<?php $this->load->view('header'); ?>
<div id="cont">
    <div class="row row-sm">
        <?php $cat = $this->db->get('bbpsincat')->result(); ?>
        <?php foreach($cat as $cat) : ?>
    	<div class="col-xl-2 col-lg-4 col-md-4 col-xm-4">
    		<div class="card overflow-hidden sales-card bg-primary-gradient" onclick="rundata('<?php echo $cat->cat_key; ?>');">
    			<div class="pl-1 pt-3 pr-3 pb-2 pt-0">
    				<div class="pb-0 mt-0">
    					<center>
        					<img src="<?php echo $cat->logo; ?>" height="100px" width="100px">
    					</center>
    				</div>
    			</div>
    		</div>
    	    <center>
    			<h6 class="mt-4"><?php echo $cat->name; ?></h6>
    		</center>
    	</div>
    	<?php endforeach; ?>
    </div>
</div>


<input type="hidden" id="auth" value="<?php echo $_SESSION['auth']; ?>">
<script>
    function rundata(cat)
	{
        var auth = $("#auth").val();
        $.ajax({
		    url: "<?php echo base_url(); ?>/bbps/loadpage",
		    method : "POST",
		    data : {
                "auth" : auth,
			    "cat" : cat
		    },
		    success:function(data,status)
		    {
                if(data == 1)
			    {
			  	    alert('INVALID TOKEN');
			    }else{
			        if(data == 2){
			            alert('ERROR IN PAGE');
			        }else{
			            $("#cont").html(data);
			        }
			    }
		    }
	    });
    }
</script>
<?php $this->load->view('footer'); ?>