<div class="content">
    <div class="content_resize_1">
      <div class="mainbar_1">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <span><?php echo $myUpdateManifestList; ?></span>
		  <div class="clr"></div>
		  
		  <?php 
		  $attributes = array('id' => 'myform');
		  //,'target'=>'_BLANK'
		  echo form_open(base_url().'index.php/report/oneStopIgmCertifyList',$attributes);
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
						
						<tr><td colspan="2"><font color="blue"><b><?php echo $msg; ?></b></font></td></tr>
						
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr align="center">
							
							
							<td align="right" ><label for="rotation_no">Container No:<em>&nbsp;</em></label></td>
							<td align="left" >
							<?php 
								$attribute = array('name'=>'ddl_imp_cont_no','id'=>'txt_login','class'=>'login_input_text' );
								echo form_input($attribute,set_value('ddl_imp_rot_no'));
								//'onblur'=> "alert();"
							?>
									
							</td>
						</tr>	
						<tr><td colspan="2" align="center"><font size="2" color="black"><b>Or</b></font></td></tr>
						<tr align="center">
							<br />
							
							<td align="right" ><label for="rotation_no">BL No:<em>&nbsp;</em></label></td>
							<td align="left" >
							<?php 
								$attribute = array('name'=>'ddl_imp_bl_no','id'=>'txt_login','class'=>'login_input_text' );
								echo form_input($attribute,set_value('ddl_imp_rot_no'));
								//'onblur'=> "alert();"
							?>
									
							</td>
						</tr>	
						
						<tr>
							<td colspan="2" align="center" width="70px"><br><?php $arrt = array('name'=>'report','id'=>'submit','value'=>'Search','class'=>'login_button'); echo form_submit($arrt);?>	
						</tr>
						<tr><td colspan="2">&nbsp;</td></tr>
				</table>
			</td>
		</tr>
	</table>
	
	<?php
/*****************************************************
Developed BY: Shemul Bhowmick
Sr. Software Engineer
DataSoft Systems Bangladesh Ltd
******************************************************/

$_SESSION['Control_Panel']=$this->session->userdata('Control_Panel');
include("mydbPConnection.php");
?>


<table border="0" width="60%" bgcolor="#FFFFFF">
	<TR align="center"><TD colspan="6" ><h2><span ><?php echo $title; ?></span> </h2></TD></TR>
	<TR align="center"><TD colspan="6" ><h2><span ><?php if($containerNo!="") echo "Container No: ".$containerNo; else echo "BL No: ".$blNo ?></span> </h2></TD></TR>
	
	<TR><TD colspan="6" align="center">
		<table border=0 cellspacing="1" cellpading="1" bdcolor="#ffffff">
		<tr class="gridDark" >
			<td align="center">SL</td>
			<td align="center">Container</td>
			<td align="center" >Yard</td>
			<td align="center">Position</td>
			<td align="center">Rotation</td>
			<td align="center">Vessel Name</td>
			<td align="center">Master BL</td>
			<td align="center">Sub BL</td>
			<td align="center">Discharge Time</td>
			<td align="center">Size</td>
			<td align="center">Height</td>
			<td align="center">Destination</td>
			<td align="center">Offdock Name</td>
			<td align="center">Gate Out Date & Time</td>
			<td align="center">Status</td>
			<td align="center">Seal</td>
			<td align="center">Container Type</td>
		</tr>
		
		
		<?php
			
			
			$totcontainerNo="";
			if($rtnContainerList) {
			$len=count($rtnContainerList);
            $j=0;
            for($i=0;$i<$len;$i++){
			 $id=$rtnContainerList[$i]['id'];
			 $sql=mysql_query("select  group_concat(igm_supplimentary_detail.BL_No) as sub_bl from igm_supplimentary_detail where igm_detail_id=$id");
			 $rtnSubBl=mysql_fetch_object($sql);
			 $subBl=$rtnSubBl->sub_bl;
			 $j++;
			 $containerNo1=$rtnContainerList[$i]['cont_number'];
			 $rotaionNo=$rtnContainerList[$i]['Import_Rotation_No'];
			//echo $rtnContainerList[$i]['cont_number']."-".$containerNo;
			$conn=mysql_connect("10.1.1.21","sparcsn4","sparcsn4");
			mysql_select_db("ctmsmis",$conn);
			
			$sqlYardPosition=mysql_query("select fcy_time_in,fcy_last_pos_slot,yard,fcy_time_out,(select cont_block(fcy_last_pos_slot,yard)) as block from (
			select fcy_time_in,fcy_last_pos_slot,(select cont_yard(fcy_last_pos_slot)) as yard,fcy_time_out from mis_inv_unit where id='$containerNo1' and vsl_visit_dtls_ib_vyg='$rotaionNo'
			) as  tmp",$conn);
			$rtnYardPosition=mysql_fetch_object($sqlYardPosition);
			
			
			
		?>
			    <tr <?php if($rtnContainerList[$i]['cont_number']==$containerNo) { ?> class="pinkLight" <?php } else { ?> class="gridLight" <?php } ?>>
					<td align="center"><?php echo $j; ?></td>
					<td align="center" ><?php print($rtnContainerList[$i]['cont_number']); ?></td>
					<td align="center" ><?php if($rtnYardPosition->yard) print($rtnYardPosition->yard.", ".$rtnYardPosition->block);  ?></td>
					<td align="center"><?php if($rtnYardPosition->fcy_time_in=="") print($rtnYardPosition->fcy_last_pos_slot."<font color='blue' size='2'><i> On_Vessel</i></font>"); else print($rtnYardPosition->fcy_last_pos_slot); ?></td>
					<td align="center"><?php print($rtnContainerList[$i]['Import_Rotation_No']); ?></td>
					<td align="center"><?php print($rtnContainerList[$i]['vsl_name']); ?></td>
					<td align="center"><?php print($rtnContainerList[$i]['BL_No']); ?></td>
					<td align="center" ><?php print($subBl); ?></td>
					<td align="center"><?php print($rtnYardPosition->fcy_time_in); ?></td>
					<td align="center"><?php print($rtnContainerList[$i]['cont_size']); ?></td>
					<td align="center"><?php print($rtnContainerList[$i]['cont_height']); ?></td>
					<td align="center"><?php print($rtnContainerList[$i]['off_dock_id']); ?></td>
					<td align="center"><?php print($rtnContainerList[$i]['offdock_name']); ?></td>
					<td align="center"><?php print($rtnYardPosition->fcy_time_out); ?></td>
					<td align="center"><?php print($rtnContainerList[$i]['cont_status']); ?></td>
					<td align="center"><?php print($rtnContainerList[$i]['cont_seal_number']); ?></td>
					<td align="center"> <?php print($rtnContainerList[$i]['cont_iso_type']); ?></td>
				</tr>
		<?php	
			
			if($totcontainerNo!="")
				$totcontainerNo=$totcontainerNo.",".$containerNo1;
			else
				$totcontainerNo=$containerNo1;
				
				mysql_close($conn);
			
			}	}
			

		?>
		<tr><td colspan="16" align="center"><?php echo "Total Container: ". $j;?></td></tr>
		<tr><td colspan="16" align="left"><?php if($totcontainerNo) echo  $totcontainerNo; else echo "&nbsp;"; ?></td></tr>
	</table>
</TD></TR>
<br/>

</table>

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
	<?php echo form_close()?>
  </div>