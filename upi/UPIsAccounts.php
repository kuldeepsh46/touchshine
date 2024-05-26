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
<!-- Modal -->
<div class="modal fade" id="CreateUPI" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content p-4 card-nblue">
   <form action="" method="post">
   
   <label class="text-white">UPI ID</label>
<div class="input-group input-group-sm mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text"><?php echo webdata("upi_prefix");?></span>
  </div>
  <input type="text" name="upi_id" class="form-control form-control-sm" placeholder="Numeric Value" maxlength="10" onkeypress="return isNumber(event)" required>
  <div class="input-group-append">
    <span class="input-group-text"><?php echo webdata("upi_bank");?></span>
  </div>
</div>

    <div class="form-group">
      <label class="text-white">Name</label>
      <input type="text" name="upi_name" class="form-control form-control-sm" placeholder="Name (Max 40 characters)" maxlength="40" required>
    </div>
	
	<div class="form-group">
      <label class="text-white">PAN</label>
      <input type="text" name="pan_no" id="pan_no" class="form-control form-control-sm" placeholder="PAN" maxlength="10" onchange="panValidation(this.value)" required>
    </div>
	
	<div class="form-group">
      <label class="text-white">Category</label>
      <select name="category" class="form-control form-control-sm" required>
	   <option value="">---Select---</option>
	   <option value="Clothing">Clothing</option>
	   <option value="Restaurants">Restaurants</option>
	   <option value="Saloons">Saloons</option>
	   <option value="Groceries">Groceries</option>
	   <option value="Supermarkets">Supermarkets</option>
	   <option value="Retail Stores">Retail Stores</option>
	   <option value="Services">Services</option>
	   <option value="Others">Others</option>
	   
	  </select>
    </div>
	
	<div class="form-group">
      <label class="text-white">Address</label>
      <textarea name="address" class="form-control form-control-sm" placeholder="Address" required></textarea>
    </div>
	
	
    <button type="submit" name="addupi" class="btn bg-white text-dark btn-sm"><i class="fa fa-bolt"></i> Create UPI</button>
    
  </form>
    </div>
  </div>
</div>
<?php
if(isset($_POST['addupi']) && 
!empty($_POST['upi_id'])&& 
!empty($_POST['upi_name'])&& 
!empty($_POST['pan_no'])&& 
!empty($_POST['category'])&& 
!empty($_POST['address']) ){
	
$upi_id = webdata("upi_prefix").safe_str($_POST['upi_id']).webdata("upi_bank");	
$upi_uid = safe_str($_POST['upi_id']);
$upi_name = safe_str($_POST['upi_name']);
$pan_no = safe_str($_POST['pan_no']);
$category = safe_str($_POST['category']);
$address = safe_str($_POST['address']);
	
$res = sql_query("SELECT * FROM `tb_upis` WHERE upi_id='".$upi_id."' ");
$result = sql_num_rows($res);	
if($result==0){
$query = sql_query("INSERT INTO tb_upis (uid,upi_uid,upi_id,upi_name,pan,category,address,date,time,status) 
VALUES ('$uid','$upi_uid','$upi_id','$upi_name','$pan_no','$category','$address','".date_time("Y-m-d")."','".date_time("h:i:s A")."','PENDING')");
if($query){
echo '<script>swal("Successfully!", "UPI ID Has Created!", "success");</script>';
redirect('','1500');	
}else{
echo '<script>swal("Alert!", "Service is Down!", "error");</script>';
redirect('','1500');
}

}else{
echo '<script>swal("Alert!", "UPI ID Already Exist!", "error");</script>';
redirect('','1500');
}	
	
}
?>

<?php
if(isset($_POST['send_bank']) && !empty($_POST['upiuid']) ){
	
$upiuid = safe_str($_POST['upiuid']);
$obj = json_decode($_POST['GEOCode']);
$lat = substr($obj->latitude, 0, 9); 
$lon = substr($obj->longitude, 0, 9);
	
$res = sql_query("SELECT * FROM `tb_upis` WHERE id='".$upiuid."' ");
$row = sql_num_rows($res);	
$result = sql_fetch_array($res);
if($row==1){
	
$arr = array(
"upi_id"=>$result['upi_id'], 
"name"=>$result['upi_name'], 
"pan"=>$result['pan'], 
"category"=>$result['category'], 
"address"=>$result['address'], 
"lat"=>$lat, 
"lon"=>$lon);

$url = $hypto_url."/api/upis";	
$post_data = json_encode($arr);
$header = array("Content-Type: application/json","Authorization: ".webdata('hypto_token')." ");
$res  = json_decode(curl_post($url,$post_data,$header));
$status = $res->success;
$message = $res->message;
$upi_uid = $res->data->upi->id;
$upi_status = $res->data->upi->status;
if($status==true){
sql_query("UPDATE `tb_upis` SET upi_uid='".$upi_uid."', status='".$upi_status."' WHERE id='".$result['id']."' ");
echo '<script>swal("Successfully!", "UPI ID Activated!", "success");</script>';	
redirect('','1500');
}else{
echo '<script>swal("Alert!", "'.$message.'!", "error");</script>';
redirect('','2000');
}

}else{
echo '<script>swal("Alert!", "UPI ID Not Exist!", "error");</script>';
redirect('','2000');
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
                          <th class="text-white">UPIs Accounts</th>
                          <th class="text-white">
						  <button class="btn bg-mix text-white btn-sm btn-block" data-toggle="modal" data-target="#CreateUPI" type="button">Create UPI <i class="fa fa-plus"></i></button>
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
						  
<th class="text-white" colspan="1">
<div class="input-group">
<input class="form-control form-control-sm" name="search_input" placeholder="Search ID / UPI ID" style=" height: 30.1px; ">
<div class="input-group-append">
<button class="btn bg-mix text-white btn-sm" name="filter" type="submit"><i class="fa fa-search"></i></button>
</div>
</div>
</th>
<th class="text-white">
<button class="btn bg-mix text-white btn-sm" onclick="Export('UPIsAccount')"  type="button">Export <i class="fa fa-external-link-alt"></i></button>
</th>
						  
                        </tr>
                      </thead>
					</form>
					
                      <thead>
                        <tr class="bg-mix">
                          <th class="text-white">ID</th>
                          <th class="text-white">UPI</th>
                          <th class="text-white">Created Time</th>
                          <th class="text-white">Name</th>
                          <th class="text-white">PAN</th>
                          <th class="text-white">Category</th>
                          <th class="text-white">Status</th>
						  
                        </tr>
                      </thead>
                      <tbody>
<?php
$sql = "SELECT * FROM `tb_upis` WHERE uid='".$userdata['id']."' ORDER BY `id` DESC ";	

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
$concat	= " CONCAT(`upi_uid`,`upi_id`) LIKE '%$search_input%' AND ";
}
	
$sql = "SELECT * FROM `tb_upis` WHERE $concat date between '".$from_date."' AND '".$to_date."' AND uid='".$userdata['id']."' ORDER BY `id` DESC LIMIT $rows_input ";	
 
}

$query  = sql_query($sql);
$sl = 1;
while($rows = sql_fetch_array($query)){ 
$status = $rows['status'];
if($rows['status']=="PENDING"){
$status = '
<form action="" method="post"> 
<input type="hidden" name="upiuid" value="'.$rows['id'].'">
<input type="hidden" id="G'.$sl.'" name="GEOCode">
<button name="send_bank" onmouseover="funLocation(\'G'.$sl.'\');" class="btn bg-mix text-white btn-sm btn-block">Send Bank <i class="fa fa-bolt"></i></button>
</form>
';	
}
?>						  
						<tr>
                          <td><?php echo $rows['upi_uid'];?></td>
                          <td><?php echo $rows['upi_id'];?></td>
                          <td><?php echo $rows['date'];?> <?php echo $rows['time'];?></td>
                          <td><?php echo $rows['upi_name'];?></td>
                          <td><?php echo strtoupper($rows['pan']);?></td>
                          <td><?php echo $rows['category'];?></td>
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