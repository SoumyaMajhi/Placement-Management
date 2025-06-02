<?php
// session_start();
// include '../includes/db.php';

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.html");
    exit();
}

$student_id = $_SESSION['student_id'];
$drive_id = $_POST['drive_id'];
$applied = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Save application
    $sql = "INSERT INTO applications (student_id, drive_id) VALUES ('$student_id', '$drive_id')";

    if ($conn->query($sql) === TRUE) {
        $applied = true;
    } else {
        $error_message = "Error applying: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Placement Drive</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Modal trigger -->
    <!-- <button class="btn btn-primary" data-bs-target="#applyModal1" data-bs-toggle="modal">Open first modal</button> -->

    <!-- bootstrap modal -->
    <div class="modal fade" id="applyModal1" aria-hidden="true" aria-labelledby="applyModalLabel1" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="applyModalLabel1">Apply for Placement Drive</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to apply for this drive?</p>
                </div>
                <div class="modal-footer">
                    <form method="post" action="apply_drive.php?drive_id=<?php echo $drive_id; ?>">
                        <button type="submit" class="btn btn-primary" data-bs-target="#applyModal2" data-bs-toggle="modal">Yes</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="applyModal2" aria-hidden="true" aria-labelledby="applyModalLabel2" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="applyModalLabel2">
                    <?php if ($applied==true){
                        echo "Successfully Applied!";
                        }else{
                            echo "Error";
                        }?>
                        </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <p><?php if ($applied==true){
                        echo "Successfully applied for the placement drive.";
                        }else{
                            echo $error_message;
                        }?>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>