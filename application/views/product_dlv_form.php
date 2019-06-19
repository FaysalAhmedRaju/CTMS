<script type="text/javascript">
	// function validate()
	// {
		// if(document.product_type.short_name.value == "")
		// {
			// alert("Please provide short name!");
			// document.product_type.short_name.focus();
			// return false;
		// }
		// if(document.product_type.description.value == "")
		// {
			// alert("Please provide description!");
			// document.product_type.description.focus();
			// return false;
		// }
		// return true ;
	// }
	
	function get_product_name(product_type_id)
	{
		if (window.XMLHttpRequest) 
		{
			xmlhttp=new XMLHttpRequest();
		} 
		else 
		{  
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		var url = "<?php echo site_url('ajaxController/get_product_name')?>?product_type_id="+product_type_id;
		
		xmlhttp.onreadystatechange=stateChangeProductType;
		xmlhttp.open("GET",url,false);
					
		xmlhttp.send();
	}
	
	function stateChangeProductType()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			var val = xmlhttp.responseText;
			//alert(val);
			var selectList=document.getElementById("product_name");
			removeOptions(selectList);
			
			var val = xmlhttp.responseText;
			var jsonData = JSON.parse(val);
			
			for (var i = 0; i < jsonData.length; i++) 
			{
				var option = document.createElement('option');
				option.value = jsonData[i].id;  //value of option in backend
				option.text = jsonData[i].prod_name;	  //text of option in frontend
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
	
	function get_handover_to(handover_cat)
	{
		if (window.XMLHttpRequest) 
		{
			xmlhttp=new XMLHttpRequest();
		} 
		else 
		{  
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		var url = "<?php echo site_url('ajaxController/get_handover_to')?>?handover_cat="+handover_cat;
		
		xmlhttp.onreadystatechange=stateChangeHandoverTo;
		xmlhttp.open("GET",url,false);
					
		xmlhttp.send();
	}
	
	function stateChangeHandoverTo()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			var val = xmlhttp.responseText;
			//alert(val);
			var selectList=document.getElementById("handover_to");
			removeOptions(selectList);
			
			var val = xmlhttp.responseText;
			var jsonData = JSON.parse(val);
			
			var handover_category=document.getElementById('handover_category').value;
			//alert(handover_category);
			if(handover_category=="new")
			{
				for (var i = 0; i < jsonData.length; i++) 
				{
					var option = document.createElement('option');
					option.value = jsonData[i].id;  //value of option in backend
					option.text = jsonData[i].full_name;	  //text of option in frontend
					selectList.appendChild(option);
				}
			}
			else if(handover_category=="damaged"||handover_category=="repaired")
			{
				for (var i = 0; i < jsonData.length; i++) 
				{
					var option = document.createElement('option');
					option.value = jsonData[i].id;  //value of option in backend
					option.text = jsonData[i].company_name;	  //text of option in frontend
					selectList.appendChild(option);
				}
			}				
		}
	}
        
        
     function showUsr(usr)
       {       
            if(usr=="owner")
            { 
                document.getElementById("ownerTr").style.display = "table-row";
                document.getElementById("userTr").style.display = "none";
                document.getElementById("blankTr3").style.display = "table-row";
                document.getElementById("blankTr2").style.display = "none";
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
				<h2><span><?php echo $title; ?></span> </h2>
				<p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
			
				<div class="clr"></div>
				<div class="img">
					<form name= "product_dlv_form" id="product_dlv_form"  action="<?php echo site_url("report/product_dlv_entry");?>"  method="post">
						<table align="center" style="border:solid 1px #ccc;" width="600px" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="2" align="center"><?php echo $msg; ?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="center" ><font color='red'><b>*</b></font>Product Type : </td>
								<td>
									<select id="product_type" name="product_type" onchange="get_product_name(this.value);" >
										<option value="">--Select Type--</option>
                                                                                <?php if($editflag==1){ ?>
                                                                                <option value="<?php echo $delv_details[0]['typeid']; ?>" selected="true"><?php echo $delv_details[0]['short_name']; ?></option>
										<?php
                                                                                }
										include('mydbPConnection.php');
										$sql_product_type="SELECT id,IF(short_name='Monitor',CONCAT(short_name,'-',product_desc),short_name) AS short_name FROM cchaportdb.inventory_product_type ORDER BY short_name ASC";
										
										$rslt_product_type=mysql_query($sql_product_type);
										
										while($row_product_type=mysql_fetch_object($rslt_product_type))
										{
											$product_id=$row_product_type->id;
											$product_name=$row_product_type->short_name;
										?>
										<option value="<?php echo $product_id; ?>"><?php echo $product_name; ?></option>
										<?php
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="center" ><font color='red'><b>*</b></font>Product Name- Serial: </td>
								<td>
									<select id="product_name" name="product_name">
										<option value="">--Select Type--</option>
                                                                                 <?php if($editflag==1){ ?>
                                                                                <option value="<?php echo $delv_details[0]['product_id']; ?>" selected="true"><?php echo $delv_details[0]['prod_name']; ?> </option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="center" ><font color='red'><b>*</b></font>Handover Category : </td>
								<td>
									<select id="handover_category" name="handover_category" >
										<option value="">--Select Type--</option>
                                                                                 <?php if($editflag==1){ ?>
                                                                                <option value="<?php echo $delv_details[0]['handover_category']; ?>" selected="true"><?php echo $delv_details[0]['handover_category']; ?></option>
										<?php } ?>
										<option value="damaged">Damaged</option>
										<option value="new">New</option>
										<option value="repaired">Repaired</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
<!--							<tr>
								<td align="right" ><font color='red'><b>*</b></font>Handover To : </td>
								<td>
									<select id="handover_to" name="handover_to">
										<option value="">--Select Type--</option>
                                                                                 <?php if($editflag==1){ ?>
                                                                                <option value="<?php echo $delv_details[0]['handover_to']; ?>" selected="true"><?php echo $delv_details[0]['owner_user']; ?></option>
										<?php } ?>
									</select>
								</td>
							</tr>-->
							<tr>
								<td>&nbsp;</td>
							</tr>
                                                        
                                                        
                                                    <tr>
                                                    <td align="center" ><font color='red'><b>*</b></font>Handover To : </td>
                                                        <td>
                                                                <select  id="handover_to" name="handover_to" style="width:215px;" onchange="showUsr(this.value)">
                                                                        <option value="">--Select--</option>
                                                            <?php $hand_to= $delv_details[0]['handover_to'];
                                                                    if($editflag==1)  {?> 
                                                                        <option value="<?php echo $hand_to ?>" selected="true"><?php echo $hand_to; ?></option>
                                                              <?php } ?>        
                                                                         <option value="owner">owner</option>
                                                                         <option value="user">user</option>
                                                                </select>
                                                              
                                                        </td>               
                                                    </tr> 
                                                    <tr><td colspan="2">&nbsp;</td></tr>

                                                    <tr id="ownerTr"  <?php if ($delv_details[0]['handover_to']!='owner') { ?>  style="display: none" <?php } ?>>
                                                        <td align="center"><nobr>Handover To Owner </nobr></td>
<!--                                                        <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>-->
                                                        <td>
                                                            <select  id="ownar_id" name="ownar_id" style="width:215px;" value="" >
                                                                        <option value="">--Select--</option>

                                                                         <?php if($editflag==1 && $hand_to=="owner"){?> 
                                                                        <option value="<?php echo $delv_details[0]['handover_owner_user_id']; ?>" selected="true"><?php echo $delv_details[0]['owner_user']; ?></option>
                                                                       <?php } ?> 

                                                                        <?php
                                                                        for($i=0; $i<count($owner_list); $i++){ ?>
                                                                            <option value="<?php echo $owner_list[$i]['id']; ?>"><?php echo $owner_list[$i]['full_name']; ?></option>
                                                                       <?php } ?>
                                                                </select>	
                                                        </td>

                                                    </tr>

                                                    <tr  id="blankTr2"><td colspan="2">&nbsp;</td></tr>

                                                    <tr id="userTr"   <?php if ($delv_details[0]['handover_to']!='user') { ?>  style="display: none" <?php } ?> >
                                                        <td align="center"><nobr>Handover To User  : </nobr></td>
                                                        <td>
                                                            <select  id="usr_id" name="usr_id" style="width:215px;" value="" >
                                                                        <option value="">--Select--</option>

                                                                     <?php if($editflag==1 && $hand_to=="user"){?> 
                                                                        <option value="<?php echo $delv_details[0]['handover_owner_user_id']; ?>" selected="true"><?php echo $delv_details[0]['owner_user']; ?></option>
                                                                       <?php } ?> 

                                                                        <?php
                                                                        for($i=0; $i<count($usr_list); $i++){ ?>
                                                                            <option value="<?php echo $usr_list[$i]['id']; ?>"><?php echo $usr_list[$i]['company_name']; ?></option>
                                                                       <?php } ?>
                                                                </select>	
                                                        </td>

                                                    </tr>

                                                        
                                                        
                                                         <tr id="blankTr3"><td colspan="2">&nbsp;</td></tr>
                                                        
                                                        
							<tr>
								<td align="center" ><font color='red'><b>*</b></font>Handover Date : </td>
								<td>
                                                                        <input type="text" style="width:150px;" id="handover_date" name="handover_date"  <?php if($editflag==1){ ?> value="<?php echo $delv_details[0]['handover_date'];  }?>"/>
								</td>
								<script>
									$(function() {
										$( "#handover_date" ).datepicker({
											changeMonth: true,
											changeYear: true,
											dateFormat: 'yy-mm-dd', // iso format
										});
									});
								</script>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="center" ><font color='red'><b>*</b></font>Comments : </td>
								<td>
									<textarea id="comments" name="comments" rows="5" ><?php if($editflag==1) { echo $delv_details[0]['comments']; }  ?> </textarea>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="center" ><font color='red'><b>*</b></font>Handover By : </td>
								<td>
                                                                        <input type="text" style="width:150px;" id="handover_by" name="handover_by" <?php if($editflag==1) { ?> value="<?php echo $delv_details[0]['handover_by']; } else{  ?>" value="<?php echo $login_id; } ?>"  readonly />
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
<!--								<td colspan="2" align="center">
									<input type="submit" value="Save" class="login_button"/>      
								</td>-->
                                                                  <td align="right" >
                                                                    <?php if($editflag==1){ ?>
                                                                    <input class="login_button"  name="update" type="submit"  value="Update" > 
                                                                    <?php } else { ?>
                                                                     <input class="login_button"  name="save" type="submit"  value="Save" > 
                                                                    <?php } ?> 
                                                                </td>
                                                        </tr>
							<tr>
								<td>&nbsp;</td>
                                                                <td><input type="hidden" style="width:150px;" id="delid" name="delid" <?php if($editflag==1) { ?> value="<?php echo $delv_details[0]['id']; }  ?>"  /></td>

							</tr>
                                                        <tr>
                                                            <!--<td><?php echo $msg; ?></td>-->
                                                        </tr>
						</table>
					</form>
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