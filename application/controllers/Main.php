<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	public function index()
	{
		if (isset($_SESSION['uid'])) {   //if user login
		    $domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "MON" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
			$this->load->view('dashboard', $data);

		} else {
			// if user not login
			$domain = $_SERVER['HTTP_HOST'];
			/*echo base_url();
			echo '<br>';
			echo $domain;exit;
			*/
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "MON" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
			$this->load->view('login', $data);

		}

	}
	public function newlogin()
	{
	    $domain = $_SERVER['HTTP_HOST'];
	    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
		$logo = $sdata->logo;
		$title = $sdata->title;
		$auth = "MON" . rand(00000, 99999) . rand(00000, 99999);
		$_SESSION['auth'] = $auth;
		$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
	    $this->load->view('newlogin',$data);
	}
	public function forgotpass(){
	    if($_SESSION['auth'] == $this->input->post('auth')){
	        $this->load->view('forgotpass');
	    }else{
	        echo "INVALID TOKEN";
	    }
	}
	public function verifyforgotpass(){
	    if($_SESSION['auth'] == $this->input->post('auth')){
	        $user = $this->input->post('user');
	        if($user == ""){
	            echo "PLEASE SEND USERNAME";
	        }else{
	            $count = $this->db->get_where('users',array('username' => $user))->num_rows();
	            if($count <= 0){
	                echo "USERNAME NOT EXITS";
	            }else{
	                $user = $this->db->get_where('users',array('username' => $user))->row();
	                $otp = rand(11111,99999);
	                $_SESSION['otp'] = $otp;
	                $_SESSION['phone'] = $user->phone;
	                
	                $senderid = "MONSFT";
		            $phone = $user->phone;
        		    $message = " Dear User Your Password Reset OTP is ".$otp." And do not share this OTP with anyone, Thanks Team MOSFTY";
        		    $template = "1707165259121486813";
                    send_sms($senderid,$phone,$message,$template);
	                $this->load->view('forgototp');
	            }
	        }
	        
	    }else{
	        echo "INVALID TOKEN";
	    }
	}
	public function verifyotpfor(){
	    if($_SESSION['auth'] == $this->input->post('auth')){
	        $otp = $this->input->post('otp');
	        if($otp == ""){
	            echo "PLEASE SEND USERNAME";
	        }else{
	            if($otp == $_SESSION['otp']){
	                $this->load->view('forchangepass');
	            }else{
	                echo "INVALID OTP";
	            }
	        }
	        
	    }else{
	        echo "INVALID TOKEN";
	    }
	}
	public function verifychangepass(){
	    if($_SESSION['auth'] == $this->input->post('auth')){
	        $type = $this->input->post('type');
	        $pass = $this->input->post('pass');
	        $cpass = $this->input->post('cpass');
	        if($type == "" || $pass == "" || $cpass == ""){
	            echo "PLEASE SEND PROPER DATA";
	        }else{
	            if($type == "0"){
	                echo "PLEASE SEND ACTION TYPE";
	            }else{
	                if($pass == $cpass){
	                    if($type == "1"){
	                        //change password
	                        $this->db->update('users',array('password' => $pass),array('phone' => $_SESSION['phone']));
	                        echo 1;
	                        
	                    }elseif($type == "2"){
	                        //change pin
	                        $count = strlen($pass);
	                        if($count == "4"){
	                            $this->db->update('users',array('pin' => $pass),array('phone' => $_SESSION['phone']));
	                            echo 2;
	                        }else{
	                            echo "PLEASE SEND PIN ONLY 4 DEGIT";
	                        }
	                        
	                    }else{
	                        echo "ERROR";
	                    }
	                }else{
	                    echo "PASSWORD AND NEW PASS IS NOT MATCH";
	                }
	            }
	        }
	        
	    }else{
	        echo "INVALID TOKEN";
	    }
	}
	public function logout()
	{
	    session_destroy();
	    redirect('/');
	}
	public function login()
	{
		if ($_SESSION['auth'] == $this->input->post("auth")) {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$domain = $_SERVER['HTTP_HOST'];
	        
			if ($username != "" && $password != "") {
				$count = $this->db->get_where('users', array('username' => $username))->num_rows();
				if ($count > 0) {
					$user = $this->db->get_where('users', array('username' => $username))->row();
					$sit = $user->site;
					$sd = $this->db->get_where('sites',array('id' => $sit))->row();
					if($sd->domain != $domain){
					    echo "YOU ARE NOT AUTHORISE CONTACT TO ADMIN";
					    exit();
					}
					if($user->active != 1)
					{
					    echo "Your Account is Disabled. Please Contact to Administrator";
					    exit();
					}
					
					
					if ($password == $user->password) {
						$_SESSION['pin'] = $user->pin;
						$_SESSION['pid'] = $user->id;
						$_SESSION['role'] = $user->role;

						$this->load->view('loginpin');
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
	public function verify()
	{
		if ($_SESSION['auth'] == $this->input->post("auth")) {
			if (isset($_SESSION['pid']))
			{
			    
			    
			    
			    $log = $this->input->post("log");
			    $lat = $this->input->post("lat");
			    if($log != "" && $lat != "")
			    {
			    
			    
			    
			    
				if ($_SESSION['pin'] == $this->input->post("pin")) {
					$_SESSION['uid'] = $_SESSION['pid'];
					
					$username = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row()->username;
					
					$data = array(
					    
					    'username' => $username,
					    'ip' => $_SERVER['REMOTE_ADDR'],
					    'log' => $log,
					    'lat' => $lat,
					    'type' => "USER"
					   	
					    
					    );
					    $this->db->insert('loginlog',$data);
					echo "1";

				} else {

					echo "PIN NOT MATCHED";
				}
				
				
			    }else{
			        
			        echo "ERROR IN LOCATION V2";
			    }
				
				
				
				
				
				
				

			} else {

				echo "ERROR OCCURED.";
			}
		} else {

			echo "INVALID TOKEN";
		}

	}
	
	/*Code Change by Krishna Main-20220423 start*/
	 public function checkop()
    {
        $mobile = $this->input->post("mobile");
        $apikey = $this->db->get_where('settings',array('name' => 'api_key'))->row()->value;
        
        $this->load->helper('recharge');
        
        $url = "https://api.softpayapi.com/api/Operator/OperatorInformation?api_key=CZ791105NM5AYLUA6FGHRSBD3C6QI72XW8KT2BVE38OD0J9P44"."&mobile_number=".$mobile;
      
        $result = curl_get_file_contents($url);
        $data = json_decode($result);
        //log_message('debug',print_r($data,TRUE));
       ///print_r($data);exit;
        $op = $data->Operator;
        $op_code = $data->Operatorcode;
        $circle_code=$data->Circlecode;
        $_SESSION['circ'] = $data->Circlecode;
        $_SESSION['opcode'] = $op_code;
        if($op == "Jio"){
            echo "3"."__@__".$circle_code."__@__".$op_code;
        }elseif($op == "Vodafone Idea"){
            echo "2"."__@__".$circle_code."__@__".$op_code;
        }elseif($op == "BSNL"){
            echo "1"."__@__".$circle_code."__@__".$op_code;
        }elseif($op == "Airtel"){
            echo "0"."__@__".$circle_code."__@__".$op_code;
        }else{
            echo "ERROR";
        }
        exit;
        
    }
    
 public function viewplannew()
    {
        $operator = $this->input->post('operator');
        $circle = $this->input->post('circle');
        $opdtl = $this->db->get_where('rechargev2op',array('id' => $operator))->row();
        $cdtl = $this->db->get_where('circle',array('name' => $circle))->row();
        $opcode=$opdtl->opcode_v;
        $opname=$opdtl->name;
        
        $this->load->helper('recharge');
        $responce = viewplans($circle,$opcode);
	
        $data = json_decode($responce);
        //print_r($data);exit;
        //$rec = $data->Data;
        //$details = json_encode($rec);
        if($data->Status == "Success"){
            $dat = array('op' => $opname,'circle' => $cdtl->code,'data' => $data->Data);
            $this->load->view('viewplan',$dat);
        }
    }
    
	public function recharge()
	{
	    if (isset($_SESSION['uid'])) {   //if user login
			$domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "MON" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
			$this->load->model('recharge_model');
            $resdata = $this->recharge_model->getRechargeTxnlist();
            $data['resdata'] = $resdata;
			
			$curernt_api = $this->db->get_where('settings',array('name' => 'recharge_api'))->row();
			if($curernt_api->value=="CYRUS")
			{
				$this->load->view('recharge', $data);
			}else{
				$this->load->view('lapu_recharge', $data);
			}
			
			
	    }else{
	        redirect('/');
	    }
	}
	public function drecharge()
	{
	    if (isset($_SESSION['uid'])) {   //if user login
			$domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "MON" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
			$this->load->model('recharge_model');
            $resdata = $this->recharge_model->getRechargeTxnlist();
            $data['resdata'] = $resdata;
			$curernt_api = $this->db->get_where('settings',array('name' => 'recharge_api'))->row();
			if($curernt_api->value=="CYRUS")
			{
				$this->load->view('drecharge', $data);
			}else{
				$this->load->view('lapu_drecharge', $data);
			}
			
	    }else{
	        redirect('/');
	    }
	}
	
	/*Code Changes By Krishna-MD-250422*/
	
	public function dorecharge()
	{
	    if(isset($_SESSION['uid'])){
	        if ($_SESSION['auth'] == $this->input->post("auth")) {
	            // check admin service 
	            $aservice = $this->db->get_where('aservice',array('id' => '1'))->row()->recharge;
	            if($aservice != "1"){
					echo json_encode(array('status'=>'failed','response'=>'SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN'));
	                //echo "SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN";
	                exit();
	            }
	            //check whitelabel 
	            $user = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row();
	            $rid = $this->db->get_where('sites',array('id' => $user->site))->row()->rid;
	            $rservice = $this->db->get_where('reseller',array('id' => $rid))->row()->recharge;
	            if($rservice != "1"){
	                //echo "SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN";
					echo json_encode(array('status'=>'failed','response'=>'SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN'));
	                exit();
	            }
	            //check reseller service 
	            $service = $this->db->get_where('service',array('site' => $user->site))->row()->recharge;
	            if($service != "1"){
	                //echo "SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN";
					echo json_encode(array('status'=>'failed','response'=>'SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN'));
	                exit();
	            }
	            //check user 
	            if($user->recharge != "1"){
	                //echo "SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN";
					echo json_encode(array('status'=>'failed','response'=>'SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN'));
	                exit();
	            }

	            $uid = $_SESSION['uid'];
	            $udata = $this->db->get_where('users',array('id' => $uid))->row();
	            $site = $udata->site;
	            $sdata = $this->db->get_where('sites',array('id' => $site))->row();
	            $rdata = $this->db->get_where('reseller',array('id' => $sdata->rid))->row();
	            log_message('debug',print_r($rdata,true));
			    $mobile = $this->input->post('mobile');
			    $amount = $this->input->post('amount');
			    $operator = $this->input->post('operator');
			    $circle = $this->input->post('circle');
			    if($mobile == "" || $amount == "" || $operator == "" ||$circle == ""){
			        //echo "PLEASE FILL ALL DETAILS";
					echo json_encode(array('status'=>'failed','response'=>'PLEASE FILL ALL DETAILS'));
			    }else{
			        if($amount <= 0){
			            //echo "INVALID AMOUNT";
						echo json_encode(array('status'=>'failed','response'=>'INVALID AMOUNT'));
			        }else{
			            //check user wallet
			            
			            if($amount >= $udata->main_wallet){
			                //echo "INSUFFICIENT FUND";
							echo json_encode(array('status'=>'failed','response'=>'INSUFFICIENT FUND'));
			            }else{
			                //check reseller wallet
			                if($amount >= $rdata->main_wallet){
			                    //echo "TECHNICAL ISSUE CONTACT TO ADMIN";
								echo json_encode(array('status'=>'failed','response'=>'TECHNICAL ISSUE CONTACT TO ADMIN'));
			                }else{
			                    
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
			                   echo json_encode(array('status'=>'success','response'=>'Success'));
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
							   echo json_encode(array('status'=>'success','response'=>'TRANSACTION PENDING'));
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
								   echo json_encode(array('status'=>'failed','response'=>'TRANSACTION FAILED'));
			                   }else{
								   echo json_encode(array('status'=>'failed','response'=>'ERROR'));
			                      // echo "ERROR";
			                       exit();
			                   }
			                    
			                }
			            }
			        }
			    }
    		} else {
    
    			echo "INVALID TOKEN";
    		}
	    }else{
	        redirect('/');
	    }
		


	}
	
	public function dorecharge_lapu()
	{
	    if(isset($_SESSION['uid'])){
	        if ($_SESSION['auth'] == $this->input->post("auth")) {
	            // check admin service 
	            $aservice = $this->db->get_where('aservice',array('id' => '1'))->row()->recharge;
	            if($aservice != "1"){
					echo json_encode(array('status'=>'failed','response'=>'SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN'));
	                //echo "SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN";
	                exit();
	            }
	            //check whitelabel 
	            $user = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row();
	            $rid = $this->db->get_where('sites',array('id' => $user->site))->row()->rid;
	            $rservice = $this->db->get_where('reseller',array('id' => $rid))->row()->recharge;
	            if($rservice != "1"){
	                //echo "SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN";
					echo json_encode(array('status'=>'failed','response'=>'SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN'));
	                exit();
	            }
	            //check reseller service 
	            $service = $this->db->get_where('service',array('site' => $user->site))->row()->recharge;
	            if($service != "1"){
	                //echo "SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN";
					echo json_encode(array('status'=>'failed','response'=>'SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN'));
	                exit();
	            }
	            //check user 
	            if($user->recharge != "1"){
	                //echo "SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN";
					echo json_encode(array('status'=>'failed','response'=>'SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN'));
	                exit();
	            }

	            $uid = $_SESSION['uid'];
	            $udata = $this->db->get_where('users',array('id' => $uid))->row();
	            $site = $udata->site;
	            $sdata = $this->db->get_where('sites',array('id' => $site))->row();
	            $rdata = $this->db->get_where('reseller',array('id' => $sdata->rid))->row();
	            log_message('debug',print_r($rdata,true));
			    $mobile = $this->input->post('mobile');
			    $amount = $this->input->post('amount');
			    $operator = $this->input->post('operator');
			    $circle = $this->input->post('circle');
			    if($mobile == "" || $amount == "" || $operator == "" ||$circle == ""){
			        //echo "PLEASE FILL ALL DETAILS";
					echo json_encode(array('status'=>'failed','response'=>'PLEASE FILL ALL DETAILS'));
			    }else{
			        if($amount <= 0){
			            //echo "INVALID AMOUNT";
						echo json_encode(array('status'=>'failed','response'=>'INVALID AMOUNT'));
			        }else{
			            //check user wallet
			            
			            if($amount >= $udata->main_wallet){
			                //echo "INSUFFICIENT FUND";
							echo json_encode(array('status'=>'failed','response'=>'INSUFFICIENT FUND'));
			            }else{
			                //check reseller wallet
			                if($amount >= $rdata->main_wallet){
			                    //echo "TECHNICAL ISSUE CONTACT TO ADMIN";
								echo json_encode(array('status'=>'failed','response'=>'TECHNICAL ISSUE CONTACT TO ADMIN'));
			                }else{
			                    
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
			                   echo json_encode(array('status'=>'success','response'=>'Success'));
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
								   echo json_encode(array('status'=>'failed','response'=>'TRANSACTION FAILED'));
			                   }else{
								   echo json_encode(array('status'=>'failed','response'=>'ERROR'));
			                      // echo "ERROR";
			                       exit();
			                   }
			                    
			                }
			            }
			        }
			    }
    		} else {
    
    			echo "INVALID TOKEN";
    		}
	    }else{
	        redirect('/');
	    }
		


	}
	
	public function pan()
	{
	    if (isset($_SESSION['uid'])) {   //if user login
			$domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "MON" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
			$this->load->view('pan', $data);
	    }else{
	        redirect('/');
	    }
	}
	public function utipsa()
	{
	    if (isset($_SESSION['uid'])) {   //if user login
			if ($_SESSION['auth'] == $this->input->post("auth")) {
			    
			    // check admin service 
	            $aservice = $this->db->get_where('aservice',array('id' => '1'))->row()->uti;
	            if($aservice != "1"){
	                echo "SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN";
	                exit();
	            }
	            //check whitelabel 
	            $user = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row();
	            $rid = $this->db->get_where('sites',array('id' => $user->site))->row()->rid;
	            $rservice = $this->db->get_where('reseller',array('id' => $rid))->row()->uti;
	            if($rservice != "1"){
	                echo "SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN";
	                exit();
	            }
	            //check reseller service 
	            $service = $this->db->get_where('service',array('site' => $user->site))->row()->uti;
	            if($service != "1"){
	                echo "SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN";
	                exit();
	            }
	            //check user 
	            if($user->uti != "1"){
	                echo "SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN";
	                exit();
	            }
			    
			    
			    $name = $this->input->post("name");
                $mobile = $this->input->post("mobile");
                $email = $this->input->post("email");
                $shop = $this->input->post("shop");
                $adhaar = $this->input->post("adhaar");
                $pan = $this->input->post("pan");
                $address = $this->input->post("address");
                $state = $this->input->post("state");
                $pin = $this->input->post("pin");
                $api_key = $this->db->get_where('settings',array('name' =>"api_key"))->row()->value;
                $psaid = $this->db->get_where('settings',array('name' =>"uti_prefix"))->row()->value.$mobile;
                if($name != "" && $mobile != "" && $email != "" && $shop != "" && $adhaar != "" && $pan != "" && $address != "" && $state != "" && $pin != "" && $psaid != ""){
                    
                    $url = 'https://partner.ecuzen.in/api/createpsa'; 
            	$data = array(                                   
            		'api_key' => $api_key,
            		'psaid' => $psaid,
            		'mobile' => $mobile,
            		'email' =>$email,
            		'shop' => $shop,
            		'name' => $name,
            		'pan' => $pan,
            		'pincode' => $pin,
            		'location' => $address,
            		'adhaar' => $adhaar,
            		'state' => $state
            	
            	);
            
            
            
            $cURLConnection = curl_init($url);
            curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $data);
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
            
            $apiResponse = curl_exec($cURLConnection);
            curl_close($cURLConnection);
            
            $data = json_decode($apiResponse);
            $status = $data->status;
            $udata = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row();
	        $site = $udata->site;
            
            if($status == "SUCCESS")
            {
                
                 $dat = array(
                'uid' => $_SESSION['uid'],
                'psaid' => $psaid,
                'name' => $name,
                'mobile' =>$mobile,
                'email' => $email,
                'shop' => $shop,
                'location' => $address,
                'state' => $state,
                'pincode' => $pin,
                'adhaar'=>$adhaar,
                'pan' => $pan,
                'status' => "PENDING",
                'site' => $site
            );
            
            $this->db->insert('psa',$dat);
                
            echo 1;
            }else{
                echo "TECHNICAL ISSUE OCCURRED. PLEASE TRY AGAIN LATER.";
            }   
                    
                }else{
                    echo "PLEASE SEND ALL DATA";
                }
			}else{
			    echo "INVALID TOKEN";
			}
	    }else{
	        redirect('/');
	    }
	}
	public function utiparse()
    {
        if(isset($_SESSION['uid'])){
            
        
       	if ($_SESSION['auth'] == $this->input->post("auth")) 
       	{

            $qty = $this->input->post("qty");
            $package = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row()->package;
            $cost = $this->db->get_where('coponcharge',array('package' => $package))->row()->amount;
            $amount = $cost*$qty;
            
            echo $amount;
        }else{
            echo "INVALID TOKEN";
        }
        }else{
            redirect('/');
        }
     	    
    }
    public function getpurchase()
    {
        if(isset($_SESSION['uid']))
        {
            if($_SESSION['auth'] == $this->input->post('auth'))
            {
                // check admin service 
	            $aservice = $this->db->get_where('aservice',array('id' => '1'))->row()->uti;
	            if($aservice != "1"){
	                echo "SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN";
	                exit();
	            }
	            //check whitelabel 
	            $user = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row();
	            $rid = $this->db->get_where('sites',array('id' => $user->site))->row()->rid;
	            $rservice = $this->db->get_where('reseller',array('id' => $rid))->row()->uti;
	            if($rservice != "1"){
	                echo "SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN";
	                exit();
	            }
	            //check reseller service 
	            $service = $this->db->get_where('service',array('site' => $user->site))->row()->uti;
	            if($service != "1"){
	                echo "SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN";
	                exit();
	            }
	            //check user 
	            if($user->uti != "1"){
	                echo "SERVICE PROVIDER DOWN PLEASE CONTACT TO ADMIN";
	                exit();
	            }
                $qty = $this->input->post("qty");
		        $package = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row()->package;
		        $cost = $this->db->get_where('coponcharge',array('package' => $package))->row()->amount;
		        $wallet = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row()->wallet;
		        $amount = $cost*$qty;
		        $api_key = $this->db->get_where('settings',array('name' => "api_key"))->row()->value;
		        $psaid = $this->db->get_where('psa',array('uid' => $_SESSION['uid']))->row()->psaid;
		        //check wallet balance
		        if($wallet >=$amount)
		        {
		            $udata = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row();
	                $site = $udata->site;
                    $rid= $this->db->get_where('sites',array('id' => $site))->row()->rid;
                    $walletbalance = $this->db->get_where('reseller',array('id' => $rid))->row()->wallet;
                    //verify reseller balance
                    if($amount > $walletbalance)
                    {
                        echo "SERVICE ERROR CONTACT TO ADMIN";
                        exit();
                    }
		            //working
		                
		                
	                $url = 'https://partner.ecuzen.in/api/requestcopon'; 
	                $data = array(                                   
	                	'api_key' => $api_key,
                	    'psa_id' => $psaid,
	                	'quantity' => $qty
	                	);

                    $cURLConnection = curl_init($url);
                    curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
                    $apiResponse = curl_exec($cURLConnection);
                    curl_close($cURLConnection);
                    $data = json_decode($apiResponse);
                    $status = $data->status;
                    $txn = $data->txnid;
                    
                      //working end
                    if($status == "PENDING")
                    {
		                $newbalance = $wallet-$amount;
		                $this->db->update('users', array('wallet' => $newbalance), array('id' => $_SESSION['uid']));
		                $txnid = "UTI".rand(11111111,999999999);
		                           $udataarray = array(
			                         'uid' => $uid,
			                         'txnid' => $txnid,
			                         'qty' => $qty,
			                         'amount' => $amount,
			                         'status' => $status,
			                         'response' => $apiResponse,
			                         'site' => $site
			                         );
			                   $this->db->insert('pancoupontxn',$udataarray);
			                   $udataarray = array(
			                       

			                         'uid' => $uid,
			                         'type' => "PAN",
			                         'txntype' => "DEBIT",
			                         'opening' => $wallet,
			                         'closing' => $newbalance,	
			                         'txnid' => $txnid,
			                         'amount' => $amount,
			                         'site' => $site
			                         );
			                   $this->db->insert('wallet',$udataarray);
                             	
						//entry for reseller
                        //entry for UTI COPON SUCCESS TRANSACTION
                        $udata = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row();
    	                $site = $udata->site;
                        $rid= $this->db->get_where('sites',array('id' => $site))->row()->rid;
                        $walletbalance = $this->db->get_where('reseller',array('id' => $rid))->row()->wallet;
                                  //adding amount to reseller Wallet
                        $rnewbalance = $walletbalance - $amount;
                        $this->db->update('reseller',array('wallet' => $rnewbalance),array('id' => $rid));
                                  
                        //adding end 
                        //making entry
                      
                        $rdata = array(
                       
                            'type' => "UTICOPON",
                            'txnid' => $txnid,
                            'amount' => $amount,
                            'closing' => $rnewbalance,
                            'opening' => $walletbalance,
                            'rid' => $rid
                        );                                   
                        $this->db->insert('rtransaction',$rdata);
                        //entry for reseller ends
                        //commission 
                        $uid = $_SESSION['uid'];
                        $this->load->model('Pan_model');
			            $this->recharge_model->pancommission($uid,$qty,$txnid,$site);
                        
						echo 1;
                    }else{
                        echo "ERROR OCCURED. PLEASE TRY AGAIN LATER.";
                    }
    		    }else{
    		        echo "INSUFFICIENT BALANCE";
    		    }
            }else{
                echo "TOKEN MISMATCH";
            }
        }else{
            echo "SESSION EXPIRED";
        }
    }
    public function addfund()
	{
	    if (isset($_SESSION['uid'])) {   //if user login
			$domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "MON" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
			$this->load->view('addfund', $data);
	    }else{
	        redirect('/');
	    }
	}
	
	public function topup()
	{
	    if (isset($_SESSION['uid'])) {   //if user login
			$domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "MON" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
			$this->load->view('topup', $data);
	    }else{
	        redirect('/');
	    }
	}
	
	public function addfundreq()
	{
	    if (isset($_SESSION['uid'])) {   //if user login
			if($_SESSION['auth'] == $this->input->post('auth')){
			    if(isset($_POST['submit'])){
			        $bank = $this->input->post('bank');
			        $amount = $this->input->post('amount');
			        $rrn = $this->input->post('rrn');
			        $transaction_date = $this->input->post('transaction_date');
			        if($bank == "" || $amount == "" || $rrn == "" || $transaction_date == ""){
			            ?>
                            <script>
                                alert('Please Send Proper Data');
                                location.replace('/main/addfund');
                            </script>
                        <?php
			        }else{
			            if($amount <= 0){
			                ?>
                                <script>
                                    alert('INVALID AMOUNT');
                                    location.replace('/main/addfund');
                                </script>
                            <?php
			            }else{
			                $config['upload_path']          = './uploads/';
                        $config['allowed_types']        = 'jpg|jpeg|png|pdf';
                        $config['max_size']             = 1024;
                        $this->load->library('upload', $config);
        	             if ( ! $this->upload->do_upload('image'))
                        {
                                $error =  $this->upload->display_errors();
                                ?>
                                    <script>
                                        alert('<?php print_r($error); ?>');
                                        location.replace('/main/addfund');
                                    </script>
                                <?php
                                
                        }
                        else
                        {
                                $data = $this->upload->data();
                               $proof = base_url()."/uploads/".$data['file_name'];
                        }
                        $site = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row()->site;
                        $txnid = "TOPUP".rand(1111111111,9999999999);
                        $ardata = array(
                            'amount' => $amount,
                            'txnid' => $txnid,
                            'proof' => $proof,
                            'status' => "PENDING",
                            'bank' => $bank,
                            'uid' => $_SESSION['uid'],
                            'rrn' => $rrn,
                            'transaction_date' => $transaction_date,
                            'site' => $site
                            );
                        $this->db->insert('topup',$ardata);
                        ?>
                            <script>
                                alert('Request Submit');
                                location.replace('/main/addfund');
                            </script>
                        <?php
			            }
			            
                        
			        }
			    }else{
			        redirect('/main/addfund');
			    }
			}else{
			    ?>
			        <script>
			            alert('INVALID TOKEN');
			            location.replace('/main/addfund');
			        </script>
			    <?php
			}
	    }else{
	        redirect('/');
	    }
	}
	
	public function searchtxn()
	{
	    if(isset($_SESSION['uid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $afrom = $this->input->post('from');
	            $ato = $this->input->post('to');
	            $type = $this->input->post('type');
	            if($afrom == "" || $ato == "" || $type == ""){
	                echo 2;
	                exit();
	            }
	            //set from
	            $farray = explode('/', $afrom);
	            $fnar = array('0' => $farray[2],'1' => $farray[0],'2' => $farray[1]);
	            $nfrom = implode('-',$fnar);
	            $from = $nfrom." 00:00:00";
	            //set to
	            $tarray = explode('/', $ato);
	            $tnar = array('0' => $tarray[2],'1' => $tarray[0],'2' => $tarray[1]);
	            $nto = implode('-',$tnar);
	            $to = $nto." 23:59:59";
	            $data = array('from' => $from,'to' => $to);
	            if($type == "aeps"){
	                $this->load->view('transaction/aeps',$data);
	            }elseif($type == "naeps"){
	                $this->load->view('transaction/naeps',$data);
	            }elseif($type == "recharge"){
	                $this->load->view('transaction/recharge',$data);
	            }elseif($type == "pan"){
	                $this->load->view('transaction/pan',$data);
	            }elseif($type == "dmr"){
	                $this->load->view('transaction/dmr',$data);
	            }elseif($type == "payout"){
	                $this->load->view('transaction/payout',$data);
	            }elseif($type == "qtransfer"){
	                $this->load->view('transaction/qtransfer',$data);
	            }elseif($type == "ledger"){
	                $this->load->view('transaction/ledger',$data);
	            }elseif($type == "mwledger"){
	                $this->load->view('transaction/mwledger',$data);
	            }elseif($type == "topupledger"){
	                $this->load->view('transaction/topupledger',$data);
	            }
				else{
	                echo "ERROR";
	            }
	        }else{
	            echo 1;
	        }
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function kyc()
	{
	    if (isset($_SESSION['uid'])) {   //if user login
			$domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "MON" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
			$this->load->view('user_kyc', $data);
	    }else{
	        redirect('/');
	    }
	}
	
		public function kyc_data()
	{
	    if (isset($_SESSION['uid'])) {   //if user login
			$domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "MON" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
			$this->load->view('kycdata', $data);
	    }else{
	        redirect('/');
	    }
	}
	
	
	
	
	public function pan_validte()
	{
	    	$token = $this->input->post('token');
	    	$patron_id = $this->input->post('patron_id');
	    	$pan = $this->input->post('pan');
		
	        
			if ($token != "" && $patron_id != "" && $pan != "" ) {
			    
			    
			   


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://signzy.tech/api/v2/patrons/$patron_id/panv2",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\"task\":\"...task..\",\"essentials\":{\"number\":\"$pan_\"}}",
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
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}

	    }
	}
	
	
	
		public function user_kycc()
	{
	    	$request_id = $this->input->post('request_id');
	    	$token = $this->input->post('token');
	    	$patron_id = $this->input->post('patron_id');
		
	        
			if ($request_id != "" && isset($_SESSION['uid'])) {
			    
			    
			    $user = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row();
                    
                $this->db->update('users',array('request_id' => $request_id,'token' => $token,'patron_id' => $patron_id),array('id' => $_SESSION['uid']));
              
// 			$domain = $_SERVER['HTTP_HOST'];
// 		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
// 			$logo = $sdata->logo;
// 			$title = $sdata->title;
// 			$auth = "MON" . rand(00000, 99999) . rand(00000, 99999);
// 			$_SESSION['auth'] = $auth;
// 			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
// 			$this->load->view('kycdata', $data);
	    }
	    
	    
	}
	
		public function after_kyc()
	{
	    
	   // $request_id=$_GET['requestId'];
	   // echo  $request_id;exit;
	    $user = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row();
                    
                    
                     
                    $requestId=$user->request_id;
                    $token=$user->token;
                    $patron_id=$user->patron_id;
	    
	    if (isset($_SESSION['uid'])) {   //if user login
	    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://signzy.tech/api/v2/patrons/$patron_id/digilockers",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\"task\":\"getEadhaar\", \"essentials\": {\"requestId\": \"$requestId\"},\"redirectUrl\": \"S\",\"redirectTime\": \"2\"}",
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
  echo "cURL Error #:" . $err;
} else {
  $arr=json_decode($response);
  $aadhar_name=$arr->result->name;
  $uid=$arr->result->uid;
  $dob=$arr->result->dob;
  $gender=$arr->result->gender;
  $photo=$arr->result->photo;
  $district=$arr->result->splitAddress->district[0];
  $state=$arr->result->splitAddress->state[0][0];
  $pincode=$arr->result->splitAddress->pincode;
  $city=$arr->result->splitAddress->city[0];
  $address=$arr->result->splitAddress->addressLine;
}                  


$re = '/:[A-Z]*.[A-Z]*/';
$str = $address;

preg_match($re, $str, $matches, PREG_OFFSET_CAPTURE, 0);
    
// Print the entire match result

$matches= str_replace(":","",$matches[0][0]);


$data = array(
                        'uid' =>  $_SESSION['uid'],
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
                        $this->db->insert('kyc',$data);
	    
			$domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "MON" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
			$this->load->view('kycdata', $data);
	    }else{
	        redirect('/');
	    }
	}

	
	public function uploadkyc()
	{
	    if (isset($_SESSION['uid'])) {   //if user login
			
		
			$pan_name = $this->input->post('pan_name');
			$adhaar = $this->input->post('aadhar');
	
			$pan = $this->input->post('pan');
		
			$adhaarimg = $this->input->post('aadharimg');
			$panimg = $this->input->post('panimg');
			$shopname = $this->input->post('shopname');
			$shopaddress = $this->input->post('shopaddress');
			
			$adhaar_back = $this->input->post('aadhar_back');
		
			
			
			
			
			
			if($pan == "" || $shopname == "" || $shopaddress == ""){
			    ?>
			        <script>
			            alert('Please Send Proper Data');
			            location.replace("/");
			        </script>
			    <?php
			}else{
			    $agree = $this->input->post('agree');
			    if($agree == ""){
			        ?>
    			        <script>
    			            alert('Please Agree Treams And Conditions');
    			            location.replace("/");
    			        </script>
			        <?php
			    }else{
			        $config['upload_path']          = './uploads/';
                    $config['allowed_types']        = 'jpg|jpeg|png|pdf';
                    $config['max_size']             = 1024;
                    $this->load->library('upload', $config);
    	             if ( ! $this->upload->do_upload('aadharimg'))
                    {
                            $error =  $this->upload->display_errors();
                            ?>
                                <script>
                                    alert('<?php print_r($error); ?>');
                                    location.replace('/');
                                </script>
                            <?php
                            
                    }
                    else
                    {
                            $data = $this->upload->data();
                           $adhaarimg = base_url()."/uploads/".$data['file_name'];
                            
                    }
                    $config['upload_path']          = './uploads/';
                    $config['allowed_types']        = 'jpg|jpeg|png|pdf';
                    $config['max_size']             = 1024;
                    $this->load->library('upload', $config);
    	             if ( ! $this->upload->do_upload('aadhar_back'))
                    {
                            $error =  $this->upload->display_errors();
                            ?>
                                <script>
                                    alert('<?php print_r($error); ?>');
                                    location.replace('/');
                                </script>
                            <?php
                            
                    }
                    else
                    {
                            $data = $this->upload->data();
                           $adhaar_back = base_url()."/uploads/".$data['file_name'];
                            
                    }
                    
                    $config['upload_path']          = './uploads/';
                    $config['allowed_types']        = 'jpg|jpeg|png|pdf';
                    $config['max_size']             = 1024;
                    $this->load->library('upload', $config);
    	             if ( ! $this->upload->do_upload('panimg'))
                    {
                            $error =  $this->upload->display_errors();
                            ?>
                                <script>
                                    alert('<?php print_r($error); ?>');
                                    location.replace('/');
                                </script>
                            <?php
                            
                    }
                    else
                    {
                            $data = $this->upload->data();
                           $panimg = base_url()."/uploads/".$data['file_name'];
                            
                    }
                    $user = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row();
                    $data = array(
                        'uid' => $user->id,
                        
                        'pan_name' => $pan_name,
                        'adhaar' => $adhaar,
                        
                        'pan' => $pan,
                      
                        'adhaarimg' => $adhaarimg,
                        'panimg' => $panimg,
                        'shopname' => $shopname,
                        'shopaddress' => $shopaddress,
                        'active' => "0",
                        'site' => $user->site,
                        
                        'adhaarback' => $adhaar_back
                        
                        
                        
                        

                        
                        
                        
                        );
                        
                        $this->db->update('kyc',$data,array('uid' => $_SESSION['uid']));
                        ?>
                            <script>
                                alert('KYC SUCCESSFULL SUBMITED');
                                
                            </script>
                        <?php
                        $domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "MON" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
			$this->load->view('pending', $data);
			    }
			}
	    }else{
	        redirect('/');
	    }
	}
	public function listmember()
	{
	    if (isset($_SESSION['uid'])) {   //if user login
			$domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "MON" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
			$this->load->view('listmember', $data);
	    }else{
	        redirect('/');
	    }
	}
	public function profile()
	{
	    if (isset($_SESSION['uid'])) {   //if user login
			$domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "MON" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
			$this->load->view('profile', $data);
	    }else{
	        redirect('/');
	    }
	}
	public function setting()
	{
	    if (isset($_SESSION['uid'])) {   //if user login
			$domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "MON" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
			$this->load->view('setting', $data);
	    }else{
	        redirect('/');
	    }
	}
	public function changepass()
	{
	    if (isset($_SESSION['uid'])) {   //if user login
			if($_SESSION['auth'] == $this->input->post('auth')){
			    $pass = $this->input->post('pass');
			    $newpass = $this->input->post('newpass');
			    $cpass = $this->input->post('cpass');
			    if($pass == "" || $newpass == "" || $cpass == ""){
			        echo "PLEASE FILL ALL DETAILS";
			    }else{
			        if($newpass == $cpass){
			            $check = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row()->password;
			            if($check == $pass){
			                $this->db->update('users',array('password' => $newpass),array('id' => $_SESSION['uid']));
			                echo 1;
			            }else{
			                echo "OLD PASSWORD IS NOT MATCH";
			            }
			        }else{
			            echo "PASSWORD AND CONFIRM PASSWORD IS NOT MATCH";
			        }
			    }
			}else{
			    echo "INVALID TOKEN";
			}
	    }else{
	        redirect('/');
	    }
	}
	public function changepin()
	{
	    if (isset($_SESSION['uid'])) {   //if user login
			if($_SESSION['auth'] == $this->input->post('auth')){
			    $pass = $this->input->post('pass');
			    $newpass = $this->input->post('newpass');
			    $cpass = $this->input->post('cpass');
			    if($pass == "" || $newpass == "" || $cpass == ""){
			        echo "PLEASE FILL ALL DETAILS";
			    }else{
			        if($newpass == $cpass){
			            $check = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row()->pin;
			            if($check == $pass){
			                $count = strlen($newpass);
			                if($count == "4"){
			                    $this->db->update('users',array('pin' => $newpass),array('id' => $_SESSION['uid']));
			                    echo 1;
			                }else{
			                    echo "PLEASE SEND 4 DEGIT OF PIN";
			                }
			             
			            }else{
			                echo "OLD PIN IS NOT MATCH";
			            }
			        }else{
			            echo "PIN AND CONFIRM PIN IS NOT MATCH";
			        }
			    }
			}else{
			    echo "INVALID TOKEN";
			}
	    }else{
	        redirect('/');
	    }
	}
	public function registration()
	{
	    if (isset($_SESSION['uid'])) {   //if user login
			$domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "MON" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
			$this->load->view('registration', $data);
	    }else{
	        redirect('/');
	    }
	}
	public function setpack()
	{
	    if (isset($_SESSION['uid'])) {   //if user login
		  
		          
		          $role = $this->input->post("role");
		          $site = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row()->site;
		          $pks = $this->db->get_where('package',array('role' => $role))->result();
		          foreach($pks as $pk)
		          {
		              echo '<option value="'.$pk->id.'">'.$pk->name.'</option>';
		              
		          }
		     
	    	}else{
	    	    
	    	    echo "SESSION EXPIRED";
	    	}
	    
	}
	public function memberreg()
	{
	    if(isset($_SESSION['uid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $name = $this->input->post('name');
	            $mobile = $this->input->post('mobile');
	            $email = $this->input->post('email');
	            $role = $this->input->post('role');
	            $pkg = $this->input->post('pkg');
	            
	            $site = $this->db->get_where('sites',array('rid' => $_SESSION['rid']))->row()->id;
	            if($name == "" || $mobile == "" || $email == "" || $role == "" || $pkg == ""){
	                echo "Please Fill All Data";
	            }else{
	                $cmobile = $this->db->get_where('users',array('phone' => $mobile,'site'=>$site))->num_rows();
	                if($cmobile > 0){
	                    echo "Mobile Already Exits";
	                }else{
	                    $cmail = $this->db->get_where('users',array('email' => $email,'site'=>$site))->num_rows();
	                    if($cmail > 0){
	                        echo "Email Already Exits";
	                    }else{
	                        if($role == 2){
	                            $username = "SH".rand(111111,999999);
	                        }elseif($role == 3){
	                            $username = "MD".rand(111111,999999);
	                        }elseif($role == 4){
	                            $username = "DT".rand(111111,999999);
	                        }elseif($role == 5){
	                            $username = "RT".rand(111111,999999);
	                        }else{
	                            echo "ERROR";
	                            exit();
	                        }
	                        $password = rand(111111,999999);
	                        $pin = rand(1111,9999);
	                        $profile = "https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg";
	                        $rdata = array(
                                'name' => $name,
                                'username' => $username,
                                'password' => $password,
                                'email' => $email,
                                'phone' => $mobile,
                                'wallet' =>  "0",
                                'active' => "1",
                                'otp' => "1234",
                                'package' => $pkg,
                                'role' => $role,
                                'owner' => $_SESSION['uid'],
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
	                       $this->db->insert('users',$rdata);
	                       
	                       $reseller = $this->db->get_where('reseller',array('id' => $_SESSION['rid']))->row();
	                       $company_nm=$reseller->name;
	                       
	                       $senderid = "MONSFT";
	                       $message = "Dear".$name." Welcome To ".$company_nm." , Your New account Cretated Sucessfully, Your Login User name Is ".$username.", Password ".$password." And Login Pin ".$pin.", Thanks Team MOSFTY";
        		           $template = "1707165259142274391";
                           send_sms($senderid,$mobile,$message,$template);
	                       echo "1";
	                    }
	                }
	            }
	        }else{
	            echo "INVALID TOKEN";
	        }
	    }else{
	        redirect('/');
	    }
	}
	
	
	
	 /*COde By KRishna- RC-250422*/     
     public function get_last_rechargetxn(){
       $this->load->model('recharge_model');
       $resdata=$this->recharge_model->getRechargeTxnlist();
       $data['resdata']=$resdata;
       $this->load->view('rechargetxnlist',$data);
     }
	 
	public function wallettransfer()
	{
	    if (isset($_SESSION['uid'])) {   //if user login
			$domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "MON" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
			$this->load->model('recharge_model');
            
			$this->load->view('wallettransfer', $data);
			
	    }else{
	        redirect('/');
	    }
	}
	
	public function dotransfer()
	{
	    if(isset($_SESSION['uid'])){
	        if ($_SESSION['auth'] == $this->input->post("auth")) {
	            
	            $uid = $_SESSION['uid'];
	            $udata = $this->db->get_where('users',array('id' => $uid))->row();
	            $site = $udata->site;
	            $sdata = $this->db->get_where('sites',array('id' => $site))->row();
	            $rdata = $this->db->get_where('reseller',array('id' => $sdata->rid))->row();
	            log_message('debug',print_r($rdata,true));
			    $amount = $this->input->post('amount');
			   
			    if($amount == ""){
			        //echo "PLEASE FILL ALL DETAILS";
					echo json_encode(array('status'=>'failed','response'=>'PLEASE FILL AMOUNT DETAILS'));
			    }else{
			        if($amount <= 0){
			            //echo "INVALID AMOUNT";
						echo json_encode(array('status'=>'failed','response'=>'INVALID AMOUNT'));
			        }else{
			            //check user wallet
			            
			            if($amount >= $udata->wallet){
			                //echo "INSUFFICIENT FUND";
							echo json_encode(array('status'=>'failed','response'=>'INSUFFICIENT FUND'));
			            }else
						{
			                //check reseller wallet
			                if($amount >= $rdata->wallet){
			                    //echo "TECHNICAL ISSUE CONTACT TO ADMIN";
								echo json_encode(array('status'=>'failed','response'=>'TECHNICAL ISSUE CONTACT TO ADMIN'));
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
			                    
			                   echo json_encode(array('status'=>'success','response'=>'Success'));
			                  
			                }
			            }
			        }
			    }
    		} else {
    
    			echo "INVALID TOKEN";
    		}
	    }else{
	        redirect('/');
	    }
		


	}
	
	public function create_order()
	{
		$api_token = $this->db->get_where('settings',array('name' => "all_api_token"))->row()->value;
		$order_id = "MNST".rand(11111111,999999999);
		$uid = $_SESSION['uid'];
		$udata = $this->db->get_where('users',array('id' => $uid))->row();
		$site = $udata->site;
		$sdata = $this->db->get_where('sites',array('id' => $site))->row();
		
		$txn_amount = $_POST['amount'];
		$customer_name = $udata->name;
		$customer_mobile =  $udata->phone;
		$customer_email =  $udata->email;
		
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
			header("Location: ".$result_array['results']['payment_url']);
			die();
		}else{
			redirect('transaction/mwledger');
		}
		      
	}
	
	public function callback()
	{
		if($_POST)
		{
			$order_id = $_POST['order_id'];
			$status = $_POST['status'];
			$api_token = $this->db->get_where('settings',array('name' => "all_api_token"))->row()->value;	
			$amounttransaction = $this->db->get_where('amounttransaction',array('order_id' => $order_id))->row();
			$uid = $amounttransaction->uid;
			$udata = $this->db->get_where('users',array('id' => $uid))->row();
			
			$_SESSION['pin'] = $udata->pin;
			$_SESSION['pid'] = $udata->id;
			$_SESSION['role'] = $udata->role;
			$_SESSION['uid'] = $_SESSION['pid'];
			
			if($status==true)
			{
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
				
				if($amounttransaction->status=="PENDING")
				{
					

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
					
				redirect('transaction/mwledger');
				}else{
					redirect('transaction/mwledger');
				}
							
			}else{
				redirect('transaction/mwledger');
			}
			}
		}else{
			redirect('transaction/mwledger');
		}
		 
	}
         
         
         
	
}
