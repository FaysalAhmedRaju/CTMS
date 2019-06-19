<script>
    function validate()
      {
          if (confirm("Are you sure! Delete this record?") == true) {
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
		 
	
	<div class="img" align="center">         
		   
   	<table  cellspacing="1" cellpadding="1" align="center"  id="mytbl" style="overflow-y:scroll" width="600px" >
	<tr><td align="center"><h2><span><font color="green"  size="4" style="font-weight: bold"><nobr><?php echo $tableTitle; ?></nobr></font></span> </h2></td></tr>
            <form action="<?php echo site_url('report/location_details_list');?>" method="POST">	
             <tr>
		<td align="center" >
		<label for=""><nobr><b>Location Name:</b></nobr><em>&nbsp;</em></label></td>

                <td>
                    <select  id="location" name="location"  value="" onchange="showInfo(this.value)" >
                            <option value="">--Select--</option>
                            <?php if($editFlag==1){?> 
                            <option value="" >--Select--</option>
                           <?php } else ?> 
                            <?php
                            for($i=0; $i<count($location_list); $i++){ ?>
                                <option value="<?php echo $location_list[$i]['id']; ?>"><?php echo $location_list[$i]['location_name']; ?></option>
                           <?php } ?>
                    </select>
                  </td>  
                <td  align="left">
                    <input type="submit" value="View" name="search" class="login_button">
	   
		</td>
                </form>
                </tr>
        
                 <tr><td>&nbsp;</td></tr>
                <tr class="gridDark" style="height:35px;" >
		<font size="15">
			<th>SL</th>
			<th><nobr>Location Name<nobr></th>
                        <th><nobr>Location Details<nobr></th>        
			<th><nobr>Edit</nobr></th>
			<th><nobr>Delete</nobr></th>

			</font>
		</tr>
		
	  <?php
     //  loc_id, location_name, owner_id, full_name, type_id, short_name, prod_user_id, 
	//   company_name, prod_serial, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by
        for($i=0;$i<count($loc_list);$i++) { 				
		?>
	      <tr class="gridLight">
            <td align="center">
           <?php echo $i+1;?>
          </td>
         
        <td align="center"><nobr>
           <?php echo $loc_list[$i]['location_name']?></nobr>
         </td>   
         <td align="center">
           <?php echo $loc_list[$i]['location_details']?>
         </td>   
        <td align="center">
			<form action="<?php echo site_url('report/location_details_list_edit');?>" method="POST">
				<input type="hidden" id="location_dtl_id" name="location_dtl_id" value="<?php echo $loc_list[$i]['loc_dtl_id'];?>">							
				<input type="submit" value="Edit"  class="login_button" style="width:100%;">							
			</form> 
        </td> 
	
	<td align="center"> 
			<form action="<?php echo site_url('report/location_details_list');?>" method="POST" onsubmit="return validate();">						
				<input type="hidden" id="lid" name="lid" value="<?php echo $loc_list[$i]['loc_dtl_id'];?>">							
				<input type="submit" value="Del." name="delete" class="login_button" style="width:80%;">			 						
			</form> 
        </td> 
		
		 <?php } ?>
		</tr>
		
	    </table>


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