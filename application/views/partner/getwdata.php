<div class="form-group row">
	<div class="col-md-12">
	    <?php $userdata = $this->db->get_where('users',array('id' => $user))->row(); ?>
	    <h6>Name: <?php echo $userdata->name; ?></h6><br>
		<h6>Wallet: <?php echo $userdata->wallet; ?></h6><br>
		<h6>Locked Wallet: <?php echo $userdata->lamount; ?></h6>
	</div>
	<div class="col-md-12">
	    <input class="form-control" type="number" id="amount" placeholder="Enter Amount">
	</div>
</div>

<button class="btn btn-primary mt-3 mb-0" onclick="move();" id="mbtn">Lock Wallet</button>
<button class="btn btn-primary mt-3 mb-0" onclick="transfer();" id="tbtn">Unlock Wallet</button>