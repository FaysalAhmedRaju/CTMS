<HTML>
	<HEAD>
		<TITLE>YARD WISE CONTAINER DELIVERY REPORT</TITLE>
		
	    <style type="text/css">
<!--
.style1 {font-size: 12px}
-->
        </style>
</HEAD>
<BODY>

	<?php
		include("dbConection.php");
		$sql_cond="";
		if($yard_no!="")
		{
			if($block=="ALL")
			{
				$sql_cond="Yard_No= '$yard_no'";
			}
			else
			{
				$sql_cond="Yard_No='$yard_no' and Block_No='$block'";
			}
		}
				$sql="SELECT DISTINCT *
						FROM (
						SELECT a.id AS cont_no,a.seal_nbr1 as seal_nbr,a.category,
						(select right(sparcsn4.ref_equip_type.nominal_length,2) from sparcsn4.inv_unit_equip
						inner join sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
						inner join  sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
						where sparcsn4.inv_unit_equip.unit_gkey=a.gkey) as size,
						(select right(sparcsn4.ref_equip_type.nominal_height,2) from sparcsn4.inv_unit_equip
						inner join sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
						inner join  sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
						where sparcsn4.inv_unit_equip.unit_gkey=a.gkey)/10 as height,
						b.time_in AS dischargetime,
						b.time_out as delivery,
						b.last_pos_name,
						g.id AS mlo,
						sparcsn4.config_metafield_lov.mfdch_desc,
						a.freight_kind AS statu,
						a.goods_and_ctr_wt_kg AS weight,

						(SELECT ctmsmis.cont_yard((SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
						FROM sparcsn4.srv_event
						INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
						WHERE sparcsn4.srv_event.applied_to_gkey=a.gkey AND sparcsn4.srv_event.event_type_gkey=18 LIMIT 1))) AS Yard_No,
						(SELECT ctmsmis.cont_block((SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
						FROM sparcsn4.srv_event
						INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
						WHERE sparcsn4.srv_event.applied_to_gkey=a.gkey AND sparcsn4.srv_event.event_type_gkey=18 LIMIT 1),Yard_No)) AS Block_No,
						b.flex_date01 AS assignmentdate

						FROM sparcsn4.inv_unit a
						INNER JOIN sparcsn4.inv_unit_fcy_visit b ON b.unit_gkey=a.gkey
						INNER JOIN sparcsn4.ref_bizunit_scoped g ON a.line_op = g.gkey
						INNER JOIN sparcsn4.config_metafield_lov ON a.flex_string01=config_metafield_lov.mfdch_value
						INNER JOIN
							 sparcsn4.inv_goods j ON j.gkey = a.goods
						LEFT JOIN
							 sparcsn4.ref_bizunit_scoped k ON k.gkey = j.consignee_bzu
						WHERE date(b.flex_date01)='$assDt' AND config_metafield_lov.mfdch_value NOT IN ('CANCEL','OCD','APPCUS','APPOTH','APPREF')
						) AS tmp where ".$sql_cond." and delivery between '$fromdate $fromTime:00' and '$todate $toTime:00'";
				/*$sql = "select * from (select inv_unit.id,
						(select right(sparcsn4.ref_equip_type.nominal_length,2) from sparcsn4.inv_unit_equip
						inner join sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
						inner join  sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
						where sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey) as size,
						(select right(sparcsn4.ref_equip_type.nominal_height,2) from sparcsn4.inv_unit_equip
						inner join sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
						inner join  sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
						where sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey)/10 as height,
						sparcsn4.ref_bizunit_scoped.id as MLO,inv_unit.category,inv_unit.freight_kind,
						(SELECT ctmsmis.cont_yard(sparcsn4.inv_unit_fcy_visit.last_pos_slot)) AS Yard_No,
						(SELECT ctmsmis.cont_block(sparcsn4.inv_unit_fcy_visit.last_pos_slot,Yard_No)) AS Block_No,
						inv_unit_fcy_visit.last_pos_name,inv_unit_fcy_visit.last_pos_slot,
						inv_unit_fcy_visit.time_in

						from sparcsn4.inv_unit 
						inner join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
						inner join ref_bizunit_scoped on sparcsn4.inv_unit.line_op=sparcsn4.ref_bizunit_scoped.gkey
						where sparcsn4.inv_unit_fcy_visit.time_in BETWEEN '$fromdate $fromTime:00' and '$todate $toTime:00' 
						and sparcsn4.inv_unit.category='IMPRT') as tmp
						where ".$sql_cond;*/
			
			//echo $sql;
		$sqlRslt=mysql_query($sql,$con_sparcsn4);								
	?>
			
		<TABLE width="100%">
			<TR><TD width="100%">
				<table class='table-header' border=0 width="100%">
					<tr><td colspan="2" align="center"><h1>YARD WISE CONTAINER DELIVERY REPORT</h1></td></tr>
					<tr>
						<tr>
							<th align="center" colspan="6">
								<h3>
								<?php 
									$strTitle = "";
									$strTitle2 = "";
									$strTitle3 = "";
									$strTitle = "SEARCH FOR TERMINAL : ".$yard_no." AND BLOCK : ".$block;
									$strTitle2 = "</br>DELIVERY DATE FROM : ".$fromdate." ".$fromTime.":00 TO : ".$todate." ".$toTime.":00";
									$strTitle3 = "</br>ASSIGNMENT DATE : ".$assDt;
									echo $strTitle.$strTitle2.$strTitle3;
								?>
								</h3>
							</th>
						</tr>
				</table>
			</TD></TR>
			<TR><TD>
					<table width="100%" border=1  cellspacing="0" cellpadding="0">
					<tr>
						
						<th align="center">Sl</th>
						<th align="center">CONTAINER</th>						
						<th align="center">SEAL NO</th>						
						<th align="center">SIZE</th>						
						<th align="center">HEIGHT</th>						
						<th align="center">WEIGHT</th>						
						<th align="center">MLO</th>		
						<th align="center">CATEGORY</th>							
						<th align="center">FRIEGHT KIND</th>						
						<!--th align="center">YARD</th-->
						<?php if($block=="ALL") {?>		
						<th align="center">BLOCK</th>
						<?php }?>
						<th align="center">LAST POSITION</th>
						<!--th align="center">LAST SLOT</th>											
						<th align="center">TIME IN</th-->								
					</tr>
					<?php
					$eq = "";
					$i=0;
					while ($row=mysql_fetch_object($sqlRslt))						
					{
						$i=$i+1;
					?>
						 <tr>
								<td  align="center"><?php echo $i;?></td>
								<td  align="center"><?php if($row->cont_no) echo($row->cont_no); else echo("&nbsp;");?></td>
								<td  align="center"><?php if($row->seal_nbr) echo($row->seal_nbr); else echo("&nbsp;");?></td>
								<td  align="center"><?php if($row->size) echo($row->size); else echo("&nbsp;");?></td>
								<td  align="center"><?php if($row->height) echo($row->height); else echo("&nbsp;");?></td>
								<td  align="center"><?php if($row->weight) echo($row->weight); else echo("&nbsp;");?></td>
								<td  align="center"><?php if($row->mlo) echo($row->mlo); else echo("&nbsp;");?></td>
								<td  align="center"><?php if($row->category) echo($row->category); else echo("&nbsp;");?></td>
								<td  align="center"><?php if($row->statu) echo($row->statu); else echo("&nbsp;");?></td>
								<!--td  align="center"><?php if($row->Yard_No) echo($row->Yard_No); else echo("&nbsp;");?></td-->
								<?php if($block=="ALL") {?>	
								<td  align="center"><?php if($row->Block_No) echo($row->Block_No); else echo("&nbsp;");?></td>
								<?php }?>
								<td  align="center"><?php if($row->last_pos_name) echo($row->last_pos_name); else echo("&nbsp;");?></td>
								<!--td  align="center"><?php if($row->last_pos_slot) echo($row->last_pos_slot); else echo("&nbsp;");?></td>
								<td  align="center"><?php if($row->time_in) echo($row->time_in); else echo("&nbsp;");?></td-->
						</tr>					 
					<?php 
					}
					?>
					      </table>  						 
						</TD></TR>
					</TABLE>
	
<?php 
mysql_close($con_cchaportdb);
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>		
	</BODY>
</HTML>
<?php }?>
