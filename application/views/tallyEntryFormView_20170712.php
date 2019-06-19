<html>
	<head>
		<title>Chittagong Port Authority</title>
	</head>
	<body>
		<table width="100%" cellpadding="0">
			<tr bgcolor="#273076" height="100px">
				<td align="center" valign="middle">
					<h1><font color="white">Chittagong Port Authority</font></h1>
				</td>
			</tr>
			<tr bgcolor="#2E9AFE">
				<td align="left" valign="middle" style="padding-top:10px;padding-left:20px;">
					<h3><font color="white">Tally Entry Form for<?php echo " Rotation: <font color='#1C0204'>".$rotation."</font> and Container: <font color='#1C0204'>".$cont."</font>";?></font></h3>
				</td>
			</tr>
			<tr>
				<td align="left" valign="middle">
					<h3><?php echo $stat;?></h3>
				</td>
			</tr>
			<tr>
				<td>
					<table border="0" align="center" cellspacing="1" cellpadding="1">
						<tr bgcolor="#58ACFA">
							<th>SL.</th>
							<th>Import Rotation</th>
							<th>BL No.</th>
							<th>Seal Number</th>
							<th>Marks & Number</th>
							<th>Consignee Description</th>
							<th>Notify Description</th>
							<th>Container Size</th>
							<th>Container Gross Weight</th>
							<th>Package Unit</th>
							<th>Package Quantity</th>
							<th>Package Receive</th>
							<th>Package Fault</th>
							<th>Location in Shed</th>
							<th>Tally Sheet Number</th>
							<th>Marks State</th>
							<th>Shift Name</th>
							<th>Actual Marks</th>
							<th>Remarks</th>
							<th>Action</th>
						</tr>
						
							<?php
								include_once("mydbPConnection.php");
								for($i=0;$i<count($rtnContainerList);$i++) { 
									?>
									<tr bgcolor="#A9D0F5">
										<td>
											<?php echo $i+1;?>
										</td>
										<td>
											<?php echo $rtnContainerList[$i]['Import_Rotation_No']?>
										</td>
										<td>
											<?php echo $rtnContainerList[$i]['BL_No']?>
										</td>				
										<td>
											<?php echo $rtnContainerList[$i]['cont_seal_number']?>
										</td>
										<td width="200">
											<?php echo $rtnContainerList[$i]['Pack_Marks_Number']?>
										</td>
										<td width="200">
											<?php echo $rtnContainerList[$i]['ConsigneeDesc']?>
										</td>
										<td width="200">
											<?php echo $rtnContainerList[$i]['NotifyDesc']?>
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
										<form action="<?php echo site_url('report/updateTallyInfo');?>" method="post">
										<input type="hidden" value="<?php echo $rtnContainerList[$i]['id']?>"  name="dtlId" style="width:80px">
										<input type="hidden" value="<?php echo $rtnContainerList[$i]['Import_Rotation_No']?>"  name="rot" style="width:80px">
										<input type="hidden" value="<?php echo $rtnContainerList[$i]['cont_number']?>"  name="cont" style="width:80px">
										<input type="hidden" value="<?php echo $tbl?>"  name="tbl" style="width:80px">
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
												echo $strAllRcv;
											?>
											<input type="text" name="rcvpre" value="<?php if($numrowrcvAll==0) echo '0.0'; else echo $rowrcv->rcv_pack;?>" readonly="true" style="background-color:#D8D8D8;"/><br/>
											<font size="5"><b>+</b></font><br/>
											<input type="text" name="rcv"/>
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
													$strfltAll = "select flt_pack from shed_tally_info where igm_sup_detail_id='$supDtlId'";
												else
													$strfltAll = "select flt_pack from shed_tally_info where igm_detail_id='$supDtlId'";
												$resfltAll = mysql_query($strfltAll);
												$numrowfltAll = mysql_num_rows($resfltAll);
												$strAllFlt = "";
												$flt=0;
												while($rowfltAll=mysql_fetch_object($resfltAll))
												{
													$flt++;
													//echo $rcv."<".$numrowrcv."<br>";
													if($flt<$numrowfltAll)
														$strAllFlt = $strAllFlt.$rowfltAll->flt_pack." + ";
													else
														$strAllFlt = $strAllFlt.$rowfltAll->flt_pack." =";
												}
												//echo $i."<br>";
												echo $strAllFlt;
											?>
											<input type="text" name="fltpre" value="<?php if($numrowfltAll==0) echo '0.0'; else echo $rowflt->flt_pack;?>" readonly="true" style="background-color:#D8D8D8;"/><br/>
											<font size="5"><b>+</b></font><br/>
											<input type="text" name="flt"/>
										</td>
										<td>
											<input type="text" name="loc"/>
										</td>
										<!--text field "Tally Sheet Number" begins-->
										<td>
											<input type="text" name="tallysheet"/>
										</td>
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
										<td>
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
												<option value="Nill" <?php if($valueNillMark>0){?> selected="true"<?php }?>>Nill Mark</option>
												<option value="Wrong" <?php if($value > 0){?> selected="true" <?php }?>>Wrong Mark</option>
											</select> 
										</td>
										<!--combo box "Markstate ends"-->
										<!--combo box "Shift Name" begins-->
										<td>
											<select name="shiftname">
												<option value="">-Select-</option>
												<option value="day">Day</option>
												<option value="night">Night</option>
											</select> 
										</td>
										<!--combo box "Shift Name" ends-->
										<!--text area "Actual Marks" begins-->
										<td>
											<textarea cols="12" rows="5" name="actualmarks" style="resize:none;"></textarea>
										</td>
										<!--text area "Actual Marks" ends-->
										<td>
											<font>Max 250 character</font><br/>
											<input type="text" name="remark"/>
										</td>
										<td>
											<input type="submit" value="Save"/>
										</td>
										</form>
									</tr>
									<?php
								}
							?>
						
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>