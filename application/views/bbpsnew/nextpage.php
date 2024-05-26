<?php if($biller->fetch_req == "0" && $biller->validation == "0"){ ?>
<!--Direct Pay-->
<?php $field = json_decode($biller->vardata); ?>
<?php $ind = 1; ?>
<?php foreach($field as $field) : ?>
<div class="col-lg-12 mt-1">
    <label><?php echo $field; ?> : </label>
	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text" id="basic-addon1"><i class="fa fa-opera" aria-hidden="true"></i></span>
		</div>
		<input type="text" class="form-control" id="param<?php echo $ind; ?>" placeholder="<?php echo $field; ?>" autocomplete="false">
	</div>
</div>
<?php $ind++; ?>
<?php endforeach; ?>
<div class="col-lg-12 mt-1">
    <label>Amount : </label>
	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text" id="basic-addon1"><i class="fa fa-opera" aria-hidden="true"></i></span>
		</div>
		<input type="text" class="form-control" id="amount" placeholder="Amount" autocomplete="false">
	</div>
</div>
<input type="hidden" id="bid" value="<?php echo $biller->id; ?>">
<button class="btn btn-primary block" onclick="pay();" id="pabtn">Pay</button>
<?php } ?>
<?php if($biller->fetch_req == "0" && $biller->validation == "1"){ ?>
<!--Validation-->





<?php } ?>
<?php if($biller->fetch_req == "1" && $biller->validation == "1"){ ?>
<!--Both-->





<?php } ?>
<?php if($biller->fetch_req == "1" && $biller->validation == "0"){ ?>
<!--Fetch And Pay-->
<div class="col-lg-12 mt-1">
    <label>MOBILE NO. : </label>
	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text" id="basic-addon1"><i class="fa fa-opera" aria-hidden="true"></i></span>
		</div>
		<input type="number" class="form-control" id="mobile" placeholder="Enter Mobile Number" autocomplete="false">
	</div>
</div>
<?php $field = json_decode($biller->vardata); ?>
<?php $ind = 1; ?>
<?php foreach($field as $field) : ?>
<div class="col-lg-12 mt-1">
    <label><?php echo $field; ?> : </label>
	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text" id="basic-addon1"><i class="fa fa-opera" aria-hidden="true"></i></span>
		</div>
		<input type="text" class="form-control" id="param<?php echo $ind; ?>" placeholder="<?php echo $field; ?>" autocomplete="false">
	</div>
</div>
<?php $ind++; ?>
<?php endforeach; ?>
<button class="btn btn-primary block" onclick="fetch();" id="fbtn">Fetch Bill</button>




<?php } ?>


<div class="modal fade" id="info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="infocont">
      
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="infor">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Transaction Receipt</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="printThis">
            
      </div>
        

      </div>
      
    </div>
  </div>


<script>
    function makeprint()
{
    printElement(document.getElementById("printThis"));
}

function printElement(elem) {
    var domClone = elem.cloneNode(true);
    
    var $printSection = document.getElementById("printSection");
    
    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }
    
    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
}
    
</script>
<script>
    function fetch()
    {
        document.getElementById("fbtn").disabled = true;
        var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
        $('#fbtn').html(dat);
        var param1 = $("#param1").val();
        var param2 = $("#param2").val();
        var param3 = $("#param3").val();
        var mobile = $("#mobile").val();
        var auth = $("#auth").val();
        var refid = $("#refid").val();
        $.ajax({
            url : "<?php echo base_url(); ?>/bbps/fetchbillnew",
            method : "POST",
            data : {
                "bid" : <?php echo $biller->id; ?>,
                "param1" : param1,
                "param2" : param2,
                "param3" : param3,
                "mobile" : mobile,
                "auth" : auth,
                "refid" : refid
            },
            success:function(data,status)
            {
                document.getElementById("fbtn").disabled = false;
                var dat = 'Fetch Bill';
                $('#fbtn').html(dat);
                if(data  == 1)
                {
                    alert('INVALID TOKEN');
                }else{
                    if(data == 2){
                        alert('SEND PROPER DATA');
                    }else{
                        $("#info").modal("show");
                        $("#infocont").html(data);
                    }
                }
            }
        });
    }
    function pay()
    {
        document.getElementById("pabtn").disabled = true;
        var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
        $('#pabtn').html(dat);
        var param1 = $("#param1").val();
        var param2 = $("#param2").val();
        var param3 = $("#param3").val();
        var mobile = $("#mobile").val();
        var refid = $("#refid").val();
        var bid = $("#bid").val();
        var auth = $("#auth").val();
        var amount = $("#amount").val();
        $.ajax({
            url : "<?php echo base_url(); ?>/bbps/paybillnew",
            method : "POST",
            data : {
                "bid" : bid,
                "param1" : param1,
                "param2" : param2,
                "param3" : param3,
                "amount" : amount,
                "mobile" : mobile,
                "refid" : refid,
                "auth" : auth
            },
            success:function(data,status)
            {
                document.getElementById("pabtn").disabled = false;
                var dat = 'Pay';
                $('#pabtn').html(dat);
                if(data  == 1)
                {
                    alert('INVALID TOKEN');
                }else{
                    if(data == 2){
                        alert('SEND PROPER DATA');
                    }else{
                        if(data == 3){
                            alert('INSUFFICIENT FUND');
                        }else{
                            $("#info").modal("hide");
                            $("#infor").modal("show");
                            $("#printThis").html(data);
                        }
                    }
                }
            }
        });
    }
</script>