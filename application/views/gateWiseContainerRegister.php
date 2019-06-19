<!--script>
   function getAllGate()
	{	
     alert("ok");	
		if (window.XMLHttpRequest) 
		{

		  xmlhttp=new XMLHttpRequest();
		} 
		else 
		{  
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=stateChangeGateInfo;
		xmlhttp.open("GET","<?php echo site_url('ajaxController/getAllGate')?>",false);
					
		xmlhttp.send();
	}
	
	
	function stateChangeGateInfo()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			var val = xmlhttp.responseText;
			
		   alert(val);
			var selectList=document.getElementById("gateNo");
			removeOptions(selectList);
			//alert(xmlhttp.responseText);
			var val = xmlhttp.responseText;
			var jsonData = JSON.parse(val);
			//alert(xmlhttp.responseText);
			for (var i = 0; i < jsonData.length; i++) 
			{
				var option = document.createElement('option');
				option.value = jsonData[i].gkey;  //value of option in backend
				option.text = jsonData[i].id;	  //text of option in frontend
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
 
</script-->
<html>
<!--body onload="getAllGate()"-->
<div class="content">
    <div class="content_resize">
		<div class="mainbar">
			<div class="article">
				<h2><span><?php echo $title; ?></span> </h2>
				<p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
   
				<div class="clr"></div>
					<div class="img">
						<form name= "myForm" onsubmit="return(validation());" action="<?php echo site_url("gateController/gateWiseContainerRegisterView");?>" target="_blank" method="post">
							<table align="center" style="border:solid 1px #ccc;" width="350px"  cellspacing="0" cellpadding="0">
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
								    <th><nobr>DATE</nobr></th>
									<td colspan="2"><input type="text" class="read" style="width:135px;"  id="date" name="date" ></td>
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
									<th align="left"><label><font color='red'></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REGISTER TYPE:</label></th>
							
										<td colspan="2">
											<select name="registerType" id="registerType">  
												<option value="">--------Select--------</option>
												<option value="inward">INWARD</option>
												<option value="outward">OUTWARD</option>
												
											</select>	
									    </td>						
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<th align="left"><label><font color='red'></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GATE NO:</label></th>
							
										<td colspan="2">
											<select name="gate" id="gate">  
												<option value="all">--------Select--------</option>
												<option value="all">ALL</option>
												<?php for($i=0; $i<count($gateList); $i++){ ?>
													
												<option value="<?php echo $gateList[$i]['gkey'];?>"><?php echo $gateList[$i]['id'];?></option>
												
												<?php } ?>
											</select>	
									    </td>						
								</tr>
								<tr>
									<td>&nbsp;</td>
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
												'checked'     => FALSE,
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
								</tr></table></td>
								</tr>
								
								<tr>
									<td colspan="2" align="center">
										&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="submit" value="Search" class="login_button"/> 
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
							</table>
							
							
							<!--table align="center" style="border:solid 1px #ccc;"  cellspacing="0" cellpadding="0">
								<tr>
										<th><nobr>DATE :&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
										<td colspan="2"><input type="text" class="read" style="width:135px;"  id="date" name="date"  placeholder="Date" ></td>
										<script>
												  $(function() {
													$( "#date" ).datepicker({
														changeMonth: true,
														changeYear: true,
														dateFormat: 'yy-mm-dd', // iso format
													});
												});
										</script>
									
										<th align="left"><label><font color='red'></font><nobr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GATE NO:&nbsp;&nbsp;&nbsp;&nbsp;</nobr></label></th>
								
										<td colspan="2">
												<select name="gateNo" id="gateNo" >  
													<option value="">------Select-------</option>
															
												</select>	
										</td>						
										<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
										<td><input type="submit" value="Search" class="login_button" /> </td>
								</tr>
							</table-->
							
						</form>
					</div>
        
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
  <!--/body-->
  </html>