<?php if($_POST['options']=='html'){?>
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

	<?php } 
	else if($_POST['options']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=Container-List-$fromDt-TO-$toDt-EmptyGateOut.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
       //$rot=$_REQUEST['rot']; 	
	?>

	
	<table align="center" width="50%" border ='1' cellpadding='0' cellspacing='0'>
	<?php 
	if($_POST['options']=='html'){?>
	<!--tr bgcolor="#273076" height="100px">
		<td align="center" valign="middle" colspan="14" >
			<h1><font color="white">Chittagong Port Authority</font></h1>
		</td>
	</tr-->
	<tr>
		<td colspan="14" align="center"><img width="250px" height="80px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
	</tr>
	<?php } ?>
	<tr bgcolor="#ffffff" align="center" height="50px">
		<td colspan="1" align="center"><font size="3"><b><?php echo $containerStatus;?></b></font></td>
		<td colspan="4" align="center"><font size="5"><b><?php echo $title;?></b></font></td>
	</tr>
	<!--tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr-->
	
	<tr bgcolor="#A9A9A9" align="center" height="25px">
		<td style="border-width:3px;border-style: double;"><b>SL.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Container</b></td>
		<td style="border-width:3px;border-style: double;"><b>Rotation</b></td>
		<td style="border-width:3px;border-style: double;"><b>Gate Out Time</b></td>
		<td style="border-width:3px;border-style: double;"><b>Depo</b></td>
			
	</tr>

<?php
	include("dbConection.php");
				
				$str="SELECT * FROM (
						SELECT (SELECT sparcsn4.inv_unit_fcy_visit.flex_string10 FROM sparcsn4.inv_unit
						INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
						WHERE id=tbl.id AND sparcsn4.inv_unit.category='IMPRT' ORDER BY sparcsn4.inv_unit.gkey DESC LIMIT 1) AS ib_vyg,id,time_out,last_pos_name,depo
						FROM (
						SELECT sparcsn4.inv_unit.id,sparcsn4.inv_unit_fcy_visit.time_out,
						sparcsn4.inv_unit_fcy_visit.last_pos_name,sparcsn4.inv_unit.category,sparcsn4.inv_unit_fcy_visit.transit_state,
						(SELECT biz.name FROM sparcsn4.inv_unit inv 
						INNER JOIN sparcsn4.road_truck_transactions rtt ON rtt.unit_gkey=inv.gkey
						INNER JOIN sparcsn4.road_trucking_companies rtc ON rtc.trkc_id=rtt.trkco_gkey
						INNER JOIN sparcsn4.ref_bizunit_scoped biz ON biz.gkey=rtc.trkc_id
						WHERE inv.gkey=sparcsn4.inv_unit.gkey ORDER BY inv.gkey DESC LIMIT 1) AS depo
						FROM sparcsn4.inv_unit
						INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
						INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.inv_unit.line_op
						WHERE  DATE(sparcsn4.inv_unit_fcy_visit.time_out) BETWEEN '$fromDt' AND '$toDt'
						AND sparcsn4.inv_unit.freight_kind='MTY' AND sparcsn4.ref_bizunit_scoped.id='PIL' AND sparcsn4.inv_unit.category='STRGE'
						AND sparcsn4.inv_unit_fcy_visit.last_pos_name LIKE 'T%'
						) AS tbl ) AS final WHERE ib_vyg IS NOT NULL";
	//echo $str;
	$query=mysql_query($str);					

	//echo $positon;
	$i=0;
	$j=0;	
	//$transit_state="";
	while($row=mysql_fetch_object($query)){
	$i++;
?>
<tr align="center">

		<td><?php echo $i?></td>
		<td><?php if($row->id) echo $row->id; else echo "&nbsp;";?></td>
		<td><?php if($row->ib_vyg) echo $row->ib_vyg; else echo "&nbsp;";?></td>
		<td><?php if($row->time_out) echo $row->time_out; else echo "&nbsp;";?></td>
		<td><?php if($row->depo) echo $row->depo; else echo "&nbsp;";?></td>
		
</tr>

		<?php 
		
		}
		//$login_id = $this->session->userdata('login_id')
		//$login_id_trans=="";
		  function Offdock($login_id)
			{
				if($login_id=='gclt')
				{
					return "GCL";
				}
				elseif($login_id=='saplw')
				{
					return "SAPE";
				}
				elseif($login_id=='ebil')
				{
					return "EBIL";
				}
				elseif($login_id=='cctcl')
				{
					return "CL";
				}
				elseif($login_id=='ktlt')
				{
					return "KTL";
				}
				elseif($login_id=='qnsc')
				{
					return "QNSC";
				}
				elseif($login_id=='ocl')
				{
					return "OCCL";
				}
				elseif($login_id=='vlsl')
				{
					return "VLSL";
				}
				elseif($login_id=='shml')
				{
					return "SHML";
				}
				elseif($login_id=='iqen')
				{
					return "IE";
				}
				elseif($login_id=='iltd')
				{
					return "IL";
				}
				
				elseif($login_id=='plcl')
				{
					return "PLCL";
				}
				elseif($login_id=='shpm')
				{
					return "SHPM";
				}
				elseif($login_id=='hsat')
				{
					return "HSAT";
				}
				elseif($login_id=='ellt')
				{
					return "ELL";
				}
				elseif($login_id=='bmcd')
				{
					return "BM";
				}
				elseif($login_id=='nclt')
				{
					return "NCL";
				}
				
				else
				{
					return "";
				}
				
			}
 mysql_close($con_sparcsn4);
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
