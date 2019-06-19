<html>
<head>
<style>

</style>
<!--script src="http://code.jquery.com/jquery-latest.min.js"></script-->
<!--script type="text/javascript" src="<?php echo JS_PATH?>JsBarcode.js"</script-->
<script type="text/javascript" src="<?php echo JS_PATH; ?>JsBarcode.all.min.js"></script>

<!--title>Barcode Generator</title-->
</head>

<?php include("dbConection.php");
		$strTruckNum="SELECT ctmsmis.mis_cf_assign_truck.number_of_truck FROM ctmsmis.mis_cf_assign_truck
		WHERE ctmsmis.mis_cf_assign_truck.cont_id='$cont_no'";
		$truckNum=mysql_query($strTruckNum);
		$truckStat=mysql_fetch_object($truckNum);
		$trStat= $truckStat->number_of_truck;	
	?>


	<?php
	
			$strInfoQry="SELECT inv.id,RIGHT(sparcsn4.ref_equip_type.nominal_length,2) AS size,
			RIGHT(sparcsn4.ref_equip_type.nominal_height,2) AS height,inv.seal_nbr1,
			sparcsn4.vsl_vessels.name,g.id AS MLO,inv.category,inv.freight_kind,vsl_vessel_visit_details.ib_vyg AS rotation
										 
			FROM sparcsn4.inv_unit inv  
			INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=inv.gkey
			INNER JOIN sparcsn4.argo_carrier_visit ON argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
			INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
			INNER JOIN sparcsn4.vsl_vessels ON vsl_vessels.gkey=vsl_vessel_visit_details.vessel_gkey
			INNER JOIN sparcsn4.inv_unit_equip ON inv.gkey=inv_unit_equip.unit_gkey 
			INNER JOIN sparcsn4.ref_bizunit_scoped g ON inv.line_op = g.gkey
			INNER JOIN sparcsn4.ref_equipment ON inv_unit_equip.eq_gkey=ref_equipment.gkey
			INNER JOIN sparcsn4.ref_equip_type ON ref_equipment.eqtyp_gkey=ref_equip_type.gkey 
			WHERE inv.id ='$cont_no' ORDER BY inv.gkey DESC LIMIT 1";
			
			$rtnInfoQry=mysql_query($strInfoQry);
			$rowInfoQry=mysql_fetch_object($rtnInfoQry);
	

	
			$strBarcode="SELECT ctmsmis.mis_cf_assign_truck.cont_id, ctmsmis.mis_cf_assign_truck.number_of_truck,
				ctmsmis.cont_wise_truck_dtl.bizu_gkey,cont_id, 
				ctmsmis.cont_wise_truck_dtl.encrypted_data, ctmsmis.cont_wise_truck_dtl.truck_number,entrance_gate,entrance_serial 
				FROM ctmsmis.mis_cf_assign_truck 
				INNER JOIN ctmsmis.cont_wise_truck_dtl ON ctmsmis.cont_wise_truck_dtl.cf_assign_truck_id=ctmsmis.mis_cf_assign_truck.id
				WHERE ctmsmis.mis_cf_assign_truck.cont_id='$cont_no'";
		$barcodeData=mysql_query($strBarcode);
		// $barcodeStat=mysql_fetch_object($barcodeData);
		
			$i=0;	
	while($barcodeStat=mysql_fetch_object($barcodeData)){
	$i++;

		$encrptData= $barcodeStat->encrypted_data;
	?>
	
	<body>
	<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
		<tr bgcolor="#ffffff" align="center" height="100px">
				<td colspan="8" align="center">
					<table border=0 width="100%">
						
						<tr>
							<td align="center" colspan="8"><img align="middle"  width="220px" height="70px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
						</tr>

						<tr align="center">
							<td colspan="8"><font size="4"><b><?php echo $title;?></b></font></td>
						</tr>
						<tr align="center">
							<td colspan="8"><font size="4"><b></b></font></td>
						</tr>
					</table>
				
				</td>
				
		</tr>
		<tr>
			<td  colspan="8" align="center"><b>Truck No :<?php echo strtoupper($barcodeStat->truck_number);?></b></td>
		</tr>
		<br/>
		<tr>
			<td align="center" colspan="7"> 
				<svg id="barcode<?php echo $i;?>"></svg>
			</td>
			<script>
				JsBarcode("#barcode<?php echo $i;?>", "<?php echo $barcodeStat->encrypted_data; ?>", {
				  textAlign: "center",
				  textPosition: "bottom",
				  font: "plain",
				  fontOptions: "bold",
				  fontSize: 20,
				  textMargin: 5,
				  text: "<?php echo $barcodeStat->cont_id; ?>",
				  width:1,
				  height: 50
				});
				</script>
		</tr>
		<table align="center" border="0">
		<tr>
			<td  align="left"><b>Serial No  :<?php echo $barcodeStat->entrance_serial;?>,</b></td>
			<td  align="left"><b> Gate  : <?php echo $barcodeStat->entrance_gate;?>,</b></td>
			<td  align="left"><b> Vessel Name  : <?php echo $rowInfoQry->name;?>,</b></td>
			<td  align="left"><b> MLO  : <?php echo $rowInfoQry->MLO;?>,</b></td>
			<td  align="left"><b> Freight Kind  : <?php echo $rowInfoQry->freight_kind;?></b></td>
		</tr>
		<tr>
			<td  align="left"><b>Size  :<?php echo $rowInfoQry->size;?>,</b></td>
			<td  align="left"><b> Height  : <?php echo $rowInfoQry->height;?>,</b></td>
			<td  align="left"><b> Seal No  : <?php echo $rowInfoQry->seal_nbr1;?>,</b></td>
			<td  align="left"><b> Rotation  : <?php echo $rowInfoQry->rotation;?>,</b></td>
			<td  align="left"><b> Status  : <?php if($rowInfoQry->category=="EXPRT") { echo "EXPORT"; } else if($rowInfoQry->category=="IMPRT") { echo "IMPORT"; } else if($rowInfoQry->category=="STRGE") { echo "STORAGE"; }?></b></td>
		</tr>
		<!--tr>
			<td colspan="4" align="right"><b>Vessel Name  :<?php echo $rowInfoQry->name;?></b><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MLO  : <?php echo $rowInfoQry->MLO;?></b></td>
			<!--td><b>Vessel Name  :<?php echo $rowInfoQry->name;?></b></td-->			
			<!--td colspan="4" align="left"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Size  :  <?php echo $rowInfoQry->size;?></b><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Height  : <?php echo $rowInfoQry->height;?></b></td>
			<!--td><b>Height  : <?php echo $rowInfoQry->height;?></b></td-->
			
		</tr>
		<tr>
			<!--td colspan="4" align="right"><b>Freight Kind : <?php echo $rowInfoQry->freight_kind;?></b><b>&nbsp;&nbsp;&nbsp;&nbsp;Seal No : <?php echo $rowInfoQry->seal_nbr1;?></b></td>
			<!--td><b>Seal No : <?php echo $rowInfoQry->seal_nbr1;?></b></td-->
			<!--td colspan="4" align="left"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rotation  : <?php echo $rowInfoQry->rotation;?></b><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Status   : <?php if($rowInfoQry->category=="EXPRT") { echo "EXPORT"; } else if($rowInfoQry->category=="IMPRT") { echo "IMPORT"; } else if($rowInfoQry->category=="STRGE") { echo "STORAGE"; }?></b></td>
			<!--td><b>Status   : <?php // if($rowInfoQry->category=="EXPRT") { echo "EXPORT"; } else if($rowInfoQry->category=="IMPRT") { echo "IMPORT"; } else if($rowInfoQry->category=="STRGE") { echo "STORAGE"; }?></b></td-->
		</tr-->	
	</table>
	
	
	
</body>
<div class="mybreak"> </div>
	<?php } ?>

</html>
<?php 
mysql_close($con_sparcsn4);
?>