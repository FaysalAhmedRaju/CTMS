

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
		<td style="border-width:3px;border-style: double;"><b>State</b></td>
		<td style="border-width:3px;border-style: double;"><b>Category</b></td>
		
	</tr>

<?php
//echo $rot;
include("dbConection.php");

if($serch_by=="rot")
	{
		$query=mysql_query("select * from (
		select cont_id,rotation,cont_status,cont_mlo,cont_size,cont_height,agent,
		(select sparcsn4.vsl_vessels.name from sparcsn4.vsl_vessel_visit_details
		inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
		where sparcsn4.vsl_vessel_visit_details.vvd_gkey=mis_exp_unit_preadv_req.vvd_gkey) as vsl_name
		from ctmsmis.mis_exp_unit_preadv_req where agent='$login_id' and rotation='$serch_value'
		 )as tmp order by cont_id");
			
		
	}
	
	elseif($serch_by=="cont")
	{
		$query=mysql_query("select * from (
		select cont_id,rotation,cont_status,cont_mlo,cont_size,cont_height,agent,
		(select sparcsn4.vsl_vessels.name from sparcsn4.vsl_vessel_visit_details
		inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
		where sparcsn4.vsl_vessel_visit_details.vvd_gkey=mis_exp_unit_preadv_req.vvd_gkey) as vsl_name
		
		from ctmsmis.mis_exp_unit_preadv_req where agent='$login_id' and cont_id='$serch_value'  
		 )as tmp");
		
	
	}
	elseif($serch_by=="mlo")
	{
		$query=mysql_query("select * from (
		select cont_id,rotation,cont_status,cont_mlo,cont_size,cont_height,agent,
		(select sparcsn4.vsl_vessels.name from sparcsn4.vsl_vessel_visit_details
		inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
		where sparcsn4.vsl_vessel_visit_details.vvd_gkey=mis_exp_unit_preadv_req.vvd_gkey) as vsl_name
		
		from ctmsmis.mis_exp_unit_preadv_req where agent='$login_id' and cont_mlo='$serch_value' 
		 )as tmp");
		
	
	}
	elseif($serch_by=="pod")
	{
		$query=mysql_query("select * from (
		select cont_id,rotation,cont_status,cont_mlo,cont_size,cont_height,agent,
		(select sparcsn4.vsl_vessels.name from sparcsn4.vsl_vessel_visit_details
		inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
		where sparcsn4.vsl_vessel_visit_details.vvd_gkey=mis_exp_unit_preadv_req.vvd_gkey) as vsl_name
		
		from ctmsmis.mis_exp_unit_preadv_req where agent='$login_id' and pod='$serch_combo' 
		 )as tmp ");
		
	
	}
	else
	{
		$query=mysql_query("select * from (
		select cont_id,rotation,cont_status,cont_mlo,cont_size,cont_height,agent,
		(select sparcsn4.vsl_vessels.name from sparcsn4.vsl_vessel_visit_details
		inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
		where sparcsn4.vsl_vessel_visit_details.vvd_gkey=mis_exp_unit_preadv_req.vvd_gkey) as vsl_name
		
		from ctmsmis.mis_exp_unit_preadv_req where agent='$login_id' and transOp='$serch_combo'

		 ");
		
	}




	$i=0;
	$j=0;
	
	//$Trans="";
	//$cat="";
	while($row=mysql_fetch_object($query)){
	$i++;
	
								$strTrans = "select sparcsn4.inv_unit_fcy_visit.transit_state,sparcsn4.inv_unit.category from sparcsn4.inv_unit 
								inner join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
								where sparcsn4.inv_unit.id='$row->cont_id' order by sparcsn4.inv_unit_fcy_visit.gkey";
									//echo $strTrans."<hr>";
								$resTrans = mysql_query($strTrans);
								$Trans="";
								$cat="";
								while($rowTrans = mysql_fetch_object($resTrans))
								{
									$Trans=$rowTrans->transit_state;
									$cat=$rowTrans->category;
								}
		
	
	/*if($Trans==$Trans && $cat=='EXPRT'){
		if($j>0){
		?>
		<tr bgcolor="#DCDCDC" valign="center"><td colspan="2"><font size="4"><b>&nbsp;&nbsp;Total Container:</b></font></td><td  colspan="15">&nbsp;&nbsp;<font size="4"><b><?php  echo $j;?></b></font></td></tr>
		<?php
		}
		?>
		<tr bgcolor="#F0F4CA" valign="center">
		<td colspan="15"><?php $transs =$Trans; echo $str2 = substr($transs, 4);?></td>
		
		</tr>
		<?php
		
		
		$j=1;
		
	}else{
		$j++;
		
	}
	$Trans=$Trans;
	
	*/
?>
<tr align="center">
		<td><?php echo $i;?></td>
		<td><?php if($row->cont_id) echo $row->cont_id; else echo "&nbsp;";?></td>
		<td><?php if($row->vsl_name) echo $row->vsl_name; else echo "&nbsp;";?></td>
		<td><?php if($row->rotation) echo $row->rotation; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_size) echo $row->cont_size; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_height) echo $row->cont_height; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_mlo) echo $row->cont_mlo; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_status) echo $row->cont_status; else echo "&nbsp;";?></td>
		<td><?php $transs =$Trans; echo $str2 = substr($transs, 4);?></td>
		<td><?php if($cat) echo $cat; else echo "&nbsp;";?></td>
	</tr>

<?php }

 ?>

<tr bgcolor="#E0FFFF" valign="center"><td colspan="2"><font size="4"><b>&nbsp;&nbsp;Grand Total:</b></font></td><td  colspan="15">&nbsp;&nbsp;<font size="4"><b><?php  echo $i;?></b></font></td></tr>
<?php mysql_close($con_sparcsn4);?>
</table>
