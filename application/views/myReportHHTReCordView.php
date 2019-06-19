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
<!--style>
   /*table {border-collapse:collapse; table-layout:fixed; width:700px;font-size: 80%;}
   table td,th {border:solid 1px #000; width:160px; word-wrap:break-word;}*/
   img {padding-left:300px;}
</style-->
<!--title>BLOCK WISE EQUIPMET LIST</title-->
<!--img align="middle" src="<?php echo IMG_PATH; ?>cpa1.png"-->
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0' >
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="4" align="center">
			<table border=0 width="100%">
				<tr align="center">
					<td align="center" valign="middle" colspan="12"><img align="middle"  width="50px" height="50px" src="<?php echo IMG_PATH?>cpa.png"></td>
				</tr>
				<tr align="center">
					<td align="center" valign="middle" ><font size="4"><b><nobr>CHITTAGONG PORT AUTHORITY,CHITTAGONG</nobr></b></font></td>
				</tr>
			
				<tr align="center">
					<td align="center" valign="middle"colspan="12"><font size="4"><b><u>BLOCK WISE ASSIGNED EQUIPMENT LIST</u></b></font></td>
				</tr>
				<tr align="center">
					<td align="center" valign="middle" colspan="12"><font size="4"><b></b></font></td>
				</tr>

				

			</table>
		
		</td>
		
	</tr>
	
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="4" align="center"></td>		
	</tr>
	</table>
	<table width="50%" border ='1' cellpadding='0' cellspacing='0' align="center" >
		<thead>
			<tr bgcolor="#A9A9A9" align="center" height="25px" >
				<td align="center"><b>SLNO</b></td>
				<td align="center"><b>Yard</b></td>
				<td align="center"><b>Block</b></td>	
				<td align="center"><b>Equipment</b></td>		
			</tr>
		</thead>
		<tbody>

<?php
	include("dbConection.php");
	
	$query=mysql_query("
	select * from(
	select distinct  sel_block Block,
	short_name equipement,
	(select ctmsmis.cont_yard(xps_chezone.sel_block)) AS Yard_No

	from xps_che
	inner join xps_chezone on xps_chezone.che_id=xps_che.id

	order by Yard_No,Block 
	) tm where Yard_No is not null and (equipement <> '')");
	$i=0;
	$j=0;

	
	$Yard_No="";
	$row="";
	while($row=mysql_fetch_object($query)){
	
	if($Yard_No!=$row->Yard_No){
		if($j>0){
		?>
		<tr   bgcolor="#aaffff" valign="center">

				<td  colspan="2"><font size="4"><b>&nbsp;&nbsp;Total (<?php echo $Yard_No; ?>):</b></font></td>
				<td  colspan="2">&nbsp;&nbsp;<font size="4"><b><?php  echo $j;?></b></font></td>

		</tr>
		<?php
		}
		?>
		<tr   bgcolor="#F0F4CA" valign="center">
			<td  colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size="4" color="blue"><b><?php  if($row->Yard_No) echo $row->Yard_No; else echo "&nbsp;"; ?></b></font></td>

		</tr>
		<?php
		
		
		$j=1;
		$i=1;
		
	}else{
		$j++;
		$i++;
	}
	$Yard_No=$row->Yard_No;
	
?>
<tr align="center" >
		<td align="center"><?php  echo $i;?></td>
		<td align="center"><?php if($row->Yard_No) echo $row->Yard_No; else echo "&nbsp;";?></td>
		<td align="center"><?php if($row->Block) echo $row->Block; else echo "&nbsp;";?></td>
		
		<td align="center"><?php if($row->equipement) echo $row->equipement; else echo "&nbsp;";?></td>
</tr>

<?php } ?>

<tr  bgcolor="#aaffff" valign="center"><td colspan="2"><font size="4"><b>&nbsp;&nbsp;Total  (<?php echo $Yard_No; ?>):</b></font></td><td  colspan="2">&nbsp;&nbsp;<font size="4"><b><?php  echo $j;?></b></font></td></tr>
</tbody>
</table>
<br/><br/>
			<table border="2" width="50%" align="center">
				
				<tr align="center" >
					<td colspan="4"><font size="4"><b>SUMMARY OF EQUIPMENT DETAILS</b></font></td>
				</tr>
			</table>
<table width="50%" border ='1' cellpadding='0' cellspacing='0' align="center">
	<tr bgcolor="#A9A9A9" align="center" height="25px">
		
	
		<td align="center"><b>SLNO.</b></td>
		<td align="center"><b>Equipment.</b></td>
		<td align="center"><b>Total.</b></td>
		
	</tr>

<?php
	include("dbConection.php");
	
	$query=mysql_query("
	select tt,count(equipement) as total from(
 select distinct short_name equipement,
Replace(Replace(Replace(Replace(Replace(Replace(Replace(Replace(Replace(Replace(short_name,'9',''),'8',''),'7',''),'6',''),'5',''),'4',''),'3',''),'2',''),'1',''),'0','') as tt

 from xps_che
 inner join xps_chezone on xps_chezone.che_id=xps_che.id
 ) tm where (equipement <> '') and tt not in('F','HHT') group by tt");
	$i=0;
	$j=0;

	
	
	while($row1=mysql_fetch_object($query)){
	$i++;
?>
<tr align="center">
		<td align="center"><?php  echo $i;?></td>
		<td align="center"><?php if($row1->tt) echo $row1->tt; else echo "&nbsp;";?></td>
		<td align="center"><?php if($row1->total) echo $row1->total; else echo "&nbsp;";?></td>
</tr>

<?php } ?>



</table>
<br/>
<br/>
<img src="<?php echo IMG_PATH; ?>containerloc.png" width="1050" height="500" alt="" align="left"/ style="padding-left:40px;">
<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
