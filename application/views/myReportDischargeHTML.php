 <?php if(substr($_SERVER['REMOTE_ADDR'],0,7)=="192.168" or substr($_SERVER['REMOTE_ADDR'],0,4)=="10.1") { ?>
 <script type="text/javascript" src="<?php echo JS_PATH; ?>getagentlocal.js"> </script>
 <?php } else { ?>
 <script type="text/javascript" src="<?php echo JS_PATH; ?>getagent.js"> </script>
 <?php } ?>
 
 <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
		  
		  <?php 
		  $attributes = array('target' => '_blank', 'id' => 'myform');
		  
		  echo form_open(base_url().'index.php/report/myDischargeListView',$attributes);
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
						
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr align="center">
							<br />
							
							<td align="right" ><label for="rotation_no">Import Rotation No:<em>&nbsp;</em></label></td>
							<td align="left" >
							<?php 
								$attribute = array('name'=>'ddl_imp_rot_no','id'=>'txt_login','class'=>'login_input_text','onblur'=> "myshowAgent(this);" );
								echo form_input($attribute,set_value('ddl_imp_rot_no'));
							?>
									
							</td>
						</tr>	
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr>
						
							<td id="lbl_line" align="right">Organization Name:</td>
							<td>
								<div id="line_no" ></div>
							</td>
						</tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr>
							<td id="lbl_line"  align="right">MLO Code:</td>
							<td>
								<div id="igm"></div>
							</td>
						</tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr>
									
									<td align="left">
									<label for="Excel" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Excel</label>
									<?php 	$data = array(
													'name'        => 'options',
													'id'          => 'options',
													'value'       => 'xl',
													'checked'     => FALSE,
													'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
													);
										echo form_radio($data); ?>
										
										</td>
										<td align="left">
										<label for="HTML" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">HTML</label>
										<?php 	$data = array(
													'name'        => 'options',
													'id'          => 'options',
													'value'       => 'html',
													'checked'     => FALSE,
													'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
													);
										echo form_radio($data); ?>
										
									</td>
								</tr>
	
						<!--<tr>
							<td colspan="2">Excl<input type="radio" name="options" value="xl">&nbsp;HTML<input type="radio" name="options" value="html"></td>
						</tr>-->
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr>
							<td colspan="2" align="center" width="70px"><br><?php $arrt = array('name'=>'report','id'=>'submit','value'=>'Show','class'=>'login_button'); echo form_submit($arrt);?>	
						</tr>
						<tr><td colspan="2">&nbsp;</td></tr>
				</table>
			</td>
		</tr>
	</table>

		 <!--</div>-->
		 </div>
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