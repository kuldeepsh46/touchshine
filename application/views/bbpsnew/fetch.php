<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Bill Data</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
<?php if($dat->status == "ERROR"){ ?>
<center>
    <img src="https://www.arttdinox.com/assets/web/wrong.gif" height="100px">
    <h5>Message: </h5><p><?php echo $dat->msg; ?></p>
</center>


<?php }else{ ?>
    <center>
        <img src="https://gif-avatars.com/img/200x200/test.gif" height="100px">
        <p><strong>Name: </strong><?php echo $dat->customername; ?></p>
        <p><strong>Bill No.: </strong><?php echo $dat->billnumber; ?></p>
        <p><strong>Biller: </strong><?php echo $dat->biller; ?></p>
        <p><strong>Bill date: </strong><?php echo $dat->billdate; ?></p>
        <p><strong>Due date: </strong><?php echo $dat->billduedate; ?></p>
        <p><strong>Due Amount: </strong><?php echo $dat->billamount; ?></p>
    </center>
<?php } ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <?php if($dat->status == "SUCCESS"){ ?>
    <button class="btn btn-primary" onclick="pay();" id="pabtn">Pay</button>
    <?php } ?>
</div>

<input type="hidden" id="refid" value="<?php echo $_SESSION['brefid']; ?>">
<input type="hidden" id="param1" value="<?php echo $_SESSION['param1']; ?>">
<input type="hidden" id="param2" value="<?php echo $_SESSION['param2']; ?>">
<input type="hidden" id="param3" value="<?php echo $_SESSION['param3']; ?>">
<input type="hidden" id="mobile" value="<?php echo $_SESSION['mobile']; ?>">
<input type="hidden" id="bid" value="<?php echo $_SESSION['biller_id']; ?>">
<input type="hidden" id="amount" value="<?php echo $_SESSION['bamount']; ?>">
