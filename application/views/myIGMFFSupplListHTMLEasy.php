<?php
/*****************************************************
Developed BY: Nisho
Software Engineer 
DataSoft Systems Bangladesh Ltd
******************************************************/
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
			
			if (validate_required(txt_serch,"Please Type Your Text to Search")==false)
				{return false;}
			if (validate_required(rot_search,"Please select Your Rotation No")==false)
				{return false;}	
			
				
				
		}
	}
</script>
<?php
$this->TM=$type;
$this->MCODE=$MCODE;
$this->CType=$CType;
$_SESSION['Control_Panel']=$this->session->userdata('Control_Panel');
$_SESSION['org_id']=$this->session->userdata('org_id');
include("mydbPConnection.php");
?>

<table border="0" width="100%">
	
	
	<TR align="center"><TD colspan="4" class="formCaption"><h2><span><?php print($title."(".$this->TM.")"); ?></span><h2></TD></TR>
	<TR align="left"><TD colspan="6" ><a href="<?php echo site_url('igmViewController/myPanelView') ?>"><img src="<?php echo IMG_PATH; ?>back.png" height="40px" width="40px" align="middle" hspace="5"/>Back to Control Panel</a></TD></TR>
	<TR><TD class="onlyTable"><?php 
		$str="select distinct Import_Rotation_No From igm_masters 
		WHERE id=$this->MCODE";
	//	print($str);
		$result_rotationno = mysql_query($str);
		$row_rotationno=mysql_fetch_object($result_rotationno);
	print("<b>IMPORT ROTATION NO : ".$row_rotationno->Import_Rotation_No."</b>"); ?></TD></TR>
	</table>
<br>
<table border="1" cellspacing="0" cellpadding="0" >
<tr>

<?php
//cus&mlo

if(($_SESSION['Control_Panel']==10) || ($_SESSION['Control_Panel']==7))
{

?>		
<td>
	
<table border="0">
			<td  id="lbl_org_id12"  class="onlyTable1">
			<form name="frmff" action="home.php" method="post">
					<input type="hidden" name="myflag" value="50">					
					<input type="hidden" name="MCODE" value="<?php print($this->MCODE); ?>">	
					<input type="hidden" name="TM" value="<?php print($this->TM); ?>">
					
			<input type="hidden" name="txt_SFlag" value="<?php print($this->SFlag); ?>">		
			<input type="hidden" name="txt_ROTATION" value="<?php print($row_rotationno->Import_Rotation_No); ?>">
			Search&nbsp;for&nbsp;FF:&nbsp;	
				<select name="txt_Org_Id_for_search"  maxlength="50" onFocus="gsLabelObj(lbl_org_id12,'#61BCEF','white')" onBlur="gsLabelObj(lbl_org_id12,'','')">
					<?php
						$resultcombo = mysql_query("SELECT id,Organization_Name  FROM organization_profiles where Org_Type_id=4  ORDER BY Organization_Name");
						while ($rowcombo = mysql_fetch_object($resultcombo)){
					?>
					<option value="<?php print($rowcombo->id);?>" <?php if($myedit=="yes") { if($rowcombo->id==$rowcombo->id) print('selected'); } ?> ><?php print($rowcombo->Organization_Name);?></option>
					<?php	
					}	
					?>
				</select>&nbsp;&nbsp;			
			<select name="lbl_search">
							<option value="1">Consignee</option>
							<option value="2">Notify</option>							
			</select>&nbsp;&nbsp;			
			<input type="submit" name="btn_serch1" value="GO!">	
</form>
</td>
</table>

</td>
<td>

<table>

<td  id="lbl_org_id13"  class="onlyTable1">
				<form name="frmCnF" action="home.php" method="post">
					<input type="hidden" name="myflag" value="51">					
					<input type="hidden" name="txt_ccc" value="<?php print($this->MCODE); ?>">					
					<input type="hidden" name="txt_TMccc2" value="<?php print($this->TM); ?>">	
					<input type="hidden" name="txt_SFlagcc" value="<?php print($this->SFlag); ?>">	
<input type="hidden" name="txt_ROTATION" value="<?php print($row_rotationno->Import_Rotation_No); ?>">
					Search&nbsp;for&nbsp;C&nbsp;&amp;&nbsp;F:&nbsp;&nbsp;
				<select name="txt_Org_Id_for_cnfcc"  maxlength="50" onFocus="gsLabelObj(lbl_org_id13,'#61BCEF','white')" onBlur="gsLabelObj(lbl_org_id13,'','')">
					<?php
						$resultcombo2 = mysql_query("SELECT id,Organization_Name  FROM organization_profiles where Org_Type_id=2  ORDER BY Organization_Name");
						while ($rowcombo2 = mysql_fetch_object($resultcombo2)){
					?>
					<option value="<?php print($rowcombo2->id);?>" <?php if($myedit=="yes") { if($rowcombo2->id==$rowcombo2->id) print('selected'); } ?> ><?php print($rowcombo2->Organization_Name);?></option>
					<?php	
					}	
					?>
				</select>&nbsp;&nbsp;<input type="submit" name="btn_serch2" value="GO!">	
				</form>
				</td>
</td>
</table>

</td>
<td>

<table>

<td  id="lbl_org_id14"  class="onlyTable1">
				<form name="frmofdock" action="home.php" method="post">
					<input type="hidden" name="myflag" value="52">					
					<input type="hidden" name="txt_ccc7" value="<?php print($this->MCODE); ?>">					
					<input type="hidden" name="txt_TMccc22" value="<?php print($this->TM); ?>">	
					<input type="hidden" name="txt_SFlagcc7" value="<?php print($this->SFlag); ?>">
<input type="hidden" name="txt_ROTATION" value="<?php print($row_rotationno->Import_Rotation_No); ?>">	
					Search&nbsp;Dock:&nbsp;&nbsp;
				<select name="txt_Org_Id_for_cnfcc7"  maxlength="50" onFocus="gsLabelObj(lbl_org_id14,'#61BCEF','white')" onBlur="gsLabelObj(lbl_org_id14,'','')">
					<?php
						$resultcombo3 = mysql_query("SELECT id,Organization_Name  FROM organization_profiles where Org_Type_id=5 or Org_Type_id=6 ORDER BY Organization_Name");
						while ($rowcombo3 = mysql_fetch_object($resultcombo3)){
					?>
					<option value="<?php print($rowcombo3->id);?>" <?php if($myedit=="yes") { if($rowcombo3->id==$rowcombo3->id) print('selected'); } ?> ><?php print($rowcombo3->Organization_Name);?></option>
					<?php	
					}	
					?>
				</select>&nbsp;&nbsp;<input type="submit" name="btn_serch3" value="GO!">	
				</form>
				</td>
</td>
</table>

</td>
<?php
}
?>	
	

	
		
<?php
//start for FF
if($_SESSION['Control_Panel']==11) 
{
?>
<td  id="lbl_org_id15"  class="onlyTable1">
		<form name="frmff1" action="home.php" method="post">
		<input type="hidden" name="myflag" value="47">		
		<input type="hidden" name="MCODE" value="<?php print($this->MCODE); ?>">	
		<input type="hidden" name="TM" value="<?php print($this->TM); ?>">
		Search&nbsp;By:&nbsp;
		<select name="CType" onFocus="gsLabelObj(lbl_org_id15,'#61BCEF','white')" onBlur="gsLabelObj(lbl_org_id15,'','')">
				<option value="C">Consignee</option>
				<option value="N">Notify</option>							
		</select>			
		<input type="submit" name="btn_serch4" value="GO!">	
		</form>
</td>
<?php
}
//end ff
?>

<?php
//start for FF
if(($_SESSION['Control_Panel']==44) ||($_SESSION['Control_Panel']==7)||($_SESSION['Control_Panel']==10))
{
?>
<td>
		<table>
		<tr>
			<td  id="lbl_org_id16"  class="onlyTable1">						
								<form name="frmnavyicd" action="home.php" method="post" onsubmit="return validate_form(this)">
					<input type="hidden" name="myflag" value="49">					
						<input type="hidden" name="MCODE" value="<?php print($this->MCODE); ?>">	
						<input type="hidden" name="TM" value="<?php print($this->TM); ?>">
						<input type="hidden" name="txt_SFlag" value="<?php print($this->SFlag); ?>">
<input type="hidden" name="txt_ROTATION" value="<?php print($row_rotationno->Import_Rotation_No); ?>">
						Search&nbsp;By:&nbsp;
						
						<select name="lbl_search" onFocus="gsLabelObj(lbl_org_id16,'#61BCEF','white')" onBlur="gsLabelObj(lbl_org_id16,'','')">
							<option value="1">DG Cargo</option>
							<option value="2">IMCO</option>							
						</select>
						<input type="text" name="txt_serch" value="" maxlength="50" style="width:150px">
						<input type="submit" name="btn_serch5" value="GO!">
				</form>
			</td>
		</tr>
	</table>	
</td>
<?php
}
//end ff
?>

<?php
//start for FF
if(($_SESSION['Control_Panel']==6) )
{
?>
<td>
		<table>
		<tr>
			<td  id="lbl_org_id16"  class="onlyTable1">						
								<form name="frmnavyicd" action="home.php" method="post" onsubmit="return validate_form(this)">
					<input type="hidden" name="myflag" value="55">					
						<input type="hidden" name="MCODE" value="<?php print($this->MCODE); ?>">	
						<input type="hidden" name="TM" value="<?php print($this->TM); ?>">
						<input type="hidden" name="txt_SFlag" value="<?php print($this->SFlag); ?>">
<input type="hidden" name="txt_ROTATION" value="<?php print($row_rotationno->Import_Rotation_No); ?>">
						Search&nbsp;By:&nbsp;
						
						<select name="lbl_search" onFocus="gsLabelObj(lbl_org_id16,'#61BCEF','white')" onBlur="gsLabelObj(lbl_org_id16,'','')">
							<option value="1">Consignee</option>
							<option value="2">Notify</option>							
						</select>
						<input type="text" name="txt_serch" value="" maxlength="50" style="width:150px">
						<input type="submit" name="btn_serch5" value="GO!">
				</form>
			</td>
		</tr>
	</table>	
</td>
<?php
}
//end ff
?>


<?php
//print $str;
?>
<td>

<table>
		<tr>
				
			<td  id="lbl_org_id17"  class="onlyTable1">

					<!--<form name="frmgn" action="home.php" method="post" onsubmit="return validate_form(this)">-->
					<?php
						echo form_open('igmViewController/myListSearchFFByLineBL');
						$Stylepadding = 'style="padding: 12px 20px;"';
						if(!empty($error_message))
						{
							$Stylepadding = 'style="padding:25px 20px;"';
						}	
						if(isset($captcha_image)){
							$Stylepadding = 'style="padding:62px 20px 93px;"';
						}
					?>
						<b>Rotaion No:</b>
						<select name="rot_search">
							<option value="<?php echo $row_rotationno->Import_Rotation_No; ?>"><?php echo $row_rotationno->Import_Rotation_No; ?></option>
						</select>
						
						
						<input type="hidden" name="myflag" value="48">					
							<input type="hidden" name="CType" value="<?php print($this->CType); ?>">
						<input type="hidden" name="MCODE" value="<?php print($this->MCODE); ?>">	
						<input type="hidden" name="master_id" value="<?php print($igmMasterList[$i]['igm_master_id']); ?>">	
						<input type="hidden" name="TM" value="<?php print($this->TM); ?>">
						<input type="hidden" name="txt_SFlag" value="<?php print($this->SFlag); ?>">	
<input type="hidden" name="txt_ROTATION" value="<?php print($row_rotationno->Import_Rotation_No); ?>">
						<b>Search&nbsp;By:&nbsp;</b>
						<select name="lbl_search" onFocus="gsLabelObj(lbl_org_id17,'#61BCEF','white')" onBlur="gsLabelObj(lbl_org_id17,'','')">
							<option value="1">B/L No</option>
							<option value="2">Line No</option>
							<option value="3">Container No</option>
						</select>
						<input type="text" name="txt_serch" value="" maxlength="50" style="width:150px">
						<!--<input type="submit" name="btn_serch6" value="GO!">-->
						<?php $arrt3 = array('name'=>'btn_serch6','id'=>'submit3','value'=>'GO!','class'=>'login_button'); echo form_submit($arrt3);?>
				</form>
			</td>
			<td  id="lbl_org_id133"  class="onlyTable1">
			<!--	<form name="frmCnF" action="home.php" method="post">-->
			<?php
						echo form_open('igmViewController/myListSearchFFByFF');
						$Stylepadding = 'style="padding: 12px 20px;"';
						if(!empty($error_message))
						{
							$Stylepadding = 'style="padding:25px 20px;"';
						}	
						if(isset($captcha_image)){
							$Stylepadding = 'style="padding:62px 20px 93px;"';
						}
					?>
					<input type="hidden" name="myflag" value="1003">					
					<input type="hidden" name="txt_ccc" value="<?php print($this->MCODE); ?>">					
					<input type="hidden" name="txt_TMccc2" value="<?php print($this->TM); ?>">	
					<input type="hidden" name="txt_ROTATION" value="<?php print($row_rotationno->Import_Rotation_No); ?>">
					<b>IGM&nbsp;Supplementary&nbsp;Submitted&nbsp;by&nbsp;FF:&nbsp;</b>
				<select name="txt_Org_Id_for_submittedFF"  maxlength="50" onFocus="gsLabelObj(lbl_org_id133,'#61BCEF','white')" onBlur="gsLabelObj(lbl_org_id133,'','')">
					<?php
					if($_SESSION['Control_Panel']==10 or $_SESSION['Control_Panel']==12)
					{
					$resultcombo2 = mysql_query("select distinct Submitee_Org_Id as id,organization_profiles.Organization_Name from igm_supplimentary_detail  igms 
						inner join organization_profiles on igms.Submitee_Org_Id = organization_profiles.id
						WHERE igms.igm_master_id=$this->MCODE and type_of_igm='$this->TM' and igms.final_submit=1 ORDER BY Organization_Name");
					}
					else
					$resultcombo2=mysql_query("select id,Organization_Name from organization_profiles where Org_Type_id='4' order by Organization_Name");
					
						
						
						while ($rowcombo2 = mysql_fetch_object($resultcombo2)){
					?>
					<option value="<?php print($rowcombo2->id);?>" <?php if($myedit=="yes") { if($rowcombo2->id==$rowcombo2->id) print('selected'); } ?> ><?php print($rowcombo2->Organization_Name);?></option>
					<?php	
					}	
					?>
				</select>&nbsp;&nbsp;
				<!--<input type="submit" name="btn_serch2" value="View Supplementary!">	-->
				<?php $arrt3 = array('name'=>'btn_serch2','id'=>'submit3','value'=>'View!','class'=>'login_button'); echo form_submit($arrt3);?>
				</form>
				</td>
		</tr>
	</table>	
	
</td>
</tr>
</table>

<table border="1" >
		<tr>		

				<!--<td>
				<span class="style15">
					<a href='home.php?myflag=36&CODE=<?php print($this->MCODE); ?>&TM=<?php print($this->TM); ?>&TYPE=FCL&ORG_Id=<? print($_SESSION['org_id']); ?>' style="color:green;font-size:12.0px"><img src="image/add.png" border="0" height="25" width="35">View Classified IGM(FCL)</a>
					&nbsp;&nbsp;|&nbsp;&nbsp;
					<a href='home.php?myflag=36&CODE=<?php print($this->MCODE); ?>&TM=<?php print($this->TM); ?>&TYPE=LCL&ORG_Id=<? print($_SESSION['org_id']); ?>' style="color:green;font-size:12.0px"><img src="image/add.png" border="0" height="25" width="35">View Classified IGM(LCL)</a>
				</span>	
				</td>-->

</table>


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
			<td valign="top">Shipping&nbsp;Agent&nbsp;Name</td>
			<td valign="top">Import Rotation No</td>
			<td valign="top">Line&nbsp;No.</td>
			<td valign="top">HBL</td>
			<td valign="top">Number/Quantity</td>
			<td valign="top">Kind of Package</td>
			<td valign="top">Gross Weight</td>
			<td valign="top">Net Weight</td>
			<td valign="top">Marks&nbsp;&&nbsp;Number</td>
			<td valign="top">Description&nbsp;Of&nbsp;Goods</td>
			<!--<td valign="top">Date&nbsp;Of&nbsp;Entry&nbsp;of&nbsp;Goods</td>-->
			<!--<td valign="top">Net Weight</td>	
			<td valign="top">Gross Weight</td>	-->				
			<td valign="top">Container&nbsp;Detail</td>		
			<td valign="top">Consignee&nbsp;and&nbsp;Notify&nbsp;Party</td>
			<td valign="top">Bill&nbsp;Of&nbsp;Entry&nbsp;Number</td>
			<td valign="top">Bill&nbsp;Of&nbsp;Entry&nbsp;Date</td>
			<td valign="top">Delivered</td>
			<td valign="top">Discharged</td>
			<td valign="top">C&&nbsp;F&nbsp;Agent&nbsp;For</td>
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

		if($_SESSION['Control_Panel']==11)
		{
		// Freight_Forwarder
			print("<td>Accessibility for Navy</td>");
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
		
		
/*
if($_SESSION['Control_Panel']==14)
		{
		// Importer
			print("<td>Accessibility</td>");
		} */


		if($_SESSION['Control_Panel']==15)
		{
		// Exporter
			print("<td>Accessibility</td>");
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
				
					
				?>
			
			    <tr class='gridLight'>
		<td valign="top"><?php print($igmMasterList[$i]['Agent_Name'].'<br>'.'AIN NO: '.$igmMasterList[$i]['AIN_No']); ?></td>
					<td valign="top"><?php print($igmMasterList[$i]['Import_Rotation_No']); ?></td>
					<td valign="top"><?php print($igmMasterList[$i]['Line_No']); ?></td>
					<td valign="top"><?php print($mbldata1); ?></td>
					<td valign="top"><?php print($igmMasterList[$i]['Pack_Number']); ?></td>					
					<td valign="top"><?php print($igmMasterList[$i]['Pack_Description']); ?></td>	
					<td valign="top"><?php print($igmMasterList[$i]['weight'].' '.$igmMasterList[$i]['weight_unit']); ?></td>				
					<td valign="top"><?php print($igmMasterList[$i]['net_weight'].' '.$igmMasterList[$i]['net_weight_unit']); ?></td>
										
					<td valign="top"><?php print($igmMasterList[$i]['Pack_Marks_Number']); ?></td>
					<td valign="top"><?php print($igmMasterList[$i]['Description_of_Goods']); ?></td>
					<!--<td valign="top"><?php print($igmMasterList[$i]['Date_of_Entry_of_Goods']); ?></td>--->
					
					<!--<td valign="top"><?php print($igmMasterList[$i]['net_weight']." ".$igmMasterList[$i]['net_weight_unit']); ?></td>
					<td valign="top"><?php print($igmMasterList[$i]['weight']." ".$igmMasterList[$i]['weight_unit']); ?></td>-->
					
					
				
					<td align="left" valign="top">
					
					<table width="100%">
					<tr><td>Offdock</td><td>Cnt.&nbsp;Number</td><td>Seal&nbsp;Number</td><td>Size</td><td>Type</td><td>ISO Code</td><td>Height</td><td>Weight</td><td>Cont.GW</td><td>IMCO</td><td>UN</td><td>Status</td><td>Tech Desc.</td></tr>
					<?php 
					//load container detail
		//print("select cnt.id as id,cnt.cont_number as cont_number,cnt.cont_size as cont_size,cnt.cont_type as cont_type,cnt.cont_height as cont_height,cnt.cont_status as cont_status,cnt.cont_weight as cont_weight,cnt.cont_seal_number as cont_seal_number,cnt.cont_description as cont_description,cnt.cont_imo as imco,cnt.cont_un as un,cnt.technical_desc,Organization_Name from igm_sup_detail_container cnt inner join organization_profiles on cnt.off_dock_id=organization_profiles.id where cnt.igm_sup_detail_id=$row->id");

if($CType=="FF" or $CType=="FFnosubmit")
 $Table_List[3]="igm_sup_detail_container";
					$id=$igmMasterList[$i]['id'];
						
						$result1 = mysql_query("select cnt.id as id,cnt.cont_number as cont_number,cnt.cont_size as cont_size,cnt.cont_iso_type as cont_iso_type,cnt.cont_type 
as cont_type,cnt.cont_height as cont_height,cnt.cont_status as cont_status,cnt.cont_weight 
as cont_weight,cnt.cont_gross_weight,cnt.cont_seal_number as cont_seal_number,cnt.cont_description as 
cont_description,cnt.cont_imo as imco,cnt.cont_un as un,cnt.technical_desc,Organization_Name
from  igm_sup_detail_container cnt inner join organization_profiles on 
cnt.off_dock_id=organization_profiles.id where cnt.igm_sup_detail_id=$id");						
						

						while($row1 = mysql_fetch_object($result1)) {
							print("<tr><td>$row1->Organization_Name</td><td>$row1->cont_number</td><td>$row1->cont_seal_number</td><td>$row1->cont_size</td><td>$row1->cont_type</td><td>$row1->cont_iso_type</td><td>$row1->cont_height</td><td>$row1->cont_weight</td><td>$row1->cont_gross_weight</td><td>$row1->imco</td><td>$row1->un</td><td>$row1->cont_status</td><td>$row1->technical_desc</td></tr>");	
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
						$result2 = mysql_query("select cons.id,cons.igm_sup_detail_id,cons.Consignee_ID,(select org.Organization_Name from organization_profiles org where org.id=cons.Consignee_ID) as consignee_name,(select org1.Address_1 from organization_profiles org1 where org1.id=cons.Consignee_ID) as Address_1,cons.ff_clearance as ff_clearance from igm_sup_detail_consigneetabs cons where cons.igm_sup_detail_id=$id");						
						
						while($row2 = mysql_fetch_object($result2)) {
						if($_SESSION['org_id']==$row2->Consignee_ID)
							{
								if($row2->ff_clearance==1)
								{
								print("<tr><td align='left' class='notifyHighLight'><a href='home.php?myflag=340&CODE=$row->id&MCODE=$row->igm_master_id&SubCODE=$row->igm_detail_id&SSubCODE=$row->id&ImpRot=$row->Import_Rotation_No&MLine=$row->master_Line_No&MBL=$row->master_BL_No&MSLine=$row->Line_No&MSBL=$row->BL_No&TM=$row->type_of_igm&SFlag=1' target='upper_top'>$row2->consignee_name<br>$row2->Address_1</a></td></tr>");	
								print("<tr><td><hr noshade></td></tr>");
								}
								else
								{
								$altm='javascript:alert("You need clearance to submit Supplementary IGM")';
								print("<tr><td align='left'><a href='$altm' target='upper_top'>$row2->consignee_name<br>$row2->Address_1</a></td></tr>");	
								print("<tr><td><hr noshade></td></tr>");								
								}
							}

						


	
						}
						mysql_free_result($result2);	
						
					?>
					<tr><td><?php print($igmMasterList[$i]['ConsigneeDesc']); ?></td></tr>
					<tr><th align="left">Notify Party :</th></tr>
					
					<?php 
					// load notify
						$str="select notf.id,notf.igm_sup_detail_id,notf.Notify_ID,(select org.Organization_Name from organization_profiles org where org.id=notf.Notify_ID) as notify_name,(select org1.Address_1 from organization_profiles org1 where org1.id=notf.Notify_ID) as Address_1,notf.ff_clearance as ff_clearance from igm_sup_detail_notifytabs notf where notf.igm_sup_detail_id=$row->id";
						//print("notify:".$str);
						$result3 = mysql_query($str);
											
						
						while($row3 = mysql_fetch_object($result3)) {

							//print($_SESSION['org_id']."12");	
							//print($row3->Notify_ID."34");

							if($_SESSION['org_id']==$row3->Notify_ID)
							{
								if($row3->ff_clearance==1)
								{
									print("<tr><td align='left' class='notifyHighLight'><a href='home.php?myflag=340&CODE=$row->id&MCODE=$row->igm_master_id&SubCODE=$row->igm_detail_id&SSubCODE=$row->id&ImpRot=$row->Import_Rotation_No&MLine=$row->master_Line_No&MBL=$row->master_BL_No&MSLine=$row->Line_No&MSBL=$row->BL_No&TM=$row->type_of_igm&SFlag=1' target='upper_top'>$row3->notify_name<br>$row3->Address_1</a></td></tr>");	
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
					
					<td valign="top"><a href='Forms/myBillEntryImportReportHTML.php?reg=<?php print($igmMasterList[$i]['Bill_of_Entry_No']);?>&date=<?php print($igmMasterList[$i]['Bill_of_Entry_Date']);?>&code=<?php print($igmMasterList[$i]['office_code']);?>' target="aboutblank"><?php print($igmMasterList[$i]['Bill_of_Entry_No']);?></a></td>
					<td valign="top"><?php print($igmMasterList[$i]['Bill_of_Entry_Date']); ?></td>
					<td valign="top"><?php print($igmMasterList[$i]['No_of_Pack_Delivered']); ?></td>
					<td valign="top"><?php print($igmMasterList[$i]['No_of_Pack_Discharged']); ?></td>
				
					<td align="left" valign="top">
					
					<table width="100%">					
					<?php 
					// load CnF
						
						/*$result4 = mysql_query("select cnf.id,cnf.igm_sup_detail_id,cnf.CnF_ID_to_be_AccountedFor as CnF_ID_to_be_AccountedFor,(select org.Organization_Name from organization_profiles org where org.id=cnf.CnF_ID_to_be_AccountedFor) as cnf_name,(select org1.Address_1 from organization_profiles org1 where org1.id=cnf.CnF_ID_to_be_AccountedFor) as Address_1 from igm_sup_detail_cnftabs cnf where cnf.igm_sup_detail_id=$row->id");*/


                                                $result4 = mysql_query("select cnf.id,cnf.igm_detail_id,cnf.CnF_ID_to_be_AccountedFor as CnF_ID_to_be_AccountedFor,(select org.Organization_Name from organization_profiles org where org.id=cnf.CnF_ID_to_be_AccountedFor) as cnf_name,(select org1.Address_1 from organization_profiles org1 where org1.id=cnf.CnF_ID_to_be_AccountedFor) as Address_1,(select org.AIN_No from organization_profiles org where org.id=cnf.CnF_ID_to_be_AccountedFor) as AIN_No from igm_detail_cnftabs cnf where cnf.igm_detail_id=$id");							
						
						while($row4 = mysql_fetch_object($result4)) {
							
							if($_SESSION['org_id']==$row4->CnF_ID_to_be_AccountedFor)
							{
							print("<tr><td class='cnfHighLight'><a href='home.php?myflag=180&CODE=$row4->CnF_ID_to_be_AccountedFor&TM=$this->TM&SubCODE=$row->id&ImpRot=$this->ImpRot&MLine=$row->Line_No&MBL=$row->BL_No&TABINDX=1'>$row4->cnf_name<br>$row4->Address_1</a></td></tr>");
							}
							else
							{
							print("<tr><td align='left'>$row4->cnf_name<br>$row4->Address_1<br> AIN NO: $row4->AIN_No</td></tr>");	
							}
							print("<tr><td><hr noshade></td></tr>");
						}
						mysql_free_result($result4);	
						
					?>
					</table>
					
					</td>
					
					<td><?php print($igmMasterList[$i]['Remarks']); ?></td>
					
					<td><a href='home.php?myflag=40&CODE=<?php print($igmMasterList[$i]['id']); ?>&MCODE=<?php print($igmMasterList[$i]['igm_master_id']); ?>&SubCODE=<?php print($igmMasterList[$i]['igm_detail_id']); ?>&SSubCODE=<?php print($igmMasterList[$i]['id']); ?>&ImpRot=<?php print($igmMasterList[$i]['Import_Rotation_No']); ?>&MLine=<?php print($igmMasterList[$i]['master_Line_No']); ?>&MBL=<?php print($igmMasterList[$i]['master_BL_No']); ?>&MSLine=<?php print($igmMasterList[$i]['Line_No']); ?>&MSBL=<?php print($igmMasterList[$i]['BL_No']); ?>&TM=<?php print($this->TM); ?>&SFlag=1' target='upper_top'>View Supplementary</a></td>					

		<?php
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
			} else {?>
				<td></td>
		<?php }?>

		
					<?php if($_SESSION['Control_Panel']==11) {
						$org_id=$_SESSION['org_id'];
						//print($org_id."<br>");
						//print($row->Submitee_Org_Id);
						if($row->Submitee_Org_Id != $org_id)
						{
						?>
					<td valign="top">
						<!-- <a href='home.php?myflag=1217&SubCODE=<?php print($row->id); ?>&ImpRot=<?php print($row->Import_Rotation_No); ?>&MLine=<?php print($row->Line_No); ?>&MBL=<?php print($row->BL_No); ?>&TM=<?php print($this->TM); ?>' target='upper_top' style="color:green">Add BL Documents</a><hr> -->
						<a href='home.php?myflag=300&CODE=<?php  print($row->id); ?>' target='upper_top' style="color:green">Submit Application for Navy Approval</a><hr>
						 <a href='home.php?myflag=1201&CODE=<?php print($row->id);?>&TM=<?php print($this->TM); ?>' style="color:green">Update&nbsp;Technical&nbsp;Remarks</a><hr>
					

						<?php
										if(($this->TM=="GM" or $this->TM=="TS"  or $this->TM=="ROB"  or $this->TM=="MT" or $this->TM=="BB"))
										{
										?>
										<a href='home.php?myflag=6195&CODE=<?php print($row->igm_master_id);?>&SUBCODE=<?php print($row->Import_Rotation_No);?>&TM=<?php print($this->TM);?>' style="color:blue">Upload Sup(Co-loader)Igm <?php print("(".$this->TM.")");?> From Excel File</a><br><hr>

	
					<?php
							}?>		

				</td>	
					
				<?php } else { ?>
				<td><td>
				<?php } }?>


			
		<?php
		
		if($_SESSION['Control_Panel']==6)
		{
			$_SESSION['morshed_sup']=1;
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
			print("<td><a href='home?myflag=406&Id_Detail=$row->id&TM=$this->TM'>Submit Dispute</a><br><hr noshade><a href='home.php?myflag=403&dis_msg=sup&TM=$this->TM&detail_id=$row->id'>View Dispute List</a><br><hr noshade><a href='home.php?myflag=417&sup_detail_id=$row->id&TM=$this->TM'>View Suplimentary Amendment Request list</a><br><hr noshade><a href='home?myflag=419&sup_detail_id=$row->id&TM=$this->TM'>Confirm Final Amendment</a><br><hr noshade><a href='home?myflag=421&sup_detail_id=$row->id&TM=$this->TM'>Send Change Request to Ship Agnt(Receive from C&F)</a></td>");
		}
		
		if($_SESSION['Control_Panel']==12)
		{
		// PORT
			if($this->TM=="GM")
			{
				print("<td><a href='home.php?myflag=518&CODE=$row->id&TM=$this->TM'>Update Cont. Discharge Status</a><br><hr noshade><a href='home.php?myflag=521&CODE=$row->id&TM=$this->TM'>Add Cont. Unstaffing</a><br><hr noshade><a href='home.php?myflag=515&CODE=$row->id&TM=$this->TM'>Update Cont. Delivery Status</a></td>");   
			}
			else
			{
				print("<td><a href='home.php?myflag=518&CODE=$row->id&TM=$this->TM'>Update Cont. Discharge Status</a><br><hr noshade><a href='home.php?myflag=521&CODE=$row->id&TM=$this->TM'>Add Cont. Unstaffing</a><br><hr><a href='home.php?myflag=515&CODE=$row->id&TM=$this->TM'>Update Cont. Delivery Status</a><br><hr noshade><a href='home.php?myflag=39&CODE=$row->id&MCODE=$this->CODE&SubCODE=$this->SubCODE&ImpRot=$this->ImpRot&MLine=$this->MLine&MBL=$this->MBL&TM=$this->TM&DV=DS&SFlag=$this->SFlag'>Update Break Bulk Discharge Status</a><br><hr noshade><a href='home.php?myflag=39&CODE=$row->id&MCODE=$this->CODE&SubCODE=$this->SubCODE&ImpRot=$this->ImpRot&MLine=$this->MLine&MBL=$this->MBL&TM=$this->TM&DV=DL&SFlag=$this->SFlag'>Update Break Bulk Delivery Status</a></td>");   
			}

		}
		
		if($_SESSION['Control_Panel']==13)
		{
		// Of Dock
			if($this->TM=="GM")
			{		
				print("<td><a href='home.php?myflag=518&CODE=$row->id&TM=$this->TM'>Update Cont. Discharge Status</a><br><hr noshade><a href='home.php?myflag=521&CODE=$row->id&TM=$this->TM'>Add Cont. Unstaffing</a><br><hr noshade><a href='home.php?myflag=515&CODE=$row->id&TM=$this->TM'>Update Cont. Delivery Status</a></td>");    
			}
			else
			{
				print("<td><a href='home.php?myflag=518&CODE=$row->id&TM=$this->TM'>Update Cont. Discharge Status</a><br><hr noshade><a href='home.php?myflag=521&CODE=$row->id&TM=$this->TM'>Add Cont. Unstaffing</a><br><hr noshade><a href='home.php?myflag=515&CODE=$row->id&TM=$this->TM'>Update Cont. Delivery Status</a><br><hr noshade><a href='home.php?myflag=39&CODE=$row->id&MCODE=$this->CODE&SubCODE=$this->SubCODE&ImpRot=$this->ImpRot&MLine=$this->MLine&MBL=$this->MBL&TM=$this->TM&DV=DS&SFlag=$this->SFlag'>Update Break Bulk Discharge Status</a><br><hr><a href='home.php?myflag=39&CODE=$row->id&MCODE=$this->CODE&SubCODE=$this->SubCODE&ImpRot=$this->ImpRot&MLine=$this->MLine&MBL=$this->MBL&TM=$this->TM&DV=DL&SFlag=$this->SFlag'>Update Break Bulk Delivery Status</a></td>");    
			}
		
		}
		
		


/*
if($_SESSION['Control_Panel']==14)
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
		} */
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
<TR><TD><p><font size="3" color="black"><?php echo $links; ?></font></p></TD></TR>

</table>

<?php mysql_close($con_cchaportdb);?>
<?php
		/*include_once("myPageCreate.php");
		$myform = new myPageCreate();
		$myform->myListPage("$mySQL","home.php?myflag=46&MCODE=$this->MCODE&TM=$this->TM");*/
?>

