
<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>Bearth Operator Report</TITLE>
		<meta Http-Equiv="Cache-Control" Content="no-cache">
		<meta Http-Equiv="Pragma" Content="no-cache">
		<meta Http-Equiv="Expires" Content="0"> 
		<!--meta http-equiv="refresh" content="20" -->
		<LINK href="../css/report.css" type="text/css rel=stylesheet">
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
		header("Content-Disposition: attachment; filename=SC_PERFORMANCE.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");
		

	}
	include("mydbPConnectionctms.php");
	
	?>
<html>
<title>EQUIPMENT HANDLING PERFORMANCE HISTORY</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				
				
				<tr align="center">
					<!--td colspan="12"><font size="4"><b>CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td-->
					<td colspan="12" align="center"><img width="250px" height="80px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
				</tr>
			
				<tr align="center">
					<td colspan="12"><font size="4"><b><u>EQUIPMENT HANDLING PERFORMANCE HISTORY</u></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b></b></font></td>
				</tr>
				<tr>
					<td colspan="3" align="center"><font size="4"><b>DATE: <?php  Echo $fromdate;?></b></font></td>
					<td colspan="3" align="center"><font size="4"><b>Shift: <?php  Echo $shift;?></b></font></td>
				</tr>

			</table>
		
		</td>
		
	</tr>
	
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr>
	</table>
	<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<tr  align="center" bgcolor="#e6e6e6">
		<td style="border-width:3px;border-style: double;"><b>SlNo.</b></td>
		<td style="border-width:3px;border-style: double;"><b>VMT Logln/LogOut Time</b></td>
		<td style="border-width:3px;border-style: double;"><b>Log Type</b></td>
		<td style="border-width:3px;border-style: double;"><b>User Name</b></td>
		<td style="border-width:3px;border-style: double;"><b>Operator Name</b></td>
		<td style="border-width:3px;border-style: double;"><b>Program</b></td>
	</tr>

<?php
	$cond = "";
	if($shift=="Day")
		$cond = "between concat('$fromdate',' 08:00:00') and concat('$fromdate',' 20:00:00')";
	else
		$cond = "between concat('$fromdate',' 20:00:00') and concat(DATE_ADD('$fromdate', interval 1 day),' 08:00:00')";
	
	if($serch_by =='all'){
		$strQuery = "select * from ctmsmis.mis_equip_log_in_out_info where LogDate $cond order by logDate,logEquip";
		
	}
	if($serch_by =='equip'){
		$strQuery = "select * from ctmsmis.mis_equip_log_in_out_info where logEquip='$serch_value' and LogDate $cond order by logDate";
	}
	if($serch_by =='euser'){
		$strQuery = "select * from ctmsmis.mis_equip_log_in_out_info where logBy='$serch_value' and LogDate $cond order by logDate";
	}
	
	$query=mysql_query($strQuery);

	$i=0;
	
	while($row=mysql_fetch_object($query)){
	$i++;
	
	
	?>
	<tr align="center">
			<td><?php  echo $i;?></td>
			<td><?php if($row->logDate) echo $row->logDate; else echo "&nbsp;";?></td>
			<td><?php if($row->logType) echo $row->logType; else echo "&nbsp;";?></td>
			<td><?php if($row->logBy) echo $row->logBy; else echo "&nbsp;";?></td>
			<td><?php if($row->logEquip) echo $row->logEquip; else echo "&nbsp;";?></td>
			<td><?php if($row->program) echo $row->program; else echo "&nbsp;";?></td>
		</tr>

	<?php }?>
</table>

<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>
	
	</BODY>
</HTML>
<?php }?>
