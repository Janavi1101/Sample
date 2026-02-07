<?php
session_start();
include 'fetch_plants.php'; // This should connect to your MySQL database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate
    if (empty($email) || empty($password)) {
        echo "<script>alert('Please fill in all fields.'); window.location.href='login.html';</script>";
        exit();
    }

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM customers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // For production, use password hashing
        if ($user['password'] === $password) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            // Redirect to previously selected plant or homepage
            if (isset($_SESSION['plant_id'])) {
                $plant_id = $_SESSION['plant_id'];
                unset($_SESSION['plant_id']);
                header("Location: plant_details.php?id=$plant_id");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            echo "<script>alert('Invalid password.'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('User not found.'); window.location.href='login.html';</script>";
    }
}
?>
