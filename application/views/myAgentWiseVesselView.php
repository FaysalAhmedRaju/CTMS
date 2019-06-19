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
<title>Agent Wise Export Container  Report</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				
				<!--tr align="center">
					<td colspan="12"><font size="4"><b> CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td>
				</tr-->
				<tr>
					<td colspan="12" align="center"><img width="250px" height="80px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
				</tr>
			
				<tr align="center">
					<td colspan="12"><font size="4"><b><u>Agent Wise Export Container  Report</u></b></font></td>
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
	
		<td style="border-width:1px;border-style: double;" rowspan="2"><b>Total Exp Unit.</b></td>
		<td style="border-width:1px;border-style: double;" colspan="2"><b>Agent Wise PreAdvice</b></td>
		
	</tr>
	<tr align="center">
		<td style="border-width:1px;border-style: double;"><b>Details</b></td>
		<!--td style="border-width:1px;border-style: double;"><b>Summary</b></td-->
		
	</tr>

<?php
	//echo $todate;

include("mydbPConnectionctms.php");
$query=mysql_query("select *,
(select count(cont_id) from ctmsmis.mis_exp_unit_preadv_req preq where preq.rotation=tbl.rotation) as totexpcont
from
(
select distinct vvd_gkey,rotation,
(select sparcsn4.vsl_vessels.name from sparcsn4.vsl_vessel_visit_details
inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
where sparcsn4.vsl_vessel_visit_details.vvd_gkey=mis_exp_unit_preadv_req.vvd_gkey) as vsl_name,
(SELECT sparcsn4.argo_carrier_visit.phase FROM sparcsn4.argo_carrier_visit
 WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit_preadv_req.vvd_gkey) AS phase,
(select ata from sparcsn4.argo_carrier_visit where cvcvd_gkey=mis_exp_unit_preadv_req.vvd_gkey) as ata,
(select atd from sparcsn4.argo_carrier_visit where cvcvd_gkey=mis_exp_unit_preadv_req.vvd_gkey) as atd

from ctmsmis.mis_exp_unit_preadv_req 
where agent='$login_id' order by last_update desc limit 20) as tbl where phase !='80CANCELED'");
 //echo $query;
	$i=0;
	$j=0;
	

	while($row=mysql_fetch_object($query)){
	$i++;
	
	//echo$row->vvd_gkey;
	
?>
<tr align="center">
		<td><?php  echo $i;?></td>
		<td><?php if($row->rotation) echo $row->rotation; else echo "&nbsp;";?></td>
		<td><?php if($row->vsl_name) echo $row->vsl_name; else echo "&nbsp;";?></td>
		<td><?php if($row->phase) echo substr($row->phase,2); else echo "&nbsp;";?></td>
		<td><?php if($row->ata) echo $row->ata; else echo "&nbsp;";?></td>
		<td><?php if($row->atd) echo $row->atd; else echo "&nbsp;";?></td>
		<td><?php if($row->totexpcont) echo $row->totexpcont; else echo "&nbsp;";?></td>
		<td>
			<a href="<?php echo site_url('report/myPreAdviceContainerDetail/'.$row->rotation.'/');?>" target="_blank">View</a>
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
