<?php $this->load->view('admin/header'); ?>

<?php $service = $this->db->get_where('aservice',array('id' => '1'))->row(); ?>


       <div class="modal-content">
            <div class="form-group">
              	<table class="table">
              	    
              	    <thead>
              	        <tr>
              	            <th>AePS INDUS</th>
              	            <th>
              	                
              	                <?php if($service->aeps == "1") {?>
              	            <input class="form-control" type="checkbox" checked="" value="1" id="aeps">
              	            <?php }else{ ?>
              	            <input class="form-control" type="checkbox" value="1" id="aeps">
              	            <?php } ?>
              	            </th>
              	        </tr>
              	        <tr>
              	            <th>BBPS</th>
              	            <th>
              	                <?php if($service->bbps == "1") {?>
              	            <input class="form-control" type="checkbox" checked="" value="1" id="bbps">
              	            <?php }else{ ?>
              	            <input class="form-control" type="checkbox" value="1" id="bbps">
              	            <?php } ?>
              	            </th>
              	        </tr>
              	        <tr>
              	            <th>RECHARGE</th>
              	            <th>
              	                <?php if($service->recharge == "1") {?>
              	            <input class="form-control" type="checkbox" checked="" value="1" id="recharge">
              	            <?php }else{ ?>
              	            <input class="form-control" type="checkbox" value="1" id="recharge">
              	            <?php } ?>
              	            </th>
              	        </tr>
              	        <tr>
              	            <th>PAYOUT</th>
              	            <th>
              	                <?php if($service->payout == "1") {?>
              	            <input class="form-control" type="checkbox" checked="" value="1" id="payout">
              	            <?php }else{ ?>
              	            <input class="form-control" type="checkbox" value="1" id="payout">
              	            <?php } ?>
              	            </th>
              	        </tr>
              	        <tr>
              	            <th>UTI</th>
              	            <th>
              	                <?php if($service->uti == "1") {?>
              	            <input class="form-control" type="checkbox" checked="" value="1" id="uti">
              	            <?php }else{ ?>
              	            <input class="form-control" type="checkbox" value="1" id="uti">
              	            <?php } ?>
              	            </th>
              	        </tr>
              	        <tr>
              	            <th>QUCK TRANSFER</th>
              	            <th>
              	                <?php if($service->qtransfer == "1") {?>
              	            <input class="form-control" type="checkbox" checked="" value="1" id="qtransfer">
              	            <?php }else{ ?>
              	            <input class="form-control" type="checkbox" value="1" id="qtransfer">
              	            <?php } ?>
              	            </th>
              	        </tr>
              	        <tr>
              	            <th>DMT</th>
              	            <th>
              	                <?php if($service->dmt == "1") {?>
              	            <input class="form-control" type="checkbox" checked="" value="1" id="dmt">
              	            <?php }else{ ?>
              	            <input class="form-control" type="checkbox" value="1" id="dmt">
              	            <?php } ?>
              	            </th>
              	        </tr>
              	        <tr>
              	            <th>ICICI AePS</th>
              	            <th>
              	                <?php if($service->iaeps == "1") {?>
              	            <input class="form-control" type="checkbox" checked="" value="1" id="iaeps">
              	            <?php }else{ ?>
              	            <input class="form-control" type="checkbox" value="1" id="iaeps">
              	            <?php } ?>
              	            </th>
              	        </tr>
              	        
              	    </thead>
              	</table>
      	 </div>
      	<input type="hidden" value="<?php echo $_SESSION['auth']; ?>" id="auth">
		<button class="btn btn-primary" onclick="updatedata();" id="upbtn">Update</button>								
      
      
    </div>
<script>
function updatedata(uid)
    {
        
    document.getElementById("upbtn").disabled = true;
    var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Loading...';
    $('#upbtn').html(dat);
        var aeps = (document.getElementById("aeps").checked)?"1":"0";
        var bbps = (document.getElementById("bbps").checked)?"1":"0";
        var recharge = (document.getElementById("recharge").checked)?"1":"0";
        var payout = (document.getElementById("payout").checked)?"1":"0";
        var uti = (document.getElementById("uti").checked)?"1":"0";
        var qtransfer = (document.getElementById("qtransfer").checked)?"1":"0";
        var dmt = (document.getElementById("dmt").checked)?"1":"0";
        var iaeps = (document.getElementById("iaeps").checked)?"1":"0";
        var auth = $("#auth").val();
        
        $.ajax({
            url : "/admin/updateservice",
            method : "POST",
            data : {
                "aeps" : aeps,
                "bbps" : bbps,
                "recharge" : recharge,
                "payout" : payout,
                "uti" : uti,
                "qtransfer" : qtransfer,
                "dmt" : dmt,
                "iaeps" : iaeps,
                "auth" : auth
            },
            success:function(data,status)
            {
            document.getElementById("upbtn").disabled = false;
            var dat = 'Update';
            $('#upbtn').html(dat);
                if(data  == 1)
                {
                    alert("UPDATE SUCCESSFULL");
                    location.href="/admin/manage";
                }
                if(data  != 1)
                {
                    alert(data);
                }
            }
        });
    }

</script>

<?php $this->load->view('admin/footer'); ?>