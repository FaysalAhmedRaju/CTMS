<div align ="center" style="margin:100px;">

	<!--div align="center" style="font-size:18px">
			<title><img align="middle"  width="220px" height="70px" src="<?php echo IMG_PATH?>cpanew.jpg"></title>
	</div>
		<div align="center"><font size="5"><b>INWARD & OUTWARD CONTAINER REGISTER</b></font></div-->

	<table width="100%">
	  <thead>
		<tr height="100px">
			<th align="center" colspan="11">
				<h2><img align="middle"  width="235px" height="75px" src="<?php echo IMG_PATH?>cpanew.jpg"></h2>
			</th>
		</tr>
		<tr bgcolor="#ffffff" height="50px">
			<th align="center" colspan="11"><font size="5"><b>MANLESS GATE INWARD & OUTWARD CONTAINER REGISTER</b></font></th>
		</tr>
		<tr bgcolor="#ffffff" height="50px"  colspan="10">
			<th colspan="2" align="left"><font size="5"><b><?php echo "Gate:  ". $gateResult[0]['id'];?></b></font></td>
			<th colspan="3" align="center"><font size="5"><b>File No: </b></font></td>
			<th colspan="3" ><font size="5"><b>Duty Hours:</b></font></td>
			<th colspan="2" align="right"><font size="5"><b><?php echo "Date:  ". $date; ?></b></font></td>
		</tr>
		
		<?php 
				$loadin=0;
				$loadout=0;
				$mtyin=0;
				$mtyout=0;
		?>
		
		<tr>
			<th rowspan="2" style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b>SL.</b></th>
			<th rowspan="2" style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b>VEHICLE.NO</b></th>
			<th rowspan="2" style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b>CONTAINER.NO.</b></th>
			<th rowspan="2" style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b>SIZE</b></th>
			<th rowspan="2" style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b>SHIPPING AGENT/C&F AGENT</b></th>
			<!--td rowspan="2"><b>SHIPPING AGENT/C&F AGENT</b></td-->
			<th colspan="2" style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b><nobr>LOAD CONT</nobr></b></th>
			<th colspan="2" style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b><nobr>EMPTY CONT</nobr></b></th>
			<th rowspan="2" style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b>EIR NO:-M/GATE PASS NO</b></th>
            <th rowspan="2" style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b>Actual Out Time</b></th>
			<th rowspan="2" style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center"><b>SIGNATURE OF </BR>J/S & A/REPRESTATIVE </b></th>
		</tr>
		<tr>
		    <th style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center" width="8%"><b>IN</b></th>
		    <th style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center" width="8%"><b>OUT<b></th>	    
			<th style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center" width="8%"><b>IN</b></th>
		    <th style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center" width="8%"><b>OUT</b></th>
		</tr>
		</thead>
		

		<?php
			include_once("dbConection.php");
//			$query="SELECT cont_number,freight_kind
//			FROM ctmsmis.mis_ocr_info
//			WHERE entry_dt='$date'";
//			$row_query=mysql_query($query);
			$i=0;
//			while($rtn_query=mysql_fetch_object($row_query)){
//			 $getRegisterDtl="SELECT sparcsn4.road_truck_visit_details.truck_license_nbr,sparcsn4.road_truck_transactions.ctr_id,sparcsn4.road_truck_transactions.stage_id,
//					sparcsn4.road_truck_transactions.ctr_freight_kind,RIGHT(sparcsn4.road_truck_transactions.eqo_eq_length,2) AS size,sparcsn4.road_truck_transactions.nbr,
//					sparcsn4.road_truck_transactions.line_id
//					FROM sparcsn4.road_truck_visit_details
//					INNER JOIN sparcsn4.road_truck_transactions ON sparcsn4.road_truck_transactions.truck_visit_gkey=sparcsn4.road_truck_visit_details.tvdtls_gkey
//					INNER JOIN ctmsmis.mis_ocr_info ON ctmsmis.mis_ocr_info.cont_number=sparcsn4.road_truck_transactions.ctr_id
//					WHERE ctmsmis.mis_ocr_info.entry_dt='$date' AND sparcsn4.road_truck_transactions.ctr_id='".$rtn_query->cont_number."'";

//                $getRegisterDtl="SELECT *,
//(CASE
//WHEN entry_dt_time >= CONCAT('$date',' 08:00:00') AND entry_dt_time <CONCAT('$date',' 16:00:00') THEN 'Shift A'
//WHEN entry_dt_time >= CONCAT('$date',' 16:00:00') AND entry_dt_time <CONCAT(DATE_ADD('$date',INTERVAL 1 DAY),' 00:00:00') THEN 'Shift B'
//WHEN entry_dt_time >= CONCAT('$date',' 00:00:00') AND entry_dt_time <CONCAT(DATE_ADD('$date',INTERVAL 1 DAY),' 08:00:00') THEN 'Shift C'
//END) AS shift
//FROM (
//SELECT ctmsmis.mis_ocr_info.cont_number,ctmsmis.mis_ocr_info.freight_kind,
//sparcsn4.road_truck_visit_details.truck_license_nbr,sparcsn4.road_truck_transactions.ctr_id,sparcsn4.road_truck_transactions.stage_id,
//sparcsn4.road_truck_transactions.ctr_freight_kind,RIGHT(sparcsn4.road_truck_transactions.eqo_eq_length,2) AS size,sparcsn4.road_truck_transactions.nbr,
//sparcsn4.road_truck_transactions.line_id,ctmsmis.mis_ocr_info.entry_dt_time AS entry_dt_time
//FROM sparcsn4.road_truck_visit_details
//INNER JOIN sparcsn4.road_truck_transactions ON sparcsn4.road_truck_transactions.truck_visit_gkey=sparcsn4.road_truck_visit_details.tvdtls_gkey
//INNER JOIN ctmsmis.mis_ocr_info ON ctmsmis.mis_ocr_info.cont_number=sparcsn4.road_truck_transactions.ctr_id
//WHERE DATE(ctmsmis.mis_ocr_info.entry_dt)='$date'
//) AS tmp ORDER BY shift";


                        $getRegisterDtl="SELECT *
FROM (
SELECT ctmsmis.mis_ocr_info.cont_number,ctmsmis.mis_ocr_info.freight_kind,ctmsmis.mis_ocr_info.entry_dt_time AS entry_dt_time,
(SELECT truck_license_nbr FROM sparcsn4.road_truck_visit_details
INNER JOIN sparcsn4.road_truck_transactions ON sparcsn4.road_truck_transactions.truck_visit_gkey=sparcsn4.road_truck_visit_details.tvdtls_gkey
WHERE sparcsn4.road_truck_transactions.unit_gkey=ctmsmis.mis_ocr_info.unit_gkey ORDER BY sparcsn4.road_truck_transactions.gate_gkey DESC LIMIT 1)
AS truck_license_nbr,
(SELECT stage_id FROM sparcsn4.road_truck_transactions 
WHERE sparcsn4.road_truck_transactions.unit_gkey=ctmsmis.mis_ocr_info.unit_gkey ORDER BY sparcsn4.road_truck_transactions.gate_gkey DESC LIMIT 1)
AS stage_id,
(SELECT RIGHT(sparcsn4.road_truck_transactions.eqo_eq_length,2) FROM sparcsn4.road_truck_transactions 
WHERE sparcsn4.road_truck_transactions.unit_gkey=ctmsmis.mis_ocr_info.unit_gkey ORDER BY sparcsn4.road_truck_transactions.gate_gkey DESC LIMIT 1)
AS size,
(SELECT nbr FROM sparcsn4.road_truck_transactions 
WHERE sparcsn4.road_truck_transactions.unit_gkey=ctmsmis.mis_ocr_info.unit_gkey ORDER BY sparcsn4.road_truck_transactions.gate_gkey DESC LIMIT 1)
AS nbr,
(SELECT line_id FROM sparcsn4.road_truck_transactions 
WHERE sparcsn4.road_truck_transactions.unit_gkey=ctmsmis.mis_ocr_info.unit_gkey ORDER BY sparcsn4.road_truck_transactions.gate_gkey DESC LIMIT 1)
AS line_id,
(CASE 
WHEN entry_dt_time >= CONCAT('$date',' 08:00:00') AND entry_dt_time <CONCAT('$date',' 16:00:00') THEN 'Shift A'
WHEN entry_dt_time >= CONCAT('$date',' 16:00:00') AND entry_dt_time <CONCAT(DATE_ADD('$date',INTERVAL 1 DAY),' 00:00:00') THEN 'Shift B'
WHEN entry_dt_time >= CONCAT(DATE_ADD('$date',INTERVAL 1 DAY),' 00:00:00') AND entry_dt_time <CONCAT(DATE_ADD('$date',INTERVAL 1 DAY),' 08:00:00') THEN 'Shift C'
END) AS shift
FROM ctmsmis.mis_ocr_info
WHERE DATE(ctmsmis.mis_ocr_info.entry_dt) BETWEEN '$date' AND '$add_date'
) AS tmp WHERE shift IS NOT NULL  ORDER BY shift,entry_dt_time ASC";
        // print_r($add_date); exit();
        //                $getRegisterDtl="SELECT ctmsmis.mis_ocr_info.rcont_number,ctmsmis.mis_ocr_info.freight_kind,sparcsn4.road_truck_visit_details.truck_license_nbr,sparcsn4.road_truck_transactions.ctr_id,sparcsn4.road_truck_transactions.stage_id,
        //					sparcsn4.road_truck_transactions.ctr_freight_kind,RIGHT(sparcsn4.road_truck_transactions.eqo_eq_length,2) AS size,sparcsn4.road_truck_transactions.nbr,
        //					sparcsn4.road_truck_transactions.line_id
        //					FROM sparcsn4.road_truck_visit_details
        //					INNER JOIN sparcsn4.road_truck_transactions ON sparcsn4.road_truck_transactions.truck_visit_gkey=sparcsn4.road_truck_visit_details.tvdtls_gkey
        //					INNER JOIN ctmsmis.mis_ocr_info ON ctmsmis.mis_ocr_info.cont_number=sparcsn4.road_truck_transactions.ctr_id
        //					WHERE ctmsmis.mis_ocr_info.entry_dt='$date'";
				$row_query_reg=mysql_query($getRegisterDtl);
//               $rtn_query_reg=mysql_fetch_object($row_query_reg);
        $shift="";
        $tot20 = 0;
        while($rtn_query_reg=mysql_fetch_object($row_query_reg)){

					$i++;
            if($shift==$rtn_query_reg->shift or $i==1)
            {
                $tot20 = $tot20+1;
            }

            if($shift!=$rtn_query_reg->shift)
            {
                $shift=$rtn_query_reg->shift;

                if($i!=1)
                {
                    ?>
                    <tr >
                        <td colspan="12" style="border:1px solid black;"><b><?php  echo "Total:".$tot20;?></b></td>
                    </tr>
                    <?php
                    $tot20 = 1;
                }
                ?>

                ?>
                <tr>
                    <td colspan="12" style="border:1px solid black;">
                        <b><?php  echo $rtn_query_reg->shift;?></b>
                    </td>
                </tr>
                <?php
                $i=1;
            }
            $shift=$rtn_query_reg->shift;

            ?>
				<tr border ='1' cellpadding='0' cellspacing='0' style="font-size:12px;  border-collapse: collapse;">
				
					<td  style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $i;?>
					</td>
					
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $rtn_query_reg->truck_license_nbr;?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
<!--						--><?php //echo $rtn_query->cont_number;?>
                        <?php echo $rtn_query_reg->cont_number;?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $rtn_query_reg->size;?>
					</td>	
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $rtn_query_reg->line_id;?>
					</td>										
					<!--td style="text-align:center">
						<?php echo $result[$i]['time_in']?>
					</td-->
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php /*if ($rtn_query_reg->ctr_freight_kind!="MTY" && $rtn_query_reg->stage_id=="In Gate"){ echo "---"; $loadin++; } else  echo "";*/?>
						<?php echo "";?>
					</td>										
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php if ($rtn_query_reg->freight_kind!="MTY") { echo "---"; $loadout++; } else  echo "";?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php /*if ($rtn_query_reg->ctr_freight_kind=="MTY" && $rtn_query_reg->stage_id=="In Gate") { echo "---"; $mtyin++; }else  echo "";*/?>
						<?php echo "";?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php if ($rtn_query_reg->freight_kind=="MTY") { echo "---"; $mtyout++; }else  echo "";?>
					</td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						<?php echo $rtn_query_reg->nbr; ?>
					</td>
                    <td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
                        <?php echo $rtn_query_reg->entry_dt_time; ?>
                    </td>
					<td style="border:1px solid black; font-size:12px;  border-collapse: collapse;" align="center">
						
					</td>		
							
				</tr>
			<?php
			}
		?>
        <tr >
            <td colspan="12" style="border:1px solid black;"><b><?php  echo "Total:".$tot20;?></b></td>

        </tr>
		<!--tr><td colspan='5' border='0'>Total Container :</td></tr-->
		<tr bgcolor="#ffffff" height="50px">
			<th align="center" colspan="10">&nbsp;</th>
		</tr>
		<tr bgcolor="#ffffff" height="50px">
			<th align="center" colspan="10">&nbsp;</th>
		</tr>
		<tr bgcolor="#ffffff" height="50px">
			<th align="center" colspan="10"><font size="5"><b>INWARD & OUTWARD CONTAINER REGISTER SUMMARY IN <?php echo "GATE:  ". $gateResult[0]['id'];?> </b></font></th>
		</tr>
		<tr>
			<td  align="center" colspan="10">
				<table border="1" style="border-collapse:collapse; font-size:12px;" >
					<tr>
						<td colspan='2'>LOAD</td>
						<td colspan='2'>EMPTY</td>
						<td colspan='2' align='center'>TOTAL</td>
					</tr>
					<tr>
						<td>IN</td>
						<td>OUT</td>
						<td>IN</td>
						<td>OUT</td>
						<td>IN</td>
						<td>OUT</td>
					</tr>
					<tr>
						<td><?php echo $loadin; ?></td>
						<td><?php echo $loadout; ?></td>
						<td><?php echo $mtyin; ?></td>
						<td><?php echo $mtyout; ?></td>
						<td><?php echo $loadin+$mtyin; ?></td>
						<td><?php echo $loadout+$mtyout; ?></td>
					</tr>
				</table>
			
			</td>
		
		
		</tr>
		
	</table>
</div>