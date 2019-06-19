<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>Planned Report</TITLE>
		<LINK href="../css/report.css" type=text/css rel=stylesheet>
	    <style type="text/css">
<!--
.style1 {font-size: 12px}
-->
        </style>
</HEAD>
<BODY>

	<?php } else if($_POST['options']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=PlannedReport.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}



?>
<style>
   table {border-collapse:collapse; table-layout:fixed; width:700px;font-size: 80%;}
   table td,th {border:solid 1px #000; width:300px; word-wrap:break-word;}
   img {padding-left:300px;}
</style>
<img align="middle" src="<?php echo IMG_PATH?>cpanew.jpg"/>


<!--<h3 align="center">Vessel Wise CTMS Container Job Done by HHT,VMT and Manually<br/>From  </h3>-->
<h3 align="center">Shed Report<br/></h3>
<h3>Rotation Number : <?php echo $rotation?> Container No :  <?php echo $container?></h3>
<?php 

mysql_close($con);
mysql_close($con1);
if($_POST['options']=='html'){?>	
	</BODY>
</HTML>
<?php }?>
