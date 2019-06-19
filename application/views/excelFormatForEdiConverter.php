<?php
header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=EDI.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");


include("dbConection.php");

$rot=$_REQUEST['rot'];
$sql=mysql_query("select vvd_gkey,ib_vyg,vsl_vessels.name,ref_bizunit_scoped.id from vsl_vessel_visit_details 
inner join vsl_vessels on vsl_vessels.gkey=vsl_vessel_visit_details.vessel_gkey
inner join ref_bizunit_scoped on ref_bizunit_scoped.gkey=vsl_vessel_visit_details.bizu_gkey where ib_vyg='$rot'");
$row=mysql_fetch_object($sql);
?>
<table border="1" cellspacing="0" cellpadding="0">
	<tr>
		<td></td><td></td>
	</tr>
	<tr>
		<td></td><td></td>
	</tr>
	<tr>
		<td>Agent</td><td><?php echo $row->id; ?></td>
	</tr>
	<tr>
		<td>Voy</td><td></td>
	</tr>
	<tr>
		<td>Call Sign</td><td></td>
	</tr>
	<tr>
		<td>Vessel Name</td><td><?php echo $row->name; ?></td>
	</tr>
	<tr>
		<td>Date</td><td></td>
	</tr>
	<tr>
		<td>LOP</td><td>BDCGP</td>
	</tr>
	<tr>
		<td>Next Port</td><td></td>
	</tr>
	<tr>
		<td></td><td></td>
	</tr>
	
	
	<tr>
		<td colspan="13">
			<table border="1" cellspacing="0" cellpadding="0">
				<tr>
					<td>Container</td><td>ISO</td><td>Liner</td><td>Status</td><td>Weight</td><td>Booking</td><td>Seal</td><td>IMDG</td><td>UNNO</td><td>TEMP</td><td>Load Port</td><td>Discharge Port</td><td>Stowage</td>
				</tr>
				
				<?php
					$sql1=mysql_query("select inv_unit.id,ref_equip_type.id as iso_code,
(select mlo from ctmsmis.mis_inv_unit where ctmsmis.mis_inv_unit.gkey=sparcsn4.inv_unit.gkey) as mlo,
freight_kind,mis_exp_unit.goods_and_ctr_wt_kg,'1' as booking,seal_no,pod,stowage_pos   from ctmsmis.mis_exp_unit 
inner join sparcsn4.inv_unit on sparcsn4.inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
inner join inv_unit_equip on inv_unit_equip.gkey=inv_unit.primary_ue
inner join ref_equipment on ref_equipment.gkey=inv_unit_equip.eq_gkey
inner join ref_equip_type on ref_equip_type.gkey=ref_equipment.eqtyp_gkey
where mis_exp_unit.vvd_gkey=$row->vvd_gkey");
				while($row1=mysql_fetch_object($sql1)){
				?>
					<tr>
						<td><?php  if($row1->id) echo $row1->id; else echo ""?></td>
						<td><?php  if($row1->iso_code) echo $row1->iso_code; else echo ""?></td>
						<td><?php  if($row1->mlo) echo $row1->mlo; else echo ""?></td>
						<td><?php  if($row1->freight_kind) echo $row1->freight_kind; else echo ""?></td>
						<td><?php  if($row1->goods_and_ctr_wt_kg) echo $row1->goods_and_ctr_wt_kg; else echo ""?></td>
						<td><?php  if($row1->booking) echo $row1->booking; else echo ""?></td>
						<td><?php  if($row1->seal_no) echo $row1->seal_no; else echo ""?></td>
						<td></td>
						<td></td>
						<td></td>
						<td>BDCGP</td>
						<td><?php  if($row1->pod) echo $row1->pod; else echo ""?></td>
						<td><?php  if($row1->stowage_pos) echo $row1->stowage_pos; else echo ""?></td>
					</tr>
				<?php
				}
				?>
				
				
			</table>
		</td>
	</tr>
	
	
	<?php mysql_close($con_sparcsn4);?>
	
	
	
</table>