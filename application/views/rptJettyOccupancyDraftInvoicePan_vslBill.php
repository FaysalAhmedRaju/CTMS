
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
		</table>	
		<!--div align="center">(LCL BILL)</div-->

</head>
<body>	
		<div align ="center">
			<table align="center" width="95%">

				<tr>
					<td align="left" style="width:15%">BILL NO</td>
					<td align="left" style="width:15%">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['draftNumber'];?></td>
					<td align="left" style="width:10%"></td>
					<td align="left" style="width:10%">BILL DATE</td>
					<td align="left" style="width:25%">: &nbsp;&nbsp;<?php echo DATE($bill_rslt[0]['created']);?></td>
				</tr>
				<tr>
					<td align="left">VESSEL NAME</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['vesselName'];?></td>
					<td align="left"></td>
					<td align="left">CREATOR</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['creator'];?></td>
				</tr>
				<tr>
					<td align="left">ROT NO</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['ibVoyageNbr'];?></td>
					<td align="left"></td>
					<td align="left">JETTY NO</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['berth'];?></td>
					
				<tr>
					<td align="left">NAME OF MASTER</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['captain'];?></td>
					<td align="left"></td>
					<td align="left">FLAG</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['flagcountry'];?></td>
					
				</tr>
				<tr>
					<td align="left">DATE OF BERTHING</td>
					<td align="left">: &nbsp;&nbsp;<?php echo date($bill_rslt[0]['ATA']);?></td>
					<td align="left"></td>
					<td align="left">DECK CARGO</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['cargo'];?></td>
				</tr>
				<tr>
					<td align="left">DATE OF LEAVING</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['ATD'];?></td> 
					<td align="left"></td>
					<td align="left">B.B/O.A.DATE</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['ffd'];?></td>
				</tr>
				<tr>
					<td align="left">AGENT CODE</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['payeecustomerkey'];?></td>
					<td align="left"></td>
					<td align="left"></td>
					<td align="left"></td>
					
				</tr>
				<tr>
					<td align="left">AGENT NAME</td>
					<td colspan="3" align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['customerName'];?></td>
					<td align="left"></td>
				</tr>	
				<tr>
					<td align="left">AGENT ADERESS</td>
					<td colspan="3" align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['agent_address'];?></td>
					<td align="left"></td>
				</tr>		
				<tr>
					<td align="left">GRT OF VESSEL</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $bill_rslt[0]['grossRevenueTons'];?></td>
					<td align="left"></td>
				
				</tr>
			</table>	
			<table align="center" width="95%">
				<tr>
					<td align="left">DESCRIPTION</td>
					<td align="left">A/C</td>
					<td align="right">RATE BDT</td>
					<td align="center">BAS</td>
					<td align="center">UNIT</td>
					<!--td align="left">MOVE</td-->
					<td align="right">AMOUNT(BDT)</td>
					<!--td align="right">VAT(BDT)</td-->
				</tr>
				<tr>
					<td colspan="8">
						<hr/>
					</td>
				</tr>
					
				<?php
				$total=0;
				$vatTotal=0;
				for($i=0; $i<count($bill_rslt); $i++) {?>
				
				<tr>
					<td align="left"><?php echo $bill_rslt[$i]['description'];?></td>
					<td align="left"><?php echo $bill_rslt[$i]['glcode'];?></td>
					<td align="right"><?php if (strpos($bill_rslt[$i]['rateBilled'], '.') !== false) {
												echo $bill_rslt[$i]['rateBilled'];
											} else {
												echo $bill_rslt[$i]['rateBilled'].".00";
											}?></td>
					<td align="center"><?php echo $bill_rslt[$i]['quantityUnit'];?></td>
					<td align="center"><?php echo $bill_rslt[$i]['quantityBilled'];?></td>
					<!--td align="right"><?php echo $bill_rslt[$i]['move'];?></td-->
					<td align="right"><?php if (strpos($bill_rslt[$i]['totbsd'], '.') !== false) {
												echo $bill_rslt[$i]['totbsd'];
											} else {
												echo $bill_rslt[$i]['totbsd'].".00";
											}?></td>
					<!--td align="right"><?php echo $bill_rslt[$i]['bdVat'];?></td-->
				</tr>
				<?php   
				 $total=$total+$bill_rslt[$i]['totbsd'];
				// $vatTotal=$vatTotal+$bill_rslt[$i]['bdVat'];
				} 
			 $itotalCharge = $total;
				// $total=$total;
				// $vatTotalCharge=(int)$vatTotal;
				
				
				?>
				<tr>
					<td colspan="8">
						<hr/>
					</td>
				</tr>
				<tr>
					<td colspan="5" align="right">TOTAL TK :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td align="right"><?php if (strpos($itotalCharge, '.') !== false) {
												echo $itotalCharge;
											} else {
												echo $itotalCharge.".00";
											}?></td>
					<!--td align="right"><?php  if (strpos($vatTotalCharge, '.') !== false) {
												echo $vatTotalCharge;
											} else {
												echo $vatTotalCharge.".00";
											}?></td-->

				</tr>
			</table>
			<table align="center" width="85%">
				<tr>
					<td colspan="6">
						<table align="left">
							<tr>
								<td align ="left">
									<font size="4"><b>IN WORDS </font></b> </b>
								</td>
								<td> : </td>
								<td> <?php  echo numtowords($total)." Only";?> </td>
							</tr>	
							<!--tr>	
								<td align ="left">
								  <font size="4"><b> VAT </font></b> </b>
								</td>
								<td> : </td>
								<td> <?php echo numtowords($vatTotal)." Only";?> </td>
							</tr-->
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
						<b>COMPUTER OPERATOR</b>
					</td>
					<td align="left" colspan="2">
						<b>CHECKED BY</b>
					</td>
					<td align="left" colspan="2">
						<b>FOR CF & AC</b>
					</td>
				</tr>
				<tr>
					<td align="left" colspan="6">
						BILL DATE: &nbsp;&nbsp;<?php echo DATE($bill_rslt[0]['created']);?>
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
				<!--tr>
					<td colspan="6"><font size="3">Note: Water Supply Charge calculated by per 1000 Litres</font></td>
				</tr-->
				
				
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
