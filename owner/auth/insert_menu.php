<?php
session_start();
include '../../auth/connection.php';

// Validate form submission
if (!isset($_POST['item_name']) || !isset($_POST['category']) || !isset($_POST['price'])) {
    $_SESSION['menu_error'] = "All required fields must be filled out.";
    header("Location: ../restaurant-menu.php");
    exit();
}

$item_name = htmlspecialchars($_POST['item_name']);
$category = htmlspecialchars($_POST['category']);
$description = htmlspecialchars($_POST['description']);
$price = floatval($_POST['price']);

$image_path = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $target_dir = "../uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $image_name = basename($_FILES["image"]["name"]);
    $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    $max_size = 10 * 1024 * 1024; // 10MB

    if (!in_array($image_ext, $allowed_types)) {
        $_SESSION['menu_error'] = "Invalid file type. Only JPG, JPEG, PNG & GIF allowed.";
        header("Location: ../restaurant-menu.php");
        exit();
    }
    if ($_FILES["image"]["size"] > $max_size) {
        $_SESSION['menu_error'] = "File is too large. Maximum size is 10MB.";
        header("Location: ../restaurant-menu.php");
        exit();
    }

    $unique_name = uniqid() . "." . $image_ext;
    $target_file = $target_dir . $unique_name;

    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $_SESSION['menu_error'] = "Failed to upload image.";
        header("Location: ../restaurant-menu.php");
        exit();
    }
    // Save only the filename in the database
    $image_path = $unique_name;
}

$sql = "INSERT INTO menu_items (item_name, category, description, price, image_url) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    $_SESSION['menu_error'] = "Database error: " . $conn->error;
    header("Location: ../restaurant-menu.php");
    exit();
}
$stmt->bind_param("sssds", $item_name, $category, $description, $price, $image_path);
if ($stmt->execute()) {
    $_SESSION['menu_item_added'] = true;
} else {
    $_SESSION['menu_error'] = "Error adding menu item: " . $stmt->error;
}
$stmt->close();
$conn->close();
header("Location: ../restaurant-menu.php");
exit();
?>
