
<html>
<head>
	<table align="center" width="95%">
		<tr>
			<td align="center" style="padding-left:125px"><font size="5"><b>CHITTAGONG PORT AUTHORITY</b></font></td>
			<td align="center"><?php echo $bill_rslt[0]['STATUS'];?></td>
		</tr>
		<tr>
			<td align="center" colspan="2"><b>VAT Reg:2041001546</b></td>
		</tr>
		<tr>
			<td align="center" colspan="2"><b><?php echo $bill_rslt[0]['invoiceDesc']?></b></td>
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
		<table align="center" width="95%" border="0">
			<tr>
				<td align="left" style="width:15%">Draft Bill No</td>
				<td align="left" style="width:15%">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['draftNumber'];?></td>
				<td align="left" style="width:10%"></td>
				<td align="left" style="width:10%">Rot No</td>
				<td align="left" style="width:25%">: &nbsp;&nbsp;As Per List Attached</td>
			</tr>
			<tr>
				<td align="left">Nature Bill</td>
				<td align="left">: &nbsp;&nbsp;REEFER BILL</td>
				<td align="left"></td>
				<td align="left">Vessel</td>
				<td align="left">: &nbsp;&nbsp;As Per List Attached</td>
			</tr>
			<tr>
				<td align="left">MLO</td>
				<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['payCustomerId'];?> </td>
				<td align="left"></td>
				<td align="left">Arrival Date</td>
				<td align="left">: &nbsp;&nbsp;</td>
			<tr>
				<td align="left">MLO Name</td>
				<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['payCustomername'];?></td>
				<td align="left"></td>
				<td align="left">Sailing Date</td>
				<td align="left">: &nbsp;&nbsp;</td>
			</tr>
			<tr>
				<td align="left">S. Agent</td>
				<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['payCustomerId'];?></td>
				<td align="left"></td>
				<td align="left">Berth</td>
				<td align="left">: &nbsp;&nbsp;</td>
			</tr>
			<tr>
				<td align="left">S. Agent Name</td>
				<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['customerName'];?></td> 
				<td align="left"></td>
				<td align="left">Comm.Land Dt.</td>
				<td align="left">: &nbsp;&nbsp;</td>
			</tr>
			<tr>
				<td align="left" colspan="5">&nbsp;</td>
			</tr>
			<!--tr>
				<td align="left">USD/BDT Ex</td>
				<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['exchangeRate'];?></td>				
				<td align="left">Dis. Conn. Dt.</td>
				<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['eventTo'];?></td>
			</tr-->
			<tr>
				<td align="left">USD/BDT Ex</td>
				<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['exchangeRate'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dis. Conn. Dt.</td>
				<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['eventTo'];?></td>
				<td align="right">Bill Date</td>
				<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['billing_date'];?></td>
			</tr>
		</table>	
		<table align="center" width="95%">
			<!--tr>
				<td colspan="10">
					<hr/>
				</td>
			</tr-->
			<thead>
				<tr>
					<td class="bottomtopborder" align="left">Sl</td>
					<td class="bottomtopborder" align="left">Particulars</td>
					<td class="bottomtopborder" align="left">Size</td>
					<td class="bottomtopborder" align="left">Height</td>
					<td class="bottomtopborder" align="left">QTY</td>
					<td class="bottomtopborder" align="right">Days</td>
					<td class="bottomtopborder" align="right">RATE</td>
					<td class="bottomtopborder" align="right">AMOUNT BDT</td>
					<td class="bottomtopborder" align="right">VAT BDT</td>
					<td class="bottomtopborder" align="right">TOTAL BDT</td>
				</tr>
			</thead>
			<!--tr>
				<td colspan="10">
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
						$q20=$q20+$bill_rslt[$i]['qtyUnit'];
						$flag20=$flag20+1;
					}
					else if($bill_rslt[$i]['size']==40 and $flag40==0)
					{
						$q40=$q40+$bill_rslt[$i]['qtyUnit'];
						$flag40=$flag40+1;
					}
					else if($bill_rslt[$i]['size']==45 and $flag45==0)
					{
						$q45=$q45+$bill_rslt[$i]['qtyUnit'];
						$flag45=$flag45+1;
					}
					?>
					<td align="left"><?php echo number_format($bill_rslt[$i]['height'],1);?></td>
					<td align="center"><?php echo $bill_rslt[$i]['qtyUnit'];?></td>
					<td align="right"><?php echo $bill_rslt[$i]['qty'];?></td>
					<td align="right"><?php echo $bill_rslt[$i]['rateBilled'];?></td>
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
				<tr>
					<td colspan="10">
						<hr/>
					</td>
				</tr>
				<tr>
					<td colspan="2">20=><?php echo $bill_rslt[0]['qtytot20']; ?>&nbsp;&nbsp;&nbsp;40=><?php echo $bill_rslt[0]['qtytot40']; ?>&nbsp;&nbsp;&nbsp;45=><?php echo $bill_rslt[0]['qtytot45']; ?></td>
					<td colspan="4" align="right">Total Taka:</td>
					<td>&nbsp;</td>
					<td align="right"><?php echo number_format($amountTotal,2); ?></td>
					<td align="right"><?php echo number_format($vatTotal,2); ?></td>
					<td align="right"><?php echo number_format($total,2); ?></td>
				</tr>
				<tr>
					<td colspan="10">
						<hr/>
					</td>
				</tr>
				<tr>
					<td colspan="10">
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
								<td>&nbsp;</td>
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
					<td align="center" colspan="2">
						<b>Bank's Seal</b>
					</td>
					<td align="center" colspan="2">
						<b>Computer Operator<br>TM Office/CPA</b>
					</td>
					<td align="center" colspan="2">
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
				<!--tr>
					<td colspan="6">PRINT DATE: &nbsp;&nbsp;&nbsp;<?php echo $print_time[0]['Time']; ?></td>
				</tr-->
				<tr>
					<td colspan="6"><font size="3">Ex. Currency is taken on the basis of Disconnection Date</font></td>
				</tr>
			</table>
		</div>
	
</body>
</html>
<?php function numtowords($num){ 
$decones = array( 
            '01' => "One", 
            '02' => "Two", 
            '03' => "Three", 
            '04' => "Four", 
            '05' => "Five", 
            '06' => "Six", 
            '07' => "Seven", 
            '08' => "Eight", 
            '09' => "Nine", 
            10 => "Ten", 
            11 => "Eleven", 
            12 => "Twelve", 
            13 => "Thirteen", 
            14 => "Fourteen", 
            15 => "Fifteen", 
            16 => "Sixteen", 
            17 => "Seventeen", 
            18 => "Eighteen", 
            19 => "Nineteen" 
            );
$ones = array( 
            0 => " ",
            1 => "One",     
            2 => "Two", 
            3 => "Three", 
            4 => "Four", 
            5 => "Five", 
            6 => "Six", 
            7 => "Seven", 
            8 => "Eight", 
            9 => "Nine", 
            10 => "Ten", 
            11 => "Eleven", 
            12 => "Twelve", 
            13 => "Thirteen", 
            14 => "Fourteen", 
            15 => "Fifteen", 
            16 => "Sixteen", 
            17 => "Seventeen", 
            18 => "Eighteen", 
            19 => "Nineteen" 
            ); 
$tens = array( 
            0 => "",
            2 => "Twenty", 
            3 => "Thirty", 
            4 => "Forty", 
            5 => "Fifty", 
            6 => "Sixty", 
            7 => "Seventy", 
            8 => "Eighty", 
            9 => "Ninety" 
            ); 
$hundreds = array( 
            "Hundred", 
            "Thousand", 
            "Million", 
            "Billion", 
            "Trillion", 
            "Quadrillion" 
            ); //limit t quadrillion 
$num = number_format($num,2,".",","); 
$num_arr = explode(".",$num); 
$wholenum = $num_arr[0]; 
$decnum = $num_arr[1]; 
$whole_arr = array_reverse(explode(",",$wholenum)); 
krsort($whole_arr); 
$rettxt = ""; 
foreach($whole_arr as $key => $i){ 
    if($i < 20){ 
        $rettxt .= $ones[$i]; 
    }
    elseif($i < 100){ 
        $rettxt .= $tens[substr($i,0,1)]; 
        $rettxt .= " ".$ones[substr($i,1,1)]; 
    }
    else{ 
        $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
        $rettxt .= " ".$tens[substr($i,1,1)]; 
        $rettxt .= " ".$ones[substr($i,2,1)]; 
    } 
    if($key > 0){ 
        $rettxt .= " ".$hundreds[$key]." "; 
    } 

} 
$rettxt = $rettxt." Taka";

if($decnum > 0){ 
    $rettxt .= " and "; 
    if($decnum < 20){ 
        $rettxt .= $decones[$decnum]; 
    }
    elseif($decnum < 100){ 
        $rettxt .= $tens[substr($decnum,0,1)]; 
        $rettxt .= " ".$ones[substr($decnum,1,1)]; 
    }
    $rettxt = $rettxt." Paisa"; 
} 
return $rettxt;} ?>
