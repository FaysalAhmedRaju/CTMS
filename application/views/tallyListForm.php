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
		  
		  echo form_open(base_url().'index.php/report/tallyFormList',$attributes);
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
				<table border="0" width="500px" align="center">
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
									<td align="left" ><label for=""><font color='red'></font><nobr>Rotation No : </nobr><em>&nbsp;</em></label></td>
									<td>
									<input type="text" style="width:150px;" id="ddl_imp_rot_no" name="ddl_imp_rot_no" > 
									</td>
									<td align="left" ><label for=""><font color='red'></font><nobr>Container No : </nobr><em>&nbsp;</em></label></td>
									<td>
									<input type="text" style="width:150px;" id="ddl_cont_no" name="ddl_cont_no" > 
									</td>	
									<td  colspan="4" align="right" ><?php $arrt = array('name'=>'submit_login','id'=>'submit','value'=>'Show','class'=>'login_button'); echo form_submit($arrt);?></td>
									<?php echo form_close()?>
								</tr>
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
						<!--td><b>View Appraisement</b></td-->
						<td ><b>Tally Sheet No</b></td>
						<td ><b>Container No</b></td>	
						<!--td ><b>Bl No</b></td-->						
						<td ><b>Rotation</b></td>
						<td ><b>Rcv Pkg</b></td>
						<td ><b>Fault Pack</b></td>
						<td ><b>Loc Fast</b></td>
						<td ><b>Position</b></td>
						<td ><b>Yard/Shed</b></td>
						<td ><b>Unstuffing Date</b></td>
						<td ><b>Report</b></td>
					</tr>
					<?php for($i=0;$i<count($rtnContainerList);$i++){?>
					<tr class="gridLight" align="center">
					
						<!--td align="center"> 
							<form action="<?php echo site_url('report/appraisementCertifyList/'.str_replace("/","_",$rtnContainerList[$i]['BL_NO']).'/'.str_replace("/","_",$rtnContainerList[$i]['rotation']))?>" target="_blank" method="POST">						
								<input type="submit" value="View"  class="login_button" style="width:100%;">							
							</form> 
						</td--> 
						<td style="color:red"><?php echo $rtnContainerList[$i]['tally_sheet_number'];?></td>
						<td><?php echo $rtnContainerList[$i]['cont_number'];?></td>
						<!--td><?php echo $rtnContainerList[$i]['BL_NO'];?></td-->
						<td><?php echo $rtnContainerList[$i]['import_rotation'];?></td>
						<td><?php echo $rtnContainerList[$i]['rcv_pack'];?></td>
						<td><?php echo $rtnContainerList[$i]['flt_pack'];?></td>
						<td><?php echo $rtnContainerList[$i]['loc_first'];?></td>
						<td><?php echo $rtnContainerList[$i]['shed_loc'];?></td>
						<td><?php echo $rtnContainerList[$i]['shed_yard'];?></td>
						<td><?php echo $rtnContainerList[$i]['wr_date'];?></td>
						<td>
							<form name="tallyreport" id="tallyreport" target="_blank" action="<?php echo site_url("ShedBillController/tallyReportPdf");?>" method="post">
								<input type="hidden" name="rotation" id="rotation" value="<?php echo $rtnContainerList[$i]['import_rotation'];?>">
								<input type="hidden" name="container" id="container" value="<?php echo $rtnContainerList[$i]['cont_number'];?>">
								<input type="submit" name="report" value="Report" class="login_button" >
							</form>
						</td>
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