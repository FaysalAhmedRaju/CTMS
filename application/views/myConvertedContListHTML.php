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
							<th>SL</th><th>Rotation</th><th>Agent</th><th>Container No.</th><th>MLO</th><th>ISO Type</th><th>Size</th><th>Height</th><th>Form</th><th>Category</th><th>Present State</th>
						</tr>
						<?php 
						include("dbConection.php");
						$str ="select vvd_gkey,rotation,agent,cont_id,cont_mlo,isoType,cont_size,cont_height,transOp
						from ctmsmis.mis_exp_unit_preadv_req where preAddStat=1 and date(last_update)=date(now()) and vvd_gkey=$vvdGkey";
						//echo $str;
						$res =mysql_query($str);
						$contStr = "";
						$i=0;
						$j=0;
						$no= 0;
						while($row=mysql_fetch_object($res)) 
						{
							
							$cont =$row->cont_id;
							$strTrans = "select sparcsn4.inv_unit_fcy_visit.transit_state,sparcsn4.inv_unit.category from sparcsn4.inv_unit 
							inner join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
							where sparcsn4.inv_unit.id='$cont' order by sparcsn4.inv_unit_fcy_visit.gkey";
							//echo $str;
							$resultTrans = mysql_query($strTrans);
							$trans = "";
							$cat="";
							while($rowTrans = mysql_fetch_object($resultTrans))
							{
								$trans = $rowTrans->transit_state;
								$cat = $rowTrans->category;
							}
							$transPart = explode("_", $trans);
								
							/*$strCat = "select category from sparcsn4.inv_unit where id='$row->cont_id'";
							$resCat = mysql_query($strCat);
							$cat="";
									
							while($rowCat = mysql_fetch_object($resCat))
							{
								$cat=$rowCat->category;
							}*/
								
							if($trans=="S40_YARD" or $trans=="S50_ECOUT")
							{
								$no = 1;
								$i=$i+1;
							}
							else if($cat=="EXPRT" and ($trans=="S60_LOADED" or $trans=="S70_DEPARTED" or $trans=="S99_RETIRED"))
							{
								$no = 1;
								$i=$i+1;
							}
							else if(($cat=="IMPRT" or $cat=="STRGE") and $trans=="S20_INBOUND")
							{
								$no = 1;
								$i=$i+1;
							}
							else
							{
								if($i==10)
									$contStr = $contStr.$row->cont_id.",<br>";
								else
									$contStr = $contStr.$row->cont_id.", ";
									
								$no = 0;
								$j=$j+1;
							}
							//echo $no;	
						if($no==0)
						{
						//echo "yes";
						?>
						<tr>							
							<td><?php echo $j; ?></td>
							<td><?php echo $row->rotation; ?></td>
							<td><?php echo $row->agent; ?></td>
							<td><?php echo $row->cont_id; ?></td>
							<td><?php echo $row->cont_mlo; ?></td>
							<td><?php echo $row->isoType; ?></td>
							<td><?php echo $row->cont_size; ?></td>
							<td><?php echo $row->cont_height; ?></td>
							<td><?php echo $row->transOp; ?></td>							
							<td><?php echo $cat; ?></td>							
							<td>
								<?php 									
									echo $transPart[1]; 
								?>
							</td>							
						</tr>						
						<?php 
						}
						}
						?>
						<tr>
							<td colspan="10"><?php echo $contStr;?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>