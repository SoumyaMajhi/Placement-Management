<?php
session_start();
include 'db.php';

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.html");
    exit();
}

$student_id = $_SESSION['student_id'];
$drive_id = $_GET['drive_id'];

// Withdraw application
$sql = "DELETE FROM applications WHERE student_id='$student_id' AND drive_id='$drive_id'";

if ($conn->query($sql) === TRUE) {
    echo "Successfully withdrawn from the placement drive.";
} else {
    echo "Error withdrawing: " . $conn->error;
}
?>
