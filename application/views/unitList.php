<script type="text/javascript">
	function validate()
	{
		if( document.myForm.rotation.value == "" )
		{
			alert( "Please provide Rotation No!" );
			document.myForm.rotation.focus() ;
			return false;
		}
		
		return true ;
	}
	function del_validate()
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
				<h2><span><?php echo $title;?></span> </h2>
				<p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
			
				<div class="clr"></div>
				<div class="img">
					<form name="myForm" onsubmit="return(validate());" action="<?php echo site_url("ShedBillController/unitListSearch");?>" method="post">
						<table align="center" style="border:solid 1px #ccc;" width="300px" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="center" ><label>Rotation</label></td>
								<td>:</td>
								<td>
									<input type="text" style="width:130px;" id="rotation" name="rotation"/>
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
					<table width="350px;">
						<tr>
							<td colspan="5" align="center">
								<?php echo $msg?>
							</td>
						</tr>
						<tr>
							<th class="gridDark">Serial</th>
							<th class="gridDark">Rotation</th>
							<th class="gridDark">Unit</th>
							<th class="gridDark">Action</th>
							<th class="gridDark">Action</th>
						</tr>
						<?php
						for($i=0;$i<count($rslt_list);$i++)
						{
						?>
							<tr>
								<td class="gridLight" align="center" width="10px">
									<?php echo $i+1;?>
								</td>
								<td class="gridLight" align="center">
									<?php echo $rslt_list[$i]['rotation']?>
								</td>
								<td class="gridLight" align="center">
									<?php echo $rslt_list[$i]['unit_no']?>
								</td>
								<td class="gridLight" align="center">
									<form action="<?php echo site_url("ShedBillController/unitListEdit");?>" method="post">
										<input type="hidden" name="rt_no" value="<?php echo $rslt_list[$i]['rotation']?>" />
										<input type="submit" name="edit" value="Edit" class="login_button" />
									</form>
								</td>
								<td class="gridLight" align="center">
									<form onsubmit="return del_validate()" action="<?php echo site_url("ShedBillController/unitListDelete");?>" method="post">
										<input type="hidden" name="rot" value="<?php echo $rslt_list[$i]['rotation']?>" />
										<input type="hidden" name="unit" value="<?php echo $rslt_list[$i]['unit_no']?>" />
										<input type="submit" name="delete" value="Delete" class="login_button" />
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