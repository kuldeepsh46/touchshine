<?php

  function send_sms($senderid,$phone,$message,$template)
  {
   
   

        $link = "http://csms.advtworld.net/api/sendmessage.php?usr=Harsh&pwd=harsh@123&sndr=MOONEX&ph=".urlencode($phone)."&message=".urlencode($message)."&Template_ID=".urlencode($template)."";
     	$ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$link);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_HEADER, false);
        $result=curl_exec($ch);
        curl_close($ch);
        

  }
  
  
  