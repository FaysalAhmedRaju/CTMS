<div class="content">
    <div class="content_resize">
		<div class="mainbar">
			<div class="article">
				<h2><span><?php echo $title; ?></span> </h2>
				<p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
   
				<div class="clr"></div>
					<div class="img">
						<form name= "myForm"  action="<?php echo site_url("report/shedDeliveryOrderForm");?>" method="post" target="_blank">
							<table align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="left" ><label><font color='red'></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verify No:</label></td>
									<td>
										<input type="text" style="width:130px;" id="verifyNo" name="verifyNo" value=""/>
										&nbsp;&nbsp;&nbsp;&nbsp;
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
	
	<div class="img">

	</div>

      
      </div>
      <div class="sidebar">
    <?php include_once("mySideBar.php"); ?>
   </div>
      <div class="clr"></div>
    </div>
 <?php echo form_close()?>
  </div>