<script type="text/javascript">
	function chk_confirm()
	{
		var discharge_actual=document.getElementById("discharge_actual").value;
		var discharge_ctms=document.getElementById("discharge_ctms").value;
		var loading_actual=document.getElementById("loading_actual").value;
		var loading_ctms=document.getElementById("loading_ctms").value;
		
		document.getElementById("discharge_actual_entry").value=discharge_actual;
		document.getElementById("discharge_ctms_entry").value=discharge_ctms;
		document.getElementById("loading_actual_entry").value=loading_actual;
		document.getElementById("loading_ctms_entry").value=loading_ctms;
		
		if (confirm("Do you want to save ?") == true) 
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
	<div class="content_resize" > 
		<div class="mainbar">
			<div class="article" >
				<h2><span><?php echo $title; ?></span> </h2>
				<p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
				
				<div class="clr"></div>
				<div class="img">
					<form name="search_user" onsubmit="return(chk_user());" action="<?php echo site_url("report/handling_performance_compare_search");?>" method="post">
						<table style="border:solid 1px #ccc;align:center" width="300px" cellspacing="0" cellpadding="0">
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="right"><label>Date</label></td>
								<td>:</td>
								<td>
									<input type="date" style="width:130px;" id="perform_search_date" name="perform_search_date"/>
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
					<?php
					if($flag==1)
					{
					?>
					<table width="650px">
						<tr>
							<th class="gridDark" rowspan="2">Sl</th>
							<th class="gridDark" rowspan="2">Vessel</th>
							<th class="gridDark" rowspan="2">Rotation</th>
							<th class="gridDark" rowspan="2">Berth</th>
							<th class="gridDark" rowspan="2">Agent</th>
							<th class="gridDark" colspan="2">Discharge</th>
							<th class="gridDark" colspan="2">Loading</th>
							<th class="gridDark" rowspan="2">Action</th>
						</tr>
						<tr>
							<th class="gridDark">Actual</th>
							<th class="gridDark">CTMS</th>
							<th class="gridDark">Actual</th>
							<th class="gridDark">CTMS</th>
						</tr>
						<?php
						$dis_actual="";
						$dis_ctms="";
						$load_actual="";
						$load_ctms="";
						
						$btn_disable="";
						
						for($i=0;$i<count($rslt_performance_search);$i++)
						{
							//--
							$tmp_ata=$perform_search_date;
							$tmp_vvd_gkey=$rslt_performance_search[$i]['cvcvd_gkey'];
							
							$sql_mismatch="SELECT IFNULL(id,0) AS id,discharge_actual,discharge_ctms,loading_actual,loading_ctms 
							FROM ctmsmis.handlingperformancecompare 
							WHERE ata_dt='$tmp_ata' AND vvd_gkey='$tmp_vvd_gkey'
							ORDER BY entry_dt DESC LIMIT 1";
							
							$rslt_mismatch=mysql_query($sql_mismatch);
							
							$row_mismatch=mysql_fetch_object($rslt_mismatch);
							
							$id=$row_mismatch->id;
							$dis_actual=$row_mismatch->discharge_actual;
							$dis_ctms=$row_mismatch->discharge_ctms;
							$load_actual=$row_mismatch->loading_actual;
							$load_ctms=$row_mismatch->loading_ctms;
							
							// if($dis_actual!="" or $dis_ctms!="" or $load_actual!="" or $load_ctms!="")
								// $btn_disable=1;
							//--
						?>
						<tr>
							<form name="actual_ctms_entry_form" id="actual_ctms_entry_form" action="<?php echo site_url("report/actual_ctms_entry_action")?>" method="post">
								<input type="hidden" id="tbl_id" name="tbl_id" value="<?php echo $id; ?>" />
								<input type="hidden" id="vvd_gkey_entry" name="vvd_gkey_entry" value="<?php echo $rslt_performance_search[$i]['cvcvd_gkey']; ?>" />
								<input type="hidden" id="ata_dt_entry" name="ata_dt_entry" value="<?php echo $rslt_performance_search[$i]['ata_dt']; ?>" />
								<input type="hidden" id="perform_search_date_entry" name="perform_search_date_entry" value="<?php echo $perform_search_date; ?>" />
								
								<td class="gridLight" align="center"><?php echo $i+1; ?></td>
								<td class="gridLight" align="center">
									<input style="width:50px" type="text" id="vsl_name_entry" name="vsl_name_entry" value="<?php echo $rslt_performance_search[$i]['name']; ?>" />
								</td>
								<td class="gridLight" align="center">
									<input style="width:50px" type="text" id="rot_entry" name="rot_entry" value="<?php echo $rslt_performance_search[$i]['ib_vyg']; ?>" />
								</td>
								<td class="gridLight" align="center">
									<input style="width:50px" type="text" id="berth_entry" name="berth_entry" value="<?php echo $rslt_performance_search[$i]['berth']; ?>" />
								</td>
								<td class="gridLight" align="center">
									<input style="width:50px" type="text" id="agent_entry" name="agent_entry" value="<?php echo $rslt_performance_search[$i]['agent']; ?>" />
								</td>
								<td class="gridLight" align="center">
									<input style="width:50px" type="text" id="discharge_actual_entry" name="discharge_actual_entry" value="<?php echo $dis_actual; ?>" />
								</td>
								<td class="gridLight" align="center">
									<input style="width:50px" type="text" id="discharge_ctms_entry" name="discharge_ctms_entry" value="<?php echo $dis_ctms; ?>" />
								</td>
								<td class="gridLight" align="center">
									<input style="width:50px" type="text" id="loading_actual_entry" name="loading_actual_entry" value="<?php echo $load_actual; ?>" />
								</td>
								<td class="gridLight" align="center">
									<input style="width:50px" type="text" id="loading_ctms_entry" name="loading_ctms_entry" value="<?php echo $load_ctms; ?>"  />
								</td>
								<td class="gridLight" align="center">
									<input type="submit" id="save_entry" name="save_entry" value="Save" class="login_button" onclick="return chk_confirm();"  />
								</td>
							</form>
						</tr>
						<?php
						}
						?>
						<form name="add_new_form" id="add_new_form" action="<?php echo site_url("report/add_new_form_action")?>" method="post">
							<input type="hidden" id="perform_search_date_entry_new" name="perform_search_date_entry_new" value="<?php echo $perform_search_date; ?>" />
							<tr>
								<td class="gridLight" align="center"><?php echo $i+1; ?></td>
								<td class="gridLight" align="center"><input style="width:50px" type="text" name="vsl_name_new" id="vsl_name_new" /></td>
								<td class="gridLight" align="center"><input style="width:50px" type="text" name="rot_new" id="rot_new" /></td>
								<td class="gridLight" align="center"><input style="width:50px" type="text" name="berth_new" id="berth_new" /></td>
								<td class="gridLight" align="center"><input style="width:50px" type="text" name="agent_new" id="agent_new" /></td>
								<td class="gridLight" align="center"><input style="width:50px" type="text" name="dis_act_new" id="dis_act_new" /></td>
								<td class="gridLight" align="center"><input style="width:50px" type="text" name="dis_ctms_new" id="dis_ctms_new" /></td>
								<td class="gridLight" align="center"><input style="width:50px" type="text" name="load_act_new" id="load_act_new" /></td>
								<td class="gridLight" align="center"><input style="width:50px" type="text" name="load_ctms_new" id="load_ctms_new" /></td>
								<td class="gridLight" align="center"><input style="width:50px" type="submit" name="add_new" id="add_new" value="Add" class="login_button" /></td>
							</tr>
						</form>
					</table>
					<?php
					}
					?>
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
	