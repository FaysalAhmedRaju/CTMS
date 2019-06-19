 
 
 <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
		  
		  <?php 
		  $attributes = array( 'id' => 'myform','enctype'=>'multipart/form-data');
		  
		  echo form_open(base_url().'index.php/report/EDIFileConverter',$attributes);
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
		 <table style="border:solid 1px #ccc;" width="500px" align="center" cellspacing="0" cellpadding="0" border="0">
			 <tr>
				<td>
					<table align="center" border ="0" width="100%" cellspacing="1" cellpadding="1" >	
					<?php 
					if($vsl) 
					{
						$len1=count($vsl);
						for($i=0;$i<$len1;$i++){
						?>
						<tr><td bgcolor="#94C5FD"><label for="rotation_no"><font color="white"><b>Rotaion No</b></font><em>&nbsp;</em></label></td><td colspan="2" bgcolor="#E5F7FD"><em>&nbsp;</em><label for="rotation_no"><?php echo $exp_no1 ?></label></td></tr>
						<tr><td bgcolor="#94C5FD"><label for="rotation_no"><font color="white"><b>Vessel Name</b></font><em>&nbsp;</em></label></td><td colspan="2" bgcolor="#E5F7FD"><em>&nbsp;</em><label for="rotation_no"><?php echo $vsl[$i]['vsl_name']; ?></label></td></tr>
						<tr><td bgcolor="#94C5FD"><label for="rotation_no"><font color="white"><b>Master Name</b></font><em>&nbsp;</em></label></td><td colspan="2" bgcolor="#E5F7FD"><em>&nbsp;</em><label for="rotation_no"><?php echo $vsl[$i]['master_name']; ?></label></td></tr>
						<tr><td bgcolor="#94C5FD"><label for="rotation_no"><font color="white"><b>Agent Code</b></font><em>&nbsp;</em></label></td><td colspan="2" bgcolor="#E5F7FD"><em>&nbsp;</em><label for="rotation_no"><?php echo $vsl[$i]['agent_code']; ?></label></td></tr>
						<tr><td bgcolor="#94C5FD"><label for="rotation_no"><font color="white"><b>Agent Name</b></font><em>&nbsp;</em></label></td><td colspan="2" bgcolor="#E5F7FD"><em>&nbsp;</em><label for="rotation_no"><?php echo $vsl[$i]['agent_name']; ?></label></td></tr>
						
						<?php
								
						} 
					}
					if($berth) {
					?>
					<tr ><td align="center" colspan="3"><label for="rotation_no"><font color="#3C7FD6" size="2"><b>Berthing Details:</b></font><em>&nbsp;</em></label></td></tr>
					<tr bgcolor="#94C5FD"><td align="center"><label for="rotation_no"><font color="white"><b>Berth Name</b></font><em>&nbsp;</em></label></td><td align="center"><label for="rotation_no"><font color="white"><b>ATA</b></font><em>&nbsp;</em></label></td><td align="center"><label for="rotation_no"><font color="white"><b>ATD</b></font><em>&nbsp;</em></label></td></tr>
					<?php
						
							$len=count($berth);
							 
							for($j=0;$j<$len;$j++){
							//$id=$berth[$j]['vsl_name'];
							//echo $id."2";
							?>
								<tr bgcolor="#E5F7FD" align="center">
									<td><label for="rotation_no"><?php echo $berth[$j]['berth']; ?></label></td>
									<td><label for="rotation_no"><?php echo $berth[$j]['ata']; ?></label></td>
									<td><label for="rotation_no"><?php echo $berth[$j]['atd']; ?></label></td>
								</tr>
							
							<?php
							
								}
							
							}
					?>
					</table>
				</td>
			 </tr>
				<tr><td>	 
		 <table align="center" border ="0">		
						<tr>
							<td colspan="4" align="center"><?php echo "<font color='red' size='2'><b>".$msg."</b></font><br/>" ;?><br/></td>
						</tr>
												
						<tr>
					
							<td><input type="hidden" name="exp_no" value="<?php echo $exp_no1; ?>"></td>
							<td align="right" ><label for="rotation_no">Select Your Excel File:<em>&nbsp;</em></label></td>
							
							<td colspan="2"   class="onlyTable1"><input type="file" name="fileToUpload" /></td>
							<td colspan="2" align="center" width="70px"><?php $arrt = array('name'=>'report','id'=>'submit','value'=>'Upload','class'=>'login_button'); echo form_submit($arrt);?>	</td>
							
							
						</tr>	
						
						<tr>
							
							<td align="right" ><em>&nbsp;</em></td>
							
						</tr>
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