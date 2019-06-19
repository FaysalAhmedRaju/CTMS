<script>
	function showInfo(locid)
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
            xmlhttp.onreadystatechange=stateChangeLocation;
            xmlhttp.open("GET","<?php echo site_url('ajaxController/getLocationInfo')?>?locid="+locid,false);	
       	
            xmlhttp.send(); 
         }
       
       	function stateChangeLocation()
	{
          //  alert(xmlhttp.responseText);
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			var loc_dtl=document.getElementById("loc_dtl");
			removeOptions(loc_dtl);
//			//alert(xmlhttp.responseText);
			var val = xmlhttp.responseText;
			var jsonData = JSON.parse(val);
                       // alert(jsonData[0].location_details);
                       for (var i = 0; i < jsonData.length; i++) 
			{
                            var option = document.createElement('option');
                            option.value = jsonData[i].id;  //value of option in backend
                            option.text = jsonData[i].location_details;	  //text of option in frontend
                            loc_dtl.appendChild(option);
			}
//                        if(jsonData[0].cdtl==1)
//                        {
//                          //  alert(1);
//                            document.getElementById('loc_dts_tr').style.display="table-row";
//                            document.getElementById('loc_dtl').innerHTML=jsonData[0].location_details;  
//                            document.getElementById('blankTr4').style.display="table-row";
//
//                        }
//                         else
//                        {
//                           // alert(2); blankTr4
//                            document.getElementById('loc_dts_tr').style.display="none";
//                            document.getElementById('loc_dtl').innerHTML=null;
//                            document.getElementById('blankTr4').style.display="none";
//                        }
			//alert(xmlhttp.responseText);
//			for (var i = 0; i < jsonData.length; i++) 
//			{
//                            var option = document.createElement('option');
//                            option.value = jsonData[i].id;  //value of option in backend
//                            option.text = jsonData[i].prod_name;	  //text of option in frontend
//                            prod_name.appendChild(option);
//			}
		}
	}
    
       function removeOptions(loc_dtl)
	{
            var i;
            for(i=loc_dtl.options.length-1;i>=0;i--)
            {
		loc_dtl.remove(i);
            }
	}
        
    
   function showModel(type)
   {
	   document.getElementById("prod_name").value="";
	   document.getElementById("dec_id").value="";
      // alert(type);
        if(type== 11 || type==9)
        { 
            document.getElementById("dec").style.display = "table-cell";
            document.getElementById("mdl").style.display = "none";

        }	
		  else if(type== 13 || type==14 || type==15 || type==16 || type==18 || type==19 || type==22)
        {
                var eleVal = document.getElementById("product_type").innerHTML;
                var res = eleVal.split(type+'"');
                //alert(eleVal);
                var firsEle = res[1];
                //alert(res[1]);
                var strSplit = firsEle.split("-");
                document.getElementById("prod_name").value=strSplit[1]; //">Monitor
                var secondEle = strSplit[2].split("<");
                //alert(strSplit[2]);
                var secondElement=secondEle[0].split('">Monitor');
                //alert(secondElement);
                document.getElementById("dec_id").value=secondElement[0].split(',');

                document.getElementById("dec").style.display = "none";
                document.getElementById("mdl").style.display = "table-cell";
        }
        else 
        {
            document.getElementById("dec").style.display = "none";
            document.getElementById("mdl").style.display = "table-cell";

        }
      
   }
   
    function validate()
   {
        if( document.myForm.product_type.value == "" )
        {
            alert( "Please! Select Product Type." );
            document.myForm.product_type.focus() ;
            return false;
	    }
        else if( document.myForm.prod_name.value == "" )
        {
            alert( "Please! Provide Product Name.." );
            document.myForm.prod_name.focus() ;
            return false;
		}

        else if( document.myForm.location.value == "" )
        {
            alert( "Please! Select Location." );
            document.myForm.location.focus() ;
            return false;
		}
         else if( document.myForm.loc_dtl.value == "" )
        {
            alert( "Please! Provide Location Details." );
            document.myForm.loc_dtl.focus() ;
            return false;
		}
       
        else
            return true;
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
		<form name= "myForm" onsubmit="return validate();" action="<?php echo site_url("report/networkProductEntryPerform");?>" method="post">
           
		<table align="center" > 
                      <tr><td colspan="3" align="center"><a href="<?php echo site_url('report/networkProductEntryList') ?>">BACK TO PRODUCT LIST</a></td></tr>
                      <tr><td>&nbsp;</td></tr>
							 <tr>
                                 <td align="center" colspan="3"><?php echo $msg; ?> </td>

                           </tr>
                       <tr>
                                <th align="left"><nobr>Product Type.</nobr></th> 
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <th>
                                        <select  id="product_type" name="product_type" style="width:215px;"  value="" onchange="showModel(this.value)">
												<option value="">--Select--</option>
                                                 <?php if($editFlag==1){?> 
                                                <option value="<?php echo $product_details[0]['type_id']; ?>" label="<?php echo $product_details[0]['short_name']; ?>" selected="true"><?php echo $product_details[0]['short_name']; ?></option>
                                               <?php } else ?> 
											<?php
											for($i=0; $i<count($product_list); $i++){ ?>
																	<option value="<?php echo $product_list[$i]['id']; ?>" label="<?php echo $product_list[$i]['short_name']; ?>"><?php echo $product_list[$i]['short_name']; ?></option>
																   <?php } ?>
										</select>	 				
				
                            </tr>
                             <tr><td>&nbsp;</td></tr>
                             <tr>
                                <th align="left"><nobr>Product Name.</nobr></th>
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <th><input class="read" type="text" style="width:200px;"  id="prod_name" name="prod_name" <?php if($editFlag==1){?> value="<?php echo $product_details[0]['prod_name'] ?>" <?php } ?> ></nobr></th>
				
                            </tr> 
                             <tr><td>&nbsp;</td></tr>
                            <tr>
                                <th align="left"><nobr>Serial  no.</nobr></th>
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <th><input class="read" type="text" style="width:200px;"  id="serial_no" name="serial_no" <?php if($editFlag==1){?> value="<?php echo $product_details[0]['prod_serial'] ?>" <?php } ?> ></nobr></th>
				
                            </tr> 
							 <tr><td>&nbsp;</td></tr>
                            <tr>
                                <th align="left"><nobr>IMEI No.</nobr></th>
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <th><input class="read" type="text" style="width:200px;"  id="imei_number" name="imei_number" <?php if($editFlag==1){?> value="<?php echo $product_details[0]['imei_number'] ?>" <?php } ?> ></nobr></th>
				
                            </tr> 
                             <tr><td>&nbsp;</td></tr>
                            <tr>
                                <th align="left"><nobr>Received Date.</nobr></th>
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <th><input class="read" type="text" style="width:200px;"  id="rcv_date" name="rcv_date"  <?php if($editFlag==1){?> value="<?php echo $product_details[0]['prod_rcv_date'] ?>" <?php } ?> ></nobr></th>
                                                <script>
                                                    $( function() {
                                                    $( "#rcv_date" ).datepicker({
                                                    changeMonth: true,
                                                    changeYear: true,
                                                    dateFormat: 'yy-mm-dd', // iso format
                                                    });
                                                    } );
						</script>
				
                            </tr>
                             <tr><td>&nbsp;</td></tr>
                            <tr>
                                <th align="left"><nobr>IP Address </nobr></th>
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <th><input class="read" type="text" style="width:200px;"  id="ip_addr" name="ip_addr"  <?php if($editFlag==1){?> value="<?php echo $product_details[0]['prod_ip'] ?>" <?php } ?>  ></nobr></th>
				
                            </tr>
                             <tr><td>&nbsp;</td></tr>
                            <tr>
                                <th align="left" id="dec" style="display: none"><nobr>Dec. </nobr></th>
                                <th align="left" id="mdl"  ><nobr>Model. </nobr></th>
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <th><input class="read" type="text" style="width:200px;"  id="dec_id" name="dec_id"  <?php if($editFlag==1){?> value="<?php echo $product_details[0]['prod_deck_id'] ?>" <?php } ?>  ></nobr></th>
				
                            </tr>
                            
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <th align="left"><nobr>Location.</nobr></th>
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <th>
					<select  id="location" name="location" style="width:215px;"  value="" onchange="showInfo(this.value)" >
						<option value="">--Select--</option>
                                               <?php if($editFlag==1){?> 
                                                <option value="<?php echo $product_details[0]['loc_id']; ?>" selected="true"><?php echo $product_details[0]['location_name']; ?></option>
                                               <?php } else ?> 
                                                
                                                
						<?php
						for($i=0; $i<count($location_list); $i++){ ?>
                                                    <option value="<?php echo $location_list[$i]['id']; ?>"><?php echo $location_list[$i]['location_name']; ?></option>
                                               <?php } ?>
					</select>	 				
				</th>
                            </tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr id="loc_dts_tr" >
                                <th align="left" ><nobr>Location Details </nobr></th>
                                <th align="" ><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <!--<th><label class="read" type="text" style="width:200px;"  id="loc_dtl" name="loc_dtl"  <?php if($editFlag==1){?> value="<?php echo $product_details[0]['prod_deck_id'] ?>" <?php } ?>  ></label></th>-->
								<th>
								<!--select id="loc_dtl" name="loc_dtl"  style="width:215px;" >
									<option value="">---Select Product---</option>
                                        <?php if($editFlag==1){?> 
                                        <option value="<?php echo $product_details[0]['loc_detail_id']; ?>" selected="true"><?php echo $product_details[0]['location_details']; ?></option>
                                         <?php }?>
	
                                </select-->
								<input class="read" type="text" style="width:200px;"  id="loc_dtl" name="loc_dtl"  <?php if($editFlag==1){?> value="<?php echo $product_details[0]['location_details'] ?>" <?php } ?>  >
								</th>
                            </tr>
                               <tr id="blankTr4" ><td>&nbsp;</td></tr>
<!--                            <tr>
                                <th align="left"><nobr>Product User </nobr></th>
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;</nobr></th>
                                <th>
					<select  id="product_user" name="product_user" style="width:215px;"  value=""  >
						<option value="">--Select--</option>                                                                                               
                                                 <?php if($editFlag==1){?> 
                                                <option value="<?php echo $product_details[0]['prod_user_id']; ?>" selected="true"><?php echo $product_details[0]['company_name']; ?></option>
                                               <?php } else ?> 
                                                
						<?php
						for($i=0; $i<count($usr_list); $i++){ ?>
                                                    <option value="<?php echo $usr_list[$i]['id']; ?>"><?php echo $usr_list[$i]['company_name']; ?></option>
                                               <?php } ?>
					</select>	
                                  </th>  
                            </tr>-->
                            <tr>
                                <th align="left"><nobr>Owner</nobr></th>
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <th>
					<select  id="ownar_id" name="ownar_id" style="width:215px;" value="" >
						<!--option value="">--Select--</option-->
                                                
                                                 <?php if($editFlag==1){?> 
                                                <option value="<?php echo $product_details[0]['owner_id']; ?>" selected="true"><?php echo $product_details[0]['full_name']; ?></option>
                                               <?php } else ?> 
                                                
						<?php
						for($i=0; $i<count($owner_list); $i++){ ?>
                                                    <option value="<?php echo $owner_list[$i]['id']; ?>"><?php echo $owner_list[$i]['full_name']; ?></option>
                                               <?php } ?>
					</select>	
                                  </th>          
				
                            </tr>
                             <tr><td>&nbsp;</td></tr>
                              <tr>
                                <th align="left"><nobr>Received By</nobr></th>
                               <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                               <th><input class="read" type="text" style="width:200px;"  id="rcv_by" name="rcv_by"  value="<?php echo $login_id;?>" readonly="true"></nobr></th>	 				
				
                            </tr>
                             <tr><td>&nbsp;</td></tr>
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
                               <td align="right" colspan="3"><input class="read" type="hidden"  id="pid" name="pid"  <?php if($editFlag==1){?> value="<?php echo $product_details[0]['id']; }?>"</td>

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