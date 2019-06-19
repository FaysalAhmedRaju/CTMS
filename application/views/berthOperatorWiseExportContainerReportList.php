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
	
	
	?>
<html>
<title>Rotation Wise Export Container  Report</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				
				<!--tr align="center">
					<td colspan="12"><font size="4"><b> CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td>
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
					<td colspan="12"><font size="4"><b><u>Rotation Wise Export Container  Report</u></b></font></td>
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
		<td style="border-width:1px;border-style: double;" rowspan="2"><b>Rotation</b></td>
		<td style="border-width:1px;border-style: double;" rowspan="2"><b>Vessel Name.</b></td>
		<td style="border-width:1px;border-style: double;" rowspan="2"><b>Phase.</b></td>
		<td style="border-width:1px;border-style: double;" rowspan="2"><b>ATA.</b></td>
		<td style="border-width:1px;border-style: double;" rowspan="2"><b>ATD.</b></td>
		<td style="border-width:1px;border-style: double;" rowspan="2"><b>Berth Operator.</b></td>
		<td style="border-width:1px;border-style: double;" rowspan="2"><b>Total Unit.</b></td>
		<td style="border-width:1px;border-style: double;" colspan="2"><b>MLO Wise Loaded</b></td>
		<td style="border-width:1px;border-style: double;" colspan="2"><b>Import Container</b></td>
	</tr>
	<tr align="center">
		<td style="border-width:1px;border-style: double;"><b>Details</b></td>
		<td style="border-width:1px;border-style: double;"><b>Summary</b></td>
		<td style="border-width:1px;border-style: double;"><b>Balance/Discharge List</b></td>
		<td style="border-width:1px;border-style: double;"><b>Summary</b></td>
	</tr>

<?php
	//echo $todate;

include("mydbPConnectionctms.php");	
$query=mysql_query("
SELECT mis_inv_unit.vsl_visit_dtls_ib_vyg,mis_inv_unit.vsl_name,
(SELECT sparcsn4.argo_carrier_visit.phase FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS PHASE,
(SELECT sparcsn4.argo_carrier_visit.ata FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS ata,
(SELECT sparcsn4.argo_carrier_visit.atd FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS atd,
(SELECT sparcsn4.vsl_vessel_visit_details.flex_string02 FROM sparcsn4.vsl_vessel_visit_details WHERE sparcsn4.vsl_vessel_visit_details.vvd_gkey=mis_exp_unit.vvd_gkey) AS bop,
COUNT(mis_exp_unit.gkey) AS exp_cont
FROM mis_exp_unit 
INNER JOIN mis_inv_unit ON mis_inv_unit.gkey=mis_exp_unit.gkey
WHERE DATE(mis_inv_unit.arcar_ata) BETWEEN '$fromdate' AND '$todate' AND mis_inv_unit.vsl_visit_dtls_ib_vyg and snx=0 IS NOT NULL
GROUP BY 1
 ");
 //echo $query;
	$i=0;
	$j=0;
	
	$mlo="";
	while($row=mysql_fetch_object($query)){
	$i++;
	
		
	
?>
<tr align="center">
		<td><?php  echo $i;?></td>
		<td><?php if($row->vsl_visit_dtls_ib_vyg) echo $row->vsl_visit_dtls_ib_vyg; else echo "&nbsp;";?></td>
		<td><?php if($row->vsl_name) echo $row->vsl_name; else echo "&nbsp;";?></td>
		<td><?php if($row->PHASE) echo $row->PHASE; else echo "&nbsp;";?></td>
		<td><?php if($row->ata) echo $row->ata; else echo "&nbsp;";?></td>
		<td><?php if($row->atd) echo $row->atd; else echo "&nbsp;";?></td>
		<td><?php if($row->bop) echo $row->bop; else echo "&nbsp;";?></td>
		<td><?php if($row->exp_cont) echo $row->exp_cont; else echo "&nbsp;";?></td>
		<td>
			<a href="<?php echo site_url('report/myAllReportView/'.$row->vsl_visit_dtls_ib_vyg.'/1/detail');?>" target="_blank">View</a>
		</td>
		<td>
			<a href="<?php echo site_url('report/myAllReportView/'.$row->vsl_visit_dtls_ib_vyg.'/1/summary');?>" target="_blank"><font color="#990000">View</font></a>
		</td>	
		<td>
			<a href="<?php echo site_url('report/myAllReportView/'.$row->vsl_visit_dtls_ib_vyg.'/2/detail');?>" target="_blank">View</a>
		</td>
		<td>
			<a href="<?php echo site_url('report/myAllReportView/'.$row->vsl_visit_dtls_ib_vyg.'/2/summary');?>" target="_blank"><font color="#990000">View</font></a>
		</td>		
	</tr>
<?php } ?>
</table>
<br />
<br />



<?php 
mysql_close($con_ctmsmis);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
