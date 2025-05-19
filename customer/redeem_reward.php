<?php
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in.']);
    exit;
}
require_once '../auth/connection.php';
$userId = $_SESSION['user_id'];
$points = intval($_POST['points'] ?? 0);
$rewardName = trim($_POST['reward_name'] ?? '');
if ($points <= 0 || $rewardName === '') {
    echo json_encode(['success' => false, 'message' => 'Invalid reward.']);
    exit;
}
// Get current points
$res = $conn->query("SELECT points FROM users WHERE id = $userId");
if (!$res || !($row = $res->fetch_assoc())) {
    echo json_encode(['success' => false, 'message' => 'User not found.']);
    exit;
}
$currentPoints = (int)$row['points'];
if ($currentPoints < $points) {
    echo json_encode(['success' => false, 'message' => 'Not enough points.']);
    exit;
}
// Deduct points
$newPoints = $currentPoints - $points;
$update = $conn->query("UPDATE users SET points = $newPoints WHERE id = $userId");
if ($update) {
    // Optionally, log redemption in a table
    $stmt = $conn->prepare("INSERT INTO points_history (user_id, type, reference, points, created_at) VALUES (?, 'redeem', ?, ?, NOW())");
    $stmt->bind_param('isi', $userId, $rewardName, $points);
    $stmt->execute();
    $stmt->close();
    // Delete the redeemed reward from promotions
    $del = $conn->prepare("DELETE FROM promotions WHERE name = ? AND points = ? LIMIT 1");
    $del->bind_param('si', $rewardName, $points);
    $del->execute();
    $del->close();
    echo json_encode(['success' => true, 'message' => 'Reward redeemed!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to redeem reward.']);
}
$conn->close();
