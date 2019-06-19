
<script type="text/javascript">
    function validate()
	{
		if(document.stuffingContainerMloSearchForm.search_by.value == "cont_no")
		{
			if(document.stuffingContainerMloSearchForm.cont_no.value == "")
			{
				alert( "Please provide a container no!" );
				document.stuffingContainerMloSearchForm.cont_no.focus() ;
				return false;
			}
			if(document.stuffingContainerMloSearchForm.stuffing_date_mlo.value == "")
			{
				alert( "Please provide stuffing date!" );
				document.stuffingContainerMloSearchForm.stuffing_date_mlo.focus() ;
				return false;
			}
		}
		
		else if(document.stuffingContainerMloSearchForm.search_by.value == "offdock")
		{
			if(document.stuffingContainerMloSearchForm.offdock.value == "")
			{
				alert( "Please provide an offdock!" );
				document.stuffingContainerMloSearchForm.offdock.focus() ;
				return false;
			}
			if(document.stuffingContainerMloSearchForm.stuffing_date_mlo.value == "")
			{
				alert( "Please provide stuffing date!" );
				document.stuffingContainerMloSearchForm.stuffing_date_mlo.focus() ;
				return false;
			}
		}
	}
	
	function search_criteria(search_by)
	{
//		alert("ok");
		if(document.stuffingContainerMloSearchForm.search_by.value == "")
		{
			alert( "Please provide a value!" );
			document.stuffingContainerMloSearchForm.search_by.focus() ;
			return false;
		}
		else
		{
			if(search_by == "cont_no")
			{
				stuffing_date_mlo.disabled=false;
				cont_no.disabled=false;
				offdock.disabled=true;
				document.stuffingContainerMloSearchForm.offdock.value="";
				document.stuffingContainerMloSearchForm.stuffing_date_mlo.value="";
			}
			else if(search_by == "offdock")
			{
				stuffing_date_mlo.disabled=false;
				cont_no.disabled=true;
				offdock.disabled=false;
				document.stuffingContainerMloSearchForm.offdock.value="";
				document.stuffingContainerMloSearchForm.stuffing_date_mlo.value="";
			}
		}
	}
</script> 
 <?php 
 $org_Type_id = $this->session->userdata('org_Type_id');
 $login_id = $this->session->userdata('login_id');

 ?>
<div class="content">
    <div class="content_resize">
		<div class="mainbar">
			<div class="article">
				<h2><span><?php echo $title; ?></span> </h2>
				<p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
				<div class="clr"></div>
				<div class="img">
					<form name= "stuffingContainerMloSearchForm" id="stuffingContainerMloSearchForm" onsubmit="return(validate());" action="<?php echo site_url("report/stuffingContainerListPerform");?>" target="_blank" method="post">
						<input type="hidden" id="login_id_mlo" name="login_id_mlo" value="<?php echo $login_id; ?>" />
						<table border="0" align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
						<?php if($org_Type_id==57) { ?>
								<tr>
								<td align="right"><label><nobr>&nbsp;&nbsp;&nbsp;MLO&nbsp;&nbsp;&nbsp;</nobr></label></td>
								<td>:&nbsp;&nbsp;&nbsp;</td>
								<td>
									<select name="ship_mlo" id="ship_mlo" width="150px">
										<option value="ALL">--Select--</option>
									<?php
									include("mydbPConnectionn4.php");
									$sql_mlo_list="SELECT r.id FROM sparcsn4.ref_bizunit_scoped r       
														LEFT JOIN ( sparcsn4.ref_agent_representation X       
														LEFT JOIN sparcsn4.ref_bizunit_scoped Y ON X.agent_gkey=Y.gkey )  ON r.gkey=X.bzu_gkey 
														WHERE Y.id = '$login_id'";
									$rslt_mlo_list=mysql_query($sql_mlo_list,$con_sparcsn4);
									while($mlo_list=mysql_fetch_object($rslt_mlo_list))
									{
									?>
										<option value="<?php echo $mlo_list->id; ?>"><?php echo $mlo_list->id; ?></option>
									<?php
									}
									?>
									</select>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						<?php } ?>
							<tr>
								<td align="right"><label><nobr>&nbsp;&nbsp;&nbsp;Search By&nbsp;&nbsp;&nbsp;</nobr></label></td>
								<td>:</td>
								<td> 
									<select name="search_by" id="search_by" width="150px" onchange="search_criteria(this.value);" >
										<option value="">--Select--</option>
										<option value="offdock">Offdock</option>
										<option value="cont_no">Container</option>
										<!--option value="stuffing_date">Stuffing Date</option-->
									</select>
								</td>	
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="right"><label><nobr>&nbsp;&nbsp;&nbsp;Offdock&nbsp;&nbsp;&nbsp;</nobr></label></td>
								<td>:&nbsp;&nbsp;&nbsp;</td>
								<td>
									<select name="offdock" id="offdock" width="150px" disabled >
										<option value="ALL">--Select--</option>
									<?php
									include("mydbPConnectionn4.php");
									$sql_offdock_list="select code,name from ctmsmis.offdoc";
									$rslt_offdock_list=mysql_query($sql_offdock_list,$con_sparcsn4);
									while($offdock_list=mysql_fetch_object($rslt_offdock_list))
									{
									?>
										<option value="<?php echo $offdock_list->code; ?>"><?php echo $offdock_list->name; ?></option>
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
								<td align="right"><label><nobr>&nbsp;&nbsp;&nbsp;Container&nbsp;&nbsp;&nbsp;</nobr></label></td>
								<td>:&nbsp;&nbsp;&nbsp;</td>
								<td> 
									<input type="text" style="width:150px;" id="cont_no" name="cont_no" disabled />
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="right"><label><nobr>&nbsp;&nbsp;&nbsp;Stuffing Date&nbsp;&nbsp;&nbsp;</nobr></label></td>
								<td>:&nbsp;&nbsp;&nbsp;</td>
								<td>
									<input type="text" style="width:150px;" id="stuffing_date_mlo" name="stuffing_date_mlo" value="<?php date("Y-m-d"); ?>"  />
								</td>
								<script>
									$(function() {
										$( "#stuffing_date_mlo" ).datepicker({
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
									<table>
										<tr>
											<td align="left">
												<label for="PDF" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">PDF</label>
												<?php 	
												$data = array(
													'name'        => 'option',
													'id'          => 'option',
													'value'       => 'pdf',
													'checked'     => false,
													'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
													);
												echo form_radio($data); ?>
											</td>
											<td align="left">
												<label for="html" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">HTML</label>
													<?php 	
													$data = array(
													'name'        => 'option',
													'id'          => 'option',
													'value'       => 'html',
													'checked'     => true,
													'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
													);
												echo form_radio($data); ?>
											</td>
										</tr>
									</table>
								</td>
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