

	<?php 
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=DEPOT_LADEN_CONTAINER_LIST.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

			putenv('TZ=Asia/Dhaka');
			//echo $rotation;
			include("dbConection.php");
			//echo $sValue;
			$str = "select now() as dt";
			$res = mysql_query($str);
			$rowD = mysql_fetch_object($res);
			$date = $rowD->dt;
			$strDepoName = "select distinct ctmsmis.offdoc.name from ctmsmis.offdoc where id='$depo'";
			$resDepoName = mysql_query($strDepoName);
			$rowDepoName = mysql_fetch_object($resDepoName);
			$DepoName = $rowDepoName->name;
			$cond = " and right(nominal_length,2)=20";
			if($size!="20")
			{
				$cond = " and right(nominal_length,2)!=20";
			}
			$str2 = "select sparcsn4.inv_unit.id,sparcsn4.inv_unit.category,sparcsn4.inv_unit.freight_kind,sparcsn4.inv_unit_fcy_visit.last_pos_slot,
			sparcsn4.inv_unit_fcy_visit.flex_string10,ifnull(r.id,'') as mlo,ifnull(r.name,'') as mloName,ifnull(Y.id,'') as agent,
			ifnull(Y.name,'') as agentName,right( nominal_length,2) as size,right( nominal_height,2)/10 as height,inv_goods.destination
			FROM sparcsn4.inv_unit 
			INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey 
			INNER JOIN sparcsn4.inv_unit_equip ON inv_unit.gkey=inv_unit_equip.unit_gkey 
			INNER JOIN sparcsn4.ref_equipment ON inv_unit_equip.eq_gkey=ref_equipment.gkey
			INNER JOIN sparcsn4.ref_equip_type ON ref_equipment.eqtyp_gkey=ref_equip_type.gkey 
			INNER JOIN sparcsn4.inv_goods ON inv_unit.goods=inv_goods.gkey
			inner join  ( sparcsn4.ref_bizunit_scoped r   
						 LEFT JOIN ( sparcsn4.ref_agent_representation X   
						 LEFT JOIN sparcsn4.ref_bizunit_scoped Y ON X.agent_gkey=Y.gkey )  ON r.gkey=X.bzu_gkey                               
						)  ON r.gkey = sparcsn4.inv_unit.line_op
			where sparcsn4.inv_unit.category='IMPRT' and inv_unit.visit_state ='1ACTIVE' and inv_unit_fcy_visit.transit_state='S40_YARD'
			and destination='$depo' $cond";			
			$result2 = mysql_query($str2);
		?>
		<table align="center" border="0">
			<tr>
				
			</tr>
			<tr>
				<td>
					<h2 align="center">CHITTAGONG PORT AUTHORITY</h2>
				</td>
			</tr>
			<tr>
				<td>
					<h3 align="center"><?php echo "DEPOT LADEN CONTAINER AT CHITTAGONG PORT UP TO ".$date." OF ".$DepoName;?></h3>
				</td>
			</tr>
			<tr>
				<td>
					<table border="0" cellspacing="1" cellpadding="3">
						<tr>
							<th>SL.NO</th><th>CONTAINER NO.</th><th>CATEGORY.</th><th>STATUS</th><th>MLO</th><th>SIZE</th><th>HEIGHT</th><th>POSITION</th><th>ROTATION</th>
						</tr>
						<?php 
							$i = 0;
							while($row2 = mysql_fetch_object($result2))
							{	
							$i++;
						?>
							<tr>
								<td><?php echo $i;?></td>
								<td><?php echo $row2->id;?></td>
								<td><?php echo $row2->category;?></td>
								<td><?php echo $row2->freight_kind;?></td>
								<td><?php echo $row2->mlo;?></td>
								<td><?php echo $row2->size;?></td>
								<td><?php echo $row2->height;?></td>
								<td><?php echo $row2->last_pos_slot;?></td>
								<td><?php echo $row2->flex_string10;?></td>
							</tr>
						<?php 
							}
						?>
					</table>
				</td>
			</tr>
			<?php mysql_close($con_sparcsn4);?>
		</table>