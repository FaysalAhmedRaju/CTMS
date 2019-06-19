<script>
    function getAllBlock()
	{	
     // alert("ok");	
		if (window.XMLHttpRequest) 
		{

		  xmlhttp=new XMLHttpRequest();
		} 
		else 
		{  
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=stateChangeYardInfo;
		xmlhttp.open("GET","<?php echo site_url('ajaxController/getAllBlockYard')?>",false);
					
		xmlhttp.send();
	}
	
	
	function stateChangeYardInfo()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			var val = xmlhttp.responseText;
			
		   // alert(val);
			var selectList=document.getElementById("block");
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
		}
 
</script>
<html>
<body onload="getAllBlock()">
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
				  
				  echo form_open(base_url().'index.php/report/blockWiseRotationView',$attributes);
					$Stylepadding = 'style="padding: 12px 20px;"';
						if(!empty($error_message))
						{
							$Stylepadding = 'style="padding:25px 20px;"';
						}	
						if(isset($captcha_image)){
							$Stylepadding = 'style="padding:62px 20px 93px;"';
						}?>
				<table align="center" style="border:solid 1px #ccc;" width="550px" align="center" cellspacing="0" cellpadding="0">
	
				<tr><td>
				<table border="0" width="500px" align="center">
								<tr>
									
									<td align="center" ><label><font color='red'><b>*</b></font>Rotation:</label></td>
									<td> 
										<input type="text" style="width:120px;" id="rotNo" name="rotNo" value=""/>
									</td>									
									
								</tr>	
								<tr>
									<td align="center" ><label><font color='red'><b>*</b></font>Block No:</label></td>
										<td>
											<select  style="width:120px;" name="block" id="block">
												<option value="">---Select---</option>	
											</select>
										</td>
								</tr>
								<tr>
									<td align="left">
									
										
										</td>
										<td>
										<table><tr>
										<td align="left">
										<label for="Excel" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">PDF</label>
									<?php 	$data = array(
													'name'        => 'options',
													'id'          => 'options',
													'value'       => 'pdf',
													'checked'     => TRUE,
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
</body>
</html>
  		