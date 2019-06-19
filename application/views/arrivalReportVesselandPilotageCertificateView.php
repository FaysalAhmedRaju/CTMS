<script>
    function checkCond(n) 
    {
      var engineCondYes = document.getElementById('engineCondYes');
      var engineCondNo = document.getElementById('engineCondNo');
      var twoAnchorYes = document.getElementById('twoAnchorYes');
      var twoAnchorNo = document.getElementById('twoAnchorNo');
      var radarGoodCondYes = document.getElementById('radarGoodCondYes');
      var radarGoodCondNo = document.getElementById('radarGoodCondNo');
      var rpmIndicatorYes = document.getElementById('rpmIndicatorYes');
      var rpmIndicatorNo = document.getElementById('rpmIndicatorNo');
      var bowThrusterYes = document.getElementById('bowThrusterYes');
      var bowThrusterNo = document.getElementById('bowThrusterNo');
      var complyingSolasConventionYes = document.getElementById('complyingSolasConventionYes');
      var complyingSolasConventionNo = document.getElementById('complyingSolasConventionNo');
   
     if(n === 1){  
      engineCondYes.checked = true;  
      engineCondNo.checked = false;
     } 
     else if (n === 2) {   
      engineCondYes.checked = false;  
      engineCondNo.checked = true;
     }
     else if(n === 3){  
      twoAnchorYes.checked = true;  
      twoAnchorNo.checked = false;
     }
     else if (n === 4) {   
     twoAnchorYes.checked = false;  
     twoAnchorNo.checked = true;
     }
     else if(n === 5){  
      radarGoodCondYes.checked = true;  
      radarGoodCondNo.checked = false;
     }
     else if (n === 6) {   
      radarGoodCondYes.checked = false;  
      radarGoodCondNo.checked = true;
     }
      else if(n === 7){  
      rpmIndicatorYes.checked = true;  
      rpmIndicatorNo.checked = false;
     }
     else if (n === 8) {   
      rpmIndicatorYes.checked = false;  
      rpmIndicatorNo.checked = true;
     }
     else if(n === 9){  
      bowThrusterYes.checked = true;  
      bowThrusterNo.checked = false;
     }
     else if (n === 10) {   
      bowThrusterYes.checked = false;  
      bowThrusterNo.checked = true;
     }
	 else if(n === 11){  
      complyingSolasConventionYes.checked = true;  
      complyingSolasConventionNo.checked = false;
     }
     else if (n === 12) {   
      complyingSolasConventionYes.checked = false;  
      complyingSolasConventionNo.checked = true;
     }
    }
  </script>  
<style>
.read{ background-color : #F7EEC0; }
/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 9999; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    position: relative;
    background-color: #fefefe;
    margin: auto;
    padding: 0;
    border: 1px solid #888;
    width: 35%;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
    -webkit-animation-name: animatetop;
    -webkit-animation-duration: 0.4s;
    animation-name: animatetop;
    animation-duration: 0.4s
}

/* Add Animation */
@-webkit-keyframes animatetop {
    from {top:-300px; opacity:0} 
    to {top:0; opacity:1}
}

@keyframes animatetop {
    from {top:-300px; opacity:0}
    to {top:0; opacity:1}
}

/* The Close Button */
.close {
    color: black;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.modal-header {
    padding: 2px 16px;
    background-color: #fff;
    color: #000;
	
}

.modal-body {padding: 2px 16px;}

.modal-footer {
    padding: 2px 16px;
    background-color: #5cb85c;
    color: white;
}
</style>
 

 <div class="content">
    <div class="content_resize_1">
      <div class="mainbar_1">
        <div class="article">
          <h2 align="center"><span><?php echo $title; ?></span> </h2>
		  <h3 align="center"><b>ARRIVAL REPORT OF VESSEL AND PILOTAGE CERTIFICATE</b></h2>

          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>	  
		 
	
	<div class="img">
		<form name= "myForm" onsubmit="return validate();" action="<?php echo site_url("report/saveArrivalReportVesselandPilotageCertificateInfo");?>"  method="post">
                    
			<table> 
                            <input type="hidden"  id="igmId" name="igmId" value="<?php echo $rtnVesselDetails_igm[0]['id']?>" >
                            <input type="hidden"  id="vvdGkey" name="vvdGkey" value="<?php echo $rtnVesselDetails_n4[0]['vvd_gkey']?>" >
                             <input type="hidden"  id="rotation" name="rotation" value="<?php echo $rotation;?>" >
                            <tr>
                                <th align="left">1.</th>
				<th align="left" ><nobr>VESSELS NAME :
                                <input class="read" type="text" style="width:200px;"  id="vesselName" name="vesselName" value="<?php echo $rtnVesselDetails_igm[0]['Vessel_Name']?>" ></nobr></th>
				<th align="left"><nobr>CALL SIGN :
				<input  class="read" type="text" style="width:200px;" id="callsign" name="callsign"  value="<?php echo $rtnVesselDetails_n4[0]['radio_call_sign']?>"></nobr></th>
				<th align="left"><nobr>FLAG :
                                <input class="read" type="text" style="width:200px;" id="flag" name="flag" value="<?php echo $rtnVesselDetails_n4[0]['cntry_name']?>" ></nobr></th>
                            </tr>
                            <tr>
                                <th align="left">2.</th>
                                <th align="left" colspan="3" ><nobr>NAME OF MASTER :
				<input style="width:700px;" class="read" type="text"  id="masterName" name="masterName"  value="<?php echo $rtnVesselDetails_igm[0]['Name_of_Master']?>"></nobr></th>
                            </tr>
                            <tr>                                
                                <th align="left">3.</th>
				<th align="left"><nobr>GRT :
				<input  class="read" type="text" style="width:200px;" id="grt" name="grt" value="<?php echo $rtnVesselDetails_n4[0]['gross_registered_ton']?>"></nobr>
				<th align="left"><nobr>NRT :
				<input class="read" type="text" style="width:200px;" id="nrt" name="nrt" value="<?php echo $rtnVesselDetails_n4[0]['net_registered_ton']?>"></td></nobr>
                                <th align="left"><nobr>DECK CARGO :
				<input class="read" type="text" style="width:160px;" id="deckCargo" name="deckCargo" value="<?php echo $rtnVesselDetails_igm[0]['Deck_cargo']?>"></td></nobr>
                            </tr>
                            <tr>
                                <th align="left">4.</th>
				<th align="left"><nobr>LOA :
                                <input class="read" type="text" style="width:250px;" id="loa" name="loa" value="<?php echo $rtnVesselDetails_n4[0]['loa_cm']?>"></td></nobr>
                                <th align="left" colspan="2"><nobr>MAX. FW DRAUGHT :
				<input class="read" type="text" style="width:300px;" id="maxFWdraught" name="maxFWdraught" value="<?php // echo $arrivalInfo42[0]['Vessel_Name']?>"></td><nobr>	
                            </tr>
                            <tr>
                                <th align="left">5.</th>
                                <th align="left" colspan="3"><nobr>NUMBER OF CREW & OFFICER INCLUSIVE MASTER :
                        	<input  style="width:500px;" class="read" type="text"  id="crewNumber" name="crewNumber" value="<?php echo $rtn_vsl_arrival_info[0]['Vessel_Name']?>"></nobr></td>
                            </tr>
                            <tr>
                                <th align="left">6.</th>
				<th align="left" colspan="3" ><nobr>NAME AND ADDRESS OF OWNERS:
				<input style="width:500px;" class="read" type="text" id="ownerInfo" name="ownerInfo" value="<?php echo $rtnVesselDetails_igm[0]['Vessel_Name']?>"></nobr></th>						
                            </tr>
                            <tr>
                                <th align="left">7.</th>
				<th align="left"><nobr>LOCAL AGENT :
				<input class="read" type="text" style="width:200px;" id="localAgent" name="localAgent" value="<?php echo $rtnVesselDetails_n4[0]['localagent']?>"></nobr></th>
                                <th align="left"><nobr>LAST PORT :
				<input  class="read" type="text" style="width:200px;" id="lastPort" name="lastPort" value="<?php // echo $arrivalInfo42[0]['Vessel_Name']?>"></td></nobr></th>
                                <th align="left"><nobr>NEXT PORT :
				<input class="read" type="text" style="width:145px;" id="nextPort" name="nextPort" value="<?php // echo $arrivalInfo42[0]['Vessel_Name']?>"></td></nobr></th>	
                            </tr>
                            <tr>
                                <th align="left">8.</th>
				<th align="left"><nobr>NAME OF PILOT :
				<input class="read" type="text" style="width:200px;" id="pilotName" name="pilotName" value="<?php echo $rtn_vsl_arrival_info[0]['pilot_name']?>" ></nobr></td>
                                <th align="left"><nobr>BOARDED :
				<input class="read" type="text" style="width:200px;" id="boardedTime" name="boardedTime" value="<?php echo $rtn_vsl_arrival_info[0]['pilot_on_board']?>"></nobr></td>
                                <th align="left"><nobr>LEFT :
				<input  class="read" type="text" style="width:200px;" id="leftTime" name="leftTime" value="<?php echo $rtn_vsl_arrival_info[0]['pilot_off_board']?>" ></nobr></td>	
                            </tr>
                            <tr>
                                <th align="left">9.</th>
				<th align="left"><nobr>PILOTAGE FROM :
				<input class="read" type="text" style="width:200px;" id=" " name="pilotageFrom" value="<?php echo $rtn_vsl_arrival_info[0]['pilot_frm']?>" ></nobr></td>	
                                <th align="left"><nobr>TO :
				<input  class="read" type="text" style="width:200px;" id="pilotageTo" name="pilotageTo" value="<?php echo $rtn_vsl_arrival_info[0]['pilot_to']?>"></td>						
                            </tr>
                            <tr> 
                                <th align="left">10.</th>
				<th align="left"><nobr>TIME OF MOORING FROM:
				<input class="read" type="text" style="width:170px;"  id="mooringTimeFrm" name="mooringTimeFrm" value="<?php echo $rtn_vsl_arrival_info[0]['mooring_frm_time']?>"></nobr></td>	
                                <th align="left"><nobr>TO:
				<input class="read" type="text" style="width:200px;"  id="mooringTimeTo" name="mooringTimeTo" value="<?php echo $rtn_vsl_arrival_info[0]['mooring_to_time']?>"></nobr></td>						
                            </tr>
                             <tr>
                                <th align="left">11.</th>
				<th align="left"><nobr>CPA TUG/TUGS(NAME):
				<input class="read" type="text"   style="width:150px;" id="cpaTugName" name="cpaTugName" value="<?php echo $rtn_vsl_arrival_info[0]['tug_name']?>"></nobr></td>	
                                <th align="left"><nobr>ASSISTANCE FROM :
				<input  class="read" type="text"  style="width:150px;" id="cpaTugAssisFrm" name="cpaTugAssisFrm" value="<?php echo $rtn_vsl_arrival_info[0]['assit_frm']?>"></nobr></td>	
                                <th align="left"><nobr>TO :
				<input  class="read" type="text"  style="width:150px;" id="cpaTugAssisTo" name="cpaTugAssisTo" value="<?php echo $rtn_vsl_arrival_info[0]['assit_to']?>"></nobr></td>						
                            </tr>
                            <tr> 
                                <th align="left">12.</th>
				<th align="left"><nobr>ARRIVAL AT OUTER ANCHORAGE DATE :
				<input  class="read" type="text"  style="width:100px;" id="arrivalOuterAnchorageDate" name="arrivalOuterAnchorageDate" value="<?php echo $rtn_vsl_arrival_info[0]['oa_dt']?>" ></td>	
                                <script>
					  $(function() {
						$( "#arrivalOuterAnchorageDate").datepicker({
						changeMonth: true,
						changeYear: true,
						dateFormat: 'yy-mm-dd', // iso format
							});
						});
				</script>	
                                <th align="left" colspan="2"><nobr>FW. DRAFT (MAX):
				<input class="read" type="text"  style="width:300px;" id="fwDraftMax" name="fwDraftMax" value="<?php // echo $rtn_vsl_arrival_info[0]['Vessel_Name']?>"></nobr></td>						
                            </tr>
                            <tr>
                                <th align="left">13.</th>
				<th align="left"><nobr>IF WORKED AS LIGHTER, NAME OF MOTHER VESSEL :</nobr></th>
				<td align="left" colspan="4"><input  class="read" type="text" id="motherVesselName" name="motherVesselName" value="<?php // echo $rtn_vsl_arrival_info[0]['Vessel_Name']?>"></td>						
                            </tr>
                            <tr>
                                <th align="left">14.</th> 
                                <th align="left"colspan="3"><nobr>WORKED AT OUTER ANCHORAGE /OUTAGE PORT LIMIT.(TICK):
                                <input  class="read" style="width:400px" type="text" id="anchoaragePortLimit" name="anchoaragePortLimit" value="<?php // echo $rtn_vsl_arrival_info[0]['Vessel_Name']?>"></nobr></td>						
                            </tr>
                            <tr>
                                <th align="left">15.</th>
                                <th align="left" colspan="3"><nobr>DANGEROUS CARGO IF ANY :
                                <input style="width:400px" class="read"  type="text" id="dangerCargo" name="dangerCargo" value="<?php // echo $rtn_vsl_arrival_info[0]['Vessel_Name']?>"></nobr></td>						
                          </tr>
                          </table>
                    
                    <table>
                          <tr>
                            <th align="left">16.</th>
                            <th  align="left">MAIN ENGINES IN GOOD WORKING CONDITION?</th> 
                            <td align="left" ><nobr><input type="checkbox" style="width:80px;"  class="radio" id="engineCondYes" name="engineCondYes" onclick="checkCond(1)" checked>
                            YES
                            <input type="checkbox" class="radio" style="width:80px;" id="engineCondNo" name="engineCondNo" onclick="checkCond(2)">
                            NO</nobr></td>
                          </tr>
                    <tr>
                        <th align="left">17.</th>
                       <th  align="left">TWO ANCHORS IN GOOD WORKING CONDITION?</th> 
                            <td align="left" ><input type="checkbox" style="width:80px;"  class="radio" id="twoAnchorYes" name="twoAnchorYes" onclick="checkCond(3)" checked>
                            YES
                            <input type="checkbox" class="radio" style="width:80px;" id="twoAnchorNo" name="twoAnchorNo" onclick="checkCond(4)">
                            NO</nobr></th>
                     </tr>
                     <tr>
                        <th align="left">18.</th> 
                        <th  align="left">RUDDER INDICATOR IN GOOD WORKING CONDITION?</th> 
                        <td align="left" ><nobr><input type="checkbox" style="width:80px;"  class="radio" id="radarGoodCondYes" name="radarGoodCondYes" onclick="checkCond(5)" checked>
                        YES
                        <input type="checkbox" class="radio" style="width:80px;" id="radarGoodCondNo" name="radarGoodCondNo" onclick="checkCond(6)">
                        NO</nobr></td>
                     </tr>
                     <tr>
                            <th align="left">19.</th>
                            <th  align="left">RPM INDICATOR IN GOOD WORKING CONDTION?</th> 
                            <td align="left" ><nobr><input type="checkbox" style="width:80px;"  class="radio" id="rpmIndicatorYes" name="rpmIndicatorYes" onclick="checkCond(7)" checked>
                            YES
                            <input type="checkbox" class="radio" style="width:80px;" id="rpmIndicatorNo" name="rpmIndicatorNo" onclick="checkCond(8)">
                            NO</nobr></td>
                     </tr>
                     <tr>
                        <th align="left">20.</th>
                        <th  align="left">BOW THRUSTER AVAILABLE?</th> 
                        <td align="left" ><nobr><input type="checkbox" style="width:80px;"  class="radio" id="bowThrusterYes" name="bowThrusterYes" onclick="checkCond(9)" checked>
                        YES
                        <input type="checkbox" class="radio" style="width:80px;" id="bowThrusterNo" name="bowThrusterNo" onclick="checkCond(10)">
                        NO</nobr></td>
                     </tr>
                    <tr>
                        <th align="left">21.</th>
                        <th  align="left">ARE YOU COMPLYING SOLAS CONVENTION?</th> 
                        <td align="left" ><nobr><input type="checkbox" style="width:80px;"  class="radio" id="complyingSolasConventionYes" name="complyingSolasConventionYes" onclick="checkCond(11)" checked>
                        YES
                        <input type="checkbox" class="radio" style="width:80px;" id="complyingSolasConventionNo" name="complyingSolasConventionNo" onclick="checkCond(12)">
                        NO</nobr></td>
                    </tr>
                    <tr>
                        <th align="left">22.</th>
			<th align="left"><nobr>NOS. OF GOOD MOORING LINES: FORD 
			<input class="read" type="text" style="width:120px;" id="nosGoodMooringLinesFord" name="nosGoodMooringLinesFord" value="<?php // echo $rtn_vsl_arrival_info[0]['Vessel_Name']?>"></nobr></td>	
                        <th align="left"><nobr>AFT :
			<input  class="read" type="text" style="width:195px;" id="nosGoodMooringLinesAFT" name="nosGoodMooringLinesAFT" value="<?php // echo $rtn_vsl_arrival_info[0]['Vessel_Name']?>"></td>						
                    </tr>
                    <tr>
                        <th align="left">23.</th>
			<th align="left"><nobr>STERN POWER AVAILABLE :
			<input class="read" type="text" style="width:180px;" id="sternPowerAvailable" name="sternPowerAvailable" value="<?php // echo $rtn_vsl_arrival_info[0]['Vessel_Name']?>"></nobr></td>	
                        <th align="left"><nobr>IMMEDIATELY :
			<input  class="read" type="text" style="width:140px;" id="sternImmediately" name="sternImmediately" value="<?php // echo $rtn_vsl_arrival_info[0]['Vessel_Name']?>"></nobr></td>						
                    </tr>
                    <tr>
                        <th align="left">24.</th>
			<th align="left" colspan="2"><nobr>REMARKS IF ANY :
			<input class="read" type="text" style="width:470px;" id="arrivalRemarks" name="arrivalRemarks" value="<?php // echo $rtn_vsl_arrival_info[0]['Vessel_Name']?>"></nobr>
                        </th>
                    </tr> 
                     <tr>
                        <th align="left" colspan="3"><nobr><b>ARRIVAL DATE :</b>
			<input class="read" type="text" style="width:470px;" id="arrivalDate" name="arrivalDate" value="<?php echo $rtn_vsl_arrival_info[0]['ata']?>"></nobr>
                       <script>
					  $(function() {
						$( "#arrivalDate").datepicker({
						changeMonth: true,
						changeYear: true,
						dateFormat: 'yy-mm-dd', // iso format
							});
						});
			</script>
                        </th>
                    </tr> 
                    <tr align="center">
			<td colspan="2"><input class="login_button" style="width: 40%;" id="saveBtn" type="submit" value="SAVE ARRIVAL AND PILOTAGE INFO."/> </td>
        </form>	                
        <form name= "myForm" onsubmit="return validate();" action="<?php echo site_url("report/viewPdfArrivalReportVesselandPilotageCertificateInfo");?>"  target="_blank" method="post">
                         <input type="hidden"  id="arrival_rot" name="arrival_rot" value="<?php echo $rotation;?>" >   
                         <td align="left"><input class="login_button" id="viewBtn" type="submit" value="VIEW"/> </td>
        </form>
                        
                    </tr>
                    <tr align="center">
                        <td colspan="3"><?php echo $msg;?></td>
                    </tr>

		 </table>
					
			

	</div>
			
          <div class="clr"></div>
        </div>



       <!-- <p class="pages"><small>Page 1 of 2</small> <span>1</span> <a href="#">2</a> <a href="#">&raquo;</a></p>-->
      </div>
      <div class="sidebar" style="width:140px; padding: 0px 0 12px;">
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	<?php echo form_close()?>
  </div>