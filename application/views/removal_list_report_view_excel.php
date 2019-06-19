<?php 
	if($_POST['options']=='excel'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=removal_list_report_view_excel.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
?>
<table align="center" width="90%" border ='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td>
			<table width="100%" border ='1'>
				<tr>
					<td colspan="12" width="80%" align="center" style="padding-left:38%;"><h1>Chittagong Port Authority</h1></td>
					<td colspan="4" width="20%" align="left">Serial No.:</td>
				</tr>
				<tr>
					<td colspan="12" width="80%" align="center" style="padding-left:40%;"><h3>Removal Tally of Overflow Yard</h3></td>
					<td colspan="4" width="20%" align="left">Date:</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center">
		<td>
			<table style="border-collapse:collapse;" border="1" width="100%">
				<tr>
					<th>SL.</th>
					<th>Assign Type</th>
					<th>C&F Name</th>
					<th>Cell No</th>
					<th>Container No.</th>
					<th>Size</th>
					<th>Height</th>
					<th>Seal No.</th>
					<th>MLO</th>
					<th>Status</th>
					<th>Vessel Name</th>
					<th>Rotation</th>
					<th>From Slot</th>
					<th>From Yard</th>
					<th>Trailer No.</th>
					<th>Remarks</th>
				</tr>
				<?php
				for($i=0;$i<count($rslt_removal_list);$i++)
				{
				?>
				<tr>
					<td align="center"><?php echo $i+1;?></td>
					<td align="center"><?php echo $rslt_removal_list[$i]['mfdch_value']?></td>
					<td align="center"><?php echo $rslt_removal_list[$i]['cf']?></td>
					<td align="center"><?php echo $rslt_removal_list[$i]['sms_number']?></td>
					<td align="center"><?php echo $rslt_removal_list[$i]['cont_no']?></td>
					<td align="center"><?php echo $rslt_removal_list[$i]['size']?></td>
					<td align="center"><?php echo $rslt_removal_list[$i]['height']?></td>
					<td align="center"><?php echo $rslt_removal_list[$i]['seal_nbr1']?></td>
					<td align="center"><?php echo $rslt_removal_list[$i]['mlo']?></td>
					<td align="center"><?php echo $rslt_removal_list[$i]['cont_status']?></td>
					<td align="center"><?php echo $rslt_removal_list[$i]['v_name']?></td>
					<td align="center"><?php echo $rslt_removal_list[$i]['rot_no']?></td>
					<td align="center"><?php echo $rslt_removal_list[$i]['slot']?></td>
					<td align="center"><?php echo $rslt_removal_list[$i]['Yard_No']?></td>
					<td align="center">&nbsp;</td>
					<td align="center">&nbsp;</td>
				</tr>
				<?php
				}
				?>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table border="0" width="100%">
				<tr>
					<td colspan="7">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="7">&nbsp;</td>
				</tr>
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
		</td>
	</tr>
</table>