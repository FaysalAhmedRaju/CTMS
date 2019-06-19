 
 <script type="text/javascript">
  $(function() {
    $("#equipment").change(function() {
        if ($(this).val() == "All") {
			//console.log(false);
            $("#srcVal").attr("disabled", "disabled");
        }
        else {
            //console.log(true);
            $("#srcVal").removeAttr("disabled");
        }
    });
});

 </script>
 <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
		  
		  <?php 
		  $attributes = array('target' => '_blank', 'id' => 'myform');
		  
		  echo form_open(base_url().'index.php/report/containerHandlingView',$attributes);
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
		 <table align="center" border ="0">		
						
						<tr>
					
							<br />
							<td align="right" ><label for="block">Search By:<em>&nbsp;</em></label></td>
							<td align="left" >
								<select class="login_input_text" name="equipment" id="equipment" >
									<option value="">--Select--</option>
									<option value="All">All</option>
									<option value="Equipment">Equipment</option>
									<option value="Yard">Yard</option>
								</select>					
									
							</td>
						</tr>	
						<tr>				
							<br />
							<td align="right" ><label for="block">Search Value:<em>&nbsp;</em></label></td>
							<td align="left" >
								<input type="text" id="srcVal" class="login_input_text" name="sVal" >
							</td>
						</tr>
						<tr>
					
							<br />
							<td align="right" ><label for="block">Select Shift:<em>&nbsp;</em></label></td>
							<td align="left" >
								<select class="login_input_text" name="shift" id="shift" >
									<option value="">--Select--</option>
									<option value="All">All</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
								</select>					
									
							</td>
						</tr>	
						<tr>					
							<br />
							<td align="right" ><label for="sDate">Search Date:<em>&nbsp;</em></label></td>
							<td align="left" >
								<input type="text" class="login_input_text" id="sDate" name="sDate">
								<script>
											  $(function() {
												$( "#sDate" ).datepicker({
													changeMonth: true,
													changeYear: true,
													dateFormat: 'yy-mm-dd', // iso format
												});
											});
									</script>
							</td>
						</tr>	
						
						<tr>
							
							<td colspan="2" align="center" width="70px"><br><?php $arrt = array('name'=>'report','id'=>'submit','value'=>'Show','class'=>'login_button'); echo form_submit($arrt);?>	
							
							</td>
							
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