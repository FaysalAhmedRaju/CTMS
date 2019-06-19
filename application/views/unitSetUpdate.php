<script type="text/javascript">
	function validate()
	{
		if( document.myForm.rotation.value == "" )
		{
			alert( "Please provide Rotation No!" );
			document.myForm.rotation.focus() ;
			return false;
		}
		if( document.myForm.unit.value == "" )
		{
			alert( "Please provide Unit No!" );
			document.myForm.unit.focus() ;
			return false;
		}
		return true ;
	}
</script> 
 
<div class="content">
    <div class="content_resize">
		<div class="mainbar">
			<div class="article">
				<h2><span><?php echo $title;?></span> </h2>
				<p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
			
				<div class="clr"></div>
				<div class="img">
					<form name="myForm" onsubmit="return(validate());" action="<?php echo site_url("ShedBillController/unitSetUpdatePerform");?>" method="post">
						<table align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="center" colspan="11"><?php echo $msg;?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="center" ><label>Rotation</label></td>
								<td>:</td>
								<?php 
								if($value==1)
								{
								?>
								<td>
									<input type="text" style="width:130px;" id="rotation" name="rotation" value="<?php echo $rotation?>" readonly />
								</td>
								<?php
								}
								else if($value==0)
								{
								?>
								<td>
									<input type="text" style="width:130px;" id="rotation" name="rotation"/>
								</td>
								<?php
								}
								?>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="center" ><label>Unit</label></td>
								<td>:</td>
								<td>
									<input type="text" style="width:130px;" id="unit" name="unit"/>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<?php 
								if($value==1)
								{
								?>
								<td align="center" colspan="5">
									<input type="submit" value="Update" class="login_button"/>      
								</td>
								<?php
								}
								else if($value==0)
								{
								?>
								<td align="center" colspan="5">
									<input type="submit" value="Save" class="login_button"/>      
								</td>
								<?php
								}
								?>
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