
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
			<td align="center"><b>ICD Bill</b></td>
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
		<table align="center" width="85%">
			<tr>
				<td align="left" style="width:15%">Draft Bill No</td>
				<td align="left" >:</td>
				<td align="left" style="width:35%"><?php echo $bill_rslt[0]['draftNumber'];?></td>
				<!--td align="left" style="width:10%"></td-->
				<td align="left" style="width:10%">Bill Date</td>
				<td align="left" >:</td>
				<td align="left" style="width:25%"><?php echo $bill_rslt[0]['billingDate'];?></td>
			</tr>
			<tr>
				<td align="left" style="width:15%">Nature Bill</td>
				<td align="left" >:</td>
				<td align="left" style="width:35%"><?php echo $bill_rslt[0]['invoiceDesc'];?></td>
				<!--td align="left" style="width:10%"></td-->
				<td align="left" style="width:10%">Rotation No</td>
				<td align="left" >:</td>
				<td align="left" style="width:25%"><?php echo $bill_rslt[0]['ibVisitId'];?></td>
			</tr>
			<tr>
				<td align="left" style="width:15%">MLO</td>
				<td align="left" >:</td>
				<td align="left" style="width:35%"><?php echo $bill_rslt[0]['customerId'];?></td>
				<!--td align="left" style="width:10%"></td-->
				<td align="left" style="width:10%">Vessel</td>
				<td align="left" >:</td>
				<td align="left" style="width:25%"><?php echo $bill_rslt[0]['ibCarrierName'];?></td>
			</tr>
			<tr>
				<td align="left" style="width:15%">MLO Name</td>
				<td align="left" >:</td>
				<td align="left" style="width:35%"><?php echo $bill_rslt[0]['customerName'];?></td>
				<!--td align="left" style="width:10%"></td-->
				<td align="left" style="width:10%">Arrival Date</td>
				<td align="left" >:</td>
				<td align="left" style="width:25%"><?php echo $bill_rslt[0]['ata'];?></td>
			</tr>
			<tr>
				<td align="left" style="width:15%">Agent Code</td>
				<td align="left" >:</td>
				<td align="left" style="width:35%"><?php echo $bill_rslt[0]['payCustomerId'];?></td>
				<!--td align="left" style="width:10%"></td-->
				<td align="left" style="width:10%">Sailing Date</td>
				<td align="left" >:</td>
				<td align="left" style="width:25%"><?php echo $bill_rslt[0]['atd'];?></td>
			</tr>
			<tr>
				<td align="left" style="width:15%">Agent Name</td>
				<td align="left" >:</td>
				<td align="left" style="width:35%"><?php echo $bill_rslt[0]['payCustomername'];?></td>
				<!--td align="left" style="width:10%"></td-->
				<td align="left" style="width:10%">Berth</td>
				<td align="left" >:</td>
				<td align="left" style="width:25%"><?php echo $bill_rslt[0]['berth'];?></td>
			</tr>
			<tr>
				<td align="left" style="width:15%">USD/BDT Ex.</td>
				<td align="left" >:</td>
				<td align="left" style="width:35%"><?php echo number_format($bill_rslt[0]['exchangeRate'],4);?></td>
				<!--td align="left" style="width:10%"></td-->
				<td align="left" style="width:10%">CPA Out Date</td>
				<td align="left" >:</td>
				<td align="left" style="width:25%"><?php echo $bill_rslt[0]['eventPerformDate'];?></td>
			</tr>
			<tr>
				<td align="left" style="width:15%">&nbsp;</td>
				<td align="left" >&nbsp;</td>
				<td align="left" style="width:35%">&nbsp;</td>
				<!--td align="left" style="width:10%"></td-->
				<td align="left" style="width:10%">CL Date</td>
				<td align="left" >:</td>
				<td align="left" style="width:25%"><?php echo $bill_rslt[0]['discharge_done'];?></td>
			</tr>
		</table>	
		<table align="center" width="95%">
			<!--tr>
				<td colspan="9">
					<hr/>
				</td>
			</tr-->
			<thead>
				<tr>
					<td class="bottomtopborder" align="left">Sl</td>
					<td class="bottomtopborder" align="left">Particulars</td>
					<td class="bottomtopborder" align="left">Size</td>
					<td class="bottomtopborder" align="left">Height</td>
					<td class="bottomtopborder" align="center">QTY</td>
					<td class="bottomtopborder" align="center">Days</td>
					<td class="bottomtopborder" align="right">RATE</td>
					<td class="bottomtopborder" align="right">AMOUNT BDT</td>
					<td class="bottomtopborder" align="right">VAT BDT</td>
					<td class="bottomtopborder" align="right">TOTAL BDT</td>
				</tr>
			</thead>
			<!--tr>
				<td colspan="9">
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
				for($i=0; $i<count($bill_rslt); $i++) {?>
				
				<tr>
					<td align="left"><?php echo $i+1; ?></td>
					<td align="left">$<?php echo $bill_rslt[$i]['Particulars']; ?></td>
					<td align="left"><?php echo $bill_rslt[$i]['size']; ?></td>
					<?php 
					if($bill_rslt[$i]['size']==20 and $flag20==0)
					{
						$q20=$q20+$bill_rslt[$i]['qty'];
						$flag20=$flag20+1;
					}
					else if($bill_rslt[$i]['size']==40 and $flag40==0)
					{
						$q40=$q40+$bill_rslt[$i]['qty'];
						$flag40=$flag40+1;
					}
					else if($bill_rslt[$i]['size']==45 and $flag45==0)
					{
						$q45=$q45+$bill_rslt[$i]['qty'];
						$flag45=$flag45+1;
					}
					?>
					<td align="left"><?php echo number_format($bill_rslt[$i]['height'],1);?></td>
					<!--td align="center"><?php echo $bill_rslt[$i]['quantityBilled'];?></td-->
					<td align="right"><?php echo $bill_rslt[$i]['qty'];?></td>
					<td align="right"><?php echo $bill_rslt[$i]['storage_days'];?></td>
					<td align="right"><?php echo number_format($bill_rslt[$i]['rateBilled'],2);?></td>
					<td align="right"><?php echo number_format($bill_rslt[$i]['amt'],2);?></td>
					<?php
						$amountTotal=$amountTotal+$bill_rslt[$i]['amt'];
					?>
					<td align="right"><?php echo number_format($bill_rslt[$i]['vat'],2);?></td>
					<?php
						$vatTotal=$vatTotal+$bill_rslt[$i]['vat'];
					?>
					<td align="right"><?php echo number_format(($bill_rslt[$i]['amt']+$bill_rslt[$i]['vat']),2);?></td>
					<?php
						$total=$total+$bill_rslt[$i]['amt']+$bill_rslt[$i]['vat'];
					?>
				</tr>
				<?php   
				} 
				?>
				<!--tr>
					<td colspan="10">
						<hr/>
					</td>
				</tr-->
				<tr>
					<td class="bottomtopborder" colspan="2">20=><?php echo $q20; ?>&nbsp;&nbsp;&nbsp;40=><?php echo $q40; ?>&nbsp;&nbsp;&nbsp;45=><?php echo $q45; ?></td>
					<td class="bottomtopborder" colspan="4" align="right">Total Taka:</td>
					<td class="bottomtopborder">&nbsp;</td>
					<td class="bottomtopborder" align="right"><?php echo number_format($amountTotal,2); ?></td>
					<td class="bottomtopborder" align="right"><?php echo number_format($vatTotal,2); ?></td>
					<td class="bottomtopborder" align="right"><?php echo number_format($total,2); ?></td>
				</tr>
				<!--tr>
					<td colspan="10">
						<hr/>
					</td>
				</tr-->
				<tr>
					<td colspan="10" align="left">
						$Shows Rate in US Dollar
					</td>
				</tr>
			</table>
			<table align="center" width="95%">
				<tr>
					<td colspan="6">
						<table align="left">
							<tr>
								<td align ="left">
									<font size="4"><b>Net Payable BDT</font></b> </b>
								</td>
								<td> : </td>
								<td> <?php echo number_format($total,2); ?> </td>
							</tr>
							<tr>
								<td align ="left">
									<font size="4"><b>In Words </font></b> </b>
								</td>
								<td> : </td>
								<td> <?php  echo numtowords($total)." Only";?> </td>
							</tr>	
							<tr>	
								<td align ="left">
								  <font size="4"><b> Remarks </font></b> </b>
								</td>
								<td> : </td>
								<td>Ex. Currency is taken on the basis of Vessel Arival Date</td>
							</tr>
						</table>
					</td>
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
					<td align="left" colspan="2">
						<b>Bank's Seal</b>
					</td>
					<td align="left" colspan="2">
						<b>Computer Operator<br>TM Office/CPA</b>
					</td>
					<td align="left" colspan="2">
						<b>For Terminal Officer(A&G)<br>TM Office/CPA</b>
					</td>
				</tr>
				<!--tr>
					<td align="left" colspan="6">
						BILL DATE: &nbsp;&nbsp;<?php echo DATE($bill_rslt[0]['created']);?>
					</td>
				</tr-->
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
					<td colspan="6">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="6">&nbsp;</td>
				</tr>
				
				<tr>
					<td colspan="6">PRINT DATE: &nbsp;&nbsp;&nbsp;<?php echo $print_time[0]['Time']; ?></td>
				</tr>
				<tr>
					<td colspan="6"><font size="3">Ex. Currency is taken on the basis of Disconnection Date</font></td>
				</tr>
				
				
			</table>
			
			
			
		</div>
	
</body>
</html>
<?php
function numtowords($number){ 
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
} ?>
