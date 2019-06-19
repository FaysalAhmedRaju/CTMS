 <style>
 #table-scroll {
  height:600px;
  width:850px;
  overflow:auto;  
  margin-top:20px;
}
 </style>
 <div class="content">
    <div class="content_resize_1">
      <div class="mainbar_1">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
		  
		  <?php 
		  $attributes = array('target' => '', 'id' => 'myform');
		  
		  echo form_open(base_url().'index.php/report/viewVesselListSearchList',$attributes);
			$Stylepadding = 'style="padding: 12px 20px;"';
				if(!empty($error_message))
				{
					$Stylepadding = 'style="padding:25px 20px;"';
				}	
				if(isset($captcha_image)){
					$Stylepadding = 'style="padding:62px 20px 93px;"';
				}?>
		<div align="center"><?php echo $msg;?></div>
		<div class="img">
		 	 <!--<div id="login_container">-->
			 <table style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
				<tr><td>
				<table border="0" width="500px" align="center">
								 <tr>
									<td align="left" ><label for=""><font color='red'></font>Rotation Number : <em>&nbsp;</em></label></td>
									<td>
									<input type="text" style="width:150px;" id="rot_num" name="rot_num" > 
									</td>
									<td><?php $arrt = array('name'=>'submit_login','id'=>'submit','value'=>'Show','class'=>'login_button'); echo form_submit($arrt);?></td>
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
						<td ><b>SL.</b></td>
						<td ><b>Vessel Name</b></td>							
						<td ><b>Imp Rot</b></td>
						<td ><b>Exp Rot</b></td>
						<td ><b>Agent</b></td>
						<td ><b>Berth Operator</b></td>
						<td ><b>Status</b></td>
						<td ><b>ETA</b></td>
						<td ><b>ETD</b></td>
						<td ><b>ATA</b></td>
						<td ><b>ATD</b></td>
						<td ><b>Action</b></td>
						<?php if($login_id=="porikkhit") {?>
						<td ><b>Comments</b></td>
						<td ><b>Status</b></td>
						<td ><b>Action</b></td>
						<?php } ?>
					</tr>
					<?php for($i=0;$i<count($rtnVesselList);$i++){
						
						?>
					<tr class="gridLight" align="center">
						<td style="color:red"><?php echo $i+1;?></td>
						<td style="display:none"><?php echo $rtnVesselList[$i]['vvd_gkey'];?></td>
						<td><?php echo $rtnVesselList[$i]['name'];?></td>
						<td><?php echo $rtnVesselList[$i]['ib_vyg'];?></td>
						<td><?php echo $rtnVesselList[$i]['ob_vyg'];?></td>						
						<td><?php echo $rtnVesselList[$i]['agent'];?></td>						
						<td><?php echo $rtnVesselList[$i]['berthop'];?></td>						
						<td 
							<?php if ($rtnVesselList[$i]['phase_num']=='20')
									{?>style="background-color:#F6D8CE"<?php } else if($rtnVesselList[$i]['phase_num']=='30'){?>style="background-color:#F78181" <?php } else if($rtnVesselList[$i]['phase_num']=='40'){?>style="background-color:#FACC2E"<?php } else if($rtnVesselList[$i]['phase_num']=='50'){?>style="background-color:#F5A9A9"<?php } else if($rtnVesselList[$i]['phase_num']=='60'){?>style="background-color:#610B0B"<?php }?>>
							
						
						<?php echo $rtnVesselList[$i]['phase_str'];?></td>
						
						
						<td><?php echo $rtnVesselList[$i]['eta'];?></td>
						<td><?php echo $rtnVesselList[$i]['etd'];?></td>
						<td><?php echo $rtnVesselList[$i]['ata'];?></td>
						<td><?php echo $rtnVesselList[$i]['atd'];?></td>
						<td>
							<form style="display:inline" action="<?php echo site_url('report/myExportImExSummeryView/'.str_replace("/","_",$rtnVesselList[$i]['ib_vyg']))?>" target="_blank" method="POST">
								<input class="login_button" id="VwBtn" type="submit" value="Summary"/>
							</form>
							
							<form style="display:inline margin-top:2%" action="<?php echo site_url('report/myExportExcelUploadSampleReportView/'.str_replace("/","_",$rtnVesselList[$i]['ib_vyg']))?>" target="_blank" method="POST">
								<input class="login_button" style="background-color:green" id="VwBtn" type="submit" value="Details"/>
							</form>
						</td>
						<?php if($login_id=="porikkhit") {?>
						<td>
							<form style="display:inline" action="<?php echo site_url('report/vesselListWithStatusEntry')?>" method="POST">
								<?php 
								include_once("mydbPConnection4.php");
								$vvd_gkey = $rtnVesselList[$i]['vvd_gkey'];
								$strGkey = "select pre_comments from ctmsmis.mis_exp_vvd where vvd_gkey='$vvd_gkey'";
								
								$resComment = mysql_query($strGkey);
								$rowComment=mysql_fetch_object($resComment);
								$RcvComment = $rowComment->pre_comments;
								//echo "test : ".$resComment;
								?>
								<input style="width:100px;" id="remarks" type="text" name="remarks" value="<?php echo $RcvComment;?>"/>							
								<input id="vvd_gkey" type="hidden" name="vvd_gkey" value="<?php echo $rtnVesselList[$i]['vvd_gkey'];?>"/>							
						</td>
						<td>
								<?php 
								include_once("mydbPConnection4.php");
								$vvd_gkey = $rtnVesselList[$i]['vvd_gkey'];
								$strGkey = "select comments from ctmsmis.mis_exp_vvd where vvd_gkey='$vvd_gkey'";
								
								$resComment = mysql_query($strGkey);
								$rowComment=mysql_fetch_object($resComment);
								$RcvComment = $rowComment->comments;
								//echo "test : ".$resComment;
								echo $RcvComment;
								?>							
						</td>
						<td>							
						<!-- insert into mis_exp_vvd (vvd_gkey,comments,comments_by,comments_time,user_ip) values()-->
								<input class="login_button" id="SaveBtn" type="submit" value="Save"/>
							</form>
						</td>
						<?php } ?>
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