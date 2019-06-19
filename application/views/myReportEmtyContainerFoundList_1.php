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
		header("Content-Disposition: attachment; filename=EXPORT_SUMMERY.xls;");
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
	
	if($type=="assign")
	{
		$col = "b.flex_date01";
		$head = "Assignment Date Wise Import Container List";
	}
	
	elseif($type=="assigne")
	{
		$col = "b.flex_date01";
		$head = "Assignment Date(E) Wise Import Container List";
	}
	else
	{
		
		$col = "b.time_out";		
		$head = "Date Wise Delivery Import Container List";
	}
	
	?>
<html>
<title>PROPOSED EMPTY AND EMPTY  CONTAINER REPORT</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				
				<tr align="center">
					<td colspan="12"><font size="4"><b>CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td>
				</tr>
			
				<tr align="center">
					<td colspan="12"><font size="4"><b><u>PROPOSED EMPTY AND EMPTY  CONTAINER REPORT</u></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b></b></font></td>
				</tr>

				<tr align="center">
					<td colspan="12"><font size="4"><b><u><?php echo $head;?></u></b></font></td>
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
		<td style="border-width:3px;border-style: double;"><b>Rotation No.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Type</b></td>
		<td style="border-width:3px;border-style: double;"><b>Destination</b></td>
		<td style="border-width:3px;border-style: double;"><b>MLO</b></td>
		<td style="border-width:3px;border-style: double;"><b>Status</b></td>		
		<td style="border-width:3px;border-style: double;"><b>Weight</b></td>
		<td style="border-width:3px;border-style: double;"><b>Yard</b></td>
		<td style="border-width:3px;border-style: double;"><b>Position</b></td>
		<td style="border-width:3px;border-style: double;"><b>Discharge date</b></td>
		<td style="border-width:3px;border-style: double;"><b>Assignment Type</b></td>
		<td style="border-width:3px;border-style: double;"><b>Assignment date</b></td>
		<td style="border-width:3px;border-style: double;"><b>Propose Empty Date(E)</b></td>
		<td style="border-width:3px;border-style: double;"><b>Empty/Delivery Date</b></td>
		
		
	</tr>

<?php
	
	
	
	$query=mysql_query("

SELECT DISTINCT * FROM (
SELECT a.id AS cont_no,
(SELECT ctmsmis.mis_inv_unit.iso_code FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey) AS iso_code,
(SELECT ctmsmis.mis_inv_unit.vsl_visit_dtls_ib_vyg FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey) AS rot_no,
(SELECT size FROM ctmsmis.mis_inv_unit WHERE ctmsmis.mis_inv_unit.gkey=a.gkey) AS size,
(SELECT height FROM ctmsmis.mis_inv_unit WHERE ctmsmis.mis_inv_unit.gkey=a.gkey) AS height,
(SELECT sparcsn4.inv_goods.destination FROM sparcsn4.inv_goods WHERE sparcsn4.inv_goods.gkey=a.goods) AS destination,
b.time_in AS dischargetime,
b.time_out as delivery,
g.id AS mlo,
a.flex_string01 AS assignmenttype,
(SELECT ctmsmis.mis_inv_unit.freight_kind FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey) AS statu,
(SELECT ctmsmis.mis_inv_unit.goods_and_ctr_wt_kg FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey) AS weight,

(SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
FROM sparcsn4.srv_event
INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
WHERE sparcsn4.srv_event.applied_to_gkey=a.gkey AND sparcsn4.srv_event.event_type_gkey IN(18,13,16) AND sparcsn4.srv_event_field_changes.new_value IS NOT NULL AND sparcsn4.srv_event_field_changes.new_value !='' AND sparcsn4.srv_event_field_changes.new_value !='Y-CGP-.' AND sparcsn4.srv_event.gkey<(SELECT sparcsn4.srv_event.gkey FROM sparcsn4.srv_event 
INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
WHERE sparcsn4.srv_event.event_type_gkey IN(30) AND sparcsn4.srv_event.applied_to_gkey=a.gkey ORDER BY sparcsn4.srv_event_field_changes.gkey DESC LIMIT 1) ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1) AS carrentPosition,

(SELECT ctmsmis.cont_yard((SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
FROM sparcsn4.srv_event
INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
WHERE sparcsn4.srv_event.applied_to_gkey=a.gkey AND sparcsn4.srv_event.event_type_gkey=18 LIMIT 1))) AS Yard_No,
(SELECT ctmsmis.cont_block((SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
FROM sparcsn4.srv_event
INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
WHERE sparcsn4.srv_event.applied_to_gkey=a.gkey AND sparcsn4.srv_event.event_type_gkey=18 LIMIT 1),Yard_No)) AS Block_No,
(SELECT sparcsn4.srv_event.created FROM  sparcsn4.srv_event 
INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
WHERE applied_to_gkey=a.gkey AND event_type_gkey=4 AND sparcsn4.srv_event_field_changes.new_value='E' LIMIT 1) AS proEmtyDate,
b.time_out AS emptyDate,
b.flex_date01 AS assignmentdate

FROM sparcsn4.inv_unit a
INNER JOIN sparcsn4.inv_unit_fcy_visit b ON b.unit_gkey=a.gkey
INNER JOIN sparcsn4.ref_bizunit_scoped g ON a.line_op = g.gkey
INNER JOIN sparcsn4.config_metafield_lov ON a.flex_string01=config_metafield_lov.mfdch_value

INNER JOIN
	    sparcsn4.inv_goods j ON j.gkey = a.goods
LEFT JOIN
	    sparcsn4.ref_bizunit_scoped k ON k.gkey = j.consignee_bzu
WHERE DATE($col) BETWEEN '$fromdate' AND '$todate' AND a.seal_nbr3='E' 

) AS tmp where Yard_No='$yard_no' order by emptyDate
");

	$i=0;
	$j=0;
	
	$mlo="";
	while($row=mysql_fetch_object($query)){
	$i++;
	
	include("mydbPConnection.php");
	$sqlIsoCode=mysql_query("select cont_iso_type from igm_detail_container where cont_number='$row->cont_no'",$con_cchaportdb);
	
	//echo "select cont_iso_type from igm_detail_container where cont_number='$row->cont_no";
	$rtnIsoCode=mysql_fetch_object($sqlIsoCode);
	$iso=$rtnIsoCode->cont_iso_type;	
	
?>
<tr align="center">
		<td><?php  echo $i;?></td>
		<td><?php if($row->cont_no) echo $row->cont_no; else echo "&nbsp;";?></td>
		<td><?php if($row->size) echo $row->size; else echo "&nbsp;";?></td>
		<td><?php if($row->height/10) echo $row->height/10; else echo "&nbsp;";?></td>
		<td><?php if($row->rot_no) echo $row->rot_no; else echo "&nbsp;";?></td>
		<td><?php if($iso) echo $iso; else echo "&nbsp;";?></td>
		<td><?php if($row->destination) echo $row->destination; else echo "&nbsp;";?></td>
		<td><?php if($row->mlo) echo $row->mlo; else echo "&nbsp;";?></td>
		<td><?php if($row->statu) echo $row->statu; else echo "&nbsp;";?></td>
		<td><?php if($row->weight) echo $row->weight; else echo "&nbsp;";?></td>
		<td><?php if($row->Yard_No) echo $row->Yard_No; else echo "&nbsp;";?></td>
		<td><?php if($row->carrentPosition) echo $row->carrentPosition; else echo "&nbsp;";?></td>
		<td><?php if($row->dischargetime) echo $row->dischargetime; else echo "&nbsp;";?></td>
		<td><?php if($row->assignmenttype) echo $row->assignmenttype; else echo "&nbsp;";?></td>
		<td><?php if($row->assignmentdate) echo $row->assignmentdate; else echo "&nbsp;";?></td>
		
		<td><?php if($row->proEmtyDate) echo $row->proEmtyDate; else echo "&nbsp;";?></td>
		<td><?php if($row->emptyDate) echo $row->emptyDate; else echo "&nbsp;";?></td>
		
				
	</tr>

<?php 
	mysql_close($con_cchaportdb);
} ?>
</table>
<br />
<br />

<?php
include("dbConection.php");

$sqlSummery2=mysql_query("SELECT 
SUM(cont_no) AS cont_no,
SUM(impt20_not_done) AS impt20_not_done,
SUM(impt40_not_done) AS impt40_not_done,
SUM(impt20_done) AS impt20_done,
SUM(impt40_done) AS impt40_done

FROM (


SELECT 

(CASE WHEN a.id IS NOT NULL THEN 1 ELSE 0 END) AS cont_no,
(CASE WHEN ms.size=20  AND time_out IS NULL THEN 1 ELSE 0 END) AS impt20_not_done,
(CASE WHEN ms.size!=20  AND time_out IS NULL THEN 1 ELSE 0 END) AS impt40_not_done,
(CASE WHEN ms.size=20  AND time_out IS NOT NULL THEN 1 ELSE 0 END) AS impt20_done,
(CASE WHEN ms.size!=20  AND time_out IS NOT NULL THEN 1 ELSE 0 END) AS impt40_done
FROM sparcsn4.inv_unit a
INNER JOIN sparcsn4.inv_unit_fcy_visit b ON b.unit_gkey=a.gkey

INNER JOIN ctmsmis.mis_inv_unit ms ON ms.gkey=a.gkey

WHERE  DATE(b.flex_date01) BETWEEN '$fromdate' AND '$todate' AND a.seal_nbr3='E'  

) AS tmp");

$rowSummery2=mysql_fetch_object($sqlSummery2);
?>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr><td colspan="12" align="center"><font size="4"><b><u> Summary For Not Yet Delivery/Empty Report</u></b></font></td></tr>
<tr><td colspan="12" align="center"><font size="4"><b>&nbsp;</b></font></td></tr>
</table>
<table width="40%" border ='1' cellpadding='0' cellspacing='0' align="center">
	<tr>
		<td colspan="6" align="center">Delivery/Empty List</td>
	
	</tr>
	
	<tr>
		<td style="width:160px; align="center" >Total Container</td>
		<td align="center">20</td>
		<td align="center">40</td>
		
	</tr>
	<tr>
		
	
		<td align="center"><?php if($rowSummery2->cont_no) echo $rowSummery2->cont_no; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery2->impt20_not_done) echo $rowSummery2->impt20_not_done; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery2->impt40_not_done) echo $rowSummery2->impt40_not_done; else echo "&nbsp;"; ?></td>
		
	</tr>
</table>
<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
