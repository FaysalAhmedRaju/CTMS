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
<title>Export Container Loading List</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				<tr>
					<td align="right"><b>Vessel:</b></td>
					<td align="left"><font size="4"><b><?php  Echo $row1->vsl_name;?></b></font></td>
					<td align="right"><font size="4"><b>Voy:</b></font></td>
					<td align="left"><font size="4"><b><?php  Echo $voysNo;?></b></font></td>
					<td align="right"><font size="4"><b>EXP ROT.:</b></font></td>
					<td align="left"><font size="4"><b><?php Echo $ddl_imp_rot_no;?></b></font></td>
					<td colspan="3" align="right"><font size="4"><b>Arrival Date:</b></font></td>
					<td colspan="3" align="left"><font size="4"><b><?php  Echo $row1->ata;?></b></font></td>
				</tr>
			</table>
		</td>
	</tr>
	</table>
	<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<tr  align="center">
		<td style="border-width:3px;border-style: double;"><b>SlNo.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Container No.</b></td>
		<td style="border-width:3px;border-style: double;"><b>ISO Type</b></td>
		<td style="border-width:3px;border-style: double;"><b>Size</b></td>
		<td style="border-width:3px;border-style: double;"><b>Height</b></td>
		<td style="border-width:3px;border-style: double;"><b>MLO</b></td>
		<td style="border-width:3px;border-style: double;"><b>Status</b></td>		
		<td style="border-width:3px;border-style: double;"><b>Weight</b></td>
		<td style="border-width:3px;border-style: double;"><b>POD</b></td>
		<td style="border-width:3px;border-style: double;"><b>Stowage</b></td>
		<td style="border-width:3px;border-style: double;"><b>Loaded Time</b></td>
		<td style="border-width:3px;border-style: double;"><b>Seal No</b></td>
		<td style="border-width:3px;border-style: double;"><b>Coming From</b></td>
		<td style="border-width:3px;border-style: double;"><b>Truck No</b></td>
		<td style="border-width:3px;border-style: double;"><b>Craine Id</b></td>
		<td style="border-width:3px;border-style: double;"><b>Commodity</b></td>
		<td style="border-width:3px;border-style: double;"><b>Shift</b></td>
		<td style="border-width:3px;border-style: double;"><b>Date</b></td>
		<!--td style="border-width:3px;border-style: double;"><b>Shipment Type</b></td-->
		<!--td style="border-width:3px;border-style: double;"><b>Remarks</b></td-->
		<td style="border-width:3px;border-style: double;"><b>User Id</b></td>
		<!--td style="border-width:3px;border-style: double;"><b>Action</b></td-->
		
	</tr>

<?php
$cond="";
/* if($fromdate!="" and $todate!="")	
{
	if($fromTime=="" or $toTime=="")
		$cond = " and date(mis_exp_unit.last_update) between '$fromdate' and '$todate'";
	else
	{
		$frmDate = $fromdate." ".$fromTime.":00";
		$tDate = $todate." ".$toTime.":00";
		$cond = " and mis_exp_unit.last_update between '$frmDate' and '$tDate'";
	}
}	 */
	//echo$vvdGkey;
	$strQuery = "select ctmsmis.mis_exp_unit.gkey,concat(substring(ctmsmis.mis_exp_unit.cont_id,1,4),substring(ctmsmis.mis_exp_unit.cont_id,5)) as id,
	sparcsn4.ref_equip_type.id as iso,RIGHT(sparcsn4.ref_equip_type.nominal_length,2) AS size,RIGHT(sparcsn4.ref_equip_type.nominal_height,2) AS height,
	mis_exp_unit.cont_mlo AS mlo,ctmsmis.mis_exp_unit.craine_id,ctmsmis.mis_exp_unit.seal_no,cont_status as freight_kind,ctmsmis.mis_exp_unit.goods_and_ctr_wt_kg as weight,
	ctmsmis.mis_exp_unit.coming_from AS coming_from,ctmsmis.mis_exp_unit.pod,ctmsmis.mis_exp_unit.stowage_pos,ctmsmis.mis_exp_unit.last_update,ref_commodity.short_name,
	ctmsmis.mis_exp_unit.user_id,ctmsmis.mis_exp_unit.truck_no,ctmsmis.mis_exp_unit.shipmentType
	from ctmsmis.mis_exp_unit
	left join sparcsn4.inv_unit on sparcsn4.inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
	inner join sparcsn4.ref_bizunit_scoped g ON sparcsn4.inv_unit.line_op = g.gkey
	left join sparcsn4.inv_goods on sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
	left join sparcsn4.ref_commodity on sparcsn4.ref_commodity.gkey=sparcsn4.inv_goods.commodity_gkey
	inner join sparcsn4.inv_unit_equip on sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
	inner join sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
	inner join sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
	where mis_exp_unit.vvd_gkey='$vvdGkey' AND mis_exp_unit.preAddStat='0' and snx_type=0 and mis_exp_unit.delete_flag='0' ".$cond;
	
	//echo $strQuery;
	$query=mysql_query($strQuery);

	$i=0;
	$j=0;
	
	$mlo="";
	while($row=mysql_fetch_object($query)){
	$i++;
?>
	<tr align="center">
		<td><?php  	echo $i;?></td>
		<td><?php 	if($row->id) echo $row->id; else echo "&nbsp;";?></td>
		<td><?php 	if($row->iso) echo $row->iso; else echo "&nbsp;";?></td>
		<td><?php 	if($row->size) echo $row->size; else echo "&nbsp;";?></td>
		<td><?php 	if($row->height) echo $row->height; else echo "&nbsp;";?></td>
		<td><?php 	if($row->mlo) echo $row->mlo; else echo "&nbsp;";?></td>
		<td><?php 	if($row->freight_kind) echo $row->freight_kind; else echo "&nbsp;";?></td>
		<td><?php 	if($row->weight) echo $row->weight; else echo "&nbsp;";?></td>
		<td><?php 	if($row->pod) echo $row->pod; else echo "&nbsp;";?></td>
		<td><?php 	if($row->stowage_pos) 
					{
						if(strlen($row->stowage_pos)==5)
							echo "0".$row->stowage_pos;
						else
							echo $row->stowage_pos;
					}
			?>
		</td>
		<td><?php	if($row->last_update) echo $row->last_update; else echo "&nbsp;";?></td>
		<td><?php 	if($row->seal_no) echo $row->seal_no; else echo "&nbsp;";?></td>
		<td><?php 	if($row->coming_from) echo $row->coming_from; else echo "&nbsp;";?></td>
		<td><?php 	if($row->truck_no) echo $row->truck_no; else echo "&nbsp;";?></td>
		<td><?php 	if($row->craine_id) echo $row->craine_id; else echo "&nbsp;";?></td>
		<td><?php 	if($row->short_name) echo $row->short_name; else echo "&nbsp;";?></td>
		<td width="80px">&nbsp;</td>
		<td width="80px">&nbsp;</td>
		<!--td width="80px"><?php 	if($row->shipmentType==0 && $row->coming_from=="YARD") { echo "YARD"; }  else if ($row->shipmentType==1) { echo "DLOAD"; } else if ($row->shipmentType==2) { echo "YLOAD"; } else echo "";?></td-->
		<td><?php 	if($row->user_id) echo $row->user_id;  else echo "&nbsp;";?></td>
	</tr>

<?php } ?>
</table>
<br />

<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
