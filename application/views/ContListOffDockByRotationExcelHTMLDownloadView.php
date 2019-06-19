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
		header("Content-Disposition: attachment; filename=Container-List-$rota-Offdock.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
       //$rot=$_REQUEST['rot']; 	
	?>

	
	<table align="center" width="70%" border ='1' cellpadding='0' cellspacing='0'>
	<?php 
	if($_POST['options']=='html'){?>
	<!--tr bgcolor="#273076" height="100px">
		<td align="center" valign="middle" colspan="14" >
			<h1><font color="white">Chittagong Port Authority</font></h1>
		</td>
	</tr-->
	<tr>
		<td colspan="14" align="center"><img width="250px" height="80px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
	</tr>
	<?php } ?>
	<tr bgcolor="#ffffff" align="center" height="50px">
		<td colspan="1" align="center"><font size="3"><b><?php echo $containerStatus;?></b></font></td>
		<td colspan="3" align="center"><font size="5"><b><?php echo $title;?></b></font></td>
	</tr>
	<!--tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr-->
	
	<tr bgcolor="#A9A9A9" align="center" height="25px">
		<td style="border-width:3px;border-style: double;"><b>SL.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Rotation</b></td>
		<td style="border-width:3px;border-style: double;"><b>Container</b></td>
		<td style="border-width:3px;border-style: double;"><b>Delivery Date</b></td>
				
	</tr>

<?php
	include("dbConection.php");
			$str = "select ib_vyg,id,time_out from 
					(
					SELECT 	sparcsn4.vsl_vessel_visit_details.ib_vyg,sparcsn4.inv_unit.id,sparcsn4.inv_unit_fcy_visit.time_out,
					(select count(*) from sparcsn4.srv_event where applied_to_gkey=sparcsn4.inv_unit.gkey and event_type_gkey=30) as strip_evt
						FROM sparcsn4.vsl_vessel_visit_details
						INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
						INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.actual_ib_cv=sparcsn4.argo_carrier_visit.gkey
						INNER JOIN sparcsn4.inv_unit ON sparcsn4.inv_unit.gkey=sparcsn4.inv_unit_fcy_visit.unit_gkey
						INNER JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
						inner join sparcsn4.ref_bizunit_scoped on sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.inv_unit.line_op
						WHERE sparcsn4.inv_unit_fcy_visit.time_out BETWEEN '$off_date_from' and '$off_date_to' and 
						sparcsn4.inv_unit_fcy_visit.time_out is not null and sparcsn4.ref_bizunit_scoped.id='PIL' order by 2
						) as tbl where strip_evt=0";
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
		<td><?php if($row->id) echo $row->id; else echo "&nbsp;";?></td>
		<td><?php if($row->time_out) echo $row->time_out; else echo "&nbsp;";?></td>
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
