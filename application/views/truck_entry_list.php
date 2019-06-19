<script type="text/javascript">
	function chk_user()
	{
		if( document.search_user.search_by.value == "")
		{
			alert( "Please provide search type!" );
			document.search_user.login_id_search.focus() ;
			return false;
		}
		else if( document.search_user.login_id_search.value == "" && document.search_user.org_type_id.value == "")
		{
			alert( "Please provide User or Org Type!" );
			document.search_user.login_id_search.focus() ;
			return false;
		}
		
		return true ;
	}
	function del_user()
	{
		if (confirm("Do you want to detete this entry?") == true)
		{
			return true ;
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
					<table width="300px">
						<td colspan="5" align="center">
							<?php echo $msg?>
						</td>
						<tr>
							<th class="gridDark">Sl</th>
							<th class="gridDark">Truck No</th>
							<th class="gridDark">Action</th>
							<th class="gridDark">Action</th>
						</tr>
						<?php
						for($i=0;$i<count($rslt_truck_list);$i++)
						{
						?>
							<tr>
								<td class="gridLight"><?php echo $i+1; ?></td>								
								<td class="gridLight"><?php echo $rslt_truck_list[$i]['truck_id']; ?></td>
								<td class="gridLight" align="center">
									<form name="edit_truck" id="edit_truck" action="<?php echo site_url('report/edit_truck');?>" method="post">
										<input type="hidden" name="id_edit" id="id_edit" value="<?php echo $rslt_truck_list[$i]['id'] ;?>">
										<input type="submit" value="Edit" name="edit" class="login_button">
									</form>
								</td>
								<td class="gridLight" align="center">
									<form name="report_truck" id="report_truck" action="<?php echo site_url('report/truck_report');?>" method="post" target="_blank">
										<input type="hidden" name="id_report" id="id_report" value="<?php echo $rslt_truck_list[$i]['id'] ;?>">
										<input type="submit" value="Report" name="report" class="login_button">
									</form>
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
	