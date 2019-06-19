<script>

	function validate()
      {
		  //alert("OK");
		if( document.myform.work_date.value == "" )
         {
            alert( "Please provide Date!" );
            document.myform.work_date.focus() ;
            return false;
         }
		 else if( document.myform.rotation_no.value == "" )
         {
            alert( "Please provide Rotation No!" );
            document.myform.rotation_no.focus() ;
            return false;
         }
		 else{
			 return( true );
		 }
	  }
 </script>
 <?php if($_POST['options']=='html'){?>
 	<?php } 
	else if($_POST['options']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=Export_Container_Gate_In.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}
	
	?>
<div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
		
		  <?php 
		  $attributes = array('target' => '_blank', 'id' => 'myform','name' => 'myform','onsubmit'=>'return validate()');
		  
		  echo form_open(base_url().'index.php/report/exportContainerGateInList',$attributes);
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
			 <table style="border:solid 1px #ccc;" width="450px" align="center" cellspacing="0" cellpadding="0">
				<tr><td>
				<table border="0" width="650px" align="center">
								<tr>
									<td align="right" colspan="2"></td>
								</tr>
								<tr>
									<td align="right" ><label for=""><font color='red'></font>Rotation :<em>&nbsp;</em></label></td>
									<td>
										<input type="text" style="width:150px;" id="rotation_no" name="rotation_no" > 
										
									</td>
								</tr>
								<tr>
									<td align="left">										
										</td>
										<td>
										<table><tr>
										<td align="left">
										<label for="Excel" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">EXCEL</label>
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
													'checked'     => TRUE,
													'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
													);
										echo form_radio($data); ?>
										
									</td>
									<td align="left">
										<label for="HTML" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">PDF</label>
										<?php 	$data = array(
													'name'        => 'options',
													'id'          => 'options',
													'value'       => 'pdf',
													'checked'     => FALSE,
													'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
													);
										echo form_radio($data); ?>
										
									</td>
									</tr></table></td>
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
      </div>
      <div class="sidebar">
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	<?php echo form_close()?>
  </div>