 <?php
	$con = mysql_connect("192.168.16.42","user1","user1test");
	mysql_select_db("cchaportdb",$con);
	
	$con1 = mysql_connect("10.1.1.21","sparcsn4","sparcsn4");
	mysql_select_db("sparcsn4",$con1);
 ?>
<HTML>
	<HEAD>
		<title>Chittagong Port Authority</title>
		<LINK href="../css/report.css" type=text/css rel=stylesheet>
</HEAD>
<BODY>
<style>
   table {border-collapse:collapse;}
   table td,th { width:300px; word-wrap:break-word;}
   img {padding-left:300px;}
   
</style>
<!--<img align="middle" src="<?php echo IMG_PATH?>cpanew.jpg"/>-->


<!--<h3 align="center">Vessel Wise CTMS Container Job Done by HHT,VMT and Manually<br/>From  </h3>-->
<h3 align="center">DELIVERY ORDER<br/></h3>
<div align="left" style="padding-left:10%;">

	<table>
		<tr>
			<td align="left">To</td>
			<td align="right">Date <?php echo date('Y-m-d'); ?></td>
		</tr>
		<tr>
			<td>The Terminal Manager,</td>
		</tr>
		<tr>
			<td>Chittagong Port Authority,</td>
		</tr>
		<tr>
			<td>Chittagong.</td>
		</tr>

	</table>
</div>
<?php 
$blNo= "";
$lineNo= "";
$rotNo = "";
$vslName= "";
$voyNo= "";

$queryStr = "select BL_NO,Notify_name,Line_No,bill_of_entry_date,supDtl.Import_Rotation_No,Vessel_Name,Voy_No from igm_supplimentary_detail supDtl 
			inner join igm_sup_detail_container supDtlCont on supDtl.id=supDtlCont.igm_sup_detail_id
			inner join igm_masters im on supDtl.igm_master_id= im.id
			where supDtl.Bill_of_Entry_No=$container";
$resQuery=mysql_query($queryStr,$con);
while($rowequip=mysql_fetch_object($resQuery))
{
	$blNo= $rowequip->BL_NO;
	$beDate= $rowequip->bill_of_entry_date;
	$lineNo= $rowequip->Line_No;
	$rotNo = $rowequip->Import_Rotation_No;
	$notifyName= $rowequip->Notify_name;
	$voyNo= $rowequip->Voy_No;
	
	
	
	
}
$queryStrSpars = "select date(ata) as ata,name from sparcsn4.argo_carrier_visit 
					inner join sparcsn4.vsl_vessel_visit_details on sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
					inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessel_visit_details.vessel_gkey=sparcsn4.vsl_vessels.gkey
					where sparcsn4.vsl_vessel_visit_details.ib_vyg='$rotNo'";
$resQuerySprs=mysql_query($queryStrSpars,$con1);
while($rowequipSprs=mysql_fetch_object($resQuerySprs))
{
		$vslName= $rowequipSprs->Vessel_Name;
		$ata= $rowequipSprs->ata;
}										

?>
<div align="left" style="padding-left:10%;">
</br>
</br>
	Dear Sir, </br></br>
	Please deliver to M/S <u><?php echo "Test Mess"?></u> or order the undermentioned goods Ex. The </br>
	Vessel M.V. <u><?php echo $vslName?></u> Voyage <u><?php echo $voyNo?></u> Import Rot # <u><?php echo $rotNo?></u> Line No <u><?php echo $blNo?></u> </br>
	Arrived at Chittagong On <u><?php echo $ata?></u> </br>
	</br>
	The Bill of Lading for which is in our possession / </br>
	Customs B/E No & C.No <u><?php echo $container?></u> Date <u><?php echo $beDate?></u> Delivery Order granted against original Bill of Lading.
</div>

<div style="padding-left:10%;padding-right:10%;">
	</br>
	<table border=1px >
		<tr>
			<td>B/L NO #</td>
			<td>Marks and Number</td>
			<td>No Of Pkgs</td>
			<td>Description of Cargo</td>
			<td>Gross Wt.</td>
			<td>Container</td>
			<td>Size</td>
			<td>Status</td>
		</tr>
		<tr>
		<?php 
		
			$queryStr = "select BL_NO,Pack_Number,Pack_Marks_Number,weight,weight_unit,Pack_Description,Description_of_Goods,cont_number,cont_size,cont_status from igm_supplimentary_detail supDtl 
			inner join igm_sup_detail_container supDtlCont on supDtl.id=supDtlCont.igm_sup_detail_id
			inner join igm_masters im on supDtl.igm_master_id= im.id
			where supDtl.Bill_of_Entry_No=$container";
			$resQuery=mysql_query($queryStr,$con);
			while($rowequip=mysql_fetch_object($resQuery))
			{
				$blNoU= $rowequip->BL_NO;
				$marksNum= $rowequip->Pack_Marks_Number;
				$noOfPkg= $rowequip->Pack_Number;
				$pkgDesc= $rowequip->Pack_Description;
				$desc= $rowequip->Description_of_Goods;
				$grossWeight = $rowequip->weight;
				$weightUnit = $rowequip->weight_unit;
				$cont= $rowequip->cont_number;
				$size= $rowequip->cont_size;
				$status= $rowequip->cont_status;
				?>
				
				<td><?php echo $blNoU?></td>
				<td><?php echo $marksNum?></td>
				<td><?php echo $noOfPkg.$pkgDesc?></td>
				<td><?php echo $desc?></td>
				<td><?php echo $grossWeight.$weightUnit?></td>
				<td><?php echo $cont?></td>
				<td><?php echo $size?></td>
				<td><?php echo $status?></td>
				
			<?php }?>
		</tr>
	</table>
</div>
<div style="padding-left:10%;padding-right:10%;">
			<?php 
		
				$queryStr = "select SUM(Pack_Number) as sumPack from igm_supplimentary_detail supDtl 
				inner join igm_sup_detail_container supDtlCont on supDtl.id=supDtlCont.igm_sup_detail_id
				inner join igm_masters im on supDtl.igm_master_id= im.id
				where supDtl.Bill_of_Entry_No=$container";
				$resQuery=mysql_query($queryStr,$con);
				while($rowequip=mysql_fetch_object($resQuery))
				{
					$sumPack= $rowequip->sumPack;
				}
			?>
Demurrage Paid Up To <u><?php echo str_repeat('&nbsp;', 20);?></u>   Total Packages <?php echo $sumPack?>
</div>
<div align="right" style="padding-right:10%;">
For <u><?php echo $notifyName?></u> </br>
As AGENTS
</div>
<!--
<div style="padding-left:10%;padding-right:10%;">
	<table border=1px>
		<tr><td></td><td></td><td></td><td></td></tr>
	</table>
	<table>
		<tr>
			<td align="left">Chittagong Office</td>
			<td align="right">Dhaka Office</td>
		</tr>
		<tr>
			<td align="left">Chittagong Office</td>
			<td align="right">Dhaka Office</td>
		</tr>
		<tr>
			<td align="left">Chittagong Office</td>
			<td align="right">Dhaka Office</td>
		</tr>
		<tr>
			<td align="left">Chittagong Office</td>
			<td align="right">Dhaka Office</td>
		</tr>
		<tr>
			<td align="left">Chittagong Office</td>
			<td align="right">Dhaka Office</td>
		</tr>

	</table>
</div>
-->
<?php 

mysql_close($con);
mysql_close($con1);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
