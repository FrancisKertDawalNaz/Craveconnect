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
    $points = isset($_POST['points']) ? intval($_POST['points']) : 0;

    // Basic validation
    if ($name === '' || $discount < 0 || $discount > 100 || $start_date === '' || $end_date === '' || $points < 0) {
        echo json_encode(['success' => false, 'message' => 'Please fill all required fields correctly.']);
        exit;
    }

    // Check if 'points' column exists in promotions table
    $colCheck = $conn->query("SHOW COLUMNS FROM promotions LIKE 'points'");
    if (!$colCheck || $colCheck->num_rows === 0) {
        echo json_encode([
            'success' => false,
            'message' => "The 'points' column is missing from the promotions table. Please add it using: ALTER TABLE promotions ADD COLUMN points INT DEFAULT 0;"
        ]);
        exit;
    }

    $sql = "INSERT INTO promotions (name, description, discount, status, start_date, end_date, points) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('ssdsssi', $name, $description, $discount, $status, $start_date, $end_date, $points);
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
