<style>
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
<?php
/*****************************************************
Developed BY: Shemul Bhowmick
Sr. Software Engineer
DataSoft Systems Bangladesh Ltd
******************************************************/

$_SESSION['Control_Panel']=$this->session->userdata('Control_Panel');
?>
<!--<div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
		  
		
		
		<div class="img1">-->
		 	 <!--<div id="login_container">-->
			 
		<table border="0" width="100%">
			<TR align="center"><TD colspan="6" ><h2><span ><?php echo $title; ?></span> </h2></TD></TR>
			<TR align="left"><TD colspan="6" ><a href="<?php echo site_url('igmViewController/myPanelView') ?>"><img src="<?php echo IMG_PATH; ?>back.png" height="40px" width="40px" align="middle" hspace="5"/>Back to Control Panel</a></TD></TR>
			<TR><TD colspan="6"  id="lbl_SearchCriteria">
			
			<?php
				echo form_open(base_url().'index.php/igmViewController/myListSearch',$attributes);
				$Stylepadding = 'style="padding: 12px 20px;"';
				if(!empty($error_message))
				{
					$Stylepadding = 'style="padding:25px 20px;"';
				}	
				if(isset($captcha_image)){
					$Stylepadding = 'style="padding:62px 20px 93px;"';
				}
			?>
			Search&nbsp;&nbsp; 
			<?php 
				$location_options = array(
					'VName' =>'Vessel Name',
					'Voy' =>'Voyage No',
					'Import' =>'Import Rot',
					'Export' =>'Export Rot',
					'port' =>'Port of Shipment',
					'All' =>'All',
				);

				echo form_dropdown('SearchCriteria', $location_options, $this->input->post('SearchCriteria'));
			?>
			<?php 
				$attribute = array('name'=>'Searchdata','id'=>'SearchID','class'=>'login_input_text' );
				echo form_input($attribute,set_value('Searchdata'));
				//'onblur'=> "alert();"
			?>
			<?php $arrt = array('name'=>'SearchD','id'=>'submit','value'=>'Go','class'=>'login_button'); echo form_submit($arrt);?>
			<input type="hidden" name="type" value="<?php echo $type; ?>">
			<?php form_close();?>
					
			</TD></TR>
			
	
		<TR><TD colspan="6">
		<table border=0 cellspacing="1" cellpading="1" bdcolor="#ffffff">
		<tr class="gridDark"><td>Agent Type</td><td>Shipping Agent</td><td>License Number</td><td>Import Rotation No</td><td>Export Rotation No</td><td>Sailed Year</td><td>Sailed Date</td><td>Expected Date Of Arrival</td><td>Actual Berth Date</td><td>Final Entry Date</td><td>Vessel Name</td><td>Voy No</td><td>Net Tonnage</td><td>Name of Master</td><td>Port of Depart</td><td>Port of Destination</td><td>Submission Date</td><td>Action (Import)</td>
		
					<?php
					//
					if($_SESSION['Control_Panel']==7 or $_SESSION['Control_Panel']==6 or $_SESSION['Control_Panel']==12 or $_SESSION['Control_Panel']==13 or $_SESSION['Control_Panel']==10 or $_SESSION['Control_Panel']==44 or $_SESSION['Control_Panel']==57 or $_SESSION['Control_Panel']==58 or $_SESSION['Control_Panel']==64)
					{
					?>
					<td>Action (Export)</td>
					<?php
					}
					?>
		
		<?php
		
		if($_SESSION['Control_Panel']==10)
		{
		// Custom
			print("<td>Accessibility</td><td>Accessibility</td><td>Update Vessel Information</td>");
		}
		?>
		
		</tr>
		
		
			
		<?php
			if($igmMasterList) {
			$len=count($igmMasterList);
			
			include_once("mydbPConnection.php");
			include_once("mydbPConnectionn4.php");
			$path= "http://".$_SERVER['SERVER_ADDR']."/myportpanel/resources/edi/";
							 //$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/edi/
            for($i=0;$i<$len;$i++)
			{
				$id=$igmMasterList[$i]['id'];
				$myrot=$igmMasterList[$i]['Import_Rotation_No'];
				
				$str_edi_file_name="SELECT file_name_edi,file_name_stow FROM edi_stow_info WHERE igm_masters_id='$id'";
				$rslt_edi_file_name=mysql_query($str_edi_file_name,$con_cchaportdb);
				$row_edi_file_name=mysql_fetch_object($rslt_edi_file_name);
				$edi_file_name=$row_edi_file_name->file_name_edi;
				$stow_file_name=$row_edi_file_name->file_name_stow;
				$nmrwFile = mysql_num_rows($rslt_edi_file_name);
				
				//---
				$strChkEdi = "select count(*) as rtnValue from edi_stow_info where ucase(file_name_edi)=ucase(concat(replace('$myrot','/','_'),'.edi'))";
				$ediSt = $this->bm->dataReturnDb1($strChkEdi);
				
				$strCntryCode = "select sparcsn4.vsl_vessels.country_code as rtnValue
				from sparcsn4.vsl_vessel_visit_details
				inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
				where ib_vyg='$myrot'";
				$CntryCode = $this->bm->dataReturn($strCntryCode);
				//---
				
				$strVvd = "SELECT vvd_gkey FROM sparcsn4.vsl_vessel_visit_details WHERE ib_vyg='$myrot'";
				$resVvd = mysql_query($strVvd,$con_sparcsn4);
				$rowVvd = mysql_fetch_object($resVvd);
				$vvdGkey = $rowVvd->vvd_gkey;
				$nmrwVvd = mysql_num_rows($resVvd);
				
		?>
			    <tr class="gridLight">
					<td><?php echo $igmMasterList[$i]['Submitee_Org_Type']; ?></td>
					<td><?php print($igmMasterList[$i]['org_name']); ?></td>
					<td><?php print($igmMasterList[$i]['S_Org_License_Number']); ?></td>
					<td><?php print($igmMasterList[$i]['Import_Rotation_No']); ?></td>
					<td><?php print($igmMasterList[$i]['Export_Rotation_No']); ?></td>
					<td><?php print($igmMasterList[$i]['Sailed_Year']); ?></td>
					<td><?php print($igmMasterList[$i]['Sailed_Date']); ?></td>
					<td><?php print($igmMasterList[$i]['ETA_Date']); ?></td>
					<td><?php print($igmMasterList[$i]['Actual_Berth']); ?></td>
					<td><?php print($igmMasterList[$i]['file_clearence_date']); ?></td>
					<td><?php print($igmMasterList[$i]['Vessel_Name']); ?></td>
					<td><?php print($igmMasterList[$i]['Voy_No']); ?></td>
					<td><?php print($igmMasterList[$i]['Net_Tonnage']); ?></td>
					<td><?php print($igmMasterList[$i]['Name_of_Master']); ?></td>
					<td><?php print($igmMasterList[$i]['Port_of_Shipment']); ?></td>
					<td><?php print($igmMasterList[$i]['Port_of_Destination']); ?></td>
					<td><?php print($igmMasterList[$i]['Submission_Date']); ?></td>
					
	
					<td>
					
					<?php
					if($nmrwVvd>0){
					?>
					<a href="<?php echo site_url('uploadExcel/impBayViewPerformed') ?>?vvdGkey=<?php echo $vvdGkey;?>" target="_BLANK" class="blink_me">Import Vessel Layout</a><br><hr>
					<?php
					}else{
					?>
					<span class="blink_me">Vessel Visit Not Created</span><br><hr>
					<?php
					}
					
					if($_SESSION['Control_Panel']==11)
					{
						if($row->file_clearence_date<"2013-09-03" or $row->file_clearence_date=="" )
						{
					?>
					<a href="home.php?myflag=106&CODE=<?php print($row->id); ?>&TM=<?php print($this->VD); ?>" >View IGM Sub Detail<a/><br><hr>
					<!--<a href='home.php?myflag=6194&CODE=<?php print($row->id);?>&SUBCODE=<?php print($row->Import_Rotation_No);?>&TM=<?php print($this->VD); ?>' style="color:blue">Upload IGM Sub(GM) from Excel File</a><br><hr>-->
					<?php }} else { ?>
					<a href="<?php echo site_url("igmViewController/myListForm/$id/$type") ?>" target="_BLANK">View IGM Sub Detail<a/><br><hr>
					<?php } ?>
					<?php 
					if($_SESSION['Control_Panel']==7 or $_SESSION['Control_Panel']==6 or $_SESSION['Control_Panel']==12 or $_SESSION['Control_Panel']==13 or $_SESSION['Control_Panel']==15 or $_SESSION['Control_Panel']==10 or $_SESSION['Control_Panel']==44 or $_SESSION['Control_Panel']==58)
					{
					//for egm general manifest
				
					if($type=='BB'){?>
					<!--for BB-->					
						<a href="<?php echo site_url("igmViewController/myListForm/$id/BTS") ?>" target="upper_top">View Break Bulk TS</a><br><hr>
						<a href="<?php echo site_url("igmViewController/myListForm/$id/BMT") ?>" target="upper_top">View Break Bulk EMPTY</a><br><hr>
						<a href="<?php echo site_url("igmViewController/myListForm/$id/BNIL") ?>" target="upper_top">View Break Bulk NIL</a><br><hr>
						<a href="<?php echo site_url("igmViewController/myListForm/$id/BAMS") ?>" target="upper_top">Break Bulk Arms,Ammunition and Explosiv(Container)</a><br><hr>
						<a href="<?php echo site_url("igmViewController/myListForm/$id/BPS") ?>" target="upper_top">View Break Bulk Provision And Store Supply(Container)</a><br><hr>
						<a href="<?php echo site_url("igmViewController/myListForm/$id/BROB") ?>" target="upper_top">View Break Bulk ROB IGM Detail</a><br><hr>
						<a href="<?php echo site_url("igmViewController/myListForm/$id/BRC") ?>" target="upper_top">View Break Bulk IGM Retention Cargo(Container)</a><br><hr>					
					<?php }} else print("&nbsp;");
					//FF
					if($_SESSION['Control_Panel']==11 or $_SESSION['Control_Panel']==57)
					{
						if($row->file_clearence_date<"2013-09-03")
						{
					?>
					<a href="home.php?myflag=46&MCODE=<?php print($row->id); ?>&TM=<?php print($this->VD); ?>&CType=C" target="upper_top">View IGM Supplementary Detail<a/><br><hr>
					<?php
						}
					}
					if($_SESSION['Control_Panel']==57 or $_SESSION['Control_Panel']==12 or $_SESSION['Control_Panel']==28)
					{
						if($_SESSION['Control_Panel']==57 or $_SESSION['Control_Panel']==28)
						{
					?>
						<a href="<?php echo site_url('uploadExcel/ediUpload/'.$id) ?>">EDI Upload</a><br><hr>
						<?php		
						}
						if($nmrwFile>0)
						{
							if($ediSt==0 and $CntryCode!="BD")
							{
								echo "<font color='red'>EDI not uploaded through myportpanel</font><br>";
							}
							else
							{
						?>
							<a href="<?php echo $path.$edi_file_name;?>" download="<?php echo $edi_file_name?>">EDI Download</a><br><hr>
							<a href="<?php echo $path.$stow_file_name;?>" download="<?php echo $stow_file_name?>">Stow Plan Download</a><br><hr>
					<?php
							}	
						}	
					}
					
					if($_SESSION['Control_Panel']==11)
					{	
						if($row->file_clearence_date<"2013-09-03"){
					?>
                    <a href="home.php?myflag=137&MCODE=<?php print($row->id); ?>&TM=<?php print($this->VD); ?>&CType=C">View & Delete IGM Supplementary Detail</a><br><hr>
		      			<?php
			
						}
					}
					?>
					<?php 
					$lid = $this->session->userdata('login_id');
					//echo $lid;
					if($lid =='devberth' or $lid =='SAIFBO') { ?>
						<a href="<?php echo $path.$edi_file_name;?>" download="<?php echo $edi_file_name?>">EDI Download</a><br><hr>
					<?php } ?>
			 <?php
					//if($this->VD=='GM')
					if(($type=='GM') && ($_SESSION['Control_Panel']==11))
					{
						if($row->file_clearence_date>"2013-09-03" or $row->file_clearence_date=="") 
						{		
					?>

		      <a href='home.php?myflag=6194&CODE=<?php print($row->id);?>&SUBCODE=<?php print($row->Import_Rotation_No);?>&TM=<?php print($this->VD); ?>' style="color:blue">Upload IGM Sub(GM) from Excel File</a><br><hr>
					<?php
			
						}
					}
					?>

					<?php
					//Custom,NBR & Intelligence
					if($_SESSION['Control_Panel']==10 or $_SESSION['Control_Panel']==63 or $_SESSION['Control_Panel']==58)
					{
						//if($this->VD!='SC'){
					?>
					<a href="home.php?myflag=46&MCODE=<?php print($row->id); ?>&TM=<?php print($this->VD); ?>&CType=C" target="upper_top">View IGM Supplementary Detail<a/><br><hr>
					<?php
					//}else { print("&nbsp;");
						//}
					}
					//CnF , Port, Off Dock, Dhaka ICD, Importer
					if($_SESSION['Control_Panel']==6 or $_SESSION['Control_Panel']==12 or $_SESSION['Control_Panel']==13 or $_SESSION['Control_Panel']==43 or $_SESSION['Control_Panel']==14)
					{		
					?>
					<!--<a href="home.php?myflag=46&MCODE=<?php print($row->id); ?>&TM=<?php print($this->VD); ?>&CType=M" target="upper_top">View IGM Supplementary Detail</a><br><hr>-->
					<a href="<?php echo site_url("igmViewController/myListFormSEasy/$id/$type/M") ?>" target="_BLANK">View IGM Supplementary Detail</a><br><hr>
					<?php
					}
					?>
					
					<?php
					// navy 
					if($_SESSION['Control_Panel']==44)
					{		
					?>
					<a href="home.php?myflag=46&MCODE=<?php print($row->id); ?>&TM=<?php print($this->VD); ?>&CType=N" target="upper_top">View IGM Supplementary Detail</a><br><hr>
					<?php
					}
					?>

					
					
					<?php
					if($_SESSION['Control_Panel']==7 or $_SESSION['Control_Panel']==6 or $_SESSION['Control_Panel']==12 or $_SESSION['Control_Panel']==13 or $_SESSION['Control_Panel']==10 or $_SESSION['Control_Panel']==44 or $_SESSION['Control_Panel']==58)
					{
					//for egm general manifest
					if($type=='GM'){
					?>
					<!--<a href="home.php?myflag=106&CODE=<?php //print($row->id); ?>&TM=ROB" target="upper_top">View IGM ROB Detail<a/><br><hr>
					<a href="home.php?myflag=106&CODE=<?php //print($row->id); ?>&TM=TS" target="upper_top">View IGM TS Detail<a/><br><hr>
					<a href="home.php?myflag=106&CODE=<?php //print($row->id); ?>&TM=MT" target="upper_top">View IGM EMPTY Detail<a/><br><hr>
					<a href="home.php?myflag=106&CODE=<?php //print($row->id); ?>&TM=ROB" target="upper_top">View IGM ROB Detail<a/><br><hr>
					<a href="home.php?myflag=106&CODE=<?php //print($row->id); ?>&TM=TS" target="upper_top">View IGM TS Detail<a/><br><hr>
					<a href="home.php?myflag=106&CODE=<?php //print($row->id); ?>&TM=MT" target="upper_top">View IGM EMPTY Detail<a/><br><hr>-->
						
						<a href="<?php echo site_url("igmViewController/myListForm/$id/TS") ?>" target="upper_top">View TS IGM Detail</a><br><hr>
						<a href="<?php echo site_url("igmViewController/myListForm/$id/MT") ?>" target="upper_top">View EMPTY IGM Detail</a><br><hr>
						<a href="<?php echo site_url("igmViewController/myListForm/$id/NIL") ?>" target="upper_top">View NIL IGM Detail</a><br><hr>
						<a href="<?php echo site_url("igmViewController/myListForm/$id/AMS") ?>" target="upper_top">Arms,Ammunition and Explosiv(Container)</a><br><hr>
						<a href="<?php echo site_url("igmViewController/myListForm/$id/PS") ?>" target="upper_top">Provision And Store Supply(Container)</a><br><hr>
						<a href="<?php echo site_url("igmViewController/myListForm/$id/ROB") ?>" target="upper_top">View ROB IGM Detail</a><br><hr>
						<a href="<?php echo site_url("igmViewController/myListForm/$id/RC") ?>" target="upper_top">View IGM Retention Cargo(Container)</a><br><hr>
						
					<?php
					}
					}
					?>
					

					<?php
					//Offdock
					if($_SESSION['Control_Panel']==13)
					{
					?>
						<a href="home.php?myflag=8115&key=rcv&CODE=<?php print($row->id);?>&TM=<?php print($this->VD);?>"><font color="blue">Upload Container (Recieved)</font></a><hr>
						<a href="home.php?myflag=8116&key=del&CODE=<?php print($row->id);?>&TM=<?php print($this->VD);?>"><font color="blue">Upload Container (Delivery)</font></a><hr>
					<?php
					}
					?>
					<?php
					//Port
					if($_SESSION['Control_Panel']==12 and $type=="GM")
					{
					?>
						<!--<a href="home.php?myflag=35&CODE=<?php print($row->id); ?>&TM=GM" target="upper_top">View IGM Classified<a/><br><hr>-->
					<?php
					}
					?>

					<?php
					if($_SESSION['Control_Panel']==12 and $type=="BB")
					{
					?>
						<!--<a href="home.php?myflag=35&CODE=<?php print($row->id); ?>&TM=BB" target="upper_top">View IGM Classified<a/><br><hr>-->
					<?php
					}
					?>
					
					</td>
					
					
					<?php
					if($_SESSION['Control_Panel']==7 or $_SESSION['Control_Panel']==6 or $_SESSION['Control_Panel']==12 or $_SESSION['Control_Panel']==13 or $_SESSION['Control_Panel']==10 or $_SESSION['Control_Panel']==44 or $_SESSION['Control_Panel']==58 or $_SESSION['Control_Panel']==64)
					{
					//for egm general manifest
					if($type=='GM'){
					
					?>
					<td>
						<a href="home.php?myflag=247&CODE=<?php print($row->id); ?>&TM=GM" target="upper_top">View EGM Sub Detail<a/><br><hr>
						<a href='home.php?myflag=247&CODE=<?php print($row->id);?>&TM=TS' target="upper_top">View TS EGM Detail</a><br><hr>
						<a href='home.php?myflag=247&CODE=<?php print($row->id);?>&TM=MT' target="upper_top">View EMPTY EGM Detail</a><br><hr>
						<a href='home.php?myflag=247&CODE=<?php print($row->id);?>&TM=NIL' target="upper_top">View NIL EGM Detail</a><br><hr>
						<a href='home.php?myflag=247&CODE=<?php print($row->id);?>&TM=AMS' target="upper_top">Arms,Ammunition and Explosiv(Container)</a><br><hr>
						<a href='home.php?myflag=247&CODE=<?php print($row->id);?>&TM=PS' target="upper_top">Provision And Store Supply(Container)</a><br><hr>
						<a href='home.php?myflag=247&CODE=<?php print($row->id);?>&TM=ROB' target="upper_top">View ROB EGM Detail</a><br><hr>
						<a href='home.php?myflag=295&CODE=<?php print($row->id);?>&TM=RC' target="upper_top">View EGM Retention Cargo(Container)</a><br><hr>
					</td>
					<?php
					//for egm break bulk
					}	else if($type=='BB'){
					
					?>
					<td>
						<a href="home.php?myflag=247&CODE=<?php print($row->id);?>&TM=BB" target="upper_top">View EGM Break Bulk Sub Detail<a/><br><hr>
						<a href='home.php?myflag=247&CODE=<?php print($row->id);?>&TM=BTS' target="upper_top">View TS EGM Break Bulk Detail</a><br><hr>
						<a href='home.php?myflag=247&CODE=<?php print($row->id);?>&TM=BMT' target="upper_top">View EMPTY EGM Break Bulk Detail</a><br><hr>
						<a href='home.php?myflag=247&CODE=<?php print($row->id);?>&TM=BNIL' target="upper_top">View NIL EGM Break Bulk Detail</a><br><hr>
						<a href='home.php?myflag=247&CODE=<?php print($row->id);?>&TM=BAMS' target="upper_top">Arms,Ammunition and Explosiv(Container)</a><br><hr>
						<a href='home.php?myflag=247&CODE=<?php print($row->id);?>&TM=BPS' target="upper_top">Provision And Store Supply(Container)</a><br><hr>
						<a href='home.php?myflag=247&CODE=<?php print($row->id);?>&TM=BROB' target="upper_top">View ROB EGM Break Bulk Detail</a><br><hr>
						<a href='home.php?myflag=295&CODE=<?php print($row->id);?>&TM=BRC' target="upper_top">View EGM Break Bulk Retention Cargo(Container)</a><br><hr>
					</td>
					<?php
					}
					}
					?>
					
					
			<?php
		
				if($_SESSION['Control_Panel']==10)
				{
				// Custom
					if(($row->Import_Rotation_No=='')&&($row->custom_approved==0))
					{
						print("<td><a href='home.php?myflag=413&master_id=$row->id&TM=$this->VD'>Assign Import Rotation Number</a><hr><a href='home.php?myflag=2008&CODE=$row->id&VD=$this->VD'>Port Clearance</a><hr><a href='home.php?myflag=447&master_id=$row->id&TM=$this->VD'>Approve The Given Information</a>");	
					if(($_SESSION['user_role_id']==3) && ($row->file_clearence_date==''))
						{	
							print("<hr><a href='home.php?myflag=2007&CODE=$row->id&VD=$this->VD'>Final Entry</a>");
						}
					print("</td>");
					}
					else if(($row->Import_Rotation_No=='')&&($row->custom_approved==1))
						{
						print("<td><a href='home.php?myflag=413&master_id=$row->id&TM=$this->VD'>Assign Import Rotation Number</a><hr><a href='home.php?myflag=2008&CODE=$row->id&VD=$this->VD'>Port Clearance</a><hr><a href='home.php?myflag=448&master_id=$row->id&TM=$this->VD'>Reject The Given Information</a>");
						if(($_SESSION['user_role_id']==3) && ($row->file_clearence_date==''))
						{	
							print("<hr><a href='home.php?myflag=2007&CODE=$row->id&VD=$this->VD'>Final Entry</a>");
						}
					print("</td>");
						
						
						
						}
					else if(($row->Import_Rotation_No)&&($row->custom_approved==0))
						{
						print("<td><a href='home.php?myflag=414&master_id=$row->id&TM=$this->VD'>Update Import Rotation Number</a><hr><a href='home.php?myflag=2008&CODE=$row->id&VD=$this->VD'>Port Clearance</a><hr><a href='home.php?myflag=447&master_id=$row->id&TM=$this->VD'>Approve The Given Information</a>");
						if(($_SESSION['user_role_id']==3) && ($row->file_clearence_date==''))
						{	
							print("<hr><a href='home.php?myflag=2007&CODE=$row->id&VD=$this->VD'>Final Entry</a>");
						}
					print("</td>");
						
						}
					else if(($row->Import_Rotation_No)&&($row->custom_approved==1))
						{
						print("<td><a href='home.php?myflag=414&master_id=$row->id&TM=$this->VD'>Update Import Rotation Number</a><hr><a href='home.php?myflag=2008&CODE=$row->id&VD=$this->VD'>Port Clearance</a><hr><a href='home.php?myflag=448&master_id=$row->id&TM=$this->VD'>Reject The Given Information</a>");
						if(($_SESSION['user_role_id']==3) && ($row->file_clearence_date==''))
						{	
							print("<hr><a href='home.php?myflag=2007&CODE=$row->id&VD=$this->VD'>Final Entry</a>");
						}
					print("</td>");
						}
					
					if($row->Export_Rotation_No=='')
						print("<td><a href='home.php?myflag=436&master_id=$row->id&TM=$this->VD'>Assign Export Rotation Number</a></td>");	
					else
						print("<td><a href='home.php?myflag=437&master_id=$row->id&TM=$this->VD'>Update Export Rotation Number</a></td>");			
					
			  ?>		
			<td><a href='home.php?myflag=202&Edit=yes&CODE=<?php print($row->id);?>&VD=<?php print($this->VD); ?>' style='color:blue'>Update</a></td>
			<?php }?>
		
	
			
		
				</tr>
		<?php	
			
			}	}
//print($_SESSION['Control_Panel']."ghghjghgjhhljhjlhj<hr>"); return;

		?>
	</table>
</TD></TR>
<TR><TD><p><?php echo $links; ?></p></TD></TR>
</table>
<!--</div>
 <div class="clr"></div>
        
           </div>
	
  </div>
      
      
      <div class="sidebar">
	   <?php // include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>

</div>
</div>-->
<?php
	//	include_once("myPageCreate.php");
	//	$myform = new myPageCreate();
	//	$myform->myListPage("$mySQL","home.php?myflag=101&VD=$this->VD");
?>