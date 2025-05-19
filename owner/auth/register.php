<?php
include '../../auth/connection.php'; 
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $restaurant_name = mysqli_real_escape_string($conn, $_POST['restaurant_name']);
    $restaurant_address = mysqli_real_escape_string($conn, $_POST['restaurant_address']);
    $cuisine_type = mysqli_real_escape_string($conn, $_POST['cuisine_type']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $_SESSION['register_error'] = 'Passwords do not match!';
        header('Location: ../restaurant-register.php?error=1');
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check_email = mysqli_query($conn, "SELECT * FROM restaurant_owners WHERE email='$email'");
    if (mysqli_num_rows($check_email) > 0) {
        $_SESSION['register_error'] = 'This email is already registered.';
        header('Location: ../restaurant-register.php?error=1');
        exit();
    }

    $insert = "INSERT INTO restaurant_owners (fullname, email, phone, restaurant_name, restaurant_address, cuisine_type, password)
               VALUES ('$fullname', '$email', '$phone', '$restaurant_name', '$restaurant_address', '$cuisine_type', '$hashed_password')";

    if (mysqli_query($conn, $insert)) {
        header("Location: ../restaurant-login.php?registered=1");
        exit();
    } else {
        $error = mysqli_error($conn);
        $_SESSION['register_error'] = 'Something went wrong. Error: ' . $error;
        header('Location: ../restaurant-register.php?error=1');
        exit();
    }
}
?>
