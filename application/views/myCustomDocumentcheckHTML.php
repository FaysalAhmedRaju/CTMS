<div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
			<div class="img">
			<table style="border:solid 1px #ccc;" width="500px" align="center" cellspacing="0" cellpadding="0">
				<tr><td>	
			<TABLE width="100%" border="0" align="center">
			 <?php 
			$attributes=array('target' =>'_blank');
			echo form_open(base_url().'index.php/igmViewController/checkTheIGMList',$attributes);
			$Stylepadding = 'style="padding: 12px 20px;"';
				if(!empty($error_message))
				{
					$Stylepadding = 'style="padding:25px 20px;"';
				}	
				if(isset($captcha_image)){
					$Stylepadding = 'style="padding:62px 20px 93px;"';
				}?>
			<!--<form name="frm2" action="home.php?myflag=136" method="post"  >-->
		
			<TR>
				<TD>
				<table border="0" class="hptxtnormal" align="center">		
						
					<tr>
						<td colspan="4" bgColor="#7ea4d4" class="hptxtnormal" style="COLOR: white; FONT-WEIGHT: bold">Please enter following information.</td>
					</tr>
				</table>
				</TD>
			</TR>
			<TR>
				<TD>
			
				<table border="0" bgcolor="#F2ECA6" align="center">
				
					<tr>
						<td align="left"><label for="rotation_no">Import Rotation No:<em>&nbsp;</em></label></td>
						<td>
						<?php 
							$attribute = array('name'=>'txt_imp_rot','id'=>'txt_imp_rot','class'=>'login_input_text' );
							echo form_input($attribute,set_value('txt_imp_rot'));
							//'onblur'=> "alert();"
						?>
						</td>
					</tr>
					<tr>
					</tr>
					<tr>
						<td align="left"><label for="rotation_no">Line No:<em>&nbsp;</em></label></td>
						<td>
						<?php 
							$attribute = array('name'=>'txt_line','id'=>'txt_line','class'=>'login_input_text' );
							echo form_input($attribute,set_value('txt_line'));
							//'onblur'=> "alert();"
						?>
						</td>
					</tr>
					
				</table>
				<br>
				<font color="red" size="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OR</font>
				<br><br>
				<table border="0" bgcolor="#8BA7CC" align="center">
					<tr>
						<td align="left"><label for="rotation_no">Import Rotation No:<em>&nbsp;</em></label></td>
						<td>
						<?php 
							$attribute = array('name'=>'txt_imp_rot1','id'=>'txt_imp_rot1','class'=>'login_input_text' );
							echo form_input($attribute,set_value('txt_imp_rot1'));
							//'onblur'=> "alert();"
						?>
						</td>
					</tr>
					<tr>
						<td align="left"><label for="rotation_no">BL No:<em>&nbsp;</em></label></td>
						<td>
						<?php 
							$attribute = array('name'=>'txt_bl','id'=>'txt_bl','class'=>'login_input_text' );
							echo form_input($attribute,set_value('txt_bl'));
							//'onblur'=> "alert();"
						?>
						</td>
					</tr>
					
					
				</table>
				<br>
				<table align="center">
				<tr>
						<td colspan="2">
							<?php $arrt = array('name'=>'Add','id'=>'submit','value'=>'OK','class'=>'login_button'); echo form_submit($arrt);?>
						</td>
					</tr>
				</table>
				</TD>
			</TR>
							
		<?php echo form_close()?>
		</TABLE>
			</td></tr></table>
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