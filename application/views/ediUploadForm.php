<script type="text/javascript">
function validate()
{
	if(document.myform.rotation.value == "")
	{
		alert( "Please provide rotation!" );
		document.myform.rotation.focus() ;
		return false;
	}
	
	if(document.myform.imp_voyage.value == "")
	{
		alert( "Please provide IMP Voyage!" );
		document.myform.imp_voyage.focus() ;
		return false;
	}
	
	if(document.myform.exp_voyage.value == "")
	{
		alert( "Please provide EXP Voyage!" );
		document.myform.exp_voyage.focus() ;
		return false;
	}
	
	if(document.myform.grt.value == "")
	{
		alert( "Please provide GRT!" );
		document.myform.grt.focus() ;
		return false;
	}
	
	if(document.myform.nrt.value == "")
	{
		alert( "Please provide NRT!" );
		document.myform.nrt.focus() ;
		return false;
	}
	
	if(document.myform.imo_no.value == "")
	{
		alert( "Please provide IMO No.!" );
		document.myform.imo_no.focus() ;
		return false;
	}
	
	if(document.myform.loa.value == "")
	{
		alert( "Please provide LOA!" );
		document.myform.loa.focus() ;
		return false;
	}
	
	if(document.myform.flag.value == "")
	{
		alert( "Please provide Flag!" );
		document.myform.flag.focus() ;
		return false;
	}
	
	if(document.myform.call_sign.value == "")
	{
		alert( "Please provide Call Sign!" );
		document.myform.call_sign.focus() ;
		return false;
	}
	
	/*if(document.myform.beam.value == "")
	{
		alert( "Please provide Beam!" );
		document.myform.beam.focus() ;
		return false;
	}*/
	
	if(document.myform.edi.value == "")
	{
		alert( "Please provide EDI file!" );
		document.myform.edi.focus() ;
		return false;
	}
	else
	{
		var file_name=document.myform.edi.value;
	
		var ext=file_name.split('.').pop();
	
		if(ext.toUpperCase()!="EDI")
		{
			alert("File extension should be .edi");
			return false;
		}		
	}
	
	/*if(document.myform.excel.value == "")
	{
		alert( "Please provide Stow file!" );
		document.myform.excel.focus() ;
		return false;
	}*/
	
	return true ;
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
					<table style="border:solid 1px #ccc; background:#ddf3f5" width="500px" align="center" cellspacing="0" cellpadding="0">
						<tr>
							<td>	 
								<table align="center" border ="0" style="background:#ddf3f5">	
									<tr>
										<td colspan="3" align="center"><font color="blue" size="2"><b><?php echo $msg; ?><br></b> </font></td>
									</tr>
									<form name="myform" id="myform" action="<?php echo site_url('uploadExcel/ediUploadPerform');?>" method="POST" enctype="multipart/form-data" onsubmit="return validate();">
										<?php
										include_once("mydbPConnection.php");
										$str_info="SELECT Import_Rotation_No,Voy_No,VoyNoExp,grt,nrt,imo,loa_cm,flag,radio_call_sign,beam_cm 
										FROM igm_masters WHERE id='$id'";
										
										$rslt_info=mysql_query($str_info);
										$row=mysql_fetch_object($rslt_info);
										?>
										<tr>
											<td><font color='red'><b>*</b></font>Rotation</td>
											<td>:</td>
											<td>
												<input type="text" name="rotation" id="rotation" style="width:150px;" value="<?php echo $row->Import_Rotation_No;?>"  />
											</td>
										</tr>
										<tr>
											<td><font color='red'><b>*</b></font>IMP Voyage</td>
											<td>:</td>
											<td>
												<input type="text" name="imp_voyage" id="imp_voyage" style="width:150px;" value="<?php echo $row->Voy_No;?>"  />
											</td>
										</tr>
										<tr>
											<td><font color='red'><b>*</b></font>EXP Voyage</td>
											<td>:</td>
											<td>
												<input type="text" name="exp_voyage" id="exp_voyage" style="width:150px;" value="<?php echo $row->VoyNoExp;?>"  />
											</td>
										</tr>
										<tr>
											<td><font color='red'><b>*</b></font>GRT</td>
											<td>:</td>
											<td>
												<input type="text" name="grt" id="grt" style="width:150px;" value="<?php echo $row->grt;?>"  />
											</td>
										</tr>
										<tr>
											<td><font color='red'><b>*</b></font>NRT</td>
											<td>:</td>
											<td>
												<input type="text" name="nrt" id="nrt" style="width:150px;" value="<?php echo $row->nrt;?>"  />
											</td>
										</tr>
										<tr>
											<td><font color='red'><b>*</b></font>IMO No.</td>
											<td>:</td>
											<td>
												<input type="text" name="imo_no" id="imo_no" style="width:150px;" value="<?php echo $row->imo;?>"  />
											</td>
										</tr>
										<tr>
											<td><font color='red'><b>*</b></font>LOA</td>
											<td>:</td>
											<td>
												<input type="text" name="loa" id="loa" style="width:150px;" value="<?php echo $row->loa_cm;?>"  />
											</td>
										</tr>
										<tr>
											<td><font color='red'><b>*</b></font>Flag</td>
											<td>:</td>
											<td>
												<input type="text" name="flag" id="flag" style="width:150px;" value="<?php echo $row->flag;?>"  />
											</td>
										</tr>
										<tr>
											<td><font color='red'><b>*</b></font>Call Sign</td>
											<td>:</td>
											<td>
												<input type="text" name="call_sign" id="call_sign" style="width:150px;" value="<?php echo $row->radio_call_sign;?>"  />
											</td>
										</tr>
										<tr>
											<td>Beam</td>
											<td>:</td>
											<td >
												<input type="text" name="beam" id="beam" style="width:150px;" value="<?php echo $row->beam_cm;?>"  />
											</td>
										</tr>
										<tr>
											<td><font color='red'><b>*</b></font>Browse EDI File</td>
											<td>:</td>
											<td>
												<input type="file" name="edi" id="edi" style="width:150px; background:white" value="<?php echo $row->Voy_No;?>"  />
											</td>
										</tr>
										<tr>
											<td>Browse Stow File</td>
											<td>:</td>
											<td>
												<input type="file" name="excel" id="excel" style="width:150px; background:white" value="<?php echo $row->Voy_No;?>"  />
											</td>
										</tr>
										<tr>
											<td colspan="3" align="center">
												<input type="submit" class="login_button" name="submit" value="Upload"/>
											</td>
										</tr>
									</form>
								</table>
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