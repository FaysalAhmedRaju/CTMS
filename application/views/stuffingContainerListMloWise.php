<html>
	<head>
		<title>STUFFING CONTAINER LIST</title>
		<!--style>
			/* th,td
			{
				border:1px solid black;
			} */
		</style-->
	</head>
	<body>
		<table width="100%" style="border-collapse: collapse;" border="0" align="center">
			<!--tr>
				<td colspan="11" align="center"><img width="200px" height="60px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
			</tr-->
		
			<tr>
				<td colspan="11" align="center"><h2><?php echo $rslt_stuffing_report[0]['mlo_code']; ?></h2></td>
			</tr>
			<tr>
				<td colspan="11" align="center">STUFFING CONTAINER LIST</td>
			</tr>
			<tr>
				<th style="border:1px solid black;">Sl</th>
				<th style="border:1px solid black;">Container No</th>
				<th style="border:1px solid black;">Seal No</th>
				<th style="border:1px solid black;">ISO</th>
				<th style="border:1px solid black;">Size</th>
				<th style="border:1px solid black;">Height</th>
				<th style="border:1px solid black;">Type</th>
				<!--th style="border:1px solid black;">MLO</th-->
				<th style="border:1px solid black;">Stuffing Date</th>
				<th style="border:1px solid black;">Destination Port</th>
				<th style="border:1px solid black;">Commodity</th>
				<th style="border:1px solid black;">Offdoc</th>
			</tr>
			<?php
			for($i=0;$i<count($rslt_stuffing_report);$i++)
			{
			?>
				<tr>
					<td align="center" style="border:1px solid black;"><?php echo $i+1; ?></td>
					<td align="center" style="border:1px solid black;"><?php echo $rslt_stuffing_report[$i]['cont_id']; ?></td>
					<td align="center" style="border:1px solid black;"><?php echo $rslt_stuffing_report[$i]['seal_no']; ?></td>
					<td align="center" style="border:1px solid black;"><?php echo $rslt_stuffing_report[$i]['iso_type']; ?></td>
					<td align="center" style="border:1px solid black;"><?php echo $rslt_stuffing_report[$i]['size']; ?></td>
					<td align="center" style="border:1px solid black;"><?php echo $rslt_stuffing_report[$i]['height']; ?></td>
					<td align="center" style="border:1px solid black;"><?php echo $rslt_stuffing_report[$i]['iso_group']; ?></td>
					<!--td align="center" style="border:1px solid black;"><?php echo $rslt_stuffing_report[$i]['mlo_code']; ?></td-->
					<td align="center" style="border:1px solid black;"><?php echo $rslt_stuffing_report[$i]['stuffing_date']; ?></td>
					<td align="center" style="border:1px solid black;"><?php echo $rslt_stuffing_report[$i]['dest_port']; ?></td>
					<td align="center" style="border:1px solid black;"><?php echo $rslt_stuffing_report[$i]['comodity_code']; ?></td>
					<td align="center" style="border:1px solid black;"><?php echo $rslt_stuffing_report[$i]['name']; ?></td>
				</tr>
			<?php
			}
			?>
				<!--tr>
					<td style="border:1px solid black;" colspan="11">&nbsp;</td>
				</tr-->
				<tr>
					<td style="border:1px solid black;" colspan="2" align="center"><b>20' => <?php echo $size_20;?></b></td>
					<td style="border:1px solid black;" colspan="2" align="center"><b>40' => <?php echo $size_40;?></b></td>
					<td style="border:1px solid black;" colspan="7" align="left"><b>Teus => <?php echo $t20+$t40;?></b></td>
				</tr>
		</table>
		</br>
		</br>
		</br>
		<!--table style="border-collapse:collapse" border="1" align="center">
			<tr>
				<th>20'</th>
				<th>40'</th>
				<th>Total Teus</th>
			</tr>
			<tr>
				<td><?php echo $size_20;?></td>
				<td><?php echo $size_40;?></td>
				<td><?php echo $t20+$t40;?></td>
			</tr>
		</table-->
	</body>
</html>