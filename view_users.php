<?php
include 'config.php';
session_start();

// Redirect if not admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: admin_portal.php");
    exit();
}

// Fetch all users
$sql = "SELECT id, first_name, last_name, email, role, created_at FROM users ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WellTrackeR | Manage Users</title>
    <link rel="icon" type="image/png" href="image/Logo_R.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/patient.css">
    <link rel="stylesheet" href="css/doctor_review.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <h1>WellTrackeR</h1>
        </div>
    </div>

    <!-- Hamburger Menu -->
    <i class='bx bx-menu menu-toggle'></i>

    <div class="nav-links">
        <a href="#" class="login-btn"><?php echo $_SESSION["first_name"] . " " . $_SESSION["last_name"]; ?></a>
        <a href="logout.php" class="login-btn">Logout</a>
        <a href="admin_portal.php" class="register-btn">Admin Portal</a>
    </div>
</nav>

<div class="patient-portal-container">
    <div class="patient-portal-header">
        <h1>Manage Users</h1>
    </div>

    <div class="quick-actions">
        <table class="doctor-table">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Registered At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['role']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td><button class="delete-btn" data-user-id="<?php echo $row['id']; ?>">Delete</button></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5">No users found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    $(".status-select").change(function() {
        var userId = $(this).data("user-id");
        var newStatus = $(this).val();

        $.ajax({
            url: "update_user_status.php",
            type: "POST",
            data: { user_id: userId, status: newStatus },
            success: function(response) {
                console.log("Status updated:", response);
            },
            error: function(xhr) {
                alert("Failed to update status.");
            }
        });
    });
});
// Delete user
$(".delete-btn").click(function() {
    if (!confirm("Are you sure you want to delete this user?")) return;

    var userId = $(this).data("user-id");
    var row = $(this).closest("tr");

    $.ajax({
        url: "delete_user.php",
        type: "POST",
        data: { user_id: userId },
        success: function(response) {
            alert("User deleted successfully.");
            row.remove(); // Remove row from table
        },
        error: function(xhr) {
            alert("Failed to delete user.");
        }
    });
});

</script>

</body>
</html>
