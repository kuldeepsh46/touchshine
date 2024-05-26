<?php
// create a new cURL resource
$ch = curl_init();

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, "http://api.softpayapi.in/api/Operator/RechargePlanDetails?api_key=CZ791105NM5AYLUA6FGHRSBD3C6QI72XW8KT2BVE38OD0J9P44&circle_id=2&operator_code=SOFTAIRTELPRE/");
curl_setopt($ch, CURLOPT_HEADER, 0);

// grab URL and pass it to the browser
curl_exec($ch);

// close cURL resource, and free up system resources
curl_close($ch);
?>