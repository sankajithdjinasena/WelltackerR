<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $license_number = $_POST['license_number'];
    $specialization = $_POST['specialization'];
    $notes = $_POST['notes'];

    // Handle file upload
    $target_dir = "uploads/doctor_docs/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

    $file_name = basename($_FILES["document_file"]["name"]);
    $target_file = $target_dir . time() . "_" . $file_name;
    move_uploaded_file($_FILES["document_file"]["tmp_name"], $target_file);

    // Insert into doctor_verifications table
    $stmt = $conn->prepare("
        INSERT INTO doctor_verifications (user_id, license_number, specialization, notes, document_file)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("issss", $user_id, $license_number, $specialization, $notes, $target_file);

    if ($stmt->execute()) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
        Swal.fire({
            title: 'Success!',
            text: 'Verification submitted successfully!',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'doctor_portal.php';
        });
        </script>";

    } else {
        echo "Error: " . $conn->error;
    }
}
?>
