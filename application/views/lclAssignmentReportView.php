	<?php
	include("mydbPConnection.php");
	for($i=0;$i<count($lclAssignmentList);$i++) 
	{
		$shed = $lclAssignmentList[$i]['cont_loc_shed'];
	?>	
	<?php if($i<count($lclAssignmentList)-1) {?>
	<div class="tblBreak">
	<?php } else { ?>
	<div class="pageBreakOff">
	<?php } ?>
	<table  cellspacing="1" cellpadding="1" align="center" >
		<tr>
			<th colspan="13" align="center"><font size="4">CHITTAGONG PORT AUTHORITY</font><br>LCL ASSIGNMENT REPORT</th>
		</tr>
		<tr>
			<td colspan="13" style="font-size:11px"><?php echo "Cargo To Be Stored at:  ".$shed; ?></td>
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
			$str = "select lcl_assignment_detail.id,igm_detail_container.cont_number,igm_detail_container.cont_size,
			    igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,
				igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,lcl_assignment_detail.remarks,
				date(lcl_assignment_detail.landing_time)as landing_time, lcl_assignment_detail.last_update AS lst_updt
				from lcl_assignment_detail
				inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id
				inner join igm_masters on igm_masters.id=igm_details.IGM_id
				inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id
				where unstuff_flag=0 and cont_loc_shed='$shed' ORDER BY lst_updt ASC";
				//echo $str;
				
			$res = mysql_query($str);
			$j = 0;
			while($row=mysql_fetch_object($res))
			{
				$j++;
		?>
		<tr>
			<td>
				<img src="<?php echo IMG_PATH;?>lclcheck.jpg">
			</td>
			 <td align="center" style="font-size:11px">
				<?php echo $j;?>
			</td >
			<td align="center" style="font-size:11px">
			   <?php echo $row->cont_number;?>
			</td>
			<td align="center" style="font-size:11px">
			   <?php echo $row->cont_size;?>
			</td>
          <td align="center" style="font-size:11px">
           <?php echo $row->cont_height;?>
          </td>
          <td align="center" style="font-size:11px">
           <?php echo $row->Import_Rotation_No;?>
          </td>   
		<td align="center" style="font-size:11px">
           <?php echo $row->Vessel_Name;?>
         </td>  
          <td align="center" style="font-size:11px">
           <?php echo $row->mlocode;?>
          </td>          
          <td align="center" style="font-size:11px">
           <?php echo $row->stv;?>
          </td>
          <td align="center" style="font-size:11px">
           <?php echo $row->cont_loc_shed;?>
          </td>  
		  <td align="center" style="font-size:11px">
           <?php echo $row->description_cargo;?>
          </td> 
		  <td align="center" style="font-size:11px">
           <?php echo $row->landing_time;?>
          </td> 
		  <td align="center" style="font-size:11px">
           <?php echo $row->remarks;?>
          </td> 
		  
         </tr>
			
		<?php 
			} 
		?>
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
	</div>
	<div class="mybreak"> </div>
	<?php
	}
	?>
	
	