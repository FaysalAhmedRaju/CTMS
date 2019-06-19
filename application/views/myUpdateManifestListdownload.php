<?php
include("mydbPConnection.php");
$rotation=$_POST['ddl_imp_rot_no'];
	$igm_master=mysql_query("select Vessel_Name from igm_masters where Import_Rotation_No='$rotation'");
		//print("select Vessel_Name from igm_masters where Import_Rotation_No='$rotation'");
		$row_master=mysql_fetch_object($igm_master);
		//$vessel_name=$row_master->Vessel_Name;
		$vessel_name1=$row_master->Vessel_Name;
		$vessel_name=str_replace('/','',$vessel_name1);	
		$vessel_name=str_replace('"','',$vessel_name);	
		//$vessel_name2=str_replace('.','',$vessel_name);

		$rotation=explode('/',$rotation);
		$rot1=$rotation[0];
		$rot2=$rotation[1];
		$rotno=$rot1.$rot2;
		$file = $rotno."_".$vessel_name;
		$myFile=$file.'.xml';
		
		if (file_exists($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/manifest/".$myFile)) {
			
				ob_start();		
				$myFileName=str_replace(" ","_",$myFile);
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header("Content-Disposition: attachment; filename=".$myFileName);
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/manifest/".$myFile));
				
				ob_end_clean(); 
				flush();
				readfile($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/manifest/".$myFile);
				
				//exit;
				
		
			}



mysql_close($con_cchaportdb);

?>