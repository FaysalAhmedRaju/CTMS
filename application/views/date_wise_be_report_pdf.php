<html>
<head>
	<table align="center" width="95%">
		<tr>
			<td  align="center"><img align="middle"  width="200px" height="70px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
		</tr>
		<tr>
			<td align="center"><font size="4"><b>DATE WISE Bill of Entry REPORT</b></font></td>
		</tr>
		<tr>
			<td align="center"><font size="4"><b>Date : <?php echo $be_entry_date; ?></b></font></td>
		</tr>	
	</table>	
</head>
<body>	
	<table border="1" align="center" width="70%" style="border-collapse:collapse">
		<thead>
			<tr>
				<th>Sl</th>
				<th>IP Address</th>
				<th>Total Entry</th>
			</tr>
		</thead>
		<?php
		$tot_entry=0;
		for($i=0;$i<count($rslt_be_report_datewise);$i++)
		{
		?>
		<tr>
			<td align="center"><?php echo $i+1;?></td>
			<td align="center"><?php echo $rslt_be_report_datewise[$i]['ip_address']?></td>   
            <td align="center"><?php echo $rslt_be_report_datewise[$i]['tot_entry']?></td>   
		</tr>
		<?php
		$tot_entry=$tot_entry+$rslt_be_report_datewise[$i]['tot_entry'];
		}
		?>
		<tr>
			<!--td>&nbsp;</td-->
			<td align="center" colspan="2"><b>Total</b></td> 
			<td align="center"><b><?php echo $tot_entry; ?></b></td> 
		</tr>
	</table>			
</body>
</html>
