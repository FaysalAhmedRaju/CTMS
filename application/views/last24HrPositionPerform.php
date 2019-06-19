<?php
	include("mydbPConnectionn4.php");
	?>
<html>

	<body>
		<div>
			<div align="center">
			</div>	
			<div align="center">
			
			<table border=0 width="100%">
				<tr align="center">
					<td><img align="middle"  width="235px" height="80x" src="<?php echo IMG_PATH?>cpanew.jpg"></td></tr>
			
				<tr align="center">
					<td colspan="10"><font size="4"><b>LAST 24 HOURS POSITION</b></font></td>
				</tr>
				<tr align="center">
					<td colspan="10"><font size="4">Date: <?php echo $date; ?></font></td>
				</tr>
				<tr align="center">
					<td colspan="10"><font size="4">Unit: <?php echo $unit; ?></font></td>
				</tr>	
			</table>
	
	<style>
	.column {
  float: left;
  width: 50%;
  padding: 10px;
  height: 300px; /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
	</style>
	<?php
			
			$yards="SELECT block FROM ctmsmis.yard_block WHERE block_unit='$unit'";
	
		  	$sql=mysql_query("SELECT Block_No,size,COUNT(id) AS tot_cont FROM (
			SELECT a.id,
			(SELECT ctmsmis.cont_yard(b.last_pos_slot)) AS Yard_No,
			(SELECT ctmsmis.cont_block(b.last_pos_slot,Yard_No)) AS Block_No,
			(CASE
			WHEN (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip		
			INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
			INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
			WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey LIMIT 1)=20 THEN 20

			ELSE 40 END ) AS size


			FROM sparcsn4.inv_unit a  
			INNER JOIN sparcsn4.inv_unit_fcy_visit b ON b.unit_gkey=a.gkey 
			WHERE a.category='IMPRT' AND b.transit_state='S40_YARD' AND a.freight_kind!='MTY'
			) AS tbl
			WHERE Block_No IN ($yards) 
			GROUP BY Block_No,size
			ORDER BY Block_No,size");
				
			
	//$row=mysql_fetch_object($sql);	
	
	
	?>
	<div>		
		<table width="90%" border ='1' cellpadding='0' cellspacing='0' >

		<tr align="center">
			<td rowspan=2 colspan=2>OPENING BALANCE </td>
			<td colspan=3>APPRAISEMENT</td>
			<td colspan=3>DELIVERY</td>
			<td rowspan=2>RECEIVING</td>
			<td rowspan=2>REMOVAL</td>
			<td rowspan=2>SHIPMENT</td>
			<td rowspan=2>CLOSING BALANCE</td>
		</tr>
		<tr align="center">			
			<td>ASSING.</td>
			<td>K/DOWN</td>
			<td>W/DOWN</td>
			<td>ASSING.</td>
			<td>K/DOWN</td>
			<td>W/DOWN</td>
			<!--td>Y-3</td>
			<td>Y-5</td>
			<td>Y-6</td-->
		</tr>

<?php 	
while($row=mysql_fetch_object($sql)){
	$i++;
	 ?>
	<?php 
	$ass_query="SELECT COUNT(id) AS tot_cont_ass
	FROM
	(
	SELECT a.id,(SELECT ctmsmis.cont_yard(b.last_pos_slot)) AS Yard_No,
	(SELECT ctmsmis.cont_block(b.last_pos_slot,Yard_No)) AS Block_No
	FROM sparcsn4.inv_unit a  
	INNER JOIN sparcsn4.inv_unit_fcy_visit b ON b.unit_gkey=a.gkey 
	INNER JOIN sparcsn4.config_metafield_lov ON a.flex_string01=config_metafield_lov.mfdch_value
	WHERE b.flex_date01 BETWEEN CONCAT(DATE_ADD('$date', INTERVAL -1 DAY),' 07:59:59') AND CONCAT('$date',' 08:00:00') 
	AND config_metafield_lov.mfdch_desc LIKE 'APPRAISE%'
	AND
	(SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip		
	INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
	INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
	WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey LIMIT 1)= $row->size
	) AS tbl WHERE Block_No='".$row->Block_No."'";
	$ass_rtn=mysql_query($ass_query);
	$ass_row=mysql_fetch_object($ass_rtn);
	
	$kd_query="SELECT COUNT(id) AS tot_cont_kd
	FROM
	(
	SELECT a.id,(SELECT ctmsmis.cont_yard(b.last_pos_slot)) AS Yard_No,
	(SELECT ctmsmis.cont_block(b.last_pos_slot,Yard_No)) AS Block_No
	FROM sparcsn4.inv_unit a  
	INNER JOIN sparcsn4.inv_unit_fcy_visit b ON b.unit_gkey=a.gkey 
	INNER JOIN sparcsn4.config_metafield_lov ON a.flex_string01=config_metafield_lov.mfdch_value
	WHERE b.flex_date01 BETWEEN CONCAT(DATE_ADD('$date', INTERVAL -1 DAY),' 07:59:59') AND CONCAT('$date',' 08:00:00')
	AND config_metafield_lov.mfdch_desc LIKE 'APPRAISE%'
	AND b.time_in IS NOT NULL
	AND
	(SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip		
	INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
	INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
	WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey LIMIT 1)= $row->size
	) AS tbl WHERE Block_No='".$row->Block_No."'";
	
	$kd_rtn=mysql_query($kd_query);
	$kd_row=mysql_fetch_object($kd_rtn);
	
	
	
	$ass_query_dlv="SELECT COUNT(id) AS tot_cont_ass
	FROM
	(
	SELECT a.id,(SELECT ctmsmis.cont_yard(b.last_pos_slot)) AS Yard_No,
	(SELECT ctmsmis.cont_block(b.last_pos_slot,Yard_No)) AS Block_No
	FROM sparcsn4.inv_unit a  
	INNER JOIN sparcsn4.inv_unit_fcy_visit b ON b.unit_gkey=a.gkey 
	INNER JOIN sparcsn4.config_metafield_lov ON a.flex_string01=config_metafield_lov.mfdch_value
	WHERE b.flex_date01 BETWEEN CONCAT(DATE_ADD('$date', INTERVAL -1 DAY),' 07:59:59') AND CONCAT('$date',' 08:00:00')
	AND config_metafield_lov.mfdch_desc LIKE 'DELIVERY%'
	AND
	(SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip		
	INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
	INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
	WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey LIMIT 1)= $row->size
	) AS tbl WHERE Block_No='".$row->Block_No."'";
	$ass_rtn_dlv=mysql_query($ass_query_dlv);
	$ass_row_dlv=mysql_fetch_object($ass_rtn_dlv);
	
	$kd_query_dlv="SELECT COUNT(id) AS tot_cont_kd
	FROM
	(
	SELECT a.id,(SELECT ctmsmis.cont_yard(b.last_pos_slot)) AS Yard_No,
	(SELECT ctmsmis.cont_block(b.last_pos_slot,Yard_No)) AS Block_No
	FROM sparcsn4.inv_unit a  
	INNER JOIN sparcsn4.inv_unit_fcy_visit b ON b.unit_gkey=a.gkey 
	INNER JOIN sparcsn4.config_metafield_lov ON a.flex_string01=config_metafield_lov.mfdch_value
	WHERE b.flex_date01 BETWEEN CONCAT(DATE_ADD('$date', INTERVAL -1 DAY),' 07:59:59') AND CONCAT('$date',' 08:00:00')
	AND config_metafield_lov.mfdch_desc LIKE 'DELIVERY%'
	AND b.time_in IS NOT NULL
	AND
	(SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip		
	INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
	INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
	WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey LIMIT 1)= $row->size
	) AS tbl WHERE Block_No='".$row->Block_No."'";
	
	$kd_rtn_dlv=mysql_query($kd_query_dlv);
	$kd_row_dlv=mysql_fetch_object($kd_rtn_dlv);
	
	$rcv_qry="SELECT COUNT(*) as tot_cont_rcv FROM
	(
	SELECT sparcsn4.inv_unit.id,
	(SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
	FROM sparcsn4.srv_event
	INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
	WHERE sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey AND sparcsn4.srv_event.event_type_gkey=18) AS pos,
	(SELECT ctmsmis.cont_yard(pos)) AS Yard_No,
	(SELECT ctmsmis.cont_block(pos,Yard_No)) AS Block_No
	FROM sparcsn4.argo_carrier_visit
	INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.actual_ib_cv=sparcsn4.argo_carrier_visit.gkey
	INNER JOIN sparcsn4.inv_unit ON sparcsn4.inv_unit.gkey=sparcsn4.inv_unit_fcy_visit.unit_gkey
	WHERE PHASE IN('40WORKING','60DEPARTED') AND carrier_mode='VESSEL'
	AND sparcsn4.inv_unit_fcy_visit.time_in BETWEEN CONCAT(DATE_ADD('$date', INTERVAL -1 DAY),' 07:59:59') AND CONCAT('$date',' 08:00:00')
	AND
	(SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip		
	INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
	INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
	WHERE sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey LIMIT 1)= $row->size
	) AS tbl WHERE Block_No='".$row->Block_No."'";
	$rtn_rcv=mysql_query($rcv_qry);
	$row_rcv=mysql_fetch_object($rtn_rcv);
	
	// OFFDOCK REMOVAL
	$removal_qry="SELECT COUNT(id) as tot_rmv_cont  FROM 
	( SELECT sparcsn4.inv_unit.id ,
	(SELECT SUBSTRING(sparcsn4.srv_event_field_changes.prior_value,7) FROM sparcsn4.srv_event 
	INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey 
	WHERE sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey AND sparcsn4.srv_event.event_type_gkey 
	IN(22) ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1) AS slot,
	(SELECT ctmsmis.cont_yard(slot)) AS yard_no, 
	(SELECT ctmsmis.cont_block(slot,yard_no)) AS block_no
	FROM sparcsn4.inv_unit 
	INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey 
	INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv 
	INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey 
	INNER JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey 
	INNER JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods 
	INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.inv_unit.line_op
	INNER JOIN sparcsn4.road_truck_transactions ON sparcsn4.road_truck_transactions.unit_gkey=sparcsn4.inv_unit.gkey
	INNER JOIN sparcsn4.road_truck_visit_details ON sparcsn4.road_truck_visit_details.tvdtls_gkey=sparcsn4.road_truck_transactions.truck_visit_gkey
	WHERE sparcsn4.inv_unit_fcy_visit.time_load BETWEEN CONCAT(DATE_ADD('$date', INTERVAL -1 DAY),' 07:59:59') AND CONCAT('$date',' 08:00:00')
	AND sparcsn4.inv_goods.destination NOT IN('2591','2592','BDCGP')
	AND sparcsn4.inv_goods.destination IS NOT NULL AND sparcsn4.road_truck_transactions.status !='CANCEL'
	AND
	(SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip		
	INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
	INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
	WHERE sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey LIMIT 1)= $row->size
	) AS tmp WHERE Block_No = '".$row->Block_No."' ";
	
	$rtn_removal=mysql_query($removal_qry);
	$row_removal=mysql_fetch_object($rtn_removal);
	
	?>
		<tr align="center">
			<td ><?php echo $row->Block_No; ?> </td>
			<td><?php echo $row->tot_cont."    X  ".$row->size."'"; ?></td>
			<td><?php echo $ass_row->tot_cont_ass; ?></td>
			<td><?php echo $kd_row->tot_cont_kd; ?></td>
			<td><?php echo $kd_row->tot_cont_kd; ?></td>
			<td><?php echo $ass_row_dlv->tot_cont_ass; ?></td>
			<td><?php echo $kd_row_dlv->tot_cont_kd; ?></td>
			<td><?php echo $kd_row_dlv->tot_cont_kd; ?></td>
			<td><?php echo $row_rcv->tot_cont_rcv; ?></td>
			<td><?php echo $row_removal->tot_rmv_cont; ?></td>
			<td><?php echo "0"; ?></td>
			<td><?php echo ($row->tot_cont - ($kd_row_dlv->tot_cont_kd+$row_rcv->tot_cont_rcv+$row_removal->tot_rmv_cont))."    X  ".$row->size."'"; ?></td>
		</tr>
<?php } ?>
		
		</table>
	</div>	
	<div width="90%" style="margin-left: 64px;">
	  <div>
	  <table  width="45%" align="left">
		<tr><td>
		<table width="80%" border =0 cellpadding='0' cellspacing='0' >
			<tr><td><nobr>LAST 24 HOURS DELIVERY DATA</nobr></td></tr>
		</table>
		<table width="80%" border ='1' cellpadding='0' cellspacing='0'>
		<?php 
		$size_str="";
		$cont_ton=0;
		$lst_dlv_data="SELECT size,
		COUNT(id) AS tot_cont,SUM(goods_and_ctr_wt_kg)/1000 AS tons
		FROM
		(
		SELECT a.id,goods_and_ctr_wt_kg,

		(SELECT ctmsmis.cont_yard(b.last_pos_slot)) AS Yard_No,
		(SELECT ctmsmis.cont_block(b.last_pos_slot,Yard_No)) AS Block_No,
		(CASE
		WHEN (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip		
		INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
		INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
		WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey LIMIT 1)=20 THEN 20
		ELSE 40 END ) AS size

		FROM sparcsn4.inv_unit a  
		INNER JOIN sparcsn4.inv_unit_fcy_visit b ON b.unit_gkey=a.gkey 
		WHERE b.flex_date01 BETWEEN CONCAT(DATE_ADD('$date', INTERVAL -1 DAY),' 07:59:59') AND CONCAT('$date',' 08:00:00')
		) AS tbl WHERE Block_No IN ($yards) 
		GROUP BY size
		order by size";
		$rtn_lst_dlv_data=mysql_query($lst_dlv_data);
		while($row_lst_dlv_data=mysql_fetch_object($rtn_lst_dlv_data))
		{
			if($row_lst_dlv_data->size=='20')
			{
				$size_str=$size_str.$row_lst_dlv_data->tot_cont." X 20 ";
			}
			else
			{
				$size_str=$size_str." + ".$row_lst_dlv_data->tot_cont." X 40 ";
			}
			
			$cont_ton = $cont_ton+$row_lst_dlv_data->tons;
		}
		?>
		
			<tr>
				<td><nobr>TOTAL DELIVERY</nobr></td>
				<td><?php echo $size_str; ?></td>
			</tr>
			<tr>
				<td>PACKAGES</td>
				<td><?php echo ""; ?></td>
			</tr>
			<tr>
				<td>TONS</td>
				<td><?php echo $cont_ton; ?></td>
			</tr>
		</table>
		
			  <table><tr><td>&nbsp;</td></tr></table>
	<?php 
				$fcl_query="SELECT 
				SUM(tot_del_20_day) AS tot_del_20_day,SUM(tot_del_20_eve) AS tot_del_20_eve,SUM(tot_del_20_night) AS tot_del_20_night,
				SUM(tot_del_40_day) AS tot_del_40_day,SUM(tot_del_40_eve) AS tot_del_40_eve,SUM(tot_del_40_night) AS tot_del_40_night,
				SUM(tot_app_20) AS tot_app_20,SUM(tot_app_40) AS tot_app_40
				FROM 
				(

				SELECT 
				(SELECT ctmsmis.cont_yard(b.last_pos_slot)) AS Yard_No,
				(SELECT ctmsmis.cont_block(b.last_pos_slot,Yard_No)) AS Block_No,
				a.id,b.flex_date01,CONCAT(DATE(b.flex_date01),' 08:00:00') AS tt,
				(CASE  
				  WHEN b.flex_date01 BETWEEN  CONCAT(DATE_ADD('$date', INTERVAL -1 DAY),' 08:00:01') AND CONCAT(DATE_ADD('$date', INTERVAL -1 DAY),' 16:00:00') THEN 'DAY' 
				  WHEN b.flex_date01 BETWEEN  CONCAT(DATE_ADD('$date', INTERVAL -1 DAY),' 16:00:01') AND CONCAT(DATE_ADD('$date', INTERVAL -1 DAY),' 00:00:00') THEN 'EVENING'
				  WHEN b.flex_date01 BETWEEN  CONCAT('$date',' 00:00:01') AND CONCAT('$date',' 08:00:00') THEN 'NIGHT'
				  ELSE 'OTHER' END
				  ) AS shift,
				 (SELECT CASE
				WHEN UCASE(mfdch_desc) LIKE 'DELIVERY%' AND
				b.flex_date01 BETWEEN  CONCAT(DATE_ADD('$date', INTERVAL -1 DAY),' 08:00:01') AND CONCAT(DATE_ADD('$date', INTERVAL -1 DAY),' 16:00:00') AND 
				(SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip		
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) ='20' 
				THEN 1 ELSE 0 END ) AS tot_del_20_day,
				(SELECT CASE
				WHEN UCASE(mfdch_desc) LIKE 'DELIVERY%' AND
				b.flex_date01 BETWEEN CONCAT(DATE_ADD('$date', INTERVAL -1 DAY),' 16:00:01') AND CONCAT(DATE_ADD('$date', INTERVAL -1 DAY),' 00:00:00') AND 
				(SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip		
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) ='20' 
				THEN 1 ELSE 0 END ) AS tot_del_20_eve,
				 (SELECT CASE
				WHEN UCASE(mfdch_desc) LIKE 'DELIVERY%' AND
				b.flex_date01 BETWEEN  CONCAT('$date',' 00:00:01') AND CONCAT('$date',' 08:00:00')
							 AND 
				(SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip		
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) ='20' 
				THEN 1 ELSE 0 END ) AS tot_del_20_night,

				 (SELECT CASE
				WHEN UCASE(mfdch_desc) LIKE 'DELIVERY%' AND
				b.flex_date01 BETWEEN  CONCAT(DATE_ADD('$date', INTERVAL -1 DAY),' 08:00:01') AND CONCAT(DATE_ADD('$date', INTERVAL -1 DAY),' 16:00:00') AND 
				(SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip		
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) >='40' 
				THEN 1 ELSE 0 END ) AS tot_del_40_day,
				(SELECT CASE
				WHEN UCASE(mfdch_desc) LIKE 'DELIVERY%' AND
				b.flex_date01 BETWEEN  CONCAT(DATE_ADD('$date', INTERVAL -1 DAY),' 16:00:01') AND CONCAT(DATE_ADD('$date', INTERVAL -1 DAY),' 00:00:00') AND 
				(SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip		
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) >='40' 
				THEN 1 ELSE 0 END ) AS tot_del_40_eve,
				 (SELECT CASE
				WHEN UCASE(mfdch_desc) LIKE 'DELIVERY%' AND
				b.flex_date01 BETWEEN  CONCAT('$date',' 00:00:01') AND CONCAT('$date',' 08:00:00')
							 AND 
				(SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip		
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) >='40' 
				THEN 1 ELSE 0 END ) AS tot_del_40_night,

				(SELECT CASE
				WHEN UCASE(mfdch_desc) LIKE 'APPRAISE%' AND
				(SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip		
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) ='20' 
				THEN 1 ELSE 0 END ) AS tot_app_20,

				(SELECT CASE
				WHEN UCASE(mfdch_desc) LIKE 'APPRAISE%' AND
				(SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip		
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) >='40' 
				THEN 1 ELSE 0 END ) AS tot_app_40

				FROM sparcsn4.inv_unit a  
				INNER JOIN sparcsn4.inv_unit_fcy_visit b ON b.unit_gkey=a.gkey 
				INNER JOIN sparcsn4.config_metafield_lov ON a.flex_string01=config_metafield_lov.mfdch_value
				WHERE a.freight_kind='FCL' AND b.flex_date01>CONCAT('$date',' 08:00:00') AND  
				b.flex_date01<CONCAT(DATE_ADD('$date', INTERVAL 1 DAY),' 08:00:00') AND 
				config_metafield_lov.mfdch_value NOT IN ('CANCEL','APPCUS','APPOTH','APPREF')
				ORDER BY b.flex_date01
				) AS tbl WHERE Block_No IN ($yards) 
					  
				";
			//return fcl_query;
			$fcl_sql=mysql_query($fcl_query);
			

	 ?>
	 
		<table width="100%" border =0 cellpadding='0' cellspacing='0'>
			<tr><td><nobr>LAST 24 HOURS FCL CONTAINER POSITION</nobr></td></tr>
		</table>
		<?php
				while($row_fcl=mysql_fetch_object($fcl_sql)){
			$i++;
			?>
		<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
			<tr>
				<td></td>
				<td></td>
				<td>20"</td>
				<td>40"</td>
			</tr>
			<tr>
				<td rowspan="2">DELIVERY</td>
				<td>DAY</td>
				<td><?php if($row_fcl->tot_del_20_day!=("" || 0)){ echo $row_fcl->tot_del_20_day; } else echo "-"; ?></td>
				<td><?php if($row_fcl->tot_del_40_day!=("" || 0)){ echo $row_fcl->tot_del_40_day; } else echo "-"; ?></td>
			</tr>
			<tr>
				<td>NIGHT</td>
				<td><?php if($row_fcl->tot_del_20_night!=("" || 0)){ echo $row_fcl->tot_del_20_night; } else echo "-"; ?></td>
				<td><?php if($row_fcl->tot_del_40_night!=("" || 0)){ echo $row_fcl->tot_del_40_night; } else echo "-"; ?></td>
			</tr>
			<tr>
				<td>APPRAISEMENT</td>
				<td></td>
				<td><?php if($row_fcl->tot_app_20!=("" || 0)){ echo $row_fcl->tot_app_20; } else echo "-"; ?></td>
				<td><?php if($row_fcl->tot_app_40!=("" || 0)){ echo $row_fcl->tot_app_40; } else echo "-"; ?></td>
			</tr>
			<tr>
				<td rowspan="3">FCL CONTAINER RECEIVING </td>
				<td>DAY</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>EVENING</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>NIGHT</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>FCL LYING LOAD </td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>EMPTY CONT REC. </td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td rowspan="3">EMPTY CONT REMOVE </td>
				<td>DAY</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>EVENING</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>NIGHT</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>EMPTY CONT LYING</td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>
		</td>
	</tr>
</table>
		<?php } ?>

	  <div  style="margin-left: 30px;">
	 <?php 
	  
	  	$assignment_sql=mysql_query("SELECT COUNT(id) AS tot_cont,
				SUM(tot_ass_del_20) AS tot_ass_del_20,SUM(tot_ass_del_40) AS tot_ass_del_40,
				SUM(tot_ass_app_20) AS tot_ass_app_20,SUM(tot_ass_app_40) AS tot_ass_app_40,
				SUM(tot_ass_appcum_20) AS tot_ass_appcum_20,SUM(tot_ass_appcum_40) AS tot_ass_appcum_40,
				SUM(tot_ass_ocd_20) AS tot_ass_ocd_20,SUM(tot_ass_ocd_40) AS tot_ass_ocd_40,
				SUM(tot_ass_cusinv_20) AS tot_ass_cusinv_20,SUM(tot_ass_cusinv_40) AS tot_ass_cusinv_40   
				FROM
				(
				SELECT a.id,b.flex_date01,(SELECT ctmsmis.cont_yard(b.last_pos_slot)) AS Yard_No,
				(SELECT ctmsmis.cont_block(b.last_pos_slot,Yard_No)) AS Block_No,
				(SELECT CASE
				WHEN UCASE(mfdch_desc) LIKE 'DELIVERY%' AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip		
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) ='20' 
				THEN 1 ELSE 0 END ) AS tot_ass_del_20,
				(SELECT CASE
				WHEN UCASE(mfdch_desc) LIKE 'DELIVERY%' AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip		
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) >='40' 
				THEN 1 ELSE 0 END ) AS tot_ass_del_40 ,
				(SELECT CASE
				WHEN UCASE(mfdch_desc) LIKE 'APPRAISE' AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip		
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) ='20' 
				THEN 1 ELSE 0 END ) AS tot_ass_app_20,
				(SELECT CASE
				WHEN UCASE(mfdch_desc) LIKE 'APPRAISE' AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip		
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) >='40' 
				THEN 1 ELSE 0 END ) AS tot_ass_app_40, 
				(SELECT CASE
				WHEN UCASE(mfdch_desc) LIKE 'APPRAISE CUM DEL%' AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip	INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) ='20' 
				THEN 1 ELSE 0 END ) AS tot_ass_appcum_20,
				(SELECT CASE
				WHEN UCASE(mfdch_desc) LIKE 'APPRAISE CUM DEL%' AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip	INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) >='40' 
				THEN 1 ELSE 0 END ) AS tot_ass_appcum_40,
				(SELECT CASE
				WHEN UCASE(mfdch_value) ='OCD' AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip	INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) ='20' 
				THEN 1 ELSE 0 END ) AS tot_ass_ocd_20,
				(SELECT CASE
				WHEN UCASE(mfdch_value) ='OCD' AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip	INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) >='40' 
				THEN 1 ELSE 0 END ) AS tot_ass_ocd_40,
				(SELECT CASE
				WHEN UCASE(mfdch_desc) ='CUSTOM%' AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip	INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) ='20' 
				THEN 1 ELSE 0 END ) AS tot_ass_cusinv_20,
				(SELECT CASE
				WHEN UCASE(mfdch_desc) ='CUSTOM%' AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip	INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) >='40' 
				THEN 1 ELSE 0 END ) AS tot_ass_cusinv_40       
				FROM sparcsn4.inv_unit a  
				INNER JOIN sparcsn4.inv_unit_fcy_visit b ON b.unit_gkey=a.gkey 
				INNER JOIN sparcsn4.config_metafield_lov ON a.flex_string01=config_metafield_lov.mfdch_value
				WHERE b.flex_date01 > CONCAT(DATE_ADD('$date', INTERVAL 1 DAY),' 08:00:00') AND  
				b.flex_date01 < CONCAT(DATE_ADD('$date', INTERVAL 2 DAY),' 08:00:00') 
				AND config_metafield_lov.mfdch_value NOT IN ('CANCEL','APPCUS','APPOTH','APPREF')
				) AS tbl WHERE Block_No IN ($yards)");
				
			
	$assignment_row=mysql_fetch_object($assignment_sql);	

  	$keepdown_sql=mysql_query("SELECT COUNT(id) AS tot_cont,
				SUM(tot_ass_del_20) AS tot_ass_del_20,SUM(tot_ass_del_40) AS tot_ass_del_40,
				SUM(tot_ass_app_20) AS tot_ass_app_20,SUM(tot_ass_app_40) AS tot_ass_app_40,
				SUM(tot_ass_appcum_20) AS tot_ass_appcum_20,SUM(tot_ass_appcum_40) AS tot_ass_appcum_40,
				SUM(tot_ass_ocd_20) AS tot_ass_ocd_20,SUM(tot_ass_ocd_40) AS tot_ass_ocd_40,
				SUM(tot_ass_cusinv_20) AS tot_ass_cusinv_20,SUM(tot_ass_cusinv_40) AS tot_ass_cusinv_40   
				FROM
				(
				SELECT a.id,(SELECT ctmsmis.cont_yard(b.last_pos_slot)) AS Yard_No,
				(SELECT ctmsmis.cont_block(b.last_pos_slot,Yard_No)) AS Block_No,
				(SELECT CASE
				WHEN UCASE(mfdch_desc) LIKE 'DELIVERY%' AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip		
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) ='20' 
				THEN 1 ELSE 0 END ) AS tot_ass_del_20,
				(SELECT CASE
				WHEN UCASE(mfdch_desc) LIKE 'DELIVERY%' AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip		
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) >='40' 
				THEN 1 ELSE 0 END ) AS tot_ass_del_40 ,
				(SELECT CASE
				WHEN UCASE(mfdch_desc) LIKE 'APPRAISE' AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip		
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) ='20' 
				THEN 1 ELSE 0 END ) AS tot_ass_app_20,
				(SELECT CASE
				WHEN UCASE(mfdch_desc) LIKE 'APPRAISE' AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip		
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) >='40' 
				THEN 1 ELSE 0 END ) AS tot_ass_app_40, 
				(SELECT CASE
				WHEN UCASE(mfdch_desc) LIKE 'APPRAISE CUM DEL%' AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip	INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) ='20' 
				THEN 1 ELSE 0 END ) AS tot_ass_appcum_20,
				(SELECT CASE
				WHEN UCASE(mfdch_desc) LIKE 'APPRAISE CUM DEL%' AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip	INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) >='40' 
				THEN 1 ELSE 0 END ) AS tot_ass_appcum_40,
				(SELECT CASE
				WHEN UCASE(mfdch_value) ='OCD' AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip	INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) ='20' 
				THEN 1 ELSE 0 END ) AS tot_ass_ocd_20,
				(SELECT CASE
				WHEN UCASE(mfdch_value) ='OCD' AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip	INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) >='40' 
				THEN 1 ELSE 0 END ) AS tot_ass_ocd_40,
				(SELECT CASE
				WHEN UCASE(mfdch_desc) ='CUSTOM%' AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip	INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey	 	
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) ='20' 
				THEN 1 ELSE 0 END ) AS tot_ass_cusinv_20,
				(SELECT CASE
				WHEN UCASE(mfdch_desc) ='CUSTOM%' AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip	INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
				INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
				WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey) >='40' 
				THEN 1 ELSE 0 END ) AS tot_ass_cusinv_40       
				FROM sparcsn4.inv_unit a  
				INNER JOIN sparcsn4.inv_unit_fcy_visit b ON b.unit_gkey=a.gkey 
				INNER JOIN sparcsn4.config_metafield_lov ON a.flex_string01=config_metafield_lov.mfdch_value
				WHERE b.flex_date01 > CONCAT(DATE_ADD('$date', INTERVAL 1 DAY),' 08:00:00') AND  
				b.flex_date01 < CONCAT(DATE_ADD('$date', INTERVAL 2 DAY),' 08:00:00') 
				AND config_metafield_lov.mfdch_value NOT IN ('CANCEL','APPCUS','APPOTH','APPREF') AND 
				b.time_in IS NOT NULL
				) AS tbl WHERE Block_No IN ($yards)");
				//echo $keepdown_sql;
						//	return;

	$keepdown_row=mysql_fetch_object($keepdown_sql);
	  ?>
	  
	  		<table width="55%" border =0 cellpadding='0' cellspacing='0' >
			<tr><td>KEEP DOWN POSITION FOR NEXT DAY</td></tr>
		</table>
		<table width="55%" border ='1' cellpadding='0' cellspacing='0'>
			<tr>
				<td rowspan="2"></td>
				<td colspan="2">ASSIGNMENT</td>
				<td colspan="2">KEEP DOWN</td>
				<td colspan="2">BALANCE</td>
			</tr>
			<tr>
				<td>20'</td>
				<td>40'</td>
				<td>20'</td>
				<td>40'</td>
				<td>20'</td>
				<td>40'</td>
			</tr>
			<tr>
				<td>DELIVERY</td>
				<td><?php if($assignment_row->tot_ass_del_20!=("" || 0)){ echo $assignment_row->tot_ass_del_20; } else echo "-"; ?></td>
				<td><?php if($assignment_row->tot_ass_del_40!=("" || 0)){ echo $assignment_row->tot_ass_del_40; } else echo "-";  ; ?></td>
				<td><?php if($keepdown_row->tot_ass_del_20!=("" || 0)){ echo $keepdown_row->tot_ass_del_20; } else echo "-"; ?></td>
				<td><?php if($keepdown_row->tot_ass_del_40!=("" || 0)){ echo $keepdown_row->tot_ass_del_40; } else echo "-";  ; ?></td>
				<td><?php $balance20=($assignment_row->tot_ass_del_20-$keepdown_row->tot_ass_del_20); if($balance20!=("" || 0)){ echo $balance20; } else echo "-"; ?></td>
				<td><?php $balance40=($assignment_row->tot_ass_del_40-$keepdown_row->tot_ass_del_40); if($balance40!=("" || 0)){ echo $balance40; } else echo "-"; ?></td>
			</tr>
			<tr>
				<td>APPRAISEMENT</td>
				<td><?php if($assignment_row->tot_ass_app_20!=("" || 0)){ echo $assignment_row->tot_ass_app_20; } else echo "-";  ?></td>
				<td><?php if($assignment_row->tot_ass_app_40!=("" || 0)){ echo $assignment_row->tot_ass_app_40; } else echo "-"; ?></td>
				<td><?php if($keepdown_row->tot_ass_app_20!=("" || 0)){ echo $keepdown_row->tot_ass_app_20; } else echo "-";  ?></td>
				<td><?php if($keepdown_row->tot_ass_app_40!=("" || 0)){ echo $keepdown_row->tot_ass_app_40; } else echo "-"; ?></td>
				<td><?php $appraise20=($assignment_row->tot_ass_app_20-$keepdown_row->tot_ass_app_20); if($appraise20!=("" || 0)){ echo $appraise20; } else echo "-"; ?></td>
				<td><?php $appraise40=($assignment_row->tot_ass_app_40-$keepdown_row->tot_ass_app_40); if($appraise20!=("" || 0)){ echo $appraise40; } else echo "-"; ?></td>
			</tr>	
			<tr>
				<td>APP CUM DELIVERY</td>
				<td><?php if($assignment_row->tot_ass_appcum_20!=("" || 0)){ echo $assignment_row->tot_ass_appcum_20; } else echo "-"; ?></td>
				<td><?php if($assignment_row->tot_ass_appcum_40!=("" || 0)){ echo $assignment_row->tot_ass_appcum_40; } else echo "-"; ?></td>
				<td><?php if($keepdown_row->tot_ass_appcum_20!=("" || 0)){ echo $keepdown_row->tot_ass_appcum_20; } else echo "-"; ?></td>
				<td><?php if($keepdown_row->tot_ass_appcum_40!=("" || 0)){ echo $keepdown_row->tot_ass_appcum_40; } else echo "-"; ?></td>
				<td><?php $appCumDel20=($assignment_row->tot_ass_appcum_20-$keepdown_row->tot_ass_appcum_20); if($appCumDel20!=("" || 0)){ echo $appCumDel20; } else echo "-"; ?></td>
				<td><?php $appCumDel40=($assignment_row->tot_ass_appcum_40-$keepdown_row->tot_ass_appcum_40); if($appCumDel40!=("" || 0)){ echo $appCumDel40; } else echo "-"; ?></td>
			</tr>		
			<tr>
				<td>ON CHASIS</td>
				<td><?php if($assignment_row->tot_ass_ocd_20!=("" || 0)){ echo $assignment_row->tot_ass_ocd_20; } else echo "-"; ?></td>
				<td><?php if($assignment_row->tot_ass_ocd_40!=("" || 0)){ echo $assignment_row->tot_ass_ocd_40; } else echo "-"; ?></td>
				<td><?php if($keepdown_row->tot_ass_ocd_20!=("" || 0)){ echo $keepdown_row->tot_ass_ocd_20; } else echo "-"; ?></td>
				<td><?php if($keepdown_row->tot_ass_ocd_40!=("" || 0)){ echo $keepdown_row->tot_ass_ocd_40; } else echo "-"; ?></td>
				<td><?php $chasis20=($assignment_row->tot_ass_ocd_20-$keepdown_row->tot_ass_ocd_20); if($chasis20!=("" || 0)){ echo $chasis20; } else echo "-"; ?></td>
				<td><?php $chasis40=($assignment_row->tot_ass_ocd_40-$keepdown_row->tot_ass_ocd_40); if($chasis40!=("" || 0)){ echo $chasis40; } else echo "-"; ?></td>
			</tr>	
			<tr>
				<td>CUSTOM INVENTORY</td>
				<td><?php if($assignment_row->tot_ass_cusinv_20!=("" || 0)){ echo $assignment_row->tot_ass_cusinv_20; } else echo "-"; ?></td>
				<td><?php if($assignment_row->tot_ass_cusinv_40!=("" || 0)){ echo $assignment_row->tot_ass_cusinv_40; } else echo "-"; ?></td>
				<td><?php if($keepdown_row->tot_ass_cusinv_20!=("" || 0)){ echo $keepdown_row->tot_ass_cusinv_20; } else echo "-"; ?></td>
				<td><?php if($keepdown_row->tot_ass_cusinv_40!=("" || 0)){ echo $keepdown_row->tot_ass_cusinv_40; } else echo "-"; ?></td>
				<td><?php $custInv20=($assignment_row->tot_ass_cusinv_20-$keepdown_row->tot_ass_cusinv_20); if($custInv20!=("" || 0)){ echo $custInv20; } else echo "-"; ?></td>
				<td><?php $custInv40=($assignment_row->tot_ass_cusinv_40-$keepdown_row->tot_ass_cusinv_40); if($custInv40!=("" || 0)){ echo $custInv40; } else echo "-"; ?></td>
			</tr>
		</table>
	  
	  <table><tr><td>&nbsp;</td></tr></table>
	  
		<table width="55%" border =0 cellpadding='0' cellspacing='0'>
			<tr><td>EMPTY CONTAINER 24 hrs POSITION</td></tr>
		</table>
		<table width="55%" border ='1' cellpadding='0' cellspacing='0' >
			<tr>
				<td>OPENING BALANCE</td>
				<td>RECEIVING</td>
				<td colspan="4">GATE PASS</td>
				<td colspan="4">SHIPMENT</td>
				<td>CLOSING BALANCE</td>
			</tr>
			
			<?php 
			$mty_row="";

			$mty_str="SELECT size,COUNT(id) AS tot_cont FROM (
			SELECT a.id,
			(SELECT ctmsmis.cont_yard(b.last_pos_slot)) AS Yard_No,
			(SELECT ctmsmis.cont_block(b.last_pos_slot,Yard_No)) AS Block_No,
			(CASE
			WHEN (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip		
			INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey		
			INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey		
			WHERE sparcsn4.inv_unit_equip.unit_gkey=a.gkey LIMIT 1)=20 THEN 20

			ELSE 40 END ) AS size

			FROM sparcsn4.inv_unit a  
			INNER JOIN sparcsn4.inv_unit_fcy_visit b ON b.unit_gkey=a.gkey 
			WHERE a.category='IMPRT' AND b.transit_state='S40_YARD' AND a.freight_kind='MTY'
			) AS tbl
			WHERE Block_No IN ($yards) 
			GROUP BY size
			ORDER BY size";
			
			$rtn_str=mysql_query($mty_str);
			while($row_str=mysql_fetch_object($rtn_str))
			{
			?>
			
			
			<tr>
				<td rowspan="2"> <?php if($row_str->size=='20') { echo $row_str->tot_cont." X 20 "; } else { echo $row_str->tot_cont." X 40 "; } ?></td>
				<td rowspan="2"></td>
				<td>D/T</td>
				<td>E/T</td>
				<td>N/T</td>
				<td>TOTAL</td>
				<td>D/T</td>
				<td>E/T</td>
				<td>N/T</td>
				<td>TOTAL</td>
				<td rowspan="2"> X 20"</td>
			</tr>
			<tr>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
			</tr>
			<?php } ?>
			<!--tr>
				<td rowspan="2"> X 40"</td>
				<td rowspan="2"></td>
				<td>D/T</td>
				<td>E/T</td>
				<td>N/T</td>
				<td>TOTAL</td>
				<td>D/T</td>
				<td>E/T</td>
				<td>N/T</td>
				<td>TOTAL</td>
				<td rowspan="2"> X 40"</td>
			</tr>
			
			<tr>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
			</tr-->	
		
		</table>
		

		
</div>

	</div>
		</div>
			<?php mysql_close($con_ctmsmis); ?>
	</body>
</html>

