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
						<?php
						if($flag==1)
						{
							$path=BASE_PATH.'resources/';
							//echo $path= 'http://'.$_SERVER['SERVER_ADDR'].'/myportpanel/resources/';
						?>
						<tr>
							<td colspan="2" align="center"><a href="<?php echo $path.'sampleExcelStuffingContainer.xls';?>"><span>Download Sample Excel</span></a></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<?php
						}
						else
						{
						?>	
						<tr>
							<td colspan="2" align="center"><font color="blue" size="2"><b><?php echo $msg; ?><br></b> </font></td>
						</tr>
						<?php
						}
						?>
						<form action="<?php echo site_url('uploadExcel/stuffingContExcelPerform');?>" method="POST" enctype="multipart/form-data">	
						<?php
						$org_Type_id=$this->session->userdata('org_Type_id');
						if($org_Type_id==28)
						{
						?>
						<tr>
							<td>Offdock</td>
							<td>
								<select name="offdock" id="offdock ">
									<option value="">--Select--</option>
									<?php
									include("mydbPConnectionn4.php");
									$sql_offdock_list="select code,name from ctmsmis.offdoc";
									$rslt_offdock_list=mysql_query($sql_offdock_list,$con_sparcsn4);
									while($offdock_list=mysql_fetch_object($rslt_offdock_list))
									{
									?>
										<option value="<?php echo $offdock_list->code; ?>"><?php echo $offdock_list->name; ?></option>
									<?php
									}
									?>
								</select>
							</td>
						</tr>
						<?php
						}
						?>
						<!--form action="<?php echo site_url('uploadExcel/stuffingContExcelPerform');?>" method="POST" enctype="multipart/form-data"-->	
						<tr>
							<td>Browse Excel File</td>
							<td>
								<input type="file" name="file"/>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<?php //echo $diff; ?>
								<input type="submit" class="login_button" name="submit" value="Upload" <?php if($ctime>=$upperLimit and $org_Type_id!=28 and $diff == null) { ?>disabled <?php } ?> />
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						</form>
					</table>
					<?php
				//	if($ctime<=10 and $ctime>=9)
				//	if($ctime==11)
					if($ctime==$lowerLimit and $org_Type_id!=28 and $diff!=null)
					{ 
					?>
					<div style="font-size:20px;color:red;">
						<marquee hspace="1"><b>Upload facility will be closed after <?php echo $diff; ?> minutes for today.</b></marquee>
					</div>
					<?php
					}
				//	else if($ctime>=10 and $cmin==15)	
				//	else if($ctime>=12)
					else if($ctime>=$upperLimit and $org_Type_id!=28)
					{ 
					?>
						<div style="font-size:20px;color:red;">
							<marquee hspace="1"><b>Upload facility is closed for today.</b></marquee>
						</div>
					<?php
					}
					?>
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