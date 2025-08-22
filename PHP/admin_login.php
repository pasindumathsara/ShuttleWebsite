<?php
session_start();

// Admin credentials (can be stored in a database for production)
$admin_username = "admin";
$admin_password = "admin123";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['admin_username'];
    $password = $_POST['admin_password'];

    // Simple username/password check (replace with database check for production)
    if ($username == $admin_username && $password == $admin_password) {
        $_SESSION['admin_id'] = 1; // set admin session ID
        header("Location: ../adminprofile.html"); // Redirect to admin page
        exit();
    } else {
        echo "<script>
                alert('Invalid login credentials.');
                window.location.href = 'adminlogin.html';
              </script>";
    }
}
?>
