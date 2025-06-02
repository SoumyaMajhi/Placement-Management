<?php
session_start();

function check_student_session() {
    global $conn, $student;
    
    // Check if student_id exists in session
    if (!isset($_SESSION['student_id'])) {
        header("Location: ../student/student_login.php");
        exit();
    }
    
    // Get student details
    $student_id = $_SESSION['student_id'];
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        // If student doesn't exist in database, clear session and redirect
        session_unset();
        session_destroy();
        header("Location: ../student/student_login.php");
        exit();
    }
    
    // Set student data in global variable
    $student = $result->fetch_assoc();
    return $student;
}