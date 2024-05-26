
       <div class="modal-content">
      	<label style="text-align:center; margin-top: 10px;">Select Package : </label>
										<div class="input-group mb-3 input-lg">
											
											<div class="input-group-prepend">
												
											</div><select class="form-control" id="pkg">
											    <?php $ind = 1; ?>
											    <?php $pkg = $this->db->get_where('package',array('role' => $role))->result(); ?>
											    <?php foreach($pkg as $pk) : ?>
											    <option value="<?php echo $pk->id; ?>"><?php echo $pk->name; ?></option>
											    <?php $ind++; ?>
											    <?php endforeach; ?>
											</select>
											
										</div>
      
      <div class="modal-footer" style="text-align:center">

        	<button class="btn btn-primary" id="regverify" onclick="verify();">Verify</button>
      </div>
    </div>

