<?php

class Partner_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    
    public function getKycCount($rid){
        $sql="SELECT count(*) AS total_kyc , "
                . " SUM(case when active = '0' then 1 else 0 end) AS pending_kyc, "
                . " SUM(case when active = '1' then 1 else 0 end) AS completed_kyc, "
                . " SUM(case when active = NULL then 1 else 0 end) AS incomplete_kyc "
                . " FROM `kyc` WHERE site=$rid ";
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row;
    }
    
    public function getaepsKycCount($rid){
        $sql="SELECT count(*) AS total_aekyc , "
                . " SUM(case when status = 'PENDING' then 1 else 0 end) AS pending_aekyc, "
                . " SUM(case when status = 'APPROVED' then 1 else 0 end) AS completed_aekyc"
                . " FROM `indus_kyc` WHERE site=$rid ";
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row;
    }
    
    public function getUserCount($rid){
              $sql="SELECT count(*) AS total_users , "
                . " SUM(case when active = '0' then 1 else 0 end) AS inactive_users, "
                . " SUM(case when active = '1' then 1 else 0 end) AS active_users "
                . " FROM `users` WHERE site=$rid ";
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row;  
    }
    public function getresellerCount(){
              $sql="SELECT count(*) AS total_reseller , "
                . " SUM(case when active = '0' then 1 else 0 end) AS inactive_reseller, "
                . " SUM(case when active = '1' then 1 else 0 end) AS active_reseller "
                . " FROM `reseller`";
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row;  
    }
    
   
    
    public function getaepsCount($rid){
              $sql="SELECT count(*) AS total_aeps , "
                . " SUM(case when status = 'Success' then 1 else 0 end) AS tot_success_aeps, "
                . " SUM(case when status = 'Pending' then 1 else 0 end) AS tot_pending_aeps, "
                . " SUM(case when status = 'Decline' then 1 else 0 end) AS tot_decline_aeps, "
                . " SUM(case when status = 'Failed' then 1 else 0 end) AS tot_failed_aeps "
                . " FROM `aeps_list` WHERE site=$rid ";
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row;  
    }
    
    public function getPayoutCount($rid){
              $sql="SELECT count(*) AS total_payout , "
                . " SUM(case when status = 'SUCCESS' then 1 else 0 end) AS tot_success_payout, "
                . " SUM(case when status = 'PENDING' then 1 else 0 end) AS tot_pending_payout, "
                . " SUM(case when status = 'FAILED' then 1 else 0 end) AS tot_failed_payout "
                . " FROM `payouttxn` WHERE site=$rid ";
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row;  
    }
    
    public function getPayoutAccCount($rid){
              $sql="SELECT count(*) AS total_payout_acc , "
                . " SUM(case when status = 'APPROVED' then 1 else 0 end) AS tot_app_payout_acc, "
                . " SUM(case when status = 'PENDING' then 1 else 0 end) AS tot_pending_payout_acc "
                . "  "
                . " FROM `payoutaccount` WHERE site=$rid ";
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row;  
    }
    
     public function getRechargeCount($rid){
              $sql="SELECT count(*) AS total_recharge , "
                . " SUM(case when status = 'Success' then 1 else 0 end) AS tot_success_recharge, "
                . " SUM(case when status = 'Pending' then 1 else 0 end) AS tot_pending_recharge, "
                . " SUM(case when status = 'Failure' then 1 else 0 end) AS tot_failed_recharge "
                . " FROM `rechargetxn` WHERE site=$rid ";
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row;  
    }
    
    public function getQTCount($rid){
              $sql="SELECT count(*) AS total_qt , "
                . " SUM(case when status = 'SUCCESS' then 1 else 0 end) AS tot_success_qt, "
                . " SUM(case when status = 'PENDING' then 1 else 0 end) AS tot_pending_qt, "
                . " SUM(case when status = 'FAILED' then 1 else 0 end) AS tot_failed_qt "
                . " FROM `qtransfertxn` WHERE site=$rid ";
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row;  
    }
    
     public function getDMTCount($rid){
              $sql="SELECT count(*) AS total_dmt , "
                . " SUM(case when status = 'SUCCESS' then 1 else 0 end) AS tot_success_dmt, "
                . " SUM(case when status = 'PENDING' then 1 else 0 end) AS tot_pending_dmt, "
                . " SUM(case when status = 'FAILURE' then 1 else 0 end) AS tot_failed_dmt "
                . " FROM `dmrtxn` WHERE site=$rid ";
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row;  
    }
    
    
    
    public function getRchtxntoday($rid){
       $cdate=date('Y-m-d');
       $sql="SELECT count(*) AS num_txn, SUM(amount) AS total_txn_amt FROM `rechargetxn` "
               . " WHERE status='Success' AND DATE(`date`)='".$cdate."' AND site=$rid "; 
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row; 
    }
    
      
    public function getbbpstxntoday($rid){
       $cdate=date('Y-m-d');
       $sql="SELECT count(*) AS num_txn, SUM(amount) AS total_txn_amt FROM `bbpstxn` "
               . " WHERE status='SUCCESS' AND DATE(`date`)='".$cdate."'  "; 
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row; 
    }
    
    public function getaepstxntoday($rid){
       $cdate=date('Y-m-d');
       $sql="SELECT count(*) AS num_txn, SUM(amount) AS total_txn_amt, "
               . " SUM(case when t_type = 'CW' then amount else 0 end) AS tot_amt_cw,"
               . " SUM(case when t_type = 'CW' then 1 else 0 end) AS tot_success_cw,"
               . " SUM(case when t_type = 'MN' then 1 else 0 end) AS tot_success_mn,"
               . " SUM(case when t_type = 'BE' then 1 else 0 end) AS tot_success_beq"
               . " FROM `aeps_list` "
               . " WHERE status='Success' AND DATE(`created_at`)='".$cdate."' AND site=$rid "; 
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row; 
    }
    
    public function getpayouttxntoday($rid){
       $cdate=date('Y-m-d');
       $sql="SELECT count(*) AS num_txn, SUM(amount) AS total_txn_amt FROM `payouttxn` "
               . " WHERE status='SUCCESS' AND DATE(`date`)='".$cdate."' AND site=$rid "; 
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row; 
    }
    
    public function getdmttxntoday($rid){
       $cdate=date('Y-m-d');
       $sql="SELECT count(*) AS num_txn, SUM(amount) AS total_txn_amt FROM `dmrtxn` "
               . " WHERE status='SUCCESS' AND DATE(`date`)='".$cdate."' AND site=$rid "; 
        $query=$this->db->query($sql); 
        $row=$query->row_array();
        return $row; 
    }
    
    public function getQTtxntoday($rid){
       $cdate=date('Y-m-d');
       $sql="SELECT count(*) AS num_txn, SUM(amount) AS total_txn_amt FROM `qtransfertxn` "
               . " WHERE status='SUCCESS' AND DATE(`date`)='".$cdate."' AND site=$rid "; 
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row; 
    }
    
     public function getUTItoday($rid){
       $cdate=date('Y-m-d');
       
       $sql="SELECT count(*) AS total_users , "
                . " SUM(case when token != '' then 1 else 0 end) AS token_sale, "
                . " SUM(case when uti = '1' then 1 else 0 end) AS tot_uti "
                . " FROM `users` WHERE site=$rid AND active='1' AND DATE(`create_date`)='".$cdate."'";
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row; 
    }
    
   
    
    public function todayTxnsummary($rid){
        $return_data=array();
        $return_data['recharge']=$this->getRchtxntoday($rid);
        $return_data['aeps']=$this->getaepstxntoday($rid);
        $return_data['bbps']=$this->getbbpstxntoday($rid);
        $return_data['qtrans']=$this->getQTtxntoday($rid);
        $return_data['dmt']=$this->getdmttxntoday($rid);
        $return_data['payout']=$this->getpayouttxntoday($rid);
        $return_data['uti']=$this->getUTItoday($rid);
        return $return_data;
    }
    
    
    

   

}
