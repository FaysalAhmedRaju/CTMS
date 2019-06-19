<html>
	<head>
		<title>Tally Report</title>
		<style>
			 table {border-collapse: collapse;}
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
							<td width="">
								Name of vessel : <?php echo $rtntallyreport[0]['Vessel_Name'];?>
							</td>
							<td>
								Rot No : <?php echo $rotation;?>
							</td>
							<td>
								<!--div style="border:1px solid black; width:250px">Tally Sheet No: <b><?php echo $section."-".$rtntallyreport[0]['tls_no'];?></b></div-->
								<div style="border:1px solid black; width:250px">Tally Sheet No: <b><?php echo $rtntallyreport[0]['tally_sheet_number'];?></b></div>
							</td>
						</tr>
						<tr>
							<td>
								Name of Shipping Agent :
							</td>
							<td>
								Jetty/Shed No : <?php echo $section;?>
							</td>
						</tr>
						<tr>
							<td>
								Name of Shore Handling Contractor : <?php $rsltBerth[0]['rtnValue']?>
							</td>
							<td>
								
							</td>
							<td>
								Arrival Date : <?php ?>
							</td>
						</tr>
						<tr>
							<td>
								C&F Agent : <?php echo $rtntallyreport[0]['Notify_name'];?>
							</td>
							<td>
								Size: <?php echo $rtntallyreport[0]['cont_size'];?>
							</td>
							<td>
								Shift/Date : <?php echo $rtntallyreport[0]['shift_name'];?>
							</td>
						</tr>
						<tr>
							<td>
								Container No : <?php echo $container?>
							</td>
							<td>
								
							</td>
							<td>
								Status : FCL/LCL <?php ?>
							</td>
						</tr>
						<tr>
							<td>
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
							//	include_once("mydbPConnection.php");
								for($i=0;$i<count($rtntallyreport);$i++) { 
									?>
									<tr>
										<td align="center">
											<?php echo $i+1;?>
										</td>
										<td align="center">
											<?php echo substr($rtntallyreport[$i]['Pack_Marks_Number'], 0, 50)?>
										</td>										
										<td align="center">
											<?php echo substr($rtntallyreport[$i]['Description_of_Goods'], 0, 50);?>
										</td>
										<td align="center">
											<?php echo ($rtntallyreport[$i]['rcv_pack']+$rtntallyreport[$i]['loc_first'])?>
										</td>	
										<td align="center">
											<?php echo $rtntallyreport[$i]['flt_pack']?>
										</td>
										<td align="center">
											<?php echo $rtntallyreport[$i]['shed_loc']?>
										</td>	
										<td align="center">
											<?php echo $rtntallyreport[$i]['totPkg']?>
										</td>	
										<td align="center">
											
										</td>
									</tr>
									<?php
								}
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