<script type="text/javascript">  
	function validate()
	{
		if(document.location_form.location_name.value == "")
		{
			alert("Please provide location name!");
			document.location_form.location_name.focus();
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
					<form name="location_form" id="location_form" onsubmit="return(validate());" action="<?php echo site_url("report/location_save");?>" method="post">
						<input type="hidden" id="location_id" name="location_id" value="<?php echo $rslt_location_info[0]['id']; ?>" />
						<table align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="2" align="center"><?php echo $msg; ?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="right" ><label><font color='red'><b>*</b></font>Location Name : </label></td>
								<td>
									<input type="text" style="width:200px;height:20px;" name="location_name" id="location_name" value="<?php echo $rslt_location_info[0]['location_name']; ?>"  />
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" align="center">
									<input type="submit" value="Save" class="login_button"/>      
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