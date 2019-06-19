<?php 
//echo "count : ".count($rtnCounter);
$total_1=0;
$total_2=0;
$total=0;
$counter=ceil(count($rtnCounter)/5);
for($j=0;$j<$counter;$j++)
{ 
?>
<html>
	<body>
	<?php if($j<$counter-1) {?>
		<div style="position: relative;PAGE-BREAK-AFTER: always;">
		<?php } else {?>
		<div style="position: relative;PAGE-BREAK-AFTER: avoid;">
		<?php }?>
		<table width="100%" cellpadding="0" border="0">
			<tr height="100px">
				<td align="center" valign="middle">
					<img src="<?php echo IMG_PATH;?>cpa.png">
					<h1 style="font-size:25px;">Chittagong Port Authority</h1>
					<h3 style="font-size:14px;">Unstuffing Tally of Container</h3>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%" border="0">
						<tr>
							<td width="35%" style="font-size:12px;">
								Vessel Name: <?php echo $rtninfo[0]['Vessel_Name'];?>
							</td>
							<td width="27%" style="font-size:12px;">
								Rot No : <?php echo $rotation;?>
							</td>
							<td width="37%" align="left" style="border:1px solid black;font-size:12px;" >
								<!--div style="border:1px solid black; width:250px">Tally Sheet No: <b><?php echo $section."-".$rtninfo[0]['tls_no'];?></b></div-->
								
								T.S.N.: <b><?php $subtsn = $j+1; echo $rtninfo[0]['tally_sheet_number']."-".$subtsn;?></b>
							</td>
						</tr>
						<tr>
							<td style="font-size:12px;">
								Shipping Agent : <?php echo $rtninfo[0]['mlocode'];?>
							</td>
							<td style="font-size:12px;">
								Jetty/Shed : <?php echo $section;?>
							</td>
							<td style="font-size:12px;">
								Arrival Date : <?php echo $rsltBerth[0]['ata']?>
							</td>
						</tr>
						<tr>
							<td style="font-size:12px;">
								Handling Contractor : <?php echo $rsltBerth[0]['berthOp']?>
							</td>
							<td style="font-size:12px;">
								Size: <?php echo $rtninfo[0]['cont_size'];?>
							</td>
							<td style="font-size:12px;">
								Shift/Date : <?php echo $rtninfo[0]['shift_name'];?>
							</td>
							<!--td>
								Arrival Date : <?php echo $rsltBerth[0]['ata']?>
							</td-->
						</tr>
						<tr>
							<!--td colspan="3" style="font-size:12px;">
								Freight Forwarder : <?php echo $rtninfo[1]['Notify_name'];?>
							</td-->
							<!--td>
								Size: <?php echo $rtninfo[0]['cont_size'];?>
							</td-->
							<!--td>
								Shift/Date : <?php echo $rtninfo[0]['shift_name'];?>
							</td-->
						</tr>
						<tr>
							<td style="font-size:12px;">
								Container No : <?php echo strtoupper($container);?>
							</td>
							<td style="font-size:12px;">
								Seal No : <?php echo $rtninfo[0]['cont_seal_number'];?>
							</td>
							<td style="font-size:12px;">
								Status : LCL <?php ?>
							</td>
						</tr>
						<!--tr>
							<td>
								Seal No : <?php echo $rtninfo[0]['cont_seal_number'];?>
							</td>
						</tr-->
						<tr>
							<td colspan="3" style="font-size:12px;">
								Remarks if any :
							</td>
						</tr>
						<tr>
							<td align="center" colspan="3" style="font-size:12px;">
								<p>(State of contents of the unstuffed pkgs unkown to CPA & CPA is not responsible for content)</p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table border="1" align="center" cellspacing="0" cellpadding="0" width="100%" style="font-size:11px">
						<tr>
							<th rowspan="2">Sl No.</th>
							<th rowspan="2">BL No</th>
							<th rowspan="2">Marks</th>							
							<th rowspan="2">Description</th>
							<th colspan="2">Good Condition</th>
							<th colspan="2">Broken Pkgs.<br>conditions and Nos.</th>
							<!--th rowspan="2">Broken Pkgs.<br>conditions and Nos.</th-->
							<th rowspan="2">Cargo Location</th>
							<th rowspan="2">Total No of Pkgs</th>
							<th rowspan="2">Rcv Unit</th>
							<th rowspan="2">Remarks</th>
						</tr>
						<tr>
							<th>W/R House</th>
							<th>Loc Fast</th>
							<th>W/R House</th>
							<th>Loc Fast</th>
						</tr>
						
							<?php
								include_once("mydbPConnection.php");
							//	for($i=0;$i<count($rtntallyreport);$i++) { 
							
							if($j==0)
								$init=0;
							else
								$init=$init+5;
								
							$sqltallyreport = "select * from (SELECT igm_supplimentary_detail.id,master_BL_No,Description_of_Goods,Import_Rotation_No,BL_No,cont_number,
												cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
												FROM igm_supplimentary_detail 
												LEFT JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id					
												WHERE Import_Rotation_No='$rotation' AND cont_number='$container'
												) tbl1
												union
												select * from (SELECT shed_tally_info.igm_sup_detail_id as id,master_BL_No,Description_of_Goods,import_rotation as Import_Rotation_No,BL_No,
												shed_tally_info.cont_number, cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,
												NotifyDesc FROM shed_tally_info 
												LEFT JOIN igm_supplimentary_detail ON shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id 
												LEFT JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id 
												WHERE shed_tally_info.import_rotation='$rotation' and shed_tally_info.cont_number='$container' and BL_NO is null
												)tbl2 LIMIT $init,5";
							//echo $sqltallyreport;
							$restallyreport = mysql_query($sqltallyreport);
						
							$i=1;
							//	for($i=0;$i<5;$i++) { 
							while($rtntallyreport=mysql_fetch_object($restallyreport)) { 
								$strrcv = "select sum(rcv_pack) as rcv_pack,sum(flt_pack) as flt_pack,sum(flt_pack_loc) as flt_pack_loc,sum(loc_first) as loc_first,sum(total_pack) as total_pack,rcv_unit,shed_loc,remarks from shed_tally_info 
											where igm_sup_detail_id='$rtntallyreport->id' group by rcv_unit,shed_loc
											order by id";
								$resrcv = mysql_query($strrcv);
								$totRow = mysql_num_rows($resrcv);
								
								$strrcv1 = "select sum(rcv_pack) as rcv_pack,sum(flt_pack) as flt_pack,sum(flt_pack_loc) as flt_pack_loc,sum(loc_first) as loc_first,sum(total_pack) as total_pack,rcv_unit,shed_loc,remarks from shed_tally_info 
											where igm_sup_detail_id='$rtntallyreport->id' group by rcv_unit,shed_loc
											order by id  limit 0,1";
								$resrcv1 = mysql_query($strrcv1);
							?>
								<tr>									
									<td align="center" <?php if($totRow>1) { ?>rowspan="<?php echo $totRow; ?>" <?php } ?>>
										<?php echo $i++;?>
									</td>
									<!--td align="center">
										<?php echo substr($rtntallyreport->Pack_Marks_Number, 0, 50);?>
									</td-->
									<td style="font-size:9px;" align="center" <?php if($totRow>1) { ?>rowspan="<?php echo $totRow; ?>" <?php } ?>>
										<?php echo $rtntallyreport->BL_No;?>
									</td>
									<td style="font-size:9px;" align="center" <?php if($totRow>1) { ?>rowspan="<?php echo $totRow; ?>" <?php } ?>>
										<?php 
											$strMarks = "select distinct(actual_marks) as actual_marks from shed_tally_info 
											where igm_sup_detail_id='$rtntallyreport->id'";
											$resMarks = mysql_query($strMarks);
											$rowMarks = mysql_fetch_object($resMarks);
										?>
										<?php if($rowMarks->actual_marks!="" or $rowMarks->actual_marks!=null) echo $rowMarks->actual_marks; else echo substr($rtntallyreport->Pack_Marks_Number, 0, 50);?>
									</td>											
									<td style="font-size:9px;" align="center" <?php if($totRow>1) { ?>rowspan="<?php echo $totRow; ?>" <?php } ?>>
										<?php echo substr($rtntallyreport->Description_of_Goods, 0, 30);?>
									</td> 
									<?php 
									$rowrcv1 = mysql_fetch_object($resrcv1);
									?>
										<td style="font-size:9px;" align="center">
											<?php echo $rowrcv1->rcv_pack;?>
										</td>
										<td style="font-size:9px;" align="center">
											<?php echo $rowrcv1->loc_first;?>
										</td>	
										<td style="font-size:9px;" align="center">
											<?php echo $rowrcv1->flt_pack;?>
										</td>
										<td style="font-size:9px;" align="center">
											<?php echo $rowrcv1->flt_pack_loc;?>
										</td>
										<td style="font-size:9px;" align="center">
											<?php 
											if ($rowrcv1->loc_first>0 && $rowrcv1->rcv_pack>0)
												echo "L/F, ".$rowrcv1->shed_loc; 
											else if($rowrcv1->loc_first>0 && $rowrcv1->rcv_pack==0)
												echo "L/F";
											else if($rowrcv1->loc_first==0 && $rowrcv1->rcv_pack>0)
												echo $rowrcv1->shed_loc;?>
										</td>	
										<td style="font-size:9px;" align="center">
											<?php echo $rowrcv1->total_pack;?>
										</td>
										<td style="font-size:9px;" align="center">
											<?php echo $rowrcv1->rcv_unit;?>
										</td>
										<td style="font-size:9px;" align="center">
											<?php echo $rowrcv1->remarks;?>
										</td>							
									<?php
									//}
									?>
								</tr>
								<?php 
								if($totRow>1)
								{
								$lim = $totRow-1;
								$strrcv2 = "select sum(rcv_pack) as rcv_pack,sum(flt_pack) as flt_pack,sum(flt_pack_loc) as flt_pack_loc,sum(loc_first) as loc_first,total_pack,rcv_unit,shed_loc,remarks from shed_tally_info 
											where igm_sup_detail_id='$rtntallyreport->id' group by rcv_unit,shed_loc
											order by id  limit 1,$lim";
								$resrcv2 = mysql_query($strrcv2);
								while($rowrcv2 = mysql_fetch_object($resrcv2)){
								?>
								<tr>
									<td style="font-size:9px;" align="center">
										<?php echo $rowrcv2->rcv_pack;?>
									</td>
									<td style="font-size:9px;" align="center">
										<?php echo $rowrcv2->loc_first;?>
									</td>	
									<td style="font-size:9px;" align="center">
										<?php echo $rowrcv2->flt_pack;?>
									</td>
									<td style="font-size:9px;" align="center">
											<?php echo $rowrcv1->flt_pack_loc;?>
									</td>
									<td style="font-size:9px;" align="center">
										<?php 
										if ($rowrcv2->loc_first>0 && $rowrcv2->rcv_pack>0)
											echo "L/F, ".$rowrcv2->shed_loc; 
										else if($rowrcv2->loc_first>0 && $rowrcv2->rcv_pack==0)
											echo "L/F";
										else if($rowrcv2->loc_first==0 && $rowrcv2->rcv_pack>0)
											echo $rowrcv2->shed_loc;?>
									</td>	
									<td style="font-size:9px;" align="center">
										<?php echo $rowrcv2->total_pack;?>
									</td>
									<td style="font-size:9px;" align="center">
										<?php echo $rowrcv2->rcv_unit;?>
									</td>
									<td style="font-size:9px;" align="center">
										<?php echo $rowrcv2->remarks;?>
									</td>
								</tr>								
								<?php
									$total_2=$total_2+$rowrcv2->total_pack;
								}
								}
								$total_1=$total_1+$rowrcv1->total_pack;
								?>
								
							<?php
							}
							//	$init=$init+5;
							if($j==$counter-1)
							{
							?>
							
								<tr>
									<td colspan="9"></td>
									<td align="center"><?php echo $total_1+$total_2;?></td>
									<td colspan="2"></td>
								</tr>
							<?php
							}
							?>
							
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%">
						<tr>
							<td>
								Berth Operator
							</td>
							<td>
								Freight Forwarder
							</td>
							<td>
								CPA
							</td>
						</tr>
						<tr>
							<td valign="middle">
								<table>
									<tr>
										<td>
											Signature :
										</td>
										<td>
											<img id="sig_security" src="<?php echo IMG_PATH.'Signature/'.$signature_path_berth; ?>" height=50 width=50 />
										</td>
									</tr>
								</table>
								 
							</td>
							<td>
								<table>
									<tr>
										<td>
											Signature :
										</td>
										<td>
											<img id="sig_security" src="<?php echo IMG_PATH.'Signature/'.$signature_path_freight; ?>" height=50 width=50 />
										</td>
									</tr>
								</table>
							</td>
							<td>
								<table>
									<tr>
										<td>
											Signature :
										</td>
										<td>
											<img id="sig_security" src="<?php echo IMG_PATH.'Signature/'.$signature_path_cpa; ?>" height=50 width=50 />
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>
								Name :
							</td>
							<td>
								N :
							</td>
							<td>
								N :
							</td>
						</tr>
						<tr>
							<td>
								Designation :
							</td>
							<td>
								D :
							</td>
							<td>
								D :
							</td>
						</tr>
						<tr>
							<td colspan="3">
							<table>
								<tr>
									<td>
										Tally Supervisor Signature: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                
									</td>
									<td>
										Name :  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                            
									</td>
									<td>
										Designation : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									</td>
								</tr>
							</table>
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<table>
									<tr>
										<td>
											Note: 
										</td>
										<td>
											1. For remarks
										</td>
									</tr>
									<tr>
										<td>
										</td>
										<td>
											(a) The type of defects of containers such as dented, outward damage, door defective etc.
										</td>
									</tr>
									<tr>
										<td>
										</td>
										<td>
											(b) The type of defects of lock and seal such as broken, missing etc, and mention of survey or any other action in this connection.
										</td>
									</tr>
									<tr>
										<td>
										</td>
										<td>
											(c) The type of Containers other than the usual General purpose Container such as flats, half heights open top etc. to be indicated as observed prior to opening of the containers for unstuffing.
										</td>
									</tr>
									<tr>
										<td>
										</td>
										<td>
											2. Proper remarks should be given for qualified packages and in case the contents of the pkgs, is suspected to be effected survey should be conducted with the Steamer Agent, no special cargo to be received with remarks but without survey.
										</td>
									</tr>
									<tr>
										<td>
										</td>
										<td>
											3. In case unstuffing is not complete then container is to be locked and sealed jointly with the Steamer Agent.
										</td>
									</tr>
								</table>	
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>	
		</div>
	</body>
</html>

<?php 
}
?>
