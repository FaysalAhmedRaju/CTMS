<div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
	
		<div class="img">
		 <table style="border:solid 1px #ccc;" width="500px" align="center" cellspacing="0" cellpadding="0">
			<tr>
				<td>	 
					<table align="center" border ="0">	
						<tr>
							<td colspan="2" align="center"><font color="blue" size="2"><b><?php echo $msg; ?><br></b> </font></td>
						</tr>
						<form action="<?php echo site_url('uploadExcel/exportExcelUploadPerformForAdmin');?>" method="POST" enctype="multipart/form-data">						
						<tr>
							<td>Browse Excel File</td>
							<td>
								<input type="file" name="file"/>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<input type="submit" class="login_button" name="submit" value="Upload"/>
							</td>
						</tr>
						</form>
					</table>
				</td>
			</tr>
	</table>
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