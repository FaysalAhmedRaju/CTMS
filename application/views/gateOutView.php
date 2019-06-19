

<div class="content" style="padding: 30px 0 12px;">
    <div class="content_resize_1" >
      <div class="mainbar_1" style="width:910px">
        <div class="article">
   <h2 align="center"><span><?php echo $title; ?></span> </h2>
   <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
   
   <div class="clr"></div>
   <div class="img">

    <form name= "myForm" action="<?php echo site_url("gateController/gateOutView");?>" method="post">
	
	
	<div align="center">	 
  			<table align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
				<tr>
				<td>&nbsp;</td>
				</tr>
				<tr>
					<td align="left" ><label><font color='red'></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verify No:</label></td>
					<td>
						<input type="text" style="width:130px;" id="verifyNo" name="verifyNo" value=""/>
							&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" value="Search" class="login_button"/> 
					 </td>
				</tr>
				<tr>
				<td>&nbsp;</td>
		     	</tr>
			</table>
					
	 </div>
    </form>
	<br/>
	 
   <form name= "myForm" action="<?php echo site_url("gateController/chalan");?>" method="post" target="_blank">
   
     	<input type="hidden" style="width:140px;" id="verifyNo" name="verifyNo" value="<?php echo $verifyNo; ?>"> 
   
   	<table cellspacing="1" cellpadding="1" align="center"  id="mytbl" style="overflow-y:scroll" >
		   <?php if($tableFlag==1){?>
	<tr><td colspan="12" align="center">  <h3><span><nobr><b><?php echo $tableTitle; ?></b></nobr></span> </h3></td></tr>
		<tr class="gridDark" style="height:35px;" >
		
		
		<font size="15">
			<th>SL</th>
			<th><nobr>Rotation No</nobr></th>
			<th>Cont No</th>
			<th><nobr>Rec.Pack<nobr></th>
			<th><nobr>flt pack<nobr></th>
			<th><nobr>Shed Lock<nobr></th>
			<th><nobr>Lock1st<nobr></th>
			<th><nobr>PackNo.</nobr></th>
			<th><nobr>Pack Dr.</nobr></th>
			<th><nobr>Weight</nobr></th>
			<th><nobr>Notify Name</nobr></th>
			<th><nobr>Consignee</nobr></th>

			</font>
		</tr>
		
	  <?php
       
        for($i=0;$i<count($verifyStatusList);$i++) { 				
		?>
	      <tr class="gridLight">
		  <td>
           <?php echo $i+1;?>
          </td>
          <td align="center">
           <?php echo $verifyStatusList[$i]['import_rotation']?>
          </td>
          <td align="center">
           <?php echo $verifyStatusList[$i]['cont_number']?>
          </td>
          <td align="center">
           <?php echo $verifyStatusList[$i]['rcv_pack']?>
          </td>
          <td align="center">
           <?php echo $verifyStatusList[$i]['flt_pack']?>
          </td> 
		   <td align="center">
           <?php echo $verifyStatusList[$i]['shed_loc']?>
          </td> 
		 <td align="center">
           <?php echo $verifyStatusList[$i]['loc_first']?>
         </td>   
		 <td align="center">
           <?php echo $verifyStatusList[$i]['Pack_Number']?>
         </td>   

		 <td align="center">
           <?php echo $verifyStatusList[$i]['Pack_Description']?>
         </td>   

		 <td align="center">
           <?php echo $verifyStatusList[$i]['weight']?>
         </td>   

		 <td align="center">
           <?php echo $verifyStatusList[$i]['Notify_name']?>
         </td>   

		 <td align="center">
           <?php echo $verifyStatusList[$i]['Consignee_name']?>
         </td>     
		 
         </tr>
		 <tr>
		   	<input type="hidden" style="width:140px;" id="notifyName" name="notifyName" value="<?php echo $verifyStatusList[$i]['Notify_name'] ?>"> 
			<input type="hidden" style="width:140px;" id="notifyAddress" name="notifyAddress" value="<?php echo $verifyStatusList[$i]['Notify_address'] ?>"> 
		 </tr>
		 
		<tr>
         <td colspan="15" align="center">
          <input type="submit" value="INVOICE" class="login_button"/>      
        </td>
      </tr>
		 
         <?php } ?>	 
		 <?php } ?>
	    </table>
		<?php if($tableFlag==1) {?>
		<table align="center"><tr><th><font size= "2"; color="green">Truck Wise Goods Details</font></th><tr></table>
		<table  align="center" width=80% border="1" style="font-size:12px" > 
				<thead style="">
					<tr >		
						<th align="center" ><nobr>TRUCK NO</nobr></th>
						<th align="center" >DESCRIPTION OF GOODS</th>
						<th align="center" >QUANTITY</th>
                        <th align="center" >REMARKS</th>						
					</tr>
				</thead>
				<tbody>
				 <?php       
				for($i=0;$i<count($result3);$i++) { 
				 ?>
				 <tr class="" > 
				  
				  <td align="center">
				   <?php echo $result3[$i]['truck_id']?>
				  </td>
				  <td align="left">
				   <?php echo $goodsDes?>
				  </td>
				  <td align="center">
				   <?php echo $result3[$i]['delv_pack']?>
				  </td>
				  <td align="center">
				   <?php echo $result3[$i]['remarks']?>
				  </td>
				 

				</tr>
				 <?php
				}
			   ?>
			</tbody>
		</table>
		<?php }?>
		
		
		
      </form>
        </div>
          <div class="clr"></div>
        </div>
       
   
      </div>
      <div class="sidebar" style="width:160px">
    <?php include_once("mySideBar.php"); ?>
   </div>
      <div class="clr"></div>
    </div>
 <?php echo form_close()?>
  </div>