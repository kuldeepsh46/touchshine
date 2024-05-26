
       <div class="modal-content">
      	<table class="table">
      	    <?php  
      	    if($status == "Error"){
      	    ?>
      	        <thead>
      	        <tr>
      	            <th>Error MEssage</th>
      	            <td><?php echo $msg; ?></td>
      	        </tr>
      	    </thead>
      	    <?php }else{ ?>
      	    <thead>
      	        <tr>
      	            <th>Name</th>
      	            <td><?php echo 1; ?></td>
      	        </tr>
      	        <?php print_r($result); ?>
      	        
      	    </thead>
      	
										
      <?php } ?>
      </table>
    </div>

