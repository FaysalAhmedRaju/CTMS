<div style="background-color: lightblue">
<div align="center" style="font-size:18px">
		<img align="middle"  width="220px" height="70px" src="<?php echo IMG_PATH?>cpanew.jpg">
	</div>

<table width="100%"  cellpadding='0'  cellspacing='0'>
       <tr>
	<td  align="center" style="border:none;"><font size="5"><b>ARRIVAL REPORT OF VESSEL AND PILOTAGE CERTIFICATE</b></font></td>	
       </tr>
</table>
                <table> 
<!--                            <input type="hidden"  id="igmId" name="igmId" value="<?php echo $rtnVesselDetails_igm[0]['id']?>" >
                            <input type="hidden"  id="vvdGkey" name="vvdGkey" value="<?php echo $rtnVesselDetails_n4[0]['vvd_gkey']?>" >
                             <input type="hidden"  id="rotation" name="rotation" value="<?php echo $rotation;?>" >-->
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
				<td align="left" style="width:150px; font-size: 12px;">CPA TUG/TUGS(NAME): <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtn_vsl_arrival_info[0]['tug_name']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </u></td>	
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
                    
                    <table>
                          <tr>
                            <td align="left">16.</td>
                            <td  align="left" style="width:300px; font-size: 12px;">MAIN ENGINES IN GOOD WORKING CONDITION?</td> YES
                           <td align="left" style="font-size: 12px;">  &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;<input type="checkbox" style="width:80px; font-size: 15px;"  class="radio" id="twoAnchorYes" name="twoAnchorYes"  >
                           &nbsp;YES  &nbsp; &nbsp; &nbsp; &nbsp;
                                             <input type="checkbox" class="radio"  style="width:80px; font-size: 15px;" id="twoAnchorNo" name="twoAnchorNo" >
                                 NO </td>
                          </tr>
                    <tr>
                        <td align="left">17.</td>
                        <td  align="left">TWO ANCHORS IN GOOD WORKING CONDITION?</td> 
                        <td align="left" style="font-size: 12px;">  &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;<input type="checkbox" style="width:80px; font-size: 15px;"  class="radio" id="twoAnchorYes" name="twoAnchorYes"  >
                           &nbsp;YES  &nbsp; &nbsp; &nbsp; &nbsp;
                                             <input type="checkbox" class="radio"  style="width:80px; font-size: 15px;" id="twoAnchorNo" name="twoAnchorNo" >
                                 NO </td>
                          </tr>
                     </tr>
                     <tr>
                        <td align="left">18.</td> 
                        <td  align="left">RUDDER INDICATOR IN GOOD WORKING CONDITION?</td> 
                        <td align="left" style="font-size: 12px;">  &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;<input type="checkbox" style="width:80px; font-size: 15px;"  class="radio" id="twoAnchorYes" name="twoAnchorYes"  >
                           &nbsp;YES  &nbsp; &nbsp; &nbsp; &nbsp;
                                             <input type="checkbox" class="radio"  style="width:80px; font-size: 15px;" id="twoAnchorNo" name="twoAnchorNo" >
                                 NO </td>
                          </tr>
                     </tr>
                     <tr>
                            <td align="left">19.</td>
                            <td  align="left">RPM INDICATOR IN GOOD WORKING CONDTION?</td> 
                           <td align="left" style="font-size: 12px;">  &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;<input type="checkbox" style="width:80px; font-size: 15px;"  class="radio" id="twoAnchorYes" name="twoAnchorYes"  >
                           &nbsp;YES  &nbsp; &nbsp; &nbsp; &nbsp;
                                             <input type="checkbox" class="radio"  style="width:80px; font-size: 15px;" id="twoAnchorNo" name="twoAnchorNo" >
                                 NO </td>
                          </tr>
                     </tr>
                     <tr>
                        <td align="left">20.</td>
                        <td  align="left">BOW THRUSTER AVAILABLE?</td> 
                        <td align="left" style="font-size: 12px;">  &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;<input type="checkbox" style="width:80px; font-size: 15px;"  class="radio" id="twoAnchorYes" name="twoAnchorYes"  >
                           &nbsp;YES  &nbsp; &nbsp; &nbsp; &nbsp;
                                             <input type="checkbox" class="radio"  style="width:80px; font-size: 15px;" id="twoAnchorNo" name="twoAnchorNo" >
                                 NO </td>
                          </tr>
                     </tr>
                    <tr>
                        <td align="left">21.</td>
                        <td  align="left">ARE YOU COMPLYING SOLAS CONVENTION?</td> 
                        <td align="left" style="font-size: 12px;">  &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;<input type="checkbox" style="width:80px; font-size: 15px;"  class="radio" id="twoAnchorYes" name="twoAnchorYes"  >
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
<!--                     <tr>
                        <td align="left" colspan="3" style="width:470px;">ARRIVAL DATE : <?php echo $rtn_vsl_arrival_info[0]['ata']?>
                       
                        </td>
                    </tr> -->
<!--                    <tr align="left">
			<td colspan="4" class="lbl">22. STERN POWER AVAILABLE:</td>
			<td colspan="1">---------------------------------</td>
			<td colspan="2" class="lbl">IMMEDIATELY</td>
			<td colspan="1">----------------------------------</td>
			<td colspan="2" class="lbl">SECS.LATER</td>						
                    </tr>-->
<!--		<tr align="left">
			<td colspan="10" class="lbl">23. REMARKS IF ANY :-</td>
		</tr>-->
		<tr align="left">
			<td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CERTIFIED THAT THE ABOVE PARTICULARS ARE CORRECT AND CHARGES THEREOF</td>						
		</tr>
		<tr align="left">
			<td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WILL BE PAID BY US/LOCAL AGENT INCLUSIVE OF OTHER PORT CHARGES.</td>						
		</tr>
		<tr><td colspan="4">&nbsp;</td></tr>
                <tr><td colspan="4">&nbsp;</td></tr>

		<tr>
		<td colspan="4" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rtn_vsl_arrival_info[0]['ata']?>&nbsp;&nbsp;&nbsp;&nbsp;</u></td>	
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