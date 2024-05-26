<?php

class cd_model extends CI_Model
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

    public function commisionRate($utype)
    {
        $commisionRate = $this->db->get_where('icdpcomission', array('package' => $utype))->row()->amount;
        return $commisionRate;
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
    public function isPercent($utype, $amount)
    {
        $ispercent = $this->db->get_where('icdpcomission', array('package' => $utype, 'froma<=' => $amount, 'toa>=' => $amount))->row()->percent;
        if ($ispercent == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function commission($uid, $amount, $txnid, $site)
    {
        $commision = array();
        $commisioned_user = array();
        $user_n_com = array();

        while ($uid != 0) {
            if ($this->isOwner($uid)) {
                $type = $this->uType($uid);
                $parent_id = $this->isOwner($uid);
                $parent_type =  $this->uType($parent_id);

                if ($this->isPercent($type, $amount)) {
                    $main_commision = (($this->commisionRate($type)) * ($amount / 100)) - array_sum($commision);
                } else {
                    $main_commision = (($this->commisionRate($type))) - array_sum($commision);
                }


                array_push($commision, $main_commision);
                array_push($commisioned_user, $uid);

                if ($this->isPercent($parent_type, $amount)) {
                    $parent_commision = (($this->commisionRate($parent_type)) * ($amount / 100)) - array_sum($commision);
                } else {
                    $parent_commision = (($this->commisionRate($parent_type))) - array_sum($commision);
                }


                array_push($commision, $parent_commision);
                array_push($commisioned_user, $parent_id);
                $uid = $this->isOwner($parent_id);
            } else {
                $type = $this->uType($uid);
                if ($this->isPercent($type, $amount)) {
                    $main_commision = (($this->commisionRate($type)) * ($amount / 100)) - array_sum($commision);
                } else {
                    $main_commision = (($this->commisionRate($type))) - array_sum($commision);
                }
                array_push($commision, $main_commision);
                array_push($commisioned_user, $uid);
                $uid = 0;
            }

            for ($i = 0; $i < count($commision); $i++) {
                $user_n_com[$i] = [$commisioned_user[$i] => $commision[$i]];
            }

            foreach ($user_n_com as $key => $value) {
                foreach ($value as $key => $value) {
                    $openingBal = $this->openingBal($key);
                    $closingBal = $openingBal + $value;
                    $data = ['uid' => $key, 'amount' => $value, 'txnid' => $txnid, 'opening' => $openingBal, 'closing' => $closingBal, 'site' => $site, 'type' => 'I-CD-COMMISSION', 'txntype' => 'CREDIT'];
                    $checkTxn = $this->db->get_where('wallet', array('txnid' => $txnid, 'uid' => $key, 'txntype' => 'CREDIT'))->row()->txnid; //check if there is any entry available with same transaction id(txnid), so that we can save from doind clone entry
                    if ($checkTxn) {
                    } else {
                        $this->db->insert('wallet', $data);
                        $this->updateBal($key, $closingBal);
                    }
                }
            }
        }
    }
}
