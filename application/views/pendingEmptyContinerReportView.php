<html>
<title>PROPOSED EMPTY AND EMPTY  CONTAINER REPORT</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				
				<tr align="center">
					<td colspan="12"><font size="4"><b>CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td>
				</tr>
			
				<tr align="center">
					<td colspan="12"><font size="4"><b><?php echo $head; ?></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b>DATE : <?php echo $fromdate; ?>&nbsp;&nbsp;Yard NO : <?php echo $yard_no; ?></b></font></td>
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
		<td style="border-width:3px;border-style: double;"><b>Rotation No.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Type</b></td>
		<td style="border-width:3px;border-style: double;"><b>MLO</b></td>
		<td style="border-width:3px;border-style: double;"><b>Status</b></td>		
		<td style="border-width:3px;border-style: double;"><b>Weight</b></td>
		<td style="border-width:3px;border-style: double;"><b>Assignment Type</b></td>
		<td style="border-width:3px;border-style: double;"><b>Current Position</b></td>
		<td style="border-width:3px;border-style: double;"><b>Discharge date</b></td>
		<td style="border-width:3px;border-style: double;"><b>Assignment date</b></td>
		<td style="border-width:3px;border-style: double;"><b>Propose Empty Date(E)</b></td>
		<td style="border-width:3px;border-style: double;"><b>Delivery/Empty Date</b></td>
		
		
	</tr>

<?php
	//echo $type;
	
	include("dbConection.php");
	$query=mysql_query("

SELECT a.id AS cont_no,
(SELECT ctmsmis.mis_inv_unit.iso_code FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey) AS iso_code,
(SELECT ctmsmis.mis_inv_unit.vsl_visit_dtls_ib_vyg FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey) AS rot_no,
b.time_in AS dischargetime,
b.time_out as delivery,
g.id AS mlo,
sparcsn4.config_metafield_lov.mfdch_desc,
(SELECT ctmsmis.mis_inv_unit.freight_kind FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey) AS statu,
(SELECT ctmsmis.mis_inv_unit.goods_and_ctr_wt_kg FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey) AS weight,
(SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
FROM sparcsn4.srv_event
INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
WHERE sparcsn4.srv_event.applied_to_gkey=a.gkey AND sparcsn4.srv_event.event_type_gkey=18 LIMIT 1) AS carrentPosition,
(SELECT ctmsmis.cont_yard((SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
FROM sparcsn4.srv_event
INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
WHERE sparcsn4.srv_event.applied_to_gkey=a.gkey AND sparcsn4.srv_event.event_type_gkey=18 LIMIT 1))) AS Yard_No,
(SELECT ctmsmis.cont_block((SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
FROM sparcsn4.srv_event
INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
WHERE sparcsn4.srv_event.applied_to_gkey=a.gkey AND sparcsn4.srv_event.event_type_gkey=18 LIMIT 1),Yard_No)) AS Block_No,
(SELECT sparcsn4.srv_event.created FROM  sparcsn4.srv_event 
INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
WHERE applied_to_gkey=a.gkey AND event_type_gkey=4 AND sparcsn4.srv_event_field_changes.new_value='E' LIMIT 1) AS proEmtyDate,
b.flex_date01 AS assignmentdate

FROM sparcsn4.inv_unit a
INNER JOIN sparcsn4.inv_unit_fcy_visit b ON b.unit_gkey=a.gkey
INNER JOIN sparcsn4.ref_bizunit_scoped g ON a.line_op = g.gkey
INNER JOIN sparcsn4.config_metafield_lov ON a.flex_string01=config_metafield_lov.mfdch_value

INNER JOIN
	    sparcsn4.inv_goods j ON j.gkey = a.goods
LEFT JOIN
	    sparcsn4.ref_bizunit_scoped k ON k.gkey = j.consignee_bzu
WHERE DATEDIFF('$fromdate', date(b.flex_date01) ) between 1 and 5 AND config_metafield_lov.mfdch_value NOT IN ('CANCEL','OCD','APPCUS','APPOTH','APPREF')
");



  
	$i=0;
	$j=0;
	$j20=0;
	$j40=0;
	$a20 = 0;
	$a40 = 0;
	$b20 = 0;
	$a40 = 0;
	$c20 = 0;
	$a40 = 0;
	$allCont="";
	$yard="";
	$shift="";
	$tot20 = 0;
	$tot40 = 0;
	include("mydbPConnection.php");
	$numRows=mysql_num_rows($query);
	
	while($row=mysql_fetch_object($query)){
	$i++;
	if($yard_no=="GCB")
	{
		if($i==$numRows)
			$allCont .=$row->cont_no;
		else
			$allCont .=$row->cont_no.", ";
	}
	$sqlIsoCode=mysql_query("select cont_iso_type from igm_detail_container where cont_number='$row->cont_no'",$con_cchaportdb);
	
	//echo "select cont_iso_type from igm_detail_container where cont_number='$row->cont_no";
	$rtnIsoCode=mysql_fetch_object($sqlIsoCode);
	$iso=$rtnIsoCode->cont_iso_type;
	if(substr($iso,0,1)==2)
		$j20=$j20+1;
	else
		$j40=$j40+1;
		
	if(substr($iso,0,1)==2)
	{
		if($row->shift=="Shift A")
			$a20 = $a20+1;
		if($row->shift=="Shift B")
			$b20 = $b20+1;
		if($row->shift=="Shift C")
			$c20 = $c20+1;
	}
	else
	{
		if($row->shift=="Shift A")
			$a40 = $a40+1;
		if($row->shift=="Shift B")
			$b40 = $b40+1;
		if($row->shift=="Shift C")
			$c40 = $c40+1;
	}
		
	if($shift==$row->shift or $i==1)
	{
		if(substr($iso,0,1)==2)
			$tot20 = $tot20+1;
		else 
			$tot40 = $tot40+1;
	}
	if($totalcon==$row->cont_no or $i==1)
	{
		if(substr($iso,0,1)==2)
			$tot20 = $tot20+1;
		else 
			$tot40 = $tot40+1;
	}
	if($yard!=$row->Yard_No)
	{
		$yard=$row->Yard_No;
		if($i!=1)
		{
		?>
		<tr>
			<td colspan="15"><b><?php  echo "Total 20'=>".$tot20." & 40'=>".$tot40;?></b></td>
		</tr>
		<?php
			if(substr($iso,0,1)==2)
			{
				$tot20 = 1;
				$tot40 = 0;
			}
			else
			{
				$tot20 = 0;
				$tot40 = 1;
			}
		}
		?>
		<tr>
			<td colspan="15"><b><?php  echo $row->Yard_No;?></b></td>
		</tr>
		<?php
		$i=1;
	}
	if($shift!=$row->shift)
	{	
		$shift=$row->shift;		
		if($i!=1)
		{
		?>
		<tr>
			<td colspan="15"><b><?php  echo "Total 20'=>".$tot20." & 40'=>".$tot40;?></b></td>
		</tr>
		<?php
			if(substr($iso,0,1)==2)
			{
				$tot20 = 1;
				$tot40 = 0;
			}
			else
			{
				$tot20 = 0;
				$tot40 = 1;
			}
		}
		?>
		<tr>
			<td colspan="15"><b><?php  echo $row->shift;?></b></td>
		</tr>	
		<?php	
		$i=1;
	}
	?>
	
	<?php
     if(($row->proEmtyDate)=="" or ($row->delivery=="")){

	if(($row->proEmtyDate)=="" or ($row->proEmtyDate)==null){ ?>
	<tr bgcolor="#F2DC5D" align="center">
	<?php }  if (($row->delivery=="") or  ($row->delivery==null)) { ?>
	<tr  bgcolor="#74BAE7" align="center">
	<?php } ?>
			<td><?php  echo $i;?></td>
			<td><?php if($row->cont_no) echo $row->cont_no; else echo "&nbsp;";?></td>
			<td><?php if($row->rot_no) echo $row->rot_no; else echo "&nbsp;";?></td>
			<td><?php if($iso) echo $iso; else echo "&nbsp;";?></td>
			<td><?php if($row->mlo) echo $row->mlo; else echo "&nbsp;";?></td>
			<td><?php if($row->statu) echo $row->statu; else echo "&nbsp;";?></td>
			<td><?php if($row->weight) echo $row->weight; else echo "&nbsp;";?></td>
			<td><?php if($row->mfdch_desc) echo $row->mfdch_desc; else echo "&nbsp;";?></td>
			<td><?php if($row->carrentPosition) echo $row->carrentPosition; else echo "&nbsp;";?></td>
			<td><?php if($row->dischargetime) echo $row->dischargetime; else echo "&nbsp;";?></td>
			<td><?php if($row->assignmentdate) echo $row->assignmentdate; else echo "&nbsp;";?></td>
			<td><?php if($row->proEmtyDate) echo $row->proEmtyDate; else echo "&nbsp;";?></td>
			<td><?php if($row->delivery) echo $row->delivery; else echo "&nbsp;";?></td>
		</tr>
	<?php
	 }
	} 
	mysql_close($con_cchaportdb);
	?>
		<tr>
			<td colspan="15"><b><?php  echo "Total 20'=>".$tot20." & 40'=>".$tot40;?></b></td>
			
		</tr>
		<?php 
		if($yard_no=="GCB")
		{
		?>
		<tr>
			<td colspan="15"><?php echo $allCont;?></td>
		</tr>
		<tr>
			
			<td colspan="15" align="center">
			<form action="<?php echo site_url('report/strippingPreparation/');?>" method="post">
				<input type="hidden" name="fromdate" value="<?php echo $fromdate; ?>">
				<button>StrippingPreparation</button>
			</form>
			<form action="<?php echo site_url('report/stripping/');?>" method="post">
				<input type="hidden" name="fromdate" value="<?php echo $fromdate; ?>">
				<button>Stripping</button>
			</form>
			
			</td>
		</tr>
		<?php 
		}
		?>
	</table>