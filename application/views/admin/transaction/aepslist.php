<?php $this->load->view('admin/header'); ?>
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

<div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
	<div class="card  box-shadow-0 mb-0">
		<div class="card-header">
			<h4 class="card-title">Pending AEPS Transaction</h4>
		</div>
			<div id="cont">
		  </div>
		</div>
	</div>
</div>


<script>
   
    function search()
    {
        
        document.getElementById("srbtn").disabled = true;
var dat = '<span class="spinner-border spinner-border-sm" role="status"aria-hidden="true"></span> Processing...';
$('#srbtn').html(dat);
        var from = $("#from").val();
        var to = $("#to").val();
        var auth = $("#auth").val();
        $.ajax({
            
            url : "<?php echo site_url();?>/admin/srhaepslist",
            method : "POST",
            data : {
                
                "auth" : auth,
                
                "from" : from,
                "to" : to
            },
            success:function(data,status)
            {
                //alert(data)
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
        
     function aeps_status_chk(idx){
         
        var id_parts=idx.split('__');
        var mtxnid=id_parts[1];
        var auth = $("#auth").val();
        //alert(mtxnid);
       $.ajax({
            
            url : "<?php echo site_url();?>/pwcallback/aepschkStatus",
            method : "POST",
            data : {
                 "auth" : auth,
                "mtxnid" : mtxnid
                
            },
            success:function(data,status)
            {
             if(data=='1') {
                 search();
             }else{
                 alert(data);
             }
            }
            
            
            
        }); 
    }
                   
</script>





<?php $this->load->view('admin/footer'); ?>