<div class="form-group row">
	<div class="col-md-12">
	    <?php $userdata = $this->db->get_where('users',array('id' => $user))->row(); ?>
		<h6>Owner: <?php if($userdata->owner == 0){ echo "ADMIN"; }else{ echo $this->db->get_where('users',array('id' => $userdata->owner))->row()->username; } ?></h6>
	</div>
	<div class="col-md-12">
	    <select class="form-control" id="owner">
	        <?php $role = $userdata->role; ?>
	        <?php $ind = 1; ?>
	        <?php $site = $this->db->get_where('sites',array('rid' => $_SESSION['rid']))->row()->id;
	        $this->db->where('site',$site);
	        ?>
	        <?php $data = $this->db->get('users')->result(); ?>
	        <?php foreach($data as $dat) : ?>
	        <option value="<?php echo $dat->id; ?>"><?php echo $dat->username; ?></option>
	        <?php $ind++; ?>
	        <?php endforeach; ?>
	    </select>
	</div>
</div>

<button type="submit" class="btn btn-primary mt-3 mb-0" onclick="move();" id="mbtn">Move Member</button>