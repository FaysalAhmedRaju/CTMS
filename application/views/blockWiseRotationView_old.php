<html>
<head>
		<div align="center" style="font-size:18px">
			<title>CHITTAGONG PORT AUTHORITY</title>
		</div>
		<div align="center"><h1>Chittagong Port Authority </h1></div>
		<div align="center"><h3>IMPORT DISCHARGE REPORT</h3></div>
		<div align="center"><h3><?php echo "Rotation : ".$rotNo; ?></h3></div>

</head>
<body>	
		<div align ="center">
		<table align="center" width="80%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
		
		<tr>
		  <th>SL</th>
		  <th>Container No.</th>
		  <th>Status</th>
		  <th>Size</th>
		  <th>Height</th>
		  <th>Discharge Time</th>
	      <th>User</th>
		</tr>
		
		<?php 
		$pos="";
		$j=1;
		for ($i=0; $i<count($getList); $i++) 
		{
			if($pos!=$getList[$i]['current_position'])
			{ $j=1;
		?>
			<tr bgcolor="#FFC0E">
				<td colspan="7"><?php echo "Block : ".$getList[$i]['current_position']?></td>
			</tr>
		<?php
			}
		?>
		<tr>
		  <td align="center"><?php echo $j++; ?></td>
		  <td align="center"><?php echo $getList[$i]['cont_id']; ?></td>
		  <td align="center"><?php echo $getList[$i]['cont_status']; ?></td>
		  <td align="center"><?php echo $getList[$i]['cont_size']; ?></td>
		  <td align="center"><?php echo $getList[$i]['cont_height']; ?></td>
		  <td align="center"><?php echo $getList[$i]['last_update']; ?></td>
	       <td align="center"><?php echo $getList[$i]['user_id']; ?></td>
	    </tr>
		<?php 
		$pos = $getList[$i]['current_position'];
		}		
		?>
       
		 
		</table>
		
		
		</div>
	
</body>
</html>
