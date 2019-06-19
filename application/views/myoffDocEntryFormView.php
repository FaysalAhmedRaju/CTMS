 <script type="text/javascript">       
  function validate()
   {   

		if(document.offDocEntryForm.offdoc_id.value == "" )
		{
			alert( "Please provide Offdoc ID!" );
			document.offDocEntryForm.offdoc_id.focus() ;
			return false;
		}
                else if(document.offDocEntryForm.offdoc_code.value == "" )
		{
			alert( "Please provide offdoc code!" );
			document.offDocEntryForm.offdoc_code.focus() ;
			return false;
		}
		else if( document.offDocEntryForm.offdoc_name.value == "" )
		{
			alert( "Please provide offdoc name!" );
			document.offDocEntryForm.offdoc_name.focus() ;
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
					<form name= "offDocEntryForm" id="offDocEntryForm" onsubmit="return(validate());" action="<?php echo site_url("report/myoffDocEntryFormPerform");?>" target="_blank" method="post">
						<table border="0" align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td>&nbsp;</td>
							</tr>
							
                                                        <tr>
								<td align="right"><label><nobr>&nbsp;&nbsp;&nbsp;Offdoc ID&nbsp;&nbsp;&nbsp;</nobr></label></td>
								<td>:&nbsp;&nbsp;&nbsp;</td>
								<td>
									<input type="text" style="width:150px;" id="offdoc_id" name="offdoc_id" value="" />
								</td>
								
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
                                                        
                                                        <tr>
								<td align="right"><label><nobr>&nbsp;&nbsp;&nbsp;Offdoc Code&nbsp;&nbsp;&nbsp;</nobr></label></td>
								<td>:&nbsp;&nbsp;&nbsp;</td>
								<td>
									<input type="text" style="width:150px;" id="offdoc_code" name="offdoc_code" value="" />
								</td>
								
							</tr>
							
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="right"><label><nobr>&nbsp;&nbsp;&nbsp;Offdoc Name&nbsp;&nbsp;&nbsp;</nobr></label></td>
								<td>:&nbsp;&nbsp;&nbsp;</td>
								<td>
									<input type="text" style="width:150px;" id="offdoc_name" name="offdoc_name" value="" />
								</td>
								
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
								<td>&nbsp;</td>
							</tr>
                                                        <tr >
								<td colspan="3" align="center"><?php echo $msg; ?></td>
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