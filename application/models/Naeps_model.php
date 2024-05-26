<?php

class naeps_model extends CI_Model
{
    public function isOwner($uid)
    {
        $owner = $this->db->get_where('users', array('id' => $uid))->row()->owner;
        if ($owner) {
            return $owner;
        } else {
            return 0;
        }
    }

    public function uType($uid)
    {
        $utype = $this->db->get_where('users', array('id' => $uid))->row()->package;
        // echo $utype . "<br>";
        return $utype;
    }

    public function commisionRate($utype, $amount)
    {
        $commisionRate = $this->db->get_where('aepscomission', array('package' => $utype, 'froma<=' => $amount, 'toa>=' => $amount))->row()->amount;
        return $commisionRate;
    }
    public function msCommisionRate($utype)
    {
        $commisionRate = $this->db->get_where('mscom', array('package' => $utype, 'type' => 2))->row()->amount;
        return $commisionRate;
    }
    public function isPercent($utype, $amount)
    {
        $ispercent = $this->db->get_where('aepscomission', array('package' => $utype, 'froma<=' => $amount, 'toa>=' => $amount))->row()->percent;
        if ($ispercent == 0) {
            return false;
        } else {
            return true;
        }
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


    //ms commission start
    public function msCommission($uid, $txnid)
    {
        $site = $this->db->get_where('users', array('id' => $uid))->row()->site;
        $commision = array();
        $commisioned_user = array();
        $user_n_com = array();
        while ($uid != 0) {
            if ($this->isOwner($uid)) {
                $type = $this->uType($uid);
                $parent_id = $this->isOwner($uid);
                $parent_type =  $this->uType($parent_id);
                $main_commision = $this->msCommisionRate($type);
                // echo $main_commision."<br>".
                array_push($commision, $main_commision);
                array_push($commisioned_user, $uid);
                $parent_commision = $this->msCommisionRate($parent_type);
                array_push($commision, $parent_commision);
                array_push($commisioned_user, $parent_id);
                $uid = $this->isOwner($parent_id);
            } else {
                $type = $this->uType($uid);
                $main_commision = $this->msCommisionRate($type);

                array_push($commision, $main_commision);
                array_push($commisioned_user, $uid);
                $uid = 0;
            }
            $commission_n = array();
            $commission_f = array();
            foreach ($commision as $key => $value) {
                $commission_n[] = $value;
            }
            for ($i = 0; $i < count($commission_n); $i++) {
                $commission_f[$i] = $commission_n[$i] - $commission_n[$i - 1];
            }

            for ($i = 0; $i < count($commission_f); $i++) {
                $user_n_com[$i] = [$commisioned_user[$i] => $commission_f[$i]];
            }

            foreach ($user_n_com as $key => $value) {
                foreach ($value as $key => $value) {
                    $openingBal = $this->openingBal($key);
                    $closingBal = $openingBal + $value;
                    $data = ['uid' => $key, 'amount' => $value, 'txnid' => $txnid, 'opening' => $openingBal, 'closing' => $closingBal, 'site' => $site, 'type' => 'N-MS-COMMISSION', 'txntype' => 'CREDIT'];
                    $checkTxn = $this->db->get_where('wallet', array('txnid' => $txnid, 'uid' => $key, 'txntype' => 'CREDIT', 'type' => 'N-MS-COMMISSION'))->row()->txnid; //check if there is any entry available with same transaction id(txnid), so that we can save from doind clone entry
                    if ($checkTxn) {
                      //  print_r($data);
                    } else {
                        $this->db->insert('wallet', $data);
                        $this->updateBal($key, $closingBal);
                    }
                }
            }
        }
    }
    //ms commission -->

    public function commission($uid, $amount, $txnid)
    {
        $site = $this->db->get_where('users', array('id' => $uid))->row()->site;
        $commision = array();
        $commisioned_user = array();
        $user_n_com = array();
        while ($uid != 0) {
            if ($this->isOwner($uid)) {
                $type = $this->uType($uid);
                //echo $uid;
                $parent_id = $this->isOwner($uid);
                $parent_type =  $this->uType($parent_id);

                if ($this->isPercent($type, $amount)) {
                    //echo "percent ";
                    $main_commision = $this->commisionRate($type, $amount) * ($amount / 100);
                } else {
                    $main_commision = $this->commisionRate($type, $amount);
                }

                // echo $main_commision."<br>".
                array_push($commision, $main_commision);
                array_push($commisioned_user, $uid);
                if ($this->isPercent($parent_type, $amount)) {
                    //echo "percent ";
                    $parent_commision = $this->commisionRate($parent_type, $amount) * ($amount / 100);
                } else {

                    $parent_commision = $this->commisionRate($parent_type, $amount);
                }


                array_push($commision, $parent_commision);
                array_push($commisioned_user, $parent_id);
                $uid = $this->isOwner($parent_id);
            } else {
                $type = $this->uType($uid);
                if ($this->isPercent($type, $amount)) {
                    echo "percent ";
                    $main_commision = $this->commisionRate($type, $amount) * ($amount / 100);
                } else {

                    $main_commision = $this->commisionRate($type, $amount);
                }

                array_push($commision, $main_commision);
                array_push($commisioned_user, $uid);
                $uid = 0;
            }
            $commission_n = array();
            $commission_f = array();
            foreach ($commision as $key => $value) {
                $commission_n[] = $value;
                //echo $value . "<br>";
            }
            for ($i = 0; $i < count($commission_n); $i++) {
                $commission_f[$i] = $commission_n[$i] - $commission_n[$i - 1];
            }

            for ($i = 0; $i < count($commission_f); $i++) {
                $user_n_com[$i] = [$commisioned_user[$i] => $commission_f[$i]];
            }

            foreach ($user_n_com as $key => $value) {
                foreach ($value as $key => $value) {
                    $openingBal = $this->openingBal($key);
                    $closingBal = $openingBal + $value;
                    $c_type = "NAEPS-COMISSION";
                    $data = ['uid' => $key, 'amount' => $value, 'txnid' => $txnid, 'opening' => $openingBal, 'closing' => $closingBal, 'site' => $site, 'type' => $c_type, 'txntype' => 'CREDIT'];
                    $checkTxn = $this->db->get_where('wallet', array('txnid' => $txnid, 'uid' => $key, 'txntype' => 'CREDIT', 'type' => $c_type))->row()->txnid; //check if there is any entry available with same transaction id(txnid), so that we can save from doind clone entry
                    if ($checkTxn) {
                    } else {
                        $this->db->insert('wallet', $data);
                        $this->updateBal($key, $closingBal);
                    }
                }
            }
        }
        //print_r($commission_n);
    }
}
