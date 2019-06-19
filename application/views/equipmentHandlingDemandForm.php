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

</script>
 <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <span><?php echo $msg; ?></span>
		  <div class="clr"></div>
		  		 
		<div class="img">
			<table width="100%"  align="center">
			<form action="<?php echo site_url('uploadExcel/equipmentHandlingDemandFormPerform');?>" method="POST">	
				<tr>
					<th align="center"><nobr>Yard</nobr></th>
					<th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
					<th>
                                            <select  id="yard" name="yard" style="width:180px;" >
                                               <?php if($editFlag==1){?> 
                                                <option value="<?php echo $select_result[0]['yard']; ?>" selected="true"><?php echo $select_result[0]['yard']; ?></option>
                                               <?php }  ?> 
                                                 <option value="">--Select--</option>
                                                 <option value="JR">JR</option>
                                                 <option value="AB">AB</option>
                                                 <option value="DREFFER">DREFFER</option>
                                                 <option value="Y7">Y7</option>
                                                 <option value="SCY">SCY</option>
                                                 <option value="Y1,Y2,YMN">Y1,Y2,YMN</option>
                                                 <option value="Y3">Y3</option>
                                                 <option value="Y5">Y5</option>
                                                 <option value="Y6,Y6X">Y6</option>
                                                 <option value="Y8B">Y8B</option>
                                                 <option value="BAPX1,BAPX2,Y8">BAPX1,BAPX2,Y8</option>
                                                 <option value="Y9,Y10">Y9,Y10</option>
                                                 <option value="Y11">Y11</option>
                                                 <option value="NCY">NCY</option>                                                                         
                                                 <option value="CCT">CCT</option>                                                                         
                                                 <option value="NCT">NCT</option>                                                                         
                                                 <option value="ICD">ICD</option>                                                                         
                                                 <option value="NOFCY">NOFCY</option>                                                                         

                                            </select>
					</th>
				
                                </tr>
                                <tr><td>&nbsp;</td></tr>
                                <tr>
					<th align="center"><nobr>Equipment Type</nobr></th>
					<th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
					<th>
                                             <select  id="equipment" name="equipment" style="width:180px;"  onchange="showValue(this.value)" >
                                                  <?php if($editFlag==1){?> 
                                                <option value="<?php echo $select_result[0]['equip_type']; ?>" selected="true"><?php echo $select_result[0]['equip_type']; ?></option>
                                               <?php }  ?> 
										<option value="">--Select--</option>                                                
												<option value="QGC">QGC</option>
												<option value="RTG">RTG</option>
												<option value="MHC">MHC</option>
												<option value="RMG">RMG</option>
												<option value="SC">SC</option>
                                                <option value="RST 45 Ton(L)">RST 45 Ton(L)</option>
                                                <option value="FLT 42 Ton">FLT 42 Ton</option>
                                                <option value="FLT 16 Ton">FLT 16 Ton</option>
                                                <option value="RST 7 Ton">RST 7 Ton</option>
                                                <option value="FLT 10 Ton">FLT 10 Ton</option>
                                                <option value="CM">CM</option>
					</select>
					</th>
				
                                </tr>
                                <tr><td>&nbsp;</td></tr>
                                <tr>
                                        <th align="center"><nobr>Demand</nobr></th>
                                        <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                 <th><input class="read" type="number" style="width:180px;"  id="demand" name="demand" <?php if($editFlag==1){?> value="<?php echo $select_result[0]['equip_demand']; ?>" <?php }?>  ></th>
				
                               </tr>
                                <tr><td>&nbsp;</td></tr>
                                <tr>
                                    <input class="read" type="hidden"  id="eqiID" name="eqiID" <?php if($editFlag==1){?> value="<?php echo $select_result[0]['id']; ?>" <?php }?>>
                                 <td align="center" colspan="3">
                                     <?php if($editFlag==1){?>
                                     <input class="login_button"  name="update" type="submit"  value="UPDATE" > 
                                     <?php } else{ ?>
                                      <input class="login_button"  name="save" type="submit"  value="SAVE" > 
                                     <?php } ?> 
                                 </td>

                                </tr>
                                
			</form>
				</table>
                             <table cellspacing="1" cellpadding="1" align="center"  id="mytbl" style="overflow-y:scroll" width="600px">
                                <tr><td colspan="12" align="center">  <h2><span><font color="green"  size="4" style="font-weight: bold"><nobr><?php echo $tableTitle; ?></nobr></font></span> </h2></td></tr>
                                    <tr class="gridDark" style="height:35px;">


                                        <font size="15">
                                            <th>SL</th>
                                            <th><nobr>Yard <nobr></th>
                                            <th><nobr>Equipment<nobr></th>        
                                            <th><nobr>Demand<nobr></th>
                                            <!--<th><nobr>Location Details</nobr></th>-->
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

                            <td align="center">
                               <?php echo $result[$i]['yard']?>
                             </td>   
                             <td align="center">
                               <?php echo $result[$i]['equip_type']?>
                             </td>   

                             <td align="center">
                               <?php echo $result[$i]['equip_demand']?>
                             </td>   

                            <td align="center">
                                    <form action="<?php echo site_url('uploadExcel/equipmentHandlingDemandFormEdit');?>" method="POST">
                                            <input type="hidden" id="eqiID" name="eqiID" value="<?php echo $result[$i]['id'];?>">							
                                            <input type="submit" value="Edit"  class="login_button" style="width:100%;">							
                                    </form> 
                            </td> 

                            <td align="center"> 
                                    <form action="<?php echo site_url('uploadExcel/equipmentHandlingDemandForm');?>" method="POST" onsubmit="return validate();">						
                                            <input type="hidden" id="eid" name="eid" value="<?php echo $result[$i]['id'];?>">							
                                            <input type="submit" value="Del." name="delete" class="login_button" style="width:100%;">			 						
                                    </form> 
                            </td> 

                                     <?php }?>
                                    </tr>

                            </table>

                    <br/>

		 </div>
          <div class="clr"></div>
        </div>
      </div>
      <div class="sidebar">
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
  </div>
 