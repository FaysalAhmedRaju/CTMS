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
	
	function search_criteria(search_by)
	{
//		alert("ok");
		if(document.stuffingContainerSearchForm.search_by.value == "")
		{
			alert( "Please provide a value!" );
			document.stuffingContainerSearchForm.search_by.focus() ;
			return false;
		}
		else
		{
			if(search_by == "cont_no")
			{
				stuffing_date.disabled=false;
				cont_no.disabled=false;
				offdock.disabled=true;
				document.stuffingContainerSearchForm.offdock.value="";
				document.stuffingContainerSearchForm.stuffing_date.value="";
			}
			else if(search_by == "offdock")
			{
				stuffing_date.disabled=false;
				cont_no.disabled=true;
				offdock.disabled=false;
				document.stuffingContainerSearchForm.offdock.value="";
				document.stuffingContainerSearchForm.stuffing_date.value="";
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
					<form name= "stuffingContainerSearchForm" id="stuffingContainerSearchForm" onsubmit="return(validate());" action="<?php echo site_url("report/stuffingContainerListPerform");?>" target="_blank" method="post">
						<table border="0" align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td>&nbsp;</td>
							</tr>
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
										<option value="">--Select--</option>
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
									<input type="text" style="width:150px;" id="stuffing_date" name="stuffing_date" value="<?php date("Y-m-d"); ?>" disabled />
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