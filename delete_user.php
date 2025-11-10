<?php
include 'config.php';
session_start();

// Only Admin can delete
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    http_response_code(403);
    echo "Unauthorized";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);

    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

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
