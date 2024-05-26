

        function CallkycCapture(device,path) {
            
           
                    if (device == "MANTRA") {
                        sessionStorage.setItem("device", "MANTRA");
                       CaptureAvdm(path);
                      

                    }
                    else if (device == "MORPHO") {
                         sessionStorage.setItem("device", "MORPHO");
                        CaptureMorpho(path);
                       
                    }

                

            

        }




      function discoverAvdm() {

        var SuccessFlag = 0;


        var verb = "RDSERVICE";
        var err = "";
        SuccessFlag = 0;
        var res;
        $.support.cors = true;
        var httpStaus = false;
        var jsonstr = "";
        var data = new Object();
        var obj = new Object();

        $.ajax({

            type: "RDSERVICE",
            async: false,
            crossDomain: true,
            url: "http://127.0.0.1:11100",
            contentType: "text/xml; charset=utf-8",
            processData: false,
            cache: false,
            crossDomain: true,

            success: function(data) {

                httpStaus = true;
                res = {
                    httpStaus: httpStaus,
                    data: data
                };
                //alert(data);
                finalUrl = "http://127.0.0.1:11100";
                var $doc = $.parseXML(data);
                var CmbData1 = $($doc).find('RDService').attr('status');
                var CmbData2 = $($doc).find('RDService').attr('info');




                MethodCapture = "/rd/capture";



                MethodInfo = "/rd/info";

                SuccessFlag = 1;
                return;

            },
            error: function(jqXHR, ajaxOptions, thrownError) {
                if (i == "8005" && OldPort == true) {
                    OldPort = false;
                    i = "11099";
                }

            },

        });



       



    

    if (SuccessFlag == 0) {
        alert("Connection failed Please try again.");
        ClearCtrl();
    }




    return res;
}


    function CaptureAvdm(path) {
       
        
        if (true) {
            discoverAvdm();
            
    
            var XML = '<?xml version="1.0"?> <PidOptions ver="1.0"> <Opts fCount="1" fType="0" iCount="0" pCount="0" format="0"   pidVer="2.0" timeout="10000" posh="UNKNOWN" env="P" WADH="E0jzJ/P8UopUHAieZn8CKqS4WPMi5ZSYXgfnlfkWjrc=" /> </PidOptions>';
            var verb = "CAPTURE";
            var err = "";
            var res;
            $.support.cors = true;
            var httpStaus = false;
            var jsonstr = "";

            $.ajax({
                type: "CAPTURE",
                async: false,
                crossDomain: true,
                url: finalUrl + MethodCapture,
              
                data: XML,
                contentType: "text/xml; charset=utf-8",
                processData: false,
                success: function (data) {
                   
                    httpStaus = true;
                    res = { httpStaus: httpStaus, data: data };
                    
                    var $doc = $.parseXML(data);
                    var Message = $($doc).find('Resp').attr('errInfo');
               
                    
                   
                    CallApi(data,path);
                        
                   
                },
                error: function (jqXHR, ajaxOptions, thrownError) {
                    //$('#txtPidOptions').val(XML);
                    alert(thrownError);
                    res = { httpStaus: httpStaus, err: getHttpError(jqXHR) };
                },
            });

        return res;
    }

    else {
        alert("Check Terms & Conditions");
        ClearCtrl()
    }
}

//captcture mantra

function CallApi(BiometricData,path) {
	//responce

 var device  = sessionStorage.getItem("device");

	var errCode = $(BiometricData).find('Resp').eq(0).attr('errCode');
	
	if(device == "MANTRA")
	{
	   var errInfo = $(BiometricData).find('Resp').eq(0).attr('errInfo');
	}else{
	    var errInfo = "Success";
	    
	}

	var fCount = $(BiometricData).find('Resp').eq(0).attr('fCount');
	var fType = $(BiometricData).find('Resp').eq(0).attr('fType');
	var nmPoints = $(BiometricData).find('Resp').eq(0).attr('nmPoints');
	var qScore = $(BiometricData).find('Resp').eq(0).attr('qScore');
	// responce end
	//----------------------------------------------------//
	//Device Info
	 var dpId = $(BiometricData).find('DeviceInfo').eq(0).attr('dpId');
	 var rdsId = $(BiometricData).find('DeviceInfo').eq(0).attr('rdsId');
	 var rdsVer = $(BiometricData).find('DeviceInfo').eq(0).attr('rdsVer');
	 var mi = $(BiometricData).find('DeviceInfo').eq(0).attr('mi');
	 var mc = $(BiometricData).find('DeviceInfo').eq(0).attr('mc');
	 var dc = $(BiometricData).find('DeviceInfo').eq(0).attr('dc');
	 // Device INFO END
	 //--------------------------------------------------//
	 // additional info
	 var srno = $(BiometricData).find('Param').eq(0).attr('value');
	 
	
	 if(device == "MANTRA")
	 {
	      var sysid = $(BiometricData).find('Param').eq(1).attr('value');
	      var ts = $(BiometricData).find('Param').eq(2).attr('value');
	 }else{
	     
	      var sysid = Math.random().toString(13).replace('0.', '');
	      var ts = Date.now();
	 }
	 
	 
	 //$(BiometricData).find('Param').eq(2).attr('value');
	 //addtional info end
	 //-------------------------------------------------//
	 //session info
	  var ci = $(BiometricData).find('Skey').eq(0).attr('ci');
	 $skey = $(BiometricData).find('Skey');
      var skey = $skey.text();
    //session info end
	//--------------------------------------------------//
	//hmac
	 $hmac = $(BiometricData).find('Hmac');
      var hmac = $hmac.text();
	//hmac end
	//-------------------------------------------------//
	var datatype = $(BiometricData).find('Data').eq(0).attr('type');
	 $data = $(BiometricData).find('Data');
    var pdata = $data.text();
	 
	 
	 var trfdata = {
		 "errCode" : errCode,
		 "errInfo" : errInfo,
		 "fCount" : fCount,
		 "fType" : fType,
		 "nmPoints" : nmPoints,
		 "qScore" : qScore,
		 "dpId" : dpId,
		 "rdsId" : rdsId,
		 "rdsVer" : rdsVer,
		 "mi" : mi,
		 "mc" : mc,
		 "dc" : dc,
		 "srno" : srno,
		 "sysid" : sysid,
		 "ts" : ts,
		 "ci" : ci,
		 "skey" : skey,
		 "hmac" : hmac,
		 "datatype" : datatype,
		 "pdata" : pdata
 	 
	 };
	        
	        
	 
	
	
	
	 
	
	
	
	

	
	if(path == "DK")
	{
	    
	    $.post( "/iciciaeps/kycfingerverify",trfdata,function( data ) {
	        
          document.getElementById("kycbtn").disabled = false;
          document.getElementById("kycbtn").innerHTML = "Capture Finger";
        if(data == 1)
        {
            alert('KYC SUCCESSFULL PROCESS');
            location.href="https://drparmar.in/partner/icici/panel";
        }else{
            alert(data);
        }

  
       });
       
     

	}
	
	
	 


  
}



//captcture mantra
        function CaptureMorpho(path) {
            debugger;
            var url = "http://127.0.0.1:11100/capture";
            var PIDOPTS = '<PidOptions ver=\"1.0\">' + '<Opts fCount=\"1\" fType=\"0\" iCount=\"\" iType=\"\" pCount=\"\" pType=\"\" format=\"0\" pidVer=\"2.0\" timeout=\"10000\"  env=\"P\" otp=\"\" wadh=\"E0jzJ/P8UopUHAieZn8CKqS4WPMi5ZSYXgfnlfkWjrc=\" posh=\"\"/>' + '</PidOptions>';
            /*
            format=\"0\"     --> XML
            format=\"1\"     --> Protobuf   env=\"P\"
            */
            var xhr;
            var ua = window.navigator.userAgent;
            var msie = ua.indexOf("MSIE ");

            if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) // If Internet Explorer, return version number
            {
                //IE browser
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
            else {
                //other browser
                xhr = new XMLHttpRequest();
            }

            xhr.open('CAPTURE', url, true);
            xhr.setRequestHeader("Content-Type", "text/xml");
            xhr.setRequestHeader("Accept", "text/xml");

            xhr.onload = function () {
                //if(xhr.readyState == 1 && count == 0){
                //	fakeCall();
                //}
                if (xhr.readyState == 4) {
                    var status = xhr.status;

                    if (status == 200) {
                      
                      
                         
                            CallApi(xhr.responseText,path);
                       

                }
                else {
                    alert(xhr.response);

                }
            }

            };

        xhr.send(PIDOPTS);

    }














function ClearCtrl()
{
	alert("Clear Control");
	
}
