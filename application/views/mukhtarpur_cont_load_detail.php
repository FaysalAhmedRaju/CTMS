
<html>
<head>
		<table align="center" width="100%">
			<tr>
				<td align="center"><font size="5"><b>CHITTAGONG PORT AUTHORITY</b></font></td>
			</tr>
			<tr>
				<td align="center"><b>VAT Reg:2041001546</b></td>
			</tr>
			<tr>
				<td align="center"><b><?php echo $rslt_detail[0]['invoiceDesc'];?></b></td>
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
		<!--div align="center">(LCL BILL)</div-->

</head>
<body>	
		<div align ="center">
			<table align="center" width="95%">

				<tr>
					<td align="left">Draft Bill No</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $rslt_detail[0]['draftNumber'];?></td>
					<td align="left"></td>
					<td align="left">Rotation No</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $rslt_detail[0]['ibVisitId'];?></td>
					<td align="left"></td>
					<td align="left">Date </td>
					<td align="left">: &nbsp;&nbsp;<?php echo $rslt_detail[0]['created'];?></td>
					<td align="left"></td>
					
				</tr>
				<tr>
					<td align="left">Vessel</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $rslt_detail[0]['ibCarrierName'];?></td>
					<td align="left"></td>
					<td align="left">MLO</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $rslt_detail[0]['customerId'];?></td>
					<td align="left"></td>
					<td align="left">Agent </td>
					<td align="left">: &nbsp;&nbsp;<?php echo $rslt_detail[0]['concustomerid'];?></td>
					<td align="left"></td>
					
				</tr>
				<tr>
					<td align="left">MLO Name</td>
					<td colspan="2" align="left">: &nbsp;&nbsp;<?php echo $rslt_detail[0]['customerName'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="left">Agent Name</td>
					<td colspan="2" align="left">: &nbsp;&nbsp;<?php echo $rslt_detail[0]['concustomername'];?></td>
					<td align="left"></td>
					<td align="left"></td>
					<td align="left"></td>
				</tr>
				
			</table>	
			<table align="center" width="95%">
				<tr>
					<td colspan="13">
						<hr style=" border-top:1px dotted; color:black;"/>
					</td>
				</tr>
				<tr>
					<td align="center">SL</td>
					<td align="center">CONTAINER NO</td>
					<td align="center">SIZE</td>
					<td align="center">HEIGHT</td>
					<td align="center">STATUS</td>
					<td align="center">IMP ROT</td>
					<td align="center">IMP ATA</td>
					<td align="center">C. L. DATE</td>
					<td align="center">FROM DEPO</td>
					<td align="center">PCT OUT</td>			
					<td align="center">VAT(%)</td>					
					<td align="center">DAYS</td>					
				</tr>
				<tr>
					<td colspan="13">
						<hr style=" border-top:1px dotted; color:black;"/>
					</td>
				</tr>
					
				<?php
				
				for($i=0; $i<count($rslt_detail); $i++) {?>
				
				<tr>
					<td align="center"><?php echo $i+1;?></td>
					<td align="center" ><?php echo $rslt_detail[$i]['unitId'] ?></td>
					<td align="center"><?php echo $rslt_detail[$i]['isoLength'];?></td>
					<td align="center"><?php echo number_format($rslt_detail[$i]['isoHeight'],1);?></td>
					<td align="center"><?php echo $rslt_detail[$i]['STATUS'];?></td>					
					<td align="center"><?php echo $rslt_detail[$i]['ibVisitId'];?></td>					
					<td align="center"><?php echo $rslt_detail[$i]['imp_ata'];?></td>					
					<td align="center"><?php echo $rslt_detail[$i]['timeIn'];?></td>					
					<td align="center">&nbsp;</td>					
					<td align="center"><?php echo $rslt_detail[$i]['timeOut'];?></td>
					<td align="center"><?php echo $rslt_detail[$i]['vatperc'];?></td>
					<td align="center"><?php echo $rslt_detail[$i]['days'];?></td>
				</tr>
				<?php  } ?>
				
			</table>	
			<table align="center" width="85%">	
				<tr>
					<td colspan="17">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" align="left"><u>Equipment</u></td>
					<td align="center"></td>
					<td align="center"></td>
					<td align="center"></td>
					<td align="center"></td>
					<td colspan="2" align="right"><u>Vat</u></td>
					<td align="right"></td>
					<td align="right"></td>
					<td align="right"></td>
					<td align="right"></td>
					<td align="right"></td>
					<td align="center" style="width:90px"><u>Lift On / Lift Off:</u></td>
					<td align="right"></td>
					<td align="right"></td>
										<td align="right"></td>
					<td align="right"></td>
				</tr>
				<tr>
					<td style="border: 1px solid black; border-collapse: collapse; " align="left">Wholly:</td>
					<td style="border: 1px solid black; border-collapse: collapse; width:30px" align="center"><?php echo $summary_bill_detail[0]['equipmentW'];?></td>
					<td style="border: 1px solid black; border-collapse: collapse;" align="left">No:</td>
					<td style="border: 1px solid black; border-collapse: collapse; width:30px" align="center" ><?php echo $summary_bill_detail[0]['equipmentN'];?></td>
					<td style="border: 1px solid black; border-collapse: collapse;" align="center">Partly:</td>
					<td style="border: 1px solid black; border-collapse: collapse; width:30px" align="center"><?php echo $summary_bill_detail[0]['equipmentP'];?></td>
					<td align="right" style="width:25px"></td>
					<td style="border: 1px solid black; border-collapse: collapse;" align="left">Vat:</td>
					<td style="border: 1px solid black; border-collapse: collapse; width:30px" align="center"><?php echo $summary_bill_detail[0]['vat'];?></td>
					<td style="border: 1px solid black; border-collapse: collapse;" align="left">Non Vat:</td>
					<td style="border: 1px solid black; border-collapse: collapse; width:30px" align="center"><?php echo $summary_bill_detail[0]['nonvat'];?></td>
					<td align="right" style="width:120px"></td>
					<td style="border: 1px solid black; border-collapse: collapse; width:40px" align="center">Yes:</td>
					<td style="border: 1px solid black; border-collapse: collapse; width:40px" align="center"><?php echo $summary_bill_detail[0]['LON'];?></td>
					<td style="border: 1px solid black; border-collapse: collapse; width:40px" align="center">No:</td>
					<td style="border: 1px solid black; border-collapse: collapse; width:40px" align="center"><?php echo $summary_bill_detail[0]['NLON'];?></td>
					<td align="right"></td>
				</tr>
				<tr>
					<td colspan="17">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="17">&nbsp;</td>
				</tr>
			</table>
			<table align="center" width="85%">
				<tr>
					<td align="center"><u>Summary</u></td>
					<td align="center"><u>20 X 8.5</u></td>
					<td align="center"><u>20 X 9.5</u></td>
					<td align="center"><u>40 X 8.5</u></td>
					<td align="center"><u>40 X 9.5</u></td>
					<td align="center"><u>45 X 8.5</u></td>
					<td align="center"><u>45 X 9.5</u></td>
					<td align="center" style=" border-left: 1px dashed black;"></td>
					<td align="center"><u>Total</u></td>
				</tr>
				<tr>
					<td align="center">FCL - </td>
					<td align="center"><?php echo $summary_bill_detail[0]['fcl_20_85'];?></td>
					<td align="center"><?php echo $summary_bill_detail[0]['fcl_20_95'];?></td>
					<td align="center"><?php echo $summary_bill_detail[0]['fcl_40_85'];?></td>
					<td align="center"><?php echo $summary_bill_detail[0]['fcl_40_95'];?></td>
					<td align="center"><?php echo $summary_bill_detail[0]['fcl_45_85'];?></td>
					<td align="center"><?php echo $summary_bill_detail[0]['fcl_45_95'];?></td>
					<td align="center" style=" border-left: 1px dashed black;"></td>
					<td align="center"><?php echo $summary_bill_detail[0]['fcl'];?></td>
				</tr>
				<tr>
					<td align="center">LCL - </td>
					<td align="center"><?php echo $summary_bill_detail[0]['lcl_20_85'];?></td>
					<td align="center"><?php echo $summary_bill_detail[0]['lcl_20_95'];?></td>
					<td align="center"><?php echo $summary_bill_detail[0]['lcl_40_85'];?></td>
					<td align="center"><?php echo $summary_bill_detail[0]['lcl_40_95'];?></td>
					<td align="center"><?php echo $summary_bill_detail[0]['lcl_45_85'];?></td>
					<td align="center"><?php echo $summary_bill_detail[0]['lcl_45_95'];?></td>
					<td align="center" style=" border-left: 1px dashed black;"></td>					
					<td align="center"><?php echo $summary_bill_detail[0]['lcl'];?></td>
				</tr>
				<tr>
					<td align="center" style="border-bottom:1px dashed black">EMT - </td>
					<td align="center" style="border-bottom:1px dashed black"><?php echo $summary_bill_detail[0]['mty_20_85'];?></td>
					<td align="center" style="border-bottom:1px dashed black"><?php echo $summary_bill_detail[0]['mty_20_95'];?></td>
					<td align="center" style="border-bottom:1px dashed black"><?php echo $summary_bill_detail[0]['mty_40_85'];?></td>
					<td align="center" style="border-bottom:1px dashed black"><?php echo $summary_bill_detail[0]['mty_40_95'];?></td>
					<td align="center" style="border-bottom:1px dashed black"><?php echo $summary_bill_detail[0]['mty_45_85'];?></td>
					<td align="center" style="border-bottom:1px dashed black"><?php echo $summary_bill_detail[0]['mty_45_95'];?></td>
					<td align="center" style=" border-left: 1px dashed black;border-bottom:1px dashed black"></td>					
					<td align="center" style="border-bottom:1px dashed black"><?php echo $summary_bill_detail[0]['mty'];?></td>
				</tr>
				<!--tr>
				    <td colspan="9"><hr style=" border-top:1px dotted; color:black;"/></td>
				</tr-->
				<tr>
					<td align="center"> </td>
					<td align="center"><?php echo $summary_bill_detail[0]['tot_20_85'];?></td>
					<td align="center"><?php echo $summary_bill_detail[0]['tot_20_95'];?></td>
					<td align="center"><?php echo $summary_bill_detail[0]['tot_40_85'];?></td>
					<td align="center"><?php echo $summary_bill_detail[0]['tot_40_95'];?></td>
					<td align="center"><?php echo $summary_bill_detail[0]['tot_45_85'];?></td>
					<td align="center"><?php echo $summary_bill_detail[0]['tot_45_95'];?></td>
					<td align="center" style=" border-left: 1px dashed black;"></td>					
					<td align="center"><?php echo $summary_bill_detail[0]['tot'];?></td>
				</tr>
			</table>
			
			<table align="center" width="90%">
				<tr>
					<td colspan="6">&nbsp;</td>
				</tr><tr>
					<td colspan="6">&nbsp;</td>
				</tr><tr>
					<td colspan="6">&nbsp;</td>
				</tr><tr>
					<td colspan="6">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="6">Print Date : &nbsp;&nbsp; <?php echo $print_time[0]['Time']; ?></td>
				</tr>
			</table>			
		</div>
	
</body>
</html>
