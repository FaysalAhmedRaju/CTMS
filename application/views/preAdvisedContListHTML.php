<html>
	<head>
	
	</head>
	<body>
		<table align="center">
			<tr align="center">
				<td>&nbsp;</td>
			</tr>
			<tr align="center">
				<td><h1>CHITTAGONG PORT AUTHOURITY, CHITTAGONG</h1></td>
			</tr>
			<tr align="center">
				<td><h2><?php echo $title;?></h2></td>
			</tr>
			<tr align="center">
				<td>
					<table border="1">
						<tr>
							<th>SL</th><th>Rotation</th><th>Agent</th><th>Container No.</th><th>MLO</th><th>ISO Type</th><th>Size</th><th>Height</th><th>Form</th><th>Present State</th>
						</tr>
						<?php 
						include("dbConection.php");
						$contStr = "";
						for($i=0;$i<count($preAddContList);$i++) {?>
						<tr>							
							<td><?php echo $i+1; ?></td>
							<td><?php echo $preAddContList[$i][rotation]; ?></td>
							<td><?php echo $preAddContList[$i][agent]; ?></td>
							<td><?php echo $preAddContList[$i][cont_id]; ?></td>
							<td><?php echo $preAddContList[$i][cont_mlo]; ?></td>
							<td><?php echo $preAddContList[$i][isoType]; ?></td>
							<td><?php echo $preAddContList[$i][cont_size]; ?></td>
							<td><?php echo $preAddContList[$i][cont_height]; ?></td>
							<td><?php echo $preAddContList[$i][transOp]; ?></td>							
							<td>
								<?php 
									if($i+1==10)
										$contStr = $contStr.$preAddContList[$i][cont_id].",<br>";
									else
										$contStr = $contStr.$preAddContList[$i][cont_id].", ";
									$cont =$preAddContList[$i][cont_id];
									$str = "select sparcsn4.inv_unit_fcy_visit.transit_state from sparcsn4.inv_unit 
									inner join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
									where sparcsn4.inv_unit.id='$cont' order by sparcsn4.inv_unit_fcy_visit.gkey";
									//echo $str;
									$result = mysql_query($str);
									$trans = "";
									while($row = mysql_fetch_object($result))
									{
										$trans = $row->transit_state;
									}
									$transPart = explode("_", $trans);
									echo $transPart[1]; 
								?>
							</td>							
						</tr>						
						<?php } ?>
						<tr>
							<td colspan="10"><?php echo $contStr;?></td>
						</tr>
						<?php mysql_close($con_sparcsn4);?>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>