<?php
$servername = "sql108.infinityfree.com";
$username = "if0_36978352";
$password = "ntnypgZ0nuE";
$dbname = "if0_36978352_placement_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
