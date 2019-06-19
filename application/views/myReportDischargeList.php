<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>Discharge Manifest</TITLE>
		<LINK href="../css/report.css" type=text/css rel=stylesheet>
	</HEAD>
	<BODY>
	<?php } else if($_POST['options']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=IGM Import General Manifest.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}




	
	

include("mydbPConnection.php");
	$from=$_GET['igm_no'];
	$orgid=$_GET['org_id'];
	//echo "$orgid";
	$rotation=mysql_query("select Import_Rotation_No from igm_details where IGM_id='$from'");
	//$rowinp=mysql_fetch_object($rotation);
	//$import=$rowinp->Import_Rotation_No;
	$import=$_POST[ddl_imp_rot_no];
	//echo $from;
	$txt_org=$_POST[txt_line];
	$mlo=$_POST['ddl_Org_id'];
	
	//AW Update
	/*$sqlmaster=mysql_query("select file_clearence_date from igm_masters where Import_Rotation_No='$_POST[ddl_imp_rot_no]'");
	$rowMaster=mysql_fetch_object($sqlmaster);
	$file_clearence_date=$rowMaster->file_clearence_date;
	if(!($_POST['txt_controlpanel']==10 or $_POST['txt_controlpanel']==44 or $_POST['txt_controlpanel']==12))
	{
		if($file_clearence_date=="" or $file_clearence_date>"2013-09-02")
		{
			print("<font color='red' size='4'>According to customs decision, you can not view any IGM  after final entry completion from 2013-09-02...</font>");
			//include_once("myCustomDocumentcheckHTML.php");
			break;

		}
	}
	*/
	//AW Update
	
if($_POST['txt_line']=="all")
{

$str1="select igm_details.submitee_Org_id,igm_details.id,mlocode,igm_details.Line_No,igm_details.BL_No,
Bill_of_Entry_No,igm_details.Bill_of_Entry_Date,igm_details.Remarks, replace(igm_detail_container.cont_number,' ','') 
as cont_number,igm_detail_container.cont_size,igm_detail_container.cont_height,igm_detail_container.cont_weight,
igm_detail_container.cont_imo, igm_detail_container.cont_un,igm_details.type_of_igm, igm_detail_container.cont_type,
igm_detail_container.cont_status,igm_details.weight,igm_details.weight_unit, igm_details.net_weight,
igm_details.net_weight_unit, igm_detail_container.cont_seal_number,igm_detail_container.off_dock_id, 
igm_detail_container.commudity_code,commudity_desc,igm_detail_container.cont_vat,Description_of_Goods,Pack_Marks_Number,
Pack_Number,Pack_Description, igm_detail_container.cont_gross_weight,Agent_code,Exporter_name,Exporter_address,
place_of_unloading,port_of_origin from igm_details inner join organization_profiles on igm_details.submitee_Org_id = organization_profiles.id 
inner join igm_detail_container on igm_details.id=igm_detail_container.igm_detail_id 
left join commudity_detail on igm_detail_container.commudity_code=commudity_detail.commudity_code 
where igm_details.Import_Rotation_No='$import' and igm_details.final_submit=1 


";
}
else
{	
			
$str1="select igm_details.submitee_Org_id,igm_details.id,mlocode,igm_details.Line_No,igm_details.BL_No,Bill_of_Entry_No,
igm_details.Bill_of_Entry_Date,igm_details.Remarks, replace(igm_detail_container.cont_number,' ','') as cont_number,
igm_detail_container.cont_size,igm_detail_container.cont_height,igm_detail_container.cont_weight,igm_detail_container.cont_imo,
 igm_detail_container.cont_un,igm_details.type_of_igm, igm_detail_container.cont_type,igm_detail_container.cont_status,
 igm_details.weight,igm_details.weight_unit, igm_details.net_weight,igm_details.net_weight_unit, 
 igm_detail_container.cont_seal_number,igm_detail_container.off_dock_id, igm_detail_container.commudity_code,
 commudity_desc,igm_detail_container.cont_vat,Description_of_Goods,Pack_Marks_Number,Pack_Number,Pack_Description, 
 igm_detail_container.cont_gross_weight,Agent_code,Exporter_name,Exporter_address,place_of_unloading,port_of_origin from igm_details 
 inner join organization_profiles on igm_details.submitee_Org_id = organization_profiles.id 
 inner join igm_detail_container on igm_details.id=igm_detail_container.igm_detail_id 
 left join commudity_detail on igm_detail_container.commudity_code=commudity_detail.commudity_code 
 where igm_details.Import_Rotation_No='$import' and igm_details.Submitee_Org_Id=$txt_org and igm_details.final_submit=1 
 and mlocode='$mlo' and igm_details.type_of_igm<>'ROB'

";


}                    
					
					//print $str1;
					//print $str1;
				   $result1=mysql_query($str1);
				  $sl=1;
								
					
		?>
			
		<TABLE width="100%">
			<TR><TD width="100%">
				<table class='table-header' border=0 width="100%">
				
				
					<tr><td colspan="2" align="center"><h1> DISCHARGE LIST  </h1></td></tr>
					<tr>
						
							<?php
							$result_now=mysql_query("SELECT NOW() as datetime");
							$row_now=mysql_fetch_object($result_now);
							$time=substr($row_now->datetime,10);
							$day=substr($row_now->datetime,0,10);
						$result_igm_master=mysql_query("SELECT
												Import_Rotation_No,
												igm_masters.Vessel_Name,
												Voy_No,
												Net_Tonnage,
												Port_of_Shipment,
												Port_of_Destination,
												Sailed_Year,
												Submitee_Org_Id,
												Name_of_Master,
												Organization_Name,
												Submitee_Org_Type,
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
												igm_masters.Import_Rotation_No='$import' 
												
											");
		
			if($result_igm_master)
			$row_igm_master=mysql_fetch_object($result_igm_master);	
							$str="SELECT organization_Name from organization_profiles where id='$_POST[txt_org]' or id='$orgid'";
			//print $str;
			$result_org_name=mysql_query($str);
			$row_org_name=mysql_fetch_object($result_org_name);
			$str1=mysql_query("select ETA_Date,ETD_Date,Actual_Berth,Actual_Berth_time from vessels_berth_detail
									where Import_Rotation_No='$import'");
$row_time=mysql_fetch_object($str1);
			$sl=1;
		?>
		<table>
			
		
			
				<tr><td>&nbsp;</td><td>&nbsp;</td>
					<td align="center">Vessel name:</td><td><?php print($row_igm_master->Vessel_Name);?></td>
					<td align="center">Voy. No.:</th><td><?php print($row_igm_master->Voy_No);?></td>
					
					</tr>
					<tr><td>&nbsp;</td><td>&nbsp;</td>
					<td align="center">Rotation No:&nbsp;&nbsp;<?php print($row_igm_master->Import_Rotation_No);?></td></tr>
					<tr>
					<td>&nbsp;</td><td>&nbsp;</td><td align="right"><b>Agent:&nbsp;<?php print($row_org_name->organization_Name);?></b></td>
				
					<td align="center"><b> Shipping Line:&nbsp;<?php print($row_igm_master->Organization_Name);?></b></td>
					
					<tr><td>&nbsp;</td>
					<tr>
					<td align="left">ETA:<?php print($row_time->ETA_Date);?></td>
						
					
					<td align="left">ETD<?php print($row_time->ETD_Date);?></td>
					</tr>
				<tr>
					<td align="left">ATA:<?php print($row_time->Actual_Berth);?></td>
						
					
					<td align="left">ATD:<?php print($row_time->Actual_Berth_time);?></td>
					</tr>
					<!--<th>Net Tonnage</th>-->
					
			
					
						
				</table>
		
						</td>
						<td align="right"><b>Date:</b><?php print($day);?></td>
						
					</tr>
					<tr>
					<td align="right"><b>Time:</b><?php print($time);?></td>
					</tr>
				</table>
			</TD></TR>
			<TR><TD>
					<table width="100%" border=1  cellspacing="0" cellpadding="0">
					<tr>
							<th><span class="style1">Rotation No</span></th>
							<th><span class="style1">Agent Code</span></th>
							<th><span class="style1">MLO Code</span></th>
							<th><span class="style1">Line No</span></th>
							<th><span class="style1">B/L No</span></th>
							<th><span class="style1">Description of Goods </span></th>
							<th><span class="style1">Exporter Name & Address</span></th>
							<th><span class="style1">Port of Origin/Loading Port</span></th>
							<th><span class="style1">Place of Unloading</span></th>
							<th><span class="style1">Marks & Number</span></th>
							<th><span class="style1">No. of Packages</span></th>
							<th><span class="style1">Unit</span></th>
							<th><span class="style1">BILL Of Entry No </span></th>
							<th><span class="style1">BILL Of Entry Date</span></th>
						    <th><span class="style1">BIN No</span></th>
							<th><span class="style1">Continer Number</span></th>
							<th><span class="style1">Container Size</span></th>
							<th><span class="style1">Container Height</span></th>
							
							
							
							<th><span class="style1">Container Type</span></th>
							<th><span class="style1">Container Status</span></th>
							<th><span class="style1">Container IMDG Code</span></th>
							<th><span class="style1">Container UN Code</span></th>
							<th><span class="style1">Gross Weight</span></th>
							<th><span class="style1">Gross Weight Unit</span></th>
							<th><span class="style1">Net Weight</span></th>
							<th><span class="style1">Net Weight Unit</span></th>
							<th><span class="style1">MLO Navy Comments</span></th>
							<th><span class="style1">FF Code</span></th>
							<th><span class="style1">Line No</span></th>
							<th><span class="style1">B/L No</span></th>
							<th><span class="style1">Description of Goods </span></th>
							<th><span class="style1">Marks & Number</span></th>
							<th><span class="style1">No. of Packages</span></th>
							<th><span class="style1">Unit</span></th>
							<th><span class="style1">Container Actual Status</span></th>
							<th><span class="style1">Gross Weight</span></th>
							<th><span class="style1">Gross Weight Unit</span></th>
							<th><span class="style1">FF Navy Comments</span></th>	
							<th align="center"><span class="style1">Seal Number</span></th>
							<th><span class="style1">Port of Origin Transhipment<br>(Port of Loading)</span></th>
							<th><span class="style1">Stowinstr Indicator Special cont</span></th>
							<th><span class="style1">Port / ICD / Offdock/TS</span></th>
							
							<th><span class="style1">Commodity Code</span></th>
							
							<th><span class="style1">Container Vat</span></th>
							<th><span class="style1">Remarks</span></th>
							
							<th><span class="style1">Sl No</span></th>
							
							
					</tr>
					
						<tr>
							<?php 
							$prev_line="";
							$prev_ln_line="";
							while($row1=mysql_fetch_object($result1)){ 
						if ($row1->Bill_of_Entry_No)
{
$sad_reg_nber=substr($row1->Bill_of_Entry_No,1);
							$bin=mysql_query("select  SAD_CONSIGNEE,SAD_DECLARANT from sad_gen_informations where SAD_REG_NBER='$sad_reg_nber' 
and SAD_REG_DATE='$row1->Bill_of_Entry_Date'");
$rowbin=mysql_fetch_object($bin);
}

							$str5="select navyresponse.response_details1,navyresponse.response_details2,navyresponse.response_details3,navyresponse.hold_application,
navyresponse.rejected_application,navyresponse.final_amendment from igm_navy_response navyresponse inner join  igm_details igms on igms.id=navyresponse.igm_details_id where igms.id = $row1->id";
					  		

							$navy=mysql_query($str5);
						$rownavy=mysql_fetch_object($navy);	


							?>
					
					  <tr>
					  <td align="center"><?php print($import); ?>
					  <td  align="center">
						<?php 

						$sql_agent_code=mysql_query("select mlo_agent_code_ctms from mlo_detail 
						where org_id='$row1->submitee_Org_id' and mlocode='$row1->mlocode'");
						$row_agent_code=mysql_fetch_object($sql_agent_code);

						
						if($row_agent_code->mlo_agent_code_ctms) print(strtoupper($row_agent_code->mlo_agent_code_ctms)); else print("&nbsp;");
						?>
					  </td>
					  <td  align="center"><?php $mlopart=substr("$row1->mlocode",0,3); if($row1->mlocode) print(strtoupper($mlopart)); else print("&nbsp;"); ?></td>
					  <td  align="center"><?php if($row1->Line_No)  print(strtoupper($row1->Line_No)); else print("&nbsp;"); ?></td>
					  <td  align="center"><?php if($row1->BL_No) print(strtoupper($row1->BL_No)); else print("&nbsp;");?></td>
                      <td  align="center"><?php if($row1->Description_of_Goods) print(strtoupper($row1->Description_of_Goods)); else print("&nbsp;");?></td>
                      <td  align="center"><?php print($row1->Exporter_name."<br>".$row1->Exporter_address);?></td>
					  <td  align="center"><?php print($row1->port_of_origin);?></td>
					  <td  align="center"><?php print($row1->place_of_unloading);?></td>
					  <td  align="center"><?php if($row1->Pack_Marks_Number) print(substr($row1->Pack_Marks_Number,0,3000)); else print("&nbsp;");?></td>
                     <td  align="center"><?php if($row1->Pack_Number) print(strtoupper($row1->Pack_Number)); else print("&nbsp;");?></td>
                     <td  align="center"><?php if($row1->Pack_Description) print(strtoupper($row1->Pack_Description)); else print("&nbsp;");?></td>
					  <td  align="center"><?php if($row1->Bill_of_Entry_No) print($row1->Bill_of_Entry_No); else print("&nbsp;");?></td>
					  <td  align="center"><?php if($row1->Bill_of_Entry_Date) print($row1->Bill_of_Entry_Date); else print("&nbsp;");?></td>
					  <td  align="center"><?php if($rowbin->SAD_CONSIGNEE) print(strtoupper($rowbin->SAD_CONSIGNEE)); else print("&nbsp;");?></td>
					  <td  align="center"><?php if($row1->cont_number) print(strtoupper($row1->cont_number)); else print("&nbsp;");?></td>
					  <td  align="center"><?php if($row1->cont_size)  print($row1->cont_size); else print("&nbsp;"); ?></td>
					  <td  align="center"><?php if($row1->cont_height!=806 or $row1->cont_height!=906)  print($row1->cont_height); else if($row1->cont_height==806) print("8.6"); else if($row1->cont_height==906) print("9.6"); else print("&nbsp;"); ?></td>
					  <td  align="center"><?php if(strtoupper($row1->cont_type)=='OPEN TOP') print("O-T"); else if(strtoupper($row1->cont_type)=='FLAT RACK') print("F-R"); else if(strtoupper($row1->cont_type)=='REEFER') print("REF"); else if(strtoupper($row1->cont_type)=='INSULATED') print("INS"); else if(strtoupper($row1->cont_type)=='HARD TOP') print("H-T"); else if(strtoupper($row1->cont_type)=='OPEN SIDE') print("O-S"); else print(strtoupper($row1->cont_type)); ?></td>
					  <td  align="center"><?php if(strtoupper($row1->cont_status)=='EMPTY') print("EMT"); else if(strtoupper($row1->cont_status)=='TRANSHIPMENT LOAD') print("TSL"); else if(strtoupper($row1->cont_status)=='TRANSHIPMENT EMPTY') print("TSE"); else if($row1->cont_status=='') print("&nbsp;"); else { $status=explode("/",$row1->cont_status); print($status[0]); } ?></td>
					  <td  align="center"><?php if($row1->cont_imo) print(strtoupper($row1->cont_imo)); else print("&nbsp;");?></td>
					  <td  align="center"><?php if($row1->cont_un) print(strtoupper($row1->cont_un)); else print("&nbsp");?></td>
					  <td  align="center">
					  <?php 
					  if($row1->cont_status=="MT" or $row1->cont_status=="EMT" or $row1->cont_status=="EMPTY" or $row1->cont_status=="MTY")
					  {
						if($row1->cont_weight) print($row1->cont_weight); else print("&nbsp;");
					  }
					  else
					  {
					  if($row1->cont_gross_weight) {print($row1->cont_gross_weight+$row1->cont_weight);} else print("&nbsp;");
					  }
					  ?></td>
					  
					  <td  align="center"><?php if($row1->weight_unit)  print(strtoupper($row1->weight_unit)); else print("&nbsp;"); ?></td>
					  <td  align="center">
					  <?php 
					  if($row1->cont_status=="MT" or $row1->cont_status=="EMT" or $row1->cont_status=="EMPTY" or $row1->cont_status=="MTY")
					  {
						if($row1->cont_weight) print($row1->cont_weight); else print("&nbsp;");
					  }
					  else
					  {
					  if($row1->cont_gross_weight)  print($row1->cont_gross_weight); else print("&nbsp;"); 
					  } ?></td>
					  <td  align="center"><?php if($row1->weight_unit) print(strtoupper($row1->weight_unit)); else print("&nbsp;");?></td>
	<td  align="center"><?php 
						if($rownavy->final_amendment==2){ 
							print("Lab Com: ".$rownavy->response_details1."/".
							"NAIO:".$rownavy->response_details2."/ hold:".$rownavy->hold_application); 
						}
						else if($rownavy->final_amendment==3){
							print("Lab Com: ".$rownavy->response_details1."/".
							"NAIO:".$rownavy->response_details2."/ Rejected:".$rownavy->rejected_application); 
						}
						else if($rownavy->final_amendment==1){
							print("Lab Com: ".$rownavy->response_details1."/".
							"NAIO:".$rownavy->response_details2."/ Finally:".$rownavy->response_details3); 
						}
						else print("&nbsp;");?>
					</td>
					  <?php 
					  
						$str2="
				                select igm_supplimentary_detail.Submitee_Org_Id as Submitee_Org_Id,igm_supplimentary_detail.Line_No as sLine_no, 
								igm_supplimentary_detail.BL_No as s_BL_no,Pack_Marks_Number,Description_of_Goods,Pack_Number,Pack_Description,
								igm_sup_detail_container.cont_status as s_cont_status,igm_sup_detail_container.cont_status ,igm_sup_detail_container.cont_weight,
								igm_sup_detail_container.cont_imo,igm_sup_detail_container.cont_un,
								igm_supplimentary_detail.weight as weight,igm_supplimentary_detail.weight_unit,
								igm_supplimentary_detail.net_weight,igm_supplimentary_detail.net_weight_unit
								from igm_supplimentary_detail
								left join 
								igm_sup_detail_container on igm_supplimentary_detail.id=igm_sup_detail_container.igm_sup_detail_id
								where 
								igm_supplimentary_detail.igm_detail_id='$row1->id' and 
								replace(igm_sup_detail_container.cont_number,' ','')='$row1->cont_number' and  igm_supplimentary_detail.final_submit=1";
							
							//print($str2);
					    $result2=mysql_query($str2);
						$rno=0;
						$num_rows=mysql_num_rows($result2);

						if ($num_rows>0)
					{
						while($row2=mysql_fetch_object($result2))
						{
$str5="select navyresponse.response_details1,navyresponse.response_details2,navyresponse.response_details3,navyresponse.hold_application,
navyresponse.rejected_application,navyresponse.final_amendment from igm_navy_response navyresponse inner join igm_supplimentary_detail igms on igms.id=navyresponse.egm_details_id where igms.id = $row2->id";
$resultnavyff=mysql_query($str5);
$rownavyff = mysql_fetch_object($resultnavyff);
						$result3 = mysql_query("select cons.id, cons.igm_detail_id,cons.Consignee_ID from igm_detail_consigneetabs cons where cons.igm_detail_id=$row1->id");						
						//	print("select cons.id, cons.igm_detail_id,cons.Consignee_ID,(select org.Organization_Name from organization_profiles org where org.id=cons.Consignee_ID) as consignee_name,(select org1.Address_1 from organization_profiles org1 where org1.id=cons.Consignee_ID) as Address_1 from igm_detail_consigneetabs cons where cons.igm_detail_id=$row1->id");
						$row3 = mysql_fetch_object($result3);
						$rno=$rno+1;
						?>
						
						<td   align="center"><?php if($row2->Submitee_Org_Id) print(strtoupper($row2->Submitee_Org_Id)); else print("&nbsp;");?></td>
						<td  align="center"><?php if($row2->sLine_no)  print(strtoupper($row2->sLine_no)); else print("&nbsp;"); ?></td>
						<td  align="center"><?php if($row2->s_BL_no) print(strtoupper($row2->s_BL_no)); else print("&nbsp;");?></td>
						<td  align="center"><?php if($row2->Description_of_Goods) print($row2->Description_of_Goods); else print("&nbsp;");?></td>
						<td  align="center"><?php if($row2->Pack_Marks_Number) print(substr($row2->Pack_Marks_Number,0,3000)); else print("&nbsp;");?></td>
						<td  align="center"><?php if($row2->Pack_Number) print($row2->Pack_Number); else print("&nbsp;");?></td>
						<td  align="center"><?php if($row2->Pack_Description)  print($row2->Pack_Description); else print("&nbsp;");?></td>
						<td  align="center"><?php if($row2->s_cont_status) { $status2=explode("/",$row2->s_cont_status); print($status2[0]); } else print("&nbsp;");?></td>
						  <td  align="center"><?php if($row2->weight) {print($row2->weight);} else print("&nbsp;");?></td>
					  <td  align="center"><?php if($row2->weight_unit)  print($row2->weight_unit); else print("&nbsp;"); ?></td>
<td><?php
if($rownavyff->final_amendment==2){ 
							print("Lab Com: ".$rownavyff->response_details1."/".
							"NAIO:".$rownavyff->response_details2."/ hold:".$rownavyff->hold_application); 
						}
						else if($rownavyff->final_amendment==3){
							print("Lab Com: ".$rownavyff->response_details1."/".
							"NAIO:".$rownavyff->response_details2."/ Rejected:".$rownavyff->rejected_application); 
						}
						else if($rownavyff->final_amendment==1){
							print("Lab Com: ".$rownavyff->response_details1."/".
							"NAIO:".$rownavyff->response_details2."/ Finally:".$rownavyff->response_details3); 
						}
						else print("&nbsp;"); ?>
</td>
					
						<td  align="center"><?php $sealpart=substr($row1->cont_seal_number,0,20); if($row1->cont_seal_number) print($sealpart); else print("&nbsp;");?></td>
					  <td   align="center"><?php if($row_igm_master->Port_of_Shipment) print($row_igm_master->Port_of_Shipment); else print("&nbsp;");?></td>
					  <td   align="center"><?php print("&nbsp;");?></td>
					  <td   align="center"><?php if($row1->type_of_igm <> 'TS') print($row1->off_dock_id); else print("0000");?></td>
					  <td  align="center"><?php if($row1->commudity_desc)  print($row1->commudity_desc); else print("&nbsp;"); ?></td> 
					  
					  
					  <td  align="center"><?php print($row1->cont_vat);?></td>
					  <td  align="center"><?php if($row1->Remarks) print($row1->Remarks); else print("&nbsp;");?></td>
					<td align="center"><?php print($sl);$sl=$sl+1;?></td>	
					


</tr>
					<?php if ($rno < $num_rows) 
					{
					?>
					 <td align="center"><?php print($import); ?>
					 <td  align="center">
					 <?php 
					 
					 $sql_agent_code=mysql_query("select mlo_agent_code_ctms from mlo_detail 
						where org_id='$row1->submitee_Org_id' and mlocode='$row1->mlocode'");
						$row_agent_code=mysql_fetch_object($sql_agent_code);

						if($row_agent_code->mlo_agent_code_ctms) print(strtoupper($row_agent_code->mlo_agent_code_ctms)); else print("&nbsp;");

					 //if($row1->Agent_code) print($row1->Agent_code); else print("&nbsp;");
					 ?>
					 <td  align="center"><?php if($row1->mlocode) print($row1->mlocode); else print("&nbsp;");?></td>
					  <td  align="center"><?php if($row1->Line_No)  print($row1->Line_No); else print("&nbsp;"); ?></td>
					  <td  align="center"><?php if($row1->BL_No) print($row1->BL_No); else print("&nbsp;");?></td>
                      <td  align="center"><?php if($row1->Description_of_Goods) print($row1->Description_of_Goods); else print("&nbsp;");?></td>
                      <td  align="center"><?php if($row1->Pack_Marks_Number) print(subStr($row1->Pack_Marks_Number,0,3000)); else print("&nbsp;");?></td>
                     <td  align="center"><?php if($row1->Pack_Number) print($row1->Pack_Number); else print("&nbsp;");?></td>
                     <td  align="center"><?php if($row1->Pack_Description) print($row1->Pack_Description); else print("&nbsp;");?></td>
					  <td  align="center"><?php if($row1->Bill_of_Entry_No) print($row1->Bill_of_Entry_No); else print("&nbsp;");?></td>
					  <td  align="center"><?php if($row1->Bill_of_Entry_Date) print($row1->Bill_of_Entry_Date); else print("&nbsp;");?></td>
					  <td  align="center"><?php if($rowbin->SAD_CONSIGNEE) print($rowbin->SAD_CONSIGNEE); else print("&nbsp;");?></td>
					  <td  align="center"><?php if($row1->cont_number) print($row1->cont_number); else print("&nbsp;");?></td>
					  <td  align="center"><?php if($row1->cont_size)  print($row1->cont_size); else print("&nbsp;"); ?></td>
					  <td  align="center"><?php if($row1->cont_height)  print($row1->cont_height); else print("&nbsp;"); ?></td>
					  <td  align="center"><?php if($row1->cont_type) print($row1->cont_type); else print("&nbsp;");?></td>
					  <td  align="center"><?php if($row1->cont_status) print($row1->cont_status); else print("&nbsp;");?></td>
					  <td  align="center"><?php if($row1->cont_imo) print($row1->cont_imo); else print("&nbsp;");?></td>
					  <td  align="center"><?php if($row1->cont_un) print($row1->cont_un); else print("&nbsp");?></td>
					  <td  align="center"><?php if($row1->cont_gross_weight) {print($row1->cont_gross_weight+$row1->cont_weight);} else print("&nbsp;");?></td>
					  <td  align="center"><?php if($row1->weight_unit)  print($row1->weight_unit); else print("&nbsp;"); ?></td>
					  <td  align="center"><?php if($row1->cont_gross_weight)  print($row1->cont_gross_weight); else print("&nbsp;"); ?></td>
					  <td  align="center"><?php if($row1->weight_unit) print($row1->weight_unit); else print("&nbsp;");?></td>
<td  align="center"><?php
						if($rownavy->final_amendment==3){ 
							print("Lab Com: ".$rownavy->response_details1."/".
							"NAIO:".$rownavy->response_details2."/ hold:".$rownavy->hold_application); 
						}
						else if($rownavy->final_amendment==2){
							print("Lab Com: ".$rownavy->response_details1."/".
							"NAIO:".$rownavy->response_details2."/ Rejected:".$rownavy->rejected_application); 
						}
						else if($rownavy->final_amendment==1){
							print("Lab Com: ".$rownavy->response_details1."/".
							"NAIO:".$rownavy->response_details2."/ Finally:".$rownavy->response_details3); 
						}
						else print("&nbsp;");?>
					</td>
					<?php
					}
						}
						}
					else
					{
					$row2=mysql_fetch_object($result2);
					$result3 = mysql_query("select cons.id, cons.igm_detail_id,cons.Consignee_ID from igm_detail_consigneetabs cons where cons.igm_detail_id=$row1->id");						
						
					//	print("select cons.id, cons.igm_detail_id,cons.Consignee_ID,(select org.Organization_Name from organization_profiles org where org.id=cons.Consignee_ID) as consignee_name,(select org1.Address_1 from organization_profiles org1 where org1.id=cons.Consignee_ID) as Address_1 from igm_detail_consigneetabs cons where cons.igm_detail_id=$row1->id");
						
					$row3 = mysql_fetch_object($result3); 
							
					?>		
						
					 
						
						<td/><td/><td/><td/><td/><td/><td/><td/><td/><td/><td/>
					  <td  align="center"><?php $sealpart=substr($row1->cont_seal_number,0,20); if($row1->cont_seal_number) print($sealpart); else print("&nbsp;");?></td>
					  <td   align="center"><?php if($row_igm_master->Port_of_Shipment) print($row_igm_master->Port_of_Shipment); else print("&nbsp;");?></td>
					  <td   align="center"><?php print("&nbsp;");?></td>
					  <td   align="center"><?php if($row1->type_of_igm <> 'TS') print($row1->off_dock_id); else print("1000");?></td>
					  <td  align="center"><?php if($row1->commudity_desc)  print($row1->commudity_desc); else print("&nbsp;"); ?></td> 
					  <td  align="center"><?php print($row1->cont_vat);?></td>
					  <td  align="center"><?php if($row1->Remarks) print($row1->Remarks); else print("&nbsp;");?></td>
						<td align="center"><?php print($sl);$sl=$sl+1?></td>
  					
				



</tr>
	
						<?php
					}
					?>	
					 
						
						
										<?php 
										}?>	
										
				
					</table>
					
			</TD></TR>
		</TABLE>
<?php if($_POST['options']=='html'){?>		
	</BODY>
</HTML>
<?php }?>
