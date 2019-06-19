<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>Bearth Operator</TITLE>
		<LINK href="../css/report.css" type=text/css rel=stylesheet>
	    <style type="text/css">
<!--
.style1 {font-size: 12px}
-->
        </style>
</HEAD>
<BODY>

	<?php } 
	else if($_POST['options']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=IMPORT_SUMMERY.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}
//$ddl_imp_rot_no=$_REQUEST['ddl_imp_rot_no']; 

	include("dbConection.php");
	
	$sql=mysql_query("select vvd_gkey from sparcsn4.vsl_vessel_visit_details where ib_vyg='$ddl_imp_rot_no'");
	$row=mysql_fetch_object($sql);
	$vvdGkey=$row->vvd_gkey;
	
	$sql="call ctmsmis.update_containers_by_vvd_gkey($vvdGkey)";
	$res=mysql_query($sql);
	//echo$vvdGkey;
	$sql1=mysql_query("select vsl_vessels.name as vsl_name,ifnull(sparcsn4.vsl_vessel_visit_details.flex_string02,
	ifnull(sparcsn4.vsl_vessel_visit_details.flex_string03,'')) as berth_op,ifnull(sparcsn4.argo_quay.id,'') as berth,DATE(sparcsn4.vsl_vessel_visit_details.published_eta) AS ata,
	sparcsn4.argo_carrier_visit.atd from vsl_vessel_visit_details
inner join sparcsn4.argo_carrier_visit on sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
inner join sparcsn4.vsl_vessel_berthings on sparcsn4.vsl_vessel_berthings.vvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
inner join sparcsn4.argo_quay on sparcsn4.argo_quay.gkey=sparcsn4.vsl_vessel_berthings.quay
where vsl_vessel_visit_details.vvd_gkey=$vvdGkey");
	$row1=mysql_fetch_object($sql1);
	
	?>
<html>
<title>Import Container Discharge List</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				
				
				<tr align="center">
					<td colspan="13"><font size="4"><b>CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td>
				</tr>
			
				<tr align="center">
					<td colspan="12"><font size="4"><b><u>Import Container Discharging Report</u></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b></b></font></td>
				</tr>

				<tr>
					<td colspan="3" align="center"><font size="4"><b> <?php  Echo $row1->vsl_name;?></b></font></td>
					<td colspan="3" align="center"><font size="4"><b>Voy: <?php  Echo $voysNo;?></b></font></td>
					<td colspan="3" align="center"><font size="4"><b>Imp.Rot No.: <?php  Echo $ddl_imp_rot_no;?></b></font></td>
					<td colspan="0" align="center"><font size="4"><b>ETA :-<?php  Echo $row1->ata;?></b></font></td>
					
				</tr>

			</table>
		
		</td>
		
	</tr>
	
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr>
	</table>
	<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<tr  bgcolor="#aaffff" ><td colspan="13"><b>IMPORT CONTAINER BALANCE ON BOARD LIST:<b></td></tr>
	<tr align="center">
		<td style="border-width:3px;border-style: double;"><b>SlNo.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Container No.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Discharge Time.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Location.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Seal No</b></td>
		<td style="border-width:3px;border-style: double;"><b>Type</b></td>
		<td style="border-width:3px;border-style: double;"><b>MLO</b></td>
		<td style="border-width:3px;border-style: double;"><b>Status</b></td>		
		<td style="border-width:3px;border-style: double;"><b>Weight</b></td>
		<td style="border-width:3px;border-style: double;"><b>IMCO</b></td>
		<td style="border-width:3px;border-style: double;"><b>Commodity</b></td>
		<td style="border-width:3px;border-style: double;"><b>Remarks</b></td>
		<td style="border-width:3px;border-style: double;"><b>User Id</b></td>
		
	</tr>

<?php
	
	
	$query=mysql_query("SELECT CONCAT(SUBSTRING(sparcsn4.inv_unit.id,1,4),' ',SUBSTRING(sparcsn4.inv_unit.id,5)) AS id,sparcsn4.inv_unit_fcy_visit.time_in AS fcy_time_in,
sparcsn4.inv_unit_fcy_visit.last_pos_slot AS location,sparcsn4.inv_unit.seal_nbr1 AS sealno,
sparcsn4.ref_equip_type.id AS iso,sparcsn4.ref_bizunit_scoped.id AS mlo,sparcsn4.inv_unit.freight_kind,sparcsn4.inv_unit.goods_and_ctr_wt_kg AS weight,
ref_commodity.short_name,sparcsn4.inv_unit.remark
FROM  sparcsn4.inv_unit 
INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
LEFT JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
LEFT JOIN sparcsn4.ref_commodity ON sparcsn4.ref_commodity.gkey=sparcsn4.inv_goods.commodity_gkey
INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.inv_unit.line_op
WHERE sparcsn4.vsl_vessel_visit_details.vvd_gkey='$vvdGkey' AND category='IMPRT' AND sparcsn4.inv_unit_fcy_visit.transit_state='S20_INBOUND'");
	$i=0;
	$j=0;
	
	$mlo="";
	while($row=mysql_fetch_object($query)){
	$i++;
	
		
	
?>
<tr align="center">
		<td><?php  echo $i;?></td>
		<td><?php if($row->id) echo $row->id; else echo "&nbsp;";?></td>
		<td><?php if($row->fcy_time_in) echo $row->fcy_time_in; else echo "&nbsp;";?></td>
		<td><?php if($row->location) echo $row->location; else echo "&nbsp;";?></td>
		<td><?php if($row->sealno) echo $row->sealno; else echo "&nbsp;";?></td>
		<td><?php if($row->iso) echo $row->iso; else echo "&nbsp;";?></td>
		<td><?php if($row->mlo) echo $row->mlo; else echo "&nbsp;";?></td>
		<td><?php if($row->freight_kind) echo $row->freight_kind; else echo "&nbsp;";?></td>
		<td><?php if($row->weight) echo $row->weight; else echo "&nbsp;";?></td>
		<td><?php  echo "&nbsp;";?></td>
		<td><?php if($row->short_name) echo $row->short_name; else echo "&nbsp;";?></td>
		<td><?php echo "&nbsp;";?></td>
		<td><?php if($row->user_id) echo $row->user_id; else echo "&nbsp;";?></td>
				
	</tr>

<?php } ?>
</table>
<br />
<br />

<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
<tr  bgcolor="#aaffff"><td colspan="13"><b>IMPORT CONTAINER DISCHARGED LIST:<b></td></tr>
	<tr align="center">
		<td style="border-width:3px;border-style: double;"><b>SlNo.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Container No.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Discharge Time.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Location.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Seal No</b></td>
		<td style="border-width:3px;border-style: double;"><b>Type</b></td>
		<td style="border-width:3px;border-style: double;"><b>MLO</b></td>
		<td style="border-width:3px;border-style: double;"><b>Status</b></td>		
		<td style="border-width:3px;border-style: double;"><b>Weight</b></td>
		<td style="border-width:3px;border-style: double;"><b>IMCO</b></td>
		<td style="border-width:3px;border-style: double;"><b>Commodity</b></td>
		<td style="border-width:3px;border-style: double;"><b>Remarks</b></td>
		<td style="border-width:3px;border-style: double;"><b>User Id</b></td>
		
	</tr>

<?php
	
	
	$query=mysql_query("SELECT CONCAT(SUBSTRING(sparcsn4.inv_unit.id,1,4),' ',SUBSTRING(sparcsn4.inv_unit.id,5)) AS id,sparcsn4.inv_unit_fcy_visit.time_in AS fcy_time_in,
sparcsn4.inv_unit_fcy_visit.last_pos_slot AS location,sparcsn4.inv_unit.seal_nbr1 AS sealno,
sparcsn4.ref_equip_type.id AS iso,sparcsn4.ref_bizunit_scoped.id AS mlo,sparcsn4.inv_unit.freight_kind,sparcsn4.inv_unit.goods_and_ctr_wt_kg AS weight,
ref_commodity.short_name,sparcsn4.inv_unit.remark
FROM  sparcsn4.inv_unit 
INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
LEFT JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
LEFT JOIN sparcsn4.ref_commodity ON sparcsn4.ref_commodity.gkey=sparcsn4.inv_goods.commodity_gkey
INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.inv_unit.line_op
WHERE sparcsn4.vsl_vessel_visit_details.vvd_gkey='$vvdGkey' AND category='IMPRT' AND sparcsn4.inv_unit_fcy_visit.time_in IS NOT NULL");
	$i=0;
	$j=0;
	
	$mlo="";
	while($row=mysql_fetch_object($query)){
	$i++;
	
		
	
?>
<tr align="center">
		<td><?php  echo $i;?></td>
		<td><?php if($row->id) echo $row->id; else echo "&nbsp;";?></td>
		<td><?php if($row->fcy_time_in) echo $row->fcy_time_in; else echo "&nbsp;";?></td>
		<td><?php if($row->location) echo $row->location; else echo "&nbsp;";?></td>
		<td><?php if($row->sealno) echo $row->sealno; else echo "&nbsp;";?></td>
		<td><?php if($row->iso) echo $row->iso; else echo "&nbsp;";?></td>
		<td><?php if($row->mlo) echo $row->mlo; else echo "&nbsp;";?></td>
		<td><?php if($row->freight_kind) echo $row->freight_kind; else echo "&nbsp;";?></td>
		<td><?php if($row->weight) echo $row->weight; else echo "&nbsp;";?></td>
		<td><?php  echo "&nbsp;";?></td>
		<td><?php if($row->short_name) echo $row->short_name; else echo "&nbsp;";?></td>
		<td><?php echo "&nbsp;";?></td>
		<td><?php if($row->user_id) echo $row->user_id; else echo "&nbsp;";?></td>
				
	</tr>

<?php } ?>
</table>
<br />
<br />


<?php
	$sqlSummery=mysql_query("SELECT gkey,
IFNULL(SUM(onboard_LD_20),0) AS onboard_LD_20,
IFNULL(SUM(onboard_LD_40),0) AS onboard_LD_40,
IFNULL(SUM(onboard_MT_20),0) AS onboard_MT_20,
IFNULL(SUM(onboard_MT_40),0) AS onboard_MT_40,
IFNULL(SUM(onboard_LD_tues),0) AS onboard_LD_tues,
IFNULL(SUM(onboard_MT_tues),0) AS onboard_MT_tues

 FROM (
SELECT DISTINCT sparcsn4.inv_unit.gkey AS gkey,
(CASE WHEN RIGHT(nominal_length,2) = 'NOM20' AND freight_kind IN ('FCL','LCL')  THEN 1  
ELSE NULL END) AS onboard_LD_20, 
(CASE WHEN RIGHT(nominal_length,2) > '20' AND freight_kind IN ('FCL','LCL')  THEN 1  
ELSE NULL END) AS onboard_LD_40,
(CASE WHEN RIGHT(nominal_length,2) = '20' AND freight_kind ='MTY'  THEN 1  
ELSE NULL END) AS onboard_MT_20, 
(CASE WHEN RIGHT(nominal_length,2) > '20' AND freight_kind ='MTY'  THEN 1  
ELSE NULL END) AS onboard_MT_40, 
(CASE WHEN RIGHT(nominal_length,2)=20 AND freight_kind IN ('FCL','LCL') THEN 1 
ELSE (CASE WHEN RIGHT(nominal_length,2)>20 AND freight_kind IN ('FCL','LCL') THEN 2 ELSE NULL END) END) AS onboard_LD_tues, 
(CASE WHEN RIGHT(nominal_length,2)=20 AND freight_kind='MTY' THEN 1 
ELSE (CASE WHEN RIGHT(nominal_length,5)>20 AND freight_kind='MTY' THEN 2 ELSE NULL END) END) AS onboard_MT_tues

FROM sparcsn4.inv_unit
INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
WHERE  sparcsn4.vsl_vessel_visit_details.vvd_gkey='$vvdGkey' AND category='IMPRT' AND sparcsn4.inv_unit_fcy_visit.transit_state ='S20_INBOUND'
) AS tmp");
$rowSummery=mysql_fetch_object($sqlSummery);


$sqlSummery2=mysql_query("SELECT gkey,
IFNULL(SUM(balance_LD_20),0) AS balance_LD_20,
IFNULL(SUM(balance_LD_40),0) AS balance_LD_40,
IFNULL(SUM(balance_MT_20),0) AS balance_MT_20,
IFNULL(SUM(balance_MT_40),0) AS balance_MT_40,
IFNULL(SUM(balance_LD_tues),0) AS balance_LD_tues,
IFNULL(SUM(balance_MT_tues),0) AS balance_MT_tues

 FROM (
SELECT DISTINCT sparcsn4.inv_unit.gkey AS gkey,
(CASE WHEN RIGHT(nominal_length,2) = '20' AND freight_kind IN ('FCL','LCL')  THEN 1  
ELSE NULL END) AS balance_LD_20, 
(CASE WHEN RIGHT(nominal_length,2) > '20' AND freight_kind IN ('FCL','LCL')  THEN 1  
ELSE NULL END) AS balance_LD_40,
(CASE WHEN RIGHT(nominal_length,2) = '20' AND freight_kind ='MTY'  THEN 1  
ELSE NULL END) AS balance_MT_20, 
(CASE WHEN RIGHT(nominal_length,2) > '20' AND freight_kind ='MTY'  THEN 1  
ELSE NULL END) AS balance_MT_40, 
(CASE WHEN RIGHT(nominal_length,2) = 20 AND freight_kind IN ('FCL','LCL') THEN 1 
ELSE (CASE WHEN RIGHT(nominal_length,2) > 20 AND freight_kind IN ('FCL','LCL') THEN 2 ELSE NULL END) END) AS balance_LD_tues, 
(CASE WHEN RIGHT(nominal_length,2) = 20 AND freight_kind='MTY' THEN 1 
ELSE (CASE WHEN RIGHT(nominal_length,2) > 20 AND freight_kind='MTY' THEN 2 ELSE NULL END) END) AS balance_MT_tues

FROM  sparcsn4.inv_unit 
INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
LEFT JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
LEFT JOIN sparcsn4.ref_commodity ON sparcsn4.ref_commodity.gkey=sparcsn4.inv_goods.commodity_gkey
INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.inv_unit.line_op
WHERE sparcsn4.vsl_vessel_visit_details.vvd_gkey='$vvdGkey' AND category='IMPRT' AND sparcsn4.inv_unit_fcy_visit.transit_state !='S20_INBOUND') AS tmp
");

$rowSummery2=mysql_fetch_object($sqlSummery2);
?>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr><td colspan="12" align="center"><font size="4"><b><u>Import Summery Report</u></b></font></td></tr>
<tr><td colspan="12" align="center"><font size="4"><b>&nbsp;</b></font></td></tr>
</table>
<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<tr>
		<td colspan="6" align="center">DISCHARGED</td>
		<td colspan="6" align="center">BALANCE ON BOARD</td>
	</tr>
	<tr>
		<td colspan="2" align="center">LADEN</td>
		<td colspan="2" align="center">EMPTY</td>
		<td colspan="2" align="center">TUES</td>
		<td colspan="2" align="center">LADEN</td>
		<td colspan="2" align="center">EMPTY</td>
		<td colspan="2" align="center">TUES</td>
		
	</tr>
	<tr>
		<td align="center">20</td>
		<td align="center">40</td>
		<td align="center">20</td>
		<td align="center">40</td>
		<td align="center">LD</td>
		<td align="center">MT</td>
		<td align="center">20</td>
		<td align="center">40</td>
		<td align="center">20</td>
		<td align="center">40</td>
		<td align="center">LD</td>
		<td align="center">MT</td>
	</tr>
	<tr>
		
	
		<td align="center"><?php if($rowSummery2->balance_LD_20) echo $rowSummery2->balance_LD_20; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery2->balance_LD_40) echo $rowSummery2->balance_LD_40; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery2->balance_MT_20) echo $rowSummery2->balance_MT_20; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery2->balance_MT_40) echo $rowSummery2->balance_MT_40; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery2->balance_LD_tues) echo $rowSummery2->balance_LD_tues; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery2->balance_MT_tues) echo $rowSummery2->balance_MT_tues; else echo "&nbsp;"; ?></td>
		
		<td align="center"><?php if($rowSummery->onboard_LD_20) echo $rowSummery->onboard_LD_20; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery->onboard_LD_40) echo $rowSummery->onboard_LD_40; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery->onboard_MT_20) echo $rowSummery->onboard_MT_20; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery->onboard_MT_40) echo $rowSummery->onboard_MT_40; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery->onboard_LD_tues) echo $rowSummery->onboard_LD_tues; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery->onboard_MT_tues) echo $rowSummery->onboard_MT_tues; else echo "&nbsp;"; ?></td>

		
	</tr>
</table>
<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
