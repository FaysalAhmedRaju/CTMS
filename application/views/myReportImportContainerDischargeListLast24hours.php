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
$ddl_imp_rot_no=$_REQUEST['ddl_imp_rot_no']; 

	include("dbConection.php");
	
	$sql=mysql_query("select vvd_gkey from sparcsn4.vsl_vessel_visit_details where ib_vyg='$ddl_imp_rot_no'");
	$row=mysql_fetch_object($sql);
	$vvdGkey=$row->vvd_gkey;
	
	$sql="call ctmsmis.update_containers_by_vvd_gkey($vvdGkey)";
	$res=mysql_query($sql);
	//echo$vvdGkey;
	$sql1=mysql_query("SELECT vsl_vessels.name AS vsl_name,sparcsn4.vsl_vessel_visit_details.ob_vyg AS ex_Roation,
IFNULL(sparcsn4.vsl_vessel_visit_details.flex_string02,IFNULL(sparcsn4.vsl_vessel_visit_details.flex_string03,'')) AS berth_op,
IFNULL(sparcsn4.argo_quay.id,'') AS berth,
ref_bizunit_scoped.id AS local_agent,
DATE(sparcsn4.vsl_vessel_visit_details.published_eta) AS published_eta,


CONCAT(HOUR(sparcsn4.vsl_vessel_visit_details.start_work),'',MINUTE(sparcsn4.vsl_vessel_visit_details.start_work)) AS discharge_start_time,
DATE(sparcsn4.vsl_vessel_visit_details.start_work) AS discharge_start,
CONCAT(HOUR(sparcsn4.vsl_vessel_visit_details.end_work),'',MINUTE(sparcsn4.vsl_vessel_visit_details.end_work)) AS discharge_completed_time,
DATE(sparcsn4.vsl_vessel_visit_details.end_work) AS discharge_completed,
(SELECT ata FROM sparcsn4.vsl_vessel_berthings 
WHERE vsl_vessel_berthings.vvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey ORDER BY vsl_vessel_berthings.ata DESC LIMIT 1)AS ata,
(SELECT atd FROM sparcsn4.vsl_vessel_berthings 
WHERE vsl_vessel_berthings.vvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey ORDER BY vsl_vessel_berthings.atd DESC LIMIT 1)AS atd
FROM vsl_vessel_visit_details
INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
INNER JOIN sparcsn4.vsl_vessel_berthings ON sparcsn4.vsl_vessel_berthings.vvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
INNER JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
INNER JOIN sparcsn4.ref_bizunit_scoped ON ref_bizunit_scoped.gkey=vsl_vessels.owner_gkey
INNER JOIN sparcsn4.argo_quay ON sparcsn4.argo_quay.gkey=sparcsn4.vsl_vessel_berthings.quay
WHERE vsl_vessel_visit_details.vvd_gkey='$vvdGkey'");
	$row1=mysql_fetch_object($sql1);
	
	?>
<html>
<title>Import Container Discharge List</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" height="100px">
		<td>
			<table border=0 width="100%">
				<tr align="center">
					<!--td colspan="13"><font size="4"><b>CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td-->
					<td colspan="13" align="center"><img width="250px" height="80px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
				</tr>
			
				<tr align="center">
					<td colspan="12"><font size="4"><b>24 HRS.WORK DONE REPORT CLOSSING AT 0800 HRS.OF <?php  Echo $fromdate;?></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b></b></font></td>
				</tr>
			</table>
			<table border=0 width="40%">
				<tr>
					<td><font size="4"><b>DATE</b></font></td>
					<td> - </td>
					<td><font size="4"><b><font size="4"><?php  Echo $fromdate;?></b></font></td>
				</tr>
				<tr>
					<td><font size="4"><b>VESSEL NAME</b></font></td>
					<td> - </td>
					<td><font size="4"><b><font size="4"><?php  Echo $row1->vsl_name;?></b></font></td>
				</tr>
				<tr>
					<td><font size="4"><b>VOYAGE NO</b></font></td>
					<td> - </td>
					<td><font size="4"><b><?php  Echo $voysNo;?></b></font></td>					
				</tr>
				<tr>
					<td><font size="4"><b>IMP.ROT</b></font></td>					
					<td> - </td>
					<td><font size="4"><b><?php  Echo $ddl_imp_rot_no;?></b></font></td>					
				</tr>
				<tr>
					<td><font size="4"><b> EXP.ROT</b></font></td>				
					<td> - </td>
					<td><font size="4"><b><?php  Echo  $row1->ex_Roation;?></b></font></td>					
				</tr>
				<tr>
					<td><font size="4"><b>BERTH NO</b></font></td>					
					<td> - </td>
					<td><font size="4"><b><?php  Echo  $row1->berth;?></b></font></td>
					
				</tr>
				<tr>
					<td><font size="4"><b>BERTH OPERATOR</b></font>
					<td> - </td>
					<td><font size="4"><b><?php  Echo  $row1->berth_op;?></b></font></td>
				</tr>
				<tr>
					<td><font size="4"><b>SHIPPING AGENT</b></font></td>
					<td> - </td>
					<td><font size="4"><b><?php  Echo  $row1->local_agent;?></b></font></td>					
				</tr>
				<tr>
					<td><font size="4"><b>ARRIVED ON</b></font></td>
					<td> - </td>
					<td><font size="4"><b><?php  Echo  $row1->ata;?></b></font></td>					
				</tr>
				<tr>
					<td><font size="4"><b>EXPECTED TIME OF ARRIVED</b></font></td>
					<td> - </td>
					<td><font size="4"><b><?php  Echo $row1->published_eta;?></b></font></td>					
				</tr>
				<tr></tr>
				<tr></tr>
			</table>
		
		</td>
		
	</tr>
	
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr>
	</table>
	




<?php

$sqlSummery3=mysql_query("
SELECT
IFNULL(SUM(discharge_done_LD_20),0) AS discharge_done_LD_20,
IFNULL(SUM(discharge_done_LD_40),0) AS discharge_done_LD_40,
IFNULL(SUM(discharge_done_MT_20),0) AS discharge_done_MT_20,
IFNULL(SUM(discharge_done_MT_40),0) AS discharge_done_MT_40,
IFNULL(SUM(dischage_LD_tues),0) AS dischage_LD_tues,
IFNULL(SUM(discharge_MT_tues),0) AS discharge_MT_tues
FROM 
(
SELECT 
(CASE WHEN size = 20
AND fcy_time_in >CONCAT(DATE_ADD('$fromdate', INTERVAL -1 DAY),' 08:00:00')
AND fcy_time_in <CONCAT('$fromdate',' 08:00:01') 
AND freight_kind IN ('FCL','LCL')  THEN 1  
ELSE NULL END) AS discharge_done_LD_20, 
(CASE WHEN size !=20
AND fcy_time_in >CONCAT(DATE_ADD('$fromdate', INTERVAL -1 DAY),' 08:00:00')
AND fcy_time_in <CONCAT('$fromdate',' 08:00:01') 
AND freight_kind IN ('FCL','LCL')  THEN 1  
ELSE NULL END) AS discharge_done_LD_40,
(CASE WHEN size = 20
AND fcy_time_in >CONCAT(DATE_ADD('$fromdate', INTERVAL -1 DAY),' 08:00:00')
AND fcy_time_in <CONCAT('$fromdate',' 08:00:01') 
AND freight_kind ='MTY'  THEN 1  
ELSE NULL END) AS discharge_done_MT_20, 
(CASE WHEN size !=20
AND fcy_time_in >CONCAT(DATE_ADD('$fromdate', INTERVAL -1 DAY),' 08:00:00')
AND fcy_time_in <CONCAT('$fromdate',' 08:00:01') 
AND freight_kind ='MTY'  THEN 1  
ELSE NULL END) AS discharge_done_MT_40, 
(CASE WHEN size=20 
AND fcy_time_in >CONCAT(DATE_ADD('$fromdate', INTERVAL -1 DAY),' 08:00:00')
AND fcy_time_in <CONCAT('$fromdate',' 08:00:01') 
AND freight_kind IN ('FCL','LCL') THEN 1 
ELSE (CASE WHEN size>20 
AND fcy_time_in >CONCAT(DATE_ADD('$fromdate', INTERVAL -1 DAY),' 08:00:00')
AND fcy_time_in <CONCAT('$fromdate',' 08:00:01') 
AND freight_kind IN ('FCL','LCL') THEN 2 ELSE NULL END) END) AS dischage_LD_tues, 
(CASE WHEN size=20 
AND fcy_time_in >CONCAT(DATE_ADD('$fromdate', INTERVAL -1 DAY),' 08:00:00')
AND fcy_time_in <CONCAT('$fromdate',' 08:00:01') 
AND freight_kind='MTY' THEN 1 
ELSE (CASE WHEN size>20 
AND fcy_time_in >CONCAT(DATE_ADD('$fromdate', INTERVAL -1 DAY),' 08:00:00')
AND fcy_time_in <CONCAT('$fromdate',' 08:00:01')
AND freight_kind='MTY' THEN 2 ELSE NULL END) END) AS discharge_MT_tues
FROM
(
SELECT size,IFNULL((SELECT disch_dt FROM ctmsmis.mis_disch_cont WHERE ctmsmis.mis_disch_cont.gkey=ctmsmis.mis_inv_unit.gkey),fcy_time_in) AS fcy_time_in,freight_kind
FROM ctmsmis.mis_inv_unit 
WHERE  mis_inv_unit.vvd_gkey='$vvdGkey' AND category='IMPRT'
) AS tmp WHERE fcy_time_in IS NOT NULL
) AS final");

$rowSummery3=mysql_fetch_object($sqlSummery3);

$qq="select gkey,
IFNULL(SUM(onboard_LD_20),0) AS onboard_LD_20,
IFNULL(SUM(onboard_LD_40),0) AS onboard_LD_40,
IFNULL(SUM(onboard_MT_20),0) AS onboard_MT_20,
IFNULL(SUM(onboard_MT_40),0) AS onboard_MT_40,
IFNULL(SUM(onboard_LD_tues),0) AS onboard_LD_tues,
IFNULL(SUM(onboard_MT_tues),0) AS onboard_MT_tues

 from (
select distinct ctmsmis.mis_inv_unit.gkey as gkey,IFNULL((SELECT disch_dt FROM ctmsmis.mis_disch_cont 
WHERE ctmsmis.mis_disch_cont.gkey=ctmsmis.mis_inv_unit.gkey),fcy_time_in) AS fcy_time_in,
(CASE WHEN size = '20' AND freight_kind in ('FCL','LCL')  THEN 1  
ELSE NULL END) AS onboard_LD_20, 
(CASE WHEN size > '20' AND freight_kind in ('FCL','LCL')  THEN 1  
ELSE NULL END) AS onboard_LD_40,
(CASE WHEN size = '20' AND freight_kind ='MTY'  THEN 1  
ELSE NULL END) AS onboard_MT_20, 
(CASE WHEN size > '20' AND freight_kind ='MTY'  THEN 1  
ELSE NULL END) AS onboard_MT_40, 
(CASE WHEN size=20 AND freight_kind in ('FCL','LCL') THEN 1 
ELSE (CASE WHEN size>20 AND freight_kind in ('FCL','LCL') THEN 2 ELSE NULL END) END) AS onboard_LD_tues, 
(CASE WHEN size=20 AND freight_kind='MTY' THEN 1 
ELSE (CASE WHEN size>20 AND freight_kind='MTY' THEN 2 ELSE NULL END) END) AS onboard_MT_tues

FROM ctmsmis.mis_inv_unit
where  mis_inv_unit.vvd_gkey='$vvdGkey' and category='IMPRT' and fcy_transit_state='S20_INBOUND' AND fcy_time_in IS NULL
) as tmp WHERE fcy_time_in IS NULL";

//echo $qq;
$sqlSummery=mysql_query($qq);
$rowSummery=mysql_fetch_object($sqlSummery);


$sqlSummery2=mysql_query("select gkey,
IFNULL(SUM(balance_LD_20),0) AS balance_LD_20,
IFNULL(SUM(balance_LD_40),0) AS balance_LD_40,
IFNULL(SUM(balance_MT_20),0) AS balance_MT_20,
IFNULL(SUM(balance_MT_40),0) AS balance_MT_40,
IFNULL(SUM(balance_LD_tues),0) AS balance_LD_tues,
IFNULL(SUM(balance_MT_tues),0) AS balance_MT_tues

 from (
select distinct ctmsmis.mis_inv_unit.gkey as gkey,
(CASE WHEN size = '20' AND freight_kind in ('FCL','LCL')  THEN 1  
ELSE NULL END) AS balance_LD_20, 
(CASE WHEN size > '20' AND freight_kind in ('FCL','LCL')  THEN 1  
ELSE NULL END) AS balance_LD_40,
(CASE WHEN size = '20' AND freight_kind ='MTY'  THEN 1  
ELSE NULL END) AS balance_MT_20, 
(CASE WHEN size > '20' AND freight_kind ='MTY'  THEN 1  
ELSE NULL END) AS balance_MT_40, 
(CASE WHEN size=20 AND freight_kind in ('FCL','LCL') THEN 1 
ELSE (CASE WHEN size>20 AND freight_kind in ('FCL','LCL') THEN 2 ELSE NULL END) END) AS balance_LD_tues, 
(CASE WHEN size=20 AND freight_kind='MTY' THEN 1 
ELSE (CASE WHEN size>20 AND freight_kind='MTY' THEN 2 ELSE NULL END) END) AS balance_MT_tues

FROM ctmsmis.mis_inv_unit 
where  mis_inv_unit.vvd_gkey='$vvdGkey' and category='IMPRT' and fcy_transit_state not in ('S20_INBOUND')
) as tmp ");

$rowSummery2=mysql_fetch_object($sqlSummery2);
?>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr><td colspan="12" align="center"><font size="4"><b><u>IMPORT</u></b></font></td></tr>

</table>
<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<tr>
		<td colspan="6" align="center">DISCHARGED</td>
		<td colspan="6" align="center">TOTAL DISCHARGED</td>
		<td colspan="6" align="center">BALANCE ON BOARD</td>
	</tr>
	<tr>
		<td colspan="2" align="center">LADEN</td>
		<td colspan="2" align="center">EMPTY</td>
		<td colspan="2" align="center">TUES</td>
		<td colspan="2" align="center">LADEN</td>
		<td colspan="2" align="center">EMPTY</td>
		<td colspan="2" align="center">TUES</td>
		<td colspan="2" align="center">LADEN</td>
		<td colspan="2" align="center">EMPTY</td>
		<td colspan="2" align="center">TUES</td>
		
	</tr>
	<tr>
		<td align="center">20</td>
		<td align="center">40</td>
		<td align="center">20</td>
		<td align="center">40</td>
		<td align="center">LD</td>
		<td align="center">MT</td>
		<td align="center">20</td>
		<td align="center">40</td>
		<td align="center">20</td>
		<td align="center">40</td>
		<td align="center">LD</td>
		<td align="center">MT</td>
		<td align="center">20</td>
		<td align="center">40</td>
		<td align="center">20</td>
		<td align="center">40</td>
		<td align="center">LD</td>
		<td align="center">MT</td>
	</tr>
	<tr>
		
	
		<td align="center"><a href="<?php echo site_url('report/getLast24HourDischargeImportContainerList/20/'.$fromdate.'/'.$vvdGkey.'/discharge_done_LD_20') ?>" target="_BLANK"><?php if($rowSummery3->discharge_done_LD_20) echo $rowSummery3->discharge_done_LD_20; else echo ""; ?></a></td>
		<td align="center"><a href="<?php echo site_url('report/getLast24HourDischargeImportContainerList/20/'.$fromdate.'/'.$vvdGkey.'/discharge_done_LD_40') ?>" target="_BLANK"><?php if($rowSummery3->discharge_done_LD_40) echo $rowSummery3->discharge_done_LD_40; else echo ""; ?></a></td>
		<td align="center"><a href="<?php echo site_url('report/getLast24HourDischargeImportContainerList/20/'.$fromdate.'/'.$vvdGkey.'/discharge_done_MT_20') ?>" target="_BLANK"><?php if($rowSummery3->discharge_done_MT_20) echo $rowSummery3->discharge_done_MT_20; else echo ""; ?></a></td>
		<td align="center"><a href="<?php echo site_url('report/getLast24HourDischargeImportContainerList/20/'.$fromdate.'/'.$vvdGkey.'/discharge_done_MT_40') ?>" target="_BLANK"><?php if($rowSummery3->discharge_done_MT_40) echo $rowSummery3->discharge_done_MT_40; else echo ""; ?></a></td>
		<td align="center"><?php if($rowSummery3->dischage_LD_tues) echo $rowSummery3->dischage_LD_tues; else echo ""; ?></td>
		<td align="center"><?php if($rowSummery3->discharge_MT_tues) echo $rowSummery3->discharge_MT_tues; else echo ""; ?></td>
		
		<td align="center"><a href="<?php echo site_url('report/getLast24HourDischargeImportContainerList/20/'.$fromdate.'/'.$vvdGkey.'/balance_LD_20') ?>" target="_BLANK"><?php if($rowSummery2->balance_LD_20) echo $rowSummery2->balance_LD_20; else echo ""; ?></a></td>
		<td align="center"><a href="<?php echo site_url('report/getLast24HourDischargeImportContainerList/20/'.$fromdate.'/'.$vvdGkey.'/balance_LD_40') ?>" target="_BLANK"><?php if($rowSummery2->balance_LD_40) echo $rowSummery2->balance_LD_40; else echo ""; ?></a></td>
		<td align="center"><a href="<?php echo site_url('report/getLast24HourDischargeImportContainerList/20/'.$fromdate.'/'.$vvdGkey.'/balance_MT_20') ?>" target="_BLANK"><?php if($rowSummery2->balance_MT_20) echo $rowSummery2->balance_MT_20; else echo ""; ?></a></td>
		<td align="center"><a href="<?php echo site_url('report/getLast24HourDischargeImportContainerList/20/'.$fromdate.'/'.$vvdGkey.'/balance_MT_40') ?>" target="_BLANK"><?php if($rowSummery2->balance_MT_40) echo $rowSummery2->balance_MT_40; else echo ""; ?></a></td>
		<td align="center"><?php if($rowSummery2->balance_LD_tues) echo $rowSummery2->balance_LD_tues; else echo ""; ?></td>
		<td align="center"><?php if($rowSummery2->balance_MT_tues) echo $rowSummery2->balance_MT_tues; else echo ""; ?></td>
		
		<td align="center"><a href="<?php echo site_url('report/getLast24HourDischargeImportContainerList/20/'.$fromdate.'/'.$vvdGkey.'/onboard_LD_20') ?>" target="_BLANK"><?php if($rowSummery->onboard_LD_20) echo $rowSummery->onboard_LD_20; else echo ""; ?></a></td>
		<td align="center"><a href="<?php echo site_url('report/getLast24HourDischargeImportContainerList/20/'.$fromdate.'/'.$vvdGkey.'/onboard_LD_40') ?>" target="_BLANK"><?php if($rowSummery->onboard_LD_40) echo $rowSummery->onboard_LD_40; else echo ""; ?></a></td>
		<td align="center"><a href="<?php echo site_url('report/getLast24HourDischargeImportContainerList/20/'.$fromdate.'/'.$vvdGkey.'/onboard_MT_20') ?>" target="_BLANK"><?php if($rowSummery->onboard_MT_20) echo $rowSummery->onboard_MT_20; else echo ""; ?></a></td>
		<td align="center"><a href="<?php echo site_url('report/getLast24HourDischargeImportContainerList/20/'.$fromdate.'/'.$vvdGkey.'/onboard_MT_40') ?>" target="_BLANK"><?php if($rowSummery->onboard_MT_40) echo $rowSummery->onboard_MT_40; else echo ""; ?></a></td>
		<td align="center"><?php if($rowSummery->onboard_LD_tues) echo $rowSummery->onboard_LD_tues; else echo ""; ?></td>
		<td align="center"><?php if($rowSummery->onboard_MT_tues) echo $rowSummery->onboard_MT_tues; else echo ""; ?></td>

		
	</tr>
</table>

<!--EXPORT-->

<?php

$sqlSummery4=mysql_query("

SELECT gkey,
IFNULL(SUM(discharge_done_LD_20),0) AS discharge_done_LD_20,
IFNULL(SUM(discharge_done_LD_40),0) AS discharge_done_LD_40,
IFNULL(SUM(discharge_done_MT_20),0) AS discharge_done_MT_20,
IFNULL(SUM(discharge_done_MT_40),0) AS discharge_done_MT_40,
IFNULL(SUM(dischage_LD_tues),0) AS dischage_LD_tues,
IFNULL(SUM(discharge_MT_tues),0) AS discharge_MT_tues

 FROM (
SELECT DISTINCT ctmsmis.mis_inv_unit.gkey AS gkey,
(CASE WHEN size = 20
AND fcy_time_in >CONCAT(DATE_ADD('$fromdate', INTERVAL -1 DAY),' 08:00:00')
AND fcy_time_in <CONCAT('$fromdate',' 08:00:01') 
AND freight_kind IN ('FCL','LCL')  THEN 1  
ELSE NULL END) AS discharge_done_LD_20, 
(CASE WHEN size !=20
AND fcy_time_in >CONCAT(DATE_ADD('$fromdate', INTERVAL -1 DAY),' 08:00:00')
AND fcy_time_in <CONCAT('$fromdate',' 08:00:01') 
AND freight_kind IN ('FCL','LCL')  THEN 1  
ELSE NULL END) AS discharge_done_LD_40,
(CASE WHEN size = 20
AND fcy_time_in >CONCAT(DATE_ADD('$fromdate', INTERVAL -1 DAY),' 08:00:00')
AND fcy_time_in <CONCAT('$fromdate',' 08:00:01') 
AND freight_kind ='MTY'  THEN 1  
ELSE NULL END) AS discharge_done_MT_20, 
(CASE WHEN size !=20
AND fcy_time_in >CONCAT(DATE_ADD('$fromdate', INTERVAL -1 DAY),' 08:00:00')
AND fcy_time_in <CONCAT('$fromdate',' 08:00:01') 
AND freight_kind ='MTY'  THEN 1  
ELSE NULL END) AS discharge_done_MT_40, 
(CASE WHEN size=20 
AND fcy_time_in >CONCAT(DATE_ADD('$fromdate', INTERVAL -1 DAY),' 08:00:00')
AND fcy_time_in <CONCAT('$fromdate',' 08:00:01') 
AND freight_kind IN ('FCL','LCL') THEN 1 
ELSE (CASE WHEN size>20 
AND fcy_time_in >CONCAT(DATE_ADD('$fromdate', INTERVAL -1 DAY),' 08:00:00')
AND fcy_time_in <CONCAT('$fromdate',' 08:00:01') 
AND freight_kind IN ('FCL','LCL') THEN 2 ELSE NULL END) END) AS dischage_LD_tues, 
(CASE WHEN size=20 
AND fcy_time_in >CONCAT(DATE_ADD('$fromdate', INTERVAL -1 DAY),' 08:00:00')
AND fcy_time_in <CONCAT('$fromdate',' 08:00:01') 
AND freight_kind='MTY' THEN 1 
ELSE (CASE WHEN size>20 
AND fcy_time_in >CONCAT(DATE_ADD('$fromdate', INTERVAL -1 DAY),' 08:00:00')
AND fcy_time_in <CONCAT('$fromdate',' 08:00:01')
AND freight_kind='MTY' THEN 2 ELSE NULL END) END) AS discharge_MT_tues

FROM ctmsmis.mis_inv_unit 
WHERE  mis_inv_unit.vvd_gkey='$vvdGkey' AND category='EXPRT' AND fcy_time_in IS NOT NULL

) AS tmp");

$rowSummery4=mysql_fetch_object($sqlSummery4);

$sqlSummery5=mysql_query("select gkey,
IFNULL(SUM(balance_LD_20),0) AS balance_LD_20,
IFNULL(SUM(balance_LD_40),0) AS balance_LD_40,
IFNULL(SUM(balance_MT_20),0) AS balance_MT_20,
IFNULL(SUM(balance_MT_40),0) AS balance_MT_40,
IFNULL(SUM(balance_LD_tues),0) AS balance_LD_tues,
IFNULL(SUM(balance_MT_tues),0) AS balance_MT_tues

 from (
select distinct ctmsmis.mis_inv_unit.gkey as gkey,
(CASE WHEN size = '20' AND freight_kind in ('FCL','LCL')  THEN 1  
ELSE NULL END) AS balance_LD_20, 
(CASE WHEN size > '20' AND freight_kind in ('FCL','LCL')  THEN 1  
ELSE NULL END) AS balance_LD_40,
(CASE WHEN size = '20' AND freight_kind ='MTY'  THEN 1  
ELSE NULL END) AS balance_MT_20, 
(CASE WHEN size > '20' AND freight_kind ='MTY'  THEN 1  
ELSE NULL END) AS balance_MT_40, 
(CASE WHEN size=20 AND freight_kind in ('FCL','LCL') THEN 1 
ELSE (CASE WHEN size>20 AND freight_kind in ('FCL','LCL') THEN 2 ELSE NULL END) END) AS balance_LD_tues, 
(CASE WHEN size=20 AND freight_kind='MTY' THEN 1 
ELSE (CASE WHEN size>20 AND freight_kind='MTY' THEN 2 ELSE NULL END) END) AS balance_MT_tues

FROM ctmsmis.mis_inv_unit 
where  mis_inv_unit.vvd_gkey='$vvdGkey' and category='EXPRT' and fcy_transit_state not in ('S20_INBOUND')
) as tmp");

$rowSummery5=mysql_fetch_object($sqlSummery5);

$sqlSummery6=mysql_query("select gkey,
IFNULL(SUM(onboard_LD_20),0) AS onboard_LD_20,
IFNULL(SUM(onboard_LD_40),0) AS onboard_LD_40,
IFNULL(SUM(onboard_MT_20),0) AS onboard_MT_20,
IFNULL(SUM(onboard_MT_40),0) AS onboard_MT_40,
IFNULL(SUM(onboard_LD_tues),0) AS onboard_LD_tues,
IFNULL(SUM(onboard_MT_tues),0) AS onboard_MT_tues

 from (
select distinct ctmsmis.mis_inv_unit.gkey as gkey,
(CASE WHEN size = '20' AND freight_kind in ('FCL','LCL')  THEN 1  
ELSE NULL END) AS onboard_LD_20, 
(CASE WHEN size > '20' AND freight_kind in ('FCL','LCL')  THEN 1  
ELSE NULL END) AS onboard_LD_40,
(CASE WHEN size = '20' AND freight_kind ='MTY'  THEN 1  
ELSE NULL END) AS onboard_MT_20, 
(CASE WHEN size > '20' AND freight_kind ='MTY'  THEN 1  
ELSE NULL END) AS onboard_MT_40, 
(CASE WHEN size=20 AND freight_kind in ('FCL','LCL') THEN 1 
ELSE (CASE WHEN size>20 AND freight_kind in ('FCL','LCL') THEN 2 ELSE NULL END) END) AS onboard_LD_tues, 
(CASE WHEN size=20 AND freight_kind='MTY' THEN 1 
ELSE (CASE WHEN size>20 AND freight_kind='MTY' THEN 2 ELSE NULL END) END) AS onboard_MT_tues

FROM ctmsmis.mis_inv_unit
where  mis_inv_unit.vvd_gkey='$vvdGkey'and category='EXPRT' and fcy_transit_state='S20_INBOUND'
) as tmp");
$rowSummery6=mysql_fetch_object($sqlSummery6);
?>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr><td colspan="12" align="center"><font size="4"><b><u></u></b></font></td></tr>
<tr><td colspan="12" align="center"><font size="4"><b></b></font></td></tr>
</table>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr><td colspan="12" align="center"><font size="4"><b><u>EXPORT</u></b></font></td></tr>

</table>
<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<tr>
		<td colspan="6" align="center">SHIPMENT</td>
		<td colspan="6" align="center">TOTAL ON BOARD</td>
		<td colspan="6" align="center">BALANCE TO SHIPMENT</td>
	</tr>
	<tr>
		<td colspan="2" align="center">LADEN</td>
		<td colspan="2" align="center">EMPTY</td>
		<td colspan="2" align="center">TUES</td>
		<td colspan="2" align="center">LADEN</td>
		<td colspan="2" align="center">EMPTY</td>
		<td colspan="2" align="center">TUES</td>
		<td colspan="2" align="center">LADEN</td>
		<td colspan="2" align="center">EMPTY</td>
		<td colspan="2" align="center">TUES</td>
		
	</tr>
	<tr>
		<td align="center">20</td>
		<td align="center">40</td>
		<td align="center">20</td>
		<td align="center">40</td>
		<td align="center">LD</td>
		<td align="center">MT</td>
		<td align="center">20</td>
		<td align="center">40</td>
		<td align="center">20</td>
		<td align="center">40</td>
		<td align="center">LD</td>
		<td align="center">MT</td>
		<td align="center">20</td>
		<td align="center">40</td>
		<td align="center">20</td>
		<td align="center">40</td>
		<td align="center">LD</td>
		<td align="center">MT</td>
	</tr>
	<tr>
		
	
		<td align="center"><a href="<?php echo site_url('report/getLast24HourDischargeExportContainerList/20/'.$fromdate.'/'.$vvdGkey.'/discharge_done_LD_20') ?>" target="_BLANK"><?php if($rowSummery4->discharge_done_LD_20) echo $rowSummery4->discharge_done_LD_20; else echo ""; ?></a></td>
		<td align="center"><a href="<?php echo site_url('report/getLast24HourDischargeExportContainerList/20/'.$fromdate.'/'.$vvdGkey.'/discharge_done_LD_40') ?>" target="_BLANK"><?php if($rowSummery4->discharge_done_LD_40) echo $rowSummery4->discharge_done_LD_40; else echo ""; ?></a></td>
		<td align="center"><a href="<?php echo site_url('report/getLast24HourDischargeExportContainerList/20/'.$fromdate.'/'.$vvdGkey.'/discharge_done_MT_20') ?>" target="_BLANK"><?php if($rowSummery4->discharge_done_MT_20) echo $rowSummery4->discharge_done_MT_20; else echo ""; ?></a></td>
		<td align="center"><a href="<?php echo site_url('report/getLast24HourDischargeExportContainerList/20/'.$fromdate.'/'.$vvdGkey.'/discharge_done_MT_40') ?>" target="_BLANK"><?php if($rowSummery4->discharge_done_MT_40) echo $rowSummery4->discharge_done_MT_40; else echo ""; ?></a></td>
		<td align="center"><?php if($rowSummery4->dischage_LD_tues) echo $rowSummery4->dischage_LD_tues; else echo ""; ?></td>
		<td align="center"><?php if($rowSummery4->discharge_MT_tues) echo $rowSummery4->discharge_MT_tues; else echo ""; ?></td>
		
		<td align="center"><a href="<?php echo site_url('report/getLast24HourDischargeExportContainerList/20/'.$fromdate.'/'.$vvdGkey.'/balance_LD_20') ?>" target="_BLANK"><?php if($rowSummery5->balance_LD_20) echo $rowSummery5->balance_LD_20; else echo ""; ?></a></td>
		<td align="center"><a href="<?php echo site_url('report/getLast24HourDischargeExportContainerList/20/'.$fromdate.'/'.$vvdGkey.'/balance_LD_40') ?>" target="_BLANK"><?php if($rowSummery5->balance_LD_40) echo $rowSummery5->balance_LD_40; else echo ""; ?></a></td>
		<td align="center"><a href="<?php echo site_url('report/getLast24HourDischargeExportContainerList/20/'.$fromdate.'/'.$vvdGkey.'/balance_MT_20') ?>" target="_BLANK"><?php if($rowSummery5->balance_MT_20) echo $rowSummery5->balance_MT_20; else echo ""; ?></a></td>
		<td align="center"><a href="<?php echo site_url('report/getLast24HourDischargeExportContainerList/20/'.$fromdate.'/'.$vvdGkey.'/balance_MT_40') ?>" target="_BLANK"><?php if($rowSummery5->balance_MT_40) echo $rowSummery5->balance_MT_40; else echo ""; ?></a></td>
		<td align="center"><?php if($rowSummery5->balance_LD_tues) echo $rowSummery5->balance_LD_tues; else echo ""; ?></td>
		<td align="center"><?php if($rowSummery5->balance_MT_tues) echo $rowSummery5->balance_MT_tues; else echo ""; ?></td>
		
		<td align="center"><a href="<?php echo site_url('report/getLast24HourDischargeExportContainerList/20/'.$fromdate.'/'.$vvdGkey.'/onboard_LD_20') ?>" target="_BLANK"><?php if($rowSummery6->onboard_LD_20) echo $rowSummery6->onboard_LD_20; else echo ""; ?></a></td>
		<td align="center"><a href="<?php echo site_url('report/getLast24HourDischargeExportContainerList/20/'.$fromdate.'/'.$vvdGkey.'/onboard_LD_40') ?>" target="_BLANK"><?php if($rowSummery6->onboard_LD_40) echo $rowSummery6->onboard_LD_40; else echo ""; ?></a></td>
		<td align="center"><a href="<?php echo site_url('report/getLast24HourDischargeExportContainerList/20/'.$fromdate.'/'.$vvdGkey.'/onboard_MT_20') ?>" target="_BLANK"><?php if($rowSummery6->onboard_MT_20) echo $rowSummery6->onboard_MT_20; else echo ""; ?></a></td>
		<td align="center"><a href="<?php echo site_url('report/getLast24HourDischargeExportContainerList/20/'.$fromdate.'/'.$vvdGkey.'/onboard_MT_40') ?>" target="_BLANK"><?php if($rowSummery6->onboard_MT_40) echo $rowSummery6->onboard_MT_40; else echo ""; ?></a></td>
		<td align="center"><?php if($rowSummery6->onboard_LD_tues) echo $rowSummery6->onboard_LD_tues; else echo ""; ?></td>
		<td align="center"><?php if($rowSummery6->onboard_MT_tues) echo $rowSummery6->onboard_MT_tues; else echo ""; ?></td>

		
	</tr>
</table>
<!--last-->
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr><td colspan="12" align="center"><font size="4"><b><u></u></b></font></td></tr>
<tr><td colspan="12" align="center"><font size="4"><b></b></font></td></tr>
</table>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr><td colspan="12" align="center"><font size="4"><b><u>PROGRAM</u></b></font></td></tr>

</table>
<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<tr>
		<td colspan="6" align="center">IMPORT-01</td>
		<td colspan="6" align="center">EXPORT-01</td>
	</tr>
</table>
<table border=0 width="100%">
				
				
				<tr align="center">
					<td colspan="12"><font size="4"></font></td>
				
				<tr align="center">
					<td colspan="12"><font size="4"><b></b></font></td>
				</tr>
				
				<tr align="center">
					<td colspan="12"><font size="4"></font></td>
				
				<tr align="center">
					<td colspan="12"><font size="4"><b></b></font></td>
				</tr>
				<tr  align="left">
				<td align="left"><font size="4"><b>BERTHED - </b></font>
				<font size="4"><b><?php  Echo $row1->ata;?></b></font>
				</td>
				</tr>
				<tr>
				<td  align="left"><font size="4"><b> COMMENCE DISCHARGE -</b></font>
				<font size="4"><b><?php  Echo $row1->discharge_start_time;?> HRS<?php  Echo $row1->discharge_start;?></b></font>
				</td>
				</tr>
				
				<tr>
				<td align="left">
				<font size="4"><b>COMPLETED DISCHARGE -</b></font>
				<font size="4"><b><?php  Echo $row1->discharge_completed_time;?> HRS<?php  Echo $row1->discharge_completed;?></b></font>
				</td>
				</tr>
				<tr>
				<td align="left">
				<font size="4"><b>COMMENCE LOAD -</b></font>
				
				</td>
				</tr>
				<tr>
				<td align="left">
				<font size="4"><b>COMPLETED LOAD -</b></font>
				
				</td>
				</tr>
				<tr>
				<td align="left">
				<font size="4"><b>SAILED -</b></font>
				<font size="4"><b><?php  Echo $row1->atd;?></b></font>
				</td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b></b></font></td>
				</tr>
				
				<tr align="center">
					<td colspan="12"><font size="4"></font></td>
				</tr>
				<tr align="right">
					<td colspan="12"><font size="4"><b>Prepared by -</b></font></td>
				</tr>
				
			</table>
<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
