<html>
<head>
    <table align="center" width="95%">
        <tr>
            <td  align="center"><img align="middle"  width="200px" height="70px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
        </tr>
        <tr>
            <td align="center"><font size="4"><b>DATE WISE ICD ENTRY REPORT</b></font></td>
        </tr>
        <tr>
            <td align="center"><font size="4"><b>Date : <?php echo $icd_entry_date; ?></b></font></td>
        </tr>
    </table>
</head>
<body>
<table border="1" align="center" width="70%" style="border-collapse:collapse">
    <thead>
    <tr>
        <th>Sl</th>
        <th>CIR No</th>
        <th>Time</th>
        <th>PT</th>
        <th>Shift</th>
        <th>Category</th>
        <th>Entry Date</th>
    </tr>
    </thead>
    <?php
    $tot_entry=0;
    for($i=0;$i<count($rslt_icd_report_datewise);$i++)
    {
        ?>
        <tr>
            <td align="center"><?php echo $i+1;?></td>

            <form action="<?php echo site_url("report/icd_icr_wise_report");?>"  method="post" target="_blank">
            <td align="center">

                    <input type="hidden" name="cir_no" id="cir_no" value="<?php echo $rslt_icd_report_datewise[$i]['cir_no'] ?>" />
                    <input type="hidden" name="cir_dt" id="cir_dt" value="<?php echo $rslt_icd_report_datewise[$i]['cir_dt'] ?>" />
                    <input type="submit" name="view" id="view" value="<?php echo $rslt_icd_report_datewise[$i]['cir_no']?>" style="border: hidden"  />

<!--                <a href="--><?php //echo site_url("report/icd_icr_wise_report");?><!--"  method="post" target="_blank">-->
<!---->
<!--                    --><?php //echo $rslt_icd_report_datewise[$i]['cir_no']?>
<!--                </a>-->

            </td>
            </form>
            <td align="center"><?php echo $rslt_icd_report_datewise[$i]['time']?></td>
            <td align="center"><?php echo $rslt_icd_report_datewise[$i]['pt']?></td>
            <td align="center"><?php echo $rslt_icd_report_datewise[$i]['shift']?></td>
            <td align="center"><?php echo $rslt_icd_report_datewise[$i]['category']?></td>
            <td align="center"><?php echo $rslt_icd_report_datewise[$i]['entry_dt']?></td>
        </tr>
        <?php
//        $tot_entry=$tot_entry+$rslt_icd_report_datewise[$i]['cir_no'];
    }
    ?>
    <tr>

        <td align="center" colspan="6"><b>Total</b></td>
        <td align="center"><b><?php echo $i; ?></b></td>
    </tr>
</table>
</body>
</html>
