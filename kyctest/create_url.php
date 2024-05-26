<?php

if(isset($_POST['id'])){
    
    $user_id=$_POST['id'];

$mysqli = new mysqli("localhost","u457006293_moonex","Moonex@2001","u457006293_moonex");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  
}

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://signzy.tech/api/v2/patrons/login",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\"username\":\"moonex_prod\",\"password\":\"gBGRM4sPkOc9p6BnMcte\"}",
  CURLOPT_HTTPHEADER => array(
    "accept: */*",
    "accept-language: en-US,en;q=0.8",
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
//echo $response;

  $arr=json_decode($response);
  
}

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://signzy.tech/api/v2/patrons/$arr->userId/digilockers",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\"task\":\"url\",\"essentials\": {\"signup\":true,\"redirectUrl\": \"https://moonexpay.in/app/getAdhaarkyc\",\"redirectTime\": \"2\"}}",
  
  
  
  CURLOPT_HTTPHEADER => array(
    "accept: */*",
    "accept-language: en-US,en;q=0.8",
    "authorization: $arr->id",
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {

  
  $arr1=json_decode($response);
  $id=$arr1->id;
  $patronId=$arr1->patronId;
  $requestId=$arr1->result->requestId;
  $url=$arr1->result->url;
  
  
  $a=1;

}


$sql = "update users set request_id='$requestId', token='$arr->id',patron_id='$patronId' where id='$user_id'";

if ($mysqli->query($sql) === TRUE) {
  $arr=array("status"=>"success","url"=>$url);
} else {
  echo $mysqli->error;
}

echo json_encode($arr);


}


?>
    