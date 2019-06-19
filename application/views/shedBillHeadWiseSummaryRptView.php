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
		header("Content-Disposition: attachment; filename=Container-List-$rota-Stripping.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
       //$rot=$_REQUEST['rot']; 	
	?>

	
	<table align="center" width="70%" cellpadding='0' cellspacing='0'>
	<?php 
	if($_POST['options']=='html'){?>
	<tr bgcolor="" >
		<td align="center" valign="middle" colspan="7" >
			<h3><font color="black">CHITTAGONG PORT AUTHORITY</font></h1>
		</td>
	</tr>
	<tr bgcolor="" >
		<td align="center" valign="middle" colspan="7" >
			<h4><font color="black">HEADWISE SUMMARY FOR SHED BILL</font></h1>
		</td>
	</tr>
	<?php } ?>
	<tr bgcolor="#ffffff" align="center" height="50px">
		
		<td colspan="7" align="center"><font size="3"><b><?php echo $title;?></b></font></td>
	</tr>
	</table>
	<!--tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr-->
	<table align="center" width="70%" border ='1' cellpadding='0' cellspacing='0'>
	<tr bgcolor="" align="center" height="25px">
		<td style="border-width:3px;border-style: double;"><b>CODE</b></td>
		<td style="border-width:3px;border-style: double;"><b>DESCRIPTION</b></td>
		<td style="border-width:3px;border-style: double;"><b>PORT (TK)</b></td>
		<td style="border-width:3px;border-style: double;"><b>VAT (TK)</b></td>
		<td style="border-width:3px;border-style: double;"><b>MLWF (TK)</b></td>
		<td style="border-width:3px;border-style: double;"><b>TOTAL (TK)</b></td>	
	</tr>

<?php
	include("mydbPConnection.php");
			/*$str = "SELECT ib_vyg,id,time_out,
					(SELECT sparcsn4.inv_unit_fcy_visit.last_pos_name 
					FROM sparcsn4.inv_unit
					INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
					WHERE sparcsn4.inv_unit.id=tbl.id AND sparcsn4.inv_unit.category='STRGE' AND sparcsn4.inv_unit_fcy_visit.transit_state='S40_YARD') AS last_pos_name,
					(SELECT sparcsn4.inv_unit_fcy_visit.last_pos_slot 
					FROM sparcsn4.inv_unit
					INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
					WHERE sparcsn4.inv_unit.id=tbl.id AND sparcsn4.inv_unit.category='STRGE' AND sparcsn4.inv_unit_fcy_visit.transit_state='S40_YARD') AS last_pos_slot
					 FROM 
					   (
					  SELECT  sparcsn4.vsl_vessel_visit_details.ib_vyg,sparcsn4.inv_unit.id,sparcsn4.inv_unit_fcy_visit.time_out,
					  (SELECT COUNT(*) FROM sparcsn4.srv_event WHERE applied_to_gkey=sparcsn4.inv_unit.gkey AND event_type_gkey=30) AS strip_evt
					  FROM sparcsn4.vsl_vessel_visit_details
					  INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
					  INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.actual_ib_cv=sparcsn4.argo_carrier_visit.gkey
					  INNER JOIN sparcsn4.inv_unit ON sparcsn4.inv_unit.gkey=sparcsn4.inv_unit_fcy_visit.unit_gkey 
					  INNER JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
					  inner join sparcsn4.ref_bizunit_scoped on sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.inv_unit.line_op
					  WHERE sparcsn4.vsl_vessel_visit_details.ib_vyg='$rot' 
					  AND sparcsn4.inv_unit_fcy_visit.time_out IS NOT NULL and sparcsn4.ref_bizunit_scoped.id='PIL' ORDER BY 2
						 ) AS tbl WHERE strip_evt>0";
			*/
	$str="SELECT gl_code,description,amt,vatTK,mlwfTK,(amt+vatTK+mlwfTK) as TotalTK FROM shed_bill_master
			INNER JOIN shed_bill_details ON shed_bill_master.bill_no = shed_bill_details.bill_no
			WHERE  shed_bill_master.unit_no='$unitNo' and bill_date between '$from_dt' and '$to_dt'";
		//	echo $str;
	$query=mysql_query($str);					

	//echo $str;
	$i=0;
	$j=0;	
	//$transit_state="";
	while($row=mysql_fetch_object($query)){
	$i++;
	?>
	<tr align="center">
		<td><?php if($row->gl_code) echo $row->gl_code; else echo "&nbsp;";?></td>
		<td><?php if($row->description) echo $row->description; else echo "&nbsp;";?></td>
		<td><?php if($row->amt) echo $row->amt; else echo "&nbsp;";?></td>
		<td><?php if($row->vatTK) echo $row->vatTK; else echo "&nbsp;";?></td>
		<td><?php if($row->mlwfTK) echo $row->mlwfTK; else echo "&nbsp;";?></td>
		<td><?php if($row->TotalTK) echo $row->TotalTK; else echo "&nbsp;";?></td>
	</tr>
	
		<?php 
	
		}
		?>
	
		<?php
			$str_tot_query="SELECT SUM(amt) as amtTtl,SUM(vatTK) as vatTKTtl,SUM(mlwfTK) as mlwfTKTtl,(SUM(amt)+SUM(vatTK)+SUM(mlwfTK)) as TotalTKTtl FROM shed_bill_master
								INNER JOIN shed_bill_details ON shed_bill_master.bill_no = shed_bill_details.bill_no
								WHERE  shed_bill_master.unit_no='$unitNo' and bill_date between '$from_dt' and '$to_dt'";
			//echo $str_tot_query;
			$rslt_tot=mysql_query($str_tot_query);
			//$rtn_tot=mysql_fetch_object($rslt_tot);
			while($row_tot=mysql_fetch_object($rslt_tot)){
	//$j++;	
		?>
		
		<tr align="center">			
			<td align="center" colspan=2><b>BILL TOTAL :</b> </td>
			<td><?php if($row_tot->amtTtl) echo $row_tot->amtTtl; else echo "&nbsp;";?></td>
			<td><?php if($row_tot->vatTKTtl) echo $row_tot->vatTKTtl; else echo "&nbsp;";?></td>
			<td><?php if($row_tot->mlwfTKTtl) echo $row_tot->mlwfTKTtl; else echo "&nbsp;";?></td>
			<td><?php if($row_tot->TotalTKTtl) echo $row_tot->TotalTKTtl; else echo "&nbsp;";?></td>
		</tr>
			<?php }?>
		
		<?php 
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
 mysql_close($con_cchaportdb);
 ?>


</table>
<br />
<br />

<div style="width:80%" align="right"> 
	COMPUTER INCHARGE
</div>
<div style="width:80%" align="right"> 
	COMPUTER CENTER UNIT NO : <?php echo $unitNo;?>
</div>
<div style="width:80%" align="right"> 
	CPA
</div>





<?php 
mysql_close($con_cchaportdb);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
