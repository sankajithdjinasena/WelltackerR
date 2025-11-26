<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";
$type = ""; // success, error, warning
$redirect = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    $targetDir = "uploads/medical_history/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

    $fileName = basename($_FILES["pdf_file"]["name"]);
    $targetFilePath = $targetDir . time() . "_" . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    if ($fileType == "pdf") {
        if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $targetFilePath)) {
            $sql = "INSERT INTO medical_history (user_id, title, description, pdf_file)
                    VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isss", $user_id, $title, $description, $targetFilePath);
            $stmt->execute();

            $message = "Medical history uploaded successfully!";
            $type = "success";
            $redirect = "patient_portal.php";
        } else {
            $message = "Error uploading file.";
            $type = "error";
        }
    } else {
        $message = "Only PDF files are allowed.";
        $type = "warning";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Medical History</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&display=swap');

    body{
        font-family: 'Inter', sans-serif;
    }
</style>

<?php if ($message != ""): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: '<?= ucfirst($type) ?>!',
        text: '<?= $message ?>',
        icon: '<?= $type ?>',
        confirmButtonText: 'OK'
    }).then(() => {
        <?php if ($redirect != ""): ?>
        window.location.href = '<?= $redirect ?>';
        <?php endif; ?>
    });
});
</script>
<?php endif; ?>

</body>
</html>
