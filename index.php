<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placement Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles */
        .carousel-item img {
            height: 70vh;
            object-fit: cover;
        }
        /* Caption background */
        .carousel-caption {
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black */
            border-radius: 10px; /* Rounded corners */
            padding: 1rem; /* Padding around the text */
            width: fit-content; /* Adjust width to fit content */
            left: 50%; /* Center the caption */
            transform: translateX(-50%); /* Center adjustment */
        }
        /* Video section */
        .video-section {
            position: relative;
            overflow: hidden;
            height: 70vh;
            color: white;
        }
        .video-section video {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: translate(-50%, -50%);
            z-index: 1;
            opacity: 0.9;
        }
        .video-overlay {
            position: relative;
            z-index: 2;
            background-color: rgba(0, 0, 0, 0.22);
            padding: 2rem;
            border-radius: 15px;
        }
        /* Contact Us styling */
        .contact-card {
            background: #fff;
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm rounded-4 mt-3 mx-3">
    <div class="container">
        <a class="navbar-brand fs-4 fw-bold d-flex align-items-center" href="#">
            <img src="images/logo.png" alt="College Logo" width="40" height="40" class="me-2">
            Oscar Institute of Technology
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact Us</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="studentDropdown" data-bs-toggle="dropdown">Student</a>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li><a class="dropdown-item" href="student/student_login.php">Login</a></li>
                        <li><a class="dropdown-item" href="student/student_signup.php">Sign Up</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" data-bs-toggle="dropdown">Admin/TPO</a>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li><a class="dropdown-item" href="admin/admin_login.php">Login</a></li>
                        <li><a class="dropdown-item" href="admin/admin_signup.php">Sign Up</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Carousel Section -->
<section id="carouselSection" class="mt-4">
    <div id="collegeCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/campus1.jpg" class="d-block w-100" alt="Campus">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Welcome to Oscar Institute of Technology</h5>
                    <p>Building a brighter future with excellence in education.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/campus2.jpg" class="d-block w-100" alt="Campus 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Explore Our Beautiful Campus</h5>
                    <p>A serene environment that fosters creativity and learning.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/campus3.jpg" class="d-block w-100" alt="Campus 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Join Us on the Path to Success</h5>
                    <p>Empowering students through impactful placements and careers.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#collegeCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#collegeCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

<!-- Placement Statistics Section with Video Background -->
<section class="video-section mt-5">
    <video autoplay muted loop playsinline>
        <source src="videos/hitk_campus_tour.mp4" type="video/mp4">
    </video>
    <div class="container d-flex justify-content-center align-items-center h-100">
        <div class="text-center text-white video-overlay">
            <h2 class="mb-4 fw-bold">Placement Statistics</h2>
            <div class="row g-4">
                <div class="col-12 col-md-4">
                    <div class="card bg-transparent border-0 text-center text-white">
                        <div class="card-body">
                            <h3 class="display-4 fw-bold text-warning">100+</h3>
                            <p class="fs-5">Companies Visited</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card bg-transparent border-0 text-center text-white">
                        <div class="card-body">
                            <h3 class="display-4 fw-bold text-info">500+</h3>
                            <p class="fs-5">Students Placed</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card bg-transparent border-0 text-center text-white">
                        <div class="card-body">
                            <h3 class="display-4 fw-bold text-success">50+</h3>
                            <p class="fs-5">Placement Drives</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Us Section -->
<section id="contact" class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold">Contact Us</h2>
        <div class="row g-4">
            <div class="col-12 col-lg-6">
                <div class="card contact-card shadow-sm p-4 h-100">
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" class="form-control form-control-lg" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Your Email</label>
                            <input type="email" class="form-control form-control-lg" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control form-control-lg" id="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100">Send Message</button>
                    </form>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card contact-card shadow-sm p-4 h-100">
                    <h4 class="fw-bold mb-4">Reach us at:</h4>
                    <div class="d-flex flex-column gap-3">
                        <p class="fs-5 mb-0">
                            <i class="bi bi-geo-alt-fill"></i> Oscar Institute of Technology, Kolkata
                        </p>
                        <p class="fs-5 mb-0">
                            <i class="bi bi-telephone-fill"></i> +91 9876543210
                        </p>
                        <p class="fs-5 mb-0">
                            <i class="bi bi-envelope-fill"></i> info@oscart.edu.in
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-primary text-white text-center py-3">
    <p class="mb-0">© 2024 Soumya Majhi. All Rights Reserved.</p>
</footer>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
