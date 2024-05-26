
       <div class="modal-content">
      	<table class="table">
      	    <?php $user = $this->db->get_where('users',array('id' => $uid))->row();
      	     ?>
      	    <thead>
      	        <tr>
      	            <th>Name</th>
      	            <td><?php echo $user->name; ?></td>
      	        </tr>
      	        <tr>
      	            <th>Mobile</th>
      	            <td><?php echo $user->phone; ?></td>
      	        </tr>
      	        <tr>
      	            <th>Email</th>
      	            <td><?php echo $user->email; ?></td>
      	        </tr>
      	        <tr>
      	            <th>Username</th>
      	            <td><?php echo $user->username; ?></td>
      	        </tr>
      	        <tr>
      	            <th>Password</th>
      	            <td><?php echo $user->password; ?></td>
      	        </tr>
      	        <tr>
      	            <th>PIN</th>
      	            <td><?php echo $user->pin; ?></td>
      	        </tr>
      	        <tr>
      	            <th>Wallet</th>
      	            <td><?php echo $user->wallet; ?></td>
      	        </tr>
      	        <tr>
      	            <th>Date</th>
      	            <td><?php echo $user->create_date; ?></td>
      	        </tr>
      	        <tr>
      	            <th>Company</th>
      	            <td><?php echo $this->db->get_where('sites',array('id' => $user->site))->row()->domain; ?></td>
      	        </tr>
      	    </thead>
      	</table>
										
      
      
    </div>

