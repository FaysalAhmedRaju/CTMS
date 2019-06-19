
<?php 
	//$ddl_imp_rot_no=$_REQUEST['ddl_imp_rot_no']; 

	include("dbConection.php");
	
	$sql=mysql_query("select vvd_gkey from sparcsn4.vsl_vessel_visit_details where ib_vyg='$ddl_imp_rot_no'");
	$row=mysql_fetch_object($sql);
	$vvdGkey=$row->vvd_gkey;
	
	$sql1=mysql_query("SELECT vsl_vessels.name,DATE(ata) AS arrival
	FROM sparcsn4.vsl_vessel_visit_details
	INNER JOIN sparcsn4.argo_carrier_visit ON  sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
	INNER JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
	WHERE vsl_vessel_visit_details.vvd_gkey=$vvdGkey");
	$row1=mysql_fetch_object($sql1);
	
	?>
<html>
<!--title>GARMENTS ITEM CONTAINER LIST</title-->
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
	<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="12" align="center"><img align="middle"  width="235px" height="75px" src="<?php echo IMG_PATH?>cpanew.jpg"><br/><font size="4"><b>GARMENTS ITEM CONTAINER LIST</b></font></td>
	</tr>
	<!--tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="14" align="center"><font size="5"><b>GARMENTS ITEM CONTAINER LIST</b></font></td>
	</tr-->
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="7" align="center"><b>Vessel Name:  </b><?php echo $row1->name.","; ?><b>  Rotation:  </b><?php echo $ddl_imp_rot_no.","; ?><b>  Date of Arrival:  </b><?php echo $row1->arrival; ?></td>		
	</tr>
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="10" align="center"></td>		
	</tr>
</table>
	<table align="center" width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<tr bgcolor="#aaffff" align="center">
		<td align="center" style="width:8%"><b>S/L</b></td>
		<td align="center" style="width:18%"><b>Container</b></td>
		<td align="center" style="width:8%"><b>Size</b></td>
		<td align="center" style="width:8%"><b>Height</b></td>
		<td align="center" style="width:22%"><b>Discharge Time</b></td>
		<td align="center" style="width:22%"><b>Gateout Time</b></td>
		<td align="center" style="width:8%"><b>Dwel Time</b></td>
	</tr>

<?php
	
	//echo "select id,size,height,freight_kind,mlo,mlo_name,stowage_pos,pod,seal,mis_exp_unit.goods_and_ctr_wt_kg as goods_and_ctr_wt_kg,truck_no,craine_id from ctmsmis.mis_exp_unit inner join ctmsmis.mis_inv_unit on mis_inv_unit.gkey=mis_exp_unit.gkey where mis_exp_unit.vvd_gkey=$vvdGkey";
	//echo$vvdGkey;
	$query=mysql_query(" SELECT *,
	(CASE 
		WHEN duel<=4 AND time_out IS NOT NULL THEN 1
		WHEN duel>4 AND duel<=12 AND time_out IS NOT NULL THEN 2
		WHEN duel>12 AND duel<=28 AND time_out IS NOT NULL THEN 3
		WHEN duel>28 OR time_out IS NULL THEN 4
	ELSE 0 END) AS sl,
	(CASE 
		WHEN duel<=4 AND time_out IS NOT NULL THEN '0-4 days'
		WHEN duel>4 AND duel<=12 AND time_out IS NOT NULL THEN '5-12 days'
		WHEN duel>12 AND duel<=28 AND time_out IS NOT NULL THEN '13-28 days'
		WHEN duel>28 OR time_out IS NULL THEN '29-56 or more days'
	ELSE 0 END) AS dweldays
	FROM (
	SELECT inv_unit.id,sparcsn4.inv_unit_fcy_visit.time_in,sparcsn4.inv_unit_fcy_visit.time_out,
	ref_commodity.short_name,TIMESTAMPDIFF(DAY,time_in,IFNULL(time_out,NOW())) AS duel,
	RIGHT(sparcsn4.ref_equip_type.nominal_length,2) AS size,
	RIGHT(sparcsn4.ref_equip_type.nominal_height,2)/10 AS height	   
	FROM sparcsn4.inv_unit 
	INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey 
	INNER JOIN sparcsn4.inv_unit_equip ON inv_unit.gkey=inv_unit_equip.unit_gkey 
	INNER JOIN sparcsn4.ref_equipment ON inv_unit_equip.eq_gkey=ref_equipment.gkey
	INNER JOIN sparcsn4.ref_equip_type ON ref_equipment.eqtyp_gkey=ref_equip_type.gkey     
	INNER JOIN sparcsn4.argo_carrier_visit ON  argo_carrier_visit.gkey=inv_unit.declrd_ib_cv
	INNER JOIN sparcsn4.inv_goods ON inv_unit.goods=inv_goods.gkey
	INNER JOIN sparcsn4.ref_commodity ON sparcsn4.inv_goods.commodity_gkey=ref_commodity.gkey
	INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
	WHERE sparcsn4.inv_unit.category='IMPRT'  
	AND sparcsn4.vsl_vessel_visit_details.ib_vyg='$ddl_imp_rot_no'
	) AS a WHERE short_name LIKE '%gar%' ORDER BY 5");
	$i=0;
	$j=0;
	
	$dweldays="";
	while($row=mysql_fetch_object($query)){
	$i++;
	
	if($dweldays!=$row->dweldays){
		if($j>0){
		?>	
		<tr bgcolor="#aaffff"><td valign="center" colspan="6"><font size="4"><b>&nbsp;&nbsp;Total Container (<?php echo $dweldays; ?>):</b></font></td><td align="center">&nbsp;&nbsp;<font size="4"><b><?php  echo $j;?></b></font></td></tr>
		<?php
		}
		?>
		<tr bgcolor="#F0F4CA"><td  valign="center" colspan="7">&nbsp;&nbsp;<font size="4"><b><?php  if($row->dweldays) echo $row->dweldays; else echo "&nbsp;"; ?></b></font></td></tr>
		<?php
		
		
		$j=1;
		
	}else{
		$j++;		
	}
	$dweldays=$row->dweldays;
	
	
?>
     
<tr align="center">
		<td align="center" ><?php if($row->id) echo $j; else echo "&nbsp;";?></td>
		<td align="center" ><?php if($row->id) echo $row->id; else echo "&nbsp;";?></td>
		<td align="center" ><?php if($row->size) echo $row->size; else echo "&nbsp;";?></td>
		<td align="center" ><?php if($row->height) echo $row->height; else echo "&nbsp;";?></td>
		<td align="center" ><?php if($row->time_in) echo $row->time_in; else echo "&nbsp;";?></td>
		
		
		<td align="center" ><?php if($row->time_out) echo $row->time_out; else echo "Still in Yard";?></td>
		<td align="center"><?php echo $row->duel;?></td>
		
</tr>

<?php } ?>
<tr bgcolor="#aaffff" valign="center"><td colspan="6"><font size="4"><b>&nbsp;&nbsp;Total Container (<?php echo $dweldays; ?>):</b></font></td><td align="center" >&nbsp;&nbsp;<font size="4"><b><?php  echo $j;?></b></font></td></tr> 
<tr bgcolor="#aaaaff" valign="center"><td colspan="6"><font size="4"><b>&nbsp;&nbsp;Grand Total:</b></font></td><td align="center" >&nbsp;&nbsp;<font size="4"><b><?php  echo $i;?></b></font></td></tr>
</table>
<br />
<br />

<?php
mysql_close($con_sparcsn4);
 if($_POST['options']=='html'){?>		
	</BODY>
</HTML>
<?php }?>