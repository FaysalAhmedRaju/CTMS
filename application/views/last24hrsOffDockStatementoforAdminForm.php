<script type="text/javascript">
    function validate()
	{
		if(document.stuffingContainerSearchForm.search_by.value == "cont_no")
		{
			if(document.stuffingContainerSearchForm.cont_no.value == "")
			{
				alert( "Please provide a container no!" );
				document.stuffingContainerSearchForm.cont_no.focus() ;
				return false;
			}
			if(document.stuffingContainerSearchForm.stuffing_date.value == "")
			{
				alert( "Please provide stuffing date!" );
				document.stuffingContainerSearchForm.stuffing_date.focus() ;
				return false;
			}
		}
		
		else if(document.stuffingContainerSearchForm.search_by.value == "offdock")
		{
			if(document.stuffingContainerSearchForm.offdock.value == "")
			{
				alert( "Please provide an offdock!" );
				document.stuffingContainerSearchForm.offdock.focus() ;
				return false;
			}
			if(document.stuffingContainerSearchForm.stuffing_date.value == "")
			{
				alert( "Please provide stuffing date!" );
				document.stuffingContainerSearchForm.stuffing_date.focus() ;
				return false;
			}
		}
	}
	
	
</script> 
 
<div class="content">
    <div class="content_resize">
		<div class="mainbar">
			<div class="article">
				<h2><span><?php echo $title; ?></span> </h2>
				<p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
				<div class="clr"></div>
				<div class="img">
					<form name= "stuffingContainerSearchForm" id="stuffingContainerSearchForm" onsubmit="return(validate());" action="<?php echo site_url("report/last24hrsOffDockStatementList");?>" target="_blank" method="post">
						<table border="0" align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td>&nbsp;</td>
							</tr>
							
							<tr>
								<td align="right"><label><nobr>&nbsp;&nbsp;&nbsp;Offdock&nbsp;&nbsp;&nbsp;</nobr></label></td>
								<td>:&nbsp;&nbsp;&nbsp;</td>
								<td>
									<select name="offdock" id="offdock" width="150px" >
										<option value="">--Select--</option>
									<?php
									include("mydbPConnection.php");
									$sql_offdock_list="SELECT * FROM users WHERE org_Type_id=6 and id NOT BETWEEN 2637 and 3526";
									$rslt_offdock_list=mysql_query($sql_offdock_list);
									while($offdock_list=mysql_fetch_object($rslt_offdock_list))
									{
									?>
										<option value="<?php echo $offdock_list->login_id; ?>"><?php echo $offdock_list->u_name; ?></option>
									<?php
									}
									?>
									</select>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="right"><label><nobr>&nbsp;&nbsp;&nbsp;Statement Date&nbsp;&nbsp;&nbsp;</nobr></label></td>
								<td>:&nbsp;&nbsp;&nbsp;</td>
								<td>
									<input type="text" style="width:150px;" id="stuffing_date" name="stuffing_date" value="<?php date("Y-m-d"); ?>" />
								</td>
								<script>
									$(function() {
										$( "#stuffing_date" ).datepicker({
											changeMonth: true,
											changeYear: true,
											dateFormat: 'yy-mm-dd', // iso format
										});
									});
								</script>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>

							<tr>
								<td colspan="3" align="center">
									<input type="submit" value="Search" class="login_button"/>      
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</form>
					
				<?php if($flag==1){ ?>	
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
								  
								  
								  <td align="center">
									<form action="<?php echo site_url('uploadExcel/last24hrsOffDocStatementPdf');?>" target="_blank" method="POST">

										<input type="hidden" name="akey2" id="akey2" value="<?php echo $offDock[$i]['akey'];?>">							
										<input type="hidden" name="offdockName" id="offdockName" value="<?php echo $offDock[$i]['update_by'];?>">							
										<input type="submit" title="Print" value="Print"  class="login_button" style="width:100%;">							
									</form> 
								  </td> 
						  
							</tr>
				<?php } } ?>				
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
	<?php// echo form_close()?>
</div>