<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>Bearth Operator</TITLE>
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
		header("Content-Disposition: attachment; filename=IMPORT_SUMMERY.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}
	//$ddl_imp_rot_no=$_REQUEST['ddl_imp_rot_no']; 

	//$con=mysql_connect("10.1.1.21", "sparcsn4","sparcsn4")or die("sparcsn4 database cannot connect"); 
	//mysql_select_db("ctmsmis")or die("cannot select DB");
	include("dbConection.php");
	?>
<html>
<title>Rotation Wise Export Container  Report</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				
				<tr align="center">
					<td colspan="12"><img align="middle"  width="220px" height="70px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
				</tr>
			
				<tr align="center">
					<td colspan="12"><font size="4"><b><u>VESSEL WISE REEFER CONTAINER REPORT</u></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b>ROTATION NO : <?php echo $ddl_imp_rot_no;?></b></font></td>
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
	<tr align="center">
		<td style="border-width:1px;border-style: double;" rowspan="2"><b>SlNo.</b></td>
		<td style="border-width:1px;border-style: double;" rowspan="2"><b>BERTH NO.</b></td>
		<td style="border-width:1px;border-style: double;" rowspan="2"><b>VESSEL NAME.</b></td>
		<td style="border-width:1px;border-style: double;" rowspan="2"><b>ROTATION NO.</b></td>
		<td style="border-width:1px;border-style: double;" rowspan="2"><b>ETA.</b></td>
		<td style="border-width:1px;border-style: double;" rowspan="2"><b>ETD.</b></td>
		<td style="border-width:1px;border-style: double;" rowspan="2"><b>ATA.</b></td>
		<td style="border-width:1px;border-style: double;" rowspan="2"><b>ATD.</b></td>
		
		<td style="border-width:1px;border-style: double;" colspan="2"><b>VESSEL WISE REFEER REPORT</b></td>
	</tr>
	<tr align="center">
		
		<td style="border-width:1px;border-style: double;"><b>REEFER CONTAINER</b></td>
		
	</tr>

<?php
	//echo $ddl_imp_rot_no;

	$query_str="SELECT sparcsn4.argo_quay.id,vsl_vessels.name,argo_visit_details.eta,
argo_visit_details.etd,vsl_vessel_berthings.ata,vsl_vessel_berthings.atd,
vsl_vessel_visit_details.ib_vyg
FROM sparcsn4.inv_unit tmp_inv_unit
INNER JOIN sparcsn4.argo_carrier_visit ON (sparcsn4.argo_carrier_visit.gkey=tmp_inv_unit.cv_gkey OR sparcsn4.argo_carrier_visit.gkey=tmp_inv_unit.declrd_ib_cv)
INNER JOIN sparcsn4.argo_visit_details ON sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.argo_visit_details.gkey
INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_visit_details.gkey
INNER JOIN sparcsn4.vsl_vessel_berthings ON sparcsn4.vsl_vessel_berthings.vvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
INNER JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
INNER JOIN sparcsn4.argo_quay ON sparcsn4.argo_quay.gkey=sparcsn4.vsl_vessel_berthings.quay
WHERE DATE(sparcsn4.argo_visit_details.eta)BETWEEN '$fromdate' AND '$todate' OR vsl_vessel_visit_details.ib_vyg='$ddl_imp_rot_no'
GROUP BY 2 ORDER BY argo_visit_details.eta DESC";
//echo $query_str;
$query=mysql_query($query_str);
 
	$i=0;
	$j=0;
	
	$mlo="";
	while($row=mysql_fetch_object($query)){
	$i++;
	
		
	
?>
<tr align="center">
		<td><?php  echo $i;?></td>
	
		<td><?php if($row->id) echo $row->id; else echo "&nbsp;";?></td>
		<td><?php if($row->name) echo $row->name; else echo "&nbsp;";?></td>
		<td><?php if($row->ib_vyg) echo $row->ib_vyg; else echo "&nbsp;";?></td>
		<td><?php if($row->eta) echo $row->eta; else echo "&nbsp;";?></td>
		<td><?php if($row->etd) echo $row->etd; else echo "&nbsp;";?></td>
		<td><?php if($row->ata) echo $row->ata; else echo "&nbsp;";?></td>
		<td><?php if($row->atd) echo $row->atd; else echo "&nbsp;";?></td>
		
		<td>
			<a href="<?php echo site_url('report/vesslWiseRefeerContainer/'.$row->ib_vyg);?>" target="_blank">View</a>
		</td>
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
