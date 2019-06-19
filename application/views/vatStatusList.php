<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>VAT STATUS</TITLE>
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
		header("Content-Disposition: attachment; filename=VAT_STATUS.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}

	?>
<html>
<title>Vat Status List</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				
				<tr align="center">
					<td colspan="12"><font size="4"><b>CHITTAGONG PORT AUTHORITY</b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12">
						<table>
							<tr>
								<td><font size="4"><b>Rotation : <?php echo $rotation_no; ?></b></font></td>
								<td><font size="4"><b>MLO : <?php if($mloName=="") { echo "ALL" ; } else { echo $mloName; } ?></b></font></td>
							</tr>
						<table>
					</td>
				</tr>
				<tr align="center">
					<td colspan="8"><font size="4"><b>Total : <?php echo $countVat+$countNonVat; ?></b></font></td>
					<td colspan="2"><font size="4"><b> VAT : <?php echo $countVat; ?></b></font></td>
					<td colspan="2"><font size="4"><b> NON VAT : <?php echo $countNonVat; ?></b></font></td>
				</tr>

			</table>
		
		</td>
		
	</tr>
	
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr>
	</table>
	<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<tr  align="center">
		<td style="border-width:3px;border-style: double;"><b>SlNo</b></td>
		<td style="border-width:3px;border-style: double;"><b>MLO</b></td>
		<td style="border-width:3px;border-style: double;"><b>Container No</b></td>
		<td style="border-width:3px;border-style: double;"><b>Size</b></td>
		<td style="border-width:3px;border-style: double;"><b>Height</b></td>
		<td style="border-width:3px;border-style: double;"><b>Type</b></td>
		<td style="border-width:3px;border-style: double;"><b>Status</b></td>	
	</tr>
	<?php for($i=0;$i<count($rslt_vat_stat_list);$i++) { ?>
	<tr align="center">
			<td><?php  echo $i+1;?></td>
			<td><?php  echo $rslt_vat_stat_list[$i]['mlocode'];?></td>
			<td><?php  echo $rslt_vat_stat_list[$i]['cont_number'];?></td>
			<td><?php  echo $rslt_vat_stat_list[$i]['cont_size'];?></td>
			<td><?php  echo $rslt_vat_stat_list[$i]['cont_height'];?></td>
			<td><?php  echo $rslt_vat_stat_list[$i]['cont_status'];?></td>
			<td><?php  echo $rslt_vat_stat_list[$i]['vat_novat'];?></td>
		</tr>

<?php } ?>
</table>
<br />
<br />



<?php 
mysql_close($con);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
