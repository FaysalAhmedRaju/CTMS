<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>Discharge List</TITLE>
		<LINK href="../css/report.css" type=text/css rel=stylesheet>
	    <style type="text/css">
<!--
.style1 {font-size: 12px}
-->
        </style>
</HEAD>


	<?php } 
	else if($_POST['options']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=EXPORT_SUMMERY.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	} ?>
	
<body>
  <table width="100%" cellpadding="0">
	   <tr height="100px">
			<td align="center" valign="middle"><?php echo $login; ?>
				 <h1>Chittagong Port Authority </h1>
				 <h3>Discharge List <?php echo " From: ".$fromDate." To: ".$toDate;?></h3>
			</td>
	   </tr>
        <tr>	
		 <td>
				<table border="1" align="center" cellspacing="1" cellpadding="1">
					  <tr>
						   <th>Sl No.</th>     
						   <th>CONTAINER</th>       
						   <th>CONT. SIZE</th>       
						   <th>CONT. HEIGHT</th>       
						   <th>STATUS</th>       
						   <th>DISCHARGE TIME</th>
						   <th>DELIVERY TIME</th>
					  </tr>
				   <?php
				   
					for($i=0;$i<count($getList);$i++) { 
					 ?>
					 <tr>
						  <td>
						   <?php echo $i+1;?>
						  </td>
						  <td align="center">
						   <?php echo $getList[$i]['id']?>
						  </td>
						  <td align="center">
						   <?php echo $getList[$i]['size']?>
						  </td>
						  <td align="center">
						   <?php echo $getList[$i]['height']?>
						  </td>
						  <td align="center">
						   <?php echo $getList[$i]['freight_kind']?>
						  </td>
						  <td align="center">
						   <?php echo $getList[$i]['time_in']?>
						  </td>   		  
						  <td align="center">
						   <?php echo $getList[$i]['time_out']?>
						  </td>                  
					 </tr>
					 <?php
					}
				   ?>
				 </table> 
			  </td>	
	    	</tr>	
		</table>	
    </body>
 </html>