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
      <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
<df-messenger
  intent="WELCOME"
  chat-title="WelltrackeR"
  agent-id="9d5f2420-6826-4916-9e73-235b856a1965"
  language-code="en"
></df-messenger>
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

    <style>
        #verificationDialog p{
            color: #000;
        }
    </style>

    <!-- Verification Dialog -->
    <?php if ($_SESSION['role'] === 'Doctor'): ?>
        <div id="verificationDialog" class="userinfo-dialog">
            <div class="userinfo-content">
                <span class="userinfo-close" id="closeVerification">&times;</span>
                <h2>Verification Status</h2>
                <p><strong>Status: </strong><?php echo $status; ?></p>

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
            <?php
            // Count total patients
            $patient_count_query = "SELECT COUNT(*) AS total_patients FROM users WHERE role = 'Patient'";
            $patient_count_result = $conn->query($patient_count_query);
            $patient_count = 0;
            if ($patient_count_result && $row = $patient_count_result->fetch_assoc()) {
                $patient_count = $row['total_patients'];
            }
            ?>

            <p>Dr. <?php echo $_SESSION["first_name"] . " " . $_SESSION["last_name"]; ?>,
                you have <?php echo $patient_count; ?> patients requiring attention.</p>

            <div class="patient-portal-nav-buttons">
                <button
                    id="openVerificationFormBtn"
                    class="patient-portal-nav-btn active"
                    <?php if ($status === "Verified") echo "disabled style='opacity:0.6; cursor:not-allowed;'"; ?>>
                    <i class='bx bx-calendar'></i> Verified Portal
                </button>
            </div>
        </div>

        <?php if ($status === 'Verified'): ?>


            <?php
            include 'config.php';

            // Fetch all patients and their most recent vitals
            $sql = "
                    SELECT 
                        u.id AS user_id,
                        u.email,
                        CONCAT(u.first_name, ' ', u.last_name) AS full_name,
                        v.blood_pressure,
                        v.heart_rate,
                        v.blood_sugar,
                        v.weight,
                        v.created_at
                    FROM users u
                    LEFT JOIN (
                        SELECT * FROM vitals v1
                        WHERE v1.id IN (
                            SELECT MAX(v2.id) FROM vitals v2 GROUP BY v2.user_id
                        )
                    ) v ON u.id = v.user_id
                    WHERE u.role = 'Patient'
                    ORDER BY v.created_at DESC
                    LIMIT 5
                ";

            $result = $conn->query($sql);
            ?>

            <div class="activity">
                <h3>Recent Patient Activity</h3>

                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php
                        // 🩺 Determine medical condition based on vitals
                        $condition = "Normal";

                        if (!empty($row['blood_pressure'])) {
                            // Clean out non-numeric characters (e.g. "mmHg")
                            $bp = (int) preg_replace('/[^0-9]/', '', $row['blood_pressure']);

                            // Basic classification based on systolic value only
                            if ($bp > 140) {
                                $condition = "High Blood Pressure";
                            } elseif ($bp < 90) {
                                $condition = "Low Blood Pressure";
                            } else {
                                $condition = "Normal Blood Pressure";
                            }
                        } else {
                            $condition = "No Data";
                        }

                        if ($row['blood_sugar'] > 140) {
                            $condition = "High Blood Sugar";
                        } elseif ($row['blood_sugar'] < 70) {
                            $condition = "Low Blood Sugar";
                        }
                        ?>
                        <div class="patient">
                            <div class="patient-info">
                                <strong><?= htmlspecialchars($row['full_name']) ?></strong>
                                <span>
                                    <?= "BP: " . htmlspecialchars($row['blood_pressure'] ?? 'N/A') ?> |
                                    HR: <?= htmlspecialchars($row['heart_rate'] ?? 'N/A') ?> bpm |
                                    Sugar: <?= htmlspecialchars($row['blood_sugar'] ?? 'N/A') ?> mg/dL
                                    <br>
                                    <b>Condition:</b>
                                    <span style="color: 
                            <?= $condition === 'High Blood Pressure' || $condition === 'High Blood Sugar' ? 'red' : ($condition === 'Low Blood Pressure' || $condition === 'Low Blood Sugar' ? 'orange' : 'green'); ?>">
                                        <?= $condition ?>
                                        <br></span>
                                    Last Updated: <?= htmlspecialchars($row['created_at'] ?? 'N/A') ?>
                                </span> <br>
                                <span>
                                    <button class="doctor-send-note-btn" data-user-id="<?= $row['user_id'] ?>" 
                                        data-user-name="<?= htmlspecialchars($row['full_name']) ?>"
                                        style="margin-top:10px; background:#3498db; color:#fff; padding:8px 12px; border-radius:8px; border:none; cursor:pointer;">
                                        <i class='bx bx-message-dots'></i> Send Note
                                    </button>
                                </span>
                            </div>
                            <a href="mailto:<?= htmlspecialchars($row['email']) ?>"
                                style="text-decoration:none; display:inline-block; padding:8px 12px; background-color:var(--g1color); color:#fff; border-radius:10px;">
                                <i class='bx bx-mail-send'></i> Send Email
                            </a>
                            
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No patient data available yet.</p>
                <?php endif; ?>
            </div>
        <?php elseif ($status === 'Pending'): ?>
            <!-- Limited Access -->
            <p style="color:orange; text-align:center; margin-top:20px;">
                Your account is pending verification. Full portal features are locked. <br>
                <span style="color: red;">If you are not add your verified details please upload your documents.</span>
            </p>
        <?php elseif ($status === 'Rejected'): ?>
            <!-- Access Denied -->
            <p style="color:red; text-align:center; margin-top:20px;">
                Your account verification was rejected. Please contact support.
            </p>
        <?php endif; ?>
    </div>

    <!-- Send Note Modal -->
<div id="sendNoteModal" 
     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
            background:rgba(0,0,0,0.6); justify-content:center; align-items:center; color:black;">
    
    <div style="background:#fff; padding:20px; width:350px; border-radius:10px; position:relative;">
        
        <h3 id="noteModalTitle">Send Note</h3>
        <form id="sendNoteForm">
            <input type="hidden" name="patient_id" id="modalPatientId">

            <label>Message:</label>
            <textarea name="note" required
                      style="width:100%; height:120px; border-radius:6px; padding:10px;"></textarea>

            <button type="submit"
                    style="margin-top:10px; width:100%; background:green; color:white; padding:10px; border:none; border-radius:6px;">
                Send
            </button>
        </form>

        <button id="closeModalBtn"
                style="position:absolute; top:10px; right:10px; cursor:pointer; border:none; background:none; font-size:18px;">✖</button>

                <style>
                    #closeModalBtn:hover{
                        color: red;
                    }
                </style>
    </div>
</div>
<style>
    /* Style for status 'verified' (or default status) - 100px */
.footer-normal {
    margin-top: 100px; 
}

/* Style for status 'pending' or 'rejected' - 205px */
.footer-tall {
    margin-top: 205px;
}
</style>
<?php
// Assuming $status is defined elsewhere in your PHP script.
// Example: $status = "rejected"; 

$footer_class = "";

if ($status == "Pending" || $status == "Rejected") {
    $footer_class = "footer-tall";
} else {
    // This covers "verified" and any other status by default
    $footer_class = "footer-normal"; 
}
?>
<?php include 'whatsapp.php';?>
    <footer class="<?php echo $footer_class?>">
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
<script>
document.querySelectorAll('.doctor-send-note-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const patientId = btn.getAttribute('data-user-id');
        const patientName = btn.getAttribute('data-user-name');

        document.getElementById('modalPatientId').value = patientId;
        document.getElementById('noteModalTitle').innerText = "Send Note to " + patientName;

        document.getElementById('sendNoteModal').style.display = "flex";
    });
});

document.getElementById('closeModalBtn').addEventListener('click', () => {
    document.getElementById('sendNoteModal').style.display = "none";
});
</script>

<script>
document.getElementById("sendNoteForm").addEventListener("submit", function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch("send_note.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(response => {
        if (response.trim() === "success") {
            alert("Note sent!");
            document.getElementById('sendNoteModal').style.display = "none";
        } else {
            alert("Failed to send note.");
        }
    });
});
</script>

</html>