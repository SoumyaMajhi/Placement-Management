<?php
if (!isset($admin)) {
    include '/check_admin_session.php';
    $admin = check_admin_session();
}

// Get the current page filename to highlight the active link
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sidebar</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        /* Sidebar Container */
        .sidebar {
            min-width: 250px;
            background-color: #1c1f26;
            color: white;
            padding: 25px 15px;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: all 0.3s ease;
        }

        /* Profile Icon & Info */
        .profile-icon {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background-color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .profile-icon:hover {
            transform: scale(1.1);
        }

        .profile-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .profile-info {
            text-align: center;
            margin-bottom: 25px;
        }

        .profile-info h5 {
            font-size: 1.25rem;
            margin-bottom: 5px;
        }

        .profile-info p {
            font-size: 1rem;
            color: #adb5bd;
        }

        /* Sidebar Links */
        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            display: block;
            margin: 10px 0;
            font-size: 1.1rem;
            padding: 12px;
            width: 100%;
            text-align: center;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .sidebar a:hover {
            background-color: #495057;
            color: #ffffff;
        }

        /* Active Link Styling */
        .sidebar a.active {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
        }
    </style>
</head>

<body>
    <div class="offcanvas-lg offcanvas-start" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header d-lg-none">
            <h5 class="offcanvas-title text-dark" id="sidebarMenuLabel">Admin Menu</h5>
            <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
        </div>
        <!-- <div class="offcanvas-body p-0"> -->

            <div class="sidebar">
                <!-- Profile Icon with Modal Trigger -->
                <div class="profile-icon" data-bs-toggle="modal" data-bs-target="#profileOptionsModal">
                    <?php if (!empty($admin['profile_picture'])): ?>
                        <img src="<?php echo htmlspecialchars($admin['profile_picture']); ?>" alt="Profile Picture">
                    <?php else: ?>
                        <i class="fas fa-user-circle fa-3x" style="color: white;"></i>
                    <?php endif; ?>
                </div>

                <!-- Profile Options Modal -->
                <div class="modal fade" id="profileOptionsModal" tabindex="-1" aria-labelledby="profileOptionsLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="profileOptionsLabel">Profile Icon Options</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body d-grid gap-2">
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#updatePhotoModal" data-bs-dismiss="modal">
                                    <i class="fas fa-camera me-2"></i>Update Photo
                                </button>
                                <?php if (!empty($admin['profile_picture'])): ?>
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletePhotoModal" data-bs-dismiss="modal">
                                        <i class="fas fa-trash me-2"></i>Delete Photo
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Update Photo Modal -->
                <div class="modal fade" id="updatePhotoModal" tabindex="-1" aria-labelledby="updatePhotoLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updatePhotoLabel">Update Profile Photo</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="../includes/admin_update_photo.php" method="post" enctype="multipart/form-data" id="updatePhotoForm">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="profile_photo" class="form-label">Choose Photo</label>
                                        <input type="file" name="profile_photo" id="profile_photo"
                                            class="form-control" accept="image/*" required>
                                        <div class="form-text">Maximum size: 5MB. Supported formats: JPG, PNG</div>
                                    </div>
                                    <div id="imagePreview" class="text-center mt-3" style="display: none;">
                                        <img src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-upload me-2"></i>Upload Photo
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Delete Photo Confirmation Modal -->
                <div class="modal fade" id="deletePhotoModal" tabindex="-1" aria-labelledby="deletePhotoLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deletePhotoLabel">Delete Profile Photo</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Are you sure you want to delete your profile photo? This action cannot be undone.
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="../includes/delete_photo.php" method="post">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash me-2"></i>Delete Photo
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Information -->
                <div class="profile-info">
                    <h5><?php echo htmlspecialchars($admin['name']); ?></h5>
                    <p>Admin ID: <?php echo htmlspecialchars($admin['id']); ?></p>
                </div>

                <!-- Sidebar Navigation Links -->
                <a href="admin_dashboard.php" class="<?php echo $current_page == 'admin_dashboard.php' ? 'active' : ''; ?>">
                    <i class="fas fa-home me-2"></i>Home
                </a>
                <a href="profile_update.php" class="<?php echo $current_page == 'profile_update.php' ? 'active' : ''; ?>">
                    <i class="fa-solid fa-graduation-cap me-2"></i>Students
                    <!-- <i class="fas fa-user-edit me-2"></i> -->
                </a>
                <a href="placements.php" class="<?php echo $current_page == 'placements.php' ? 'active' : ''; ?>">
                    <i class="fas fa-briefcase me-2"></i>Placement Drives
                </a>
                <a href="raise_issue.php" class="<?php echo $current_page == 'raise_issue.php' ? 'active' : ''; ?>">
                    <i class="fas fa-exclamation-circle me-2"></i>Issues
                </a>
                <a href="view_notifs.php" class="<?php echo $current_page == 'view_notifs.php' ? 'active' : ''; ?>">
                    <i class="fas fa-bell me-2"></i>Notifications
                </a>
                <a href="../includes/logout.php?logout=admin">
                    <i class="fas fa-sign-out-alt me-2"></i>Sign Out
                </a>
            </div>


    </div>



    <!-- Bootstrap JS
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> -->

    <script>
        // Image preview functionality
        document.getElementById('profile_photo')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('imagePreview');
            const previewImg = preview.querySelector('img');

            if (file) {
                // Validate file size (5MB max)
                if (file.size > 5 * 1024 * 1024) {
                    alert('File size must be less than 5MB');
                    e.target.value = '';
                    preview.style.display = 'none';
                    return;
                }

                // Validate file type
                if (!file.type.match('image.*')) {
                    alert('Please select an image file');
                    e.target.value = '';
                    preview.style.display = 'none';
                    return;
                }

                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });

        // Reset file input and preview when modal is closed
        document.getElementById('updatePhotoModal')?.addEventListener('hidden.bs.modal', function() {
            document.getElementById('updatePhotoForm').reset();
            document.getElementById('imagePreview').style.display = 'none';
        });
    </script>


    <!-- jQuery (if needed) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>