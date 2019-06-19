
<html>
<head>
		<div align="center" style="">
			<title><b>CHITTAGONG PORT AUTHORITY</b></title>
		</div>
		<div align="center">ONE STOP SERVICE CENTER</div>
		<div align="center">(LCL BILL)</div>

</head>
<body>	
		<div align ="center">
			<table align="center" width="100%">
				<tr style="border-bottom:1px solid black">
					<td>VERIFY NO : <?php echo $verify_number;?></td>
					<td>UNIT NO : <?php echo $unit_no;?></td>
					<td>CPA VAT REG NO : <?php echo $cpa_vat_reg_no;?></td>
					<td>EX.RATE($) : <?php echo $ex_rate;?></td>
				</tr>			
			</table>
			<hr>
			<table align="center" width="100%">
			 <?php       
					for($i=0;$i<count($rtnContainerList);$i++) { 
					 ?>
				<tr style="border-bottom:1px solid black">
					<td>BILL NO : <?php echo $rtnContainerList[$i]['bill_no'];?></td>
					<td>DATE : <?php echo date("y-m-d");?></td>
					<td>ARRAIVAL DATE : <?php echo $rtnContainerList[$i]['arraival_date'];?></td>
				</tr>
				<tr style="border-bottom:1px solid black">
					<td>ROT NO : <?php echo $rtnContainerList[$i]['import_rotation'];?></td>
					<td>VSL NAME : <?php echo $rtnContainerList[$i]['vessel_name'];?></td>
					<td>C/L DATE : </td>
				</tr>	
				<tr style="border-bottom:1px solid black">
					<td>LINE/BL NO : <?php echo $rtnContainerList[$i]['bl_no'];?></td>
					<td>W/R DATE : <?php echo $rtnContainerList[$i]['wr_date'];?></td>
					<td>W/R BILL UPTO : <?php echo $rtnContainerList[$i]['wr_upto_date'];?></td>
				</tr>	
				<tr style="border-bottom:1px solid black">
					<td>VAT REG NO : </td>
					<td>IMPORTER : </td>
				</tr>	
				<tr style="border-bottom:1px solid black">
					<td>C&F LC NO : <?php echo $rtnContainerList[$i]['cnf_lic_no'];?></td>
					<td>C&F AGENT : <?php echo $rtnContainerList[$i]['cnf_agent'];?></td>
				</tr>	
				<tr style="border-bottom:1px solid black">
					<td>BE NO : <?php echo $rtnContainerList[$i]['be_no'];?></td>
					<td>BE DATE : <?php echo $rtnContainerList[$i]['be_date'];?></td>
				</tr>	
				<tr style="border-bottom:1px solid black">
					<td>ADO NO : </td>
					<td>ADO DATE : </td>
					<td>ADO VALID UPTO : </td>
				</tr>	
				<tr style="border-bottom:1px solid black">
					<td>MANIFEST QTY : <?php echo $rtnContainerList[$i]['manifest_qty']."*".$rtnContainerList[$i]['cont_size']."*".$rtnContainerList[$i]['cont_height'];?></td>
				</tr>
					<?Php }?>
			</table>
			<div align="center"><u>QNTY FOR WHICH CHARGE MADE</u></div>
			<table align="center"  cellpadding="1" cellspacing="1" style="border-top: 1px solid black;border-bottom: 1px solid black;">
				<thead style="">
					<tr style="border-top: 1px solid black;">		
						<th align="center" >CODE</th>
						<th align="center" >DESCRIPTION</th>
						<th align="center" >RATE(T/$)</th>
						<th align="center" >QNTY</th>
						<th align="center" >DAYS</th>
						<th align="center" >PORT(TK)</th>
						<th align="center" >VAT(TK)</th>
						<th align="center" >MLWF(TK)</th>
					</tr>
				</thead>
				<tbody>
					 <?php       
					for($i=0;$i<count($chargeList);$i++) { 
					 ?>
					 <tr class="" style="page-break-inside:avoid; page-break-after:auto;"> 
					  
					  <td align="center">
					   <?php echo $chargeList[$i]['gl_code']?>
					  </td>
					  <td align="left">
					   <?php echo $chargeList[$i]['description']?>
					  </td>
					  <td align="center">
					   <?php echo $chargeList[$i]['tarrif_rate']?>
					  </td>
					  <td align="center">
					   <?php echo $chargeList[$i]['Qty']?>
					  </td>
					  <td align="center">
					   <?php if($chargeList[$i]['gl_code']!=206031 && $chargeList[$i]['gl_code']!=206033 && $chargeList[$i]['gl_code']!=206035 && $chargeList[$i]['gl_code']!=206037 && $chargeList[$i]['gl_code']!=206039 && $chargeList[$i]['gl_code']!=206041 && $chargeList[$i]['qday']=1) {?>
						<?php echo "";} else {?>
						<?php echo $chargeList[$i]['qday'];}?>
					  </td>
					  <td align="center">
					   <?php echo $chargeList[$i]['amt']?>
					  </td>
					  <td align="center">
					   <?php echo $chargeList[$i]['vatTK']?>
					  </td>
					  <td align="center">
					   
					  </td>
					</tr>
					 <?php
					}
				   ?>
				</tbody>
			</table>
			<table>
				<tr>
					<td>
						SHOW RATE IN US$ TOTAL DAYS : <?php echo $tot_qday;?></b>
					</td>
					<td>
						TOTAL(TK) : <?php echo $tot_sum;?></b>
					</td>
				</tr>
				<tr >
					<td colspan="4">NET AMOUNT : <?php $ait=($tot_sum * 0.1); $other= $tot_sum - $ait; echo "( ".$other." + AIT 10% ".$ait." )"?></td>
					<td>PORT : <?php echo $tot_sum;?></b></td>
				</tr>
				<tr>
					<td align="center" colspan="5">
						<b>NET PAYABLE (TK) : <?php echo $tot_sum;?></b>
					</td>
				</tr>
				<tr>
					<td colspan="5">
						REMARKS :  <?php echo numtowords($tot_sum); ?>
						
					</td>
				</tr>
				<tr>
					<td colspan="5">
						<b>SHOULD BE PAID ON BEFORE <?php for($i=0;$i<count($rtnContainerList);$i++) {  echo $rtnContainerList[$i]['wr_upto_date'];}?></b> 
					</td>
				</tr>
				<tr>
					<td>BANK'S SEAL</td><td></td>
					<td>C&F AGENT</td><td></td>
					<td>BILL CLERK</td><td></td>
					<td>L/C NO</td><td></td>
					<td>UNIT NO </td><td><?php echo $unit_no;?></td>
				</tr>
			</table>
			<?php 
			if($rcvstat==1)
			{
			?>
			<table style="border: 1px solid black">
				<tr>
					<td>Bank Name</td>
					<td>:</td>
					<td><?php echo $cpbankname;?></td>
				</tr>
				<tr>
					<td>CP NO</td>
					<td>:</td>
					<td><?php echo $cpnoview;?></td>
				</tr>
				<tr>
					<td>Date</td>
					<td>:</td>
					<td><?php echo $recv_time;?></td>
				</tr>
				<tr>
					<td>Receive By</td>
					<td>:</td>
					<td><?php echo $recv_by;?></td>
				</tr>
			</table>
			<?php } ?>
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
