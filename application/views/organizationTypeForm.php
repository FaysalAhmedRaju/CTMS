   <script>
  
 function validate()
        { 
			

			 if( document.myForm.orgType.value =="" )
					{
						alert( "Please! Provide Organisation Name." );
						document.myForm.orgType.focus() ;
						return false;
					}	
			else if(document.myForm.type_description.value =="")
					{
						alert( "Please!Provide Organisation Description." );
						document.myForm.type_description.focus() ;
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
	<?php include("dbConnection.php"); ?> 

	<form name="myForm" onsubmit="return validate();" action="<?php echo site_url("report/organizationTypeEntryForm");?>" target="_self" method="post">
			<div class="img">
		 	 <!--<div id="login_container">-->
			 <table style="border:solid 1px #ccc;" width="450px" align="center" cellspacing="0" cellpadding="0">
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr><td colspan="3" align="center"><a href="<?php echo site_url('report/organizationTypeList') ?>">BACK TO ORGANIZATION TYPE LIST</a></td></tr>

						<tr>
							<td align="center" colspan="2">&nbsp;</td>
						</tr>
						<!--tr>
							<td align="center" colspan="2">&nbsp;</td>
						</tr--> 

						<tr>
							<th align="center"><label><font color='red'></font>Organization Type:</label></th>
							<td><input type="text" style="width:150px;" id="org_type" name="org_type" <?php if($editFlag==1){ ?> value="<?php echo $formList[0]['Org_Type'];  ?>"<?php } ?>></td>
						</tr>
						<tr>
						<td colspan="2">&nbsp;</td></tr>

						<tr>
							<th align="center"><label><font color='red'></font>Type Description:</label></th>
							<td><input type="textarea" style="width:150px;" id="type_description" name="type_description" <?php if($editFlag==1){ ?> value="<?php echo $formList[0]['Type_description'];  ?>"<?php } ?>></td>
						</tr>
						<tr>
						
						<tr><td colspan="2"> <td><input type="hidden" id="org_id" name="org_id" <?php if($editFlag==1){ ?> value="<?php echo $formList[0]['id'];  ?>"<?php } ?>></td>&nbsp;</td></tr>
						
						<tr>
							<td align="right" colspan="2"></td>
						</tr>
						
						<tr><td colspan="2">&nbsp;</td></tr>

				   <tr>
						 <td align="center" colspan="2">
							 <?php if($editFlag==1){?>
							 <input class="login_button"  name="update" type="submit"  value="UPDATE" > 
							 <?php } else{?>
							  <input class="login_button"  name="save" type="submit"  value="SAVE" > 
							 <?php } ?> 
						 </td>

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
