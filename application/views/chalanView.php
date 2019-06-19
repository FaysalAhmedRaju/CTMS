<?php 
for($j=0;$j<$count;$j++)   //in live, code may change as all configuration is not present in local
{ 
?>
<html>
<head>
		<hr>
		<div align="center" style="font-size:18px">
			<title><b>CHITTAGONG PORT AUTHORITY</b></title>
		</div>
		<div align="center"></div>
		<div align="center">INVOICE PAPER</div>

</head>
<body>	
		<div align ="center">
		<table align="center" width="80%" style="font-size:12px">
			<tr style="border-bottom:1px solid black">
				<td>VERIFY NO : <?php echo $verifyNo;?></td>

			</tr>			
		</table>
		<!--hr-->
		
		
		
		<table align="center" width="80%" border="1" style="font-size:12px;  border-collapse: collapse;">
		 <tr>
		   <th rowspan="2"> CNF Detail </th>
		   <th> Name </th>
		   <td><?php echo $cnfName;?></td>	   
		 </tr>
		 
		  <tr>
		   <th> Address</th>
			<td><?php echo $cnfAddress1;?></td>
         </tr>
		 
		 <tr>
		   <th rowspan="2"> IMPORTER Detail</th>
		   <th> Name </th>
		   <td><?php echo $notifyName;?></td>
		 </tr>
         <tr>		  
		   <th> Address</th>
		   <td><?php echo $notifyAddress;?></td>
		 </tr>
		 
		</table>
		
		

		<!--hr-->
		<br>

		<!--div align="center"><font size=4>Description</font></div-->
			<table  align="center" width=80% border="1" style="font-size:12px; border-collapse: collapse;" > 
				<thead style="">
					<tr >		
						<th align="center" >TRUCK NO</th>
						<th align="center" >DESCRIPTION OF GOODS</th>
						<th align="center" >QUANTITY</th>
                        <th align="center" >REMARKS</th>						
					</tr>
				</thead>
				<tbody>
				 <?php       
				for($i=0;$i<count($result3);$i++) { 
				 ?>
				 <tr class="" > 
				  
				  <td align="center">
				   <?php echo $result3[$i]['truck_id']?>
				  </td>
				  <td align="left">
				   <?php echo $goodsDes?>
				  </td>
				  <td align="center">
				   <?php echo $result3[$i]['delv_pack']?>
				  </td>
				  <td align="center">
				   <?php echo $result3[$i]['remarks']?>
				  </td>
				 

				</tr>
				 <?php
				}
			   ?>
			</tbody>
			</table>
		</div>
	
</body>
</html>
<?php 
}
?>
