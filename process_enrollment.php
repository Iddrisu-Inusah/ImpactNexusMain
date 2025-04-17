<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'] ?? null;
    $course_id = $_POST['course_id'];

    if (!$user_id) {
        $_SESSION['error_message'] = "You must be logged in to enroll.";
        header("Location: course_register.php?course_id=" . $course_id);
        exit();
    }

    // Check if the user is already enrolled
    $sql_check = "SELECT id FROM enrollments WHERE user_id = ? AND course_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ii", $user_id, $course_id);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $_SESSION['error_message'] = "You are already enrolled in this course!";
        $stmt_check->close(); // ✅ Close before exiting
        header("Location: course_register.php?course_id=" . $course_id);
        exit();
    }

    $stmt_check->close(); // ✅ Close outside the if-else blocks

    // Insert enrollment record
    $sql = "INSERT INTO enrollments (user_id, course_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $course_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "You have successfully enrolled!";
        $stmt->close();
        $conn->close();
        header("Location: courses.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Something went wrong. Try again!";
        $stmt->close();
        $conn->close();
        header("Location: course_register.php?course_id=" . $course_id);
        exit();
    }
}
?>