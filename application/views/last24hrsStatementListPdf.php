<table align="center"  width="70%"  cellspacing="0" cellpadding="0">
								<tr style="height:35px";>
									<td align="center" colspan="12" style="border: 1px solid black; color:black"><b><h1 style="color:black">Last 24hrs Statement</h1></b></td>
								</tr>
								<tr>
									<th align="center" colspan="7" style="border: 1px solid black; height:22px; color:black"><h2><b>Name of Off-Dock : <?php echo $offDock;?></b></h2></th>
									<th align="center" colspan="5" width="70%"  style="border: 1px solid black; color:black"><h2>Date : <?php echo $offDockData[0]['stmt_date']?></h2></th>
								</tr>	
								<tr>
									<th align="center" rowspan="2" style="border: 1px solid black; height:22px; color:black"><b>Off-Dock</b></th>
								    <th align="center" rowspan="2" style="border: 1px solid black; color:black">Capacity(TEUs)</th>
									<th align="center" rowspan="2" style="border: 1px solid black; color:black">Import Cont. <br/> Lying (TEUs) </th>
								    <th align="center" rowspan="2" style="border: 1px solid black; color:black">Export Cont. <br/> Lying (TEUs) </th>
									<th align="center" rowspan="2" style="border: 1px solid black; color:black">Empty Cont.<br/> Lying(TEUs)</th>
								    <th align="center" rowspan="2" style="border: 1px solid black; color:black">Total(TEUs)</th>
									<th align="center" rowspan="2" style="border: 1px solid black; color:black">Last 24hrs Export<br/> stuffed(TEUs)</th>
								    <th align="center" colspan="2" style="border: 1px solid black; color:black">PORT TO DEPORT(TEUS)</th>
									<th align="center" colspan="2" style="border: 1px solid black; color:black">DEPORT TO PORT(TEUS)</th>					
								    <th align="center" rowspan="2" style="border: 1px solid black; color:black">Remarks</th>	
								</tr>
								<tr>
									<th align="center" style="border: 1px solid black; color:black">LADEN</th>
									<th align="center" style="border: 1px solid black; color:black">EMPTY</th>
									<th align="center" style="border: 1px solid black; color:black">LADEN</th>
									<th align="center" style="border: 1px solid black; color:black">EMPTY</th>									
								</tr>
										
								<tr>
									<td align="center" style="border: 1px solid black;"><?php echo $offDock; ?></td>
									<td align="center" style="border: 1px solid black;"><?php echo $offDockData[0]['capacity']?></td>
									<td align="center" style="border: 1px solid black;"><?php echo $offDockData[0]['imp_lying']?></td>
									<td align="center" style="border: 1px solid black;"><?php echo $offDockData[0]['exp_lying']?></td>
									<td align="center" style="border: 1px solid black;"><?php echo $offDockData[0]['mty_lying']?></td>
									<td align="center" style="border: 1px solid black;"><?php echo $offDockData[0]['total_teus']?></td>
									<td align="center" style="border: 1px solid black;"><?php echo $offDockData[0]['last_24hrs']?></td>
									<td align="center" style="border: 1px solid black;"><?php echo $offDockData[0]['port_to_depo_laden']?></td>
									<td align="center" style="border: 1px solid black;"><?php echo $offDockData[0]['port_to_depo_mty']?></td>
									<td align="center" style="border: 1px solid black;"><?php echo $offDockData[0]['depo_to_port_laden']?></td>
									<td align="center" style="border: 1px solid black;"><?php echo $offDockData[0]['depo_to_port_mty']?></td>
									<td align="center" style="border: 1px solid black;"><?php echo $offDockData[0]['remarks']?></td>
								</tr>
								<tr>
									<td colspan="12" style="border: 1px solid black; height:60px;"></td>
								</tr>
								
								
								
							</table>