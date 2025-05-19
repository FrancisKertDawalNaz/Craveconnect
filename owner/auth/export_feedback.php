<?php
include '../auth/connection.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="feedback_export.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['ID', 'User Name', 'Order ID', 'Rating', 'Comments', 'Categories', 'Created At']);

$sql = "SELECT f.id, u.fullname, f.order_id, f.rating, f.comments, f.categories, f.created_at FROM feedback f LEFT JOIN users u ON f.user_id = u.id ORDER BY f.id DESC";
$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['id'],
            $row['fullname'],
            $row['order_id'],
            $row['rating'],
            $row['comments'],
            $row['categories'],
            $row['created_at']
        ]);
    }
}
fclose($output);
exit;
