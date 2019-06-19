<?php if($_POST['options']=='html'){?>
	<?php } 
	else if($_POST['options']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=OffDock_Removal_Position.xls;");
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
				
				
				<!--tr align="center">
					<td colspan="12"><font size="4"><b>CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td>
				</tr-->
				<tr>
					<td colspan="12" align="center"><img width="250px" height="80px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
				</tr>
			
				<tr align="center">
					<td colspan="12"><font size="4"><b><?php echo $title;?></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b></b></font></td>
				</tr>

				<tr>
					<td colspan="3" align="center" style="padding-left:240px;"><font size="4"><b> Shift : <?php echo $search_shift." (TIME From ".$fromTime." - To ".$toTime." )";?></b></font></td>
					<td colspan="3" align="center"><font size="4"><b> Date : <?php echo $search_by;?></b></font></td>
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
		<td style="border-width:3px;border-style: double;"><b>Sl.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Container No.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Size</b></td>
		<td style="border-width:3px;border-style: double;"><b>Seal No</b></td>
		<td style="border-width:3px;border-style: double;"><b>Vessel Name</b></td>		
		<td style="border-width:3px;border-style: double;"><b>Rot No</b></td>
		<td style="border-width:3px;border-style: double;"><b>MLO</b></td>
		<td style="border-width:3px;border-style: double;"><b>Depot</b></td>
		<td style="border-width:3px;border-style: double;"><b>Entered Yard</b></td>
		<td style="border-width:3px;border-style: double;"><b>Exited Yard</b></td>
		<td style="border-width:3px;border-style: double;"><b>Gate No</b></td>
		<td style="border-width:3px;border-style: double;"><b>User</b></td>

	</tr>

<?php
$cond = "";
if($terminal=="GCB")
{
	if($search_yard=="all")
	{
		$cond = " where yard_no='$terminal'";
	}
	else
	{
		$cond = " where yard_no='$terminal' and block_no='$search_yard'";
	}
	
}
else
{
	$cond = " where yard_no='$terminal'";
}
/*if($search_yard=='all')
{
	$cond = "";
}
else
{
	$cond = " where block_no='$search_yard'";
}*/
	$strQuery = "select *,(select ctmsmis.offdoc.code from ctmsmis.offdoc where ctmsmis.offdoc.id=tmp.destination) as offdock from 
				( SELECT sparcsn4.inv_unit.id as container, sparcsn4.inv_unit.seal_nbr1,sparcsn4.inv_unit.remark, 
				sparcsn4.vsl_vessels.name,sparcsn4.vsl_vessel_visit_details.ib_vyg, sparcsn4.inv_goods.destination,entered_yard,exited_yard,
				(select id from road_gates where gkey= road_truck_visit_details.gate_gkey) as GateNo,sparcsn4.road_truck_visit_details.creator as user,
				 (SELECT SUBSTRING(sparcsn4.srv_event_field_changes.prior_value,7) FROM sparcsn4.srv_event 
				INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey 
				WHERE sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey AND sparcsn4.srv_event.event_type_gkey 
				IN(22) ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1) AS slot, (SELECT ctmsmis.cont_yard(slot)) AS yard_no, 
				(SELECT ctmsmis.cont_block(slot,yard_no)) AS block_no, sparcsn4.inv_unit_fcy_visit.time_out, 
				(select right(sparcsn4.ref_equip_type.nominal_length,2) from sparcsn4.ref_equip_type 
				INNER JOIN sparcsn4.ref_equipment ON ref_equipment.eqtyp_gkey=ref_equip_type.gkey 
				INNER JOIN sparcsn4.inv_unit_equip ON inv_unit_equip.eq_gkey=ref_equipment.gkey 
				where sparcsn4.inv_unit_equip.unit_gkey=inv_unit.gkey ) as size,sparcsn4.ref_bizunit_scoped.id as mlo 
				FROM sparcsn4.inv_unit INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey 
				INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv 
				INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey 
				INNER JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey 
				inner join sparcsn4.inv_goods on sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods 
				inner join sparcsn4.ref_bizunit_scoped on sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.inv_unit.line_op
				inner join sparcsn4.road_truck_transactions on sparcsn4.road_truck_transactions.unit_gkey=sparcsn4.inv_unit.gkey
				inner join sparcsn4.road_truck_visit_details on sparcsn4.road_truck_visit_details.tvdtls_gkey=sparcsn4.road_truck_transactions.truck_visit_gkey
				WHERE sparcsn4.inv_unit_fcy_visit.time_load between '".$search_by." ".$fromTime."' and '".$search_by." ".$toTime."' 
				and sparcsn4.inv_goods.destination not in('2591','2592','BDCGP')
				and sparcsn4.inv_goods.destination is not null and sparcsn4.road_truck_transactions.status !='CANCEL'
				) as tmp 
				".$cond;
	
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
		<td><?php if($row->name) echo $row->name; else echo "&nbsp;";?></td>
		<td><?php if($row->ib_vyg) echo $row->ib_vyg; else echo "&nbsp;";?></td>
		<td><?php if($row->mlo) echo $row->mlo; else echo "&nbsp;";?></td>
		<td><?php if($row->offdock) echo $row->offdock; else echo "&nbsp;";?></td>		
		<td><?php if($row->entered_yard) echo $row->entered_yard; else echo "&nbsp;";?></td>		
		<td><?php if($row->exited_yard) echo $row->exited_yard; else echo "&nbsp;";?></td>		
		<td><?php if($row->GateNo) echo $row->GateNo; else echo "&nbsp;";?></td>		
		<td><?php if($row->user) echo $row->user; else echo "&nbsp;";?></td>		
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
