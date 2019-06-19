<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>BLOCKED CONTAINER LIST</TITLE>
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

	?>
<html>
<title>OFFDOC Information List</title>
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
					<tr>
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
					<td colspan="12"><font size="4"><b><u>Vessel Wise Transit Ways</u></b></font></td>
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
	<table style="border:solid 1px #ccc;" width="500px" align="center" cellspacing="0" cellpadding="0">


<?php

	include("dbConection.php");
	$query=mysql_query("SELECT vvd_gkey AS vvd_gkey,vsl,ib_vyg,ata,etd,berth,ship_agent,berth_op,`phase`,(SELECT GROUP_CONCAT(id SEPARATOR '->') AS transit_way FROM sparcsn4.ref_point_calls INNER JOIN sparcsn4.ref_routing_point ON sparcsn4.ref_point_calls.point_gkey=sparcsn4.ref_routing_point.gkey WHERE itin_gkey=(SELECT itinereray FROM sparcsn4.argo_visit_details WHERE gkey=vvd_gkey)) AS transit_way FROM( SELECT IFNULL(sparcsn4.vsl_vessel_visit_details.vvd_gkey,'') AS vvd_gkey,
	sparcsn4.vsl_vessels.name AS vsl,
	IFNULL(sparcsn4.vsl_vessel_visit_details.ib_vyg,'') AS ib_vyg,
	IFNULL(sparcsn4.argo_carrier_visit.ata,'') AS ata, 
	IFNULL(sparcsn4.argo_visit_details.etd,'') AS etd,
	IFNULL((SELECT sparcsn4.argo_quay.id FROM sparcsn4.argo_quay 
	INNER JOIN sparcsn4.vsl_vessel_berthings ON sparcsn4.vsl_vessel_berthings.quay=sparcsn4.argo_quay.gkey WHERE sparcsn4.vsl_vessel_berthings.vvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey ORDER BY sparcsn4.vsl_vessel_berthings.gkey LIMIT 1),'') AS berth,
	IFNULL(Y.name,'') AS ship_agent,
	IFNULL(sparcsn4.vsl_vessel_visit_details.flex_string02,
	IFNULL(sparcsn4.vsl_vessel_visit_details.flex_string03,'')) AS berth_op,
	IFNULL(sparcsn4.argo_carrier_visit.phase,'') AS PHASE FROM sparcsn4.vsl_vessel_visit_details 
	INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey INNER JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey 
	INNER JOIN sparcsn4.argo_visit_details ON sparcsn4.argo_visit_details.gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey 
	INNER JOIN sparcsn4.ref_carrier_service ON sparcsn4.ref_carrier_service.gkey=sparcsn4.argo_visit_details.service 
	INNER JOIN ( sparcsn4.ref_bizunit_scoped r LEFT JOIN ( sparcsn4.ref_agent_representation X LEFT JOIN sparcsn4.ref_bizunit_scoped Y ON X.agent_gkey=Y.gkey ) ON r.gkey=X.bzu_gkey) ON r.gkey = vsl_vessel_visit_details.bizu_gkey
	WHERE sparcsn4.vsl_vessel_visit_details.ib_vyg='$rot') AS a");
	$i=0;

	
	$mlo="";
	while($row=mysql_fetch_object($query)){
	$i++;
	
	
?>
<tr >
<td><b>Vessel Name.</b></td>
<td><?php if($row->vsl) echo $row->vsl; else echo "&nbsp;";?></td>
</tr>
<tr>
<td><b>Phase.</b></td>
<td><?php if($row->phase) echo substr($row->phase,2); else echo "&nbsp;";?></td>
</tr>
<tr >
<td><b>ATA</b></td>
<td><?php if($row->ata) echo $row->ata; else echo "&nbsp;";?></td>
</tr>
<tr>
<td><b>ETD.</b></td>
<td><?php if($row->etd) echo $row->etd; else echo "&nbsp;";?></td>
</tr>
<tr>
<td><b>Berth.</b></td>
<td><?php if($row->berth) echo $row->berth; else echo "&nbsp;";?></td>
</tr>
<tr>
<td><b>Agent.</b></td>
<td><?php if($row->ship_agent) echo $row->ship_agent; else echo "&nbsp;";?></td>
</tr>
<tr>
<td><b>Berth Operator.</b></td>
<td><?php if($row->berth_op) echo $row->berth_op; else echo "&nbsp;";?></td>
</tr>
<tr>
<td><b>Transit Ways.</b></td>
<td><font color="blue"><b><?php if($row->transit_way) echo $row->transit_way; else echo "&nbsp;";?></font></b></td>
</tr>
<?php } ?>
</table>

<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
