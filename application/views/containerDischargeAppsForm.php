<script>
 $(document).ready(function(){
	search_value.value="";
	search_value.disabled=true;
 });
 function changeTextBox(v)
    {
		var search_value = document.getElementById("search_value");
		var fromdate = document.getElementById("fromdate");
		var todate = document.getElementById("todate");
		var fromTime = document.getElementById("fromTime");
		var toTime = document.getElementById("toTime");
		if(v=="yard")
		{
			//search_value.value="";
			fromdate.value="";
			todate.value="";
			fromTime.value="";
			toTime.value="";
			
			search_value.disabled=false;
			fromdate.disabled=false;
			todate.disabled=false;
			fromTime.disabled=true;
			toTime.disabled=true;
			
			if (window.XMLHttpRequest) 
			{
			  xmlhttp=new XMLHttpRequest();
			} 
			else 
			{  
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=stateChangeYardInfo;
			xmlhttp.open("GET","<?php echo site_url('ajaxController/getAllYard')?>",false);
						
			xmlhttp.send();
		
		}	
		else if(v=="dateRange")
		{
			search_value.value="";
			
			fromdate.value="";
			todate.value="";
			fromTime.value="";
			toTime.value="";
			
			fromdate.disabled=false;
			todate.disabled=false;
			fromTime.disabled=true;
			toTime.disabled=true;
			search_value.disabled=true;
		}
		else if(v=="dateTime")
		{
			search_value.value="";
			
			fromdate.value="";
			todate.value="";
			fromTime.value="";
			toTime.value="";
			
			fromdate.disabled=false;
			todate.disabled=false;
			fromTime.disabled=false;
			toTime.disabled=false;
			search_value.disabled=true;	
		}
		else{
			search_value.value="";
			fromdate.value="";
			todate.value="";
			fromTime.value="";
			toTime.value="";
			search_value.disabled=true;
			fromdate.disabled=true;
			todate.disabled=true;
			fromTime.disabled=true;
			toTime.disabled=true;
			
		}
		
    }
	function stateChangeYardInfo()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			
			var val = xmlhttp.responseText;
			
		    //alert(val);
			
			var selectList=document.getElementById("search_value");
			removeOptions(selectList);
			//alert(xmlhttp.responseText);
			var val = xmlhttp.responseText;
			var jsonData = JSON.parse(val);
			//alert(xmlhttp.responseText);
			for (var i = 0; i < jsonData.length; i++) 
			{
				var option = document.createElement('option');
				option.value = jsonData[i].current_position;  //value of option in backend
				option.text = jsonData[i].current_position;	  //text of option in frontend
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
	function validate()
      {
		  //alert("OK");
		if( document.myform.ddl_imp_rot_no.value == "" )
         {
            alert( "Please provide Rotation!" );
            document.myform.ddl_imp_rot_no.focus() ;
            return false;
         }
		 if( document.myform.search_by.value == "" )
         {
            alert( "Please provide Search By!" );
            document.myform.search_by.focus() ;
            return false;
         }
		  if( document.myform.search_by.value == "yard" )
         {
             if( document.myform.search_value.value == "" )
			 {
				alert( "Please provide Search Value!" );
				document.myform.search_value.focus() ;
				return false;
			 }
			 else
			 {
				return( true ); 
			 }
         }
		  if( document.myform.search_by.value == "dateRange" )
         {
             if( document.myform.fromdate.value == "" || document.myform.todate.value == "")
			 {
				alert( "Please provide Search Date!" );
				//document.myform.search_by.focus() ;
				return false;
			 }
			 else
			 {
				return( true ); 
			 }
         }
		  if( document.myform.search_by.value == "dateTime" )
         {
             if( document.myform.fromdate.value == "" || document.myform.todate.value == "" || document.myform.fromTime.value == "" || document.myform.toTime.value == "")
			 {
				alert( "Please provide Search Date & Time!" );
				//document.myform.search_by.focus() ;
				return false;
			 }
			 else
			 {
				return( true ); 
			 }
         }
		
         return( true );
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
		  $attributes = array('target' => '_blank', 'id' => 'myform','name' => 'myform');
		  
		  echo form_open(base_url().'index.php/report/containerDischargeAppsList',$attributes);
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
									<td align="left" ><label for="rotation_no">Import Rotation No:</label></td>
									<td >
									<label>
										<?php 
											/*$attribute = array('name'=>'ddl_imp_rot_no','id'=>'txt_login','class'=>'login_input_text');
											echo form_input($attribute,set_value('ddl_imp_rot_no'));*/
										?>
										</label>
										<input type="text" style="width:120px;" id="ddl_imp_rot_no" name="ddl_imp_rot_no"> 
									</td>
								</tr>
								<tr>
									<td align="left" >
									<label for=""><font color='red'></font>Search By :<em>&nbsp;</em></label></td>
									<td>
									        <select name="search_by" id="search_by" class="" onchange="changeTextBox(this.value);">
												<option value="all" label="search_by" selected style="width:110px;">--Select--</option>
												<option value="yard" label="Yard" >YARD</option>
												<option value="dateRange" label="DateRange" >DATE</option>												
												<option value="dateTime" label="DateTime" >DATETIME</option>												
											</select>

									</td>
								</tr>
								 <tr>
									<td align="left" ><label for=""><font color='red'></font>Search Yard :<em>&nbsp;</em></label></td>
									<td>
										<!--input type="text" style="width:150px;" id="search_value" name="search_value" disabled--> 
										<select name="search_value" id="search_value">
											<option  style="width:110px;">--Select--</option>
										</select>
									</td>
									<!--td align="left" ><label for=""><font color='red'></font>Search value :<em>&nbsp;</em></label></td>
									<td>
									<input type="text" style="width:150px;" id="search_value" name="search_value" disabled> 
									</td-->
								</tr>	
								<tr>
									
									<td align="left" ><label><font color='red'><b>*</b></font>From Date:</label>
											<td> 
											<input type="text" style="width:120px;" id="fromdate" name="fromdate" value="<?php date("Y-m-d"); ?>"/>
											</td>
								
											<script>
											  $(function() {
												$( "#fromdate" ).datepicker({
													changeMonth: true,
													changeYear: true,
													dateFormat: 'yy-mm-dd', // iso format
												});
											});
									</script>
									</td>
									
									<td align="left"><label><font color='red'><b>*</b></font>From Time:</label>
									<input type="text" style="width:120px;" id="fromTime" name="fromTime"> (HH:MM)(24 hrs)
									</td>
								</tr>
									<tr>
									<td align="left" ><label><font color='red'><b>*</b></font>To Date:
									<td ><input type="text" style="width:120px;" id="todate" name="todate" value="<?php date("Y-m-d"); ?>"/></td>
									</label> 
									<script>
											  $(function() {
												$( "#todate" ).datepicker({
													changeMonth: true,
													changeYear: true,
													dateFormat: 'yy-mm-dd', // iso format
												});
											});
									</script>
									</td>
									<td align="left"><label><font color='red'><b>&nbsp;&nbsp;  *</b></font>  To Time        :</label>
									<input type="text" style="width:120px;" id="toTime" name="toTime"> (HH:MM)(24 hrs)
									</td>
									</tr>
																		
								<tr>
									<td align="right" colspan="3"></td>
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
				
				<table>
					<tr class="gridDark">
						<th>SL</th>
						<th>Container</th>
						<th>Rotation</th>
						<th>MLO</th>
						<th>ISO</th>
						<th>Status</th>
						<th><nobr>Disch Time</nobr></th>
						<th><nobr>Yard Pos</nobr></th>
						<th>Destination</th>
						<th>User Id</th>
					</tr>
					<?php
					$lenth = count($rtnAllList);
					for($i=0;$i<$lenth;$i++)
					{
					?>
					<tr class="gridLight">
						<td><?php echo $i+1;?></td>
						<td><?php echo $rtnAllList[$i]['id']?></td>
						<td><?php echo $rtnAllList[$i]['rotation']?></td>
						<td><?php echo $rtnAllList[$i]['mlo']?></td>
						<td><?php echo $rtnAllList[$i]['iso']?></td>
						<td><?php echo $rtnAllList[$i]['freight_kind']?></td>
						<td><nobr><?php echo $rtnAllList[$i]['last_update']?></nobr></td>
						<td><?php echo $rtnAllList[$i]['current_position']?></td>
						<td><?php echo $rtnAllList[$i]['destination']?></td>
						<td><?php echo $rtnAllList[$i]['user_id']?></td>
					</tr>
					<?php
					}
					?>
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