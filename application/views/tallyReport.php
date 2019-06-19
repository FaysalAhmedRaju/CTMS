<?php 
//echo count($rtntallyreport);
$counter=ceil(count($rtninfo)/5);
for($j=0;$j<$counter;$j++)
{ 
?>
<html>
	<head>
		<title>Tally Report</title>
		<style>
			 table {
					border-collapse: collapse;
					page-break-after: always;
				}
			 
			 body {
				height: 842px;
				width: 595px;
				/* to centre page on screen*/
				margin-left: auto;
				margin-right: auto;
			}
		</style>
	</head>
	<body>
		<table width="100%" cellpadding="0">
			<tr height="100px">
				<td align="center" valign="middle">
					<h1>Chittagong Port Authority</h1>
					<h3>Unstuffing Tally of Containers</h3>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%" border="0">
						<tr>
							<td width="35%">
								Vessel Name: <?php echo $rtninfo[0]['Vessel_Name'];?>
							</td>
							<td width="27%">
								Rot No : <?php echo $rotation;?>
							</td>
							<td width="37%" align="left" style="border:1px solid black;" >
								<!--div style="border:1px solid black; width:250px">Tally Sheet No: <b><?php echo $section."-".$rtninfo[0]['tls_no'];?></b></div-->
								T.S.N.: <b><?php $subtsn = $j+1; echo $rtninfo[0]['tally_sheet_number']."-".$subtsn;?></b>
							</td>
						</tr>
						<tr>
							<td>
								Shipping Agent : <?php echo $rtninfo[0]['mlocode'];?>
							</td>
							<td >
								Jetty/Shed : <?php echo $section;?>
							</td>
							<td>
								Arrival Date : <?php echo $rsltBerth[0]['ata']?>
							</td>
						</tr>
						<tr>
							<td>
								Handling Contractor : <?php echo $rsltBerth[0]['berthOp']?>
							</td>
							<td>
								Size: <?php echo $rtninfo[0]['cont_size'];?>
							</td>
							<td>
								Shift/Date : <?php echo $rtninfo[0]['shift_name'];?>
							</td>
							<!--td>
								Arrival Date : <?php echo $rsltBerth[0]['ata']?>
							</td-->
						</tr>
						<tr>
							<td colspan="3">
								Freight Forwarder : <font size="2"><?php echo $rtninfo[0]['Notify_name'];?></font>
							</td>
							<!--td>
								Size: <?php echo $rtninfo[0]['cont_size'];?>
							</td-->
							<!--td>
								Shift/Date : <?php echo $rtninfo[0]['shift_name'];?>
							</td-->
						</tr>
						<tr>
							<td>
								Container No : <?php echo $container?>
							</td>
							<td>
								Seal No : <?php echo $rtninfo[0]['cont_seal_number'];?>
							</td>
							<td>
								Status : FCL/LCL <?php ?>
							</td>
						</tr>
						<!--tr>
							<td>
								Seal No : <?php echo $rtninfo[0]['cont_seal_number'];?>
							</td>
						</tr-->
						<tr>
							<td colspan="3">
								Remarks if any :
							</td>
						</tr>
						<tr>
							<td align="center" colspan="3">
								<p>(State of contents of the unstuffed pkgs unkown to CPA & CPA is not responsible for content)</p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table border="1" align="center" cellspacing="1" cellpadding="1" width="100%" style="font-size:12px">
						<tr>
							<th>Sl No.</th>													
							<th>Marks</th>							
							<th>Description</th>
							<th>Good Condition</th>
							<th>Broken Pkgs.<br>conditions and Nos.</th>
							<th>Cargo Location</th>
							<th>Total No of Pkgs</th>
							<th>Remarks</th>
							
						</tr>
						
							<?php
								include_once("mydbPConnection.php");
							//	for($i=0;$i<count($rtntallyreport);$i++) { 
							

							if($j==0)
								$init=0;
							else
								$init=$init+5;
								
							$sqltallyreport = "SELECT id,Vessel_Name,Import_Rotation_No,cont_number,cont_seal_number,cont_size,tally_sheet_number,rcv_pack,loc_first,flt_pack,shed_loc,Line_No,Pack_Marks_Number,Description_of_Goods,Pack_Number,
							(SUM(rcv_pack)+IFNULL(loc_first,0)) AS totPkg,actual_marks,marks_state,
							(SELECT SUM(delv_pack) FROM do_information WHERE verify_no=tmp.verify_number) AS delv_pack,shift_name,Notify_name,mlocode,remarks
							FROM(SELECT igm_supplimentary_detail.id,igm_supplimentary_detail.Line_No,igm_supplimentary_detail.Import_Rotation_No,igm_sup_detail_container.cont_number,cont_seal_number,Vessel_Name,cont_size,igm_supplimentary_detail.Pack_Marks_Number,igm_supplimentary_detail.Description_of_Goods,igm_supplimentary_detail.Pack_Number,rcv_pack,loc_first,actual_marks,marks_state,shed_tally_info.verify_number,shed_tally_info.flt_pack,shed_loc,tally_sheet_number,shift_name,igm_supplimentary_detail.Notify_name,igm_details.mlocode,shed_tally_info.remarks
							FROM igm_supplimentary_detail 
							INNER JOIN igm_details ON igm_details.id=igm_supplimentary_detail.igm_detail_id
							INNER JOIN igm_masters ON igm_masters.id=igm_supplimentary_detail.igm_master_id
							INNER JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
							LEFT JOIN shed_tally_info ON shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
							WHERE igm_supplimentary_detail.Import_Rotation_No='$rotation' AND igm_sup_detail_container.cont_number='$container') AS tmp GROUP BY id LIMIT $init,5";
							
							$restallyreport = mysql_query($sqltallyreport);
						
							$i=1;
							//	for($i=0;$i<5;$i++) { 
							while($rtntallyreport=mysql_fetch_object($restallyreport)) { 
							?>
								<tr>
									<td align="center">
										<?php echo $i++;?>
									</td>
									<td align="center">
										<?php echo substr($rtntallyreport->Pack_Marks_Number, 0, 50);?>
									</td>										
									<td align="center">
										<?php echo substr($rtntallyreport->Description_of_Goods, 0, 30);?>
									</td>
									<td align="center">
										<?php echo ($rtntallyreport->rcv_pack+$rtntallyreport->loc_first);?>
									</td>	
									<td align="center">
										<?php echo $rtntallyreport->flt_pack;?>
									</td>
									<td align="center">
										<?php echo $rtntallyreport->shed_loc;?>
									</td>	
									<td align="center">
										<?php echo $rtntallyreport->totPkg;?>
									</td>
									<td align="center">
											
									</td>															
								</tr>
								<?php
							}
							//	$init=$init+5;
							?>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<br>
					<table width="100%">
						<tr>
							<td>
								Rep. of S/Agent
							</td>
							<td>
								CPA Tally Supervisor
							</td>
							<td>
								CPA Hatch Jr. AO.
							</td>
						</tr>
						<tr>
							<td>
								Signature :
							</td>
							<td>
								S :
							</td>
							<td>
								S :
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
								<br>
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
	</body>
</html>
<?php 
}
?>
