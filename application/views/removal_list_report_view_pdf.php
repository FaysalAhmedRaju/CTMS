<?php ini_set('display_errors', 1);?>
<?php ini_set('memory_limit','256M');?>
<table style="width:100%;">				
	<thead>
		<tr>
			<?php
			if($modify=="overflow")
			{
			?>
			<td colspan="12" width="80%" style="padding-left:38%;"><img width="200px" height="60px" src="<?php echo IMG_PATH?>cpanew.jpg" /></td>
			<td colspan="4" width="20%" align="left">Serial No.:</td>
			<?php
			}
			else if($modify=="all")
			{
			?>
			<td colspan="16" width="100%" style="padding-left:38%;"><img width="200px" height="60px" src="<?php echo IMG_PATH?>cpanew.jpg" /></td>
			<?php
			}
			?>
		</tr>
		<tr>
			<?php
			if($modify=="overflow")
			{
			?>
			<td colspan="12" width="80%" style="padding-left:40%;"><h3><?php echo $heading; ?></h3></td>
			<td colspan="4" width="20%" align="left">Date:</td>
			<?php
			}
			else if($modify=="all")
			{
			?>
			<td colspan="16" width="100%" style="padding-left:40%;"><h3><?php echo $heading; ?></h3></td>
			<?php
			}
			?>
		</tr>
		<tr>
			<td colspan="16">&nbsp;</td>
		</tr>
		<tr align="center">
			<td style="border:1;" align="center"><b>SL.</b></td>
			<td style="border:1;" align="center"><b>Assign Type</b></td>
			<td style="border:1;" align="center"><b>C&F Name</b></td>
			<td style="border:1;" align="center"><b>Cell No</b></td>
			<td style="border:1;" align="center"><b>Container No.</b></td>
			<td style="border:1;" align="center"><b>Size</b></td>
			<td style="border:1;" align="center"><b>Height</b></td>
			<td style="border:1;" align="center"><b>Seal No.</b></td>
			<td style="border:1;" align="center"><b>MLO</b></td>
			<td style="border:1;" align="center"><b>Status</b></td>
			<td style="border:1;" align="center"><b>Vessel Name</b></td>
			<td style="border:1;" align="center"><b>Rotation</b></td>
			<td style="border:1;" align="center"><b>From Slot</b></td>
			<td style="border:1;" align="center"><b>From Yard</b></td>
			<td style="border:1;" align="center"><b>Trailer No.</b></td>
			<td style="border:1;" align="center"><b>Remarks</b></td>
		</tr>
	</thead>
	<?php
	for($i=0;$i<count($rslt_removal_list);$i++)
	{
	?>
	<tr>
		<td style="border:1;" align="center"><?php echo $i+1;?></td>
		<td style="border:1;" align="center"><?php echo $rslt_removal_list[$i]['mfdch_value']?></td>
		<td style="border:1;" align="center"><?php echo $rslt_removal_list[$i]['cf']?></td>
		<td style="border:1;" align="center"><?php echo $rslt_removal_list[$i]['sms_number']?></td>
		<td style="border:1;" align="center"><?php echo $rslt_removal_list[$i]['cont_no']?></td>
		<td style="border:1;" align="center"><?php echo $rslt_removal_list[$i]['size']?></td>
		<td style="border:1;" align="center"><?php echo $rslt_removal_list[$i]['height']?></td>
		<td style="border:1;" align="center"><?php echo $rslt_removal_list[$i]['seal_nbr1']?></td>
		<td style="border:1;" align="center"><?php echo $rslt_removal_list[$i]['mlo']?></td>
		<td style="border:1;" align="center"><?php echo $rslt_removal_list[$i]['cont_status']?></td>
		<td style="border:1;" align="center"><?php echo $rslt_removal_list[$i]['v_name']?></td>
		<td style="border:1;" align="center"><?php echo $rslt_removal_list[$i]['rot_no']?></td>
		<td style="border:1;" align="center"><?php echo $rslt_removal_list[$i]['slot']?></td>
		<td style="border:1;" align="center"><?php echo $rslt_removal_list[$i]['Yard_No']?></td>
		<td style="border:1;" align="center">&nbsp;</td>
		<td style="border:1;" align="center">&nbsp;</td>
	</tr>
	<?php
	}
	?>
</table>
<?php
if($modify=="overflow")
{
?>
<table border="0" width="100%" align="center">
	<tr>
		<td style="width:20%" align="center"><u>Sender</u> : <br>CCT/NCT</td>
		<td style="width:2%">&nbsp;</td>
		<td style="width:20%;border-bottom: 2px dotted black;">&nbsp;</td>
		<td style="width:9%">&nbsp;</td>
		<td style="width:20%;border-bottom: 2px dotted black;">&nbsp;</td>
		<td style="width:9%">&nbsp;</td>
		<td style="width:20%;border-bottom: 2px dotted black;">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="7">&nbsp;</td>
	</tr>
	<tr>
		<td style="width:20%" align="center"><u>Receiver</u> : <br>Overflow</td>
		<td style="width:2%">&nbsp;</td>
		<td style="width:20%;border-bottom: 2px dotted black;">&nbsp;</td>
		<td style="width:9%">&nbsp;</td>
		<td style="width:20%;border-bottom: 2px dotted black;">&nbsp;</td>
		<td style="width:9%">&nbsp;</td>
		<td style="width:20%;border-bottom: 2px dotted black;">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="7">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="7">&nbsp;</td>
	</tr>				
</table>
<?php
}
?>