<?php
session_start();

function check_admin_session() {
    global $conn;
    
    // Check if admin_id exists in session
    if (!isset($_SESSION['admin_id'])) {
        header("Location: ../admin/admin_login.php");
        exit();
    }
    
    // Get admin details
    $admin_id = $_SESSION['admin_id'];
    $stmt = $conn->prepare("SELECT * FROM admin WHERE id = ?");
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        // If admin doesn't exist in database, clear session and redirect
        session_unset();
        session_destroy();
        header("Location: ../admin/admin_login.php");
        exit();
    }
    
    // Set admin data in global variable
    $admin = $result->fetch_assoc();
    return $admin;
}