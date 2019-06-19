<?php

echo"Shemul";

	if($DeliveryList) {
			$len=count($DeliveryList);
             echo $len;
            for($i=0;$i<$len;$i++){ ?>
		<table width="900px" border="0" align="center">
			<tr>
				<td width="300px">
					NO. <?php echo $DeliveryList[$i]['bill_no']; ?>
				</td>
				<td width="300px" align="center">
					<font size="5"><b>ORIGINAL</b></font>
				</td>
				<td width="300px" align="right">
					CHITTAGONG
				</td>
			</tr>
			<tr>
				<td width="300px" colspan="2">
					THE DEPUTY TRAFFIC MANAGER<br>CHITTAGONG PORT AUTHORITY<br>CHITTAGONG
				</td>
				<td width="300px" align="right">
					Date:
				</td>
			</tr>
			<tr>
				<td colspan="3">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td width="895px" colspan="3">
					Sir,<br>
					Please Deliver to M/S_____________________________________________________________________________________________<br>
					or order the undermentioned Cargo Ex. M.V._________________________________________________________________________<br>
					Voy____________________ arrived from_________________________ Imp. Rot No____________________________________<br>
					and take proper receipt.
				</td>
			</tr>
			<tr>
				<td colspan="3">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<table border="1" width="895px" cellspacing="0" cellpadding="0">
						<tr align="center">
							<td width="45%">
								Marks & Numbers
							</td>
							<td width="55%">
								No. of Packages & Description
							</td>
						</tr>
						<tr>
							<td width="45%">
								Query Value
							</td>
							<td width="55%">
								Query Value
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan="3">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="45%">
								L/No. _______________________
							</td>							
						</tr>
						<tr>
							<td width="55%">
								B/L No. _______________________
							</td>
						</tr>
						<tr>
							<td width="45%">
								B/E No. ____________________ Dt. _______________
							</td>	
						</tr>
						<tr>
							<td width="55%">
								G.P No. ____________________ Dt. _______________
							</td>
						</tr>
						<tr>
							<td width="55%">
								<b>PAID UPTO:</b>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td>
								Query Value
							</td>
						</tr>
						<tr>							
							<td>
								&nbsp;
							</td>
						</tr>
						<tr align="right">
							<td>
								As Agents
							</td>
						</tr>
					</table>
					
				</td>
			</tr>
		</table>
		<?php }} ?>
