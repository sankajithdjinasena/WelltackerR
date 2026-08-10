<?php
include 'config.php';
session_start();

if (!isset($_SESSION['reset_email'])) {
    header("Location: forget.php");
    exit();
}

$alert_script = '';

if (isset($_POST['verify_otp'])) {
    $entered_otp = trim($_POST['otp']);

    if (isset($_SESSION['reset_otp']) && $entered_otp === (string)$_SESSION['reset_otp']) {
        $alert_script = "
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Success!',
                text: 'OTP Verified. You can now reset your password.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'reset_password.php';
            });
        });
        </script>";
    } else {
        $alert_script = "
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Error!',
                text: 'Invalid OTP!',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
        </script>";
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
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <?php echo $alert_script; ?>
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
    width: 100px;
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
    <h2>Verify OTP</h2>
    <form action="verify_otp.php" method="post">
        <label for="otp">Enter OTP:</label>
        <input type="text" name="otp" id="otp" maxlength="6" required>
        <div style="margin-bottom: 10px;"></div>
        <input type="submit" name="verify_otp" value="Verify" class="login-submit-btn">
    </form>
    <div class="otp-info">
        <p>Enter the OTP sent to your registered email: <strong><?php echo $_SESSION['reset_email']; ?></strong></p>
        <p>If you didn't receive the OTP, please check your spam folder or <a href="forgot_password.php">request a new one</a>.</p>
        
    </div>
    </div>
</div>    
<footer style="margin-top: 185px;">
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
        <p>&copy; 2026 WellTrackeR. All rights reserved.</p>
    </footer>

</body>
</html>
