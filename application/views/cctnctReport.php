<html>
	<body>
		<?php
		include("mydbPConnectionn4.php");		
		$assignType="";			
		$length=count($rsltNCTCCT);
		for($i=0;$i<$length;$i++)
		{ 		
		$mfdch_value = $rsltNCTCCT[$i]['mfdch_value'];
		$mfdch_desc = $rsltNCTCCT[$i]['mfdch_desc'];
		?>
		<div class="pagewidth">
			<table border="0" cellspacing="0">
				<thead>
					<tr>
						<!--td colspan="12" align="center"><font size="5">CHITTAGONG PORT AUTHORITY</font></td-->
						<td colspan="12" align="center"><img width="200px" height="60px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
					</tr>
					<tr>
						<td colspan="12" align="center">OFFICE OF THE TERMINAL MANAGER</td>
					</tr>
					<tr>
						<td colspan="12" align="center">DELIVERY REPORT OF <?php echo $terminal?></td>
					</tr>
					<tr>
						<td colspan="8" style="padding-left:320px">Date: <?php echo $date?></td>
						<td colspan="4">Printed: <?php echo date('d/m/Y h:i:s')?></td>
					</tr>
					<tr>
						<td colspan="12"><b><?php echo "Assignment (Delivery): ".$mfdch_desc; ?></b></td>
					</tr>
					<tr>
						<td style="border:1px solid black" align="center" width="10px">SL</td>
						<td style="border:1px solid black" align="center" width="150px">C & F Agent</td>
						<td style="border:1px solid black" align="center" width="120px">Vessel Name</td>
						<td style="border:1px solid black" align="center" width="50px">Rot.No</td>
						<td style="border:1px solid black" align="center" width="50px">MLO</td>
						<td style="border:1px solid black" align="center" width="50px">Seal No</td>
						<td style="border:1px solid black" align="center"><font size="2">DLV(Y/N)</font></td>
						<td style="border:1px solid black" align="center" >Cont No.</td>
						<td style="border:1px solid black" align="center">Sz</td>
						<td style="border:1px solid black" align="center">Ht</td>
						<td style="border:1px solid black" align="center" width="50px">BL No.</td>
						<td style="border:1px solid black" align="center">From</td>
						<td style="border:1px solid black" align="center" width="50px">Remarks</td>
					</tr>
				</thead>				
				<?php 
				$strAllData = "SELECT DISTINCT * FROM ctmsmis.tmp_assignment_type_new
				WHERE mfdch_value='$mfdch_value' and Yard_No='$terminal' ORDER BY Yard_No,mfdch_value,flex_date01,line_no";
				$resAllData = mysql_query($strAllData);
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
					}
					
					if($rowAllData->size==20)
						$t20 += 1;
					else
						$t40 += 1;
				?>
					<tr>
						<td align="center"><?php echo $j;?></td>
						<td><?php echo $rowAllData->cf; ?></td>
						<td><?php echo $rowAllData->v_name; ?></td>
						<td><?php echo $rowAllData->rot_no; ?></td>
						<td align="center"><?php echo $rowAllData->mlo; ?></td>
						<td align="center"><?php echo $rowAllData->seal_nbr1; ?></td>							
						<?php
							$cont_no=$rowAllData->cont_no;
							$cont_no=str_replace("-","",$cont_no);
								
							$sqlYN="SELECT time_out FROM sparcsn4.inv_unit 
							INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
							WHERE sparcsn4.inv_unit.id='$cont_no' AND category='IMPRT'
							order by inv_unit.gkey desc limit 1";

							$resYN=mysql_query($sqlYN);
							$rowYN=mysql_fetch_object($resYN);
							$yn=$rowYN->time_out;
							if($yn!=null)
							{
						?>
								<td style="border:1px solid black; width:10px; background-color:#bbbaba;" align="center">Yes</td>
						<?php
							}
							else
							{
						?>
								<td style="border:1px solid black; width:10px;" align="center"></td>
						<?php
							}										
						?>
						
						<td><?php echo $rowAllData->cont_no; ?></td>
						<td><?php echo $rowAllData->size; ?></td>
						<td><?php echo number_format($rowAllData->height,1); ?></td>
						<td align="center"><?php echo $rowAllData->line_no; ?></td>
						<td><?php echo $rowAllData->slot; ?></td>
						<td align="center"><?php echo $rowAllData->remarks; ?></td>
					</tr>
				<?php
				}
				?>
					<tr><td colspan="12"><hr></td></tr>
					<tr>
						<td>Total:</td>
						<td><?php echo $tot; ?></td>
						<td align="right">20 FT:</td>
						<td><?php echo $t20; ?></td>
						<td align="right">40 FT:</td>
						<td><?php echo $t40; ?></td>
						<td align="right">TEUS:</td>
						<td><?php echo $t20+$t40*2; ?></td>
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