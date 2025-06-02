<?php
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $roll_no = $_POST['roll_no']; // Get roll no
    $dob = $_POST['dob']; // Get date of birth
    $mobile_no = $_POST['mobile_no'];

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT * FROM students WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "<script>alert('Email is already registered. Please use a different email.');</script>";
    } else {
        // Prepare the insert statement
        $stmt = $conn->prepare("INSERT INTO students (name, email, password, roll_no, dob, mobile_no) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $email, $password, $roll_no, $dob, $mobile_no);
        
        if ($stmt->execute() === TRUE) {
            echo "Sign up successful! Redirecting...";
            header("Location: student_login.php");
            exit(); // Ensure script stops after redirect
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    // Close statement
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        Student Signup
                    </div>
                    <div class="card-body">
                        <form action="student_signup.php" method="post">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
                            </div>
                            <div class="mb-3">
                                <label for="roll_no" class="form-label">Roll No.</label>
                                <input type="number" class="form-control" id="roll_no" name="roll_no" placeholder="Enter your roll number" required>
                            </div>
                            <div class="mb-3">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="dob" name="dob" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" required>
                            </div>
                            <div class="mb-3">
                                <label for="mobile_no" class="form-label">Mobile No.</label>
                                <input type="number" class="form-control" id="mobile_no" name="mobile_no" placeholder="Enter your mobile number" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Create a password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <a href="student_login.php">Already have an account? Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
