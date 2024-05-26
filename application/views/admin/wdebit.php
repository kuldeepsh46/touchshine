
       <div class="modal-content">
      	<label style="text-align:center; margin-top: 10px;">DEBIT FUND : </label>
      	<div class="input-group mb-3 input-lg">
											
			<div class="input-group-prepend">
				
			</div><input value="<?php echo $this->db->get_where('reseller',array('id' => $uid))->row()->wallet; ?>" aria-describedby="basic-addon1" aria-label="Username" class="form-control" type="number" disabled="" autocomplete="off">
			
		</div>
		<div class="input-group mb-3 input-lg">
			
			<div class="input-group-prepend">
				
			</div><input aria-describedby="basic-addon1" aria-label="Username" class="form-control" placeholder="Enter Amount" type="number" id="amount" autocomplete="off">
			
		</div>
      
      <div class="modal-footer" style="text-align:center">

        	<button class="btn btn-primary" id="dvrbtn" onclick="debitverify('<?php echo $uid; ?>');">Debit Fund</button>
      </div>
    </div>

