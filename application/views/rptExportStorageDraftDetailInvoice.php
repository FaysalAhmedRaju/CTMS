
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
				<td align="center">MLO WISE EXPORT STORAGE CONTAINER LIST<?php // echo $rslt_detail[0]['invoiceDesc'];?></td>
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
					<td align="left">Int Ref No</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $rslt_detail[0]['draftNumber'];?></td>
					<td align="left" style="width:10%"></td>
					<td align="left">Voyage No</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $rslt_detail[0]['obVisitId'];?></td>
					<td align="left" style="width:10%"></td>
					<td align="left">Date</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $rslt_detail[0]['created'];?></td>
				</tr>
				<tr>
					<td align="left">Vessel </td>
					<td align="left">: &nbsp;&nbsp;<?php echo $rslt_detail[0]['obCarrierName'];?></td>
					<td align="left" style="width:10%"></td>
					<td align="left">MLO</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $rslt_detail[0]['customerId'];?></td>
					<td align="left" style="width:10%"></td>
					<td align="left">Agent</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $rslt_detail[0]['concustomerid'];?></td>
				</tr>
				<tr>
					<td align="left"></td>
					<td align="left"></td>
					<td align="left" style="width:10%"></td>
					<td align="left">MLO Name</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $rslt_detail[0]['customerName'];?></td>
					<td align="left" style="width:10%"></td>
					<td align="left">Agent Name</td>
					<td align="left">: &nbsp;&nbsp;<?php echo $rslt_detail[0]['concustomername'];?></td>
				</tr>
			</table>	
			<table align="center" width="100%">
				<tr>
					<td colspan="9">
						<hr style=" border-top:1px dotted; color:black;"/>
					</td>
				</tr>
				<tr>
					<td style="width:50px" align="left">SL</td>
					<td align="left" >CONTAINER NO</td>
					<td align="right">SIZE</td>
					<td align="right">HEIGHT</td>
					<td align="center">STATUS</td>
					<td align="center">STORAGE FROM</td>
					<td align="center">STORAGE TO</td>
					<td align="right">DAYS</td>
					<td align="right">VAT(%)</td>
				</tr>
				<tr>
					<td colspan="9">
						<hr style=" border-top:1px dotted; color:black;"/>
					</td>
				</tr>
					
				<?php
		/* 		$size20=0;
				$size40=0;
				$size45=0;

                $sumAmt=0;
                $sumVat=0;
                $sum=0;
                $sumTotal=0; */
				
				for($i=0; $i<count($rslt_detail); $i++) {?>
				
				<tr>
					<td align="left"><?php echo $i+1;?></td>
					<td align="center"><?php echo $rslt_detail[$i]['unitId'];?></td>
					<td align="center"><?php echo $rslt_detail[$i]['isoLength'];?></td>
					<td align="center"><?php echo $rslt_detail[$i]['isoHeight'];?></td>
					<td align="center"><?php echo $rslt_detail[$i]['freightKind'];?></td>
					<td align="center"><?php echo $rslt_detail[$i]['eventFrom'];?></td>
					<td align="center"><?php echo $rslt_detail[$i]['eventTo'];?></td>
					<td align="center"><?php echo $rslt_detail[$i]['days'];?></td>
					<td align="center"><?php echo $rslt_detail[$i]['vatperc'];?></td>					
				</tr>
				<?php  } ?>


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
}
?>