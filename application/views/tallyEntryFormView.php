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
							//document.getElementById("btnTr").innerHTML = "";
							//document.getElementById("btnTr2").innerHTML = "";
							
							//document.getElementById("btnTr1").colSpan="4";

							alert("Exchange Done.");
							deleteLastrow();
							$("#exBtn").remove();
							$("#tblInner tbody tr").find("td:eq(9)").remove();
							//document.getElementById("vwBtn").style.width = "300px"; 
							document.getElementById('excngeData').innerHTML = 
							"<table><tr><td>Exchange Done.</td><td><a class='button' href='#popup1'  onclick='txttransfer()'><font color='white'>Upload Signature</font></a></td></tr></table>";
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
				var answer = confirm("Are you want to delete tally?");
				if (answer) {
							return true;
							}
							else {
								return false;
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
	
	
		</script>
	</head>
	<body>
	<!--form action="<?php echo site_url('report/saveTallyRcv');?>" method="post" target="blank" onsubmit=""-->
	<!--form action="<?php echo site_url('report/updateTallyInfo');?>" method="post" onsubmit="return validateField()"-->
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
					<h3><font color="white">Tally Entry Form for<?php echo " Rotation: <font color='#1C0204'>".$rotation."</font> and Container: <font color='#1C0204'>".strtoupper($cont)."</font>";?></font>			
					<font color="red"><b>Unstuffing Date</b></font> :  
					<input size="10" type="text" id="wrDate" name="wrDate" value="<?php if($numrowDt==0) echo ""; else echo $rowrcv->wr_date;?>" />
					<input size="10" type="hidden" id="maxTallyNo" name="maxTallyNo" value="<?php if($numrowDt==0) echo ""; else echo $rowrcv->tally_sheet_no;?>" />
					<input  type="hidden" id="rotNumTransfer" name="rotNumTransfer" value="<?php echo $rotation;?>" />
					<input  type="hidden" id="contNumTransfer" name="contNumTransfer" value="<?php echo $cont;?>" />
					<input  type="hidden" id="userTransfer" name="userTransfer" value="<?php echo $login_id;?>" />
					
					<font color="green"><b>Tally Sheet Number</b></font> : <input class="" size="15" type="text" id="tallySheetNumber" name="tallySheetNumber" value="<?php if($numrowDt==0) echo ""; else echo $rowrcv->tally_sheet_number;?>" readonly="true"/>
					<br>
					<font color='white'>Vessel Name:</font> <?php echo $rslt_vesselname_seal[0]['Vessel_Name']?>
					<font color='white'>Seal No:</font> <?php echo $rslt_vesselname_seal[0]['cont_seal_number']?>
					<font color='white'>Size:</font> <?php echo $rslt_vesselname_seal[0]['cont_size']?>
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
					
					<table id="myTbl" width="100%" border="0" align="center" cellspacing="1" cellpadding="1">
						
						<tr bgcolor="#58ACFA">
							<td align="center">SL.</td>
							<!--td rowspan="2">Import Rotation</td>
							<td rowspan="2">Master BL</td-->
							<td align="center">BL No.</td>
							
							<td align="center">Marks & Number</td>
							
							<!--td rowspan="2">Consignee Description</td-->
							
							
							<td align="center">G.Weight</td>
							<td align="center">Pkg Unit</td>
							<td align="center"><nobr>Pkg Qty</nobr></td>
							<td align="center">Input Fields</td>
							<!--td style="display:none" rowspan="2">Unstuff Date</td-->
							<!--td align="center" colspan="5">Pack Rcv</td-->
							
							<!--td>Location in Shed</td-->
							<!--td rowspan="2">Bay No</td-->
							<!--td>Loc First</td-->
							<!--td rowspan="2">Tally Sheet Number</td-->
							<!--td rowspan="2">Physical<br>Marks</td-->
							<!--td rowspan="2">Shift Name</td>
							<td rowspan="2">Physical Marks</td>
							<td rowspan="2">Remarks</td-->
							<!--td rowspan="2">Seal Number</td>
							<td rowspan="2">Description<br>of Goods</td>
							<td rowspan="2">Cont Size</td>
							<td rowspan="2">Notify Description</td-->
							<!--td rowspan="2">Remarks</td-->
							<!--td rowspan="2">Action</td>
							<td rowspan="2">Report</td-->
						</tr>
						<!--tr bgcolor="#58ACFA">
										<td>IWH</td>
										<td>Loc Fast</td>
										<td>Ship Survey</td>
										<td>Total</td>
										<td>Rcv Unit</td>
						</tr-->
						
							<?php
								include_once("mydbPConnection.php");
								for($i=0; $i< count($rtnContainerList)+1;$i++) { 
								//echo "After Loop : ".count($rtnContainerList)+1;
									?>
								
									<tr bgcolor="#A9D0F5">
										<td>
											<?php echo $i+1;?>
										</td>
											
										<!--td>
											<?php echo "<font size='2'>".$rtnContainerList[$i]['Import_Rotation_No']."</font>"?>
										</td-->
										<!--td>
											<?php echo "<font size='2'>".$rtnContainerList[$i]['master_BL_No']."</font>"?>
										</td-->
										<td>
											<?php echo "<font size='2'>".$rtnContainerList[$i]['BL_No']."</font>"?>
										</td>				
										
										<td width="100">
											<?php 
											$strMarks = "select distinct(actual_marks) as actual_marks from shed_tally_info 
											where igm_sup_detail_id='".$rtnContainerList[$i]['id']."'";
											$resMarks = mysql_query($strMarks);
											$rowMarks = mysql_fetch_object($resMarks);
											//echo "".$strMarks;
										?>
										<?php if($rowMarks->actual_marks!="" or $rowMarks->actual_marks!=null) echo $rowMarks->actual_marks; else echo "<font size='2'>".substr($rtnContainerList[$i]['Pack_Marks_Number'], 0, 50)."</font>";?>
											<?php //echo "<font size='2'>".substr($rtnContainerList[$i]['Pack_Marks_Number'], 0, 20)."</font>"?>
											
										</td>
										
										<!--td width="200">
											<?php echo "<font size='2'>".$rtnContainerList[$i]['ConsigneeDesc']."</font>"?>
										</td-->
										
										
										<td>
											<?php echo $rtnContainerList[$i]['Cont_gross_weight']?>
										</td>
										<td>
											<?php echo $rtnContainerList[$i]['Pack_Description']?>
										</td>
										<td>
											<?php echo $rtnContainerList[$i]['Pack_Number']?>
										</td>
															
										<td>
											<table id="tblInner" border="0" cellpadding="1" cellspacing="2" bgcolor="#fff" style="width:100%;">
												<tr align="center" bgcolor="#7fb3d5 ">
													<td  colspan="2"><nobr>Good Condition</nobr></td>
													<td  colspan="2"><nobr>Ship Survey</nobr></td>
													<td  rowspan="2">Total</td>
													<td rowspan="2"><nobr>Rcv Unit</nobr></td>
													<td rowspan="2">Bay No</td>
													<td rowspan="2"><nobr>Shift Name</nobr></td>
													<td width=150 rowspan="2">Physical Marks</td>
													<td width=150 rowspan="2">Remarks</td>
													<?php if($save_btn_status=="1") { ?><td class="actionTd" rowspan="2">Action</td><?php } ?>
													<td align="center" colspan="7"><nobr></nobr></td>
													
												</tr>
												<tr align="center" bgcolor="#7fb3d5 ">
													<td>IWH</td>
													<td>L/Fast</td>
													<td>IWH</td>
													<td>L/Fast</td>
													<!--td><nobr>Ship Survey</nobr></td-->
													
													
												</tr>
												<!--For loop start -->
												<?php
												$supDtlId = $rtnContainerList[$i]['id'];
												$strrcv = "";
												if($tbl=="sup_detail")
													$strrcv = "select * from shed_tally_info where igm_sup_detail_id='$supDtlId'";
												else
													$strrcv = "select * from shed_tally_info where igm_detail_id='$supDtlId'";
													$resrcv = mysql_query($strrcv);
												while($rowrcv = mysql_fetch_object($resrcv))
												{
												?>
												<tr align="center" bgcolor="#a9cce3">
													<td><?php echo $rowrcv->rcv_pack;?></td>
													<td><?php echo $rowrcv->loc_first;?></td>
													<td><?php echo $rowrcv->flt_pack;?></td>
													<td><?php echo $rowrcv->flt_pack_loc;?></td>
													<td><?php echo $rowrcv->total_pack;?></td>
													<td><?php echo $rowrcv->rcv_unit;?></td>
													<td><?php echo $rowrcv->shed_loc;?></td>
													<td><?php echo $rowrcv->shift_name;?></td>
													<td width=150><font size="1"><?php echo substr($rowrcv->actual_marks, 0, 20);?></font></td>
													<td width=150><font size="1"><?php echo substr($rowrcv->remarks, 0, 20);?></font></td>
													<?php if($rowrcv->exchange_done_status!="1") {?><td class="actionTd"><a href="<?php echo site_url('report/deleteTallyRcv/'.$rowrcv->id."/".$rowrcv->cont_number."/".str_replace("/","_",$rowrcv->import_rotation)."/".$tbl);?>" onclick="return confirm('Are you sure you want to delete Tally?');">Delete</a></td><?php }?>
												</tr>
												<?php } ?>
												<!--While loop end-->
												<tr align="center" bgcolor="#a9cce3">
												<form action="<?php echo site_url('report/saveTallyRcv');?>" method="post" onsubmit="">
													<td>
														<input class="chkValidation" size="5" type="text" id="rcv<?php echo $i;?>" name="rcv" value="<?php if($numrowrcvAll==0) echo '0.0'; else echo '0.0';?>" onfocus="if(this.value=='0.0') this.value=''" onblur="if(this.value=='') this.value='0.0'"/>
														<script>
															$('#rcv<?php echo $i;?>').keyup(function() {
																//alert("jfkg");
																
																var tot= parseFloat($("#rcv<?php echo $i;?>").val())+parseFloat($("#conLocFast<?php echo $i;?>").val());
																$("#totalPck<?php echo $i;?>").val(tot);
															});	
															$('#rcv<?php echo $i;?>').blur(function() {
																//alert("jfkg");
																
																var tot= parseFloat($("#rcv<?php echo $i;?>").val())+parseFloat($("#conLocFast<?php echo $i;?>").val());
																$("#totalPck<?php echo $i;?>").val(tot);
															});	
														</script>
													</td>
													<td>
														<input class="chkValidation" size="5" type="text" id="conLocFast<?php echo $i;?>" name="conLocFast" value="<?php if($numrowrcvAll==0) echo '0.0'; else echo '0.0';?>" onfocus="if(this.value=='0.0') this.value=''" onblur="if(this.value=='') this.value='0.0'"/>
														<script>
															$('#conLocFast<?php echo $i;?>').keyup(function() {
															
															var tot= parseFloat($("#conLocFast<?php echo $i;?>").val())+ parseFloat($("#rcv<?php echo $i;?>").val());
															$("#totalPck<?php echo $i;?>").val(tot);
															});	
															$('#conLocFast<?php echo $i;?>').blur(function() {
															
															var tot= parseFloat($("#conLocFast<?php echo $i;?>").val())+ parseFloat($("#rcv<?php echo $i;?>").val());
															$("#totalPck<?php echo $i;?>").val(tot);
															});	
															
														</script>
													</td>
														<td>
														<input class="chkValidation" size="5" type="text" id="flt<?php echo $i;?>" name="flt" value="<?php if($numrowfltAll==0) echo '0.0'; else echo '0.0';?>" onfocus="if(this.value=='0.0') this.value=''" onblur="if(this.value=='') this.value='0.0'"/>
														<script>
															$('#flt<?php echo $i;?>').keyup(function() {
															
															var tot= parseFloat($("#flt<?php echo $i;?>").val())+ parseFloat($("#rcv<?php echo $i;?>").val()) + parseFloat($("#conLocFast<?php echo $i;?>").val());
															$("#totalPck<?php echo $i;?>").val(tot);
															});	
															$('#flt<?php echo $i;?>').blur(function() {
															
															var tot= parseFloat($("#flt<?php echo $i;?>").val())+ parseFloat($("#rcv<?php echo $i;?>").val()) + parseFloat($("#conLocFast<?php echo $i;?>").val());
															$("#totalPck<?php echo $i;?>").val(tot);
															});	
															
														</script>
													</td>
													<td>
														<input class="chkValidation" size="5" type="text" id="flt_pack_loc<?php echo $i;?>" name="flt_pack_loc" value="<?php if($numrowfltAll==0) echo '0.0'; else echo '0.0';?>" onfocus="if(this.value=='0.0') this.value=''" onblur="if(this.value=='') this.value='0.0'"/>
														<script>
															$('#flt_pack_loc<?php echo $i;?>').keyup(function() {
															
															var tot= parseFloat($("#flt_pack_loc<?php echo $i;?>").val())+ parseFloat($("#rcv<?php echo $i;?>").val()) + parseFloat($("#conLocFast<?php echo $i;?>").val())+ parseFloat($("#flt<?php echo $i;?>").val());
															$("#totalPck<?php echo $i;?>").val(tot);
															});	
															$('#flt_pack_loc<?php echo $i;?>').blur(function() {
															
															var tot= parseFloat($("#flt_pack_loc<?php echo $i;?>").val())+ parseFloat($("#rcv<?php echo $i;?>").val()) + parseFloat($("#conLocFast<?php echo $i;?>").val()) + parseFloat($("#flt<?php echo $i;?>").val());
															$("#totalPck<?php echo $i;?>").val(tot);
															});	
															
														</script>
													</td>
													<!--td>
														<input class="chkValidation" size="5" type="text" id="flt" name="flt" value="<?php if($numrowfltAll==0) echo '0.0'; else echo '0.0';?>" onfocus="if(this.value=='0.0') this.value=''" onblur="if(this.value=='') this.value='0.0'"/>
													</td>
													<td>
														<input class="chkValidation" size="5" type="text" id="flt_pack_loc" name="flt_pack_loc" value="<?php if($numrowfltAll==0) echo '0.0'; else echo '0.0';?>" onfocus="if(this.value=='0.0') this.value=''" onblur="if(this.value=='') this.value='0.0'"/>
													</td-->
													<td>
														<input class="chkValidation" size="5" type="text" id="totalPck<?php echo $i;?>" name="totalPck" value="<?php if($numrowrcvAll==0) echo '0.0'; else echo '0.0';?>" readonly="true"/>													
													</td>
													<td>
														<input class="chkValidation" type="search" size="5" value="<?php echo $RcvUnit;?>" list="rcvUnit" placeholder="Pick Unit" name="rcv_unit">
														<datalist id="rcvUnit" >
														<?php				
															$supDtlId = $rtnContainerList[$i]['id'];
															$strrcvAll = "";
																$strrcvAllQry = "select Pack_Unit as Pack_Description from igm_pack_unit";
																
																$resrcvAllT = mysql_query($strrcvAllQry);
																		
																while($rowrcvAllQry=mysql_fetch_object($resrcvAllT))
																{
																	echo '<option selected="selected" value="'.$rowrcvAllQry->Pack_Description.'">'.$rowrcvAllQry->Pack_Description.'</option>';													
																}
															echo $strAllRcv."<br>";
														?>
														</datalist>
													</td>
													<td>
														<input size="5" type="text" value="" name="contAtShed"/>
													</td>
													<td>
														<select name="shiftname">												
															<option value="day">Day</option>
															<option value="night">Night</option>
														</select> 
													</td>
													<td>
														<textarea cols="13" rows="2" name="actualmarks" style="resize:none;"></textarea>
													</td>
													<td>
														<textarea cols="13" rows="2" name="remark" style="resize:none;"></textarea>
														<!--input type="text" name="remark<?php echo $i; ?>" value="<?php if($rowremarks==0) echo ""; else echo $remarks; ?>"/-->
													</td>
													<?php if($save_btn_status=="1") {?><td>
														<input  style="display:inline" id="SaveBtn" type="submit" value="Save"/>							
														<!--a href="<?php echo site_url('report/saveTallyRcv/'.$rtnContainerList[$i]['id']);?>">Save</a-->								
													</td><?php }?>
												</tr>
												<input type="hidden" value="<?php echo $rtnContainerList[$i]['id']?>"  name="dtlId" style="width:80px">
												<input type="hidden" value="<?php echo $rotation?>" id="rot"  name="rot" style="width:80px">
												<input type="hidden" value="<?php echo $cont?>"  id="cont" name="cont" style="width:80px"> 
												<input type="hidden" value="<?php echo $tbl?>"  name="tbl" style="width:80px">					
											</form>
											</table>
										</td>										
										
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
							
							<!--td id="btnTr">
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
							</td-->							
							<td>
								<table>
									<tr>
										<td id="btnTr1">
											<?php if($view_btn_status=="1")
											{?>
												<form style="display:inline" action="<?php echo site_url('ShedBillController/tallyReportPdf/'.str_replace("/","_",$rotation).'/'.str_replace("/","_",$cont))?>" target="_blank" method="POST">
													<input id="VwBtn" type="submit" value="View"/>
												</form>
												<!--form style="display:inline" action="<?php echo site_url('ShedBillController/tallyReportPdf/'.str_replace("/","_",$rotation).'/'.str_replace("/","_",$cont))?>" target="_blank" method="POST">
													<input id="VwBtn" type="submit" value="View"/>
												</form-->
											<?php }?>
										</td>
										<td id="excngeData">
										</td>
									</tr>
								</table>
								<?php if($view_btn_status=="1")
								{?>
									<!--form style="display:inline" action="<?php echo site_url('ShedBillController/tallyReportPdf/'.str_replace("/","_",$rotation).'/'.str_replace("/","_",$cont))?>" target="_blank" method="POST">
										<input id="VwBtn" type="submit" value="View"/>
									</form-->
									<!--form style="display:inline" action="<?php echo site_url('ShedBillController/tallyReportPdf/'.str_replace("/","_",$rotation).'/'.str_replace("/","_",$cont))?>" target="_blank" method="POST">
										<input id="VwBtn" type="submit" value="View"/>
									</form-->
								<?php }?>
							</td>
							<td id="btnTr2"> 
								<?php if($exchange_btn_status=="1")
								{?>
									<input id="exBtn"  type="button" id="ExBtn" value="Exchange Done" onclick="exchangeDone()"/>									
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
						<tr id="btnSig" align="right">
							
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