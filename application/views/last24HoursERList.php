<?php if($_POST['options']=='html'){?>
	<?php } 
	else if($_POST['options']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=LAST_24_HOUR_ER.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}
	include("dbConection.php");
	?>
<html>
<title>Export Container Loading List</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				
				
				<tr align="center">
					<td colspan="12"><img align="middle"  width="220px" height="70px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
				</tr>
			
				<tr align="center">
					<td colspan="12"><font size="4"><b><?php echo $title;?></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b></b></font></td>
				</tr>

				<tr>
					<td colspan="3" align="center"><font size="4"><b> Date : <?php echo $search_by;?></b></font></td>
					<td colspan="3" align="center"><font size="4"><b> Yard : <?php if($search_yard=="all"){ echo "ALL";} else if($search_yard=="y9ny10"){echo "Y9 and Y10";} else { echo $search_yard;}?></b></font></td>
					<td colspan="3" align="center"><font size="4"><b> Shift : <?php echo $search_shift." (TIME From ".$fromTime." - To ".$toTime." )";?></b></font></td>
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
		<td style="border-width:3px;border-style: double;"><b>Size</b></td>
		<td style="border-width:3px;border-style: double;"><b>Seal No</b></td>
		<td style="border-width:3px;border-style: double;"><b>E/R No</b></td>
		<td style="border-width:3px;border-style: double;"><b>Vessel Name</b></td>		
		<td style="border-width:3px;border-style: double;"><b>Rot No</b></td>
		<td style="border-width:3px;border-style: double;"><b>Depot</b></td>
		<td style="border-width:3px;border-style: double;"><b>Shipping Agent</b></td>
	</tr>

<?php
$cond = "";

if($search_yard=='all')
{
	$cond = "where";
}
else if($search_yard=='y9ny10')
{
	$cond = " where block_no in('Y9','Y10') and";
}
else
{
	$cond = " where block_no='$search_yard' and";
}

$inCond = "";
if($search_shift=="A")
	$inCond = "'".$search_by." 08:30:01' AND '".$search_by." 16:30:00'";
else if($search_shift=="B")
	$inCond = "'".$search_by." 16:30:01' AND CONCAT(DATE_ADD('".$search_by."',INTERVAL 1 DAY),' 00:30:00')";
else if($search_shift=="C")
	$inCond = "CONCAT(DATE_ADD('".$search_by."',INTERVAL 1 DAY),' 00:30:01') AND CONCAT(DATE_ADD('".$search_by."',INTERVAL 1 DAY),' 08:30:00')";
else
	$inCond = "'".$search_by." 08:30:01' AND CONCAT(DATE_ADD('".$search_by."',INTERVAL 1 DAY),' 08:30:00')";

$strQuery = "select * from 
	(SELECT sparcsn4.inv_unit.seal_nbr1,sparcsn4.inv_unit.remark,sparcsn4.inv_unit.id as container,
	sparcsn4.vsl_vessels.name,sparcsn4.vsl_vessel_visit_details.ib_vyg,sparcsn4.ref_bizunit_scoped.id,
	(select nbr from sparcsn4.road_truck_transactions 				
	where unit_gkey=sparcsn4.inv_unit.gkey limit 1) as eir_no,
	(SELECT biz.id FROM sparcsn4.road_truck_transactions rtt
	INNER JOIN sparcsn4.road_trucking_companies rtc ON rtc.trkc_id=rtt.trkco_gkey
	INNER JOIN sparcsn4.ref_bizunit_scoped biz ON biz.gkey=rtc.trkc_id
	WHERE rtt.unit_gkey=sparcsn4.inv_unit.gkey LIMIT 1) AS off_dock_code,
	(SELECT biz.name FROM sparcsn4.road_truck_transactions rtt
	INNER JOIN sparcsn4.road_trucking_companies rtc ON rtc.trkc_id=rtt.trkco_gkey
	INNER JOIN sparcsn4.ref_bizunit_scoped biz ON biz.gkey=rtc.trkc_id
	WHERE rtt.unit_gkey=sparcsn4.inv_unit.gkey LIMIT 1) AS off_dock,
	(SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
	FROM sparcsn4.srv_event
	INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
	WHERE sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey  AND sparcsn4.srv_event.event_type_gkey IN(13,23) ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1) AS slot,
	(SELECT ctmsmis.cont_yard(slot)) AS yard_no,
	(SELECT ctmsmis.cont_block(slot,yard_no)) AS block_no,
	sparcsn4.inv_unit_fcy_visit.time_in,
	(select right(sparcsn4.ref_equip_type.nominal_length,2) from ref_equip_type 
			INNER JOIN sparcsn4.ref_equipment ON ref_equipment.eqtyp_gkey=ref_equip_type.gkey
			INNER JOIN sparcsn4.inv_unit_equip ON inv_unit_equip.eq_gkey=ref_equipment.gkey
			where sparcsn4.inv_unit_equip.unit_gkey=inv_unit.gkey
			) as size,
	(select sparcsn4.srv_event.placed_by from sparcsn4.srv_event where sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey and event_type_gkey IN(13,23) ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1) as usr
	FROM sparcsn4.inv_unit
	INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
	INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ob_cv
	INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
	INNER JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
	INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.vsl_vessel_visit_details.bizu_gkey
	WHERE sparcsn4.inv_unit_fcy_visit.transit_state IN ('S40_YARD','S60_LOADED','S70_DEPARTED') 
	and  sparcsn4.inv_unit.freight_kind!='MTY' and time_in between ".$inCond.") as tmp ".$cond." usr !='snx:-snx-' and usr!='xps:1:CHE'";
	
	//echo $strQuery;
	$query=mysql_query($strQuery);
	$i=0;
	$mlo="";
	$totCont = "";
	while($row=mysql_fetch_object($query)){
	$i++;
	$totCont = $totCont.$row->container.", ";
		
	
?>
<tr align="center">
		<td><?php  echo $i;?></td>
		<td><?php if($row->container) echo $row->container; else echo "&nbsp;";?></td>
		<td><?php if($row->size) echo $row->size; else echo "&nbsp;";?></td>
		<td><?php if($row->seal_nbr1) echo $row->seal_nbr1; else echo "&nbsp;";?></td>
		<td><?php if($row->eir_no) echo $row->eir_no; else echo "&nbsp;";?></td>
		<td><?php if($row->name) echo $row->name; else echo "&nbsp;";?></td>
		<td><?php if($row->ib_vyg) echo $row->ib_vyg; else echo "&nbsp;";?></td>
		<td><?php if($row->off_dock_code) echo $row->off_dock_code; else echo "&nbsp;";?></td>		
		<td><?php if($row->id) echo $row->id; else echo "&nbsp;";?></td>
	</tr>
<?php } ?>
</table>
<br />
<br />
<?php if($_POST['options']=='html'){?>
<table border="1">
<tr>
	<?php echo $totCont; ?>									
</tr>

<table>
<?php } ?>
<?php 
mysql_close($con_sparcsn4);
