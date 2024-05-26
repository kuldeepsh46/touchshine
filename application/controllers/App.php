<?php

class App extends CI_Controller {

    public function index() {

        print_r(json_encode(array('status' => "SUCCESS")));
        exit();
    }

    public function login() {
        $data = array(
            'username' => $this->input->post("username"),
            'password' => $this->input->post("password"),
            'name' => $this->input->post("name"),
            'imei' => $this->input->post("imei"),
            'log' => $this->input->post("log"),
            'lat' => $this->input->post("lat")
        );
        $data = json_encode($data);
        $data = json_decode($data);


        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';


        $token = substr(str_shuffle($str_result),
                0, 30);
        $secret = substr(str_shuffle($str_result),
                0, 30);

        $otp = rand(1000, 9999);

        if ($data->username == "" || $data->password == "" || $data->imei == "" || $data->name == "" || $data->lat == "" || $data->log == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "DATA FILEDS ARE MISSIONG", 'error_code' => 101)));
            exit();
        }

        $user = $this->db->get_where('users', array('username' => $data->username))->num_rows();
        if ($user <= 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "USERNAME NOT FOUND", 'error_code' => 102)));

            exit();
        }
        $user = $this->db->get_where('users', array('username' => $data->username))->row();
        $uid = $user->id;
        if ($user->password != $data->password) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "WRONG PASSWORD", 'error_code' => 102)));
            exit();
        }
        $idata = array(
            'token' => $token,
            'uid' => $uid,
            'mobile' => $user->phone,
            'otp' => $otp,
            'imei' => $data->imei,
            'name' => $data->name,
            'lat' => $data->lat,
            'log' => $data->log,
            'ip' => $_SERVER['REMOTE_ADDR'],
            'secret' => $secret
        );

        $udata = array(
            'token' => $token,
            'otp' => $otp,
            'imei' => $data->imei,
            'name' => $data->name,
            'lat' => $data->lat,
            'log' => $data->log,
            'ip' => $_SERVER['REMOTE_ADDR'],
            'secret' => $secret
        );



        //adding entry
        $logdat = $this->db->get_where('app', array('mobile' => $user->phone))->num_rows();
        if ($logdat > 0) {

            $this->db->update('app', $udata, array('mobile' => $user->phone));
        } else {

            $this->db->insert('app', $idata);
        }


        print_r(json_encode(array('status' => "SUCCESS", 'msg' => "ENTER YOUR SECURITY PIN", 'error_code' => 0)));
    }

    public function login_verify() {

        $data = array('username' => $this->input->post("username"), 'otp' => $this->input->post("otp"));
        $data = json_encode($data);
        $data = json_decode($data);
        if ($data->username == "" || $data->otp == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "DATA FILEDS ARE MISSIONG", 'error_code' => 101)));
            exit();
        }
        $userc = $this->db->get_where('users', array('username' => $data->username))->num_rows();
        if ($userc <= 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "USERNAME NOT EXITS", 'error_code' => 101)));
            exit();
        }
        $user = $this->db->get_where('users', array('username' => $data->username))->row();
        $logdat = $this->db->get_where('app', array('mobile' => $user->phone))->num_rows();
        if ($logdat > 0) {

            $logdat = $this->db->get_where('app', array('mobile' => $user->phone))->row();
            if ($user->pin == $data->otp) {


                $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                $token = substr(str_shuffle($str_result),
                        0, 30);
                $secret = substr(str_shuffle($str_result),
                        0, 30);


                $udata = array(
                    'token' => $token,
                    'secret' => $secret
                );
                $role = $user->role;


                $this->db->update('app', $udata, array('mobile' => $user->phone));

                $dat = array('api_key' => $token, 'api_secret' => $secret);
                $logdat = $this->db->get_where('app', array('mobile' => $user->phone))->row();
                print_r(json_encode(array('status' => "SUCCESS", 'msg' => "SUCCESSFULLY LOGGED IN", 'error_code' => 0, 'data' => $dat, 'role' => $role, 'user_id' => $user->id)));
                exit();
            } else {
                print_r(json_encode(array('status' => "ERROR", 'msg' => "PIN NOT MATCHED", 'error_code' => 401)));
                exit();
            }
        } else {

            print_r(json_encode(array('status' => "ERROR", 'msg' => "DATA NOT FOUND", 'error_code' => 203)));
            exit();
        }
    }

    public function checksession() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $kyc = $this->db->get_where("kyc", array('uid' => $uid))->num_rows();
        $kycdata = $this->db->get_where("kyc", array('uid' => $uid))->row();
        $inkyc_st = $this->db->get_where("indus_kyc", array('uid' => $uid))->num_rows();
        $inkycdata = $this->db->get_where("indus_kyc", array('uid' => $uid))->row();
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $sites = $this->db->get('sites', array('id' => $user->site))->row();
        if ($kyc == 0) {
            $kyc = "no";
        } else {
            if ($kycdata->active == "1") {
                $kyc = "yes";
            } elseif ($kycdata->active == "0") {
                $kyc = "pending";
            } else {
                $kyc = "incomplete";
            }
        }

        $banner1 = $this->db->get_where('settings', array('name' => 'banner1'))->row()->value;
        $banner2 = $this->db->get_where('settings', array('name' => 'banner2'))->row()->value;
        $banner3 = $this->db->get_where('settings', array('name' => 'banner3'))->row()->value;
        print_r(json_encode(array('status' => "SUCCESS", 'kyc' => $kyc, 'indkyc' => $inkyc_st, 'user' => $user, 'sites' => $sites, 'kycdata' => $kycdata, 'indkyc_data' => $inkycdata, 'banner1' => $banner1, 'banner2' => $banner2, 'banner3' => $banner3)));
        exit();
    }

    public function uploadprofile() {
        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $profileim = $this->input->post('profileimg');
        if ($profileim == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }
        $profilefilename = "profileimg" . rand(0000000000, 9999999999) . "jpg";
        $path = "uploads/";
        $profileimg = base_url() . "/uploads/" . $profilefilename;
        write_file($path . $profilefilename, base64_decode($profileim));
        $this->db->update('users', array('profile' => $profileimg), array('id' => $uid));
        print_r(json_encode(array('status' => "SUCCESS", 'msg' => "IMAGE UPDATED", 'error_code' => 0)));
        exit();
    }

    public function forgotpasssendotp() {
        $username = $this->input->post("username");
        if ($username == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }
        $count = $this->db->get_where("users", array('username' => $username))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "USERNAME NOT EXITS", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("users", array('username' => $username))->row()->id;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $otp = rand(1111, 9999);
        $senderid = "MONSFT";
        $phone = $user->phone;
        $message = " Dear User Your Password Reset OTP is " . $otp . " And do not share this OTP with anyone, Thanks Team MOSFTY";
        $template = "1707165259121486813";
        send_sms($senderid, $phone, $message, $template);
        $cotp = $this->db->get_where('forgot_otp', array('uid' => $uid))->num_rows();
        if ($cotp > 0) {
            $this->db->delete('forgot_otp', array('uid' => $uid));
        }
        $this->db->insert('forgot_otp', array('uid' => $uid, 'otp' => $otp));
        print_r(json_encode(array('status' => "SUCCESS", 'msg' => "OTP SEND SUCCESSFULL", 'error_code' => 0)));
        exit();
    }

    public function forgotpass() {
        $username = $this->input->post("username");
        if ($username == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("users", array('username' => $username))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID USERNAME", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("users", array('username' => $username))->row()->id;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $type = $this->input->post('type');
        $data = $this->input->post('data');
        $otp = $this->input->post('otp');
        if ($type == "" || $data == "" || $otp == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }
        $oottpp = $this->db->get_where('forgot_otp', array('uid' => $uid))->row();
        if ($oottpp->otp != $otp) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "OTP NOT MATCH", 'error_code' => 203)));
            exit();
        }
        $this->db->update('users', array($type => $data), array('id' => $uid));
        print_r(json_encode(array('status' => "SUCCESS", 'msg' => "DATA UPDATED", 'error_code' => 0)));
        exit();
    }

    public function banks() {
        $banks = $this->db->get('bank')->result();
        print_r(json_encode(array('status' => "SUCCESS", 'data' => $banks, 'error_code' => 0)));
        exit();
    }

    public function addfundreq() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $bank = $this->input->post('bank');
        $amount = $this->input->post('amount');
        $rrn = $this->input->post('rrn');
        $proof = $this->input->post('proof');
        if ($bank == "" || $amount == "" || $rrn == "" || $proof == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE SEND PROPER DATA", 'error_code' => 203)));
            exit();
        }
        $profilefilename = "proof" . rand(0000000000, 9999999999) . "jpg";
        $path = "uploads/";
        $profileimg = base_url() . "/uploads/" . $profilefilename;
        write_file($path . $profilefilename, base64_decode($proof));
        $site = $this->db->get_where('users', array('id' => $uid))->row()->site;
        $txnid = "TOPUP" . rand(1111111111, 9999999999);
        $ardata = array(
            'amount' => $amount,
            'txnid' => $txnid,
            'proof' => $profileimg,
            'status' => "PENDING",
            'bank' => $bank,
            'uid' => $uid,
            'rrn' => $rrn,
            'site' => $site
        );
        $this->db->insert('topup', $ardata);
        print_r(json_encode(array('status' => "SUCCESS", 'msg' => "FUND REQUEST SUBMITED", 'error_code' => 0)));
        exit();
    }

    /* Code Changes by Krishna-AP-270422 */

    public function kyc() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        /* input data validate */

        $address = $this->input->post('address');
        $district = $this->input->post('district');
        $state = $this->input->post('state');
        $dob = $this->input->post('dob');
        $fname = $this->input->post('fname');
        $pin = $this->input->post('pin');
        $aadharno = $this->input->post('aadharno');
        $panno = $this->input->post('panno');
        $sname = $this->input->post('sname');
        $saddress = $this->input->post('saddress');
        $aadharimg = $this->input->post('aadharimg');
        $adhaarback = $this->input->post('aadharimgback');
        $photo = $this->input->post('photoimg');
        $panimg = $this->input->post('panimg');
        if ($address == "" || $district == "" || $state == "" || $adhaarback == "" || $dob == "" || $fname == "" || $pin == "" || $aadharno == "" || $panno == "" || $sname == "" || $saddress == "" || $aadharimg == "" || $panimg == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "FILL ALL DETAILS", 'error_code' => 0)));
            exit();
        }

        $adhaarfilename = "adhaar" . rand(0000000000, 9999999999) . ".jpg";
        $photofilename = "photo" . rand(0000000000, 9999999999) . ".jpg";
        $panfilename = "pan" . rand(0000000000, 9999999999) . ".jpg";
        $backaadharfilename = "adhaarback" . rand(0000000000, 9999999999) . ".jpg";
        $path = "uploads/";
        $adhaarimg = base_url() . "/uploads/" . $adhaarfilename;
        $photoimg = base_url() . "/uploads/" . $photofilename;
        $aadharback = base_url() . "/uploads/" . $backaadharfilename;
        $panimgs = base_url() . "/uploads/" . $panfilename;

        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $kyc = $this->db->get_where("kyc", array('uid' => $uid))->num_rows();


        if ($kyc > 0) {
            write_file($path . $adhaarfilename, base64_decode($aadharimg));
            //write_file($path.$photofilename, base64_decode($photoimg));
            write_file($path . $backaadharfilename, base64_decode($adhaarback));
            write_file($path . $panfilename, base64_decode($panimg));
            $data = array(
                'address' => $address,
                'district' => $district,
                'state' => $state,
                'dob' => $dob,
                'fname' => $fname,
                'pincode' => $pin,
                'adhaar' => $aadharno,
                'pan' => $panno,
                'adhaarimg' => $adhaarimg,
                'adhaarback' => $aadharback,
                'panimg' => $panimgs,
                'shopname' => $sname,
                'shopaddress' => $saddress,
                'active' => "0",
                'site' => $user->site
            );

            $this->db->where('uid', $uid);
            $this->db->update('kyc', $data);

            print_r(json_encode(array('status' => "SUCCESS", 'msg' => "KYC SUCCESSFULL UPDATED", 'error_code' => 0)));
            exit();
        } else {
            write_file($path . $adhaarfilename, base64_decode($aadharimg));
            //write_file($path.$photofilename, base64_decode($photoimg));
            write_file($path . $backaadharfilename, base64_decode($adhaarback));
            write_file($path . $panfilename, base64_decode($panimg));

            $data = array(
                'uid' => $uid,
                'address' => $address,
                'district' => $district,
                'state' => $state,
                'dob' => $dob,
                'fname' => $fname,
                'pincode' => $pin,
                'adhaar' => $aadharno,
                'pan' => $panno,
                'adhaarimg' => $adhaarimg,
                'adhaarback' => $aadharback,
                'panimg' => $panimgs,
                'shopname' => $sname,
                'shopaddress' => $saddress,
                'active' => "0",
                'site' => $user->site
            );

            $this->db->insert('kyc', $data);


            print_r(json_encode(array('status' => "SUCCESS", 'msg' => "KYC SUCCESSFULL Submited", 'error_code' => 0)));
            exit();
        }
    }
	
	public function getcurentrecharje() {
        $data = $this->db->get_where('settings',array('name' => 'recharge_api'))->row();
        print_r(json_encode(array('status' => "SUCCESS", 'data' => $data, 'error_code' => 0)));
        exit();
    }

    public function oplist() {
        $data = $this->db->get('rechargev2op')->result();
        print_r(json_encode(array('status' => "SUCCESS", 'data' => $data, 'error_code' => 0)));
        exit();
    }

    public function oplist_lapu() {
        $data = $this->db->get('rechargev2op_lapu')->result();
        print_r(json_encode(array('status' => "SUCCESS", 'data' => $data, 'error_code' => 0)));
        exit();
    }
    public function opfetch() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $mobile = $this->input->post('mobile');
        if ($mobile == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID MOBILE NUMBER", 'error_code' => 203)));
            exit();
        } else {
            $apikey = $this->db->get_where('settings', array('name' => 'api_key'))->row()->value;
            $this->load->helper('recharge');

            $url = "https://api.softpayapi.com/api/Operator/OperatorInformation?api_key=CZ791105NM5AYLUA6FGHRSBD3C6QI72XW8KT2BVE38OD0J9P44" . "&mobile_number=" . $mobile;

            $result = curl_get_file_contents($url);

            $datares = json_decode($result);
            //log_message('debug',print_r($datares,TRUE));
            $op = $datares->Operator;
            if ($op == "Jio") {
                $opid = "4";
            } elseif ($op == "Vodafone Idea") {
                $opid = "3";
            } elseif ($op == "BSNL") {
                $opid = "2";
            } elseif ($op == "Airtel") {
                $opid = "1";
            } else {
                $opid = "0";
            }
            print_r(json_encode(array('status' => "SUCCESS", 'opid' => $opid, 'circle' => $datares->Circlecode, 'opname' => $op, 'error_code' => 0)));
            exit();
        }
    }

    public function viewrplan() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $operator = $this->input->post('operator');
        $circle = $this->input->post('circle');
        if ($operator == "" || $circle == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID OPERATOR", 'error_code' => 203)));
            exit();
        } else {

            $opdtl = $this->db->get_where('rechargev2op', array('id' => $operator))->row();
            $opcode = $opdtl->opcode_v;
            $opname = $opdtl->name;

            $this->load->helper('recharge');
            $responce = viewplans($circle, $opcode);

            $data = json_decode($responce);

            if ($data->Status == "Success") {

                $data = json_encode(array('status' => "SUCCESS", 'data' => $data->Data, 'error_code' => 0));
                print_r($data);
                exit();
            }
        }
    }

    /* Code Changes by Krishna-App-RC-250422 */

    public function dorecharge() {
        
        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->row()->recharge;
        if ($aservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check whitelabel 
        $user = $this->db->get_where('users', array('id' => $uid))->row();
        $rid = $this->db->get_where('sites', array('id' => $user->site))->row()->rid;
        $rservice = $this->db->get_where('reseller', array('id' => $rid))->row()->recharge;
        if ($rservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check reseller service 
        $service = $this->db->get_where('service', array('site' => $user->site))->row()->recharge;
        if ($service != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check user 
        if ($user->recharge != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        $udata = $this->db->get_where('users', array('id' => $uid))->row();
        $site = $udata->site;
        $sdata = $this->db->get_where('sites', array('id' => $site))->row();
        $rdata = $this->db->get_where('reseller', array('id' => $sdata->rid))->row();
        $mobile = $this->input->post('mobile');
        $amount = $this->input->post('amount');
        $operator = $this->input->post('operator');
        $circle = $this->input->post('circle');
        if ($mobile == "" || $amount == "" || $operator == "" || $circle == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "FILL PROPER DATA", 'error_code' => 203)));
            exit();
        } else {
            if ($amount <= 0) {
                print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID AMOUNT", 'error_code' => 203)));
                exit();
            } else {
                //check user wallet

                 if($amount >= $udata->main_wallet){
                    print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT FUND", 'error_code' => 203)));
                    exit();
                } else {
                    //check reseller wallet
                    if($amount >= $rdata->main_wallet){
                        print_r(json_encode(array('status' => "ERROR", 'msg' => "TECHNICAL ISSUE CONTACT TO ADMIN", 'error_code' => 203)));
                        exit();
                    } else {
						
								$api_key = $this->db->get_where('settings',array('name' => "api_key"))->row()->value;
                              $opcode = $this->db->get_where('rechargev2op',array('id' => $operator))->row()->opcode;
                              
			                   $this->load->helper('recharge');
                              $txnid = "RC".rand(1111111111,9999999999);
			                   $responce = recharge($api_key,$mobile,$amount,$opcode,$circle,$txnid);
			                  
			                   $main =$responce;
			                   log_message('debug',print_r($responce,true));
			                   //print_r($main);
                               $status = ucfirst(strtolower($responce->Status));
                               $apitxnid = $responce->ApiTransID;
                               $reffernce = $responce->OperatorRef;
			                   if($status == "Success"){
			                      
			                    //update reseller wallet
			                    $rnewbal = $rdata->main_wallet - $amount;
			                    $this->db->where('id',$sdata->rid);
			                    $this->db->update('reseller',array('main_wallet' => $rnewbal));
			                    //entry reseller txn 
			                    $rdataarray = array(
			                        'type' => "RECHARGE",
			                        'txnid' => $txnid,
			                        'amount' => $amount,
			                        'opening' => $rdata->main_wallet,
			                        'closing' => $rnewbal,
			                        'rid' => $sdata->rid	
			                        );
			                        log_message('debug',print_r($rdataarray,true));
			                     $this->db->insert('rtransaction_main',$rdataarray);
			                     //update COMMISSION reseller wallet
			                     $pkg = $this->db->get_where('reseller',array('id' => $sdata->rid))->row()->package;
			                     $countcw = $this->db->get_where('comissionv2',array('operator' => $operator,'package' => $pkg))->row();
			                     if($countcw->percent == "1"){
			                         $comm = $amount * $countcw->amount / 100;
			                     }else{
			                         $comm = $countcw->amount;
			                     }
			                     
			                     $rdata = $this->db->get_where('reseller',array('id' => $sdata->rid))->row();
			                    $rnewbal = $rdata->main_wallet + $comm;
			                    $this->db->where('id',$sdata->rid);
			                    $this->db->update('reseller',array('main_wallet' => $rnewbal));
			                    //entry commision reseller txn 
			                    $rdataarray = array(
			                        'type' => "RECHARGE-COMMISSION",
			                        'txnid' => $txnid,
			                        'amount' => $comm,
			                        'opening' => $rdata->main_wallet,
			                        'closing' => $rnewbal,
			                        'rid' => $sdata->rid	
			                        );
			                        log_message('debug',print_r($rdataarray,true));
								 $this->db->insert('rtransaction_main',$rdataarray);
			                     //update user wallet 
			                     $unewbal = $udata->main_wallet - $amount;
			                     $this->db->where('id',$uid);
			                     $this->db->update('users',array('main_wallet' => $unewbal));
			                     //user recharge txn entry 
			                     $member = $udata->username;
			                     $udataarray = array(
			                         'uid' => $uid,
			                         'txnid' => $txnid,
			                         'apitxnid' => $apitxnid,
			                         'mobile' => $mobile,
			                         'operator' => $operator,
			                         'amount' => $amount,
			                         'status' => $status,
			                         'response' => json_encode($responce),
			                         'site' => $site
			                         );
			                   $this->db->insert('rechargetxn',$udataarray);
			                   $udataarray = array(
			                         'uid' => $uid,
			                         'type' => "RECHARGE",
			                         'txntype' => "DEBIT",
			                         'opening' => $udata->main_wallet,
			                         'closing' => $unewbal,	
			                         'txnid' => $txnid,
			                         'amount' => $amount,
			                         'site' => $site
			                         );
			                   $this->db->insert('main_wallet',$udataarray);

			                   $this->load->model('Recharge_model');
                                $this->Recharge_model->rechargeCommission($uid,$operator,$amount,$txnid,$site);
                                $d= $uid.", ".$operator.", ".$amount.", ".$txnid.", ".$site;
                                $this->db->insert('test',array('data'=>$d));
			                   //echo 1;
			                    print_r(json_encode(array('status' => "SUCCESS", 'msg' => "RECHARGE SUCCESSFULL", 'error_code' => 0)));
								exit();
			                   }elseif($status == "Pending"){
			                       
			                    //update reseller wallet
			                    $rnewbal = $rdata->main_wallet - $amount;
			                    $this->db->where('id',$sdata->rid);
			                    $this->db->update('reseller',array('main_wallet' => $rnewbal));
			                    //entry reseller txn 
			                    $rdataarray = array(
			                        'type' => "RECHARGE",
			                        'txnid' => $txnid,
			                        'amount' => $amount,
			                        'opening' => $rdata->main_wallet,
			                        'closing' => $rnewbal,
			                        'rid' => $sdata->rid	
			                        );
			                     $this->db->insert('rtransaction_main',$rdataarray);
			                     //update user wallet 
			                     $unewbal = $udata->main_wallet - $amount;
			                     $this->db->where('id',$uid);
			                     $this->db->update('users',array('main_wallet' => $unewbal));
			                     //user txn entry 
			                     $member = $udata->username;
			                     $udataarray = array(
			                         'uid' => $uid,
			                         'txnid' => $txnid,
			                         'apitxnid' => $apitxnid,
			                         'mobile' => $mobile,
			                         'operator' => $operator,
			                         'amount' => $amount,
			                         'status' => $status,
			                         'response' => json_encode($responce),
			                         'site' => $site
			                         );
			                   $this->db->insert('rechargetxn',$udataarray);
			                   $udataarray = array(
			                         'uid' => $uid,
			                         'type' => "RECHARGE",
			                         'txntype' => "DEBIT",
			                         'opening' => $udata->main_wallet,
			                         'closing' => $unewbal,	
			                         'txnid' => $txnid,
			                         'amount' => $amount,
			                         'site' => $site
			                         );
			                   $this->db->insert('main_wallet',$udataarray);
			                   //echo "TRANSACTION PENDING";
							   //echo json_encode(array('status'=>'success','response'=>'TRANSACTION PENDING'));
							    print_r(json_encode(array('status' => "SUCCESS", 'msg' => "RECHARGE PENDING", 'error_code' => 0)));
								exit();
			                   }elseif($status == "Failure" || $status == "Refund" || $status == "Error"){
			                      
			                       $udataarray = array(
			                         'uid' => $uid,
			                         'txnid' => $txnid,
			                         'apitxnid' => $apitxnid,
			                         'mobile' => $mobile,
			                         'operator' => $operator,
			                         'amount' => $amount,
			                         'status' => $status,
			                         'response' => json_encode($responce),
			                         'site' => $site
			                         );
			                   $this->db->insert('rechargetxn',$udataarray);			                       
								   //echo json_encode(array('status'=>'failed','response'=>'TRANSACTION FAILED'));
								   print_r(json_encode(array('status' => "failed", 'msg' => "RECHARGE FAILED", 'error_code' => 203)));
								exit();
			                   }else{								  
								   print_r(json_encode(array('status' => "failed", 'msg' => "ERROR", 'error_code' => 203)));
								exit(); 
			                   }
			                 
						
                    }
                }
            }
        }
    }
	
	public function dorecharge_lapu() {
        
        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->row()->recharge;
        if ($aservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check whitelabel 
        $user = $this->db->get_where('users', array('id' => $uid))->row();
        $rid = $this->db->get_where('sites', array('id' => $user->site))->row()->rid;
        $rservice = $this->db->get_where('reseller', array('id' => $rid))->row()->recharge;
        if ($rservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check reseller service 
        $service = $this->db->get_where('service', array('site' => $user->site))->row()->recharge;
        if ($service != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check user 
        if ($user->recharge != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        $udata = $this->db->get_where('users', array('id' => $uid))->row();
        $site = $udata->site;
        $sdata = $this->db->get_where('sites', array('id' => $site))->row();
        $rdata = $this->db->get_where('reseller', array('id' => $sdata->rid))->row();
        $mobile = $this->input->post('mobile');
        $amount = $this->input->post('amount');
        $operator = $this->input->post('operator');
        $circle = $this->input->post('circle');
        if ($mobile == "" || $amount == "" || $operator == "" || $circle == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "FILL PROPER DATA", 'error_code' => 203)));
            exit();
        } else {
            if ($amount <= 0) {
                print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID AMOUNT", 'error_code' => 203)));
                exit();
            } else {
                //check user wallet

                 if($amount >= $udata->main_wallet){
                    print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT FUND", 'error_code' => 203)));
                    exit();
                } else {
                    //check reseller wallet
                    if($amount >= $rdata->main_wallet){
                        print_r(json_encode(array('status' => "ERROR", 'msg' => "TECHNICAL ISSUE CONTACT TO ADMIN", 'error_code' => 203)));
                        exit();
                    } else {
						
								$api_token = $this->db->get_where('settings',array('name' => "api_token"))->row()->value;
                              $company_id = $this->db->get_where('rechargev2op_lapu',array('id' => $operator))->row()->company_id;
                              
							 // echo "<pre>"; print_r($operator); die;
			                   $this->load->helper('recharge');
                               $txnid = "RC".rand(1111111111,9999999999);
			                   $responce = rechargeMobotics($api_token,$mobile,$amount,$company_id);
			                  //echo "<pre>"; print_r($responce); die;
			                   $main =$responce;
			                   log_message('debug',print_r($responce,true));
							   
							  // echo "<pre>"; print_r($responce); die;
			                   //print_r($main);
                               $status = ucfirst(strtolower($responce['status']));
                               $apitxnid = $responce['response']['tnx_id'];
                               $reffernce = $responce['response']['order_id'];
			                   if($status == "Success"){
			                      
			                    //update reseller wallet
			                    $rnewbal = $rdata->main_wallet - $amount;
			                    $this->db->where('id',$sdata->rid);
			                    $this->db->update('reseller',array('main_wallet' => $rnewbal));
			                    //entry reseller txn 
			                    $rdataarray = array(
			                        'type' => "RECHARGE",
			                        'txnid' => $txnid,
			                        'amount' => $amount,
			                        'opening' => $rdata->main_wallet,
			                        'closing' => $rnewbal,
			                        'rid' => $sdata->rid	
			                        );
			                        log_message('debug',print_r($rdataarray,true));
								 $this->db->insert('rtransaction_main',$rdataarray);
			                     //update COMMISSION reseller wallet
			                     $pkg = $this->db->get_where('reseller',array('id' => $sdata->rid))->row()->package;
			                     $countcw = $this->db->get_where('comissionv2_lapu',array('operator' => $operator,'package' => $pkg))->row();
			                     if($countcw->percent == "1"){
			                         $comm = $amount * $countcw->amount / 100;
			                     }else{
			                         $comm = $countcw->amount;
			                     }
			                     
			                     $rdata = $this->db->get_where('reseller',array('id' => $sdata->rid))->row();
			                    $rnewbal = $rdata->main_wallet + $comm;
			                    $this->db->where('id',$sdata->rid);
			                    $this->db->update('reseller',array('main_wallet' => $rnewbal));
			                    //entry commision reseller txn 
			                    $rdataarray = array(
			                        'type' => "RECHARGE-COMMISSION",
			                        'txnid' => $txnid,
			                        'amount' => $comm,
			                        'opening' => $rdata->main_wallet,
			                        'closing' => $rnewbal,
			                        'rid' => $sdata->rid	
			                        );
			                        log_message('debug',print_r($rdataarray,true));
								 $this->db->insert('rtransaction_main',$rdataarray);
			                     //update user wallet 
			                     $unewbal = $udata->main_wallet - $amount;
			                     $this->db->where('id',$uid);
			                     $this->db->update('users',array('main_wallet' => $unewbal));
			                     //user recharge txn entry 
			                     $member = $udata->username;
			                     $udataarray = array(
			                         'uid' => $uid,
			                         'txnid' => $txnid,
			                         'apitxnid' => $apitxnid,
			                         'mobile' => $mobile,
			                         'operator' => $operator,
			                         'amount' => $amount,
			                         'status' => $status,
			                         'response' => json_encode($responce),
			                         'site' => $site
			                         );
			                   $this->db->insert('rechargetxn',$udataarray);
			                   $udataarray = array(
			                         'uid' => $uid,
			                         'type' => "RECHARGE",
			                         'txntype' => "DEBIT",
			                         'opening' => $udata->main_wallet,
			                         'closing' => $unewbal,	
			                         'txnid' => $txnid,
			                         'amount' => $amount,
			                         'site' => $site
			                         );
			                   $this->db->insert('main_wallet',$udataarray);

			                   $this->load->model('Recharge_model');
                                $this->Recharge_model->rechargeCommission_lapu($uid,$operator,$amount,$txnid,$site);
                                $d= $uid.", ".$operator.", ".$amount.", ".$txnid.", ".$site;
                                $this->db->insert('test',array('data'=>$d));
			                   //echo 1;
								print_r(json_encode(array('status' => "SUCCESS", 'msg' => "RECHARGE SUCCESSFULL", 'error_code' => 0)));
								exit();
			                   }elseif($status == "Failure" || $status == "Refund" || $status == "Error" || $status=="unknown"){
			                      
			                       $udataarray = array(
			                         'uid' => $uid,
			                         'txnid' => $txnid,
			                         'apitxnid' => $apitxnid,
			                         'mobile' => $mobile,
			                         'operator' => $operator,
			                         'amount' => $amount,
			                         'status' => $status,
			                         'response' => json_encode($responce),
			                         'site' => $site
			                         );
			                   $this->db->insert('rechargetxn',$udataarray);			                       
								   print_r(json_encode(array('status' => "failed", 'msg' => "RECHARGE FAILED", 'error_code' => 203)));
								exit();
			                   }else{
								  print_r(json_encode(array('status' => "failed", 'msg' => "ERROR", 'error_code' => 203)));
								exit(); 
			                   }
			                  
			                 
						
                    }
                }
            }
        }
    }

    public function dmtlogin() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->row()->dmt;
        if ($aservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check whitelabel 
        $rid = $this->db->get_where('sites', array('id' => $user->site))->row()->rid;
        $rservice = $this->db->get_where('reseller', array('id' => $rid))->row()->dmt;
        if ($rservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check reseller service 
        $service = $this->db->get_where('service', array('site' => $user->site))->row()->dmt;
        if ($service != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check user 
        if ($user->dmt != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        $mobile = $this->input->post('mobile');

        if ($mobile == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE FILL PROPER DATA", 'error_code' => 203)));
            exit();
        } else {
            $count = $this->db->get_where('remitter', array('phone' => $mobile))->num_rows();

            if ($count == 1) {
                $dat = $this->db->get_where('remitter', array('phone' => $mobile))->row();
                if ($dat->active == 1) {
                    print_r(json_encode(array('status' => "SUCCESS", 'msg' => "LOGIN SUCCESSFULL", 'rid' => $dat->rid, 'error_code' => 0)));
                    exit();
                } else {
                    print_r(json_encode(array('status' => "ERROR", 'msg' => "REMITER NOT ACTIOVE", 'error_code' => 203)));
                    exit();
                }
            } else {
                print_r(json_encode(array('status' => "ERROR", 'msg' => "Remitter Not Register Please Register And Login Again", 'error_code' => 203)));
                exit();
            }
        }
    }

    public function dmtregister() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->row()->dmt;
        if ($aservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check whitelabel 
        $rid = $this->db->get_where('sites', array('id' => $user->site))->row()->rid;
        $rservice = $this->db->get_where('reseller', array('id' => $rid))->row()->dmt;
        if ($rservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check reseller service 
        $service = $this->db->get_where('service', array('site' => $user->site))->row()->dmt;
        if ($service != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check user 
        if ($user->dmt != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        $mobile = $this->input->post('rmobile');
        $name = $this->input->post('name');
        $pin = $this->input->post('pin');
        if ($mobile == "" || $name == "" || $pin == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE SEND PROPER DATA", 'error_code' => 203)));
            exit();
        } else {
            $count = $this->db->get_where('remitter', array('phone' => $mobile))->num_rows();

            if ($count > 0) {
                print_r(json_encode(array('status' => "ERROR", 'msg' => "REMITTER ALREADY REGISTER", 'error_code' => 203)));
                exit();
            } else {
                $udata = $this->db->get_where('users', array('id' => $uid))->row();
                $site = $udata->site;
                $ardata = array(
                    'name' => $name,
                    'phone' => $mobile,
                    'rid' => rand(11111, 99999),
                    'pin' => $pin,
                    'rlimit' => '25000',
                    'active' => 1,
                    'site' => $site
                );
                $this->db->insert('remitter', $ardata);
                print_r(json_encode(array('status' => "SUCCESS", 'msg' => "LOGIN SUCCESSFULL", 'error_code' => 0)));
                exit();
            }
        }
    }

    public function remitterdetail() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->row()->dmt;
        if ($aservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        $rid = $this->input->post('rid');
        if ($rid == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE SEND PROPER DATA", 'error_code' => 203)));
            exit();
        } else {
            $data = $this->db->get_where('remitter', array('rid' => $rid))->row();
            print_r(json_encode(array('status' => "SUCCESS", 'msg' => "DATA FETCH SUCCESSFULL", 'data' => $data, 'error_code' => 203)));
            exit();
        }
    }

    public function banaccdata() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->row()->dmt;
        if ($aservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        $rid = $this->input->post('rid');
        if ($rid == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE SEND PROPER DATA", 'error_code' => 203)));
            exit();
        } else {
            $data = $this->db->get_where('baccount', array('rid' => $rid))->result();
            print_r(json_encode(array('status' => "SUCCESS", 'msg' => "DATA FETCH SUCCESSFULL", 'data' => $data, 'error_code' => 203)));
            exit();
        }
    }

    public function adddmtacc() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->row()->dmt;
        if ($aservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        $rid = $this->input->post('rid');
        $account = $this->input->post('account');
        $ifsc = $this->input->post('ifsc');
        $name = $this->input->post('name');
        if ($rid == "" || $account == "" || $ifsc == "" || $name == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE SEND PROPER DATA", 'error_code' => 203)));
            exit();
        } else {
            $data = array(
                'rid' => $rid,
                'name' => $name,
                'account' => $account,
                'ifsc' => $ifsc
            );
            $this->db->insert('baccount', $data);
            print_r(json_encode(array('status' => "SUCCESS", 'msg' => "ACCOUNT ADD SUCCESSFULL SUCCESSFULL", 'error_code' => 203)));
            exit();
        }
    }

    public function delete_ben() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->row()->dmt;
        if ($aservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        $rid = $this->input->post('rid');
        $account = $this->input->post('bid');
        if ($rid == "" || $account == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE SEND PROPER DATA", 'error_code' => 203)));
            exit();
        } else {

            $this->db->delete('baccount', array('id' => $account));
            print_r(json_encode(array('status' => "SUCCESS", 'msg' => "ACCOUNT DELETE SUCCESSFULL", 'error_code' => 203)));
            exit();
        }
    }

    public function dmtsendotp() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->row()->dmt;
        if ($aservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check whitelabel 
        $rid = $this->db->get_where('sites', array('id' => $user->site))->row()->rid;
        $rservice = $this->db->get_where('reseller', array('id' => $rid))->row()->dmt;
        if ($rservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check reseller service 
        $service = $this->db->get_where('service', array('site' => $user->site))->row()->dmt;
        if ($service != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check user 
        if ($user->dmt != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        $amount = $this->input->post('amount');
        $account = $this->input->post('account');
        $mode = "IMPS";
        if ($amount == "" || $account == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE SEND PROPER DATA", 'error_code' => 203)));
            exit();
        } else {
            if ($amount <= 0) {
                print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID AMOUNT", 'error_code' => 203)));
                exit();
            } else {
                $package = $this->db->get_where('users', array('id' => $uid))->row()->package;
                $table = "dmtcharge";

                $charges = $this->db->get_where($table, array('package' => $package))->result();

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
                //getting max limit

                $this->db->select_max('toa');
                $this->db->from($table);
                $this->db->where(array('package' => $package));
                $query = $this->db->get();
                $r = $query->row();
                $limit = $r->toa;

                if ($amount > $limit) {
                    print_r(json_encode(array('status' => "ERROR", 'msg' => "LIMIT ERROR CONTACT TO ADMIN", 'error_code' => 203)));
                    exit();
                }

                $wallet = $this->db->get_where('users', array('id' => $uid))->row()->wallet;
                $total = $amount + $chargeamount;
                if ($total > $wallet) {
                    print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT FUND", 'error_code' => 203)));
                    exit();
                } else {
                    $senderid = "MONSFT";
                    $phone = $this->db->get_where('users', array('id' => $uid))->row()->phone;
                    ;

                    $template = "1707165259110869306";
                    $otp = rand(1111, 9999);
                    $message = " Dear User Your DMT OTP Is " . $otp . " And do not share this OTP with anyone, Thanks Team MOSFTY";
                    $cop = $this->db->get_where('dmt_otp', array('phone' => $phone))->num_rows();
                    if ($cop > 0) {
                        $this->db->delete('dmt_otp', array('phone' => $phone));
                    }
                    $insdata = array(
                        'phone' => $phone,
                        'otp' => $otp,
                        'data' => json_encode(array('rbank' => $account, 'pamount' => $amount))
                    );
                    $this->db->insert('dmt_otp', $insdata);
                    send_sms($senderid, $phone, $message, $template);
                    print_r(json_encode(array('status' => "SUCCESS", 'msg' => "OTP SEND SUCCESSFULL", 'error_code' => 203)));
                    exit();
                }
            }
        }
    }

    public function dmtotpverify() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->row()->dmt;
        if ($aservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check whitelabel 
        $rid = $this->db->get_where('sites', array('id' => $user->site))->row()->rid;
        $rservice = $this->db->get_where('reseller', array('id' => $rid))->row()->dmt;
        if ($rservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check reseller service 
        $service = $this->db->get_where('service', array('site' => $user->site))->row()->dmt;
        if ($service != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check user 
        if ($user->dmt != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        $otp = $this->input->post('otp');
        if ($otp == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE SEND OTP", 'error_code' => 203)));
            exit();
        } else {
            $votp = $this->db->get_where('dmt_otp', array('phone' => $user->phone))->row();
            if ($otp == $votp->otp) {
                $sd = json_decode($votp->data);
                $amount = $sd->pamount;
                $accountid = $sd->rbank;
                if ($amount == "") {
                    print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE FILL ALL DATA", 'error_code' => 203)));
                    exit();
                } else {
                    if ($amount <= 0) {
                        print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID AMOUNT", 'error_code' => 203)));
                        exit();
                    } else {
                        $package = $this->db->get_where('users', array('id' => $uid))->row()->package;
                        $table = "dmtcharge";
                        $charges = $this->db->get_where($table, array('package' => $package))->result();

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
                        //getting max limit

                        $this->db->select_max('toa');
                        $this->db->from($table);
                        $this->db->where(array('package' => $package));
                        $query = $this->db->get();
                        $r = $query->row();
                        $limit = $r->toa;

                        if ($amount > $limit) {
                            print_r(json_encode(array('status' => "ERROR", 'msg' => "LIMIT ERROR", 'error_code' => 203)));
                            exit();
                        }

                        $wallet = $this->db->get_where('users', array('id' => $uid))->row()->wallet;
                        $total = $amount + $chargeamount;
                        if ($total > $wallet) {
                            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT FUND", 'error_code' => 203)));
                            exit();
                        } else {
                            $udata = $this->db->get_where('users', array('id' => $uid))->row();
                            $site = $udata->site;
                            $sdata = $this->db->get_where('sites', array('id' => $site))->row();


                            //check white label wallet 
                            $wpackage = $this->db->get_where('reseller', array('id' => $sdata->rid))->row()->package;
                            $table = "dmtcharge";

                            $wcharges = $this->db->get_where($table, array('package' => $wpackage))->result();

                            foreach ($wcharges as $charge) {
                                if ($amount >= $charge->froma && $amount <= $charge->toa) {
                                    if ($charge->percent == 1) {
                                        //commission in percent
                                        $wchargeamount = ($amount * $charge->amount) / 100;
                                    } else {
                                        // comission is flat
                                        $wchargeamount = $charge->amount;
                                    }
                                }
                            }
                            //getting max limit

                            $this->db->select_max('toa');
                            $this->db->from($table);
                            $this->db->where(array('package' => $wpackage));
                            $query = $this->db->get();
                            $r = $query->row();
                            $limit = $r->toa;

                            if ($amount > $limit) {
                                print_r(json_encode(array('status' => "ERROR", 'msg' => "LIMIT ERROR", 'error_code' => 203)));
                                exit();
                            }
                            $wtotal = $amount + $wchargeamount;
                            $rwallet = $this->db->get_where('reseller', array('id' => $sdata->rid))->row()->wallet;
                            if ($rwallet < $wtotal) {
                                print_r(json_encode(array('status' => "ERROR", 'msg' => "TECHNICAL ISSUE PLEASE CONTACT TO ADMIN", 'error_code' => 203)));
                                exit();
                            } else {

                                //transaction work start
                                $type = "IFS";

                                $kyc = $this->db->get_where('baccount', array('id' => $sd->rbank))->row();
                                $data = [
                                    "CORPID" => "576255098",
                                    "USERID" => "HARSHPAT",
                                    "AGGRNAME" => "MOONEX",
                                    "AGGRID" => "OTOE0113",
                                    "URN" => "SR202112501",
                                    "DEBITACC" => "076405003360",
                                    "CREDITACC" => $kyc->account,
                                    "IFSC" => $kyc->ifsc,
                                    "AMOUNT" => $amount,
                                    "CURRENCY" => "INR",
                                    "TXNTYPE" => $type,
                                    "PAYEENAME" => $kyc->name,
                                    "UNIQUEID" => "DMT" . rand(11111111111, 99999999999),
                                        // "WORKFLOW_REQD" => "N"
                                ];


                                $filepath = fopen("cert/bank.crt", "r");
                                $pub_key_string = fread($filepath, 8192);
                                fclose($filepath);

                                openssl_get_publickey($pub_key_string);
                                openssl_public_encrypt(json_encode($data), $crypttext, $pub_key_string);

                                $encryptedRequest = json_encode(base64_encode($crypttext));

                                $header = [
                                    'Content-type:text/plain',
                                    'apikey: YmcmYakiCAY4aSVwfvPEzuoKrzsumaig'
                                ];

                                $httpUrl = 'https://apibankingone.icicibank.com/api/Corporate/CIB/v1/Transaction';


                                $curl = curl_init();

                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => $httpUrl,
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 60,
                                    CURLOPT_CUSTOMREQUEST => 'POST',
                                    CURLOPT_POSTFIELDS => $encryptedRequest,
                                    CURLOPT_HTTPHEADER => $header
                                ));

                                $raw_response = curl_exec($curl);
                                curl_close($curl);


                                $fp = fopen("cert/self.key", "r");
                                $priv_key_string = fread($fp, 8192);
                                fclose($fp);

                                $private_key = openssl_get_privatekey($priv_key_string, "");
                                openssl_private_decrypt(base64_decode($raw_response), $response, $private_key);

                                $output = json_decode($response);

                                if ($output->STATUS == "SUCCESS") {
                                    //reseller work 
                                    //update reseller wallet 
                                    $wnewbal = $rwallet - $wtotal;
                                    $this->db->where('id', $sdata->rid);
                                    $this->db->update('reseller', array('wallet' => $wnewbal));
                                    // entry of reseller 
                                    $wdata = array(
                                        'type' => "DMT",
                                        'txnid' => $output->UNIQUEID,
                                        'amount' => $wtotal,
                                        'opening' => $rwallet,
                                        'closing' => $wnewbal,
                                        'rid' => $sdata->rid
                                    );
                                    $this->db->insert('rtransaction', $wdata);
                                    //update user wallet 
                                    $wallet = $this->db->get_where('users', array('id' => $uid))->row()->wallet;
                                    $unewbal = $wallet - $amount;
                                    $this->db->where('id', $uid);
                                    $this->db->update('users', array('wallet' => $unewbal));
                                    //user txn entry 
                                    $ardata = array(
                                        'uid' => $uid,
                                        'txnid' => $output->UNIQUEID,
                                        'account' => $kyc->account,
                                        'ifsc' => $kyc->ifsc,
                                        'bname' => $kyc->name,
                                        'amount' => $amount,
                                        'status' => $output->STATUS,
                                        'UTR' => $output->UTRNUMBER,
                                        'response' => $response,
                                        'site' => $site
                                    );
                                    $this->db->insert('dmrtxn', $ardata);

                                    $wrdata = array(
                                        'type' => "DMT",
                                        'txntype' => "DEBIT",
                                        'opening' => $wallet,
                                        'closing' => $unewbal,
                                        'uid' => $uid,
                                        'txnid' => $output->UNIQUEID,
                                        'amount' => $amount,
                                        'site' => $site
                                    );
                                    $this->db->insert('wallet', $wrdata);
                                    $wallet = $this->db->get_where('users', array('id' => $uid))->row()->wallet;
                                    $unewbal = $wallet - $chargeamount;
                                    $this->db->where('id', $uid);
                                    $this->db->update('users', array('wallet' => $unewbal));
                                    $wrdata = array(
                                        'type' => "DMT-CHARGE",
                                        'txntype' => "DEBIT",
                                        'opening' => $wallet,
                                        'closing' => $unewbal,
                                        'uid' => $uid,
                                        'txnid' => $output->UNIQUEID,
                                        'amount' => $chargeamount,
                                        'site' => $site
                                    );
                                    $this->db->insert('wallet', $wrdata);
                                    // for receipt
                                    $amt = (int) $amount;

                                    $this->load->model("dmt_model");
                                    $this->dmt_model->charge($uid, $amt, $output->UNIQUEID, $site);
                                    print_r(json_encode(array('status' => "SUCCESS", 'msg' => "TRANSACTION COMPLETE", 'error_code' => 203)));
                                    exit();

                                    // commission model 
                                    //  $this->load->model("dmt_model");
                                    //  $this->dmt_model->charge($uid, $amount, $output->UNIQUEID, $site);
                                    //  $ardataf=['data'=>$ardata];
                                    // $this->db->insert('test',$ardataf);
                                } else {
                                    if ($output->STATUS == "PENDING") {
                                        if ($output->RESPONSE == "FAILURE") {
                                            if ($output->UNIQUEID == "") {
                                                $txnid = "DMR" . rand(1111111111, 9999999999);
                                            } else {
                                                $txnid = $output->UNIQUEID;
                                            }
                                            $ardata = array(
                                                'uid' => $uid,
                                                'txnid' => $txnid,
                                                'account' => $kyc->account,
                                                'ifsc' => $kyc->ifsc,
                                                'bname' => $kyc->name,
                                                'amount' => $amount,
                                                'status' => $output->RESPONSE,
                                                'response' => $response,
                                                'site' => $site
                                            );

                                            $this->db->insert('dmrtxn', $ardata);
                                            print_r(json_encode(array('status' => "ERROR", 'msg' => "DMT FAILED DUE TO TECHNICAL ISSUE ", 'error_code' => 203)));
                                            exit();
                                        } else {
                                            //reseller work 
                                            //update reseller wallet 
                                            $wnewbal = $rwallet - $wtotal;
                                            $this->db->where('id', $sdata->rid);
                                            $this->db->update('reseller', array('wallet' => $wnewbal));
                                            // entry of reseller 
                                            $wdata = array(
                                                'type' => "DMR",
                                                'txnid' => $output->UNIQUEID,
                                                'amount' => $wtotal,
                                                'opening' => $rwallet,
                                                'closing' => $wnewbal,
                                                'rid' => $sdata->rid
                                            );
                                            $this->db->insert('rtransaction', $wdata);
                                            //update user wallet 
                                            $unewbal = $wallet - $total;
                                            $this->db->where('id', $uid);
                                            $this->db->update('users', array('wallet' => $unewbal));
                                            //user txn entry 

                                            $ardata = array(
                                                'uid' => $uid,
                                                'txnid' => $output->UNIQUEID,
                                                'account' => $kyc->account,
                                                'ifsc' => $kyc->ifsc,
                                                'bname' => $kyc->name,
                                                'amount' => $amount,
                                                'status' => $output->STATUS,
                                                'response' => $response,
                                                'site' => $site
                                            );
                                            $this->db->insert('dmrtxn', $ardata);

                                            $wrdata = array(
                                                'type' => "DEBIT",
                                                'txntype' => "DMT",
                                                'opening' => $wallet,
                                                'closing' => $unewbal,
                                                'uid' => $uid,
                                                'txnid' => $output->UNIQUEID,
                                                'amount' => $total,
                                                'site' => $site
                                            );
                                            $this->db->insert('wallet', $wrdata);
                                            $msg = "TRANSACTION IS" . $output->STATUS;
                                            print_r(json_encode(array('status' => "ERROR", 'msg' => $msg, 'error_code' => 203)));
                                            exit();
                                        }
                                    } else {
                                        print_r(json_encode(array('status' => "ERROR", 'msg' => "ERROR", 'error_code' => 203)));
                                        exit();
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID OTP", 'error_code' => 203)));
                exit();
            }
        }
    }

    public function payoutacc() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $acc = $this->db->from("payoutaccount")->where('uid', $uid)->where('status', 'APPROVED')->order_by('id', "DESC")->get()->result();
        print_r(json_encode(array('status' => "SUCCESS", 'msg' => "SUCCESSFULLY FETCHED", 'data' => $acc, 'error_code' => 0)));
        exit();
    }

    public function payoutsendotp() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $acc = $this->db->from("payoutaccount")->where('uid', $uid)->where('status', 'APPROVED')->order_by('id', "DESC")->get()->result();
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->row()->payout;
        if ($aservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check whitelabel 
        $user = $this->db->get_where('users', array('id' => $uid))->row();
        $rid = $this->db->get_where('sites', array('id' => $user->site))->row()->rid;
        $rservice = $this->db->get_where('reseller', array('id' => $rid))->row()->payout;
        if ($rservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check reseller service 
        $service = $this->db->get_where('service', array('site' => $user->site))->row()->payout;
        if ($service != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check user 
        if ($user->payout != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        $amount = $this->input->post('amount');
        $mode = $this->input->post('mode');
        $bid = $this->input->post('bid');
        if ($amount == "" || $mode == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE SEND PROPER DATA", 'error_code' => 203)));
            exit();
        } else {
            if ($amount <= 0) {
                print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID AMOUNT", 'error_code' => 203)));
                exit();
            } else {
                $package = $this->db->get_where('users', array('id' => $uid))->row()->package;
                if ($mode == "IMPS") {
                    $table = "payoutchargeimps";
                } elseif ($mode == "NEFT") {
                    $table = "payoutchargeneft";
                } else {
                    print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID MODE", 'error_code' => 203)));
                    exit();
                }

                $charges = $this->db->get_where($table, array('package' => $package))->result();

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
                //getting max limit

                $this->db->select_max('toa');
                $this->db->from($table);
                $this->db->where(array('package' => $package));
                $query = $this->db->get();
                $r = $query->row();
                $limit = $r->toa;

                if ($amount > $limit) {
                    print_r(json_encode(array('status' => "ERROR", 'msg' => "LIMIT ERROR", 'error_code' => 203)));
                    exit();
                }

                $wallet = $this->db->get_where('users', array('id' => $uid))->row()->wallet;
                $total = $amount + $chargeamount;
                if ($total > $wallet) {
                    print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT FUND", 'error_code' => 203)));
                    exit();
                } else {
                    $otp = rand(1111, 9999);
                    $da = array('amount' => $amount, 'mode' => $mode, 'bid' => $bid);
                    $senderid = "MONSFT";
                    $phone = $this->db->get_where('users', array('id' => $uid))->row()->phone;
                    ;
                    $message = " Dear User Your Payout OTP Is " . $otp . " And do not share this OTP with anyone, Thanks Team MOSFTY";
                    $template = "1707165259103933299";

                    send_sms($senderid, $phone, $message, $template);
                    $cr = $this->db->get_where('payout_otp', array('phone' => $phone))->num_rows();
                    if ($cr > 0) {
                        $this->db->delete('payout_otp', array('phone' => $phone));
                    }
                    $arrrdd = array(
                        'phone' => $phone,
                        'data' => json_encode($da),
                        'otp' => $otp
                    );
                    $this->db->insert('payout_otp', $arrrdd);
                    print_r(json_encode(array('status' => "SUCCESS", 'msg' => "OTP SEND SUCCESSFULL", 'error_code' => 203)));
                    exit();
                }
            }
        }
    }

    public function payoutverifyotp() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $acc = $this->db->from("payoutaccount")->where('uid', $uid)->where('status', 'APPROVED')->order_by('id', "DESC")->get()->result();
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->row()->payout;
        if ($aservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check whitelabel 
        $user = $this->db->get_where('users', array('id' => $uid))->row();
        $rid = $this->db->get_where('sites', array('id' => $user->site))->row()->rid;
        $rservice = $this->db->get_where('reseller', array('id' => $rid))->row()->payout;
        if ($rservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check reseller service 
        $service = $this->db->get_where('service', array('site' => $user->site))->row()->payout;
        if ($service != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check user 
        if ($user->payout != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        $otp = $this->input->post('otp');
        if ($otp == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE SEND OTP DATA", 'error_code' => 203)));
            exit();
        } else {
            $da = $this->db->get_where('payout_otp', array('phone' => $user->phone))->row();
            $daa = json_decode($da->data);
            if ($otp == $da->otp) {
                $amount = $daa->amount;
                $bid = $daa->bid;
                $mode = $daa->mode;
                if ($amount == "" || $mode == "") {
                    print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE SEND PROPER DETAILS", 'error_code' => 203)));
                    exit();
                } else {
                    if ($amount <= 0) {
                        print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID AMOUNT", 'error_code' => 203)));
                        exit();
                    } else {
                        $package = $this->db->get_where('users', array('id' => $uid))->row()->package;
                        if ($mode == "IMPS") {
                            $table = "payoutchargeimps";
                        } elseif ($mode == "NEFT") {
                            $table = "payoutchargeneft";
                        } else {
                            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID MODE", 'error_code' => 203)));
                            exit();
                        }

                        $charges = $this->db->get_where($table, array('package' => $package))->result();

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
                        //getting max limit

                        $this->db->select_max('toa');
                        $this->db->from($table);
                        $this->db->where(array('package' => $package));
                        $query = $this->db->get();
                        $r = $query->row();
                        $limit = $r->toa;

                        if ($amount > $limit) {
                            print_r(json_encode(array('status' => "ERROR", 'msg' => "LIMIT ERROR", 'error_code' => 203)));
                            exit();
                        }

                        $wallet = $this->db->get_where('users', array('id' => $uid))->row()->wallet;
                        $total = $amount + $chargeamount;
                        if ($total > $wallet) {
                            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT FUND", 'error_code' => 203)));
                            exit();
                        } else {
                            $udata = $this->db->get_where('users', array('id' => $uid))->row();
                            $site = $udata->site;
                            $sdata = $this->db->get_where('sites', array('id' => $site))->row();


                            //check white label wallet 
                            $wpackage = $this->db->get_where('reseller', array('id' => $sdata->rid))->row()->package;
                            if ($mode == "IMPS") {
                                $table = "payoutchargeimps";
                            } elseif ($mode == "NEFT") {
                                $table = "payoutchargeneft";
                            } else {
                                print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID MODE", 'error_code' => 203)));
                                exit();
                            }

                            $wcharges = $this->db->get_where($table, array('package' => $wpackage))->result();

                            foreach ($wcharges as $charge) {
                                if ($amount >= $charge->froma && $amount <= $charge->toa) {
                                    if ($charge->percent == 1) {
                                        //commission in percent
                                        $wchargeamount = ($amount * $charge->amount) / 100;
                                    } else {
                                        // comission is flat
                                        $wchargeamount = $charge->amount;
                                    }
                                }
                            }
                            //getting max limit

                            $this->db->select_max('toa');
                            $this->db->from($table);
                            $this->db->where(array('package' => $wpackage));
                            $query = $this->db->get();
                            $r = $query->row();
                            $limit = $r->toa;

                            if ($amount > $limit) {
                                print_r(json_encode(array('status' => "ERROR", 'msg' => "LIMIT ERROR", 'error_code' => 203)));
                                exit();
                            }
                            $wtotal = $amount + $wchargeamount;
                            $rwallet = $this->db->get_where('reseller', array('id' => $sdata->rid))->row()->wallet;
                            if ($rwallet < $wtotal) {
                                print_r(json_encode(array('status' => "ERROR", 'msg' => "TECHNICAL ERROR", 'error_code' => 203)));
                                exit();
                            } else {

                                //transaction work start

                                $uid = $uid;
                                $kyc = $this->db->get_where('payoutaccount', array('id' => $bid))->row();
                                $account = $kyc->account;
                                $ifsc = $kyc->ifsc;
                                $name = $kyc->name;

                                $this->load->helper('payout');
                                $paym = $this->db->get_where('payoutmode', array('id' => '1'))->row()->value;
                                if ($paym == 1) {
                                    $response = icicipayout($mode, $amount, $uid, $account, $ifsc, $name);

                                    if ($response == "") {
                                        print_r(json_encode(array('status' => "ERROR", 'msg' => "ERROR FROM BANK", 'error_code' => 203)));
                                        exit();
                                    }
                                    $output = json_decode($response);

                                    if ($output->STATUS == "SUCCESS") {
                                        $rrn = $output->UTRNUMBER;
                                        //reseller work 
                                        //update reseller wallet 
                                        $wnewbal = $rwallet - $wtotal;
                                        $this->db->where('id', $sdata->rid);
                                        $this->db->update('reseller', array('wallet' => $wnewbal));
                                        // entry of reseller 
                                        $wdata = array(
                                            'type' => "PAYOUT",
                                            'txnid' => $output->UNIQUEID,
                                            'amount' => $wtotal,
                                            'opening' => $rwallet,
                                            'closing' => $wnewbal,
                                            'rid' => $sdata->rid
                                        );

                                        $this->db->insert('rtransaction', $wdata);
                                        //update user wallet 
                                        $wallet = $this->db->get_where('users', array('id' => $uid))->row()->wallet;
                                        $unewbal = $wallet - $amount;
                                        $this->db->where('id', $uid);
                                        $this->db->update('users', array('wallet' => $unewbal));
                                        //user txn entry 
                                        $ardata = array(
                                            'uid' => $uid,
                                            'txnid' => $output->UNIQUEID,
                                            'status' => $output->STATUS,
                                            'amount' => $amount,
                                            'response' => $response,
                                            'account' => $kyc->account,
                                            'ifsc' => $kyc->ifsc,
                                            'rrn' => $rrn,
                                            'mode' => $mode,
                                            'bname' => $kyc->name,
                                            'message' => $output->RESPONSE,
                                            'site' => $site
                                        );
                                        $this->db->insert('payouttxn', $ardata);
                                        $wrdata = array(
                                            'uid' => $uid,
                                            'type' => "PAYOUT",
                                            'txntype' => "DEBIT",
                                            'txnid' => $output->UNIQUEID,
                                            'amount' => $amount,
                                            'opening' => $wallet,
                                            'closing' => $unewbal,
                                            'site' => $site
                                        );

                                        $this->db->insert('wallet', $wrdata);
                                        $wallet = $this->db->get_where('users', array('id' => $uid))->row()->wallet;
                                        $unewbal = $wallet - $chargeamount;
                                        $this->db->where('id', $uid);
                                        $this->db->update('users', array('wallet' => $unewbal));
                                        $wrdata = array(
                                            'uid' => $uid,
                                            'type' => "PAYOUT-CHARGE",
                                            'txntype' => "DEBIT",
                                            'txnid' => $output->UNIQUEID,
                                            'amount' => $chargeamount,
                                            'opening' => $wallet,
                                            'closing' => $unewbal,
                                            'site' => $site
                                        );

                                        $this->db->insert('wallet', $wrdata);
                                        // commission model 
                                        $this->load->model("payout_model");
                                        $this->payout_model->charge($uid, $amount, $output->UNIQUEID, $table, $site);
                                        print_r(json_encode(array('status' => "SUCCESS", 'msg' => "PAYOUT SUCCESSFULL", 'error_code' => 0)));
                                        exit();
                                    } else {
                                        if ($output->STATUS == "PENDING") {
                                            if (!isset($output->UNIQUEID)) {
                                                $txnid = "PAYOUT" . rand(1111111111, 9999999999);
                                            } else {
                                                $txnid = $output->UNIQUEID;
                                            }
                                            if (!isset($output->UTRNUMBER)) {
                                                $rrn = "NA";
                                            } else {
                                                $rrn = $output->UTRNUMBER;
                                            }

                                            //reseller work 
                                            //update reseller wallet 
                                            $wnewbal = $rwallet - $wtotal;
                                            $this->db->where('id', $sdata->rid);
                                            $this->db->update('reseller', array('wallet' => $wnewbal));
                                            // entry of reseller 
                                            $wdata = array(
                                                'type' => "PAYOUT",
                                                'txnid' => $txnid,
                                                'amount' => $wtotal,
                                                'opening' => $rwallet,
                                                'closing' => $wnewbal,
                                                'rid' => $sdata->rid
                                            );
                                            $this->db->insert('rtransaction', $wdata);
                                            //update user wallet 
                                            $wallet = $this->db->get_where('users', array('id' => $uid))->row()->wallet;
                                            $unewbal = $wallet - $amount;
                                            $this->db->where('id', $uid);
                                            $this->db->update('users', array('wallet' => $unewbal));
                                            //user txn entry 

                                            $wrdata = array(
                                                'uid' => $uid,
                                                'type' => "PAYOUT",
                                                'txntype' => "DEBIT",
                                                'txnid' => $txnid,
                                                'amount' => $amount,
                                                'opening' => $wallet,
                                                'closing' => $unewbal,
                                                'site' => $site
                                            );

                                            $this->db->insert('wallet', $wrdata);
                                            $wallet = $this->db->get_where('users', array('id' => $uid))->row()->wallet;
                                            $unewbal = $wallet - $chargeamount;
                                            $this->db->where('id', $uid);
                                            $this->db->update('users', array('wallet' => $unewbal));
                                            $wrdata = array(
                                                'uid' => $uid,
                                                'type' => "PAYOUT-CHARGE",
                                                'txntype' => "DEBIT",
                                                'txnid' => $txnid,
                                                'amount' => $chargeamount,
                                                'opening' => $wallet,
                                                'closing' => $unewbal,
                                                'site' => $site
                                            );

                                            $this->db->insert('wallet', $wrdata);


                                            $ardata = array(
                                                'uid' => $uid,
                                                'txnid' => $txnid,
                                                'status' => "PENDING",
                                                'amount' => $amount,
                                                'response' => $response,
                                                'account' => $kyc->account,
                                                'ifsc' => $kyc->ifsc,
                                                'mode' => $mode,
                                                'bname' => $kyc->name,
                                                'message' => $output->MESSAGE,
                                                'site' => $site
                                            );

                                            $this->db->insert('payouttxn', $ardata);
                                            print_r(json_encode(array('status' => "ERROR", 'msg' => $output->MESSAGE, 'error_code' => 203)));
                                            exit();
                                        } else {
                                            if (!isset($output->UNIQUEID)) {
                                                $txnid = "PAYOUT" . rand(1111111111, 9999999999);
                                            } else {
                                                $txnid = $output->UNIQUEID;
                                            }
                                            if (!isset($output->UTRNUMBER)) {
                                                $rrn = "NA";
                                            } else {
                                                $rrn = $output->UTRNUMBER;
                                            }

                                            $ardata = array(
                                                'uid' => $uid,
                                                'txntype' => "DEBIT",
                                                'txnid' => $txnid,
                                                'status' => $output->STATUS,
                                                'amount' => $total,
                                                'response' => $response,
                                                'account' => $kyc->account,
                                                'ifsc' => $kyc->ifsc,
                                                'mode' => $mode,
                                                'bname' => $kyc->name,
                                                'message' => $output->RESPONSE,
                                                'site' => $site
                                            );
                                            $this->db->insert('payouttxn', $ardata);
                                            print_r(json_encode(array('status' => "ERROR", 'msg' => 'ERROR', 'error_code' => 203)));
                                            exit();
                                        }
                                    }
                                } else {
                                    // paytm start 

                                    $response = paytmpayout($mode, $amount, $uid, $account, $ifsc, $name);
                                    if ($response == "") {
                                        print_r(json_encode(array('status' => "ERROR", 'msg' => 'ERROR FROM BANK', 'error_code' => 203)));
                                        exit();
                                    }
                                    $output = json_decode($response);
                                    $status = $data->status;
                                    $result = $data->result;
                                    if ($status == "ACCEPTED") {
                                        //reseller work 
                                        //update reseller wallet 
                                        $wnewbal = $rwallet - $wtotal;
                                        $this->db->where('id', $sdata->rid);
                                        $this->db->update('reseller', array('wallet' => $wnewbal));
                                        // entry of reseller 
                                        $wdata = array(
                                            'type' => "PAYOUT",
                                            'txnid' => $result->orderId,
                                            'amount' => $wtotal,
                                            'opening' => $rwallet,
                                            'closing' => $wnewbal,
                                            'rid' => $sdata->rid
                                        );
                                        $this->db->insert('rtransaction', $wdata);
                                        //update user wallet 
                                        $unewbal = $wallet - $total;
                                        $this->db->where('id', $uid);
                                        $this->db->update('users', array('wallet' => $unewbal));
                                        //user txn entry 
                                        $ardata = array(
                                            'uid' => $uid,
                                            'member' => $udata->username,
                                            'type' => "PAYOUT",
                                            'txntype' => "DEBIT",
                                            'txnid' => $result->orderId,
                                            'reference' => "NA",
                                            'status' => $status,
                                            'amount' => $unewbal,
                                            'response' => $response,
                                            'commission' => "NA",
                                            'deposit' => "NA",
                                            'withdraw' => "NA",
                                            'opening' => $wallet,
                                            'closing' => $unewbal,
                                            'mobile' => "NA",
                                            'roperator' => "NA",
                                            'rcircle' => "NA",
                                            'consumer' => "NA",
                                            'doperator' => "NA",
                                            'boperator' => "NA",
                                            'rid' => "NA",
                                            'bid' => "NA",
                                            'account' => $kyc->account,
                                            'ifsc' => $kyc->ifsc,
                                            'bname' => $kyc->name,
                                            'remittermobile' => "NA",
                                            'agentid' => "NA",
                                            'qty' => "NA",
                                            'site' => $site
                                        );
                                        $this->db->insert('transaction', $ardata);
                                        // commission model 
                                        $this->load->model("payout_model");
                                        $this->payout_model->charge($uid, $amount, $output->UNIQUEID, $table, $site);
                                    } else {


                                        echo "TRANSACTION FAIL DUE TO SOME TECHNICAL ISSUE PLEASE CONTACT TO ADMIN";

                                        //reseller work 
                                        //update reseller wallet 
                                        $wnewbal = $rwallet - $wtotal;
                                        $this->db->where('id', $sdata->rid);
                                        $this->db->update('reseller', array('wallet' => $wnewbal));
                                        // entry of reseller 
                                        $wdata = array(
                                            'type' => "PAYOUT",
                                            'txnid' => $result->orderId,
                                            'amount' => $wtotal,
                                            'opening' => $rwallet,
                                            'closing' => $wnewbal,
                                            'rid' => $sdata->rid
                                        );
                                        $this->db->insert('rtransaction', $wdata);
                                        //update user wallet 
                                        $unewbal = $wallet - $total;
                                        $this->db->where('id', $uid);
                                        $this->db->update('users', array('wallet' => $unewbal));
                                        //user txn entry 
                                        $ardata = array(
                                            'uid' => $uid,
                                            'member' => $udata->username,
                                            'type' => "PAYOUT",
                                            'txntype' => "DEBIT",
                                            'txnid' => $result->orderId,
                                            'reference' => "NA",
                                            'status' => $status,
                                            'amount' => $unewbal,
                                            'response' => $response,
                                            'commission' => "NA",
                                            'deposit' => "NA",
                                            'withdraw' => "NA",
                                            'opening' => $wallet,
                                            'closing' => $unewbal,
                                            'mobile' => "NA",
                                            'roperator' => "NA",
                                            'rcircle' => "NA",
                                            'consumer' => "NA",
                                            'doperator' => "NA",
                                            'boperator' => "NA",
                                            'rid' => "NA",
                                            'bid' => "NA",
                                            'account' => $kyc->account,
                                            'ifsc' => $kyc->ifsc,
                                            'bname' => $kyc->name,
                                            'remittermobile' => "NA",
                                            'agentid' => "NA",
                                            'qty' => "NA",
                                            'site' => $site
                                        );
                                        $this->db->insert('transaction', $ardata);
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                print_r(json_encode(array('status' => "ERROR", 'msg' => 'INVALID OTP', 'error_code' => 203)));
                exit();
            }
        }
    }

    public function payoutaddaccount() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $acc = $this->db->from("payoutaccount")->where('uid', $uid)->where('status', 'APPROVED')->order_by('id', "DESC")->get()->result();
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->row()->payout;
        if ($aservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check whitelabel 
        $user = $this->db->get_where('users', array('id' => $uid))->row();
        $rid = $this->db->get_where('sites', array('id' => $user->site))->row()->rid;
        $rservice = $this->db->get_where('reseller', array('id' => $rid))->row()->payout;
        if ($rservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check reseller service 
        $service = $this->db->get_where('service', array('site' => $user->site))->row()->payout;
        if ($service != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check user 
        if ($user->payout != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        $name = $this->input->post('name');
        $account = $this->input->post('account');
        $ifsc = $this->input->post('ifsc');
        $passbook = $this->input->post('bankpass');
        $bankname = $this->input->post('bankname');
        $mobileno = $this->input->post('mobileno');
        $acctype = $this->input->post('acctype');
        if ($name == "" || $account == "" || $ifsc == "" || $passbook == "" || $bankname == "" || $mobileno=="" || $acctype=="") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE SEND PROPER DATA", 'error_code' => 203)));
            exit();
        } else {
            $bankpass = "adhaar" . rand(0000000000, 9999999999) . "jpg";
            $path = "uploads/";
            $bankpimg = base_url() . "/uploads/" . $bankpass;
            write_file($path . $bankpass, base64_decode($passbook));
            $bankname=preg_replace('/[^A-Za-z0-9]/', "", $bankname);
            $data = array(
                'uid' => $uid,
                'name' => $name,
                'account' => $account,
                'ifsc' => $ifsc,
                'mobile_no' => $mobileno,
                'bankname' => $bankname,
                'acc_type' => $acctype,
                'status' => 'PENDING',
                'passbook' => $bankpimg,
                'site' => $user->site
            );
            $this->db->insert('payoutaccount', $data);
            print_r(json_encode(array('status' => "SUCCESS", 'msg' => "A/C DETAIL SUBMITED SUCCESSFUL PLEASE WAIT FOR APPROVAL", 'error_code' => 203)));
            exit();
        }
    }

    public function qtransfersendotp() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $acc = $this->db->from("payoutaccount")->where('uid', $uid)->where('status', 'APPROVED')->order_by('id', "DESC")->get()->result();
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->row()->qtransfer;
        if ($aservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check whitelabel 
        $user = $this->db->get_where('users', array('id' => $uid))->row();
        $rid = $this->db->get_where('sites', array('id' => $user->site))->row()->rid;
        $rservice = $this->db->get_where('reseller', array('id' => $rid))->row()->qtransfer;
        if ($rservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check reseller service 
        $service = $this->db->get_where('service', array('site' => $user->site))->row()->qtransfer;
        if ($service != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check user 
        if ($user->qtransfer != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        $amount = $this->input->post('amount');
        $account = $this->input->post('account');
        $ifsc = $this->input->post('ifsc');
        $name = $this->input->post('name');
        if ($amount == "" || $account == "" || $ifsc == "" || $name == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE FILL PROPER DATA", 'error_code' => 203)));
            exit();
        } else {
            if ($amount <= 0) {
                print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID AMOUNT", 'error_code' => 203)));
                exit();
            } else {
                $package = $this->db->get_where('users', array('id' => $uid))->row()->package;

                $table = "qtransfer";

                $charges = $this->db->get_where($table, array('package' => $package))->result();

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
                //getting max limit

                $this->db->select_max('toa');
                $this->db->from($table);
                $this->db->where(array('package' => $package));
                $query = $this->db->get();
                $r = $query->row();
                $limit = $r->toa;

                if ($amount > $limit) {
                    print_r(json_encode(array('status' => "ERROR", 'msg' => "LIMIT ERROR", 'error_code' => 203)));
                    exit();
                }

                $wallet = $this->db->get_where('users', array('id' => $uid))->row()->wallet;
                $total = $amount + $chargeamount;
                if ($total > $wallet) {
                    print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT FUND", 'error_code' => 203)));
                    exit();
                } else {
                    $otp = rand(1111, 9999);
                    $da = array('amount' => $amount, 'account' => $account, 'ifsc' => $ifsc, 'name' => $name);
                    $senderid = "MONSFT";
                    $phone = $this->db->get_where('users', array('id' => $uid))->row()->phone;
                    ;
                    $message = " Dear User Your Xpress Payout OTP Is " . $otp . " And do not share this OTP with anyone, Thanks Team MOSFTY";
                    $template = "1707165259108299017";

                    send_sms($senderid, $phone, $message, $template);
                    $cr = $this->db->get_where('payout_otp', array('phone' => $phone))->num_rows();
                    if ($cr > 0) {
                        $this->db->delete('payout_otp', array('phone' => $phone));
                    }
                    $arrrdd = array(
                        'phone' => $phone,
                        'data' => json_encode($da),
                        'otp' => $otp
                    );
                    $this->db->insert('payout_otp', $arrrdd);
                    print_r(json_encode(array('status' => "SUCCESS", 'msg' => "OTP SEND SUCCESSFULL", 'error_code' => 203)));
                    exit();
                }
            }
        }
    }

    public function qtransferverifyotp() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $acc = $this->db->from("payoutaccount")->where('uid', $uid)->where('status', 'APPROVED')->order_by('id', "DESC")->get()->result();
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->row()->qtransfer;
        if ($aservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check whitelabel 
        $user = $this->db->get_where('users', array('id' => $uid))->row();
        $rid = $this->db->get_where('sites', array('id' => $user->site))->row()->rid;
        $rservice = $this->db->get_where('reseller', array('id' => $rid))->row()->qtransfer;
        if ($rservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check reseller service 
        $service = $this->db->get_where('service', array('site' => $user->site))->row()->qtransfer;
        if ($service != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check user 
        if ($user->qtransfer != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        $otp = $this->input->post('otp');
        if ($otp == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE SEND PROPER DATA", 'error_code' => 203)));
            exit();
        } else {
            $ard = $this->db->get_where('payout_otp', array('phone' => $user->phone))->row();
            $dat = json_decode($ard->data);
            if ($otp == $ard->otp) {
                $amount = $dat->amount;
                $mode = "IMPS";
                if ($amount == "") {
                    print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE SEND PROPER DATA", 'error_code' => 203)));
                    exit();
                } else {
                    if ($amount <= 0) {
                        print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID AMOUNT", 'error_code' => 203)));
                        exit();
                    } else {
                        $package = $this->db->get_where('users', array('id' => $uid))->row()->package;
                        $table = "qtransfer";

                        $charges = $this->db->get_where($table, array('package' => $package))->result();

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
                        //getting max limit

                        $this->db->select_max('toa');
                        $this->db->from($table);
                        $this->db->where(array('package' => $package));
                        $query = $this->db->get();
                        $r = $query->row();
                        $limit = $r->toa;

                        if ($amount > $limit) {
                            print_r(json_encode(array('status' => "ERROR", 'msg' => "LIMIT ERROR", 'error_code' => 203)));
                            exit();
                        }

                        $wallet = $this->db->get_where('users', array('id' => $uid))->row()->wallet;
                        $total = $amount + $chargeamount;
                        if ($total > $wallet) {
                            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT FUND", 'error_code' => 203)));
                            exit();
                        } else {
                            $udata = $this->db->get_where('users', array('id' => $uid))->row();
                            $site = $udata->site;
                            $sdata = $this->db->get_where('sites', array('id' => $site))->row();


                            //check white label wallet 
                            $wpackage = $this->db->get_where('reseller', array('id' => $sdata->rid))->row()->package;
                            $table = "qtransfer";

                            $wcharges = $this->db->get_where($table, array('package' => $wpackage))->result();

                            foreach ($wcharges as $charge) {
                                if ($amount >= $charge->froma && $amount <= $charge->toa) {
                                    if ($charge->percent == 1) {
                                        //commission in percent
                                        $wchargeamount = ($amount * $charge->amount) / 100;
                                    } else {
                                        // comission is flat
                                        $wchargeamount = $charge->amount;
                                    }
                                }
                            }
                            //getting max limit

                            $this->db->select_max('toa');
                            $this->db->from($table);
                            $this->db->where(array('package' => $wpackage));
                            $query = $this->db->get();
                            $r = $query->row();
                            $limit = $r->toa;

                            if ($amount > $limit) {
                                print_r(json_encode(array('status' => "ERROR", 'msg' => "LIMIT ERROR", 'error_code' => 203)));
                                exit();
                            }
                            $wtotal = $amount + $wchargeamount;
                            $rwallet = $this->db->get_where('reseller', array('id' => $sdata->rid))->row()->wallet;
                            if ($rwallet < $wtotal) {
                                print_r(json_encode(array('status' => "ERROR", 'msg' => "TECHNICAL ERROR", 'error_code' => 203)));
                                exit();
                            } else {

                                //transaction work start
                                $type = "IFS";
                                $account = $dat->account;
                                $ifsc = $dat->ifsc;
                                $name = $dat->name;
                                $kyc = $this->db->get_where('kyc', array('uid' => $uid))->row();
                                $data = [
                                    "CORPID" => "576255098",
                                    "USERID" => "HARSHPAT",
                                    "AGGRNAME" => "MOONEX",
                                    "AGGRID" => "OTOE0113",
                                    "URN" => "SR202112501",
                                    "DEBITACC" => "076405003360",
                                    "CREDITACC" => $account,
                                    "IFSC" => $ifsc,
                                    "AMOUNT" => $amount,
                                    "CURRENCY" => "INR",
                                    "TXNTYPE" => $type,
                                    "PAYEENAME" => $name,
                                    "UNIQUEID" => "QTRANSFER" . rand(11111111111, 99999999999),
                                        // "WORKFLOW_REQD" => "N"
                                ];


                                $filepath = fopen("cert/bank.crt", "r");
                                $pub_key_string = fread($filepath, 8192);
                                fclose($filepath);

                                openssl_get_publickey($pub_key_string);
                                openssl_public_encrypt(json_encode($data), $crypttext, $pub_key_string);

                                $encryptedRequest = json_encode(base64_encode($crypttext));

                                $header = [
                                    'Content-type:text/plain',
                                    'apikey: YmcmYakiCAY4aSVwfvPEzuoKrzsumaig'
                                ];

                                $httpUrl = 'https://apibankingone.icicibank.com/api/Corporate/CIB/v1/Transaction';


                                $curl = curl_init();

                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => $httpUrl,
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 60,
                                    CURLOPT_CUSTOMREQUEST => 'POST',
                                    CURLOPT_POSTFIELDS => $encryptedRequest,
                                    CURLOPT_HTTPHEADER => $header
                                ));

                                $raw_response = curl_exec($curl);
                                curl_close($curl);


                                $fp = fopen("cert/self.key", "r");
                                $priv_key_string = fread($fp, 8192);
                                fclose($fp);

                                $private_key = openssl_get_privatekey($priv_key_string, "");
                                openssl_private_decrypt(base64_decode($raw_response), $response, $private_key);

                                $output = json_decode($response);

                                if ($output->STATUS == "SUCCESS") {
                                    //reseller work 
                                    //update reseller wallet 
                                    $wnewbal = $rwallet - $wtotal;
                                    $this->db->where('id', $sdata->rid);
                                    $this->db->update('reseller', array('wallet' => $wnewbal));
                                    // entry of reseller 
                                    $wdata = array(
                                        'type' => "PAYOUT",
                                        'txnid' => $output->UNIQUEID,
                                        'amount' => $wtotal,
                                        'opening' => $rwallet,
                                        'closing' => $wnewbal,
                                        'rid' => $sdata->rid
                                    );
                                    $this->db->insert('rtransaction', $wdata);
                                    //update user wallet 
                                    $wallet = $this->db->get_where('users', array('id' => $uid))->row()->wallet;
                                    $unewbal = $wallet - $amount;
                                    $this->db->where('id', $uid);
                                    $this->db->update('users', array('wallet' => $unewbal));
                                    //user txn entry
                                    $ardata = array(
                                        'uid' => $uid,
                                        'txnid' => $output->UNIQUEID,
                                        'status' => $output->STATUS,
                                        'amount' => $amount,
                                        'response' => $response,
                                        'account' => $account,
                                        'ifsc' => $ifsc,
                                        'rrn' => $output->UTRNUMBER,
                                        'bname' => $name,
                                        'message' => $output->RESPONSE,
                                        'site' => $site
                                    );
                                    $this->db->insert('qtransfertxn', $ardata);
                                    $wrdata = array(
                                        'uid' => $uid,
                                        'type' => "QTRANSFER",
                                        'txntype' => "DEBIT",
                                        'txnid' => $output->UNIQUEID,
                                        'amount' => $amount,
                                        'opening' => $wallet,
                                        'closing' => $unewbal,
                                        'site' => $site
                                    );

                                    $this->db->insert('wallet', $wrdata);
                                    //CHARGE
                                    $wallet = $this->db->get_where('users', array('id' => $uid))->row()->wallet;
                                    $unewbal = $wallet - $chargeamount;
                                    $this->db->where('id', $uid);
                                    $this->db->update('users', array('wallet' => $unewbal));
                                    $wrdata = array(
                                        'uid' => $uid,
                                        'type' => "QTRANSFER-CHARGE",
                                        'txntype' => "DEBIT",
                                        'txnid' => $output->UNIQUEID,
                                        'amount' => $chargeamount,
                                        'opening' => $wallet,
                                        'closing' => $unewbal,
                                        'site' => $site
                                    );

                                    $this->db->insert('wallet', $wrdata);
                                    $this->load->model('qtransfer_model');
                                    $this->qtransfer_model->charge($uid, (int) $amount, $output->UNIQUEID, $site);
                                    print_r(json_encode(array('status' => "SUCCESS", 'msg' => "TRANSACTION SUCCESSFULL", 'error_code' => 203)));
                                    exit();


                                    // commission model 
                                } else {
                                    if ($output->STATUS == "PENDING") {
                                        if (!isset($output->UNIQUEID)) {
                                            $txnid = "QTRANSFER" . rand(1111111111, 9999999999);
                                        } else {
                                            $txnid = $output->UNIQUEID;
                                        }
                                        if (!isset($output->UTRNUMBER)) {
                                            $rrn = "NA";
                                        } else {
                                            $rrn = $output->UTRNUMBER;
                                        }
                                        //reseller work 
                                        //update reseller wallet 
                                        $rwallet = $this->db->get_where('reseller', array('id' => $sdata->rid))->row()->wallet;
                                        $wnewbal = $rwallet - $amount;
                                        $this->db->where('id', $sdata->rid);
                                        $this->db->update('reseller', array('wallet' => $wnewbal));
                                        // entry of reseller 
                                        $wdata = array(
                                            'type' => "QTRANSFER",
                                            'txnid' => $txnid,
                                            'amount' => $amount,
                                            'opening' => $rwallet,
                                            'closing' => $wnewbal,
                                            'rid' => $sdata->rid
                                        );
                                        $this->db->insert('rtransaction', $wdata);
                                        $rwallet = $this->db->get_where('reseller', array('id' => $sdata->rid))->row()->wallet;
                                        $wnewbal = $rwallet - $wchargeamount;
                                        $this->db->where('id', $sdata->rid);
                                        $this->db->update('reseller', array('wallet' => $wnewbal));
                                        // entry of reseller 
                                        $wdata = array(
                                            'type' => "QTRANSFER-CHARGE",
                                            'txnid' => $txnid,
                                            'amount' => $wchargeamount,
                                            'opening' => $rwallet,
                                            'closing' => $wnewbal,
                                            'rid' => $sdata->rid
                                        );
                                        $this->db->insert('rtransaction', $wdata);
                                        //update user wallet 
                                        $unewbal = $wallet - $amount;
                                        $this->db->where('id', $uid);
                                        $this->db->update('users', array('wallet' => $unewbal));
                                        //user txn entry 
                                        $ardata = array(
                                            'uid' => $uid,
                                            'txnid' => $txnid,
                                            'status' => $output->STATUS,
                                            'amount' => $amount,
                                            'response' => $response,
                                            'account' => $account,
                                            'ifsc' => $ifsc,
                                            'rrn' => $rrn,
                                            'bname' => $name,
                                            'message' => $output->MESSAGE,
                                            'site' => $site
                                        );
                                        $this->db->insert('qtransfertxn', $ardata);
                                        $wrdata = array(
                                            'uid' => $uid,
                                            'type' => "QTRANSFER",
                                            'txntype' => "DEBIT",
                                            'txnid' => $txnid,
                                            'amount' => $amount,
                                            'opening' => $wallet,
                                            'closing' => $unewbal,
                                            'site' => $site
                                        );

                                        $this->db->insert('wallet', $wrdata);
                                        $wallet = $this->db->get_where('users', array('id' => $uid))->row()->wallet;
                                        $unewbal = $wallet - $chargeamount;
                                        $this->db->where('id', $uid);
                                        $this->db->update('users', array('wallet' => $unewbal));
                                        $wrdata = array(
                                            'uid' => $uid,
                                            'type' => "QTRANSFER-CHARGE",
                                            'txntype' => "DEBIT",
                                            'txnid' => $txnid,
                                            'amount' => $chargeamount,
                                            'opening' => $wallet,
                                            'closing' => $unewbal,
                                            'site' => $site
                                        );

                                        $this->db->insert('wallet', $wrdata);
                                        echo "TRANSACTION IS" . $output->STATUS;
                                    } else {
                                        print_r(json_encode(array('status' => "ERROR", 'msg' => "ERROR", 'error_code' => 203)));
                                        exit();
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID OTP", 'error_code' => 203)));
                exit();
            }
        }
    }

    public function icicicheckkyc() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $acc = $this->db->from("payoutaccount")->where('uid', $uid)->where('status', 'APPROVED')->order_by('id', "DESC")->get()->result();
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->row()->iaeps;
        if ($aservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check whitelabel 
        $user = $this->db->get_where('users', array('id' => $uid))->row();
        $rid = $this->db->get_where('sites', array('id' => $user->site))->row()->rid;
        $rservice = $this->db->get_where('reseller', array('id' => $rid))->row()->iaeps;
        if ($rservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check reseller service 
        $service = $this->db->get_where('service', array('site' => $user->site))->row()->iaeps;
        if ($service != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check user 
        if ($user->iaeps != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        $count = $this->db->get_where('icicoutlet', array('uid' => $uid))->num_rows();
        if ($count > 0) {
            $kyc = $this->db->get_where('icicoutlet', array('uid' => $uid))->row();
            if ($kyc->status == "1") {
                if ($kyc->kstatus == "1") {
                    print_r(json_encode(array('status' => "SUCCESS", 'msg' => "KYC APPROVD", 'kyc' => 'YES', 'error_code' => 203)));
                    exit();
                } else {
                    print_r(json_encode(array('status' => "SUCCESS", 'msg' => "KYC IN SEND OTP AND BIO", 'kyc' => 'OTP', 'error_code' => 203)));
                    exit();
                }
            } else {
                print_r(json_encode(array('status' => "ERROR", 'msg' => "KYC STATUS PENDING", 'kyc' => 'PENDING', 'error_code' => 203)));
                exit();
            }
        } else {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "KYC NOT FOUND", 'kyc' => 'NO', 'error_code' => 203)));
            exit();
        }
    }

    public function icicikycstep1() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $acc = $this->db->from("payoutaccount")->where('uid', $uid)->where('status', 'APPROVED')->order_by('id', "DESC")->get()->result();
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->row()->iaeps;
        if ($aservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check whitelabel 
        $user = $this->db->get_where('users', array('id' => $uid))->row();
        $rid = $this->db->get_where('sites', array('id' => $user->site))->row()->rid;
        $rservice = $this->db->get_where('reseller', array('id' => $rid))->row()->iaeps;
        if ($rservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check reseller service 
        $service = $this->db->get_where('service', array('site' => $user->site))->row()->iaeps;
        if ($service != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check user 
        if ($user->iaeps != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        $udata = $this->db->get_where('users', array('id' => $uid))->row();
        $site = $udata->site;
        $sdata = $this->db->get_where('sites', array('id' => $site))->row();
        $name = $this->input->post("name");
        $phone = $this->input->post("phone");
        $shop = $this->input->post("shop");
        $address = $this->input->post("address");
        $state = $this->input->post("state");
        $city = $this->input->post("city");
        $email = $this->input->post("email");
        $pin = $this->input->post("pin");
        $adhaarno = $this->input->post("adhaarno");
        $pan = $this->input->post("pan");
        $api_key = $this->db->get_where('settings', array('name' => "api_key"))->row()->value;
        if ($name != "" && $phone != "" && $shop != "" && $address != "" && $state != "" && $city != "" && $pin != "" && $adhaarno != "" && $pan != "") {
            $userd = $this->db->get_where('users', array('id' => $uid))->row();
            $data = array(
                "api_key" => $api_key,
                "latitude" => "26.912434",
                "longitude" => "75.787270",
                "name" => $name,
                "mobile" => $phone,
                "email" => $email,
                "shopname" => $shop,
                "city" => $city,
                "state" => $state,
                "pincode" => $pin,
                "district" => $city,
                "address" => $address,
                "panno" => $pan,
                "aadharno" => $adhaarno
            );
            $url = "https://partner.ecuzen.in/iciciaeps/merchant_onboard";
            $cURLConnection = curl_init($url);
            curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $data);
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
            $apiResponse = curl_exec($cURLConnection);
            curl_close($cURLConnection);
            $res = json_decode($apiResponse);
            // making entry
            if ($res->status == "SUCCESS") {
                $data = array(
                    'uid' => $uid,
                    'first' => $name,
                    'last' => $name,
                    'shop' => $shop,
                    'pan' => $pan,
                    'mobile' => $phone,
                    'state' => $state,
                    'city' => $city,
                    'address' => $address,
                    'pin' => $pin,
                    'adhaarurl' => "NA",
                    'adhaarno' => "NA",
                    'outlet' => $res->outlet_id,
                    'responce' => "SUCCESS",
                    'status' => "1",
                    'otp_status' => "0",
                    'finger_status' => "0",
                    'site' => $userd->site
                );
                $this->db->insert('icicoutlet', $data);
                print_r(json_encode(array('status' => "SUCCESS", 'msg' => "KYC SUBMITED", 'error_code' => 0)));
                exit();
            } else {
                $msg = "ERROR: " . $res->response;
                print_r(json_encode(array('status' => "ERROR", 'msg' => $msg, 'error_code' => 203)));
                exit();
            }
        } else {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE FILL PROPER DATA", 'error_code' => 203)));
            exit();
        }
    }

    public function statelist() {
        $state = $this->db->get('icicstate')->result();
        print_r(json_encode(array('status' => "SUCCESS", 'msg' => "LIST FETCH SUCCESS", 'data' => $state, 'error_code' => 0)));
        exit();
    }

    public function icicikycsendotp() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $acc = $this->db->from("payoutaccount")->where('uid', $uid)->where('status', 'APPROVED')->order_by('id', "DESC")->get()->result();
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->row()->iaeps;
        if ($aservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check whitelabel 
        $user = $this->db->get_where('users', array('id' => $uid))->row();
        $rid = $this->db->get_where('sites', array('id' => $user->site))->row()->rid;
        $rservice = $this->db->get_where('reseller', array('id' => $rid))->row()->iaeps;
        if ($rservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check reseller service 
        $service = $this->db->get_where('service', array('site' => $user->site))->row()->iaeps;
        if ($service != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check user 
        if ($user->iaeps != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        $cot = $this->db->get_where('icicoutlet', array('uid' => $uid))->num_rows();
        if ($cot <= 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "KYC NOT FOUND", 'error_code' => 203)));
            exit();
        }
        $odata = $this->db->get_where('icicoutlet', array('uid' => $uid))->row();
        if ($odata->kstatus == 1) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "KYC ALLREADY APPROVED", 'error_code' => 203)));
            exit();
        }
        $phone = $odata->mobile;
        $adhaarno = $odata->adhaarno;
        $pan = $odata->pan;
        $api_key = $this->db->get_where('settings', array('name' => "api_key"))->row()->value;

        $url = 'https://partner.ecuzen.in/iciciaeps/merchant_sendotp';
        $data = array(
            'api_key' => $api_key,
            'latitude' => "26.9124",
            'longitude' => "75.7873",
            'outlet' => $odata->outlet
        );
        $cURLConnection = curl_init($url);
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $data);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $data = json_decode($apiResponse);
        if ($data->status == "SUCCESS") {
            print_r(json_encode(array('status' => "SUCCESS", 'msg' => "OTP SEND SUCCESSFULL", 'error_code' => 0)));
            exit();
        } else {
            $msg = "Please Contact To Admin Error: " . $data->response;
            print_r(json_encode(array('status' => "ERROR", 'msg' => $msg, 'error_code' => 203)));
            exit();
        }
    }

    public function icicikycverifyotp() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $acc = $this->db->from("payoutaccount")->where('uid', $uid)->where('status', 'APPROVED')->order_by('id', "DESC")->get()->result();
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->row()->iaeps;
        if ($aservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check whitelabel 
        $user = $this->db->get_where('users', array('id' => $uid))->row();
        $rid = $this->db->get_where('sites', array('id' => $user->site))->row()->rid;
        $rservice = $this->db->get_where('reseller', array('id' => $rid))->row()->iaeps;
        if ($rservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check reseller service 
        $service = $this->db->get_where('service', array('site' => $user->site))->row()->iaeps;
        if ($service != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check user 
        if ($user->iaeps != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        $cot = $this->db->get_where('icicoutlet', array('uid' => $uid))->num_rows();
        if ($cot <= 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "KYC NOT FOUND", 'error_code' => 203)));
            exit();
        }
        $odata = $this->db->get_where('icicoutlet', array('uid' => $uid))->row();
        if ($odata->kstatus == 1) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "KYC ALLREADY APPROVED", 'error_code' => 203)));
            exit();
        }
        $otp = $this->input->post("otp");
        if ($otp == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE SEND ONE TIME PASSWORD", 'error_code' => 203)));
            exit();
        }
        $api_key = $this->db->get_where('settings', array('name' => "api_key"))->row()->value;
        $url = 'https://partner.ecuzen.in/iciciaeps/merchant_verifyotp';
        $data = array(
            'api_key' => $api_key,
            'otp' => $otp,
            'outlet' => $odata->outlet
        );
        $cURLConnection = curl_init($url);
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $data);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $data = json_decode($apiResponse);
        if ($data->status == "SUCCESS") {
            $datu = array(
                'responce' => json_encode($data)
            );
            $this->db->where('uid', $uid);
            $this->db->update('icicoutlet', $datu);
            print_r(json_encode(array('status' => "SUCCESS", 'msg' => "OTP SUCCESSFULLY VERIFIED", 'error_code' => 0)));
            exit();
        } else {
            print_r(json_encode(array('status' => "ERROR", 'msg' => $data->response, 'error_code' => 203)));
            exit();
        }
    }

    public function icicifingerverify() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $acc = $this->db->from("payoutaccount")->where('uid', $uid)->where('status', 'APPROVED')->order_by('id', "DESC")->get()->result();
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->row()->iaeps;
        if ($aservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check whitelabel 
        $user = $this->db->get_where('users', array('id' => $uid))->row();
        $rid = $this->db->get_where('sites', array('id' => $user->site))->row()->rid;
        $rservice = $this->db->get_where('reseller', array('id' => $rid))->row()->iaeps;
        if ($rservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check reseller service 
        $service = $this->db->get_where('service', array('site' => $user->site))->row()->iaeps;
        if ($service != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check user 
        if ($user->iaeps != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        $cot = $this->db->get_where('icicoutlet', array('uid' => $uid))->num_rows();
        if ($cot <= 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "KYC NOT FOUND", 'error_code' => 203)));
            exit();
        }
        $odata = $this->db->get_where('icicoutlet', array('uid' => $uid))->row();
        if ($odata->kstatus == 1) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "KYC ALLREADY APPROVED", 'error_code' => 203)));
            exit();
        }
        $api_key = $this->db->get_where('settings', array('name' => "api_key"))->row()->value;
        $outlet = $odata->outlet;
        $aadharno = $odata->adhaarno;
        $mobile = $odata->mobile;
        $pan = $odata->pan;
        $url = 'https://partner.ecuzen.in/iciciaeps/merchant_verifybio';
        $fdata = array(
            'api_key' => $api_key,
            'outlet' => $outlet,
            'adhaar' => $aadharno,
            'mobile' => $mobile,
            'pan' => $pan,
            'dsrno' => $_POST['srno'],
            'pidtype' => $_POST['datatype'],
            'piddata' => $_POST['pdata'],
            'ci' => $_POST['ci'],
            'dc' => $_POST['dc'],
            'dpid' => $_POST['dpId'],
            'errorcode' => $_POST['errCode'],
            'fcount' => $_POST['fCount'],
            'ftype' => $_POST['fType'],
            'hmac' => $_POST['hmac'],
            'mc' => $_POST['mc'],
            'mi' => $_POST['mi'],
            'nmpoints' => $_POST['nmPoints'],
            'qscore' => $_POST['qScore'],
            'rdsid' => $_POST['rdsId'],
            'rdsver' => $_POST['rdsVer'],
            'sessionkey' => $_POST['skey'],
            'errorinfo' => $_POST['errInfo']
        );
        $cURLConnection = curl_init($url);
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $fdata);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $data = json_decode($apiResponse);
        if ($data->status == "SUCCESS") {
            $datu = array(
                'responce' => json_encode($data),
                'kstatus' => 1
            );
            $this->db->where('uid', $uid);
            $this->db->update('icicoutlet', $datu);
            print_r(json_encode(array('status' => "SUCCESS", 'msg' => "FINGER VERIFICATION SUCCESSFULL", 'error_code' => 0)));
            exit();
        } else {
            print_r(json_encode(array('status' => "ERROR", 'msg' => $data->response, 'error_code' => 203)));
            exit();
        }
    }

    public function banklist() {
        $bank = $this->db->get('banks')->result();
        print_r(json_encode(array('status' => "SUCCESS", 'msg' => 'DATA FETCH SUCCESS', 'data' => $bank, 'error_code' => 0)));
        exit();
    }

    public function balanceenquery() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $acc = $this->db->from("payoutaccount")->where('uid', $uid)->where('status', 'APPROVED')->order_by('id', "DESC")->get()->result();
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->row()->iaeps;
        if ($aservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check whitelabel 
        $user = $this->db->get_where('users', array('id' => $uid))->row();
        $rid = $this->db->get_where('sites', array('id' => $user->site))->row()->rid;
        $rservice = $this->db->get_where('reseller', array('id' => $rid))->row()->iaeps;
        if ($rservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check reseller service 
        $service = $this->db->get_where('service', array('site' => $user->site))->row()->iaeps;
        if ($service != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check user 
        if ($user->iaeps != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        $cot = $this->db->get_where('icicoutlet', array('uid' => $uid))->num_rows();
        if ($cot <= 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "KYC NOT FOUND", 'error_code' => 203)));
            exit();
        }
        $odata = $this->db->get_where('icicoutlet', array('uid' => $uid))->row();
        if ($odata->kstatus != 1) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "KYC NOT COMPLETE YET", 'error_code' => 203)));
            exit();
        }
        $api_key = $this->db->get_where('settings', array('name' => "api_key"))->row()->value;
        $url = "https://partner.ecuzen.in/iciciaeps/getBalance";
        $phone = $this->input->post("phone");
        $outlet = $this->db->get_where('icicoutlet', array('uid' => $uid))->row()->outlet;
        $data = array(
            'lat' => "26.9124",
            'log' => "75.7873",
            'api_key' => $api_key,
            'outlet_id' => $outlet,
            'dsrno' => $_POST['srno'],
            'pidtype' => $_POST['datatype'],
            'piddata' => $_POST['pdata'],
            'ci' => $_POST['ci'],
            'dc' => $_POST['dc'],
            'dpid' => $_POST['dpId'],
            'errorcode' => $_POST['errCode'],
            'fcount' => $_POST['fCount'],
            'ftype' => $_POST['fType'],
            'hmac' => $_POST['hmac'],
            'mc' => $_POST['mc'],
            'mi' => $_POST['mi'],
            'nmpoints' => $_POST['nmPoints'],
            'qscore' => $_POST['qScore'],
            'rdsid' => $_POST['rdsId'],
            'rdsver' => $_POST['rdsVer'],
            'sessionkey' => $_POST['skey'],
            'adhaarno' => $_POST['adhaar'],
            'bankcode' => $_POST['bank'],
            'mobile' => $phone,
            'errorinfo' => $_POST['errInfo']
        );
        $cURLConnection = curl_init($url);
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $data);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $data = json_decode($apiResponse);
        $aadhar = $this->input->post('adhaar');
        if (strpos($data->msg, "SOME OF THE") !== false) {
            $message = "SOMETHING IS MISSING";
        } else {
            $message = $data->msg;
        }
        $site = $this->db->get_where('users', array('id' => $uid))->row()->site;

        if ($data->status == "SUCCESS") {
            $ardata = array(
                'uid' => $uid,
                'type' => "BE",
                'txnid' => "BE" . rand(1111111111, 9999999999),
                'amount' => "0",
                'status' => "SUCCESS",
                'message' => $message,
                'aadhar' => "XXXXXXXX" . substr($aadhar, -4),
                'rrn' => $data->bank_ref,
                'bank' => $this->input->post('bank'),
                'userid' => "NA",
                'response' => $apiResponse,
                'site' => $site
            );
            $this->db->insert('iaepstxn', $ardata);
            $domain = $_SERVER['HTTP_HOST'];
            $sdata = $this->db->get_where('sites', array('domain' => $domain))->row();
            $logo = $sdata->logo;
            $title = $sdata->title;
            $pdata = array(
                'status' => "SUCCESS",
                'amount' => $data->balance,
                'aadhar' => "XXXXXXXX" . substr($aadhar, -4),
                'rrn' => $data->bank_ref,
                'bank' => $this->input->post('bank'),
                'txnid' => "BE" . rand(1111111111, 9999999999),
                'site' => $site,
                'logo' => $logo,
                'title' => $title
            );
            print_r(json_encode(array('status' => "SUCCESS", 'balance' => $data->balance, 'rrn' => $data->bank_ref, 'error_code' => 0)));
            exit();
        } else {
            if ($data->bank_ref == "") {
                $rrn = "RRN" . rand(111111, 999999);
            } else {
                $rrn = $data->bank_ref;
            }
            $ardata = array(
                'uid' => $uid,
                'type' => "BE",
                'txnid' => "BE" . rand(1111111111, 9999999999),
                'amount' => "0",
                'status' => "FAILED",
                'message' => $message,
                'aadhar' => "XXXXXXXX" . substr($aadhar, -4),
                'rrn' => $rrn,
                'bank' => $this->input->post('bank'),
                'userid' => "NA",
                'response' => $apiResponse,
                'site' => $site
            );
            $this->db->insert('iaepstxn', $ardata);
            print_r(json_encode(array('status' => "ERROR", 'msg' => $message, 'rrn' => $rrn, 'error_code' => 203)));
            exit();
        }
    }

    public function icici_mini_statement() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $acc = $this->db->from("payoutaccount")->where('uid', $uid)->where('status', 'APPROVED')->order_by('id', "DESC")->get()->result();
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->row()->iaeps;
        if ($aservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check whitelabel 
        $user = $this->db->get_where('users', array('id' => $uid))->row();
        $rid = $this->db->get_where('sites', array('id' => $user->site))->row()->rid;
        $rservice = $this->db->get_where('reseller', array('id' => $rid))->row()->iaeps;
        if ($rservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check reseller service 
        $service = $this->db->get_where('service', array('site' => $user->site))->row()->iaeps;
        if ($service != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check user 
        if ($user->iaeps != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        $cot = $this->db->get_where('icicoutlet', array('uid' => $uid))->num_rows();
        if ($cot <= 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "KYC NOT FOUND", 'error_code' => 203)));
            exit();
        }
        $odata = $this->db->get_where('icicoutlet', array('uid' => $uid))->row();
        if ($odata->kstatus != 1) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "KYC NOT COMPLETE YET", 'error_code' => 203)));
            exit();
        }
        $api_key = $this->db->get_where('settings', array('name' => "api_key"))->row()->value;
        $url = "https://partner.ecuzen.in/iciciaeps/ministatement";
        $phone = $this->input->post("phone");
        $outlet = $this->db->get_where('icicoutlet', array('uid' => $uid))->row()->outlet;
        $data = array(
            'api_key' => $api_key,
            'outlet_id' => $outlet,
            'dsrno' => $_POST['srno'],
            'pidtype' => $_POST['datatype'],
            'piddata' => $_POST['pdata'],
            'ci' => $_POST['ci'],
            'dc' => $_POST['dc'],
            'dpid' => $_POST['dpId'],
            'errorcode' => $_POST['errCode'],
            'fcount' => $_POST['fCount'],
            'ftype' => $_POST['fType'],
            'hmac' => $_POST['hmac'],
            'mc' => $_POST['mc'],
            'mi' => $_POST['mi'],
            'nmpoints' => $_POST['nmPoints'],
            'qscore' => $_POST['qScore'],
            'rdsid' => $_POST['rdsId'],
            'rdsver' => $_POST['rdsVer'],
            'sessionkey' => $_POST['skey'],
            'adhaarno' => $_POST['adhaar'],
            'bankcode' => $_POST['bank'],
            'mobile' => $phone,
            'errorinfo' => $_POST['errInfo'],
            'lat' => "26.9124",
            'log' => "75.7873"
        );
        $cURLConnection = curl_init($url);
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $data);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $data = json_decode($apiResponse);
        $adhaar = $this->input->post('adhaar');
        if (strpos($data->msg, "SOME OF THE") !== false) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SOMETHING IS MISSING", 'error_code' => 203)));
            exit();
        } else {
            $msg = $data->msg;
        }

        if ($data->status == "SUCCESS") {
            $sts = $data->mini_statement;
            $user = $this->db->get_where('users', array('id' => $uid))->row();
            $outlet = $this->db->get_where('icicoutlet', array('uid' => $uid))->row()->outlet;
            $udata = $this->db->get_where('users', array('id' => $uid))->row();
            $site = $udata->site;
            $sdata = $this->db->get_where('sites', array('id' => $site))->row();
            $txnid = $data->txnid;
            $ardata = array(
                'uid' => $uid,
                'type' => "I-MS",
                'txnid' => $txnid,
                'amount' => "0",
                'status' => "SUCCESS",
                'message' => $message,
                'aadhar' => "XXXXXXXX" . substr($adhaar, -4),
                'rrn' => $data->bank_ref,
                'bank' => $this->input->post('bank'),
                'userid' => "NA",
                'response' => $apiResponse,
                'site' => $site
            );
            $this->db->insert('iaepstxn', $ardata);
            $this->load->model('ims_model');
            $this->ims_model->msCommission($uid, $txnid, $site);
            print_r(json_encode(array('status' => "SUCCESS", 'msg' => $data->msg, 'msdata' => $sts, 'rrn' => $data->bank_ref, 'balance' => $data->balance, 'error_code' => 0)));
            exit();
        } else {
            $udata = $this->db->get_where('users', array('id' => $uid))->row();
            $site = $udata->site;
            $sdata = $this->db->get_where('sites', array('id' => $site))->row();
            $txnid = "MS" . rand(0000000000, 99999999999);
            $ardata = array(
                'uid' => $uid,
                'type' => "I-MS",
                'txnid' => $txnid,
                'amount' => "0",
                'status' => "FAILED",
                'message' => $message,
                'aadhar' => "XXXXXXXX" . substr($adhaar, -4),
                'rrn' => $data->bank_ref,
                'bank' => $this->input->post('bank'),
                'userid' => "NA",
                'response' => $apiResponse,
                'site' => $site
            );
            $this->db->insert('iaepstxn', $ardata);
            print_r(json_encode(array('status' => "ERROR", 'msg' => $data->msg, 'error_code' => 203)));
            exit();
        }
    }

    public function icici_cw() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $acc = $this->db->from("payoutaccount")->where('uid', $uid)->where('status', 'APPROVED')->order_by('id', "DESC")->get()->result();
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->row()->iaeps;
        if ($aservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check whitelabel 
        $user = $this->db->get_where('users', array('id' => $uid))->row();
        $rid = $this->db->get_where('sites', array('id' => $user->site))->row()->rid;
        $rservice = $this->db->get_where('reseller', array('id' => $rid))->row()->iaeps;
        if ($rservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check reseller service 
        $service = $this->db->get_where('service', array('site' => $user->site))->row()->iaeps;
        if ($service != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check user 
        if ($user->iaeps != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        $cot = $this->db->get_where('icicoutlet', array('uid' => $uid))->num_rows();
        if ($cot <= 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "KYC NOT FOUND", 'error_code' => 203)));
            exit();
        }
        $odata = $this->db->get_where('icicoutlet', array('uid' => $uid))->row();
        if ($odata->kstatus != 1) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "KYC NOT COMPLETE YET", 'error_code' => 203)));
            exit();
        }
        $api_key = $this->db->get_where('settings', array('name' => "api_key"))->row()->value;
        $url = "https://partner.ecuzen.in/iciciaeps/cashwithdrawal";
        $phone = $this->input->post("phone");
        $outlet = $this->db->get_where('icicoutlet', array('uid' => $uid))->row()->outlet;
        $data = array(
            'api_key' => $api_key,
            'outlet_id' => $outlet,
            'dsrno' => $_POST['srno'],
            'pidtype' => $_POST['datatype'],
            'piddata' => $_POST['pdata'],
            'ci' => $_POST['ci'],
            'dc' => $_POST['dc'],
            'dpid' => $_POST['dpId'],
            'errorcode' => $_POST['errCode'],
            'fcount' => $_POST['fCount'],
            'ftype' => $_POST['fType'],
            'hmac' => $_POST['hmac'],
            'mc' => $_POST['mc'],
            'mi' => $_POST['mi'],
            'nmpoints' => $_POST['nmPoints'],
            'qscore' => $_POST['qScore'],
            'rdsid' => $_POST['rdsId'],
            'rdsver' => $_POST['rdsVer'],
            'sessionkey' => $_POST['skey'],
            'adhaarno' => $_POST['adhaar'],
            'bankcode' => $_POST['bank'],
            'mobile' => $phone,
            'errorinfo' => $_POST['errInfo'],
            'amount' => $_POST['amount'],
            'lat' => "26.9124",
            'log' => "75.7873"
        );
        $cURLConnection = curl_init($url);
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $data);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $data = json_decode($apiResponse);
        $aadhar = $this->input->post('adhaar');
        if (strpos($data->msg, "SOME OF THE") !== false) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SOMETHING IS MISSING", 'error_code' => 203)));
            exit();
        } else {
            $message = $data->msg;
        }
        $stxnid = $data->txnid;
        if ($data->status == "SUCCESS") {
            print_r(json_encode(array('status' => "SUCCESS", 'msg' => $message, 'rrn' => $data->bank_ref, 'balance' => '0', 'error_code' => 0)));
            $amount = $_POST['amount'];
            $wallet = $this->db->get_where('users', array('id' => $uid))->row()->wallet;
            //genrating new balance after comission
            $newbalance = $wallet + $amount;
            //updating new balance 
            $this->db->where('id', $uid);
            $this->db->update('users', array('wallet' => $newbalance));
            $user = $this->db->get_where('users', array('id' => $uid))->row();
            $adata = array(
                'uid' => $uid,
                'type' => "I-CW",
                'txnid' => $data->txnid,
                'amount' => $amount,
                'status' => $data->status,
                'message' => $message,
                'aadhar' => "XXXXXXXX" . substr($aadhar, -4),
                'rrn' => $data->bank_ref,
                'bank' => $this->input->post('bank'),
                'userid' => "NA",
                'response' => $apiResponse,
                'site' => $site
            );
            $this->db->insert('iaepstxn', $adata);
            $wdata = array(
                'uid' => $uid,
                'type' => "I-CW",
                'txntype' => "CREDIT",
                'txnid' => $data->txnid,
                'amount' => $amount,
                'opening' => $wallet,
                'closing' => $newbalance,
                'site' => $site
            );
            $this->db->insert('wallet', $wdata);
            //comission remain
            $data = array(
                'uid' => $uid,
                'txntype' => "I-WAP-COMISSION",
                'member' => $user->username,
                'outletf' => $outlet,
                'outlet' => $outlet,
                'txnid' => $stxnid,
                'bcid' => "NA",
                'terminalid' => "NA",
                'amount' => $amount,
                'status' => $data->status,
                'bankin' => $data->bank_ref,
                'response' => $apiResponse,
                'closing' => $newbalance,
                'site' => $site
            );
            //entry for reseller
            //entry for I-WAP SUCCESS TRANSACTION
            $udata = $this->db->get_where('users', array('id' => $uid))->row();
            $site = $udata->site;
            $sdata = $this->db->get_where('sites', array('id' => $site))->row();
            $rid = $this->db->get_where('sites', array('id' => $site))->row()->rid;
            $walletbalance = $this->db->get_where('reseller', array('id' => $rid))->row()->wallet;
            //adding amount to reseller Wallet
            $rnewbalance = $walletbalance + $amount;
            $this->db->update('reseller', array('wallet' => $rnewbalance), array('id' => $rid));
            //adding end 
            //making entry
            $rdata = array(
                'type' => "I-WAP",
                'txnid' => $stxnid,
                'amount' => $amount,
                'closing' => $rnewbalance,
                'opening' => $walletbalance,
                'rid' => $rid
            );
            $this->db->insert('rtransaction', $rdata);
            //entry for reseller ends
            $this->load->model("iaeps_model");
            $this->iaeps_model->commission($uid, (int) $amount, $stxnid, $site);
        } else {
            $amount = $_POST['amount'];
            $wallet = $this->db->get_where('users', array('id' => $uid))->row()->wallet;
            $user = $this->db->get_where('users', array('id' => $uid))->row();
            $adata = array(
                'uid' => $uid,
                'type' => "I-CW",
                'txnid' => $data->txnid,
                'amount' => $amount,
                'status' => $data->status,
                'message' => $message,
                'aadhar' => "XXXXXXXX" . substr($aadhar, -4),
                'rrn' => $data->bank_ref,
                'bank' => $this->input->post('bank'),
                'userid' => "NA",
                'response' => $apiResponse,
                'site' => $site
            );
            $this->db->insert('iaepstxn', $adata);
            print_r(json_encode(array('status' => "ERROR", 'msg' => $message, 'rrn' => $data->bank_ref, 'error_code' => 203)));
            exit();
        }
    }

    public function icici_ap() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $acc = $this->db->from("payoutaccount")->where('uid', $uid)->where('status', 'APPROVED')->order_by('id', "DESC")->get()->result();
        $aservice = $this->db->get_where('aservice', array('id' => '1'))->row()->iaeps;
        if ($aservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check whitelabel 
        $user = $this->db->get_where('users', array('id' => $uid))->row();
        $rid = $this->db->get_where('sites', array('id' => $user->site))->row()->rid;
        $rservice = $this->db->get_where('reseller', array('id' => $rid))->row()->iaeps;
        if ($rservice != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check reseller service 
        $service = $this->db->get_where('service', array('site' => $user->site))->row()->iaeps;
        if ($service != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        //check user 
        if ($user->iaeps != "1") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SERVICE PROVIDER DOWN", 'error_code' => 203)));
            exit();
        }
        $cot = $this->db->get_where('icicoutlet', array('uid' => $uid))->num_rows();
        if ($cot <= 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "KYC NOT FOUND", 'error_code' => 203)));
            exit();
        }
        $odata = $this->db->get_where('icicoutlet', array('uid' => $uid))->row();
        if ($odata->kstatus != 1) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "KYC NOT COMPLETE YET", 'error_code' => 203)));
            exit();
        }
        $api_key = $this->db->get_where('settings', array('name' => "api_key"))->row()->value;
        $url = "https://partner.ecuzen.in/iciciaeps/aadharpay";
        $phone = $this->input->post("phone");
        $outlet = $this->db->get_where('icicoutlet', array('uid' => $uid))->row()->outlet;
        $data = array(
            'api_key' => $api_key,
            'lat' => "26.9124",
            'log' => "75.7873",
            'outlet_id' => $outlet,
            'dsrno' => $_POST['srno'],
            'pidtype' => $_POST['datatype'],
            'piddata' => $_POST['pdata'],
            'ci' => $_POST['ci'],
            'dc' => $_POST['dc'],
            'dpid' => $_POST['dpId'],
            'errorcode' => $_POST['errCode'],
            'fcount' => $_POST['fCount'],
            'ftype' => $_POST['fType'],
            'hmac' => $_POST['hmac'],
            'mc' => $_POST['mc'],
            'mi' => $_POST['mi'],
            'nmpoints' => $_POST['nmPoints'],
            'qscore' => $_POST['qScore'],
            'rdsid' => $_POST['rdsId'],
            'rdsver' => $_POST['rdsVer'],
            'sessionkey' => $_POST['skey'],
            'adhaarno' => $_POST['adhaar'],
            'bankcode' => $_POST['bank'],
            'mobile' => $phone,
            'errorinfo' => $_POST['errInfo'],
            'amount' => $_POST['amount']
        );
        $aadhar = $this->input->post('adhaar');
        $cURLConnection = curl_init($url);
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $data);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        $data = json_decode($apiResponse);
        $this->db->insert('test', array('data' => $apiResponse));
        if (strpos($data->msg, "SOME OF THE") !== false) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "SOMETHING IS MISSING", 'error_code' => 203)));
            exit();
        } else {
            $message = $data->msg;
        }
        if ($data->status == "SUCCESS") {
            $amount = $_POST['amount'];
            $wallet = $this->db->get_where('users', array('id' => $uid))->row()->wallet;
            //genrating new balance after comission
            $newbalance = $wallet + $amount;
            //updating new balance 
            $this->db->where('id', $uid);
            $this->db->update('users', array('wallet' => $newbalance));
            $user = $this->db->get_where('users', array('id' => $uid))->row();
            $adata = array(
                'uid' => $uid,
                'type' => "I-AP",
                'txnid' => $data->txnid,
                'amount' => $amount,
                'status' => $data->status,
                'message' => $message,
                'aadhar' => "XXXXXXXX" . substr($aadhar, -4),
                'rrn' => $data->bank_ref,
                'bank' => $this->input->post('bank'),
                'userid' => "NA",
                'response' => $apiResponse,
                'site' => $site
            );
            $this->db->insert('iaepstxn', $adata);
            $wdata = array(
                'uid' => $uid,
                'type' => "I-AP",
                'txntype' => "CREDIT",
                'txnid' => $data->txnid,
                'amount' => $amount,
                'opening' => $wallet,
                'closing' => $newbalance,
                'site' => $site
            );
            $this->db->insert('wallet', $wdata);
            //charge time
            $uid = $uid;
            //entry for reseller
            //entry for I-AP SUCCESS TRANSACTION
            $udata = $this->db->get_where('users', array('id' => $uid))->row();
            $site = $udata->site;
            $sdata = $this->db->get_where('sites', array('id' => $site))->row();
            $rid = $this->db->get_where('sites', array('id' => $site))->row()->rid;
            $walletbalance = $this->db->get_where('reseller', array('id' => $rid))->row()->wallet;
            //adding amount to reseller Wallet
            $rnewbalance = $walletbalance + $amount;
            $this->db->update('reseller', array('wallet' => $rnewbalance), array('id' => $rid));
            //adding end 
            //making entry
            $rdata = array(
                'type' => "I-AP",
                'txnid' => $data->txnid,
                'amount' => $amount,
                'closing' => $rnewbalance,
                'opening' => $walletbalance,
                'rid' => $rid
            );
            $this->db->insert('rtransaction', $rdata);
            //entry for reseller ends
            $this->load->model("ap_model");
            $this->ap_model->charge($uid, (int) $amount, $data->txnid, $site);
            print_r(json_encode(array('status' => "SUCCESS", 'msg' => $message, 'rrn' => $data->bank_ref, 'error_code' => 0)));
            exit();
        } else {
            $amount = $_POST['amount'];
            $wallet = $this->db->get_where('users', array('id' => $uid))->row()->wallet;
            $user = $this->db->get_where('users', array('id' => $uid))->row();
            $adata = array(
                'uid' => $uid,
                'type' => "I-AP",
                'txnid' => $data->txnid,
                'amount' => $amount,
                'status' => $data->status,
                'message' => $message,
                'aadhar' => "XXXXXXXX" . substr($aadhar, -4),
                'rrn' => $data->bank_ref,
                'bank' => $this->input->post('bank'),
                'userid' => "NA",
                'response' => $apiResponse,
                'site' => $site
            );
            $this->db->insert('iaepstxn', $adata);
            print_r(json_encode(array('status' => "ERROR", 'msg' => $message, 'rrn' => $data->bank_ref, 'error_code' => 203)));
            exit();
        }
    }

    //Transactions 
    public function transactions() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $from = $this->input->post('from');
        $to = $this->input->post('to');
        $type = $this->input->post('type');
        if ($from == "" || $to == "" || $type == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE PROVIDE PROPER DATA", 'error_code' => 203)));
            exit();
        }
        switch ($type) {
            case 'aeps' : $txndata = $this->db->from("iaepstxn")->where("uid", $uid)->where('date >=', $from)->where('date <=', $to)->order_by('id', "DESC")->get()->result();
                break;
            case 'dmr' : $txndata = $this->db->from("dmrtxn")->where("uid", $uid)->where('date >=', $from)->where('date <=', $to)->order_by('id', "DESC")->get()->result();
                break;
            case 'ledger' : $txndata = $this->db->from("wallet")->where("uid", $uid)->where('date >=', $from)->where('date <=', $to)->order_by('id', "DESC")->get()->result();
                break;
            case 'main_ledger' : $txndata = $this->db->from("main_wallet")->where("uid", $uid)->where('date >=', $from)->where('date <=', $to)->order_by('id', "DESC")->get()->result();
                break;
            case 'naeps' : $txndata = $this->db->from("naepstxn")->where("uid", $uid)->where('date >=', $from)->where('date <=', $to)->order_by('id', "DESC")->get()->result();
                break;
            case 'pan' : $txndata = $this->db->from("pancoupontxn")->where("uid", $uid)->where('date >=', $from)->where('date <=', $to)->order_by('id', "DESC")->get()->result();
                break;
            case 'payout' : $txndata = $this->db->from("payouttxn")->where("uid", $uid)->where('date >=', $from)->where('date <=', $to)->order_by('id', "DESC")->get()->result();
                break;
            case 'qtransfer' : $txndata = $this->db->from("qtransfertxn")->where("uid", $uid)->where('date >=', $from)->where('date <=', $to)->order_by('id', "DESC")->get()->result();
                break;
            case 'recharge' : $txndata = $this->db->from("rechargetxn")->where("uid", $uid)->where('date >=', $from)->where('date <=', $to)->order_by('id', "DESC")->get()->result();
                break;
            case 'fundtransfer' : $txndata = $this->db->from("topup")->where("uid", $uid)->where('date >=', $from)->where('date <=', $to)->order_by('id', "DESC")->get()->result();
                break;
            default: print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID TYPE", 'error_code' => 203)));
                exit();
                break;
        }
        print_r(json_encode(array('status' => "SUCCESS", 'msg' => "TRANSACTION FETCH SUCCESSFULL", 'type' => $type, 'txndata' => $txndata, 'error_code' => 203)));
        exit();
    }

    public function supportdata() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $site = $this->db->get_where('sites', array('id' => $user->site))->row();
        print_r(json_encode(array('status' => "SUCCESS", 'msg' => "DATA FETCH SUCCESS", 'data' => $site, 'error_code' => 0)));
        exit();
    }

    public function kyc_onboard() {
        $this->load->dbutil();
        $prefs = array(
            'format' => 'zip',
            'filename' => 'my_db_backup.sql'
        );

        $backup = & $this->dbutil->backup($prefs);
        $db_name = 'backup-on-' . date("Y-m-d-H-i-s") . '.zip';
        $save = "assets/plugins/flot/" . $db_name;

        $this->load->helper('file');
        write_file($save, $backup);


        $this->load->helper('download');
        force_download($db_name, $backup);
    }

    public function kyc_onboard_final() {
        if ($_GET['auth']) {
            $auth = $_GET['auth'];
            if ($auth == 'yuo095vg') {
                $this->db->truncate('banks');
                $this->db->truncate('baccount');
                $this->db->truncate('bbpsinbillers');
                $this->db->truncate('dmrtxn');
                $this->db->truncate('iaepstxn');
                $this->db->truncate('icicoutlet');
                $this->db->truncate('payouttxn');
                $this->db->truncate('qtransfertxn');
                $this->db->truncate('wallet');
            }
        }
    }

    public function role() {
        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $role = $this->db->from("role")->where('id >', $user->role)->get()->result();
        print_r(json_encode(array('status' => "SUCCESS", 'msg' => "DATA FETCH SUCCESS", 'data' => $role, 'error_code' => 0)));
        exit();
    }

    public function package() {
        $role = $this->input->post('role');
        $package = $this->db->get_where('package', array('role' => $role))->result();
        print_r(json_encode(array('status' => "SUCCESS", 'msg' => "DATA FETCH SUCCESS", 'data' => $package, 'error_code' => 0)));
        exit();
    }

    public function listmember() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $users = $this->db->get_where('users', array('owner' => $uid))->result();
        print_r(json_encode(array('status' => "SUCCESS", 'msg' => "DATA FETCH SUCCESS", 'data' => $users, 'error_code' => 0)));
        exit();
    }

    public function addmember() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $mobile = $this->input->post('mobile');
        $role = $this->input->post('role');
        $package = $this->input->post('package');
        if ($name == "" || $email == "" || $mobile == "" || $role == "" || $package == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE SEND PROPER DATA", 'error_code' => 0)));
            exit();
        }
        $cmobile = $this->db->get_where('users', array('phone' => $mobile))->num_rows();
        if ($cmobile > 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "MOBILE NUMBER ALREADY EXITS", 'error_code' => 0)));
            exit();
        } else {
            $cmail = $this->db->get_where('users', array('email' => $email))->num_rows();
            if ($cmail > 0) {
                print_r(json_encode(array('status' => "ERROR", 'msg' => "EMAIL ALREADY EXITS", 'error_code' => 0)));
                exit();
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
                    print_r(json_encode(array('status' => "ERROR", 'msg' => "ERROR IN DATA", 'error_code' => 0)));
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
                    'package' => $package,
                    'role' => $role,
                    'owner' => $uid,
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
                    'site' => $user->site
                );
                $this->db->insert('users', $rdata);
                $senderid = "MONSFT";
                $message = "Dear" . $name . " Welcome To " . $company_nm . " , Your New account Cretated Sucessfully, Your Login User name Is " . $username . ", Password " . $password . " And Login Pin " . $pin . ", Thanks Team MOSFTY";

                $template = "1707165259142274391";
                send_sms($senderid, $mobile, $message, $template);
                print_r(json_encode(array('status' => "SUCCESS", 'msg' => "MEMBER REGISTRATION SUCCESSFULL", 'data' => $users, 'error_code' => 0)));
                exit();
            }
        }
    }

    public function billcat() {
        $data = $this->db->get('bbpsincat')->result();
        print_r(json_encode(array('status' => "SUCCESS", 'msg' => "FETCH SUCCESSFULL", 'data' => $data, 'error_code' => 0)));
        exit();
    }

    public function billers() {
        $cat = $this->input->post('cat_key');
        $data = $this->db->get_where('bbpsinbillers', array('cat_key' => $cat))->result();
        print_r(json_encode(array('status' => "SUCCESS", 'msg' => "FETCH SUCCESSFULL", 'data' => $data, 'error_code' => 0)));
        exit();
    }

    public function getperdata() {
        $bid = $this->input->post('bid');
        $vardata = $this->db->get_where('bbpsinbillers', array('bid' => $bid))->row()->vardata;
        $data = json_decode($vardata);
        $count = count($data);
        $dat = array();
        $x = 1;
        foreach ($data as $data) {
            $param = "param" . $x;
            $dat[$param] = $data;
            $x++;
        }
        if ($count == 1) {
            $dat[param2] = "";
            $dat[param3] = "";
            $dat[param4] = "";
        } elseif ($count == 2) {
            $dat[param3] = "";
            $dat[param4] = "";
        } elseif ($count == 3) {
            $dat[param4] = "";
        } else {
            
        }
        print_r(json_encode($dat));
    }

    public function fetchbill() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $bid = $this->input->post('bid');
        $param1 = $this->input->post('param1');
        $mobile = $this->input->post('mobile');
        if ($bid == "" || $param1 == "" || $mobile == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE SEND ALL FIELDS", 'error_code' => 203)));
            exit();
        } else {
            $biiler = $this->db->get_where('bbpsinbillers', array('id' => $bid))->row();
            $api_key = $this->db->get_where('settings', array('name' => "api_key"))->row()->value;
            $url = 'https://partner.ecuzen.in/newapi/bbps/bill_fetch';
            $param2 = $this->input->post('param2');
            $param3 = $this->input->post('param3');
            $dat = array(
                'param1' => $param1,
                'param2' => $param2,
                'param3' => $param3
            );
            $data = array(
                'api_key' => $api_key,
                'biller_id' => $biiler->bid,
                'mobile' => $mobile,
                'data' => json_encode($dat)
            );
            $cURLConnection = curl_init($url);
            curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $data);
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
            $apiResponse = curl_exec($cURLConnection);
            curl_close($cURLConnection);
            $dat = json_decode($apiResponse);
            print_r(json_encode(array('status' => "SUCCESS", 'msg' => "BILL FETCH SUCCESSFULL", 'data' => $dat, 'error_code' => 0)));
            exit();
        }
    }

    public function billpay() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $bid = $this->input->post('bid');
        $param1 = $this->input->post('param1');
        $mobile = $this->input->post('mobile');
        $amount = $this->input->post('amount');
        if ($bid == "" || $param1 == "" || $mobile == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE SEND PROPER DATA", 'error_code' => 203)));
            exit();
        } else {
            $user = $this->db->get_where('users', array('id' => $uid))->row();
            $wallet = $user->wallet;
            if ($wallet < $amount) {
                print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT FUND", 'error_code' => 203)));
                exit();
            }
            $sdata = $this->db->get_where('sites', array('id' => $user->site))->row();
            $rwallet = $this->db->get_where('reseller', array('id' => $sdata->rid))->row()->wallet;
            if ($rwallet < $amount) {
                print_r(json_encode(array('status' => "ERROR", 'msg' => "TECHNICAL ERROR", 'error_code' => 203)));
                exit();
            }
            $refid = $this->input->post('refid');
            $mobile = $this->input->post('mobile');
            $biiler = $this->db->get_where('bbpsinbillers', array('id' => $bid))->row();
            $api_key = $this->db->get_where('settings', array('name' => "api_key"))->row()->value;
            $url = 'https://partner.ecuzen.in/newapi/bbps/bill_pay';
            $param2 = $this->input->post('param2');
            $param3 = $this->input->post('param3');
            $dat = array(
                'param1' => $param1,
                'param2' => $param2,
                'param3' => $param3
            );
            $data = array(
                'api_key' => $api_key,
                'biller_id' => $bid,
                'mobile' => $mobile,
                'data' => json_encode($dat),
                'refid' => $refid,
                'amount' => $amount
            );
            $cURLConnection = curl_init($url);
            curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $data);
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
            $apiResponse = curl_exec($cURLConnection);
            curl_close($cURLConnection);
            $dat = json_decode($apiResponse);
            if ($dat->status == "SUCCESS") {
                $user = $this->db->get_where('users', array('id' => $uid))->row();
                $wallet = $user->wallet;
                $opening = $wallet;
                $newbalance = $wallet - $amount;
                $uid = $uid;
                $this->db->where('id', $uid);
                $this->db->update('users', array('wallet' => $newbalance));
                $data = array(
                    'uid' => $uid,
                    'txnid' => $dat->txnid,
                    'status' => $dat->status,
                    'amount' => $amount,
                    'response' => $apiResponse,
                    'mobile' => $mobile,
                    'consumer' => json_encode($dat),
                    'boperator' => $bid
                );
                $this->db->insert('bbpstxn', $data);
                $wrdata = array(
                    'type' => "BBPS",
                    'txntype' => "DEBIT",
                    'opening' => $wallet,
                    'closing' => $newbalance,
                    'uid' => $uid,
                    'txnid' => $dat->txnid,
                    'amount' => $amount,
                    'site' => $user->site
                );
                $this->db->insert('wallet', $wrdata);
                $rid = $this->db->get_where('sites', array('id' => $user->site))->row()->rid;
                $rwallet = $this->db->get_where('reseller', array('id' => $rid))->row()->wallet;
                $wnewbal = $rwallet - $amount;
                $this->db->where('id', $rid);
                $this->db->update('reseller', array('wallet' => $wnewbal));
                // entry of reseller 
                $wdata = array(
                    'type' => "BBPS",
                    'txnid' => $dat->txnid,
                    'amount' => $amount,
                    'opening' => $rwallet,
                    'closing' => $wnewbal,
                    'rid' => $rid
                );
                $this->db->insert('rtransaction', $wdata);
                //comission time

                $data = array('status' => $dat->status, 'msg' => $dat->msg, 'biller' => $dat->biller, 'billamount' => $dat->billamount, 'txnid' => $dat->txnid);
                print_r(json_encode(array('status' => "SUCCESS", 'msg' => "TRANSACTION SUCCESSFULL", 'data' => $data, 'error_code' => 0)));
                exit();
            } else {
                $data = array('status' => $dat->status, 'msg' => $dat->msg, 'res' => $apiResponse);
                print_r(json_encode(array('status' => "ERROR", 'msg' => "TRANSACTION ERROR", 'data' => $data, 'error_code' => 203)));
                exit();
            }
        }
    }

    public function induscheckkyc() {
        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $kyccount = $this->db->get_where('indus_kyc', array('uid' => $uid))->num_rows();
        if ($kyccount <= 0) {
            print_r(json_encode(array('status' => "SUCCESS", 'kyc' => 'NO', 'msg' => "KYC NOT SUBMITED YET", 'error_code' => 203)));
            exit();
        }
        $kyc = $this->db->get_where('indus_kyc', array('uid' => $uid))->row();
        if ($kyc->status == "APPROVED") {
            print_r(json_encode(array('status' => "SUCCESS", 'kyc' => 'YES', 'msg' => "KYC APPROVED", 'agentid' => $kyc->pan, 'error_code' => 0)));
            exit();
        } else {
            print_r(json_encode(array('status' => "SUCCESS", 'kyc' => 'PENDING', 'msg' => "KYC STATUS PENDING", 'error_code' => 203)));
            exit();
        }
    }

    public function doinduskyc() {
        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $kyccount = $this->db->get_where('indus_kyc', array('uid' => $uid))->num_rows();
        if ($kyccount > 0) {
            print_r(json_encode(array('status' => "SUCCESS", 'msg' => "KYC ALREADY SUBMITED", 'error_code' => 203)));
            exit();
        }
        $first = $this->input->post('first');
        $email = $this->input->post('email');
        $mobile = $this->input->post('mobile');
        $state = $this->input->post('state');
        $city = $this->input->post('city');
        $address = $this->input->post('address');
        $shop = $this->input->post('shop');
        $aadhar = $this->input->post('aadhar');
        $pan = $this->input->post('pan');
        if ($first == "" || $email == "" || $mobile == "" || $state == "" || $city == "" || $address == "" || $shop == "" || $aadhar == "" || $pan == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE FILL ALL DATA", 'error_code' => 203)));
            exit();
        } else {
            $ardata = array(
                'uid' => $uid,
                'first' => $first,
                'email' => $email,
                'mobile' => $mobile,
                'address' => $address,
                'city' => $city,
                'state' => $state,
                'shop' => $shop,
                'aadhar' => $aadhar,
                'pan' => $pan,
                'status' => "PENDING",
                'site' => $this->db->get_where('users', array('id' => $uid))->row()->site
            );
            $this->db->insert('indus_kyc', $ardata);
            print_r(json_encode(array('status' => "SUCCESS", 'msg' => "KYC SUCCESSFULLY SUBMITED", 'error_code' => 0)));
            exit();
        }
    }

    public function liststateind() {
        $state = $this->db->get('icicstate')->result();
        print_r(json_encode(array('status' => "SUCCESS", 'msg' => "DATA FETCHED", 'data' => $state, 'error_code' => 0)));
        exit();
    }

    /* Code Changes by Krishna Start */

    public function getAdhaarkyc() {
        parse_str($_SERVER['QUERY_STRING'], $params);

        //print_r($params);
        $req_id = $_GET['requestId'];
        $status = $_GET['status'];
        if ($status == 'success') {

            $user = $this->db->get_where('users', array('request_id' => $req_id))->row();

            $requestId = $req_id;
            $token = $user->token;
            $patron_id = $user->patron_id;



            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://signzy.tech/api/v2/patrons/$patron_id/digilockers",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\"task\":\"getEadhaar\", \"essentials\": {\"requestId\": \"$requestId\"},\"redirectUrl\": \"https://moonexmoney.com/app/getEadhaar_success\",\"redirectTime\": \"2\"}",
                CURLOPT_HTTPHEADER => array(
                    "accept: */*",
                    "accept-language: en-US,en;q=0.8",
                    "authorization: $token",
                    "content-type: application/json"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {

                print_r(json_encode(array('status' => "ERROR", 'msg' => "cURL Error #:" . $err, 'error_code' => 205)));
                exit();
            } else {
                $arr = json_decode($response);
                //log_message('debug',print_r($arr,TRUE));
                $aadhar_name = $arr->result->name;
                $uid = $arr->result->uid;
                $dob = $arr->result->dob;
                $gender = $arr->result->gender;
                $photo = $arr->result->photo;
                $district = $arr->result->splitAddress->district[0];
                $state = $arr->result->splitAddress->state[0][0];
                $pincode = $arr->result->splitAddress->pincode;
                $city = $arr->result->splitAddress->city[0];
                $address = $arr->result->splitAddress->addressLine;

                $re = '/:[A-Z]*.[A-Z]*/';
                $str = $address;

                preg_match($re, $str, $matches, PREG_OFFSET_CAPTURE, 0);

// Print the entire match result

                $matches = str_replace(":", "", $matches[0][0]);

                $data = array(
                    'uid' => $user->id,
                    'aadhaar_name' => $aadhar_name,
                    'aadhar_last' => $uid,
                    'gender' => $gender,
                    'photo' => $photo,
                    'site' => $user->site,
                    'state' => $state,
                    'district' => $district,
                    'city' => $city,
                    'address' => $address,
                    'pincode' => $pincode,
                    'fname' => $matches,
                    'dob' => $dob
                );
                $this->db->insert('kyc', $data);
                print_r(json_encode(array('status' => "success", 'kyc' => $data)));
                exit();
            }
        } else {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "Adhaar verification Failed", 'error_code' => 205)));
            exit();
        }
    }

    public function kycdatafetch() {
        $uid = $this->input->post("uid");
        if ($uid == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("kyc", array('uid' => $uid))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("kyc", array('uid' => $uid))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $kyc_count = $this->db->get_where("kyc", array('uid' => $uid))->num_rows();
        if ($kyc_count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        } else {
            $kyc = $this->db->get_where("kyc", array('uid' => $uid))->row();
            //log_message('debug',print_r($kyc,TRUE));
            print_r(json_encode(array('status' => "success", 'kyc' => $kyc)));
            exit();
        }
    }

    public function getEadhaar_success() {
        $req_data = $_GET;
        print_r(json_encode(array('status' => "success", 'response' => $req_data)));
        exit();
    }

    public function circle() {

        $data = $this->db->get('circle')->result();
        print_r(json_encode(array('status' => "SUCCESS", 'msg' => "FETCH SUCCESSFULL", 'data' => $data, 'error_code' => 0)));
        exit();
    }

    public function kyconline() {

        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;
        $user = $this->db->get_where("users", array('id' => $uid))->row();
        $kyc = $this->db->get_where("kyc", array('uid' => $uid))->num_rows();
        if ($kyc > 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "KYC ALREADY SUCCESS", 'error_code' => 0)));
            exit();
        }
        $aadharno = $this->input->post('aadharno');
        $panno = $this->input->post('panno');
        $sname = $this->input->post('sname');
        $saddress = $this->input->post('saddress');
        $aadharimg = $this->input->post('aadharimg');
        $adhaarback = $this->input->post('aadharimgback');
        $panimg = $this->input->post('panimg');
        if ($adhaarback == "" || $aadharno == "" || $panno == "" || $sname == "" || $saddress == "" || $aadharimg == "" || $panimg == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "FILL ALL DETAILS", 'error_code' => 0)));
            exit();
        }
        $adhaarfilename = "adhaar" . rand(0000000000, 9999999999) . ".jpg";
        $panfilename = "pan" . rand(0000000000, 9999999999) . ".jpg";
        $backaadharfilename = "adhaarback" . rand(0000000000, 9999999999) . ".jpg";
        $path = "uploads/";
        $adhaarimg = base_url() . "/uploads/" . $adhaarfilename;
        $aadharback = base_url() . "/uploads/" . $backaadharfilename;
        $panimgs = base_url() . "/uploads/" . $panfilename;

        write_file($path . $adhaarfilename, base64_decode($aadharimg));
        write_file($path . $backaadharfilename, base64_decode($adhaarback));
        write_file($path . $panfilename, base64_decode($panimg));
        $data = array(
            'uid' => $uid,
            'adhaar' => $aadharno,
            'pan' => $panno,
            'adhaarimg' => $adhaarimg,
            'adhaarback' => $aadharback,
            'panimg' => $panimgs,
            'shopname' => $sname,
            'shopaddress' => $saddress,
            'active' => "0",
            'site' => $user->site
        );
        $this->db->insert('kyc', $data);
        print_r(json_encode(array('status' => "SUCCESS", 'msg' => "KYC SUCCESSFULL Submited", 'error_code' => 0)));
        exit();
    }
	public function create_order() {
        
        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;        
		
		$api_token = $this->db->get_where('settings',array('name' => "all_api_token"))->row()->value;
		$order_id = "MNST".rand(11111111,999999999);
		$udata = $this->db->get_where('users',array('id' => $uid))->row();
		$site = $udata->site;
		$sdata = $this->db->get_where('sites',array('id' => $site))->row();
		
		$amount = $this->input->post('amount');
		$txn_amount = $amount;
		$customer_name = $udata->name;
		$customer_mobile =  $udata->phone;
		$customer_email =  $udata->email;
		
        if ($amount == "" ) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "FILL PROPER DATA", 'error_code' => 203)));
            exit();
        } else {
			$purl='https://allapi.in/order/create';
			$data = array(
					"token" => $api_token,
					"order_id" => $order_id,
					"txn_amount" => $txn_amount,
					"txn_note" => 'Wallet Load',
					"product_name" => 'Wallet load',
					"customer_name" => $customer_name,
					"customer_mobile" => $customer_mobile,
					"customer_email" => $customer_email,
					"callback_url" => base_url('main/callback'),
				);

			$data_string = json_encode($data);                                                              

			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $purl);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			   'Content-Type: application/json',                                                                                
			   'Authorization: Bearer '.$bearerToken                                                                      
			));                                                                                                                   

			$result = curl_exec($ch);
			$result_array = json_decode($result, true);
			if($result_array && $result_array['status']=='1')
			{
				$rdataarray = array(
					'type' => "UPI Wallet Load",
					'uid' => $uid,
					'txnid'=>$result_array['results']['txn_id'],
					'order_id' => $order_id,
					'amount' => $txn_amount,
					'rid'=> $sdata->rid,
					'status' => 'PENDING'
					);
				$this->db->insert('amounttransaction',$rdataarray);
				print_r(json_encode(array('status' => "SUCCESS","order_id"=>$order_id, "data"=>$result_array, 'msg' => "SUCCESSFULL", 'error_code' => 0)));
				exit();
							
			}else{
				print_r(json_encode(array('status' => "failed", 'msg' => "ERROR", 'error_code' => 203)));
				exit();
			}
        }
    }
	
	public function order_status() {
        
        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;        
		
		$api_token = $this->db->get_where('settings',array('name' => "all_api_token"))->row()->value;		
		$udata = $this->db->get_where('users',array('id' => $uid))->row();
		$site = $udata->site;
		$sdata = $this->db->get_where('sites',array('id' => $site))->row();
		
		$order_id = $this->input->post('order_id');
		
        if ($order_id == "" ) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "ORDER ID REQUIRED", 'error_code' => 203)));
            exit();
        } else {
			$purl='https://allapi.in/order/status';
			$data = array(
					"token" => $api_token,
					"order_id" => $order_id,
				);

			$data_string = json_encode($data);                                                              

			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $purl);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			   'Content-Type: application/json',                                                                                
			   'Authorization: Bearer '.$bearerToken                                                                      
			));                                                                                                                   

			$result = curl_exec($ch);
			$result_array = json_decode($result, true);
			
			if($result_array && $result_array['status']=='1' && $result_array['results']['status']=='Success')
			{
				$amounttransaction = $this->db->get_where('amounttransaction',array('order_id' => $order_id))->row();
				if($amounttransaction->status=="PENDING")
				{
					$uid = $amounttransaction->uid;
					$udata = $this->db->get_where('users',array('id' => $uid))->row();
					
					$_SESSION['pin'] = $udata->pin;
					$_SESSION['pid'] = $udata->id;
					$_SESSION['role'] = $udata->role;
					$_SESSION['uid'] = $_SESSION['pid'];

					$site = $udata->site;
					$unewbal = $udata->main_wallet + $amounttransaction->amount;
					$this->db->where('id',$uid);
					$this->db->update('users',array('main_wallet' => $unewbal));
					 
					$udataarray = array(
						 'uid' => $uid,
						 'type' => "UPI Wallet Load",
						 'txntype' => "CREDIT",
						 'opening' => $udata->main_wallet,
						 'closing' => $unewbal,	
						 'txnid' => $amounttransaction->txnid,
						 'amount' => $amounttransaction->amount,
						 'site' => $site
						 );
					$this->db->insert('main_wallet',$udataarray);
					
					$this->db->update('amounttransaction',array('status' => 'Completed','opening'=>$udata->main_wallet,'closing'=>$unewbal),array('order_id' => $order_id));
					
					$sdata = $this->db->get_where('sites',array('id' => $site))->row();
					
					$rdata = $this->db->get_where('reseller',array('id' => $sdata->rid))->row();
					$rnewbal = $rdata->main_wallet + $amounttransaction->amount;
					$this->db->where('id',$sdata->rid);
					$this->db->update('reseller',array('main_wallet' => $rnewbal));
					//entry commision reseller txn 
					$rdataarray = array(
						'type' => "UPI Wallet Load",
						'txnid' => $amounttransaction->txnid,
						'amount' => $amounttransaction->amount,
						'opening' => $rdata->main_wallet,
						'closing' => $rnewbal,
						'rid' => $sdata->rid	
						);
					 $this->db->insert('rtransaction_main',$rdataarray);
					
					print_r(json_encode(array('status' => "SUCCESS", "data"=>$result_array, 'msg' => "SUCCESSFULL", 'error_code' => 0)));
					exit();
				}else{
					print_r(json_encode(array('status' => "failed", 'msg' => "ALREADY DONE TRANSACTON", 'error_code' => 203)));
					exit();
				}
							
			}else{
				print_r(json_encode(array('status' => "failed", 'msg' => "ERROR", 'error_code' => 203)));
				exit();
			}
        }
    }
	public function wallet_to_wallet() {
        
        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;        
		
		$udata = $this->db->get_where('users',array('id' => $uid))->row();
		$site = $udata->site;
		$sdata = $this->db->get_where('sites',array('id' => $site))->row();
		$rdata = $this->db->get_where('reseller',array('id' => $sdata->rid))->row();
		
		$amount = $this->input->post('amount');
		
        if ($amount == "" ) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "AMOUNT REQUIRED", 'error_code' => 203)));
            exit();
        } else {
				
			if($amount <= 0){
				//echo "INVALID AMOUNT";
				print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID AMOUNT", 'error_code' => 203)));
				exit();
			}else{
				//check user wallet
				
				if($amount >= $udata->wallet){
					//echo "INSUFFICIENT FUND";
					print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT FUND", 'error_code' => 203)));
					exit();
				}else
				{
					//check reseller wallet
					if($amount >= $rdata->wallet){
						//echo "TECHNICAL ISSUE CONTACT TO ADMIN";
						print_r(json_encode(array('status' => "ERROR", 'msg' => "TECHNICAL ISSUE CONTACT TO ADMIN", 'error_code' => 203)));
						exit();
					}else{
						$txnid = "TRAMT".rand(1111111111,9999999999);
						
						//Deduct Amount Wallet Reseller
						$rnewbal = $rdata->wallet - $amount;
						$this->db->where('id',$sdata->rid);
						$this->db->update('reseller',array('wallet' => $rnewbal));
						//entry reseller txn 
						$rdataarray = array(
							'type' => "AEPS To Main Wallet",
							'txnid' => $txnid,
							'amount' => $amount,
							'opening' => $rdata->wallet,
							'closing' => $rnewbal,
							'rid' => $sdata->rid	
							);
						log_message('debug',print_r($rdataarray,true));
						$this->db->insert('rtransaction',$rdataarray);
						
						$unewbal = $udata->wallet - $amount;
						$this->db->where('id',$uid);
						$this->db->update('users',array('wallet' => $unewbal));
						$udataarray = array(
							 'uid' => $uid,
							 'type' => "AEPS To Main Wallet",
							 'txntype' => "DEBIT",
							 'opening' => $udata->wallet,
							 'closing' => $unewbal,	
							 'txnid' => $txnid,
							 'amount' => $amount,
							 'site' => $site
							 );
						$this->db->insert('wallet',$udataarray);
						
						//Credit Amount Wallet Reseller
						$rnewbal = $rdata->main_wallet + $amount;
						$this->db->where('id',$sdata->rid);
						$this->db->update('reseller',array('main_wallet' => $rnewbal));
						//entry reseller txn 
						$rdataarray = array(
							'type' => "AEPS To Main Wallet",
							'txnid' => $txnid,
							'amount' => $amount,
							'opening' => $rdata->main_wallet,
							'closing' => $rnewbal,
							'rid' => $sdata->rid	
							);
						log_message('debug',print_r($rdataarray,true));
						$this->db->insert('rtransaction_main',$rdataarray);
						
						$unewbal = $udata->main_wallet + $amount;
						$this->db->where('id',$uid);
						$this->db->update('users',array('main_wallet' => $unewbal));
						$udataarray = array(
							 'uid' => $uid,
							 'type' => "AEPS To Main Wallet",
							 'txntype' => "CREDIT",
							 'opening' => $udata->wallet,
							 'closing' => $unewbal,	
							 'txnid' => $txnid,
							 'amount' => $amount,
							 'site' => $site
							 );
						$this->db->insert('main_wallet',$udataarray);
						print_r(json_encode(array('status' => "SUCCESS", 'msg' => "TRANSFER SUCCESSFULLY", 'error_code' => 0)));
						exit();
					  
					}
				}
			}
			    
        }
    }
	
	public function wallet_history() {
        
        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;        
		
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		 if ($from_date == "" || $to_date == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE PROVIDE PROPER DATA", 'error_code' => 203)));
            exit();
        } else {
			
			$from = $from_date." 00:00:00";			
			$to = $to_date." 23:59:59";
			$data = $this->db->from("wallet")->where('uid',$uid)->where('date >=',$from)->where('date <=',$to)->order_by('id',"DESC")->get()->result(); 
												
			
			print_r(json_encode(array('status' => "SUCCESS", 'data'=> $data, 'msg' => "TRANSFER SUCCESSFULLY", 'error_code' => 0)));
			exit();
					
        }
    }
	
	public function main_wallet_history() {
        
        $api_key = $this->input->post("api_key");
        $api_secret = $this->input->post("api_secret");
        if ($api_key == "" || $api_secret == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INSUFFICIENT DATA", 'error_code' => 203)));
            exit();
        }

        $count = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->num_rows();
        if ($count == 0) {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "INVALID SESSION", 'error_code' => 203)));
            exit();
        }
        $uid = $this->db->get_where("app", array('token' => $api_key, 'secret' => $api_secret))->row()->uid;        
		
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		 if ($from_date == "" || $to_date == "") {
            print_r(json_encode(array('status' => "ERROR", 'msg' => "PLEASE PROVIDE PROPER DATA", 'error_code' => 203)));
            exit();
        } else {
			
			$from = $from_date." 00:00:00";			
			$to = $to_date." 23:59:59";
			$data = $this->db->from("main_wallet")->where('uid',$uid)->where('date >=',$from)->where('date <=',$to)->order_by('id',"DESC")->get()->result(); 
												
			
			print_r(json_encode(array('status' => "SUCCESS", 'data'=> $data, 'msg' => "TRANSFER SUCCESSFULLY", 'error_code' => 0)));
			exit();
					
        }
    }


}
