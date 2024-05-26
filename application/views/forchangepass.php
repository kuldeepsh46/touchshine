<h5 class="card-title text-center  mb-4">Please Update Your Password</h5>
    <div class="form-group">
        <select class="form-control" id="type">
            <option value="0">Select Type</option>
            <option value="1">Login Password</option>
            <option value="2">Login Pin</option>
        </select>
	</div>
    <div class="form-group">
		<input type="text" style="margin-top:18px" class="form-control" placeholder="Please Enter New Data" id="pass">
	</div>
	<div class="form-group">
		<input type="text" class="form-control" placeholder="Re Enter Data" id="cpass">
	</div>

	<button class="btn btn-primary btn-block" onclick="verifychangepass();" id="ubtn">Update Data</button>