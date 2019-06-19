<script language="JavaScript">
function changeField() 
{	
	var serch_by = document.getElementById('serch_by').value;
	document.getElementById('serch_value').value="";
	/*alert(serch_by);*/
	if(serch_by=="offdoc" || serch_by=="pod")
	{
		document.getElementById('gen').style.display="none";
		document.getElementById('combo').style.display="inline";		
		if (window.XMLHttpRequest) 
		{
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} 
		else 
		{  
			// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=stateChangeValue;
		xmlhttp.open("GET","<?php echo site_url('ajaxController/ajaxValue')?>?serch_by="+serch_by,false);
		xmlhttp.send();
	}
	else
	{
		document.getElementById('gen').style.display="inline";
		document.getElementById('combo').style.display="none";
	}	  
}

function stateChangeValue()
{
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
      var selectList=document.getElementById("serch_combo");
	  removeOptions(selectList);
	  var val = xmlhttp.responseText;
	  var jsonData = JSON.parse(val);
	  //alert(jsonData.length);
		for (var i = 0; i < jsonData.length; i++) 
		{
			var option = document.createElement('option');
			option.value = jsonData[i].id;
			option.text = jsonData[i].name;
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
		  $attributes = array('target' => '_blank', 'id' => 'myform');
		  
		  echo form_open(base_url().'index.php/report/myAgentWiseContainerStatusReport',$attributes);
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
				<tr>
					<td>
				<table border="0" width="450px" align="center">
					<tr>
						<td align="right" colspan="2"></td>
					</tr>			
									
									<tr>
										<td><label for="field3"><font color='red'><b>*</b></font>Search Crieteria:</label></td>
										<td>
											<select name="serch_by" id="serch_by" onchange="changeField()" required>
												<option value="" selected style="width:130px;">Select</option>
												<option value="rot">Rotation</option>
												<option value="cont">CONTAINER</option>
												<option value="mlo">MLO</option>
												<option value="offdoc">OFF-DOC</option>
												<option value="pod">POD</option>
										</select>
										</td>
									</tr>
									<tr>										
										<td align="left" ><label><font color='red'><b>*</b></font>Search Value</label>
										<td>
											<div id="gen">
												<input type="text" name="serch_value" id="serch_value" style="width:150px;">	
											</div>
											<div id="combo" style="display:none;">
												<select name="serch_combo" id="serch_combo" class="">
													<option value="" selected style="width:130px;">Select</option>
												</select>	
											</div>
										</td>
										</td>
									</tr>
								<tr>
									<td align="right" colspan="2"></td>
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
													'checked'     => FALSE,
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