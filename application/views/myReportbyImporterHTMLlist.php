<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>IGM Import Manifest</TITLE>
		<LINK href="../css/report.css" type=text/css rel=stylesheet>
	</HEAD>
	<BODY>
	<?php } else if($_POST['options']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=IGMIMPORTER.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}
	include("mydbPConnection.php");
	//$org_Type_id=$_SESSION['org_Type_id'];
	//$login_id=$_SESSION['login_id'];

	//print($org_Type_id.$login_id."abcd");


	//*********start	

	$description=$_POST['description'];
	$today=date("Y-m-d h:i:s");			
	$from=$_POST['from'];	
	$to=$_POST['to'];
	

    
	$str_vessel=mysql_query("select Vessel_Name,file_clearence_logintime,file_clearence_date,
	final_clerance_files_ref_number from igm_masters where Import_Rotation_No='$import_rotationno'");
	$row_vessel=mysql_fetch_object($str_vessel);
	//print("select Vessel_Name,file_clearence_logintime,file_clearence_date,
	//final_clerance_files_ref_number from igm_masters where Import_Rotation_No='$import_rotationno'");	
	
	/*if(!($org_Type_id=='5' or $org_Type_id=='3' or $org_Type_id=='12'))
	{
		if( $row_vessel->file_clearence_date>"2013-09-02")
		{
			print("<font color='red' size='4'>According to customs decision, you can not view any IGM  after final entry completion from 2013-09-02...</font>");
			//include_once("myCustomDocumentcheckHTML.php");
			break;

		}
	}
	if($org_Type_id=='5')	
	{
	$handle111= fopen('/var/www/html/Message/port_log.txt' , 'a') or exit("Unable to open file!");	
	fwrite(	$handle111,	"\r\n Rottion_no:".$import_rotationno."|"." line_no:".$row->Line_No."|"." File Clearence date: ".$row_vessel->file_clearence_date."|"." Date: ".$today."|"." Link: ".$link." Login_id: ".$login_id."|". "org_Type_id:".$org_Type_id);		
	fclose($handle111); 
	}
*/
	//********end
	if($row_vessel->file_clearence_date=="" or $row_vessel->file_clearence_date>"2013-09-02")
	$awstatus="and final_submit=0";
	else
	$awstatus="";
	
	
		//if($_POST['txt_controlp']==10 or $_POST['txt_controlp']==58 or $_POST['txt_controlp']==63 or $_POST['txt_controlp']==12 or $_POST['txt_controlp']==44){
		$str="select 
								igms.id as id,
								igms.IGM_id as IGM_id,
								igms.Import_Rotation_No as Import_Rotation_No,
								igms.Line_No as Line_No,
								igms.BL_No as BL_No,
								igms.Pack_Number as Pack_Number,
								igms.Pack_Description as Pack_Description,
								igms.Pack_Marks_Number as Pack_Marks_Number,
								igms.Description_of_Goods as Description_of_Goods,
								igms.Date_of_Entry_of_Goods as Date_of_Entry_of_Goods,
								igms.weight as weight,
								igms.weight_unit as weight_unit,
								igms.net_weight as net_weight,
								igms.net_weight_unit as net_weight_unit,
								igms.Bill_of_Entry_No as Bill_of_Entry_No,
								igms.Bill_of_Entry_Date as Bill_of_Entry_Date,
								igms.No_of_Pack_Delivered as No_of_Pack_Delivered,
								igms.No_of_Pack_Discharged as No_of_Pack_Discharged,
								igms.Remarks as Remarks,
								igms.ConsigneeDesc,
								igms.NotifyDesc,
								igms.extra_remarks,
								igms.imco,
								igms.un,
								igms.mlocode,igms.Exporter_name,igms.Exporter_address
							from 
								igm_details igms 
							where 
								upper(igms.NotifyDesc) like upper('%$_POST[description]%') and Submission_Date between '$from' and '$to'
								
								order by id
								";
								$result=mysql_query($str);
					
	
	//print($str);
			
			
?>
	<TABLE border="0">
	<TR><TD width="2113">
		<table align="center">
		<?php 
		$type=substr($_POST[ddl_manifest],0,1);
		if($type!="B")
		{
		?>
			<tr><td style="font-size:22px;" ><b>IGM REPORT CONTAINER</b></td></tr>
			
		<?php
		}
		else
		{
		?>
				<tr><td style="font-size:22px;" ><b>IGM REPORT BREAK BULK</b></td></tr>
		<?php 
		}
		?>
		</table>
	</TD></TR>
	<TR><TD>
		<table width="100%">
		
			
			
		</table>
	</TD></TR>
	<TR>
		<TD>
		
		<td width="10"></TD>
	</TR>
	<TR><TD>
		<table width="100%" border="1" cellpadding=0 cellspacing=0>
		<tr >
			<th>Import Rotation No</th>
			<th>MLO CODE</th>
			<th>Line No.</th>
			<th>B/L Number</th>
			<th>Number</th>
			<th>Description</th>
			<th>Marks & Number</th>
			<th>Description Of Goods</th>
			<th>Date Of Entry of Goods</th>
			<th>Net Weight</th>
			<th>Gross Weight</th>
			<?php
			if($type=="B")
			{
			?>
			<th>Imco</th>
			<th>Un</th>
			<?php } ?>
			<th>Container Detail</th>
			<th>Name of the Importers or Clearing Agent</th>
			<th>Name of the Exporter</th>
			<th>Bill Of Entry Number</th>
			<th>Bill Of Entry Date</th>
			<th>Delivered</th>
			<th>Discharged</th>
			<th>To be Accounted For</th>
			<?php
			if($_POST[ddl_manifest]=="BAMS" OR $_POST[ddl_manifest]=="AMS")
			{
			?>
			<th>Arms,Ammunition and Explosiv</th>
			<?php
			}
			else if($_POST[ddl_manifest]=="BPS" OR $_POST[ddl_manifest]=="PS")
			{
			?>
			<th>Provision and Store Supply</th>
			<?php
			}
			?>
			<th>Remarks</th>
	
		
				
		</tr>

		<?php

			while ($row = mysql_fetch_object($result)) {
		?>
			
			    <tr >
					<td height="96" valign="top"><?php if($row->Import_Rotation_No) print($row->Import_Rotation_No); else print("&nbsp;");?></td>
					<td height="96" valign="top"><?php if($row->mlocode) print($row->mlocode); else print("&nbsp;");?></td>
					<td height="96" valign="top"><?php if($row->Line_No) print($row->Line_No); else print("&nbsp;");?></td>
					<td valign="top"><?php if($row->BL_No) print($row->BL_No); else print("&nbsp;");?></td>
					<td valign="top"><?php if($row->Pack_Number) print($row->Pack_Number); else print("&nbsp;"); ?></td>
					<td valign="top"><?php if($row->Pack_Description) print($row->Pack_Description); else print("&nbsp;");?></td>
					<td valign="top"><?php if($row->Pack_Marks_Number) print($row->Pack_Marks_Number); else print("&nbsp;");?></td>
					<td valign="top"><?php if($row->Description_of_Goods) print($row->Description_of_Goods); else print("&nbsp;") ?></td>
					<td valign="top"><?php if($row->Date_of_Entry_of_Goods) print($row->Date_of_Entry_of_Goods); else print("&nbsp;"); ?></td>
					<td valign="top"><?php if($row->net_weight) print($row->net_weight."&nbsp;".$row->net_weight_unit); else print("&nbsp;"); ?></td>
					<td valign="top"><?php if($row->weight) print($row->weight."&nbsp;".$row->weight_unit); else print("&nbsp;"); ?></td>
					<?php if($type=="B") {?>
					<td valign="top"><?php if($row->imco!="") print($row->imco); else print("&nbsp;"); ?></td>
					<td valign="top"><?php if($row->un!="") print($row->un); else print("&nbsp;"); ?></td>
					<?php }?>
					<td align="left" valign="top">
					
					<table width="100%">
					<tr border="1">
						<th>Off Dock</th>
						<th>Cnt. Number</th>
						<th>Seal Number</th>
						<th>Size</th>
						<th>Type</th>
						<th>Height</th>
						<th>Weight</th>
						<th>Status</th>
						<th>Imco</th>
						<th>Un</th>
					</tr>
					<?php 
					//load container detail
						//print("select cnt.id as id,cnt.cont_number as cont_number,cnt.cont_size as cont_size,cnt.cont_weight as cont_weight,cnt.cont_seal_number as cont_seal_number,cnt.cont_description as cont_description from igm_detail_container cnt where cnt.igm_detail_id=$row->id");
						
						$result1 = mysql_query("select cnt.id as id, cnt.cont_number as cont_number, cnt.cont_size as cont_size,cnt.cont_type as cont_type,cnt.cont_height as cont_height,cnt.cont_status as cont_status,cnt.cont_weight as cont_weight,cnt.cont_seal_number as cont_seal_number,cnt.cont_description as cont_description,cnt.cont_imo as cont_imo, cnt.cont_un as cont_un,Organization_Name from igm_detail_container cnt join organization_profiles org on org.id=cnt.off_dock_id where cnt.igm_detail_id=$row->id");
						
						while($row1 = mysql_fetch_object($result1)) {
							print("<tr>
								<td>$row1->Organization_Name</td>
								<td>$row1->cont_number</td>
								<td>$row1->cont_seal_number</td>
								<td>$row1->cont_size</td>
								<td>$row1->cont_type</td>
								<td>$row1->cont_height</td>
								<td>$row1->cont_weight</td>
								<td>$row1->cont_status</td>
								<td>$row1->cont_imo</td>
								<td>$row1->cont_un</td>
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
						
						$result2 = mysql_query("select cons.id, cons.igm_detail_id,cons.Consignee_ID,(select org.Organization_Name from organization_profiles org where org.id=cons.Consignee_ID) as consignee_name,(select org1.Address_1 from organization_profiles org1 where org1.id=cons.Consignee_ID) as Address_1 from igm_detail_consigneetabs cons where cons.igm_detail_id=$row->id");						
						
						
						
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
						
						$result3 = mysql_query("select notf.id,notf.igm_detail_id,notf.Notify_ID,(select org.Organization_Name from organization_profiles org where org.id=notf.Notify_ID) as notify_name,(select org1.Address_1 from organization_profiles org1 where org1.id=notf.Notify_ID) as Address_1 from igm_detail_notifytabs notf where notf.igm_detail_id=$row->id");						
						
						
						
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
					<td><?php print($row->Exporter_address."<br />".$row->Exporter_address); ?></td>
					<td valign="top"><?php if($row->Bill_of_Entry_No) print($row->Bill_of_Entry_No); else print("&nbsp;"); ?></td>
					<td valign="top"><?php if($row->Bill_of_Entry_Date) print($row->Bill_of_Entry_Date); else print("&nbsp;"); ?></td>
					<td valign="top"><?php if($row->No_of_Pack_Delivered) print($row->No_of_Pack_Delivered); else print("&nbsp;"); ?></td>
					<td valign="top"><?php if($row->No_of_Pack_Discharged) print($row->No_of_Pack_Discharged); else print("&nbsp;");?></td>
				
					<td align="left" valign="top">
					
					<table width="100%">					
					<?php 
					// load CnF
						
						$result4 = mysql_query("select cnf.id, cnf.igm_detail_id,cnf.CnF_ID_to_be_AccountedFor as CnF_ID_to_be_AccountedFor,(select org.Organization_Name from organization_profiles org where org.id=cnf.CnF_ID_to_be_AccountedFor) as cnf_name,(select org1.Address_1 from organization_profiles org1 where org1.id=cnf.CnF_ID_to_be_AccountedFor) as Address_1 from igm_detail_cnftabs cnf where cnf.igm_detail_id=$row->id");						
						
						while($row4 = mysql_fetch_object($result4)) {
							print("<tr><td align='left'>$row4->cnf_name<br>$row4->Address_1</td></tr>");	
							
							}
						mysql_free_result($result4);	
						
					?>
					</table>
					
					</td>
					
					<?php
					if($_POST[ddl_manifest]=="BAMS" or $_POST[ddl_manifest]=="BPS" or $_POST[ddl_manifest]=="AMS" or $_POST[ddl_manifest]=="PS")
					{
					?>
						<td valign="top"><?php if($row->extra_remarks) print($row->extra_remarks); else print("&nbsp;"); ?></td>
					<?php
					}
					?>
					
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
