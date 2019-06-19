<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>Bearth Operator</TITLE>
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
		header("Content-Disposition: attachment; filename=IMPORT_SUMMERY.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}
	
	
	?>
<html>
<title>CONTAINER HISTORY REPORT</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				
				<tr align="center">
					<td colspan="12"><img width="250px" height="80px" src="<?php echo IMG_PATH?>cpanew.jpg"> &nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>
			
				<tr align="center">
					<td colspan="12"><font size="4"><b>Country Wise Container Report</u></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b>Country Name : <?php echo $countryName;?></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4">From Date  :  <?php echo $fromdate;?>&nbsp;&nbsp;&nbsp;&nbsp; To Date  :   <?php echo $todate;?></font></td>
				</tr>
			</table>
		
		</td>
		
	</tr>
	
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr>
	</table>
	<table width="70%" align="center" border ='1' cellpadding='0' cellspacing='0'>
	<tr align="center">
		<td style="border-width:3px;border-style: double;"><b>SL.</b></td>
		<td style="border-width:3px;border-style: double;"><b>COUNTRY NAME</b></td>
		<td style="border-width:3px;border-style: double;"><b>YEAR</b></td>
		<td style="border-width:3px;border-style: double;"><b>BOX</b></td>
		<td style="border-width:3px;border-style: double;"><b>TEUS</b></td>
		<td style="border-width:3px;border-style: double;"><b>TONNAGE</b></td>
	</tr>

<?php

	for($i=0;$i<count($reslt);$i++)
		{ ?>
		<tr align="center">
			<td width="20px"  align="center">
				<?php echo $i+1; ?>
			</td>
			<td align="center">
				<?php echo $reslt[$i]['cnty']; ?>
			</td>
			<td align="center">
				<?php echo $reslt[$i]['yr']; ?>
			</td>
			<td align="center">
				<?php echo $reslt[$i]['box']; ?>
			</td>
			<td align="center">
				<?php echo $reslt[$i]['teus']; ?>
			</td>
			<td align="center">
				<?php echo $reslt[$i]['tonnage']; ?>
			</td>
	
		
		</tr>

		<?php } ?>
		</table>
	<br />
	<br />
<?php 
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
