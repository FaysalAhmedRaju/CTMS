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
				echo form_open(base_url().'index.php/report/myEDIDetailSearch',$attributes);
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
					'container_no' =>'Container No',
					'iso_code' =>'ISO Code',
					'line_op' =>'Line Operator',
					'status' =>'Container Status',
					'seal' =>'Container Seal',
					'imdg' =>'IMDG',
					'unno' =>'UNNO',
					'loasd_port' =>'Load Port',
					'discharge_port' =>'Discharge Port',
					'st' =>'Stowage',
					'Export_Rotation_No'=>'ALL'
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
			<td>Container No</td>
			<td>ISO Code</td>
			<td>Line Op</td>
			<td>Status</td>
			<td>Weight</td>
			<td>Seal</td>
			<td>IMDG</td>
			<td>UNNO</td>
			<td>Temparature</td>
			<td>Load Port</td>
			<td>Discharge Port</td>
			<td>Stowage</td>
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
					<td><?php echo $ediDetails[$i]['container_no']; ?></td>
					<td><?php echo $ediDetails[$i]['iso_code']; ?></td>
					<td><?php echo $ediDetails[$i]['line_op']; ?></td>
					<td><?php echo $ediDetails[$i]['status']; ?></td>
					<td><?php echo $ediDetails[$i]['weight']; ?></td>
					<td><?php echo $ediDetails[$i]['seal']; ?></td>
					<td><?php echo $ediDetails[$i]['imdg']; ?></td>
					<td><?php echo $ediDetails[$i]['unno']; ?></td>
					<td><?php echo $ediDetails[$i]['temp']; ?></td>
					<td><?php echo $ediDetails[$i]['loasd_port']; ?></td>
					<td><?php echo $ediDetails[$i]['discharge_port']; ?></td>
					<td><?php echo $ediDetails[$i]['stowage']; ?></td>
				</tr>
		<?php	
			
			}	
			
		}


		?>
		
	</table>
</TD></TR>
<TR bgcolor="#C7EDFC" align="center"><TD><p><?php echo $links; ?></p></TD></TR>
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