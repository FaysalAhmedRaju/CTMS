<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<!--TITLE>MLO WISE LOADING SUMMARY REPORT</TITLE-->
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
		
		$cond = " where time_in between '$frmDate' and '$tDate'";
	}
	else
	{
		$cond = " ";
	}
	//$sql="call ctmsmis.update_containers_by_vvd_gkey($vvdGkey)";
	//$res=mysql_query($sql);
	
	$sql1=mysql_query("select vsl_vessels.name as vsl_name,ifnull(sparcsn4.vsl_vessel_visit_details.flex_string02,ifnull(sparcsn4.vsl_vessel_visit_details.flex_string03,'')) as berth_op,ifnull(sparcsn4.argo_quay.id,'') as berth,sparcsn4.argo_carrier_visit.ata,sparcsn4.argo_carrier_visit.atd from vsl_vessel_visit_details
inner join sparcsn4.argo_carrier_visit on sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
inner join sparcsn4.vsl_vessel_berthings on sparcsn4.vsl_vessel_berthings.vvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
inner join sparcsn4.argo_quay on sparcsn4.argo_quay.gkey=sparcsn4.vsl_vessel_berthings.quay
where vsl_vessel_visit_details.vvd_gkey=$vvdGkey");
	$row1=mysql_fetch_object($sql1);
	
	?>
<html>
<!--title>MLO WISE IMPORT CONTAINER LIST</title-->
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
	<tr>
		<td colspan="7" align="center"><img align="middle"  src="<?php echo IMG_PATH?>cpanew.jpg"></td>
	</tr>
	<tr>
		<td colspan="7" align="center"><font size="3"><b>OFFICE OF THE TERMINAL MANAGER</b></font></td>
	</tr>
	<tr>
		<td colspan="7" align="center"><font size="3"><b>MLO WISE FINAL DISCHARGING SUMMARY</b></font></td>					
	</tr>
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="5" align="center"></td>
	</tr>
	<tr bgcolor="#ffffff" align="center">
		<td  align="centre"><font size="3"><b>VESSEL-<?php echo $row1->vsl_name; ?></b></font></td>
		<td  align="centre"><font size="3"><b>VOY- <?php echo $voysNo; ?></b></font></td>
		<td  align="centre"><font size="3"><b>IMP.ROT- <?php echo $ddl_imp_rot_no; ?></b></font></td>
		<td  align="centre"><font size="3"><b>ARRIVED DATE- <?php echo $row1->ata; ?></b></font></td>
		<td  align="centre"><font size="3"><b>BERTH-<?php echo $row1->berth; ?></b></font></td>
	</tr>
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
	</tr>
</table>
	<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<tr align="center">
		<td rowspan="2" align="center"><b>MLO'S<b></td>
		<td colspan="11" align="center"><b>LADEN</b></td>
		<td colspan="11" align="center"><b>EMPTY</b></td>
		<td rowspan="2" align="center"><b>TOTAL CONTS</b></td>
		<td rowspan="2" align="center"><b>TOTAL TEUS</b></td>
		<td rowspan="2" align="center"><b>WEIGHT</b></td>
	</tr>
	<tr height="40px" align="center">
		<td><b>2D</b></td>
		<td><b>2RF</b></td>
		<td><b>2OT</b></td>
		<td><b>2FR</b></td>
		<td><b>2TK</b></td>
		<td><b>4D</b></td>
		<td><b>4H</b></td>
		<td><b>4RH</b></td>
		<td><b>45H</b></td>		
		<td><b>4FR</b></td>
		<td><b>4OT</b></td>
		
		<td><b>2D</b></td>
		<td><b>2RF</b></td>
		<td><b>2OT</b></td>
		<td><b>2FR</b></td>
		<td><b>2TK</b></td>
		<td><b>4D</b></td>
		<td><b>4H</b></td>
		<td><b>4RH</b></td>
		<td><b>45H</b></td>		

		
		<td><b>4FR</b></td>
		<td><b>4OT</b></td>				
		
	
	</tr>
	
	

<?php
	
	$sqlQry="SELECT gkey,mlo,
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
			SUM(goods_and_ctr_wt_kg) AS weight,time_in

			 FROM (
			SELECT DISTINCT sparcsn4.inv_unit.gkey AS gkey,
			(SELECT disch_dt FROM ctmsmis.mis_disch_cont WHERE gkey=sparcsn4.inv_unit.gkey) AS time_in,
			r.id AS mlo,goods_and_ctr_wt_kg,
			RIGHT(sparcsn4.ref_equip_type.nominal_length,2) AS size,
			RIGHT(sparcsn4.ref_equip_type.nominal_height,2) AS height,
			(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' AND freight_kind IN ('FCL','LCL') AND sparcsn4.ref_equip_type.iso_group NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
			ELSE NULL END) AS D_20, 
			(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '40' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' AND freight_kind IN ('FCL','LCL') AND sparcsn4.ref_equip_type.iso_group NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
			ELSE NULL END) AS D_40, 
			(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '40' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='96' AND freight_kind IN ('FCL','LCL') AND sparcsn4.ref_equip_type.iso_group NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
			ELSE NULL END) AS H_40, 
			(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '45' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='96' AND freight_kind IN ('FCL','LCL') AND sparcsn4.ref_equip_type.iso_group NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
			ELSE NULL END) AS H_45,


			(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' AND freight_kind IN ('FCL','LCL') AND sparcsn4.ref_equip_type.iso_group IN ('RS','RT','RE')  THEN 1  
			ELSE NULL END) AS R_20, 
			(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '40' AND freight_kind IN ('FCL','LCL') AND sparcsn4.ref_equip_type.iso_group IN ('RS','RT','RE')  THEN 1  
			ELSE NULL END) AS RH_40,

			(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' AND freight_kind IN ('FCL','LCL') AND sparcsn4.ref_equip_type.iso_group IN ('UT')  THEN 1  
			ELSE NULL END) AS OT_20,
			(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '40' AND freight_kind IN ('FCL','LCL') AND sparcsn4.ref_equip_type.iso_group IN ('UT')  THEN 1  
			ELSE NULL END) AS OT_40,

			(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' AND freight_kind IN ('FCL','LCL') AND sparcsn4.ref_equip_type.iso_group IN ('PF','PC')  THEN 1  
			ELSE NULL END) AS FR_20,
			(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '40' AND freight_kind IN ('FCL','LCL') AND sparcsn4.ref_equip_type.iso_group IN ('PF','PC')  THEN 1  
			ELSE NULL END) AS FR_40,

			(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' AND freight_kind IN ('FCL','LCL') AND sparcsn4.ref_equip_type.iso_group IN ('TN','TD','TG')  THEN 1  
			ELSE NULL END) AS TK_20,

			(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' AND freight_kind ='MTY' AND sparcsn4.ref_equip_type.iso_group NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
			ELSE NULL END) AS MD_20, 
			(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '40' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' AND freight_kind ='MTY' AND sparcsn4.ref_equip_type.iso_group NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
			ELSE NULL END) AS MD_40, 
			(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '40' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='96' AND freight_kind ='MTY' AND sparcsn4.ref_equip_type.iso_group NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
			ELSE NULL END) AS MH_40, 
			(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '45' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='96' AND freight_kind ='MTY' AND sparcsn4.ref_equip_type.iso_group NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC')  THEN 1  
			ELSE NULL END) AS MH_45,


			(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' AND freight_kind ='MTY' AND sparcsn4.ref_equip_type.iso_group IN ('RS','RT','RE')  THEN 1  
			ELSE NULL END) AS MR_20, 
			(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '40' AND freight_kind ='MTY' AND sparcsn4.ref_equip_type.iso_group IN ('RS','RT','RE')  THEN 1  
			ELSE NULL END) AS MRH_40,

			(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' AND freight_kind ='MTY' AND sparcsn4.ref_equip_type.iso_group IN ('UT')  THEN 1  
			ELSE NULL END) AS MOT_20,
			(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '40' AND freight_kind ='MTY' AND sparcsn4.ref_equip_type.iso_group IN ('UT')  THEN 1  
			ELSE NULL END) AS MOT_40,

			(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' AND freight_kind ='MTY' AND sparcsn4.ref_equip_type.iso_group IN ('PF','PC')  THEN 1  
			ELSE NULL END) AS MFR_20,
			(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '40' AND freight_kind ='MTY' AND sparcsn4.ref_equip_type.iso_group IN ('PF','PC')  THEN 1  
			ELSE NULL END) AS MFR_40,

			(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' AND freight_kind ='MTY' AND sparcsn4.ref_equip_type.iso_group IN ('TN','TD','TG')  THEN 1  
			ELSE NULL END) AS MTK_20,
			(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) IN('20','40','45','42')  THEN 1 ELSE NULL END) AS grand_tot,
			(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2)=20  THEN 1 ELSE 2 END) AS tues    
			FROM sparcsn4.inv_unit
			INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey
			INNER JOIN sparcsn4.argo_carrier_visit ON argo_carrier_visit.gkey=sparcsn4.inv_unit.declrd_ib_cv
			INNER JOIN sparcsn4.argo_visit_details ON sparcsn4.argo_visit_details.gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
			INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_visit_details.gkey
			INNER JOIN sparcsn4.inv_goods ON inv_goods.gkey=inv_unit.goods
			INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
			INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
			INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
			INNER JOIN  ( sparcsn4.ref_bizunit_scoped r                                                 
			LEFT JOIN ( sparcsn4.ref_agent_representation X                                                 
			LEFT JOIN sparcsn4.ref_bizunit_scoped Y ON X.agent_gkey=Y.gkey )  ON r.gkey=X.bzu_gkey)  ON r.gkey = inv_unit.line_op 
			WHERE inv_unit.category='IMPRT' AND vvd_gkey='$vvdGkey' 
			 ) AS tmp ".$cond." GROUP BY mlo WITH ROLLUP";
	//echo $sqlQry;
	$query=mysql_query($sqlQry);
	$i=0;
	$j=0;
	
	$mlo="";
	while($row=mysql_fetch_object($query)){
	$i++;
	
		
	
?>
<tr align="center">
		<td><?php if($row->mlo) echo $row->mlo_name."".$row->mlo.""; else echo "<b>TOTAL</b>";?></td>
		<td><?php if($row->D_20) echo $row->D_20; else echo "&nbsp;";?></td>
		<td><?php if($row->R_20) echo $row->R_20; else echo "&nbsp;";?></td>
		<td><?php if($row->OT_20) echo $row->OT_20; else echo "&nbsp;";?></td>
		<td><?php if($row->FR_20) echo $row->FR_20; else echo "&nbsp;";?></td>
		<td><?php if($row->TK_20) echo $row->TK_20; else echo "&nbsp;";?></td>
		<td><?php if($row->D_40) echo $row->D_40; else echo "&nbsp;";?></td>
		<td><?php if($row->H_40) echo $row->H_40; else echo "&nbsp;";?></td>
		<td><?php if($row->RH_40) echo $row->RH_40; else echo "&nbsp;";?></td>
		<td><?php if($row->H_45) echo $row->H_45; else echo "&nbsp;";?></td>				
		<td><?php if($row->FR_40) echo $row->FR_40; else echo "&nbsp;";?></td>
		<td><?php if($row->OT_40) echo $row->OT_40; else echo "&nbsp;";?></td>
		
		<td><?php if($row->MD_20) echo $row->MD_20; else echo "&nbsp;";?></td>
		<td><?php if($row->MR_20) echo $row->MR_20; else echo "&nbsp;";?></td>				
		<td><?php if($row->MOT_20) echo $row->MOT_20; else echo "&nbsp;";?></td>
		<td><?php if($row->MFR_20) echo $row->MFR_20; else echo "&nbsp;";?></td>
		<td><?php if($row->MTK_20) echo $row->MTK_20; else echo "&nbsp;";?></td>
		<td><?php if($row->MD_40) echo $row->MD_40; else echo "&nbsp;";?></td>
		<td><?php if($row->MH_40) echo $row->MH_40; else echo "&nbsp;";?></td>
		<td><?php if($row->MRH_40) echo $row->MRH_40; else echo "&nbsp;";?></td>
		<td><?php if($row->MH_45) echo $row->MH_45; else echo "&nbsp;";?></td>
		<td><?php if($row->MFR_40) echo $row->MFR_40; else echo "&nbsp;";?></td>
		<td><?php if($row->MOT_40) echo $row->MOT_40; else echo "&nbsp;";?></td>
		
		<td align="center"><?php if($row->grand_tot) echo $row->grand_tot; else echo "&nbsp;";?></td>
		<td align="center"><?php if($row->tues) echo $row->tues; else echo "&nbsp;";?></td>
		<td align="center"><?php if($row->weight) echo $row->weight; else echo "&nbsp;";?></td>
	</tr>

<?php } ?>

</table>
<?php 
mysql_close($con);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
