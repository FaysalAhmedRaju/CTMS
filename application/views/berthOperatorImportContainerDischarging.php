	 <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
		  
		  <?php 
		  $attributes = array('target' => '_blank', 'id' => 'myform');
		  
		  echo form_open(base_url().'index.php/report/myRefferImportContainerDischargeReportView',$attributes);
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
			 <table style="border:solid 1px #ccc;" width="300px" align="center" cellspacing="0" cellpadding="0">
				<tr><td>
				<table border="0" width="400px" align="center">
				
									<tr>
									<td align="right" colspan="2"></td>
								</tr>
								<tr>
									<tr>
									<td align="left">
									
										
										</td>
										<td>
										<table><tr>
										<td align="left">
										<label for="Excel" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Discharge</label>
										
									<?php 	$data = array(
													'name'        => 'options1',
													'id'          => 'options1',
													'value'       => 'dis',
													'checked'     => TRUE,
													'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
													);
										echo form_radio($data); ?>
									</td>
									<td align="left">
										<label for="HTML" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Delivery</label>
										<?php 	$data = array(
													'name'        => 'options1',
													'id'          => 'options1',
													'value'       => 'deli',
													'checked'     => FALSE,
													'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
													);
										echo form_radio($data); ?>
										
									</td>
									<td align="left">
										<label for="HTML" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Connection</label>
										<?php 	$data = array(
													'name'        => 'options1',
													'id'          => 'options1',
													'value'       => 'con',
													'checked'     => FALSE,
													'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
													);
										echo form_radio($data); ?>
										
									</td>
									</tr>
									<tr>
									<td align="left">
										<label for="HTML" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Assignment</label>
										<?php 	$data = array(
													'name'        => 'options1',
													'id'          => 'options1',
													'value'       => 'assign',
													'checked'     => FALSE,
													'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
													);
										echo form_radio($data); ?>
										
									</td>
									</tr>
									</tr></table></td>
								</tr>
								<tr>
									
									
									<td align="left" ><label><font color='red'><b>*</b></font>From Date:</label>
											<td> 
											<input type="text" style="width:150px;" id="fromdate" name="fromdate" value="<?php date("Y-m-d"); ?>"/>
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
									</td>
								
								</tr>
									<tr>
									<td align="left" ><label><font color='red'><b>*</b></font>To Date:
									<td ><input type="text" style="width:150px;" id="todate" name="todate" value="<?php date("Y-m-d"); ?>"/></td>
									</label> 
									<script>
											  $(function() {
												$( "#todate" ).datepicker({
													changeMonth: true,
													changeYear: true,
													dateFormat: 'yy-mm-dd', // iso format
												});
											});
									</script>
									</td>
									</tr>
									<tr>
										<td>
										<label for="field3"><font color='red'><b>*</b></font>Yard Name:</label></td>
										<td>
											<select name="yard_no" id="yard_no" class="" required>
											<option value="" label="yard_no" selected style="width:130px;">Select</option>
												<option value="CCT" label="CCT" >CCT</option>
												<option value="NCT" label="NCT" >NCT</option>
												<option value="GCB" label="GCB">GCB</option>
												<option value="All" label="ALL">ALL</option>
										</select>
										</td>
									</tr>
								<tr>
									<td align="right" colspan="2"></td>
								</tr>
								<tr>
										<td align="left">
									
										
										</td>
										<td>
										<table><tr>
										<td align="left">
										<label for="1" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Disconnection 1</label>
									<?php 	$data = array(
													'name'        => 'optionsC',
													'id'          => 'optionsC',
													'value'       => '1',
													'checked'     => TRUE,
													'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
													);
										echo form_radio($data); ?>
									</td>
									<td align="left">
										<label for="2" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Disconnection 2</label>
										<?php 	$data = array(
													'name'        => 'optionsC',
													'id'          => 'optionsC',
													'value'       => '2',
													'checked'     => FALSE,
													'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
													);
										echo form_radio($data); ?>
										
									</td>
									<td align="left">
										<label for="3" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Disconnection 3</label>
										<?php 	$data = array(
													'name'        => 'optionsC',
													'id'          => 'optionsC',
													'value'       => '3',
													'checked'     => FALSE,
													'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
													);
										echo form_radio($data); ?>
										
									</td>
									</tr></table>
									</td>
								</tr>
								<tr>
									

										
										
										<td align="left">
									
										
										</td>
										<td>
										<table><tr>
										<td align="left">
										<label for="Excel" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Excel</label>
									<?php 	$data = array(
													'name'        => 'options',
													'id'          => 'options',
													'value'       => 'xl',
													'checked'     => FALSE,
													'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
													);
										echo form_radio($data); ?>
									</td>
									<td align="left">
										<label for="HTML" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">HTML</label>
										<?php 	$data = array(
													'name'        => 'options',
													'id'          => 'options',
													'value'       => 'html',
													'checked'     => TRUE,
													'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
													);
										echo form_radio($data); ?>
										
									</td>
									<td align="left">
										<label for="PDF" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">PDF</label>
										<?php 	$data = array(
													'name'        => 'options',
													'id'          => 'options',
													'value'       => 'pdf',
													'checked'     => FALSE,
													'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
													);
										echo form_radio($data); ?>
										
									</td>
									</tr></table>
									</td>
								</tr>
								
								<tr>
									<td><?php $arrt = array('name'=>'submit_login','id'=>'submit','value'=>'Show','class'=>'login_button'); echo form_submit($arrt);?></td>
									<td><?php $arrt = array('name'=>'submit_forwarding','id'=>'submit_forwarding','value'=>'Forwarding','class'=>'login_button'); echo form_submit($arrt);?></td>
									
								</tr>
								<tr><td colspan="2">&nbsp;</td></tr>
								
							</table>
						</td>
					</tr>
				</table>
		 </div>
		  <?php echo form_close()?>
          <div class="clr"></div>
        </div>
       
      </div>
      <div class="sidebar">
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	<?php echo form_close()?>
  </div>