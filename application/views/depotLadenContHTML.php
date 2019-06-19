<?php if($_POST['options']=='html'){?>
<html>
	<head>
		
	</head>
	<body>

	<?php } 
	else if($_POST['options']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=DEPOT_LADEN_CONTAINER.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}
			putenv('TZ=Asia/Dhaka');
			//echo $rotation;
			include("dbConection.php");
			//echo $sValue;
			$str = "select now() as dt";
			$res = mysql_query($str);
			$rowD = mysql_fetch_object($res);
			$date = $rowD->dt;
			$cond = " and destination not in('2591','BDCGP')";
			if($sValue=="depot")
			{
				$cond = " and destination not in('2591','BDCGP','2592','5231','5232','5233','5234','5235','5236','5237','5238','AUCTION','BDMGL','BDPGN')";
			}
			$str2 = "select destination,
			if(destination='AUCTION',destination,(select ctmsmis.offdoc.code from ctmsmis.offdoc where id=destination)) as offdoc_code,
			if(destination='AUCTION',destination,(select ctmsmis.offdoc.name from ctmsmis.offdoc where id=destination)) as offdoc_name,
			sum(cont_20) as cont_20,sum(cont_40) as cont_40,(sum(cont_20)+sum(cont_40)) as cont_tot,(sum(cont_20)+sum(cont_40)*2) as teus
			from(
			select
			(case when right( nominal_length,2)=20 then 1 else 0 end) as cont_20,
			(case when right( nominal_length,2)!=20 then 1 else 0 end) as cont_40,
			(case 
			when inv_goods.destination='BDMGL' then 5232
			when inv_goods.destination='BDPGN' then 5235
			else inv_goods.destination end
			) as destination
			FROM sparcsn4.inv_unit 
			INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey 
			INNER JOIN sparcsn4.inv_unit_equip ON inv_unit.gkey=inv_unit_equip.unit_gkey 
			INNER JOIN sparcsn4.ref_equipment ON inv_unit_equip.eq_gkey=ref_equipment.gkey
			INNER JOIN sparcsn4.ref_equip_type ON ref_equipment.eqtyp_gkey=ref_equip_type.gkey 
			INNER JOIN sparcsn4.inv_goods ON inv_unit.goods=inv_goods.gkey
			where sparcsn4.inv_unit.category='IMPRT' and inv_unit.visit_state ='1ACTIVE' and inv_unit_fcy_visit.transit_state='S40_YARD'
			and destination is not null and destination!='' and sparcsn4.inv_unit.freight_kind !='MTY' $cond		
			) as tmp group by destination";			
			$result2 = mysql_query($str2);
		?>
		<table align="center" border="0">
			<tr>
				
			</tr>
			<tr>
				<td align="center">
					<img align="middle" src="<?php echo IMG_PATH?>cpanew.jpg">
				</td>
			</tr>
			<tr>
				<td>
					<h3 align="center"><?php echo $title." ".$date;?></h3>
				</td>
			</tr>
			<tr>
				<td>
					<table border="0" cellspacing="1" cellpadding="3">
						<tr <?php if($_POST['options']=='html'){?>bgcolor="#9999CC"<?php }?>>
							<th>SL.NO</th><th>DPOT CODE NO.</th><th>DEPOT CODE IN TRADITIONAL SYSTEM</th><th>DEPOT NAME</th><th>20'</th><th>40'</th><th>TOTAL BOX</th><th>TOTAL TEUS</th>
						</tr>
						<?php 
							$i = 0;
							$cont20 = 0;
							$cont40 = 0;
							$box = 0;
							$teus = 0;
							while($row2 = mysql_fetch_object($result2))
							{	
							$i++;
							$cont20 = $cont20+$row2->cont_20;
							$cont40 = $cont40+$row2->cont_40;
							$box = $box+$row2->cont_tot;
							$teus = $teus+$row2->teus;
						?>
							<tr <?php if($_POST['options']=='html'){?>bgcolor="#CCCCCC"<?php }?>>
								<td><?php echo $i;?></td>
								<td><?php echo $row2->destination;?></td>
								<td><?php echo $row2->offdoc_code;?></td>
								<td><?php echo $row2->offdoc_name;?></td>
								<td>
									<?php 
										if($_POST['options']=='xl')
										{
											echo $row2->cont_20;
										}
										else
										{
									?>
										<a href="<?php echo site_url('report/depotLadenContListView/'.$row2->destination.'/20') ?>"><?php echo $row2->cont_20;?></a>
									<?php
										}
									?>
								</td>
								<td>
									<?php 
										if($_POST['options']=='xl')
										{
											echo $row2->cont_40;
										}
										else
										{
									?>
										<a href="<?php echo site_url('report/depotLadenContListView/'.$row2->destination.'/40') ?>"><?php echo $row2->cont_40;?></a>
									<?php
										}
									?>									
								</td>
								<td><?php echo $row2->cont_tot;?></td>
								<td><?php echo $row2->teus;?></td>
							</tr>
						<?php 
							}
						?>
							<tr <?php if($_POST['options']=='html'){?>bgcolor="#CCCCCC"<?php }?>>
								<td colspan="4"><b>Total</b></td>
								<td><b><?php echo $cont20;?></b></td>
								<td><b><?php echo $cont40;?></b></td>
								<td><b><?php echo $box;?></b></td>
								<td><b><?php echo $teus;?></b></td>
							</tr>
					</table>
				</td>
			</tr>
		</table>
<?php mysql_close($con_sparcsn4);?>
<?php if($_POST['options']=='html'){?>		
	</body>
</html>
<?php }?>	