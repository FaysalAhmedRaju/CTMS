 <script type="text/javascript">
   
	function validate()
	{
		if( document.removal_list_form.assignment_date.value == "" )
		{
			alert( "Please provide Assignment Date!" );
			document.removal_list_form.assignment_date.focus() ;
			return false;
		}
		return true ;
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
					<form name= "removal_list_form" onsubmit="return(validate());" action="<?php echo site_url("report/removal_list_report");?>" target="_blank" method="post">
						<input type="hidden" style="width:130px;" id="modify" name="modify" value="<?php echo $modify; ?>"/>
						<table align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="right" ><label><font color='red'><b>*</b></font>Assignment Date : </label></td>
								<td>
									<input type="text" style="width:130px;" id="assignment_date" name="assignment_date" value="<?php date("Y-m-d"); ?>"/>
								</td>
								<script>
									$(function() {
									$( "#assignment_date" ).datepicker({
										changeMonth: true,
										changeYear: true,
										dateFormat: 'yy-mm-dd', // iso format
									});
									});
								</script>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>		
								<td align="left"></td>
								<td>
									<table>
										<tr>
											<td align="left">
												<label for="PDF" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">PDF</label>
							
												<?php 	$data = array(
												'name'        => 'options',
												'id'          => 'options',
												'value'       => 'pdf',
												'checked'     => TRUE,
												'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
												);
												echo form_radio($data); ?>
											</td>
											<td align="left">
												<label for="Excel" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Excel</label>
												<?php 	$data = array(
												'name'        => 'options',
												'id'          => 'options',
												'value'       => 'excel',
												'checked'     => FALSE,
												'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
												);
												echo form_radio($data); ?>
											</td>
											<td align="left">
												<label for="html" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">HTML</label>
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
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" align="center">
									<input type="submit" value="View" class="login_button"/>      
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</form>
				</div>
				<div class="clr"></div>
			</div>
		</div>
		<div class="sidebar">
			<?php include_once("mySideBar.php"); ?>
		</div>
		<div class="clr"></div>
	</div>
</div>