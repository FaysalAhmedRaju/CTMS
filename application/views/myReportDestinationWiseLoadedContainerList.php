
<?php 
	//$ddl_imp_rot_no=$_REQUEST['ddl_imp_rot_no']; 

	//$con=mysql_connect("10.1.1.21", "sparcsn4","sparcsn4")or die("cannot connect"); 
	//mysql_select_db("sparcsn4")or die("cannot select DB");
	include("dbConection.php");
	$sql=mysql_query("select vvd_gkey from sparcsn4.vsl_vessel_visit_details where ib_vyg='$ddl_imp_rot_no'");
	$row=mysql_fetch_object($sql);
	$vvdGkey=$row->vvd_gkey;
	
	$sql="call ctmsmis.update_containers_by_vvd_gkey($vvdGkey)";
	$res=mysql_query($sql);
	
	$sql1=mysql_query("select vsl_vessels.name,ifnull(sparcsn4.vsl_vessel_visit_details.flex_string02,ifnull(sparcsn4.vsl_vessel_visit_details.flex_string03,'')) as berth_op,ifnull(sparcsn4.argo_quay.id,'') as berth from vsl_vessel_visit_details
inner join sparcsn4.vsl_vessel_berthings on sparcsn4.vsl_vessel_berthings.vvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
inner join sparcsn4.argo_quay on sparcsn4.argo_quay.gkey=sparcsn4.vsl_vessel_berthings.quay
where vsl_vessel_visit_details.vvd_gkey=$vvdGkey");
	$row1=mysql_fetch_object($sql1);
	
	?>
<html>
<title>MLO WISE LOADED CONTAINER LIST</title>
<body>
<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<!--td colspan="12"><font size="4"><b>CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td-->
		<td colspan="12" align="center"><img width="250px" height="80px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
		</tr>
		<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="14" align="center"><font size="5"><b>MLO WISE LOADED CONTAINER LIST FOR <?php echo $ddl_imp_rot_no; ?></b></font></td>
		
	</tr>
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="2" align="center"><b>Vessel Name:</b></font></td>
		<td colspan="2" align="center"><b><?php echo $row1->name; ?></b></font></td>
		<td colspan="2" align="center"><b>Berth: </b></font></td>
		<td colspan="2" align="center"><b> <?php echo $row1->berth; ?></b></font></td>
		<td colspan="2" align="center"><b>Berth Operator:</b></font></td>
		<td colspan="4" align="center"><b><?php echo $row1->berth_op; ?></b></font></td>
		
	</tr>
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr>
	<tr bgcolor="#aaffff" align="center">
		<td><b>S/L</b></td>
		<td><b>Container</b></td>
		<td><b>Size</b></td>
		<td><b>Height</b></td>
		<td><b>Freight Kind</b></td>
		<td><b>mlo</b></td>
		
		
		<td><b>Position</b></td>
		<td><b>Seal No</b></td>
		<td><b>Weight</b></td>
		<td><b>Port of Discharge</b></td>
		<td><b>Trailer No</b></td>
		<td><b>Crain Id</b></td>
	</tr>

<?php
	
	//mlo is changed to cont_mlo (of mis_exp_unit)
	$query=mysql_query("select id,size,height,freight_kind,cont_mlo,mlo_name,stowage_pos,
	pod,seal_no,mis_exp_unit.goods_and_ctr_wt_kg as goods_and_ctr_wt_kg,truck_no,craine_id 
	from ctmsmis.mis_exp_unit 
	inner join ctmsmis.mis_inv_unit on mis_inv_unit.gkey=mis_exp_unit.gkey 
	where mis_exp_unit.vvd_gkey='$vvdGkey'AND preAddStat='0' and snx_type=0 order by pod,cont_mlo");
	
	$i=0;
	$j=0;
	
	$pod="";
	while($row=mysql_fetch_object($query)){
	$i++;
	
	if($pod!=$row->pod){
		if($j>0){
		?>
		<tr bgcolor="#aaffff" valign="center"><td colspan="2"><font size="4"><b>&nbsp;&nbsp;Total Container (<?php echo $pod; ?>):</b></font></td><td  colspan="15">&nbsp;&nbsp;<font size="4"><b><?php  echo $j;?></b></font></td></tr>
		<?php
		}
		?>
		<tr bgcolor="#F0F4CA" valign="center"><td  colspan="15">&nbsp;&nbsp;<font size="4"><b><?php  if($row->pod) echo "(".$row->pod.") ".$row->pod; else echo "&nbsp;"; ?></b></font></td></tr>
		<?php
		
		
		$j=1;
		
	}else{
		$j++;
		
	}
	$pod=$row->pod;
	
	
?>
<tr align="center">
		<td><?php if($row->id) echo $j; else echo "&nbsp;";?></td>
		<td><?php if($row->id) echo $row->id; else echo "&nbsp;";?></td>
		<td><?php if($row->size) echo $row->size; else echo "&nbsp;";?></td>
		<td><?php if($row->height) echo $row->height; else echo "&nbsp;";?></td>
		<td><?php if($row->freight_kind) echo $row->freight_kind; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_mlo) echo $row->cont_mlo; else echo "&nbsp;";?></td>
		
		
		<td><?php if($row->stowage_pos) echo $row->stowage_pos; else echo "&nbsp;";?></td>
		<td><?php if($row->seal_no) echo $row->seal_no; else echo "&nbsp;";?></td>
		
		<td><?php if($row->goods_and_ctr_wt_kg) echo $row->goods_and_ctr_wt_kg; else echo "&nbsp;";?></td>
		<td><?php if($row->pod) echo $row->pod; else echo "&nbsp;";?></td>
		<td><?php if($row->truck_no) echo $row->truck_no; else echo "&nbsp;";?></td>
		<td><?php if($row->craine_id) echo $row->craine_id; else echo "&nbsp;";?></td>
		
	</tr>

<?php } ?>
<tr bgcolor="#aaffff" valign="center"><td colspan="2"><font size="4"><b>&nbsp;&nbsp;Total Container (<?php echo $pod; ?>):</b></font></td><td  colspan="15">&nbsp;&nbsp;<font size="4"><b><?php  echo $j;?></b></font></td></tr>
<tr bgcolor="#aaaaff" valign="center"><td colspan="2"><font size="4"><b>&nbsp;&nbsp;Grand Total:</b></font></td><td  colspan="15">&nbsp;&nbsp;<font size="4"><b><?php  echo $i;?></b></font></td></tr>
</table>
<br />
<br />
<!--
<?php
	$sqlSummery=mysql_query("select gkey,
IFNULL(SUM(onboard_LD_20),0) AS onboard_LD_20,
IFNULL(SUM(onboard_LD_40),0) AS onboard_LD_40,
IFNULL(SUM(onboard_MT_20),0) AS onboard_MT_20,
IFNULL(SUM(onboard_MT_40),0) AS onboard_MT_40,
IFNULL(SUM(onboard_LD_tues),0) AS onboard_LD_tues,
IFNULL(SUM(onboard_MT_tues),0) AS onboard_MT_tues

 from (
select distinct ctmsmis.mis_exp_unit.gkey as gkey,
(CASE WHEN size = '20' AND freight_kind in ('FCL','LCL')  THEN 1  
ELSE NULL END) AS onboard_LD_20, 
(CASE WHEN size > '20' AND freight_kind in ('FCL','LCL')  THEN 1  
ELSE NULL END) AS onboard_LD_40,
(CASE WHEN size = '20' AND freight_kind ='MTY'  THEN 1  
ELSE NULL END) AS onboard_MT_20, 
(CASE WHEN size > '20' AND freight_kind ='MTY'  THEN 1  
ELSE NULL END) AS onboard_MT_40, 
(CASE WHEN size=20 AND freight_kind in ('FCL','LCL') THEN 1 
ELSE (CASE WHEN size>20 AND freight_kind in ('FCL','LCL') THEN 2 ELSE NULL END) END) AS onboard_LD_tues, 
(CASE WHEN size=20 AND freight_kind='MTY' THEN 1 
ELSE (CASE WHEN size>20 AND freight_kind='MTY' THEN 2 ELSE NULL END) END) AS onboard_MT_tues

FROM ctmsmis.mis_exp_unit
inner join ctmsmis.mis_inv_unit on ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
where  mis_exp_unit.vvd_gkey='$vvdGkey'AND preAddStat='0'
) as tmp");
$rowSummery=mysql_fetch_object($sqlSummery);


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
<tr><td colspan="12" align="center"><font size="4"><b><u>Export Summary Report</u></b></font></td></tr>
<tr><td colspan="12" align="center"><font size="4"><b>&nbsp;</b></font></td></tr>
</table>
<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<tr>
		<td colspan="6" align="center">TOTAL ONBOARD</td>
		<td colspan="6" align="center">BALANCE TO LOAD</td>
	</tr>
	<tr>
		<td colspan="2" align="center">LADEN</td>
		<td colspan="2" align="center">EMPTY</td>
		<td colspan="2" align="center">TUES</td>
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
		<td align="center">20</td>
		<td align="center">40</td>
		<td align="center">20</td>
		<td align="center">40</td>
		<td align="center">LD</td>
		<td align="center">MT</td>
	</tr>
	<tr>
		<td align="center"><?php if($rowSummery->onboard_LD_20) echo $rowSummery->onboard_LD_20; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery->onboard_LD_40) echo $rowSummery->onboard_LD_40; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery->onboard_MT_20) echo $rowSummery->onboard_MT_20; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery->onboard_MT_40) echo $rowSummery->onboard_MT_40; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery->onboard_LD_tues) echo $rowSummery->onboard_LD_tues; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery->onboard_MT_tues) echo $rowSummery->onboard_MT_tues; else echo "&nbsp;"; ?></td>
	
		<td align="center"><?php if($rowSummery2->balance_LD_20) echo $rowSummery2->balance_LD_20; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery2->balance_LD_40) echo $rowSummery2->balance_LD_40; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery2->balance_MT_20) echo $rowSummery2->balance_MT_20; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery2->balance_MT_40) echo $rowSummery2->balance_MT_40; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery2->balance_LD_tues) echo $rowSummery2->balance_LD_tues; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery2->balance_MT_tues) echo $rowSummery2->balance_MT_tues; else echo "&nbsp;"; ?></td>
		

		
	</tr>
</table>
-->
<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>		
	</BODY>
</HTML>
<?php }?>