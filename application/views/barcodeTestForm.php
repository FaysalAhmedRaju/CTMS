<script>
	function enableCont()
	{
		if(document.myform.printType.value=="single")
		{
			//alert("gg");
			 document.getElementById("container_no2").disabled=true;
			 document.myform.container_no2.value="";
		}
		else if(document.myform.printType.value=="multiple")
		{
			//alert("ee");
			document.getElementById("container_no2").disabled=false;
		}
	}
	function validate()
      {
		  //alert("OK");
		 if( document.myform.contCat.value == "" )
         {
            alert( "Please Select Category!" );
            document.myform.contCat.focus() ;
            return false;
         }
		 else if( document.myform.printType.value == "" )
         {
            alert( "Please Select Print Type!" );
            document.myform.printType.focus() ;
            return false;
         }
		else if( document.myform.container_no.value == "" )
         {
            alert( "Please provide Container No!" );
            document.myform.container_no.focus() ;
            return false;
         }
		 else if( document.myform.truck_no.value == "" )
         {
            alert( "Please provide Truck Id!" );
            document.myform.truck_no.focus() ;
            return false;
         }
		 else if(document.myform.printType.value=="multiple")
		{
			//alert("ee");
			if(document.myform.container_no2.value == "")
			{
				alert( "Please provide Container 2!" );
				document.myform.container_no2.focus() ;
				return false;
			}
			else
			{
				return( true );
			}
			
		}
		 else{
			 return( true );
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
		
		  <?php 
		  $attributes = array('target' => '_blank', 'id' => 'myform','name' => 'myform','onsubmit'=>'return validate()');
		  
		  echo form_open(base_url().'index.php/report/generateBarcodePage',$attributes);
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
			 <table style="border:solid 1px #ccc;" width="300px" align="center" cellspacing="0" cellpadding="0">
				<tr><td>
				<table border="0" width="300px" align="center">
								<tr>
									<td align="right" colspan="2"></td>
								</tr>
								<tr>
									<td align="left" ><label for=""><font color='red'></font>Category :<em>&nbsp;</em></label></td>
									<td>
										<select style="width:120px;" name="contCat" id="contCat" >												
											<option value="">--SELECT--</option>
											<option value="import">IMPORT</option>
											<option value="export">EXPORT</option>
											<!--option value="storage">STORAGE</option-->
										</select>										
									</td>
								</tr>
								<tr>
									<td align="left" ><label for=""><font color='red'></font>Print Type :<em>&nbsp;</em></label></td>
									<td>
										<select name="printType" id="printType" style="width:120px;" onchange="enableCont()">												
											<option value="single">SINGLE</option>
											<option value="multiple">DOUBLE</option>
										</select>										
									</td>
								</tr>
								<tr><br />
									<td align="left" ><label for="rotation_no">Container No:</label></td>
									<td>
									<label>
										</label>
										<input type="text" style="width:120px;" id="container_no" name="container_no"> 
									</td>
								</tr>
								<tr><br />
									<td align="left" ><label for="rotation_no">Container No 2:</label></td>
									<td>
									<label>
										</label>
										<input type="text" style="width:120px;" id="container_no2" name="container_no2" disabled="true"> 
									</td>
								</tr>
								<tr>
									<td align="left" ><label for=""><font color='red'></font>Truck Id :<em>&nbsp;</em></label></td>
									<td>
										<input type="text" style="width:120px;" id="truck_no" name="truck_no" > 
										
									</td>
								</tr>
								<tr>
									<td align="left">										
										</td>
										<td>
										<table><tr>
											<!--td align="left">
												<label for="HTML" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">HTML</label>
												<?php 	$data = array(
															'name'        => 'options',
															'id'          => 'options',
															'value'       => 'html',
															'checked'     => TRUE,
															'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
															);
												echo form_radio($data); ?>
												
											</td-->
											<!--td align="left">
												<label for="HTML" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">PDF</label>
												<?php 	$data = array(
															'name'        => 'options',
															'id'          => 'options',
															'value'       => 'pdf',
															'checked'     => TRUE,
															'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
															);
												echo form_radio($data); ?>
												
											</td-->
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