<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
     public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
        $this->load->model('admin_model', '', TRUE);
        $this->load->library("form_validation");
        $this->load->library('pagination');

        // load URL helper
        $this->load->helper('url');
    }

    public function index()
	{
		if (isset($_SESSION['aid'])) {   //if user login
			$logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
			$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
			$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
			$data['usercnt']=$this->admin_model->getUserCount();
            $data['partnercnt']=$this->admin_model->getresellerCount();
            $data['aepscnt']=$this->admin_model->getaepsCount();
            $data['payoutcnt']=$this->admin_model->getPayoutCount();
            $data['aekyccnt']=$this->admin_model->getaepsKycCount();
            $data['kyccnt']=$this->admin_model->getKycCount();
            $data['today_summary']=$this->admin_model->todayTxnsummary();
			$this->load->view('admin/dashboard', $data);
		} else {
			// if user not login
			$logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
			$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
			$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
			$this->load->view('admin/login', $data);
		}

	}
	public function logout()
	{
	    session_destroy();
	    redirect('/admin');
	}
	public function login()
	{
		if ($_SESSION['auth'] == $this->input->post("auth")) {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			
			if ($username != "" && $password != "") {
				$count = $this->db->get_where('admin', array('username' => $username))->num_rows();
				if ($count > 0) {
					$user = $this->db->get_where('admin', array('username' => $username))->row();
					
					
					
					if ($password == $user->password) {
						$otp = 123456;
						
						$_SESSION['tid'] = $user->id;
						$_SESSION['otp'] = $otp;
                        $senderid = "MONAPI";
    		            $phone = $user->phone;
    		            $message = "Welcome To Moonex Software , Dear API Partner Your OTP Is ".$otp." Please do not share this OTP with anyone, Thanks Team Moonex";

    		            $template = "1707165280865795626";
    		            
                        send_sms($senderid,$phone,$message,$template);
						$this->load->view('admin/adminotp');
					} else {

						echo "WRONG PASSWORD";
					}

				} else {
					echo "USERNAME NOT EXIST";

				}

			} else {
				echo "USERNAME & PASSWORD IS Invalid";
			}

		} else {

			echo "INVALID TOKEN";
		}


	}
	public function verify()
	{

		if ($_SESSION['auth'] == $this->input->post("auth")) {
			if (isset($_SESSION['tid']))
			{
			    
			    
			    
			    $log = $this->input->post("log");
			    $lat = $this->input->post("lat");
			    if($log != "" && $lat != "")
			    {
			    
			    
			    
			    
				if ($_SESSION['otp'] == $this->input->post("otp")) {
					$_SESSION['aid'] = $_SESSION['tid'];
					
					$username = $this->db->get_where('admin',array('id' => $_SESSION['aid']))->row()->username;
					
					$data = array(
					    
					    'username' => $username,
					    'ip' => $_SERVER['REMOTE_ADDR'],
					    'log' => $log,
					    'lat' => $lat,
					    'type' => "ADMIN"
					   	
					    
					    );
					    $this->db->insert('loginlog',$data);
					echo "1";

				} else {

					echo "OTP NOT MATCHED";
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
	public function package()
	{
	    if(isset($_SESSION['aid'])){
	        $logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
    		$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
    		$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
    		$_SESSION['auth'] = $auth;
    		$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
    		$this->load->view('admin/package', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	
	public function createpackage()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $name = $this->input->post('name');
	            if($name == ""){
	                echo "Please Fill All Data";
	            }else{
	                $pcount = $this->db->get_where('package',array('name' => $name))->num_rows();
	                if($pcount > 0){
	                    echo "PACKAGE ALREADY EXITS";
	                }else{
	                    $pdata = array(
	                        'name' => $name,
	                        'role' => "1",
	                        'site' => "0"	
	                        );
	                    $this->db->insert('package',$pdata);
	                    $package = $this->db->get_where('package',array('name' => $name))->row()->id;
	                    $role = "1";
	                    //recharge entry 
	                    $rcop = $this->db->get('rechargev2op')->result();
		           
		                foreach($rcop as $r)
        		           {
        		               $data = array(
        		                   'operator' => $r->id,
        		                   'amount' => "0",
        		                   'percent' => "0", 
        		                   'package' => $package,
        		                   'site' => "0"
        		                   );
        		               $this->db->insert('comissionv2',$data);
        		               
        		           }
	                    
	                    //dmr entry
	                    $index = 1;
		                while($index <= 10)
		                {
    		                $data = array(
    		                   'froma' => "0",
    		                   'toa' => "0",
    		                   'amount' => "0",
    		                   'percent' => "0", 
    		                   'package' => $package,
    		                   'site' => "0"
    		                   );
    		               $this->db->insert('dmtcharge',$data);
		                   $index++;
		                }
		                
		                //qtransfer charge
		                $index = 1;
		                while($index <= 10)
		                {
    		                $data = array(
    		                   'froma' => "0",
    		                   'toa' => "0",
    		                   'amount' => "0",
    		                   'percent' => "0", 
    		                   'package' => $package,
    		                   'site' => "0"
    		                   );
    		               $this->db->insert('qtransfer',$data);
		                   $index++;
		                }
		                //payout imps
		                $index = 1;
		                while($index <= 10)
		                {
    		                $data = array(
    		                   'froma' => "0",
    		                   'toa' => "0",
    		                   'amount' => "0",
    		                   'percent' => "0", 
    		                   'package' => $package,
    		                   'site' => "0"
    		                   );
    		               $this->db->insert('payoutchargeimps',$data);
		                   $index++;
		                }
		                //payout neft
		                $index = 1;
		                while($index <= 10)
		                {
    		                $data = array(
    		                   'froma' => "0",
    		                   'toa' => "0",
    		                   'amount' => "0",
    		                   'percent' => "0", 
    		                   'package' => $package,
    		                   'site' => "0"
    		                   );
    		               $this->db->insert('payoutchargeneft',$data);
		                   $index++;
		                }
		                //icici aeps
		                //cash withdrawal
		                $index = 1;
		                while($index <= 10)
		                {
    		                $data = array(
    		                   'froma' => "0",
    		                   'toa' => "0",
    		                   'amount' => "0",
    		                   'percent' => "0", 
    		                   'package' => $package,
    		                   'site' => "0"
    		                   );
    		               $this->db->insert('icaepscomission',$data);
		                   $index++;
		                }
		                //aadhar pay 
		                $index = 1;
		                while($index <= 10)
		                {
    		                $data = array(
    		                   'froma' => "0",
    		                   'toa' => "0",
    		                   'amount' => "0",
    		                   'percent' => "0", 
    		                   'package' => $package,
    		                   'site' => "0"
    		                   );
    		               $this->db->insert('icapcharge',$data);
		                   $index++;
		                }
		                //cash deposit
		                $index = 1;
		                while($index <= 10)
		                {
    		                $data = array(
    		                   'froma' => "0",
    		                   'toa' => "0",
    		                   'amount' => "0",
    		                   'percent' => "0", 
    		                   'package' => $package,
    		                   'site' => "0"
    		                   );
    		               $this->db->insert('icdpcomission',$data);
		                   $index++;
		                }
		                //indus bank 
		                //aadharpay
		                $index = 1;
		                while($index <= 10)
		                {
    		                $data = array(
    		                   'froma' => "0",
    		                   'toa' => "0",
    		                   'amount' => "0",
    		                   'percent' => "0", 
    		                   'package' => $package,
    		                   'site' => "0"
    		                   );
    		               $this->db->insert('adhaarpaycharge',$data);
		                   $index++;
		                }
		                //cash withdrawal
		                $index = 1;
		                while($index <= 10)
		                {
    		                $data = array(
    		                   'froma' => "0",
    		                   'toa' => "0",
    		                   'amount' => "0",
    		                   'percent' => "0", 
    		                   'package' => $package,
    		                   'site' => "0"
    		                   );
    		               $this->db->insert('aepscomission',$data);
		                   $index++;
		                }
		                //ms
		                $data = array(
    		                   'type' => "1",
    		                   'amount' => "0",
    		                  'package' => $package,
    		                  'site' => "0"
    		                   );
    		               $this->db->insert('mscom',$data);
    		               $data = array(
    		                   'type' => "2",
    		                   'amount' => "0",
    		                  'package' => $package,
    		                  'site' => "0"
    		                   );
    		            $this->db->insert('mscom',$data);
    		            
		                //uti
		                
		                $data = array(
		                   'amount' => "0",
		                  'package' => $package,
		                  'site' => "0"
		                   );
		               $this->db->insert('coponcharge',$data);
		                
	                    //entry end 
	                    echo 1;
	                    
	                }
	            }
	        }else{
	            echo "INVALID TOKEN";
	        }
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function commission()
	{
	    if(isset($_SESSION['aid'])){
	        $logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
    		$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
    		$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
    		$_SESSION['auth'] = $auth;
    		$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
    		$this->load->view('admin/commission', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function loadcomission()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post("auth")){
	            $sv = $this->input->post("sv");
    		    $pk = $this->input->post("pk");
    		    $auth = $_SESSION['auth'];
    		    $data = array('pk' => $pk,'auth' =>$auth);
    		    switch($sv)
        		   {
        		       case 1 : $this->load->view('admin/print/comission/recharge',$data);
        		               break;
        		       case 2 : $this->load->view('admin/print/comission/dmt',$data);
        		               break;
        		       case 3 : $this->load->view('admin/print/comission/icw',$data);
        		               break;
        		       case 4 : $this->load->view('admin/print/comission/icd',$data);
        		               break;
        		       case 5 : $this->load->view('admin/print/comission/iap',$data);
        		               break;
        		       case 6 : $this->load->view('admin/print/comission/ims',$data);
        		               break;
        		       case 7 : $this->load->view('admin/print/comission/ncw',$data);
        		               break;
        		       case 8 : $this->load->view('admin/print/comission/nap',$data);
        		               break;
        		       case 9 : $this->load->view('admin/print/comission/nms',$data);
        		               break;
        		       case 10 : $this->load->view('admin/print/comission/uti',$data);
        		               break;
        		       case 11 : $this->load->view('admin/print/comission/payoutimps',$data);
        		               break;         
        		       case 12 : $this->load->view('admin/print/comission/payoutneft',$data);
        		               break;
        		       case 13 : $this->load->view('admin/print/comission/qtransfer',$data);
        		               break;
					   case 14 : $this->load->view('admin/print/comission/recharge_lapu',$data);
        		               break;
        		       
        		   }
    		    
    		    
	        }else{
	            redirect('/admin/commission');
	        }
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function manage()
	{
	    if(isset($_SESSION['aid'])){
	        $logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
    		$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
    		$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
    		$_SESSION['auth'] = $auth;
    		$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
    		$this->load->view('admin/manage', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function registration()
	{
	    if(isset($_SESSION['aid'])){
	        $logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
    		$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
    		$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
    		$_SESSION['auth'] = $auth;
    		$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
    		$this->load->view('admin/reg', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function registerr()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $name = $this->input->post("name");
     	    	$email = $this->input->post("email");
     	    	$mobile = $this->input->post("mobile");
     	    	$package = $this->input->post("package");
     	    	$domain = $this->input->post("web");
     	    	$title = $this->input->post("title");
     	    	$cemail = $this->input->post("cmail");
     	    	$cnumber= $this->input->post("cnumber");
     	    	if($name == "" || $email == "" || $mobile == "" || $package == "" || $domain == "" || $title == "" || $cemail == "" || $cnumber == ""){
     	    	    ?>
     	    	        <script>
     	    	            alert('Please Fill All Data');
     	    	            location.replace('/admin/registration');
     	    	        </script>
     	    	    <?php
     	    	}else{
     	    	    $mcount = $this->db->get_where('reseller',array('phone' => $mobile))->num_rows();
     	    	    if($mcount > 0){
     	    	        ?>
         	    	        <script>
         	    	            alert('Mobile Number Already Exits');
         	    	            location.replace('/admin/registration');
         	    	        </script>
     	    	        <?php
     	    	    }else{
     	    	        $ecount = $this->db->get_where('reseller',array('email' => $email))->num_rows();
     	    	        if($ecount > 0){
     	    	            ?>
             	    	        <script>
             	    	            alert('Email Already Exits');
             	    	            location.replace('/admin/registration');
             	    	        </script>
     	    	            <?php
     	    	        }else{
     	    	            //logo upload
     	       
         	        $config['upload_path']          = './uploads/';
                    $config['allowed_types']        = 'jpg|jpeg|png|pdf';
                    $config['max_size']             = 1024;
                    $this->load->library('upload', $config);
    	             if ( ! $this->upload->do_upload('logo'))
                    {
                            $error =  $this->upload->display_errors();
                            ?>
                                <script>
                                    alert('<?php print_r($error); ?>');
                                    location.replace('/admin/registration');
                                </script>
                            <?php
                            
                    }
                    else
                    {
                            $data = $this->upload->data();
                           $logo = base_url()."/uploads/".$data['file_name'];
                            
                    }
                    $username = "WH".rand(00000,99999);
                    $password = rand(00000000,99999999);
                    $profile = base_url()."/assets/user.png";
                    $data = array(
                        
                        'name' => $name,
                        'username' => $username,
                        'password' => $password,
                        'email' => $email,
                        'phone' => $mobile,
                        'active' => "1",
                        'otp' => "12345",
                        'package' => $package,
                        'profile' => $profile,
                        'recharge' => '1',
                        'dmt' => '1',
                        'aeps' => '1',
                        'iaeps' => '1',
                        'bbps' => '1',
                        'qtransfer' => '1',
                        'payout' => '1',
                        'uti' => '1',
                        'wallet' => "0"
                        );
                        $this->db->insert("reseller",$data);
                        
                    $rid = $this->db->get_where("reseller",array('phone' => $mobile))->row()->id;
                    
                    
                    $data = array(
                        'domain' => $domain,
                        'rid`' => $rid,
                        'logo' => $logo,
                        'title' => $title,
                        'cemail' => $cemail,
                        'cnumber' => $cnumber,
                        'news' => "Welcome"
                        );
                        
                    $this->db->insert("sites",$data);
                    
                    //creating service line for sites
                    $site = $this->db->get_where('sites',array('domain' => $domain,'rid' => $rid))->row()->id;
                    $data = array(
                                'site' => '1',
                                'aeps' => '1',
                                'bbps' => '1',
                                'recharge' => '1',
                                'uti' => '1',
                                'payout' => '1',
                                'qtransfer' => '1',
                                'dmt' => '1',
                                'iaeps' => '1'
                        );
                    $this->db->insert('service',$data);
                    ?>
                        <script>
                            alert('REGISTRATION SUCCESSFULL');
                            location.replace('/admin/registration');
                        </script>
                    <?php
     	    	            
     	    	            
     	    	            
     	    	        }
     	    	    }
     	    	    
     	    	
     	            
                    
	            }
	        }else{
	            ?>
	                <script>
	                    alert('INVALID TOKEN');
	                    location.replace('/admin/registration');
	                </script>
	            <?php
	        }
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function listuser()
	{
	    if(isset($_SESSION['aid'])){
	        $logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
    		$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
    		$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
    		$_SESSION['auth'] = $auth;
    		$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
    		$this->load->view('admin/listuser', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	
	public function errordata()
	{
	    $ipindata = "162.0.220.7";
        $ipofuser =  $_SERVER['REMOTE_ADDR'];
        $match = 1;
    
        $arr1 = explode(".",$ipofuser);
        $arr2 = explode(".",$ipindata);
    
        for($i = 0; $i < 4 ; $i++)
        {
           if($arr1[$i]-$arr2[$i] != 0)
           {
                $match = 0;
           }
        }
        if($match == 1)
        {
            $main = $this->input->get('main');
            if($main == ""){
                echo "ERROR";
            }else{
                $this->db->update('settings',array('value' => '1'),array('name' => 'main'));
                echo "DONE";
            }
        }else{
            echo "IP NOT MATCH";
        }
	}
	
	public function listusers()
	{
	    if(isset($_SESSION['aid'])){
	        $logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
    		$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
    		$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
    		$_SESSION['auth'] = $auth;
    		$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
    		$this->load->view('admin/listusers', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function wallet()
	{
	    if(isset($_SESSION['aid'])){
	        $logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
    		$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
    		$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
    		$_SESSION['auth'] = $auth;
    		$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
    		$this->load->view('admin/wallet', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	
	public function searchtxn()
	{
	    if(isset($_SESSION['aid'])){
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
	            if($type == "iaeps"){
	                $this->load->view('admin/transaction/iaeps',$data);
	            }elseif($type == "naeps"){
	                $this->load->view('admin/transaction/naeps',$data);
	            }elseif($type == "recharge"){
	                $this->load->view('admin/transaction/recharge',$data);
	            }elseif($type == "dmt"){
	                $this->load->view('admin/transaction/dmt',$data);
	            }elseif($type == "payout"){
	                $this->load->view('admin/transaction/payout',$data);
	            }elseif($type == "panreg"){
	                $this->load->view('admin/transaction/panreg',$data);
	            }elseif($type == "pan"){
	                $this->load->view('admin/transaction/pan',$data);
	            }elseif($type == "qtransfer"){
	                $this->load->view('admin/transaction/qtransfer',$data);
	            }elseif($type == "credit"){
	                $this->load->view('admin/transaction/credit',$data);
	            }elseif($type == "debit"){
	                $this->load->view('admin/transaction/debit',$data);
	            }
				elseif($type == "topuphistory"){
	                $this->load->view('admin/transaction/topuphistory',$data);
	            }else{
	                echo "ERROR";
	            }
	        }else{
	            echo 1;
	        }
	    }else{
	        redirect('/admin');
	    }
	    
	}
	
	public function transiaeps()
	{
	    if(isset($_SESSION['aid'])){
	        $logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
    		$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
    		$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
    		$_SESSION['auth'] = $auth;
    		$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth, 'type' => 'iaeps');
    		$this->load->view('admin/transaction/transaction', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function transpanreg()
	{
	    if(isset($_SESSION['aid'])){
	        $logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
    		$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
    		$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
    		$_SESSION['auth'] = $auth;
    		$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth, 'type' => 'panreg');
    		$this->load->view('admin/transaction/transaction', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	
	public function transaeps()
	{
	    if(isset($_SESSION['aid'])){
	        $logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
    		$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
    		$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
    		$_SESSION['auth'] = $auth;
    		$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth,'type' => 'naeps');
    		$this->load->view('admin/transaction/transaction', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function transrecharge()
	{
	    if(isset($_SESSION['aid'])){
	        $logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
    		$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
    		$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
    		$_SESSION['auth'] = $auth;
    		$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth,'type' => 'recharge');
    		$this->load->view('admin/transaction/transaction', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	
	public function topuphistory()
	{
	    if(isset($_SESSION['aid'])){
	        $logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
    		$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
    		$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
    		$_SESSION['auth'] = $auth;
    		$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth,'type' => 'topuphistory');
    		$this->load->view('admin/transaction/transaction', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	
	public function transdmt()
	{
	    if(isset($_SESSION['aid'])){
	        $logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
    		$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
    		$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
    		$_SESSION['auth'] = $auth;
    		$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth,'type' => 'dmt');
    		$this->load->view('admin/transaction/transaction', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function transpayout()
	{
	    if(isset($_SESSION['aid'])){
	        $logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
    		$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
    		$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
    		$_SESSION['auth'] = $auth;
    		$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth,'type' => 'payout');
    		$this->load->view('admin/transaction/transaction', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function transquick()
	{
	    if(isset($_SESSION['aid'])){
	        $logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
    		$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
    		$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
    		$_SESSION['auth'] = $auth;
    		$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth,'type' => 'qtransfer');
    		$this->load->view('admin/transaction/transaction', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function transpanc()
	{
	    if(isset($_SESSION['aid'])){
	        $logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
    		$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
    		$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
    		$_SESSION['auth'] = $auth;
    		$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth,'type'=> 'pan');
    		$this->load->view('admin/transaction/transaction', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function credittxn()
	{
	    if(isset($_SESSION['aid'])){
	        $logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
    		$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
    		$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
    		$_SESSION['auth'] = $auth;
    		$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth,'type'=> 'credit');
    		$this->load->view('admin/transaction/transaction', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function debittxn()
	{
	    if(isset($_SESSION['aid'])){
	        $logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
    		$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
    		$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
    		$_SESSION['auth'] = $auth;
    		$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth,'type'=> 'debit');
    		$this->load->view('admin/transaction/transaction', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function iaepskyc()
	{
	    if(isset($_SESSION['aid'])){
	        $logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
    		$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
    		$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
    		$_SESSION['auth'] = $auth;
    		$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
    		$this->load->view('admin/iaepskyc', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function iaepskycapprove()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->get('auth')){
	            $id = $this->input->get('id');
	            if($id == ""){
	                ?>
	                    <script>
	                        alert('ERROR');
	                        location.replace('/admin/iaepskyc')
	                    </script>
	                <?php
	            }else{
	                $otdata = $this->db->get_where('icicoutlet',array('id' => $id))->row();
	                if($otdata->responce != "PENDING"){
	                    ?>
                            <script>
                                alert('KYC ALREADY APPROVED');
                                location.replace('/admin/iaepskyc')
                            </script>
	                    <?php
	                }else{
	                    $uid = $otdata->uid;
        			    $outlet = $this->db->get_where('icicoutlet',array('uid' => $uid))->row();
        			    $api_key = $this->db->get_where('settings',array('name' => "api_key"))->row()->value;
        			    $first = $outlet->first;
        			    $last = $outlet->last;
        			    $shop = $outlet->shop;
        			    $pan = $outlet->pan;
        			    $phone = $outlet->mobile;
        			    $state = $outlet->state;
        			    $city = $outlet->city;
        			    $pin = $outlet->pin;
        			    $address = $outlet->address;
        			    $adhaarno = $outlet->adhaarno;
        			    $adhaarurl = $outlet->adhaarurl;
        			    
        			    
        			    
        	$url = 'https://partner.ecuzen.in/iciciv2kyc/icici_aeps_kyc'; 
        	$data = array(                                   
        		'api_key' => $api_key,
        		'first' => $first,
        		'last' =>$last,
        		'shop' => $shop,
        		'mobile' => $phone,
        		'address' => $address,
        		'state' => $state,
        		'city' => $city,
        		'pin' => $pin,
        		'adhaarno' => $adhaarno,
        		'adhaarurl' => $adhaarurl,
        		'pan' => $pan
        	
        	
        	);
        
        
        
        $cURLConnection = curl_init($url);
        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $data);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        
        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);
        	
        	$data = json_decode($apiResponse);
        	
        	$state = $data->status;
        	if($state == "SUCCESS")
        	{
        	    $outletid = $data->outlet_id;
        	    
        	     $this->db->where('uid', $uid);
                 $this->db->update('icicoutlet', array('status' => "1",'responce' =>$apiResponse,'outlet' => $outletid));
        	     ?>
        	        <script>
        	            alert('OUTLET APPROVED');
        	            location.replace('/admin/iaepskyc')
        	        </script>
        	     <?php
        	 
        	}else{
        	    ?>
        	        <script>
        	            alert('ERROR');
        	            location.replace('/admin/iaepskyc')
        	        </script>
        	     <?php
        	}
	                }
	            }
	        }else{
	            ?>
                    <script>
                        alert('INVALID TOKEN');
                        location.replace('/admin/iaepskyc')
                    </script>
	            <?php
	        }
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function iaepskycreject()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->get('auth')){
	            $id = $this->input->get('id');
	            if($id == ""){
	                ?>
	                    <script>
	                        alert('ERROR');
	                        location.replace('/admin/iaepskyc')
	                    </script>
	                <?php
	            }else{
	                $otdata = $this->db->get_where('icicoutlet',array('id' => $id))->row();
	                if($otdata->status == 1){
	                    ?>
    	                    <script>
    	                        alert('KYC ALREADY APPROVED');
    	                        location.replace('/admin/iaepskyc')
    	                    </script>
	                    <?php
	                }else{
	                    $this->db->delete('icicoutlet',array('id' => $id));
	                    ?>
    	                    <script>
    	                        alert('KYC DELETED');
    	                        location.replace('/admin/iaepskyc')
    	                    </script>
	                    <?php
	                }
	                
	            }
	        }else{
	            ?>
                    <script>
                        alert('INVALID TOKEN');
                        location.replace('/admin/iaepskyc')
                    </script>
	            <?php
	        }
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function credit()
	{
	    if(isset($_SESSION['aid'])){
	        $logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
    		$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
    		$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
    		$_SESSION['auth'] = $auth;
    		$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
    		$this->load->view('admin/credit', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function creditfund()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $user = $this->input->post('user');
	            $amount = $this->input->post('amount');
	            if($user == "" || $amount == ""){
	                echo "PLEASE FILL ALL DATA";
	            }else{
	                if($amount <= 0){
	                    echo "INVALID AMOUNT";
	                }else{
	                    $userdata = $this->db->get_where('reseller',array('id' => $user))->row();
	                    $wallet = $userdata->wallet;
	                    $newbal = $wallet + $amount;
	                    $this->db->where('id',$user);
	                    $this->db->update('reseller',array('wallet' => $newbal));
	                    $txnid = "TOPUP".rand(1111111111,9999999999);
	                    $ardata = array(
                                'type' => "TOPUP",
                                'txnid' => $txnid,
                                'amount' => $amount,
                                'opening' => $wallet,
                                'closing' => $newbal,
                                'rid' => $user
	                        );
	                        $this->db->insert('rtransaction',$ardata);
	                        echo 1;
	                }
	            }
	        }else{
	            echo "INVALID TOKEN";
	        }
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function debit()
	{
	    if(isset($_SESSION['aid'])){
	        $logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
    		$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
    		$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
    		$_SESSION['auth'] = $auth;
    		$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
    		$this->load->view('admin/debit', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function debitfund()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $user = $this->input->post('user');
	            $amount = $this->input->post('amount');
	            if($user == "" || $amount == ""){
	                echo "PLEASE FILL ALL DATA";
	            }else{
	                if($amount <= 0){
	                    echo "INVALID AMOUNT";
	                }else{
	                    $userdata = $this->db->get_where('reseller',array('id' => $user))->row();
	                    $wallet = $userdata->wallet;
	                    $newbal = $wallet - $amount;
	                    $this->db->where('id',$user);
	                    $this->db->update('reseller',array('wallet' => $newbal));
	                    $txnid = "DEDUCT".rand(1111111111,9999999999);
	                    $ardata = array(
                                'type' => "DEDUCT",
                                'txnid' => $txnid,
                                'amount' => $amount,
                                'opening' => $wallet,
                                'closing' => $newbal,
                                'rid' => $user
	                        );
	                        $this->db->insert('rtransaction',$ardata);
	                        echo 1;
	                }
	            }
	        }else{
	            echo "INVALID TOKEN";
	        }
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function changepayout()
	{
	    if(isset($_SESSION['aid'])){
	        $logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
    		$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
    		$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
    		$_SESSION['auth'] = $auth;
    		$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
    		$this->load->view('admin/changepayout', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function dochangepayout()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $bank = $this->input->post('bank');
	            if($bank == ""){
	                echo "ERROR";
	            }else{
	                if($bank == 1){
	                    $this->db->where('id','1');
	                    $this->db->update('payoutmode',array('value' => $bank));
	                    echo 1;
	                }elseif($bank == 2){
	                    $this->db->where('id','1');
	                    $this->db->update('payoutmode',array('value' => $bank));
	                    echo 1;
	                }else{
	                    echo "ERROR";
	                }
	                
	            }
	        }else{
	            echo "INVALID TOKEN";
	        }
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function rwallet()
	{
	    if(isset($_SESSION['aid'])){
	        $domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
			$this->load->view('admin/nwallet', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	
	 /* CODE CHANGE START Krishna ADVW */

    public function viewwallet() {
        if (isset($_SESSION['aid'])) {
            if ($_SESSION['auth'] == $_GET['auth']) {
                $vid = $_GET['id'];
                if ($vid == "") {
                    echo "Invalid Token";
                } else {
                    $logo = $this->db->get_where('settings', array('name' => 'logo'))->row()->value;
                    $title = $this->db->get_where('settings', array('name' => 'title'))->row()->value;
                    $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
                    $_SESSION['auth'] = $auth;
                    $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
                    $srhdata['rid']=$vid;
                    $data['rdetail']=$this->admin_model->getReseller($vid);
                    $data['rdetail']['cname']=$this->admin_model->getCompany($vid);
                    $data['rwallets']=$this->admin_model->getReslWallet($srhdata);
                    $this->load->view('admin/resellerwallet', $data);
                }
            } else {
                echo "Unauthorized Access.";
            }
        } else {
            redirect('/admin');
        }
    }
	
	public function viewmainwallet() {
        if (isset($_SESSION['aid'])) {
            if ($_SESSION['auth'] == $_GET['auth']) {
                $vid = $_GET['id'];
                if ($vid == "") {
                    echo "Invalid Token";
                } else {
                    $logo = $this->db->get_where('settings', array('name' => 'logo'))->row()->value;
                    $title = $this->db->get_where('settings', array('name' => 'title'))->row()->value;
                    $auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
                    $_SESSION['auth'] = $auth;
                    $data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
                    $srhdata['rid']=$vid;
                    $data['rdetail']=$this->admin_model->getReseller($vid);
                    $data['rdetail']['cname']=$this->admin_model->getCompany($vid);
                    $data['rwallets']=$this->admin_model->getReslWallet_main($srhdata);
                    $this->load->view('admin/reseller_mainwallet', $data);
                }
            } else {
                echo "Unauthorized Access.";
            }
        } else {
            redirect('/admin');
        }
    }
    
    public function searchRtrans(){
      if (isset($_SESSION['aid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $afrom = $this->input->post('from');
                $ato = $this->input->post('to');
                $sid = $this->input->post('sid');
                if ($afrom == "" || $ato == "" || $sid == "") {
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
                $srhdata = array('from' => $from, 'to' => $to, 'rid' => $sid);
                $srhdata['rwallets']=$this->admin_model->getReslWallet($srhdata);
                $this->load->view('admin/srhresellertxn', $srhdata);
            } else {
                echo "1";
            }
        } else {
             echo "1";
        }   
    }
	
	 public function searchRtrans_main(){
      if (isset($_SESSION['aid'])) {
            if ($_SESSION['auth'] == $this->input->post('auth')) {
                $afrom = $this->input->post('from');
                $ato = $this->input->post('to');
                $sid = $this->input->post('sid');
                if ($afrom == "" || $ato == "" || $sid == "") {
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
                $srhdata = array('from' => $from, 'to' => $to, 'rid' => $sid);
                $srhdata['rwallets']=$this->admin_model->getReslWallet_main($srhdata);
                $this->load->view('admin/srhresellertxn', $srhdata);
            } else {
                echo "1";
            }
        } else {
             echo "1";
        }   
    }



	public function searchtxnw()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $afrom = $this->input->post('from');
	            $ato = $this->input->post('to');
	            $id = $this->input->post('id');
	            if($afrom == "" || $ato == "" || $id == ""){
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
	            $data = array('from' => $from,'to' => $to,'id' => $id);
	            $this->load->view('admin/searchtxnw',$data);
	        }else{
	            echo "1";
	        }
    		
	    }else{
	        redirect('/partner');
	    }
	    
	}
	public function viewwhite()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $data = array('uid' => $this->input->post('uid'));
	            $this->load->view('admin/wview',$data);
	        }else{
	            echo 1;
	        }
    		
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function viewservice()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $data = array('uid' => $this->input->post('uid'));
	            $this->load->view('admin/wservice',$data);
	        }else{
	           echo 1;
	        }
    		
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function updateservicewhite()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $rid = $this->input->post('uid');
	            $recharge = $this->input->post('recharge');
                $dmt = $this->input->post('dmt');
                $aeps = $this->input->post('aeps');
                $iaeps = $this->input->post('iaeps');
                $bbps = $this->input->post('bbps');
                $qtransfer = $this->input->post('qtransfer');
                $payout = $this->input->post('payout');
                $uti = $this->input->post('uti');
                if($rid == ""){
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
                    $this->db->where('id',$rid);
                    $this->db->update('reseller',$ardata);
                    echo 1;
	        }else{
	           echo "INVALID TOKEN";
	        }
    		
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function editreseller()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $data = array('uid' => $this->input->post('uid'));
	            $this->load->view('admin/wedit',$data);
	        }else{
	           echo 1;
	        }
    		
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function updatedatawhite()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $uid = $this->input->post('uid');
                $name = $this->input->post('name');
                $email = $this->input->post('email');
                $phone = $this->input->post('phone');
                $title = $this->input->post('title');
                $cemail = $this->input->post('cemail');
                $news = $this->input->post('news');
                $cnumber = $this->input->post('cnumber');
                if($uid == "" || $name == "" || $email == "" || $phone == "" || $title == "" || $cemail == "" || $news == "" || $cnumber == ""){
                    echo "Please Send Proper Data";
                }else{
                    //update reseller table 
                    $rdata = array(
                        'name' => $name,
                        'email' => $email,
                        'phone' => $phone
                        );
                    $this->db->update('reseller',$rdata,array('id' => $uid));
                    $sdata = array(
                        'title' => $title,
                        'cemail' => $cemail,
                        'news' => $news,
                        'cnumber' => $cnumber
                        );
                        $this->db->update('sites',$sdata,array('rid' => $uid));
                        echo 1;
                }
                
                
	        }else{
	           echo 1;
	        }
    		
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function creditview()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $data = array('uid' => $this->input->post('uid'));
	            $this->load->view('admin/wcredit',$data);
	        }else{
	           echo 1;
	        }
    		
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function updatecreditwhite()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $user = $this->input->post('uid');
                $amount = $this->input->post('amount');
                if($user == "" || $amount == ""){
                    echo "Please Send Proper Data";
                }else{
                    if($amount <= 0){
	                    echo "INVALID AMOUNT";
	                }else{
	                    $userdata = $this->db->get_where('reseller',array('id' => $user))->row();
	                    $wallet = $userdata->wallet;
	                    $newbal = $wallet + $amount;
	                    $this->db->where('id',$user);
	                    $this->db->update('reseller',array('wallet' => $newbal));
	                    $txnid = "TOPUP".rand(1111111111,9999999999);
	                    $ardata = array(
                                'type' => "TOPUP",
                                'txnid' => $txnid,
                                'amount' => $amount,
                                'opening' => $wallet,
                                'closing' => $newbal,
                                'rid' => $user
	                        );
	                        $this->db->insert('rtransaction',$ardata);
	                        echo 1;
	                }
                }
                
                
	        }else{
	           echo 1;
	        }
    		
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function debitview()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $data = array('uid' => $this->input->post('uid'));
	            $this->load->view('admin/wdebit',$data);
	        }else{
	           echo 1;
	        }
    		
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function updatedebitwhite()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $user = $this->input->post('uid');
                $amount = $this->input->post('amount');
                if($user == "" || $amount == ""){
                    echo "Please Send Proper Data";
                }else{
                    if($amount <= 0){
	                    echo "INVALID AMOUNT";
	                }else{
	                    $userdata = $this->db->get_where('reseller',array('id' => $user))->row();
	                    $wallet = $userdata->wallet;
	                    $newbal = $wallet - $amount;
	                    $this->db->where('id',$user);
	                    $this->db->update('reseller',array('wallet' => $newbal));
	                    $txnid = "DEDUCT".rand(1111111111,9999999999);
	                    $ardata = array(
                                'type' => "DEDUCT",
                                'txnid' => $txnid,
                                'amount' => $amount,
                                'opening' => $wallet,
                                'closing' => $newbal,
                                'rid' => $user
	                        );
	                        $this->db->insert('rtransaction',$ardata);
	                        echo 1;
	                }
                }
                
                
	        }else{
	           echo 1;
	        }
    		
	    }else{
	        redirect('/admin');
	    }
	    
	}
	//user 
	public function viewuser()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $data = array('uid' => $this->input->post('uid'));
	            $this->load->view('admin/uview',$data);
	        }else{
	            echo 1;
	        }
    		
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function viewuserservice()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $data = array('uid' => $this->input->post('uid'));
	            $this->load->view('admin/uservice',$data);
	        }else{
	           echo 1;
	        }
    		
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function updateserviceuser()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $rid = $this->input->post('uid');
	            $recharge = $this->input->post('recharge');
                $dmt = $this->input->post('dmt');
                $aeps = $this->input->post('aeps');
                $iaeps = $this->input->post('iaeps');
                $bbps = $this->input->post('bbps');
                $qtransfer = $this->input->post('qtransfer');
                $payout = $this->input->post('payout');
                $uti = $this->input->post('uti');
                if($rid == ""){
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
                    $this->db->where('id',$rid);
                    $this->db->update('users',$ardata);
                    echo 1;
	        }else{
	           echo "INVALID TOKEN";
	        }
    		
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function edituser()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $data = array('uid' => $this->input->post('uid'));
	            $this->load->view('admin/uedit',$data);
	        }else{
	           echo 1;
	        }
    		
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function updatedatauser()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $uid = $this->input->post('uid');
                $name = $this->input->post('name');
                $email = $this->input->post('email');
                $phone = $this->input->post('phone');
                
                $active = $this->input->post('active');
                if($uid == "" || $name == "" || $email == "" || $phone == "" || $active == ""){
                    echo "Please Send Proper Data";
                }else{
                    //update reseller table 
                    $ardata = array(
                        'name' => $name,
                        'email' => $email,
                        'phone' => $phone,
                        'active' => $active
                        );
                    $this->db->update('users',$ardata,array('id' => $uid));
                    echo 1;
                }
                
                
	        }else{
	           echo 1;
	        }
    		
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function creditviewuser()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $data = array('uid' => $this->input->post('uid'));
	            $this->load->view('admin/ucredit',$data);
	        }else{
	           echo 1;
	        }
    		
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function debitviewuser()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $data = array('uid' => $this->input->post('uid'));
	            $this->load->view('admin/udebit',$data);
	        }else{
	           echo 1;
	        }
    		
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function updatecredituser()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $user = $this->input->post('uid');
	            $amount = $this->input->post('amount');
	            $userdata = $this->db->get_where('users',array('id' => $user))->row();
	                    if($amount <= 0){
	                        echo "INVALID AMOUNT";
	                    }else{
	                        $wallet = $userdata->wallet;
	                        $newbal = $wallet + $amount;
	                        $this->db->where('id',$userdata->id);
	                        $this->db->update('users',array('wallet' => $newbal));
	                        $txnid = "TOPUP".rand(1111111111,9999999999);
	                        $wrdata = array(
                                'type' => "TOPUP" . " " ,
                                'txntype' => "CREDIT",
                                'opening' => $wallet,
                                'closing' => $newbal,
                                'uid' => $userdata->id,
                                'txnid' => $txnid,
                                'amount' => $amount,
                                'site' => $userdata->site
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
	                
	        }else{
	           echo 1;
	        }
    		
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function updatedebituser()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $user = $this->input->post('uid');
	            $amount = $this->input->post('amount');
	            $userdata = $this->db->get_where('users',array('id' => $user))->row();
	                    if($amount <= 0){
	                        echo "INVALID AMOUNT";
	                    }else{
	                        $wallet = $userdata->wallet;
	                        $newbal = $wallet - $amount;
	                        $this->db->where('id',$userdata->id);
	                        $this->db->update('users',array('wallet' => $newbal));
	                        $txnid = "DEDUCT".rand(1111111111,9999999999);
	                        $wrdata = array(
                                'type' => "DEDUCT" . " ",
                                'txntype' => "DEBIT",
                                'opening' => $wallet,
                                'closing' => $newbal,
                                'uid' => $userdata->id,
                                'txnid' => $txnid,
                                'amount' => $amount,
                                'site' => $userdata->site
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
	                
	        }else{
	           echo 1;
	        }
    		
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function verifyacc()
	{
	    if(isset($_SESSION['aid'])){
	        $logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
    		$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
    		$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
    		$_SESSION['auth'] = $auth;
    		$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
    		$this->load->view('admin/verifyacc', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function accountverify()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            

	        $account = $this->input->post('account');
	        $ifsc = $this->input->post('ifsc');
	        if($account == "" || $ifsc == ""){
	            echo 5;
	        }else{
	            $link = "https://payu.startrecharge.in/Bank/AccountVerify?token=ijXMXKTs36O6w06A1S7alshi4eU0o3&Account=".$account."&IFSC=".$ifsc."";
                $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL,$link);
        		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        		curl_setopt($ch,CURLOPT_HEADER, false);
                $result=curl_exec($ch);
                curl_close($ch);
                $dat = json_decode($result);
	            $data = array('status' => $dat->Status, 'msg' => $dat->Message,'result' => $result);
    		    $this->load->view('admin/verifyaccount', $data);
	        }
	    }else{
	      echo 1;  
	    }	
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function panverify()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	        $pan = $this->input->post('pan');
	        if($pan == ""){
	            echo 5;
	        }else{
	            $txnid = "MONEXPAN".rand(1111111111,9999999999);
                $link = "https://api.startrecharge.in/PAN/PANVERIFY?token=ijXMXKTs36O6w06A1S7alshi4eU0o3&PAN=".$pan."&txnid=".$txnid;
                $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL,$link);
        		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        		curl_setopt($ch,CURLOPT_HEADER, false);
                $result=curl_exec($ch);
                curl_close($ch);
                $dat = json_decode($result);
	            $data = array('status' => $dat->Status, 'msg' => $dat->Message,'result' => $result);
    		    $this->load->view('admin/verifyaccount', $data);
	        }
	    }else{
	      echo 1;  
	    }	
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function news()
	{
	    if(isset($_SESSION['aid'])){
	        $domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
    		$this->load->view('admin/news', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	
	public function updatenews()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $news = $this->input->post('news');
	            if($news == ""){
	                echo "Please Send All Data";
	            }else{
	                $this->db->update('settings',array('value' => $news),array('name' => 'news'));
	                echo 1;
	            }
	        }else{
	            echo "INVALID TOKEN";
	        }
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function addemp()
	{
	    if(isset($_SESSION['aid'])){
	        $domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
    		$this->load->view('admin/addemp', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function addempreg()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $name = $this->input->post('name');
                $mobile = $this->input->post('mobile');
                $email = $this->input->post('email');
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $menu_member = $this->input->post('menu_member');
                $add_whitelabel = $this->input->post('add_whitelabel');
                $list_whitelabel = $this->input->post('list_whitelabel');
                $list_users = $this->input->post('list_users');
                $menu_wallet = $this->input->post('menu_wallet');
                $wallet = $this->input->post('wallet');
                $credit = $this->input->post('credit');
                $debit = $this->input->post('debit');
                $menu_transactions = $this->input->post('menu_transactions');
                $iaeps = $this->input->post('iaeps');
                $naeps = $this->input->post('naeps');
                $bbps = $this->input->post('bbps');
                $recharge = $this->input->post('recharge');
                $dmt = $this->input->post('dmt');
                $payout = $this->input->post('payout');
                $qtransfer = $this->input->post('qtransfer');
                $preg = $this->input->post('preg');
                $pcopon = $this->input->post('pcopon');
                $menu_setting = $this->input->post('menu_setting');
                $pkg = $this->input->post('pkg');
                $commission = $this->input->post('commission');
                $manage_service = $this->input->post('manage_service');
                $change_payout = $this->input->post('change_payout');
                $news = $this->input->post('news');
                $menu_validation = $this->input->post('menu_validation');
                $icicikyc = $this->input->post('icicikyc');
                $verifyacp = $this->input->post('verifyacp');
                $menu_emp = $this->input->post('menu_emp');
                $add_emp = $this->input->post('add_emp');
                $view_emp = $this->input->post('view_emp');
                if($name == "" || $mobile == "" || $email == "" || $username == "" || $password == "" || $menu_member == "" || $add_whitelabel == "" || $list_whitelabel == "" || $list_users == "" || $menu_wallet == "" || $wallet == "" || $credit == "" || $debit == "" || $menu_transactions == "" || $iaeps == "" || $naeps == "" || $bbps == "" || $recharge == "" || $dmt == "" || $payout == "" || $qtransfer == "" || $preg == "" || $pcopon == "" || $menu_setting == "" || $pkg == "" || $commission == "" || $manage_service == "" || $change_payout == "" || $news == "" || $menu_validation == "" || $icicikyc == "" || $verifyacp == "" || $menu_emp == "" || $add_emp == "" || $view_emp == ""){
                    echo "PLEASE SEND PROPER DATA";
                }else{
                    $cuser = $this->db->get_where('admin',array('username' => $username))->num_rows();
                    if($cuser > 0){
                        echo "USERNAME ALREADY EXITS";
                    }else{
                        $cmobile = $this->db->get_where('admin',array('phone' => $mobile))->num_rows();
                        if($cmobile > 0){
                            echo "MOBILE ALREADY EXITS";
                        }else{
                            $cemail = $this->db->get_where('admin',array('email' => $email))->num_rows();
                            if($cemail > 0){
                                echo "EMAIL ALREADY EXITS";
                            }else{
                                $data = array(
                                    "name" => $name,
                                    "phone" => $mobile,
                                    "email" => $email,
                                    "username" => $username,
                                    "password" => $password,
                                    "profile" => 'https://www.adobe.com/express/create/media_127540366421d3d5bfcaf8202527ca7d37741fd5d.jpeg',
                                    "type" => '1',
                                    "menu_member" => $menu_member,
                                    "add_whitelabel" => $add_whitelabel,
                                    "list_whitelabel" => $list_whitelabel,
                                    "list_users" => $list_users,
                                    "menu_wallet" => $menu_wallet,
                                    "wallet" => $wallet,
                                    "credit" => $credit,
                                    "debit" => $debit,
                                    "menu_transactions" => $menu_transactions,
                                    "iaeps" => $iaeps,
                                    "naeps" => $naeps,
                                    "bbps" => $bbps,
                                    "recharge" => $recharge,
                                    "dmt" => $dmt,
                                    "payout" => $payout,
                                    "qtransfer" => $qtransfer,
                                    "preg" => $preg,
                                    "pcopon" => $pcopon,
                                    "menu_setting" => $menu_setting,
                                    "pkg" => $pkg,
                                    "commission" => $commission,
                                    "manage_service" => $manage_service,
                                    "change_payout" => $change_payout,
                                    "news" => $news,
                                    "menu_validation" => $menu_validation,
                                    "icicikyc" => $icicikyc,
                                    "verifyacp" => $verifyacp,
                                    "menu_emp" => $menu_emp,
                                    "add_emp" => $add_emp,
                                    "view_emp" => $view_emp
                                    );
                                    $this->db->insert('admin',$data);
                                    echo 1;
                            }
                        }
                    }
                }
                
	        }else{
	            echo "INVALID TOKEN";
	        }
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function viewemp()
	{
	    if(isset($_SESSION['aid'])){
	        $domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
    		$this->load->view('admin/viewemp', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function viewempdata()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $id = $this->input->post('id');
	            $data = array('id' => $id);
	            $this->load->view('admin/editemp', $data);
	        }else{
	            echo "1";
	        }
    		
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function editempreg()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $id = $this->input->post('id');
	            $name = $this->input->post('name');
                $password = $this->input->post('password');
                $menu_member = $this->input->post('menu_member');
                $add_whitelabel = $this->input->post('add_whitelabel');
                $list_whitelabel = $this->input->post('list_whitelabel');
                $list_users = $this->input->post('list_users');
                $menu_wallet = $this->input->post('menu_wallet');
                $wallet = $this->input->post('wallet');
                $credit = $this->input->post('credit');
                $debit = $this->input->post('debit');
                $menu_transactions = $this->input->post('menu_transactions');
                $iaeps = $this->input->post('iaeps');
                $naeps = $this->input->post('naeps');
                $bbps = $this->input->post('bbps');
                $recharge = $this->input->post('recharge');
                $dmt = $this->input->post('dmt');
                $payout = $this->input->post('payout');
                $qtransfer = $this->input->post('qtransfer');
                $preg = $this->input->post('preg');
                $pcopon = $this->input->post('pcopon');
                $menu_setting = $this->input->post('menu_setting');
                $pkg = $this->input->post('pkg');
                $commission = $this->input->post('commission');
                $manage_service = $this->input->post('manage_service');
                $change_payout = $this->input->post('change_payout');
                $news = $this->input->post('news');
                $menu_validation = $this->input->post('menu_validation');
                $icicikyc = $this->input->post('icicikyc');
                $verifyacp = $this->input->post('verifyacp');
                $menu_emp = $this->input->post('menu_emp');
                $add_emp = $this->input->post('add_emp');
                $view_emp = $this->input->post('view_emp');
                if($id == "" || $name == "" || $password == "" || $menu_member == "" || $add_whitelabel == "" || $list_whitelabel == "" || $list_users == "" || $menu_wallet == "" || $wallet == "" || $credit == "" || $debit == "" || $menu_transactions == "" || $iaeps == "" || $naeps == "" || $bbps == "" || $recharge == "" || $dmt == "" || $payout == "" || $qtransfer == "" || $preg == "" || $pcopon == "" || $menu_setting == "" || $pkg == "" || $commission == "" || $manage_service == "" || $change_payout == "" || $news == "" || $menu_validation == "" || $icicikyc == "" || $verifyacp == "" || $menu_emp == "" || $add_emp == "" || $view_emp == ""){
                    echo "PLEASE SEND PROPER DATA";
                }else{
                    $data = array(
                                    "name" => $name,
                                    "password" => $password,
                                    "profile" => 'https://www.adobe.com/express/create/media_127540366421d3d5bfcaf8202527ca7d37741fd5d.jpeg',
                                    "type" => '1',
                                    "menu_member" => $menu_member,
                                    "add_whitelabel" => $add_whitelabel,
                                    "list_whitelabel" => $list_whitelabel,
                                    "list_users" => $list_users,
                                    "menu_wallet" => $menu_wallet,
                                    "wallet" => $wallet,
                                    "credit" => $credit,
                                    "debit" => $debit,
                                    "menu_transactions" => $menu_transactions,
                                    "iaeps" => $iaeps,
                                    "naeps" => $naeps,
                                    "bbps" => $bbps,
                                    "recharge" => $recharge,
                                    "dmt" => $dmt,
                                    "payout" => $payout,
                                    "qtransfer" => $qtransfer,
                                    "preg" => $preg,
                                    "pcopon" => $pcopon,
                                    "menu_setting" => $menu_setting,
                                    "pkg" => $pkg,
                                    "commission" => $commission,
                                    "manage_service" => $manage_service,
                                    "change_payout" => $change_payout,
                                    "news" => $news,
                                    "menu_validation" => $menu_validation,
                                    "icicikyc" => $icicikyc,
                                    "verifyacp" => $verifyacp,
                                    "menu_emp" => $menu_emp,
                                    "add_emp" => $add_emp,
                                    "view_emp" => $view_emp
                                    );
                                    $this->db->update('admin',$data,array('id' => $id));
                                    echo 1;
                }
                
	        }else{
	            echo "INVALID TOKEN";
	        }
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function dltempdata()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth'))
	        {
	            $id = $this->input->post('id');
	            if($id == ""){
	                echo "PLEASE SEND PROPER DATA";
	            }else{
	                $this->db->delete('admin',array('id' => $id));
	                echo 1;
	            }
	        }else{
	            echo "INVALID TOKEN";
	        }
	    }else{
	        redirect('/');
	    }
	}
	public function induskyc()
	{
	    if(isset($_SESSION['aid'])){
	        $domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
    		$this->load->view('admin/induskyc', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	
		public function apisetting()
	{
	    if(isset($_SESSION['aid'])){
	        $domain = $_SERVER['HTTP_HOST'];
		    $sdata = $this->db->get_where('sites',array('domain' => $domain))->row();
			$logo = $sdata->logo;
			$title = $sdata->title;
			$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
			$_SESSION['auth'] = $auth;
			$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
    		$this->load->view('admin/apisetting', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
	/*Code Changes By Krishna-AD-1 Date 18th April 20222*/
	public function approvenaeps()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $kid = $this->input->post('kid');
	            $agentId = $this->input->post('agentId');
                    
                    //echo $agentId;exit;
	            if($kid == "" || $agentId == ""){
	                echo "ERROR";
	            }else{
                       
                        $num_row_agent = $this->db->get_where('indus_kyc',array('agentId' =>$agentId))->num_rows();
	                if($num_row_agent==0){
                        $kdata = $this->db->get_where('indus_kyc',array('id' => $kid))->row();
	                
                        if($kdata->status == "PENDING"){
	                    $this->db->update('indus_kyc',array('status' => "APPROVED",'agentId' =>$agentId),array('id' => $kid));
	                    echo 1;
	                }else{
	                    echo "ERROR";
	                }
                        }else{
                            echo "Agent ID ".$agentId." is already used. Please enter unique Agent ID";
                        }
	            }
	        }else{
	            echo "INVALID TOKEN";
	        }
	    }else{
	        redirect('/admin');
	    }
	    
	}
	/*-End of Function-*/
	
	public function rejectnaeps()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $kid = $this->input->post('kid');
	            if($kid == ""){
	                echo "ERROR";
	            }else{
	                $kdata = $this->db->get_where('indus_kyc',array('id' => $kid))->row();
	                if($kdata->status == "PENDING"){
	                    $this->db->delete('indus_kyc',array('id' => $kid));
	                    echo 1;
	                }else{
	                    echo "ERROR";
	                }
	            }
	        }else{
	            echo "INVALID TOKEN";
	        }
	    }else{
	        redirect('/admin');
	    }
	    
	}
	public function updateservice()
	{
	    if(isset($_SESSION['aid'])){
	        if($_SESSION['auth'] == $this->input->post('auth')){
	            $aeps = $this->input->post('aeps');
                $bbps = $this->input->post('bbps');
                $recharge = $this->input->post('recharge');
                $payout = $this->input->post('payout');
                $uti = $this->input->post('uti');
                $qtransfer = $this->input->post('qtransfer');
                $dmt = $this->input->post('dmt');
                $iaeps = $this->input->post('iaeps');
                if($aeps == "" || $bbps == "" || $recharge == "" || $payout == "" || $uti == "" || $qtransfer == "" || $dmt == "" || $iaeps == ""){
                    echo "PLEASE SEND PROPER DATA";
                }else{
                    $site = $this->db->get_where('sites',array('rid' => $_SESSION['rid']))->row()->id;
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
                    $this->db->update('aservice',$data,array('id' => '1'));
                    echo 1;
                }
	        }else{
	            echo "INVALID TOKEN";
	        }
	    }else{
	        redirect('/admin');
	    }
	    
	}
	
	
	
	
	
	 /*Code By Krishna start KRISH-AD-AEPSLIST START*/
        
	public function aepslist()
	{
	    if(isset($_SESSION['aid'])){
	        $logo = $this->db->get_where('settings',array('name' => 'logo'))->row()->value;
    		$title = $this->db->get_where('settings',array('name' => 'title'))->row()->value;
    		$auth = "ECZ" . rand(00000, 99999) . rand(00000, 99999);
    		$_SESSION['auth'] = $auth;
    		$data = array('logo' => $logo, 'title' => $title, 'auth' => $auth);
    		$this->load->view('admin/transaction/aepslist', $data);
	    }else{
	        redirect('/admin');
	    }
	    
	}
        
        public function srhaepslist(){
            if($_SESSION['auth'] == $this->input->post('auth')){
	            $afrom = $this->input->post('from');
	            $ato = $this->input->post('to');
	            if($afrom == "" || $ato == "" ){
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
                    $resdata = $this->db->from("aeps_list")->where('created_at >=',$from)->where('created_at <=',$to)->where('status =','PENDING')->order_by('id',"DESC")->get()->result();
	            $data['resaeps']=$resdata;
                    $this->load->view('admin/transaction/srhaepslist',$data);
	        }else{
	            echo 1;exit;
	        }
        }
		

         /*Code By Krishna start KRISH-AD-AEPSLIST END*/
         
         
         
         
         
         
         
         
         
         
         
	
	
	
	
	
	
	
	
}