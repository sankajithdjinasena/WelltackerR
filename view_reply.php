<?php
include 'config.php';
session_start();

// Only Admin can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: admin_portal.php");
    exit();
}

// Fetch all community replies with post info
$sql = "SELECT cr.*, cp.title AS post_title 
        FROM community_replies cr
        JOIN community_posts cp ON cr.post_id = cp.post_id
        ORDER BY cr.created_at DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>WellTrackeR | Community Replies</title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/patient.css">
<link rel="icon" type="image/png" href="image/Logo_R.png">
<link rel="stylesheet" href="css/doctor_review.css"> <!-- reuse table styles -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
            .nav-links a.login-btn{
  color: var(--text-light);
}
.nav-links a.login-btn:hover{
  background-color: var(--text-light);
  color: var(--pcolor);
}
</style>
<style>
.delete-btn {
    background-color: #e63946;
    color: #fff;
    border: none;
    padding: 5px 10px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 13px;
    transition: 0.2s;
}
.delete-btn:hover {
    background-color: #d62828;
}
</style>
</head>
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
        <h1>Community Replies</h1>
    </div>

    <div class="quick-actions">
        <table class="doctor-table">
            <thead>
                <tr>
                    <th>Post Title</th>
                    <th>Author</th>
                    <th>Reply Text</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr id="row-<?php echo $row['reply_id']; ?>">
                            <td><?php echo htmlspecialchars($row['post_title']); ?></td>
                            <td><?php echo htmlspecialchars($row['author']); ?></td>
                            <td><?php echo htmlspecialchars($row['reply_text']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td>
                                <button class="delete-btn" data-id="<?php echo $row['reply_id']; ?>">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5">No replies found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// Delete community reply
$(".delete-btn").click(function() {
    if(!confirm("Are you sure you want to delete this reply?")) return;
    var id = $(this).data("id");
    var row = $("#row-" + id);

    $.ajax({
        url: "delete_community_reply.php",
        type: "POST",
        data: { reply_id: id },
        success: function(res) {
            alert("Reply deleted successfully.");
            row.remove();
        },
        error: function() {
            alert("Failed to delete reply.");
        }
    });
});
</script>
</body>
</html>
