<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>Export Loading</TITLE>
		<LINK href="../css/report.css" type=text/css rel=stylesheet>
	    <style type="text/css">
<!--
.style1 {font-size: 12px}
-->
			@media print {
				@page {margin:0.1 -6cm}
				html {margin:0.1 6cm}
				.pageBreak {
					page-break-after: always;
				}
				.pageBreakOff {
					page-break-before: avoid;
				}
			}
        </style>
</HEAD>
<BODY>

	<?php } 
	else if($_POST['options']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=EXPORT_LOADING/$ddl_imp_rot_no.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}
$ddl_imp_rot_no=$_REQUEST['ddl_imp_rot_no']; 

	include("dbConection.php");
	
	$sql=mysql_query("select vvd_gkey from sparcsn4.vsl_vessel_visit_details where ib_vyg='$ddl_imp_rot_no'");
	$row=mysql_fetch_object($sql);
	$vvdGkey=$row->vvd_gkey;
	
	$sql="call ctmsmis.update_containers_by_vvd_gkey($vvdGkey)";
	$res=mysql_query($sql);
	
	$sql1=mysql_query("select vsl_vessels.name as vsl_name,ifnull(sparcsn4.vsl_vessel_visit_details.flex_string02,ifnull(sparcsn4.vsl_vessel_visit_details.flex_string03,'')) as berth_op,ifnull(sparcsn4.argo_quay.id,'') as berth,sparcsn4.argo_carrier_visit.ata,sparcsn4.argo_carrier_visit.atd from vsl_vessel_visit_details
	inner join sparcsn4.argo_carrier_visit on sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
	inner join sparcsn4.vsl_vessel_berthings on sparcsn4.vsl_vessel_berthings.vvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
	inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
	inner join sparcsn4.argo_quay on sparcsn4.argo_quay.gkey=sparcsn4.vsl_vessel_berthings.quay
	where vsl_vessel_visit_details.vvd_gkey=$vvdGkey");
	
	$row1=mysql_fetch_object($sql1);
	$cond="";
	if($fromdate!="" and $todate!="")	
	{
		if($fromTime!="")
			$frmDate = $fromdate." ".$fromTime.":00";
		
		if($toTime!="")
			$tDate = $todate." ".$toTime.":00";
		
		$cond = " and mis_exp_unit.vvd_gkey='$vvdGkey' and mis_exp_unit.last_update between '$frmDate' and '$tDate'";
	}
	else
	{
		$cond = " and mis_exp_unit.vvd_gkey='$vvdGkey'";
	}
	?>
<html>
<title>Export Loading</title>
<body>
<?php 

// $sqlMloQry="SELECT DISTINCT mlo
// FROM ctmsmis.mis_exp_unit 
// INNER JOIN ctmsmis.mis_inv_unit ON ctmsmis.mis_inv_unit.gkey=mis_exp_unit.gkey 
// WHERE mis_exp_unit.preAddStat='0' AND mis_exp_unit.delete_flag='0' $cond ORDER BY mlo,craine_id,ctmsmis.mis_inv_unit.id";

$sqlMloQry="SELECT DISTINCT r.id AS mlo
FROM sparcsn4.inv_unit
INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ob_cv
INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
INNER JOIN (sparcsn4.ref_bizunit_scoped r      
LEFT JOIN (sparcsn4.ref_agent_representation X      
LEFT JOIN sparcsn4.ref_bizunit_scoped Y ON X.agent_gkey=Y.gkey) ON r.gkey=X.bzu_gkey) ON r.gkey = sparcsn4.inv_unit.line_op
WHERE ib_vyg='$ddl_imp_rot_no' ORDER BY r.id";

//echo $sqlMloQry;
$rsltMloQuery=mysql_query($sqlMloQry);
while($rowMlo=mysql_fetch_object($rsltMloQuery))
{
	
?>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td colspan="7" align="center"><img align="middle" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
	</tr>
	<tr>
		<td colspan="7" align="center"><font size="3"><b>OFFICE OF THE TERMINAL MANAGER</b></font></td>
	</tr>
	<tr>
		<td colspan="7" align="center"><font size="3"><b>MLO WISE PANGOAN LOADING DETAIL</b></font></td>					
	</tr>
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="5" align="center"></td>
	</tr>
	<!--tr bgcolor="#ffffff" align="center">
		<td  align="centre"><font size="3"><b>VESSEL-<?php echo $row1->vsl_name; ?></b></font></td>
		<td  align="centre"><font size="3"><b>VOY- <?php echo $voysNo; ?></b></font></td>
		<td  align="centre"><font size="3"><b>EXP.ROT- <?php echo $ddl_imp_rot_no; ?></b></font></td>
		<td  align="centre"><font size="3"><b>SAILED DATE- <?php echo $row1->atd; ?></b></font></td>
		<td  align="centre"><font size="3"><b>BERTH-<?php echo $row1->berth; ?></b></font></td>
	</tr-->
	
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="9" align="center"></td>
	</tr>
</table>

	<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<thead>
	<tr bgcolor="#ffffff" align="center">
		<td colspan="3" align="centre"><font size="3"><b>VESSEL-<?php echo $row1->vsl_name; ?></b></font></td>
		<td colspan="3" align="centre"><font size="3"><b>VOY- <?php echo $voysNo; ?></b></font></td>
		<td colspan="3" align="centre"><font size="3"><b>EXP.ROT- <?php echo $ddl_imp_rot_no; ?></b></font></td>
		<!--td colspan="2" align="centre"><font size="3"><b>SAILED DATE- <?php echo $row1->atd; ?></b></font></td>
		<td colspan="1" align="centre"><font size="3"><b>BERTH-<?php echo $row1->berth; ?></b></font></td-->
	</tr>

	<tr  align="center">
		<td style="border-width:3px;border-style: double;"><b>SlNo.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Container No.</b></td>
		
		<td style="border-width:3px;border-style: double;"><b>Size.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Height.</b></td>
		<td style="border-width:3px;border-style: double;"><b>ISOCode</b></td>
		<td style="border-width:3px;border-style: double;"><b>Status</b></td>
		<td style="border-width:3px;border-style: double;"><b>Seal NO</b></td>		
		<td style="border-width:3px;border-style: double;"><b>MLO</b></td>
		<!--td style="border-width:3px;border-style: double;"><b>Equipment No.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Trailer</b></td-->
		<!--td style="border-width:3px;border-style: double;"><b>OffDoc/Port</b></td-->
		<!--td style="border-width:3px;border-style: double;"><b>Stowage</b></td-->
		<!--td style="border-width:3px;border-style: double;"><b>POD</b></td-->
		
		<!--td style="border-width:3px;border-style: double;"><b>Yard</b></td-->
		<td style="border-width:3px;border-style: double;"><b>Weight</b></td>
		<!--td style="border-width:3px;border-style: double;"><b>Loading Time</b></td>
		<td style="border-width:3px;border-style: double;"><b>Remarks</b></td-->
	
		
	</tr>
	</thead>
	<tbody>

<?php
		
	// $query=mysql_query("SELECT CONCAT(SUBSTRING(ctmsmis.mis_inv_unit.id,1,4),' ',SUBSTRING(ctmsmis.mis_inv_unit.id,5)) AS id,
	// ctmsmis.mis_inv_unit.size,(ctmsmis.mis_inv_unit.height)/10 AS height,ctmsmis.mis_exp_unit.pod,ctmsmis.mis_exp_unit.craine_id,
	// (SELECT SUBSTRING(id,1,3) FROM sparcsn4.argo_quay 
	// INNER JOIN sparcsn4.vsl_vessel_berthings brt ON brt.quay=sparcsn4.argo_quay.gkey 
	// WHERE brt.vvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey ORDER BY brt.ata DESC LIMIT 1)AS berth,
	// sparcsn4.ref_equip_type.id AS iso,ctmsmis.mis_inv_unit.freight_kind,mlo,
	// ctmsmis.mis_exp_unit.seal_no AS seal_no2,ctmsmis.mis_exp_unit.truck_no AS truck_no,
	// ctmsmis.mis_exp_unit.truck_no LIKE '%sp%' AS truck_no1,
	// ctmsmis.mis_exp_unit.stowage_pos,ctmsmis.mis_exp_unit.last_update,'' AS remark,mis_exp_unit.goods_and_ctr_wt_kg AS weight
	// FROM ctmsmis.mis_exp_unit 
	// INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey
	// INNER JOIN ctmsmis.mis_inv_unit ON ctmsmis.mis_inv_unit.gkey=mis_exp_unit.gkey 
	// LEFT JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=ctmsmis.mis_inv_unit.goods
	// LEFT JOIN sparcsn4.ref_commodity ON sparcsn4.ref_commodity.gkey=sparcsn4.inv_goods.commodity_gkey
	// INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.unit_gkey=ctmsmis.mis_inv_unit.gkey
	// INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
	// INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
	// WHERE mis_exp_unit.preAddStat='0' and mis_exp_unit.delete_flag='0' and mlo='".$rowMlo->mlo."' ".$cond." ORDER BY mlo,craine_id,ctmsmis.mis_inv_unit.id");
	
	$query=mysql_query("SELECT sparcsn4.inv_unit.gkey,r.id AS mlo,category,freight_kind,inv_unit.id AS cont_id,
	(SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) 
	FROM sparcsn4.inv_unit_equip 
	INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey 
	INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey 
	WHERE sparcsn4.inv_unit_equip.unit_gkey=inv_unit.gkey) AS size,
	((SELECT RIGHT(sparcsn4.ref_equip_type.nominal_height,2) 
	FROM sparcsn4.inv_unit_equip 
	INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey 
	INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey 
	WHERE sparcsn4.inv_unit_equip.unit_gkey=inv_unit.gkey)/10) AS height,
	sparcsn4.ref_equip_type.id AS iso,
	sparcsn4.inv_unit.seal_nbr1 AS seal_no,
	sparcsn4.inv_unit.goods_and_ctr_wt_kg AS weight,
	sparcsn4.ref_routing_point.id AS pod
	FROM sparcsn4.inv_unit
	INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
	INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
	INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
	INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
	INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ob_cv
	INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
	INNER JOIN sparcsn4.ref_routing_point ON sparcsn4.ref_routing_point.gkey=sparcsn4.inv_unit.pod1_gkey
	INNER JOIN (sparcsn4.ref_bizunit_scoped r      
	LEFT JOIN (sparcsn4.ref_agent_representation X      
	LEFT JOIN sparcsn4.ref_bizunit_scoped Y ON X.agent_gkey=Y.gkey) ON r.gkey=X.bzu_gkey) ON r.gkey = sparcsn4.inv_unit.line_op
	WHERE ib_vyg='$ddl_imp_rot_no' AND r.id='$rowMlo->mlo'
	ORDER BY mlo");

	$i=0;
	$j=0;
	$mlo="";
	$weight=0;
	$totWeight=0;
	
	while($row=mysql_fetch_object($query)){
	$i++;
	
	$querydep="select count(sparcsn4.ref_bizunit_scoped.id) as cnt
from sparcsn4.ref_bizunit_scoped
inner join sparcsn4.road_trucking_companies on sparcsn4.road_trucking_companies.trkc_id = sparcsn4.ref_bizunit_scoped.gkey
where sparcsn4.road_trucking_companies.trkc_id=(select distinct trkco_gkey from road_truck_visit_details where truck_id='$row->truck_no' order by tvdtls_gkey desc limit 1) ";
	$querydepresult = mysql_query($querydep);
	$depocont=mysql_fetch_object($querydepresult);
	$offdeo = $depocont->cnt;
		
	
?>
<?php 
if($mlo!=$row->mlo)
{

	if($j>0){
		
		?>
		<tr align="center" >
				<td align="center"><b><?php  echo "Total";?></b></td>
				<td align="center"><?php  echo "&nbsp;";?></td>
				<td align="center"><?php  echo "&nbsp;";?></td>		
				<td align="center"><?php echo "";?></td>
				<td align="center"><?php echo "";?></td>
				<td align="center"><?php echo "";?></td>
				<td align="center"><?php echo "";?></td>
				<td align="center"><?php echo "&nbsp;";?></td>
				<td align="center"><?php echo "";?></td>
				<!--td align="center"><?php echo "&nbsp;";?></td-->
				<!--td align="center"><?php echo "&nbsp;";?></td-->
				<!--td align="center"><b><?php echo "";?></b></td-->
				<!--td align="center"><b><?php echo "";?></b></td-->
				<td align="center"><b><?php echo $weight;?></b></td>
				<!--td align="center"><b><?php echo "" ;?></b></td>
				<td align="center"><b><?php echo "";?></b></td-->
		</tr>
		
	<?php 

	}
	$j=1;
	$weight=$row->weight;

	//$agentVatAmnt=$row->vatTotal;
	//$agentGtAmnt=$row->GT;
	}else{
		$j++;
		$weight=$weight+$row->weight;
		//$agentVatAmnt=$agentVatAmnt+$row->vatTotal;
		//$agentGtAmnt=$agentGtAmnt+$row->GT;
	}
	$mlo=$row->mlo;
	
	?>
<tr align="center">
		<td><?php  echo $i;?></td>
		<td><?php if($row->cont_id) echo $row->cont_id; else echo "&nbsp;";?></td>
		
		<td><?php if($row->size) echo $row->size; else echo "&nbsp;";?></td>
		<td><?php if($row->height) echo $row->height; else echo "&nbsp;";?></td>
		<td><?php if($row->iso) echo $row->iso; else echo "&nbsp;";?></td>
		<td><?php if($row->freight_kind) echo $row->freight_kind; else echo "&nbsp;";?></td>
		
		<td><?php if($row->seal_no) echo $row->seal_no; else echo "&nbsp;";?></td>
		<td><?php if($row->mlo) echo $row->mlo; else echo "&nbsp;";?></td>
		<!--td><?php if($row->craine_id) echo $row->craine_id; else echo "&nbsp;";?></td>
		<td><?php if($row->truck_no) echo $row->truck_no; else echo "&nbsp;";?></td-->
		
		<!--td>
			<?php 
			if($row->truck_no1>0)
			{ 
				echo  "<strong>".strtoupper($row->truck_no). "</strong>";
			}
			elseif($offdeo>0 and $row->truck_no!="")
			{
				echo "Depot";
			}
			else 
			{
				echo "Port";
			}?>
		</td-->
		
		<!--td><?php if($row->stowage_pos) echo $row->stowage_pos; else echo "&nbsp;";?></td-->
		<!--td><?php if($row->pod) echo $row->pod; else echo "&nbsp;";?></td-->
		
		<!--td><?php if($row->berth) echo $row->berth; else echo "&nbsp;";?></td-->
		<td><?php if($row->weight) echo $row->weight; else echo "&nbsp;";?></td>
		<!--td><?php if($row->last_update) echo $row->last_update; else echo "&nbsp;";?></td>
		<td><?php if($row->remark) echo $row->remark;  else echo "&nbsp;";?></td-->
		
		
				
	</tr>

<?php $totWeight = $totWeight + $row->weight; } ?>
	<tr align="center">
			<td align="center"><b><?php  echo "Total";?></b></td>
			<td align="center"><?php  echo "&nbsp;";?></td>
			<td align="center"><?php  echo "&nbsp;";?></td>		
			<td align="center"><b><?php echo "";?></b></td>
			<td align="center"><b><?php echo "";?></b></td>
			<td align="center"><b><?php echo "";?></b></td>
			<td align="center"><b><?php echo "";?></b></td>
			<td align="center"><b><?php echo "&nbsp;";?></b></td>
			<!--td align="center"><b><?php echo "";?></b></td-->
			<!--td align="center"><b><?php echo "&nbsp;";?></b></td-->
			<!--td align="center"><b><?php echo "&nbsp;";?></b></td-->
			<!--td align="center"><b><?php echo "";?></b></td-->
			<td align="center"><b><?php echo $weight;?></b></td>
			<!--td align="center"><b><?php echo "" ;?></b></td>
			<td align="center"><b><?php echo "";?></b></td-->
	</tr>
	</tbody>
</table>
<div class="pageBreak"></div>
<?php } ?>
<br />
<br />


<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
