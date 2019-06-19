<script type="text/javascript">
  
	function validate()
	{
		var jsName=document.getElementById('jsName').value;
        var jsLicenseNo=document.getElementById('jsLicenseNo').value;
        var jsContact=document.getElementById('jsContact').value;
        var jsAddress=document.getElementById('jsAddress').value;
             
        if(jsName==""|| jsName==" ")
        {
            alert("Please! Provide Name.");
            document.getElementById('jsName').focus();
            return false;
        }
        else if(jsLicenseNo==""|| jsLicenseNo==" ")
        {
            alert("Please! Provide License Number.");
            document.getElementById('jsLicenseNo').focus();
            return false;
        }
         else if(jsContact==""|| jsContact==" ")
        {
            alert("Please! Provide Contact Number.");
            document.getElementById('jsContact').focus();
            return false;
        }
		else if(jsAddress==""|| jsAddress==" ")
        {
            alert("Please! Provide Address.");
            document.getElementById('jsAddress').focus();
            return false;
        }
		else {
			return true;
		}
	}	
	
</script

<!--body onload="getAllGate()"-->
<html>
<div class="content">
    <div class="content_resize">
		<div class="mainbar">
			<div class="article">
				<h2 align="left"><span><?php echo $title; ?></span> </h2>
				<p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
   
				<div class="clr"></div>
					<div class="img">
						<form name= "myForm" onsubmit="return(validate());" action="<?php echo site_url("report/jettySarkarEntryFormPerform");?>" method="post"  enctype="multipart/form-data" >
						<table align="center"   width="60%"  cellspacing="0" cellpadding="0" style="padding-right: 80px;" border=0>
							
								<!--tr style="height:35px";>
									<td align="center" colspan="2" ><b><h2 style="color:black">Jetty Sarkar Entry Form</h2></b></td>
								</tr-->
								<tr><td>&nbsp;</td></tr>

								<tr style="height:30px;">
								    <th align="left"><nobr>Jetty Sarkar Name</nobr></th>
									<th><nobr>&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;</nobr></th>
									<td ><input type="text"  id="jsName" name="jsName" <?php if($editFlag==1){ ?> value="<?php echo $jttySr[0]['js_name']; }?>" ></td>
								</tr>	
								<tr style="height:30px;">
								    <th align="left"><nobr>Jetty Sarkar License No</nobr></th>
									<th><nobr>&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;</nobr></th>
									<td ><input type="text"  id="jsLicenseNo " name="jsLicenseNo" <?php if($editFlag==1){ ?> value="<?php echo $jttySr[0]['js_lic_no'] ; } ?>"></td>
								</tr>
								<tr style="height:30px;">
								    <th align="left">Contact No </th>
									<th><nobr>&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;</nobr></th>
									<td ><input type="text" id="jsContact" name="jsContact"   value="<?php if($editFlag==1){ echo $jttySr[0]['cell_no'] ; } ?>" ></td>
								</tr>
								<tr style="height:30px;">
								    <th align="left">Address </th>
									<th><nobr>&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;</nobr></th>
									<td ><input type="text"  id="jsAddress" name="jsAddress" value="<?php if($editFlag==1){echo $jttySr[0]['adress'] ; } ?>"  ></td>
								</tr>
								<tr style="height:30px;">
								    <th align="left">Upload Signature </th>
									<th><nobr>&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;</nobr></th>
									<!--td><input type="file" name="file" id="file" /></td-->
									<td><input type="file" name="sign" id="sign" /></td>
									
								</tr>
								
								<tr style="height:30px;">
								    <th align="left">Upload License Copy </th>
									<th><nobr>&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;</nobr></th>
									<td><input type="file" name="license_img" id="license_img" /></td>									
								</tr>
								<tr style="height:30px;">
								    <th align="left">License Validity Date </th>
									<th><nobr>&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;</nobr></th>
									<td><input type="date" name="license_val_dt" id="license_val_dt" value="<?php if($editFlag==1){echo $jttySr[0]['lic_val_dt'] ; } ?>" /></td>							
								</tr>
								<tr style="height:30px;">
								    <th align="left">Upload Photo </th>
									<th><nobr>&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;</nobr></th>
									<td><input type="file" name="photo_img" id="photo_img" /></td>									
								</tr>
								<tr style="height:30px;">
								    <th align="left">Upload Gate Pass </th>
									<th><nobr>&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;</nobr></th>
									<td><input type="file" name="gate_pass_img" id="gate_pass_img" /></td>									
								</tr>
								<tr style="height:30px;">
								    <th align="left">Gate Pass Validity Date </th>
									<th><nobr>&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;</nobr></th>
									<td><input type="date" name="gate_pass_val_dt" id="gate_pass_val_dt" value="<?php if($editFlag==1){echo $jttySr[0]['gate_pass_val_dt'] ; } ?>" /></td>							
								</tr>
								
								<tr><td>&nbsp;</td></tr>
								<tr>
								
									<td colspan="3" align="center">
												
											<input type="submit" value="Save" name="save" class="login_button">
											
											<input type="hidden" name="updateFlag" value="<?php echo $updateFlag;?>">	
											<input type="hidden" name="jettyId" value="<?php echo $jettyId;?>">	
									</td>
									<!--td colspan="3" align="center"><?php $arrt = array('name'=>'submit_login','id'=>'submit','value'=>'Save','class'=>'login_button'); echo form_submit($arrt);?></td-->
								</tr>
								<tr>
									<td colspan="3" align="center"><?php echo $msg;?></td>
								</tr>
							</table>
							
						</form>
					</div>
        
					<div class="clr"></div>
		    </div>
      </div>
      <div class="sidebar" style="width:10px">
    <?php include_once("mySideBar.php"); ?>
   </div>
      <div class="clr"></div>
    </div>
 <?php echo form_close()?>
  </div>
  <!--/body-->
  </html>