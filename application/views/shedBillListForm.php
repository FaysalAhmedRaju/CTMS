<script type="text/javascript">

function validate()
	{
		if( document.myForm.search_by.value == "" )
		{
			alert( "Please select search type!" );
			document.myForm.search_by.focus() ;
			return false;
		}
		return true ;
	}

</script>
<div class="content">
    <div class="content_resize_1">
		<div class="mainbar_1">
			<div class="article">
				<h2><span><?php echo $title; ?></span> </h2>
				<p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
   
				<div class="clr"></div>
					<div class="img">
						<form name="myForm" id="myForm" action="<?php echo site_url("ShedBillController/shedBillList");?>" method="post" onsubmit="return validate()">
							<table align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="left" ><label><font color='red'></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Search By:</label></td>
									
									<td>
										<select name="search_by" id="search_by" class="">
											<option value="" label="search" selected style="width:110px;">--Select--</option>
											<option value="billNo" label="billNo" >Bill No</option>
											<option value="verifyNo" label="verifyNo" >Verify No</option>	
											<option value="Unit" label="Unit" >Unit</option>					
										</select>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="left" ><label><font color='red'></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Value:</label></td>
									
									<td>
										<input type="text" style="width:130px;" id="search_value" name="search_value" value=""  />
										<input type="submit" value="Search" class="login_button"/> 
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								
								<tr>
									<td>&nbsp;</td>
								</tr>
							</table>
						</form>
					</div>
        
					<div class="clr"></div>
				</div>
		<div style="height:200px;overflow:auto;width:800px;">		
			<table cellspacing="1" cellpadding="1" align="center" id="mytbl" >
				<tr class="gridDark" style="height:50px;" >
					<font size="15">
						<th>Bill No</th>
						<th>CP No</th>
						<th>Verify No</th>
						<th>Unit No</th>
						<th>Rotation</th>
						<th>CNF Agent</th>
						<th>Total Amount</th>
						<th>Total VAT</th>
						<th>Total Port</th>
						<th>Total MLWF</th>
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
					<td align="center"><nobr>
						<?php 
							$bn=$rtnbillno[$i]['bn'];
						
							$sqlcpno="SELECT gkey,bill_no,cp_no,RIGHT(cp_year,2) AS cp_year,cp_bank_code,cp_unit FROM bank_bill_recv WHERE bill_no='$bn'";
							$rtncpno=$this->bm->dataSelectDb1($sqlcpno);
							$cpbankcode=$rtncpno[0]['cp_bank_code'];
							$cpno=$rtncpno[0]['cp_no'];
							$cpyear=$rtncpno[0]['cp_year'];
							$cpunit=$rtncpno[0]['cp_unit'];
							$num_length = strlen($cpno);
							if($num_length == 4) 
							{
								$newcpno=$cpno;
							} 
							else if($num_length == 3)
							{
								$newcpno="0"."$cpno";
							}
							else if($num_length == 2)
							{
								$newcpno="00"."$cpno";
							}
							else if($num_length == 1)
							{
								$newcpno="000"."$cpno";
							}
							if($cpbankcode!=""&&$cpno!="")
							{
								echo $cpnoview=$cpbankcode.$cpunit."/".$cpyear."-"."$newcpno";
							}
					
						?>
						</nobr>
					</td>
					<td align="center">
						<?php echo $rtnbillno[$i]['verify_no']?>
					</td>
					<td align="center">
						<?php $bn=$rtnbillno[$i]['bn'];
						
							$sqlcpno="SELECT cp_unit FROM bank_bill_recv WHERE bill_no='$bn'";
							$rtncpno=$this->bm->dataSelectDb1($sqlcpno);
						echo	$cpunit=$rtncpno[0]['cp_unit'];
							?>
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
						<?php echo $rtnbillno[$i]['total_port']?>
					</td>
					<td align="center">
						<?php echo $rtnbillno[$i]['total_mlwf']?>
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
						<form action="<?php echo site_url('ShedBillController/getShedBillPdf');?>" method="POST" target="_blank">
							<!--input type="hidden" name="rcvstat" value="<?php echo $rcvstat;?>">
							<input type="hidden" name="cpnoview" value="<?php echo $cpnoview;?>">
							<input type="hidden" name="cpbankcode" value="<?php echo $cpbankcode;?>">
							<input type="hidden" name="shedbill" value="<?php echo $rtnbillno[$i]['bill_no'];?>"-->
							<input type="hidden" name="sendVerifyNo" value="<?php echo $rtnbillno[$i]['verify_no'];?>">
							<input type="submit" value="View Bill" name="viewbill" class="login_button">
						</form> 
					</td>
					<!--condition for delete put here-->
					<?php
					$_SESSION['Control_Panel']=$this->session->userdata('Control_Panel');
					if($_SESSION['Control_Panel']==13)
					{
					?>
					<td align="center">
						<?php
							$rcvstat = 0;
							$vrfno = $rtnbillno[$i]['verify_no'];
							$billrcvstat = "SELECT bill_rcv_stat FROM shed_bill_master WHERE verify_no='$vrfno'";
							
							$res = mysql_query($billrcvstat);
							$rowVal = mysql_fetch_object($res);
							$rcvstat=$rowVal->bill_rcv_stat;
							//echo $rcvstat;
							if($rcvstat==1)
								$val="Received";
							else
								$val="Receive";
						?>
						<form action="<?php echo site_url('ShedBillController/shedreceive');?>" method="POST">
							<input type="hidden" name="verifyno" value="<?php echo $rtnbillno[$i]['verify_no'];?>">
							<input type="hidden" name="shedbill" value="<?php echo $rtnbillno[$i]['bn'];?>">
							<!--input type="submit" name="receive" value="Receive" <?php if($rcvstat==1){ ?> disabled="true" style="color:black"<?php } ?> class="login_button"-->
							<input type="submit" name="receive" value="<?php echo $val;?>" class="login_button" <?php if($rcvstat==1) { ?> disabled="true" style="color:black" <?php } ?>>
						</form> 
					</td>
					<?php
					}
					else if($_SESSION['Control_Panel']==62)
					{
					?>				
						<td>
							<form action="<?php echo site_url('ShedBillController/billDeletePerform');?>" method="post">
								<input type="hidden" name="vrfno" value="<?php echo $rtnbillno[$i]['verify_no'];?>" />
								<input type="hidden" name="sdbillno" value="<?php echo $rtnbillno[$i]['bn'];?>" />
								<input type="submit" name="delete" value="Delete" class="login_button" />
							</form>
						</td>
					<?php
					}
					?>
				</tr>
			 <?php
			}
		   ?>
		</table>
	</div>
       
	</div>
      <div class="sidebar">
    <?php include_once("mySideBar.php"); ?>
   </div>
      <div class="clr"></div>
    </div>
 <?php echo form_close()?>
  </div>