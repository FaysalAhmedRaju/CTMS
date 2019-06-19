 <script type="text/javascript">
   
			function validate()
			{
				if( document.myForm.rotation.value == "" )
				{
					alert( "Please provide rotation no!" );
					document.myForm.rotation.focus() ;
					return false;
				}
				
				if( document.myForm.container.value == "" )
				{
					alert( "Please provide container no!" );
					document.myForm.container.focus() ;
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
		 	 <!--<div id="login_container">-->
				<form name= "myForm" onsubmit="return(validate());" action="<?php echo site_url("ShedBillController/tallyReport");?>" target="_blank" method="post">
					<table align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td align="left" ><label><font color='red'><b>*</b></font>Rotation:</label></td>
								<td>
									<input type="text" style="width:130px;" id="rotation" name="rotation" value=""/>
								</td>
						</tr>
						<tr>
						 <td>&nbsp;</td>
						</tr>
						<tr>
							<td align="left" ><label><font color='red'><b>*</b></font>Container:</label></td>
							<td> 
								<input type="text" style="width:130px;" id="container" name="container" value=""/>
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
							
						</td>
					</tr>
				</table>
			
		 
		 <!--</div>-->
		 </div>
          <div class="clr"></div>
        </div>
       
       <!-- <p class="pages"><small>Page 1 of 2</small> <span>1</span> <a href="#">2</a> <a href="#">&raquo;</a></p>-->
      </div>
      <div class="sidebar">
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	<?php echo form_close()?>
  </div>