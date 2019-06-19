<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>Bearth Operator Report</TITLE>
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
		header("Content-Disposition: attachment; filename=MLO_WISE_SUMMERY.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}
//$ddl_imp_rot_no=$_REQUEST['ddl_imp_rot_no']; 

	//$con=mysql_connect("10.1.1.21", "sparcsn4","sparcsn4")or die("cannot connect"); 
	//mysql_select_db("sparcsn4")or die("cannot select DB");
	include_once("mydbPConnectionn4.php");
	
	$sql=mysql_query("select vvd_gkey from sparcsn4.vsl_vessel_visit_details where ib_vyg='$ddl_imp_rot_no'");
	$row=mysql_fetch_object($sql);
	$vvdGkey=$row->vvd_gkey;
	
	$sql="call ctmsmis.update_containers_by_vvd_gkey($vvdGkey)";
	$res=mysql_query($sql);
	
	$sql1=mysql_query("select vsl_vessels.name as vsl_name,ifnull(sparcsn4.vsl_vessel_visit_details.flex_string02,ifnull(sparcsn4.vsl_vessel_visit_details.flex_string03,'')) as berth_op,ifnull(sparcsn4.argo_quay.id,'') as berth,sparcsn4.argo_carrier_visit.ata,sparcsn4.argo_carrier_visit.atd from vsl_vessel_visit_details
inner join sparcsn4.argo_carrier_visit on sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
inner join sparcsn4.vsl_vessel_berthings on sparcsn4.vsl_vessel_berthings.vvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
inner join sparcsn4.argo_quay on sparcsn4.argo_quay.gkey=sparcsn4.vsl_vessel_berthings.quay
where vsl_vessel_visit_details.vvd_gkey=$vvdGkey");
	$row1=mysql_fetch_object($sql1);
	
	?>
<html>
<title>MLO WISE IMPORT CONTAINER LIST</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<!--td width="30%" align="centre"><font size="5"><b> CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td-->
		<td align="center"><img width="250px" height="80px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
		<td width="70%" align="center">
			<table border=0 width="100%">
				<tr>
					<td ><font size="4">M.V. </font></td>
					<td colspan="3" style="text-decoration: underline;text-decoration-style:dotted;"><font size="4"><b> <?php echo $row1->vsl_name; ?></b></font></td>
					<td><font size="4">VOY</font></td>
					<td colspan="3" style="text-decoration: underline;text-decoration-style:dotted;"><font size="4"><b> <?php echo $voysNo; ?></b></font></td>
					<td ><font size="4">ROT/NO</font></td>
					<td colspan="3" style="text-decoration: underline;text-decoration-style:dotted;"><font size="4"><b> <?php echo $ddl_imp_rot_no; ?></b></font></td>
				</tr>
				<tr>
					<td colspan="2"><font size="4">Arrived on</font></td>
					<td colspan="2" style="text-decoration: underline;text-decoration-style:dotted;"><font size="4"><b> <?php echo $row1->ata; ?></b></font></td>
					<td colspan="2" ><font size="4">Sailed on</font></td>
					<td colspan="2" style="text-decoration: underline;text-decoration-style:dotted;"><font size="4"><b> <?php echo $row1->atd; ?></b></font></td>
					<td colspan="2" ><font size="4">Berth No</font></td>
					<td colspan="2" style="text-decoration: underline;text-decoration-style:dotted;"><font size="4"><b> <?php echo $row1->berth; ?></b></font></td>
				</tr>

				<tr>
					<td colspan="7" align="center"><font size="5"><b> <u>MLO WISE IMPORT SUMMARY</u></b></font></td>
					
				</tr>

			</table>
		
		</td>
		
	</tr>
	
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr>
</table>
	<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<tr>
		<td></td>
		<td colspan="11" align="center"><b>LADEN</b></td>
		<td colspan="11" align="center"><b>EMPTY</b></td>
		<td></td>
		<td></td>
	</tr>
	<tr height="40px" align="center">
		<td><b>MLO'S</b></td>		
		<td><b>2D</b></td>
		<td><b>4D</b></td>
		<td><b>4H</b></td>
		<td><b>45H</b></td>		
		<td><b>4RH</b></td>
		<td><b>2RF</b></td>
		<td><b>2OT</b></td>
		<td><b>2FR</b></td>
		<td><b>2TK</b></td>
		<td><b>4FR</b></td>
		<td><b>4OT</b></td>
		<td><b>2D</b></td>
		<td><b>4D</b></td>
		<td><b>4H</b></td>
		<td><b>45H</b></td>		
		<td><b>4RH</b></td>
		<td><b>2RF</b></td>
		<td><b>2OT</b></td>
		<td><b>2FR</b></td>
		<td><b>2TK</b></td>
		<td><b>4FR</b></td>
		<td><b>4OT</b></td>				
		<td><b>TOTAL CONTS</b></td>
		<td><b>TOTAL TEUS</b></td>
	
	</tr>
	
	

<?php
	
	
	$query=mysql_query("SELECT gkey,mlo,mlo_name,
IFNULL(SUM(D_20),0) AS D_20,
IFNULL(SUM(D_40),0) AS D_40,
IFNULL(SUM(H_40),0) AS H_40,
IFNULL(SUM(H_45),0) AS H_45,

IFNULL(SUM(R_20),0) AS R_20,
IFNULL(SUM(RH_40),0) AS RH_40,

IFNULL(SUM(OT_20),0) AS OT_20,
IFNULL(SUM(OT_40),0) AS OT_40,

IFNULL(SUM(FR_20),0) AS FR_20,
IFNULL(SUM(FR_40),0) AS FR_40,

IFNULL(SUM(TK_20),0) AS TK_20,

IFNULL(SUM(MD_20),0) AS MD_20,
IFNULL(SUM(MD_40),0) AS MD_40,
IFNULL(SUM(MH_40),0) AS MH_40,
IFNULL(SUM(MH_45),0) AS MH_45,

IFNULL(SUM(MR_20),0) AS MR_20,
IFNULL(SUM(MRH_40),0) AS MRH_40,

IFNULL(SUM(MOT_20),0) AS MOT_20,
IFNULL(SUM(MOT_40),0) AS MOT_40,

IFNULL(SUM(MFR_20),0) AS MFR_20,
IFNULL(SUM(MFR_40),0) AS MFR_40,

IFNULL(SUM(MTK_20),0) AS MTK_20,

IFNULL(SUM(grand_tot),0) AS grand_tot,
IFNULL(SUM(tues),0) AS tues
 FROM (
SELECT DISTINCT ctmsmis.mis_inv_unit.gkey AS gkey,mlo AS mlo,mlo_name AS mlo_name,
(CASE WHEN size = '20' AND height='86' AND freight_kind IN ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS D_20, 
(CASE WHEN size = '40' AND height='86' AND freight_kind IN ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS D_40, 
(CASE WHEN size = '40' AND height='96' AND freight_kind IN ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS H_40, 
(CASE WHEN size = '45' AND height='96' AND freight_kind IN ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS H_45,


(CASE WHEN size = '20' AND height='86' AND freight_kind IN ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp IN ('RS','RT','RE')  THEN 1  
ELSE NULL END) AS R_20, 
(CASE WHEN size = '40' AND freight_kind IN ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp IN ('RS','RT','RE')  THEN 1  
ELSE NULL END) AS RH_40,

(CASE WHEN size = '20' AND height='86' AND freight_kind IN ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp IN ('UT')  THEN 1  
ELSE NULL END) AS OT_20,
(CASE WHEN size = '40' AND freight_kind IN ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp IN ('UT')  THEN 1  
ELSE NULL END) AS OT_40,

(CASE WHEN size = '20' AND height='86' AND freight_kind IN ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp IN ('PF','PC')  THEN 1  
ELSE NULL END) AS FR_20,
(CASE WHEN size = '40' AND freight_kind IN ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp IN ('PF','PC')  THEN 1  
ELSE NULL END) AS FR_40,

(CASE WHEN size = '20' AND height='86' AND freight_kind IN ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp IN ('TN','TD','TG')  THEN 1  
ELSE NULL END) AS TK_20,

(CASE WHEN size = '20' AND height='86' AND freight_kind ='MTY' AND ctmsmis.mis_inv_unit.iso_grp NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS MD_20, 
(CASE WHEN size = '40' AND height='86' AND freight_kind ='MTY' AND ctmsmis.mis_inv_unit.iso_grp NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS MD_40, 
(CASE WHEN size = '40' AND height='96' AND freight_kind ='MTY' AND ctmsmis.mis_inv_unit.iso_grp NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS MH_40, 
(CASE WHEN size = '45' AND height='96' AND freight_kind ='MTY' AND ctmsmis.mis_inv_unit.iso_grp NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS MH_45,


(CASE WHEN size = '20' AND height='86' AND freight_kind ='MTY' AND ctmsmis.mis_inv_unit.iso_grp IN ('RS','RT','RE')  THEN 1  
ELSE NULL END) AS MR_20, 
(CASE WHEN size = '40' AND freight_kind ='MTY' AND ctmsmis.mis_inv_unit.iso_grp IN ('RS','RT','RE')  THEN 1  
ELSE NULL END) AS MRH_40,

(CASE WHEN size = '20' AND height='86' AND freight_kind ='MTY' AND ctmsmis.mis_inv_unit.iso_grp IN ('UT')  THEN 1  
ELSE NULL END) AS MOT_20,
(CASE WHEN size = '40' AND freight_kind ='MTY' AND ctmsmis.mis_inv_unit.iso_grp IN ('UT')  THEN 1  
ELSE NULL END) AS MOT_40,

(CASE WHEN size = '20' AND height='86' AND freight_kind ='MTY' AND ctmsmis.mis_inv_unit.iso_grp IN ('PF','PC')  THEN 1  
ELSE NULL END) AS MFR_20,
(CASE WHEN size = '40' AND freight_kind ='MTY' AND ctmsmis.mis_inv_unit.iso_grp IN ('PF','PC')  THEN 1  
ELSE NULL END) AS MFR_40,

(CASE WHEN size = '20' AND height='86' AND freight_kind ='MTY' AND ctmsmis.mis_inv_unit.iso_grp IN ('TN','TD','TG')  THEN 1  
ELSE NULL END) AS MTK_20,
(CASE WHEN size IN('20','40','45','42')  THEN 1 ELSE NULL END) AS grand_tot,
(CASE WHEN size=20  THEN 1 ELSE 2 END) AS tues     
FROM ctmsmis.mis_inv_unit

 
  
WHERE  mis_inv_unit.vvd_gkey='$vvdGkey' AND mis_inv_unit.category='IMPRT' AND mlo IS NOT NULL
) AS tmp GROUP BY mlo WITH ROLLUP
");
	$i=0;
	$j=0;
	
	$mlo="";
	while($row=mysql_fetch_object($query)){
	$i++;
	
		
	
?>
<tr align="center">
		<td><?php if($row->mlo) echo $row->mlo_name." (".$row->mlo.")"; else echo "<b>TOTAL</b>";?></td>
		<td><?php if($row->D_20) echo $row->D_20; else echo "&nbsp;";?></td>
		<td><?php if($row->D_40) echo $row->D_40; else echo "&nbsp;";?></td>
		<td><?php if($row->H_40) echo $row->H_40; else echo "&nbsp;";?></td>
		<td><?php if($row->H_45) echo $row->H_45; else echo "&nbsp;";?></td>
		
		<td><?php if($row->RH_40) echo $row->RH_40; else echo "&nbsp;";?></td>
		<td><?php if($row->R_20) echo $row->R_20; else echo "&nbsp;";?></td>
		
		
		<td><?php if($row->OT_20) echo $row->OT_20; else echo "&nbsp;";?></td>
		<td><?php if($row->FR_20) echo $row->FR_20; else echo "&nbsp;";?></td>
		<td><?php if($row->TK_20) echo $row->TK_20; else echo "&nbsp;";?></td>
		
		<td><?php if($row->FR_40) echo $row->FR_40; else echo "&nbsp;";?></td>
		<td><?php if($row->OT_40) echo $row->OT_40; else echo "&nbsp;";?></td>
		
		<td><?php if($row->MD_20) echo $row->MD_20; else echo "&nbsp;";?></td>
		<td><?php if($row->MD_40) echo $row->MD_40; else echo "&nbsp;";?></td>
		<td><?php if($row->MH_40) echo $row->MH_40; else echo "&nbsp;";?></td>
		<td><?php if($row->MH_45) echo $row->MH_45; else echo "&nbsp;";?></td>
		
		<td><?php if($row->MRH_40) echo $row->MRH_40; else echo "&nbsp;";?></td>
		<td><?php if($row->MR_20) echo $row->MR_20; else echo "&nbsp;";?></td>		
		
		
		<td><?php if($row->MOT_20) echo $row->MOT_20; else echo "&nbsp;";?></td>
		<td><?php if($row->MFR_20) echo $row->MFR_20; else echo "&nbsp;";?></td>
		<td><?php if($row->MTK_20) echo $row->MTK_20; else echo "&nbsp;";?></td>
		
		<td><?php if($row->MFR_40) echo $row->MFR_40; else echo "&nbsp;";?></td>
		<td><?php if($row->MOT_40) echo $row->MOT_40; else echo "&nbsp;";?></td>
		
		<td><?php if($row->grand_tot) echo $row->grand_tot; else echo "&nbsp;";?></td>
		<td><?php if($row->tues) echo $row->tues; else echo "&nbsp;";?></td>
	</tr>

<?php } ?>

</table>
<?php 
mysql_close($con);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
