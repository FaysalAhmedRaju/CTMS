
<script language="JavaScript">

function changeTextBox(v)
{
	    var search_value = document.getElementById("search_value");
		var fromdate = document.getElementById("fromdate");
		var todate = document.getElementById("todate");
		if(v=="dateRange")
		{
			search_value.disabled=true;
			fromdate.disabled=false;
			todate.disabled=false;
		
		}	
		else if(v=="")
		{
			search_value.disabled=true;
			fromdate.disabled=true;
			todate.disabled=true;
		}
		else 
		{
			search_value.disabled=false;
			fromdate.disabled=true;
			todate.disabled=true;		
		}
}
</script>

<div class="content">
    <div class="content_resize_1">
      <div class="mainbar_1">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <span><?php echo $myUpdateManifestList; ?></span>
		  <div class="clr"><?php echo $msg?></div>
		  
		  <?php 
		  $attributes = array('id' => 'myform','target'=>'_BLANK');
		  //,'target'=>'_BLANK'
		  echo form_open(base_url().'index.php/report/gateReportViewPdf',$attributes);
			$Stylepadding = 'style="padding: 12px 20px;"';
				if(!empty($error_message))
				{
					$Stylepadding = 'style="padding:25px 20px;"';
				}	
				if(isset($captcha_image)){
					$Stylepadding = 'style="padding:62px 20px 93px;"';
				}?>
	
		<div class="img">
		 	 <!--<div id="login_container">-->
		 <table style="border:solid 1px #ccc;" width="650px" align="center" cellspacing="0" cellpadding="0">
				<tr><td>	 
		 <table align="center" border=0>	
								<tr>
									<td align="left" >
									<label for=""><font color='red'></font>Search By :<em>&nbsp;</em></label></td>
									<td>
									        <select name="search_by" id="search_by" class="" onchange="changeTextBox(this.value);">
												<option value="" label="search_by" selected style="width:110px;">---Select-------</option>
												<option value="vNum" label="Verification Number" >Verification Number</option>
												<option value="dateRange" label="Date Range" >Date Range</option>												
											</select>

									</td>
								</tr>
								 <tr>
									<td align="left" ><label for=""><font color='red'></font><nobr>Verification No :<nobr><em>&nbsp;</em></label></td>
									<td>
									<input type="text" style="width:150px;" id="search_value" name="search_value" disabled> 
									</td>
								</tr>	


                                <tr colspan="4">
									   <td align="left" ><label><font color='red'></font>From Date:</label></td>
										<td>
										 <input type="text" style="width:130px;" id="fromdate" name="fromdate" value="<?php date("Y-m-d"); ?>" disabled />
										</td>
											<script>
											 $(function() {
											 $( "#fromdate" ).datepicker({
											  changeMonth: true,
											  changeYear: true,
											  dateFormat: 'yy-mm-dd', // iso format
											 });
											 });
											</script>
				
									   <td align="left" ><label><font color='red'></font><nobr>To Date:</nobr></label></td>
										<td>
										 <input type="text" style="width:130px;" id="todate" name="todate" value="<?php date("Y-m-d"); ?>" disabled />
										</td>
											<script>
											 $(function() {
											 $( "#todate" ).datepicker({
											  changeMonth: true,
											  changeYear: true,
											  dateFormat: 'yy-mm-dd', // iso format
											 });
											 });
											</script>
								</tr>

						<tr align="center">
							<td colspan="4" align="center" width="70px">
							<?php $arrt = array('name'=>'report','id'=>'submit','value'=>'Search','class'=>'login_button'); echo form_submit($arrt);?>	
							</td>
						</tr>
				</table>
			</td>
		</tr>
		<tr><td align="center" colspan="2"><font color=""><b>
		<?php if($verify_number>0 or $verify_num>0)
				{ echo "<font color='green'><b>VERIFY NUMBER IS ".$verify_num."</b></font>";} 			 
			  else 
				{ echo $msg;}?>
		</b></font></td></tr>
		<!--TR align="center"><TD colspan="6" ><h2><span ><?php echo "Verify No: ".$verify_num; ?></span> </h2></TD></TR-->
	</table>
	<?php echo form_close()?>
	<?php
/*****************************************************
Developed BY: Sourav Chakraborty
Software Developer
DataSoft Systems Bangladesh Ltd
******************************************************/

$_SESSION['Control_Panel']=$this->session->userdata('Control_Panel');

?>

<div style="width:100%; height:500px; overflow-y:auto;">
<table border="0"  width="100%" bgcolor="#FFFFFF" align="center">
	<!--<TR align="center"><TD colspan="6" ><h2><span ><?php echo $title; ?></span> </h2></TD></TR>-->
	
	
	<TR><TD align="center">
	
		<table border=0 cellspacing="2" cellpadding="1" bdcolor="#ffffff">
		<!--tr class="gridDark" >
			<td align="center">Action/Verify No.</td>
			<td align="center">W/R Up To</td>
			<td align="center">Bill</td>
			<!--td align="center">SL</td>
			<td align="center">Gate Out Date & Time</td>
			<td align="center">Container</td>
			<td align="center">Receive Pack</td>
			<td align="center">Marks & Number</td>
			<td align="center">Consignee Description</td>
			<td align="center">Notify Description</td>			
			<td align="center" >Yard</td>
			<td align="center">Position</td>
			<td align="center">Cont. Type</td>
			<td align="center">Status</td>
			<td align="center">Discharge Time</td>
			<td align="center">Dest.</td>
			<td align="center">Offdock Name</td>
			<td align="center">Rotation</td>
			<!--<td align="center">Vessel Name</td>
			<td align="center">Master BL</td>
			<td align="center">Sub BL</td>>
			<td align="center">Seal</td>
			<td align="center">Size</td>
			<td align="center">Height</td>
		</tr-->
		
		
		
		
		
						<!--tr class="gridLight">
						<th>Status</th><th>:</th><td><?php print($rtnContainerList[$i]['cont_status']); ?></td>
						<th>Discharge Time</th><th>:</th><td><?php print($rtnYardPosition->fcy_time_in); ?></td>
						<th>Dest.</th><th>:</th><td><?php print($rtnContainerList[$i]['off_dock_id']); ?></td>

					</tr>
					<tr class="gridLight">
					
						<th>Offdock Name</th><th>:</th><td><?php print($rtnContainerList[$i]['offdock_name']); ?></td>
						
						<th>Seal</th><th>:</th><td><?php print($rtnContainerList[$i]['cont_seal_number']); ?></td>
					</tr>
					<tr class="gridLight">
						<th>Size</th><th>:</th><td><?php print($rtnContainerList[$i]['cont_size']); ?></td>
						<th>Height</th><th>:</th><td><?php print($rtnContainerList[$i]['cont_height']); ?></td>

					</tr-->
		
		<!--tr><td colspan="16" align="center"><?php echo "Total Container: ". $j;?></td></tr-->
		<!--<tr><td colspan="16" align="left"><?php if($totcontainerNo) echo  $totcontainerNo; else echo "&nbsp;"; ?></td></tr>-->
	</table>
	<br/>
	<!--form action="<?php echo site_url('report/lclAssignmentVerify');?>" method="POST" name="myChkForm" onsubmit="return(validate());">
		<input type="hidden"value="<?php echo  $verify_id?>" name="verify_id" style="width:200px;"/>
		<input type="hidden"value="<?php echo  $verify_num?>" name="verify_num" style="width:200px;"/>
		<input type="hidden"value="<?php echo  $ddl_imp_rot_no?>" name="verify_rot" style="width:200px;"/>
		<input type="hidden"value="<?php echo  $ddl_bl_no?>" name="verify_bl" style="width:200px;"/>
		<table border=0 cellspacing="2" cellpadding="1"  width="80%" bgcolor="#2AB1D6">
			
			<tr class="gridDark">
				<th>C&f License</th><th>:</th><td><input type="text" id="strCnfLicense" value="<?php echo  $rtnContainerList[$i]['cnf_lic_no']?>" name="strCnfLicense" onblur="getCnfCode(this.value)" style="width:200px;"/></td>
				<th>C&f Name</th><th>:</th><td><input type="text" id="strCnfCode" value="<?php echo $cnf_name;?>" name="strCnfCode" style="width:200px;"/></td>
			</tr>
			<tr class="gridLight" >
				<th>Agent DO</th><th>:</th><td ><input type="text"value="<?php echo  $rtnContainerList[$i]['agent_do']?>" name="strAgentDo" style="width:200px;"/></td>
				<th>DO Date</th><th>:</th>
					<td>
						<input type="text" id="strDoDate" value="<?php echo  $rtnContainerList[$i]['do_date']?>" name="strDoDate" style="width:200px;"/>
						<script>
							$(function() {
							 $( "#strDoDate" ).datepicker({
							  changeMonth: true,
							  changeYear: true,
							  dateFormat: 'yy-mm-dd', // iso format
							 });
							 });
						</script>
					</td>

			</tr>
			<tr class="gridDark">
				<th>BE No</th><th>:</th><td><input type="text" value="<?php echo  $rtnContainerList[$i]['be_no']?>" name="strBEno" style="width:200px;"/></td>
				<th>BE Date</th><th>:</th>
					<td>
						<input type="text" id="strBEdate" value="<?php echo  $rtnContainerList[$i]['be_date']?>" name="strBEdate" style="width:200px;"/>
						<script>
							$(function() {
							 $( "#strBEdate" ).datepicker({
							  changeMonth: true,
							  changeYear: true,
							  dateFormat: 'yy-mm-dd', // iso format
							 });
							 });
						</script>
					</td>
										
			</tr>
			<tr class="gridDark">
				
				<th>W/R UP TO DATE</th><th>:</th>
					<td>
						<input type="text" id="strWRdate" value="<?php echo  $rtnContainerList[$i]['wr_upto_date']?>" name="strWRdate" style="width:200px;"/>
						<script>
							$(function() {
							 $( "#strWRdate" ).datepicker({
							  changeMonth: true,
							  changeYear: true,
							  dateFormat: 'yy-mm-dd', // iso format
							 });
							 });
						</script>
					</td>
					<th>Tonnage Update</th><th>:</th><td><input type="text" value="<?php echo  $rtnContainerList[$i]['update_ton']?>" name="strTonUpdt" style="width:200px;"/></td>					
			</tr>
			
			
		</table>
	</form-->

		
	
</TD></TR>
<br/>
<?php 
mysql_close($con_cchaportdb);?>
</table>
</div>



		 <!--</div>-->
		 </div>
         
		  </form>
          <div class="clr"></div>
        </div>
       
       <!-- <p class="pages"><small>Page 1 of 2</small> <span>1</span> <a href="#">2</a> <a href="#">&raquo;</a></p>-->
      </div>
      <div class="sidebar" >
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	
  </div>