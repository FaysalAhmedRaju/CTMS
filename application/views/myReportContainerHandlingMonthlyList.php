<HTML>
	<HEAD>
		<!--TITLE>Yardwise Equipment Booking Report</TITLE-->
		
	    <style type="text/css">
<!--
.style1 {font-size: 12px}
-->
        </style>
</HEAD>
<BODY>

	<?php
		include("dbConection.php");
		$cond = "";
		$shiftCondition=" and shift='$shift'";
		//echo $shift;
		// if($equipment=="All")
			
			// if($shift=="All")
				// $cond = " DATE(EAD.start_work_time)='$sDate'";
			// else
				// $cond = " DATE(EAD.start_work_time)='$sDate'".$shiftCondition;
			
		// else if($equipment=="Equipment")
			// if($shift=="All")
				// $cond = " (ED.equipment='$sVal') AND DATE(EAD.start_work_time)='$sDate'";
			// else
				// $cond = " (ED.equipment='$sVal') AND DATE(EAD.start_work_time)='$sDate'".$shiftCondition;
		// else if($equipment=="Yard")
			// if($shift=="All")
				// $cond = " (EAD.block='$sVal') AND DATE(EAD.start_work_time)='$sDate'";
			// else
				// $cond = " (EAD.block='$sVal') AND DATE(EAD.start_work_time)='$sDate'".$shiftCondition;
		//echo $cond;
		$sql="SELECT * FROM(
			SELECT * FROM (
			SELECT tbl1.equipement AS equipment,tbl1.Block AS block,tbl2.shift,tbl2.Start_Work_TIME,tbl2.End_Work_TIME,tbl2.Work_Out_Time,tbl2.Duration FROM
			(SELECT DISTINCT  sel_block Block,short_name equipement FROM sparcsn4.xps_che
			INNER JOIN sparcsn4.xps_chezone ON sparcsn4.xps_chezone.che_id=sparcsn4.xps_che.id
			INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=sel_block
			WHERE (short_name LIKE '%%' OR sel_block LIKE '%%'))tbl1
			RIGHT JOIN
			(SELECT ctmsmis.ED.equipment,ctmsmis.EAD.block,ctmsmis.EAD.shift, 
			IFNULL(ctmsmis.EAD.start_work_time,'') AS Start_Work_TIME, 
			IFNULL(ctmsmis.EAD.end_work_time,'') AS End_Work_TIME, 
			IFNULL(ctmsmis.EAD.work_out_time,'') AS Work_Out_Time, 
			CASE EAD.work_out_state WHEN '1' THEN IFNULL(TIMEDIFF(ctmsmis.EAD.work_out_time,ctmsmis.EAD.start_work_time),'') 
			WHEN '0' THEN IFNULL(TIMEDIFF(ctmsmis.EAD.end_work_time,ctmsmis.EAD.start_work_time),'') END AS Duration 
			FROM ctmsmis.mis_equip_assign_detail AS EAD 
			INNER JOIN ctmsmis.mis_equip_detail AS ED ON EAD.equip_detail_id=ED.id

			WHERE  DATE(EAD.start_work_time) BETWEEN '$from_date' AND '$to_date' ORDER BY ctmsmis.ED.equipment,ctmsmis.EAD.block
			)tbl2
			ON tbl1.equipement=tbl2.equipment
			WHERE tbl2.Duration = ''
			) tbl3
			UNION
			(SELECT ctmsmis.ED.equipment,ctmsmis.EAD.block,ctmsmis.EAD.shift, 
			IFNULL(ctmsmis.EAD.start_work_time,'') AS Start_Work_TIME, 
			IFNULL(ctmsmis.EAD.end_work_time,'') AS End_Work_TIME, 
			IFNULL(ctmsmis.EAD.work_out_time,'') AS Work_Out_Time, 
			CASE EAD.work_out_state WHEN '1' THEN IFNULL(TIMEDIFF(ctmsmis.EAD.work_out_time,ctmsmis.EAD.start_work_time),'') 
			WHEN '0' THEN IFNULL(TIMEDIFF(ctmsmis.EAD.end_work_time,ctmsmis.EAD.start_work_time),'') END AS Duration 
			FROM ctmsmis.mis_equip_assign_detail AS EAD 
			INNER JOIN ctmsmis.mis_equip_detail AS ED ON EAD.equip_detail_id=ED.id

			WHERE  DATE(EAD.start_work_time) BETWEEN '$from_date' AND '$to_date') 
			ORDER BY equipment,block
			) AS tbl4 WHERE equipment='$search_value' ORDER BY Start_Work_TIME";
								
								//echo $sql;
	/*	
		$sql="SELECT ctmsmis.ED.equipment,ctmsmis.EAD.block,ctmsmis.EAD.shift, 
					IFNULL(ctmsmis.EAD.start_work_time,'') as Start_Work_TIME, 
					IFNULL(ctmsmis.EAD.end_work_time,'') as End_Work_TIME, 
					IFNULL(ctmsmis.EAD.work_out_time,'') AS Work_Out_Time, 
					CASE EAD.work_out_state WHEN '1' then IFNULL(TIMEDIFF(ctmsmis.EAD.work_out_time,ctmsmis.EAD.start_work_time),'') 
					WHEN '0' then IFNULL(TIMEDIFF(ctmsmis.EAD.end_work_time,ctmsmis.EAD.start_work_time),'') END AS Duration 
					FROM ctmsmis.mis_equip_assign_detail AS EAD 
					INNER JOIN ctmsmis.mis_equip_detail AS ED ON EAD.equip_detail_id=ED.id 
					WHERE ".$cond." order by ctmsmis.ED.equipment"; */
		
		/*if($equipment=="Equipment")
		{
			$sql="SELECT ctmsmis.ED.equipment,ctmsmis.EAD.block,ctmsmis.EAD.shift, 
					IFNULL(ctmsmis.EAD.start_work_time,'') as Start_Work_TIME, 
					IFNULL(ctmsmis.EAD.end_work_time,'') as End_Work_TIME, 
					IFNULL(ctmsmis.EAD.work_out_time,'') AS Work_Out_Time, 
					CASE EAD.work_out_state WHEN '1' then IFNULL(TIMEDIFF(ctmsmis.EAD.work_out_time,ctmsmis.EAD.start_work_time),'') 
					WHEN '0' then IFNULL(TIMEDIFF(ctmsmis.EAD.end_work_time,ctmsmis.EAD.start_work_time),'') END AS Duration 
					FROM ctmsmis.mis_equip_assign_detail AS EAD 
					INNER JOIN ctmsmis.mis_equip_detail AS ED ON EAD.equip_detail_id=ED.id 
					WHERE (ED.equipment='$sVal') AND DATE(EAD.start_work_time)='$sDate'";
		}
		else if($equipment=="Yard")
		{
			$sql="SELECT ctmsmis.ED.equipment,ctmsmis.EAD.block,ctmsmis.EAD.shift, 
					IFNULL(ctmsmis.EAD.start_work_time,'') as Start_Work_TIME, 
					IFNULL(ctmsmis.EAD.end_work_time,'') as End_Work_TIME, 
					IFNULL(ctmsmis.EAD.work_out_time,'') AS Work_Out_Time, 
					CASE EAD.work_out_state WHEN '1' then IFNULL(TIMEDIFF(ctmsmis.EAD.work_out_time,ctmsmis.EAD.start_work_time),'') 
					WHEN '0' then IFNULL(TIMEDIFF(ctmsmis.EAD.end_work_time,ctmsmis.EAD.start_work_time),'') END AS Duration 
					FROM ctmsmis.mis_equip_assign_detail AS EAD 
					INNER JOIN ctmsmis.mis_equip_detail AS ED ON EAD.equip_detail_id=ED.id 
					WHERE (EAD.block='$sVal') AND DATE(EAD.start_work_time)='$sDate'";
		}*/

		$sqlRslt=mysql_query($sql,$con_sparcsn4);								
	?>
			
		<table width="100%">
			<tr>
				<td align="center">
					<img src="<?php echo IMG_PATH;?>cpa.png">
					<h1>Monthly Equipment Booking Report</h1>
				</td>
			<tr>
			<tr>
				<td align="center">
								<h3>
								<?php 
									echo "Date From : ".$from_date." To : ".$to_date;
									// $strTitle = "";
									// if($equipment=="All")
										// $strTitle = "Search From :".$from_date;
									// else
										// $strTitle = "Search For :".$sVal."<br>Search Date :".$sDate;
									// echo $strTitle;
								?>
								</h3>
				</td>
				</tr>
				<!--tr>
				<td align="left"><h3> GCB Equipment</h3></th></td>
				</tr-->
			</tr>
		</table>
					<!---- GCB Equipment Starts -->
			<table width="100%" border=1  cellspacing="0" cellpadding="0">
					<thead>
					<tr>
						
						<th align="center">Block</th>
						<th align="center">Shift</th>						
						<th align="center">Start Work</th>
						<th align="center">End Work</th>						
						<th align="center">Work Out</th>
						<th align="center">Duration</th>													
					</tr>
					</thead>
					<?php
					$eq = "";
					while ($row=mysql_fetch_object($sqlRslt))						
					{
						//echo "Equipment : ".$row->equipment;
						if($eq!=$row->equipment)
						{
					?>
						<tr>
							    <th  align="left" colspan="6">Equipment : <?php if($row->equipment) print($row->equipment); else print("&nbsp;");?></th>
						</tr>
						
					<?php
						}
					?>
						 <tr>
							<td  align="center"><?php if($row->block) print($row->block); else print("&nbsp;");?></td>
							<td  align="center"><?php if($row->shift) print($row->shift); else print("&nbsp;");?></td>
							<td  align="center"><?php if($row->Start_Work_TIME) print($row->Start_Work_TIME); else print("&nbsp;");?></td>
							<td  align="center"><?php if($row->End_Work_TIME) print($row->End_Work_TIME); else print("&nbsp;");?></td>
							<td  align="center"><?php if($row->Work_Out_Time) print($row->Work_Out_Time); else print("&nbsp;");?></td>
							<td  align="center"><?php if($row->Duration) print($row->Duration); else print("&nbsp;");?></td>
						</tr>					 
					<?php 
						$eq = $row->equipment;
					}
					?>
			</table> 
<?php 
mysql_close($con_cchaportdb);
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>		
	</BODY>
</HTML>
<?php }?>
