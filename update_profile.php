<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

$user_id    = $_POST['user_id'];
$first_name = $_POST['first_name'];
$last_name  = $_POST['last_name'];
$email      = $_POST['email'];
$telephone  = $_POST['telephone'];

// Determine return page
$return_url = $_SERVER['HTTP_REFERER'];

// Check if email exists for another user
$stmt = $conn->prepare("SELECT id FROM users WHERE email=? AND id!=?");
$stmt->bind_param("si", $email, $user_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "<script>alert('Email already exists. Please choose another.'); window.location.href='$return_url';</script>";
    exit;
}

// Update user details
$stmt = $conn->prepare(
    "UPDATE users SET first_name=?, last_name=?, email=?, telephone=? WHERE id=?"
);
$stmt->bind_param("ssssi", $first_name, $last_name, $email, $telephone, $user_id);

if ($stmt->execute()) {

    // Update session variables
    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name']  = $last_name;
    $_SESSION['email']      = $email;
    $_SESSION['telephone']  = $telephone;

    // ✅ Redirect back
    header("Location: $return_url");
    exit;

} else {
    echo "<script>alert('Error updating profile.'); window.location.href='$return_url';</script>";
}

$stmt->close();
$conn->close();
?>
