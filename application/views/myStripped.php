<?php
	//echo "inside striped";
	putenv('TZ=Asia/Dhaka');
	
	include("dbConection.php");
	
	$dt = date('dmYgi');
	$myFile = "Stripping".$dt.".xml";
	
	if(file_exists($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/Stripping/".$myFile))
	{
			unlink($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/Stripping/".$myFile);
	}
	
	$fh= fopen($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/Stripping/".$myFile , 'a');

	$query=mysql_query("SELECT DISTINCT *
	FROM (
	SELECT a.id AS cont_no,NOW() AS datt,
	CASE WHEN a.category ='IMPRT' THEN 'IMPORT' ELSE NULL END AS category,
	g.id AS mlo,
	b.transit_state,
	(SELECT sparcsn4.srv_event.placed_by FROM sparcsn4.srv_event WHERE sparcsn4.srv_event.applied_to_gkey=a.gkey
	 ORDER BY sparcsn4.srv_event.applied_to_gkey DESC LIMIT 1) AS placed_by,
	(SELECT ctmsmis.mis_inv_unit.arcar_id FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey) AS arcar_id,
	(SELECT sparcsn4.srv_event.placed_time FROM sparcsn4.srv_event WHERE sparcsn4.srv_event.applied_to_gkey=a.gkey 
	ORDER BY sparcsn4.srv_event.applied_to_gkey DESC LIMIT 1) AS placed_time, 
	(SELECT ctmsmis.mis_inv_unit.freight_kind FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey) AS freight_kind,
	(SELECT ctmsmis.cont_yard((SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
	FROM sparcsn4.srv_event
	INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
	WHERE sparcsn4.srv_event.applied_to_gkey=a.gkey AND sparcsn4.srv_event.event_type_gkey=18 LIMIT 1))) AS Yard_No,
	(SELECT sparcsn4.srv_event.created FROM  sparcsn4.srv_event 
	INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
	WHERE applied_to_gkey=a.gkey AND event_type_gkey=4 AND sparcsn4.srv_event_field_changes.new_value='E' LIMIT 1) AS proEmtyDate,
	(SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
	FROM sparcsn4.srv_event
	INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
	WHERE sparcsn4.srv_event.applied_to_gkey=a.gkey AND sparcsn4.srv_event.event_type_gkey=18 LIMIT 1) AS carrentPosition,
	b.flex_date01 AS assignmentdate
	FROM sparcsn4.inv_unit a
	INNER JOIN sparcsn4.inv_unit_fcy_visit b ON b.unit_gkey=a.gkey
	INNER JOIN sparcsn4.ref_bizunit_scoped g ON a.line_op = g.gkey
	INNER JOIN sparcsn4.config_metafield_lov ON a.flex_string01=config_metafield_lov.mfdch_value
	INNER JOIN
			sparcsn4.inv_goods j ON j.gkey = a.goods
	LEFT JOIN
			sparcsn4.ref_bizunit_scoped k ON k.gkey = j.consignee_bzu
	WHERE DATE(b.flex_date01)='$fromdate' AND config_metafield_lov.mfdch_value NOT IN ('OCD','APPCUS','APPOTH','APPREF')

	) AS tmp WHERE Yard_No='GCB' ORDER BY Yard_No,proEmtyDate");
 
	$title = "<?xml version='1.0' encoding='UTF-8'?>\n";
	fwrite($fh, $title);
	$headingstart = '<argo:snx xmlns:argo="http://www.navis.com/argo" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.navis.com/argo snx.xsd">'."\n";
	fwrite($fh, $headingstart);

	while($row=mysql_fetch_object($query)){	

	$contDatastart	='<unit update-mode="REPLACE" id="'.$row->cont_no.'" category="'.$row->category.'" restow="NONE" transit-state="YARD" freight-kind="'.$row->freight_kind.'" line="'.$row->mlo.'" unique-key="'.$row->cont_no.':'.$row->datt.'" >'."\n";
	fwrite($fh, $contDatastart);

	$position = '<position loc-type="YARD" location="CGP" slot="'.$row->carrentPosition.'" />'."\n";
	fwrite($fh, $position);
	$routing = ' <routing pod-1="CGP" pod-1-name="Bangladesh" destination="2591" origin="FCL">'."\n";
	fwrite($fh, $routing);
	$carrier1 = '<carrier direction="IB" qualifier="DECLARED" mode="TRUCK" />'."\n";
	fwrite($fh, $carrier1);
	$carrier2 = '<carrier direction="IB" qualifier="ACTUAL" mode="TRUCK" />'."\n";
	fwrite($fh, $carrier2);
	$carrier3 = '<carrier direction="OB" qualifier="DECLARED" mode="UNKNOWN" />'."\n";
	fwrite($fh, $carrier3);
	$carrier4 = '<carrier direction="OB" qualifier="ACTUAL" mode="UNKNOWN" />'."\n";
	fwrite($fh, $carrier4);
	$routingend = "</routing>\n";
	fwrite($fh, $routingend);
	$historyStart = "<non-move-history>\n";
	fwrite($fh, $historyStart);
	$eventdata ='<event id="UNIT_STRIP" note="Stripped" time-event-applied="'.$row->placed_time.'" user-id="'.$row->placed_by.'" is-billable="Y">'."\n";
	fwrite($fh, $eventdata);
	$fieldchanges = "<field-changes>\n";
	fwrite($fh, $fieldchanges);
	$gdsOrigin = ' <field-change id="gdsOrigin" new-value="FCL" prev-value="FCL" />'."\n";
	fwrite($fh, $gdsOrigin);
	$fieldchangesend = "</field-changes>\n";
	fwrite($fh, $fieldchangesend);
	$eventend = "</event>\n";
	fwrite($fh, $eventend);

	$historyend = "</non-move-history>\n";
	fwrite($fh, $historyend);
	$contDataend = "</unit>\n";
	fwrite($fh, $contDataend);
	}
	$headingEnd = "</argo:snx>\n";
	fwrite($fh, $headingEnd);
	fclose($fh);
	mysql_close($con_sparcsn4);

if (file_exists($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/Stripping/".$myFile))
 {
  $file = $_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/Stripping/".$myFile;
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

