<?php

class Cron extends CI_Controller{
    public function index()
    {
        print_r(json_encode(array('status' => "SUCCESS")));
        exit();
    }
    public function payout()
    {
        $d = $this->db->get_where('payouttxn',array('status' => 'PENDING'))->result();
        foreach($d as $da){
            $txnid = $da->txnid;
            $ctxn = $this->db->get_where('payouttxn',array('txnid' => $txnid))->row()->status;
            if($ctxn == "PENDING"){
                $data = [
                    "CORPID" => "576255098",
                    "USERID" => "HARSHPAT",
                    "AGGRID" => "OTOE0113",
                    "URN" => "SR202112501",
                    "UNIQUEID" => $txnid
                ];
                $filepath=fopen("cert/bank.crt","r"); 
                $pub_key_string=fread($filepath,8192);
                fclose($filepath);
        
                openssl_get_publickey($pub_key_string);
                openssl_public_encrypt(json_encode($data), $crypttext, $pub_key_string);
        
                $encryptedRequest = json_encode(base64_encode($crypttext));
        
                $header = [
                    'Content-type:text/plain',
                    'apikey: YmcmYakiCAY4aSVwfvPEzuoKrzsumaig'
                ];
        
                $httpUrl = 'https://apibankingone.icicibank.com/api/Corporate/CIB/v1/TransactionInquiry';
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $httpUrl,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 120,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $encryptedRequest,
                    CURLOPT_HTTPHEADER => $header,
                ));
                $raw_response = curl_exec($curl);
                curl_close($curl);
        
                $fp = fopen("cert/self.key","r");
                $priv_key_string = fread($fp, 8192);
                fclose($fp);
        
                $private_key = openssl_get_privatekey($priv_key_string, "");
        
                openssl_private_decrypt(base64_decode($raw_response), $response, $private_key);
                //echo $priv_key_string;
                $res = json_decode($response);
                if($res->STATUS == "FAILURE"){
                    $this->db->update('payouttxn',array('status' => 'FAILED'),array('txnid' => $txnid));
                    $count = $this->db->get_where('wallet',array('txnid' => $txnid,'type' => 'PAYOUT-REFUND'))->num_rows();
                    if($count > 0){
                        //already refunded
                    }else{
                        $txndata = $this->db->get_where('payouttxn',array('txnid' => $txnid))->row();
                        $user = $this->db->get_where('users',array('id' => $txndata->uid))->row();
                        $wallet = $user->wallet;
                        $amount = $this->db->get_where('wallet',array('txnid' => $txnid,'type' => 'PAYOUT'))->row()->amount;
                        $charge = $this->db->get_where('wallet',array('txnid' => $txnid,'type' => 'PAYOUT-CHARGE'))->row()->amount;
                        $total = $amount + $charge;
                        $closing = $wallet + $amount + $charge;
                        $this->db->update('users',array('wallet' => $closing),array('id' => $user->id));
                        $wrdata = array(
                            'uid' => $user->id,
                            'type' => "PAYOUT-REFUND",
                            'txntype' => "CREDIT",
                            'txnid' => $txnid,
                            'amount' => $total,
                            'opening' => $wallet,
                            'closing' => $closing,
                            'site' => $user->site
                        );
                        $this->db->insert('wallet',$wrdata);
                        // refund to reseller 
                        $cr = $this->db->get_where('rtransaction',array('txnid' => $txnid,'type' => 'PAYOUT-REFUND'))->num_rows();
                        if($cr > 0){
                            
                        }else{
                            //refund
                            $uid = $user->id;
                            $site = $user->site;
                            $rid = $this->db->get_Where('sites',array('id' => $site))->row()->rid;
                            $rdata = $this->db->get_where('reseller',array('id' => $rid))->row();
                            $opening = $rdata->wallet;
                            $amount = $this->db->get_where('rtransaction',array('txnid' => $txnid,'type' => 'PAYOUT'))->row()->amount;
                            $charge = $this->db->get_where('rtransaction',array('txnid' => $txnid,'type' => 'PAYOUT-CHARGE'))->row()->amount;
                            if($charge > 0){
                                $total = $amount + $charge;
                            }else{
                                $total = $amount;
                            }
                            $closing = $opening + $total;
                            $this->db->update('reseller',array('wallet' => $closing),array('id' => $rid));
                            $wdata = array(
                                'type' => "PAYOUT-REFUND",
                                'txnid' => $txnid,
                                'amount' => $total,
                                'opening' => $opening,
                                'closing' => $closing,
                                'rid' => $rid
                            );
                            $this->db->insert('rtransaction',$wdata);
                        }
                        
                        
                        
                    }
                }else{
                    //success or pending
                    if($res->STATUS == "SUCCESS"){
                        $this->db->update('payouttxn',array('status' => 'FAILED'),array('txnid' => $txnid));
                    }
                }
               
            }
        }

    }
    public function qtransfer()
    {
        $d = $this->db->get_where('qtransfertxn',array('status' => 'PENDING'))->result();
        foreach($d as $da){
            $txnid = $da->txnid;
            $ctxn = $this->db->get_where('qtransfertxn',array('txnid' => $txnid))->row()->status;
            if($ctxn == "PENDING"){
                $data = [
                    "CORPID" => "576255098",
                    "USERID" => "HARSHPAT",
                    "AGGRID" => "OTOE0113",
                    "URN" => "SR202112501",
                    "UNIQUEID" => $txnid
                ];
                $filepath=fopen("cert/bank.crt","r"); 
                $pub_key_string=fread($filepath,8192);
                fclose($filepath);
        
                openssl_get_publickey($pub_key_string);
                openssl_public_encrypt(json_encode($data), $crypttext, $pub_key_string);
        
                $encryptedRequest = json_encode(base64_encode($crypttext));
        
                $header = [
                    'Content-type:text/plain',
                    'apikey: YmcmYakiCAY4aSVwfvPEzuoKrzsumaig'
                ];
        
                $httpUrl = 'https://apibankingone.icicibank.com/api/Corporate/CIB/v1/TransactionInquiry';
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $httpUrl,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 120,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $encryptedRequest,
                    CURLOPT_HTTPHEADER => $header,
                ));
                $raw_response = curl_exec($curl);
                curl_close($curl);
        
                $fp = fopen("cert/self.key","r");
                $priv_key_string = fread($fp, 8192);
                fclose($fp);
        
                $private_key = openssl_get_privatekey($priv_key_string, "");
        
                openssl_private_decrypt(base64_decode($raw_response), $response, $private_key);
                //echo $priv_key_string;
                $res = json_decode($response);
                if($res->STATUS == "FAILURE"){
                    $this->db->update('qtransfertxn',array('status' => 'FAILED'),array('txnid' => $txnid));
                    $count = $this->db->get_where('wallet',array('txnid' => $txnid,'type' => 'QTRANSFER-REFUND'))->num_rows();
                    if($count > 0){
                        //already refunded
                    }else{
                        $txndata = $this->db->get_where('qtransfertxn',array('txnid' => $txnid))->row();
                        $user = $this->db->get_where('users',array('id' => $txndata->uid))->row();
                        $wallet = $user->wallet;
                        $amount = $this->db->get_where('wallet',array('txnid' => $txnid,'type' => 'QTRANSFER'))->row()->amount;
                        $charge = $this->db->get_where('wallet',array('txnid' => $txnid,'type' => 'QTRANSFER-CHARGE'))->row()->amount;
                        $total = $amount + $charge;
                        $closing = $wallet + $amount + $charge;
                        $this->db->update('users',array('wallet' => $closing),array('id' => $user->id));
                        $wrdata = array(
                            'uid' => $user->id,
                            'type' => "QTRANSFER-REFUND",
                            'txntype' => "CREDIT",
                            'txnid' => $txnid,
                            'amount' => $total,
                            'opening' => $wallet,
                            'closing' => $closing,
                            'site' => $user->site
                        );
                        $this->db->insert('wallet',$wrdata);
                        // refund to reseller 
                        $cr = $this->db->get_where('rtransaction',array('txnid' => $txnid,'type' => 'QTRANSFER-REFUND'))->num_rows();
                        if($cr > 0){
                            
                        }else{
                            //refund
                            $uid = $user->id;
                            $site = $user->site;
                            $rid = $this->db->get_Where('sites',array('id' => $site))->row()->rid;
                            $rdata = $this->db->get_where('reseller',array('id' => $rid))->row();
                            $opening = $rdata->wallet;
                            $amount = $this->db->get_where('rtransaction',array('txnid' => $txnid,'type' => 'QTRANSFER'))->row()->amount;
                            $charge = $this->db->get_where('rtransaction',array('txnid' => $txnid,'type' => 'QTRANSFER-CHARGE'))->row()->amount;
                            if($charge > 0){
                                $total = $amount + $charge;
                            }else{
                                $total = $amount;
                            }
                            $closing = $opening + $total;
                            $this->db->update('reseller',array('wallet' => $closing),array('id' => $rid));
                            $wdata = array(
                                'type' => "QTRANSFER-REFUND",
                                'txnid' => $txnid,
                                'amount' => $total,
                                'opening' => $opening,
                                'closing' => $closing,
                                'rid' => $rid
                            );
                            $this->db->insert('rtransaction',$wdata);
                        }
                        
                        
                        
                    }
                }else{
                    //success or pending
                    if($res->STATUS == "SUCCESS"){
                        $this->db->update('qtransfertxn',array('status' => 'FAILED'),array('txnid' => $txnid));
                    }
                }
                
            }
        }

    }
    public function dmt()
    {
        $d = $this->db->get_where('dmrtxn',array('status' => 'PENDING'))->result();
        foreach($d as $da){
            $txnid = $da->txnid;
            $ctxn = $this->db->get_where('dmrtxn',array('txnid' => $txnid))->row()->status;
            if($ctxn == "PENDING"){
                $data = [
                    "CORPID" => "576255098",
                    "USERID" => "HARSHPAT",
                    "AGGRID" => "OTOE0113",
                    "URN" => "SR202112501",
                    "UNIQUEID" => $txnid
                ];
                $filepath=fopen("cert/bank.crt","r"); 
                $pub_key_string=fread($filepath,8192);
                fclose($filepath);
        
                openssl_get_publickey($pub_key_string);
                openssl_public_encrypt(json_encode($data), $crypttext, $pub_key_string);
        
                $encryptedRequest = json_encode(base64_encode($crypttext));
        
                $header = [
                    'Content-type:text/plain',
                    'apikey: YmcmYakiCAY4aSVwfvPEzuoKrzsumaig'
                ];
        
                $httpUrl = 'https://apibankingone.icicibank.com/api/Corporate/CIB/v1/TransactionInquiry';
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $httpUrl,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 120,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $encryptedRequest,
                    CURLOPT_HTTPHEADER => $header,
                ));
                $raw_response = curl_exec($curl);
                curl_close($curl);
        
                $fp = fopen("cert/self.key","r");
                $priv_key_string = fread($fp, 8192);
                fclose($fp);
        
                $private_key = openssl_get_privatekey($priv_key_string, "");
        
                openssl_private_decrypt(base64_decode($raw_response), $response, $private_key);
                //echo $priv_key_string;
                $res = json_decode($response);
                if($res->STATUS == "FAILURE"){
                    $this->db->update('dmrtxn',array('status' => 'FAILED'),array('txnid' => $txnid));
                    $count = $this->db->get_where('wallet',array('txnid' => $txnid,'type' => 'DMT-REFUND'))->num_rows();
                    if($count > 0){
                        //already refunded
                    }else{
                        $txndata = $this->db->get_where('dmrtxn',array('txnid' => $txnid))->row();
                        $user = $this->db->get_where('users',array('id' => $txndata->uid))->row();
                        $wallet = $user->wallet;
                        $amount = $this->db->get_where('wallet',array('txnid' => $txnid,'type' => 'DMT'))->row()->amount;
                        $charge = $this->db->get_where('wallet',array('txnid' => $txnid,'type' => 'DMT-CHARGE'))->row()->amount;
                        $total = $amount + $charge;
                        $closing = $wallet + $amount + $charge;
                        $this->db->update('users',array('wallet' => $closing),array('id' => $user->id));
                        $wrdata = array(
                            'uid' => $user->id,
                            'type' => "DMT-REFUND",
                            'txntype' => "CREDIT",
                            'txnid' => $txnid,
                            'amount' => $total,
                            'opening' => $wallet,
                            'closing' => $closing,
                            'site' => $user->site
                        );
                        $this->db->insert('wallet',$wrdata);
                        // refund to reseller 
                        $cr = $this->db->get_where('rtransaction',array('txnid' => $txnid,'type' => 'DMT-REFUND'))->num_rows();
                        if($cr > 0){
                            
                        }else{
                            //refund
                            $uid = $user->id;
                            $site = $user->site;
                            $rid = $this->db->get_Where('sites',array('id' => $site))->row()->rid;
                            $rdata = $this->db->get_where('reseller',array('id' => $rid))->row();
                            $opening = $rdata->wallet;
                            $amount = $this->db->get_where('rtransaction',array('txnid' => $txnid,'type' => 'DMT'))->row()->amount;
                            $charge = $this->db->get_where('rtransaction',array('txnid' => $txnid,'type' => 'DMT-CHARGE'))->row()->amount;
                            if($charge > 0){
                                $total = $amount + $charge;
                            }else{
                                $total = $amount;
                            }
                            $closing = $opening + $total;
                            $this->db->update('reseller',array('wallet' => $closing),array('id' => $rid));
                            $wdata = array(
                                'type' => "DMT-REFUND",
                                'txnid' => $txnid,
                                'amount' => $total,
                                'opening' => $opening,
                                'closing' => $closing,
                                'rid' => $rid
                            );
                            $this->db->insert('rtransaction',$wdata);
                        }
                        
                        
                        
                    }
                }else{
                    //success or pending
                    if($res->STATUS == "SUCCESS"){
                        $this->db->update('dmrtxn',array('status' => 'FAILED'),array('txnid' => $txnid));
                    }
                }
                
            }
        }

    }
}