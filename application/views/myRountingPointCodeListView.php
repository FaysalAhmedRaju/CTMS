<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>BLOCKED CONTAINER LIST</TITLE>
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
		header("Content-Disposition: attachment; filename=EXPORT_SUMMERY.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}



	
	
	?>
<html>
<title>Routing Points</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				
				<tr align="center">
					<td colspan="12"><img align="middle" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
				</tr>
			
				<tr align="center">
					<td colspan="12"><font size="4"><b><u>Routing Points</u></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b></b></font></td>
				</tr>

				

			</table>
		
		</td>
		
	</tr>
	
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr>
	</table>
	<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<tr bgcolor="#A9A9A9" align="center" height="25px">
		<td style="border-width:3px;border-style: double;"><b>SlNo.</b></td>
		
		<td style="border-width:3px;border-style: double;"><b>ID.</b></td>
		<td style="border-width:3px;border-style: double;"><b>UnLoc.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Actual POD.</b></td>
		<td style="border-width:3px;border-style: double;"><b>UnLoc Place Name.</b></td>
		<td style="border-width:3px;border-style: double;"><b>UnLoc Country Name.</b></td>
		
	</tr>

<?php
	include("dbConection.php");
	
	$query=mysql_query("select ref_routing_point.id,ref_unloc_code.id as lok,ref_unloc_code.place_code,ref_unloc_code.place_name,
(select ref_country.cntry_name from ref_country where ref_country.cntry_code=ref_unloc_code.cntry_code) as cntname

from ref_routing_point 

inner join ref_unloc_code on ref_routing_point.unloc_gkey=ref_unloc_code.gkey
order by 1");
	$i=0;

	
	$mlo="";
	while($row=mysql_fetch_object($query)){
	$i++;
	
	
?>
<tr align="center">
		<td><?php  echo $i;?></td>
		
		<td><?php if($row->id) echo $row->id; else echo "&nbsp;";?></td>
		<td><?php if($row->lok) echo $row->lok; else echo "&nbsp;";?></td>
		<td><?php if($row->place_code) echo $row->place_code; else echo "&nbsp;";?></td>
		<td><?php if($row->place_name) echo $row->place_name; else echo "&nbsp;";?></td>
		<td><?php if($row->cntname) echo $row->cntname; else echo "&nbsp;";?></td>
				
	</tr>

<?php } ?>
</table>

<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
