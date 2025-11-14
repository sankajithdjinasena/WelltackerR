<?php
session_start();
include 'config.php';

if (!isset($_SESSION["user_id"])) {
    die("Not logged in");
}

$doctor_id = $_SESSION["user_id"];
$patient_id = $_POST["patient_id"];
$note = $_POST["note"];

$sql = "INSERT INTO doctor_notes (patient_id, doctor_id, note) 
        VALUES ('$patient_id', '$doctor_id', '$note')";

if ($conn->query($sql)) {
    echo "success";
} else {
    echo "error";
}
?>
