
   <script>
	function rtnFunc(val)
	{
	//	document.getElementById("offhire_date").disabled=true;
		if(document.offhireSummaryAndDetailsForm.offhire_date.value=="")
		{
			alert( "Please provide date!" );
			document.offhireSummaryAndDetailsForm.offhire_date.focus() ;
			return false;
		}
	}
  </script>



 <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
	
			<div class="img">
			<form name= "offhireSummaryAndDetailsForm" onsubmit="return(rtnFunc());" action="<?php echo site_url("report/offhireSummaryAndDetailsView");?>" target="_blank" method="post">
				<table style="border:solid 1px #ccc;" width="300px" align="center" cellspacing="0" cellpadding="0">
					<tr>
						<td>
							<table border="0" width="650px" align="center">
								<tr>
									<td align="right" colspan="2">&nbsp;</td>
								</tr>
								<tr>
									<td align="right" ><label><font color='red'><b>*</b></font>Date:</label>
									<td> 
										<input type="text" style="width:120px;" id="offhire_date" name="offhire_date" value="<?php date("Y-m-d"); ?>"/>
									</td>							
										<script>
											$(function() {
												$( "#offhire_date" ).datepicker({
													changeMonth: true,
													changeYear: true,
													dateFormat: 'yy-mm-dd', // iso format
												});
											});
										</script>
									</td>
								</tr>		
								<tr>
									<td align="right" colspan="2"></td>
								</tr>
								<tr>
									<!--td align="left"></td-->
									<td colspan="2">
										<table align="center">
											<tr>
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
												<td align="right">
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
											</tr>
										</table>
									</td>
								</tr>									
								<tr>
									<td align="right" width="70px"><?php $arrt = array('name'=>'submit','id'=>'submit','value'=>'Details','class'=>'login_button'); echo form_submit($arrt);?></td>
									<td align="left" width="70px"><?php $arrt = array('name'=>'submit','id'=>'submit','value'=>'Summary','class'=>'login_button'); echo form_submit($arrt);?></td>
								</tr>
								<tr><td colspan="2">&nbsp;</td></tr>
							</table>
						</td>
					</tr>
				</table>
			</form>
		 </div>
		  <?php //echo form_close()?>
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