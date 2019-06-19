<div class="content">
    <div class="content_resize">
		<div class="mainbar">
			<div class="article">
				<h2><span><?php echo $title; ?></span> </h2>
				<p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
				<div class="clr"></div>
		  
				<?php 
				$attributes = array('target' => '_blank', 'id' => 'myform');
		  
				echo form_open(base_url().'index.php/report/reportView',$attributes);
				$Stylepadding = 'style="padding: 12px 20px;"';
				if(!empty($error_message))
				{
					$Stylepadding = 'style="padding:25px 20px;"';
				}	
				if(isset($captcha_image)){
					$Stylepadding = 'style="padding:62px 20px 93px;"';
				}
				?>
	
				<div class="img">
					<table style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
						<tr>
							<td>
								<table border="0" width="300px" align="center">
									<tr>
										<td align="right" colspan="2"></td>
									</tr>
									<tr><br />
										<td align="right" ><label for="rotation_no">Import Rotation No:<em>&nbsp;</em></label></td>
										<td align="left" >
										
											<?php 
												$attribute = array('name'=>'ddl_imp_rot_no','id'=>'txt_login','class'=>'login_input_text');
												echo form_input($attribute,set_value('ddl_imp_rot_no'));
											?>
										</td>
									</tr>					
									<tr>
										<td align="right" colspan="2"></td>
									</tr>										
									<tr align="left">										
										<td align="right" colspan="2">
										<!--<label for="rd1">Excel</label><input align="left" type="checkbox" name="myradio" value="1" <?php echo set_checkbox('myradio', '1'); ?> /><br/>-->
										<!--<label for="rd1">radio 2</label><input align="left" type="radio" name="myradio" value="2" <?php echo set_radio('myradio', '2'); ?> /><br/>-->
										<?php 
										/*$attribute = array(
													'name'        => 'newsletter',
													'id'          => 'newsletter',
													'value'       => 'XL',
													'checked'     => FALSE,
													'style'       => 'margin:10px',
													);

												echo form_radio($attribute);*/
									?>
										</td>
									</tr>										
									<tr>
										<td colspan="2" align="center" width="70px"><?php $arrt = array('name'=>'submit_login','id'=>'submit','value'=>'Show','class'=>'login_button'); echo form_submit($arrt);?></td>								
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