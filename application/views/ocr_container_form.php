 <html>
	<head>
		 <meta http-equiv="refresh" content="10">
		 <style>
			body{font-family: "Calibri";}
		 </style>
	</head>
	<body>
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
				<!--p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p-->
			
				<div class="clr"></div>
				<div class="img">
					<!--form name="search_by_form" id="search_by_form" onsubmit="return validate();" action="<?php echo site_url("report/ocr_container_list");?>"  method="post">	
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
					</form-->
					<br>
					<?php
					include('dbConection.php');
					$sql_ocr_cont="SELECT * FROM ctmsmis.mis_ocr_info 
					WHERE entry_dt=DATE(NOW())
					ORDER BY entry_dt_time DESC LIMIT 100";
					$rslt_ocr_cont=mysql_query($sql_ocr_cont);							
					?>
					<table align="center" style="width:90%">
						<tr>
							<th colspan="14"><img align="middle"  width="200px" height="70px" src="<?php echo IMG_PATH?>cpanew.jpg"></th>
						</tr>
						<tr>
							<th colspan="14"><b><font size="6">Gate out Container List</font></b></th>
						</tr>
						<tr>
							<th colspan="14"><b><font size="5">Gate : CPAR </font></b></th>
						</tr>
						<tr bgcolor="#CBCACA">
							<th class="gridDark">Sl</th>
							<th class="gridDark">Office Code</th>
							<th class="gridDark">Bill Of Entry Number</th>
							<th class="gridDark">Date</th>
							<th class="gridDark">Container</th>
							<th class="gridDark">Freight Kind</th>
							<th class="gridDark">Assignment Type</th>
							<th class="gridDark">Assignment Date</th>
							<th class="gridDark">Offdock</th>
							<th class="gridDark">C&F</th>
							<th class="gridDark">Trailer Number</th>
							<th class="gridDark">Actual Gate Out</th>
							<th class="gridDark">Status</th>
							<!--th class="gridDark">Total Container</th-->
							<th class="gridDark">Action</th>
							<!--th class="gridDark">Action</th-->
						</tr>
						<?php
						
						$j=$start;
						while($row_ocr_dtl=mysql_fetch_object($rslt_ocr_cont))
						{
							include('mydbPConnection.php');
							//echo $row_ocr_dtl->cont_number;
							
							$get_offdock_name="SELECT Organization_Name FROM igm_detail_container 
							INNER JOIN igm_details ON igm_details.id=igm_detail_container.igm_detail_id 
							INNER JOIN organization_profiles ON igm_detail_container.off_dock_id= organization_profiles.id 
							WHERE igm_detail_container.cont_number='$row_ocr_dtl->cont_number'
							ORDER BY igm_detail_container.id DESC LIMIT 1";
							$rslt_offdock=mysql_query($get_offdock_name);	
							
							$row_offdock=mysql_fetch_object($rslt_offdock);
							
							$sql_sad_info="SELECT office_code,reg_no,reg_date FROM sad_info INNER JOIN sad_container ON sad_container.`sad_id`=sad_info.`id`
							WHERE sad_container.`cont_number`='".$row_ocr_dtl->cont_number."'";
							$rslt_sad_cont=mysql_query($sql_sad_info);	
							
							$row_sad_dtl=mysql_fetch_object($rslt_sad_cont);
							//{
							$j++;
							$reg_no=$row_sad_dtl->reg_no;
							$reg_date=$row_sad_dtl->reg_date;		//
							
							$sql_tot_cont="SELECT COUNT(*) AS tot_cont 
							FROM sad_container
							INNER JOIN sad_info ON sad_info.id=sad_container.sad_id
							WHERE reg_no='$reg_no' and reg_date='$reg_date'";
							
							$rslt_tot_cont=mysql_query($con_cchaportdb,$sql_tot_cont);
							
							$row_tot_cont=mysql_fetch_object($rslt_tot_cont);
							$tot_cont=$row_tot_cont->tot_cont;
							
							include('dbConection.php');
							$sql_gate_cont="SELECT sparcsn4.road_truck_visit_details.bat_nbr
							FROM sparcsn4.road_truck_visit_details
							INNER JOIN sparcsn4.road_truck_transactions ON sparcsn4.road_truck_transactions.truck_visit_gkey=sparcsn4.road_truck_visit_details.tvdtls_gkey
							WHERE sparcsn4.road_truck_transactions.ctr_id='$row_ocr_dtl->cont_number'
							ORDER BY sparcsn4.road_truck_visit_details.tvdtls_gkey DESC LIMIT 1";
							$rslt_gate_cont=mysql_query($sql_gate_cont);	
							$row_batNo=mysql_fetch_object($rslt_gate_cont);
							mysql_close($con_sparcsn4);
						?>
						<tr <?php if($row_ocr_dtl->legal_delivery_st=="1") { ?> bgcolor="#DAF7A6" <?php } else { ?> bgcolor="#FA1502" <?php } ?>>
							<td  align="center"><b><font color="black"><?php echo $j; ?></font></b></td>
							<td  align="center"><b><font color="black"><?php echo $row_sad_dtl->office_code; ?></font></b></td>
							<td  align="center"><b><font color="black"><?php echo $row_sad_dtl->reg_no; ?></font></b></td>
							<td  align="center"><b><font color="black"><?php echo $row_sad_dtl->reg_date; ?></font></b></td>							
							<td  align="center"><b><font color="black"><?php echo $row_ocr_dtl->cont_number; ?></font></b></td>							
							<td  align="center"><b><font color="black"><?php echo $row_ocr_dtl->freight_kind; ?></font></b></td>							
							<td  align="center"><b><font color="black"><?php echo $row_ocr_dtl->assign_type; ?></font></b></td>							
							<td  align="center"><b><font color="black"><?php echo $row_ocr_dtl->assign_dt; ?></font></b></td>							
							<td  align="center"><b><font color="black"><?php echo $row_offdock->Organization_Name; ?></font></b></td>							
							<td  align="center"><b><font color="black"><?php echo $row_ocr_dtl->cf_name; ?></font></b></td>		
							<td  align="center"><b><font color="black"><?php echo $row_batNo->bat_nbr; ?></font></b></td>								
							<td  align="center"><b><font color="black"><?php echo $row_ocr_dtl->entry_dt_time; ?></font></b></td>							
							<td  align="center"><b><font color="black"><?php if($row_ocr_dtl->legal_delivery_st=="1") echo "OK"; else echo "Fault"; ?></font></b></td>							
							<td  align="center">
								<?php if($row_sad_dtl->reg_no!="") { ?>	
								<form action="<?php echo site_url("report/xml_conversion_action");?>"  method="post" target="_blank">
									<input type="hidden" name="office_code" id="office_code" value="<?php echo $row_sad_dtl->office_code; ?>" />
									<input type="hidden" name="c_nubmber" id="c_nubmber" value="<?php echo $row_sad_dtl->reg_no; ?>" />
									<input type="hidden" name="xml_date" id="xml_date" value="<?php echo $row_sad_dtl->reg_date; ?>" />
							
									<input type="submit" name="view" id="view" value="View" class="login_button" />
								
								</form>
							<?php } ?>
							</td>
							<!--td class="gridLight" align="center">
								<form action="<?php echo site_url("report/xml_conversion_action");?>"  method="post" target="_blank">
									<input type="hidden" name="office_code" id="office_code" value="<?php echo $row_sad_dtl->office_code; ?>" />
									<input type="hidden" name="c_nubmber" id="c_nubmber" value="<?php echo $row_sad_dtl->reg_no; ?>" />
									<input type="hidden" name="xml_date" id="xml_date" value="<?php echo $row_sad_dtl->reg_date; ?>" />
									<input type="submit" name="view" id="view" value="View Container" class="login_button" style="width:100px" />
								</form>
							</td-->
						</tr>
						<?php
							//}
							}
						?>
						<tr>
							<td colspan="7" align="center"><p><?php echo $links; ?></p></td>
						</tr>
					</table>
				</div>
				<div class="clr"></div>
			</div>
		</div>
		
		<div class="clr"></div>
	</div>
</div>
</body>
</html>