<?php
//echo "view";
include('dbConection.php');
$rotation = $_GET['rot'];
//$rotation = "2016/3";
$strVslInfo = "select sparcsn4.vsl_vessels.id,sparcsn4.vsl_vessels.name
from sparcsn4.vsl_vessel_visit_details
inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
where sparcsn4.vsl_vessel_visit_details.ib_vyg='$rotation'";
$rtnVslInfo = mysql_query($strVslInfo);
$rowVslInfo = mysql_fetch_object($rtnVslInfo);
$vslId= $rowVslInfo->id;
$vslName= $rowVslInfo->name;

$str = "select bay,pairedWith from ctmsmis.misBayView where vslId='$vslId' order by bay asc";
//echo $str;
$res = mysql_query($str);
$mumrows = mysql_num_rows($res);
$dBay = "";
$i=1;
while($row = mysql_fetch_object($res))
{
	//echo "i=".$i."n=".$mumrows;
	$bay = $row->bay;
	if($bay<10)
		$bay="0".$bay;
	else
		$bay=$bay;
	$pairedWith = $row->pairedWith;
	if($pairedWith<10)
		$pairedWith="0".$pairedWith;
	else
		$pairedWith=$pairedWith;
		
	if($pairedWith!=0)
		$bayP = $bay."(".$pairedWith.")";
	else
		$bayP = $bay;
	if($i==$mumrows)	
		$dBay.=$bayP;
	elseif($i%5==0)
		$dBay.=$bayP.",<br/>";
	else 
		$dBay.=$bayP.", ";
	$i++;
}
?>

<table border="0">
	<tr>
		<td>
			Vessel:
		</td>
		<td>
			<b><?php echo $vslName;?></b>
		</td>
	</tr>
	<?php
	if($mumrows>0)
	{
	?>
	<tr>
		<td>
			Drawn Bay:
		</td>
		<td>
			<b><?php echo $dBay;?></b>
		</td>
	</tr>	
	<tr>
		<td colspan="2" align="center">
			<a href="<?php  echo site_url("report/blankBayView"); ?>?get=yes&vslId=<?php echo $vslId?>&vslName=<?php echo $vslName?>" target="_blank">View Layout</a>
		</td>
	</tr>
	<?php
	}
	?>
	<?php mysql_close($con_sparcsn4);?>
</table>