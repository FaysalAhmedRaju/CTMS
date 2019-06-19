<!--<div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
			<div class="img1">-->
			<table width="70%" ><TR align="center"><TD ><h2><span ><?php echo $title; ?></span> </h2></TD></TR>
			<TR align="left"><TD colspan="6" ><a href="<?php echo site_url('igmViewController/myPanelView') ?>"><img src="<?php echo IMG_PATH; ?>back.png" height="30px" width="30px" align="middle" hspace="5"/>Back to Control Panel</a></TD></TR>
			</table>
			<table border="0" width="100%">
				
				<TR valign="center" >
					<?php
					echo form_open(base_url().'index.php/igmViewController/myIGMContainerList',$attributes);
					$Stylepadding = 'style="padding: 12px 20px;"';
					if(!empty($error_message))
						{
							$Stylepadding = 'style="padding:25px 20px;"';
						}	
					if(isset($captcha_image)){
						$Stylepadding = 'style="padding:62px 20px 93px;"';
					}
					?>
					<td align="right" width="100px"><label for="rotation_no">Search:<em>&nbsp;</em></label></td>
					<td align="left" width="100px">
						<?php 
							$location_options = array(
								   'Import' =>'Import Rotation No',
								  );

							echo form_dropdown('SearchCriteria', $location_options, $this->input->post('SearchCriteria'));
						?>
									
					</td>
					<td align="left" width="100px">
						<?php 
							$attribute = array('name'=>'Searchdata','id'=>'SearchID','class'=>'login_input_text','value'=>$rotation );
							echo form_input($attribute,set_value('Searchdata'));
							//'onblur'=> "alert();"
						?>
									
					</td>	
					
					<td align="left" width="100px">
						<?php 
						if(substr($_SERVER['REMOTE_ADDR'],0,7)=="192.168" or substr($_SERVER['REMOTE_ADDR'],0,4)=="10.1")
						{
							$location_options2 = array(
									   '1' =>'ALL',
									   '2' =>'Change Container Status',
									   '3' =>'Change Container Size',
									   '4' =>'Change Container Height',
									   '5' =>'MLO Change',
									   '6' =>'Category Change',
									   '7' =>'Container Not Found',
									   '8' =>'Container Mismatch',
									   '9' =>'ISOCODE Mismatch',
									   '10' =>'IGM not submitted by FF',
									  
									  );

							echo form_dropdown('SearchCriteria2', $location_options2, $this->input->post('SearchCriteria2'));
						}
									?>
									
					</td>	
					<td width="70px"><?php $arrt = array('name'=>'SearchD','id'=>'submit','value'=>'Go','class'=>'login_button'); echo form_submit($arrt);?>	</td>
					<td colspan="6"></td>
				</TR>			
					
	
				<TR>
					<TD colspan="6">
					<br/>
					<table>
						<tr class='gridDark'><td>Sl</td><td>Shipping Agent</td><td>MLO CODE</td><td>Line No</td><td>BL NO</td><td>Container Number</td><td width="400px">Description of Goods</td><td>Container Size</td><td>Height</td><td>ISO CODE</td><td>Cont. Category</td><td>Cont. Gross Weight</td><td>Cont. Tare Weight</td>
							<td>Sealed NO.</td><td>Cont. Status</td><td>Cont. Type</td>
							<td>Commudity Code</td><td>Cont. Vat</td><td>Off dock Name</td><td>Place of Unloading</td><td>IMO</td><td>UN</td><td>Navy Comments</td>
			
							<?php
							$con_no="";
							$sl=0;
							$sl2=0;
							$sl3=0;
							$sl4=0;
							$sl5=0;
							$sl6=0;
							if($igmContainerList) {
							$len=count($igmContainerList);
							include("mydbPConnectionctms.php");
							//include("dbConection.php");
							for($i=0;$i<$len;$i++){
							
							//while ($row = mysql_fetch_object($result)) {
			
							/*	if ($row->type=='S')
								{
									$resultmailline = mysql_query("select Import_Rotation_No,master_Line_No,igm_detail_id from igm_supplimentary_detail where id=$row->detail_id");
									$rowmainline = mysql_fetch_object($resultmailline);
									$str="select cont_gross_weight,cont_weight,off_dock_id from igm_detail_container where igm_detail_id='$rowmainline->igm_detail_id'";
									$resultweight=mysql_query($str);
									$rowweight = mysql_fetch_object($resultweight);
									$place_of_unloading=mysql_query("select (select Description from Locationcode where Locationcode.Port_Code=igm_details.place_of_unloading) as Description from igm_details where id=$rowmainline->igm_detail_id");
							
									$str="SELECT Organization_Name as off_dock_name FROM organization_profiles where id='$rowweight->off_dock_id'";
			
			
								}
								else
								{
									$str="SELECT Organization_Name as off_dock_name FROM organization_profiles where id='$row->off_dock_id'";
									//print($str);
									$place_of_unloading=mysql_query("select Description from Locationcode where Port_Code='$row->place_of_unloading'");
									
								}
								$resultcombo = mysql_query($str);
								$rowcombo = mysql_fetch_object($resultcombo);
								$row_place_of_unloading=mysql_fetch_object($place_of_unloading);
								*/
								$contno=$igmContainerList[$i]['cont_number'];
								
								//echo $contno;
								$igm_detail_id2=$igmContainerList[$i]['igm_detail_id2'];
								//echo $igm_detail_id2."====".$contno."<br>";
								if ($con_no<>$igmContainerList[$i]['cont_number'])
								{			
									$sl=$sl + 1;
								}
								
								if($igmContainerList[$i]['cont_height']==8 or $igmContainerList[$i]['cont_height']==8.1 or $igmContainerList[$i]['cont_height']==8.2 or $igmContainerList[$i]['cont_height']==8.3 or $igmContainerList[$i]['cont_height']==8.4 or $igmContainerList[$i]['cont_height']==8.5)	{
								
								$container_height=8.6;
								}
								else
								{
									$container_height=$igmContainerList[$i]['cont_height'];
								}
								
								// get container information form ctmsmis database.....................
								
								
								$sql_str="SELECT sparcsn4.inv_unit.id,sparcsn4.inv_unit.gkey, category, freight_kind,RIGHT(sparcsn4.ref_equip_type.nominal_length,2) AS size,
								RIGHT(sparcsn4.ref_equip_type.nominal_height,2) AS height, ref_bizunit_scoped.id as mlo
								FROM sparcsn4.inv_unit 
								INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.unit_gkey=inv_unit.gkey
								INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
								INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
								INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit.gkey=sparcsn4.inv_unit_fcy_visit.unit_gkey 
								INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.inv_unit_fcy_visit.actual_ib_cv=sparcsn4.argo_carrier_visit.gkey
								INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
								INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey= inv_unit.line_op
								WHERE sparcsn4.inv_unit.id='$contno' AND sparcsn4.vsl_vessel_visit_details.ib_vyg='$rotation'";
								//$sql_str="select freight_kind,mlo,size,height,category,id from ctmsmis.mis_inv_unit where id='$contno' and  vsl_visit_dtls_ib_vyg='$rotation'";
								//echo $sql_str;
								$sql=mysql_query($sql_str);
								//echo "Rows=".mysql_num_rows($sql);
								if($row=mysql_fetch_object($sql)){
									if($row->freight_kind=="MTY") 
									$freight_kind="ETY";
									else
									$freight_kind=$row->freight_kind;
									$height=$row->height;
									$size=$row->size;
									$mlo=$row->mlo;
									$category=$row->category;
									$containerNo=$row->id;
									$tag=0;
									
								}
								else
								{
									
									$freight_kind="Container Not Found";
									$freight_kind="Container Not Found";
									$height="Container Not Found";
									$size="Container Not Found";
									$mlo="Container Not Found";
									$category="Container Not Found";
									$containerNo="Container Not Found";
									$tag=1;
								}
								$portCategory="IMPRT";
								
								// End container information form ctmsmis database.....................
								
								// get iso code from sparcsn4 database ............................
								
								$sql22=mysql_query("select ref_equip_type.id from inv_unit
								INNER JOIN sparcsn4.inv_unit_equip ON inv_unit.gkey=inv_unit_equip.unit_gkey 
								INNER JOIN sparcsn4.ref_equipment ON inv_unit_equip.eq_gkey=ref_equipment.gkey
								INNER JOIN sparcsn4.ref_equip_type ON ref_equipment.eqtyp_gkey=ref_equip_type.gkey 
								where inv_unit.id='$contno' limit 1");
								if($row22=mysql_fetch_object($sql22)){
									$isocode=$row22->id;
								}
								
								//End get iso code from sparcsn4 database ............................
								
															
								//echo $row->freight_kind."<hr>";
								if($SearchCriteria2==1){
							?>
			    <tr  <?php if($igmContainerList[$i]['symbol']=="S") {?> bgcolor="lightgreen"<?php } else { ?>class='gridLight'<?php } ?>>
					<td><?php print($sl);?></td>
					<td><?php echo $igmContainerList[$i]['Organization_Name'];?></td>
					<td <?php if(($igmContainerList[$i]['mlocode'])!=($mlo)){ ?> bgcolor="pink" <?php } ?>><?php if(($igmContainerList[$i]['mlocode'])!=($mlo)) { echo "<b>".$igmContainerList[$i]['mlocode']."<hr>N4: ".$mlo."</b>";} else echo $igmContainerList[$i]['mlocode']?></td>
					<td><?php echo $igmContainerList[$i]['Line_No'];?></td>
					<td><?php echo $igmContainerList[$i]['BL_No'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_number'];?></td>
					<td  width="400px"><?php echo $igmContainerList[$i]['Description_of_Goods'];?></td>
					<td <?php if(($igmContainerList[$i]['cont_size'])!=($size)){ ?> bgcolor="pink" <?php } ?>><?php if(($igmContainerList[$i]['cont_size'])!=($size)){ echo "<b>".$igmContainerList[$i]['cont_size']."<hr>N4: ".$size."</b>";} else echo $igmContainerList[$i]['cont_size'];?></td>
					<td <?php if(($container_height)!=($height/10)){ ?> bgcolor="pink" <?php } ?>><?php if(($container_height)!=($height/10)) { echo "<b>".$container_height."<hr> n4: ".$height."</b>";} else echo $container_height;?></td>
					<td <?php if(trim($igmContainerList[$i]['cont_iso_type'])!=trim($isocode)){ ?> bgcolor="pink" <?php } ?>><?php if(($igmContainerList[$i]['cont_iso_type'])!=($isocode)){ echo "<b>".$igmContainerList[$i]['cont_iso_type']."<hr>N4: ".$isocode."</b>";} else echo $igmContainerList[$i]['cont_iso_type'];?></td>
					<td <?php if(($portCategory)!=($category)){ ?> bgcolor="pink" <?php } ?>><?php if(($portCategory)!=($category)) { echo "<b>".$portCategory."<hr> n4: ".$category."</b>";} else echo $portCategory;?></td>
					<td><?php echo $igmContainerList[$i]['Cont_gross_weight'];?></td>
					
				
					<td><?php 
					if ($row->type=='S' and $row->cont_status=='LCL')
{

					print($rowweight->cont_weight);
}
					else
					print($row->cont_weight); ?></td>
					
					<td><?php echo $igmContainerList[$i]['cont_seal_number'];?></td>
					<td <?php if(substr(trim($igmContainerList[$i]['cont_status']),0,3)!=($freight_kind)){ ?> bgcolor="pink" <?php } ?>><?php if(substr(trim($igmContainerList[$i]['cont_status']),0,3)!=trim($freight_kind)) echo "<b>".substr($igmContainerList[$i]['cont_status'],0,3)."<hr> N4: ".$freight_kind."</b>"; else echo $igmContainerList[$i]['cont_status'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_type'];?></td>
					<td><?php echo $igmContainerList[$i]['commudity_desc'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_vat'];?></td>
					<td><?php echo $igmContainerList[$i]['off_dock_name'];?></td>
					
					
					<td><?php print($rowcombo->off_dock_name); ?></td>
					<td><?php print($row_place_of_unloading->Description); ?></td>
					
					<td><?php echo $igmContainerList[$i]['cont_imo'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_un'];?></td>
				
					
					<?php 	

							if($row->final_amendment == 2)
			{
				print("<td>LabComments:$row->response_details1<br>
						   NAIO Comments:$row->response_details2<br>		
						   Finally:$row->hold_application</td>");
			}
			else if($row->final_amendment == 3)
			{
				print("<td valign='top'>
							LabComments:$row->response_details1<br>
							NAIO Comments:$row->response_details2<br>
							$row->rejected_application</td>");
			}
			else if($row->navy_response_to_port != "" and $row->response_details3 == "")
			{		
				print("<td valign='top'>$row->navy_response_to_port</td>");
			}
			else if($row->final_amendment==1)
			{	
						print("<td>LabComments:$row->response_details1<br>
						   NAIO Comments:$row->response_details2<br>		
						   Finally:$row->response_details3</td>");
			}
			else
			{
				print("<td valign='top'></td>");
			}
			$con_no=$igmContainerList[$i]['cont_number'];

									
			?>
					
		</tr>
		<?php	
			}
			if($SearchCriteria2==2){
			
			 if(substr(trim($igmContainerList[$i]['cont_status']),0,3)!=($freight_kind)){
						$sl2++;
									?>
						<tr class='gridLight'>
							<td><?php print($sl2);?></td>
							<td><?php echo $igmContainerList[$i]['Organization_Name'];?></td>
							<td><?php echo $igmContainerList[$i]['mlocode']?></td>
							<td><?php echo $igmContainerList[$i]['Line_No'];?></td>
							<td><?php echo $igmContainerList[$i]['BL_No'];?></td>
							<td><?php echo $igmContainerList[$i]['cont_number'];?></td>
							<td  width="400px"><?php echo $igmContainerList[$i]['Description_of_Goods'];?></td>
							<td><?php echo $igmContainerList[$i]['cont_size'];?></td>
							<td><?php echo $igmContainerList[$i]['cont_height'];?></td>
							<td><?php echo $igmContainerList[$i]['cont_iso_type'];?></td>
							<td><?php echo $portCategory;?></td>
							<td><?php echo $igmContainerList[$i]['Cont_gross_weight'];?></td>
							
						
							<td><?php 
							if ($row->type=='S' and $row->cont_status=='LCL')
		{

							print($rowweight->cont_weight);
		}
							else
							print($row->cont_weight); ?></td>
							
							<td><?php echo $igmContainerList[$i]['cont_seal_number'];?></td>
							<td <?php if(substr(trim($igmContainerList[$i]['cont_status']),0,3)!=($freight_kind)){ ?> bgcolor="pink" <?php } ?>><?php if(substr(trim($igmContainerList[$i]['cont_status']),0,3)!=trim($freight_kind)) echo "<b>".substr($igmContainerList[$i]['cont_status'],0,3)."<hr> N4: ".$freight_kind."</b>"; else echo $igmContainerList[$i]['cont_status'];?></td>
							<td><?php echo $igmContainerList[$i]['cont_type'];?></td>
							<td><?php echo $igmContainerList[$i]['commudity_desc'];?></td>
							<td><?php echo $igmContainerList[$i]['cont_vat'];?></td>
							<td><?php echo $igmContainerList[$i]['off_dock_name'];?></td>
							
							
							<td><?php print($rowcombo->off_dock_name); ?></td>
							<td><?php print($row_place_of_unloading->Description); ?></td>
							
							<td><?php echo $igmContainerList[$i]['cont_imo'];?></td>
							<td><?php echo $igmContainerList[$i]['cont_un'];?></td>
						
							
							<?php 	

									if($row->final_amendment == 2)
					{
						print("<td>LabComments:$row->response_details1<br>
								   NAIO Comments:$row->response_details2<br>		
								   Finally:$row->hold_application</td>");
					}
					else if($row->final_amendment == 3)
					{
						print("<td valign='top'>
									LabComments:$row->response_details1<br>
									NAIO Comments:$row->response_details2<br>
									$row->rejected_application</td>");
					}
					else if($row->navy_response_to_port != "" and $row->response_details3 == "")
					{		
						print("<td valign='top'>$row->navy_response_to_port</td>");
					}
					else if($row->final_amendment==1)
					{	
								print("<td>LabComments:$row->response_details1<br>
								   NAIO Comments:$row->response_details2<br>		
								   Finally:$row->response_details3</td>");
					}
					else
					{
						print("<td valign='top'></td>");
					}
					$con_no=$igmContainerList[$i]['cont_number'];

											
					?>
							
				</tr>
				<?php	
			}
			}
			if($SearchCriteria2==3){
							// echo $igmContainerList[$i]['cont_size'].'------------'.$size;

			 if($igmContainerList[$i]['cont_size']!=$size){
				$sl2++;
							?>
			    <tr class='gridLight'>
					<td><?php print($sl2);?></td>
					<td><?php echo $igmContainerList[$i]['Organization_Name'];?></td>
					<td><?php echo $igmContainerList[$i]['mlocode']?></td>
					<td><?php echo $igmContainerList[$i]['Line_No'];?></td>
					<td><?php echo $igmContainerList[$i]['BL_No'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_number'];?></td>
					<td  width="400px"><?php echo $igmContainerList[$i]['Description_of_Goods'];?></td>
					<td <?php if(($igmContainerList[$i]['cont_size'])!=($size)){ ?> bgcolor="pink" <?php } ?>><?php if(($igmContainerList[$i]['cont_size'])!=($size)){ echo "<b>".$igmContainerList[$i]['cont_size']."<hr>N4: ".$size."</b>";} else echo $igmContainerList[$i]['cont_size'];?></td>
					<td><?php  echo $igmContainerList[$i]['cont_height'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_iso_type'];?></td>
					<td <?php if(($portCategory)!=($category)){ ?> bgcolor="pink" <?php } ?>><?php if(($portCategory)!=($category)) { echo "<b>".$portCategory."<hr> n4: ".$category."</b>";} else echo $portCategory;?></td>
					<td><?php echo $igmContainerList[$i]['Cont_gross_weight'];?></td>
					
				
					<td><?php 
					if ($row->type=='S' and $row->cont_status=='LCL')
{

					print($rowweight->cont_weight);
}
					else
					print($row->cont_weight); ?></td>
					
					<td><?php echo $igmContainerList[$i]['cont_seal_number'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_status'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_type'];?></td>
					<td><?php echo $igmContainerList[$i]['commudity_desc'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_vat'];?></td>
					<td><?php echo $igmContainerList[$i]['off_dock_name'];?></td>
					
					
					<td><?php print($rowcombo->off_dock_name); ?></td>
					<td><?php print($row_place_of_unloading->Description); ?></td>
					
					<td><?php echo $igmContainerList[$i]['cont_imo'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_un'];?></td>
				
					
					<?php 	

							if($row->final_amendment == 2)
			{
				print("<td>LabComments:$row->response_details1<br>
						   NAIO Comments:$row->response_details2<br>		
						   Finally:$row->hold_application</td>");
			}
			else if($row->final_amendment == 3)
			{
				print("<td valign='top'>
							LabComments:$row->response_details1<br>
							NAIO Comments:$row->response_details2<br>
							$row->rejected_application</td>");
			}
			else if($row->navy_response_to_port != "" and $row->response_details3 == "")
			{		
				print("<td valign='top'>$row->navy_response_to_port</td>");
			}
			else if($row->final_amendment==1)
			{	
						print("<td>LabComments:$row->response_details1<br>
						   NAIO Comments:$row->response_details2<br>		
						   Finally:$row->response_details3</td>");
			}
			else
			{
				print("<td valign='top'></td>");
			}
			$con_no=$igmContainerList[$i]['cont_number'];

									
			?>
					
		</tr>
		<?php	
			}
			}
			if($SearchCriteria2==4){
			
			 if($igmContainerList[$i]['cont_height']!=$height/10){
				$sl4++;
							?>
			    <tr class='gridLight'>
					<td><?php print($sl4);?></td>
					<td><?php echo $igmContainerList[$i]['Organization_Name'];?></td>
					<td><?php echo $igmContainerList[$i]['mlocode']?></td>
					<td><?php echo $igmContainerList[$i]['Line_No'];?></td>
					<td><?php echo $igmContainerList[$i]['BL_No'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_number'];?></td>
					<td  width="400px"><?php echo $igmContainerList[$i]['Description_of_Goods'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_size'];?></td>
					<td <?php if(($container_height)!=($height/10)){ ?> bgcolor="pink" <?php } ?>><?php if(($container_height)!=($height/10)) { echo "<b>".$container_height."<hr> n4: ".$height."</b>";} else echo $container_height;?></td>
					<td><?php echo $igmContainerList[$i]['cont_iso_type'];?></td>
					<td><?php echo $portCategory;?></td>
					<td><?php echo $igmContainerList[$i]['Cont_gross_weight'];?></td>
					
				
					<td><?php 
					if ($row->type=='S' and $row->cont_status=='LCL')
{

					print($rowweight->cont_weight);
}
					else
					print($row->cont_weight); ?></td>
					
					<td><?php echo $igmContainerList[$i]['cont_seal_number'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_status'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_type'];?></td>
					<td><?php echo $igmContainerList[$i]['commudity_desc'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_vat'];?></td>
					<td><?php echo $igmContainerList[$i]['off_dock_name'];?></td>
					
					
					<td><?php print($rowcombo->off_dock_name); ?></td>
					<td><?php print($row_place_of_unloading->Description); ?></td>
					
					<td><?php echo $igmContainerList[$i]['cont_imo'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_un'];?></td>
				
					
					<?php 	

							if($row->final_amendment == 2)
			{
				print("<td>LabComments:$row->response_details1<br>
						   NAIO Comments:$row->response_details2<br>		
						   Finally:$row->hold_application</td>");
			}
			else if($row->final_amendment == 3)
			{
				print("<td valign='top'>
							LabComments:$row->response_details1<br>
							NAIO Comments:$row->response_details2<br>
							$row->rejected_application</td>");
			}
			else if($row->navy_response_to_port != "" and $row->response_details3 == "")
			{		
				print("<td valign='top'>$row->navy_response_to_port</td>");
			}
			else if($row->final_amendment==1)
			{	
						print("<td>LabComments:$row->response_details1<br>
						   NAIO Comments:$row->response_details2<br>		
						   Finally:$row->response_details3</td>");
			}
			else
			{
				print("<td valign='top'></td>");
			}
			$con_no=$igmContainerList[$i]['cont_number'];

									
			?>
					
		</tr>
		<?php	
			}
			}
			if($SearchCriteria2==5){
			
			 if($igmContainerList[$i]['mlocode']!=$mlo){
				$sl5++;
							?>
			    <tr class='gridLight'>
					<td><?php print($sl5);?></td>
					<td><?php echo $igmContainerList[$i]['Organization_Name'];?></td>
					<td <?php if(($igmContainerList[$i]['mlocode'])!=($mlo)){ ?> bgcolor="pink" <?php } ?>><?php if(($igmContainerList[$i]['mlocode'])!=($mlo)) { echo "<b>".$igmContainerList[$i]['mlocode']."<hr>N4: ".$mlo."</b>";} else echo $igmContainerList[$i]['mlocode']?></td>
					<td><?php echo $igmContainerList[$i]['Line_No'];?></td>
					<td><?php echo $igmContainerList[$i]['BL_No'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_number'];?></td>
					<td  width="400px"><?php echo $igmContainerList[$i]['Description_of_Goods'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_size'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_height'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_iso_type'];?></td>
					<td><?php  echo $portCategory;?></td>
					<td><?php echo $igmContainerList[$i]['Cont_gross_weight'];?></td>
					
				
					<td><?php 
					if ($row->type=='S' and $row->cont_status=='LCL')
{

					print($rowweight->cont_weight);
}
					else
					print($row->cont_weight); ?></td>
					
					<td><?php echo $igmContainerList[$i]['cont_seal_number'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_status'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_type'];?></td>
					<td><?php echo $igmContainerList[$i]['commudity_desc'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_vat'];?></td>
					<td><?php echo $igmContainerList[$i]['off_dock_name'];?></td>
					
					
					<td><?php print($rowcombo->off_dock_name); ?></td>
					<td><?php print($row_place_of_unloading->Description); ?></td>
					
					<td><?php echo $igmContainerList[$i]['cont_imo'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_un'];?></td>
				
					
					<?php 	

							if($row->final_amendment == 2)
			{
				print("<td>LabComments:$row->response_details1<br>
						   NAIO Comments:$row->response_details2<br>		
						   Finally:$row->hold_application</td>");
			}
			else if($row->final_amendment == 3)
			{
				print("<td valign='top'>
							LabComments:$row->response_details1<br>
							NAIO Comments:$row->response_details2<br>
							$row->rejected_application</td>");
			}
			else if($row->navy_response_to_port != "" and $row->response_details3 == "")
			{		
				print("<td valign='top'>$row->navy_response_to_port</td>");
			}
			else if($row->final_amendment==1)
			{	
						print("<td>LabComments:$row->response_details1<br>
						   NAIO Comments:$row->response_details2<br>		
						   Finally:$row->response_details3</td>");
			}
			else
			{
				print("<td valign='top'></td>");
			}
			$con_no=$igmContainerList[$i]['cont_number'];

									
			?>
					
		</tr>
		<?php	
			}
			}
			if($SearchCriteria2==6){
			
			 if($portCategory!=$category){
				$sl5++;
							?>
			    <tr class='gridLight'>
					<td><?php print($sl5);?></td>
					<td><?php echo $igmContainerList[$i]['Organization_Name'];?></td>
					<td><?php echo $igmContainerList[$i]['mlocode']?></td>
					<td><?php echo $igmContainerList[$i]['Line_No'];?></td>
					<td><?php echo $igmContainerList[$i]['BL_No'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_number'];?></td>
					<td  width="400px"><?php echo $igmContainerList[$i]['Description_of_Goods'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_size'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_height'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_iso_type'];?></td>
					<td <?php if(($portCategory)!=($category)){ ?> bgcolor="pink" <?php } ?>><?php if(($portCategory)!=($category)) { echo "<b>".$portCategory."<hr> n4: ".$category."</b>";} else echo $portCategory;?></td>
					<td><?php echo $igmContainerList[$i]['Cont_gross_weight'];?></td>
					
				
					<td><?php 
					if ($row->type=='S' and $row->cont_status=='LCL')
{

					print($rowweight->cont_weight);
}
					else
					print($row->cont_weight); ?></td>
					
					<td><?php echo $igmContainerList[$i]['cont_seal_number'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_status'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_type'];?></td>
					<td><?php echo $igmContainerList[$i]['commudity_desc'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_vat'];?></td>
					<td><?php echo $igmContainerList[$i]['off_dock_name'];?></td>
					
					
					<td><?php print($rowcombo->off_dock_name); ?></td>
					<td><?php print($row_place_of_unloading->Description); ?></td>
					
					<td><?php echo $igmContainerList[$i]['cont_imo'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_un'];?></td>
				
					
					<?php 	

							if($row->final_amendment == 2)
			{
				print("<td>LabComments:$row->response_details1<br>
						   NAIO Comments:$row->response_details2<br>		
						   Finally:$row->hold_application</td>");
			}
			else if($row->final_amendment == 3)
			{
				print("<td valign='top'>
							LabComments:$row->response_details1<br>
							NAIO Comments:$row->response_details2<br>
							$row->rejected_application</td>");
			}
			else if($row->navy_response_to_port != "" and $row->response_details3 == "")
			{		
				print("<td valign='top'>$row->navy_response_to_port</td>");
			}
			else if($row->final_amendment==1)
			{	
						print("<td>LabComments:$row->response_details1<br>
						   NAIO Comments:$row->response_details2<br>		
						   Finally:$row->response_details3</td>");
			}
			else
			{
				print("<td valign='top'></td>");
			}
			$con_no=$igmContainerList[$i]['cont_number'];

									
			?>
					
		</tr>
		<?php	
			}
			}
			if($SearchCriteria2==8){
			
			 if($igmContainerList[$i]['cont_number']!=$containerNo){
				$sl6++;
							?>
			    <tr class='gridLight'>
					<td><?php print($sl6);?></td>
					<td><?php echo $igmContainerList[$i]['Organization_Name'];?></td>
					<td><?php echo $igmContainerList[$i]['mlocode']?></td>
					<td><?php echo $igmContainerList[$i]['Line_No'];?></td>
					<td><?php echo $igmContainerList[$i]['BL_No'];?></td>
					<td <?php if(($igmContainerList[$i]['cont_number'])!=($containerNo)){ ?> bgcolor="pink" <?php } ?>><?php if(($igmContainerList[$i]['cont_number'])!=($containerNo)){ echo "<b>".$igmContainerList[$i]['cont_number']."<hr>N4: ".$containerNo."</b>";} else echo $igmContainerList[$i]['cont_number'];?></td>
					<td  width="400px"><?php echo $igmContainerList[$i]['Description_of_Goods'];?></td>
					<td ><?php echo $igmContainerList[$i]['cont_size'];?></td>
					<td><?php  echo $igmContainerList[$i]['cont_height'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_iso_type'];?></td>
					<td ><?php echo $portCategory;?></td>
					<td><?php echo $igmContainerList[$i]['Cont_gross_weight'];?></td>
					
				
					<td><?php 
					if ($row->type=='S' and $row->cont_status=='LCL')
{

					print($rowweight->cont_weight);
}
					else
					print($row->cont_weight); ?></td>
					
					<td><?php echo $igmContainerList[$i]['cont_seal_number'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_status'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_type'];?></td>
					<td><?php echo $igmContainerList[$i]['commudity_desc'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_vat'];?></td>
					<td><?php echo $igmContainerList[$i]['off_dock_name'];?></td>
					
					
					<td><?php print($rowcombo->off_dock_name); ?></td>
					<td><?php print($row_place_of_unloading->Description); ?></td>
					
					<td><?php echo $igmContainerList[$i]['cont_imo'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_un'];?></td>
				
					
					<?php 	

							if($row->final_amendment == 2)
			{
				print("<td>LabComments:$row->response_details1<br>
						   NAIO Comments:$row->response_details2<br>		
						   Finally:$row->hold_application</td>");
			}
			else if($row->final_amendment == 3)
			{
				print("<td valign='top'>
							LabComments:$row->response_details1<br>
							NAIO Comments:$row->response_details2<br>
							$row->rejected_application</td>");
			}
			else if($row->navy_response_to_port != "" and $row->response_details3 == "")
			{		
				print("<td valign='top'>$row->navy_response_to_port</td>");
			}
			else if($row->final_amendment==1)
			{	
						print("<td>LabComments:$row->response_details1<br>
						   NAIO Comments:$row->response_details2<br>		
						   Finally:$row->response_details3</td>");
			}
			else
			{
				print("<td valign='top'></td>");
			}
			$con_no=$igmContainerList[$i]['cont_number'];

									
			?>
					
		</tr>
		<?php	
			}
			}
			if($SearchCriteria2==9){
			//echo "N4:".$isocode."-".$igmContainerList[$i]['cont_iso_type']."<br>";
			 if($isocode!=$igmContainerList[$i]['cont_iso_type']){
				$sl6++;
							?>
			    <tr class='gridLight'>
					<td><?php print($sl6);?></td>
					<td><?php echo $igmContainerList[$i]['Organization_Name'];?></td>
					<td><?php echo $igmContainerList[$i]['mlocode']?></td>
					<td><?php echo $igmContainerList[$i]['Line_No'];?></td>
					<td><?php echo $igmContainerList[$i]['BL_No'];?></td>
					<td <?php if(($igmContainerList[$i]['cont_number'])!=($containerNo)){ ?> bgcolor="pink" <?php } ?>><?php if(($igmContainerList[$i]['cont_number'])!=($containerNo)){ echo "<b>".$igmContainerList[$i]['cont_number']."<hr>N4: ".$containerNo."</b>";} else echo $igmContainerList[$i]['cont_number'];?></td>
					<td  width="400px"><?php echo $igmContainerList[$i]['Description_of_Goods'];?></td>
					<td ><?php echo $igmContainerList[$i]['cont_size'];?></td>
					<td><?php  echo $igmContainerList[$i]['cont_height'];?></td>
					<td <?php if(trim($igmContainerList[$i]['cont_iso_type'])!=trim($isocode)){ ?> bgcolor="pink" <?php } ?>><?php if(($igmContainerList[$i]['cont_iso_type'])!=($isocode)){ echo "<b>".$igmContainerList[$i]['cont_iso_type']."<hr>N4: ".$isocode."</b>";} else echo $igmContainerList[$i]['cont_iso_type'];?></td>
					<td ><?php echo $portCategory;?></td>
					<td><?php echo $igmContainerList[$i]['Cont_gross_weight'];?></td>
					
				
					<td><?php 
					if ($row->type=='S' and $row->cont_status=='LCL')
{

					print($rowweight->cont_weight);
}
					else
					print($row->cont_weight); ?></td>
					
					<td><?php echo $igmContainerList[$i]['cont_seal_number'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_status'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_type'];?></td>
					<td><?php echo $igmContainerList[$i]['commudity_desc'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_vat'];?></td>
					<td><?php echo $igmContainerList[$i]['off_dock_name'];?></td>
					
					
					<td><?php print($rowcombo->off_dock_name); ?></td>
					<td><?php print($row_place_of_unloading->Description); ?></td>
					
					<td><?php echo $igmContainerList[$i]['cont_imo'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_un'];?></td>
				
					
					<?php 	

							if($row->final_amendment == 2)
			{
				print("<td>LabComments:$row->response_details1<br>
						   NAIO Comments:$row->response_details2<br>		
						   Finally:$row->hold_application</td>");
			}
			else if($row->final_amendment == 3)
			{
				print("<td valign='top'>
							LabComments:$row->response_details1<br>
							NAIO Comments:$row->response_details2<br>
							$row->rejected_application</td>");
			}
			else if($row->navy_response_to_port != "" and $row->response_details3 == "")
			{		
				print("<td valign='top'>$row->navy_response_to_port</td>");
			}
			else if($row->final_amendment==1)
			{	
						print("<td>LabComments:$row->response_details1<br>
						   NAIO Comments:$row->response_details2<br>		
						   Finally:$row->response_details3</td>");
			}
			else
			{
				print("<td valign='top'></td>");
			}
			$con_no=$igmContainerList[$i]['cont_number'];

									
			?>
					
		</tr>
		<?php	
			}
			}
			if($SearchCriteria2==10){
			//echo "N4:".$isocode."-".$igmContainerList[$i]['cont_iso_type']."<br>";
			 if($igmContainerList[$i]['symbol']=='S'){
				$sl6++;
							?>
			    <tr <?php if($igmContainerList[$i]['symbol']=="S") {?> bgcolor="lightgreen"<?php } else { ?>class='gridLight'<?php } ?>>
					<td><?php print($sl6);?></td>
					<td><?php echo $igmContainerList[$i]['Organization_Name'];?></td>
					<td><?php echo $igmContainerList[$i]['mlocode']?></td>
					<td><?php echo $igmContainerList[$i]['Line_No'];?></td>
					<td><?php echo $igmContainerList[$i]['BL_No'];?></td>
					<td <?php if(($igmContainerList[$i]['cont_number'])!=($containerNo)){ ?> bgcolor="pink" <?php } ?>><?php if(($igmContainerList[$i]['cont_number'])!=($containerNo)){ echo "<b>".$igmContainerList[$i]['cont_number']."<hr>N4: ".$containerNo."</b>";} else echo $igmContainerList[$i]['cont_number'];?></td>
					<td  width="400px"><?php echo $igmContainerList[$i]['Description_of_Goods'];?></td>
					<td ><?php echo $igmContainerList[$i]['cont_size'];?></td>
					<td><?php  echo $igmContainerList[$i]['cont_height'];?></td>
					<td <?php echo $igmContainerList[$i]['cont_iso_type'];?></td>
					<td ><?php echo $portCategory;?></td>
					<td><?php echo $igmContainerList[$i]['Cont_gross_weight'];?></td>
					
				
					<td><?php 
					if ($row->type=='S' and $row->cont_status=='LCL')
{

					print($rowweight->cont_weight);
}
					else
					print($row->cont_weight); ?></td>
					
					<td><?php echo $igmContainerList[$i]['cont_seal_number'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_status'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_type'];?></td>
					<td><?php echo $igmContainerList[$i]['commudity_desc'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_vat'];?></td>
					<td><?php echo $igmContainerList[$i]['off_dock_name'];?></td>
					
					
					<td><?php print($rowcombo->off_dock_name); ?></td>
					<td><?php print($row_place_of_unloading->Description); ?></td>
					
					<td><?php echo $igmContainerList[$i]['cont_imo'];?></td>
					<td><?php echo $igmContainerList[$i]['cont_un'];?></td>
				
					
					<?php 	

							if($row->final_amendment == 2)
			{
				print("<td>LabComments:$row->response_details1<br>
						   NAIO Comments:$row->response_details2<br>		
						   Finally:$row->hold_application</td>");
			}
			else if($row->final_amendment == 3)
			{
				print("<td valign='top'>
							LabComments:$row->response_details1<br>
							NAIO Comments:$row->response_details2<br>
							$row->rejected_application</td>");
			}
			else if($row->navy_response_to_port != "" and $row->response_details3 == "")
			{		
				print("<td valign='top'>$row->navy_response_to_port</td>");
			}
			else if($row->final_amendment==1)
			{	
						print("<td>LabComments:$row->response_details1<br>
						   NAIO Comments:$row->response_details2<br>		
						   Finally:$row->response_details3</td>");
			}
			else
			{
				print("<td valign='top'></td>");
			}
			$con_no=$igmContainerList[$i]['cont_number'];

									
			?>
					
		</tr>
		<?php	
			}
			}
			if($SearchCriteria2==7){
			
			 if($tag==1){
				$sl5++;
							?>
			    <tr class='gridLight'>
					<td height="50px" valign="center" colspan="22" align="center"><?php print("<font color='blue' size='3' align='center'><b>Container No: ".$igmContainerList[$i]['cont_number'] . " not found</b></font>");?></td>
												
			
		</tr>
		<?php	
			}
			}
			}	
				mysql_close($con_ctmsmis);
				//mysql_close($con_sparcsn4);
			}

		?>
	</table>
</TD></TR>
</table>
			<!--</div>
			 <div class="clr"></div>
        
        </div>
	
	  </div>
            
      <div class="sidebar">
	   <?php // include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>

	</div>
</div>-->