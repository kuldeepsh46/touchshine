<?php
class Partnercommission extends CI_Controller
{
    public function recharge()
    {
        if(isset($_SESSION['rid']))
        {
            if($_SESSION['auth'] == $this->input->post("auth"))
            {
                
                $ops = $this->db->get('rechargev2op')->result();
                $package = $this->input->post("package");
	            $index = 1;
	            foreach($ops as $r)
	            {
	                $opname = "op".$index;
	                $op = $this->input->post($opname);
	                $amountname = "amount".$index;
	                $amount = $this->input->post($amountname);
	                $percentname = "percent".$index;
	                $percent = $this->input->post($percentname);
	                if($percent == 1)
	                {
	                    $percent = 1;
	                }else{
	                    
	                    $percent =0;
	                }
	                $data = array(
	                   
	                    'amount' => $amount,
	                    'percent' => $percent
	                    
	                    );
	                   $this->db->update('comissionv2', $data, array('package' => $package,'operator' => $op));
	                
	                
	                
	                
	                
	                
	                $index++;
	            }
                
                redirect("/partner/commission");
            
                
            }else{
                echo "TOKEN MISMATCH";
            }
            
            
            
            
        }else{
            
            echo "SESSION EXPIRED";
        }
        
    }
	
	public function recharge_lapu()
    {
        if(isset($_SESSION['rid']))
        {
            if($_SESSION['auth'] == $this->input->post("auth"))
            {
                
                $ops = $this->db->get('rechargev2op_lapu')->result();
                $package = $this->input->post("package");
	            $index = 1;
	            foreach($ops as $r)
	            {
	                $opname = "op".$index;
	                $op = $this->input->post($opname);
	                $amountname = "amount".$index;
	                $amount = $this->input->post($amountname);
	                $percentname = "percent".$index;
	                $percent = $this->input->post($percentname);
	                if($percent == 1)
	                {
	                    $percent = 1;
	                }else{
	                    
	                    $percent =0;
	                }
	               $rdata = $this->db->get_where('comissionv2_lapu',array('package' => $package,'operator' => $op))->row();
					if($rdata)
					{
						 $data = array(	                   
	                    'amount' => $amount,
	                    'percent' => $percent
	                    );
	                   $this->db->update('comissionv2_lapu', $data, array('package' => $package,'operator' => $op));
					}else{
						$data = array(	                   
	                    'amount' => $amount,
	                    'percent' => $percent,
						'package' => $package,
						'operator' => $op
	                    );
	                   $this->db->insert('comissionv2_lapu', $data);
					}
					   
	                $index++;
	            }
                
                redirect("/partner/commission");
            
                
            }else{
                echo "TOKEN MISMATCH";
            }
            
            
            
            
        }else{
            
            echo "SESSION EXPIRED";
        }
        
    }
	
     public function dmt()
    {
        if(isset($_SESSION['rid']))
        {
            if($_SESSION['auth'] == $this->input->post("auth"))
            {
                
               
                $package = $this->input->post("package");
	            $index = 1;
	            $datas = $this->db->get_where('dmtcharge',array('package' => $package))->result();
	            foreach($datas as $data)
	            {
	                
	               $fromaname = "froma".$index;
	               $toaname = "toa".$index; 
	               $amountname = "amount".$index; 
	               $percentname = "percent".$index; 
	               
	               $froma  = $this->input->post($fromaname);
	               $toa  = $this->input->post($toaname);
	               $amount  = $this->input->post($amountname);
	               $percent  = $this->input->post($percentname);
	               if($percent == 1)
	               {
	                   $percent =1; 
	                   
	               }else{
	                   $percent =0;   
	               }
	                
	                $dat = array(
	                   
	                    'froma' => $froma,
	                    'toa' => $toa,
	                    'amount' =>$amount,
	                    'percent'=>$percent
	                    
	                    );
	                   $this->db->update('dmtcharge', $dat, array('id' => $data->id));
	                
	                
	                
	                
	                $index++;
	            }
	           
	         
                
                redirect("/partner/commission");
            
                
            }else{
                echo "TOKEN MISMATCH";
            }
            
            
            
            
        }else{
            
            echo "SESSION EXPIRED";
        }
        
    }
     public function icw()
    {
        if(isset($_SESSION['rid']))
        {
            if($_SESSION['auth'] == $this->input->post("auth"))
            {
                
               
                $package = $this->input->post("package");
	            $index = 1;
	            $datas = $this->db->get_where('icaepscomission',array('package' => $package))->result();
	            foreach($datas as $data)
	            {
	                
	               $fromaname = "froma".$index;
	               $toaname = "toa".$index; 
	               $amountname = "amount".$index; 
	               $percentname = "percent".$index; 
	               
	               $froma  = $this->input->post($fromaname);
	               $toa  = $this->input->post($toaname);
	               $amount  = $this->input->post($amountname);
	               $percent  = $this->input->post($percentname);
	               if($percent == 1)
	               {
	                   $percent =1; 
	                   
	               }else{
	                   $percent =0;   
	               }
	                
	                $dat = array(
	                   
	                    'froma' => $froma,
	                    'toa' => $toa,
	                    'amount' =>$amount,
	                    'percent'=>$percent
	                    
	                    );
	                   $this->db->update('icaepscomission', $dat, array('id' => $data->id));
	                
	                
	                
	                
	                $index++;
	            }
	           
	         
                
                redirect("/partner/commission");
            
                
            }else{
                echo "TOKEN MISMATCH";
            }
            
            
            
            
        }else{
            
            echo "SESSION EXPIRED";
        }
        
    }
    public function iap()
    {
        if(isset($_SESSION['rid']))
        {
            if($_SESSION['auth'] == $this->input->post("auth"))
            {
                
               
                $package = $this->input->post("package");
	            $index = 1;
	            $datas = $this->db->get_where('icapcharge',array('package' => $package))->result();
	            foreach($datas as $data)
	            {
	                
	               $fromaname = "froma".$index;
	               $toaname = "toa".$index; 
	               $amountname = "amount".$index; 
	               $percentname = "percent".$index; 
	               
	               $froma  = $this->input->post($fromaname);
	               $toa  = $this->input->post($toaname);
	               $amount  = $this->input->post($amountname);
	               $percent  = $this->input->post($percentname);
	               if($percent == 1)
	               {
	                   $percent =1; 
	                   
	               }else{
	                   $percent =0;   
	               }
	                
	                $dat = array(
	                   
	                    'froma' => $froma,
	                    'toa' => $toa,
	                    'amount' =>$amount,
	                    'percent'=>$percent
	                    
	                    );
	                   $this->db->update('icapcharge', $dat, array('id' => $data->id));
	                
	                
	                
	                
	                $index++;
	            }
	           
	         
                
                redirect("/partner/commission");
            
                
            }else{
                echo "TOKEN MISMATCH";
            }
            
            
            
            
        }else{
            
            echo "SESSION EXPIRED";
        }
        
    }
    public function icd()
    {
        if(isset($_SESSION['rid']))
        {
            if($_SESSION['auth'] == $this->input->post("auth"))
            {
                
               
                $package = $this->input->post("package");
	            $index = 1;
	            $datas = $this->db->get_where('icdpcomission',array('package' => $package))->result();
	            foreach($datas as $data)
	            {
	                
	               $fromaname = "froma".$index;
	               $toaname = "toa".$index; 
	               $amountname = "amount".$index; 
	               $percentname = "percent".$index; 
	               
	               $froma  = $this->input->post($fromaname);
	               $toa  = $this->input->post($toaname);
	               $amount  = $this->input->post($amountname);
	               $percent  = $this->input->post($percentname);
	               if($percent == 1)
	               {
	                   $percent =1; 
	                   
	               }else{
	                   $percent =0;   
	               }
	                
	                $dat = array(
	                   
	                    'froma' => $froma,
	                    'toa' => $toa,
	                    'amount' =>$amount,
	                    'percent'=>$percent
	                    
	                    );
	                   $this->db->update('icdpcomission', $dat, array('id' => $data->id));
	                
	                
	                
	                
	                $index++;
	            }
	           
	         
                
                redirect("/partner/commission");
            
                
            }else{
                echo "TOKEN MISMATCH";
            }
            
            
            
            
        }else{
            
            echo "SESSION EXPIRED";
        }
        
    }
    public function ncw()
    {
        if(isset($_SESSION['rid']))
        {
            if($_SESSION['auth'] == $this->input->post("auth"))
            {
                
               
                $package = $this->input->post("package");
	            $index = 1;
	            $datas = $this->db->get_where('aepscomission',array('package' => $package))->result();
	            foreach($datas as $data)
	            {
	                
	               $fromaname = "froma".$index;
	               $toaname = "toa".$index; 
	               $amountname = "amount".$index; 
	               $percentname = "percent".$index; 
	               
	               $froma  = $this->input->post($fromaname);
	               $toa  = $this->input->post($toaname);
	               $amount  = $this->input->post($amountname);
	               $percent  = $this->input->post($percentname);
	               if($percent == 1)
	               {
	                   $percent =1; 
	                   
	               }else{
	                   $percent =0;   
	               }
	                
	                $dat = array(
	                   
	                    'froma' => $froma,
	                    'toa' => $toa,
	                    'amount' =>$amount,
	                    'percent'=>$percent
	                    
	                    );
	                   $this->db->update('aepscomission', $dat, array('id' => $data->id));
	                
	                
	                
	                
	                $index++;
	            }
	           
	         
                
                redirect("/partner/commission");
            
                
            }else{
                echo "TOKEN MISMATCH";
            }
            
            
            
            
        }else{
            
            echo "SESSION EXPIRED";
        }
        
    }
    public function nap()
    {
        if(isset($_SESSION['rid']))
        {
            if($_SESSION['auth'] == $this->input->post("auth"))
            {
                
               
                $package = $this->input->post("package");
	            $index = 1;
	            $datas = $this->db->get_where('adhaarpaycharge',array('package' => $package))->result();
	            foreach($datas as $data)
	            {
	                
	               $fromaname = "froma".$index;
	               $toaname = "toa".$index; 
	               $amountname = "amount".$index; 
	               $percentname = "percent".$index; 
	               
	               $froma  = $this->input->post($fromaname);
	               $toa  = $this->input->post($toaname);
	               $amount  = $this->input->post($amountname);
	               $percent  = $this->input->post($percentname);
	               if($percent == 1)
	               {
	                   $percent =1; 
	                   
	               }else{
	                   $percent =0;   
	               }
	                
	                $dat = array(
	                   
	                    'froma' => $froma,
	                    'toa' => $toa,
	                    'amount' =>$amount,
	                    'percent'=>$percent
	                    
	                    );
	                   $this->db->update('adhaarpaycharge', $dat, array('id' => $data->id));
	                
	                
	                
	                
	                $index++;
	            }
	           
	         
                
                redirect("/partner/commission");
            
                
            }else{
                echo "TOKEN MISMATCH";
            }
            
            
            
            
        }else{
            
            echo "SESSION EXPIRED";
        }
        
    }
    public function ims()
    {
        
        if(isset($_SESSION['rid']))
        {
            if($_SESSION['auth'] == $this->input->post("auth"))
            {
                
               $amount = $this->input->post('amount');
               $package = $this->input->post('package');
	                $data = array(
	                   
	                    'amount' => $amount,
	                    
	                    
	                    );
	                   $this->db->update('mscom', $data, array('package' => $package,'type' => "1"));
	                
	                
	                
	                
	             
                
                redirect("/partner/commission");
            
                
            }else{
                echo "TOKEN MISMATCH";
            }
            
            
            
            
        }else{
            
            echo "SESSION EXPIRED";
        }
        
        
    }
    public function nms()
    {
        
        if(isset($_SESSION['rid']))
        {
            if($_SESSION['auth'] == $this->input->post("auth"))
            {
                
               $amount = $this->input->post('amount');
               $package = $this->input->post('package');
	                $data = array(
	                   
	                    'amount' => $amount,
	                    
	                    
	                    );
	                   $this->db->update('mscom', $data, array('package' => $package,'type' => "2"));
	                
	                
	                
	                
	             
                
                redirect("/partner/commission");
            
                
            }else{
                echo "TOKEN MISMATCH";
            }
            
            
            
            
        }else{
            
            echo "SESSION EXPIRED";
        }
        
        
    }
    public function uti()
    {
        
        if(isset($_SESSION['rid']))
        {
            if($_SESSION['auth'] == $this->input->post("auth"))
            {
                
              
                $package = $this->input->post("package");
	            $amount = $this->input->post("amount");
	            $dat = array('amount' => $amount);
	            
	            $this->db->update('coponcharge', $dat, array('package' => $package));
                
                redirect("/partner/commission");
            
                
            }else{
                echo "TOKEN MISMATCH";
            }
            
            
            
            
        }else{
            
            echo "SESSION EXPIRED";
        }
        
        
    }
     public function payoutimps()
    {
        if(isset($_SESSION['rid']))
        {
            if($_SESSION['auth'] == $this->input->post("auth"))
            {
                
               
                $package = $this->input->post("package");
	            $index = 1;
	            $datas = $this->db->get_where('payoutchargeimps',array('package' => $package))->result();
	            foreach($datas as $data)
	            {
	                
	               $fromaname = "froma".$index;
	               $toaname = "toa".$index; 
	               $amountname = "amount".$index; 
	               $percentname = "percent".$index; 
	               
	               $froma  = $this->input->post($fromaname);
	               $toa  = $this->input->post($toaname);
	               $amount  = $this->input->post($amountname);
	               $percent  = $this->input->post($percentname);
	               if($percent == 1)
	               {
	                   $percent =1; 
	                   
	               }else{
	                   $percent =0;   
	               }
	                
	                $dat = array(
	                   
	                    'froma' => $froma,
	                    'toa' => $toa,
	                    'amount' =>$amount,
	                    'percent'=>$percent
	                    
	                    );
	                   $this->db->update('payoutchargeimps', $dat, array('id' => $data->id));
	                
	                
	                
	                
	                $index++;
	            }
	           
	         
                
                redirect("/partner/commission");
            
                
            }else{
                echo "TOKEN MISMATCH";
            }
            
            
            
            
        }else{
            
            echo "SESSION EXPIRED";
        }
        
    }
     public function payoutneft()
    {
        if(isset($_SESSION['rid']))
        {
            if($_SESSION['auth'] == $this->input->post("auth"))
            {
                
               
                $package = $this->input->post("package");
	            $index = 1;
	            $datas = $this->db->get_where('payoutchargeneft',array('package' => $package))->result();
	            foreach($datas as $data)
	            {
	                
	               $fromaname = "froma".$index;
	               $toaname = "toa".$index; 
	               $amountname = "amount".$index; 
	               $percentname = "percent".$index; 
	               
	               $froma  = $this->input->post($fromaname);
	               $toa  = $this->input->post($toaname);
	               $amount  = $this->input->post($amountname);
	               $percent  = $this->input->post($percentname);
	               if($percent == 1)
	               {
	                   $percent =1; 
	                   
	               }else{
	                   $percent =0;   
	               }
	                
	                $dat = array(
	                   
	                    'froma' => $froma,
	                    'toa' => $toa,
	                    'amount' =>$amount,
	                    'percent'=>$percent
	                    
	                    );
	                   $this->db->update('payoutchargeneft', $dat, array('id' => $data->id));
	                
	                
	                
	                
	                $index++;
	            }
	           
	         
                
                redirect("/partner/commission");
            
                
            }else{
                echo "TOKEN MISMATCH";
            }
            
            
            
            
        }else{
            
            echo "SESSION EXPIRED";
        }
        
    }
     public function qtransfer()
    {
        if(isset($_SESSION['rid']))
        {
            if($_SESSION['auth'] == $this->input->post("auth"))
            {
                
               
                $package = $this->input->post("package");
	            $index = 1;
	            $datas = $this->db->get_where('qtransfer',array('package' => $package))->result();
	            foreach($datas as $data)
	            {
	                
	               $fromaname = "froma".$index;
	               $toaname = "toa".$index; 
	               $amountname = "amount".$index; 
	               $percentname = "percent".$index; 
	               
	               $froma  = $this->input->post($fromaname);
	               $toa  = $this->input->post($toaname);
	               $amount  = $this->input->post($amountname);
	               $percent  = $this->input->post($percentname);
	               if($percent == 1)
	               {
	                   $percent =1; 
	                   
	               }else{
	                   $percent =0;   
	               }
	                
	                $dat = array(
	                   
	                    'froma' => $froma,
	                    'toa' => $toa,
	                    'amount' =>$amount,
	                    'percent'=>$percent
	                    
	                    );
	                   $this->db->update('qtransfer', $dat, array('id' => $data->id));
	                
	                
	                
	                
	                $index++;
	            }
	           
	         
                
                redirect("/partner/commission");
            
                
            }else{
                echo "TOKEN MISMATCH";
            }
            
            
            
            
        }else{
            
            echo "SESSION EXPIRED";
        }
        
    }
}