
<table width="100%"  align="center" cellpadding='0' cellspacing='0' border="1">
	<tr  height="100px">
		<td align="center" valign="middle" colspan="14" >
			<h1><font color="black">Chittagong Port Authority</font></h1>
		</td>
	</tr>
	<tr bgcolor="#ffffff" align="center" height="50px">
		<td colspan="14" align="center"><font color="green" size="4"><b><?php echo $title;?></b></font></td>
	</tr>

			<?php
			
			
			$rotNo=$rtnVerifyReport[0][Import_Rotation_No];
			$contNo=$rtnVerifyReport[0][cont_number];
			include("dbConection.php");
			
		
			$sqlYardPosition=mysql_query("select fcy_time_in,fcy_last_pos_slot,fcy_position_name,yard,fcy_time_out,(select ctmsmis.cont_block(fcy_last_pos_slot,yard)) as block from (
											select time_in as fcy_time_in,last_pos_slot as fcy_last_pos_slot,last_pos_name as fcy_position_name,ctmsmis.cont_yard(last_pos_slot) as yard,time_out as fcy_time_out from inv_unit a
												inner join 
											inv_unit_fcy_visit on inv_unit_fcy_visit.unit_gkey=a.gkey
													inner join
											 argo_carrier_visit h ON (h.gkey = a.declrd_ib_cv or h.gkey = a.cv_gkey)
													inner join
												argo_visit_details i ON h.cvcvd_gkey = i.gkey
													inner join
												vsl_vessel_visit_details ww ON ww.vvd_gkey = i.gkey where ib_vyg='$rotNo' and a.id='$contNo'
											) as  tmp"
										);
			

			
			$rtnYardPosition=mysql_fetch_object($sqlYardPosition);
			
			//echo $rtnYardPosition->fcy_time_in."<hr>";
			
		?>
	
	

             <tr class="gridLight">
						<th width="100px" align="left"><nobr>Discharge Time</nobr></th><th>:</th><td><?php print($rtnYardPosition->fcy_time_out); ?></td>
						<th width="100px" align="left">Container</th><th>:</th><td><?php print($rtnVerifyReport[0]['cont_number']);  ?></td>
						<th width="100px" align="left"><nobr>Receive Pack</nobr></th><th>:</th><td><?php print($rtnVerifyReport[0]['rcv_pack']); ?></td>
					</tr >
             <tr><td>&nbsp;</td></tr>
					<tr class="gridLight">
						<th align="left"><nobr>Marks & Number</nobr></th><th>:</th><td><?php echo str_replace(',',', ',$rtnVerifyReport[0]['Pack_Marks_Number']); ?></td>
						<th width="150px" align="left"><nobr>Consignee Description</nobr></th><th>:</th><td><?php print($rtnVerifyReport[0]['ConsigneeDesc']);  ?></td>
						<th align="left"><nobr>Notify Description</nobr></th><th>:</th><td><?php print($rtnVerifyReport[0]['NotifyDesc']); ?></td>
					</tr>
				<tr><td>&nbsp;</td></tr>	
					<tr class="gridLight">	
						<th align="left">Yard</th><th>:</th><td><?php print($rtnVerifyReport[0]['shed_yard']);   ?></td>
						<th align="left">Position</th><th>:</th><td><?php print($rtnVerifyReport[0]['shed_loc']);  ?></td>
						<th align="left"><nobr>Container Type</nobr></th><th>:</th><td><?php print($rtnVerifyReport[0]['cont_iso_type']); ?></td>
				
					</tr>
				<tr><td>&nbsp;</td></tr>	
					<tr class="gridLight">
						<th align="left">Status</th><th>:</th><td><?php print($rtnVerifyReport[0]['cont_status']); ?></td>
						<th align="left"><nobr>Discharge Time</nobr></th><th>:</th><td><?php print($rtnYardPosition->fcy_time_in); ?></td>
						<th align="left">Destination</th><th>:</th><td><?php print($rtnVerifyReport[0]['off_dock_id']); ?></td>
						
						
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr class="gridLight">
					
						<th align="left"><nobr>Offdock Name</nobr></th><th>:</th><td><?php print($rtnVerifyReport[0]['offdock_name']); ?></td>
						<th align="left">Rotation</th><th>:</th><td><?php print($rtnVerifyReport[0]['import_rotation']); ?></td>
						<th align="left">Seal</th><th>:</th><td><?php print($rtnVerifyReport[0]['cont_seal_number']); ?></td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr class="gridLight">
						<th align="left">Size</th><th>:</th><td><?php print($rtnVerifyReport[0]['cont_size']); ?></td>
						<th align="left">Height</th><th>:</th><td><?php print($rtnVerifyReport[0]['cont_height']); ?></td>

					</tr>
</table>
