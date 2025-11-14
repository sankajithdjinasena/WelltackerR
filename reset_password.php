<?php
include 'config.php';
echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
session_start();

if (!isset($_SESSION['reset_email'])) {
    header("Location: forget.php");
    exit();
}

if (isset($_POST['update_password'])) {
    if ($_POST['new_password'] !== $_POST['confirm_new_password']) {
        echo "<script>alert('Password doesn't matched');</script>";
    } else {
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $email = $_SESSION['reset_email'];

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $new_password, $email);

        if ($stmt->execute()) {
            unset($_SESSION['reset_email'], $_SESSION['reset_otp']);
            echo "<script>
            alert('Password updated successfully! Please login with your new password.');
            window.location.href = 'login.php';
            </script>";
        } else {
            echo "<script>
            alert('Error updating password. Please try again.');
            window.location.href = 'reset_password.php';
            </script>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WelltrackeR | Forget Password</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" type="image/png" href="image/Logo_R.png">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<style>
    .login-submit-btn {
    background-color: transparent;
    color: #1abc9c;
    border: 2px solid #1abc9c;
    padding: 6px 18px;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    width: 170px;
}

.login-submit-btn:hover {
    background-color: #1abc9c;
    color: #fff;
    transform: scale(1.05);
}
</style>
<body>
    <nav>
        <div class="nav-header">
            <div class="nav-logo"><img src="image/Logo_R.png" alt="Logo"></div>
            <div class="nav-title">
                <h1>WellTrackeR</h1>
            </div>
        </div>

        <!-- Hamburger Menu -->
        <i class='bx bx-menu menu-toggle'></i>

        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="about.php">About</a>
            <a href="community.php">Community</a>
            <a href="contact.php">Contact</a>
            <a href="login.php" class="login-btn" id="active">Login</a>
            <a href="register.php" class="register-btn">Register</a>
        </div>

    </nav>

<div class="login-contact-section">
    <div class="login-contact-form">
    <h2>Reset Your Password</h2>
    <form action="reset_password.php" method="post" id="resetForm">
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" id="new_password" required>

        <label for="confirm_new_password">Confirm New Password:</label>
        <input type="password" name="confirm_new_password" id="confirm_new_password" required>
        <div style="margin-bottom: 10px;"></div>
        <input type="submit" name="update_password" value="Update Password" class="login-submit-btn">
    </form>
    </div>
</div>    
<footer style="margin-top: 175px;">
        <div class="social">
            <h2>Follow us</h2>
            <div class="social-media">
                <a href="#"> <i class='bx bxl-facebook'></i></a>
                <a href="#"> <i class='bx bxl-instagram'></i></a>
                <a href="#"> <i class='bx bxl-twitter'></i></a>
            </div>
        </div>

        <div class="footer-links">
            <a href="privacy.php">Privacy Policy</a>
            <a href="terms.php">Terms of Service</a>
            <a href="contact.php">Contact Us</a>
        </div>
        <p>&copy; 2025 WellTrackeR. All rights reserved.</p>
    </footer>
<script>
const form = document.getElementById('resetForm');
const newPassword = document.getElementById('new_password');
const confirmNewPassword = document.getElementById('confirm_new_password');

form.addEventListener('submit', (e) => {
    if (newPassword.value !== confirmNewPassword.value) {
        e.preventDefault();
        Swal.fire({
            title: 'Error!',
            text: 'Passwords do not match!',
            icon: 'error',
            confirmButtonText: 'Try Again'
        });
    }
});
</script>

</body>
</html>
