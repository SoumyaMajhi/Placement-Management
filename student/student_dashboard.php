<?php 
include '../includes/db.php';
include '../includes/check_student_session.php';

$student = check_student_session();

// Fetch applied drives
$applied_drives_query = "
    SELECT pd.*, a.apply_date, a.status
    FROM applications a
    JOIN placement_drives pd ON a.drive_id = pd.id
    WHERE a.student_id = ?
    ORDER BY a.apply_date DESC
";

$stmt = $conn->prepare($applied_drives_query);
$stmt->bind_param("i", $student['id']);
$stmt->execute();
$applied_drives = $stmt->get_result();

// Determine the latest degree, specialization, and year of passing
$latest_degree = '';
$latest_specialization = '';
$latest_year = '';

if (!empty($student['pg_degree']) && !empty($student['pg_specialization']) && !empty($student['pg_year'])) {
    $latest_degree = htmlspecialchars($student['pg_degree']);
    $latest_specialization = htmlspecialchars($student['pg_specialization']);
    $latest_year = htmlspecialchars($student['pg_year']);
} elseif (!empty($student['ug_degree']) && !empty($student['ug_specialization']) && !empty($student['ug_year'])) {
    $latest_degree = htmlspecialchars($student['ug_degree']);
    $latest_specialization = htmlspecialchars($student['ug_specialization']);
    $latest_year = htmlspecialchars($student['ug_year']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body class="d-flex vh-100 overflow-hidden">
    <?php include '../includes/student_sidebar.php'; ?>
    
    <div class="flex-grow-1 overflow-auto bg-light p-4">
        <?php include '../includes/student_navbar.php'; ?>
        
        <div class="container py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-user-circle fs-1 text-primary me-3"></i>
                                <div>
                                    <h2 class="mb-0">Welcome, <?php echo htmlspecialchars($student['name']); ?></h2>
                                    
                                    <p class="text-muted mb-0"><?php 
                                        if (!empty($latest_degree) && !empty($latest_specialization) && !empty($latest_year)) {
                                            echo "$latest_degree in $latest_specialization (Batch of $latest_year)";
                                        } else {
                                            echo "Degree information not available.";
                                        }
                                        ?>
                                        </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
                                    <p class="mb-1"><strong>Mobile No:</strong> <?php echo htmlspecialchars($student['mobile_no']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card shadow-sm">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="h5 mb-0">
                                    <i class="fas fa-briefcase me-2 text-primary"></i>
                                    Your Applied Drives
                                </h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if ($applied_drives->num_rows > 0) { ?>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">Company Name</th>
                                                <th scope="col">Job Role</th>
                                                <th scope="col">Eligibility</th>
                                                <th scope="col">Applied On</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($drive = $applied_drives->fetch_assoc()) { ?>
                                                <tr>
                                                    <td>
                                                        <div class="fw-semibold"><?php echo htmlspecialchars($drive['company_name']); ?></div>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($drive['job_role']); ?></td>
                                                    <td>
                                                        <small class="text-muted">
                                                            <?php echo htmlspecialchars($drive['eligibility_criteria']); ?>
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">
                                                            <?php echo date('M d, Y', strtotime($drive['apply_date'])); ?>
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <span class="badge rounded-pill <?php 
                                                            echo match($drive['status']) {
                                                                'Applied' => 'bg-primary',
                                                                'Selected' => 'bg-success',
                                                                'Rejected' => 'bg-danger',
                                                                default => 'bg-info'
                                                            };
                                                        ?>">
                                                            <?php echo htmlspecialchars($drive['status']); ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } else { ?>
                                <div class="text-center py-5">
                                    <i class="fas fa-clipboard-list fs-1 text-muted mb-3"></i>
                                    <h5>No Applications Yet</h5>
                                    <p class="text-muted mb-0">You haven't applied to any placement drives yet.</p>
                                    <a href="apply_placements.php" class="btn btn-primary mt-3">
                                        <i class="fas fa-search me-2"></i>Browse Available Drives
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>