<HTML>
	<!--HEAD>
		<TITLE>Container detail by Rotation</TITLE>
		<LINK href="../css/report.css" type=text/css rel=stylesheet>
	    <style type="text/css">
<!--
.style1 {font-size: 12px}    // comment section

        </style>
    </HEAD>
	-->
<BODY>

	<?php 

		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=get24HourDischargeContainerList.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");
	
       //$rot=$_REQUEST['rot']; 	
	?>

	
	<table align="center" width="50%" border ='1' cellpadding='0' cellspacing='0'>
	
	<tr bgcolor="#273076" height="100px">
		<td align="center" valign="middle" colspan="14" >
			<h1><font color="white">Chittagong Port Authority</font></h1>
		</td>
	</tr>
	<tr bgcolor="#ffffff" align="center" height="50px">
		<td colspan="6" align="center"><font size="3"><b>Container Discharge List</b></font></td>
	</tr>
	<tr bgcolor="#ffffff" align="center" height="50px">
		<td colspan="3" align="center"><font size="3"><b>Rotation : <?php echo $getVesselInfo[0]['ib_vyg']; ?></b></font></td>
		<td colspan="3" align="center"><font size="3"><b>Vessel : <?php echo $getVesselInfo[0]['vsl_name']; ?></b></font></td>
	</tr><tr bgcolor="#ffffff" align="center" height="50px">
		<td colspan="3" align="center"><font size="3"><b>Berth : <?php echo $getVesselInfo[0]['berth_op'].' ('.$getVesselInfo[0]['berth'].') '; ?></b></font></td>
		<td colspan="3" align="center"><font size="3"><b>Arrival Date : <?php echo $getVesselInfo[0]['ata']; ?></b></font></td>
	</tr>
	<!--tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr-->
	
	<tr bgcolor="#A9A9A9" align="center" height="25px">
		<td style="border-width:3px;border-style: double;"><b>SL.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Container</b></td>
		<td style="border-width:3px;border-style: double;"><b>Size</b></td>
		<td style="border-width:3px;border-style: double;"><b>Height</b></td>
		<td style="border-width:3px;border-style: double;"><b>Freight</b></td>
		<td style="border-width:3px;border-style: double;"><b>Time In</b></td>
	</tr>

<?php for($i=0; $i<count($disChargeListContainer);$i++) { ?>
<tr align="center">

		<td><?php echo $i+1?></td>
		<td><?php echo $disChargeListContainer[$i]['discharge_container'];?></td>
		<td><?php echo $disChargeListContainer[$i]['size'];?></td>
		<td><?php echo $disChargeListContainer[$i]['height'];?></td>
		<td><?php echo $disChargeListContainer[$i]['freight_kind'];?></td>
		<td><?php echo $disChargeListContainer[$i]['fcy_time_in'];?></td>
		
		
</tr>

		<?php 
}
		
 ?>


</table>




<br />
<br />




<?php 
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
