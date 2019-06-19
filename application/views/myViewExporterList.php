<div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
			<div class="img">
			<table width="100%">
			<?php echo form_open(base_url().'index.php/igmViewController/viewExporterList/search',$attributes);?>
				<tr>
					<td>
						Search
					</td>
					<td>
						<input type="text" name="search">
					</td>
					<td>
						<?php $arrt = array('name'=>'Add','id'=>'submit','value'=>'OK','class'=>'login_button'); echo form_submit($arrt);?>
					</td>
					
				</tr>
				<?php echo form_close()?>
				</table><br/>
			<table style="border:solid 1px #ccc;" width="640px" align="center" cellspacing="0" cellpadding="0">
				
				<tr><td>	
			<TABLE width="100%" border="0" align="center">
				
				<tr class="gridDark">
					
					<td>Exporter Name</td>
					<td>Exporter Address</td>
				</tr>
				<?php for($i=0;$i<count($igmImporterList);$i++) {?>
				<tr class="gridLight">
					
					<td><?php if($igmImporterList[$i]['Exporter_name']) echo $igmImporterList[$i]['Exporter_name']; else echo "&nsp;"; ?></td>
					<td><?php if($igmImporterList[$i]['Exporter_address']) echo $igmImporterList[$i]['Exporter_address']; else echo "&nbsp;"; ?></td>
					
				</tr>
				<?php } ?>
			
			</TABLE>
			</td></tr>
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
</div>