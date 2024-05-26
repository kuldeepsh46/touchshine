<div class="form-group row">
	<div class="col-md-12">
	    <?php $userdata = $this->db->get_where('users',array('id' => $user))->row(); ?>
	    <h6>Name: <?php echo $userdata->name; ?></h6><br>
	</div>
	<div class="col-md-12">
	    <select class="form-control" id="role">
	        <?php if($userdata->role == "5"){ ?>
	        <option value="2">State Head</option>
	        <option value="3">Master Distributor</option>
	        <option value="4">Distributor</option>
	        <?php }elseif($userdata->role == "4"){ ?>
	        <option value="2">State Head</option>
	        <option value="3">Master Distributor</option>
	        <?php }elseif($userdata->role == "3"){ ?>
	        <option value="2">State Head</option>
	        <?php }else{ ?>
	        <h3>Already Upgraded</h3>
	        <?php } ?>
	    </select>
	</div>
</div>

<button type="submit" class="btn btn-primary mt-3 mb-0" onclick="move();" id="mbtn">Upgrade User</button>