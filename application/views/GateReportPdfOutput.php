
<html>
<head>
		<div align="center" style="">
			<title><b>CHITTAGONG PORT AUTHORITY</b></title>
		</div>
		<div align="center">ONE STOP SERVICE CENTER</div>
		<div align="center">Delivery Register</div>
		<?php 
		if($verify_number=="")
		{
			?>
			<div align="center">From Date : <?php echo $fromdate;?> To Date :  <?php echo $todate;?> </div>
		<?php
		}
		else 
		{
			?>
			<div align="center">Verification Number : <?php echo $verify_number;?></div>
			<?php
		}
		?>

</head>
<body>	
		<div align ="center">
			<table border="1" align="center"  cellpadding="1" cellspacing="1" style="font-size:12px;  border-collapse: collapse;">
				<thead style="">
					<tr style="border-top: 1px solid black;">		
						<th align="center" >Sl. No </th>
						<th align="center" >TRUCK NO.</th>
						<th align="center" >MANIFESTED MARKS</th>
						<th align="center" >CART TICKET MARKS</th>
						<th align="center" >CART TICKET QTY</th>
						<th align="center" >MANIFESTED QTY</th>
						<th align="center" >CLOSING BALANCE</th>
						<th align="center" >B.E NO</th>
						<th align="center" >R.O NO</th>
						<th align="center" >SHED NO</th>
						<th align="center" >SHIP NAME</th>
						<th align="center" >CLEARING FIRM</th>
						<th align="center" >TIME PASSED OUT</th>
						<th align="center" >SIGNATURE OF INSPECTOR GATE</th>
						<th align="center" >SIGNATURE OF JETTY SARKAR</th>
						<th align="center" >VERIFY NO</th>
						<th align="center" >DATE</th>
						<th align="center" >REMARKS</th>
					</tr>
				</thead>
				<tbody>
				 <?php       
				for($i=0;$i<count($rtnGateReportList);$i++) { 
				 ?>
				 <tr class="" style="page-break-inside:avoid; page-break-after:auto;border-top: 1px solid black;"> 
				   <td align="center">
				   <?php echo $i+1;?>
				  </td>
				  <td align="center">
				   <?php echo $rtnGateReportList[$i]['truck_id']?>
				  </td>
				  <td align="left">
				   <?php echo $rtnGateReportList[$i]['Pack_Marks_Number']?>
				  </td>
				  <td align="center">
				   <?php echo $rtnGateReportList[$i]['Pack_Marks_Number']?>
				  </td>
				  <td align="center">
				   <?php echo $rtnGateReportList[$i]['delv_pack']?>
				  </td>				
				  <td align="center">
				   <?php echo $rtnGateReportList[$i]['manifest_qty']?>
				  </td>
				  <td align="center">
				   <?php echo $rtnGateReportList[$i]['balance']?>
				  </td>
				  <td align="center">
				   <?php echo $rtnGateReportList[$i]['be_no']?>
				  </td>
				   <td align="center">
				   <?php echo $rtnGateReportList[$i]['exit_note_number']?>
				  </td>
				   <td align="center">
				   <?php echo $rtnGateReportList[$i]['shed_loc']?>
				  </td>
				   <td align="center">
				   <?php echo $rtnGateReportList[$i]['vessel_name']?>
				  </td>
				   <td align="center">
				   <?php echo $rtnGateReportList[$i]['cnf_agent']?>
				  </td>
				   <td align="center">
				   <?php echo $rtnGateReportList[$i]['date']?>
				  </td>
				   <td align="center">
				   <img id="sig_security" src="<?php echo IMG_PATH.'CnfSignature/'.$signaturePath; ?>" height=25 width=50 />
				  </td>
				   <td align="center">				   
				   <img id="sig_cnf" src="<?php echo IMG_PATH.'CnfSignature/'.$rtnGateReportList[$i]['signature_path']; ?>" height=25 width=50 />
				  </td>
				   <td align="center">
				   <?php echo $rtnGateReportList[$i]['verify_no']?>
				  </td>
				   <td align="center">
				   <?php echo $rtnGateReportList[$i]['dt']?>
				  </td>
				   <td align="center">
				   <?php echo $rtnGateReportList[$i]['remarks']?>
				  </td>
				  
				</tr>
				 <?php
				}
			   ?>
			</tbody>
			</table>
			
		</div>
	
</body>
</html>

