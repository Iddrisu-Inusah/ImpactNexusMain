<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error_message'] = "You need to log in to enroll in a course.";
        header("Location: login.php");
        exit();
    }

    if (!isset($_POST['course_id']) || empty($_POST['course_id'])) {
        $_SESSION['error_message'] = "Invalid course selection.";
        header("Location: courses.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $course_id = intval($_POST['course_id']);

    // Check if the email already exists for another user
    $check_email = "SELECT id FROM users WHERE email = (SELECT email FROM users WHERE id = ?)";
    if ($stmt_email = $conn->prepare($check_email)) {
        $stmt_email->bind_param("i", $user_id);
        $stmt_email->execute();
        $stmt_email->store_result();

        if ($stmt_email->num_rows > 0) {
            $_SESSION['error_message'] = "This email is already registered. Please log in to enroll in courses.";
            $stmt_email->close();
            header("Location: enroll.php?course_id=" . $course_id);
            exit();
        }
        $stmt_email->close();
    } else {
        $_SESSION['error_message'] = "Database error: " . htmlspecialchars($conn->error);
        header("Location: courses.php");
        exit();
    }

    // Check if the user is already enrolled
    $check_enrollment = "SELECT id FROM enrollments WHERE user_id = ? AND course_id = ?";
    if ($stmt_check = $conn->prepare($check_enrollment)) {
        $stmt_check->bind_param("ii", $user_id, $course_id);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $_SESSION['error_message'] = "You are already enrolled in this course.";
            $stmt_check->close();
            header("Location: course.php?course_id=" . $course_id);
            exit();
        }
        $stmt_check->close();
    } else {
        $_SESSION['error_message'] = "Database error: " . htmlspecialchars($conn->error);
        header("Location: courses.php");
        exit();
    }

    // Enroll the user in the course
    $sql_enroll = "INSERT INTO enrollments (user_id, course_id) VALUES (?, ?)";
    if ($stmt_enroll = $conn->prepare($sql_enroll)) {
        $stmt_enroll->bind_param("ii", $user_id, $course_id);
        if ($stmt_enroll->execute()) {
            $_SESSION['success_message'] = "Enrollment successful!";
        } else {
            $_SESSION['error_message'] = "Error enrolling: " . htmlspecialchars($stmt_enroll->error);
        }
        $stmt_enroll->close();
    } else {
        $_SESSION['error_message'] = "Database error: " . htmlspecialchars($conn->error);
    }

    $conn->close();
    header("Location: course.php?course_id=" . $course_id);
    exit();
} else {
    $_SESSION['error_message'] = "Invalid request!";
    header("Location: courses.php");
    exit();
}
?>