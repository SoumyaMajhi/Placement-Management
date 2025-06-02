<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.html");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $announcement_text = $_POST['announcement_text'];

    $sql = "INSERT INTO announcements (announcement_text, created_at) VALUES ('$announcement_text', NOW())";

    if ($conn->query($sql) === TRUE) {
        $message = "Announcement created!";
    } else {
        $message = "Error creating announcement: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Announcement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Create Announcement</h2>
        <?php if (isset($message)) { ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php } ?>
        <form action="create_announcement.php" method="post">
            <div class="mb-3">
                <label for="announcement_text" class="form-label">Announcement Text</label>
                <textarea class="form-control" id="announcement_text" name="announcement_text" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Announcement</button>
        </form>
    </div>
</body>
</html>



<!-- to student dashboard -->
<?php
// Fetch announcements
$announcement_sql = "SELECT announcement_text, created_at FROM announcements ORDER BY created_at DESC";
$announcement_result = $conn->query($announcement_sql);
?>

<div class="container mt-5">
    <h2>Latest Announcements</h2>
    <?php while($announcement = $announcement_result->fetch_assoc()) { ?>
        <div class="alert alert-secondary">
            <strong><?php echo date('d M Y', strtotime($announcement['created_at'])); ?>:</strong> 
            <?php echo $announcement['announcement_text']; ?>
        </div>
    <?php } ?>
</div>
