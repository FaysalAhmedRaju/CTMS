<script>
   function showModel(type)
          {
                document.getElementById("brand").value = "";
                document.getElementById("model").value = "";
                var eleVal = document.getElementById("monitor").innerHTML;
                var res = eleVal.split(type+'"');
                //alert(eleVal);
                var firsEle = res[1];
                //alert(res[1]);
                var strSplit = firsEle.split("-");
                document.getElementById("brand").value=strSplit[1]; //">Monitor
                var secondEle = strSplit[2].split("<");
                //alert(strSplit[2]);
                var secondElement=secondEle[0].split('">Monitor');
               // alert(secondElement);
                document.getElementById("model").value=secondElement[0].split(',');

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
		<form name= "myForm" onsubmit="return validate();" action="<?php echo site_url("report/addWorkStationItemPerform");?>" method="post">
		<table align="center"> 
                    <tr><td colspan="3" align="center"><a href="<?php echo site_url('report/workstationList') ?>">BACK TO WORKSTATION LIST</a></td></tr>
                     <tr><td colspan="3">&nbsp;</td></tr>      
                    <tr>
                               <th align="left"><nobr>Product Name</nobr></th>
                                 <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                <th><input class="read" type="text" id="prod_name" name="prod_name" style="width:215px;" value="<?php echo $product_name ?>"></th> 
				
                            </tr>
                            <tr><td colspan="3">&nbsp;</td></tr>
                             <tr>
                                <th align="left"><nobr>Product Serial</nobr></th>
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <th><input class="read" type="text" id="prod_serial" name="prod_serial" style="width:215px;" value="<?php echo $product_serial;?>"></th> 
				
                            </tr>
                            <tr><td colspan="3">&nbsp;</td></tr>
                             <tr>
                               <th align="left"><nobr>Product Model</nobr></th>
                                 <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                		 <th><input class="read" type="text" id="prod_model" name="prod_model" style="width:215px;" value="<?php echo $product_model;?>"></th> 
				
                            </tr>
                            <tr><td colspan="3">&nbsp;</td></tr>
                            <tr>
                                <th align="left"><nobr>Monitor</nobr></th>
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <th><select id="monitor" name="monitor"  style="width:215px;" onchange="showModel(this.value)">
					<option value="">---Select Monitor---</option>
                                       <?php for($i=0; $i<count($monitor_list); $i++) { ?> 
                                        <option value="<?php echo $monitor_list[$i]['id'];?>" label="<?php echo $monitor_list[$i]['short_name'];?>"><?php echo $monitor_list[$i]['short_name'];?></option>
                                         <?php }?>
	
                                    </select></th>
				
                            </tr>  
                           
        
<!--   
                            <tr><td colspan="3">&nbsp;</td></tr>  
                            <tr>
                                 <th align="left"><nobr>Brand</nobr></th>
                                 <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                		 <th><input class="read" type="text" id="brand" name="brand" style="width:215px;"></th>

                                 <th><input class="read" type="text" style="width:200px; height: 50px"  id="rcv_comment" name="rcv_comment"  <?php if($editFlag==1){ ?> value="<?php echo $product_details[0]['comments'] ?>" <?php } ?>  ></nobr></th>	 				
				
                            </tr> 
                            <tr><td colspan="3">&nbsp;</td></tr>-->
<!--                            <tr><td colspan="3">&nbsp;</td></tr> 
                            <tr>
                                 <th align="left"><nobr>Model</nobr></th>
                                 <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                		 <th><input class="read" type="text" id="model" name="model" style="width:215px;"></th>
                            </tr> 
                         
                             <tr><td colspan="3">&nbsp;</td></tr>       -->
<!--                            <tr>
                                 <th align="left"><nobr>Model</nobr></th>
                                 <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                		 <th><input class="read" type="text" id="model" name="model" style="width:215px;"></th>	 				
				
                            </tr>-->
                            <!--<tr><td colspan="3">&nbsp;</td></tr>-->
                            <input type="hidden" name="product_info_id" id="product_info_id"  value="<?php echo $product_info_id; ?>">
                            <tr>
                                 <td align="right" colspan="3">
                                     <?php if($editFlag==1){?>
                                     <input class="login_button"  name="update" type="submit"  value="UPDATE" > 
                                     <?php } else{?>
                                      <input class="login_button"  name="save" type="submit"  value="SAVE" > 
                                     <?php } ?> 
                                 </td>

                           </tr>
                            <tr>
                                 <td align="right" colspan="3"><?php echo $msg; ?> </td>

                           </tr>
                           <tr>
                               <td align="right" colspan="3"><input class="read" type="hidden"  id="rcvid" name="rcvid"  <?php if($editFlag==1){?> value="<?php echo $product_details[0]['rcv_id']; }?>"</td>

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