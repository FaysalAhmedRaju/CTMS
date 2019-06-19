 <style>
 #table-scroll {
  height:600px;
  width:850px;
  overflow:auto;  
  margin-top:20px;
}
table{
	border: 1px solid black;
    table-layout: fixed;
    width: 100%;
}

th, td {
	border-bottom: 1px solid #ddd;
}
.tbl {
	font-family: 	Times New Roman;
	color:		black;
	font-size:	12px;
}
.lbl
{
	
}
input[type="text"], textarea {

  background-color : #F7EEC0; 

}
 </style>
  <script>
    function checkCond(n) 
    {
      var goodCondYes = document.getElementById('goodCondYes');
      var goodCondNo = document.getElementById('goodCondNo');
	  var anchorGoodCondYes = document.getElementById('anchorGoodCondYes');
      var anchorGoodCondNo = document.getElementById('anchorGoodCondNo');
	  var radarGoodCondYes = document.getElementById('radarGoodCondYes');
      var radarGoodCondNo = document.getElementById('radarGoodCondNo');
	  var rpmGoodCondYes = document.getElementById('rpmGoodCondYes');
      var rpmGoodCondNo = document.getElementById('rpmGoodCondNo');
	  var bowAvailableYes = document.getElementById('bowAvailableYes');
      var bowAvailableNo = document.getElementById('bowAvailableNo');
	  var solasConventionYes = document.getElementById('solasConventionYes');
      var solasConventionNo = document.getElementById('solasConventionNo');
	  
     if(n === 0){  
      goodCondNo.checked = true;  
      goodCondYes.checked = false;
     }
     else if (n === 1) {   
      goodCondNo.checked = false;  
      goodCondYes.checked = true;
     }
	 else if(n === 2){  
      anchorGoodCondYes.checked = true;  
      anchorGoodCondNo.checked = false;
     }
     else if (n === 3) {   
      anchorGoodCondYes.checked = false;  
      anchorGoodCondNo.checked = true;
     }
	 else if(n === 4){  
      radarGoodCondYes.checked = true;  
      radarGoodCondNo.checked = false;
     }
     else if (n === 5) {   
      radarGoodCondYes.checked = false;  
      radarGoodCondNo.checked = true;
     }
	 else if(n === 6){  
      rpmGoodCondYes.checked = true;  
      rpmGoodCondNo.checked = false;
     }
     else if (n === 7) {   
      rpmGoodCondYes.checked = false;  
      rpmGoodCondNo.checked = true;
     }
	 else if(n === 8){  
      bowAvailableYes.checked = true;  
      bowAvailableNo.checked = false;
     }
     else if (n === 9) {   
      bowAvailableYes.checked = false;  
      bowAvailableNo.checked = true;
     }
	 else if(n === 10){  
      solasConventionYes.checked = true;  
      solasConventionNo.checked = false;
     }
     else if (n === 11) {   
      solasConventionYes.checked = false;  
      solasConventionNo.checked = true;
     }
    }
    </script>
 <div class="content">
    <div class="content_resize_1">
      <div class="mainbar_1">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
		  
		  <?php 
		  $attributes = array('target' => '', 'id' => 'myform');
		  
		  echo form_open(base_url().'index.php/report/departureOfVesselEntry',$attributes);
			$Stylepadding = 'style="padding: 12px 20px;"';
				if(!empty($error_message))
				{
					$Stylepadding = 'style="padding:25px 20px;"';
				}	
				if(isset($captcha_image)){
					$Stylepadding = 'style="padding:62px 20px 93px;"';
				}?>
		<div align="center"><?php echo $msg;?></div>
		</div>
			<table class="tbl">
					<tr align="center">
						<td colspan="10"> <b>CHITTAGONG PORT AUTHORITY</b> </td>
					</tr>
					<tr align="center">
						<td colspan="10"> DEPARTURE REPORT OF VESSEL </BR> AND </td>
					</tr>
					<tr align="center">
						<td colspan="10"> PILOTAGE CERTIFICATE </td>
					</tr>
					<tr align="left">
						<td colspan="2">1. VESSEL NAME</td>
						<td colspan="2"><input type="text" value="<?php echo $rtnVesselDetails_igm[0]['Vessel_Name']; ?>" name="d_vsl_name" style="width: 99%;"/></td>
						<td class="lbl">CALL SIGN</td>
						<td colspan="2"><input type="text" value="<?php echo $rtnVesselDetails_n4[0]['radio_call_sign']; ?>" name="d_cal_sign" style="width: 99%;"/></td>
						<td class="lbl">FLAG</td>
						<td colspan="2"><input type="text" value="<?php echo $rtnVesselDetails_n4[0]['flag']; ?>" name="d_vsl_flag" style="width: 99%;"/></td>
						<input type="hidden" value="<?php echo $rtnVesselDetails_igm[0]['igm_mst_id']; ?>" name="d_igm_mst_id" style="width: 99%;"/>
						<input type="hidden" value="<?php echo $rtnVesselDetails_n4[0]['vvd_gkey']; ?>" name="d_vvd_gkey" style="width: 99%;"/>
					</tr>
					<tr align="left">
						<td colspan="2" class="lbl">2. NAME OF MASTER</td>
						<td colspan="8"><input type="text" value="<?php echo $rtnVesselDetails_igm[0]['Name_of_Master']; ?>" style="width: 99%;" name="d_master_name"/></td>
					</tr>
					<tr align="left">
						<td class="lbl">3. GRT</td>
						<td colspan="2"><input type="text" value="<?php echo $rtnVesselDetails_n4[0]['gross_registered_ton']; ?>" name="d_grt" style="width: 99%;"/></td>
						<td class="lbl">NRT</td>
						<td colspan="2"><input type="text" value="<?php echo $rtnVesselDetails_n4[0]['net_registered_ton']; ?>" name="d_nrt" style="width: 99%;"/></td>
						<td colspan="2" class="lbl">DECK CARGO</td>
						<td colspan="2"><input type="text" value="<?php echo $rtnVesselDetails_igm[0]['Deck_cargo']; ?>" name="d_deck_cargo" style="width: 99%;"/></td>
					</tr>
					<tr align="left">
						<td class="lbl">4. LOA</td>
						<td colspan="3"><input type="text" value="<?php echo $rtnVesselDetails_n4[0]['loa_cm']; ?>" name="d_loa" style="width: 99%;"/></td>
						<td colspan="3" class="lbl">MAX FW DRAUGHT</td>
						<td colspan="3"><input type="text" value="<?php echo $rtnVesselDetails_n4[0]['beam_cm']; ?>" name="d_max_fw" style="width: 99%;"/></td>
					</tr>
					<tr align="left">
						<td colspan="4" class="lbl">5. NAME AND ADDRESS OF OWNERS</td>
						<td colspan="6"><input type="text" name="d_name_addr_owner" style="width: 99%;"/></td>
					</tr>
					<tr align="left">
						<td colspan="2" class="lbl">6. LOCAL AGENT</td>
						<td colspan="2"><input type="text" value="<?php echo $rtnVesselDetails_n4[0]['localagent']; ?>" name="d_loc_agent" style="width: 99%;"/></td> 
						<td colspan="2" class="lbl">LAST PORT</td>
						<td colspan="1"><input type="text" name="lst_prt" style="width: 99%;"/></td>
						<td colspan="2" class="lbl">NEXT PORT</td>
						<td colspan="1"><input type="text" value="<?php echo $rtnVesselDetails_igm[0]['Port_of_Destination']; ?>" name="d_nxt_prt" style="width: 99%;"/></td>
					</tr>
					<tr align="left">
						<td colspan="2" class="lbl">7. NAME OF PILOT</td>
						<td><input type="text" name="d_name_pilot" value="<?php if($chk_igm_id>0) { echo $rtnVesselDetails_depart[0]['pilot_name']; } else { echo ""; } ?>" style="width: 99%;"/></td>
						<td colspan="2">BOARDED AT</td>
						<td><input type="text" name="d_board_at" value="<?php if($chk_igm_id>0) { echo $rtnVesselDetails_depart[0]['pilot_on_board']; } else { echo ""; } ?>" style="width: 99%;"/></td>
						<td class="lbl">LEFT AT</td>
						<td><input type="text" name="d_left_at" value="<?php if($chk_igm_id>0) { echo $rtnVesselDetails_depart[0]['pilot_off_board']; } else { echo ""; } ?>" style="width: 99%;"/></td>
						<td class="lbl">DT</td>
						<td>
							<input type="text" id="left_dt" name="d_left_dt" style="width: 99%;"/>
							<script>
								$(function() {
								 $( "#left_dt" ).datepicker({
								  changeMonth: true,
								  changeYear: true,
								  dateFormat: 'yy-mm-dd', // iso format
								 });
								});
							</script>
						</td>
					</tr>
					<tr align="left">
						<td colspan="2" class="lbl">8. PILOTAGE FROM</td>
						<td colspan="2"><input type="text" name="d_pilotage_from" value="<?php if($chk_igm_id>0) { echo $rtnVesselDetails_depart[0]['pilot_frm']; } else { echo ""; } ?>" style="width: 99%;"/></td>
						<td class="lbl">TO</td>
						<td colspan="2"><input type="text" name="d_pilotage_to" value="<?php if($chk_igm_id>0) { echo $rtnVesselDetails_depart[0]['pilot_to']; } else { echo ""; } ?>" style="width: 99%;"/></td>
						<td class="lbl">DT</td>
						<td colspan="2">
							<input type="text" id="pilotage_dt" name="d_pilotage_dt" style="width: 99%;"/>
							<script>
								$(function() {
								 $( "#pilotage_dt" ).datepicker({
								  changeMonth: true,
								  changeYear: true,
								  dateFormat: 'yy-mm-dd', // iso format
								 });
								});
							</script>
						</td>
					</tr>
					<tr align="left">
						<td colspan="3" class="lbl">9. DATE OF ARRAIVAL IN PORT</td>
						<td colspan="2">
							<input type="text" id="dt_arraival" value="<?php if($chk_igm_id>0) { echo $ata; } else { echo ""; } ?>" name="d_dt_arraival" style="width: 99%;"/>
							<script>
								$(function() {
								 $( "#dt_arraival" ).datepicker({
								  changeMonth: true,
								  changeYear: true,
								  dateFormat: 'yy-mm-dd', // iso format
								 });
								});
							</script>
						</td>
						<td colspan="3" class="lbl">DATE AND HOUR OF BERTHING</td>
						<td colspan="2"><input type="text" name="d_dt_hrs_berth" style="width: 99%;"/></td>
					</tr>
					<tr align="left">
						<td colspan="3" class="lbl">10. DATE OF DEPARTURE</td>
						<td colspan="2">
							<input type="text" id="dt_of_depart" name="d_dt_of_depart" value="<?php if($chk_igm_id>0) { echo $rtnVesselDetails_depart[0]['atd']; } else { echo ""; } ?>" style="width: 99%;"/>
							<script>
								$(function() {
								 $( "#dt_of_depart" ).datepicker({
								  changeMonth: true,
								  changeYear: true,
								  dateFormat: 'yy-mm-dd', // iso format
								 });
								});
							</script>
						</td>
						<td colspan="3" class="lbl">DEP.DRAFT(MAX)</td>
						<td colspan="2"><input type="text" name="d_dept_draft" style="width: 99%;"/></td>
					</tr>
					<tr align="left">
						<td colspan="4" class="lbl">11. TIME OF UNMOORING FROM</td>
						<td colspan="1"><input type="text" name="d_time_unmoor_from" value="<?php if($chk_igm_id>0) { echo $rtnVesselDetails_depart[0]['mooring_frm_time']; } else { echo ""; } ?>" style="width: 99%;"/></td>
						<td class="lbl">TO</td>
						<td colspan="1"><input type="text" name="d_time_unmoor_to" value="<?php if($chk_igm_id>0) { echo $rtnVesselDetails_depart[0]['mooring_to_time']; } else { echo ""; } ?>" style="width: 99%;"/></td>
						<td class="lbl">DT</td>
						<td colspan="2">
							<input type="text" id="time_unmoor_dt" name="d_time_unmoor_dt" style="width: 99%;"/>
							<script>
								$(function() {
								 $( "#time_unmoor_dt" ).datepicker({
								  changeMonth: true,
								  changeYear: true,
								  dateFormat: 'yy-mm-dd', // iso format
								 });
								});
							</script>
						</td>
					</tr>
					<tr align="left">
						<td colspan="2" class="lbl">12. CPA TUG/TUGS(NAME)</td>
						<td><input type="text" name="d_cpa_tug" value="<?php if($chk_igm_id>0) { echo $rtnVesselDetails_depart[0]['tug_name']; } else { echo ""; } ?>" style="width: 99%;"/></td>
						<td colspan="2" class="lbl">ASSISTANCE FROM</td>
						<td><input type="text" name="d_assist_from" value="<?php if($chk_igm_id>0) { echo $rtnVesselDetails_depart[0]['assit_frm']; } else { echo ""; } ?>" style="width: 99%;"/></td>
						<td class="lbl">TO</td>
						<td><input type="text" name="d_assist_to" value="<?php if($chk_igm_id>0) { echo $rtnVesselDetails_depart[0]['assit_to']; } else { echo ""; } ?>" style="width: 99%;"/></td>
						<td class="lbl">DT</td>
						<td >
							<input type="text" id="assist_dt" name="d_assist_dt" style="width: 99%;"/>
							<script>
								$(function() {
								 $( "#assist_dt" ).datepicker({
								  changeMonth: true,
								  changeYear: true,
								  dateFormat: 'yy-mm-dd', // iso format
								 });
								});
							</script>
						</td>
					</tr>
					<tr align="left">
						<td colspan="2" class="lbl">13. PC NO</td>
						<td colspan="3"><input type="text" name="d_pc_no" style="width: 99%;"/></td>
						<td colspan="2" class="lbl">DT</td>
						<td colspan="3">
							<input type="text" id="pc_dt" name="d_pc_dt" style="width: 99%;"/>
							<script>
								$(function() {
								 $( "#pc_dt" ).datepicker({
								  changeMonth: true,
								  changeYear: true,
								  dateFormat: 'yy-mm-dd', // iso format
								 });
								});
							</script>
						</td>
					</tr>
					<tr align="left">
						<td colspan="4" class="lbl">14. TONS OF CARGO ON BOARD</td>
						<td colspan="6"><input type="text" name="d_tons_of_crgo" style="width: 99%;"/></td>
					</tr>
					<tr align="left">
						<td colspan="6" class="lbl">15. MAIN ENGINES IN GOOD WORKING CONDITION?</td>
						<td colspan="1">
							<input type="checkbox" class="radio" id="goodCondYes" name="d_goodCondYes" onclick="checkCond(1)" style="width: 99%;" checked/>
						</td>
						<td>
							YES
						</td>
						<td colspan="1">
							<input type="checkbox" class="radio" id="goodCondNo" name="d_goodCondNo" onclick="checkCond(0)" style="width: 99%;"/>
						</td>
						<td>
							NO
						</td>

					</tr>
					<tr align="left">
						<td colspan="6" class="lbl">16. TWO ANCHORS IN GOOD WORKING CONDITION?</td>
						<td colspan="1">
							<input type="checkbox" class="radio" id="anchorGoodCondYes" name="d_anchorGoodCondYes" onclick="checkCond(2)" style="width: 99%;" checked/>
						</td>
						<td>
							YES
						</td>
						<td colspan="1">
							<input type="checkbox" class="radio" id="anchorGoodCondNo" name="d_anchorGoodCondNo" onclick="checkCond(3)" style="width: 99%;" />
						</td>
						<td>
							NO
						</td>

					</tr>
					<tr align="left">
						<td colspan="6" class="lbl">17. RUDDER INDICATOR IN GOOD WORKING CONDITION?</td>
						<td colspan="1">
							<input type="checkbox" class="radio" id="radarGoodCondYes" name="d_radarGoodCondYes" onclick="checkCond(4)" style="width: 99%;" checked/>
						</td>
						<td>
							YES
						</td>
						<td colspan="1">
							<input type="checkbox" class="radio" id="radarGoodCondNo" name="d_radarGoodCondNo" onclick="checkCond(5)" style="width: 99%;" />
						</td>
						<td>
							NO
						</td>

					</tr>
					<tr align="left">
						<td colspan="6" class="lbl">18. RPM INDICATOR IN GOOD WORKING CONDITION?</td>
						<td colspan="1">
							<input type="checkbox" class="radio" id="rpmGoodCondYes" name="d_rpmGoodCondYes" onclick="checkCond(6)" style="width: 99%;" checked/>
						</td>
						<td>
							YES
						</td>
						<td colspan="1">
							<input type="checkbox" class="radio" id="rpmGoodCondNo" name="d_rpmGoodCondNo" onclick="checkCond(7)" style="width: 99%;"/>
						</td>
						<td>
							NO
						</td>

					</tr>
					<tr align="left">
						<td colspan="6" class="lbl">19. BOW THURSTER AVAILABLE?</td>
						<td colspan="1">
							<input type="checkbox" class="radio" id="bowAvailableYes" name="d_bowAvailableYes" onclick="checkCond(8)" style="width: 99%;" checked/>
						</td>
						<td>
							YES
						</td>
						<td colspan="1">
							<input type="checkbox" class="radio" id="bowAvailableNo" name="d_bowAvailableNo" onclick="checkCond(9)" style="width: 99%;"/>
						</td>
						<td>
							NO
						</td>

					</tr>
					<tr align="left">
						<td colspan="6" class="lbl">20. ARE YOU COMPLYING SOLAS CONVENTION?</td>
						<td colspan="1">
							<input type="checkbox" class="radio" id="solasConventionYes" name="d_solasConventionYes" onclick="checkCond(10)" style="width: 99%;" checked/>
						</td>
						<td>
							YES
						</td>
						<td colspan="1">
							<input type="checkbox" class="radio" id="solasConventionNo" name="d_solasConventionNo" onclick="checkCond(11)" style="width: 99%;" />
						</td>
						<td>
							NO
						</td>

					</tr>
					<tr align="left">
						<td colspan="5" class="lbl">21. NOS. OF GOOD MOORING LINES: FORD</td>
						<td colspan="2"><input type="text" name="d_no_good_mor_line" style="width: 99%;"/></td>
						<td class="lbl">AFT</td>
						<td colspan="2"><input type="text" name="d_aft" style="width: 99%;"/></td>
					</tr>
					<tr align="left">
						<td colspan="4" class="lbl">22. STERN POWER AVAILABLE:</td>
						<td colspan="1"><input type="text" name="d_st_power_avbl" style="width: 99%;"/></td>
						<td colspan="2" class="lbl">IMMEDIATELY</td>
						<td colspan="1"><input type="text" name="d_immediate" style="width: 99%;"/></td>
						<td colspan="2" class="lbl">SECS.LATER</td>						
					</tr>
					<tr align="center">
						<td colspan="5" align="right"> <input class="login_button" id="saveBtn" type="submit" value="Save"/> </td>
						<td colspan="5" align="left"> </td>
					</tr>
			</table>
	<?php echo form_close()?>
       <!-- <p class="pages"><small>Page 1 of 2</small> <span>1</span> <a href="#">2</a> <a href="#">&raquo;</a></p>-->
      </div>
      <div class="sidebar">
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	
  </div>