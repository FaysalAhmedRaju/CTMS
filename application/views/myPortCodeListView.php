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
<title>Port Code List</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				
				<!--tr align="center">
					<td colspan="12"><font size="4"><b>CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td>
				</tr-->
				<tr align="center">
					<td colspan="12" align="center"><img width="250px" height="80px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
				</tr>
			
				<tr align="center">
					<td colspan="12"><font size="4"><b><u>Port Code List</u></b></font></td>
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
		<td style="border-width:3px;border-style: double;"><b>PORT FULL NAME.</b></td>
		<td style="border-width:3px;border-style: double;"><b>CODE.</b></td>
		<td style="border-width:3px;border-style: double;"><b>NATION.</b></td>
		<td style="border-width:3px;border-style: double;"><b>PORT CODE.</b></td>
		
	</tr>

<?php
	include("dbConection.php");
	
	$query=mysql_query("select * from
			(
			select
			(select id from sparcsn4.ref_unloc_code where gkey=tbl.unloc_gkey) as id,
			(select place_name from sparcsn4.ref_unloc_code where gkey=tbl.unloc_gkey) as name,
			(select cntry_code from sparcsn4.ref_unloc_code where gkey=tbl.unloc_gkey) as contry_code,
			(select place_code from sparcsn4.ref_unloc_code where gkey=tbl.unloc_gkey) as port_code
			from 
			(
			select distinct unloc_gkey from sparcsn4.ref_routing_point
			) as tbl 
			) as final WHERE id REGEXP '[a-z]+' order by id");
	$i=0;

	
	$mlo="";
	while($row=mysql_fetch_object($query)){
	$i++;
	
	
?>
<tr align="center">
		<td><?php  echo $i;?></td>
		<td><?php if($row->name) echo $row->name; else echo "&nbsp;";?></td>
		<td><?php if($row->id) echo $row->id; else echo "&nbsp;";?></td>
		<td><?php if($row->contry_code) echo $row->contry_code; else echo "&nbsp;";?></td>
		<td><?php if($row->port_code) echo $row->port_code; else echo "&nbsp;";?></td>
				
	</tr>

<?php } ?>
</table>

<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>