<?php 
include 'db.php';
include 'check_student_session.php';

$student = check_student_session();
$student_id = $student['id']; // Get student ID from the session data

// Retrieve current profile picture path
$query = "SELECT profile_picture FROM students WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row && !empty($row['profile_picture'])) {
    $profile_picture = $row['profile_picture'];
    
    // Add error logging for debugging
    error_log("Attempting to delete file: " . $profile_picture);
    
    // Check if file exists and is readable
    if (file_exists($profile_picture) && is_readable($profile_picture)) {
        try {
            if (unlink($profile_picture)) {
                // File deleted successfully
                error_log("File deleted successfully");
                
                // Update the database to remove the profile picture path
                $query = "UPDATE students SET profile_picture = NULL WHERE id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $student_id);
                
                if ($stmt->execute()) {
                    $_SESSION['success_message'] = "Profile photo deleted successfully.";
                } else {
                    $_SESSION['error_message'] = "Error updating database: " . $conn->error;
                }
            } else {
                $_SESSION['error_message'] = "Could not delete the file. Please check file permissions.";
                error_log("Failed to delete file: " . $profile_picture);
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Error occurred while deleting file: " . $e->getMessage();
            error_log("Exception while deleting file: " . $e->getMessage());
        }
    } else {
        // If file doesn't exist, just update the database
        $query = "UPDATE students SET profile_picture = NULL WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $student_id);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Profile photo record removed from database.";
        } else {
            $_SESSION['error_message'] = "Error updating database: " . $conn->error;
        }
        error_log("File not found or not readable: " . $profile_picture);
    }
} else {
    $_SESSION['error_message'] = "No profile photo found in database.";
    error_log("No profile picture found in database for student ID: " . $student_id);
}

// Close database connections
$stmt->close();
$conn->close();

header("Location: ../student/student_dashboard.php");
exit();
?>