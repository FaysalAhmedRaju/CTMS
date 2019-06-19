<?php

	putenv('TZ=Asia/Dhaka');
	
	
	include("dbConection.php");
	$visit=trim($_POST['visit']);
	
	$date=date("ymd:hi");
	$date2=date("Ymdhis");
	$UNB = "<?xml version='1.0' encoding='UTF-8'?>\n";
	$UNB = $UNB.'<argo:snx xmlns:argo="http://www.navis.com/argo" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.navis.com/argo snx.xsd">'."\n";
	$NAD = "";
	$END = "";
	
	$strMain = "select * from ctmsmis.mis_pangoan_unit where visit_id='$visit'";
	//echo $strMain."<hr>";
	$resMain = mysql_query($strMain);
	$st = 0;
	$tbl = "<table border='1'><tr><td colspan='5'><b>Listed Containers are need to be depart</b></td></tr><tr><th>Container</th><th>Category</th><th>Status</th><th>MLO</th><th>Iso Type</th></tr>";
	while($rowMain= mysql_fetch_object($resMain))
	{	
		$strTrans = "select sparcsn4.inv_unit_fcy_visit.transit_state,sparcsn4.inv_unit.category from sparcsn4.inv_unit 
		inner join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
		where sparcsn4.inv_unit.id='$rowMain->cont_id' order by sparcsn4.inv_unit_fcy_visit.gkey";
		//echo $strTrans."<hr>";
		$resTrans = mysql_query($strTrans);
		$Trans="";
		$cat="";
		while($rowTrans = mysql_fetch_object($resTrans))
		{
			$Trans=$rowTrans->transit_state;
			$cat=$rowTrans->category;
		}
		$s = 0;
		if($Trans=="S60_LOADED" or $Trans=="S20_INBOUND" or $Trans=="S40_YARD")
			$s = 1;
		if($s==0)
		{
			$NAD=$NAD.'<unit id="'.$rowMain->cont_id.'" category="'.$rowMain->category.'" transit-state="INBOUND" visit-state="ACTIVE" freight-kind="'.$rowMain->fried_kind.'" weight-kg="'.$rowMain->gross_weight.'"  line="'.$rowMain->mlo.'"  xml-status="0">'."\n";			
			$NAD=$NAD.'<equipment eqid="'.$rowMain->cont_id.'" type="'.$rowMain->iso_code.'" class="CTR" life-cycle-state="ACT" role="PRIMARY"></equipment>'."\n";
			$NAD=$NAD.'<routing pol="CGP" pod-1="CGP">'."\n";
			$NAD=$NAD.'<carrier direction="IB" qualifier="DECLARED" mode="VESSEL" id="'.$rowMain->visit_id.'"></carrier>'."\n";
			$NAD=$NAD.'<carrier direction="IB" qualifier="ACTUAL" mode="VESSEL" id="'.$rowMain->visit_id.'"></carrier>'."\n";
			$NAD=$NAD.'<carrier direction="OB" qualifier="DECLARED" mode="VESSEL" id="GEN_CARRIER"></carrier>'."\n";
			$NAD=$NAD.'<carrier direction="OB" qualifier="ACTUAL" mode="VESSEL" id="GEN_CARRIER"></carrier>'."\n";
			$NAD=$NAD.'</routing>'."\n";
			$NAD=$NAD.'<contents weight-kg="'.$rowMain->gross_weight.'"/>'."\n";
			$NAD=$NAD.'<unit-etc category="'.$rowMain->category.'" line="'.$rowMain->mlo.'"/>'."\n";
			if($rowMain->fried_kind=="FCL" or $rowMain->fried_kind=="LCL")
			{
				$NAD=$NAD.'<seals seal-1="'.$rowMain->seal.'" />'."\n";
			}
				
			$NAD=$NAD.'</unit>'."\n";
		}
		else if($s==1)
		{
			$tbl = $tbl."<tr><td>$rowMain->cont_id</td><td>$rowMain->category</td><td>$rowMain->fried_kind</td><td>$rowMain->mlo</td><td>$rowMain->iso_code</td></tr>";
			$strCont = $strCont.$rowMain->cont_id.", ";
			$st++;
		}
	}
	$tbl = $tbl."<tr><td colspan='5'>$strCont</td></tr></table>";
	//echo $NAD;
	$END = $END.'</argo:snx>'."\n";
	//echo $END;
	if($st>0)
	{
		$data['msg'] = $tbl;
		$data['title']="CONVERT COPINO...";
		$this->load->view('header2');
		$this->load->view('convertPanContForm',$data);
		$this->load->view('footer');
		return;
	}
	$file_old = $visit;
	$myFile_old="PANGOAN-".$file_old.'.xml';
	if(file_exists($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/pangoan/xml/".$myFile_old))
	{
		unlink($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/pangoan/xml/".$myFile_old);
	}
	$fh= fopen($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/pangoan/xml/".$myFile_old , 'a');
	fwrite($fh, $UNB);		
	fwrite($fh, $NAD);
	fwrite($fh, $END);
	fclose($fh);
		

	if (file_exists($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/pangoan/xml/".$myFile_old))
	{
		$file = $_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/pangoan/xml/".$myFile_old;
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
	
 
?>

