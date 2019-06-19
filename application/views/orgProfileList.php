 <script>
 function search_type(type)
	{
		if( document.search_org_profile.search_by.value == "" )
		{
			alert( "Please provide search type!" );
			document.search_org_profile.search_by.focus() ;
			return false;
		}
		else
		{	
			if(type=="org_type")
			{
				document.getElementById("type").style.display = 'inline';
				document.getElementById("name").style.display = 'none';
				document.getElementById("lic").style.display = 'none';
				document.getElementById("aiin").style.display = 'none';
				//org_name.disabled=true;
				//org_type.disabled=false;
				//lic_no.disabled=true;
				
				document.search_org_profile.lic_no.value="";
				document.search_org_profile.aiin_no.value="";
			}
			else if(type=="org_name")
			{
				document.getElementById("type").style.display = 'none';
				document.getElementById("name").style.display = 'inline';
				document.getElementById("lic").style.display = 'none';
				document.getElementById("aiin").style.display = 'none';
				//org_name.disabled=false;
				//org_type.disabled=true;
				//lic_no.disabled=true;
				
				document.search_org_profile.lic_no.value="";
				document.search_org_profile.aiin_no.value="";
			}
			else if(type=="lic_no")
			{
				document.getElementById("type").style.display = 'none';
				document.getElementById("name").style.display = 'none';
				document.getElementById("lic").style.display = 'inline';
				document.getElementById("aiin").style.display = 'none';
				document.search_org_profile.aiin_no.value="";
				//org_name.disabled=true;
				//org_type.disabled=true;
				//lic_no.disabled=false;
				
			}
			else if(type=="aiin_no")
			{
				document.getElementById("type").style.display = 'none';
				document.getElementById("name").style.display = 'none';
				document.getElementById("lic").style.display = 'none';
				document.getElementById("aiin").style.display = 'inline';
				document.search_org_profile.lic_no.value="";
				//org_name.disabled=true;
				//org_type.disabled=true;
				//lic_no.disabled=false;
				
			}
		}
	}
	function validate()
	  {
		if (confirm("Are you sure!! Delete this record?") == true) {
		   return true ;
		} else 
		{
			return false;
		}		 
	  }
 </script>
 <div class="content">
    <div class="content_resize_1">
      <div class="mainbar_1">
        <div class="article">
   <h2><span><?php echo $title; ?></span> </h2>
   <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
   
   <div class="clr"></div>
   <div class="img">
	<table cellspacing="1" cellpadding="1" align="center">
		<!--tr>
			<td colspan="8">
				<form name="search_org_profile" id="search_bill" action="<?php echo site_url("cfsModule/searchOrgProfile");?>" method="post">
					<table align="center" style="border:solid 1px #ccc;" width="600px" cellspacing="0" cellpadding="0">
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td align="right"><label>Search By</label></td>
							<td>:</td>
							<td>
								<select name="search_by" id="search_by" onchange="search_type(this.value);">
									<option value="">--Select--</option>
									<option value="org_type">Org Type</option>
									<option value="org_name">Org Name</option>
									<option value="lic_no">License No</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td align="right"><label>Organization Type</label></td>
							<td>:</td>
							<td>
								<select name="org_type" id="org_type" onchange="search_type(this.value);" disabled>
									<option value="">--Select--</option>
									<?php
									for($i=0; $i<count($org_type_list); $i++){ ?>
										<option value="<?php echo $org_type_list[$i]['id']; ?>" label="<?php echo $org_type_list[$i]['Org_Type']; ?>"><?php echo $org_type_list[$i]['Org_Type']; ?></option>
									<?php } ?>											
																		
								</select>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td align="right"><label>Organization Name</label></td>
							<td>:</td>
							<td>
								<select name="org_name" id="org_name" onchange="search_type(this.value);" disabled>
									<option value="">--Select--</option>
									<?php
									for($i=0; $i<count($org_name_list); $i++){ ?>
										<option value="<?php echo $org_name_list[$i]['Organization_Name']; ?>" label="<?php echo $org_name_list[$i]['Organization_Name']; ?>"><?php echo $org_name_list[$i]['Organization_Name']; ?></option>
									<?php } ?>											
																		
								</select>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td align="right"><label>License No</label></td>
							<td>:</td>
							<td>
								<input name="lic_no" id="lic_no" type="text" disabled />
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td align="center" colspan="3">
								<input type="submit" value="Search" class="login_button" />      
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>
				</form>
			</td>
		</tr-->
		<tr>
			<form name="search_org_profile" id="search_bill" action="<?php echo site_url("cfsModule/searchOrgProfile");?>" method="post">
			<td><label>Search By</label></td>
			<td>:</td>
			<td colspan="1">
				<select name="search_by" id="search_by" onchange="search_type(this.value);">
					<option value="">--Select--</option>
					<option value="org_type">Org Type</option>
					<option value="org_name">Org Name</option>
					<option value="lic_no">License No</option>
					<option value="aiin_no">Aiin No</option>
				</select>
			</td>
			<td colspan="3" align="left">
				<div align="left" id="type" style="display:none;">
					<table>
						<tr>
							<td align="right"><label>Organization Type</label></td>
							<td>:</td>
							<td>
								<select name="org_type" id="org_type" onchange="search_type(this.value);" >
									<option value="">--Select--</option>
									<?php
									for($i=0; $i<count($org_type_list); $i++){ ?>
										<option value="<?php echo $org_type_list[$i]['id']; ?>" label="<?php echo $org_type_list[$i]['Org_Type']; ?>"><?php echo $org_type_list[$i]['Org_Type']; ?></option>
									<?php } ?>											
																		
								</select>
							</td>
						</tr>
					</table>
				</div>
				<div align="left" id="name" style="display:none;">
					<table>
						<tr>
							<td align="right"><label>Organization Name</label></td>
							<td>:</td>
							<td>
								<select name="org_name" id="org_name" onchange="search_type(this.value);" >
									<option value="">--Select--</option>
									<?php
									for($i=0; $i<count($org_name_list); $i++){ ?>
										<option value="<?php echo $org_name_list[$i]['Organization_Name']; ?>" label="<?php echo $org_name_list[$i]['Organization_Name']; ?>"><?php echo $org_name_list[$i]['Organization_Name']; ?></option>
									<?php } ?>											
																		
								</select>
							</td>
						</tr>
					</table>
				</div>
				<div align="left" id="lic" style="display:none;">
					<table>
						<tr>
							<td align="right"><label>License No</label></td>
							<td>:</td>
							<td>
								<input name="lic_no" id="lic_no" type="text" />
							</td>
						</tr>
					</table>
				</div>
				<div align="left" id="aiin" style="display:none;">
					<table>
						<tr>
							<td align="right"><label>Aiin No</label></td>
							<td>:</td>
							<td>
								<input name="aiin_no" id="aiin_no" type="text" />
							</td>
						</tr>
					</table>
				</div>
			</td>
			<td align="left">
				<input type="submit" value="Search" class="login_button" />
			</td>
			</form>
			<td align="right">
				<form action="<?php echo site_url('cfsModule/org_creation_form');?>" method="POST">
					<input type="submit" value="ADD NEW" class="login_button" /> 
				</form>
			</td>
		</tr>
		</table>
		<table cellspacing="1" cellpadding="1" align="center">
		<tr class="gridDark" style="height:35px;" >
			<th>SL</th>
			<th>Org Type</th>
			<th>Org Name</th>
			<th>AIIN NO</th>
			<th>License</th>
			<th>Agent Code</th>
			<th>Action</th>
			<th>Action</th>
		</tr>
		
	  <?php
        for($i=0;$i<count($profileList);$i++) { 
         ?>
         <tr class="gridLight">
          <td>
           <?php echo $i+1;?>
          </td>
         <td align="center" >
           <?php echo $profileList[$i]['Org_Type']?>
          </td> 
          <td align="center">
           <?php echo $profileList[$i]['Organization_Name']?>
          </td>
          <td align="center">
           <?php echo $profileList[$i]['AIN_No_New']?>
          </td>
          <td align="center">
           <?php echo $profileList[$i]['License_No']?>
          </td>
          <td align="center">
           <?php echo $profileList[$i]['Agent_Code']?>
          </td> 
		   
		<td align="center">
			<form action="<?php echo site_url('cfsModule/editOrgProfile');?>" method="POST">
				<input type="hidden" name="lclID" value="<?php echo $profileList[$i]['profileId'];?>">							
				<input type="submit" value="Edit" name="edit" class="login_button" style="width:90%;">							
			</form> 
        </td> 
		  <td align="center">
           <form action="<?php echo site_url('cfsModule/orgProfileList');?>" method="POST" onsubmit="return validate();">
				<input type="hidden" name="lclID" value="<?php echo $profileList[$i]['profileId'];?>">							
				<input type="submit" value="Delete" name="delete" class="login_button" style="width:100%;">							
			</form> 
          </td> 
		  
         </tr>
         <?php
        }
       ?>
		<tr>
			<td colspan="8" align="center"><p><?php echo $links; ?></p></td>
		</tr>
	</table>
   

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