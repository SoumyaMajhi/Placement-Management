<?php
include 'db.php';

$drive_id = $_GET['id'];

$sql = "DELETE FROM placement_drives WHERE id='$drive_id'";

if ($conn->query($sql) === TRUE) {
    header("Location: admin_dashboard.php");
} else {
    echo "Error deleting drive: " . $conn->error;
}

$conn->close();
?>
