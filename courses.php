<?php
session_start();
include 'db_connect.php'; // Database connection file

// Fetch courses from the database
$query = "SELECT * FROM courses";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - Impact Nexus</title>
    <link rel="stylesheet" href="courses.css">
    <script defer src="courses.js"></script>
</head>
<body>
    <!-- Navigation Bar -->
    <nav>
        <div class="logo-container">
            <a href="index.php"><img src="images/nexus logo.jpg" alt="Impact Nexus Logo"></a>
        </div>
        <ul class="nav-links">
            <li><a href="Home.php">Home</a></li>
            <li><a href="About.html">About</a></li>
            <li><a href="courses.php" class="active">Courses</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>

    <!-- Sidebar for User Account -->
    <aside class="sidebar <?php echo isset($_SESSION['user_id']) ? '' : 'hidden'; ?>">
        <h3>User Dashboard</h3>
        <p>Welcome, <span id="username"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?></span></p>
        <?php if (isset($_SESSION['user_id'])): ?>
            <button id="logout-btn">Logout</button>
        <?php else: ?>
            <button id="login-btn">Login</button>
        <?php endif; ?>
    </aside>

    <!-- Hero Section -->
    <header class="courses-hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Explore Our IT & STEAM Courses</h1>
            <p>Empowering the next generation of innovators through technology education.</p>
        </div>
    </header>

    <!-- Courses Section -->
    <section class="courses-container">
        <div class="container">
            <h2>Our Programs</h2>
            <div class="courses-grid">
                <?php while ($course = mysqli_fetch_assoc($result)): ?>
                    <div class="course-card">
                        <img src="<?php echo $course['image']; ?>" alt="<?php echo $course['title']; ?>">
                        <h3><?php echo $course['title']; ?></h3>
                        <p><?php echo $course['description']; ?></p>
                        <button class="enroll-btn" onclick="location.href='enroll_course.php?course_id=<?php echo $course['id']; ?>'">Enroll Now</button>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Impact Nexus Network Academy. All Rights Reserved.</p>
    </footer>
</body>
</html>
