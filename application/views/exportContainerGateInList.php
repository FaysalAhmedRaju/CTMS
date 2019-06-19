<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
</HEAD>
<BODY>

	<?php } 
	else if($_POST['options']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=EXPORT_CONTAINER_GATE_IN_LIST.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}
	
	?>

	<table border=0 width="100%">				
		<tr align="center">
			<td colspan="12" align="center"><img align="middle"  width="220px" height="70px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
		</tr>
			
		<tr align="center">
			<td colspan="12" align="center"><font size="4"><b><u><?php echo $title;?></u></b></font></td>
		</tr>
	</table>
		

	<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<thead>
	<tr align="center">
		<td align="center" style="border-width:1px;border-style: double;" ><b>Sl.NO</b></td>
		<td align="center" style="border-width:1px;border-style: double;"><b>CONTAINER NO</b></td>
		<td align="center" style="border-width:1px;border-style: double;" ><b>SIZE</b></td>
		<td align="center" style="border-width:1px;border-style: double;" ><b>HEIGHT</b></td>
		<td align="center" style="border-width:1px;border-style: double;" ><b>SEAL NO</b></td>
		<td align="center" style="border-width:1px;border-style: double;" ><b>MLO</b></td>
		<td align="center" style="border-width:1px;border-style: double;" ><b>TYPE</b></td>
		<td align="center" style="border-width:1px;border-style: double;" ><b>VESSEL NAME</b></td>
		<td align="center" style="border-width:1px;border-style: double;" ><b>TIME IN</b></td>
	</tr>
	</thead>
<?php
	//echo $todate;
include("dbConection.php");
// Check Shipping Agent Exist , After Login Get the Shipping Agent Id.
$chkListQuery= "SELECT count(inv.id) as chkNum											 
				FROM sparcsn4.inv_unit inv  
				INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=inv.gkey
				INNER JOIN sparcsn4.argo_carrier_visit ON argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ob_cv
				INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
				INNER JOIN sparcsn4.ref_bizunit_scoped g ON sparcsn4.vsl_vessel_visit_details.bizu_gkey = g.gkey
				where g.id='$login_id_ship' and vsl_vessel_visit_details.ob_vyg='$rotation_no' order by inv_unit_fcy_visit.time_in desc";
$rtnChkList=mysql_query($chkListQuery);
$rowChkList=mysql_fetch_object($rtnChkList);

if($rowChkList->chkNum > 0)
{
$expQuery="SELECT inv.id,RIGHT(sparcsn4.ref_equip_type.nominal_length,2) AS size,RIGHT(sparcsn4.ref_equip_type.nominal_height,2)/10 AS height,
			inv.seal_nbr1,sparcsn4.vsl_vessels.name,g.id AS MLO,inv.category,inv.freight_kind,
			vsl_vessel_visit_details.ob_vyg AS rotation,inv_unit_fcy_visit.time_in												 
			FROM sparcsn4.inv_unit inv  
			LEFT JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=inv.gkey
			LEFT JOIN sparcsn4.argo_carrier_visit ON argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ob_cv
			LEFT JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
			LEFT JOIN sparcsn4.vsl_vessels ON vsl_vessels.gkey=vsl_vessel_visit_details.vessel_gkey
			LEFT JOIN sparcsn4.inv_unit_equip ON inv.gkey=inv_unit_equip.unit_gkey 
			LEFT JOIN sparcsn4.ref_bizunit_scoped g ON inv.line_op = g.gkey
			LEFT JOIN sparcsn4.ref_equipment ON inv_unit_equip.eq_gkey=ref_equipment.gkey
			LEFT JOIN sparcsn4.ref_equip_type ON ref_equipment.eqtyp_gkey=ref_equip_type.gkey 
			WHERE vsl_vessel_visit_details.ob_vyg='$rotation_no' and inv_unit_fcy_visit.time_in is not null  
			ORDER BY inv.gkey DESC";	
	
$rtnExpQuery=mysql_query($expQuery);
 //echo $query;
	$i=0;	
	while($rowExpQuery=mysql_fetch_object($rtnExpQuery)){
	$i++;
?>
<tbody>
<tr align="center">
		<td align="center"><?php  echo $i;?></td>
		<td align="center"><?php if($rowExpQuery->id) echo $rowExpQuery->id; else echo "&nbsp;";?></td>
		<td align="center"><?php if($rowExpQuery->size) echo $rowExpQuery->size; else echo "&nbsp;";?></td>
		<td align="center"><?php if($rowExpQuery->height) echo $rowExpQuery->height; else echo "&nbsp;";?></td>
		<td align="center"><?php if($rowExpQuery->seal_nbr1) echo $rowExpQuery->seal_nbr1; else echo "&nbsp;";?></td>
		<td align="center"><?php if($rowExpQuery->MLO) echo $rowExpQuery->MLO; else echo "&nbsp;";?></td>
		<td align="center"><?php if($rowExpQuery->freight_kind) echo $rowExpQuery->freight_kind; else echo "&nbsp;";?></td>
		<td align="center"><?php if($rowExpQuery->name) echo $rowExpQuery->name; else echo "&nbsp;";?></td>
		<td align="center"><?php if($rowExpQuery->time_in) echo $rowExpQuery->time_in; else echo "&nbsp;";?></td>
	</tr>
</tbody>
<?php } } else { ?>
<tr align="center">
	<td colspan="9"> No Container Found </td>
</tr>
<?php } ?>
</table>
<?php 
mysql_close($con_ctmsmis);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
