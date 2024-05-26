<?php

// API URL
$url = 'https://www.mplan.in/api/plans.php';

// API Key
$apiKey = 'edad770c50f096272c3b6e130b55804a';

// Get parameters from GET request
$offer = $_GET['offer'] ?? 'roffer';
$tel = $_GET['tel'] ?? '7388139606';
$operator = $_GET['operator'] ?? 'Airtel';

// Build query string
$queryString = http_build_query([
    'apikey' => $apiKey,
    'offer' => $offer,
    'tel' => $tel,
    'operator' => $operator
]);

// Final URL with query string
$finalUrl = $url . '?' . $queryString;

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $finalUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute cURL session
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
}

// Close cURL session
curl_close($ch);

// Decode the JSON response
$responseData = json_decode($response, true);

//echo "<pre>"; print_r($responseData); die;

// Check if decoding was successful
if ($responseData && isset($responseData['records'])) {
    // Output the records in JSON format
    $records = $responseData['records'];
    $outputRecords = [];
    foreach ($records as $record) {
        $outputRecords[] = [
            'Rs' => $record['rs'],
            'Details' => $record['desc']
        ];
    }

    // Output JSON
    header('Content-Type: application/json');
    echo json_encode($outputRecords, JSON_PRETTY_PRINT);
} else {
    echo "Error decoding JSON or records not found in response.";
}

?>
