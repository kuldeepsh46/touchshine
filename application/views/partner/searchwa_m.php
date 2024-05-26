
<div class="row">
    <div class="col-lg-12">
        <div class="card">
			<div class="search-product">
				<div class="form row no-gutters">
					<div class="form-group  col-xl-4 col-lg-3 col-md-12 mb-0 bg-white">
						<input class="form-control input-lg fc-datepicker" placeholder="MM/DD/YYYY" type="text" id="from">
					</div>
					<div class="form-group  col-xl-1 col-lg-3 col-md-12 mb-0 bg-white">
						<center><h3 class="pt-4"><i class="fa fa-arrows-h" aria-hidden="true"></i></h3></center>
					</div>
					<div class="form-group  col-xl-4 col-lg-3 col-md-12 mb-0 bg-white">
						<input class="form-control input-lg fc-datepicker" placeholder="MM/DD/YYYY" type="text" id="to">
					</div>
					<div class="col-xl-3 col-lg-3 col-md-12 mb-0">
					    <button class="br-tl-md-0 br-bl-md-0 btn btn-lg btn-block btn-primary" onclick="search();" id="srbtn">Search Here</button>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
<input type="hidden" value="<?php echo $_SESSION['auth']; ?>" id="auth">
<input type="hidden" value="<?php echo $type; ?>" id="type">

<div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
	<div class="card  box-shadow-0 mb-0">
		<div class="card-header">
			<h4 class="card-title">Transaction History</h4>
		</div>
		<div class="card-body">
			<div id="cont">



		  </div>
		</div>
	</div>
</div>
<input type="hidden" value="<?php echo $_SESSION['auth']; ?>" id="auth">
<input type="hidden" value="<?php echo $id; ?>" id="id">

<script>
   
    function search()
    {
        
        document.getElementById("srbtn").disabled = true;
var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Processing...';
$('#srbtn').html(dat);
        var from = $("#from").val();
        var to = $("#to").val();
        var auth = $("#auth").val();
        var id = $("#id").val();
        $.ajax({
            
            url : "/partner/searchtxnw_m",
            method : "POST",
            data : {
                
                "auth" : auth,
                "id" : id,
                "from" : from,
                "to" : to
            },
            success:function(data,status)
            {
                $('#srbtn').html(dat);
                if(data  == 1)
                {
                    alert("INVALID TOKEN");
                    document.getElementById("srbtn").disabled = false;
                    $('#srbtn').html("Search Here");
                    
                }else{
                    if(data  == 2)
                    {
                        alert("PLEASE FILL ALL DATA");
                        document.getElementById("srbtn").disabled = false;
                        $('#srbtn').html("Search Here");
                        
                    }else{
                         $("#cont").html(data);
                         var i = setInterval(function(){
                            var table =  $("#example").DataTable( {
		lengthChange: false,
		buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
	});
	table.buttons().container()
		.appendTo( '#example_wrapper .col-md-6:eq(0)' );
                             clearInterval(i);
                         },1000);
                        outprocess();
                    }
                }
                
                
                
                
            }
            
            
            
        });
        
        
        
    }
    
    
    
    function inprocess()
	{

document.getElementById("srbtn").disabled = true;
var data = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Processing...';
$('#').html(data);

	}

	function outprocess()
	{

document.getElementById("srbtn").disabled = false;
$('#srbtn').html("Search Here");


	}
</script>

