<?php 
if(isset($_POST['id']) && isset($_POST['pan'])){

    $user_id = $_POST['id'];
    $pan = $_POST['pan'];

    $mysqli = new mysqli("localhost","u457006293_moonex","Moonex@2001","u457006293_moonex");

    // Check connection
    if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
    }

    $sql = "SELECT * FROM users WHERE id='$user_id'";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        // Fetch user data
        $row = $result->fetch_assoc();
        $token = $row["token"];
    } else {
        echo "User not found.";
        exit();
    }

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api-preproduction.signzy.app/api/v3/pan/fetchV2",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode(array(
            "number" => $pan,
            "returnIndividualTaxComplianceInfo" => "true"
        )),
        CURLOPT_HTTPHEADER => array(
            "Authorization: $token",
            "Content-Type: application/json"
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
