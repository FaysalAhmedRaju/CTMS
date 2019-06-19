<script>
	function myconfirm()
	{
		if(confirm("Do you want done this EDI?"))
		{
			return true;
		}
		else
		{
			return false;
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
					<table width="600px">
						<th class="gridDark">Sl.</th>
						<th class="gridDark">EDI File</th>
						<th class="gridDark">Stow File</th>
						<th class="gridDark">Status</th>
						<th class="gridDark">Declaration</th>
						
						<?php
						$path= 'http://'.$_SERVER['SERVER_ADDR'].'/myportpanel/resources/edi/';
						
						for($i=0;$i<count($rslt_edi_list);$i++)
						{
						?>
						<tr>
							<td class="gridLight" align="center"><?php echo $i+1; ?></td>
							<td class="gridLight" align="center"><a href="<?php echo $path.$rslt_edi_list[$i]['file_name_edi'];?>" download /><?php echo $rslt_edi_list[$i]['file_name_edi']; ?></td>
							<td class="gridLight" align="center"><a href="<?php echo $path.$rslt_edi_list[$i]['file_name_stow'];?>" download /><?php echo $rslt_edi_list[$i]['file_name_stow']; ?></td>
							<td class="gridLight" align="center">
								<a href="<?php echo site_url('uploadExcel/update_edi_status/'.$rslt_edi_list[$i]['id']); ?>" class="login_button" style="text-decoration: none;" onclick="return myconfirm();">Done EDI</a>
							</td>
							<td class="gridLight" align="center">
								<a href="<?php echo site_url('uploadExcel/show_edi_declaration/'.$rslt_edi_list[$i]['id']); ?>" class="login_button" style="text-decoration: none;" target="BLANK">View</a>
							</td>
						</tr>
						<?php
						}
						?>
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
	