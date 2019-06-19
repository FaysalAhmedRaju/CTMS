<html>
	<head>
		<script type="text/javascript">
	function myFormValidation()
      {
		  if(confirm("Do you really want to create Oranization Profile?"))
		  {
			 if( document.profileCreation.org_type.value == "" )
			 {
				alert( "Please select Oranization Type!" );
				document.profileCreation.org_type.focus() ;
				return false;
			 }
			
			 if( document.profileCreation.org_name.value == "" )
			 {
				alert( "Please provide Organization name!" );
				document.profileCreation.org_name.focus() ;
				return false;
			 }
			 if( document.profileCreation.ain_no.value == "" )
			 {
				alert( "Please provide AIIN No!" );
				document.profileCreation.ain_no.focus() ;
				return false;
			 } 
			 if( document.profileCreation.agent_code.value == "" )
			 {
				alert( "Please provide Agent Code!" );
				document.profileCreation.agent_code.focus() ;
				return false;
			 }
			
			 return true ;
		  }
		  else
		  {
			return false;
		  }
		  //alert(document.myChkForm.used_equipment.value);
		
      }
		</script>
	</head>
	<body>
		<script type="text/javascript" src="<?php echo JS_PATH; ?>AdvancedCalender.js"></script>
 <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div align="center" class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
	
		<form name="profileCreation" id="profileCreation" action="<?php echo site_url("cfsModule/org_creation_action"); ?>" method="POST" onsubmit="return myFormValidation();" enctype="multipart/form-data">
			<!--input type="hidden" id="org_id" name="org_id" value="" /-->
			<table>
				<tr>
					<td colspan="3" align="center"><a href="<?php echo site_url('cfsModule/orgProfileList') ?>">Go To Organization Profile List</a></td>
				</tr>
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
						<input list="org_types" value="<?php echo $orgDetailList[0]['Org_Type']; ?>" name="org_type" id="org_type">
						<datalist id="org_types">
							<option value="">---Select---</option> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		
							<?php for($i=0; $i<count($orgList); $i++){ ?>
								<option value="<?php echo $orgList[$i]['Org_Type']; ?>" 
								id="<?php echo $orgList[$i]['id']; ?>"
								label="<?php echo $orgList[$i]['Org_Type']; ?>" 
								>
								</option>
							<?php } ?>	
						</datalist>
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
						<input type="text" id="org_name" name="org_name" <?php if($editFlag==1){?> value="<?php echo $orgDetailList[0]['Organization_Name'] ?>" <?php } ?>/>
						<input type="hidden" id="org_prof_id" name="org_prof_id" <?php if($editFlag==1){?> value="<?php echo $orgDetailList[0]['profileId'] ?>" <?php } ?>/>
					</td>
				</tr>
				<tr>
					<td>
						AIN No
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<input type="text" id="ain_no" name="ain_no"  <?php if($editFlag==1){?> value="<?php echo $orgDetailList[0]['AIN_No_New'] ?>" <?php } ?>/>
					</td>
				</tr>
				<tr>
					<td>
						License No
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<input type="text" id="license_no" name="license_no" <?php if($editFlag==1){?> value="<?php echo $orgDetailList[0]['License_No'] ?>" <?php } ?>/>
					</td>
				</tr>
				<tr>
					<td>
						License Issue Date
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<input type="date" id="license_issue_dt" name="license_issue_dt" <?php if($editFlag==1){?> value="<?php echo $orgDetailList[0]['License_issue_Date'] ?>" <?php } ?>/>
					</td>
				</tr>
				<tr>
					<td>
						License Validity Date
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<input type="date" id="license_validity_dt" name="license_validity_dt"  <?php if($editFlag==1){?> value="<?php echo $orgDetailList[0]['Licence_Validity_Date'] ?>" <?php } ?>/>
					</td>
				</tr>
				<tr>
					<td>
						Address 1
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<input type="text" id="address_1" name="address_1" <?php if($editFlag==1){?> value="<?php echo $orgDetailList[0]['Address_1'] ?>" <?php } ?>/>
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
						<input type="text" id="address_2" name="address_2"<?php if($editFlag==1){?> value="<?php echo $orgDetailList[0]['Address_2'] ?>" <?php } ?>/>
					</td>
				</tr>
				<tr>
					<td>
						Address 3
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<input type="text" id="address_3" name="address_3" <?php if($editFlag==1){?> value="<?php echo $orgDetailList[0]['Address_3'] ?>" <?php } ?>/>
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
						<input type="text" id="land_phone" name="land_phone" <?php if($editFlag==1){?> value="<?php echo $orgDetailList[0]['Telephone_No_Land'] ?>" <?php } ?>/>
					</td>
				</tr>
				<tr>
					<td>
						Cell Phone 1
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<input type="text" id="cell_phone_1" name="cell_phone_1" <?php if($editFlag==1){?> value="<?php echo $orgDetailList[0]['Cell_No_1'] ?>" <?php } ?>/>
					</td>
				</tr>
				<tr>
					<td>
						Cell Phone 2
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<input type="text" id="cell_phone_2" name="cell_phone_2" <?php if($editFlag==1){?> value="<?php echo $orgDetailList[0]['Cell_No_2'] ?>" <?php } ?>/>
					</td>
				</tr>
				<tr>
					<td>
						Fax No
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<input type="text" id="fax_no" name="fax_no" <?php if($editFlag==1){?> value="<?php echo $orgDetailList[0]['Fax_No'] ?>" <?php } ?>/>
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
						<input type="text" id="email" name="email" <?php if($editFlag==1){?> value="<?php echo $orgDetailList[0]['email'] ?>" <?php } ?>/>
					</td>
				</tr>
				<tr>
					<td>
						URL
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<input type="text" id="url" name="url" <?php if($editFlag==1){?> value="<?php echo $orgDetailList[0]['URL'] ?>" <?php } ?>/>
					</td>
				</tr>
				<!--tr>
					<td>
						User Action
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<input type="text" id="user_action" name="user_action" />
					</td>
				</tr>
				<tr>
					<td>
						License No Dh
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<input type="text" id="license_no_dh" name="license_no_dh" />
					</td>
				</tr-->
				<tr>
					<td>
						Agent Code
					</td>
					<td>
						<b>:</b>
					</td>
					<td>
						<input type="text" id="agent_code" name="agent_code" <?php if($editFlag==1){?> value="<?php echo $orgDetailList[0]['Agent_Code'] ?>" <?php } ?>/>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="3">
						<input type="submit" name="submit" id="submit" value="Create" class="login_button" >
					</td>
				</tr>
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