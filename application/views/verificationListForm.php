  <script>
  function validate()
   {
	if (confirm("Do you want to detete this Verification Number?") == true)
	{
		return true ;
    }
    else
	{
	   return false;
    }
   }
   	
 </script>
 <style>
 #table-scroll {
  height:350px;
  width:650px;
  overflow:auto;  
  margin-top:20px;
}
 </style>
 <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
		  
		  <?php 
		  $attributes = array('target' => '', 'id' => 'myform');
		  
		  echo form_open(base_url().'index.php/report/verificationListFormView',$attributes);
			$Stylepadding = 'style="padding: 12px 20px;"';
				if(!empty($error_message))
				{
					$Stylepadding = 'style="padding:25px 20px;"';
				}	
				if(isset($captcha_image)){
					$Stylepadding = 'style="padding:62px 20px 93px;"';
				}?>
	
		<div class="img">
		 	 <!--<div id="login_container">-->
			 <table style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
				<tr><td>
				<table border="0" width="300px" align="center">
								<tr>
									<td align="right" colspan="2"></td>
								</tr>
								
								
								<!--tr><br />
									<td align="right" ><label for="rotation_no">Rotation No.:<em>&nbsp;</em></label></td>
									<td align="left" >
									
										<?php 
										//$attribute = array('name'=>'rot','id'=>'txt_login','class'=>'login_input_text');
											//echo form_input($attribute,set_value('rot'));
										?> 
									</td>
								</tr>
								
								-->  
								
								 <tr>
									<td align="left" ><label for=""><font color='red'></font><nobr>Verify Number : </nobr><em>&nbsp;</em></label></td>
									<td>
									<input type="text" style="width:150px;" id="strVerifyNum" name="strVerifyNum" > 
									</td>
									<td  colspan="2" align="center" ><?php $arrt = array('name'=>'submit_login','id'=>'submit','value'=>'Show','class'=>'login_button'); echo form_submit($arrt);?></td>
									<?php echo form_close()?>
									
								</tr>
								
								<tr>
									<td align="right" colspan="2"></td>
								</tr>

									
								</tr>
								
								<tr>
									
									<!--form action="<?php echo site_url('ShedBillController/getShedStockBalancePdf')?>" method="POST" target="_blank">
										<input type="hidden" name="vNum" value = "<?php echo $vNum; ?>"/>
										<td  align="left" ><input type="submit" class="login_button" value="Get PDF"/></td>
									</form-->
									<!--<td colspan="2" align="center" width="70px"><?php $arrt = array('name'=>'submit_login','id'=>'submit','value'=>'Download Excel for EDI','class'=>'login_button'); echo form_submit($arrt);?></td>-->
									<!--<a href="excelFormatForEdiConverter" target="_blank">Download Excel for EDI</a>-->
								</tr>
								<tr><td colspan="2">&nbsp;</td></tr>
							</table>
						</td>
					</tr>
				</table>
				
		 
		 <!--</div>-->
		 </div>
		 
         <!-- <div class="post_content">
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. <a href="#">Suspendisse bibendum. Cras id urna.</a> Morbi tincidunt, orci ac convallis aliquam, lectus turpis varius lorem, eu posuere nunc justo tempus leo. Donec mattis, purus nec placerat bibendum, dui pede condimentum odio, ac blandit ante orci ut diam. Cras fringilla magna. Phasellus suscipit, leo a pharetra condimentum, lorem tellus eleifend magna, eget fringilla velit magna id neque. Curabitur vel urna. In tristique orci porttitor ipsum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. Suspendisse bibendum. Cras id urna. Morbi tincidunt, orci ac convallis aliquam, lectus turpis varius lorem, eu posuere nunc justo tempus leo.</p>
            <p><strong>Aenean consequat porttitor adipiscing. Nam pellentesque justo ut tortor congue lobortis. Donec venenatis sagittis fringilla.</strong> Etiam nec libero magna, et dictum velit. Proin mauris mauris, mattis eu elementum eget, commodo in nulla. Mauris posuere venenatis pretium. Maecenas a dui sed lorem aliquam dictum. Nunc urna leo, imperdiet eu bibendum ac, pretium ac massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla facilisi. Quisque condimentum luctus ullamcorper.</p>
            <p class="spec"><a href="#" class="rm">Read more &raquo;</a></p>
			
			
          </div>-->
		  <?php echo form_close()?>
          <div class="clr"></div>
        </div>
       <div id="table-scroll">
			<table  style="border:1px solid #ccc;" >
					<tr class="gridDark" align="center">
						<td><b>View Certification</b></td>
						<td><b>Truck Add</b></td>
						<?php if($login_id!='devcf'){?>
						<td><b>Action</b></td>
						<?php } ?>
						<td ><b>Verify Number</b></td>						
						<td ><b>Rotation</b></td>
						<td ><b>Container</b></td>
						<td ><b>MBL</b></td>
						<td ><b>FBL</b></td>
						<td ><b>Size</b></td>
						<td ><b>Type</b></td>
						<td ><b>Status</b></td>
						<td ><b>Qnty</b></td>
						<td ><b>Pkgs</b></td>
						<td ><b>Importer</b></td>
						<td ><b>Gross weight</b></td>
								
					</tr>
					<?php for($i=0;$i<count($rtnContainerList);$i++){?>
					<tr class="gridLight" align="center">
					
						<td align="center"> 
							<form action="<?php echo site_url('report/certificationFormViewList/'.str_replace("/","_",$rtnContainerList[$i]['BL_No']).'/'.str_replace("/","_",$rtnContainerList[$i]['import_rotation']))?>" method="POST">
								<input type="submit" value="View"  class="login_button" style="width:100%;">							
							</form> 
						</td>
						<td align="center"> 
							<form action="<?php echo site_url('ShedBillController/bilSearchByVerifyNumber/'.$rtnContainerList[$i]['verify_number'])?>" method="POST">
								<input type="submit" value="Add Truck"  class="login_button" style="width:100%;">							
							</form> 
						</td> 
					<?php if($login_id!='devcf'){?>
						<td align="center"> 
						<form  name= "delForm" onsubmit="return validate();" action="<?php echo site_url('report/deleteVerificationNumber/'.str_replace("/","_",$rtnContainerList[$i]['verify_number']));?>" method="POST">
							<input type="submit" id="delButton" value="Delete"  class="login_button" style="width:100%;">
						</form>	
					    </td> 
					<?php } ?>	
						<td style="color:red"><?php echo $rtnContainerList[$i]['verify_number'];?></td>
						<td><?php echo $rtnContainerList[$i]['import_rotation'];?></td>
						<td><?php echo $rtnContainerList[$i]['cont_number'];?></td>
						<td><?php echo $rtnContainerList[$i]['master_BL_No'];?></td>
						<td><?php echo $rtnContainerList[$i]['BL_No'];?></td>
						<td><?php echo $rtnContainerList[$i]['cont_size'];?></td>
						<td><?php echo $rtnContainerList[$i]['cont_type'];?></td>
						<td><?php echo $rtnContainerList[$i]['cont_status'];?></td>
						<td><?php echo $rtnContainerList[$i]['Pack_Number'];?></td>
						<td><?php echo $rtnContainerList[$i]['Pack_Description'];?></td>		
						<td><?php echo $rtnContainerList[$i]['Notify_name'];?></td>
						<td><?php echo $rtnContainerList[$i]['cont_weight'];?></td>
					
					</tr>
					<?php }?>
				</table>
		 </div>
       <!-- <p class="pages"><small>Page 1 of 2</small> <span>1</span> <a href="#">2</a> <a href="#">&raquo;</a></p>-->
      </div>
      <div class="sidebar">
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	
  </div>