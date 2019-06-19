 <div class="content"> 
    <div class="content_resize">
		<div>
			<div>
				<h2 style="width:90%;color:#000;text-align:center;"><span>Chittagong Port</span> Authority</h2>
				<p align="center" style="width:90%;color:#000;text-align:center;font-size:16px;">Today: 
					<span class="date">
					<?php 
						$timezone  = 6; //(GMT -6:00) EST (Dhaka)
						echo gmdate("F j, Y, g:i a", time() + 3600*($timezone+date("I"))); 
					?>
					</span> 
				</p>	
			</div>
			<div style="width:100%;">
				<p style="text-align:justify;color:#000;font-size:16px;padding:10px;">The Chittagong Port is the principal seaport of Bangladesh handling about 92% of import-export trade of the country. As such its importance in the national economy is paramount. The Chittagong Port Authority (CPA) is a basic services provider. Its objective focuses mainly on providing necessary services and facilities to the port users efficiently and effectively at competitive price.</p>
				<p style="text-align:justify;color:#000;font-size:16px;padding:10px;"><b>Considering the growing need of containerization the CPA has developed the New Mooring Container Terminal (NCT) in the port adjacent to existing container terminal CCT.</b></p>
			</div>
		</div>
		<div class="mainbar">
			<div class="article">
				<div>
					<div style="border:1px solid black;color:#000;" align="center" id="login_container">
					<?php
						$attributes = array('name' => 'frm2');
						echo form_open(base_url().'index.php/report/mySearchContainerLocation',array('name' =>'frm3','onsubmit' => 'isValidation();','target'=>'_BLANK'));
						$Stylepadding = 'style="padding: 12px 20px;"';
						?>
						<!--a href='".site_url('report/containerHandlingView')."' target='_blank'>Container Handling today</a-->
					
							<table>
								<tr><td colspan="3" align="center"><h2><span style="color:#000;">Container Location</span></h2></td></tr>
								<tr>
									<td>
										<label for="user_name">Container No.:</label>
									</td>
									<td>
										<?php $attribute = array('name'=>'containerLocation','id'=>'containerLocation','class'=>'login_input_text');
										echo form_input($attribute,set_value('containerLocation'));
										?>
									</td>
									<td><?php $arrt = array('name'=>'submit_login','id'=>'submit','value'=>'Search','class'=>'login_button'); echo form_submit($arrt);?></td>
								</tr>
							</table>	
						</form>
					</div>
					<!--div class="clr"></div>
			<br/-->
					<div>
					<table>
					<tr><td></td><tr>
					</table>
					</div>

					<div style="border:1px solid black;color:#000;" align="center" id="login_container">
					<form name= "myForm" onsubmit="return(validate());" action="<?php echo site_url("report/berthReportView");?>" target="_blank" method="post">
					<table >
						<tr align="center" valign="center">
							<td>
								<table>
								    <tr><td colspan="3" align="center"><h2><span style="color:#000;">Berthing Report</span></h2></td></tr>
										<tr>
										   <th align="left"><label><nobr> From Date: </nobr> </label></th>
											<td>
											 <input type="date" style="width:140px;"  id="fromdate" name="fromdate" value=""/>
											</td>
										  </tr>
										   <tr>
										   <th align="left"><label><nobr> To Date: </nobr> </label></th>
											 <td>
											 <input type="date" style="width:140px;"  id="todate" name="todate" value=""/>
											</td>
											  <td><input type="submit" name="View" value="View" class="login_button"/></td>
											</tr>										
									</tr>
							  </table>
							</td>
						</tr>
						
					</table>
					</form>
					</div>
				</div>				
				<div class="clr"></div>
				<br/>
				<div align="center" width="100%">
					<h2><font color="black">Vessel Information</font></h2>
				</div>
				<div style="overflow:scroll;height:400px;color:#000;">
					<table>
						<tr class="gridDark">
							<th>Vessel Name</th>
							<th>Rotation</th>
							<th>Phase</th>
							<th>ETA</th>
							<th>ATA</th>
							<th>Berth</th>
							<th>Operator</th>
							<th>Agent</th>
							<th>ETD</th>
							<th>ATD</th>
						</tr>
						<?php
						for($i=0;$i<count($rtnVesselList);$i++){
						?>
						<tr class="gridLight">
							<td><?php echo $rtnVesselList[$i]['name']?></td>
							<td><?php echo $rtnVesselList[$i]['ib_vyg']?></td>
							<td><?php echo $rtnVesselList[$i]['phase_str']?></td>
							<td><nobr><?php echo $rtnVesselList[$i]['eta']?></nobr></td>
							<td><nobr><?php echo $rtnVesselList[$i]['ata']?></nobr></td>
							<td><?php echo $rtnVesselList[$i]['berth']?></td>
							<td><?php echo $rtnVesselList[$i]['berthop']?></td>
							<td><?php echo $rtnVesselList[$i]['agent']?></td>
							<td><nobr><?php echo $rtnVesselList[$i]['etd']?></nobr></td>
							<td><nobr><?php echo $rtnVesselList[$i]['atd']?></nobr></td>
						</tr>
						<?php
						}
						?>
					</table>
				</div>				  
				<div class="clr"></div>
			</div>
		</div>
		<div class="sidebar">
        <div class="clr"></div>
		<?php 
		//$body="";
		//echo form_open('auths/login'); 
		$attributes = array('name' => 'frm2');
		echo form_open(base_url().'index.php/login/',array('name' =>'frm2','onsubmit' => 'isvalidLogin()'));
		$Stylepadding = 'style="padding: 12px 20px;"';
		if(!empty($error_message))
		{
			$Stylepadding = 'style="padding:25px 20px;"';
		}	
		if(isset($captcha_image)){
			$Stylepadding = 'style="padding:62px 20px 93px;"';
		}
		?>
		<div id="login_body_container">
			<div id="login_container" style="width:100%;border:1px solid black;">
			 <?php if($body!="") echo $body; ?>
				<table border="0" width="250px">
						<tr>
							<td align="right" colspan="2"><label for="user_name">User Name:<em>&nbsp;</em></label></td>
						</tr>
						<tr>
						<td align="left" colspan="2" class="borderTop">
							<?php 
							$attribute = array('name'=>'username','id'=>'txt_login','class'=>'login_input_text');
							echo form_input($attribute,set_value('username'));
							?>
						</td>
					</tr>					
					<tr>
						<td align="right" colspan="2"><label for="password">Password:<em>&nbsp;</em></label></td>
					</tr>
					<tr>
						<td align="left" colspan="2" class="borderTop">
							<?php $attribute = array('name'=>'password','id'=>'txt_password','class'=>'login_input_text');
							echo form_password($attribute);?>
							<?php //echo form_error('txt_password'); ?>
						</td>
					</tr>
							
					<tr>
						<td align="left"><?php $arrt = array('name'=>'submit_login','id'=>'submit','value'=>'Login','class'=>'login_button'); echo form_submit($arrt);?></td>
						<!--td align="left">
							<?php $data = array(
							'name'        => 'remember_me',
							'id'          => 'remember_me',
							'value'       => '1',
							'checked'     => FALSE,
							'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
							);
							echo form_checkbox($data); ?>
							<label for="remember_me" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">Remember Me</label>
						</td-->
					</tr>					
				</table>
			</div>
			<div class="clr"></div>
			<br/>
			<div style="width:100%;text-align:center;border:1px solid black;" id="login_container">
				<!--div style="width:100%;text-align:center"><img src="<?php echo IMG_PATH; ?>small3.jpg" width="300" height="215" alt="" class="" /></div-->
				<table>
					<tr><td align="center"><h2><span style="color:#000;">Important Link</h2></td></tr>
					<tr><td align="center"><a href="<?php echo BASE_PATH;?>index.php/report/containerHandlingView" target="_blank">Yardwise Equipment Booking Report Today</a></td></tr>
				</table>
			</div>
			<div class="clr"></div>
			<br/>
			<div style="width:100%;border:1px solid black;" id="login_container">
				<table>
					<tr><td colspan="3" align="center"><h2><span style="color:#000;">Message</span></h2></td></tr>
					<tr>
						<td colspan="4">
							<p style="text-align: justify;">
							<font color='blue' size='3'>
							<marquee hspace="1"  direction = "up" scrollamount="1"><b>Dear users,<br/>
							Our all time url as below:<br/>
							<strong>Local:</strong> http://192.168.16.42/myportpanel/<br/>
							<strong>Global:</strong> http://115.127.51.199/myportpanel/<br/>
							If global users could not reach our site through above global url then requested to connect through alternet url as below<br/>
							<strong>Global:</strong> http://180.211.170.142/myportpanel/<br/>
							</b>
							<span  style="color:red;">
								<b><strong>CPACS1</strong> user id is closed. Please contact to <strong>01749-923327</strong> for your own user id and password</b>
							</span>
							</marquee>
							<span style="color:#000;"><b>For any help please Contact CTMS helpline:01749-923327</b></span>
							</font>
							</p>
						</td>
						</tr>
					</table>
				</div>
		</div>			
	  </div>
      <div class="clr"></div>
    </div>
	<?php //echo form_close()?>
	</form>
  </div>