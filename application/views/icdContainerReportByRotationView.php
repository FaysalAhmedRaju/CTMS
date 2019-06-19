<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>ICD Container Report</TITLE>
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
		header("Content-Disposition: attachment; filename=ICD_Container_Summary.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}
$ddl_imp_rot_no=$_REQUEST['ddl_imp_rot_no']; 

	include("dbConection.php");
	

	?>
<html>
<title>Import Container Discharge List</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				
				
				<tr align="center">
					<td><img align="middle"  width="235px" height="80x" src="<?php echo IMG_PATH?>cpanew.jpg"></td></tr>
			
				<tr align="center">
					<td colspan="10"><font size="4"><b>ICD CONTAINER REPORT</b></font></td>
				</tr>
				<tr align="center">
					<td colspan="10"><font size="4"><b></b></font></td>
				</tr>

				<tr>
					<td colspan="10" align="center"><font size="4"><b>Rotation: <?php  echo $ddl_imp_rot_no;?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Vessel: <?php  echo $vsselName[0]['vsl_name'];?></b></font></td>					
				</tr>

			</table>
		
		</td>
		
	</tr>
	
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="10" align="center"></td>
		
	</tr>
<?php
	
	$mlo_query=mysql_query("SELECT  DISTINCT (sparcsn4.ref_bizunit_scoped.id), Y.id AS agent
FROM sparcsn4.inv_unit 
INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.unit_gkey=inv_unit.gkey
INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit.gkey=sparcsn4.inv_unit_fcy_visit.unit_gkey 
INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.inv_unit_fcy_visit.actual_ib_cv=sparcsn4.argo_carrier_visit.gkey
INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.inv_unit.line_op
INNER JOIN  ( sparcsn4.ref_bizunit_scoped r  
LEFT JOIN ( sparcsn4.ref_agent_representation X  
LEFT JOIN sparcsn4.ref_bizunit_scoped Y ON X.agent_gkey=Y.gkey )               
ON r.gkey=X.bzu_gkey)  ON r.gkey = sparcsn4.inv_unit.line_op
INNER JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
WHERE sparcsn4.vsl_vessel_visit_details.ib_vyg='$ddl_imp_rot_no' AND inv_goods.destination=2592 AND inv_unit_equip.eq_role='PRIMARY'
ORDER BY ref_bizunit_scoped.id ASC");
	$mlo=0;	
	while($mlo_row=mysql_fetch_object($mlo_query)){
	$mlo++;

?>
	<table width="85%" cellpadding='0' cellspacing='0' align="center">
		<tr height="25px">
			<td colspan="10" align="left"><?php echo "MLO:   <b>".$mlo_row->id."</b> &nbsp;&nbsp;&nbsp;AGENT CODE:  <b>".$mlo_row->agent."<b>";  ?></td>
		</tr>
	</table>
	
	<table width="85%" border ='1' cellpadding='0' cellspacing='0' align="center">
	<tr align="center">
		<td style="border-width:3px;border-style: double;"><b>SlNo.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Container No.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Size.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Height.</b></td>
		<!--td style="border-width:3px;border-style: double;"><b>MLO</b></td-->
		<td style="border-width:3px;border-style: double;"><b>Category</b></td>		
		<td style="border-width:3px;border-style: double;"><b>Time in</b></td>
		<td style="border-width:3px;border-style: double;"><b>Time out</b></td>

	</tr>

<?php
	
	$query=mysql_query("SELECT sparcsn4.inv_unit.gkey, sparcsn4.inv_unit.id as cont, sparcsn4.ref_bizunit_scoped.id as mlo, inv_unit_fcy_visit.time_in,
	inv_unit_fcy_visit.time_out, inv_goods.destination,category, freight_kind,
RIGHT(sparcsn4.ref_equip_type.nominal_length,2) AS size,
RIGHT(sparcsn4.ref_equip_type.nominal_height,2) AS height
FROM sparcsn4.inv_unit 
INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.unit_gkey=inv_unit.gkey
INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit.gkey=sparcsn4.inv_unit_fcy_visit.unit_gkey 
INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.inv_unit_fcy_visit.actual_ib_cv=sparcsn4.argo_carrier_visit.gkey
INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.inv_unit.line_op
INNER JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
WHERE sparcsn4.vsl_vessel_visit_details.ib_vyg='$ddl_imp_rot_no' AND inv_goods.destination=2592 AND inv_unit_equip.eq_role='PRIMARY' and ref_bizunit_scoped.id ='$mlo_row->id'");
	$i=0;	
	while($row=mysql_fetch_object($query)){
	$i++;

?>
<tr align="center">
		<td><?php  echo $i;?></td>
		<td><?php if($row->cont) echo $row->cont; else echo "&nbsp;";?></td>
		<td><?php if($row->size) echo $row->size; else echo "&nbsp;";?></td>
		<td><?php if($row->height) echo $row->height; else echo "&nbsp;";?></td>
		<!--td><?php if($row->mlo) echo $row->mlo; else echo "&nbsp;";?></td-->
		<td><?php if($row->freight_kind) echo $row->freight_kind; else echo "&nbsp;";?></td>
		<td><?php if($row->time_in) echo $row->time_in; else echo "&nbsp;";?></td>
		<td><?php if($row->time_out) echo $row->time_out; else echo "&nbsp;";?></td>
</tr>

<?php } ?>
</table>
<?php
	
$summary_query=mysql_query("SELECT
IFNULL(SUM(20_86),0) AS icd_20_86,
IFNULL(SUM(20_96),0) AS icd_20_96,
IFNULL(SUM(40_86),0) AS icd_40_86,
IFNULL(SUM(40_96),0) AS icd_40_96,

IFNULL(SUM(20_86_mty),0) AS icd_20_86_mty,
IFNULL(SUM(20_96_mty),0) AS icd_20_96_mty,
IFNULL(SUM(40_86_mty),0) AS icd_40_86_mty,
IFNULL(SUM(40_96_mty),0) AS icd_40_96_mty

FROM (SELECT 

(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' AND freight_kind IN ('FCL','LCL')  THEN 1  
ELSE NULL END) AS 20_86, 
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='96' AND freight_kind IN ('FCL','LCL')  THEN 1  
ELSE NULL END) AS 20_96,
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) > '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' AND freight_kind IN ('FCL','LCL')  THEN 1  
ELSE NULL END) AS 40_86,
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) > '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='96' AND freight_kind IN ('FCL','LCL')  THEN 1  
ELSE NULL END) AS 40_96, 

(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' AND freight_kind='MTY'  THEN 1  
ELSE NULL END) AS 20_86_mty, 
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='96' AND freight_kind='MTY'  THEN 1  
ELSE NULL END) AS 20_96_mty,
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) > '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' AND freight_kind='MTY'  THEN 1  
ELSE NULL END) AS 40_86_mty,
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) > '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='96' AND freight_kind='MTY'  THEN 1  
ELSE NULL END) AS 40_96_mty, 

(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2)=20 AND freight_kind IN ('FCL','LCL') THEN 1 
ELSE (CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2)>20 AND freight_kind IN ('FCL','LCL') THEN 2 ELSE NULL END) END) AS onboard_LD_tues, 
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2)=20 AND freight_kind='MTY' THEN 1 
ELSE (CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2)>20 AND freight_kind='MTY' THEN 2 ELSE NULL END) END) AS onboard_MT_tues

FROM sparcsn4.inv_unit 
INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.unit_gkey=inv_unit.gkey
INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit.gkey=sparcsn4.inv_unit_fcy_visit.unit_gkey 
INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.inv_unit_fcy_visit.actual_ib_cv=sparcsn4.argo_carrier_visit.gkey
INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.inv_unit.line_op
INNER JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
WHERE sparcsn4.vsl_vessel_visit_details.ib_vyg='$ddl_imp_rot_no' AND ref_bizunit_scoped.id ='$mlo_row->id' AND inv_goods.destination=2592 AND inv_unit_equip.eq_role='PRIMARY') AS tmp");
	$sum=0;	
	while($summary_row=mysql_fetch_object($summary_query)){
	$sum++;

?>
	<table width="50%"   cellpadding='0' cellspacing='0' align="center">
	<tr height="25px">
		<td colspan="7" align="left"><?php echo "Summary: "?></td>
	</tr>


	<tr>
		<td align="center"></td>
		<td align="center">20 X 8.5</td>
		<td align="center">20 X 9.5</td>
		<td align="center">40 X 8.5</td>
		<td align="center">40 X 9.5</td>
		<td align="center">TOTAL</td>
	</tr>
	<tr>
		<td align="center">FCL</td>
		<td align="center"><?php echo $summary_row->icd_20_86; ?></td>
		<td align="center"><?php echo $summary_row->icd_20_96; ?></td>
		<td align="center"><?php echo $summary_row->icd_40_86; ?></td>
		<td align="center"><?php echo $summary_row->icd_40_96; ?></td>
		<td align="center"><?php echo $summary_row->icd_20_86 + $summary_row->icd_20_96 + $summary_row->icd_40_86 + $summary_row->icd_40_96 ?></td>
	</tr>
	<tr height="25px">
		<td align="center">EMPTY</td>
		<td align="center"><?php echo $summary_row->icd_20_86_mty; ?></td>
		<td align="center"><?php echo $summary_row->icd_20_96_mty; ?></td>
		<td align="center"><?php echo $summary_row->icd_40_86_mty; ?></td>
		<td align="center"><?php echo $summary_row->icd_40_96_mty; ?></td>
		<td align="center"><?php echo $summary_row->icd_20_86_mty + $summary_row->icd_20_96_mty + $summary_row->icd_40_86_mty + $summary_row->icd_40_96_mty; ?></td>
	</tr>
	</table>	
	
	<?php } ?>
	<br />
	<?php } ?>

</table>

<table width="70%" border="1" cellpadding='0' cellspacing='0' align="center">
	<tr  align="center"  ><td  colspan="7" style="border: none; font-size:20px"><b>Total Summary</b></td></tr>
	<tr>
		<td align="center"><b>MLO</b></td>
		<td align="center"><b>AGENT NAME</b></td>
		<td align="center"><b>20 X 8.5</b></td>
		<td align="center"><b>20 X 9.5</b></td>
		<td align="center"><b>40 X 8.5</b></td>
		<td align="center"><b>40 X 9.5</b></td>
		<td align="center"><b>TOTAL</b></td>
	</tr>

<?php
	
	$mlo_query_2=mysql_query("SELECT DISTINCT(r.id), Y.id AS agent, Y.name AS agent_name
FROM sparcsn4.inv_unit 
INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.unit_gkey=inv_unit.gkey
INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit.gkey=sparcsn4.inv_unit_fcy_visit.unit_gkey 
INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.inv_unit_fcy_visit.actual_ib_cv=sparcsn4.argo_carrier_visit.gkey
INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
INNER JOIN  ( sparcsn4.ref_bizunit_scoped r  
LEFT JOIN ( sparcsn4.ref_agent_representation X  
LEFT JOIN sparcsn4.ref_bizunit_scoped Y ON X.agent_gkey=Y.gkey )               
ON r.gkey=X.bzu_gkey)  ON r.gkey = sparcsn4.inv_unit.line_op
INNER JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
WHERE sparcsn4.vsl_vessel_visit_details.ib_vyg='$ddl_imp_rot_no' AND inv_goods.destination=2592 AND inv_unit_equip.eq_role='PRIMARY'");
	$mlo_2=0;	
	while($mlo_row_2=mysql_fetch_object($mlo_query_2)){
	$mlo_2++;


$summary_query_2=mysql_query("SELECT
IFNULL(SUM(20_86),0) AS icd_20_86,
IFNULL(SUM(20_96),0) AS icd_20_96,
IFNULL(SUM(40_86),0) AS icd_40_86,
IFNULL(SUM(40_96),0) AS icd_40_96,

IFNULL(SUM(20_86_mty),0) AS icd_20_86_mty,
IFNULL(SUM(20_96_mty),0) AS icd_20_96_mty,
IFNULL(SUM(40_86_mty),0) AS icd_40_86_mty,
IFNULL(SUM(40_96_mty),0) AS icd_40_96_mty

FROM (SELECT 

(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' AND freight_kind IN ('FCL','LCL')  THEN 1  
ELSE NULL END) AS 20_86, 
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='96' AND freight_kind IN ('FCL','LCL')  THEN 1  
ELSE NULL END) AS 20_96,
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) > '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' AND freight_kind IN ('FCL','LCL')  THEN 1  
ELSE NULL END) AS 40_86,
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) > '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='96' AND freight_kind IN ('FCL','LCL')  THEN 1  
ELSE NULL END) AS 40_96, 

(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' AND freight_kind='MTY'  THEN 1  
ELSE NULL END) AS 20_86_mty, 
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='96' AND freight_kind='MTY'  THEN 1  
ELSE NULL END) AS 20_96_mty,
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) > '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' AND freight_kind='MTY'  THEN 1  
ELSE NULL END) AS 40_86_mty,
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) > '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='96' AND freight_kind='MTY'  THEN 1  
ELSE NULL END) AS 40_96_mty, 

(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2)=20 AND freight_kind IN ('FCL','LCL') THEN 1 
ELSE (CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2)>20 AND freight_kind IN ('FCL','LCL') THEN 2 ELSE NULL END) END) AS onboard_LD_tues, 
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2)=20 AND freight_kind='MTY' THEN 1 
ELSE (CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2)>20 AND freight_kind='MTY' THEN 2 ELSE NULL END) END) AS onboard_MT_tues

FROM sparcsn4.inv_unit 
INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.unit_gkey=inv_unit.gkey
INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit.gkey=sparcsn4.inv_unit_fcy_visit.unit_gkey 
INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.inv_unit_fcy_visit.actual_ib_cv=sparcsn4.argo_carrier_visit.gkey
INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.inv_unit.line_op
INNER JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
WHERE sparcsn4.vsl_vessel_visit_details.ib_vyg='$ddl_imp_rot_no' AND ref_bizunit_scoped.id ='$mlo_row_2->id' AND inv_goods.destination=2592 AND inv_unit_equip.eq_role='PRIMARY') AS tmp");
	$sum=0;	
	while($summary_row_2=mysql_fetch_object($summary_query_2)){
	$sum++;

?>

	<tr>
		<td align="center"><?php echo $mlo_row_2->id; ?></td>
		<td align="center"><?php echo $mlo_row_2->agent_name; ?></td>
		<td align="center"><?php echo $summary_row_2->icd_20_86; ?></td>
		<td align="center"><?php echo $summary_row_2->icd_20_96; ?></td>
		<td align="center"><?php echo $summary_row_2->icd_40_86; ?></td>
		<td align="center"><?php echo $summary_row_2->icd_40_96; ?></td>
		<td align="center"><?php echo $summary_row_2->icd_20_86 + $summary_row_2->icd_20_96 + $summary_row_2->icd_40_86 + $summary_row_2->icd_40_96 ?></td>
	</tr>

	
	<?php } ?>
	<br />
	<?php } ?>
</table>		
<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
