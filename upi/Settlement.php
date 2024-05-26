<?php
require_once('layouts/header.php');

$account = json_decode($userdata['settle_account']);
?>

      <!-- adminx-content-aside -->
      <div class="adminx-content">
        <!-- <div class="adminx-aside">

        </div> -->

        <div class="adminx-main-content">
          <div class="container-fluid">
            <!-- BreadCrumb -->
<!-- Modal -->
<div class="modal fade" id="MoveToBank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content p-4 card-nblue">
   <form action="" method="post">
   
    <div class="form-group">
      <label class="text-white">Amount (Current Balance ₹<?php echo moneyformat($userdata['balance']);?>)</label>
      <input type="text" name="amount"  class="form-control form-control-sm" placeholder="Amount" maxlength="8" onkeypress="return isNumber(event)" required>
    </div>
	
	<div class="form-group">
      <label class="text-white">Transfer Type</label>
      <select name="transfer_type" class="form-control form-control-sm" required>
	   <option value="IMPS">IMPS</option>
	   <option value="NEFT">NEFT</option>
	  </select>
    </div>
	
	
    <div class="form-group">
      <label class="text-white">Account Number</label>
      <input type="text" name="account_no" value="<?php echo $account->account_no;?>" class="form-control form-control-sm" placeholder="Account Number" maxlength="34" readonly="" required>
    </div>	
	
    <div class="form-group">
      <label class="text-white">Beneficiary Name</label>
      <input type="text" name="beneficiary_name" value="<?php echo $account->beneficiary_name;?>" class="form-control form-control-sm" placeholder="Beneficiary Name" readonly="" minlength="5" maxlength="35" required>
    </div>
	
    <div class="form-group">
      <label class="text-white">IFSC</label>
      <input type="text" name="ifsc" value="<?php echo $account->ifsc;?>" class="form-control form-control-sm" placeholder="IFSC" minlength="11" maxlength="11" readonly="" required>
    </div>
	
	
    <div class="form-group">
      <label class="text-white">Note</label>
      <input type="text" name="note" class="form-control form-control-sm" placeholder="Note" minlength="2" required>
    </div>

	
    <button type="submit" name="banktransfer" class="btn bg-white text-dark btn-sm"><i class="fa fa-bolt"></i> Initiate Transfer</button>
    
  </form>
    </div>
  </div>
</div>
<?php
if(isset($_POST['banktransfer']) && 
!empty($_POST['amount'])&& 
!empty($_POST['transfer_type'])&& 
!empty($_POST['account_no'])&& 
!empty($_POST['beneficiary_name'])&& 
!empty($_POST['ifsc'])&& 
!empty($_POST['note']) ){
	
$amount = safe_str($_POST['amount']);	
$transfer_type = safe_str($_POST['transfer_type']);
$account_no = safe_str($_POST['account_no']);
$beneficiary_name = safe_str($_POST['beneficiary_name']);
$ifsc = safe_str($_POST['ifsc']);
$note = safe_str($_POST['note']);

if($transfer_type=="IMPS"){
$slab_json = json_decode($plan_slab['imps']);
}elseif($transfer_type=="NEFT"){
$slab_json = json_decode($plan_slab['neft']);
}else{
echo '<script>swal("Alert!", "Invalid Transfer Request!", "error");</script>';	
redirect('','1500');
exit();
}


if($amount >= 1 && $amount <= 1000){
$total_amount = $amount + $slab_json->slab1;
}else if ($amount >= 1001 && $amount <= 25000) {
$total_amount = $amount + $slab_json->slab2;
}else if ($amount >= 25000 && $amount <= 100000){
$total_amount = $amount + $slab_json->slab3;
}else{
echo '<script>swal("Alert!", "Transfer Amount Min ₹1 to Max ₹100000!", "error");</script>';	
redirect('','1500');
exit();
}


if($total_amount>$userdata['balance']){
echo '<script>swal("Alert!", "Insufficient Balance!", "error");</script>';
redirect('','1500');
}else{

$closing_balance = $userdata['balance'] - $total_amount;
$order_id = GenRandomString();		
$pay_upi = $account->account_no;
$mode = $transfer_type;
$upi_id = $userdata['login_id'];
$newrrn = '';
$txn_amount = $total_amount;	
$settle_amount = $amount;
$fees = $total_amount - $amount;
$txn_type = 'DEBIT';
$remark = $note;

$result = sql_query("INSERT INTO `tb_transactions`(`token`, `user_uid`, `order_id`, `date`, `time`, `type`, `mode`, `pay_upi`, `upi_id`, `rrn`, `txn_amount`, `settle_amount`, `fees`, `closing_balance`, `txn_type`, `remark`, `status`) 
VALUES ('".$userdata['token']."','".$userdata['id']."','$order_id','".date_time("Y-m-d")."','".date_time("h:i:s A")."','Bank Transfer','$mode','$pay_upi','$upi_id','$newrrn','$txn_amount','$settle_amount','$fees','$closing_balance','$txn_type','$remark','PENDING')");

$balres = sql_query("UPDATE `tb_partner` SET balance='".$closing_balance."' WHERE id='".$userdata['id']."' ");
if($result && $balres){

$arr = array(
"amount"=> $amount, 
"payment_type"=>$transfer_type, 
"ifsc"=>$account->ifsc, 
"number"=>$account->account_no, 
"note"=>$note, 
"reference_number"=>$order_id
);

$url = $hypto_url."/api/transfers/initiate";	
$post_data = json_encode($arr);
$header = array("Content-Type: application/json","Authorization: ".webdata('hypto_token')." ");
$res  = json_decode(curl_post($url,$post_data,$header));	
$status = $res->success;
$message = $res->message;
$reason = $res->reason;	
$bank_ref_num = $res->data->bank_ref_num;
$txn_status = $res->data->status;	

if($status==true){
sql_query("UPDATE `tb_transactions` SET status='".$txn_status."', rrn='".$bank_ref_num."' WHERE order_id='".$order_id."' ");	
echo '<script>swal("Successfully!", "Bank Transfer!", "success");</script>';	
}else{
sql_query("UPDATE `tb_transactions` SET status='REFUNDED', rrn='".$message."' WHERE order_id='".$order_id."' ");	
$new_balance = $closing_balance + $total_amount;
$txn_type = 'CREDIT';
$result = sql_query("INSERT INTO `tb_transactions`(`token`, `user_uid`, `order_id`, `date`, `time`, `type`, `mode`, `pay_upi`, `upi_id`, `rrn`, `txn_amount`, `settle_amount`, `fees`, `closing_balance`, `txn_type`, `remark`, `status`) 
VALUES ('".$userdata['token']."','".$userdata['id']."','".GenRandomString()."','".date_time("Y-m-d")."','".date_time("h:i:s A")."','Funds Refunded','$mode','$pay_upi','$upi_id','$order_id','$txn_amount','$new_balance','$fees','$new_balance','$txn_type','$remark','COMPLETED')");

$balres = sql_query("UPDATE `tb_partner` SET balance='".$new_balance."' WHERE id='".$userdata['id']."' ");

if($result && $balres){
echo '<script>swal("'.$txn_status.'!", "'.$message.'!", "error");</script>';
redirect('','2000');
}else{
echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
redirect('','2000');
}	

}	
	
	
	
}else{
echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
redirect('','2000');
}



}		
}
?>
<?php
if(isset($_POST['txn_status_check']) && 
!empty($_POST['order_id']) ){
	
$order_id = safe_str($_POST['order_id']);

$url = $hypto_url."/api/transfers/status/$order_id";	
$post_data = json_encode($arr);
$header = array("Content-Type: application/json","Authorization: ".webdata('hypto_token')." ");
$res  = json_decode(curl_get($url,$header));
$status = $res->success;
$message = $res->message;
$bank_ref_num = $res->data->bank_ref_num;
$txn_status = $res->data->status;
if($status==true){
if($txn_status=="COMPLETED"){
sql_query("UPDATE `tb_transactions` SET status='".$txn_status."', rrn='".$bank_ref_num."' WHERE order_id='".$order_id."' ");   
}    
echo '<script>swal("'.$txn_status.'!", "Ref: '.$bank_ref_num.'!", "success");</script>';	    
}
}
?>


<div class="row mt-1">
              <div class="col">
                <div class="card mb-grid">
                  <div class="table-responsive-md">
				  
                    <table class="table table-hover">
					<form action="" method="post"> 
                      <thead>
                        <tr class="card-nblue">
                          <th class="text-white">Payout Settlement</th>
                          <th class="text-white">
						  <button class="btn bg-mix text-white btn-sm btn-block" data-toggle="modal" data-target="#MoveToBank" type="button">Move To Bank <i class="fa fa-share-square"></i></button>
						  </th>
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
                          <th class="text-white">RRN & Payment Mode</th>
                          <th class="text-white">Fees & Txn Amount</th>
                          <th class="text-white">Settled Amount</th>
                          <th class="text-white">Closing Balance</th>
                          <th class="text-white">Credit/Debit</th>
                          <th class="text-white">Status</th>
						  
                        </tr>
                      </thead>
                      <tbody>
<?php
$sql = "SELECT * FROM `tb_transactions` WHERE date between '".date_time("Y-m-d")."' AND '".date_time("Y-m-d")."' AND user_uid='".$userdata['id']."' AND type='Bank Transfer' AND txn_type='DEBIT' ORDER BY `id` DESC ";	

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
	
$sql = "SELECT * FROM `tb_transactions` WHERE $concat date between '".$from_date."' AND '".$to_date."' AND user_uid='".$userdata['id']."' AND type='Bank Transfer' AND txn_type='DEBIT' ORDER BY `id` DESC LIMIT $rows_input ";	
 
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
$status = $rows['status'];
if($rows['status']=="PENDING"){
$status = '
<form action="" method="post"> 
<input type="hidden" name="order_id" value="'.$rows['order_id'].'">
<button name="txn_status_check" class="btn bg-mix text-white btn-sm btn-block">'.$status.' <i class="fa fa-history"></i></button>
</form>
';    
}
?>						  
						<tr>
                          <td>#<?php echo $rows['order_id'];?></td>
                          <td><?php echo $rows['date'];?> <?php echo $rows['time'];?></td>
                          <td><?php echo strtoupper($rows['upi_id']);?><br><?php echo $rows['type'];?></td>
                          <td><?php echo strtoupper($rows['pay_upi']);?><br><?php echo $rows['mode'];?>-<?php echo $rows['rrn'];?></td>
                          <td>₹<?php echo moneyformat($rows['txn_amount']);?><br>₹+<?php echo moneyformat($rows['fees']);?></td>
                          <td>₹<?php echo moneyformat($rows['settle_amount']);?></td>
                          <td>₹<?php echo moneyformat($rows['closing_balance']);?></td>
                          <td class="text-<?php echo $txn_type;?>"><?php echo $rows['txn_type'];?></td>
                          <td><?php echo $status;?></td>
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