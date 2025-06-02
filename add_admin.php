<?php
include '../db.php';

// Use this script only once to create the first admin
$name = "Admin";
$password = password_hash("1234", PASSWORD_DEFAULT);
$email = "admin@admin.com";
// $full_name = "Admin";

$stmt = $conn->prepare("INSERT INTO admin (name, password, email) VALUES (?, ?, ?)");
$stmt->bind_param("ssss", $name, $password, $email);

if ($stmt->execute()) {
    echo "Admin created successfully!";
} else {
    echo "Error creating admin: " . $conn->error;
}
?>