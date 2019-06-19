 
 <!--script type="text/javascript" src="<?php echo JS_PATH; ?>AdvancedCalender.js"></script-->
 <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
		  
		  <?php 
		  //$attributes = array('target' => '_blank', 'id' => 'myform');
		  
		  /*echo form_open(base_url().'index.php/report/IgmReportbyDescriptionView',$attributes);
			$Stylepadding = 'style="padding: 12px 20px;"';
				if(!empty($error_message))
				{
					$Stylepadding = 'style="padding:25px 20px;"';
				}	
				if(isset($captcha_image)){
					$Stylepadding = 'style="padding:62px 20px 93px;"';
				}*/?>
				
				<?php
		include('dbConection.php');
		$str = "select * from (
		select sparcsn4.vsl_vessel_visit_details.vvd_gkey,concat(sparcsn4.vsl_vessels.name,'-',sparcsn4.vsl_vessel_visit_details.ib_vyg) as vsl
				from sparcsn4.vsl_vessel_visit_details
				inner join sparcsn4.argo_carrier_visit on sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
				inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
				where sparcsn4.argo_carrier_visit.phase not in('80CANCELED','70CLOSED') and sparcsn4.vsl_vessels.name not like '%PANGAON%' 
		union
		select sparcsn4.vsl_vessel_visit_details.vvd_gkey,concat(sparcsn4.vsl_vessels.name,'-',sparcsn4.vsl_vessel_visit_details.ib_vyg) as vsl
				from sparcsn4.vsl_vessel_visit_details
				inner join sparcsn4.argo_carrier_visit on sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
				inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
				where sparcsn4.argo_carrier_visit.atd > DATE_ADD(now(),interval -2 day)
		) as tbl order by vvd_gkey desc";
		$query = mysql_query($str);
	?>
	
		<div class="img">
		 	 <!--<div id="login_container">-->
		 <form action="<?php echo site_url('uploadExcel/bayViewPerformed');?>" target="_blank" method="post">
			<table style="border:solid 1px #ccc;" width="400px" align="center" cellspacing="0" cellpadding="0">
				<tr>
				<td colspan="2" align="center">&nbsp;</td>
				</tr>
				<!--tr>
					<td><b>Vessel :</b></td>
					<td>
						<select name="vvdGkey">
							<option>----Select Vessel----</option>
							<?php while($row = mysql_fetch_object($query)){ ?>
								<option value="<?php echo $row->vvd_gkey; ?>"><?php echo $row->vsl; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr-->
				<tr>
					<td align="right"><b>Rotation :</b></td>
					<td><input type="text" style="width:120px;" id="vsl_rotation" name="vsl_rotation"> </td>
				</tr>
				<tr>
					<td colspan="2" align="center">
										&nbsp;	
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" value="View"  class="login_button"/>						
					</td>
				</tr>
					<tr>
					<td colspan="2" align="center">
										&nbsp;	
					</td>
				</tr>
			</table>
		</form>

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
       
       <!-- <p class="pages"><small>Page 1 of 2</small> <span>1</span> <a href="#">2</a> <a href="#">&raquo;</a></p>-->
      </div>
      <div class="sidebar">
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	<?php echo form_close()?>
  </div>