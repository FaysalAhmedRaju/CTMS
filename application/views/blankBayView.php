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



<title>Vessel Blank View</title>

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

//$vslId = "HCALYPSO";
$get = $_REQUEST['get'];
$vslId = "";
$vslName = "";
if($get=="yes")
{
$vslId = $_REQUEST['vslId'];
$vslName = $_REQUEST['vslName'];
}
else
{
$vvdGkey = $_REQUEST['vvdGkey'];

$strVGkey = "select sparcsn4.vsl_vessels.id,sparcsn4.vsl_vessels.name
from sparcsn4.vsl_vessel_visit_details
inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
where sparcsn4.vsl_vessel_visit_details.vvd_gkey='$vvdGkey'";
$resVGkey = mysql_query($strVGkey);
$rowVGkey = mysql_fetch_object($resVGkey);
$vslId = $rowVGkey->id;
$vslName = $rowVGkey->name;
}
$strBay = "select * from ctmsmis.misBayView where vslId='$vslId' order by bay asc";
$resBay = mysql_query($strBay);
$numRowsBay = mysql_num_rows($resBay);
if($numRowsBay==0)
{
echo "<div align='center'><font color='red' size='5'><b>Sorry! Vessel $vslName is not drawn yet.Please contact with Datasoft people (+8801749923327) to draw this vessel...</b></font></div>";
return;
}
echo "<h1 align='center'>Vessel: $vslName</h1>";
while($rowbay = mysql_fetch_object($resBay))
{
	//echo $rowbay->bay."<br>";
	$bay = "";
	$title = "";
	if($rowbay->paired == 1)
	{
		if($rowbay->bay<10)
			$title1 = "0".$rowbay->bay;
		else
			$title1 = $rowbay->bay;
		
		if($rowbay->pairedWith<10)
			$title2 = "0".$rowbay->pairedWith;
		else
			$title2 = $rowbay->pairedWith;
			
		$title=$title1."(".$title2.")";
	}	
	else 
	{
		if($rowbay->bay<10)
			$title = "0".$rowbay->bay;
		else
			$title = $rowbay->bay;
	}
	//echo $title."<br>";
	
	$strMaxCol = "select max(maxColLimit) as maxCol from ctmsmis.misBayViewBelow where vslId='$vslId' and bay=$rowbay->bay";
	//echo $strMaxCol;
	
	$resMaxCol = mysql_query($strMaxCol);
	$rowMaxCol = mysql_fetch_object($resMaxCol);
	$maxCol = intval($rowMaxCol->maxCol);
	//echo "M==".$maxCol;
	//return;
?>
	<table align="center" cellspacing="0" cellpadding="0">		
		<tr><td></td><td colspan="<?php if($rowbay->centerLineA==1 or $rowbay->gapLineA==1) echo $maxCol+1; else echo $maxCol;?>" class="nogrid" align="center" valign="bottom"><b><?php echo "Bay ".$title; ?></b></td></tr>
		<!-- Row leble start -->
		<tr>
			<td></td>
			<?php 
			//$maxCol = intval($rowbay->maxColLimAbv);		
			$strUpDeckLbl = "select minColLimit,maxColLimit from ctmsmis.misBayViewBelow where vslId='$vslId' and bay=$rowbay->bay";
			//echo "fdfd=".$strUpDeckLbl;
			
			$resUpDeckLbl = mysql_query($strUpDeckLbl);
			$rowUpDeckLbl = mysql_fetch_object($resUpDeckLbl);
			$minColLimitLbl = $rowUpDeckLbl->minColLimit;			
			
			if($maxCol%2==1)
			{
				$kl = $maxCol-1;
			}
			else
			{
				$kl = $maxCol;
			}
			//echo "kl==".$kl;	
			
			while($kl>=$minColLimitLbl)
			{
			if($minColLimitLbl!=0){
			?>
			<td class="nogrid" align="center"><?php if($kl<10) echo "0".$kl; else echo $kl; ?></td>
			<?php 
			}
			$kl = $kl-2;
			}
			if($rowbay->centerLineA==1)
			{
			?>
			<td class="nogrid" align="center">00</td>
			<?php 
			}
			elseif($rowbay->centerLineA==0 and $rowbay->gapLineA==1)
			{
			?>
			<td class="nogrid" align="center"></td>
			<?php 
			}
			
			$ll = $minColLimitLbl;
			//echo $l;
			if($maxCol%2==0)
				$rLimit = $maxCol-1;
			else
				$rLimit = $maxCol;
			while($ll<=$rLimit)
			{
			//echo $ll."-";
			//echo $rLimit;
			?>
			<td class="nogrid" align="center"><?php if($ll<10) echo "0".$ll; else echo $ll; ?></td>
			<?php 
			$ll = $ll+2;
			}
			
			?>
		</tr>
		<!-- Row leble end -->
		
		<!-- Dynamic Row start -->
		<?php 
		$minRow = intval($rowbay->minRowLimAbv);	
		$maxRowAbv = intval($rowbay->maxRowLimAbv);	
		$upGapVal = $rowbay->gapUpperRow;
		$upGapValArr = explode(',',$upGapVal);
		//print_r($upGapValArr);
		/*if (in_array("0090", $upGapValArr)) {
			echo "Got Irix";
		}*/
		$i=$maxRowAbv;
			
		while($i>=$minRow)
		{
			$strUpDeck = "select minColLimit,maxColLimit from ctmsmis.misBayViewBelow where vslId='$vslId' and bay=$rowbay->bay and bayRow=$i";
			//echo $strBlDeck;
			$resUpDeck = mysql_query($strUpDeck);
			$rowUpDeck = mysql_fetch_object($resUpDeck);
			$minColLimitUp = $rowUpDeck->minColLimit;
			$maxColLimitUp = intval($rowUpDeck->maxColLimit);
			//echo "Max==".$maxColLimitUp;
		?>
		<tr>
			<td class="nogrid" align="center"><?php echo $i; ?></td>
			<!-- Left side column -->
			<?php 
			if($maxCol%2==1)
			{
				$k = $maxCol-1;
			}
			else
			{
				$k = $maxCol;
			}
				
			while($k>=trim($minColLimitUp))
			{
			if($k<10)
				$kval = "0".$k;
			else
				$kval = $k;
			$gapStr = $kval.$i;
			if($minColLimitUp!=0)
			{
			?>
				
				<td <?php if($k >$maxColLimitUp){?>class="nogrid"<?php } elseif(in_array($gapStr, $upGapValArr)){?>class="nogrid"<?php } else {?>class="grid" <?php } ?> align="center">
				</td>				
			<?php 
			}
				$k = $k-2;				
			}
			
			// for centre line
			if($rowbay->centerLineA==1 and (!in_array("00".$i, $upGapValArr)))
			{			
			?>
			<!-- Center column -->
			<td class="grid"></td>
			
			<!-- Right side column -->
			<?php 
			}
			elseif(in_array("00".$i, $upGapValArr))
			{			
			?>
			<!-- Center column -->
			<td class="nogrid"></td>
			
			<!-- Right side column -->
			<?php 
			}
			elseif($rowbay->centerLineA==0 and $rowbay->gapLineA==1)
			{			
			?>
			<!-- Center column -->
			<td class="nogrid"></td>
			
			<!-- Right side column -->
			<?php 
			}
			$l = trim($minColLimitUp);
			//echo $l;
			if($maxCol%2==0)
				$rcLimit = $maxCol-1;
			else
				$rcLimit = $maxCol;
			while($l<=$rcLimit)
			{
			if($l<10)
				$lval = "0".$l;
			else
				$lval = $l;
			$gapStrRisht = $lval.$i;
			?>				
				<td <?php if($l >$maxColLimitUp){?>class="nogrid"<?php } elseif(in_array($gapStrRisht, $upGapValArr)){?>class="nogrid"<?php } else {?>class="grid" <?php } ?> align="center">
				</td>
			<?php 
				$l = $l+2;	
			}			
			?>
			<td class="nogrid" align="center"><?php echo $i; ?></td>
		</tr>
		<?php 
		$i=$i-2;
		} 
		if($rowbay->isBelow==1)
		{
		?>
		
		<!-- Dynamic Row end -->
		<tr><td></td><td colspan="<?php if($rowbay->centerLineA==1 or $rowbay->gapLineA==1) echo $maxCol+1; else echo $maxCol;?>" align="center"><hr></td></tr>
		
		<!-- Below part start -->
		<?php 
		
			$b = $rowbay->maxRowLimBlw;
			$bMin = $rowbay->minRowLimBlw;
			$lowGapVal = $rowbay->gapLowerRow;
			$lowGapValArr = explode(',',$lowGapVal);
			//echo$rowbay->bay;
			/*if($rowbay->bay==34)
			{
				print_r($lowGapValArr);
			}
			*/
			while($b>=$bMin)
			{
			?>
			<tr>
				<td class="nogrid" align="center"><?php if($b<10){echo "0".$b;}else{echo $b;} ?></td>
			<?php
				$strBlDeck = "select minColLimit,maxColLimit from ctmsmis.misBayViewBelow where vslId='$vslId' and bay=$rowbay->bay and bayRow=$b";
				//echo $strBlDeck;
				$resBlDeck = mysql_query($strBlDeck);
				$rowBlDeck = mysql_fetch_object($resBlDeck);
				$minColLimit = $rowBlDeck->minColLimit;
				$maxColLimit = $rowBlDeck->maxColLimit;
				if($maxCol%2==1)
				{
					$kbelow = $maxCol-1;
				}
				else
				{
					$kbelow = $maxCol;
				}
				
				if($rowbay->centerLineA==0 and $rowbay->centerLineB!=0)
				$kbelow = $kbelow-2;
				else if($rowbay->centerLineA==0 and $rowbay->centerLineB==0)
					$kbelow = $kbelow;
				
				while($kbelow>=02)
				{
				if($b<10)
					$bval = "0".$b;
				else
					$bval = $b;
				
				if($kbelow<10)
					$kbval = "0".$kbelow;
				else
					$kbval = $kbelow;
				$gapStrB = $kbval.$bval;
				//echo $gapStrB;
				
				?>
					<td <?php if($kbelow >$maxColLimit){?>class="nogrid"<?php } elseif(in_array($gapStrB, $lowGapValArr)){?>class="nogrid"<?php } else {?>class="grid" <?php } ?> align="center">
						<?php 
							/*if($kbelow ==$maxColLimit+2 and $b !=$rowbay->maxRowLimBlw) 
							{
								if($kbelow<10)
									echo "0".$kbelow;
								else
									echo $kbelow;
							}*/
						?>
					</td>
				<?php 				
					$kbelow = $kbelow-2;
				} 
				
				// for centre line
				if($rowbay->centerLineB==1)
				{			
				?>
				<!-- Center column -->
				<td <?php if(in_array("00".$b, $lowGapValArr)){?>class="nogrid"<?php } else {?>class="grid"<?php } ?>></td>		
				<!-- Right side column -->
				<?php 
				}
				elseif($rowbay->centerLineB==0 and $rowbay->gapLineB==1)
				{
				?>
				<td class="nogrid"></td>
				<?php 
				}
				$lBelow = 1;
				//echo $l;
				if($maxCol%2==0)
					$rcLimitBelow = $maxCol-1;
				else
					$rcLimitBelow = $maxCol;
				//echo "l==".$rcLimitBelow;
				//echo "m==".$maxColLimit."<br>";
				while($lBelow<=$rcLimitBelow)
				{
				if($lBelow<10)
					$kbvalR = "0".$lBelow;
				else
					$kbvalR = $lBelow;
					
				$gapStrBR = $kbvalR.$bval;				
				?>		
					<td <?php if($lBelow >$maxColLimit){?>class="nogrid"<?php } elseif(in_array($gapStrBR, $lowGapValArr)){?>class="nogrid"<?php } else {?> class="grid" <?php }?> >
					
					</td>	
				<?php 
					$lBelow = $lBelow+2;	
				}
				?>
				<td class="nogrid" align="center"><?php if($b<10){echo "0".$b;}else{echo $b;} ?></td>
				
			</tr>
					
			<?php 
			$b = $b-2;
			
			}
		
		?>
		
			<!-- below label-->
			<tr>
				<td></td>
				<?php 
				//$maxCol = intval($rowbay->maxColLimAbv);			
					
				if($maxCol%2==1)
				{
					$kl = $maxCol-1;
				}
				else
				{
					$kl = $maxCol;
				}
				//echo "kl==".$kl;	
				if($rowbay->centerLineA==0 and $rowbay->centerLineB!=0)
				$kl = $kl-2;
				if($rowbay->centerLineA==0 and $rowbay->centerLineB==0)
					$kl = $kl;
				while($kl>=02)
				{
				?>
				<td class="nogrid" align="center"><?php if($kl<10) echo "0".$kl; else echo $kl; ?></td>
				<?php 
				$kl = $kl-2;
				}
				if($rowbay->centerLineB==1)
				{
				?>
				<td class="nogrid" align="center">00</td>
				<?php 
				}
				elseif($rowbay->centerLineB==0 and $rowbay->gapLineB==1)
				{
				?>
				<td class="nogrid" align="center"></td>
				<?php
				}
				$ll = 1;
				//echo $l;
				
				if($maxCol%2==0)
					$rLimit = $maxCol-1;
				else
					$rLimit = $maxCol;
					
				if($rowbay->centerLineA==0 and $rowbay->centerLineB!=0)
				$rLimit = $rLimit-2;
				if($rowbay->centerLineA==0 and $rowbay->centerLineB==0)
					$rLimit = $rLimit;
					
				while($ll<=$rLimit)
				{
				?>
				<td class="nogrid" align="center"><?php if($ll<10) echo "0".$ll; else echo $ll; ?></td>
				<?php 
				$ll = $ll+2;
				
				}
				
			}
			//if($rowbay->bay==29)
			//return;
			?>
		</tr>
		<tr>
			<td colspan="12">&nbsp;</td>
		</tr>
	</table>
	<span class="pagebreak"> </span>
<?php
} 
 mysql_close($con_sparcsn4);
?>
</body>
</html>
