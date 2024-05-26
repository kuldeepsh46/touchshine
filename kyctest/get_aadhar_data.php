<?php
if(isset($_POST['id'])&&isset($_POST['site'])){
    $user_id=$_POST['id'];
    $site_id=$_POST['site'];

$mysqli = new mysqli("localhost","u457006293_moonex","Moonex@2001","u457006293_moonex");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;

}



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
  CURLOPT_POSTFIELDS => "{\"task\":\"getEadhaar\", \"essentials\": {\"requestId\": \"$requestId\"},\"redirectUrl\": \"https://moonexsoftware.co/index.php/main/after_kyc\",\"redirectTime\": \"2\"}",
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


$sql = "INSERT INTO kyc (uid, aadhaar_name, aadhar_last,gender,photo,site,state,district,city,address,pincode,fname,dob)
VALUES ('$user_id','$aadhar_name','$uid','$gender','$photo','$site_id','$state','$district','$city','$address','$pincode','$matches','$dob')";

if ($mysqli->query($sql) === TRUE) {
  $arr=array("response"=>"success");

} else {
  echo $mysqli->error;
}
echo json_encode($arr);
$mysqli->close();

//$arr=array("name"=>$aadhar_name,"uid"=>$uid,"dob"=>$dob,"gender"=>$gender,"photo"=>$phpto,"district"=>$district,"state"=>$state,"pincode"=>$pincode,"city"=>$city,"address"=>$address,"father_name"=>$matches);

//echo json_encode($arr);



}
?>