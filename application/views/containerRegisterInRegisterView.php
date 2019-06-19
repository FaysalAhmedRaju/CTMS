<div align ="center" style="margin:100px;">

	<!--div align="center" style="font-size:18px">
			<title><img align="middle"  width="220px" height="70px" src="<?php echo IMG_PATH?>cpanew.jpg"></title>
	</div>
		<div align="center"><font size="5"><b>INWARD & OUTWARD CONTAINER REGISTER</b></font></div-->

	<table width="100%">
	  <thead>
		<tr height="100px">
			<th align="center" colspan="10">
				<h2><img align="middle"  width="235px" height="75px" src="<?php echo IMG_PATH?>cpanew.jpg"></h2>
			</th>
		</tr>
		<tr bgcolor="#ffffff" height="50px">
			<th align="center" colspan="10"><font size="5"><b>INWARD & OUTWARD CONTAINER REGISTER</b></font></th>
		</tr>
		<tr bgcolor="#ffffff" height="50px"  colspan="10">
			<th colspan="2" align="left"><font size="5"><b><?php echo "Gate:  ". $gateResult[0]['id'];?></b></font></td>
			<th colspan="3" align="center"><font size="5"><b>File No: </b></font></td>
			<th colspan="3" ><font size="5"><b>Duty Hours:</b></font></td>
			<th colspan="2" align="right"><font size="5"><b><?php echo "Date:  ". $date; ?></b></font></td>
		</tr>
		
		<?php 
				$loadin=0;
				$loadout=0;
				$mtyin=0;
				$mtyout=0;
		?>
		
		<tr>
			<th rowspan="2" style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b>SL.</b></th>
			<th rowspan="2" style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b>VEHICLE.NO</b></th>
			<th rowspan="2" style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b>CONTAINER.NO.</b></th>
			<th rowspan="2" style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b>SIZE</b></th>
			<th rowspan="2" style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b>SHIPPING AGENT/C&F AGENT</b></th>
			<!--td rowspan="2"><b>SHIPPING AGENT/C&F AGENT</b></td-->
			<th colspan="2" style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b><nobr>LOAD CONT</nobr></b></th>
			<th colspan="2" style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b><nobr>EMPTY CONT</nobr></b></th>
			<th rowspan="2" style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b>EIR NO:-M/GATE PASS NO</b></th>
			<th rowspan="2" style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b>SIGNATURE OF </BR>J/S & A/REPRESTATIVE </b></th>
		</tr>
		<tr>
		    <th style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center" width="8%"><b>IN</b></th>
		    <th style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center" width="8%"><b>OUT<b></th>	    
			<th style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center" width="8%"><b>IN</b></th>
		    <th style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center" width="8%"><b>OUT</b></th>
		</tr>
		</thead>
		

		<?php
			//	include_once("mydbPConnection.php");
			for($i=0;$i<count($result);$i++) { 
			?>
				<tr border ='1' cellpadding='0' cellspacing='0' style="font-size:12px;  border-collapse: collapse;">
					<td  style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $i+1;?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $result[$i]['truck_license_nbr']?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $result[$i]['ctr_id']?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $result[$i]['size']?>
					</td>	
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $result[$i]['line_id']?>
					</td>										
					<!--td style="text-align:center">
						<?php echo $result[$i]['time_in']?>
					</td-->
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php if ($result[$i]['ctr_freight_kind']!="MTY" && $result[$i]['stage_id']=="In Gate"){ echo "---"; $loadin++; } else  echo "";?>
					</td>										
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php if ($result[$i]['ctr_freight_kind']!="MTY" && $result[$i]['stage_id']=="Out Gate") { echo "---"; $loadout++; } else  echo "";?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php if ($result[$i]['ctr_freight_kind']=="MTY" && $result[$i]['stage_id']=="In Gate") { echo "---"; $mtyin++; }else  echo "";?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php if ($result[$i]['ctr_freight_kind']=="MTY" && $result[$i]['stage_id']=="Out Gate") { echo "---"; $mtyout++; }else  echo "";?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $result[$i]['nbr']; ?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						
					</td>									
				</tr>
			<?php
			}
		?>
		<!--tr><td colspan='5' border='0'>Total Container :</td></tr-->
		<tr bgcolor="#ffffff" height="50px">
			<th align="center" colspan="10">&nbsp;</th>
		</tr>
		<tr bgcolor="#ffffff" height="50px">
			<th align="center" colspan="10">&nbsp;</th>
		</tr>
		<tr bgcolor="#ffffff" height="50px">
			<th align="center" colspan="10"><font size="5"><b>INWARD & OUTWARD CONTAINER REGISTER SUMMARY IN <?php echo "GATE:  ". $gateResult[0]['id'];?> </b></font></th>
		</tr>
		<tr>
			<td  align="center" colspan="10">
				<table border="1" style="border-collapse:collapse; font-size:12px;" >
					<tr>
						<td colspan='2'>LOAD</td>
						<td colspan='2'>EMPTY</td>
						<td colspan='2' align='center'>TOTAL</td>
					</tr>
					<tr>
						<td>IN</td>
						<td>OUT</td>
						<td>IN</td>
						<td>OUT</td>
						<td>IN</td>
						<td>OUT</td>
					</tr>
					<tr>
						<td><?php echo $loadin; ?></td>
						<td><?php echo $loadout; ?></td>
						<td><?php echo $mtyin; ?></td>
						<td><?php echo $mtyout; ?></td>
						<td><?php echo $loadin+$mtyin; ?></td>
						<td><?php echo $loadout+$mtyout; ?></td>
					</tr>
				</table>
			
			</td>
		
		
		</tr>
		
	</table>
</div>