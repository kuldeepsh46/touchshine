<?php

$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => "https://sphirelabs-indian-telecom-data-recharge-plans-v1.p.rapidapi.com/telecomdata/v1/get/index.php?opcode=idea&circle=tn&type=Topup",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"X-RapidAPI-Host: sphirelabs-indian-telecom-data-recharge-plans-v1.p.rapidapi.com",
		"X-RapidAPI-Key: db3674e842mshb8d43d39efc257cp1c97fdjsn0c6cfe776dd8"
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	echo $response;
}