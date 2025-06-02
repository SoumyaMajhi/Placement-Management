<?php
include '../includes/db.php';
include '../includes/check_student_session.php';

$student = check_student_session();
$student_id = $_SESSION['student_id'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $issue = $_POST['issue'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO issues (student_id, issue_text, status, created_at) VALUES (?, ?, 'pending', NOW())");
    $stmt->bind_param("is", $student_id, $issue);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Issue raised successfully.";
    } else {
        $_SESSION['error_message'] = "Error raising issue: " . $conn->error;
    }

    header("Location: raise_issue.php");
    exit();
}

// Fetch all issues for this student
$stmt = $conn->prepare("SELECT id, issue_text, status, created_at, admin_response, resolved_at 
                       FROM issues 
                       WHERE student_id = ? 
                       ORDER BY created_at DESC");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$issues = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raise an Issue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .status-badge {
            font-size: 0.8rem;
            padding: 0.3rem 0.6rem;
        }

        .issue-card {
            transition: transform 0.2s;
        }

        .issue-card:hover {
            transform: translateY(-2px);
        }
    </style>
</head>

<body class="d-flex vh-100 overflow-hidden">
    <?php include '../includes/student_sidebar.php'; ?>

    <div class="flex-grow-1 overflow-auto bg-light p-4">
        <?php include '../includes/student_navbar.php'; ?>

        <div class="container mt-4">
            <!-- Success/Error Messages -->
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php
                    echo $_SESSION['success_message'];
                    unset($_SESSION['success_message']);
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php
                    echo $_SESSION['error_message'];
                    unset($_SESSION['error_message']);
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- New Issue Button -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Issues</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newIssueModal">
                    <i class="fas fa-plus-circle me-2"></i>Raise New Issue
                </button>
            </div>

            <!-- Issues List -->
            <div class="row">
                <?php foreach ($issues as $issue): ?>
                    <div class="col-12 mb-3">
                        <div class="card issue-card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title">Issue #<?php echo htmlspecialchars($issue['id']); ?></h5>
                                    <span class="status-badge badge <?php
                                                                    echo match ($issue['status']) {
                                                                        'pending' => 'bg-warning',
                                                                        'resolved' => 'bg-success',
                                                                        'withdrawn' => 'bg-secondary',
                                                                        default => 'bg-primary'
                                                                    };
                                                                    ?>">
                                        <?php echo ucfirst(htmlspecialchars($issue['status'])); ?>
                                    </span>
                                </div>
                                <p class="card-text"><?php echo nl2br(htmlspecialchars($issue['issue_text'])); ?></p>
                                <?php if ($issue['admin_response']): ?>
                                    <div class="mt-3 p-3 bg-light rounded">
                                        <strong>Admin Response:</strong><br>
                                        <?php echo nl2br(htmlspecialchars($issue['admin_response'])); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="text-muted mt-2">
                                    <small>
                                        Raised on: <?php echo date('M d, Y H:i', strtotime($issue['created_at'])); ?>
                                        <?php if ($issue['resolved_at']): ?>
                                            <br>Resolved on: <?php echo date('M d, Y H:i', strtotime($issue['resolved_at'])); ?>
                                        <?php endif; ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($issues)): ?>
                    <div class="col-12">
                        <div class="alert alert-info">
                            No issues raised yet.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- New Issue Modal -->
        <div class="modal fade" id="newIssueModal" tabindex="-1" aria-labelledby="newIssueModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newIssueModalLabel">Raise New Issue</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="raise_issue.php" method="post">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="issue" class="form-label">Describe Your Issue</label>
                                <textarea class="form-control" id="issue" name="issue" rows="4" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit Issue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>