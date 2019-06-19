<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>Import Container Discharge</TITLE>
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
		header("Content-Disposition: attachment; filename=IMPORT_DISCHARGE/$ddl_imp_rot_no.xls;");
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
	
	?>
<html>
<title>Import Container Discharge List</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table align="left" width="40%">
				
				
			
			
				<tr align="center">
					<td></td>
					<td></td>
					<td align="center" style="border:1px solid black;"><font size="4"><b>Import Discharge</b></font></td>
				</tr>
				<tr>
				<td></td>
				<td></td>
				<td align="left" style="border:1px solid black;" ><font size="4"><b>Rotation</b></font></td>
				<td align="left" bgcolor="yellow" style="border:1px solid black;"><font size="4"><b><?php  Echo $ddl_imp_rot_no;?></b></font></td>
				<td align="left" style="border:1px solid black;"><font size="4"><b> Vessel</b></font></td>
				<td align="left" bgcolor="yellow" style="border:1px solid black;"><font size="4"><b> <?php  Echo $row1->vsl_name;?></b></font></td>
				</tr>
				<tr>
				<td></td>
				<td></td>
				<td align="left" style="border:1px solid black;"><font size="4"><b>Sheet</b></font></td>
				<td align="left" bgcolor="yellow" style="border:1px solid black;"><font size="4"><b><?php  Echo "$nbsp";?></b></font></td>
				</tr>
				<tr>
				<td></td>
				<td></td>
				<td align="left" style="border:1px solid black;"><font size="4"><b>Shift</b></font></td>
				<td align="left" bgcolor="yellow" style="border:1px solid black;"><font size="4"><b><?php  Echo "$nbsp";?></b></font></td>
				<td align="left" bgcolor="yellow" style="border:1px solid black;" ><font size="4"><b><?php  Echo $fromdate;?></b></font></td>
				<td align="left" bgcolor="yellow" style="border:1px solid black;" ><font size="4"><b><?php  Echo $todate;?></b></font></td>
				</tr>
				<tr>
				<td></td>
				<td></td>
				<td align="left" style="border:1px solid black;"><font size="4"><b>Checker</b></font></td>
				<td align="left" bgcolor="yellow" style="border:1px solid black;"><font size="4"><b><?php  Echo "$nbsp";?></b></font></td>
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
		<td style="border-width:3px;border-style: double;"><b>Container No.</b></td>
	
		<td style="border-width:3px;border-style: double;"><b>Size.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Height.</b></td>
		<td style="border-width:3px;border-style: double;"><b>ISOCode</b></td>
		<td style="border-width:3px;border-style: double;"><b>ISOGroup</b></td>
		<td style="border-width:3px;border-style: double;"><b>Status</b></td>
		<td style="border-width:3px;border-style: double;"><b>Seal NO</b></td>		
		<td style="border-width:3px;border-style: double;"><b>MLO</b></td>
		<td style="border-width:3px;border-style: double;"><b>Equipment No.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Trailer</b></td>
		<td style="border-width:3px;border-style: double;"><b>OffDoc/Port</b></td>
		
		<td style="border-width:3px;border-style: double;"><b>Yard</b></td>
		<td style="border-width:3px;border-style: double;"><b>Discharge Time</b></td>
		<td style="border-width:3px;border-style: double;"><b>Job Done Time</b></td>
		<td style="border-width:3px;border-style: double;"><b>Remarks</b></td>
	
		
	</tr>

<?php
//IFNULL((SELECT disch_dt FROM ctmsmis.mis_disch_cont WHERE gkey=sparcsn4.inv_unit.gkey),sparcsn4.inv_unit_fcy_visit.time_in) AS time_in,

$cond="";
if($fromdate!="" and $todate!="")	
{
	if($fromTime!="")
		$frmDate = $fromdate." ".$fromTime.":00";
	
	if($toTime!="")
		$tDate = $todate." ".$toTime.":00";
	
	$cond = " vvd_gkey='$vvdGkey' and time_in between '$frmDate' and '$tDate'";
}
else
{
	$cond = " vvd_gkey='$vvdGkey'";
}
	
	$query=mysql_query("SELECT * FROM
(
SELECT CONCAT(SUBSTRING(sparcsn4.inv_unit.id,1,4),' ',SUBSTRING(sparcsn4.inv_unit.id,5)) AS cont_no,
(SELECT ctmsmis.mis_inv_unit.size FROM ctmsmis.mis_inv_unit WHERE gkey=sparcsn4.inv_unit.gkey) AS size,
(SELECT ctmsmis.mis_inv_unit.height FROM ctmsmis.mis_inv_unit WHERE gkey=sparcsn4.inv_unit.gkey)/10 AS height,
sparcsn4.ref_equip_type.id AS iso,sparcsn4.ref_equip_type.iso_group AS iso_group,
sparcsn4.vsl_vessel_visit_details.vvd_gkey,
(SELECT ctmsmis.mis_inv_unit.mlo FROM ctmsmis.mis_inv_unit WHERE gkey=sparcsn4.inv_unit.gkey) AS mlo,
(SELECT ctmsmis.mis_inv_unit.freight_kind FROM ctmsmis.mis_inv_unit WHERE gkey=sparcsn4.inv_unit.gkey) AS freight_kind,
CASE WHEN sparcsn4.inv_goods.destination='2591' THEN 'Port'
WHEN sparcsn4.inv_goods.destination IS NULL THEN ''
WHEN sparcsn4.inv_goods.destination = '2592' THEN 'ICD'
WHEN sparcsn4.inv_goods.destination = '2594' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '2595' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '2596' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '2597' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '2598' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '2599' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '2600' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '2601' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '2603' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '2620' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '2643' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '2646' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '2647' THEN 'other'
WHEN sparcsn4.inv_goods.destination = '3328' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '3450' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '3697' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '3709' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '3725' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '4013' THEN 'Depot'
ELSE 'Depot' END AS desti,
sparcsn4.inv_unit.seal_nbr1 AS seal_nbr1,'' AS remark,

(SELECT ctmsmis.cont_yard((SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
FROM sparcsn4.srv_event
INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
WHERE sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey AND sparcsn4.srv_event.event_type_gkey=18 LIMIT 1))) AS Yard_No,
(SELECT disch_dt FROM ctmsmis.mis_disch_cont WHERE gkey=sparcsn4.inv_unit.gkey) AS time_in,
sparcsn4.inv_unit_fcy_visit.time_in as timein,
(SELECT trailer FROM ctmsmis.mis_disch_cont WHERE gkey=sparcsn4.inv_unit.gkey) AS truck_id,

(SELECT frmpos FROM ctmsmis.mis_disch_cont WHERE gkey=sparcsn4.inv_unit.gkey) AS frmpos

FROM sparcsn4.inv_unit 
INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey
INNER JOIN sparcsn4.argo_carrier_visit ON argo_carrier_visit.gkey=sparcsn4.inv_unit.declrd_ib_cv
INNER JOIN sparcsn4.argo_visit_details ON sparcsn4.argo_visit_details.gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_visit_details.gkey
INNER JOIN sparcsn4.inv_goods ON inv_goods.gkey=inv_unit.goods
INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
WHERE inv_unit.category='IMPRT' AND sparcsn4.vsl_vessel_visit_details.vvd_gkey='$vvdGkey' ORDER BY time_in,frmpos,sparcsn4.inv_unit.id
) AS tbl where $cond");

/*echo ("SELECT * FROM
(
SELECT CONCAT(SUBSTRING(sparcsn4.inv_unit.id,1,4),' ',SUBSTRING(sparcsn4.inv_unit.id,5)) AS cont_no,
(SELECT ctmsmis.mis_inv_unit.size FROM ctmsmis.mis_inv_unit WHERE gkey=sparcsn4.inv_unit.gkey) AS size,
(SELECT ctmsmis.mis_inv_unit.height FROM ctmsmis.mis_inv_unit WHERE gkey=sparcsn4.inv_unit.gkey)/10 AS height,
sparcsn4.ref_equip_type.id AS iso,
sparcsn4.vsl_vessel_visit_details.vvd_gkey,
(SELECT ctmsmis.mis_inv_unit.mlo FROM ctmsmis.mis_inv_unit WHERE gkey=sparcsn4.inv_unit.gkey) AS mlo,
(SELECT ctmsmis.mis_inv_unit.freight_kind FROM ctmsmis.mis_inv_unit WHERE gkey=sparcsn4.inv_unit.gkey) AS freight_kind,
CASE WHEN sparcsn4.inv_goods.destination='2591' THEN 'Port'
WHEN sparcsn4.inv_goods.destination IS NULL THEN ''
WHEN sparcsn4.inv_goods.destination = '2592' THEN 'ICD'
WHEN sparcsn4.inv_goods.destination = '2594' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '2595' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '2596' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '2597' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '2598' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '2599' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '2600' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '2601' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '2603' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '2620' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '2643' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '2646' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '2647' THEN 'other'
WHEN sparcsn4.inv_goods.destination = '3328' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '3450' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '3697' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '3709' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '3725' THEN 'Depot'
WHEN sparcsn4.inv_goods.destination = '4013' THEN 'Depot'
ELSE 'Depot' END AS desti,
sparcsn4.inv_unit.seal_nbr1 AS seal_nbr1,'' AS remark,

(SELECT ctmsmis.cont_yard((SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
FROM sparcsn4.srv_event
INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
WHERE sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey AND sparcsn4.srv_event.event_type_gkey=18 LIMIT 1))) AS Yard_No,
IFNULL((SELECT disch_dt FROM ctmsmis.mis_disch_cont WHERE gkey=sparcsn4.inv_unit.gkey),sparcsn4.inv_unit_fcy_visit.time_in) AS time_in,
(SELECT trailer FROM ctmsmis.mis_disch_cont WHERE gkey=sparcsn4.inv_unit.gkey) AS truck_id,

(SELECT frmpos FROM ctmsmis.mis_disch_cont WHERE gkey=sparcsn4.inv_unit.gkey) AS frmpos

FROM sparcsn4.inv_unit 
INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey
INNER JOIN sparcsn4.argo_carrier_visit ON argo_carrier_visit.gkey=sparcsn4.inv_unit.declrd_ib_cv
INNER JOIN sparcsn4.argo_visit_details ON sparcsn4.argo_visit_details.gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_visit_details.gkey
INNER JOIN sparcsn4.inv_goods ON inv_goods.gkey=inv_unit.goods
INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
WHERE inv_unit.category='IMPRT' AND sparcsn4.vsl_vessel_visit_details.vvd_gkey='$vvdGkey' ORDER BY frmpos,sparcsn4.inv_unit.id
) AS tbl where $cond");*/

	$i=0;
	$j=0;
	
	
	while($row=mysql_fetch_object($query)){
	$i++;
	
	
?>
<tr align="center">
		<td><?php  echo $i;?></td>
		<td><?php if($row->cont_no) echo $row->cont_no; else echo "&nbsp;";?></td>
		
		<td><?php if($row->size) echo $row->size; else echo "&nbsp;";?></td>
		<td><?php if($row->height) echo $row->height; else echo "&nbsp;";?></td>
		<td><?php if($row->iso) echo $row->iso; else echo "&nbsp;";?></td>
		<td><?php if($row->iso) echo $row->iso_group; else echo "&nbsp;";?></td>
		<td><?php if($row->freight_kind) echo $row->freight_kind; else echo "&nbsp;";?></td>
		<td><?php if($row->seal_nbr1) echo $row->seal_nbr1; else echo "&nbsp;";?></td>
		<td><?php if($row->mlo) echo $row->mlo; else echo "&nbsp;";?></td>
		<td><?php if($row->frmpos) echo $row->frmpos; else echo "&nbsp;";?></td>
		<td><?php if($row->truck_id) echo $row->truck_id; else echo "&nbsp;";?></td>
		<td><?php if($row->desti) echo $row->desti; else echo "&nbsp;";?></td>
		<td><?php if($row->Yard_No) echo $row->Yard_No; else echo "&nbsp;";?></td>
		<td><?php if($row->time_in) echo $row->time_in; else echo "&nbsp;";?></td>
		<td><?php if($row->timein) echo $row->timein; else echo "&nbsp;";?></td>
		<td><?php if($row->remark) echo $row->remark;  else echo "&nbsp;";?></td>
		
		
				
	</tr>

<?php } ?>
</table>
<br />
<br />


<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
