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
	
	$strMain = "SELECT ctmsmis.mis_assignment_entry.unit_gkey,cont_id,ctmsmis.mis_assignment_entry.consignee,BL_No,rotation,CONCAT(DATE(propose_date),'T',TIME(propose_date)) AS propose_date,
	mfdch_value,sparcsn4.ref_bizunit_scoped.id AS mlo,sparcsn4.argo_carrier_visit.id AS visit_id,sparcsn4.inv_goods.destination,sparcsn4.inv_unit_fcy_visit.flex_date01,
	IF(ctmsmis.mis_assignment_entry.remarks IS NULL OR ctmsmis.mis_assignment_entry.remarks='','NT',ctmsmis.mis_assignment_entry.remarks) AS remarks
	FROM ctmsmis.mis_assignment_entry
	INNER JOIN sparcsn4.inv_unit ON sparcsn4.inv_unit.gkey=ctmsmis.mis_assignment_entry.unit_gkey
	INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.inv_unit.line_op
	INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
	INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
	LEFT JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
	WHERE snx_stat=0 ORDER BY last_update ASC";
	//echo $strMain."<hr>";
	$resMain = mysql_query($strMain);
	$st = 0;
	//$tbl = "<table border='1'><tr><td colspan='5'><b>Listed Containers are need to be depart</b></td></tr><tr><th>Container</th><th>Category</th><th>Status</th><th>MLO</th><th>Iso Type</th></tr>";
	while($rowMain= mysql_fetch_object($resMain))
	{	
		/*$strTrans = "select sparcsn4.inv_unit_fcy_visit.transit_state,sparcsn4.inv_unit.category from sparcsn4.inv_unit 
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
		{*/
			$NAD=$NAD.'<unit update-mode="REPLACE" id="'.$rowMain->cont_id.'" category="IMPORT" restow="NONE" transit-state="YARD" freight-kind="FCL" line="'.$rowMain->mlo.'">'."\n";			
			//$NAD=$NAD.'<equipment eqid="'.$rowMain->cont_id.'" type="'.$rowMain->iso_code.'" class="CTR" life-cycle-state="ACT" role="PRIMARY"></equipment>'."\n";
			$NAD=$NAD.'<routing pod-1="CGP" pod-1-name="Bangladesh" destination="'.$rowMain->destination.'">'."\n";
			$NAD=$NAD.'<carrier direction="IB" qualifier="DECLARED" mode="VESSEL" id="'.$rowMain->visit_id.'"></carrier>'."\n";
			$NAD=$NAD.'<carrier direction="IB" qualifier="ACTUAL" mode="VESSEL" id="'.$rowMain->visit_id.'"></carrier>'."\n";
			$NAD=$NAD.'<carrier direction="OB" qualifier="DECLARED" mode="TRUCK"></carrier>'."\n";
			$NAD=$NAD.'<carrier direction="OB" qualifier="ACTUAL" mode="TRUCK"></carrier>'."\n";
			$NAD=$NAD.'</routing>'."\n";
			$NAD=$NAD.'<contents  consignee-id="'.$rowMain->consignee.'" bl-nbr="'.$rowMain->BL_No.'"/>'."\n";
			if($rowMain->remarks=='NT'){
				$NAD=$NAD.'<unit-flex unit-flex-1="'.$rowMain->mfdch_value.'" unit-flex-7="YES"/>'."\n";
			}
			else {
				$NAD=$NAD.'<unit-flex unit-flex-1="'.$rowMain->mfdch_value.'" unit-flex-7="YES" unit-flex-15="'.$rowMain->remarks.'"/>'."\n";
			}
			$NAD=$NAD.'<ufv-flex ufv-flex-6="W" ufv-flex-9="LON" ufv-flex-date-1="'.$rowMain->propose_date.'" />'."\n";
				
			$NAD=$NAD.'</unit>'."\n";
		/*}
		else if($s==1)
		{
			$tbl = $tbl."<tr><td>$rowMain->cont_id</td><td>$rowMain->category</td><td>$rowMain->fried_kind</td><td>$rowMain->mlo</td><td>$rowMain->iso_code</td></tr>";
			$strCont = $strCont.$rowMain->cont_id.", ";
			$st++;
		}*/
		$strUpdate = "UPDATE ctmsmis.mis_assignment_entry SET snx_stat=1 WHERE unit_gkey=$rowMain->unit_gkey";
		$resUpdate = mysql_query($strUpdate);
	}
	//$tbl = $tbl."<tr><td colspan='5'>$strCont</td></tr></table>";
	//echo $NAD;
	$END = $END.'</argo:snx>'."\n";
	//echo $END;
	/*if($st>0)
	{
		$data['msg'] = $tbl;
		$data['title']="CONVERT COPINO...";
		$this->load->view('header2');
		$this->load->view('convertPanContForm',$data);
		$this->load->view('footer');
		return;
	}*/
	$file_old = $date2;
	$myFile_old="Assignment-".$file_old.'.xml';
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
	
 mysql_close($con_sparcsn4);
?>

