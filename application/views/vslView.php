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



<title>Vessel Bay View</title>

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
			background-color:#93E0FE;
			color:black;
			font-size: 75%;
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
$numrowPrevCont=0;
$numrowPrevContRight=0;
$numrowPrevContBelow=0;
$numrowPrevContBelowRight=0;
//$vvdGkey = $_REQUEST['vvdGkey'];

// GET GKEY BY USING ROTATION START
$vsl_rotation = $_REQUEST['vsl_rotation'];
$str = "select sparcsn4.vsl_vessel_visit_details.vvd_gkey,sparcsn4.vsl_vessel_visit_details.ib_vyg
				from sparcsn4.vsl_vessel_visit_details
				inner join sparcsn4.argo_carrier_visit on sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
				inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
				where ib_vyg='$vsl_rotation' ";
		$query = mysql_query($str);
		$row = mysql_fetch_object($query);
		$vvdGkey=$row->vvd_gkey;
// END		
$strVGkey = "select sparcsn4.vsl_vessels.id,sparcsn4.vsl_vessels.name,sparcsn4.vsl_vessel_visit_details.ib_vyg,
sparcsn4.argo_carrier_visit.ata,sparcsn4.argo_carrier_visit.atd
from sparcsn4.vsl_vessel_visit_details
inner join sparcsn4.argo_carrier_visit on sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
where sparcsn4.vsl_vessel_visit_details.vvd_gkey='$vvdGkey'";
//echo $strVGkey."<hr>";
$resVGkey = mysql_query($strVGkey);
$rowVGkey = mysql_fetch_object($resVGkey);
$vslId = $rowVGkey->id;
$vslName = $rowVGkey->name;
$rot = $rowVGkey->ib_vyg;
$ata = $rowVGkey->ata;
$atd = $rowVGkey->atd;
$strBay = "select * from ctmsmis.misBayView where vslId='$vslId' order by bay asc";
$resBay = mysql_query($strBay);
$numRowsBay = mysql_num_rows($resBay);
if($numRowsBay==0)
{
echo "<div align='center'><font color='red' size='5'><b>Sorry! Vessel $vslName is not drawn yet.Please contact with Datasoft people (+8801749923327) to draw this vessel...</b></font></div>";
return;
}
echo "<h1 align='center'>Vessel: $vslName, Rotation: $rot</h1>";
echo "<h2 align='center'>Arrival Time:$ata, Depart Time:$atd</h2>";
$mystat = 0;
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
		$bay = $title1.",".$title2;
		
	}	
	else 
	{
		if($rowbay->bay<10)
			$title = "0".$rowbay->bay;
		else
			$title = $rowbay->bay;
		
		$bay = $title;
	}
	
	$prevBay1 = $rowbay->bay-1;
	$prevBay2 = $rowbay->bay-2;
	$strChkBay = "select count(bay) as cnt from ctmsmis.misBayView where vslId='$vslId' and bay=$prevBay1";
	$resChkBay = mysql_query($strChkBay);
	$rowChkBay = mysql_fetch_object($resChkBay);
	
	$strBayState = "";
	if($rowChkBay->cnt>0)
		$strBayState = "select paired from ctmsmis.misBayView where vslId='$vslId' and bay=$prevBay1";
	else
		$strBayState = "select paired from ctmsmis.misBayView where vslId='$vslId' and bay=$prevBay2";
		
	$resBayState = mysql_query($strBayState);
	$rowBayState = mysql_fetch_object($resBayState);
	$bayState = $rowBayState->paired;
	
	if($rowbay->bay==1 and $rowbay->paired==0)
		$mystat = 1;
	//echo $bay."<br>";
	
	$strMaxCol = "select max(maxColLimit) as maxCol from ctmsmis.misBayViewBelow where vslId='$vslId' and bay=$rowbay->bay";
	//echo $strMaxCol;
	
	$resMaxCol = mysql_query($strMaxCol);
	$rowMaxCol = mysql_fetch_object($resMaxCol);
	$maxCol = intval($rowMaxCol->maxCol);
?>
	<table align="center" cellspacing="0" cellpadding="1">		
		<tr><td></td><td colspan="<?php if($rowbay->centerLineA==1) echo $maxCol+1; else echo $maxCol;?>" class="nogrid" align="center" valign="bottom"><b><?php echo "Bay ".$title; ?></b></td></tr>
		<!-- Row leble start -->
		<tr>
			<td></td>
			<?php 
			//$maxCol = intval($rowbay->maxColLimAbv);			
			$strUpDeckLbl = "select minColLimit,maxColLimit from ctmsmis.misBayViewBelow where vslId='$vslId' and bay=$rowbay->bay";
			//echo $strBlDeck;
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
		$i=$maxRowAbv;
		$tons12 =0;
		$tons11 =0;
		$tons10 =0;
		$tons9 =0;
		$tons8 =0;
		$tons7 =0;
		$tons6 =0;
		$tons5 =0;
		$tons4 =0;
		$tons3 =0;
		$tons2 =0;
		$tons1 =0;
		$tons0 =0;
		while($i>=$minRow)
		{
			//echo $i;
			$strUpDeck = "select minColLimit,maxColLimit from ctmsmis.misBayViewBelow where vslId='$vslId' and bay=$rowbay->bay and bayRow=$i";
			//echo $strBlDeck;
			$resUpDeck = mysql_query($strUpDeck);
			$rowUpDeck = mysql_fetch_object($resUpDeck);
			$minColLimitUp = $rowUpDeck->minColLimit;
			$maxColLimitUp = $rowUpDeck->maxColLimit;
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
				
			while($k>=$minColLimitUp)
			{
				if($k<10)
					$kval = "0".$k;
				else
					$kval = $k;
				$gapStr = $kval.$i;
				//echo $k."<br>";
				if($k<10)
					$pos = "0".$k.$i;
				else
					$pos = $k.$i;
					
				if($rowbay->paired==0)
				{
					$rby1 = $rowbay->bay-2;
					$rby2 = $rowbay->bay-1;
					if($rby1<10)
						$rby12 = "0".$rby1;
					else
						$rby12 = $rby1;
						
					if($rby2<10)
						$rby22 = "0".$rby2;
					else
						$rby22 = $rby2;
						
					//echo $rby12.$pos."-".$rby22.$pos;
					$slot1 = $rby12.$pos;
					$slot2 = $rby22.$pos;
					
					$strPrevCont = "select right(sparcsn4.ref_equip_type.nominal_length,2) as size from ctmsmis.mis_exp_unit 
					inner join sparcsn4.inv_unit on sparcsn4.inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
					inner join sparcsn4.inv_unit_equip on sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
					inner join sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
					inner join sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
					where (stowage_pos='$slot1' or stowage_pos='$slot2') and ctmsmis.mis_exp_unit.vvd_gkey=$vvdGkey";
					$resPrevCont = mysql_query($strPrevCont);
					$rowPrevCont = mysql_fetch_object($resPrevCont);
					$numrowPrevCont = mysql_num_rows($resPrevCont);
					//if($bay==34)
						//echo $strPrevCont."<hr>";
					//echo $pos."=".$numrowPrevCont."-".$rowPrevCont->size;
				}
				
				if($numrowPrevCont>0 and $rowbay->paired==0 and $rowPrevCont->size>20 and $mystat==0 and $bayState>0)
				{
					?>
					<td class="gridcolor" align="center">
						<?php echo $rowPrevCont->size."'";?>
					</td>
					<?php
				}
				else
				{
					$strPos = "select ctmsmis.mis_exp_unit.pod,sparcsn4.inv_unit.freight_kind,sparcsn4.inv_unit.id,cont_mlo as mlo,
					right(sparcsn4.ref_equip_type.nominal_length,2) as size, 
					ceil((ctmsmis.mis_exp_unit.goods_and_ctr_wt_kg/1000)) as tons,sparcsn4.ref_equip_type.iso_group as rfr_connect 
					from ctmsmis.mis_exp_unit 
					inner join sparcsn4.inv_unit on sparcsn4.inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
					inner join sparcsn4.inv_unit_equip on sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
					inner join sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
					inner join sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
					inner JOIN sparcsn4.ref_bizunit_scoped r ON r.gkey=inv_unit.line_op 
					LEFT JOIN sparcsn4.ref_agent_representation x on r.gkey=x.bzu_gkey 
					LEFT JOIN sparcsn4.ref_bizunit_scoped y ON x.agent_gkey=y.gkey
					where ctmsmis.mis_exp_unit.vvd_gkey=$vvdGkey and left(stowage_pos,2) in($bay) and right(stowage_pos,4)='$pos' and right(stowage_pos,2)>=80 order by stowage_pos";
					//echo $strPos."<br>";
					$resPos = mysql_query($strPos);
					$rowPos = mysql_fetch_object($resPos);
					$numrow = mysql_num_rows($resPos);
					if($minColLimitUp!=0)
					{
					?>
					<td <?php if($k >$maxColLimitUp){?>class="nogrid"<?php } elseif(in_array($gapStr, $upGapValArr)){?>class="nogrid"<?php } elseif($numrow>0) {?> class="gridcolor" <?php } else {?> class="grid" <?php }?> align="center">
					<?php
						if($numrow>0 and $k<=$maxColLimitUp)
						{
								$rfrAbvL = $rowPos->rfr_connect;
								$freight_kindAbvL = $rowPos->freight_kind;
								$txtAbvL = "";
								if($rfrAbvL == "RE" or $rfrAbvL == "RS" or $rfrAbvL == "RT" or $rfrAbvL == "HR")
									$txtAbvL = "R";
								elseif($freight_kindAbvL=="MTY")
									$txtAbvL = "E";
								elseif($freight_kindAbvL=="FCL" or $freight_kindAbvL=="LCL")
									$txtAbvL = "D";
									
								echo $rowPos->pod." ".$txtAbvL.$rowPos->size."'<br/>";
								echo $rowPos->id."<br/>";
								echo $rowPos->mlo." ".$rowPos->tons."Ts";
								${'tons'.$k} += $rowPos->tons;
						}
					?>
					</td>
					<?php 
					}
				}				
				$k = $k-2;
			}
			
			// for centre line
			if($rowbay->centerLineA==1 and (!in_array("00".$i, $upGapValArr)))
			{			
				$posCentre = "00".$i;
				
				if($rowbay->paired==0)
				{
					$rbyCntr1 = $rowbay->bay-2;
					$rbyCntr2 = $rowbay->bay-1;
					if($rbyCntr1<10)
						$rbyCntr12 = "0".$rbyCntr1;
					else
						$rbyCntr12 = $rbyCntr1;
						
					if($rbyCntr2<10)
						$rbyCntr22 = "0".$rbyCntr2;
					else
						$rbyCntr22 = $rbyCntr2;
						
					//echo $rby12.$pos."-".$rby22.$pos;
					$slotCntr1 = $rbyCntr12.$posCentre;
					$slotCntr2 = $rbyCntr22.$posCentre;
					
					$strPrevContCntr = "select right(sparcsn4.ref_equip_type.nominal_length,2) as size from ctmsmis.mis_exp_unit 
					inner join sparcsn4.inv_unit on sparcsn4.inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
					inner join sparcsn4.inv_unit_equip on sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
					inner join sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
					inner join sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
					where (stowage_pos='$slotCntr1' or stowage_pos='$slotCntr2') and ctmsmis.mis_exp_unit.vvd_gkey=$vvdGkey";
					$resPrevContCntr = mysql_query($strPrevContCntr);
					$rowPrevContCntr = mysql_fetch_object($resPrevContCntr);
					$numrowPrevContCntr = mysql_num_rows($resPrevContCntr);
					//echo $strPrevContCntr."<hr>";
				}
				
				if($numrowPrevContCntr>0 and $rowbay->paired==0 and $rowPrevContCntr->size>20 and $mystat==0 and $bayState>0)
				{
					?>
					<td class="gridcolor" align="center">
						<?php echo $rowPrevContCntr->size."'";?>
					</td>
					<?php
				}
				else
				{
					$strPosCentre = "select ctmsmis.mis_exp_unit.pod,sparcsn4.inv_unit.freight_kind,sparcsn4.inv_unit.id,cont_mlo as mlo,right(sparcsn4.ref_equip_type.nominal_length,2) as size, ceil((ctmsmis.mis_exp_unit.goods_and_ctr_wt_kg/1000)) as tons,sparcsn4.ref_equip_type.iso_group as rfr_connect 
					from ctmsmis.mis_exp_unit 
					inner join sparcsn4.inv_unit on sparcsn4.inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
					inner join sparcsn4.inv_unit_equip on sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
					inner join sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
					inner join sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
					inner JOIN sparcsn4.ref_bizunit_scoped r ON r.gkey=inv_unit.line_op 
					LEFT JOIN sparcsn4.ref_agent_representation x on r.gkey=x.bzu_gkey 
					LEFT JOIN sparcsn4.ref_bizunit_scoped y ON x.agent_gkey=y.gkey
						where ctmsmis.mis_exp_unit.vvd_gkey=$vvdGkey and left(stowage_pos,2) in($bay) and right(stowage_pos,4)='$posCentre' and right(stowage_pos,2)>=80 order by stowage_pos";
					//echo $strPosCentre."<hr>";
					$resPosCentre = mysql_query($strPosCentre);
					$rowPosCentre = mysql_fetch_object($resPosCentre);
					$numrowCentre = mysql_num_rows($resPosCentre);
					?>
					<!-- Center column -->
					<td <?php if($numrowCentre>0) {?> class="gridcolor" <?php } else {?> class="grid" <?php }?> align="center">
						<?php
							if($numrowCentre>0)
							{
									$rfrAbvC = $rowPosCentre->rfr_connect;
									$freight_kindAbvC = $rowPosCentre->freight_kind;
									$txtAbvC = "";
									if($rfrAbvC == "RE" or $rfrAbvC == "RS" or $rfrAbvC == "RT" or $rfrAbvC == "HR")
										$txtAbvC = "R";
									elseif($freight_kindAbvC=="MTY")
										$txtAbvC = "E";
									elseif($freight_kindAbvC=="FCL" or $freight_kindAbvC=="LCL")
										$txtAbvC = "D";
										
									echo $rowPosCentre->pod." ".$txtAbvC.$rowPosCentre->size."'<br/>";
									echo $rowPosCentre->id."<br/>";
									echo $rowPosCentre->mlo." ".$rowPosCentre->tons."Ts";
									$tons0 += $rowPosCentre->tons;
							}
						?>
					</td>
					
					<!-- Right side column -->
					<?php 
				}
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
			
			$l = $minColLimitUp;
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
				
				if($l<10)
				$posRight = "0".$l.$i;
				else
				$posRight = $l.$i;
				
				if($rowbay->paired==0)
				{
					$rbyRight1 = $rowbay->bay-2;
					$rbyRight2 = $rowbay->bay-1;
					if($rbyRight1<10)
						$rbyRight12 = "0".$rbyRight1;
					else
						$rbyRight12 = $rbyRight1;
						
					if($rbyRight2<10)
						$rbyRight22 = "0".$rbyRight2;
					else
						$rbyRight22 = $rbyRight2;
						
					//echo $rby12.$pos."-".$rby22.$pos;
					$slotRight1 = $rbyRight12.$posRight;
					$slotRight2 = $rbyRight22.$posRight;
					
					$strPrevContRight = "select right(sparcsn4.ref_equip_type.nominal_length,2) as size from ctmsmis.mis_exp_unit 
					inner join sparcsn4.inv_unit on sparcsn4.inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
					inner join sparcsn4.inv_unit_equip on sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
					inner join sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
					inner join sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
					where (stowage_pos='$slotRight1' or stowage_pos='$slotRight2') and ctmsmis.mis_exp_unit.vvd_gkey=$vvdGkey";
					$resPrevContRight = mysql_query($strPrevContRight);
					$rowPrevContRight = mysql_fetch_object($resPrevContRight);
					$numrowPrevContRight = mysql_num_rows($resPrevContRight);
					//echo $pos."=".$numrowPrevCont."-".$rowPrevCont->size;
				}
				
				if($numrowPrevContRight>0 and $rowbay->paired==0 and $rowPrevContRight->size>20 and $mystat==0 and $bayState>0)
				{
					?>
					<td class="gridcolor" align="center">
						<?php echo $rowPrevContRight->size."'";?>
					</td>
					<?php
				}
				else
				{
				$strPosRight = "select ctmsmis.mis_exp_unit.pod,sparcsn4.inv_unit.freight_kind,sparcsn4.inv_unit.id,cont_mlo as mlo,right(sparcsn4.ref_equip_type.nominal_length,2) as size, ceil((ctmsmis.mis_exp_unit.goods_and_ctr_wt_kg/1000)) as tons,sparcsn4.ref_equip_type.iso_group as rfr_connect 
				from ctmsmis.mis_exp_unit 
				inner join sparcsn4.inv_unit on sparcsn4.inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
				inner join sparcsn4.inv_unit_equip on sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
				inner join sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
				inner join sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
				inner JOIN sparcsn4.ref_bizunit_scoped r ON r.gkey=inv_unit.line_op 
				LEFT JOIN sparcsn4.ref_agent_representation x on r.gkey=x.bzu_gkey 
				LEFT JOIN sparcsn4.ref_bizunit_scoped y ON x.agent_gkey=y.gkey
				where ctmsmis.mis_exp_unit.vvd_gkey=$vvdGkey and left(stowage_pos,2) in($bay) and right(stowage_pos,4)='$posRight' and right(stowage_pos,2)>=80 order by stowage_pos";
				//echo $strPosRight."<hr>";
				$resPosRight = mysql_query($strPosRight);
				$rowPosRight = mysql_fetch_object($resPosRight);
				$numrowRight = mysql_num_rows($resPosRight);
				?>
				<td <?php if($l >$maxColLimitUp){?>class="nogrid"<?php } elseif(in_array($gapStrRisht, $upGapValArr)){?>class="nogrid"<?php } elseif($numrowRight>0) {?> class="gridcolor" <?php } else {?> class="grid" <?php }?> align="center">
					<?php
						if($numrowRight>0 and $l<=$maxColLimitUp)
						{
								$rfrAbvR = $rowPosRight->rfr_connect;
								$freight_kindAbvR = $rowPosRight->freight_kind;
								$txtAbvR = "";
								if($rfrAbvR == "RE" or $rfrAbvR == "RS" or $rfrAbvR == "RT" or $rfrAbvR == "HR")
									$txtAbvR = "R";
								elseif($freight_kindAbvR=="MTY")
									$txtAbvR = "E";
								elseif($freight_kindAbvR=="FCL" or $freight_kindAbvR=="LCL")
									$txtAbvR = "D";
									
								echo $rowPosRight->pod." ".$txtAbvR.$rowPosRight->size."'<br/>";
								echo $rowPosRight->id."<br/>";
								echo $rowPosRight->mlo." ".$rowPosRight->tons."Ts";
								${'tons'.$l} += $rowPosRight->tons;
						}
					?>
				</td>
				<?php 
				}
				$l = $l+2;	
			}
			?>
			<td class="nogrid" align="center"><?php echo $i; ?></td>
		</tr>
		<?php 
		$i=$i-2;
		}
		?>
		<!-- Calculation for total Tons start-->
		<tr>
		<td align="center" style="font-family: Verdana,Geneva,sans-serif;">Total</td>
		<!-- Calculation for Left side Total Tons-->
			<?php
				if($maxCol%2==1)
				{
					$tL = $maxCol-1;
				}
				else
				{
					$tL = $maxCol;
				}
				while($tL>=$minColLimitUp)
				{
			?>
					<td align="center" style="font-family: Verdana,Geneva,sans-serif;"><?php echo ${'tons'.$tL}.'Ts'; ?></td>
			<?php
				$tL = $tL-2;
				}
				
				if($rowbay->centerLineA==1)
				{
			?>
					<td align="center" style="font-family: Verdana,Geneva,sans-serif;"><?php echo $tons0."Ts"; ?></td>
			<?php
				}
				elseif($rowbay->centerLineA==0 and $rowbay->gapLineA==1)
				{			
				?>
					<!-- Center column -->
					<td></td>
					
					<!-- Right side column -->
					<?php 
				}
				$tR = $minColLimitUp;
				//echo $l;
				if($maxCol%2==0)
					$rcLimit = $maxCol-1;
				else
					$rcLimit = $maxCol;
				while($tR<=$rcLimit)
				{
			?>
				<td align="center" style="font-family: Verdana,Geneva,sans-serif;"><?php echo ${'tons'.$tR}.'Ts'; ?></td>
			<?php
				$tR = $tR+2;
				}
			?>
		</tr>
		<!-- Calculation for total Tons end-->
		<?php
		if($rowbay->isBelow==1)
		{
		?>
		
		<!-- Dynamic Row end -->
		<tr><td></td><td colspan="<?php if($rowbay->centerLineA==1) echo $maxCol+1; else echo $maxCol;?>" align="center"><hr></td></tr>
		
		<!-- Below part start -->
		<?php 
		$b = $rowbay->maxRowLimBlw;
		$bMin = $rowbay->minRowLimBlw;
		$upGapValBelow = $rowbay->gapLowerRow;
		$upGapValArrBelow = explode(',',$upGapValBelow);
		$tonsB12 =0;
		$tonsB11 =0;
		$tonsB10 =0;
		$tonsB9 =0;
		$tonsB8 =0;
		$tonsB7 =0;
		$tonsB6 =0;
		$tonsB5 =0;
		$tonsB4 =0;
		$tonsB3 =0;
		$tonsB2 =0;
		$tonsB1 =0;
		$tonsB0 =0;
		
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
			//echo "M=".$maxColLimit."<br>";
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
			while($kbelow>=2)
			{
			//echo "KB=".$kbelow."<br>";
				if($b<10)
					$bb = "0".$b;
				else
					$bb = $b;
					
				if($kbelow<10)
					$cc = "0".$kbelow;
				else
					$cc = $kbelow;
					
				$posbelow = $cc.$bb;
				//$gapStr = $kval.$i;
				if($rowbay->paired==0)
				{
					$rbyBelow1 = $rowbay->bay-2;
					$rbyBelow2 = $rowbay->bay-1;
					if($rbyBelow1<10)
						$rbyBelow12 = "0".$rbyBelow1;
					else
						$rbyBelow12 = $rbyBelow1;
						
					if($rbyBelow2<10)
						$rbyBelow22 = "0".$rbyBelow2;
					else
						$rbyBelow22 = $rbyBelow2;
						
					//echo $rby12.$pos."-".$rby22.$pos;
					$slotBelow1 = $rbyBelow12.$posbelow;
					$slotBelow2 = $rbyBelow22.$posbelow;
					
					$strPrevContBelow = "select right(sparcsn4.ref_equip_type.nominal_length,2) as size from ctmsmis.mis_exp_unit 
					inner join sparcsn4.inv_unit on sparcsn4.inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
					inner join sparcsn4.inv_unit_equip on sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
					inner join sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
					inner join sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
					where (stowage_pos='$slotBelow1' or stowage_pos='$slotBelow2') and ctmsmis.mis_exp_unit.vvd_gkey=$vvdGkey";
					$resPrevContBelow = mysql_query($strPrevContBelow);
					$rowPrevContBelow = mysql_fetch_object($resPrevContBelow);
					$numrowPrevContBelow= mysql_num_rows($resPrevContBelow);
					//echo $pos."=".$numrowPrevCont."-".$rowPrevCont->size;
				}
				
				
				if($numrowPrevContBelow>0 and $rowbay->paired==0 and $rowPrevContBelow->size>20 and $kbelow <=$maxColLimit and $mystat==0 and $bayState>0)
				{
					?>
					<td class="gridcolor" align="center">
						<?php echo $rowPrevContBelow->size."'";?>
					</td>
					<?php
				}
				else
				{
					$strPosbelow = "select ctmsmis.mis_exp_unit.pod,sparcsn4.inv_unit.freight_kind,sparcsn4.inv_unit.id,cont_mlo as mlo,right(sparcsn4.ref_equip_type.nominal_length,2) as size, ceil((ctmsmis.mis_exp_unit.goods_and_ctr_wt_kg/1000)) as tons,sparcsn4.ref_equip_type.iso_group as rfr_connect 
					from ctmsmis.mis_exp_unit 
					inner join sparcsn4.inv_unit on sparcsn4.inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
					inner join sparcsn4.inv_unit_equip on sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
					inner join sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
					inner join sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
					inner JOIN sparcsn4.ref_bizunit_scoped r ON r.gkey=inv_unit.line_op 
					LEFT JOIN sparcsn4.ref_agent_representation x on r.gkey=x.bzu_gkey 
					LEFT JOIN sparcsn4.ref_bizunit_scoped y ON x.agent_gkey=y.gkey
					where ctmsmis.mis_exp_unit.vvd_gkey=$vvdGkey and left(stowage_pos,2) in($bay) and right(stowage_pos,4)='$posbelow' and right(stowage_pos,2)<80 order by stowage_pos";
					//echo $strPosbelow."<br>";
					$resPosbelow = mysql_query($strPosbelow);
					$rowPosbelow = mysql_fetch_object($resPosbelow);
					$numrowbelow = mysql_num_rows($resPosbelow);
					?>
					<td <?php if($numrowbelow>0 and $kbelow <=$maxColLimit) {?> class="gridcolor" <?php } elseif(in_array($posbelow, $upGapValArrBelow)){?>class="nogrid"<?php } elseif($kbelow >$maxColLimit){?>class="nogrid"<?php } else {?>class="grid" <?php } ?> align="center">
						<?php 
							
							if($numrowbelow>0 and $kbelow <=$maxColLimit)
							{
								$rfr = $rowPosbelow->rfr_connect;
								$freight_kind = $rowPosbelow->freight_kind;
								$txt = "";
								if($rfr == "RE" or $rfr == "RS" or $rfr == "RT" or $rfr == "HR")
									$txt = "R";
								elseif($freight_kind=="MTY")
									$txt = "E";
								elseif($freight_kind=="FCL" or $freight_kind=="LCL")
									$txt = "D";
									
								echo $rowPosbelow->pod." ".$txt.$rowPosbelow->size."'<br/>";
								echo $rowPosbelow->id."<br/>";
								echo $rowPosbelow->mlo." ".$rowPosbelow->tons."Ts";
								${'tonsB'.$kbelow} += $rowPosbelow->tons;
							}
					?>
					</td>
					<?php 	
				}
				$kbelow = $kbelow-2;
			} 
			// for centre line
			//if($rowbay->centerLineA==1 and (!in_array("00".$i, $upGapValArr)))
			if($rowbay->centerLineB==1 and (!in_array("00".$b, $upGapValArrBelow)))
			{	
				if($b<10)
					$cb = "0".$b;
				else
					$cb = $b;
				$posCentreBelow = "00".$cb;
			
				if($rowbay->paired==0)
				{
					$rbyBelowCntr1 = $rowbay->bay-2;
					$rbyBelowCntr2 = $rowbay->bay-1;
					if($rbyBelowCntr1<10)
						$rbyBelowCntr12 = "0".$rbyBelowCntr1;
					else
						$rbyBelowCntr12 = $rbyBelowCntr1;
						
					if($rbyBelowCntr2<10)
						$rbyBelowCntr22 = "0".$rbyBelowCntr2;
					else
						$rbyBelowCntr22 = $rbyBelowCntr2;
						
					//echo $rby12.$pos."-".$rby22.$pos;
					$slotBelowCntr1 = $rbyBelowCntr12.$posCentreBelow;
					$slotBelowCntr2 = $rbyBelowCntr22.$posCentreBelow;
					
					$strPrevContBelowCntr = "select right(sparcsn4.ref_equip_type.nominal_length,2) as size from ctmsmis.mis_exp_unit 
					inner join sparcsn4.inv_unit on sparcsn4.inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
					inner join sparcsn4.inv_unit_equip on sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
					inner join sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
					inner join sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
					where (stowage_pos='$slotBelowCntr1' or stowage_pos='$slotBelowCntr2') and ctmsmis.mis_exp_unit.vvd_gkey=$vvdGkey";
					$resPrevContBelowCntr = mysql_query($strPrevContBelowCntr);
					$rowPrevContBelowCntr = mysql_fetch_object($resPrevContBelowCntr);
					$numrowPrevContBelowCntr= mysql_num_rows($resPrevContBelowCntr);
					//echo $pos."=".$numrowPrevCont."-".$rowPrevCont->size;
				}
				
				if($numrowPrevContBelowCntr>0 and $rowbay->paired==0 and $rowPrevContBelowCntr->size>20 and $mystat==0 and $bayState>0)
				{
					?>
					<td class="gridcolor" align="center">
						<?php echo $rowPrevContBelowCntr->size."'";?>
					</td>
					<?php
				}
				else
				{
					$strPosCentreBelow = "select ctmsmis.mis_exp_unit.pod,sparcsn4.inv_unit.freight_kind,sparcsn4.inv_unit.id,cont_mlo as mlo,right(sparcsn4.ref_equip_type.nominal_length,2) as size, ceil((ctmsmis.mis_exp_unit.goods_and_ctr_wt_kg/1000)) as tons,sparcsn4.ref_equip_type.iso_group as rfr_connect 
					from ctmsmis.mis_exp_unit 
					inner join sparcsn4.inv_unit on sparcsn4.inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
					inner join sparcsn4.inv_unit_equip on sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
					inner join sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
					inner join sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
					inner JOIN sparcsn4.ref_bizunit_scoped r ON r.gkey=inv_unit.line_op 
					LEFT JOIN sparcsn4.ref_agent_representation x on r.gkey=x.bzu_gkey 
					LEFT JOIN sparcsn4.ref_bizunit_scoped y ON x.agent_gkey=y.gkey
						where ctmsmis.mis_exp_unit.vvd_gkey=$vvdGkey and left(stowage_pos,2) in($bay) and right(stowage_pos,4)='$posCentreBelow' and right(stowage_pos,2)<80 order by stowage_pos";
					//echo $pos."<br>";
					$resPosCentreBelow = mysql_query($strPosCentreBelow);
					$rowPosCentreBelow = mysql_fetch_object($resPosCentreBelow);
					$numrowCentreBelow = mysql_num_rows($resPosCentreBelow);
					?>
					<!-- Center column -->
					<td <?php if($numrowCentreBelow>0) {?> class="gridcolor" <?php } else {?> class="grid" <?php }?> align="center">
							<?php
								if($numrowCentreBelow>0)
								{
									$rfrCtr = $rowPosCentreBelow->rfr_connect;
									$freight_kindCtr = $rowPosCentreBelow->freight_kind;
									$txtCtr = "";
									if($rfrCtr == "RE" or $rfrCtr == "RS" or $rfrCtr == "RT" or $rfrCtr == "HR")
										$txtCtr = "R";
									elseif($freight_kindCtr=="MTY")
										$txtCtr = "E";
									elseif($freight_kindCtr=="FCL" or $freight_kindCtr=="LCL")
										$txtCtr = "D";
										
									echo $rowPosCentreBelow->pod." ".$txtCtr.$rowPosCentreBelow->size."'<br/>";
									echo $rowPosCentreBelow->id."<br/>";
									echo $rowPosCentreBelow->mlo." ".$rowPosCentreBelow->tons."Ts";
									$tonsB0 += $rowPosCentreBelow->tons;
								}
							?>
					</td>			
					<!-- Right side column -->
					<?php	
				}
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
			//echo "LB=".$lBelow."M=".($maxColLimit-1)."<br>";
				if($b<10)
				$posRightBelow = "0".$lBelow."0".$b;
				else
				$posRightBelow = "0".$lBelow.$b;
				
				if($rowbay->paired==0)
				{
					$rbyBelowRight1 = $rowbay->bay-2;
					$rbyBelowRight2 = $rowbay->bay-1;
					if($rbyBelowRight1<10)
						$rbyBelowRight12 = "0".$rbyBelowRight1;
					else
						$rbyBelowRight12 = $rbyBelowRight1;
						
					if($rbyBelowRight2<10)
						$rbyBelowRight22 = "0".$rbyBelowRight2;
					else
						$rbyBelowRight22 = $rbyBelowRight2;
						
					//echo $rby12.$pos."-".$rby22.$pos;
					$slotBelowRight1 = $rbyBelowRight12.$posRightBelow;
					$slotBelowRight2 = $rbyBelowRight22.$posRightBelow;
					
					$strPrevContBelowRight = "select right(sparcsn4.ref_equip_type.nominal_length,2) as size from ctmsmis.mis_exp_unit 
					inner join sparcsn4.inv_unit on sparcsn4.inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
					inner join sparcsn4.inv_unit_equip on sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
					inner join sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
					inner join sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
					where (stowage_pos='$slotBelowRight1' or stowage_pos='$slotBelowRight2') and ctmsmis.mis_exp_unit.vvd_gkey=$vvdGkey";
					$resPrevContBelowRight = mysql_query($strPrevContBelowRight);
					$rowPrevContBelowRight = mysql_fetch_object($resPrevContBelowRight);
					$numrowPrevContBelowRight= mysql_num_rows($resPrevContBelowRight);
					//echo $pos."=".$numrowPrevCont."-".$rowPrevCont->size;
				}
				
				if($numrowPrevContBelowRight>0 and $rowbay->paired==0 and $rowPrevContBelowRight->size>20 and $lBelow <=$maxColLimit-1 and $mystat==0 and $bayState>0)
				{
					?>
					<td class="gridcolor" align="center">
						<?php echo $rowPrevContBelowRight->size."'";?>
					</td>
					<?php
				}
				else
				{				
					$strPosRightBelow = "select ctmsmis.mis_exp_unit.pod,sparcsn4.inv_unit.freight_kind,sparcsn4.inv_unit.id,cont_mlo as mlo,right(sparcsn4.ref_equip_type.nominal_length,2) as size, ceil((ctmsmis.mis_exp_unit.goods_and_ctr_wt_kg/1000)) as tons,sparcsn4.ref_equip_type.iso_group as rfr_connect 
					from ctmsmis.mis_exp_unit 
					inner join sparcsn4.inv_unit on sparcsn4.inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
					inner join sparcsn4.inv_unit_equip on sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
					inner join sparcsn4.ref_equipment on sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
					inner join sparcsn4.ref_equip_type on sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
					inner JOIN sparcsn4.ref_bizunit_scoped r ON r.gkey=inv_unit.line_op 
					LEFT JOIN sparcsn4.ref_agent_representation x on r.gkey=x.bzu_gkey 
					LEFT JOIN sparcsn4.ref_bizunit_scoped y ON x.agent_gkey=y.gkey
					where ctmsmis.mis_exp_unit.vvd_gkey=$vvdGkey and left(stowage_pos,2) in($bay) and right(stowage_pos,4)=right('$posRightBelow',4) and right(stowage_pos,2)<80 order by stowage_pos";
					//echo $strPosRightBelow."<br>";
					$resPosRightBelow = mysql_query($strPosRightBelow);
					$rowPosRightBelow = mysql_fetch_object($resPosRightBelow);
					$numrowRightBelow = mysql_num_rows($resPosRightBelow);
					?>		
					<td <?php if($numrowRightBelow>0 and $lBelow <=$maxColLimit-1) {?> class="gridcolor" <?php } elseif(in_array($posRightBelow, $upGapValArrBelow)){?>class="nogrid"<?php } elseif($lBelow >$maxColLimit){?>class="nogrid"<?php } else {?> class="grid" <?php }?> align="center">
						<?php
							if($numrowRightBelow>0 and $lBelow <=$maxColLimit-1)
							{
								$rfrBlw = $rowPosRightBelow->rfr_connect;
								$freight_kindBlw = $rowPosRightBelow->freight_kind;
								$txtBlw = "";
								if($rfrBlw == "RE" or $rfrBlw == "RS" or $rfrBlw == "RT" or $rfrBlw == "HR")
									$txtBlw = "R";
								elseif($freight_kindBlw=="MTY")
									$txtBlw = "E";
								elseif($freight_kindBlw=="FCL" or $freight_kindBlw=="LCL")
									$txtBlw = "D";
									
								echo $rowPosRightBelow->pod." ".$txtBlw.$rowPosRightBelow->size."'<br/>";
								echo $rowPosRightBelow->id."<br/>";
								echo $rowPosRightBelow->mlo." ".$rowPosRightBelow->tons."Ts";
								${'tonsB'.$lBelow} += $rowPosRightBelow->tons;
							}
						?>
					</td>	
					<?php
				}	
				$lBelow = $lBelow+2;	
			}
			
			?>
			<td class="nogrid" align="center"><?php if($b<10){echo "0".$b;}else{echo $b;} ?></td>
			
		</tr>
				
		<?php 
		$b = $b-2;
		} 
		?>
		
		<!-- Calculation for total Tons start-->
		<tr>
		<td align="center" style="font-family: Verdana,Geneva,sans-serif;">Total</td>
		<!-- Calculation for Left side Total Tons-->
			<?php
				$strBlDeckMC = "select max(maxColLimit) as mc from ctmsmis.misBayViewBelow where vslId='$vslId' and bay=$rowbay->bay and bayRow<80";
				//$strBlDeck = "select minColLimit,maxColLimit from ctmsmis.misBayViewBelow where vslId='$vslId' and bay=$rowbay->bay";
				//echo $strBlDeck;
				$resBlDeckMC = mysql_query($strBlDeckMC);
				$rowBlDeckMC = mysql_fetch_object($resBlDeckMC);
				$mc = $rowBlDeckMC->mc;
				
				if($maxCol%2==1)
				{
					$kbelowT = $maxCol-1;
				}
				else
				{
					$kbelowT = $maxCol;
				}
				if($rowbay->centerLineA==0 and $rowbay->centerLineB!=0)
					$kbelowT = $kbelowT-2;
				else if($rowbay->centerLineA==0 and $rowbay->centerLineB==0)
					$kbelowT = $kbelowT;
					
				while($kbelowT>=2)
				{
			?>
					<td align="center" style="font-family: Verdana,Geneva,sans-serif;"><?php if($kbelowT <=$mc) {echo ${'tonsB'.$kbelowT}.'Ts';} else {echo "";} ?></td>
			<?php
				$kbelowT = $kbelowT-2;
				}
				
				if($rowbay->centerLineB==1)
				{
			?>
					<td align="center" style="font-family: Verdana,Geneva,sans-serif;"><?php echo $tonsB0."Ts"; ?></td>
			<?php
				}
				elseif($rowbay->centerLineB==0 and $rowbay->gapLineB==1)
				{
				?>
				<td></td>
				<?php 
				}
				$lBelowT = 1;
				//echo $l;
				if($maxCol%2==0)
					$rcLimitBelowT = $maxCol-1;
				else
					$rcLimitBelowT = $maxCol;
				while($lBelowT<=$rcLimitBelowT)
				{
			?>
				<td align="center" style="font-family: Verdana,Geneva,sans-serif;"><?php if($lBelowT <=$mc-1){echo ${'tonsB'.$lBelowT}.'Ts';} else {echo "";} ?></td>
			<?php
				$lBelowT = $lBelowT+2;
				}
			?>
		</tr>
		<!-- Calculation for total Tons end-->
		
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
			?>
		</tr>
		<tr>
			<td colspan="12">&nbsp;</td>
		</tr>
	</table>
	<span class="pagebreak"> </span>
<?php 
} 
?>
</body>
</html>
