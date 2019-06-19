<script type="text/javascript">
	function validate()
	{
		if(document.product_type.short_name.value == "")
		{
			alert("Please provide short name!");
			document.product_type.short_name.focus();
			return false;
		}
		if(document.product_type.description.value == "")
		{
			alert("Please provide description!");
			document.product_type.description.focus();
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
					<form name= "product_type" id="product_type" onsubmit="return(validate());" action="<?php echo site_url("report/product_type_save");?>"  method="post">
						<input type="hidden" id="product_id" name="product_id" value="<?php echo $rslt_product_info[0]['id']; ?>" />
						<table align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="2" align="center"><?php echo $msg; ?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="right" ><label><font color='red'><b>*</b></font>Short Name : </label></td>
								<td>
									<input type="text" style="width:200px;height:20px;" id="short_name" name="short_name" value="<?php echo $rslt_product_info[0]['short_name']; ?>" />
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="right" ><label><font color='red'><b>*</b></font>Description : </label></td>
								<td>
									<textarea id="description" name="description" rows="8"><?php echo $rslt_product_info[0]['product_desc']; ?></textarea> 
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