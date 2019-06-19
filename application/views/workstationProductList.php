<script>
    function validate()
      {
        if (confirm("Are you sure!! Delete this record?") == true) {
		   return true ;
	} else {
		 return false;
            }		 
      }
      
 </script>
<div class="content">
    <div class="content_resize_1">
      <div class="mainbar_1">
        <div class="article">
          <h2 align="left"><span><?php echo $title; ?></span> </h2>
		  

          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>	  
		 
	
	<div class="img">         
		   
   	<table cellspacing="1" cellpadding="1" align="center"  id="mytbl" style="overflow-y:scroll" >
            <form action="<?php echo site_url('report/workstationList');?>" method="POST" >
             <tr><td colspan="12" align="center">  <span><font color="green"  size="4" style="font-weight: bold"><nobr><?php echo $tableTitle; ?></nobr></font></span> </td></tr>
		

								 
                <tr>
		<td align="center" >
		<label for=""><nobr><b>Search By :</b></nobr><em>&nbsp;</em></label></td>

                <td>
                    <select name="search_by" id="search_by">
                        <option value="serial" label="Serial No" selected style="width:110px;">Serial No</option>
                        <option value="ip_addr" label="IP Address">IP Address</option>
                     </select>
		</td>

		<td><b><nobr>Search Value:</nobr></b></td>
		<td>
                    <input type="text" style="width:170px" id="searchInput" name="searchInput" autofocus />
		</td>

		<td  align="center" width="70px">
                    <input type="submit" value="View" name="View" class="login_button">
		</td>
		</tr>
            </form>
        </table>
        <table>
        <tr class="gridDark" style="height:35px;" >
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
			<th rowspan="2"><nobr>Add</nobr></th>
			<!--<th><nobr>Delete</nobr></th>-->

			</font>
		</tr>                
                <tr class="gridDark" style="height:35px;" >
		
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
	      <tr class="gridLight">
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
		 
		<td align="center">
			<form action="<?php echo site_url('report/addWorkStationItem');?>" method="POST">
				<input type="hidden" id="product_info_id" name="product_info_id" value="<?php echo $list[$i]['id'];?>">	
                                <input type="hidden" id="product_name" name="product_name" value="<?php echo $list[$i]['prod_name'];?>">	
				<input type="hidden" id="product_serial" name="product_serial" value="<?php echo $list[$i]['prod_serial'];?>">							
				<input type="hidden" id="product_model" name="product_model" value="<?php echo $list[$i]['prod_deck_id'];?>">							
				<input type="submit" value="Assign Monitor"  class="login_button" style="width:100%;">							
			</form> 
        </td> 
	
<!--		<td align="center"> 
			<form action="<?php echo site_url('report/networkProductEntryList');?>" method="POST" onsubmit="return validate();">						
				<input type="hidden" id="pid" name="pid" value="<?php echo $list[$i]['id'];?>">							
				<input type="submit" value="Del." name="delete" class="login_button" style="width:80%;">			 						
			</form> 
        </td> 
		-->
		 <?php }?>
		</tr>
		
	    </table>
    </form>

	</div>
			
          <div class="clr"></div>
        </div>

      </div>
      <div class="sidebar" style="width:140px; padding: 0px 0 12px;">
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	<?php echo form_close()?>
  </div>