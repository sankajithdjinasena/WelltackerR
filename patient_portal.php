<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WellTrackeR | Patient Portal</title>
    <link rel="icon" type="image/png" href="image/Logo_R.png">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/patient.css">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.html");
    exit();
}
?>
    <nav>
        <div class="nav-header">
            <div class="nav-logo"><img src="image/Logo_R.png" alt="Logo"></div>
            <div class="nav-title">
                <h1 style="font-size: 24px;">Patient Portal</h1>
            </div>
        </div>

        <!-- Hamburger Menu -->
        <i class='bx bx-menu menu-toggle'></i>

        <div class="nav-links">
            <a id="openProfileBtn" class="register-btn"><?php echo $_SESSION["first_name"] ." ".$_SESSION["last_name"]?></a>
            <a href="login.php" class="login-btn">Logout</a>
        </div>
    </nav>

    <!-- Profile Dialog -->
<!-- User Info Dialog -->
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



    <div class="patient-portal-container">
        <!-- Header -->
        <div class="patient-portal-header">
            <h1>Patient Portal</h1>
            <p>Welcome back, <?php echo $_SESSION["first_name"] ." ".$_SESSION["last_name"]?>! Here's your health overview.</p>
            <div class="patient-portal-nav-buttons">
                <button class="patient-portal-nav-btn active">
                    <i class='bx bx-calendar'></i> Today's Overview
                </button>
                <button class="patient-portal-nav-btn">
                    <i class='bx bx-folder'></i> Medical History
                </button>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h2>Quick Actions</h2>
            <button class="add-btn" id="openDialog">
                <i class='bx bx-plus'></i> Add Today's Vitals
            </button>
        </div>

        <div class="vitals-dialog" id="vitalsDialog">
            <div class="dialog-content">
                <span class="close-dialog" id="closeDialog">&times;</span>
                <h2>Add Today's Vitals</h2>

                <form>
                    <div class="form-group">
                        <label>Blood Pressure (mmHg)</label>
                        <input type="text" placeholder="120/80" required>
                    </div>

                    <div class="form-group">
                        <label>Heart Rate (bpm)</label>
                        <input type="number" placeholder="Enter heart rate" required>
                    </div>

                    <div class="form-group">
                        <label>Blood Sugar (mg/dL)</label>
                        <input type="number" placeholder="Enter blood sugar level" required>
                    </div>

                    <div class="form-group">
                        <label>Weight (kg)</label>
                        <input type="number" step="0.1" placeholder="Enter weight" required>
                    </div>                

                    <div class="form-group">
                        <label>Notes</label>
                        <textarea placeholder="Add any notes..."></textarea>
                    </div>

                    <button type="submit" class="submit-btn">Save Vitals</button>
                </form>
            </div>
        </div>

        <!-- Vitals Cards -->
        <div class="vitals-grid">
            <div class="vital-card">
                <div class="vital-header">
                    <span class="vital-title">Blood Pressure</span>
                    <div class="vital-icon icon-blue">
                        <i class='bx bx-heart'></i>
                    </div>
                </div>
                <div class="vital-value">
                    120/80<span class="vital-unit">mmHg</span>
                </div>
                <div class="vital-change change-negative">
                    <i class='bx bx-down-arrow-alt'></i> 2.5% from last week
                </div>
            </div>

            <div class="vital-card">
                <div class="vital-header">
                    <span class="vital-title">Heart Rate</span>
                    <div class="vital-icon icon-cyan">
                        <i class='bx bx-pulse'></i>
                    </div>
                </div>
                <div class="vital-value">
                    72<span class="vital-unit">bpm</span>
                </div>
                <div class="vital-change change-positive">
                    <i class='bx bx-up-arrow-alt'></i> 1.2% from last week
                </div>
            </div>

            <div class="vital-card">
                <div class="vital-header">
                    <span class="vital-title">Blood Sugar</span>
                    <div class="vital-icon icon-red">
                        <i class='bx bx-droplet'></i>
                    </div>
                </div>
                <div class="vital-value">
                    95<span class="vital-unit">mg/dL</span>
                </div>
                <div class="vital-change change-neutral">
                    <i class='bx bx-minus'></i> 0% from last week
                </div>
            </div>

            <div class="vital-card">
                <div class="vital-header">
                    <span class="vital-title">Weight</span>
                    <div class="vital-icon icon-purple">
                        <i class='bx bx-body'></i>
                    </div>
                </div>
                <div class="vital-value">
                    70.5<span class="vital-unit">kg</span>
                </div>
                <div class="vital-change change-negative">
                    <i class='bx bx-down-arrow-alt'></i> 0.8% from last week
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-section">
            <div class="chart-card">
                <div class="chart-header">
                    <h3>Blood Pressure Trends</h3>
                    <p>Your blood pressure readings over the last 30 days</p>
                </div>
                <div class="chart-placeholder">
                    <i class='bx bx-bar-chart-alt-2 chart-icon'></i>
                    <p>Chart visualization will be displayed here</p>
                    <p>Integration with Chart.js coming soon</p>
                </div>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <h3>Weight Progress</h3>
                    <p>Weight tracking and BMI calculations</p>
                </div>
                <div class="chart-placeholder">
                    <i class='bx bx-line-chart chart-icon'></i>
                    <p>Chart visualization will be displayed here</p>
                    <p>Integration with Chart.js coming soon</p>
                </div>
            </div>
        </div>
    </div>

    <section class="features-section">
        <h2>AI Health Insights</h2>
        <p>Advanced features designed to revolutionize how you monitor and manage health data</p>

        <div class="features-grid">
            <div class="feature-card">
                <i class='bx bx-pulse'></i>
                <h3>Real-time Vitals Tracking</h3>
                <p>Monitor blood pressure, heart rate, blood sugar, and weight with intelligent trend analysis</p>
                <div class="ai-links">
                    <a href="index.html" class="ai-btn">Check</a>
                </div>
            </div>

            <div class="feature-card">
                <i class='bx bx-trending-up'></i>
                <h3>AI Health Insights</h3>
                <p>Get personalized recommendations and early risk detection powered by machine learning</p>
                <div class="ai-links">
                    <a href="index.html" class="ai-btn">Check</a>
                </div>
            </div>

            <div class="feature-card">
                <i class='bx bx-shield'></i>
                <h3>Secure & Private</h3>
                <p>Enterprise-grade security ensures your health data remains confidential and protected</p>
                <div class="ai-links">
                    <a href="index.html" class="ai-btn">Check</a>
                </div>
            </div>
        </div>
    </section>



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
            <a href="privacy.html">Privacy Policy</a>
            <a href="terms.html">Terms of Service</a>
            <a href="contact.html">Contact Us</a>
        </div>
        <p>&copy; 2025 WellTrackeR. All rights reserved.</p>
    </footer>
</body>
<script src="js/script.js"></script>
<script src="js/patientdialogbox.js"></script>

</html>