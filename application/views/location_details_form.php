<script type="text/javascript">  
	function validate()
	{
		if(document.location_form.location_name.value == "")
		{
			alert("Please provide location name!");
			document.location_form.location_name.focus();
			return false;
		}
		return true ;
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
					<form name="location_form" id="location_form" onsubmit="return(validate());" action="<?php echo site_url("report/location_details_save");?>" method="post">
						<input type="hidden" id="location_id" name="location_id" value="<?php echo $rslt_location_info[0]['id']; ?>" />
						<table align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td colspan="3" align="center"><?php echo $msg; ?></td>
							</tr>
							<tr>
								<td colspan="3">&nbsp;</td>
							</tr>
							
							<tr>
								<td align="right" ><label><font color='red'><b>*</b></font><nobr>Location Name </nobr></label></td>
								<td align="right" >:</td>
<!--                                                        <td>
								<input style="white-space:pre-wrap;background-color:#FF9;width: 200px;" name="location" type="search" list="loc" placeholder="Location" >	
								<datalist id="loc">
								<?php 
								for($i=0; $i<count($location_list); $i++){  ?>
								  <option data-value="<?php echo $location_list[$i]['id']?>" value="<?php echo $location_list[$i]['location_name']?>"></option>
								<?php } ?>
								
								  echo '<option value="'.$location_list[$i]['id'].'">'.$location_list[$i]['location_name'].'</option>';
												} ?>


         
							 
								</datalist>
                                                            </td>-->
								
						<th>
						<select  id="location" name="location" style="width:215px;" value=""  >
						<option value="">--Select--</option>
                                              <?php if($editFlag==1){?> 
                                                <option value="<?php echo $loc_list[0]['locId']; ?>" selected="true"><?php echo $loc_list[0]['location_name']; ?></option>
                                               <?php }  ?>    
                                                
						<?php
						for($i=0; $i<count($location_list); $i++){ ?>
                                            <option value="<?php echo $location_list[$i]['id']; ?>"><?php echo $location_list[$i]['location_name']; ?></option>
												   <?php } ?>
									</select>	 				
								</th> 
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="right" ><label><font color='red'><b>*</b></font><nobr>Location Details </nobr></label></td>
								<td align="right" >:</td>
								<td>
                                                                        <textarea type="text" style="width:250px; height: 70px" rows="6" name="location_detail" id="location_detail" value=""><?php if($editFlag==1){ echo $loc_list[0]['location_details']; }?> </textarea>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
                                                        <tr>
								<td><input class="read" type="hidden"  id="loc_dt_id" name="loc_dt_id"  <?php if($editFlag==1){?> value="<?php echo $loc_list[0]['loc_dtl_id']; }?>"</td>
							</tr>
							<tr>
								<td colspan="3" align="center">
                                                                    <?php if($editFlag==1){ ?>
                                                                    <input class="login_button"  name="update" type="submit"  value="UPDATE" > 
                                                                    <?php } else{?>
                                                                     <input class="login_button"  name="save" type="submit"  value="SAVE" > 
                                                                    <?php } ?>    
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
</div>