
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
			
			if (validate_required(txt_serch,"Please Type Your Text to Search")==false)
				{return false;}
			if (validate_required(txt_str_Search,"Please Type Your Text to Search")==false)
				{return false;}
				
				
		}
	}
</script>
<?php include("mydbPConnection.php");
$_SESSION['Control_Panel']=$this->session->userdata('Control_Panel');
$this->CODE=$CODE;
$this->TM=$type;

?>
<table border="0" width="30%">
	
	<TR><TD colspan="2" class="formCaption" align="right"><h2><span><?php print($title); ?></span></h2></TD></TR>

	<TR>
	<TD ><a href="<?php echo site_url('igmViewController/myPanelView') ?>"><img src="<?php echo IMG_PATH; ?>back.png" height="40px" width="40px" align="middle" hspace="5"/>Back to Control Panel</a></TD>
	<TD align="center"><?php 
		$str="select distinct Import_Rotation_No From igm_masters WHERE id=$this->CODE ";
		//print($str);
		$result_rotationno = mysql_query($str);
		$row_rotationno=mysql_fetch_object($result_rotationno);
	print("<b>IMPORT ROTATION NO : ".$row_rotationno->Import_Rotation_No."</b>"); ?></TD></TR>

</table>

<table border="1" >
		<tr>			
<tr></tr>				
<?php
if(($_SESSION['Control_Panel']==11)||($_SESSION['Control_Panel']==10)||($_SESSION['Control_Panel']==7))
{
?>			
			<td  id="lbl_org_id12"  class="onlyTable1">
			<form action="home.php" method="post">
					<input type="hidden" name="myflag" value="377">					
					<input type="hidden" name="txt_CODE" value="<?php print($this->CODE); ?>">					
					<input type="hidden" name="txt_TM" value="<?php print($this->TM); ?>">	
				<input type="hidden" name="txt_ROTATION" value="<?php print($row_rotationno->Import_Rotation_No); ?>">	
			Search&nbsp;for&nbsp;FF:		
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
						</select>&nbsp;		
<input type="submit" name="btn_serch" value="GO!">	
</form>
</td>
<?php
}
?>
<?php
if(($_SESSION['Control_Panel']==6)||($_SESSION['Control_Panel']==10)||($_SESSION['Control_Panel']==7))
{
?>
<td>Search&nbsp;for&nbsp;C&nbsp;&amp;&nbsp;F:&nbsp;&nbsp;</td>
		<td>
				<form action="home.php" method="post">
					<input type="hidden" name="myflag" value="380">					
					<input type="hidden" name="txt_CODE2" value="<?php print($this->CODE); ?>">					
					<input type="hidden" name="txt_TM2" value="<?php print($this->TM); ?>">	
<input type="hidden" name="txt_ROTATION" value="<?php print($row_rotationno->Import_Rotation_No); ?>">			
						<select name="txt_Org_Id_for_search2"  maxlength="50">
							<?php
								$resultcombo2 = mysql_query("SELECT id,Organization_Name  FROM organization_profiles where Org_Type_id=2 ORDER BY Organization_Name");
								while ($rowcombo2 = mysql_fetch_object($resultcombo2)){
							?>
							<option value="<?php print($rowcombo2->id);?>" <?php if($myedit=="yes") { if($rowcombo2->id==$rowcombo2->id) print('selected'); } ?> ><?php print($rowcombo2->Organization_Name);?></option>
							<?php	
							}	
							?>
						</select>&nbsp;<input type="submit" name="btn_serch" value="GO!">	
				</form>
		</td>
</td>

<?php
}
?>
<?php
if(($_SESSION['Control_Panel']==12)||($_SESSION['Control_Panel']==10)||($_SESSION['Control_Panel']==7))
{
?>
<td><b>Search&nbsp;for&nbsp;Port:</b></td>
		<td>
				<!--<form action="home.php" method="post">-->
			<?php
				echo form_open('igmViewController/myListSearchforPort',$attributes);
				echo form_hidden('form_id', 1);
				$Stylepadding = 'style="padding: 12px 20px;"';
				if(!empty($error_message))
				{
					$Stylepadding = 'style="padding:25px 20px;"';
				}	
				if(isset($captcha_image)){
					$Stylepadding = 'style="padding:62px 20px 93px;"';
				}
			?>
					<input type="hidden" name="myflag" value="383">					
					<input type="hidden" name="txt_CODE2" value="<?php print($this->CODE); ?>">					
					<input type="hidden" name="txt_TM2" value="<?php print($this->TM); ?>">			
					<input type="hidden" name="txt_ROTATION" value="<?php print($row_rotationno->Import_Rotation_No); ?>">	
					<select name="txt_Org_Id_for_search2"  maxlength="50">
						<option>-------------------Select--------------------</option>
						<?php
							$resultcombo2 = mysql_query("SELECT id,Organization_Name  FROM organization_profiles where Org_Type_id=6 or id=2591 ORDER BY Organization_Name");
							while ($rowcombo2 = mysql_fetch_object($resultcombo2)){
						?>
						<option value="<?php print($rowcombo2->id);?>" <?php if($myedit=="yes") { if($rowcombo2->id==$rowcombo2->id) print('selected'); } ?> ><?php print($rowcombo2->Organization_Name);?></option>
						<?php	
						}	
						?>
						
					</select>&nbsp;<?php $arrt = array('name'=>'SearchD','id'=>'submit','value'=>'Go','class'=>'login_button'); echo form_submit($arrt);?>
					<!--<input type="submit" name="btn_serch" value="GO!">-->	
				<?php form_close(); ?>
		</td>
</td>

<?php
}
?>

<?php
if(($_SESSION['Control_Panel']==13)||($_SESSION['Control_Panel']==10)||($_SESSION['Control_Panel']==7))
{
?>
<td>Search&nbsp;for&nbsp;DOCK</td>
		<td>
				<form action="home.php" method="post">
					<input type="hidden" name="myflag" value="383">					
					<input type="hidden" name="txt_CODE2" value="<?php print($this->CODE); ?>">					
					<input type="hidden" name="txt_TM2" value="<?php print($this->TM); ?>">	
<input type="hidden" name="txt_ROTATION" value="<?php print($row_rotationno->Import_Rotation_No); ?>">		
						<select name="txt_Org_Id_for_search2"  maxlength="50">
							<?php
								$resultcombo2 = mysql_query("SELECT id,Organization_Name  FROM organization_profiles where Org_Type_id=6 ORDER BY Organization_Name");
								while ($rowcombo2 = mysql_fetch_object($resultcombo2)){
							?>
							<option value="<?php print($rowcombo2->id);?>" <?php if($myedit=="yes") { if($rowcombo2->id==$rowcombo2->id) print('selected'); } ?> ><?php print($rowcombo2->Organization_Name);?></option>
							<?php	
							}	
							?>
						</select>&nbsp;<input type="submit" name="btn_serch" value="GO!">	
				</form>
		</td>
</td>

<?php
}
?>

<?php
if(($_SESSION['Control_Panel']==43)||($_SESSION['Control_Panel']==10)||($_SESSION['Control_Panel']==7))
{
?>
<td>Search&nbsp;for&nbsp;Dhaka-ICD</td>
		<td>
				<form action="home.php" method="post">
					<input type="hidden" name="myflag" value="383">					
					<input type="hidden" name="txt_CODE2" value="<?php print($this->CODE); ?>">					
					<input type="hidden" name="txt_TM2" value="<?php print($this->TM); ?>">	
<input type="hidden" name="txt_ROTATION" value="<?php print($row_rotationno->Import_Rotation_No); ?>">			
						<select name="txt_Org_Id_for_search2"  maxlength="50">
							<?php
								$resultcombo2 = mysql_query("SELECT id,Organization_Name  FROM organization_profiles where Org_Type_id=11 ORDER BY Organization_Name");
								while ($rowcombo2 = mysql_fetch_object($resultcombo2)){
							?>
							<option value="<?php print($rowcombo2->id);?>" <?php if($myedit=="yes") { if($rowcombo2->id==$rowcombo2->id) print('selected'); } ?> ><?php print($rowcombo2->Organization_Name);?></option>
							<?php	
							}	
							?>
						</select>&nbsp;<input type="submit" name="btn_serch" value="GO!">	
				</form>
		</td>
</td>

<?php
}
?>

<?php

if(($_SESSION['Control_Panel']==44)||($_SESSION['Control_Panel']==10)||($_SESSION['Control_Panel']==7))
{
?>
<td>Search&nbsp;for&nbsp;NAVY</td>
		<td>
				<form action="home.php" method="post" onsubmit="return validate_form(this)">
					<input type="hidden" name="myflag" value="384">					
					<input type="hidden" name="txt_CODE2" value="<?php print($this->CODE); ?>">					
					<input type="hidden" name="txt_TM2" value="<?php print($this->TM); ?>">	
<input type="hidden" name="txt_ROTATION" value="<?php print($row_rotationno->Import_Rotation_No); ?>">		
					
						<select name="lbl_type_search">
							<option value="1">DG Cargo</option>
							<option value="2">IMCO</option>							
						</select>&nbsp;&nbsp;
					<input type="text" name="txt_str_Search" value="" maxlength="100" style="width:75px">
					<input type="submit" name="btn_serch" value="GO!">	
						
				</form>
		</td>
</td>
<?php
}
?>

	
</table>	

<table border="0" width="2000px">
		<tr>			
						
			<td  id="lbl_org_id122"  class="onlyTable1">
			<!--<form action="home.php" method="post">-->
			<?php
				echo form_open(base_url().'index.php/igmViewController/myListSearchBySAF',$attributes);
				$Stylepadding = 'style="padding: 12px 20px;"';
				if(!empty($error_message))
				{
					$Stylepadding = 'style="padding:25px 20px;"';
				}	
				if(isset($captcha_image)){
					$Stylepadding = 'style="padding:62px 20px 93px;"';
				}
			?>
					<input type="hidden" name="myflag" value="1001">					
					<input type="hidden" name="txt_CODE" value="<?php print($this->CODE); ?>">					
					<input type="hidden" name="txt_TM" value="<?php print($this->TM); ?>">	
<input type="hidden" name="txt_ROTATION" value="<?php print($row_rotationno->Import_Rotation_No); ?>">	
					
			<b>IGM&nbsp;Submitted&nbsp;by&nbsp;SAF:	</b>
				<select name="txt_Org_Id_for_search122"  maxlength="50" onFocus="gsLabelObj(lbl_org_id122,'#61BCEF','white')" onBlur="gsLabelObj(lbl_org_id122,'','')">
					<?php
						$resultcombo1 = mysql_query("SELECT distinct(Submitee_Org_Id) as id,(select Organization_Name from organization_profiles orgs where orgs.id=igm_details.Submitee_Org_Id) as Organization_Name 
FROM  igm_details where IGM_id=$this->CODE and Substring(Submitee_Id,-1)='F' and type_of_igm='$this->TM' ORDER BY Organization_Name");
						while ($rowcombo1 = mysql_fetch_object($resultcombo1)){
					?>
					<option value="<?php print($rowcombo1->id);?>" <?php if($myedit=="yes") { if($rowcombo1->id==$rowcombo1->id) print('selected'); } ?> ><?php print($rowcombo1->Organization_Name);?></option>
					<?php	
					}
					?>
				</select>			
			<?php $arrt = array('name'=>'SearchD','id'=>'submit','value'=>'GO!','class'=>'login_button'); echo form_submit($arrt);?>
<!--<input type="submit" name="btn_serch" value="GO!">-->	
</form>
</td>

<td  id="lbl_org_id123"  class="onlyTable1">
			<!--<form action="home.php" method="post">-->
			<?php
				echo form_open(base_url().'index.php/igmViewController/myListSearchByMLO',$attributes);
				$Stylepadding = 'style="padding: 12px 20px;"';
				if(!empty($error_message))
				{
					$Stylepadding = 'style="padding:25px 20px;"';
				}	
				if(isset($captcha_image)){
					$Stylepadding = 'style="padding:62px 20px 93px;"';
				}
						?>
			
					<input type="hidden" name="myflag" value="1002">					
					<input type="hidden" name="txt_CODE" value="<?php print($this->CODE); ?>">					
					<input type="hidden" name="txt_TM" value="<?php print($this->TM); ?>">	
<input type="hidden" name="txt_ROTATION" value="<?php print($row_rotationno->Import_Rotation_No); ?>">	
		<b>	IGM&nbsp;Submitted&nbsp;by&nbsp;MLO:		</b>
				<select name="txt_Org_Id_for_search123"  maxlength="50" onFocus="gsLabelObj(lbl_org_id123,'#61BCEF','white')" onBlur="gsLabelObj(lbl_org_id123,'','')">
					<?php
						$resultcombo = mysql_query("SELECT distinct(Submitee_Org_Id) as id,(select Organization_Name from organization_profiles orgs where orgs.id=igm_details.Submitee_Org_Id) as Organization_Name 
FROM igm_details where IGM_id=$this->CODE and Substring(Submitee_Id,-1)='m' and type_of_igm='$this->TM' ORDER BY Organization_Name");
						
						while ($rowcombo = mysql_fetch_object($resultcombo)){
					?>
					<option value="<?php print($rowcombo->id);?>" <?php if($myedit=="yes") { if($rowcombo->id==$rowcombo->id) print('selected'); } ?> ><?php print($rowcombo->Organization_Name);?></option>
					<?php	
					}
					?>
				</select>			
			<?php $arrt = array('name'=>'btn_serch','id'=>'submit','value'=>'GO!','class'=>'login_button'); echo form_submit($arrt);?>
<!--<input type="submit" name="btn_serch" value="GO!">	-->
</form>
</td>
	
<td  id="lbl_org_id124"  class="onlyTable1">
<?php
				echo form_open('igmViewController/myListSearchMLO');
				$Stylepadding = 'style="padding: 12px 20px;"';
				if(!empty($error_message))
				{
					$Stylepadding = 'style="padding:25px 20px;"';
				}	
				if(isset($captcha_image)){
					$Stylepadding = 'style="padding:62px 20px 93px;"';
				}
			?>
			<!--<form action="home.php" method="post">-->
					<input type="hidden" name="myflag" value="1004">					
					<input type="hidden" name="txt_CODE" value="<?php print($this->CODE); ?>">					
					<input type="hidden" name="txt_TM" value="<?php print($this->TM); ?>">	
<input type="hidden" name="txt_ROTATION" value="<?php print($row_rotationno->Import_Rotation_No); ?>">	
			<b>Search&nbsp;by&nbsp;MLO&nbsp;CODE:	</b>	
				
				<select name="txt_Org_Id_for_search123"  maxlength="50" onFocus="gsLabelObj(lbl_org_id124,'#61BCEF','white')" onBlur="gsLabelObj(lbl_org_id124,'','')">
					<?php
						//print("SELECT distinct(mlocode) FROM igm_details where IGM_id='$this->CODE'");
					
						$resultcombo = mysql_query("SELECT distinct(mlocode) 
FROM igm_details where IGM_id='$this->CODE'");
						while ($rowcombo = mysql_fetch_object($resultcombo)){
					?>
					<option value="<?php print($rowcombo->mlocode);?>" <?php if($myedit=="yes") { if($rowcombo->mlocode==$rowcombo->mlocode) print('selected'); } ?> ><?php print($rowcombo->mlocode);?></option>
					<?php	
					}
					?>
				</select>			
			<?php $arrt3 = array('name'=>'btn_serch3','id'=>'submit3','value'=>'GO!','class'=>'login_button'); echo form_submit($arrt3);?>
<!--<input type="submit" name="btn_serch" value="GO!">	-->
</form>

</td>	
<?php
				
				echo form_open('igmViewController/myListSearchLineBL');
				
				$Stylepadding = 'style="padding: 12px 20px;"';
				if(!empty($error_message))
				{
					$Stylepadding = 'style="padding:25px 20px;"';
				}	
				if(isset($captcha_image)){
					$Stylepadding = 'style="padding:62px 20px 93px;"';
				}
			?>
		<td  id="lbl_org_id17"  class="onlyTable1">
				<!--	<form name="frmgn" action="home.php" method="post" onsubmit="return validate_form(this)">-->
				
						<input type="hidden" name="myflag" value="53">					
						<input type="hidden" name="MCODE" value="<?php print($this->CODE); ?>">	
						<input type="hidden" name="TM" value="<?php print($this->TM); ?>">
<input type="hidden" name="txt_ROTATION" value="<?php print($row_rotationno->Import_Rotation_No); ?>">					
						<b>Search&nbsp;By:&nbsp;</b>
						<select name="lbl_search" onFocus="gsLabelObj(lbl_org_id17,'#61BCEF','white')" onBlur="gsLabelObj(lbl_org_id17,'','')">
							<option value="1">B/L No</option>
							<option value="2">Line No</option>
							<option value="3">Container No</option>
						</select>
						<input type="text" name="txt_serch" value="" maxlength="50" style="width:75px">
						<?php $arrt2 = array('name'=>'btn_serch2','id'=>'submit2','value'=>'GO!','class'=>'login_button'); echo form_submit($arrt2);?>
						<!--<input type="submit" name="btn_serch6" value="GO!">-->
			
			</td>
	</form>		
	<?php
	echo form_open('igmViewController/myListSearchImporter');
				
				$Stylepadding = 'style="padding: 12px 20px;"';
				if(!empty($error_message))
				{
					$Stylepadding = 'style="padding:25px 20px;"';
				}	
				if(isset($captcha_image)){
					$Stylepadding = 'style="padding:62px 20px 93px;"';
				}
			?>
		<td  id="lbl_org_id17"  class="onlyTable1">
				<!--	<form name="frmgn" action="home.php" method="post" onsubmit="return validate_form(this)">-->
				
						<input type="hidden" name="myflag" value="53">					
						<input type="hidden" name="MCODE" value="<?php print($this->CODE); ?>">	
						<input type="hidden" name="TM" value="<?php print($this->TM); ?>">
<input type="hidden" name="txt_ROTATION" value="<?php print($row_rotationno->Import_Rotation_No); ?>">					
						<b>Search&nbsp;By:&nbsp;</b>
						<select name="lbl_search" onFocus="gsLabelObj(lbl_org_id17,'#61BCEF','white')" onBlur="gsLabelObj(lbl_org_id17,'','')">
							<option value="ConsigneeDesc">Consignee</option>
							<option value="NotifyDesc">Notify</option>
							<option value="Description_of_Goods">Description</option>
						</select>
						<input type="text" name="txt_serch" value="" maxlength="50" style="width:75px">
						<?php $arrt2 = array('name'=>'btn_serch2','id'=>'submit2','value'=>'GO!','class'=>'login_button'); echo form_submit($arrt2);?>
						<!--<input type="submit" name="btn_serch6" value="GO!">-->
			
			</td>
	</form>	
</tr>	
</table>	



<?php
if($_SESSION['Control_Panel']==12)
{ /* close for new panel by shemul
?>
<table>
<tr>
<td><a href='home.php?myflag=557&CODE=<?php print($this->CODE); ?>&TM=<?php print($this->TM); ?>'><img src="img/cchaiconEdit.png" height="20" width="20">&nbsp;Update Cont. Discharge Status</a></td>
<td><a href='home.php?myflag=558&CODE=<?php print($this->CODE); ?>&TM=<?php print($this->TM); ?>'><img src="img/cchaiconEdit.png" height="20" width="20">&nbsp;Update Cont. Received Status</a></td>
<td><a href='home.php?myflag=560&CODE=<?php print($this->CODE); ?>&TM=<?php print($this->TM); ?>'><img src="img/cchaiconAdd.png" height="20" width="20">&nbsp;Add Cont. Unstaffing</a></td>
<td><a href='home.php?myflag=559&CODE=<?php print($this->CODE); ?>&TM=<?php print($this->TM); ?>'><img src="img/cchaiconEdit.png" height="20" width="20">&nbsp;Update Cont. Delivery Status</a></td>

</tr>
</table>
<?php
*/ } 
?>

<?php
if($_SESSION['Control_Panel']==13)
{
?>
<table>
<tr>
<td><img src="img/cchaiconEdit.png" height="20" width="20">&nbsp;<a href='home.php?myflag=558&CODE=<?php print($this->CODE); ?>&TM=<?php print($this->TM); ?>'>Update Cont. Received Status</a></td>
<td><img src="img/cchaiconEdit.png" height="20" width="20">&nbsp;<a href='home.php?myflag=559&CODE=<?php print($this->CODE); ?>&TM=<?php print($this->TM); ?>'>Update Cont. Delivery Status</a></td>
</tr>
</table>
<?php
}
?>

<?php if($_SESSION['Control_Panel']==81) {?>
<a href="home.php?myflag=139">&nbsp <img src="img/cchaiconBackPrevious.png" border="0" height="20" width="20"> Back to View IGM</a>
<?php } ?>
<table >
		<tr class='gridDark'><td>Shipping Agent Name</td><td>MLO&nbsp;Code</td><td>Line&nbsp;No.</td><td>B/L Number</td><td>Number/Quantity</td><td>Kind of Package</td><td>Marks&nbsp;&&nbsp;Number</td><td>Description&nbsp;Of&nbsp;Goods</td><!--<td>Date&nbsp;Of&nbsp;Entry&nbsp;of&nbsp;Goods</td>--><td>Gross Weight</td><td>Net Weight</td><td>IGM Submission Date</td>

		<td>Container&nbsp;Detail</td>

		<td>Consignee&nbsp;and&nbsp;Notify&nbsp;Party</td><td>Bill&nbsp;Of&nbsp;Entry&nbsp;Number</td><td>Bill&nbsp;Of&nbsp;Entry&nbsp;Date</td><td>Delivered</td><td>Discharged</td><td>C&nbsp;&&nbsp;F&nbsp;Agent&nbsp;Name</td><td>Remarks</td><td>AIR BLock Status</td><td>Delivery Block Status</td><td>Intelligence Block Status</td>
		
			<?php
			if($this->TM == "BB" || $this->TM == "BNIL" || $this->TM == "BTS" || $this->TM == "BROB")
			{
		?>
				<td>IMCO</td><td>UN</td>
		<?php
			}
			if($this->TM == "BAMS" || $this->TM == "BPS" || $this->TM == "AMS" || $this->TM == "PS")
			{
		?>
				<td>IMCO</td><td>UN</td><td>
				<?php
				if($this->TM == "BAMS" || $this->TM == "AMS")
				print("Arms,Ammunition and Explosive");
				
				if($this->TM == "BPS" || $this->TM == "PS")
				print("Provision And Store Supply");
				
				?>
				</td>
		<?php
			}
		?>
			<?php	
		if($_SESSION['Control_Panel']==12)
		{
			// Custom
				print("<td>Referd To Navy</td>");
		}
		?>

		<td>Supplementary</td>
		
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
		
		if($_SESSION['Control_Panel']==11)
		{
		// Freight_Forwarder
			print("<td>Accessibility for Navy</td>");
		}
		
		if($_SESSION['Control_Panel']==12)
		{
		// PORT close for new panel by shemul
			// print("<td>Accessibility</td>");
		}
		
		if($_SESSION['Control_Panel']==13)
		{
		// Of Dock
			print("<td>Accessibility</td>");
		}
		
	/*	if($_SESSION['Control_Panel']==14)
		{
		// Importer
			print("<td>Accessibility</td>");
		} */
		
		
		if($_SESSION['Control_Panel']==10 || $_SESSION['Control_Panel']==44 || $_SESSION['Control_Panel']==12)
		{
		// Navy
			
			//print("<td>Comments</td>")			
			print("<td>Navy&nbsp;Comments</td>");
			
		}
		
		if($_SESSION['Control_Panel']==44)
		{
		// Navy
			
			//print("<td>Comments</td>")						
			print("<td>Accessibility</td>");
		}		
		if($_SESSION['Control_Panel']==81)
		{
	//Custom Intelligence AIR
			
			//print("<td>Comments</td>")						
			print("<td>AIR</td>");
		}		
		?>
		<td>Delivery Order</td>
		
		</tr>

		<?php
//include("mydbPConnection.php");
//include("DatasoftUtility.php");
			
			//while ($row = mysql_fetch_object($result)) {
			if($igmMasterList) {
			$len=count($igmMasterList);
             
            for($i=0;$i<$len;$i++){
		?>
			<?php 
				if($igmMasterList[$i]['AFR']=="BLOCKED")
				{
				?>
				<tr bgcolor='#93FDBD' align="center">
				<?php } elseif ($row->delivery_block_stat=="block") { ?>
				<tr bgcolor='#FF6633' align="center">
				<?php } elseif ($row->int_block=="block") { ?>
				<tr bgcolor='#C8D780' align="center">
				<?php } else { ?>
				<tr class='gridLight'>
				<?php } ?>
			    <!--<tr class='gridLight'>-->
<td valign="top"><?php print('AIN NO: '.$igmMasterList[$i]['AIN_No'].'<br>'.$igmMasterList[$i]['Organization_Name']); ?></td>
					<td valign="top"><?php print($igmMasterList[$i]['mlocode']); ?></td>					
					<td valign="top"><?php print($igmMasterList[$i]['Line_No']); ?></td>
					<td valign="top"><?php print($igmMasterList[$i]['BL_No']); ?></td>
					<td valign="top"><?php print($igmMasterList[$i]['Pack_Number']); ?></td>
										
					<td valign="top"><?php print($igmMasterList[$i]['Pack_Description']); ?></td>
					<td valign="top"><?php print($igmMasterList[$i]['Pack_Marks_Number']); ?></td>
					<td valign="top"><?php print($igmMasterList[$i]['Description_of_Goods']); ?></td>
					<!--<td valign="top"><?php print($igmMasterList[$i]['Date_of_Entry_of_Goods']); ?></td>-->
					<td valign="top"><?php print($igmMasterList[$i]['weight']); ?>&nbsp;<?php print($igmMasterList[$i]['weight_unit']); ?></td>
					<td valign="top"><?php print($igmMasterList[$i]['net_weight']); ?>&nbsp;<?php print($igmMasterList[$i]['net_weight_unit']); ?></td>
					
					
<td valign="top"><?php print($igmMasterList[$i]['final_submit_date']); ?></td>
		
					<td align="left" valign="top">
					
					<table width="100%">
					<tr><td>Offdock</td><td>Cnt.&nbsp;Number</td><td>Seal&nbsp;Number</td><td>Size</td><td>Type</td><td>ISO Code</td><td>Height</td><td>Gross Weight</td><td>Tare Weight</td><td>Status</td><td>IMCO</td><td>UN</td><td>Remarks</td></tr>
					<?php 
					//load container detail
						//print("select cnt.id as id,cnt.cont_number as cont_number,cnt.cont_size as cont_size,cnt.cont_iso_type as cont_iso_type,cnt.cont_weight as cont_weight,cnt.cont_seal_number as cont_seal_number,cnt.cont_description as cont_description from igm_detail_container cnt where cnt.igm_detail_id=$row->id");
						$id=$igmMasterList[$i]['id'];
						$str="select cnt.id as id,cnt.cont_number as cont_number,cnt.cont_size as cont_size,cnt.cont_type as cont_type,cnt.cont_iso_type as cont_iso_type,cnt.cont_height as cont_height,cnt.cont_status as cont_status,cnt.cont_gross_weight as cont_gross_weight,cnt.cont_weight as cont_weight,cnt.cont_seal_number as cont_seal_number,cnt.cont_description as cont_description,cnt.cont_imo as cont_imo,cnt.cont_un as cont_un,Organization_Name from igm_detail_container cnt 
left join organization_profiles on cnt.off_dock_id=organization_profiles.id
where cnt.igm_detail_id=$id";
//print($str);
$result1 = mysql_query($str);						
						
						while($row1 = mysql_fetch_object($result1)) {
							print("<tr><td>$row1->Organization_Name</td><td>$row1->cont_number</td><td>$row1->cont_seal_number</td><td>$row1->cont_size</td><td>$row1->cont_type</td><td>$row1->cont_iso_type</td><td>$row1->cont_height</td><td>$row1->cont_gross_weight</td><td>$row1->cont_weight</td><td>$row1->cont_status</td><td>$row1->cont_imo</td><td>$row1->cont_un</td><td>$row1->cont_description</td></tr>");	
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
						
						$result2 = mysql_query("select cons.id,cons.igm_detail_id,cons.Consignee_ID,(select org.Organization_Name from organization_profiles org where org.id=cons.Consignee_ID) as consignee_name,(select org1.Address_1 from organization_profiles org1 where org1.id=cons.Consignee_ID) as Address_1,cons.ff_clearance as ff_clearance from igm_detail_consigneetabs cons where cons.igm_detail_id=$id");						
						
						
						
						while($row2 = mysql_fetch_object($result2)) {
							if($_SESSION['org_id']==$row2->Consignee_ID)
							{
								if($row2->ff_clearance==1)
								{
								print("<tr><td class='consigneeHighLight'><a href='home.php?myflag=324&CODE=$row->IGM_id&SubCODE=$row->id&ImpRot=$row->Import_Rotation_No&MLine=$row->Line_No&MBL=$row->BL_No&TM=$this->TM&SFlag=0' target='upper_top'>$row2->consignee_name<br>$row2->Address_1</a></td></tr>");	



		//// IGM Acceptance Status
		$resprior = mysql_query("select PFStatus from igm_details where id=$igmMasterList[$i]['id']");
			if($rowprior = mysql_fetch_object($resprior)) 
				{
				$PFs=$rowprior->PFStatus ;
				if($PFs=="2")
				print("<br><label class='onlyMsg'>PRIOR IGM Not Accepted by Custom yet.</label>");
				else if($PFs=="1")
				print("<br><label class='onlyMsg'>Accepted by Custom as PRIOR IGM.</label>");
				else if($PFs=="10")
				print("<br><label class='onlyMsg'>Final Entry Complete.</label>");
				}
			/// End IGM Acceptance Status

								print("<tr><td><hr noshade></td></tr>");								
								}
								else
								{
								$altm='javascript:alert("You need clearance to submit Supplementary IGM")';
								print("<tr><td class='consigneeHighLight'><a href='$altm' target='upper_top'>$row2->consignee_name<br>$row2->Address_1</a></td></tr>");	
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
					
					<tr><td valign="top"><?php print($igmMasterList[$i]['ConsigneeDesc']); ?></td></tr>
					
					<tr><th align="left">Notify Party</th></tr>
					
					<?php 
					// load notify
						
						$result3 = mysql_query("select notf.id,notf.igm_detail_id,notf.Notify_ID,(select org.Organization_Name from organization_profiles org where org.id=notf.Notify_ID) as notify_name,(select org1.Address_1 from organization_profiles org1 where org1.id=notf.Notify_ID) as Address_1,notf.ff_clearance as ff_clearance from igm_detail_notifytabs notf where notf.igm_detail_id=$id");						
						
						
						
						while($row3 = mysql_fetch_object($result3)) {
							
							if($_SESSION['org_id']==$row3->Notify_ID)
							{
								if($row3->ff_clearance==1)
								{
								print("<tr><td class='notifyHighLight'><a href='home.php?myflag=324&CODE=$row->IGM_id&SubCODE=$row->id&ImpRot=$row->Import_Rotation_No&MLine=$row->Line_No&MBL=$row->BL_No&TM=$this->TM&SFlag=0' target='upper_top'>$row3->notify_name<br>$row3->Address_1</a></td></tr>");	
								print("<tr><td><hr noshade></td></tr>");
								}
								else
								{
								$altm='javascript:alert("You need clearance to submit Supplementary IGM")';
								print("<tr><td class='notifyHighLight'><a href='$altm' target='upper_top'>$row3->notify_name<br>$row3->Address_1</a></td></tr>");	
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
					
					<tr><td valign="top"><?php print($igmMasterList[$i]['NotifyDesc']); ?></td></tr>
					</table>
					
					</td>
					




<td valign="top"><a href='Forms/myBillEntryImportReportHTML.php?reg=<?php print($igmMasterList[$i]['Bill_of_Entry_No']);?>&date=<?php print($igmMasterList[$i]['Bill_of_Entry_Date']);?>&code=<?php print($igmMasterList[$i]['office_code']);?>' target="aboutblank"><?php print($igmMasterList[$i]['Bill_of_Entry_No']);?></a>

					<?php if($igmMasterList[$i]['Bill_of_Entry_No']!='' and $igmMasterList[$i]['R_No']!='') { ?>
					<?php 
					print("<hr noshade>"); ?>
					<font color="">
					
					
					BE Status:
					<?php //print("$row->BE_Status<br>");	
							print("<br>"); ?>
					<?php } if($igmMasterList[$i]['R_No']!='') { ?>
					RNo:<a href="javascript:gsremote2
('Forms/myDeliverydashboardrepot.php?beno=<?php print($igmMasterList[$i]['Bill_of_Entry_No']);?>
&bedate=<?php print($igmMasterList[$i]['Bill_of_Entry_Date']);?>
&officecode=<?php print($igmMasterList[$i]['office_code']);?>
&Import_Rotation_No=<?php print($igmMasterList[$i]['Import_Rotation_No']);?>
&Line_No=<?php print($igmMasterList[$i]['Line_No']);?>
&BL_No=<?php print($igmMasterList[$i]['BL_No']);?>','abc',400,350,10,10)">
<?php if($igmMasterList[$i]['R_No'])  print($igmMasterList[$i]['R_No']); else print("&nbsp;"); print("<br>");   ?>
</a>R Date:<?php if($igmMasterList[$i]['R_Date'])  print($igmMasterList[$i]['R_Date']); 
else print("&nbsp;"); ?>
															
					<?php 
						
						}	
					 ?>
					</font></td>


					<td valign="top"><?php print($igmMasterList[$i]['Bill_of_Entry_Date']); ?></td>
					<td valign="top"><?php print($igmMasterList[$i]['No_of_Pack_Delivered']); ?></td>
					<td valign="top"><?php print($igmMasterList[$i]['No_of_Pack_Discharged']); ?></td>
				
					<td align="left" valign="top">
					
					<table width="100%">					
					<?php 
					// load CnF
						
						/*$result4 = mysql_query("select cnf.id,cnf.igm_detail_id,cnf.CnF_ID_to_be_AccountedFor as CnF_ID_to_be_AccountedFor,(select org.Organization_Name from organization_profiles org where org.id=cnf.CnF_ID_to_be_AccountedFor) as cnf_name,(select org1.Address_1 from organization_profiles org1 where org1.id=cnf.CnF_ID_to_be_AccountedFor) as Address_1 from igm_detail_cnftabs cnf where cnf.igm_detail_id=$row->id");*/		         

                                              $result4 = mysql_query("select cnf.id,cnf.igm_detail_id,cnf.CnF_ID_to_be_AccountedFor 
	as CnF_ID_to_be_AccountedFor,(select org.Organization_Name from organization_profiles org 
	where org.id=cnf.CnF_ID_to_be_AccountedFor) as cnf_name,(select org1.Address_1 from organization_profiles 
	org1 where org1.id=cnf.CnF_ID_to_be_AccountedFor) as Address_1,(select org.AIN_No from organization_profiles 
	org where org.id=cnf.CnF_ID_to_be_AccountedFor) as AIN_No from igm_detail_cnftabs cnf 
	where cnf.igm_detail_id=$igmMasterList[$i]['id']");				
						
						while($row4 = mysql_fetch_object($result4)) {
							
							if($_SESSION['org_id']==$row4->CnF_ID_to_be_AccountedFor)
							{
							print("<tr><td class='cnfHighLight'><a href='home.php?myflag=180&CODE=$row4->CnF_ID_to_be_AccountedFor&TM=$this->TM&SubCODE=$row->id&ImpRot=$row->Import_Rotation_No&MLine=$row->Line_No&MBL=$row->BL_No&TABINDX=0'>$row4->cnf_name<br>$row4->Address_1</a></td></tr>");
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
					
					<td valign="top"><?php print($igmMasterList[$i]['Remarks']); ?></td>
					<td valign="top"><?php print($igmMasterList[$i]['AFR']); ?></td>
					<td valign="top"><?php print($igmMasterList[$i]['delivery_block_stat']); ?></td>
					<td valign="top"><?php print($igmMasterList[$i]['int_block']); ?></td>
					<?php
						if($this->TM == "BB" || $this->TM == "BNIL" || $this->TM == "BTS")
						{
					?>
							<td valign="top"><?php print($igmMasterList[$i]['imco']); ?></td>
							<td valign="top"><?php print($igmMasterList[$i]['un']); ?></td>
					<?php
						}
						if($this->TM == "BAMS" || $this->TM == "BPS" || $this->TM == "AMS" || $this->TM == "PS")
						{
					?>
							<td valign="top"><?php print($igmMasterList[$i]['imco']); ?></td>
							<td valign="top"><?php print($igmMasterList[$i]['un']); ?></td>
							<td valign="top"><?php print($igmMasterList[$i]['extra_remarks']); ?></td>
					<?php
						}
					?>
					
					<?php if($_SESSION['Control_Panel']==12){?>
				<td valign="top"><a href='home.php?myflag=814&id=<?php print($igmMasterList[$i]['submitId']); ?>&tag=6&label=Refered Details&SubCODE=<?php print($igmMasterList[$i]['id']);?>&Type=GM'>View Refered</a></td>
					<?php }?>
					<?php
					$CODE=$igmMasterList[$i]['IGM_id'];
					?>
					<td valign="top"><a href="<?php echo site_url("igmViewController/myListFormS/$CODE/$id/$type") ?>" target='upper_top'>View Supplementary</a><br><hr>
					<!--<td valign="top"><a href='home.php?myflag=30&CODE=<?php print($igmMasterList[$i]['IGM_id']); ?>&SubCODE=<?php print($igmMasterList[$i]['id']); ?>&ImpRot=<?php print($igmMasterList[$i]['Import_Rotation_No']); ?>&MLine=<?php print($igmMasterList[$i]['Line_No']); ?>&MBL=<?php print($igmMasterList[$i]['BL_No']); ?>&TM=<?php print($this->TM); ?>' target='upper_top'>View Supplementary</a><br><hr>-->
					<!--<a href='home.php?myflag=6194&CODE=<?php print($row->IGM_id);?>&SUBCODE=<?php print($row->Import_Rotation_No);?>&TM=GM' style="color:blue">Upload IGM Sub(GM) from Excel File</a><br><hr></td>-->
	
	<?php
		
			
?>
				
					<?php if($_SESSION['Control_Panel']==81){?>
					<td valign="top"><a href='home.php?myflag=106&CODE=<?php print($row->IGM_id); ?>&SubCODE=<?php print($row->id); ?>&ImpRot=<?php print($row->Import_Rotation_No); ?>&MLine=<?php print($row->Line_No); ?>&MBL=<?php print($row->BL_No); ?>&TM=<?php print($this->TM); ?>&AFR=<?php print($row->AFR); ?>&AFO=<?php print($off)?>' target='upper_top'><?print($row->AFR);?></a></td>	
					<?php } ?>


					<?php if($_SESSION['Control_Panel']==11) {
						$org_id=$_SESSION['org_id'];
						if($row->Submitee_Org_Id == $org_id)
						{
						?>
					<td valign="top">
						<!-- <a href='home.php?myflag=1217&SubCODE=<?php print($row->id); ?>&ImpRot=<?php print($row->Import_Rotation_No); ?>&MLine=<?php print($row->Line_No); ?>&MBL=<?php print($row->BL_No); ?>&TM=<?php print($this->TM); ?>' target='upper_top' style="color:green">Add BL Documents</a><hr> -->
						<a href='home.php?myflag=300&CODE=<?php  print($row->id); ?>' target='upper_top' style="color:green">Submit Application for Navy Approval</a><hr>
						<a href='home.php?myflag=1201&CODE=<?php print($row->id);?>&TM=<?php print($row->type_of_igm);?>' style="color:green">Update&nbsp;Technical&nbsp;Remarks</a><hr>
					</td>	
					
				<?php } else {?>
				
					<td></td>
				<?php } }?>	

		<?php
		
		if($_SESSION['Control_Panel']==6)
		{
		// CNF------------Morshed-------------------------
		$_SESSION['migm_master_id']=$this->CODE;
		$_SESSION['morshed_flag']=1;
		
		print("<td valign='top'>");
			print("<table width=100%>");
				print("<tr><td><a href='home.php?myflag=110&CODE=$row->id&TM=$this->TM'>Submit Cross Match Information</a></td></tr>");
				print("<tr><td><a href='home.php?myflag=109&CODE=$row->id&TM=$this->TM'>Update Cross match information</a></td></tr>");
				print("<tr><td><a href='home.php?myflag=115&CODE=$row->id&TM=$this->TM'>View List Duration of Amendment Request and Approved</a></td></tr>");
				print("<tr><td><a href='home.php?myflag=107&CODE=$row->id&TM=$this->TM'>View Dispute List</a></td></tr>");
				print("<tr><td><a href='home.php?myflag=217&CODE=$row->id&TM=$this->TM'>Assign&nbsp;CnF</a></td></tr>");
						
			print("</table>");
		print("</td>");
		}

		if($_SESSION['Control_Panel']==10)
		{
		// Custom
			$_SEESION['req_id']=$row->id;
			print("<td valign='top'><a href='home.php?myflag=402&IGM_DET_ID=$row->id&TM=$this->TM&CODE=$this->CODE'>Submit Dispute</a><br><hr noshade><a href='home.php?myflag=403&dis_msg=sub&TM=$this->TM&detail_id=$row->id&CODE=$this->CODE'>View Dispute List</a><br><hr noshade><a href='home.php?myflag=409&req_id=$row->id&TM=$this->TM&CODE=$this->CODE'>View Amendment Request list</a><br><hr noshade><a href='home.php?myflag=411&req_id=$row->id&TM=$this->TM&CODE=$this->CODE'>Confirm Final Amendment</a><br><hr noshade><a href='home.php?myflag=415&detail_id=$row->id&TM=$this->TM&CODE=$this->CODE'>Send Change Request to Ship Agnt(Receive from C&F)</a></td>");

		}

		
		if($_SESSION['Control_Panel']==12)
		{
		// PORT
			/*   Close for new panel by shemul
			if($this->TM=="GM")
			{
				print("<td valign='top'><a href='home.php?myflag=508&CODE=$igmMasterList[$i]['id']&TM=$this->TM'>Update Cont. Discharge Status</a><br><hr noshade><a href='home.php?myflag=554&CODE=$igmMasterList[$i]['id']&TM=$this->TM'>Update Cont. Receive Status</a><br><hr noshade><a href='home.php?myflag=511&CODE=$igmMasterList[$i]['id']&TM=$this->TM'>Add Cont. Unstaffing</a><br><hr noshade><a href='home.php?myflag=505&CODE=$igmMasterList[$i]['id']&TM=$this->TM'>Update Cont. Delivery Status</a></td>");
			}
			else
			{
				print("<td valign='top'><a href='home.php?myflag=508&CODE=$igmMasterList[$i]['id']&TM=$this->TM'>Update Cont. Discharge Status</a><br><hr noshade><a href='home.php?myflag=554&CODE=$igmMasterList[$i]['id']&TM=$this->TM'>Update Cont. Receive Status</a><br><hr noshade><a href='home.php?myflag=511&CODE=$igmMasterList[$i]['id']&TM=$this->TM'>Add Cont. Unstaffing</a><br><hr><a href='home.php?myflag=505&CODE=$igmMasterList[$i]['id']&TM=$this->TM'>Update Cont. Delivery Status<a><br><hr noshade><a href='home.php?myflag=38&CODE=$igmMasterList[$i]['id']&TM=$this->TM&MCODE=$igmMasterList[$i]['IGM_id']&SFlag=0'>Update Break Bulk Discharge Status</a><br><hr noshade><a href='home.php?myflag=38&CODE=$igmMasterList[$i]['id']&TM=$this->TM&MCODE=$igmMasterList[$i]['IGM_id']&SFlag=0'>Update Break Bulk Delivery Status<a></td>");
			}
			*/
		
		}
		
		if($_SESSION['Control_Panel']==13)
		{
		// Of Dock
			if($this->TM=="GM")
			{
				print("<td valign='top'><a href='home.php?myflag=554&CODE=$row->id&TM=$this->TM'>Update Cont. Receive Status</a><br><hr noshade><a href='home.php?myflag=505&CODE=$row->id&TM=$this->TM'>Update Cont. Delivery Status</a></td>");
			}
			else
			{	
				print("<td valign='top'><a href='home.php?myflag=554&CODE=$row->id&TM=$this->TM'>Update Cont. Receive Status</a><br><hr noshade><a href='home.php?myflag=505&CODE=$row->id&TM=$this->TM'>Update Cont. Delivery Status</a><br><hr noshade><a href='home.php?myflag=38&CODE=$row->id&TM=$this->TM&MCODE=$row->IGM_id&SFlag=0'>Update Break Bulk Discharge Status</a><br><hr noshade><a href='home.php?myflag=38&CODE=$row->id&TM=$this->TM&MCODE=$row->IGM_id&SFlag=0'>Update Break Bulk Delivery Status</a></td>");			
			}

		}
		
		
/*
if($_SESSION['Control_Panel']==14)
		{
		// Importer
			print("<td valign='top'>");
			print("<table width=100%>");
				print("<tr><td><a href='home.php?myflag=110&CODE=$row->id&TM=$this->TM'>Submit Cross Match Information</a></td></tr>");
				print("<tr><td><a href='home.php?myflag=109&CODE=$row->id&TM=$this->TM'>Update Cross match information</a></td></tr>");
				print("<tr><td><a href='home.php?myflag=115&CODE=$row->id&TM=$this->TM'>View List Duration of Amendment Request and Approved</a></td></tr>");
				print("<tr><td><a href='home.php?myflag=107&CODE=$row->id&TM=$this->TM'>View Dispute List</a></td></tr>");
				print("<tr><td><a href='home.php?myflag=217&CODE=$row->id&TM=$this->TM'>Assign CnF</a></td></tr>");
			print("</table>");
			print("</td>");
		
		} */
		
		if($_SESSION['Control_Panel']==10 || $_SESSION['Control_Panel']==44 || $_SESSION['Control_Panel']==12)
		{
		// Navy
			
			//print("<td>Comments</td>")			
			//print("<td valign='top'>$row->navy_response_to_port</td>");
			
		}
		
		if( $_SESSION['Control_Panel']==12)
		{
		
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
			
		}
		
		if( $_SESSION['Control_Panel']==10)
		{
		// Custom
					
			if($row->final_amendment==2)
			{
				print("<td valign='top'>
							LabComments:$row->response_details1<br>
							NAIO Comments:$row->response_details2<br>
							$row->hold_application</td>");
			}
			else if($row->final_amendment==3)
			{
				print("<td valign='top'>
							LabComments:$row->response_details1<br>
							NAIO Comments:$row->response_details2<br>
							$row->rejected_application</td>");
			}
			else if($row->to_custom != "" and $row->response_details3 == "")
			{		
				print("<td valign='top'>$row->to_custom</td>");
			}
			else if($row->final_amendment==1)
			{	
				print("<td>LabComments:$row->response_details1<br>
						   NAIO Comments:$row->response_details2<br>		
						   Finally:$row->response_details3</td>");
			}
			else
			{
				print("<td valign='top'></td>");
			}
		}
		
		if($_SESSION['Control_Panel']==44)
		{
		// Navy			
			print("<td valign='top'><a href='home.php?myflag=56&CODE=$row->id&TM=$this->TM'>Update Comments</a></td>");		
			
		}		
		?>
		

					
					<td><a href="<?php echo site_url('report/viewDeliveryOrder/'.$igmMasterList[$i]['BL_No'].'/'.str_replace("/","_",$igmMasterList[$i]['Import_Rotation_No'])) ?>" target="_BLANK">View Report</td>
					</tr>
		<?php	
			}
		
		}
		?>
<TR><TD><p><?php echo $links; ?></p></TD></TR>
</table>
<?php mysql_close($con_cchaportdb);?>