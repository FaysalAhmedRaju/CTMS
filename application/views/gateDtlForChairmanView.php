<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>Gate Details Report</TITLE>
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

	include("dbConection.php");
	
	?>
<html>

<head>
	<title>Gate List</title>
	<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.4.2.min.js"></script>
	<script>
	var window_focus;
		$(window).focus(function() {
			window_focus = true;
		}).blur(function() {
			window_focus = false;
		});
		function checkReload(){
			if(!window_focus){
				location.reload();  // if not focused, reload
			}
		}
		setInterval(checkReload, 60*1000); // 1 minute
	</script>
</head>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">				
				<tr align="center">
					<td colspan="12"><img height="100px" src="<?php echo IMG_PATH;?>cpa_logo.png" /></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b>CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td>
				</tr>
			
				<tr align="center">
					<td colspan="12"><font size="4"><b><u>Gate Report</u></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b><?php echo "Current date is " . date("Y-m-d"); ?></b></font></td>
				</tr>

			</table>
		
		</td>
		
	</tr>
	
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr>
	</table>
	<div align="center">
	<table width="50%" border ='1' cellpadding='0' cellspacing='0'>
	
	<tr  align="center" bgcolor="#D8D0CE">
		<td style="border-width:3px;border-style: double;"><b>SlNo.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Gate</b></td>
		<td style="border-width:3px;border-style: double;"><b>Total In Today</b></td>
		<td style="border-width:3px;border-style: double;"><b>Total Out Today</b></td>
	</tr>

	<!--tr  align="center">
		<td style="border-width:3px;border-style: double;"><b>Total Import Container</b></td>
		<td style="border-width:3px;border-style: double;"><b>Total Discharge Container</b></td>		
		<td style="border-width:3px;border-style: double;"><b>Balance</b></td>
		<td style="border-width:3px;border-style: double;"><b>Total Export Container</b></td>
		<td style="border-width:3px;border-style: double;"><b>Loaded On Board</b></td>		
		<td style="border-width:3px;border-style: double;"><b>Balance To Be Shipped</b></td>	
	</tr-->

<?php

	//echo$vvdGkey;
	$strQuery = "SELECT DISTINCT gkey, id FROM sparcsn4.road_gates WHERE life_cycle_state='ACT' AND id NOT IN('CGP','IFT')";
	
	//echo $strQuery;
	$query=mysql_query($strQuery);

	$i=0;
	while($row=mysql_fetch_object($query)){
	$i++;
	
	$sqlGetTotIn="SELECT COUNT(sparcsn4.road_truck_transactions.nbr) AS total_in
					FROM sparcsn4.road_truck_visit_details
					INNER JOIN sparcsn4.road_truck_transactions ON sparcsn4.road_truck_transactions.truck_visit_gkey=sparcsn4.road_truck_visit_details.tvdtls_gkey
					WHERE DATE(sparcsn4.road_truck_visit_details.created)=DATE(NOW()) AND sparcsn4.road_truck_visit_details.gate_gkey=$row->gkey AND stage_id='In Gate'";
	$queryTotIn=mysql_query($sqlGetTotIn);
	$rowTotIn=mysql_fetch_object($queryTotIn);
	
	$sqlGetTotOut="SELECT COUNT(sparcsn4.road_truck_transactions.nbr) AS total_out
					FROM sparcsn4.road_truck_visit_details
					INNER JOIN sparcsn4.road_truck_transactions ON sparcsn4.road_truck_transactions.truck_visit_gkey=sparcsn4.road_truck_visit_details.tvdtls_gkey
					WHERE DATE(sparcsn4.road_truck_visit_details.created)=DATE(NOW()) AND sparcsn4.road_truck_visit_details.gate_gkey=$row->gkey AND stage_id='Out Gate'";
	$queryTotOut=mysql_query($sqlGetTotOut);
	$rowTotOut=mysql_fetch_object($queryTotOut);
	
?>
<tr align="center">
		<td><?php  echo $i;?></td>
		<td><?php if($row->id) echo $row->id; else echo "&nbsp;";?></td>
		<td><?php echo $rowTotIn->total_in; ?></td>
		<td><?php echo $rowTotOut->total_out; ?></td>		
</tr>

<?php } ?>
</table>
</div>
<br />
<br />

<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
