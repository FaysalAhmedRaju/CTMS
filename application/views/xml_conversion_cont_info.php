<table style="border-collapse:collapse;width:100%;">
	<tr>
		<td align="center"><img width="200px" height="60px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
	</tr>
</table>

<table border="1" style="border-collapse:collapse;width:100%;">
	<tr>
		<th>Sl</th>
		<th>Container No</th>
		<th>Type</th>
		<th>Status</th>
		<th>Gross Weight</th>
		<th>Goods Description</th>
		<th>Package Type</th>
		<th>Package Number</th>
		<th>Package Weight</th>
	</tr>
	<?php
	for($i=0;$i<count($rslt_cont_info);$i++)
	{
	?>
	<tr>
		<td align="center"><?php echo $i+1; ?></td>
		<td align="center"><?php echo $rslt_cont_info[$i]['cont_number']; ?></td>
		<td align="center"><?php echo $rslt_cont_info[$i]['cont_type']; ?></td>
		<td align="center"><?php echo $rslt_cont_info[$i]['freight_kind']; ?></td>
		<td align="center"><?php echo $rslt_cont_info[$i]['gross_wt']; ?></td>
		<td align="center"><?php echo $rslt_cont_info[$i]['goods_desc']; ?></td>
		<td align="center"><?php echo $rslt_cont_info[$i]['pkg_type']; ?></td>
		<td align="center"><?php echo $rslt_cont_info[$i]['pkg_num']; ?></td>
		<td align="center"><?php echo $rslt_cont_info[$i]['pkg_wt']; ?></td>
	</tr>
	<?php
	}
	?>
</table>