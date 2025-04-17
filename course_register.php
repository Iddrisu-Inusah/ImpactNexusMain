<?php
session_start();
include 'db_connect.php';

$error = "";
$success = "";

// Ensure a course is selected before allowing registration
if (!isset($_GET['course_id'])) {
    die("Invalid request! No course selected.");
}

$course_id = $_GET['course_id'];

// Fetch course details to avoid undefined variable error
$course_sql = "SELECT * FROM courses WHERE id = ?";
$stmt_course = $conn->prepare($course_sql);
$stmt_course->bind_param("i", $course_id);
$stmt_course->execute();
$result = $stmt_course->get_result();

if ($result->num_rows > 0) {
    $course = $result->fetch_assoc();
} else {
    die("Error: Course not found.");
}
$stmt_course->close();

// Prevent re-registration if the user is already enrolled
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $check_enrollment = "SELECT id FROM enrollments WHERE user_id = ? AND course_id = ?";
    $stmt_check = $conn->prepare($check_enrollment);
    $stmt_check->bind_param("ii", $user_id, $course_id);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $_SESSION['error_message'] = "You are already enrolled in this course.";
        header("Location: courses.php?course_id=" . $course_id);
        exit();
    }
    $stmt_check->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll in Course</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h2 {
            margin-bottom: 15px;
            color: #333;
        }
        .message {
            font-size: 14px;
            margin-bottom: 10px;
        }
        .error-message {
            color: red;
        }
        .success-message {
            color: green;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Enroll in <?php echo htmlspecialchars($course['title']); ?></h2>

        <?php if (isset($_SESSION['error_message'])): ?>
            <p class="message error-message"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION['success_message'])): ?>
            <p class="message success-message"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></p>
        <?php endif; ?>

    <form action="course_process.php" method="POST">
    <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">

    <label for="name">Name:</label>
    <input type="text" name="name" value="<?php echo $_SESSION['full_name'] ?? ''; ?>" disabled>

    <label for="email">Email:</label>
    <input type="email" name="email" value="<?php echo $_SESSION['email'] ?? ''; ?>" disabled>

    <button type="submit">Enroll Now</button>
    </form>
    </div>

</body>
</html>