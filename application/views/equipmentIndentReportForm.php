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
					<form  action="<?php echo site_url("misReport/mis_equipment_indent_report_view");?>" target="_blank" method="post">
						<table align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="2" align="center"><?php echo $msg; ?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="right" ><label><b>Indent Date :  </b></label></td>
								<td>
									<input type="text" style="width:200px;" name="indent_date" id="indent_date" />
								</td>
								<script>
									$( function() {
										
									$( "#indent_date" ).datepicker({
									//minDate: 0,
									changeMonth: true,
									changeYear: true,
									dateFormat: 'yy-mm-dd', // iso format
									});
									} );
								</script>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2" align="center">
									<input type="submit" value="Search" class="login_button"/>      
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