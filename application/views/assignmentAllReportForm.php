 <script>
	// MIS start
	function validate2()
	{
		if(document.misassignment.date.value == "")
		{
			alert( "Please provide date!" );
			document.misassignment.date.focus() ;
			return false;
		}
		else if(document.misassignment.terminal.value == "")
		{
			alert( "Please provide terminal!" );
			document.misassignment.terminal.focus() ;
			return false;
		}
	}
	
	function changeterminal(terminal)
	{
		if( document.misassignment.date.value == "" )
		{
			alert( "Please provide date then select!" );
			document.misassignment.date.focus() ;
			return false;
		}
		else
		{	
			if(terminal=="")
			{
				yard.disabled=true;
				assigntype.disabled=true;
			}
			else if(terminal=="CCT" || terminal=="NCT")
			{
				yard.disabled=true;
				assigntype.disabled=false;
				getAssignment();
			}
			else if(terminal=="GCB")
			{
				yard.disabled=false;
				assigntype.disabled=false;				
				getAssignment();
				getBlock2();
			}
		}
	}
	
	function getAssignment()
	{
		if (window.XMLHttpRequest) 
		{
		  xmlhttp=new XMLHttpRequest();
		} 
		else 
		{  
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		var assignDt = document.misassignment.date.value;
		var terminal=document.getElementById("terminal").value;
		var url = "<?php echo site_url('ajaxController/getAssignmentType')?>?terminal="+terminal+"&assignDt="+assignDt;
		//alert(url);
		xmlhttp.onreadystatechange=stateChangeAssignment;
		xmlhttp.open("GET",url,false);
					
		xmlhttp.send();
	}
	
	function stateChangeAssignment()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			var val = xmlhttp.responseText;
			//alert(val);
			var selectList=document.getElementById("assigntype");
			removeOptions(selectList);
			
			var val = xmlhttp.responseText;
			var jsonData = JSON.parse(val);
		//	alert(jsonData[0].mfdch_value);
			for (var i = 0; i < jsonData.length; i++) 
			{
				var option = document.createElement('option');
				option.value = jsonData[i].mfdch_value;  //value of option in backend
				option.text = jsonData[i].mfdch_desc;	  //text of option in frontend
				selectList.appendChild(option);
			}										
		}
	}
	
	function getBlock2()
	{
		if (window.XMLHttpRequest) 
		{
			xmlhttp=new XMLHttpRequest();
		} 
		else 
		{  
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		var terminal=document.getElementById("terminal").value;
		xmlhttp.onreadystatechange=stateChangeLoadBlock;
		xmlhttp.open("GET","<?php echo site_url('ajaxController/loadBlock')?>?terminal="+terminal,false);
					
		xmlhttp.send();
	}
	
	function stateChangeLoadBlock()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			var val = xmlhttp.responseText;
			
			var selectList=document.getElementById("yard");
			removeOptions(selectList);
			
			var val = xmlhttp.responseText;
			var jsonData = JSON.parse(val);
			
			for (var i = 0; i < jsonData.length; i++) 
			{
				var option = document.createElement('option');
				option.value = jsonData[i].Block_No;  //value of option in backend
				option.text = jsonData[i].Block_No;	  //text of option in frontend
				selectList.appendChild(option);
			}										
		}
	}
	
	function onblockchange()
	{
		if (window.XMLHttpRequest) 
		{
		  xmlhttp=new XMLHttpRequest();
		} 
		else 
		{  
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		var assignDt = document.misassignment.date.value;
	//	var terminal=document.getElementById("terminal").value;
		var terminal=document.misassignment.terminal.value;
	//	var yard=document.getElementById("yard").value;
		var yard=document.misassignment.yard.value;
		var url = "<?php echo site_url('ajaxController/onblockchange')?>?terminal="+terminal+"&assignDt="+assignDt+"&yard="+yard;
	
		xmlhttp.onreadystatechange=stateChangeBlock;
		xmlhttp.open("GET",url,false);
					
		xmlhttp.send();
	}
	
	function stateChangeBlock()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			var val = xmlhttp.responseText;
			//alert(val);
			var selectList=document.getElementById("assigntype");
			removeOptions2(selectList);
			
			var val = xmlhttp.responseText;
			var jsonData = JSON.parse(val);
			
			for (var i = 0; i < jsonData.length; i++) 
			{
				var option = document.createElement('option');
				option.value = jsonData[i].mfdch_value;  //value of option in backend
				option.text = jsonData[i].mfdch_desc;	  //text of option in frontend
				selectList.appendChild(option);
			}										
		}
	}
	
	function removeOptions2(selectbox)
	{
		var i;
		for(i=selectbox.options.length-1;i>=1;i--)
		{
			selectbox.remove(i);
		}
	}
	//MIS end
	
	
    function getBlock(yard)
	{		
		if (window.XMLHttpRequest) 
		{

		  xmlhttp=new XMLHttpRequest();
		} 
		else 
		{  
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=stateChangeYardInfo;
		xmlhttp.open("GET","<?php echo site_url('ajaxController/getBlock')?>?yard="+yard,false);
					
		xmlhttp.send();
	}
	
	
	function stateChangeYardInfo()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			
			var val = xmlhttp.responseText;
			
		    //alert(val);
			
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
 
 /*
  function blockList() {
   
    $.getJSON('<?php echo site_url('ajaxController/getBlock')?>?yard='+yard, {yardName:$('#yard_no').val()}, function(data) {

        var select = $('#block');
        var options = select.prop('options');
        $('option', select).remove();

        $.each(data, function(index, array) {
            options[options.length] = new Option(array['variety']);
        });

    });

}

$(document).ready(function() {
	
	blockList();
	$('#yard_no').change(function() {
		blockList();
	});
	
});
 
 
 */
 
	function rtnFuncAss(val)
		{
			//alert(val);
			if(val=="assign1")
			{
				document.getElementById("fromdate1").disabled=false;
				document.getElementById("todate1").disabled=true;
				document.getElementById("todate1").disabled=true;
				document.getElementById("yard_no1").disabled=false;
				document.getElementById("container1").disabled=true;
			}		
			else if(val=="deli1")
			{
				document.getElementById("fromdate1").disabled=false;
				document.getElementById("todate1").disabled=false;
				document.getElementById("yard_no1").disabled=false;
				document.getElementById("container1").disabled=true;
			}
			else if(val=="cont1")
			{
				document.getElementById("fromdate1").disabled=true;
				document.getElementById("todate1").disabled=true;
				document.getElementById("yard_no1").disabled=true;
				document.getElementById("container1").disabled=false;
			}
			else
			{
				document.getElementById("fromdate1").disabled=false;
				document.getElementById("todate1").disabled=false;
				document.getElementById("yard_no1").disabled=true;
				document.getElementById("container1").disabled=true;
			}
		}
 
 
	function rtnFunc(val)
	{
		//alert(val);
		if(val=="assign")
		{
			document.getElementById("fromdate").disabled=false;
			document.getElementById("todate").disabled=true;
			document.getElementById("yard_no").disabled=false;
			document.getElementById("block").disabled=false;
			document.getElementById("container").disabled=true;
		}		
		else if(val=="deli")
		{
			document.getElementById("fromdate").disabled=false;
			document.getElementById("todate").disabled=false;
			document.getElementById("yard_no").disabled=false;
			document.getElementById("block").disabled=false;
			document.getElementById("container").disabled=true;

		}
		else if(val=="cont")
		{
			document.getElementById("fromdate").disabled=true;
			document.getElementById("todate").disabled=true;
			document.getElementById("yard_no").disabled=true;
			document.getElementById("block").disabled=true;
			document.getElementById("container").disabled=false;		
		}
		else
		{
			document.getElementById("fromdate").disabled=false;
			document.getElementById("todate").disabled=false;
			document.getElementById("yard_no").disabled=true;
			document.getElementById("block").disabled=true;			
			document.getElementById("container").disabled=true;
		}
	}
	
	function validation()
	{
		if( document.cont_search.assignment.value == "" )
		{
			alert( "Please provide assignment date!" );
			document.cont_search.assignment.focus() ;
			return false;
		}
				
		if( document.cont_search.ddl_imp_cont_no.value == "" )
		{
			alert( "Please provide container!" );
			document.cont_search.ddl_imp_cont_no.focus() ;
			return false;
		}
		return true ;
	}
	
	//Head Delivery Register Report start
	function updatetable(regblock)
	{
	//	alert(regblock);
		if (window.XMLHttpRequest) 
		{
		  xmlhttp=new XMLHttpRequest();
		} 
		else 
		{  
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		var date=document.getElementById("regdate").value;
		
		var url = "<?php echo site_url('ajaxController/updatetable')?>?date="+date+"&regblock="+regblock;
		//alert(url);
		xmlhttp.onreadystatechange=stateChangeTable;
		xmlhttp.open("GET",url,false);
					
		xmlhttp.send();
	}
	
	function stateChangeTable()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			var val = xmlhttp.responseText;
			
			var selectList=document.getElementById("regassigntype");
			removeOptions(selectList);
			
			var val = xmlhttp.responseText;
			var jsonData = JSON.parse(val);
			
			for (var i = 0; i < jsonData.length; i++) 
			{
				var option = document.createElement('option');
				option.value = jsonData[i].mfdch_value;  //value of option in backend
				option.text = jsonData[i].mfdch_desc;	  //text of option in frontend
				selectList.appendChild(option);
			}										
		}
	}
	
	//----------------
	function chkblock()
	{
		if(document.appraisementRegister.regterminal.value == "")
		{
			alert( "Please provide terminal!" );
			document.appraisementRegister.regterminal.focus() ;
			return false;
		}
		else if(document.appraisementRegister.regterminal.value=="GCB" && document.appraisementRegister.regblock.value == "")
		{
			alert( "Please provide block!" );
			document.appraisementRegister.regblock.focus() ;
			return false;
		}
		return true;
	}
	
	function fetchterminal(regterminal)
	{
		if(regterminal=="")
		{
			regblock.disabled=true;
			regassigntype.disabled=true;
		}
		else if(regterminal=="CCT" || regterminal=="NCT")
		{
			regblock.disabled=true;
			regassigntype.disabled=false;
			getAssignment2();
		}
		else if(regterminal=="GCB")
		{
			regblock.disabled=false;
			regassigntype.disabled=false;				
			getAssignment2();
			getBlock3();
		}
	}
	
	function getAssignment2()
	{
	//	alert(terminal);
		if (window.XMLHttpRequest) 
		{
		  xmlhttp=new XMLHttpRequest();
		} 
		else 
		{  
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		var assignDt = document.appraisementRegister.regdate.value;
		var terminal=document.appraisementRegister.regterminal.value;
	
		var url = "<?php echo site_url('ajaxController/getAssignmentType')?>?terminal="+terminal+"&assignDt="+assignDt;
	//	alert(url);
		xmlhttp.onreadystatechange=stateChangeAssignment2;
		xmlhttp.open("GET",url,false);
					
		xmlhttp.send();
	}
	
	function stateChangeAssignment2()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			var val = xmlhttp.responseText;
			//alert(val);
			var selectList=document.getElementById("regassigntype");
			removeOptions(selectList);
			
			var val = xmlhttp.responseText;
			var jsonData = JSON.parse(val);
			
			for (var i = 0; i < jsonData.length; i++) 
			{
				var option = document.createElement('option');
				option.value = jsonData[i].mfdch_value;  //value of option in backend
				option.text = jsonData[i].mfdch_desc;	  //text of option in frontend
				selectList.appendChild(option);
			}										
		}
	}
	
	function getBlock3()
	{
	//	alert("ok");
		if (window.XMLHttpRequest) 
		{
			xmlhttp=new XMLHttpRequest();
		} 
		else 
		{  
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}

		var terminal=document.appraisementRegister.regterminal.value;
	//	alert(terminal);
		xmlhttp.onreadystatechange=stateChangeLoadBlock3;
		xmlhttp.open("GET","<?php echo site_url('ajaxController/loadBlock')?>?terminal="+terminal,false);
					
		xmlhttp.send();
	}
	
	function stateChangeLoadBlock3()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			var val = xmlhttp.responseText;
			
			var selectList=document.getElementById("regblock");
			removeOptions(selectList);
			
			var val = xmlhttp.responseText;
			var jsonData = JSON.parse(val);
			
			for (var i = 0; i < jsonData.length; i++) 
			{
				var option = document.createElement('option');
				option.value = jsonData[i].Block_No;  //value of option in backend
				option.text = jsonData[i].Block_No;	  //text of option in frontend
				selectList.appendChild(option);
			}										
		}
	}
	
	function onblockchange2()
	{
		if (window.XMLHttpRequest) 
		{
		  xmlhttp=new XMLHttpRequest();
		} 
		else 
		{  
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		var assignDt = document.appraisementRegister.regdate.value;
		var terminal=document.appraisementRegister.regterminal.value;
		var yard=document.appraisementRegister.regblock.value;
		
		var url = "<?php echo site_url('ajaxController/onblockchange')?>?terminal="+terminal+"&assignDt="+assignDt+"&yard="+yard;
	//	alert(url);
		xmlhttp.onreadystatechange=stateChangeBlock2;
		xmlhttp.open("GET",url,false);
					
		xmlhttp.send();
	}
	
	function stateChangeBlock2()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			var val = xmlhttp.responseText;
			//alert(val);
			var selectList=document.getElementById("regassigntype");
			removeOptions(selectList);
			
			var val = xmlhttp.responseText;
			var jsonData = JSON.parse(val);
			
			for (var i = 0; i < jsonData.length; i++) 
			{
				var option = document.createElement('option');
				option.value = jsonData[i].mfdch_value;  //value of option in backend
				option.text = jsonData[i].mfdch_desc;	  //text of option in frontend
				selectList.appendChild(option);
			}										
		}
	}
	//Head Delivery Register Report end
  </script>


<div class="content" style="padding: 0px 0 12px;">
    <div class="content_resize_1">
		<div class="mainbar_1">
        <div class="article">
			<h2><span><?php echo $title; ?></span> </h2>
			<p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
			<div class="clr"></div>
			<div class="img">
				<table>
					<tr>
						<!--ASSIGNMENT/DELIVERY EMPTY DETAILS start-->
						<td valign="top">			   <!--1 1-->
						<?php 
						$attributes = array('target' => '_blank', 'id' => 'myform');
						echo form_open(base_url().'index.php/report/assignmentAllReportFormView',$attributes);
						$Stylepadding = 'style="padding: 12px 20px;"';
						if(!empty($error_message))
						{
							$Stylepadding = 'style="padding:25px 20px;"';
						}	
						if(isset($captcha_image)){
							$Stylepadding = 'style="padding:62px 20px 93px;"';
						}?>
						<table style="border:solid 1px #ccc;" width="300px" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td align="center" colspan="2"><b>
									ASSIGNMENT/DELIVERY EMPTY DETAILS</b>
									<input type="hidden" name="submit" id="submit" value="2">
								</td>
							</tr>
							<tr>
								<td>
									<table border="0" width="450px" align="center">
										<tr>
											<td align="right" colspan="2"></td>
										</tr>
										<tr>		
											<td align="left"></td>
											<td>
												<table>
													<tr>
														<td align="left">
															<label for="Excel" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Assignment</label>
										
															<?php 	$data = array(
															'name'        => 'options1',
															'id'          => 'options1',
															'value'       => 'assign1',
															'onclick' => 'rtnFuncAss(this.value)',
															'checked'     => TRUE,
															'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
															);
															echo form_radio($data); ?>
														</td>
														<td align="left">
															<label for="HTML" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Assignment(E)</label>
															<?php 	$data = array(
															'name'        => 'options1',
															'id'          => 'options1',
															'value'       => 'assigne1',
															'onclick' => 'rtnFuncAss(this.value)',
															'checked'     => FALSE,
															'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
															);
															echo form_radio($data); ?>
										
														</td>	
													</tr>
													<tr>
														<td align="left">
															<label for="HTML" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Delivery</label>
															<?php 	$data = array(
															'name'        => 'options1',
															'id'          => 'options1',
															'value'       => 'deli1',
															'onclick' => 'rtnFuncAss(this.value)',
															'checked'     => FALSE,
															'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
															);
															echo form_radio($data); ?>
														</td>
														<td align="left">
															<label for="HTML" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Container</label>
															<?php 	$data = array(
															'name'        => 'options1',
															'id'          => 'options1',
															'value'       => 'cont1',
															'onclick' => 'rtnFuncAss(this.value)',
															'checked'     => FALSE,
															'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
															);
															echo form_radio($data); ?>
										
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td align="left" ><label><font color='red'><b>*</b></font>From Date:</label>
											<td> 
												<input type="text" style="width:150px;" id="fromdate1" name="fromdate1" value="<?php date("Y-m-d"); ?>"/>
											</td>
											<script>
											  $(function() {
												$( "#fromdate1" ).datepicker({
													changeMonth: true,
													changeYear: true,
													dateFormat: 'yy-mm-dd', // iso format
												});
											});
											</script>
											</td>
										</tr>
										<tr>
											<td align="left">
												<label><font color='red'><b>*</b></font>To Date:
											<td><input type="text" style="width:150px;" id="todate1" name="todate1" value="<?php date("Y-m-d"); ?>" disabled /></td>
											</label> 
											<script>
													  $(function() {
														$( "#todate1" ).datepicker({
															changeMonth: true,
															changeYear: true,
															dateFormat: 'yy-mm-dd', // iso format
														});
													});
											</script>
											</td>
										</tr>									
										<tr>
											<td>
											<label for="field3"><font color='red'><b>*</b></font>Yard Name:</label></td>
											<td>
												<select name="yard_no1" id="yard_no1" class="">
												<option value="" label="yard_no" selected style="width:130px;">Select</option>
													<option value="CCT" label="CCT">CCT</option>
													<option value="NCT" label="NCT">NCT</option>
													<option value="GCB" label="GCB">GCB</option>
													<option value="SCY" label="SCY">SCY</option>
											</select>
											</td>
										</tr>
										<tr>
											<td align="left" ><label><font color='red'><b>*</b></font>Container No.</label>
											<td>
												<input type="text" name="container1" id="container1" style="width:150px;" disabled >	
												</td>
											</td>
										</tr>
										<tr>
											<td align="right" colspan="2"></td>
										</tr>
										<tr>	
											<td align="left"></td>
											<td>
												<table>
													<tr>
														<td align="left">
															<label for="Excel" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Excel</label>
															<?php 	$data = array(
															'name'        => 'fileOptions',
															'id'          => 'fileOptions',
															'value'       => 'xl',
															'checked'     => FALSE,
															'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
															);
															echo form_radio($data); ?>
														</td>
														<td align="left">
															<label for="HTML" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">HTML</label>
															<?php 	$data = array(
																		'name'        => 'fileOptions',
																		'id'          => 'fileOptions',
																		'value'       => 'html',
																		'checked'     => TRUE,
																		'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
																		);
															echo form_radio($data); ?>
														</td>
														<td align="left">
															<label for="PDF" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">PDF</label>
															<?php 	$data = array(
																		'name'        => 'fileOptions',
																		'id'          => 'fileOptions',
																		'value'       => 'pdf',
																		'checked'     => FALSE,
																		'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
																		);
															echo form_radio($data); ?>
														</td>
													</tr>
												</table>
											</td>
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
					</td>
					<!--ASSIGNMENT/DELIVERY EMPTY DETAILS end-->
					<!--YARDWISE ASSIGNMENT/DELIVERY EMPTY DETAILS start-->
					<td valign="top">		<!--1 2-->
						<?php echo form_close()?>
						<?php 
							$attributes = array('target' => '_blank', 'id' => 'myform');
						  
							echo form_open(base_url().'index.php/report/assignmentAllReportFormView',$attributes);
							$Stylepadding = 'style="padding: 12px 20px;"';
								if(!empty($error_message))
								{
									$Stylepadding = 'style="padding:25px 20px;"';
								}	
								if(isset($captcha_image)){
									$Stylepadding = 'style="padding:62px 20px 93px;"';
						}?>
					<!--<div id="login_container">-->
						<table style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td align="center" colspan="2"><b>
									YARDWISE ASSIGNMENT/DELIVERY EMPTY DETAILS</b>
						             <input type="hidden" name="submit" id="submit" value="1">
								</td>
							</tr>
							<tr>
								<td>
									<table border="0" width="350px" align="center">
										<tr>
											<td align="right" colspan="2"></td>
										</tr>
										<tr>		
											<td align="left"></td>
											<td>
												<table>
													<tr>
														<td align="left">
															<label for="Excel" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Assignment</label>
										
															<?php 	$data = array(
															'name'        => 'options1',
															'id'          => 'options1',
															'value'       => 'assign',
															'onclick' => 'rtnFunc(this.value)',
															'checked'     => TRUE,
															'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
															);
															echo form_radio($data); ?>
														</td>
														<td align="left">
															<label for="HTML" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Assignment(E)</label>
															<?php 	$data = array(
															'name'        => 'options1',
															'id'          => 'options1',
															'value'       => 'assigne',
															'onclick' => 'rtnFunc(this.value)',
															'checked'     => FALSE,
															'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
															);
															echo form_radio($data); ?>
														</td>	
													</tr>
													<tr> 		
														<td align="left">
															<label for="HTML" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Delivery</label>
															<?php 	
																$data = array(
																	'name'        => 'options1',
																	'id'          => 'options1',
																	'value'       => 'deli',
																	'onclick' => 'rtnFunc(this.value)',
																	'checked'     => FALSE,
																	'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
																	);
																echo form_radio($data); ?>
														</td>
														<td align="left">
															<label for="HTML" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Container</label>
															<?php 	
																$data = array(
																	'name'        => 'options1',
																	'id'          => 'options1',
																	'value'       => 'cont',
																	'onclick' => 'rtnFunc(this.value)',
																	'checked'     => FALSE,
																	'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
																	);
																echo form_radio($data); ?>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td align="left" ><label><font color='red'><b>*</b></font>From Date:</label>
											<td> 
												<input type="text" style="width:150px;" id="fromdate" name="fromdate" value="<?php date("Y-m-d"); ?>"/>
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
										</tr>
										<tr>
											<td align="left" ><label><font color='red'><b>*</b></font>To Date:
											<td ><input type="text" style="width:150px;" id="todate" name="todate" value="<?php date("Y-m-d"); ?>" disabled /></td>
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
										</tr>								
										<tr>
											<td>
											<label for="field3"><font color='red'><b>*</b></font>Yard Name:</label></td>
											<td>
												<select name="yard_no" id="yard_no" class="" onchange="getBlock(this.value)";>
												<option value="" label="yard_no" selected style="width:130px;">Select</option>
													<option value="CCT" label="CCT" >CCT</option>
													<option value="NCT" label="NCT" >NCT</option>
													<option value="GCB" label="GCB">GCB</option>
													<option value="SCY" label="SCY">SCY</option>
											</select>
											</td>
										</tr>
										<tr>
											<td>
											<label for="field4"><font color='red'><b>*</b></font>Block :</label></td>
											<td>
												<select name="block" id="block">
												<option value="">---Select---</option> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												
												</select>
											</td>
											<!--td> <label>Only select, count all block. </label></td-->
										</tr>
										<tr>
											<td align="left" ><label><font color='red'><b>*</b></font>Container No.</label>
											<td>
												<input type="text" name="container" id="container" style="width:150px;" disabled >	
												</td>
											</td>
										</tr>
										<tr>
											<td align="right" colspan="2"></td>
										</tr>
										<tr>
											<td align="left"></td>
											<td>
												<table>
													<tr>
														<td align="left">
															<label for="Excel" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Excel</label>
															<?php 	
																$data = array(
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
															<?php 	
																$data = array(
																	'name'        => 'options',
																	'id'          => 'options',
																	'value'       => 'html',
																	'checked'     => FALSE,
																	'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
																	);
															echo form_radio($data); ?>
														</td>
													</tr>
												</table>
											</td>
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
										<tr>
											<td colspan="2">&nbsp;</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<?php echo form_close()?>
					</td>
					<!--YARDWISE ASSIGNMENT/DELIVERY EMPTY DETAILS end-->
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<!--HEAD DELIVERY REGISTER REPORT start-->
					<td>	<!--2 1-->
						<form name="appraisementRegister" id="appraisementRegister" action="<?php echo site_url("report/appraisementRegisterPerform");?>" target="_blank" method="post" onsubmit="return chkblock();">
							<table align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
								<tr>
									<td colspan="3" align="center"><b>HEAD DELIVERY REGISTER REPORT</b></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><font color='red'><b>*</b></font><label>Date</label></td>
									<td>:</td>
									<td>
										<input type="text" style="width:180px;" id="regdate" name="regdate" value="<?php date("Y-m-d"); ?>"/>
									</td>
									<script>
										$(function() {
											$( "#regdate" ).datepicker({
												changeMonth: true,
												changeYear: true,
												dateFormat: 'yy-mm-dd', // iso format
											});
										});
									</script>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><font color='red'><b>*</b></font>Terminal</td>
									<td>:</td>
									<td>
										<select name="regterminal" id="regterminal" onchange="fetchterminal(this.value);">
											<option value="">--Select--</option>
											<option value="CCT">CCT</option>
											<option value="NCT">NCT</option>
											<option value="GCB">GCB</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><font color='red'><b>*</b></font><label>Block</label></td>
									<td>:</td>
									<td>
										<select name="regblock" id="regblock" onchange="onblockchange2(this.value);" disabled>
											<option value="">--Select--</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><label>Assignment Type</label></td>
									<td>:</td>
									<td>
										<select name="regassigntype" id="regassigntype" disabled >
											<option value="ALLASSIGN">--All Assignment--</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td colspan="3" align="center">
										<input type="submit" value="View" class="login_button"/>      
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
							</table>
						</form>
					</td>
					<!--HEAD DELIVERY	REGISTER REPORT end-->
					<!--MIS Assignment start-->
					<td>		<!--2 2-->
						 <!--form name= "myForm" onsubmit="return(validate2());" action="<?php echo site_url("report/misAssignmentPerform");?>" target="_blank" method="post"-->
						 <form name="misassignment" id="misassignment" onsubmit="return(validate2());" action="<?php echo site_url("report/misAssignmentPerform");?>" target="_blank" method="post">
							<table align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
								<tr>
									<td align="center" colspan="3"><b>MIS Assignment</b></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><label><font color='red'><b>*</b></font>Date</label></td>
									<td>:</td>
									<td>
										<input type="text" style="width:130px;" id="date" name="date" value="<?php date("Y-m-d"); ?>"/>
									</td>
									<script>
										$(function() {
											$( "#date" ).datepicker({
												changeMonth: true,
												changeYear: true,
												dateFormat: 'yy-mm-dd', // iso format
											});
										});
									</script>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><label><font color='red'><b>*</b></font>Terminal</label></td>
									<td>:</td>
									<td> 
										<select name="terminal" id="terminal" onchange="changeterminal(this.value);">
											<option value="">--Select--</option>
											<option value="CCT">CCT</option>
											<option value="NCT">NCT</option>
											<option value="GCB">GCB</option>
											<option value="SCY">SCY</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><label>Yard/Block</label></td>
									<td>:</td>
									<td> 
										<select name="yard" id="yard" onchange="onblockchange(this.value);" disabled>
											<option value="ALLBLOCK">--All Block--</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="right"><label>Assignment Type</label></td>
									<td>:</td>
									<td> 
										<select name="assigntype" id="assigntype" disabled>
											<option value="ALLASSIGN">--All Assignment--</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
								<td colspan="3" align="center">
									<table>
										<tr>
									
											<td align="left">
												<label for="PDF" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">PDF</label>
												<?php 	
												$data = array(
													'name'        => 'option',
													'id'          => 'option',
													'value'       => 'pdf',
													'checked'     => TRUE,
													'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
													);
												echo form_radio($data); ?>
											</td>
											<td align="left">
												<label for="Excel" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Excel</label>
													<?php 	
													$data = array(
													'name'        => 'option',
													'id'          => 'option',
													'value'       => 'xl',
													'checked'     => FALSE,
													'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
													);
												echo form_radio($data); ?>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
								<tr>
									<td colspan="3" align="center">
										<input type="submit" value="View" class="login_button"/>      
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
							</table>
						</form>
					</td> 
					<!--MIS Assignment end-->
				</tr> 
				<tr><td>&nbsp;</td></tr>
				<tr>	
					<!--Container search start-->
					<td>		<!--3 1-->
						<?php 
						$attributes = array('name' => 'cont_search','id' => 'cont_search','target'=>'_BLANK','onsubmit'=>'return validation()');
						//,'target'=>'_BLANK'
						echo form_open(base_url().'index.php/report/containerSearchResult',$attributes);
						$Stylepadding = 'style="padding: 12px 20px;"';
						if(!empty($error_message))
						{
							$Stylepadding = 'style="padding:25px 20px;"';
						}	
						if(isset($captcha_image)){
							$Stylepadding = 'style="padding:62px 20px 93px;"';
						}?>
						<table style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td>	 
									<table align="center" border="0">		
										<tr><td colspan="2" align="center"><b>CONTAINER SEARCH</b></td></tr>
										<tr>
											<td><font color='red'><b>*</b></font>Assignment Date:</td>
											<td>
												<input type="text" style="width:180px;" id="assignment" name="assignment" value="<?php date("Y-m-d"); ?>"/>
											</td>
											<script>
												$(function() {
													$( "#assignment" ).datepicker({
														changeMonth: true,
														changeYear: true,
														dateFormat: 'yy-mm-dd', // iso format
													});
												});
											</script>
										</tr>	
										<tr align="center">
											<td align="right" ><label for="container"><font color='red'><b>*</b></font>Container No:<em>&nbsp;</em></label></td>
											<td align="left" >
												<?php 
													$attribute = array('name'=>'ddl_imp_cont_no','id'=>'ddl_imp_cont_no','class'=>'login_input_text' );
													echo form_input($attribute,set_value('ddl_imp_rot_no'));
													//'onblur'=> "alert();"
												?>
											</td>
										</tr>				
										<tr>
											<td colspan="2" align="center" width="70px"><br><?php $arrt = array('name'=>'report','id'=>'submit','value'=>'Search','class'=>'login_button'); echo form_submit($arrt);?></td>	
										</tr>
										<tr><td colspan="2">&nbsp;</td></tr>
									</table>
									<?php echo form_close()?>
								</td>
								<!--Container search end-->
							</tr>
						</table>
					</td>
					<!--APPRAISE RE-SLOT LOCATION start-->
					<td>	<!--3 2-->
						<?php 
						$attributes = array('target' => '_blank', 'id' => 'myform','name' => 'myform','onsubmit'=>'return validate()');
						echo form_open(base_url().'index.php/report/appraiseReSlotLocList',$attributes);
						$Stylepadding = 'style="padding: 12px 20px;"';
						if(!empty($error_message))
						{
							$Stylepadding = 'style="padding:25px 20px;"';
						}	
						if(isset($captcha_image)){
							$Stylepadding = 'style="padding:62px 20px 93px;"';
						}?>
						<table style="border:solid 1px #ccc;" width="400px" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td align="center" colspan="2"><b>
									APPRAISE RE-SLOT LOCATION</b>
								</td>
							</tr>
							<tr>
								<td>
									<table border="0" width="300px" align="center">
										<tr>
											<td align="center" ><label><font color='red'><b>*</b></font>Search Date:</label>	<script>
												$(function() {
													$( "#fromdate4" ).datepicker({
														changeMonth: true,
														changeYear: true,
														dateFormat: 'yy-mm-dd', // iso format
													});
												});
											</script>
											</td>
											<td> 
												<input type="text" style="width:120px;" id="fromdate4" name="fromdate" value="<?php date("Y-m-d"); ?>"/>
											</td>
										</tr>
										<tr>
											<td align="center" ><label><font color='red'><b>*</b></font>Containers:</label>																			
											</td>
											<td> 
												<textarea style="width:200px;" id="contList" name="contList"></textarea>
											</td>
										</tr>
										<!--tr>
											<td align="center" ><label><font color='red'><b>*</b></font>From Time:</label>								
													
											</td>
											<td> 
												<input type="text" style="width:120px;" id="fromTime" name="fromTime" value=""/>(HH:MM)
											</td>
										</tr>
										<tr>
											<td align="center" ><label><font color='red'><b>*</b></font>To Time:</label>								
													
											</td>
											<td> 
												<input type="text" style="width:120px;" id="toTime" name="toTime" value=""/>(HH:MM)
											</td>
										</tr-->
										<tr>
											<td colspan="2" align="center">
												<table>
													<tr>
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
																'checked'     => FALSE,
																'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
																);
															echo form_radio($data); ?>
														</td>
														<td align="left">
															<label for="PDF" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">PDF</label>
															<?php 	$data = array(
																'name'        => 'options',
																'id'          => 'options',
																'value'       => 'pdf',
																'checked'     => TRUE,
																'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
																);
															echo form_radio($data); ?>
														</td>
													</tr>
												</table>
											</td>
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
						<?php echo form_close()?>
					</td>
					<!--APPRAISE RE-SLOT LOCATION end-->
				</tr>
				<tr><td>&nbsp;</td></tr>
				<!--appraisementRegister start-->
				<tr>
					<td>	<!--4 1-->
						<?php 
						$attributes = array('target' => '_blank', 'id' => 'myform');
				  
						echo form_open(base_url().'index.php/report/assignmentAllReportFormView',$attributes);
						$Stylepadding = 'style="padding: 12px 20px;"';
						if(!empty($error_message))
						{
							$Stylepadding = 'style="padding:25px 20px;"';
						}	
						if(isset($captcha_image)){
							$Stylepadding = 'style="padding:62px 20px 93px;"';
						}?>
						<table style="border:solid 1px #ccc;" width="300px" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td align="center" colspan="2"><b>
									ASSIGNMENT/DELIVERY EMPTY SUMMARY REPORT
									<input type="hidden" name="submit" id="submit" value="3"></b>
								</td>
							</tr>
							<tr>
								<td>
									<table border="0" width="350px" align="center">
										<tr>
											<td align="right" colspan="3"></td>
										</tr>
										<tr>
											<td align="left" ><label><font color='red'><b>*</b></font>Assignment Date:</label>
													<td> 
													<input type="text" style="width:150px;" id="fromdate3" name="fromdate3" value="<?php date("Y-m-d"); ?>"/>
													</td>
										
													<script>
													  $(function() {
														$( "#fromdate3" ).datepicker({
															changeMonth: true,
															changeYear: true,
															dateFormat: 'yy-mm-dd', // iso format
														});
													});
											</script>
											</td>
										</tr>
										<tr>
											<td>
												<label for="field3"><font color='red'><b>*</b></font>Yard Name:</label>
											</td>
											<td>
												<select name="yard3" id="yard3" class="">
													<option value="" label="yard" selected style="width:130px;">Select</option>
													<option value="CCT" label="CCT" >CCT</option>
													<option value="NCT" label="NCT" >NCT</option>
													<option value="GCB" label="GCB">GCB</option>
													<option value="SCY" label="SCY">SCY</option>
												</select>
											</td>
										</tr>
										<tr>
											<td align="right" colspan="2"></td>
										</tr>
										<tr>
											<td align="left"></td>
											<td>
												<table>
													<tr>
														<td align="left">
															<label for="Excel" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Excel</label>
															<?php 	$data = array(
																'name'        => 'options3',
																'id'          => 'options3',
																'value'       => 'xl',
																'checked'     => FALSE,
																'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
																);
															echo form_radio($data); ?>
														</td>
														<td align="left">
															<label for="HTML" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">HTML</label>
															<?php 	$data = array(
															'name'        => 'options3',
															'id'          => 'options3',
															'value'       => 'html',
															'checked'     => FALSE,
															'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
															);
															echo form_radio($data); ?>
														</td>
													</tr>
												</table>
											</td>
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
						<?php echo form_close()?>
					</td>
					<td>
						 <?php 
						  $attributes = array('target' => '_blank', 'id' => 'myform','name' => 'myform','onsubmit'=>'return validate()');
						  
						  echo form_open(base_url().'index.php/report/listOfNotStrippedContainerView',$attributes);
							$Stylepadding = 'style="padding: 12px 20px;"';
								if(!empty($error_message))
								{
									$Stylepadding = 'style="padding:25px 20px;"';
								}	
								if(isset($captcha_image)){
									$Stylepadding = 'style="padding:62px 20px 93px;"';
								}?>
					
						<div class="img">
						 <table style="border:solid 1px #ccc;" width="300px" align="center" cellspacing="0" cellpadding="0">
						<tr>
							<td>	 
								<table border="0" width="400px" align="center">
								<tr>
									<td align="center" colspan="2"><b>
										List Of Not Stripped Assignment Delivery Containers
					
									</td>
								</tr>
								<tr>
									<td align="right" colspan="2"></td>
								</tr>
								<tr>
									<td align="left" ><label><font color='red'><b>*</b></font>Date:</label>
									<td> 
										<input type="text" style="width:150px;" id="strDt" name="strDt" value=""/>
									</td>
									<script>
									  $(function() {
										$( "#strDt" ).datepicker({
											changeMonth: true,
											changeYear: true,
											dateFormat: 'yy-mm-dd', // iso format
										});
									});
									</script>
									</td>
								</tr>						
								<tr>
									<td>
									<label for="field3"><font color='red'><b>*</b></font>Yard Name:</label></td>
									<td>
										<select name="yard_no1" id="yard_no1" class="">
										<option value="" label="yard_no" selected style="width:130px;">Select</option>
											<option value="CCT" label="CCT">CCT</option>
											<option value="NCT" label="NCT">NCT</option>
											<option value="GCB" label="GCB">GCB</option>
											<option value="SCY" label="SCY">SCY</option>
									</select>
									</td>
								</tr>
								
								<tr>
									<td align="right" colspan="2"></td>
								</tr>
								<tr>	
									<td align="left"></td>
									<td>
										<table>
											<tr>
												<td align="left">
													<label for="Excel" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Excel</label>
													<?php 	$data = array(
													'name'        => 'fileOptions',
													'id'          => 'fileOptions',
													'value'       => 'xl',
													'checked'     => FALSE,
													'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
													);
													echo form_radio($data); ?>
												</td>
												<td align="left">
													<label for="HTML" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">HTML</label>
													<?php 	$data = array(
																'name'        => 'fileOptions',
																'id'          => 'fileOptions',
																'value'       => 'html',
																'checked'     => TRUE,
																'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
																);
													echo form_radio($data); ?>
												</td>
												<!--td align="left">
													<label for="PDF" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">PDF</label>
													<?php 	$data = array(
																'name'        => 'fileOptions',
																'id'          => 'fileOptions',
																'value'       => 'pdf',
																'checked'     => FALSE,
																'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
																);
													echo form_radio($data); ?>
												</td-->
											</tr>
										</table>
									</td>
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

  		