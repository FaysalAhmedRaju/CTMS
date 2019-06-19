<?php if($_POST['options']=='html'){?>

<?php }
else if($_POST['options']=='xl'){
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=APPRAISE_RE_SLOT_LOCATIONxls;");
    header("Content-Type: application/ms-excel");
    header("Pragma: no-cache");
    header("Expires: 0");

}
include("dbConection.php");
?>
<html>

<body>
<table width="100%" border ='0' cellpadding='0' cellspacing='0' align="center">
    <tr align="center">
        <!--td colspan="10" align="center"><font size="4"><b>CHITTAGONG PORT AUTHORITY,CHITTAGONG</b></font></td-->
        <td colspan="10" align="center"><img align="middle"  width="220px" height="70px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
    </tr>
    <tr align="center" >
        <td colspan="6" style="text-align: left;"  >
           <b><?php echo " SHED NO : ".$shed_no?></b>
        </td>
        <td colspan="6" style="text-align: right;"><b>
                    <?php
                    /*$searchFrom = $fromDt." ".$fromTime.":00";
                    $searchTo = $fromDt." ".$toTime.":00";
                    echo " FROM : ".$searchFrom." TO : ".$searchTo; */
                    echo " DATE : ".$importCargodate;
                    ?>
                </b>
        </td>
    </tr>
    <tr align="center">
        <td colspan="10" align="center"><font size="4"><b>IMPORT CARGO RECEIVING & DELIVERY REPORT</b></font></td>

    </tr>
    <tr>
        &nbsp;
    </tr>
</table>
<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
    <thead>
    <tr  align="center">
        <th style=""><b>1</b></th>
        <th style=""><b>2</b></th>
        <th style=""><b>3</b></th>
        <th style=""><b>4</b></th>
        <th style=""><b>5</b></th>
        <th style="" colspan="2"><b>6</b></th>
        <th style=""><b>7</b></th>
        <th style=""><b>8</b></th>
        <th style=""><b>9</b></th>
        <th style=""><b>10</b></th>

    </tr>
    <tr  align="center">
        <th style=""><b>VESSEL NAME</b></th>
        <th style=""><b>REG. NO.</b></th>
        <th style=""><b>CONT. NO.</b></th>
        <th style=""><b>SEAL NO.</b></th>
        <th style=""><b>B/L NO.</b></th>

        <th style=""><b>QTY (PKG)</b></th>
        <th style=""><b>TON</b></th>

        <th style=""><b>B/L NO.</b></th>
        <th style=""><b>REC. BAY NO.</b></th>
        <th style=""><b>BAY INCH</b></th>
        <th style=""><b>T/S OF B.OP.</b></th>
    </tr>
    </thead>
    <tbody>
    <?php
    include("mydbPConnection.php");

    $getImportCargoData = "SELECT `Vessel_Name`,shed_tally_info.`cont_number`,igm_masters.Import_Rotation_No,igm_details.`BL_No`,shed_tally_info.`rcv_pack`,shed_tally_info.`shed_loc`,
igm_details.`Pack_Number`,ROUND(igm_details.`Pack_Number`/1000,2) AS ton 
FROM `igm_masters` 
INNER JOIN `igm_details` ON igm_masters.`id`=igm_details.`IGM_id`
INNER JOIN `shed_tally_info` ON shed_tally_info.`igm_detail_id`=igm_details.id
WHERE DATE(shed_tally_info.last_update) = '$importCargodate' AND shed_tally_info.shed_yard = '$shed_no' 
UNION
SELECT `Vessel_Name`,shed_tally_info.`cont_number`,igm_masters.Import_Rotation_No,igm_supplimentary_detail.`BL_No` ,shed_tally_info.`rcv_pack`,shed_tally_info.`shed_loc`,
igm_supplimentary_detail.`Pack_Number`,ROUND(igm_supplimentary_detail.`Pack_Number`/1000,2) AS ton  
FROM `igm_masters` 
INNER JOIN `igm_supplimentary_detail` ON igm_masters.`id`=igm_supplimentary_detail.`igm_master_id`
INNER JOIN `shed_tally_info` ON shed_tally_info.`igm_sup_detail_id`=igm_supplimentary_detail.id
WHERE DATE(shed_tally_info.last_update) = '$importCargodate' AND shed_tally_info.shed_yard = '$shed_no'";

    $getData = mysql_query($getImportCargoData);
//    $row_data = mysql_fetch_object($getData);
//            echo "<pre>";
//            print_r(mysql_fetch_object($getData));
//            echo "</pre>";
//            exit();
            $i = 0;
            $qty = 0;
            $ton = 0;
    while($row_data = mysql_fetch_object($getData)){
        $i++;
       ?>
                <tr align="center">
                    <td><?php echo $row_data->Vessel_Name;?></td>
                    <td><?php echo $row_data->Import_Rotation_No;?></td>
                    <td><?php echo $row_data->cont_number;?></td>
                    <td><?php echo " ";?></td>
                    <td><?php echo $row_data->BL_No;?></td>
                    <td><?php echo $row_data->Pack_Number;?></td><?php $qty = $qty + $row_data->Pack_Number ?>
                    <td><?php echo $row_data->ton;?></td><?php $ton = $ton + $row_data->ton ?>
                    <td><?php echo " ";?></td>
                    <td><?php echo $row_data->rcv_pack;?></td>
                    <td><?php echo $row_data->shed_loc;?></td>
                    <td><?php echo " ";?></td>
                </tr>

  <?php
			}
    ?>

    <tr align="center">
        <td colspan="2"><b><?php  echo "Total:".$i;?></b></td>
        <td colspan="3"><b><?php  echo " ";?></b></td>
        <td ><b><?php  echo $qty;?></b></td>
        <td ><b><?php  echo $ton;?></b></td>
        <td colspan="4"><b><?php  echo " ";?></b></td>
    </tr>

<!--    --><?php //} ?>
<!--    -->

</table>
<br />
<br />
<table width="100%" border ='1' cellpadding='0' cellspacing='0'>
    <thead>
    <tr  align="center">
        <th style=""><b>11</b></th>
        <th style=""><b>12</b></th>
        <th style=""><b>13</b></th>
        <th style=""><b>14</b></th>
        <th style=""><b>15</b></th>
        <th style="" ><b>16</b></th>
        <th style=""><b>17</b></th>
        <th style=""><b>18</b></th>
        <th style=""><b>19</b></th>
        <th style="" colspan="2"><b>20</b></th>

    </tr>
    <tr  align="center">
        <th style=""><b>B/E NO. & DATE</b></th>
        <th style=""><b>C/P NO.</b></th>
        <th style=""><b>VERIFY NO.</b></th>
        <th style=""><b>C&F AGENT<BR/>NAME & CODE</b></th>
        <th style=""><b>JETTY SIRCAR <BR/>NAME & LICENSE</b></th>

        <th style=""><b>DLY QTY</b></th>
        <th style=""><b>DLY DATE</b></th>

        <th style=""><b>BALANCE<BR/> QTY</b></th>
        <th style=""><b>DLY GANG</b></th>
        <th style="" colspan="2"><b>REMARKS</b></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $getSecondPageData = "SELECT DISTINCT shed_tally_info.verify_number,verify_other_data.be_no,verify_other_data.be_date,bank_bill_recv.cp_no,cnf_name
FROM shed_tally_info
INNER JOIN verify_other_data ON shed_tally_info.id=verify_other_data.shed_tally_id
INNER JOIN shed_bill_master ON shed_bill_master.verify_no=shed_tally_info.verify_number
INNER JOIN bank_bill_recv ON shed_bill_master.bill_no=bank_bill_recv.bill_no
WHERE verify_other_data.be_no!='' AND DATE(shed_tally_info.last_update) = '$importCargodate' AND shed_tally_info.shed_yard = '$shed_no'";
    $getSecondData = mysql_query($getSecondPageData);
    while($row_second_data = mysql_fetch_object($getSecondData)) {
        ?>
        <?php
        $getVNoData = "SELECT SUM(delv_pack) AS delv_pack,DATE(last_update) AS last_update FROM do_information WHERE do_information.verify_no='$row_second_data->verify_number'";
        $vData = mysql_query($getVNoData);
        $row_v_data = mysql_fetch_object($vData);
//                    echo "<pre>";
//            print_r($row_v_data);
//            echo "</pre>";
//            exit();
        ?>
        <tr align="center">
            <td><?php echo $row_second_data->be_no . "--" . $row_second_data->be_date ;?></td>
            <td><?php echo $row_second_data->cp_no;?></td>
            <td><?php echo $row_second_data->verify_number;?></td>
            <td><?php echo $row_second_data->cnf_name;?></td>
            <td><?php echo " ";?></td>
            <td><?php echo $row_v_data->delv_pack;?></td>
            <td><?php echo $row_v_data->last_update;?></td>
            <td><?php echo " ";?></td>
            <td><?php echo " ";?></td>
            <td><?php echo " ";?></td>
            <td><?php echo " ";?></td>
        </tr>





        <?php
    }
    ?>



</table>
</body>
</html>