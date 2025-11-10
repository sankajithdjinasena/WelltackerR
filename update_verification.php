<?php
include 'config.php';
session_start();

// Allow only Admins
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    http_response_code(403);
    echo "Unauthorized";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['doctor_id'], $_POST['status'])) {
    $doctor_id = intval($_POST['doctor_id']);
    $status = $_POST['status'];

    $valid_status = ['Pending', 'Verified', 'Rejected'];
    if (in_array($status, $valid_status)) {
        $verified_at = ($status === 'Verified') ? date('Y-m-d H:i:s') : null;

        // Prepare query
        $sql = "UPDATE doctor_verifications 
                SET verification_status = ?, verified_at = ? 
                WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $status, $verified_at, $doctor_id);

        if ($stmt->execute()) {
            header("location:view_doctors.php");
        } else {
            http_response_code(500);
            echo "Database error: " . $conn->error;
        }
    } else {
        http_response_code(400);
        echo "Invalid status";
    }
} else {
    http_response_code(400);
    echo "Invalid request";
}
?>
