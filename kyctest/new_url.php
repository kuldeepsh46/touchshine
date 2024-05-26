<?php

$mysqli = new mysqli("localhost","u457006293_moonex","Moonex@2001","u457006293_moonex");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;

}
$user_id=$_SESSION['uid'];
$sql = "select * from users where id='$user_id'";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $requestId=$row["request_id"];
    $token=$row["token"];
    $patron_id=$row["patron_id"];
    
  }
}



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://signzy.tech/api/v2/patrons/$patron_id/digilockers",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\"task\":\"getEadhaar\", \"essentials\": {\"requestId\": \"$requestId\"},\"redirectUrl\": \"S\",\"redirectTime\": \"2\"}",
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
  $arr=json_decode($response);
  $aadhar_name=$arr->result->name;
  $uid=$arr->result->uid;
  $dob=$arr->result->dob;
  $gender=$arr->result->gender;
  $photo=$arr->result->photo;
  $district=$arr->result->splitAddress->district[0];
  $state=$arr->result->splitAddress->state[0][0];
  $pincode=$arr->result->splitAddress->pincode;
  $city=$arr->result->splitAddress->city[0];
  $address=$arr->result->splitAddress->addressLine;
}                  


$re = '/:[A-Z]*.[A-Z]*/';
$str = $address;

preg_match($re, $str, $matches, PREG_OFFSET_CAPTURE, 0);
    
// Print the entire match result

$matches= str_replace(":","",$matches[0][0]);


$data = array(
                        'uid' =>  $_SESSION['uid'],
                        'aadhaar_name' => $aadhar_name,
                        
                        
                        'aadhar_last' => $uid,
                        
                        'gender' => $gender,
                        'photo' => $photo,
                        
                       
                        
                        'site' => $user->site,
                        'state' => $state,
                        'district' => $district,
                        'city' => $city,
                        'address' => $address,
                        'pincode' => $pincode,
                        
                        'fname' => $matches,
                        'dob' => $dob
                        
                        
                        

                        
                        
                        
                        );
                        $this->db->insert('kyc',$data);

header("Location: $url");

?>