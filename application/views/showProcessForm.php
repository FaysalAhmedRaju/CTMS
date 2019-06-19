 <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div align="center"><span><?php echo $msg; ?></span></div>
		  <div class="clr"></div>

		<div class="img">
		
		 <table  style="border:solid 1px #ccc;" width="550px" align="center" cellspacing="0" cellpadding="0">
				<tr><td>	 
		 <table  align="center" border="0">		
						<thead>
							<tr bgcolor="#85DDEA">
								<th>Sl No</th>
								<th>User</th>						
								<th>Host</th>
								<th>DB</th>
								<th>Command</th>
								<th>Time</th>
								<th>State</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$j=$start;
						for($i=0;$i<count($processList);$i++) { 
						$j++;
						//$equip = $processList[$i]['equipement'];
						//$srcBlock= $processList[$i]['Block'];
						?>
						
				<tr <?php if($processList[$i]['TIME']>2000) { ?> bgcolor="red" <?php } else if($processList[$i]['TIME']>1000 and $processList[$i]['TIME']<2000){ ?>bgcolor="orange" <?php }else { ?> bgcolor="green" <?php }?> style="color:white;">
					<td><?php  echo $j; ?></td>					
					<td><?php if($processList[$i]['USER']) echo $processList[$i]['USER']; else echo "&nsp;"; ?></td>					
					<td><?php if($processList[$i]['HOST']) echo $processList[$i]['HOST']; else echo "&nbsp;"; ?></td>		
					<td><?php if($processList[$i]['DB']) echo $processList[$i]['DB']; else echo "&nbsp;"; ?></td>
					<td><?php if($processList[$i]['COMMAND']) echo $processList[$i]['COMMAND']; else echo "&nbsp;"; ?></td>
					<td>
						<?php if($processList[$i]['TIME']) echo $processList[$i]['TIME']; else echo "&nbsp;"; ?>
					</td>
					<td><?php if($processList[$i]['STATE']) echo $processList[$i]['STATE']; else echo "&nbsp;"; ?></td>
	
				
					
					
				</tr>
				<?php } ?>
						</tbody>
						
				</table>
			</td>
		</tr>
		<TR><TD align="center"><p><?php echo $links; ?></p></TD></TR>
	</table>

		 <!--</div>-->
		 </div>
      
		  </form>
          <div class="clr"></div>
        </div>
		
		<?php
			if($mystatus==2)
			{
				echo $body;
			}
		?>
      </div>
      <div class="sidebar">
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	<?php echo form_close()?>
  </div>