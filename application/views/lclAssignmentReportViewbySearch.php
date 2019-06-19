	<?php
	//for($i=0;$i<count($lclAssignmentList);$i++) 
	//{
		//$shed = $lclAssignmentList[$i]['cont_loc_shed'];
	?>	
	<table  cellspacing="1" cellpadding="1" align="center" class="tblBreak">
		<tr>
			<th colspan="13" align="center"><font size="4">CHITTAGONG PORT AUTHORITY</font><br><?php echo $title; ?></th>
		</tr>
		<tr>
			<td colspan="13" align="right">Print Dt.  <?php echo $lclAssignmentList[0]['time']; ?></td>
		</tr>
			
		<tr>
			<th style="border:1px solid black; font-size:11px">Y/N</th>
			<th style="border:1px solid black; font-size:11px">SL</th>
			<th style="border:1px solid black; font-size:11px"><nobr>Container No</nobr></th>
			<th style="border:1px solid black; font-size:11px">Size</th>
			<th style="border:1px solid black; font-size:11px">Height</th>
			<th style="border:1px solid black; font-size:11px">Rotation</th>
			<th style="border:1px solid black; font-size:11px"><nobr>Vessel Name</nobr></th>
			<th style="border:1px solid black; font-size:11px">MLO</th>
			<th style="border:1px solid black; font-size:11px">STV</th>
			<th style="border:1px solid black; font-size:11px"><nobr>Cont at Shed</nobr></th>
			<th style="border:1px solid black; font-size:11px"><nobr>Description of Cargo</nobr></th>
			<th style="border:1px solid black; font-size:11px"><nobr>Landing Date</nobr></th>
			<th style="border:1px solid black; font-size:11px">Remarks</th>
		</tr>
	<?php
	for($i=0;$i<count($lclAssignmentList);$i++) 
	{
		//$shed = $lclAssignmentList[$i]['cont_loc_shed'];
	?>	
		<tr>
			<td>
				<img src="<?php echo IMG_PATH;?>lclcheck.jpg">
			</td>
			 <td align="center" style="font-size:11px">
				<?php echo $i+1;?>
			</td >
			<td align="center" style="font-size:11px">
			   <?php echo $lclAssignmentList[$i]['cont_number'];?>
			</td>
			<td align="center" style="font-size:11px">
			   <?php echo $lclAssignmentList[$i]['cont_size']?>
			</td>
          <td align="center" style="font-size:11px">
           <?php echo $lclAssignmentList[$i]['cont_height'];?>
          </td>
          <td align="center" style="font-size:11px">
           <?php echo $lclAssignmentList[$i]['Import_Rotation_No'];?>
          </td>   
		  <td align="center" style="font-size:11px">
           <?php echo $lclAssignmentList[$i]['Vessel_Name'];?>
          </td>  
          <td align="center" style="font-size:11px">
           <?php echo $lclAssignmentList[$i]['mlocode'];?>
          </td>          
          <td align="center" style="font-size:11px">
           <?php echo $lclAssignmentList[$i]['stv'];?>
          </td>
          <td align="center" style="font-size:11px">
           <?php echo $lclAssignmentList[$i]['cont_loc_shed'];?>
          </td>  
		  <td align="center" style="font-size:11px">
           <?php echo $lclAssignmentList[$i]['description_cargo'];?>
          </td> 
		  <td align="center" style="font-size:11px">
           <?php echo $lclAssignmentList[$i]['landing_time'];?>
          </td> 
		  <td align="center" style="font-size:11px">
           <?php echo $lclAssignmentList[$i]['remarks'];?>
          </td> 
		  
         </tr>
			<?php
	} ?>

		<tr>
			<td colspan="13"><hr/> </td>
		</tr>
		<tr>
			<td colspan="10" style="padding-left:50px;">
				<font>
				<p align="left" style="font-size:11px">
				1) All Hazardous Cargo must be removed to "P/O" shed by the Unstuffing Stevedors.<br/>
				2)Containers bearing SL .No._______ <br/>
				Must be unstuffed in presence of Army/ Navy/Air Force/Police Personnel and<br/>
				Army/ Navy/Air Force/Police cargo must be stored in the Lockfast.<br/>
				3)Containers bearing lockfast cargo must be placed near lockfast  for unstuffing purpose.<br/><br/>
				MOBILE;01 & 02 TO ensure the placement of containers in time <br/>
				M/S-<br/>
				Incharge/Yard No:<br/>
				Incharge/CFS No:<br/>
				</p>			
				</font>
			</td>
			<td colspan="3" style="padding-left:50px;">
				<font>
				<p align="left" style="font-size:11px"> 
				<br/>
				<br/><br/><br/>	<br/><br/><hr>
				Terminal Officer (CFS)<br/>
				Chittagong Port Authority<br/>
				</p>			
				</font>
			</td>
		</tr>
	</table>	
	<!--div class="mybreak"> </div-->
	

	
	