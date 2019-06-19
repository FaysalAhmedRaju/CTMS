<?php 

include("mydbPConnection.php");
$str1=mysql_query("select Vessel_Name from igm_masters where Import_Rotation_No='$rot'");
$rtn1=mysql_fetch_object($str1);
//echo "select Vessel_Name from igm_masters where Import_Rotation_No='$rot'";
$vessel_name=$rtn1->Vessel_Name;
$vessel_name=str_replace(' ','_',$vessel_name);
$vessel_name=str_replace('"','',$vessel_name);
$vessel_name=str_replace("'",'',$vessel_name);

$filename=str_replace("/","_",$rot)."_".$vessel_name.".txt";
//echo "<br>".$filename;
if(file_exists($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/igmCanada/".$filename))
{
	unlink($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/igmCanada/".$filename);
}

$fh= fopen($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/igmCanada/".$filename , 'a');


$stringData="Import Rotation No|BL No|Exporter Name|Exporter Address|Importer Code|Importer Name|Importer Address|Consignee Code|Consignee Name|Consignee Address|Gross Weight|Vessel registration date|Description of Goods\n\n";
fwrite($fh, $stringData);


$str="select Import_Rotation_No,BL_No,Exporter_name,Exporter_address,Notify_code,Notify_name,Notify_address,Consignee_code,Consignee_name,Consignee_address,weight,date(PFstatusdt) as PFstatusdt,Description_of_Goods from igm_details where Import_Rotation_No='$rot'";

$result=mysql_query($str);
while($rtn=mysql_fetch_object($result)){

$Import_Rotation_No=$rtn->Import_Rotation_No;
$BL_No=$rtn->BL_No;
$Exporter_name=$rtn->Exporter_name;
$Exporter_name=preg_replace('/[^a-zA-Z0-9_ -.+]/s', '',$Exporter_name);
$Exporter_name=remove_numbers($Exporter_name);
$Exporter_address=$rtn->Exporter_address;
$Exporter_address=preg_replace('/[^a-zA-Z0-9_ -.+]/s', '',$Exporter_address);
$Exporter_address=remove_numbers($Exporter_address);
$Notify_code=$rtn->Notify_code;
$Notify_name=$rtn->Notify_name;
$Notify_name=preg_replace('/[^a-zA-Z0-9_ -.+]/s', '',$Notify_name);
$Notify_name=remove_numbers($Notify_name);
$Notify_address=$rtn->Notify_address;
$Notify_address=preg_replace('/[^a-zA-Z0-9_ -.+]/s', '',$Notify_address);
$Notify_address=remove_numbers($Notify_address);
$Consignee_code=$rtn->Consignee_code;

$Consignee_name=$rtn->Consignee_name;
$Consignee_name=preg_replace('/[^a-zA-Z0-9_ -.+]/s', '',$Consignee_name);
$Consignee_name=remove_numbers($Consignee_name);

$Consignee_address=$rtn->Consignee_address;
$Consignee_address=preg_replace('/[^a-zA-Z0-9_ -.+]/s', '',$Consignee_address);
$Consignee_address=remove_numbers($Consignee_address);

$weight=$rtn->weight;
$PFstatusdt=$rtn->PFstatusdt;
$Description_of_Goods=$rtn->Description_of_Goods;
$Description_of_Goods=preg_replace('/[^a-zA-Z0-9_ -.+]/s', '',$Description_of_Goods);
$Description_of_Goods=remove_numbers($Description_of_Goods);

$ConsigneeDesc=preg_replace('/[^a-zA-Z0-9_ -.+]/s', '',$ConsigneeDesc);
$stringData=$Import_Rotation_No."|".$BL_No."|".$Exporter_name."|".$Exporter_address."|".$Notify_code."|".$Notify_name."|".$Notify_address."|".$Consignee_code."|".$Consignee_name."|".$Consignee_address."|".$weight."|".$PFstatusdt."|".$Description_of_Goods."\n";
//echo $stringData;
fwrite($fh, $stringData);
}
fclose($fh);
mysql_close($con_cchaportdb);
if (file_exists($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/igmCanada/".$filename)) {
			
				ob_start();		
				$myFileName=str_replace(" ","_",$myFile);
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header("Content-Disposition: attachment; filename=".$filename);
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/igmCanada/".$filename));
				
				ob_end_clean(); 
				flush();
				readfile($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/igmCanada/".$filename);
				
				//exit;
				
		
			}

function remove_numbers($string) {
				$spchar = array("\n","&",'"',"'","/",">","<","^","  ","~");
				$string = str_replace($spchar, '', $string);				
				//$string=substr($string, 0, 80);
				return $string;
				} 





?>