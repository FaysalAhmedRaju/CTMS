
	<div class="content">
		<div class="content_resize">
			<div class="mainbar">
				<div class="article">
					<h2><span><?php echo $title; ?></span> </h2>
					<p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
					<div class="clr"></div>
		
					<form name="ocr_report_form" id="ocr_report_form" action="<?php echo site_url("report/ocr_report_action"); ?>" method="POST" onsubmit="return ocr_report_validate();" target="_blank" enctype="multipart/form-data">
						<table id="truck_entry_table" name="truck_entry_table" style="border:solid 1px #ccc;" width="350px" align="center"> 
							<tr>
								<td align="center" colspan="3">
									<?php echo $msg;?>
								</td>
							</tr>
							<tr>
								<td align="right">
									Search By
								</td>
								<td>
									<b>:</b>
								</td>
								<td>
									<select name="search_by" id="search_by">
										<option value="">-Select-</option>
										<option value="ocd">On Chasis Delivery</option>
										<option value="depo">Depo</option>
									</select>
								</td>
							</tr>
							<tr>
								<td align="right">
									From
								</td>
								<td>
									<b>:</b>
								</td>
								<td>
									<input style="width:150px" id="from_dt" name="from_dt" type="date" />
								</td>
							</tr>
							<tr>
								<td align="right">
									To
								</td>
								<td>
									<b>:</b>
								</td>
								<td>
									<input style="width:150px" id="to_dt" name="to_dt" type="date" />
								</td>
							</tr>
							<tr>
								<td colspan="3" align="center">
									<input type="submit" id="btn_ocr_search" name="btn_ocr_search" value="Search" class="login_button" />
								</td>
							</tr>
						</table>	
					</form>
								
						
					<!--/form-->	
					<div class="clr"></div>
				</div>
			</div>
			<div class="sidebar">
				<?php include_once("mySideBar.php"); ?>
			</div>
			<div class="clr"></div>
		</div>
	</div>
	