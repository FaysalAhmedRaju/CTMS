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

	//$con=mysql_connect("10.1.1.21", "sparcsn4","sparcsn4")or die("cannot connect"); 
	//mysql_select_db("sparcsn4")or die("cannot select DB");
	include("dbConection.php");
	$sql=mysql_query("select vvd_gkey from sparcsn4.vsl_vessel_visit_details where ib_vyg='$ddl_imp_rot_no'");
	$row=mysql_fetch_object($sql);
	$vvdGkey=$row->vvd_gkey;
	
	$sql="call ctmsmis.update_containers_by_vvd_gkey($vvdGkey)";
	$res=mysql_query($sql);
	
	
	?>
<html>
<title>Assignment Date Wise Container Report</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				
				<tr align="center">
					<td colspan="12"><font size="4"><b>CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td>
				</tr>
			
				<tr align="center">
					<td colspan="12"><font size="4"><b>LAST 24:00 HRS SHIPPING BY HHT POSITION FOR FCL DLY CONTAINER</b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b> DATE: <?php echo $fromdate;?></b></font></td>
				</tr>
			</table>
		
		</td>
		
	</tr>
	
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr>
	</table>
	<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	

<?php
	//echo $type;
	
	
	$query=mysql_query("


SELECT DISTINCT *,
(CASE 
WHEN proEmtyDate >= CONCAT('$fromdate',' 08:00:00') AND proEmtyDate <CONCAT('$fromdate',' 16:00:00') THEN 'Shift A'
WHEN proEmtyDate >= CONCAT('$fromdate',' 16:00:00') AND proEmtyDate <CONCAT(DATE_ADD('$fromdate',INTERVAL 1 DAY),' 00:00:00') THEN 'Shift B'
WHEN proEmtyDate >= CONCAT(DATE_ADD('$fromdate',INTERVAL 1 DAY),' 00:00:00') AND proEmtyDate <CONCAT(DATE_ADD('$fromdate',INTERVAL 1 DAY),' 08:00:00') THEN 'Shift C'
END) AS shift,
(CASE WHEN proEmtyDate IS NULL THEN 2 ELSE 1 END) AS sl
FROM (
SELECT a.id AS cont_no,


(SELECT ctmsmis.cont_yard((SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
FROM sparcsn4.srv_event
INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
WHERE sparcsn4.srv_event.applied_to_gkey=a.gkey AND sparcsn4.srv_event.event_type_gkey=18 LIMIT 1))) AS Yard_No,

(SELECT sparcsn4.srv_event.created FROM  sparcsn4.srv_event 
INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
WHERE applied_to_gkey=a.gkey AND event_type_gkey=4 AND sparcsn4.srv_event_field_changes.new_value='E' LIMIT 1) AS proEmtyDate,
b.flex_date01 AS assignmentdate

FROM sparcsn4.inv_unit a
INNER JOIN sparcsn4.inv_unit_fcy_visit b ON b.unit_gkey=a.gkey
INNER JOIN sparcsn4.ref_bizunit_scoped g ON a.line_op = g.gkey
INNER JOIN sparcsn4.config_metafield_lov ON a.flex_string01=config_metafield_lov.mfdch_value

INNER JOIN
	    sparcsn4.inv_goods j ON j.gkey = a.goods
LEFT JOIN
	    sparcsn4.ref_bizunit_scoped k ON k.gkey = j.consignee_bzu
WHERE DATE(b.flex_date01)='$fromdate' AND config_metafield_lov.mfdch_value NOT IN ('OCD','APPCUS','APPOTH','APPREF')
) AS tmp WHERE Yard_No='$yard'
");

	$i=0;
	$j=0;
	$j20=0;
	$j40=0;
	$a20 = 0;
	$a40 = 0;
	$b20 = 0;
	$a40 = 0;
	$c20 = 0;
	$a40 = 0;
	
	//$yard="";
	$shift="";
	$tot20 = 0;
	$tot40 = 0;
	include("mydbPConnection.php");
	
	while($row=mysql_fetch_object($query)){
	$i++;			
	
	$sqlIsoCode=mysql_query("select cont_iso_type from igm_detail_container where cont_number='$row->cont_no'",$con2);
	
	//echo "select cont_iso_type from igm_detail_container where cont_number='$row->cont_no";
	$rtnIsoCode=mysql_fetch_object($sqlIsoCode);
	$iso=$rtnIsoCode->cont_iso_type;
	if(substr($iso,0,1)==2)
		$j20=$j20+1;
	else
		$j40=$j40+1;
		
	if(substr($iso,0,1)==2)
	{
		if($row->shift=="Shift A")
			$a20 = $a20+1;
		if($row->shift=="Shift B")
			$b20 = $b20+1;
		if($row->shift=="Shift C")
			$c20 = $c20+1;
	}
	else
	{
		if($row->shift=="Shift A")
			$a40 = $a40+1;
		if($row->shift=="Shift B")
			$b40 = $b40+1;
		if($row->shift=="Shift C")
			$c40 = $c40+1;
	}
		
	if($shift==$row->shift or $i==1)
	{
		if(substr($iso,0,1)==2)
			$tot20 = $tot20+1;
		else 
			$tot40 = $tot40+1;
	}
	

	} 
	mysql_close($con_cchaportdb);
	?>
		
	
	<table border="1" align="center">
	
		<thead>
			<tr>
				<th rowspan="3">UNIT/YARD</th>
				<th rowspan="3">SHIFT</th>
				<th colspan="2">TOTAL ASSIGNMENT</th>
				<th colspan="2">STRIPPED BY HHT</th>
				<th colspan="2">BALANCE</th>
				<th rowspan="3">REMARKS</th>
			</tr>
			<tr>
				<th>20(L)</th>
				<th>40(L)</th>
				<th>20(E)</th>
				<th>40(E)</th>
				<th>20(L)</th>
				<th>40(L)</th>
			</tr>
		</thead>
		<tbody>
			<tr align="center">
				
				<td><?php echo $yard; ?></td>
				<td>A</td>
				<td><?php echo $j20;?></td>
				<td><?php echo $j40;?></td>
				<td><?php echo $a20;?></td>
				<td><?php echo $a40;?></td>
				<td>
					<?php 
						$balA20 = $j20-$a20;
						echo $balA20;
					?>
				</td>
				<td>
					<?php 
						$balA40 = $j40-$a40;
						echo $balA40;
					?>
				</td>
				<td width="150"></td>
			</tr>
			<tr align="center">
				<td><?php echo $yard; ?></td>
				<td>B</td>
				<td><?php echo $balA20;?></td>
				<td><?php echo $balA40;?></td>
				<td><?php echo $b20;?></td>
				<td><?php echo $b40;?></td>
				<td>
					<?php 
						$balB20 = $balA20-$b20;
						echo $balB20;
					?>
				</td>
				<td>
					<?php 
						$balB40 = $balA40-$b40;
						echo $balB40;
					?>
				</td>
				<td></td>
			</tr>
			<tr align="center">
				<td><?php echo $yard; ?></td>
				<td>C</td>
				<td><?php echo $balB20;?></td>
				<td><?php echo $balB40;?></td>
				<td><?php echo $c20;?></td>
				<td><?php echo $c40;?></td>
				<td>
					<?php 
						$balC20 = $balB20-$c20;
						echo $balC20;
					?>
				</td>
				<td>
					<?php 
						$balC40 = $balB40-$c40;
						echo $balC40;
					?>
				</td>
				<td></td>
			</tr>
		</tbody>
	</table>
	<?php 
	mysql_close($con_sparcsn4);
	if($_POST['options']=='html'){?>	
		</BODY>
	</HTML>
<?php }?>
