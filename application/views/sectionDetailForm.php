   <script>
  
 function validate()
        { 
			if( document.myForm.orgType.value =="" )
					{
						alert( "Please! Select Organisation." );
						document.myForm.orgType.focus() ;
						return false;
					}
			else if(document.myForm.shortName.value =="")
					{
						alert( "Please! Provide Short Name." );
						document.myForm.shortName.focus() ;
						return false;
					}	
			else if( document.myForm.fullName.value =="")
					{
						alert( "Please! Provide Full Name." );
						document.myForm.fullName.focus() ;
						return false;
					}
			else
					return true;
		}
   	
 </script>  

<div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span></h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
		  

	<form name="myForm" onsubmit="return validate();" action="<?php echo site_url("menuDesignController/sectionDetailsFormPerform");?>" target="_self" method="post">
			<div class="img">
		 	 <!--<div id="login_container">-->
			 <table style="border:solid 1px #ccc;" width="450px" align="center" cellspacing="0" cellpadding="0">
								<tr><td colspan="2">&nbsp;</td></tr>

								<tr>
									<td align="right" colspan="2"></td>
								</tr>
								<tr>
								<th align="center"><label><font color='red'></font>Org Type:</label></th>
								<td>
									<select  id="orgType" name="orgType" style="width:150px;">
										<option value="">--Select--</option>
									<?php
									include("mydbPConnection.php");
									$sql_org_list="select * from tbl_org_types";
									$result_org_list=mysql_query($sql_org_list);
									while($orgList=mysql_fetch_object($result_org_list))
									{
									?>
										<option value="<?php echo $orgList->id; ?>"><?php echo $orgList->Org_Type; ?></option>
									<?php
									}
									?>
									</select>
								</td>
								</tr>
								
								<tr><td colspan="2">&nbsp;</td></tr>

								<tr>
									<th align="center"><label><font color='red'></font>Short Name:</label></th>
									<td><input type="text" style="width:150px;" id="shortName" name="shortName"></td>
								</tr>
								<tr><td colspan="2">&nbsp;</td></tr>

								<tr>
									<th align="center"><label><font color='red'></font>Full Name:</label></th>
									<td><input type="text" style="width:250px;" id="fullName" name="fullName"></td>
								</tr>			
								<tr><td colspan="2">&nbsp;</td></tr>

									
								<tr>
									<td align="right" colspan="2"></td>
								</tr>
								
								<tr><td colspan="2">&nbsp;</td></tr>

						<tr>
					   <td colspan="2" align="center"><button class="login_button">Submit</button></td>
					</tr>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr><td colspan="2" align="center"><?php echo $msg; ?></td></tr>
				</table>
			</div>
		</form>	
          <div class="clr"></div>
        </div>
       
      </div>
      <div class="sidebar">
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
  </div>
