<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>Export Loading</TITLE>
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
		header("Content-Disposition: attachment; filename=EXPORT_LOADING/$ddl_imp_rot_no.xls;");
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
<title>Export Loading</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table align="left" width="40%">
				
				
			
			
				<tr align="center">
					<td></td>
					<td></td>
					<td align="center" style="border:1px solid black;"><font size="4"><b>Export Loading</b></font></td>
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
				<td align="left" bgcolor="yellow" style="border:1px solid black;" ><font size="4"><b><?php  if($fromdate!==""){Echo $fromdate.":".$fromTime;}?></b></font></td>
				<td align="left" bgcolor="yellow" style="border:1px solid black;" ><font size="4"><b><?php  if($todate!==""){Echo $todate.":".$toTime;}?></b></font></td>
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
		<td style="border-width:3px;border-style: double;"><b>Status</b></td>
		<td style="border-width:3px;border-style: double;"><b>Seal NO</b></td>		
		<td style="border-width:3px;border-style: double;"><b>MLO</b></td>
		<td style="border-width:3px;border-style: double;"><b>Equipment No.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Trailer</b></td>
		<td style="border-width:3px;border-style: double;"><b>OffDoc/Port</b></td>
		<td style="border-width:3px;border-style: double;"><b>Stowage</b></td>
		<td style="border-width:3px;border-style: double;"><b>POD</b></td>
		
		<td style="border-width:3px;border-style: double;"><b>Yard</b></td>
		<td style="border-width:3px;border-style: double;"><b>Loading Time</b></td>
		<td style="border-width:3px;border-style: double;"><b>Remarks</b></td>
	
		
	</tr>


<?php
$cond="";
if($fromdate!="" and $todate!="")	
{
	if($fromTime!="")
		$frmDate = $fromdate." ".$fromTime.":00";
	
	if($toTime!="")
		$tDate = $todate." ".$toTime.":00";
	
	$cond = " and mis_exp_unit.vvd_gkey='$vvdGkey' and mis_exp_unit.last_update between '$frmDate' and '$tDate'";
}
else
{
	$cond = " and mis_exp_unit.vvd_gkey='$vvdGkey'";
}
	
	//mlo is changed to cont_mlo (of mis_exp_unit)
	$query=mysql_query("SELECT CONCAT(SUBSTRING(ctmsmis.mis_inv_unit.id,1,4),' ',SUBSTRING(ctmsmis.mis_inv_unit.id,5)) AS id,
ctmsmis.mis_inv_unit.size,(ctmsmis.mis_inv_unit.height)/10 AS height,ctmsmis.mis_exp_unit.pod,ctmsmis.mis_exp_unit.craine_id,
(SELECT SUBSTRING(id,1,3) FROM sparcsn4.argo_quay 
	INNER JOIN sparcsn4.vsl_vessel_berthings brt ON brt.quay=sparcsn4.argo_quay.gkey 
	WHERE brt.vvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey ORDER BY brt.ata DESC LIMIT 1)AS berth,
sparcsn4.ref_equip_type.id AS iso,ctmsmis.mis_inv_unit.freight_kind,ctmsmis.mis_exp_unit.cont_mlo,
ctmsmis.mis_exp_unit.seal_no AS seal_no2,ctmsmis.mis_exp_unit.truck_no AS truck_no,
ctmsmis.mis_exp_unit.truck_no LIKE '%sp%' AS truck_no1,
ctmsmis.mis_exp_unit.stowage_pos,ctmsmis.mis_exp_unit.last_update,'' AS remark
 FROM ctmsmis.mis_exp_unit 
 INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey
INNER JOIN ctmsmis.mis_inv_unit ON ctmsmis.mis_inv_unit.gkey=mis_exp_unit.gkey 
LEFT JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=ctmsmis.mis_inv_unit.goods
LEFT JOIN sparcsn4.ref_commodity ON sparcsn4.ref_commodity.gkey=sparcsn4.inv_goods.commodity_gkey
INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.unit_gkey=ctmsmis.mis_inv_unit.gkey
INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
WHERE mis_exp_unit.preAddStat='0' and snx_type=0 and mis_exp_unit.delete_flag='0' ".$cond." ORDER BY craine_id,ctmsmis.mis_inv_unit.id");

	$i=0;
	$j=0;
	
	$mlo="";
	while($row=mysql_fetch_object($query)){
	$i++;
	
	$querydep="select count(sparcsn4.ref_bizunit_scoped.id) as cnt
from sparcsn4.ref_bizunit_scoped
inner join sparcsn4.road_trucking_companies on sparcsn4.road_trucking_companies.trkc_id = sparcsn4.ref_bizunit_scoped.gkey
where sparcsn4.road_trucking_companies.trkc_id=(select distinct trkco_gkey from road_truck_visit_details where truck_id='$row->truck_no' order by tvdtls_gkey desc limit 1) ";
	$querydepresult = mysql_query($querydep);
	$depocont=mysql_fetch_object($querydepresult);
	$offdeo = $depocont->cnt;
		
	
?>
<tr align="center">
		<td><?php  echo $i;?></td>
		<td><?php if($row->id) echo $row->id; else echo "&nbsp;";?></td>
		
		<td><?php if($row->size) echo $row->size; else echo "&nbsp;";?></td>
		<td><?php if($row->height) echo $row->height; else echo "&nbsp;";?></td>
		<td><?php if($row->iso) echo $row->iso; else echo "&nbsp;";?></td>
		<td><?php if($row->freight_kind) echo $row->freight_kind; else echo "&nbsp;";?></td>
		
		<td><?php if($row->seal_no2) echo $row->seal_no2; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_mlo) echo $row->cont_mlo; else echo "&nbsp;";?></td>
		<td><?php if($row->craine_id) echo $row->craine_id; else echo "&nbsp;";?></td>
		<td><?php if($row->truck_no) echo $row->truck_no; else echo "&nbsp;";?></td>
		
		<td>
			<?php 
			if($row->truck_no1>0)
			{ 
				echo  "<strong>".strtoupper($row->truck_no). "</strong>";
			}
			elseif($offdeo>0 and $row->truck_no!="")
			{
				echo "Depot";
			}
			else 
			{
				echo "Port";
			}?>
		</td>
		
		<td><?php if($row->stowage_pos) echo $row->stowage_pos; else echo "&nbsp;";?></td>
		<td><?php if($row->pod) echo $row->pod; else echo "&nbsp;";?></td>
		
		<td><?php if($row->berth) echo $row->berth; else echo "&nbsp;";?></td>
		<td><?php if($row->last_update) echo $row->last_update; else echo "&nbsp;";?></td>
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
