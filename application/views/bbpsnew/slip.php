<h4 style="text-align:center;"><?php echo $title; ?></h4><br>
<center>  <img src="<?php echo $logo; ?>" alt="logo" height="50px"> </center>
<?php $user = $this->db->get_where('users',array('id' => $_SESSION['uid']))->row(); ?>
<center>  <h3>Status: <?php echo $status; ?></h3> </center>
<div>
     <div class="form-group">
         <div class="row form-control">
            <label for="" class="">VLE Name : <strong> <?php echo $user->name; ?></strong></label>
        </div>
        <div class="row form-control">
            <label for="" class="">VLE Name : <strong> <?php echo $user->phone; ?></strong></label>
        </div>
        <div class="row form-control">
            <label for="" class="">VLE Name : <strong> <?php echo $user->email; ?></strong></label>
        </div>
     </div>
     <hr>
     <?php if($status == "SUCCESS"){ ?>
     <!--success-->
     <div class="form-group">
         <div class="row form-control">
            <label for="" class="">Message : <strong> <?php echo $msg; ?></strong></label>
        </div>
        <div class="row form-control">
            <label for="" class="">Biller : <strong> <?php echo $biller; ?></strong></label>
        </div>
        <div class="row form-control">
            <label for="" class="">Amount : <strong> <?php echo $billamount; ?></strong></label>
        </div>
        <div class="row form-control">
            <label for="" class="">Txnid : <strong> <?php echo $txnid; ?></strong></label>
        </div>
     </div>
     
     <?php }else{ ?>
     <!--failed-->
     <div class="form-group">
         <div class="row form-control">
            <label for="" class="">Message : <strong> <?php echo $msg; ?></strong></label>
        </div>
     </div>
     
     
     <?php } ?>
     <button type="button" class="btn btn-primary" onclick="makeprint();">Print</button>
     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>