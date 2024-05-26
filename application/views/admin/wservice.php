
       <div class="modal-content">
      	<table class="table">
      	    <?php $rdata = $this->db->get_where('reseller',array('id' => $uid))->row();
      	    $sdata = $this->db->get_where('sites',array('rid' => $uid))->row(); ?>
      	    <thead>
      	        <tr>
      	            <th>Service</th>
      	            <th>Status</th>
      	        </tr>
      	        <tbody>
      	            <tr>
      	                <?php if($rdata->recharge == 1){ ?>
      	                <td><input type="checkbox" checked="" value="1" id="recharge"></td>
      	                <?php }else{ ?>
      	                <td><input type="checkbox" value="1" id="recharge"></td>
      	                <?php } ?>
      	                <td>Recharge</td>
      	            </tr>
      	            <tr>
      	                <?php if($rdata->dmt == 1){ ?>
      	                <td><input type="checkbox" checked="" value="1" id="dmt"></td>
      	                <?php }else{ ?>
      	                <td><input type="checkbox" value="1" id="dmt"></td>
      	                <?php } ?>
      	                <td>Dmt</td>
      	            </tr>
      	            <tr>
      	                <?php if($rdata->aeps == 1){ ?>
      	                <td><input type="checkbox" checked="" value="1" id="aeps"></td>
      	                <?php }else{ ?>
      	                <td><input type="checkbox" value="1" id="aeps"></td>
      	                <?php } ?>
      	                <td>Indus AePS</td>
      	            </tr>
      	            <tr>
      	                <?php if($rdata->iaeps == 1){ ?>
      	                <td><input type="checkbox" checked="" value="1" id="iaeps"></td>
      	                <?php }else{ ?>
      	                <td><input type="checkbox" value="1" id="iaeps"></td>
      	                <?php } ?>
      	                <td>Icici AePS</td>
      	            </tr>
      	            <tr>
      	                <?php if($rdata->bbps == 1){ ?>
      	                <td><input type="checkbox" checked="" value="1" id="bbps"></td>
      	                <?php }else{ ?>
      	                <td><input type="checkbox" value="1" id="bbps"></td>
      	                <?php } ?>
      	                <td>BBPS</td>
      	            </tr>
      	            <tr>
      	                <?php if($rdata->qtransfer == 1){ ?>
      	                <td><input type="checkbox" checked="" value="1" id="qtransfer"></td>
      	                <?php }else{ ?>
      	                <td><input type="checkbox" value="1" id="qtransfer"></td>
      	                <?php } ?>
      	                <td>Q Transfer</td>
      	            </tr>
      	            <tr>
      	                <?php if($rdata->payout == 1){ ?>
      	                <td><input type="checkbox" checked="" value="1" id="payout"></td>
      	                <?php }else{ ?>
      	                <td><input type="checkbox" value="1" id="payout"></td>
      	                <?php } ?>
      	                <td>Payout</td>
      	            </tr>
      	            <tr>
      	                <?php if($rdata->uti == 1){ ?>
      	                <td><input type="checkbox" checked="" value="1" id="uti"></td>
      	                <?php }else{ ?>
      	                <td><input type="checkbox" value="1" id="uti"></td>
      	                <?php } ?>
      	                <td>UTI Pan</td>
      	            </tr>
      	        </tbody>
      	    </thead>
      	</table>
      	<input type="hidden" value="<?php echo $_SESSION['auth']; ?>" id="auth">
		<button class="btn btn-primary" onclick="updateservice('<?php echo $rdata->id; ?>');" id="serbtn">Update</button>								
      
      
    </div>

