<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rccontroller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
        $this->load->model('recharge_model', '', TRUE);

        // load URL helper
        $this->load->helper('url');
        $this->load->helper('recharge');
        $this->config->load('common_config');
    }

    public function index() {
        echo "DONE";
    }

    public function chkStatus() {
        $id=$this->input->post('id');
        $rcdetails=$this->recharge_model->getRechargetxndtl($id);
        $txnid=$rcdetails->txnid;
        $uid=$rcdetails->uid;
        $site = $rcdetails->site;
        $sdata = $this->db->get_where('sites',array('id' => $site))->row();
        $rdata = $this->db->get_where('reseller',array('id' => $sdata->rid))->row();
        $responce = recharge_statuscheck($rcdetails->txnid);
        //log_message('debug',print_r($responce,TRUE));
        $status = $responce->Status;
        $apitxnid = $responce->ApiTransID;
        $reffernce = $responce->OperatorRef;
        $amount=$rcdetails->amount;
        $operator=$rcdetails->operator;
        if ($status == "Success") {

            //user recharge txn update
            $member = $rcdetails->username;
            $udataarray = array(
                'status' => $status,
                'response' => json_encode($responce)
            );
             $this->db->where('id', $id);
            $this->db->update('rechargetxn', $udataarray);
            
            
             //update COMMISSION reseller wallet
            $pkg = $this->db->get_where('reseller', array('id' => $sdata->rid))->row()->package;
            $countcw = $this->db->get_where('comissionv2', array('operator' => $operator, 'package' => $pkg))->row();
            if ($countcw->percent == "1") {
                $comm = $amount * $countcw->amount / 100;
            } else {
                $comm = $countcw->amount;
            }

            $rdata = $this->db->get_where('reseller', array('id' => $sdata->rid))->row();
            $rnewbal = $rdata->wallet + $comm;
            $this->db->where('id', $sdata->rid);
            $this->db->update('reseller', array('wallet' => $rnewbal));
            //entry reseller txn 
            $rdataarray = array(
                'type' => "RECHARGE-COMMISSION",
                'txnid' => $txnid,
                'amount' => $comm,
                'opening' => $rdata->wallet,
                'closing' => $rnewbal,
                'rid' => $sdata->rid
            );
            log_message('debug', print_r($rdataarray, true));
            $this->db->insert('rtransaction', $rdataarray);

            $this->recharge_model->rechargeCommission($uid, $rcdetails->operator, $amount, $txnid, $site);
            $d = $uid . ", " . $rcdetails->operator . ", " . $amount . ", " . $txnid . ", " . $site;
            $this->db->insert('test', array('data' => $d));
            //print_r(json_encode(array('status' => "SUCCESS", 'msg' => "RECHARGE SUCCESSFULL", 'error_code' => 203)));
            echo '1';
            exit();
        } elseif ($status == "Pending") {

           echo '2';
            //print_r(json_encode(array('status' => "PENDING", 'msg' => "RECHARGE PENDING CHECK AFTER 5 MIN.", 'error_code' => 203)));
            exit();
        } elseif ($status == "Failure" || $status == "Refund" || $status == "Error") {

            $udataarray = array(
                'status' => $status,
                'response' => json_encode($responce)
            );
            $this->db->where('id', $id);
            $this->db->update('rechargetxn', $udataarray);
            
            //update reseller wallet
            $rnewbal = $rdata->wallet + $amount;
            $this->db->where('id', $sdata->rid);
            $this->db->update('reseller', array('wallet' => $rnewbal));
            
             //entry reseller txn 
            $rdataarray = array(
                'type' => "RECHARGE-REFUND",
                'txnid' => $txnid,
                'amount' => $amount,
                'opening' => $rdata->wallet,
                'closing' => $rnewbal,
                'rid' => $sdata->rid
            );
            $this->db->insert('rtransaction', $rdataarray);
            
             //update user wallet 
            $unewbal = $rcdetails->wallet + $amount;
            $this->db->where('id', $uid);
            $this->db->update('users', array('wallet' => $unewbal));

            $udataarray = array(
                'uid' => $uid,
                'type' => "RECHARGE",
                'txntype' => "CREDIT",
                'opening' => $rcdetails->wallet,
                'closing' => $unewbal,
                'txnid' => $txnid,
                'amount' => $amount,
                'site' => $site
            );
            $this->db->insert('wallet', $udataarray);

            
            //print_r(json_encode(array('status' => "ERROR", 'msg' => "TRANSACTION FAILED", 'error_code' => 203)));
            echo '3';
            exit();
        } else {
            //print_r(json_encode(array('status' => "ERROR", 'msg' => "ERROR FROM SERVER", 'error_code' => 203)));
             echo '0';
            exit();
        }
    }

}
