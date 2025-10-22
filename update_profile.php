<?php
session_start();
include 'config.php';

$user_id = $_POST['user_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];

// Check if email exists for another user
$stmt = $conn->prepare("SELECT id FROM users WHERE email=? AND id!=?");
$stmt->bind_param("si", $email, $user_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "<script>alert('Email already exists. Please choose another.'); window.history.back();</script>";
    exit;
}

// Update user details
$stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, email=? WHERE id=?");
$stmt->bind_param("sssi", $first_name, $last_name, $email, $user_id);

if ($stmt->execute()) {
    // Update session variables
    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name'] = $last_name;
    $_SESSION['email'] = $email;

    echo "<script>alert('Profile updated successfully!'); window.location='".$_SERVER['HTTP_REFERER']."';</script>";
} else {
    echo "<script>alert('Error updating profile.'); window.history.back();</script>";
}
$stmt->close();
$conn->close();
?>
