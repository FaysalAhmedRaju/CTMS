 <?php
	$con = mysql_connect("192.168.16.42","user1","user1test");
	mysql_select_db("cchaportdb",$con);
 ?>
<html>
<head>
		<title>Chittagong Port Authority</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
		<script type="text/javascript" src="http://192.168.16.43/myportpanel/resources/scripts/calender.jquery-ui.min.js"></script>
		<link rel="stylesheet" type="text/css" href="http://192.168.16.43/myportpanel/resources/styles/calender.jquery-ui.css">
	
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
					<h3><font color="white">Delivery Order Entry Form for<?php echo " Container: <font color='#1C0204'>".$container."</font> and Rotation: <font color='#1C0204'>".$rotation."</font>";?></font></h3>
				</td>
			</tr>
			<tr>
				<td align="left" valign="middle">
					<h3><?php echo $msg;?></h3>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%" border="1px" align="center" cellspacing="1" cellpadding="1">
						<thead>
							<tr bgcolor="#58ACFA">
								<td align="center">Line No</td>
								<td align="center">BL No</td>
								<td align="center">Pack Number</td>
								<td align="center">BE No</td>
								<td align="center">BE Date</td>
								<td align="center">Office Code</td>
								<td align="center">Action</td>			
							</tr>
						</thead>
							<tbody>
								
								<?php 
										for($i=0;$i<count($rtnSqlUpdateShedList);$i++){
											$dtlID=$rtnSqlUpdateShedList[$i]['id'];
											if($tblName=="Detail")
											{
												$strID = "select Bill_of_Entry_No,Bill_of_Entry_Date,office_code from cchaportdb.igm_details where id='$dtlID'";
											}
											else
											{
												$strID = "select Bill_of_Entry_No,Bill_of_Entry_Date,office_code from cchaportdb.igm_supplimentary_detail where id='$dtlID'";
												//echo $strID;
											}
											
											$resequip=mysql_query($strID,$con);
											$bEntryNo = "";
											$eDate = "";
											$offCode="";
											while($rowequip=mysql_fetch_object($resequip))
											{
												$bEntryNo= $rowequip->Bill_of_Entry_No;
												$eDate= $rowequip->Bill_of_Entry_Date;
												$offCode = $rowequip->office_code;
											}
										?>
									<tr>	
										<form action="<?php echo site_url('report/updateActionPerform');?>" method="POST">
										<td bgcolor="#A9D0F5" align="center"><?php echo $rtnSqlUpdateShedList[$i]['Line_No'];?></td>
										<td bgcolor="#A9D0F5" align="center"><?php echo $rtnSqlUpdateShedList[$i]['BL_No'];?></td>
										<td bgcolor="#A9D0F5" align="center"><?php echo $rtnSqlUpdateShedList[$i]['Pack_Number'];?></td>
										<td bgcolor="#A9D0F5" align="center"><input type="text" name="beNo" value="<?php echo $bEntryNo;?>"></td>
										<td bgcolor="#A9D0F5" align="center"><input type="text" id="beDate<?php echo $i;?>" name="beDate" value="<?php echo $eDate;?>" readonly='true'></td>
										<script>
											 $(function() {
												$( '#beDate<?php echo $i;?>' ).datepicker({
													changeMonth: true,
													changeYear: true,
													dateFormat: 'yy-mm-dd', // iso format
												});
											});
										</script>
										<td bgcolor="#A9D0F5" align="center"><input type="text" name="offCode" value="<?php echo $offCode;?>"></td>

										<input type="hidden" name="container" value="<?php echo $container;?>">
										<input type="hidden" name="rotation" value="<?php echo $rotation;?>">
										<input type="hidden" name="tblName" value="<?php echo $tblName;?>">
										<input type="hidden" name="dtlID" value="<?php echo $rtnSqlUpdateShedList[$i]['id'];?>">
										<input type="hidden" name="lineNo" value="<?php echo $rtnSqlUpdateShedList[$i]['Line_No'];?>">
										<input type="hidden" name="packNo" value="<?php echo $rtnSqlUpdateShedList[$i]['Pack_Number'];?>">
										<input type="hidden" name="blNo" value="<?php echo $rtnSqlUpdateShedList[$i]['BL_No'];?>">
										<td bgcolor="#A9D0F5"><input type="submit" value="Update" name="Update" class="login_button"></td>
										</form>
									</tr>
								<?php
								}
								?>
							</tbody>
						</table>

				</td>
			</tr>
		</table>				
</table>
</html>
<?php 
//mysql_close($con);
?>