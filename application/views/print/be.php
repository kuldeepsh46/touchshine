<?php if($status == "SUCCESS"){ ?>
<h4 style="text-align:center;"><?php echo $title; ?></h4><br>
             <center>  <img src="<?php echo $logo; ?>" alt="logo" height="50px"> </center>
            <?php $user = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row(); ?>
             <div>
             <div class="form-group">
                 <div class="row form-control">
                    <label for="" class="">VLE Name : <strong> <?php echo $user->name; ?></strong></label>
                </div>
                <div class="row form-control">
                    <label for="" class="">VLE Mobile : <strong><?php echo $user->phone ?></strong></label>
                </div>
                <div class="row form-control">
                <label for="" class="">VLE Email : <strong><?php echo $user->email; ?></strong></label>
                </div>
                
                <hr>
                <center><img src="data:image/png;base64,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" height="20px"></center>
                                <hr>
                <div class="row">
                    <div class="col-md-6">
                    <span>Transaction Status</span>
                    </div>
                    <div class="col-md-6">
                        <span><i class="fa fa-check" aria-hidden="true"></i><?php echo $status; ?></span>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <span>Avail Balance</span>
                    </div>
                    <div class="col-md-6">
                        <span><i class="fa fa-check" aria-hidden="true"></i><?php echo $amount; ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <span>Transaction Id</span>
                    </div>
                    <div class="col-md-6">
                        <span><i class="fa fa-check" aria-hidden="true"></i><?php echo $txnid; ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <span>RRN</span>
                    </div>
                    <div class="col-md-6">
                        <span><i class="fa fa-check" aria-hidden="true"></i><?php echo $rrn; ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <span>Aadhar No.</span>
                    </div>
                    <div class="col-md-6">
                        <span><i class="fa fa-check" aria-hidden="true"></i><?php echo $aadhar; ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <span>BANK NAME.</span>
                    </div>
                    <div class="col-md-6">
                        <span><i class="fa fa-check" aria-hidden="true"></i><?php echo $this->db->get_where('banks',array('id' => $bank))->row()->name; ?></span>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                    <span>TIMESTAMP</span>
                    </div>
                    <div class="col-md-6">
                        <span><i class="fa fa-check" aria-hidden="true"></i><?php echo date("Y/m/d")." ".date("h:i:sa"); ?></span>
                    </div>
                </div>
                
             </div>
             
             
             <button type="button" class="btn btn-primary" onclick="makeprint();">Print</button>
             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

<?php }else{ ?>

<h4 style="text-align:center;"><?php echo $title; ?></h4><br>
             <center>  <img src="<?php echo $logo; ?>" alt="logo" height="50px"> </center>
            <?php $user = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row(); ?>

             <div>
             <div class="form-group">
                 <div class="row form-control">
                    <label for="" class="">VLE Name : <strong> <?php echo $user->name; ?></strong></label>
                </div>
                <div class="row form-control">
                    <label for="" class="">VLE Mobile : <strong><?php echo $user->phone ?></strong></label>
                </div>
                <div class="row form-control">
                <label for="" class="">VLE Email : <strong><?php echo $user->email; ?></strong></label>
                </div>
                
                <hr>
                <center><img src="data:image/png;base64,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" height="20px"></center>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                    <span>Transaction Status</span>
                    </div>
                    <div class="col-md-6">
                        <span><i class="fa fa-check" aria-hidden="true"></i><?php echo $status; ?></span>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <span>Transaction Id</span>
                    </div>
                    <div class="col-md-6">
                        <span><i class="fa fa-check" aria-hidden="true"></i><?php echo $txnid; ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <span>RRN</span>
                    </div>
                    <div class="col-md-6">
                        <span><i class="fa fa-check" aria-hidden="true"></i><?php echo $rrn; ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <span>Aadhar No.</span>
                    </div>
                    <div class="col-md-6">
                        <span><i class="fa fa-check" aria-hidden="true"></i><?php echo $aadhar; ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <span>BANK NAME.</span>
                    </div>
                    <div class="col-md-6">
                        <span><i class="fa fa-check" aria-hidden="true"></i><?php echo $this->db->get_where('banks',array('id' => $bank))->row()->name;; ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <span>MESSAGE</span>
                    </div>
                    <div class="col-md-6">
                        <span><i class="fa fa-check" aria-hidden="true"></i><?php echo $msg; ?></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                    <span>TIMESTAMP</span>
                    </div>
                    <div class="col-md-6">
                        <span><i class="fa fa-check" aria-hidden="true"></i><?php echo date("Y/m/d")." ".date("h:i:sa"); ?></span>
                    </div>
                </div>
                
             </div>
             
             
             <button type="button" class="btn btn-primary" onclick="makeprint();">Print</button>
             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
             
             <?php } ?>