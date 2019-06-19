<script type="text/javascript">
    function validate()
	{
		if(document.stuffingContainerOffdockWiseSearchForm.stuffing_date_offdock.value=="")
		{
			alert( "Please provide a date!" );
			document.stuffingContainerOffdockWiseSearchForm.stuffing_date_offdock.focus() ;
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
					<form name= "stuffingContainerOffdockWiseSearchForm" id="stuffingContainerOffdockWiseSearchForm" onsubmit="return(validate());" action="<?php echo site_url("report/stuffingContainerListPerform");?>" target="_blank" method="post">
						<input type="hidden" id="login_id_offdock" name="login_id_offdock" value="<?php echo $login_id; ?>" />
						<table border="0" align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="right"><label><nobr>&nbsp;&nbsp;&nbsp;Stuffing Date&nbsp;&nbsp;&nbsp;</nobr></label></td>
								<td>:&nbsp;&nbsp;&nbsp;</td>
								<td>
									<input type="text" style="width:150px;" id="stuffing_date_offdock" name="stuffing_date_offdock" value="<?php date("Y-m-d"); ?>"  />
								</td>
								<script>
									$(function() {
										$( "#stuffing_date_offdock" ).datepicker({
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
								<td colspan="3" align="center">
									<table>
										<tr>
											<td align="left">
												<label for="PDF" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">PDF</label>
												<?php 	
												$data = array(
													'name'        => 'option',
													'id'          => 'option',
													'value'       => 'pdf',
													'checked'     => false,
													'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
													);
												echo form_radio($data); ?>
											</td>
											<td align="left">
												<label for="html" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">HTML</label>
													<?php 	
													$data = array(
													'name'        => 'option',
													'id'          => 'option',
													'value'       => 'html',
													'checked'     => true,
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
								<td colspan="3" align="center">
									<input type="submit" value="Search" class="login_button"/>      
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3">
								<?php
				//	if($ctime<=10 and $ctime>=9)
					if($ctime==$lowerLimit)
					{ 
					?>
					<div style="font-size:20px;color:red;">
						<marquee hspace="1"><b>Delete facility will be closed after <?php echo $diff; ?> minutes for today.</b></marquee>
					</div>
					<?php
					}
					else if($ctime>=$upperLimit)
					{ 
					?>
						<div style="font-size:20px;color:red;">
							<marquee hspace="1"><b>Delete facility is closed for today.</b></marquee>
						</div>
					<?php
					}
					?>
								</td>
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
	<?php// echo form_close()?>
</div>