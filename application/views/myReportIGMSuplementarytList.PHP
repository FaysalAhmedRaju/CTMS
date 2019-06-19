<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>IGM Supplementary Import Manifest</TITLE>
		
	</HEAD>
	<BODY>
	<?php } else if($_POST['options']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=IGM Supplementary General Manifest.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}
	//echo $_POST['txt_org'];
	include("mydbPConnection.php");

	$import_rotationno=$_POST['ddl_imp_rot_no'];
	$today=date("Y-m-d h:i:s");			
	$org_Type_id=$_POST['txt_org_type_id'];	
	$login_id=$_POST['txt_login_id'];
	$link=$_POST['txt_homemsg'];
	//print($org_Type_id.$login_id."abcd");

    
	$str_vessel=mysql_query("select Vessel_Name,file_clearence_logintime,file_clearence_date,
	final_clerance_files_ref_number from igm_masters where Import_Rotation_No='$import_rotationno'");

	//print("select Vessel_Name,file_clearence_logintime,file_clearence_date,
	//final_clerance_files_ref_number from igm_masters where Import_Rotation_No='$import_rotationno'");
		
	$row_vessel=mysql_fetch_object($str_vessel); 

	/*if(!($org_Type_id=='5' or $org_Type_id=='3' or $org_Type_id=='12'))
	{
		if($row_vessel->file_clearence_date>"2013-09-02")
		{
			print("<font color='red' size='4'>According to customs decision, you can not view any IGM  after final entry completion from 2013-09-02...</font>");
			//include_once("myCustomDocumentcheckHTML.php");
			break;

		}
	}
	if($row_vessel->file_clearence_date=="" or $row_vessel->file_clearence_date>"2013-09-02")
		$awstatus="and final_submit=0";
		else
			$awstatus="";
 	
	if($org_Type_id=='5')	
	{
	//$handle111= fopen('C:\port_log.txt' , 'a') or exit("Unable to open file!"); 
	$handle111= fopen('/var/www/html/Message/port_log.txt' , 'a') or exit("Unable to open file!");	
	fwrite(	$handle111,	"\r\n Rottion_no:".$import_rotationno."|"." line_no:".$row->Line_No."|"." File Clearence date: ".$row_vessel->file_clearence_date."|"." Date: ".$today."|"." Link: ".$link." Login_id: ".$login_id."|". "org_Type_id:".$org_Type_id);		
	fclose($handle111);
	}*/

	//if($_POST['txt_controlp']==10 or $_POST['txt_controlp']==58 or $_POST['txt_controlp']==63){
	$result=mysql_query("select igms.id as id, 
							igms.Import_Rotation_No as Import_Rotation_No, 
							igms.Line_No as Line_No, igms.BL_No as BL_No,
							 igms.Pack_Number as Pack_Number,
							 igms.Pack_Description as Pack_Description, 
							igms.Pack_Marks_Number as Pack_Marks_Number, 
							left(replace(igms.Description_of_Goods,'
',' '),450) as Description_of_Goods,
							 
							igms.weight as weight, igms.Bill_of_Entry_No as Bill_of_Entry_No,
							 igms.Bill_of_Entry_Date as Bill_of_Entry_Date, 
							igms.No_of_Pack_Delivered as No_of_Pack_Delivered,
							 igms.No_of_Pack_Discharged as No_of_Pack_Discharged,
							 igms.Remarks as Remarks, igms.ConsigneeDesc,
							igms.weight,weight_unit,igms.net_weight,net_weight_unit, 
							igms.NotifyDesc, igms.Submission_Date 
							from igm_supplimentary_detail igms
							where 
								igms.Import_Rotation_No='$_POST[ddl_imp_rot_no]' and 
								igms.type_of_igm='$_POST[ddl_manifest]' and 
								igms.final_submit=1 and
								igms.Submission_Date like '$_POST[ddl_year]%' and
								igms.type_of_igm='$_POST[ddl_manifest]' and
								igms.Submitee_Org_Id ='$_POST[ddl_Org_id]'
								");
						

								//print_r($result1);
								//die();
							
								//die();*/
								//igms.Submitee_Org_Id='$_GET[org_id]'
		
?>
	<TABLE border="0">
	<TR><TD width="2113">
		<table align="center">
			<tr><td style="font-size:22px;" ><b>IGM SUPLEMENTARY CONTAINER</b></td></tr>
		</table>
	</TD></TR>
	<TR><TD>
		<table width="100%">
		<?php
		
			//if($_POST['txt_controlp']==10 or $_POST['txt_controlp']==58 or $_POST['txt_controlp']==63){
			$result_igm_master=mysql_query("SELECT
												Import_Rotation_No,
												vessels.Vessel_Name,
												Voy_No,
												Net_Tonnage,
												Port_of_Shipment,
												Port_of_Destination,
												Sailed_Year,
												Submitee_Org_Id,
												Name_of_Master,
												Organization_Name,
												is_Foreign,
												Vessel_Type,
												Name_of_Master,
												Port_of_Registry
											FROM
												igm_masters 
												LEFT JOIN organization_profiles ON 
												organization_profiles.id=igm_masters.Submitee_Org_Id
												LEFT JOIN vessels ON vessels.id=igm_masters.Vessel_Id
											WHERE 
												igm_masters.Import_Rotation_No='$_POST[ddl_imp_rot_no]'
												
											");
			
			if($result_igm_master)
			$row_igm_master=mysql_fetch_object($result_igm_master);											
			$str="SELECT Organization_Name from organization_profiles where id='$_POST[ddl_Org_id]'";
			//print $str;
			$result_org_name=mysql_query($str);
			$row_org_name=mysql_fetch_object($result_org_name);
		?>
			<tr><td align="left"><b>Line Belongs To:&nbsp;<?php print($row_org_name->Organization_Name);?></b></td></tr>
			<tr>
				<td><b>PORT OF&nbsp;Chittagong</b></td>
				<td><b>Rotation No:&nbsp;&nbsp;<?php print($row_igm_master->Import_Rotation_No);?></b></td>
				<td><b>Year:&nbsp;<?php print($_POST['ddl_year']);?></b></td>
				<td style="font-size:15.0px"><b><?php print($row_igm_master->Organization_Name);?></b></td>
			</tr>
			
		</table>
	</TD></TR>
	<TR>
		<TD>
			<table width="100%" style="border-style:dashed; border-color:black; border-width:1.0px" align="center">
				<tr>
					<th>SHIP NAME</th>
					<th>Voy. No.</th>
					<!--<th>Net Tonnage</th>-->
					<th>Bangladesh/Foreign</th>
					<th>If Mortor Vessel Or Steamear</th>
					<th>Name of Master and Wheather a Bangladeshi or Foreign</th>
					<th>PORT OF SHIPMENT</th>
				</tr>
				<tr align="center">
					<td><?php print($row_igm_master->Vessel_Name);?></td>
					<td><?php print($row_igm_master->Voy_No);?></td>
					<!--<td><?php //print($row_igm_master->Vessel_Name);?></td>-->
					<td><?php print($row_igm_master->Port_of_Registry);?></td>
					<td><?php print($row_igm_master->Vessel_Name);?></td>
					<td><?php print($row_igm_master->Name_of_Master);?></td>
					<td><?php print($row_igm_master->Port_of_Shipment);?></td>
			</tr>
			</table>
		<td width="10"></TD>
	</TR>
	<TR><TD>
		<table width="81%" height="212" border="1" cellpadding=0 cellspacing=0>
		<tr >
			<th>Line No.</th>
			<th>B/L Number</th>
			<th>Number</th>
			<th>Description</th>
			<th>Marks & Number</th>
			<th>Description Of Goods</th>
			<th>Submission Date</th>
			
			<th>Net Weight</th>
			<th>Gross Weight</th>
			<th>Container Detail</th>
			<th>Name of the Importers or Clearing Agent</th>
			<th>Bill Of Entry Number</th>
			<th>Bill Of Entry Date</th>
			<th>Delivered</th>
			<th>Discharged</th>
			<th>To be Accounted For</th>
			<th>Remarks</th>
	
		
				
		</tr>

		<?php

			while ($row = mysql_fetch_object($result)) {
		?>
			
			    <tr >
					<td height="96" valign="top"><?php if($row->Line_No) print($row->Line_No); else print("&nbsp;");?></td>
					<td valign="top"><?php if($row->BL_No) print($row->BL_No); else print("&nbsp;");?></td>
					<td valign="top"><?php if($row->Pack_Number) print($row->Pack_Number); else print("&nbsp;"); ?></td>
					<td valign="top"><?php if($row->Pack_Description) print($row->Pack_Description); else print("&nbsp;");?></td>
					<td valign="top"><?php if($row->Pack_Marks_Number) print($row->Pack_Marks_Number); else print("&nbsp;");?></td>
					<td valign="top"><?php if($row->Description_of_Goods) print($row->Description_of_Goods); else print("&nbsp;") ?></td>
					<td valign="top"><?php if($row->Submission_Date) print($row->Submission_Date); else print("&nbsp;"); ?></td>
					<td valign="top"><?php if($row->net_weight) print($row->net_weight."&nbsp;".$row->net_weight_unit); else print("&nbsp;"); ?></td>
					
					<td valign="top"><?php if($row->weight) print($row->weight."&nbsp;".$row->weight_unit); else print("&nbsp;"); ?></td>
					
					<td align="left" valign="top">
					
					<table width="100%">
					<tr border="1">
						<th>Cnt. Number</th>
						<th>Seal Number</th>
						<th>Size</th>
						<th>Type</th>
						<th>Height</th>
						<th>Weight</th>
						<th>Status</th>
					</tr>
					<?php 
					//load container detail
						//print("select cnt.id as id,cnt.cont_number as cont_number,cnt.cont_size as cont_size,cnt.cont_weight as cont_weight,cnt.cont_seal_number as cont_seal_number,cnt.cont_description as cont_description from igm_detail_container cnt where cnt.igm_detail_id=$row->id");
						
						$result1 = mysql_query("select cnt.id as id, cnt.cont_number as cont_number, cnt.cont_size as cont_size,cnt.cont_type as cont_type,cnt.cont_height as cont_height,cnt.cont_status as cont_status,cnt.cont_weight as cont_weight,cnt.cont_seal_number as cont_seal_number,cnt.cont_description as cont_description from igm_sup_detail_container cnt where cnt.igm_sup_detail_id=$row->id");						
						//print("select cnt.id as id, cnt.cont_number as cont_number, cnt.cont_size as cont_size,cnt.cont_type as cont_type,cnt.cont_height as cont_height,cnt.cont_status as cont_status,cnt.cont_weight as cont_weight,cnt.cont_seal_number as cont_seal_number,cnt.cont_description as cont_description from igm_sup_detail_container cnt where cnt.igm_sup_detail_id=$row->id");
						//die();
						//print("select cnt.id as id, cnt.cont_number as cont_number, cnt.cont_size as cont_size,cnt.cont_type as cont_type,cnt.cont_height as cont_height,cnt.cont_status as cont_status,cnt.cont_weight as cont_weight,cnt.cont_seal_number as cont_seal_number,cnt.cont_description as cont_description from igm_sup_detail_container cnt where cnt.igm_sup_detail_id=$row->id");
						//die();
						while($row1 = mysql_fetch_object($result1)) {
							print("<tr>
								<td>$row1->cont_number</td>
								<td>$row1->cont_seal_number</td>
								<td>$row1->cont_size</td>
								<td>$row1->cont_type</td>
								<td>$row1->cont_height</td>
								<td>$row1->cont_weight</td>
								<td>$row1->cont_status</td>
								</tr>");	
							print("<tr><td colspan='4'><hr noshade></td></tr>");
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
						
						$result2 = mysql_query("select cons.id, cons.igm_sup_detail_id,cons.Consignee_ID,(select org.Organization_Name from organization_profiles org where org.id=cons.Consignee_ID) as consignee_name,(select org1.Address_1 from organization_profiles org1 where org1.id=cons.Consignee_ID) as Address_1 from igm_sup_detail_consigneetabs cons where cons.igm_sup_detail_id=$row->id");						
						
						//print("select cons.id, cons.igm_sup_detail_id,cons.Consignee_ID,(select org.Organization_Name from organization_profiles org where org.id=cons.Consignee_ID) as consignee_name,(select org1.Address_1 from organization_profiles org1 where org1.id=cons.Consignee_ID) as Address_1 from igm_sup_detail_consigneetabs cons where cons.igm_sup_detail_id=$row->id");
						//die();
						
						while($row2 = mysql_fetch_object($result2)) {
							if($_SESSION['org_id']==$row2->Consignee_ID)
							{
							print("<tr><td class='consigneeHighLight'>$row2->consignee_name<br>$row2->Address_1</td></tr>");	
							print("<tr><td><hr noshade></td></tr>");
							}
							else
							{
							print("<tr><td align='left'>$row2->consignee_name<br>$row2->Address_1</td></tr>");	
							print("<tr><td><hr noshade></td></tr>");
							}
						}
						mysql_free_result($result2);	
						
					?>
					
					<tr><td><?php print($row->ConsigneeDesc); ?></td></tr>
					
					<tr><th align="left">Notify Party</th></tr>
					
					<?php 
					// load notify
						
						$result3 = mysql_query("select notf.id,notf.igm_sup_detail_id,notf.Notify_ID,(select org.Organization_Name from organization_profiles org where org.id=notf.Notify_ID) as notify_name,(select org1.Address_1 from organization_profiles org1 where org1.id=notf.Notify_ID) as Address_1 from igm_sup_detail_notifytabs notf where notf.igm_sup_detail_id=$row->id");						
						
						
						
						while($row3 = mysql_fetch_object($result3)) {
							
							if($_SESSION['org_id']==$row3->Notify_ID)
							{
							print("<tr><td class='notifyHighLight'>$row3->notify_name<br>$row3->Address_1</td></tr>");	
							print("<tr><td><hr noshade></td></tr>");
							}
							else
							{
							print("<tr><td align='left'>$row3->notify_name<br>$row3->Address_1</td></tr>");	
							print("<tr><td><hr noshade></td></tr>");
							}
						}
						mysql_free_result($result3);	
						
					?>
					
					<tr><td><?php print($row->NotifyDesc); ?></td></tr>
					</table>
					
					</td>
					
					<td valign="top"><?php if($row->Bill_of_Entry_No) print($row->Bill_of_Entry_No); else print("&nbsp;"); ?></td>
					<td valign="top"><?php if($row->Bill_of_Entry_Date) print($row->Bill_of_Entry_Date); else print("&nbsp;"); ?></td>
					<td valign="top"><?php if($row->No_of_Pack_Delivered) print($row->No_of_Pack_Delivered); else print("&nbsp;"); ?></td>
					<td valign="top"><?php if($row->No_of_Pack_Discharged) print($row->No_of_Pack_Discharged); else print("&nbsp;");?></td>
				
					<td align="left" valign="top">
					
					<table width="100%">					
					<?php 
					// load CnF
						
						$result4 = mysql_query("select cnf.id, cnf.igm_sup_detail_id,cnf.CnF_ID_to_be_AccountedFor as CnF_ID_to_be_AccountedFor,(select org.Organization_Name from organization_profiles org where org.id=cnf.CnF_ID_to_be_AccountedFor) as cnf_name,(select org1.Address_1 from organization_profiles org1 where org1.id=cnf.CnF_ID_to_be_AccountedFor) as Address_1 from igm_sup_detail_cnftabs cnf where cnf.igm_sup_detail_id=$row->id");						
						
						while($row4 = mysql_fetch_object($result4)) {
							print("<tr><td align='left'>$row4->cnf_name<br>$row4->Address_1</td></tr>");	
							
							}
						mysql_free_result($result4);	
						
					?>
					</table>
					
					</td>
					
					<td valign="top"><?php if($row->Remarks) print($row->Remarks); else print("&nbsp;"); ?></td>
				
										
										
		
		  </tr>
	  <?php	
			}	

		?></table>
	</TD></TR>
	</TABLE>
<?php
mysql_close($con_cchaportdb);
 if($_POST['options']=='html'){?>		
	</BODY>
</HTML>
<?php }?>
