<?php 
if(isset($_POST['token'])&&isset($_POST['patron_id'])&&isset($_POST['pan'])){

$token=$_POST['token'];
$patron_id=$_POST['patron_id'];
$pan=$_POST['pan'];
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://signzy.tech/api/v2/patrons/$patron_id/panv2",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\"task\":\"fetch\",\"essentials\":{\"number\":\"$pan\"}}",
  CURLOPT_HTTPHEADER => array(
    "accept: */*",
    "accept-language: en-US,en;q=0.8",
    "authorization: $token",
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
}
?>