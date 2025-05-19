<?php
// delete_menu.php
session_start();
include '../../auth/connection.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM menu_items WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        $_SESSION['menu_error'] = "Database error: " . $conn->error;
        header("Location: ../restaurant-menu.php");
        exit();
    }
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['menu_item_deleted'] = true;
    } else {
        $_SESSION['menu_error'] = "Error deleting menu item: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
    header("Location: ../restaurant-menu.php");
    exit();
}
$_SESSION['menu_error'] = "Invalid request.";
header("Location: ../restaurant-menu.php");
exit();
