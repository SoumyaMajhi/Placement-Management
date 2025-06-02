<?php
include 'db.php';
include 'check_student_session.php';
$student = check_student_session();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_photo'])) {
    $file = $_FILES['profile_photo'];
    $allowedTypes = ['image/jpeg', 'image/png'];
    // $maxSize = 2 * 1024 * 1024; // 2MB
    $maxSize = 5 * 1024 * 1024; // 5MB


    // Validate file
    if ($file['error'] === UPLOAD_ERR_OK) {
        if ($file['size'] <= $maxSize) {
            if (in_array($file['type'], $allowedTypes)) {
                $uploadDir = '../images/profile_pictures/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $fileName = 'student_' . $student['id'] . '.' . 
                           pathinfo($file['name'], PATHINFO_EXTENSION);
                $filePath = $uploadDir . $fileName;

                if (move_uploaded_file($file['tmp_name'], $filePath)) {
                    // Delete old photo if exists
                    if (!empty($student['profile_picture'])) {
                        @unlink($student['profile_picture']);
                    }

                    // Update database with new photo path
                    $sql = "UPDATE students SET profile_picture = ? WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    
                    if ($stmt->execute([$filePath, $student['id']])) {
                        $_SESSION['success_message'] = 'Profile photo updated successfully!';
                    } else {
                        $_SESSION['error_message'] = 'Failed to update database. Please try again.';
                        // Clean up uploaded file if database update fails
                        @unlink($filePath);
                    }
                } else {
                    $_SESSION['error_message'] = 'Failed to upload file. Please try again.';
                }
            } else {
                $_SESSION['error_message'] = 'Invalid file type. Please upload JPG or PNG files only.';
            }
        } else {
            $_SESSION['error_message'] = 'File size must be less than 5MB.';
        }
    } else {
        $_SESSION['error_message'] = 'Error uploading file. Please try again.';
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>