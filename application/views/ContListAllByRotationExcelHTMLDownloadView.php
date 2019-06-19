<?php if($_POST['options']=='html'){?>
<HTML>
	<!--HEAD>
		<TITLE>Container detail by Rotation</TITLE>
		<LINK href="../css/report.css" type=text/css rel=stylesheet>
	    <style type="text/css">
<!--
.style1 {font-size: 12px}    // comment section

        </style>
    </HEAD>
	-->
<BODY>

	<?php } 
	else if($_POST['options']=='xl'){
		$rota=str_replace('/', '-', $rot);
		
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=Container-List-$rota-ALL.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
       //$rot=$_REQUEST['rot']; 	
	?>

	
	<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<?php 
	if($_POST['options']=='html'){?>
	<!--tr bgcolor="#273076" height="100px"-->
	<tr>
		<td colspan="13" align="center"><img width="250px" height="80px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
	</tr>
	<?php } ?>
	<tr bgcolor="#ffffff" align="center" height="50px">
		<td colspan="2" align="center"><font size="5"><b><?php echo $containerStatus;?></b></font></td>
		<td colspan="11" align="center"><font size="5"><b><?php echo $title;?></b></font></td>
	</tr>
	<!--tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr-->
	
	<tr bgcolor="#A9A9A9" align="center" height="25px">
		<td style="border-width:3px;border-style: double;"><b>SL.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Rotation</b></td>
		<td style="border-width:3px;border-style: double;"><b>Vessel Name</b></td>
		<td style="border-width:3px;border-style: double;"><b>Container</b></td>
		<td style="border-width:3px;border-style: double;"><b>Size</b></td>
		<td style="border-width:3px;border-style: double;"><b>Height</b></td>
		<td style="border-width:3px;border-style: double;"><b>Status</b></td>
		<td style="border-width:3px;border-style: double;"><b>Destination</b></td>
		<td style="border-width:3px;border-style: double;"><b>ISO Type</b></td>
		<td style="border-width:3px;border-style: double;"><b>ISO Group</b></td>				
		<td style="border-width:3px;border-style: double;"><b>Description</b></td>
		<td style="border-width:3px;border-style: double;"><b>Vessel Position</b></td>
		<td style="border-width:3px;border-style: double;"><b>Position</b></td>
	</tr>

<?php
	include("dbConection.php");
			$str = "SELECT sparcsn4.vsl_vessel_visit_details.ib_vyg,sparcsn4.inv_unit.id,
		(SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.inv_unit_equip
		INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
		INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
		WHERE sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey) AS size,
		(SELECT RIGHT(sparcsn4.ref_equip_type.nominal_height,2) FROM sparcsn4.inv_unit_equip
		INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
		INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
		WHERE sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey)/10 AS height,
		sparcsn4.inv_unit.freight_kind,sparcsn4.vsl_vessels.name as vessel_name,
		sparcsn4.inv_unit_fcy_visit.last_pos_name,sparcsn4.inv_unit_fcy_visit.last_pos_slot,sparcsn4.ref_equip_type.id as iso_type,
		sparcsn4.ref_equip_type.iso_group,sparcsn4.ref_equip_type.description,
		sparcsn4.inv_goods.destination
		FROM sparcsn4.vsl_vessel_visit_details
		INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
		INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.actual_ib_cv=sparcsn4.argo_carrier_visit.gkey
		INNER JOIN sparcsn4.inv_unit ON sparcsn4.inv_unit.gkey=sparcsn4.inv_unit_fcy_visit.unit_gkey
		INNER JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
		inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
		inner join sparcsn4.inv_unit_equip on sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
		inner join sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
		inner join sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
		inner join sparcsn4.ref_bizunit_scoped on sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.inv_unit.line_op
		WHERE sparcsn4.vsl_vessel_visit_details.ib_vyg='$rot' and sparcsn4.ref_bizunit_scoped.id='PIL' order by 2";
	$query=mysql_query($str);					

	//echo $positon;
	$i=0;
	$j=0;	
	//$transit_state="";
	while($row=mysql_fetch_object($query)){
	$i++;
?>
<tr align="center">

		<td><?php echo $i?></td>
		<td><?php if($row->ib_vyg) echo $row->ib_vyg; else echo "&nbsp;";?></td>
		<td><?php if($row->vessel_name) echo $row->vessel_name; else echo "&nbsp;";?></td>
		<td><?php if($row->id) echo $row->id; else echo "&nbsp;";?></td>
		<td><?php if($row->size) echo $row->size; else echo "&nbsp;";?></td>
		<td><?php if($row->height) echo $row->height; else echo "&nbsp;";?></td>
		<td><?php if($row->freight_kind) echo $row->freight_kind; else echo "&nbsp;";?></td>
		<td><?php if($row->destination) echo $row->destination; else echo "&nbsp;";?></td>
		<td><?php if($row->iso_type) echo $row->iso_type; else echo "&nbsp;";?></td>
		<td><?php if($row->iso_group) echo $row->iso_group; else echo "&nbsp;";?></td>
		<td><?php if($row->description) echo $row->description; else echo "&nbsp;";?></td>		
		<td><?php if($row->last_pos_name) echo $row->last_pos_name; else echo "&nbsp;";?></td>
		<td><?php if($row->last_pos_slot) echo $row->last_pos_slot; else echo "&nbsp;";?></td>
		
		
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




<br />
<br />




<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
