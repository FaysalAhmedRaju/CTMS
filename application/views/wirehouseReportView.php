<html>
	<head>
		<title>Chittagong Port Authority</title>
		<style>
			/*.tblborder *
			{
				border:1px solid black;
			}*/
		</style>
	</head>
	<body>
		<table width="100%" cellpadding="0">
			<tr height="100px">
				<td align="center" valign="middle">
					<h1>Chittagong Port Authority</h1>
					<h3>Warehouse Report for<?php echo " Rotation: ".$rotation." and Container: ".$cont;?></h3>
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
					<table border="1" align="center" cellspacing="0" cellpadding="1">
						<tr>
							<th>Sl No.</th>
							<th>Line No.</th>							
							<th>Marks & Number</th>							
							<th>Description of Goods</th>
							<th>Package Quantity</th>
							<th>Package Receive</th>
							<th>Location in Shed</th>
							<th>Package Delivery</th>
							<th>Remain Package</th>
							<th>Remarks</th>
						</tr>
						
							<?php
								include_once("mydbPConnection.php");
								for($i=0;$i<count($rtnContainerList);$i++) { 
									?>
									<tr>
										<td>
											<?php echo $i+1;?>
										</td>
										<td>
											<?php echo $rtnContainerList[$i]['Line_No']?>
										</td>
										<td width="200">
											<?php echo $rtnContainerList[$i]['Pack_Marks_Number']?>
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
										<td width="200">
											&nbsp;
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