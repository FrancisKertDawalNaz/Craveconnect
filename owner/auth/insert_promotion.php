<?php
// insert_promotion.php
include '../auth/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $discount = floatval($_POST['discount'] ?? 0);
    $status = $_POST['status'] ?? 'inactive';
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';

    // Basic validation
    if ($name === '' || $discount < 0 || $discount > 100 || $start_date === '' || $end_date === '') {
        echo json_encode(['success' => false, 'message' => 'Please fill all required fields correctly.']);
        exit;
    }

    $sql = "INSERT INTO promotions (name, description, discount, status, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('ssdsss', $name, $description, $discount, $status, $start_date, $end_date);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Promotion created successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    }
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
