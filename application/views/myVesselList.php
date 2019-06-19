<?php
/*****************************************************
Developed BY: Shemul Bhowmick
Sr. Software Engineer
DataSoft Systems Bangladesh Ltd
******************************************************/
?>
<div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <span><?php echo $myUpdateManifestList; ?></span>
		  <div class="clr"></div>
		  
		
	
		<div class="img">
			 
		<table border="0" width="650px">
			<!--<TR align="center"><TD colspan="6" ><h2><span ><?php echo $title; ?></span> </h2></TD></TR>-->
			
			<!--<TR><TD colspan="6"  id="lbl_SearchCriteria">
			<form action="<?php echo base_url().'index.php/report/myVesselList';?>" method="POST">
			<?php
				//echo form_open(base_url().'index.php/report/myVesselList',$attributes);
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
			<?php $year=date("Y");?>
			<select name="SearchCriteria" onchange="this.form.submit()">
			<option>-- select Year --</option>
			<?php 
				
				for($j=2014;$j<=$year;$j++){
				?><option value="<?php echo $j; ?>"><?php echo $j; ?></option>
				<?php } ?>
			
			</select>
			</form>
			<?php form_close();
			//
			?>
			
			</TD></TR>-->
			
			<tr><td>
				<form action="<?php echo base_url().'index.php/report/myVesselList';?>" method="POST">
				<table style="border:solid 1px #ccc;" height="200px" width="640px" align="left">
					<tr height="50px" valign="top"><td align="left" colspan="2"><label><font color='#2886B7' size="2"><b>Search By Submission Date</b></font></label></td></tr>
					<TR align="center">	
						
						<td align="right" ><label><font color='red'><b>*</b></font>From Date:</label>
							<td align="left"> 
								<input type="text" style="width:120px;" id="fromdate" name="fromdate" value="<?php date("Y-m-d"); ?>"/>
							</td>
											
							<script>
								$(function() {
									$( "#fromdate" ).datepicker({
										changeMonth: true,
										changeYear: true,
										dateFormat: 'yy-mm-dd', // iso format
									});
								});
							</script>
						</td>
					</tr>
					<tr align="center">
					
						<td align="right" ><label><font color='red'><b>*</b></font>To Date:
						<td align="left"><input type="text" style="width:120px;" id="todate" name="todate" value="<?php date("Y-m-d"); ?>" /></td>
							</label> 
							<script>
								$(function() {
									$( "#todate" ).datepicker({
										changeMonth: true,
										changeYear: true,
										dateFormat: 'yy-mm-dd', // iso format
									});
								});
							</script>
						</td>
						</tr>
						<tr align="center">
						
						<td  colspan="2" align="center" width="70px"><?php $arrt = array('name'=>'submit_login','id'=>'submit','value'=>'Search','class'=>'login_button'); echo form_submit($arrt);?></td>
						<!--<td  align="center" width="70px"><input type="submit" name="submit_login" id="submit" value="Search" class="login_button" style="background: url(<?php echo IMG_PATH?>search.ico) no-repeat scroll 0 0 transparent;"><?php //$arrt = array('name'=>'submit_login','id'=>'submit','value'=>'Search','class'=>'login_button'); echo form_submit($arrt);?></td>-->
					</tr>
				</td>
			</tr>
		</table>
		</form>
			<TR><TD >&nbsp;</TD></TR>
	<?php if($rtnVesselList) { ?>
		<TR><TD >
		<table border=0 cellspacing="1" cellpadding="1" bdcolor="#ffffff" width="100%">
		<tr class="login_button1" align="center">
			<td>Import Rotation No</td>
			<td>Vessel Name</td>
			<td>Submission Date</td>
			<td>Download IGM</td>
			
		</tr>
		
		
			
		<?php
			
			$len=count($rtnVesselList);
            // echo $len;
            for($i=0;$i<$len;$i++){
			
		?>
			    <tr class="gridLight" align="center">
					<td><?php echo $rtnVesselList[$i]['Import_Rotation_No']; ?></td>
					<td><?php echo $rtnVesselList[$i]['Vessel_Name']; ?></td>
					<td><?php echo $rtnVesselList[$i]['Submission_Date']; ?></td>
					<td><a href="<?php echo site_url('report/myIGMDownload/'.$rtnVesselList[$i]['Import_Rotation_No']); ?>" target='_blank' download><img src="<?php echo IMG_PATH; ?>download.png" width="30" height="30" alt="" /></a></td>
					
					
					
	
					
	
			
		
				</tr>
		<?php	
			
			}	
			
		}


		?>
	</table>
</TD></TR>
<!--<TR><TD><p><?php echo $links; ?></p></TD></TR>-->
</table>

		</div>
         <!-- <div class="post_content">
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. <a href="#">Suspendisse bibendum. Cras id urna.</a> Morbi tincidunt, orci ac convallis aliquam, lectus turpis varius lorem, eu posuere nunc justo tempus leo. Donec mattis, purus nec placerat bibendum, dui pede condimentum odio, ac blandit ante orci ut diam. Cras fringilla magna. Phasellus suscipit, leo a pharetra condimentum, lorem tellus eleifend magna, eget fringilla velit magna id neque. Curabitur vel urna. In tristique orci porttitor ipsum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. Suspendisse bibendum. Cras id urna. Morbi tincidunt, orci ac convallis aliquam, lectus turpis varius lorem, eu posuere nunc justo tempus leo.</p>
            <p><strong>Aenean consequat porttitor adipiscing. Nam pellentesque justo ut tortor congue lobortis. Donec venenatis sagittis fringilla.</strong> Etiam nec libero magna, et dictum velit. Proin mauris mauris, mattis eu elementum eget, commodo in nulla. Mauris posuere venenatis pretium. Maecenas a dui sed lorem aliquam dictum. Nunc urna leo, imperdiet eu bibendum ac, pretium ac massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla facilisi. Quisque condimentum luctus ullamcorper.</p>
            <p class="spec"><a href="#" class="rm">Read more &raquo;</a></p>
			
			
          </div>-->
		  </form>
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