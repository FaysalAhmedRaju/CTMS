


<?php
/*****************************************************
Developed BY: Sk. Farhad Kamal Jitu
Software Developer
DataSoft Systems Bangladesh Ltd
******************************************************/

$logid=$_SESSION['login_id'];
$sqloffice=mysql_query("select office_code from users where login_id='$logid'");
$rowoffice=mysql_fetch_object($sqloffice);
$off=$rowoffice->office_code;

?>




<br />
<br />
<br />

<table border="0" width="100%">

		<tr class='gridDark'>
		<td>SL</td>
		
		
		<td>Import Rotation No</td><td>Agent</td><td>MLO&nbsp;Code</td><td>Line&nbsp;No.</td><td>B/L&nbsp;Number</td><td>Number/Quantity</td><td>Description</td><td>Marks&nbsp;&&nbsp;Number</td><td>Description&nbsp;Of&nbsp;Goods</td><td>Date&nbsp;Of&nbsp;Entry&nbsp;of&nbsp;Goods</td><td>Net Weight</td><td>Gross Weight</td>

		<td>Container&nbsp;Detail</td>

		<td>Name&nbsp;of&nbsp;the&nbsp;Importers&nbsp;or&nbsp;Clearing&nbsp;Agent</td><td>Importers in B/E </td><td>Bill&nbsp;Of&nbsp;Entry&nbsp;Number</td><td>Bill&nbsp;Of&nbsp;Entry&nbsp;Date</td><td>Delivered</td><td>Discharged</td><td>To&nbsp;be&nbsp;Accounted&nbsp;For</td><td>Port of Shipment</td><td>Remarks</td>




</tr>


		<?php
		//print($row->BL_No);
		
			$i=0;
			
			while ($row = mysql_fetch_object($result)) {
			
			$i=$i+1;
			$typ=$row->igmtyp;
if (($row->amendment_appoved<>1) and ($row->PFstatus=1 or $row->PFstatus=10)) {
		?>
	<?php 
	if($_SESSION['org_Type_id']!="18")
	{	
		if($row->AFR=="BLOCKED" ) {?>
			<tr id="color<?php print($i);?>" name="color<?php print($i);?>" bgcolor='#93FDBD' align="center">
		<?php }

		elseif	($row->deliverbstat=="block"){?>
			<tr id="color<?php print($i);?>" name="color<?php print($i);?>" bgcolor='#FF6633' align="center">
		<?php }
		elseif	($row->int_block=="block"){?>
			<tr id="color<?php print($i);?>" name="color<?php print($i);?>" bgcolor='#B1C264' align="center">
		<?php }
		else 
			{
			?>
			<tr id="color<?php print($i);?>" name="color<?php print($i);?>" class='gridLight'>
		<?php
		}
		}
		
		else 
			{
			?>
			<tr id="color<?php print($i);?>" name="color<?php print($i);?>" class='gridLight'>
		<?php
		} ?>
		
	<?php
		if($typ=="I")
		{
			$str="select cnt.Delivery_Status,cnt.Delivery_Status_date,cnt.Discharged_Status,cnt.off_dock_id,cnt.id as id,cnt.cont_number as cont_number,cnt.cont_size as cont_size,cnt.cont_type as cont_type,cnt.cont_height as cont_height,cnt.cont_status as cont_status,cnt.cont_weight as cont_weight,cnt.cont_seal_number as cont_seal_number,cnt.cont_description as cont_description,cnt.cont_imo as cont_imo,cnt.cont_un as cont_un from igm_detail_container cnt where cnt.igm_detail_id=$row->id";
		}
		else if($typ=="S")
		{
			$str="select cnt.Delivery_Status,cnt.Delivery_Status_date,cnt.Discharged_Status,cnt.off_dock_id,cnt.id as id,cnt.cont_number as cont_number,cnt.cont_size as cont_size,cnt.cont_type as cont_type,cnt.cont_height as cont_height,cnt.cont_status as cont_status,cnt.cont_weight as cont_weight,cnt.cont_seal_number as cont_seal_number,cnt.cont_description as cont_description,cnt.cont_imo as cont_imo,cnt.cont_un as cont_un from igm_sup_detail_container cnt where cnt.igm_sup_detail_id=$row->id";
		}
		
		//print($str);
		$result1 = mysql_query($str);
		$con_num_row=mysql_num_rows($result1);
		?>
		<td><?php print($i); ?></td>
		<td><?php print($row->Import_Rotation_No); ?></td>
		<td><?php print($row->Organization_Name); ?></td>
		<td><?php print($row->mlocode); ?></td>
		<td><?php print($row->Line_No); ?></td>
		<td><?php print($row->BL_No); ?></td>
		<td><?php print($row->Pack_Number); ?></td>
		<td><?php print($row->Pack_Description); ?></td>
		<td><?php print($row->Pack_Marks_Number); ?></td>
		<td><?php print($row->Description_of_Goods); ?></td>
		<td><?php print($row->Date_of_Entry_of_Goods); ?></td>
		<td><?php print($row->net_weight); ?>&nbsp;<?php print($row->net_weight_unit); ?></td>
		<td ><?php print($row->weight); ?>&nbsp;<?php print($row->weight_unit); ?></td>
		<td>
				<table width="100%">
					<tr><td>Cnt.&nbsp;Number</td><td>Seal&nbsp;Number</td><td>Size</td><td>Type</td><td>Height</td><td>Weight</td><td>Status</td><td>IMCO</td><td>UN</td><td>Deliver</td><td>Discharge</td><td>Offdock ID</td><td>Action</td></tr>
					<?php 
											
						while($row1 = mysql_fetch_object($result1)) {
							?><tr><td><?php print($row1->cont_number)?></td>
							<td><?php print($row1->cont_seal_number)?></td>
							<td><?php print($row1->cont_size)?></td>
							<td><?php print($row1->cont_type)?></td>
							<td><?php print($row1->cont_height)?></td>
							<td><?php print($row1->cont_weight)?></td>
							<td><?php print($row1->cont_status)?></td>
							<td><?php print($row1->cont_imo)?></td>
							<td><?php print($row1->cont_un)?></td>
							<td><?php if($row1->Delivery_Status==1)print("Yes"); else print ("No"); ?></td>
							<td><?php if($row1->Discharged_Status==1)print("Yes"); else print ("No");?></td>
							<td>
							<?php 
								$sql_offdock=mysql_query("select Organization_Name from organization_profiles where id='$row1->off_dock_id'");
								$row_offdock=mysql_fetch_object($sql_offdock);
								print($row_offdock->Organization_Name);
							?></td>
							<td >
								<?php 
								
								if($row1->Delivery_Status==1) {
								print("<font color=blue size=2>Status: Delivered <br> Date: ".$row1->Delivery_Status_date."</font>");
								
								 } else { ?>
								<a href="../searchcontainerlocation.php?cont=<?php print($row1->cont_number); ?>" target="_blank"><color="blue">Location</font></a>
								<?php  } ?>
								</td>

							</tr>	
							
							<?php
							print("<tr><td colspan='4'><hr noshade></td></tr>");
						}
						mysql_free_result($result1);	
						
					?>					
					</table>
					
					</td>
					
		
					
		
		
		<td>
		
		<table width="100%">
					<tr><th align="left">Consignee</th></tr>
					<?php 
					// load consignee
						
				if($typ=="I"){
						
							$result2 = mysql_query("select cons.id,cons.igm_detail_id,cons.Consignee_ID,(select org.Organization_Name from organization_profiles org where org.id=cons.Consignee_ID) as consignee_name,(select org1.Address_1 from organization_profiles org1 where org1.id=cons.Consignee_ID) as Address_1,cons.ff_clearance as ff_clearance from igm_detail_consigneetabs cons where cons.igm_detail_id=$row->id");						
						}
					else if($typ=="S")
					{
					//$str="select cnt.id as id,cnt.cont_number as cont_number,cnt.cont_size as cont_size,cnt.cont_type as cont_type,cnt.cont_height as cont_height,cnt.cont_status as cont_status,cnt.cont_weight as cont_weight,cnt.cont_seal_number as cont_seal_number,cnt.cont_description as cont_description,cnt.cont_imo as cont_imo,cnt.cont_un as cont_un from igm_sup_detail_container cnt where cnt.igm_sup_detail_id=$row->id";
						$result2 = mysql_query("select cons.id,cons.igm_sup_detail_id,cons.Consignee_ID,(select org.Organization_Name from organization_profiles org where org.id=cons.Consignee_ID) as consignee_name,(select org1.Address_1 from organization_profiles org1 where org1.id=cons.Consignee_ID) as Address_1,cons.ff_clearance as ff_clearance from igm_sup_detail_consigneetabs cons where cons.igm_sup_detail_id=$row->id");						
					}
						
						
						
						
						
					
						
						
						
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
					
					<tr><td valign="top"><?php print($row->ConsigneeDesc); ?></td></tr>
					
					<tr><th align="left">Notify Party</th></tr>
					
					<?php 
					// load notify
						
						if($typ=="I"){
						
						$result3 = mysql_query("select notf.id,notf.igm_detail_id,notf.Notify_ID,(select org.Organization_Name from organization_profiles org where org.id=notf.Notify_ID) as notify_name,(select org1.Address_1 from organization_profiles org1 where org1.id=notf.Notify_ID) as Address_1,notf.ff_clearance as ff_clearance from igm_detail_notifytabs notf where notf.igm_detail_id=$row->id");						
						}
					else if($typ=="S")
					{
					$result3 = mysql_query("select notf.id,notf.igm_sup_detail_id,notf.Notify_ID,(select org.Organization_Name from organization_profiles org where org.id=notf.Notify_ID) as notify_name,(select org1.Address_1 from organization_profiles org1 where org1.id=notf.Notify_ID) as Address_1,notf.ff_clearance as ff_clearance from igm_sup_detail_notifytabs notf where notf.igm_sup_detail_id=$row->id");						
					}					
						
						while($row3 = mysql_fetch_object($result3)) {
							
							if($_SESSION['org_id']==$row3->Notify_ID)
							{
								if($row3->ff_clearance==1)
								{
								print("<tr><td class='notifyHighLight'><a href='home.php?myflag=324&CODE=$row->IGM_id&SubCODE=$row->id&ImpRot=$row->Import_Rotation_No&MLine=$row->Line_No&MBL=$row->BL_No&TM=$this->TM&SFlag=0' target='upper_top'>$row3->notify_name<br>$row3->Address_1</a></td></tr>");	
								print("<tr><td><hr noshade></td></tr>");
								}
								else
								{
								$altm='javascript:alert("You need clearance to submit Supplementary IGM")';
								print("<tr><td class='notifyHighLight'><a href='$altm' target='upper_top'>$row3->notify_name<br>$row3->Address_1</a></td></tr>");	
								print("<tr><td><hr noshade></td></tr>");								
								}
							}
							else
							{
							print("<tr><td align='left'>$row3->notify_name<br>$row3->Address_1</td></tr>");	
							print("<tr><td><hr noshade></td></tr>");
							}
						}
						mysql_free_result($result3);	
						
					?>
					
					<tr><td valign="top"><?php print($row->NotifyDesc); ?></td></tr>
					</table>
					
					</td>
		
		<td>
		<?php
						
						if($row_consignee->SAD_CONSIGNEE)
								{
									$sql_consignee=mysql_query("select CMP_NAM,
									concat(CMP_ADR,ifnull(CMP_AD2,' '),ifnull(CMP_AD3,' '),ifnull(CMP_AD4,' ')) as address 
									from uncmptab where CMP_COD='$row_consignee->SAD_CONSIGNEE'");

									/*print("select CMP_NAM,
									concat(CMP_ADR,ifnull(CMP_AD2,' '),ifnull(CMP_AD3,' '),ifnull(CMP_AD4,' ')) as address 
									from uncmptab where CMP_COD='$row_consignee->SAD_CONSIGNEE'");*/


									$row_consignee=mysql_fetch_object($sql_consignee);
									
									$bin_name=$row_consignee->CMP_NAM;
									$bin_add=$row_consignee->address;
								}
								else if($row_consignee->SAD_CONSIGNEE="" and $row_consignee->SAD_TYP_DEC=="IM")
								{
									$sql_consignee=mysql_query("select SAD_CON_NAM as CMP_NAM,concat(SAD_CON_ADD1,SAD_CON_ADD2) as address 
									from sad_occ_cns where SAD_GEN_id=$id");

									/*print("select SAD_CON_NAM as CMP_NAM,concat(SAD_CON_ADD1,SAD_CON_ADD2) as address 
									from sad_occ_cns where SAD_GEN_id=$id");*/

									$row_consignee=mysql_fetch_object($sql_consignee);
									
									$bin_name=$row_consignee->CMP_NAM;
									$bin_add=$row_consignee->address;
								}
					 print($bin_name."<br>".$bin_add);
						?>
						</td>
		
		
		
		
		<td valign="center"><a href='Forms/myBillEntryImportReportHTML.php?reg=<?php print($row->Bill_of_Entry_No);?>&date=<?php print($row->Bill_of_Entry_Date);?>&code=<?php print($row->office_code);?>' target="aboutblank"><?php print($row->Bill_of_Entry_No); ?></a></td>

		<!--<td><?php print($row->Bill_of_Entry_No); ?></td>-->
		<td><?php print($row->Bill_of_Entry_Date); ?></td>
		<td><?php print($row->No_of_Pack_Delivered); ?></td>
		<td><?php print($row->No_of_Pack_Discharged); ?></td>
		<td>
		<table width="100%">					
					<?php 
					// load CnF
						if($typ=="I"){
						$result4 = mysql_query("select cnf.id,cnf.igm_detail_id,cnf.CnF_ID_to_be_AccountedFor as CnF_ID_to_be_AccountedFor,(select org.Organization_Name from organization_profiles org where org.id=cnf.CnF_ID_to_be_AccountedFor) as cnf_name,(select org1.Address_1 from organization_profiles org1 where org1.id=cnf.CnF_ID_to_be_AccountedFor) as Address_1 from igm_detail_cnftabs cnf where cnf.igm_detail_id=$row->id");						
						}
					else if($typ=="S")
					{
					$result4 = mysql_query("select cnf.id,cnf.igm_sup_detail_id,cnf.CnF_ID_to_be_AccountedFor as CnF_ID_to_be_AccountedFor,(select org.Organization_Name from organization_profiles org where org.id=cnf.CnF_ID_to_be_AccountedFor) as cnf_name,(select org1.Address_1 from organization_profiles org1 where org1.id=cnf.CnF_ID_to_be_AccountedFor) as Address_1 from igm_sup_detail_cnftabs cnf where cnf.igm_sup_detail_id=$row->id");						
					}
					
						while($row4 = mysql_fetch_object($result4)) {
							
							if($_SESSION['org_id']==$row4->CnF_ID_to_be_AccountedFor)
							{
							print("<tr><td class='cnfHighLight'><a href='home.php?myflag=180&CODE=$row4->CnF_ID_to_be_AccountedFor&TM=$this->TM&SubCODE=$row->id&ImpRot=$row->Import_Rotation_No&MLine=$row->Line_No&MBL=$row->BL_No&TABINDX=0'>$row4->cnf_name<br>$row4->Address_1</a></td></tr>");
							}
							else
							{
							print("$row4->cnf_name<br>$row4->Address_1</td></tr>");	
							}
							print("<tr><td><hr noshade></td></tr>");
						}
						mysql_free_result($result4);	
						
					?>
					</table>
					
					</td>
		
		
		<td>
		<?php  
		$sqligmmaster=mysql_query("select Port_of_Shipment from igm_masters where Import_Rotation_No='$row->Import_Rotation_No'");
		$rowigmmaster=mysql_fetch_object($sqligmmaster);	

		print($rowigmmaster->Port_of_Shipment); ?></td>
		<td><?php print($row->Remarks); ?></td>
		
		


<?php 

	//print ($row->deliverbstat);
	/*if($row->igm_detail_id=="") {
	if($row->deliverbstat == "Open") {
?>

<td>
<?php print("Status : Open <hr>"); ?>
 <a href='home.php?myflag=1066&CODE=<?php print($row->IGM_id); ?>&SubCODE=<?php print($row->id); ?>&ImpRot=<?php print($row->Import_Rotation_No); ?>&MLine=<?php print($row->Line_No); ?>&MBL=<?php print($row->BL_No); ?>&TM=<?php print($row->type_of_igm); ?>&deliverbstat=<?php print($row->deliverbstat); ?>&AFO=<?php print($off)?>&igm_type=<?php print($this->igm); ?>' target='upper_top'>
Click Here to Block this IGM</a>
</td>
<?php }  ?>

<?php if ($row->deliverbstat == "block") {
print ($row->deliverbstat) ;
?>
<td>
<?php print("Status : Block <hr>"); ?>
<a href='home.php?myflag=1066&CODE=<?php print($row->IGM_id); ?>&SubCODE=<?php print($row->id); ?>&ImpRot=<?php print($row->Import_Rotation_No); ?>&MLine=<?php print($row->Line_No); ?>&MBL=<?php print($row->BL_No); ?>&TM=<?php print($row->type_of_igm); ?>&deliverbstat=<?php print($row->deliverbstat); ?>&AFO=<?php print($off)?>&igm_type=<?php print($this->igm); ?>' target='upper_top'>
Click Here to Open this IGM</a>
  </td>
<?php } 
}else {

if($row->deliverbstat == "Open") {
 ?>
 <td>
<?php print("Status : Open <hr>"); ?>
 <a href='home.php?myflag=3033&MCODE=<?php print($row->id);?>&deliverbstat=<?php print($row->deliverbstat); ?>&ImpRot=<?php print($row->Import_Rotation_No); ?>&MSLine=<?php print($row->Line_No); ?>&TM=<?php print($row->type_of_igm); ?>&AFO=<?php print($off)?>&SubCODE=<?php print($row->igm_detail_id); ?>&CODE=<?php print($row->IGM_id); ?>&igm_type=<?php print($this->igm); ?>' target='upper_top'>
Click Here to Block this IGM</a>  </td>
<?php }  ?>

<?php if ($row->deliverbstat == "block") {
print ($row->deliverbstat) ;
?>
<td>
<?php print("Status : Block <hr>"); ?>
<a href='home.php?myflag=3033&MCODE=<?php print($row->id);?>&deliverbstat=<?php print($row->deliverbstat); ?>&ImpRot=<?php print($row->Import_Rotation_No); ?>&MSLine=<?php print($row->Line_No); ?>&TM=<?php print($row->type_of_igm); ?>&AFO=<?php print($off)?>&SubCODE=<?php print($row->igm_detail_id); ?>&CODE=<?php print($row->IGM_id); ?>&igm_type=<?php print($this->igm); ?>' target='upper_top'>
Click Here to Open this IGM</a>  </td>
<?php 
}
}*/ ?>

		
		</tr>
		<?php
		}
		}
		
		?>
		
		
		
		
		</table>

<?php

	//	include_once("myPageCreate.php");
	//	$myform = new myPageCreate();
	//	$myform->myListPage("$mySQL","home.php?myflag=139&impno=$this->impno&options=$this->igm");
		
?>

