<?php
require_once('layouts/header.php');
?>

      <!-- adminx-content-aside -->
      <div class="adminx-content">
        <!-- <div class="adminx-aside">

        </div> -->

        <div class="adminx-main-content">
          <div class="container-fluid">
            <!-- BreadCrumb -->

<div class="row mt-1">
              <div class="col">
                <div class="card mb-grid">
                  <div class="table-responsive-md">
				  
                    <table class="table table-hover">
					<form action="" method="post"> 
                      <thead>
                        <tr class="card-nblue">
                          <th class="text-white">Account Statement</th>
                          <th class="text-white">Transactions Details</th>
						  <th class="text-white">
						  <input type="date" name="from_date" value="" class="form-control form-control-sm">
						  </th>
						  
						  <th class="text-white">
						  <input type="date" name="to_date" value="" class="form-control form-control-sm">
						  </th>
						  
                          <th class="text-white">
						  <input type="number" name="rows_input" value="10" class="form-control form-control-sm" placeholder="Show entries">
						  </th>
						  
<th class="text-white" colspan="3">
<div class="input-group">
<input class="form-control form-control-sm" name="search_input" placeholder="Search ID / Bank Ref Number" style=" height: 30.1px; ">
<div class="input-group-append">
<button class="btn bg-mix text-white btn-sm" name="filter" type="submit"><i class="fa fa-search"></i></button>
</div>
</div>
</th>
<th class="text-white">
<button class="btn bg-mix text-white btn-sm" onclick="Export('Transactions')"  type="button">Export <i class="fa fa-external-link-alt"></i></button>
</th>
						  
                        </tr>
                      </thead>
					</form>
					
                      <thead>
                        <tr class="bg-mix">
                          <th class="text-white">ID</th>
                          <th class="text-white">Time</th>
                          <th class="text-white">Type</th>
                          <th class="text-white">Payment Mode</th>
                          <th class="text-white">Txn Amount</th>
                          <th class="text-white">Settled Amount</th>
                          <th class="text-white">Closing Balance</th>
                          <th class="text-white">Credit/Debit</th>
                          <th class="text-white">Status</th>
						  
                        </tr>
                      </thead>
                      <tbody>
<?php
$sql = "SELECT * FROM `tb_transactions` WHERE date between '".date_time("Y-m-d")."' AND '".date_time("Y-m-d")."' AND user_uid='".$userdata['id']."' ORDER BY `id` DESC ";	

if(isset($_POST['filter']) AND 
!empty($_POST['from_date']) AND 
!empty($_POST['to_date']) AND 
!empty($_POST['rows_input']) ){
	
$from_date = date("Y-m-d", strtotime($_POST['from_date']));	
$to_date = date("Y-m-d", strtotime($_POST['to_date']));	
$rows_input = safe_str($_POST['rows_input']);
$search_input = safe_str($_POST['search_input']);
$concat = '';
if($search_input!=''){
$concat	= " CONCAT(`order_id`,`rrn`) LIKE '%$search_input%' AND ";
}
	
$sql = "SELECT * FROM `tb_transactions` WHERE $concat date between '".$from_date."' AND '".$to_date."' AND user_uid='".$userdata['id']."' ORDER BY `id` DESC LIMIT $rows_input ";	
 
}

$query  = sql_query($sql);
$sl = 1;
while($rows = sql_fetch_array($query)){ 

if($rows['txn_type']=='CREDIT'){
$txn_type = 'success';	
}else if($rows['txn_type']=='DEBIT'){
$txn_type = 'danger';		
}else{
$txn_type = 'info';		
}
?>						  
						<tr>
                          <td>#<?php echo $rows['order_id'];?><br><?php echo $rows['client_orderid'];?></td>
                          <td><?php echo $rows['date'];?> <?php echo $rows['time'];?></td>
                          <td><?php echo strtoupper($rows['upi_id']);?><br><?php echo $rows['type'];?></td>
                          <td><?php echo strtoupper($rows['pay_upi']);?><br><?php echo $rows['mode'];?>-<?php echo $rows['rrn'];?></td>
                          <td>₹<?php echo moneyformat($rows['txn_amount']);?></td>
                          <td>₹<?php echo moneyformat($rows['settle_amount']);?></td>
                          <td>₹<?php echo moneyformat($rows['closing_balance']);?></td>
                          <td class="text-<?php echo $txn_type;?>"><?php echo $rows['txn_type'];?></td>
                          <td><?php echo $rows['status'];?></td>
                        </tr>
<?php
$sl++;}
?>											
						
                      </tbody>
                    </table>
					
					<div class="row">
					<div class="col-sm-12 col-md-5">
					
					</div>
					</div>
					
                  </div>
                </div>
              </div>
            </div>

            
            
          </div>
        </div>
      </div>
<?php
require_once('layouts/footer.php');
?>