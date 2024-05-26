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
                        <span><i class="fa fa-check" aria-hidden="true"></i><?php echo $UTR; ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <span>Amount</span>
                    </div>
                    <div class="col-md-6">
                        <span><i class="fa fa-check" aria-hidden="true"></i><?php echo $amount; ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <span>Account No.</span>
                    </div>
                    <div class="col-md-6">
                        <span><i class="fa fa-check" aria-hidden="true"></i><?php echo $account; ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <span>IFSC</span>
                    </div>
                    <div class="col-md-6">
                        <span><i class="fa fa-check" aria-hidden="true"></i><?php echo $ifsc; ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <span>NAME</span>
                    </div>
                    <div class="col-md-6">
                        <span><i class="fa fa-check" aria-hidden="true"></i><?php echo $bname; ?></span>
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