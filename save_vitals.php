<?php
session_start();
include 'config.php'; // include your database connection

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access");
}

$user_id = $_SESSION['user_id'];
$bp = $_POST['blood_pressure'];
$hr = $_POST['heart_rate'];
$bs = $_POST['blood_sugar'];
$wt = $_POST['weight'];
$notes = $_POST['notes'];

$stmt = $conn->prepare("INSERT INTO vitals (user_id, blood_pressure, heart_rate, blood_sugar, weight, notes) 
                        VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isiiis", $user_id, $bp, $hr, $bs, $wt, $notes);

if ($stmt->execute()) {
    echo "<script>alert('Vitals saved successfully!'); window.location.href='patient_portal.php';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
