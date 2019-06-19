<?php

putenv('TZ=Asia/Dhaka');
	
	   // START DGCARGO  ZICO
	/*mysql_close();  
	mysql_connect("192.168.1.7","user-dev","user7test");
	mysql_select_db("cchaportdb");*/
	
	
	/*$dbfile=file("/var/www/db_info.php");
	$dbu2=trim($dbfile[1]);
	$dbup2=trim($dbfile[2]);

	mysql_connect("192.168.1.1", $dbu2, $dbup2);
	mysql_select_db("ccha");*/
	//echo "shemul";
	include("mydbPConnection.php");
	$rotation_no=$_POST['ddl_imp_rot_no'];
	
	$my=substr($rotation_no,0,1);
	$myrot=substr($rotation_no,4,1);
	if($my=="R" or $my=="r" or $myrot=="/")
	{
	
	$sql_imp=mysql_query("select id from igm_masters where Import_Rotation_No='$rotation_no'");
	$row_imp=mysql_fetch_object($sql_imp);
	$igm_master_id=$row_imp->id;
		


			///IGM Details
				
				//$str= "select id from igm_details where (PFstatus=1 or PFstatus=10 or PFstatus=2) and IGM_id='$igm_master_id'";
					/*$str= "select igm_details.id from igm_details left join igm_supplimentary_detail on igm_supplimentary_detail.igm_detail_id=igm_details.id 
					where (igm_details.PFstatus=1 or igm_details.PFstatus=10 or igm_details.PFstatus=2) and IGM_id='$igm_master_id' 
					and igm_supplimentary_detail.igm_detail_id is null";*/
					
					$str="select distinct igm_details.id from igm_details inner join igm_detail_container on igm_detail_container.igm_detail_id=igm_details.id 
					left join igm_supplimentary_detail on igm_supplimentary_detail.igm_detail_id=igm_details.id 
					left join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id 
					where (igm_details.PFstatus=1 or igm_details.PFstatus=10 or igm_details.PFstatus=2) and IGM_id=$igm_master_id  and igm_detail_container.cont_number not in 
					(select cont_number from igm_sup_detail_container inner join igm_supplimentary_detail on igm_supplimentary_detail.id=igm_sup_detail_container.igm_sup_detail_id  where igm_master_id=$igm_master_id)";					
						
						$result =mysql_query($str);					
					while ($row1 = mysql_fetch_object($result))
					{
						$igm_detail_id="";
						$igm_detail_id=$row1->id;
						$stri= "select igm_detail_id from igm_for_ctms where igm_detail_id=$igm_detail_id and data_type='igm'";
						$resulti =mysql_query($stri);					
						if(!($rowi = mysql_fetch_object($resulti)))
							{
								mysql_query("insert into igm_for_ctms(igm_detail_id,update_datetime,data_type) values('$igm_detail_id',now(),'igm')");	
							}							
							
					}
	///IGM Supplimentary
				
				$str= "select id from igm_supplimentary_detail where (PFstatus=1 or PFstatus=10 or PFstatus=2) and igm_master_id='$igm_master_id'";

				$result =mysql_query($str);					
					while ($row1 = mysql_fetch_object($result))
					{
						$igm_sup_detail_id="";
						$igm_sup_detail_id=$row1->id;
						$stri= "select igm_sub_detail_id from igm_for_ctms where igm_sub_detail_id=$igm_sup_detail_id and data_type='igm'";
						$resulti =mysql_query($stri);					
						if(!($rowi = mysql_fetch_object($resulti)))
							{
								mysql_query("insert into igm_for_ctms(igm_sub_detail_id,update_datetime,data_type) values('$igm_sup_detail_id',now(),'igm')");	
							}							
							
					}
					
					
$str22="update igm_for_ctms 
inner join igm_details on igm_details.id=igm_for_ctms.igm_detail_id
set igm_for_ctms.igm_master_id=igm_details.IGM_id
where igm_for_ctms.igm_master_id is null";

		if($result =mysql_query($str22))
				$a.="Master id (IGM) Success<br>";

$str33="update igm_for_ctms 
inner join igm_supplimentary_detail on igm_supplimentary_detail.id=igm_for_ctms.igm_sub_detail_id
set igm_for_ctms.igm_master_id=igm_supplimentary_detail.igm_master_id
where igm_for_ctms.igm_master_id is null";

				if($result =mysql_query($str33))
					$a.="Master id (IGM Supplimentary) Success<br>";
				
	


$str= "update igm_for_ctms 
inner join igm_details on igm_details.id=igm_for_ctms.igm_detail_id
set igm_for_ctms.Rotation_no=igm_details.Import_Rotation_No,
igm_for_ctms.BL_No=igm_details.BL_No
where igm_for_ctms.igm_master_id='$igm_master_id'";
				
				if($result =mysql_query($str))
				$a.="IGM Success<br>";				
				
				$str= "update igm_for_ctms 
inner join igm_supplimentary_detail on igm_supplimentary_detail.id=igm_for_ctms.igm_sub_detail_id
set igm_for_ctms.Rotation_no=igm_supplimentary_detail.Import_Rotation_No,
igm_for_ctms.BL_No=  replace(replace(substring_index(igm_supplimentary_detail.BL_No,_latin1'*',-(1)) ,' ',''),'	','')
where igm_for_ctms.igm_master_id='$igm_master_id'";
				
				if($result =mysql_query($str))
					$a.="IGM Supplimentary Success<br>";	




/********************************************Start of transfer data to CTMS Manifest***********************************************/
	
	
	$total=0;
	//read_datetime is null
	function remove_numbers($string) {
				$spchar = array("\n","&",'"',"'","/",">","<","^","  ","~");
				$string = str_replace($spchar, '', $string);				
				$string=substr($string, 0, 80);
				return $string;
				} 
	
	//while($row11=mysql_fetch_object($sql11)){
	$masterid=$igm_master_id;
	//$masterid=$row11->igm_master_id;
	//print($masterid."<br>");
	
	
	$igm_master_name=mysql_query("select Vessel_Name,Import_Rotation_No from igm_masters where id='$masterid'");
			//print("select Vessel_Name,Import_Rotation_No from igm_masters where id='$row11->igm_master_id'");
			$row_master_name=mysql_fetch_object($igm_master_name);
			
			//$vessel_name=$row_master->Vessel_Name;
			$vessel_name_del=$row_master_name->Vessel_Name;
			$vessel_name_new=str_replace('/','',$vessel_name_del);	
			$vessel_name_new=str_replace('/','',$vessel_name_new);	
			//$vessel_name2=str_replace('.','',$vessel_name);
			//print($vessel_name_new);
			$rotation11=explode('/',$row_master_name->Import_Rotation_No);
			$rot11=$rotation11[0];
			$rot22=$rotation11[1];
			$rotno_new=$rot11.$rot22;
			//print($rotno);
			
			//$blno = $row1->BL_No;
			//$rep_bl = str_replace("/",".","$blno");
			//print($rep_bl."zico");
			
			$file_old = $rotno_new."_".$vessel_name_new;
			//print($file."sssssss");
			//print "$id1"."idddd";
	      //  print($from."bbbbnnnnnn");
		  $myFile_old=$file_old.'.xml';
		  // print($myFile_old."<hr>");
		 
	
	/*if (file_exists('/var/www/html/manifest/manifest/'.$myFile_old)) 
			{
			//print("shemul");
			unlink('/var/www/html/manifest/manifest/'.$myFile_old);
			} 
		 */
		 //echo $_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/manifest/".$myFile_old;
		// break;
		 if(file_exists($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/manifest/".$myFile_old))
		 {
			unlink($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/manifest/".$myFile_old);
		 }
		
		$sql2 = mysql_query("select id,igm_master_id,igm_detail_id,igm_sub_detail_id,Rotation_no,BL_No from igm_for_ctms 
		where  data_type='igm' and igm_master_id=$masterid") or die (mysql_error()); 
//read_datetime is null

		/*$sql2 = mysql_query("select id,igm_master_id,igm_detail_id,igm_sub_detail_id,
		Rotation_no,BL_No from igm_for_ctms 
		where update_datetime like '2011-08-10%' and data_type='igm' and 
		igm_master_id=$masterid") or die (mysql_error());*/ 
		//print("select id,igm_master_id,igm_detail_id,igm_sub_detail_id,Rotation_no,BL_No from igm_for_ctms 
		//where  data_type='igm' and igm_master_id=$masterid");
		
		
		$filegenerated=0;
		$loopgnrt=0;
		$newfile=0;
		$igm_master_id="";
		$igm_master_id_old="";
	
       while ($row1 = mysql_fetch_object($sql2)){
	   $loopgnrt=$loopgnrt+1;
			$id1 = $row1->id;
			$igmdetailid = $row1->igm_detail_id;
			$igmsubdetailid = $row1->igm_sub_detail_id;
			 $igm_master_id=$row1->igm_master_id;
		
		
			$rotation = $row1->Rotation_no;
			
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
			//print($rotno);
			
			$blno = $row1->BL_No;
			$blno=remove_numbers($blno);
			$rep_bl = str_replace("/",".","$blno");
			//print($rep_bl."zico");
			
			$file = $rotno."_".$vessel_name;
			//print($file."sssssss");
			//print "$id1"."idddd";
	      //  print($from."bbbbnnnnnn");
		  $myFile=$file.'.xml';
		  //$fh= fopen('/var/www/html/manifest/manifest/'.$myFile , 'a');
		  $fh= fopen($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/manifest/".$myFile , 'a');
		$stringData = "<edi:blTransactions xmlns:edi=\"http://www.navis.com/argo\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\">\n";
				
				if($loopgnrt==1)
				fwrite($fh, $stringData);
				
			//	print($myFile."<hr>");
				//print("shahzahan(<hr>)".filesize('/var/www/html/manifest/manifest/'.$myFile).$myFile);
				
			
			//else
			
			
			if ($igmdetailid != ''){

			//	$mypath="/var/www/html/manifest/manifest/";
				//print($mypath);
			//	$abc=mkdir("$mypath",0777,true);
				$testpath = $mypath;
				
				
				
				$GetigmInfo=mysql_query("select Pack_Number,Pack_Description,Pack_Marks_Number,Description_of_Goods,
				weight,weight_unit,IGM_id,mlocode,ConsigneeDesc,Submitee_Org_Id,type_of_igm from igm_details 
				where id=$row1->igm_detail_id ");
				//print("select Pack_Number,Pack_Description,Pack_Marks_Number,Description_of_Goods,weight,weight_unitIGM_id,mlocode,ConsigneeDesc,Submitee_Org_Id from igm_details where id=$row1->igm_detail_id ");
				$row_igm=mysql_fetch_object($GetigmInfo);
				
				/*$getagentcode=mysql_query("select Agent_Code from organization_profiles where 
				id=$row_igm->Submitee_Org_Id");
				
				$row_agent=mysql_fetch_object($getagentcode);*/
				
				$getvesselInfo=mysql_query("select Import_Rotation_No,Vessel_Name,Voy_No,Port_of_Shipment,Port_Ship_ID from igm_masters 
				where id=$row_igm->IGM_id");
				$row_vessel=mysql_fetch_object($getvesselInfo);
				$rotaion_no=$row_vessel->Import_Rotation_No;
				//$rotaion_no=str_replace("/","",$rotaion_no);
				$vessel_name_1=remove_numbers($row_vessel->Vessel_Name);
				$mlocode22=$row_igm->mlocode;
				
				/*$mlo_agent_code=mysql_query("select mlocode as port_mlo from mlo_detail where mlocode='$row_igm->mlocode' and org_id='$row_igm->Submitee_Org_Id'");
				$row_mlo_agent_code=mysql_fetch_object($mlo_agent_code);
				if(!($row_mlo_agent_code->port_mlo))
				{
					$mlo_agent_code=mysql_query("select port_mlo from mlo_detail_old where mlocode='$row_igm->mlocode'");
					$row_mlo_agent_code=mysql_fetch_object($mlo_agent_code);
				}*/
				if($row_igm->type_of_igm=="TS"){
					$blCategory="TRANSSHIP";
					$portId="BDMGL";
				}
				else{				
					$blCategory="IMPORT";
					$portId="BDCGP";
				}
				
				$stringData = "<edi:blTransaction edi:msgClass=\"MANIFEST\" edi:msgFunction=\"9\" edi:msgReferenceNbr=\"000000001\" edi:msgTypeId=\"310\">\n";
				fwrite($fh, $stringData);
				$stringData = "<edi:Interchange edi:InterchangeReceipient=\"CPA\" edi:InterchangeSender=\"CPA\"/>\n";
				fwrite($fh, $stringData);
				$stringData = "<edi:ediBillOfLading edi:blCategory=\"".$blCategory."\" edi:blNbr=\"" .$blno. "\"/>\n";
				fwrite($fh, $stringData);
				$stringData = "<edi:ediVesselVisit edi:actualTimeArrival=\"\" edi:actualTimeDeparture=\"\" edi:estimatedTimeArrival=\"\" edi:estimatedTimeDeparture=\"\" edi:inVoyageNbr=\"" .$rotaion_no. "\" edi:vesselId=\"" .$vessel_name_1. "\" edi:vesselIdConvention=\"VESNAME\">\n";
				fwrite($fh, $stringData);
				$stringData = "<edi:shippingLine edi:shippingLineCode=\"" .$mlocode22. "\" edi:shippingLineCodeAgency=\"SCAC\"/>\n";
				fwrite($fh, $stringData);
				$stringData = "<edi:loadPort edi:portId=\"" .$row_vessel->Port_Ship_ID. "\" edi:portIdConvention=\"UNLOCCODE\"/>\n";
				fwrite($fh, $stringData);
				$stringData = "</edi:ediVesselVisit>\n";
				fwrite($fh, $stringData);
				$stringData = "<edi:shipper edi:shipperName=\"\"/>\n";
				fwrite($fh, $stringData);
				//$ConsigneeDesc=str_replace('"',"",$row_igm->ConsigneeDesc);

				//$ConsigneeDesc=str_replace('&','AND',$row_igm->ConsigneeDesc);
				//$ConsigneeDesc=substr($ConsigneeDesc, 0, 80);
				
				//$ConsigneeDesc=$row_igm->ConsigneeDesc;
				//$ConsigneeDesc=remove_numbers($ConsigneeDesc);
				$ConsigneeDesc=$row_igm->ConsigneeDesc;
				$ConsigneeDesc=remove_numbers($ConsigneeDesc);
				$ConsigneeDesc=preg_replace('/[^a-zA-Z0-9_ -.+]/s', '',$ConsigneeDesc);
				
				$stringData = "<edi:consignee edi:consigneeName=\"\"/>\n";
				fwrite($fh, $stringData);
					
					$detailcont_offdid = mysql_query("select off_dock_id
				from igm_detail_container where igm_detail_id='$igmdetailid' limit 1");
				
				if($rowoff = mysql_fetch_object($detailcont_offdid))
				$offdock_id=$rowoff->off_dock_id;
				
				$stringData = "<edi:dischargePort1 edi:portId=\"".$portId."\" edi:portIdConvention=\"UNLOCCODE\"/>\n";
				fwrite($fh, $stringData);
				$stringData = "<edi:ediBlItemHolder>\n";
				fwrite($fh, $stringData);
				
				
				$detailcont = mysql_query("select cont_number,cont_gross_weight,cont_status,cont_iso_type,commudity_code,off_dock_id,cont_seal_number
				from igm_detail_container where igm_detail_id='$igmdetailid'");
				
				while ($row2 = mysql_fetch_object($detailcont)){
				
				if($row2->commudity_code=="")
				{
				$commudity_code="35";
				}
				else
				{
				$commudity_code=$row2->commudity_code;
				}
				
				if($row2->cont_status=="EMPTY" or $row2->cont_status=="EMT" or $row2->cont_status=="MT")
				{
				$cont_status="MTY";
				
				}
				else
				{
				$cont_status=$row2->cont_status;
				}
				$cont_status_final=substr(trim($cont_status), 0, 3);

				/*$container_seal_no=str_replace('/','.',$row2->cont_seal_number);
				$container_seal_no2=str_replace('"','',$container_seal_no);
				$container_seal_no3=str_replace("'",'',$container_seal_no2);
				$container_seal_no=explode(",",$container_seal_no3);*/
				
				$container_seal_no=remove_numbers($row2->cont_seal_number);
				$container_seal_no=explode(",",$container_seal_no);
				
				//Transship IGM
				if($row_igm->type_of_igm=="TS")
					$offdock="BDMGL";
				else
					$offdock=$row2->off_dock_id;
				
				//End TS IGM
				
				$contnumber = $row2->cont_number;
				$strcont = '"'.$contnumber.'"';
				$stringData = "<edi:ediBlEquipment>\n";
				fwrite($fh, $stringData);
				$stringData = "<edi:ediContainer edi:containerGrossWt=\"" .$row2->cont_gross_weight. "\" edi:containerISOcode=\"" .$row2->cont_iso_type. "\" edi:containerNbr=\"".$row2->cont_number."\" edi:containerSealNumber1=\"" .$container_seal_no[0]. "\" edi:containerSealNumber2=\"" .$container_seal_no[1].  "\" edi:containerSealNumber4=\"" .$container_seal_no[2]. "\" edi:containerStatus=\"" .$cont_status_final. "\">\n";
				fwrite(	$fh, $stringData );	
				$stringData = "</edi:ediContainer>\n";
				fwrite($fh, $stringData);
				$stringData = "<edi:ediCommodity edi:referenceNbr=\"\" edi:commodityCode=\"" .$commudity_code.  "\" edi:commodityShortName=\"\" edi:commodityDescription=\"\" edi:origin=\"\" edi:destination=\"" .$offdock. "\" edi:shipper=\"\" edi:consignee=\"\">\n";
				fwrite($fh, $stringData);
				$stringData = "</edi:ediCommodity>\n";
				fwrite($fh, $stringData);
				$stringData = "</edi:ediBlEquipment>\n";
				fwrite($fh, $stringData);
				//print "$contnumber"."<br />";
				}
				
				
				//$Pack_Marks_Number=$row_igm->Pack_Marks_Number;
				//$Pack_Marks_Number=remove_numbers($Pack_Marks_Number);
				//$Description_of_Goods=$row_igm->Description_of_Goods;
				//$Description_of_Goods=remove_numbers($Description_of_Goods);
				
				$Pack_Marks_Number=$row_igm->Pack_Marks_Number;
				$Pack_Marks_Number=remove_numbers($Pack_Marks_Number);
				$Pack_Marks_Number=preg_replace('/[^a-zA-Z0-9_ -.+]/s', '',$Pack_Marks_Number);
				
				$Description_of_Goods=$row_igm->Description_of_Goods;
				$Description_of_Goods=remove_numbers($Description_of_Goods);
				$Description_of_Goods=preg_replace('/[^a-zA-Z0-9_ -.+]/s', '',$Description_of_Goods);
				
					   
				if(!($row_igm->weight=='' and $row_igm->weight_unit==''))
					  {
					  //print($row_igm->weight."<br>".$row_igm->weight_unit."<br>"); 
					  
					  $igm_gross_weight=$row_igm->weight;
					  
					   $weight_unit=strtoupper($row_igm->weight_unit);
					   $weight_unit= str_replace('.','',$weight_unit);
					   $weight_unit= str_replace(' ','',$weight_unit);
					   $ex_mess="";
					  if(($weight_unit=="MTON") Or ($weight_unit=="MTONS"))
									{
									$weight1=$igm_gross_weight * 1000;
									//$ex_mess="Note  : 1 MTON = 1000 KGs";
									}
									else if( ($weight_unit=="TON") or ($weight_unit=="TONS"))
									{
									$weight1=$igm_gross_weight * 1000;
									//$ex_mess="Note : 1 TON = 1000 KGs";
									}									
									else if(($weight_unit=="HTON") or ($weight_unit=="HTONS"))
									{
									$weight1=$igm_gross_weight * 1000 * 1.8;
									//$ex_mess="Note : 1 HTON=1800 KGs";
									}
									else if(($weight_unit=="STON") or ($weight_unit=="STONS" ))
									{
									$weight1=$igm_gross_weight * 907.185;
									//$ex_mess="Note  : 1 STON = 907.185 KGs";
									}									
									else if(($weight_unit=="LTON" ) or ($weight_unit=="LTONS" ))
									{
									$weight1=$igm_gross_weight * 1016.05 ;
									//$ex_mess="Note : 1 LTON = 1016.05 KGs";
									}
									else if($weight_unit=="LBS" )
									{
									$weight1=$igm_gross_weight * 0.453592;
									//$ex_mess="Note : 1 LBS = 0.453592 KGs";
									}
									else
									
									{
									$weight1=$igm_gross_weight;
									
									}
									$weight_unit='KG';
								//	print($weight1."<br>");
									//print($weight_unit."<br>");
									
									
				/*if(!($weight_unit=="KG" or $weight_unit=="KGS"))
				//print("<br>&nbsp;&nbsp;&nbsp;<a><font  color='blue'> Equivalent to ".$weight1." KGS </font></a><hr><font  color='red'>".$ex_mess."</font>");
				{
					print($weight1."<br>");
					$weight_unit='KGS';
					print($weight_unit."<br>");
				}
				else
			
				{
					//print($row_igm->weight."<br>");
					$weight1=$row_igm->weight;
					print($weight1);
					print($weight_unit."<br>"); 
				}*/
					  
		}
		
		
		else 
		{
	    print("&nbsp;");
		}
				
				//************************end********************************
				
				$stringData = "<edi:ediBlItem edi:quantity=\"" .$row_igm->Pack_Number. "\" edi:type=\"\" edi:weight=
				\"" .$weight1. "\" edi:weightUnit=\"" .$weight_unit. "\" edi:markNumber=
				\"" .$Pack_Marks_Number. "\" edi:description=
				\"" .$Description_of_Goods. "\">\n";
				
				/*$stringData = "<edi:ediBlItem edi:quantity=\"" .$row_igm->Pack_Number. "\" edi:type=\"\" edi:weight=
				\"" .$row_igm->weight. "\" edi:weightUnit=\"" .$row_igm->weight_unit. "\" edi:markNumber=
				\"" .$Pack_Marks_Number. "\" edi:description=
				\"" .$Description_of_Goods. "\">\n";*/
				
				fwrite($fh, $stringData);
				$stringData = "<edi:ediCommodity edi:referenceNbr=\"\" edi:commodityCode=\"".$commudity_code."\" edi:commodityShortName=\"\" edi:commodityDescription=\"\" edi:origin=\"\" edi:destination=\"\" edi:shipper=\"\" edi:consignee=\"\">\n";
				fwrite($fh, $stringData);
				$stringData = "</edi:ediCommodity>\n";
				fwrite($fh, $stringData);
				$stringData = "</edi:ediBlItem>\n";
				fwrite($fh, $stringData);
				$stringData = "</edi:ediBlItemHolder>\n";
				fwrite($fh, $stringData);
				$stringData = "</edi:blTransaction>\n";
				fwrite($fh, $stringData);
				//$stringData = "</edi:blTransactions>\n";
				//fwrite($fh, $stringData);
				
				
				                				
			//	fclose($fh);
				//$contnumber;
				//$this->containerXmlWrite($contnumber,$filename,$file);
				
				
			} 
			
			else
			   {
			    //$loopgnrt=$loopgnrt+1;
			//	$mypath1="/var/www/html/manifest/manifest/";
			   //$mypath1="C:\\$from\\dgcargosup\\";
				//$abc1=mkdir("$mypath1",0777,true);
				$testpath1 = $mypath1;
				//print($testpath1);
			  
				$GetigmInfo=mysql_query("select igm_detail_id,Pack_Number,Pack_Description,Pack_Marks_Number,Description_of_Goods,
				weight,weight_unit,igm_master_id as IGM_id,ConsigneeDesc,Submitee_Org_Id,type_of_igm from 
				igm_supplimentary_detail where id=$row1->igm_sub_detail_id ");
				//print("select Pack_Number,Pack_Description,Pack_Marks_Number,Description_of_Goods,weight,weight_unitIGM_id,mlocode,ConsigneeDesc,Submitee_Org_Id from igm_details where id=$row1->igm_detail_id ");
				$row_igm=mysql_fetch_object($GetigmInfo);
				
				
				$getsubmitee=mysql_query("select mlocode,Submitee_Org_Id from igm_details where id=$row_igm->igm_detail_id");
				$row_getsubmitee=mysql_fetch_object($getsubmitee);
				$mlocode22=$row_getsubmitee->mlocode;
				
				/*$mlo_agent_code_ff=mysql_query("select mlocode as port_mlo from mlo_detail where mlocode='$row_getsubmitee->mlocode' and org_id='$row_getsubmitee->Submitee_Org_Id'");
				$row_mlo_agent_code_ff=mysql_fetch_object($mlo_agent_code_ff);
				if(!($row_mlo_agent_code_ff->port_mlo))
				{
					$mlo_agent_code_ff=mysql_query("select port_mlo from mlo_detail_old where mlocode='$row_getsubmitee->mlocode'");
					$row_mlo_agent_code_ff=mysql_fetch_object($mlo_agent_code_ff);
				}*/
				/*$getagentcode=mysql_query("select Agent_Code from organization_profiles where 
				id=$row_getsubmitee->Submitee_Org_Id");
				
				$row_agent=mysql_fetch_object($getagentcode);*/
				
				$getvesselInfo=mysql_query("select Import_Rotation_No,Vessel_Name,Voy_No,Port_of_Shipment,Port_Ship_ID from igm_masters 
				where id=$row_igm->IGM_id");
				$row_vessel=mysql_fetch_object($getvesselInfo);
				$rotaion_no=$row_vessel->Import_Rotation_No;
				//$rotaion_no=str_replace("/","",$rotaion_no);
				$vessel_name_1=remove_numbers($row_vessel->Vessel_Name);
				//$detailcont = mysql_query("select cont_number from igm_detail_container where igm_detail_id='$igmdetailid'");
				//print "select cont_number from igm_detail_container where igm_detail_id='$igmdetailid'";
				
				//$myFile = $file.'.'.'xml';
				
				//$fh= fopen('manifest/'.$myFile , 'w');
				//if($from=="" and $to=="")
				//{
				
			//else
				///{
					//truncate_last_n_lines_of_file('/var/www/html/manifest/manifest/'.$myFile,1);
				//}

				
			//	$stringData = "<edi:blTransactions xmlns:edi=\"http://www.navis.com/argo\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\">\n";
				//fwrite($fh, $stringData);
				
				if($row_igm->type_of_igm=="TS"){
					$blCategory="TRANSSHIP";
					$portId="BDMGL";
				}
				else{
					$blCategory="IMPORT";
					$portId="BDCGP";
				}
				
				$stringData = "<edi:blTransaction edi:msgClass=\"MANIFEST\" edi:msgFunction=\"9\" edi:msgReferenceNbr=\"000000001\" edi:msgTypeId=\"310\">\n";
				fwrite($fh, $stringData);
				$stringData = "<edi:Interchange edi:InterchangeReceipient=\"CPA\" edi:InterchangeSender=\"CPA\"/>\n";
				fwrite($fh, $stringData);
				$stringData = "<edi:ediBillOfLading edi:blCategory=\"".$blCategory."\" edi:blNbr=\"" .$blno. "\"/>\n";
				fwrite($fh, $stringData);
				$stringData = "<edi:ediVesselVisit edi:actualTimeArrival=\"\" edi:actualTimeDeparture=\"\" edi:estimatedTimeArrival=\"\" edi:estimatedTimeDeparture=\"\" edi:inVoyageNbr=\"" .$rotaion_no. "\" edi:vesselId=\"" .$vessel_name_1. "\" edi:vesselIdConvention=\"VESNAME\">\n";
				fwrite($fh, $stringData);
				$stringData = "<edi:shippingLine edi:shippingLineCode=\"" .$mlocode22. "\" edi:shippingLineCodeAgency=\"SCAC\"/>\n";
				fwrite($fh, $stringData);
				$stringData = "<edi:loadPort edi:portId=\"" .$row_vessel->Port_Ship_ID. "\" edi:portIdConvention=\"UNLOCCODE\"/>\n";
				fwrite($fh, $stringData);
				$stringData = "</edi:ediVesselVisit>\n";
				fwrite($fh, $stringData);
				$stringData = "<edi:shipper edi:shipperName=\"\"/>\n";
				fwrite($fh, $stringData);

				
				
				$ConsigneeDesc=$row_igm->ConsigneeDesc;
				$ConsigneeDesc=remove_numbers($ConsigneeDesc);
				$ConsigneeDesc=preg_replace('/[^a-zA-Z0-9_ -.+]/s', '',$ConsigneeDesc);
				
				
				$stringData = "<edi:consignee edi:consigneeName=\"\"/>\n";
				fwrite($fh, $stringData);
					
					
					$detailcont_offdid = mysql_query("select off_dock_id
				from igm_sup_detail_container where igm_detail_id='$igmsubdetailid' limit 1");
				
				if($rowoff = mysql_fetch_object($detailcont_offdid))
				$offdock_id=$rowoff->off_dock_id;
				
				$stringData = "<edi:dischargePort1 edi:portId=\"".$portId."\" edi:portIdConvention=\"UNLOCCODE\"/>\n";
				fwrite($fh, $stringData);
				$stringData = "<edi:ediBlItemHolder>\n";
				fwrite($fh, $stringData);
				
				
				
				$detailcont = mysql_query("select cont_number,cont_gross_weight,cont_status,cont_iso_type,commudity_code,off_dock_id,cont_seal_number
				from igm_sup_detail_container where igm_sup_detail_id='$igmsubdetailid'");
				
				while ($row2 = mysql_fetch_object($detailcont)){
				
				//$stringData = "<edi:dischargePort1 edi:portId=\"" .$row2->off_dock_id. "\" edi:portIdConvention=\"UNLOCCODE\"/>\n";
				//fwrite($fh, $stringData);
				//$stringData = "<edi:ediBlItemHolder>\n";
				//fwrite($fh, $stringData);
				
				if($row2->commudity_code=="")
				{
				$commudity_code="35";
				}
				else
				{
				$commudity_code=$row2->commudity_code;
				}
				
				if($row2->cont_status=="EMPTY" or $row2->cont_status=="EMT" or $row2->cont_status=="MT")
				{
				$cont_status="MTY";
				
				}
				else
				{
				$cont_status=$row2->cont_status;
				}
				$cont_status_final=substr(trim($cont_status), 0, 3);
				
				/*$container_seal_no=str_replace('/','.',$row2->cont_seal_number);
				$container_seal_no2=str_replace('"','',$container_seal_no);
				$container_seal_no3=str_replace("'",'',$container_seal_no2);
				$container_seal_no=explode(",",$container_seal_no3);*/
				
				//Transship IGM
				if($row_igm->type_of_igm=="TS")
					$offdock="BDMGL";
				else
					$offdock=$row2->off_dock_id;
				
				//End TS IGM

				$container_seal_no=remove_numbers($row2->cont_seal_number);
				$container_seal_no=explode(",",$container_seal_no);

				
				$contnumber = $row2->cont_number;
				$strcont = '"'.$contnumber.'"';
				$stringData = "<edi:ediBlEquipment>\n";
				fwrite($fh, $stringData);                                                                
				$stringData = "<edi:ediContainer edi:containerGrossWt=\"" .$row2->cont_gross_weight. "\" edi:containerISOcode=\"" .$row2->cont_iso_type. "\" edi:containerNbr=\"".$row2->cont_number. "\" edi:containerSealNumber1=\"" .$container_seal_no[0]. "\" edi:containerSealNumber2=\"" .$container_seal_no[1].  "\" edi:containerSealNumber4=\"" .$container_seal_no[2]. "\" edi:containerStatus=\"" .$cont_status_final. "\">\n";
				fwrite(	$fh, $stringData );	
				$stringData = "</edi:ediContainer>\n";
				fwrite($fh, $stringData);
				$stringData = "<edi:ediCommodity edi:referenceNbr=\"\" edi:commodityCode=\"" .$commudity_code.  "\" edi:commodityShortName=\"\" edi:commodityDescription=\"\" edi:origin=\"\" edi:destination=\"" .$row2->off_dock_id. "\" edi:shipper=\"\" edi:consignee=\"\">\n";
				fwrite($fh, $stringData);
				$stringData = "</edi:ediCommodity>\n";
				fwrite($fh, $stringData);
				$stringData = "</edi:ediBlEquipment>\n";
				fwrite($fh, $stringData);
				//print "$contnumber"."<br />";
				}
				
				//$Pack_Marks_Number=$row_igm->Pack_Marks_Number;
				//$Pack_Marks_Number=remove_numbers($Pack_Marks_Number);
				//$Description_of_Goods=$row_igm->Description_of_Goods;
				//$Description_of_Goods=remove_numbers($Description_of_Goods);
				
				$Pack_Marks_Number=$row_igm->Pack_Marks_Number;
				$Pack_Marks_Number=remove_numbers($Pack_Marks_Number);
				$Pack_Marks_Number=preg_replace('/[^a-zA-Z0-9_ -.+]/s', '',$Pack_Marks_Number);
				
				$Description_of_Goods=$row_igm->Description_of_Goods;
				$Description_of_Goods=remove_numbers($Description_of_Goods);
				$Description_of_Goods=preg_replace('/[^a-zA-Z0-9_ -.+]/s', '',$Description_of_Goods);
				
				//*************************start******************************
				//$row_igm->weight=15;
				//$row_igm->weight_unit='mton';

				if(!($row_igm->weight=='' and $row_igm->weight_unit==''))
					  {
					  //print($row_igm->weight."<br>".$row_igm->weight_unit."<br>"); 
					  
					  $igm_gross_weight=$row_igm->weight;
					  
					   $weight_unit=strtoupper($row_igm->weight_unit);
					   $weight_unit= str_replace('.','',$weight_unit);
					   $weight_unit= str_replace(' ','',$weight_unit);
					   $ex_mess="";
					  if(($weight_unit=="MTON") Or ($weight_unit=="MTONS"))
									{
									$weight1=$igm_gross_weight * 1000;
									//$ex_mess="Note  : 1 MTON = 1000 KGs";
									}
									else if( ($weight_unit=="TON") or ($weight_unit=="TONS"))
									{
									$weight1=$igm_gross_weight * 1000;
									//$ex_mess="Note : 1 TON = 1000 KGs";
									}									
									else if(($weight_unit=="HTON") or ($weight_unit=="HTONS"))
									{
									$weight1=$igm_gross_weight * 1000 * 1.8;
									//$ex_mess="Note : 1 HTON=1800 KGs";
									}
									else if(($weight_unit=="STON") or ($weight_unit=="STONS" ))
									{
									$weight1=$igm_gross_weight * 907.185;
									//$ex_mess="Note  : 1 STON = 907.185 KGs";
									}									
									else if(($weight_unit=="LTON" ) or ($weight_unit=="LTONS" ))
									{
									$weight1=$igm_gross_weight * 1016.05 ;
									//$ex_mess="Note : 1 LTON = 1016.05 KGs";
									}
									else if($weight_unit=="LBS" )
									{
									$weight1=$igm_gross_weight * 0.453592;
									//$ex_mess="Note : 1 LBS = 0.453592 KGs";
									}
									else
									
									{
									$weight1=$igm_gross_weight;
									
									}
									$weight_unit='KG';
									//print($weight1."<br>");
									//print($weight_unit."<br>");
									
									
				
					  
		}
		
		
		else 
		{
	    print("&nbsp;");
		}
				
				//************************end********************************
				
				/*$stringData = "<edi:ediBlItem edi:quantity=\"" .$row_igm->Pack_Number. "\" edi:type=\"\" edi:weight=
				\"" .$row_igm->weight. "\" edi:weightUnit=\"" .$row_igm->weight_unit. "\" edi:markNumber=
				\"" .$Pack_Marks_Number. "\" edi:description=\"" .$Description_of_Goods. "\">\n";*/
				
				$stringData = "<edi:ediBlItem edi:quantity=\"" .$row_igm->Pack_Number. "\" edi:type=\"\" edi:weight=
				\"" .$weight1. "\" edi:weightUnit=\"" .$weight_unit. "\" edi:markNumber=
				\"" .$Pack_Marks_Number. "\" edi:description=\"" .$Description_of_Goods. "\">\n";
				
				
				fwrite($fh, $stringData);
				$stringData = "<edi:ediCommodity edi:referenceNbr=\"\" edi:commodityCode=\"".$commudity_code."\" edi:commodityShortName=\"\" edi:commodityDescription=\"\" edi:origin=\"\" edi:destination=\"\" edi:shipper=\"\" edi:consignee=\"\">\n";
				fwrite($fh, $stringData);
				$stringData = "</edi:ediCommodity>\n";
				fwrite($fh, $stringData);
				$stringData = "</edi:ediBlItem>\n";
				fwrite($fh, $stringData);
				$stringData = "</edi:ediBlItemHolder>\n";
				fwrite($fh, $stringData);
				$stringData = "</edi:blTransaction>\n";
				fwrite($fh, $stringData);
				
								
				//$contnumber;
				//$this->containerXmlWrite($contnumber,$filename,$file);
					 
			 //  print "#############"."<br>";
			   }
			   
		
		}

	  $stringData = "</edi:blTransactions>\n";
				fwrite($fh, $stringData);
				
				fclose($fh);
				//	include_once("header2.php");
				//include_once("myUpdateManifest.php");
				//include_once("footer.php");
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

		 //*******************************************************ftp start  122.152.53.70****************************************************
			   
			   //$conn = ftp_connect("122.152.53.70") or die ("Cannot connection to host");
		 /* $conn = ftp_connect("10.1.1.7") or die ("Cannot connection to host");
				// send access parameters	
				ftp_login($conn, "ccha", "ccha") or die("Cannot login");
				
				if (file_exists("ftp://ccha:ccha@10.1.1.7/MANIFEST".$myFile)) 
				{
					
					unlink("ftp://ccha:ccha@10.1.1.7/MANIFEST".$myFile);
					
					
					//ftp_delete($conn, "manifest/".$myFile)
				} 	
				// perform file upload
				//$upload = ftp_put($conn, "MANIFEST/$myFile", "/var/www/html/manifest/manifest/$myFile", FTP_BINARY);
				$upload = ftp_put($conn, "MANIFEST/$myFile", $_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/manifest/$myFile", FTP_BINARY);
				// check upload status
				// display message
				if (!$upload) {
				echo "Cannot upload";
				} else {
				echo "Upload complete";
				}
				// close the FTP stream
				ftp_close($conn);*/
				$total=$total+1;
			   
			   //***************************************************************************end**********************************


//} //end function



$date=date("Ymd");
$Time=date("Y-m-d H-i-s");
$user=$this->session->userdata('login_id');
$ip=$this->session->userdata('ip_address');

	//if(file_exists('/var/www/html/manifest/log_manifest/CTMS'.$date.'log.txt'))
	//{
	//rename("/var/www/html/manifest/log_manifest/CTMS".$date."log.txt", "/var/www/html/manifest/log_manifest/CTMS".$datetime."log.txt");
	//}

	$handle111= fopen($_SERVER['DOCUMENT_ROOT'].'/myportpanel/resources/manifest/CTMS'.$date.'log.txt' , 'a') or exit("Unable to open file!"); 

	fwrite(	$handle111,	"Manifest: Total ".$total." file uploaded for menifest $rotation_no on Time $Time by $user IP: $ip\r\n");	

	fclose($handle111);


				//$today = date("Y-m-d h:i:s");

				//print("update igm_for_ctms set read_datetime='$today' where 
				//read_datetime is null and data_type='igm'");

				$igm_for_ctms2=mysql_query("update igm_for_ctms set read_datetime=now() where 
				read_datetime is null and data_type='igm' and igm_master_id='$igm_detail_id'");
		
				if(!($igm_for_ctms2))
				{
					$igm_for_ctms3=mysql_query("update igm_for_ctms set read_datetime='$today' where 
					read_datetime is null and data_type='igm' and igm_master_id='$igm_detail_id'");

				}

				// NEW MANIFEST      END BY ZICO    21.07.2011
				//print("<font color=blue> Successfully for Rotaion $rotation_no</font>");
				 $a.="<font color=green> Successfully for Rotaion $rotation_no<br></font>";
				//echo $a.="<font color=blue><a href='ftp://10.1.1.7/MANIFEST/' target='_BLANK'><b>Click Here to Download File</b></a> </font>";
				// NEW MANIFEST      END BY ZICO    21.07.2011
				
				
				 }			
			else{
			print("<font color=red size='4'> You can not generate XML file before ASYCODA WORLD registration....</font>");
			}
				//include("myupadatectms.php");
				
				
	mysql_close($con_cchaportdb);	

		?>