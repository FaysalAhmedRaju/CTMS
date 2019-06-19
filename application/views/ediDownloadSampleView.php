<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>Shipping Agent</TITLE>
		<LINK href="../css/report.css" type=text/css rel=stylesheet>
	    <style type="text/css">
<!--
.style1 {font-size: 12px}
-->
        </style>
</HEAD>
<BODY>

	<?php } 
	else if($_POST['options']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=".$fileSample."_edi.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}
	//$ddl_imp_rot_no=$_REQUEST['ddl_imp_rot_no']; 

	//$con=mysql_connect("10.1.1.21", "sparcsn4","sparcsn4")or die("sparcsn4 database cannot connect"); 
	//mysql_select_db("ctmsmis")or die("cannot select DB");
	
	?>
<html>
<body>

		
			<table style="border-width:1px;" border ='1'>
					<tr><td width="80px"></td><td width="80px"></td></tr>
					<tr><td width="80px"></td><td width="80px"></td></tr>
					<tr><td bgcolor="#8CE67C" style="border-width:1px;" width="80px" align="left">Agent</td><td style="border-width:1px;" width="80px" align="right"><?php echo $result1[0]['agent']; ?></td></tr>
					<tr><td bgcolor="#8CE67C" style="border-width:1px;" width="80px" align="left">voy</td><td style="border-width:1px;" width="80px" align="right"><?php echo $result2[0]['Voy_No']; ?></td></tr>
					<tr><td bgcolor="#8CE67C" style="border-width:1px;" width="80px" align="left">call sign</td><td style="border-width:1px;" width="80px" align="right"><?php echo $result1[0]['radio_call_sign']; ?></td></tr>
					<tr><td bgcolor="#8CE67C" style="border-width:1px;" width="80px" align="left">Vessel Name</td><td style="border-width:1px;" width="80px"  align="right"><?php echo $result1[0]['name']; ?></td></tr>
					<tr><td bgcolor="#8CE67C" style="border-width:1px;" width="80px" align="left">Date</td><td style="border-width:1px;" width="80px" align="right"></td></tr>
					<tr><td bgcolor="#8CE67C" style="border-width:1px;" width="80px" align="left">LOP</td><td style="border-width:1px;" width="80px" align="right"><?php echo $result1[0]['LOP']; ?></td></tr>
					<tr><td bgcolor="#8CE67C" style="border-width:1px;" width="80px" align="left">Next Port</td><td style="border-width:1px;" width="80px" align="right"></td></tr>
                    <tr><td border="0" width="80px"></td><td border="0" width="80px"></td></tr>
			</table>
		

		<table border ='1'>
				<tr align="center">
					<td bgcolor="#F77B41" width="120px" style="border-width:1px;"><b>Container</b></td>
					<td bgcolor="#F77B41" width="120px" style="border-width:1px;"><b>ISO</b></td>
					<td bgcolor="#F77B41" width="75px" style="border-width:1px;"><b>Liner</b></td>
					<td bgcolor="#F77B41" width="75px" style="border-width:1px;"><b>Status</b></td>
					<td bgcolor="#F77B41" width="75px" style="border-width:1px;"><b>Weight</b></td>
					<td bgcolor="#F77B41" width="75px" style="border-width:1px;"><b>Booking</b></td>	
					<td bgcolor="#F77B41" width="75px" style="border-width:1px;"><b>Seal</b></td>	
					<td bgcolor="#F77B41" width="75px" style="border-width:1px;"><b>IMDG</b></td>
					<td bgcolor="#F77B41" width="75px" style="border-width:1px;"><b>UNNO</b></td>
					<td bgcolor="#F77B41" width="75px" style="border-width:1px;"><b>Temp</b></td>
					<td bgcolor="#F77B41" width="75px" style="border-width:1px;"><b>Load Port</b></td>
					<td bgcolor="#F77B41" width="120px" style="border-width:1px;"><b>Discharge Port</b></td>
					<td bgcolor="#F77B41" width="120px" style="border-width:1px;"><b>Stowage</b></td>	
				</tr>

<?php
	//echo $todate;
	for($i=0; $i<count($result); $i++){
	
	//echo$row->vvd_gkey;
	
?>
<tr align="center">
		<td align="left"><?php echo $result[$i]['cont_id'];?></td>
		<td align="right"><?php echo $result[$i]['isoType'];?></td>
		<td align="left"><?php echo $result[$i]['cont_mlo'];?></td>
		<td align="left"><?php echo $result[$i]['cont_status'];?></td>
		<td align="right"><?php echo $result[$i]['goods_and_ctr_wt_kg'];?></td>
		<td align="right"><?php echo $result[$i]['bookingNo'];?></td>
		<td align="left"><?php  echo $result[$i]['seal_no'];?></td>
		<td align="right"></td>
		<td align="right"></td>
		<td align="right"></td>

		<td align="left"><?php echo $result[$i]['load_port'];?></td>
		<td align="left"><?php echo $result[$i]['pod'];?></td>
		<td align="left"><?php echo $result[$i]['stowage_pos'];?></td>	
	</tr>
<?php } ?>
</table>
<br />
<br />



<?php 
mysql_close($con_ctmsmis);?>	
	</BODY>
</HTML>

