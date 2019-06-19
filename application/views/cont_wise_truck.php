<html>
	<head>
		<script type="text/javascript">			
			function total_truck_number(val)
			{					
				var total_truck=document.getElementById("total_truck").value;
				
				var table = document.getElementById("truck_number_table");
				removeTableElement(table);
				
				//var t=1;
				
				for(var i=1;i <= total_truck;i++)
				{
					var tr = document.createElement('tr');
					
					var td1 = document.createElement('td');
					var text1 = document.createTextNode("Truck No "+i);
					td1.appendChild(text1);
					
					var td2 = document.createElement('td');
					var text2 = document.createTextNode(":");
					td2.appendChild(text2);
					
					var td3 = document.createElement('td');
					var input = document.createElement("input");
					input.type = "text";
					input.name = "truck_no_"+i;
					input.id = "truck_no_"+i;
					//input.value = "";
					input.style.width = "100px";
					td3.appendChild(input);
					
					tr.appendChild(td1);
					tr.appendChild(td2);
					tr.appendChild(td3);
					
					table.appendChild(tr);
					
					//t++;
				}
			}
			
			function removeTableElement(table)
			{
				var tblLen = table.rows.length;
				
				for(var i=tblLen;i>0;i--)
				{
					table.deleteRow(i-1);
				}				
			}			
			
			function save_action()
			{
				var container_no=document.getElementById('cont_no').value;
				
				document.getElementById("container_no").value=container_no;
			}
		</script>
	</head>
	<body>
	<div class="content">
		<div class="content_resize">
			<div class="mainbar">
				<div class="article">
					<h2><span><?php echo $title; ?></span> </h2>
					<p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
					<div class="clr"></div>
						<form name="cont_search_form" id="cont_search_form" method="post" action="<?php echo site_url('report/cont_wise_truck_search') ?>">
							<table align="center" style="border:solid 1px #ccc;" width="70%" align="center" cellspacing="0" cellpadding="0">
								<tr>
									<td>&nbsp;</td>
								</tr>
								
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><label>Container No.</label></td>
									<td>:</td>
									<td>
										<input type="text" style="width:180px;" id="cont_no" name="cont_no" value="<?php echo $container_no; ?>" />
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td colspan="3" align="center">
										<input type="submit" value="Search" class="login_button"/>      
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td colspan="3" align="center"><?php echo $msg; ?></td>
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
						<div style="width: 50%; height: 50%; float:left;">
							<form name="truck_wise_entry_form" id="truck_wise_entry_form" method="post" action="<?php echo site_url('report/truck_wise_entry_action')?>">						
								<input type="hidden" id="all_truck" name="all_truck"  />
								<input type="hidden" id="bizu_gkey" name="bizu_gkey" value="<?php echo $rslt_cont_truck_n4[0]['bizu_gkey'] ?>" />
								<input type="hidden" id="unit_gkey" name="unit_gkey" value="<?php echo $rslt_cont_truck_n4[0]['unit_gkey'] ?>" />
								<input type="hidden" id="assign_type" name="assign_type" value="<?php echo $rslt_cont_truck_n4[0]['assign_type'] ?>" />
								<input type="hidden" id="container_no" name="container_no"  />
								<table>
									<tr>
										<th class="gridDark" colspan="3">Form</th>
									</tr>
									<tr>
										<td class="gridLight">Gate No</td>
										<td class="gridLight">:</td>
										<td class="gridLight">
											<select name="gate" id="gate">  
												<option value="">--------Select--------</option>
												<?php for($i=0; $i<count($gateList); $i++){ ?>
													
												<option value="<?php echo $gateList[$i]['id'];?>"><?php echo $gateList[$i]['id'];?></option>
												
												<?php } ?>
											</select>	
									    </td>
									</tr>
									<!--tr>
										<td class="gridLight">Container</td>
										<td class="gridLight">:</td>
										<td class="gridLight">
											<input type="text" name="cont_no" id="cont_no" style="width:200px" onblur="return get_cont_data();" />
										</td>
									</tr-->
									<tr>
										<td class="gridLight">Total Truck</td>
										<td class="gridLight">:</td>
										<td class="gridLight">											
											<input type="text" name="total_truck" id="total_truck" style="width:130px" value="<?php echo $rslt_chk_entered_truck[0]['number_of_truck']; ?>" onblur="total_truck_number()" />
										</td>
									</tr>
									<?php
									if(count($rslt_truck_number_list)>0)
									{
									?>
									<tr>
										<td align="center" colspan="3">
											<table name="truck_number_table" id="truck_number_table" >
												<?php
												for($i=0;$i<$rslt_chk_entered_truck[0]['number_of_truck'];$i++)
												{
												?>
												<tr>
													<td>Truck No <?php echo $i+1;?> </td>
													<td>:</td>													
													<td><input type="text" name="truck_no_<?php echo $i+1;?>" id="truck_no_<?php echo $i+1;?>" value="<?php echo $rslt_truck_number_list[$i]['truck_number']; ?>" style="width:100px;" <?php if($rslt_truck_number_list[$i]['truck_number']!=""){?> readonly <?php } ?> /></td>
												</tr>
												<?php
												}
												?>
											</table>
										</td>
									</tr>	
									<?php
									}
									else
									{
									?>
									<tr>
										<td align="center" colspan="3">
											<table name="truck_number_table" id="truck_number_table" >
												<tr>
													<td></td>
												</tr>
											</table>
										</td>
									</tr>
									<?php
									}
									?>
									<tr>
										<td colspan="3" align="center">											
											<input type="submit" id="btn_save" name="btn_save" value="Save" class="login_button" onclick="return save_action();" />
										</td>
									</tr>
								</table>
							</form>							
						</div>
						<div style="width: 1%; height: 1%; float:left;">
							&nbsp;
						</div>
											
						<div style="width: 49%; height: 49%; float:right;">
							<table width="100%">
								<tr>
									<th class="gridDark" colspan="3">Info</th>
								</tr>
								<tr>
									<td width="20%" class="gridLight">Assignment Type</td>
									<td width="2%" class="gridLight">:</td>
									<td class="gridLight" id="assign_type"><?php echo $rslt_cont_truck_n4[0]['assign_type'] ?></td>
								</tr>
								<tr>
									<td width="20%" class="gridLight">Assignment Date</td>
									<td width="2%" class="gridLight">:</td>
									<td class="gridLight" id="assign_date"><?php echo $rslt_cont_truck_n4[0]['assign_date'] ?></td>
								</tr>
								<tr>
									<td width="20%" class="gridLight">Rotation</td>
									<td width="2%" class="gridLight">:</td>
									<td class="gridLight" id="rotation"><?php echo $rslt_cont_truck_n4[0]['rotation'] ?></td>
								</tr>
								<tr>
									<td width="20%" class="gridLight">Vessel Name</td>
									<td width="2%" class="gridLight">:</td>
									<td class="gridLight" id="vessel_name"><?php echo $rslt_cont_truck_n4[0]['vessel_name'] ?></td>
								</tr>
								<tr>
									<td width="20%" class="gridLight">C&F</td>
									<td width="2%" class="gridLight">:</td>
									<td class="gridLight" id="cnf"><?php echo $rslt_cont_truck_n4[0]['cnf'] ?></td>
								</tr>
								<tr>
									<td width="20%" class="gridLight">Pack Description</td>
									<td width="2%" class="gridLight">:</td>
									<td class="gridLight" id="Pack_Description"><?php echo $rslt_cont_truck_igm[0]['Pack_Description'] ?></td>
								</tr>
								<tr>
									<td width="20%" class="gridLight">Package Quantity</td>
									<td width="2%" class="gridLight">:</td>
									<td class="gridLight" id="Pack_Number"><?php echo $rslt_cont_truck_igm[0]['Pack_Number'] ?></td>
								</tr>
								<tr>
									<td width="20%" class="gridLight">Size</td>
									<td width="2%" class="gridLight">:</td>
									<td class="gridLight" id="cont_size"><?php echo $rslt_cont_truck_igm[0]['cont_size'] ?></td>
								</tr>
								<tr>
									<td width="20%" class="gridLight">Height</td>
									<td width="2%" class="gridLight">:</td>
									<td class="gridLight" id="cont_height"><?php echo $rslt_cont_truck_igm[0]['cont_height'] ?></td>
								</tr>
							</table>
						</div>	
						<?php
						}
						?>						
					<div class="clr"></div>
				</div>
			</div>
			<div class="sidebar">
				<?php include_once("mySideBar.php"); ?>
			</div>
			<div class="clr"></div>
		</div>
	</div>
	</body>
</html>