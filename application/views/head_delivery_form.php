 <script type="text/javascript">
	function show_info()
	{
		var cont_no=document.container_search.cont_no.value;
		
		if(cont_no=="")
		{
			alert("No container no. Please provide one.");
			return false;
		}
	}
	
	function chk_weight()
	{
		var current_weight=parseInt(document.getElementById("quantity").value);
		var stc=document.getElementById("stc").value;
		var tot_dlv_qty=parseInt(document.getElementById("tot_dlv_qty").value);
		
		stc=stc.substr(0,stc.indexOf(' '));
		
		var gross_weight=tot_dlv_qty+current_weight;
		
		if(gross_weight > stc)
		{
			if (confirm("Total quantity is more then assignment. Continue?") == true) 
			{
				return true ;
			} 
			else 
			{
				return false;
			}
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
					<table>
						<tr>
							<td>
								<form name="container_search" onsubmit="return(show_info());" action="<?php echo site_url("report/head_delivery_search");?>" method="post" target="_blank">
									<table align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
										<tr>
											<td colspan="3">&nbsp;</td>
										</tr>
										<tr>
											<td colspan="3" align="center"><font color="red"><b><?php echo $msg; ?></b></font></td>
										</tr>
										<tr>
											<td colspan="3">&nbsp;</td>
										</tr>
										<tr>
											<td align="right">Container No</td>
											<td>:</td>
											<td>
												<input type="text" style="width:130px;" id="cont_no" name="cont_no" />
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td colspan="3" align="center">
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