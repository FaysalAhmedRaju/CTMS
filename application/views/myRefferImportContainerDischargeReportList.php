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
		header("Content-Disposition: attachment; filename=Reefer_Container.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}
	//$ddl_imp_rot_no=$_REQUEST['ddl_imp_rot_no']; 

	//$con=mysql_connect("10.1.1.21", "sparcsn4","sparcsn4")or die("sparcsn4 database cannot connect"); 
	//mysql_select_db("sparcsn4")or die("cannot select DB");
	include("dbConection.php");
	//echo $todate;
	
	if($type=="con")
	{
		$col = "date(inv_unit_fcy_visit.flex_date03) BETWEEN '$fromdate' AND '$todate'";
		$head = "Power Connection Date Wise Import Reefer Container List";
	}
	
	elseif($type=="assign")
	{
		$col = "date(flex_date01) BETWEEN '$fromdate' AND '$todate'";
		$head = "Assignment Date Wise Import Reefer Container List";
	}
	else
	{
		$col = "date(time_in) BETWEEN '$fromdate' AND '$todate'";
		$head = "Discharge Date Wise Import Reefer Container List";
	}
	?>
<html>
<!--title>Import Reffer Container Discharge List</title-->
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				<tr align="center">
					<td align="center" valign="middle" colspan="12" align="center"><img align="middle"  width="220px" height="70px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
				</tr>				
				<tr align="center">
					<td align="center" valign="middle" colspan="12"><font size="4"><b> Container Terminal Operator</b></font></td>
				</tr>
				
				<tr align="center">
					<td align="center" valign="middle" colspan="12"><font size="4"><b><u><?php echo $head;?></u></b></font></td>
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
	<tr  align="center">
		<td style="border-width:3px;border-style: double;"><b>SlNo.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Container No.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Size.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Height.</b></td>
		<td style="border-width:3px;border-style: double;"><b>MLO.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Vessel Name.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Rotation.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Discharge Time.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Yard Name.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Block Name.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Position.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Power Request Time.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Power Connect.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Power Disconnect.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Delivery Type.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Assignment Date.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Delivery Date.</b></td>
		
		
	</tr>

<?php

	
$query=mysql_query("SELECT * FROM (
SELECT inv_unit.gkey,inv_unit.id,inv_unit_fcy_visit.time_in,inv_unit.power_rqst_time,
(SELECT vsl_name FROM ctmsmis.mis_inv_unit WHERE ctmsmis.mis_inv_unit.gkey=sparcsn4.inv_unit.gkey) AS vsl_name,
(SELECT vsl_visit_dtls_ib_vyg FROM ctmsmis.mis_inv_unit WHERE ctmsmis.mis_inv_unit.gkey=sparcsn4.inv_unit.gkey) AS vsl_visit_dtls_ib_vyg,
(SELECT sparcsn4.srv_event.created FROM sparcsn4.srv_event WHERE sparcsn4.srv_event.event_type_gkey=30 AND sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1) AS time_out, 
(SELECT sparcsn4.srv_event.created FROM sparcsn4.srv_event WHERE sparcsn4.srv_event.event_type_gkey=32 AND sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1) AS rfr_connect, 
(SELECT sparcsn4.srv_event.created FROM sparcsn4.srv_event WHERE sparcsn4.srv_event.event_type_gkey=33 AND sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1) AS rfr_disconnect, 
(SELECT size FROM ctmsmis.mis_inv_unit WHERE ctmsmis.mis_inv_unit.gkey=sparcsn4.inv_unit.gkey) AS size,
(SELECT height FROM ctmsmis.mis_inv_unit WHERE ctmsmis.mis_inv_unit.gkey=sparcsn4.inv_unit.gkey) AS height,
(SELECT mlo FROM ctmsmis.mis_inv_unit WHERE ctmsmis.mis_inv_unit.gkey=sparcsn4.inv_unit.gkey) AS mlo,
IF(sparcsn4.inv_unit_fcy_visit.last_pos_slot='',
(SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
FROM sparcsn4.srv_event
INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
WHERE sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey AND sparcsn4.srv_event.event_type_gkey IN(18) AND sparcsn4.srv_event_field_changes.new_value IS NOT NULL AND sparcsn4.srv_event_field_changes.new_value !='' AND sparcsn4.srv_event_field_changes.new_value !='Y-CGP-.' AND sparcsn4.srv_event.gkey<(SELECT sparcsn4.srv_event.gkey FROM sparcsn4.srv_event 
INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
WHERE sparcsn4.srv_event.event_type_gkey IN(25,29,30) AND sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey ORDER BY sparcsn4.srv_event_field_changes.gkey DESC LIMIT 1) ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1)
,sparcsn4.inv_unit_fcy_visit.last_pos_slot) AS last_pos_slot,

(SELECT ctmsmis.cont_yard(IF(sparcsn4.inv_unit_fcy_visit.last_pos_slot='',
(SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
FROM sparcsn4.srv_event
INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
WHERE sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey AND sparcsn4.srv_event.event_type_gkey IN(18) AND sparcsn4.srv_event_field_changes.new_value IS NOT NULL AND sparcsn4.srv_event_field_changes.new_value !='' AND sparcsn4.srv_event_field_changes.new_value !='Y-CGP-.' AND sparcsn4.srv_event.gkey<(SELECT sparcsn4.srv_event.gkey FROM sparcsn4.srv_event 
INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
WHERE sparcsn4.srv_event.event_type_gkey IN(25,29,30) AND sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey ORDER BY sparcsn4.srv_event_field_changes.gkey DESC LIMIT 1) ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1)
,sparcsn4.inv_unit_fcy_visit.last_pos_slot))) AS yard,
(SELECT ctmsmis.cont_block(IF(sparcsn4.inv_unit_fcy_visit.last_pos_slot='',
(SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
FROM sparcsn4.srv_event
INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
WHERE sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey AND sparcsn4.srv_event.event_type_gkey IN(18) AND sparcsn4.srv_event_field_changes.new_value IS NOT NULL AND sparcsn4.srv_event_field_changes.new_value !='' AND sparcsn4.srv_event_field_changes.new_value !='Y-CGP-.' AND sparcsn4.srv_event.gkey<(SELECT sparcsn4.srv_event.gkey FROM sparcsn4.srv_event 
INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
WHERE sparcsn4.srv_event.event_type_gkey IN(25,29,30) AND sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey ORDER BY sparcsn4.srv_event_field_changes.gkey DESC LIMIT 1) ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1)
,sparcsn4.inv_unit_fcy_visit.last_pos_slot),yard)) AS block,
sparcsn4.inv_unit.flex_string01,sparcsn4.inv_unit_fcy_visit.flex_date01
FROM sparcsn4.inv_unit
LEFT JOIN ctmsmis.mis_inv_unit ON ctmsmis.mis_inv_unit.gkey = inv_unit.gkey
INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey
WHERE ctmsmis.mis_inv_unit.iso_grp IN ('RE','RS','RT')  AND sparcsn4.inv_unit.category='IMPRT' 
AND DATE(sparcsn4.inv_unit_fcy_visit.flex_date01) BETWEEN '$fromdate' AND '$todate'
ORDER BY yard
 )
 AS tmp WHERE $col and yard='$yard_no' ORDER BY yard
 ");

	$i=0;
	$j=0;
	
	$mlo="";
	while($row=mysql_fetch_object($query)){
	$i++;
	
		
	
?>
<tr align="center">
		<td><?php  echo $i;?></td>
		<td><?php if($row->id) echo $row->id; else echo "&nbsp;";?></td>
		<td><?php if($row->size) echo $row->size; else echo "&nbsp;";?></td>
		<td><?php if($row->height) echo $row->height; else echo "&nbsp;";?></td>
		<td><?php if($row->mlo) echo $row->mlo; else echo "&nbsp;";?></td>
		<td><?php if($row->vsl_name) echo $row->vsl_name; else echo "&nbsp;";?></td>
		<td><?php if($row->vsl_visit_dtls_ib_vyg) echo $row->vsl_visit_dtls_ib_vyg; else echo "&nbsp;";?></td>
		<td><?php if($row->time_in) echo $row->time_in; else echo "&nbsp;";?></td>
		<td><?php if($row->yard) echo $row->yard; else echo "&nbsp;";?></td>
		<td><?php if($row->block) echo $row->block; else echo "&nbsp;";?></td>
		<td><?php if($row->last_pos_slot) echo $row->last_pos_slot; else echo "&nbsp;";?></td>
		<td><?php if($row->power_rqst_time) echo $row->power_rqst_time; else echo "&nbsp;";?></td>
		<td><?php if($row->rfr_connect) echo $row->rfr_connect; else echo "&nbsp;";?></td>
		<td><?php if($row->rfr_disconnect) echo $row->rfr_disconnect; else echo "&nbsp;";?></td>
		<td><?php if($row->flex_string01) echo $row->flex_string01; else echo "&nbsp;";?></td>
		<td><?php if($row->flex_date01) echo $row->flex_date01; else echo "&nbsp;";?></td>
		<td><?php if($row->time_out) echo $row->time_out; else echo "&nbsp;";?></td>
				
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
