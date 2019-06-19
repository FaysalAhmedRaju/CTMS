<html>
	<head>
		<title>Chittagong Port Authority</title>
		<style>
			table,tr,td{border:1px solid black;}
		</style>
	</head>
	<body>
		<table width="100%" cellpadding="0">
			<tr height="100px">
				<!--td align="center" valign="middle">
					<h1>Chittagong Port Authority</h1>
					<h3>Datewise Wirehouse Report<?php echo " From: ".$from." To: ".$to;?></h3>
				</td-->
				
				<td align="center" valign="middle">
					<td colspan="14" align="center"><img width="200px" height="60px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
				</td>
				<td>
					<h3>Datewise Wirehouse Report<?php echo " From: ".$from." To: ".$to;?></h3>
				</td>
			</tr>
			<!--tr>
				<td align="left" valign="middle" style="padding-top:10px;padding-left:20px;">
					<h3>Wirehouse Report for<?php echo " Rotation: ".$rotation." and Container: ".$cont;?></h3>
				</td>
			</tr-->
			<tr>
				<td align="left" valign="middle">
					<h3><?php echo $stat;?></h3>
				</td>
			</tr>
			<tr>
				<td>
					<table border="1" align="center" cellspacing="1" cellpadding="1">
						<tr>
							<th>Sl No.</th>
							<th>Line No.</th>							
							<th>Rotation</th>							
							<th>Container</th>							
							<th>Marks (IGM)</th>
							<th>Marks Description (Actual)</th>							
							<th>Description of Goods</th>
							<th>Package Quantity</th>
							<th>Package Receive</th>
							<th>Location in Shed</th>
							<th>Package Delivery</th>
							<th>Remain Package</th>
							<th>Remarks</th>
							<th>Marks State</th>
						</tr>
						
							<?php
							//	include_once("mydbPConnection.php");
								for($i=0;$i<count($rtnContainerList);$i++) { 
									?>
									<tr>
										<td>
											<?php echo $i+1;?>
										</td>
										<td>
											<?php echo $rtnContainerList[$i]['Line_No']?>
										</td>
										<td>
											<?php echo $rtnContainerList[$i]['Import_Rotation_No']?>
										</td>
										<td>
											<?php echo $rtnContainerList[$i]['cont_number']?>
										</td>
										<td width="200">
											<?php echo $rtnContainerList[$i]['Pack_Marks_Number']?>
										</td>
										<td width="200">
											<?php echo $rtnContainerList[$i]['actual_marks']?>
										</td>										
										<td width="200">
											<?php echo $rtnContainerList[$i]['Description_of_Goods']?>
										</td>										
										<td>
											<?php echo $rtnContainerList[$i]['Pack_Number']?>
										</td>
										<td>
											<?php echo $rtnContainerList[$i]['rcv_pack']?>
										</td>
										<td>
											<?php echo $rtnContainerList[$i]['shed_loc']?>
										</td>
										<td>
											<?php echo $rtnContainerList[$i]['delv_pack']?>
										</td>
										<td>
											<?php echo $rtnContainerList[$i]['rest_pack']?>
										</td>
										<td>
											<?php echo $rtnContainerList[$i]['remarks']?>
										</td>
										<td>
											<?php echo $rtnContainerList[$i]['marks_state']?>
										</td>										
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