 <script type="text/javascript">
  $(function() {
    $("#srcFor").change(function() {
        if ($(this).val() == "Date") {
			//console.log(false);
            $("#srcRot").attr("disabled", "disabled");
			 $("#srcRot").removeAttr("value");
			$("#fromdate").removeAttr("disabled");
			$("#todate").removeAttr("disabled");
			
        }
        else {
            //console.log(true);
            $("#srcRot").removeAttr("disabled");
			 $("#fromdate").removeAttr("value");
			  $("#todate").removeAttr("value");
			$("#fromdate").attr("disabled", "disabled");
			$("#todate").attr("disabled", "disabled");
        }
    });
});

 </script>
  
	
 <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
		  
		  <?php 
		  $attributes = array('target' => '_blank', 'id' => 'myform');
		  
		  echo form_open(base_url().'index.php/report/plannedRptFormView',$attributes);
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
								<tr>
					
									<br />
									<td align="left" ><label for="block">Search By:<em>&nbsp;</em></label></td>
									<td align="left" >
										<select class="login_input_text" name="srcFor" id="srcFor" >
											    <!--<option value="">--Select--</option>	-->										
												<option value="Date">Date</option>
												<option value="Rotation">Rotation</option>
										</select>					
											
									</td>
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
							<br />
							<td align="left" ><label for="block">Search Rotation:<em>&nbsp;</em></label></td>
							<td align="left" >
								<input type="text" id="srcRot" class="login_input_text" name="srcRot" disabled >
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
													'checked'     => FALSE,
													'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
													);
										echo form_radio($data); ?>
										
									</td>
									</tr></table></td>
								</tr>
								
								<tr>
									<td colspan="2" align="center" width="70px"><?php $arrt = array('name'=>'submit_login','id'=>'submit','value'=>'Show','class'=>'login_button'); echo form_submit($arrt);?></td>
									
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