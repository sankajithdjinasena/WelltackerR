<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    die("Unauthorized access");
}

// get user data
$user_name = $_SESSION["first_name"] . " " . $_SESSION["last_name"];
$user_email = $_SESSION["email"];

// OPTIONAL: fetch today's vitals
include "config.php";
$user_id = $_SESSION["user_id"];

$vitals_sql = "SELECT * FROM vitals WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 1";
$vitals_result = $conn->query($vitals_sql);
$vitals = $vitals_result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Health Report PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 25px;
        }
        .header {
            text-align: center;
        }
        .header img {
            width: 90px;
        }
        .section {
            margin-top: 20px;
        }
        h2 {
            border-bottom: 2px solid #444;
            padding-bottom: 5px;
        }
        .info-box {
            background: #f3f3f3;
            padding: 15px;
            border-radius: 10px;
        }

        #reportArea{
            margin: 15px;
            padding: 20px;
        }
    </style>

    <!-- html2canvas + jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>
<body>

<div id="reportArea">

    <div class="header">
        <img src="image/Logo_R.png">
        <h1>WellTrackeR - Health Summary Report</h1>
    </div>

    <div class="section info-box">
        <p><strong>Name:</strong> <?= $user_name ?></p>
        <p><strong>Email:</strong> <?= $user_email ?></p>
        <p><strong>Date:</strong> <?= date("Y-m-d") ?></p>
    </div>

    <div class="section">
        <h2>Last update Vitals</h2>
        <?php if ($vitals): ?>
            <p><strong>Blood Pressure:</strong> <?= $vitals["blood_pressure"] ?></p>
            <p><strong>Heart Rate:</strong> <?= $vitals["heart_rate"] ?></p>
            <p><strong>Blood Sugar:</strong> <?= $vitals["blood_sugar"] ?></p>
            <p><strong>Weight:</strong> <?= $vitals["weight"] ?></p>
            <p><strong>Last Update:</strong> <?= $vitals["created_at"] ?></p>
        <?php else: ?>
            <p>No vitals available.</p>
        <?php endif; ?>
    </div>

    <div class="section">
        <h2>Charts</h2>
            <!-- YOU MUST PASS IMAGES FROM MAIN PAGE -->
    </div>

</div>
<div style="justify-content: center; text-align:center" >
<button onclick="downloadPDF()" style="margin-top:20px; padding:10px 20px; cursor:pointer ; border:none; background:#1abc9c; color:#fff; border-radius:6px; font-size:15px;">
    Download PDF
</button>
</div>

<script>
function downloadPDF() {
    const { jsPDF } = window.jspdf;

    html2canvas(document.getElementById("reportArea"), { scale: 2 }).then(canvas => {
        const imgData = canvas.toDataURL("image/png");

        const pdf = new jsPDF("p", "mm", "a4");
        let width = pdf.internal.pageSize.getWidth();
        let height = (canvas.height * width) / canvas.width;

        pdf.addImage(imgData, "PNG", 0, 0, width, height);
        pdf.save("Health_Report.pdf");
    });
}
</script>
<script src="js/patientchart.js"></script>
</body>
</html>
