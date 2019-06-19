 <div class="content">
    <div class="content_resize_1">
      <div class="mainbar_1">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div align="center"><span><?php echo $msg; ?></span></div>
		  <div class="clr"></div>

		<div class="img">
		
		 <table  style="border:solid 1px #ccc;" width="750px" align="center" cellspacing="0" cellpadding="0">
				<tr><td>	 
		 <table  align="center" border="0">	
						
						<thead>
						<tr><td align="center"><b><font size="4"><nobr>Slave process of DB-21</nobr></font></b></td></tr>
							<tr bgcolor="#85DDEA">
								<th>Slave IO Running</th>
								<th>Slave SQL Running</th>						
								<th>Seconds Behind Master</th>
								<th>Slave IO State</th>
								<th>Master Host</th>
								<th>Relay Log Pos</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						for($i=0;$i<count($processList);$i++) { ?>
						
						<tr <?php if($processList[$i]['Slave_IO_Running']=="No" or $processList[$i]['Slave_SQL_Running']=="No") { ?> bgcolor="#E74C3C" <?php }  else { ?> bgcolor="#1E8449" <?php }?> style="color:white;">				
							<td align="center"><?php echo $processList[$i]['Slave_IO_Running']; ?></td>					
							<td align="center"><?php echo $processList[$i]['Slave_SQL_Running'];  ?></td>		
							<td align="center"><?php echo $processList[$i]['Seconds_Behind_Master']; ?></td>
							<td align="center"><?php echo $processList[$i]['Slave_IO_State'];  ?></td>
							<td align="center"><?php echo $processList[$i]['Master_Host']; ?></td>
							<td align="center"><?php echo $processList[$i]['Relay_Log_Pos']; ?></td>
						</tr>
				<?php } ?>
						</tbody>
						<tr><td>&nbsp;&nbsp;</td></tr>
						<tr><td>&nbsp;&nbsp;</td></tr>
						<tr><td align="center"><b><font size="4"><nobr>Slave process of DB-22</nobr></font></b></td></tr>
						
						<thead>
							<tr bgcolor="#85DDEA">
								<th>Slave IO Running</th>
								<th>Slave SQL Running</th>						
								<th>Seconds Behind Master</th>
								<th>Slave IO State</th>
								<th>Master Host</th>
								<th>Relay Log Pos</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						for($i=0;$i<count($processList22);$i++) { ?>
						
						<tr <?php if($processList22[$i]['Slave_IO_Running']=="No" or $processList22[$i]['Slave_SQL_Running']=="No") { ?> bgcolor="#E74C3C" <?php }  else { ?> bgcolor="#1E8449" <?php }?> style="color:white;">				
							<td align="center"><?php echo $processList22[$i]['Slave_IO_Running']; ?></td>					
							<td align="center"><?php echo $processList22[$i]['Slave_SQL_Running'];  ?></td>		
							<td align="center"><?php echo $processList22[$i]['Seconds_Behind_Master']; ?></td>
							<td align="center"><?php echo $processList22[$i]['Slave_IO_State'];  ?></td>
							<td align="center"><?php echo $processList22[$i]['Master_Host']; ?></td>
							<td align="center"><?php echo $processList22[$i]['Relay_Log_Pos']; ?></td>
						</tr>
				<?php } ?>
						</tbody>
						
				</table>
			</td>
		</tr>
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