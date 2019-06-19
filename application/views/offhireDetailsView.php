<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>Export Loading</TITLE>
		<LINK href="../css/report.css" type=text/css rel=stylesheet>
	    <style type="text/css">
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
		header("Content-Disposition: attachment; filename=OFFHIRE_DETAILS/$ddl_imp_rot_no.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
	?>
<html>
<title>Offhire Details</title>
<body>
<?php 
	for($j=0;$j<count($rslt_get_mlo);$j++)
	{
		$mlo=$rslt_get_mlo[$j]['mlo'];
	?>
		<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
			<tr>
				<?php
				if($_POST['options']=='xl')
				{
				?>
				<td colspan="13" align="center"><font size="5">CHITTAGONG PORT AUTHORITY</font></td>
				<?php
				}
				else if($_POST['options']=='html')
				{
				?>
				<td colspan="3" align="center"><img align="middle" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
				<?php
				}
				?>				
			</tr>
			<tr>
				<?php
				if($_POST['options']=='xl')
				{
				?>
				<td colspan="13" align="center"><font size="3"><b>VAT Reg : 2041001546</b></font></td>
				<?php
				}
				else if($_POST['options']=='html')
				{
				?>
				<td colspan="3" align="center"><font size="3"><b>VAT Reg : 2041001546</b></font></td>
				<?php
				}
				?>				
			</tr>
			<tr>
				<?php
				if($_POST['options']=='xl')
				{
				?>
				<td colspan="13" align="center"><font size="3"><b>OFFHIRE DATA FORMAT FOR PREPARATION OF AGENT BILL DATE WISE</b></font></td>
				<?php
				}
				else if($_POST['options']=='html')
				{	
				?>
				<td colspan="3" align="center"><font size="3"><b>OFFHIRE DATA FORMAT FOR PREPARATION OF AGENT BILL DATE WISE</b></font></td>
				<?php
				}
				?>				
			</tr>
			<tr bgcolor="#ffffff" align="center" height="25px">
				<?php
				if($_POST['options']=='xl')
				{
				?>
				<td colspan="4" align="center">Agent Name: <?php echo $rslt_get_mlo[$j]['concustomername']; ?></td>
				<td colspan="4" align="center">Import MLO: <?php echo $rslt_get_mlo[$j]['mlo']; ?></td>
				<td colspan="5" align="center">Date: <?php echo $offhire_date; ?></td>
				<?php
				}
				else if($_POST['options']=='html')
				{					
				?>
				<td align="center">Agent Name: <?php echo $rslt_get_mlo[$j]['concustomername']; ?></td>
				<td align="center">Import MLO: <?php echo $rslt_get_mlo[$j]['mlo']; ?></td>
				<td align="center">Date: <?php echo $offhire_date; ?></td>
				<?php
				}
				?>
				
			</tr>
			<tr bgcolor="#ffffff" align="center" height="25px">
				<td colspan="3" align="center"></td>
			</tr>
		</table>
		<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
			<thead>
				<tr align="center">
					<td style="align:center"><b>SlNo.</b></td>
					<td style="align:center"><b>Container No.</b></td>
					<td style="align:center"><b>Size.</b></td>
					<td style="align:center"><b>Height</b></td>
					<td style="align:center"><b>Status</b></td>
					<td style="align:center"><b>Rot No</b></td>
					<td style="align:center"><b>Vessel Name</b></td>
					<td style="align:center"><b>Berth</b></td>
					<td style="align:center"><b>Land Date</b></td>
					<td style="align:center"><b>Dlv Date</b></td>
					<td style="align:center"><b>Unstaff Date</b></td>
					<td style="align:center"><b>To Depo</b></td>
					<td style="align:center"><b>Depo Name</b></td>
				</tr>
			</thead>
			<tbody>
			<?php
				include_once('mydbPConnectionn4.php');
				
				$sql_offhire_details="SELECT sparcsn4.inv_unit.gkey,sparcsn4.road_truck_transactions.ctr_id AS unitId,
				(SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.ref_equip_type
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.eqtyp_gkey=sparcsn4.ref_equip_type.gkey
				INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.eq_gkey=sparcsn4.ref_equipment.gkey
				WHERE sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey) AS isoLength,
				(SELECT RIGHT(sparcsn4.ref_equip_type.nominal_height,2) FROM sparcsn4.ref_equip_type
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.eqtyp_gkey=sparcsn4.ref_equip_type.gkey
				INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.eq_gkey=sparcsn4.ref_equipment.gkey
				WHERE sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey)/10 AS isoHeight,sparcsn4.road_truck_transactions.ctr_freight_kind AS freightKind,
				IF(sparcsn4.inv_unit.category='IMPRT',sparcsn4.inv_unit_fcy_visit.flex_string10, 
				(SELECT fcy.flex_string10 FROM sparcsn4.inv_unit_fcy_visit fcy 
				INNER JOIN sparcsn4.inv_unit inv ON inv.gkey=fcy.unit_gkey 
				WHERE inv.id=sparcsn4.inv_unit.id AND inv.category='IMPRT' AND fcy.time_out < sparcsn4.inv_unit_fcy_visit.time_out
				ORDER BY inv.gkey DESC LIMIT 1)) AS ibVisitId,
				(SELECT sparcsn4.vsl_vessels.name FROM sparcsn4.vsl_vessels 
				INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vessel_gkey=sparcsn4.vsl_vessels.gkey 
				WHERE sparcsn4.vsl_vessel_visit_details.ib_vyg=ibVisitId LIMIT 1) AS ibCarrierName,
				(SELECT sparcsn4.argo_quay.id FROM sparcsn4.argo_quay 
				INNER JOIN sparcsn4.vsl_vessel_berthings ON sparcsn4.vsl_vessel_berthings.quay=sparcsn4.argo_quay.gkey 
				INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.vsl_vessel_berthings.vvd_gkey 
				WHERE sparcsn4.vsl_vessel_visit_details.ib_vyg=ibVisitId 
				ORDER BY sparcsn4.vsl_vessel_visit_details.vvd_gkey DESC LIMIT 1) AS berth,
				DATE(sparcsn4.inv_unit_fcy_visit.time_in) AS timeIn,
				(SELECT DATE(fcy1.time_in) 
				FROM sparcsn4.inv_unit inv1
				INNER JOIN sparcsn4.inv_unit_fcy_visit fcy1 ON fcy1.unit_gkey=inv1.gkey 
				WHERE inv1.id=sparcsn4.inv_unit.id AND inv1.gkey<sparcsn4.inv_unit.gkey  AND category='IMPRT'  ORDER BY inv1.gkey DESC LIMIT 1) AS eventTo, 
				(SELECT IF((SELECT inv.freight_kind FROM sparcsn4.inv_unit_fcy_visit fcy 
				INNER JOIN sparcsn4.inv_unit inv ON inv.gkey=fcy.unit_gkey 
				WHERE inv.id=sparcsn4.inv_unit.id AND inv.category='IMPRT' AND fcy.time_out < sparcsn4.inv_unit_fcy_visit.time_out 
				ORDER BY inv.gkey DESC LIMIT 1)='LCL',(SELECT fcy.time_out FROM sparcsn4.inv_unit_fcy_visit fcy 
				INNER JOIN sparcsn4.inv_unit inv ON inv.gkey=fcy.unit_gkey 
				WHERE inv.id=sparcsn4.inv_unit.id AND inv.category='IMPRT' AND fcy.time_out < sparcsn4.inv_unit_fcy_visit.time_out 
				ORDER BY inv.gkey DESC LIMIT 1),'')) AS unstuffingDate,
				DATE(sparcsn4.road_truck_visit_details.created) AS yardOutDate1, 
				sparcsn4.inv_unit_fcy_visit.last_pos_locid AS depoName,
				r.id AS customerId,Y.name AS concustomername,r.id AS mlo,'DRAFT' AS STATUS,sparcsn4.inv_unit.category
				FROM sparcsn4.inv_unit
				INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
				INNER JOIN sparcsn4.road_truck_transactions ON sparcsn4.road_truck_transactions.unit_gkey=sparcsn4.inv_unit.gkey
				INNER JOIN sparcsn4.road_truck_visit_details ON sparcsn4.road_truck_transactions.truck_visit_gkey=sparcsn4.road_truck_visit_details.tvdtls_gkey
				INNER JOIN  ( sparcsn4.ref_bizunit_scoped r   
				LEFT JOIN ( sparcsn4.ref_agent_representation X   
				LEFT JOIN sparcsn4.ref_bizunit_scoped Y ON X.agent_gkey=Y.gkey )                
				ON r.gkey=X.bzu_gkey)  ON r.gkey = sparcsn4.inv_unit.line_op
				WHERE sparcsn4.road_truck_visit_details.created >= CONCAT('$offhire_date',' 08:00:00')
				AND sparcsn4.road_truck_visit_details.created <= CONCAT(ADDDATE('$offhire_date',INTERVAL 1 DAY),' 08:00:00')
				AND sparcsn4.road_truck_transactions.stage_id='Out Gate' AND road_truck_transactions.status !='CANCEL'
				AND sparcsn4.road_truck_transactions.ctr_freight_kind='MTY' AND sparcsn4.inv_unit.category !='EXPRT'
				AND r.id='$mlo' 
				ORDER BY unitId ASC";
			//	echo "<br>";
				$rslt_offhire_details=mysql_query($sql_offhire_details);
				
				$k=1;
		
				while($row_offhire_details=mysql_fetch_object($rslt_offhire_details))
				{
			?>
				<tr align="center">
					<td align="center"><?php  echo $k; ?></td>
					<td align="center"><?php  echo $row_offhire_details->unitId; ?></td>
					<td align="center"><?php  echo $row_offhire_details->isoLength; ?></td>
					<td align="center"><?php  echo $row_offhire_details->isoHeight; ?></td>
					<td align="center"><?php  echo $row_offhire_details->freightKind; ?></td>
					<td align="center"><?php  echo $row_offhire_details->ibVisitId; ?></td>
					<td align="center"><?php  echo $row_offhire_details->ibCarrierName; ?></td>
					<td align="center"><?php  echo $row_offhire_details->berth; ?></td>
					<!--td align="center"><?php  echo $row_offhire_details->timeIn; ?></td-->
					<td align="center"><?php  echo $row_offhire_details->eventTo; ?></td>
					<td align="center"><?php  echo $row_offhire_details->timeIn; ?></td>
					<td align="center"><?php  echo $row_offhire_details->unstuffingDate; ?></td>
					<td align="center"><?php  echo $row_offhire_details->yardOutDate1; ?></td>
					<td align="center"><?php  echo $row_offhire_details->depoName; ?></td>
				</tr>
			<?php 
				$k=$k+1;
				}
			?>
			</tbody>
		</table>
<!--div class="pageBreak"></div-->
<?php } ?>
<br />
<br />


<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
