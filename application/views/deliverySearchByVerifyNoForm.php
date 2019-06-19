<script language="JavaScript">

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

  function getVerifyInfo(verifyNo)
     { 
	    //document.getElementById("rotNo").value="";
	    //document.getElementById("verifyNo").value="";
		document.getElementById("regNo").value="";
		document.getElementById("mloBLno").value="";   
	    document.getElementById("fBLno").value="";      		
	    document.getElementById("vslNam").value=""; 
	    document.getElementById("unStuffDate").value=""; 
	    document.getElementById("unTallyShitNo").value=""; 	
		document.getElementById("unRecvQty").value="";    
		document.getElementById("unRecvPKQty").value="";   
		document.getElementById("marksNo").value="";
		document.getElementById("description").value="";
		document.getElementById("quantity").value="";
		document.getElementById("pkUnit").value="";
		document.getElementById("grossWeight").value=""
		document.getElementById("netWeight").value="";
		document.getElementById("importerName").value="";
		document.getElementById("apprDate").value="";
		document.getElementById("cfAgentCode").value="";
		document.getElementById("cfAgentName").value="";
		document.getElementById("customBillofEntryNo").value="";
		document.getElementById("customBillofEntryDate").value="";
		document.getElementById("contNo").value="";
		document.getElementById("contSize").value="";
		document.getElementById("contHeight").value="";
		document.getElementById("contType").value="";
        document.getElementById("status").value="";
		document.getElementById("unstuffShedNo").value="";
		document.getElementById("cargoRecLoc").value="";
		document.getElementById("verifyNo1").value="";
		document.getElementById("verifyDate").value="";
		document.getElementById("invoiceValue").value="";
		document.getElementById("custRealiseOrderNum").value="";
		document.getElementById("custRealiseOrderDate").value="";
		document.getElementById("exitNoteNum").value="";
		document.getElementById("exitNoteDate").value="";
		document.getElementById("billNumber").value="";
		document.getElementById("billDate").value="";
		document.getElementById("bankCPno").value="";
		document.getElementById("bankCPdate").value="";
		document.getElementById("portBillStatus").value="";
		document.getElementById("truckNum").value="";
		document.getElementById("assignClerk").value="";
	

		//var rotNo=document.getElementById("rotNo").value;
		
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
		xmlhttp.onreadystatechange=stateChangegetVerifyInfo;
		xmlhttp.open("GET","<?php echo site_url('ajaxController/getVerifyInfo')?>?verifyNo="+verifyNo,false);	
       	
		xmlhttp.send(); 

   }


	function stateChangegetVerifyInfo()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{			
			var val = xmlhttp.responseText;
		    //alert(val);		
            //var val = xmlhttp.responseText;
			//var strArr = val.split("|");
		    //alert(val);
			
		 var jsonData = JSON.parse(val);
		 for (var i = 0; i < jsonData.length; i++) 
		    {
				document.getElementById("regNo").value=jsonData[i].import_rotation;
				document.getElementById("mloBLno").value=jsonData[i].master_BL_No;  
				document.getElementById("fBLno").value=jsonData[i].BL_No;		
				document.getElementById("vslNam").value=jsonData[i].Vessel_Name;
				document.getElementById("unStuffDate").value=jsonData[i].wr_date;
				document.getElementById("unTallyShitNo").value=jsonData[i].tally_sheet_number;	
				document.getElementById("unRecvQty").value=jsonData[i].un_rcv_qty;    
				document.getElementById("unRecvPKQty").value=jsonData[i].Pack_Description;   
				document.getElementById("marksNo").value=jsonData[i].Pack_Marks_Number;
				document.getElementById("description").value=jsonData[i].Description_of_Goods;
				document.getElementById("quantity").value=jsonData[i].Pack_Number;
				document.getElementById("pkUnit").value=jsonData[i].Pack_Description; 
				document.getElementById("grossWeight").value=jsonData[i].Cont_gross_weight;
				document.getElementById("netWeight").value=jsonData[i].cont_weight;
				var importer = jsonData[i].Notify_name +" "+jsonData[i].Notify_address ; 
				document.getElementById("importerName").value=importer;
				document.getElementById("importerNam").value=jsonData[i].Notify_name;         //for hidden field
				document.getElementById("importerAddress").value=jsonData[i].Notify_address;  //for hidden field
				document.getElementById("apprDate").value=jsonData[i].appraise_date;
				document.getElementById("cfAgentCode").value=jsonData[i].cnf_lic_no;
				document.getElementById("cfAgentName").value=jsonData[i].cnf_name;
				document.getElementById("customBillofEntryNo").value=jsonData[i].be_no;
				document.getElementById("customBillofEntryDate").value=jsonData[i].be_date;
				document.getElementById("contNo").value=jsonData[i].cont_number;
				document.getElementById("contSize").value=jsonData[i].cont_size;
				document.getElementById("contHeight").value=jsonData[i].cont_height;
				document.getElementById("contType").value=jsonData[i].cont_type;
				document.getElementById("status").value=jsonData[i].cont_status;
				document.getElementById("unstuffShedNo").value=jsonData[i].shed_loc;
				document.getElementById("cargoRecLoc").value=jsonData[i].shed_yard;
				
                document.getElementById("verifyNo1").value=jsonData[i].verify_number;
				
				//document.getElementById("verifyNo1").value=jsonData[i].verify_number;
				document.getElementById("verifyDate").value=jsonData[i].verifyDate;
				document.getElementById("invoiceValue").value=jsonData[i].grand_total;
				document.getElementById("custRealiseOrderNum").value=jsonData[i].cus_rel_odr_no;
				document.getElementById("custRealiseOrderDate").value=jsonData[i].cus_rel_odr_date;
				document.getElementById("exitNoteNum").value=jsonData[i].exit_note_number;
				document.getElementById("exitNoteDate").value=jsonData[i].date;
				document.getElementById("billNumber").value=jsonData[i].bill_no;
				document.getElementById("billDate").value=jsonData[i].bill_date;
				document.getElementById("portBillStatus").value=jsonData[i].bill_rcv_stat;
				document.getElementById("shedTallyId").value=jsonData[i].shed_tally_id;
				document.getElementById("truckNum").value=jsonData[i].no_of_truck;
				if(jsonData[i].bill_rcv_stat=="Not Paid" )	
				   {
					    //alert("Not ok");
					    $("#portBillStatus").removeClass("read2");
					    $("#portBillStatus").removeClass("read");
						$('#portBillStatus').addClass('read3');
                   
					//document.getElementById("portBillStatus").classList.remove('read2');
				  }
				  
				  else if(jsonData[i].bill_rcv_stat=="Paid")
					{
						  //alert("ok");
					    $('#portBillStatus').removeClass('read');
						$('#portBillStatus').removeClass('read3');
						$('#portBillStatus').addClass('read2');
                      
						//document.getElementById("portBillStatus").classList.add('read2');
					}
					else
					{
						$('#portBillStatus').removeClass('read3');
						$('#portBillStatus').removeClass('read2');
						$('#portBillStatus').addClass('read');
					}
				
				var cp_no = jsonData[i].cp_no;
				var cp_year = jsonData[i].cp_year;
				var cp_bank_code = jsonData[i].cp_bank_code;
				var cp_unit = jsonData[i].cp_unit;
				var cpLen = cp_no.length;
				var finaCPno = "";
				//alert(cpLen);
				if(cpLen==1)
					finaCPno = cp_bank_code+cp_unit+"/"+cp_year+"-000"+cp_no;
				else if(cpLen==2)
					finaCPno = cp_bank_code+cp_unit+"/"+cp_year+"-00"+cp_no;
				else if(cpLen==3)
					finaCPno = cp_bank_code+cp_unit+"/"+cp_year+"-0"+cp_no;
				else
					finaCPno = cp_bank_code+cp_unit+"/"+cp_year+"-"+cp_no;
				
				document.getElementById("bankCPno").value=finaCPno;
				document.getElementById("bankCPdate").value=jsonData[i].bank_cp_date;
				
				
				//var clerkAssign=(jsonData[i].clerk_assign.trim());
				if(jsonData[i].clerk_assign!=null)
				{ 
					alert("Already! A clerk is assigned.");
					//getClerk();
					/* $("#asClerk").show();
					$("#clerkName").show();
					document.getElementById("clerkName").value =jsonData[i].clerk_assign;*/
					var selectList=document.getElementById("assignClerk");
					removeOptions(selectList);
					var option = document.createElement('option');
					option.value = jsonData[i].clerk_assign;  //value of option in backend
					option.text = jsonData[i].clerk_assign;	  //text of option in frontend
					option.selected = true;
					selectList.appendChild(option);
				    $("#save").attr("disabled",true);
				}
				else
				  {		
					getClerk();
					//$("#asClerk").show();
					
					$("#save").removeAttr("disabled");
					
                  }
			}			
		}
	}
	
	
	//clerk asign
		function getClerk(){
		//alert(val);
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
		var url = "<?php echo site_url('ajaxController/getClerk')?>?";
		//alert(url);
		xmlhttp.onreadystatechange=stateChangeSection;
		xmlhttp.open("GET",url,false);
		xmlhttp.send();
	}
	
	function stateChangeSection()
	{
		//alert(xmlhttp.responseText);
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			var selectList=document.getElementById("assignClerk");
			removeOptions(selectList);
			//alert(xmlhttp.responseText);
			var val = xmlhttp.responseText;
			var jsonData = JSON.parse(val);
			//alert(xmlhttp.responseText);
			for (var i = 0; i < jsonData.length; i++) 
			{
				var option = document.createElement('option');
				option.value = jsonData[i].u_name;  //value of option in backend
				option.text = jsonData[i].u_name;	  //text of option in frontend
				selectList.appendChild(option);
			}
		}
	}
	
	function removeOptions(selectbox)
	{
		var i;
		for(i=selectbox.options.length-1;i>=1;i--)
		{
			selectbox.remove(i);
		}
	}
	
	
	function validate() 
	{
     if( document.myForm.assignClerk.value == "" )
			{
			 alert( "Please Select a Clerk!" );
			 document.myForm.assignClerk.focus() ;
			 return false;
			}
		else
			return true;
	}
	
</script>
<style>
.read{ background-color : #F7EEC0; }
.read2{ background-color : #45f55f; }
.read3{ background-color : #ff5746; }
</style>
 
 <div class="content">
    <div class="content_resize_1">
      <div class="mainbar_1">
        <div class="article">
          <h2 align="center"><span><?php echo $title; ?></span> </h2>
		  <!--h3 align="center"><b>DOCUMENTATION PROCESS</b></h3-->

          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>	  
		 
	
			<div class="img" style="background-color:#C1E0FF;">
			<form onsubmit="return(validate());" action="<?php echo site_url("report/deliverySearchByVerify");?>" name="myForm" method="post">
			
				<div style="width:100%;">
				  <table>
					<tr>
						<th align="right;" style="color:blue;">VERIFY NO :</th>
						<td align="left"><input style="width:140px;" type="text"  id="verifyNo" name="verifyNo" onblur="getVerifyInfo(this.value)" tabindex="1"></td>

					</tr>
			      </table>
				</div>
			 
				<div style="width:40%; float:left; background-color:#C1E0FF;">
						<table>
							<tr>
								<th align="right"><nobr>Reg/No</nobr></th>
								<td><input type="text" class="read" style="width:120px;" id="regNo" name="regNo" readonly></td>
							</tr>
							<tr>
								<th align="right"><nobr>MLO BL/No</nobr></th>
								<td><input type="text" class="read" style="width:120px;" id="mloBLno" name="mloBLno" readonly></td>
							</tr>
							<tr>
								<th align="right"><nobr>F BL/No</nobr></th>
								<td><input type="text" class="read" style="width:120px;" id="fBLno" name="fBLno" readonly></td>
							</tr>	
							<tr>
								<th align="right"><nobr>VSL NAME</nobr></th>
								<td><input type="text" class="read" style="width:120px;" id="vslNam" name="vslNam" readonly></td>
							</tr>
							<tr>
								<th align="right"><nobr>Unstuffing Date</nobr></th>
								<td><input type="text" class="read" style="width:120px;" id="unStuffDate" name="unStuffDate" readonly></td>
							</tr>
							<tr>
								<th align="right"><nobr>Un Tally Shit No</nobr></th>
								<td><input type="text" class="read" style="width:120px;" id="unTallyShitNo" name="unTallyShitNo" readonly></td>
							</tr>
							
							<tr>
								<th align="right"><nobr>Un Recieve Qty</nobr></th>
								<td><input type="text" class="read" style="width:120px;" id="unRecvQty" name="unRecvQty" readonly></td>
							</tr>
							<tr>
								<th align="right"><nobr>Un Recieve Pk Unit<nobr></th>
								<td><input type="text" class="read" style="width:120px;" id="unRecvPKQty" name="unRecvPKQty" readonly></td>
							</tr>
							<tr>
							<th align="right"><nobr>Custom Bill of Entry No</nobr></th>
							<td><input type="text" class="read" style="width:120px;" id="customBillofEntryNo" name="customBillofEntryNo" readonly></td>
						</tr>
						<tr>
							<th align="right"><nobr>Custom Bill of Entry Date</nobr></th>
							<td><input type="text" class="read"  style="width:120px;" id="customBillofEntryDate" name="customBillofEntryDate" readonly></td>
						</tr>
						</table>
		         </div>
		 
		 
		         <div style="width:60%; float:left;  background-color:#C1E0FF;">
						<table>
							<tr>
								<th align="right"><nobr>Marks_Number</nobr></th>
								<td><input type="text" class="read" style="width:120px;" id="marksNo" name="marksNo" readonly></td>
							</tr>
							<tr>
								<th align="right"><nobr>Descrption</nobr></th>
								<td><input type="text" class="read"  style="width:120px;" id="description" name="description" readonly></td>
							</tr>
							<tr>
								<th align="right"><nobr>Quantity</nobr></th>
								<td><input type="text" class="read" style="width:120px;" id="quantity" name="quantity" readonly></td>
							</tr>	
							<tr>
								<th align="right"><nobr>Pk Unit</nobr></th>
								<td><input type="text" class="read" style="width:120px;" id="pkUnit" name="pkUnit" readonly></td>
							</tr>
							<tr>
								<th align="right"><nobr>Net Weight</nobr></th>
								<td><input type="text" class="read" style="width:120px;" id="netWeight" name="netWeight" readonly></td>
							</tr>
							<tr>
								<th align="right"><nobr>Gross Weight</nobr></th>
								<td><input type="text" class="read" style="width:120px;" id="grossWeight" name="grossWeight" readonly></td>
							</tr>	
							<tr>
							<th align="right"><nobr>Appraisement Date</nobr></th>
							<td><input type="text"class="read" style="width:120px;" id="apprDate" name="apprDate" readonly></td>
							</tr>
							<tr>
							<th align="right"><nobr>CF Agent Code</nobr></th>
							<td><input type="text" class="read"  style="width:120px;" id="cfAgentCode" name="cfAgentCode" readonly></td>
						</tr>
						<tr>
							<th align="right"><nobr>CF Agent Name Address</nobr></th>
							<td><input type="text"class="read" style="width:265px;" id="cfAgentName" name="cfAgentName" readonly></td>
						</tr>
						<tr>
							<th align="right"><nobr>Importer Name Address</nobr></th>
							<td><input type="text" class="read" style="width:265px;" id="importerName" name="importerName" readonly></td>
						    <td><input type="hidden" style="" id="importerNam" name="importerNam" readonly></td>
							<td><input type="hidden" style="" id="importerAddress" name="importerAddress" readonly></td>
						</tr>
					</table>
 
		      </div>
           
		  
			<div>
			    <table style="width:80%" align="left">
				    <tr>
					     <th>Container No</th>
						 <th>Size</th>
					     <th>Height</th>
					     <th>Type</th>
					     <th>Status</th>
					     <th>Unstuffing Shed No</th>
					     <th>Cargo Recive Location</th>
					</tr> 

					<tr>
					    <td><input type="text" class="read" style="width:120px" id="contNo" name="contNo" readonly> </td>
					    <td><input type="text" class="read" style="width:65px" id="contSize" name="contSize" readonly> </td>
					    <td><input type="text" class="read" style="width:65px" id="contHeight" name="contHeight" readonly> </td>
					    <td><input type="text" class="read" style="width:65px" id="contType" name="contType" readonly> </td>
					    <td><input type="text" class="read" style="width:65px" id="status" name="status" readonly> </td>
					    <td><input type="text" class="read" style="width:140px" id="unstuffShedNo" name="unstuffShedNo" readonly> </td>
					    <td><input type="text" class="read"  style="width:140px" id="cargoRecLoc" name="cargoRecLoc" readonly> </td>

					</tr>
				</table>
			</div>
           
		   	<div>
			    <table style="width:80%" align="left"> 
				    <tr>
					     <th>Verify Number</th>
						 <th>Verify Date</th>
					     <th>Invoice Value</th>
					     <th>Custum Realise </br> Order Number</th>
					     <th>Custom Realise </br>Order Date</th>
					</tr>
					<tr>
					    <td><input type="text" class="read" style="width:150px" id="verifyNo1" name="verifyNo1" readonly> </td>
					    <td><input type="text" class="read" style="width:120px" id="verifyDate" name="verifyDate" readonly> </td>
					    <td><input type="text" class="read" style="width:120px" id="invoiceValue" name="invoiceValue" readonly> </td>
					    <td><input type="text" class="read" style="width:115px" id="custRealiseOrderNum" name="custRealiseOrderNum"> </td>
					    <td><input type="text" class="read" style="width:115px" id="custRealiseOrderDate" name="custRealiseOrderDate"> </td>
					</tr>
				</table>
			</div> 
       		<div> 
			    <table>
				    <tr>
					     <th>Exit Note Number</th>
						 <th>Exit Note Date</th>
					     <th>Bill Number</th>
					     <th>Bill Date</th>
					     <th style="border: 1px solid; width:120px"; align="center">Bank CP/No</th>
					     <th style="border: 1px solid; width:120px"; align="center">Bank CP Date</th>
					     <th style="border: 1px solid; width:120px"; align="center">Port Bill Status</th>
					</tr>
					<tr>
					    <td><input type="text" class="read" style="width:100px" id="exitNoteNum" name="exitNoteNum" readonly> </td>
					    <td><input type="text" class="read" style="width:85px" id="exitNoteDate" name="exitNoteDate" readonly> </td>
					    <td><input type="text" class="read" style="width:85px" id="billNumber" name="billNumber" readonly> </td>
					    <td><input type="text" class="read" style="width:85px" id="billDate" name="billDate" readonly> </td>
					    <td><input type="text" class="read" style="width:120px" id="bankCPno" name="bankCPno" readonly> </td>
					    <td><input type="text" class="read" style="width:120px" id="bankCPdate" name="bankCPdate" readonly> </td>
					    <td><input type="text" class="read" style="width:120px" id="portBillStatus" name="portBillStatus" readonly> </td>

					</tr>
				</table>
			</div>
	
	        <div>
			<table>
			<input type="hidden" style="" id="shedTallyId" name="shedTallyId">
			
		
			  <tr >

			      <th style="border: 1px solid; width:150px";align="center">Assign Clerk to Delivery </th>
				   <!--td><input type="text"  style="width:190px" id="assignClerk" name="assignClerk"><font color='red'><b>*</b></font></td-->
				  <td  id="asClerk"><select id="assignClerk" name="assignClerk"  tabindex="2">
								<option value="">---Select Clerk---</option>
	
					 </select></td>							
			  </tr>
		
			  
			  
			  <tr>
			      <th style="border: 1px solid; width:150px";align="center">Truck Number</th>
				  <td><input type="text" class="read" style="width:110px" id="truckNum" name="truckNum" readonly></td>
			  </tr>
			</table>
			</div>
			<table align="center">
			   <!--tr><td><iframe id="successMsg" name="successMsg" height="50" width="450" style="border:0"></iframe></td></tr-->
			   <tr><td><?PHP ECHO $msg;?></td></tr>
			   <tr><td align="center"><input type="submit" value="SAVE" id="save" name="save" class="login_button"  tabindex="3"/> </td></tr>
			</table>
				
			</form>	
			</div>
			
          <div class="clr"></div>
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