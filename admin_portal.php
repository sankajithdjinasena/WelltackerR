<?php
    include 'config.php';
    session_start();

    // Redirect if not a doctor
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
        header("Location: login.php");
        exit();
    }

    $total_users = $conn->query("SELECT COUNT(*) AS count FROM users")->fetch_assoc()['count'];
$total_doctors = $conn->query("SELECT COUNT(*) AS count FROM users WHERE role='Doctor'")->fetch_assoc()['count'];
$total_patients = $conn->query("SELECT COUNT(*) AS count FROM users WHERE role='Patient'")->fetch_assoc()['count'];
$verified_doctors = $conn->query("SELECT COUNT(*) AS count FROM users WHERE role='Doctor' AND verification_status='Verified'")->fetch_assoc()['count'];


    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WellTrackeR | Admin Portal</title>
    <link rel="icon" type="image/png" href="image/Logo_R.png">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/patient.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <nav>
        <div class="nav-header">
            <div class="nav-logo"><img src="image/Logo_R.png" alt="Logo"></div>
            <div class="nav-title">
                <h1 style="font-size: 24px;">Admin Portal</h1>
            </div>
        </div>

        <!-- Hamburger Menu -->
        <i class='bx bx-menu menu-toggle'></i>

        <div class="nav-links">
<a id="openProfileBtn" class="register-btn" style="cursor: pointer;">
                <?php echo $_SESSION["first_name"] . " " . $_SESSION["last_name"] ?>
            </a>            
            <a href="login.php" class="login-btn">Logout</a>
        </div>
    </nav>

    <div class="patient-portal-container">
        <!-- Header -->
        <div class="patient-portal-header">
            <h1>Admin Portal</h1>
            <p>System Overview: 1,247 active users, 45 doctors online.</p>
            <div class="patient-portal-nav-buttons">
                <button class="patient-portal-nav-btn active">
                    <i class='bx bx-calendar'></i> Today's Overview
                </button>
                <button class="patient-portal-nav-btn">
                    <i class='bx bx-stats'></i> Analytics
                </button>
            </div>
        </div>


        <!-- Vitals Cards -->
    <div class="vitals-grid">
        <div class="vital-card">
            <h3>Total Users</h3>
            <div class="vital-value"><?php echo $total_users; ?></div>
        </div>
        <div class="vital-card">
            <h3>Total Doctors</h3>
            <div class="vital-value"><?php echo $total_doctors; ?></div>
        </div>
        <div class="vital-card">
            <h3>Verified Doctors</h3>
            <div class="vital-value"><?php echo $verified_doctors; ?></div>
        </div>
        <div class="vital-card">
            <h3>Total Patients</h3>
            <div class="vital-value"><?php echo $total_patients; ?></div>
        </div>
    </div>



        <div class="content-grid">
            <div class="section-card">
                <div class="section-header">
                    <h2>User Management</h2>
                    <p>Manage patients and healthcare providers</p>
                </div>
                <div class="menu-list">
                    <div class="menu-item">
                        <i class='bx bx-user'></i>
                        <span>Manage Patients</span>
                    </div>
                    <div class="menu-item">
                        <i class='bx bx-user-plus'></i>
                        <span>Manage Doctors</span>
                    </div>
                    <div class="menu-item">
                        <i class='bx bx-cog'></i>
                        <span>System Settings</span>
                    </div>
                </div>
            </div>

            <div class="section-card">
                <div class="section-header">
                    <h2>Reports & Analytics</h2>
                    <p>Generate health insights and system reports</p>
                </div>
                <div class="menu-list">
                    <div class="menu-item">
                        <i class='bx bx-pulse'></i>
                        <span>User Activity Report</span>
                    </div>
                    <div class="menu-item">
                        <i class='bx bx-trash'></i>
                        <span>Remove Comments</span>
                    </div>
                    <div class="menu-item">
                        <i class='bx bx-chat'></i>
                        <span>Contact Messages</span>
                    </div>
                </div>
            </div>
        </div>
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
</body>
<script src="js/script.js"></script>

</html>