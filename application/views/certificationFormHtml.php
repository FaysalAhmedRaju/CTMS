
<script language="JavaScript">

</script>

<div class="content">
    <div class="content_resize_1">
      <div class="mainbar_1">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <span><?php echo $myUpdateManifestList; ?></span>
		  <div class="clr"><?php echo $msg?></div>
		  
		  <?php 
		  $attributes = array('id' => 'myform');
		  //,'target'=>'_BLANK'
		  echo form_open(base_url().'index.php/report/certificationFormViewList',$attributes);
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
		 <table style="border:solid 1px #ccc;" width="650px" align="center" cellspacing="0" cellpadding="0">
				<tr><td>	 
		 <table align="center" border=0>	
						<tr align="center">
							<td align="right" ><label for="rotation_no">Rotation No:<em>&nbsp;</em></label></td>
							<td align="left" >
							<?php 
								$attribute = array('name'=>'ddl_imp_rot_no','id'=>'txt_login','class'=>'login_input_text' );
								echo form_input($attribute,set_value('ddl_imp_rot_no'));
								//'onblur'=> "alert();"
							?>
									
							</td>
						
							<td align="right" ><label for="rotation_no">BL No:<em>&nbsp;</em></label></td>
							<td align="left" >
							<?php 
								$attribute = array('name'=>'ddl_bl_no','id'=>'txt_login','class'=>'login_input_text' );
								echo form_input($attribute,set_value('ddl_bl_no'));
								//'onblur'=> "alert();"
							?>
									
							</td>
						
							<td colspan="2" align="center" width="70px">
							<?php $arrt = array('name'=>'report','id'=>'submit','value'=>'Search','class'=>'login_button'); echo form_submit($arrt);?>	
							</td>
						</tr>
				</table>
			</td>
		</tr>
		<tr><td align="center" colspan="2"><font color=""><b>
		<?php if($verify_number>0 or $verify_num>0)
				{ echo "<font color='green'><b>VERIFY NUMBER IS ".$verify_num."</b></font>";} 			 
			  else 
				{ echo $msg;}?>
		</b></font></td></tr>
		<!--TR align="center"><TD colspan="6" ><h2><span ><?php echo "Verify No: ".$verify_num; ?></span> </h2></TD></TR-->
	</table>
	<?php echo form_close()?>
	<?php
/*****************************************************
Developed BY: Sourav Chakraborty
Software Developer
DataSoft Systems Bangladesh Ltd
******************************************************/

$_SESSION['Control_Panel']=$this->session->userdata('Control_Panel');

?>
<?php 
if($unstuff_flag>0)
			{
				?>
<div style="width:100%; height:500px; overflow-y:auto;">
<table border="0"  width="100%" bgcolor="#FFFFFF" align="center">
	<!--<TR align="center"><TD colspan="6" ><h2><span ><?php echo $title; ?></span> </h2></TD></TR>-->
	
	
	<TR><TD align="center">
	
		<table border=0 cellspacing="2" cellpadding="1" bdcolor="#ffffff">
		<!--tr class="gridDark" >
			<td align="center">Action/Verify No.</td>
			<td align="center">W/R Up To</td>
			<td align="center">Bill</td>
			<!--td align="center">SL</td>
			<td align="center">Gate Out Date & Time</td>
			<td align="center">Container</td>
			<td align="center">Receive Pack</td>
			<td align="center">Marks & Number</td>
			<td align="center">Consignee Description</td>
			<td align="center">Notify Description</td>			
			<td align="center" >Yard</td>
			<td align="center">Position</td>
			<td align="center">Cont. Type</td>
			<td align="center">Status</td>
			<td align="center">Discharge Time</td>
			<td align="center">Dest.</td>
			<td align="center">Offdock Name</td>
			<td align="center">Rotation</td>
			<!--<td align="center">Vessel Name</td>
			<td align="center">Master BL</td>
			<td align="center">Sub BL</td>>
			<td align="center">Seal</td>
			<td align="center">Size</td>
			<td align="center">Height</td>
		</tr-->
		
		
		<?php
			
			include("mydbPConnection.php");
			$totcontainerNo="";
			if($rtnContainerList) {
			$len=count($rtnContainerList);
			//echo "Length : ".$len;
            $j=0;
            for($i=0;$i<$len;$i++){
				
			
				
			 $id=$rtnContainerList[$i]['igm_detail_id'];
			 $containerNo1=$rtnContainerList[$i]['cont_number'];
			 $rotaionNo=$rtnContainerList[$i]['Import_Rotation_No'];
			 $igm_supDtl_id=$rtnContainerList[$i]['igm_sup_dtl_id'];
			 //$sql=mysql_query("select  group_concat(igm_supplimentary_detail.BL_No) as sub_bl from igm_supplimentary_detail where igm_detail_id=$id");
			 //$rtnSubBl=mysql_fetch_object($sql);						 
			 $j++;
			 $sql=mysql_query("select rcv_pack,marks_state,shift_name from shed_tally_info where igm_sup_detail_id=$igm_supDtl_id");
			 $rtnData=mysql_fetch_object($sql);	
			 
			//echo $rtnContainerList[$i]['cont_number']."-".$containerNo1;
			//echo $rtnContainerList[$i]['Import_Rotation_No']."-".$rotaionNo;
			
			include("dbConection.php");
			
			/*$sqlYardPosition=mysql_query("select fcy_time_in,fcy_last_pos_slot,fcy_position_name,yard,fcy_time_out,(select cont_block(fcy_last_pos_slot,yard)) as block from (
			select fcy_time_in,fcy_last_pos_slot,fcy_position_name,(select cont_yard(fcy_last_pos_slot)) as yard,fcy_time_out from mis_inv_unit where id='$containerNo1' and vsl_visit_dtls_ib_vyg='$rotaionNo'
			) as  tmp",$conn);*/
			
			$sqlYardPosition=mysql_query("select fcy_time_in,fcy_last_pos_slot,fcy_position_name,yard,fcy_time_out,(select ctmsmis.cont_block(fcy_last_pos_slot,yard)) as block from (
											select time_in as fcy_time_in,last_pos_slot as fcy_last_pos_slot,last_pos_name as fcy_position_name,ctmsmis.cont_yard(last_pos_slot) as yard,time_out as fcy_time_out from inv_unit a
												inner join 
											inv_unit_fcy_visit on inv_unit_fcy_visit.unit_gkey=a.gkey
													inner join
											 argo_carrier_visit h ON (h.gkey = a.declrd_ib_cv or h.gkey = a.cv_gkey)
													inner join
												argo_visit_details i ON h.cvcvd_gkey = i.gkey
													inner join
												vsl_vessel_visit_details ww ON ww.vvd_gkey = i.gkey where ib_vyg='$rotaionNo' and a.id='$containerNo1'
											) as  tmp"
										);
			
			/*echo "select fcy_time_in,fcy_last_pos_slot,fcy_position_name,yard,fcy_time_out,(select ctmsmis.cont_block(fcy_last_pos_slot,yard)) as block from (
select time_in as fcy_time_in,last_pos_slot as fcy_last_pos_slot,last_pos_name as fcy_position_name,ctmsmis.cont_yard(last_pos_slot) as yard,time_out as fcy_time_out from inv_unit a
	inner join 
inv_unit_fcy_visit on inv_unit_fcy_visit.unit_gkey=a.gkey
        inner join
 argo_carrier_visit h ON (h.gkey = a.declrd_ib_cv or h.gkey = a.cv_gkey)
        inner join
    argo_visit_details i ON h.cvcvd_gkey = i.gkey
        inner join
    vsl_vessel_visit_details ww ON ww.vvd_gkey = i.gkey where ib_vyg='$rotaionNo' and a.id='$containerNo1'
) as  tmp"."<hr>";*/
			
			$rtnYardPosition=mysql_fetch_object($sqlYardPosition);
			//echo $rtnYardPosition->fcy_time_in."<hr>";
			
		?>
		
		
					<tr class="gridLight">
						<th width="100px">Discharge Time</th><th>:</th><td><?php print($rtnYardPosition->fcy_time_out); ?></td>
						<th width="100px">Vessel Name</th><th>:</th><td><?php print($rtnContainerList[$i]['Vessel_Name']); ?></td>
						<th>Rotation</th><th>:</th><td><?php print($rtnContainerList[$i]['Import_Rotation_No']); ?></td>
						
					</tr >
					<tr class="gridLight">
						<th width="100px">Container</th><th>:</th><td><?php print($rtnContainerList[$i]['cont_number']);  ?></td>
						<th width="100px">Cont.Size</th><th>:</th><td><?php print($rtnContainerList[$i]['cont_size']);  ?></td>
						<th width="100px">Cont.Height</th><th>:</th><td><?php print($rtnContainerList[$i]['cont_height']);  ?></td>
					</tr>
					<tr class="gridLight">
						<!--th>Cont. Type</th><th>:</th><td><?php print($rtnContainerList[$i]['cont_iso_type']); ?></td-->
						<th>BL No</th><th>:</th><td><?php print($rtnContainerList[$i]['BL_No']); ?></td>
						<th>Yard / Shed</th><th>:</th><td><?php print($rtnContainerList[$i]['shed_yard']);  ?></td>
						<th width="100px">Unstuffing Date</th><th>:</th><td><?php print($rtnContainerList[$i]['wr_date']);  ?></td>
					</tr>
					<tr class="gridLight">
						<th>Marks & Number</th><th>:</th><td><?php echo str_replace(',',', ',$rtnContainerList[$i]['Pack_Marks_Number']); ?></td>
						<th width="150px">Description of Goods</th><th>:</th><td><?php print($rtnContainerList[$i]['Description_of_Goods']);  ?></td>
						<th>Importer</th><th>:</th><td><?php print($rtnContainerList[$i]['Notify_name']); ?></td>
					</tr>
					<tr class="gridLight">	
						<th width="100px">Receive Pack</th><th>:</th><td><?php print($rtnContainerList[$i]['rcv_pack']); ?></td>
						<th width="100px">Pack Unit</th><th>:</th><td><?php print($rtnContainerList[$i]['rcv_unit']); ?></td>
					</tr>
					<tr align="center">
						<th colspan=9 >
							<form action="<?php echo site_url('report/certificationListPdf/'.str_replace("/","_",$rtnContainerList[$i]['BL_No']).'/'.str_replace("/","_",$rtnContainerList[$i]['Import_Rotation_No']))?>" target="_blank" method="POST">						
								<input type="submit" value="PDF View"  class="login_button" style="width:10%;">							
							</form> 
						</th>
					</tr>
					<!--tr class="gridLight">
						<th>Status</th><th>:</th><td><?php print($rtnContainerList[$i]['cont_status']); ?></td>
						<th>Discharge Time</th><th>:</th><td><?php print($rtnYardPosition->fcy_time_in); ?></td>
						<th>Dest.</th><th>:</th><td><?php print($rtnContainerList[$i]['off_dock_id']); ?></td>

					</tr>
					<tr class="gridLight">
					
						<th>Offdock Name</th><th>:</th><td><?php print($rtnContainerList[$i]['offdock_name']); ?></td>
						
						<th>Seal</th><th>:</th><td><?php print($rtnContainerList[$i]['cont_seal_number']); ?></td>
					</tr>
					<tr class="gridLight">
						<th>Size</th><th>:</th><td><?php print($rtnContainerList[$i]['cont_size']); ?></td>
						<th>Height</th><th>:</th><td><?php print($rtnContainerList[$i]['cont_height']); ?></td>

					</tr-->
		<?php	
			
			if($totcontainerNo!="")
				$totcontainerNo=$totcontainerNo.", ".$containerNo1;
			else
				$totcontainerNo=$containerNo1;
				
				mysql_close($con_sparcsn4);
			
			
			
			

		?>
		<!--tr><td colspan="16" align="center"><?php echo "Total Container: ". $j;?></td></tr-->
		<!--<tr><td colspan="16" align="left"><?php if($totcontainerNo) echo  $totcontainerNo; else echo "&nbsp;"; ?></td></tr>-->
	</table>
	<br/>
	<!--form action="<?php echo site_url('report/lclAssignmentVerify');?>" method="POST" name="myChkForm" onsubmit="return(validate());">
		<input type="hidden"value="<?php echo  $verify_id?>" name="verify_id" style="width:200px;"/>
		<input type="hidden"value="<?php echo  $verify_num?>" name="verify_num" style="width:200px;"/>
		<input type="hidden"value="<?php echo  $ddl_imp_rot_no?>" name="verify_rot" style="width:200px;"/>
		<input type="hidden"value="<?php echo  $ddl_bl_no?>" name="verify_bl" style="width:200px;"/>
		<table border=0 cellspacing="2" cellpadding="1"  width="80%" bgcolor="#2AB1D6">
			
			<tr class="gridDark">
				<th>C&f License</th><th>:</th><td><input type="text" id="strCnfLicense" value="<?php echo  $rtnContainerList[$i]['cnf_lic_no']?>" name="strCnfLicense" onblur="getCnfCode(this.value)" style="width:200px;"/></td>
				<th>C&f Name</th><th>:</th><td><input type="text" id="strCnfCode" value="<?php echo $cnf_name;?>" name="strCnfCode" style="width:200px;"/></td>
			</tr>
			<tr class="gridLight" >
				<th>Agent DO</th><th>:</th><td ><input type="text"value="<?php echo  $rtnContainerList[$i]['agent_do']?>" name="strAgentDo" style="width:200px;"/></td>
				<th>DO Date</th><th>:</th>
					<td>
						<input type="text" id="strDoDate" value="<?php echo  $rtnContainerList[$i]['do_date']?>" name="strDoDate" style="width:200px;"/>
						<script>
							$(function() {
							 $( "#strDoDate" ).datepicker({
							  changeMonth: true,
							  changeYear: true,
							  dateFormat: 'yy-mm-dd', // iso format
							 });
							 });
						</script>
					</td>

			</tr>
			<tr class="gridDark">
				<th>BE No</th><th>:</th><td><input type="text" value="<?php echo  $rtnContainerList[$i]['be_no']?>" name="strBEno" style="width:200px;"/></td>
				<th>BE Date</th><th>:</th>
					<td>
						<input type="text" id="strBEdate" value="<?php echo  $rtnContainerList[$i]['be_date']?>" name="strBEdate" style="width:200px;"/>
						<script>
							$(function() {
							 $( "#strBEdate" ).datepicker({
							  changeMonth: true,
							  changeYear: true,
							  dateFormat: 'yy-mm-dd', // iso format
							 });
							 });
						</script>
					</td>
										
			</tr>
			<tr class="gridDark">
				
				<th>W/R UP TO DATE</th><th>:</th>
					<td>
						<input type="text" id="strWRdate" value="<?php echo  $rtnContainerList[$i]['wr_upto_date']?>" name="strWRdate" style="width:200px;"/>
						<script>
							$(function() {
							 $( "#strWRdate" ).datepicker({
							  changeMonth: true,
							  changeYear: true,
							  dateFormat: 'yy-mm-dd', // iso format
							 });
							 });
						</script>
					</td>
					<th>Tonnage Update</th><th>:</th><td><input type="text" value="<?php echo  $rtnContainerList[$i]['update_ton']?>" name="strTonUpdt" style="width:200px;"/></td>					
			</tr>
			<?php 
				if ($verify_num >0)
				{
					?>
					<tr style="background:#FFF"  align="center">
						<td colspan="6" align="center"><input type="submit" class="login_button" value="UPDATE"/></td>
					</tr>
			<?php
				}
				else{
					?>
					<tr style="background:#FFF"  align="center">
						<td colspan="6" align="center"><input type="submit" class="login_button" value="VERIFY"/></td>
					</tr>
					
			<?php 
				}
			?>
			
		</table>
	</form-->
<?php }
			
			
			}?>
		
	
</TD></TR>
<br/>
<?php 
mysql_close($con_cchaportdb);?>
</table>
</div>
<?php 
}
			else{
				echo "";
				
			}
?>

		 <!--</div>-->
		 </div>
         
		  </form>
          <div class="clr"></div>
        </div>
       
       <!-- <p class="pages"><small>Page 1 of 2</small> <span>1</span> <a href="#">2</a> <a href="#">&raquo;</a></p>-->
      </div>
      <div class="sidebar" >
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	
  </div>