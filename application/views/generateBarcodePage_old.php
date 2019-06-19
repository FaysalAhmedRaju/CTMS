<?php if($_POST['options']=='html'){?>
	<?php } 
	else if($_POST['options']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=LAST_24_HOUR_ER.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}
	include("dbConection.php");
	?>
<html>
<head>
<script type="text/javascript" src="<?php echo JS_PATH; ?>JsBarcode.all.min.js"></script>
</head>
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
	$strInfoQry="SELECT inv.id,RIGHT(sparcsn4.ref_equip_type.nominal_length,2) AS size,inv.seal_nbr1,
	sparcsn4.vsl_vessels.name,g.id AS MLO,inv.category,inv.freight_kind,vsl_vessel_visit_details.ib_vyg AS rotation
								 
	FROM sparcsn4.inv_unit inv  
	INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=inv.gkey
	INNER JOIN sparcsn4.argo_carrier_visit ON argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ob_cv
	INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
	INNER JOIN sparcsn4.vsl_vessels ON vsl_vessels.gkey=vsl_vessel_visit_details.vessel_gkey
	INNER JOIN sparcsn4.inv_unit_equip ON inv.gkey=inv_unit_equip.unit_gkey 
	INNER JOIN sparcsn4.ref_bizunit_scoped g ON inv.line_op = g.gkey
	INNER JOIN sparcsn4.ref_equipment ON inv_unit_equip.eq_gkey=ref_equipment.gkey
	INNER JOIN sparcsn4.ref_equip_type ON ref_equipment.eqtyp_gkey=ref_equip_type.gkey 
	WHERE inv.id ='$container_no' ORDER BY inv.gkey DESC LIMIT 1";
	$rtnInfoQry=mysql_query($strInfoQry);
	$rowInfoQry=mysql_fetch_object($rtnInfoQry);
	
	$strTrailerQry="SELECT truck_id,license_nbr,DATE_FORMAT(NOW(),'%d/%m/%Y %H:%i:%s') AS pdate FROM sparcsn4.road_trucks WHERE truck_id=REPLACE('$truck_no','-','')";
	$rtnTraileQry=mysql_query($strTrailerQry);
	$rowTrailerQry=mysql_fetch_object($rtnTraileQry);
	?>
	<table align="center" width="80%" border ="1" cellpadding="4" cellspacing="0">
		<tr align="center">
		<td colspan="6" align="center">
		<?php if($search_format!="pdf") { ?>
				<svg id="barcode"></svg>
				<script>
					JsBarcode("#barcode", "<?php echo $container_no;?>",
					{
						width:1,
						height: 50,
						fontSize: 18,
						fontOptions: "bold"
					}
					);
				</script>
		<?php }  else {?>
					<barcode code="<?php echo $container_no; ?>" type="EAN13" size="1" height="0.5" values="1" />
		<?php }  ?>
		</td>
		</tr>
		<tr>
			<td colspan="6" align="center">
			<b>
			<?php 
			$user=$this->session->userdata('User_Name');
			echo  strtoupper($user);
			?>
			</b></td>
		</tr>
		<tr>
			<td colspan="2"><font size="5" style="padding-left:25px;"><b><?php echo  $truck_no;?></b></font></td>
			<td><b>MLO: </b></td><td><b><?php echo $rowInfoQry->MLO;?></b></td>
			<td><b>Date: </b></td><td><b><?php echo $rowTrailerQry->pdate;?></b></td>
		</tr>
		<tr>
			<td><b>Vessel Name: </b></td><td><b><?php echo $rowInfoQry->name;?></b></td>			
			<td><b>Size: </b></td><td><b><?php echo $rowInfoQry->size;?></b></td>
			<td><b>Seal: </b></td><td><b><?php echo $rowInfoQry->seal_nbr1;?></b></td>
			
		</tr>
		<tr>
			<td><b>Trailer No: </b></td><td><b><?php echo $rowTrailerQry->license_nbr;?></b></td>
			<td><b>Rotation: </b></td><td><b><?php echo $rowInfoQry->rotation;?></b></td>
			<td><b>Status: </b></td><td><font size="5"><b><?php if($rowInfoQry->category=="EXPRT") echo "EXPORT";?></b></font></td>
		</tr>		
		<tr>
			<td align="right" colspan="6" style="padding-right:80px;"><b><i><br/><br/><br/>SIGNATURE</i></b></td>
		</tr>
		
	</table>
	<!--table width="80%" align="center">
		<tr>
			<td align="left"colspan="1">Print Date : <?php echo date('Y-m-d H:i:s');?></td>
			<td align="right" colspan="2">Signature</td>
		</tr>
	</table-->
<?php if($_POST['options']=='html'){?>

<?php } ?>
<?php 

mysql_close($con_sparcsn4);?>

