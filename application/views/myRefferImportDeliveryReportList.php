<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>Reefer Report</TITLE>
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
	//mysql_select_db("sparcsn4")or die("cannot select DB");
	include("dbConection.php");
	//echo $todate;

	
		//$col = "date(inv_unit_fcy_visit.flex_date04) BETWEEN '$fromdate' AND '$todate'";		
		//$head = "Delivery Date Wise Import Reefer Container List";
	
	
	?>
<html>
<title>Import Reefer Container Discharge List</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				
				<tr align="center">
					<td colspan="12"><font size="4"><b>CHITTAGONG PORT AUTHORITY</b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b>Reefer Position of Yard - <?php if($row->creator) echo $row->creator; else echo "&nbsp;";?><?php echo $yard_no;?></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b><u>Delivery Date Wise Import Reefer Container List</u></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b><u>DATE :</u> <?php
					echo date("d-m-Y", strtotime($fromdate));
					//$test1='$fromdate';
					//echo date('d-m-Y',strtotime($test1));
						?></b></font></td>
				</tr>

			</table>
		
		</td>
		
	</tr>
	
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr>
	</table>
	<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<tr  align="center">
		<td style="border-width:3px;border-style: double;"><b>SlNo.</b></td>
		<td style="border-width:3px;border-style: double;"><b>MLO.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Container No.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Size.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Vessel Name.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Rotation No.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Connection 1 Date & Time.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Disconnection 1 Date & Time.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Connection 2 Date & Time.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Disconnection 2 Date & Time.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Connection 3 Date & Time.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Disconnection 3 Date & Time.</b></td>
		<!--td style="border-width:3px;border-style: double;"><b>Yard Name.</b></td-->
		<td style="border-width:3px;border-style: double;"><b>User.</b></td>
	</tr>

<?php

$searchVal="";
if($rfrConStat=="1")
{
	$searchVal="inv_unit_fcy_visit.flex_date04";
}
else if($rfrConStat=="2")
{
	$searchVal="inv_unit_fcy_visit.flex_date06";
}
else if($rfrConStat=="3")
{
	$searchVal="inv_unit_fcy_visit.flex_date08";
}

//echo "VAL : ".$searchVal;

if($yard_no=="All")
		{
		$query=mysql_query("select * from (
		SELECT inv_unit.id,
		(SELECT vsl_name FROM ctmsmis.mis_inv_unit WHERE ctmsmis.mis_inv_unit.gkey=sparcsn4.inv_unit.gkey) AS vsl_name,
		(SELECT vsl_visit_dtls_ib_vyg FROM ctmsmis.mis_inv_unit WHERE ctmsmis.mis_inv_unit.gkey=sparcsn4.inv_unit.gkey) AS vsl_visit_dtls_ib_vyg,
		inv_unit_fcy_visit.flex_date03 AS rfr_connect, 
		inv_unit_fcy_visit.flex_date04 AS rfr_disconnect,
		inv_unit_fcy_visit.flex_date05 AS rfr_connect2, 
		inv_unit_fcy_visit.flex_date06 AS rfr_disconnect2,
		inv_unit_fcy_visit.flex_date07 AS rfr_connect3, 
		inv_unit_fcy_visit.flex_date08 AS rfr_disconnect3,
		(SELECT size FROM ctmsmis.mis_inv_unit WHERE ctmsmis.mis_inv_unit.gkey=sparcsn4.inv_unit.gkey) AS size,
		(SELECT mlo FROM ctmsmis.mis_inv_unit WHERE ctmsmis.mis_inv_unit.gkey=sparcsn4.inv_unit.gkey) AS mlo,
		(SELECT sparcsn4.srv_event.creator
		FROM sparcsn4.srv_event
		INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
		WHERE sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey AND sparcsn4.srv_event_field_changes.new_value IS NOT NULL AND sparcsn4.srv_event_field_changes.new_value like'%BDT' and sparcsn4.srv_event.event_type_gkey in ('4','33')
		 ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1)AS creator,
		(
		SELECT 
		CASE
			WHEN SUBSTR(UCASE(creator),1,3) = 'CCT' THEN 'CCT'
			WHEN SUBSTR(UCASE(creator),1,3) = 'GCB' THEN 'GCB'
			WHEN SUBSTR(UCASE(creator),1,3) = 'NCT' THEN 'NCT'
			ELSE SUBSTR(UCASE(inv_unit.flex_string03),1,3)
		END

		) AS yard 
		FROM sparcsn4.inv_unit
		INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey

		WHERE date($searchVal) BETWEEN '$fromdate' AND '$todate'
		AND sparcsn4.inv_unit.category='IMPRT'

		) as tmp order by rfr_disconnect");
								  
		}
		else
		{
			$login_id = $this->session->userdata('login_id');
			$str="SELECT * FROM (
			SELECT inv_unit.gkey,inv_unit.id,
			(SELECT vsl_name FROM ctmsmis.mis_inv_unit WHERE ctmsmis.mis_inv_unit.gkey=sparcsn4.inv_unit.gkey) AS vsl_name,
			(SELECT vsl_visit_dtls_ib_vyg FROM ctmsmis.mis_inv_unit WHERE ctmsmis.mis_inv_unit.gkey=sparcsn4.inv_unit.gkey) AS vsl_visit_dtls_ib_vyg,
			inv_unit_fcy_visit.flex_date03 AS rfr_connect, 
			inv_unit_fcy_visit.flex_date04 AS rfr_disconnect,
			inv_unit_fcy_visit.flex_date05 AS rfr_connect2, 
			inv_unit_fcy_visit.flex_date06 AS rfr_disconnect2,
			inv_unit_fcy_visit.flex_date07 AS rfr_connect3, 
			inv_unit_fcy_visit.flex_date08 AS rfr_disconnect3,
			(SELECT size FROM ctmsmis.mis_inv_unit WHERE ctmsmis.mis_inv_unit.gkey=sparcsn4.inv_unit.gkey) AS size,
			(SELECT mlo FROM ctmsmis.mis_inv_unit WHERE ctmsmis.mis_inv_unit.gkey=sparcsn4.inv_unit.gkey) AS mlo,
			(SELECT sparcsn4.srv_event.creator
			FROM sparcsn4.srv_event
			INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
			WHERE sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey AND sparcsn4.srv_event_field_changes.new_value IS NOT NULL 
			AND sparcsn4.srv_event_field_changes.new_value like'%BDT' and sparcsn4.srv_event.event_type_gkey=4 ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1)
			AS creator,
			(
			SELECT 
			CASE
				WHEN SUBSTR(UCASE(creator),1,3) = 'CCT' THEN 'CCT'
				WHEN SUBSTR(UCASE(creator),1,3) = 'GCB' THEN 'GCB'
				WHEN SUBSTR(UCASE(creator),1,3) = 'NCT' THEN 'NCT'
				ELSE SUBSTR(UCASE(inv_unit.flex_string03),1,3)
			END

			) AS yard 
			FROM sparcsn4.inv_unit

			INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey
			WHERE date($searchVal) BETWEEN '$fromdate' AND '$todate' AND sparcsn4.inv_unit.category='IMPRT' 
			 )
			 AS tmp WHERE yard='$yard_no'order by mlo, rfr_disconnect 
			 ";
			 //echo $str;
			$query=mysql_query($str);

		}

	$i=0;
	$j=0;
	
	$mlo="";
	while($row=mysql_fetch_object($query)){
	$i++;
	
		
	
?>

<tr align="center">
		<td><?php  echo $i;?></td>
		<td><?php if($row->mlo) echo $row->mlo; else echo "&nbsp;";?></td>
		<td><?php if($row->id) echo $row->id; else echo "&nbsp;";?></td>
		<td><?php if($row->size) echo $row->size; else echo "&nbsp;";?></td>
		<td><?php if($row->vsl_name) echo $row->vsl_name; else echo "&nbsp;";?></td>
		<td><?php if($row->vsl_visit_dtls_ib_vyg) echo $row->vsl_visit_dtls_ib_vyg; else echo "&nbsp;";?></td>
		<td><?php if($row->rfr_connect) echo $row->rfr_connect; else echo "&nbsp;";?></td>
		<td><?php if($row->rfr_disconnect) echo $row->rfr_disconnect; else echo "&nbsp;";?></td>
		<td><?php if($row->rfr_connect2) echo $row->rfr_connect2; else echo "&nbsp;";?></td>
		<td><?php if($row->rfr_disconnect2) echo $row->rfr_disconnect2; else echo "&nbsp;";?></td>
		<td><?php if($row->rfr_connect3) echo $row->rfr_connect3; else echo "&nbsp;";?></td>
		<td><?php if($row->rfr_disconnect3) echo $row->rfr_disconnect3; else echo "&nbsp;";?></td>
		<!--td><?php if($row->yard) echo $row->yard; else echo "&nbsp;";?></td-->
		<td><?php if($row->creator) echo $row->creator; else echo "&nbsp;";?></td>
	</tr>

<?php } ?>
</table>
 </br>
 </br>

<table width="70%" border="1" cellpadding='0' cellspacing='0' align="center">
	<tr  align="center"><td  colspan="4" style="border: none; font-size:20px"><b>Total Summary</b></td>
						<td colspan="4" style="border: none; font-size:20px"><font size="4"><b>DATE : <?php
							echo date("d-m-Y", strtotime($fromdate));
						?></b></font></td>
	</tr>
	<tr>
		<td align="center"><b>MLO</b></td>
		<td align="center"><b>AGENT NAME</b></td>
		<td align="center"><b>20 X 8.5</b></td>
		<td align="center"><b>20 X 9.5</b></td>
		<td align="center"><b>40 X 8.5</b></td>
		<td align="center"><b>40 X 9.5</b></td>
		<td align="center"><b>45 X 9.5</b></td>
		<td align="center"><b>TOTAL</b></td>
	</tr>

<?php
	
	$mlo_query_2=mysql_query("SELECT DISTINCT mlo,agent,agent_name,yard FROM (SELECT DISTINCT(r.id) AS mlo, Y.id AS agent, Y.name AS agent_name,
	(SELECT sparcsn4.srv_event.creator FROM sparcsn4.srv_event 
	INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
	WHERE sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey AND sparcsn4.srv_event_field_changes.new_value IS NOT NULL
	AND sparcsn4.srv_event_field_changes.new_value LIKE'%BDT' AND sparcsn4.srv_event.event_type_gkey=4
	 ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1) AS creator_name,
	(
	SELECT 
	CASE
		WHEN SUBSTR(UCASE(creator_name),1,3) = 'CCT' THEN 'CCT'
		WHEN SUBSTR(UCASE(creator_name),1,3) = 'GCB' THEN 'GCB'
		WHEN SUBSTR(UCASE(creator_name),1,3) = 'NCT' THEN 'NCT'
		ELSE SUBSTR(UCASE(inv_unit.flex_string03),1,3)
	END

	) AS yard 
	FROM sparcsn4.inv_unit 
	INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey

	INNER JOIN  ( sparcsn4.ref_bizunit_scoped r  
	LEFT JOIN ( sparcsn4.ref_agent_representation X  
	LEFT JOIN sparcsn4.ref_bizunit_scoped Y ON X.agent_gkey=Y.gkey )               
	ON r.gkey=X.bzu_gkey)  ON r.gkey = sparcsn4.inv_unit.line_op
	WHERE DATE($searchVal) BETWEEN '$fromdate' AND '$todate' AND sparcsn4.inv_unit.category='IMPRT') AS tmp
	WHERE yard='$yard_no' order by mlo asc");
	$mlo_2=0;	
	$reff_20_86=0;
	$reff_20_96=0;
	$reff_40_86=0;
	$reff_40_86=0;
	$reff_40_96=0;
	$reff_45_96=0;
	$tot=0;
	while($mlo_row_2=mysql_fetch_object($mlo_query_2)){
	$mlo_2++;

$st="SELECT 
IFNULL(SUM(20_86),0) AS reff_20_86,
IFNULL(SUM(20_96),0) AS reff_20_96, 
IFNULL(SUM(40_86),0) AS reff_40_86,
IFNULL(SUM(40_96),0) AS reff_40_96,
IFNULL(SUM(45_96),0) AS reff_45_96,
IFNULL(SUM(20_86_mty),0) AS reff_20_86_mty, 
IFNULL(SUM(20_96_mty),0) AS reff_20_96_mty,
IFNULL(SUM(40_86_mty),0) AS reff_40_86_mty, 
IFNULL(SUM(40_96_mty),0) AS reff_40_96_mty 
FROM (

SELECT (CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' 
AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' AND freight_kind IN ('FCL','LCL') 
THEN 1 ELSE NULL END) AS 20_86, 
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' 
AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='96' AND freight_kind IN ('FCL','LCL') 
THEN 1 ELSE NULL END) AS 20_96,
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) > '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' 
AND freight_kind IN ('FCL','LCL') THEN 1 ELSE NULL END) AS 40_86,
 
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) > '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='96'
AND freight_kind IN ('FCL','LCL') THEN 1 ELSE NULL END) AS 40_96,

(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) > '40' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='96'
AND freight_kind IN ('FCL','LCL') THEN 1 ELSE NULL END) AS 45_96,
 
 
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86' 
AND freight_kind='MTY' THEN 1 ELSE NULL END) AS 20_86_mty,
 (CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) = '20' 
AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='96' AND freight_kind='MTY' THEN 1 ELSE NULL END) AS 20_96_mty,
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) > '20' AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='86'
AND freight_kind='MTY' THEN 1 ELSE NULL END) AS 40_86_mty, 
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2) > '20'
AND RIGHT(sparcsn4.ref_equip_type.nominal_height,2)='96' AND freight_kind='MTY' THEN 1 ELSE NULL END) AS 40_96_mty, 

(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2)=20 AND freight_kind IN ('FCL','LCL') 
THEN 1 ELSE (CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2)>20 AND freight_kind IN ('FCL','LCL') THEN 2 ELSE NULL END) END) AS onboard_LD_tues,
(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2)=20 AND freight_kind='MTY' THEN 1
ELSE (CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2)>20 AND freight_kind='MTY' THEN 2 ELSE NULL END) END) AS onboard_MT_tues,
(SELECT sparcsn4.srv_event.creator FROM sparcsn4.srv_event 
INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
WHERE sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey AND sparcsn4.srv_event_field_changes.new_value IS NOT NULL
AND sparcsn4.srv_event_field_changes.new_value LIKE'%BDT' AND sparcsn4.srv_event.event_type_gkey=4
 ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1) AS creator_name,
(
SELECT 
CASE
    WHEN SUBSTR(UCASE(creator_name),1,3) = 'CCT' THEN 'CCT'
    WHEN SUBSTR(UCASE(creator_name),1,3) = 'GCB' THEN 'GCB'
    WHEN SUBSTR(UCASE(creator_name),1,3) = 'NCT' THEN 'NCT'
    ELSE SUBSTR(UCASE(inv_unit.flex_string03),1,3)
END

) AS yard 
FROM sparcsn4.inv_unit 
INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.unit_gkey=inv_unit.gkey
INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey 
INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit.gkey=sparcsn4.inv_unit_fcy_visit.unit_gkey 
INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.inv_unit_fcy_visit.actual_ib_cv=sparcsn4.argo_carrier_visit.gkey
INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey 

INNER JOIN  ( sparcsn4.ref_bizunit_scoped r  
LEFT JOIN ( sparcsn4.ref_agent_representation X  
LEFT JOIN sparcsn4.ref_bizunit_scoped Y ON X.agent_gkey=Y.gkey )               
ON r.gkey=X.bzu_gkey)  ON r.gkey = sparcsn4.inv_unit.line_op
WHERE DATE($searchVal) BETWEEN '$fromdate' AND '$todate' AND sparcsn4.inv_unit.category='IMPRT'
AND r.id ='$mlo_row_2->mlo' 
) AS tmp WHERE yard='$yard_no'";

//echo $st;
$summary_query_2=mysql_query($st);
$sum=0;	

while($summary_row_2=mysql_fetch_object($summary_query_2)){
$sum++;

?>

	<tr>
		<td align="center"><?php echo $mlo_row_2->mlo; ?></td>
		<td align="center"><?php echo $mlo_row_2->agent.'-'.$mlo_row_2->agent_name; ?></td>
		<td align="center"><?php $reff_20_86+=$summary_row_2->reff_20_86; echo $summary_row_2->reff_20_86; ?></td>
		<td align="center"><?php $reff_20_96+=$summary_row_2->reff_20_96; echo $summary_row_2->reff_20_96; ?></td>
		<td align="center"><?php $reff_40_86+=$summary_row_2->reff_40_86; echo $summary_row_2->reff_40_86; ?></td>
		<td align="center"><?php $reff_40_96+=$summary_row_2->reff_40_96; echo $summary_row_2->reff_40_96; ?></td>
		<td align="center"><?php $reff_45_96+=$summary_row_2->reff_45_96; echo $summary_row_2->reff_45_96; ?></td>
		<td align="center"><?php $tot+=$summary_row_2->reff_20_86 + $summary_row_2->reff_20_96 + $summary_row_2->reff_40_86 + $summary_row_2->reff_40_96 + $summary_row_2->reff_45_96 ;  echo $summary_row_2->reff_20_86 + $summary_row_2->reff_20_96 + $summary_row_2->reff_40_86 + $summary_row_2->reff_40_96 + $summary_row_2->reff_45_96 ; ?></td>
	</tr>
	<!--tr>
		<td></td>
		<td align="right">Total:</td>
		<td align="center"><?php echo $reff_20_86; ?></td>
		<td align="center"><?php echo $reff_20_96; ?></td>
		<td align="center"><?php echo $reff_40_86; ?></td>
		<td align="center"><?php echo $reff_40_96; ?></td>
		<td align="center"><?php echo $reff_45_96; ?></td>
		<td align="center"><?php echo $tot; ?></td>
	</tr-->

	
	<?php } ?>

	<?php } ?>
	<tr>
		<td align="right" colspan="2"><b>Total:</b></td>
		<td align="center"><?php echo $reff_20_86; ?></td>
		<td align="center"><?php echo $reff_20_96; ?></td>
		<td align="center"><?php echo $reff_40_86; ?></td>
		<td align="center"><?php echo $reff_40_96; ?></td>
		<td align="center"><?php echo $reff_45_96; ?></td>
		<td align="center"><?php echo $tot; ?></td>
	</tr>

</table>


<br />
<br />



<?php 
mysql_close($con);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
