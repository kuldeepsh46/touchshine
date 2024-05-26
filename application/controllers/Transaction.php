<?php

class Transaction extends CI_Controller{
    public function index(){
        
    }
    public function recharge(){
        if(isset($_SESSION['uid'])){
            $domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth,'type' => 'recharge');
            $this->load->view('transaction/transaction',$data);
        }else{
            redirect('/');
        }
        
    }
    public function naeps(){
        if(isset($_SESSION['uid'])){
            $domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth,'type' => 'naeps');
            $this->load->view('transaction/transaction',$data);
        }else{
            redirect('/');
        }
        
    }
    public function dmr(){
        if(isset($_SESSION['uid'])){
            $domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth,'type' => 'dmr');
            $this->load->view('transaction/transaction',$data);
        }else{
            redirect('/');
        }
    }
    public function pan(){
        if(isset($_SESSION['uid'])){
            $domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth,'type' => 'pan');
            $this->load->view('transaction/transaction',$data);
        }else{
            redirect('/');
        }
    }
    public function qtransfer(){
        if(isset($_SESSION['uid'])){
            $domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth,'type' => 'qtransfer');
            $this->load->view('transaction/transaction',$data);
        }else{
            redirect('/');
        }
    }
    public function aeps(){
        if(isset($_SESSION['uid'])){
            $domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth,'type' => 'aeps');
            $this->load->view('transaction/transaction',$data);
        }else{
            redirect('/');
        }
    }
    
    public function ledger(){
        if(isset($_SESSION['uid'])){
            $domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth,'type' => 'ledger');
            $this->load->view('transaction/transaction',$data);
        }else{
            redirect('/');
        }
    }
      public function mwledger(){
        if(isset($_SESSION['uid'])){
            $domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth,'type' => 'mwledger');
            $this->load->view('transaction/transaction',$data);
        }else{
            redirect('/');
        }
    }
	
	public function topupledger(){
        if(isset($_SESSION['uid'])){
            $domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth,'type' => 'topupledger');
            $this->load->view('transaction/transaction',$data);
        }else{
            redirect('/');
        }
    }
    public function payout(){
        if(isset($_SESSION['uid'])){
            $domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth,'type' => 'payout');
            $this->load->view('transaction/transaction',$data);
        }else{
            redirect('/');
        }
    }
    
}