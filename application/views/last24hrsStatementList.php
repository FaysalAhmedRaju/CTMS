<script>
function validate(){
   if (confirm("Do you want to delete this Statement?") == true) {
		   return true ;
		} else {
			return false;
		}
}	
</script>
<html>

<!--body onload="getAllGate()"-->
<div class="content">
    <div class="content_resize_1">
		<div class="mainbar_1">
			<div class="article">
				<h2 align="center"><span><?php echo $title; ?></span> </h2>
				<p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
   
				<div class="clr"></div>
					<div class="img">
						<form name= "myForm" onsubmit="return(validation());" action="<?php echo site_url("uploadExcel/last24hrsOffDocStatement");?>" target="_blank" method="post">
						<h3 align="center"><span><?php if($delFlag==1) echo $msg2; ?></span> </h3>
						<table cellspacing="1" cellpadding="1" align="center" id="mytbl" >
						 <tr><td colspan="12" align="center"><h3><span><nobr><b><?php echo $tableTitle; ?></b></nobr></span> </h3></td></tr>
							<tr class="gridDark" style="height:35px;">
								<font size="15">
									<th rowspan="2">SL</th>
									<th rowspan="2">Date</th>
									<th rowspan="2"><nobr>Capacity</nobr></th>
									<th rowspan="2">Imp.Cont Lying</th>
									<th rowspan="2">Exp.Cont Lying</th>
									<th rowspan="2">Emty.Cont Lying</th>
									<th rowspan="2">Total</th>
									<th rowspan="2">Last 24hrs <br/> Exp. stuffed</th>
									<th colspan="2"><nobr>Port To Deport<nobr></th>
									<th colspan="2"><nobr>Deport To Port<nobr></th>
									<th rowspan="2">Remarks</th>
									<th rowspan="2">Action</th>
									<th rowspan="2">Action</th>
									<th rowspan="2">Print</th>
								</font>
							</tr>
							<tr class="gridDark">
									<th>Laden</th>
									<th>Empty</th>
									<th>Laedn</th>
									<th>Empty</th>
							</tr>
								
							  <?php
							   
								for($i=0;$i<count($offDock);$i++) { 				
								?>
								
							<tr class="gridLight">
								  <td>
								   <?php echo $i+1;?>
								  </td>
								  <td align="center">
								   <?php echo $offDock[$i]['stmt_date']?>
								  </td>
								  <td align="center">
								   <?php echo $offDock[$i]['capacity']?>
								  </td>
								  <td align="center">
								   <?php echo $offDock[$i]['imp_lying']?>
								  </td>
								  <td align="center">
								   <?php echo $offDock[$i]['exp_lying']?>
								  </td> 
								   <td align="center">
								   <?php echo $offDock[$i]['mty_lying']?>
								  </td> 
								  <td align="center">
								   <?php echo $offDock[$i]['total_teus']?>
								  </td> 
								  <td align="center">
								   <?php echo $offDock[$i]['last_24hrs']?>
								  </td> 
								  <td align="center">
								   <?php echo $offDock[$i]['port_to_depo_laden']?>
								  </td> 
								  <td align="center">
								   <?php echo $offDock[$i]['port_to_depo_mty']?>
								  </td>    
								  <td align="center">
								   <?php echo $offDock[$i]['depo_to_port_laden']?>
								  </td>  
								  <td align="center">
								   <?php echo $offDock[$i]['depo_to_port_mty']?>
								  </td>  
								  <td align="center">
								   <?php echo $offDock[$i]['remarks']?>
								  </td>
								</form>  
								 <td align="center">
									<form action="<?php echo site_url('uploadExcel/last24hrsOffDocStatementEdit');?>" target="_self" method="POST">
									<?php
											$time=$offDock[$i]['last_update'];
											 include("mydbPConnection.php");
										    $str = "SELECT TIMEDIFF(CONCAT(DATE('$time'),' 10:00:00'),NOW()) AS diff ";
											$query=mysql_query($str);
											$row=mysql_fetch_object($query);
											$difference=$row->diff;	
										?>
									   
										<input type="hidden" name="akey" id="akey" value="<?php echo $offDock[$i]['akey'];?>">							
										<input type="submit" title="Update" value="Edit"  class="login_button" style="width:70%" <?php if( strtotime($difference) < strtotime(' 00:00:00')){ ?>  bgcolor="#FA5858" disabled  <?php } ?> >							
									</form> 
								  </td> 
								  <td align="center">
									<form action="<?php echo site_url('uploadExcel/last24hrsOffDocStatementDelete');?>"  onsubmit="return validate()" method="POST">
									
										
										<input type="hidden" name="akey1" id="akey1" value="<?php echo $offDock[$i]['akey'];?>">							
										<input type="submit"  title="Delete" Value="X"  class="login_button" style="width:70%;" <?php if( strtotime($difference) < strtotime(' 00:00:00')){ ?>  style="background-color:#FA5858" disabled  <?php } ?> >							
									</form> 
								  </td>   
								  <td align="center">
									<form action="<?php echo site_url('uploadExcel/last24hrsOffDocStatementPdf');?>" target="_blank" method="POST">

										<input type="hidden" name="akey2" id="akey2" value="<?php echo $offDock[$i]['akey'];?>">							
										<input type="submit" title="Print" value="Print"  class="login_button" style="width:100%;">							
									</form> 
								  </td> 
						  
							</tr>
						<?php } ?>				
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
  <!--/body-->
  </html>