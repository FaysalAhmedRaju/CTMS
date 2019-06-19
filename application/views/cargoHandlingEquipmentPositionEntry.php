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
		<form name= "myForm"  action="<?php echo site_url("report/cargoHandlingEquipmentPositionPerform");?>" method="post">
		<table align="center"> 
                           
                             <tr>
                                <th align="left"><nobr>Equipment Type</nobr></th> 
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <th>
									<select  id="equip_type" name="equip_type" style="width:180px;"  onchange="showValue(this.value)" >
											<option value="">--Select--</option>
                                                 <?php if($editFlag==1){?> 
                                                <option value="<?php echo $select_result[0]['equip_type']; ?>" selected="true"><?php echo $select_result[0]['equip_type']; ?></option>
                                               <?php }  ?> 
                                                
												<option value="Crane 50 Ton">Crane 50 Ton</option>
												<option value="Crane 30 Ton">Crane 30 Ton</option>
                                                <option value="Crane 20 Ton">Crane 20 Ton</option>
                                                <option value="Crane 10 Ton">Crane 10 Ton</option>
                                                <option value="FLT 20 Ton">FLT 20 Ton</option>
                                                <option value="FLT 10 Ton">FLT 10 Ton</option>
                                                <option value="FLT 05 Ton">FLT 05 Ton</option>
                                                <option value="FLT 03 Ton">FLT 03 Ton</option>
                                                <option value="FLT 1.5 Ton">FLT 1.5 Ton</option>
                                                <option value="RRC 05 Ton">RRC 05 Ton</option>
                                                <option value="Tractor 25 Ton">Tractor 25 Ton</option>
                                                <option value="Heavy Trailer 25 Ton">Heavy Trailer 25 Ton</option>
                                                <option value="Light Trailer 06 Ton">Light Trailer 06 Ton</option>
                                                <option value="Car Carrier">Car Carrier</option>
                                                <option value="Tele Handler 04 Ton">Tele Handler 04 Ton</option>
      
										</select>
                                </th>  
				
                            </tr>
							 <tr>
                                <th align="left"><nobr>Office</nobr></th> 
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <th>
                                        <select  id="office" name="office" style="width:180px;"  onchange="showValue(this.value)" >
											<option value="">--Select--</option>
                                                 <?php if($editFlag==1){?> 
                                                <option value="<?php echo $select_result[0]['office']; ?>" selected="true"><?php echo $select_result[0]['office']; ?></option>
                                               <?php }  ?> 
                                                
												<option value="TM">TM(CCT/NCT+GCB)</option>
                                                <option value="DTM">DTM(Heavy Lift)</option>												
										</select>
                                </th>  
				
                            </tr>
                            
                            <!--tr>
                                <th align="left"><nobr>Total Equipment</nobr></th>
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <th><input class="read" type="number" min="0" style="width:100px;"  id="total_equip" name="total_equip"   <?php if($editFlag==1){?> value="<?php echo $select_result[0]['total_equip']; ?>" <?php }?> ></th>
				
                            </tr--> 
							<tr>
                                <th align="left"><nobr>Demand</nobr></th>
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <th><input class="read" type="number" min="0" style="width:100px;"  id="demand" name="demand"  value=0  <?php if($editFlag==1){?> value="<?php echo $select_result[0]['demand']; ?>" <?php }?> ></th>
				
                            </tr>  
							<tr>
                                <th align="left"><nobr>Supply</nobr></th>
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <th><input class="read" type="number" min="0" style="width:100px;"  id="supply" name="supply" value=0  <?php if($editFlag==1){?> value="<?php echo $select_result[0]['supply']; ?>" <?php }?> ></th>
				
                            </tr>  
							<tr>
                                <th align="left"><nobr>Stand By</nobr></th>
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <th><input class="read" type="number" min="0"  style="width:100px;"  id="stand_by" name="stand_by" value=0  <?php if($editFlag==1){?> value="<?php echo $select_result[0]['stand_by']; ?>" <?php }?> ></th>
				
                            </tr> 
							<tr>
                                <th align="left"><nobr>Out of Order</nobr></th>
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <th><input class="read" type="number" min="0" style="width:100px;"  id="out_of_order" name="out_of_order" value=0 <?php if($editFlag==1){?> value="<?php echo $select_result[0]['out_of_order']; ?>" <?php }?> ></th>
				
                            </tr> 
                            
                           <input type="hidden" id="equipID" name="equipID" <?php if($editFlag==1){?> value="<?php echo $select_result[0]['id']; }?>">							
                            <tr><td colspan="3">&nbsp;</td></tr> 
                            <tr>
                                 <td align="right" colspan="3">
                                      <input class="login_button"  name="save" type="submit"  value="SAVE" >  
                                 </td>
								<!--td colspan="2" align="left" style="padding-left:15px;">
									<a href="<?php echo site_url('report/cargoHandlingEquipmentPositionView') ?>"  class="login_button" name="View" style="padding:4px;" target="_blank"><font size="2" color="#424242">View</font></a>
								</td-->

                           </tr>
							<tr>
                                 <td align="right" colspan="3"><?php echo $msg; ?> </td>

                           </tr>
                          
				
         </table>
 </form>
         <table cellspacing="1" cellpadding="1" align="center"  id="mytbl" style="overflow-y:scroll" width="600px">
            <tr><td colspan="12" align="center"> <h2><span><font color="green"  size="4" style="font-weight: bold"><nobr><?php echo $tableTitle; ?></nobr></font></span></h2></td></tr>
		<tr class="gridDark" style="height:35px;">
		<font size="15">
			<th>SL</th>
			<th><nobr>Type of Equipment <nobr></th>
			<th><nobr>Office<nobr></th>
			<!--th><nobr>Total Equipment<nobr></th-->
			<th><nobr>Demand<nobr></th>        
            <th><nobr>Supply<nobr></th>        
            <th><nobr>Stand By<nobr></th>        
			<th><nobr>Out of Order<nobr></th>
			<!--th><nobr>Date</nobr></th-->
			<th><nobr>Edit</nobr></th>
			<th><nobr>Delete</nobr></th>

		</font>
		</tr>
	  <?php
     //  loc_id, location_name, owner_id, full_name, type_id, short_name, prod_user_id, 
	//   company_name, prod_serial, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by
        for($i=0;$i<count($result);$i++) { 				
		?>
	      <tr class="gridLight">
		  <td>
           <?php echo $i+1;?>
          </td>
         
        <td align="center"><nobr>
           <?php echo $result[$i]['equip_type']?></nobr>
         </td> 
		 <td align="center">
           <?php echo $result[$i]['office']?>
         </td>   
         <!--td align="center">
           <?php echo $result[$i]['total_equip']?>
         </td-->   

         <td align="center">
           <?php echo $result[$i]['demand']?>
         </td>   
		 <td align="center">
           <?php echo $result[$i]['supply']?>
         </td> 
		 <td align="center">
           <?php echo $result[$i]['stand_by']?>
         </td>  
		 <td align="center">
           <?php echo $result[$i]['out_of_order']?>
         </td> 
		<!--td align="center"><nobr>
           <?php echo $result[$i]['update_time']?> </nobr>
         </td--> 

		<td align="center">
		<form action="<?php echo site_url('report/cargoHandlingEquipmentPositionEdit');?>" method="POST">
			<input type="hidden" id="eqiID" name="eqiID" value="<?php echo $result[$i]['id'];?>">							
			<input type="submit" value="Edit"  class="login_button" style="width:100%;">							
		</form> 
        </td> 
	
	<td align="center"> 
		<form action="<?php echo site_url('report/cargoHandlingEquipmentPositionEntry');?>" method="POST" onsubmit="return validate();">						
			<input type="hidden" id="eid" name="eid" value="<?php echo $result[$i]['id'];?>">							
			<input type="submit" value="Del." name="delete" class="login_button" style="width:100%;">			 						
		</form> 
        </td> 
		
		 <?php }?>
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