<link rel="stylesheet" href="<?php echo CSS_PATH; ?>jquery.timepicker.min.css" type="text/css"/>
<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.timepicker.min.js"></script>

<div class="content">
    <div class="content_resize">
		<div class="mainbar">
			<div class="article">
				<h2><span><?php echo $title; ?></span> </h2>
				<p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
				<div class="clr"></div>
				<div class="img">
					<form  onsubmit="return(validate());" action="<?php echo site_url("report/stuffingPermissionPerform");?>" target="_self" method="post">
						<table border="0" align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="right"><label><nobr>&nbsp;&nbsp;&nbsp;Offdock Name: &nbsp;&nbsp;&nbsp;</nobr></label></td>
								<td>:&nbsp;&nbsp;&nbsp;</td>
								<td>
									<select name="offdock" id="offdock" width="150px" >
										<option value="">--Select--</option>
									<?php
									include("mydbPConnectionn4.php");
									$sql_offdock_list="select id,name from ctmsmis.offdoc";
									$rslt_offdock_list=mysql_query($sql_offdock_list,$con_sparcsn4);
									while($offdock_list=mysql_fetch_object($rslt_offdock_list))
									{
									?>
										<option value="<?php echo $offdock_list->id; ?>"><?php echo $offdock_list->name; ?></option>
									<?php
									}
									?>
									</select>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>

							<tr>
								<td align="right"><label><nobr>&nbsp;&nbsp;&nbsp; Date&nbsp;&nbsp;&nbsp;</nobr></label></td>
								<td>:&nbsp;&nbsp;&nbsp;</td>
								<td>
									<input type="text" style="width:150px;" id="stuffing_date" name="stuffing_date" value="<?php echo $toDate; ?>" readonly />
								</td>
								<!--script>
									$(function() {
										$( "#stuffing_date" ).datepicker({
											changeMonth: true,
											changeYear: true,
											dateFormat: 'yy-mm-dd', // iso format
										});
									});
								</script-->
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="right"><label><nobr>&nbsp;&nbsp;&nbsp; Time&nbsp;&nbsp;&nbsp;</nobr></label></td>
								<td>:&nbsp;&nbsp;&nbsp;</td>
								<td>
									<input type="text" style="width:150px;" id="time" name="time" value="" />
								</td>
								<script>
									$('#time').timepicker({ timeFormat: 'HH:mm:ss' });

								</script>
							</tr>

							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3" align="center">
									<input type="submit" value="Save" class="login_button"/>      
								</td>
							</tr>
							<tr>
								<td colspan="3" align="center"><font color="green" size="3"><?php echo $msg;?></font></td>
							</tr>
							<tr>
								<td >&nbsp;</td>
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