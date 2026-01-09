<?php
header('Content-Type: application/json');

// The Flask API URL
$flask_url = 'http://127.0.0.1:10003/brain_predict'; 

if (!isset($_FILES['file']) || $_FILES['file']['error'] != UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['error' => 'No file uploaded or file upload error']);
    exit;
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $flask_url);
curl_setopt($ch, CURLOPT_POST, 1);

// Forwarding the file using CURLFile
$cfile = new CURLFile($_FILES['file']['tmp_name'], $_FILES['file']['type'], $_FILES['file']['name']);
$post_fields = ['file' => $cfile];

curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    http_response_code(500);
    echo json_encode(['error' => 'Connection to AI server failed: ' . $error]);
    exit;
}

http_response_code($http_code);
echo $response;
?>