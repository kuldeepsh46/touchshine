<?php $this->load->view('partner/header'); ?>
<style>
    .info-box-4 {
    box-shadow: 0 2px 10px rgb(0 0 0 / 20%);
    height: auto;
    display: flex;
    cursor: default;
    background-color: #fff;
    position: relative;
    overflow: hidden;
    margin-bottom: 30px;
    border-radius: 10px;
}
.info-box-4 .content {
    display: inline-block;
    padding: 12px 11px 0px 11px;
    width: 120%;
}
.content {
    background-color: white;
}
.head-center {
    justify-content: center;
    background-color: #5d6e23;
    margin: 10px 2px;
    border-radius: 5px;
    letter-spacing: 2px;
    font-weight: bold;
}
.head-center>div {
    color: #fff;
}
</style>

    <div class="block-header">
         <div class="card-header head-center">
              <div class="card-title">Pending Transaction</div>
         </div>
    <div class="row">
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm- col-xs-12">
                            <div class="info-box-4 hover-expand-effect">
                                <div class="content">
                                    <div class="box" style="height: 130px;">
                                        <a href= "/partner/profilekyc" </a>
                                        <p style="margin: 10px; text-align: center; color: #020202; font-size: 16px; background-color: FFA500; padding: 5px; color: #000000; font-weight: bold;">
                                            <span id="ContentPlaceHolder1_Label8" style="font-size: 14px;">Pending Profile KYC</span>
                                        </p>
                                        <p style="margin: 10px; text-align: center; color: #020202;">
                                        </p>

                                        <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                            <span>
                                                <?php

                                                  echo '<span id="lbltodayMtAmount" style="color:Black;font-weight:bold;">'.$kyccnt['pending_kyc'].'</span>'; 
                                                ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box-4 hover-expand-effect">
                                <div class="content">
                                    <a href= "#" </a>
                                    <div class="box" style="height: 130px;">
                                        <p style="margin: 10px; text-align: center; color: #020202; font-size: 16px; background-color: FFA500; padding: 5px; color: #000000; font-weight: bold;">
                                            <span id="ContentPlaceHolder1_Label17" style="font-size: 14px;">Pending AEPS KYC</span>
                                        </p>
                                        <p style="margin: 10px; text-align: center; color: #020202;">
                                        </p>
                                        <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                            <span>
                                                <?php
                                                  echo '<span id="lbltodayMtAmount" style="color:Black;font-weight:bold;">'.$aekyccnt['pending_aekyc'].'</span>'; 
                                                ?>        
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box-4 hover-expand-effect">
                                <div class="content">
                                    <a href= "#" </a>
                                    <div class="box" style="height: 130px;">
                                        <p style="margin: 10px; text-align: center; color: #020202; font-size: 16px; background-color: FFA500; padding: 5px; color: #000000; font-weight: bold;">
                                            <span style="font-size: 14px;">Pending AEPS TXN</span>
                                        </p>
                                        <p style="margin: 10px; text-align: center; color: #020202;">
                                        </p>
                                        <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                            <span>
                                                <span id="lbltodayvr" style="color:Black;font-weight:bold;"><?php echo $aepscnt['tot_pending_aeps'];?></span></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box-4 hover-expand-effect">
                                <div class="content">
                                    <a href= "https://moonexsoftware.co/cron/payout" </a>
                                    <div class="box" style="height: 130px;">
                                        <p style="margin: 10px; text-align: center; color: #020202; font-size: 16px; background-color: FFA500; padding: 5px; color: #000000; font-weight: bold;">
                                            <span style="font-size: 14px;">Pending Payout</span>
                                        </p>
                                        <p style="margin: 10px; text-align: center; color: #020202;">
                                        </p>
                                        <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                            <span>
                                                <span id="lbltodayvr" style="color:Black;font-weight:bold;"><?php echo $payoutcnt['tot_pending_payout'];?></span></span>

                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm- col-xs-12">
                            <div class="info-box-4 hover-expand-effect">
                                <div class="content">
                                    <a href= "https://moonexsoftware.co/cron/qtransfer" </a>
                                    <div class="box" style="height: 130px;">
                                        <p style="margin: 10px; text-align: center; color: #020202; font-size: 16px; background-color: FFA500; padding: 5px; color: #000000; font-weight: bold;">
                                            <span id="ContentPlaceHolder1_Label8" style="font-size: 14px;">Pending Q Transfer Txn</span>
                                        </p>
                                        <p style="margin: 10px; text-align: center; color: #020202;">
                                        </p>

                                        <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                            <span>
                                                <?php

                                                  echo '<span id="lbltodayMtAmount" style="color:Black;font-weight:bold;">'.$qtCnt['tot_pending_qt'].'</span>'; 
                                                ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box-4 hover-expand-effect">
                                <div class="content">
                                    <a href= "https://moonexsoftware.co/cron/dmt" </a>
                                    <div class="box" style="height: 130px;">
                                        <p style="margin: 10px; text-align: center; color: #020202; font-size: 16px; background-color: FFA500; padding: 5px; color: #000000; font-weight: bold;">
                                            <span id="ContentPlaceHolder1_Label17" style="font-size: 14px;">Pending DMT Txn</span>
                                        </p>
                                        <p style="margin: 10px; text-align: center; color: #020202;">
                                        </p>
                                        <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                            <span>
                                                <?php
                                                  echo '<span id="lbltodayMtAmount" style="color:Black;font-weight:bold;">'.$dmtCnt['tot_pending_dmt'].'</span>'; 
                                                ?>        
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box-4 hover-expand-effect">
                                <div class="content">
                                    <a href= "/partner/transrecharge" </a>
                                    <div class="box" style="height: 130px;">
                                        <p style="margin: 10px; text-align: center; color: #020202; font-size: 16px; background-color: FFA500; padding: 5px; color: #000000; font-weight: bold;">
                                            <span style="font-size: 14px;">Pending Recharge</span>
                                        </p>
                                        <p style="margin: 10px; text-align: center; color: #020202;">
                                        </p>
                                        <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                            <span>
                                                <span id="lbltodayvr" style="color:Black;font-weight:bold;"><?php echo $rechargeCnt['tot_pending_recharge'];?></span></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box-4 hover-expand-effect">
                                <div class="content">
                                    <a href= "/partner/approvepayout" </a>
                                    <div class="box" style="height: 130px;">
                                        <p style="margin: 10px; text-align: center; color: #020202; font-size: 16px; background-color: FFA500; padding: 5px; color: #000000; font-weight: bold;">
                                            <span style="font-size: 14px;">Pending Payout ACC Approval</span>
                                        </p>
                                        <p style="margin: 10px; text-align: center; color: #020202;">
                                        </p>
                                        <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                            <span>
                                                <span id="lbltodayvr" style="color:Black;font-weight:bold;"><?php echo $payoutAccCnt['tot_pending_payout_acc'];?></span></span>

                                        </p>
                                    </div>
                                </div>
                            </div>
                       </div>
                    </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box-4 hover-expand-effect">
                                    <div class="content">
                                        <a href= "/partner/memberlist" </a>
                                        <div class="box" style="height: 230px;">
                                            <p style="margin: 10px; text-align: center; color: #020202; font-size: 16px; background-color: 006400; padding: 5px; color: white; font-weight: bold;">
                                                <span id="ContentPlaceHolder1_Label8">Total Users</span>
                                            </p>
                                            <p style="margin: 10px; text-align: center; color: #020202;">
                                                <span id="ContentPlaceHolder1_Label11">Active Users</span>
                                            </p>
                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                                <span>
                                <span id="lbltodayqraccount" style="color:Black;font-weight:bold;"><?php echo $usercnt['active_users']?></span>
                                                </span>
                                            </p>
                                            <p style="margin: 10px; text-align: center; color: #020202;">
                                                <span id="ContentPlaceHolder1_Label14"> InActive Users</span>
                                            </p>
                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                                <span>
                                                    <span id="lbltodayqraccount" style="color:Black;font-weight:bold;"><?php echo $usercnt['inactive_users']?></span></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box-4 hover-expand-effect">
                                    <div class="content">
                                        <a href= "/partner/transpanrc" </a>
                                        <div class="box" style="height: 230px;">
                                            <p style="margin: 10px; text-align: center; color: #020202; font-size: 16px; background-color: 006400; padding: 5px; color: white; font-weight: bold;">
                                                <span id="ContentPlaceHolder1_Label17" style="font-size: 14px;">UTI Registration</span>
                                            </p>
                                            <p style="margin: 10px; text-align: center; color: #020202;">
                                                <span id="ContentPlaceHolder1_Label18">UTI Registration</span>
                                            </p>
                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                                <span>

                                                    <span id="lbltodayqraccount" style="color:Black;font-weight:bold;"><?php echo $partnercnt['active_reseller']?></span>
                                                </span>
                                            </p>
                                            <p style="margin: 10px; text-align: center; color: #020202;">
                                                <span id="ContentPlaceHolder1_Label20">Inactive Partner</span>
                                            </p>
                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                                <span>
                                                    <span id="lbltodayqraccount" style="color:Black;font-weight:bold;"><?php echo $partnercnt['inactive_reseller']?></span></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box-4 hover-expand-effect">
                                    <div class="content">
                                    <a href= "/partner/profilekyc" </a>
                                        <div class="box" style="height: 230px;">
                                            <p style="margin: 10px; text-align: center; color: #020202; font-size: 16px; background-color: 006400; padding: 5px; color: white; font-weight: bold;">
                                                <span style="font-size: 14px;">Profile KYC</span>
                                            </p>
                                            <p style="margin: 10px; text-align: center; color: #020202;">
                                                <span>Completed KYC</span>
                                            </p>
                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                                <span>
 <?php

                                                  echo '<span id="lbltodayMtAmount" style="color:Black;font-weight:bold;">'.$kyccnt['completed_kyc'].'</span>'; 
                                                ?> </span>
                                            </p>
                                            <p style="margin: 10px; text-align: center; color: #020202;">
                                                <span>Incomplete KYC</span>
                                            </p>
                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                                <span>
                                                <?php
                                                  echo '<span id="lbltodayMtAmount" style="color:Black;font-weight:bold;">'.$kyccnt['incomplete_kyc'].'</span>'; 
                                                ?>     
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box-4 hover-expand-effect">
                                    <div class="content">
                                        <a href= "/partner/memberlist" </a>
                                        <div class="box" style="height: 230px;">
                                            <p style="margin: 10px; text-align: center; color: #020202; font-size: 16px; background-color: 006400; padding: 5px; color: white; font-weight: bold;">
                                                <span style="font-size: 14px;">AEPS Onboarded User</span>
                                            </p>
                                            <p style="margin: 10px; text-align: center; color: #020202;">
                                                <span>Total On boarded</span>
                                            </p>
                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                                <span>
 <?php
                                                  echo '<span id="lbltodayMtAmount" style="color:Black;font-weight:bold;">'.$aekyccnt['completed_aekyc'].'</span>'; 
                                                ?>  </span>
                                            </p>
                                            <p style="margin: 10px; text-align: center; color: #020202;">
                                                <span>Pending For On boarding</span>
                                            </p>
                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                                <span>
                                                    <span id="lbltodayvraccount" style="color:Black;font-weight:bold;">
                                                        <?php
                                                        $total_active_users=isset($usercnt['active_users'])?$usercnt['active_users']:0;
                                                        $total_pwaeps_comp=isset($aekyccnt['completed_aekyc'])?$aekyccnt['completed_aekyc']:0;
                                                        echo $total_active_users-$total_pwaeps_comp;
                                                        ?>
                                                    </span>
                                                        
                                                </span>

                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                                 <div class="card-header head-center">
                                <div class="card-title">Daily Transaction</div>
                            </div>
                            <div class="row">
                        </div>
                        <div class="row">

                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box-4 hover-expand-effect">
                                    <div class="content">
                                        <div class="box" style="height: 210px;">
                                            <p style="margin: 10px; text-align: center; color: #020202; font-size: 16px; background-color: 150570; padding: 5px; color: white; font-weight: bold;">
                                                <span id="ContentPlaceHolder1_Label27" style="font-size: 14px;">Today(Recharge) </span>
                                            </p>
                                            <p style="margin: 10px; text-align: center; color: #020202;">
                                                <span id="ContentPlaceHolder1_Label28">Total Amount</span>
                                            </p>
                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                                <span id="ContentPlaceHolder1_Label29">
                                                    <span id="lbltodayRechargeAmt" style="color:Black;font-weight:bold;">
                                                        <?php echo isset($today_summary['recharge']['total_txn_amt'])?$today_summary['recharge']['total_txn_amt']:'0.00';?>
                                                    </span>
                                                </span>
                                            </p>
                                            <p style="margin: 10px; text-align: center; color: #020202;">
                                                <span id="ContentPlaceHolder1_Label30">Total Transaction</span>
                                            </p>
                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                                <span id="ContentPlaceHolder1_Label31">
                                                    <span id="lbltodayRechargeCount" style="color:Black;font-weight:bold;">
                                                        <?php echo isset($today_summary['recharge']['num_txn'])?$today_summary['recharge']['num_txn']:'0';?>
                                                        </span>
                                                </span>
                                            </p>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box-4 hover-expand-effect">
                                    <div class="content">
                                        <div class="box" style="height: 210px;">
                                            <p style="margin: 10px; text-align: center; color: #020202; font-size: 16px; background-color: 150570; padding: 5px; color: white; font-weight: bold;">
                                                <span id="ContentPlaceHolder1_Label27" style="font-size: 14px;">Today(BBPS) </span>
                                            </p>
                                            <p style="margin: 10px; text-align: center; color: #020202;">
                                                <span id="ContentPlaceHolder1_Label28">Total Amount</span>
                                            </p>
                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                                <span>
                                                    <span id="lbltodaybbpsAmt" style="color:Black;font-weight:bold;">
                                                         <?php echo isset($today_summary['bbps']['total_txn_amt'])?$today_summary['bbps']['total_txn_amt']:'0.00';?>
                                                    
                                                    </span></span>
                                            </p>
                                            <p style="margin: 10px; text-align: center; color: #020202;">
                                                <span id="ContentPlaceHolder1_Label30">Total Transaction</span>
                                            </p>
                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                                <span>
                                                    <span id="lbltodaybbpsCount" style="color:Black;font-weight:bold;">
                                                        <?php echo isset($today_summary['bbps']['num_txn'])?$today_summary['bbps']['num_txn']:'0';?>
                                                         </span>
                                                </span>
                                            </p>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box-4 hover-expand-effect">
                                    <div class="content">
                                        <div class="box" style="height: 210px;">
                                            <p style="margin: 10px; text-align: center; color: #020202; font-size: 16px; background-color: 150570; padding: 5px; color: white; font-weight: bold;">
                                                <span>Today (AEPS)</span>
                                            </p>
                                            <p style="text-align: center; color: #5b5a5a;">
                                                <span id="ContentPlaceHolder1_lbltodyamt">Transaction Amount</span>
                                            </p>

                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                                <span id="lblaepstodayamt" style="color:Black;font-weight:bold;">
                                                     <?php echo isset($today_summary['aeps']['total_txn_amt'])?$today_summary['aeps']['tot_amt_cw']:'0.00';?>
                                                    
                                                </span>
                                            </p>
                                            <p style="text-align: center; color: #5b5a5a; margin: 10px;">
                                                <span id="ContentPlaceHolder1_Label15">Total Transaction</span>

                                            </p>
                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                                <span id="lblaepstodaytransac" style="color:Black;font-weight:bold;">
                                                 <?php echo isset($today_summary['aeps']['tot_success_cw'])?$today_summary['aeps']['tot_success_cw']:'0';?>
                                                  </span>
                                                </span>
                                            </p>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box-4 hover-expand-effect">
                                    <div class="content">
                                        <div class="box" style="height: 210px;">
                                            <p style="margin: 10px; text-align: center; color: #020202; font-size: 16px; background-color: 150570; padding: 5px; color: white; font-weight: bold;">
                                                <span id="ContentPlaceHolder1_Label22" style="font-size: 14px;">Today Payout </span> 
                                            </p>
                                            <p style="margin: 10px; text-align: center; color: #020202;">
                                                <span id="ContentPlaceHolder1_Label23">Total Amount</span>
                                            </p>
                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                                <span id="lbltodayaepsloan" style="color:Black;font-weight:bold;"><?php echo isset($today_summary['payout']['total_txn_amt'])?$today_summary['payout']['total_txn_amt']:'0.00';?></span>
                                            </p>
                                            <p style="margin: 10px; text-align: center; color: #020202;">
                                                <span id="ContentPlaceHolder1_Label25">Total Transaction</span>
                                            </p>
                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                                <span id="lbltodayaepsint" style="color:Black;font-weight:bold;">
                                                    <?php echo isset($today_summary['payout']['num_txn'])?$today_summary['payout']['num_txn']:'0';?>
                                                     </span>
                                                </span>
                                            </p>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box-4 hover-expand-effect">
                                    <div class="content">
                                        <div class="box" style="height: 210px;">
                                            <p style="margin: 10px; text-align: center; color: #020202; font-size: 16px; background-color: 150570; padding: 5px; color: white; font-weight: bold;">
                                                <span id="ContentPlaceHolder1_Label22" style="font-size: 14px; font-weight: bold;">Today (DMT) </span>
                                            </p>
                                            <p style="margin: 10px; text-align: center; color: #020202;">
                                                <span id="ContentPlaceHolder1_Label23">Total Amount</span>
                                            </p>
                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                                <span id="lbltodayaepsloan" style="color:Black;font-weight:bold;"><?php echo isset($today_summary['dmt']['total_txn_amt'])?$today_summary['dmt']['total_txn_amt']:'0.00';?></span>
                                           </p>
                                            <p style="margin: 10px; text-align: center; color: #020202;">
                                                <span id="ContentPlaceHolder1_Label25">No. Of Transaction</span>
                                            </p>
                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                                <span id="lbltodaydmtcount" style="color:Black;font-weight:bold;">
                                                    <?php echo isset($today_summary['dmt']['num_txn'])?$today_summary['dmt']['num_txn']:'0';?>
                                                     </span>
                                                </span>
                                            </p>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box-4 hover-expand-effect">
                                    <div class="content">
                                        <div class="box" style="height: 210px;">
                                            <p style="margin: 10px; text-align: center; color: #020202; font-size: 16px; background-color: 150570; padding: 5px; color: white; font-weight: bold;">
                                                <span id="ContentPlaceHolder1_Label32" style="font-size: 14px; font-weight: bold;">Today (Quick Transfer) </span>
                                            </p>
                                            <p style="margin: 10px; text-align: center; color: #020202;">
                                                <span id="ff">Total Amount</span>
                                            </p>
                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">

                                         <span id="lbltodayaepsloan" style="color:Black;font-weight:bold;"><?php echo isset($today_summary['qtrans']['total_txn_amt'])?$today_summary['qtrans']['total_txn_amt']:'0.00';?></span>
                                           
                                            </p>
                                            <p style="margin: 10px; text-align: center; color: #020202;">
                                                <span id="dfd">No. Of Transaction</span>
                                            </p>
                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">

                                                <span id="lbltodaymatmcount" style="color:Black;font-weight:bold;">
                                                    <?php echo isset($today_summary['qtrans']['num_txn'])?$today_summary['qtrans']['num_txn']:'0';?>
                                                     </span>
                                                </span>
                                            </p>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box-4 hover-expand-effect">
                                    <div class="content">
                                        <div class="box" style="height: 210px;">
                                            <p style="margin: 10px; text-align: center; color: #020202; font-size: 16px; background-color: 150570; padding: 5px; color: white; font-weight: bold;">
                                                <span id="ContentPlaceHolder1_Label22" style="font-size: 14px; font-weight: bold;">Today (MS & BE ) </span>
                                            </p>
                                            <p style="margin: 10px; text-align: center; color: #020202;">
                                                <span id="ContentPlaceHolder1_Label23">Today (Mini statement)</span>
                                            </p>
                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                                <span id="lbltodaymini" style="color:Black;font-weight:bold;">
                                                    <?php echo isset($today_summary['aeps']['tot_success_mn'])?$today_summary['aeps']['tot_success_mn']:'0';?>
                                                 
                                                </span>
                                            </p>
                                            <p style="margin: 10px; text-align: center; color: #020202;">
                                                <span id="ContentPlaceHolder1_Label25"> Today (balance Enquriy)</span>
                                            </p>
                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                                <span id="lblyesmini" style="color:Black;font-weight:bold;">
                                                    <?php echo isset($today_summary['aeps']['tot_success_beq'])?$today_summary['aeps']['tot_success_beq']:'0';?>
                                                     </span>
                                                </span>
                                            </p>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box-4 hover-expand-effect">
                                    <div class="content">
                                        <div class="box" style="height: 210px;">
                                            <p style="margin: 10px; text-align: center; color: #020202; font-size: 16px; background-color: 150570; padding: 5px; color: white; font-weight: bold;">
                                                <span id="ContentPlaceHolder1_Label22" style="font-size: 14px; font-weight: bold;">Today(Aadhar Pay) </span>
                                            </p>
                                            <p style="margin: 10px; text-align: center; color: #020202;">
                                                <span id="ContentPlaceHolder1_Label23">Today Txn</span>
                                            </p>
                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                                <span id="lbltodayaadhar" style="color:Black;font-weight:bold;">0.00</span>
                                            </p>
                                            <p style="margin: 10px; text-align: center; color: #020202;">
                                                <span id="ContentPlaceHolder1_Label25">Yesterday Txn</span>
                                            </p>
                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                                <span id="lblyesaadhar" style="color:Black;font-weight:bold;">0.00</span>
                                                 </span>
                                                </span>
                                            </p>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="block-header">

                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box-4 hover-expand-effect">
                                    <div class="content">
                                        <div class="box" style="height: 210px;">
                                            <p style="margin: 10px; text-align: center; color: #020202; font-size: 16px; background-color: 150570; padding: 5px; color: white; font-weight: bold;">
                                                <span id="ContentPlaceHolder1_Label8">Today (UTI)
                                                </span>
                                            </p>
                                            <p style="margin: 10px; text-align: center; color: #020202;">
                                                <span id="ContentPlaceHolder1_Label11">Total Member Created</span>
                                            </p>
                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                                <span>
                                                    <span id="lbltodayMtAmount" style="color:Black;font-weight:bold;"><?php echo isset($today_summary['uti']['tot_uti'])?$today_summary['uti']['tot_uti']:'0';?></span></span>
                                            </p>
                                            <p style="margin: 10px; text-align: center; color: #020202;">
                                                <span id="ContentPlaceHolder1_Label14">Total Token Sale</span>
                                            </p>
                                            <p style="background-color: white; border: dotted 1px #676f6f; text-align: center; padding: 7px; font-size: 16px; width: 52%; margin: auto; height: 40px;">
                                                <span>
                                                    <span id="lbltodayMTcount" style="color:Black;font-weight:bold;"><?php echo isset($today_summary['uti']['token_sale'])?$today_summary['uti']['token_sale']:'0';?></span></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('partner/footer'); ?>