
<HTML>
	<HEAD>
		<!--TITLE>BLOCKED CONTAINER LIST</TITLE-->
	    <style type="text/css">
<!--
.style1 {font-size: 12px}
-->
        </style>
	</HEAD>
	<BODY>
	
		<?php 
			if($igm_id_arraival>0)
			{
		?>
		<div style="background-color: lightblue;height:1050px;">
				<table class="tbl" width="100%" border ='0' cellpadding='0' cellspacing='0' >
		
					   <tr>
							<td  align="center" style="border:none;"><font size="5"><b><u>THE CHITTAGONG PORT AUTHORITY</u></b></font></td>
					   </tr>
					   <tr>
							<td  align="center" style="border:none;"><font size="5"><b>ARRIVAL REPORT OF VESSEL AND PILOTAGE CERTIFICATE</b></font></td>	
					   </tr>
				</table>
				<table class="tbl" width="100%" border ='0' cellpadding='0' cellspacing='0' >
				
				<tr>
					<td align="left">1.</td>
					<td align="left" style="width:200px; font-size: 12px;">VESSELS NAME :   <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtnVesselDetails_igm[0]['Vessel_Name']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>
								<td align="left" style="width:200px; font-size: 12px;">CALL SIGN :<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtnVesselDetails_n4[0]['radio_call_sign']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>
								<td align="left" style="width:200px; font-size: 12px;">FLAG : <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtnVesselDetails_n4[0]['cntry_name']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>
											</tr>
											<tr>
												<td align="left">2.</td>
												<td align="left" colspan="3" style="width:700px; font-size: 12px;" >NAME OF MASTER : <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtnVesselDetails_igm[0]['Name_of_Master']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>
											</tr>
											<tr>                                
												<td align="left">3.</td>
								<td align="left" style="width:200px; font-size: 12px;">GRT : <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtnVesselDetails_n4[0]['gross_registered_ton']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>
								<td align="left" style="width:200px; font-size: 12px;">NRT : <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtnVesselDetails_n4[0]['net_registered_ton']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>
												<td align="left" style="width:160px; font-size: 12px;">DECK CARGO : <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtnVesselDetails_igm[0]['Deck_cargo']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>
											</tr>
											<tr>
												<td align="left">4.</td>
								<td align="left" style="width:250px; font-size: 12px;">LOA : <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtnVesselDetails_n4[0]['loa_cm']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>
												<td align="left" colspan="2" style="width:300px; font-size: 12px;">MAX. FW DRAUGHT : <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php // echo $arrivalInfo42[0]['Vessel_Name']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>	
											</tr>
											<tr>
												<td align="left">5.</td>
												<td align="left" colspan="3" style="width:500px; font-size: 12px;">NUMBER OF CREW & OFFICER INCLUSIVE MASTER : <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtn_vsl_arrival_info[0]['Vessel_Name']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>
											</tr>
											<tr>
												<td align="left">6.</td>
								<td align="left" colspan="3" style="width:500px;font-size: 12px;" >NAME AND ADDRESS OF OWNERS: <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtnVesselDetails_igm[0]['Vessel_Name']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>						
											</tr>
											<tr>
												<td align="left">7.</td>
								<td align="left" style="width:200px; font-size: 12px;">LOCAL AGENT : <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtnVesselDetails_n4[0]['localagent']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>
												<td align="left" style="width:200px; font-size: 12px;">LAST PORT : <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php // echo $arrivalInfo42[0]['Vessel_Name']?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>
												<td align="left" style="width:145px; font-size: 12px;">NEXT PORT : <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php // echo $arrivalInfo42[0]['Vessel_Name']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>	
											</tr>
											<tr>
												<td align="left">8.</td>
								<td align="left" style="width:200px; font-size: 12px;">NAME OF PILOT : <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtn_vsl_arrival_info[0]['pilot_name']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>
												<td align="left" style="width:200px; font-size: 12px;">BOARDED : <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtn_vsl_arrival_info[0]['pilot_on_board']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>
												<td align="left" style="width:200px; font-size: 12px;">LEFT : <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtn_vsl_arrival_info[0]['pilot_off_board']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>	
											</tr>
											<tr>
												<td align="left">9.</td>
								<td align="left" style="width:200px; font-size: 12px;">PILOTAGE FROM : <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtn_vsl_arrival_info[0]['pilot_frm']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>	
												<td align="left" style="width:200px; font-size: 12px;">TO : <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtn_vsl_arrival_info[0]['pilot_to']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>						
											</tr>
											<tr> 
												<td align="left">10.</td>
								<td align="left" style="width:170px; font-size: 12px;">TIME OF MOORING FROM: <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtn_vsl_arrival_info[0]['mooring_frm_time']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>	
												<td align="left" style="width:200px; font-size: 12px;">TO: <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtn_vsl_arrival_info[0]['mooring_to_time']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>						
											</tr>
											 <tr>
												<td align="left">11.</td>
								<td align="left" style="width:150px; font-size: 12px;">CPA TUG/TUGS(NAME): <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtn_vsl_arrival_info[0]['aditional_tug']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>	
												<td align="left" style="width:220px; font-size: 12px;">ASSISTANCE FROM : <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtn_vsl_arrival_info[0]['assit_frm']?>&nbsp;&nbsp;&nbsp;&nbsp;</u></td>	
												<td align="left" style="width:150px; font-size: 12px;">TO : <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtn_vsl_arrival_info[0]['assit_to']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>						
											</tr>
											<tr> 
												<td align="left">12.</td>
								<td align="left" style="width:100px; font-size: 12px;">ARRIVAL AT OUTER ANCHORAGE DATE : <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtn_vsl_arrival_info[0]['oa_dt']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>		
												<td align="left" colspan="2" style="width:300px; font-size: 12px;">FW. DRAFT (MAX): <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php // echo $rtn_vsl_arrival_info[0]['Vessel_Name']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>						
											</tr>
											<tr>
												<td align="left">13.</td>
								<td align="left" style="width:400px; font-size: 12px;">IF WORKED AS LIGHTER, NAME OF MOTHER VESSEL : <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php // echo $rtn_vsl_arrival_info[0]['Vessel_Name']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>						
											</tr>
											<tr>
												<td align="left">14.</td> 
												<td align="left"colspan="3" style="width:400px; font-size: 12px;">WORKED AT OUTER ANCHORAGE / OUTAGE PORT LIMIT.(TICK)</td>						
											</tr>
											<tr>
												<td align="left">15.</td>
												<td align="left" colspan="3" style="width:400px; font-size: 12px;">DANGEROUS CARGO IF ANY : <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php // echo $rtn_vsl_arrival_info[0]['Vessel_Name']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>						
										  </tr>
					</table>
									
					<table class="tbl" width="100%" border ='0' cellpadding='0' cellspacing='0' >
										  <tr>
											<td align="left">16.</td>
											<td  align="left" style="width:300px; font-size: 12px;">MAIN ENGINES IN GOOD WORKING CONDITION?</td> YES
										   <td align="left" style="font-size: 12px;">  &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;<img src="<?php echo IMG_PATH?>check_mark_icon.jpg" />
										   &nbsp;YES  &nbsp; &nbsp; &nbsp; &nbsp;
															 <input type="checkbox" class="radio"  style="width:80px; font-size: 15px;" id="twoAnchorNo" name="twoAnchorNo" >
												 NO </td>
										  </tr>
									<tr>
										<td align="left">17.</td>
										<td  align="left">TWO ANCHORS IN GOOD WORKING CONDITION?</td> 
										<td align="left" style="font-size: 12px;">  &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;<img src="<?php echo IMG_PATH?>check_mark_icon.jpg" />
										   &nbsp;YES  &nbsp; &nbsp; &nbsp; &nbsp;
															 <input type="checkbox" class="radio"  style="width:80px; font-size: 15px;" id="twoAnchorNo" name="twoAnchorNo" >
												 NO </td>
										  </tr>
									 </tr>
									 <tr>
										<td align="left">18.</td> 
										<td  align="left">RUDDER INDICATOR IN GOOD WORKING CONDITION?</td> 
										<td align="left" style="font-size: 12px;">  &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;<img src="<?php echo IMG_PATH?>check_mark_icon.jpg" />
										   &nbsp;YES  &nbsp; &nbsp; &nbsp; &nbsp;
															 <input type="checkbox" class="radio"  style="width:80px; font-size: 15px;" id="twoAnchorNo" name="twoAnchorNo" >
												 NO </td>
										  </tr>
									 </tr>
									 <tr>
											<td align="left">19.</td>
											<td  align="left">RPM INDICATOR IN GOOD WORKING CONDTION?</td> 
										   <td align="left" style="font-size: 12px;">  &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;<img src="<?php echo IMG_PATH?>check_mark_icon.jpg" />
										   &nbsp;YES  &nbsp; &nbsp; &nbsp; &nbsp;
															 <input type="checkbox" class="radio"  style="width:80px; font-size: 15px;" id="twoAnchorNo" name="twoAnchorNo" >
												 NO </td>
										  </tr>
									 </tr>
									 <tr>
										<td align="left">20.</td>
										<td  align="left">BOW THRUSTER AVAILABLE?</td> 
										<td align="left" style="font-size: 12px;">  &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;<img src="<?php echo IMG_PATH?>check_mark_icon.jpg" />
										   &nbsp;YES  &nbsp; &nbsp; &nbsp; &nbsp;
															 <input type="checkbox" class="radio"  style="width:80px; font-size: 15px;" id="twoAnchorNo" name="twoAnchorNo" >
												 NO </td>
										  </tr>
									 </tr>
									<tr>
										<td align="left">21.</td>
										<td  align="left">ARE YOU COMPLYING SOLAS CONVENTION?</td> 
										<td align="left" style="font-size: 12px;">  &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;<img src="<?php echo IMG_PATH?>check_mark_icon.jpg" />
										   &nbsp;YES  &nbsp; &nbsp; &nbsp; &nbsp;
															 <input type="checkbox" class="radio"  style="width:80px; font-size: 15px;" id="twoAnchorNo" name="twoAnchorNo" >
												 NO </td>
										  </tr>
									</tr>
									<tr>
									   <td align="left">23.</td>
							<td align="left" style="width:250px; font-size: 12px;">NOS OF GOOD MOORING LINES: FORD:  <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>	
										<td align="left" style="width:250px; font-size: 12px;">AFT : <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>			
									</tr>			
									<tr>
										<td align="left">23.</td>
							<td align="left" style="width:250px; font-size: 12px;">STERN POWER AVAILABLE :  <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>	
										<td align="left" style="width:250px; font-size: 12px;">IMMEDIATELY : <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> SECS. LATER</td>												
									</tr>
									<tr>
										<td align="left">24.</td>
							<td align="left" colspan="2"  style="width:470px;">REMARKS IF ANY : <?php // echo $rtn_vsl_arrival_info[0]['Vessel_Name']?>
										</td>
									</tr>
									<tr><td colspan="4">&nbsp;</td></tr>
									<tr><td colspan="4">&nbsp;</td></tr>
						<tr align="left">
							<td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CERTIFIED THAT THE ABOVE PARTICULARS ARE CORRECT AND CHARGES THEREOF</td>						
						</tr>
						<tr align="left">
							<td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WILL BE PAID BY US/LOCAL AGENT INCLUSIVE OF OTHER PORT CHARGES.</td>						
						</tr>
						<tr><td colspan="4">&nbsp;</td></tr>
								<tr><td colspan="4">&nbsp;</td></tr>

						<tr>
						<td colspan="4" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtn_vsl_arrival_info[0]['sign_arraival']; ?>&nbsp;&nbsp;&nbsp;&nbsp;</u></td>	
						<!--td colspan="4" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "2018-09-26";?>&nbsp;&nbsp;&nbsp;&nbsp;</u></td-->	
						<td colspan="4" >---------------------------------------------</td>	
						</tr>
						<tr>
						<td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATE</td>	
						<td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MASTER</td>	
						</tr>

						<tr align="left">
							<td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FORWARDED TO THE CHIEF FINANCE & ACCOUNTS OFFICER,PORT AUTHORITY</td>						
						</tr>
						<tr align="left">
							<td colspan="4" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CHITTAGONG FOR NECESSARY ACTION.</td>						
						</tr>
						<tr><td colspan="4">&nbsp;</td></tr>
								<tr><td colspan="4">&nbsp;</td></tr>
						<tr>
									<td colspan="4" >---------------------------------------------</td>	
									<td colspan="4" >-------------------------------------------------------------------------</td>
									<td colspan="1"></td>
						</tr>
						<tr>
				<!--                   <td colspan="1"></td>-->
						<td  colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AHM/PILOT</td>	
						<td  colspan="4">DEPUTY CONSERVATOR/HARBOUR MASTER</td>
										
						</tr>
						<tr>
						<td colspan="4">&nbsp;&nbsp;&nbsp;<u>CHITTAGONG PORT AUTHORITY</u></td>	
						<td colspan="4" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>CHITTAGONG PORT AUTHORITY</u></td>	
						
								</tr>
						


				 </table>
		</div>
		<?php } if ($igm_id_shift>0) {
		?>
		<div style="page-break-after: always;background: #eaf9a7; height:1050px;">
			<table class="tbl" width="100%" border ='0' cellpadding='0' cellspacing='0' >
				<!--tr align="center">
					<td colspan="10" align="center"> <b><u>CHITTAGONG PORT AUTHORITY</u></b> </td>
				</tr-->
				<tr align="center">
					<td  colspan="10" align="center" style="border:none;"><font size="5"><b><u>THE CHITTAGONG PORT AUTHORITY</u></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="10"  align="center" style="border:none;"><font size="5"><b>PILOTAGE CERTIFICATE FOR SHIFTING</b></font></td>
				</tr>
				<tr align="left">
					<td colspan="4"><font size="2px">1. VESSEL NAME : <u><?php echo $rtnVesselDetails_igm[0]['Vessel_Name']; ?></u></font></td>
					<td colspan="3"><font size="2px">CALL SIGN : <u><?php echo $rtnVesselDetails_n4[0]['radio_call_sign']; ?></u></font></td>
					<td colspan="3"><font size="2px">FLAG : <u><?php echo $rtnVesselDetails_n4[0]['flag']; ?></u></font></td>
				</tr>
				<tr align="left">
					<td colspan="10"><font size="2px">2. NAME OF MASTER : <u><?php echo $rtnVesselDetails_igm[0]['Name_of_Master']; ?></u></font></td>
				</tr>
				<tr align="left">
					<td colspan="4">3. GRT : <u><?php echo $rtnVesselDetails_n4[0]['gross_registered_ton']; ?></u></td>
					<td colspan="3">NRT : <u><?php echo $rtnVesselDetails_n4[0]['net_registered_ton']; ?></u></td>
					<td colspan="3">DECK CARGO : <u><?php echo $rtnVesselDetails_igm[0]['Deck_cargo']; ?></u></td>
				</tr>
				<tr align="left">
					<td colspan="4">4. LOA : <u><?php echo $rtnVesselDetails_n4[0]['loa_cm']; ?></u></td>
					<td colspan="6" class="lbl">MAX FW DRAUGHT : <u><?php echo $rtnVesselDetails_n4[0]['beam_cm']; ?></u></td>

				</tr>
				<tr align="left">
					<td colspan="10" class="lbl">5. NAME AND ADDRESS OF OWNERS : -------------------------------------------------------------</td>
				</tr>
				<tr align="left">
					<td colspan="10" class="lbl">6. LOCAL AGENT : <u><?php echo $rtnVesselDetails_n4[0]['localagent']; ?></u></td> 
					
				</tr>
				<tr align="left">
					<td colspan="4" class="lbl">7. NAME OF PILOT : <u><?php if(count($rslt_show_current_data)>0) { echo $rslt_show_current_data[0]['pilot_name']; } else { echo ""; } ?></u></td>
					<td colspan="3" align="right">BOARDED AT : <u><?php if(count($rslt_show_current_data)>0) { echo $rslt_show_current_data[0]['pilot_on_board']; } else { echo ""; } ?></u></td>
					<td colspan="2" align="right">LEFT AT : <u><?php if(count($rslt_show_current_data)>0) { echo $rslt_show_current_data[0]['pilot_off_board']; } else { echo ""; } ?></u></td>
					<td colspan="1" align="right">DT : -----------</td>
				</tr>
				<tr align="left">
					<td colspan="4">8. SHIFTED/SWUNG FROM : <u><?php if(count($rslt_show_current_data)>0) { echo $rslt_show_current_data[0]['shift_frm']; } else {echo "";} ?></u></td>
					<td colspan="6" align="right">   TO : <u><?php if(count($rslt_show_current_data)>0) { echo $rslt_show_current_data[0]['shift_to']; } else {echo "";} ?></u></td>
				</tr>
				<tr align="left">
					<td colspan="4" >9. TIME OF MOORING/UNMOORING FROM : <u><?php if(count($rslt_show_current_data)>0) { echo $rslt_show_current_data[0]['mooring_frm_time']; } else {echo "";} ?></td>
					<td colspan="3">TO : <u><?php if(count($rslt_show_current_data)>0) { echo $rslt_show_current_data[0]['mooring_to_time']; } else {echo "";} ?></u></td>
					<td colspan="3">DT : <u><?php if(count($rslt_show_current_data)>0) { echo $rslt_show_current_data[0]['shift_dt']; } else {echo "";} ?></u></td>
				</tr>
				<tr align="left">
					<td colspan="4">10. CPA TUG/TUGS(NAME) : <u><?php if(count($rslt_show_current_data)>0) { echo $rslt_show_current_data[0]['aditional_tug']; } else {echo "";} ?></u></td>
					<!--td colspan="4">10. CPA TUG/TUGS(NAME) : <u><?php  echo "1"; ?></u></td-->
					<td colspan="3">ASSISTANCE FROM : <u><?php if(count($rslt_show_current_data)>0) { echo $rslt_show_current_data[0]['assit_frm']; } else {echo "";} ?></u></td>
					<td colspan="2">TO : <u><?php if(count($rslt_show_current_data)>0) { echo $rslt_show_current_data[0]['assit_to']; } else {echo "";} ?></u></td>
					<td colspan="1">DT : <u><?php if(count($rslt_show_current_data)>0) { echo $rslt_show_current_data[0]['shift_dt']; } else {echo "";} ?></u></td>
				</tr>
				<tr align="left">
					<td colspan="6">11. MAIN ENGINES IN GOOD WORKING CONDITION?</td> 
					<td colspan="2">
						<img src="<?php echo IMG_PATH?>check_mark_icon.jpg" /> YES
						<!--input type="checkbox" class="radio" value="1" name="shift_good_cond_yes" id="shift_good_cond_yes" checked /-->
					</td>
					<td colspan="2">
						<input type="checkbox" class="radio" value="1" name="shift_good_cond_yes" id="shift_good_cond_yes" /> NO
					</td>
				</tr>
				<tr align="left">
					<td colspan="6">12. TWO ANCHORS IN GOOD WORKING CONDITION?</td>
					<td colspan="2">
						<img src="<?php echo IMG_PATH?>check_mark_icon.jpg" /> YES
						<!--input type="checkbox" class="radio" value="1" name="shift_two_anchors_yes" id="shift_two_anchors_yes" checked /-->
					</td>
					<td colspan="2">
						<input type="checkbox" class="radio" value="1" name="shift_two_anchors_no" id="shift_two_anchors_no"/> NO
					</td>
				</tr>
				<tr align="left">
					<td colspan="6">13. RUDDER INDICATOR IN GOOD WORKING CONDITION?</td>
					<td colspan="2">
						<img src="<?php echo IMG_PATH?>check_mark_icon.jpg" /> YES
						<!--input type="checkbox" class="radio" value="1" name="shift_rudded_indicator_yes" id="shift_rudded_indicator_yes" checked /-->
					</td>
					<td colspan="2">
						<input type="checkbox" class="radio" value="1" name="shift_rudded_indicator_no" id="shift_rudded_indicator_no" /> NO
					</td>
				</tr>
				<tr align="left">
					<td colspan="6">14. RPM INDICATOR IN GOOD WORKING CONDITION?</td>
					<td colspan="2">
						<img src="<?php echo IMG_PATH?>check_mark_icon.jpg" /> YES
						<!--input type="checkbox" class="radio" value="1" name="shift_rpm_indicator_yes" id="shift_rpm_indicator_yes" /-->
					</td>
					<td colspan="2">
						<input type="checkbox" class="radio" value="1" name="shift_rpm_indicator_no" id="shift_rpm_indicator_no" /> NO
					</td>
				</tr>
				<tr align="left">
					<td colspan="6">15. BOW THURSTER AVAILABLE?</td>
					<td colspan="2">
						<img src="<?php echo IMG_PATH?>check_mark_icon.jpg" /> YES
						<!--input type="checkbox" class="radio" value="1" name="shift_bow_thurster_yes" id="shift_bow_thurster_yes" /-->
					</td>
					<td colspan="2">
						<input type="checkbox" class="radio" value="1" name="shift_bow_thurster_no" id="shift_bow_thurster_no" /> NO
					</td>

				</tr>
				<tr align="left">
					<td colspan="6">16. ARE YOU COMPLYING SOLAS CONVENTION?</td>
					<td colspan="2">
						<img src="<?php echo IMG_PATH?>check_mark_icon.jpg" /> YES
						<!--input type="checkbox" class="radio" value="1" name="shift_solas_convention_yes" id="shift_solas_convention_yes" /-->
					</td>
					<td colspan="2">
						<input type="checkbox" class="radio" value="1" name="shift_solas_convention_no" id="shift_solas_convention_no" /> NO
					</td>
				</tr>
				<tr align="left">
					<td colspan="8" >17. NOS. OF GOOD MOORING LINES: FORD : -------------------------------------</td>
					<td colspan="2">AFT : -----------------------------------</td>
				</tr>
				<tr align="left">
					<td colspan="6">18. STERN POWER AVAILABLE : -----------</td>
					<td colspan="2">IMMEDIATELY : -----------</td>
					<td colspan="2">SECS.LATER</td>						
				</tr>
				<tr align="left">
					<td colspan="10" class="lbl">19. REMARKS IF ANY :-</td>
				</tr>
				<tr align="left">
					<td colspan="10" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CERTIFIED THAT THE ABOVE PARTICULARS ARE CORRECT AND CHARGES THEREOF</td>						
				</tr>
				<tr align="left">
					<td colspan="10" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WILL BE PAID BY US/LOCAL AGENT INCLUSIVE OF OTHER PORT CHARGES.</td>						
				</tr>
				<tr><td colspan="10" class="lbl"></td></tr>
				<tr><td colspan="10" class="lbl"></td></tr>
				<tr><td colspan="10" class="lbl"></td></tr>
				<tr>
					<td colspan="4" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><?php if(count($rslt_show_current_data)>0) { echo $rslt_show_current_data[0]['sign_shift']; } else { echo "------------"; } ?></u></td>	
					<!--td colspan="4" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo "2018-09-27";  ?></u></td-->	
					<td colspan="6" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;---------------------------------------------</td>	
				</tr>
				<tr>
						<td colspan="4" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATE</td>	
						<td colspan="6" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MASTER</td>	
					</tr>
					<tr><td colspan="10" class="lbl"></td></tr>
					<tr><td colspan="10" class="lbl"></td></tr>
					<tr><td colspan="10" class="lbl"></td></tr>
					<tr align="left">
						<td colspan="10" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FORWARDED TO THE CHIEF FINANCE & ACCOUNTS OFFICER,PORT AUTHORITY</td>						
					</tr>
					<tr align="left">
						<td colspan="10" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CHITTAGONG FOR NECESSARY ACTION.</td>						
					</tr>
					<tr><td colspan="10" class="lbl"></td></tr>
					<tr><td colspan="10" class="lbl"></td></tr>
					<tr><td colspan="10" class="lbl"></td></tr>
					<tr>
						<td colspan="4" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--------------------</td>	
						<td colspan="6" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-----------------------</td>
					</tr>
					<tr>
						<td colspan="4" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AHM/PILOT</td>	
						<td colspan="6" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DEPUTY CONSERVATOR/HARBOUR MASTER</td>						
					</tr>
					<tr>
						<td colspan="4" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>CHITTAGONG PORT AUTHORITY</u></td>	
						<td colspan="6" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>CHITTAGONG PORT AUTHORITY</u></td>	
					</tr>
			</table>
		</div>
		<?php } if ($igm_id_depart>0) {
		?>
		<div style="background: #E6E45A; font-family: Times New Roman;font-size: 10px; height:1050px;">
			<table class="tbl" width="100%" border ='0' cellpadding='0' cellspacing='0' >
				<tr align="center">
					<td  colspan="10" align="center" style="border:none;"><font size="5"><b><u>THE CHITTAGONG PORT AUTHORITY</u></b></font></td>	
				</tr>
				<tr align="center">
					<td colspan="10"  align="center" style="border:none;"><font size="5"><b>DEPARTURE REPORT OF VESSEL <BR> AND</b></font></td>
				</tr>
				<tr align="center">
					<td colspan="10" align="center" style="border:none;"> <font size="5"><b><u>PILOTAGE CERTIFICATE</u></b></font> </td>
				</tr>
				<tr align="left">
					<td colspan="4">1.&nbsp;&nbsp;&nbsp;VESSEL NAME : <u><?php echo $rtnVesselDetails_igm[0]['Vessel_Name']; ?></u></td>
					<td colspan="3">CALL SIGN : <u><?php echo $rtnVesselDetails_n4[0]['radio_call_sign']; ?></u></td>
					<td colspan="3">FLAG : <u><?php echo $rtnVesselDetails_n4[0]['flag']; ?></u></td>
				</tr>
				<tr align="left">
					<td colspan="10" class="lbl">2.&nbsp;&nbsp;&nbsp;NAME OF MASTER : <u><?php echo $rtnVesselDetails_igm[0]['Name_of_Master']; ?></u></td>
				</tr>
				<tr align="left">
						<td colspan="3">3.&nbsp;&nbsp;&nbsp;GRT : <u><?php echo $rtnVesselDetails_n4[0]['gross_registered_ton']; ?></u></td>
						<td colspan="3">NRT : <u><?php echo $rtnVesselDetails_n4[0]['net_registered_ton']; ?></u></td>
						<td colspan="4">DECK CARGO : <u><?php echo $rtnVesselDetails_igm[0]['Deck_cargo']; ?></u></td>
				</tr>
				<tr align="left">
						<td colspan="4">4.&nbsp;&nbsp;&nbsp;LOA : <u><?php echo $rtnVesselDetails_n4[0]['loa_cm']; ?></u></td>
						<td colspan="6">MAX FW DRAUGHT : <u><?php echo $rtnVesselDetails_n4[0]['beam_cm']; ?></u></td>
				</tr>
				<tr align="left">
						<td colspan="4" class="lbl">5.&nbsp;&nbsp;&nbsp;NAME AND ADDRESS OF OWNERS</td>
						<td colspan="6">-------------------------------------------------------------</td>
				</tr>
				<tr align="left">
						<td colspan="4">6.&nbsp;&nbsp;&nbsp;LOCAL AGENT : <u><?php echo $rtnVesselDetails_n4[0]['localagent']; ?></u></td>
						<td colspan="3">LAST PORT : -----------</td>
						<td colspan="3">NEXT PORT : <u><?php echo $rtnVesselDetails_igm[0]['Port_of_Destination']; ?></u></td>
				</tr>
				<tr align="left">
						<td colspan="3">7.&nbsp;&nbsp;&nbsp;NAME OF PILOT : <u><?php if($chk_igm_id>0) { echo $rtnVesselDetails_depart[0]['pilot_name']; } else { echo "---------"; } ?></u></td>
						<td colspan="2">BOARDED AT : <u><?php if($chk_igm_id>0) { echo $rtnVesselDetails_depart[0]['pilot_on_board']; } else { echo "--------"; } ?></u></td>
						<td colspan="3">LEFT AT : <u><?php if($chk_igm_id>0) { echo $rtnVesselDetails_depart[0]['pilot_off_board']; } else { echo "--------"; } ?></u></td>
						<td colspan="2">DT : -----------</td>

					</tr>
					<tr align="left">
						<td colspan="4" >8.&nbsp;&nbsp;&nbsp;PILOTAGE FROM : <u><?php if($chk_igm_id>0) { echo $rtnVesselDetails_depart[0]['pilot_frm']; } else { echo "---------"; } ?></u></td>
						<td colspan="3">TO : <u><?php if($chk_igm_id>0) { echo $rtnVesselDetails_depart[0]['pilot_to']; } else { echo "----------"; } ?></u></td>
						<td colspan="3">DT : -----------------</td>
					</tr>
					<tr align="left">
						<td colspan="4">9.&nbsp;&nbsp;&nbsp;DATE OF ARRAIVAL IN PORT : <u><?php if($chk_igm_id>0) { echo $ata; } else { echo "----------------"; } ?></u></td>
						<td colspan="6">DATE AND HOUR OF BERTHING : --------------------------</td>
					</tr>
					<tr align="left">
						<td colspan="4" >10. DATE OF DEPARTURE : <u><?php if($chk_igm_id>0) { echo $rtnVesselDetails_depart[0]['atd']; } else { echo "------------"; } ?></u></td>
						<td colspan="6" >DEP.DRAFT(MAX) : ------------------</td>
					</tr>
					<tr align="left">
						<td colspan="4">11. TIME OF UNMOORING FROM : <u><?php if($chk_igm_id>0) { echo $rtnVesselDetails_depart[0]['mooring_frm_time']; } else { echo "----------"; } ?></u></td>
						<td colspan="3">TO : <u><?php if($chk_igm_id>0) { echo $rtnVesselDetails_depart[0]['mooring_to_time']; } else { echo "----------"; } ?></u></td>
						<td colspan="3">DT : ---------------------------------</td>
					</tr>
					<tr align="left">
						<td colspan="3" class="lbl">12. CPA TUG/TUGS(NAME) : <u><?php if($chk_igm_id>0) { echo $rtnVesselDetails_depart[0]['aditional_tug']; } else { echo ""; } ?></u></td>
						<!--td colspan="3" class="lbl">12. CPA TUG/TUGS(NAME) : <u><?php echo "1"; ?></u></td-->
						<td colspan="3" class="lbl">ASSISTANCE FROM : <u><?php if($chk_igm_id>0) { echo $rtnVesselDetails_depart[0]['assit_frm']; } else { echo ""; } ?></u></td>
						<td colspan="2" >TO : <u><?php if($chk_igm_id>0) { echo $rtnVesselDetails_depart[0]['assit_to']; } else { echo ""; } ?></u></td>
						<td colspan="2" >DT : -------------------------</td>
					</tr>
					<tr align="left">
						<td colspan="4" class="lbl">13. PC NO : -----------------------------</td>
						<td colspan="6" class="lbl">DT : ----------------------------------</td>
					</tr>
					<tr align="left">
						<td colspan="10">14. TONS OF CARGO ON BOARD : ------------------------------------------------</td>
					</tr>
					<tr align="left">
						<td colspan="6" class="lbl">15. MAIN ENGINES IN GOOD WORKING CONDITION?</td>
						<td colspan="2">
							<img src="<?php echo IMG_PATH?>check_mark_icon.jpg" /> YES
						</td>
						<td colspan="2">
							<input type="checkbox" class="radio" id="goodCondNo" name="d_goodCondNo" onclick="checkCond(0)" style="width: 99%;"/> NO
						</td>

					</tr>
					<tr align="left">
						<td colspan="6" class="lbl">16. TWO ANCHORS IN GOOD WORKING CONDITION?</td>
						<td colspan="2">
							<img src="<?php echo IMG_PATH?>check_mark_icon.jpg" /> YES
						</td>
						<td colspan="2">
							<input type="checkbox" class="radio" id="anchorGoodCondNo" name="d_anchorGoodCondNo" onclick="checkCond(3)" style="width: 99%;" /> NO
						</td>

					</tr>
					<tr align="left">
						<td colspan="6" class="lbl">17. RUDDER INDICATOR IN GOOD WORKING CONDITION?</td>
						<td colspan="2">
							<img src="<?php echo IMG_PATH?>check_mark_icon.jpg" /> YES
						</td>
						<td colspan="2">
							<input type="checkbox" class="radio" id="radarGoodCondNo" name="d_radarGoodCondNo" onclick="checkCond(5)" style="width: 99%;" /> NO
						</td>

					</tr>
					<tr align="left">
						<td colspan="6" class="lbl">18. RPM INDICATOR IN GOOD WORKING CONDITION?</td>
						<td colspan="2">
							<img src="<?php echo IMG_PATH?>check_mark_icon.jpg" /> YES
						</td>
						<td colspan="2">
							<input type="checkbox" class="radio" id="rpmGoodCondNo" name="d_rpmGoodCondNo" onclick="checkCond(7)" style="width: 99%;"/> NO
						</td>

					</tr>
					<tr align="left">
						<td colspan="6" class="lbl">19. BOW THURSTER AVAILABLE?</td>
						<td colspan="2">
							<img src="<?php echo IMG_PATH?>check_mark_icon.jpg" /> YES
						</td>
						<td colspan="2">
							<input type="checkbox" class="radio" id="bowAvailableNo" name="d_bowAvailableNo" onclick="checkCond(9)" style="width: 99%;"/> NO
						</td>

					</tr>
					<tr align="left">
						<td colspan="6" class="lbl">20. ARE YOU COMPLYING SOLAS CONVENTION?</td>
						<td colspan="2">
							<img src="<?php echo IMG_PATH?>check_mark_icon.jpg" /> YES
						</td>
						<td colspan="2">
							<input type="checkbox" class="radio" id="solasConventionNo" name="d_solasConventionNo" onclick="checkCond(11)" style="width: 99%;" /> NO
						</td>

					</tr>
					<tr align="left">
						<td colspan="4">21. NOS. OF GOOD MOORING LINES:FORD : ------</td>
						<td colspan="6">AFT : ------</td>
					</tr>
					<tr align="left">
						<td colspan="4" class="lbl">22. STERN POWER AVAILABLE : -----------------</td>
						<td colspan="3" class="lbl">IMMEDIATELY : ---------------</td>
						<td colspan="3" class="lbl">SECS.LATER</td>						
					</tr>
					<tr align="left">
						<td colspan="10" class="lbl">23. REMARKS IF ANY :-</td>
					</tr>
					<tr align="left">
						<td colspan="10" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CERTIFIED THAT THE ABOVE PARTICULARS ARE CORRECT AND CHARGES THEREOF</td>						
					</tr>
					<tr align="left">
						<td colspan="10" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WILL BE PAID BY US/LOCAL AGENT INCLUSIVE OF OTHER PORT CHARGES.</td>						
					</tr>
					<tr><td colspan="10" class="lbl"></td></tr>
					<tr><td colspan="10" class="lbl"></td></tr>
					<tr><td colspan="10" class="lbl"></td></tr>
					<tr>
						<td colspan="4" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><?php if($chk_igm_id>0) { echo $rtnVesselDetails_depart[0]['sign_depart']; } else { echo "------------"; } ?></u></td>	
						<!--td colspan="4" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><?php echo "2018-09-29"; ?></u></td-->	
						<td colspan="6" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;---------------------------------------------</td>	
					</tr>
					<tr>
						<td colspan="4" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATE</td>	
						<td colspan="6" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MASTER</td>	
					</tr>
					<tr><td colspan="10" class="lbl"></td></tr>
					<tr><td colspan="10" class="lbl"></td></tr>
					<tr><td colspan="10" class="lbl"></td></tr>
					<tr align="left">
						<td colspan="10" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FORWARDED TO THE CHIEF FINANCE & ACCOUNTS OFFICER,PORT AUTHORITY</td>						
					</tr>
					<tr align="left">
						<td colspan="10" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CHITTAGONG FOR NECESSARY ACTION.</td>						
					</tr>
					<tr><td colspan="10" class="lbl"></td></tr>
					<tr><td colspan="10" class="lbl"></td></tr>
					<tr><td colspan="10" class="lbl"></td></tr>
					<tr>
						<td colspan="4" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--------------------</td>	
						<td colspan="6" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-----------------------</td>
					</tr>
					<tr>
						<td colspan="4" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AHM/PILOT</td>	
						<td colspan="6" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DEPUTY CONSERVATOR/HARBOUR MASTER</td>						
					</tr>
					<tr>
						<td colspan="4" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>CHITTAGONG PORT AUTHORITY</u></td>	
						<td colspan="6" class="lbl">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>CHITTAGONG PORT AUTHORITY</u></td>	
					</tr>
			</table>
		</div>
		<?php } ?>
	</BODY>
</HTML>