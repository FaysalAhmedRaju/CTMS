<script>
/*$(document).ready(function(){
	//alert("OK");
	if (window.XMLHttpRequest) 
			{
			  xmlhttp=new XMLHttpRequest();
			} 
			else 
			{  
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=stateChangeYardInfo;
			//xmlhttp.open("GET","<?php echo site_url('ajaxController/getAllBlockYard')?>",false);
			xmlhttp.open("GET","<?php echo site_url('ajaxController/getAllBlock')?>",false);			
			xmlhttp.send();
 });
 function stateChangeYardInfo()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			
			var val = xmlhttp.responseText;
			
		    //alert(val);
			
			var selectList=document.getElementById("search_yard");
			removeOptions(selectList);
			//alert(xmlhttp.responseText);
			var val = xmlhttp.responseText;
			var jsonData = JSON.parse(val);
			//alert(xmlhttp.responseText);
			for (var i = 0; i < jsonData.length; i++) 
			{
				var option = document.createElement('option');
				option.value = jsonData[i].block;  //value of option in backend
				option.text = jsonData[i].block;	  //text of option in frontend
				selectList.appendChild(option);
			}										
		}
	}
	 function removeOptions(selectbox)
		{
			var i;
			for(i=selectbox.options.length-1;i>=1;i--)
			{
				selectbox.remove(i);
			}
		}*/
		function validate()
      {
		  //alert("OK");
		if( document.myform.er_date.value == "" )
         {
            alert( "Please provide Date!" );
            document.myform.er_date.focus() ;
            return false;
         }
		 else{
			 return( true );
		 }
	  }
 </script>
<?php include("dbConection.php"); ?> 
<div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
		
		  <?php 
		  $attributes = array('target' => '_blank', 'id' => 'myform','name' => 'myform','onsubmit'=>'return validate()');
		  
		  echo form_open(base_url().'index.php/report/last24HoursERList',$attributes);
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
								<tr><br />
									<td align="left" ><label for="rotation_no">Date:</label></td>
									<td >
									<label>
										<?php 
											/*$attribute = array('name'=>'ddl_imp_rot_no','id'=>'txt_login','class'=>'login_input_text');
											echo form_input($attribute,set_value('ddl_imp_rot_no'));*/
										?>
										</label>
										<input type="text" style="width:120px;" id="er_date" name="er_date"> 
										<script>
											  $(function() {
												$( "#er_date" ).datepicker({
													changeMonth: true,
													changeYear: true,
													dateFormat: 'yy-mm-dd', // iso format
												});
											});
										</script>
									</td>
								</tr>
								<tr>
									<td align="left" ><label for=""><font color='red'></font>Shift :<em>&nbsp;</em></label></td>
									<td>
										<!--input type="text" style="width:150px;" id="search_value" name="search_value" disabled--> 
										<select name="search_shift" id="search_shift">
											<option style="width:110px;" value="all">--SELECT--</option>
											<option style="width:110px;" value="A">A</option>
											<option style="width:110px;" value="B">B</option>
											<option style="width:110px;" value="C">C</option>
										</select>
									</td>
								</tr>
								<tr>
									<td align="left" ><label for=""><font color='red'></font>Search Yard :<em>&nbsp;</em></label></td>
									<td>
										<!--input type="text" style="width:150px;" id="search_value" name="search_value" disabled--> 
										<select name="search_yard" id="search_yard">
											<option style="width:110px;" value="all">--SELECT--</option>
											<?php
											$sql_yard_list="select distinct block_cpa from ctmsmis.yard_block where block_cpa in('Y5','Y9','Y10')";
											//echo $sql_yard_list;
											$result_yard_list=mysql_query($sql_yard_list);
											while($yardList=mysql_fetch_object($result_yard_list))
											{
											?>
												<option value="<?php  echo $yardList->block_cpa; ?>"><?php echo $yardList->block_cpa; ?></option>
											<?php
											}
											?>
											<option value="y9ny10">Both Y9 & Y10</option>
										</select>
									</td>
								</tr>
								<tr>
									<td align="left">
									
										
										</td>
										<td>
										<table><tr>
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
													'checked'     => TRUE,
													'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
													);
										echo form_radio($data); ?>
										
									</td>
									</tr></table></td>
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
									<!--<td colspan="2" align="center" width="70px"><?php $arrt = array('name'=>'submit_login','id'=>'submit','value'=>'Download Excel for EDI','class'=>'login_button'); echo form_submit($arrt);?></td>-->
									<!--<a href="excelFormatForEdiConverter" target="_blank">Download Excel for EDI</a>-->
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