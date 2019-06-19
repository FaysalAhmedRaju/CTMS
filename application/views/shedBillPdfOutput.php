
<html>
<head>
		

</head>
<body>	
		<?php 
		for ($billTime=0;$billTime<$bill_print_times;$billTime++)
		{
		?>
		<?php if($billTime<$bill_print_times-1) {?>
		<div class="pageBreak" style="position: relative;">
		<?php } else {?>
		<div class="pageBreakOff" style="position: relative;">
		<?php }?>
		<div align="center" style="">
			<title><b>CHITTAGONG PORT AUTHORITY</b></title>
		</div>
		<div align="center">ONE STOP SERVICE CENTER</div>
		<div align="center">(LCL BILL)</div>
		
		<div align ="center">
			<table align="center" style="width:80%">
				<tr style="border-bottom:1px solid black">
					<td><font size="1pt">VERIFY NO : <?php echo $verify_number;?></font></td>
					<td><font size="1pt">UNIT NO : <?php echo $unit_no;?></font></td>
					<td><font size="1pt">CPA VAT REG NO : <?php echo $cpa_vat_reg_no;?></font></td>
					<td><font size="1pt">EX.RATE($) : <?php echo $ex_rate;?></font></td>
				</tr>			
			</table>
			<hr width="80%">
			<table align="center" style="width:80%">
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
					<td>UNSTUFFING DATE : <?php echo $rtnContainerList[$i]['wr_date'];?></td>
				</tr>	
				<tr style="border-bottom:1px solid black">
					<td>LINE/BL NO : <?php echo $rtnContainerList[$i]['bl_no'];?></td>
					<td>W/R DATE : <?php echo $rtnContainerList[$i]['wr_date'];?></td>
					<td>W/R BILL UPTO : <?php echo $rtnContainerList[$i]['wr_upto_date'];?></td>
				</tr>	
				<tr style="border-bottom:1px solid black">
					<td>VAT REG NO : <?php echo $rtnContainerList[$i]['cpa_vat_reg_no'];?></td>
					<td>IMPORTER : <?php echo $rtnContainerList[$i]['importer_name'];?></td>
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
					<td>ADO NO : <?php echo $rtnContainerList[$i]['ado_no'];?></td>
					<td>ADO DATE : <?php echo $rtnContainerList[$i]['ado_date'];?></td>
					<td>ADO VALID UPTO : <?php echo $rtnContainerList[$i]['ado_valid_upto'];?></td>
				</tr>	
				<tr style="border-bottom:1px solid black">
					<td>MANIFEST QTY : <?php echo $rtnContainerList[$i]['manifest_qty']."*".$rtnContainerList[$i]['cont_size']."*".$rtnContainerList[$i]['cont_height'];?></td>
				</tr>
					<?Php }?>
			</table>
			<div align="center"><u>QNTY FOR WHICH CHARGE MADE</u></div>
			<table align="center"  cellpadding="1" cellspacing="1" style="width:80%;border-top: 1px solid black;border-bottom: 1px solid black;">
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
				<?php       
					$totmlwf = 0;
					for($i=0;$i<count($chargeList);$i++) 
					{ 
						$totmlwf = $totmlwf+$chargeList[$i]['mlwfTK'];
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
					   <?php echo $chargeList[$i]['mlwfTK']?>
					  </td>
					</tr>
					 <?php
					}
				   ?>
			</table>
			
		</div>
		<div align="center" class="fixed">
			<table align="center" style="width:80%">
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
						<b>NET PAYABLE (TK) : <?php echo $tot_sum+$totmlwf;?></b>
					</td>
				</tr>
				<tr>
					<td colspan="5">
						REMARKS :  <?php echo numtowords($tot_sum+$totmlwf); ?>
						
					</td>
				</tr>
				<tr>
					<td colspan="5">
						<b>SHOULD BE PAID ON BEFORE <?php for($i=0;$i<count($rtnContainerList);$i++) {  echo $rtnContainerList[$i]['wr_upto_date'];}?></b> 
					</td>
				</tr>
				<!--tr>
					<td>BANK'S SEAL</td>
					<td>C&F AGENT</td>
					<td>BILL CLERK <u><?php echo $recv_by;?></u></td>
					<td>L/C NO</td>
					<td>UNIT NO <u><?php echo $unit_no;?></u></td>
				</tr-->
			</table>
			<table align="center" style="width:80%">
				<tr>
					<td>BANK'S SEAL</td>
					<td>C&F AGENT</td>
					<td>BILL CLERK : <?php echo $bill_clerk;?></td>
					<td>L/C NO</td>
					<td>UNIT NO : <?php echo $unit_no;?></td>
				</tr>
			</table>
			<?php 
			if($rcvstat==1)
			{
			?>
			<table style="margin-left:12%;border: 1px solid black">
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
					<td>S :</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>N : <?php echo $recv_by;?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>D :</td>
				</tr>
			</table>
			<?php } ?>
			</div>
	</div>
	<?php }?>
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

<?php if($billFrmRls==1) {?>
<div style="page-break-after: always;">
	</div>
<div>
	<table width=100% >
		<tr align="center">
			<td align="center" style="font-size:22px" ><b><?php echo $orderList[0]['cnf_name']?></b></td>
		</tr>
		<!--tr><td align="center" style="font-size:17px" ><b> SELF C&F </b> </td></tr>
		<tr align="center" >
			<td colspan="2" style="font-size:17px"><p> 532/533, Sk. Mujib Road, Dewanhat, Chittagong </p></td>
		</tr>
		<tr align="center" >
		    <td colspan="2" style="font-size:17px"><p> Phone: 031-718185, Mobile: 01712-232155, 01721-166690 </p></td>
		</tr-->
		<tr>
			<td align="center" style="font-size:17px" align="center"><b><nobr>CHITTAGONG PORT AUTHORITY </nobr></b></td>
		</tr>
		<tr>
			<td align="center" style="font-size:17px" align="center"><b>SHED DELIVERY ORDER </b></td>
		</tr>
	</table>
	
	
	<table align="center" width=95%>
		<tr><td colspan="2" style="font-size:11px">Rot No. <b> <?php echo $orderList[0]['Import_Rotation_No']?> </b></td></tr>
		<tr><td colspan="2" style="font-size:11px">Line No.& B/L NO.  <b> <?php echo $orderList[0]['BL_No']?> </b> </td></tr>
		<tr><td align="left" width="56%" style="font-size:11px"><nobr>For goods Ex. S. S.<b>&nbsp;&nbsp; <?php echo $orderList[0]['Vessel_Name']?> &nbsp;</b> Consigned to</nobr></td><td align="left" style="font-size:16px"><b> <?php echo $orderList[0]['cnf_name']?></b></td></tr>
		<tr><td colspan="2" style="font-size:11px">Y/Shed No: &nbsp;&nbsp; <b> <?php echo  $orderList[0]['shed_yard']?> &nbsp;&nbsp;</b>  R.O. No. U________________Date______________B/E. No.  <b> &nbsp;&nbsp;<?php echo $orderList[0]['be_no']?>&nbsp;&nbsp; </b> date. <b> &nbsp;&nbsp;<?php echo $orderList[0]['be_date']?> </b></td></tr>
	</table>
	<table><tr><td>&nbsp;</td></tr></table>

	
	<table align="center" border="1" width=95% style="border-collapse: collapse;">
	    <tr>
		   <td align="center" colspan="4" style="font-size:12px"> Particulars of Consignment</td> 
		   <td align="center" colspan="3" style="font-size:12px"> Particulars of wrong marks or no marks application</td>
		</tr>
		<tr align="center">
		   <td align="center" style="font-size:12px"> Marks and Nos.</td> 
		   <td align="center" style="font-size:12px"> Quantity and Description</td>
		   <td align="center" style="font-size:12px"> Marks and Nos</td>
		   <td align="center" style="font-size:12px"> Quantity and Description</td>
		   <td align="center" style="font-size:12px"> Date of application</td>
		   <td align="center" style="font-size:12px"> Marks and landed</td>
		   <td align="center" style="font-size:12px"> Signature of Head Shed Clerk</td>
		</tr>
		
		<tr>
		    <td style="font-size:11px"> <?php echo $orderList[0]['Pack_Marks_Number']?> </td>
			<td style="font-size:11px"> <?php echo $orderList[0]['Description_of_Goods']?> </td>
			<td style="font-size:11px"> <?php echo $orderList[0]['Pack_Marks_Number']?></td>
			<td style="font-size:11px"> <?php echo $orderList[0]['Description_of_Goods']?></td>
			<td style="font-size:11px"></td>
			<td style="font-size:11px"></td>
			<td style="font-size:11px"></td>	
		</tr>
		  <?php for($i=0; $i<8; $i++) {?>
		
		<tr>
		    <td height="20px"></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>	
		</tr>
		  <?php } ?>
		
	</table>
	
	<table  align="center" border="1" width=95% style="border-collapse: collapse;">
		<tr>
		   <td align="center" width="10%" rowspan="2" style="font-size:12px"> Date </td> 
		   <td align="center" colspan="3" style="font-size:12px">Particulars of Delivery</td>		    
		   <td align="center" rowspan="2" style="font-size:12px" >Consignee's Signature </td>
		   <td align="center" rowspan="2" style="font-size:12px">Head Clerk's Signature</td>
		   <td align="center" rowspan="2" style="font-size:12px">Delivery Clerk's Signature</td>
		   <td align="center"  rowspan="2" style="font-size:12px;" >Remarks of Consignee</br>or his Agent,why</br>Delivery not taken in</br> full(see instruction overleaf) </td>

		</tr>
		<tr><td align="center" style="font-size:12px">No. applied for</td> 
			<td align="center" style="font-size:12px">No. delivered </td>	
		    <td align="center" style="font-size:12px">Balanced due</td></tr>
		 
		</tr>
		<?php for($i=0; $i<14; $i++) {?>
		<tr>
        	<td width="" height="20px"></td>
			<td width=""></td>
			<td width=""></td>
			<td width=""></td>
			<td width=""></td>
			<td width=""></td>
			<td width=""></td>	
			<td width=""></td>	
		</tr>
		  <?php } ?>
		
	</table>
	</div>
	<div style="page-break-after: always;">
	</div>
		
	<div align="center" style="width:95%; padding-left: 30px; " >
	<p  style="font-size:11px">&nbsp; &nbsp; &nbsp; &nbsp; 1. Any consignee or his representative failing to remove on the day declared for delivery: on the packages declared
	should in his own interest not on his documents at the close of the day's work, his reasons for not removing those left on the
	Port Commissioner's premises. Unless this nothing is made and accepted by the S. M. S. P. or delivery Foreman Claims for 
	remission of Scheduled rent charges will not be entertained and claims  for damage of lost goods may fall for lack of evidence.</p>
	
	<p  style="font-size:11px">&nbsp; &nbsp; &nbsp; &nbsp; 2.If reason so recorded disclose a shortage, damage or other discrepancy, the Delivery Clerk will at once bring the
	matter specially to the notice of Shed Master who will initial the consignee's remarks and immediately and personally 
	investigate and report the result to his Superintendent if no shortage, damage or other discrepancy is alleged or if no note is
	made on this document by the consignee, the Delivery Clerk will sign and hand it over to the Shed Manager at once.</p>
	
	<p  style="font-size:11px">&nbsp; &nbsp; &nbsp; &nbsp; 3.Packages pilfered or damaged to the extent mentioned in the Lockfast Rules must be removed to the Lockfast if and
	when goods once reported missing are found letter. The Shed Manager must see that the column date found correctly posted
	in the missing goods register and that the marks and numbers of the packages are posted on the Shed Notice board for the
	information of the consignees. </p>
	</div>

	<div align="left" style="padding-left:75px; font-size:11px"> Summary of cart tickets issued daily (to be filled in by the Delivery Clerk). <font size=4><b><?php echo $orderList[0]['cnf_name']?></b></font> 

		<table  align="center" border="1" width=95% style="border-collapse: collapse;">
		
		<tr>
		   <td align="center" style="border-left-style: none;"> Date </td> 
		   <td align="center" >Truck No.</td>		    
		   <td align="center" >Qty</td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center"></td>		    
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center"></td>		    
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center"></td>		    
		   <td align="center" ></td>
		   <td align="center" width="90px" style="border-right-style: none;" ></td>
		</tr>
		
		<?php
		$totalRow=15;
		$remainRow=$totalRow-$truckCount;
		?>
		 <?php for($i=0; $i<$truckCount; $i++){?>
		<tr>
           <td align="center" width="90px" height="25px" style="border-left-style: none;" >  </td> 
		   <td align="center" ><?php echo $truckDetails[$i]['truck_id'];?></td>		    
		   <td align="center" ><?php echo $truckDetails[$i]['delv_pack'];?></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center"></td>		    
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center"></td>		    
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center"></td>		    
		   <td align="center" ></td>
		   <td align="center"  width="90px" style="border-right-style: none;"  ></td>
		</tr>
		 <?php }?>

		
		 <?php for($i=0; $i<$remainRow; $i++){?>
		<tr>
           <td align="center" width="90px" height="25px" style="border-left-style: none;" >  </td> 
		   <td align="center" ></td>		    
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center"></td>		    
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center"></td>		    
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center"></td>		    
		   <td align="center" ></td>
		   <td align="center"  width="90px" style="border-right-style: none;"  ></td>
		</tr>
		 <?php }?>

		 <tr>
		   <td align="center" width="90px"  height="25px" style="border-left-style: none;" ><font size=3><b>Total </b></font></td> 
		   <td align="center" ></td>		    
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center"></td>		    
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center"></td>		    
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center"></td>		    
		   <td align="center" ></td>
		   <td align="center"  width="90px" style="border-right-style: none;"></td>
		</tr>
		<tr>
		   <td align="center" height="25px" style="border-left-style: none;"> <font size=1><b>Delivery</br> Clerk's</br> Initials </b></font></td> 
		   <td align="center" ></td>		    
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center"></td>		    
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center"></td>		    
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center" ></td>
		   <td align="center"></td>		    
		   <td align="center" ></td>
		   <td align="center" width="90px" style="border-right-style: none;" ></td>
		</tr>
	</table>
	</div>
<?php }?>
