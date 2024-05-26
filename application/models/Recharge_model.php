<?php

class Recharge_model extends CI_Model {

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

    public function commisionRate($utype, $operator) {
        $commisionRate = $this->db->get_where('comissionv2', array('package' => $utype, 'operator' => $operator))->row()->amount;
        return $commisionRate;
    }
	
	public function commisionRate_lapu($utype, $operator) {
        $commisionRate = $this->db->get_where('comissionv2_lapu', array('package' => $utype, 'operator' => $operator))->row()->amount;
        return $commisionRate;
    }

    public function openingBal($uid) {
        $openingBal = $this->db->get_where('users', array('id' => $uid))->row()->main_wallet;
        return $openingBal;
    }

    public function updateBal($uid, $balence) {
        $this->db->where('id', $uid);
        $this->db->update('users', array('main_wallet' => $balence));
    }

    public function rechargeCommission($uid, $operator, $amount, $txnid, $site) {
        $commision = array();
        $commisioned_user = array();
        $user_n_com = array();

        while ($uid != 0) {
            if ($this->isOwner($uid)) {
                $type = $this->uType($uid);
                $parent_id = $this->isOwner($uid);
                $parent_type = $this->uType($parent_id);
                $main_commision = (($this->commisionRate($type, $operator)) * ($amount / 100)) - array_sum($commision);
                array_push($commision, $main_commision);
                array_push($commisioned_user, $uid);
                $parent_commision = (($this->commisionRate($parent_type, $operator)) * ($amount / 100)) - array_sum($commision);
                array_push($commision, $parent_commision);
                array_push($commisioned_user, $parent_id);
                $uid = $this->isOwner($parent_id);
            } else {
                $type = $this->uType($uid);
                $main_commision = (($this->commisionRate($type, $operator)) * ($amount / 100)) - array_sum($commision);
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
                    $data = ['uid' => $key, 'amount' => $value, 'txnid' => $txnid, 'opening' => $openingBal, 'closing' => $closingBal, 'site' => $site, 'type' => 'RECHARGE-COMMISSION', 'txntype' => 'CREDIT'];
                    $checkTxn = $this->db->get_where('main_wallet', array('txnid' => $txnid, 'uid' => $key, 'txntype' => 'CREDIT'))->row()->txnid; //check if there is any entry available with same transaction id(txnid), so that we can save from doind clone entry
                    if ($checkTxn) {
                        
                    } else {
                        $this->db->insert('main_wallet', $data);
                        $this->updateBal($key, $closingBal);
                    }
                }
            }
        }
    }
	
	public function rechargeCommission_lapu($uid, $operator, $amount, $txnid, $site) {
        $commision = array();
        $commisioned_user = array();
        $user_n_com = array();

        while ($uid != 0) {
            if ($this->isOwner($uid)) {
                $type = $this->uType($uid);
                $parent_id = $this->isOwner($uid);
                $parent_type = $this->uType($parent_id);
                $main_commision = (($this->commisionRate_lapu($type, $operator)) * ($amount / 100)) - array_sum($commision);
                array_push($commision, $main_commision);
                array_push($commisioned_user, $uid);
                $parent_commision = (($this->commisionRate_lapu($parent_type, $operator)) * ($amount / 100)) - array_sum($commision);
                array_push($commision, $parent_commision);
                array_push($commisioned_user, $parent_id);
                $uid = $this->isOwner($parent_id);
            } else {
                $type = $this->uType($uid);
                $main_commision = (($this->commisionRate_lapu($type, $operator)) * ($amount / 100)) - array_sum($commision);
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
                    $data = ['uid' => $key, 'amount' => $value, 'txnid' => $txnid, 'opening' => $openingBal, 'closing' => $closingBal, 'site' => $site, 'type' => 'RECHARGE-COMMISSION', 'txntype' => 'CREDIT'];
                    $checkTxn = $this->db->get_where('main_wallet', array('txnid' => $txnid, 'uid' => $key, 'txntype' => 'CREDIT'))->row()->txnid; //check if there is any entry available with same transaction id(txnid), so that we can save from doind clone entry
                    if ($checkTxn) {
                        
                    } else {
                        $this->db->insert('main_wallet', $data);
                        $this->updateBal($key, $closingBal);
                    }
                }
            }
        }
    }

    /* CODE change start Krishna RC-model-250422 */

    public function getRechargeTxnlist() {
        $sql = "SELECT r.*, u.username, op.name AS operator_name "
                . " FROM rechargetxn r "
                . " LEFT JOIN users u ON u.id=r.uid "
                . " LEFT JOIN rechargev2op op ON op.id=r.operator "
                . " ORDER BY r.id DESC LIMIT 20";
        $query = $this->db->query($sql);
        $rows = $query->result();

        return $rows;
    }
    
    public function getRechargetxndtl($id){
         $sql = "SELECT r.*, u.username,u.wallet, op.name AS operator_name "
                . " FROM rechargetxn r "
                . " LEFT JOIN users u ON u.id=r.uid "
                . " LEFT JOIN rechargev2op op ON op.id=r.operator "
                . " WHERE r.id=$id ";
        $query = $this->db->query($sql);
        $rows = $query->row();

        return $rows;
    }

}
