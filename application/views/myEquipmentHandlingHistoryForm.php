<script>
	function enabletime(time)
	{
		if(time=="Day" || time=="Night")
		{
			fromtime.disabled=true;
			totime.disabled=true;
			todate.disabled=true;
			
			document.myform.fromtime.value="";
			document.myform.totime.value="";
			document.myform.todate.value="";
		}
		else if(time=="timewise")
		{
			fromtime.disabled=false;
			totime.disabled=false;
			todate.disabled=false;
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
		  
			<?php 
			$attributes = array('target' => '_blank', 'name'=>'myform', 'id' => 'myform');
		  
			echo form_open(base_url().'index.php/report/myEquipmentHandlingHistoryView',$attributes);
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
			<table style="border:solid 1px #ccc;" width="500px" align="center" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<table border="0" width="500px" align="center">
							<tr>
								<td align="center" colspan="6"></td>
							</tr>
							<tr>
								<td>
									<label for="field3"><font color='red'><b>*</b></font>Shift:</label>
								</td>
								<td>
									<select name="shift" id="shift" onchange="enabletime(this.value);">
										<option value="" label="shift" selected style="width:110px;">Select</option>
										<option value="Day" label="Day">Day</option>
										<option value="Night" label="Night">Night</option>
										<option value="timewise" label="timewise">Time Wise</option>
									</select>
								</td>
							</tr>
							<tr>
								<td align="left" ><label><font color='red'><b>*</b></font>From Date:</label>
								<td> 
									<input type="text" style="width:130px;" id="fromdate" name="fromdate" value="<?php date("Y-m-d"); ?>"/>
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
								<td align="left" ><label><font color='red'><b>*</b></font>From Time:</label></td>
								<td> 
									<input type="text" style="width:130px;" id="fromtime" name="fromtime" disabled />
								</td>
								<td>
									(HH:MM)
								</td>
							</tr>
							<tr>
								<td align="left" ><label><font color='red'><b>*</b></font>To Date:</label>
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
								</td>
								<td align="left" ><label><font color='red'><b>*</b></font>To Time:</label></td>
								<td> 
									<input type="text" style="width:130px;" id="totime" name="totime" disabled />
								</td>
								<td>
									(HH:MM)
								</td>
							</tr>
							<tr>
								<td align="center" colspan="6">
									<table>
										<tr>
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
										</tr>
									</table>
								</td>
							</tr>
							<tr align="left">
								<td align="right" colspan="6">
											<!--<label for="rd1">Excel</label><input align="left" type="checkbox" name="myradio" value="1" <?php echo set_checkbox('myradio', '1'); ?> /><br/>-->
											<!--<label for="rd1">radio 2</label><input align="left" type="radio" name="myradio" value="2" <?php echo set_radio('myradio', '2'); ?> /><br/>-->
											<?php 
											/*$attribute = array(
														'name'        => 'newsletter',
														'id'          => 'newsletter',
														'value'       => 'XL',
														'checked'     => FALSE,
														'style'       => 'margin:10px',
														);

													echo form_radio($attribute);*/
										?>
								</td>
							</tr>
							<tr>
								<td colspan="6" align="center" width="70px"><?php $arrt = array('name'=>'submit_login','id'=>'submit','value'=>'Show','class'=>'login_button'); echo form_submit($arrt);?></td>
							</tr>
							<tr><td colspan="6">&nbsp;</td></tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
         
		  <?php echo form_close()?>
          <div class="clr"></div>
        </div>
       
       <!-- <p class="pages"><small>Page 1 of 2</small> <span>1</span> <a href="#">2</a> <a href="#">&raquo;</a></p>-->
      </div>
      <div class="sidebar">
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	<?php echo form_close()?>
  </div>