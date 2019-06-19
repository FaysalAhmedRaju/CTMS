<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>ASSIGNMENT DATE WISE SMS STATUS REPORT</TITLE>
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
		header("Content-Disposition: attachment; filename=ASSIGNMENT_DATE_WISE_SMS_STATUS_REPORT.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}
	//$ddl_imp_rot_no=$_REQUEST['ddl_imp_rot_no']; 

	//$con=mysql_connect("10.1.1.21", "sparcsn4","sparcsn4")or die("sparcsn4 database cannot connect"); 
	//mysql_select_db("ctmsmis")or die("cannot select DB");
	include("dbConection.php");
	?>
<html>
<title>ASSIGNMENT DATE WISE SMS STATUS REPORT</title>
<body>
<?php include("dbConection.php");?>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				<tr align="center">
					<td colspan="7"><img height="100px" src="<?php echo IMG_PATH;?>cpa_logo.png" /></td>
				</tr>
				<tr align="center">
					<td colspan="7"><font size="4"><b> CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td>
				</tr>
			
				<tr align="center">
					<td colspan="7"><font size="4"><b><u>ASSIGNMENT DATEWISE SMS STATUS REPORT</u></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="7"><font size="4"><b>ASSIGNMENT DATE : <?php echo $fromdate;?></b></font></td>
				</tr>
				
				<tr align="center">
					<td colspan="7"><font size="4"><b></b></font></td>
				</tr>

			</table>
		
		</td>
		
	</tr>
	
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr>
	</table>
<div align="center">
	<table border=0 cellspacing="5" cellpadding="5">		
		<tr>
			<td><b>TOTAL</b></td><td colspan="5"><?php echo $rtnSmsTotInfo[0]['tot']; ?></td>		
		</tr>
		<tr>
			<td><b>TOTAL ASSIGNMENT</b></td><td><?php echo $rtnSmsTotInfo[0]['count_tot_assignment']; ?></td>
			<td><b>TOTAL ASSIGNMENT SMS SEND</b></td><td><?php echo $rtnSmsTotInfo[0]['count_tot_assignment_send_sms']; ?></td>
			<td><b>TOTAL ASSIGNMENT SMS PENDING</b></td><td><?php echo $rtnSmsTotInfo[0]['count_tot_assignment_sms_not_send']; ?></td>
		</tr>
		<tr>
			<?php 
			
			$strQuery="SELECT count(a.id) AS cont_no
				FROM sparcsn4.inv_unit a
				INNER JOIN sparcsn4.inv_unit_fcy_visit b ON b.unit_gkey=a.gkey
				INNER JOIN sparcsn4.ref_bizunit_scoped g ON a.line_op = g.gkey
				LEFT JOIN ctmsmis.mis_assignment_entry ON ctmsmis.mis_assignment_entry.unit_gkey=a.gkey
				INNER JOIN sparcsn4.config_metafield_lov ON a.flex_string01=config_metafield_lov.mfdch_value
				INNER JOIN
						sparcsn4.inv_goods j ON j.gkey = a.goods
				LEFT JOIN
						sparcsn4.ref_bizunit_scoped k ON k.gkey = j.consignee_bzu
				WHERE DATE(flex_date01)='$fromdate' AND config_metafield_lov.mfdch_value NOT IN ('CANCEL') AND a.remark LIKE 'overflow%'";
			$queryOverflow=mysql_query($strQuery);
			$rowOverflow=mysql_fetch_object($queryOverflow);
			?>
			<!--td><b>TOTAL OVERFLOW</b></td><td><?php echo $rtnSmsTotInfo[0]['count_tot_overflow']; ?></td-->
			<td><b>TOTAL OVERFLOW</b></td><td><?php echo $rowOverflow->cont_no; ?></td>
			<td><b>TOTAL OVERFLOW SMS SEND</b></td><td><?php echo $rtnSmsTotInfo[0]['count_tot_overflow_send_sms']; ?></td>
			<td><b>TOTAL OVERFLOW SMS PENDING</b></td><td><?php echo $rtnSmsTotInfo[0]['count_tot_overflow_sms_not_send']; ?></td>
		</tr>	
		<tr>
			<td><b>TOTAL KEEPDOWN</b></td><td><?php echo $rtnSmsTotInfo[0]['count_tot_keepdown']; ?></td>
			<td><b>TOTAL KEEPDOWN SMS SEND</b></td><td><?php echo $rtnSmsTotInfo[0]['count_tot_keepdown_send_sms']; ?></td>
			<td><b>TOTAL KEEPDOWN SMS PENDING</b></td><td><?php echo $rtnSmsTotInfo[0]['count_tot_keepdown_sms_not_send']; ?></td>
		</tr>
	</table>
</div>
<br>
	<table width="100%" border ='1' cellpadding='1' cellspacing='1'>
	<tr align="center" bgcolor="grey">
		<td style="border-width:1px;border-style: double;" ><b>SL</b></td>
		<td style="border-width:1px;border-style: double;"><b>CONTAINER NO</b></td>
		<td style="border-width:1px;border-style: double;" ><b>MOBILE NO</b></td>
		<td style="border-width:1px;border-style: double;" ><b>CNF</b></td>
		<td style="border-width:1px;border-style: double;" ><b>SMS STATUS</b></td>
		<td style="border-width:1px;border-style: double;" ><b>SMS SEND TIME</b></td>
		<td style="border-width:1px;border-style: double;" ><b>SMS TYPE</b></td>
		<td style="border-width:1px;border-style: double;" ><b>GIVEN DATE</b></td>
	</tr>

<?php
	$count_tot=0;
	$count_tot_assignment=0;
	$count_tot_overflow=0;
	$count_tot_keepdown=0;
	$count_tot_assignment_sms_send=0;
	$count_tot_overflow_sms_send=0;
	$count_tot_keepdown_sms_send=0;
	for($i=0;$i<count($rtnSmsDetails);$i++){
		$count_tot++;
?>
<tr align="center" <?php if($rtnSmsDetails[$i]['sms_status']=='SEND') { ?> bgcolor="#DAF7A6" <?php } else { ?> bgcolor="#FF5733" <?php } ?>>
		<td><?php  echo $i+1;?></td>
		<td><?php if($rtnSmsDetails[$i]['id']) echo $rtnSmsDetails[$i]['id']; else echo "&nbsp;";?></td>
		<td><?php if($rtnSmsDetails[$i]['cell_no']) echo $rtnSmsDetails[$i]['cell_no']; else echo "&nbsp;";?></td>
		<td><?php if($rtnSmsDetails[$i]['name']) echo $rtnSmsDetails[$i]['name']; else echo "&nbsp;";?></td>
		<td><?php if($rtnSmsDetails[$i]['sms_status']) echo $rtnSmsDetails[$i]['sms_status'];  else echo "&nbsp;"; ?></td>
		<td><?php if($rtnSmsDetails[$i]['sms_sending_time']) echo $rtnSmsDetails[$i]['sms_sending_time']; else echo "&nbsp;";?></td>
		<td><?php if($rtnSmsDetails[$i]['sms_type']) echo $rtnSmsDetails[$i]['sms_type']; else echo "&nbsp;";?></td>
		<td><?php if($rtnSmsDetails[$i]['max_time_limit']) echo $rtnSmsDetails[$i]['max_time_limit']; else echo "&nbsp;";?></td>
	</tr>
<?php 
	if($rtnSmsDetails[$i]['sms_type']=='OVERFLOW')
	{
		$count_tot_overflow++;
	}
	if($rtnSmsDetails[$i]['sms_type']=='KEEPDOWN')
	{
		$count_tot_keepdown++;
	}
	if($rtnSmsDetails[$i]['sms_type']=='ASSIGNMENT')
	{
		$count_tot_assignment++;
	}
	if($rtnSmsDetails[$i]['sms_type']=='OVERFLOW' && $rtnSmsDetails[$i]['sms_status']=='SEND')
	{
		$count_tot_overflow_sms_send++;
	}
	if($rtnSmsDetails[$i]['sms_type']=='KEEPDOWN' && $rtnSmsDetails[$i]['sms_status']=='SEND')
	{
		$count_tot_keepdown_sms_send++;
	}
	if($rtnSmsDetails[$i]['sms_type']=='ASSIGNMENT' && $rtnSmsDetails[$i]['sms_status']=='SEND')
	{
		$count_tot_assignment_sms_send++;
	}
} 
?>
</table>
<br />
<br />
<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
