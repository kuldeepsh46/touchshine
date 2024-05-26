<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Partner extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
        $this->load->model('partner_model', '', TRUE);
        $this->load->library("form_validation");
        $this->load->library('pagination');

        // load URL helper
        $this->load->helper('url');
    }

    public function index() {
        if (isset($_SESSION['rid'])) {   //if user login
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
            $data['usercnt'] = $this->partner_model->getUserCount($_SESSION['rid']);
            $data['partnercnt']=$this->partner_model->getresellerCount();
            $data['kyccnt'] = $this->partner_model->getKycCount($_SESSION['rid']);
            $data['aekyccnt'] = $this->partner_model->getaepsKycCount($_SESSION['rid']);
            $data['aepscnt'] = $this->partner_model->getaepsCount($_SESSION['rid']);
            $data['payoutcnt'] = $this->partner_model->getPayoutCount($_SESSION['rid']);
            $data['payoutAccCnt'] = $this->partner_model->getPayoutAccCount($_SESSION['rid']);
            $data['rechargeCnt'] = $this->partner_model->getRechargeCount($_SESSION['rid']);
            $data['qtCnt'] = $this->partner_model->getQTCount($_SESSION['rid']);
            $data['dmtCnt'] = $this->partner_model->getDMTCount($_SESSION['rid']);
          
            $data['today_summary'] = $this->partner_model->todayTxnsummary($_SESSION['rid']);
            $this->load->view('partner/dashboard', $data);
        } else {
            // if user not login
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
            $this->load->view('partner/login', $data);
        }
    }

    public function logout() {
        session_destroy();
        redirect('/partner');
    }

    public function login() {
        if ($_SESSION['auth'] == $this->input->post("auth")) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            if ($username != "" && $password != "") {
                $count = $this->db->get_where('reseller', array('username' => $username))->num_rows();
                if ($count > 0) {
                    $user = $this->db->get_where('reseller', array('username' => $username))->row();



                    if ($password == $user->password) {
                        $otp = rand(111111, 999999);
                        $_SESSION['tid'] = $user->id;
                        $_SESSION['otp'] = $otp;
                        $senderid = "MONAPI";
                        $phone = $user->phone;
                        $message = "Welcome To Moonex Software , Dear Partner Your Login OTP Is " . $otp . " Please do not share this OTP with anyone, Thanks Team Moonex";

                        $template = "1707165280858588105";

                        send_sms($senderid, $phone, $message, $template);
                        $this->load->view('partner/loginotp');
                    } else {

                        echo "WRONG PASSWORD";
                    }
                } else {
                    echo "USERNAME NOT EXIST";
                }
            } else {
                echo "USERNAME & PASSWORD IS MISSING";
            }
        } else {

            echo "INVALID TOKEN";
        }
    }

    public function verify() {

        if ($_SESSION['auth'] == $this->input->post("auth")) {
            if (isset($_SESSION['tid'])) {
                $log = $this->input->post("log");
                $lat = $this->input->post("lat");
                if ($log != "" && $lat != "") {




                    if ($_SESSION['otp'] == $this->input->post("otp")) {
                        $_SESSION['rid'] = $_SESSION['tid'];

                        $username = $this->db->get_where('reseller', array('id' => $_SESSION['rid']))->row()->username;

                        $data = array(
                            'username' => $username,
                            'ip' => $_SERVER['REMOTE_ADDR'],
                            'log' => $log,
                            'lat' => $lat,
                            'type' => "PARTNER"
                        );
                        $this->db->insert('loginlog', $data);
                        echo "1";
                    } else {

                        echo "OTP NOT MATCHED";
                    }
                } else {

                    echo "ERROR IN LOCATION V2";
                }
            } else {

                echo "ERROR OCCURED.";
            }
        } else {

            echo "INVALID TOKEN";
        }
    }

    public function package() {
        if (isset($_SESSION['rid'])) {   //if user login
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
            $this->load->view('partner/package', $data);
        }
    }

    public function createpackage() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $name = $this->input->post('name');
                $pkg = $this->input->post('pkg');
                $site = $this->db->get_where('sites', array('rid' => $_SESSION['rid']))->row()->id;
                if ($name == "" || $pkg == "") {
                    echo "Please Fill All Data";
                } else {
                    $pcount = $this->db->get_where('package', array('name' => $name))->num_rows();
                    if ($pcount > 0) {
                        echo "PACKAGE ALREADY EXITS";
                    } else {
                        $pdata = array(
                            'name' => $name,
                            'role' => $pkg,
                            'site' => $site
                        );
                        $this->db->insert('package', $pdata);
                        $package = $this->db->get_where('package', array('name' => $name))->row()->id;
                        $role = "1";
                        //recharge entry 
                        $rcop = $this->db->get('rechargev2op')->result();

                        foreach ($rcop as $r) {
                            $data = array(
                                'operator' => $r->id,
                                'amount' => "0",
                                'percent' => "0",
                                'package' => $package,
                                'site' => $site
                            );
                            $this->db->insert('comissionv2', $data);
                        }

                        //dmr entry
                        $index = 1;
                        while ($index <= 10) {
                            $data = array(
                                'froma' => "0",
                                'toa' => "0",
                                'amount' => "0",
                                'percent' => "0",
                                'package' => $package,
                                'site' => $site
                            );
                            $this->db->insert('dmtcharge', $data);
                            $index++;
                        }

                        //qtransfer charge
                        $index = 1;
                        while ($index <= 10) {
                            $data = array(
                                'froma' => "0",
                                'toa' => "0",
                                'amount' => "0",
                                'percent' => "0",
                                'package' => $package,
                                'site' => $site
                            );
                            $this->db->insert('qtransfer', $data);
                            $index++;
                        }
                        //payout imps
                        $index = 1;
                        while ($index <= 10) {
                            $data = array(
                                'froma' => "0",
                                'toa' => "0",
                                'amount' => "0",
                                'percent' => "0",
                                'package' => $package,
                                'site' => $site
                            );
                            $this->db->insert('payoutchargeimps', $data);
                            $index++;
                        }
                        //payout neft
                        $index = 1;
                        while ($index <= 10) {
                            $data = array(
                                'froma' => "0",
                                'toa' => "0",
                                'amount' => "0",
                                'percent' => "0",
                                'package' => $package,
                                'site' => $site
                            );
                            $this->db->insert('payoutchargeneft', $data);
                            $index++;
                        }
                        //icici aeps
                        //cash withdrawal
                        $index = 1;
                        while ($index <= 10) {
                            $data = array(
                                'froma' => "0",
                                'toa' => "0",
                                'amount' => "0",
                                'percent' => "0",
                                'package' => $package,
                                'site' => $site
                            );
                            $this->db->insert('icaepscomission', $data);
                            $index++;
                        }
                        //aadhar pay 
                        $index = 1;
                        while ($index <= 10) {
                            $data = array(
                                'froma' => "0",
                                'toa' => "0",
                                'amount' => "0",
                                'percent' => "0",
                                'package' => $package,
                                'site' => $site
                            );
                            $this->db->insert('icapcharge', $data);
                            $index++;
                        }
                        //cash deposit
                        $index = 1;
                        while ($index <= 10) {
                            $data = array(
                                'froma' => "0",
                                'toa' => "0",
                                'amount' => "0",
                                'percent' => "0",
                                'package' => $package,
                                'site' => $site
                            );
                            $this->db->insert('icdpcomission', $data);
                            $index++;
                        }
                        //indus bank 
                        //aadharpay
                        $index = 1;
                        while ($index <= 10) {
                            $data = array(
                                'froma' => "0",
                                'toa' => "0",
                                'amount' => "0",
                                'percent' => "0",
                                'package' => $package,
                                'site' => $site
                            );
                            $this->db->insert('adhaarpaycharge', $data);
                            $index++;
                        }
                        //cash withdrawal
                        $index = 1;
                        while ($index <= 10) {
                            $data = array(
                                'froma' => "0",
                                'toa' => "0",
                                'amount' => "0",
                                'percent' => "0",
                                'package' => $package,
                                'site' => $site
                            );
                            $this->db->insert('aepscomission', $data);
                            $index++;
                        }
                        //ms
                        $data = array(
                            'type' => "1",
                            'amount' => "0",
                            'package' => $package,
                            'site' => $site
                        );
                        $this->db->insert('mscom', $data);
                        $data = array(
                            'type' => "2",
                            'amount' => "0",
                            'package' => $package,
                            'site' => $site
                        );
                        $this->db->insert('mscom', $data);

                        //uti

                        $data = array(
                            'amount' => "0",
                            'package' => $package,
                            'site' => $site
                        );
                        $this->db->insert('coponcharge', $data);

                        //entry end 
                        echo 1;
                    }
                }
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function commission() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
            $this->load->view('partner/commission', $data);
        } else {
            redirect('/partner');
        }
    }

    public function loadcomission() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post("auth")) {
                $sv = $this->input->post("sv");
                $pk = $this->input->post("pk");
                $auth = $_SESSION['auth'];
                $data = array('pk' => $pk, 'auth' => $auth);
                switch ($sv) {
                    case 1 : $this->load->view('partner/print/comission/recharge', $data);
                        break;
                    case 2 : $this->load->view('partner/print/comission/dmt', $data);
                        break;
                    case 3 : $this->load->view('partner/print/comission/icw', $data);
                        break;
                    case 4 : $this->load->view('partner/print/comission/icd', $data);
                        break;
                    case 5 : $this->load->view('partner/print/comission/iap', $data);
                        break;
                    case 6 : $this->load->view('partner/print/comission/ims', $data);
                        break;
                    case 7 : $this->load->view('partner/print/comission/ncw', $data);
                        break;
                    case 8 : $this->load->view('partner/print/comission/nap', $data);
                        break;
                    case 9 : $this->load->view('partner/print/comission/nms', $data);
                        break;
                    case 10 : $this->load->view('partner/print/comission/uti', $data);
                        break;
                    case 11 : $this->load->view('partner/print/comission/payoutimps', $data);
                        break;
                    case 12 : $this->load->view('partner/print/comission/payoutneft', $data);
                        break;
                    case 13 : $this->load->view('partner/print/comission/qtransfer', $data);
                        break;
					case 14 : $this->load->view('partner/print/comission/recharge_lapu', $data);
                        break;
                }
            } else {
                redirect('/partner/commission');
            }
        } else {
            redirect('/partner');
        }
    }

    public function registration() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
            $this->load->view('partner/registration', $data);
        } else {
            redirect('/partner');
        }
    }

    public function setpack() {
        if (isset($_SESSION['rid']) || $_SESSION['role'] == 1 || $_SESSION['role'] == 2) {   //if user login
            $role = $this->input->post("role");
            $site = $this->db->get_where('sites', array('rid' => $_SESSION['rid']))->row()->id;
            $pks = $this->db->get_where('package', array('role' => $role, 'site' => $site))->result();
            foreach ($pks as $pk) {
                echo '<option value="' . $pk->id . '">' . $pk->name . '</option>';
            }
        } else {

            echo "SESSION EXPIRED";
        }
    }

    public function memberreg() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $name = $this->input->post('name');
                $mobile = $this->input->post('mobile');
                $email = $this->input->post('email');
                $role = $this->input->post('role');
                $pkg = $this->input->post('pkg');
                $site = $this->db->get_where('sites', array('rid' => $_SESSION['rid']))->row()->id;
                if ($name == "" || $mobile == "" || $email == "" || $role == "" || $pkg == "") {
                    echo "Please Fill All Data";
                } else {
                    $cmobile = $this->db->get_where('users', array('phone' => $mobile, 'site' => $site))->num_rows();
                    if ($cmobile > 0) {
                        echo "Mobile Already Exits";
                    } else {
                        $cmail = $this->db->get_where('users', array('email' => $email, 'site' => $site))->num_rows();
                        if ($cmail > 0) {
                            echo "Email Already Exits";
                        } else {
                            if ($role == 2) {
                                $username = "SH" . rand(111111, 999999);
                            } elseif ($role == 3) {
                                $username = "MD" . rand(111111, 999999);
                            } elseif ($role == 4) {
                                $username = "DT" . rand(111111, 999999);
                            } elseif ($role == 5) {
                                $username = "RT" . rand(111111, 999999);
                            } else {
                                echo "ERROR";
                                exit();
                            }
                            $password = rand(111111, 999999);
                            $pin = rand(1111, 9999);
                            $profile = "https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg";
                            $rdata = array(
                                'name' => $name,
                                'username' => $username,
                                'password' => $password,
                                'email' => $email,
                                'phone' => $mobile,
                                'wallet' => "0",
                                'active' => "1",
                                'otp' => "1234",
                                'package' => $pkg,
                                'role' => $role,
                                'owner' => "0",
                                'pin' => $pin,
                                'profile' => $profile,
                                'recharge' => "1",
                                'dmt' => "1",
                                'aeps' => "1",
                                'iaeps' => "1",
                                'bbps' => "1",
                                'qtransfer' => "1",
                                'payout' => "1",
                                'uti' => "1",
                                'site' => $site
                            );
                            $this->db->insert('users', $rdata);

                            $reseller = $this->db->get_where('reseller', array('id' => $_SESSION['rid']))->row();
                            $company_nm = $reseller->name;

                            $senderid = "MOONEX";
                            $message = "Dear " . $name . " Welcome To " . $company_nm . ", Your New account Cretated Sucessfully, Your Login Id " . $username . ", Password " . $password . " And Txn Password " . $pin . " , Thanks Team MOSFTY";
                            $template = "1707164930177160196";
                            send_sms($senderid, $mobile, $message, $template);
                            echo "1";
                        }
                    }
                }
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function memberlist() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
            $this->load->view('partner/memberlist', $data);
        } else {
            redirect('/partner');
        }
    }

    public function wallet() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
            $this->load->view('partner/wallet', $data);
        } else {
            redirect('/partner');
        }
    }
	
	public function mwallet() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
            $this->load->view('partner/mwallet', $data);
        } else {
            redirect('/partner');
        }
    }

    public function credit() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
            $this->load->view('partner/credit', $data);
        } else {
            redirect('/partner');
        }
    }

    public function creditfund() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $user = $this->input->post('user');
                $amount = $this->input->post('amount');
                $remark = $this->input->post('remark');
                $site = $this->db->get_where('sites', array('rid' => $_SESSION['rid']))->row()->id;
                if ($user == "" || $amount == "" || $remark == "") {
                    echo "Please Fill All Data";
                } else {
                    $userdata = $this->db->get_where('users', array('id' => $user))->row();
                    if ($userdata->site == $site) {
                        if ($amount <= 0) {
                            echo "INVALID AMOUNT";
                        } else {
                            $wallet = $userdata->wallet;
                            $newbal = $wallet + $amount;
                            $this->db->where('id', $userdata->id);
                            $this->db->update('users', array('wallet' => $newbal));
                            $txnid = "TOPUP" . rand(1111111111, 9999999999);

                            $wrdata = array(
                                'type' => "TOPUP" . " " . $remark,
                                'txntype' => "CREDIT",
                                'opening' => $wallet,
                                'closing' => $newbal,
                                'uid' => $userdata->id,
                                'txnid' => $txnid,
                                'amount' => $amount,
                                'site' => $site
                            );
                            $this->db->insert('wallet', $wrdata);
                            
                             $ardata = array(
                                        'uid' => $userdata->id,
                                        'member' => $userdata->username,
                                        'type' => "TOPUP",
                                        'txntype' => "CREDIT",
                                        'txnid' => $txnid,
                                        'reference' => "NA",
                                        'status' => "SUCCESS",
                                        'amount' => $amount,
                                        'response' => "NA",
                                        'commission' => "NA",
                                        'deposit' => "NA",
                                        'withdraw' => "NA",
                                        'opening' => $wallet,
                                        'closing' => $newbal,
                                        'mobile' => "NA",
                                        'roperator' => "NA",
                                        'rcircle' => "NA",
                                        'consumer' => "NA",
                                        'doperator' => "NA",
                                        'boperator' => "NA",
                                        'rid' => "NA",
                                        'bid' => "NA",
                                        'account' => "NA",
                                        'ifsc' => "NA",
                                        'bname' => "NA",
                                        'remittermobile' => "NA",
                                        'agentid' => "NA",
                                        'qty' => "NA",
                                        'site' => $userdata->site
	                            );
	                            $this->db->insert('transaction',$ardata);
                            echo 1;
                        }
                    } else {
                        echo "ERROR";
                    }
                }
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function debit() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
            $this->load->view('partner/debit', $data);
        } else {
            redirect('/partner');
        }
    }

    public function debitfund() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $user = $this->input->post('user');
                $amount = $this->input->post('amount');
                $remark = $this->input->post('remark');
                $site = $this->db->get_where('sites', array('rid' => $_SESSION['rid']))->row()->id;
                if ($user == "" || $amount == "" || $remark == "") {
                    echo "Please Fill All Data";
                } else {
                    $userdata = $this->db->get_where('users', array('id' => $user))->row();
                    if ($userdata->site == $site) {
                        if ($amount <= 0) {
                            echo "INVALID AMOUNT";
                        } else {
                            $wallet = $userdata->wallet;
                            $newbal = $wallet - $amount;
                            $this->db->where('id', $userdata->id);
                            $this->db->update('users', array('wallet' => $newbal));
                            $txnid = "DEDUCT" . rand(1111111111, 9999999999);
                            $wrdata = array(
                                'type' => "DEDUCT" . " " . $remark,
                                'txntype' => "DEBIT",
                                'opening' => $wallet,
                                'closing' => $newbal,
                                'uid' => $userdata->id,
                                'txnid' => $txnid,
                                'amount' => $amount,
                                'site' => $site
                            );
                            $this->db->insert('wallet', $wrdata);
                            $ardata = array(
                                        'uid' => $userdata->id,
                                        'member' => $userdata->username,
                                        'type' => "DEDUCT",
                                        'txntype' => "DEBIT",
                                        'txnid' => $txnid,
                                        'reference' => "NA",
                                        'status' => "SUCCESS",
                                        'amount' => $amount,
                                        'response' => "NA",
                                        'commission' => "NA",
                                        'deposit' => "NA",
                                        'withdraw' => "NA",
                                        'opening' => $wallet,
                                        'closing' => $newbal,
                                        'mobile' => "NA",
                                        'roperator' => "NA",
                                        'rcircle' => "NA",
                                        'consumer' => "NA",
                                        'doperator' => "NA",
                                        'boperator' => "NA",
                                        'rid' => "NA",
                                        'bid' => "NA",
                                        'account' => "NA",
                                        'ifsc' => "NA",
                                        'bname' => "NA",
                                        'remittermobile' => "NA",
                                        'agentid' => "NA",
                                        'qty' => "NA",
                                        'site' => $userdata->site
	                            );
	                            $this->db->insert('transaction',$ardata);
                            echo 1;
                        }
                    } else {
                        echo "ERROR";
                    }
                }
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function searchtxn() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $afrom = $this->input->post('from');
                $ato = $this->input->post('to');
                $type = $this->input->post('type');
                if ($afrom == "" || $ato == "" || $type == "") {
                    echo 2;
                    exit();
                }
                //set from
                $farray = explode('/', $afrom);
                $fnar = array('0' => $farray[2], '1' => $farray[0], '2' => $farray[1]);
                $nfrom = implode('-', $fnar);
                $from = $nfrom . " 00:00:00";
                //set to
                $tarray = explode('/', $ato);
                $tnar = array('0' => $tarray[2], '1' => $tarray[0], '2' => $tarray[1]);
                $nto = implode('-', $tnar);
                $to = $nto . " 23:59:59";
                $data = array('from' => $from, 'to' => $to);
                if ($type == "iaeps") {
                    $this->load->view('partner/transaction/iaeps', $data);
                } elseif ($type == "naeps") {
                    $this->load->view('partner/transaction/naeps', $data);
                } elseif ($type == "recharge") {
                    $this->load->view('partner/transaction/recharge', $data);
                } elseif ($type == "dmt") {
                    $this->load->view('partner/transaction/dmt', $data);
                } elseif ($type == "payout") {
                    $this->load->view('partner/transaction/payout', $data);
                } elseif ($type == "profile") {
                    $this->load->view('partner/profilekyc', $data);
                } elseif ($type == "pacc") {
                    $this->load->view('partner/approvepayout', $data);
                } elseif ($type == "qtransfer") {
                    $this->load->view('partner/transaction/qtransfer', $data);
                } elseif ($type == "pan") {
                    $this->load->view('partner/transaction/panreg', $data);
                } elseif ($type == "panc") {
                    $this->load->view('partner/transaction/pan', $data);
                } elseif ($type == "credit") {
                    $this->load->view('partner/transaction/credit', $data);
                } elseif ($type == "debit") {
                    $this->load->view('partner/transaction/debit', $data);
                } elseif ($type == "wallet") {
                    $this->load->view('partner/transaction/wallet', $data);
                }
				elseif ($type == "mainwallet") {
                    $this->load->view('partner/transaction/mainwallet', $data);
                }
				elseif ($type == "topuphistory") {
                    $this->load->view('partner/transaction/topuphistory', $data);
                } 
				else {
                    echo "ERROR";
                }
            } else {
                echo 1;
            }
        } else {
            redirect('/partner');
        }
    }

    public function transwallet() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth, 'type' => 'wallet');
            $this->load->view('partner/transaction/transaction', $data);
        } else {
            redirect('/partner');
        }
    }
     public function mainwallet() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth, 'type' => 'mainwallet');
            $this->load->view('partner/transaction/transaction', $data);
        } else {
            redirect('/partner');
        }
    }

    public function transiaeps() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth, 'type' => 'iaeps');
            $this->load->view('partner/transaction/transaction', $data);
        } else {
            redirect('/partner');
        }
    }

    public function transaeps() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth, 'type' => 'naeps');
            $this->load->view('partner/transaction/transaction', $data);
        } else {
            redirect('/partner');
        }
    }

    public function transcredit() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth, 'type' => 'credit');
            $this->load->view('partner/transaction/transaction', $data);
        } else {
            redirect('/partner');
        }
    }

    public function transdebit() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth, 'type' => 'debit');
            $this->load->view('partner/transaction/transaction', $data);
        } else {
            redirect('/partner');
        }
    }

    public function news() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
            $this->load->view('partner/news', $data);
        } else {
            redirect('/partner');
        }
    }

    public function updatenews() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $news = $this->input->post('news');
                if ($news == "") {
                    echo "Please Send All Data";
                } else {
                    $this->db->update('sites', array('news' => $news), array('rid' => $_SESSION['rid']));
                    echo 1;
                }
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function transrecharge() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth, 'type' => 'recharge');
            $this->load->view('partner/transaction/transaction', $data);
        } else {
            redirect('/partner');
        }
    }
	
	public function topuphistory() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth, 'type' => 'topuphistory');
            $this->load->view('partner/transaction/transaction', $data);
        } else {
            redirect('/partner');
        }
    }

    public function transdmt() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth, 'type' => 'dmt');
            $this->load->view('partner/transaction/transaction', $data);
        } else {
            redirect('/partner');
        }
    }

    public function transpayout() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth, 'type' => 'payout');
            $this->load->view('partner/transaction/transaction', $data);
        } else {
            redirect('/partner');
        }
    }

    public function transquick() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth, 'type' => 'qtransfer');
            $this->load->view('partner/transaction/transaction', $data);
        } else {
            redirect('/partner');
        }
    }

    public function transpanrc() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth, 'type' => 'panc');
            $this->load->view('partner/transaction/transaction', $data);
        } else {
            redirect('/partner');
        }
    }

    public function transpanr() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth, 'type' => 'pan');
            $this->load->view('partner/transaction/transaction', $data);
        } else {
            redirect('/partner');
        }
    }

    public function viewwallet() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $vid = $this->input->post('vid');
                if ($vid == "") {
                    echo "2";
                } else {

                    $data = array('id' => $vid);
                    $this->load->view('partner/searchwa', $data);
                }
            } else {
                echo "1";
            }
        } else {
            redirect('/partner');
        }
    }
	public function viewmwallet() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $vid = $this->input->post('vid');
                if ($vid == "") {
                    echo "2";
                } else {

                    $data = array('id' => $vid);
                    $this->load->view('partner/searchwa_m', $data);
                }
            } else {
                echo "1";
            }
        } else {
            redirect('/partner');
        }
    }

    public function searchtxnw() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $afrom = $this->input->post('from');
                $ato = $this->input->post('to');
                $id = $this->input->post('id');
                if ($afrom == "" || $ato == "" || $id == "") {
                    echo 2;
                    exit();
                }
                //set from
                $farray = explode('/', $afrom);
                $fnar = array('0' => $farray[2], '1' => $farray[0], '2' => $farray[1]);
                $nfrom = implode('-', $fnar);
                $from = $nfrom . " 00:00:00";
                //set to
                $tarray = explode('/', $ato);
                $tnar = array('0' => $tarray[2], '1' => $tarray[0], '2' => $tarray[1]);
                $nto = implode('-', $tnar);
                $to = $nto . " 23:59:59";
                $data = array('from' => $from, 'to' => $to, 'id' => $id);
                $this->load->view('partner/viewwallet', $data);
            } else {
                echo "1";
            }
        } else {
            redirect('/partner');
        }
    }
	
	public function searchtxnw_m() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $afrom = $this->input->post('from');
                $ato = $this->input->post('to');
                $id = $this->input->post('id');
                if ($afrom == "" || $ato == "" || $id == "") {
                    echo 2;
                    exit();
                }
                //set from
                $farray = explode('/', $afrom);
                $fnar = array('0' => $farray[2], '1' => $farray[0], '2' => $farray[1]);
                $nfrom = implode('-', $fnar);
                $from = $nfrom . " 00:00:00";
                //set to
                $tarray = explode('/', $ato);
                $tnar = array('0' => $tarray[2], '1' => $tarray[0], '2' => $tarray[1]);
                $nto = implode('-', $tnar);
                $to = $nto . " 23:59:59";
                $data = array('from' => $from, 'to' => $to, 'id' => $id);
                $this->load->view('partner/viewwallet_m', $data);
            } else {
                echo "1";
            }
        } else {
            redirect('/partner');
        }
    }

    public function viewuser() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $data = array('uid' => $this->input->post('uid'));
                $this->load->view('admin/uview', $data);
            } else {
                echo 1;
            }
        } else {
            redirect('/partner');
        }
    }

    public function viewuserservice() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $data = array('uid' => $this->input->post('uid'));
                $this->load->view('admin/uservice', $data);
            } else {
                echo 1;
            }
        } else {
            redirect('/partner');
        }
    }

    public function updateserviceuser() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $rid = $this->input->post('uid');
                $recharge = $this->input->post('recharge');
                $dmt = $this->input->post('dmt');
                $aeps = $this->input->post('aeps');
                $iaeps = $this->input->post('iaeps');
                $bbps = $this->input->post('bbps');
                $qtransfer = $this->input->post('qtransfer');
                $payout = $this->input->post('payout');
                $uti = $this->input->post('uti');
                if ($rid == "") {
                    echo "Please Send Proper Data";
                    exit();
                }
                $ardata = array(
                    "recharge" => $recharge,
                    "dmt" => $dmt,
                    "aeps" => $aeps,
                    "iaeps" => $iaeps,
                    "bbps" => $bbps,
                    "qtransfer" => $qtransfer,
                    "payout" => $payout,
                    "uti" => $uti
                );
                $this->db->where('id', $rid);
                $this->db->update('users', $ardata);
                echo 1;
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function edituser() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $data = array('uid' => $this->input->post('uid'));
                $this->load->view('admin/uedit', $data);
            } else {
                echo 1;
            }
        } else {
            redirect('/partner');
        }
    }

    public function updatedatauser() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $uid = $this->input->post('uid');
                $name = $this->input->post('name');
                $email = $this->input->post('email');
                $phone = $this->input->post('phone');

                $active = $this->input->post('active');
                if ($uid == "" || $name == "" || $email == "" || $phone == "" || $active == "") {
                    echo "Please Send Proper Data";
                } else {
                    //update reseller table 
                    $ardata = array(
                        'name' => $name,
                        'email' => $email,
                        'phone' => $phone,
                        'active' => $active
                    );
                    $this->db->update('users', $ardata, array('id' => $uid));
                    echo 1;
                }
            } else {
                echo 1;
            }
        } else {
            redirect('/partner');
        }
    }

    public function creditviewuser() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $data = array('uid' => $this->input->post('uid'));
                $this->load->view('admin/ucredit', $data);
            } else {
                echo 1;
            }
        } else {
            redirect('/partner');
        }
    }

    public function loginuser() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $uid = $this->input->post('uid');
                if ($uid == "") {
                    echo "ERROR";
                } else {
                    $_SESSION['uid'] = $uid;
                    echo 1;
                }
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function debitviewuser() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $data = array('uid' => $this->input->post('uid'));
                $this->load->view('admin/udebit', $data);
            } else {
                echo 1;
            }
        } else {
            redirect('/partner');
        }
    }

    public function updatecredituser() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $user = $this->input->post('uid');
                $amount = $this->input->post('amount');
                $userdata = $this->db->get_where('users', array('id' => $user))->row();
                if ($amount <= 0) {
                    echo "INVALID AMOUNT";
                } else {
                    $wallet = $userdata->wallet;
                    $newbal = $wallet + $amount;
                    $this->db->where('id', $userdata->id);
                    $this->db->update('users', array('wallet' => $newbal));
                    $txnid = "TOPUP" . rand(1111111111, 9999999999);
                    $ardata = array(
                        'uid' => $userdata->id,
                        'member' => $userdata->username,
                        'type' => "TOPUP",
                        'txntype' => "CREDIT",
                        'txnid' => $txnid,
                        'reference' => "NA",
                        'status' => "SUCCESS",
                        'amount' => $amount,
                        'response' => "NA",
                        'commission' => "NA",
                        'deposit' => "NA",
                        'withdraw' => "NA",
                        'opening' => $wallet,
                        'closing' => $newbal,
                        'mobile' => "NA",
                        'roperator' => "NA",
                        'rcircle' => "NA",
                        'consumer' => "NA",
                        'doperator' => "NA",
                        'boperator' => "NA",
                        'rid' => "NA",
                        'bid' => "NA",
                        'account' => "NA",
                        'ifsc' => "NA",
                        'bname' => "NA",
                        'remittermobile' => "NA",
                        'agentid' => "NA",
                        'qty' => "NA",
                        'site' => $userdata->site
                    );
                    $this->db->insert('transaction', $ardata);
                    echo 1;
                }
            } else {
                echo 1;
            }
        } else {
            redirect('/partner');
        }
    }

    public function updatedebituser() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $user = $this->input->post('uid');
                $amount = $this->input->post('amount');
                $userdata = $this->db->get_where('users', array('id' => $user))->row();
                if ($amount <= 0) {
                    echo "INVALID AMOUNT";
                } else {
                    $wallet = $userdata->wallet;
                    $newbal = $wallet - $amount;
                    $this->db->where('id', $userdata->id);
                    $this->db->update('users', array('wallet' => $newbal));
                    $txnid = "DEDUCT" . rand(1111111111, 9999999999);
                    $ardata = array(
                        'uid' => $userdata->id,
                        'member' => $userdata->username,
                        'type' => "DEDUCT",
                        'txntype' => "CREDIT",
                        'txnid' => $txnid,
                        'reference' => "NA",
                        'status' => "SUCCESS",
                        'amount' => $amount,
                        'response' => "NA",
                        'commission' => "NA",
                        'deposit' => "NA",
                        'withdraw' => "NA",
                        'opening' => $wallet,
                        'closing' => $newbal,
                        'mobile' => "NA",
                        'roperator' => "NA",
                        'rcircle' => "NA",
                        'consumer' => "NA",
                        'doperator' => "NA",
                        'boperator' => "NA",
                        'rid' => "NA",
                        'bid' => "NA",
                        'account' => "NA",
                        'ifsc' => "NA",
                        'bname' => "NA",
                        'remittermobile' => "NA",
                        'agentid' => "NA",
                        'qty' => "NA",
                        'site' => $userdata->site
                    );
                    $this->db->insert('transaction', $ardata);
                    echo 1;
                }
            } else {
                echo 1;
            }
        } else {
            redirect('/partner');
        }
    }

    public function userrequest() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
            $this->load->view('partner/userrequest', $data);
        } else {
            redirect('/partner');
        }
    }

    public function approveuser() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $rid = $this->input->post('rid');
                if ($rid == "") {
                    echo 1;
                }
                $data = array('rid' => $rid);
                $this->load->view('partner/approveuser', $data);
            } else {
                echo 1;
            }
        } else {
            redirect('/partner');
        }
    }

    public function approveusers() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $rid = $this->input->post('rid');
                $package = $this->input->post('apackage');
                if ($rid == "" || $package == "") {
                    echo "PLEASE SEND PROPER DATA";
                }
                $udata = $this->db->get_where('register', array('id' => $rid))->row();
                $role = $udata->role;

                if ($role == 2) {
                    $username = "SH" . rand(111111, 999999);
                } elseif ($role == 3) {
                    $username = "MD" . rand(111111, 999999);
                } elseif ($role == 4) {
                    $username = "DT" . rand(111111, 999999);
                } elseif ($role == 5) {
                    $username = "RT" . rand(111111, 999999);
                } else {
                    echo "ERROR";
                    exit();
                }
                $password = rand(111111, 999999);
                $pin = rand(1111, 9999);
                $profile = "https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg";

                $site = $this->db->get_where('sites', array('rid' => $_SESSION['rid']))->row()->id;

                $mcount = $this->db->get_where('users', array('phone' => $udata->mobile))->num_rows();
                if ($mcount > 0) {
                    echo "MOBILE NUMBER ALREADY EXIT";
                    exit();
                }
                $gcount = $this->db->get_where('users', array('email' => $udata->email))->num_rows();
                if ($gcount > 0) {
                    echo "EMAIL ALREADY EXIT";
                    exit();
                }
                $ardata = array(
                    'name' => $udata->first . " " . $udata->last,
                    'username' => $username,
                    'password' => $password,
                    'email' => $udata->email,
                    'phone' => $udata->mobile,
                    'wallet' => "0",
                    'active' => "1",
                    'otp' => "1234",
                    'package' => $package,
                    'role' => $udata->role,
                    'owner' => "0",
                    'pin' => $pin,
                    'profile' => $profile,
                    'recharge' => "1",
                    'dmt' => "1",
                    'aeps' => "1",
                    'iaeps' => "1",
                    'bbps' => "1",
                    'qtransfer' => "1",
                    'payout' => "1",
                    'uti' => "1",
                    'site' => $site
                );
                $this->db->insert('users', $ardata);
                $this->db->delete('register', array('id' => $rid));
                echo 1;
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function rejectusers() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $rid = $this->input->post('rid');
                if ($rid == "") {
                    echo "PLEASE SEND PROPER DATA";
                }
                $this->db->delete('register', array('id' => $rid));
                echo 1;
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function fundrequest() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
            $this->load->view('partner/fundrequests', $data);
        } else {
            redirect('/partner');
        }
    }

    public function approvefund() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $rid = $this->input->post('rid');
                if ($rid == "") {
                    echo "PLEASE SEND PROPER DATA";
                } else {
                    $rdata = $this->db->get_where('topup', array('id' => $rid))->row();
                    if ($rdata->amount <= 0) {
                        echo "INVALID AMOUNT";
                    } else {
                        $amount = $rdata->amount;
                        $userdata = $this->db->get_where('users', array('id' => $rdata->uid))->row();
                        $wallet = $userdata->wallet;
                        $newbal = $wallet + $amount;
                        $this->db->where('id', $userdata->id);
                        $this->db->update('users', array('wallet' => $newbal));
                        $txnid = "TOPUP" . rand(1111111111, 9999999999);
                        $site = $this->db->get_where('sites', array('rid' => $_SESSION['rid']))->row()->id;
                        $wrdata = array(
                            'type' => "FUND-REQUEST",
                            'txntype' => "CREDIT",
                            'opening' => $wallet,
                            'closing' => $newbal,
                            'uid' => $userdata->id,
                            'txnid' => $txnid,
                            'amount' => $amount,
                            'site' => $site
                        );
                        $this->db->insert('wallet', $wrdata);

                        $this->db->update('topup', array('status' => 'APPROVED'), array('id' => $rid));

                        echo 1;
                    }
                }
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function rejectfund() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $rid = $this->input->post('rid');
                if ($rid == "") {
                    echo "PLEASE SEND PROPER DATA";
                } else {
                    $this->db->update('topup', array('status' => 'REJECTED'), array('id' => $rid));
                    echo 1;
                }
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function regfees() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
            $this->load->view('partner/regfees', $data);
        } else {
            redirect('/partner');
        }
    }

    public function updatecharge() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $md = $this->input->post('md');
                $dt = $this->input->post('dt');
                $rt = $this->input->post('rt');
                if ($md == "" || $dt == "" || $rt == "") {
                    echo "PLEASE SEND PROPER DATA";
                } else {
                    $this->db->update('sites', array('md' => $md, 'dt' => $dt, 'rt' => $rt), array('rid' => $_SESSION['rid']));
                    echo 1;
                }
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function movemember() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
            $this->load->view('partner/movemember', $data);
        } else {
            redirect('/partner');
        }
    }

    public function getdata() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $user = $this->input->post('user');
                $data = array('user' => $user);
                $this->load->view('partner/movememberdata', $data);
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function movemembertra() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $user = $this->input->post('user');
                $owner = $this->input->post('owner');
                if ($user == "" || $owner == "") {
                    echo "PLEASE SEND PROPER DATA";
                } else {
                    $this->db->update('users', array('owner' => $owner), array('id' => $user));
                    echo 1;
                }
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function lockamount() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
            $this->load->view('partner/lockamount', $data);
        } else {
            redirect('/partner');
        }
    }

    public function getwdata() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $user = $this->input->post('user');
                $data = array('user' => $user);
                $this->load->view('partner/getwdata', $data);
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function lockamountd() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $user = $this->input->post('user');
                $amount = $this->input->post('amount');
                if ($user == "" || $amount == "") {
                    echo "PLEASE SEND PROPER DATA";
                } else {
                    if ($amount <= 0) {
                        echo "INVALID AMOUNT";
                    } else {
                        $userdata = $this->db->get_where('users', array('id' => $user))->row();
                        if ($userdata->wallet > $amount) {
                            $site = $userdata->site;
                            $wallet = $userdata->wallet;
                            $newbal = $wallet - $amount;
                            $lamount = $userdata->lamount + $amount;
                            $this->db->where('id', $userdata->id);
                            $this->db->update('users', array('wallet' => $newbal, 'lamount' => $lamount));
                            $txnid = "LOCK" . rand(1111111111, 9999999999);
                            $ardata = array(
                                'uid' => $userdata->id,
                                'member' => $userdata->username,
                                'type' => "LOCK",
                                'txntype' => "DEBIT",
                                'txnid' => $txnid,
                                'reference' => "NA",
                                'status' => "SUCCESS",
                                'amount' => $amount,
                                'response' => "NA",
                                'commission' => "NA",
                                'deposit' => "NA",
                                'withdraw' => "NA",
                                'opening' => $wallet,
                                'closing' => $newbal,
                                'mobile' => "NA",
                                'roperator' => "NA",
                                'rcircle' => "NA",
                                'consumer' => "NA",
                                'doperator' => "NA",
                                'boperator' => "NA",
                                'rid' => "NA",
                                'bid' => "NA",
                                'account' => "NA",
                                'ifsc' => "NA",
                                'bname' => "NA",
                                'remittermobile' => "NA",
                                'agentid' => "NA",
                                'qty' => "NA",
                                'site' => $site
                            );
                            $this->db->insert('transaction', $ardata);
                            echo 1;
                        } else {
                            echo "INSUFFICIENT FUND";
                        }
                    }
                }
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function unlockamountd() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $user = $this->input->post('user');
                $amount = $this->input->post('amount');
                if ($user == "" || $amount == "") {
                    echo "PLEASE SEND PROPER DATA";
                } else {
                    if ($amount <= 0) {
                        echo "INVALID AMOUNT";
                    } else {
                        $userdata = $this->db->get_where('users', array('id' => $user))->row();
                        if ($userdata->lamount > $amount) {
                            $site = $userdata->site;
                            $wallet = $userdata->wallet;
                            $newbal = $wallet + $amount;
                            $lamount = $userdata->lamount - $amount;
                            $this->db->where('id', $userdata->id);
                            $this->db->update('users', array('wallet' => $newbal, 'lamount' => $lamount));
                            $txnid = "UNLOCK" . rand(1111111111, 9999999999);
                            $ardata = array(
                                'uid' => $userdata->id,
                                'member' => $userdata->username,
                                'type' => "UNLOCK",
                                'txntype' => "CREDIT",
                                'txnid' => $txnid,
                                'reference' => "NA",
                                'status' => "SUCCESS",
                                'amount' => $amount,
                                'response' => "NA",
                                'commission' => "NA",
                                'deposit' => "NA",
                                'withdraw' => "NA",
                                'opening' => $wallet,
                                'closing' => $newbal,
                                'mobile' => "NA",
                                'roperator' => "NA",
                                'rcircle' => "NA",
                                'consumer' => "NA",
                                'doperator' => "NA",
                                'boperator' => "NA",
                                'rid' => "NA",
                                'bid' => "NA",
                                'account' => "NA",
                                'ifsc' => "NA",
                                'bname' => "NA",
                                'remittermobile' => "NA",
                                'agentid' => "NA",
                                'qty' => "NA",
                                'site' => $site
                            );
                            $this->db->insert('transaction', $ardata);
                            echo 1;
                        } else {
                            echo "INSUFFICIENT FUND";
                        }
                    }
                }
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function upgrade() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
            $this->load->view('partner/updateuser', $data);
        } else {
            redirect('/partner');
        }
    }

    public function getupdata() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $user = $this->input->post('user');
                $data = array('user' => $user);
                $this->load->view('partner/getupdata', $data);
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function upgradenewuser() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $user = $this->input->post('user');
                $role = $this->input->post('role');
                $data = array('user' => $user, 'role' => $role);
                $this->load->view('partner/getupnewdata', $data);
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function newtoupgrade() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $role = $this->input->post('role');
                $user = $this->input->post('user');
                $pkg = $this->input->post('pkg');
                if ($role == "" || $user == "" || $pkg == "") {
                    echo "ERROR";
                } else {
                    if ($role == 2) {
                        $username = "SH" . rand(111111, 999999);
                    } elseif ($role == 3) {
                        $username = "MD" . rand(111111, 999999);
                    } elseif ($role == 4) {
                        $username = "DT" . rand(111111, 999999);
                    } elseif ($role == 5) {
                        $username = "RT" . rand(111111, 999999);
                    } else {
                        echo "ERROR";
                        exit();
                    }
                    $this->db->update('users', array('username' => $username, 'role' => $role), array('id' => $user));
                    echo 1;
                }
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function profilekyc() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth, 'type' => 'profile');
            $this->load->view('partner/transaction/transaction', $data);
        } else {
            redirect('/partner');
        }
    }

    public function viewprofilekyc() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $kid = $this->input->post('kid');
                if ($kid == "") {
                    echo 5;
                } else {
                    $data = array('kid' => $kid);
                    $this->load->view('partner/viewprofilekyc', $data);
                }
            } else {
                echo 1;
            }
        } else {
            redirect('/partner');
        }
    }

    public function kycapproverequest() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $kid = $this->input->post('kid');
                if ($kid == "") {
                    echo "ERROR";
                } else {
                    $this->db->update('kyc', array('active' => "1"), array('id' => $kid));
                    echo 1;
                }
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function kycrejectrequest() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $kid = $this->input->post('kid');
                if ($kid == "") {
                    echo "ERROR";
                } else {
                    $kdata = $this->db->get_where('kyc', array('id' => $kid))->row();
                    if ($kdata->active == "1") {
                        echo "ERROR";
                    } else {
                        $this->db->delete('kyc', array('id' => $kid));
                        echo 1;
                    }
                }
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function approvepayout() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth, 'type' => 'pacc');
            $this->load->view('partner/transaction/transaction', $data);
        } else {
            redirect('/partner');
        }
    }

    public function rejectpayaccount() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $bid = $this->input->post('bid');
                if ($bid == "") {
                    echo "PLEASE SEND ALL DATA";
                } else {
                    $this->db->delete('payoutaccount', array('id' => $bid));
                    echo 1;
                }
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function approvepayaccount() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $bid = $this->input->post('bid');
                if ($bid == "") {
                    echo "PLEASE SEND ALL DATA";
                } else {
                    $data = array('bid' => $bid);
                    $this->load->view('partner/payapview', $data);
                }
            } else {
                echo 1;
            }
        } else {
            redirect('/partner');
        }
    }

    public function aprrovebtnpay() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $bid = $this->input->post('bid');
                if ($bid == "") {
                    echo "PLEASE SEND ALL DATA";
                } else {
                    $this->db->where('id', $bid);
                    $this->db->update('payoutaccount', array('status' => 'APPROVED'));
                    echo 1;
                }
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function accountverification() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $bid = $this->input->post('bid');
                if ($bid == "") {
                    echo "PLEASE SEND ALL DATA";
                } else {
                    $dd = $this->db->get_where('payoutaccount', array('id' => $bid))->row();
                    $link = "https://payu.startrecharge.in/Bank/AccountVerify?token=ijXMXKTs36O6w06A1S7alshi4eU0o3&Account=" . $dd->account . "&IFSC=" . $dd->ifsc . "";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $link);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $data = json_decode($result);
                    if ($data->Status == "Error") {
                        echo $data->Message;
                    } else {
                        $dat = $data->data;
                        echo "Account Holder Name: <strong>" . $dat->BeneficiaryName . "</strong>";
                    }
                }
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function panverification() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $pan = $this->input->post('pan');
                if ($pan == "") {
                    echo "PLEASE SEND ALL DATA";
                } else {
                    $txnid = "PANVER" . rand(1111111111, 9999999999);
                    $link = "https://api.startrecharge.in/PAN/PANVERIFY?token=ijXMXKTs36O6w06A1S7alshi4eU0o3&PAN=" . $pan . "&txnid=" . $txnid;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $link);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $data = json_decode($result);
                    if ($data->Status == "Error") {
                        echo $data->Message;
                    } else {
                        print_r($data);
                        exit();
                        $dat = $data->data;
                        echo "Account Holder Name: <strong>" . $dat->BeneficiaryName . "</strong>";
                    }
                }
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

    public function manageservice() {
        if (isset($_SESSION['rid'])) {
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
            $_SESSION['auth'] = $auth;
            $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
            $this->load->view('partner/manageservice', $data);
        } else {
            redirect('/partner');
        }
    }

    public function updateservice() {
        if (isset($_SESSION['rid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $aeps = $this->input->post('aeps');
                $bbps = $this->input->post('bbps');
                $recharge = $this->input->post('recharge');
                $payout = $this->input->post('payout');
                $uti = $this->input->post('uti');
                $qtransfer = $this->input->post('qtransfer');
                $dmt = $this->input->post('dmt');
                $iaeps = $this->input->post('iaeps');
                if ($aeps == "" || $bbps == "" || $recharge == "" || $payout == "" || $uti == "" || $qtransfer == "" || $dmt == "" || $iaeps == "") {
                    echo "PLEASE SEND PROPER DATA";
                } else {
                    $site = $this->db->get_where('sites', array('rid' => $_SESSION['rid']))->row()->id;
                    $data = array(
                        'aeps' => $aeps,
                        'bbps' => $bbps,
                        'recharge' => $recharge,
                        'uti' => $uti,
                        'payout' => $payout,
                        'qtransfer' => $qtransfer,
                        'dmt' => $dmt,
                        'iaeps' => $iaeps
                    );
                    $this->db->update('service', $data, array('site' => $site));
                    echo 1;
                }
            } else {
                echo "INVALID TOKEN";
            }
        } else {
            redirect('/partner');
        }
    }

}
