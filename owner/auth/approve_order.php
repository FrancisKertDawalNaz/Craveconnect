<?php
include_once '../../auth/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
    if ($orderId > 0) {
        $sql = "UPDATE orders SET order_status = 'Approved' WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $orderId);
            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(['success' => true]);
                exit;
            }
        }
    }
}
echo json_encode(['success' => false]);
exit;
