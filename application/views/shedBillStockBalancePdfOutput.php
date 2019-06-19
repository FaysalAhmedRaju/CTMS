
<html>
<head>
		<div align="center" style="">
			<title><b>CHITTAGONG PORT AUTHORITY</b></title>
		</div>
		<div align="center">VERIFY LIST</div>
		

</head>
<body>	
		<div align ="center">
		
		<hr>
			<table  style="border:1px solid #ccc;" >
					<tr class="gridDark" align="center">
						
						<td ><b>Verify Number</b></td>
						<td ><b>Rotation</b></td>
						<td ><b>Container</b></td>
						<td ><b>MBL</b></td>
						<td ><b>FBL</b></td>
						<td ><b>Size</b></td>
						<td ><b>Type</b></td>
						<td ><b>Status</b></td>
						<td ><b>Qnty</b></td>
						<td ><b>Pkgs</b></td>
						<td ><b>Importer</b></td>
						<td ><b>Gross weight</b></td>
								
					</tr>
					<?php for($i=0;$i<count($rtnContainerList);$i++){?>
					<tr class="gridLight" align="center">
					
						
						<td style="color:red"><?php echo $rtnContainerList[$i]['verify_number'];?></td>
						<td><?php echo $rtnContainerList[$i]['import_rotation'];?></td>
						<td><?php echo $rtnContainerList[$i]['cont_number'];?></td>
						<td><?php echo $rtnContainerList[$i]['master_BL_No'];?></td>
						<td><?php echo $rtnContainerList[$i]['BL_No'];?></td>
						<td><?php echo $rtnContainerList[$i]['cont_size'];?></td>
						<td><?php echo $rtnContainerList[$i]['cont_type'];?></td>
						<td><?php echo $rtnContainerList[$i]['cont_status'];?></td>
						<td><?php echo $rtnContainerList[$i]['Pack_Number'];?></td>
						<td><?php echo $rtnContainerList[$i]['Pack_Description'];?></td>		
						<td><?php echo $rtnContainerList[$i]['Notify_name'];?></td>
						<td><?php echo $rtnContainerList[$i]['cont_weight'];?></td>
					
					</tr>
					<?php }?>
				</table>
			
		</div>
	
</body>
</html>

