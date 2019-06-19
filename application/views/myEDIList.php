<?php
/*****************************************************
Developed BY: Shemul Bhowmick
Sr. Software Engineer
DataSoft Systems Bangladesh Ltd
******************************************************/

$_SESSION['Control_Panel']=$this->session->userdata('Control_Panel');
$login_id=$this->session->userdata('login_id');
?>
 <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
		  
		 
		<div class="img">
			 
		<table border="0" width="650px">
			<!--<TR align="center"><TD colspan="6" ><h2><span ><?php echo $title; ?></span> </h2></TD></TR>-->
			
			<TR><TD colspan="6"  id="lbl_SearchCriteria">
			
			<?php
				echo form_open(base_url().'index.php/report/myEDIListSearch',$attributes);
				$Stylepadding = 'style="padding: 12px 20px;"';
				if(!empty($error_message))
				{
					$Stylepadding = 'style="padding:25px 20px;"';
				}	
				if(isset($captcha_image)){
					$Stylepadding = 'style="padding:62px 20px 93px;"';
				}
			?>
			Search&nbsp;&nbsp; 
			<?php 
				$location_options = array(
					'Export_Rotation_No' =>'Export Rotation No',
					'vsl_name' =>'Vessel Name',
					'voys_no' =>'Voyage No',
					'call_sign' =>'Call Sign',
					'load_port' =>'Load Port',
					'next_port' =>'Next Port',
					'date' =>'Date',
					'create_time' =>'Create Date',
				);

				echo form_dropdown('SearchCriteria', $location_options, $this->input->post('SearchCriteria'));
			?>
			<?php 
				$attribute = array('name'=>'Searchdata','id'=>'SearchID','class'=>'login_input_text' );
				echo form_input($attribute,set_value('Searchdata'));
				//'onblur'=> "alert();"
			?>
			<?php $arrt = array('name'=>'SearchD','id'=>'submit','value'=>'Go','class'=>'login_button'); echo form_submit($arrt);?>
			<input type="hidden" name="type" value="<?php echo $type; ?>">
			<?php form_close();?>
			</form>	
			</TD></TR>
			<TR><TD >&nbsp;</TD></TR>
	
		<TR><TD >
		<table border=0 cellspacing="1" cellpadding="1" bdcolor="#ffffff">
		<tr class="login_button1" align="center">
			<td>Export Rotation No</td>
			<td>Voys</td>
			<td>Call Sign</td>
			<td>Vessel Name</td>
			<td>Date</td>
			<td>Load Port</td>
			<td>Next Port</td>
			<td>Create Time</td>
			<td>Berth Details</td>
			<td>View Details</td>
			<!--<td>View Edi</td>-->
			<td>Download Edi</td>
		</tr>
		
		
			
		<?php
			if($ediDetails) {
			$len=count($ediDetails);
            // echo $len;
            for($i=0;$i<$len;$i++){
			$filename=$login_id."_".str_replace("/","",$ediDetails[$i]['Export_Rotation_No'].".edi");
	
			$converted_EDI='http://'.$_SERVER['SERVER_ADDR']."/myportpanel/resources/uploadfile/xml/".$filename;
			//echo $ediDetails[$i]['Export_Rotation_No']; 
			 
		?>
			    <tr class="gridLight" align="center">
					<td><?php echo $ediDetails[$i]['Export_Rotation_No']; ?></td>
					<td><?php echo $ediDetails[$i]['voys_no']; ?></td>
					<td><?php echo $ediDetails[$i]['call_sign']; ?></td>
					<td><?php echo $ediDetails[$i]['vsl_name']; ?></td>
					<td><?php echo $ediDetails[$i]['date']; ?></td>
					<td><?php echo $ediDetails[$i]['load_port']; ?></td>
					<td><?php echo $ediDetails[$i]['next_port']; ?></td>
					<td><?php echo $ediDetails[$i]['create_time']; ?></td>
					<td><a href="<?php echo site_url('report/viewBerthDetails/'.str_replace("/","",$ediDetails[$i]['Export_Rotation_No'])) ?>">Details</a></td>
					<td><a href="<?php echo site_url('report/viewEDIDetails/'.str_replace("/","",$ediDetails[$i]['Export_Rotation_No'])) ?>">Details</a></td>
					<!--<td><a href="<?php echo $converted_EDI; ?>" target='_blank'>View</a></td>-->
					<td><a href="<?php echo $converted_EDI; ?>" target='_blank' download><img src="<?php echo IMG_PATH; ?>download.png" width="30" height="30" alt="" /></a></td>
					
					
					
	
					
	
			
		
				</tr>
		<?php	
			
			}	
			
		}


		?>
	</table>
</TD></TR>
<TR><TD><p><?php echo $links; ?></p></TD></TR>
</table>

		 </div>
        
		  
          <div class="clr"></div>
        </div>
         </div>
      <div class="sidebar">
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	<?php echo form_close()?>
  </div>