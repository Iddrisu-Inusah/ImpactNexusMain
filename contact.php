<?php
$servername = "localhost";
$username = "root"; // Change if different
$password = ""; // Change if different
$database = "impactnexus_main";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("ssss", $name, $email, $subject, $message);
                if ($stmt->execute()) {
                    echo "Message saved successfully!";
                } else {
                    echo "Error executing query: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
        } else {
            echo "Invalid email format.";
        }
    } else {
        echo "Please fill in all fields.";
    }
}

$conn->close();
?>7

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Impact Nexus</title>
    <link rel="stylesheet" href="contact.css">
    <script src="contact."></script>
    
</head>
<body>
    <nav>
        <div class="logo-container">
            <a href="#"><img src="images/nexus logo.jpg" alt="Impact Nexus Logo"></a>
        </div>
        <ul class="nav-links">
            <li><a href="home.php">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="courses.php">Courses</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>
    <header class="contact-hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Contact Us</h1>
            <p>We’d love to hear from you! Get in touch with us today.</p>
        </div>
    </header>
    <section class="contact-info">
        <div class="container">
            <h2>Get in Touch</h2>
            <p>If you have any questions, feel free to reach out.</p>
            <div class="info-grid">
                <div class="info-card"><h3>Email Us</h3><p>info@impactnexus.com</p></div>
                <div class="info-card"><h3>Call Us</h3><p>+233 24 123 4567</p></div>
                <div class="info-card"><h3>Visit Us</h3><p>Impact Nexus Network, Ghana</p></div>
            </div>
        </div>
    </section>
    <section class="contact-form">
        <div class="container">
            <h2>Send Us a Message</h2>
            <?php if (isset($successMessage)) echo "<p class='success'>$successMessage</p>"; ?>
            <?php if (isset($errorMessage)) echo "<p class='error'>$errorMessage</p>"; ?>
            <form id="contactForm" method="POST" action="contact.php">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <input type="text" name="subject" placeholder="Subject" required>
                <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
                <button type="submit" class="submit-btn">Send Message</button>
            </form>
        </div>
    </section>
    <section class="map">
        <div class="container">
            <h2>Find Us Here</h2>
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d35891.50998353333!2d-1.2920779038688965!3d5.113061706192187!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sgh!4v1743245963147!5m2!1sen!2sgh" 
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </section>
    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 Impact Nexus Network Academy. All Rights Reserved.</p>
    </footer>
</body>
</html>