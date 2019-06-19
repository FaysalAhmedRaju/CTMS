<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>EQUIPMENT CURRENT STATUS</TITLE>
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
		header("Content-Disposition: attachment; filename=EQUIPMENT_CURRENT_STAT.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}

	include("mydbPConnectionctmsmis.php");
	
	?>
<html>

<head>
	<title>EQUIPMENT CURRENT STATUS</title>
	<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-1.4.2.min.js"></script>
	<script>
	var window_focus;
		$(window).focus(function() {
			window_focus = true;
		}).blur(function() {
			window_focus = false;
		});
		function checkReload(){
			if(!window_focus){
				location.reload();  // if not focused, reload
			}
		}
		setInterval(checkReload, 5000);
	</script>
</head>
<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0'>
<tr bgcolor="#ffffff" align="center" height="100px">
		<td colspan="13" align="center">
			<table border=0 width="100%">				
				<tr align="center">
					<td colspan="12"><img height="100px" src="<?php echo IMG_PATH;?>cpa_logo.png" /></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b>CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td>
				</tr>
			
				<tr align="center">
					<td colspan="12"><font size="4"><b><u>STATEMENT OF EQUIPMENT AT GCB YARD UNDER ZONE- AB & C</u></b></font></td>
				</tr>
				<tr align="center">
					<td colspan="12"><font size="4"><b></b></font></td>
				</tr>

			</table>
		
		</td>
		
	</tr>
	
	<tr bgcolor="#ffffff" align="center" height="25px">
		<td colspan="15" align="center"></td>
		
	</tr>
	</table>
	
<table width="100%" border ='1' cellpadding='0' cellspacing='0' >
	
	<tr align="center">
		<td rowspan=2>EQUIPMENT</td>
		<td colspan=4>WORKSHOP-AB</td>
		<td colspan=10>WORKSHOP-C</td>
		<td rowspan=2>TOTAL</td>
	</tr>
	<tr align="center">			
		<td>Y-JR</td>
		<td>Y-AB</td>
		<td>D-REFER</td>
		<td>Y-7</td>
		<td>Y-1,2,MN</td>
		<td>Y-3</td>
		<td>Y-5</td>
		<td>Y-6</td>
		<td>Y-8</td>
		<td>Y-8B</td>
		<td>Y-8 BAPEX</td>
		<td>Y-9,10</td>
		<td>Y-11</td>
		<td>NCY</td>
	</tr>
	<?php	
		$equipArray= Array();
		
		$tot_equip_sc=0;
		$tot_equip_sc_ab=0;
		$tot_equip_sc_c=0;
		
		$tot_equip_rst45=0;
		$tot_equip_rst45_ab=0;
		$tot_equip_rst45_c=0;
		
		$tot_equip_flt16=0;
		$tot_equip_flt16_ab=0;
		$tot_equip_flt16_c=0;
		
		$tot_equip_rst7=0;
		$tot_equip_rst7_ab=0;
		$tot_equip_rst7_c=0;
		
		$tot_equip_flt10=0;
		$tot_equip_flt10_ab=0;
		$tot_equip_flt10_c=0;
	?>
	<tr align="center">			
		<td>SC</td>
		<!-- WORKSHOP-AB -->
		<td>
			<?php 
				$strJRSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'SC%' AND block_cpa='JR' ORDER BY 1";
				$resJRSC = mysql_query($strJRSC);
				$nVal = 0;
				$plusVal = 0;
				while($rowJRSC = mysql_fetch_object($resJRSC)){
					$equiJrSc = $rowJRSC->equipment;
					$strChkShareJrSc = "SELECT DISTINCT equipment,block_cpa
					FROM ctmsmis.mis_equip_assign_detail
					INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
					INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
					WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiJrSc' ORDER BY 1";
					$resCSJS = mysql_query($strChkShareJrSc);
					$numRowCSJS = mysql_num_rows($resCSJS);
					if($numRowCSJS>1)
					{
						$plusVal +=1;
						array_push($equipArray, $equiJrSc);
					}
					else{
						$nVal +=1;
					}
				}
				if($nVal>0 and $plusVal>0)
				{
					$tot_equip_sc=$tot_equip_sc+$nVal+$plusVal;
					$tot_equip_sc_ab=$tot_equip_sc_ab+$nVal+$plusVal;
					echo $nVal.",".$plusVal."+"; 
				}
				else if($nVal>0){
					$tot_equip_sc=$tot_equip_sc+$nVal;
					$tot_equip_sc_ab=$tot_equip_sc_ab+$nVal;
					echo $nVal;
				}
				else if($plusVal>0){
					$tot_equip_sc=$tot_equip_sc+$plusVal;
					$tot_equip_sc_ab=$tot_equip_sc_ab+$plusVal;
					echo $plusVal."+"; 
				}
				else{
					$tot_equip_sc=$tot_equip_sc;
					$tot_equip_sc_ab=$tot_equip_sc_ab;
					echo "-";
				} 
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'SC%' AND block_cpa='AB' ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_sc=$tot_equip_sc+$nValAB+$plusValAB;
					$tot_equip_sc_ab=$tot_equip_sc_ab+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_sc=$tot_equip_sc+$nValAB;
					$tot_equip_sc_ab=$tot_equip_sc_ab+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_sc=$tot_equip_sc+$plusValAB;
					$tot_equip_sc_ab=$tot_equip_sc_ab+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_sc=$tot_equip_sc;
					$tot_equip_sc_ab=$tot_equip_sc_ab;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'SC%' AND block_cpa='DREFFER' ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_sc=$tot_equip_sc+$nValAB+$plusValAB;
					$tot_equip_sc_ab=$tot_equip_sc_ab+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_sc=$tot_equip_sc+$nValAB;
					$tot_equip_sc_ab=$tot_equip_sc_ab+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_sc=$tot_equip_sc+$plusValAB;
					$tot_equip_sc_ab=$tot_equip_sc_ab+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_sc=$tot_equip_sc;
					$tot_equip_sc_ab=$tot_equip_sc_ab;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'SC%' AND block_cpa='Y7' ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_sc=$tot_equip_sc+$nValAB+$plusValAB;
					$tot_equip_sc_ab=$tot_equip_sc_ab+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_sc=$tot_equip_sc+$nValAB;
					$tot_equip_sc_ab=$tot_equip_sc_ab+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_sc=$tot_equip_sc+$plusValAB;
					$tot_equip_sc_ab=$tot_equip_sc_ab+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_sc=$tot_equip_sc;
					$tot_equip_sc_ab=$tot_equip_sc_ab;
					echo "-";
				}
			?>
		</td>
		<!-- WORKSHOP-C-->
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'SC%' AND block_cpa in('Y1','Y2','YMN') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_sc=$tot_equip_sc+$nValAB+$plusValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_sc=$tot_equip_sc+$nValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_sc=$tot_equip_sc+$plusValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_sc=$tot_equip_sc;
					$tot_equip_sc_c=$tot_equip_sc_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'SC%' AND block_cpa in('Y3') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_sc=$tot_equip_sc+$nValAB+$plusValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_sc=$tot_equip_sc+$nValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_sc=$tot_equip_sc+$plusValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_sc=$tot_equip_sc;
					$tot_equip_sc_c=$tot_equip_sc_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'SC%' AND block_cpa in('Y5') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_sc=$tot_equip_sc+$nValAB+$plusValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_sc=$tot_equip_sc+$nValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_sc=$tot_equip_sc+$plusValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_sc=$tot_equip_sc;
					$tot_equip_sc_c=$tot_equip_sc_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'SC%' AND block_cpa in('Y6','Y6X') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_sc=$tot_equip_sc+$nValAB+$plusValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_sc=$tot_equip_sc+$nValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_sc=$tot_equip_sc+$plusValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_sc=$tot_equip_sc;
					$tot_equip_sc_c=$tot_equip_sc_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'SC%' AND block_cpa in('Y8') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_sc=$tot_equip_sc+$nValAB+$plusValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_sc=$tot_equip_sc+$nValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_sc=$tot_equip_sc+$plusValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_sc=$tot_equip_sc;
					$tot_equip_sc_c=$tot_equip_sc_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'SC%' AND block_cpa in('Y8B') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_sc=$tot_equip_sc+$nValAB+$plusValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_sc=$tot_equip_sc+$nValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_sc=$tot_equip_sc+$plusValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_sc=$tot_equip_sc;
					$tot_equip_sc_c=$tot_equip_sc_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'SC%' AND block_cpa like 'BAPX%' ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_sc=$tot_equip_sc+$nValAB+$plusValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_sc=$tot_equip_sc+$nValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_sc=$tot_equip_sc+$plusValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_sc=$tot_equip_sc;
					$tot_equip_sc_c=$tot_equip_sc_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'SC%' AND block_cpa in('Y9','Y10') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_sc=$tot_equip_sc+$nValAB+$plusValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_sc=$tot_equip_sc+$nValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_sc=$tot_equip_sc+$plusValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_sc=$tot_equip_sc;
					$tot_equip_sc_c=$tot_equip_sc_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'SC%' AND block_cpa in('Y11') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_sc=$tot_equip_sc+$nValAB+$plusValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_sc=$tot_equip_sc+$nValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_sc=$tot_equip_sc+$plusValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_sc=$tot_equip_sc;
					$tot_equip_sc_c=$tot_equip_sc_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'SC%' AND block_cpa in('NCY') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_sc=$tot_equip_sc+$nValAB+$plusValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_sc=$tot_equip_sc+$nValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_sc=$tot_equip_sc+$plusValAB;
					$tot_equip_sc_c=$tot_equip_sc_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_sc=$tot_equip_sc;
					$tot_equip_sc_c=$tot_equip_sc_c;
					echo "-";
				}
			?>
		</td>
		<td><?php echo $tot_equip_sc; ?></td>
	</tr>
	<!-- RST45 -->
	<tr align="center">			
		<td>RST 45 Ton(L)</td>
		<td>
			<?php 
				$strJRSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=45 AND block_cpa='JR' ORDER BY 1";
				$resJRSC = mysql_query($strJRSC);
				$nVal = 0;
				$plusVal = 0;
				while($rowJRSC = mysql_fetch_object($resJRSC)){
					$equiJrSc = $rowJRSC->equipment;
					$strChkShareJrSc = "SELECT DISTINCT equipment,block_cpa
					FROM ctmsmis.mis_equip_assign_detail
					INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
					INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
					WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiJrSc' ORDER BY 1";
					$resCSJS = mysql_query($strChkShareJrSc);
					$numRowCSJS = mysql_num_rows($resCSJS);
					if($numRowCSJS>1)
					{
						$plusVal +=1;
						array_push($equipArray, $equiJrSc);
					}
					else{
						$nVal +=1;
					}
				}
				if($nVal>0 and $plusVal>0)
				{
					$tot_equip_rst45=$tot_equip_rst45+$nVal+$plusVal;
					$tot_equip_rst45_ab=$tot_equip_rst45_ab+$nVal+$plusVal;
					
					echo $nVal.",".$plusVal."+"; 
				}
				else if($nVal>0){
					$tot_equip_rst45=$tot_equip_rst45+$nVal;
					$tot_equip_rst45_ab=$tot_equip_rst45_ab+$nVal;
					echo $nVal;
				}
				else if($plusVal>0){
					$tot_equip_rst45=$tot_equip_rst45+$plusVal;
					$tot_equip_rst45_ab=$tot_equip_rst45_ab+$plusVal;
					echo $plusVal."+"; 
				}
				else{
					$tot_equip_rst45=$tot_equip_rst45;
					$tot_equip_rst45_ab=$tot_equip_rst45_ab;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=45 AND block_cpa='AB' ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst45=$tot_equip_rst45+$nValAB+$plusValAB;
					$tot_equip_rst45_ab=$tot_equip_rst45_ab+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$nValAB;
					$tot_equip_rst45_ab=$tot_equip_rst45_ab+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$plusValAB;
					$tot_equip_rst45_ab=$tot_equip_rst45_ab+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst45=$tot_equip_rst45;
					$tot_equip_rst45_ab=$tot_equip_rst45_ab;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=45 AND block_cpa='DREFFER' ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst45=$tot_equip_rst45+$nValAB+$plusValAB;
					$tot_equip_rst45_ab=$tot_equip_rst45_ab+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$nValAB;
					$tot_equip_rst45_ab=$tot_equip_rst45_ab+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$plusValAB;
					$tot_equip_rst45_ab=$tot_equip_rst45_ab+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst45=$tot_equip_rst45;
					$tot_equip_rst45_ab=$tot_equip_rst45_ab;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=45 AND block_cpa='Y7' ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst45=$tot_equip_rst45+$nValAB+$plusValAB;
					$tot_equip_rst45_ab=$tot_equip_rst45_ab+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$nValAB;
					$tot_equip_rst45_ab=$tot_equip_rst45_ab+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$plusValAB;
					$tot_equip_rst45_ab=$tot_equip_rst45_ab+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst45=$tot_equip_rst45;
					$tot_equip_rst45_ab=$tot_equip_rst45_ab;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=45 AND block_cpa in('Y1','Y2','YMN') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst45=$tot_equip_rst45+$nValAB+$plusValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$nValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$plusValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst45=$tot_equip_rst45;
					$tot_equip_rst45_c=$tot_equip_rst45_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=45 AND block_cpa in('Y3') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst45=$tot_equip_rst45+$nValAB+$plusValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$nValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$plusValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst45=$tot_equip_rst45;
					$tot_equip_rst45_c=$tot_equip_rst45_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=45 AND block_cpa in('Y5') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst45=$tot_equip_rst45+$nValAB+$plusValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$nValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$plusValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst45=$tot_equip_rst45;
					$tot_equip_rst45_c=$tot_equip_rst45_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=45 AND block_cpa in('Y6','Y6X') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst45=$tot_equip_rst45+$nValAB+$plusValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$nValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$plusValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst45=$tot_equip_rst45;
					$tot_equip_rst45_c=$tot_equip_rst45_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=45 AND block_cpa in('Y8') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst45=$tot_equip_rst45+$nValAB+$plusValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$nValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$plusValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst45=$tot_equip_rst45;
					$tot_equip_rst45_c=$tot_equip_rst45_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=45 AND block_cpa in('Y8B') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst45=$tot_equip_rst45+$nValAB+$plusValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$nValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$plusValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst45=$tot_equip_rst45;
					$tot_equip_rst45_c=$tot_equip_rst45_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=45 AND block_cpa like 'BAPX%' ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst45=$tot_equip_rst45+$nValAB+$plusValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$nValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$plusValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst45=$tot_equip_rst45;
					$tot_equip_rst45_c=$tot_equip_rst45_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=45 AND block_cpa in('Y9','Y10') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst45=$tot_equip_rst45+$nValAB+$plusValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$nValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$plusValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst45=$tot_equip_rst45;
					$tot_equip_rst45_c=$tot_equip_rst45_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=45 AND block_cpa in('Y11') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst45=$tot_equip_rst45+$nValAB+$plusValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$nValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$plusValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst45=$tot_equip_rst45;
					$tot_equip_rst45_c=$tot_equip_rst45_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=45 AND block_cpa in('NCY') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst45=$tot_equip_rst45+$nValAB+$plusValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$nValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst45=$tot_equip_rst45+$plusValAB;
					$tot_equip_rst45_c=$tot_equip_rst45_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst45=$tot_equip_rst45;
					$tot_equip_rst45_c=$tot_equip_rst45_c;
					echo "-";
				}
			?>
		</td>
		<td><?php echo $tot_equip_rst45; ?></td>
	</tr>
	<!-- FLT16 -->
	<tr align="center">			
		<td>FLT 16 Ton</td>
		<td>
			<?php 
				$strJRSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=16 AND block_cpa='JR' ORDER BY 1";
				$resJRSC = mysql_query($strJRSC);
				$nVal = 0;
				$plusVal = 0;
				while($rowJRSC = mysql_fetch_object($resJRSC)){
					$equiJrSc = $rowJRSC->equipment;
					$strChkShareJrSc = "SELECT DISTINCT equipment,block_cpa
					FROM ctmsmis.mis_equip_assign_detail
					INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
					INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
					WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiJrSc' ORDER BY 1";
					$resCSJS = mysql_query($strChkShareJrSc);
					$numRowCSJS = mysql_num_rows($resCSJS);
					if($numRowCSJS>1)
					{
						$plusVal +=1;
						array_push($equipArray, $equiJrSc);
					}
					else{
						$nVal +=1;
					}
				}
				if($nVal>0 and $plusVal>0)
				{
					$tot_equip_flt16=$tot_equip_flt16+$nVal+$plusVal;
					$tot_equip_flt16_ab=$tot_equip_flt16_ab+$nVal+$plusVal;
					
					echo $nVal.",".$plusVal."+"; 
				}
				else if($nVal>0){
					$tot_equip_flt16=$tot_equip_flt16+$nVal;
					$tot_equip_flt16_ab=$tot_equip_flt16_ab+$nVal;
					echo $nVal;
				}
				else if($plusVal>0){
					$tot_equip_flt16=$tot_equip_flt16+$plusVal;
					$tot_equip_flt16_ab=$tot_equip_flt16_ab+$plusVal;
					echo $plusVal."+"; 
				}
				else{
					$tot_equip_flt16=$tot_equip_flt16;
					$tot_equip_flt16_ab=$tot_equip_flt16_ab;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=16 AND block_cpa='AB' ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt16=$tot_equip_flt16+$nValAB+$plusValAB;
					$tot_equip_flt16_ab=$tot_equip_flt16_ab+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$nValAB;
					$tot_equip_flt16_ab=$tot_equip_flt16_ab+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$plusValAB;
					$tot_equip_flt16_ab=$tot_equip_flt16_ab+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt16=$tot_equip_flt16;
					$tot_equip_flt16_ab=$tot_equip_flt16_ab;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=16 AND block_cpa='DREFFER' ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt16=$tot_equip_flt16+$nValAB+$plusValAB;
					$tot_equip_flt16_ab=$tot_equip_flt16_ab+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$nValAB;
					$tot_equip_flt16_ab=$tot_equip_flt16_ab+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$plusValAB;
					$tot_equip_flt16_ab=$tot_equip_flt16_ab+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt16=$tot_equip_flt16;
					$tot_equip_flt16_ab=$tot_equip_flt16_ab;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=16 AND block_cpa='Y7' ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt16=$tot_equip_flt16+$nValAB+$plusValAB;
					$tot_equip_flt16_ab=$tot_equip_flt16_ab+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$nValAB;
					$tot_equip_flt16_ab=$tot_equip_flt16_ab+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$plusValAB;
					$tot_equip_flt16_ab=$tot_equip_flt16_ab+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt16=$tot_equip_flt16;
					$tot_equip_flt16_ab=$tot_equip_flt16_ab;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=16 AND block_cpa in('Y1','Y2','YMN') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt16=$tot_equip_flt16+$nValAB+$plusValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$nValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$plusValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt16=$tot_equip_flt16;
					$tot_equip_flt16_c=$tot_equip_flt16_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=16 AND block_cpa in('Y3') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt16=$tot_equip_flt16+$nValAB+$plusValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$nValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$plusValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt16=$tot_equip_flt16;
					$tot_equip_flt16_c=$tot_equip_flt16_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=16 AND block_cpa in('Y5') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt16=$tot_equip_flt16+$nValAB+$plusValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$nValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$plusValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt16=$tot_equip_flt16;
					$tot_equip_flt16_c=$tot_equip_flt16_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=16 AND block_cpa in('Y6','Y6X') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt16=$tot_equip_flt16+$nValAB+$plusValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$nValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$plusValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt16=$tot_equip_flt16;
					$tot_equip_flt16_c=$tot_equip_flt16_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=16 AND block_cpa in('Y8') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt16=$tot_equip_flt16+$nValAB+$plusValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$nValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$plusValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt16=$tot_equip_flt16;
					$tot_equip_flt16_c=$tot_equip_flt16_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=16 AND block_cpa in('Y8B') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt16=$tot_equip_flt16+$nValAB+$plusValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$nValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$plusValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt16=$tot_equip_flt16;
					$tot_equip_flt16_c=$tot_equip_flt16_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=16 AND block_cpa like 'BAPX%' ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt16=$tot_equip_flt16+$nValAB+$plusValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$nValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$plusValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt16=$tot_equip_flt16;
					$tot_equip_flt16_c=$tot_equip_flt16_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=16 AND block_cpa in('Y9','Y10') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt16=$tot_equip_flt16+$nValAB+$plusValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$nValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$plusValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt16=$tot_equip_flt16;
					$tot_equip_flt16_c=$tot_equip_flt16_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=16 AND block_cpa in('Y11') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt16=$tot_equip_flt16+$nValAB+$plusValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$nValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$plusValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt16=$tot_equip_flt16;
					$tot_equip_flt16_c=$tot_equip_flt16_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=16 AND block_cpa in('NCY') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt16=$tot_equip_flt16+$nValAB+$plusValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$nValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt16=$tot_equip_flt16+$plusValAB;
					$tot_equip_flt16_c=$tot_equip_flt16_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt16=$tot_equip_flt16;
					$tot_equip_flt16_c=$tot_equip_flt16_c;
					echo "-";
				}
			?>
		</td>
		<td><?php echo $tot_equip_flt16; ?></td>
	</tr>
	<!-- RST7 -->
	<tr align="center">			
		<td>RST 7 Ton</td>
		<td>
			<?php 
				$strJRSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=7 AND block_cpa='JR' ORDER BY 1";
				$resJRSC = mysql_query($strJRSC);
				$nVal = 0;
				$plusVal = 0;
				while($rowJRSC = mysql_fetch_object($resJRSC)){
					$equiJrSc = $rowJRSC->equipment;
					$strChkShareJrSc = "SELECT DISTINCT equipment,block_cpa
					FROM ctmsmis.mis_equip_assign_detail
					INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
					INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
					WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiJrSc' ORDER BY 1";
					$resCSJS = mysql_query($strChkShareJrSc);
					$numRowCSJS = mysql_num_rows($resCSJS);
					if($numRowCSJS>1)
					{
						$plusVal +=1;
						array_push($equipArray, $equiJrSc);
					}
					else{
						$nVal +=1;
					}
				}
				if($nVal>0 and $plusVal>0)
				{
					$tot_equip_rst7=$tot_equip_rst7+$nVal+$plusVal;
					$tot_equip_rst7_ab=$tot_equip_rst7+$nVal+$plusVal;
					
					echo $nVal.",".$plusVal."+"; 
				}
				else if($nVal>0){
					$tot_equip_rst7=$tot_equip_rst7+$nVal;
					$tot_equip_rst7_ab=$tot_equip_rst7_ab+$nVal;
					echo $nVal;
				}
				else if($plusVal>0){
					$tot_equip_rst7=$tot_equip_rst7+$plusVal;
					$tot_equip_rst7_ab=$tot_equip_rst7_ab+$plusVal;
					echo $plusVal."+"; 
				}
				else{
					$tot_equip_rst7=$tot_equip_rst7;
					$tot_equip_rst7_ab=$tot_equip_rst7_ab;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=7 AND block_cpa='AB' ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst7=$tot_equip_rst7+$nValAB+$plusValAB;
					$tot_equip_rst7_ab=$tot_equip_rst7_ab+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$nValAB;
					$tot_equip_rst7_ab=$tot_equip_rst7_ab+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$plusValAB;
					$tot_equip_rst7_ab=$tot_equip_rst7_ab+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst7=$tot_equip_rst7;
					$tot_equip_rst7_ab=$tot_equip_rst7_ab;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=7 AND block_cpa='DREFFER' ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst7=$tot_equip_rst7+$nValAB+$plusValAB;
					$tot_equip_rst7_ab=$tot_equip_rst7_ab+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$nValAB;
					$tot_equip_rst7_ab=$tot_equip_rst7_ab+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$plusValAB;
					$tot_equip_rst7_ab=$tot_equip_rst7_ab+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst7=$tot_equip_rst7;
					$tot_equip_rst7_ab=$tot_equip_rst7_ab;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=7 AND block_cpa='Y7' ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst7=$tot_equip_rst7+$nValAB+$plusValAB;
					$tot_equip_rst7_ab=$tot_equip_rst7_ab+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$nValAB;
					$tot_equip_rst7_ab=$tot_equip_rst7_ab+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$plusValAB;
					$tot_equip_rst7_ab=$tot_equip_rst7_ab+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst7=$tot_equip_rst7;
					$tot_equip_rst7_ab=$tot_equip_rst7_ab;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=7 AND block_cpa in('Y1','Y2','YMN') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst7=$tot_equip_rst7+$nValAB+$plusValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$nValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$plusValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst7=$tot_equip_rst7;
					$tot_equip_rst7_c=$tot_equip_rst7_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=7 AND block_cpa in('Y3') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst7=$tot_equip_rst7+$nValAB+$plusValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$nValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$plusValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst7=$tot_equip_rst7;
					$tot_equip_rst7_c=$tot_equip_rst7_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=7 AND block_cpa in('Y5') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst7=$tot_equip_rst7+$nValAB+$plusValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$nValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$plusValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst7=$tot_equip_rst7;
					$tot_equip_rst7_c=$tot_equip_rst7_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=7 AND block_cpa in('Y6','Y6X') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst7=$tot_equip_rst7+$nValAB+$plusValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$nValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$plusValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst7=$tot_equip_rst7;
					$tot_equip_rst7_c=$tot_equip_rst7_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=7 AND block_cpa in('Y8') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst7=$tot_equip_rst7+$nValAB+$plusValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$nValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$plusValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst7=$tot_equip_rst7;
					$tot_equip_rst7_c=$tot_equip_rst7_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=7 AND block_cpa in('Y8B') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst7=$tot_equip_rst7+$nValAB+$plusValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$nValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$plusValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst7=$tot_equip_rst7;
					$tot_equip_rst7_c=$tot_equip_rst7_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=7 AND block_cpa like 'BAPX%' ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst7=$tot_equip_rst7+$nValAB+$plusValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$nValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$plusValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst7=$tot_equip_rst7;
					$tot_equip_rst7_c=$tot_equip_rst7_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=7 AND block_cpa in('Y9','Y10') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst7=$tot_equip_rst7+$nValAB+$plusValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$nValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$plusValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst7=$tot_equip_rst7;
					$tot_equip_rst7_c=$tot_equip_rst7_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=7 AND block_cpa in('Y11') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst7=$tot_equip_rst7+$nValAB+$plusValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$nValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$plusValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst7=$tot_equip_rst7;
					$tot_equip_rst7_c=$tot_equip_rst7_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'RST%' AND capacity=7 AND block_cpa in('NCY') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_rst7=$tot_equip_rst7+$nValAB+$plusValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$nValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_rst7=$tot_equip_rst7+$plusValAB;
					$tot_equip_rst7_c=$tot_equip_rst7_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_rst7=$tot_equip_rst7;
					$tot_equip_rst7_c=$tot_equip_rst7_c;
					echo "-";
				}
			?>
		</td>
		<td><?php echo $tot_equip_rst7; ?></td>
	</tr>
	<!-- FLT10 -->
	<tr align="center">			
		<td>FLT 10 Ton</td>
		<td>
			<?php 
				$strJRSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=10 AND block_cpa='JR' ORDER BY 1";
				$resJRSC = mysql_query($strJRSC);
				$nVal = 0;
				$plusVal = 0;
				while($rowJRSC = mysql_fetch_object($resJRSC)){
					$equiJrSc = $rowJRSC->equipment;
					$strChkShareJrSc = "SELECT DISTINCT equipment,block_cpa
					FROM ctmsmis.mis_equip_assign_detail
					INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
					INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
					WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiJrSc' ORDER BY 1";
					$resCSJS = mysql_query($strChkShareJrSc);
					$numRowCSJS = mysql_num_rows($resCSJS);
					if($numRowCSJS>1)
					{
						$plusVal +=1;
						array_push($equipArray, $equiJrSc);
					}
					else{
						$nVal +=1;
					}
				}
				if($nVal>0 and $plusVal>0)
				{
					$tot_equip_flt10=$tot_equip_flt10+$nVal+$plusVal;
					$tot_equip_flt10_ab=$tot_equip_flt10_ab+$nVal+$plusVal;
					
					echo $nVal.",".$plusVal."+"; 
				}
				else if($nVal>0){
					$tot_equip_flt10=$tot_equip_flt10+$nVal;
					$tot_equip_flt10_ab=$tot_equip_flt10_ab+$nVal;
					echo $nVal;
				}
				else if($plusVal>0){
					$tot_equip_flt10=$tot_equip_flt10+$plusVal;
					$tot_equip_flt10_ab=$tot_equip_flt10_ab+$plusVal;
					echo $plusVal."+"; 
				}
				else{
					$tot_equip_flt10=$tot_equip_flt10;
					$tot_equip_flt10_ab=$tot_equip_flt10_ab;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND eequipment LIKE 'FLT%' AND capacity=10 AND block_cpa='AB' ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt10=$tot_equip_flt10+$nValAB+$plusValAB;
					$tot_equip_flt10_ab=$tot_equip_flt10_ab+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$nValAB;
					$tot_equip_flt10_ab=$tot_equip_flt10_ab+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$plusValAB;
					$tot_equip_flt10_ab=$tot_equip_flt10_ab+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt10=$tot_equip_flt10;
					$tot_equip_flt10_ab=$tot_equip_flt10_ab;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=10 AND block_cpa='DREFFER' ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt10=$tot_equip_flt10+$nValAB+$plusValAB;
					$tot_equip_flt10_ab=$tot_equip_flt10_ab+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$nValAB;
					$tot_equip_flt10_ab=$tot_equip_flt10_ab+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$plusValAB;
					$tot_equip_flt10_ab=$tot_equip_flt10_ab+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt10=$tot_equip_flt10;
					$tot_equip_flt10_ab=$tot_equip_flt10_ab;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=10 AND block_cpa='Y7' ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt10=$tot_equip_flt10+$nValAB+$plusValAB;
					$tot_equip_flt10_ab=$tot_equip_flt10_ab+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$nValAB;
					$tot_equip_flt10_ab=$tot_equip_flt10_ab+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$plusValAB;
					$tot_equip_flt10_ab=$tot_equip_flt10_ab+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt10=$tot_equip_flt10;
					$tot_equip_flt10_ab=$tot_equip_flt10_ab;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=10 AND block_cpa in('Y1','Y2','YMN') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt10=$tot_equip_flt10+$nValAB+$plusValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$nValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$plusValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt10=$tot_equip_flt10;
					$tot_equip_flt10_c=$tot_equip_flt10_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=10 AND block_cpa in('Y3') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt10=$tot_equip_flt10+$nValAB+$plusValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$nValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$plusValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt10=$tot_equip_flt10;
					$tot_equip_flt10_c=$tot_equip_flt10_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=10 AND block_cpa in('Y5') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt10=$tot_equip_flt10+$nValAB+$plusValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$nValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$plusValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt10=$tot_equip_flt10;
					$tot_equip_flt10_c=$tot_equip_flt10_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=10 AND block_cpa in('Y6','Y6X') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt10=$tot_equip_flt10+$nValAB+$plusValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$nValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$plusValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt10=$tot_equip_flt10;
					$tot_equip_flt10_c=$tot_equip_flt10_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=10 AND block_cpa in('Y8') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt10=$tot_equip_flt10+$nValAB+$plusValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$nValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$plusValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt10=$tot_equip_flt10;
					$tot_equip_flt10_c=$tot_equip_flt10_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=10 AND block_cpa in('Y8B') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt10=$tot_equip_flt10+$nValAB+$plusValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$nValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$plusValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt10=$tot_equip_flt10;
					$tot_equip_flt10_c=$tot_equip_flt10_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=10 AND block_cpa like 'BAPX%' ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt10=$tot_equip_flt10+$nValAB+$plusValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$nValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$plusValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt10=$tot_equip_flt10;
					$tot_equip_flt10_c=$tot_equip_flt10_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=10 AND block_cpa in('Y9','Y10') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt10=$tot_equip_flt10+$nValAB+$plusValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$nValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$plusValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt10=$tot_equip_flt10;
					$tot_equip_flt10_c=$tot_equip_flt10_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=10 AND block_cpa in('Y11') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt10=$tot_equip_flt10+$nValAB+$plusValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$nValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$plusValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt10=$tot_equip_flt10;
					$tot_equip_flt10_c=$tot_equip_flt10_c;
					echo "-";
				}
			?>
		</td>
		<td>
			<?php 
			
				$strABSC = "SELECT DISTINCT equipment
				FROM ctmsmis.mis_equip_assign_detail
				INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
				INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
				WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment LIKE 'FLT%' AND capacity=10 AND block_cpa in('NCY') ORDER BY 1";
				$resABSC = mysql_query($strABSC);
				$nValAB = 0;
				$plusValAB = 0;
				$numRowCSAS = 0;
				$strChkShareABSc = "";
				$equiABSc= "";
				while($rowABSC = mysql_fetch_object($resABSC)){
					$equiABSc = $rowABSC->equipment;
					$inarr = in_array($equiABSc, $equipArray);
					if(!$inarr)
					{
						$strChkShareABSc = "SELECT DISTINCT equipment,block_cpa
						FROM ctmsmis.mis_equip_assign_detail
						INNER JOIN ctmsmis.mis_equip_detail ON mis_equip_assign_detail.equip_detail_id=mis_equip_detail.id
						INNER JOIN ctmsmis.yard_block ON ctmsmis.yard_block.block=ctmsmis.mis_equip_assign_detail.block
						WHERE start_state =1 AND DATE(start_work_time)=DATE(NOW()) AND equipment = '$equiABSc' ORDER BY 1";
						$resCSAS = mysql_query($strChkShareABSc);
						$numRowCSAS = mysql_num_rows($resCSAS);
						if($numRowCSAS>1)
						{
							$plusValAB +=1;
							array_push($equipArray, $equiABSc);
						}
						else{
							$nValAB +=1;
						}
					}
				}
				if($nValAB>0 and $plusValAB>0)
				{
					$tot_equip_flt10=$tot_equip_flt10+$nValAB+$plusValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$nValAB+$plusValAB;
					
					echo $nValAB.",".$plusValAB."+"; 
				}
				else if($nValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$nValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$nValAB;
					echo $nValAB;
				}
				else if($plusValAB>0){
					$tot_equip_flt10=$tot_equip_flt10+$plusValAB;
					$tot_equip_flt10_c=$tot_equip_flt10_c+$plusValAB;
					echo $plusValAB."+"; 
				}
				else{
					$tot_equip_flt10=$tot_equip_flt10;
					$tot_equip_flt10_c=$tot_equip_flt10_c;
					echo "-";
				}
			?>
		</td>
		<td><?php echo $tot_equip_flt10; ?></td>
	</tr>
	<?php //} ?>
	

</table>

<BR>
<table border=0 width="100%">				

	<tr align="center">
		<td colspan="12"><font size="4"><b><u>STATEMENT OF EQUIPMENT AT GCB YARD UNDER ZONE- AB & C</u></b></font></td>
	</tr>
	<tr align="center">
		<td colspan="12"><font size="4"><b></b></font></td>
	</tr>

</table>
<BR>
<table width="100%" border ='1' cellpadding='0' cellspacing='0' >
	
			<tr align="center">
				<td rowspan=3>EQUIPMENT</td>
				<td colspan=4>ZONE-AB</td>
				<td colspan=4>ZONE-C</td>
				<td rowspan=3>TOTAL EQUIPMENT</td>
				<td colspan=2>TOTAL OPERATIONAL</td>
				<td rowspan=3>TOTAL OUT OF ORDER</td>
			</tr>
			<tr align="center">			
				<td rowspan="2">TOTAL NUMBER</td>
				<td colspan="2">OPERATIONAL</td>
				<td rowspan="2">OUT OF ORDER</td>
				<td rowspan="2">TOTAL NUMBER</td>
				<td colspan="2">OPERATIONAL</td>
				<td rowspan="2">OUT OF ORDER</td>
				<td rowspan="2">BOOKED</td>
				<td rowspan="2">STAND BY</td>
			</tr>
			<tr align="center">	
				<td>BOOKED</td>
				<td>STAND BY</td>
				<td>BOOKED</td>
				<td>STAND BY</td>
			</tr>
			
			<?php 
			$sc_ab_tot=0;
			$sc_ab_booked=0;
			$sc_ab_standby=0;
			$sc_ab_out=0;
			
			$sc_c_tot=0;
			$sc_c_booked=0;
			$sc_c_standby=0;
			$sc_c_out=0;
			$scQuery="SELECT
					(SELECT IFNULL(equip_num,0) AS equip_num FROM equip_assign_detail WHERE workshop_zone='AB' AND equipment='SC') AS  ab_tot,
					(SELECT IFNULL(equip_num,0) AS equip_num FROM equip_assign_detail WHERE workshop_zone='C' AND equipment='SC') AS  c_tot,
					(SELECT IFNULL(non_operational,0) AS non_operational FROM equip_assign_detail WHERE workshop_zone='AB' AND equipment='SC') AS  ab_tot_non_op,
					(SELECT IFNULL(non_operational,0) AS non_operational FROM equip_assign_detail WHERE workshop_zone='C' AND equipment='SC') AS  
					c_tot_non_op";
			$rowSCQry=mysql_query($scQuery);
			while($rtnSCQuery=mysql_fetch_object($rowSCQry))
			{
				$sc_ab_tot=$rtnSCQuery->ab_tot;
				$sc_ab_booked=$tot_equip_sc_ab;
				$sc_ab_standby=$rtnSCQuery->ab_tot - ($tot_equip_sc_ab+$rtnSCQuery->ab_tot_non_op);
				$sc_ab_out=$rtnSCQuery->ab_tot_non_op;
				
				$sc_c_tot=$rtnSCQuery->c_tot;
				$sc_c_booked=$tot_equip_sc_c;
				$sc_c_standby=$rtnSCQuery->c_tot - ($tot_equip_sc_c+$rtnSCQuery->c_tot_non_op);

				$sc_c_out=$rtnSCQuery->c_tot_non_op;
				
				if($sc_ab_standby<0)
				{
					$sc_ab_standby=0;
				}
				if($sc_c_standby<0)
				{
					$sc_c_standby=0;
				}
				
			?>
			<tr align="center">			
				<td>SC</td>
				<td><?php echo $sc_ab_tot;  ?></td>
				<td><?php echo $sc_ab_booked;  ?></td>
				<td><?php echo $sc_ab_standby;  ?></td> <!-- STAND BY -->
				<td><?php echo $sc_ab_out;  ?></td>
				
				<td><?php echo $sc_c_tot;  ?></td>
				<td><?php echo $sc_c_booked;  ?></td>
				<td><?php echo $sc_c_standby;  ?></td> <!-- STAND BY -->
				<td><?php echo $sc_c_out;  ?></td>
				
				<td><?php echo $sc_ab_tot+$sc_c_tot ;  ?></td>
				<td><?php echo $sc_ab_booked+$sc_c_booked;  ?></td>
				<td><?php echo $sc_ab_standby+$sc_c_standby;  ?></td>
				<td><?php echo $sc_ab_out+$sc_c_out;  ?></td>
				
			</tr>
			<?php } ?>
			<?php
			$sc_ab_tot=0;
			$sc_ab_booked=0;
			$sc_ab_standby=0;
			$sc_ab_out=0;
			
			$sc_c_tot=0;
			$sc_c_booked=0;
			$sc_c_standby=0;
			$sc_c_out=0;
			
			$scQuery="SELECT
					(SELECT IFNULL(equip_num,0) AS equip_num FROM equip_assign_detail WHERE workshop_zone='AB' AND equipment='RST Loaded 45 Ton') AS  ab_tot,
					(SELECT IFNULL(equip_num,0) AS equip_num FROM equip_assign_detail WHERE workshop_zone='C' AND equipment='RST Loaded 45 Ton') AS  c_tot,
					(SELECT IFNULL(non_operational,0) AS non_operational FROM equip_assign_detail WHERE workshop_zone='AB' AND equipment='RST Loaded 45 Ton') AS  ab_tot_non_op,
					(SELECT IFNULL(non_operational,0) AS non_operational FROM equip_assign_detail WHERE workshop_zone='C' AND equipment='RST Loaded 45 Ton') AS  
					c_tot_non_op";
			$rowSCQry=mysql_query($scQuery);
			while($rtnSCQuery=mysql_fetch_object($rowSCQry))
			{
				$sc_ab_tot=$rtnSCQuery->ab_tot;
				$sc_ab_booked=$tot_equip_rst45_ab;
				$sc_ab_standby=$rtnSCQuery->ab_tot - ($tot_equip_rst45_ab+$rtnSCQuery->ab_tot_non_op);
				$sc_ab_out=$rtnSCQuery->ab_tot_non_op;
				
				$sc_c_tot=$rtnSCQuery->c_tot;
				$sc_c_booked=$tot_equip_rst45_c;
				$sc_c_standby=$rtnSCQuery->c_tot - ($tot_equip_rst45_c+$rtnSCQuery->c_tot_non_op);
				$sc_c_out=$rtnSCQuery->c_tot_non_op;
				
				if($sc_ab_standby<0)
				{
					$sc_ab_standby=0;
				}
				if($sc_c_standby<0)
				{
					$sc_c_standby=0;
				}
				
			?>
			<tr align="center">			
				<td>RST 45 TON(L)</td>
				<td><?php echo $sc_ab_tot;  ?></td>
				<td><?php echo $sc_ab_booked;  ?></td>
				<td><?php echo $sc_ab_standby;  ?></td> <!-- STAND BY -->
				<td><?php echo $sc_ab_out;  ?></td>
				
				<td><?php echo $sc_c_tot;  ?></td>
				<td><?php echo $sc_c_booked;  ?></td>
				<td><?php echo $sc_c_standby;  ?></td> <!-- STAND BY -->
				<td><?php echo $sc_c_out;  ?></td>
				
				<td><?php echo $sc_ab_tot+$sc_c_tot ;  ?></td>
				<td><?php echo $sc_ab_booked+$sc_c_booked;  ?></td>
				<td><?php echo $sc_ab_standby+$sc_c_standby;  ?></td>
				<td><?php echo $sc_ab_out+$sc_c_out;  ?></td>
				
			</tr>
			<?php } ?>
			<?php
			$sc_ab_tot=0;
			$sc_ab_booked=0;
			$sc_ab_standby=0;
			$sc_ab_out=0;
			
			$sc_c_tot=0;
			$sc_c_booked=0;
			$sc_c_standby=0;
			$sc_c_out=0;
			
			$scQuery="SELECT
					(SELECT IFNULL(equip_num,0) AS equip_num FROM equip_assign_detail WHERE workshop_zone='AB' AND equipment='FLT 16 Ton') AS  ab_tot,
					(SELECT IFNULL(equip_num,0) AS equip_num FROM equip_assign_detail WHERE workshop_zone='C' AND equipment='FLT 16 Ton') AS  c_tot,
					(SELECT IFNULL(non_operational,0) AS non_operational FROM equip_assign_detail WHERE workshop_zone='AB' AND equipment='FLT 16 Ton') AS  ab_tot_non_op,
					(SELECT IFNULL(non_operational,0) AS non_operational FROM equip_assign_detail WHERE workshop_zone='C' AND equipment='FLT 16 Ton') AS  
					c_tot_non_op";
			$rowSCQry=mysql_query($scQuery);
			while($rtnSCQuery=mysql_fetch_object($rowSCQry))
			{
				$sc_ab_tot=$rtnSCQuery->ab_tot;
				$sc_ab_booked=$tot_equip_flt16_ab;
				$sc_ab_standby=$rtnSCQuery->ab_tot - ($tot_equip_flt16_ab+$rtnSCQuery->ab_tot_non_op);
				$sc_ab_out=$rtnSCQuery->ab_tot_non_op;
				
				$sc_c_tot=$rtnSCQuery->c_tot;
				$sc_c_booked=$tot_equip_flt16_c;
				$sc_c_standby=$rtnSCQuery->c_tot - ($tot_equip_flt16_c+$rtnSCQuery->c_tot_non_op);
				$sc_c_out=$rtnSCQuery->c_tot_non_op;
				
				if($sc_ab_standby<0)
				{
					$sc_ab_standby=0;
				}
				if($sc_c_standby<0)
				{
					$sc_c_standby=0;
				}
				
			?>
			<tr align="center">			
				<td>FLT 16 TON</td>
				<td><?php echo $sc_ab_tot;  ?></td>
				<td><?php echo $sc_ab_booked;  ?></td>
				<td><?php echo $sc_ab_standby;  ?></td> <!-- STAND BY -->
				<td><?php echo $sc_ab_out;  ?></td>
				
				<td><?php echo $sc_c_tot;  ?></td>
				<td><?php echo $sc_c_booked;  ?></td>
				<td><?php echo $sc_c_standby;  ?></td> <!-- STAND BY -->
				<td><?php echo $sc_c_out;  ?></td>
				
				<td><?php echo $sc_ab_tot+$sc_c_tot ;  ?></td>
				<td><?php echo $sc_ab_booked+$sc_c_booked;  ?></td>
				<td><?php echo $sc_ab_standby+$sc_c_standby;  ?></td>
				<td><?php echo $sc_ab_out+$sc_c_out;  ?></td>
				
			</tr>
			<?php } ?>
			<?php
			$sc_ab_tot=0;
			$sc_ab_booked=0;
			$sc_ab_standby=0;
			$sc_ab_out=0;
			
			$sc_c_tot=0;
			$sc_c_booked=0;
			$sc_c_standby=0;
			$sc_c_out=0;
			
			$scQuery="SELECT
					(SELECT IFNULL(equip_num,0) AS equip_num FROM equip_assign_detail WHERE workshop_zone='AB' AND equipment='RST 7 Ton') AS  ab_tot,
					(SELECT IFNULL(equip_num,0) AS equip_num FROM equip_assign_detail WHERE workshop_zone='C' AND equipment='RST 7 Ton') AS  c_tot,
					(SELECT IFNULL(non_operational,0) AS non_operational FROM equip_assign_detail WHERE workshop_zone='AB' AND equipment='RST 7 Ton') AS  ab_tot_non_op,
					(SELECT IFNULL(non_operational,0) AS non_operational FROM equip_assign_detail WHERE workshop_zone='C' AND equipment='RST 7 Ton') AS  
					c_tot_non_op";
			$rowSCQry=mysql_query($scQuery);
			while($rtnSCQuery=mysql_fetch_object($rowSCQry))
			{
				$sc_ab_tot=$rtnSCQuery->ab_tot;
				$sc_ab_booked=$tot_equip_rst7_ab;
				$sc_ab_standby=$rtnSCQuery->ab_tot - ($tot_equip_rst7_ab+$rtnSCQuery->ab_tot_non_op);
				$sc_ab_out=$rtnSCQuery->ab_tot_non_op;
				
				$sc_c_tot=$rtnSCQuery->c_tot;
				$sc_c_booked=$tot_equip_rst7_c;
				$sc_c_standby=$rtnSCQuery->c_tot - ($tot_equip_rst7_c+$rtnSCQuery->c_tot_non_op);
				$sc_c_out=$rtnSCQuery->c_tot_non_op;
				
				if($sc_ab_standby<0)
				{
					$sc_ab_standby=0;
				}
				if($sc_c_standby<0)
				{
					$sc_c_standby=0;
				}
				
			?>
			<tr align="center">			
				<td>RST 7 TON</td>
				<td><?php echo $sc_ab_tot;  ?></td>
				<td><?php echo $sc_ab_booked;  ?></td>
				<td><?php echo $sc_ab_standby;  ?></td> <!-- STAND BY -->
				<td><?php echo $sc_ab_out;  ?></td>
				
				<td><?php echo $sc_c_tot;  ?></td>
				<td><?php echo $sc_c_booked;  ?></td>
				<td><?php echo $sc_c_standby;  ?></td> <!-- STAND BY -->
				<td><?php echo $sc_c_out;  ?></td>
				
				<td><?php echo $sc_ab_tot+$sc_c_tot ;  ?></td>
				<td><?php echo $sc_ab_booked+$sc_c_booked;  ?></td>
				<td><?php echo $sc_ab_standby+$sc_c_standby;  ?></td>
				<td><?php echo $sc_ab_out+$sc_c_out;  ?></td>
				
			</tr>
			<?php } ?>
			<?php
			$sc_ab_tot=0;
			$sc_ab_booked=0;
			$sc_ab_standby=0;
			$sc_ab_out=0;
			
			$sc_c_tot=0;
			$sc_c_booked=0;
			$sc_c_standby=0;
			$sc_c_out=0;
			
			$scQuery="SELECT
					(SELECT IFNULL(equip_num,0) AS equip_num FROM equip_assign_detail WHERE workshop_zone='AB' AND equipment='FLT 10 Ton') AS  ab_tot,
					(SELECT IFNULL(equip_num,0) AS equip_num FROM equip_assign_detail WHERE workshop_zone='C' AND equipment='FLT 10 Ton') AS  c_tot,
					(SELECT IFNULL(non_operational,0) AS non_operational FROM equip_assign_detail WHERE workshop_zone='AB' AND equipment='FLT 10 Ton') AS  ab_tot_non_op,
					(SELECT IFNULL(non_operational,0) AS non_operational FROM equip_assign_detail WHERE workshop_zone='C' AND equipment='FLT 10 Ton') AS  
					c_tot_non_op";
			$rowSCQry=mysql_query($scQuery);
			while($rtnSCQuery=mysql_fetch_object($rowSCQry))
			{
				$sc_ab_tot=$rtnSCQuery->ab_tot;
				$sc_ab_booked=$tot_equip_flt10_ab;
				$sc_ab_standby=$rtnSCQuery->ab_tot - ($tot_equip_flt10_ab+$rtnSCQuery->ab_tot_non_op);
				$sc_ab_out=$rtnSCQuery->ab_tot_non_op;
				
				$sc_c_tot=$rtnSCQuery->c_tot;
				$sc_c_booked=$tot_equip_flt10_c;
				$sc_c_standby=$rtnSCQuery->c_tot - ($tot_equip_flt10_c+$rtnSCQuery->c_tot_non_op);
				$sc_c_out=$rtnSCQuery->c_tot_non_op;
				
				if($sc_ab_standby<0)
				{
					$sc_ab_standby=0;
				}
				if($sc_c_standby<0)
				{
					$sc_c_standby=0;
				}
				
			?>
			<tr align="center">			
				<td>FLT 10 TON</td>
				<td><?php echo $sc_ab_tot;  ?></td>
				<td><?php echo $sc_ab_booked;  ?></td>
				<td><?php echo $sc_ab_standby;  ?></td> <!-- STAND BY -->
				<td><?php echo $sc_ab_out;  ?></td>
				
				<td><?php echo $sc_c_tot;  ?></td>
				<td><?php echo $sc_c_booked;  ?></td>
				<td><?php echo $sc_c_standby;  ?></td> <!-- STAND BY -->
				<td><?php echo $sc_c_out;  ?></td>
				
				<td><?php echo $sc_ab_tot+$sc_c_tot ;  ?></td>
				<td><?php echo $sc_ab_booked+$sc_c_booked;  ?></td>
				<td><?php echo $sc_ab_standby+$sc_c_standby;  ?></td>
				<td><?php echo $sc_ab_out+$sc_c_out;  ?></td>
				
			</tr>
			<?php } ?>
			<!--tr align="center">			
				<td><?php echo $rtnTotQuery->equipment;  ?></td>
				<td><?php echo $rtnTotQuery->ab_tot;  ?></td>
				<td><?php echo $rtnTotQuery->ab_tot_booked;  ?></td>
				<td><?php echo $rtnTotQuery->ab_tot_standby;  ?></td>
				<td><?php echo $rtnTotQuery->ab_tot_non_op;  ?></td>
				<td><?php echo $rtnTotQuery->c_tot;  ?></td>
				<td><?php echo $rtnTotQuery->c_tot_booked;  ?></td>
				<td><?php echo $rtnTotQuery->c_tot_standby;  ?></td>
				<td><?php echo $rtnTotQuery->c_tot_non_op;  ?></td>
				<td><?php echo $rtnTotQuery->tot_equip;  ?></td>
				<td><?php echo $rtnTotQuery->tot_op_booked;  ?></td>
				<td><?php echo $rtnTotQuery->tot_op_standby;  ?></td>
				<td><?php echo $rtnTotQuery->tot_non_op;  ?></td>
				
			</tr-->
			<?php //} ?>
			
		</table>

<?php 
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
