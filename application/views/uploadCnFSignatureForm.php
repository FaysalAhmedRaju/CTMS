
<script language="JavaScript">
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
		var cnfCodeTxt=document.getElementById("strCnfCode");
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
      
         if( document.myChkForm.license_no.value == "" )
         {
            alert( "Please provide C&F License No!" );
            document.myChkForm.license_no.focus() ;
            return false;
         }
         
         if( document.myChkForm.strCnfCode.value == "" )
         {
            alert( "Please provide C&F Name!" );
            document.myChkForm.strCnfCode.focus() ;
            return false;
         }
		 return true;
	  }
</script>
<style>
input {
   
    width: 200px;
  
}
</style>
<div class="content">
    <div class="content_resize_1">
      <div class="mainbar_1">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div align="center"><?php echo $msg?></div>
		 
		  <?php 
		  $attributes = array('method' => 'POST','id' => 'myform','name'=>'myChkForm','onsubmit'=>'return(validate())','enctype'=>'multipart/form-data');
		  //,'target'=>'_BLANK'
		  echo form_open(base_url().'index.php/uploadExcel/cnfSignatureUpload',$attributes);
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
						<tr align="left">
							<td align="right">C&F License No :<em>&nbsp;</em></td>
							<td align="left" >
							<input type="text" id="license_no"  name="license_no" onblur= "getCnfCode(this.value)"/>
							</td>
						</tr>
						<tr align="left">
							<td align="right" >C&F Name :<em>&nbsp;</em></td>
							<td>
								<input type="text" id="strCnfCode" name="strCnfCode"/>
							</td>
						</tr>
						<tr align="left">
							<td>Browse Signature File :</td>
							<td>
								<input type="file" name="file"/>
							</td>
						</tr>
						<tr align="left">
							<td colspan="2" align="center" width="70px">
							<?php $arrt = array('name'=>'report','id'=>'submit','value'=>'Upload','class'=>'login_button'); echo form_submit($arrt);?>	
							</td>
						</tr>
				</table>
			</td>
		</tr>
		<tr><td align="center" colspan="2"><font color=""><b>
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

<div style="width:100%; height:500px; overflow-y:auto;">
</div>


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