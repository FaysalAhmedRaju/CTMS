
<script language="JavaScript">

</script>

<div class="content">
    <div class="content_resize_1">
      <div class="mainbar_1">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <span><?php echo $myUpdateManifestList; ?></span>
		  <div class="clr"><?php echo $msg?></div>
		  
		  <?php 
		  $attributes = array('target' => '_blank','id' => 'myform');
		  //,'target'=>'_BLANK'
		  echo form_open(base_url().'index.php/report/cartTicketPdf',$attributes);
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
		 <table style="border:solid 1px #ccc;" width="650px" align="center" cellspacing="0" cellpadding="0">
				<tr><td>	 
		 <table align="center" border=0>	
						<tr align="center">
							
							
							<td align="right" ><label for="rotation_no">Verification No:<em>&nbsp;</em></label></td>
							<td align="left" >
							<?php 
								$attribute = array('name'=>'verify_number','id'=>'txt_login','class'=>'login_input_text' );
								echo form_input($attribute,set_value('verify_number'));
								//'onblur'=> "alert();"
							?>
									
							</td>
						
							<!--td align="right" ><label for="rotation_no">BL No:<em>&nbsp;</em></label></td>
							<td align="left" >
							<?php 
								$attribute = array('name'=>'ddl_bl_no','id'=>'txt_login','class'=>'login_input_text' );
								echo form_input($attribute,set_value('ddl_bl_no'));
								//'onblur'=> "alert();"
							?>
									
							</td-->
						
							<td colspan="2" align="center" width="70px">
							<?php $arrt = array('name'=>'report','id'=>'submit','value'=>'Search','class'=>'login_button'); echo form_submit($arrt);?>	
							</td>
						</tr>
				</table>
			</td>
		</tr>
		<tr><td align="center" colspan="2"><font color=""><b>
		</b></font></td></tr>
		<!--TR align="center"><TD colspan="6" ><h2><span ><?php echo "Verify No: ".$verify_num; ?></span> </h2></TD></TR-->
	</table>
	<?php echo form_close()?>
	<?php
/*****************************************************
Developed BY: Sourav Chakraborty
Software Developer
DataSoft Systems Bangladesh Ltd
******************************************************/

$_SESSION['Control_Panel']=$this->session->userdata('Control_Panel');

?>

<div style="width:100%; height:500px; overflow-y:auto;">
</div>


		 <!--</div>-->
		 </div>
         
		  </form>
          <div class="clr"></div>
        </div>
       
       <!-- <p class="pages"><small>Page 1 of 2</small> <span>1</span> <a href="#">2</a> <a href="#">&raquo;</a></p>-->
      </div>
      <div class="sidebar" >
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	
  </div>