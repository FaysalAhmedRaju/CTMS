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
				
				<tr align="center">
					<!--td colspan="12"><font size="4"><b> CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td-->
					<td colspan="12" align="center"><img width="250px" height="80px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
				</tr>
			
				<tr align="center">
					<td colspan="12"><font size="4"><b><u>Rotation Wise Export Container  Report</u></b></font></td>
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
		<td style="border-width:1px;border-style: double;" rowspan="2"><b>AGENT.</b></td>
		<td style="border-width:1px;border-style: double;" rowspan="2"><b>MLO.</b></td>
		<td style="border-width:1px;border-style: double;" colspan="2"><b>LOAD</b></td>
		<td style="border-width:1px;border-style: double;" colspan="2"><b>EMPTY</b></td>
		<td style="border-width:1px;border-style: double;" colspan="2"><b>REFFER</b></td>
		<td style="border-width:1px;border-style: double;" colspan="2"><b>IMDG</b></td>
		<td style="border-width:1px;border-style: double;" colspan="2"><b>TRANS</b></td>
		<td style="border-width:1px;border-style: double;" colspan="2"><b>ICD</b></td>
		<td style="border-width:1px;border-style: double;" colspan="2"><b>45</b></td>
		<td style="border-width:1px;border-style: double;" rowspan="2"><b>TOTAL</b></td>
		<td style="border-width:1px;border-style: double;" colspan="2"><b>MLO REPORT</b></td>
	</tr>
	<tr align="center">
		<td style="border-width:1px;border-style: double;"><b>20</b></td>
		<td style="border-width:1px;border-style: double;"><b>40</b></td>
		<td style="border-width:1px;border-style: double;"><b>20</b></td>
		<td style="border-width:1px;border-style: double;"><b>40</b></td>
		<td style="border-width:1px;border-style: double;"><b>20</b></td>
		<td style="border-width:1px;border-style: double;"><b>40</b></td>
		<td style="border-width:1px;border-style: double;"><b>20</b></td>
		<td style="border-width:1px;border-style: double;"><b>40</b></td>
		<td style="border-width:1px;border-style: double;"><b>20</b></td>
		<td style="border-width:1px;border-style: double;"><b>40</b></td>
		<td style="border-width:1px;border-style: double;"><b>20</b></td>
		<td style="border-width:1px;border-style: double;"><b>40</b></td>
		<td style="border-width:1px;border-style: double;"><b>LD</b></td>
		<td style="border-width:1px;border-style: double;"><b>MT</b></td>
		<td style="border-width:1px;border-style: double;"><b>DETAILS</b></td>
		<td style="border-width:1px;border-style: double;"><b>SUMMARY</b></td>
		
	</tr>

<?php
	//echo $todate;
include("mydbPConnectionctms.php");
	
$query=mysql_query("
SELECT gkey,mlo,agent,
IFNULL(SUM(Loaded_20),0) AS Loaded_20,
IFNULL(SUM(Loaded_40),0) AS Loaded_40,
IFNULL(SUM(EMTY_20),0) AS EMTY_20,
IFNULL(SUM(EMTY_40),0) AS EMTY_40,

IFNULL(SUM(REEFER_20),0) AS REEFER_20,
IFNULL(SUM(REEFER_40),0) AS REEFER_40,
IFNULL(SUM(IMDG_20),0) AS IMDG_20,
IFNULL(SUM(IMDG_40),0) AS IMDG_40,
IFNULL(SUM(TRSHP_20),0) AS TRSHP_20,
IFNULL(SUM(TRSHP_40),0) AS TRSHP_40,
IFNULL(SUM(ICD_20),0) AS ICD_20,
IFNULL(SUM(ICD_40),0) AS ICD_40,
IFNULL(SUM(LD_20),0) AS LD_20,
IFNULL(SUM(LD_40),0) AS LD_40,

IFNULL(SUM(grand_tot),0) AS grand_tot,
IFNULL(SUM(tues),0) AS tues
FROM (
SELECT DISTINCT ctmsmis.mis_exp_unit_preadv_req.gkey AS gkey,mis_exp_unit_preadv_req.cont_mlo AS mlo,mis_exp_unit_preadv_req.agent AS agent,
(CASE WHEN cont_size =20  AND cont_status IN ('FCL','LCL') and ctmsmis.mis_exp_unit_preadv_req.isoType not in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3','45R5') THEN 1  
ELSE NULL END) AS Loaded_20, 
(CASE WHEN cont_size!=20  AND cont_status IN ('FCL','LCL') and ctmsmis.mis_exp_unit_preadv_req.isoType not in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3','45R5')  THEN 1  
ELSE NULL END) AS Loaded_40, 

(CASE WHEN cont_size = 20 AND cont_status ='MTY'  THEN 1  
ELSE NULL END) AS EMTY_20, 
(CASE WHEN cont_size != 20 AND cont_status ='MTY'  THEN 1  
ELSE NULL END) AS EMTY_40, 
(CASE WHEN cont_size = 20 AND cont_status IN ('FCL','LCL') AND ctmsmis.mis_exp_unit_preadv_req.isoType in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3','45R5')  THEN 1  
ELSE NULL END) AS REEFER_20, 
(CASE WHEN cont_size != 20 AND cont_status IN ('FCL','LCL') AND ctmsmis.mis_exp_unit_preadv_req.isoType in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3','45R5')  THEN 1  
ELSE NULL END) AS REEFER_40,
'' AS IMDG_20, 
'' AS IMDG_40, 
(CASE WHEN cont_size =20  AND cont_status IN ('FCL','LCL','MTY') AND ctmsmis.mis_exp_unit_preadv_req.cont_category='TRSHP' THEN 1  
ELSE NULL END) AS TRSHP_20, 
(CASE WHEN cont_size!=20  AND cont_status IN ('FCL','LCL','MTY') AND ctmsmis.mis_exp_unit_preadv_req.cont_category='TRSHP' THEN 1  
ELSE NULL END) AS TRSHP_40, 
'' AS ICD_20, 
'' AS ICD_40, 
'' AS LD_20, 
'' AS LD_40, 
1 AS grand_tot,
 (CASE WHEN cont_size=20  THEN 1 ELSE 2 END) AS tues 
FROM  ctmsmis.mis_exp_unit_preadv_req
WHERE  mis_exp_unit_preadv_req.rotation='$ddl_imp_rot_no'
) AS tmp GROUP BY mlo 
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
	
		<td><?php if($row->agent) echo $row->agent; else echo "&nbsp;";?></td>
		<td><?php if($row->mlo) echo $row->mlo; else echo "&nbsp;";?></td>
		<td><?php if($row->Loaded_20) echo $row->Loaded_20; else echo "&nbsp;";?></td>
		<td><?php if($row->Loaded_40) echo $row->Loaded_40; else echo "&nbsp;";?></td>
		<td><?php if($row->EMTY_20) echo $row->EMTY_20; else echo "&nbsp;";?></td>
		<td><?php if($row->EMTY_40) echo $row->EMTY_40; else echo "&nbsp;";?></td>
		<td><?php if($row->REEFER_20) echo $row->REEFER_20; else echo "&nbsp;";?></td>
		<td><?php if($row->REEFER_40) echo $row->REEFER_40; else echo "&nbsp;";?></td>
		<td><?php if($row->IMDG_20) echo $row->IMDG_20; else echo "&nbsp;";?></td>
		<td><?php if($row->IMDG_40) echo $row->IMDG_40; else echo "&nbsp;";?></td>
		<td><?php if($row->TRSHP_20) echo $row->TRSHP_20; else echo "&nbsp;";?></td>
		<td><?php if($row->TRSHP_40) echo $row->TRSHP_40; else echo "&nbsp;";?></td>
		<td><?php if($row->ICD_20) echo $row->ICD_20; else echo "&nbsp;";?></td>
		<td><?php if($row->ICD_40) echo $row->ICD_40; else echo "&nbsp;";?></td>
		<td><?php if($row->LD_20) echo $row->LD_20; else echo "&nbsp;";?></td>
		<td><?php if($row->LD_40) echo $row->LD_40; else echo "&nbsp;";?></td>
		<td><?php if($row->grand_tot) echo $row->grand_tot; else echo "&nbsp;";?></td>
		<td>
			<a href="<?php echo site_url('report/myPreAdviceAllView/'.$ddl_imp_rot_no.'/'.$row->mlo);?>" target="_blank">View</a>
		</td>
		<td>
			<a href="<?php echo site_url('report/mlowiseviewsummary/'.$ddl_imp_rot_no.'/'.$row->mlo);?>" target="_blank"><font color="#990000">View</font></a>
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
