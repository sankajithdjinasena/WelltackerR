<?php
include 'config.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    http_response_code(403);
    exit("Unauthorized");
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['user_id'])) {

    $user_id = intval($_POST['user_id']);

    try {

        $conn->begin_transaction();

        // Delete vitals
        $stmt = $conn->prepare("DELETE FROM vitals WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        // Delete medical history
        $stmt = $conn->prepare("DELETE FROM medical_history WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        // Delete doctor verification
        $stmt = $conn->prepare("DELETE FROM doctor_verifications WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        // Delete doctor notes where user is patient
        $stmt = $conn->prepare("DELETE FROM doctor_notes WHERE patient_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        // Delete doctor notes where user is doctor
        $stmt = $conn->prepare("DELETE FROM doctor_notes WHERE doctor_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        // Finally delete user
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $conn->commit();

        echo "success";

    } catch (Exception $e) {

        $conn->rollback();

        http_response_code(500);
        echo $e->getMessage();
    }

} else {

    http_response_code(400);
    echo "Invalid request";

}
?>