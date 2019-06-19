
<div align="center" style="font-size:18px">
		<img align="middle"  width="220px" height="70px" src="<?php echo IMG_PATH?>cpanew.jpg">
	</div>
<table width="100%" cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="50px">
		<td colspan="14" align="center" style="border:none;"><font size="4"><b>POSITION WISE PRE ADVICE CONTAINER</b></font></td>
		
	</tr>
<table/>
<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
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
	select gkey,cont_id,rotation,cont_status,cont_mlo,cont_size,cont_height,agent,transOp,last_update,
	(select sparcsn4.vsl_vessels.name from sparcsn4.vsl_vessel_visit_details
	inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
	where sparcsn4.vsl_vessel_visit_details.vvd_gkey=mis_exp_unit_preadv_req.vvd_gkey) as vsl_name,
	
	(select last_pos_name from sparcsn4.inv_unit_fcy_visit
	inner join sparcsn4.inv_unit on sparcsn4.inv_unit.gkey=sparcsn4.inv_unit_fcy_visit.unit_gkey
	 where sparcsn4.inv_unit.category='EXPRT' and  sparcsn4.inv_unit.id=ctmsmis.mis_exp_unit_preadv_req.cont_id order by sparcsn4.inv_unit.gkey desc  limit 1) as last_pos_name,
	 
	 (select sparcsn4.inv_unit_fcy_visit.transit_state from sparcsn4.inv_unit_fcy_visit
	inner join sparcsn4.inv_unit on sparcsn4.inv_unit.gkey=sparcsn4.inv_unit_fcy_visit.unit_gkey
	 where sparcsn4.inv_unit.category='EXPRT' and  sparcsn4.inv_unit.id=ctmsmis.mis_exp_unit_preadv_req.cont_id order by sparcsn4.inv_unit.gkey desc  limit 1) as transit_state
	 
	from ctmsmis.mis_exp_unit_preadv_req where cont_id='$container_no' order by last_update desc limit 1
	)as tmp where transit_state='S20_INBOUND'");					

	//echo $positon;
	$i=0;
	$j=0;	
	//$transit_state="";
	while($row=mysql_fetch_object($query)){
	
	
		
				
		$strTrans = "select sparcsn4.inv_unit_fcy_visit.transit_state from sparcsn4.inv_unit 
		inner join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
		where sparcsn4.inv_unit.id='$row->cont_id' order by sparcsn4.inv_unit_fcy_visit.gkey";
		
		$resTrans = mysql_query($strTrans);
		$Trans="";
		
		while($rowTrans = mysql_fetch_object($resTrans))
		{
			$Trans=$rowTrans->transit_state;
		}			
		
		$i++;
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
		<td><?php if($row->last_pos_name) echo $row->last_pos_name; else echo "&nbsp;";?></td>
</tr>

		<?php 
		
		}
		//$login_id = $this->session->userdata('login_id')
		//$login_id_trans=="";
		  function Offdock($login_id)
			{
				if($login_id=='gclt')
				{
					return "GCL";
				}
				elseif($login_id=='saplw')
				{
					return "SAPE";
				}
				elseif($login_id=='ebil')
				{
					return "EBIL";
				}
				elseif($login_id=='cctcl')
				{
					return "CL";
				}
				elseif($login_id=='ktlt')
				{
					return "KTL";
				}
				elseif($login_id=='qnsc')
				{
					return "QNSC";
				}
				elseif($login_id=='ocl')
				{
					return "OCCL";
				}
				elseif($login_id=='vlsl')
				{
					return "VLSL";
				}
				elseif($login_id=='shml')
				{
					return "SHML";
				}
				elseif($login_id=='iqen')
				{
					return "IE";
				}
				elseif($login_id=='iltd')
				{
					return "IL";
				}
				
				elseif($login_id=='plcl')
				{
					return "PLCL";
				}
				elseif($login_id=='shpm')
				{
					return "SHPM";
				}
				elseif($login_id=='hsat')
				{
					return "HSAT";
				}
				elseif($login_id=='ellt')
				{
					return "ELL";
				}
				elseif($login_id=='bmcd')
				{
					return "BM";
				}
				elseif($login_id=='nclt')
				{
					return "NCL";
				}
				
				else
				{
					return "";
				}
				
			}
 mysql_close($con_sparcsn4);
 ?>


</table>
