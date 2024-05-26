<?php

class Spayout_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getSitedtl() {
        $domain = $_SERVER['HTTP_HOST'];
        $resellerDtl = $this->db->get_where('sites', array('domain' => $domain))->row();
        return $resellerDtl;
    }

    public function getPayoutAcc($uid) {
        $data = $this->db->get_where('payoutaccount', array('uid' => $uid, 'status' => "APPROVED"))->result();
        return $data;
    }

    public function checkAdminService() {
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->row()->payout;
        return ($aservice != "1") ? 0 : 1;
    }

    public function chkWhitelabel($uid) {
        $user = $this->db->get_where('users', array('id' => $uid))->row();
        //print_r($user);exit;
        //check user 
        if ($user->payout == "1") {
            //echo 'user payout';
            $rid = $this->db->get_where('sites', array('id' => $user->site))->row()->rid;
            $rservice = $this->db->get_where('reseller', array('id' => $rid))->row()->payout;
            //echo 'resseller service'.$rservice;exit;
            if ($rservice == "0") {
                return 0;
            } else {
                //check reseller service 
                $service = $this->db->get_where('service', array('site' => $user->site))->row()->payout;
                return ($service != "1") ? 0 : 1;
            }
        } else {
            return 0;
        }
    }

    public function isOwner($uid) {
        $owner = $this->db->get_where('users', array('id' => $uid))->row()->owner;
        if ($owner) {
            return $owner;
        } else {
            return false;
        }
    }

    public function uType($uid) {
        $utype = $this->db->get_where('users', array('id' => $uid))->row()->package;
        return $utype;
    }

    public function isPercent($table, $utype, $amount) {
        $ispercent = $this->db->get_where($table, array('package' => $utype, 'froma<=' => $amount, 'toa>=' => $amount))->row()->percent;
        if ($ispercent == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function payoutCharge($table, $utype, $amount) {
        $payoutCharge = $this->db->get_where($table, array('package' => $utype, 'froma<=' => $amount, 'toa>=' => $amount))->row()->amount;
        // echo $payoutCharge;
        return $payoutCharge;

        // return 2;
    }

    public function openingBal($uid) {
        $openingBal = $this->db->get_where('users', array('id' => $uid))->row()->wallet;
        return $openingBal;
    }

    public function updateBal($uid, $balence) {
        $this->db->where('id', $uid);
        $this->db->update('users', array('wallet' => $balence));
    }

    public function getUserDtl($uid) {
        $user = $this->db->get_where('users', array('id' => $uid))->row();
        return $user;
    }

    public function getRsellerDtl($rid) {
        $reseller = $this->db->get_where('reseller', array('id' => $rid))->row();
        return $reseller;
    }

    public function getPayoutCharges($package, $amount, $table) {
        $charges = $this->db->get_where($table, array('package' => $package))->result();
        $chargeamount = 0;
        foreach ($charges as $charge) {
            if ($amount >= $charge->froma && $amount <= $charge->toa) {
                if ($charge->percent == 1) {
                    //commission in percent
                    $chargeamount = ($amount * $charge->amount) / 100;
                } else {
                    // comission is flat
                    $chargeamount = $charge->amount;
                }
            }
        }

        return $chargeamount;
    }

    public function getMaxlimit($package, $table) {
        $this->db->select_max('toa');
        $this->db->from($table);
        $this->db->where(array('package' => $package));
        $query = $this->db->get();
        $r = $query->row();
        $limit = $r->toa;
        return $limit;
    }

    public function getPayoutaccDtl($id) {
        $row = $this->db->get_where('payoutaccount', array('id' => $id))->row_array();
        return $row;
    }

    public function getPendingTxn() {
        $data = $this->db->get_where('payouttxn_safex', array('status' => "PENDING"))->result_array();
        return $data;
    }

    public function payoutProcess($response, $uid, $bid, $mode, $txnNo, $amount) {
        $current_date = date('Y-m-d H:i:s');
        $returnarr = array();
        $payoutBean = $response['payOutBean'];
        $payoutResponse = $response['response'];
        $userDtl = $this->getUserDtl($uid);
        $accDtl = $this->getPayoutaccDtl($bid);

        $payoutTxnIns['uid'] = $uid;
        $payoutTxnIns['txnid'] = $txnNo;
        $payoutTxnIns['account'] = $accDtl['account'];
        $payoutTxnIns['ifsc'] = $accDtl['ifsc'];
        $payoutTxnIns['bname'] = $accDtl['name'];
        $payoutTxnIns['amount'] = $amount;
        $payoutTxnIns['status'] = $payoutBean['txnStatus'];
        $payoutTxnIns['message'] = $payoutResponse['description'];
        $payoutTxnIns['response'] = json_encode($response);
        $payoutTxnIns['rrn'] = $payoutBean['orderRefNo'];
        $payoutTxnIns['mode'] = $mode;
        $payoutTxnIns['date'] = $current_date;
        $payoutTxnIns['site'] = $userDtl->site;
        $payoutTxnIns['bankname'] = $accDtl['bankname'];
        $payoutTxnIns['mobile_no'] = $accDtl['mobile_no'];
        $payoutTxnIns['payout_id'] = $payoutBean['payoutId'];
        $payoutTxnIns['agg_id'] = $payoutBean['aggregatorId'];
        $payoutTxnIns['agg_name'] = $payoutBean['aggregtorName'];
        $payoutTxnIns['bank_status'] = $payoutBean['bankStatus'];
        $payoutTxnIns['status_code'] = $payoutBean['statusCode'];
        $payoutTxnIns['bank_status_code'] = $payoutBean['bankResponseCode'];
        $payoutTxnIns['txn_modified_date'] = $current_date;
        $payoutTxnIns['spk_ref_no'] = $payoutBean['spkRefNo'];
        $payoutTxnIns['payid'] = $payoutBean['id'];
        $payoutTxnIns['bank_ref_no'] = $payoutBean['bankRefNo'];

        $this->db->insert('payouttxn_safex', $payoutTxnIns);

        $ardata = array(
            'uid' => $uid,
            'txnid' => $txnNo,
            'status' => "PENDING",
            'amount' => $amount,
            'response' => json_encode($response),
            'account' => $accDtl['account'],
            'ifsc' => $accDtl['ifsc'],
            'mode' => $mode,
            'bname' => $accDtl['name'],
            'message' => $payoutResponse['description'],
            'site' => $userDtl->site
        );

        //$this->db->insert('payouttxn', $ardata);

        if ($payoutBean['txnStatus'] == 'SUCCESS') {
            $this->payoutSuccess($userDtl, $accDtl, $mode, $txnNo, $amount);
            return $payoutResponse;
        } elseif ($payoutBean['txnStatus'] == 'PENDING') {
            $this->payoutPending($userDtl, $accDtl, $mode, $txnNo, $amount);
            return $payoutResponse;
        } else {
            return $payoutResponse;
        }
    }

    public function payoutSuccess($userDtl, $accDtl, $mode, $txnNo, $amount) {
        $table = ($mode == "IMPS") ? "payoutchargeimps" : "payoutchargeneft";
        $resellerDtl = $this->getRsellerDtl($userDtl->site);
        $chargeamtRes = $this->getPayoutCharges($resellerDtl->package, $amount, $table);
        $walletRes = $resellerDtl->wallet;
        $totalRes = $amount + $chargeamtRes;
        //reseller work 
        //update reseller wallet 
        $wnewbal = $walletRes - $totalRes;
        $this->db->where('id', $userDtl->site);
        $this->db->update('reseller', array('wallet' => $wnewbal));
        // entry of reseller 
        $wdata = array(
            'type' => "PAYOUT",
            'txnid' => $txnNo,
            'amount' => $totalRes,
            'opening' => $walletRes,
            'closing' => $wnewbal,
            'rid' => $userDtl->site
        );

        $this->db->insert('rtransaction', $wdata);
        //update user wallet
        $unewbal = $userDtl->wallet - $amount;
        $this->db->where('id', $userDtl->id);
        $this->db->update('users', array('wallet' => $unewbal));

        $wrdata = array(
            'uid' => $userDtl->id,
            'type' => "PAYOUT",
            'txntype' => "DEBIT",
            'txnid' => $txnNo,
            'amount' => $amount,
            'opening' => $userDtl->wallet,
            'closing' => $unewbal,
            'site' => $userDtl->site
        );

        $this->db->insert('wallet', $wrdata);

        $chargeamount = $this->getPayoutCharges($userDtl->package, $amount, $table);

        $wallet = $userDtl->wallet;
        $unewbal = $wallet - $chargeamount;
        $this->db->where('id', $userDtl->id);
        $this->db->update('users', array('wallet' => $unewbal));
        $wrdata = array(
            'uid' => $userDtl->id,
            'type' => "PAYOUT-CHARGE",
            'txntype' => "DEBIT",
            'txnid' => $txnNo,
            'amount' => $chargeamount,
            'opening' => $wallet,
            'closing' => $unewbal,
            'site' => $userDtl->site
        );

        $this->db->insert('wallet', $wrdata);
        $this->charge($userDtl, $amount, $txnNo, $table);
        return 1;
    }

    public function payoutPending($userDtl, $accDtl, $mode, $txnid, $amount) {
        //reseller work 
        //update reseller wallet 
        $table = ($mode == "IMPS") ? "payoutchargeimps" : "payoutchargeneft";
        $resellerDtl = $this->getRsellerDtl($userDtl->site);
        $rwallet = $this->db->get_where('reseller', array('id' => $resellerDtl->rid))->row()->wallet;
        $wnewbal = $rwallet - $amount;
        $this->db->where('id', $resellerDtl->rid);
        $this->db->update('reseller', array('wallet' => $wnewbal));
        // entry of reseller 
        $wdata = array(
            'type' => "PAYOUT",
            'txnid' => $txnid,
            'amount' => $amount,
            'opening' => $rwallet,
            'closing' => $wnewbal,
            'rid' => $resellerDtl->rid
        );
        $this->db->insert('rtransaction', $wdata);
        $wchargeamount = $this->getPayoutCharges($resellerDtl->package, $amount, $table);

        $rwallet = $resellerDtl->wallet;
        $wnewbal = $rwallet - $wchargeamount;
        $this->db->where('id', $resellerDtl->rid);
        $this->db->update('reseller', array('wallet' => $wnewbal));
        // entry of reseller 
        $wdata = array(
            'type' => "PAYOUT-CHARGE",
            'txnid' => $txnid,
            'amount' => $wchargeamount,
            'opening' => $rwallet,
            'closing' => $wnewbal,
            'rid' => $resellerDtl->rid
        );
        $this->db->insert('rtransaction', $wdata);
        $wallet = $userDtl->wallet;
        //update user wallet 
        $unewbal = $wallet - $amount;
        $this->db->where('id', $userDtl->id);
        $this->db->update('users', array('wallet' => $unewbal));
        //user txn entry 

        $wrdata = array(
            'uid' => $_SESSION['uid'],
            'type' => "PAYOUT",
            'txntype' => "DEBIT",
            'txnid' => $txnid,
            'amount' => $amount,
            'opening' => $wallet,
            'closing' => $unewbal,
            'site' => $userDtl->site
        );

        $this->db->insert('wallet', $wrdata);
        $wallet = $this->db->get_where('users', array('id' => $userDtl->id))->row()->wallet;
        $chargeamount = $this->getPayoutCharges($userDtl->package, $amount, $table);
        $unewbal = $wallet - $chargeamount;
        $this->db->where('id', $userDtl->id);
        $this->db->update('users', array('wallet' => $unewbal));
        $wrdata = array(
            'uid' => $_SESSION['uid'],
            'type' => "PAYOUT-CHARGE",
            'txntype' => "DEBIT",
            'txnid' => $txnid,
            'amount' => $chargeamount,
            'opening' => $wallet,
            'closing' => $unewbal,
            'site' => $userDtl->site
        );

        $this->db->insert('wallet', $wrdata);
        return 1;
    }

    public function charge($userDtl, $amt, $txnid, $table) {
        $amount = (float) $amt;
        $uid = $userDtl->id;
        $site = $userDtl->site;
        $main_user = $userDtl->id;
        // echo  $amount." ". $txnid." ". $site;
        $dddd = $userDtl->id . " +++ " . $amount . " +++ " . $txnid . " +++ " . $table . " +++ " . $site;
        $this->db->insert('test', array('data' => $dddd));
        $commision = array();
        $commisioned_user = array();
        $user_n_com = array();
        $type = $userDtl->package;
        //$parent_id = $this->isOwner($uid);
        //$parent_type =  $this->uType($parent_id);
        if ($this->isPercent($table, $type, $amount)) {
            $main_commision = array_sum($commision) + ($this->payoutCharge($table, $type, $amount) * ($amount / 100));
        } else {
            $main_commision = array_sum($commision) + $this->payoutCharge($table, $type, $amount);
        }

        array_push($commision, $main_commision);
        array_push($commisioned_user, $uid);
        $uid = $this->isOwner($userDtl->id);


        while ($uid != 0) {
            if ($this->isOwner($uid)) {
                $childUser = $commisioned_user[count($commisioned_user) - 1];
                $type = $this->uType($uid);
                $parent_id = $this->isOwner($uid);
                $parent_type = $this->uType($parent_id);
                if ($this->isPercent($table, $type, $amount)) {
                    $main_commision = $this->payoutCharge($table, $type, $amount) * ($amount / 100);
                } else {
                    $main_commision = $this->payoutCharge($table, $type, $amount);
                }

                array_push($commision, $main_commision);
                array_push($commisioned_user, $uid);

                if ($this->isPercent($table, $parent_type, $amount)) {
                    $parent_commision = ($this->payoutCharge($table, $parent_type, $amount) * ($amount / 100));
                } else {
                    $parent_commision = $this->payoutCharge($table, $parent_type, $amount);
                }
                array_push($commision, $parent_commision);
                array_push($commisioned_user, $parent_id);
                $uid = $this->isOwner($parent_id);
            } else {
                $type = $this->uType($uid);
                if ($this->isPercent($table, $type, $amount)) {
                    $main_commision = ($this->payoutCharge($table, $type, $amount) * ($amount / 100));
                } else {
                    $main_commision = $this->payoutCharge($table, $type, $amount);
                }
                array_push($commision, $main_commision);
                array_push($commisioned_user, $uid);
                $uid = 0;
            }
            $f_commision = array();
            for ($i = 0; $i < count($commision); $i++) {
                if ($i == 0) {
                    $f_commision[$i] = 0 - $commision[$i];
                } else {
                    $f_commision[$i] = $commision[$i - 1] - $commision[$i];
                }
            }


            for ($i = 0; $i < count($f_commision); $i++) {
                $user_n_com[$i] = [$commisioned_user[$i] => $f_commision[$i]];
            }



            foreach ($user_n_com as $key => $value) {
                foreach ($value as $key => $value) {
                    $openingBal = $this->openingBal($key);

                    if ($key != $main_user) {
                        $closingBal = $openingBal + $value;

                        if ($value < 0) {
                            $txntype = 'DEBIT';
                        } else {
                            $txntype = 'CREDIT';
                        }
                        $c_type = "PAYOUT-CHARGE";
                        //$value = str_replace('-', '', $value);

                        $data = ['uid' => $key, 'amount' => $value, 'txnid' => $txnid, 'opening' => $openingBal, 'closing' => $closingBal, 'site' => $site, 'type' => $c_type, 'txntype' => $txntype];
                        $checkTxn = $this->db->get_where('wallet', array('txnid' => $txnid, 'uid' => $key, 'txntype' => $txntype, 'type' => $c_type))->row()->txnid; //check if there is any entry available with same transaction id(txnid), so that we can save from doind clone entry
                        if ($checkTxn) {
                            
                        } else {
                            $this->db->insert('wallet', $data);
                            $this->updateBal($key, $closingBal);
                        }
                    }
                }
            }
            // print_r($user_n_com);
        }

        return 1;
    }

    public function payoutStatuschk($response, $accDtl) {
        $uid = $accDtl['uid'];
        $mode = $accDtl['mode'];
        $table = ($mode == "IMPS") ? "payoutchargeimps" : "payoutchargeneft";

        $current_date = date('Y-m-d H:i:s');

        $payoutBean = $response['payOutBean'];
        $payoutResponse = $response['response'];
        $userDtl = $this->getUserDtl($uid);


        $payoutTxnUpd['bank_status'] = $payoutBean['bankStatus'];
        $payoutTxnUpd['status_code'] = $payoutBean['statusCode'];
        $payoutTxnUpd['bank_status_code'] = $payoutBean['bankResponseCode'];
        $payoutTxnUpd['txn_modified_date'] = $current_date;
        $payoutTxnUpd['status'] = $payoutBean['txnStatus'];
        $payoutTxnUpd['status_chk_response'] = json_encode($response);

        $this->db->update('payouttxn_safex', $payoutTxnUpd, array('id' => $accDtl['id']));

        if ($payoutBean['txnStatus'] == 'SUCCESS') {
            $this->charge($userDtl, $accDtl['amount'], $accDtl['txn_id'], $table);
            return 1;
        } elseif ($payoutBean['txnStatus'] == 'FAILED') {
            $rdatar = $this->db->get_where('rtransaction', array('txnid' => $accDtl['txn_id']))->row();
            $wtotal = $rdatar->amount;
            $rwallet = $this->db->get_where('reseller', array('id' => $rdatar->rid))->row()->wallet;
            $wnewbal = $rwallet + $wtotal;
            $this->db->where('id', $rdatar->rid);
            $this->db->update('reseller', array('wallet' => $wnewbal));
            // entry of reseller 
            $wdata = array(
                'type' => "PAYOUT-REFUND",
                'txnid' => $accDtl['txn_id'],
                'amount' => $wtotal,
                'opening' => $rwallet,
                'closing' => $wnewbal,
                'rid' => $rdatar->rid
            );
            $this->db->insert('rtransaction', $wdata);
            //update user wallet 
            $wallet = $this->db->get_where('users', array('id' => $uid))->row()->wallet;
            $amt = $this->db->get_where('wallet', array('txnid' => $accDtl['txn_id'], 'type' => 'PAYOUT'))->row()->amount;
            $char = $this->db->get_where('wallet', array('txnid' => $accDtl['txn_id'], 'type' => 'PAYOUT-CHARGE'))->row()->amount;
            $total = $amt + $char;
            $unewbal = $wallet + $total;
            $this->db->where('id', $uid);
            $this->db->update('users', array('wallet' => $unewbal));
            $txnd = $this->db->get_where('payouttxn_safex', array('txnid' => $accDtl['txn_id']))->row();


            $wrdata = array(
                'uid' => $uid,
                'type' => "PAYOUT-REFUND",
                'txntype' => "CREDIT",
                'txnid' => $accDtl['txn_id'],
                'amount' => $total,
                'opening' => $wallet,
                'closing' => $unewbal,
                'site' => $txnd->site
            );
            $this->db->insert('wallet', $wrdata);
            return 1;
        } else {
            return 0;
        }
    }

}
