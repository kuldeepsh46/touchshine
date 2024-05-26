<?php $data = $this->db->get_where('payoutaccount',array('id' => $bid))->row(); ?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Verify Details</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" value="<?php echo $data->name; ?>" disabled="">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Account Number</label>
        <input type="text" class="form-control" value="<?php echo $data->account; ?>" disabled="">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">IFSC</label>
        <input type="text" class="form-control" value="<?php echo $data->ifsc; ?>" disabled="">
    </div>
    <div class="form-group">
        <button class="form-control btn btn-primary" onclick="verifyaccount('<?php echo $bid; ?>');" id="vac">Verify Account</button>
    </div>
    <div id="verifydetails">
        
    </div>

      
      
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" onclick="aprrovebtn('<?php echo $bid; ?>');" id="apbtn">Approve</button>
  </div>
<input type="hidden" value="<?php echo $_SESSION['auth']; ?>" id="auth">
<script>
function verifyaccount(bid)
    {
        var auth = $("#auth").val();
        $.ajax({
            url : "/partner/accountverification",
            method : "POST",
            data : {
                "auth" : auth,
                "bid" : bid
            },
            success:function(data,status)
            {
                if(data  == 1)
                {
                    alert("INVALID TOKEN");
                }else{
                    $("#verifydetails").html(data);
                }
            }
        });
    }


function aprrovebtn(bid)
   {
      var auth = $("#auth").val();
      $.ajax({
              url : "/partner/aprrovebtnpay",
              method : "POST",
              data : {
                   "auth" : auth,
                   "bid" : bid
              },
              success:function(data,status)
              {
                    if(data  == 1)
                    {
                        alert("ACCOUNT APPROVE SUCCESS");
                        location.href="/partner/approvepayout";
                    }
                    if(data  != 1)
                    {
                        alert(data);
                    }
              }
         });
   }
    
    
</script>





