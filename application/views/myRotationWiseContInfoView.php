<?php

	putenv('TZ=Asia/Dhaka');
	
	include("mydbPConnection.php");
	$sql=mysql_query("select igm_masters.Vessel_Name from igm_masters where Import_Rotation_No='$ddl_imp_rot_no'");
	$row=mysql_fetch_object($sql);
	$vsl = str_replace('/','_',$row->Vessel_Name);
	
	$ddl_imp_rot_no=$_REQUEST['ddl_imp_rot_no']; 
	$rot = str_replace('/','_',$ddl_imp_rot_no);
	$myFile = $rot."_".$vsl.".dat";
	if(file_exists($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/Container/".$myFile))
	{
			unlink($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/Container/".$myFile);
	}
	
	$fh= fopen($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/Container/".$myFile , 'a');
	 $query=mysql_query("select distinct Organization_Name,cont_number,cont_size,cont_gross_weight,
                                  cont_weight,cont_seal_number,cont_status,off_dock_id,cont_imo,
                                  cont_un,commudity_code,cont_height,cont_iso_type,cont_type,mlocode,igm_masters.Port_Ship_ID,
                                  REPLACE(Vessel_Name,' ','_' ) AS Vessel_Name,
                                  (select Organization_Name from organization_profiles
                                   where organization_profiles.id=igm_detail_container.off_dock_id) as offdock_name,
                                  (select commudity_desc from commudity_detail where commudity_detail.commudity_code=
                                  igm_detail_container.commudity_code) as commodity from igm_detail_container inner join 
                                  igm_details on igm_details.id=igm_detail_container.igm_detail_id inner join igm_masters on 
                                  igm_details.IGM_id=igm_masters.id inner join organization_profiles on organization_profiles.id=
                                  igm_detail_container.org_id where igm_details.Import_Rotation_No='$ddl_imp_rot_no'");
	while($row=mysql_fetch_object($query)){
	$contDatastart	=''.$row->cont_number.'|'.$row->cont_size.'|'.$row->cont_gross_weight.'|'.$row->cont_weight.'|'.$row->cont_seal_number.'|'.$row->cont_status.'|'.$row->cont_height.'|'.$row->cont_iso_type.'|'.$row->cont_type.'|'.$row->offdock_name.'|'.$row->offdock_name.'|'.$row->Organization_Name.'|'.$row->mlocode.'|'.$row->cont_imo.'|'.$row->cont_un.'|'.$row->Port_Ship_ID.'|'.$row->commodity.'';
	fwrite($fh, $contDatastart);
	$contDataend = "\n";
	fwrite($fh, $contDataend);
	}
	
	fclose($fh);
mysql_close($con_cchaportdb);
if (file_exists($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/Container/".$myFile))
 {
  $file = $_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/Container/".$myFile;
  $fp = fopen($file, 'rb');
  $myFile = str_replace(' ','-',$myFile);
  header("Content-Type: application/octet-stream");
  header("Content-Disposition: attachment; filename=".basename($myFile));
  header("Content-Length: ". filesize($file ));
  fpassthru($fp);
  fclose($fp);
  exit;
 }
 else
 {
  echo "File does not exists.Please Contact with DataSoft Operation Team";
 }
	

	
	
 
?>

