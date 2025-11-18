<?php
// Set headers to ensure the browser expects a JSON response
header('Content-Type: application/json');

// Define the URL of your running Flask server
$flask_url = 'http://127.0.0.1:10000/predict'; // Adjust host and port if needed

// Collect all POST data from the form
$post_data = $_POST;

// Check if all necessary fields are present before making the request
$required_fields = ['Pregnancies', 'Glucose', 'BloodPressure', 'SkinThickness', 'Insulin', 'BMI', 'DPF', 'Age'];
foreach ($required_fields as $field) {
    if (!isset($post_data[$field])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required field: ' . $field]);
        exit;
    }
}

// Initialize cURL for the request to the Python Flask server
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $flask_url);
curl_setopt($ch, CURLOPT_POST, 1);
// Pass the data as a string of key/value pairs (like a regular form submission)
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Get the response back as a string

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    http_response_code(500);
    echo json_encode(['error' => 'cURL Error (to Python server): ' . $error]);
    exit;
}

// Forward the HTTP status code and response from the Python server
http_response_code($http_code);
echo $response;

?>