<html>
	<head>
		
	</head>
	<body>
		<?php 
			//echo $rotation;
			include("dbConection.php");
			$str = "select sparcsn4.vsl_vessels.name,(select ctmsmis.berth_for_vessel(sparcsn4.vsl_vessel_visit_details.vvd_gkey)) as berth
			from sparcsn4.vsl_vessel_visit_details
			inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
			where sparcsn4.vsl_vessel_visit_details.ib_vyg='$rotation'";
			
			$result = mysql_query($str);
			$row = mysql_fetch_object($result);
			$vslName = $row->name;
			$berth = $row->berth;
			$sub = substr($row->berth,0,3);
			
			$str2 = "select *,if(bill_type=101,'JETTY CHARGES ON VESSEL','BILL FOR PORT & PILOTAGE CHARGES ON VESSEL') as bill_name from
			(
			select sparcsn4.srv_event_types.id,sparcsn4.srv_event_types.description,sparcsn4.srv_event.created,sparcsn4.srv_event.creator,
			(select distinct bill_type from ctmsmis.mis_vsl_bill_tarrif where ctmsmis.mis_vsl_bill_tarrif.id=
			if(sparcsn4.srv_event_types.id='PD_SEA_VESSEL',replace(sparcsn4.srv_event_types.id,'_',' '),sparcsn4.srv_event_types.id) 
			and ctmsmis.mis_vsl_bill_tarrif.berth_time=1) as bill_type
			from sparcsn4.vsl_vessel_visit_details
			inner join sparcsn4.srv_event on sparcsn4.srv_event.applied_to_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
			inner join sparcsn4.srv_event_types on sparcsn4.srv_event_types.gkey=sparcsn4.srv_event.event_type_gkey
			where sparcsn4.vsl_vessel_visit_details.ib_vyg='$rotation' and sparcsn4.srv_event.applied_to_class='VV'
			and sparcsn4.srv_event_types.id not like 'UPDATE%' and sparcsn4.srv_event_types.id not like 'PHASE%'
			) as tmp order by bill_type";			
			$result2 = mysql_query($str2);			
		?>
		<table align="center" border="0">
			<tr>
				
			</tr>
			<tr>
				<td>
					<h2 align="center">CHITTAGONG PORT AUTHORITY</h2>
				</td>
			</tr>
			<tr>
				<td>
					<h3 align="center"><?php echo $title;?></h3>
				</td>
			</tr>
			<tr>
				<td>
					<h3 align="center"><?php echo "Rotation : ".$rotation.", Vessel : ".$vslName.", Berth : ".$berth;?></h3>
				</td>
			</tr>
			<tr>
				<td>
					<table border="0" cellspacing="1" cellpadding="5">
						<tr bgcolor="#9999CC">
							<th>Event Id</th><th>Event Description</th><th>Created</th><th>Created By</th>
						</tr>
						<?php 
							$billName = "";
							while($row2 = mysql_fetch_object($result2))
							{							
							if($billName!=$row2->bill_name)
							{
							$billName = $row2->bill_name;
						?>
							<tr bgcolor="#999999">
								<td colspan="4"><?php echo $row2->bill_name;?></td>
							</tr>
						<?php
							}
						?>
							<tr bgcolor="#CCCCCC">
								<td><?php echo $row2->id;?></td>
								<td><?php echo $row2->description;?></td>
								<td><?php echo $row2->created;?></td>
								<td><?php echo $row2->creator;?></td>
							</tr>
						<?php 
							}
							if($sub=="CCT")
							{
						?>						
							<tr bgcolor="#999999">
								<td colspan="4"><?php echo "GANTRY CRANE CHARGES ON CONTAINER";?></td>
							</tr>
						<?php 
							}
						?>
					</table>
				</td>
			</tr>
		</table>
		<?php mysql_close($con_sparcsn4);?>
	</body>
</html>