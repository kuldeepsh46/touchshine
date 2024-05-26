<?php $this->load->view('admin/header'); ?>

<?php
// Database connection
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_api = $_POST["recharge_api"];
    $update_query = "UPDATE settings SET value = '$selected_api' WHERE name = 'recharge_api'";
    if ($conn->query($update_query) === TRUE) {
        echo "Recharge API updated successfully";
        $recharge_api = $selected_api; // Update the displayed value
    } else {
        echo "Error updating recharge API: " . $conn->error;
    }
}

// Retrieve recharge_api setting from the database
$recharge_api_query = "SELECT value FROM settings WHERE name = 'recharge_api'";
$recharge_api_result = $conn->query($recharge_api_query);

$recharge_api = '';
if ($recharge_api_result->num_rows > 0) {
    $row = $recharge_api_result->fetch_assoc();
    $recharge_api = $row["value"];
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recharge API Selection</title>
</head>

<body>
    <h1>Recharge API Selection</h1>
    <form action="" method="post">
        <label for="recharge_api">Select Recharge API:</label>
        <select name="recharge_api" id="recharge_api">
            <option value="CYRUS" <?php if ($recharge_api == 'CYRUS') echo 'selected'; ?>>CYRUS API</option>
            <option value="LAPU" <?php if ($recharge_api == 'LAPU') echo 'selected'; ?>>LAPU API</option>
        </select>
        <br><br>
        <input type="submit" value="Save">
    </form>
</body>

</html>

<?php $this->load->view('admin/footer'); ?>
