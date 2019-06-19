<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		
		<TITLE>Bearth Operator</TITLE>
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
		header("Content-Disposition: attachment; filename=Reefer_list.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}
	include("dbConection.php");
	
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<!--title>Import Reffer Container Discharge List</title-->
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr colspan="2">
	<td align="center"><h1>চট্টগ্রাম বন্দর কর্তৃপক্ষ</h1></td>
</tr>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td align="center">
			<table border=0 width="100%">				
				
				<tr colspan="2">
					<td>পত্র নং-চবক/উউসপ্র  (বি)  /সিজিডি/রিফার/২০১/   </td>
					<td style=""><nobr>তারিখঃ&nbsp;&nbsp;/&nbsp;&nbsp;/২০১</nobr> </td>
				</tr>
				<tr colspan="2">
					<td>বরাবরে,</td>
				</tr>
				<tr colspan="2">
					<td style="padding-left:50px">টি.আই / কন্টেইনার বিল শাখা,</td>
				</tr>
				<tr colspan="2">
					<td style="padding-left:50px">টার্মিনাল ভবন / চবক</td>
				</tr>
				<tr colspan="2">
					<td><nobr>বিষয়ঃ&nbsp;&nbsp;/&nbsp;&nbsp;/২০১&nbsp; ইং তারিখে চবক এর ডি-রিফার ইয়ারডে রিফার সংযোগ ও বিচ্ছিন্ন করণ প্রতিবেদন প্রসঙ্গে ।</nobr></td>
				</tr>
				<tr colspan="2">
					<td><u>সূত্রঃ-মাননীয় চেয়ারম্যান/চবক মহোদয়ের দপ্তরাদেশ নং-০১/৮৯ তাং-২২/০১/৮৯ ইং ও টার্মিনাল ম্যানেজার/চবক এর পত্র নং-কাক/রিফার/৩৯/অংশ-১ তাং-&nbsp;/০৯/৯৩ ইং ।</u></td>
				</tr>
				<tr colspan="2">
					<td style="padding-left:50px"></td>
				</tr>
				<tr colspan="2">
					<td><p>উপরোক্ত সূত্র মোতাবেক চবক এর ডি-রিফার ইয়ার্ডে &nbsp;&nbsp;/&nbsp;&nbsp;/২০১&nbsp; ইং তারিখে যে সমস্ত রিপার কন্টেইনার এ বিদ্যুত সংযোগ প্রদান ও বিচ্ছিন্ন করা হয়েছে তার তালিকা নিম্নে প্রদত্ত হল। সংযুক্ত তালিকা অনুযায়ী সংশ্লিষ্ট এজেন্টের নিকট থেকে বিদ্যুত চার্জ আদায়ের পরবর্তী প্রয়োজনীয় ব্যবস্থা গ্রহণের জন্য অনুরোধ করা গেল।</p></td>
				</tr>

			</table>
		
		</td>
		
	</tr>
	
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr>
	</table>
	<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
	<tr  align="center">
		<td ><b>ক্রঃনং</b></td>
		<td ><b>এজেন্টের নাম</b></td>
		<td ><b>কন্টেইনার সংখ্যা</b></td>
		<td ><b>মন্তব্য</b></td>
	</tr>

<?php
if($yard_no=="All")
		{
			$queryAll="SELECT * FROM
						(
						SELECT id,

						(SELECT id FROM sparcsn4.ref_bizunit_scoped WHERE gkey=temp.line_op) AS mlo,
						(SELECT sparcsn4.srv_event.creator
												FROM sparcsn4.srv_event
												INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
												WHERE sparcsn4.srv_event.applied_to_gkey=temp.gkey AND sparcsn4.srv_event_field_changes.new_value IS NOT NULL 
												AND sparcsn4.srv_event_field_changes.new_value LIKE'%BDT' AND sparcsn4.srv_event.event_type_gkey=4 
												ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1) AS creator,
						(SELECT SUBSTR(UCASE(creator),1,3)) AS yard,

						tot_container
						FROM
						(
						SELECT sparcsn4.inv_unit.gkey,sparcsn4.inv_unit.id,sparcsn4.inv_unit.line_op,COUNT(sparcsn4.inv_unit.id) AS tot_container
												FROM sparcsn4.inv_unit
												INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey
												INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
												WHERE DATE(inv_unit_fcy_visit.flex_date04) BETWEEN '$fromdate' AND '$todate'
												GROUP BY sparcsn4.inv_unit.line_op   /*Reffer Connection 1*/

												UNION ALL

												SELECT inv_unit.gkey,inv_unit.id,sparcsn4.inv_unit.line_op,
												COUNT(sparcsn4.inv_unit.id) AS tot_container
												FROM sparcsn4.inv_unit
												INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey
												INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
												WHERE DATE(inv_unit_fcy_visit.flex_date06) BETWEEN '$fromdate' AND '$todate'    /*Reffer Connection 2*/

												UNION ALL

												SELECT inv_unit.gkey,inv_unit.id,sparcsn4.inv_unit.line_op,
												COUNT(sparcsn4.inv_unit.id) AS tot_container
												FROM sparcsn4.inv_unit
												INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey
												INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
												WHERE DATE(inv_unit_fcy_visit.flex_date08) BETWEEN '$fromdate' AND '$todate'     /*Reffer Connection 3*/
												) AS temp ) AS final order by mlo";
			$rtnQueryAll=mysql_query($queryAll);			
		
		}
		else
		{
			//echo "hh";
			$login_id = $this->session->userdata('login_id');
			$queryAll="SELECT * FROM
						(
						SELECT id,

						(SELECT id FROM sparcsn4.ref_bizunit_scoped WHERE gkey=temp.line_op) AS mlo,
						(SELECT sparcsn4.srv_event.creator
												FROM sparcsn4.srv_event
												INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
												WHERE sparcsn4.srv_event.applied_to_gkey=temp.gkey AND sparcsn4.srv_event_field_changes.new_value IS NOT NULL 
												AND sparcsn4.srv_event_field_changes.new_value LIKE'%BDT' AND sparcsn4.srv_event.event_type_gkey=4 
												ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1) AS creator,
						(SELECT SUBSTR(UCASE(creator),1,3)) AS yard,

						tot_container
						FROM
						(
						SELECT sparcsn4.inv_unit.gkey,sparcsn4.inv_unit.id,sparcsn4.inv_unit.line_op,COUNT(sparcsn4.inv_unit.id) AS tot_container
												FROM sparcsn4.inv_unit
												INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey
												INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
												WHERE DATE(inv_unit_fcy_visit.flex_date04) BETWEEN '$fromdate' AND '$todate'
												GROUP BY sparcsn4.inv_unit.line_op   /*Reffer Connection 1*/

												UNION ALL

												SELECT inv_unit.gkey,inv_unit.id,sparcsn4.inv_unit.line_op,
												COUNT(sparcsn4.inv_unit.id) AS tot_container
												FROM sparcsn4.inv_unit
												INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey
												INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
												WHERE DATE(inv_unit_fcy_visit.flex_date06) BETWEEN '$fromdate' AND '$todate'    /*Reffer Connection 2*/

												UNION ALL

												SELECT inv_unit.gkey,inv_unit.id,sparcsn4.inv_unit.line_op,
												COUNT(sparcsn4.inv_unit.id) AS tot_container
												FROM sparcsn4.inv_unit
												INNER JOIN sparcsn4.inv_unit_fcy_visit ON inv_unit_fcy_visit.unit_gkey=inv_unit.gkey
												INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
												WHERE DATE(inv_unit_fcy_visit.flex_date08) BETWEEN '$fromdate' AND '$todate'     /*Reffer Connection 3*/
												) AS temp ) AS final WHERE yard='$yard_no' order by mlo";
			//echo $queryAll;
			$rtnQueryAll=mysql_query($queryAll);
			
		}

	$i=0;
	$j=0;
	
	$mlo="";
	while($row=mysql_fetch_object($rtnQueryAll)){
	$i++;
	
		
	
?>

<tr align="center">
		<td><?php  echo $i;?></td>
		<td><?php if($row->mlo) echo $row->mlo; else echo "&nbsp;";?></td>
		<td><?php if($row->tot_container) echo $row->tot_container; else echo "&nbsp;";?></td>
		<td><?php echo "&nbsp;"; ?></td>

	</tr>

<?php } ?>
</table>
<br />
<br />
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
	<tr colspan="2">
		<td><br></td>
	</tr>
	<tr colspan="2">
		<td><br></td>
	</tr>
	<tr colspan="2">
		<td>অনুলিপিঃ</td>
	</tr>
	<tr colspan="2">
		<td>১। নিপ্রি(বি)/সিটি/চবক মহোদয়ের সদয় অবগতির জন্য সপ্র৯(বি)/জেটি/চবক এর মাধ্যমে দেওয়া গেল।</td>
	</tr>
	<tr colspan="2">
		<td>২। সিটিএমএস এ ডাটা সঠিকভাবে এন্ট্রি যাচাই করার জন্য, সিটিএমএস(অপাঃ রুম)/ডাটাসফট এর পরবর্তী প্রয়োজনীয় ব্যবস্থার জন্য এক কপি প্রেরণ করা হলো।</td>
	</tr>
	<tr colspan="2">
		<td><br></td>
	</tr>
	<tr colspan="2">
		<td><br></td>
	</tr>
	<tr colspan="2">
		<td><br></td>
	</tr>	
	<tr colspan="2">
		<td><br></td>
	</tr>
	<tr>
		<td>উউসপ্র(বি)/সিজিডি<br>চট্টগ্রাম বন্দর কর্তৃপক্ষ।</td>
		<td>উসপ্র(বি)/ইএসএস ৩ ও ৪<br>চট্টগ্রাম বন্দর কর্তৃপক্ষ।</td> 
	</tr>
</table>


<?php 
//mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
