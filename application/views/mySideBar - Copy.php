 <?php if($this->session->userdata('Control_Panel')==56) {?>
	 <div class="gadget">
		<h2 class="star">IGM INFORMATION</h2>
		  <ul class="sb_menu">
			<li><a href="<?php echo site_url('report/myVesselList') ?>">Vessel List</a></li>
		  </ul>
	</div>
	<?php }else {?>
	
	<div class="gadget">
		<?php if($this->session->userdata('Control_Panel')!=22){ ?>
            
			<h2 class="star"><span>IGM</span> OPERATION</h2>
		<?php } ?>
		<div class="clr"></div>
		<ul class="sb_menu">
			<?php if($this->session->userdata('Control_Panel')!=22){ ?>
            <li><a href="<?php echo site_url('igmViewController/viewIgmGeneral/GM') ?>" target="_BLANK">View IGM General Information</a></li>
			<li><a href="<?php echo site_url('igmViewController/viewIgmGeneral/BB') ?>" target="_BLANK">View IGM Break Bulk Information</a></li>
			<?php } ?>
		   <?php if($this->session->userdata('Control_Panel')==12 && $this->session->userdata('login_id')!="cpaops") { ?>
			<li><a href="<?php echo site_url('igmViewController/myIGMContainer') ?>" target="_BLANK">IGM Container List</a></li>
            <li><a href="<?php echo site_url('igmViewController/checkTheIGM') ?>">Check The IGM</a></li>
            <li><a href="<?php echo site_url('igmViewController/updateManifest') ?>">Convert IGM</a></li>
			<li><a href="<?php echo site_url('uploadExcel/convertCopino') ?>">Convert COPINO</a></li>
			<li><a href="<?php echo site_url('report/myExportCommodityForm') ?>">Convert EXPORT-COMMODITY</a></li>
          <!--  <li><a href="<?php echo site_url('igmViewController/viewImporterList/-') ?>">View Importer List</a></li>
            <li><a href="<?php echo site_url('igmViewController/viewExporterList/-') ?>">View Exporter List</a></li>-->
            <!--<li><a href="<?php echo site_url('igmViewController/myDBDelivery') ?>">Delivery Dash Board Import</a></li>-->
			<?php } ?>
			<?php if($this->session->userdata('login_id')=="cpaops") { ?>
			<li><a href="<?php echo site_url('igmViewController/checkTheIGM') ?>">Check The IGM</a></li>
			<li><a href="<?php echo site_url('igmViewController/viewIGM') ?>">View IGM</a></li>
			<?php } ?>
		</ul>  
        
<?php if($this->session->userdata('Control_Panel')==12 && $this->session->userdata('login_id')!="cpaops") { ?>

	<h2 class="star">REEFER REPORT </h2>
    <div class="clr"></div>
    <ul class="sb_menu">
		<li><a href="<?php echo site_url('report/myRefferImportContainerDischargeReport') ?>">YARD WISE REEFER IMPORT CONTAINER</a></li>
		<li><a href="<?php echo site_url('report/vesslWiseRefeerContainerList') ?>">VESSEL WISE REEFER CONTAINER LIST </a></li>
		<li><a href="<?php echo site_url('report/myWaterSupplyInVesselsReportForm') ?>">WATER SUPPLY IN VESSELS</a></li>
		<li><a href="<?php echo site_url('report/myContainerHistoryReportForm') ?>">CONTAINER HISTORY REPORT</a></li>
	</ul>

<?php } ?>
</div>

<div class="gadget">
		<?php if($this->session->userdata('Control_Panel')!=22){ ?>
          <h2 class="star"><span>REPORT</span> <span>IGM </span> OPERATION</h2>
		<?php } ?>
          <div class="clr"></div>
		
          <ul class="sb_menu">
		  <?php if($this->session->userdata('Control_Panel')==12 && $this->session->userdata('login_id')!="cpaops") { ?>		  
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
			<?php } ?>
			<!--Berth Panel List Start-->
		
		
	
			<?php if($this->session->userdata('Control_Panel')==61) { ?>
			<li><font color="blue" size="2"><b>IMPORT</b></font></a></li>
				<li><a href="<?php echo site_url('report/myBirthIGMList') ?>">VIEW BEARTH OPERATOR REPORT</a></li>
				<li><a href="<?php echo site_url('report/myImportContainerLoadingReportForm') ?>">IMPORT CONTAINER DISCHARGE(EXCEL)</a></li>
				<li><a href="<?php echo site_url('report/myImportContainerDischargeReport') ?>">IMPORT CONTAINER DISCHARGE REPORT( BALANCE AND DISCHARGE)</a></li>
				<li><a href="<?php echo site_url('report/myImportContainerDischargeReportlast24hours') ?>">IMPORT CONTAINER DISCHARGE REPORT( LAST 24 HOURS)</a></li>
				<li><a href="<?php echo site_url('report/myImportSummery') ?>">MLO WISE IMPORT SUMMARY(BERTH OPERATOR)</a></li>
				<li><a href="<?php echo site_url('report/myRequstEmtyContainerReport') ?>">ASSAIGNMENT/DELIVERY EMPTY DETAILS</a></li>
				<li><a href="<?php echo site_url('report/myRequstAssignmentEmtyContainerReport') ?>">ASSAIGNMENT/DELIVERY EMPTY SUMMARY </a></li>
				<li><a href="<?php echo site_url('report/OffDockContainerList') ?>">OFFDOCK DESTINATION WISE CONTAINER LIST </a></li>
			<?php } ?>
			
			<?php if($this->session->userdata('login_id')!="cpaops" && $this->session->userdata('Control_Panel')!=22){ ?>
				<li><a href="<?php echo site_url('report/mloDischargeSummery') ?>">MLO DISCHARGE SUMMARY LIST</a></li>
				<li><a href="<?php echo site_url('report/') ?>">FEEDER DISCHARGE SUMMARY LIST</a></li>
				<li><a href="<?php echo site_url('report/myBlockedContainerAllView') ?>" target="_blank">BLOCKED CONTAINER REPORT</a></li>
			<?php } ?>
			
			
			<?php if($this->session->userdata('Control_Panel')==61) { ?>
			<li><font color="blue" size="2"><b>EXPORT </b></font></a></li>
				<li><a href="<?php echo site_url('report/loadedContainerList') ?>">MLO WISE LOADED CONTAINER LIST </a></li>
				<li><a href="<?php echo site_url('report/mloWisePreadviceloadedContainerList') ?>">MLO WISE PREADVICE LOADED CONTAINER LIST </a></li>
				<li><a href="<?php echo site_url('report/destinationloadedContainerList') ?>">DESTINATION WISE MLO LOADED CONTAINER LIST </a></li>
				<li><a href="<?php echo site_url('report/ExportContainerTobeLoadingReport') ?>">EXPORT  CONTAINER TO BE LOADED LIST</a></li>
				<li><a href="<?php echo site_url('report/myExportContainerLoadingReportForm') ?>">EXPORT CONTAINER LOADING(EXCEL)</a></li>
				<li><a href="<?php echo site_url('report/myExportContainerLoadingReport') ?>">LOADED CONTAINER LIST</a></li>
				<li><a href="<?php echo site_url('report/loadedFreightKindContainerList') ?>">LOADED CONTAINER LIST(LOAD & EMPTY)</a></li>
				<li><a href="<?php echo site_url('report/myExportImExSummery') ?>">MLO WISE EXPORT SUMMARY</a></li>
				
				<li><a href="<?php echo site_url('report/berthOperatorExportContainerHandlingReport') ?>">ROTATION WISE EXPORT CONTAINER</a></li>
				<li><a href="<?php echo site_url('report/myExportContainerNotFoundReport') ?>">EXPORT CONTAINER NOT FOUND REPORT</a></li>
				
				
				
				<li><a href="<?php echo site_url('report/myExportContainerBlockReport') ?>">EXPORT CONTAINER BLOCK REPORT</a></li>
				<li><a href="<?php echo site_url('report/myImportContainerDischargeReport') ?>">BERTH OPERATOR WISE EXPORT CONTAINER HANDLING</a></li>
			<?php 
				$path= 'http://'.$_SERVER['SERVER_ADDR'].'/myportpanel/resources/download/';
			?>
				<li><a href="<?php echo site_url('uploadExcel/uploadCoparnForm') ?>">EXCEL UPLOAD FOR COPARN</a></li>
				<li><a href="<?php echo site_url('uploadExcel') ?>">EXCEL UPLOAD FOR COPINO</a></li>
				<li><a href="<?php echo site_url('uploadExcel/bayView') ?>">EXPORT CONTAINER BAY VIEW</a></li>
				<li><a href="<?php echo site_url('report/blankBayForm') ?>">EXPORT BLANK BAY VIEW</a></li>
				<li><a href="<?php echo $path.'export_loading_app.apk';?>"><font color="blue" size="2"><b>EXPORT LOADING APP</b></font></a></li>
				<?php if($this->session->userdata('login_id')=="SAIFBO") { ?>
				<li><a href="<?php echo site_url('report/myRotationWiseContInfoForm') ?>">ROTATIN WISE CONTAINER INFORMATION</a></li>
				<!--<li><a href="<?php echo $path.'TIMS.rar';?>"><font color="blue" size="2"><b>TIMS DOWNLOAD LINK</b></font></a></li>-->
			<?php }} ?>
			
			<!--Berth Panel List End-->
			
			<?php if($this->session->userdata('Control_Panel')==12 && $this->session->userdata('login_id')!="cpaops") { ?>
				<li><a href="<?php echo site_url('report/ImportContainerSummery') ?>">Summary Of Import Container(MLO,Size,Height) Wise</a></li>
				<li><a href="<?php echo site_url('report/OffDockContainerList') ?>">OFFDOCK DESTINATION WISE CONTAINER LIST </a></li>
			<?php } ?>
		   
		   <?php if($this->session->userdata('login_id')=="cpaops") { ?>
				<li><a href="<?php echo site_url('report/IgmReportbyDescription') ?>">Report by Description of Goods</a></li>
				<li><a href="<?php echo site_url('report/IgmReportbyImporter') ?>">Report by Importer Name</a></li>
				<li><a href="<?php echo site_url('report/IgmReportbyContainer') ?>">Report by Container</a></li>
				<li><a href="<?php echo site_url('report/IgmReportbyBL') ?>">Report by BL No</a></li>
			<?php } ?>
			
			<?php if($this->session->userdata('Control_Panel')==28) { ?>
			<div class="gadget">
			<h2 class="star">ADMIN PANEL</h2>
			<ul class="sb_menu">
				<li><a href="<?php echo site_url('report/vslLayout') ?>">NEW VESSEL LAYOUT</a></li>
				<li><a href="<?php echo site_url('report/myExportContainerLoadingReport') ?>">LOADED CONTAINER LIST</a></li>
				</ul>  
			</div>
				
				
			<?php } ?>
          </ul>
		  
        </div>
		
		<div class="clr"></div>
		
       <!--OFFDOCK PANEL START-->
	   
	   
		
		<?php if($this->session->userdata('Control_Panel')==22 && $this->session->userdata('org_Type_id')==6){?>
		<div class="gadget">
		<h2 class="star">OFFDOCK PANEL</h2>
		<ul class="sb_menu">
			<li><a href="<?php echo site_url('uploadExcel/uploadBlockedContainerForm') ?>">EXCEL UPLOAD BLOCKED CONTAINER</a></li>
			<li><a href="<?php echo site_url('report/myBlockedContainerView') ?>" target="_blank">BLOCKED CONTAINER REPORT</a></li>
			</ul>  
		</div>
		<?php } ?>
			
		
		<?php } ?>
      <!--OFFDOCK PANEL END-->
       	<div class="gadget">
		<?php if($this->session->userdata('Control_Panel')!=22){ ?>
		 <h2 class="star"><span>LCL</span> <span>ASSIGMENT </span> </h2>
			<ul class="sb_menu">
				<li><a href="<?php echo site_url('report/myBirthIGMList') ?>">VIEW BEARTH OPERATOR REPORT</a></li>
				
			</ul>  
		<?php } ?>
	</div> 
        