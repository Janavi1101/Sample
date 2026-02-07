<?php
include 'fetch_plants.php'; // Assumes you have a file for DB connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if user already exists
    $check_user = mysqli_query($conn, "SELECT * FROM customers WHERE email = '$email'");
    if (mysqli_num_rows($check_user) > 0) {
        echo "<script>alert('User already exists. Please login.'); window.location='login.html';</script>";
    } else {
        $query = "INSERT INTO customers (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$password')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Registration successful!'); window.location='login.html';</script>";
        } else {
            echo "<script>alert('Error occurred during registration.'); window.location='register.html';</script>";
        }
    }
}
?>
