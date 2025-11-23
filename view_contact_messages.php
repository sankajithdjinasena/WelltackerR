<?php
include 'config.php';
session_start();

// Only Admin can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: admin_portal.php");
    exit();
}

// Fetch all contact messages
$sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>WellTrackeR | Contact Messages</title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/patient.css">
<link rel="stylesheet" href="css/doctor_review.css"> <!-- reuse table styles -->
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
    <i class='bx bx-menu menu-toggle'></i>
    <div class="nav-links">
        <a href="" class="login-btn"><?php echo $_SESSION["first_name"] . " " . $_SESSION["last_name"] ?></a>
        <a href="logout.php" class="login-btn">Logout</a>
        <a href="admin_portal.php" class="register-btn">Admin Portal</a>
    </div>
</nav>

<div class="patient-portal-container">
    <div class="patient-portal-header">
        <h1>Contact Messages</h1>
    </div>

    <div class="quick-actions">
        <table class="doctor-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr id="row-<?php echo $row['id']; ?>">
                            <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><?php echo htmlspecialchars($row['subject']); ?></td>
                            <td><?php echo htmlspecialchars($row['message']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td>
                                <button class="delete-btn" data-id="<?php echo $row['id']; ?>">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7">No contact messages found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// Delete contact message
$(".delete-btn").click(function() {
    if(!confirm("Are you sure you want to delete this message?")) return;
    var id = $(this).data("id");
    var row = $("#row-" + id);

    $.ajax({
        url: "delete_contact_message.php",
        type: "POST",
        data: { id: id },
        success: function(res) {
            alert("Message deleted successfully.");
            row.remove();
        },
        error: function() {
            alert("Failed to delete message.");
        }
    });
});
</script>
</body>
</html>
