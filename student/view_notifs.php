<?php
include '../includes/db.php';
include '../includes/check_student_session.php';

$student = check_student_session();

// Fetch notifications for this student
$query = "SELECT n.*, a.name 
          FROM notifications n 
          LEFT JOIN admin a ON n.admin_id = a.id 
          WHERE n.recipient_id = ? 
          OR n.recipient_id IS NULL 
          ORDER BY n.created_at DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Notifications</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        .notification {
            border-left: 4px solid #007bff;
            margin-bottom: 15px;
        }

        .notification-time {
            color: #6c757d;
            font-size: 0.875rem;
        }

        .notification-sender {
            font-weight: bold;
            color: #495057;
        }
    </style>
</head>

<body class="d-flex vh-100 overflow-hidden">
    <?php include '../includes/student_sidebar.php'; ?>

    <div class="flex-grow-1 overflow-auto bg-light p-4">
        <?php include '../includes/student_navbar.php'; ?>
        <div class="container py-5">
            <h2 class="mb-4">My Notifications</h2>

            <?php if ($result->num_rows > 0): ?>
                <div class="notifications-container">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="notification card p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="notification-sender">
                                    From: <?php echo htmlspecialchars($row['name']); ?>
                                </span>
                                <span class="notification-time">
                                    <?php echo date('M d, Y h:i A', strtotime($row['created_at'])); ?>
                                </span>
                            </div>
                            <div class="notification-subject mb-2">
                                <strong><?php echo htmlspecialchars($row['subject']); ?></strong>
                            </div>
                            <div class="notification-message">
                                <?php echo nl2br(htmlspecialchars($row['message'])); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    No notifications found.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
$stmt->close();
$conn->close();
?>
