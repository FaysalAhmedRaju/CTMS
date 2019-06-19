<script>
	function changeTextBox(val)
		{
			//alert(val);
			var conboDiv = document.getElementById("comboDiv");
			var inputDiv = document.getElementById("inputDiv");
			var dateDiv = document.getElementById("dateDiv");
			if(val=="entry_date")
			{
				dateDiv.style.display="inline";
				inputDiv.style.display="none";
				conboDiv.style.display="none";
			}
			else if(val=="cnf_license")
			{
				inputDiv.style.display="inline";
				conboDiv.style.display="none";
				dateDiv.style.display="none";
			}
			else
			{
				dateDiv.style.display="none";
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
				var url = "<?php echo site_url('ajaxController/getIndentYard');?>";
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
			
				var val = xmlhttp.responseText;
				
				//alert(val);
				
				var selectList=document.getElementById("searchVal");
				removeOptions(selectList);
				//alert(xmlhttp.responseText);
				var val = xmlhttp.responseText;
				var jsonData = JSON.parse(val);
				//alert(xmlhttp.responseText);
				for (var i = 0; i < jsonData.length; i++) 
				{
					var option = document.createElement('option');
					option.value = jsonData[i].id;  //value of option in backend
					option.text = jsonData[i].yard_name;	  //text of option in frontend
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
		} else 
		{
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
            <form action="<?php echo site_url('misReport/mis_equipment_indent_list_Search');?>" method="POST" >
            <table border="0" width="300px" align="center">
		<tr><td colspan="4" align="center"><span><font color="green"  size="4" style="font-weight: bold"><nobr><?php echo $tableTitle; ?></nobr></font></span> </td></tr>

								 
                <tr>
		<td align="left" >
		<label for=""><nobr><b>Search By :</b></nobr><em>&nbsp;</em></label></td>

                <td>
                    <select name="search_by" id="search_by" onchange="changeTextBox(this.value);">
                        <option value="entry_date" selected style="width:110px;">Entry Date</option>
                        <option value="yard" >YARD</option>
                        <option value="cnf_license">CNF LICENSE</option>
                     </select>
		</td>

		<td><b><nobr>Search Value:</nobr></b></td>
		<td>
			<div id="comboDiv" style="display:none;">
				<select name="searchVal" id="searchVal" style="width:170px">
				<option value="">---select---</option>
				</select>
			</div>
			<div id="inputDiv" style="display:none;">
				<input type="text" style="width:170px" id="searchInput" name="searchInput" autofocus />
			</div>
			<div id="dateDiv" style="">
				<input type="text" style="width:170px" id="searchDt" name="searchDt" autofocus />
				<script>
					$(function() {
						$( "#searchDt" ).datepicker({
							changeMonth: true,
							changeYear: true,
							dateFormat: 'yy-mm-dd', // iso format
						});
					});
				</script>
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
                    <input type="submit" value="Search" name="View" class="login_button">
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
			<th>Indent Date</th>
			<th><nobr>Cnf Name<nobr></th>
            <th><nobr>No Of Container<nobr></th>        
			<th><nobr>Description<nobr></th>
            <th><nobr>Yard<nobr></th>
            <th><nobr>RRC<nobr></th>
            <th><nobr>FLT 3T<nobr></th>
            <th><nobr>FLT 5T<nobr></th>
            <th><nobr>FLT 10T<nobr></th>
            <th><nobr>FLT 20T<nobr></th>
            <th><nobr>MC 10T<nobr></th>
            <th><nobr>MC 20T<nobr></th>
            <th><nobr>MC 30T<nobr></th>
            <th><nobr>MC 50T<nobr></th>
			<th><nobr>Edit</nobr></th>
			<th><nobr>Delete</nobr></th>
           </font>
		</tr>
		
	  <?php
     //  loc_id, location_name, owner_id, full_name, type_id, short_name, prod_user_id, 
	//   company_name, prod_serial, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by
        for($i=0;$i<count($list);$i++) { 				
		?>
        <tr>
		<td>
           <?php echo $i+1;?>
        </td>
         
        <td align="center">
           <?php echo $list[$i]['indent_date']?>
        </td>    
		<td align="center">
           <?php echo $list[$i]['cnf_name']?>
        </td>   
        <td align="center">
           <?php echo $list[$i]['no_of_container']?>
        </td>   

        <td align="center">
           <?php echo $list[$i]['goods_description']?>
        </td>   
         
        <td align="center">
           <?php echo $list[$i]['yard_name']?>
        </td>
		<td align="center">
           <?php if($list[$i]['equip_rrc']==1) echo $list[$i]['no_of_rrc']; else echo "0"; ?>
        </td>
		
		<td align="center">
           <?php if($list[$i]['equip_flt_3t']==1) echo $list[$i]['no_of_flt']; else echo "0"; ?>
        </td>
		<td align="center">
           <?php if($list[$i]['equip_flt_5t']==1) echo $list[$i]['no_of_flt']; else echo "0"; ?>
        </td>
		<td align="center">
           <?php if($list[$i]['equip_flt_10t']==1) echo $list[$i]['no_of_flt']; else echo "0"; ?>
        </td>
		<td align="center">
           <?php if($list[$i]['equip_flt_20t']==1) echo $list[$i]['no_of_flt']; else echo "0"; ?>
        </td>
       <td align="center">
           <?php if($list[$i]['equip_mc_10t']==1) echo $list[$i]['no_of_mc']; else echo "0"; ?>
        </td>
		<td align="center">
           <?php if($list[$i]['equip_mc_20t']==1) echo $list[$i]['no_of_mc']; else echo "0"; ?>
        </td>
		<td align="center">
           <?php if($list[$i]['equip_mc_30t']==1) echo $list[$i]['no_of_mc']; else echo "0"; ?>
        </td>
		<td align="center">
           <?php if($list[$i]['equip_mc_50t']==1) echo $list[$i]['no_of_mc']; else echo "0"; ?>
        </td>
	   
		 
		<td align="center">
                <form action="<?php echo site_url('misReport/mis_equipment_indent_list_Edit');?>" method="POST">
                    <input type="hidden" id="indentid" name="indentid" value="<?php echo $list[$i]['id'];?>">							
                    <input type="submit" value="Edit"  class="login_button" style="width:100%;">							
                </form> 
        </td> 
	
		<td align="center"> 
                <form action="<?php echo site_url('misReport/mis_equipment_indent_list');?>" method="POST" onsubmit="return validate();">						
                    <input type="hidden" id="indentid" name="indentid" value="<?php echo $list[$i]['id'];?>">							
                    <input type="submit" value="Delete" name="delete" class="login_button" style="width:100%;">			 						
                </form> 
        </td> 
		
		 <?php }?>
		</tr>
		<tr>
			<td colspan="16" align="center"><b><?php echo $links?></b></td>
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