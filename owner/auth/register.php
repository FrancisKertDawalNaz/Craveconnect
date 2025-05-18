<?php
include '../../auth/connection.php'; 

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
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Password Mismatch',
                    text: 'Passwords do not match!'
                }).then(() => { history.back(); });
              </script>";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check_email = mysqli_query($conn, "SELECT * FROM restaurant_owners WHERE email='$email'");
    if (mysqli_num_rows($check_email) > 0) {
        echo "<script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Email Already Used',
                    text: 'This email is already registered.'
                }).then(() => { history.back(); });
              </script>";
        exit();
    }

    $insert = "INSERT INTO restaurant_owners (fullname, email, phone, restaurant_name, restaurant_address, cuisine_type, password)
               VALUES ('$fullname', '$email', '$phone', '$restaurant_name', '$restaurant_address', '$cuisine_type', '$hashed_password')";

    if (mysqli_query($conn, $insert)) {
        header("Location: ../restaurant-login.php?registered=1");
        exit();
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Database Error',
                    text: 'Something went wrong. Please try again.'
                }).then(() => { history.back(); });
              </script>";
    }
}
?>
