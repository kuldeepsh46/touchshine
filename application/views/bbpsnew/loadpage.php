<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php $catdata = $this->db->get_where('bbpsincat',array('cat_key' => $cat))->row(); ?>
<div class="row">
	<div class="col-12  col-lg-12 col-xl-6">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title"><?php echo $catdata->name; ?></h5>
				<hr class="my-2">
				<div id="maincont">
					<div class="col-lg-12 mt-1">
                        <label>Board/Operator : </label>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-addon1"><i class="fa fa-opera" aria-hidden="true"></i></span>
							</div>
							<select aria-describedby="basic-addon1" aria-label="Operator" class="form-control" id="operator" onchange="next();">
							    <?php $operators = $this->db->get_where('bbpsinbillers',array('cat_key' => $cat))->result(); ?>
								<?php foreach($operators as $op) : ?>
                                    <option value="<?php echo $op->id; ?>"><?php echo $op->bname; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
                    <div id="conts">
                             
                    </div>
                </div>
			</div>
	    </div>
	</div>
	<div class="col-12  col-lg-12 col-xl-6" id="bill">
   
	</div>
</div>
<script>
    
    function next()
    {
        var operator = $("#operator").val();
        $.ajax({
            
            url : "<?php echo base_url(); ?>/bbps/get",
            method : "POST",
            data : {
                "operator" : operator
            },
            success:function(data,status)
            {
                $("#conts").html(data);
            }
        });
    }
</script>