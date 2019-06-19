 <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <span><?php echo $myUpdateManifestList; ?></span>
		  <div class="clr"></div>
		  
		  <?php 
		  $attributes = array('id' => 'myform');
		  //,'target'=>'_BLANK'
		  echo form_open(base_url().'index.php/report/oneStopIgmCertifyList',$attributes);
			$Stylepadding = 'style="padding: 12px 20px;"';
				if(!empty($error_message))
				{
					$Stylepadding = 'style="padding:25px 20px;"';
				}	
				if(isset($captcha_image)){
					$Stylepadding = 'style="padding:62px 20px 93px;"';
				}?>
	
		<div class="img">
		 	 <!--<div id="login_container">-->
		 <table style="border:solid 1px #ccc;" width="500px" align="center" cellspacing="0" cellpadding="0">
				<tr><td>	 
		 <table align="center" border=0>		
						
						<tr><td colspan="2"><font color="blue"><b><?php echo $msg; ?></b></font></td></tr>
						
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr align="center">
							
							
							<td align="right" ><label for="rotation_no">Container No:<em>&nbsp;</em></label></td>
							<td align="left" >
							<?php 
								$attribute = array('name'=>'ddl_imp_cont_no','id'=>'txt_login','class'=>'login_input_text' );
								echo form_input($attribute,set_value('ddl_imp_rot_no'));
								//'onblur'=> "alert();"
							?>
									
							</td>
						</tr>	
						<tr><td colspan="2" align="center"><font size="2" color="black"><b>Or</b></font></td></tr>
						<tr align="center">
							<br />
							
							<td align="right" ><label for="rotation_no">BL No:<em>&nbsp;</em></label></td>
							<td align="left" >
							<?php 
								$attribute = array('name'=>'ddl_imp_bl_no','id'=>'txt_login','class'=>'login_input_text' );
								echo form_input($attribute,set_value('ddl_imp_rot_no'));
								//'onblur'=> "alert();"
							?>
									
							</td>
						</tr>	
						
						<tr>
							<td colspan="2" align="center" width="70px"><br><?php $arrt = array('name'=>'report','id'=>'submit','value'=>'Search','class'=>'login_button'); echo form_submit($arrt);?>	
						</tr>
						<tr><td colspan="2">&nbsp;</td></tr>
				</table>
			</td>
		</tr>
	</table>

		 <!--</div>-->
		 </div>
         
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