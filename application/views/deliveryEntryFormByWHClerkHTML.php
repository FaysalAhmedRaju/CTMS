<script language="JavaScript">

	
	/*$('body').on('keydown', 'input, select, textarea', function(e) {
		var self = $(this)
		  , form = self.parents('form:eq(0)')
		  , focusable
		  , next
		  ;
		if (e.keyCode == 13) {
			focusable = form.find('input,select,button,textarea,submit').filter(':visible');
			next = focusable.eq(focusable.index(this)+1);
			if (next.length) {
				//next.style.backgroundColor = "red";
				next.focus();			
			} else {
				form.submit();
			}
			return false;
		}
	}); */
	
	$(document).on('keypress', 'input,select', function (e) {
    if (e.which == 13) {
        e.preventDefault();
        var $next = $('[tabIndex=' + (+this.tabIndex + 1) + ']');
        console.log($next.length);
        if (!$next.length) {
            //$next = $('[tabIndex=1]');
   form.submit();
        }
  else
        $next.focus();
    }
   });


function getBlInfo(blNo)  
   {        
		var rotNo=document.getElementById("rotNo").value;
		//alert(rotNo);
		if(blNo=="" || blNo==" " || rotNo=="" || rotNo==" ")
		{
			if(rotNo=="" || rotNo==" ")
			{
				alert("Rotation Field is blank");
				document.getElementById("rotNo").focus();
				return false;
			}
			
			if(blNo=="" || blNo==" ")
			{
				alert("BL Field is blank");
				document.getElementById("rotNo").focus();
				return false;
			}
		}
		else
		{
			//document.getElementById("rotNo").value=""; 
			document.getElementById("verifyNo").value="";
			document.getElementById("oneStopPoint").value="";
			document.getElementById("doQuantity").value="";
			document.getElementById("doUnit").value="";

			document.getElementById("marks").value="";
			document.getElementById("mloCode").value="";
			
			document.getElementById("doNo").value="";
			document.getElementById("doDate").value="";
			document.getElementById("validUpToDate").value="";
			//document.getElementById("mloStatus").value="";
			//document.getElementById("ffwStatus").value="";
		
		   // paperFileDate  exitNoteNum   date  truckNum cusOrderNo cusOrderDate
			document.getElementById("description").value="";
			//document.getElementById("mloStatus").value="";
			//document.getElementById("ffwStatus").value="";
			document.getElementById("importerName").value="";
			document.getElementById("grossWeight").value="";
			//document.getElementById("contNo").value="";
			//document.getElementById("contSize").value="";
			//document.getElementById("contHeight").value="";
			//document.getElementById("contType").value="";
			document.getElementById("mloLine").value="";
			document.getElementById("forwarderLine").value="";			
			//document.getElementById("commLandDate").value="";
			//document.getElementById("location").value="";
			document.getElementById("billNo").value="";
			document.getElementById("billOfEntryDate").value="";
			//document.getElementById("doDate").value="";
			//document.getElementById("validUpToDate").value="";
			//document.getElementById("totPack").value="";
			document.getElementById("shedTallyInfoID").value=""; 
			document.getElementById("netWeight").value="";
			document.getElementById("doIssuedBy").value="";
			document.getElementById("cnf_lic").value="";
			document.getElementById("cnfName").value="";  
			document.getElementById("paperFileDate").value="";  
			document.getElementById("exitNoteNum").value="";  
			document.getElementById("date").value="";  
			document.getElementById("truckNum").value="";  
			document.getElementById("cusOrderNo").value="";  
			document.getElementById("cusOrderDate").value="";  
			
			
			document.getElementById("date").value="";		
			//document.getElementById("billNo").value="";
			//document.getElementById("billOfEntryDate").value="";
			document.getElementById("invoiceAmount").value="";
			//document.getElementById("invoiceAmount1").value="";
			
			if (window.XMLHttpRequest) 
			{
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			} 
			else 
			{  
			// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			//alert(rotNo);
			//alert(blNo);
			xmlhttp.onreadystatechange=stateChangegetBLInfo;
			xmlhttp.open("GET","<?php echo site_url('ajaxController/getDeliveryByBLInfo')?>?blNo="+blNo+"&rotNo="+rotNo,false);	
			
			xmlhttp.send();	 
		}

   }


	function stateChangegetBLInfo()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{			
			var val = xmlhttp.responseText;
		   // alert(val);		
            //var val = xmlhttp.responseText;
			//var strArr = val.split("|");
		   // alert(val);
			
		 var jsonData = JSON.parse(val);
		 $('#myTable').find('tbody').empty();
		 if (jsonData.igmContList.length!=jsonData.beContList.length)
		 {
			alert("Container Mismatch !!! \n In IGM , No of Container : "+jsonData.igmContList.length+"\n IN Bill Of Entry , No Of Container : "+jsonData.beContList.length);
		 }
		 if (jsonData.exchnStatus=='no')
				{
				alert("Exchange Not Done or entered wrong BL!");
				}
				
		else{		
		 //alert(jsonData);
		 
		 for (var i = 0; i < jsonData.deliveryList.length; i++) 
		    {
				//alert(jsonData.deliveryList[i].Pack_Number);
				document.getElementById("shedTallyInfoID").value=jsonData.deliveryList[i].id;
			    var igmUnit=((jsonData.deliveryList[i].Pack_Description).trim());
				var recvUnit=((jsonData.deliveryList[i].rcv_unit).trim());

				if(jsonData.deliveryList[i].verify_number!=null)
				{
					document.getElementById("verifyNo").value=jsonData.deliveryList[i].verify_number;
					document.getElementById("vmsg").style.display = 'inline';
					document.getElementById("btn").style.display = 'none';	
                    // alert("Already, The BL is Verified.");   
						
					var  msgDiv = document.getElementById("msgDiv");
					msgDiv.innerHTML = "";
					//var v_num=jsonData.deliveryList[i].verify_number;
					var textMsgDiv = document.createTextNode("Verification no: "+jsonData.deliveryList[i].verify_number);
					msgDiv.appendChild(textMsgDiv);
					displayModal();
				}	
				else{
					document.getElementById("vmsg").style.display = 'none';
					document.getElementById("btn").style.display = 'inline';
				}
				
				
			if(igmUnit!= recvUnit && document.getElementById("verifyNo").value=="")
				{
					//alert(igmUnit);
					var  msgDiv1 = document.getElementById("msgDiv1");
					msgDiv1.innerHTML = "";
					var textMsgDiv1 = document.createTextNode("IGM Package Unit: "+igmUnit+"......");
					var textMsgDiv2 = document.createTextNode("Received Package Unit: "+recvUnit);
					
					
					msgDiv1.appendChild(textMsgDiv1);
					msgDiv1.appendChild(textMsgDiv2);
					packageDisplayModal();
				}
				
				var marks = (jsonData.deliveryList[i].actual_marks).trim();
				if(marks!="" &&  document.getElementById("verifyNo").value=="")
				{
					//alert(marks);
					var  msgDiv2 = document.getElementById("msgDiv2");
					msgDiv2.innerHTML = "";
					var textMsgDiv3 = document.createTextNode("Marks: "+marks);			
					msgDiv2.appendChild(textMsgDiv3);
					marksDisplayModal();
				}
				
				

				
			    //document.getElementById("blNo").value=jsonData[i].BL_No;
				
				document.getElementById("oneStopPoint").value=jsonData.deliveryList[i].one_stop_point;
		
				document.getElementById("doQuantity").value=jsonData.deliveryList[i].Pack_Number;
				document.getElementById("doUnit").value=jsonData.deliveryList[i].Pack_Description;

				document.getElementById("marks").value=jsonData.deliveryList[i].Pack_Marks_Number;  
				document.getElementById("mloCode").value=jsonData.deliveryList[i].mlocode;
				
				document.getElementById("doNo").value=jsonData.deliveryList[i].do_no;
				document.getElementById("doDate").value=jsonData.deliveryList[i].do_date;
				document.getElementById("validUpToDate").value=jsonData.deliveryList[i].valid_up_to_date;	
				
				document.getElementById("mloCode").value=jsonData.deliveryList[i].mlocode;
				document.getElementById("description").value=jsonData.deliveryList[i].Description_of_Goods;
				document.getElementById("mloLine").value=jsonData.deliveryList[i].master_BL_No;
				document.getElementById("forwarderLine").value=jsonData.deliveryList[i].BL_No;
				
				document.getElementById("importerName").value=jsonData.deliveryList[i].Notify_name;
				document.getElementById("grossWeight").value=jsonData.deliveryList[i].Cont_gross_weight;
				document.getElementById("netWeight").value=jsonData.deliveryList[i].cont_weight; 
				document.getElementById("doIssuedBy").value=jsonData.deliveryList[i].Organization_Name; 							
				//document.getElementById("contNo").value=jsonData.deliveryList[i].cont_number;
				//document.getElementById("contSize").value=jsonData.deliveryList[i].cont_size;
				//document.getElementById("contHeight").value=jsonData.deliveryList[i].cont_height;
				//document.getElementById("contType").value=jsonData.deliveryList[i].cont_type;
				//document.getElementById("mloStatus").value=jsonData.deliveryList[i].mloStatus;
				//document.getElementById("ffwStatus").value=jsonData.deliveryList[i].ffwStatus;

				//document.getElementById("location").value=jsonData.deliveryList[i].shed_loc;
			    document.getElementById("cnf_lic").value=jsonData.deliveryList[i].cnf_lic_no;
		        document.getElementById("cnfName").value=jsonData.deliveryList[i].cnf_name;
				
			    document.getElementById("date").value=jsonData.deliveryList[i].date;
				
			   document.getElementById("paperFileDate").value=jsonData.deliveryList[i].paper_file_date;  
		       document.getElementById("exitNoteNum").value=jsonData.deliveryList[i].exit_note_number;
		       //document.getElementById("date").value = jsonData.deliveryList[i].be_no;  
		       document.getElementById("truckNum").value=jsonData.deliveryList[i].no_of_truck;  
		       document.getElementById("cusOrderNo").value=jsonData.deliveryList[i].cus_rel_odr_no;  
		       document.getElementById("cusOrderDate").value=jsonData.deliveryList[i].cus_rel_odr_date;  
				
               document.getElementById("billNo").value=jsonData.deliveryList[i].be_no;
			   document.getElementById("billOfEntryDate").value=jsonData.deliveryList[i].be_date;
               document.getElementById("invoiceAmount").value=jsonData.deliveryList[i].grand_total;		
				//document.getElementById("doDate").value=jsonData[i].do_date;
				//document.getElementById("validUpToDate").value=jsonData[i].wr_upto_date;
			}
			for (var i = 0; i < jsonData.igmContList.length; i++) 
			 {  
				$('#feedback').append('<tr><td align="center" class="read" style="width:120px;">' 
				+ jsonData.igmContList[i].cont_number + '</td><td align="center" class="read" style="width:90px;">' 
				+ jsonData.igmContList[i].cont_size + '</td><td align="center" class="read" style="width:60px;">' 
				+ jsonData.igmContList[i].cont_height +'</td><td align="center" class="read" style="width:90px;">' 
				+ jsonData.igmContList[i].cont_status +'</td></tr>');
				
				 //alert(jsonData.igmContList[i].cont_number);


			}
		 /*for (var i = 0; i < jsonData.commLandDate.length; i++) 
		    {
				//alert(jsonData.commLandDate[i].rtnValue);
				document.getElementById("commLandDate").value=jsonData.commLandDate[i].rtnValue;

			}	*/			
		  }
			
		}
	}
	
	/* Get Info By B/E Number */
	function getSeaInfo(seaNo)  
   {        
		//var rotNo=document.getElementById("rotNo").value;
		//alert(rotNo);
		if(seaNo=="" || seaNo==" ")
		{
			if(seaNo=="" || seaNo==" ")
			{
				alert("SEA NUMBER Can not be blank");
				//document.getElementById("seaNumber").focus();
				//return false;
			}
		}
		else
		{
			//alert(seaNo);
			document.getElementById("rotNo").value=""; 
			document.getElementById("blNo").value=""; 
			document.getElementById("verifyNo").value="";
			document.getElementById("oneStopPoint").value="";
			document.getElementById("doQuantity").value="";
			document.getElementById("doUnit").value="";

			document.getElementById("marks").value="";
			document.getElementById("mloCode").value="";
			
			document.getElementById("doNo").value="";
			document.getElementById("doDate").value="";
			document.getElementById("validUpToDate").value="";
			//document.getElementById("mloStatus").value="";
			//document.getElementById("ffwStatus").value="";
		
		   // paperFileDate  exitNoteNum   date  truckNum cusOrderNo cusOrderDate
			document.getElementById("description").value="";
			//document.getElementById("mloStatus").value="";
			//document.getElementById("ffwStatus").value="";
			document.getElementById("importerName").value="";
			document.getElementById("grossWeight").value="";
			//document.getElementById("contNo").value="";
			//document.getElementById("contSize").value="";
			//document.getElementById("contHeight").value="";
			//document.getElementById("contType").value="";
			//document.getElementById("mloLine").value="";
			//document.getElementById("forwarderLine").value="";			
			//document.getElementById("commLandDate").value="";
			//document.getElementById("location").value="";
			document.getElementById("billNo").value="";
			document.getElementById("billOfEntryDate").value="";
			//document.getElementById("doDate").value="";
			//document.getElementById("validUpToDate").value="";
			//document.getElementById("totPack").value="";
			document.getElementById("shedTallyInfoID").value=""; 
			document.getElementById("netWeight").value="";
			document.getElementById("doIssuedBy").value="";
			document.getElementById("cnf_lic").value="";
			document.getElementById("cnfName").value="";  
			document.getElementById("paperFileDate").value="";  
			document.getElementById("exitNoteNum").value="";  
			document.getElementById("date").value="";  
			document.getElementById("truckNum").value="";  
			document.getElementById("cusOrderNo").value="";  
			document.getElementById("cusOrderDate").value="";  
			
			
			document.getElementById("date").value="";		
			//document.getElementById("billNo").value="";
			//document.getElementById("billOfEntryDate").value="";
			document.getElementById("invoiceAmount").value="";
			//document.getElementById("invoiceAmount1").value="";
			
			if (window.XMLHttpRequest) 
			{
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			} 
			else 
			{  
			// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			//alert(rotNo);
			//alert(blNo);
			xmlhttp.onreadystatechange=stateChangegetSEAInfo;
			xmlhttp.open("GET","<?php echo site_url('ajaxController/getDeliveryBySeaInfo')?>?seaNo="+seaNo,false);	
			
			xmlhttp.send();	 
		}

   }


	function stateChangegetSEAInfo()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{			
			var val = xmlhttp.responseText;
		   // alert(val);		
            //var val = xmlhttp.responseText;
			//var strArr = val.split("|");
		   // alert(val);
			
		 var jsonData = JSON.parse(val);
		 console.log(jsonData);
		 $('#myTable').find('tbody').empty();
		 for (var i = 0; i < jsonData.igmContList.length; i++) 
		 {  
			$('#feedback').append('<tr><td align="center" class="read" style="width:120px;">' 
			+ jsonData.igmContList[i].cont_number + '</td><td align="center" class="read" style="width:90px;">' 
			+ jsonData.igmContList[i].cont_size + '</td><td align="center" class="read" style="width:60px;">' 
			+ jsonData.igmContList[i].cont_height +'</td><td align="center" class="read" style="width:90px;">' 
			+ jsonData.igmContList[i].cont_status +'</td></tr>');
			
			 //alert(jsonData.igmContList[i].cont_number);


		}
		 if (jsonData.igmContList.length!=jsonData.beContList.length)
		 {
			alert("Container Mismatch !!! \n In IGM , No of Container : "+jsonData.igmContList.length+"\n IN Bill Of Entry , No Of Container : "+jsonData.beContList.length);
		 }
		if (jsonData.exchnStatus=='no')
		{
			alert("Exchange Not Done or entered wrong SEA NUMBER!");
		}
				
		else{		
		 //alert(jsonData);
		 
		 for (var i = 0; i < jsonData.deliveryList.length; i++) 
		    {
				//alert(jsonData.deliveryList[i].Pack_Number);
				document.getElementById("shedTallyInfoID").value=jsonData.deliveryList[i].id;
			    var igmUnit=((jsonData.deliveryList[i].Pack_Description).trim());
				var recvUnit=((jsonData.deliveryList[i].rcv_unit).trim());

				if(jsonData.deliveryList[i].verify_number!=null)
				{
					document.getElementById("verifyNo").value=jsonData.deliveryList[i].verify_number;
					document.getElementById("vmsg").style.display = 'inline';
					document.getElementById("btn").style.display = 'none';	
                    // alert("Already, The BL is Verified.");   
						
					var  msgDiv = document.getElementById("msgDiv");
					msgDiv.innerHTML = "";
					//var v_num=jsonData.deliveryList[i].verify_number;
					var textMsgDiv = document.createTextNode("Verification no: "+jsonData.deliveryList[i].verify_number);
					msgDiv.appendChild(textMsgDiv);
					displayModal();
				}	
				else{
					document.getElementById("vmsg").style.display = 'none';
					document.getElementById("btn").style.display = 'inline';
				}
				
				
			if(igmUnit!= recvUnit && document.getElementById("verifyNo").value=="")
				{
					//alert(igmUnit);
					var  msgDiv1 = document.getElementById("msgDiv1");
					msgDiv1.innerHTML = "";
					var textMsgDiv1 = document.createTextNode("IGM Package Unit: "+igmUnit+"......");
					var textMsgDiv2 = document.createTextNode("Received Package Unit: "+recvUnit);
					
					
					msgDiv1.appendChild(textMsgDiv1);
					msgDiv1.appendChild(textMsgDiv2);
					packageDisplayModal();
				}
				
				var marks = (jsonData.deliveryList[i].actual_marks).trim();
				if(marks!="" &&  document.getElementById("verifyNo").value=="")
				{
					//alert(marks);
					var  msgDiv2 = document.getElementById("msgDiv2");
					msgDiv2.innerHTML = "";
					var textMsgDiv3 = document.createTextNode("Marks: "+marks);			
					msgDiv2.appendChild(textMsgDiv3);
					marksDisplayModal();
				}
				
				

				document.getElementById("blNo").value=jsonData.deliveryList[i].BL_No;
				document.getElementById("rotNo").value=jsonData.deliveryList[i].import_rotation;
			    //document.getElementById("blNo").value=jsonData[i].BL_No;
				
				document.getElementById("oneStopPoint").value=jsonData.deliveryList[i].one_stop_point;
		
				document.getElementById("doQuantity").value=jsonData.deliveryList[i].Pack_Number;
				document.getElementById("doUnit").value=jsonData.deliveryList[i].Pack_Description;

				document.getElementById("marks").value=jsonData.deliveryList[i].Pack_Marks_Number;  
				document.getElementById("mloCode").value=jsonData.deliveryList[i].mlocode;
				
				document.getElementById("doNo").value=jsonData.deliveryList[i].do_no;
				document.getElementById("doDate").value=jsonData.deliveryList[i].do_date;
				document.getElementById("validUpToDate").value=jsonData.deliveryList[i].valid_up_to_date;	
				
				document.getElementById("mloCode").value=jsonData.deliveryList[i].mlocode;
				document.getElementById("description").value=jsonData.deliveryList[i].Description_of_Goods;
				document.getElementById("mloLine").value=jsonData.deliveryList[i].master_BL_No;
				document.getElementById("forwarderLine").value=jsonData.deliveryList[i].BL_No;
				
				document.getElementById("importerName").value=jsonData.deliveryList[i].Notify_name;
				document.getElementById("grossWeight").value=jsonData.deliveryList[i].Cont_gross_weight;
				document.getElementById("netWeight").value=jsonData.deliveryList[i].cont_weight; 
				document.getElementById("doIssuedBy").value=jsonData.deliveryList[i].Organization_Name; 							
				document.getElementById("contNo").value=jsonData.deliveryList[i].cont_number;
				document.getElementById("contSize").value=jsonData.deliveryList[i].cont_size;
				document.getElementById("contHeight").value=jsonData.deliveryList[i].cont_height;
				document.getElementById("contType").value=jsonData.deliveryList[i].cont_type;
				document.getElementById("mloStatus").value=jsonData.deliveryList[i].mloStatus;
				document.getElementById("ffwStatus").value=jsonData.deliveryList[i].ffwStatus;

				document.getElementById("location").value=jsonData.deliveryList[i].shed_loc;
			    document.getElementById("cnf_lic").value=jsonData.deliveryList[i].cnf_lic_no;
		        document.getElementById("cnfName").value=jsonData.deliveryList[i].cnf_name;
				
			    document.getElementById("date").value=jsonData.deliveryList[i].date;
				
			   document.getElementById("paperFileDate").value=jsonData.deliveryList[i].paper_file_date;  
		       document.getElementById("exitNoteNum").value=jsonData.deliveryList[i].exit_note_number;
		       //document.getElementById("date").value = jsonData.deliveryList[i].be_no;  
		       document.getElementById("truckNum").value=jsonData.deliveryList[i].no_of_truck;  
		       document.getElementById("cusOrderNo").value=jsonData.deliveryList[i].cus_rel_odr_no;  
		       document.getElementById("cusOrderDate").value=jsonData.deliveryList[i].cus_rel_odr_date;  
				
               document.getElementById("billNo").value=jsonData.deliveryList[i].be_no;
			   document.getElementById("billOfEntryDate").value=jsonData.deliveryList[i].be_date;
               document.getElementById("invoiceAmount").value=jsonData.deliveryList[i].grand_total;		
				//document.getElementById("doDate").value=jsonData[i].do_date;
				//document.getElementById("validUpToDate").value=jsonData[i].wr_upto_date;
			}
			
		 for (var i = 0; i < jsonData.commLandDate.length; i++) 
		    {
				//alert(jsonData.commLandDate[i].rtnValue);
				document.getElementById("commLandDate").value=jsonData.commLandDate[i].rtnValue;

			}				
		  }
			
		}
	}
	
	/* Get Info By B/E Number */
	
	
	
	function displayModal(){
		var modal = document.getElementById('myModal');					
		modal.style.display = "block";
	   }
	
	function packageDisplayModal(){
		var packModal = document.getElementById('packageModel');					
		packModal.style.display = "block";
		}
		
	function marksDisplayModal(){
		var marModel = document.getElementById('marksModel');					
		marModel.style.display = "block";
		}	
		
		
	function removeTableElement(table)
		{
		var tblLen = table.rows.length;
			//alert(tblLen);
			for(var i=tblLen;i>0;i--)
			{
				table.deleteRow(i-1);
			}				
		}
		

	

		
	function getcnfName(cnf_lic_no)
	{	
	    //alert(cnf_lic_no);
	  if (window.XMLHttpRequest) 
			{
			 // code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			} 
			else 
			{  
			// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=stateChangegetCNFInfo;
			xmlhttp.open("GET","<?php echo site_url('ajaxController/getCnfCode')?>?cnf_lic_no="+cnf_lic_no,false);
					
			xmlhttp.send();
	  
     }

	function stateChangegetCNFInfo()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{			
			var val = xmlhttp.responseText;	
			//alert(val);
            var jsonData = JSON.parse(val);	
	        for (var i = 0; i < jsonData.length; i++) 
		    {			
			 document.getElementById("cnfName").value=jsonData[i].name;
			}
		}
    }

	
	
	   function validate()
			{
			if( document.myForm.doNo.value == "" )
				{
					alert( "Please! Provide DO no.." );
					document.myForm.doNo.focus() ;
					return false;
				}
				else if( document.myForm.doDate.value == "" ) 
				{
					alert( "Please! Provide DO Date.." );
					document.myForm.doDate.focus() ;
					return false;
				}
				else if( document.myForm.validUpToDate.value == "" )
				{
					alert( "Please! Provide Valid Upto Date.." );
					document.myForm.validUpToDate.focus() ;
					return false;
				}
				
				else if( document.myForm.cnf_lic.value == "" )
				{
					alert( "Please! Provide CNF licence code.." );
					document.myForm.cnf_lic.focus() ;
					return false;
				}

				else if( document.myForm.cnfName.value == "" )
				{
					alert( "Please! Provide CNF Name.." );
					document.myForm.cnfName.focus() ;
					return false;
				}
				
				
				else if( document.myForm.paperFileDate.value == "" )
				{
					alert( "Please! Provide Papaer file Date.." );
					document.myForm.paperFileDate.focus() ;
					return false;
				}
				
				else if( document.myForm.exitNoteNum.value == "" )
				{
					alert( "Please! Provide Exit note No.." );
					document.myForm.exitNoteNum.focus() ;
					return false;
				}
			
					
				else if( document.myForm.date.value == "" )
				{
					alert( "Please! Provide date of exit.." );
					document.myForm.date.focus() ;
					return false;
				}
				else if( document.myForm.truckNum.value == "" )
				{
					alert( "Please! Provide number of Truck.." );
					document.myForm.truckNum.focus() ;
					return false;
				}
				else if( document.myForm.cusOrderNo.value == "" )
				{
					alert( "Please! Provide Custome order no.." );
					document.myForm.cusOrderNo.focus() ;
					return false;
				}
				else if( document.myForm.cusOrderDate.value == "" )
				{
					alert( "Please! Provide Custom Order Date." );
					document.myForm.cusOrderDate.focus() ;
					return false;
				}
				else
				return true;
			}

		function closeMsgBox()
			{
				//alert("OK");
				document.getElementById('myModal').style.display = "none";
			}

		function closeMsgBox2()
			{
				document.getElementById('packageModel').style.display = "none";
			}	
			
		function closeMsgBox3()
			{
				document.getElementById('marksModel').style.display = "none";
			}		
	</script>

<style>
.read{ background-color : #F7EEC0; }
/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 9999; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    position: relative;
    background-color: #fefefe;
    margin: auto;
    padding: 0;
    border: 1px solid #888;
    width: 35%;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
    -webkit-animation-name: animatetop;
    -webkit-animation-duration: 0.4s;
    animation-name: animatetop;
    animation-duration: 0.4s
}

/* Add Animation */
@-webkit-keyframes animatetop {
    from {top:-300px; opacity:0} 
    to {top:0; opacity:1}
}

@keyframes animatetop {
    from {top:-300px; opacity:0}
    to {top:0; opacity:1}
}

/* The Close Button */
.close {
    color: black;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.modal-header {
    padding: 2px 16px;
    background-color: #fff;
    color: #000;
	
}

.modal-body {padding: 2px 16px;}

.modal-footer {
    padding: 2px 16px;
    background-color: #5cb85c;
    color: white;
}
</style>
 

 <div class="content">
    <div class="content_resize_1">
      <div class="mainbar_1">
        <div class="article">
          <h2 align="center"><span><?php echo $title; ?></span> </h2>
		  <h3 align="center"><b>DOCUMENTATION PROCESS</b></h2>

          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>	  
		 
	
			<div class="img">
			<form name= "myForm" onsubmit="return validate();" action="<?php echo site_url("report/deliveryEntryForm");?>" target="successMsg" method="post">
			  
				<fieldset style=" background-color:#C1E0FF;">
				<legend><b>Search</b></legend>
				<table align="center"> 
					<tr>
						<th><nobr>SEA NUMBER :</nobr></th>
						<td><input style="width:100px;" type="text" id="seaNumber" name="seaNumber" onblur="getSeaInfo(this.value)"></td>
						<th>ROTATION NO :</th>
						<td align="center"><nobr><input style="width:100px;" type="text" id="rotNo" name="rotNo" <?php if($doFormFlag==1){?> value="<?php echo $rotNo;?>" <?php }?> tabindex="1" ><font color='red'><b>*</b></font></nobr></td>
						<th>VERIFY NO :</th>
						<td align="center"><input style="width:100px;" class="read" type="text"  id="verifyNo" name="verifyNo" readonly></td>
					</tr>
				</table>
				</fieldset>
				
				<fieldset style=" background-color:#C1E0FF;"> 
				<legend><b>IGM Information</b></legend>
				<table> 
					<tr>
						<th><nobr>ONE STOP POINT :</nobr></th>
						<td><input style="width:100px;"  class="read" type="text" id="oneStopPoint" name="oneStopPoint" readonly></td>
						<th><nobr>DO NO :</nobr></th>
						<td><nobr><input style="width:70px;" type="text"  id="doNo" name="doNo"  tabindex="3"><font color='red'><b>*</b></font></nobr></td>
						<th><nobr>DO DATE :</nobr></th>
						<td><nobr><input style="width:90px;" type="text" id="doDate" name="doDate"  tabindex="4"><font color='red'><b>*</b></font></nobr></td>
						<script>
							  $(function() {
								$( "#doDate").datepicker({
									changeMonth: true,
									changeYear: true,
									dateFormat: 'yy-mm-dd', // iso format
									});
								});
						</script>
						<th><nobr>VALID UPTO DATE :</nobr></th>
						<td><nobr><input style="width:100px;" type="text" id="validUpToDate" name="validUpToDate"  tabindex="5"><font color='red'><b>*</b></font></nobr></td>
		                <script>
							  $(function() {
								$( "#validUpToDate").datepicker({
									changeMonth: true,
									changeYear: true,
									dateFormat: 'yy-mm-dd', // iso format
									});
								});
						</script>				
						
					</tr>
					<tr>
						<th><nobr>BL NO :</nobr></th>
						<td><nobr><input style="width:140px;" type="text"  id="blNo" name="blNo" <?php if($doFormFlag==1){?> value="<?php echo $blNo;?>"  autofocus <?php }?> onblur="getBlInfo(this.value)" tabindex="2"><font color='red'><b>*</b></font></nobr></td>
						<th><nobr>MLO :</nobr></th>
						<td><input style="width:70px;" class="read" type="text" id="mloCode" name="mloCode" readonly></td>
						<th><nobr>Marks :</nobr></th>
						<td colspan="3"><input type="text" class="read" style="width:310px;" id="marks" name="marks" readonly></td>
						
						
						
						<input type="hidden"  id="shedTallyInfoID" name="shedTallyInfoID">

					</tr>
					<tr>
						<th><nobr>MLO LINE :</nobr></th> 
						<td><input style="width:140px;" class="read" type="text" id="mloLine" name="mloLine" readonly></td>
						<th ><nobr>DESCRIPTION :</nobr></th>
						<td colspan="5"><input style="width:474px;" class="read" type="text" id="description" name="description" readonly></td>
					</tr>
					<tr>
						<th><nobr>FORWARDER LINE :</nobr></th>
						<td colspan="2"><input style="width:240px;" class="read" type="text"  id="forwarderLine" name="forwarderLine" readonly></td>
						<th><nobr>DO QUANTITY :</nobr></th>
						<td colspan="2"><input style="width:100px;" class="read" type="text"  id="doQuantity"name="doQuantity" readonly></td>	
						<th><nobr>DO Unit :</nobr></th>
						<td><input style="width:100px;" class="read" type="text" id="doUnit" name="doUnit" readonly></td>	
					</tr>
					<tr>
						<th><nobr>IMPORTER NAME :</nobr></th>
						<td colspan="2"><input style="width:240px;" class="read" type="text" id="importerName" name="importerName" readonly></td>
						<th><nobr>GROSS WEIGHT :</nobr></th>
						<td colspan="2"><nobr><input style="width:60px;"  class="read" type="text"  id="grossWeight"name="grossWeight" readonly> KG</nobr></td>

						<th> <nobr>NET WEIGHT :</nobr></th>
						<td><nobr><input type="text" style="width:80px;" class="read"   id="netWeight" name="netWeight" readonly> KG</nobr></td>

					</tr>
					<tr>
						<th><nobr>DO ISSUED BY :</nobr></th>
						<td colspan="7"><input style="width:725px;" class="read" type="text" id="doIssuedBy" name="doIssuedBy" readonly></td>
						
					</tr>
				</table>
				</fieldset>

				<fieldset style=" background-color:#C1E0FF;">
					<legend><b>Container Details</b></legend>
				<table border="0" id="myTable">
					<thead>
						<tr>
							 <th><nobr>Container No</nobr></th>  
							 <th>Size</th>
							 <th>Height</th>
							 <th>Type</th>
							 <th><nobr>MLO Status</nobr></th>
							 <th><nobr>FFW Status</nobr></th>
							 <th><nobr>Comm Land Date</nobr></th> 
							 <th>Location</th>
							 <th>Pass</th>
						</tr>
					</thead>
					<tbody id="feedback">
					</tbody>
					<!--tr>
						<td align="center"><input type="text" class="read" style="width:120px;" id="contNo" name="contNo" readonly></td>
						<td align="center"><input type="text" class="read" style="width:90px;"  id="contSize"  name="contSize" readonly></td>
						<td align="center"><input type="text" class="read" style="width:60px;" id="contHeight"  name="contHeight" readonly></td>
						<td align="center"><input type="text" class="read" style="width:90px;" id="contType"  name="contType" readonly></td>
						<td align="center"><input type="text" class="read" style="width:75px;" id="mloStatus"  name="mloStatus" readonly></td>
						<td align="center"><input type="text" class="read" style="width:75px;"  id="ffwStatus" name="ffwStatus" readonly></td>
						<td align="center"><input type="text" class="read" style="width:90px;"  id="commLandDate" name="commLandDate" readonly></td>
						<td align="center"><input type="text" class="read" style="width:90px;"  id="location" name="location" readonly></td>
						<td><input style="width:15px"  type="checkbox" id="pass" name="pass"></td>
					</tr>
					<tr>
						<td align="center"><input type="text" class="read" style="width:120px;" id="contNo" name="contNo" readonly></td>
						<td align="center"><input type="text" class="read" style="width:90px;"  id="contSize"  name="contSize" readonly></td>
						<td align="center"><input type="text" class="read" style="width:60px;" id="contHeight"  name="contHeight" readonly></td>
						<td align="center"><input type="text" class="read" style="width:90px;" id="contType"  name="contType" readonly></td>
						<td align="center"><input type="text" class="read" style="width:75px;" id="mloStatus"  name="mloStatus" readonly></td>
						<td align="center"><input type="text" class="read"style="width:75px;"  id="ffwStatus" name="ffwStatus" readonly></td>
						<td align="center"><input type="text" class="read" style="width:90px;"  id="commLandDat" name="commLandDat" readonly></td>
						<td align="center"><input type="text" class="read" style="width:90px;"  id="location" name="location" readonly></td>
						<td><input style="width:15px"  type="checkbox" id="pass" name="pass"></td>
					</tr-->
					<!--tr>
						<td><input type="text" style="width:120px;" id="contNo" name="contNo" readonly></td>
						<td><input type="text" style="width:90px;"  id="contSize"  name="contSize" readonly></td>
						<td><input type="text" style="width:60px;" id="contHeight"  name="contHeight" readonly></td>
						<td><input type="text" style="width:90px;" id="contType"  name="contType" readonly></td>
						<td><input type="text" style="width:75px;" id="mloStatus"  name="mloStatus" readonly></td>
						<td><input type="text" style="width:75px;"  id="ffwStatus" name="ffwStatus" readonly></td>
						<td><input type="text" style="width:90px;"  id="commLandDate" name="commLandDate" readonly></td>
						<td><input type="text" style="width:90px;"  id="location" name="location" readonly></td>
						<td><input style="width:15px"  type="checkbox" id="pass" name="pass"></td>
					</tr-->
				  </table>
				</fieldset>

				<fieldset style=" background-color:#C1E0FF; border: solid-1px;">
					<legend><b>CNF Info</b></legend>
				<table>	
					<tr> 
						<td>
							<table>
								<tr>
									<th> C & F AGENT :</th>
									<td> <input type="text" style="width:80px;" id="cnf_lic" name="cnf_lic"  onblur="getcnfName(this.value)" tabindex="6"><font color='red'><b>*</b></font></td>
									<td> <input type="text" class="read"  style="width:220px;" id="cnfName" name="cnfName" readonly></td>
								</tr>
								<tr>
									<th> <nobr>PAPER FILE DATE </nobr></th> 
									<td colspan="2"> <input type="text" style="width:135px;"  id="paperFileDate" name="paperFileDate" tabindex="7"><font color='red'><b>*</b></font></td>
									<script>
											  $(function() {
												$( "#paperFileDate" ).datepicker({
													changeMonth: true,
													changeYear: true,
													dateFormat: 'yy-mm-dd', // iso format
												});
											});
									</script> 
								</tr>  
								<tr>
								    <th><nobr>EXIT NOTE NUMBER</nobr></th>
									<td colspan="2"><input type="text" style="width:135px;"  id="exitNoteNum" name="exitNoteNum" tabindex="8" ><font color='red'><b>*</b></font></</td>
								</tr>
								<tr>
								    <th><nobr>DATE</nobr></th>
									<td colspan="2"><input type="text" class="read" style="width:135px;"  id="date" name="date" readonly ></</td>
									<script>
											  $(function() {
												$( "#date" ).datepicker({
													changeMonth: true,
													changeYear: true,
													dateFormat: 'yy-mm-dd', // iso format
												});
											});
									</script>
								</tr>
								<tr>
								    <th><nobr>NUMBER OF TRUCK</nobr></th>
									<td colspan="2"><input type="text" style="width:135px;"  id="truckNum" name="truckNum"  tabindex="9"><font color='red'><b>*</b></font></</td>
								</tr>
							</table>
						</td>
						<td span="6">
						</td>
						<td>
							<table>
								<tr>
									<th><nobr>BILL OF ENTRY NO </nobr></th>
									<td colspan="2"> <input type="text"  style="width:145px;" id="billNo" name="billNo" ></td>
								</tr>
								<tr>
									<th><nobr>BILL OF ENTRY DT :</nobr></th>
									<td colspan="2"> <input type="text"  style="width:135px;" id="billOfEntryDate" name="billOfEntryDate" ></td>
									<script>
											  $(function() {
												$( "#billOfEntryDate" ).datepicker({
													changeMonth: true,
													changeYear: true,
													dateFormat: 'yy-mm-dd', // iso format
												});
											});
									</script>
								</tr>
								<tr>
									<th><nobr>INVOICE AMOUNT :</nobr></th>
									<td> <input type="text"  style="width:110px;" id="invoiceAmount" name="invoiceAmount"  ></td>
									<td> <input type="text"  style="width:60px;" id="invoiceAmount1" name="invoiceAmount1" ></td>
								</tr>
								<tr>
									<th><nobr>CUS ORDER NO :</nobr></th>
									<td colspan="2"><nobr><input type="text" style="width:170px;" id="cusOrderNo" name="cusOrderNo"  tabindex="10"><font color='red'><b>*</b></font></nobr></td>

								</tr>
								<tr>
									<th><nobr>CUS ORDER DATE:</nobr></th>
									<td colspan="2"><nobr><input type="text" style="width:135px;" id="cusOrderDate" name="cusOrderDate"  tabindex="11"><font color='red'><b>*</b></font></nobr></td>
									<script>
											  $(function() {
												$( "#cusOrderDate" ).datepicker({
													changeMonth: true,
													changeYear: true,
													dateFormat: 'yy-mm-dd', // iso format
												});
											});
									</script>
								</tr>
							</table>
						</td>
					</tr>			 
		 
		        </table>
					
			</fieldset>
				<!--fieldset style=" background-color:#C1E0FF; border: solid-1px;">
				<legend><b>Tally Info</b></legend>
					<table>
						<tr>
							<th>TOTAL PACKAGE</th>
							<td><input type="text" id="totPack" name="totPack" readonly></td>
							<th>RECEIVE PACKAGE</th>
							<td><input type="text" id ="rcvPack" name="rcvPack" readonly></td>
						</tr>
					</table>
				</fieldset-->
				
				<fieldset style=" background-color:#C1E0FF; border: solid-1px;">
				<legend><b>Buttons</b></legend>
					<table align="center"  id="mytbl">
						<!--tr>
							<th> W/H Clerk</th>
							<td colspan="3"><input type="text" style="width:170px;" id="whClerk"name="whClerk"></td>
						</tr-->
						<tr>
							<td align="center">
								<div id="btn">
									<input type="submit" value="SAVE" id="save" name="save" class="login_button" tabindex="12"/> 
									<a href="<?php echo site_url('report/deliveryEntryFormByWHClerk/');?>" class="login_button" style="text-decoration: none;padding:4px;font-size:12px;"><nobr>CLEAR</nobr></a>
								</div>
								<div id="vmsg" style="display:none;">
									<font color="red">This is already verified.</font>
									<a href="<?php echo site_url('report/deliveryEntryFormByWHClerk/');?>" class="login_button" style="text-decoration: none;padding:4px;font-size:12px;"><nobr>CLEAR</nobr></a>
								</div>
							</td>
						</tr>
						
						<tr>
							<td>
								<iframe id="successMsg" name="successMsg" height="50" width="600" style="border:0"></iframe>
							</td>
						</tr>
					</table>
					
										
				</fieldset>
				
				
				
			</form>	
			</div>
			
          <div class="clr"></div>
        </div>

<!-- The Modal -->
	<div id="myModal" class="modal">
		<!-- Modal content -->
		<div class="modal-content">
		<div align="center" class="modal-header">
		  <span class="close" onclick="closeMsgBox()">&times;</span>
		  <h2><font color="red">This BL is already verified.</font></h2>
		</div>
		<div align="center"  class="modal-body">
			<div id="msgDiv"></div>
		</div>
		<!--<div class="modal-footer">
		  <h3>Modal Footer</h3>
		</div>-->
		</div>
	</div>


	<div id="packageModel" class="modal">
		<!-- Modal content -->
		<div class="modal-content">
		<div align="center" class="modal-header">
		  <span class="close" onclick="closeMsgBox2()">&times;</span>
		  <h2><font color="red">Different Unit!</font></h2>
		</div>
		<div align="center"  class="modal-body">
			<div id="msgDiv1"></div>
		</div>
		</div>
	</div>


	<div id="marksModel" class="modal">
		<!-- Modal content -->
		<div class="modal-content">
		<div align="center" class="modal-header">
		  <span class="close" onclick="closeMsgBox3()">&times;</span>
		  <h2><font color="red">This BL Received nill/wrong mark!</font></h2>
		</div>
		<div align="center"  class="modal-body">
			<div id="msgDiv2"></div>
		</div>
		</div>
	</div>

       <!-- <p class="pages"><small>Page 1 of 2</small> <span>1</span> <a href="#">2</a> <a href="#">&raquo;</a></p>-->
      </div>
      <div class="sidebar" style="width:140px; padding: 0px 0 12px;">
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	<?php echo form_close()?>
  </div>