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
<title>OFFDOC Blocked Container List</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				
				<tr align="center">
					<td colspan="12"><img align="middle"  width="235px" height="75px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
				</tr>
			
				<tr align="center">
					<td colspan="12"><font size="4"><b><u><?php echo $UserName?></u></b></font></td>
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
		<td style="border-width:3px;border-style: double;"><b>Container No.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Vessel Name.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Rotation.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Size.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Height.</b></td>
		<td style="border-width:3px;border-style: double;"><b>MLO</b></td>
		<td style="border-width:3px;border-style: double;"><b>Status</b></td>
		<td style="border-width:3px;border-style: double;"><b>Position</b></td>
		<td style="border-width:3px;border-style: double;"><b>IN Date</b></td>
		<td style="border-width:3px;border-style: double;"><b>Out Date</b></td>
		<td style="border-width:3px;border-style: double;"><b>Total Days</b></td>
	</tr>

<?php
include("dbConection.php");
	
	$query=mysql_query("SELECT *
					 FROM ctmsmis.mis_block_unit 
					 WHERE ctmsmis.mis_block_unit.offdoc_name ='$UserName'");
	$i=0;
	$j=0;
	
	$mlo="";
	while($row=mysql_fetch_object($query)){
	$i++;
	$sqlvsl_name=mysql_query("SELECT vsl_name FROM ctmsmis.mis_inv_unit WHERE id='$row->cont_id'");
	$rtnContvsl_name=mysql_fetch_object($sqlvsl_name);
	$convsl_name=$rtnContvsl_name->vsl_name;
	$sqlib_vyg=mysql_query("SELECT vsl_visit_dtls_ib_vyg FROM ctmsmis.mis_inv_unit WHERE id='$row->cont_id'");
	$rtnContib_vyg=mysql_fetch_object($sqlib_vyg);
	$conib_vyg=$rtnContib_vyg->vsl_visit_dtls_ib_vyg;
	$sqlsize=mysql_query("SELECT size FROM ctmsmis.mis_inv_unit WHERE id='$row->cont_id'");
	$rtnContsize=mysql_fetch_object($sqlsize);
	$consize=$rtnContsize->size;
	$sqlheight=mysql_query("SELECT height FROM ctmsmis.mis_inv_unit WHERE id='$row->cont_id'");
	$rtnContheight=mysql_fetch_object($sqlheight);
	$conheight=$rtnContheight->height;
	$sqlmlo=mysql_query("SELECT mlo FROM ctmsmis.mis_inv_unit WHERE id='$row->cont_id'");
	$rtnContmlo=mysql_fetch_object($sqlmlo);
	$contmlo=$rtnContmlo->mlo;
	$sqlfreight_kind=mysql_query("SELECT freight_kind FROM sparcsn4.inv_unit WHERE id='$row->cont_id' ORDER BY sparcsn4.inv_unit.gkey DESC LIMIT 1");
	$rtnfreight_kind=mysql_fetch_object($sqlfreight_kind);
	$contfreight_kind=$rtnfreight_kind->freight_kind;
	$sqlpostion=mysql_query("SELECT sparcsn4.inv_unit_fcy_visit.last_pos_name
							FROM sparcsn4.inv_unit 
							INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
							WHERE id='$row->cont_id' ORDER BY sparcsn4.inv_unit.gkey DESC LIMIT 1");
	$rtnConpostion=mysql_fetch_object($sqlpostion);
	$contpostion=$rtnConpostion->last_pos_name;
	$sqltime_out=mysql_query("SELECT sparcsn4.inv_unit_fcy_visit.time_out
							FROM sparcsn4.inv_unit 
							INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
							WHERE id='$row->cont_id' ORDER BY sparcsn4.inv_unit.gkey DESC LIMIT 1");
	$rtnContime_out=mysql_fetch_object($sqltime_out);
	$conttime_out=$rtnContime_out->time_out;
	$sqltime_in=mysql_query("SELECT sparcsn4.inv_unit_fcy_visit.time_in
							FROM sparcsn4.inv_unit 
							INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
							WHERE id='$row->cont_id' ORDER BY sparcsn4.inv_unit.gkey ASC LIMIT 1");
	$rtnContime_in=mysql_fetch_object($sqltime_in);
	$conttime_in=$rtnContime_in->time_in;
	$sqltotalDays=mysql_query("SELECT 
							TIMESTAMPDIFF(DAY,intime,timeout) AS totalDays
							FROM
							(
							SELECT sparcsn4.inv_unit_fcy_visit.time_in AS intime,
							(SELECT sparcsn4.inv_unit_fcy_visit.time_out
							FROM sparcsn4.inv_unit 
							INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
							WHERE id='$row->cont_id' ORDER BY sparcsn4.inv_unit.gkey DESC LIMIT 1) AS timeout

							FROM sparcsn4.inv_unit 
							INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
							WHERE id='$row->cont_id' ORDER BY sparcsn4.inv_unit.gkey ASC LIMIT 1
							) AS tmp");
	$rtnContotalDays=mysql_fetch_object($sqltotalDays);
	$conttotalDays=$rtnContotalDays->totalDays;
		
	
?>
<tr align="center">
		<td><?php  echo $i;?></td>
		<td><?php if($row->cont_id) echo $row->cont_id; else echo "&nbsp;";?></td>
		<td><?php if($convsl_name) echo $convsl_name; else echo "&nbsp;";?></td>
		<td><?php if($conib_vyg) echo $conib_vyg; else echo "&nbsp;";?></td>
		<td><?php if($consize) echo $consize; else echo "&nbsp;";?></td>
		<td><?php if($conheight) echo $conheight/10; else echo "&nbsp;";?></td>
		<td><?php if($contmlo) echo $contmlo; else echo "&nbsp;";?></td>
		<td><?php if($contfreight_kind) echo $contfreight_kind; else echo "&nbsp;";?></td>
		<td><?php if($contpostion) echo $contpostion; else echo "&nbsp;";?></td>
		<td><?php if($conttime_in) echo $conttime_in; else echo "&nbsp;";?></td>
		<td><?php if($conttime_out) echo $conttime_out; else echo "&nbsp;";?></td>
		<td><?php if($conttotalDays) echo $conttotalDays; else echo "&nbsp;";?></td>
				
	</tr>

<?php } ?>
</table>

<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
