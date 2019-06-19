
<div align ="center" style="margin:100px;">


	<table width="100%">
	  <thead>
		<tr height="100px">
			<th align="center" colspan="10">
				<h2><img align="middle"  width="235px" height="75px" src="<?php echo IMG_PATH?>cpanew.jpg"></h2>
			</th>
		</tr>
		<tr bgcolor="#ffffff" height="50px">
			<th align="center" colspan="10"><font size="5"><b><?php echo $tableTitle; ?></b></font></th>
		</tr>
		
		
		<tr>
			<th style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b>SL.</b></th>
			<th style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b><nobr>Container No.<nobr></b></th>
			<th style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b><nobr>Container Type<nobr></b></th>
			<th style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b><nobr>Num. of Truck<nobr></b></th>
			<th style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b><nobr>Truck No<nobr></b></th>
			<!--td rowspan="2"><b>SHIPPING AGENT/C&F AGENT</b></td-->
			<th style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b><nobr>Entrance Gate<nobr></b></th>
			<th style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b><nobr>Entrance Date</nobr></b></th>
			<th style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b><nobr>Status</nobr></b></th>
		</tr>

		</thead>
		

		<?php
			//	include_once("mydbPConnection.php");
			for($i=0;$i<count($list);$i++) { 
			?>
				<tr border ='1' cellpadding='0' cellspacing='0' style="font-size:12px;  border-collapse: collapse;">
					<td  style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $i+1;?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $list[$i]['cont_id']?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $list[$i]['assign_type']?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $list[$i]['number_of_truck']?>
					</td>										
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $list[$i]['truck_number']?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $list[$i]['entrance_gate']; ?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $list[$i]['entrance_date']; ?>
					</td>										
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php if($list[$i]['cont_wise_truck_dtl']==1) echo "Verified";  else echo "Not Verified"; ?>					
					</td>
					<!--td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php if ($result[$i]['ctr_freight_kind']=="MTY" && $result[$i]['stage_id']=="In Gate") { echo "---"; $mtyin++; }else  echo "";?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php if ($result[$i]['ctr_freight_kind']=="MTY" && $result[$i]['stage_id']=="Out Gate") { echo "---"; $mtyout++; }else  echo "";?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $result[$i]['nbr']; ?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						
					</td-->									
				</tr>
			<?php
			}
		?>

		
	</table>
</div>
