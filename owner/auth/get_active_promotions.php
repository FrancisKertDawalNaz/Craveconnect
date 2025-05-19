<?php
// get_active_promotions.php
include '../auth/connection.php';

$sql = "SELECT name, description, discount, end_date FROM promotions WHERE status = 'active' AND start_date <= CURDATE() AND end_date >= CURDATE() ORDER BY end_date ASC LIMIT 10";
$result = $conn->query($sql);
$promotions = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $promotions[] = $row;
    }
}
$conn->close();
echo json_encode($promotions);
