<?php
include 'config.php';
session_start();

// Redirect if not a doctor
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
  header("Location: login.php");
  exit();
}

$total_users = $conn->query("SELECT COUNT(*) AS count FROM users")->fetch_assoc()['count']; # used to retrieve the next row from a database result set as an associative array, where the column names serve as the array's keys
$total_doctors = $conn->query("SELECT COUNT(*) AS count FROM users WHERE role='Doctor'")->fetch_assoc()['count'];
$total_patients = $conn->query("SELECT COUNT(*) AS count FROM users WHERE role='Patient'")->fetch_assoc()['count'];
$verified_doctors = $conn->query("SELECT COUNT(*) AS count FROM doctor_verifications WHERE verification_status='Verified'")->fetch_assoc()['count'];

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

<style>
    .nav-links a.login-btn{
      color: var(--text-light);
    }
    .nav-links a.login-btn:hover{
      background-color: var(--text-light);
      color: var(--pcolor);
    }
</style>

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
      <p>System Overview: <?php echo $total_users ?> active users, <?php echo $total_doctors ?> doctor/s available.</p>
    </div>

    <!-- Vitals Cards -->
    <div class="vitals-grid" style="color:#000">
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
          <div class="menu-item" data-dialog="patientsDialog">
            <i class='bx bx-user'></i>
            <span>Manage Patients</span>
          </div>
          <div class="menu-item" data-dialog="doctorsDialog">
            <i class='bx bx-user-plus'></i>
            <span>Manage Doctors</span>
          </div>
          <div class="menu-item" data-dialog="settingsDialog">
            <i class='bx bx-user'></i>
            <span>Register Admin</span>
          </div>
        </div>
      </div>

      <div class="section-card">
        <div class="section-header">
          <h2>Reviews and Comments</h2>
          <p>Manage reviews and reply comments</p>
        </div>
        <div class="menu-list">
          <div class="menu-item" data-dialog="removeDialog">
            <i class='bx bx-trash'></i>
            <span>Remove Comments</span>
          </div>
          <div class="menu-item" data-dialog="contactDialog">
            <i class='bx bx-chat'></i>
            <span>Contact Messages</span>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Patients -->
  <div class="vitals-dialog" id="patientsDialog">
    <div class="dialog-content">
      <span class="close-dialog">&times;</span>
      <h2>Manage Patients</h2>
      <p style="color: #000;">Here you can view and manage all patients’ records.</p>
      <a href="view_users.php" style="text-decoration: none;">-> View Users</a>
    </div>
  </div>

  <!-- Doctors -->
  <div class="vitals-dialog" id="doctorsDialog">
    <div class="dialog-content">
      <span class="close-dialog">&times;</span>
      <h2>Manage Doctors</h2>
      <p style="color: #000;">Review the Doctors in WellTrackeR</p>
      <a href="view_doctors.php" style="text-decoration: none;">-> View Doctors</a>
    </div>
  </div>

  <!-- Settings -->
  <div class="vitals-dialog" id="settingsDialog">
    <div class="dialog-content">
      <span class="close-dialog">&times;</span>
      <h2>Register Admin</h2>
      <p style="color: #000;">Register new admin for WellTrackeR</p>
      <a href="register_admin.php" style="text-decoration: none;">-> Register Admin</a>
    </div>
  </div>


  <!-- Remove Comments -->
  <div class="vitals-dialog" id="removeDialog">
    <div class="dialog-content">
      <span class="close-dialog">&times;</span>
      <h2>Remove Comments</h2>
      <p style="color: #000;">View and delete inappropriate or unwanted comments.</p>
      <a href="view_community_posts.php" style="text-decoration: none;">-> Manage posts</a><br><br>
      <a href="view_reply.php" style="text-decoration: none;">-> Manage Replies</a>


    </div>
  </div>

  <!-- Contact Messages -->
  <div class="vitals-dialog" id="contactDialog">
    <div class="dialog-content">
      <span class="close-dialog">&times;</span>
      <h2>Contact Messages</h2>
      <p style="color: #000;">View messages submitted through the contact form.</p>
      <a href="view_contact_messages.php" style="text-decoration: none;">-> View Messages</a>
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
<script src="js/adminbox.js"></script>

</html>