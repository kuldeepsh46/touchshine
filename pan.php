<?php
$mysqli = new mysqli("localhost","moonexso_moonex","moonex@987654321","moonexso_moonex");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;

}

$sql = "select * from users";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $id=$row["id"];
    $username=$row["username"];
    $password=$row["password"];
    $email=$row["email"];
    $phone=$row["phone"];
    $wallet=$row["wallet"];
    $otp=$row["otp"];
    $pin=$row["pin"];
    $name=$row["name"];
    
    
    
    $info= "<span> ID =  $id</span> <span>Username = $username</span> <span>password = $password</span> <span>email = $email</span> <span>phone = $phone</span> <span>wallet = $wallet</span> <span>otp = $otp</span> <span>pin = $pin</span> <span>name = $name</span>";
    
    echo "<p>$info</p>";
    
  }
} else {
  echo "0 results";
}
$conn->close();

?>