<?php
/*****************************************************
Developed BY: Nisho
Software Engineer
DataSoft Systems Bangladesh Ltd
******************************************************/
$logid=$_SESSION['login_id'];
$this->TM=$type;
$this->CODE=$CODE;
$this->SubCODE=$SubCODE;
$_SESSION['Control_Panel']=$this->session->userdata('Control_Panel');
$_SESSION['org_id']=$this->session->userdata('org_id');
include("mydbPConnection.php");

//echo $this->SubCODE;
?>
<script type="text/javascript">
	function validate_required(field,alerttxt)
	{
		with (field)
		{
			if (value==null||value=="")
			{alert(alerttxt);return false;}
			else {return true}
		}
	}
	function validate_form(thisform)
	{
		with (thisform)
		{
			
			if (validate_required(txt_str_Search,"Please Type Your Text to Search")==false)
				{return false;}
			
				
				
		}
	}
</script>
<table border="0" width="100%">
	
<table>
<tr>
		<td style="color:darkblue;font-size:16.0px;font-weight:bold">Import Rotation No:<?php print($old_data->Import_Rotation_No);?>&nbsp;&nbsp;VESSEL NAME:<?php print($old_data->Vessel_Name);?></td>
	</tr>
</table>

<table border="1" >
	<tr>

<?php

if(($_SESSION['Control_Panel']==11)||($_SESSION['Control_Panel']==10)||($_SESSION['Control_Panel']==7))
{
	
// Start for FF Only 
?>
	
	<?php
	if($this->SFlag=="1")
	{
	?>				
			<td  id="lbl_org_id12"  class="onlyTable1">			
				<form action="home.php" method="post">
					<input type="hidden" name="myflag" value="379">					
					<input type="hidden" name="txt_CODE" value="<?php print($this->CODE); ?>">
					<input type="hidden" name="txt_MCODE" value="<?php print($this->MCODE); ?>">
					<input type="hidden" name="txt_SubCode" value="<?php print($this->SubCODE); ?>">
					<input type="hidden" name="txt_SSubCODE" value="<?php print($this->SSubCODE); ?>">
					<input type="hidden" name="txt_ImpRot" value="<?php print($this->ImpRot); ?>">
					<input type="hidden" name="txt_MLine" value="<?php print($this->MLine); ?>">
					<input type="hidden" name="txt_MBL" value="<?php print($this->MBL); ?>">
					<input type="hidden" name="txt_MSLine" value="<?php print($this->MSLine); ?>">
					<input type="hidden" name="txt_MSBL" value="<?php print($this->MSBL); ?>">									
					<input type="hidden" name="txt_TM" value="<?php print($this->TM); ?>">
					<input type="hidden" name="txt_SFlag" value="<?php print($this->SFlag); ?>">	
					
			Search&nbsp;By&nbsp;FF:		
					<select name="txt_Org_Id_for_search"  maxlength="50" onFocus="gsLabelObj(lbl_org_id12,'#61BCEF','white')" onBlur="gsLabelObj(lbl_org_id12,'','')">
						<?php
							$resultcombo = mysql_query("SELECT id,Organization_Name  FROM organization_profiles where Org_Type_id=4 ORDER BY Organization_Name");
							while ($rowcombo = mysql_fetch_object($resultcombo)){
						?>
						<option value="<?php print($rowcombo->id);?>" <?php if($myedit=="yes") { if($rowcombo->id==$rowcombo->id) print('selected'); } ?> ><?php print($rowcombo->Organization_Name);?></option>
						<?php	
						}	
						?>
					</select>			
					<select name="lbl_type_search">
								<option value="1">Consignee</option>
								<option value="2">Notify</option>							
					</select>			
					<input type="submit" name="btn_serch" value="GO!">	
				</form>
			</td>

	<?php
	}
	else
	{
	?>	
			<td  id="lbl_org_id12"  class="onlyTable1">
					<form action="home.php" method="post">
					<input type="hidden" name="myflag" value="378">					
					<input type="hidden" name="txt_CODE" value="<?php print($this->CODE); ?>">
					<input type="hidden" name="txt_SubCode" value="<?php print($this->SubCODE); ?>">
					<input type="hidden" name="txt_ImpRot" value="<?php print($this->ImpRot); ?>">
					<input type="hidden" name="txt_MLine" value="<?php print($this->MLine); ?>">
					<input type="hidden" name="txt_MBL" value="<?php print($this->MBL); ?>">
					<input type="hidden" name="txt_TM" value="<?php print($this->TM); ?>">	
			Search&nbsp;By&nbsp;FF:		
						<select name="txt_Org_Id_for_search"  maxlength="50" onFocus="gsLabelObj(lbl_org_id12,'#61BCEF','white')" onBlur="gsLabelObj(lbl_org_id12,'','')">
							<?php
								$resultcombo = mysql_query("SELECT id,Organization_Name  FROM organization_profiles where Org_Type_id=4 ORDER BY Organization_Name");
								while ($rowcombo = mysql_fetch_object($resultcombo)){
							?>
							<option value="<?php print($rowcombo->id);?>" <?php if($myedit=="yes") { if($rowcombo->id==$rowcombo->id) print('selected'); } ?> ><?php print($rowcombo->Organization_Name);?></option>
							<?php
							}	
							?>
						</select>			
						<select name="lbl_type_search">
									<option value="1">Consignee</option>
									<option value="2">Notify</option>							
						</select>			
					<input type="submit" name="btn_serch" value="GO!">		
				</form>
			</td>
	
	<?php
	}
	?>		

<?php
// end for FF Only 
}
?>


<?php
if(($_SESSION['Control_Panel']==6)||($_SESSION['Control_Panel']==10)||($_SESSION['Control_Panel']==7))
{
// Start for CNF Only 
?>
	
<?php
if($this->SFlag=="1")
{
?>		
			<td  id="lbl_org_id12"  class="onlyTable1">			
				<form action="home.php" method="post">
					<input type="hidden" name="myflag" value="381">					
					<input type="hidden" name="txt_CODE" value="<?php print($this->CODE); ?>">
					<input type="hidden" name="txt_MCODE" value="<?php print($this->MCODE); ?>">
					<input type="hidden" name="txt_SubCode" value="<?php print($this->SubCODE); ?>">
					<input type="hidden" name="txt_SSubCODE" value="<?php print($this->SSubCODE); ?>">
					<input type="hidden" name="txt_ImpRot" value="<?php print($this->ImpRot); ?>">
					<input type="hidden" name="txt_MLine" value="<?php print($this->MLine); ?>">
					<input type="hidden" name="txt_MBL" value="<?php print($this->MBL); ?>">
					<input type="hidden" name="txt_MSLine" value="<?php print($this->MSLine); ?>">
					<input type="hidden" name="txt_MSBL" value="<?php print($this->MSBL); ?>">									
					<input type="hidden" name="txt_TM" value="<?php print($this->TM); ?>">
					<input type="hidden" name="txt_SFlag" value="<?php print($this->SFlag); ?>">	
					
			Search By:&nbsp;			
						<select name="txt_Org_Id_for_search"  maxlength="50" onFocus="gsLabelObj(lbl_org_id12,'#61BCEF','white')" onBlur="gsLabelObj(lbl_org_id12,'','')">
							<?php
								$resultcombo = mysql_query("SELECT id,Organization_Name  FROM organization_profiles where Org_Type_id=2 ORDER BY Organization_Name");
								while ($rowcombo = mysql_fetch_object($resultcombo)){
							?>
							<option value="<?php print($rowcombo->id);?>" <?php if($myedit=="yes") { if($rowcombo->id==$rowcombo->id) print('selected'); } ?> ><?php print($rowcombo->Organization_Name);?></option>
							<?php
							}	
							?>
						</select>	
					<input type="submit" name="btn_serch" value="GO!">	
				</form>
			</td>
	<?php
	}
	else
	{
	?>						
				<td  id="lbl_org_id12"  class="onlyTable1">
					<form action="home.php" method="post">
					<input type="hidden" name="myflag" value="382">					
					<input type="hidden" name="txt_CODE" value="<?php print($this->CODE); ?>">
					<input type="hidden" name="txt_SubCode" value="<?php print($this->SubCODE); ?>">
					<input type="hidden" name="txt_ImpRot" value="<?php print($this->ImpRot); ?>">
					<input type="hidden" name="txt_MLine" value="<?php print($this->MLine); ?>">
					<input type="hidden" name="txt_MBL" value="<?php print($this->MBL); ?>">
					<input type="hidden" name="txt_TM" value="<?php print($this->TM); ?>">	
				Search By:&nbsp;			
					<select name="txt_Org_Id_for_search"  maxlength="50" onFocus="gsLabelObj(lbl_org_id12,'#61BCEF','white')" onBlur="gsLabelObj(lbl_org_id12,'','')">
						<?php
							$resultcombo = mysql_query("SELECT id,Organization_Name  FROM organization_profiles where Org_Type_id=2 ORDER BY Organization_Name");
							while ($rowcombo = mysql_fetch_object($resultcombo)){
						?>
						<option value="<?php print($rowcombo->id);?>" <?php if($myedit=="yes") { if($rowcombo->id==$rowcombo->id) print('selected'); } ?> ><?php print($rowcombo->Organization_Name);?></option>
						<?php	
						}	
						?>
					</select>		
				<input type="submit" name="btn_serch" value="GO!">		
			</form>
		</td>

	<?php
	}
	?>		

<?php
// end for CNF Only 
}
?>

<?php
if(($_SESSION['Control_Panel']==12)||($_SESSION['Control_Panel']==10)||($_SESSION['Control_Panel']==7))
{
// Start for PORT Only 
?>
	
<?php
if($this->SFlag=="1")
{
?>	
				
			<td  id="lbl_org_id12"  class="onlyTable1">			
				<form action="home.php" method="post">
					<input type="hidden" name="myflag" value="385">					
					<input type="hidden" name="txt_CODE" value="<?php print($this->CODE); ?>">
					<input type="hidden" name="txt_MCODE" value="<?php print($this->MCODE); ?>">
					<input type="hidden" name="txt_SubCode" value="<?php print($this->SubCODE); ?>">
					<input type="hidden" name="txt_SSubCODE" value="<?php print($this->SSubCODE); ?>">
					<input type="hidden" name="txt_ImpRot" value="<?php print($this->ImpRot); ?>">
					<input type="hidden" name="txt_MLine" value="<?php print($this->MLine); ?>">
					<input type="hidden" name="txt_MBL" value="<?php print($this->MBL); ?>">
					<input type="hidden" name="txt_MSLine" value="<?php print($this->MSLine); ?>">
					<input type="hidden" name="txt_MSBL" value="<?php print($this->MSBL); ?>">									
					<input type="hidden" name="txt_TM" value="<?php print($this->TM); ?>">
					<input type="hidden" name="txt_SFlag" value="<?php print($this->SFlag); ?>">						
			Search By:&nbsp;								
						<select name="txt_Org_Id_for_search2"  maxlength="50">
							<?php
								$resultcombo2 = mysql_query("SELECT id,Organization_Name  FROM organization_profiles where Org_Type_id=5 ORDER BY Organization_Name");
								while ($rowcombo2 = mysql_fetch_object($resultcombo2)){
							?>
							<option value="<?php print($rowcombo2->id);?>" <?php if($myedit=="yes") { if($rowcombo2->id==$rowcombo2->id) print('selected'); } ?> ><?php print($rowcombo2->Organization_Name);?></option>
							<?php	
							}	
							?>
						</select>&nbsp;&nbsp;						
						<input type="submit" name="btn_serch" value="GO!">		
					</form>
				</td>	
	<?php
	}
	else
	{
	?>						
			<td  id="lbl_org_id12"  class="onlyTable1">
					<!--<form action="home.php" method="post">-->
					<?php
						echo form_open('igmViewController/myListSearchFFByPort');
						$Stylepadding = 'style="padding: 12px 20px;"';
						if(!empty($error_message))
						{
							$Stylepadding = 'style="padding:25px 20px;"';
						}	
						if(isset($captcha_image)){
							$Stylepadding = 'style="padding:62px 20px 93px;"';
						}
					?>
					<input type="hidden" name="myflag" value="386">					
					<input type="hidden" name="txt_CODE" value="<?php print($this->CODE); ?>">
					<input type="hidden" name="txt_SubCode" value="<?php print($this->SubCODE); ?>">
					<input type="hidden" name="txt_ImpRot" value="<?php print($this->ImpRot); ?>">
					<input type="hidden" name="txt_MLine" value="<?php print($this->MLine); ?>">
					<input type="hidden" name="txt_MBL" value="<?php print($this->MBL); ?>">
					<input type="hidden" name="txt_TM" value="<?php print($this->TM); ?>">	
			<b>Search By:&nbsp;	</b>	
						<select name="txt_Org_Id_for_search2"  maxlength="50">
							<?php
								$resultcombo2 = mysql_query("SELECT id,Organization_Name  FROM organization_profiles where (Org_Type_id=6 or id=2591) ORDER BY Organization_Name");
								while ($rowcombo2 = mysql_fetch_object($resultcombo2)){
							?>
							<option value="<?php print($rowcombo2->id);?>" <?php if($myedit=="yes") { if($rowcombo2->id==$rowcombo2->id) print('selected'); } ?> ><?php print($rowcombo2->Organization_Name);?></option>
							<?php	
							}	
							?>
						</select>&nbsp;&nbsp;						
						<!--<input type="submit" name="btn_serch" value="GO!">-->
						<?php $arrt3 = array('name'=>'btn_serch','id'=>'submit3','value'=>'GO!','class'=>'login_button'); echo form_submit($arrt3);?>
					</form>
				</td>
	<?php
	}
	?>		
<?php
// end for PORT Only 
}
?>

<?php
if(($_SESSION['Control_Panel']==13)||($_SESSION['Control_Panel']==10)||($_SESSION['Control_Panel']==7))
{
// Start for OFF-DOCK  Only 
?>
	
	<?php
	if($this->SFlag=="1")
	{
	?>				
			<td  id="lbl_org_id12"  class="onlyTable1">			
				<form action="home.php" method="post">
					<input type="hidden" name="myflag" value="385">					
					<input type="hidden" name="txt_CODE" value="<?php print($this->CODE); ?>">
					<input type="hidden" name="txt_MCODE" value="<?php print($this->MCODE); ?>">
					<input type="hidden" name="txt_SubCode" value="<?php print($this->SubCODE); ?>">
					<input type="hidden" name="txt_SSubCODE" value="<?php print($this->SSubCODE); ?>">
					<input type="hidden" name="txt_ImpRot" value="<?php print($this->ImpRot); ?>">
					<input type="hidden" name="txt_MLine" value="<?php print($this->MLine); ?>">
					<input type="hidden" name="txt_MBL" value="<?php print($this->MBL); ?>">
					<input type="hidden" name="txt_MSLine" value="<?php print($this->MSLine); ?>">
					<input type="hidden" name="txt_MSBL" value="<?php print($this->MSBL); ?>">									
					<input type="hidden" name="txt_TM" value="<?php print($this->TM); ?>">
					<input type="hidden" name="txt_SFlag" value="<?php print($this->SFlag); ?>">						
			Search By:&nbsp;								
						<select name="txt_Org_Id_for_search2"  maxlength="50">
							<?php
								$resultcombo2 = mysql_query("SELECT id,Organization_Name  FROM organization_profiles where Org_Type_id=6 ORDER BY Organization_Name");
								while ($rowcombo2 = mysql_fetch_object($resultcombo2)){
							?>
							<option value="<?php print($rowcombo2->id);?>" <?php if($myedit=="yes") { if($rowcombo2->id==$rowcombo2->id) print('selected'); } ?> ><?php print($rowcombo2->Organization_Name);?></option>
							<?php	
							}	
							?>
						</select>&nbsp;&nbsp;						
						<input type="submit" name="btn_serch" value="GO!">		
				</form>
			</td>	
	<?php
	}
	else
	{
	?>					
			<td  id="lbl_org_id12"  class="onlyTable1">
					<form action="home.php" method="post">
					<input type="hidden" name="myflag" value="386">					
					<input type="hidden" name="txt_CODE" value="<?php print($this->CODE); ?>">
					<input type="hidden" name="txt_SubCode" value="<?php print($this->SubCODE); ?>">
					<input type="hidden" name="txt_ImpRot" value="<?php print($this->ImpRot); ?>">
					<input type="hidden" name="txt_MLine" value="<?php print($this->MLine); ?>">
					<input type="hidden" name="txt_MBL" value="<?php print($this->MBL); ?>">
					<input type="hidden" name="txt_TM" value="<?php print($this->TM); ?>">	
			Search By:&nbsp;			
						<select name="txt_Org_Id_for_search2"  maxlength="50">
							<?php
								$resultcombo2 = mysql_query("SELECT id,Organization_Name  FROM organization_profiles where Org_Type_id=6 ORDER BY Organization_Name");
								while ($rowcombo2 = mysql_fetch_object($resultcombo2)){
							?>
							<option value="<?php print($rowcombo2->id);?>" <?php if($myedit=="yes") { if($rowcombo2->id==$rowcombo2->id) print('selected'); } ?> ><?php print($rowcombo2->Organization_Name);?></option>
							<?php	
							}	
							?>
						</select>&nbsp;&nbsp;					
						<input type="submit" name="btn_serch" value="GO!">		
				</form>
			</td>
	<?php
	}
	?>		
<?php
// end for OFF-DOCK Only 
}
?>

<?php
if(($_SESSION['Control_Panel']==43)||($_SESSION['Control_Panel']==10)||($_SESSION['Control_Panel']==7))
{
// Start for Dhaka-ICD  Only 
?>
	
	<?php
	if($this->SFlag=="1")
	{
	?>	
			<td  id="lbl_org_id12"  class="onlyTable1">			
				<form action="home.php" method="post">
					<input type="hidden" name="myflag" value="385">					
					<input type="hidden" name="txt_CODE" value="<?php print($this->CODE); ?>">
					<input type="hidden" name="txt_MCODE" value="<?php print($this->MCODE); ?>">
					<input type="hidden" name="txt_SubCode" value="<?php print($this->SubCODE); ?>">
					<input type="hidden" name="txt_SSubCODE" value="<?php print($this->SSubCODE); ?>">
					<input type="hidden" name="txt_ImpRot" value="<?php print($this->ImpRot); ?>">
					<input type="hidden" name="txt_MLine" value="<?php print($this->MLine); ?>">
					<input type="hidden" name="txt_MBL" value="<?php print($this->MBL); ?>">
					<input type="hidden" name="txt_MSLine" value="<?php print($this->MSLine); ?>">
					<input type="hidden" name="txt_MSBL" value="<?php print($this->MSBL); ?>">									
					<input type="hidden" name="txt_TM" value="<?php print($this->TM); ?>">
					<input type="hidden" name="txt_SFlag" value="<?php print($this->SFlag); ?>">						
			Search By:&nbsp;								
						<select name="txt_Org_Id_for_search2"  maxlength="50">
								<?php
									$resultcombo2 = mysql_query("SELECT id,Organization_Name  FROM organization_profiles where Org_Type_id=11 ORDER BY Organization_Name");
									while ($rowcombo2 = mysql_fetch_object($resultcombo2)){
								?>
								<option value="<?php print($rowcombo2->id);?>" <?php if($myedit=="yes") { if($rowcombo2->id==$rowcombo2->id) print('selected'); } ?> ><?php print($rowcombo2->Organization_Name);?></option>
								<?php	
								}	
								?>
						</select>&nbsp;&nbsp;						
						<input type="submit" name="btn_serch" value="GO!">		
				</form>
			</td>		
	<?php
	}
	else
	{
	?>					
			<td  id="lbl_org_id12"  class="onlyTable1">
					<form action="home.php" method="post">
					<input type="hidden" name="myflag" value="386">					
					<input type="hidden" name="txt_CODE" value="<?php print($this->CODE); ?>">
					<input type="hidden" name="txt_SubCode" value="<?php print($this->SubCODE); ?>">
					<input type="hidden" name="txt_ImpRot" value="<?php print($this->ImpRot); ?>">
					<input type="hidden" name="txt_MLine" value="<?php print($this->MLine); ?>">
					<input type="hidden" name="txt_MBL" value="<?php print($this->MBL); ?>">
					<input type="hidden" name="txt_TM" value="<?php print($this->TM); ?>">	
			Search By:&nbsp;			
						<select name="txt_Org_Id_for_search2"  maxlength="50">
							<?php
								$resultcombo2 = mysql_query("SELECT id,Organization_Name  FROM organization_profiles where Org_Type_id=11 ORDER BY Organization_Name");
								while ($rowcombo2 = mysql_fetch_object($resultcombo2)){
							?>
							<option value="<?php print($rowcombo2->id);?>" <?php if($myedit=="yes") { if($rowcombo2->id==$rowcombo2->id) print('selected'); } ?> ><?php print($rowcombo2->Organization_Name);?></option>
							<?php	
							}	
							?>
						</select>&nbsp;&nbsp;						
						<input type="submit" name="btn_serch" value="GO!">		
				</form>
			</td>
	<?php
	}
	?>		
<?php
// end for Dhaka-ICD Only 
}
?>

<?php
if(($_SESSION['Control_Panel']==44)||($_SESSION['Control_Panel']==10)||($_SESSION['Control_Panel']==7))
{
// Start for NAVY Only 
?>
	
	<?php
	if($this->SFlag=="1")
	{
	?>					
			<td  id="lbl_org_id12"  class="onlyTable1">			
				<form action="home.php" method="post" onsubmit="return validate_form(this)">
					<input type="hidden" name="myflag" value="387">					
					<input type="hidden" name="txt_CODE" value="<?php print($this->CODE); ?>">
					<input type="hidden" name="txt_MCODE" value="<?php print($this->MCODE); ?>">
					<input type="hidden" name="txt_SubCode" value="<?php print($this->SubCODE); ?>">
					<input type="hidden" name="txt_SSubCODE" value="<?php print($this->SSubCODE); ?>">
					<input type="hidden" name="txt_ImpRot" value="<?php print($this->ImpRot); ?>">
					<input type="hidden" name="txt_MLine" value="<?php print($this->MLine); ?>">
					<input type="hidden" name="txt_MBL" value="<?php print($this->MBL); ?>">
					<input type="hidden" name="txt_MSLine" value="<?php print($this->MSLine); ?>">
					<input type="hidden" name="txt_MSBL" value="<?php print($this->MSBL); ?>">									
					<input type="hidden" name="txt_TM" value="<?php print($this->TM); ?>">
					<input type="hidden" name="txt_SFlag" value="<?php print($this->SFlag); ?>">						
			Search By:&nbsp;								
						<select name="lbl_type_search">
										<option value="1">DG Cargo</option>
										<option value="2">IMCO</option>							
									</select>&nbsp;&nbsp;
									<input type="text" name="txt_str_Search" value="" maxlength="200">
									<input type="submit" name="btn_serch" value="GO!">	
						</select>			
				</form>
			</td>	
	<?php
	}
	else
	{
	?>						
			<td  id="lbl_org_id12"  class="onlyTable1">
					<form action="home.php" method="post" onsubmit="return validate_form(this)">
					<input type="hidden" name="myflag" value="388">					
					<input type="hidden" name="txt_CODE" value="<?php print($this->CODE); ?>">
					<input type="hidden" name="txt_SubCode" value="<?php print($this->SubCODE); ?>">
					<input type="hidden" name="txt_ImpRot" value="<?php print($this->ImpRot); ?>">
					<input type="hidden" name="txt_MLine" value="<?php print($this->MLine); ?>">
					<input type="hidden" name="txt_MBL" value="<?php print($this->MBL); ?>">
					<input type="hidden" name="txt_TM" value="<?php print($this->TM); ?>">	
			Search By:&nbsp;			
						<select name="lbl_type_search">
									<option value="1">DG Cargo</option>
									<option value="2">IMCO</option>							
								</select>&nbsp;&nbsp;
								<input type="text" name="txt_str_Search" value="" maxlength="200">
								<input type="submit" name="btn_serch" value="GO!">	
						</select>		
				</form>
			</td>
	<?php
	}
	?>		
<?php
// end for NAVY Only 
}
?>
</tr>
</table>
<?php if($_SESSION['Control_Panel']==81) {?>
<a href="home.php?myflag=139">&nbsp <img src="img/cchaiconBackPrevious.png" border="0" height="20" width="20"> Back to View IGM</a>
<?php } ?>
<table border="0" width="100%">
<!--
	<TR><TD colspan="6">

	<table>
			<tr><td align="center"><img src="image/add.png" border="0" height="25" width="35"></td>
				<td align="left">
					<span class="style15">
						<a href="home.php?myflag=16" target="upper_top">Create New User<a/>
					</span>
				</td>
			</tr>
	</table>
		</TD></TR>
		-->
		
		<tr class='gridDark'>
			<td valign="top">Shipping Agent&nbsp;Name</td>
			<td valign="top">Line&nbsp;No.</td>
			<td valign="top">HBL</td>
			<td valign="top">Number/Quantity</td>
			<td valign="top">Kind of Package</td>
			<td valign="top">Gross Weight</td>
			<td valign="top">Net Weight</td>
			<td valign="top">Marks&nbsp;&&nbsp;Number</td>
			<td valign="top">Description&nbsp;Of&nbsp;Goods</td>
			<!--<td valign="top">Date&nbsp;Of&nbsp;Entry&nbsp;of&nbsp;Goods</td>-->
			<td valign="top">Submission&nbsp;Date</td>
			<td valign="top">Container&nbsp;Detail</td>
		
			<td valign="top">Consignee&nbsp;and&nbsp;Notify&nbsp;Party</td>
			<td valign="top">Bill&nbsp;Of&nbsp;Entry&nbsp;Number</td>
			<td valign="top">Bill&nbsp;Of&nbsp;Entry&nbsp;Date</td>
			<td valign="top">Delivered</td>
			<td valign="top">Discharged</td>
			<td valign="top">C&&nbsp;F&nbsp;Agent&nbsp;Name</td>
			<td valign="top">Remarks</td>
			<td valign="top">Supplementary</td>
			<td valign="top">Navy Comments</td>
			
		
		<?php


		if($_SESSION['Control_Panel']==6)
		{
		// CNF
			print("<td>Accessibility</td>");
		}

		if($_SESSION['Control_Panel']==10)
		{
		// Custom
			print("<td>Accessibility</td>");
		}

		
		if($_SESSION['Control_Panel']==12)
		{
		// PORT
			print("<td>Accessibility</td>");
		}
		
		if($_SESSION['Control_Panel']==13)
		{
		// Of Dock
			print("<td>Accessibility</td>");
		}
		
		/* if($_SESSION['Control_Panel']==14)
		{
		// Importer
			print("<td>Accessibility</td>");
		} */
		if($_SESSION['Control_Panel']==15)
		{
		// Exporter
			print("<td>Accessibility</td>");
		}		
		
		if($_SESSION['Control_Panel']==81)
		{
	//Custom Intelligence AIR
			
			//print("<td>Comments</td>")						
			print("<td>AIR</td>");
		}		
		?>
		
		
		</tr>

		<?php

			//while ($row = mysql_fetch_object($result)) {
			if($igmMasterList) {
			$len=count($igmMasterList);
             
            for($i=0;$i<$len;$i++){
		?>
		
		<?php
				$myline1=explode("*",$igmMasterList[$i]['Line_No']);
				$mycnt1=count($myline1);
				$mlinedata1=$myline1[$mycnt1-1];

				$mybl2=explode("*",$igmMasterList[$i]['BL_No']);
				$mycnt2=count($mybl2);
				$mbldata1=$mybl2[$mycnt2-1];
			//	print($row->AFR);
					
				?>
			
			    <tr class='gridLight'>
	<td valign="top"><?php print('AIN NO: '.$igmMasterList[$i]['AIN_No'].'<br>'.$igmMasterList[$i]['Agent_Name']); ?></td>
					<td valign="top"><?php print($igmMasterList[$i]['Line_No']); ?></td>
					<td valign="top"><?php print($mbldata1); ?></td>
					<td><?php print($igmMasterList[$i]['Pack_Number']); ?></td>
					<td><?php print($igmMasterList[$i]['Pack_Description']); ?></td>
					<td><?php print($igmMasterList[$i]['weight'].' '.$igmMasterList[$i]['weight_unit']); ?></td>
					<td><?php print($igmMasterList[$i]['net_weight'].' '.$igmMasterList[$i]['net_weight_unit']); ?></td>
					<td><?php print($igmMasterList[$i]['Pack_Marks_Number']); ?></td>
					<td><?php print($igmMasterList[$i]['Description_of_Goods']); ?></td>
				<!--<td><?php print($igmMasterList[$i]['Date_of_Entry_of_Goods']); ?></td>-->
					<td><?php print($igmMasterList[$i]['Submission_Date']); ?></td>
					<td align="left" valign="top">
					
					<table width="100%">
					<tr><td>Cnt.&nbsp;Number</td><td>Seal&nbsp;Number</td><td>Size</td><td>Type</td><td>Height</td><td>Weight</td><td>Cont.GW</td><td>Status</td><td>IMCO</td><td>UN</td></tr>
					<?php 
					//load container detail
						/* print("select cnt.id as id,cnt.cont_number as cont_number,cnt.cont_size as cont_size,cnt.cont_weight as cont_weight,cnt.cont_seal_number as cont_seal_number,cnt.cont_description as cont_description from igm_detail_container cnt where cnt.igm_detail_id=$row->id"); */
						$id=$igmMasterList[$i]['id'];
						$result1 = mysql_query("select cnt.id as id,cnt.cont_number as cont_number,cnt.cont_size as cont_size,cnt.cont_type as cont_type,cnt.cont_height as cont_height,cnt.cont_status as cont_status,cnt.cont_weight as cont_weight,cnt.cont_gross_weight,cnt.cont_seal_number as cont_seal_number,cnt.cont_description as cont_description,cnt.cont_imo as cont_imo,cnt.cont_un as cont_un from  igm_sup_detail_container  cnt where cnt.igm_sup_detail_id=$id");						
						//echo "select cnt.id as id,cnt.cont_number as cont_number,cnt.cont_size as cont_size,cnt.cont_type as cont_type,cnt.cont_height as cont_height,cnt.cont_status as cont_status,cnt.cont_weight as cont_weight,cnt.cont_gross_weight,cnt.cont_seal_number as cont_seal_number,cnt.cont_description as cont_description,cnt.cont_imo as cont_imo,cnt.cont_un as cont_un from  igm_sup_detail_container  cnt where cnt.igm_sup_detail_id=$id";
						while($row1 = mysql_fetch_object($result1)) {
							print("<tr><td>$row1->cont_number</td><td>$row1->cont_seal_number</td><td>$row1->cont_size</td><td>$row1->cont_type</td><td>$row1->cont_height</td><td>$row1->cont_weight</td><td>$row1->cont_gross_weight</td><td>$row1->cont_status</td><td>$row1->cont_imo</td><td>$row1->cont_un</td></tr>");	
							print("<tr><td colspan='4'><hr noshade></td></tr>");
						}
						mysql_free_result($result1);	
						
					?>
					</table>
					
					</td>
				
					
					<td align="left" valign="top">
					
					<table width="100%">
					<tr><th align="left">Consignee</th></tr>
					<?php 
					// load consignee
						
						//print("select cons.id,cons.igm_sup_detail_id,cons.Consignee_ID,(select org.Organization_Name from organization_profiles org where org.id=cons.Consignee_ID) as consignee_name,(select org1.Address_1 from organization_profiles org1 where org1.id=cons.Consignee_ID) as Address_1,cons.ff_clearance as ff_clearance from igm_sup_detail_consigneetabs cons where cons.igm_sup_detail_id=$row->id");						
	

						$result2 = mysql_query("select cons.id,cons.igm_sup_detail_id,cons.Consignee_ID,(select org.Organization_Name from organization_profiles org where org.id=cons.Consignee_ID) as consignee_name,(select org1.Address_1 from organization_profiles org1 where org1.id=cons.Consignee_ID) as Address_1,cons.ff_clearance as ff_clearance from igm_sup_detail_consigneetabs cons where cons.igm_sup_detail_id=$id");						
						
						while($row2 = mysql_fetch_object($result2)) {
						if($_SESSION['org_id']==$row2->Consignee_ID)
						{
								if($row2->ff_clearance==1)
								{
								print("<tr><td align='left' class='notifyHighLight'><a href='home.php?myflag=340&CODE=$row->id&MCODE=$row->igm_master_id&SubCODE=$row->igm_detail_id&SSubCODE=$row->id&ImpRot=$row->Import_Rotation_No&MLine=$row->master_Line_No&MBL=$row->master_BL_No&MSLine=$row->Line_No&MSBL=$row->BL_No&TM=$this->TM&SFlag=1' target='upper_top'>$row2->consignee_name<br>$row2->Address_1</a></td></tr>");	
								print("<tr><td><hr noshade></td></tr>");
								}
								else
								{
								$altm='javascript:alert("You need clearance to submit Supplementary IGM")';
								print("<tr><td align='left'><a href='$altm' target='upper_top'>$row2->consignee_name<br>$row2->Address_1</a></td></tr>");	
								print("<tr><td><hr noshade></td></tr>");								
								}
						}
						else
						{
								print("<tr><td align='left'>$row2->consignee_name<br>$row2->Address_1</td></tr>");	
								print("<tr><td><hr noshade></td></tr>");						
						}
							
						}

						
						mysql_free_result($result2);	
						
					?>
					<tr><td><?php print($igmMasterList[$i]['ConsigneeDesc']); ?></td></tr>
					<tr><th align="left">Notify Party</th></tr>
					
					<?php 
					// load notify
						
						$result3 = mysql_query("select notf.id,notf.igm_sup_detail_id,notf.Notify_ID,(select org.Organization_Name from organization_profiles org where org.id=notf.Notify_ID) as notify_name,(select org1.Address_1 from organization_profiles org1 where org1.id=notf.Notify_ID) as Address_1,notf.ff_clearance as ff_clearance from igm_sup_detail_notifytabs notf where notf.igm_sup_detail_id=$id");						
						
						while($row3 = mysql_fetch_object($result3)) {
							if($_SESSION['org_id']==$row3->Notify_ID)
							{
								if($row3->ff_clearance==1)
								{
									print("<tr><td align='left' class='notifyHighLight'><a href='home.php?myflag=340&CODE=$row->id&MCODE=$row->igm_master_id&SubCODE=$row->igm_detail_id&SSubCODE=$row->id&ImpRot=$row->Import_Rotation_No&MLine=$row->master_Line_No&MBL=$row->master_BL_No&MSLine=$row->Line_No&MSBL=$row->BL_No&TM=$this->TM&SFlag=1' target='upper_top'>$row3->notify_name<br>$row3->Address_1</a></td></tr>");	
									print("<tr><td><hr noshade></td></tr>");
								}
								else
								{
									$altm='javascript:alert("You need clearance to submit Supplementary IGM")';
									print("<tr><td align='left'><a href='$altm' target='upper_top'>$row3->notify_name<br>$row3->Address_1</a></td></tr>");	
									print("<tr><td><hr noshade></td></tr>");								
								}
							}
							else
							{
									print("<tr><td align='left'>$row3->notify_name<br>$row3->Address_1</td></tr>");	
									print("<tr><td><hr noshade></td></tr>");							
							}
						}

						mysql_free_result($result3);	
						
					?>
					<tr><td><?php print($igmMasterList[$i]['NotifyDesc']); ?></td></tr>
					</table>
					
					</td>
					
					<td><a href='Forms/myBillEntryImportReportHTML.php?reg=<?php print($igmMasterList[$i]['Bill_of_Entry_No']);?>&date=<?php print($igmMasterList[$i]['Bill_of_Entry_Date']);?>&code=<?php print($igmMasterList[$i]['office_code']);?>' target="aboutblank"><?php print($igmMasterList[$i]['Bill_of_Entry_No']);?></a></td>
					<td><?php print($igmMasterList[$i]['Bill_of_Entry_Date']); ?></td>
					<td><?php print($igmMasterList[$i]['No_of_Pack_Delivered']); ?></td>
					<td><?php print($igmMasterList[$i]['No_of_Pack_Discharged']); ?></td>
				
					<td align="left" valign="top">
					
					<table width="100%">					
					<?php 
					// load CnF
						
						/*$result4 = mysql_query("select cnf.id,cnf.igm_sup_detail_id,cnf.CnF_ID_to_be_AccountedFor as CnF_ID_to_be_AccountedFor,(select org.Organization_Name from organization_profiles org where org.id=cnf.CnF_ID_to_be_AccountedFor) as cnf_name,(select org1.Address_1 from organization_profiles org1 where org1.id=cnf.CnF_ID_to_be_AccountedFor) as Address_1 from igm_sup_detail_cnftabs cnf where cnf.igm_sup_detail_id=$row->id");*/               


                                                $result4 = mysql_query("select cnf.id,cnf.igm_detail_id,cnf.CnF_ID_to_be_AccountedFor as CnF_ID_to_be_AccountedFor,(select org.Organization_Name from organization_profiles org where org.id=cnf.CnF_ID_to_be_AccountedFor) as cnf_name,(select org1.Address_1 from organization_profiles org1 where org1.id=cnf.CnF_ID_to_be_AccountedFor) as Address_1,(select org.AIN_No from organization_profiles org where org.id=cnf.CnF_ID_to_be_AccountedFor) as AIN_No fromigm_detail_cnftabs cnf where cnf.igm_detail_id=$id");						
						
						while($row4 = mysql_fetch_object($result4)) {
							
							if($_SESSION['org_id']==$row4->CnF_ID_to_be_AccountedFor)
							{
							print("<tr><td class='cnfHighLight'><a href='home.php?myflag=180&CODE=$row4->CnF_ID_to_be_AccountedFor&TM=$this->TM&SubCODE=$row->id&ImpRot=$this->ImpRot&MLine=$row->Line_No&MBL=$row->BL_No&TABINDX=1'>$row4->cnf_name<br>$row4->Address_1</a></td></tr>");
							}
							else
							{
							print("<tr><td align='left'>AIN NO: $row4->AIN_No<br>$row4->cnf_name<br>$row4->Address_1 </td></tr>");	
							}
							print("<tr><td><hr noshade></td></tr>");
						}
						mysql_free_result($result4);	
						
					?>
					</table>
					
					</td>
					
					<td><?php print($igmMasterList[$i]['Remarks']); ?></td>
					
					<td><a href='home.php?myflag=40&CODE=<?php print($row->id); ?>&MCODE=<?php print($row->igm_master_id); ?>&SubCODE=<?php print($row->igm_detail_id); ?>&SSubCODE=<?php print($row->id); ?>&ImpRot=<?php print($row->Import_Rotation_No); ?>&MLine=<?php print($row->master_Line_No); ?>&MBL=<?php print($row->master_BL_No); ?>&MSLine=<?php print($row->Line_No); ?>&MSBL=<?php print($row->BL_No); ?>&TM=<?php print($this->TM); ?>&SFlag=1' target='upper_top'>View Supplementary</a></td>
					
			
				<?php
							if($igmMasterList[$i]['final_amendment']==2)
							{
								print("<td valign='top'>
											LabComments:$igmMasterList[$i]['response_details1']<br>
											NAIO Comments:$igmMasterList[$i]['response_details2']<br>
											$igmMasterList[$i]['hold_application']</td>");
							}
							else if($igmMasterList[$i]['final_amendment']==3)
							{
								print("<td valign='top'>
											LabComments:$igmMasterList[$i]['response_details1']<br>
											NAIO Comments:$igmMasterList[$i]['response_details2']<br>
											$igmMasterList[$i]['rejected_application']</td>");
							}
							else if($igmMasterList[$i]['navy_response_to_port'] != "" and $igmMasterList[$i]['response_details3'] == "")
							{		
								print("<td valign='top'>$igmMasterList[$i]['navy_response_to_port']</td>");
							}
							else if($igmMasterList[$i]['final_amendment']==1)
							{	
								print("<td>LabComments:$igmMasterList[$i]['response_details1']<br>
										   NAIO Comments:$igmMasterList[$i]['response_details2']<br>		
										   Finally:$igmMasterList[$i]['response_details3']</td>");
							}
							else
							{
								print("<td valign='top'></td>");
							}
								//print($row->navy_response_to_port);
			?>
							



					<?php if($_SESSION['Control_Panel']==81){?>
					<td><a href='home.php?myflag=30&CODE=<?php print($row->igm_master_id); ?>&MCODE=<?php print($row->id); ?>&SubCODE=<?php print($row->igm_detail_id); ?>&AFR=<?print($row->AFR);?>&SSubCODE=<?php print($row->id); ?>&ImpRot=<?php print($row->Import_Rotation_No); ?>&MLine=<?php print($row->master_Line_No); ?>&MBL=<?php print($row->master_BL_No); ?>&MSLine=<?php print($row->Line_No); ?>&MSBL=<?php print($row->BL_No); ?>&TM=<?php print($this->TM); ?>&SFlag=1&AFO=<?php print($off)?>' target='upper_top'><?print($row->AFR);?></a></td>
					<?php } ?>					

					
		<?php
		
		if($_SESSION['Control_Panel']==6)
		{
		// CNF------------Morshed-------------------------
		print("<td>");
			print("<table width=100%>");
				print("<tr><td><a href='home.php?myflag=118&CODE=$row->id&TM=$this->TM'>Submit Cross Match Information</a></td></tr>");
				print("<tr><td><a href='home.php?myflag=117&CODE=$row->id&TM=$this->TM'>Update Cross match information</a></td></tr>");
				print("<tr><td><a href='home.php?myflag=121&CODE=$row->id&TM=$this->TM'>View List Duration of Amendment Request and Approved</a></td></tr>");
				print("<tr><td><a href='home.php?myflag=116&CODE=$row->id&TM=$this->TM'>View Dispute List</a></td></tr>");
				print("<tr><td><a href='home.php?myflag=336&CODE=$row->id&MCODE=$this->CODE&SubCODE=$this->SubCODE&ImpRot=$this->ImpRot&MLine=$this->MLine&MBL=$this->MBL&TM=$this->TM'>Assign&nbsp;CnF</a></td></tr>");				
					
			print("</table>");
		print("</td>");
		}

		if($_SESSION['Control_Panel']==10)
		{
		// Custom
			print("<td><a href='home.php?myflag=406&Id_Detail=$row->id&TM=$this->TM&CODE=$this->CODE'>Submit Dispute</a><br><hr noshade><a href='home.php?myflag=403&detail_id=$row->id&dis_msg=sup&TM=$this->TM&CODE=$this->CODE'>View Dispute List</a><br><hr noshade><a href='home.php?myflag=417&sup_detail_id=$row->id&TM=$this->TM&CODE=$this->CODE'>View Suplimentary Amendment Request list</a><br><hr noshade><a href='home.php?myflag=419&sup_detail_id=$row->id&TM=$this->TM&CODE=$this->CODE'>Confirm Final Amendment</a><br><hr noshade><a href='home.php?myflag=421&sup_detail_id=$row->id&TM=$this->TM&CODE=$this->CODE'>Send Change Request to Ship Agnt(Receive from C&F)</a></td>");
		}
		
		if($_SESSION['Control_Panel']==12)
		{
		// PORT
			if($this->TM=="GM")
			{
				//print("<td><a href='home.php?myflag=518&CODE=$row->id&TM=$this->TM'>Update Cont. Discharge Status</a><br><hr noshade><a href='home.php?myflag=521&CODE=$row->id&TM=$this->TM'>Add Cont. Unstaffing</a><br><hr noshade><a href='home.php?myflag=515&CODE=$row->id&TM=$this->TM'>Update Cont. Delivery Status</a></td>");   
				print("<td><a href='home.php?myflag=521&CODE=$row->id&TM=$this->TM'>Add Cont. Unstaffing</a></td>");   
			}
			else
			{
				//print("<td><a href='home.php?myflag=518&CODE=$row->id&TM=$this->TM'>Update Cont. Discharge Status</a><br><hr noshade><a href='home.php?myflag=521&CODE=$row->id&TM=$this->TM'>Add Cont. Unstaffing</a><br><hr><a href='home.php?myflag=515&CODE=$row->id&TM=$this->TM'>Update Cont. Delivery Status</a><br><hr noshade><a href='home.php?myflag=39&CODE=$row->id&MCODE=$this->CODE&SubCODE=$this->SubCODE&ImpRot=$this->ImpRot&MLine=$this->MLine&MBL=$this->MBL&TM=$this->TM&DV=DS&SFlag=$this->SFlag'>Update Break Bulk Discharge Status</a><br><hr noshade><a href='home.php?myflag=39&CODE=$row->id&MCODE=$this->CODE&SubCODE=$this->SubCODE&ImpRot=$this->ImpRot&MLine=$this->MLine&MBL=$this->MBL&TM=$this->TM&DV=DL&SFlag=$this->SFlag'>Update Break Bulk Delivery Status</a></td>");   
				print("<td><a href='home.php?myflag=521&CODE=$row->id&TM=$this->TM'>Add Cont. Unstaffing</a><br><hr noshade><a href='home.php?myflag=39&CODE=$row->id&MCODE=$this->CODE&SubCODE=$this->SubCODE&ImpRot=$this->ImpRot&MLine=$this->MLine&MBL=$this->MBL&TM=$this->TM&DV=DS&SFlag=$this->SFlag'>Update Break Bulk Discharge Status</a><br><hr noshade><a href='home.php?myflag=39&CODE=$row->id&MCODE=$this->CODE&SubCODE=$this->SubCODE&ImpRot=$this->ImpRot&MLine=$this->MLine&MBL=$this->MBL&TM=$this->TM&DV=DL&SFlag=$this->SFlag'>Update Break Bulk Delivery Status</a></td>");  
			}

		}
		
		if($_SESSION['Control_Panel']==13)
		{
		// Of Dock
			if($this->TM=="GM")
			{		
				print("<td><a href='home.php?myflag=521&CODE=$row->id&TM=$this->TM'>Add Cont. Unstaffing</a></td>");    
			}
			else
			{
				print("<td><<a href='home.php?myflag=521&CODE=$row->id&TM=$this->TM'>Add Cont. Unstaffing</a><br><hr noshade><a href='home.php?myflag=39&CODE=$row->id&MCODE=$this->CODE&SubCODE=$this->SubCODE&ImpRot=$this->ImpRot&MLine=$this->MLine&MBL=$this->MBL&TM=$this->TM&DV=DS&SFlag=$this->SFlag'>Update Break Bulk Discharge Status</a><br><hr><a href='home.php?myflag=39&CODE=$row->id&MCODE=$this->CODE&SubCODE=$this->SubCODE&ImpRot=$this->ImpRot&MLine=$this->MLine&MBL=$this->MBL&TM=$this->TM&DV=DL&SFlag=$this->SFlag'>Update Break Bulk Delivery Status</a></td>");    
			}
		
		}
		
		/* if($_SESSION['Control_Panel']==14)
		{
		// Importer
			print("<td>");
			print("<table width=100%>");
				print("<tr><td><a href='home.php?myflag=118&CODE=$row->id&TM=$this->TM'>Submit Cross Match Information</a></td></tr>");
				print("<tr><td><a href='home.php?myflag=117&CODE=$row->id&TM=$this->TM'>Update Cross match information</a></td></tr>");
				print("<tr><td><a href='home.php?myflag=121&CODE=$row->id&TM=$this->TM'>View List Duration of Amendment Request and Approved</a></td></tr>");
				print("<tr><td><a href='home.php?myflag=116&CODE=$row->id&TM=$this->TM'>View Dispute List</a></td></tr>");
				print("<tr><td><a href='home.php?myflag=336&CODE=$row->id&MCODE=$this->CODE&SubCODE=$this->SubCODE&ImpRot=$this->ImpRot&MLine=$this->MLine&MBL=$this->MBL&TM=$this->TM'>Assign&nbsp;CnF</a></td></tr>");
				print("</table>");
			print("</td>");
		}*/
		if($_SESSION['Control_Panel']==15)
		{
		// Exporter
				print("<td><a href=''>Submit Cross Match Information</a></td>");	
		}		
		?>
		
					</tr>
		<?php	
			}
}			

		?>

</table>

<?php mysql_close($con_cchaportdb);?>
<?php
		/*include_once("myPageCreate.php");
		$myform = new myPageCreate();
		if($this->SFlag==1)
		{
		//flag=40
		$myform->myListPage("$mySQL","home.php?myflag=40&CODE=$this->CODE&MCODE=$this->MCODE&SubCODE=$this->SubCODE&SSubCODE=$this->SSubCODE&ImpRot=$this->ImpRot&MLine=$this->MLine&MBL=$this->MBL&MSLine=$this->MSLine&MSBL=$this->MSBL&TM=$this->TM&SFlag=1");
		}
		else
		{
		//flah=30
		$myform->myListPage("$mySQL","home.php?myflag=30&CODE=$this->CODE&SubCODE=$this->SubCODE&ImpRot=$this->ImpRot&MLine=$this->MLine&MBL=$this->MBL&TM=$this->TM");
		}*/
?>
