<?php
session_start();
include 'config.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['send_otp'])) {
    $email = $_POST['email'];

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $otp = rand(100000, 999999);

        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_otp'] = $otp;

        // Send email via PHPMailer
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'jobsanke26198@gmail.com'; // your Gmail
            $mail->Password = 'ksrc yoxk smej svey'; // app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('support@welltracker.com', 'WellTracker Support');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body = "
            <div style='font-family: Arial; padding: 20px; background:#f9f9f9; border:1px solid #ddd; border-radius:8px;'>
                <h2 style='color:#4CAF50;'>🔐 Password Reset Request</h2>
                <p>Use the OTP below to reset your password:</p>
                <div style='padding:15px; background:#fff; border:1px dashed #4CAF50; text-align:center; border-radius:5px;'>
                    <p style='font-size:24px; font-weight:bold; color:#4CAF50;'>$otp</p>
                </div>
                <p>If you didn't request this, ignore this email.</p>
                <p>Thank you,<br>Welltracker Support</p>
            </div>
            ";

            $mail->send();
            $msg = "OTP sent to your email!";
            header("Location: verify_otp.php?success=" . urlencode($msg));
            exit;

        } catch (Exception $e) {
            $error = "Failed to send OTP. Mailer Error: {$mail->ErrorInfo}";
        }

    } else {
        $error = "No user found with this email.";
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
    width: 150px;
}

.login-submit-btn:hover {
    background-color: #1abc9c;
    color: #fff;
    transform: scale(1.05);
}
</style>
<body>
    <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
<df-messenger
  intent="WELCOME"
  chat-title="WelltrackeR"
  agent-id="9d5f2420-6826-4916-9e73-235b856a1965"
  language-code="en"
></df-messenger>


    <!-- Navbar -->
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

<section class="login-contact-section">
    <div class="login-contact-form">
        <h2>Forgot Password</h2>
        <p>Enter your registered email to receive a One-Time Password (OTP)</p>

        <?php if(isset($error)): ?>
            <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="post">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required placeholder="Enter your email">
            <button type="submit" name="send_otp" class="login-submit-btn">Send OTP</button>
        </form>
        <p style="margin-top:15px;font-size:14px;">
            <a href="login.php" style="color:#16a085;font-weight:600;">Back to Login</a>
        </p>
    </div>
</section>
<!-- Footer -->
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

</body>
<script src="js/script.js"></script>

</html>
