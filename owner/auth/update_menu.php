<?php
// update_menu.php
session_start();
include '../../auth/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $item_name = htmlspecialchars($_POST['item_name']);
    $category = htmlspecialchars($_POST['category']);
    $price = floatval($_POST['price']);
    $description = htmlspecialchars($_POST['description']);

    $sql = "UPDATE menu_items SET item_name=?, category=?, price=?, description=?, updated_at=NOW() WHERE id=?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode(['success' => false, 'error' => $conn->error]);
        exit();
    }
    $stmt->bind_param("ssdsi", $item_name, $category, $price, $description, $id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit();
}
echo json_encode(['success' => false, 'error' => 'Invalid request']);
exit();
