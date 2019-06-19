<html>
<head>
    <table align="center" width="95%">
        <tr>
            <td  align="center"><img align="middle"  width="200px" height="70px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
        </tr>
        <tr>
            <td align="center"><font size="4"><b>DATE WISE AND CIR NO WISE REPORT</b></font></td>
        </tr>
        <tr>
            <td align="center"><font size="4"><b>Date : <?php echo $cir_dt; ?></b></font></td>
        </tr>
    </table>
</head>
<body>
<table border="1" align="center" width="70%" style="border-collapse:collapse">
    <thead>
    <tr>
        <th>Sl</th>
        <th>Container No</th>
        <th>Rotation</th>
        <th>Wagon No</th>

    </tr>
    </thead>
    <?php
    $tot_entry=0;
    for($i=0;$i<count($rslt_data);$i++)
    {
        ?>
        <tr>
            <td align="center"><?php echo $i+1;?></td>
            <td align="center"><?php echo $rslt_data[$i]['cont_no']?></td>
            <td align="center"><?php echo $rslt_data[$i]['rotation']?></td>
            <td align="center"><?php echo $rslt_data[$i]['wagon_no']?></td>

        </tr>
        <?php
//        $tot_entry=$tot_entry+$rslt_icd_report_datewise[$i]['cir_no'];
    }
    ?>
    <tr>

        <td align="center" colspan="3"><b>Total</b></td>
        <td align="center"><b><?php echo $i; ?></b></td>
    </tr>
</table>
</body>
</html>
