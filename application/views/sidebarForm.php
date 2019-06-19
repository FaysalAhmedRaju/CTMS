<script type="text/javascript">
	function validate()
	{
		if(document.sidebarForm.loginID.value=="")
		{
			alert("Provide a login ID");
			document.sidebarForm.loginID.focus();
			return false;
		}
		if( document.sidebarForm.orgType.value == "" )
		{
			alert( "Please provide an Org Type" );
			document.sidebarForm.orgType.focus();
			return false;
		}
		if(document.sidebarForm.section.value=="")
		{
			alert("Provide a Section");
			document.sidebarForm.section.focus();
			return false;
		}
		if(document.sidebarForm.menuType.value=="")
		{
			alert("Provide a Menu Type");
			document.sidebarForm.menuType.focus();
			return false;
		}
		if(document.sidebarForm.urlName.value=="")
		{
			alert("Provide a URL Name");
			document.sidebarForm.urlName.focus();
			return false;
		}
		return true;
	}
	
	function getOrgTypeSection(val)
	{
		var login_id=document.sidebarForm.loginID.value;
	
	//	alert(login_id); 
		if (window.XMLHttpRequest) 
		{
		  xmlhttp=new XMLHttpRequest();
		} 
		else 
		{  
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		var url = "<?php echo site_url('ajaxController/getOrgTypeSection')?>?login_id="+login_id;
		
		xmlhttp.onreadystatechange=stateChangeValue;
		xmlhttp.open("GET",url,false);	
			
		xmlhttp.send();
	}
	
	function stateChangeValue()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200) //???
		{			
			var val = xmlhttp.responseText;
			
			var jsonData = JSON.parse(val);
			
			/*
			select users.login_id,tbl_org_types.id as tbl_org_types_id,Org_Type,users_section_detail.id as users_section_detail_id,full_name
			from users 
			inner join tbl_org_types on tbl_org_types.id=users.org_Type_id
			inner join users_section_detail on users_section_detail.id=users.section
			where login_id='devcpa'
			*/
			
			document.getElementById("tbl_org_types_id").value=jsonData[0].tbl_org_types_id; 
			document.getElementById("orgType").value=jsonData[0].Org_Type; 
			document.getElementById("users_section_detail_id").value=jsonData[0].users_section_detail_id; 
			document.getElementById("section").value=jsonData[0].full_name; 
		}
	}
	
	$(document).on('keypress', 'input,select', function (e) {
		if (e.which == 13) {
			e.preventDefault();
			var $next = $('[tabIndex=' + (+this.tabIndex + 1) + ']');
			console.log($next.length);
			if (!$next.length) {
				//$next = $('[tabIndex=1]');
		form.submit();
			}
		else
			$next.focus();
		}
	});
	
	function onMenuChange()
	{
		if (window.XMLHttpRequest) 
		{
		  xmlhttp=new XMLHttpRequest();
		} 
		else 
		{  
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		var menu_id = document.sidebarForm.menuType.value;
		
		var url = "<?php echo site_url('ajaxController/getURL')?>?menu_id="+menu_id;
		
	//	alert(url);
		xmlhttp.onreadystatechange=stateChangeURL;
		xmlhttp.open("GET",url,false);
					
		xmlhttp.send();
	}
	
	function stateChangeURL()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			var val = xmlhttp.responseText;
			//alert(val);
			var selectList=document.getElementById("urlName");
			removeOptions(selectList);
			
			var val = xmlhttp.responseText;
			var jsonData = JSON.parse(val);
			
			for (var i = 0; i < jsonData.length; i++) 
			{
				var option = document.createElement('option');
				option.value = jsonData[i].url_id;  //value of option in backend
				option.text = jsonData[i].url_title;	  //text of option in frontend
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
				<div class="img">
					<form name= "sidebarForm" id="sidebarForm" onsubmit="return(validate());" action="<?php echo site_url("menuDesignController/sidebarDataInsert");?>" target="_blank" method="post">
						<table border="0" align="center" style="border:solid 1px #ccc;" width="450px" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="3" align="center"><?php echo $msg; ?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="right" >Login ID</td>
								<td>:</td>
								<td>
									<input name="loginID" id="loginID" type="text" onblur="return getOrgTypeSection(this.value)"tabindex="1"   />
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="right">Org Type</td>
								<td>:</td>
								<td>
									<input name="tbl_org_types_id" id="tbl_org_types_id" type="hidden" />
									<input name="orgType" id="orgType" type="text" readonly />
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="right">Section</td>
								<td>:</td>
								<td> 
									<input name="users_section_detail_id" id="users_section_detail_id" type="hidden"  />
									<input name="section" id="section" type="text" readonly />
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="right">Menu Type</td>
								<td>:</td>
								<td>
									<select name="menuType" id="menuType" onchange="onMenuChange(this.value);" tabindex="2">
										<option value="">--Select--</option>
										<?php
										$sql_MenuType="select menu_id,menu_name from panel_menu";
										$rslt_MenuType=mysql_query($sql_MenuType);
										while($row_MenuType=mysql_fetch_object($rslt_MenuType))
										{
										?>
											<option value="<?php echo $row_MenuType->menu_id; ?>"><?php echo $row_MenuType->menu_name; ?></option>
										<?php
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="right">URL Name</td>
								<td>:</td>
								<td>
									<select name="urlName" id="urlName">
										<option value="">--Select--</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td colspan="3" align="center">
									<input type="submit" value="Save" class="login_button"/>      
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
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
	<?php// echo form_close()?>
</div>