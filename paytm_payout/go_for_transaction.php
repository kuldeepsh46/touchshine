<?php
error_reporting(1);
               $match = 1;
               $ip = "162.0.220.7";
               $arr1 = explode(".",$_SERVER['REMOTE_ADDR']);
               $arr2 = explode(".",$ip);
               
               for($i = 0; $i < 4 ; $i++)
               {
                   if($arr1[$i]-$arr2[$i] != 0)
                   {
                     
                     $match = 0;
                   }
                   
               }
               
               if($match == 0)
               {
                   echo '{
    "status": "FAILURE",
    "statusCode": "DE_040",
    "statusMessage": "IP NOT MATCH"
} ';       


                   exit();
               }



class PaytmChecksum{

	private static $iv = "@@@@&&&&####$$$$";

	static public function encrypt($input, $key) {
		$key = html_entity_decode($key);

		if(function_exists('openssl_encrypt')){
			$data = openssl_encrypt ( $input , "AES-128-CBC" , $key, 0, self::$iv );
		} else {
			$size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
			$input = self::pkcs5Pad($input, $size);
			$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', '');
			mcrypt_generic_init($td, $key, self::$iv);
			$data = mcrypt_generic($td, $input);
			mcrypt_generic_deinit($td);
			mcrypt_module_close($td);
			$data = base64_encode($data);
		}
		return $data;
	}

	static public function decrypt($encrypted, $key) {
		$key = html_entity_decode($key);
		
		if(function_exists('openssl_decrypt')){
			$data = openssl_decrypt ( $encrypted , "AES-128-CBC" , $key, 0, self::$iv );
		} else {
			$encrypted = base64_decode($encrypted);
			$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', '');
			mcrypt_generic_init($td, $key, self::$iv);
			$data = mdecrypt_generic($td, $encrypted);
			mcrypt_generic_deinit($td);
			mcrypt_module_close($td);
			$data = self::pkcs5Unpad($data);
			$data = rtrim($data);
		}
		return $data;
	}

	static public function generateSignature($params, $key) {
		if(!is_array($params) && !is_string($params)){
			throw new Exception("string or array expected, ".gettype($params)." given");			
		}
		if(is_array($params)){
			$params = self::getStringByParams($params);			
		}
		return self::generateSignatureByString($params, $key);
	}

	static public function verifySignature($params, $key, $checksum){
		if(!is_array($params) && !is_string($params)){
			throw new Exception("string or array expected, ".gettype($params)." given");
		}
		if(isset($params['CHECKSUMHASH'])){
			unset($params['CHECKSUMHASH']);
		}
		if(is_array($params)){
			$params = self::getStringByParams($params);
		}		
		return self::verifySignatureByString($params, $key, $checksum);
	}

	static private function generateSignatureByString($params, $key){
		$salt = self::generateRandomString(4);
		return self::calculateChecksum($params, $key, $salt);
	}

	static private function verifySignatureByString($params, $key, $checksum){
		$paytm_hash = self::decrypt($checksum, $key);
		$salt = substr($paytm_hash, -4);
		return $paytm_hash == self::calculateHash($params, $salt) ? true : false;
	}

	static private function generateRandomString($length) {
		$random = "";
		srand((double) microtime() * 1000000);

		$data = "9876543210ZYXWVUTSRQPONMLKJIHGFEDCBAabcdefghijklmnopqrstuvwxyz!@#$&_";	

		for ($i = 0; $i < $length; $i++) {
			$random .= substr($data, (rand() % (strlen($data))), 1);
		}

		return $random;
	}

	static private function getStringByParams($params) {
		ksort($params);		
		$params = array_map(function ($value){
			return ($value !== null && strtolower($value) !== "null") ? $value : "";
	  	}, $params);
		return implode("|", $params);
	}

	static private function calculateHash($params, $salt){
		$finalString = $params . "|" . $salt;
		$hash = hash("sha256", $finalString);
		return $hash . $salt;
	}

	static private function calculateChecksum($params, $key, $salt){
		$hashString = self::calculateHash($params, $salt);
		return self::encrypt($hashString, $key);
	}

	static private function pkcs5Pad($text, $blocksize) {
		$pad = $blocksize - (strlen($text) % $blocksize);
		return $text . str_repeat(chr($pad), $pad);
	}

	static private function pkcs5Unpad($text) {
		$pad = ord($text[strlen($text) - 1]);
		if ($pad > strlen($text))
			return false;
		return substr($text, 0, -1 * $pad);
	}
}

$data = base64_decode($_POST['data']);
$data = json_decode($data);

 $key = $data->skey;

if($key == "354764534453211355645455646545643221354631")
{
    
    
$paytmParams = array();

$paytmParams["subwalletGuid"]      = $data->nguid;
$paytmParams["orderId"]            = $data->txnid;
$paytmParams["beneficiaryVPA"] = $data->upi;
$paytmParams["beneficiaryAccount"] = $data->accno;
$paytmParams["beneficiaryIFSC"]    = $data->ifsc;
$paytmParams["amount"]             = $data->amount;
$paytmParams["beneficiaryName"] = $data->bname;


$paytmParams["callbackUrl"] = "https://partner.ecuzen.in/payout/callback_url";
$paytmParams["transferMode"] = $data->mode;
$paytmParams["transactionType"] = "NON_CASHBACK";


$paytmParams["purpose"]            = $data->purpose;
$paytmParams["date"]               = $data->date;

$post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);


$checksum = PaytmChecksum::generateSignature($post_data, "gHOzWYtSkBcmdIO@");

$x_mid      = "ECUZEN31135371924095";
$x_checksum = $checksum;

$url = "https://dashboard.paytm.com/bpay/api/v1/disburse/order/bank";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "x-mid: " . $x_mid, "x-checksum: " . $x_checksum)); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
$response = curl_exec($ch);



print_r($response);



}else{
    
    echo "ACCESS RESTRICTED";

}



