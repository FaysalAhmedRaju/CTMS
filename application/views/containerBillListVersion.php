<script type="text/javascript">
	function chk_rotation()
	{
		if( document.search_bill.search_by.value == "")
		{
			alert( "Please provide Search By option!" );
			document.search_bill.search_by.focus() ;
			return false;
		}
		else if( document.search_bill.search_by.value == "bill_type" && document.search_bill.bill_type.value == "")
		{
			alert( "Please provide Bill Type!" );
			document.search_bill.bill_type.focus() ;
			return false;
		}
		else if( document.search_bill.search_by.value == "draft_no" && document.search_bill.draft_no.value == "")
		{
			alert( "Please provide Draft No!" );
			document.search_bill.bill_type.focus() ;
			return false;
		}
		else if( document.search_bill.search_by.value == "imp_rotation_no" && document.search_bill.rotation_no.value == "")
		{
			alert( "Please provide Import Rotation No!" );
			document.search_bill.bill_type.focus() ;
			return false;
		}
		else if( document.search_bill.search_by.value == "exp_rotation_no" && document.search_bill.rotation_no.value == "")
		{
			alert( "Please provide Export Rotation No!" );
			document.search_bill.bill_type.focus() ;
			return false;
		}
		
		return true ;
	}
	
	function search_type(type)
	{
		if( document.search_bill.search_by.value == "" )
		{
			alert( "Please provide search type!" );
			document.myForm.date.focus() ;
			return false;
		}
		else
		{	
			if(type=="bill_type")
			{
				bill_type.disabled=false;
				draft_no.disabled=true;
				rotation_no.disabled=true;
				
				document.search_bill.draft_no.value="";
				document.search_bill.rotation_no.value="";
			}
			else if(type=="draft_no")
			{
				bill_type.disabled=true;
				draft_no.disabled=false;
				rotation_no.disabled=true;
				
				document.search_bill.bill_type.value="";
				document.search_bill.rotation_no.value="";
			}
			else if(type=="imp_rotation_no" || type=="exp_rotation_no")
			{
				bill_type.disabled=true;
				draft_no.disabled=true;
				rotation_no.disabled=false;
				
				document.search_bill.bill_type.value="";
				document.search_bill.draft_no.value="";
			}
		}
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
								<form name="search_bill" id="search_bill" onsubmit="return(chk_rotation());" action="<?php echo site_url("bill/searchBillofContainerVersion");?>" method="post">
									<table align="center" style="border:solid 1px #ccc;" width="400px" cellspacing="0" cellpadding="0">
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td align="right"><label>Search By</label></td>
											<td>:</td>
											<td>
												<select name="search_by" id="search_by" onchange="search_type(this.value);">
													<option value="">--Select--</option>
													<option value="bill_type">Bill Type</option>
													<option value="draft_no">Draft No</option>
													<option value="imp_rotation_no">Rotation No (Import)</option>
													<option value="exp_rotation_no">Rotation No (Export)</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td align="right"><label>Bill Type</label></td>
											<td>:</td>
											<td>
												<select name="bill_type" id="bill_type" onchange="search_type(this.value);" disabled>
													<option value="">--Select--</option>
													<option value="ICD BILL">ICD BILL</option>
													<option value="CONTAINER LOADING">CONTAINER LOADING</option>
													<option value="STATUS CHANGE INVOICE (CPA TO PCT)">STATUS CHANGE INVOICE (CPA TO PCT)</option>
													<option value="REEFER CHARGE ON CONTAINER">REEFER CHARGE ON CONTAINER</option>
													<option value="PCT CONT LOAD">PCT CONT LOAD</option>
													<option value="CONTAINER DISCHARGE">CONTAINER DISCHARGE</option>
													<option value="PCT CONT DISCHARGE">PCT CONT DISCHARGE</option>
												</select>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td align="right"><label>Draft No</label></td>
											<td>:</td>
											<td>
												<input name="draft_no" id="draft_no" type="text" disabled />
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td align="right"><label>Rotation No</label></td>
											<td>:</td>
											<td>
												<input name="rotation_no" id="rotation_no" type="text" disabled />
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td align="center" colspan="3">
												<input type="submit" value="Search" class="login_button" />      
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
										<th>Draft No</th>
										<th>MLO</th>
										<th>Imprt. Rot</th>
										<th>Exp. Rot</th>
										<th>Bill Type</th>
										<th>Version</th>
										<th>Modification Type</th>
										<th>View Bill</th>
										<th>View Detail</th>
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
											<?php echo $rslt_bill_list[$i]['draft_id']; ?>
										</td>
										<td align="center">
											<?php echo $rslt_bill_list[$i]['mlo_code']; ?>
										</td>
										<td align="center">
											<?php echo $rslt_bill_list[$i]['imp_rot']; ?>
										</td>
										<td align="center">
										<?php echo $rslt_bill_list[$i]['exp_rot']; ?>				
										</td>
										<td  align="center">
											<?php echo $rslt_bill_list[$i]['billtype']; ?>
										</td>
										<td align="center">
											<?php echo $rslt_bill_list[$i]['version']; ?>
										</td>
										<td align="center">
											<?php echo $rslt_bill_list[$i]['modification_type']; ?>
										</td>
										<td class="gridLight" align="center">
											<form name="view_bill" id="view_bill" action="<?php echo site_url("bill/viewContainerBillVersion"); ?>" method="post" target="_blank">
												<input type="hidden" name="draftNumber" id="draftNumber" value="<?php echo $rslt_bill_list[$i]['draft_id']; ?>" />
												<input type="hidden" name="draft_view" id="draft_view" value="<?php echo $rslt_bill_list[$i]['pdf_draft_view_name']; ?>" />
												<input type="hidden" name="version" id="version" value="<?php echo $rslt_bill_list[$i]['version']; ?>" />
												<input name="view_container_bill" id="view_container_bill" value="View Bill" type="submit" class="login_button" />
											</form>
										</td>
										<td class="gridLight" align="center">
											<form name="view_detail" id="view_detail" action="<?php echo site_url("bill/viewContainerDetailVersion"); ?>" method="post" target="_blank">
												<input name="draft_detail_view" id="draft_detail_view" type="hidden" value="<?php echo $rslt_bill_list[$i]['pdf_draft_view_name']; ?>" />
												<input name="draftNumberDetail" id="draftNumberDetail" type="hidden" value="<?php echo $rslt_bill_list[$i]['draft_id']; ?>" />
												<input name="version" id="version" type="hidden" value="<?php echo $rslt_bill_list[$i]['version']; ?>" />
												<input name="view_container_detail" id="view_container_detail" value="View Detail"type="submit" class="login_button"/>
											</form>
										</td>
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
	