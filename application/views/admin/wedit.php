
       <div class="modal-content">
            <div class="form-group">
              	<table class="table">
              	    <?php $rdata = $this->db->get_where('reseller',array('id' => $uid))->row();
              	    $sdata = $this->db->get_where('sites',array('rid' => $uid))->row(); ?>
              	    <thead>
              	         <tr>
              	            <th>  </th>
              	            <th>  </th>
              	        </tr>
              	        <tr>
              	            <th>Name</th>
              	            <th><input class="form-control" type="text" value="<?php echo $rdata->name; ?>" id="name"></th>
              	        </tr>
              	        <tr>
              	            <th>Email</th>
              	            <th><input class="form-control" type="email" value="<?php echo $rdata->email; ?>" id="email"></th>
              	        </tr>
              	        <tr>
              	            <th>Mobile</th>
              	            <th><input class="form-control" type="number" value="<?php echo $rdata->phone; ?>" id="phone"></th>
              	        </tr>
              	        <tr>
              	            <th>Title</th>
              	            <th><input class="form-control" type="text" value="<?php echo $sdata->title; ?>" id="title"></th>
              	        </tr>
              	        <tr>
              	            <th>Contact Email</th>
              	            <th><input class="form-control" type="email" value="<?php echo $sdata->cemail; ?>" id="cemail"></th>
              	        </tr>
              	        <tr>
              	            <th>Contact Number</th>
              	            <th><input class="form-control" type="number" value="<?php echo $sdata->cnumber; ?>" id="cnumber"></th>
              	        </tr>
              	        <tr>
              	            <th>News</th>
              	            <th><input class="form-control" type="text" value="<?php echo $sdata->news; ?>" id="news"></th>
              	        </tr>
              	        
              	    </thead>
              	</table>
      	 </div>
      	<input type="hidden" value="<?php echo $_SESSION['auth']; ?>" id="auth">
		<button class="btn btn-primary" onclick="updatedata('<?php echo $rdata->id; ?>');" id="upbtn">Update</button>								
      
      
    </div>

