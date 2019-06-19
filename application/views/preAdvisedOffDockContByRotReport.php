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

include("dbConection.php");
$strVsl = "select name from sparcsn4.vsl_vessel_visit_details
inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
where ib_vyg='$rotation'";
$resVsl = mysql_query($strVsl);
$rowVsl=mysql_fetch_object($resVsl)
?>

<div align="center" style="font-size:18px">
		<img align="middle" src="<?php echo IMG_PATH?>cpanew.jpg">
	</div>
<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="50px">
		<td colspan="14" align="center" style="border:none;">
			<font size="5"><b>ROTATION WISE PRE ADVICE CONTAINER LIST</b></font><br/>
			<font size="5"><b><?php echo "Rotation: ".$rotation." Vessel Name: ".$rowVsl->name;?></b></font>
		</td>		
	</tr>
	<!--tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr-->
	<tr bgcolor="#A9A9A9" align="center" height="25px">
		<td style="border-width:3px;border-style: double;"><b>SlNo.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Container No.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Size.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Height.</b></td>
		<td style="border-width:3px;border-style: double;"><b>MLO</b></td>
		<td style="border-width:3px;border-style: double;"><b>Status</b></td>
		<td style="border-width:3px;border-style: double;"><b>State</b></td>
		<td style="border-width:3px;border-style: double;"><b>Category</b></td>
		<td style="border-width:3px;border-style: double;"><b>Last Position</b></td>
		
	</tr>

<?php
//echo $rot;

$strQuery = "";
if($serch_by=="all")
{
	$strQuery = "select * from ctmsmis.mis_exp_unit_preadv_req where rotation='$rotation' and transOp=$ofdock order by cont_mlo";
}
else
{
	$strQuery = "select * from ctmsmis.mis_exp_unit_preadv_req where rotation='$rotation' and transOp=$ofdock and cont_mlo='$serch_by' order by cont_id";
}
$res = mysql_query($strQuery);
//echo $strQuery;
while($row=mysql_fetch_object($res)){
	$i++;
	//echo $i;
	$strTrans = "select sparcsn4.inv_unit_fcy_visit.transit_state,sparcsn4.inv_unit.category,sparcsn4.inv_unit_fcy_visit.last_pos_name from sparcsn4.inv_unit 
	inner join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
	where sparcsn4.inv_unit.id='$row->cont_id' order by sparcsn4.inv_unit_fcy_visit.gkey";
	//echo $strTrans."<hr>";
	$resTrans = mysql_query($strTrans);
	$Trans="";
	$cat="";
	$lastPos = "";
	while($rowTrans = mysql_fetch_object($resTrans))
	{
		$Trans=$rowTrans->transit_state;
		$cat=$rowTrans->category;
		$lastPos=$rowTrans->last_pos_name;
	}
?>
<tr align="center">
		<td><?php echo $i;?></td>
		<td><?php if($row->cont_id) echo $row->cont_id; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_size) echo $row->cont_size; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_height) echo $row->cont_height; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_mlo) echo $row->cont_mlo; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_status) echo $row->cont_status; else echo "&nbsp;";?></td>
		<td><?php $transs =$Trans; echo $str2 = substr($transs, 4);?></td>
		<td><?php if($cat) echo $cat; else echo "&nbsp;";?></td>
		<td><?php if($lastPos) echo $lastPos; else echo "&nbsp;";?></td>
	</tr>

<?php }

 ?>

<tr bgcolor="#E0FFFF" valign="center"><td colspan="2"><font size="4"><b>&nbsp;&nbsp;Total:</b></font></td><td  colspan="15">&nbsp;&nbsp;<font size="4"><b><?php  echo $i;?></b></font></td></tr>
<?php mysql_close($con_sparcsn4);?>
</table>
<?php 
if($_POST['options']=='html'){?> 
 </BODY>
</HTML>
<?php }?>
