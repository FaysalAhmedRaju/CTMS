<?php if($_POST['options']=='html'){?>
<HTML>

<BODY>

	<?php } 
	else if($_POST['options']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=Vessel-List-$fromDt-TO-$toDt-Comments.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
       //$rot=$_REQUEST['rot']; 	
	?>

	
	<table align="center" width="80%" border ='0' cellpadding='0' cellspacing='0'>
	<?php 
	if($_POST['options']=='html'){?>
	<tr  height="100px">
		<td align="center" valign="middle" colspan="14" >
			<img align="middle"  src="<?php echo IMG_PATH?>cpanew.jpg">
		</td>
	</tr>
	<?php } ?>
	<tr bgcolor="#ffffff" align="center" height="50px">
		<td colspan="14" align="center"><font size="5"><b><?php echo $title;?></b></font></td>
	</tr>
	<!--tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr-->
	</table>
	<table align="center" width="80%" border ='1' cellpadding='0' cellspacing='0'>
	<tr bgcolor="#A9A9A9" align="center" height="25px">
		<td style="border-width:3px;border-style: double;"><b>SL.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Vessel Name</b></td>
		<td style="border-width:3px;border-style: double;"><b>Import Rotation</b></td>
		<td style="border-width:3px;border-style: double;"><b>Export Rotation</b></td>
		<td style="border-width:3px;border-style: double;"><b>Agent</b></td>
		<td style="border-width:3px;border-style: double;"><b>Berth Operator</b></td>
		<td style="border-width:3px;border-style: double;"><b>Status</b></td>
		<td style="border-width:3px;border-style: double;"><b>ETA</b></td>
		<td style="border-width:3px;border-style: double;"><b>ETD</b></td>
		<td style="border-width:3px;border-style: double;"><b>ATA</b></td>
		<td style="border-width:3px;border-style: double;"><b>ATD</b></td>
		<td style="border-width:3px;border-style: double;"><b>Status</b></td>
		<td style="border-width:3px;border-style: double;"><b>Status Time</b></td>
		<td style="border-width:3px;border-style: double;"><b>Comments</b></td>
		<td style="border-width:3px;border-style: double;"><b>Comments By</b></td>
		<td style="border-width:3px;border-style: double;"><b>Comments Time</b></td>
			
	</tr>

<?php
	include("dbConection.php");
			$str="SELECT sparcsn4.vsl_vessel_visit_details.vvd_gkey,sparcsn4.vsl_vessels.name,sparcsn4.vsl_vessel_visit_details.ib_vyg,sparcsn4.vsl_vessel_visit_details.ob_vyg,
					LEFT(sparcsn4.argo_carrier_visit.phase,2) AS phase_num,SUBSTR(sparcsn4.argo_carrier_visit.phase,3) AS phase_str,sparcsn4.argo_visit_details.eta,sparcsn4.argo_visit_details.etd,sparcsn4.argo_carrier_visit.ata,sparcsn4.argo_carrier_visit.atd,ctmsmis.mis_exp_vvd.comments,ctmsmis.mis_exp_vvd.comments_by,ctmsmis.mis_exp_vvd.comments_time,ctmsmis.mis_exp_vvd.pre_comments,ctmsmis.mis_exp_vvd.pre_comments_time,
					sparcsn4.ref_bizunit_scoped.id AS agent,
					IFNULL(sparcsn4.vsl_vessel_visit_details.flex_string02,sparcsn4.vsl_vessel_visit_details.flex_string03) AS berthop
					FROM sparcsn4.argo_carrier_visit
					INNER JOIN sparcsn4.argo_visit_details ON sparcsn4.argo_visit_details.gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
					INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_visit_details.gkey
					INNER JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
					INNER JOIN ctmsmis.mis_exp_vvd ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=ctmsmis.mis_exp_vvd.vvd_gkey
					INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.vsl_vessel_visit_details.bizu_gkey
					WHERE DATE(ctmsmis.mis_exp_vvd.comments_time) BETWEEN '$fromDt' and '$toDt'
					ORDER BY ctmsmis.mis_exp_vvd.comments_time desc";
	//echo $str;
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
		<td><?php if($row->name) echo $row->name; else echo "&nbsp;";?></td>
		<td><?php if($row->ib_vyg) echo $row->ib_vyg; else echo "&nbsp;";?></td>
		<td><?php if($row->ob_vyg) echo $row->ob_vyg; else echo "&nbsp;";?></td>
		<td><?php if($row->agent) echo $row->agent; else echo "&nbsp;";?></td>
		<td><?php if($row->berthop) echo $row->berthop; else echo "&nbsp;";?></td>
		<td><?php if($row->phase_str) echo $row->phase_str; else echo "&nbsp;";?></td>
		<td><?php if($row->eta) echo $row->eta; else echo "&nbsp;";?></td>
		<td><?php if($row->etd) echo $row->etd; else echo "&nbsp;";?></td>
		<td><?php if($row->ata) echo $row->ata; else echo "&nbsp;";?></td>
		<td><?php if($row->atd) echo $row->atd; else echo "&nbsp;";?></td>
		<td><?php if($row->comments) echo $row->comments; else echo "&nbsp;";?></td>
		<td><?php if($row->comments_time) echo $row->comments_time; else echo "&nbsp;";?></td>
		<td><?php if($row->pre_comments) echo $row->pre_comments; else echo "&nbsp;";?></td>
		<td><?php if($row->comments_by) echo $row->comments_by; else echo "&nbsp;";?></td>
		<td><?php if($row->pre_comments_time) echo $row->pre_comments_time; else echo "&nbsp;";?></td>
		
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
