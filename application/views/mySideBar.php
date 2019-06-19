<style>
.badge1 {
   position:relative;
}
.badge1[data-badge]:after {
   content:attr(data-badge);
   position:absolute;
   top:-5px;
   right:-10px;
   font-size:1.5em;
   background:red;
   color:white;
   width:28px;height:28px;
   text-align:center;
   line-height:28px;
   border-radius:50%;
   box-shadow:0 0 1px #333;
}

.blink_me {
  animation: blinker 2s linear infinite;
  color:red;
  font-weight: bold;
}

@keyframes blinker {  
  50% { opacity: 0; }
}
.blink_me:hover {
    opacity: 1;
    -webkit-animation-name: none;
    /* should be set to 100% opacity as soon as the mouse enters the box; when the mouse exits the box, the original animation should resume. */
}
</style>	
		
		
		<link rel="shortcut icon" href="<?php echo IMG_PATH; ?>icon_minus.png" />
		<link rel="shortcut icon" href="<?php echo IMG_PATH; ?>icon_plus.png" />
		<link rel="shortcut icon" href="<?php echo IMG_PATH; ?>pattern.png" />
		<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>styles_leftbutton.css" />
		<script type="text/javascript" src="<?php echo JS_PATH; ?>script_leftbutton.js"></script>
		
		
 <?php 
	include("dbConection.php");
	include("mydbPConnection.php");
	if($this->session->userdata('Control_Panel')==56) 
	{?>
	 <div class="gadget">
		<h2 class="star">IGM INFORMATION</h2>
		  <ul class="sb_menu">
			<li><a href="<?php echo site_url('report/myVesselList') ?>">Vessel List</a></li>
		  </ul>
	</div>
	<?php 
	}
	else 
	{
	if($this->session->userdata('Control_Panel')==12 and $this->session->userdata('section')==9)	
	{
	?>
	<div class="gadget">
		<div id='cssmenu'>
			<ul>
				<li class='active'><a href='#'><span>CPA PANEL</span></a></li>
				<li class='has-sub'><a href='#'><span>IGM OPERATION</span></a>
					<ul>
						<li><a href="<?php echo site_url('igmViewController/viewIgmGeneral/GM') ?>" target="_BLANK">View IGM General Information</a></li>
						<li><a href="<?php echo site_url('igmViewController/viewIgmGeneral/BB') ?>" target="_BLANK">View IGM Break Bulk Information</a></li>
						<li><a href="<?php echo site_url('igmViewController/myIGMContainer') ?>" target="_BLANK">IGM Container List</a></li>
						<li><a href="<?php echo site_url('igmViewController/checkTheIGM') ?>">Check The IGM</a></li>
						<li><a href="<?php echo site_url('igmViewController/updateManifest') ?>">Convert IGM</a></li>
						<!--li><a href="<?php echo site_url('uploadExcel/convertCopino') ?>">Convert COPINO</a></li-->
						<li><a href="<?php echo site_url('report/myExportCommodityForm') ?>">Convert EXPORT-COMMODITY</a></li>
						<li><a href="<?php echo site_url('igmViewController/checkTheIGM') ?>">Check The IGM</a></li>
						<li><a href="<?php echo site_url('igmViewController/viewIGM') ?>">View IGM</a></li>
						<li><a href="<?php echo site_url('report/convertIgmCertifySection') ?>">Convert Igm to Certify Section</a></li>
						<li><a href="<?php echo site_url('report/onestopCertifySection') ?>">Location \ Certify</a></li>
						<li><a href="<?php echo site_url('report/myRountingPointCodeList') ?>" target="_BLANK">Routing Points</a></li>
						<li><a href="<?php echo site_url('report/myViewBreakBulkList') ?>" target="_BLANK">Break Bulk IGM Info</a></li>
					</ul>
				</li>
				<li class='has-sub'><a href='#'><span>IGM REPORTS</span></a>
					<ul>
						<li><a href="<?php echo site_url('report/myIGMReport') ?>">IGM REPORTS</a></li>
						<li><a href="<?php echo site_url('report/myIGMBBReport') ?>">IGM REPORTS BREAK BULK</a></li>
						<li><a href="<?php echo site_url('report/myIGMFFReport') ?>">IGM SUPLEMENTARY REPORTS</a></li>
						<li><a href="<?php echo site_url('report/myIGMFFReport') ?>">IGM SUPLEMENTARY BREAK BULK REPORTS</a></li>
						<li><a href="<?php echo site_url('report/myICDManifest') ?>">ICD MENIFEST</a></li>
						<li><a href="<?php echo site_url('report/myDGManifest') ?>">DG MENIFEST</a></li>
						<li><a href="<?php echo site_url('report/myLCLManifest') ?>">LCL MENIFEST</a></li>
						<li><a href="<?php echo site_url('report/myFCLManifest') ?>">FCL MENIFEST</a></li>
						<li><a href="<?php echo site_url('report/myDischargeList') ?>">DISCHARGE LIST</a></li>
						<li><a href="<?php echo site_url('report/RequestForPreAdviceReport') ?>">REQUEST FOR PREADVICE CONTAINER LIST</a></li>
						<li><a href="<?php echo site_url('report/ImportContainerSummery') ?>">Summary Of Import Container(MLO,Size,Height) Wise</a></li>
						<li><a href="<?php echo site_url('report/mloDischargeSummery') ?>">MLO DISCHARGE SUMMARY LIST</a></li>
						<li><a href="<?php echo site_url('report/') ?>">FEEDER DISCHARGE SUMMARY LIST</a></li>
						<li><a href="<?php echo site_url('report/OffDockContainerList') ?>">OFFDOCK DESTINATION WISE CONTAINER LIST </a></li>
						<li><a href="<?php echo site_url('report/depotLadenContForm') ?>">DEPOT LADEN CONTAINER</a></li>
						<li><a href="<?php echo site_url('report/mis_assignment_report_search') ?>">MIS ASSIGNMENT REPORT</a></li>				
					</ul>
			   </li>
			   <li class='has-sub'><a href='#'><span>ICD</span></a>
					<ul>
					<li><a href="<?php echo site_url('uploadExcel/uploadIcdExcel') ?>">ICD EXCEL FILE UPLOAD</a></li>
				   <li><a href="<?php echo site_url('uploadExcel/convertIcdFileForm') ?>">ICD EXCEL FILE CONVERTER</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<?php
	}
	?>
			
	<div class="gadget">
		<?php if($this->session->userdata('Control_Panel')!=22 && $this->session->userdata('Control_Panel')==12 && $this->session->userdata('section')!=19 && $this->session->userdata('section')!=9 && $this->session->userdata('login_id')!="cpaops" && $this->session->userdata('Control_Panel')!=28 and $this->session->userdata('Control_Panel')!=57 && $this->session->userdata('Control_Panel')!=61){ ?>
           <div id='cssmenu'>
				<ul>
			   <li class='active'><a href='#'><span>CPA PANEL</span></a></li>
			    <?php  if($this->session->userdata('section')!='scy') { ?>
			   <li class='has-sub'><a href='#'><span>IGM OPERATION</span></a>
				  <ul>
					<li><a href="<?php echo site_url('igmViewController/viewIgmGeneral/GM') ?>" target="_BLANK">View IGM General Information</a></li>
					<li><a href="<?php echo site_url('igmViewController/viewIgmGeneral/BB') ?>" target="_BLANK">View IGM Break Bulk Information</a></li>
					<li><a href="<?php echo site_url('igmViewController/myIGMContainer') ?>" target="_BLANK">IGM Container List</a></li>
					<li><a href="<?php echo site_url('igmViewController/checkTheIGM') ?>">Check The IGM</a></li>
					<li><a href="<?php echo site_url('igmViewController/updateManifest') ?>">Convert IGM</a></li>
					<!--li><a href="<?php echo site_url('uploadExcel/convertCopino') ?>">Convert COPINO</a></li-->
					<li><a href="<?php echo site_url('report/myExportCommodityForm') ?>">Convert EXPORT-COMMODITY</a></li>
					<li><a href="<?php echo site_url('igmViewController/checkTheIGM') ?>">Check The IGM</a></li>
					<li><a href="<?php echo site_url('igmViewController/viewIGM') ?>">View IGM</a></li>
					<li><a href="<?php echo site_url('report/convertIgmCertifySection') ?>">Convert Igm to Certify Section</a></li>
					<li><a href="<?php echo site_url('report/onestopCertifySection') ?>">Location \ Certify</a></li>
					<li><a href="<?php echo site_url('report/myRountingPointCodeList') ?>" target="_BLANK">Routing Points</a></li>
					<li><a href="<?php echo site_url('report/myViewBreakBulkList') ?>" target="_BLANK">Break Bulk IGM Info</a></li>
					
					<?php  
					$lid = $this->session->userdata('login_id');
					//echo $lid;
					if($lid=="sazam" or $lid=="mdibrahim" or $lid=="popy" or $lid=="Shepu" or $lid=="tipai" or $lid=="shopna" or $lid=="norin"  or $lid=="anikcpa" or $lid=="IBRAHIM") { ?>
					 <li><a href="<?php echo site_url('report/myoffDociew') ?>" target="_BLANK">OFFDOCK INFORMATION</a></li>
					 <li><a href="<?php echo site_url('report/commodityInfoView') ?>" target="_BLANK">COMMODITY INFORMATION</a></li>					 
					<!--li><a href="<?php echo site_url('uploadExcel') ?>">EXCEL UPLOAD FOR COPINO</a></li-->
					<?php						
						$str = "select count(distinct rotation) as cnt from ctmsmis.mis_exp_unit_preadv_req where preAddStat=1 and date(last_update)=date(now())";
						$result = mysql_query($str,$con_sparcsn4);
						$row = mysql_fetch_object($result);
						$badge = $row->cnt;		
					?>
					<li class="badge1" data-badge="<?php echo $badge;?>"><a href="<?php echo site_url('uploadExcel/preAdvisedRotList') ?>">Today's Pre-Advised Rotation</a></li>
					<?php mysql_close($con_sparcsn4);?>
					<?php
						include("mydbPConnection.php");
						$str = "select count(id) as cnt from edi_stow_info where file_status=0";
						
						$result = mysql_query($str);
						$row = mysql_fetch_object($result);
						$badge = $row->cnt;
						//echo "TEST : ".$badge;
					?>
					<li class="badge1" data-badge="<?php echo $badge;?>"><a href="<?php echo site_url('uploadExcel/todays_edi_declaration') ?>">Today's EDI Declaration</a></li>
					<?php 
					mysql_close($cchaportdb);
					include("dbConection.php");
					?>
					
					<li><a href="<?php echo site_url('uploadExcel/convertCopino') ?>">Convert COPINO</a></li>
				<?php } ?>
				  </ul>
			   </li>
			   
			   <li class='has-sub'><a href='#'><span>EXPORT REPORTS</span></a>
				  <ul>
					<li><a href="<?php echo site_url('report/viewVesselListStatus') ?>">VESSEL LIST WITH EXPORT APPS LOADING REPORT</a></li>
					<li><a href="<?php echo site_url('report/commentsSearchForVessel') ?>"><span class="blink_me">COMMENTS BY SHIPPING SECTION ON EXPORT VESSEL</span></a></li>
					<li><a href="<?php echo site_url('report/last24HoursERForm') ?>">LAST 24 HOUR'S EIR POSITION</a></li>
					<li><a href="<?php echo site_url('report/workDone24hrsForm') ?>">LAST 24 HRS. CONTAINER HANDLING REPORT</a></li>
					<li><a href="<?php echo site_url('report/myExportImExSummery') ?>">MLO WISE EXPORT SUMMARY</a></li>
					<li><a href="<?php echo site_url('report/mloWiseFinalDischargingExportFormForCPA') ?>">MLO WISE FINAL LOADING EXPORT APPS</a></li>
					<li><a href="<?php echo site_url('report/mloWiseFinalDischargingExportFormForCPAN4') ?>">MLO WISE FINAL LOADING EXPORT</a></li>
					<li><a href="<?php echo site_url('report/pangoanLoadingExportForm') ?>">PANGOAN LOADING EXPORT</a></li>		
					<li><a href="<?php echo site_url('report/assignment_sheet_for_pangaon') ?>">ASSIGNMENT SHEET FOR OUTWARD PANGAON ICT CONTAINER</a></li>					
					 <?php  
					$lid = $this->session->userdata('login_id');
					if($lid=="porikkhit") { ?>
					<li><a href="<?php echo site_url('report/stuffingContainerListForm') ?>">LAST 24 HOURS STUFFING CONTAINER LIST</a></li>
					<li><a href="<?php echo site_url('report/last24hrsOffDockStatementoforAdminForm') ?>">LAST 24 STATEMENT LIST</a></li>		
					<li><a href="<?php echo site_url('uploadExcel/last24hrsStatements') ?>">LAST 24 STATEMENT</a></li>
					<!--li><a href="<?php echo site_url('uploadExcel/last24hrsStatementList') ?>">LAST 24 STATEMENT LIST</a></li-->
					<li><a href="<?php echo site_url('report/stuffingPermissionForm') ?>">STUFFING PERMISSION FORM</a></li>
					<?php } ?>
				  </ul>
			   </li>
			    <li class='has-sub'><a href='#'><span>IMPORT REPORTS</span></a>
				  <ul>
				  	<li><a href="<?php echo site_url('report/assignmentAllReportForm') ?>">ALL ASSAIGNMENT/DELIVERY EMPTY DETAILS</a></li>
					<li><a href="<?php echo site_url('report/yardWiseContainerHandlingDetailsRptForm') ?>">CURRENT YARD LYING CONTAINER REPORT</a></li>
					<li><a href="<?php echo site_url('report/yardWiseContainerHandlingRptForm') ?>">YARD WISE CONTAINER RECEIVE REPORT</a></li>
					<li><a href="<?php echo site_url('report/yardWiseContainerDeliveryRptForm') ?>">YARD WISE CONTAINER DELIVERY REPORT</a></li>
					<li><a href="<?php echo site_url('report/containerPositionEntryForm') ?>">CONTAINER POSITION ENTRY</a></li>
					<li><a href="<?php echo site_url('report/blockWiseRotation') ?>">IMPORT DISCHARGE REPORT BY APPS</a></li>	
					<li><a href="<?php echo site_url('report/offDockRemovalPositionForm') ?>">OFFDOCK REMOVAL CONTAINER</a></li>
					<li><a href="<?php echo site_url('report/countryWiseImportReport') ?>">COUNTRY WISE IMPORT REPORT</a></li>
					<li><a href="<?php echo site_url('report/yearWiseImportReport') ?>">YEAR WISE IMPORT REPORT</a></li>
					<li><a href="<?php echo site_url('report/mloWiseFinalDischargingImportFormForCPA') ?>">MLO WISE FINAL DISCHARGING IMPORT</a></li>
					<li><a href="<?php echo site_url('report/pangoanDischargeForm') ?>">PANGOAN DISCHARGE</a></li>
					<li><a href="<?php echo site_url('report/removal_list_form/overflow') ?>">REMOVAL LIST OF OVERFLOW YARD</a></li>
					<li><a href="<?php echo site_url('report/removal_list_form/all') ?>">LIST OF CTMS ASSIGNMENT</a></li>
				  </ul>
			   </li>
			   
			   <?php if($lid=="devcpa"){ ?>
			   <li class='has-sub'><a href='#'><span>LCL ASSIGNMENT<span></a>
			     <ul>
			    <li><a href="<?php echo site_url('cfsModule')?>">LCL ASSIGNMENT ENTRY FORM</a></li>
				<li><a href="<?php echo site_url('cfsModule/lclAssignmentReportTable')?>">LCL ASSIGNMENT REPORT</a></li>
			     </ul>
			   </li>
			   <?php } ?>

			   <li class='has-sub'><a href='#'><span>IGM REPORTS</span></a>
				  <ul>
				<li><a href="<?php echo site_url('report/myIGMReport') ?>">IGM REPORTS</a></li>
				<li><a href="<?php echo site_url('report/myIGMBBReport') ?>">IGM REPORTS BREAK BULK</a></li>
				<li><a href="<?php echo site_url('report/myIGMFFReport') ?>">IGM SUPLEMENTARY REPORTS</a></li>
				<li><a href="<?php echo site_url('report/myIGMFFReport') ?>">IGM SUPLEMENTARY BREAK BULK REPORTS</a></li>
				<li><a href="<?php echo site_url('report/myICDManifest') ?>">ICD MENIFEST</a></li>
				<li><a href="<?php echo site_url('report/myDGManifest') ?>">DG MENIFEST</a></li>
				<li><a href="<?php echo site_url('report/myLCLManifest') ?>">LCL MENIFEST</a></li>
				<li><a href="<?php echo site_url('report/myFCLManifest') ?>">FCL MENIFEST</a></li>
				<li><a href="<?php echo site_url('report/myDischargeList') ?>">DISCHARGE LIST</a></li>
				<li><a href="<?php echo site_url('report/RequestForPreAdviceReport') ?>">REQUEST FOR PREADVICE CONTAINER LIST</a></li>
				<li><a href="<?php echo site_url('report/ImportContainerSummery') ?>">Summary Of Import Container(MLO,Size,Height) Wise</a></li>
				<li><a href="<?php echo site_url('report/mloDischargeSummery') ?>">MLO DISCHARGE SUMMARY LIST</a></li>
				<li><a href="<?php echo site_url('report/') ?>">FEEDER DISCHARGE SUMMARY LIST</a></li>
				<li><a href="<?php echo site_url('report/OffDockContainerList') ?>">OFFDOCK DESTINATION WISE CONTAINER LIST </a></li>
				<li><a href="<?php echo site_url('report/depotLadenContForm') ?>">DEPOT LADEN CONTAINER</a></li>
				<li><a href="<?php echo site_url('report/mis_assignment_report_search') ?>">MIS ASSIGNMENT REPORT</a></li>
				
				  </ul>
			   </li>
			   <li class='has-sub'><a href='#'><span>REEFER REPORT</span></a>
				  <ul>
				<li><a href="<?php echo site_url('report/myRefferImportContainerDischargeReport') ?>">YARD WISE REEFER IMPORT CONTAINER</a></li>
				<li><a href="<?php echo site_url('report/vesslWiseRefeerContainerList') ?>">VESSEL WISE REEFER CONTAINER LIST </a></li>
				<li><a href="<?php echo site_url('report/myWaterSupplyInVesselsReportForm') ?>">WATER SUPPLY IN VESSELS</a></li>
				<li><a href="<?php echo site_url('report/myContainerHistoryReportForm') ?>">CONTAINER HISTORY REPORT</a></li>
				  </ul>
			   </li>
			   <li class='has-sub'><a href='#'><span>MIS REPORT</span></a>
				  <ul>
				<li><a href="<?php echo site_url('misReport/A23_1Form') ?>">Performance Container Vessels Last 24hrs (A23.1)</a></li>
				<li><a href="<?php echo site_url('report/garmentsContInfoForm') ?>">Container Information (Garments Item) by Rotation</a></li>
				<li><a href="<?php echo site_url('report/searchGarmentsItemByRotationForm') ?>">Container Information by Item & Rotation</a></li>
				<li><a href="<?php echo site_url('report/last24HrPositionForm') ?>">LAST 24 HOURS POSITION</a></li>

				
				  </ul>
			   </li>
				
			   <li class='has-sub'><a href='#'><span>EQUIPMENT</span></a>
				  <ul>
					<li><a href="<?php echo site_url('report/myReportHHTReCord') ?>" target="_BLANK">YARD WISE ASSIGNED EQUIPMENT LIST</a></li>
					<li><a href="<?php echo site_url('report/monthlyYardWiseContainerHandling') ?>">YARD WISE TOTAL CONTAINER HANDLING</a></li>
					<li><a href="<?php echo site_url('uploadExcel/blockWiseEquipmentList') ?>">Container Handling Equipment Assign</a></li>
					<!--li><a href="<?php echo site_url('uploadExcel/equipmentDemandList') ?>">Container Handling Equipment Demand</a></li--> 
					<li><a href="<?php echo site_url('uploadExcel/equipmentHandlingDemandForm') ?>">Container Handling Equipment Demand</a></li>
					<li><a href="<?php echo site_url('uploadExcel/updateEquipmentList') ?>">Update Equipment Information</a></li>
					<li><a href="<?php echo site_url('report/dateWiseEqipAssignForm') ?>">Block Wise Equipment Booking Lists</a></li>
					<li><a href="<?php echo site_url('report/containerHandlingRptForm') ?>">CONTAINER HANDLING REPORT</a></li>
					<li><a href="<?php echo site_url('report/containerHandlingRptMonthlyForm') ?>">MONTHLY CONTAINER HANDLING REPORT</a></li>
					<li><a href="<?php echo site_url('report/plannedRptForm') ?>">CONTAINER JOB DONE VESSELWISE</a></li>
					<li><a href="<?php echo site_url('report/equipmentEntryForm') ?>">EQUIPMENT ENTRY FORM</a></li>
					<li><a href="<?php echo site_url('report/mis_equipment_cur_stat_rpt') ?>" target="_BLANK">EQUIPMENT CURRENT STATUS</a></li>
					<li><a href="<?php echo site_url('misReport/mis_equipment_indent') ?>">EQUIPMENT INDENT</a></li>
					<li><a href="<?php echo site_url('misReport/mis_equipment_indent_list') ?>">EQUIPMENT INDENT LIST</a></li>				
					<li><a href="<?php echo site_url('misReport/mis_equipment_indent_report') ?>">EQUIPMENT INDENT REPORT</a></li>
					<li><a href="<?php echo site_url('misReport/equipmentUnstuffing') ?>">EQUIPMENT UNSTUFFING</a></li>
					<li><a href="<?php echo site_url('misReport/equipmentUnstuffingList') ?>">EQUIPMENT UNSTUFFING LIST</a></li>
					<li><a href="<?php echo site_url('report/cargoHandlingEquipmentPositionEntry') ?>">CARGO HANDLING EQUIPMENT POSITION</a></li>
					
				 </ul>
			   </li>
				<!--li class='has-sub'><a href='#'><span>HEAD DELIVERY</span></a>
					<ul>
						<li><a href="<?php echo site_url('report/head_delivery') ?>">HEAD DELIVERY DETAIL ENTRY</a></li>
						<li><a href="<?php echo site_url('report/headDeliveryForm') ?>">HEAD DELIVERY REPORT</a></li>
					</ul>
				</li-->
				<li class='has-sub'><a href='#'><span>HEAD DELIVERY</span></a>
					<ul>
						<li><a href="<?php echo site_url('report/xml_conversion') ?>">BILL OF ENTRY LIST</a></li>
						<li><a href="<?php echo site_url('report/date_wise_be_report') ?>">DATE WISE Bill of Entry REPORT</a></li>
						<li><a href="<?php echo site_url('report/head_delivery') ?>">CONTAINER SEARCH & TRUCK ENTRY</a></li>	
					</ul>
				</li>
			    <?php } ?>
			   <?php if($this->session->userdata('section')=='scy') { ?>
			    <li class='has-sub'><a href='#'><span>SCY CONTAINER OPERATION</span></a>
				  <ul>
					<li><a href="<?php echo site_url('report/assignmentAllReportForm') ?>">ALL ASSAIGNMENT/DELIVERY EMPTY DETAILS</a></li>
					<li><a href="<?php echo site_url('report/containerOperationYardLyingList') ?>" target="_blank">SCY YARD LYING CONTAINER</a></li>
					<li><a href="<?php echo site_url('report/containerPositionEntryForm') ?>">CONTAINER OPERATION</a></li>
					<li><a href="<?php echo site_url('report/containerOperationReportForm') ?>">Container OPERATION REPORT</a></li>
				  </ul>
			   </li>
			 <?php } ?>	

			 <?php if(strtoupper($lid)=="NORIN" || strtoupper($lid)=="UHABIBA" || strtoupper($lid)=="SHAMMI") { ?>
			    <li class='has-sub'><a href='#'><span>ICD</span></a>
					<ul>
					<li><a href="<?php echo site_url('uploadExcel/uploadIcdExcel') ?>">ICD EXCEL FILE UPLOAD</a></li>
				   <li><a href="<?php echo site_url('uploadExcel/convertIcdFileForm') ?>">ICD EXCEL FILE CONVERTER</a></li>
					</ul>
				</li>
			 <?php } ?>
			 <?php 
			   if($lid!="CPACS1")
			   {
			   ?>
			   <li class='has-sub'><a href='#'><span>ACCOUNT SETTING</span></a>
				  <ul>
					<li><a href="<?php echo site_url('login/myPasswordChange') ?>">PASSWORD CHANGE</a></li>
				  </ul>
			   </li>
			   <?php
			   }
			   ?>
			   <!--li class='has-sub'><a href='#'><span>ASSIGMENT(LCL)REPORTS</span></a>
				  <ul>
				<li><a href="<?php echo site_url('report/myBirthIGMList') ?>">VIEW BERTH OPERATOR REPORT</a></li>
				  </ul>
			   </li-->
			</ul>
			</div>
		<?php } ?>
		<div class="clr"></div>
		<ul class="sb_menu">
			
		   <?php if($this->session->userdata('Control_Panel')==12 && $this->session->userdata('login_id')!="cpaops") { ?>
			
          <!--  <li><a href="<?php echo site_url('igmViewController/viewImporterList/-') ?>">View Importer List</a></li>
            <li><a href="<?php echo site_url('igmViewController/viewExporterList/-') ?>">View Exporter List</a></li>-->
            <!--<li><a href="<?php echo site_url('igmViewController/myDBDelivery') ?>">Delivery Dash Board Import</a></li>-->
			<?php } ?>
			
		</ul>  
        
</div>

<div class="gadget">
	
		   <ul class="sb_menu">
		   <?php if($this->session->userdata('login_id')=="cpaops") { ?>
				<li><a href="<?php echo site_url('igmViewController/viewIgmGeneral/GM') ?>" target="_BLANK">View IGM General Information</a></li>
				<li><a href="<?php echo site_url('igmViewController/viewIgmGeneral/BB') ?>" target="_BLANK">View IGM Break Bulk Information</a></li>
				<li><a href="<?php echo site_url('igmViewController/myIGMContainer') ?>" target="_BLANK">IGM Container List</a></li>
				<li><a href="<?php echo site_url('igmViewController/checkTheIGM') ?>">Check The IGM</a></li>
				<li><a href="<?php echo site_url('igmViewController/viewIGM') ?>">View IGM</a></li>
						
				<li><a href="<?php echo site_url('report/IgmReportbyDescription') ?>">Report by Description of Goods</a></li>
				<li><a href="<?php echo site_url('report/IgmReportbyImporter') ?>">Report by Importer Name</a></li>
				<li><a href="<?php echo site_url('report/IgmReportbyContainer') ?>">Report by Container</a></li>
				<li><a href="<?php echo site_url('report/IgmReportbyBL') ?>">Report by BL No</a></li>
			<?php } ?>
			 </ul>
		  
        </div>
		
		<div class="clr"></div>
		<?php } ?>
		
			<!--Berth Panel List Start-->
		
		
		<?php 
			if($this->session->userdata('Control_Panel')==30 && $this->session->userdata('Control_Panel')!=22 and $this->session->userdata('Control_Panel')!=57 ) 
			{ 
				// $org_id = $this->session->userdata('org_id');
				// $loginUsr = $this->session->userdata('login_id');
				// $strVVD = "select vvd_gkey as rtnValue from ctmsmis.mis_exp_vvd where brth_org_id='$org_id' and ucase(comments) !='OK'";
				// $resultVVD = mysql_query($strVVD,$con_sparcsn4);
				// $rowVVD = mysql_fetch_object($resultVVD);
				// $numVVD = mysql_num_rows($resultVVD);
				// $vvd = $rowVVD->rtnValue;
				// $expST = 0;
				// $strRot = "";
				// if($numVVD>0)
				// {
					// $strBlockRot = "select ib_vyg as rtnValue from ctmsmis.mis_exp_vvd
					// inner join sparcsn4.vsl_vessel_visit_details on sparcsn4.vsl_vessel_visit_details.vvd_gkey=ctmsmis.mis_exp_vvd.vvd_gkey
					// where brth_org_id='$org_id' and ucase(comments) !='OK'";
					// $resBlockRot = mysql_query($strBlockRot,$con_sparcsn4);
					// while($rowBlockRot=mysql_fetch_object($resBlockRot))
					// {
						// $strRot .= $rowBlockRot->rtnValue.", ";
					// }
					// $strBerth = "SELECT IFNULL(flex_string03,flex_string02) AS rtnValue
					// FROM sparcsn4.vsl_vessel_visit_details WHERE vvd_gkey='$vvd'";
					// $resultBerth = mysql_query($strBerth,$con_sparcsn4);
					// $rowBerth = mysql_fetch_object($resultBerth);
					// $berthOp = $rowBerth->rtnValue;
					
					// $strLogin = "SELECT login_id FROM cchaportdb.users WHERE u_name LIKE '%$berthOp%' AND org_Type_id=30";
					// $resultLogin = mysql_query($strLogin,$con_cchaportdb);
					// //print_r($loginList);
					// $arr = array();
					// while($rowLogin = mysql_fetch_object($resultLogin))
					// {				
						// array_push($arr,$rowLogin->login_id);
					// }
					// //print_r($arr);
					// //$expST = 1;
					// if(in_array($loginUsr,$arr))
						// $expST = 0;
					// else
						// $expST = 1;
				// }
				// else
				// {
					// $expST = 1;
				// }
				//echo $expST;
		?>
			<div id='cssmenu'>
				<ul>
				<li class='active'><a href='#'><span>BERTH OPERATOR</span></a></li>
				<?php 
				$lid = $this->session->userdata('login_id');
				//echo $lid;
				if($lid =='devberth' or $lid =='SAIFBO') { ?>
				<li class='has-sub'><a href='#'><span>SPECIAL REPORT</span></a>
					<ul>
						<li><a href="<?php echo site_url('report/reportSpecial') ?>">FEEDER DISCHARGE SUMMARY</a></li>
						
					</ul>
				</li>
				 <?php } ?>
				<li class='has-sub'><a href='#'><span>IGM OPERATION</span></a>
					<ul>
						<?php// if($expST==1){?>
						<li><a href="<?php echo site_url('igmViewController/viewIgmGeneral/GM') ?>" target="_BLANK">View IGM General Information</a></li>
						<li><a href="<?php echo site_url('igmViewController/viewIgmGeneral/BB') ?>" target="_BLANK">View IGM Break Bulk Information</a></li>
						
						<?php //} else {?>
						<!--li><b><font color="red">You did not complete your previous export vessel Rotaton <?php echo $strRot;?>. To open link, Please contact with Shipping section, TM Building and CTMS help desk.</font></b></li-->
						<?php //}?>
						
						<?php if($lid =='devberth' or $lid =='SAIFBO') { mysql_close($con_sparcsn4);?>
						<li><a href="<?php echo site_url('igmViewController/updateManifest') ?>">Convert IGM</a></li>
						<?php
							include("mydbPConnection.php");
							$str = "select count(id) as cnt from edi_stow_info where file_status=0";
							
							$result = mysql_query($str);
							$row = mysql_fetch_object($result);
							$badge = $row->cnt;
							//echo "TEST : ".$badge;
						?>
						<?php 
						mysql_close($cchaportdb);
						include("dbConection.php");
						?>
						<li class="badge1" data-badge="<?php echo $badge;?>"><a href="<?php echo site_url('uploadExcel/todays_edi_declaration') ?>">Today's EDI Declaration</a></li>
						<?php } ?>
					</ul>
				</li>
				 
				<li class='has-sub'><a href='#'><span>IMPORT REPORTS</span></a>
					<ul>
						<?php //if($expST==1){?>
						<li><a href="<?php echo site_url('report/containerEventHistory') ?>">CONTAINER EVENT HISTORY</a></li>
						<li><a href="<?php echo site_url('report/myBirthIGMList') ?>">VIEW BERTH OPERATOR REPORT</a></li>
						<li><a href="<?php echo site_url('report/myEquipmentHandlingHistory') ?>">EQUIPMENT HANDLING PERFORMANCE(RTG)</a></li>
						<li><a href="<?php echo site_url('report/myEquipmentLoginLogout') ?>">EQUIPMENT HANDLING(RTG LOGIN/LOGOUT)</a></li>
						<li><a href="<?php echo site_url('report/myImportContainerLoadingReportForm') ?>">IMPORT CONTAINER DISCHARGE DETAILS(EXCEL LAST 24 HOURS)</a></li>
						<li><a href="<?php echo site_url('report/myImportContainerDischargeReportlast24hours') ?>">IMPORT CONTAINER DISCHARGE REPORT SUMMARY( LAST 24 HOURS)</a></li>
						<!--li><a href="<?php echo site_url('report/myImportContainerDischargeReport') ?>">IMPORT CONTAINER DISCHARGE REPORT( BALANCE AND DISCHARGE)</a></li-->
						
						<li><a href="<?php echo site_url('report/myImportSummery') ?>">MLO WISE IMPORT SUMMARY(BERTH OPERATOR)</a></li>
						<li><a href="<?php echo site_url('report/assignmentAllReportForm') ?>">ALL ASSAIGNMENT/DELIVERY EMPTY DETAILS</a></li>				
						<li><a href="<?php echo site_url('report/myImportContainerDischargeReport') ?>">IMPORT CONTAINER DISCHARGE AND BALANCE REPORT</a></li>
						<!--li><a href="<?php echo site_url('report/myRequstEmtyContainerReport') ?>">ASSAIGNMENT/DELIVERY EMPTY DETAILS</a></li>
						<li><a href="<?php echo site_url('report/yardWiseEmtyContainerReport') ?>">YARD WISE ASSAIGNMENT/DELIVERY EMPTY DETAILS</a></li>
						<li><a href="<?php echo site_url('report/myRequstAssignmentEmtyContainerReport') ?>">ASSAIGNMENT/DELIVERY EMPTY SUMMARY </a></li-->
						
						<li><a href="<?php echo site_url('report/OffDockContainerList') ?>">OFFDOCK DESTINATION WISE CONTAINER LIST </a></li>
						<li><a href="<?php echo site_url('report/mloDischargeSummery') ?>">MLO DISCHARGE SUMMARY LIST</a></li>
						<li><a href="<?php echo site_url('report/') ?>">FEEDER DISCHARGE SUMMARY LIST</a></li>
						<li><a href="<?php echo site_url('report/myBlockedContainerAllView') ?>" target="_blank">BLOCKED CONTAINER REPORT</a></li>
						<li><a href="<?php echo site_url('uploadExcel/impBayView') ?>"><span class="blink_me">IMPORT CONTAINER BAY VIEW</span></a></li>
						<li><a href="<?php echo site_url('report/containerDischargeAppsForm') ?>">CONTAINER DISCHARGE(APPS)</a></li>
						<li><a href="<?php echo site_url('report/removal_list_form/overflow') ?>">REMOVAL LIST OF OVERFLOW YARD</a></li>
						<?php //} else {?>
						<!--li><b><font color="red">You did not complete your previous export vessel Rotaton <?php echo $strRot;?>. To open link, Please contact with Shipping section and CTMS help desk.</font></b></li-->
						<?php// }?>
					</ul>
			   </li>
			   <li class='has-sub'><a href='#'><span>HANDLING REPORTS</span></a>
					<ul>
						<li><a href="<?php echo site_url('report/workDone24hrsForm') ?>">LAST 24 HRS. CONTAINER HANDLING REPORT</a></li>
					</ul>
			   </li>
			   <li class='has-sub'><a href='#'><span>EXPORT REPORTS</span></a>
					<ul>
						<li><a href="<?php echo site_url('report/viewVesselListStatus') ?>">VESSEL LIST WITH STATUS</a></li>
						<li><a href="<?php echo site_url('report/loadedContainerList') ?>">MLO WISE LOADED CONTAINER LIST </a></li>
						<li><a href="<?php echo site_url('report/mloWisePreadviceloadedContainerList') ?>">MLO WISE PREADVICE LOADED CONTAINER LIST </a></li>
						<li><a href="<?php echo site_url('report/dateAndRoationWisePreAdviseCont') ?>">DATE AND ROTATION WISE PRE ADVISED CONTAINER </a></li>
						<li><a href="<?php echo site_url('report/destinationloadedContainerList') ?>">DESTINATION WISE MLO LOADED CONTAINER LIST </a></li>
						<li><a href="<?php echo site_url('report/ExportContainerTobeLoadingReport') ?>">EXPORT  CONTAINER TO BE LOADED LIST</a></li>
						<li><a href="<?php echo site_url('report/myExportContainerLoadingReportForm') ?>">EXPORT CONTAINER LOADING(EXCEL)</a></li>
						<li><a href="<?php echo site_url('report/myExportContainerLoadingReport') ?>">LOADED CONTAINER LIST</a></li>						
						<li><a href="<?php echo site_url('report/myExportExcelUploadSampleForm') ?>">EXPORT EXCEL UPLOAD SAMPLE (WITH LOADED DATA)</a></li>
						<li><a href="<?php echo site_url('uploadExcel/exportExcelUpload') ?>">UPLOAD EXPORT CONTAINER (EXCEL FILE)</a></li>
						<li><a href="<?php echo site_url('report/myExportExcelUploadSample') ?>">MLO WISE EXCEL UPLOADED REPORT</a></li>
						<li><a href="<?php echo site_url('report/commentsSearchForVessel') ?>">COMMENTS BY SHIPPING SECTION ON EXPORT VESSEL</a></li>
						<li><a href="<?php echo site_url('report/loadedFreightKindContainerList') ?>">LOADED CONTAINER LIST(LOAD & EMPTY)</a></li>
						<li><a href="<?php echo site_url('report/myExportImExSummery') ?>">MLO WISE EXPORT SUMMARY</a></li>
						<li><a href="<?php echo site_url('report/berthOperatorExportContainerHandlingReport') ?>">ROTATION WISE EXPORT CONTAINER</a></li>
						<li><a href="<?php echo site_url('report/myExportContainerNotFoundReport') ?>">EXPORT CONTAINER NOT FOUND REPORT</a></li>
						<li><a href="<?php echo site_url('report/myRotationWiseContInfoForm') ?>">ROTATIN WISE CONTAINER INFORMATION</a></li>
						<li><a href="<?php echo site_url('report/myExportContainerBlockReport') ?>">EXPORT CONTAINER BLOCK REPORT</a></li>
						<li><a href="<?php echo site_url('report/exportCopinoView') ?>">EXPORT COPINO</a></li>
						<?php $path= 'http://'.$_SERVER['SERVER_ADDR'].'/myportpanel/resources/download/';?>
						
						<!--li><a href="<?php echo site_url('uploadExcel') ?>">EXCEL UPLOAD FOR COPINO</a></li-->
						<li><a href="<?php echo site_url('uploadExcel/bayView') ?>">EXPORT CONTAINER BAY VIEW</a></li>
						<li><a href="<?php echo site_url('report/blankBayForm') ?>">EXPORT BLANK BAY VIEW</a></li>
						<?php 
							//include("dbConection.php");
							$appQry="SELECT  app_name,version_code,REPLACE(version_name,'.','_') as version_name FROM ctmsmis.mis_exp_app_version ORDER BY id desc limit 1";
							$rtnAppQry= mysql_query($appQry,$con_sparcsn4);
							$row=mysql_fetch_object($rtnAppQry);
						?>
						<!--li><a href="<?php echo $path.'export_loading_app.apk';?>"><font color="blue" size="2"><b>EXPORT LOADING APP</b></font></a></li-->
						<li><a href="<?php echo $path.$row->app_name."V".$row->version_name.".apk";?>"><font color="blue" size="2"><b>EXPORT LOADING APP</b></font></a></li>
						
						<li><a href="<?php echo site_url('report/podListView') ?>" >POD LIST</a></li>
						<li><a href="<?php echo site_url('report/isoCodeListView') ?>" >ISO CODE LIST</a></li>
						<li><a href="<?php echo site_url('report/yardListView') ?>" >YARD LIST</a></li>						
					</ul>
			   </li>
			   <?php  
					$lid = $this->session->userdata('login_id');
					if($lid=="saif")
					{
				?>
					<li class='has-sub'><a href='#'><span>PANGOAN</span></a>
					  <ul>
						<li><a href="<?php echo site_url('uploadExcel/pangoanContUpload') ?>">EXCEL UPLOAD FOR PANGOAN</a></li>
						<li><a href="<?php echo site_url('uploadExcel/convertPanContForm') ?>">CONVERT PANGOAN CONTAINERS</a></li>
					  </ul>
				   </li>
			   <?php  
					}
				?>
				
				<?php  
					//$lid = $this->session->userdata('login_id');
					if($lid=="devberth" or $lid=="MHCLBOO")
					{				?>
					<li class='has-sub'><a href='#'><span>MH CHOWDHURY REPORT</span></a>
						<ul>							
							<li><a href="<?php echo site_url('report/contDetailInfoByRotWithXlsDownloadForm') ?>">CONTAINER DETAILS BY ROTATION HTML AND EXCEL VIEW</a></li>
							<li><a href="<?php echo site_url('report/contListAllByRotationForm') ?>">CONTAINER LIST (ALL)</a></li>
							<li><a href="<?php echo site_url('report/contListDischargeByRotationForm') ?>">CONTAINER LIST (DISCHARGE)</a></li>
							<li><a href="<?php echo site_url('report/contListAssignmentByRotationForm') ?>">CONTAINER LIST (ASSIGNMENT)</a></li>
							<li><a href="<?php echo site_url('report/contListOffDockByRotationForm') ?>">CONTAINER LIST (OFF-DOCK DELIVERY)</a></li>
							<li><a href="<?php echo site_url('report/contListReferByRotationForm') ?>">CONTAINER LIST (REEFER)</a></li>
							<li><a href="<?php echo site_url('report/contListEmptyGateOutByRotationForm') ?>">CONTAINER LIST (EMPTY GATE OUT)</a></li>
							<li><a href="<?php echo site_url('report/contListStripingByRotationForm') ?>">CONTAINER LIST (STRIPPING)</a></li>
							<li><a href="<?php echo site_url('report/exportContListAllByRotationForm') ?>">EXPORT CONTAINER (ALL)</a></li>
						</ul>
				   </li>
			   <?php  
					}
				?>
				<!--li class='has-sub'><a href='#'><span>MH CHOWDHURY EXPORT</span></a>
						<ul>
							<li><a href="<?php echo site_url('report/exportContListDownload') ?>">CONTAINER EXPORT DOWNLOAD</a></li>
							<li><a href="<?php echo site_url('report/exportContListAllByRotationForm') ?>">CONTAINER EXPORT (ALL)</a></li>
						</ul>
				   </li-->
			   <li class='has-sub'><a href='#'><span>ACCOUNT SETTING</span></a>
				  <ul>
					<li><a href="<?php echo site_url('login/myPasswordChange') ?>">PASSWORD CHANGE</a></li>
				  </ul>
			   </li>
			   <!--li class='has-sub'><a href='#'><span>ASSIGMENT(LCL)REPORTS</span></a>
				  <ul>
				<li><a href="<?php echo site_url('report/myBirthIGMList') ?>">VIEW BERTH OPERATOR REPORT</a></li>
				  </ul>
			   </li-->
			</ul>
			</div>
			
			<?php } ?>
			<!--Berth Panel List End-->
				<!--ADMIN PANEL START-->
			
		<?php 
			$ipaddr = $_SERVER['REMOTE_ADDR'];
			//$hostaddr = $_SERVER['REMOTE_ADMIN'];
			//echo $ipaddr." ".$hostaddr;
			if($this->session->userdata('Control_Panel')==28){
		?>
		<div class="gadget">
		<div id='cssmenu'>
				<ul>
					<li class='active'><a href='#'><span>ADMIN PANEL</span></a></li>
					<li class='has-sub'><a href='#'><span>VESSEL LAYOUT</span></a>			   
						<ul>
							<li><a href="<?php echo site_url('report/vslLayout') ?>">NEW VESSEL LAYOUT</a></li>
							<li><a href="<?php echo site_url('report/deleteWrongBay') ?>">DELETE WRONG BAY</a></li>
							<li><a href="<?php echo site_url('report/updateVslForExpCont') ?>">UPDATE VESSEL FOR EXPORT CONTAINERS</a></li>
							<li><a href="<?php echo site_url('report/updateVisitForPctCont') ?>">UPDATE VISIT FOR PANGOAN CONTAINERS</a></li>
						</ul>
					</li>
					<li class='has-sub'><a href='#'><span>IGM OPERATION</span></a>
			   
					<ul>
						<li><a href="<?php echo site_url('igmViewController/viewIgmGeneral/GM') ?>" target="_BLANK">View IGM General Information</a></li>
						<li><a href="<?php echo site_url('igmViewController/viewIgmGeneral/BB') ?>" target="_BLANK">View IGM Break Bulk Information</a></li>
						<li><a href="<?php echo site_url('igmViewController/myIGMContainer') ?>" target="_BLANK">IGM Container List</a></li>
						<li><a href="<?php echo site_url('igmViewController/checkTheIGM') ?>">Check The IGM</a></li>
						<li><a href="<?php echo site_url('igmViewController/updateManifest') ?>">Convert IGM</a></li>
						<!--li><a href="<?php echo site_url('uploadExcel/convertCopino') ?>">Convert COPINO</a></li-->
						<li><a href="<?php echo site_url('report/myExportCommodityForm') ?>">Convert EXPORT-COMMODITY</a></li>
						<li><a href="<?php echo site_url('igmViewController/checkTheIGM') ?>">Check The IGM</a></li>
						<li><a href="<?php echo site_url('igmViewController/viewIGM') ?>">View IGM</a></li>
						<li><a href="<?php echo site_url('report/convertIgmCertifySection') ?>">Convert Igm to Certify Section</a></li>
						<li><a href="<?php echo site_url('report/onestopCertifySection') ?>">Location \ Certify</a></li>
						<li><a href="<?php echo site_url('report/myRountingPointCodeList') ?>" target="_BLANK">Routing Points</a></li>
						<li><a href="<?php echo site_url('report/myViewBreakBulkList') ?>" target="_BLANK">Break Bulk IGM Info</a></li>
						<li><a href="<?php echo site_url('report/deleteIGMInfo') ?>">DELETE IGM INFORMATION</a></li>
						<li><a href="<?php echo site_url('igmViewController/igmInfoProcessForm') ?>">IGM INFORMATION ENTRY</a></li>
					</ul>
				</li>
				<li class='has-sub'><a href='#'><span>IGM REPORTS</span></a>
					<ul>
						<li><a href="<?php echo site_url('report/myIGMReport') ?>">IGM REPORTS</a></li>
						<li><a href="<?php echo site_url('report/myIGMBBReport') ?>">IGM REPORTS BREAK BULK</a></li>
						<li><a href="<?php echo site_url('report/myIGMFFReport') ?>">IGM SUPLEMENTARY REPORTS</a></li>
						<li><a href="<?php echo site_url('report/myIGMFFReport') ?>">IGM SUPLEMENTARY BREAK BULK REPORTS</a></li>
						<li><a href="<?php echo site_url('report/myICDManifest') ?>">ICD MENIFEST</a></li>
						<li><a href="<?php echo site_url('report/myDGManifest') ?>">DG MENIFEST</a></li>
						<li><a href="<?php echo site_url('report/myLCLManifest') ?>">LCL MENIFEST</a></li>
						<li><a href="<?php echo site_url('report/myFCLManifest') ?>">FCL MENIFEST</a></li>
						<li><a href="<?php echo site_url('report/myDischargeList') ?>">DISCHARGE LIST</a></li>
						<li><a href="<?php echo site_url('report/RequestForPreAdviceReport') ?>">REQUEST FOR PREADVICE CONTAINER LIST</a></li>
						<li><a href="<?php echo site_url('report/ImportContainerSummery') ?>">Summary Of Import Container(MLO,Size,Height) Wise</a></li>
						<li><a href="<?php echo site_url('report/mloDischargeSummery') ?>">MLO DISCHARGE SUMMARY LIST</a></li>
						<li><a href="<?php echo site_url('report/') ?>">FEEDER DISCHARGE SUMMARY LIST</a></li>
						<li><a href="<?php echo site_url('report/OffDockContainerList') ?>">OFFDOCK DESTINATION WISE CONTAINER LIST </a></li>
						<li><a href="<?php echo site_url('report/depotLadenContForm') ?>">DEPOT LADEN CONTAINER</a></li>
					</ul>
				</li>
				<li class='has-sub'><a href='#'><span>REPORT</span></a>
					<ul>
						<li><a href="<?php echo site_url('report/assignmentAllReportForm') ?>">ALL ASSAIGNMENT/DELIVERY EMPTY DETAILS</a></li>
						<li><a href="<?php echo site_url('report/searchIGMByContainer') ?>">SEARCH IGM CONTAINER</a></li>
						<li><a href="<?php echo site_url('report/myoffDociew') ?>" target="_BLANK">OFFDOCK INFORMATION</a></li>
						<li><a href="<?php echo site_url('report/myoffDocEntryForm')?>">OFFDOCK INFORMATION ENTRY FORM</a></li>
						<li><a href="<?php echo site_url('report/commodityInfoView') ?>" target="_BLANK">COMMODITY INFORMATION</a></li>
						<li><a href="<?php echo site_url('report/myExportContainerLoadingReport') ?>">LOADED CONTAINER LIST</a></li>
						<li><a href="<?php echo site_url('report/vesselEventHistory') ?>">VESSEL EVENT HISTORY</a></li>
						<li><a href="<?php echo site_url('report/containerEventHistory') ?>">CONTAINER EVENT HISTORY</a></li>
						<li><a href="<?php echo site_url('report/depotLadenContForm') ?>">DEPOT LADEN CONTAINER</a></li>
						<li><a href="<?php echo site_url('report/showProcessList') ?>">SYSTEM STATUS</a></li>
						<li><a href="<?php echo site_url('report/containerDischargeAppsForm') ?>">CONTAINER DISCHARGE(APPS)</a></li>
						<li><a href="<?php echo site_url('report/containerSearchByRotationAppsForm') ?>">CONTAINER SEARCH FOR APPS</a></li>
						
						<li><a href="<?php echo site_url('report/offDockRemovalPositionForm') ?>">OFFDOCK REMOVAL POSITION</a></li>
					    <!--  <li><a href="<?php echo site_url('igmViewController/viewImporterList/-') ?>">View Importer List</a></li>
						<li><a href="<?php echo site_url('igmViewController/viewExporterList/-') ?>">View Exporter List</a></li>-->
						<!--<li><a href="<?php echo site_url('igmViewController/myDBDelivery') ?>">Delivery Dash Board Import</a></li>-->
						<li><a href="<?php echo site_url('report/stuffingContainerListForm') ?>">LAST 24 HOURS STUFFING CONTAINER LIST</a></li>
						<li><a href="<?php echo site_url('report/last24hrsOffDockStatementoforAdminForm') ?>">LAST 24 STATEMENT LIST</a></li>		
						<li><a href="<?php echo site_url('report/barcodeTestForm') ?>">PRINT BARCODE</a></li>
						<li><a href="<?php echo site_url('uploadExcel/last24hrsStatements') ?>">LAST 24 STATEMENT</a></li>
						<!--li><a href="<?php echo site_url('uploadExcel/last24hrsStatementList') ?>">LAST 24 STATEMENT LIST</a></li-->
						<li><a href="<?php echo site_url('report/stuffingPermissionForm') ?>">STUFFING PERMISSION FORM</a></li>
						<li><a href="<?php echo site_url('report/last24HoursERForm') ?>">LAST 24 HOUR'S EIR POSITION</a></li>
						<li><a href="<?php echo BASE_PATH.'resources/goods_vessel_tariff/CPA-Tariff-ilovepdf-compressed.pdf' ?>" target="blank">TARIFF ON GOODS, VESSEL ETC.</a></li>
						<li><a href="<?php echo site_url('report/vesselBillList/1') ?>">VESSEL BILL LIST</a></li>
						<li><a href="<?php echo site_url('report/checkVatStatusForm') ?>">VAT STATUS</a></li>
						<li><a href="<?php echo site_url('report/slaveProcess/') ?>">SLAVE PROCESS</a></li>
						<li><a href="<?php echo site_url('report/exportContainerLoadingList') ?>" target="_blank" >EXPORT CONTAINER LOADING LIST</a></li>
						<li><a href="<?php echo site_url('report/myExportContainerNotFoundReport') ?>">EXPORT CONTAINER NOT FOUND REPORT</a></li>
						<li><a href="<?php echo site_url('report/offhireSummaryAndDetails') ?>" >OFFHIRE SUMMARY AND DETAILS</a></li>
						<li><a href="<?php echo site_url('bill/containerBillListVersion/1') ?>">CONTAINER BILL LIST (VERSION)</a></li>
						
						<li><a href="<?php echo site_url('report/mis_assignment_report_search') ?>">MIS ASSIGNMENT REPORT</a></li>
						<li><a href="<?php echo site_url('report/pilot_vsl_entry_rpt') ?>" target="_BLANK">PILOT VESSEL ENTRY REPORT</a></li>

					</ul>
				</li>
				 <li class='has-sub'><a href='#'><span>REEFER REPORT</span></a>
				  <ul>
					<li><a href="<?php echo site_url('report/myRefferImportContainerDischargeReport') ?>">YARD WISE REEFER IMPORT CONTAINER</a></li>
					<!--li><a href="<?php echo site_url('report/vesslWiseRefeerContainerList') ?>">VESSEL WISE REEFER CONTAINER LIST </a></li>
					<li><a href="<?php echo site_url('report/myWaterSupplyInVesselsReportForm') ?>">WATER SUPPLY IN VESSELS</a></li>
					<li><a href="<?php echo site_url('report/myContainerHistoryReportForm') ?>">CONTAINER HISTORY REPORT</a></li-->
				  </ul>
			   </li>
				<li class='has-sub'><a href='#'><span>SCY OPERATION</span></a>
					<ul>
			           <li><a href="<?php echo site_url('report/rotationWiseContainerPosition') ?>">ROTATION WISE CONTAINER POSITION</a></li>
					   <li><a href="<?php echo site_url('report/containerOperationReportForm') ?>">CONTAINER OPERATION REPORT</a></li>
					</ul>
				</li>
				<li class='has-sub'><a href='#'><span>PILOTAGE CERTIFICATE</span></a>
				  <ul>
					<li><a href="<?php echo site_url('report/vesselListForPilotage') ?>">CERTIFICATE</a></li>
				  </ul>
			   </li>
			   <li class='has-sub'><a href='#'><span>UPLOAD</span></a>
				  <ul>
					<?php
						//include("dbConection.php");
						$str = "select count(distinct rotation) as cnt from ctmsmis.mis_exp_unit_preadv_req where preAddStat=1 and date(last_update)=date(now())";
						$result = mysql_query($str,$con_sparcsn4);
						$row = mysql_fetch_object($result);
						$badge = $row->cnt;
					?>
					<li class="badge1" data-badge="<?php echo $badge;?>"><a href="<?php echo site_url('uploadExcel/preAdvisedRotList') ?>">Today's Pre-Advised Rotation</a></li>
					<?php mysql_close($con_sparcsn4);?>
					<?php
						include("mydbPConnection.php");
						$str = "select count(id) as cnt from edi_stow_info where file_status=0";
						
						$result = mysql_query($str);
						$row = mysql_fetch_object($result);
						$badge = $row->cnt;
						//echo "TEST : ".$badge;
					?>
					<?php 
					mysql_close($cchaportdb);
					include("dbConection.php");
					?>
					<li class="badge1" data-badge="<?php echo $badge;?>"><a href="<?php echo site_url('uploadExcel/todays_edi_declaration') ?>">Today's EDI Declaration</a></li>
					<li><a href="<?php echo site_url('uploadExcel/convertCopino') ?>">Convert COPINO</a></li>
					<li><a href="<?php echo site_url('uploadExcel') ?>">EXCEL UPLOAD FOR COPINO</a></li>
					<li><a href="<?php echo site_url('uploadExcel/stuffingContExcel') ?>">UPLOAD EXCEL FOR LAST 24 HOURS STUFFING CONTAINER</a></li>
					<li><a href="<?php echo site_url('uploadExcel/exportExcelUploadForAdmin') ?>">UPLOAD EXPORT CONTAINER (EXCEL FILE)</a></li>
					<li><a href="<?php echo site_url('uploadExcel/last24hrPerformancePdfForm') ?>">Last 24 Hour Performance PDF File Upload</a></li>
					<li><a href="<?php echo site_url('report/handling_performance_compare') ?>">HANDLING PERFORMANCE COMPARE</a></li>
				  </ul>
			   </li>
			   
			   <li class='has-sub'><a href='#'><span>LCL ASSIGNMENT<span></a>
			     <ul>
			    <li><a href="<?php echo site_url('cfsModule')?>">LCL ASSIGNMENT ENTRY FORM</a></li>
				<li><a href="<?php echo site_url('cfsModule/lclAssignmentReportTable')?>">LCL ASSIGNMENT REPORT</a></li>
			     </ul>
			   </li>
			   <li class='has-sub'><a href='#'><span>SMS</span></a>
					<ul>
						<li><a href="<?php echo site_url('report/smsRptForm') ?>">DATEWISE SMS STATUS</a></li>
						<li><a href="<?php echo site_url('report/smsBalanceEntryForm') ?>">SMS BALANCE UPLOAD</a></li>
					</ul>
				</li>
			   <li class='has-sub'><a href='#'><span>DOWNLOAD</span></a>
				  <ul>
					<li><a href="<?php echo site_url('report/myBillSummaryForm') ?>">BILL SUMMARY</a></li>
				  </ul>
			   </li>
			   <li class='has-sub'><a href='#'><span>PANGOAN</span></a>
					<ul>
						<li><a href="<?php echo site_url('uploadExcel/pangoanContUpload') ?>">EXCEL UPLOAD FOR PANGOAN</a></li>
						<li><a href="<?php echo site_url('uploadExcel/convertPanContForm') ?>">CONVERT PANGOAN CONTAINERS</a></li>
					</ul>
				</li>
				<li class='has-sub'><a href='#'><span>ICD</span></a>
					<ul>
					<li><a href="<?php echo site_url('uploadExcel/uploadIcdExcel') ?>">ICD EXCEL FILE UPLOAD</a></li>
				   <li><a href="<?php echo site_url('uploadExcel/convertIcdFileForm') ?>">ICD EXCEL FILE CONVERTER</a></li>
					</ul>
				</li>
			   <li class='has-sub'><a href='#'><span>ACCOUNT SETTING</span></a>
				  <ul>
					
					<li><a href="<?php echo site_url('login/myPasswordChange') ?>">PASSWORD CHANGE</a></li>
					<?php  if($ipaddr=="192.168.16.68" or $ipaddr=="192.168.16.41"  or $ipaddr=="192.168.16.172" or $ipaddr=="192.168.16.50" or $ipaddr=="192.168.16.43"){?>
						<li><a href="<?php echo site_url('report/userList') ?>">USER LIST</a></li>
						<li><a href="<?php echo site_url('cfsModule/orgProfileList') ?>">ORGANIZATION PROFILE LIST</a></li>
						<li><a href="<?php echo site_url('report/organizationTypeList') ?>">ORGANIZATION TYPE LIST</a></li>												
						<li><a href="<?php echo site_url('report/usrCreationForm') ?>">CREATE USER</a></li>
						<li><a href="<?php echo site_url('login/changePassForClient') ?>">PASSWORD CHANGE FOR CLIENT</a></li>
						<li><a href="<?php echo site_url('menuDesignController/sectionDetailsForm') ?>">SECTION DETAILS FORM</a></li>	
						<li><a href="<?php echo site_url('menuDesignController/sidebarForm') ?>">SIDEBAR</a></li>												
						<li><a href="<?php echo site_url('menuDesignController/sidebarFormList') ?>">SIDEBAR LIST</a></li>												
					<?php }?>
				  </ul>
			   </li>
			</ul>
			</div>
		
		
		</div>
		<?php } ?>
      <!--ADMIN PANEL END-->
			<!--OFFDOCK PANEL START-->
		<?php if($this->session->userdata('Control_Panel')==22 && $this->session->userdata('org_Type_id')==6){?>
		<div class="gadget">
		<div id='cssmenu'>
				<ul>
			   <li class='active'><a href='#'><span>OFFDOCK PANEL</span></a></li>
			   <li class='has-sub'><a href='#'><span>REPORTS</span></a>
				  <ul>
					<li><a href="<?php echo site_url('report/myBlockedContainerView') ?>" target="_blank">BLOCKED CONTAINER REPORT</a></li>
					<!--li><a href="<?php echo site_url('report/myoffDocWiseContStatus') ?>" target="_BLANK">ALL CONTAINER LIST</a></li-->
					<li><a href="<?php echo site_url('report/offDockContListForm') ?>">POSITION WISE PRE ADVISED CONTAINER LIST</a></li>
					<li><a href="<?php echo site_url('report/offDockContSearchForm') ?>">PRE ADVISED CONTAINER SEARCH </a></li>
					<li><a href="<?php echo site_url('report/dateWiseoffDockContListForm') ?>">DATE WISE PRE ADVISED CONTAINER LIST</a></li>
					<li><a href="<?php echo site_url('report/preAdvisedOffDockContByRotForm') ?>">ROTATION WISE PRE-ADVISED CONTAINERS</a></li>
					<li><a href="<?php echo site_url('report/myoffDociew') ?>" target="_BLANK">OFFDOCK INFORMATION</a></li>
					<li><a href="<?php echo site_url('report/offdocdepotLadenCont') ?>" target="_BLANK">LADEN CONTAINER</a></li>
					<li><a href="<?php echo site_url('report/onestopCertifySection') ?>">LOCATION \ CERTIFY</a></li>
					<li><a href="<?php echo site_url('uploadExcel/last24hrsStatements') ?>">LAST 24 STATEMENT</a></li>
					<li><a href="<?php echo site_url('uploadExcel/last24hrsStatementList') ?>">LAST 24 STATEMENT LIST</a></li>
					<li><a href="<?php echo site_url('report/barcodeTestForm') ?>">PRINT BARCODE</a></li>
					<li><a href="<?php echo site_url('report/stuffingContainerListForm') ?>">LAST 24 HOURS STUFFING CONTAINER LIST</a></li>
				  </ul>
			   </li>
			   <li class='has-sub'><a href='#'><span>UPLOAD</span></a>
				  <ul>
					<li><a href="<?php echo site_url('uploadExcel/uploadBlockedContainerForm') ?>">EXCEL UPLOAD BLOCKED CONTAINER</a></li>
					<li><a href="<?php echo site_url('uploadExcel/stuffingContExcel') ?>">UPLOAD EXCEL FOR LAST 24 HOURS STUFFING CONTAINER</a></li>
				  </ul>
			   </li>
			    <li class='has-sub'><a href='#'><span>MANUAL</span></a>
				  <ul>
					<li><a href="<?php echo BASE_PATH.'resources/OffdockManual/CTMS Off-Dock User Manual.pdf' ?>" target="blank">OFF-DOCK MANUAL</a></li>
					<li><a href="<?php echo BASE_PATH.'resources/OffdockManual/iso_code.xls' ?>" target="blank">ISO CODE LIST</a></li>
					<li><a href="<?php echo BASE_PATH.'resources/OffdockManual/mlo_code.xls' ?>" target="blank">MLO CODE LIST</a></li>
				  </ul>
			   </li>
			   <li class='has-sub'><a href='#'><span>ACCOUNT SETTING</span></a>
				  <ul>
					<li><a href="<?php echo site_url('login/myPasswordChange') ?>">PASSWORD CHANGE</a></li>
				  </ul>
			   </li>
			</ul>
			</div>
		
		
		</div>
		<?php } ?>
      <!--OFFDOCK PANEL END-->
	<!--AGENT PANEL START-->
		<?php if($this->session->userdata('Control_Panel')==57 && $this->session->userdata('org_Type_id')==57){?>
			<div class="gadget">
			<div id='cssmenu'>
				<ul>
					<li class='active'><a href='#'><span>SHIPPING AGENT PANEL</span></a></li>
						<li class='has-sub'><a href='#'><span>IGM OPERATION</span></a>
							<ul>
								<li><a href="<?php echo site_url('igmViewController/viewIgmGeneral/GM') ?>" target="_BLANK">View IGM General Information</a></li>
							</ul>
						</li>
			   	   <li class='has-sub'><a href='#'><span>ENTRY FORM</span></a>
						<ul>
							<li><a href="<?php echo site_url('report/officeCodeUpdaterForm') ?>">B/E Entry Form</a></li>
							
						</ul>
				   </li>
				 <li class='has-sub'><a href='#'><span>STUFFING REPORT</span></a>
					<ul>
						<li><a href="<?php echo site_url('report/stuffingContainerListForm') ?>">LAST 24 HOURS STUFFING CONTAINER LIST</a></li>
					</ul>
			   </li>
			   <li class='has-sub'><a href='#'><span>ASSIGNMENT REPORT</span></a>
				<ul>
					<li><a href="<?php echo site_url('report/sh_agent_assignment_Form') ?>">ALL ASSIGNMENT DETAILS</a></li>
				</ul>
			   </li>
			   <li class='has-sub'><a href='#'><span>REPORTS</span></a>
				  <ul>
					 <li><a href="<?php echo site_url('report/myoffDociew') ?>" target="_BLANK">OFFDOCK INFORMATION</a></li>
					 <li><a href="<?php echo site_url('report/commodityInfoView') ?>" target="_BLANK">COMMODITY INFORMATION</a></li>
					 <li><a href="<?php echo site_url('report/myPortCodeList') ?>" target="_BLANK">PORT CODE LIST</a></li>
					 <li><a href="<?php echo site_url('report/myAgentWiseVessel') ?>" target="_BLANK">VESSEL WISE PRE ADVISED CONTAINER</a></li>
					 <li><a href="<?php echo site_url('report/myAgentWiseContainerStatus') ?>">AGENT WISE PRE ADVISED CONTAINER STATUS</a></li>					 
					 <li><a href="<?php echo site_url('report/myOffdocWiseContainerStatus') ?>">OFFDOCK WISE PRE ADVISED CONTAINER STATUS</a></li>
					 <li><a href="<?php echo site_url('report/myAgentWiseVesselInfo') ?>">VESSEL TRANSIT WAYS INFORMATION</a></li>
					 <li><a href="<?php echo site_url('report/mloWisePreadviceloadedContainerList') ?>">MLO WISE PRE ADVISED CONTAINER LIST </a></li>
					 <li><a href="<?php echo site_url('report/myExportContainerLoadingReport') ?>">LOADED CONTAINER LIST</a></li>
					 <li><a href="<?php echo site_url('report/myImportContainerDischargeReport') ?>">IMPORT DISCHARGE AND BALANCE REPORT</a></li>
					<li><a href="<?php echo site_url('report/doReportForm') ?>">Delivery Order Report</a></li>
					<li><a href="<?php echo site_url('report/exportContainerGateInForm') ?>">EXPORT CONTAINER GATE IN LIST</a></li>
					<!-- From MLO Panel --->
					<li><a href="<?php echo site_url('report/dischargeListForMLO') ?>">DISCHARGE LIST </a></li>
					<li><a href="<?php echo site_url('report/yardWiseContainerHandlingDetailsRptForm') ?>">CURRENT YARD LYING CONTAINER REPORT</a></li>
					<li><a href="<?php echo site_url('report/viewVesselListStatus') ?>">VESSEL LIST WITH EXPORT APPS LOADING REPORT</a></li>
					<li><a href="<?php echo site_url('report/vesselBillList/1') ?>">VESSEL BILL LIST</a></li>
					<li><a href="<?php echo site_url('report/viewVesselListImportStatus') ?>">VESSEL LIST WITH IMPORT APPS LOADING REPORT</a></li>

				  </ul>
			   </li>
			   <li class='has-sub'><a href='#'><span>UPLOAD</span></a>
				  <ul>
				  <?php
						//include("dbConection.php");
						$str = "select count(distinct rotation) as cnt from ctmsmis.mis_exp_unit_preadv_req where preAddStat=1 and date(last_update)=date(now())";
						$result = mysql_query($strn,$con_sparcsn4);
						$row = mysql_fetch_object($result);
						$badge = $row->cnt;
					?>
					<li class="badge1" data-badge="<?php echo $badge;?>"><a href="<?php echo site_url('uploadExcel/preAdvisedRotList') ?>">Today's Pre-Advised Rotation</a></li>
					<?php //mysql_close($con_sparcsn4);?>
					<li><a href="<?php echo site_url('uploadExcel') ?>">EXCEL UPLOAD FOR COPINO</a></li>
					<li><a href="<?php echo site_url('uploadExcel/ediDownloadSample') ?>">DOWLOAD EXCEL SAMPLE FOR EDI DOWNLOAD</a></li>
					<li><a href="<?php echo site_url('report/EDISearch') ?>">EDI CONVERTER</a></li>
					<li><a href="<?php echo site_url('report/ConvertedEDISearch') ?>">CONVERTED VESSEL LIST</a></li>
				  </ul>
			   </li>
			   <li class='has-sub'><a href='#'><span>ACCOUNT SETTING</span></a>
				  <ul>
					<li><a href="<?php echo site_url('login/myPasswordChange') ?>">PASSWORD CHANGE</a></li>
				  </ul>
			   </li>
			</ul>
			</div>
			</div>
		<?php } ?>
		<!--AGENT PANEL END-->
         <!--Security start-->
		<?php if($this->session->userdata('Control_Panel')==58 && $this->session->userdata('org_Type_id')==58){?>
		<div class="gadget">
		<div id='cssmenu'>
				<ul>
			   
			   <li class='has-sub'><a href='#'><span>REPORTS</span></a>
				<ul>
				<li><a href="<?php echo site_url('report/offDockContSearchForm') ?>">PRE ADVISED CONTAINER SEARCH </a></li>
				</ul>
			   </li>
			</ul>
			</div>
		
		
		</div>
		<?php } ?>
      <!--Security END-->
	  
	  
	  <!--Shed start-->
	  <?php if($this->session->userdata('Control_Panel')==59 && $this->session->userdata('org_Type_id')==59){?>
		<div class="gadget">
			<div id='cssmenu'>
				<ul>
				   <li class='active'><a href='#'><span>CPA SHED PANEL</span></a></li>
				   <li class='has-sub'><a href='#'><span>ASSIGNMENT VIEW</span></a>
						<ul>
							<li><a href="<?php echo site_url('cfsModule/lclAssignmentReportTable') ?>">LCL ASSIGNMENT REPORT</a></li>
							<li><a href="<?php echo site_url('report/tallyEntryWithIgmInfoForm') ?>">TALLY SHEET ENTRY </a></li>							
							<li><a href="<?php echo site_url('report/appraisementCertifySection') ?>">APPRAISEMENT SECTION</a></li>
							<li><a href="<?php echo site_url('report/appraisementCertifySectionEdit') ?>">EDIT APPRISEMENT</a></li>
						</ul>
				   </li>
				   <li class='has-sub'><a href='#'><span>OTHERS</span></a>
						<ul>
							
							<!--li><a href="<?php echo site_url('report/doEntrySearchForm') ?>">DELIVERY ORDER(DO) ENTRY</a></li>
                            <li><a href="<?php echo site_url('cfsModule') ?>">LCL ASSIGNMENT ENTRY FORM</a></li-->
							
							<li><a href="<?php echo site_url('ShedBillController/billSearchByVerifyForm') ?>">DELIVERY ORDER(DO) ENTRY</a></li>
  							<li><a href="<?php echo site_url('report/deliveryEntryFormByWHClerk') ?>">DOCUMENT PROCESS (Verify)</a></li>
							<li><a href="<?php echo site_url('report/deliverySearchByVerifyNo') ?>">W.H/LOCKFAST ENTRY</a></li>
							<li><a href="<?php echo site_url('ShedBillController/tallyReportForm') ?>">TALLY REPORT</a></li>
							<!--li><a href="<?php echo site_url('ShedBillController') ?>">SHED BILL</a></li-->

						</ul>
				   </li>
				   <li class='has-sub'><a href='#'><span>REPORTS</span></a>
						<ul>
							<li><a href="<?php echo site_url('report/verificationListForm') ?>">VERIFICATION LIST</a></li>
							<li><a href="<?php echo site_url('report/appraisementListForm') ?>">APPRISEMENT LIST</a></li>
							<li><a href="<?php echo site_url('report/tallyListForm') ?>">TALLY LIST</a></li>
							<li><a href="<?php echo site_url('report/wirehouseReportForm') ?>">WAREHOUSE REPORT (IMPORT) </a></li>
							<li><a href="<?php echo site_url('report/wirehouseReportFormDatewise') ?>">WIREHOUSE REPORT (DATEWISE) </a></li>
							<li><a href="<?php echo site_url('report/gateReportForm') ?>">GATE REPORT</a></li>
						</ul>
				   </li>
				</ul>
			</div>		
		</div>
		<?php } ?>
		<?php if($this->session->userdata('Control_Panel')==59 && $this->session->userdata('org_Type_id')==59){?>
		<!--div class="gadget">
			<div id='cssmenu'>
				<ul>
				   <li class='active'><a href='#'><span>CPA SHED PANEL</span></a></li>
				   <li class='has-sub'><a href='#'><span>TALLY ENTRY</span></a>
						<ul>
							<li><a href="<?php echo site_url('report/tallyEntryWithIgmInfoForm') ?>">TALLY ENTRY WITH IGM INFORMATION</a></li>
							<li><a href="<?php echo site_url('report/doEntrySearchForm') ?>">DELIVERY ORDER(DO) ENTRY</a></li>
							<li><a href="<?php echo site_url('cfsModule/lclAssignmentReportTable')?>">LCL ASSIGNMENT REPORT</a></li>

						</ul>
				   </li>
				   <li class='has-sub'><a href='#'><span>REPORTS</span></a>
						<ul>
							<li><a href="<?php echo site_url('report/wirehouseReportForm') ?>">WAREHOUSE REPORT (IMPORT) </a></li>
							<li><a href="<?php echo site_url('report/wirehouseReportFormDatewise') ?>">WIREHOUSE REPORT (DATEWISE) </a></li>
						</ul>
				   </li>
				   <li class='has-sub'><a href=""><span>SHED BILL</span></a>
						<ul>
							<li><a href="<?php echo site_url('ShedBillController/shedBillListForm') ?>">SHED BILL LIST</a></li>
							<li><a href="<?php echo site_url('ShedBillController/tallyReportForm') ?>">TALLY REPORT</a></li>
						</ul>
				   </li>
				</ul>
			</div>		
		</div-->
		<?php } ?>
      <!--Shed END-->
	  
	  <!--C&F start-->
		<?php if($this->session->userdata('Control_Panel')==2 && $this->session->userdata('org_Type_id')==2){?>
		<div class="gadget">
			<div id='cssmenu'>
				<ul>
				   <li class='active'><a href='#'><span>C&F PANEL</span></a></li>
				   <li class='has-sub'><a href='#'><span>ENTRY FORM</span></a>
						<ul>
							<!--li><a href="<?php echo site_url('report/officeCodeUpdaterForm') ?>">B/E Entry Form</a></li-->
							<li><a href="<?php echo site_url('ShedBillController/billSearchByVerifyForm') ?>">DELIVERY ORDER(DO) ENTRY</a></li>
							
							<li><a href="<?php echo site_url('report/jettySarkarEntryForm') ?>">JETTY SARKAR ENTRY FORM</a></li>	
							<li><a href="<?php echo site_url('report/jettySarkarListForm') ?>">JETTY SARKAR LIST</a></li>	
							<li><a href="<?php echo site_url('report/truck_entry_form') ?>">CONTAINER ASSIGN FOR DELIVERY</a></li>
							<li><a href="<?php echo site_url('report/billOfEntryInfoForm') ?>">B/L ENTRY INFORMATION FORM</a></li>	
						</ul>
				   </li>
				   <li class='has-sub'><a href='#'><span>REPORTS</span></a>
						<ul>
							<li><a href="<?php echo site_url('report/tallyListForm') ?>">TALLY LIST</a></li>
							<li><a href="<?php echo site_url('report/certificationFormHtml') ?>">UNSTUFFING INFORMATION</a></li>
							<!--li><a href="<?php echo site_url('report/shedStockBalanceForm') ?>">VIEW CERTIFICATION</a></li-->
							<li><a href="<?php echo site_url('report/verificationListForm') ?>">VERIFICATION LIST</a></li>
							<!--li><a href="<?php echo site_url('report/doReportForm') ?>">Delivery Order Report</a></li>
							<li><a href="<?php echo site_url('report/onestopCertifySection') ?>">Location \ Certify</a></li-->
							
						</ul>
				   </li>
				    <li class='has-sub'><a href='#'><span>ASSIGNMENT LIST</span></a>
						<ul>
							<li><a href="<?php echo site_url('report/cf_agent_assignment_Form') ?>">ALL ASSIGNMENT DETAILS</a></li>
							<!--li><a href="<?php echo site_url('report/truck_entry_list') ?>">ASSIGNED TRUCK LIST</a></li-->
						</ul>
					</li>
					<!--li class='has-sub'><a href='#'><span>ENTRY FORM</span></a>
						<ul>
							<li><a href="<?php echo site_url('report/truck_entry_form') ?>">TRUCK ENTRY FORM</a></li>
						</ul>
					</li-->
				</ul>
			</div>		
		</div>
		<?php } ?>
      <!--C&F END-->
	   <!--Gate User start-->
		<?php if($this->session->userdata('Control_Panel')==61 && $this->session->userdata('org_Type_id')==61){?>
		<div class="gadget">
			<div id='cssmenu'>
				<ul>
				   <li class='active'><a href='#'><span>GATE USER PANEL</span></a></li>
				   <li class='has-sub'><a href='#'><span>GATE INSPECTOR</span></a>
						<ul>
						<li><a href="<?php echo site_url('gateController/gateOut') ?>">GATE ENTRY</a></li>
						<li><a href="<?php echo site_url('report/gateConfirmation') ?>">GATE CONFIRMATION</a></li>

						
						<!--
							<li><a href="<?php echo site_url('report/tallyEntryWithIgmInfoForm') ?>">TALLY ENTRY WITH IGM INFORMATION</a></li>
							<li><a href="<?php echo site_url('report/doEntrySearchForm') ?>">DELIVERY ORDER(DO) ENTRY</a></li>
                            <li><a href="<?php echo site_url('cfsModule') ?>">LCL ASSIGNMENT ENTRY FORM</a></li>
                            <li><a href="<?php echo site_url('cfsModule/lclAssignmentReportTable') ?>">LCL ASSIGNMENT REPORT</a></li>
							<li><a href="<?php echo site_url('ShedBillController') ?>">SHED BILL</a></li>
							<li><a href="<?php echo site_url('ShedBillController/exchangeRateForm') ?>">ADD EXCHANGE RATE</a></li>
                           -->
						</ul>
				   </li>
				    <li class='has-sub'><a href='#'><span>GATE REPORT</span></a>
						<ul>
							<li><a href="<?php echo site_url('report/gateReportForm') ?>">GATE REPORT</a></li>
							<li><a href="<?php echo site_url('gateController/containerRegisterInRegister')?>">INWARD & OUTWARD CONTAINER REGISTER</a></li>
							<li><a href="<?php echo site_url('gateController/gateWiseContainerRegister')?>">GATEWISE INWARD & OUTWARD CONTAINER REGISTER</a></li>
							<li><a href="<?php echo site_url('gateController/containerRegisterInRegister_ocr')?>">INWARD & OUTWARD OCR CONTAINER REGISTER</a></li>
						<!--
							<li><a href="<?php echo site_url('report/wirehouseReportForm') ?>">WAREHOUSE REPORT (IMPORT) </a></li>
							<li><a href="<?php echo site_url('report/lclAssignmentCertifySection') ?>">LCL Assignment \ Certify</a></li>
							
						-->	
						</ul>
				   </li>
				   <li class='has-sub'><a href='#'><span>GATE SECURITY</span></a>
						<ul>
						<!--
							<li><a href="<?php echo site_url('report/wirehouseReportForm') ?>">WAREHOUSE REPORT (IMPORT) </a></li>
							<li><a href="<?php echo site_url('report/lclAssignmentCertifySection') ?>">LCL Assignment \ Certify</a></li>
						-->	
						</ul>
				   </li>
				</ul>
			</div>		
		</div>
		<?php } ?>
      <!--Gate User END-->
	   <!--One Stop start-->
		<?php if($this->session->userdata('Control_Panel')==62 && $this->session->userdata('org_Type_id')==62){?>
		<div class="gadget">
		<div id='cssmenu'>
				<ul>
			   <li class='active'><a href='#'><span>LCL DOCUMENTATION</span></a></li>
			   <li class='has-sub'><a href='#'><span>CPA SHED SECTION</span></a>
					<ul>
					
						<li><a href="<?php echo site_url('cfsModule/lclAssignmentReportTable') ?>">LCL ASSIGNMENT REPORT</a></li>
						<li><a href="<?php echo site_url('report/tallyEntryWithIgmInfoForm') ?>">TALLY SHEET ENTRY </a></li>							
						<li><a href="<?php echo site_url('report/appraisementCertifySection') ?>">APPRAISEMENT SECTION</a></li>
						<li><a href="<?php echo site_url('report/appraisementCertifySectionEdit') ?>">EDIT APPRISEMENT</a></li>
						<li><a href="<?php echo site_url('ShedBillController/billSearchByVerifyForm') ?>">DELIVERY ORDER(DO) ENTRY</a></li>
  						<li><a href="<?php echo site_url('report/deliveryEntryFormByWHClerk') ?>">DOCUMENT PROCESS (Verify)</a></li>
						<li><a href="<?php echo site_url('report/deliverySearchByVerifyNo') ?>">W.H/LOCKFAST ENTRY</a></li>
						<li><a href="<?php echo site_url('ShedBillController/tallyReportForm') ?>">TALLY REPORT</a></li>
						<!--shed panel link changed by awal-->
					</ul>
				 </li>
			    <li class='has-sub'><a href='#'><span>ONESTOP SECTION</span></a>
					<ul>
						<li><a href="<?php echo site_url('report/lclAssignmentCertifySection') ?>">LCL ASSIGNMENT/CERTIFY</a></li>
						<li><a href="<?php echo site_url('ShedBillController/exchangeRateForm') ?>">ADD EXCHANGE RATE</a></li>
						<li><a href="<?php echo site_url('ShedBillController') ?>">SHED BILL</a></li>
						<!--shed panel link changed by awal-->
						<!--li><a href="<?php echo site_url('report/appraisementCertifySection') ?>">APPRAISEMENT SECTION</a></li>
						<li><a href="<?php echo site_url('report/appraisementCertifySectionEdit') ?>">EDIT APPRISEMENT</a></li-->
						<li><a href="<?php echo site_url('ShedBillController/billSearchByVerifyForm') ?>">DELIVERY ORDER(DO) ENTRY</a></li>
  						<li><a href="<?php echo site_url('report/deliveryEntryFormByWHClerk') ?>">DOCUMENT PROCESS (Verify)</a></li>
						<li><a href="<?php echo site_url('report/deliverySearchByVerifyNo') ?>">W.H/LOCKFAST ENTRY</a></li>
						<li><a href="<?php echo site_url('ShedBillController/tallyReportForm') ?>">TALLY REPORT</a></li>
						<li><a href="<?php echo site_url('report/gateConfirmation') ?>">GATE CONFIRMATION</a></li>
						<li><a href="<?php echo site_url('uploadExcel/uploadCnFSignatureForm') ?>">UPLOAD C&F SIGNATURE</a></li>
						<li><a href="<?php echo site_url('ShedBillController/unitSetUpdate') ?>">UNIT ASSIGN</a></li>
						<li><a href="<?php echo site_url('ShedBillController/unitList') ?>">ASSIGNED UNIT LIST</a></li>
						<!--shed panel link changed by awal-->
					</ul>
				   </li>
				   <li class='has-sub'><a href='#'><span>BILL/REVENUE SECTION</span></a>
					<ul>
						<li><a href="<?php echo site_url('ShedBillController/billGenerationForm') ?>">BILL GENERATION</a></li>
						<!--bank panel link changed by awal-->
						<li><a href="<?php echo site_url('ShedBillController/shedBillListForm') ?>">SHED BILL LIST</a></li>
						<!--bank panel link changed by awal-->
						<!--li><a href="<?php echo site_url('ShedBillController') ?>">SHED BILL</a></li-->
					</ul>
				   </li>
				   <li class='has-sub'><a href='#'><span>BANK SECTION</span></a>
					<ul>
						<li><a href="<?php echo site_url('ShedBillController/shedBillListForm') ?>">SHED BILL LIST</a></li>
						<li><a href="<?php echo site_url('ShedBillController/shedBillHeadWiseSummaryRptForm') ?>">HEAD WISE SUMMARY REPORT</a></li>
						<li><a href="<?php echo site_url('ShedBillController/shedBillSummaryRptForm') ?>">SUMMARY REPORT </a></li>
					</ul>
				   </li>
				   <li class='has-sub'><a href='#'><span>C&F SECTION</span></a>
					<ul>
						<li><a href="<?php echo site_url('report/certificationFormHtml') ?>">VIEW CERTIFICATION</a></li>
						<li><a href="<?php echo site_url('report/verificationListForm') ?>">VERIFICATION LIST</a></li>
					</ul>
				   </li>
				<li class='has-sub'><a href='#'><span>GATE SECTION</span></a>
					<ul>
						<li><a href="<?php echo site_url('gateController/gateOut') ?>">GATE ENTRY</a></li>
						<li><a href="<?php echo site_url('report/gateConfirmation') ?>">GATE CONFIRMATION</a></li>
						<li><a href="<?php echo site_url('report/gateReportForm') ?>">GATE REPORT</a></li>
					</ul>
				   </li>
			   <li class='has-sub'><a href='#'><span>REPORTS</span></a>
				<ul>
					<li><a href="<?php echo site_url('report/verificationListForm') ?>">VERIFICATION LIST</a></li>
					<li><a href="<?php echo site_url('report/shedStockBalanceForm') ?>">SHED STOCK BALANCE</a></li>
					<li><a href="<?php echo site_url('report/releaseOrderForm') ?>">RELEASE ORDER</a></li>
					<li><a href="<?php echo site_url('report/shedDeliveryOrder') ?>">SHED DELIVERY ORDER</a></li>
					<li><a href="<?php echo site_url('report/cartTicketForm') ?>">CART TICKET</a></li>
					<li><a href="<?php echo site_url('report/gateReportForm') ?>">GATE REPORT</a></li>
                    <li><a href="<?php echo site_url('report/importCargoReportForm') ?>">IMPORT CARGO RECEIVING & DELIVERY REPORT</a></li>
				</ul>
			   </li>
			</ul>
			</div>
		
		
		</div>
		<?php } ?>
      <!--One Stop END-->
	   <!--Bank Panel Start-->
		<?php if($this->session->userdata('Control_Panel')==13 && $this->session->userdata('org_Type_id')==13){?>
		<div class="gadget">
		<div id='cssmenu'>
				<ul>
			   <li class='active'><a href='#'><span>BANK PANEL</span></a></li>
			   <li class='has-sub'><a href='#'><span>BILL LIST</span></a>
			   <ul>
					<li><a href="<?php echo site_url('ShedBillController/shedBillListForm') ?>">SHED BILL LIST</a></li>
			   </ul>
			   </li>
			   
			   <li class='has-sub'><a href='#'><span>REPORTS</span></a>
				<ul>
					<li><a href="<?php echo site_url('ShedBillController/shedBillHeadWiseSummaryRptForm') ?>">HEAD WISE SUMMARY REPORT</a></li>
					<li><a href="<?php echo site_url('ShedBillController/shedBillSummaryRptForm') ?>">SUMMARY REPORT </a></li>
				</ul>
			   </li>
			</ul>
			</div>
		
		
		</div>
		<?php } ?>
      <!--Bank Panel END-->
	  <!--MLO Panel Start-->
		<?php if($this->session->userdata('Control_Panel')==1 && $this->session->userdata('org_Type_id')==1){?>
		<div class="gadget">
		<div id='cssmenu'>
				<ul>
			   <li class='active'><a href='#'><span>MLO PANEL</span></a></li>
			   <li class='has-sub'><a href='#'><span>STUFFING REPORT</span></a>
				<ul>
					<li><a href="<?php echo site_url('report/stuffingContainerListForm') ?>">LAST 24 HOURS STUFFING CONTAINER LIST</a></li>
				</ul>
			   </li>
			   <li class='has-sub'><a href='#'><span>REPORTS</span></a>
				<ul>
					<!--li><a href="<?php echo site_url('report/offDockContSearchForm') ?>">PRE ADVISED CONTAINER SEARCH </a></li-->
					<!--li><a href="<?php echo site_url('ShedBillController/shedBillHeadWiseSummaryRptForm') ?>">HEAD WISE SUMMARY REPORT</a></li-->
					<li><a href="<?php echo site_url('report/dischargeListForMLO') ?>">DISCHARGE LIST </a></li>
					<li><a href="<?php echo site_url('report/yardWiseContainerHandlingDetailsRptForm') ?>">CURRENT YARD LYING CONTAINER REPORT</a></li>
					<li><a href="<?php echo site_url('report/viewVesselListStatus') ?>">VESSEL LIST WITH EXPORT APPS LOADING REPORT</a></li>
					<li><a href="<?php echo site_url('report/viewVesselListImportStatus') ?>">VESSEL LIST WITH IMPORT APPS LOADING REPORT</a></li>
					<!--li><a href="<?php echo site_url('ShedBillController/shedBillSummaryRptForm') ?>">SUMMARY REPORT </a></li-->
					<!--li><a href="<?php echo site_url('report/myRequstEmtyContainerReport1') ?>">Test Pdf </a></li-->
					<!--li><a href="<?php echo site_url('report/stuffingContainerListForm') ?>">LAST 24 HOURS STUFFING CONTAINER LIST</a></li-->
					<?php	
						$strContBill = "";
						if($lid=="devmlo")
							$strContBill = "select count(draft_id) as cnt from ctmsmis.mis_billing where date(billing_date) = date(now())";
						else
							$strContBill = "SELECT COUNT(draft_id) AS cnt FROM ctmsmis.mis_billing WHERE DATE(billing_date) = DATE(NOW()) AND mlo_code='$lid'";
						$resultContBill = mysql_query($strContBill,$con_sparcsn4);
						$rowContBill = mysql_fetch_object($resultContBill);
						$badgeContBill = $rowContBill->cnt;		
					?>
					<li class="badge1" data-badge="<?php echo $badgeContBill;?>"><a href="<?php echo site_url('bill/containerBillList/1') ?>">CONTAINER BILL LIST</a></li>
					<!--li><a href="<?php echo site_url('bill/containerBillListVersion/1') ?>">CONTAINER BILL LIST (VERSION)</a></li-->

				</ul>
			   </li>
			    <li class='has-sub'><a href='#'><span>ACCOUNT SETTING</span></a>
				  <ul>
					<li><a href="<?php echo site_url('login/myPasswordChange') ?>">PASSWORD CHANGE</a></li>
				  </ul>
			   </li>
			</ul>
			</div>
		
		
		</div>
		<?php } ?>
      <!--MLO Panel END-->
	  <!--FREIGHT Panel Start-->
		<?php if($this->session->userdata('Control_Panel')==4 && $this->session->userdata('org_Type_id')==4){?>
		<div class="gadget">
		<div id='cssmenu'>
				<ul>
			   <li class='active'><a href='#'><span>FREIGHT PANEL</span></a></li>
				<li class='has-sub'><a href='#'><span>STUFFING REPORT</span></a>
				<ul>
					<li><a href="<?php echo site_url('report/stuffingContainerListForm') ?>">LAST 24 HOURS STUFFING CONTAINER LIST</a></li>
				</ul>
			   </li>
			   <li class='has-sub'><a href='#'><span>REPORTS</span></a>
				<ul>
					<li><a href="<?php echo site_url('report/myoffDociew') ?>" target="_BLANK">OFFDOCK INFORMATION</a></li>
					 <li><a href="<?php echo site_url('report/myPortCodeList') ?>" target="_BLANK">PORT CODE LIST</a></li>
					 <li><a href="<?php echo site_url('report/myAgentWiseVessel') ?>" target="_BLANK">VESSEL WISE PRE ADVISED CONTAINER</a></li>
					 <li><a href="<?php echo site_url('report/myAgentWiseContainerStatus') ?>">AGENT WISE PRE ADVISED CONTAINER STATUS</a></li>					 
					 <li><a href="<?php echo site_url('report/myOffdocWiseContainerStatus') ?>">OFFDOCK WISE PRE ADVISED CONTAINER STATUS</a></li>
					 <li><a href="<?php echo site_url('report/myAgentWiseVesselInfo') ?>">VESSEL TRANSIT WAYS INFORMATION</a></li>
					 <li><a href="<?php echo site_url('report/mloWisePreadviceloadedContainerList') ?>">MLO WISE PRE ADVISED CONTAINER LIST </a></li>
					 <li><a href="<?php echo site_url('report/myExportContainerLoadingReport') ?>">LOADED CONTAINER LIST</a></li>
					 <li><a href="<?php echo site_url('report/myImportContainerDischargeReport') ?>">IMPORT DISCHARGE AND BALANCE REPORT</a></li>
					<li><a href="<?php echo site_url('report/doReportForm') ?>">Delivery Order Report</a></li>
					<li><a href="<?php echo site_url('report/exportContainerGateInForm') ?>">EXPORT CONTAINER GATE IN LIST</a></li>
					<!-- From MLO Panel --->
					<li><a href="<?php echo site_url('report/dischargeListForMLO') ?>">DISCHARGE LIST </a></li>
					<li><a href="<?php echo site_url('report/yardWiseContainerHandlingDetailsRptForm') ?>">CURRENT YARD LYING CONTAINER REPORT</a></li>
					<li><a href="<?php echo site_url('report/viewVesselListStatus') ?>">VESSEL LIST WITH EXPORT APPS LOADING REPORT</a></li>
					<li><a href="<?php echo site_url('report/vesselBillList/1') ?>">VESSEL BILL LIST</a></li>
					<li><a href="<?php echo site_url('report/viewVesselListImportStatus') ?>">VESSEL LIST WITH IMPORT APPS LOADING REPORT</a></li>
					
				</ul>
			   </li>
			    <li class='has-sub'><a href='#'><span>ACCOUNT SETTING</span></a>
				  <ul>
					<li><a href="<?php echo site_url('login/myPasswordChange') ?>">PASSWORD CHANGE</a></li>
				  </ul>
			   </li>
			</ul>
			</div>
		
		
		</div>
		<?php } ?>
      <!--FREIGHT Panel END-->
	  
	  <!--Pilot Panel Start-->
		<?php if($this->session->userdata('Control_Panel')==64 && $this->session->userdata('org_Type_id')==64){?>
		<div class="gadget">
			<div id='cssmenu'>
				<ul>
					<li class='active'><a href='#'><span>PILOT PANEL</span></a></li>
					<li class='has-sub'><a href='#'><span>CERTIFICATE</span></a>
						<ul>
							<li><a href="<?php echo site_url('report/vesselListForPilotage') ?>">CERTIFICATE</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<?php } ?>
		<!--ICD App Panel Start-->
		<?php if($this->session->userdata('Control_Panel')==69 && $this->session->userdata('org_Type_id')==69){?>
		<div class="gadget">
			<div id='cssmenu'>
				<ul>
					<li class='active'><a href='#'><span>ICD APP PANEL</span></a></li>
					<li class='has-sub'><a href='#'><span>REPORT</span></a>
						<ul>
							<li><a href="<?php echo site_url('report/cirForm') ?>">CONTAINER INTERCHANGE RECEIPT</a></li>
							<li><a href="<?php echo site_url('report/date_wise_icd_report') ?>">DATE WISE ICD REPORT</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<?php } ?>
		<!--ICD App Panel Panel End-->
		<?php if($this->session->userdata('Control_Panel')==65&& $this->session->userdata('org_Type_id')==65){?>
		<div class="gadget">
			<div id='cssmenu'>
				<ul>
					<li class='active'><a href='#'><span>CHAIRMAN PANEL</span></a></li>
					 <li class='has-sub'><a href='#'><span>EQUIPMENT REPORT</span></a>
						  <ul>
							<li><a href="<?php echo site_url('report/myReportHHTReCord') ?>" target="_BLANK">YARD WISE ASSIGNED EQUIPMENT LIST</a></li>
							<li><a href="<?php echo site_url('report/monthlyYardWiseContainerHandling') ?>">YARD WISE TOTAL CONTAINER HANDLING</a></li>
							<!--li><a href="<?php echo site_url('report/monthlyYardWiseContainerHandling') ?>">YARD WISE TOTAL CONTAINER HANDLING</a></li-->
							<li><a href="<?php echo site_url('report/containerHandlingRptForm') ?>">CONTAINER HANDLING REPORT</a></li>
							<li><a href="<?php echo site_url('report/containerHandlingRptMonthlyForm') ?>">MONTHLY CONTAINER HANDLING REPORT</a></li>
							<li><a href="<?php echo site_url('report/plannedRptForm') ?>">CONTAINER JOB DONE VESSELWISE</a></li>
						  </ul>
					</li>
					<li class='has-sub'><a href='#'><span>EXPORT REPORT</span></a>
						<ul>
							<li><a href="<?php echo site_url('report/commentsSearchForVessel') ?>"><span class="blink_me">COMMENTS BY SHIPPING SECTION ON EXPORT VESSEL</span></a></li>					
						 </ul>
					</li>
					<li class='has-sub'><a href='#'><span>REPORTS</span></a>
						<ul>
							<li><a href="<?php echo site_url('report/vslDtlForChairmanView') ?>" target="_blank">LIST OF VESSEL</a></li>			
							<li><a href="<?php echo site_url('report/gateDtlForChairmanView') ?>" target="_blank">LIST OF GATE</a></li>			
						 </ul>
					</li>
				</ul>
			</div>
		</div>
		<?php } ?>
      <!--Pilot Panel END-->
	  
	   <!--Network Start-->
		<?php 
		$lid = $this->session->userdata('login_id');
		if($this->session->userdata('Control_Panel')==66 && $this->session->userdata('org_Type_id')==66){?>
		<div class="gadget">
			<div id='cssmenu'>
				<ul>
				   <li class='active'><a href='#'><span>NETWORK PANEL</span></a></li>
				   <li class='has-sub'><a href='#'><span>ENTRY FORM</span></a>
						<ul>
							<li><a href="<?php echo site_url('report/product_type_form') ?>">PRODUCT TYPE</a></li>
							<li><a href="<?php echo site_url('report/location_form') ?>">LOCATION</a></li>
							<li><a href="<?php echo site_url('report/location_detail_form') ?>">LOCATION DETAIL FORM</a></li>
							<li><a href="<?php echo site_url('report/product_user_form') ?>">PRODUCT USER</a></li>
							<li><a href="<?php echo site_url('report/networkProductEntryForm') ?>">PRODUCT ENTRY FORM</a></li>
							<li><a href="<?php echo site_url('report/networkProductReceive') ?>">PRODUCT RECEIVED FORM</a></li>							
							<li><a href="<?php echo site_url('report/product_dlv_form') ?>">PRODUCT DELIVERY FORM</a></li>

						</ul>
				   </li>
				   <li class='has-sub'><a href='#'><span>ENTRY LIST</span></a>
						<ul>
							<li><a href="<?php echo site_url('report/product_list') ?>">PRODUCT TYPE LIST</a></li>
							<li><a href="<?php echo site_url('report/location_list') ?>">LOCATION LIST</a></li>
							<li><a href="<?php echo site_url('report/location_details_list') ?>">LOCATION DETAIL LIST</a></li>
							<li><a href="<?php echo site_url('report/product_user_list') ?>">USER LIST</a></li>
							<li><a href="<?php echo site_url('report/workstationList') ?>">WORKSTATION LIST</a></li>
							<li><a href="<?php echo site_url('report/networkProductEntryList') ?>">PRODUCT LIST</a></li>
							<li><a href="<?php echo site_url('report/networkProductReceiveList') ?>">PRODUCT RECEIVED LIST</a></li>
							<li><a href="<?php echo site_url('report/networkProductDeliveryList') ?>">PRODUCT DELIVERY LIST</a></li>

						</ul>
				   </li>
				    <li class='has-sub'><a href='#'><span>REPORTS</span></a>
						<ul>
							<li><a href="<?php echo site_url('report/workstationReport') ?>">WORKSTATION REPORT</a></li>
							<li><a href="<?php echo site_url('report/product_report_search') ?>">PRODUCT REPORT</a></li>
						</ul>	
					</li>
					<li class='has-sub'><a href='#'><span>ACCOUNT SETTING</span></a>
					  <ul>						
						<li><a href="<?php echo site_url('login/myPasswordChange') ?>">PASSWORD CHANGE</a></li>
						<?php  if($lid=="nadmin"){?>
							<li><a href="<?php echo site_url('report/userList') ?>">USER LIST</a></li>
							<li><a href="<?php echo site_url('report/usrCreationForm') ?>">CREATE USER</a></li>												
						<?php }?>
					  </ul>
				   </li>
				</ul>
			</div>		
		</div>
		<?php } ?>
      <!--Network  END-->
	  
	  <!--Billing Start-->
		<?php 
		$lid = $this->session->userdata('login_id');
		if($this->session->userdata('section')==19 && $this->session->userdata('org_Type_id')==5){?>
		<div class="gadget">
			<div id='cssmenu'>
				<ul>
					<li class='active'><a href='#'><span>BILLING PANEL</span></a></li>
					<li class='has-sub'><a href='#'><span>IGM OPERATION</span></a>
					  <ul>
						<li><a href="<?php echo site_url('igmViewController/viewIgmGeneral/GM') ?>" target="_BLANK">View IGM General Information</a></li>
						<li><a href="<?php echo site_url('igmViewController/viewIgmGeneral/BB') ?>" target="_BLANK">View IGM Break Bulk Information</a></li>
						<li><a href="<?php echo site_url('igmViewController/myIGMContainer') ?>" target="_BLANK">IGM Container List</a></li>
						<li><a href="<?php echo site_url('igmViewController/checkTheIGM') ?>">Check The IGM</a></li>
						<li><a href="<?php echo site_url('igmViewController/updateManifest') ?>">Convert IGM</a></li>
						<!--li><a href="<?php echo site_url('uploadExcel/convertCopino') ?>">Convert COPINO</a></li-->
						<li><a href="<?php echo site_url('report/myExportCommodityForm') ?>">Convert EXPORT-COMMODITY</a></li>
						<li><a href="<?php echo site_url('igmViewController/checkTheIGM') ?>">Check The IGM</a></li>
						<li><a href="<?php echo site_url('igmViewController/viewIGM') ?>">View IGM</a></li>
						<li><a href="<?php echo site_url('report/convertIgmCertifySection') ?>">Convert Igm to Certify Section</a></li>
						<li><a href="<?php echo site_url('report/onestopCertifySection') ?>">Location \ Certify</a></li>
						<li><a href="<?php echo site_url('report/myRountingPointCodeList') ?>" target="_BLANK">Routing Points</a></li>
						<li><a href="<?php echo site_url('report/myViewBreakBulkList') ?>" target="_BLANK">Break Bulk IGM Info</a></li>
						
						<?php  
						$lid = $this->session->userdata('login_id');
						//echo $lid;
						if($lid=="sazam" or $lid=="mdibrahim" or $lid=="popy" or $lid=="Shepu" or $lid=="tipai" or $lid=="shopna" or $lid=="norin"  or $lid=="anikcpa" or $lid=="IBRAHIM") { ?>
						 <li><a href="<?php echo site_url('report/myoffDociew') ?>" target="_BLANK">OFFDOCK INFORMATION</a></li>
						 <li><a href="<?php echo site_url('report/commodityInfoView') ?>" target="_BLANK">COMMODITY INFORMATION</a></li>					 
						<!--li><a href="<?php echo site_url('uploadExcel') ?>">EXCEL UPLOAD FOR COPINO</a></li-->
						<?php						
							$str = "select count(distinct rotation) as cnt from ctmsmis.mis_exp_unit_preadv_req where preAddStat=1 and date(last_update)=date(now())";
							$result = mysql_query($str,$con_sparcsn4);
							$row = mysql_fetch_object($result);
							$badge = $row->cnt;		
						?>
						<li class="badge1" data-badge="<?php echo $badge;?>"><a href="<?php echo site_url('uploadExcel/preAdvisedRotList') ?>">Today's Pre-Advised Rotation</a></li>
						<?php mysql_close($con_sparcsn4);?>
						<?php
							include("mydbPConnection.php");
							$str = "select count(id) as cnt from edi_stow_info where file_status=0";
							
							$result = mysql_query($str);
							$row = mysql_fetch_object($result);
							$badge = $row->cnt;
							//echo "TEST : ".$badge;
						?>
						<li class="badge1" data-badge="<?php echo $badge;?>"><a href="<?php echo site_url('uploadExcel/todays_edi_declaration') ?>">Today's EDI Declaration</a></li>
						<?php 
						mysql_close($cchaportdb);
						include("dbConection.php");
						?>
						
						<li><a href="<?php echo site_url('uploadExcel/convertCopino') ?>">Convert COPINO</a></li>
					<?php } ?>
					  </ul>
					</li>
					<li class='has-sub'><a href='#'><span>IGM REPORTS</span></a>
						<ul>
							<li><a href="<?php echo site_url('report/myIGMReport') ?>">IGM REPORTS</a></li>
							<li><a href="<?php echo site_url('report/myIGMBBReport') ?>">IGM REPORTS BREAK BULK</a></li>
							<li><a href="<?php echo site_url('report/myIGMFFReport') ?>">IGM SUPLEMENTARY REPORTS</a></li>
							<li><a href="<?php echo site_url('report/myIGMFFReport') ?>">IGM SUPLEMENTARY BREAK BULK REPORTS</a></li>
							<li><a href="<?php echo site_url('report/myICDManifest') ?>">ICD MENIFEST</a></li>
							<li><a href="<?php echo site_url('report/myDGManifest') ?>">DG MENIFEST</a></li>
							<li><a href="<?php echo site_url('report/myLCLManifest') ?>">LCL MENIFEST</a></li>
							<li><a href="<?php echo site_url('report/myFCLManifest') ?>">FCL MENIFEST</a></li>
							<li><a href="<?php echo site_url('report/myDischargeList') ?>">DISCHARGE LIST</a></li>
							<li><a href="<?php echo site_url('report/RequestForPreAdviceReport') ?>">REQUEST FOR PREADVICE CONTAINER LIST</a></li>
							<li><a href="<?php echo site_url('report/ImportContainerSummery') ?>">Summary Of Import Container(MLO,Size,Height) Wise</a></li>
							<li><a href="<?php echo site_url('report/mloDischargeSummery') ?>">MLO DISCHARGE SUMMARY LIST</a></li>
							<li><a href="<?php echo site_url('report/') ?>">FEEDER DISCHARGE SUMMARY LIST</a></li>
							<li><a href="<?php echo site_url('report/OffDockContainerList') ?>">OFFDOCK DESTINATION WISE CONTAINER LIST </a></li>
							<li><a href="<?php echo site_url('report/depotLadenContForm') ?>">DEPOT LADEN CONTAINER</a></li>
							<li><a href="<?php echo site_url('report/mis_assignment_report_search') ?>">MIS ASSIGNMENT REPORT</a></li>
				
						</ul>
					</li>
					 <li class='has-sub'><a href='#'><span>REEFER REPORT</span></a>
						<ul>
							<li><a href="<?php echo site_url('report/myRefferImportContainerDischargeReport') ?>">YARD WISE REEFER IMPORT CONTAINER</a></li>
							<li><a href="<?php echo site_url('report/vesslWiseRefeerContainerList') ?>">VESSEL WISE REEFER CONTAINER LIST </a></li>
							<li><a href="<?php echo site_url('report/myWaterSupplyInVesselsReportForm') ?>">WATER SUPPLY IN VESSELS</a></li>
							<li><a href="<?php echo site_url('report/myContainerHistoryReportForm') ?>">CONTAINER HISTORY REPORT</a></li>
						</ul>
					</li>
					<li class='has-sub'><a href='#'><span>ICD</span></a>
						<ul>
							<li><a href="<?php echo site_url('report/icdInboundOutboundContainerReport')?>">ICD INCOMING OUTCOMING CONTAINER REPORT</a></li>
							<li><a href="<?php echo site_url('report/icdContainerReportByRotation') ?>">ICD CONTAINER BY ROTATION</a></li>
						</ul>
					</li>
					<li class='has-sub'><a href='#'><span>EXPORT REPORTS</span></a>
						  <ul>
							<li><a href="<?php echo site_url('report/viewVesselListStatus') ?>">VESSEL LIST WITH EXPORT APPS LOADING REPORT</a></li>
							<li><a href="<?php echo site_url('report/commentsSearchForVessel') ?>"><span class="blink_me">COMMENTS BY SHIPPING SECTION ON EXPORT VESSEL</span></a></li>
							<li><a href="<?php echo site_url('report/last24HoursERForm') ?>">LAST 24 HOUR'S EIR POSITION</a></li>
							<li><a href="<?php echo site_url('report/workDone24hrsForm') ?>">LAST 24 HRS. CONTAINER HANDLING REPORT</a></li>
							<li><a href="<?php echo site_url('report/myExportImExSummery') ?>">MLO WISE EXPORT SUMMARY</a></li>
							<li><a href="<?php echo site_url('report/mloWiseFinalDischargingExportFormForCPA') ?>">MLO WISE FINAL LOADING EXPORT APPS</a></li>
							<li><a href="<?php echo site_url('report/mloWiseFinalDischargingExportFormForCPAN4') ?>">MLO WISE FINAL LOADING EXPORT</a></li>	
							<li><a href="<?php echo site_url('report/assignment_sheet_for_pangaon') ?>">ASSIGNMENT SHEET FOR OUTWARD PANGAON ICT CONTAINER</a></li>					
							 <?php  
							$lid = $this->session->userdata('login_id');
							if($lid=="porikkhit") { ?>
							<li><a href="<?php echo site_url('report/stuffingContainerListForm') ?>">LAST 24 HOURS STUFFING CONTAINER LIST</a></li>
							<li><a href="<?php echo site_url('report/last24hrsOffDockStatementoforAdminForm') ?>">LAST 24 STATEMENT LIST</a></li>		
							<li><a href="<?php echo site_url('uploadExcel/last24hrsStatements') ?>">LAST 24 STATEMENT</a></li>
							<!--li><a href="<?php echo site_url('uploadExcel/last24hrsStatementList') ?>">LAST 24 STATEMENT LIST</a></li-->
							<li><a href="<?php echo site_url('report/stuffingPermissionForm') ?>">STUFFING PERMISSION FORM</a></li>
							<?php } ?>
						  </ul>
					</li>
					<li class='has-sub'><a href='#'><span>IMPORT REPORTS</span></a>
						  <ul>
								<li><a href="<?php echo site_url('report/assignmentAllReportForm') ?>">ALL ASSAIGNMENT/DELIVERY EMPTY DETAILS</a></li>
								<li><a href="<?php echo site_url('report/yardWiseContainerHandlingDetailsRptForm') ?>">CURRENT YARD LYING CONTAINER REPORT</a></li>
								<li><a href="<?php echo site_url('report/yardWiseContainerHandlingRptForm') ?>">YARD WISE CONTAINER RECEIVE REPORT</a></li>
								<li><a href="<?php echo site_url('report/yardWiseContainerDeliveryRptForm') ?>">YARD WISE CONTAINER DELIVERY REPORT</a></li>
								<li><a href="<?php echo site_url('report/containerPositionEntryForm') ?>">CONTAINER POSITION ENTRY</a></li>
								<li><a href="<?php echo site_url('report/blockWiseRotation') ?>">IMPORT DISCHARGE REPORT BY APPS</a></li>	
								<li><a href="<?php echo site_url('report/offDockRemovalPositionForm') ?>">OFFDOCK REMOVAL CONTAINER</a></li>
								<li><a href="<?php echo site_url('report/countryWiseImportReport') ?>">COUNTRY WISE IMPORT REPORT</a></li>
								<li><a href="<?php echo site_url('report/yearWiseImportReport') ?>">YEAR WISE IMPORT REPORT</a></li>
								<li><a href="<?php echo site_url('report/mloWiseFinalDischargingImportFormForCPA') ?>">MLO WISE FINAL DISCHARGING IMPORT</a></li>

								<li><a href="<?php echo site_url('report/removal_list_form/overflow') ?>">REMOVAL LIST OF OVERFLOW YARD</a></li>
								<li><a href="<?php echo site_url('report/removal_list_form/all') ?>">LIST OF CTMS ASSIGNMENT</a></li>
						  </ul>
				   </li>
				   <li class='has-sub'><a href='#'><span>GATE REPORTS</span></a>
						<ul>
							<li><a href="<?php echo site_url('report/offhireSummaryAndDetails') ?>" target="_blank" >OFFHIRE SUMMARY AND DETAILS</a></li>
							<li><a href="<?php echo site_url('gateController/gateWiseContainerRegister')?>">GATEWISE INWARD & OUTWARD CONTAINER REGISTER</a></li>

						</ul>
					</li>
					<li class='has-sub'><a href='#'><span>PANGOAN REPORTS</span></a>
						<ul>
							<li><a href="<?php echo site_url('report/pangoanLoadingExportForm') ?>">PANGOAN LOADING EXPORT</a></li>	
							<li><a href="<?php echo site_url('report/pangoanDischargeForm') ?>">PANGOAN DISCHARGE</a></li>
						</ul>
					</li>
					<li class='has-sub'><a href='#'><span>ACCOUNT SETTING</span></a>
					  <ul>						
						<li><a href="<?php echo site_url('login/myPasswordChange') ?>">PASSWORD CHANGE</a></li>
					  </ul>
				   </li>
				</ul>
			</div>		
		</div>
		<?php } ?>
      <!--Billing  END-->
	  <!--Security Panel Start-->
		<?php if($this->session->userdata('Control_Panel')==67&& $this->session->userdata('org_Type_id')==67){?>
		<div class="gadget">
			<div id='cssmenu'>
				<ul>
					<li class='active'><a href='#'><span>SECURITY PANEL</span></a></li>
						<?php  
							$lid = $this->session->userdata('login_id');
							if($lid=="pass" or $lid=="ds" or $lid=="ddops" or $lid=="soops" or $lid=="opincharge") { ?>	
						<li class='has-sub'><a href='#'><span>ASSIGNMENT</span></a>
							 <ul>
								<li><a href="<?php echo site_url('report/assignmentAllReportForm') ?>">ALL ASSAIGNMENT/DELIVERY EMPTY DETAILS</a></li>
							</ul>
						</li>
						<li class='has-sub'><a href='#'><span>ACCOUNT SETTING</span></a>
							<ul>
								<li><a href="<?php echo site_url('login/myPasswordChange') ?>">PASSWORD CHANGE</a></li>
							</ul>
					   </li>
							<?php } else {?>	
						<li class='has-sub'><a href='#'><span>TRUCK ENTRY</span></a>
						 <ul>
							<li><a href="<?php echo site_url('report/cont_wise_truck') ?>">CONTAINER WISE TRUCK ENTRY</a></li>
							<li><a href="<?php echo site_url('report/containerBarcodeSearch') ?>">CONTAINER SEARCH(BARCODE GENERATOR)</a></li>
							<li><a href="<?php echo site_url('report/containerListForSecurity') ?>" >CONTAINER AND TRUCK ENTRY LIST</a></li>

						</ul>
						</li>
						<li class='has-sub'><a href='#'><span>ACCOUNT SETTING</span></a>
							<ul>
							<li><a href="<?php echo site_url('login/myPasswordChange') ?>">PASSWORD CHANGE</a></li>
							</ul>
					   </li>
						<li class='has-sub'><a href='#'><span>HEAD DELIVERY</span></a>
							<ul>
								<li><a href="<?php echo site_url('report/xml_conversion') ?>">BILL OF ENTRY LIST</a></li>
								<li><a href="<?php echo site_url('report/ocr_container_info') ?>" target="_blank">OCR CONTAINER LIST</a></li>
								<!--li><a href="<?php echo site_url('report/date_wise_be_report') ?>">DATE WISE Bill of Entry REPORT</a></li>
								<li><a href="<?php echo site_url('report/head_delivery') ?>">CONTAINER SEARCH & TRUCK ENTRY</a></li-->	
							</ul>
						</li>
					<li class='has-sub'><a href='#'><span>OCR</span></a>
						<ul>						
							<li><a href="<?php echo site_url('report/ocr_report_form') ?>">OCR REPORT</a></li>
						</ul>
					</li>
					<?php } ?>	
				</ul>
			</div>
		</div>
		<?php } ?>
      <!--Security Panel END-->
	<?php mysql_close($con_sparcsn4);?>
	<?php mysql_close($con_cchaportdb);?>