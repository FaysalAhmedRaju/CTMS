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
					<h3><font color="white">Delivery Order Entry Form for<?php echo " Rotation: <font color='#1C0204'>".$rotation."</font> and Container: <font color='#1C0204'>".$cont."</font>";?></font></h3>
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
							<th>Import Rotation</th>
							<th>BL No.</th>							
							<th>Marks & Number</th>							
							<th>Package Unit</th>
							<th>Package Quantity</th>
							<th>Package Receive</th>
							<th>Package Fault</th>
							<th>Package Delivery</th>
							<th>Location in Shed</th>
							<th>Remarks</th>
							<th>Action</th>
						</tr>
						
							<?php
								include_once("mydbPConnection.php");
								for($i=0;$i<count($rtnContainerList);$i++) { 
									?>
									<tr bgcolor="#A9D0F5">
										<td>
											<?php echo $rtnContainerList[$i]['import_rotation']?>
										</td>
										<td>
											<?php echo $rtnContainerList[$i]['BL_No']?>
										</td>										
										<td width="200">
											<?php echo $rtnContainerList[$i]['Pack_Marks_Number']?>
										</td>										
										<td>
											<?php echo $rtnContainerList[$i]['Pack_Description']?>
										</td>
										<td>
											<?php echo $rtnContainerList[$i]['Pack_Number']?>
										</td>
										<td width="200">
											<?php echo $rtnContainerList[$i]['rcv_pack']?>
										</td>
										<td width="200">
											<?php echo $rtnContainerList[$i]['flt_pack']?>
										</td>
										<form action="<?php echo site_url('report/updateDOInfo');?>" method="post">
										<input type="hidden" value="<?php echo $rtnContainerList[$i]['id']?>"  name="dtlId" style="width:80px">
										<input type="hidden" value="<?php echo $rtnContainerList[$i]['import_rotation']?>"  name="rot" style="width:80px">
										<input type="hidden" value="<?php echo $rtnContainerList[$i]['cont_number']?>"  name="cont" style="width:80px">
										<input type="hidden" value="<?php echo $tbl?>"  name="tbl" style="width:80px">
										<td align="center">
											<?php
												$supDtlId = $rtnContainerList[$i]['id'];
												$strrcv = "";
												if($tbl=="sup_detail")
													$strrcv = "select sum(delv_pack) as delv_pack from do_information where igm_sup_detail_id='$supDtlId'";
												else
													$strrcv = "select sum(delv_pack) as delv_pack from do_information where igm_detail_id='$supDtlId'";
												$resrcv = mysql_query($strrcv);
												$rowrcv = mysql_fetch_object($resrcv);
												
												$strrcvAll = "";
												if($tbl=="sup_detail")
													$strrcvAll = "select delv_pack from do_information where igm_sup_detail_id='$supDtlId'";
												else
													$strrcvAll = "select delv_pack from do_information where igm_detail_id='$supDtlId'";
												$resrcvAll = mysql_query($strrcvAll);
												$numrowrcvAll = mysql_num_rows($resrcvAll);
												$strAllRcv = "";
												$rcv=0;
												while($rowrcvAll=mysql_fetch_object($resrcvAll))
												{
													$rcv++;
													//echo $rcv."<".$numrowrcv."<br>";
													if($rcv<$numrowrcvAll)
														$strAllRcv = $strAllRcv.$rowrcvAll->delv_pack." + ";
													else
														$strAllRcv = $strAllRcv.$rowrcvAll->delv_pack." =";
												}
												//echo $i."<br>";
												echo $strAllRcv;
											?>
											<input type="text" name="dlvpre" value="<?php if($numrowrcvAll==0) echo '0.0'; else echo $rowrcv->delv_pack;?>" readonly="true" style="background-color:#D8D8D8;"/><br/>
											<font size="5"><b>+</b></font><br/>
											<input type="text" name="dlv"/>
										</td>
										<td>
											<input type="text" name="loc"/>
										</td>
										<td>
											<font>Max 250 character</font><br/>
											<input type="text" name="remark"/>
										</td>
										<td>
											<input type="submit" <?php if($rowrcv->delv_pack >=$rtnContainerList[$i]['rcv_pack']){?> disabled="true" <?php } ?> value="Save"/>
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