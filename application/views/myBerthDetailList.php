<?php
/*****************************************************
Developed BY: Shemul Bhowmick
Sr. Software Engineer
DataSoft Systems Bangladesh Ltd
******************************************************/

$_SESSION['Control_Panel']=$this->session->userdata('Control_Panel');
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
				/*$location_options = array(
					'Export_Rotation_No' =>'Export Rotation No',
					'vsl_name' =>'Vessel Name',
					'voys_no' =>'Voyage No',
					'call_sign' =>'Call Sign',
					'load_port' =>'Load Port',
					'next_port' =>'Next Port',
					'date' =>'Date',
					'create_time' =>'Create Date',
				);

				echo form_dropdown('SearchCriteria', $location_options, $this->input->post('SearchCriteria'));*/
			?>
			<?php 
				/*$attribute = array('name'=>'Searchdata','id'=>'SearchID','class'=>'login_input_text' );
				echo form_input($attribute,set_value('Searchdata'));
				//'onblur'=> "alert();"*/
			?>
			<?php /*$arrt = array('name'=>'SearchD','id'=>'submit','value'=>'Go','class'=>'login_button'); echo form_submit($arrt);*/?>
			<input type="hidden" name="type" value="<?php echo $type; ?>">
			<?php form_close();?>
			</form>	
			</TD></TR>
			<TR><TD >&nbsp;</TD></TR>
	
		<TR><TD >
		<table border=0 cellspacing="1" cellpadding="1" bdcolor="#ffffff">
		<tr class="login_button1" align="center">
			<td>Export Rotation No</td>
			<td>Vessel Name</td>
			<td>Master Name</td>
			<td>Agent Code</td>
			<td>Agent Name</td>
			<td>Berth</td>
			<td>ATA</td>
			<td>ATD</td>
			
		</tr>
		
		
			
		<?php
			if($ediDetails) {
			$len=count($ediDetails);
            // echo $len;
            for($i=0;$i<$len;$i++){
			//echo $ediDetails[$i]['Export_Rotation_No']; 
			 
		?>
			    <tr class="gridLight" align="center">
					<td><?php echo $ediDetails[$i]['Export_Rotation_No']; ?></td>
					<td><?php echo $ediDetails[$i]['vsl_name']; ?></td>
					<td><?php echo $ediDetails[$i]['master_name']; ?></td>
					<td><?php echo $ediDetails[$i]['agent_code']; ?></td>
					<td><?php echo $ediDetails[$i]['agent_name']; ?></td>
					<td><?php echo $ediDetails[$i]['bearth']; ?></td>
					<td><?php echo $ediDetails[$i]['ata']; ?></td>
					<td><?php echo $ediDetails[$i]['atd']; ?></td>
					
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