<?php if($_POST['fileOptions']=='html'){?>
<HTML>
	<HEAD>
		<TITLE></TITLE>
		<LINK href="../css/report.css" type=text/css rel=stylesheet>
	    <style type="text/css">
<!--
.style1 {font-size: 12px}
-->
        </style>
</HEAD>
<BODY>

	<?php } 
	else if($_POST['fileOptions']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=EXPORT_SUMMERY.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}
	include("mydbPConnection.php");
	?>
<html>
<title> </title>
<body>
<?php 
	$get_icd_mst="SELECT id,cir_dt,cir_no,TIME,pt,shift,category FROM icd_app_mst 
	WHERE cir_dt='$fromdate' AND category='$cat'
	ORDER BY cir_no ";
	$query_icd_mst=mysql_query($get_icd_mst);
	$i=0;
	while($row_icd_mst=mysql_fetch_object($query_icd_mst))
	{
	$i++;
?>

<div <?php if($i<mysql_num_rows($query_icd_mst)) { ?> class="pageBreak" <?php } else { ?> class="pageBreakOff " <?php } ?>>

	<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<tr align="center">
			<td colspan="8" align="center"><img align="middle" width="220px" height="70px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
		</tr>
	
		<tr align="center">
			<td colspan="8" align="center"><font size="4"><b>C.P.A/B.D RLY DATE <?php echo $fromdate; ?></b></font></td>
		</tr>
		<tr align="center">
			<td colspan="8" align="center"><font size="4"><b>CONTAINER INTERCHANGE RECEIPT (CIR) - <?php echo $row_icd_mst->cir_no; ?></b></font></td>
		</tr>
		<tr align="center">
			<td colspan="8" align="center"><font size="4"><b>FOR CONTAINER TRANSPORT BY RAILWAY</b></font></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><?php if($row_icd_mst->category=="IMPRT") { echo " CTG ICD TO DHAKA "; } else { echo " DHAKA TO CTG ICD "; } ?></td>
		<td colspan="2" align="center">DATE : <?php echo $fromdate; ?></td>		
		<td align="center">P/T : <?php echo $row_icd_mst->pt; ?></td>
		<td colspan="2" align="center">CIR TIME : <?php echo $row_icd_mst->TIME; ?></td>
		<td align="center">SHIFT: <?php echo $row_icd_mst->shift; ?></td>
	</tr>
	<tr  align="center">
		<td align="center"><b>SlNo.</b></td>
		<td align="center"><b>Container No.</b></td>
		<td align="center"><b>Size</b></td>
		<td align="center"><b>Seal No</b></td>
		<td align="center"><b>Vessel Name</b></td>
		<td align="center"><b>Rotation No</b></td>		
		<td align="center"><b>MLO</b></td>
		<td align="center"><b>Wagon No</b></td>
	</tr>
	<?php 
	$get_icd_dtl="SELECT * FROM icd_app_dtl WHERE mst_id=".$row_icd_mst->id;
	$query_icd_dtl=mysql_query($get_icd_dtl);
	$j=0;
	$val_20=0;
	$val_40=0;
	$val_tot=0;
	while($row_icd_dtl=mysql_fetch_object($query_icd_dtl))
	{
	$j++;
	$get_igm_data="SELECT Vessel_Name,cont_size,cont_seal_number,cont_status,cont_iso_type,Consignee_name,igm_details.mlocode FROM igm_masters
	INNER JOIN igm_details ON igm_masters.id=igm_details.IGM_id
	INNER JOIN igm_detail_container ON igm_details.id=igm_detail_container.igm_detail_id
	WHERE cont_number='".$row_icd_dtl->cont_no."' and igm_details.Import_Rotation_No='".$row_icd_dtl->rotation."'
	ORDER BY igm_detail_container.id DESC";
	$query_igm_data=mysql_query($get_igm_data);
	$row_igm_data=mysql_fetch_object($query_igm_data);
	?>
	<tr  align="center">
		<td align="center"><?php echo $j; ?></td>
		<td align="center"><?php echo $row_icd_dtl->cont_no; ?></td>
		<td align="center"><?php echo $row_igm_data->cont_size; ?></td>
		<td align="center"><?php echo $row_igm_data->cont_seal_number; ?></td>
		<td align="center"><?php echo $row_igm_data->Vessel_Name; ?></td>
		<td align="center"><?php echo $row_icd_dtl->rotation; ?></td>
		<td align="center"><?php echo $row_igm_data->mlocode; ?></td>
		<td align="center"><?php echo $row_icd_dtl->wagon_no; ?></td>
	</tr>
	<?php 
	if($row_igm_data->cont_size >=40)
	{
		$val_40=$val_40+2;
	}
	else
	{
		$val_20=$val_20+1;
	}
	
	}
	?>
	<tr  align="center">
		<td colspan="8" align="left"><b><?php echo "20'(L) ".$val_20." TUES"; ?></b></td>
	</tr>
	<tr  align="center">
		<td colspan="8" align="left"><b><?php echo "40'(L) ".$val_40." TUES"; ?></b></td>
	</tr>
	<tr  align="center">
		<td colspan="8" align="left"><b><?php $val_tot=$val_20+$val_40; echo "Total : ".$j." Boxes = ".$val_tot." TUES"; ?></b></td>
	</tr>
	</table>
	</div>
	<?php } ?>


	
	<?php 
	mysql_close($con_sparcsn4);
	if($_POST['options']=='html'){?>	
		</BODY>
	</HTML>
<?php }?>
