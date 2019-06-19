<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>Bearth Operator Report</TITLE>
		<LINK href="../css/report.css" type=text/css rel=stylesheet>
	    <style type="text/css">
<!--
.style1 {font-size: 12px}
-->
        </style>
</HEAD>
<BODY>

	<?php } 
	else if($_POST['options']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=IGM.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}
	$from=$_POST['ddl_imp_rot_no'];
		$mlo=$_POST['MLOCODE'];
		
	include("mydbPConnection.php");
//include_once("mydbClientconnect.php");


		//Vessel Name:
		$str_vessel="select Vessel_Name from igm_masters where Import_Rotation_No='$from'";
		$result_vessel=mysql_query($str_vessel);
		$row_vessel=mysql_fetch_object($result_vessel);

	
			if ($_POST['CStatus']=='Both' or $_POST['CStatus']=='' )
			{
			
					if($mlo=="All")
					{
						$str="select imco,un,igm_details.Pack_Number,igm_details.Pack_Description,(select Organization_Name from organization_profiles where organization_profiles.id=igm_detail_container.off_dock_id) as depu,igm_details.Pack_Marks_Number,igm_detail_container.id,igm_details.Import_Rotation_No,igm_details.Line_No,igm_details.BL_No,igm_details.Submitee_Org_Id,cont_number,cont_size,cont_weight,cont_seal_number,igm_details.Description_of_Goods as dg,cont_status,cont_height,cont_type,mlocode,cont_type,
						Cont_gross_weight,Organization_Name,commudity_desc,final_amendment,response_details1,
						firstapprovaltime,response_details2,secondapprovaltime,response_details3,thirdapprovaltime,hold_application,rejected_application,hold_date,rejected_date,'D' as type,master_Line_No
						from igm_details left join igm_detail_container on igm_details.id=igm_detail_container.igm_detail_id 
						left join commudity_detail on igm_detail_container.commudity_code=commudity_detail.commudity_code
						left join igm_navy_response on igm_details.id=igm_navy_response.igm_details_id
						inner join organization_profiles on igm_details.Submitee_Org_Id=organization_profiles.id  
						left join igm_supplimentary_detail on igm_details.id=igm_supplimentary_detail.igm_detail_id where igm_details.Import_Rotation_No Like'$from' 
						and igm_detail_container.port_status ='0' and igm_supplimentary_detail.id is null  and igm_details.final_submit=1
						union
						select igm_sup_detail_container.cont_imo,igm_sup_detail_container.cont_un,igm_supplimentary_detail.Pack_Number,igm_supplimentary_detail.Pack_Description,(select Organization_Name from organization_profiles where organization_profiles.id=igm_sup_detail_container.off_dock_id) as depu,igm_supplimentary_detail.Pack_Marks_Number,igm_sup_detail_container.id,igm_supplimentary_detail.Import_Rotation_No,igm_supplimentary_detail.Line_No,igm_supplimentary_detail.BL_No,igm_supplimentary_detail.Submitee_Org_Id,cont_number,cont_size,cont_weight,cont_seal_number,igm_supplimentary_detail.Description_of_Goods as dg,cont_status,cont_height,cont_type,0 as mlocode,cont_type,
						igm_supplimentary_detail.weight,Organization_Name,commudity_desc,final_amendment,response_details1,firstapprovaltime,response_details2,secondapprovaltime,response_details3,
						thirdapprovaltime,hold_application,rejected_application,hold_date,rejected_date,'S' as type,master_Line_No
						from igm_supplimentary_detail left join igm_sup_detail_container on igm_supplimentary_detail.id=igm_sup_detail_container.igm_sup_detail_id
						left join commudity_detail on igm_sup_detail_container.commudity_code=commudity_detail.commudity_code
						left join igm_navy_response on igm_supplimentary_detail.id=igm_navy_response.egm_details_id
						inner join organization_profiles on igm_supplimentary_detail.Submitee_Org_Id=organization_profiles.id  
						inner join igm_details on igm_details.id=igm_supplimentary_detail.igm_detail_id
						where igm_supplimentary_detail.Import_Rotation_No Like '$from' 
						and igm_sup_detail_container.port_status ='0'
						and igm_supplimentary_detail.final_submit=1 order by cont_number,Organization_Name";
					}
					else
					{	

						//print("BB");
						$str="select imco,un,igm_details.Pack_Number,igm_details.Pack_Description,(select Organization_Name from organization_profiles where organization_profiles.id=igm_detail_container.off_dock_id) as depu,igm_details.Pack_Marks_Number,igm_detail_container.id,igm_details.Import_Rotation_No,igm_details.Line_No,igm_details.BL_No,igm_details.Submitee_Org_Id,cont_number,cont_size,cont_weight,cont_seal_number,igm_details.Description_of_Goods as dg,cont_status,cont_height,cont_type,mlocode,cont_type,
						Cont_gross_weight,Organization_Name,commudity_desc,final_amendment,response_details1,
						firstapprovaltime,response_details2,secondapprovaltime,response_details3,thirdapprovaltime,hold_application,rejected_application,hold_date,rejected_date,'D' as type,master_Line_No
						from igm_details left join igm_detail_container on igm_details.id=igm_detail_container.igm_detail_id 
						left join commudity_detail on igm_detail_container.commudity_code=commudity_detail.commudity_code
						left join igm_navy_response on igm_details.id=igm_navy_response.igm_details_id
						inner join organization_profiles on igm_details.Submitee_Org_Id=organization_profiles.id  
						left join igm_supplimentary_detail on igm_details.id=igm_supplimentary_detail.igm_detail_id where igm_details.Import_Rotation_No Like'$from' 
						and igm_detail_container.port_status ='0' and igm_supplimentary_detail.id is null and mlocode='$mlo' and igm_details.final_submit=1
						union
						select igm_sup_detail_container.cont_imo,igm_sup_detail_container.cont_un,igm_supplimentary_detail.Pack_Number,igm_supplimentary_detail.Pack_Description,(select Organization_Name from organization_profiles where organization_profiles.id=igm_sup_detail_container.off_dock_id) as depu,igm_supplimentary_detail.Pack_Marks_Number,igm_sup_detail_container.id,igm_supplimentary_detail.Import_Rotation_No,igm_supplimentary_detail.Line_No,igm_supplimentary_detail.BL_No,igm_supplimentary_detail.Submitee_Org_Id,cont_number,cont_size,cont_weight,cont_seal_number,igm_supplimentary_detail.Description_of_Goods as dg,cont_status,cont_height,cont_type,0 as mlocode,cont_type,
						igm_supplimentary_detail.weight,Organization_Name,commudity_desc,final_amendment,response_details1,firstapprovaltime,response_details2,secondapprovaltime,response_details3,
						thirdapprovaltime,hold_application,rejected_application,hold_date,rejected_date,'S' as type,master_Line_No
						from igm_supplimentary_detail left join igm_sup_detail_container on igm_supplimentary_detail.id=igm_sup_detail_container.igm_sup_detail_id
						left join commudity_detail on igm_sup_detail_container.commudity_code=commudity_detail.commudity_code
						left join igm_navy_response on igm_supplimentary_detail.id=igm_navy_response.egm_details_id
						inner join organization_profiles on igm_supplimentary_detail.Submitee_Org_Id=organization_profiles.id  
						inner join igm_details on igm_details.id=igm_supplimentary_detail.igm_detail_id
						where igm_supplimentary_detail.Import_Rotation_No Like '$from' 
						and igm_sup_detail_container.port_status ='0'
						 and mlocode='$mlo' and igm_supplimentary_detail.final_submit=1 order by cont_number,Organization_Name";
					}	 
				}			
  	else if ($_POST['CStatus']=='FCL')
	{
					
					if($mlo=="All")
					{
						$str="select imco,un,igm_details.Pack_Number,igm_details.Pack_Description,(select Organization_Name from organization_profiles where organization_profiles.id=igm_detail_container.off_dock_id) as depu,igm_details.Pack_Marks_Number,igm_detail_container.id,igm_details.Import_Rotation_No,igm_details.Line_No,igm_details.BL_No,igm_details.Submitee_Org_Id,cont_number,cont_size,cont_weight,cont_seal_number,igm_details.Description_of_Goods as dg,cont_status,cont_height,cont_type,mlocode,cont_type,
						Cont_gross_weight,Organization_Name,commudity_desc,final_amendment,response_details1,
						firstapprovaltime,response_details2,secondapprovaltime,response_details3,thirdapprovaltime,hold_application,rejected_application,hold_date,rejected_date,'D' as type,master_Line_No
						from igm_details left join igm_detail_container on igm_details.id=igm_detail_container.igm_detail_id 
						left join commudity_detail on igm_detail_container.commudity_code=commudity_detail.commudity_code
						left join igm_navy_response on igm_details.id=igm_navy_response.igm_details_id
						inner join organization_profiles on igm_details.Submitee_Org_Id=organization_profiles.id  
						left join igm_supplimentary_detail on igm_details.id=igm_supplimentary_detail.igm_detail_id where igm_details.Import_Rotation_No Like'$from' and cont_status='FCL'
						and igm_detail_container.port_status ='0' and igm_supplimentary_detail.id is null  and igm_details.final_submit=1
						union
						select igm_sup_detail_container.cont_imo,igm_sup_detail_container.cont_un,igm_supplimentary_detail.Pack_Number,igm_supplimentary_detail.Pack_Description,(select Organization_Name from organization_profiles where organization_profiles.id=igm_sup_detail_container.off_dock_id) as depu,igm_supplimentary_detail.Pack_Marks_Number,igm_sup_detail_container.id,igm_supplimentary_detail.Import_Rotation_No,igm_supplimentary_detail.Line_No,igm_supplimentary_detail.BL_No,igm_supplimentary_detail.Submitee_Org_Id,cont_number,cont_size,cont_weight,cont_seal_number,igm_supplimentary_detail.Description_of_Goods as dg,cont_status,cont_height,cont_type,0 as mlocode,cont_type,
						igm_supplimentary_detail.weight,Organization_Name,commudity_desc,final_amendment,response_details1,firstapprovaltime,response_details2,secondapprovaltime,response_details3,
						thirdapprovaltime,hold_application,rejected_application,hold_date,rejected_date,'S' as type,master_Line_No
						from igm_supplimentary_detail left join igm_sup_detail_container on igm_supplimentary_detail.id=igm_sup_detail_container.igm_sup_detail_id
						left join commudity_detail on igm_sup_detail_container.commudity_code=commudity_detail.commudity_code
						left join igm_navy_response on igm_supplimentary_detail.id=igm_navy_response.egm_details_id
						inner join organization_profiles on igm_supplimentary_detail.Submitee_Org_Id=organization_profiles.id  
						inner join igm_details on igm_details.id=igm_supplimentary_detail.igm_detail_id
						where igm_supplimentary_detail.Import_Rotation_No Like '$from' and cont_status='FCL'
						and igm_sup_detail_container.port_status ='0'
						and igm_supplimentary_detail.final_submit=1 order by cont_number,Organization_Name";
					
					
					}
					
					else
					{
						$str="select imco,un,igm_details.Pack_Number,igm_details.Pack_Description,(select Organization_Name from organization_profiles where organization_profiles.id=igm_detail_container.off_dock_id) as depu,igm_details.Pack_Marks_Number,igm_detail_container.id,igm_details.Import_Rotation_No,igm_details.Line_No,igm_details.BL_No,igm_details.Submitee_Org_Id,cont_number,cont_size,cont_weight,cont_seal_number,igm_details.Description_of_Goods as dg,cont_status,cont_height,cont_type,mlocode,cont_type,
						Cont_gross_weight,Organization_Name,commudity_desc,final_amendment,response_details1,
						firstapprovaltime,response_details2,secondapprovaltime,response_details3,thirdapprovaltime,hold_application,rejected_application,hold_date,rejected_date,'D' as type,master_Line_No
						from igm_details left join igm_detail_container on igm_details.id=igm_detail_container.igm_detail_id 
						left join commudity_detail on igm_detail_container.commudity_code=commudity_detail.commudity_code
						left join igm_navy_response on igm_details.id=igm_navy_response.igm_details_id
						inner join organization_profiles on igm_details.Submitee_Org_Id=organization_profiles.id  
						left join igm_supplimentary_detail on igm_details.id=igm_supplimentary_detail.igm_detail_id where igm_details.Import_Rotation_No Like'$from' and cont_status='FCL'
						and igm_detail_container.port_status ='0' and igm_supplimentary_detail.id is null and mlocode='$mlo' and igm_details.final_submit=1
						union
						select igm_sup_detail_container.cont_imo,igm_sup_detail_container.cont_un,igm_supplimentary_detail.Pack_Number,igm_supplimentary_detail.Pack_Description,(select Organization_Name from organization_profiles where organization_profiles.id=igm_sup_detail_container.off_dock_id) as depu,igm_supplimentary_detail.Pack_Marks_Number,igm_sup_detail_container.id,igm_supplimentary_detail.Import_Rotation_No,igm_supplimentary_detail.Line_No,igm_supplimentary_detail.BL_No,igm_supplimentary_detail.Submitee_Org_Id,cont_number,cont_size,cont_weight,cont_seal_number,igm_supplimentary_detail.Description_of_Goods as dg,cont_status,cont_height,cont_type,0 as mlocode,cont_type,
						igm_supplimentary_detail.weight,Organization_Name,commudity_desc,final_amendment,response_details1,firstapprovaltime,response_details2,secondapprovaltime,response_details3,
						thirdapprovaltime,hold_application,rejected_application,hold_date,rejected_date,'S' as type,master_Line_No
						from igm_supplimentary_detail left join igm_sup_detail_container on igm_supplimentary_detail.id=igm_sup_detail_container.igm_sup_detail_id
						left join commudity_detail on igm_sup_detail_container.commudity_code=commudity_detail.commudity_code
						left join igm_navy_response on igm_supplimentary_detail.id=igm_navy_response.egm_details_id
						inner join organization_profiles on igm_supplimentary_detail.Submitee_Org_Id=organization_profiles.id  
						inner join igm_details on igm_details.id=igm_supplimentary_detail.igm_detail_id
						where igm_supplimentary_detail.Import_Rotation_No Like '$from' and cont_status='FCL'
						and igm_sup_detail_container.port_status ='0'
						 and mlocode='$mlo' and igm_supplimentary_detail.final_submit=1 order by cont_number,Organization_Name";
					}
			}

 	else
	{
						if($mlo=="All")
						{
							$str="select imco,un,igm_details.Pack_Number,igm_details.Pack_Description,(select Organization_Name from organization_profiles where organization_profiles.id=igm_detail_container.off_dock_id) as depu,igm_details.Pack_Marks_Number,igm_detail_container.id,igm_details.Import_Rotation_No,igm_details.Line_No,igm_details.BL_No,igm_details.Submitee_Org_Id,cont_number,cont_size,cont_weight,cont_seal_number,igm_details.Description_of_Goods as dg,cont_status,cont_height,cont_type,mlocode,cont_type,
							Cont_gross_weight,Organization_Name,commudity_desc,final_amendment,response_details1,
							firstapprovaltime,response_details2,secondapprovaltime,response_details3,thirdapprovaltime,hold_application,rejected_application,hold_date,rejected_date,'D' as type,master_Line_No
							from igm_details left join igm_detail_container on igm_details.id=igm_detail_container.igm_detail_id 
							left join commudity_detail on igm_detail_container.commudity_code=commudity_detail.commudity_code
							left join igm_navy_response on igm_details.id=igm_navy_response.igm_details_id
							inner join organization_profiles on igm_details.Submitee_Org_Id=organization_profiles.id  
							left join igm_supplimentary_detail on igm_details.id=igm_supplimentary_detail.igm_detail_id where igm_details.Import_Rotation_No Like'$from' and cont_status='LCL'
							and igm_detail_container.port_status ='0' and igm_supplimentary_detail.id is null and igm_details.final_submit=1
							union
							select igm_sup_detail_container.cont_imo,igm_sup_detail_container.cont_un,igm_supplimentary_detail.Pack_Number,igm_supplimentary_detail.Pack_Description,(select Organization_Name from organization_profiles where organization_profiles.id=igm_sup_detail_container.off_dock_id) as depu,igm_supplimentary_detail.Pack_Marks_Number,igm_sup_detail_container.id,igm_supplimentary_detail.Import_Rotation_No,igm_supplimentary_detail.Line_No,igm_supplimentary_detail.BL_No,igm_supplimentary_detail.Submitee_Org_Id,cont_number,cont_size,cont_weight,cont_seal_number,igm_supplimentary_detail.Description_of_Goods as dg,cont_status,cont_height,cont_type,0 as mlocode,cont_type,
							igm_supplimentary_detail.weight,Organization_Name,commudity_desc,final_amendment,response_details1,firstapprovaltime,response_details2,secondapprovaltime,response_details3,
							thirdapprovaltime,hold_application,rejected_application,hold_date,rejected_date,'S' as type,master_Line_No
							from igm_supplimentary_detail left join igm_sup_detail_container on igm_supplimentary_detail.id=igm_sup_detail_container.igm_sup_detail_id
							left join commudity_detail on igm_sup_detail_container.commudity_code=commudity_detail.commudity_code
							left join igm_navy_response on igm_supplimentary_detail.id=igm_navy_response.egm_details_id
							inner join organization_profiles on igm_supplimentary_detail.Submitee_Org_Id=organization_profiles.id  
							inner join igm_details on igm_details.id=igm_supplimentary_detail.igm_detail_id
							where igm_supplimentary_detail.Import_Rotation_No Like '$from' and cont_status='LCL'
							and igm_sup_detail_container.port_status ='0'
							and igm_supplimentary_detail.final_submit=1 order by cont_number,Organization_Name";
						}
						else
						{

							$str="select imco,un,igm_details.Pack_Number,igm_details.Pack_Description,(select Organization_Name from organization_profiles where organization_profiles.id=igm_detail_container.off_dock_id) as depu,igm_details.Pack_Marks_Number,igm_detail_container.id,igm_details.Import_Rotation_No,igm_details.Line_No,igm_details.BL_No,igm_details.Submitee_Org_Id,cont_number,cont_size,cont_weight,cont_seal_number,igm_details.Description_of_Goods as dg,cont_status,cont_height,cont_type,mlocode,cont_type,
							Cont_gross_weight,Organization_Name,commudity_desc,final_amendment,response_details1,
							firstapprovaltime,response_details2,secondapprovaltime,response_details3,thirdapprovaltime,hold_application,rejected_application,hold_date,rejected_date,'D' as type,master_Line_No
							from igm_details left join igm_detail_container on igm_details.id=igm_detail_container.igm_detail_id 
							left join commudity_detail on igm_detail_container.commudity_code=commudity_detail.commudity_code
							left join igm_navy_response on igm_details.id=igm_navy_response.igm_details_id
							inner join organization_profiles on igm_details.Submitee_Org_Id=organization_profiles.id  
							left join igm_supplimentary_detail on igm_details.id=igm_supplimentary_detail.igm_detail_id where igm_details.Import_Rotation_No Like'$from' and cont_status='LCL'
							and igm_detail_container.port_status ='0' and igm_supplimentary_detail.id is null and mlocode='$mlo' and igm_details.final_submit=1
							union
							select igm_sup_detail_container.cont_imo,igm_sup_detail_container.cont_un,igm_supplimentary_detail.Pack_Number,igm_supplimentary_detail.Pack_Description,(select Organization_Name from organization_profiles where organization_profiles.id=igm_sup_detail_container.off_dock_id) as depu,igm_supplimentary_detail.Pack_Marks_Number,igm_sup_detail_container.id,igm_supplimentary_detail.Import_Rotation_No,igm_supplimentary_detail.Line_No,igm_supplimentary_detail.BL_No,igm_supplimentary_detail.Submitee_Org_Id,cont_number,cont_size,cont_weight,cont_seal_number,igm_supplimentary_detail.Description_of_Goods as dg,cont_status,cont_height,cont_type,0 as mlocode,cont_type,
							igm_supplimentary_detail.weight,Organization_Name,commudity_desc,final_amendment,response_details1,firstapprovaltime,response_details2,secondapprovaltime,response_details3,
							thirdapprovaltime,hold_application,rejected_application,hold_date,rejected_date,'S' as type,master_Line_No
							from igm_supplimentary_detail left join igm_sup_detail_container on igm_supplimentary_detail.id=igm_sup_detail_container.igm_sup_detail_id
							left join commudity_detail on igm_sup_detail_container.commudity_code=commudity_detail.commudity_code
							left join igm_navy_response on igm_supplimentary_detail.id=igm_navy_response.egm_details_id
							inner join organization_profiles on igm_supplimentary_detail.Submitee_Org_Id=organization_profiles.id  
							inner join igm_details on igm_details.id=igm_supplimentary_detail.igm_detail_id
							where igm_supplimentary_detail.Import_Rotation_No Like '$from' and cont_status='LCL'
							and igm_sup_detail_container.port_status ='0'
							and mlocode='$mlo' and igm_supplimentary_detail.final_submit=1 order by cont_number,Organization_Name";
						}	
	}			
					
					
					//print($str);

					$result=mysql_query($str);
				$i=0;
				   $num=0;
				   
//print($str);				
					
		?>
			
		<TABLE width="100%">
			<TR><TD width="100%">
				<table class='table-header' border=0 width="100%">
					<tr><td colspan="2" align="center"><h1><font color="#F00000" > CHITTAGONG PORT AUTHORITY, CHITTAGONG  </font></h1></td></tr>
					<tr><td align="left"><b>Vessel Name: </b><?php print($row_vessel->Vessel_Name); ?></td></tr>
					<tr><td align="left"><b>Import Rotation No: </b><?php print($from); ?></td></tr>
				</table>
			</TD></TR>
			<TR><TD>
					<table width="100%" border=1  cellspacing="0" cellpadding="0">
						<tr>
							<?php if ($this->session->userdata('Control_Panel')==12) { ?>	
								<th><span class="style1">Serial No</span></th>
								<th><span class="style1">Shipping Agent</span></th>
								<th><span class="style1">Container Number</span></th>
								<th><span class="style1">UN NO</span></th>
								<th><span class="style1">Pack Name & Quantity</span></th>	
								<th><span class="style1">Container Description</span></th>
								<th><span class="style1">Description Of Good</span></th>
								<th><span class="style1">SL</span></th>	
							<?php } else { ?>
							<th><span class="style1">Serial No</span></th>
							<th><span class="style1">MLO CODE</span></th>
							<th><span class="style1">Shipping Agent</span></th>
							<th><span class="style1">Line No</span></th>					
							<th><span class="style1">Container Number</span></th>
							<th><span class="style1">UN NO</span></th>
							<th><span class="style1">IMDG CODE</span></th>							
							<th><span class="style1">Pack Name & Quantity</span></th>	
							<th><span class="style1">Container Description</span></th>
							<th><span class="style1">Container Type</span></th>	
							<th><span class="style1">TARE WEIGHT</span></th>
							<th><span class="style1">Gross Weight</span></th>
							<th><span class="style1">Container Seal Number</span></th>
							<th><span class="style1">Pack Marks Number</span></th>
							<th><span class="style1">Depu Code</span></th>
							<th><span class="style1">Description Of Good</span></th>
							<th><span class="style1">Commodity List</span></th>													
						    <th><span class="style1">Navy Comments</span></th>	
							<th><span class="style1">Date of Comments</span></th>	
							<th><span class="style1">SL</span></th>		

							<?php } ?>
						</tr>
					
						
							<?php while($row=mysql_fetch_object($result))
							{ $i=$i+1;
							if($check==$row->cont_number)
							{
							
							
							}
							else
							{
							$num=$num+1;
							$check=$row->cont_number;
							}
							?>
							
					  <tr>
							<?php if ($this->session->userdata('Control_Panel')==12) { ?>
								<td align="center"><?php print($num);?></td>
								<td align="center"><?php if($row->Organization_Name)  print($row->Organization_Name); else print("&nbsp;"); ?></td>					
								<td align="center"><?php if($row->cont_number)  print($row->cont_number); else print("&nbsp;"); ?></td>
								<td align="center"><?php if($row->imco)  print($row->imco); else print("&nbsp;"); ?></td>
								<td align="center"><?php if($row->Pack_Number or $row->Pack_Description) print($row->Pack_Description.$row->Pack_Number); else print("&nbsp;"); ?></td>
								<td align="center"><?php if($row->cont_status or $row->cont_size or $row->cont_height) print($row->cont_size.$row->cont_status.$row->cont_height); else print("&nbsp;"); ?></td>
								<td align="center"><?php if($row->dg)  print($row->dg); else print("&nbsp;"); ?></td>
								<td align="center"><?php print($i);?></td>
							
							
							<?php } else { ?>
						  <td align="center"><?php print($num);?></td>
						  <td align="center"><?php if($row->mlocode)  print($row->mlocode); else print("&nbsp;"); ?></td>
						  <td align="center"><?php if($row->Organization_Name)  print($row->Organization_Name); else print("&nbsp;"); ?></td>					
						  <td align="center"><?php if($row->Line_No)  print($row->Line_No); else print("&nbsp;"); ?></td>					  
						  <td align="center"><?php if($row->cont_number)  print($row->cont_number); else print("&nbsp;"); ?></td>
							<td align="center"><?php if($row->imco)  print($row->imco); else print("&nbsp;"); ?></td>
							<td align="center"><?php if($row->un)  print($row->un); else print("&nbsp;"); ?></td>




						<td align="center"><?php if($row->Pack_Number or $row->Pack_Description) print($row->Pack_Description.$row->Pack_Number); else print("&nbsp;"); ?></td>
		
						  <td align="center"><?php if($row->cont_status or $row->cont_size or $row->cont_height) print($row->cont_size.$row->cont_status.$row->cont_height); else print("&nbsp;"); ?></td>
			 <td align="center"><?php if($row->cont_weight)  print($row->cont_type); else print("&nbsp;"); ?></td>			  
						 
						   <td align="center"><?php if($row->cont_weight)  print($row->cont_weight); else print("&nbsp;"); ?></td>
						  <td align="center"><?php 
						
					if ($row->type=='S' and $row->cont_status=='LCL')
							{
												
												$str1="select cont_gross_weight,cont_weight from igm_detail_container inner join igm_details on 
							igm_details.id=igm_detail_container.igm_detail_id where 
							Import_Rotation_No='$row->Import_Rotation_No' and Line_No='$row->master_Line_No' and cont_number='$row->cont_number'";
												//print($str1);
												$resultweight=mysql_query($str1);
												$rowweight = mysql_fetch_object($resultweight);
												//print($rowweight->cont_weight."<br>");
												print($rowweight->cont_gross_weight);

												//print($rowweight->cont_gross_weight+$rowweight->cont_weight);
							}
												else
							
							
							
							
							//print($row->cont_weight."<br>");
							
							 print($row->Cont_gross_weight);
							//print($row->cont_weight+$row->Cont_gross_weight); 
							?>
									  
						  </td>
						  
						  
						  
						  
						  
						  
						  
						  <td align="center"><?php if($row->cont_seal_number)  print($row->cont_seal_number); else print("&nbsp;"); ?></td>
						  <td align="center"><?php if($row->Pack_Marks_Number)  print($row->Pack_Marks_Number); else print("&nbsp;"); ?></td>
						  <td align="center"><?php if($row->depu)  print($row->depu); else print("&nbsp;"); ?></td>
						  <td align="center"><?php if($row->dg)  print($row->dg); else print("&nbsp;"); ?></td>
						  <td align="center"><?php if($row->commudity_desc)  print($row->commudity_desc); else print("&nbsp;"); ?></td>

						  
						  
						  
						  
						 
						  <td align="center"><?php if($row->final_amendment==4)  {print($row->hold_application);}
											 else if($row->final_amendment==5)  {print($row->rejected_application);}
											 else if($row->final_amendment==2)  {print($row->response_details2);}
												else if($row->final_amendment==1)  {print($row->response_details3);}
						  else print("&nbsp;"); ?></td>
						  <td align="center"><?php if($row->final_amendment==4)  {print($row->hold_date);}
											 else if($row->final_amendment==5)  {print($row->rejected_date);}
											 else if($row->final_amendment==2)  {print($row->secondapprovaltime);}
												else if($row->final_amendment==1)  {print($row->thirdapprovaltime);}
						  else print("&nbsp;"); ?></td>
						<td align="center"><?php print($i);?></td>
						<?php } ?>
					  </tr>	
					<?php 
					
					
					} ?>	
					
					
					
				
					</table>
					
			</TD></TR>
		</TABLE>
	<?php 
mysql_close($con_cchaportdb);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
