<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>BLOCKED CONTAINER LIST</TITLE>
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
		header("Content-Disposition: attachment; filename=EXPORT_SUMMERY.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}


	?>
<html>
<title>Break Bulk IGM Information</title>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">
				
				<tr align="center">
					<td colspan="12"><img align="middle" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
				</tr>
			
				<tr align="center">
					<td colspan="12"><font size="4"><b><u>Break Bulk IGM Information</u></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b></b></font></td>
				</tr>

				

			</table>
		
		</td>
		
	</tr>
	
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr>
	</table>
	<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<tr bgcolor="#A9A9A9" align="center" height="25px">
		<td style="border-width:3px;border-style: double;"><b>SlNo.</b></td>
		
		<td style="border-width:3px;border-style: double;"><b>Rotation.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Voy No.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Vessel Name.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Name of Master.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Date of Arrival.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Date of Departure.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Customs office Code.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Agent Code.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Agent Name.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Agent Address.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Mode of Transport.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Nationality of Transporter Code.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Total Number of Packages.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Total Gross Mass.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Place of Departure Code.</b></td>
		<td style="border-width:3px;border-style: double;"><b>Place of Destination Code.</b></td>
		
	</tr>

<?php
	include("con_cchaportdb.php");
	
						$query=mysql_query("SELECT Import_Rotation_No,igm_masters.Vessel_Name,Voy_No,Total_number_of_bols,Total_number_of_packages,				Total_number_of_containers,Total_gross_mass,Port_of_Shipment,Port_of_Destination,Submitee_Org_Id,
											Name_of_Master,AIN_No,Address_1,Address_2,Organization_Name,Customs_office_code,Mode_of_transport_code,Nationality_of_transporter_code,vsl_fsubmit_date,file_clearence_date
											FROM igm_masters 
											LEFT JOIN organization_profiles ON organization_profiles.id=igm_masters.Submitee_Org_Id

											WHERE igm_masters.vsl_dec_type='BB' order by Submission_Date desc");
	$i=0;

	
	while($row=mysql_fetch_object($query)){
	$i++;
	
	
?>
<tr align="center">
		<td><?php  echo $i;?></td>
		
		<td><?php if($row->Import_Rotation_No) echo $row->Import_Rotation_No; else echo "&nbsp;";?></td>
		<td><?php if($row->Voy_No) echo $row->Voy_No; else echo "&nbsp;";?></td>
		<td><?php if($row->Vessel_Name) echo $row->Vessel_Name; else echo "&nbsp;";?></td>
		<td><?php if($row->Name_of_Master) echo $row->Name_of_Master; else echo "&nbsp;";?></td>
		<td><?php if($row->vsl_fsubmit_date) echo $row->vsl_fsubmit_date; else echo "&nbsp;";?></td>
		<td><?php if($row->file_clearence_date) echo $row->file_clearence_date; else echo "&nbsp;";?></td>
		<td><?php if($row->Customs_office_code) echo $row->Customs_office_code; else echo "&nbsp;";?></td>
		<td><?php if($row->AIN_No) echo $row->AIN_No; else echo "&nbsp;";?></td>
		<td><?php if($row->Organization_Name) echo $row->Organization_Name; else echo "&nbsp;";?></td>
		<td><?php if($row->Address_1) echo $row->Address_1; else echo "&nbsp;";?></td>
		<td><?php if($row->Mode_of_transport_code) echo $row->Mode_of_transport_code; else echo "&nbsp;";?></td>
		<td><?php if($row->Nationality_of_transporter_code) echo $row->Nationality_of_transporter_code; else echo "&nbsp;";?></td>
		<td><?php if($row->Total_number_of_packages) echo $row->Total_number_of_packages; else echo "&nbsp;";?></td>
		<td><?php if($row->Total_gross_mass) echo $row->Total_gross_mass; else echo "&nbsp;";?></td>
		<td><?php if($row->Port_of_Shipment) echo $row->Port_of_Shipment; else echo "&nbsp;";?></td>
		<td><?php if($row->Port_of_Destination) echo $row->Port_of_Destination; else echo "&nbsp;";?></td>
				
	</tr>

<?php } ?>
</table>

<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
