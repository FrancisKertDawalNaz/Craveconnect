<?php
// get_promotion_stats.php
include '../auth/connection.php';

// Count active promotions
$sql = "SELECT COUNT(*) as total FROM promotions WHERE status = 'active' AND start_date <= CURDATE() AND end_date >= CURDATE()";
$result = $conn->query($sql);
$active_promotions = 0;
if ($result && $row = $result->fetch_assoc()) {
    $active_promotions = (int)$row['total'];
}

// Count loyalty members (assuming a 'users' table with a 'loyalty_member' column)
$sql = "SELECT COUNT(*) as total FROM users WHERE loyalty_member = 1";
$result = $conn->query($sql);
$loyalty_members = 0;
if ($result && $row = $result->fetch_assoc()) {
    $loyalty_members = (int)$row['total'];
}

// Points redeemed (assuming an 'orders' table with a 'points_redeemed' column)
$sql = "SELECT SUM(points_redeemed) as total FROM orders WHERE points_redeemed IS NOT NULL";
$result = $conn->query($sql);
$points_redeemed = 0;
if ($result && $row = $result->fetch_assoc()) {
    $points_redeemed = (int)$row['total'];
}

// Total discounts (assuming an 'orders' table with a 'discount_amount' column)
$sql = "SELECT SUM(discount_amount) as total FROM orders WHERE discount_amount IS NOT NULL";
$result = $conn->query($sql);
$total_discounts = 0;
if ($result && $row = $result->fetch_assoc()) {
    $total_discounts = (float)$row['total'];
}

$conn->close();

echo json_encode([
    'active_promotions' => $active_promotions,
    'loyalty_members' => $loyalty_members,
    'points_redeemed' => $points_redeemed,
    'total_discounts' => $total_discounts
]);
