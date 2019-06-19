<?php if($_POST['options']=='html'){?>
	<?php } 
	else if($_POST['options']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=Container_Operation_Report.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}
	include("dbConection.php");
	?>
<html>
<!--title>Container Operation Report</title-->
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				
				
				<tr align="center">
					<td colspan="2"><font size="4"><b>CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td>
				</tr>
			
				<tr align="center">
					<td colspan="2"><font size="4"><b><?php echo $title;?></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="2"><font size="4"><b></b></font></td>
				</tr>

				<tr>
					<td align="center"><font size="4"><b> Date : <?php echo $searchDt;?></b></font></td>
					<td align="center"><font size="4"><b> Action : <?php if($cont_position=="all"){ echo "ALL";} else { echo $cont_position;}?></b></font></td>
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
		<td style="border-width:1px;border-style: solid;"><b>SlNo.</b></td>
		<td style="border-width:1px;border-style: solid;"><b>Container No</b></td>
		<?php if($cont_position=='All') { ?>
		<td align="center" style="border-width:1px;border-style: solid;"><b>Action</b></td>
		<?php } ?>
		<td style="border-width:1px;border-style: solid;"><b>Trailer No</b></td>
		<td style="border-width:1px;border-style: solid;"><b>Rotation</b></td>
		<td style="border-width:1px;border-style: solid;"><b>Size</b></td>
		<td style="border-width:1px;border-style: solid;"><b>Height</b></td>
		<td style="border-width:1px;border-style: solid;"><b>Status</b></td>		
	</tr>

<?php
$cond = "";
if($cont_position=='All')
{
	$cond = "";
}
else
{
	$cond = " and position='$cont_position'";
}
	$strQuery = "select cont_number,rotation,cont_size,cont_height,cont_status,position,user,trailer_no from ctmsmis.container_move_position
				where DATE(entry_date)='$searchDt'
				".$cond."order by id desc";
	
	//echo $strQuery;
	$query=mysql_query($strQuery);
	$i=0;
	$mlo="";
	$totCont = "";
	while($row=mysql_fetch_object($query)){
	$i++;
	$totCont = $totCont.$row->cont_number.", ";
		
	
?>
<tr align="center">
		<td><?php  echo $i;?></td>
		<td><?php if($row->cont_number) echo $row->cont_number; else echo "&nbsp;";?></td>
		<?php if($cont_position=='All') { ?>
		<td align="center"><?php if($row->position) echo $row->position; else echo "&nbsp;";?></td>
		<?php } ?>
		<td><?php if($row->trailer_no) echo $row->trailer_no; else echo "&nbsp;";?></td>
		<td><?php if($row->rotation) echo $row->rotation; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_size) echo $row->cont_size; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_height) echo $row->cont_height; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_status) echo $row->cont_status; else echo "&nbsp;";?></td>
	</tr>
<?php } ?>
</table>
<br />
<br />
<?php if($_POST['options']=='html'){?>
<table border="1">
<tr>
	<?php echo $totCont; ?>									
</tr>

<table>
<?php } ?>
<?php 
mysql_close($con_sparcsn4);
