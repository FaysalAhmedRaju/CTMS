<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>Bearth Operator Report</TITLE>
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


	//$con=mysql_connect("10.1.1.21", "sparcsn4","sparcsn4")or die("cannot connect"); 
	//mysql_select_db("sparcsn4")or die("cannot select DB");
	include("dbConection.php");
	
	?>
<html>
<title>REQUEST FOR PREADVICE CONTAINER LIST</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				
				
				<tr align="center">
					<td colspan="12"><img align="middle" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
				</tr>
			
				<tr align="center">
					<td colspan="12"><font size="4"><b><u>REQUEST FOR PREADVICE CONTAINER LIST</u></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b></b></font></td>
				</tr>
				<!--
				<tr>
					<td align="center"><font size="4"><b>FROM :<?php  Echo $fromdate;?></b></font></td>
					<td align="left"><font size="4"><b>TO :<?php  Echo $todate;?></b></font></td>
				</tr>
				-->
			</table>
		
		</td>
		
	</tr>
	
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr>
	</table>
	<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<tr  align="center">
		<td style="border-width:3px;border-style: double;"><b>SlNo.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Container No.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Rotation NO</b></td>
		<td style="border-width:3px;border-style: double;"><b>Category.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Status.</b></td>
		<td style="border-width:3px;border-style: double;"><b>MLO</b></td>
		<td style="border-width:3px;border-style: double;"><b>Type</b></td>
		<td style="border-width:3px;border-style: double;"><b>Size</b></td>
		<td style="border-width:3px;border-style: double;"><b>Height</b></td>
		<td style="border-width:3px;border-style: double;"><b>Weight</b></td>
		<td style="border-width:3px;border-style: double;"><b>ISO Group</b></td>
		<td style="border-width:3px;border-style: double;"><b>Booking NO</b></td>
		<td style="border-width:3px;border-style: double;"><b>Agent</b></td>
		<td style="border-width:3px;border-style: double;"><b>Seal No</b></td>
		<td style="border-width:3px;border-style: double;"><b>Seal No2</b></td>
		<td style="border-width:3px;border-style: double;"><b>Seal No3</b></td>
		<td style="border-width:3px;border-style: double;"><b>Seal No4</b></td>
		<td style="border-width:3px;border-style: double;"><b>POD</b></td>
		<td style="border-width:3px;border-style: double;"><b>FPOD</b></td>
		<td style="border-width:3px;border-style: double;"><b>Mode Trans</b></td>
		<td style="border-width:3px;border-style: double;"><b>Transport</b></td>
		<td style="border-width:3px;border-style: double;"><b>TransOp</b></td>
		<td style="border-width:3px;border-style: double;"><b>Last Update</b></td>
		<td style="border-width:3px;border-style: double;"><b>User Id</b></td>
		
	</tr>

<?php
//echo$fromdate;
	
	$query=mysql_query("SELECT gkey,cont_id,cont_category,cont_status,cont_mlo,isoType,cont_size,
	cont_height,isoGroup,bookingNo,vvd_gkey,rotation,agent,last_update,user_id,seal_no,seal_no2,
	seal_no3,seal_no4,goods_and_ctr_wt_kg,pod,fpod,modeTrans,transport,transOp,preAddStat
	FROM ctmsmis.mis_exp_unit WHERE DATE(last_update) BETWEEN '$fromdate' AND '$todate' AND preAddStat=1");
	$i=0;
	$j=0;
	
	$mlo="";
	while($row=mysql_fetch_object($query)){
	$i++;
	
		
	
?>
<tr align="center">
		<td><?php  echo $i;?></td>
		<td><?php if($row->cont_id) echo $row->cont_id; else echo "&nbsp;";?></td>
		<td><?php if($row->rotation) echo $row->rotation; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_category) echo $row->cont_category; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_status) echo $row->cont_status; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_mlo) echo $row->cont_mlo; else echo "&nbsp;";?></td>
		<td><?php if($row->isoType) echo $row->isoType; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_size) echo $row->cont_size; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_height) echo $row->cont_height; else echo "&nbsp;";?></td>
		<td><?php if($row->goods_and_ctr_wt_kg) echo $row->goods_and_ctr_wt_kg; else echo "&nbsp;";?></td>
		<td><?php if($row->isoGroup) echo $row->isoGroup; else echo "&nbsp;";?></td>
		<td><?php if($row->bookingNo) echo $row->bookingNo; else echo "&nbsp;";?></td>
		<td><?php if($row->agent) echo $row->agent; else echo "&nbsp;";?></td>
		<td><?php if($row->seal_no) echo $row->seal_no; else echo "&nbsp;";?></td>
		<td><?php if($row->seal_no2) echo $row->seal_no2; else echo "&nbsp;";?></td>
		<td><?php if($row->seal_no3) echo $row->seal_no3; else echo "&nbsp;";?></td>
		<td><?php if($row->seal_no4) echo $row->seal_no4; else echo "&nbsp;";?></td>
		<td><?php if($row->pod) echo $row->pod; else echo "&nbsp;";?></td>
		<td><?php if($row->fpod) echo $row->fpod; else echo "&nbsp;";?></td>
		<td><?php if($row->modeTrans) echo $row->modeTrans; else echo "&nbsp;";?></td>
		<td><?php if($row->transport) echo $row->transport; else echo "&nbsp;";?></td>
		<td><?php if($row->transOp) echo $row->transOp; else echo "&nbsp;";?></td>
		<td><?php if($row->last_update) echo $row->last_update; else echo "&nbsp;";?></td>
		<td><?php if($row->user_id) echo $row->user_id; else echo "&nbsp;";?></td>
				
	</tr>

<?php } ?>
</table>
<br />
<br />



<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
