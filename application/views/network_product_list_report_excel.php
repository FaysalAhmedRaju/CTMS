<html>
<?php if($_POST['fileOptions']=='html'){?>
<HTML>
	<HEAD>
		<TITLE> Report</TITLE>
		<LINK href="../css/report.css" type=text/css rel=stylesheet>
	    <style type="text/css">
<!--
.style1 {font-size: 12px}
-->
        </style>
</HEAD>
<BODY>

	<?php } 
	else if($_POST['fileOptions']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=Product_Report.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	} ?>
<head>
	<table align="center" width="95%">
		<tr>
			<td  align="center"><img align="middle"  width="235px" height="80x" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
		</tr>
		<tr></br></tr>
		<tr>
			<td align="center"><font size="4"><b>PRODUCT REPORT</b></font></td>
		</tr>
		<tr></br></tr>
		<tr></br></tr>
		<tr align="center">
			<tr><td align="center"> <?php echo $tableTitle; ?></td></tr>
		</tr>			
	</table>	
</head>
<body>	
<div align ="center">
	<table border="1" align="center" width="90%" style="border-collapse:collapse">
		<thead>
			<tr>
				<th>Sl</th>
				<th>Product Category</th>
				<th>Product Name</th>
				<th>Serial No.</th>
				<th>IMEI No.</th>
				<th>Location Details</th>
				<th>IP Address</th>
				<th>Model/Dec</th>
				<th>Received Date</th>
			</tr>
		</thead>
		<?php
		for($i=0;$i<count($rslt_product_list);$i++)
		{
		?>
		<tr>
			<td align="center"><?php echo $i+1;?></td>
            <td align="center"><?php echo $rslt_product_list[$i]['short_name']?></td>   
			<td align="center"><?php echo $rslt_product_list[$i]['prod_name']?></td>   
			<td align="center"><?php echo $rslt_product_list[$i]['prod_serial']?></td>   
            <td align="center"><?php echo $rslt_product_list[$i]['imei_number']?></td>
			<td align="center"><?php echo $rslt_product_list[$i]['location_details']?></td>   
			<td align="center"><?php echo $rslt_product_list[$i]['prod_ip']?></td>  		 
			<td align="center"><?php echo $rslt_product_list[$i]['prod_deck_id']?></td>  
            <td align="center"><?php echo $rslt_product_list[$i]['prod_rcv_date']?></td> 
		</tr>
		<?php
		}
		?>
	</table>			
</div>
	
</body>
<!--/html-->
<?php 
	mysql_close($con_sparcsn4);
	if($_POST['options']=='html'){?>	
		</BODY>
	</HTML>
<?php }?>
