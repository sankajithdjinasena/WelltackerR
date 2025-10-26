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
include 'config.php';
session_start();

// Redirect if not a doctor
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Doctor') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch latest verification submission (if any)
$verification_stmt = $conn->prepare("SELECT * FROM doctor_verifications WHERE user_id = ? ORDER BY submitted_at DESC LIMIT 1");
$verification_stmt->bind_param("i", $user_id);
$verification_stmt->execute();
$verification_result = $verification_stmt->get_result();
$latest_verification = $verification_result->fetch_assoc();

// Update session to match latest verification status
if (!empty($latest_verification)) {
    $_SESSION['verification_status'] = $latest_verification['verification_status'];
} else {
    $_SESSION['verification_status'] = 'Pending';
}

$status = $_SESSION['verification_status'];
$color = match ($status) {
    'Verified' => 'lightgreen',
    'Pending'  => 'yellow',
    'Rejected' => 'red',
    default    => 'gray'
};
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
            <?php echo $_SESSION["first_name"] . " " . $_SESSION["last_name"] ?>
        </a>
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
<?php if ($_SESSION['role'] === 'Doctor'): ?>
<div id="verificationDialog" class="userinfo-dialog">
    <div class="userinfo-content">
        <span class="userinfo-close" id="closeVerification">&times;</span>
        <h2>Verification Status</h2>
        <p>Status: <strong><?php echo $status; ?></strong></p>

        <?php if (!empty($latest_verification)): ?>
            <p><strong>License Number:</strong> <?php echo htmlspecialchars($latest_verification['license_number']); ?></p>
            <p><strong>Specialization:</strong> <?php echo htmlspecialchars($latest_verification['specialization']); ?></p>
            <?php if (!empty($latest_verification['notes'])): ?>
                <p><strong>Notes:</strong> <?php echo nl2br(htmlspecialchars($latest_verification['notes'])); ?></p>
            <?php endif; ?>
            <?php if (!empty($latest_verification['document_file'])): ?>
                <p><strong>Document:</strong> <a href="<?php echo $latest_verification['document_file']; ?>" target="_blank">View</a></p>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ($status === 'Pending'): ?>
            <p style="color:orange;">Your verification is under review. Some features are locked until approved by admin.</p>
        <?php elseif ($status === 'Rejected'): ?>
            <p style="color:red;">Your verification was rejected. Please contact admin.</p>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<!-- Verification Form Popup -->
<div id="verificationFormDialog" class="userinfo-dialog" style="display: none;">
    <div class="userinfo-content">
        <span class="userinfo-close" id="closeVerificationForm">&times;</span>
        <h2>Doctor Verification Form</h2>

        <form id="verificationForm" method="POST" action="submit_verification.php" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">

            <label>License Number:</label>
            <input type="text" name="license_number" required>

            <label>Specialization:</label>
            <input type="text" name="specialization" required>

            <label>Notes (optional):</label>
            <textarea name="notes"></textarea>

            <label>Upload License / Certificate:</label>
            <input type="file" name="document_file" accept=".pdf,.jpg,.png" required>

            <button type="submit" class="userinfo-save-btn">Submit for Verification</button>
        </form>
    </div>
</div>

<div class="patient-portal-container">
    <div class="patient-portal-header">
        <h1>Doctor Portal</h1>
        <p>Dr. <?php echo $_SESSION["first_name"] . " " . $_SESSION["last_name"] ?> you have 12 patients requiring attention.</p>
        <div class="patient-portal-nav-buttons">
            <button id="openVerificationFormBtn" class="patient-portal-nav-btn active">
                <i class='bx bx-calendar'></i> Verified Portal
            </button>
        </div>
    </div>

    <?php if ($status === 'Verified'): ?>
        <!-- Full Portal -->
        <div class="vitals-grid">
            <div class="vital-card">
                <div class="vital-header"><span class="vital-title">Active Patients</span></div>
                <div class="vital-value">127</div>
            </div>
            <div class="vital-card">
                <div class="vital-header"><span class="vital-title" style="color:red;">Critical Alerts</span></div>
                <div class="vital-value">5</div>
            </div>
            <div class="vital-card">
                <div class="vital-header"><span class="vital-title">Appointments Today</span></div>
                <div class="vital-value">8</div>
            </div>
        </div>

        <div class="activity">
            <h3>Recent Patient Activity</h3>
            <div class="patient">
                <div class="patient-info"><strong>Patient #001</strong><span>Blood pressure: 145/95 mmHg</span></div>
                <button>View Details</button>
            </div>
            <div class="patient">
                <div class="patient-info"><strong>Patient #002</strong><span>Blood pressure: 145/95 mmHg</span></div>
                <button>View Details</button>
            </div>
            <div class="patient">
                <div class="patient-info"><strong>Patient #003</strong><span>Blood pressure: 145/95 mmHg</span></div>
                <button>View Details</button>
            </div>
        </div>
    <?php elseif ($status === 'Pending'): ?>
        <!-- Limited Access -->
        <p style="color:orange; text-align:center; margin-top:20px;">
            Your account is pending verification. Full portal features are locked.
        </p>
    <?php elseif ($status === 'Rejected'): ?>
        <!-- Access Denied -->
        <p style="color:red; text-align:center; margin-top:20px;">
            Your account verification was rejected. Please contact support.
        </p>
    <?php endif; ?>
</div>

<footer>
    <div class="social">
        <h2>Follow us</h2>
        <div class="social-media">
            <a href="#"><i class='bx bxl-facebook'></i></a>
            <a href="#"><i class='bx bxl-instagram'></i></a>
            <a href="#"><i class='bx bxl-twitter'></i></a>
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
<script src="js/docvertification.js"></script>
</body>
</html>
