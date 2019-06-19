

<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="50px">
		<td colspan="14" align="center"><font size="5"><b>AGENT WISE PRE ADVICE CONTAINER LIST</b></font></td>
		
	</tr>
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr>
	<tr bgcolor="#A9A9A9" align="center" height="25px">
		<td style="border-width:3px;border-style: double;"><b>SlNo.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Container No.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Vessel Name.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Rotation.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Size.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Height.</b></td>
		<td style="border-width:3px;border-style: double;"><b>MLO</b></td>
		<td style="border-width:3px;border-style: double;"><b>Status</b></td>
		<td style="border-width:3px;border-style: double;"><b>Cont State</b></td>
		<td style="border-width:3px;border-style: double;"><b>Position</b></td>
		
	</tr>

<?php
	include("dbConection.php");
	$query=mysql_query("select * from (
select cont_id,rotation,cont_status,cont_mlo,cont_size,cont_height,agent,transOp,
(select sparcsn4.vsl_vessels.name from sparcsn4.vsl_vessel_visit_details
inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
where sparcsn4.vsl_vessel_visit_details.vvd_gkey=mis_exp_unit_preadv_req.vvd_gkey) as vsl_name,
(select transit_state from sparcsn4.inv_unit_fcy_visit where sparcsn4.inv_unit_fcy_visit.unit_gkey=mis_exp_unit_preadv_req.gkey) as transit_state,
(select last_pos_name from sparcsn4.inv_unit_fcy_visit where sparcsn4.inv_unit_fcy_visit.unit_gkey=mis_exp_unit_preadv_req.gkey) as last_pos_name
from ctmsmis.mis_exp_unit_preadv_req where transOp='$login_id'  
 )as tmp order by transit_state,last_pos_name");

	$i=0;
	$j=0;	
	$transit_state="";
	while($row=mysql_fetch_object($query)){
	$i++;
	
	if($transit_state!=$row->transit_state){
		

		if($j>0){
		?>
		<tr bgcolor="#aaffff" valign="center"><td colspan="2"><font size="4"><b>&nbsp;&nbsp;Total Container :</b></font></td><td  colspan="15">&nbsp;&nbsp;<font size="4"><b><?php  echo $j;?></b></font></td></tr>
		<?php
		}
		?>
		<tr bgcolor="#F0F4CA" valign="center"><td  colspan="15">&nbsp;&nbsp;<font size="4"><b><?php $transit_state = substr($row->transit_state, 4);if ($transit_state = substr($row->transit_state, 4)) echo $transit_state;else echo "&nbsp;";?></b></font></td></tr>
		<?php
		
		
		$j=1;
		
	}else{
		$j++;
		
	}
	$transit_state=$row->transit_state;
	
?>
<tr align="center">
		<td><?php echo $j;?></td>
		<td><?php if($row->cont_id) echo $row->cont_id; else echo "&nbsp;";?></td>
		<td><?php if($row->vsl_name) echo $row->vsl_name; else echo "&nbsp;";?></td>
		<td><?php if($row->rotation) echo $row->rotation; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_size) echo $row->cont_size; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_height) echo $row->cont_height; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_mlo) echo $row->cont_mlo; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_status) echo $row->cont_status; else echo "&nbsp;";?></td>
		<td><?php 
		if($row->transit_state) echo substr($row->transit_state,4); else echo "&nbsp;";?></td>
		<td><?php if($row->last_pos_name) echo $row->last_pos_name; else echo "&nbsp;";?></td>
	</tr>

<?php }

 ?>
<tr bgcolor="#DCDCDC" valign="center"><td colspan="2"><font size="4"><b>&nbsp;&nbsp;Total Container :</b></font></td><td  colspan="15">&nbsp;&nbsp;<font size="4"><b><?php  echo $j;?></b></font></td></tr>
<tr bgcolor="#E0FFFF" valign="center"><td colspan="2"><font size="4"><b>&nbsp;&nbsp;Grand Total:</b></font></td><td  colspan="15">&nbsp;&nbsp;<font size="4"><b><?php  echo $i;?></b></font></td></tr>
<?php mysql_close($con_sparcsn4);?>
</table>
