<?php
include '../includes/db.php';
include '../includes/check_student_session.php';

// Check if the student is logged in
// This will handle the session check and set $student variable
$student = check_student_session();

$student_id = $_SESSION['student_id'];
$applied_drive_ids = [];
$message = '';
$applied = false;

// Fetch student details
$result = $conn->query("SELECT * FROM students WHERE id='$student_id'");
$student = $result->fetch_assoc();

// Fetch applied drives
$applied_drives = $conn->query("SELECT drive_id FROM applications WHERE student_id='$student_id'");
while ($row = $applied_drives->fetch_assoc()) {
    $applied_drive_ids[] = $row['drive_id'];
}

// Fetch available placement drives
$placement_drives = $conn->query("SELECT * FROM placement_drives");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $drive_id = $_POST['drive_id'];
    if (in_array($drive_id, $applied_drive_ids)) {
        // Withdraw application
        $sql = "DELETE FROM applications WHERE student_id='$student_id' AND drive_id='$drive_id'";
        $message = ($conn->query($sql) === TRUE) ? "Successfully withdrawn from the placement drive." : "Error withdrawing: " . $conn->error;
        $applied = false;
    } else {
        // Apply for the drive
        $sql = "INSERT INTO applications (student_id, drive_id) VALUES ('$student_id', '$drive_id')";
        $message = ($conn->query($sql) === TRUE) ? "Successfully applied for the placement drive." : "Error applying: " . $conn->error;
        $applied = true;
    }

    // Redirect after showing message
?>
    <script>
        setTimeout(function() {
            window.location.href = '<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>';
        }, 3000); // 3 seconds delay
    </script>
<?php
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Placement Drives</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="d-flex vh-100 overflow-hidden">
    <?php include '../includes/student_sidebar.php'; ?>
    <div class="content flex-grow-1 overflow-auto bg-light p-4">
        <?php include '../includes/student_navbar.php'; ?>

        <div class="container mt-5">
            <h2>Available Placement Drives</h2>

            <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo $applied ? 'success' : 'info'; ?> alert-dismissible alert-fade" role="alert">
                    <?php echo htmlspecialchars($message); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

            <?php endif; ?>

            <?php if ($placement_drives && $placement_drives->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
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
                            <?php while ($drive = $placement_drives->fetch_assoc()):
                                $drive_id = $drive['id'];
                                $is_applied = in_array($drive_id, $applied_drive_ids);
                                $deadline_passed = strtotime($drive['apply_deadline']) < time();
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($drive['company_name']); ?></td>
                                    <td><?php echo htmlspecialchars($drive['job_role']); ?></td>
                                    <td><?php echo htmlspecialchars($drive['eligibility_criteria']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($drive['apply_deadline'])); ?></td>
                                    <td>
                                        <?php if (!$deadline_passed): ?>
                                            <button class="btn btn-<?php echo $is_applied ? 'danger' : 'primary'; ?>"
                                                data-bs-target="#applyModal<?php echo $drive_id; ?>"
                                                data-bs-toggle="modal">
                                                <?php echo $is_applied ? 'Withdraw' : 'Apply'; ?>
                                            </button>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Deadline Passed</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="applyModal<?php echo $drive_id; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    <?php echo $is_applied ? 'Withdraw Application' : 'Apply for Placement Drive'; ?>
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to <?php echo $is_applied ? 'withdraw from' : 'apply for'; ?>
                                                    the placement drive at <?php echo htmlspecialchars($drive['company_name']); ?>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="post" class="d-inline">
                                                    <input type="hidden" name="drive_id" value="<?php echo $drive_id; ?>">
                                                    <button type="submit" class="btn btn-<?php echo $is_applied ? 'danger' : 'primary'; ?>">
                                                        <?php echo $is_applied ? 'Yes, Withdraw' : 'Yes, Apply'; ?>
                                                    </button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

            <?php else: ?>
                <div class="alert alert-info">
                    No placement drives are currently available.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>