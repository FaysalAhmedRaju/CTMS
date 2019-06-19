<div align ="center" style="margin:100px;">

	<!--div align="center" style="font-size:18px">
			<title><img align="middle"  width="220px" height="70px" src="<?php echo IMG_PATH?>cpanew.jpg"></title>
	</div>
		<div align="center"><font size="5"><b>INWARD & OUTWARD CONTAINER REGISTER</b></font></div-->

	<table width="100%">
	  <thead>
		<tr height="100px">
			<th align="center" colspan="8">
				<h2><img align="middle"  width="235px" height="75px" src="<?php echo IMG_PATH?>cpanew.jpg"></h2>
			</th>
		</tr>
		<tr bgcolor="#ffffff" height="50px">
			<th align="center" colspan="8"><font size="5"><b>ICD CONTAINER LIST</b></font></th>
		</tr>
		<tr bgcolor="#ffffff" height="50px"  colspan="8">
			<th  align="left"><font size="4"><b><?php echo $title; ?></b></font></td>
			<th  align="left"><font size="5"><b><?php echo "Visit ID: ".$vist_id;; ?></b></font></td>
			<!--th colspan="3" align="center"><font size="5"><b>File No: </b></font></td>
			<th colspan="3" ><font size="5"><b>Duty Hours:</b></font></td>
			<th colspan="2" align="right"><font size="5"><b><?php echo "Date:  ". $date; ?></b></font></td-->
		</tr>
		
		
		
		<tr>
			<th  style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b>SL.</b></th>
			<th  style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b>VESSEL NAME</b></th>
			<th  style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b>CONTAINER.NO.</b></th>
			<th  style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b>SIZE</b></th>
			<th  style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b><nobr>HEIGHT</nobr></b></th>
			<th  style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b><nobr>ROTATION</nobr></b></th>
			<th  style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b>TIME IN</b></th>
			<th  style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b>TIME OUT</b></th>
		</tr>
		
		</thead>
		

		<?php
			//	include_once("mydbPConnection.php");
			for($i=0;$i<count($result);$i++) { 
			?>
				<tr border ='1' cellpadding='0' cellspacing='0' style="font-size:12px;  border-collapse: collapse;">
					<td  style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $i+1;?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $result[$i]['name']?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $result[$i]['cont']?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $result[$i]['size']?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $result[$i]['height']?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $result[$i]['rot_no']?>
					</td>										
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $result[$i]['time_in']; ?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $result[$i]['time_out']; ?>
					</td>									
				</tr>
			<?php
			}
		?>
		<!--tr><td colspan='5' border='0'>Total Container :</td></tr-->
	
	</table>
</div>