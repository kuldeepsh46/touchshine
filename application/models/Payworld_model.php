<?php

class Payworld_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getSitedtl() {
        $domain = $_SERVER['HTTP_HOST'];
        $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
        return $sdata;
    }

    public function kycUpload($data) {
        $user = $this->db->get_where('users', array('id' => $_SESSION['uid']))->row();
        //print_r($user);exit;
        $status_message = "";
        // check admin service 
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->rows()->aeps;

        if ($aservice != "1") {
            $status_message = "SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN";
        } else {
            //check whitelabel AepsTxn

            $rid = $this->db->get_where('sites', array('id' => $user->site))->row()->rid;
            $rservice = $this->db->get_where('reseller', array('id' => $rid))->row()->aeps;

            if ($rservice != "1") {
                $status_message = "SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN";
            } else {
                //check reseller service 
                $service = $this->db->get_where('service', array('site' => $user->site))->row()->aeps;
                //echo $service;exit;
                if ($service != "1") {
                    $status_message = "SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN";
                } else {
                    //check user 
                    if ($user->aeps != "1") {
                        $status_message = "SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN";
                    } else {
                        $kc = $this->db->get_where('indus_kyc', array('uid' => $_SESSION['uid']))->num_rows();
                        if ($kc > 0) {
                            $status_message = "ERROR PLEASE CONTACT TO ADMIN";
                        } else {
                            $ardata = array(
                                'uid' => $_SESSION['uid'],
                                'first' => $data['first'],
                                'last' => $data['last'],
                                'email' => $data['email'],
                                'mobile' => $data['mobile'],
                                'address' => $data['address'],
                                'city' => $data['city'],
                                'state' => $data['state'],
                                'shop' => $data['shop'],
                                'aadhar' => $data['aadhar'],
                                'pan' => $data['pan'],
                                'status' => "PENDING",
                                'site' => $user->site
                            );
                            //print_r($ardata);exit;
                            $this->db->insert('indus_kyc', $ardata);
                            $status_message = 1;
                        }
                    }
                }
            }
        }

        return $status_message;
    }

    public function getUserkyc() {
         $row_user = $this->db->get_where('indus_kyc', array('uid' => $_SESSION['uid']))->num_rows();

        if ($row_user > 0) {
           $kyc = $this->db->get_where('indus_kyc', array('uid' => $_SESSION['uid']))->row();
           return $kyc;
        } else {
            return array();
        }
        
    }

    public function getkyc() {
        $kyc = $this->db->get_where('kyc', array('uid' => $_SESSION['uid']))->row();
        return isset($kyc)?$kyc:array();;
    }

    public function getUserdtl() {
        $userdtl = $this->db->get_where('users', array('id' => $_SESSION['uid']))->row();
        return $userdtl;
    }

    public function getUid($agentid) {
        $row_user = $this->db->get_where('indus_kyc', array('agentId' => $agentid))->num_rows();

        if ($row_user > 0) {
            $row_us = $this->db->get_where('indus_kyc', array('agentId' => $agentid))->row();
            return $row_us->uid;
        } else {
            return 0;
        }
    }
    
    function number_pad($number, $n) {
        if ($number < 9000000) {
            return str_pad((int) $number, $n, "0", STR_PAD_LEFT);
        } else {
            return $number;
        }
    }
    
    public function get_lastid(){
        $sql="SELECT id FROM aeps_list ORDER BY id DESC LIMIT 1";
        $query=$this->db->query($sql);
        $row=$query->row_array();
        $id=isset($row['id'])?$row['id']:0;
        return $id+1;
    }

    public function insertAeps($data) {
     // $this->db->insert('test',['data'=>json_encode($data)]);
      
        $ins_q = $this->db->insert('aeps_list', $data);
        $ins_id = $this->db->insert_id();
        return $ins_id;
    }
    
    public function updateAeps($data,$txn_id){
      $this->db->where('txn_id', $txn_id);
      $this->db->update('aeps_list', $data); 
      return 1;
    }

    public function getWalletbyId($user_id) {
        $user_wallet = $this->db->get_where('users', array('id' => $user_id))->row()->wallet;
        return $user_wallet;
    }

    public function getUserbyId($user_id) {
        $user_dtl = $this->db->get_where('users', array('id' => $user_id))->row();
        return $user_dtl;
    }

    public function getUserFromTransaction($txnid) {
        $num_row = $this->db->get_where('aeps_list', array('txn_id' => $txnid, 'status' => 'PENDING'))->num_rows();
        if ($num_row > 0) {
            $row_us = $this->db->get_where('aeps_list', array('txn_id' => $txnid, 'status' => 'PENDING'))->row();
            return $row_us->user_id;
        } else {
            return 0;
        }
    }

    public function getPanno($uid) {
        $row_us = $this->db->get_where('indus_kyc', array('uid' => $uid))->row();
        return $row_us->pan;
    }

    public function insertAepstxn($ardata) {
      //$this->db->insert('test',['data'=>'naeps : '.json_encode($ardata)]);
      if(isset($ardata['userid'])){unset($ardata['userid']); }
        $this->db->insert('naepstxn', $ardata);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function updateUserWallet($wdata) {

        //update user wallet
        $sql_userupd = "UPDATE users SET wallet=wallet+" . $wdata['amount'] . " WHERE id=" . $wdata['uid'];
        $query = $this->db->query($sql_userupd);
        //insert wallet
        $this->db->insert('wallet', $wdata);
        $site = $wdata['site'];
        $sdata = $this->db->get_where('sites', array('id' => $site))->row();
        $rid = $sdata->rid;
        $walletbalance = $this->db->get_where('reseller', array('id' => $rid))->row()->wallet;
        //adding amount to reseller Wallet
        $rnewbalance = $walletbalance + $wdata['amount'];
        $this->db->update('reseller', array('wallet' => $rnewbalance), array('id' => $rid));
        //making entry
        $rdata = array(
            'type' => "PW-CW",
            'txnid' => $wdata['txnid'],
            'amount' => $wdata['amount'],
            'closing' => $rnewbalance,
            'opening' => $walletbalance,
            'rid' => $rid
        );
        $this->db->insert('rtransaction', $rdata);
        //commission
        $wpackage = $this->db->get_where('reseller', array('id' => $rid))->row()->package;
        $wcharges = $this->db->get_where('aepscomission', array('package' => $wpackage))->result();
        $amount=$wdata['amount'];
        foreach ($wcharges as $charge) {
            if ($amount >= $charge->froma && $amount <= $charge->toa) {
                if ($charge->percent == 1) {
                    //commission in percent
                    $wcom = ($amount * $charge->amount) / 100;
                } else {
                    // comission is flat
                    $wcom = $charge->amount;
                }
            }
        }

        $walletbalance = $this->db->get_where('reseller', array('id' => $rid))->row()->wallet;
        //adding amount to reseller Wallet
        $rnewbalance = $walletbalance + $wcom;
        $this->db->update('reseller', array('wallet' => $rnewbalance), array('id' => $rid));
        //adding end 
        //making entry
        $rdata = array(
            'type' => "PW-CW-COMMISSION",
            'txnid' => $wdata['txnid'],
            'amount' => $wcom,
            'closing' => $rnewbalance,
            'opening' => $walletbalance,
            'rid' => $rid
        );
        $this->db->insert('rtransaction', $rdata);
        return 1;
    }
    
    public function debitUserWallet($wdata){
       //update user wallet
        $sql_userupd = "UPDATE users SET wallet=wallet-" . $wdata['amount'] . " WHERE id=" . $wdata['uid'];
        $query = $this->db->query($sql_userupd);
        //insert wallet
        $this->db->insert('wallet', $wdata);
        $site = $wdata['site'];
        $sdata = $this->db->get_where('sites', array('id' => $site))->row();
        $rid = $sdata->rid;
        $walletbalance = $this->db->get_where('reseller', array('id' => $rid))->row()->wallet;
        //removing amount to reseller Wallet
        $rnewbalance = $walletbalance - $wdata['amount'];
        $this->db->update('reseller', array('wallet' => $rnewbalance), array('id' => $rid));
        //making entry
        $rdata = array(
            'type' => "PW-CD",
            'txnid' => $wdata['txnid'],
            'amount' => $wdata['amount'],
            'closing' => $rnewbalance,
            'opening' => $walletbalance,
            'rid' => $rid
        );
        $this->db->insert('rtransaction', $rdata);
        //commission
        $wpackage = $this->db->get_where('reseller', array('id' => $rid))->row()->package;
        $wcharges = $this->db->get_where('icdpcomission', array('package' => $wpackage))->result();
        foreach ($wcharges as $charge) {
            if ($amount >= $charge->froma && $amount <= $charge->toa) {
                if ($charge->percent == 1) {
                    //commission in percent
                    $wcom = ($amount * $charge->amount) / 100;
                } else {
                    // comission is flat
                    $wcom = $charge->amount;
                }
            }
        }

        $walletbalance = $this->db->get_where('reseller', array('id' => $rid))->row()->wallet;
        //adding amount to reseller Wallet
        $rnewbalance = $walletbalance + $wcom;
        $this->db->update('reseller', array('wallet' => $rnewbalance), array('id' => $rid));
        //adding end 
        //making entry
        $rdata = array(
            'type' => "PW-CD-COMMISSION",
            'txnid' => $wdata['txnid'],
            'amount' => $wcom,
            'closing' => $rnewbalance,
            'opening' => $walletbalance,
            'rid' => $rid
        );
        $this->db->insert('rtransaction', $rdata);
        return 1; 
    }

    public function successMinistmt($txnid, $udata) {
        $rid = $this->db->get_where('sites', array('id' => $udata->site))->row()->rid;
        $wpackage = $this->db->get_where('reseller', array('id' => $rid))->row()->package;
        $wcom = $this->db->get_where('mscom', array('package' => $wpackage, 'type' => '2'))->row()->amount;
        //$sdata = $this->db->get_where('sites', array('id' => $udata->site))->row();

        $walletbalance = $this->db->get_where('reseller', array('id' => $rid))->row()->wallet;
        //adding amount to reseller Wallet
        $rnewbalance = $walletbalance + $wcom;
        $this->db->update('reseller', array('wallet' => $rnewbalance), array('id' => $rid));
        //adding end 
        //making entry
        $rdata = array(
            'type' => "PW-MS-COMMISSION",
            'txnid' => $txnid,
            'amount' => $wcom,
            'closing' => $rnewbalance,
            'opening' => $walletbalance,
            'rid' => $rid
        );
        $this->db->insert('rtransaction', $rdata);
        return 1;
    }

}
