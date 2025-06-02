<?php
include 'db.php';

$issue_id = $_GET['id'];

$sql = "UPDATE issues SET status='resolved' WHERE id='$issue_id'";

if ($conn->query($sql) === TRUE) {
    header("Location: admin_dashboard.php");
} else {
    echo "Error resolving issue: " . $conn->error;
}

$conn->close();
?>
