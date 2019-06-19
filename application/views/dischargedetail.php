
<html>
<head>
	<table align="center" width="95%">
		<tr>
			<td align="center"><font size="5"><b>CHITTAGONG PORT AUTHORITY</b></font></td>
		</tr>
		<tr>
			<td align="center"><b>VAT Reg:2041001546</b></td>
		</tr>
		<tr>
			<td align="center"><b>CONTAINER DISCHARGING BILL</b></td>
		</tr>
		<?php
		if($version!="")
		{
		?>
		<tr>
			<td align="center">Version:&nbsp;<?php echo $version; ?></td>
		</tr>
		<?php
		}
		?>
	</table>	
</head>
<body>	
	<div align ="center">
		<table align="center" width="95%">
			<tr>
				<td align="left" style="width:10%">Draft Bill No</td>
				<td align="left" style="width:5%">:</td>
				<td align="left" style="width:20%"><?php echo $rslt_detail[0]['draftNumber'];?></td>
				<!--td align="left" style="width:5%"></td-->
				<td align="left" style="width:5%">Rotation No</td>
				<td align="left" style="width:5%">:</td>
				<td align="left" style="width:20%"><?php echo $rslt_detail[0]['ibVisitId'];?></td>
				<!--td align="left" style="width:5%"></td-->
				<td align="left" style="width:5%">Date</td>
				<td align="left" style="width:5%">:</td>
				<td align="left" style="width:20%"><?php echo $rslt_detail[0]['created'];?></td>
			</tr>
			<tr>
				<td align="left" style="width:10%">Vessel</td>
				<td align="left" style="width:5%">:</td>
				<td align="left" style="width:20%"><?php echo $rslt_detail[0]['ibCarrierName'];?></td>
				<!--td align="left" style="width:5%"></td-->
				<td align="left" style="width:5%">MLO</td>
				<td align="left" style="width:5%">:</td>
				<td align="left" style="width:20%"><?php echo $rslt_detail[0]['customerId'];?></td>
				<!--td align="left" style="width:5%"></td-->
				<td align="left" style="width:5%">Agent</td>
				<td align="left" style="width:5%">:</td>
				<td align="left" style="width:20%"><?php echo $rslt_detail[0]['concustomerid'];?></td>
			</tr>
			<tr>
				<td align="left" style="width:10%">&nbsp;</td>
				<td align="left" style="width:5%"></td>
				<td align="left" style="width:20%"></td>
				<!--td align="left" style="width:5%"></td-->
				<td align="left" style="width:5%">MLO Name</td>
				<td align="left" style="width:5%">:</td>
				<td align="left" style="width:20%"><?php echo $rslt_detail[0]['customerName'];?></td>
				<!--td align="left" style="width:5%"></td-->
				<td align="left" style="width:5%">Agent Name</td>
				<td align="left" style="width:5%">:</td>
				<td align="left" style="width:20%"><?php echo $rslt_detail[0]['concustomerid'];?></td>
			</tr>
		</table>	
		<table align="center" width="95%">
			<!--tr>
				<td colspan="13">
					<hr/>
				</td>
			</tr-->
			<thead>
				<tr>
					<td class="bottomtopborder" align="center">Sl</td>
					<td class="bottomtopborder" align="center">Container No</td>
					<td class="bottomtopborder" align="center">Size</td>
					<td class="bottomtopborder" align="center">Height</td>
					<td class="bottomtopborder" align="center">Status</td>
					<td class="bottomtopborder" align="center">Landing Date</td>
					<td class="bottomtopborder" align="center">Equipment</td>
					<td class="bottomtopborder" align="center">Pre Loc</td>
					<td class="bottomtopborder" align="center">Vat(%)</td>
					<td class="bottomtopborder" align="center">Type</td>
				</tr>
			</thead>
			<!--tr>
				<td colspan="13">
					<hr/>
				</td>
			</tr-->
			<?php
				$total=0;
				$vatTotal=0;
				$amountTotal=0;
				$q20=0;
				$q40=0;
				$q45=0;
				$flag20=0;
				$flag40=0;
				$flag45=0;
				for($i=0; $i<count($rslt_detail); $i++) {?>
				
				<tr>
					<td align="center"><?php echo $i+1; ?></td>
					<td align="center"><?php echo $rslt_detail[$i]['unitId']; ?></td>
					<td align="center"><?php echo $rslt_detail[$i]['isoLength']; ?></td>
					<td align="center"><?php echo number_format($rslt_detail[$i]['isoHeight'],1); ?></td>
					<td align="center"><?php echo $rslt_detail[$i]['freightKind']; ?></td>
					<td align="center"><?php echo $rslt_detail[$i]['created']; ?></td>
					<td align="center"><?php echo $rslt_detail[$i]['equipment']; ?></td>
					<td align="center"><?php echo $rslt_detail[$i]['preloc']; ?></td>
					<td align="center"><?php echo number_format($rslt_detail[$i]['vatperc'],2); ?></td>
					<td align="center">&nbsp;</td>
				</tr>
				<?php   
				} 
				?>
		</table>
		
		<table align="center" width="80%">
			<tr>
				<td colspan="11"><u>Equipment</u>:</td>
				<td colspan="8"><u>VAT</u>:</td>
				<td colspan="6"><u>Lift On/Lift Off</u>:</td>
			</tr>
			<tr>
				<td class="cell">Wholly:</td>
				<td align="center" class="cell"><?php echo $rslt_detail_summary[0]['equipmentW']; ?></td>
				<td>&nbsp;</td>
				<td class="cell">No:</td>
				<td align="center" class="cell"><?php echo $rslt_detail_summary[0]['equipmentN']; ?></td>
				<td>&nbsp;</td>
				<td class="cell">Partly:</td>
				<td align="center" class="cell"><?php echo $rslt_detail_summary[0]['equipmentP']; ?></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td class="cell">VAT:</td>
				<td align="center" class="cell"><?php echo $rslt_detail_summary[0]['vat']; ?></td>
				<td>&nbsp;</td>
				<td class="cell">Non VAT:</td>
				<td align="center" class="cell"><?php echo $rslt_detail_summary[0]['nonvat']; ?></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td class="cell">Yes:</td>
				<td align="center" class="cell"><?php echo $rslt_detail_summary[0]['LON']; ?></td>
				<td>&nbsp;</td>
				<td class="cell">No:</td>
				<td align="center" class="cell"><?php echo $rslt_detail_summary[0]['NLON']; ?></td>
				<td>&nbsp;</td>
			</tr>
		</table>
		
		<table align="center" width="80%">
			<tr>
				<th align="center">Summary</th>
				<th align="center">20X8.5</th>
				<th align="center">20X9.5</th>
				<th align="center">40X8.5</th>
				<th align="center">40X9.5</th>
				<th align="center">45X8.5</th>
				<th align="center">45X9.5</th>
				<th align="center" class="leftborder">Total</th>
			</tr>
			<tr>
				<td align="center">FCL</td>
				<td align="center"><?php echo $rslt_detail_summary[0]['fcl_20_85']; ?></td>
				<td align="center"><?php echo $rslt_detail_summary[0]['fcl_20_95']; ?></td>
				<td align="center"><?php echo $rslt_detail_summary[0]['fcl_40_85']; ?></td>
				<td align="center"><?php echo $rslt_detail_summary[0]['fcl_40_95']; ?></td>
				<td align="center"><?php echo $rslt_detail_summary[0]['fcl_45_85']; ?></td>
				<td align="center"><?php echo $rslt_detail_summary[0]['fcl_45_95']; ?></td>
				<?php
				$total_fcl=$rslt_detail_summary[0]['fcl_20_85']+$rslt_detail_summary[0]['fcl_20_95']+$rslt_detail_summary[0]['fcl_40_85']+$rslt_detail_summary[0]['fcl_40_95']+$rslt_detail_summary[0]['fcl_45_85']+$rslt_detail_summary[0]['fcl_45_95'];
				?>
				<td align="center" class="leftborder"><?php echo $total_fcl; ?></td>
			</tr>
			<tr>
				<td align="center">LCL</td>
				<td align="center"><?php echo $rslt_detail_summary[0]['lcl_20_85']; ?></td>
				<td align="center"><?php echo $rslt_detail_summary[0]['lcl_20_95']; ?></td>
				<td align="center"><?php echo $rslt_detail_summary[0]['lcl_40_85']; ?></td>
				<td align="center"><?php echo $rslt_detail_summary[0]['lcl_40_95']; ?></td>
				<td align="center"><?php echo $rslt_detail_summary[0]['lcl_45_85']; ?></td>
				<td align="center"><?php echo $rslt_detail_summary[0]['lcl_45_95']; ?></td>
				<?php
				$total_lcl=$rslt_detail_summary[0]['lcl_20_85']+$rslt_detail_summary[0]['lcl_20_95']+$rslt_detail_summary[0]['lcl_40_85']+$rslt_detail_summary[0]['lcl_40_95']+$rslt_detail_summary[0]['lcl_45_85']+$rslt_detail_summary[0]['lcl_45_95'];
				?>
				<td align="center" class="leftborder"><?php echo $total_lcl; ?></td>
			</tr>
			<tr>
				<td align="center" class="bottomborder">EMT</td>
				<td align="center" class="bottomborder"><?php echo $rslt_detail_summary[0]['mty_20_85']; ?></td>
				<td align="center" class="bottomborder"><?php echo $rslt_detail_summary[0]['mty_20_95']; ?></td>
				<td align="center" class="bottomborder"><?php echo $rslt_detail_summary[0]['mty_40_85']; ?></td>
				<td align="center" class="bottomborder"><?php echo $rslt_detail_summary[0]['mty_40_95']; ?></td>
				<td align="center" class="bottomborder"><?php echo $rslt_detail_summary[0]['mty_45_85']; ?></td>
				<td align="center" class="bottomborder"><?php echo $rslt_detail_summary[0]['mty_45_95']; ?></td>
				<?php
				$total_mty=$rslt_detail_summary[0]['mty_20_85']+$rslt_detail_summary[0]['mty_20_95']+$rslt_detail_summary[0]['mty_40_85']+$rslt_detail_summary[0]['mty_40_95']+$rslt_detail_summary[0]['mty_45_85']+$rslt_detail_summary[0]['mty_45_95'];
				?>
				<td align="center" class="bottomleftborder"><?php echo $total_mty; ?></td>
			</tr>
			<!--tr>
				<td colspan="8">
					<hr>
				</td>
			</tr-->
			<tr>
				<td></td>
				<td align="center"><?php echo $rslt_detail_summary[0]['fcl_20_85']+$rslt_detail_summary[0]['lcl_20_85']+$rslt_detail_summary[0]['mty_20_85']; ?></td>
				<td align="center"><?php echo $rslt_detail_summary[0]['fcl_20_95']+$rslt_detail_summary[0]['lcl_20_95']+$rslt_detail_summary[0]['mty_20_95']; ?></td>
				<td align="center"><?php echo $rslt_detail_summary[0]['fcl_40_85']+$rslt_detail_summary[0]['lcl_40_85']+$rslt_detail_summary[0]['mty_40_85']; ?></td>
				<td align="center"><?php echo $rslt_detail_summary[0]['fcl_40_95']+$rslt_detail_summary[0]['lcl_40_95']+$rslt_detail_summary[0]['mty_40_95']; ?></td>
				<td align="center"><?php echo $rslt_detail_summary[0]['fcl_45_85']+$rslt_detail_summary[0]['lcl_45_85']+$rslt_detail_summary[0]['mty_45_85']; ?></td>
				<td align="center"><?php echo $rslt_detail_summary[0]['fcl_45_95']+$rslt_detail_summary[0]['lcl_45_95']+$rslt_detail_summary[0]['mty_45_95']; ?></td>
				<?php
				//$total=$rslt_detail_summary[0]['fcl_20_85']+$rslt_detail_summary[0]['lcl_20_85']+$rslt_detail_summary[0]['mty_20_85']+$rslt_detail_summary[0]['fcl_20_95']+$rslt_detail_summary[0]['lcl_20_95']+$rslt_detail_summary[0]['mty_20_95']+$rslt_detail_summary[0]['fcl_40_85']+$rslt_detail_summary[0]['lcl_40_95']+$rslt_detail_summary[0]['mty_40_85']+$rslt_detail_summary[0]['fcl_40_95']+$rslt_detail_summary[0]['lcl_40_95']+$rslt_detail_summary[0]['mty_40_95']+$rslt_detail_summary[0]['fcl_45_85']+$rslt_detail_summary[0]['lcl_45_85']+$rslt_detail_summary[0]['mty_45_85']+$rslt_detail_summary[0]['fcl_45_95']+$rslt_detail_summary[0]['lcl_45_95']+$rslt_detail_summary[0]['mty_45_95'];
				$total=$total_fcl+$total_lcl+$total_mty;
				?>
				<td  align="center" class="leftborder"><?php echo $total; ?></td>
			</tr>
		</table>
	</div>
</body>
</html>





