<?php

function recharge($api_key, $number, $amount, $operator, $circle, $txnid)
{
    $url = 'https://cyrusrecharge.in/api/recharge.aspx?';
    $data_url = "memberid=AP897886&pin=AAB5C66373&number=" . $number . "&operator=" . $operator . "&circle=" . $circle . "&amount=" . $amount . "&usertx=" . $txnid . "&format=json";
    $call_url = $url . $data_url;
    //log_message('debug',$call_url);
    //echo $call_url;exit;
    $output = curl_get_file_contents($call_url);
    $apiResponse = array();
    $apiResponse = json_decode($output, false);


    return $apiResponse;
}


function rechargeMobotics($api_token, $mobile_no, $amount, $company_id, $is_stv = false)
{


    // Database credentials
    $servername = "localhost";
    $username = "u457006293_moonex";
    $password = "Moonex@2001";
    $dbname = "u457006293_moonex";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to get company ID
    $query = "SELECT company_id FROM rechargev2op_lapu WHERE id = $company_id";

    $result = $conn->query($query);

    $company_id_new = null; // Initialize the variable

    if ($result->num_rows > 0) {
        // Fetch the company_id value
        $row = $result->fetch_assoc();
        $company_id_new = $row["company_id"];
    } else {
        // echo "0 results";
         $response = array('errorMessage' => 'COMPANY NOT FOUND');
         echo json_encode($response);
    }

    // Close connection
    $conn->close();

    // Generate order_id
    $order_id = '58' . time(); // Example: Prefixing '58' to the current timestamp for simplicity


    // Data to be sent in the POST request
    $data = array(
        'api_token' => $api_token,
        'mobile_no' => $mobile_no,
        'amount' => $amount,
        'company_id' => $company_id_new,
        'order_id' => $order_id,
        'is_stv' => false, // Convert boolean to string
    );

    // URL to which the request is to be sent
    $url = 'https://mrobotics.in/api/recharge';

    // Initialize curl
    $ch = curl_init();

    // Set curl options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute curl and get the response
    $response = curl_exec($ch);

    // Close curl
    curl_close($ch);
    
    // Parse the JSON response
    $parsed_response = json_decode($response, true);

    // Extract the status from the parsed response
    $status = isset($parsed_response['status']) ? $parsed_response['status'] : 'unknown';

    // Return the response in a standardized format
    return array('status' => $status, 'message' => 'Request sent successfully', 'response' => $parsed_response, 'all_res' => $response);

    // Return the response
    // return $response;
}

function recharge_statuscheck($apitxnid)
{
    $url = 'https://cyrusrecharge.in/api/rechargestatus.aspx?';
    $data_url = "memberid=AP897886&pin=AAB5C66373&transid=" . $apitxnid . "&format=json";
    $call_url = $url . $data_url;
    $output = curl_get_file_contents($call_url);
    $apiResponse = array();
    $apiResponse = json_decode($output, false);


    return $apiResponse;
}


function viewplans($circle_id, $opcode)
{
    $url = 'https://api.startrecharge.in/Recharge/GetPlanFinder';

    $data = array("Apiuserid" => "API101896", "Token" => "ijXMXKTs36O6w06A1S7alshi4eU0o3", "CircleID" => "{$circle_id}", "OperatorCode" => "{$opcode}");

    $data_string = json_encode($data);

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);

    curl_close($ch);

    return $result;
}

function curl_get_file_contents($URL)
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $URL);
    $contents = curl_exec($c);
    curl_close($c);

    if ($contents) return $contents;
    else return FALSE;
}
