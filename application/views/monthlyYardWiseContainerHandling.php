<div class="content" >
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
			<h2><span><?php echo $title; ?></span> </h2>
			<p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
			<div class="clr"></div>
			<div class="img">
		<table>
		<tr>	
			
			<td>
				 <?php 
				  $attributes = array('target' => '_blank', 'id' => 'myform','name' => 'myform','onsubmit'=>'return validate()');
				  
				  echo form_open(base_url().'index.php/report/monthlyYardWiseContainerHandlingView',$attributes);
					$Stylepadding = 'style="padding: 12px 20px;"';
						if(!empty($error_message))
						{
							$Stylepadding = 'style="padding:25px 20px;"';
						}	
						if(isset($captcha_image)){
							$Stylepadding = 'style="padding:62px 20px 93px;"';
						}?>
				<table style="border:solid 1px #ccc;" width="400px" align="center" cellspacing="0" cellpadding="0">
	
				<tr><td>
				<table border="0" width="300px" align="center">
								<tr>
									
									<td align="center" ><label><font color='red'><b>*</b></font>From Date:</label>	</td>
									<td> 
										<input type="text" style="width:120px;" id="fromDate" name="fromDate" value="<?php date("Y-m-d"); ?>"/>
										<script>
											  $(function() {
												$( "#fromDate" ).datepicker({
													changeMonth: true,
													changeYear: true,
													dateFormat: 'yy-mm-dd', // iso format
												});
											});
									</script>
									</td>									
									
								</tr>	
								<tr>
									
									<td align="center" ><label><font color='red'><b>*</b></font>To Date:</label></td>
									<td> 
										<input type="text" style="width:120px;" id="toDate" name="toDate" value="<?php date("Y-m-d"); ?>"/>
										
										<script>
											  $(function() {
												$( "#toDate" ).datepicker({
													changeMonth: true,
													changeYear: true,
													dateFormat: 'yy-mm-dd', // iso format
												});
											});
									</script>
									
									</td>
								</tr>								
								<tr>
									<td colspan="2" align="center" width="70px"><?php $arrt = array('name'=>'submit_login','id'=>'submit','value'=>'Show','class'=>'login_button'); echo form_submit($arrt);?></td>
									<!--<td colspan="2" align="center" width="70px"><?php $arrt = array('name'=>'submit_login','id'=>'submit','value'=>'Download Excel for EDI','class'=>'login_button'); echo form_submit($arrt);?></td>-->
									<!--<a href="excelFormatForEdiConverter" target="_blank">Download Excel for EDI</a>-->
								</tr>
								<tr><td colspan="2">&nbsp;</td></tr>
							</table>
						</td>
					</tr>
				</table>
				<?php echo form_close()?>
			</td>

		 </tr>
		</table>
		</div>
		<div class="clr"></div>
	</div>
       
       <!-- <p class="pages"><small>Page 1 of 2</small> <span>1</span> <a href="#">2</a> <a href="#">&raquo;</a></p>-->
      </div>
      <div class="sidebar" >
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	<?php// echo form_close()?>
  </div>

  		