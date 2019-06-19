<script>
	function changeTextBox(val)
		{
			//alert(val);
			var conboDiv = document.getElementById("conboDiv");
			var inputDiv = document.getElementById("inputDiv");
			if(val=="serial" || val=="product" || val=="ip_addr")
			{
				inputDiv.style.display="inline";
				conboDiv.style.display="none";
			}
			else
			{
				inputDiv.style.display="none";
				conboDiv.style.display="inline";
				
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
				var url = "<?php echo site_url('ajaxController/getComboValForNetworkList');?>?colName="+val;
				//alert(url);
				xmlhttp.onreadystatechange=stateChangeSearchComboVal;
				xmlhttp.open("GET",url,false);
				xmlhttp.send();
			}
			
		}
		
	function stateChangeSearchComboVal()
		{
			//alert(xmlhttp.responseText);
           if (xmlhttp.readyState==4 && xmlhttp.status==200) 
			{
			var selectList=document.getElementById("searchVal");
			removeOptions(selectList);
				//alert(xmlhttp.responseText);
			var val = xmlhttp.responseText;
			var jsonData = JSON.parse(val);
				//alert(xmlhttp.responseText);
			for (var i = 0; i < jsonData.length; i++) 
			{
				var option = document.createElement('option');
				option.value = jsonData[i].id;
				option.text = jsonData[i].detl;
				selectList.appendChild(option);
                                
			}
                    }
		}
		
    function removeOptions(selectbox)
	{
	var i;
	for(i=selectbox.options.length-1;i>=1;i--)
            {
		selectbox.remove(i);
            }
	}

    function validate()
      {
        if (confirm("Are you sure!! Delete this record?") == true) {
		   return true ;
	} else {
		 return false;
            }		 
      }
      
       function checked()
      {
          	if (confirm("Are you sure! you checked this record!!") == true) {
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
            <form action="<?php echo site_url('report/networkProductEntryListBySearch');?>" method="POST" >
            <table border="0" width="300px" align="center">
		<tr><td colspan="4" align="center"><span><font color="green"  size="4" style="font-weight: bold"><nobr><?php echo $tableTitle; ?></nobr></font></span> </td></tr>

								 
                <tr>
		<td align="left" >
		<label for=""><nobr><b>Search By :</b></nobr><em>&nbsp;</em></label></td>

                <td>
                    <select name="search_by" id="search_by" onchange="changeTextBox(this.value);">
                        <option value="serial" label="Serial No" selected style="width:110px;">Serial No</option>
                        <option value="category" label="Product Category">Product Category</option>
                        <option value="product" label="Product Name">Product Name</option>
                        <option value="location" label="Location">Location</option>
                        <!--<option value="serial" label="Serial No">Serial No</option>-->
                        <option value="user" label="Updated By">Updated By</option>
                        <option value="ip_addr" label="IP Address">IP Address</option>
                     </select>
		</td>

		<td><b><nobr>Search Value:</nobr></b></td>
		<td>
			<div id="conboDiv" style="display:none;">
				<select name="searchVal" id="searchVal" style="width:170px">
				<option value="">---select---</option>
				</select>
			</div>
			<div id="inputDiv" style="">
				<input type="text" style="width:170px" id="searchInput" name="searchInput" autofocus />
			</div>
		</td>
<!--		 <select name="search_by" id="search_by" class="" onchange="changeTextBox(this.value);">
			<option value="" label="search_by" selected style="width:110px;">---Select-------</option>
			<option value="category" label="Product Category">Product Category</option>
			<option value="product" label="Product Name">Product Name</option>
                        <option value="location" label="Location">Product Name</option>
                        <option value="serial" label="Serial No">Serial No</option>

																
                 </select>-->

<!--		</tr>	
														
		<tr>
		<td align="left" ><label for=""><font color='red'></font><nobr>Search value :<nobr><em>&nbsp;</em></label></td>
		<td>
		<input type="text" style="width:150px;" id="search_value" name="search_value" > 
		</td>-->
		<td  align="center" width="70px">
                    <input type="submit" value="View" name="View" class="login_button">
		</td>
			
								
	<!--tr>
		<td colspan="4" align="right" width="70px">
                    <input type="submit" value="View" name="View" class="login_button">
		</td>
					
            </tr-->
            </table>
         </form>	
	   
   	<table cellspacing="1" cellpadding="1" align="center"  id="mytbl" style="overflow-y:scroll" >
	<tr><td colspan="12" align="center"><h2><span><font color="green"  size="4" style="font-weight: bold"><nobr><?php // echo $tableTitle; ?></nobr></font></span> </h2></td></tr>
		<tr class="gridDark" style="height:35px;" >		
                    <font size="15">
			<th>SL</th>
			<th><nobr>Product Category<nobr></th>
            <th><nobr>Product Name<nobr></th>        
			<th><nobr>Serial No.<nobr></th>
            <th><nobr>IMEI No.<nobr></th>
			<th><nobr>Location Details</nobr></th>
			<th><nobr>IP Address</nobr></th>			
			<th><nobr>Model/Dec</nobr></th>
			<th><nobr>Received Date</nobr></th>
            <th><nobr>Checked</nobr></th>
			<th><nobr>Edit</nobr></th>
			<th><nobr>Delete</nobr></th>
           </font>
		</tr>
		
	  <?php
     //  loc_id, location_name, owner_id, full_name, type_id, short_name, prod_user_id, 
	//   company_name, prod_serial, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by
        for($i=0;$i<count($list);$i++) { 				
		?>
                <tr <?php if($list[$i]['checkStatus']==1){ ?> 
                style="background-color:#f9e79f" <?php } else ?> class="gridLight">
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
           <?php echo $list[$i]['imei_number']?>
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
                <form action="<?php echo site_url('report/networkProductCkecked');?>" method="POST" onsubmit="return checked();">
                    <input type="hidden" id="chkId" name="chkId" value="<?php echo $list[$i]['id'];?>">							
                    <input type="submit" value="Check"  class="login_button" style="width:100%;">							
                </form> 
        </td> 
		 
	<td align="center">
                <form action="<?php echo site_url('report/networkProductListEdit');?>" method="POST">
                    <input type="hidden" id="prodructID" name="prodructID" value="<?php echo $list[$i]['id'];?>">							
                    <input type="submit" value="Edit"  class="login_button" style="width:100%;">							
                </form> 
        </td> 
	
	<td align="center"> 
                <form action="<?php echo site_url('report/networkProductEntryList');?>" method="POST" onsubmit="return validate();">						
                    <input type="hidden" id="pid" name="pid" value="<?php echo $list[$i]['id'];?>">							
                    <input type="submit" value="Del." name="delete" class="login_button" style="width:80%;">			 						
                </form> 
        </td> 
		
		 <?php }?>
		</tr>
		<tr>
			<td colspan="11" align="center"><b><?php echo $links?></b></td>
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