				<table border=0 width="100%">
				
				
				<tr >
					<td  align="center"><img align="middle"  width="235px" height="80x" src="<?php echo IMG_PATH?>cpanew.jpg"></td></tr>
			
				<tr >
					<td align="center"><font size="4"><b>WORKSTATION REPORT</b></font></td>
				</tr>
				<tr align="center">
					<tr><td align="center"> <?php echo $tableTitle; ?></td></tr>
				</tr>


			</table>

        <table  border="1" cellpadding="0" cellspacing="0" style="font-size:12px;  border-collapse: collapse;">
        <tr style="height:35px;" >
		<font size="15">
			<th rowspan="2">SL</th>
			<th rowspan="2"><nobr>Product Category<nobr></th>
			<th rowspan="2"><nobr>Product Name<nobr></th>        
			<th rowspan="2"><nobr>Serial No.<nobr></th>
			<th colspan="2"><nobr>Monitor Info<nobr></th>
			<th rowspan="2"><nobr>Location Details</nobr></th>
			<th rowspan="2"><nobr>IP Address</nobr></th>			
			<th rowspan="2"><nobr>Model/Dec</nobr></th>
			<th rowspan="2"><nobr>Received Date</nobr></th>
			</font>
		</tr>                
                <tr  style="height:35px;" >
		
		<font size="15">
			<th>Brand</th>
			<th><nobr>Serial<nobr></th>

			</font>
		</tr>
		
	  <?php
     //  loc_id, location_name, owner_id, full_name, type_id, short_name, prod_user_id, 
	//   company_name, prod_serial, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by
        for($i=0;$i<count($list);$i++) { 				
		?>
	      <tr >
		  <td>
           <?php echo $i+1;?>
          </td>
         
        <td align="center">
           <?php echo $list[$i]['short_name']?>
         </td>   
         <td align="center">
           <?php echo $list[$i]['prod_name']?>
         </td>   

         <td align="center">
           <?php echo $list[$i]['prod_serial']?>
         </td>   
         
        <td align="center">
           <?php echo $list[$i]['mName']?>
        </td>
        <td align="center">
           <?php echo $list[$i]['mSerial']?>
         </td>

        <td align="center">
           <?php echo $list[$i]['location_details']?>
         </td>   
		 
		 <td align="center">
           <?php echo $list[$i]['prod_ip']?>
         </td>  		 
		 <td align="center">
           <?php echo $list[$i]['prod_deck_id']?>
         </td>  
		 <td align="center">
           <?php echo $list[$i]['prod_rcv_date']?>
         </td>  
		 
		 <?php }?>
		</tr>
		
	    </table>
  