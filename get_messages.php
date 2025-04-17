<?php
include 'db_connect.php';

$result = $conn->query("SELECT * FROM chat_messages ORDER BY created_at ASC");

while ($row = $result->fetch_assoc()) {
    echo "<p><strong>" . htmlspecialchars($row['user_name']) . ":</strong> " . htmlspecialchars($row['message']) . "</p>";
}
?>