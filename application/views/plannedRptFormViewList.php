<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>Planned Report</TITLE>
		<LINK href="../css/report.css" type=text/css rel=stylesheet>
	    <style type="text/css">
<!--
.style1 {font-size: 12px}
-->
        </style>
</HEAD>
<BODY>

	<?php } else if($_POST['options']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=PlannedReport.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}



?>
<style>
   table {border-collapse:collapse; table-layout:fixed; width:700px;font-size: 80%;}
   table td,th {border:solid 1px #000; width:300px; word-wrap:break-word;}
   img {padding-left:300px;}
</style>
<img align="middle" src="<?php echo IMG_PATH?>cpanew.jpg"/>

<?php 
$cond = "";
$forTitle="";

//echo $srcFor;
if($srcFor=="Date")
{
			$cond = "date(sparcsn4.argo_carrier_visit.ata) between '$fromdate' and '$todate'and ifnull(sparcsn4.vsl_vessel_visit_details.flex_string02,sparcsn4.vsl_vessel_visit_details.flex_string03)!='SAIF POWERTEC' order by sparcsn4.argo_carrier_visit.ata desc";
			$forTitle="From $fromdate To $todate";
}
else
{
			$cond = "sparcsn4.vsl_vessel_visit_details.ib_vyg='$srcRot'";
			$forTitle="Rotation No $srcRot";
}
?>
<!--<h3 align="center">Vessel Wise CTMS Container Job Done by HHT,VMT and Manually<br/>From  <?php echo $fromdate?> To <?php echo $todate?></h3>-->
<h3 align="center">Vessel Wise CTMS Container Job Done by HHT,VMT and Manually<br/><?php echo $forTitle?></h3>
<table align="center" cellpadding="2">
	<tr>
		<th style="width:25px;" rowspan="3">Sl no</th><th style="width:140px;" rowspan="3">Vessel Name</th><th style="width:65px;" rowspan="3">Arrival Date</th><th style="width:65px;" rowspan="3">Rotation</th><th style="width:60px;" rowspan="3">Berth Operator</th><th rowspan="3" style="width:50px;">Total Import</th><th colspan="5">With HHT</th><th colspan="5">Without HHT</th><th style="width:40px;" rowspan="3">Total VMT</th><th style="width:55px;" rowspan="3">Total Manually</th>
	</tr>
	<tr>
		<th colspan="2">With VMT</th><th colspan="2">Manually</th><th rowspan="2">Total</th><th colspan="2">With VMT</th><th colspan="2">Manually</th><th rowspan="2">Total</th>
	</tr>
	<tr>
		<th>Planned</th><th>Plan Changed</th><th>Planned</th><th>Plan Changed</th><th>Planned</th><th>Plan Changed</th><th>Planned</th><th>Plan Changed</th>
	</tr>
	<?php
	include_once("dbConection.php");
	//$con = mysql_connect("10.1.1.21","sparcsn4","sparcsn4");
	//mysql_select_db("ctmsmis",$con);
	include_once("mydbPConnection.php");
	//$con1 = mysql_connect("192.168.16.42","user1","user1test");
	//mysql_select_db("cchaportdb",$con1);
	$str = "select sparcsn4.argo_carrier_visit.id,date(sparcsn4.argo_carrier_visit.ata) as ata,sparcsn4.vsl_vessels.name,sparcsn4.vsl_vessel_visit_details.ib_vyg,ifnull(sparcsn4.vsl_vessel_visit_details.flex_string02,sparcsn4.vsl_vessel_visit_details.flex_string03) as berthop 
	from sparcsn4.argo_carrier_visit
	inner join sparcsn4.vsl_vessel_visit_details on sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
	inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
	where ".$cond."";
	$res = mysql_query($str,$con_sparcsn4);
	$i=0;
	while($row=mysql_fetch_object($res))
	{
		$i++;
		$strVsl = "select argo_carrier_visit.id,srv_event.gkey,event_type_gkey,che_fetch,che_put,placed_by,applied_to_gkey,to_pos_slot 
		from sparcsn4.srv_event 
		inner join sparcsn4.inv_move_event on inv_move_event.mve_gkey=srv_event.gkey
		inner join sparcsn4.argo_carrier_visit on argo_carrier_visit.gkey=inv_move_event.carrier_gkey
		where sparcsn4.argo_carrier_visit.id='$row->id' and event_type_gkey=18";
		$resVsl = mysql_query($strVsl,$con_sparcsn4);	
		$bertOpPart = explode(" ",$row->berthop);
		$tot=0;
		$hht_vmt_plan = 0;
		$hht_vmt_plan_chng = 0;
		$hht_man_plan = 0;
		$hht_man_plan_chng = 0;
		$oth_vmt_plan = 0;
		$oth_vmt_plan_chng = 0;
		$oth_man_plan = 0;
		$oth_man_plan_chng = 0;
		while($rowVsl=mysql_fetch_object($resVsl))
		{
			$tot=$tot+1;
			$che_fetch=$rowVsl->che_fetch;
			$placed_by=$rowVsl->placed_by;
			$cont=$rowVsl->applied_to_gkey;
			$to_pos_slot=$rowVsl->to_pos_slot;
			$vmtPart = explode(":",$placed_by);
			$strPlan = "select pos_slot as planpos1 from ctmsmis.mis_inv_equip_planned where unit_gkey=$cont";
			$resPlan = mysql_query($strPlan,$con_sparcsn4);
			$plan = null;
			while($rowPlan=mysql_fetch_object($resPlan))
			{
				$plan = $rowPlan->planpos1;
			}
			
			if($che_fetch!=null)
			{
				if(end($vmtPart)=="COMPLETE_MOVE")
				{
					if (strpos($to_pos_slot, $plan) !== false)
						$hht_man_plan = $hht_man_plan+1;
					else
						$hht_man_plan_chng = $hht_man_plan_chng+1;
				}
				else
				{
					if (strpos($to_pos_slot, $plan) !== false)
						$hht_vmt_plan = $hht_vmt_plan+1;
					else
						$hht_vmt_plan_chng = $hht_vmt_plan_chng+1;
				}
			}
			else
			{
				if(end($vmtPart)=="COMPLETE_MOVE")
				{
					if (strpos($to_pos_slot, $plan) !== false)
						$oth_man_plan = $oth_man_plan+1;
					else
						$oth_man_plan_chng = $oth_man_plan_chng+1;
				}
				else
				{
					if (strpos($to_pos_slot, $plan) !== false)
						$oth_vmt_plan = $oth_vmt_plan+1;
					else
						$oth_man_plan_chng = $oth_man_plan_chng+1;
				}
			}	
			
		}
	?>
		<tr align="center">
			<td><?php echo $i;?></td>
			<td><?php echo $row->name;?></td>
			<td><?php echo $row->ata;?></td>
			<td><?php echo $row->ib_vyg;?></td>
			<td><?php echo $bertOpPart[0];?></td>
			<td><?php echo $tot;?></td>
			<td><?php echo $hht_vmt_plan;?></td>
			<td><?php echo $hht_vmt_plan_chng;?></td>
			<td><?php echo $hht_man_plan;?></td>
			<td><?php echo $hht_man_plan_chng;?></td>
			<td><?php echo $hht_vmt_plan+$hht_vmt_plan_chng+$hht_man_plan+$hht_man_plan_chng;?></td>
			<td><?php echo $oth_vmt_plan;?></td>
			<td><?php echo $oth_vmt_plan_chng;?></td>
			<td><?php echo $oth_man_plan;?></td>
			<td><?php echo $oth_man_plan_chng;?></td>
			<td><?php echo $oth_vmt_plan+$oth_vmt_plan_chng+$oth_man_plan+$oth_man_plan_chng;?></td>
			<td><?php echo $hht_vmt_plan+$hht_vmt_plan_chng+$oth_vmt_plan+$oth_vmt_plan_chng;?></td>
			<td><?php echo $hht_man_plan+$hht_man_plan_chng+$oth_man_plan+$oth_man_plan_chng;?></td>
			
		</tr>
	<?php
	}
	//echo"<hr> End "
	?>
</table>

<?php 

mysql_close($con_sparcsn4);
mysql_close($con_cchaportdb);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
