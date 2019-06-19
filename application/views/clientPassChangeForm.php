 <link rel="shortcut icon" href="<?php echo IMG_PATH; ?>changepassword.jpg" />
 <script type="text/javascript">
      function checkPass()
	{
    //Store the password field objects into variables ...
    var new_password = document.getElementById('new_password');
    var confirm_password = document.getElementById('confirm_password');
    //Store the Confimation Message Object ...
    var message = document.getElementById('confirmMessage');
    //Set the colors we will be using ...
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    //Compare the values in the password field 
    //and the confirmation field
    if(new_password.value == confirm_password.value){
        //The passwords match. 
        //Set the color to the good color and inform
        //the user that they have entered the correct password 
        confirm_password.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "Passwords Match!"
    }else{
        //The passwords do not match.
        //Set the color to the bad color and
        //notify the user.
        confirm_password.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Passwords Not Match!"
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
		  <h2><span><?php echo $title; ?></span> </h2>
		  <?php 
		  $attributes = array('id' => 'myform');
		  
		  echo form_open(base_url().'index.php/login/changePassForClientPerform',$attributes);
			$Stylepadding = 'style="padding: 12px 20px;"';
				if(!empty($error_message))
				{
					$Stylepadding = 'style="padding:25px 20px;"';
				}	
				if(isset($captcha_image)){
					$Stylepadding = 'style="padding:62px 20px 93px;"';
				}?>
	
		<div class="img">
		 	 
			 <table style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
				<tr><td>
				<table border="0" width="400px" align="center" cellspacing="5">				
								<tr>
									<td align="right" colspan="2"></td>
								</tr>
								<tr>
									<td align="center" colspan="2"><h2>Client Password Change Form</h2></td>
								</tr>
								
								<tr><br />
									<td align="right" ><label for="loging_id">Login Id:<em>&nbsp;</em></label></td>
									<td align="left" >
									  <input type="text" name="loging_id"  id="loging_id" value="" style="width:130px;">
									</td>
								</tr>
								<!--tr><br />
									<td align="right" ><label for="old_password">Current Password:<em>&nbsp;</em></label></td>
									<td align="left" >
									<input type="password" name="old_password" id="old_password" style="width:130px;" > 
									</td>
								</tr-->
								<tr><br />
									<td align="right" ><label for="new_password">New Password:<em>&nbsp;</em></label></td>
									<td align="left" >
									<input type="password" name="new_password" id="new_password" value="" style="width:130px;">
									</td>
								</tr>
								<tr><br />
									<td align="right" ><label for="confirm_password">Confirm Password:<em>&nbsp;</em></label></td>
									<td align="left" >
									<input type="password" name="confirm_password" id="confirm_password" style="width:130px;"onkeyup="checkPass(); return false;">
									 <span id="confirmMessage" class="confirmMessage"></span>
									</td>
								</tr>
								<tr>
									<td align="center" colspan="2">
										<b><?php echo $ptitle; ?></b>
									</td>
								</tr>
								<tr>
									<td colspan="2" align="center" width="70px"><?php $arrt = array('name'=>'submit_login','id'=>'submit','value'=>'Update','class'=>'login_button'); echo form_submit($arrt);?></td>
									
								</tr>
								<tr><td colspan="2">&nbsp;</td></tr>
							</table>
						</td>
					</tr>
				</table>
		 
		 </div>
       
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