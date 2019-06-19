<html>
	<head>
		<title>RELEASE ORDER FOR DELEVERY</title>
		<style>
			 table {border-collapse: collapse;}
			 .left{
					width:300px;
					float:left;
					height:100%;
				}
				.middle{
					margin-left:20px;
					width:300px;
					float:left;
					height:100%;
				}
				.right{
					margin-left:20px;
				}
				
				#borderDiv{
					border-bottom:1px dotted red;
				}
				
				@media print {
							@page { 
									size: auto;/* auto is the initial value */
									margin: 5px;
									}
							@page port { size: portrait; }
							  .portrait { page: port; page-break-after: always;}
							@page land { size: landscape; }
							  .landscape { page: land;											
											-webkit-transform: rotate(-90deg) scale(.75,1.15);
											-moz-transform: rotate(-90deg) scale(.80);											
											zoom: 90%;	
											width: 100%;
											height: 100%;
										}       
							body  { margin: 0 cm;}
						.breakPage { page-break-after: auto; }
						.left{
							width:350px;
							float:left;
							height:100%;
						}
						.middle{
							margin-left:20px;
							width:350px;
							float:right;
							height:100%;
						}
						div.fixed {
							position: absolute;
							bottom: 0;
							right: 0;
							width: 100%;
							align:left;
						}
						
						#borderDiv{
							border-bottom:none;
						}
					}
		</style>
	</head>
	<body>
		<?php 
		for($i=0;$i<count($rtnContainerList);$i++)
		{
		?>
		<div id="borderDiv">
		<div class="portrait">
		<table width="100%" cellpadding="0">
			<tr height="100px">
				<td colspan="4" align="center" valign="middle">
					<h1>Chittagong Port Authority</h1>
					
					<h3>RELEASE ORDER FOR DELEVERY (CASH) C.P NO <u>
					<?php 
						  $cpbankcode=$rtnContainerList[$i]['cp_bank_code'];
						  $cpno=$rtnContainerList[$i]['cp_no'];
						  $cpyear=$rtnContainerList[$i]['cp_year'];
						  $cpunit=$rtnContainerList[$i]['cp_unit'];
						  $num_length = strlen($cpno);
						  if($num_length == 4) 
						  {
						   $newcpno=$cpno;
						  } 
						  else if($num_length == 3)
						  {
						   $newcpno="0"."$cpno";
						  }
						  else if($num_length == 2)
						  {
						   $newcpno="00"."$cpno";
						  }
						  else if($num_length == 1)
						  {
						   $newcpno="000"."$cpno";
						  }
						  if($cpbankcode!=""&&$cpno!="")
						  {
						   echo $cpnoview=$cpbankcode.$cpunit."/".$cpyear."-"."$newcpno";
						  }
					?></u> OF <u><?php echo $rtnContainerList[$i]['cp_date']; ?></u></h3>
				</td>
			</tr>
			<tr>
				<td align="center" >
					EX.S.S <u><?php echo  $rtnContainerList[$i]['Vessel_Name']?></u>
				</td>
				<td align="center" >
					ROTATION <u><?php echo  $rtnContainerList[$i]['Import_Rotation_No']?></u>
				</td>
				<td align="center">
					LINE/BL <u><?php echo  $rtnContainerList[$i]['BL_No']?></u>
				</td>
				<td align="center">
					BILL OF ENTRY NO (<u><?php echo  $rtnContainerList[$i]['be_no']?></u>) OF <u><?php echo  $rtnContainerList[$i]['cnf_name']?></u> CONTAINER NO: <u><?php echo  $rtnContainerList[$i]['cont_number']?></u>
				</td>
				<td align="center">
					<?php echo  $rtnContainerList[$i]['cont_status']?>
				</td>
			</tr>
		</table>
		
		</br>
		
		<table border="1" width="100%" cellpadding="0" style="font-size:12px">
			<tr bgcolor="">
				<td align="center" rowspan="2">Marks & Number</td>
				<td align="center" rowspan="2">Quantity</td>
				<td align="center" rowspan="2">Description</td>
				<td align="center" rowspan="2">Weight</td>
				<td align="center" rowspan="2">Measurement</td>
				<td align="center" colspan="2">Landing Charges</td>
				<td align="center" rowspan="2">Date of Delivery</td>
				<td align="center" rowspan="2">Quantity applied for delivery</td>
				<td align="center" rowspan="2">Consignee's Signature & License No.</td>
				<td align="center" rowspan="2">S.O's Signature</td>
				<td align="center" colspan="2">Quantity Passed out</td>
				<td align="center" rowspan="2">Balance Due</td>
				<td align="center" rowspan="2">Signature of G.S. and Date</td>
			</tr>
			<tr bgcolor="">
				<td>Taka</td>
				<td>Ps.</td>
				<td>Figure</td>
				<td>In words</td>
			</tr>
			<tr height="100px" bgcolor="">
				<td rowspan="2"><font size="2px"><?php echo  $rtnContainerList[$i]['Pack_Marks_Number']?></font></td>
				<td rowspan="2"><?php echo  $rtnContainerList[$i]['Pack_Number']?></td>
				<td rowspan="2"><font size="2px"><?php echo  $rtnContainerList[$i]['Description_of_Goods']?></font></td>
				<td rowspan="2"><?php echo  $rtnContainerList[$i]['cont_weight']?></td>
				<td rowspan="2"><?php echo  $rtnContainerList[$i]['cont_size']." * ".$rtnContainerList[$i]['cont_height']?></td>
				<td rowspan="2">
				</td>
				<td rowspan="2">
				</td>
				<td rowspan="2">
				</td>
				<td rowspan="2">
				</td>
				<td rowspan="2">
				</td>
				<td rowspan="2">
				</td>
				<td rowspan="2">
				</td>
				<td rowspan="2">
				</td>
				<td rowspan="2">
				</td>
				<td rowspan="2">
				</td>
			</tr>
		</table>
		
		</br>
		
		<table width="100%" cellpadding="0">
			<tr>
				<td align="left" colspan="4" align="center" >
					Total(in words)
				</td>
				<td colspan="4">
				</td>
				<td colspan="4" align="right" >
					N.B. - No alteration of any particular entered herein will be made by the consignee.
				</td>
			</tr>
			<tr>
				<td align="left" colspan="4">
					Signature of the consignee :
				</td>
				<td  colspan="4">
					 
				</td>
				<td colspan="4">
				</td>
			</tr>
			<tr>
				<td align="left" colspan="4" style="width:430px;">
					Address :                                      
				</td>
				<td align="right" colspan="4" >
					Wrong mark/No Mark Repairing application
				</td>
				<td align="right" colspan="4">
					Certified that the particulars of the
				</td>
			</tr>
		</table>
		</br>
		<table width="100%" cellpadding="0">
			<tr>
				<td align="left" colspan="4" >
					Certified that the Consignment has been passed
				</td>
				<td align="left" colspan="4" >
					filled on ------------------------ and attached herewith
				</td>
				<td align="right" colspan="4" >
					Consignment noted here in correct.
				</td>
			</tr>
			<tr>
				<td align="left" colspan="4" >
					out of the Customs control in full/in part
				</td>
				<td align="left" colspan="4" >
					for ------------------------ pkgs
				</td>
			</tr>
			<tr>
				<td align="left" colspan="4" >
					Detain No -----------------
				</td>
				<td align="left" colspan="4" >
					Imp/ ------------------------
				</td>
			</tr>
			<tr>
				<td align="left" colspan="2" >
					Date -----------------
				</td>
				<td align="left" colspan="2" >
					Shed Officer
				</td>
				<td align="left" colspan="2" >
					Date -----------------
				</td>
				<td align="left" colspan="2" >
					Shed Officer
				</td>
				<td align="left" colspan="2" >
					Date -----------------
				</td>
				<td align="left" colspan="2" >
					Shed Officer
				</td>
			</tr>
		</table>
		<?php echo "PREPARED BY : ".$login_id;?>
		</div>
		
		</br>
		</br>
		</br>
	<div class="portrait">
		<div class="left">
			<table>
				<tr>
					<td colspan="3">
						<u>Apprising/Repacking Application</u>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						Received in good order and condition the following <br>packages for Apprising/Repacking
					</td>					
				</tr>
				<tr>
					<td colspan="1" valign="top">
						<u>Mark & Number</u>
					</td>
					<td colspan="2" valign="top">
						<u>Description</u>
					</td>
				</tr>
				<tr>
					<td colspan="1" height="100px" valign="top"><font size="2px"><?php echo  substr($rtnContainerList[$i]['Pack_Marks_Number'],0,10)?></font></td>
					<td colspan="2" height="100px" valign="top"><font size="2px"><?php echo  substr($rtnContainerList[$i]['Description_of_Goods'],0,10)?></font></td>
				</tr>
				<tr height="100px" valign="bottom">
					<td>
						Custom's<br>Representative
					</td>
					<td>
						Consignee's<br>Representative<br>License No.
					</td>
					<td>
						Sr.S.O.
					</td>
				</tr>
				<tr>
					<td colspan="3" align="center">
						<u><b>Survey</b></u>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						Received the following packages for survey -
					</td>
					
				</tr>
				<tr>
					<td colspan="1" valign="top">
						<u>Mark & Number</u>
					</td>
					<td colspan="2" valign="top">
						<u>Description</u>
					</td>
				</tr>
				<tr>
					<td colspan="1" height="100px" valign="top"><font size="2px"><?php echo  substr($rtnContainerList[$i]['Pack_Marks_Number'],0,10)?></font></td>
					<td colspan="2" height="100px" valign="top"><font size="2px"><?php echo  substr($rtnContainerList[$i]['Description_of_Goods'],0,10)?></font></td>
				</tr>
				<tr height="100px" valign="bottom">
					<td colspan="3" align="right">
						Consignee's<br>Representative<br>License No.
					</td>
				</tr>
				<tr>
					<td colspan="3" align="left">
						Surveyor-Customs-S.O.
					</td>
				</tr>
				<tr>
					<td colspan="3" align="center">
						Lockfast Clerk
					</td>
				</tr>
				<tr>
					<td colspan="3" align="left">
						N.B. - No alteration by the consignee will be accepted<br>
						unless the same is countersigned <nobr>by the Sr.Shed Officer.</nobr>
					</td>
				</tr>
			</table>
		
		</div>
		<div class="middle">
			<table>
				<tr>
					<td width="100px" align="center" colspan="2">
						<table style="border:1px solid black">
							<tr>
								<td><font size=4>BL/NO - </font></td>
								<td><font size=4><b><?php echo  $rtnContainerList[$i]['BL_No']?></b></font></td>								
							</tr>
							<tr>
								<td><font size=4>X/NO - </td>
								<td><font size=4><b><?php echo  $rtnContainerList[$i]['exit_note_number']?></b></font></td>								
							</tr>
							<tr>
								<td><font size=3>VERIFY NO - &nbsp; </font> </td>
								<td><font size=4><b><?php echo  $rtnContainerList[$i]['verify_number']?></b></font></td>								
							</tr>
						</table>
					</td>
				</tr>
				<tr height="150px" valign="top" align="center">
					<td colspan="2">
						<u><b>RELEASE ORDER</b></u>
					<td>
				</tr>
				<tr>
					<td>CP No. <?php echo $cpnoview;?></td>
					<td>Date <u><?php echo $rtnContainerList[$i]['cp_date']; ?></u></td>
				</tr>
				<tr height="10px" valign="bottom">
					<td colspan="2">Manifest Page No. -------------</td>
				</tr>
				<tr>
					<td colspan="2">Quantity <u><?php echo  $rtnContainerList[$i]['Pack_Number']?></u></td>
				</tr>
				<tr height="30px" valign="bottom">
					<td colspan="2">Shed No. <u><?php echo  $rtnContainerList[$i]['shed_loc']?></u></td>
				</tr>
				<tr>
					<td>S.S. -------------</td>
					<td>Date -------------</td>
				</tr>
				<tr>
					<td colspan="2">Voyage <u><?php echo  $rtnContainerList[$i]['VoyNo']?></u></td>
				</tr>
				<tr>
					<td colspan="2">Consignee <u><?php echo  $rtnContainerList[$i]['Notify_name']?></u></td>
					
				</tr>
				<tr height="50px" valign="bottom">
					<td colspan="2">Address <u><?php echo  $rtnContainerList[$i]['Notify_address']?></u></td>
				</tr>
				<tr>
					<td>Rotation No. <u><?php echo  $rtnContainerList[$i]['Import_Rotation_No']?></u></td>
					<td>Line No. <u><?php echo  $rtnContainerList[$i]['Line_No']?></u></td>
				</tr>
				<tr>
					<td>Bill of Entry No. <u><?php echo  $rtnContainerList[$i]['be_no']?></u></td>
					<td>of <u><?php echo  $rtnContainerList[$i]['be_date']?></u></td>
				</tr>
			</table>
		</div>
		<?php echo "PREPARED BY : ".$login_id;?>
	</div>
	<div class="portrait">
	</br>
		<div class="right">
			<table border="1">
				<tr ><td align="center" colspan="8"><b>PARTICULARS OF DELIVERY BY RESHIPMENT</b></td></tr>
				<tr>
					<td>
						Date 
					</td>
					<td>
						Quantity applied for reshipment
					</td>
					<td>
						Consignee's Signature and License No. 
					</td>
					<td>
						Customs allow order 
					</td>
					<td>
						S.O's Signature 
					</td>
					<td>
						Quantity reshipped
					</td>
					<td>
						Total Quantity (Running) 
					</td>
					<td>
						Signature of the shipping Clerk 
					</td>
				</tr>
				<tr height="200px">
					<td></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
				</tr>
				<tr><td align="center" colspan="8"><b>PARTICULARS OF DELIVERY BY RAIL</b></td></tr>
				<tr>
					<td>
						Date Note of accepted
					</td>
					<td>
						F/Note No.
					</td>
					<td>
						Description
					</td>
					<td>
						Quantity accepted
					</td>
					<td>
						Date of Loading
					</td>
					<td>
						Quantity Loaded
					</td>
					<td>
						Total Quantity
					</td>
					<td>
						Signature of the Shed Officer
					</td>
				</tr>
				<tr height="200px">
					<td></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
					<td ></td>
				</tr>
				<tr height="80px">
					<td colspan="8" align="center">
						<table>
							<tr>
								<b><u>Bill Receive Information</u></b></br>
							</tr>
							<?php 
									for($j=0;$j<count($rtnBillRcvInfo);$j++)
									{
										?>
							<tr>
								<?php echo $rtnBillRcvInfo[$j]['description']; ?>,									
							</tr>
							<?php }?>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="8" align="Center"> <b> <?php  echo $rtnBillList[0]['paid_status']?> upto :<?php echo $rtnContainerList[$i]['bill_date']; ?> &nbsp;&nbsp;&nbsp; Vide CP No. &nbsp;:<?php echo $cpnoview;?> &nbsp;&nbsp; Bill No - &nbsp; <?php echo $rtnContainerList[$i]['master_bill_no']; ?></b></td>
				</tr>				
			</table>
		</div>
		<table width=100%>	
		 <tr>
		      <td>&nbsp; </br> &nbsp;</td>
	     </tr>
         <tr>
		       <td><?php echo "PREPARED BY : ".$login_id;?></td>
		  	   <td align="right"> ________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; _________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;_______________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		 </tr>
		 <tr>
		    <td></td>
			<td align="right"> TI/CFS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CC/ONESTOP &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TI/ONESTOP &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		 </tr>
		</table>
		</div>
		</div>
			<?php
		}
		
		?>
			
			<?php
			include("mydbPConnection.php");
			$truckNo=$rtnTruckNumber[0]['no_of_truck'];
			for($i=0;$i<$truckNo;$i++)
			{ 
			
				/* $sqlCartTicket="SELECT igm_supplimentary_detail.id,IFNULL(SUM(rcv_pack+loc_first),0) AS rcv_pack,igm_masters.Vessel_Name,igm_supplimentary_detail.Import_Rotation_No,igm_sup_detail_container.cont_number,Pack_Marks_Number,shed_loc,shed_yard,Description_of_Goods,Notify_name,IFNULL(shed_tally_info.verify_number,0) AS verify_number,IFNULL(shed_tally_info.id,0) AS verify_id,igm_supplimentary_detail.Pack_Number,igm_supplimentary_detail.Pack_Description,igm_supplimentary_detail.BL_No,igm_sup_detail_container.cont_size,igm_sup_detail_container.cont_status,igm_sup_detail_container.cont_weight,verify_other_data.cnf_name,verify_other_data.be_no,verify_other_data.be_date,igm_sup_detail_container.cont_height,truck_id
				FROM  igm_supplimentary_detail
				INNER JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
				INNER JOIN igm_masters ON igm_supplimentary_detail.igm_master_id=igm_masters.id
				LEFT JOIN  shed_tally_info ON shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
				LEFT JOIN verify_other_data ON shed_tally_info.id=verify_other_data.shed_tally_id
				LEFT JOIN do_information ON do_information.verify_no=shed_tally_info.verify_number
				WHERE shed_tally_info.verify_number='$verifyNo'"; */
				
				$sqlCartTicket="SELECT igm_supplimentary_detail.id,IFNULL(SUM(rcv_pack+loc_first),0) AS rcv_pack,igm_masters.Vessel_Name,igm_supplimentary_detail.Import_Rotation_No,igm_sup_detail_container.cont_number,Pack_Marks_Number,shed_loc,shed_yard,Description_of_Goods,Notify_name,IFNULL(shed_tally_info.verify_number,0) AS verify_number,IFNULL(shed_tally_info.id,0) AS verify_id,igm_supplimentary_detail.Pack_Number,igm_supplimentary_detail.Pack_Description,igm_supplimentary_detail.BL_No,igm_sup_detail_container.cont_size,igm_sup_detail_container.cont_status,igm_sup_detail_container.cont_weight,verify_other_data.cnf_name,verify_other_data.be_no,verify_other_data.be_date,igm_sup_detail_container.cont_height,truck_id,cus_rel_odr_no
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
			<div id="borderDiv">
			<div id="cartTicket" class="portrait">
				<table width="100%" border="0">
					<tr align="center">
						<!--td colspan="5" style="font-size:30px; font-weight: bold;">ORION INFUSION LTD.</td-->
						<td colspan="5" style="font-size:20px; font-weight: bold;"><?php echo $rtnCartTicket[0]['cnf_name'];?></td>
					</tr>
					<tr align="center">
						<td colspan="5" style="font-size:10px; font-weight: bold;">SELF C&F </td>
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
					<tr align="center">
						<td colspan="5">
							<p> CHITTAGONG PORT AUTHORITY </p>
						</td>
					</tr>
					<tr>
						<td colspan="5" align="center" style="font-weight: bold;"><u>CART TICKET</u></td>
					</tr>
					<tr>
						<td width="70px">Rot No.</td>
						<td style="border-bottom:1px solid black"><?php echo $rtnCartTicket[0]['Import_Rotation_No'];?></td>
						<td>&nbsp;</td>
						<td width="50">Job No.</td>
						<td style="border-bottom:1px solid black"></td>
					</tr>
					<tr>
						<td width="30px">Line No.</td>
						<td style="border-bottom:1px solid black"><?php echo $rtnCartTicket[0]['BL_No'];?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				<!--table/-->
					<tr>
						<td colspan="5">
							<table border="0">
								<tr>
									<td width="100px">Shed No.</td>
									<td colspan="2" style="border-bottom:1px solid black; width:300px"><?php echo $rtnCartTicket[0]['shed_yard'];?></td>
									<td align="center">Release Order No.</td>
									<td colspan="2 "style="border-bottom:1px solid black; width:300px"><?php echo $rtnCartTicket[0]['cus_rel_odr_no'];?></td>
									<td align="center">Of</td>
									<td colspan="2" style="border-bottom:1px solid black; width:300px"></td>
								</tr>
								<tr>
									<td>Ex. S/S. M/V</td>
									<td style="border-bottom:1px solid black; width:300px"><?php echo $rtnCartTicket[0]['Vessel_Name'];?></td>
									<td>No</td>
									<td style="border-bottom:1px solid black; width:200px"></td>
									<td>Consignee:</td>
									<td colspan="3" style="border-bottom:1px solid black; width:300px"><?php echo $rtnCartTicket[0]['cnf_name'];?></td>
								</tr>
								<tr>
									<td>B/E No.</td>
									<td style="border-bottom:1px solid black; width:300px"><?php echo $rtnCartTicket[0]['be_no'];?></td>
									<td>of</td>
									<td style="border-bottom:1px solid black; width:200px"><?php echo $rtnCartTicket[0]['be_date'];?></td>
									<td>Truck No.</td>
									<td style="border-bottom:1px solid black; width:300px"><?php echo $rtnTruckNumber[$i]['truck_id'];?></td>
									<td width="70px">Gate No.</td>	
									<td style="border-bottom:1px solid black; width:250px"></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								<tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="5">
							<table border="1" width="100%">
								<tr>
									<th width="20%">Marks</th>
									<th width="20%">Description</th>
									<th width="40%">Number</th>
									<th width="20%">Consecutive Carts Total</th>
								</tr>
								<tr align="center">
									<td width="20%" rowspan="2"><font size="2px"><?php echo substr($rtnCartTicket[0]['Pack_Marks_Number'],0,50);?></font></td>
									<td width="20%" rowspan="2"><font size="2px"><?php echo substr($rtnCartTicket[0]['Description_of_Goods'],0,50);?></font></td>
									<!--td height="25px"><?php echo $rtnTruckNumber[$i]['delv_pack'];?></td>
									<td height="25px"><?php echo $rtnCartTicket[0]['Pack_Number'];?></td-->
									<td width="40%" height="10px"></td>
									<td width="20%"height="10px"></td>
								</tr>
								<tr align="center">
									<td height="10px"></td>
									<td height="10px"></td>
								</tr>
								<tr align="center">
									<td rowspan="2"></td>
									<td rowspan="2"></td>
									<td height="10px"></td>
									<td height="10px"></td>
								</tr>
								<tr align="center">
									<td height="10px"></td>
									<td height="10px"></td>
								</tr>
								<tr align="center">
									<td rowspan="2"></td>
									<td rowspan="2"></td>
									<td height="10px"></td>
									<td height="10px"></td>
								</tr>
								<tr align="center">
									<td height="10px"></td>
									<td height="10px"></td>
								</tr>
								<tr align="center">
									<td rowspan="2"></td>
									<td rowspan="2"></td>
									<td height="10px"></td>
									<td height="10px"></td>
								</tr>
								<tr align="center">
									<td height="10px"></td>
									<td height="10px"></td>
								</tr>
								<tr align="center">
									<td rowspan="2"></td>
									<td rowspan="2"></td>
									<td height="10px"></td>
									<td height="10px"></td>
								</tr>
								<tr align="center">
									<td height="10px"></td>
									<td height="10px"></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="5">
							<table border="0">
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td colspan="2">Total Packages (in words)</td>
									<td style="border-bottom:1px solid black; " colspan="6"></td>
								</tr>
								<tr>
									<td colspan="3">Received the above in full.</td>
									<td colspan="3" style="width:200px">For- <font size="2px"><?php echo $rtnCartTicket[0]['cnf_name'];?></font></td>
									<td colspan="2" style="width:200px" align="right">Checked and found ok</td>
								</tr>
								<tr>
									<td colspan="8">&nbsp;</td>
								</tr>
								<tr>
									<td>Date</td>
									<td style="border-bottom:1px solid black; width:150px"></td>
									<td>Consignee's Signature</td>
									<td style="width:250px"></td>
									<td>Delivery Clerk</td>
									<td style="width:250px"></td>
									<td>Gate Sargent</td>	
									<td style="width:250px"></td>
								</tr>
								<tr>
									<td colspan="8" style="border-bottom:1px solid black; width:200px">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="8">N.B.: Loss of Cart Ticket must immediately be reported to the Shed Master of Shed Foreman. Unused Cart Ticket must be returned to the delivery Foreman on the same day they were issued.</td>
								</tr>
								<tr>
									<td colspan="8">&nbsp;</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<?php echo "PREPARED BY : ".$login_id;?>
			</div>
			</div>
			<?php } ?>
	
	<div id="deliveryOrder" class="portrait">
			<table width=90%  align="center" >
			<tr align="center">
				<td colspan="2" style="font-size:20px"><b><?php echo $rtnContainerList[0]['cnf_name']?></b></td>
			</tr>
			<!--tr><td align="center" style="font-size:17px" ><b> SELF C&F </b> </td></tr>
			<tr align="center" >
				<td colspan="2" style="font-size:17px"><p> 532/533, Sk. Mujib Road, Dewanhat, Chittagong </p></td>
			</tr>
			<tr align="center" >
				<td colspan="2" style="font-size:17px"><p> Phone: 031-718185, Mobile: 01712-232155, 01721-166690 </p></td>
			</tr-->
			<tr>
				<td align="center" style=""><b><nobr>CHITTAGONG PORT AUTHORITY </nobr></b></td>
			</tr>
			<tr>
				<td align="center" style=""><b>SHED DELIVERY ORDER </b></td>
			</tr>
		</table>
		
		
		<table align="center" width=95%>
			<tr><td colspan="2">Rot No. <b> <?php echo $rtnContainerList[0]['Import_Rotation_No']?> </b></td></tr>
			<tr><td colspan="2">Line No.& B/L NO.  <b> <?php echo $rtnContainerList[0]['BL_No']?> </b> </td></tr>
			<tr><td align="left" width="56%"><nobr>For goods Ex. S. S.<b>&nbsp;&nbsp; <?php echo $rtnContainerList[0]['Vessel_Name']?> &nbsp;</b> Consigned to</nobr></td><td align="left" style="font-size:20px"><b> <?php echo $rtnContainerList[0]['cnf_name']?></b></td></tr>
			<tr><td colspan="2">Y/Shed No: &nbsp;&nbsp; <b> <?php echo  $rtnContainerList[0]['shed_yard']?> &nbsp;&nbsp;</b>  R.O. No. U________________Date______________B/E. No.  <b> &nbsp;&nbsp;<?php echo $rtnContainerList[0]['be_no']?>&nbsp;&nbsp; </b> date. <b> &nbsp;&nbsp;<?php echo $rtnContainerList[0]['be_date']?> </b></td></tr>
		</table>
		<table><tr><td>&nbsp;</td></tr></table>
		
		<table  align="center" border="1" width=95%>
			<tr>
			   <td align="center" width="57%" height="30px"> Particulars of Consignment</td> 
			   <td align="center"> Particulars of wrong marks or no marks application</td>
			</tr>
		</table>
		
		<table align="center" border="1" width=95%>
			<tr align="center">
			   <td align="center"> Marks and Nos.</td> 
			   <td align="center"> Quantity and Description</td>
			   <td align="center"> Marks and Nos</td>
			   <td align="center"> Quantity and Description</td>
			   <td align="center"> Date of application</td>
			   <td align="center"> Marks and landed</td>
			   <td align="center"> Signature of Head Shed Clerk</td>
			</tr>
			
			<tr>
				<td width="13%" height="10px"><font size="2px"> <b> <?php echo $rtnContainerList[0]['Pack_Marks_Number']?> </b></font></td>
				<td width="13%"><font size="2px"><?php echo $rtnContainerList[0]['Description_of_Goods']?></font></td>
				<td width="13%"><font size="2px"><?php echo $rtnContainerList[0]['Pack_Marks_Number']?></font></td>
				<td width="13%"><font size="2px"><?php echo $rtnContainerList[0]['Description_of_Goods']?></font></td>
				<td width="13%"></td>
				<td width="13%"></td>
				<td width="13%"></td>	
			</tr>
			<tr>
				<td width="13%" height="15px"></td>
				<td width="13%"></td>
				<td width="13%"></td>
				<td width="13%"></td>
				<td width="13%"></td>
				<td width="13%"></td>
				<td width="13%"></td>	
			</tr>
			<tr>
				<td width="13%" height="15px"></td>
				<td width="13%"></td>
				<td width="13%"></td>
				<td width="13%"></td>
				<td width="13%"></td>
				<td width="13%"></td>
				<td width="13%"></td>	
			</tr>
			<tr>
				<td width="13%" height="15px"></td>
				<td width="13%"></td>
				<td width="13%"></td>
				<td width="13%"></td>
				<td width="13%"></td>
				<td width="13%"></td>
				<td width="13%"></td>	
			</tr>

		</table>
		</br>
		<table  align="center" border="1px solid black" width=95%>
			<tr>
			   <td align="center" width="10%" rowspan="2"> Date </td> 
			   <td align="center" colspan="3">Particulars of Delivery</td>		    
			   <td align="center" rowspan="2" >Consignee's Signature </td>
			   <td align="center" rowspan="2">Head Clerk's Signature</td>
			   <td align="center" rowspan="2">Delivery Clerk's Signature</td>
			   <td align="center" style="font-size:14px;"rowspan="2">Remarks of Consignee</br>or his Agent,why</br>Delivery not taken in</br> full(see instruction overleaf) </td>

			</tr>
			<tr><td align="center" >No. applied for</td> 
				<td align="center">No. delivered </td>	
				<td align="center">Balanced due</td></tr>
			 
			<tr>
				<td width="" height="15px"></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>	
				<td width=""></td>	
			</tr>
			<tr>
				<td width="" height="15px"></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>	
				<td width=""></td>	
			</tr>
			<tr>
				<td width="" height="15px"></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>	
				<td width=""></td>	
			</tr>
			<tr>
				<td width="" height="15px"></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>	
				<td width=""></td>	
			</tr>
			<tr>
				<td width="" height="15px"></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>	
				<td width=""></td>	
			</tr>
			<tr>
				<td width="" height="15px"></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>	
				<td width=""></td>	
			</tr>
			<tr>
				<td width="" height="15px"></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>
				<td width=""></td>	
				<td width=""></td>	
			</tr>

		</table>
		<?php echo "PREPARED BY : ".$login_id;?>
	</div>
	<div class="portrait">
	</br>
	<div style="width:90%; padding-left: 30px; ">
	<p width=90%>&nbsp; &nbsp; &nbsp; &nbsp; <font size="2">1. Any consignee or his representative failing to remove on the day declared for delivery: on the packages declared
	should in his own interest not on his documents at the close of the day's work, his reasons for not removing those left on the
	Port Commissioner's premises. Unless this nothing is made and accepted by the S. M. S. P. or delivery Foreman Claims for 
	remission of Scheduled rent charges will not be entertained and claims  for damage of lost goods may fall for lack of evidence.</font></p>	
	<p>&nbsp; &nbsp; &nbsp; &nbsp; <font size="2">2.If reason so recorded disclose a shortage, damage or other discrepancy, the Delivery Clerk will at once bring the
	matter specially to the notice of Shed Master who will initial the consignee's remarks and immediately and personally 
	investigate and report the result to his Superintendent if no shortage, damage or other discrepancy is alleged or if no note is
	made on this document by the consignee, the Delivery Clerk will sign and hand it over to the Shed Manager at once.</font></p>	
	<p>&nbsp; &nbsp; &nbsp; &nbsp; <font size="2">3.Packages pilfered or damaged to the extent mentioned in the Lockfast Rules must be removed to the Lockfast if and
	when goods once reported missing are found letter. The Shed Manager must see that the column date found correctly posted
	in the missing goods register and that the marks and numbers of the packages are posted on the Shed Notice board for the
	information of the consignees.</font></p>
	</div>

	<div style="padding-left: 75px ; " > Summary of cart tickets issued daily (to be filled in by the Delivery Clerk). <font size=4><b><?php echo $rtnContainerList[0]['cnf_name']?></b></font> </div>

		<table  align="center" border="1px solid black" width=95%>
		
		<tr>
		   <td align="center" width="110px" height="25px" style="border-left-style: none;" > Date </td> 
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
		   <td align="center" width="120px" height="25px" ></td>
		</tr>
		 <?php for($i=0; $i<21; $i++){?>
		<tr>
           <td align="center" width="110px" height="15px">  </td> 
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
		   <td align="center" width="120px" height="15px"></td>
		</tr>
		 <?php }?>

		 <tr>
		   <td align="center" width="110px"  height="15px" ><font size=3><b>Total </b></font></td> 
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
		   <td align="center" width="120px" height="15px" ></td>
		</tr>
		<tr>
		   <td align="center" width="110px" height="15px"> <font size=1><b>Delivery</br> Clerk's</br> Initials </b></font></td> 
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
		   <td align="center" width="120px" height="15px"></td>
		</tr>
	</table>
	<?php echo "PREPARED BY : ".$login_id;?>
	</div>
	<?php 
	for ($billTime=0;$billTime<$bill_print_times;$billTime++)
	{
	?>
	</br>
	<!--div id="billArea" class="landscape breakPage">
		<div align="center" style="">
			<b>CHITTAGONG PORT AUTHORITY</b>
		</div>
		<div align="center"><b>ONE STOP SERVICE CENTER</b></div>
		<div align="center"><b>(LCL BILL)</b></div>
		
		<div align ="center">
		<table align="center" width="80%">
			<tr style="">
				<td><font size="2px"><b>VERIFY NO : <?php echo $verify_number;?></b></font></td>
				<td><font size="2px"><b>UNIT NO : <?php echo $unit_no;?></b></font></td>
				<td><font size="2px"><b>CPA VAT REG NO : <?php echo $cpa_vat_reg_no;?></b></font></td>
				<td><font size="2px"><b>EX.RATE($) : <?php echo $ex_rate;?></b></font></td>
			</tr>			
		</table>
		<hr width="80%">
		<table align="center" width="80%" >
		 <?php       
				for($i=0;$i<count($rtnBillList);$i++) { 
				 ?>
			<tr style="">
				<td><font size="2px"><b>BILL NO : <?php echo $rtnBillList[$i]['bill_no'];?></b></font></td>
				<td><font size="2px"><b>DATE : <?php echo date("y-m-d");?></b></font></td>
				<td><font size="2px"><b>ARRAIVAL DATE : <?php echo $rtnBillList[$i]['arraival_date'];?></b></font></td>
			</tr>
			<tr style="">
				<td><font size="2px"><b>ROT NO : <?php echo $rtnBillList[$i]['import_rotation'];?></b></font></td>
				<td><font size="2px"><b>VSL NAME : <?php echo $rtnBillList[$i]['vessel_name'];?></b></font></td>
				<td><font size="2px"><b>C/L DATE : <?php echo $rtnBillList[$i]['cl_date'];?></b></font></td>
			</tr>	
			<tr style="">
				<td><font size="2px"><b>LINE/BL NO : <?php echo $rtnBillList[$i]['bl_no'];?></b></font></td>
				<td><font size="2px"><b>W/R DATE : <?php echo $rtnBillList[$i]['wr_date'];?></b></font></td>
				<td><font size="2px"><b>W/R BILL UPTO : <?php echo $rtnBillList[$i]['wr_upto_date'];?></b></font></td>
			</tr>	
			<tr style="">
				<td><font size="2px"><b>VAT REG NO : <?php echo $rtnBillList[$i]['cpa_vat_reg_no'];?></b></font></td>
				<td><font size="2px"><b>IMPORTER : <?php echo $rtnBillList[$i]['importer_name'];?></b></font></td>
			</tr>	
			<tr style="">
				<td><font size="2px"><b>C&F LC NO : <?php echo $rtnBillList[$i]['cnf_lic_no'];?></b></font></td>
				<td><font size="2px"><b>C&F AGENT : <?php echo $rtnBillList[$i]['cnf_agent'];?></b></font></td>
			</tr>	
			<tr style="">
				<td><font size="2px"><b>BE NO : <?php echo $rtnBillList[$i]['be_no'];?></b></font></td>
				<td><font size="2px"><b>BE DATE : <?php echo $rtnBillList[$i]['be_date'];?></b></font></td>
			</tr>	
			<tr style="">
				<td><font size="2px"><b>ADO NO : <?php echo $rtnBillList[$i]['ado_no'];?></b></font></td>
				<td><font size="2px"><b>ADO DATE : <?php echo $rtnBillList[$i]['ado_date'];?></b></font></td>
				<td><font size="2px"><b>ADO VALID UPTO : <?php echo $rtnBillList[$i]['ado_valid_upto'];?></b></font></td>
			</tr>	
			<tr style="">
				<td><font size="2px"><b>MANIFEST QTY : <?php echo $rtnBillList[$i]['manifest_qty']."*".$rtnBillList[$i]['cont_size']."*".$rtnBillList[$i]['cont_height'];?></b></font></td>
			</tr>
				<?Php }?>
		</table>
		<div align="center"><u><font size="2px">QNTY FOR WHICH CHARGE MADE</font></u></div></br>
			<table width="80%" align="center"  cellpadding="1" cellspacing="1" style="border-top: 1px solid black;border-bottom: 1px solid black;">
				<thead style="">
					<tr style="border-top: 1px solid black;">		
						<th align="center" ><font size="2px">CODE</font></th>
						<th align="center" ><font size="2px">DESCRIPTION</font></th>
						<th align="center" ><font size="2px">RATE(T/$)</font></th>
						<th align="center" ><font size="2px">QNTY</font></th>
						<th align="center" ><font size="2px">DAYS</font></th>
						<th align="center" ><font size="2px">PORT(TK)</font></th>
						<th align="center" ><font size="2px">VAT(TK)</font></th>
						<th align="center" ><font size="2px">MLWF(TK)</font></th>
					</tr>
				</thead>
				<tbody>
				 <?php       
				for($i=0;$i<count($chargeList);$i++) { 
				 ?>
				 <tr class="" style="page-break-inside:avoid; page-break-after:auto;"> 
				  
				  <td align="center">
				   <font size="2px"><b><?php echo $chargeList[$i]['gl_code']?></b></font>
				  </td>
				  <td align="left">
				   <font size="2px"><b><?php echo $chargeList[$i]['description']?></b></font>
				  </td>
				  <td align="center">
				   <font size="2px"><b><?php echo $chargeList[$i]['tarrif_rate']?></b></font>
				  </td>
				  <td align="center">
				   <font size="2px"><b><?php echo $chargeList[$i]['Qty']?></b></font>
				  </td>
				  <td align="center">
				   <?php if($chargeList[$i]['gl_code']!=206031 && $chargeList[$i]['gl_code']!=206033 && $chargeList[$i]['gl_code']!=206035 
				   && $chargeList[$i]['gl_code']!=206037 && $chargeList[$i]['gl_code']!=206039 && $chargeList[$i]['gl_code']!=206041 && $chargeList[$i]['qday']=1) {?>
					<?php echo "";} else {?>
					<font size="2px"><b><?php echo $chargeList[$i]['qday'];}?></b></font>
				  </td>
				  <td align="center">
				   <font size="2px"><b><?php echo $chargeList[$i]['amt']?></b></font>
				  </td>
				  <td align="center">
				   <font size="2px"><b><?php echo $chargeList[$i]['vatTK']?></b></font>
				  </td>
				  <td align="center">
				   
				  </td>
				</tr>
				 <?php
				}
			   ?>
			</tbody>
			</table>
			</div>
			<div align="left" class="fixed">
			<table align ="center" width="80%">
				<tr>
					<td>
						<b><font size="2px">SHOW RATE IN US$ TOTAL DAYS : <?php echo $tot_qday;?></font></b>
					</td>
					<td>
						<font size="2px">TOTAL(TK) : <?php echo $tot_sum;?></font></b>
					</td>
				</tr>
				<tr >
					<td colspan="4"><font size="2px">NET AMOUNT : <?php $ait=($tot_sum * 0.1); $other= $tot_sum - $ait; echo "( ".$other." + AIT 10% ".$ait." )"?></font></td>
					<td><font size="2px">PORT : <?php echo $tot_sum;?></b></font></td>
				</tr>
				<tr>
					<td align="center" colspan="5">
						<b><font size="2px">NET PAYABLE (TK) : <?php echo $tot_sum;?></font></b>
					</td>
				</tr>
				<tr>
					<td colspan="5">
						<font size="2px">REMARKS :  <b><?php echo numtowords($tot_sum); ?></b></font>
						
					</td>
				</tr>
				<tr>
					<td colspan="5">
						<b><font size="2px">SHOULD BE PAID ON BEFORE <?php for($i=0;$i<count($rtnContainerList);$i++) {  echo $rtnContainerList[$i]['wr_upto_date'];}?></font></b> 
					</td>
				</tr>
				</table>
				<table align="center" style="width:80%">
				<tr>
					<td>BANK'S SEAL</td>
					<td>C&F AGENT</td>
					<td>BILL CLERK : <?php echo $billPrepareBy;?> </td>
					<td>L/C NO</td>
					<td>UNIT NO : <?php echo $unit_no;?> </td>
				</tr>
			</table>
			<?php 
			if($bill_rcv_stat==1)
			{
			?>
			<div align="left" style="margin-left:10%;">
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
			</div>
			<?php } ?>
			<div align="left" style="margin-left:10%;">
			<?php echo "PREPARED BY : ".$billPrepareBy;?>
			</div>
		</div>
		
	</div-->
	<?php } ?>
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