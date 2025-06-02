<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company_name = $_POST['company_name'];
    $job_role = $_POST['job_role'];
    $eligibility_criteria = $_POST['eligibility_criteria'];
    $apply_deadline = $_POST['apply_deadline'];

    $sql = "INSERT INTO placement_drives (company_name, job_role, eligibility_criteria, apply_deadline) 
            VALUES ('$company_name', '$job_role', '$eligibility_criteria', '$apply_deadline')";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_dashboard.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Placement Drive</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Add New Placement Drive</h2>
        <form action="add_drive.php" method="post">
            <div class="mb-3">
                <label for="company_name" class="form-label">Company Name</label>
                <input type="text" class="form-control" id="company_name" name="company_name" required>
            </div>
            <div class="mb-3">
                <label for="job_role" class="form-label">Job Role</label>
                <input type="text" class="form-control" id="job_role" name="job_role" required>
            </div>
            <div class="mb-3">
                <label for="eligibility_criteria" class="form-label">Eligibility Criteria</label>
                <textarea class="form-control" id="eligibility_criteria" name="eligibility_criteria" required></textarea>
            </div>
            <div class="mb-3">
                <label for="apply_deadline" class="form-label">Apply Deadline</label>
                <input type="date" class="form-control" id="apply_deadline" name="apply_deadline" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Drive</button>
        </form>
    </div>
</body>
</html>
