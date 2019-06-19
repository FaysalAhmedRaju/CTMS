<html>
	<head>
		 <meta http-equiv="refresh" content="20">
	</head>
	<body>
		<div>	
			<?php include("mydbPConnection.php");?>
			
			<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
			<tr bgcolor="#ffffff" align="center" height="100px">
					<td colspan="13" align="center">
						<table border=0 width="100%">
							<tr align="center">
								<td colspan="7"><img height="100px" src="<?php echo IMG_PATH;?>cpa_logo.png" /></td>
							</tr>
							<tr align="center">
								<td colspan="7"><font size="4"><b> CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td>
							</tr>
						
							<tr align="center">
								<td colspan="7"><font size="4"><b><u>PILOT VESSEL ENTRY REPORT</u></b></font></td>
							</tr>
							
							<tr align="center">
								<td colspan="7"><font size="4"><b></b></font></td>
							</tr>

						</table>
					
					</td>
					
				</tr>
				
				<tr bgcolor="#ffffff" align="center" height="25px">
					<td colspan="13" align="center"></td>					
				</tr>
			</table>
			<div align="center"><?php echo $msg; ?></div>
			<br>
			<table width="100%" border ='1' cellpadding='1' cellspacing='1'>
			<tr align="center" bgcolor="grey">
				<td style="border-width:1px;border-style: double;" ><b>SL</b></td>
				<td style="border-width:1px;border-style: double;"><b>VESSEL NAME</b></td>
				<td style="border-width:1px;border-style: double;" ><b>MASTER NAME</b></td>
				<td style="border-width:1px;border-style: double;" ><b>FLAG</b></td>
				<td style="border-width:1px;border-style: double;" ><b>GRT</b></td>
				<td style="border-width:1px;border-style: double;" ><b>NRT</b></td>
				<td style="border-width:1px;border-style: double;" ><b>DECK CARGO</b></td>
				<td style="border-width:1px;border-style: double;" ><b>LOA</b></td>
				<td style="border-width:1px;border-style: double;" ><b>AGENT</b></td>
				<td style="border-width:1px;border-style: double;" ><b>LAST PORT</b></td>
				<td style="border-width:1px;border-style: double;" ><b>NEXT PORT</b></td>
				<td style="border-width:1px;border-style: double;" ><b>ROTATION</b></td>
				<td style="border-width:1px;border-style: double;" ><b>ACTION</b></td>
			</tr>

		<?php
			$strPilotVesselEntry= "SELECT id,vsl_name,master_name,flag,grt,nrt,deck_cargo,loa,local_agent,last_port,next_port,rotation FROM doc_vsl_info where status=0";
			//echo $strAssignment;
			$queryPilotVsl=mysql_query($strPilotVesselEntry);
			$i=0;
			while($rowPilotVessel=mysql_fetch_object($queryPilotVsl))
			{
			$i++;			
		?>
			<tr align="center">
					<td><?php echo $i;?></td>
					<td><?php echo $rowPilotVessel->vsl_name; ?></td>
					<td><?php echo $rowPilotVessel->master_name; ?></td>
					<td><?php echo $rowPilotVessel->flag; ?></td>
					<td><?php echo $rowPilotVessel->grt; ?></td>
					<td><?php echo $rowPilotVessel->nrt; ?></td>
					<td><?php echo $rowPilotVessel->deck_cargo; ?></td>
					<td><?php echo $rowPilotVessel->loa; ?></td>
					<td><?php echo $rowPilotVessel->local_agent; ?></td>
					<td><?php echo $rowPilotVessel->last_port; ?></td>
					<td><?php echo $rowPilotVessel->next_port; ?></td>
					<td><?php echo $rowPilotVessel->rotation; ?></td>
					<td class="contact-delete">
						<?php if(strtoupper($this->session->userdata('login_id'))==strtoupper($row->user_id) OR strtoupper($this->session->userdata('login_id'))=='ADMIN'){?>
						<form action="<?php echo site_url('report/update_pilot_vsl_status') ?>" method="post" onsubmit="return confirm('Are You Sure To Update Vessel Info?');">
							<input type="hidden" name="vslEntryId" value="<?php if($rowPilotVessel->id) echo $rowPilotVessel->id; ?>">
							<input type="submit" name="submit" value="UPDATE">
						</form>
						<?php }?>
					</td>	

			</tr>
		<?php 
			
		} 
		?>
		</table>
		<br />
		</div>
	</body>
</html>