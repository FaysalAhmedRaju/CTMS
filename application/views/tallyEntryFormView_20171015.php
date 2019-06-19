<html>
	<head>
		<title>Chittagong Port Authority</title>
		<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>calender.jquery-ui.css">
		<link rel="stylesheet" href="<?php echo CSS_PATH; ?>popUp.css" type="text/css"/>
		<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.6.0.min.js"></script>
		<script type="text/javascript" src="<?php echo JS_PATH; ?>calender.jquery-ui.min.js"></script>
		<style type="text/css">
		  #overlay {
			  background: rgba(0,0,0,0.4);
			  width: 100%;
			  height: 100%;
			  min-height: 100%;
			  position: absolute;
			  top: 0;
			  left: 0;
			  z-index: 5;
			}
			.button {
				display: block;
				width: 100%;
				height: 5%;
				background: #4E9CAF;
				padding: 10px;
				text-align: center;
				border-radius: 5px;
				color: white;
				font-weight: bold;
				text-decoration: none;
			}
		</style>
		<script>		
			function exchangeDone() {
				var answer = confirm("Are you want to Exchange Done?")
					if (answer) {
						var rotation=document.getElementById("rot").value;
						var container=document.getElementById("cont").value;
						//console.log(rotation+"--"+container);
						//alert(rotation+"--"+container);
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
							xmlhttp.onreadystatechange=stateChangeValue;
							xmlhttp.open("GET","<?php echo site_url('ajaxController/ExchangeDoneStatusChange')?>?rotation="+rotation+"&container="+container,false);
							xmlhttp.send();
					}
					else {
						
					}
				//alert("K");		
				
				 
			}
			function stateChangeValue()
				{
					//alert("ddfd");
					if (xmlhttp.readyState==4 && xmlhttp.status==200) 
					{
							  
						var val = xmlhttp.responseText;
						var jsonData = JSON.parse(val);
						//alert(jsonData.stat);
						//var cnfCodeTxt=document.getElementById("cnfName");
						if(jsonData.stat[0]=="1")
						{
							//document.getElementById("btnTr").style.visibility = 'hidden';
							document.getElementById("btnTr").innerHTML = "";
							document.getElementById("btnTr2").innerHTML = "";
							alert("Exchange Done.");
							deleteLastrow();
							document.getElementById('btnSig').innerHTML = "Exchange Done.<nobr><a class='button' href='#popup1'  onclick='txttransfer()'><font color='white'>Upload Signature</font></a></nobr>";
							document.getElementById("btnView").style.visibility = 'block';
						}
						else
						{
							alert("Exchange Not Done.");
						}
					}
				}
			function validateField()
			{
				var wrDate=document.getElementById('wrDate').value;
				
				if(wrDate=="")
				{
					alert("Unstuffing Date Is Empty.");
					document.getElementById('wrDate').focus();
					return false;
				}
				else
				{
					var flag = false;
					  $('.chkValidation').filter(function() {
						if (this.value == '' || this.value == '0.0') {
							flag=true;			
						}
					  });
					if(flag==true)
					{
						var answer = confirm("Some Fields ate Empty.Are you want to Save Tally Sheet?");
							if (answer) {
								return true;
							}
							else {
								return false;
							}		
					}
				}
			}
			function txttransfer(){
							//alert("TEST");
							var div = document.getElementById('popup1');
							div.style.display = 'block';
							
							var rotNumber="";
							var containerNumber="";
							var userTransfer="";
							
							
							rotNumber="<b>"+document.getElementById("rotNumTransfer").value+"</b>";
							containerNumber="<b>"+document.getElementById("contNumTransfer").value+"</b>";
							userTransfer="<b>"+document.getElementById("userTransfer").value+"</b>";
							
							
							//alert("kdf : "+containerNumber);
							
							document.getElementById('rotNum').innerHTML=rotNumber;
							document.getElementById('contNum').innerHTML=containerNumber;
							document.getElementById('userName').innerHTML=userTransfer;
							
							
							document.getElementById("rotNumber").value=document.getElementById("rotNumTransfer").value;
							document.getElementById("contNumber").value=document.getElementById("contNumTransfer").value;
							document.getElementById("user").value=document.getElementById("userTransfer").value;
					
							
						}
	function deleteRow(row)
	{
		var i=row.parentNode.parentNode.rowIndex;
		document.getElementById('myTbl').deleteRow(i);
	}
	function deleteLastrow() 
	{
		var table = document.getElementById('myTbl');
		var rowCount = table.rows.length;
		table.deleteRow(rowCount -1);
	}
	function addRowToTbl()
	{
		//alert("TEST");
		$("#myTbl").append('<tr bgcolor="#A9D0F5"><td> </td><td> </td><td> </td>'+
							'<td> </td><td> </td><td> </td><td> </td>'+
							'<td> </td><td> </td><td> </td><td> </td>'+
							'<td> </td>'+
							'<td align="center">'+											
											<!--input size="5" type="text" name="rcvpre" value="<?php if($numrowrcvAll==0) echo '0.0'; else echo $rowrcv->rcv_pack;?>" readonly="true" style="background-color:#D8D8D8;"/><br/-->
											'<font size="5"><b>+</b></font><br/>'+
											'<input type="text" size="5"/>'+											
									'</td>'+
							'<td align="center">'+											
											<!--input size="5" type="text" name="rcvpre" value="<?php if($numrowrcvAll==0) echo '0.0'; else echo $rowrcv->rcv_pack;?>" readonly="true" style="background-color:#D8D8D8;"/><br/-->
											'<font size="5"><b>+</b></font><br/>'+
											'<input type="text" size="5"/>'+											
									'</td>'+
							'<td align="center">'+											
											<!--input size="5" type="text" name="rcvpre" value="<?php if($numrowrcvAll==0) echo '0.0'; else echo $rowrcv->rcv_pack;?>" readonly="true" style="background-color:#D8D8D8;"/><br/-->
											'<font size="5"><b>+</b></font><br/>'+
											'<input type="text" size="5"/>'+											
									'</td>'+
							'<td align="center">'+											
											<!--input size="5" type="text" name="rcvpre" value="<?php if($numrowrcvAll==0) echo '0.0'; else echo $rowrcv->rcv_pack;?>" readonly="true" style="background-color:#D8D8D8;"/><br/-->
											'<font size="5"><b>+</b></font><br/>'+
											'<input type="text" size="5"/>'+											
									'</td>'+
							'<td align="center">'+											
											<!--input size="5" type="text" name="rcvpre" value="<?php if($numrowrcvAll==0) echo '0.0'; else echo $rowrcv->rcv_pack;?>" readonly="true" style="background-color:#D8D8D8;"/><br/-->
											'<font size="5"><b>+</b></font><br/>'+
											'<input type="text" size="5"/>'+											
									'</td>'+
							'<td align="center">'+											
											<!--input size="5" type="text" name="rcvpre" value="<?php if($numrowrcvAll==0) echo '0.0'; else echo $rowrcv->rcv_pack;?>" readonly="true" style="background-color:#D8D8D8;"/><br/-->
											
											'<input type="text" size="5"/>'+											
									'</td>'+
							'<td align="center">'+											
											<!--input size="5" type="text" name="rcvpre" value="<?php if($numrowrcvAll==0) echo '0.0'; else echo $rowrcv->rcv_pack;?>" readonly="true" style="background-color:#D8D8D8;"/><br/-->
											
											'<select name="shiftname"><option value="day">Day</option><option value="night">Night</option></select> '+											
									'</td>'+
							'<td align="center">'+											
											<!--input size="5" type="text" name="rcvpre" value="<?php if($numrowrcvAll==0) echo '0.0'; else echo $rowrcv->rcv_pack;?>" readonly="true" style="background-color:#D8D8D8;"/><br/-->
											
											'<textarea cols="12" rows="5" style="resize:none;"></textarea>'+											
									'</td>'+
							'<td align="center">'+											
											<!--input size="5" type="text" name="rcvpre" value="<?php if($numrowrcvAll==0) echo '0.0'; else echo $rowrcv->rcv_pack;?>" readonly="true" style="background-color:#D8D8D8;"/><br/-->
											
											'<input  type="button" id="removeRow" value="Remove" onclick="deleteRow(this)"'+											
									'</td>'+
							'</tr>');
	}
		</script>
	</head>
	<body>
	<form action="<?php echo site_url('report/updateTallyInfo');?>" method="post" onsubmit="return validateField()">
		<table width="100%" cellpadding="0">
			<tr bgcolor="#273076" height="100px">
				<td align="center" valign="middle">
					<h1><font color="white">Chittagong Port Authority</font></h1>
				</td>
			</tr>
			<tr bgcolor="#2E9AFE">
				<td align="left" valign="middle" style="padding-top:10px;padding-left:20px;">
					<?php
					
							//$rot_number = $rtnContainerList[$i]['Import_Rotation_No'];
							//$con_number = $rtnContainerList[$i]['cont_number'];
							$strDt = "";							
							$strDt = "select distinct wr_date,tally_sheet_number,tally_sheet_no from shed_tally_info where import_rotation='$rotation' and cont_number='$cont'";
							//echo "Tst : ".$strDt;
							$resDt = mysql_query($strDt);
							$numrowDt = mysql_num_rows($resDt);
							$rowrcv = mysql_fetch_object($resDt);
					?>																						
						<script>
							$(function() {
							 $( "#wrDate" ).datepicker({
							  changeMonth: true,
							  changeYear: true,
							  dateFormat: 'yy-mm-dd', // iso format
							 });
							});
						</script>
					<h3><font color="white">Tally Entry Form for<?php echo " Rotation: <font color='#1C0204'>".$rotation."</font> and Container: <font color='#1C0204'>".$cont."</font>";?></font>     
					<font color="red"><b>Unstuffing Date</b></font> :  
					<input size="10" type="text" id="wrDate" name="wrDate" value="<?php if($numrowDt==0) echo ""; else echo $rowrcv->wr_date;?>" />
					<input size="10" type="hidden" id="maxTallyNo" name="maxTallyNo" value="<?php if($numrowDt==0) echo ""; else echo $rowrcv->tally_sheet_no;?>" />
					<input  type="hidden" id="rotNumTransfer" name="rotNumTransfer" value="<?php echo $rotation;?>" />
					<input  type="hidden" id="contNumTransfer" name="contNumTransfer" value="<?php echo $cont;?>" />
					<input  type="hidden" id="userTransfer" name="userTransfer" value="<?php echo $login_id;?>" />
					
					<font color="green"><b>Tally Sheet Number</b></font> : <input class="" size="15" type="text" id="tallySheetNumber" name="tallySheetNumber" value="<?php if($numrowDt==0) echo ""; else echo $rowrcv->tally_sheet_number;?>" readonly="true"/>
					<br/></h3>
				</td>
			</tr>
			<tr>
				<td align="left" valign="middle">
					<h3><?php echo $stat;?></h3>
				</td>
			</tr>
			<tr>
				<td>
					
					<table id="myTbl" border="0" align="center" cellspacing="1" cellpadding="1">
						<tr bgcolor="#58ACFA">
							<td rowspan="2">SL.</td>
							<td rowspan="2">Import Rotation</td>
							<td rowspan="2">Master BL</td>
							<td rowspan="2">BL No.</td>
							<td rowspan="2">Seal Number</td>
							<td rowspan="2">Marks & Number</td>
							<td rowspan="2">Description<br>of Goods</td>
							<!--td rowspan="2">Consignee Description</td-->
							<td rowspan="2">Notify Description</td>
							<td rowspan="2">Cont Size</td>
							<td rowspan="2">Cont Gross Weight</td>
							<td rowspan="2">Package Unit</td>
							<td rowspan="2">Package Qty</td>
							<!--td style="display:none" rowspan="2">Unstuff Date</td-->
							<td align="center" colspan="5">Pack Rcv</td>
							
							<!--td>Location in Shed</td-->
							<td rowspan="2">Bay No</td>
							<!--td>Loc First</td-->
							<!--td rowspan="2">Tally Sheet Number</td-->
							<!--td rowspan="2">Physical<br>Marks</td-->
							<td rowspan="2">Shift Name</td>
							<td rowspan="2">Physical Marks</td>
							<!--td rowspan="2">Remarks</td-->
							<!--td rowspan="2">Action</td>
							<td rowspan="2">Report</td-->
						</tr>
						<tr bgcolor="#58ACFA">
							<td>IWH</td>
							<td>Loc Fast</td>
							<td>Ship Survey</td>
							<td>Total</td>
							<td>Rcv Unit</td>
						</tr>
						
							<?php
								include_once("mydbPConnection.php");
								//echo "45454 : ".$update_btn_status."---".$save_btn_status;
								if($save_btn_status=="1" || $update_btn_status=="1")
								{
									$equal=1;	
									//echo "1";
								}
								else
								{
									$equal=0;
									//echo "2";
								}
								//echo "Before Loop : ".$equal;
								for($i=0; $i< count($rtnContainerList)+$equal;$i++) { 
								//echo "After Loop : ".count($rtnContainerList)+1;
									?>
									<tr bgcolor="#A9D0F5">
										<td>
											<?php echo $i+1;?>
										</td>
											
										<td>
											<?php echo "<font size='2'>".$rtnContainerList[$i]['Import_Rotation_No']."</font>"?>
										</td>
										<td>
											<?php echo "<font size='2'>".$rtnContainerList[$i]['master_BL_No']."</font>"?>
										</td>
										<td>
											<?php echo "<font size='2'>".$rtnContainerList[$i]['BL_No']."</font>"?>
										</td>				
										<td>
											<?php echo "<font size='2'>".$rtnContainerList[$i]['cont_seal_number']."</font>"?>
										</td>
										<td width="200">
											<?php echo "<font size='2'>".$rtnContainerList[$i]['Pack_Marks_Number']."</font>"?>
										</td>
										<td width="200">
											<?php echo "<font size='2'>".$rtnContainerList[$i]['Description_of_Goods']."</font>"?>
										</td>
										<!--td width="200">
											<?php echo "<font size='2'>".$rtnContainerList[$i]['ConsigneeDesc']."</font>"?>
										</td-->
										<td width="200">
											<?php echo "<font size='2'>".$rtnContainerList[$i]['NotifyDesc']."</font>"?>
										</td>
										<td>
											<?php echo $rtnContainerList[$i]['cont_size']?>
										</td>
										<td>
											<?php echo $rtnContainerList[$i]['Cont_gross_weight']?>
										</td>
										<td>
											<?php echo $rtnContainerList[$i]['Pack_Description']?>
										</td>
										<td>
											<?php echo $rtnContainerList[$i]['Pack_Number']?>
										</td>
															
										
										
										<input type="hidden" value="<?php echo $rtnContainerList[$i]['id']?>"  name="dtlId<?php echo $i;?>" style="width:80px">
										<input type="hidden" value="<?php echo $rotation?>" id="rot"  name="rot" style="width:80px">
										<input type="hidden" value="<?php echo $cont?>"  id="cont" name="cont" style="width:80px">
										<input type="hidden" value="<?php echo $tbl?>"  name="tbl<?php echo $i;?>" style="width:80px">
										
										<!--td style="display:none">
											<?php
												$supDtlId = $rtnContainerList[$i]['id'];
												$strDt = "";
												if($tbl=="sup_detail")
													$strDt = "select wr_date  from shed_tally_info where igm_sup_detail_id='$supDtlId'";
												else
													$strDt = "select wr_date from shed_tally_info where igm_detail_id='$supDtlId'";
												$resDt = mysql_query($strDt);
												$numrowDt = mysql_num_rows($resDt);
												$rowrcv = mysql_fetch_object($resDt);
												?>
											<input class="validateField" size="7" type="text" id="wrDate" name="wrDate" value="<?php if($numrowDt==0) echo ""; else echo $rowrcv->wr_date;?>" /><br/>
											
											<script>
											 $(function() {
											 $( "#wrDate" ).datepicker({
											  changeMonth: true,
											  changeYear: true,
											  dateFormat: 'yy-mm-dd', // iso format
											 });
											 });
											</script>
																					
										</td-->	
										<td align="center">
											<?php
												$supDtlId = $rtnContainerList[$i]['id'];
												$strrcv = "";
												if($tbl=="sup_detail")
													$strrcv = "select sum(rcv_pack) as rcv_pack from shed_tally_info where igm_sup_detail_id='$supDtlId'";
												else
													$strrcv = "select sum(rcv_pack) as rcv_pack from shed_tally_info where igm_detail_id='$supDtlId'";
												$resrcv = mysql_query($strrcv);
												$rowrcv = mysql_fetch_object($resrcv);
												
												$strrcvAll = "";
												if($tbl=="sup_detail")
													$strrcvAll = "select rcv_pack from shed_tally_info where igm_sup_detail_id='$supDtlId'";
												else
													$strrcvAll = "select rcv_pack from shed_tally_info where igm_detail_id='$supDtlId'";
												$resrcvAll = mysql_query($strrcvAll);
												$numrowrcvAll = mysql_num_rows($resrcvAll);
												$strAllRcv = "";
												$rcv=0;
												while($rowrcvAll=mysql_fetch_object($resrcvAll))
												{
													$rcv++;
													//echo $rcv."<".$numrowrcv."<br>";
													if($rcv<$numrowrcvAll)
														$strAllRcv = $strAllRcv.$rowrcvAll->rcv_pack." + ";
													else
														$strAllRcv = $strAllRcv.$rowrcvAll->rcv_pack." =";
												}
												//echo $i."<br>";
												echo $strAllRcv."<br>";
											?>
											<!--input size="5" type="text" name="rcvpre" value="<?php if($numrowrcvAll==0) echo '0.0'; else echo $rowrcv->rcv_pack;?>" readonly="true" style="background-color:#D8D8D8;"/><br/-->
											<font size="5"><b>+</b></font><br/>
											<input class="chkValidation" size="5" type="text" id="rcv<?php echo $i;?>" name="rcv<?php echo $i;?>" value="<?php if($numrowrcvAll==0) echo '0.0'; else echo $rowrcv->rcv_pack;?>" onfocus="if(this.value=='0.0') this.value=''"/>
											<script>
											$('#rcv<?php echo $i;?>').keyup(function() {
												//alert("jfkg");
												
												var tot= parseFloat($("#rcv<?php echo $i;?>").val())+parseFloat($("#conLocFast<?php echo $i;?>").val())+parseFloat($("#flt<?php echo $i;?>").val());
												$("#totalPck<?php echo $i;?>").val(tot);
											});			
											</script>
										</td>
										
										<td align="center">
											<?php
												$supDtlId = $rtnContainerList[$i]['id'];
												$strrcv = "";
												if($tbl=="sup_detail")
													$strrcv = "select sum(loc_first) as loc_first from shed_tally_info where igm_sup_detail_id='$supDtlId'";
												else
													$strrcv = "select sum(loc_first) as loc_first from shed_tally_info where igm_detail_id='$supDtlId'";
												$resrcv = mysql_query($strrcv);
												$rowrcv = mysql_fetch_object($resrcv);
												
												$strrcvAll = "";
												if($tbl=="sup_detail")
													$strrcvAll = "select loc_first from shed_tally_info where igm_sup_detail_id='$supDtlId'";
												else
													$strrcvAll = "select loc_first from shed_tally_info where igm_detail_id='$supDtlId'";
												$resrcvAll = mysql_query($strrcvAll);
												$numrowrcvAll = mysql_num_rows($resrcvAll);
												$strAllRcv = "";
												$rcv=0;
												while($rowrcvAll=mysql_fetch_object($resrcvAll))
												{
													$rcv++;
													//echo $rcv."<".$numrowrcv."<br>";
													if($rcv<$numrowrcvAll)
														$strAllRcv = $strAllRcv.$rowrcvAll->loc_first." + ";
													else
														$strAllRcv = $strAllRcv.$rowrcvAll->loc_first." =";
												}
												//echo $i."<br>";
												echo $strAllRcv."<br>";
											?>
											<!--input type="text" size="5" name="conLocFastpre" value="<?php if($numrowrcvAll==0) echo '0.0'; else echo $rowrcv->loc_first;?>" readonly="true" style="background-color:#D8D8D8;"/><br/-->
											<font size="5"><b>+</b></font><br/>
											<input class="chkValidation" size="5" type="text" id="conLocFast<?php echo $i;?>" name="conLocFast<?php echo $i;?>" value="<?php if($numrowrcvAll==0) echo '0.0'; else echo $rowrcv->loc_first;?>" onfocus="if(this.value=='0.0') this.value=''"/>
											<script>
												$('#conLocFast<?php echo $i;?>').keyup(function() {
												
												var tot= parseFloat($("#conLocFast<?php echo $i;?>").val())+ parseFloat($("#rcv<?php echo $i;?>").val())+parseFloat($("#flt<?php echo $i;?>").val());
												$("#totalPck<?php echo $i;?>").val(tot);
												});	
											</script>
										</td>
										
										<td align="center">
											<?php
												$strflt = "";
												if($tbl=="sup_detail")
													$strflt = "select sum(flt_pack) as flt_pack from shed_tally_info where igm_sup_detail_id='$supDtlId'";
												else
													$strflt = "select sum(flt_pack) as flt_pack from shed_tally_info where igm_detail_id='$supDtlId'";
												$resflt = mysql_query($strflt);
												$rowflt = mysql_fetch_object($resflt);
												
												$strfltAll="";
												if($tbl=="sup_detail")
													$strfltAll = "select flt_pack,shed_loc,tally_sheet_no from shed_tally_info where igm_sup_detail_id='$supDtlId'";
												else
													$strfltAll = "select flt_pack,shed_loc,tally_sheet_no from shed_tally_info where igm_detail_id='$supDtlId'";
												$resfltAll = mysql_query($strfltAll);
												$numrowfltAll = mysql_num_rows($resfltAll);
												$strAllFlt = "";
												$strBayLoc = "";
												$flt=0;
												while($rowfltAll=mysql_fetch_object($resfltAll))
												{
													$flt++;
													$strBayLoc = $rowfltAll->shed_loc;
													$tally_sheet_no = $rowfltAll->tally_sheet_no;
													
													//echo $rcv."<".$numrowrcv."<br>";
													if($flt<$numrowfltAll)
														$strAllFlt = $strAllFlt.$rowfltAll->flt_pack." + ";
													else
														$strAllFlt = $strAllFlt.$rowfltAll->flt_pack." =";
												}
												//echo $i."<br>";
												echo $strAllFlt."<br>";
											?>
											<!--input size="5" type="text" name="fltpre" value="<?php if($numrowfltAll==0) echo '0.0'; else echo $rowflt->flt_pack;?>" readonly="true" style="background-color:#D8D8D8;"/><br/-->
											<font size="5"><b>+</b></font><br/>
											<input class="chkValidation" size="5" type="text" id="flt<?php echo $i;?>" name="flt<?php echo $i;?>" value="<?php if($numrowfltAll==0) echo '0.0'; else echo $rowflt->flt_pack;?>" onfocus="if(this.value=='0.0') this.value=''"/>
											<!--script>
												$('#flt<?php echo $i;?>').keyup(function() {
												
												var tot= parseFloat($("#flt<?php echo $i;?>").val())+parseFloat($("#conLocFast<?php echo $i;?>").val())+ parseFloat($("#rcv<?php echo $i;?>").val());
												$("#totalPck<?php echo $i;?>").val(tot);
												});	
											</script-->
										</td>
										<td align="center">
											<?php
												$supDtlId = $rtnContainerList[$i]['id'];
												//echo "ID : ".$supDtlId;
												$strrcv = "";
												if($tbl=="sup_detail")
													$strrcv = "select sum(total_pack) as total_pack from shed_tally_info where igm_sup_detail_id='$supDtlId'";
												else
													$strrcv = "select sum(total_pack) as total_pack from shed_tally_info where igm_detail_id='$supDtlId'";
												$resrcv = mysql_query($strrcv);
												$rowrcv = mysql_fetch_object($resrcv);
												
												$strrcvAll = "";
												if($tbl=="sup_detail")
													$strrcvAll = "select total_pack from shed_tally_info where igm_sup_detail_id='$supDtlId'";
												else
													$strrcvAll = "select total_pack from shed_tally_info where igm_detail_id='$supDtlId'";
												$resrcvAll = mysql_query($strrcvAll);
												$numrowrcvAll = mysql_num_rows($resrcvAll);
												$strAllRcv = "";
												$rcv=0;
												while($rowrcvAll=mysql_fetch_object($resrcvAll))
												{
													$rcv++;
													//echo $rcv."<".$numrowrcv."<br>";
													if($rcv<$numrowrcvAll)
														$strAllRcv = $strAllRcv.$rowrcvAll->total_pack." + ";
													else
														$strAllRcv = $strAllRcv.$rowrcvAll->total_pack." =";
												}
												//echo $i."<br>";
												echo $strAllRcv."<br>";
												if($tbl=="sup_detail")						
												$strRcvUnit = "select rcv_unit from shed_tally_info where igm_sup_detail_id='$supDtlId'";
												else
												$strRcvUnit = "select rcv_unit from shed_tally_info where igm_detail_id='$supDtlId'";
												
												$resRcvUnit = mysql_query($strRcvUnit);
												$rowRcvUnit=mysql_fetch_object($resRcvUnit);
												$RcvUnit = $rowRcvUnit->rcv_unit;
												//echo "RCV :".$RcvUnit;
											?>
											<!--input size="5" type="text" name="totalPckpre" value="<?php if($numrowrcvAll==0) echo '0.0'; else echo $rowrcv->total_pack;?>" readonly="true" style="background-color:#D8D8D8;"/><br/-->
											<font size="5"><b>+</b></font><br/>
											<input class="chkValidation" size="5" type="text" id="totalPck<?php echo $i;?>" name="totalPck<?php echo $i;?>" value="<?php if($numrowrcvAll==0) echo '0.0'; else echo $rowrcv->total_pack;?>" readonly="true"/>
										</td>
										<td align="center">
											</br>
											<font size="5"><b>+</b></font><br/>
											<input class="chkValidation" type="search" size="5" value="<?php echo $RcvUnit;?>" list="rcvUnit" placeholder="Pick Unit" name="rcv_unit<?php echo $i;?>">
											<datalist id="rcvUnit" >
											<?php				
												$supDtlId = $rtnContainerList[$i]['id'];
												//echo "ID : ".$supDtlId;
												$strrcvAll = "";
																				
													//if($tbl=="sup_detail")
														//$strrcvAll = "select rcv_unit from shed_tally_info where igm_sup_detail_id='$supDtlId'";
													//else
														//$strrcvAll = "select rcv_unit from shed_tally_info where igm_detail_id='$supDtlId'";
													
													//$resrcvAll = mysql_query($strrcvAll);
													$strrcvAllQry = "select Pack_Unit as Pack_Description from igm_pack_unit";
													
													$resrcvAllT = mysql_query($strrcvAllQry);
															
													while($rowrcvAllQry=mysql_fetch_object($resrcvAllT))
													{
														echo '<option selected="selected" value="'.$rowrcvAllQry->Pack_Description.'">'.$rowrcvAllQry->Pack_Description.'</option>';													
													}
														
													

													
												//echo $i."<br>";
												echo $strAllRcv."<br>";
												
											?>
											</datalist>
											<!--input size="5" type="text" name="totalPckpre" value="<?php if($numrowrcvAll==0) echo '0.0'; else echo $rowrcv->total_pack;?>" readonly="true" style="background-color:#D8D8D8;"/><br/-->
											
										</td>
										<td>
											<input size="5" type="text" value="<?php if($numrowfltAll==0) echo ''; else echo $strBayLoc;?>" name="contAtShed<?php echo $i;?>"/>
											<!--select name="contAtShed" id="contAtShed">  
												<option value="">--------Select---------</option>
												<option value="CFS/NCT">CFS/NCT</option> 
												<option value="CFS/CCT">CFS/CCT</option> 
												<option value="13 Shed">13 Shed</option> 
												<option value="12 Shed">12 Shed</option> 
												<option value="9 Shed">9 Shed</option> 
												<option value="8 Shed">8 Shed</option> 
												<option value="7 Shed">7 Shed</option> 
												<option value="6 Shed">6 Shed</option> 
												<option value="N Shed">N Shed</option> 
												<option value="D Shed">D Shed</option> 
												<option value="P Shed">P Shed</option> 	
										   </select-->	
										</td>
										
										<!--td>
											<select name="conLocFirst" id="conLocFirst">
												<option value="">--------Select---------</option>
												<option value="1">Yes</option> 
												<option value="0">No</option> 
											</select>
										</td-->
										<!--text field "Tally Sheet Number" begins-->
										<!--td>
											<input size="5" type="text" value="<?php if($numrowfltAll==0) echo ''; else echo $tally_sheet_no;?>" name="tallysheet<?php echo $i;?>" readonly="true"/>
										</td-->
										<!--text field "Tally Sheet Number" ends-->
										<!--old marksstate combo
										<td>
											<select name="markstate">
												<option value="">-Select-</option>
												<option value="Wrong">Wrong Mark</option>
												<option value="Nill">Nill Mark</option>
											</select> 
										</td>
										-->
										
										
										<!--combo box "Markstate begins"-->
										<!--td>
											<?php 
												$value = 0;
												$valueNillMark=0;
												$marks_state="SELECT COUNT(*) AS cnt FROM shed_tally_info WHERE igm_sup_detail_id='$supDtlId' AND marks_state='wrong'";
												
												$res = mysql_query($marks_state);
												$rowVal = mysql_fetch_object($res);
												$value=$rowVal->cnt;
												
												$strNillMark="SELECT COUNT(*) AS cnt FROM shed_tally_info WHERE igm_sup_detail_id='$supDtlId' AND marks_state='Nill'";
												
												$resNillMark = mysql_query($strNillMark);
												$rowValNillMark = mysql_fetch_object($resNillMark);
												$valueNillMark=$rowValNillMark->cnt;
											
											?>
											<select name="markstate" <?php if($value>0 or $valueNillMark>0){ ?> disabled="true" <?php } ?>>
												<option value="">-Select-</option>
												<option value="Nill" <?php if($valueNillMark>0){?> selected="true"<?php }?>>Physical Mark</option>
												<option value="Wrong" <?php if($value > 0){?> selected="true" <?php }?>>Actual Mark</option>
											</select> 
										</td-->
										<!--combo box "Markstate ends"-->
										<!--combo box "Shift Name" begins-->
										<td>
											<select name="shiftname<?php echo $i;?>">												
												<option value="day">Day</option>
												<option value="night">Night</option>
											</select> 
										</td>
										<!--combo box "Shift Name" ends-->
										<!--text area "Actual Marks" begins-->
										<td>
											<textarea cols="12" rows="5" name="actualmarks<?php echo $i;?>" style="resize:none;"></textarea>
										</td>
										<!--text area "Actual Marks" ends-->
										<!--td>
											<font>Max 250 character</font><br/>
											<input type="text" name="remark"/>
										</td-->
										<!--td>
											<input type="submit" value="Save"/>
										</td-->
										

										
									</tr>
									<?php
								}
							?>
						
					</table>
				</td>
			</tr>
			<tr bgcolor="#2E9AFE">
				<td align="center">
					<table>
						<tr>
							
							<td id="btnTr">
								<input type="hidden" value="<?php echo count($rtnContainerList)+$equal;?>"  name="tblRow" style="width:80px">
								<?php if($save_btn_status=="1")
								{?>
									<input  style="display:inline" id="SaveBtn" type="submit" value="Save"/>	
								<?php } ?>
								<?php if($update_btn_status=="1")
								{?>
									<input style="display:inline" id="UpdateBtn" type="submit" value="Update"/>	
								<?php } ?>
								</form>								
							</td>							
							<td id="btnTr1">
								<?php if($view_btn_status=="1")
								{?>
									
									<form style="display:inline" action="<?php echo site_url('ShedBillController/tallyReportPdf/'.str_replace("/","_",$rotation).'/'.str_replace("/","_",$cont))?>" target="_blank" method="POST">
										<input id="VwBtn" type="submit" value="View"/>
									</form>
								<?php }?>
							</td>
							<td id="btnTr2">
								<?php if($exchange_btn_status=="1")
								{?>
									<input  type="button" id="ExBtn" value="Exchange Done" onclick="exchangeDone()"/>									
								<?php }
								else{?>
									
									<?php
									echo $msgExchange;?>
									
								<?php }?>
							</td>
							<?php if($view_btn_status=="1" && $exchange_btn_status=="0")
								{?>
								<td id="btnTr3">
								<div>
									<a class="button" href="#popup1"  onclick="txttransfer()"><font color="white">Upload Signature</font></a>
								</div>
								</td>
								
								<?php }?>
							<!--td>
								<?php if($view_btn_status=="1" && $exchange_btn_status=="0")
								{?>
								<div >
									<a class="button" href="#popup1"  onclick="txttransfer()"><font color="white">Upload Signature</font></a>
								</div>
								<?php }?>
							</td-->
							<!--td>
								<input  type="button" id="addRow" value="Add Row" onclick="addRowToTbl()"/>	
							</td-->
						</tr>
						<tr id="btnSig">
							
						</tr>
					
					</table>
				</td>
				
			</tr>
		</table>
		<div id="popup1" class="overlay">
		<div class="popup">
			
			<?php  
				include("popUpSignature.php") ;
				//include("popUpSignatureNew.php") ;
			?>
			
			</div>
			
		</div>	
	</body>
</html>