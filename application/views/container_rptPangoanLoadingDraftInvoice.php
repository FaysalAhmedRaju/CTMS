
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
				<td align="center"><b><?php echo $bill_rslt[0]['invoiceDesc'];?></b></td>
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
					<td align="left" style="width:15%">Bill No</td>
					<td align="left" style="width:15%">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['draftNumber'];?></td>
					<td align="left" style="width:10%"></td>
					<td align="left">Bill Creator</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['created_user'];?></td>
					
				</tr>
				<tr>
					<td align="left">Nature Bill</td>
					<td align="left">: &nbsp; LOADING BILL (PCT)<!--?php echo $bill_rslt[0]['vesselName'];?--></td>
					<td align="left"></td>
					<td align="left" style="width:10%">Bill Date</td>
					<td align="left" style="width:25%">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['billingDate'];?></td>
				</tr>
				<tr>
					<td align="left">MLO</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['payCustomerId'];?></td>
					<td align="left"></td>
					<td align="left">Rotation No</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['ibVisitId'];?></td>
				</tr>
				<tr>
					<td align="left">MLO Name</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['payCustomername'];?></td>
					<td align="left"></td>
					<td align="left">Vessel</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['ibCarrierName'];?></td>
				</tr>
				<tr>
					<td align="left">S.Agent</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['customerId'];?></td>
					<td align="left"></td>
				    <td align="left">Arrival Date</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['eta'];?></td>
				</tr>
				<tr>
					<td align="left">S.Agent Name</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['customerName'];?></td> 
					<td align="left"></td>
					<td align="left">Sailing</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['etd'];?></td>
				</tr>
				<tr>
					<td align="left">Ex. Rate</td>
					<td align="left">: &nbsp;&nbsp;<?php echo number_format($bill_rslt[0]['exchangeRate'],2);?></td>
					<td align="left"></td>
					<td align="left">Berth</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['berth'];?></td>
				</tr>
				
			</table>	
			<table align="center" width="95%">
				<tr>
					<td colspan="10">
						<hr style=" border-top:1px dotted; color:black;"/>
					</td>
				</tr>
				<tr>
					<td style="width:50px" align="left">SL</td>
					<td align="left">PARTICULARS</td>
					<td style="width:50px" align="right">SIZE</td>
					<td align="right">HEIGHT</td>
					<td align="center">QTY</td>
					<td align="center">DAYS</td>
					<td align="right">RATE</td>
					<td align="right">AMOUNT BDT</td>
					<td align="right">VAT BDT</td>
					<td align="right">TOTAL BDT</td>

				</tr>
				<tr>
					<td colspan="10">
						<hr style=" border-top:1px dotted; color:black;"/>
					</td>
				</tr>
					
				<?php
				$size20=0;
				$size40=0;
				$size45=0;

                $sumAmt=0;
                $sumVat=0;
                $sum=0;
                $sumTotal=0;
				
				for($i=0; $i<count($bill_rslt); $i++) {?>
				
				<tr>
					<td align="left"><?php echo $i+1;?></td>
					<td align="left" ><?php if ($bill_rslt[$i]['usd']!="" or  null) echo $bill_rslt[$i]['usd'];  echo $bill_rslt[$i]['Particulars'];?></td>
					<td align="right"><?php echo $bill_rslt[$i]['size'];
								if($bill_rslt[$i]['size']=="20")
								{
									$size20++;
								}
								else if($bill_rslt[$i]['size']=="40")
								{
									$size40++;
								}	
								else
									$size45++;
					?></td>
					<td align="right"><?php echo number_format($bill_rslt[$i]['height'],1);?></td>
					<td align="center"><?php echo $bill_rslt[$i]['qty'];?></td>
					<td align="center"><?php echo $bill_rslt[$i]['days2'];?></td>
					<td align="right"><?php echo number_format($bill_rslt[$i]['rateBilled'],2); ?></td>
					<td align="right"><?php echo number_format($bill_rslt[$i]['amt'],2);												
										$sumAmt=$sumAmt+$bill_rslt[$i]['amt'];?></td>
					<td align="right"><?php echo number_format($bill_rslt[$i]['vat'],2);
											$sumVat=$sumVat+$bill_rslt[$i]['vat'];?></td>
					<td align="right"><?php $sum= $bill_rslt[$i]['amt'] + $bill_rslt[$i]['vat'];
											echo number_format($sum,2);	
										$sumTotal=$sumTotal+$sum; ?></td>	
				</tr>
				<?php  } ?>
				<tr>
					<td colspan="10">
						<hr style=" border-top:1px dotted; color:black;"/>
					</td>
				</tr>
				<tr>
					<td align="center"> 20 => <?php echo $bill_rslt[0]['qtytot20'];?></td>
					<td align="center"> 40 => <?php echo $bill_rslt[0]['qtytot40'];?></td>
					<td align="center"> 45 => <?php echo $bill_rslt[0]['qtytot45'];?></td>
					<td align="center" colspan="3"></td>
					<td align="center">Total Taka:</td>
					<td align="right"><?php echo number_format ($sumAmt, 2);?></td>
					<td align="right"><?php  echo number_format ($sumVat, 2);?></td>
					<td align="right"><?php  echo number_format ($sumTotal, 2); ?></td>
				</tr>
				<tr>
					<td colspan="10">
						<hr style=" border-top:1px dotted; color:black;"/>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="10">$Shows Rate in US Dollar</td>
				</tr>
				
			</table>	
			<table align="center" width="85%">	
				<tr>
					<td colspan="6">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="6" align="left">Net Payable BDT :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php  echo number_format($sumTotal,2); ?></b></td>
				</tr>	
				<tr>	
					<td colspan="6" align="left">In Words :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php  echo numtowords($sumTotal)." Only"; ?></b></td>
					
				</tr>
				<tr>	
					<td colspan="6" align="left">Ex. Currency is taken on the basis of vessel arrival date.</td>
				</tr>
				<tr>	
					<td colspan="6" align="left">Remarks &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</td>
				</tr>
			</table>
			<table align="center" width="90%">
				<tr>
					<td colspan="6"></td>
				</tr>
				<tr>
					<td colspan="6">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="6">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="6">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="6">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="6">&nbsp;</td>
				</tr>

				<tr>
					<td align="center" colspan="2"></td>
					<td align="center" colspan="2"><?php echo $bill_rslt[0]['created_user'];?></td>
					<td align="center" colspan="2"></td>
				</tr>
				<tr>
					<td align="center" colspan="2">---------------------------</td>
					<td align="center" colspan="2">---------------------------</td>
					<td align="center" colspan="2">---------------------------</td>
				</tr>
				<tr>
					<td align="center" colspan="2">
						<b>Bank's Seal</b>
					</td>
					<td align="center" colspan="2">
						<b>Computer Operator</b>
					</td>
					<td align="center" colspan="2">
						<b>For Terminal Officer(A&G)</b>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="2"></td>
					<td align="center" colspan="2">TM Office/CPA</td>
					<td align="center" colspan="2">TM Office/CPA</td>
				</tr>
				
				<tr>
					<td colspan="6">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="6">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="6">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="6">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="6">&nbsp;</td>
				</tr>
			</table>	
			<table align="center" width="90%">
				<tr>
					<td colspan="6">Print Date : &nbsp;&nbsp; <?php echo $print_time[0]['Time']; ?></td>
				</tr>
				
				
			</table>
			
			
			
		</div>
	
</body>
</html>
<?php function numtowords($number){ 
//print($number."<br>");
    $no = round($number);
    $decimal = round($number - ($no = floor($number)), 2) * 100;    
    $digits_length = strlen($no);    
    $i = 0;
    $str = array();
    $words = array(
        0 => '',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen',
        20 => 'Twenty',
        30 => 'Thirty',
        40 => 'Forty',
        50 => 'Fifty',
        60 => 'Sixty',
        70 => 'Seventy',
        80 => 'Eighty',
        90 => 'Ninety');
    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? '' : null;            
            $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural;
        } else {
            $str [] = null;
        }  
    }
    
    $Rupees = implode(' ', array_reverse($str));
    $paise = ($decimal) ? "And " . ($words[$decimal - $decimal%10]) ." " .($words[$decimal%10])." Paisa"  : '';
    return ($Rupees ?  $Rupees." Taka " : '') . $paise;
}
 ?>
