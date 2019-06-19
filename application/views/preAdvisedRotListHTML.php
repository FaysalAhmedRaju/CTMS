 <?php if(substr($_SERVER['REMOTE_ADDR'],0,7)=="192.168" or substr($_SERVER['REMOTE_ADDR'],0,4)=="10.1") { ?>
 <script type="text/javascript" src="<?php echo JS_PATH; ?>getagentlocal.js"> </script>
 <?php } else { ?>
 <script type="text/javascript" src="<?php echo JS_PATH; ?>getagent.js"> </script>
 <?php } ?>
 
 
 <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <span><?php echo $myUpdateManifestList; ?></span>
		  <div class="clr"></div>
		  
		  <?php 
		  $attributes = array('id' => 'myform');
		  //,'target'=>'_BLANK'
		  echo form_open(base_url().'index.php/uploadExcel/convertCopinoPerformed',$attributes);
			$Stylepadding = 'style="padding: 12px 20px;"';
				if(!empty($error_message))
				{
					$Stylepadding = 'style="padding:25px 20px;"';
				}	
				if(isset($captcha_image)){
					$Stylepadding = 'style="padding:62px 20px 93px;"';
				}
				
				//$as=new convertCopinoPerformed();
				
				//$as->aasa();
				
				include("dbConection.php");
				/*$str = "select vvd_gkey,rotation,agent,cont,
				(select name from sparcsn4.vsl_vessel_visit_details
				inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
				where ib_vyg=ctmsmis.tbl.rotation
				) as vsl_name
				from
				(
				select distinct vvd_gkey,rotation,agent,count(cont_id) as cont
				from ctmsmis.mis_exp_unit_preadv_req where preAddStat=1 and date(last_update)=date(now()) 
				group by  vvd_gkey
				) as tbl";
				*/
				if($login_id=="sazam" or $login_id=="gnullah" or $login_id=="popy" or $login_id=="Shepu" or $login_id=="tipai" or $login_id=="shopna" or $login_id=="norin" or $login_id=="admin" or $login_id=="anikcpa") {
				// $str = "select distinct ctmsmis.mis_exp_unit_preadv_req.vvd_gkey,rotation,sparcsn4.vsl_vessels.name as vsl_name,Y.id as agent from ctmsmis.mis_exp_unit_preadv_req 
				// inner join sparcsn4.vsl_vessel_visit_details vsldtl on vsldtl.vvd_gkey=ctmsmis.mis_exp_unit_preadv_req.vvd_gkey
				// inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=vsldtl.vessel_gkey
				// inner join  ( sparcsn4.ref_bizunit_scoped r  
				// left join ( sparcsn4.ref_agent_representation X  
				// left join sparcsn4.ref_bizunit_scoped Y ON X.agent_gkey=Y.gkey )               
				// ON r.gkey=X.bzu_gkey)  ON r.gkey = vsldtl.bizu_gkey
				// where preAddStat=1 and date(last_update)=date(now()) limit 2";
				
				$str = "select distinct ctmsmis.mis_exp_unit_preadv_req.vvd_gkey,rotation,sparcsn4.vsl_vessels.name as vsl_name,Y.id as agent from ctmsmis.mis_exp_unit_preadv_req 
				inner join sparcsn4.vsl_vessel_visit_details vsldtl on vsldtl.vvd_gkey=ctmsmis.mis_exp_unit_preadv_req.vvd_gkey
				inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=vsldtl.vessel_gkey
				inner join  ( sparcsn4.ref_bizunit_scoped r  
				left join ( sparcsn4.ref_agent_representation X  
				left join sparcsn4.ref_bizunit_scoped Y ON X.agent_gkey=Y.gkey )               
				ON r.gkey=X.bzu_gkey)  ON r.gkey = vsldtl.bizu_gkey
				where preAddStat=1 and date(last_update)=date(now())";
				}
				else
				{
					$str = "select distinct ctmsmis.mis_exp_unit_preadv_req.vvd_gkey,rotation,sparcsn4.vsl_vessels.name as vsl_name,Y.id as agent from ctmsmis.mis_exp_unit_preadv_req 
				inner join sparcsn4.vsl_vessel_visit_details vsldtl on vsldtl.vvd_gkey=ctmsmis.mis_exp_unit_preadv_req.vvd_gkey
				inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=vsldtl.vessel_gkey
				inner join  ( sparcsn4.ref_bizunit_scoped r  
				left join ( sparcsn4.ref_agent_representation X  
				left join sparcsn4.ref_bizunit_scoped Y ON X.agent_gkey=Y.gkey )               
				ON r.gkey=X.bzu_gkey)  ON r.gkey = vsldtl.bizu_gkey
				where preAddStat=1 and date(last_update)=date(now()) and agent='$login_id'";
				}
				$result = mysql_query($str);				
				?>
	
		<div class="img">
		 	 <!--<div id="login_container">-->
		 <table style="border:solid 1px #ccc;" width="550px" align="center" cellspacing="0" cellpadding="0">
				<tr><td>	 
		 <table align="center" border="0">		
						
						<tr bgcolor="#85DDEA"><th>Rotation</th><th>Vessel Name</th><th>Agent</th><th>Total Container</th><th>To be Convert</th><th>Will not Convert</th><th>Action</th></tr>
						<?php
							while($row = mysql_fetch_object($result))
							{
								$strCont = "select cont_id from ctmsmis.mis_exp_unit_preadv_req where vvd_gkey='$row->vvd_gkey' and preAddStat=1 and date(last_update)=date(now()) ";
								$resultCont = mysql_query($strCont);
								$totCont = 0;
								$convertCont = 0;
								$noConvertCont = 0;
								while($rowCont = mysql_fetch_object($resultCont))
								{
									$totCont = $totCont+1;
									/*$strCat = "select category from sparcsn4.inv_unit where id='$rowCont->cont_id'";
									$resCat = mysql_query($strCat);
									$cat="";
									
									while($rowCat = mysql_fetch_object($resCat))
									{
										$cat=$rowCat->category;
									}*/
									
									$strTrans = "select sparcsn4.inv_unit_fcy_visit.transit_state,sparcsn4.inv_unit.category from sparcsn4.inv_unit 
									inner join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
									where sparcsn4.inv_unit.id='$rowCont->cont_id' order by sparcsn4.inv_unit_fcy_visit.gkey";
									//echo $strTrans."<hr>";
									$resTrans = mysql_query($strTrans);
									$Trans="";
									$cat="";
									while($rowTrans = mysql_fetch_object($resTrans))
									{
										$Trans=$rowTrans->transit_state;
										$cat=$rowTrans->category;
									}
									
									if($Trans=="S40_YARD" or $Trans=="S50_ECOUT")
										$noConvertCont = $noConvertCont+1;
									else if($cat=="EXPRT" and ($Trans=="S60_LOADED" or $Trans=="S70_DEPARTED" or $Trans=="S99_RETIRED"))
										$noConvertCont = $noConvertCont+1;
									else if(($cat=="IMPRT" or $cat=="STRGE") and $Trans=="S20_INBOUND")
										$noConvertCont = $noConvertCont+1;
										
								}
								$convertCont = $totCont-$noConvertCont;
						?>
							<tr bgcolor="#A6E1EB">
								<td><?php echo $row->rotation; ?></td>
								<td><?php echo $row->vsl_name; ?></td>
								<td><?php echo $row->agent; ?></td>
								<td><a href="<?php echo site_url('uploadExcel/showDetailPrevCont/'.$row->vvd_gkey.'/all'); ?>" target="_blank"><?php echo $totCont; ?></a></td>
								<td><a href="<?php echo site_url('uploadExcel/showConverted/'.$row->vvd_gkey); ?>" target="_blank"><?php echo $convertCont; ?></a></td>
								<td><a href="<?php echo site_url('uploadExcel/showNoConverted/'.$row->vvd_gkey); ?>" target="_blank"><?php echo $noConvertCont; ?></a></td>
								<?php if($login_id=="sazam" or $login_id=="gnullah" or $login_id=="popy" or $login_id=="tipai" or $login_id=="shopna" or $login_id=="norin" or $login_id=="admin" or $login_id=="anikcpa"){?>
								<td><a href="<?php echo site_url('uploadExcel/updateSNXStatus/'.$row->vvd_gkey); ?>" class="login_button" style="text-decoration: none;" onclick="return myconfirm();">Done SNX</a></td>
								<?php }else{?>
									<td>CPA got notification</td>
								<?php }?>
								<!--td><?php $arrt = array('name'=>'report','id'=>'submit','value'=>'Done SNX','class'=>'login_button'); echo form_submit($arrt); ?></td-->
							</tr>
						<?php
							}
						?>
						<!--tr><td colspan="2"><?php echo $msg; ?></td></tr>
						
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr align="center">
							<br />
							
							<td align="right" ><label for="rotation_no">Import Rotation No:<em>&nbsp;</em></label></td>
							<td align="left" >
							<?php 
								$attribute = array('name'=>'ddl_imp_rot_no','id'=>'txt_login','class'=>'login_input_text' );
								echo form_input($attribute,set_value('ddl_imp_rot_no'));
								//'onblur'=> "alert();"
							?>
									
							</td>
						</tr>	
						
						
						<!--<tr>
							<td colspan="2">Excl<input type="radio" name="options" value="xl">&nbsp;HTML<input type="radio" name="options" value="html"></td>
						</tr>-->
						<!--tr><td colspan="2">&nbsp;</td></tr>
						<tr>
							<td colspan="2" align="center" width="70px"><br><?php $arrt = array('name'=>'report','id'=>'submit','value'=>'Convert','class'=>'login_button'); echo form_submit($arrt);?>	
						</tr>
						<tr><td colspan="2">&nbsp;</td></tr-->
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
		  </form>
          <div class="clr"></div>
        </div>
		<?php
			if($mystatus==2)
			{
				echo $body;
			}
		?>
	
   
   	
		
       
       <!-- <p class="pages"><small>Page 1 of 2</small> <span>1</span> <a href="#">2</a> <a href="#">&raquo;</a></p>-->
      </div>
      <div class="sidebar">
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	<?php echo form_close()?>
  </div>
  
  <script>
	function myconfirm()
	{
		if(confirm("Do you want done this SNX?"))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
  </script>
 