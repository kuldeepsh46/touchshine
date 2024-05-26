<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Callback extends CI_Controller {
    public function index()
    {
        echo "DONE";
    }
    public function induswebhook()
    {
        
        $d = file_get_contents('php://input');
        $data = json_decode($d);
        $pan = $data->username;
        $kyc = $this->db->get_where('indus_kyc',array('pan' => $pan))->row();
        $user = $this->db->get_where('users',array('id' => $kyc->uid))->row();
        if($data->txnType == "MINI_STATEMENT"){
            //mini statement
            
            if($data->status == "SUCCESS"){
                $pan = $data->username;
                $kyc = $this->db->get_where('indus_kyc',array('pan' => $pan))->row();
                $user = $this->db->get_where('users',array('id' => $kyc->uid))->row();
                $ardata = array(
                    'uid' => $kyc->uid,
                    'type' => "IN-MS",
                    'txnid' => $data->txnId,
                    'amount' => "0",
                    'status' => $data->status,
                    'message' => $data->statusDesc,
                    'aadhar' => $data->customeridentIfication,
                    'rrn' => $data->rrn,
                    'userid' => $pan,
                    'response' => $d,
                    'site' => $kyc->site
                    );
                    $this->db->insert('naepstxn',$ardata);
                    $this->load->model("naeps_model");
                    $this->naeps_model->msCommission($kyc->uid,$data->txnId);
                    
                    $rid= $this->db->get_where('sites',array('id' => $user->site))->row()->rid;
                    $wpackage = $this->db->get_where('reseller',array('id' => $rid))->row()->package;
                    $wcom = $this->db->get_where('mscom',array('package' => $wpackage,'type' => '2'))->row()->amount;
    		        $udata = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row();
                    $site = $kyc->site;
                    $sdata = $this->db->get_where('sites',array('id' => $site))->row();
                    
                    $walletbalance = $this->db->get_where('reseller',array('id' => $rid))->row()->wallet;
                    //adding amount to reseller Wallet
                    $rnewbalance = $walletbalance + $wcom;
                    $this->db->update('reseller',array('wallet' => $rnewbalance),array('id' => $rid));
                    //adding end 
                    //making entry
                    $rdata = array(
                        'type' => "IN-MS-COMMISSION",
                        'txnid' => $data->txnId,
                        'amount' => $wcom,
                        'closing' => $rnewbalance,
                        'opening' => $walletbalance,
                        'rid' => $rid
                    );                                   
                    $this->db->insert('rtransaction',$rdata);
                    
                    
            }else{
                //failed
                $pan = $data->username;
                $kyc = $this->db->get_where('indus_kyc',array('pan' => $pan))->row();
                $user = $this->db->get_where('users',array('id' => $kyc->uid))->row();
                $ardata = array(
                    'uid' => $kyc->uid,
                    'type' => "IN-MS",
                    'txnid' => $data->txnId,
                    'amount' => "0",
                    'status' => $data->status,
                    'message' => $data->statusDesc,
                    'aadhar' => $data->customeridentIfication,
                    'rrn' => $data->rrn,
                    'userid' => $pan,
                    'response' => $d,
                    'site' => $kyc->site
                    );
                    $this->db->insert('naepstxn',$ardata);
            }
            
            
            
            
        }elseif($data->txnType == "ENQUIRY"){
            //balance enquery
            if($data->status == "SUCCESS"){
                $pan = $data->username;
                $kyc = $this->db->get_where('indus_kyc',array('pan' => $pan))->row();
                $user = $this->db->get_where('users',array('id' => $kyc->uid))->row();
                $ardata = array(
                    'uid' => $kyc->uid,
                    'type' => "IN-BE",
                    'txnid' => $data->txnId,
                    'amount' => "0",
                    'status' => $data->status,
                    'message' => $data->statusDesc,
                    'aadhar' => $data->customeridentIfication,
                    'rrn' => $data->rrn,
                    'userid' => $pan,
                    'response' => $d,
                    'site' => $kyc->site
                    );
                    $this->db->insert('naepstxn',$ardata);
            }else{
                //failed
                $pan = $data->username;
                $kyc = $this->db->get_where('indus_kyc',array('pan' => $pan))->row();
                $user = $this->db->get_where('users',array('id' => $kyc->uid))->row();
                $ardata = array(
                    'uid' => $kyc->uid,
                    'type' => "IN-BE",
                    'txnid' => $data->txnId,
                    'amount' => "0",
                    'status' => $data->status,
                    'message' => $data->statusDesc,
                    'aadhar' => $data->customeridentIfication,
                    'rrn' => $data->rrn,
                    'userid' => $pan,
                    'response' => $d,
                    'site' => $kyc->site
                    );
                    $this->db->insert('naepstxn',$ardata);
            }
        }elseif($data->txnType == "WITHDRAW"){
            //withdrawal
            if($data->status == "SUCCESS"){
                $pan = $data->username;
                $kyc = $this->db->get_where('indus_kyc',array('pan' => $pan))->row();
                $user = $this->db->get_where('users',array('id' => $kyc->uid))->row();
                $ardata = array(
                    'uid' => $kyc->uid,
                    'type' => "IN-CW",
                    'txnid' => $data->txnId,
                    'amount' => $data->txnAmount,
                    'status' => $data->status,
                    'message' => $data->statusDesc,
                    'aadhar' => $data->customeridentIfication,
                    'rrn' => $data->rrn,
                    'userid' => $pan,
                    'response' => $d,
                    'site' => $user->site
                    );
                    $this->db->insert('naepstxn',$ardata);
                    $wallet = $user->wallet;
                    $amount = $data->txnAmount;
                    $newbal = $wallet + $amount;
                    //update wallet 
                    $this->db->update('users',array('wallet' => $newbal),array('id' => $user->id));
                    //wallet entry 
                    $wdata = array(
                        'uid' => $user->id,
                        'type' => "IN-CW",
                        'txntype' => "CREDIT",
                        'txnid' => $data->txnId,
                        'amount' => $data->txnAmount,
                        'opening' => $wallet,
                        'closing' => $newbal,
                        'site' => $user->site
                        );
                    $this->db->insert('wallet',$wdata);
                   //$amount= (float)$amount;
                    
                    
                    
                    $udata = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row();
                    $site = $user->site;
                    $sdata = $this->db->get_where('sites',array('id' => $site))->row();
                    $rid= $this->db->get_where('sites',array('id' => $site))->row()->rid;
                    $walletbalance = $this->db->get_where('reseller',array('id' => $rid))->row()->wallet;
                    //adding amount to reseller Wallet
                    $rnewbalance = $walletbalance + $data->txnAmount;
                    $this->db->update('reseller',array('wallet' => $rnewbalance),array('id' => $rid));
                    //adding end 
                    //making entry
                    $rdata = array(
                        'type' => "IN-CW",
                        'txnid' => $data->txnId,
                        'amount' => $data->txnAmount,
                        'closing' => $rnewbalance,
                        'opening' => $walletbalance,
                        'rid' => $rid
                    );                                   
                    $this->db->insert('rtransaction',$rdata);
                    //commission
                    $wpackage = $this->db->get_where('reseller',array('id' => $rid))->row()->package;
                    $wcharges = $this->db->get_where('aepscomission',array('package' => $wpackage))->result();
    		        foreach ($wcharges as $charge)
    		        {
    		            if($amount >= $charge->froma && $amount <= $charge->toa)
    		            {
    		              if($charge->percent == 1)
    		              {
    		                  //commission in percent
    		                  $wcom = ($amount * $charge->amount)/100;
    		              }else{
    		                  // comission is flat
    		                  $wcom = $charge->amount;
    		              }
    		            }
    		        }
    		        
                    $walletbalance = $this->db->get_where('reseller',array('id' => $rid))->row()->wallet;
                    //adding amount to reseller Wallet
                    $rnewbalance = $walletbalance + $wcom;
                    $this->db->update('reseller',array('wallet' => $rnewbalance),array('id' => $rid));
                    //adding end 
                    //making entry
                    $rdata = array(
                        'type' => "IN-CW-COMMISSION",
                        'txnid' => $data->txnId,
                        'amount' => $wcom,
                        'closing' => $rnewbalance,
                        'opening' => $walletbalance,
                        'rid' => $rid
                    );                                   
                    $this->db->insert('rtransaction',$rdata);
    		        $this->load->model("naeps_model");
                    $this->naeps_model->commission($kyc->uid,(float)$amount,$data->txnId);
    		        
    		        
            }else{
                //failed
                $pan = $data->username;
                $kyc = $this->db->get_where('indus_kyc',array('pan' => $pan))->row();
                $user = $this->db->get_where('users',array('id' => $kyc->uid))->row();
                $ardata = array(
                    'uid' => $kyc->uid,
                    'type' => "IN-CW",
                    'txnid' => $data->txnId,
                    'amount' => $data->txnAmount,
                    'status' => $data->status,
                    'message' => $data->statusDesc,
                    'aadhar' => $data->customeridentIfication,
                    'rrn' => $data->rrn,
                    'userid' => $pan,
                    'response' => $d,
                    'site' => $user->site
                    );
                    $this->db->insert('naepstxn',$ardata);
            }
        }else{
            exit();
        }
        
        
    }
    public function panreg()
    {
        $data = file_get_contents('php://input');
        $this->db->insert('aeps_indusind',array('response' => "Callback: ".$data));
    }
    public function pancoupon()
    {
        $ipindata = "162.0.220.7";
        $ipofuser =  $_SERVER['HTTP_X_FORWARDED_FOR'];
        $match = 1;
        $arr1 = explode(".",$ipofuser);
        $arr2 = explode(".",$ipindata);
        for($i = 0; $i < 4 ; $i++)
        {
            if($arr1[$i]-$arr2[$i] != 0)
            {
                $match = 0;
            }
        }
        if($match == 0)
        {
            $match = 1;
            $ipindata = "162.0.220.7";
            $ipofuser =  $_SERVER['REMOTE_ADDR'];
            $match = 1;
            $arr1 = explode(".",$ipofuser);
            $arr2 = explode(".",$ipindata);
            for($i = 0; $i < 4 ; $i++)
            {
                if($arr1[$i]-$arr2[$i] != 0)
                {
                    $match = 0;
                }
            }
        }
        if($match == 1)
        {
                 
            $data = $this->input->post("data");
            $data = json_decode($data);
            $txnid = $data->txnid;
            $status = $data->status;
            $count = $this->db->get_where('transaction',array('reference' => $txnid))->num_rows();
            if($count > 0)
            {
                $this->db->where('reference',$txnid);
                $this->db->update('psa',array('status' => $status));
            }
        }
    }
    
}