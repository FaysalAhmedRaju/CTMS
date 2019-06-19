
<?php $ddl_imp_rot_no=$_REQUEST['ddl_imp_rot_no']; 

	//$con=mysql_connect("10.1.1.6", "user1","user1test")or die("cannot connect"); 
	//$con=mysql_connect("192.168.16.49", "shahadat","shahadat")or die("cannot connect"); 
	//mysql_select_db("cchaportdb")or die("cannot select DB");
	include("mydbPConnection.php");
	$sql=mysql_query("
SELECT Import_Rotation_No,Vessel_Name FROM igm_masters 

WHERE igm_masters.Import_Rotation_No='$ddl_imp_rot_no'");
	$row=mysql_fetch_object($sql);
	?>


<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>DESTINATION/OFFDOCK WISE CONTAINER LIST</TITLE>
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
		header("Content-Disposition: attachment; filename=IMPORT_SUMMERY.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}?>
<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="50px">
		<td colspan="14" align="center"><font size="5"><b>DESTINATION/OFFDOCK WISE CONTAINER LIST</b></font></td>
		
	</tr>
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td ><b>Vessel Name:</b></font></td>
		<td><b><?php echo $row->Vessel_Name; ?></b></font></td>
		<td ><b> For: </b></font></td>
		<td ><b> <?php echo $row->Import_Rotation_No; ?></b></font></td>
	</tr>
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr>
	<tr bgcolor="#A9A9A9" align="center" height="25px">
		<td><b>S/L</b></td>
		<td><b>Container</b></td>
		<td><b>MLO</b></td>
		<td><b>Size</b></td>
		<td><b>Height</b></td>
		<td><b>Status</b></td>
	</tr>

<?php
	$query=mysql_query("SELECT DISTINCT cont_number AS id,cont_size,cont_status,cont_height,Organization_Name,off_dock_id,mlocode FROM igm_detail_container 
	INNER JOIN igm_details ON igm_details.id=igm_detail_container.igm_detail_id 
	INNER JOIN organization_profiles ON igm_detail_container.off_dock_id= organization_profiles.id 
	WHERE Import_Rotation_No='$ddl_imp_rot_no' AND igm_detail_container.off_dock_id NOT IN ('2591','2592')
	ORDER BY Organization_Name");
	
	$i=0;
	$j=0;
	
	$off_dock_id="";
	while($row=mysql_fetch_object($query)){
	$i++;
	
	if($off_dock_id!=$row->off_dock_id){
		if($j>0){
		?>
		<tr bgcolor="#DCDCDC" valign="center"><td colspan="2"><font size="4"><b>&nbsp;&nbsp;Total Container:</b></font></td><td  colspan="15">&nbsp;&nbsp;<font size="4"><b><?php  echo $j;?></b></font></td></tr>
		<?php
		}
		?>
		<tr bgcolor="#F0F4CA" valign="center"><td  colspan="15">&nbsp;&nbsp;<font size="4"><b><?php  if($row->off_dock_id) echo $row->Organization_Name; else echo "&nbsp;"; ?></b></font></td></tr>
		<?php
		
		
		$j=1;
		
	}else{
		$j++;
		
	}
	$off_dock_id=$row->off_dock_id;
	
	
?>
<tr align="center">
		<td><?php if($row->id) echo $j; else echo "&nbsp;";?></td>
		<td><?php if($row->id) echo $row->id; else echo "&nbsp;";?></td>
		<td><?php if($row->mlocode) echo $row->mlocode; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_size) echo $row->cont_size."'"; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_height) echo $row->cont_height; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_status) echo $row->cont_status; else echo "&nbsp;";?></td>
		
	</tr>

<?php } ?>
<tr bgcolor="#DCDCDC" valign="center"><td colspan="2"><font size="4"><b>&nbsp;&nbsp;Total Container :</b></font></td><td  colspan="15">&nbsp;&nbsp;<font size="4"><b><?php  echo $j;?></b></font></td></tr>

</table>

<!-- District Wise Container --->
<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="50px">
		<td colspan="14" align="center"><font size="5"><b> DISTRICT WISE CHITTAGONG PORT CONTAINER LIST FOR <?php echo $ddl_imp_rot_no; ?></b></font></td>
		
	</tr>
	<tr bgcolor="#A9A9A9" align="center">
		<td><b>S/L</b></td>
		<td><b>Container</b></td>
		<td><b>MLO</b></td>
		<td><b>Size</b></td>
		<td><b>Height</b></td>
		<td><b>Status</b></td>
	</tr>

<?php
	$query=mysql_query("SELECT id,cont_size,cont_status,cont_height,test,mlocode,(CASE 
WHEN UPPER(NotifyDesc) LIKE UPPER('%Barguna%') THEN UPPER('Barguna')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Barisal%') THEN UPPER('Barisal')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Bhola%') THEN UPPER('Bhola')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Jhalokati%') THEN UPPER('Jhalokati')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Patuakhali%') THEN UPPER('Patuakhali')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Pirojpur%') THEN UPPER('Pirojpur')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Bandarban%') THEN UPPER('Bandarban')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Brahmanbaria%') THEN UPPER('Brahmanbaria')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Chandpur%') THEN UPPER('Chandpur')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Chittagong%') THEN UPPER('Chittagong')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Comilla%') THEN UPPER('Comilla')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Coxs Bazar%') THEN UPPER('Coxs Bazar')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Feni%') THEN UPPER('Feni')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Khagrachhari%') THEN UPPER('Khagrachhari')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Lakshmipur%') THEN UPPER('Lakshmipur')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Noakhali%') THEN UPPER('Noakhali')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Rangamati%') THEN UPPER('Rangamati')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Dhaka%') THEN UPPER('Dhaka')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Faridpur%') THEN UPPER('Faridpur')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Gazipur%') THEN UPPER('Gazipur')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Gopalganj%') THEN UPPER('Gopalganj')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Jamalpur%') THEN UPPER('Jamalpur')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Kishoreganj%') THEN UPPER('Kishoreganj')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Madaripur%') THEN UPPER('Madaripur')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Manikganj%') THEN UPPER('Manikganj')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Manikgonj%') THEN UPPER('Manikganj')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Munshiganj%') THEN UPPER('Munshiganj')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Mymensingh%') THEN UPPER('Mymensingh')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Narayanganj%') THEN UPPER('Narayanganj')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Narayangonj%') THEN UPPER('Narayanganj')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Narsingdi%') THEN UPPER('Narsingdi')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Netrakona%') THEN UPPER('Netrakona')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Rajbari%') THEN UPPER('Rajbari')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Shariatpur%') THEN UPPER('Shariatpur')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Sherpur%') THEN UPPER('Sherpur')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Tangail%') THEN UPPER('Tangail')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Bagerhat%') THEN UPPER('Bagerhat')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Chuadanga%') THEN UPPER('Chuadanga')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Jessore%') THEN UPPER('Jessore')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Jhenaidah%') THEN UPPER('Jhenaidah')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Khulna%') THEN UPPER('Khulna')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Kushtia%') THEN UPPER('Kushtia')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Magura%') THEN UPPER('Magura')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Meherpur%') THEN UPPER('Meherpur')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Narail%') THEN UPPER('Narail')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Satkhira%') THEN UPPER('Satkhira')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Bogra%') THEN UPPER('Bogra')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Joypurhat%') THEN UPPER('Joypurhat')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Naogaon%') THEN UPPER('Naogaon')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Natore%') THEN UPPER('Natore')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Nawabganj%') THEN UPPER('Nawabganj')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Pabna%') THEN UPPER('Pabna')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Rajshahi%') THEN UPPER('Rajshahi')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Sirajganj%') THEN UPPER('Sirajganj')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Dinajpur%') THEN UPPER('Dinajpur')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Gaibandha%') THEN UPPER('Gaibandha')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Kurigram%') THEN UPPER('Kurigram')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Lalmonirhat%') THEN UPPER('Lalmonirhat')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Nilphamari%') THEN UPPER('Nilphamari')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Panchagarh%') THEN UPPER('Panchagarh')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Rangpu%') THEN UPPER('Rangpu')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Thakurgaon%') THEN UPPER('Thakurgaon')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Habiganj%') THEN UPPER('Habiganj')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Moulvibazar%') THEN UPPER('Moulvibazar')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Sunamganj%') THEN UPPER('Sunamganj')
WHEN UPPER(NotifyDesc) LIKE UPPER('%Sylhet%') THEN UPPER('Sylhet')
ELSE 'Other'
END
 ) AS dist FROM (
SELECT distinct cont_number AS id,cont_size,cont_status,cont_height,NotifyDesc AS test,mlocode,
REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(UPPER(CONVERT(NotifyDesc USING latin1)),'.',''),'-',''),',',''),'  ',' '),' ',''),'\r\n',''),'\n',''),'^',''),'\t','') AS NotifyDesc
FROM igm_detail_container 
INNER JOIN igm_details ON igm_details.id=igm_detail_container.igm_detail_id 
INNER JOIN organization_profiles ON igm_detail_container.off_dock_id= organization_profiles.id 
WHERE Import_Rotation_No='$ddl_imp_rot_no' AND igm_detail_container.off_dock_id='2591'
) AS tmp ORDER BY dist");
	
	//$i=0;
	$j=0;
	
	$dist="";
	while($row=mysql_fetch_object($query)){
	$i++;
	
	if($dist!=$row->dist){
		if($j>0){
		?>
		<tr bgcolor="#DCDCDC" valign="center"><td colspan="2"><font size="4"><b>&nbsp;&nbsp;Total Container :</b></font></td><td  colspan="15">&nbsp;&nbsp;<font size="4"><b><?php  echo $j;?></b></font></td></tr>
		<?php
		}
		?>
		<tr bgcolor="#F0F4CA" valign="center"><td  colspan="15">&nbsp;&nbsp;<font size="4"><b><?php  if($row->dist) echo $row->dist; else echo "&nbsp;"; ?></b></font></td></tr>
		<?php
		
		
		$j=1;
		
	}else{
		$j++;
		
	}
	$dist=$row->dist;
	
	
?>

<tr align="center">
		<td><?php if($row->id) echo $j; else echo "&nbsp;";?></td>
		<td><?php if($row->id) echo $row->id; else echo "&nbsp;";?></td>
		<td><?php if($row->mlocode) echo $row->mlocode; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_size) echo $row->cont_size."'"; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_height) echo $row->cont_height; else echo "&nbsp;";?></td>
		<td><?php if($row->cont_status) echo $row->cont_status; else echo "&nbsp;";?></td>
		
	</tr>

<?php } ?>
<tr bgcolor="#DCDCDC" valign="center"><td colspan="2"><font size="4"><b>&nbsp;&nbsp;Total Container :</b></font></td><td  colspan="15">&nbsp;&nbsp;<font size="4"><b><?php  echo $j;?></b></font></td></tr>
<tr bgcolor="#E0FFFF" valign="center"><td colspan="2"><font size="4"><b>&nbsp;&nbsp;Grand Total:</b></font></td><td  colspan="15">&nbsp;&nbsp;<font size="4"><b><?php  echo $i;?></b></font></td></tr>
</table>
<?php
mysql_close($con_cchaportdb);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>