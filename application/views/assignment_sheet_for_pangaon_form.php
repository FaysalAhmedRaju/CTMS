<script>
	function rtnFunc(val)
	{
		var pangaon_rot=document.getElementById("pangaon_rot").value;
		
		if(pangaon_rot=="")
		{
			alert("Provide rotation");
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
					<form name= "assignment_sheet_form" id="assignment_sheet_form" onsubmit="return(rtnFunc());" action="<?php echo site_url("report/assignment_sheet_for_pangaon_action");?>"  method="post" target="_blank">
						<table align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="5" align="center"><?php echo $msg; ?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="right"><font color='red'><b>*</b></font>Pangaon Rotation</td>
								<td>&nbsp;</td>
								<td>:</td>
								<td>&nbsp;</td>
								<td>
									<input type="text" style="width:150px;" id="pangaon_rot" name="pangaon_rot" />
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>		
								<td colspan="5" align="center">
									<table>
										<tr>
											<td align="left">
												<label for="HTML" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Excel</label>
												<?php 	$data = array(
												'name'        => 'options',
												'id'          => 'options',
												'value'       => 'excel',												
												'checked'     => TRUE,
												'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
												);
												echo form_radio($data); ?>
											</td>	
											<td align="left">
												<label for="Excel" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">HTML</label>
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
								<td colspan="5" align="center">
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