<?php
session_start();
// session_unset();
// session_destroy();
// header("Location: ../index.php");
// exit();


// Handle Logout for Admin
if (isset($_GET['logout']) && $_GET['logout'] == 'admin') {
    unset($_SESSION['admin_id']); // Clear only the admin session variable
    header("Location: ../index.php"); // Redirect to login page
    exit();
}

// Handle Logout for Student
if (isset($_GET['logout']) && $_GET['logout'] == 'student') {
    unset($_SESSION['student_id']); // Clear only the student session variable
    header("Location: ../index.php"); // Redirect to login page
    exit();
}
?>


