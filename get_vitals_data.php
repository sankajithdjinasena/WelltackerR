<?php
session_start();
include 'config.php';

$user_id = $_SESSION['user_id'];

$query = "SELECT DATE(created_at) as date, blood_pressure, heart_rate, blood_sugar, weight 
          FROM vitals WHERE user_id = ? ORDER BY created_at ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>
