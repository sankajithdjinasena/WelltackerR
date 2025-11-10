<?php
include 'config.php';

    session_start();

    // Redirect if not a doctor
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
        header("Location: admin_portal.php");
        exit();
    }

    $sql = "
SELECT 
    dv.id,
    u.first_name,
    u.last_name,
    dv.license_number,
    dv.specialization,
    dv.notes,
    dv.document_file,
    dv.verification_status,
    dv.submitted_at,
    dv.verified_at
FROM doctor_verifications dv
JOIN users u ON dv.user_id = u.id
ORDER BY dv.submitted_at DESC
";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WellTrackeR | Doctor Review</title>
    <link rel="icon" type="image/png" href="image/Logo_R.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/patient.css">
    <link rel="stylesheet" href="css/doctor_review.css">
</head>
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
            <a href="" class="login-btn"><?php echo $_SESSION["first_name"] . " " . $_SESSION["last_name"] ?></a>
            <a href="logout.php" class="login-btn">Logout</a>
            <a href="admin_portal.php" class="register-btn">Admin Portal</a>
        </div>
    </nav>
    <div class="patient-portal-container">
        <!-- Header -->
        <div class="patient-portal-header">
            <h1>Doctor Reviews</h1>
        </div>

        <div class="quick-actions">
        <table class="doctor-table">
            <thead>
                <tr>
                    <th>Doctor Name</th>
                    <th>License Number</th>
                    <th>Specialization</th>
                    <th>Document</th>
                    <th>Status</th>
                    <th>Submitted At</th>
                    <th>Verified At</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['license_number']); ?></td>
                            <td><?php echo htmlspecialchars($row['specialization']); ?></td>
                            <td>
                                <?php if (!empty($row['document_file'])): ?>
                                    <a href="<?php echo htmlspecialchars($row['document_file']); ?>" target="_blank">View</a>
                                <?php else: ?>
                                    No file
                                <?php endif; ?>
                            </td>
<td>
  <form method="post" action="update_verification.php" class="status-form">
      <input type="hidden" name="doctor_id" value="<?php echo $row['id']; ?>">
      <select name="status" class="status-select">
          <option value="Pending"  <?php if($row['verification_status'] == 'Pending') echo 'selected'; ?>>Pending</option>
          <option value="Verified" <?php if($row['verification_status'] == 'Verified') echo 'selected'; ?>>Verified</option>
          <option value="Rejected" <?php if($row['verification_status'] == 'Rejected') echo 'selected'; ?>>Rejected</option>
      </select>
      <button type="submit" class="update-btn">Update</button>
  </form>
</td>
                            <td><?php echo htmlspecialchars($row['submitted_at']); ?></td>
                            <td><?php echo htmlspecialchars($row['verified_at']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7">No doctor verification records found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    </div>
</body>
</html>