//before student_signup.php
<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO students (name, email, password) VALUES ('$name', '$email', '$password')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: student_login.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>


//before student_dashboard.php

<?php
session_start();
include 'db.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$result = $conn->query("SELECT * FROM students WHERE id='$student_id'");
if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
    //echo "Welcome, " . htmlspecialchars($student['name']) . "!";

} else {
    echo "Student not found!";
}

$placement_drives = $conn->query("SELECT * FROM placement_drives");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Welcome, <?php echo $student['name']; ?></h2>
        <h3>Profile Details</h3>
        <p>Email: <?php echo $student['email']; ?></p>
        <p>Profile Details: <?php echo $student['profile_details']; ?></p>

        <h3>Available Placement Drives</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Company Name</th>
                    <th>Job Role</th>
                    <th>Eligibility</th>
                    <th>Apply By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($drive = $placement_drives->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $drive['company_name']; ?></td>
                    <td><?php echo $drive['job_role']; ?></td>
                    <td><?php echo $drive['eligibility_criteria']; ?></td>
                    <td><?php echo $drive['apply_deadline']; ?></td>
                    <td><a href="apply_drive.php?drive_id=<?php echo $drive['id']; ?>" class="btn btn-primary">Apply</a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>



//student dashboard 2

<?php
session_start();
include 'db.php';

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$result = $conn->query("SELECT * FROM students WHERE id='$student_id'");
if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
} else {
    echo "Student not found!";
}

// Fetch placement drives
$placement_drives = $conn->query("SELECT * FROM placement_drives");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        .sidebar {
            min-width: 250px;
            background-color: #343a40;
            color: white;
            padding: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            margin: 15px 0;
        }
        .sidebar a:hover {
            background-color: #495057;
            border-radius: 5px;
        }
        .content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }
        .navbar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>Student Dashboard</h3>
        <a href="student_dashboard.php">Home</a>
        <a href="profile_update.php">Profile Update</a>
        <a href="placement_drives.php">Available Placement Drives</a>
        <a href="issue_raise.php">Issue Raise</a>
    </div>

    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">College Placement System</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="view_notifs.php"><i class="fas fa-bell"></i> Notifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Sign Out</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container mt-4">
            <h2>Welcome, <?php echo htmlspecialchars($student['name']); ?></h2>
            <h3>Your Profile Details</h3>
            <p>Email: <?php echo htmlspecialchars($student['email']); ?></p>
            <p>Profile Details: <?php echo htmlspecialchars($student['profile_details']); ?></p>

            <h3>Available Placement Drives</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Job Role</th>
                        <th>Eligibility</th>
                        <th>Apply By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($drive = $placement_drives->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($drive['company_name']); ?></td>
                        <td><?php echo htmlspecialchars($drive['job_role']); ?></td>
                        <td><?php echo htmlspecialchars($drive['eligibility_criteria']); ?></td>
                        <td><?php echo htmlspecialchars($drive['apply_deadline']); ?></td>
                        <td>
                            <a href="apply_drive.php?drive_id=<?php echo $drive['id']; ?>" class="btn btn-primary">Apply</a>
                            <a href="withdraw_drive.php?drive_id=<?php echo $drive['id']; ?>" class="btn btn-danger">Withdraw</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

