<?php
// insert_order.php
require_once 'connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $item_name = $_POST['item_name'] ?? '';
    $quantity = intval($_POST['quantity'] ?? 1);
    $price = floatval($_POST['price'] ?? 0);
    $total = $price * $quantity;
    $order_type = $_POST['order_type'] ?? 'Pickup';

    if ($item_name && $quantity > 0 && $price > 0) {
        $stmt = $conn->prepare("INSERT INTO orders (user_id, item_name, quantity, price, total, order_type) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('isidds', $user_id, $item_name, $quantity, $price, $total, $order_type);
        if ($stmt->execute()) {
            // Award points: 10 points per order (or you can use floor($total) for 1 point per peso/dollar)
            $points = 10;
            $conn->query("UPDATE users SET points = points + $points WHERE id = $user_id");
            // Log to points_history
            $order_id = $stmt->insert_id;
            $ph_stmt = $conn->prepare("INSERT INTO points_history (user_id, type, reference, points) VALUES (?, 'earn', ?, ?)");
            $reference = 'Order #' . $order_id;
            $ph_stmt->bind_param('isi', $user_id, $reference, $points);
            $ph_stmt->execute();
            $ph_stmt->close();
            echo json_encode(['success' => true, 'message' => 'Order placed successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
