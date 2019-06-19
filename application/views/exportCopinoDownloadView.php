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
		header("Content-Disposition: attachment; filename=Export-Copino-$rota.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
       //$rot=$_REQUEST['rot']; 	
	?>

	
	<table align="center" width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<?php include("dbConection.php");?>
	<?php 
	if($_POST['options']=='html'){
	?>
	<!--tr bgcolor="#273076" height="100px">
		<td align="center" valign="middle" colspan="15" >
			<h1><font color="white">Chittagong Port Authority</font></h1>
		</td>
	</tr-->
	<tr>
		<td colspan="15" align="center"><img width="250px" height="80px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
	</tr>
	<?php } ?>
	<?php $str = "select name from sparcsn4.vsl_vessels inner join
					sparcsn4.vsl_vessel_visit_details on
					sparcsn4.vsl_vessel_visit_details.vessel_gkey=sparcsn4.vsl_vessels.gkey
					where sparcsn4.vsl_vessel_visit_details.ib_vyg='$rot'";
			//echo $str;
	$query=mysql_query($str);
	while($row=mysql_fetch_object($query)){
	?>
	<tr>
		<td colspan="1" align="center"></td>
		<td colspan="1" align="center"></td>
		<td colspan="1" align="center"><b>Export Copino</b></td>
	</tr>
	<tr>
		<td colspan="1" align="center"></td>
		<td colspan="1" align="center"></td>
		<td colspan="1" align="center"><font size="3"><b>Rotation</b></font></td>
		<td colspan="1" align="center"><font size="3"><b><?php echo $rot;?></b></font></td>
		<td colspan="1" align="center"><font size="3"><b>Vessel</b></font></td>
		<td colspan="1" align="center"><font size="3"><b><?php if($row->name) echo $row->name; else echo "&nbsp;";?></b></font></td>
	</tr>
	<tr>
	</tr>
	<?php
	}
	?>
	<!--tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr-->
	
	<tr bgcolor="#A9A9A9" align="center" height="25px">
		<td style="border-width:3px;border-style: double;"><b>SL.</b></td>
		<td style="border-width:3px;border-style: double;"><b>ContainerNo.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Size</b></td>
		<td style="border-width:3px;border-style: double;"><b>Height</b></td>
		<td style="border-width:3px;border-style: double;"><b>ISO Code</b></td>
		<td style="border-width:3px;border-style: double;"><b>MLO Code</b></td>
		<td style="border-width:3px;border-style: double;"><b>Status</b></td>		
		<td style="border-width:3px;border-style: double;"><b>Weight</b></td>
		<td style="border-width:3px;border-style: double;"><b>SealNo.</b></td>		
		<td style="border-width:3px;border-style: double;"><b>ComingFrom</b></td>
		<td style="border-width:3px;border-style: double;"><b>POD</b></td>
		<td style="border-width:3px;border-style: double;"><b>PermissionNo.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Commmodity</b></td>
		<td style="border-width:3px;border-style: double;"><b>POL</b></td>
		<td style="border-width:3px;border-style: double;"><b>Remarks</b></td>
		
	</tr>

<?php
	
			$str = "select cont_id,cont_size,cont_height,isoType,cont_mlo,cont_status,goods_and_ctr_wt_kg,seal_no 
					from ctmsmis.mis_exp_unit_preadv_req where rotation='$rot' order by 1";
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
		<td><?php if($row->cont_id) echo $row->cont_id; else echo "&nbsp;";?></td>	
		<td><?php if($row->cont_size) echo $row->cont_size; else echo "&nbsp;";?></td>	
		<td><?php if($row->cont_height) echo $row->cont_height; else echo "&nbsp;";?></td>
		<td><?php if($row->isoType) echo $row->isoType; else echo "&nbsp;";?></td>			
		<td><?php if($row->cont_mlo) echo $row->cont_mlo; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_status) echo $row->cont_status; else echo "&nbsp;";?></td>
		<td><?php if($row->goods_and_ctr_wt_kg) echo $row->goods_and_ctr_wt_kg; else echo "&nbsp;";?></td>
		<td><?php if($row->seal_no) echo $row->seal_no; else echo "&nbsp;";?></td>			
		<td><?php echo "&nbsp;";?></td>
		<td><?php echo "&nbsp;";?></td>
		<td><?php echo "&nbsp;";?></td>
		<td><?php echo "&nbsp;";?></td>
		<td><?php echo "&nbsp;";?></td>
		<td><?php echo "&nbsp;";?></td>
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
