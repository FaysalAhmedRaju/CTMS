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
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=CONTAINER_DETAILS_BY_ROTATION.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}
       //$rot=$_REQUEST['rot']; 	
	?>

	
	<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<!--tr bgcolor="#273076" height="100px">
		<td align="center" valign="middle" colspan="14" >
			<h1><font color="white">Chittagong Port Authority</font></h1>
		</td>
	</tr-->
	<tr>
		<td colspan="14" align="center"><img width="250px" height="80px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
	</tr>
	<tr bgcolor="#ffffff" align="center" height="50px">
		<td colspan="14" align="center"><font size="5"><b><?php echo $title;?></b></font></td>
	</tr>
	<!--tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr-->
	
	<tr bgcolor="#A9A9A9" align="center" height="25px">
		<td style="border-width:3px;border-style: double;"><b>SL.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Container</b></td>
		<td style="border-width:3px;border-style: double;"><b>Size</b></td>
		<td style="border-width:3px;border-style: double;"><b>Height</b></td>
		<td style="border-width:3px;border-style: double;"><b>Discharge Time</b></td>
		<td style="border-width:3px;border-style: double;"><b>Delivery/ Getout Time</b></td>
		<td style="border-width:3px;border-style: double;"><b>Last Position</b></td>
		<td style="border-width:3px;border-style: double;"><b>Yard</b></td>
		<td style="border-width:3px;border-style: double;"><b>Block</b></td>
		<td style="border-width:3px;border-style: double;"><b>Destination</b></td>
		<td style="border-width:3px;border-style: double;"><b>Off Dock Name</b></td>
		<td style="border-width:3px;border-style: double;"><b>Assignment Type</b></td>
		<td style="border-width:3px;border-style: double;"><b>Assignment Date</b></td>
		<td style="border-width:3px;border-style: double;"><b>View In Map</b></td>
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
		sparcsn4.inv_unit_fcy_visit.time_in,sparcsn4.inv_unit_fcy_visit.time_out,
		sparcsn4.inv_unit_fcy_visit.last_pos_name,
		(SELECT ctmsmis.cont_yard(sparcsn4.inv_unit_fcy_visit.last_pos_slot)) AS yard,
		(SELECT ctmsmis.cont_block(sparcsn4.inv_unit_fcy_visit.last_pos_slot,yard)) AS block,
		sparcsn4.inv_goods.destination,
		(SELECT ctmsmis.offdoc.name FROM ctmsmis.offdoc WHERE id=sparcsn4.inv_goods.destination) AS ofdocName,
		config_metafield_lov.mfdch_desc,
		sparcsn4.inv_unit_fcy_visit.flex_date01
		FROM sparcsn4.vsl_vessel_visit_details
		INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
		INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.actual_ib_cv=sparcsn4.argo_carrier_visit.gkey
		INNER JOIN sparcsn4.inv_unit ON sparcsn4.inv_unit.gkey=sparcsn4.inv_unit_fcy_visit.unit_gkey
		inner join sparcsn4.ref_bizunit_scoped on sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.inv_unit.line_op
		LEFT JOIN sparcsn4.config_metafield_lov ON sparcsn4.inv_unit.flex_string01=config_metafield_lov.mfdch_value
		INNER JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
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
		<td><?php if($row->id) echo $row->id; else echo "&nbsp;";?></td>
		<td><?php if($row->size) echo $row->size; else echo "&nbsp;";?></td>
		<td><?php if($row->height) echo $row->height; else echo "&nbsp;";?></td>
		<td><?php if($row->time_in) echo $row->time_in; else echo "&nbsp;";?></td>
		<td><?php if($row->time_out) echo $row->time_out; else echo "&nbsp;";?></td>
		<td><?php if($row->last_pos_name) echo $row->last_pos_name; else echo "&nbsp;";?></td>
		<td><?php if($row->yard) echo $row->yard; else echo "&nbsp;";?></td>
		<td><?php if($row->block) echo $row->block; else echo "&nbsp;";?></td>
		<td><?php if($row->destination) echo $row->destination; else echo "&nbsp;";?></td>
		<td><?php if($row->ofdocName) echo $row->ofdocName; else echo "&nbsp;";?></td>
		<td><?php if($row->mfdch_desc) echo $row->mfdch_desc; else echo "&nbsp;";?></td>
		<td><?php if($row->flex_date01) echo $row->flex_date01; else echo "&nbsp;";?></td>
		<td><a href="<?php echo site_url('report/mySearchContainerLocation/'.$row->id)?>" target="_blank">View</a></td>
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
