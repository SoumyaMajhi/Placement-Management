<?php
include '../includes/db.php';
include '../includes/check_student_session.php';

// Check if the student is logged in
$student = check_student_session();

$student_id = $_SESSION['student_id'];
$result = $conn->query("SELECT * FROM students WHERE id='$student_id'");
if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
} else {
    echo "Student not found!";
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch modifiable fields
    $address = $_POST['address'];

    // Class 10 fields
    $class_10_school = $_POST['class_10_school'];
    $class_10_board = $_POST['class_10_board'];
    $class_10_marks = $_POST['class_10_marks'];
    $class_10_year = $_POST['class_10_year']; // Added passing year for Class 10

    // Class 12 fields
    $class_12_school = $_POST['class_12_school'];
    $class_12_board = $_POST['class_12_board'];
    $class_12_marks = $_POST['class_12_marks'];
    $class_12_year = $_POST['class_12_year']; // Added passing year for Class 12

    // UG fields
    $ug_college = $_POST['ug_college'];
    $ug_university = $_POST['ug_university'];
    $ug_degree = $_POST['ug_degree'];
    $ug_specialization = $_POST['ug_specialization'];
    $ug_marks = $_POST['ug_marks'];
    $ug_year = $_POST['ug_year']; // Added passing year for UG

    // PG fields
    // $pg_college = isset($_POST['pg_college']) ? $_POST['pg_college'] : null;
    // $pg_university = isset($_POST['pg_university']) ? $_POST['pg_university'] : null;
    // $pg_degree = isset($_POST['pg_degree']) ? $_POST['pg_degree'] : null;
    // $pg_specialization = isset($_POST['pg_specialization']) ? $_POST['pg_specialization'] : null;
    // $pg_marks = isset($_POST['pg_marks']) ? $_POST['pg_marks'] : null;
    // $pg_year = isset($_POST['pg_year']) ? $_POST['pg_year'] : null;






    if (!empty($_POST['pg_college']) && !empty($_POST['pg_university']) && !empty($_POST['pg_degree']) && !empty($_POST['pg_specialization']) && !empty($_POST['pg_marks']) && !empty($_POST['pg_year'])) {
        $pg_college = $_POST['pg_college'];
        $pg_university = $_POST['pg_university'];
        $pg_degree = $_POST['pg_degree'];
        $pg_specialization = $_POST['pg_specialization'];
        $pg_marks = $_POST['pg_marks'];
        $pg_year = $_POST['pg_year']; // Added passing year for PG

        $sql = "UPDATE students SET 
                address='$address',  
                class_10_school='$class_10_school', 
                class_10_board='$class_10_board', 
                class_10_marks='$class_10_marks',
                class_10_year='$class_10_year',  
                class_12_school='$class_12_school', 
                class_12_board='$class_12_board', 
                class_12_marks='$class_12_marks',
                class_12_year='$class_12_year',  
                ug_college='$ug_college', 
                ug_university='$ug_university', 
                ug_degree='$ug_degree', 
                ug_specialization='$ug_specialization', 
                ug_marks='$ug_marks',
                ug_year='$ug_year',              
                pg_college='$pg_college', 
                pg_university='$pg_university', 
                pg_degree='$pg_degree', 
                pg_specialization='$pg_specialization', 
                pg_marks='$pg_marks',
                pg_year='$pg_year'               
            WHERE id='$student_id'";
    } else {
        $sql = "UPDATE students SET 
                address='$address',  
                class_10_school='$class_10_school', 
                class_10_board='$class_10_board', 
                class_10_marks='$class_10_marks',
                class_10_year='$class_10_year',  
                class_12_school='$class_12_school', 
                class_12_board='$class_12_board', 
                class_12_marks='$class_12_marks',
                class_12_year='$class_12_year',  
                ug_college='$ug_college', 
                ug_university='$ug_university', 
                ug_degree='$ug_degree', 
                ug_specialization='$ug_specialization', 
                ug_marks='$ug_marks',
                ug_year='$ug_year'             
                
            WHERE id='$student_id'";
    }

    // Update fields that can be modified


    if ($conn->query($sql) === TRUE) {
        // echo "yo yo";
        $_SESSION['show_modal'] = true; // Changed from profile_message
        $_SESSION['modal_message'] = "Profile updated. Awaiting admin approval."; // New variable
    } else {
        $_SESSION['show_modal'] = true; // Changed from error
        $_SESSION['modal_message'] = "Error updating profile: " . $conn->error; // New variable
    }
    // Redirect to the same page to display the modal
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Update</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>

        .hidden {
            display: none;
        }
    </style>
</head>

<body class="d-flex vh-100 overflow-hidden">
    <?php include '../includes/student_sidebar.php'; ?>
    <div class="content flex-grow-1 overflow-auto bg-light p-4">
        <?php include '../includes/student_navbar.php'; ?>

        <!-- Bootstrap modal -->
        <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="statusModalLabel">Status Update</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php
                        // echo "first";
                        if (isset($_SESSION['modal_message'])) {
                            echo htmlspecialchars($_SESSION['modal_message']);
                            unset($_SESSION['modal_message']);
                            unset($_SESSION['show_modal']);
                        }
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-5 ">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Student Profile</h2>
                <button id="editButton" class="btn btn-primary mr-4 px-4 rounded-pill" onclick="toggleEdit()">Edit</button>
            </div>
            <!-- Details View -->
            <div id="detailsView" class="mb-4 p-4 border rounded bg-light">
                <h3 class="mb-4">Details</h3>
                <div class="mb-3">
                    <label class="form-label"><strong>Name:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['name']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Roll No.:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['roll_no']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Email:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['email']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Date of Birth:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['dob']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Mobile No.:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['mobile_no']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Address:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['address']); ?></p>
                </div>
                <h5 class="mt-4">Academic Information</h5>
                <div class="mb-3">
                    <label class="form-label"><strong>Class 10 School:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['class_10_school']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Class 10 Board:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['class_10_board']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Class 10 Marks:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['class_10_marks']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Class 10 Passing Year:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['class_10_year']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Class 12/Diploma School:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['class_12_school']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Class 12/Diploma Board:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['class_12_board']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Class 12/Diploma Marks:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['class_12_marks']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>Class 12/Dipolma Passing Year:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['class_12_year']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>UG College:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['ug_college']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>UG University:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['ug_university']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>UG Degree:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['ug_degree']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>UG Specialization:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['ug_specialization']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>UG Marks:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['ug_marks']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>UG Passing Year:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['ug_year']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>PG College:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['pg_college']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>PG University:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['pg_university']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>PG Degree:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['pg_degree']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>PG Specialization:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['pg_specialization']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>PG Marks:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['pg_marks']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label"><strong>PG Passing Year:</strong></label>
                    <p class="form-control-plaintext"><?php echo htmlspecialchars($student['pg_year']); ?></p>
                </div>
            </div>


            <!-- editable form -->
            <form id="editForm" class="hidden" action="profile_update.php" method="post">
                <h3>Update Profile</h3>
                <!-- Non-modifiable fields -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" value="<?php echo htmlspecialchars($student['name']); ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="roll_no" class="form-label">Roll No.</label>
                    <input type="number" class="form-control" id="roll_no" value="<?php echo htmlspecialchars($student['roll_no']); ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($student['email']); ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" value="<?php echo htmlspecialchars($student['dob']); ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="mobile_no" class="form-label">Mobile No.</label>
                    <input type="number" class="form-control" id="mobile_no" value="<?php echo htmlspecialchars($student['mobile_no']); ?>" disabled>
                </div>

                <!-- Modifiable fields -->
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($student['address']); ?>" required>
                </div>

                <!-- Class 10 fields -->
                <div class="mb-3">
                    <label for="class_10_school" class="form-label">Class 10 School Name</label>
                    <input type="text" class="form-control" id="class_10_school" name="class_10_school" value="<?php echo htmlspecialchars($student['class_10_school']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="class_10_board" class="form-label">Class 10 Board Name</label>
                    <input type="text" class="form-control" id="class_10_board" name="class_10_board" value="<?php echo htmlspecialchars($student['class_10_board']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="class_10_marks" class="form-label">Class 10 Percentage/CGPA</label>
                    <input type="number" class="form-control" id="class_10_marks" name="class_10_marks" value="<?php echo htmlspecialchars($student['class_10_marks']); ?>" required step="0.01">
                </div>
                <div class="mb-3">
                    <label for="class_10_year" class="form-label">Class 10 Passing Year</label>
                    <input type="number" class="form-control" id="class_10_year" name="class_10_year" value="<?php echo htmlspecialchars($student['class_10_year']); ?>" required>
                </div>

                <!-- Class 12 fields -->
                <div class="mb-3">
                    <label for="class_12_school" class="form-label">Class 12/Diploma School Name</label>
                    <input type="text" class="form-control" id="class_12_school" name="class_12_school" value="<?php echo htmlspecialchars($student['class_12_school']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="class_12_board" class="form-label">Class 12/Diploma Board Name</label>
                    <input type="text" class="form-control" id="class_12_board" name="class_12_board" value="<?php echo htmlspecialchars($student['class_12_board']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="class_12_marks" class="form-label">Class 12/Diploma Percentage/CGPA</label>
                    <input type="number" class="form-control" id="class_12_marks" name="class_12_marks" value="<?php echo htmlspecialchars($student['class_12_marks']); ?>" required step="0.01">
                </div>
                <div class="mb-3">
                    <label for="class_12_year" class="form-label">Class 12 Passing Year</label>
                    <input type="number" class="form-control" id="class_12_year" name="class_12_year" value="<?php echo htmlspecialchars($student['class_12_year']); ?>" required>
                </div>

                <!-- UG fields -->
                <div class="mb-3">
                    <label for="ug_college" class="form-label">UG College Name</label>
                    <input type="text" class="form-control" id="ug_college" name="ug_college" value="<?php echo htmlspecialchars($student['ug_college']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="ug_university" class="form-label">UG University Name</label>
                    <input type="text" class="form-control" id="ug_university" name="ug_university" value="<?php echo htmlspecialchars($student['ug_university']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="ug_degree" class="form-label">UG Degree</label>
                    <select class="form-select" id="ug_degree" name="ug_degree" required onchange="updateUGSpecializations()">
                        <option value="" disabled selected>Select Degree</option>
                        <option value="B.Tech" <?php echo $student['ug_degree'] === 'B.Tech' ? 'selected' : ''; ?>>B.Tech</option>
                        <option value="B.Sc." <?php echo $student['ug_degree'] === 'B.Sc.' ? 'selected' : ''; ?>>B.Sc.</option>
                        <option value="B.Com" <?php echo $student['ug_degree'] === 'B.Com' ? 'selected' : ''; ?>>B.Com</option>
                        <option value="B.A." <?php echo $student['ug_degree'] === 'B.A.' ? 'selected' : ''; ?>>B.A.</option>
                        <option value="B.C.A." <?php echo $student['ug_degree'] === 'B.C.A.' ? 'selected' : ''; ?>>B.C.A.</option>

                    </select>
                </div>
                <div class="mb-3">
                    <label for="ug_specialization" class="form-label">UG Specialization</label>
                    <select class="form-select" id="ug_specialization" name="ug_specialization" required>
                        <option value="" disabled selected>Select your specialization</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="ug_marks" class="form-label">UG Percentage/CGPA</label>
                    <input type="number" class="form-control" id="ug_marks" name="ug_marks" value="<?php echo htmlspecialchars($student['ug_marks']); ?>" required step="0.01">
                </div>
                <div class="mb-3">
                    <label for="ug_year" class="form-label">UG Passing Year</label>
                    <input type="number" class="form-control" id="ug_year" name="ug_year" value="<?php echo htmlspecialchars($student['ug_year']); ?>" required>
                </div>

                <!-- PG fields -->
                <div class="mb-3">
                    <label for="pg_college" class="form-label">PG College Name</label>
                    <input type="text" class="form-control" id="pg_college" name="pg_college" value="<?php echo htmlspecialchars($student['pg_college']); ?>">
                </div>
                <div class="mb-3">
                    <label for="pg_university" class="form-label">PG University Name</label>
                    <input type="text" class="form-control" id="pg_university" name="pg_university" value="<?php echo htmlspecialchars($student['pg_university']); ?>">
                </div>
                <div class="mb-3">
                    <label for="pg_degree" class="form-label">PG Degree</label>
                    <select class="form-select" id="pg_degree" name="pg_degree" onchange="updatePGSpecializations()">
                        <option value="" disabled selected>Select Degree</option>
                        <option value="M.Sc" <?php echo $student['pg_degree'] === 'M.Sc' ? 'selected' : ''; ?>>M.Sc</option>
                        <option value="M.Tech" <?php echo $student['pg_degree'] === 'M.Tech' ? 'selected' : ''; ?>>M.Tech</option>
                        <option value="M.C.A." <?php echo $student['pg_degree'] === 'M.C.A.' ? 'selected' : ''; ?>>M.C.A.</option>
                        <option value="M.A" <?php echo $student['pg_degree'] === 'M.A' ? 'selected' : ''; ?>>M.A</option>
                        <option value="M.Com" <?php echo $student['pg_degree'] === 'M.Com' ? 'selected' : ''; ?>>M.Com</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="pg_specialization" class="form-label">PG Specialization</label>
                    <select class="form-select" id="pg_specialization" name="pg_specialization">
                        <option value="" disabled selected>Select your specialization</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="pg_marks" class="form-label">PG Percentage/CGPA</label>
                    <input type="number" class="form-control" id="pg_marks" name="pg_marks" value="<?php echo htmlspecialchars($student['pg_marks']); ?>" step="0.01">
                </div>
                <div class="mb-3">
                    <label for="pg_year" class="form-label">PG Passing Year</label>
                    <input type="number" class="form-control" id="pg_year" name="pg_year" value="<?php echo htmlspecialchars($student['pg_year']); ?>">
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>

    <!-- Include Bootstrap and jQuery JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        function updateUGSpecializations() {
            const degree = document.getElementById('ug_degree').value;
            const specializationSelect = document.getElementById('ug_specialization');

            // Clear previous options
            specializationSelect.innerHTML = '<option value="" disabled selected>Select your specialization</option>';

            let specializations = [];

            switch (degree) {
                case 'B.Sc.':
                    specializations = ['General', 'Physics', 'Chemistry', 'Mathematics', 'Biology', 'Computer Science', 'Statistics'];
                    break;
                case 'B.Tech':
                    specializations = ['Computer Science', 'Information Technology', 'Electronics', 'Mechanical', 'Civil', 'Electrical'];
                    break;
                case 'B.Com':
                    specializations = ['General', 'Accounting', 'Finance', 'Marketing', 'E-Commerce'];
                    break;
                case 'B.A.':
                    specializations = ['General', 'English', 'History', 'Political Science', 'Psychology', 'Sociology', 'Economics'];
                    break;
                case 'B.C.A.':
                    specializations = ['Computer Application'];
                    break;
            }

            // Populate the specialization dropdown
            specializations.forEach(spec => {
                const option = document.createElement('option');
                option.value = spec;
                option.textContent = spec;
                specializationSelect.appendChild(option);
            });
        }

        function updatePGSpecializations() {
            const degree = document.getElementById('pg_degree').value;
            const specializationSelect = document.getElementById('pg_specialization');

            // Clear previous options
            specializationSelect.innerHTML = '<option value="" disabled selected>Select your specialization</option>';

            let specializations = [];

            switch (degree) {
                case 'M.Sc':
                    specializations = ['Physics', 'Chemistry', 'Mathematics', 'Biotechnology', 'Computer Science'];
                    break;
                case 'M.Tech':
                    specializations = ['Computer Science', 'Information Technology', 'Mechanical Engineering', 'Civil Engineering', 'Electrical Engineering'];
                    break;
                case 'M.C.A.':
                    specializations = ['Computer Application'];
                    break;
                case 'M.A':
                    specializations = ['English', 'History', 'Political Science', 'Sociology', 'Psychology'];
                    break;
                case 'M.Com':
                    specializations = ['Accounting', 'Finance', 'Marketing', 'Business Management'];
                    break;
            }

            // Populate the specialization dropdown
            specializations.forEach(spec => {
                const option = document.createElement('option');
                option.value = spec;
                option.textContent = spec;
                specializationSelect.appendChild(option);
            });
        }

        function toggleEdit() {
            const detailsView = document.getElementById('detailsView');
            const editForm = document.getElementById('editForm');
            const editButton = document.getElementById('editButton');

            if (editForm.classList.contains('hidden')) {
                detailsView.classList.add('hidden');
                editForm.classList.remove('hidden');
                editButton.innerText = 'View';
            } else {
                detailsView.classList.remove('hidden');
                editForm.classList.add('hidden');
                editButton.innerText = 'Edit';
            }
        }
        // $(document).ready(function() {
        //     console.log("hello");
        //     <?php if (isset($_SESSION['profile_message']) || isset($_SESSION['error'])): ?>
        //         console.log("samy");
        //         $('#statusModal').modal('show');
        //     <?php endif; ?>
        // });

        // Replace the existing modal trigger code with this
        // $(document).ready(function() {
        //     <?php if (isset($_SESSION['show_modal'])): ?>
        //         console.log("samy");
        //         var myModal = new bootstrap.Modal(document.getElementById('statusModal'));
        //         myModal.show();
        //     <?php endif; ?>
        // });

        // $(document).ready(function() {
        //     const showModal = <?php echo isset($_SESSION['show_modal']) ? 'true' : 'false' ?>;
        //     console.log(showModal);
        //     if (showModal) {
        //         console.log("showing modal");
        //         var myModal = new bootstrap.Modal(document.getElementById('statusModal'));
        //         myModal.show();
        //     }
        // });
    </script>
</body>

</html>