<!DOCTYPE html>
<html lang="en">
	
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-language" content="en" />
<meta http-equiv="cache-control" content="no-cache">
<!--meta http-equiv="refresh" content="360"-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--[if lt IE 9]>
<script src="../_default/js/html5shiv.js" type="text/javascript"></script>
<![endif]-->



<title>Vessel View</title>

<style type="text/css">
		/*body  {
			background: url("slide7.png")no-repeat center center fixed;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
		}*/
		
		.grid
		{
			font-family: Verdana,Geneva,sans-serif;
			border: 1px solid #000;
			height:60px;
			width: 70px;
		}
		
		.gridcolor
		{
			font-family: Verdana,Geneva,sans-serif;
			border: 1px solid #000;
			height: 60px;
			width: 70px;
			background-color:#0099FF;
			color:white;
		}
		
		.nogrid
		{
			height: 60px;
			width: 70px;
		}
		
		hr
		{ 
			/*height: 12px; 
			border: 0; 
			box-shadow: inset 0 12px 12px -12px rgba(0, 0, 0, 0.5); */
			display: block;
			margin-top: 0.5em;
			margin-bottom: 0.5em;
			margin-left: auto;
			margin-right: auto;
			border-style: inset;
			border-width: 3px;
		}
		
		.pagebreak { page-break-before: always; }
		
</style>

</head>
<body>
<?php
include('dbConection.php');
//$vsl = 6003411;
//$vsl = 5569517;
$vsl = $_REQUEST['vvdGkey'];
$strBay = "select distinct 
case 
	when left(stowage_pos,2)=02 then '01'
	when left(stowage_pos,2)=06 then '05'
	when left(stowage_pos,2)=10 then '09'
	when left(stowage_pos,2)=14 then '13'
	when left(stowage_pos,2)=18 then '17'
	when left(stowage_pos,2)=22 then '21'
	when left(stowage_pos,2)=26 then '25'
	when left(stowage_pos,2)=30 then '29'
	when left(stowage_pos,2)=34 then '33'
	else left(stowage_pos,2) end as bay 
from ctmsmis.mis_exp_unit
where vvd_gkey=$vsl and stowage_pos !='' order by stowage_pos";

$resBay = mysql_query($strBay);
while($rowbay = mysql_fetch_object($resBay))
{
	//echo $rowbay->bay."<br>";
	$bay = "";
	$title = "";
	if($rowbay->bay == "01")
	{
		$bay = "01,02";
		$title = "01(02)";
	}
	elseif($rowbay->bay == "05")
	{
		$bay = "05,06";
		$title = "05(06)";
	}
	elseif($rowbay->bay == "09")
	{
		$bay = "09,10";
		$title = "09(10)";
	}
	elseif($rowbay->bay == "13")
	{
		$bay = "13,14";
		$title = "13(14)";
	}
	elseif($rowbay->bay == "17")
	{
		$bay = "17,18";
		$title = "17(18)";
	}
	elseif($rowbay->bay == "21")
	{
		$bay = "21,22";
		$title = "21(22)";
	}
	elseif($rowbay->bay == "25")
	{
		$bay = "25,26";
		$title = "25(26)";
	}
	elseif($rowbay->bay == "29")
	{
		$bay = "29,30";
		$title = "29(30)";
	}
	elseif($rowbay->bay == "33")
	{
		$bay = "33,34";
		$title = "33(34)";
	}
	else 
	{
		$bay = $rowbay->bay;
		$title = $rowbay->bay;
	}
	//echo $bay."<br>";
	
	
?>
	<table align="center" cellspacing="0" cellpadding="0">
		<tr><td></td><td colspan="12" class="nogrid" align="center"><?php echo "Bay ".$title; ?></td></tr>
		<!-- Row leble start -->
		<tr>
			<td></td>
			<?php 
			$strMaxCol = "select max(substring(stowage_pos,3,2)) as maxCol from ctmsmis.mis_exp_unit
			inner join ctmsmis.mis_inv_unit on ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey
			where ctmsmis.mis_exp_unit.vvd_gkey=$vsl and left(stowage_pos,2) in($bay) order by stowage_pos";
			//echo $strMaxCol;
			$resMaxCol = mysql_query($strMaxCol);
			$rowMaxCol = mysql_fetch_object($resMaxCol);
			$maxCol = intval($rowMaxCol->maxCol);
			
			$strIsCLine = "select count(ctmsmis.mis_inv_unit.gkey) as cnt from ctmsmis.mis_exp_unit
			inner join ctmsmis.mis_inv_unit on ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey
			where ctmsmis.mis_exp_unit.vvd_gkey=$vsl and left(stowage_pos,2) in($bay) and substring(stowage_pos,3,2)='00' order by stowage_pos";
			$resIsCLine = mysql_query($strIsCLine);
			$rowIsCLine = mysql_fetch_object($resIsCLine);
			$IsCLine = intval($rowIsCLine->cnt);
			
			if($maxCol==0 or $maxCol%2==1)
			{
				$kl = 10;
			}
			else
			{
				$kl = $maxCol;
			}
			//echo $kl;	
			while($kl>=02)
			{
			?>
			<td class="nogrid" align="center"><?php if($kl<10) echo "0".$kl; else echo $kl; ?></td>
			<?php 
			$kl = $kl-2;
			}
			if($IsCLine>0)
			{
			?>
			<td class="nogrid" align="center">00</td>
			<?php 
			}
			$ll = 1;
			//echo $l;
			if($maxCol==0 or $maxCol%2==0)
				$rLimit = 9;
			else
				$rLimit = $maxCol;
			while($ll<=$rLimit)
			{
			?>
			<td class="nogrid" align="center"><?php if($ll<10) echo "0".$ll; else echo $ll; ?></td>
			<?php 
			$ll = $ll+2;
			}
			?>
		<tr>
		<!-- Row leble end -->
		
		<!-- Dynamic Row start -->
		<?php 
		$strMinRow = "select min(right(stowage_pos,2)) as minRow from ctmsmis.mis_exp_unit
		inner join ctmsmis.mis_inv_unit on ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey
		where ctmsmis.mis_exp_unit.vvd_gkey=$vsl and left(stowage_pos,2) in($bay)  and right(stowage_pos,2)>=80 order by stowage_pos";
		//echo $strMinRow;
		$resMinRow = mysql_query($strMinRow);
		$rowMinRow = mysql_fetch_object($resMinRow);
		$minRow = intval($rowMinRow->minRow);	
		if($minRow==0)
			$minRow = 80;
		else
			$minRow = $minRow;
		$i=92;
		while($i>=$minRow)
		{
		?>
		<tr>
			<td class="nogrid" align="center"><?php echo $i; ?></td>
			<!-- Left side column -->
			<?php 
			if($maxCol==0 or $maxCol%2==1)
				$k = 10;
			else
				$k = $maxCol;
				
			while($k>=02)
			{
				if($k<10)
					$pos = "0".$k.$i;
				else
					$pos = $k.$i;
				$strPos = "select ctmsmis.mis_inv_unit.iso_code as typId,stowage_pos as bay,ctmsmis.mis_exp_unit.gkey,ctmsmis.mis_inv_unit.id,ctmsmis.mis_inv_unit.mlo from ctmsmis.mis_exp_unit
				inner join ctmsmis.mis_inv_unit on ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey
				where ctmsmis.mis_exp_unit.vvd_gkey=$vsl and left(stowage_pos,2) in($bay) and right(stowage_pos,4)='$pos' and right(stowage_pos,2)>=80 order by stowage_pos";
				//echo $strPos."<br>";
				$resPos = mysql_query($strPos);
				$rowPos = mysql_fetch_object($resPos);
				$numrow = mysql_num_rows($resPos);
				?>
				<td <?php if($numrow>0) {?> class="gridcolor" <?php } else {?> class="grid" <?php }?>><?php if($numrow>0) { echo substr($rowPos->id,0,5)."<br>".substr($rowPos->id,5)."<br>".$rowPos->mlo;}?></td>
				<?php 
				$k = $k-2;
			}
			// for centre line
			if($IsCLine>0)
			{
			$posCentre = "00".$i;
			$strPosCentre = "select ctmsmis.mis_inv_unit.iso_code as typId,stowage_pos as bay,ctmsmis.mis_exp_unit.gkey,ctmsmis.mis_inv_unit.id,ctmsmis.mis_inv_unit.mlo from ctmsmis.mis_exp_unit
			inner join ctmsmis.mis_inv_unit on ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey
			where ctmsmis.mis_exp_unit.vvd_gkey=$vsl and left(stowage_pos,2) in($bay) and right(stowage_pos,4)='$posCentre' and right(stowage_pos,2)>=80 order by stowage_pos";
			//echo $pos."<br>";
			$resPosCentre = mysql_query($strPosCentre);
			$rowPosCentre = mysql_fetch_object($resPosCentre);
			$numrowCentre = mysql_num_rows($resPosCentre);
			?>
			<!-- Center column -->
			<td <?php if($numrowCentre>0) {?> class="gridcolor" <?php } else {?> class="grid" <?php }?>><?php if($numrowCentre>0) { echo substr($rowPosCentre->id,0,5)."<br>".substr($rowPosCentre->id,5)."<br>".$rowPosCentre->mlo;}?></td>
			
			<!-- Right side column -->
			<?php 
			}
			$l = 1;
			//echo $l;
			if($maxCol==0 or $maxCol%2==0)
				$rcLimit = 9;
			else
				$rcLimit = $maxCol;
			while($l<=$rcLimit)
			{
				if($k<10)
				$posRight = "0".$l.$i;
				else
				$posRight = $l.$i;
				$strPosRight = "select ctmsmis.mis_inv_unit.iso_code as typId,stowage_pos as bay,ctmsmis.mis_exp_unit.gkey,ctmsmis.mis_inv_unit.id,ctmsmis.mis_inv_unit.mlo from ctmsmis.mis_exp_unit
				inner join ctmsmis.mis_inv_unit on ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey
				where ctmsmis.mis_exp_unit.vvd_gkey=$vsl and left(stowage_pos,2) in($bay) and right(stowage_pos,4)='$posRight' and right(stowage_pos,2)>=80 order by stowage_pos";
				//echo $pos."<br>";
				$resPosRight = mysql_query($strPosRight);
				$rowPosRight = mysql_fetch_object($resPosRight);
				$numrowRight = mysql_num_rows($resPosRight);
				?>
				<td <?php if($numrowRight>0) {?> class="gridcolor" <?php } else {?> class="grid" <?php }?>><?php if($numrowRight>0) { echo substr($rowPosRight->id,0,5)."<br>".substr($rowPosRight->id,5)."<br>".$rowPosRight->mlo;}?></td>
				<?php 
				$l = $l+2;	
			}
			?>
			
		<tr>
		<?php 
		$i=$i-2;
		} 
		?>
		
		<!-- Dynamic Row end -->
		<tr><td></td><td colspan="12" align="center"><hr></td></tr>
		
		<!-- Below part start -->
		<?php 
		$b = 10;
		while($b>=2)
		{
		?>
		<tr>
			<td class="nogrid" align="center"><?php if($b<10){echo "0".$b;}else{echo $b;} ?></td>
			<?php
			if($maxCol==0 or $maxCol%2==1)
			{
				$kbelow = 10;
				$noCol = 10;
			}
			else
			{
				$kbelow = $maxCol;
				$noCol = $maxCol;
			}
				
			while($kbelow>=02)
			{
				if($kbelow<10 and $b>=10)
					$posbelow = "0".$kbelow.$b;	
				else if($kbelow>=10 and $b<10)
					$posbelow = $kbelow."0".$b;	
				else if($kbelow<10 and $b<10)
					$posbelow = "0".$kbelow."0".$b;
				else
					$posbelow = $kbelow.$b;
				//echo $posbelow."===";
				$strPosbelow = "select ctmsmis.mis_inv_unit.iso_code as typId,stowage_pos as bay,ctmsmis.mis_exp_unit.gkey,ctmsmis.mis_inv_unit.id from ctmsmis.mis_exp_unit
				inner join ctmsmis.mis_inv_unit on ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey
				where ctmsmis.mis_exp_unit.vvd_gkey=$vsl and left(stowage_pos,2) in($bay) and right(stowage_pos,4)='$posbelow' and right(stowage_pos,2)<80 order by stowage_pos";
				//echo $strPosbelow."<br>";
				$resPosbelow = mysql_query($strPosbelow);
				$rowPosbelow = mysql_fetch_object($resPosbelow);
				$numrowbelow = mysql_num_rows($resPosbelow);
				//echo $kbelow;
				//echo "<br> M= ".$maxCol-2;
				//echo "<br>";
				?>
				<!--td <?php if($numrowbelow>0) {?> class="gridcolor" <?php } else {?> class="nogrid" <?php }?>><?php if($numrowbelow>0) { echo "CGP<br>".$rowPosbelow->typId;}?></td-->
				<td <?php if($numrowbelow>0) {?> class="gridcolor" <?php } elseif($numrowbelow==0 and $b==10 and $kbelow<=$noCol-2) {?> class="grid" <?php } elseif($numrowbelow==0 and $b==8 and $kbelow<=$noCol-4) {?> class="grid" <?php } elseif($numrowbelow==0 and $b==6 and $kbelow<=$noCol-6) {?> class="grid" <?php } else {?> class="nogrid" <?php }?>><?php if($numrowbelow>0) { echo substr($rowPosbelow->id,0,5)."<br>".substr($rowPosbelow->id,5);}?></td>
				<?php 				
				$kbelow = $kbelow-2;
			} 
			// for centre line
			if($IsCLine>0)
			{
			if($b<10)
				$cb = "0".$b;
			else
				$cb = $b;
			$posCentreBelow = "00".$cb;
			$strPosCentreBelow = "select ctmsmis.mis_inv_unit.iso_code as typId,stowage_pos as bay,ctmsmis.mis_exp_unit.gkey,ctmsmis.mis_inv_unit.id from ctmsmis.mis_exp_unit
			inner join ctmsmis.mis_inv_unit on ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey
			where ctmsmis.mis_exp_unit.vvd_gkey=$vsl and left(stowage_pos,2) in($bay) and right(stowage_pos,4)='$posCentreBelow' and right(stowage_pos,2)<80 order by stowage_pos";
			//echo $pos."<br>";
			$resPosCentreBelow = mysql_query($strPosCentreBelow);
			$rowPosCentreBelow = mysql_fetch_object($resPosCentreBelow);
			$numrowCentreBelow = mysql_num_rows($resPosCentreBelow);
			?>
			<!-- Center column -->
			<td <?php if($numrowCentreBelow>0) {?> class="gridcolor" <?php } else {?> class="grid" <?php }?>><?php if($numrowCentreBelow>0) { echo "CGP<br>".$rowPosCentreBelow->typId;}?></td>
			
			<!-- Right side column -->
			<?php 
			}
			$lBelow = 1;
			//echo $l;
			if($maxCol==0 or $maxCol%2==0)
				$rcLimitBelow = 9;
			else
				$rcLimitBelow = $maxCol;
			//echo $rcLimitBelow;
			while($lBelow<=$rcLimitBelow)
			{
				if($b<10)
				$posRightBelow = "0".$lBelow."0".$b;
				else
				$posRightBelow = "0".$lBelow.$b;
				$strPosRightBelow = "select ctmsmis.mis_inv_unit.iso_code as typId,stowage_pos as bay,ctmsmis.mis_exp_unit.gkey,ctmsmis.mis_inv_unit.id from ctmsmis.mis_exp_unit
				inner join ctmsmis.mis_inv_unit on ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey
				where ctmsmis.mis_exp_unit.vvd_gkey=$vsl and left(stowage_pos,2) in($bay) and right(stowage_pos,4)='$posRightBelow' and right(stowage_pos,2)<80 order by stowage_pos";
				//echo $strPosRightBelow."<br>";
				$resPosRightBelow = mysql_query($strPosRightBelow);
				$rowPosRightBelow = mysql_fetch_object($resPosRightBelow);
				$numrowRightBelow = mysql_num_rows($resPosRightBelow);
				?>
				<!--td <?php if($numrowRightBelow>0) {?> class="gridcolor" <?php } else {?> class="nogrid" <?php }?>><?php if($numrowRightBelow>0) { echo "CGP<br>".$rowPosRightBelow->typId;}?></td-->
				<td <?php if($numrowRightBelow>0) {?> class="gridcolor" <?php } elseif($numrowRightBelow==0 and $b==10 and $lBelow<=$rcLimitBelow-2) {?> class="grid" <?php } elseif($numrowRightBelow==0 and $b==8 and $lBelow<=$rcLimitBelow-4) {?> class="grid" <?php } elseif($numrowRightBelow==0 and $b==6 and $lBelow<=$rcLimitBelow-6) {?> class="grid" <?php } else {?> class="nogrid" <?php }?>><?php if($numrowRightBelow>0) { echo substr($rowPosRightBelow->id,0,5)."<br>".substr($rowPosRightBelow->id,5);}?></td>
				<?php 
				$lBelow = $lBelow+2;	
			}
			?>
			
			
		</tr>
		
		<?php 
		$b = $b-2;
		} 
		?>
	</table>
	<span class="pagebreak"> </span>
<?php 
} 
?>
<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
