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

<style>
            .nav-links a.login-btn{
  color: var(--text-light);
}
.nav-links a.login-btn:hover{
  background-color: var(--text-light);
  color: var(--pcolor);
}
    .health-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        backdrop-filter: blur(2px);
    }

    .health-modal-content {
        background: #fff;
        padding: 30px 40px;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        max-width: 450px;
        width: 90%;
        position: relative;
        animation: fadeIn 0.3s ease;
        max-height: 82vh;
        overflow-y: auto;
    }

    .health-modal-content h2 {
        color: var(--g2color, #333);
        text-align: center;
        margin-bottom: 20px;
    }

    .health-modal-close {
        position: absolute;
        top: 12px;
        right: 20px;
        font-size: 26px;
        cursor: pointer;
        color: #888;
        transition: color 0.2s ease;
    }

    .health-modal-close:hover {
        color: #e74c3c;
    }

    .health-modal .form-group {
        margin-bottom: 15px;
    }

    .health-modal label {
        display: block;
        font-weight: 600;
        margin-bottom: 5px;
        color: #333;
    }

    .health-modal input,
    .health-modal textarea {
        width: 100%;
        padding: 10px 12px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 15px;
        outline: none;
        transition: border-color 0.2s ease;
    }

    .health-modal input:focus,
    .health-modal textarea:focus {
        border-color: var(--g1color, #007bff);
    }

    .health-submit {
        width: 100%;
        padding: 12px 25px;
        border-radius: 25px;
        border: none;
        background-color: var(--g1color, #007bff);
        color: #fff;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .health-submit:hover {
        background-color: var(--g2color, #0056b3);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<body>
    <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
    <df-messenger
        intent="WELCOME"
        chat-title="WelltrackeR"
        agent-id="9d5f2420-6826-4916-9e73-235b856a1965"
        language-code="en"></df-messenger>

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

        <div id="pdf-extra" style="display: none;">
            <style>
                #pdf-extra {
                    display: none;
                    /* hidden on website */
                    background: #ffffff;
                    padding: 20px;
                    width: 100%;
                    box-sizing: border-box;
                    border-bottom: 2px solid #ddd;
                    font-family: Arial, sans-serif;
                }

                /* Header section inside PDF */
                #pdf-extra .header_ {
                    display: flex;
                    align-items: center;
                    gap: 15px;
                    margin-bottom: 15px;
                }

                #pdf-extra .header_ img {
                    width: 60px;
                    /* adjusts logo size */
                    height: auto;
                }

                #pdf-extra h1 {
                    font-size: 30px;
                    color: #333;
                    margin: 0;
                }

                /* Basic info box */
                #pdf-extra .info-box {
                    margin-top: 10px;
                    padding: 15px;
                    background: #f7f7f7;
                    border-radius: 6px;
                    border: 1px solid #ddd;
                }

                #pdf-extra .info-box p {
                    margin: 5px 0;
                    color: #444;
                    font-size: 24px;
                }
            </style>
            <div class="header_">
                <img src="image/Logo_R.png">
                <h1>WellTrackeR – Health Summary Report</h1>
            </div>

            <div class="info-box">
                <p><strong>Name:</strong> <?= $_SESSION["first_name"] . " " . $_SESSION["last_name"] ?></p>
                <p><strong>Email:</strong> <?= $_SESSION["email"] ?></p>
                <p><strong>Date:</strong> <?= date("Y-m-d") ?></p>
            </div>
        </div>


        <!-- Quick Actions -->
        <div class="quick-actions">
            <h2>Toady Vitals</h2>
            <button class="add-btn" id="openDialog" title="Add Today's Vitals">
                <i class='bx bx-plus'></i> Add Today's Vitals
            </button>
        </div>
        <!-- Button Section -->
        <div class="quick-actions">
            <h2>Medical History</h2>
            <button class="add-btn" id="openHistoryDialog" title="Add your past historical medical records">
                <i class='bx bx-plus'></i> Add Medical History
            </button>
        </div>
        <button class="view-btn" id="openViewHistory" style="margin-left:25px" title="View your uploaded medical history records">
            <i class='bx bx-file'></i> View Medical History
        </button>

        <button id="openMessagesBtn" class="view-btn" style="margin-left: 5px;" title="See messages from the Doctors">
            <i class='bx bx-chat'></i> See messages from Doctor</button>


        <!-- Pop-up Dialog -->
        <div class="history-dialog" id="historyDialog">
            <div class="dialog-content">
                <span class="close-dialog" id="closeHistoryDialog">&times;</span>
                <h3>Add Medical History Details</h3>

                <form action="upload_medical_history.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Title:</label>
                        <input type="text" name="title" placeholder="Enter title" required>
                    </div>

                    <div class="form-group">
                        <label>Description:</label>
                        <textarea name="description" rows="3" placeholder="Enter description..."></textarea>
                    </div>

                    <div class="form-group">
                        <label>Upload PDF:</label>
                        <input type="file" name="pdf_file" accept="application/pdf" required>
                    </div>

                    <button type="submit" class="submit-btn">Upload</button>
                </form>
            </div>
        </div>

        <div class="view-history-dialog" id="viewHistoryDialog">
            <div class="dialog-content">
                <span class="close-dialog" id="closeViewHistory">&times;</span>
                <h3>Medical History Records</h3>

                <div class="pdf-list" style="color: #000;">
                    <?php
                    include 'config.php';
                    $user_id = $_SESSION['user_id']; // assume session has user id
                    $sql = "SELECT * FROM medical_history WHERE user_id = '$user_id' ORDER BY uploaded_at DESC";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<div class='pdf-item'>";
                            echo "<h4>" . htmlspecialchars($row['title']) . "</h4>";
                            echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                            echo "<p>Uploaded at: " . htmlspecialchars($row['uploaded_at']) . "</p>";
                            echo "<a href='" . htmlspecialchars($row['pdf_file']) . "' target='_blank' class='pdf-btn'>View PDF</a>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No medical history uploaded yet.</p>";
                    }
                    ?>

                </div>
            </div>
        </div>

        <style>
            /* Common Modal Background */
            .history-dialog,
            .view-history-dialog {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.45);
                justify-content: center;
                align-items: center;
                z-index: 10000;
            }

            /* Dialog Box */
            .dialog-content {
                background: #fff;
                padding: 25px 30px;
                border-radius: 15px;
                width: 420px;
                max-width: 90%;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
                animation: fadeIn 0.3s ease;
                position: relative;
            }


            /* Close Button */
            .close-dialog {
                position: absolute;
                right: 15px;
                top: 10px;
                font-size: 22px;
                cursor: pointer;
                color: #555;
                transition: color 0.2s;
            }

            .close-dialog:hover {
                color: #000;
            }

            /* Headings */
            .dialog-content h3 {
                text-align: center;
                color: var(--g1color, #009879);
                margin-bottom: 20px;
            }

            /* Form Fields */
            .form-group {
                margin-bottom: 15px;
            }

            label {
                font-weight: 600;
                color: #000;
                display: block;
                margin-bottom: 5px;
            }

            .form-group label{
                color: #000;
            }

            input,
            textarea {
                width: 100%;
                padding: 10px 12px;
                border: 1px solid #ccc;
                border-radius: 8px;
                font-size: 15px;
                outline: none;
                transition: border-color 0.2s ease;
            }

            input:focus,
            textarea:focus {
                border-color: var(--g1color, #009879);
            }

            /* Buttons */
            .submit-btn,
            .pdf-btn,
            .view-btn {
                background: var(--g1color, #009879);
                color: #fff;
                border: none;
                padding: 10px 20px;
                border-radius: 25px;
                cursor: pointer;
                font-weight: 600;
                text-decoration: none;
                transition: background 0.3s ease;
            }

            .submit-btn:hover,
            .pdf-btn:hover,
            .view-btn:hover {
                background: var(--g2color, #007f65);
            }

            .action-buttons {
                display: flex;
                gap: 10px;
            }

            /* PDF List */
            .pdf-list {
                max-height: 300px;
                overflow-y: auto;
                padding-right: 5px;
            }

            .pdf-item {
                border-bottom: 1px solid #eee;
                padding: 15px 0;
                margin-bottom: 10px;
            }

            .pdf-item h4 {
                margin: 0 0 5px;
                color: #222;
                font-size: 16px;
            }

            .pdf-item p {
                margin: 0 0 10px;
                font-size: 14px;
                color: #666;
            }

            .pdf-btn {
                display: inline-block;
                margin-top: 5px;
                padding: 8px 20px;
                background: var(--g1color, #009879);
                color: white;
                border-radius: 25px;
                text-decoration: none;
                font-weight: 600;
                transition: 0.3s;
            }

            .delete-btn {
                background: #ff4d4d;
                color: white;
                border: none;
                border-radius: 25px;
                padding: 8px 18px;
                cursor: pointer;
                font-weight: 600;
                transition: 0.3s;
            }

            .delete-btn:hover {
                background: #cc0000;
            }

            /* Animation */
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: scale(0.9);
                }

                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }
        </style>

        <script>
            // Add History Dialog
            const openHistoryDialog = document.getElementById("openHistoryDialog");
            const closeHistoryDialog = document.getElementById("closeHistoryDialog");
            const historyDialog = document.getElementById("historyDialog");

            // View History Dialog
            const openViewHistory = document.getElementById("openViewHistory");
            const closeViewHistory = document.getElementById("closeViewHistory");
            const viewHistoryDialog = document.getElementById("viewHistoryDialog");

            // Open Add History
            openHistoryDialog.addEventListener("click", () => {
                historyDialog.style.display = "flex";
            });
            closeHistoryDialog.addEventListener("click", () => {
                historyDialog.style.display = "none";
            });

            // Open View History
            openViewHistory.addEventListener("click", () => {
                viewHistoryDialog.style.display = "flex";
            });
            closeViewHistory.addEventListener("click", () => {
                viewHistoryDialog.style.display = "none";
            });

            // Close on outside click
            window.addEventListener("click", (e) => {
                if (e.target === historyDialog) historyDialog.style.display = "none";
                if (e.target === viewHistoryDialog) viewHistoryDialog.style.display = "none";
            });
        </script>


        <div class="vitals-dialog" id="vitalsDialog">
            <div class="dialog-content">
                <span class="close-dialog" id="closeDialog">&times;</span>
                <h2>Add Today's Vitals</h2>

                <form method="POST" action="save_vitals.php">
                    <div class="form-group">
                        <label>Blood Pressure (mmHg)</label>
                        <input type="text" name="blood_pressure" placeholder="120" required>
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
            <h2 class="vitals-section-title" style="padding-left: 20px; color:blue;" >Latest Overview</h2>

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
        <div class="download-report" style="text-align:center; margin:30px 0;">
            <button id="downloadPDF" class="health-submit" style="width:auto; padding:12px 25px;">
                <i class='bx bxs-file-pdf'></i> Download Health Report (PDF)
            </button>
        </div>
    </div>

    <section class="features-section">
        <h2>AI Health Insights</h2>
        <p>Advanced features designed to revolutionize how you monitor and manage health data</p>


        <div class="features-grid">

            <div class="feature-card" style="display: flex; flex-direction: column;">
                <h3>Real-time Diabetes Risk Tracking</h3>
                <p style="flex-grow: 1;">Monitor <strong>Pregnancies, Glucose, Blood Pressure, Skin Thickness, Insulin, BMI, DPF(Diabetes Pedigree Function), and Age </strong> to assess diabetes risk with intelligent trend analysis.</p>
                <div class="ai-links" style="margin-bottom: 10px; margin-top: auto;">
                    <button class="ai-btn open-modal submit-btn" data-target="#modalTrack">Check</button>
                </div>
            </div>

            <div class="feature-card" style="display: flex; flex-direction: column;">
                <h3>Real-Time Lung Cancer Risk Checker</h3>
                <p style="flex-grow: 1;"> Monitor key health indicators such as <strong>Age, Gender, Smoking Habits, Finger Discoloration, Mental Stress, Pollution Exposure, Long-Term Illness, Energy Level, Immune Weakness, Breathing Issues, Alcohol Consumption, Throat Discomfort, Oxygen Saturation, Chest Tightness, Family History, Smoking Family History,</strong> and <strong>Stress-Immune Factors</strong> to assess lung cancer risk with advanced machine learning insights. </p>
                <div class="ai-links" style="margin-bottom: 10px; margin-top: auto;">
                    <button class="ai-btn open-modal submit-btn" data-target="#modalInsight">Check</button>
                </div>
            </div>
        </div>


    </section>
    <?php
    include 'config.php';

    $query = "
    SELECT 
        u.id AS user_id,
        CONCAT(u.first_name, ' ', u.last_name) AS full_name,
        u.email AS email_address,
        d.specialization,
        d.license_number
    FROM users u
    JOIN doctor_verifications d ON u.id = d.user_id
    WHERE d.verification_status = 'Verified'
";
    $result = $conn->query($query);
    ?>

    <section class="features-section">
        <h2>Verified Doctors</h2>
        <p>Professionals verified and ready to provide their expertise.</p>

        <div class="features-grid">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="feature-card">
                        <h3><?= htmlspecialchars($row['full_name']) ?></h3>
                        <p><strong>Field:</strong> <?= htmlspecialchars($row['specialization']) ?><br>
                            ID: <?= htmlspecialchars($row['license_number']) ?></p>
                        <span style="color:red">Email to Schedule Consultation</span><br>
                        <a href="mailto:<?= htmlspecialchars($row['email_address']) ?>"
                            style="display:inline-block; margin-top:15px; background:var(--g1color); color:#fff; padding:10px 22px; border-radius:25px; text-decoration:none; font-size:0.9rem;">
                            Send Email
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No verified Doctors available.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Modal Structure -->
    <!-- Modal 1: Real-time Vitals Tracking -->
    <div id="modalTrack" class="health-modal">
        <div class="health-modal-content">
            <span class="health-modal-close">&times;</span>
            <h2>Diabetes Prediction</h2>
            <p class="disclaimer" style="color: #a00; font-weight: bold; margin-top: 15px; padding: 10px; border: 1px solid #f00; border-radius: 4px; background-color: #ffeaea;">
                Disclaimer: The generated values are **not true medical diagnoses**. This tool is for preliminary risk assessment and informational purposes only to provide a simple idea of potential risk factors. Always consult a qualified healthcare professional for any health concerns or before making medical decisions.
            </p>
            <form class="health-form" id="prediction-form">
                <div class="form-group" style="padding-bottom: 5px;">
                    <label>Gender</label>
                    <small class="sub-label">Select your biological gender</small>
                    <select name="Gender" required>
                        <option value="1">Male</option>
                        <option value="0">Female</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Pregnancies</label>
                    <small class="sub-label">Number of times you have been pregnant (0 if none)</small>
                    <input type="number" name="Pregnancies" required>
                </div>

                <div class="form-group">
                    <label>Glucose</label>
                    <small class="sub-label">Blood glucose level in mg/dL (e.g., 120)</small>
                    <input type="number" name="Glucose" required>
                </div>

                <div class="form-group">
                    <label>Blood Pressure</label>
                    <small class="sub-label">Diastolic blood pressure in mmHg (e.g., 80)</small>
                    <input type="number" name="BloodPressure" required>
                </div>

                <div class="form-group">
                    <label>Skin Thickness</label>
                    <small class="sub-label">Triceps skin fold thickness in mm (e.g., 20)</small>
                    <input type="number" name="SkinThickness" required>
                </div>

                <div class="form-group">
                    <label>Insulin</label>
                    <small class="sub-label">2-hour serum insulin in μU/mL (e.g., 85)</small>
                    <input type="number" name="Insulin" required>
                </div>

                <div class="form-group">
                    <label>BMI</label>
                    <small class="sub-label">Body Mass Index (weight/height²), e.g., 24.5</small>
                    <input type="number" step="any" name="BMI" required>
                </div>

                <div class="form-group">
                    <label>DPF (Diabetes Pedigree Function)</label>
                    <small class="sub-label">A score showing genetic risk for diabetes (e.g., 0.52)</small>
                    <input type="number" step="any" name="DPF" required>
                </div>

                <div class="form-group">
                    <label>Age</label>
                    <small class="sub-label">Enter your age in years</small>
                    <input type="number" name="Age" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="health-submit">Predict</button>
                </div>

            </form>
        </div>
    </div>

    <script>
        document.getElementById('prediction-form').addEventListener('submit', async function(e) {
            // Stop the form from submitting normally (which would reload the page)
            e.preventDefault();

            const form = e.target;
            // Use FormData to easily capture all form input values
            const formData = new FormData(form);

            try {
                // Send the form data to the Flask '/predict' route
                const response = await fetch('diabetic_predict.php', {
                    method: 'POST',
                    body: formData
                });

                // Check if the server responded successfully (status 200)
                if (!response.ok) {
                    // If not successful, parse the error message from the server
                    const errorData = await response.json();
                    alert('Prediction Error: ' + errorData.error);
                    return;
                }

                // Parse the successful JSON response from the server
                const result = await response.json();
                const predictionText = result.prediction_result;

                // Display the final prediction result in a pop-up alert
                alert('Prediction Result : ' + predictionText);

            } catch (error) {
                console.error('Fetch error:', error);
                alert('An unexpected error occurred during the request.');
            }
        });
    </script>

    <style>
        .sub-label {
            display: block;
            font-size: 12px;
            color: #666;
            margin-top: 3px;
        }
    </style>

    <div id="modalInsight" class="health-modal">
        <div class="health-modal-content">
            <span class="health-modal-close">&times;</span>
            <h2>Lung Cancer Prediction</h2>
            <p class="disclaimer" style="color: #a00; font-weight: bold; margin-top: 15px; padding: 10px; border: 1px solid #f00; border-radius: 4px; background-color: #ffeaea;">
                Disclaimer: The generated values are **not true medical diagnoses**. This tool is for preliminary risk assessment and informational purposes only to provide a simple idea of potential risk factors. Always consult a qualified healthcare professional for any health concerns or before making medical decisions.
            </p>
            <form class="health-form" id="lung-cancer-form">

                <div class="form-group">
                    <label>Age</label>
                    <small class="sub-label">Enter your age in years</small>
                    <input type="number" name="AGE" required>
                </div>

                <div class="form-group">
                    <label>Gender</label>
                    <small class="sub-label">Select your gender</small>
                    <select name="GENDER" required>
                        <option value="1">Male</option>
                        <option value="0">Female</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Do you smoke?</label>
                    <small class="sub-label">Select Yes if you currently smoke</small>
                    <select name="SMOKING" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Finger Discoloration</label>
                    <small class="sub-label">Dark or unusual discoloration in fingers</small>
                    <select name="FINGER_DISCOLORATION" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Mental Stress</label>
                    <small class="sub-label">Frequent stress, anxiety, or mental pressure</small>
                    <select name="MENTAL_STRESS" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Exposure to Pollution</label>
                    <small class="sub-label">Dust, smoke, harmful air, or industrial pollution</small>
                    <select name="EXPOSURE_TO_POLLUTION" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Long-Term Illness</label>
                    <small class="sub-label">Any illness lasting 6 months or more</small>
                    <select name="LONG_TERM_ILLNESS" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Energy Level (0–100)</label>
                    <small class="sub-label">Rate your energy: 0 = tired, 100 = very energetic</small>
                    <input type="number" step="any" name="ENERGY_LEVEL" required>
                </div>

                <div class="form-group">
                    <label>Weak Immune System</label>
                    <small class="sub-label">Do you fall sick often or have low immunity?</small>
                    <select name="IMMUNE_WEAKNESS" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Breathing Difficulty</label>
                    <small class="sub-label">Shortness of breath or breathing problems</small>
                    <select name="BREATHING_ISSUE" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Alcohol Consumption</label>
                    <small class="sub-label">Do you consume alcohol regularly?</small>
                    <select name="ALCOHOL_CONSUMPTION" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Throat Discomfort</label>
                    <small class="sub-label">Pain, irritation, dryness, or discomfort</small>
                    <select name="THROAT_DISCOMFORT" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Oxygen Saturation</label>
                    <small class="sub-label">Normal levels are usually above 95%</small>
                    <input type="number" step="any" name="OXYGEN_SATURATION" required>
                </div>

                <div class="form-group">
                    <label>Chest Tightness</label>
                    <small class="sub-label">Pressure, heaviness, or tight feeling in the chest</small>
                    <select name="CHEST_TIGHTNESS" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Family History</label>
                    <small class="sub-label">Any family history of lung diseases</small>
                    <select name="FAMILY_HISTORY" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Family Smoking History</label>
                    <small class="sub-label">People in your family who smoke</small>
                    <select name="SMOKING_FAMILY_HISTORY" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Stress Affecting Immunity</label>
                    <small class="sub-label">Does stress weaken your immune system?</small>
                    <select name="STRESS_IMMUNE" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>


                <div class="form-group">
                    <button type="submit" class="health-submit">Predict</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('lung-cancer-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);

            try {
                // Target the PHP script to act as the intermediary
                const response = await fetch('lung_predict.php', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    alert('Server Error: ' + errorData.error);
                    return;
                }

                const result = await response.json();
                const predictionText = result.prediction_result;

                // Display the alert
                alert('Prediction Result: ' + predictionText);

            } catch (error) {
                console.error('Fetch error:', error);
                alert('An unexpected error occurred during the request.');
            }
        });
    </script>
    <!-- Modal 3: Secure & Private -->
    <div id="modalSecureData" class="health-modal">
        <h2>Follow us</h2>
    </div>

    <!-- Messages Modal -->
    <div id="messagesModal"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
            background:rgba(0,0,0,0.6); justify-content:center; align-items:center; color:#000;">

        <div style="background:#fff; width:400px; max-height:500px; overflow-y:auto;
                padding:20px; border-radius:10px; position:relative;">

            <h3 style="color:var(--success)">Your Messages</h3>

            <div id="messagesContent">
                <!-- PHP messages will load here -->
                <?php
                include 'config.php';
                $patient_id = $_SESSION["user_id"];

                $sql = "
                SELECT dn.note, dn.created_at,
                    CONCAT(u.first_name, ' ', u.last_name) AS doctor_name
                FROM doctor_notes dn
                JOIN users u ON dn.doctor_id = u.id
                WHERE dn.patient_id = '$patient_id'
                ORDER BY dn.created_at DESC
            ";
                $result = $conn->query($sql);

                if ($result->num_rows > 0):
                    while ($row = $result->fetch_assoc()): ?>
                        <div style='background:#f4f4f4; padding:15px; border-radius:8px; margin-bottom:10px;'>
                            <strong>Doctor:</strong> <?= $row['doctor_name'] ?><br>
                            <strong>Message:</strong> <?= $row['note'] ?><br>
                            <small><?= $row['created_at'] ?></small>
                        </div>
                <?php endwhile;
                else:
                    echo "<p>No messages yet.</p>";
                endif;
                ?>
            </div>

            <!-- Close Button -->
            <button id="closeMessagesBtn"
                style="position:absolute; top:10px; right:10px; 
                       background:none; border:none; font-size:20px; cursor:pointer;"> ✖
            </button>

        </div>
    </div>

    <?php include 'whatsapp.php';
    ?>
    <footer>
        <div class="social">
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
<script src="js/patientmodel.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
    document.getElementById("downloadPDF").addEventListener("click", async () => {
        const {
            jsPDF
        } = window.jspdf;

        // Hide buttons temporarily
        const buttons = document.querySelectorAll("button, .register-btn, .login-btn, .quick-actions, #viewHistoryDialog, .patient-portal-header ");
        buttons.forEach(b => b.style.display = "none");

        // --- STEP A: Clone hidden extra content ---
        const extra = document.getElementById("pdf-extra").cloneNode(true);
        extra.style.display = "block"; // make visible only for PDF

        // --- STEP B: Attach extra header above the main report ---
        const reportElement = document.querySelector(".patient-portal-container");
        reportElement.prepend(extra);

        // --- STEP C: Capture as canvas ---
        const canvas = await html2canvas(reportElement, {
            scale: 2
        });
        const imgData = canvas.toDataURL("image/png");

        // --- STEP D: Generate PDF ---
        const pdf = new jsPDF("p", "mm", "a4");
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

        pdf.addImage(imgData, "PNG", 0, 0, pdfWidth, pdfHeight);

        // Define the coordinates for the footer
        const footerY1 = pdf.internal.pageSize.getHeight() - 15;
        const footerY2 = pdf.internal.pageSize.getHeight() - 10;
        const startX = 10;

        // 1. Set the font for the standard text
        pdf.setFontSize(10);
        pdf.setFont('helvetica', 'normal'); // Set back to normal for non-bold text

        // 2. The text you want to make bold
        const boldText = "Contact - ";

        // 3. The remaining text (not bold)
        const normalText = "Email: support@welltracker.com | Phone: +94 11-678-9012";

        // --- Print the Bold part ---
        pdf.setFont('helvetica', 'bold');
        pdf.text(boldText, startX, footerY1);

        // --- Print the Normal part ---
        // Calculate the width of the bold text to know where to start the normal text
        const boldTextWidth = pdf.getStringUnitWidth(boldText) * pdf.internal.getFontSize() / pdf.internal.scaleFactor;
        const normalTextX = startX + boldTextWidth + 0.5; // Add a small buffer (0.5 units)
        pdf.setFont('helvetica', 'normal');
        pdf.text(normalText, normalTextX, footerY1);

        // --- Print the second line (copyright) ---
        pdf.text("Generated by WellTrackeR | © 2025", startX, footerY2);

        pdf.save("Health_Report.pdf");

        // --- STEP E: Remove the temporary header ---
        extra.remove();

        // Restore UI
        buttons.forEach(b => b.style.display = "");
    });
</script>


<script>
    // Open modal
    document.querySelectorAll(".open-modal").forEach(btn => {
        btn.addEventListener("click", () => {
            const modal = document.querySelector(btn.dataset.target);
            modal.style.display = "flex";
        });
    });

    // Close modal by X
    document.querySelectorAll(".health-modal-close").forEach(btn => {
        btn.addEventListener("click", () => {
            btn.closest(".health-modal").style.display = "none";
        });
    });

    // Close modal by clicking outside
    window.addEventListener("click", e => {
        if (e.target.classList.contains("health-modal")) {
            e.target.style.display = "none";
        }
    });
</script>

<script>
    document.getElementById("openMessagesBtn").addEventListener("click", () => {
        document.getElementById("messagesModal").style.display = "flex";
    });

    document.getElementById("closeMessagesBtn").addEventListener("click", () => {
        document.getElementById("messagesModal").style.display = "none";
    });
</script>


</html>