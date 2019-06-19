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
			<h4><font color="black">SUMMARY REPORT</font></h1>
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
	<table align="center" width="70%" border="1" cellpadding="0" cellspacing="0" style=" border-collapse: collapse;">
	<tr align="center" >
		<th style="border-width:2px;"><b>NATURE OF BILL</b></th>
		<th style="border-width:2px;"><b>TOTAL BILL</b></th>
		<th style="border-width:2px;"><b>TOTAL PORT CHARGE</b></th>
		<th style="border-width:2px;"><b>TOTAL PORT CHARGE(90%)</b></th>
		<th style="border-width:2px;"><b>INCOME TAX ON PORT CHARGE(10%)</b></th>
		<th style="border-width:2px;"><b>TOTAL VAT</b></th>	
		<th style="border-width:2px;"><b>TOTAL MLWF</b></th>	
		<th style="border-width:2px;"><b>TOTAL TAKA</b></th>	
		<th style="border-width:2px;"><b>REMARKS</b></th>	
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
	$str="SELECT unit_no,count(distinct(shed_bill_details.bill_no))as ttlBill,SUM(amt) as amtTtl,(SUM(amt)*0.90) as portCharge,
			(SUM(amt)*0.10) as taxCharge,SUM(vatTK) as vatTKTtl,
			SUM(mlwfTK) as mlwfTKTtl,(SUM(amt)+SUM(vatTK)+SUM(mlwfTK)) as TotalTKTtl FROM shed_bill_master
			left JOIN shed_bill_details ON shed_bill_master.bill_no = shed_bill_details.bill_no
			WHERE  bill_date between '$from_dt' and '$to_dt'
			group by unit_no";
	$query=mysql_query($str);					

	//echo $str;
	$i=0;
	$j=0;	
	//$transit_state="";
	while($row=mysql_fetch_object($query)){
	$i++;
	?>
	<tr align="center">
		<td><?php if($row->unit_no) echo $row->unit_no; else echo "&nbsp;";?></td>
		<td><?php if($row->ttlBill) echo $row->ttlBill; else echo "&nbsp;";?></td>
		<td><?php if($row->amtTtl) echo $row->amtTtl; else echo "&nbsp;";?></td>
		<td><?php if($row->portCharge) echo $row->portCharge; else echo "&nbsp;";?></td>
		<td><?php if($row->taxCharge) echo $row->taxCharge; else echo "&nbsp;";?></td>
		<td><?php if($row->vatTKTtl) echo $row->vatTKTtl; else echo "&nbsp;";?></td>
		<td><?php if($row->mlwfTKTtl) echo $row->mlwfTKTtl; else echo "&nbsp;";?></td>
		<td><?php if($row->TotalTKTtl) echo $row->TotalTKTtl; else echo "&nbsp;";?></td>
		<td><?php echo "&nbsp;";?></td>
	</tr>
	
		<?php 
	
		}
		?>
	
		<?php
			$str_tot_query="SELECT count(distinct(shed_bill_details.bill_no))as ttlBill,SUM(amt) as amtTtl,(SUM(amt)*0.90) as portCharge,
							(SUM(amt)*0.10) as taxCharge,SUM(vatTK) as vatTKTtl,
							SUM(mlwfTK) as mlwfTKTtl,(SUM(amt)+SUM(vatTK)+SUM(mlwfTK)) as TotalTKTtl FROM shed_bill_master
							left JOIN shed_bill_details ON shed_bill_master.bill_no = shed_bill_details.bill_no
							WHERE  bill_date between '$from_dt' and '$to_dt'";
			//echo $str_tot_query;
			$rslt_tot=mysql_query($str_tot_query);
			//$rtn_tot=mysql_fetch_object($rslt_tot);
			while($row_tot=mysql_fetch_object($rslt_tot)){
	//$j++;	
		?>
		
		<tr align="center">	
			<td>GRAND TOTAL</td>
			<td><?php if($row_tot->ttlBill) echo $row_tot->ttlBill; else echo "&nbsp;";?></td>
			<td><?php if($row_tot->amtTtl) echo $row_tot->amtTtl; else echo "&nbsp;";?></td>
			<td><?php if($row_tot->portCharge) echo $row_tot->portCharge; else echo "&nbsp;";?></td>
			<td><?php if($row_tot->taxCharge) echo $row_tot->taxCharge; else echo "&nbsp;";?></td>
			<td><?php if($row_tot->vatTKTtl) echo $row_tot->vatTKTtl; else echo "&nbsp;";?></td>
			<td><?php if($row_tot->mlwfTKTtl) echo $row_tot->mlwfTKTtl; else echo "&nbsp;";?></td>
			<td><?php if($row_tot->TotalTKTtl) echo $row_tot->TotalTKTtl; else echo "&nbsp;";?></td>
			<td><?php echo "&nbsp;";?></td>
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
<div align="center">

	AUTHORISED SIGNATURE

</div>




<?php 
mysql_close($con_cchaportdb);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
