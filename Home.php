<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirect users who are not logged in
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impact Nexus - Homepage</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>

    <!-- Navigation Bar -->
    <nav>
        <div class="logo-container">
            <img src="images/nexus logo.jpg" alt="Impact Nexus Logo">
        </div>
        <ul class="nav-links">
            <li><a href="home.php">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="courses.php">Courses</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Hero Section -->
    <header class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Welcome <?php echo htmlspecialchars($_SESSION['full_name']); ?>, to Impact Nexus!</h1>
            <p>Empowering Innovation & Technology for the Future</p>
            <a href="about.html" class="hero-btn">Learn More</a>
        </div>
    </header>

    <!-- Navigation Path with Images -->
    <section class="navigation-path">
        <div class="nav-item">
            <img src="about.jpg" alt="About Us">
            <div class="nav-text">Click to view more about us</div>
        </div>
        <a href="about.html" class="nav-btn">Go to About Us</a>

        <div class="nav-item">
            <img src="images/cources.jpg" alt="Our Courses">
            <div class="nav-text">Click to explore our courses</div>
        </div>

        <a href="courses.php" class="nav-btn">Go to Courses</a>
        <div class="nav-item">
            <img src="images/contact.jpg" alt="Contact Us">
            <div class="nav-text">Click to reach out to us</div>
            
        </div>
       
        <><a href="contact.php" class="nav-btn">Go to Contact</a>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Impact Nexus. All Rights Reserved.</p>
    </footer>

</body>
</html>
