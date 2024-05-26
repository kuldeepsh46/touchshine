<?php 
class Recdemo extends CI_controller{
    public function index(){
      // $this->load->model("payout_model");
         //  $this->payout_model->charge(7,100,'NEFTTEST765656','payoutchargeneft',1);
          
           $this->load->model("iaeps_model");
           $this->iaeps_model->commission(7,200,'hjkhfjksh',1);
          //  $this->load->model("dmt_model");
          // $this->dmt_model->charge(7,270,'DMTCARG',1);
           //$this->load->model("naeps_model");
           // $this->naeps_model->commission(7,200,'NAEPSyty',1);
             // $this->naeps_model->msCommission(6,'NAEPSmsTxn');
             
                // $this->load->model("ap_model");
                // $this->ap_model->charge(7,101,'APDMO',1);
    }
}