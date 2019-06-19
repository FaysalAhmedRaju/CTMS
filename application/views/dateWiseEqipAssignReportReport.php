
<style>
   /*table {border-collapse:collapse; table-layout:fixed; width:700px;font-size: 80%;}
   table td,th {border:solid 1px #000; width:160px; word-wrap:break-word;}*/
   img {padding-left:300px;}
</style>
<title>BLOCK WISE EQUIPMET LIST</title>
<img align="middle" src="<?php echo IMG_PATH; ?>cpa1.png">
<HTML>
<BODY>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				
				<tr align="center">
					<td colspan="12"><font size="4"><b>CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td>
				</tr>
			<tr align="center">
					<td colspan="12"><font size="4"> EQUIPMET Demand LIST FOR DATE: <?php echo $fromdate;?></font></td>
				</tr>
				
				<tr align="center">
					<td colspan="12"><font size="4"><b></b></font></td>
				</tr>

				

			</table>
		
		</td>
		
	</tr>
	
	</table>
<table width="80%" border ='1' cellpadding='0' cellspacing='0'align="center">
		
	
	<tr bgcolor="#A9A9A9" align="center" height="25px">
		<td style="border-width:3px;border-style: double;"><b>SlNo.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Yard.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Equipment.</b></td>
		
		<td style="border-width:3px;border-style: double;"><b>Description.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Capacity.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Demand.</b></td>
		
	</tr>

<?php
	include("dbConection.php");

	$query=mysql_query("select (select ctmsmis.cont_yard(ctmsmis.mis_equip_booking.block)) AS Yard_No,
	ctmsmis.mis_equip_detail.equipment,ctmsmis.mis_equip_detail.description,ctmsmis.mis_equip_detail.capacity,
	count(mis_equip_booking.id) as demand
	from ctmsmis.mis_equip_booking 
	INNER JOIN ctmsmis.mis_equip_detail on ctmsmis.mis_equip_detail.id=ctmsmis.mis_equip_booking.equip_detail_id
	where date(booking_date)='$fromdate'
	group by Yard_No,ctmsmis.mis_equip_detail.equipment");

	//echo $positon;
	$i=0;
	$j=0;	
	//$transit_state="";
	while($row=mysql_fetch_object($query)){
	$i++;		
				
		
		
?>
<tr align="center">
<td><?php  echo $i;?></td>
		
		<td><?php if($row->Yard_No) echo $row->Yard_No; else echo "&nbsp;";?></td>
		<td><?php if($row->equipment) echo $row->equipment; else echo "&nbsp;";?></td>
		<td><?php if($row->description) echo $row->description; else echo "&nbsp;";?></td>
		<td><?php if($row->capacity) echo $row->capacity; else echo "&nbsp;";?></td>
		<td><?php if($row->demand) echo $row->demand; else echo "&nbsp;";?></td>
				
	</tr>

		<?php } ?>
		
<?php
		
 mysql_close($con_sparcsn4);?>

</table>
</BODY>
</HTML>