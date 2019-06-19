<script type="text/javascript">
	function chk_rotation()
	{
		if( document.search_bill.rotation.value == "")
		{
			alert( "Please provide rotation!" );
			document.search_bill.rotation.focus() ;
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
				<!--div class="img" width="600px" style="overflow:auto"-->
				<div class="img1" style="overflow:auto">
					<table>
						<tr>
							<td>
								<form name="search_bill" id="search_bill" onsubmit="return(chk_rotation());" action="<?php echo site_url("report/searchBill");?>" method="post">
									<table align="center" style="border:solid 1px #ccc;" width="400px" cellspacing="0" cellpadding="0">
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td align="right"><label>Rotation</label></td>
											<td>:</td>
											<td>
												<input type="text" style="width:130px;" id="rotation" name="rotation" />
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td align="center" colspan="3">
												<input type="submit" value="Search" class="login_button"/>      
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
									</table>
								</form>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>
								<!--div style="height:500px;overflow:auto;"-->
								<table width="100%">
									<tr class="gridDark">
										<th>Sl</th>
										<th>Bill Number</th>
										<th>Rotation</th>
										<th>Vessel Name</th>
										<th>Bill Name</th>
										<th>Arrival</th>
										<th>Departure</th>
										<!--th class="gridDark">Berth</th-->
										<th>Agent Code</th>
										<!--th class="gridDark">Agent Name</th-->
										<th>Flag</th>
										<!--th class="gridDark">Action</th-->
									</tr>
									<?php
									$j=$start;
									for($i=0;$i<count($rslt_bill_list);$i++)
									{
										$j++;
									?>
									<tr <?php if($i%2==0){ ?> bgcolor="#58D3F7"<?php } else {?>  bgcolor="#F6E3CE" <?php } ?> bgcolor="#">
										<td width="20px"  align="center">
											<?php echo $j; ?>
										</td>
										<td align="center">
											<?php echo $rslt_bill_list[$i]['finalNumber']; ?>
										</td>
										<td align="center">
											<?php echo $rslt_bill_list[$i]['rotation']; ?>
										</td>
										<td align="center">
											<?php echo $rslt_bill_list[$i]['vsl_name']; ?>
										</td>
										<td align="center">
										<a href="<?php echo site_url('report/viewBill/'.$rslt_bill_list[$i]['draftNumber'].'/'.$rslt_bill_list[$i]['cnt_code'].'/'.$rslt_bill_list[$i]['bill_type']) ?>" style="padding:4px;" target="_blank"><?php echo $rslt_bill_list[$i]['bill_name']; ?></a>
										</td>
										<td  align="center">
											<?php echo $rslt_bill_list[$i]['ata']; ?>
										</td>
										<td align="center">
											<?php echo $rslt_bill_list[$i]['atd']; ?>
										</td>
										<!--td class="gridLight" align="center">
											<?php echo $rslt_bill_list[$i]['berth']; ?>
										</td-->
										<td align="center">
											<?php echo $rslt_bill_list[$i]['agent_code']; ?>
										</td>
										<!--td class="gridLight" align="center">
											<?php echo $rslt_bill_list[$i]['agent_name']; ?>
										</td-->
										<td  align="center">
											<?php echo $rslt_bill_list[$i]['flag']; ?>
										</td>
										<!--td class="gridLight" align="center">
											<form name="view_bill" id="view_bill" action="<?php echo site_url("report/viewBill"); ?>" method="post" target="_blank">
												<input name="draftNumber" id="draftNumber" type="hidden" value="<?php echo $rslt_bill_list[$i]['draftNumber']; ?>" />
												<input name="cnt_code" id="cnt_code" type="text" value="<?php echo $rslt_bill_list[$i]['cnt_code']; ?>" />
												<input name="bill_type" id="bill_type" type="text" value="<?php echo $rslt_bill_list[$i]['bill_type']; ?>" />
												<input name="view" id="view" type="submit" value="View" class="login_button" />
											</form>
										</td-->
									</tr>
									<?php
									}
									?>
									<tr>
										<td colspan="13" align="center"><p><?php echo $links; ?></p></td>
									</tr>
								</table>
								<!--/div-->
							</td>
						</tr>
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
	