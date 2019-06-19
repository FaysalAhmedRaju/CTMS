<script type="text/javascript">
	function changeTextBox(val)
	{
		var div_office_code = document.getElementById("div_office_code");
		var div_c_number = document.getElementById("div_c_number");
		var div_c_date = document.getElementById("div_c_date");
		var div_entry_date = document.getElementById("div_entry_date");
		var div_cont_no = document.getElementById("div_cont_no");
		
		if(val=="office_code")
		{
			div_office_code.style.display="inline";
			div_c_number.style.display="none";
			div_c_date.style.display="none";
			div_entry_date.style.display="none";
			div_cont_no.style.display="none";
		}
		else if(val=="c_number")
		{
			div_office_code.style.display="none";
			div_c_number.style.display="inline";
			div_c_date.style.display="none";
			div_entry_date.style.display="none";
			div_cont_no.style.display="none";
		}
		else if(val=="c_date")
		{
			div_office_code.style.display="none";
			div_c_number.style.display="none";
			div_c_date.style.display="inline";
			div_entry_date.style.display="none";
			div_cont_no.style.display="none";
		}
		else if(val=="entry_date")
		{
			div_office_code.style.display="none";
			div_c_number.style.display="none";
			div_c_date.style.display="none";
			div_entry_date.style.display="inline";
			div_cont_no.style.display="none";
		}
		else if(val=="cont_no")
		{
			div_office_code.style.display="none";
			div_c_number.style.display="none";
			div_c_date.style.display="none";
			div_entry_date.style.display="none";
			div_cont_no.style.display="inline";
		}
	}
	
	function validate()
	{
		var search_by=document.search_by_form.search_by.value;
		
		if(search_by == "")
		{
			alert("Provide a search value");
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
					<form name="search_by_form" id="search_by_form" onsubmit="return validate();" action="<?php echo site_url("report/search_be_list");?>"  method="post">	
						<table align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="11" align="center"><span><font color="green"  size="4" style="font-weight: bold"><nobr><?php echo $tableTitle; ?></nobr></font></span> </td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td align="left" >
									<label for=""><nobr><b>Search By :</b></nobr><em>&nbsp;</em></label>
								</td>
								<td>
									<select id="search_by" name="search_by" onchange="changeTextBox(this.value);">
										<option value="">--Select--</option>
										<option value="office_code">Office Code</option>
										<option value="c_number">BE Number</option>
										<option value="c_date">BE Date</option>
										<option value="entry_date">Entry Date</option>
										<option value="cont_no">Container No</option>
									</select>
								</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>
									<label for=""><nobr><b>Search Value :</b></nobr><em>&nbsp;</em></label>
								</td>
								<td>
									<div id="div_office_code" style="">
										<input type="text" style="width:170px" id="search_office_code" name="search_office_code" />
									</div>
									<div id="div_c_number" style="display:none;">
										<input type="text" style="width:170px" id="search_c_number" name="search_c_number" />
									</div>
									<div id="div_c_date" style="display:none;">
										<input type="date" style="width:170px" id="search_c_date" name="search_c_date" />
									</div>
									<div id="div_entry_date" style="display:none;">
										<input type="date" style="width:170px" id="search_entry_date" name="search_entry_date" />
									</div>
									<div id="div_cont_no" style="display:none;">
										<input type="text" style="width:170px" id="search_cont_no" name="search_cont_no" />
									</div>
								</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td align="center" width="70px">
									<input type="submit" value="Search" name="View" class="login_button">
								</td>		
							</tr>
						</table>
					</form>
					<br>
					<?php
					if(count($rslt_list_of_be)!=0)
					{
					?>
					<table align="center" style="width:550px">
						<tr>
							<th class="gridDark" colspan="6">Bill of Entry List</th>
						</tr>
						<tr>
							<th class="gridDark">Sl</th>
							<th class="gridDark">Office Code</th>
							<th class="gridDark">C Number</th>
							<th class="gridDark">Date</th>
							<th class="gridDark">Total Container</th>
							<th class="gridDark">Action</th>
							<!--th class="gridDark">Action</th-->
						</tr>
						<?php
						include('mydbPConnection.php');
						$j=$start;
						for($i=0;$i<count($rslt_list_of_be);$i++)
						{
							$j++;
							$reg_no=$rslt_list_of_be[$i]['reg_no'];
							$reg_date=$rslt_list_of_be[$i]['reg_date'];		//
							
							$sql_tot_cont="SELECT COUNT(*) AS tot_cont 
							FROM sad_container
							INNER JOIN sad_info ON sad_info.id=sad_container.sad_id
							WHERE reg_no='$reg_no' and reg_date='$reg_date'";
							
							$rslt_tot_cont=mysql_query($sql_tot_cont);
							
							$row_tot_cont=mysql_fetch_object($rslt_tot_cont);
							$tot_cont=$row_tot_cont->tot_cont;
						?>
						<tr>
							<td class="gridLight" align="center"><?php echo $j; ?></td>
							<td class="gridLight" align="center"><?php echo $rslt_list_of_be[$i]['office_code']; ?></td>
							<td class="gridLight" align="center"><?php echo $rslt_list_of_be[$i]['reg_no']; ?></td>
							<td class="gridLight" align="center"><?php echo $rslt_list_of_be[$i]['reg_date']; ?></td>							
							<td class="gridLight" align="center"><?php echo $tot_cont; ?></td>							
							<td class="gridLight" align="center">
								<form action="<?php echo site_url("report/xml_conversion_action");?>"  method="post" target="_blank">
									<input type="hidden" name="office_code" id="office_code" value="<?php echo $rslt_list_of_be[$i]['office_code']; ?>" />
									<input type="hidden" name="c_nubmber" id="c_nubmber" value="<?php echo $rslt_list_of_be[$i]['reg_no']; ?>" />
									<input type="hidden" name="xml_date" id="xml_date" value="<?php echo $rslt_list_of_be[$i]['reg_date']; ?>" />
									<input type="submit" name="view" id="view" value="View" class="login_button" />
								</form>
							</td>
							<!--td class="gridLight" align="center">
								<form action="<?php echo site_url("report/xml_conversion_action");?>"  method="post" target="_blank">
									<input type="hidden" name="office_code" id="office_code" value="<?php echo $rslt_list_of_be[$i]['office_code']; ?>" />
									<input type="hidden" name="c_nubmber" id="c_nubmber" value="<?php echo $rslt_list_of_be[$i]['reg_no']; ?>" />
									<input type="hidden" name="xml_date" id="xml_date" value="<?php echo $rslt_list_of_be[$i]['reg_date']; ?>" />
									<input type="submit" name="view" id="view" value="View Container" class="login_button" style="width:100px" />
								</form>
							</td-->
						</tr>
						<?php
						}
						?>
						<tr>
							<td colspan="6" align="center"><p><?php echo $links; ?></p></td>
						</tr>
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