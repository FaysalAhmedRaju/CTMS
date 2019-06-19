<HTML>
	<HEAD>
		<TITLE>YARD WISE CONTAINER RECEIVE REPORT</TITLE>
		
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
				$sql="select * from (select inv_unit.id,(inv_unit.goods_and_ctr_wt_kg/1000) as weight,inv_unit.seal_nbr1 as seal_nbr,
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
						inner join sparcsn4.argo_carrier_visit on sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
						inner join sparcsn4.vsl_vessel_visit_details on sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
						inner join ref_bizunit_scoped on sparcsn4.inv_unit.line_op=sparcsn4.ref_bizunit_scoped.gkey
						where sparcsn4.inv_unit_fcy_visit.time_in BETWEEN '$fromdate $fromTime:00' and '$todate $toTime:00' 
						and sparcsn4.inv_unit.category='IMPRT' and sparcsn4.vsl_vessel_visit_details.ib_vyg='$rotNum') as tmp
						where ".$sql_cond;;
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
					<tr><td colspan="2" align="center"><h1>YARD WISE CONTAINER RECEIVE REPORT</h1></td></tr>
					<tr>
						<tr>
							<th align="center" colspan="6">
								<h3>
								<?php 
									$strTitle = "";
									$strTitle2 = "";
									$strTitle3 = "";
									$strTitle = "SEARCH FOR TERMINAL : ".$yard_no." AND BLOCK : ".$block;
									$strTitle2 = "</br>DATE FROM : ".$fromdate." ".$fromTime.":00 TO : ".$todate." ".$toTime.":00";
									$strTitle3 = "</br>ROTATION NO : ".$rotNum;
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
								<td  align="center"><?php if($row->id) echo($row->id); else echo("&nbsp;");?></td>
								<td  align="center"><?php if($row->seal_nbr) echo($row->seal_nbr); else echo("&nbsp;");?></td>
								<td  align="center"><?php if($row->size) echo($row->size); else echo("&nbsp;");?></td>
								<td  align="center"><?php if($row->height) echo($row->height); else echo("&nbsp;");?></td>
								<td  align="center"><?php if($row->weight) echo($row->weight); else echo("&nbsp;");?></td>
								<td  align="center"><?php if($row->MLO) echo($row->MLO); else echo("&nbsp;");?></td>
								<td  align="center"><?php if($row->category) echo($row->category); else echo("&nbsp;");?></td>
								<td  align="center"><?php if($row->freight_kind) echo($row->freight_kind); else echo("&nbsp;");?></td>
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
