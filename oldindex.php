<!-- <?php
    echo "this is samy";
?> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placement Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Navbar styling */
        .navbar {
            background-color: #004080;
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: #ffffff !important;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .carousel-inner img {
            width: 100%;
            height: 500px;
            object-fit: cover;
        }
        /* Contact Us Section */
        #contact {
            background-color: #f8f9fa;
            padding: 50px 0;
        }
        #contact h3 {
            margin-bottom: 30px;
        }
        .footer {
            background-color: #004080;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
        .footer a {
            color: white;
        }
        .footer a:hover {
            color: #e0e0e0;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="images/logo.png" alt="College Logo" width="40" height="40" class="d-inline-block align-text-top">
            Oscar Institute of Technology
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact Us</a>
                </li>
                <!-- Student Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="studentDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Student
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="studentDropdown">
                        <li><a class="dropdown-item" href="student/student_login.php">Login</a></li>
                        <li><a class="dropdown-item" href="student/student_signup.php">Sign Up</a></li>
                    </ul>
                </li>
                <!-- Admin Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Admin/TPO
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                        <li><a class="dropdown-item" href="admin/admin_login.php">Login</a></li>
                        <li><a class="dropdown-item" href="admin/admin_signup.php">Sign Up</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Carousel -->
<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="images/college1.jpg" class="d-block w-100" alt="College Image 1">
        </div>
        <div class="carousel-item">
            <img src="images/college2.jpg" class="d-block w-100" alt="College Image 2">
        </div>
        <div class="carousel-item">
            <img src="images/college3.jpg" class="d-block w-100" alt="College Image 3">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Placement Statistics Section -->
<div class="container my-5">
    <h2 class="text-center mb-4">Placement Statistics</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="card-title">100+</h3>
                    <p class="card-text">Companies Visited</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="card-title">500+</h3>
                    <p class="card-text">Students Placed</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="card-title">50+</h3>
                    <p class="card-text">Placement Drives Conducted</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contact Us Section -->
<section id="contact">
    <div class="container">
        <h3 class="text-center">Contact Us</h3>
        <div class="row">
            <div class="col-md-6">
                <form>
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Your Email</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
            <div class="col-md-6">
                <h5>Reach us at:</h5>
                <p><strong>Address:</strong> 123 College Road, City, State, 12345</p>
                <p><strong>Phone:</strong> +1 234 567 890</p>
                <p><strong>Email:</strong> contact@college.com</p>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<div class="footer">
    <div class="container">
        <p>&copy;2024 Soumya Majhi 
            <!-- | <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a> -->
        </p>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
