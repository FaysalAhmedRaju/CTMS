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


 function getVsl(rot_no)
	{		
		if (window.XMLHttpRequest) 
		{

		  xmlhttp=new XMLHttpRequest();
		} 
		else 
		{  
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=stateChangeInfo;
		xmlhttp.open("GET","<?php echo site_url('ajaxController/getVslName')?>?rot_no="+rot_no,false);
					
		xmlhttp.send();
	}
	
	
	function stateChangeInfo()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			var val = xmlhttp.responseText;
			var jsonData = JSON.parse(val);
			//alert(xmlhttp.responseText);
			document.getElementById("vsl_name").value="";								
			document.getElementById("vsl_name").value=jsonData[0].vsl_name;								
		}
	}
	
	
 function validate()
      {
		 
		  if( document.myChkForm.berth_op.value == "" )
		 {
			alert( "Please provide No Of Container!" );
			document.myChkForm.berth_op.focus() ;
			return false;
		 }
		 
		 if( document.myChkForm.rot_no.value == "" )
		 {
			alert( "Please provide Rotation No.!" );
			document.myChkForm.rot_no.focus() ;
			return false;
		 }

		  else
		  {
			return true;
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
		  
		<form action="<?php echo site_url('misReport/equipmentUnstuffing_entry');?>" method="POST" name="myChkForm" onsubmit="return(validate());">

		 	 <!--<div id="login_container">-->
			<table style="border:solid 1px #ccc;" width="300px" align="center" cellspacing="2" cellpadding="2">
				<tr>
					<td colspan="3" align="center"><a href="<?php echo site_url('misReport/equipmentUnstuffingList') ?>">GO TO LIST</a></td>
				</tr>
				<tr>
					<td colspan="3" align="center"><?php echo $msg; ?></td>
				</tr>
				<tr>
					<td>UNSTUFFING DATE</td>
					<td colspan="2">
						<input style="width:150px;" type="text" name="un_dt" id="un_dt" <?php if($editFlag==1){?> value="<?php echo $indent_details[0]['un_dt'] ?>" <?php } ?> tabindex="1"/>
						<script>
							$( function() {
							$( "#un_dt" ).datepicker({
							changeMonth: true,
							changeYear: true,
							dateFormat: 'yy-mm-dd', // iso format
							});
							} );
						</script>
					</td>
				</tr>
				<tr>
					<td>BERTH OPERARTOR</td>
					<td>
						<select style="width:100px;" name="berth_op" id="berth_op" tabindex="1">
									<?php if($editFlag==1){?> 
									<option value="<?php echo $indent_details[0]['berth_op']; ?>" label="<?php echo $indent_details[0]['berth_op']; ?>"><?php echo $indent_details[0]['berth_op']; ?></option>
									   <?php }  ?> 
							<option value="" style="width:130px;">---Select---</option>
							<?php	for($i=0; $i<count($bertg_opList); $i++){ ?>
							<option value="<?php echo $bertg_opList[$i]['berthop']; ?>" label="<?php echo $bertg_opList[$i]['berthop']; ?>"><?php echo $bertg_opList[$i]['berthop']; ?></option>
									   <?php }  ?>
						</select>
					
					</td>
				</tr>
				<tr>
					<td>ROTATION NO.</td>
					<td colspan="2"><input style="width:150px;" type="text" name="rot_no" id="rot_no" <?php if($editFlag==1){?> value="<?php echo $indent_details[0]['rotation'] ?>" <?php } ?> onblur="getVsl(this.value);" tabindex="2"/></td>
				</tr>
				<tr>
					<td>VESSEL NAME.</td>
					<td colspan="2"><input style="width:150px;" type="text" name="vsl_name" id="vsl_name" <?php if($editFlag==1){?> value="<?php echo $indent_details[0]['vsl_name'] ?>" <?php } ?> /></td>
				</tr>
				<tr>
					<td>UPPER NO.</td>
					<td colspan="2"><input style="width:150px;" type="text" name="upr_no" id="upr_no" <?php if($editFlag==1){?> value="<?php echo $indent_details[0]['up_no'] ?>" <?php } ?> tabindex="3"/></td>
				</tr>
				<tr>
					<td>SHED NO</td>
					<td colspan="2"><input style="width:150px;" type="text" name="shed_no" id="shed_no" <?php if($editFlag==1){?> value="<?php echo $indent_details[0]['shed_no'] ?>" <?php } ?> tabindex="4"/></td>
				</tr> 
				<tr>
					<td>BUSKAR</td>
					<td colspan="2"><input style="width:150px;" type="text" name="buskar" id="buskar" <?php if($editFlag==1){?> value="<?php echo $indent_details[0]['buskar'] ?>" <?php } ?> tabindex="5"/></td>
				</tr>
				<tr>
					<td>LONG TROLLY</td>
					<td colspan="2"><input style="width:150px;" type="text" name="long_trolly" id="long_trolly" <?php if($editFlag==1){?> value="<?php echo $indent_details[0]['long_trolly'] ?>" <?php } ?> tabindex="6"/></td>
				</tr>

				<tr>
					<td>FLT</td>
					<td>
						<select style="width:100px;" name="equip_flt" id="equip_flt" tabindex="7" >
							<option value="" selected style="width:130px;">---Select---</option>
							<option value="3T" label="3T" <?php if($indent_details[0]['flt_3t']>0) echo 'selected="selected"'; ?>>3T</option>
							<option value="5T" label="5T" <?php if($indent_details[0]['flt_5t']>0) echo 'selected="selected"'; ?>>5T</option>
							<option value="10T" label="10T" <?php if($indent_details[0]['flt_10t']>0) echo 'selected="selected"'; ?>>10T</option>
							<option value="20T" label="20T" <?php if($indent_details[0]['flt_20t']>0) echo 'selected="selected"'; ?>>20T</option>
						</select> 
					
						<input style="width:48px;" type="text" name="no_of_flt" id="no_of_flt" <?php if($editFlag==1){?> value="<?php echo $indent_details[0]['no_of_flt'] ?>" <?php } ?> tabindex="8"/>
					</td>
				</tr>
				<tr>
					<td>MC</td> 
					<td>
						<select style="width:100px;" name="equip_mc" id="equip_mc" tabindex="9">
							<option value="" selected style="width:130px;">---Select---</option>

							<option value="10T" label="10T" <?php if($indent_details[0]['mc_10t']>0) echo 'selected="selected"'; ?> >10T</option>
							<option value="20T" label="20T" <?php if($indent_details[0]['mc_20t']>0) echo 'selected="selected"'; ?>>20T</option>
							<option value="30T" label="30T" <?php if($indent_details[0]['mc_30t']>0) echo 'selected="selected"'; ?>>30T</option>
							<option value="50T" label="50T" <?php if($indent_details[0]['mc_50t']>0) echo 'selected="selected"'; ?>>50T</option>

						</select>
					
						<input style="width:48px;" type="text" name="no_of_mc" id="no_of_mc" <?php if($editFlag==1){?> value="<?php echo $indent_details[0]['no_of_mc'] ?>" <?php } ?> tabindex="10"/>
					</td>
				</tr>
				<!--tr>
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
				</tr-->
				<tr>
					<td colspan="3"><input type="hidden"  id="unstuffid" name="unstuffid"  <?php if($editFlag==1){?> value="<?php echo $indent_details[0]['id']; }?>"</td>
				</tr>
			
				<tr>
					 <td align="center" colspan="3">
						 <?php if($editFlag==1){?>
						 <input class="login_button"  name="update" type="submit"  value="UPDATE" tabindex="11"> 
						 <?php } else{?>
						  <input class="login_button"  name="save" type="submit"  value="SAVE" tabindex="11"> 
						 <?php } ?> 
					 </td>

			   </tr>
				
			</table>

		</form>
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