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
	
	$cond="";
	if($fromdate!="" and $todate!="")	
	{
		if($fromTime!="")
			$frmDate = $fromdate." ".$fromTime.":00";
		else
			$frmDate = $fromdate." 00:00:00";
		
		if($toTime!="")
			$tDate = $todate." ".$toTime.":00";
		else
			$tDate = $todate." 23:59:59";
		
		$cond = " AND mis_exp_unit.last_update BETWEEN '$frmDate' and '$tDate'";
	}
	else
	{
		$cond = " ";
	}
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
<title>MLO WISE LOADED CONTAINER LIST</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td width="30%" align="centre"><img align="middle"  src="<?php echo IMG_PATH?>cpanew.jpg"></td>
</tr>
				<tr>
					<td colspan="7" align="center"><font size="5"><b> <u>OFFICE OF THE TERMINAL MANAGER</u></b></font></td>							
				</tr>
				<tr>
					<td colspan="7" align="center"><font size="4"><b> <u>MLO WISE FINAL LOADING SUMMARY</u></b></font></td>					
				</tr>
<tr><td>&nbsp;</td></tr>				
<tr>		
		
		<td width="90%" align="center">
			<table border=0 width="90%">
				<tr>
					<td ><font size="4">VESSEL: </font></td>
					<td style="text-decoration: underline;text-decoration-style:dotted;"><font size="4"><b> <?php echo $row1->vsl_name; ?></b></font></td>
					<td><font size="4">VOY:</font></td>
					<td style="text-decoration: underline;text-decoration-style:dotted;"><font size="4"><b> <?php echo $voysNo; ?></b></font></td>
					<td ><font size="4"> EXPORT ROT:</font></td>
					<td  style="text-decoration: underline;text-decoration-style:dotted;"><font size="4"><b> <?php echo $ddl_imp_rot_no; ?></b></font></td>
					<td ><font size="4">SAILED DATE:</font></td>
					<td  style="text-decoration: underline;text-decoration-style:dotted;"><font size="4"><b> <?php echo $row1->atd; ?></b></font></td>
					<td><font size="4">BERTH NO:</font></td>
					<td style="text-decoration: underline;text-decoration-style:dotted;"><font size="4"><b> <?php echo $row1->berth; ?></b></font></td>
				</tr>
				<!--tr>
					<td colspan="2"><font size="4">Arrived on</font></td>
					<td colspan="2" style="text-decoration: underline;text-decoration-style:dotted;"><font size="4"><b> <?php echo $row1->ata; ?></b></font></td>
					
				</tr-->

				

			</table>
		
		</td>
		
	</tr>
	
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr>
</table>
	<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<tr>
		<td rowspan="2" align="center"><b>MLO</b></td>
		<td colspan="11" align="center"><b>LADEN</b></td>
		<td colspan="11" align="center"><b>EMPTY</b></td>
		<td rowspan="2" align="center"><b>TOTAL CONTS</b></td>
		<td rowspan="2" align="center"><b>TOTAL TEUS</b></td>
		<td rowspan="2" align="center"><b>WEIGHT</b></td>
	</tr>
	<tr height="40px" align="center">
		<!--td><b>MLO'S</b></td-->		
		<!--td><b>CODE</b></td-->		
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
		<!--td><b>TOTAL CONTS</b></td>
		<td><b>TOTAL TEUS</b></td-->
	
	</tr>
	
	

<?php
	$query=mysql_query("select gkey,mlo,(select name from sparcsn4.ref_bizunit_scoped where id=mlo and name !='NULL' limit 1) as mlo_name,
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
IFNULL(SUM(tues),0) AS tues,
SUM(goods_and_ctr_wt_kg) AS weight
 from (
select distinct ctmsmis.mis_exp_unit.gkey as gkey,cont_mlo as mlo,inv_unit.goods_and_ctr_wt_kg,
(CASE WHEN cont_size = '20' and cont_height='86' AND mis_exp_unit.cont_status in ('FCL','LCL') AND isoGroup not in ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS D_20, 
(CASE WHEN cont_size = '40' and cont_height='86' AND mis_exp_unit.cont_status in ('FCL','LCL') AND isoGroup not in ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS D_40, 
(CASE WHEN cont_size = '40' and cont_height='96' AND mis_exp_unit.cont_status in ('FCL','LCL') AND isoGroup not in ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS H_40, 
(CASE WHEN cont_size = '45' and cont_height='96' AND mis_exp_unit.cont_status in ('FCL','LCL') AND isoGroup not in ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1
	  WHEN cont_size = '42' and cont_height='90' AND mis_exp_unit.cont_status in ('FCL','LCL') AND isoGroup not in ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1
ELSE NULL END) AS H_45,


(CASE WHEN cont_size = '20' and cont_height='86' AND mis_exp_unit.cont_status in ('FCL','LCL') AND isoGroup in ('RS','RT','RE')  THEN 1  
ELSE NULL END) AS R_20, 
(CASE WHEN cont_size = '40' AND mis_exp_unit.cont_status in ('FCL','LCL') AND isoGroup in ('RS','RT','RE')  THEN 1  
ELSE NULL END) AS RH_40,

(CASE WHEN cont_size = '20' and cont_height='86' AND mis_exp_unit.cont_status in ('FCL','LCL') AND isoGroup in ('UT')  THEN 1  
ELSE NULL END) AS OT_20,
(CASE WHEN cont_size = '40' AND mis_exp_unit.cont_status in ('FCL','LCL') AND isoGroup in ('UT')  THEN 1  
ELSE NULL END) AS OT_40,

(CASE WHEN cont_size = '20' and cont_height='86' AND mis_exp_unit.cont_status in ('FCL','LCL') AND isoGroup in ('PF','PC')  THEN 1  
ELSE NULL END) AS FR_20,
(CASE WHEN cont_size = '40' AND mis_exp_unit.cont_status in ('FCL','LCL') AND isoGroup in ('PF','PC')  THEN 1  
ELSE NULL END) AS FR_40,

(CASE WHEN cont_size = '20' and cont_height='86' AND mis_exp_unit.cont_status in ('FCL','LCL') AND isoGroup in ('TN','TD','TG')  THEN 1  
ELSE NULL END) AS TK_20,

(CASE WHEN cont_size = '20' and cont_height='86' AND mis_exp_unit.cont_status ='MTY' AND isoGroup not in ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS MD_20, 
(CASE WHEN cont_size = '40' and cont_height='86' AND mis_exp_unit.cont_status ='MTY' AND isoGroup not in ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS MD_40, 
(CASE WHEN cont_size = '40' and cont_height='96' AND mis_exp_unit.cont_status ='MTY' AND isoGroup not in ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS MH_40, 
(CASE WHEN cont_size = '45' and cont_height='96' AND mis_exp_unit.cont_status ='MTY' AND isoGroup not in ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS MH_45,

(CASE WHEN cont_size = '20' and cont_height='86' AND mis_exp_unit.cont_status ='MTY' AND isoGroup in ('RS','RT','RE')  THEN 1  
ELSE NULL END) AS MR_20, 
(CASE WHEN cont_size = '40' AND mis_exp_unit.cont_status ='MTY' AND isoGroup in ('RS','RT','RE')  THEN 1  
ELSE NULL END) AS MRH_40,

(CASE WHEN cont_size = '20' and cont_height='86' AND mis_exp_unit.cont_status ='MTY' AND isoGroup in ('UT')  THEN 1  
ELSE NULL END) AS MOT_20,
(CASE WHEN cont_size = '40' AND mis_exp_unit.cont_status ='MTY' AND isoGroup in ('UT')  THEN 1  
ELSE NULL END) AS MOT_40,

(CASE WHEN cont_size = '20' and cont_height='86' AND mis_exp_unit.cont_status ='MTY' AND isoGroup in ('PF','PC')  THEN 1  
ELSE NULL END) AS MFR_20,
(CASE WHEN cont_size = '40' AND mis_exp_unit.cont_status ='MTY' AND isoGroup in ('PF','PC')  THEN 1  
ELSE NULL END) AS MFR_40,

(CASE WHEN cont_size = '20' and cont_height='86' AND mis_exp_unit.cont_status ='MTY' AND isoGroup in ('TN','TD','TG')  THEN 1  
ELSE NULL END) AS MTK_20,
(CASE WHEN cont_size in('20','40','45','42')  THEN 1 ELSE NULL END) AS grand_tot,
(CASE WHEN cont_size=20  THEN 1 ELSE 2 END) AS tues     
FROM ctmsmis.mis_exp_unit
left join sparcsn4.inv_unit on sparcsn4.inv_unit.gkey=ctmsmis.mis_exp_unit.gkey
 
where  mis_exp_unit.vvd_gkey='$vvdGkey' AND mis_exp_unit.preAddStat='0' and snx_type=0 and cont_mlo is not null ".$cond."
) as tmp group by mlo WITH ROLLUP");

// ** (CASE WHEN cont_size in('20','40','45','42')  THEN 1 ELSE NULL END) AS grand_tot, **
//9400771
/*	$query=mysql_query("select gkey,mlo,mlo_name,
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
 from (
select distinct ctmsmis.mis_exp_unit.gkey as gkey,mlo as mlo,mlo_name as mlo_name,
(CASE WHEN size = '20' and height='86' AND mis_exp_unit.cont_status in ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp not in ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS D_20, 
(CASE WHEN size = '40' and height='86' AND mis_exp_unit.cont_status in ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp not in ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS D_40, 
(CASE WHEN size = '40' and height='96' AND mis_exp_unit.cont_status in ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp not in ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS H_40, 
(CASE WHEN size = '45' and height='96' AND mis_exp_unit.cont_status in ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp not in ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS H_45,


(CASE WHEN size = '20' and height='86' AND mis_exp_unit.cont_status in ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp in ('RS','RT','RE')  THEN 1  
ELSE NULL END) AS R_20, 
(CASE WHEN size = '40' AND mis_exp_unit.cont_status in ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp in ('RS','RT','RE')  THEN 1  
ELSE NULL END) AS RH_40,

(CASE WHEN size = '20' and height='86' AND mis_exp_unit.cont_status in ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp in ('UT')  THEN 1  
ELSE NULL END) AS OT_20,
(CASE WHEN size = '40' AND mis_exp_unit.cont_status in ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp in ('UT')  THEN 1  
ELSE NULL END) AS OT_40,

(CASE WHEN size = '20' and height='86' AND mis_exp_unit.cont_status in ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp in ('PF','PC')  THEN 1  
ELSE NULL END) AS FR_20,
(CASE WHEN size = '40' AND mis_exp_unit.cont_status in ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp in ('PF','PC')  THEN 1  
ELSE NULL END) AS FR_40,

(CASE WHEN size = '20' and height='86' AND mis_exp_unit.cont_status in ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp in ('TN','TD','TG')  THEN 1  
ELSE NULL END) AS TK_20,

(CASE WHEN size = '20' and height='86' AND mis_exp_unit.cont_status ='MTY' AND ctmsmis.mis_inv_unit.iso_grp not in ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS MD_20, 
(CASE WHEN size = '40' and height='86' AND mis_exp_unit.cont_status ='MTY' AND ctmsmis.mis_inv_unit.iso_grp not in ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS MD_40, 
(CASE WHEN size = '40' and height='96' AND mis_exp_unit.cont_status ='MTY' AND ctmsmis.mis_inv_unit.iso_grp not in ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS MH_40, 
(CASE WHEN size = '45' and height='96' AND mis_exp_unit.cont_status ='MTY' AND ctmsmis.mis_inv_unit.iso_grp not in ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS MH_45,


(CASE WHEN size = '20' and height='86' AND mis_exp_unit.cont_status ='MTY' AND ctmsmis.mis_inv_unit.iso_grp in ('RS','RT','RE')  THEN 1  
ELSE NULL END) AS MR_20, 
(CASE WHEN size = '40' AND mis_exp_unit.cont_status ='MTY' AND ctmsmis.mis_inv_unit.iso_grp in ('RS','RT','RE')  THEN 1  
ELSE NULL END) AS MRH_40,

(CASE WHEN size = '20' and height='86' AND mis_exp_unit.cont_status ='MTY' AND ctmsmis.mis_inv_unit.iso_grp in ('UT')  THEN 1  
ELSE NULL END) AS MOT_20,
(CASE WHEN size = '40' AND mis_exp_unit.cont_status ='MTY' AND ctmsmis.mis_inv_unit.iso_grp in ('UT')  THEN 1  
ELSE NULL END) AS MOT_40,

(CASE WHEN size = '20' and height='86' AND mis_exp_unit.cont_status ='MTY' AND ctmsmis.mis_inv_unit.iso_grp in ('PF','PC')  THEN 1  
ELSE NULL END) AS MFR_20,
(CASE WHEN size = '40' AND mis_exp_unit.cont_status ='MTY' AND ctmsmis.mis_inv_unit.iso_grp in ('PF','PC')  THEN 1  
ELSE NULL END) AS MFR_40,

(CASE WHEN size = '20' and height='86' AND mis_exp_unit.cont_status ='MTY' AND ctmsmis.mis_inv_unit.iso_grp in ('TN','TD','TG')  THEN 1  
ELSE NULL END) AS MTK_20,
(CASE WHEN size in('20','40','45','42')  THEN 1 ELSE NULL END) AS grand_tot,
(CASE WHEN size=20  THEN 1 ELSE 2 END) AS tues     
FROM ctmsmis.mis_exp_unit
left join ctmsmis.mis_inv_unit on ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
 
  
where  mis_exp_unit.vvd_gkey='$vvdGkey' AND mis_exp_unit.preAddStat='0' and mlo is not null
) as tmp group by mlo WITH ROLLUP");*/
	/*$query=mysql_query("select gkey,mlo,mlo_name,
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
 from (
select distinct ctmsmis.mis_exp_unit.gkey as gkey,mlo as mlo,mlo_name as mlo_name,
(CASE WHEN size = '20' and height='86' AND freight_kind in ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp not in ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS D_20, 
(CASE WHEN size = '40' and height='86' AND freight_kind in ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp not in ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS D_40, 
(CASE WHEN size = '40' and height='96' AND freight_kind in ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp not in ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS H_40, 
(CASE WHEN size = '45' and height='96' AND freight_kind in ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp not in ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS H_45,


(CASE WHEN size = '20' and height='86' AND freight_kind in ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp in ('RS','RT','RE')  THEN 1  
ELSE NULL END) AS R_20, 
(CASE WHEN size = '40' AND freight_kind in ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp in ('RS','RT','RE')  THEN 1  
ELSE NULL END) AS RH_40,

(CASE WHEN size = '20' and height='86' AND freight_kind in ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp in ('UT')  THEN 1  
ELSE NULL END) AS OT_20,
(CASE WHEN size = '40' AND freight_kind in ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp in ('UT')  THEN 1  
ELSE NULL END) AS OT_40,

(CASE WHEN size = '20' and height='86' AND freight_kind in ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp in ('PF','PC')  THEN 1  
ELSE NULL END) AS FR_20,
(CASE WHEN size = '40' AND freight_kind in ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp in ('PF','PC')  THEN 1  
ELSE NULL END) AS FR_40,

(CASE WHEN size = '20' and height='86' AND freight_kind in ('FCL','LCL') AND ctmsmis.mis_inv_unit.iso_grp in ('TN','TD','TG')  THEN 1  
ELSE NULL END) AS TK_20,

(CASE WHEN size = '20' and height='86' AND freight_kind ='MTY' AND ctmsmis.mis_inv_unit.iso_grp not in ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS MD_20, 
(CASE WHEN size = '40' and height='86' AND freight_kind ='MTY' AND ctmsmis.mis_inv_unit.iso_grp not in ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS MD_40, 
(CASE WHEN size = '40' and height='96' AND freight_kind ='MTY' AND ctmsmis.mis_inv_unit.iso_grp not in ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS MH_40, 
(CASE WHEN size = '45' and height='96' AND freight_kind ='MTY' AND ctmsmis.mis_inv_unit.iso_grp not in ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
ELSE NULL END) AS MH_45,


(CASE WHEN size = '20' and height='86' AND freight_kind ='MTY' AND ctmsmis.mis_inv_unit.iso_grp in ('RS','RT','RE')  THEN 1  
ELSE NULL END) AS MR_20, 
(CASE WHEN size = '40' AND freight_kind ='MTY' AND ctmsmis.mis_inv_unit.iso_grp in ('RS','RT','RE')  THEN 1  
ELSE NULL END) AS MRH_40,

(CASE WHEN size = '20' and height='86' AND freight_kind ='MTY' AND ctmsmis.mis_inv_unit.iso_grp in ('UT')  THEN 1  
ELSE NULL END) AS MOT_20,
(CASE WHEN size = '40' AND freight_kind ='MTY' AND ctmsmis.mis_inv_unit.iso_grp in ('UT')  THEN 1  
ELSE NULL END) AS MOT_40,

(CASE WHEN size = '20' and height='86' AND freight_kind ='MTY' AND ctmsmis.mis_inv_unit.iso_grp in ('PF','PC')  THEN 1  
ELSE NULL END) AS MFR_20,
(CASE WHEN size = '40' AND freight_kind ='MTY' AND ctmsmis.mis_inv_unit.iso_grp in ('PF','PC')  THEN 1  
ELSE NULL END) AS MFR_40,

(CASE WHEN size = '20' and height='86' AND freight_kind ='MTY' AND ctmsmis.mis_inv_unit.iso_grp in ('TN','TD','TG')  THEN 1  
ELSE NULL END) AS MTK_20,
(CASE WHEN size in('20','40','45','42')  THEN 1 ELSE NULL END) AS grand_tot,
(CASE WHEN size=20  THEN 1 ELSE 2 END) AS tues     
FROM ctmsmis.mis_exp_unit
left join ctmsmis.mis_inv_unit on ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
 
  
where  mis_exp_unit.vvd_gkey='$vvdGkey' AND mis_exp_unit.preAddStat='0' and mlo is not null
) as tmp group by mlo WITH ROLLUP
");*/
	$i=0;
	$j=0;
	
	$mlo="";
	while($row=mysql_fetch_object($query)){
	$i++;
	
		
	
?>
<tr align="center">
		<!--td><?php if($row->mlo) echo $row->mlo_name; else echo "<b>TOTAL</b>";?></td-->
		<td><?php if($row->mlo) echo $row->mlo; else echo "<b>TOTAL</b>";?></td>
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
		<td><?php if($row->weight) echo $row->weight; else echo "&nbsp;";?></td>
	</tr>

<?php } ?>

</table>
<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
