
<html>
<head>
	<table align="center" width="95%">
		<tr>
			<td align="center"><font size="5"><b>CHITTAGONG PORT AUTHORITY</b></font></td>
		</tr>
		<tr>
			<td align="center"><b>Chittagong, Bangladesh</b></td>
		</tr>
		<tr>
			<td align="center"><b>Berthing Report</b></td>
		</tr>	
		<tr>
			<td align="center"><b><?php echo $fromdate."   " ?> TO<?php echo " ".$todate ?></b></td>
		</tr>	
	</table>	
</head>
<body>	
	<div align ="center">
		
		<table align="center" width="95%">
			<thead>
				<tr>
					<td class="bottomtopborder" align="center">Sl</td>
					<td class="bottomtopborder" align="center">Vessel ID</td>
					<td class="bottomtopborder" align="center">Vessel Name</td>
					<td class="bottomtopborder" align="center">Length</td>
					<td class="bottomtopborder" align="center">Draugh</td>
					<td class="bottomtopborder" align="center">Local Agent</td>
					<td class="bottomtopborder" align="center">L.Call Port</td>
					<td class="bottomtopborder" align="center">L.Op</td>
					<td class="bottomtopborder" align="center">Flag</td>
					<td class="bottomtopborder" align="center">Berthing Date(Est)</td>
					<td class="bottomtopborder" align="center">Berthing Date (Act)</td>
					<td class="bottomtopborder" align="center">Jetty No</td>
				</tr>
			</thead>

			<tr>
				<th colspan="12" style="font-size:5px">
					<hr/>
				</th>
			</tr>
			<?php
				
				for($i=0; $i<count($resultList); $i++) {?>
				
				<tr>
					<td align="center"><?php echo $i+1; ?></td>
					<td align="center"><?php echo $resultList[$i]['VesselID']; ?></td>
					<td align="center"><?php echo $resultList[$i]['VesselName']; ?></td>
					<td align="center"><?php echo $resultList[$i]['LENGTH']; ?></td>
					<td align="center"><?php echo $resultList[$i]['Draft']; ?></td>
					<td align="center"><?php echo $resultList[$i]['LoadPortCall']; ?></td>
					<td align="center"><?php echo $resultList[$i]['LocalAgent']; ?></td>
					<td align="center"><?php echo $resultList[$i]['LineOperator']; ?></td>
					<td align="center"><?php echo $resultList[$i]['Flag']; ?></td>
					<td align="center"><?php echo $resultList[$i]['estBerthDate']; ?></td>
					<td align="center"><?php echo $resultList[$i]['BerthDate']; ?></td>
					<td align="center"><?php echo $resultList[$i]['JettyNo']; ?></td>
					<td align="center">&nbsp;</td>
				</tr>
				<?php   
				} 
				?>
		</table>
		

	</div>
</body>
</html>