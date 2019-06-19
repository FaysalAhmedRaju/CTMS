<script>
	function showValue(typeid)
	{
            //alert(typeid);
             if (window.XMLHttpRequest) 
            {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
            } 
            else 
            {  
		// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
		//alert(rotNo);
            xmlhttp.onreadystatechange=stateChangegeProduct;
            xmlhttp.open("GET","<?php echo site_url('ajaxController/getNetworkProduct')?>?typeid="+typeid,false);	
       	
            xmlhttp.send(); 
         }
       
       	function stateChangegeProduct()
	{
          //  alert(xmlhttp.responseText);
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			var prod_name=document.getElementById("prod_name");
			removeOptions(prod_name);
			//alert(xmlhttp.responseText);
			var val = xmlhttp.responseText;
			var jsonData = JSON.parse(val);
			//alert(xmlhttp.responseText);
			for (var i = 0; i < jsonData.length; i++) 
			{
                            var option = document.createElement('option');
                            option.value = jsonData[i].id;  //value of option in backend
                            option.text = jsonData[i].prod_name;	  //text of option in frontend
                            prod_name.appendChild(option);
			}
		}
	}
        
       function removeOptions(product)
	{
            var i;
            for(i=product.options.length-1;i>=1;i--)
            {
		product.remove(i);
            }
	}
	
        
       function showUsr(usr)
       {       
            
            if(usr=="owner")
            { 
                 document.getElementById("ownerTr").style.display = "table-row";
                 document.getElementById("userTr").style.display = "none";
                 document.getElementById("blankTr3").style.display = "table-row";
            }	
            else if(usr=="user")
            {
                document.getElementById("ownerTr").style.display = "none";
                document.getElementById("userTr").style.display = "table-row";
                document.getElementById("blankTr3").style.display = "table-row";
            }
            else
            {
                 document.getElementById("ownerTr").style.display = "none";
                 document.getElementById("userTr").style.display = "none";
                 document.getElementById("blankTr3").style.display = "table-row";

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
		<form name= "myForm" onsubmit="return validate();" action="<?php echo site_url("report/networkProductReceivePerform");?>" method="post">
		<table align="center"> 
							<tr>
                                 <td align="right" colspan="3"><?php echo $msg; ?> </td>

                           </tr>
                            <tr>
                                <th align="left"><nobr>Product Type.</nobr></th> 
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <th>
                                        <select  id="product_type" name="product_type" style="width:215px;"  onchange="showValue(this.value)" >
						<option value="">--Select--</option>
                                                 <?php if($editFlag==1){?> 
                                                <option value="<?php echo $product_details[0]['id']; ?>" selected="true"><?php echo $product_details[0]['short_name']; ?></option>
                                               <?php }  ?> 
                                                
						<?php
						for($i=0; $i<count($product_list); $i++){ ?>
                                                  <option value="<?php echo $product_list[$i]['id']; ?>"><?php echo $product_list[$i]['short_name']; ?></option>
                                               <?php } ?>
					</select>
                                </th>  
				
                            </tr>
                            <tr><td colspan="3">&nbsp;</td></tr>
                            <tr>
                                <th align="left"><nobr>Product Name - Serial</nobr></th>
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <th><select id="prod_name" name="prod_name"  style="width:215px;">
					<option value="">---Select Product---</option>
                                        <?php if($editFlag==1){?> 
                                        <option value="<?php echo $product_details[0]['product_id']; ?>" selected="true"><?php echo $product_details[0]['prod_name']; ?></option>
                                         <?php }?>
	
                                    </select></th>
				
                            </tr>  
                            <tr><td colspan="3">&nbsp;</td></tr>
                            <tr>
                                <th align="left"><nobr>Receive Category</nobr></th>
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <th>
                                        <select  id="recv_category" name="recv_category" style="width:215px;"  value="">
						<option value="">--Select--</option>
                                      <?php if($editFlag==1){?> 
                                                <option value="<?php echo $product_details[0]['rcv_category']; ?>" selected="true"><?php echo $product_details[0]['rcv_category']; ?></option>
                                      <?php }?>
                                                 <option value="New">New</option>
                                                 <option value="Repaired">Repaired</option>
                                                 <option value="Damaged">Damaged</option>

					</select>
                                </th>
				
                            </tr> 
                            <tr><td colspan="3">&nbsp;</td></tr>
                            <tr>
                                <th align="left"><nobr>Received From.</nobr></th>
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <th>
                                        <select  id="rcv_from" name="rcv_from" style="width:215px;" onchange="showUsr(this.value)">
						<option value="">--Select--</option>
                                    <?php if($editFlag==1){?> 
                                                <option value="<?php echo $product_details[0]['rcv_from']; ?>" selected="true"><?php echo $product_details[0]['rcv_from']; ?></option>
                                      <?php }?>        
                                                 <option value="owner">Owner</option>
                                                 <option value="user">User</option>
					</select>
                                </th>               
                            </tr>
                            <tr><td colspan="3">&nbsp;</td></tr>

                            <tr id="ownerTr"  <?php if ($product_details[0]['rcv_from']!='owner') { ?>  style="display: none" <?php } ?>>
                                <th align="left"><nobr>Product Owner </nobr></th>
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <th>
                                    <select  id="ownar_id" name="ownar_id" style="width:215px;" value="" >
						<option value="">--Select--</option>
                                                
                                                 <?php if($editFlag==1 && $product_details[0]['rcv_from']=='owner' ){?> 
                                                <option value="<?php echo $product_details[0]['rcv_frm_owner_user']; ?>" selected="true"><?php echo $product_details[0]['owner_user']; ?></option>
                                               <?php } ?> 
                                                
						<?php
						for($i=0; $i<count($owner_list); $i++){ ?>
                                                    <option value="<?php echo $owner_list[$i]['id']; ?>"><?php echo $owner_list[$i]['full_name']; ?></option>
                                               <?php } ?>
					</select>	
                                </th>
				
                            </tr>

                            <tr  id="blankTr2" style="display: none"><td colspan="3">&nbsp;</td></tr>
                              
                            <tr id="userTr"   <?php if ($product_details[0]['rcv_from']!='user') { ?>  style="display: none" <?php } ?> >
                                <th align="left"><nobr>Product User </nobr></td>
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></td>
				<td>
                                    <select  id="usr_id" name="usr_id" style="width:215px;" value="" >
						<option value="">--Select--</option>
                                                
                                             <?php if($editFlag==1 && $product_details[0]['rcv_from']=='user' ){?> 
                                                <option value="<?php echo $product_details[0]['rcv_frm_owner_user']; ?>" selected="true"><?php echo $product_details[0]['owner_user']; ?></option>
                                               <?php } ?> 
                                                
						<?php
						for($i=0; $i<count($usr_list); $i++){ ?>
                                                    <option value="<?php echo $usr_list[$i]['id']; ?>"><?php echo $usr_list[$i]['company_name']; ?></option>
                                               <?php } ?>
					</select>	
                                </td>
				
                            </tr>
   
                            <tr id="blankTr3"  <?php if ($product_details[0]['rcv_from']!='owner' ) { ?>  style="display: none" <?php } ?>><td colspan="3">&nbsp;</td></tr>  
                             <tr>
                                 <th align="left"><nobr>Comments</nobr></th>
                                 <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                		 <th><textarea id="rcv_comment" name="rcv_comment" tyle="width:300px; height: 50px" rows="4" ><?php if($editFlag==1) { echo $product_details[0]['comments']; }  ?> </textarea>

                                 <!--<th><input class="read" type="text" style="width:200px; height: 50px"  id="rcv_comment" name="rcv_comment"  <?php if($editFlag==1){ ?> value="<?php echo $product_details[0]['comments'] ?>" <?php } ?>  ></nobr></th>-->	 				
				
                             </tr> 
                            
                             <tr ><td colspan="3">&nbsp;</td></tr> 
                            <tr>
                                <th align="left"><nobr>Received Date.</nobr></th>
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <th><input class="read" type="text" style="width:200px;"  id="rcv_date" name="rcv_date"  <?php if($editFlag==1){ ?> value="<?php echo $product_details[0]['rcv_date'] ?>" <?php } ?> ></nobr></th>
                                                <script>
                                                    $( function() {
                                                    $( "#rcv_date" ).datepicker({
                                                    changeMonth: true,
                                                    changeYear: true,
                                                    dateFormat: 'yy-mm-dd', // iso format
                                                    });
                                                    });
						</script>
				
                            </tr>
                             <tr ><td colspan="3">&nbsp;</td></tr>       
                            <tr>
                                <th align="left"><nobr>Received By</nobr></th>
                               <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                               <th><input class="read" type="text" style="width:200px;"  id="rcv_by" name="rcv_by"  value="<?php echo $login_id;?>" readonly="true"></nobr></th>	 				
				
                            </tr>
                            <tr><td colspan="3">&nbsp;</td></tr>
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