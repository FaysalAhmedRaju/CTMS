 <style>
 #table-scroll {
  height:600px;
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
		  
		  echo form_open(base_url().'index.php/report/viewVesselStatusSearchList',$attributes);
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
			 <table style="border:solid 1px #ccc;" width="400px" align="center" cellspacing="0" cellpadding="0">
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
			<table align="center" style="border:1px solid #ccc;" >
					<tr class="gridDark" align="center">
						<td ><b>SL.</b></td>
						<td ><b>Vessel Name</b></td>							
						<td ><b>Imp Rot</b></td>
						<td ><b>Exp Rot</b></td>
						<td ><b>Agent</b></td>
						<td ><b>Status</b></td>
						<td ><b>Arrival</b></td>
						<td ><b>Shifting</b></td>
						<td ><b>Departure</b></td>
						<td ><b>Report</b></td>
					</tr>
					<?php for($i=0;$i<count($rtnVesselList);$i++){
						
						
						?>
					<tr class="gridLight" align="center">
						<td style="color:red"><?php echo $i+1;?></td>
						<td style="display:none"><?php echo $rtnVesselList[$i]['vvd_gkey'];?></td>
						<td>
							<!--a href="<?php echo site_url('report/departureReportOfVessel/'.str_replace("/","_",$rtnVesselList[$i]['ib_vyg']))?>" target="_blank" method="POST">
								<?php echo "<b>".$rtnVesselList[$i]['name']."</b>";?>
							</a-->
							<?php echo "<b>".$rtnVesselList[$i]['name']."</b>";?>
						</td>
						<td><?php echo $rtnVesselList[$i]['ib_vyg'];?></td>
						<td><?php echo $rtnVesselList[$i]['ob_vyg'];?></td>						
						<td><?php echo $rtnVesselList[$i]['agent'];?></td>											
						<td 
							<?php if ($rtnVesselList[$i]['phase_num']=='20')
									{?>style="background-color:#F6D8CE"<?php } else if($rtnVesselList[$i]['phase_num']=='30'){?>style="background-color:#F78181" <?php } else if($rtnVesselList[$i]['phase_num']=='40'){?>style="background-color:#FACC2E"<?php } else if($rtnVesselList[$i]['phase_num']=='50'){?>style="background-color:#F5A9A9"<?php } else if($rtnVesselList[$i]['phase_num']=='60'){?>style="background-color:#610B0B"<?php }?>>
													
						<?php echo $rtnVesselList[$i]['phase_str'];?></td>
						
						<td>
							<a href="<?php echo site_url('report/departureReportOfVessel/A/'.str_replace("/","_",$rtnVesselList[$i]['ib_vyg']))?>" target="_blank" method="POST" >
								<?php echo "ARRAIVAL"; ?>
								<!--button type="button" class="login_button">ARRAIVAL</button-->
							</a>
						</td>
						<td>
							<a href="<?php echo site_url('report/departureReportOfVessel/S/'.str_replace("/","_",$rtnVesselList[$i]['ib_vyg']))?>" target="_blank" method="POST">
								<?php echo "SHIFTING"; ?>
								<!--button type="button" class="login_button">SHIFTING</button-->
							</a>
						</td>
						<td>
							<a href="<?php echo site_url('report/departureReportOfVessel/D/'.str_replace("/","_",$rtnVesselList[$i]['ib_vyg']))?>" target="_blank" method="POST">
								<?php echo "DEPARTURE"; ?>
								<!--button type="button" class="login_button">DEPARTURE</button-->
							</a>
						</td>
						<td>
							<a href="<?php echo site_url('report/departureReportOfVessel/R/'.str_replace("/","_",$rtnVesselList[$i]['ib_vyg']))?>" target="_blank" method="POST">
								<?php echo "View"; ?>
								<!--button type="button" class="login_button">DEPARTURE</button-->
							</a>
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