<?php

class Admin_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getSitedtl() {
        $domain = $_SERVER['HTTP_HOST'];
        $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
        return $sdata;
    }
    
    public function getReseller($id){
        $this->db->where("id",$id);
        $rdata = $this->db->get('reseller')->row_array();
        return $rdata;
        
    }
    public function getCompany($id){
        $this->db->where("rid",$id);
        $rdata = $this->db->get('sites')->row_array();
        return $rdata['title'];
        
    }
    
    public function getReslWallet($data){
        $rid=$data['rid'];
        $current_date=date('Y-m-d').' 00:00:00';
        $from_date=isset($data['from'])?$data['from']:$current_date;
        $to_date=isset($data['to'])?$data['to']:$current_date;
        
        $wcond=" ";
        if($from_date!=""){
            $wcond.=" AND `date` >= '$from_date' ";
        }
        if($to_date!=""){
            $wcond.=" AND `date` <= '$to_date' ";
        }
        
        $sql=" SELECT * FROM rtransaction WHERE rid=$rid ".$wcond." ORDER BY id DESC ";
        
        $query=$this->db->query($sql);
        $result=$query->result();
        return $result;
        
    }
	
	public function getReslWallet_main($data){
        $rid=$data['rid'];
        $current_date=date('Y-m-d').' 00:00:00';
        $from_date=isset($data['from'])?$data['from']:$current_date;
        $to_date=isset($data['to'])?$data['to']:$current_date;
        
        $wcond=" ";
        if($from_date!=""){
            $wcond.=" AND `date` >= '$from_date' ";
        }
        if($to_date!=""){
            $wcond.=" AND `date` <= '$to_date' ";
        }
        
        $sql=" SELECT * FROM rtransaction_main WHERE rid=$rid ".$wcond." ORDER BY id DESC ";
        
        $query=$this->db->query($sql);
        $result=$query->result();
        return $result;
        
    }
    
    public function getKycCount(){
        $sql="SELECT count(*) AS total_kyc , "
                . " SUM(case when active = '0' then 1 else 0 end) AS pending_kyc, "
                . " SUM(case when active = '1' then 1 else 0 end) AS completed_kyc, "
                . " SUM(case when active = NULL then 1 else 0 end) AS incomplete_kyc "
                . " FROM `kyc`";
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row;
    }
    
    public function getaepsKycCount(){
        $sql="SELECT count(*) AS total_aekyc , "
                . " SUM(case when status = 'PENDING' then 1 else 0 end) AS pending_aekyc, "
                . " SUM(case when status = 'APPROVED' then 1 else 0 end) AS completed_aekyc"
                . " FROM `indus_kyc`";
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row;
    }
    
    public function getUserCount(){
              $sql="SELECT count(*) AS total_users , "
                . " SUM(case when active = '0' then 1 else 0 end) AS inactive_users, "
                . " SUM(case when active = '1' then 1 else 0 end) AS active_users "
                . " FROM `users`";
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
    
    public function getaepsCount(){
              $sql="SELECT count(*) AS total_aeps , "
                . " SUM(case when status = 'Success' then 1 else 0 end) AS tot_success_aeps, "
                . " SUM(case when status = 'Pending' then 1 else 0 end) AS tot_pending_aeps, "
                . " SUM(case when status = 'Decline' then 1 else 0 end) AS tot_decline_aeps, "
                . " SUM(case when status = 'Failed' then 1 else 0 end) AS tot_failed_aeps "
                . " FROM `aeps_list`";
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row;  
    }
    
    public function getPayoutCount(){
              $sql="SELECT count(*) AS total_payout , "
                . " SUM(case when status = 'SUCCESS' then 1 else 0 end) AS tot_success_payout, "
                . " SUM(case when status = 'PENDING' then 1 else 0 end) AS tot_pending_payout, "
                . " SUM(case when status = 'FAILED' then 1 else 0 end) AS tot_failed_payout "
                . " FROM `payouttxn`";
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row;  
    }
    
    public function getRchtxntoday(){
       $cdate=date('Y-m-d');
       $sql="SELECT count(*) AS num_txn, SUM(amount) AS total_txn_amt FROM `rechargetxn` "
               . " WHERE status='Success' AND DATE(`date`)='".$cdate."'"; 
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row; 
    }
    
      
    public function getbbpstxntoday(){
       $cdate=date('Y-m-d');
       $sql="SELECT count(*) AS num_txn, SUM(amount) AS total_txn_amt FROM `bbpstxn` "
               . " WHERE status='SUCCESS' AND DATE(`date`)='".$cdate."'"; 
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row; 
    }
    
    public function getaepstxntoday(){
       $cdate=date('Y-m-d');
       $sql="SELECT count(*) AS num_txn, SUM(amount) AS total_txn_amt, "
               . " SUM(case when t_type = 'CW' then amount else 0 end) AS tot_amt_cw,"
               . " SUM(case when t_type = 'CW' then 1 else 0 end) AS tot_success_cw,"
               . " SUM(case when t_type = 'MN' then 1 else 0 end) AS tot_success_mn,"
               . " SUM(case when t_type = 'BE' then 1 else 0 end) AS tot_success_beq"
               . " FROM `aeps_list` "
               . " WHERE status='Success' AND DATE(`created_at`)='".$cdate."'"; 
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row; 
    }
    
    public function getpayouttxntoday(){
       $cdate=date('Y-m-d');
       $sql="SELECT count(*) AS num_txn, SUM(amount) AS total_txn_amt FROM `payouttxn` "
               . " WHERE status='SUCCESS' AND DATE(`date`)='".$cdate."'"; 
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row; 
    }
    
    public function getdmttxntoday(){
       $cdate=date('Y-m-d');
       $sql="SELECT count(*) AS num_txn, SUM(amount) AS total_txn_amt FROM `dmrtxn` "
               . " WHERE status='SUCCESS' AND DATE(`date`)='".$cdate."'"; 
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row; 
    }
    
    public function getQTtxntoday(){
       $cdate=date('Y-m-d');
       $sql="SELECT count(*) AS num_txn, SUM(amount) AS total_txn_amt FROM `qtransfertxn` "
               . " WHERE status='SUCCESS' AND DATE(`date`)='".$cdate."'"; 
        $query=$this->db->query($sql);
        $row=$query->row_array();
        return $row; 
    }
    
    public function todayTxnsummary(){
        $return_data=array();
        $return_data['recharge']=$this->getRchtxntoday();
        $return_data['aeps']=$this->getaepstxntoday();
        $return_data['bbps']=$this->getbbpstxntoday();
        $return_data['qtrans']=$this->getQTtxntoday();
        $return_data['dmt']=$this->getdmttxntoday();
        $return_data['payout']=$this->getpayouttxntoday();
        return $return_data;
    }
    
    
    

   

}
