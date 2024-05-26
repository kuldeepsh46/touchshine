
       <div class="modal-content">
            <div class="form-group">
              	<table class="table">
              	    <?php $rdata = $this->db->get_where('users',array('id' => $uid))->row();
              	     ?>
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
              	            <th>Active</th>
              	            <th><?php if($rdata->active == 1){ ?>
              	            <input class="form-control" type="checkbox" checked="" value="1" id="active">
              	            <?php }else{ ?>
              	            <input class="form-control" type="checkbox" value="1" id="active">
              	            <?php } ?>
              	            </th>
              	        </tr>
              	        
              	        
              	    </thead>
              	</table>
      	 </div>
      	<input type="hidden" value="<?php echo $_SESSION['auth']; ?>" id="auth">
		<button class="btn btn-primary" onclick="updatedata('<?php echo $rdata->id; ?>');" id="upbtn">Update</button>								
      
      
    </div>

