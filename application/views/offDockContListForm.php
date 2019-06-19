


 <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
	<div class="img">
		<form action="<?php echo site_url("report/offDockContListViews");?>" target="_blank" method="post">
			<table align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
			<input type="hidden" name="get" value="no">
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr align="center">
					<td align="center">&nbsp;&nbsp;<b>Search By :</b></td>
					<td align="left">
						<select name="positon">
							<option>----Select----</option>
								<option value="S20_INBOUND">INBOUND</option>
								<option value="S60_LOADED">LOADED</option>
								<!--option value="S70_DEPARTED">Departed</option-->
						</select>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<table>
							<tr>
								<td>
									<label for="Excel" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Excel</label>
									<?php 	
										$data = array('name'=> 'options','id'=> 'options','value' => 'xl','checked'=> TRUE,'style' => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',);
										echo form_radio($data); 
									?>
								</td>
								<td>
									<label for="Excel" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">HTML</label>
									<?php 	
										$data = array('name'=> 'options','id'=> 'options','value' => 'html','checked'=> FALSE,'style' => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',);
										echo form_radio($data); 
									?>
								</td>
							</tr>
						</table>
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
	
  </div>