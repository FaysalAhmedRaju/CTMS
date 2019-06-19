<?php

	putenv('TZ=Asia/Dhaka');
	
	
	include("dbConection.php");
	$rotation_no=$_POST['ddl_imp_rot_no'];
   
	$strVslName = "select name,sparcsn4.argo_carrier_visit.id from sparcsn4.vsl_vessel_visit_details
	inner join sparcsn4.argo_carrier_visit on sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
	inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
	where ib_vyg='$rotation_no' order by sparcsn4.argo_carrier_visit.gkey desc limit 1";
	$resVslName = mysql_query($strVslName);
	$rowVslName = mysql_fetch_object($resVslName);
	$vslName = $rowVslName->name;
	$arcar_id = $rowVslName->id;
	$strAgent = "select distinct agent from ctmsmis.mis_exp_unit_preadv_req where preAddStat=1 and rotation ='$rotation_no'";
	
	$resAgent = mysql_query($strAgent);
	$rowAgent= mysql_fetch_object($resAgent);	
	$agent = $rowAgent->agent;
	
	$date=date("ymd:hi");
	$date2=date("Ymdhis");
	$UNB = "<?xml version='1.0' encoding='UTF-8'?>\n";
	$UNB = $UNB.'<argo:snx xmlns:argo="http://www.navis.com/argo" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.navis.com/argo snx.xsd">'."\n";
	
	$NAD = "";
	$END = "";
	//echo $UNB."\n========End head=====\n";
	/*$strMain = "select * from
	(
	select *,
	(case 
	when cat='EXPRT' and transit_state in('S60_LOADED','S70_DEPARTED') then 1
	when cat in ('IMPRT','STRGE') and transit_state='S20_INBOUND' then 1 
	else 0 end
	) as s 
	from
	(
	select ctmsmis.mis_exp_unit_preadv_req.gkey,cont_id,cont_status,cont_mlo,isoType,cont_size,cont_height,vvd_gkey,rotation,seal_no,
	(select place_code from sparcsn4.ref_unloc_code where id=ctmsmis.mis_exp_unit_preadv_req.pod) as pod,
	(select place_name from sparcsn4.ref_unloc_code where id=ctmsmis.mis_exp_unit_preadv_req.pod) as pod1,
	(select id from sparcsn4.argo_carrier_visit where sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit_preadv_req.vvd_gkey) as arcar_id,
	commodity_code,goods_and_ctr_wt_kg,
	(select commudity_desc from ctmsmis.commudity_detail where commudity_code=ctmsmis.mis_exp_unit_preadv_req.commodity_code) as commudity_desc,
	(select category from sparcsn4.inv_unit where id=ctmsmis.mis_exp_unit_preadv_req.cont_id order by gkey desc limit 1) as cat,
	sparcsn4.inv_unit_fcy_visit.transit_state
	from ctmsmis.mis_exp_unit_preadv_req 
	inner join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=ctmsmis.mis_exp_unit_preadv_req.gkey
	where preAddStat=1 and rotation ='$rotation_no' and sparcsn4.inv_unit_fcy_visit.transit_state !='S40_YARD' and date(last_update)=date(now()) limit 500,1100
	) as tbl
	) as final where s !=1
	";*/
	$strMain = "select gkey,cont_id,cont_status,cont_mlo,isoType,cont_size,cont_height,vvd_gkey,rotation,seal_no,seal_no4,commodity_code,goods_and_ctr_wt_kg,pod
	from
	(
	select * from ctmsmis.mis_exp_unit_preadv_req 
	where preAddStat=1 and rotation ='$rotation_no' and date(last_update)=date(now()) 
	) as tbl
	";
	//echo $strMain."<hr>";
	$resMain = mysql_query($strMain);
	$i = 0;
	$st = 0;
	$strCont = "";
	$tbl = "<table border='1'><tr><td colspan='5'><b>Listed Containers are need to be depart</b></td></tr><tr><th>Container</th><th>Category</th><th>Status</th><th>MLO</th><th>Transit State</th></tr>";
	
	while($rowMain= mysql_fetch_object($resMain))
	{
	
		$strPod = "select place_code,place_name from sparcsn4.ref_unloc_code where id='$rowMain->pod'";
		$resPod = mysql_query($strPod);
		$rowPod = mysql_fetch_object($resPod);
		$pod = $rowPod->place_code;
		$pod1 = $rowPod->place_name;
		
		/*$strCat = "select category from sparcsn4.inv_unit where id='$rowMain->cont_id'";
		$resCat = mysql_query($strCat);
		$cat="";
		
		while($rowCat = mysql_fetch_object($resCat))
		{
			$cat=$rowCat->category;
		}
		*/
		$strTrans = "select sparcsn4.inv_unit_fcy_visit.transit_state,sparcsn4.inv_unit.category,sparcsn4.argo_carrier_visit.carrier_mode
		from sparcsn4.inv_unit 
		inner join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
		inner join sparcsn4.argo_carrier_visit on sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
		where sparcsn4.inv_unit.id='$rowMain->cont_id' order by sparcsn4.inv_unit_fcy_visit.gkey";
		//echo $strTrans."<hr>";
		$resTrans = mysql_query($strTrans);
		$Trans="";
		$cat="";
		$carrier_mode="";
		while($rowTrans = mysql_fetch_object($resTrans))
		{
			$Trans=$rowTrans->transit_state;
			$cat=$rowTrans->category;
			$carrier_mode=$rowTrans->carrier_mode;
		}
		
		$strCommodity = "select commudity_desc from ctmsmis.commudity_detail where commudity_code='$rowMain->commodity_code'";
		$resCommodity = mysql_query($strCommodity);
		$rowCommodity = mysql_fetch_object($resCommodity);
		$commudity_desc= $rowCommodity->commudity_desc;
		$s = 0;
		if($Trans=="S40_YARD" or $Trans=="S50_ECOUT")
			$s = 1;
		else if($cat=="EXPRT" and ($Trans=="S60_LOADED" or $Trans=="S70_DEPARTED" or $Trans=="S99_RETIRED"))
			$s = 1;
		else if(($cat=="IMPRT" or $cat=="STRGE") and $Trans=="S20_INBOUND")
			$s = 1;	
		else if(($carrier_mode=="TRAIN" or $carrier_mode=="VESSEL") and $Trans=="S20_INBOUND")
			$s = 1;	
		else if(($cat=="IMPRT" or $cat=="STRGE") and $Trans=="S60_LOADED")
			$s = 2;	
		
		if($s==0)
		{
			$strUpdateCont = "update sparcsn4.inv_unit set foreignhost_key=NULL where id='$rowMain->cont_id' and category='EXPRT'";
			mysql_query($strUpdateCont);
			/*if($rowMain->cont_id=='MEDU3783577')
			{
				echo $cat."-".$rowMain->transit_state;
				return;
			}*/
			if($cat=='EXPRT' and ($Trans=="S20_INBOUND" or $Trans=="S10_ADVISED"))
				$NAD=$NAD.'<unit update-mode="REPLACE" id="'.$rowMain->cont_id.'" category="EXPORT" restow="NONE" transit-state="INBOUND" freight-kind="'.$rowMain->cont_status.'" line="'.$rowMain->cont_mlo.'">'."\n";
			else
				$NAD=$NAD.'<unit id="'.$rowMain->cont_id.'" category="EXPORT" restow="NONE" transit-state="INBOUND" freight-kind="'.$rowMain->cont_status.'" line="'.$rowMain->cont_mlo.'">'."\n";
			
			$NAD=$NAD.'<routing pol="CGP" pol-name="Bangladesh" pod-1="'.$pod.'" pod-1-name="'.$pod1.'">'."\n";
			$NAD=$NAD.'<carrier direction="IB" qualifier="DECLARED" mode="TRUCK" />'."\n";
			$NAD=$NAD.'<carrier direction="IB" qualifier="ACTUAL" mode="TRUCK" />'."\n";
			$NAD=$NAD.'<carrier direction="OB" qualifier="DECLARED" mode="VESSEL" id="'.$arcar_id.'" />'."\n";
			$NAD=$NAD.'<carrier direction="OB" qualifier="ACTUAL" mode="VESSEL" id="'.$arcar_id.'" />'."\n";
			$NAD=$NAD.'</routing>'."\n";
			$NAD=$NAD.'<contents weight-kg="'.$rowMain->goods_and_ctr_wt_kg.'"  commodity-id="'.$rowMain->commodity_code.'" commodity-name="'.$commudity_desc.'" />'."\n";
			$NAD=$NAD.'<unit-etc category="EXPORT" line="'.$rowMain->cont_mlo.'" />'."\n";
			
			if(trim($rowMain->cont_status)=="FCL" or trim($rowMain->cont_status)=="LCL")
				$NAD=$NAD.'<seals seal-1="'.$rowMain->seal_no.'" seal-4="'.$rowMain->seal_no4.'"/>'."\n";
			else
				$NAD=$NAD.'<seals seal-1="'.$rowMain->seal_no.'" />'."\n";
			
			$NAD=$NAD.'</unit>'."\n";
		}
		else if($s==2)
		{
			$tbl = $tbl."<tr><td>$rowMain->cont_id</td><td>$cat</td><td>$rowMain->cont_status</td><td>$rowMain->cont_mlo</td><td>$Trans</td></tr>";
			$strCont = $strCont.$rowMain->cont_id.", ";
			$st++;
		}
	}	
	$tbl = $tbl."<tr><td colspan='5'>$strCont</td></tr></table>";
	if($st>0)
	{
		$data['msg'] = $tbl;
		$data['title']="CONVERT COPINO...";
		$this->load->view('header2');
		$this->load->view('myConvertCopinoForm',$data);
		$this->load->view('footer');
		return;
	}
	//echo $NAD;
	$END = $END.'</argo:snx>'."\n";
	//echo $END;
	$file_old = $agent."-".$rotation."-".$vslName;
	$myFile_old="COPINO-".$file_old.'.xml';
	if(file_exists($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/copino/".$myFile_old))
	{
		unlink($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/copino/".$myFile_old);
	}
	$fh= fopen($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/copino/".$myFile_old , 'a');
	fwrite($fh, $UNB);		
	fwrite($fh, $NAD);
	fwrite($fh, $END);
	fclose($fh);
		

	if (file_exists($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/copino/".$myFile_old))
	{
		$file = $_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/copino/".$myFile_old;
		$fp = fopen($file, 'rb');
		$myFile_old = str_replace(' ','-',$myFile_old);
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=".basename($myFile_old));
		header("Content-Length: ". filesize($file ));
		fpassthru($fp);
		fclose($fp);
		exit;
	}else
	{
		echo "File does not exists";
	}



	function concatstaus($str)
    {
		$vl = "";	 
		if($str=="I")
			$vl = "3";
		elseif($str=="E")
			$vl = "2";
		elseif($str=="T")
			$vl = "6";
		elseif($str=="FCL")
			$vl = "5";
		elseif($str=="MTY")
			$vl = "4";
	 
		return $vl;
	}
	

	function remove_numbers($string) 
	{
		$spchar = array("\n","&",'"',"'","/",">","<","^","  ","~");
		$string = str_replace($spchar, '', $string);				
		$string=substr($string, 0, 80);
		return $string;				
	} 
	
 mysql_close($con_sparcsn4);
?>

