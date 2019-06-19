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
		header("Content-Disposition: attachment; filename=Reefer_Container.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}
	//$ddl_imp_rot_no=$_REQUEST['ddl_imp_rot_no']; 

	//$con=mysql_connect("10.1.1.21", "sparcsn4","sparcsn4")or die("sparcsn4 database cannot connect"); 
	//mysql_select_db("sparcsn4")or die("cannot select DB");
	include("dbConection.php");
	//echo $todate;

	
		//$col = "date(inv_unit_fcy_visit.flex_date04) BETWEEN '$fromdate' AND '$todate'";		
		//$head = "Delivery Date Wise Import Reefer Container List";
	
	
	?>
<html>
<!--title>Import Reffer Container Discharge List</title-->
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				
				<tr align="center">
					<td align="center" valign="middle" colspan="12"><img align="middle"  width="220px" height="70px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
				</tr>
				<tr align="center">
					<td align="center" valign="middle" colspan="12"><font size="4"><b>Reefer Position of Yard - <?php if($row->creator) echo $row->creator; else echo "&nbsp;";?><?php echo $yard_no;?></b></font></td>
				</tr>
				<tr align="center">
					<td align="center" valign="middle" colspan="12"><font size="4"><b><u>Delivery Date Wise Import Reefer Container List</u></b></font></td>
				</tr>
				<tr align="center">
					<td align="center" valign="middle" colspan="12"><font size="4"><b><u>DATE :</u> <?php
					echo date("d-m-Y", strtotime($fromdate));
					//$test1='$fromdate';
					//echo date('d-m-Y',strtotime($test1));
						?></b></font></td>
				</tr>

			</table>
		
		</td>
		
	</tr>
	
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr>
	</table>
	<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<tr  align="center">
		<td style="border-width:3px;border-style: double;"><b>SlNo.</b></td>
		<td style="border-width:3px;border-style: double;"><b>MLO.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Container No.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Size.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Vessel Name.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Rotation No.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Connection Date & Time.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Disconnection Date & Time.</b></td>
		<!--td style="border-width:3px;border-style: double;"><b>Yard Name.</b></td-->
		<td style="border-width:3px;border-style: double;"><b>User.</b></td>
	</tr>

<?php

if($yard_no=="All")
		{
	$queryAll="select * from
						(
						SELECT gkey,id,rfr_connect,rfr_disconnect,
						(select name from sparcsn4.vsl_vessel_visit_details
						inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
						where vvd_gkey=temp.cvcvd_gkey) as vsl_name,
						(select ib_vyg from sparcsn4.vsl_vessel_visit_details where vvd_gkey=temp.cvcvd_gkey) as vsl_visit_dtls_ib_vyg,
						(select id from sparcsn4.ref_bizunit_scoped where gkey=temp.line_op) as mlo,
						(SELECT sparcsn4.srv_event.creator
						FROM sparcsn4.srv_event
						INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
						WHERE sparcsn4.srv_event.applied_to_gkey=temp.gkey AND sparcsn4.srv_event_field_changes.new_value IS NOT NULL 
						AND sparcsn4.srv_event_field_changes.new_value like'%BDT' and sparcsn4.srv_event.event_type_gkey=4 
						ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1) AS creator,
						(select right(nominal_length,2) from sparcsn4.inv_unit_equip
						inner join sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
						inner join sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey 
						where sparcsn4.inv_unit_equip.unit_gkey=temp.gkey) as size,
						(select substr(ucase(creator),1,3)) as yard
						from
						(
						SELECT sparcsn4.inv_unit.gkey,sparcsn4.inv_unit.id,sparcsn4.inv_unit.line_op,sparcsn4.argo_carrier_visit.cvcvd_gkey,
						inv_unit_fcy_visit.flex_date03 AS rfr_connect, 
						inv_unit_fcy_visit.flex_date04 AS rfr_disconnect
						FROM sparcsn4.inv_unit
						INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey
						inner join sparcsn4.argo_carrier_visit on sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
						WHERE date(inv_unit_fcy_visit.flex_date04) BETWEEN '$fromdate' AND '$todate'    /*Reffer Connection 1*/

						union all

						SELECT inv_unit.gkey,inv_unit.id,sparcsn4.inv_unit.line_op,sparcsn4.argo_carrier_visit.cvcvd_gkey,
						inv_unit_fcy_visit.flex_date05 AS rfr_connect, 
						inv_unit_fcy_visit.flex_date06 AS rfr_disconnect
						FROM sparcsn4.inv_unit
						INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey
						inner join sparcsn4.argo_carrier_visit on sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
						WHERE date(inv_unit_fcy_visit.flex_date06) BETWEEN '$fromdate' AND '$todate'   /*Reffer Connection 2*/

						union all

						SELECT inv_unit.gkey,inv_unit.id,sparcsn4.inv_unit.line_op,sparcsn4.argo_carrier_visit.cvcvd_gkey,
						inv_unit_fcy_visit.flex_date07 AS rfr_connect, 
						inv_unit_fcy_visit.flex_date08 AS rfr_disconnect
						FROM sparcsn4.inv_unit
						INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey
						inner join sparcsn4.argo_carrier_visit on sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
						WHERE date(inv_unit_fcy_visit.flex_date08) BETWEEN '$fromdate' AND '$todate'    /*Reffer Connection 3*/
						) as temp ) as final order by mlo";
			$rtnQueryAll=mysql_query($queryAll);	
								  
		}
		else
		{
			$login_id = $this->session->userdata('login_id');
			$queryAll="select * from
						(
						SELECT gkey,id,rfr_connect,rfr_disconnect,
						(select name from sparcsn4.vsl_vessel_visit_details
						inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
						where vvd_gkey=temp.cvcvd_gkey) as vsl_name,
						(select ib_vyg from sparcsn4.vsl_vessel_visit_details where vvd_gkey=temp.cvcvd_gkey) as vsl_visit_dtls_ib_vyg,
						(select id from sparcsn4.ref_bizunit_scoped where gkey=temp.line_op) as mlo,
						(SELECT sparcsn4.srv_event.creator
						FROM sparcsn4.srv_event
						INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
						WHERE sparcsn4.srv_event.applied_to_gkey=temp.gkey AND sparcsn4.srv_event_field_changes.new_value IS NOT NULL 
						AND sparcsn4.srv_event_field_changes.new_value like'%BDT' and sparcsn4.srv_event.event_type_gkey=4 
						ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1) AS creator,
						(select right(nominal_length,2) from sparcsn4.inv_unit_equip
						inner join sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
						inner join sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey 
						where sparcsn4.inv_unit_equip.unit_gkey=temp.gkey) as size,
						(select substr(ucase(creator),1,3)) as yard
						from
						(
						SELECT sparcsn4.inv_unit.gkey,sparcsn4.inv_unit.id,sparcsn4.inv_unit.line_op,sparcsn4.argo_carrier_visit.cvcvd_gkey,
						inv_unit_fcy_visit.flex_date03 AS rfr_connect, 
						inv_unit_fcy_visit.flex_date04 AS rfr_disconnect
						FROM sparcsn4.inv_unit
						INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey
						inner join sparcsn4.argo_carrier_visit on sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
						WHERE date(inv_unit_fcy_visit.flex_date04) BETWEEN '$fromdate' AND '$todate'    /*Reffer Connection 1*/

						union all

						SELECT inv_unit.gkey,inv_unit.id,sparcsn4.inv_unit.line_op,sparcsn4.argo_carrier_visit.cvcvd_gkey,
						inv_unit_fcy_visit.flex_date05 AS rfr_connect, 
						inv_unit_fcy_visit.flex_date06 AS rfr_disconnect
						FROM sparcsn4.inv_unit
						INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey
						inner join sparcsn4.argo_carrier_visit on sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
						WHERE date(inv_unit_fcy_visit.flex_date06) BETWEEN '$fromdate' AND '$todate'    /*Reffer Connection 2*/

						union all

						SELECT inv_unit.gkey,inv_unit.id,sparcsn4.inv_unit.line_op,sparcsn4.argo_carrier_visit.cvcvd_gkey,
						inv_unit_fcy_visit.flex_date07 AS rfr_connect, 
						inv_unit_fcy_visit.flex_date08 AS rfr_disconnect
						FROM sparcsn4.inv_unit
						INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey
						inner join sparcsn4.argo_carrier_visit on sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
						WHERE date(inv_unit_fcy_visit.flex_date08) BETWEEN '$fromdate' AND '$todate'   /*Reffer Connection 3*/
						) as temp ) as final WHERE yard='$yard_no' order by mlo,rfr_disconnect";
			$rtnQueryAll=mysql_query($queryAll);

		}

	$i=0;
	$j=0;
	
	$mlo="";
	while($row=mysql_fetch_object($rtnQueryAll)){
	$i++;
	
		
	
?>

<tr align="center">
		<td><?php  echo $i;?></td>
		<td><?php if($row->mlo) echo $row->mlo; else echo "&nbsp;";?></td>
		<td><?php if($row->id) echo $row->id; else echo "&nbsp;";?></td>
		<td><?php if($row->size) echo $row->size; else echo "&nbsp;";?></td>
		<td><?php if($row->vsl_name) echo $row->vsl_name; else echo "&nbsp;";?></td>
		<td><?php if($row->vsl_visit_dtls_ib_vyg) echo $row->vsl_visit_dtls_ib_vyg; else echo "&nbsp;";?></td>
		<td><?php if($row->rfr_connect) echo $row->rfr_connect; else echo "&nbsp;";?></td>
		<td><?php if($row->rfr_disconnect) echo $row->rfr_disconnect; else echo "&nbsp;";?></td>
		<!--td><?php if($row->yard) echo $row->yard; else echo "&nbsp;";?></td-->
		<td><?php if($row->creator) echo $row->creator; else echo "&nbsp;";?></td>
	</tr>

<?php } ?>
</table>
<table width="70%" border="1" cellpadding='0' cellspacing='0' align="center">
	<tr  align="center"  ><td  colspan="8" style="border: none; font-size:20px"><b>Total Summary</b></td></tr>
	<tr>
		<td align="center"><b>MLO</b></td>
		<td align="center"><b>AGENT NAME</b></td>
		<td align="center"><b>20 X 8.5</b></td>
		<td align="center"><b>20 X 9.5</b></td>
		<td align="center"><b>40 X 8.5</b></td>
		<td align="center"><b>40 X 9.5</b></td>
		<td align="center"><b>45 X 9.5</b></td>
		<td align="center"><b>TOTAL</b></td>
	</tr>

<?php
	
	$mlo_query_2=mysql_query("SELECT * FROM (SELECT DISTINCT(r.id) AS mlo, Y.id AS agent, Y.name AS agent_name,
	(SELECT sparcsn4.srv_event.creator FROM sparcsn4.srv_event 
	INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
	WHERE sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey AND sparcsn4.srv_event_field_changes.new_value IS NOT NULL
	AND sparcsn4.srv_event_field_changes.new_value LIKE'%BDT' AND sparcsn4.srv_event.event_type_gkey=4
	 ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1) AS creator_name,
	(SELECT SUBSTR(UCASE(creator_name),1,3)) AS yard 
	FROM sparcsn4.inv_unit 
	INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey

	INNER JOIN  ( sparcsn4.ref_bizunit_scoped r  
	LEFT JOIN ( sparcsn4.ref_agent_representation X  
	LEFT JOIN sparcsn4.ref_bizunit_scoped Y ON X.agent_gkey=Y.gkey )               
	ON r.gkey=X.bzu_gkey)  ON r.gkey = sparcsn4.inv_unit.line_op
	WHERE DATE(inv_unit_fcy_visit.flex_date04) BETWEEN '$fromdate' AND '$todate' AND sparcsn4.inv_unit.category='IMPRT') AS tmp
	WHERE yard='$yard_no' order by mlo ");
	$mlo_2=0;	
	while($mlo_row_2=mysql_fetch_object($mlo_query_2)){
	$mlo_2++;

$st="SELECT 
IFNULL(SUM(20_86),0) AS reff_20_86,
IFNULL(SUM(20_96),0) AS reff_20_96, 
IFNULL(SUM(40_86),0) AS reff_40_86,
IFNULL(SUM(40_96),0) AS reff_40_96,
IFNULL(SUM(45_96),0) AS reff_45_96,
IFNULL(SUM(20_86_mty),0) AS reff_20_86_mty, 
IFNULL(SUM(20_96_mty),0) AS reff_20_96_mty,
IFNULL(SUM(40_86_mty),0) AS reff_40_86_mty, 
IFNULL(SUM(40_96_mty),0) AS reff_40_96_mty 
FROM (

SELECT (CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' 
AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' AND freight_kind IN ('FCL','LCL') 
THEN 1 ELSE NULL END) AS 20_86, 
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' 
AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='96' AND freight_kind IN ('FCL','LCL') 
THEN 1 ELSE NULL END) AS 20_96,
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) > '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' 
AND freight_kind IN ('FCL','LCL') THEN 1 ELSE NULL END) AS 40_86,
 
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) > '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='96'
AND freight_kind IN ('FCL','LCL') THEN 1 ELSE NULL END) AS 40_96,

(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) > '40' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='96'
AND freight_kind IN ('FCL','LCL') THEN 1 ELSE NULL END) AS 45_96,
 
 
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' 
AND freight_kind='MTY' THEN 1 ELSE NULL END) AS 20_86_mty,
 (CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' 
AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='96' AND freight_kind='MTY' THEN 1 ELSE NULL END) AS 20_96_mty,
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) > '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86'
AND freight_kind='MTY' THEN 1 ELSE NULL END) AS 40_86_mty, 
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) > '20'
AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='96' AND freight_kind='MTY' THEN 1 ELSE NULL END) AS 40_96_mty, 

(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2)=20 AND freight_kind IN ('FCL','LCL') 
THEN 1 ELSE (CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2)>20 AND freight_kind IN ('FCL','LCL') THEN 2 ELSE NULL END) END) AS onboard_LD_tues,
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2)=20 AND freight_kind='MTY' THEN 1
ELSE (CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2)>20 AND freight_kind='MTY' THEN 2 ELSE NULL END) END) AS onboard_MT_tues,
(SELECT sparcsn4.srv_event.creator FROM sparcsn4.srv_event 
INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
WHERE sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey AND sparcsn4.srv_event_field_changes.new_value IS NOT NULL
AND sparcsn4.srv_event_field_changes.new_value LIKE'%BDT' AND sparcsn4.srv_event.event_type_gkey=4
 ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1) AS creator_name,
(SELECT SUBSTR(UCASE(creator_name),1,3)) AS yard 
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
WHERE DATE(inv_unit_fcy_visit.flex_date04) BETWEEN '$fromdate' AND '$todate' AND sparcsn4.inv_unit.category='IMPRT'
AND r.id ='$mlo_row_2->mlo' 
) AS tmp WHERE yard='$yard_no'";

//echo $st;
$summary_query_2=mysql_query($st);
$sum=0;	
while($summary_row_2=mysql_fetch_object($summary_query_2)){
$sum++;

?>

	<tr>
		<td align="center"><?php echo $mlo_row_2->mlo; ?></td>
		<td align="left"><?php echo $mlo_row_2->agent.'-'.$mlo_row_2->agent_name; ?></td>
		<td align="center"><?php echo $summary_row_2->reff_20_86; ?></td>
		<td align="center"><?php echo $summary_row_2->reff_20_96; ?></td>
		<td align="center"><?php echo $summary_row_2->reff_40_86; ?></td>
		<td align="center"><?php echo $summary_row_2->reff_40_96; ?></td>
		<td align="center"><?php echo $summary_row_2->reff_45_96; ?></td>
		<td align="center"><?php echo $summary_row_2->reff_20_86 + $summary_row_2->reff_20_96 + $summary_row_2->reff_40_86 + $summary_row_2->reff_40_96 + $summary_row_2->reff_45_96 ; ?></td>
	</tr>

	
	<?php } ?>
	<br />
	<?php } ?>
</table>

<br />
<br />



<?php 
mysql_close($con);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
