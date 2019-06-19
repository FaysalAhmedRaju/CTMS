<html>
<head>
		<div align="center" style="font-size:18px">
			<!--title>CHITTAGONG PORT AUTHORITY</title-->
		</div>
		<!--div align="center"><h1>Chittagong Port Authority </h1></div>
		<div align="center"><h3>Import Discharge Report</h3></div>
		<div align="center"><h3><?php echo "Rotation : ".$rotNo; ?></h3></div-->
		<?php 
			include("dbConection.php");
			$getVvdQry="select vvd_gkey from sparcsn4.vsl_vessel_visit_details where ib_vyg='$rotation'";
			$rtnVvdQry=mysql_query($getVvdQry);
			$row=mysql_fetch_object($rtnVvdQry);
			$vvdGkey=$row->vvd_gkey;
			$balance=$getTotal-$dischargeTotal; 
		?>

</head>
<body>	
		<div align ="center">
			<div align="center" style="font-size:18px">
				<img align="middle" height="80" width="200" src="<?php echo IMG_PATH?>cpanew.jpg">
			</div>
		<table align="center" width="80%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
			<!--tr><td colspan="13" align="center"><h3><img src="<?php echo IMG_PATH; ?>cpanew.jpg"</h3></td></tr-->
			<tr><td colspan="13" align="center"><h3>Import Discharge Report</h3></td></tr>
			<tr><td colspan="13" align="center"><h3><?php echo "Rotation : ".$rotNo; ?></h3></td></tr>
			<tr><td colspan="13" align="center"><h3><?php echo "Total: ".$getTotal."&nbsp;&nbsp;&nbsp;&nbsp;   Discharge: ".$dischargeTotal."&nbsp;&nbsp;&nbsp;&nbsp; Balance: ".$balance; ?></h3></th></tr>
		</table>
		
		<?php 	if($flag==0) { ?>
		
		<table align="center" width="80%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
		<thead>
			<tr bgcolor="#aaffff" align="center">
				<th><b>S/L</b></th>
				<th><b>Container</b></th>
				<!--th><b>Mlo</b></th-->
				<th><b>Size</b></th>
				<th><b>Height</b></th>
				<th><b>Freight Kind</b></th>
				
				<th><b>Position</b></th>
				<th><b>Seal No</b></th>
				<th><b>Weight</b></td>
				<th><b>Port of Discharge</b></th>
				<th><b>Trailer No</b></th>
				<th><b>Crain Id</b></th>
				<th><b>Load By</b></th>
				<th><b>Time</b></th>
				<th><b>Status</b></th>
			</tr>
		</thead>
<?php
	
	$getContQuery="SELECT ctmsmis.mis_inv_unit.id,ctmsmis.mis_inv_unit.fcy_time_in,
					ctmsmis.mis_inv_unit.fcy_last_pos_slot AS location,ctmsmis.mis_inv_unit.inv_seal_nbr1 AS sealno,
					sparcsn4.ref_equip_type.id AS iso,mlo,mlo_name,ctmsmis.mis_inv_unit.size,LEFT(ctmsmis.mis_inv_unit.height/10,3) as height,ctmsmis.mis_inv_unit.freight_kind,ctmsmis.mis_inv_unit.goods_and_ctr_wt_kg AS weight,
					ref_commodity.short_name,ctmsmis.mis_inv_unit.remark,ctmsmis.mis_inv_unit.last_update
					FROM  ctmsmis.mis_inv_unit 
					LEFT JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=ctmsmis.mis_inv_unit.goods
					LEFT JOIN sparcsn4.ref_commodity ON sparcsn4.ref_commodity.gkey=sparcsn4.inv_goods.commodity_gkey
					INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.unit_gkey=ctmsmis.mis_inv_unit.gkey
					INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
					INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
					WHERE mis_inv_unit.vvd_gkey='$vvdGkey' AND category='IMPRT' AND fcy_time_in IS NOT NULL
					order by mlo,id asc";
	//echo $getContQuery;
	$rtnQuery=mysql_query($getContQuery);
	$i=0;
	$j=0;
	$k=0;
	$mlo="";
	$yard="";
	while($rowCont=mysql_fetch_object($rtnQuery)){
	$i++;
	// APPS QUERY 
	$getAppsDataQuery="select id,size,height,freight_kind,mlo,mlo_name,current_position,pod,seal_no,mis_exp_unit.goods_and_ctr_wt_kg as goods_and_ctr_wt_kg,
			truck_no,craine_id,ctmsmis.mis_exp_unit.user_id,mis_exp_unit.last_update 
			from ctmsmis.mis_exp_unit 
			inner join ctmsmis.mis_inv_unit on mis_inv_unit.gkey=mis_exp_unit.gkey 
			where mis_exp_unit.rotation='$rotation' and  mis_exp_unit.snx_type=2 and id= '".$rowCont->id."' order by mis_exp_unit.last_update desc";
	$rtnAppsData=mysql_query($getAppsDataQuery);
	$rowAppsData=mysql_fetch_object($rtnAppsData);
	
	//$sql="call ctmsmis.update_containers_by_vvd_gkey($vvdGkey)";
	//$res=mysql_query($sql);
	//echo "select id,size,height,freight_kind,mlo,mlo_name,stowage_pos,pod,seal,mis_exp_unit.goods_and_ctr_wt_kg as goods_and_ctr_wt_kg,truck_no,craine_id from ctmsmis.mis_exp_unit inner join ctmsmis.mis_inv_unit on mis_inv_unit.gkey=mis_exp_unit.gkey where mis_exp_unit.vvd_gkey=$vvdGkey";
	//$query=mysql_query("select id,size,height,freight_kind,mlo,mlo_name,stowage_pos,pod,seal_no,mis_exp_unit.goods_and_ctr_wt_kg as goods_and_ctr_wt_kg,truck_no,craine_id,ctmsmis.mis_exp_unit.user_id from ctmsmis.mis_exp_unit inner join ctmsmis.mis_inv_unit on mis_inv_unit.gkey=mis_exp_unit.gkey where mis_exp_unit.vvd_gkey=$vvdGkey and  mis_exp_unit.snx_type!=2 order by mlo,id");
	
	/*$sql="select id,size,height,freight_kind,mlo,mlo_name,current_position,pod,seal_no,mis_exp_unit.goods_and_ctr_wt_kg as goods_and_ctr_wt_kg,truck_no,craine_id,
	ctmsmis.mis_exp_unit.user_id,mis_exp_unit.last_update from ctmsmis.mis_exp_unit 
	inner join ctmsmis.mis_inv_unit on mis_inv_unit.gkey=mis_exp_unit.gkey where mis_exp_unit.rotation='$rotation' and  mis_exp_unit.snx_type=2 order by current_position,id";
	//echo $sql;
	$query=mysql_query($sql);*/
	
	//$i=0;


	//while($row=mysql_fetch_object($query)){
	
	// Current Position
	
	if($rowAppsData->id)		
		$rowCurPos=$rowAppsData->current_position;
	else
		$rowCurPos=$rowCont->location;
	
	// Current Mlo
	if($rowAppsData->id)		
		$rowMlo=$rowAppsData->mlo;
	else
		$rowMlo=$rowCont->mlo;
		
	/*if($yard!=$rowCurPos){
		if($j>0){
		?>
		<tr bgcolor="#aaffff" valign="center"><td colspan="2"><font size="4"><b>&nbsp;&nbsp;Total Container (<?php echo $current_position; ?>):</b></font></td><td  colspan="14">&nbsp;&nbsp;<font size="4"><b><?php  echo $j;?></b></font></td></tr>
		<?php
		}
		?>
		<tr bgcolor="#F7819F" valign="center"><td  colspan="14">&nbsp;&nbsp;<font size="4"><b><?php  if($rowAppsData->current_position) echo "(".$rowAppsData->current_position.") "; else echo $rowCont->location; ?></b></font></td></tr>
		
		<?php
		
		
		$j=1;
		
	}else{
		$j++;
		
	}*/
	//echo $rowCont->location." : Position";
	if($mlo!=$rowMlo){
		 
		if($k>0){
		?>
		<tr bgcolor="#aaffff" valign="center"><td colspan="2"><font size="4"><b>&nbsp;&nbsp;Total Container (<?php echo $current_position; ?>):</b></font></td><td  colspan="14">&nbsp;&nbsp;<font size="4"><b><?php  echo $k;?></b></font></td></tr>
		<?php
		}
		?>
		<tr bgcolor="#F0F4CA" valign="center"><td  colspan="14">&nbsp;&nbsp;<font size="4"><b><?php  if($rowAppsData->mlo) echo "(".$rowAppsData->mlo.") ".$rowAppsData->mlo_name; else echo "(".$rowCont->mlo.") ".$rowCont->mlo_name; ?></b></font></td></tr>
		
		<?php
		$k=1;
		
	}
	else{
		$k++;
	}
	
	/*if($rowAppsData->id)
		
		$yard=$rowAppsData->current_position;
	else
		$yard=$rowCont->location;*/
	
	if($rowAppsData->id)
		
		$mlo=$rowAppsData->mlo;
	else
		$mlo=$rowCont->mlo;
	
	
	
?>
<tr align="center">
		<td><?php echo $i; ?></td>
		<td><?php if($rowAppsData->id) echo $rowAppsData->id; else echo $rowCont->id;?></td>
		<!--td><?php if($rowAppsData->id) echo $rowAppsData->mlo; else echo $rowCont->mlo;?></td-->
		<td><?php if($rowAppsData->size) echo $rowAppsData->size; else echo $rowCont->size;?></td>
		<td><?php if($rowAppsData->height) echo $rowAppsData->height/10; else echo $rowCont->height;?></td>
		<td><?php if($rowAppsData->freight_kind) echo $rowAppsData->freight_kind; else echo $rowCont->freight_kind;?></td>
		
		<!--td><?php if($rowAppsData->stowage_pos) echo $rowAppsData->stowage_pos; else echo "&nbsp;";?></td-->
		<td><?php if($rowAppsData->current_position) echo $rowAppsData->current_position; else echo $rowCont->location;?></td>
		<td><?php if($rowAppsData->current_position) echo $rowAppsData->seal_no; else echo $rowCont->sealno;?></td>
		
		<td><?php if($rowAppsData->id) echo $rowAppsData->goods_and_ctr_wt_kg; else echo $rowCont->weight;?></td> 
		<td><?php if($rowAppsData->id) echo $rowAppsData->pod; else echo "&nbsp;";?></td>
		<td><?php if($rowAppsData->id) echo $rowAppsData->truck_no; else echo "&nbsp;";?></td>
		<td><?php if($rowAppsData->id) echo $rowAppsData->craine_id; else echo "&nbsp;";?></td>
		<td><?php if($rowAppsData->user_id) echo $rowAppsData->user_id; else echo "&nbsp;";?></td>
		<td><?php if($rowAppsData->last_update) echo $rowAppsData->last_update; else echo $rowCont->last_update;?></td>
		<td><?php if($rowAppsData->id) echo "APPS"; else echo "Others";?></td>
		
	</tr>

<?php } ?>
<!--tr bgcolor="#aaffff" valign="center"><td colspan="2"><font size="4"><b>&nbsp;&nbsp;Total Container (<?php echo $mlo; ?>):</b></font></td><td  colspan="13">&nbsp;&nbsp;<font size="4"><b><?php  echo $j;?></b></font></td></tr>
<tr bgcolor="#aaaaff" valign="center"><td colspan="2"><font size="4"><b>&nbsp;&nbsp;Grand Total:</b></font></td><td  colspan="12">&nbsp;&nbsp;<font size="4"><b><?php  echo $i;?></b></font></td></tr-->
       
		 
		</table>
	<?php 	} else { ?>
			<table align="center" width="80%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
		<thead>
			<tr bgcolor="#aaffff" align="center">
				<th><b>S/L</b></th>
				<th><b>Container</b></th>
				<!--th><b>Mlo</b></th-->
				<th><b>Size</b></th>
				<th><b>Height</b></th>
				<th><b>Freight Kind</b></th>
				
				<th><b>Position</b></th>
				<th><b>Seal No</b></th>
				<th><b>Weight</b></td>
				<th><b>Port of Discharge</b></th>
				<th><b>Trailer No</b></th>
				<th><b>Crain Id</b></th>
				<th><b>Load By</b></th>
				<th><b>Time</b></th>
				<th><b>Status</b></th>
			</tr>
		</thead>
		
		<?php 
		$k=0;
		for($counter=0; $counter < count($getList); $counter++) { ?>
		<?php
			if($mlo!=$getList[$counter]['mlo'])
			{
				if($k>0){
				?>
				<tr bgcolor="#aaffff" valign="center"><td colspan="2"><font size="4"><b>&nbsp;&nbsp;Total Container :</b></font></td><td  colspan="14">&nbsp;&nbsp;<font size="4"><b><?php  echo $k;?></b></font></td></tr>
				<?php
				}
				?>
				<tr bgcolor="#F0F4CA" valign="center"><td  colspan="14">&nbsp;&nbsp;<font size="4"><b><?php  if($getList[$counter]['mlo']) echo "(".$getList[$counter]['mlo'].") ".$getList[$counter]['mlo_name']; else ""; ?></b></font></td></tr>
			
			<?php
			$k=1;
		
			}
			else{
				$k++;
			}
			$mlo=$getList[$counter]['mlo'];
			?>
		<tr align="center">		
		
			<td><?php echo $counter+1; ?></td>
			<td><?php echo $getList[$counter]['id'];?></td>
			<!--td><?php  echo $getList[$counter]['mlo'];?></td-->
			<td><?php  echo $getList[$counter]['size'];;?></td>
			<td><?php  echo $getList[$counter]['height'];?></td>
			<td><?php  echo $getList[$counter]['freight_kind'];?></td>
			
			<!--td><?php  echo "&nbsp;";?></td-->
			<td><?php   echo $getList[$counter]['current_position'];?></td>
			<td><?php  echo $getList[$counter]['seal_no'];?></td>
			
			<td><?php  echo $getList[$counter]['goods_and_ctr_wt_kg'];?></td> 
			<td><?php  echo $getList[$counter]['pod'];?></td>
			<td><?php  echo $getList[$counter]['truck_no'];?></td>
			<td><?php  echo $getList[$counter]['craine_id'];?></td>
			<td><?php  echo $getList[$counter]['user_id'];?></td>
			<td><?php  echo $getList[$counter]['last_update'];?></td>
			<td><?php  echo "APPS";?></td>			
		</tr>
		<?php } ?>
	<?php 	} ?>
		
		</div>
</br>
<table align="center" width="80%" border ='1' cellpadding='0' cellspacing='0'>
	<tr  bgcolor="#F7819F" ><td colspan="13"><b>IMPORT CONTAINER BALANCE ON BOARD LIST:<b></td></tr>
	<tr align="center">
		<td style="border-width:3px;border-style: double;"><b>SlNo.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Container No.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Discharge Time.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Location.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Seal No</b></td>
		<td style="border-width:3px;border-style: double;"><b>Type</b></td>
		<td style="border-width:3px;border-style: double;"><b>MLO</b></td>
		<td style="border-width:3px;border-style: double;"><b>Status</b></td>		
		<td style="border-width:3px;border-style: double;"><b>Weight</b></td>
		<td style="border-width:3px;border-style: double;"><b>IMCO</b></td>
		<td style="border-width:3px;border-style: double;"><b>Commodity</b></td>
		<td style="border-width:3px;border-style: double;"><b>Remarks</b></td>
		<td style="border-width:3px;border-style: double;"><b>User Id</b></td>
		
	</tr>

<?php
	$getBalContQry="SELECT ctmsmis.mis_inv_unit.id,ctmsmis.mis_inv_unit.fcy_time_in,
					ctmsmis.mis_inv_unit.fcy_last_pos_slot AS location,ctmsmis.mis_inv_unit.inv_seal_nbr1 AS sealno,
					sparcsn4.ref_equip_type.id AS iso,mlo,ctmsmis.mis_inv_unit.freight_kind,ctmsmis.mis_inv_unit.goods_and_ctr_wt_kg AS weight,
					ref_commodity.short_name,ctmsmis.mis_inv_unit.remark
					FROM  ctmsmis.mis_inv_unit 
					LEFT JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=ctmsmis.mis_inv_unit.goods
					LEFT JOIN sparcsn4.ref_commodity ON sparcsn4.ref_commodity.gkey=sparcsn4.inv_goods.commodity_gkey
					INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.unit_gkey=ctmsmis.mis_inv_unit.gkey
					INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
					INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
					WHERE mis_inv_unit.vvd_gkey='$vvdGkey' and category='IMPRT' AND fcy_transit_state='S20_INBOUND' order by id asc";
	//echo $getBalContQry;
	$rtnBalCont=mysql_query($getBalContQry);
	$i=0;
	$j=0;
	
	$mlo="";
	while($rowBalCont=mysql_fetch_object($rtnBalCont)){
	$i++;
	
		
	
?>
<tr align="center">
		<td><?php  echo $i;?></td>
		<td><?php if($rowBalCont->id) echo $rowBalCont->id; else echo "&nbsp;";?></td>
		<td><?php if($rowBalCont->fcy_time_in) echo $rowBalCont->fcy_time_in; else echo "&nbsp;";?></td>
		<td><?php if($rowBalCont->location) echo $rowBalCont->location; else echo "&nbsp;";?></td>
		<td><?php if($rowBalCont->sealno) echo $rowBalCont->sealno; else echo "&nbsp;";?></td>
		<td><?php if($rowBalCont->iso) echo $rowBalCont->iso; else echo "&nbsp;";?></td>
		<td><?php if($rowBalCont->mlo) echo $rowBalCont->mlo; else echo "&nbsp;";?></td>
		<td><?php if($rowBalCont->freight_kind) echo $rowBalCont->freight_kind; else echo "&nbsp;";?></td>
		<td><?php if($rowBalCont->weight) echo $rowBalCont->weight; else echo "&nbsp;";?></td>
		<td><?php  echo "&nbsp;";?></td>
		<td><?php if($rowBalCont->short_name) echo $rowBalCont->short_name; else echo "&nbsp;";?></td>
		<td><?php echo "&nbsp;";?></td>
		<td><?php if($rowBalCont->user_id) echo $rowBalCont->user_id; else echo "&nbsp;";?></td>
				
	</tr>

<?php } ?>
</table>
</body>
</html>
