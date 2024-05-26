
       <div class="modal-content">
      	<table class="table">
      	    <?php $rdata = $this->db->get_where('reseller',array('id' => $uid))->row();
      	    $sdata = $this->db->get_where('sites',array('rid' => $uid))->row(); ?>
      	    <thead>
      	        <tr>
      	            <th>Name</th>
      	            <td><?php echo $rdata->name; ?></td>
      	        </tr>
      	        <tr>
      	            <th>Mobile</th>
      	            <td><?php echo $rdata->phone; ?></td>
      	        </tr>
      	        <tr>
      	            <th>Email</th>
      	            <td><?php echo $rdata->email; ?></td>
      	        </tr>
      	        <tr>
      	            <th>Username</th>
      	            <td><?php echo $rdata->username; ?></td>
      	        </tr>
      	        <tr>
      	            <th>Password</th>
      	            <td><?php echo $rdata->password; ?></td>
      	        </tr>
      	        <tr>
      	            <th>Wallet</th>
      	            <td><?php echo $rdata->wallet; ?></td>
      	        </tr>
      	        <tr>
      	            <th>Domain</th>
      	            <td><?php echo $sdata->domain; ?></td>
      	        </tr>
      	        <tr>
      	            <th>Title</th>
      	            <td><?php echo $sdata->title; ?></td>
      	        </tr>
      	        <tr>
      	            <th>Date</th>
      	            <td><?php echo $rdata->date; ?></td>
      	        </tr>
      	        <tr>
      	            <th>Logo</th>
      	            <td><img src="<?php echo $sdata->logo; ?>" height="50px"></td>
      	        </tr>
      	    </thead>
      	</table>
										
      
      
    </div>

