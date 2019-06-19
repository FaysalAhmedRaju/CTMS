<?php if($_POST['options']=='html'){?>
	<?php } 
	else if($_POST['options']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=LAST_24_HOUR_CONTAINER_HANDLING.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}
	include("dbConection.php");
	?>
<html>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				
				<tr >
					<td align="center" colspan="12"><img align="middle"  width="220px" height="70px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
				</tr>
				<!--tr align="center">
					<td colspan="12"><font size="4"><b>CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td>
				</tr-->
			
				<tr align="center">
					<td colspan="12"><font size="4"><b><?php echo $title;?></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b></b></font></td>
				</tr>

				

			</table>
		
		</td>
		
	</tr>
	</table>
	<?php 
	$strInfoQry="SELECT sparcsn4.vsl_vessel_visit_details.ib_vyg,
				sparcsn4.vsl_vessel_visit_details.ob_vyg,
				sparcsn4.vsl_vessel_visit_details.vvd_gkey,
				sparcsn4.ref_bizunit_scoped.id AS shipping_agent,
				sparcsn4.vsl_vessels.name,
				DATE(sparcsn4.argo_carrier_visit.ata) as arrived_date,
				DATE(sparcsn4.argo_carrier_visit.atd) as departure_date,
				(select ctmsmis.berth_for_vessel(sparcsn4.vsl_vessel_visit_details.vvd_gkey)) as berth
				FROM sparcsn4.vsl_vessel_visit_details
				INNER JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
				INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
				INNER JOIN sparcsn4.ref_bizunit_scoped on sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.vsl_vessel_visit_details.bizu_gkey
				WHERE  sparcsn4.vsl_vessel_visit_details.ib_vyg='$rotation_no' ";
	$rtnInfoQry=mysql_query($strInfoQry);
	$rowInfoQry=mysql_fetch_object($rtnInfoQry);
	?>
	<table width="40%" border ='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td><font size="4"><b> Date : <?php echo $work_date;?></b></font></td>
		</tr>
		<tr><td>VESSEL NAME - </td><td><?php echo $rowInfoQry->name;?></td></tr>
		<tr><td>VOYAGE - </td><td><?php echo " ";?></td></tr>
		<tr><td>IMP.ROT. - </td><td><?php echo $rowInfoQry->ib_vyg;?></td></tr>
		<tr><td>EXP.ROT. - </td><td><?php echo $rowInfoQry->ob_vyg;?></td></tr>
		<tr><td>BERTH NO - </td><td><?php echo $rowInfoQry->berth;?></td></tr>
		<tr><td>SHIPPING AGENT - </td><td><?php echo $rowInfoQry->shipping_agent;?></td></tr>
		<tr><td>ARRIVED DATE - </td><td><?php echo $rowInfoQry->arrived_date;?></td></tr>
		<tr><td>EXPECTED TIME OF DEPARTURE - </td><td><?php echo $rowInfoQry->departure_date;?></td></tr>
	</table>
	
	</br>
	</br>
	<?php
	
	$strImportInfo="select 
					sum(disch_load20) as disch_load20, 
					sum(disch_load40) as disch_load40,
					sum(disch_mty20) as disch_mty20,
					sum(disch_mty40) as disch_mty40,
					(sum(disch_load20)+sum(disch_load40)*2) as load_teus,
					(sum(disch_mty20)+sum(disch_mty40)*2) as mty_teus,

					sum(tot_disch_load20) as tot_disch_load20, 
					sum(tot_disch_load40) as tot_disch_load40,
					sum(tot_disch_mty20) as tot_disch_mty20,
					sum(tot_disch_mty40) as tot_disch_mty40,
					(sum(tot_disch_load20)+sum(tot_disch_load40)*2) as tot_disch_load_teus,
					(sum(tot_disch_mty20)+sum(tot_disch_mty40)*2) as tot_disch_mty_teus,

					sum(bal_load20) as bal_load20, 
					sum(bal_load40) as bal_load40,
					sum(bal_mty20) as bal_mty20,
					sum(bal_mty40) as bal_mty40,
					(sum(bal_load20)+sum(bal_load40)*2) as bal_load_teus,
					(sum(bal_mty20)+sum(bal_mty40)*2) as bal_mty_teus    

					from
					(
					SELECT sparcsn4.inv_unit.id,freight_kind,ctmsmis.mis_disch_cont.disch_dt,
					right(sparcsn4.ref_equip_type.nominal_length,2) as size,

					(case when freight_kind != 'MTY' and right(sparcsn4.ref_equip_type.nominal_length,2)=20
					and ctmsmis.mis_disch_cont.disch_dt is not null and ctmsmis.mis_disch_cont.disch_dt>= concat(DATE(SUBDATE('$work_date',1)), ' 08:00:00')
					and ctmsmis.mis_disch_cont.disch_dt<'$work_date 08:00:00'
					then 1 else 0 end) as disch_load20,
					(case when freight_kind != 'MTY' and right(sparcsn4.ref_equip_type.nominal_length,2)!=20 
					and ctmsmis.mis_disch_cont.disch_dt is not null and ctmsmis.mis_disch_cont.disch_dt>= concat(DATE(SUBDATE('$work_date',1)), ' 08:00:00')
					and ctmsmis.mis_disch_cont.disch_dt<'$work_date 08:00:00'
					then 1 else 0 end) as disch_load40,
					(case when freight_kind = 'MTY' and right(sparcsn4.ref_equip_type.nominal_length,2)=20
					and ctmsmis.mis_disch_cont.disch_dt is not null and ctmsmis.mis_disch_cont.disch_dt>= concat(DATE(SUBDATE('$work_date',1)), ' 08:00:00')
					and ctmsmis.mis_disch_cont.disch_dt<'$work_date 08:00:00'
					then 1 else 0 end) as disch_mty20,
					(case when freight_kind = 'MTY' and right(sparcsn4.ref_equip_type.nominal_length,2)!=20
					and ctmsmis.mis_disch_cont.disch_dt is not null and ctmsmis.mis_disch_cont.disch_dt>= concat(DATE(SUBDATE('$work_date',1)), ' 08:00:00')
					and ctmsmis.mis_disch_cont.disch_dt<'$work_date 08:00:00'
					then 1 else 0 end) as disch_mty40,

					(case when freight_kind != 'MTY' and right(sparcsn4.ref_equip_type.nominal_length,2)=20
					and ctmsmis.mis_disch_cont.disch_dt is not null
					then 1 else 0 end) as tot_disch_load20,
					(case when freight_kind != 'MTY' and right(sparcsn4.ref_equip_type.nominal_length,2)!=20 
					and ctmsmis.mis_disch_cont.disch_dt is not null
					then 1 else 0 end) as tot_disch_load40,
					(case when freight_kind = 'MTY' and right(sparcsn4.ref_equip_type.nominal_length,2)=20
					and ctmsmis.mis_disch_cont.disch_dt is not null
					then 1 else 0 end) as tot_disch_mty20,
					(case when freight_kind = 'MTY' and right(sparcsn4.ref_equip_type.nominal_length,2)!=20
					and ctmsmis.mis_disch_cont.disch_dt is not null
					then 1 else 0 end) as tot_disch_mty40,

					(case when freight_kind != 'MTY' and right(sparcsn4.ref_equip_type.nominal_length,2)=20
					and ctmsmis.mis_disch_cont.disch_dt is null
					then 1 else 0 end) as bal_load20,
					(case when freight_kind != 'MTY' and right(sparcsn4.ref_equip_type.nominal_length,2)!=20 
					and ctmsmis.mis_disch_cont.disch_dt is null
					then 1 else 0 end) as bal_load40,
					(case when freight_kind = 'MTY' and right(sparcsn4.ref_equip_type.nominal_length,2)=20
					and ctmsmis.mis_disch_cont.disch_dt is null
					then 1 else 0 end) as bal_mty20,
					(case when freight_kind = 'MTY' and right(sparcsn4.ref_equip_type.nominal_length,2)!=20
					and ctmsmis.mis_disch_cont.disch_dt is null
					then 1 else 0 end) as bal_mty40


					FROM sparcsn4.inv_unit
					INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
					INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
					INNER JOIN sparcsn4.inv_unit_equip on sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
					INNER JOIN sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
					INNER JOIN sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
					LEFT JOIN ctmsmis.mis_disch_cont on sparcsn4.inv_unit.gkey=ctmsmis.mis_disch_cont.gkey
					WHERE  sparcsn4.argo_carrier_visit.cvcvd_gkey='$rowInfoQry->vvd_gkey') as tmp";
	//echo $strImportInfo;
	$rtnImportInfo=mysql_query($strImportInfo);
	$rowImportInfo=mysql_fetch_object($rtnImportInfo);
	?>
	<table width="100%" border ='1' cellpadding='0' cellspacing='0' align="center">
	<tr >
		<td align="center" colspan="18"><b>IMPORT</b></td>
	</tr>
	
	<tr >
		<td align="center" colspan="6"><b>DISCHARGED</b></td>
		<td align="center" colspan="6"><b>TOTAL DISCHARGED</b></td>
		<td align="center" colspan="6"><b>BALANCE ON BOARD</b></td>
	</tr>
	<tr>
		<td align="center" colspan="2"><b>LADEN</b></td>
		<td align="center" colspan="2"><b>EMPTY</b></td>
		<td align="center" colspan="2"><b>TEUS</b></td>
		<td align="center" colspan="2"><b>LADEN</b></td>
		<td align="center" colspan="2"><b>EMPTY</b></td>
		<td align="center" colspan="2"><b>TEUS</b></td>
		<td align="center" colspan="2"><b>LADEN</b></td>
		<td align="center" colspan="2"><b>EMPTY</b></td>
		<td align="center" colspan="2"><b>TEUS</b></td>
	</tr>
	<tr align="center">
		<td><b>20</b></td>
		<td><b>40</b></td>
		<td><b>20</b></td>
		<td><b>40</b></td>
		<td><b>LT</b></td>
		<td><b>MT</b></td>
		<td><b>20</b></td>
		<td><b>40</b></td>
		<td><b>20</b></td>
		<td><b>40</b></td>
		<td><b>LT</b></td>
		<td><b>MT</b></td>
		<td><b>20</b></td>
		<td><b>40</b></td>
		<td><b>20</b></td>
		<td><b>40</b></td>
		<td><b>LT</b></td>
		<td><b>MT</b></td>
	</tr>
	<tr align="center">
		<td><?php echo $rowImportInfo->disch_load20;?></td>
		<td><?php echo $rowImportInfo->disch_load40;?></td>
		<td><?php echo $rowImportInfo->disch_mty20;?></td>
		<td><?php echo $rowImportInfo->disch_mty40;?></td>
		<td><?php echo $rowImportInfo->load_teus;?></td>
		<td><?php echo $rowImportInfo->mty_teus;?></td>
		
		<td><?php echo $rowImportInfo->tot_disch_load20;?></td>
		<td><?php echo $rowImportInfo->tot_disch_load40;?></td>
		<td><?php echo $rowImportInfo->tot_disch_mty20;?></td>
		<td><?php echo $rowImportInfo->tot_disch_mty40;?></td>
		<td><?php echo $rowImportInfo->tot_disch_load_teus;?></td>
		<td><?php echo $rowImportInfo->tot_disch_mty_teus;?></td>
		
		<td><?php echo $rowImportInfo->bal_load20;?></td>
		<td><?php echo $rowImportInfo->bal_load40;?></td>
		<td><?php echo $rowImportInfo->bal_mty20;?></td>
		<td><?php echo $rowImportInfo->bal_mty40;?></td>
		<td><?php echo $rowImportInfo->bal_load_teus;?></td>
		<td><?php echo $rowImportInfo->bal_mty_teus;?></td>
	</tr>
	
	</table>
	</br>
	</br>
	
		<?php
	
	$strExportInfo="select 
					sum(disch_load20) as disch_load20, 
					sum(disch_load40) as disch_load40,
					sum(disch_mty20) as disch_mty20,
					sum(disch_mty40) as disch_mty40,
					(sum(disch_load20)+sum(disch_load40)*2) as load_teus,
					(sum(disch_mty20)+sum(disch_mty40)*2) as mty_teus,

					sum(tot_disch_load20) as tot_disch_load20, 
					sum(tot_disch_load40) as tot_disch_load40,
					sum(tot_disch_mty20) as tot_disch_mty20,
					sum(tot_disch_mty40) as tot_disch_mty40,
					(sum(tot_disch_load20)+sum(tot_disch_load40)*2) as tot_disch_load_teus,
					(sum(tot_disch_mty20)+sum(tot_disch_mty40)*2) as tot_disch_mty_teus,

					sum(bal_load20) as bal_load20, 
					sum(bal_load40) as bal_load40,
					sum(bal_mty20) as bal_mty20,
					sum(bal_mty40) as bal_mty40,
					(sum(bal_load20)+sum(bal_load40)*2) as bal_load_teus,
					(sum(bal_mty20)+sum(bal_mty40)*2) as bal_mty_teus    

					from
					(
					SELECT sparcsn4.inv_unit.id,freight_kind,sparcsn4.inv_unit_fcy_visit.time_load,
					right(sparcsn4.ref_equip_type.nominal_length,2) as size,

					(case when freight_kind != 'MTY' and right(sparcsn4.ref_equip_type.nominal_length,2)=20
					and sparcsn4.inv_unit_fcy_visit.time_load is not null and sparcsn4.inv_unit_fcy_visit.time_load>= concat(DATE(SUBDATE('$work_date',1)), ' 08:00:00')
					and sparcsn4.inv_unit_fcy_visit.time_load<'$work_date 08:00:00'
					then 1 else 0 end) as disch_load20,
					(case when freight_kind != 'MTY' and right(sparcsn4.ref_equip_type.nominal_length,2)!=20 
					and sparcsn4.inv_unit_fcy_visit.time_load is not null and sparcsn4.inv_unit_fcy_visit.time_load>= concat(DATE(SUBDATE('$work_date',1)), ' 08:00:00')
					and sparcsn4.inv_unit_fcy_visit.time_load<'$work_date 08:00:00'
					then 1 else 0 end) as disch_load40,
					(case when freight_kind = 'MTY' and right(sparcsn4.ref_equip_type.nominal_length,2)=20
					and sparcsn4.inv_unit_fcy_visit.time_load is not null and sparcsn4.inv_unit_fcy_visit.time_load>= concat(DATE(SUBDATE('$work_date',1)), ' 08:00:00')
					and sparcsn4.inv_unit_fcy_visit.time_load<'$work_date 08:00:00'
					then 1 else 0 end) as disch_mty20,
					(case when freight_kind = 'MTY' and right(sparcsn4.ref_equip_type.nominal_length,2)!=20
					and sparcsn4.inv_unit_fcy_visit.time_load is not null and sparcsn4.inv_unit_fcy_visit.time_load>= concat(DATE(SUBDATE('$work_date',1)), ' 08:00:00')
					and sparcsn4.inv_unit_fcy_visit.time_load<'$work_date 08:00:00'
					then 1 else 0 end) as disch_mty40,

					(case when freight_kind != 'MTY' and right(sparcsn4.ref_equip_type.nominal_length,2)=20
					and sparcsn4.inv_unit_fcy_visit.time_load is not null
					then 1 else 0 end) as tot_disch_load20,
					(case when freight_kind != 'MTY' and right(sparcsn4.ref_equip_type.nominal_length,2)!=20 
					and sparcsn4.inv_unit_fcy_visit.time_load is not null
					then 1 else 0 end) as tot_disch_load40,
					(case when freight_kind = 'MTY' and right(sparcsn4.ref_equip_type.nominal_length,2)=20
					and sparcsn4.inv_unit_fcy_visit.time_load is not null
					then 1 else 0 end) as tot_disch_mty20,
					(case when freight_kind = 'MTY' and right(sparcsn4.ref_equip_type.nominal_length,2)!=20
					and sparcsn4.inv_unit_fcy_visit.time_load is not null
					then 1 else 0 end) as tot_disch_mty40,

					(case when freight_kind != 'MTY' and right(sparcsn4.ref_equip_type.nominal_length,2)=20
					and sparcsn4.inv_unit_fcy_visit.time_load is null
					then 1 else 0 end) as bal_load20,
					(case when freight_kind != 'MTY' and right(sparcsn4.ref_equip_type.nominal_length,2)!=20 
					and sparcsn4.inv_unit_fcy_visit.time_load is null
					then 1 else 0 end) as bal_load40,
					(case when freight_kind = 'MTY' and right(sparcsn4.ref_equip_type.nominal_length,2)=20
					and sparcsn4.inv_unit_fcy_visit.time_load is null
					then 1 else 0 end) as bal_mty20,
					(case when freight_kind = 'MTY' and right(sparcsn4.ref_equip_type.nominal_length,2)!=20
					and sparcsn4.inv_unit_fcy_visit.time_load is null
					then 1 else 0 end) as bal_mty40


					FROM sparcsn4.inv_unit
					INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
					INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ob_cv
					INNER JOIN sparcsn4.inv_unit_equip on sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
					INNER JOIN sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
					INNER JOIN sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
					WHERE  sparcsn4.argo_carrier_visit.cvcvd_gkey='$rowInfoQry->vvd_gkey') as tmp";
	//echo $strExportInfo;
	$rtnExportInfo=mysql_query($strExportInfo);
	$rowExportInfo=mysql_fetch_object($rtnExportInfo);
	?>
	<table width="100%" border ='1' cellpadding='0' cellspacing='0' align="center">
	<tr >
		<td align="center" colspan="18"><b>EXPORT</b></td>
	</tr>
	
	<tr >
		<td align="center" colspan="6"><b>LOADED</b></td>
		<td align="center" colspan="6"><b>TOTAL LOADED</b></td>
		<td align="center" colspan="6"><b>BALANCE TO BE SHIPPED</b></td>
	</tr>
	<tr>
		<td align="center" colspan="2"><b>LADEN</b></td>
		<td align="center" colspan="2"><b>EMPTY</b></td>
		<td align="center" colspan="2"><b>TEUS</b></td>
		<td align="center" colspan="2"><b>LADEN</b></td>
		<td align="center" colspan="2"><b>EMPTY</b></td>
		<td align="center" colspan="2"><b>TEUS</b></td>
		<td align="center" colspan="2"><b>LADEN</b></td>
		<td align="center" colspan="2"><b>EMPTY</b></td>
		<td align="center" colspan="2"><b>TEUS</b></td>
	</tr>
	<tr align="center">
		<td><b>20</b></td>
		<td><b>40</b></td>
		<td><b>20</b></td>
		<td><b>40</b></td>
		<td><b>LT</b></td>
		<td><b>MT</b></td>
		<td><b>20</b></td>
		<td><b>40</b></td>
		<td><b>20</b></td>
		<td><b>40</b></td>
		<td><b>LT</b></td>
		<td><b>MT</b></td>
		<td><b>20</b></td>
		<td><b>40</b></td>
		<td><b>20</b></td>
		<td><b>40</b></td>
		<td><b>LT</b></td>
		<td><b>MT</b></td>
	</tr>
	<tr align="center">
		<td><?php echo $rowExportInfo->disch_load20;?></td>
		<td><?php echo $rowExportInfo->disch_load40;?></td>
		<td><?php echo $rowExportInfo->disch_mty20;?></td>
		<td><?php echo $rowExportInfo->disch_mty40;?></td>
		<td><?php echo $rowExportInfo->load_teus;?></td>
		<td><?php echo $rowExportInfo->mty_teus;?></td>
		
		<td><?php echo $rowExportInfo->tot_disch_load20;?></td>
		<td><?php echo $rowExportInfo->tot_disch_load40;?></td>
		<td><?php echo $rowExportInfo->tot_disch_mty20;?></td>
		<td><?php echo $rowExportInfo->tot_disch_mty40;?></td>
		<td><?php echo $rowExportInfo->tot_disch_load_teus;?></td>
		<td><?php echo $rowExportInfo->tot_disch_mty_teus;?></td>
		
		<td><?php echo $rowExportInfo->bal_load20;?></td>
		<td><?php echo $rowExportInfo->bal_load40;?></td>
		<td><?php echo $rowExportInfo->bal_mty20;?></td>
		<td><?php echo $rowExportInfo->bal_mty40;?></td>
		<td><?php echo $rowExportInfo->bal_load_teus;?></td>
		<td><?php echo $rowExportInfo->bal_mty_teus;?></td>
	</tr>
	
	</table>
</br>
</br>
<table width="100%" border ='1' cellpadding='0' cellspacing='0' align="center">
	<tr>
		<td align="center" colspan="2" ><b>PROGRAM</b></td>
	</tr>
	<tr>
		<td align="center" ><b>IMPORT-NIL</b></td>
		<td align="center" ><b>EXPORT-NIL</b></td>
	</tr>
</table>
</br>
</br>
<table width="100%" border ='0' cellpadding='0' cellspacing='0' align="center">
	<tr>
		<td align="left" ><b><?php echo $work_date;?></b></td>
		<td align="right" ><b>SHIP/YARD PLANNER</b></td>
	</tr>
</table>
<?php if($_POST['options']=='html'){?>

<?php } ?>
<?php 
mysql_close($con_sparcsn4);
