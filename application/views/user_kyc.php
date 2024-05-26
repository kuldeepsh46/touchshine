<?php
$redirUrl=base_url().'main/after_kyc';

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
  CURLOPT_POSTFIELDS => "{\"task\":\"url\",\"essentials\": {\"signup\":true,\"redirectUrl\": \"$redirUrl\",\"redirectTime\": \"2\"}}",
  
  
  
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

 $uid = $_SESSION['uid'];
 $user = $this->db->get_where('users',array('id' => $uid))->row();


$this->db->update('users',array('request_id' => $requestId,'token' => $arr->id,'patron_id' => $patronId),array('id' => $_SESSION['uid']));
//echo $url;exit;

header("Location: $url");

    