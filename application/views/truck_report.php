<HTML>
	<HEAD>
	    <style type="text/css"></style>
	</HEAD>
	<BODY>
		<table class="tbl" width="100%" border ='0' cellpadding='0' cellspacing='0' >
			<tr align="center">
				<td colspan="3" align="center"><img width="200px" height="60px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			<tr align="center">
				<td colspan="3" align="center"> TRUCK REPORT </td>
			</tr>
		</table>
		<table width="70%" border ='0' align="center">
			<tr>
				<td width="100px"><font >C&F Name</font></td>
				<td width="10px"><font >:</font></td>
				<td><font ><?php echo $rslt_cnf_info[0]['u_name']; ?></font></td>
			</tr>
			<tr>
				<td width="100px"><font >Container No.</font></td>
				<td width="10px"><font >:</font></td>
				<td><font ><?php echo $rslt_truck_report[0]['cont_id']; ?></font></td>
			</tr>
			<tr>
				<td width="100px"><font >Assignment Type</font></td>
				<td width="10px"><font >:</font></td>
				<td><font ><?php echo $rslt_truck_report[0]['assign_type']; ?></font></td>
			</tr>
			<tr>
				<td width="100px"><font >Delivery Time Slot</font></td>
				<td width="10px"><font >:</font></td>
				<td><font ><?php echo $rslt_truck_report[0]['dlv_time_slot']; ?></font></td>
			</tr>
			<?php 
			include('dbConection.php');
			
			$js_id=$rslt_truck_report[0]['jetty_sirkar_id'];
			
			$sql_js_name="SELECT js_name FROM ctmsmis.mis_jetty_sirkar WHERE id='$js_id'";
			
			$rslt_js_name=mysql_query($sql_js_name);
			
			$row_js_name=mysql_fetch_object($rslt_js_name);
			
			$js_name=$row_js_name->js_name;
			?>
			<tr>
				<td width="100px"><font >Jetty Sarkar</font></td>
				<td width="10px"><font >:</font></td>
				<td><font ><?php echo $js_name; ?></font></td>
			</tr>
			<tr>
				<td width="100px"><font >Truck No.</font></td>
				<td width="10px"><font >:</font></td>
				<td><font ><?php echo $rslt_truck_report[0]['truck_id']; ?></font></td>
			</tr>
			<tr>
				<td width="100px"><font >BE No.</font></td>
				<td width="10px"><font >:</font></td>
				<td><font ><?php echo $rslt_truck_report[0]['BE_No']; ?></font></td>
			</tr>
		</table>
		<table border="0" align="center" width="80%">
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td align="right"><?php echo "Print at : " . date("Y-m-d") . "<br>";?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
		</table>
	</BODY>
</HTML>