<?php
session_start();
include '../../auth/connection.php';

// Validate form submission
if (!isset($_POST['item_name']) || !isset($_POST['sku']) || !isset($_POST['category']) || !isset($_POST['unit']) || !isset($_POST['current_stock']) || !isset($_POST['min_stock']) || !isset($_POST['reorder_point']) || !isset($_POST['unit_cost'])) {
    $_SESSION['inventory_error'] = "All required fields must be filled out.";
    header("Location: ../restaurant-inventory.php");
    exit();
}

$item_name = htmlspecialchars($_POST['item_name']);
$sku = htmlspecialchars($_POST['sku']);
$category = htmlspecialchars($_POST['category']);
$unit = htmlspecialchars($_POST['unit']);
$current_stock = floatval($_POST['current_stock']);
$min_stock = floatval($_POST['min_stock']);
$reorder_point = floatval($_POST['reorder_point']);
$unit_cost = floatval($_POST['unit_cost']);
$supplier = isset($_POST['supplier']) ? htmlspecialchars($_POST['supplier']) : null;
$description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : null;
$location = isset($_POST['location']) ? htmlspecialchars($_POST['location']) : null;

$image_path = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $target_dir = "../uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $image_name = basename($_FILES["image"]["name"]);
    $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    $max_size = 5 * 1024 * 1024; // 5MB
    if (!in_array($image_ext, $allowed_types)) {
        $_SESSION['inventory_error'] = "Invalid file type. Only JPG, JPEG, PNG & GIF allowed.";
        header("Location: ../restaurant-inventory.php");
        exit();
    }
    if ($_FILES["image"]["size"] > $max_size) {
        $_SESSION['inventory_error'] = "File is too large. Maximum size is 5MB.";
        header("Location: ../restaurant-inventory.php");
        exit();
    }
    $unique_name = uniqid() . "." . $image_ext;
    $target_file = $target_dir . $unique_name;
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $_SESSION['inventory_error'] = "Failed to upload image.";
        header("Location: ../restaurant-inventory.php");
        exit();
    }
    $image_path = $unique_name;
}

$sql = "INSERT INTO inventory_items (item_name, sku, category, unit, current_stock, min_stock, reorder_point, unit_cost, supplier, description, location, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    $_SESSION['inventory_error'] = "Database error: " . $conn->error;
    header("Location: ../restaurant-inventory.php");
    exit();
}
$stmt->bind_param("ssssdddsssss", $item_name, $sku, $category, $unit, $current_stock, $min_stock, $reorder_point, $unit_cost, $supplier, $description, $location, $image_path);
if ($stmt->execute()) {
    $_SESSION['inventory_item_added'] = true;
} else {
    $_SESSION['inventory_error'] = "Error adding inventory item: " . $stmt->error;
}
$stmt->close();
$conn->close();
header("Location: ../restaurant-inventory.php");
exit();
?>
