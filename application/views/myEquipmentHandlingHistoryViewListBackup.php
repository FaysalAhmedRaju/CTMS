
<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>Bearth Operator Report</TITLE>
		<meta Http-Equiv="Cache-Control" Content="no-cache">
		<meta Http-Equiv="Pragma" Content="no-cache">
		<meta Http-Equiv="Expires" Content="0"> 
		<meta http-equiv="refresh" content="20" >
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
		header("Content-Disposition: attachment; filename=RTG_PERFORMANCE.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");
		

	}
	include("dbConection.php");
	
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
		<td style="border-width:3px;border-style: double;"><b>RTG # NO.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Start VMT Log in Time</b></td>
		<td style="border-width:3px;border-style: double;"><b>End VMT Log out Time</b></td>
		<td style="border-width:3px;border-style: double;"><b>ID NO</b></td>
		<td style="border-width:3px;border-style: double;"><b>RTG Operator Name</b></td>		
		<td style="border-width:3px;border-style: double;"><b>Import Receiving</b></td>
		<td style="border-width:3px;border-style: double;"><b>Keep Down / Delivery</b></td>
		<td style="border-width:3px;border-style: double;"><b>Delivery (OCD / Off Dock)</b></td>
		<td style="border-width:3px;border-style: double;"><b>Shifting</b></td>
		<td style="border-width:3px;border-style: double;"><b>Total Handling Boxes</b></td>
	</tr>

<?php
	$cond = "";
	if($shift=="Day")
		$cond = "between concat('$fromdate',' 08:00:00') and concat('$fromdate',' 20:00:00')";
	else
		$cond = "between concat('$fromdate',' 20:00:00') and concat(DATE_ADD('$fromdate', interval 1 day),' 08:00:00')";
	
		$strQuery = "select eq,created_by,sum(impRcv) as impRcv,sum(keepDlv) as keepDlv,sum(dlvOcdOffDock) as dlvOcdOffDock,sum(shift) as shift
					from(
					select full_name as eq,created_by,
					(case when move_kind='DSCH' then 1 else 0 end) as impRcv,
					(case when move_kind='YARD' then 1 else 0 end) as keepDlv,
					(case when move_kind in('DLVR','SHOB') then 1 else 0 end) as dlvOcdOffDock,
					(case when move_kind='SHFT' then 1 else 0 end) as shift
					from
					(
					select full_name,move_kind,
					(select  placed_by from sparcsn4.srv_event where srv_event.gkey=sparcsn4.inv_move_event.mve_gkey)  as created_by
					from sparcsn4.inv_move_event 
					inner join sparcsn4.xps_che on (sparcsn4.xps_che.gkey=sparcsn4.inv_move_event.che_fetch or sparcsn4.xps_che.gkey=sparcsn4.inv_move_event.che_carry or sparcsn4.xps_che.gkey=sparcsn4.inv_move_event.che_put)
					where t_put $cond and (full_name like 'RTG%') and move_kind='DSCH' 

					union all

					select full_name,move_kind,
					(select  placed_by from sparcsn4.srv_event where srv_event.gkey=sparcsn4.inv_move_event.mve_gkey)  as created_by
					from sparcsn4.inv_move_event 
					inner join sparcsn4.xps_che on (sparcsn4.xps_che.gkey=sparcsn4.inv_move_event.che_fetch or sparcsn4.xps_che.gkey=sparcsn4.inv_move_event.che_carry or sparcsn4.xps_che.gkey=sparcsn4.inv_move_event.che_put)
					where t_put $cond and (full_name like 'RTG%') and move_kind='SHFT' 

					union all

					select full_name,move_kind,
					(select  placed_by from sparcsn4.srv_event where srv_event.gkey=sparcsn4.inv_move_event.mve_gkey)  as created_by
					from sparcsn4.inv_move_event 
					inner join sparcsn4.xps_che on (sparcsn4.xps_che.gkey=sparcsn4.inv_move_event.che_fetch or sparcsn4.xps_che.gkey=sparcsn4.inv_move_event.che_carry or sparcsn4.xps_che.gkey=sparcsn4.inv_move_event.che_put)
					where t_put $cond and (full_name like 'RTG%') and move_kind='DLVR' 

					union all

					select full_name,move_kind,
					(select  placed_by from sparcsn4.srv_event where srv_event.gkey=sparcsn4.inv_move_event.mve_gkey)  as created_by
					from sparcsn4.inv_move_event 
					inner join sparcsn4.xps_che on (sparcsn4.xps_che.gkey=sparcsn4.inv_move_event.che_fetch or sparcsn4.xps_che.gkey=sparcsn4.inv_move_event.che_carry or sparcsn4.xps_che.gkey=sparcsn4.inv_move_event.che_put)
					where t_put $cond and (full_name like 'RTG%') and move_kind='SHOB' 

					union all

					select full_name,move_kind,
					(select  placed_by from sparcsn4.srv_event where srv_event.gkey=sparcsn4.inv_move_event.mve_gkey)  as created_by
					from sparcsn4.inv_move_event 
					inner join sparcsn4.xps_che on (sparcsn4.xps_che.gkey=sparcsn4.inv_move_event.che_fetch or sparcsn4.xps_che.gkey=sparcsn4.inv_move_event.che_carry or sparcsn4.xps_che.gkey=sparcsn4.inv_move_event.che_put)
					where t_put $cond and (full_name like 'RTG%') and move_kind='YARD' order by full_name,move_kind) as t) as f group by eq ";
					
	$query=mysql_query($strQuery);

	$i=0;
	$j=0;
	$imRtotal=0;
	$keepDTotal=0;
	$dOffTotal=0;
	$shiftTotal=0;
	include("mydbPConnectionctms.php");
	while($row=mysql_fetch_object($query)){
	$i++;
			
	$sqlLogTime=mysql_query("select logDate,logBy from mis_equip_log_in_out_info where logEquip='$row->eq' and logType='in' and  logDate $cond order by logDate limit 1",$con_ctmsmis);

				
	$rtnLogTime=mysql_fetch_object($sqlLogTime);
	$log_In=$rtnLogTime->logDate;
	$logBy=$rtnLogTime->logBy;
	
	$sqlLogOut=mysql_query("select logDate from mis_equip_log_in_out_info where logEquip='$row->eq' and logType='out' and  logDate $cond  order by logDate desc limit 1",$con_ctmsmis);
				
	$rtnLogOut=mysql_fetch_object($sqlLogOut);
	$log_Out=$rtnLogOut->logDate;
	
	$imRtotal=$imRtotal+$row->impRcv;
	$keepDTotal=$keepDTotal+$row->keepDlv;
	$dOffTotal=$dOffTotal+$row->dlvOcdOffDock;
	$shiftTotal=$shiftTotal+$row->shift;
	
	?>
	<tr align="center">
			<td><?php  echo $i;?></td>
			<td><?php if($row->eq) echo $row->eq; else echo "&nbsp;";?></td>
			<td><?php if($log_In) echo $log_In; else echo "&nbsp;";?></td>
			<td><?php if($log_Out) echo $log_Out; else echo "&nbsp;";?></td>
			
			<td><?php if($row->short_name) echo $row->short_name; else echo "&nbsp;";?></td>
			<td><?php if($logBy) echo $logBy; else echo "&nbsp;";?></td>
			<!--td><?php 
			$operator = explode(':',$row->created_by);
			 echo $operator[1];
			?></td-->	
			<td><?php echo $row->impRcv; ?></td>	
			<td><?php echo $row->keepDlv;?></td>	
			<td><?php echo $row->dlvOcdOffDock;?></td>	
			<td><?php echo $row->shift;?></td>	
			<td><?php echo $total=$row->impRcv+$row->keepDlv+$row->dlvOcdOffDock+$row->shift;?></td>	

		</tr>

	<?php  }
	mysql_close($con_ctmsmis);
	?>
		
		<tr bgcolor="#E0FFFF" align="center"><td colspan="6"><font size="4"><b>Total:</b></font></td>
		<td><font size="4"><b><?php  echo $imRtotal;?></b></font></td>
		<td><font size="4"><b><?php  echo $keepDTotal;?></b></font></td>
		<td><font size="4"><b><?php  echo $dOffTotal;?></b></font></td>
		<td><font size="4"><b><?php  echo $shiftTotal;?></b></font></td>
		<td><font size="4"><b><?php  echo $total=$imRtotal+ $keepDTotal+$dOffTotal+$shiftTotal;?></b></font></td>
		</tr>
</table>

<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>
	
	</BODY>
</HTML>
<?php }?>
