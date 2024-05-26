<?php

class payout_model extends CI_Model
{
    public function isOwner($uid)
    {
        $owner = $this->db->get_where('users', array('id' => $uid))->row()->owner;
        if ($owner) {
            return $owner;
        } else {
            return false;
        }
    }

    public function uType($uid)
    {
        $utype = $this->db->get_where('users', array('id' => $uid))->row()->package;
        return $utype;
    }
    public function isPercent($table, $utype, $amount)
    {
        $ispercent = $this->db->get_where($table, array('package' => $utype, 'froma<=' => $amount, 'toa>=' => $amount))->row()->percent;
        if ($ispercent == 0) {
            return false;
        } else {
            return true;
        }
    }
    public function payoutCharge($table, $utype, $amount)
    {
        $payoutCharge = $this->db->get_where($table, array('package' => $utype, 'froma<=' => $amount, 'toa>=' => $amount))->row()->amount;
      // echo $payoutCharge;
        return $payoutCharge;
        
        // return 2;
    }

    public function openingBal($uid)
    {
        $openingBal = $this->db->get_where('users', array('id' => $uid))->row()->wallet;
        return $openingBal;
    }
    public function updateBal($uid, $balence)
    {
        $this->db->where('id', $uid);
        $this->db->update('users', array('wallet' => $balence));
    }


    public function charge($uid, $amount, $txnid, $table, $site)
    {
       $amount= (float)$amount;
        $main_user = $uid;
        // echo  $amount." ". $txnid." ". $site;
        $dddd = $uid." +++ ".$amount." +++ " .$txnid." +++ ".$table." +++ ".$site;
        $this->db->insert('test',array('data'=> $dddd));
        $commision = array();
        $commisioned_user = array();
        $user_n_com = array();
        $type = $this->uType($uid);
        //$parent_id = $this->isOwner($uid);
        //$parent_type =  $this->uType($parent_id);
        if ($this->isPercent($table,$type, $amount)) {
            $main_commision = array_sum($commision) + ($this->payoutCharge($table, $type, $amount) * ($amount / 100));
        } else {
            $main_commision = array_sum($commision) + $this->payoutCharge($table, $type, $amount);
        }

        array_push($commision, $main_commision);
        array_push($commisioned_user, $uid);
        $uid = $this->isOwner($uid);


        while ($uid != 0) {
            if ($this->isOwner($uid)) {
                $childUser = $commisioned_user[count($commisioned_user) - 1];
                $type = $this->uType($uid);
                $parent_id = $this->isOwner($uid);
                $parent_type =  $this->uType($parent_id);
                if ($this->isPercent($table,$type, $amount)) {
                    $main_commision = $this->payoutCharge($table, $type, $amount) * ($amount / 100);
                } else {
                    $main_commision = $this->payoutCharge($table, $type, $amount);
                }

                array_push($commision, $main_commision);
                array_push($commisioned_user, $uid);

                if ($this->isPercent($table,$parent_type, $amount)) {
                    $parent_commision = ($this->payoutCharge($table, $parent_type, $amount) * ($amount / 100));
                } else {
                    $parent_commision = $this->payoutCharge($table, $parent_type, $amount);
                }
                array_push($commision, $parent_commision);
                array_push($commisioned_user, $parent_id);
                $uid = $this->isOwner($parent_id);
            } else {
                $type = $this->uType($uid);
                if ($this->isPercent($table,$type, $amount)) {
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
    }
}
