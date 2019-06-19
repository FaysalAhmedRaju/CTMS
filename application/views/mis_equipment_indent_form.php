 
 <script>
 	$(document).on('keypress', 'input,select,textarea', function (e) {
    if (e.which == 13) {
        e.preventDefault();
        var $next = $('[tabIndex=' + (+this.tabIndex + 1) + ']');
        console.log($next.length);
        if (!$next.length) {
            //$next = $('[tabIndex=1]');
   form.submit();
        }
  else
        $next.focus();
    }
   });

   
 function getCnfName(val)
	{		
	
		if (window.XMLHttpRequest) 
		{

		  xmlhttp=new XMLHttpRequest();
		} 
		else 
		{  
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=stateChangeCnfInfo;
		xmlhttp.open("GET","<?php echo site_url('ajaxController/getCnfCode')?>?cnf_lic_no="+val,false);
					
		xmlhttp.send();
	}
	
	function stateChangeCnfInfo()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			
			var val = xmlhttp.responseText;
			console.log(val);
			//alert(xmlhttp.responseText);
			var val = xmlhttp.responseText;
			var jsonData = JSON.parse(val);
			var cnfCodeTxt=document.getElementById("cnf_name");
			//alert(xmlhttp.responseText);
			for (var i = 0; i < jsonData.length; i++) 
			{
				cnfCodeTxt.value=jsonData[i].name;
			}										
		}
	}
 /*function getBlock()
	{		
		if (window.XMLHttpRequest) 
		{

		  xmlhttp=new XMLHttpRequest();
		} 
		else 
		{  
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=stateChangeYardInfo;
		xmlhttp.open("GET","<?php echo site_url('ajaxController/getIndentYard')?>",false);
					
		xmlhttp.send();
	}
	
	
	function stateChangeYardInfo()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			
			var val = xmlhttp.responseText;
			
		    //alert(val);
			
			var selectList=document.getElementById("yard");
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
	}*/
	
	
	function removeOptions(selectbox)
	{
		var i;
		for(i=selectbox.options.length-1;i>=1;i--)
		{
			selectbox.remove(i);
		}
	}
 /*window.onload = function() {
	getBlock();
};*/
 function validate()
      {
		  if(confirm("Do you really want to do this?"))
		  {
			 if( document.myChkForm.cnf_lic_no.value == "" )
			 {
				alert( "Please provide Cnf License!" );
				document.myChkForm.cnf_lic_no.focus() ;
				return false;
			 }
			
			 if( document.myChkForm.no_of_cont.value == "" )
			 {
				alert( "Please provide No Of Container!" );
				document.myChkForm.no_of_cont.focus() ;
				return false;
			 }
			 if( document.myChkForm.yard.value == "" && document.myChkForm.shed.value == "")
			 {
				alert( "Please select Yard/Shed!" );
				document.myChkForm.yard.focus() ;
				return false;
			 }
			
			 return true ;
		  }
		  else
		  {
			return false;
		  }
		  //alert(document.myChkForm.used_equipment.value);
		
      }
 </script>
 <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
		  
		<form action="<?php echo site_url('misReport/mis_equipment_indent_entry');?>" method="POST" name="myChkForm" onsubmit="return(validate());">

		 	 <!--<div id="login_container">-->
			 <?php echo $msg; ?>
			<table style="border:solid 1px #ccc;" width="300px" align="center" cellspacing="2" cellpadding="2">
				<tr>
					<td colspan="3" align="center"><a href="<?php echo site_url('misReport/mis_equipment_indent_list') ?>">GO TO INDENT LIST</a></td>
				</tr>
				<tr>
					<td>INDENT DATE</td>
					<td colspan="2">
						<input style="width:150px;" type="text" name="indent_dt" id="indent_dt" <?php if($editFlag==1){?> value="<?php echo $indent_details[0]['indent_date'] ?>" <?php } ?> tabindex="1"/>
						<script>
							$( function() {
							$( "#indent_dt" ).datepicker({
							changeMonth: true,
							changeYear: true,
							dateFormat: 'yy-mm-dd', // iso format
							});
							} );
						</script>
					</td>
				</tr>
				<tr>
					<td>CNF CODE</td>
					<td colspan="2"><input style="width:150px;" type="text" name="cnf_lic_no" id="cnf_lic_no" onblur="getCnfName(this.value)" <?php if($editFlag==1){?> value="<?php echo $indent_details[0]['cnf_code'] ?>" <?php } ?> tabindex="2"/></td>
				</tr>
				<tr>
					<td>CNF NAME</td>
					<td colspan="2"><input style="width:150px;" type="text" name="cnf_name" id="cnf_name" readonly="true" <?php if($editFlag==1){?> value="<?php echo $indent_details[0]['cnf_name'] ?>" <?php } ?>/></td>
				</tr>
				<tr>
					<td>NO OF CONT.</td>
					<td colspan="2"><input style="width:150px;" type="text" name="no_of_cont" id="no_of_cont" placeholder="no * size" <?php if($editFlag==1){?> value="<?php echo $indent_details[0]['no_of_container'] ?>" <?php } ?> tabindex="3"/></td>
				</tr>
				<tr>
					<td>DESCRIPTION</td>
					<td colspan="2"><textarea style="width:150px;" type="text" name="description" tabindex="3" > <?php if($editFlag==1){?> <?php echo $indent_details[0]['goods_description']; ?> <?php } ?> </textarea></td>
				</tr>
				<tr>
					<td>TOT WEIGHT</td>
					<td colspan="2"><input style="width:150px;" type="text" name="tot_weight" <?php if($editFlag==1){?> value="<?php echo $indent_details[0]['total_weight'] ?>" <?php } ?> tabindex="4"/></td>
				</tr>
				<tr>
					<td>MAX WEIGHT(PKG)</td>
					<td colspan="2"><input style="width:150px;" type="text" name="max_weight" <?php if($editFlag==1){?> value="<?php echo $indent_details[0]['max_weight_pkg'] ?>" <?php } ?> tabindex="5"/></td>
				</tr>
				<tr>
					<td>RRC</td>
					<td>
						<select style="width:100px;" name="equip_rrc" id="quip_rrc" tabindex="6">
							<option value="" selected style="width:130px;">---Select---</option>
							<option value="RRC" label="RRC" <?php if($indent_details[0]['equip_rrc']>0) echo 'selected="selected"'; ?>>RRC</option>
						</select>
					
						<input style="width:48px;" type="text" name="no_of_rrc" id="no_of_rrc" <?php if($editFlag==1){?> value="<?php echo $indent_details[0]['no_of_rrc'] ?>" <?php } ?>  tabindex="7"/>
					</td>
				</tr>
				<tr>
					<td>FLT</td>
					<td>
						<select style="width:100px;" name="equip_flt" id="equip_flt" tabindex="8" >
							<option value="" selected style="width:130px;">---Select---</option>
							<option value="3T" label="3T" <?php if($indent_details[0]['equip_flt_3t']>0) echo 'selected="selected"'; ?>>3T</option>
							<option value="5T" label="5T" <?php if($indent_details[0]['equip_flt_5t']>0) echo 'selected="selected"'; ?>>5T</option>
							<option value="10T" label="10T" <?php if($indent_details[0]['equip_flt_10t']>0) echo 'selected="selected"'; ?>>10T</option>
							<option value="20T" label="20T" <?php if($indent_details[0]['equip_flt_20t']>0) echo 'selected="selected"'; ?>>20T</option>
						</select>
					
						<input style="width:48px;" type="text" name="no_of_flt" id="no_of_flt" <?php if($editFlag==1){?> value="<?php echo $indent_details[0]['no_of_flt'] ?>" <?php } ?> tabindex="9"/>
					</td>
				</tr>
				<tr>
					<td>MC</td>
					<td>
						<select style="width:100px;" name="equip_mc" id="equip_mc" tabindex="10">
							<option value="" selected style="width:130px;">---Select---</option>

							<option value="10T" label="10T" <?php if($indent_details[0]['equip_mc_10t']>0) echo 'selected="selected"'; ?> >10T</option>
							<option value="20T" label="20T" <?php if($indent_details[0]['equip_mc_20t']>0) echo 'selected="selected"'; ?>>20T</option>
							<option value="30T" label="30T" <?php if($indent_details[0]['equip_mc_30t']>0) echo 'selected="selected"'; ?>>30T</option>
							<option value="50T" label="50T" <?php if($indent_details[0]['equip_mc_40t']>0) echo 'selected="selected"'; ?>>50T</option>

						</select>
					
						<input style="width:48px;" type="text" name="no_of_mc" id="no_of_mc" <?php if($editFlag==1){?> value="<?php echo $indent_details[0]['no_of_mc'] ?>" <?php } ?> tabindex="11"/>
					</td>
				</tr>
				<tr>
					<td>YARD </td>
					<td colspan="2">
						<select style="width:155px;" name="yard" id="yard" tabindex="12">
							<option value="">---Select---</option> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		
							<?php for($i=0; $i<count($rtnBlockList); $i++){ ?>
								<option value="<?php echo $rtnBlockList[$i]['id']; ?>" 
								label="<?php echo $rtnBlockList[$i]['yard_name']; ?>" <?php if($rtnBlockList[$i]['id']==$indent_details[0]['indent_yard_id']) echo 'selected="selected"'; ?>><?php echo $rtnBlockList[$i]['yard_name']; ?></option>
							<?php } ?>							
						</select>
					</td>
				</tr>
				<tr>
					<td>SHED </td>
					<td colspan="2">
						<select style="width:155px;" name="shed" id="shed" tabindex="13">
							<option value="">---Select---</option> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		
							<?php for($i=0; $i<count($rtnShedList); $i++){ ?>
								<option value="<?php echo $rtnShedList[$i]['id']; ?>" 
								label="<?php echo $rtnShedList[$i]['yard_name']; ?>" <?php if($rtnShedList[$i]['id']==$indent_details[0]['indent_yard_id']) echo 'selected="selected"'; ?>><?php echo $rtnShedList[$i]['yard_name']; ?></option>
							<?php } ?>							
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="3" align="center">
					 <?php if($editFlag==1){?>
					 <input class="login_button"  name="update" type="submit"  value="UPDATE" > 
					 <?php } else{?>
					  <input class="login_button"  name="save" type="submit"  value="SAVE" > 
					 <?php } ?> 
					</td>
				</tr>
				<tr>
					<td colspan="3"><input class="read" type="hidden"  id="indentid" name="indentid"  <?php if($editFlag==1){?> value="<?php echo $indent_details[0]['id']; }?>"</td>
				</tr>
			</table>
		 <!--</div>-->

         <!-- <div class="post_content">
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. <a href="#">Suspendisse bibendum. Cras id urna.</a> Morbi tincidunt, orci ac convallis aliquam, lectus turpis varius lorem, eu posuere nunc justo tempus leo. Donec mattis, purus nec placerat bibendum, dui pede condimentum odio, ac blandit ante orci ut diam. Cras fringilla magna. Phasellus suscipit, leo a pharetra condimentum, lorem tellus eleifend magna, eget fringilla velit magna id neque. Curabitur vel urna. In tristique orci porttitor ipsum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. Suspendisse bibendum. Cras id urna. Morbi tincidunt, orci ac convallis aliquam, lectus turpis varius lorem, eu posuere nunc justo tempus leo.</p>
            <p><strong>Aenean consequat porttitor adipiscing. Nam pellentesque justo ut tortor congue lobortis. Donec venenatis sagittis fringilla.</strong> Etiam nec libero magna, et dictum velit. Proin mauris mauris, mattis eu elementum eget, commodo in nulla. Mauris posuere venenatis pretium. Maecenas a dui sed lorem aliquam dictum. Nunc urna leo, imperdiet eu bibendum ac, pretium ac massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla facilisi. Quisque condimentum luctus ullamcorper.</p>
            <p class="spec"><a href="#" class="rm">Read more &raquo;</a></p>
			
			
          </div>-->
		  <?php echo form_close()?>
          <div class="clr"></div>
        </div>
       
       <!-- <p class="pages"><small>Page 1 of 2</small> <span>1</span> <a href="#">2</a> <a href="#">&raquo;</a></p>-->
      </div>
      <div class="sidebar">
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	<?php echo form_close()?>
  </div>