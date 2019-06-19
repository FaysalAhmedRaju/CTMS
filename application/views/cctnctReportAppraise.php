<html>
	<body>
		<?php
		include("mydbPConnectionn4.php");		
		include("mydbPConnection.php");
		$assignType="";			
		$length=count($rsltNCTCCT);
		for($i=0;$i<$length;$i++)
		{ 		
		$mfdch_value = $rsltNCTCCT[$i]['mfdch_value'];
		$mfdch_desc = $rsltNCTCCT[$i]['mfdch_desc'];
		?>
		<div class="pagewidth">
			<table border="0" cellspacing="0" width="1000px">
				<thead>
					<tr>
						<td colspan="4" align="center"><img width="200px" height="60px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
					</tr>
					<tr>
						<td colspan="4" align="center"><h3>OFFICE OF THE TERMINAL MANAGER</h3></td>
					</tr>
					<tr>
						<td colspan="4" align="center"><h3>HEAD DELIVERY REGISTER REPORT OF <?php echo $terminal?></h3></td>
					</tr>
					<tr>
						<td colspan="4" align="center"><h3>Date: <?php echo $date?></h3></td>
					</tr>
					<tr>
						<td colspan="4" style="font-size:16px;"><b><?php echo "Assignment (Delivery): ".$mfdch_desc; ?></b></td>
					</tr>
				</thead>				
				<?php 
				$strAllData = "SELECT DISTINCT * FROM ctmsmis.tmp_assignment_type_new
				WHERE mfdch_value='$mfdch_value' and Yard_No='$terminal' ORDER BY Yard_No,mfdch_value,flex_date01,line_no";
				$resAllData = mysql_query($strAllData,$con_sparcsn4);
				$j=0;
				$cnf="";
				$bl="";
				$t20=0;
				$t40=0;
				$tot = 0;
				
				while($rowAllData = mysql_fetch_object($resAllData))
				{
					$tot++;
					if($cnf!=$rowAllData->cf or $bl!=$rowAllData->line_no)
					{
						$j = $j+1;
						$cnf=$rowAllData->cf;
						$bl=$rowAllData->line_no;
						
					?>
					<tr>
						<td style="border:1px solid black;font-size:11px;" align="center" height="30px" width="20px"><b><?php echo $j;?></b></td>
						<td style="border:1px solid black;font-size:11px;" colspan="3" height="30px"><b><?php echo "C&F: ".$rowAllData->cf.", Vessel: ".$rowAllData->v_name.", Rotation: ".$rowAllData->rot_no.", BL No: ".$rowAllData->bl_no;?></b></td>
					</tr>
					<?php
					$rotation=$rowAllData->rot_no;
					$blno=$rowAllData->bl_no;
					
					$sql_stc="SELECT CONCAT(Pack_Number,' ',Pack_Description) AS stc,concat(weight,' KG') as weight FROM igm_details WHERE Import_Rotation_No='$rotation' AND replace(BL_No,'/','')='$blno'";
					
					$rslt_stc=mysql_query($sql_stc,$con_cchaportdb);
					$num_row=mysql_num_rows($rslt_stc);
					if($num_row==0)
					{
						$sql_stc="SELECT CONCAT(Pack_Number,' ',Pack_Description) AS stc,concat(weight,' KG') as weight FROM igm_supplimentary_detail WHERE Import_Rotation_No='$rotation' AND replace(BL_No,'/','')='$blno'";
						
						$rslt_stc=mysql_query($sql_stc,$con_cchaportdb);
					}
					$row=mysql_fetch_object($rslt_stc);
					?>
					<tr>
						<td style="border:1px solid black"></td>
						<td style="border:1px solid black;padding:0px;margin:0px;" colspan="3" height="40px">
							<table border="0" cellpadding="3" valign="top">
								<tr>
									<td width="50px"><b>B/E No:</b></td>
									<td width="200px">&nbsp;</td>
									<td width="80px"><b>B/E Date:</b></td>
									<td width="100px">&nbsp;</td>
									<td width="50px"><b>STC:</b></td>
									<td width="130px"><?php echo $row->stc;?></td>
								</tr>
								<tr>
									<td width="50px"><b>CP No:</b></td>
									<td width="200px">&nbsp;</td>
									<td width="80px"><b>CP Date:</b></td>
									<td width="100px">&nbsp;</td>
									<td width="50px"><b>Weight:</b></td>
									<td width="130px"><?php echo $row->weight;?></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="border:1px solid black" align="center" height="20px">&nbsp;</td>
						<td style="border:1px solid black" align="center" width="120px" height="20px"><b>Cont No.</b></td>
						<td style="border:1px solid black" align="center" width="450px" height="20px"><b>Cart Details</b></td>
						<!--td style="border:1px solid black" align="center">From</td-->
						<td style="border:1px solid black" align="center" width="100px" height="20px"><b>Signature & Mobile</b></td>
					</tr>
					<?php
					}
					
					if($rowAllData->size==20)
						$t20 += 1;
					else
						$t40 += 1;
				?>
					
					<tr>
						<td style="border:1px solid black" align="center" height="70px">&nbsp;</td>						
						<td style="border:1px solid black" height="70px" align="center"><?php echo $rowAllData->cont_no." x ".$rowAllData->size."'"; ?></td>
						<td style="border:1px solid black" height="70px"></td>
						<td style="border:1px solid black" height="70px"></td>
						<!--td style="border:1px solid black"><?php echo $rowAllData->slot; ?></td>
						<td style="border:1px solid black" align="center"><?php echo $rowAllData->remarks; ?></td-->
					</tr>
				<?php
				}
				?>
					<!--tr><td colspan="5"><hr></td></tr-->
					<tr>
						<!--td>Total:</td>
						<td><?php echo $tot; ?></td>
						<td align="right">20 FT:</td>
						<td><?php echo $t20; ?></td>
						<td align="right">40 FT:</td>
						<td><?php echo $t40; ?></td>
						<td align="right">TEUS:</td>
						<td><?php echo $t20+$t40*2; ?></td-->
					</tr>
			</table>
		</div>
			<?php
			if($i==$length-1)
			{ 
			?>
				<div class="pageBreakOff"></div>
			<?php
			 }
			else if($i<$length)  
			{ 
			?>
				<div class="pageBreak"></div>
			<?php
			}
			?>
		<?php
		}
		?>
	</body>
</html>