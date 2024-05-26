
       <div class="modal-content">
      	<label style="text-align:center; margin-top: 10px;">Select Package : </label>
										<div class="input-group mb-3 input-lg">
											
											<div class="input-group-prepend">
											    <?php $rid = $rid; ?>
											<?php $role = $this->db->get_where('register',array('id' => $rid))->row()->role; ?>	
											</div><select class="form-control" id="apackage">
											    <?php $data = $this->db->get_where('package',array('role' => $role))->result(); ?>
											    <?php $ind = 1; ?>
											    <?php foreach($data as $dat) : ?>
											    
											    <option value="<?php echo $dat->id; ?>"><?php echo $dat->name; ?></option>
											    
											    <?php $ind++; ?>
											    <?php endforeach; ?>
											</select>
											
										</div>
      <input type="hidden" value="<?php echo $rid; ?>" id="rid">
      <div class="modal-footer" style="text-align:center">

        	<button class="btn btn-primary" id="regverify" onclick="verify();">Approve</button>
      </div>
    </div>

