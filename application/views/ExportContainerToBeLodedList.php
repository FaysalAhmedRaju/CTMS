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

	//$con=mysql_connect("10.1.1.21", "sparcsn4","sparcsn4")or die("cannot connect"); 
	//mysql_select_db("sparcsn4")or die("cannot select DB");
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
<title>Export Container Balance To Be Loaded List</title>
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
				<tr align="center">
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
					<td colspan="12"><font size="4"><b><u>Export Container Balance To Be Loaded Report</u></b></font></td>
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
		<td style="border-width:3px;border-style: double;"><b>Type</b></td>
		<td style="border-width:3px;border-style: double;"><b>MLO</b></td>
		<td style="border-width:3px;border-style: double;"><b>Status</b></td>		
		<td style="border-width:3px;border-style: double;"><b>Weight</b></td>
		<td style="border-width:3px;border-style: double;"><b>POD</b></td>
		<td style="border-width:3px;border-style: double;"><b>Stowage</b></td>
		<td style="border-width:3px;border-style: double;"><b>User Id</b></td>
		
	</tr>

<?php
	
	
	$query=mysql_query("SELECT CONCAT(SUBSTRING(ctmsmis.mis_inv_unit.id,1,4),' ',SUBSTRING(ctmsmis.mis_inv_unit.id,5)) AS id,sparcsn4.ref_equip_type.id AS iso,
mlo,
ctmsmis.mis_inv_unit.freight_kind,ctmsmis.mis_inv_unit.goods_and_ctr_wt_kg AS weight,
'' AS pod,ctmsmis.mis_inv_unit.fcy_last_pos_slot,ref_commodity.short_name
 FROM  ctmsmis.mis_inv_unit 
LEFT JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=ctmsmis.mis_inv_unit.goods
LEFT JOIN sparcsn4.ref_commodity ON sparcsn4.ref_commodity.gkey=sparcsn4.inv_goods.commodity_gkey
INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.unit_gkey=ctmsmis.mis_inv_unit.gkey
INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
WHERE mis_inv_unit.vvd_gkey='$vvdGkey' AND category='EXPRT' 
AND fcy_transit_state NOT IN ('S60_LOADED','S70_DEPARTED','S99_RETIRED') ");
	$i=0;
	$j=0;
	
	$mlo="";
	while($row=mysql_fetch_object($query)){
	$i++;
	
		
	
?>
<tr align="center">
		<td><?php  echo $i;?></td>
		<td><?php if($row->id) echo $row->id; else echo "&nbsp;";?></td>
		<td><?php if($row->iso) echo $row->iso; else echo "&nbsp;";?></td>
		<td><?php if($row->mlo) echo $row->mlo; else echo "&nbsp;";?></td>
		<td><?php if($row->freight_kind) echo $row->freight_kind; else echo "&nbsp;";?></td>
		<td><?php if($row->weight) echo $row->weight; else echo "&nbsp;";?></td>
		<td><?php if($row->pod) echo $row->pod; else echo "&nbsp;";?></td>
		<td><?php if($row->fcy_last_pos_slot) echo $row->fcy_last_pos_slot; else echo "&nbsp;";?></td>
		<td><?php if($row->short_name) echo $row->short_name; else echo "&nbsp;";?></td>
				
	</tr>

<?php } ?>
</table>
<br />
<br />
<?php



$sqlSummery2=mysql_query("select gkey,
IFNULL(SUM(balance_LD_20),0) AS balance_LD_20,
IFNULL(SUM(balance_LD_40),0) AS balance_LD_40,
IFNULL(SUM(balance_MT_20),0) AS balance_MT_20,
IFNULL(SUM(balance_MT_40),0) AS balance_MT_40,
IFNULL(SUM(balance_LD_tues),0) AS balance_LD_tues,
IFNULL(SUM(balance_MT_tues),0) AS balance_MT_tues

 from (
select distinct ctmsmis.mis_inv_unit.gkey as gkey,
(CASE WHEN size = '20' AND freight_kind in ('FCL','LCL')  THEN 1  
ELSE NULL END) AS balance_LD_20, 
(CASE WHEN size > '20' AND freight_kind in ('FCL','LCL')  THEN 1  
ELSE NULL END) AS balance_LD_40,
(CASE WHEN size = '20' AND freight_kind ='MTY'  THEN 1  
ELSE NULL END) AS balance_MT_20, 
(CASE WHEN size > '20' AND freight_kind ='MTY'  THEN 1  
ELSE NULL END) AS balance_MT_40, 
(CASE WHEN size=20 AND freight_kind in ('FCL','LCL') THEN 1 
ELSE (CASE WHEN size>20 AND freight_kind in ('FCL','LCL') THEN 2 ELSE NULL END) END) AS balance_LD_tues, 
(CASE WHEN size=20 AND freight_kind='MTY' THEN 1 
ELSE (CASE WHEN size>20 AND freight_kind='MTY' THEN 2 ELSE NULL END) END) AS balance_MT_tues

FROM ctmsmis.mis_inv_unit 
where  mis_inv_unit.vvd_gkey='$vvdGkey' and category='EXPRT' and fcy_transit_state not in ('S60_LOADED','S70_DEPARTED','S99_RETIRED')
) as tmp");

$rowSummery2=mysql_fetch_object($sqlSummery2);
?>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr><td colspan="12" align="center"><font size="4"><b><u>Export Container Balance To Be Loaded Summary Report</u></b></font></td></tr>
<tr><td colspan="12" align="center"><font size="4"><b>&nbsp;</b></font></td></tr>
</table>
<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<tr>
		
		<td colspan="6" align="center">BALANCE TO LOAD</td>
	</tr>
	<tr>
		
		<td colspan="2" align="center">LADEN</td>
		<td colspan="2" align="center">EMPTY</td>
		<td colspan="2" align="center">TUES</td>
		
	</tr>
	<tr>
		
		<td align="center">20</td>
		<td align="center">40</td>
		<td align="center">20</td>
		<td align="center">40</td>
		<td align="center">LD</td>
		<td align="center">MT</td>
	</tr>
	<tr>
		
	
		<td align="center"><?php if($rowSummery2->balance_LD_20) echo $rowSummery2->balance_LD_20; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery2->balance_LD_40) echo $rowSummery2->balance_LD_40; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery2->balance_MT_20) echo $rowSummery2->balance_MT_20; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery2->balance_MT_40) echo $rowSummery2->balance_MT_40; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery2->balance_LD_tues) echo $rowSummery2->balance_LD_tues; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery2->balance_MT_tues) echo $rowSummery2->balance_MT_tues; else echo "&nbsp;"; ?></td>
		

		
	</tr>
</table>
<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
