<div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2 align="left"><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>	  

		<div class="img">
			<form name= "myForm"  action="<?php echo site_url("report/smsBalanceEntryFormPerform");?>" method="post">
			<table align="center"> 
				<tr align="center">
					<td><label style="width:80px;"><nobr>TOTAL BUY QTY</nobr></label></td>
					<td><input type="number" style="width:180px;"  id="buy_sms" name="buy_sms" ></td>
					<td><input class="login_button"  name="save" type="submit"  value="SAVE" > </td>
				</tr>  						
				<tr>
					 <td align="right" colspan="3"><?php echo $msg; ?> </td>
			   </tr>					
			 </table>
			 </form>
			<table cellspacing="1" cellpadding="1" align="center"  id="mytbl" style="overflow-y:scroll" width="600px">
				<tr class="gridDark" style="height:35px;">										
					<font size="15">
						<th>SL</th>
						<th><nobr>Previous Buying Qty <nobr></th>
						<th><nobr>Send Qty <nobr></th>
						<th><nobr>Balance Qty <nobr></th>
						<th><nobr>Previous Buy Date<nobr></th>        
					</font>
				</tr>
					
			  <?php

				for($i=0;$i<count($result);$i++) { 				
				?>
				<tr class="gridLight" align="center">
					<td>
						<?php echo $i+1;?>
					</td>
				 
					<td align="center">
						<?php echo $result[$i]['buy_sms']; ?>
					</td> 
					<td align="center">
						<?php echo $result[$i]['send_sms']; ?>
					</td> 
					<td align="center">
						<?php echo $result[$i]['buy_sms'] - $result[$i]['send_sms']; ?>
					</td>   
					<td align="center">
						<?php echo $result[$i]['date_sms']; ?>
					</td>      
				</tr>
				<?php }?>	
			</table>
		</div>
		</div>
			
          <div class="clr"></div>
        </div>

      <div class="sidebar" style="width:140px; padding: 0px 0 12px;">
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	<?php echo form_close()?>
  </div>