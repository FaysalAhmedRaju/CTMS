<?php 
	if($_POST['option']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=CCT_NCT_EXCEL.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
	
	include("mydbPConnectionn4.php");		
	$assignType="";			
	$length=count($rsltNCTCCT);
	for($i=0;$i<$length;$i++)
	{ 		
		$mfdch_value = $rsltNCTCCT[$i]['mfdch_value'];
		$mfdch_desc = $rsltNCTCCT[$i]['mfdch_desc'];
?>
	
	<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
		<?php
		if($i!=0)
		{	 
		?>
		<tr>
			<td colspan="13">&nbsp;</td>
		</tr>
		<?php
		}
		?>
		<tr>
			<td colspan="13" align="center"><font size="5">CHITTAGONG PORT AUTHORITY</font></td>
		</tr>
		<tr>
			<td colspan="13" align="center">OFFICE OF THE TERMINAL MANAGER</td>
		</tr>
		<tr>
			<td colspan="13" align="center">DELIVERY REPORT OF <?php echo $terminal?></td>
		</tr>
		<tr>
			<td colspan="13" align="center">Date: <?php echo $date?></td>
			<!--td colspan="4">Printed: <?php echo date('d/m/Y h:i:s')?></td-->
		</tr>
		<tr>
			<td colspan="13"><b><?php echo "Assignment (Delivery): ".$mfdch_desc; ?></b></td>
		</tr>
		<!--tr>
			<td style="border:1px solid black" align="center" width="10px">SL</td>
			<td style="border:1px solid black" align="center" width="150px">C & F Agent</td>
			<td style="border:1px solid black" align="center" width="120px">Vessel Name</td>
			<td style="border:1px solid black" align="center" width="50px">Rot.No</td>
			<td style="border:1px solid black" align="center" width="50px">MLO</td>
			<td style="border:1px solid black" align="center"><font size="2">DLV(Y/N)</font></td>
			<td style="border:1px solid black" align="center" >Cont No.</td>
			<td style="border:1px solid black" align="center">Sz</td>
			<td style="border:1px solid black" align="center">Ht</td>
			<td style="border:1px solid black" align="center" width="50px">BL No.</td>
			<td style="border:1px solid black" align="center">From</td>
			<td style="border:1px solid black" align="center" width="50px">Remarks</td>
		</tr-->
		<tr>
			<td style="border:1px solid black" align="center">SL</td>
			<td style="border:1px solid black" align="center">C & F Agent</td>
			<td style="border:1px solid black" align="center">Vessel Name</td>
			<td style="border:1px solid black" align="center">Rot.No</td>
			<td style="border:1px solid black" align="center">MLO</td>
			<td style="border:1px solid black" align="center" width="50px">Seal No</td>
			<td style="border:1px solid black" align="center">DLV(Y/N)</td>
			<td style="border:1px solid black" align="center">Cont No.</td>
			<td style="border:1px solid black" align="center">Sz</td>
			<td style="border:1px solid black" align="center">Ht</td>
			<td style="border:1px solid black" align="center">BL No.</td>
			<td style="border:1px solid black" align="center">From</td>
			<td style="border:1px solid black" align="center">Remarks</td>
		</tr>
		<?php 
			$strAllData = "SELECT DISTINCT * FROM ctmsmis.tmp_assignment_type_new
			WHERE mfdch_value='$mfdch_value' and Yard_No='$terminal' ORDER BY Yard_No,mfdch_value,flex_date01,line_no";
			$resAllData = mysql_query($strAllData);
			$j=0;
			$cnf="";
			$bl="";
			$t20=0;
			$t40=0;
			$tot = 0;
			while($rowAllData = mysql_fetch_object($resAllData))
			{
				$tot++;
				if($cnf!=$rowAllData->cf or $bl!=$rowAllData->line_no)
				{
					$j = $j+1;
					$cnf=$rowAllData->cf;
					$bl=$rowAllData->line_no;
				}
					
				if($rowAllData->size==20)
					$t20 += 1;
				else
					$t40 += 1;
		?>
		<tr>
			<td align="center"><?php echo $j;?></td>
			<td><?php echo $rowAllData->cf; ?></td>
			<td><?php echo $rowAllData->v_name; ?></td>
			<td><?php echo $rowAllData->rot_no; ?></td>
			<td align="center"><?php echo $rowAllData->mlo; ?></td>
			<td align="center"><?php echo $rowAllData->seal_nbr1; ?></td>
			<?php
				$cont_no=$rowAllData->cont_no;
				$cont_no=str_replace("-","",$cont_no);
								
				$sqlYN="SELECT time_out FROM sparcsn4.inv_unit 
				INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
				WHERE sparcsn4.inv_unit.id='$cont_no' AND category='IMPRT'
				order by inv_unit.gkey desc limit 1";

				$resYN=mysql_query($sqlYN);
				$rowYN=mysql_fetch_object($resYN);
				$yn=$rowYN->time_out;
				if($yn!=null)
				{
			?>
			<td style="border:1px solid black; width:10px; background-color:#bbbaba;" align="center">Yes</td>
			<?php
				}
				else
				{
			?>
			<td style="border:1px solid black; width:10px;" align="center"></td>
			<?php
				}										
			?>			
			<td><?php echo $rowAllData->cont_no; ?></td>
			<td><?php echo $rowAllData->size; ?></td>
			<td><?php echo number_format($rowAllData->height,1); ?></td>
			<td align="center"><?php echo $rowAllData->line_no; ?></td>
			<td><?php echo $rowAllData->slot; ?></td>
			<td align="center"><?php echo $rowAllData->remarks; ?></td>
		</tr>
	
		<?php
			}	
			?>
			<tr>
				<td colspan="13">&nbsp;</td>
			</tr>
			<tr>
				<td>Total:</td>
				<td align="left"><?php echo $tot; ?></td>
				<td align="right">20 FT:</td>
				<td align="left"><?php echo $t20; ?></td>
				<td align="right">40 FT:</td>
				<td align="left"><?php echo $t40; ?></td>
				<td align="right">TEUS:</td>
				<td align="left"><?php echo $t20+$t40*2; ?></td>
			</tr>
		</table>
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
 ?>



