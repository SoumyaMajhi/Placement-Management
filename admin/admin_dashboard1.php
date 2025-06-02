<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// $admin_id = $_SESSION['admin_id'];

// Fetch all students
$students = $conn->query("SELECT * FROM students");

// Fetch all placement drives
$placement_drives = $conn->query("SELECT * FROM placement_drives");

// Fetch all issues
$issues = $conn->query("SELECT issues.*, students.name AS student_name FROM issues JOIN students ON issues.student_id = students.id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Admin Dashboard</h2>

        <!-- Student Management Section -->
        <h3>Manage Students</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($student = $students->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $student['id']; ?></td>
                    <td><?php echo $student['name']; ?></td>
                    <td><?php echo $student['email']; ?></td>
                    <td>
                        <a href="edit_student.php?id=<?php echo $student['id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="delete_student.php?id=<?php echo $student['id']; ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Placement Drives Management Section -->
        <h3>Manage Placement Drives</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Company Name</th>
                    <th>Job Role</th>
                    <th>Apply By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($drive = $placement_drives->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $drive['id']; ?></td>
                    <td><?php echo $drive['company_name']; ?></td>
                    <td><?php echo $drive['job_role']; ?></td>
                    <td><?php echo $drive['apply_deadline']; ?></td>
                    <td>
                        <a href="edit_drive.php?id=<?php echo $drive['id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="delete_drive.php?id=<?php echo $drive['id']; ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="add_drive.php" class="btn btn-success">Add New Placement Drive</a>

        <!-- Issues Management Section -->
        <h3>Manage Issues</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Student Name</th>
                    <th>Issue</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($issue = $issues->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $issue['id']; ?></td>
                    <td><?php echo $issue['student_name']; ?></td>
                    <td><?php echo $issue['issue_text']; ?></td>
                    <td><?php echo $issue['status']; ?></td>
                    <td>
                        <?php if ($issue['status'] == 'pending') { ?>
                            <a href="resolve_issue.php?id=<?php echo $issue['id']; ?>" class="btn btn-primary">Resolve</a>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
