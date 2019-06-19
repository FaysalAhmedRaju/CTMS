<html>
	<head>
		
	</head>
<body>
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
			<td ></td>
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

	<div  align="left" style="padding-left:75px; font-size:11px " > Summary of cart tickets issued daily (to be filled in by the Delivery Clerk). <font size=4><b><?php echo $orderList[0]['cnf_name']?></b></font> 

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
	
</html>