<html>
	<head>
		<script type="text/javascript">
		//	function truck_entry_validation()
			function truck_entry_validatio()
			{
				if( document.truck_entry_form.cnf_name.value == "" )
				{
					alert( "Please provide C&F name!" );
					document.truck_entry_form.cnf_name.focus();
					return false;
				}
				else if( document.truck_entry_form.container_no.value == "" )
				{
					alert( "Please provide Container No.!" );
					document.truck_entry_form.container_no.focus();
					return false;
				}
				else if( document.truck_entry_form.assignment_type.value == "" )
				{
					alert( "Please provide Assignment Type!" );
					document.truck_entry_form.assignment_type.focus();
					return false;
				}
				/*else if( document.truck_entry_form.delivery_time_slot.value == "" )
				{
					alert( "Please provide Delivery Slot!" );
					document.truck_entry_form.delivery_time_slot.focus();
					return false;
				}*/
				else if( document.truck_entry_form.jetty_sarkar.value == "" )
				{
					alert( "Please provide Jetty Sarkar!" );
					document.truck_entry_form.jetty_sarkar.focus();
					return false;
				}
				/*else if( document.truck_entry_form.total_truck.value == "" )
				{
					alert( "Please provide Total Truck Number.!" );
					document.truck_entry_form.total_truck.focus();
					return false;
				}
				else if( document.truck_entry_form.be_no.value == "" )
				{
					alert( "Please provide B/E No.!" );
					document.truck_entry_form.be_no.focus();
					return false;
				}*/
				// else if( document.truck_entry_form.truck_no.value == "" )
				// {
					// alert( "Please provide Truck No.!" );
					// document.truck_entry_form.truck_no.focus() ;
					// return false;
				// }
				else
				{
					truck_data();
				}
				return true ;
			}
			
			function truck_data()
			{
				var total_truck=document.getElementById("total_truck").value;
				
				var truck_no_id="";
				var truck_no="";
				var all_truck="";
				
				var t=1;
				
				for(var i=0;i<total_truck;i++)
				{
					truck_no_id="truck_no_"+t;
					
					truck_no=document.getElementById(truck_no_id).value;
					
					all_truck=all_truck.concat(truck_no);
					all_truck=all_truck.concat(",");
					t++;
				}
			
				var n = all_truck.length;
			
				all_truck = all_truck.substring(0,n-1);
				alert(all_truck);
				document.getElementById("all_truck").value=all_truck;
			}
		
			function get_assignment_dlvtime()
			{
				if (window.XMLHttpRequest) 
				{
				  xmlhttp=new XMLHttpRequest();
				} 
				else 
				{  
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				
				var container_no=document.getElementById('container_no').value;
				
				var url = "<?php echo site_url('ajaxController/get_assignment_dlvtime')?>?container_no="+container_no;
				
				xmlhttp.onreadystatechange=rtn_assignment_dlvtime;
				xmlhttp.open("GET",url,false);
							
				xmlhttp.send();
			}
			
			function rtn_assignment_dlvtime()
			{			
				if (xmlhttp.readyState==4 && xmlhttp.status==200) 
				{
					var val = xmlhttp.responseText;
					var jsonData = JSON.parse(val);
					
					document.getElementById("unit_gkey").value=jsonData[0].gkey;
					document.getElementById("assignment_type").value=jsonData[0].assign_type;
					document.getElementById("delivery_time_slot").value=jsonData[0].dlv_time_slot;					
				}
			}
			
			function total_truck_number()
			{
				var total_truck=document.getElementById("total_truck").value;
				
				var table = document.getElementById("truck_number_table");
				removeTableElement(table);
				
				var t=1;
				
				for(var i=0;i < total_truck;i++)
				{
					var tr = document.createElement('tr');
					
					var td1 = document.createElement('td');
					var text1 = document.createTextNode("Truck No "+t);
					td1.appendChild(text1);
					
					var td2 = document.createElement('td');
					var text2 = document.createTextNode(":");
					td2.appendChild(text2);
					
					var td3 = document.createElement('td');
					var input = document.createElement("input");
					input.type = "text";
					input.name = "truck_no_"+t;
					input.id = "truck_no_"+t;
					//input.value = "";
					input.style.width = "100px";
					td3.appendChild(input);
					
					tr.appendChild(td1);
					tr.appendChild(td2);
					tr.appendChild(td3);
					
					table.appendChild(tr);
					
					t++;
				}
			}
			
			function removeTableElement(table)
			{
				var tblLen = table.rows.length;
				
				for(var i=tblLen;i>1;i--)
				{
					table.deleteRow(i-1);
				}				
			}
		</script>
	</head>
	<body>
		<script type="text/javascript" src="<?php echo JS_PATH; ?>AdvancedCalender.js"></script>
	<div class="content">
		<div class="content_resize">
			<div class="mainbar">
				<div class="article">
					<h2><span><?php echo $title; ?></span> </h2>
					<p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
					<div class="clr"></div>
		
					<form name="truck_entry_form" id="truck_entry_form" action="<?php echo site_url("report/truck_entry_data"); ?>" method="POST" onsubmit="return truck_entry_validation();" enctype="multipart/form-data">
						<table id="truck_entry_table" name="truck_entry_table">
							<tr>
								<td align="center" colspan="3">
									<?php echo $msg;?>
								</td>
							</tr>
							<tr>
								<td>
									C&F Name
								</td>
								<td>
									<b>:</b>
								</td>
								<td>
									<input id="cnf_name" name="cnf_name" type="text" value="<?php echo $rslt_cnf_info[0]['u_name']?>" readonly /><font color="red" size="4"><b>&nbsp;*</b></font>
								</td>
							</tr>
							<tr>
								<td>
									Container No.
								</td>
								<td>
									<b>:</b>
								</td>
								<td>
									<input id="container_no" name="container_no" type="text" value="<?php echo $rslt_edit_truck[0]['cont_id']; ?>" onblur="get_assignment_dlvtime()" /><font color="red" size="4"><b>&nbsp;*</b></font>
									<input id="unit_gkey" name="unit_gkey" value="<?php echo $rslt_edit_truck[0]['unit_gkey']; ?>" type="hidden" />
									<input id="table_id" name="table_id" value="<?php echo $rslt_edit_truck[0]['id']; ?>" type="hidden" />
								</td>
							</tr>
							<tr>
								<td>
									Assignment Type
								</td>
								<td>
									<b>:</b>
								</td>
								<td>
									<input id="assignment_type" name="assignment_type" type="text" value="<?php echo $rslt_edit_truck[0]['assign_type']; ?>" readonly /><font color="red" size="4"><b>&nbsp;*</b></font>
								</td>
							</tr>
							<!--tr>
								<td>
									Delivery Time Slot
								</td>
								<td>
									<b>:</b>
								</td>
								<td>
									<input id="delivery_time_slot" name="delivery_time_slot" type="text" value="<?php echo $rslt_edit_truck[0]['dlv_time_slot']; ?>" readonly /><font color="red" size="4"><b>&nbsp;*</b></font>
								</td>
							</tr-->
							<tr>
								<td>
									Jetty Sarkar
								</td>
								<td>
									<b>:</b>
								</td>
								<td>
									<select id="jetty_sarkar" name="jetty_sarkar">
										<option value="">--Select--</option>
										<?php
										include('dbConection.php');
										
										$sql_jetty_sarkar="SELECT id,js_name
															FROM ctmsmis.mis_jetty_sirkar
															WHERE n4_bizu_gkey='$n4_bizu_gkey'";
															
										$rslt_jetty_sarkar=mysql_query($sql_jetty_sarkar);
										
										while($row_jetty_sarkar=mysql_fetch_object($rslt_jetty_sarkar))
										{
											$jetty_sarkar_id=$row_jetty_sarkar->id;
											$jetty_sarkar_name=$row_jetty_sarkar->js_name;
										?>
											<option value="<?php echo $jetty_sarkar_id; ?>"><?php echo $jetty_sarkar_name; ?></option>
										<?php
										}
										?>
									</select><font color="red" size="4"><b>&nbsp;*</b></font>
								</td>
							</tr>
							<?php
							if($is_edit==1)
							{
								$truck_id_all=$rslt_edit_truck[0]['truck_id'];
								$cnt=substr_count($truck_id_all,",");
							}
							?>
							<tr>
								<td>
									Total Truck
								</td>
								<td>
									<b>:</b>
								</td>
								<td>
									<input id="all_truck" name="all_truck" type="hidden" />
									<input id="total_truck" name="total_truck" type="text" value="<?php if($is_edit==1) { echo $cnt+1; } ?>" onblur="total_truck_number()" /><font color="red" size="4"><b>&nbsp;*</b></font>
								</td>
							</tr>
							<?php
							if($is_edit==1)
							{
								$truck_id=$rslt_edit_truck[0]['truck_id'];
							?>
							<tr>
								<td align="center" colspan="3">
									<table id="truck_number_table" name="truck_number_table">
									<?php
									$start=0;
									for($i=0;$i<($cnt+1);$i++)
									{
										$no=$i+1;
										$name="truck_no_".($i+1);
										$id="truck_no_".($i+1);
											
										$position=strpos($truck_id,",");	
										if($position==0)
											$truck_no_single=$truck_id;
										else
											$truck_no_single=substr($truck_id,$start,$position);
									?>
										<tr>
											<td>Truck No <?php echo $no; ?></td>
											<td>:</td>
											<td><input name="<?php echo $name; ?>" id="<?php echo $id; ?>" value="<?php echo $truck_no_single; ?>" /></td>
										</tr>
									<?php	
									if($position==0)
									{
										$start_next=0;
									}
									else
									{
										$start_next=$position+1;
									}
									$truck_id=substr($truck_id,$start_next);
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
									<table id="truck_number_table" name="truck_number_table">
										<tr>
											<td></td>
										</tr>
									</table>
								</td>
							</tr>
							<?php
							}
							?>
							<!--tr>
								<td>
									Truck No.
								</td>
								<td>
									<b>:</b>
								</td>
								<td>
									<input id="truck_no_1" name="truck_no_1" type="text" /><font color="red" size="4"><b>&nbsp;*</b></font>
								</td>
							</tr-->
							<!--tr>
								<td>
									B/E No.
								</td>
								<td>
									<b>:</b>
								</td>
								<td>
									<input id="be_no" name="be_no" type="text" value="<?php echo $rslt_edit_truck[0]['BE_No']; ?>" /><font color="red" size="4"><b>&nbsp;*</b></font>
								</td>
							</tr-->	
							<tr>
								<td colspan="3">&nbsp;</td>
							</tr>							
							<tr >
								<td>
								&nbsp;
								</td>
								<td align="right">
									<input type="submit" name="submit" id="submit" value="Save" style="width:60px;background:#07a3b9;">
								</td>
					</form>
								<td>
								<?php 
								include('dbConection.php');
								
								$sql_last_entry="SELECT id FROM ctmsmis.mis_cf_assign_truck ORDER BY truck_assign_time DESC LIMIT 1";
								
								$rslt_last_entry=mysql_query($sql_last_entry);
								
								$row_last_entry=mysql_fetch_object($rslt_last_entry);
								
								$truck_id=$row_last_entry->id;
								?>
								<form name="report_print" id="report_print" method="post" action="<?php echo site_url('report/truck_report')?>" target="_blank">
									<input type="hidden" name="id_report" id="id_report" value="<?php echo $truck_id; ?>">
									<input type="submit" name="print" id="print" value="Print" style="width:60px;background:#07a3b9;">
								</form>
								</td>
							</tr>
						</table>
					<!--/form-->	
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