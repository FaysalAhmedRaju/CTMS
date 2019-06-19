<div class="content">
    <div class="content_resize">
		<div class="mainbar">
			<div class="article">
				<h2><span><?php echo $title; ?></span> </h2>
				<p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
   
				<div class="clr"></div>
					<div class="img">
						<form name= "myForm"  action="<?php echo site_url("ShedBillController/shedBillList");?>" method="post">
							<table align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="left" ><label><font color='red'></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bill No:</label></td>
									<td>
										<input type="text" style="width:130px;" id="billno" name="billno" value=""/>
										&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="submit" value="Search" class="login_button"/> 
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
							</table>
						</form>
					</div>
        
					<div class="clr"></div>
				</div>
		<table cellspacing="1" cellpadding="1" align="left"  id="mytbl" style="margin-left:20px">
			<tr class="gridDark" style="height:50px;" >
				<font size="15">
					<th>Bill No</th>
					<th>Verify No</th>
					<th>Unit No</th>
					<th>Rotation</th>
					<th>CNF Agent</th>
					<th>Total Amount</th>
					<th>Total VAT</th>
					<th>Action</th>
					<th>Action</th>
				</font>
			</tr>
		
		<?php
		for($i=0;$i<count($rtnbillno);$i++) { 
		?>
		
			<tr <?php if($st==1){?>bgcolor="#CCAEDE"<?php }else{?>class="gridLight"<?php }?>>
				<td align="center" >
					<?php echo $rtnbillno[$i]['bill_no']?>
				</td> 
				<td align="center">
					<?php echo $rtnbillno[$i]['verify_no']?>
				</td>
				<td align="center">
					<?php echo $rtnbillno[$i]['unit_no']?>
				</td>
				<td align="center">
					<?php echo $rtnbillno[$i]['import_rotation']?>
				</td>
				<td align="center">
					<?php echo $rtnbillno[$i]['cnf_agent']?>
				</td> 
				<td align="center">
					<?php echo $rtnbillno[$i]['total_amt']?>
				</td> 
				<td align="center">
					<?php echo $rtnbillno[$i]['total_vat']?>
				</td>   		  
				<td align="center">
					<form action="<?php echo site_url('ShedBillController/getShedBillPdf');?>" method="POST" target="_blank">
						<input type="hidden" name="sendVerifyNo" value="<?php echo $rtnbillno[$i]['verify_no'];?>">
						<input type="submit" value="View Bill" name="viewbill" class="login_button">
					</form> 
				</td> 
				<td align="center">
					<?php
						$rcvstat = 0;
						$vrfno = $rtnbillno[$i]['verify_no'];
						$billrcvstat = "SELECT bill_rcv_stat FROM shed_bill_master WHERE verify_no='$vrfno'";
						
						$res = mysql_query($billrcvstat);
						$rowVal = mysql_fetch_object($res);
						$rcvstat=$rowVal->bill_rcv_stat;
						//echo $rcvstat;
					?>
					<form action="<?php echo site_url('ShedBillController/shedreceive');?>" method="POST">
						<input type="hidden" name="shedrcv" value="<?php echo $rtnbillno[$i]['verify_no'];?>">
						<input type="submit" name="receive" value="Receive" <?php if($rcvstat==1){ ?> disabled="true" style="color:black"<?php } ?> class="login_button">
					</form> 
				</td> 
			</tr>
         <?php
        }
       ?>
	</table>
       
      
      </div>
      <div class="sidebar">
    <?php include_once("mySideBar.php"); ?>
   </div>
      <div class="clr"></div>
    </div>
 <?php echo form_close()?>
  </div>