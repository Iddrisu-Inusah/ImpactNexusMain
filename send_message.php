<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    $message = trim($_POST['message']);
    $user_name = isset($_SESSION['username']) ? $_SESSION['username'] : "Guest";

    if (!empty($message)) {
        $stmt = $conn->prepare("INSERT INTO chat_messages (user_name, message) VALUES (?, ?)");
        $stmt->bind_param("ss", $user_name, $message);
        $stmt->execute();
        $stmt->close();
    }
}
?>