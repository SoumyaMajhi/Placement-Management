<?php
include '../includes/db.php';
include '../includes/check_admin_session.php';

$admin = check_admin_session();

// Fetch applied drives
// $drives_query = "
//     SELECT * FROM placement_drives as p
//     ORDER BY p.apply_deadline DESC
// ";

// Fetch drives with status calculated based on the deadline
$drives_query = "
    SELECT 
        company_name,
        job_role,
        eligibility_criteria,
        apply_deadline,
        CASE 
            WHEN is_cancelled = 1 THEN 'Cancelled'
            WHEN apply_deadline < CURDATE() THEN 'Deadline Passed'
            ELSE 'Ongoing'
        END AS status
    FROM placement_drives
    ORDER BY apply_deadline DESC
";

$stmt = $conn->prepare($drives_query);
$stmt->execute();
$drives = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body class="d-flex vh-100 overflow-hidden">
    <?php include '../includes/admin_sidebar.php'; ?>

    <div class="flex-grow-1 overflow-auto bg-light p-4">
        <?php include '../includes/admin_navbar.php'; ?>

        <div class="container py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fa-solid fa-user-tie fs-1 text-primary me-3"></i>
                                <!-- <i class="fas fa-user-circle fs-1 text-primary me-3"></i> -->
                                <div>
                                    <h2 class="mb-0">Welcome, <?php echo htmlspecialchars($admin['name']); ?></h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Email:</strong> <?php echo htmlspecialchars($admin['email']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="h5 mb-0">
                                    <i class="fas fa-briefcase me-2 text-primary"></i>
                                    Placement Drives Status
                                </h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if ($drives->num_rows > 0) { ?>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">Company Name</th>
                                                <th scope="col">Job Role</th>
                                                <th scope="col">Eligibility</th>
                                                <th scope="col">Apply Deadline</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($drive = $drives->fetch_assoc()) { ?>
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
                                                            <?php echo date('M d, Y', strtotime($drive['apply_deadline'])); ?>
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <span class="badge rounded-pill <?php
                                                                                        echo match ($drive['status']) {
                                                                                            'Ongoing' => 'bg-primary',
                                                                                            'Deadline Passed' => 'bg-secondary',
                                                                                            'Cancelled' => 'bg-danger',
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
                                    <a href="placements.php" class="btn btn-primary mt-3">
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