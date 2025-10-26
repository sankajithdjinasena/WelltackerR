<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WellTrackeR | Doctor Portal</title>
    <link rel="icon" type="image/png" href="image/Logo_R.png">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/patient.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/doctor.css">
</head>

<body>
<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.php");
    exit();
}
?>
<nav>
    <div class="nav-header">
        <div class="nav-logo"><img src="image/Logo_R.png" alt="Logo"></div>
        <div class="nav-title">
            <h1 style="font-size: 24px;">Doctor Portal</h1>
        </div>
    </div>

    <i class='bx bx-menu menu-toggle'></i>

    <div class="nav-links">
        <a id="openProfileBtn" class="register-btn" style="cursor: pointer;">
            <?php echo $_SESSION["first_name"] ." ".$_SESSION["last_name"]?>
        </a>
        <?php
        $status = $_SESSION['verification_status'] ?? 'Pending';

        $color = match($status) {
            'Verified' => 'lightgreen',
            'Pending'  => 'yellow',
            'Rejected' => 'red',
            default    => 'gray'
        };
        ?>
        <a id="openVerificationBtn" class="register-btn" style="color: <?php echo $color; ?>; background-color:black; cursor: pointer;">
            Status: <?php echo htmlspecialchars($status); ?>
        </a>
        <a href="logout.php" class="login-btn">Logout</a>
    </div>
</nav>

<!-- User Profile Dialog -->
<div id="userinfoDialog" class="userinfo-dialog">
  <div class="userinfo-content">
    <span class="userinfo-close">&times;</span>
    <h2>User Profile</h2>

    <form id="userinfoForm" method="POST" action="update_profile.php">
      <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">

      <label>First Name:</label>
      <input type="text" name="first_name" value="<?php echo $_SESSION['first_name']; ?>" required>

      <label>Last Name:</label>
      <input type="text" name="last_name" value="<?php echo $_SESSION['last_name']; ?>" required>

      <label>Email:</label>
      <input type="email" name="email" value="<?php echo $_SESSION['email']; ?>" required>

      <label>Role:</label>
      <input type="text" value="<?php echo $_SESSION['role']; ?>" disabled>

      <button type="submit" class="userinfo-save-btn">Save Changes</button>
    </form>
  </div>
</div>

<!-- Verification Dialog -->
<?php if($_SESSION['role'] === 'doctor'): ?>
<div id="verificationDialog" class="userinfo-dialog">
    <div class="userinfo-content">
        <span class="userinfo-close" id="closeVerification">&times;</span>
        <h2>Verification Status</h2>
        <p>Status: <strong><?php echo $_SESSION['verification_status']; ?></strong></p>

        <?php if(!empty($_SESSION['verification_details'])): ?>
            <p>Submitted Details: <?php echo nl2br($_SESSION['verification_details']); ?></p>
        <?php endif; ?>

        <?php if($_SESSION['verification_status'] === 'pending'): ?>
            <p style="color:orange;">Your verification is under review. Some features are locked until approved by admin.</p>
        <?php elseif($_SESSION['verification_status'] === 'rejected'): ?>
            <p style="color:red;">Your verification was rejected. Please contact admin.</p>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<div class="patient-portal-container">
    <div class="patient-portal-header">
        <h1>Doctor Portal</h1>
        <p>Dr. <?php echo $_SESSION["first_name"] ." ".$_SESSION["last_name"]?> you have 12 patients requiring attention.</p>
        <div class="patient-portal-nav-buttons">
                <button class="patient-portal-nav-btn active">
                    <i class='bx bx-calendar'></i> Today's Overview
                </button>
                <button class="patient-portal-nav-btn active">
                    <i class='bx bx-calendar'></i> About me
                </button>
            </div>
    </div>
    

    <?php if($_SESSION['verification_status'] === 'verified'): ?>
    <!-- Full Portal -->
    <div class="vitals-grid">
        <div class="vital-card">
            <div class="vital-header">
                <span class="vital-title">Active Patients</span>
            </div>
            <div class="vital-value">127</div>
        </div>

        <div class="vital-card">
            <div class="vital-header">
                <span class="vital-title"><div style="color:red;">Critical Alerts</div></span>
            </div>
            <div class="vital-value">5</div>
        </div>

        <div class="vital-card">
            <div class="vital-header">
                <span class="vital-title">Appointments Today</span>
            </div>
            <div class="vital-value">8</div>
        </div>
    </div>

    <div class="activity">
            <h3>Recent Patient Activity</h3>
            <div class="patient">
                <div class="patient-info">
                    <strong>Patient #001</strong>
                    <span>Blood pressure: 145/95 mmHg</span>
                </div>
                <button>View Details</button>
            </div>
            <div class="patient">
                <div class="patient-info">
                    <strong>Patient #002</strong>
                    <span>Blood pressure: 145/95 mmHg</span>
                </div>
                <button>View Details</button>
            </div>
            <div class="patient">
                <div class="patient-info">
                    <strong>Patient #003</strong>
                    <span>Blood pressure: 145/95 mmHg</span>
                </div>
                <button>View Details</button>
            </div>
        </div>
    <?php else: ?>
    <!-- Limited Access for Pending/Rejection -->
    <p style="color:orange; text-align:center; margin-top:20px;">
        Your account is pending verification. Full portal features are locked.
    </p>
    <?php endif; ?>
</div>

<footer>
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

<script src="js/script.js"></script>
<script src="js/doctordialogbox.js"></script>
</body>
</html>
