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
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Patient') {
        header("Location: login.php");
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
            <a id="openProfileBtn" class="register-btn"><?php echo $_SESSION["first_name"] . " " . $_SESSION["last_name"] ?></a>
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
            <p>Welcome back, <?php echo $_SESSION["first_name"] . " " . $_SESSION["last_name"] ?>! Here's your health overview.</p>
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

                <form method="POST" action="save_vitals.php">
                    <div class="form-group">
                        <label>Blood Pressure (mmHg)</label>
                        <input type="text" name="blood_pressure" placeholder="120/80" required>
                    </div>

                    <div class="form-group">
                        <label>Heart Rate (bpm)</label>
                        <input type="number" name="heart_rate" placeholder="Enter heart rate" required>
                    </div>

                    <div class="form-group">
                        <label>Blood Sugar (mg/dL)</label>
                        <input type="number" name="blood_sugar" placeholder="Enter blood sugar level" required>
                    </div>

                    <div class="form-group">
                        <label>Weight (kg)</label>
                        <input type="number" step="0.1" name="weight" placeholder="Enter weight" required>
                    </div>

                    <div class="form-group">
                        <label>Notes</label>
                        <textarea name="notes" placeholder="Add any notes..."></textarea>
                    </div>

                    <button type="submit" class="submit-btn">Save Vitals</button>
                </form>
            </div>
        </div>

        <div class="vitals-section">
            <h2 class="vitals-section-title" style="padding-left: 20px;">Latest Overview</h2>

            <div class="vitals-grid">
                <?php
                include 'config.php';

                $user_id = $_SESSION['user_id'];

                $sql = "SELECT blood_pressure, heart_rate, blood_sugar, weight, created_at 
                FROM vitals 
                WHERE user_id = ? 
                ORDER BY created_at DESC 
                LIMIT 1";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $latest_vitals = $result->fetch_assoc();

                if (!$latest_vitals) {
                    // No data yet
                    $latest_vitals = [
                        'blood_pressure' => 'N/A',
                        'heart_rate' => 'N/A',
                        'blood_sugar' => 'N/A',
                        'weight' => 'N/A',
                        'created_at' => null
                    ];
                }
                ?>

                <!-- Blood Pressure -->
                <div class="vital-card">
                    <div class="vital-header">
                        <span class="vital-title">Blood Pressure</span>
                        <div class="vital-icon icon-blue">
                            <i class='bx bx-heart'></i>
                        </div>
                    </div>
                    <div class="vital-value">
                        <?php echo htmlspecialchars($latest_vitals['blood_pressure']); ?>
                        <span class="vital-unit">mmHg</span>
                    </div>
                </div>

                <!-- Heart Rate -->
                <div class="vital-card">
                    <div class="vital-header">
                        <span class="vital-title">Heart Rate</span>
                        <div class="vital-icon icon-cyan">
                            <i class='bx bx-pulse'></i>
                        </div>
                    </div>
                    <div class="vital-value">
                        <?php echo htmlspecialchars($latest_vitals['heart_rate']); ?>
                        <span class="vital-unit">bpm</span>
                    </div>
                </div>

                <!-- Blood Sugar -->
                <div class="vital-card">
                    <div class="vital-header">
                        <span class="vital-title">Blood Sugar</span>
                        <div class="vital-icon icon-red">
                            <i class='bx bx-droplet'></i>
                        </div>
                    </div>
                    <div class="vital-value">
                        <?php echo htmlspecialchars($latest_vitals['blood_sugar']); ?>
                        <span class="vital-unit">mg/dL</span>
                    </div>
                </div>

                <!-- Weight -->
                <div class="vital-card">
                    <div class="vital-header">
                        <span class="vital-title">Weight</span>
                        <div class="vital-icon icon-purple">
                            <i class='bx bx-body'></i>
                        </div>
                    </div>
                    <div class="vital-value">
                        <?php echo htmlspecialchars($latest_vitals['weight']); ?>
                        <span class="vital-unit">kg</span>
                    </div>
                </div>
            </div>
        </div>


        <!-- Charts Section -->
        <div class="charts-section">
            <div class="chart-card">
                <div class="chart-header">
                    <h3>Blood Pressure Trends</h3>
                    <p>Your blood pressure readings over time</p>
                </div>
                <canvas id="bpChart"></canvas>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <h3>Weight Progress</h3>
                    <p>Weight tracking and BMI calculations</p>
                </div>
                <canvas id="weightChart"></canvas>
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
            <a href="privacy.php">Privacy Policy</a>
            <a href="terms.php">Terms of Service</a>
            <a href="contact.php">Contact Us</a>
        </div>
        <p>&copy; 2025 WellTrackeR. All rights reserved.</p>
    </footer>
</body>
<script src="js/script.js"></script>
<script src="js/patientdialogbox.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="js/patientchart.js"></script>

</html>