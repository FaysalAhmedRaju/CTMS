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
$ddl_imp_rot_no_req=$_REQUEST['ddl_imp_rot_no']; 

	include("dbConection.php");
	
	$sql=mysql_query("select vvd_gkey from sparcsn4.vsl_vessel_visit_details where ib_vyg='$ddl_imp_rot_no_req'");
	$row=mysql_fetch_object($sql);
	$vvdGkey=$row->vvd_gkey;
	
	$sql="call ctmsmis.update_containers_by_vvd_gkey($vvdGkey)";
	$res=mysql_query($sql);
	
	$sql1=mysql_query("select vsl_vessels.name as vsl_name,ifnull(sparcsn4.vsl_vessel_visit_details.flex_string02,ifnull(sparcsn4.vsl_vessel_visit_details.flex_string03,'')) as berth_op,ifnull(sparcsn4.argo_quay.id,'') as berth,sparcsn4.argo_carrier_visit.ata,sparcsn4.argo_carrier_visit.atd from vsl_vessel_visit_details
inner join sparcsn4.argo_carrier_visit on sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
inner join sparcsn4.vsl_vessel_berthings on sparcsn4.vsl_vessel_berthings.vvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
inner join sparcsn4.argo_quay on sparcsn4.argo_quay.gkey=sparcsn4.vsl_vessel_berthings.quay
where vsl_vessel_visit_details.vvd_gkey=$vvdGkey");
	$row1=mysql_fetch_object($sql1);
	
	?>
<html>
<title>Export Container Loading List</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				
				
				<tr align="center">
					<td colspan="12"><font size="4"><b>CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td>
				</tr>
			
				<tr align="center">
					<td colspan="12"><font size="4"><b><u><?php echo $title;?></u></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b></b></font></td>
				</tr>

				<tr>
					<td colspan="3" align="center"><font size="4"><b> <?php  Echo $row1->vsl_name;?></b></font></td>
					<td colspan="3" align="center"><font size="4"><b>Voy: <?php  Echo $voysNo;?></b></font></td>
					<td colspan="3" align="center"><font size="4"><b>EXP ROT.: <?php  Echo $ddl_imp_rot_no;?></b></font></td>
					<td colspan="3" align="center"><font size="4"><b><?php  Echo $row1->ata;?></b></font></td>
					
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
		<td style="border-width:3px;border-style: double;"><b>SlNo.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Container No.</b></td>
		<td style="border-width:3px;border-style: double;"><b>ISO Type</b></td>
		<td style="border-width:3px;border-style: double;"><b>Type</b></td>
		<td style="border-width:3px;border-style: double;"><b>MLO</b></td>
		<td style="border-width:3px;border-style: double;"><b>Status</b></td>		
		<td style="border-width:3px;border-style: double;"><b>Weight</b></td>
		<td style="border-width:3px;border-style: double;"><b>POD</b></td>
		<td style="border-width:3px;border-style: double;"><b>Current Position</b></td>
		<td style="border-width:3px;border-style: double;"><b>Loaded Time</b></td>
		<td style="border-width:3px;border-style: double;"><b>Coming From</b></td>
		<td style="border-width:3px;border-style: double;"><b>Commodity</b></td>
		<td style="border-width:3px;border-style: double;"><b>Remarks</b></td>
		<td style="border-width:3px;border-style: double;"><b>User Id</b></td>
		<!--td style="border-width:3px;border-style: double;"><b>Action</b></td-->
		
	</tr>

<?php
$cond="";
if($search_by=="dateRange")
{
	$cond = " and date(mis_exp_unit.last_update) between '$fromdate' and '$todate' and mis_exp_unit.rotation = '$ddl_imp_rot_no'";
}
else if ($search_by=="dateTime")
{
	$frmDate = $fromdate." ".$fromTime.":00";
	$tDate = $todate." ".$toTime.":00";
	$cond = " and mis_exp_unit.last_update between '$frmDate' and '$tDate' and mis_exp_unit.rotation = '$ddl_imp_rot_no' ";
}
else if($search_by=="yard")
{
	if($fromdate=="" or $todate=="")
	{
		$cond = " and current_position = '$yard' and mis_exp_unit.rotation = '$ddl_imp_rot_no' ";
	}
	else
	{
		$cond = " and date(mis_exp_unit.last_update) between '$fromdate' and '$todate' and current_position = '$yard' and mis_exp_unit.rotation = '$ddl_imp_rot_no'";
	}
}
else if($search_by=="all")
{
	$cond = " and mis_exp_unit.rotation = '$ddl_imp_rot_no'";
}
/*if($fromdate!="" and $todate!="")	
{
	if($fromTime=="" or $toTime=="")
		$cond = " and date(mis_exp_unit.last_update) between '$fromdate' and '$todate'";
	else
	{
		$frmDate = $fromdate." ".$fromTime.":00";
		$tDate = $todate." ".$toTime.":00";
		$cond = " and mis_exp_unit.last_update between '$frmDate' and '$tDate'";
	}
}*/	
	//echo$vvdGkey;
	$strQuery = "SELECT ctmsmis.mis_exp_unit.gkey,ctmsmis.mis_exp_unit.cont_id AS id,mis_exp_unit.isoType AS iso,
(CASE 
WHEN mis_exp_unit.cont_size= '20' AND mis_exp_unit.cont_height = '86' AND mis_exp_unit.isoGroup NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC') THEN '2D'
WHEN mis_exp_unit.cont_size = '40' AND mis_exp_unit.cont_height='86' AND mis_exp_unit.isoGroup NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC') THEN '4D'
WHEN mis_exp_unit.cont_size = '40' AND mis_exp_unit.cont_height='96' AND mis_exp_unit.isoGroup NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC') THEN '4H'
WHEN mis_exp_unit.cont_size = '45' AND mis_exp_unit.cont_height='96' AND mis_exp_unit.isoGroup NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC') THEN '45H'
WHEN mis_exp_unit.cont_size = '20' AND mis_exp_unit.cont_height='86' AND mis_exp_unit.isoGroup IN ('RS','RT','RE') THEN '2RF'
WHEN mis_exp_unit.cont_size = '40' AND mis_exp_unit.isoGroup IN ('RS','RT','RE') THEN '4RH'
WHEN mis_exp_unit.cont_size = '20' AND mis_exp_unit.cont_height='86' AND mis_exp_unit.isoGroup IN ('UT') THEN '2OT'
WHEN mis_exp_unit.cont_size = '40' AND mis_exp_unit.isoGroup IN ('UT') THEN '4OT'
WHEN mis_exp_unit.cont_size = '20' AND mis_exp_unit.cont_height='86' AND mis_exp_unit.isoGroup IN ('PF','PC') THEN '2FR'
WHEN mis_exp_unit.cont_size = '40' AND mis_exp_unit.isoGroup IN ('PF','PC') THEN '4FR'
WHEN mis_exp_unit.cont_size = '20' AND mis_exp_unit.cont_height='86' AND mis_exp_unit.isoGroup IN ('TN','TD','TG') THEN '2TK'
ELSE ''
END
) AS TYPE,
mis_exp_unit.cont_mlo AS mlo,ctmsmis.mis_exp_unit.current_position,
cont_status AS freight_kind,ctmsmis.mis_exp_unit.goods_and_ctr_wt_kg AS weight,ctmsmis.mis_exp_unit.coming_from AS coming_from,
ctmsmis.mis_exp_unit.pod,ctmsmis.mis_exp_unit.stowage_pos,ctmsmis.mis_exp_unit.last_update,ref_commodity.short_name,ctmsmis.mis_exp_unit.user_id
FROM ctmsmis.mis_exp_unit 
INNER JOIN sparcsn4.inv_unit ON sparcsn4.inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
INNER join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
INNER JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
INNER JOIN sparcsn4.ref_commodity ON sparcsn4.ref_commodity.gkey=sparcsn4.inv_goods.commodity_gkey
where mis_exp_unit.vvd_gkey='$vvdGkey' and mis_exp_unit.delete_flag='0' and mis_exp_unit.snx_type=2  and sparcsn4.inv_unit_fcy_visit.transit_state='S20_INBOUND' ".$cond;
	
	//echo $strQuery;
	$query=mysql_query($strQuery);

	$i=0;
	$j=0;
	
	$mlo="";
	$allCont = "";
	while($row=mysql_fetch_object($query)){
	$i++;
	
		$allCont = $allCont.$row->id.", ";
	
?>
<tr align="center">
		<td><?php  echo $i;?></td>
		<td><?php if($row->id) echo $row->id; else echo "&nbsp;";?></td>
		<td><?php if($row->iso) echo $row->iso; else echo "&nbsp;";?></td>
		<td><?php if($row->type) echo $row->type; else echo "&nbsp;";?></td>
		<td><?php if($row->mlo) echo $row->mlo; else echo "&nbsp;";?></td>
		<td><?php if($row->freight_kind) echo $row->freight_kind; else echo "&nbsp;";?></td>
		<td><?php if($row->weight) echo $row->weight; else echo "&nbsp;";?></td>
		
		
		<td><?php if($row->pod) echo $row->pod; else echo "&nbsp;";?></td>
		<td><?php if($row->current_position) echo $row->current_position; else echo "&nbsp;";?></td>
		<td><?php if($row->last_update) echo $row->last_update; else echo "&nbsp;";?></td>
		
		<td><?php if($row->coming_from) echo $row->coming_from; else echo "&nbsp;";?></td>
		<td><?php if($row->short_name) echo $row->short_name; else echo "&nbsp;";?></td>
		<td><?php echo "&nbsp;";?></td>
		<td><?php if($row->user_id) echo $row->user_id;  else echo "&nbsp;";?></td>
		<!--td class="contact-delete">
			<?php if(strtoupper($this->session->userdata('login_id'))==strtoupper($row->user_id) OR strtoupper($this->session->userdata('login_id'))=='ADMIN'){?>
			<form action="<?php echo site_url('report/myContainerDelete') ?>" method="post" onsubmit="return confirm('Are you sure you want to delete this case?');">
				<input type="hidden" name="gkey" value="<?php if($row->gkey) echo $row->gkey; ?>">
				<input type="hidden" name="ddl_imp_rot_no" value="<?php echo $ddl_imp_rot_no; ?>">
				<!--input type="hidden" name="voysNumber" value="<?php echo $voysNo; ?>">
				<input type="submit" name="submit" value="Delete">
			</form>
			<?php }?>
		</td-->	
		
				
	</tr>

<?php } ?>
</table>
<br />
<br />
<?php


$sqlSummery=mysql_query("select gkey,
IFNULL(SUM(onboard_LD_20),0) AS onboard_LD_20,
IFNULL(SUM(onboard_LD_40),0) AS onboard_LD_40,
IFNULL(SUM(onboard_MT_20),0) AS onboard_MT_20,
IFNULL(SUM(onboard_MT_40),0) AS onboard_MT_40,
IFNULL(SUM(onboard_LD_tues),0) AS onboard_LD_tues,
IFNULL(SUM(onboard_MT_tues),0) AS onboard_MT_tues

 from (
select distinct ctmsmis.mis_exp_unit.gkey as gkey,
(CASE WHEN mis_exp_unit.cont_size = '20' AND freight_kind in ('FCL','LCL')  THEN 1  
ELSE NULL END) AS onboard_LD_20, 
(CASE WHEN mis_exp_unit.cont_size > '20' AND freight_kind in ('FCL','LCL')  THEN 1  
ELSE NULL END) AS onboard_LD_40,
(CASE WHEN mis_exp_unit.cont_size = '20' AND freight_kind ='MTY'  THEN 1  
ELSE NULL END) AS onboard_MT_20, 
(CASE WHEN mis_exp_unit.cont_size > '20' AND freight_kind ='MTY'  THEN 1  
ELSE NULL END) AS onboard_MT_40, 
(CASE WHEN mis_exp_unit.cont_size=20 AND freight_kind in ('FCL','LCL') THEN 1 
ELSE (CASE WHEN mis_exp_unit.cont_size>20 AND freight_kind in ('FCL','LCL') THEN 2 ELSE NULL END) END) AS onboard_LD_tues, 
(CASE WHEN mis_exp_unit.cont_size=20 AND freight_kind='MTY' THEN 1 
ELSE (CASE WHEN mis_exp_unit.cont_size>20 AND freight_kind='MTY' THEN 2 ELSE NULL END) END) AS onboard_MT_tues

FROM ctmsmis.mis_exp_unit
left join sparcsn4.inv_unit on sparcsn4.inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
where  mis_exp_unit.vvd_gkey='$vvdGkey' AND mis_exp_unit.preAddStat='0' and mis_exp_unit.snx_type=2 and sparcsn4.inv_unit_fcy_visit.transit_state='S20_INBOUND'
) as tmp");
$rowSummery=mysql_fetch_object($sqlSummery);


$sqlSummery2=mysql_query("select gkey,
IFNULL(SUM(balance_LD_20),0) AS balance_LD_20,
IFNULL(SUM(balance_LD_40),0) AS balance_LD_40,
IFNULL(SUM(balance_MT_20),0) AS balance_MT_20,
IFNULL(SUM(balance_MT_40),0) AS balance_MT_40,
IFNULL(SUM(balance_LD_tues),0) AS balance_LD_tues,
IFNULL(SUM(balance_MT_tues),0) AS balance_MT_tues

 from (
select distinct sparcsn4.inv_unit.gkey as gkey,
(CASE WHEN right(sparcsn4.ref_equip_type.nominal_length,2) = '20' AND freight_kind in ('FCL','LCL')  THEN 1  
ELSE NULL END) AS balance_LD_20, 
(CASE WHEN right(sparcsn4.ref_equip_type.nominal_length,2) > '20' AND freight_kind in ('FCL','LCL')  THEN 1  
ELSE NULL END) AS balance_LD_40,
(CASE WHEN right(sparcsn4.ref_equip_type.nominal_length,2) = '20' AND freight_kind ='MTY'  THEN 1  
ELSE NULL END) AS balance_MT_20, 
(CASE WHEN right(sparcsn4.ref_equip_type.nominal_length,2) > '20' AND freight_kind ='MTY'  THEN 1  
ELSE NULL END) AS balance_MT_40, 
(CASE WHEN right(sparcsn4.ref_equip_type.nominal_length,2)=20 AND freight_kind in ('FCL','LCL') THEN 1 
ELSE (CASE WHEN right(sparcsn4.ref_equip_type.nominal_length,2)>20 AND freight_kind in ('FCL','LCL') THEN 2 ELSE NULL END) END) AS balance_LD_tues, 
(CASE WHEN right(sparcsn4.ref_equip_type.nominal_length,2)=20 AND freight_kind='MTY' THEN 1 
ELSE (CASE WHEN right(sparcsn4.ref_equip_type.nominal_length,2)>20 AND freight_kind='MTY' THEN 2 ELSE NULL END) END) AS balance_MT_tues

FROM sparcsn4.inv_unit
inner join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
inner join sparcsn4.argo_carrier_visit on sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ob_cv
inner join sparcsn4.inv_unit_equip on sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
inner join sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
inner join sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
where  sparcsn4.argo_carrier_visit.cvcvd_gkey='$vvdGkey' and category='EXPRT' and mis_exp_unit.snx_type=2 and transit_state not in ('S60_LOADED','S70_DEPARTED','S99_RETIRED')
) as tmp");

$rowSummery2=mysql_fetch_object($sqlSummery2);
?>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr><td colspan="11" align="center"><font size="4"><b><u>Summery Report</u></b></font></td></tr>
<tr><td colspan="11" align="center"><font size="4"><b>&nbsp;</b></font></td></tr>
</table>
<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<tr>
		<td colspan="6" align="center">TOTAL ONBOARD</td>
		<td colspan="6" align="center">BALANCE TO LOAD</td>
	</tr>
	<tr>
		<td colspan="2" align="center">LADEN</td>
		<td colspan="2" align="center">EMPTY</td>
		<td colspan="2" align="center">TUES</td>
		<td colspan="2" align="center">LADEN</td>
		<td colspan="2" align="center">EMPTY</td>
		<td colspan="2" align="center">TUES</td>
		
	</tr>
	<tr>
		<td align="center">20</td>
		<td align="center">40</td>
		<td align="center">20</td>
		<td align="center">40</td>
		<td align="center">LD</td>
		<td align="center">MT</td>
		<td align="center">20</td>
		<td align="center">40</td>
		<td align="center">20</td>
		<td align="center">40</td>
		<td align="center">LD</td>
		<td align="center">MT</td>
	</tr>
	<tr>
		<td align="center"><?php if($rowSummery->onboard_LD_20) echo $rowSummery->onboard_LD_20; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery->onboard_LD_40) echo $rowSummery->onboard_LD_40; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery->onboard_MT_20) echo $rowSummery->onboard_MT_20; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery->onboard_MT_40) echo $rowSummery->onboard_MT_40; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery->onboard_LD_tues) echo $rowSummery->onboard_LD_tues; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery->onboard_MT_tues) echo $rowSummery->onboard_MT_tues; else echo "&nbsp;"; ?></td>
	
		<td align="center"><?php if($rowSummery2->balance_LD_20) echo $rowSummery2->balance_LD_20; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery2->balance_LD_40) echo $rowSummery2->balance_LD_40; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery2->balance_MT_20) echo $rowSummery2->balance_MT_20; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery2->balance_MT_40) echo $rowSummery2->balance_MT_40; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery2->balance_LD_tues) echo $rowSummery2->balance_LD_tues; else echo "&nbsp;"; ?></td>
		<td align="center"><?php if($rowSummery2->balance_MT_tues) echo $rowSummery2->balance_MT_tues; else echo "&nbsp;"; ?></td>
		

		
	</tr>
	<tr>
	<td colspan="12" align="center">
		<table>
			<tr>
				<b><u>Container's</u></b></br>
			</tr>
				<?php 
				/*$strQueryCont = "SELECT ctmsmis.mis_exp_unit.gkey,CONCAT(SUBSTRING(ctmsmis.mis_exp_unit.cont_id,1,4),SUBSTRING(ctmsmis.mis_exp_unit.cont_id,5)) AS id,mis_exp_unit.isoType AS iso,
							(CASE 
							WHEN mis_exp_unit.cont_size= '20' AND mis_exp_unit.cont_height = '86' AND mis_exp_unit.isoGroup NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC') THEN '2D'
							WHEN mis_exp_unit.cont_size = '40' AND mis_exp_unit.cont_height='86' AND mis_exp_unit.isoGroup NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC') THEN '4D'
							WHEN mis_exp_unit.cont_size = '40' AND mis_exp_unit.cont_height='96' AND mis_exp_unit.isoGroup NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC') THEN '4H'
							WHEN mis_exp_unit.cont_size = '45' AND mis_exp_unit.cont_height='96' AND mis_exp_unit.isoGroup NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC') THEN '45H'
							WHEN mis_exp_unit.cont_size = '20' AND mis_exp_unit.cont_height='86' AND mis_exp_unit.isoGroup IN ('RS','RT','RE') THEN '2RF'
							WHEN mis_exp_unit.cont_size = '40' AND mis_exp_unit.isoGroup IN ('RS','RT','RE') THEN '4RH'
							WHEN mis_exp_unit.cont_size = '20' AND mis_exp_unit.cont_height='86' AND mis_exp_unit.isoGroup IN ('UT') THEN '2OT'
							WHEN mis_exp_unit.cont_size = '40' AND mis_exp_unit.isoGroup IN ('UT') THEN '4OT'
							WHEN mis_exp_unit.cont_size = '20' AND mis_exp_unit.cont_height='86' AND mis_exp_unit.isoGroup IN ('PF','PC') THEN '2FR'
							WHEN mis_exp_unit.cont_size = '40' AND mis_exp_unit.isoGroup IN ('PF','PC') THEN '4FR'
							WHEN mis_exp_unit.cont_size = '20' AND mis_exp_unit.cont_height='86' AND mis_exp_unit.isoGroup IN ('TN','TD','TG') THEN '2TK'
							ELSE ''
							END
							) AS TYPE,
							mis_exp_unit.cont_mlo AS mlo,
							cont_status AS freight_kind,ctmsmis.mis_exp_unit.goods_and_ctr_wt_kg AS weight,ctmsmis.mis_exp_unit.coming_from AS coming_from,
							ctmsmis.mis_exp_unit.pod,ctmsmis.mis_exp_unit.stowage_pos,ctmsmis.mis_exp_unit.last_update,ref_commodity.short_name,ctmsmis.mis_exp_unit.user_id
							FROM ctmsmis.mis_exp_unit 
							LEFT JOIN sparcsn4.inv_unit ON sparcsn4.inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
							LEFT JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
							LEFT JOIN sparcsn4.ref_commodity ON sparcsn4.ref_commodity.gkey=sparcsn4.inv_goods.commodity_gkey
							where mis_exp_unit.vvd_gkey='$vvdGkey' and mis_exp_unit.delete_flag='0' and mis_exp_unit.snx_type=2 ".$cond;
				
				//echo $strQuery;
				$queryCont=mysql_query($strQueryCont);

				$j=0;
				while($row1=mysql_fetch_object($queryCont)){
				
				$j++;*/
				?>
			<tr>
				<?php echo $allCont; ?>									
			</tr>
				<?php //}?>
			</tbody>
		</table>
	</td>
</tr>
</table>
<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
