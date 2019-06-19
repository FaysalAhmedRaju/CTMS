<script>
    function validate()
    {
        if (confirm("Are you sure!! Delete this record?") == true) {
		   return true ;
		} 
		else 
		{
			return false;
        }		 
    }
</script>
<div class="content">
    <div class="content_resize">
		<div class="mainbar">
			<div class="article">
				<h2 align="left"><span><?php echo $title; ?></span> </h2>
				<p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
				<div class="clr"></div>	  
				<div class="img">
					<form name= "myForm"  action="<?php echo site_url("report/equipmentEntryFormPerform");?>" method="post">
						<table align="center"> 
                            <tr>
                                <th align="left"><nobr>Workshop Zone</nobr></th> 
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <td>
                                    <select  id="zone" name="zone" style="width:180px;"  onchange="showValue(this.value)" >
										<option value="">--Select--</option>
                                        <?php if($editFlag==1){?> 
                                        <option value="<?php echo $select_result[0]['workshop_zone']; ?>" selected="true"><?php echo $select_result[0]['workshop_zone']; ?></option>
                                        <?php }  ?> 
                                        <option value="AB">AB</option>
                                        <option value="C">C</option>
										<option value="D">D</option>
									</select>
                                </td>  				
                            </tr>
                            <tr>
                                <th align="left"><nobr>Equipment</nobr></th> 
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <td>
                                    <select  id="equipment" name="equipment" style="width:180px;"  onchange="showValue(this.value)" >
										<option value="">--Select--</option>
                                        <?php if($editFlag==1){?> 
                                        <option value="<?php echo $select_result[0]['equipment']; ?>" selected="true"><?php echo $select_result[0]['equipment']; ?></option>
                                        <?php }  ?> 
                                        <option value="SC">SC</option>
										<option value="QGC">QGC</option>
										<option value="RTG">RTG</option>
										<option value="MHC">MHC</option>
										<option value="RMG">RMG</option>
										<option value="RST Loaded 45 Ton">RST Loaded 45 Ton</option>
										<option value="FLT 42 Ton">FLT 42 Ton</option>
										<option value="FLT 16 Ton">FLT 16 Ton</option>
										<option value="RST 7 Ton">RST 7 Ton</option>
										<option value="FLT 10 Ton">FLT 10 Ton</option>
										<option value="CM">CM</option>
									</select>
                                </td>  				
                            </tr>                            
                            <tr>
                                <th align="left"><nobr>Total Equipment</nobr></th>
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <td><input class="read" type="text" style="width:180px;"  id="total_equip" name="total_equip"   <?php if($editFlag==1){?> value="<?php echo $select_result[0]['equip_num']; ?>" <?php }?> ></td>				
                            </tr>
							<tr>
                                <th align="left"><nobr>Supply</nobr></th>
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <td><input class="read" type="text" style="width:180px;"  id="total_supply" name="total_supply"   <?php if($editFlag==1){?> value="<?php echo $select_result[0]['equip_supply']; ?>" <?php }?> ></td>				
                            </tr>  
							<tr>
                                <th align="left"><nobr>Out of Order</nobr></th>
                                <th align=""><nobr>&nbsp; &nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</nobr></th>
                                <td><input class="read" type="text" style="width:180px;"  id="nonOperational" name="nonOperational"   <?php if($editFlag==1){?> value="<?php echo $select_result[0]['non_operational']; ?>" <?php }?> ></td>				
                            </tr> 
                            
							<input type="hidden" id="equipID" name="equipID" <?php if($editFlag==1){?> value="<?php echo $select_result[0]['id']; }?>">							
							<tr><td colspan="3">&nbsp;</td></tr> 
                            <tr>
                                <td align="right" colspan="3">
                                    <?php 
									if($editFlag==1)
									{
									?>
										<input class="login_button" name="update" type="submit" value="UPDATE" > 
                                    <?php 
									} 
									else
									{ 
									?>
										<input class="login_button" name="save" type="submit" value="SAVE" > 
                                    <?php 
									} 
									?> 
                                </td>
								<td colspan="3" align="center">
									<input style="width:100px" name="go_to_dashboard" id="go_to_dashboard" type="submit" value="Go To Dashboard" class="login_button" />
								</td>
							</tr>
                            <tr>
                                <td align="right" colspan="3"><?php echo $msg; ?> </td>
							</tr>
							<tr>
								<td align="right" colspan="3"><input class="read" type="hidden"  id="rcvid" name="rcvid"  <?php if($editFlag==1){?> value="<?php echo $product_details[0]['rcv_id']; }?>"</td>
							</tr>				
						</table>
					</form>
					<table cellspacing="1" cellpadding="1" align="center"  id="mytbl" style="overflow-y:scroll" width="600px">
						<tr><td colspan="12" align="center">  <h2><span><font color="green"  size="4" style="font-weight: bold"><nobr><?php echo $tableTitle; ?></nobr></font></span> </h2></td></tr>
						<tr class="gridDark" style="height:35px;">		
							<font size="15">
							<th>SL</th>
							<th><nobr>Workshop <nobr></th>
							<th><nobr>Equipment<nobr></th>        
							<th><nobr>Total Equipment<nobr></th>
							<th><nobr>Supply<nobr></th>
							<th><nobr>Out of Order<nobr></th>
							<!--<th><nobr>Location Details</nobr></th>-->
							<th><nobr>Edit</nobr></th>
							<th><nobr>Delete</nobr></th>
							</font>
						</tr>
		
						<?php
						for($i=0;$i<count($result);$i++) 
						{ 				
						?>
						<tr class="gridLight">
							<td><?php echo $i+1;?></td>         
							<td align="center">
								<?php echo $result[$i]['workshop_zone']?>
							</td>   
							<td align="center">
								<?php echo $result[$i]['equipment']?>
							</td>   

							<td align="center">
								<?php echo $result[$i]['equip_num']?>
							</td>  
							<td align="center">
								<?php echo $result[$i]['equip_supply']?>
							</td>   
							<td align="center">
								<?php echo $result[$i]['non_operational']?>
							</td> 

							<td align="center">
								<form action="<?php echo site_url('report/equipmentEntryFormEdit');?>" method="POST">
									<input type="hidden" id="eqiID" name="eqiID" value="<?php echo $result[$i]['id'];?>">							
									<input type="submit" value="Edit"  class="login_button" style="width:100%;">							
								</form> 
							</td> 
	
							<td align="center"> 
								<form action="<?php echo site_url('report/equipmentEntryForm');?>" method="POST" onsubmit="return validate();">
									<input type="hidden" id="eid" name="eid" value="<?php echo $result[$i]['id'];?>">							
									<input type="submit" value="Del." name="delete" class="login_button" style="width:100%;">
								</form> 
							</td> 
		
						<?php 
						}
						?>
					</tr>		
				</table>
			</div>
			
          <div class="clr"></div>
        </div>

      </div>
      <div class="sidebar" style="width:140px; padding: 0px 0 12px;">
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	<?php echo form_close()?>
  </div>