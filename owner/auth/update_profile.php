<?php
session_start();
include '../auth/connection.php';

if (!isset($_SESSION['owner_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in.']);
    exit;
}
$owner_id = $_SESSION['owner_id'];

// Accept JSON input or fallback to POST
if (stripos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') === 0) {
    $data = json_decode(file_get_contents('php://input'), true);
    $fullname = trim($data['fullname'] ?? '');
    $email = trim($data['email'] ?? '');
    $phone = trim($data['phone'] ?? '');
} else {
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
}

if ($fullname === '' || $email === '' || $phone === '') {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

// Check if email is used by another owner
$sql = "SELECT id FROM restaurant_owners WHERE email = ? AND id != ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $email, $owner_id);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Email is already in use by another account.']);
    $stmt->close();
    exit;
}
$stmt->close();

// Update owner info
$sql = "UPDATE restaurant_owners SET fullname=?, email=?, phone=? WHERE id=?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param('sssi', $fullname, $email, $phone, $owner_id);
    if ($stmt->execute()) {
        $_SESSION['owner_name'] = $fullname;
        echo json_encode(['success' => true, 'message' => 'Profile updated successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
}
$conn->close();
