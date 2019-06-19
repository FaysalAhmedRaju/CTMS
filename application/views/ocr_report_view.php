<table width="100%" border="0">
	<tr height="100px">
		<td align="center" valign="middle">
			<h1>Chittagong Port Authority</h1>
			<h3>OCR Report for<?php echo " ".$dest;?></h3>
			<h3><?php echo "From: ".$from_dt." To: ".$to_dt;?></h3>
		</td>
	</tr>
</table>
<?php
if($search_by=="ocd")
{
?>
<table style="border-collapse:collapse;width:80%" border="1" align="center" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th>Sl</th>
			<th>Container</th>							
			<th>Freight Kind</th>
			<th>EIR Taken</th>							
			<th>Out Time</th>
			<?php
		//	if($search_by=="ocd")
		//	{
			?>
			<th>Assign Date</th>
			<th>C&F Name</th>
			<?php
		//	}
		//	else if($search_by=="depo")
		//	{
			?>
			<!--th>Depo Code</th>
			<th>Depo Name</th-->
			<?php
		//	}
			?>
			<th>Trailer No</th>
			<th>License No</th>
			<th>Time Difference</th>
		</tr>
	</thead>
	
	<?php
	for($i=0;$i<count($rslt_ocr_report);$i++) 
	{ 
	?>
	<tr>
		<td align="center">
			<?php echo $i+1;?>
		</td>
		<td align="center">
			<?php echo $rslt_ocr_report[$i]['cont_number']?>
		</td>
		<td align="center">
			<?php echo $rslt_ocr_report[$i]['freight_kind']?>
		</td>
		<td align="center">
			<?php echo $rslt_ocr_report[$i]['eir_taken']?>
		</td>
		<td align="center">
			<?php echo $rslt_ocr_report[$i]['out_time']?>
		</td>										
		<?php
	//	if($search_by=="ocd")
	//	{
		?>
		<td align="center">
			<?php echo $rslt_ocr_report[$i]['assign_dt']?>
		</td>
		<td align="center">
			<?php echo $rslt_ocr_report[$i]['cf_name']?>
		</td>
		<?php
	//	}
	//	else if($search_by=="depo")
	//	{
		?>
		<!--td align="center">
			<?php echo $rslt_ocr_report[$i]['depo_code']?>
		</td>
		<td align="center">
			<?php echo $rslt_ocr_report[$i]['depo_name']?>
		</td-->
		<?php
	//	}
		?>
		<td align="center">
			<?php echo $rslt_ocr_report[$i]['trailer_no']?>
		</td>
		<td align="center">
			<?php echo $rslt_ocr_report[$i]['truck_license_nbr']?>
		</td>
		<td align="center">
			<?php echo $rslt_ocr_report[$i]['time_diff']?>
		</td>										
	</tr>
	<?php
	}
	?>	
</table>
<?php
}
else if($search_by=="depo")
{	echo count($rslt_ocr_report);
	for($j=0;$j<count($rslt_ocr_report);$j++)
	{
		$off_dock_code=$rslt_ocr_report[$j]['off_dock_code'];
		$depo_code=$rslt_ocr_report[$j]['depo_code'];
		$depo_name=$rslt_ocr_report[$j]['depo_name'];
?>
		<table style="border-collapse:collapse;width:80%" border="1" align="center" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th colspan="8" align="left">Depo Code : <?php echo $depo_code; ?>, Depo Name : <?php echo $depo_name; ?></th>
				</tr>
				<tr>
					<th>Sl</th>
					<th>Container</th>							
					<th>Freight Kind</th>
					<th>EIR Taken</th>							
					<th>Out Time</th>
					<th>Trailer No</th>
					<th>License No</th>
					<th>Time Difference</th>
				</tr>
			</thead>
			<?php
			include('dbConection.php');
			$sql_ocr_report_depo="SELECT unit_gkey,cont_number,freight_kind,
			(SELECT rd.created
			FROM sparcsn4.road_truck_transactions
			INNER JOIN sparcsn4.road_documents rd ON rd.tran_gkey=sparcsn4.road_truck_transactions.gkey
			WHERE sparcsn4.road_truck_transactions.unit_gkey=mis_ocr_info.unit_gkey AND rd.doctype_gkey='7'
			ORDER BY sparcsn4.road_truck_transactions.gkey DESC LIMIT 1) AS eir_taken,
			entry_dt_time AS out_time,
			(SELECT sparcsn4.road_truck_visit_details.bat_nbr
			FROM sparcsn4.road_truck_transactions
			INNER JOIN sparcsn4.road_truck_visit_details ON sparcsn4.road_truck_visit_details.tvdtls_gkey=sparcsn4.road_truck_transactions.truck_visit_gkey
			WHERE sparcsn4.road_truck_transactions.unit_gkey=mis_ocr_info.unit_gkey ORDER BY sparcsn4.road_truck_transactions.gkey LIMIT 1) AS trailer_no,
			(SELECT sparcsn4.road_truck_visit_details.truck_license_nbr
			FROM sparcsn4.road_truck_transactions
			INNER JOIN sparcsn4.road_truck_visit_details ON sparcsn4.road_truck_visit_details.tvdtls_gkey=sparcsn4.road_truck_transactions.truck_visit_gkey
			WHERE sparcsn4.road_truck_transactions.unit_gkey=mis_ocr_info.unit_gkey ORDER BY sparcsn4.road_truck_transactions.gkey LIMIT 1) AS truck_license_nbr,
			TIMEDIFF(entry_dt_time,(SELECT rd.created
			FROM sparcsn4.road_truck_transactions
			INNER JOIN sparcsn4.road_documents rd ON rd.tran_gkey=sparcsn4.road_truck_transactions.gkey
			WHERE sparcsn4.road_truck_transactions.unit_gkey=mis_ocr_info.unit_gkey AND rd.doctype_gkey='7'
			ORDER BY rd.gkey DESC LIMIT 1)) AS time_diff
			FROM ctmsmis.mis_ocr_info
			WHERE off_dock_code='$off_dock_code' AND entry_dt BETWEEN '$from_dt' AND '$to_dt'";
			
			$rslt_ocr_report_depo=mysql_query($sql_ocr_report_depo);
			
			$sl=1;
			while($row_ocr_report_depo=mysql_fetch_object($rslt_ocr_report_depo))
			{
			?>
				<tr>
					<td align="center">
						<?php echo $sl;?>
					</td>
					<td align="center">
						<?php echo $row_ocr_report_depo->cont_number; ?>
					</td>
					<td align="center">
						<?php echo $row_ocr_report_depo->freight_kind; ?>
					</td>
					<td align="center">
						<?php echo $row_ocr_report_depo->eir_taken; ?>
					</td>
					<td align="center">
						<?php echo $row_ocr_report_depo->out_time; ?>
					</td>
					<td align="center">
						<?php echo $row_ocr_report_depo->trailer_no; ?>
					</td>
					<td align="center">
						<?php echo $row_ocr_report_depo->truck_license_nbr; ?>
					</td>
					<td align="center">
						<?php echo $row_ocr_report_depo->time_diff; ?>
					</td>
				</tr>
			<?php
			$sl++;
			}
			?>
				<tr>
					<td colspan="8" align="left">
						<b><?php echo "Total Container : ".mysql_num_rows($rslt_ocr_report_depo); ?></b>
					</td>
				</tr>
		</table>
<?php
	}
	?>
	<br>
<?php
}
?>