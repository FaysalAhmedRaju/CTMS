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
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2 align="left"><span><?php echo $title; ?></span> </h2>
		  

          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>	  
		 
	
	<div class="img">         
		   
   	<table cellspacing="1" cellpadding="1" align="center"  id="mytbl" style="overflow-y:scroll" >
	<tr><td colspan="12" align="center"><h2><span><font color="green"  size="4" style="font-weight: bold"><nobr><?php echo $tableTitle; ?></nobr></font></span> </h2></td></tr>
		<tr class="gridDark" style="height:35px;" >
		
		
		<font size="15">
			<th>SL</th>
                        <th><nobr>Product Name</nobr></th>        
			<th><nobr>Category</nobr></th>
			<th><nobr>From</nobr></th>
			<th><nobr>Owner/User</nobr></th>
			<th><nobr>Received Date</nobr></th>
                        <th><nobr>Comments</nobr></th>
                        <th><nobr>Received By</nobr></th>	
			<th><nobr>Edit</nobr></th>
			<th><nobr>Delete</nobr></th>

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
         
        <td align="center"> <nobr>
           <?php echo $list[$i]['prod_name']?> </nobr>
         </td>   
         <td align="center">
           <?php echo $list[$i]['rcv_category']?>
         </td>   

         <td align="center">
           <?php echo $list[$i]['rcv_from']?>
         </td>   

        <td align="center"><nobr>
           <?php echo $list[$i]['owner_user']?> </nobr>
         </td>   
		 
		 <td align="center">
           <?php echo $list[$i]['rcv_date']?>
         </td>  		 
		 <td align="center">
           <?php echo $list[$i]['comments']?>
         </td>  
		 <td align="center">
           <?php echo $list[$i]['rcv_by']?>
         </td>  
		 
		<td align="center">
			<form action="<?php echo site_url('report/networkProductReceivedEdit');?>" method="POST">
				<input type="hidden" id="recvID" name="recvID" value="<?php echo $list[$i]['id'];?>">							
				<input type="submit" value="Edit"  class="login_button" style="width:100%;">							
			</form> 
                </td> 
	
		<td align="center"> 
			<form action="<?php echo site_url('report/networkProductReceiveList');?>" method="POST" onsubmit="return validate();">						
				<input type="hidden" id="pid" name="pid" value="<?php echo $list[$i]['id'];?>">							
				<input type="submit" value="Del." name="delete" class="login_button" style="width:80%;">			 						
			</form> 
        </td> 
		
		 <?php } ?>
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