<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>Bearth Operator Report</TITLE>
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
		header("Content-Disposition: attachment; filename=EXPORT_SUMMERY.xls;");
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
<title>Export Container Not Found List</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				
				<!--tr align="center">
					<td colspan="12"><font size="4"><b>CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td>
				</tr-->
				<?php
				if($_POST['options']=='html')
				{
				?>
					<tr>
						<td colspan="12" align="center"><img width="250px" height="80px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
					</tr>
				<?php
				}
				else
				{
				?>
					<tr align="center">
						<td colspan="12"><font size="4"><b>CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td>
					</tr>
				<?php
				}
				?>
			
				<tr align="center">
					<td colspan="12"><font size="4"><b><u>Export Container Not Found Report</u></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b></b></font></td>
				</tr>

				<tr>
					<td colspan="3" align="center"><font size="4"><b> <?php  Echo $row1->vsl_name;?></b></font></td>
					<td colspan="3" align="center"><font size="4"><b>Voy: <?php  Echo $voysNo;?></b></font></td>
					<td colspan="3" align="center"><font size="4"><b>EXP ROT.: <?php  Echo $ddl_imp_rot_no;?></b></font></td>
					<td colspan="3" align="center"><font size="4"><b><?php  Echo $row1->ata;?></b></font></td>
					
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
		<td style="border-width:3px;border-style: double;"><b>Rotation No.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Type</b></td>
		<td style="border-width:3px;border-style: double;"><b>MLO</b></td>
		<td style="border-width:3px;border-style: double;"><b>Status</b></td>		
		<td style="border-width:3px;border-style: double;"><b>Weight</b></td>
		<td style="border-width:3px;border-style: double;"><b>Yard</b></td>
		<td style="border-width:3px;border-style: double;"><b>Current Position</b></td>
		<td style="border-width:3px;border-style: double;"><b>Discharge date</b></td>
		<td style="border-width:3px;border-style: double;"><b>Assignment date</b></td>
		<td style="border-width:3px;border-style: double;"><b>POD</b></td>
		<td style="border-width:3px;border-style: double;"><b>Stowage</b></td>
		<td style="border-width:3px;border-style: double;"><b>Coming From</b></td>
		<td style="border-width:3px;border-style: double;"><b>Commodity</b></td>
		<td style="border-width:3px;border-style: double;"><b>Remarks</b></td>
		<td style="border-width:3px;border-style: double;"><b>User Id</b></td>
		
	</tr>

<?php
	
	
	$query=mysql_query("
SELECT * FROM
(
SELECT ctmsmis.mis_inv_unit.id AS id,ctmsmis.mis_inv_unit.fcy_time_in,
(SELECT ms.fcy_transit_state FROM ctmsmis.mis_inv_unit ms WHERE ms.id=ctmsmis.mis_inv_unit.id ORDER BY gkey DESC LIMIT 1) AS fcy_transit_state,
(SELECT sparcsn4.vsl_vessel_visit_details.ib_vyg FROM sparcsn4.vsl_vessel_visit_details WHERE sparcsn4.vsl_vessel_visit_details.vvd_gkey=mis_exp_unit_load_failed.vvd_gkey) AS rot, 
sparcsn4.ref_equip_type.id AS iso,mlo, (SELECT ctmsmis.cont_yard(IF(sparcsn4.inv_unit_fcy_visit.last_pos_slot='', (SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7) FROM sparcsn4.srv_event INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey WHERE sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey AND sparcsn4.srv_event.event_type_gkey IN(18) AND sparcsn4.srv_event_field_changes.new_value IS NOT NULL AND sparcsn4.srv_event_field_changes.new_value !='' AND sparcsn4.srv_event_field_changes.new_value !='Y-CGP-.' AND sparcsn4.srv_event.gkey<(SELECT sparcsn4.srv_event.gkey FROM sparcsn4.srv_event INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey WHERE sparcsn4.srv_event.event_type_gkey IN(25,29,30) AND sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey ORDER BY sparcsn4.srv_event_field_changes.gkey DESC LIMIT 1) ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1) ,sparcsn4.inv_unit_fcy_visit.last_pos_slot))) AS yard, IF(sparcsn4.inv_unit_fcy_visit.last_pos_slot='', (SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7) FROM sparcsn4.srv_event INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey WHERE sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey AND sparcsn4.srv_event.event_type_gkey IN(18) AND sparcsn4.srv_event_field_changes.new_value IS NOT NULL AND sparcsn4.srv_event_field_changes.new_value !='' AND sparcsn4.srv_event_field_changes.new_value !='Y-CGP-.' AND sparcsn4.srv_event.gkey<(SELECT sparcsn4.srv_event.gkey FROM sparcsn4.srv_event INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey WHERE sparcsn4.srv_event.event_type_gkey IN(25,29,30) AND sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey ORDER BY sparcsn4.srv_event_field_changes.gkey DESC LIMIT 1) ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1) ,sparcsn4.inv_unit_fcy_visit.last_pos_slot) AS last_pos_slot, ctmsmis.mis_inv_unit.freight_kind,ctmsmis.mis_exp_unit_load_failed.goods_and_ctr_wt_kg AS weight, ctmsmis.mis_exp_unit_load_failed.pod,ctmsmis.mis_exp_unit_load_failed.stowage_pos,ref_commodity.short_name, sparcsn4.inv_unit_fcy_visit.flex_date01 AS assignmentdate, ctmsmis.mis_exp_unit_load_failed.user_id FROM ctmsmis.mis_exp_unit_load_failed INNER JOIN ctmsmis.mis_inv_unit ON ctmsmis.mis_inv_unit.gkey=mis_exp_unit_load_failed.gkey LEFT JOIN inv_unit ON inv_unit.gkey=ctmsmis.mis_inv_unit.gkey INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey LEFT JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=ctmsmis.mis_inv_unit.goods LEFT JOIN sparcsn4.ref_commodity ON sparcsn4.ref_commodity.gkey=sparcsn4.inv_goods.commodity_gkey INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.unit_gkey=ctmsmis.mis_inv_unit.gkey INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey WHERE DATE(ctmsmis.mis_inv_unit.last_update) BETWEEN '$fromdate' AND '$todate' OR mis_exp_unit_load_failed.vvd_gkey='$vvdGkey'
) AS tbl WHERE fcy_transit_state NOT IN ('S60_LOADED','S70_DEPARTED')");
	$i=0;
	$j=0;
	
	$mlo="";
	while($row=mysql_fetch_object($query)){
	$i++;
	
		
	
?>
<tr align="center">
		<td><?php  echo $i;?></td>
		<td><?php if($row->id) echo $row->id; else echo "&nbsp;";?></td>
		<td><?php if($row->rot) echo $row->rot; else echo "&nbsp;";?></td>
		<td><?php if($row->iso) echo $row->iso; else echo "&nbsp;";?></td>
		<td><?php if($row->mlo) echo $row->mlo; else echo "&nbsp;";?></td>
		<td><?php if($row->freight_kind) echo $row->freight_kind; else echo "&nbsp;";?></td>
		<td><?php if($row->weight) echo $row->weight; else echo "&nbsp;";?></td>
		<td><?php if($row->yard) echo $row->yard; else echo "&nbsp;";?></td>
		<td><?php if($row->last_pos_slot) echo $row->last_pos_slot; else echo "&nbsp;";?></td>
		<td><?php if($row->last_pos_slot) echo $row->fcy_time_in; else echo "&nbsp;";?></td>
		<td><?php if($row->assignmentdate) echo $row->assignmentdate; else echo "&nbsp;";?></td>
		
		
		<td><?php if($row->pod) echo $row->pod; else echo "&nbsp;";?></td>
		<td><?php if($row->stowage_pos) echo $row->stowage_pos; else echo "&nbsp;";?></td>
		
		<td><?php  echo "&nbsp;";?></td>
		<td><?php if($row->short_name) echo $row->short_name; else echo "&nbsp;";?></td>
		<td><?php echo "&nbsp;";?></td>
		<td><?php if($row->user_id) echo $row->user_id; else echo "&nbsp;";?></td>
				
	</tr>

<?php } ?>
</table>

<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
