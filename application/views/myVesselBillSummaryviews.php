<?php

	$link = mysql_connect('10.1.1.21:3306', 'sparcsn4', 'sparcsn4');
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	$selected = mysql_select_db("ctmsmis",$link)
	or die("Could not select DB");
	if($selected)

	$myFile = "BillSummary.txt";
	
	if(file_exists($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/Summary/".$myFile))
	{
			unlink($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/Summary/".$myFile);
	}
	
	$fh= fopen($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/Summary/".$myFile , 'a');
	
	 $query=mysql_query("select bill_name as invoiceDesc,if(cnt_code='BD',concat('JL/',mis_vsl_billing_detail.draftNumber,'-',substring(billing_date,4,1)),
	concat('JF/',mis_vsl_billing_detail.draftNumber,'-',substring(billing_date,4,1))) as draftNumber,vsl_name as vesselName,
	rotation as ibVoyageNbr,master_name as captain,atd as ATD,ata as ATA,agent_name as customerName,
	agent_code,agent_alias_id AgentCode,agent_address,grt as grossRevenueTons,exchangeRate as exchangeRate,
	billing_date as created,berth as berth,flag as flagcountry,deck_cargo as cargo,oa_date as ffd,description as description,concat(gl_code,'0') as glcode,rate as rateBilled,bas as quantityUnit,
	IF(description LIKE 'BERTH_HIRE_1%',mis_vsl_billing_detail.unit,
	mis_vsl_billing_sub_detail.unit_for_pilot) as quantityBilled,if(description LIKE 'BERTH_HIRE_1%',((grt+ifnull(deck_cargo,0))*rate*unit),(rate*mis_vsl_billing_sub_detail.unit_for_pilot)) as totusd,creator,
	if(description LIKE 'BERTH_HIRE_1%',((grt+ifnull(deck_cargo,0))*rate*unit*exchangeRate),

	(rate*mis_vsl_billing_sub_detail.unit_for_pilot*exchangeRate)) as totbsd,  'DRAFT' as status 
	from ctmsmis.mis_vsl_billing_detail
	inner join ctmsmis.mis_vsl_billing_sub_detail on mis_vsl_billing_sub_detail.draftNumber=ctmsmis.mis_vsl_billing_detail.draftNumber 
	where date(billing_date)BETWEEN '$fromdate' AND '$todate'");
	
	//$result = mysql_query($query);
	while($row=mysql_fetch_object($query)){
	$line=$row->draftNumber."|".$row->invoiceDesc."|".$row->vesselName."|".$row->ibVoyageNbr."|".$row->captain."|".$row->customerName."|".$row->agent_code."|".$row->AgentCode."|".$row->agent_address."|".$row->grossRevenueTons."|".$row->exchangeRate."|".$row->flagcountry."|".$row->description."|".$row->rateBilled;
	$line=$line."|".$row->quantityUnit."|".$row->quantityBilled."|".$row->totusd."|".$row->totbsd."\n";
	fwrite($fh, $line);
	
	}
	
	fclose($fh);
	mysql_close($link);
	if (file_exists($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/Summary/".$myFile))
	{
  $file = $_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/Summary/".$myFile;
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
		echo "File does not exists";
	}
	

	
	
 
?>

