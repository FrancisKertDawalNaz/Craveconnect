<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

require_once '../auth/connection.php';
$userId = $_SESSION['user_id'];

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
$fullname = trim($data['fullname'] ?? '');
$email = trim($data['email'] ?? '');
$phone = trim($data['phone'] ?? '');

if ($fullname === '' || $email === '' || $phone === '') {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit();
}

// Check if email is used by another user
$sql = "SELECT id FROM users WHERE email = ? AND id != ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $email, $userId);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Email is already in use by another account.']);
    $stmt->close();
    exit();
}
$stmt->close();

// Update user info
$sql = "UPDATE users SET fullname = ?, email = ?, phone = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssi', $fullname, $email, $phone, $userId);
if ($stmt->execute()) {
    $_SESSION['fullname'] = $fullname;
    echo json_encode(['success' => true, 'message' => 'Profile updated successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update profile.']);
}
$stmt->close();
$conn->close();
