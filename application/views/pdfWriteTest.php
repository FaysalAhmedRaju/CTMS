<?php

include("mydbPConnection.php");
count($rtnTruckNumber);
for($i=0;$i<count($rtnTruckNumber);$i++)
{ 
	$sqlCartTicket="SELECT igm_supplimentary_detail.id,IFNULL(SUM(rcv_pack+loc_first),0) AS rcv_pack,igm_masters.Vessel_Name,igm_supplimentary_detail.Import_Rotation_No,igm_sup_detail_container.cont_number,Pack_Marks_Number,shed_loc,shed_yard,LEFT(Description_of_Goods,50) AS Description_of_Goods,Notify_name,IFNULL(shed_tally_info.verify_number,0) AS verify_number,IFNULL(shed_tally_info.id,0) AS verify_id,igm_supplimentary_detail.Pack_Number,igm_supplimentary_detail.Pack_Description,igm_supplimentary_detail.BL_No,igm_sup_detail_container.cont_size,igm_sup_detail_container.cont_status,igm_sup_detail_container.cont_weight,verify_other_data.cnf_name,verify_other_data.be_no,verify_other_data.be_date,igm_sup_detail_container.cont_height,truck_id,gate_no,cus_rel_odr_no
	FROM  igm_supplimentary_detail
	INNER JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
	INNER JOIN igm_masters ON igm_supplimentary_detail.igm_master_id=igm_masters.id
	LEFT JOIN  shed_tally_info ON shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
	LEFT JOIN verify_other_data ON shed_tally_info.id=verify_other_data.shed_tally_id
	LEFT JOIN do_information ON do_information.verify_no=shed_tally_info.verify_number
	WHERE shed_tally_info.verify_number='$verifyNo'";
				
	$rtnCartTicket = $this->bm->dataSelectDb1($sqlCartTicket);
	$data['rtnCartTicket']=$rtnCartTicket;
	
?>
<html>
	<head>
		<!--style>
			 table {border-collapse: collapse;}
		</style-->
	</head>
<body>

	<?php 
	if($i < count($rtnTruckNumber)-1) 
	{
	?>		
		<div class="tblBreak">
	<?php 
	} 
	else 
	{?>
		<div class="pageBreakOff">
	<?php 
	} 
	?>
	
	<table width="100%" border="0">
		<tr align="center">
			<!--td colspan="5" style="font-size:30px; font-weight: bold;">ORION INFUSION LTD.</td-->
			<td colspan="5" align="center" style="font-size:30px; font-weight: bold;"><?php echo $rtnCartTicket[0]['cnf_name'];?></td>
		</tr>
		<tr align="center">
			<td colspan="5" align="center" style="font-size:20px; font-weight: bold;">SELF C&F </td>
		</tr>
		<!--tr align="center">
			<td colspan="5">
				<p> 532/533, Sk. Mujib Road, Dewanhat, Chittagong </p>
			</td>
		</tr-->
		<!--tr align="center">
			<td colspan="5">
				<p> Phone: 031-718319, Mobile: 01819-841272, 01712-232155 </p>
			</td>
		</tr-->
		<tr >
			<td align="center" colspan="5">
				<p> CHITTAGONG PORT AUTHORITY </p>
			</td>
		</tr>
		<tr>
			<td colspan="5" align="center" style="font-size:20px; font-weight: bold;"><u>CART TICKET</u></td>
		</tr>
		<tr>
			<td width="70px" align="right">Rot No.&nbsp;&nbsp;&nbsp;</td>
			<td style="border-bottom:1px solid black"><?php echo $rtnCartTicket[0]['Import_Rotation_No'];?></td>
			<td>&nbsp;</td>
			<td width="50">Job No.</td>
			<td style="border-bottom:1px solid black"></td>
		</tr>
		<tr>
			<td width="30px" align="right">Line No.&nbsp;&nbsp;&nbsp;</td>
			<td style="border-bottom:1px solid black"><?php echo $rtnCartTicket[0]['BL_No'];?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
	</table>
	
	<table border="0" width="100%">
		<tr>
			<td >Shed No.</td>
			<td colspan="2" style="border-bottom:1px solid black; "><?php echo $rtnCartTicket[0]['shed_yard'];?></td>
			<td align="center" >Release Order No.</td>
			<td colspan="2 "style="border-bottom:1px solid black;"><?php echo $rtnCartTicket[0]['cus_rel_odr_no'];?></td>
			<td align="center">Of</td>
			<td style="border-bottom:1px solid black;"></td>
		</tr>
		<tr>
			<td >Ex. S/S. M/V</td>
			<td style="border-bottom:1px solid black;"><?php echo $rtnCartTicket[0]['Vessel_Name'];?></td>
			<td align="center">No</td>
			<td style="border-bottom:1px solid black;"></td>
			<td align="center">Consignee:</td>
			<td colspan="3" style="border-bottom:1px solid black;"><?php echo $rtnCartTicket[0]['cnf_name'];?></td>
		</tr>
		<tr>
			<td>B/E No.</td>
			<td style="border-bottom:1px solid black;"><?php echo $rtnCartTicket[0]['be_no'];?></td>
			<td align="center">of</td>
			<td style="border-bottom:1px solid black;"><?php echo $rtnCartTicket[0]['be_date'];?></td>
			<td align="center">Truck No.</td>
			<td style="border-bottom:1px solid black;"><?php echo $rtnTruckNumber[$i]['truck_id'];?></td>
			<td align="center">Gate No.</td>	
			<td align="center" style="border-bottom:1px solid black;" ><?php echo $rtnTruckNumber[$i]['gate_no'];?></td>
		</tr>
		<!--tr>
			<td>&nbsp;</td>
		</tr-->
	</table>
			
	<table border="1" width="100%" align="center">
		<tr>
			<th style="font-size:10px;">Marks</th>
			<th style="font-size:10px;">Description</th>
			<th style="font-size:10px;">Number</th>
			<th style="font-size:10px;">Tally</th>
			<th style="font-size:10px;">Consecutive Carts Total</th>
		</tr>
		<tr align="center">
			<td rowspan="2" width="50px" style="font-size:12px;"><?php echo $rtnCartTicket[0]['Pack_Marks_Number'];?></td>
			<td rowspan="2" width="350px" style="font-size:12px;"><?php echo $rtnCartTicket[0]['Description_of_Goods'];?></td>
			<td align="center" height="25px" width="30px" style="font-size:12px;"><?php echo $rtnTruckNumber[$i]['delv_pack'];?></td>
			<td height="25px"></td>
			<td align="center" height="25px" width="80px" style="font-size:12px;"><?php echo $rtnCartTicket[0]['Pack_Number'];?></td>
		</tr>
		<tr align="center">
			<td height="25px"></td>
			<td height="25px"></td>
			<td height="25px"></td>
		</tr>
		<tr align="center">
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td height="25px"></td>
			<td height="25px"></td>
			<td height="25px"></td>
		</tr>
		<tr align="center">
			<td height="25px"></td>
			<td height="25px"></td>
			<td height="25px"></td>
		</tr>
		<tr align="center">
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td height="25px"></td>
			<td height="25px"></td>
			<td height="25px"></td>
		</tr>
		<tr align="center">
			<td height="25px"></td>
			<td height="25px"></td>
			<td height="25px"></td>
		</tr>
		<tr align="center">
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td height="25px"></td>
			<td height="25px"></td>
			<td height="25px"></td>
		</tr>
		<tr align="center">
			<td height="25px"></td>
			<td height="25px"></td>
			<td height="25px"></td>
		</tr>
		<tr align="center">
			<td rowspan="2"></td>
			<td rowspan="2"></td>
			<td height="25px"></td>
			<td height="25px"></td>
			<td height="25px"></td>
		</tr>
		<tr align="center">
			<td height="25px"></td>
			<td height="25px"></td>
			<td height="25px"></td>
		</tr>
	</table>
			
		
	<table border="0" >
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" style="font-size:14px;">Total Packages (in words)</td>
			<td style="border-bottom:1px solid black;" colspan="6"></td>
		</tr>
		<tr>
			<td colspan="3" style="font-size:18px;">Received the above in full.</td>
			<td colspan="3" style="width:200px; font-size:18px;">For-<?php echo $rtnCartTicket[0]['cnf_name'];?></td>
			<td colspan="2" style="width:200px; font-size:18px;" align="right">Checked and found ok</td>
		</tr>
		<tr>
			<td colspan="8">&nbsp;</td>
		</tr>
		<tr>
			<td style="font-size:18px;">Date</td>
			<td style="border-bottom:1px solid black; width:150px; font-size:12px;"></td>
			<td style="font-size:18px;">Consignee's Signature</td>
			<td style="width:250px"></td>
			<td style="font-size:18px;">Delivery Clerk</td>
			<td style="width:250px"></td>
			<td style="font-size:18px;">Gate Sargent</td>	
			<td style="width:250px"></td>
		</tr>
		<tr>
			<td colspan="8" style="border-bottom:1px solid black; width:200px">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="8" style="font-size:18px;">N.B.: Loss of Cart Ticket must immediately be reported to the Shed Master of Shed Foreman. Unused Cart Ticket must be returned to the delivery Foreman on the same day they were issued</td>
		</tr>
		<tr>
			<td colspan="8">&nbsp;</td>
		</tr>
	</table>
		<?php //$mpdf->AddPage();?>
	</div>
</body>
</html>
<?php
}
?>
