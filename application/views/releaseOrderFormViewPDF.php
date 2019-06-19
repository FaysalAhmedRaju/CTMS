<html>
	<head>
		<!--title>RELEASE ORDER FOR DELEVERY</title-->
	</head>
	
	<body>
		<?php 
		for($i=0;$i<count($rtnContainerList);$i++)
		{
		?>
	<div id="borderDiv">
		<!--div class="portrait"-->
		<div class="pageBreak">
		<table width="100%" cellpadding="0" border="0">
			<tr height="100px">
				<td colspan="5" align="center" valign="middle">
					<!--h1>Chittagong Port Authority</h1-->
					<img width="250px" height="80px" src="<?php echo IMG_PATH?>cpanew.jpg">
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
		
		<!--/br-->
		
		<table border="1" width="100%" cellpadding="0" style="font-size:15px">
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
			<!--tr height="150px" bgcolor=""-->
			<tr>
				<td rowspan="2"><?php echo  $rtnContainerList[$i]['Pack_Marks_Number']?></td>
				<td rowspan="2"><?php echo  $rtnContainerList[$i]['Pack_Number']?></td>
				<td rowspan="2"><?php echo  $rtnContainerList[$i]['Description_of_Goods']?></td>
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
		<table width="100%" cellpadding="0" border="0">
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
			<tr>
				<td colspan="6">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="6">
					<?php 
					$login_id=$this->session->userdata('login_id');
					echo "PREPARED BY : ".$login_id;?>
				</td>
			</tr>
		</table>
	</div>
		
		<!--/br>
		</br>
		</br-->
	<!--div class="portrait"-->
	<div class="pageBreak">
		<table border="0">
			<tr>
				<td>
					<table border="0">
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
						<tr>
							<td colspan="3"><?php echo "PREPARED BY : ".$login_id;?></td>
						</tr>
					</table>
				</td>
				<td valign="top">
					<table border="0">
						<tr>
							<td align="left" colspan="2">
								<table style="border:1px solid black">
									<tr>
										<td style="border-top:1px solid black;">BL/NO- </td>
										<td><b><?php echo  $rtnContainerList[$i]['BL_No']?></b></td>
									</tr>
									<tr>
										<td>X/NO- </td>
										<td><b><?php echo  $rtnContainerList[$i]['exit_note_number']?></b></td>								
									</tr>
									<tr>
										<td>VERIFY NO- &nbsp; </font> </td>
										<td><b><?php echo  $rtnContainerList[$i]['verify_number']?></b></td>								
									</tr>
								</table>
							</td>
						</tr>
						<tr valign="top" align="center">
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
				</td>
			</tr>
		</table>
		<?php //echo "PREPARED BY : ".$login_id;?>
	</div>
	<div class="pageBreakOff">
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
				<tr>
					<td class="cellheight"></td>
					<td class="cellheight"></td>
					<td class="cellheight"></td>
					<td class="cellheight"></td>
					<td class="cellheight"></td>
					<td class="cellheight"></td>
					<td class="cellheight"></td>
					<td class="cellheight"></td>
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
				<tr>
					<td class="cellheight"></td>
					<td class="cellheight"></td>
					<td class="cellheight"></td>
					<td class="cellheight"></td>
					<td class="cellheight"></td>
					<td class="cellheight"></td>
					<td class="cellheight"></td>
					<td class="cellheight"></td>
				</tr>
				<tr>
					<td colspan="8" align="center">
						<b><u>Bill Receive Information</u></b></br>
					</td>	
				</tr>
				<tr>
					<td colspan="8" align="center">
						<?php 
						for($j=0;$j<count($rtnBillRcvInfo);$j++)
						{
							echo $rtnBillRcvInfo[$j]['description'].",";
						}
						?>										
					</td>
				</tr>
				<tr>
					<td colspan="8" align="Center"> <b> <?php  echo $rtnBillList[0]['paid_status']?> upto :<?php echo $rtnContainerList[$i]['bill_date']; ?> &nbsp;&nbsp;&nbsp; Vide CP No. &nbsp;:<?php echo $cpnoview;?> &nbsp;&nbsp; Bill No - &nbsp; <?php echo $rtnContainerList[$i]['master_bill_no']; ?></b></td>
				</tr>				
			</table>
		</div>
		
		<table width="100%" >	
			<tr>
				<td align="center"><?php echo "PREPARED BY : ".$login_id;?></td>
				<td colspan="5"></td>
			</tr>
			<tr>
				<td></td>
				<td style="border-top:1px solid black;" align="center">TI/CFS</td>
				<td></td>				
				<td style="border-top:1px solid black;" align="center">CC/ONESTOP</td>
				<td></td>				
				<td style="border-top:1px solid black;" align="center">TI/ONESTOP</td> 
			</tr>
		</table>
		</div>
		</div>
		<?php
		}
		?>
	</body>		
</html>
			