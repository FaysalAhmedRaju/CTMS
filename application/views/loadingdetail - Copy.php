
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
			<td align="center"><b>MLO WISE LOADING CONTAINER LIST</b></td>
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
				<td align="left" style="width:5%">Voyage No</td>
				<td align="left" style="width:5%">:</td>
				<td align="left" style="width:20%"><?php echo $rslt_detail[0]['obVisitId'];?></td>
				<!--td align="left" style="width:5%"></td-->
				<td align="left" style="width:5%">Date</td>
				<td align="left" style="width:5%">:</td>
				<td align="left" style="width:20%"><?php echo $rslt_detail[0]['created'];?></td>
			</tr>
			<tr>
				<td align="left" style="width:10%">Vessel</td>
				<td align="left" style="width:5%">:</td>
				<td align="left" style="width:20%"><?php echo $rslt_detail[0]['obCarrierName'];?></td>
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
				<td align="left" style="width:20%"><?php echo $rslt_detail[0]['concustomername'];?></td>
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
					<td class="bottomtopborder" align="center">Shipment Date</td>
					<td class="bottomtopborder" align="center">Vat</td>
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
					<td align="center"><?php echo $rslt_detail[$i]['isoHeight']; ?></td>
					<td align="center"><?php echo $rslt_detail[$i]['freightKind']; ?></td>
					<td align="center"><?php echo $rslt_detail[$i]['landingDate']; ?></td>
					<td align="center"><?php echo $rslt_detail[$i]['vatperc']; ?></td>
				</tr>
				<?php   
				} 
				?>
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
