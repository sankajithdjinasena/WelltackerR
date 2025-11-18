<?php
// Set headers to ensure the browser expects a JSON response
header('Content-Type: application/json');

// --- 1. Define the URL of your running Flask server ---
// The Flask app runs on port 10000 and the route is '/lung_predict'
$flask_url = 'http://127.0.0.1:10001/lung_predict'; 

// Collect all POST data from the form
$post_data = $_POST;

// --- 2. Check for required fields (optional but good practice) ---
$required_fields = [
    'AGE', 'GENDER', 'SMOKING', 'FINGER_DISCOLORATION', 'MENTAL_STRESS', 
    'EXPOSURE_TO_POLLUTION', 'LONG_TERM_ILLNESS', 'ENERGY_LEVEL', 'IMMUNE_WEAKNESS', 
    'BREATHING_ISSUE', 'ALCOHOL_CONSUMPTION', 'THROAT_DISCOMFORT', 'OXYGEN_SATURATION', 
    'CHEST_TIGHTNESS', 'FAMILY_HISTORY', 'SMOKING_FAMILY_HISTORY', 'STRESS_IMMUNE'
];

foreach ($required_fields as $field) {
    if (!isset($post_data[$field]) || $post_data[$field] === '') {
        http_response_code(400);
        echo json_encode(['error' => 'Missing or empty required field: ' . $field]);
        exit;
    }
}

// --- 3. Use cURL to forward the request to the Python Flask server ---
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $flask_url);
curl_setopt($ch, CURLOPT_POST, 1);
// Pass the data as a URL-encoded string
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

// --- 4. Forward the result (JSON) and status code from Flask back to JavaScript ---
http_response_code($http_code);
echo $response;

?>