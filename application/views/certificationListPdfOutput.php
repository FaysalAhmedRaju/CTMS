<html>
<head>
	<div align="center" style="">
		<!--title><b>CHITTAGONG PORT AUTHORITY</b></title-->
		<img width="200px" height="60px" src="<?php echo IMG_PATH?>cpanew.jpg">
	</div>
	<div align="center">ONE STOP SERVICE CENTER</div>
	<div align="center">View Certification</div>
</head>
<body>	
	<div align ="center">
		<table align="center" width=85% border="1" style="font-size:12px; border-collapse: collapse;">
			<?php
			for($i=0;$i<count($rtnContainerList);$i++) 
			{ 
			?>
			<tr>
				<th width="100px">Discharge Time</th><th>:</th><td><?php echo $fcy_time_out; ?></td>
				<th width="100px">Vessel Name</th><th>:</th><td><?php echo $rtnContainerList[$i]['Vessel_Name']; ?></td>
				<th>Rotation</th><th>:</th><td><?php echo $rtnContainerList[$i]['Import_Rotation_No']; ?></td>
			</tr>
			<tr>
				<th width="100px">Container</th><th>:</th><td><?php echo $rtnContainerList[$i]['cont_number'];  ?></td>
				<th width="100px">Cont.Size</th><th>:</th><td><?php echo $rtnContainerList[$i]['cont_size'];  ?></td>
				<th width="100px">Cont.Height</th><th>:</th><td><?php echo $rtnContainerList[$i]['cont_height'];  ?></td>
			</tr>
			<tr>
				<!--th>Cont. Type</th><th>:</th><td><?php echo $rtnContainerList[$i]['cont_iso_type']; ?></td-->
				<th>BL No</th><th>:</th><td><?php echo $rtnContainerList[$i]['BL_No']; ?></td>
				<th>Yard / Shed</th><th>:</th><td><?php echo $rtnContainerList[$i]['shed_yard'];  ?></td>
				<th width="100px">Unstuffing Date</th><th>:</th><td><?php echo $rtnContainerList[$i]['wr_date'];  ?></td>
			</tr>
			<tr>
				<!--th width="100px">Unstuffing Date</th><th>:</th><td><?php echo $rtnContainerList[$i]['wr_date'];  ?></td-->						
				<th>Marks & Number</th><th>:</th><td><?php echo str_replace(',',', ',$rtnContainerList[$i]['Pack_Marks_Number']); ?></td>
				<th width="150px">Description of Goods</th><th>:</th><td><?php echo $rtnContainerList[$i]['Description_of_Goods'];  ?></td>
				<th>Importer</th><th>:</th><td><?php echo $rtnContainerList[$i]['Notify_name']; ?></td>
			</tr>
			<tr>	
				<th width="100px">Receive Pack</th><th>:</th><td><?php echo $rtnContainerList[$i]['rcv_pack']; ?></td>
				<th width="100px">Pack Unit</th><th>:</th><td><?php print($rtnContainerList[$i]['rcv_unit']); ?></td>
				<!--th>Importer</th><th>:</th><td><?php echo $rtnContainerList[$i]['Notify_name']; ?></td-->
			</tr>
			<?php 
			}
			?>
		</table>
	</div>
</body>
</html>

