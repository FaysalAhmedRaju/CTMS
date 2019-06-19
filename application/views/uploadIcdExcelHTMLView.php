<?php  		
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=CONTAINER_DETAILS_BY_ROTATION.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0"); ?>
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

	
    
	
	<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<tr bgcolor="#273076" height="100px">
		<td align="center" valign="middle" colspan="14" >
			<h1><font color="white">Chittagong Port Authority</font></h1>
		</td>
	</tr>
	<tr bgcolor="#ffffff" align="center" height="50px">
		<td colspan="14" align="center"><font size="5"><b><?php echo $title;?></b></font></td>
	</tr>
	<!--tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr-->
	
	<tr bgcolor="#A9A9A9" align="center" height="25px">
		<td style="border-width:3px;border-style: double;"><b>SL.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Container</b></td>
		<td style="border-width:3px;border-style: double;"><b>Size</b></td>
		<td style="border-width:3px;border-style: double;"><b>Height</b></td>
		<td style="border-width:3px;border-style: double;"><b>Discharge Time</b></td>
		<td style="border-width:3px;border-style: double;"><b>Delivery/ Getout Time</b></td>
		<td style="border-width:3px;border-style: double;"><b>Last Position</b></td>
		<td style="border-width:3px;border-style: double;"><b>Yard</b></td>
		<td style="border-width:3px;border-style: double;"><b>Block</b></td>
		<td style="border-width:3px;border-style: double;"><b>Destination</b></td>
		<td style="border-width:3px;border-style: double;"><b>Off Dock Name</b></td>
		<td style="border-width:3px;border-style: double;"><b>Assignment Type</b></td>
		<td style="border-width:3px;border-style: double;"><b>Assignment Date</b></td>
		<td style="border-width:3px;border-style: double;"><b>View In Map</b></td>
	</tr>

<?php
	
	//$transit_state="";
for($i=0; $i<count($data['main_line_operator'][]); $i++)
{
?>
<tr align="center">

		<td><?php echo $i?></td>
		<td><?php if($row->id) echo $row->id; else echo "&nbsp;";?></td>
		<td><?php if($row->size) echo $row->size; else echo "&nbsp;";?></td>
		<td><?php if($row->height) echo $row->height; else echo "&nbsp;";?></td>
		<td><?php if($row->time_in) echo $row->time_in; else echo "&nbsp;";?></td>
		<td><?php if($row->time_out) echo $row->time_out; else echo "&nbsp;";?></td>
		<td><?php if($row->last_pos_name) echo $row->last_pos_name; else echo "&nbsp;";?></td>
		<td><?php if($row->yard) echo $row->yard; else echo "&nbsp;";?></td>
		<td><?php if($row->block) echo $row->block; else echo "&nbsp;";?></td>
		<td><?php if($row->destination) echo $row->destination; else echo "&nbsp;";?></td>
		<td><?php if($row->ofdocName) echo $row->ofdocName; else echo "&nbsp;";?></td>
		<td><?php if($row->mfdch_desc) echo $row->mfdch_desc; else echo "&nbsp;";?></td>
		<td><?php if($row->flex_date01) echo $row->flex_date01; else echo "&nbsp;";?></td>
		<td><a href="<?php echo site_url('report/mySearchContainerLocation/'.$row->id)?>" target="_blank">View</a></td>
</tr>

		<?php 
		
		}
		//$login_id = $this->session->userdata('login_id')
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
