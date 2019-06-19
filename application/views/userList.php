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
					<form name="search_user" onsubmit="return(chk_user());" action="<?php echo site_url("report/searchUser");?>" method="post">
						<table align="left" style="border:solid 1px #ccc;" width="400px" cellspacing="0" cellpadding="0">
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="right" ><label>Search By</label></td>
								<td>:</td>
								<td colspan="3">
									<select id="search_by" name="search_by">
										<option value="">--Select--</option>
										<option value="login_id">Login ID</option>
										<option value="org_Type">Org ID</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="right" ><label>Login ID</label></td>
								<td>:</td>
								<td>
									<input type="text" style="width:130px;" id="login_id_search" name="login_id_search"/>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="right" ><label>Org ID</label></td>
								<td>:</td>
								<td>
									<select id="org_type_id" name="org_type_id">
										<option value="">--Select--</option>
										<?php
										include('mydbPConnection.php');
										$sql_org_type_id="SELECT DISTINCT Org_Type_id,Org_Type 
										FROM users 
										INNER JOIN tbl_org_types ON tbl_org_types.id=users.Org_Type_id
										ORDER BY Org_Type_id ASC ";
										$rslt_org_type_id=mysql_query($sql_org_type_id);
										while($row=mysql_fetch_object($rslt_org_type_id))
										{
										?>
											<option value="<?php echo $row->Org_Type_id; ?>"><?php echo $row->Org_Type; ?></option>
										<?php
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="center" colspan="5">
									<input type="submit" value="Search" class="login_button"/>      
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</form>
					<br>
					<table width="600px">
						<td colspan="5" align="center">
							<?php echo $msg?>
						</td>
						<tr>
							<th class="gridDark">Sl</th>
							<th class="gridDark">User</th>
							<th class="gridDark">Login ID</th>
							<th class="gridDark">Organization Name</th>
							<th class="gridDark">Signature</th>
							<th class="gridDark">Action</th>
							<th class="gridDark">Action</th>
						</tr>
						<?php
						$j=$start;
						for($i=0;$i<count($rslt_user_list);$i++)
						{
							$j++;
						?>
							<tr>
								<td class="gridLight" width="10px" align="center">
									<?php echo $j; ?>
								</td>
								<td class="gridLight" width="200px">
									<?php echo $rslt_user_list[$i]['u_name']; ?>
								</td>
								<td class="gridLight" width="200px">
									<?php echo $rslt_user_list[$i]['login_id']; ?>
								</td>
								<td class="gridLight" width="200px">
									<?php echo $rslt_user_list[$i]['Organization_Name']; ?>
								</td>
								<td align="center" class="gridLight" width="200px">
									<img align="middle" width="100px" height="30px" src="<?php echo IMG_PATH?><?php echo $rslt_user_list[$i]['image_path']; ?>" >
								</td>
								<td class="gridLight">
									<form name="editUser" id="editUser" action="<?php echo site_url('report/editUser');?>" method="post">
										<input type="hidden" name="id_edit" id="id_edit" value="<?php echo $rslt_user_list[$i]['id'] ;?>">
										<input type="hidden" name="login_id_edit" id="login_id_edit" value="<?php echo $rslt_user_list[$i]['login_id'];?>">
										<input type="submit" value="Edit" name="edit" class="login_button">
									</form>
								</td>
								<td class="gridLight">
									<form name="deleteUser" id="deleteUser" action="<?php echo site_url("report/deleteUser");?>" onsubmit="return(del_user());" method="post">
										<input type="hidden" name="id_delete" id="id_delete" value="<?php echo $rslt_user_list[$i]['id'] ;?>">
										<input type="hidden" name="login_id_delete" id="login_id_delete" value="<?php echo $rslt_user_list[$i]['login_id'];?>">
										<input type="submit" value="Delete" name="delete" class="login_button">
									</form>
								</td>
							</tr>	
						<?php
						}
						?>
							<tr>
								<td colspan="6" align="center"><p><?php echo $links; ?></p></td>
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
	