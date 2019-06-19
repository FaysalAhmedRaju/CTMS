<html>
	<head>
		<script type="text/javascript">
			function checkPass()
			{
				//alert("ok");
				var uPass = document.getElementsByName("uPass")[0].value;
				var cPass = document.getElementsByName("cPass")[0].value;
				//alert(uPass+"="+cPass);
				if(uPass!=cPass)
				{
					document.getElementById("no").style.display="inline";
					document.getElementById("yes").style.display="none";
				}
				else
				{
					document.getElementById("yes").style.display="inline";
					document.getElementById("no").style.display="none";
				}
			}
			
			function myFormValidation()
			{
				var orgType = document.getElementById("orgType").value;
				var orgName = document.getElementById("orgName").value;
				var uId = document.getElementById("uId").value;
				var uPass = document.getElementById("uPass").value;
				var cPass = document.getElementById("cPass").value;
				var cPhone = document.getElementById("cPhone").value;
				var email = document.getElementById("email").value;
				//alert(orgType);
				if(orgType=="" || orgType==" ")
				{
					alert("Select a organization type.");
					document.getElementById("orgType").style.background="#F6CECE";
					document.getElementById("orgType").focus();
					return false;
				}
				else if(orgName=="" || orgName==" ")
				{
					alert("Type a organization name.");
					document.getElementById("orgName").style.background="#F6CECE";
					document.getElementById("orgName").focus();
					return false;
				}
				else if(uId=="" || uId==" ")
				{
					alert("Type a user id.");
					document.getElementById("uId").style.background="#F6CECE";
					document.getElementById("uId").focus();
					return false;
				}
				else if(uPass=="" || uPass==" ")
				{
					alert("Type a password.");
					document.getElementById("uPass").style.background="#F6CECE";
					document.getElementById("uPass").focus();
					return false;
				}
				else if(cPass=="" || cPass==" ")
				{
					alert("Type a confirm password.");
					document.getElementById("cPass").style.background="#F6CECE";
					document.getElementById("cPass").focus();
					return false;
				}
				else if(cPhone=="" || cPhone==" ")
				{
					alert("Type a phone number.");
					document.getElementById("cPhone").style.background="#F6CECE";
					document.getElementById("cPhone").focus();
					return false;
				}
				else if(email=="" || email==" ")
				{
					alert("Type a email number.");
					document.getElementById("email").style.background="#F6CECE";
					document.getElementById("email").focus();
					return false;
				}
				else
				{
					return true;
				}
			}
			
			function user_type(userType)
			{
				if(userType=="organization")
					image.disabled=false;
				else if(userType=="cnf")
					image.disabled=false;
				else
					image.disabled=true;
			}
			
			function allow_license()
			{
				var orgType = document.getElementById("orgType").value;
			
				if(orgType==2)
					license_no.disabled=false;
				else
					license_no.disabled=true;
			}
			
			function get_cnf_info()
			{
				if (window.XMLHttpRequest) 
				{
				  xmlhttp=new XMLHttpRequest();
				} 
				else 
				{  
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				
				var license_no = document.getElementById("license_no").value;
				
				var url = "<?php echo site_url('ajaxController/get_cnf_info')?>?license_no="+license_no;
				
				xmlhttp.onreadystatechange=stateChangeCnfInfo;
				xmlhttp.open("GET",url,false);
							
				xmlhttp.send();
			}
			
			function stateChangeCnfInfo()
			{			
				if (xmlhttp.readyState==4 && xmlhttp.status==200) 
				{
					var val = xmlhttp.responseText;
					var jsonData = JSON.parse(val);
					
					document.getElementById("orgName").value=jsonData[0].u_name;
					document.getElementById("address1").value=jsonData[0].Address_1;
					document.getElementById("address2").value=jsonData[0].Address_2;
					
					var land_phone=jsonData[0].Telephone_No_Land;
					var ind_of_land_phone=land_phone.indexOf(",");
					
					if(ind_of_land_phone>-1)
					{
						land_phone = land_phone.substring(0, ind_of_land_phone);
						document.getElementById("lPhone").value=land_phone;
					}
					else
					{
						document.getElementById("lPhone").value=jsonData[0].Telephone_No_Land;		
					}
					
					var cell_phone=jsonData[0].Cell_No_1;
					var ind_of_cell_phone=cell_phone.indexOf(",");
					
					if(ind_of_cell_phone>-1)
					{
						cell_phone = cell_phone.substring(0, ind_of_cell_phone);
						document.getElementById("cPhone").value=cell_phone;
					}
					else
					{
						document.getElementById("cPhone").value=jsonData[0].Cell_No_1;		
					}
					
					document.getElementById("email").value=jsonData[0].email;										
				}
			}
			$(document).on('change', 'input', function(){
				var optionslist = $('datalist')[0].options;
				var value = $(this).val();
				var orgType = document.getElementById("orgType").value;
				for (var x=0;x<optionslist.length;x++){
				   if (optionslist[x].value === value) {
					   
					
					
					if(orgType=="" || orgType==" ")
					{
						alert("Select a organization type.");
						//document.getElementById("orgType").style.background="#F6CECE";
						//document.getElementById("orgType").focus();
						return false;
					}
					else
					{
						if (window.XMLHttpRequest) 
						{
						  xmlhttp=new XMLHttpRequest();
						} 
						else 
						{  
							xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
						}
						
						
						  //Alert here value
						var url = "<?php echo site_url('ajaxController/get_org_info')?>?org_type="+orgType+"&org_name="+value;
						
						xmlhttp.onreadystatechange=stateChangeOrgInfo;
						xmlhttp.open("GET",url,false);
									
						xmlhttp.send();
					}
					  //alert(value);
					  //break;
				   }
				}
			});
			function stateChangeOrgInfo()
			{			
				if (xmlhttp.readyState==4 && xmlhttp.status==200) 
				{
					var val = xmlhttp.responseText;
					var jsonData = JSON.parse(val);
					//console.log("L : "+jsonData.length);
					document.getElementById("address1").value=jsonData[0].Address_1;
					document.getElementById("address2").value=jsonData[0].Address_2;
					document.getElementById("cPhone").value=jsonData[0].Cell_No_1;
					document.getElementById("email").value=jsonData[0].email;
					document.getElementById("lPhone").value=jsonData[0].Cell_No_2;
					
													
				}
			}
		</script>
	</head>
	<body>
		<script type="text/javascript" src="<?php echo JS_PATH; ?>AdvancedCalender.js"></script>
 <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
	
		<form name="userCreation" id="userCreation" action="<?php echo site_url("report/userCreation"); ?>" method="POST" onsubmit="return myFormValidation();" enctype="multipart/form-data">
			<table>
				<tr>
					<td align="center" colspan="3">
						<?php echo $msg;?>
					</td>
				</tr>
				<tr>
					<td>
						Organization Type
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<select name="orgType" id="orgType" onchange="allow_license()">
							<option value="">Select</option>
						<?php
							for($t=0;$t<count($orgList);$t++) 
							{	
						?>
							<!--option value="<?php echo $orgList[$t][id]; ?>" <?php if($orgList[$t][id]==$rslt_user_data[0]['org_type_id']) echo 'selected="selected"'; ?>><?php echo $orgList[$t][Org_Type]?></option-->
							<option value="<?php echo $orgList[$t][id]; ?>" <?php if($orgList[$t][id]==$rslt_user_data[0]['org_Type_id']) echo 'selected="selected"'; ?> ><?php echo $orgList[$t][Org_Type]?></option>
						<?php
							}
						?>
						</select><font color="red" size="4"><b>&nbsp;*</b></font>
					</td>
				</tr>
				<tr>
					<td>
						License No.
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<input id="license_no" name="license_no" type="text" onblur="get_cnf_info()" disabled />
					</td>
				</tr>
				<tr>
					<td>
						User Type
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<select name="userType" id="userType" onchange="user_type(this.value);" >
							<option value="">--Select--</option>
							<option value="organization">Organization</option>
							<option value="cnf">CNF</option>
							<option value="single">Single</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Organization Name
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<input list="org_names" name="orgName" id="orgName" value="<?php echo $rslt_user_data[0]['u_name']; ?>"  />
						<datalist id="org_names">
						<?php
						include('mydbPConnection.php');
						$sql_org_name="SELECT id,Organization_Name FROM organization_profiles";
						
						$rslt_org_name=mysql_query($sql_org_name);
						
						while($row_org_name=mysql_fetch_object($rslt_org_name))
						{
						?>
						<option 
						value="<?php echo $row_org_name->Organization_Name; ?>" 
						id="<?php echo $row_org_name->id; ?>"
						label="<?php echo $row_org_name->Organization_Name; ?>" 
						>
						</option>
						<?php
						}
						?>											
						</datalist>
						<font color="red" size="4"><b>&nbsp;*</b></font>
					</td>
					<!--td>
						<textarea name="orgName" id="orgName"><?php echo $rslt_user_data[0]['u_name'];?></textarea><font color="red" size="4"><b>&nbsp;*</b></font>
					</td-->
				</tr>
				<tr>
					<td>
						User Id
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<input type="text" name="uId" id="uId" value="<?php echo $rslt_user_data[0]['login_id'];?>"><font color="red" size="4"><b>&nbsp;*</b></font>
					</td>
				</tr>
			<?php 
			if($creation==1)
			{
			?>				
				<tr>
					<td>
						Password
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<input type="password" name="uPass" id="uPass"><font color="red" size="4"><b>&nbsp;*</b></font>
						<input type="hidden" name="create" id="create" value=1 />
					</td>
				</tr>
				<tr>
					<td>
						Confirm Password
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<input type="password" name="cPass" id="cPass"  onkeyup="checkPass()"><font color="red" size="4"><b>&nbsp;*</b></font>
						<span style=" display: none;" id="no"><font color="red" size="5">&#10008;</font></span><span style=" display: none;" id="yes"><font color="green" size="5">&#10004;</font></span>
					</td>
				</tr>
			<?php 
			}
			?>
				<tr>
					<td>
						Address 1
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<textarea name="address1" id="address1"><?php echo $rslt_user_data[0]['Address_1'];?></textarea>
					</td>
				</tr>
				<tr>
					<td>
						Address 2
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<textarea name="address2" id="address2"><?php echo $rslt_user_data[0]['Address_2'];?></textarea>
					</td>
				</tr>
				<tr>
					<td>
						Land Phone
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<input type="text" name="lPhone" id="lPhone" value="<?php echo $rslt_user_data[0]['Telephone_No_Land'];?>">
					</td>
				</tr>
				<tr>
					<td>
						Cell Phone
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<input type="text" name="cPhone" id="cPhone" value="<?php echo $rslt_user_data[0]['Cell_No_1'];?>"><font color="red" size="4"><b>&nbsp;*</b></font>
					</td>
				</tr>
				<tr>
					<td>
						Email
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<input type="text" name="email" id="email" value="<?php echo $rslt_user_data[0]['email'];?>"><font color="red" size="4"><b>&nbsp;*</b></font>
					</td>
				</tr>
				<tr>
					<td>
						Section
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<select name="section" id="section">
							<option value="">--Select--</option>
						<?php
					//	$sql_section="select short_name,full_name from users_section_detail";
						$sql_section="select id,full_name from users_section_detail";
						$rslt_section=mysql_query($sql_section);
						while($row_section=mysql_fetch_object($rslt_section))
						{
						?>
							<option value="<?php echo $row_section->id;?>" <?php if($row_section->id==$rslt_user_data[0]['section']) echo 'selected="selected"'; ?>><?php echo $row_section->full_name;?></option>
						<?php
						}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Image</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<input name="image" id="image" type="file" disabled />
					</td>
				</tr>
				<?php
				if($rslt_user_data[0]['login_id']==null)
				{
				?>
				<tr>
					<td align="center" colspan="3">
						<input type="submit" name="submit" id="submit" value="Create" style="width:60px;background:#07a3b9;">
					</td>
				</tr>
				<?php
				}
				else
				{
				?>
				<tr>
					<td align="center" colspan="3">
						<input type="submit" name="submit" id="submit" value="Edit" style="width:60px;background:#07a3b9;">
					</td>
				</tr>
				<?php
				}
				?>
			</table>
		</form>	
		
		<div class="clr"></div>
        </div>
       
       <!-- <p class="pages"><small>Page 1 of 2</small> <span>1</span> <a href="#">2</a> <a href="#">&raquo;</a></p>-->
      </div>
      <div class="sidebar">
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	
  </div>
	</body>
</html>