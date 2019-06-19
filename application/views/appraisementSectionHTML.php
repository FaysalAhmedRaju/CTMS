
<script language="JavaScript">
$(document).on('keypress', 'input,select', function (e) {
    if (e.which == 13) {
        e.preventDefault();
        var $next = $('[tabIndex=' + (+this.tabIndex + 1) + ']');
        console.log($next.length);
        if (!$next.length) {
            //$next = $('[tabIndex=1]');
			form.submit();
        }
		else
        $next.focus();
    }
});
function setEquipCharge(myVal)
{
	//alert(myVal);
	if (window.XMLHttpRequest) 
	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} 
	else 
	{  
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=stateChangeEquipmentValue;
	xmlhttp.open("GET","<?php echo site_url('ajaxController/getEquipmentCharge')?>?equipID="+myVal,false);
	xmlhttp.send();
}
function stateChangeEquipmentValue()
{
	//alert("ddfd");
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
		//alert(xmlhttp.responseText);			  
		var val = xmlhttp.responseText;
		var jsonData = JSON.parse(val);
		//var jval=jsonData[0].myval;
		//alert("J val:"+jval);
		var equip_charge=document.getElementById("equip_charge");
		//var selectList=document.getElementById("type"+jval);
		//removeOptions(selectList);
		//alert(xmlhttp.responseText);
		for (var i = 0; i < jsonData.length; i++) 
		{
			//alert(jsonData[i].name);
			equip_charge.value=jsonData[i].equipment_charge;
			//var option = document.createElement('option');
			//option.value = jsonData[i].block;
			//option.text = jsonData[i].block;
			//selectList.appendChild(option);
		}
    }
}
function getCnfCode(val) 
{	
	//alert(val);		
	if (window.XMLHttpRequest) 
	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} 
	else 
	{  
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=stateChangeValue;
	xmlhttp.open("GET","<?php echo site_url('ajaxController/getCnfCode')?>?cnf_lic_no="+val,false);
	xmlhttp.send();
		  
}

function stateChangeValue()
{
	//alert("ddfd");
    if (xmlhttp.readyState==4 && xmlhttp.status==200) 
	{
		//alert(xmlhttp.responseText);			  
		var val = xmlhttp.responseText;
		var jsonData = JSON.parse(val);
		//var jval=jsonData[0].myval;
		//alert("J val:"+jval);
		var cnfCodeTxt=document.getElementById("cnfName");
		//var selectList=document.getElementById("type"+jval);
		//removeOptions(selectList);
		//alert(xmlhttp.responseText);
		for (var i = 0; i < jsonData.length; i++) 
		{
			//alert(jsonData[i].name);
			cnfCodeTxt.value=jsonData[i].name;
			//var option = document.createElement('option');
			//option.value = jsonData[i].block;
			//option.text = jsonData[i].block;
			//selectList.appendChild(option);
		}
    }
}
function validate()
      {
		   if( document.myChkForm.cnfLicense.value == "" )
         {
            alert( "Please provide Cnf License!" );
            document.myChkForm.cnfLicense.focus() ;
            return false;
         }
		  if( document.myChkForm.cnfName.value == "" )
         {
            alert( "Please provide Cnf Name!" );
            document.myChkForm.cnfName.focus() ;
            return false;
         }
		  if( document.myChkForm.beNo.value == "" )
         {
            alert( "Please provide BE No!" );
            document.myChkForm.beNo.focus() ;
            return false;
         }
		  if( document.myChkForm.beDate.value == "" )
         {
            alert( "Please provide BE Date!" );
            document.myChkForm.beDate.focus() ;
            return false;
         }
      
         if( document.myChkForm.used_equipment.value == "" )
         {
            alert( "Please provide Used Equipment!" );
            document.myChkForm.used_equipment.focus() ;
            return false;
         }
         
         if( document.myChkForm.appraise_date.value == "" )
         {
            alert( "Please provide Appraisement Date!" );
            document.myChkForm.appraise_date.focus() ;
            return false;
         }
         if( document.myChkForm.carpainter_use.value == "" )
         {
            alert( "Please provide Carpainter Use!" );
            document.myChkForm.carpainter_use.focus() ;
            return false;
         }
		 if( document.myChkForm.hosting_charge.value == "" )
         {
            alert( "Please provide Hosting Charge!" );
            document.myChkForm.hosting_charge.focus() ;
            return false;
         }
		 if( document.myChkForm.extra_movement.value == "" )
         {
            alert( "Please provide Extra Movement!" );
            document.myChkForm.extra_movement.focus() ;
            return false;
         }
		 if( document.myChkForm.scale_for.value == "" )
         {
            alert( "Please provide Scale!" );
            document.myChkForm.scale_for.focus() ;
            return false;
         }
		 if(document.myChkForm.used_equipment.value != "0")
		 {
			  if( document.myChkForm.hosting_charge.value == "" ||  document.myChkForm.hosting_charge.value == "0")
			 {
				alert( "Please Set Hosting Charge atleast 1 !" );
				document.myChkForm.hosting_charge.focus() ;
				return false;
			 }
		 }
         return( true );
      }
  
</script>

<div class="content">
    <div class="content_resize_1">
      <div class="mainbar_1">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <span><?php echo $myUpdateManifestList; ?></span>
		  <div class="clr"><?php echo $msg?></div>
		  
		  <?php 
		  $attributes = array('id' => 'myform');
		  //,'target'=>'_BLANK'
		  echo form_open(base_url().'index.php/report/appraisementCertifyList',$attributes);
			$Stylepadding = 'style="padding: 12px 20px;"';
				if(!empty($error_message))
				{
					$Stylepadding = 'style="padding:25px 20px;"';
				}	
				if(isset($captcha_image)){
					$Stylepadding = 'style="padding:62px 20px 93px;"';
				}?>
	
		<div class="img">
		 	 <!--<div id="login_container">-->
		 <table style="border:solid 1px #ccc;" width="650px" align="center" cellspacing="0" cellpadding="0">
				<tr><td>	 
		 <table align="center" border=0>	
						<tr align="center">
							<td align="right" ><label for="rotation_no">Rotation No:<em>&nbsp;</em></label></td>
							<td align="left" >
							<?php 
								$attribute = array('name'=>'ddl_imp_rot_no','id'=>'txt_login','class'=>'login_input_text','autofocus'=>'autofocus' );
								echo form_input($attribute,set_value('ddl_imp_rot_no'));
								//'onblur'=> "alert();"
							?>
									
							</td>
						
							<td align="right" ><label for="rotation_no">BL No:<em>&nbsp;</em></label></td>
							<td align="left" >
							<?php 
								$attribute = array('name'=>'ddl_bl_no','id'=>'txt_login','class'=>'login_input_text','tabindex'=>1 );
								echo form_input($attribute,set_value('ddl_bl_no'));
								//'onblur'=> "alert();"
							?>
									
							</td>
						
							<td colspan="2" align="center" width="70px">
							<?php $arrt = array('name'=>'report','id'=>'submit','value'=>'Search','class'=>'login_button','tabindex'=>2 ); echo form_submit($arrt);?>	
							</td>
						</tr>
				</table>
			</td>
		</tr>
		<tr><td align="center" colspan="2"><font color=""><b>
		<?php if($verify_number>0 or $verify_num>0)
				{ echo "<font color='green'><b>VERIFY NUMBER IS ".$verify_num."</b></font><br>";} 			 
			  else 
				{ echo $msg;}?>
		<?php echo $msgPO;?>
		</b></font></td></tr>
		<!--TR align="center"><TD colspan="6" ><h2><span ><?php echo "Verify No: ".$verify_num; ?></span> </h2></TD></TR-->
	</table>
	<?php echo form_close()?>
	<?php
/*****************************************************
Developed BY: Sourav Chakraborty
Software Developer
DataSoft Systems Bangladesh Ltd
******************************************************/

$_SESSION['Control_Panel']=$this->session->userdata('Control_Panel');

?>
<?php 
if($unstuff_flag>0)
			{
				?>
				
<div style="width:100%; height:500px; overflow-y:auto;">
<table border="0"  width="100%" bgcolor="#FFFFFF" align="center">
	<!--<TR align="center"><TD colspan="6" ><h2><span ><?php echo $title; ?></span> </h2></TD></TR>-->
	
	
	<TR><TD align="center">
	
		<table border=0 cellspacing="2" cellpadding="1" bdcolor="#ffffff">

		<?php
			
			//include("mydbPConnection.php");
			$totcontainerNo="";
			if($rtnContainerList) {
			$len=count($rtnContainerList);
			//echo "Length : ".$len;
            $j=0;
            for($i=0;$i<$len;$i++){
				
			
			//echo $rtnYardPosition->fcy_time_in."<hr>";
			
		?>
		<?php if($appraiseFlag==0) { ?>
			<tr class="gridLight">
				<th width="100px">Vessel Name</th><th>:</th><td><?php echo ($rtnContainerList[$i]['Vessel_Name']) ?></td>
				<th width="100px">Rotation</th><th>:</th><td><?php print($rtnContainerList[$i]['Import_Rotation_No']);  ?></td>
				<th width="100px">Bl No</th><th>:</th><td><?php print($rtnContainerList[$i]['BL_No']);  ?></td>
				
				
			</tr >
			<tr class="gridLight">
				<th width="100px">Container</th><th>:</th><td><?php print($rtnContainerList[$i]['cont_number']); ?></td>
				<th width="100px">Size</th><th>:</th><td><?php print($rtnContainerList[$i]['cont_size']); ?></td>
				<th width="100px">Status</th><th>:</th><td><?php print($rtnContainerList[$i]['cont_status']); ?></td>
			</tr>
			<tr class="gridLight">	
				<!--th width="100px">C&F Name</th><th>:</th><td><?php print($rtnContainerList[$i]['cnf_name']); ?></td-->
				<th>Marks</th><th>:</th><td><?php echo str_replace(',',', ',$rtnContainerList[$i]['Pack_Marks_Number']); ?></td>
				<th>Quantity</th><th>:</th><td><?php echo ($rtnContainerList[$i]['Pack_Number']);  ?></td>
				<th width="150px">Good's Description</th><th>:</th><td><?php print($rtnContainerList[$i]['Description_of_Goods']);  ?></td>
				
				
			</tr>
			<!--tr class="gridLight">
				<th width="150px">Good's Description</th><th>:</th><td><?php print($rtnContainerList[$i]['Description_of_Goods']);  ?></td>
				<th>BE No</th><th>:</th><td><?php echo ($rtnContainerList[$i]['be_no']);  ?></td>
				<th>BE Date</th><th>:</th><td><?php echo ($rtnContainerList[$i]['be_date']);  ?></td>
			</tr-->
			<tr class="gridLight">
				<th>Importer Name</th><th>:</th><td><?php print($rtnContainerList[$i]['Notify_name']); ?></td>
				<th>Pack Description</th><th>:</th><td><?php echo($rtnContainerList[$i]['Pack_Description']);  ?></td>
				<th>Yard/Shed</th><th>:</th><td><?php echo($rtnContainerList[$i]['shed_yard']); ?></td>
			</tr>
			<tr class="gridLight">
				
				<th>Bay Position</th><th>:</th><td><?php $lenUnit = count($rtnUnitList); for($j=0;$j<$lenUnit;$j++) { echo($rtnUnitList[$j]['shed_loc']).",";} ?></td>
				<th>Rcv Pack</th><th>:</th><td><?php $lenUnit = count($rtnUnitList); for($j=0;$j<$lenUnit;$j++) { echo($rtnUnitList[$j]['rcvTally']).",";}  ?></td>
				<th>Rcv Unit</th><th>:</th><td><?php $lenUnit = count($rtnUnitList); for($j=0;$j<$lenUnit;$j++) { echo($rtnUnitList[$j]['rcv_unit']).",";}?></td>
				
				
			</tr>
			<tr class="gridLight">
				<th>Gross Weight</th><th>:</th><td><?php echo($rtnContainerList[$i]['Cont_gross_weight']); ?></td>
				
			</tr>
				
		
	</table>
	<br/>
	<form action="<?php echo site_url('report/appraisementVerify');?>" method="POST" name="myChkForm" onsubmit="return(validate());">
		<input type="hidden" value="<?php echo  $verify_id?>" name="verify_id" style="width:200px;"/>
		<input type="hidden" value="<?php echo  $verify_num?>" name="verify_num" style="width:200px;"/>
		<input type="hidden" value="<?php echo  $ddl_imp_rot_no?>" name="ddl_imp_rot_no" style="width:200px;"/>
		<input type="hidden" value="<?php echo  $ddl_bl_no?>" name="ddl_bl_no" style="width:200px;"/>
		<!--input type="hidden" id="login_id" name="login_id" value="<?php echo $login_id?>"-->
		<!--input type="hidden" id="userip" name="userip" value="<?php echo $userip?>"-->
		
		<table border=0 cellspacing="2" cellpadding="1"  width="80%" bgcolor="#2AB1D6">
			<tr align="center" style="background:#FFF"><td colspan="6"><font color="black"><b>Comment's</b></font></td></tr>
			<tr class="gridLight" >
				<th>Cnf License</th><th>:</th><td ><input type="text" value="<?php echo ($rtnContainerList[$i]['cnf_lic_no']); ?>" id="cnfLicense" name="cnfLicense" style="width:200px;" onblur= "getCnfCode(this.value)"/></td>
				<th>Cnf Name</th><th>:</th><td ><input type="text" value="<?php echo ($rtnContainerList[$i]['cnf_name']); ?>" id="cnfName" id="cnfName" name="cnfName" style="width:200px;"/></td>
			</tr>
			<tr class="gridLight" >
				<th>BE No</th><th>:</th><td ><input type="text" value="<?php echo ($rtnContainerList[$i]['be_no']); ?>" id="beNo" name="beNo" style="width:200px;"/></td>
				<th>Be Date</th><th>:</th>
					<td>
						<input type="text" value="<?php if($rtnContainerList[$i]['be_date'] == "" || $rtnContainerList[$i]['be_date'] == "0000-00-00") echo date("Y-m-d"); else echo $rtnContainerList[$i]['be_date'];?>" id="beDate" name="beDate" style="width:200px;"/>
						<script>
							$(function() {
								$( "#beDate" ).datepicker({
								changeMonth: true,
								changeYear: true,
								dateFormat: 'yy-mm-dd', // iso format
							 });
							 });
						</script>
					</td>
			</tr>
			<tr class="gridLight" >
				<th>Used Equipment</th><th>:</th><td>
				<!--input type="text" value="<?php echo $used_equipment; ?>" id="used_equipment" name="used_equipment" style="width:200px;"/-->
				<select name="used_equipment" id="used_equipment" onchange="setEquipCharge(this.value)" style="width:200px;">
					<option value="0">--------Select---------</option>
					<?php 
						for($i=0;$i<count($getUsedEquipment);$i++)
						{
						  echo '<option value="'.$getUsedEquipment[$i]['equipment_id'].'">'.$getUsedEquipment[$i]['equipment_name'].'</option>';
						}
					?>
					<!--option value="FLT 1-5 TON">FLT 1-5 TON</option> 
					<option value="FLT 6-20 TON">FLT 6-20 TON</option> 
					<option value="FLT 21-50 TON">FLT 21-50 TON</option> 
					<option value="CRANE 1-10 TON">CRANE 1-10 TON</option> 
					<option value="CRANE ABOVE 10 TON">CRANE ABOVE 10 TON</option--> 	
				</select>
				<input type="hidden" id="equip_charge" name="equip_charge" />
				</td>
				<th>Appraisement Date</th><th>:</th>
					<td>
						<input type="text" value="<?php if($appraise_date == "" || $appraise_date == "0000-00-00") echo date("Y-m-d"); else echo $appraise_date; ?>" id="appraise_date" name="appraise_date" style="width:200px;"/>
						<script>
							$(function() {
								$( "#appraise_date" ).datepicker({
								changeMonth: true,
								changeYear: true,
								dateFormat: 'yy-mm-dd', // iso format
							 });
							 });
						</script>
					</td>
			</tr>
			<tr class="gridLight" >
				<th>Carpainter Use</th><th>:</th><td ><input type="text" value="<?php echo $carpainter_use; ?>" id="carpainter_use" name="carpainter_use" style="width:200px;"/></td>
				<th>Hosting Charge</th><th>:</th><td ><input type="text" value="<?php echo $hosting_charge; ?>" id="hosting_charge" name="hosting_charge" style="width:200px;"/></td>
			</tr>
			<tr class="gridLight" >
				<th>Extra Movement</th><th>:</th><td ><input type="text" value="<?php echo $extra_movement; ?>" id="extra_movement" name="extra_movement" style="width:200px;"/></td>
				<th>Scale For</th><th>:</th><td ><input type="text" value="<?php echo $scale_for; ?>" id="scale_for" name="scale_for" style="width:200px;"/></td>
			</tr>
			<tr style="background:#FFF"  align="center">
				
					<td colspan="6" align="center"><input type="submit" class="login_button" value="SAVE"/></td>
				<?php } else { ?>
					<font color="green"><b>Appraisement Successfully Done.</b></font></br> <font color="red"><b>Rotation : <?php echo  $ddl_imp_rot_no?> and BL NO : <?php echo  $ddl_bl_no?></b></font>
					<!--td colspan="6" align="center"><input type="submit" class="login_button" value="UPDATE"/></td-->
				<?php } ?>
			</tr>
		</table>
	</form>
<?php }
			
			
			}?>
		
	
</TD></TR>
<br/>
</table>
</div>
<?php 
}
			else{
				echo "";
				
			}
?>

		 <!--</div>-->
		 </div>
         
		  </form>
          <div class="clr"></div>
        </div>
       
       <!-- <p class="pages"><small>Page 1 of 2</small> <span>1</span> <a href="#">2</a> <a href="#">&raquo;</a></p>-->
      </div>
      <div class="sidebar" >
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	
  </div>