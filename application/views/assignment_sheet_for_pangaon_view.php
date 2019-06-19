<?php 
	if($_POST['options']=='excel'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=assignment_sheet_for_pangaon_view.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
?>
<table align="center" width="100%">
	<tr>
		<td align="center" colspan="16"><h3>CHITTAGONG PORT AUTHORITY</h3></td>
	</tr>
	<tr>
		<td align="center" colspan="16">OFFICE OF THE TERMINAL MANAGER</td>
	</tr>
	<tr>
		<td align="center" colspan="16">ASSIGNMENT SHEET FOR OUTWARD PANGAON ICT CONTAINER</td>
	</tr>
	<tr>
		<td align="center" colspan="16"><?php echo "Pangaon Rotation : ".$pangaon_rot; ?></td>
	</tr>
</table>
<table align="center" border="1" style="border-collapse:collapse;width:90%">
	<tr>
		<th>Sl</th>
		<th>Container No</th>
		<th>Size</th>
		<th>Seal No</th>
		<th>Goods Description</th>
		<th>Remarks</th>
		<th>Release Date,etc</th>
		<th>G. WT</th>
		<th>Imp Vessels Name/Depo</th>
		<th>Rot. No.</th>		
		<th>L/D</th>		
		<th>MLO</th>		
		<th>Desp Date</th>		
		<th>Carried Vessel</th>		
		<th>Berthing Date</th>		
		<th>Location</th>		
	</tr>
	<?php
	for($i=0;$i<count($rslt_assignment_sheet);$i++)
	{
		include('mydbPConnection.php');
		
		$imp_rot=$rslt_assignment_sheet[$i]['rot_no'];
		$cont_id=$rslt_assignment_sheet[$i]['cont_id'];
		
		$sql_goods_description="SELECT Description_of_Goods 
		FROM igm_details
		INNER JOIN igm_detail_container ON igm_detail_container.igm_detail_id=igm_details.id
		WHERE Import_Rotation_No='$imp_rot' AND cont_number='$cont_id'";
		
		$rslt_goods_description=mysql_query($sql_goods_description);
		
		$row_goods_description=mysql_fetch_object($rslt_goods_description);
		
		$goods_description=$row_goods_description->Description_of_Goods;
	?>
	<tr>
		<td align="center"><?php echo $i+1; ?></td>
		<td align="center"><?php echo $rslt_assignment_sheet[$i]['cont_id']; ?></td>
		<td align="center"><?php echo $rslt_assignment_sheet[$i]['size']; ?></td>
		<td align="center"><?php echo $rslt_assignment_sheet[$i]['seal_no']; ?></td>
		<td align="center"><?php echo $goods_description; ?></td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center"><?php echo $rslt_assignment_sheet[$i]['goods_and_ctr_wt_kg']; ?></td>
		<td align="center"><?php echo $rslt_assignment_sheet[$i]['vsl_name']; ?></td>
		<td align="center"><?php echo $rslt_assignment_sheet[$i]['rot_no']; ?></td>
		<td align="center">&nbsp;</td>
		<td align="center"><?php echo $rslt_assignment_sheet[$i]['mlo']; ?></td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center"><?php echo $rslt_assignment_sheet[$i]['berthDT']; ?></td>
		<td align="center">&nbsp;</td>
	</tr>
	<?php
	}
	?>
</table>