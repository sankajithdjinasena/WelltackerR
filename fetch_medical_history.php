<?php
include 'config.php';
$user_id = $_GET['user_id'] ?? 0;

$sql = "SELECT * FROM medical_history WHERE user_id = '$user_id' ORDER BY uploaded_at DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    echo "<div class='doctor__pdf-item'>";
    echo "<h4>" . htmlspecialchars($row['title']) . "</h4>";
    echo "<p>" . htmlspecialchars($row['description']) . "</p>";
    echo "<p>Uploaded: " . htmlspecialchars($row['uploaded_at']) . "</p>";
    echo "<a href='" . htmlspecialchars($row['pdf_file']) . "' target='_blank' class='doctor__pdf-btn'>View PDF</a>";
    echo "</div>";
  }
} else {
  echo "<p>No medical history uploaded yet for this user.</p>";
}
?>
