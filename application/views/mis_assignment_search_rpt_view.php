<html>
	<head>
		
	</head>
	<body>
		<div>	
			<?php include("dbConection.php");?>
			<?php 
				if($search_by=="date")
				{
					$cond= " DATE(propose_date)='$search_val'";
					$head="Search Date : ".$search_val;
				}
				else if($search_by=="bl_no")
				{
					$cond= " BL_No='$search_val'";
					$head="Search BL : ".$search_val;
				}
				else if($search_by=="user")
				{
					$cond= " DATE(propose_date)='$search_val_dt' AND updated_by='$search_val'";
					$head="Search Date : ".$search_val_dt." And User : ".$search_val;
				}
			?>
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
								<td colspan="7"><font size="4"><b><u>ASSIGNMENT REPORT</u></b></font></td>
							</tr>
							
							<tr align="center">
								<td colspan="7"><font size="4"><b><?php echo $head; ?></b></font></td>
							</tr>

						</table>
					
					</td>
					
				</tr>
				
				<tr bgcolor="#ffffff" align="center" height="25px">
					<td colspan="15" align="center"></td>
					
				</tr>
			</table>
			<table width="100%" border ='1' cellpadding='1' cellspacing='1'>
			<tr align="center" bgcolor="grey">
				<td style="border-width:1px;border-style: double;" ><b>SL</b></td>
				<td style="border-width:1px;border-style: double;"><b>CONTAINER NO</b></td>
				<td style="border-width:1px;border-style: double;" ><b>CNF</b></td>
				<td style="border-width:1px;border-style: double;" ><b>MOBILE NO</b></td>
				<td style="border-width:1px;border-style: double;" ><b>BL</b></td>
				<td style="border-width:1px;border-style: double;" ><b>ROTATION</b></td>
				<td style="border-width:1px;border-style: double;" ><b>ASSIGNMENT TYPE</b></td>
				<td style="border-width:1px;border-style: double;" ><b>STRIPING PROPOSE DATE</b></td>
				<td style="border-width:1px;border-style: double;" ><b>USER</b></td>
				<!--td style="border-width:1px;border-style: double;" ><b>LINE NO</b></td-->
				<td style="border-width:1px;border-style: double;" ><b>REMARKS</b></td>
			</tr>

		<?php
			$strAssignment= "";
			if($login_id=="admin")
			{
				$strAssignment= "SELECT cont_id,ref_bizunit_scoped.name AS consignee,BL_No,rotation,mfdch_value,propose_date,mis_assignment_entry.unit_gkey,phone_number,
				IFNULL(remarks,'') AS remarks,updated_by,snx_stat
				FROM ctmsmis.mis_assignment_entry 
				LEFT JOIN sparcsn4.ref_bizunit_scoped ON mis_assignment_entry.consignee=ref_bizunit_scoped.id where snx_stat=0 AND ".$cond."
				ORDER BY propose_date DESC";
			}
			else {
				$strAssignment= "SELECT cont_id,ref_bizunit_scoped.name AS consignee,BL_No,rotation,mfdch_value,propose_date,mis_assignment_entry.unit_gkey,phone_number,
				IFNULL(remarks,'') AS remarks,updated_by,snx_stat
				FROM ctmsmis.mis_assignment_entry 
				LEFT JOIN sparcsn4.ref_bizunit_scoped ON mis_assignment_entry.consignee=ref_bizunit_scoped.id where ".$cond."
				ORDER BY propose_date DESC";
			}
			//echo $strAssignment;
			$queryAssignment=mysql_query($strAssignment);
			$i=0;
			while($rowAssignment=mysql_fetch_object($queryAssignment))
			{
			$i++;
			
			
			include("mydbPConnection.php");
			
			$strLineNumber="SELECT Line_No FROM cchaportdb.igm_details WHERE BL_No='".$rowAssignment->BL_No."'";
			
			//echo $strLineNumber;
			$queryLineNumber=mysql_query($strLineNumber);
			$rowLine=mysql_fetch_object($queryLineNumber);
		?>
		<tr align="center" <?php if($rowAssignment->snx_stat==1){?> style="background:#BDF5CB;" <?php } ?> >
				<td><?php echo $i;?></td>
				<td><?php echo $rowAssignment->cont_id; ?></td>
				<td><?php echo $rowAssignment->consignee; ?></td>
				<td><?php echo $rowAssignment->phone_number; ?></td>
				<td><?php echo $rowAssignment->BL_No; ?></td>
				<td><?php echo $rowAssignment->rotation; ?></td>
				<td><?php echo $rowAssignment->mfdch_value; ?></td>
				<td><?php echo $rowAssignment->propose_date; ?></td>
				<td><?php echo $rowAssignment->updated_by; ?></td>
				<!--td><?php echo $rowLine->Line_No; ?></td-->
				<td><?php if($rowAssignment->remarks!='null') echo $rowAssignment->remarks; else echo "&nbsp;";?></td>
			</tr>
		<?php 
			//}
		} 
		?>		
		</table>
		<br />
		<?php if($login_id=="admin"){?>
		<table align="center">
			<tr><td><a href="<?php echo site_url('report/downloadAssignmentSnx') ?>">Download SNX</a></td></tr>
		</table>
		<?php } ?>
		</div>
	</body>
</html>