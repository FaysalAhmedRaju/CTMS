<?php 
//print($_POST['options']);
if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>DGM Manifest</TITLE>
		<LINK href="../css/report.css" type=text/css rel=stylesheet>
	</HEAD>
	<BODY>
	<?php } else if($_POST['options']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=DG Manifest.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
include("mydbPConnection.php");

$org_id=$_POST['txt_submitted_by_who_org'];
$control_panel=$_POST['txt_controlpanel'];
$rotation=$_POST['ddl_imp_rot_no'];


//AW Update
	/*$sqlmaster=mysql_query("select file_clearence_date from igm_masters where Import_Rotation_No='$rotation'");
	$rowMaster=mysql_fetch_object($sqlmaster);
	$file_clearence_date=$rowMaster->file_clearence_date;
	if(!($control_panel==10 or $control_panel==44 or $control_panel==12))
	{
		if($file_clearence_date=="" or $file_clearence_date>"2013-09-02")
		{
			print("<font color='red' size='4'>According to customs decision, you can not view any IGM  after final entry completion from 2013-09-02...</font>");
			//include_once("myCustomDocumentcheckHTML.php");
			break;

		}
	}*/
	
	//AW Update



//if ($control_panel==12) //For Port
$str="select distinct igms.id as id,igms.mlocode,igms.IGM_id as IGM_id,igms.Import_Rotation_No as Import_Rotation_No,igms.Line_No as Line_No,
		igms.BL_No as BL_No,igms.Pack_Number as Pack_Number,igms.Pack_Description as Pack_Description,igms.Pack_Marks_Number as Pack_Marks_Number,
		igms.Description_of_Goods as Description_of_Goods,igms.Date_of_Entry_of_Goods as Date_of_Entry_of_Goods,igms.weight as weight,igms.weight_unit,igms.net_weight,igms.net_weight_unit,
		igms.Bill_of_Entry_No as Bill_of_Entry_No,igms.Bill_of_Entry_Date as Bill_of_Entry_Date,igms.No_of_Pack_Delivered as No_of_Pack_Delivered,
		igms.No_of_Pack_Discharged as No_of_Pack_Discharged,igms.Remarks as Remarks,igms.AFR as AFR,igms.ConsigneeDesc,igms.NotifyDesc,igms.navy_comments,igms.Submitee_Org_Id,igms.mlocode,
        (select Organization_Name from organization_profiles orgs where 
         orgs.id=igms.Submitee_Org_Id) as Organization_Name,
(select Vessel_Name from igm_masters igm_Master where 
         igm_Master.id=igms.IGM_id) as vessel_Name,
imco,un,extra_remarks,navyresponse.response_details1,
navyresponse.response_details2,navyresponse.secondapprovaltime,navyresponse.response_details3,navyresponse.thirdapprovaltime,
navyresponse.hold_application,navyresponse.hold_date,navyresponse.rejected_application,navyresponse.rejected_date,
navyresponse.final_amendment  
        from igm_details igms  left join igm_detail_container
        on igm_detail_container.igm_detail_id=igms.id left join igm_navy_response navyresponse on navyresponse.igm_details_id=igms.id
		where igms.Import_Rotation_No='$rotation' and (cont_imo <> '' or igms.imco <> '' or igms.un <> '')";
/*else
$str="select distinct igms.id as id,igms.mlocode,igms.IGM_id as IGM_id,igms.Import_Rotation_No as Import_Rotation_No,igms.Line_No as Line_No,
		igms.BL_No as BL_No,igms.Pack_Number as Pack_Number,igms.Pack_Description as Pack_Description,igms.Pack_Marks_Number as Pack_Marks_Number,
		igms.Description_of_Goods as Description_of_Goods,igms.Date_of_Entry_of_Goods as Date_of_Entry_of_Goods,igms.weight as weight,igms.weight_unit,igms.net_weight,igms.net_weight_unit,
		igms.Bill_of_Entry_No as Bill_of_Entry_No,igms.Bill_of_Entry_Date as Bill_of_Entry_Date,igms.No_of_Pack_Delivered as No_of_Pack_Delivered,
		igms.No_of_Pack_Discharged as No_of_Pack_Discharged,igms.Remarks as Remarks,igms.AFR as AFR,igms.ConsigneeDesc,igms.NotifyDesc,igms.navy_comments,igms.Submitee_Org_Id,igms.mlocode,
        (select Organization_Name from organization_profiles orgs where 
         orgs.id=igms.Submitee_Org_Id) as Organization_Name,
(select Vessel_Name from igm_masters igm_Master where 
         igm_Master.id=igms.IGM_id) as vessel_Name,
imco,un,extra_remarks,navyresponse.response_details1,
navyresponse.response_details2,navyresponse.secondapprovaltime,navyresponse.response_details3,navyresponse.thirdapprovaltime,
navyresponse.hold_application,navyresponse.hold_date,navyresponse.rejected_application,navyresponse.rejected_date,
navyresponse.final_amendment  
        from igm_details igms  left join igm_detail_container
        on igm_detail_container.igm_detail_id=igms.id left join igm_navy_response navyresponse on navyresponse.igm_details_id=igms.id
		where igms.Import_Rotation_No='$rotation' and (cont_imo <> '' or igms.imco <> '' or igms.un <> '') and submitee_org_id='$org_id'";
*/
		
		$result = mysql_query($str);
//print($str);

		//FOR VESSEL NAME :
		$str_vesselName="select Vessel_Name from igm_masters where Import_Rotation_No ='$rotation'";
		//print($str_vesselName);
		$result_VesselName = mysql_query($str_vesselName);
		$row_Vessel = mysql_fetch_object($result_VesselName)
	?>
<table align="center">
		
			<tr><td style="font-size:22px;" ><b>DG MENIFEST</b></td></tr>
			
			<tr><td align ="left"><b>Import Rotation No : </b><?php print($rotation); ?></td></tr>
			<tr><td align ="left"><b>Vessels Name : </b><?php print($row_Vessel->Vessel_Name); ?></td></tr>
		</table> 
<table border="1" >


		<tr class='gridDark'><th>Agent</th><th>MLO&nbsp;Code</th><td>Line&nbsp;No.</td><td>B/L&nbsp;Number</td><td>Number/Quantity</td><td>Description</td><td>Marks&nbsp;&&nbsp;Number</td><td>Description&nbsp;Of&nbsp;Goods</td><td>Date&nbsp;Of&nbsp;Entry&nbsp;of&nbsp;Goods</td><td>Net Weight</td><td>Gross Weight</td>

		<td>Container&nbsp;Detail</td>

		<td>Name&nbsp;of&nbsp;the&nbsp;Importers&nbsp;or&nbsp;Clearing&nbsp;Agent</td><td>Bill&nbsp;Of&nbsp;Entry&nbsp;Number</td><td>Bill&nbsp;Of&nbsp;Entry&nbsp;Date</td><td>Delivered</td><td>Discharged</td><td>To&nbsp;be&nbsp;Accounted&nbsp;For</td><td>Remarks</td>
		
		
		<td>IMCO</td><td>UN</td><td>Navy comments</td>

</tr>

<?php

			
			while ($row = mysql_fetch_object($result)) {
			//print($row->Remarks);
		?>
			
			    <tr class='gridLight'>
					<td valign="top"><?php if($row->Organization_Name) print($row->Organization_Name); else print("&nbsp;");?></td>
					<td valign="top"><?php  if($row->mlocode) print($row->mlocode); else print("&nbsp;"); ?></td>					
					<td valign="top"><?php print($row->Line_No); ?></td>
					<td valign="top"><?php print($row->BL_No); ?></td>
					<td valign="top"><?php print($row->Pack_Number); ?></td>
					
					
					
					<td valign="top"><?php print($row->Pack_Description); ?></td>
					<td valign="top"><?php print($row->Pack_Marks_Number); ?></td>
					<td valign="top"><?php print($row->Description_of_Goods); ?></td>
					<td valign="top"><?php print($row->Date_of_Entry_of_Goods); ?></td>
					<td valign="top"><?php print($row->net_weight); ?>&nbsp;<?php print($row->net_weight_unit); ?></td>
					<td valign="top"><?php print($row->weight); ?>&nbsp;<?php print($row->weight_unit); ?></td>
					

		
					<td align="left" valign="top">
					
					<table width="100%">
					<tr><td>Off-dock Name</td><td>Cnt.&nbsp;Number</td><td>Seal&nbsp;Number</td><td>Size</td><td>Type</td><td>Height</td><td>Weight</td><td>Status</td><td>IMCO</td><td>UN</td></tr>
					<?php 
					//load container detail
						//print("select cnt.id as id,cnt.cont_number as cont_number,cnt.cont_size as cont_size,cnt.cont_weight as cont_weight,cnt.cont_seal_number as cont_seal_number,cnt.cont_description as cont_description from igm_detail_container cnt where cnt.igm_detail_id=$row->id");
						
						$str="select cnt.id as id, cnt.cont_number as cont_number, cnt.cont_size as cont_size,cnt.cont_type as cont_type,cnt.cont_height as cont_height,cnt.cont_status as cont_status,cnt.cont_weight as cont_weight,cnt.cont_seal_number as cont_seal_number,cnt.cont_description as cont_description,cnt.cont_imo as cont_imo, cnt.cont_un as cont_un,off_dock_id,Organization_Name from igm_detail_container cnt 
                                               inner join organization_profiles on  organization_profiles.id=cnt.off_dock_id
                                                where cnt.igm_detail_id=$row->id  and cont_imo <> ''";		
						$result1 = mysql_query($str);
						//print($str);
						while($row1 = mysql_fetch_object($result1)) {
							print("<tr><td>$row1->Organization_Name</td><td>$row1->cont_number</td><td>$row1->cont_seal_number</td><td>$row1->cont_size</td><td>$row1->cont_type</td><td>$row1->cont_height</td><td>$row1->cont_weight</td><td>$row1->cont_status</td><td>$row1->cont_imo</td><td>$row1->cont_un</td></tr>");	
							print("<tr><td><hr noshade></td></tr>");
						}
						mysql_free_result($result1);	
						
					?>					
					</table>
					
					</td>
					
		
					<td align="left" valign="top">
					
					<table width="100%">
					<tr><th align="left">Consignee</th></tr>
					<?php 
					// load consignee
						
						$result2 = mysql_query("select cons.id,cons.igm_detail_id,cons.Consignee_ID,(select org.Organization_Name from organization_profiles org where org.id=cons.Consignee_ID) as consignee_name,(select org1.Address_1 from organization_profiles org1 where org1.id=cons.Consignee_ID) as Address_1,cons.ff_clearance as ff_clearance from igm_detail_consigneetabs cons where cons.igm_detail_id=$row->id");						
						
						
						
						while($row2 = mysql_fetch_object($result2)) {
							if($_SESSION['org_id']==$row2->Consignee_ID)
							{
								if($row2->ff_clearance==1)
								{
								print("<tr><td class='consigneeHighLight'><a href='home.php?myflag=324&CODE=$row->IGM_id&SubCODE=$row->id&ImpRot=$row->Import_Rotation_No&MLine=$row->Line_No&MBL=$row->BL_No&TM=$this->TM&SFlag=0' target='upper_top'>$row2->consignee_name<br>$row2->Address_1</a></td></tr>");	
								print("<tr><td><hr noshade></td></tr>");								
								}
								else
								{
								$altm='javascript:alert("You need clearance to submit Supplementary IGM")';
								print("<tr><td class='consigneeHighLight'><a href='$altm' target='upper_top'>$row2->consignee_name<br>$row2->Address_1</a></td></tr>");	
								print("<tr><td><hr noshade></td></tr>");
								}
							}
							else
							{
							print("<tr><td align='left'>$row2->consignee_name<br>$row2->Address_1</td></tr>");	
							print("<tr><td><hr noshade></td></tr>");
							}
						}
						mysql_free_result($result2);	
						
					?>
					
					<tr><td ><?php print($row->ConsigneeDesc); ?></td></tr>
					
					<tr><th align="left">Notify Party</th></tr>
					
					<?php 
					// load notify
						
						$result3 = mysql_query("select notf.id,notf.igm_detail_id,notf.Notify_ID,(select org.Organization_Name from organization_profiles org where org.id=notf.Notify_ID) as notify_name,(select org1.Address_1 from organization_profiles org1 where org1.id=notf.Notify_ID) as Address_1,notf.ff_clearance as ff_clearance from igm_detail_notifytabs notf where notf.igm_detail_id=$row->id");						
						
						
						
						while($row3 = mysql_fetch_object($result3))
						{
							
							
								
								print("<td >$row3->notify_name<br>$row3->Address_1</a></td>");	
									print("<tr><td><hr noshade></td></tr>");						
								
						}	
							
						
						mysql_free_result($result3);	
						
					?>
					
					<tr><td valign="top"><?php print($row->NotifyDesc); ?></td></tr>
					</table>
					
					</td>
					
					<td valign="top"><?php if($row->Bill_of_Entry_No) print($row->Bill_of_Entry_No); else print("&nbsp;");?></td>
					<td valign="top"><?php if($row->Bill_of_Entry_Date) print($row->Bill_of_Entry_Date); else print("&nbsp;");?></td>
					<td valign="top"><?php if($row->No_of_Pack_Delivered) print($row->No_of_Pack_Delivered); else print("&nbsp;");?></td>
					<td valign="top"><?php if($row->No_of_Pack_Discharged) print($row->No_of_Pack_Discharged); else print("&nbsp;");?></td>
				
					<td align="left" valign="top">
					
					<table width="100%">					
					<?php 
					// load CnF
						
						$result4 = mysql_query("select cnf.id,cnf.igm_detail_id,cnf.CnF_ID_to_be_AccountedFor as CnF_ID_to_be_AccountedFor,(select org.Organization_Name from organization_profiles org where org.id=cnf.CnF_ID_to_be_AccountedFor) as cnf_name,(select org1.Address_1 from organization_profiles org1 where org1.id=cnf.CnF_ID_to_be_AccountedFor) as Address_1 from igm_detail_cnftabs cnf where cnf.igm_detail_id=$row->id ");						
					while($row4 = mysql_fetch_object($result4))
						{
							
							
								
								print("<td >$row4->cnf_name<br>$row4->Address_1</td>");	
									print("<tr><td><hr noshade></td></tr>");
										
								
								
						}	
							
						
						mysql_free_result($result4);	
							
							
							
							?>
					
						
						
					</table>
					<td ><?php if($row->Remarks) print($row->Remarks); else print("&nbsp;");?></td>
<td ><?php if($row->imco) print($row->imco); else print("&nbsp;");?></td>
<td ><?php if($row->un) print($row->un); else print("&nbsp;");?></td>
						
				<td >
				<?php
					if($row->final_amendment==2)
					{
					print("Lab Com:".$row->response_details1."<br> NAIO Com:".
					$row->response_details2."<br> Hold:".$row->hold_application);
					//print($row->hold_application);
					}
					else if($row->final_amendment==3)
					{
					print("Lab Com:".$row->response_details1."<br> NAIO Com:".
					$row->response_details2."<br> Rej:".$row->rejected_application);
					
					}
					else if($row->navy_response_to_port !="" and $row->response_details3 =="")
					{		
					//print($row->navy_response_to_port);
					}
					else if($row->final_amendment==1)
					{
					print("Lab Com:".$row->response_details1."<br> NAIO Com:".
					$row->response_details2."<br> Finally:".$row->response_details3);
					
					}
					else
					{
					print("&nbsp;");
					}
				?>
				</td>
					
				

	

					
		
					</tr>
		<?php	
			}
		

		?>
		<tr>
			<td colspan="21">
				N.B.-This is Electronically generated.No Signature is required.
			</td>
		</tr>
</table>
<?php if($_POST['options']=='html'){?>		
	</BODY>
</HTML>
<?php }?>


