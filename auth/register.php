<?php
require_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit;
    }

    // Hash the password before saving
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($check->num_rows > 0) {
        echo "Email already registered.";
        exit;
    }

    $sql = "INSERT INTO users (fullname, email, phone, password) VALUES ('$fullname', '$email', '$phone', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../register.php?register=success");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
