<?php
include 'config.php';
session_start();

// Only Admin can delete
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    http_response_code(403);
    echo "Unauthorized";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['reply_id'])) {
    $reply_id = intval($_POST['reply_id']);
    $stmt = $conn->prepare("DELETE FROM community_replies WHERE reply_id = ?");
    $stmt->bind_param("i", $reply_id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        http_response_code(500);
        echo "Database error: " . $conn->error;
    }
} else {
    http_response_code(400);
    echo "Invalid request";
}
?>
