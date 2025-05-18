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

    if ($item_name && $quantity > 0 && $price > 0) {
        $stmt = $conn->prepare("INSERT INTO orders (user_id, item_name, quantity, price, total) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('isidd', $user_id, $item_name, $quantity, $price, $total);
        if ($stmt->execute()) {
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
