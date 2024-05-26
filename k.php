<?php
// Define the JSON data as a string
$jsonData = '{
    "signup": true,
    "redirectUrl": "https://www.signzy.com/",
    "redirectTime": "1",
    "callbackUrl": "https://signtest123.requestcatcher.com/",
    "customerId": "<customer ID>",
    "successRedirectUrl": "https://www.signzy.com/",
    "successRedirectTime": "5",
    "failureRedirectUrl": "https://www.signzy.com/",
    "failureRedirectTime": "5",
    "logoVisible": "true",
    "logo": "https://rise.barclays/content/dam/thinkrise-com/images/rise-stories/Signzy-16_9.full.high_quality.jpg",
    "supportEmailVisible": "true",
    "supportEmail": "support@signzy.com",
    "docType": [
        "PANCR",
        "ADHAR"
    ],
    "purpose": "kyc",
    "getScope": true,
    "consentValidTill": 1729141682,
    "showLoaderState": true,
    "internalId": "<Internal ID>",
    "companyName": "Signzy",
    "favIcon": "https://rise.barclays/content/dam/thinkrise-com/images/rise-stories/Signzy-16_9.full.high_quality.jpg",
    "persistPassword": ""
}';

// Decode the JSON data into a PHP associative array
$data = json_decode($jsonData, true);

// Check if the JSON data was decoded successfully
if (json_last_error() === JSON_ERROR_NONE) {
    // Output the data
    echo "<h1>Signzy Data</h1>";
    echo "<p>Signup: " . ($data['signup'] ? 'Enabled' : 'Disabled') . "</p>";
    echo "<p>Redirect URL: <a href='" . htmlspecialchars($data['redirectUrl']) . "'>" . htmlspecialchars($data['redirectUrl']) . "</a></p>";
    echo "<p>Redirect Time: " . htmlspecialchars($data['redirectTime']) . " seconds</p>";
    echo "<p>Callback URL: <a href='" . htmlspecialchars($data['callbackUrl']) . "'>" . htmlspecialchars($data['callbackUrl']) . "</a></p>";
    echo "<p>Customer ID: " . htmlspecialchars($data['customerId']) . "</p>";
    echo "<p>Success Redirect URL: <a href='" . htmlspecialchars($data['successRedirectUrl']) . "'>" . htmlspecialchars($data['successRedirectUrl']) . "</a></p>";
    echo "<p>Success Redirect Time: " . htmlspecialchars($data['successRedirectTime']) . " seconds</p>";
    echo "<p>Failure Redirect URL: <a href='" . htmlspecialchars($data['failureRedirectUrl']) . "'>" . htmlspecialchars($data['failureRedirectUrl']) . "</a></p>";
    echo "<p>Failure Redirect Time: " . htmlspecialchars($data['failureRedirectTime']) . " seconds</p>";
    echo "<p>Logo Visible: " . ($data['logoVisible'] === "true" ? 'Yes' : 'No') . "</p>";
    echo "<p>Logo: <img src='" . htmlspecialchars($data['logo']) . "' alt='Logo' style='max-width:200px;'></p>";
    echo "<p>Support Email Visible: " . ($data['supportEmailVisible'] === "true" ? 'Yes' : 'No') . "</p>";
    echo "<p>Support Email: <a href='mailto:" . htmlspecialchars($data['supportEmail']) . "'>" . htmlspecialchars($data['supportEmail']) . "</a></p>";
    echo "<p>Document Types: " . implode(', ', array_map('htmlspecialchars', $data['docType'])) . "</p>";
    echo "<p>Purpose: " . htmlspecialchars($data['purpose']) . "</p>";
    echo "<p>Get Scope: " . ($data['getScope'] ? 'Yes' : 'No') . "</p>";
    echo "<p>Consent Valid Till: " . date('Y-m-d H:i:s', $data['consentValidTill']) . "</p>";
    echo "<p>Show Loader State: " . ($data['showLoaderState'] ? 'Yes' : 'No') . "</p>";
    echo "<p>Internal ID: " . htmlspecialchars($data['internalId']) . "</p>";
    echo "<p>Company Name: " . htmlspecialchars($data['companyName']) . "</p>";
    echo "<p>Favicon: <img src='" . htmlspecialchars($data['favIcon']) . "' alt='Favicon' style='max-width:50px;'></p>";
    echo "<p>Persist Password: " . htmlspecialchars($data['persistPassword']) . "</p>";
} else {
    echo "<p>Failed to decode JSON data: " . json_last_error_msg() . "</p>";
}
?>
