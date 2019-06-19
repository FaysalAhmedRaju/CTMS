<body>
	<table width="100%" border ='0'>
		<tr>
			<td colspan="2" align="center"><img width="200px" src="<?php echo IMG_PATH?>cpanew.jpg" /></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>	
		<tr>
			<td colspan="2" align="center"><font size="4"><b>Summary of Offhire Cont. For Preparation of Agent Bill Dt. Wise For : <?php echo $offhire_date; ?></b></font></td>					
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td align="left" style="padding-left:20px"><font size="4"><b>Summary</b></font></td>	
			<td align="right" style="padding-right:20px"><font size="4">Print Date : <?php echo date("Y-m-d h:i:sa"); ?></font></td>		
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>	
	</table>
	<table width="100%" border ='1' style="border-collapse:collapse" cellpadding='0' cellspacing='0'>
	<tr>
		<td rowspan="2" align="center"><b>Sl</b></td>
		<td rowspan="2" align="center"><b>MLO</b></td>
		<td rowspan="2" align="center" width="30%"><b>MLO Name</b></td>
		<td colspan="2" align="center"><b>20</b></td>
		<td colspan="2" align="center"><b>40</b></td>
		<td align="center"><b>45</b></td>
		<td colspan="3" align="center"><b>Total</b></td>
		<td rowspan="2" align="center"><b>Grand Total</b></td>
	</tr>
	<tr height="40px" align="center">	
		<td align="center"><b>8.5</b></td>
		<td align="center"><b>9.5</b></td>
		<td align="center"><b>8.5</b></td>
		<td align="center"><b>9.5</b></td>
		<td align="center"><b>9.5</b></td>
		<td align="center"><b>20</b></td>
		<td align="center"><b>40</b></td>		
		<td align="center"><b>45</b></td>				
	</tr>
	<?php 
	$sum_mty_20=0;
	$sum_mty_40=0;
	$sum_mty_45=0;
	
	$total_mty_20_85=0;
	$total_mty_20_95=0;
	$total_mty_40_85=0;
	$total_mty_40_95=0;
	$total_mty_45_95=0;
	
	$total_sum_mty_20=0;
	$total_sum_mty_40=0;
	$total_sum_mty_45=0;
	
	$total_grand_total=0;
	
	for($i=0;$i<count($rslt_offhire_summary);$i++)
	{
	?>
	<tr align="center">
		<td align="center"><?php echo $i+1;?></td>
		<td align="center"><?php echo $rslt_offhire_summary[$i]['mlo'] ?></td>
		<td align="center"><?php echo $rslt_offhire_summary[$i]['NAME'] ?></td>
		<td align="center"><?php echo $rslt_offhire_summary[$i]['mty_20_85'] ?></td>
		<td align="center"><?php echo $rslt_offhire_summary[$i]['mty_20_95'] ?></td>
		<td align="center"><?php echo $rslt_offhire_summary[$i]['mty_40_85'] ?></td>
		<td align="center"><?php echo $rslt_offhire_summary[$i]['mty_40_95'] ?></td>
		<td align="center"><?php echo $rslt_offhire_summary[$i]['mty_45_95'] ?></td>
		<td align="center">
			<?php
				$sum_mty_20=$rslt_offhire_summary[$i]['mty_20_85'] + $rslt_offhire_summary[$i]['mty_20_95']; 
				echo $sum_mty_20;
			?>
		</td>
		<td align="center">
			<?php
				$sum_mty_40=$rslt_offhire_summary[$i]['mty_40_85'] + $rslt_offhire_summary[$i]['mty_40_95']; 
				echo $sum_mty_40;
			?>
		</td>
		<td align="center">
			<?php 
				$sum_mty_45=$rslt_offhire_summary[$i]['mty_45_95'];
				echo $sum_mty_45; 
			?>
		</td>
		<td align="center">
			<?php 
				$grand_total=$sum_mty_20+$sum_mty_40+$sum_mty_45;
				echo $grand_total;
			?>
		</td>
	</tr>
	<?php
		$total_mty_20_85=$total_mty_20_85+$rslt_offhire_summary[$i]['mty_20_85'];
		$total_mty_20_95=$total_mty_20_95+$rslt_offhire_summary[$i]['mty_20_95'];
		$total_mty_40_85=$total_mty_40_85+$rslt_offhire_summary[$i]['mty_40_85'];
		$total_mty_40_95=$total_mty_40_95+$rslt_offhire_summary[$i]['mty_40_95'];
		$total_mty_45_95=$total_mty_45_95+$rslt_offhire_summary[$i]['mty_45_95'];
		
		$total_sum_mty_20=$total_sum_mty_20+$sum_mty_20;
		$total_sum_mty_40=$total_sum_mty_40+$sum_mty_40;
		$total_sum_mty_45=$total_sum_mty_45+$sum_mty_45;
		
		$total_grand_total=$total_grand_total+$grand_total;
	}
	?>
	<tr align="center">
		<td border="0">&nbsp;</td>
		<td border="0">&nbsp;</td>
		<td align="center">Total</td>
		<td align="center"><?php echo $total_mty_20_85; ?></td>
		<td align="center"><?php echo $total_mty_20_95; ?></td>
		<td align="center"><?php echo $total_mty_40_85; ?></td>
		<td align="center"><?php echo $total_mty_40_95; ?></td>
		<td align="center"><?php echo $total_mty_45_95; ?></td>
		<td align="center"><?php echo $total_sum_mty_20; ?></td>
		<td align="center"><?php echo $total_sum_mty_40; ?></td>
		<td align="center"><?php echo $total_sum_mty_45; ?></td>
		<td align="center"><?php echo $total_grand_total; ?></td>
	</tr>
</table>

