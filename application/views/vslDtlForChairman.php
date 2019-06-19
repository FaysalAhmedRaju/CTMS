<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>Vessel Details Report</TITLE>
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

	include("dbConection.php");
	
	?>
<html>

<head>
	<title>Vessel List</title>
	<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.4.2.min.js"></script>
	<script>
	var window_focus;
		$(window).focus(function() {
			window_focus = true;
		}).blur(function() {
			window_focus = false;
		});
		function checkReload(){
			if(!window_focus){
				location.reload();  // if not focused, reload
			}
		}
		setInterval(checkReload, 5000);
	</script>
</head>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">				
				<tr align="center">
					<td colspan="12"><img height="100px" src="<?php echo IMG_PATH;?>cpa_logo.png" /></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b>CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td>
				</tr>
			
				<tr align="center">
					<td colspan="12"><font size="4"><b><u>Vessel Report</u></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b></b></font></td>
				</tr>

			</table>
		
		</td>
		
	</tr>
	
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr>
	</table>
	<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	
	<tr  align="center" bgcolor="#D8D0CE">
		<td style="border-width:3px;border-style: double;"><b>SlNo.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Vessel Name</b></td>
		<td style="border-width:3px;border-style: double;"><b>Rotation</b></td>
		<td style="border-width:3px;border-style: double;"><b>Phase</b></td>
		<td style="border-width:3px;border-style: double;"><b>Agent</b></td>
		<td style="border-width:3px;border-style: double;"><b>Total Import Container</b></td>
		<td style="border-width:3px;border-style: double;"><b>Total Discharge Container</b></td>		
		<td style="border-width:3px;border-style: double;"><b>Balance</b></td>
		<td style="border-width:3px;border-style: double;"><b>Total Export Container</b></td>
		<td style="border-width:3px;border-style: double;"><b>Loaded On Board</b></td>		
		<td style="border-width:3px;border-style: double;"><b>Balance To Be Shipped</b></td>
	</tr>

	<!--tr  align="center">
		<td style="border-width:3px;border-style: double;"><b>Total Import Container</b></td>
		<td style="border-width:3px;border-style: double;"><b>Total Discharge Container</b></td>		
		<td style="border-width:3px;border-style: double;"><b>Balance</b></td>
		<td style="border-width:3px;border-style: double;"><b>Total Export Container</b></td>
		<td style="border-width:3px;border-style: double;"><b>Loaded On Board</b></td>		
		<td style="border-width:3px;border-style: double;"><b>Balance To Be Shipped</b></td>	
	</tr-->

<?php

	//echo$vvdGkey;
	$strQuery = "SELECT sparcsn4.vsl_vessel_visit_details.vvd_gkey,sparcsn4.vsl_vessels.name,sparcsn4.vsl_vessel_visit_details.ib_vyg,
				SUBSTR(sparcsn4.argo_carrier_visit.phase,3) AS phase_str,sparcsn4.ref_bizunit_scoped.id AS agent
				FROM sparcsn4.argo_carrier_visit
				INNER JOIN sparcsn4.argo_visit_details ON sparcsn4.argo_visit_details.gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
				INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_visit_details.gkey
				INNER JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
				INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.vsl_vessel_visit_details.bizu_gkey
				WHERE sparcsn4.argo_carrier_visit.phase IN ('30ARRIVED','40WORKING','50COMPLETE','60DEPARTED')
				ORDER BY sparcsn4.argo_carrier_visit.phase,sparcsn4.vsl_vessels.name";
	
	//echo $strQuery;
	$query=mysql_query($strQuery);

	$i=0;
	while($row=mysql_fetch_object($query)){
	$i++;
	
	$sqlGetTotImportCont="SELECT COUNT(inv_unit.id) AS tot_cont_import
						FROM sparcsn4.inv_unit 
						INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey 
						INNER JOIN sparcsn4.argo_carrier_visit ON argo_carrier_visit.gkey=sparcsn4.inv_unit.declrd_ib_cv
						WHERE inv_unit.category='IMPRT' AND sparcsn4.argo_carrier_visit.cvcvd_gkey=$row->vvd_gkey";
	$queryTotImportCont=mysql_query($sqlGetTotImportCont);
	$rowTotImportCont=mysql_fetch_object($queryTotImportCont);
	
	$sqlGetTotImportDischargeCont="SELECT COUNT(inv_unit.id) AS tot_discharge_cont
						FROM sparcsn4.inv_unit 
						INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey 
						INNER JOIN sparcsn4.argo_carrier_visit ON argo_carrier_visit.gkey=sparcsn4.inv_unit.declrd_ib_cv
						WHERE inv_unit.category='IMPRT' AND sparcsn4.argo_carrier_visit.cvcvd_gkey=$row->vvd_gkey AND time_in IS NOT NULL";
	$queryTotImportDischargeCont=mysql_query($sqlGetTotImportDischargeCont);
	$rowTotImportDischargeCont=mysql_fetch_object($queryTotImportDischargeCont);
	
	$sqlGetTotExportCont="SELECT COUNT(sparcsn4.inv_unit.id) AS tot_exp_cont
							FROM sparcsn4.inv_unit
							INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey
							INNER JOIN sparcsn4.argo_carrier_visit ON argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ob_cv
							INNER JOIN sparcsn4.argo_visit_details ON sparcsn4.argo_visit_details.gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey 
							INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_visit_details.gkey 
							WHERE vsl_vessel_visit_details.vvd_gkey= $row->vvd_gkey";
	$queryTotExportCont=mysql_query($sqlGetTotExportCont);
	$rowTotExportCont=mysql_fetch_object($queryTotExportCont);
	
	$sqlGetTotExportLoadedCont="SELECT COUNT(ctmsmis.mis_exp_unit.cont_id) AS exp_loaded_cont
								FROM ctmsmis.mis_exp_unit
								INNER JOIN sparcsn4.inv_unit ON sparcsn4.inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
								WHERE mis_exp_unit.vvd_gkey=$row->vvd_gkey AND mis_exp_unit.preAddStat='0' 
								AND inv_unit.category='EXPRT' AND mis_exp_unit.delete_flag='0'";
	$queryTotExportLoadedCont=mysql_query($sqlGetTotExportLoadedCont);
	$rowTotExportLoadedCont=mysql_fetch_object($queryTotExportLoadedCont);
	
?>
<tr align="center">
		<td><?php  echo $i;?></td>
		<td><?php if($row->name) echo $row->name; else echo "&nbsp;";?></td>
		<td><?php if($row->ib_vyg) echo $row->ib_vyg; else echo "&nbsp;";?></td>		
		<td><?php if($row->phase_str) echo $row->phase_str; else echo "&nbsp;";?></td>
		<td><?php if($row->agent) echo $row->agent; else echo "&nbsp;";?></td>
		<td><?php echo $rowTotImportCont->tot_cont_import; ?></td>
		<td><?php echo $rowTotImportDischargeCont->tot_discharge_cont; ?></td>
		<td><?php echo $rowTotImportCont->tot_cont_import - $rowTotImportDischargeCont->tot_discharge_cont;?></td>
		<td><?php echo $rowTotExportCont->tot_exp_cont;?></td>
		<td><?php echo $rowTotExportLoadedCont->exp_loaded_cont;?></td>
		<td><?php echo $rowTotExportCont->tot_exp_cont-$rowTotExportLoadedCont->exp_loaded_cont;?></td>
		
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
