<?php
error_reporting(0);
require_once('lib/AhkWeb_Config.php');
require_once('lib/AhkWebCheckSum.php');

$checkSum = "";
$upiuid = "";
$paramList = array();

$gateway_type = $_POST['gateway_type'];
$cust_Mobile = $_POST['cust_Mobile'];
$cust_Email = $_POST['cust_Email'];
$orderId = "TEST".time();
$txnAmount = $_POST['txnAmount'];
$txnNote = $_POST['txnNote'];
$callback_url = "https://upifast.in/trial/txnResult.php";

if($gateway_type=="Advanced"){
    
$AHKWEB_TXN_URL='https://upifast.in/order/payment';

$upiuid = 's9a@paytm'; // Its Your Self UPI ID.

}else if($gateway_type=="Robotics"){

$AHKWEB_TXN_URL='https://upifast.in/order/paytm';

$upiuid = 'paytma@paytm'; // Its Paytm Business UPI Unique ID.



}else if($gateway_type=="Normal"){
    
$AHKWEB_TXN_URL='https://upifast.in/order/process';   

$upiuid = '7999780355@paytm';  // Its UPI Unique ID, (Url:http://example.com/UPIsAccounts).

}

// Create an array having all required parameters for creating checksum.
$paramList["upiuid"] = $upiuid;
$paramList["token"] = $token;
$paramList["orderId"] = $orderId ;
$paramList["txnAmount"] = $txnAmount;
$paramList["txnNote"] = $txnNote;
$paramList["callback_url"] = $callback_url;
$paramList["cust_Mobile"] = $cust_Mobile;
$paramList["cust_Email"] = $cust_Email;
$checkSum = AhkWebCheckSum::generateSignature($paramList,$secret);
?>
<html>
<head>
<title>Gateway Check Out Page</title>
</head>
<body>
	<center><h1>Please do not refresh this page...</h1></center>
		<form method="post" action="<?php echo $AHKWEB_TXN_URL ?>" name="f1">
		<table border="1">
			<tbody>
			<?php
			foreach($paramList as $name => $value) {
				echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
			}
			?>
			<input type="hidden" name="checksum" value="<?php echo $checkSum ?>">
			</tbody>
		</table>
		<script type="text/javascript">
			document.f1.submit();
		</script>
	</form>
</body>
</html>
