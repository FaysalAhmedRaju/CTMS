<script>
	function getContainerInfo(val)
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
			xmlhttp.onreadystatechange=stateChangeContainerValue;
			xmlhttp.open("GET","<?php echo site_url('ajaxController/getContainerInfo')?>?cont_number="+val,false);
			xmlhttp.send();
		
	}
	function stateChangeContainerValue()
	{
		//alert("ddfd");
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
				  
			var val = xmlhttp.responseText;
			//alert(val);
			var jsonData = JSON.parse(val);
			//alert(jsonData);
			var cont_info_div=document.getElementById("contInfoDiv");
			var cont_size=document.getElementById("cont_size");
			var cont_height=document.getElementById("cont_height");
			var cont_status=document.getElementById("cont_status");
			var cont_rot=document.getElementById("cont_rotation");
			
			var cont_size_hd=document.getElementById("cont_size_hd");
			var cont_height_hd=document.getElementById("cont_height_hd");
			var cont_status_hd=document.getElementById("cont_status_hd");
			var cont_rotation_hd=document.getElementById("cont_rotation_hd");
		
			for (var i = 0; i < jsonData.length; i++) 
			{	
				cont_size.innerHTML=jsonData[i].cont_size;
				cont_height.innerHTML=jsonData[i].cont_height;
				cont_status.innerHTML=jsonData[i].cont_status;
				cont_rot.innerHTML=jsonData[i].ib_vyg;
				
				cont_size_hd.value=jsonData[i].cont_size;
				cont_height_hd.value=jsonData[i].cont_height;
				cont_status_hd.value=jsonData[i].cont_status;
				cont_rotation_hd.value=jsonData[i].ib_vyg;
				
			}
			cont_info_div.style.display="block";
		}
	}
	function validate()
      {
		  //alert("OK");
		if( document.myChkForm.cont_no.value == "" )
         {
            alert( "Please provide Container No!" );
            document.myChkForm.cont_no.focus() ;
            return false;
         }
		 if( document.myChkForm.cont_position.value == "" )
         {
            alert( "Please provide Container Position!" );
            document.myChkForm.cont_position.focus() ;
            return false;
         }
		  if( document.myChkForm.cont_position.value == "Container Receive" ||  document.myChkForm.cont_position.value == "Empty Container Remove" ||  document.myChkForm.cont_position.value == "On Chasis Delivery")
         {
			 if( document.myChkForm.trailer_no.value == "" ) 
			 {
				alert( "Please provide Trailer No!" );
				document.myChkForm.trailer_no.focus() ;
				return false;
			 } 
			 else
			 {
				  if( document.myChkForm.cont_size_hd.value == "" &&  document.myChkForm.cont_height_hd.value == "")
				 {
						alert( "Please Provide Correct Container No" );
						document.myChkForm.cont_position.focus() ;
						return false;
				 }
				 else{
					 return true;
				 }
			 }
		 }
		  if( document.myChkForm.cont_size_hd.value == "" &&  document.myChkForm.cont_height_hd.value == "")
         {
				alert( "Please Provide Correct Container No" );
				document.myChkForm.cont_position.focus() ;
				return false;
		 }
		 else{
			 return true;
		 }
         return( true );
      }
	 function showTrailer()
	 {
		 var trailer_tr=document.getElementById("trailer_vw");
		 var trailer_no=document.getElementById("trailer_no");
		 
		  if( document.myChkForm.cont_position.value == "Container Receive" ||  document.myChkForm.cont_position.value == "Empty Container Remove" ||  document.myChkForm.cont_position.value == "On Chasis Delivery")
         {
           trailer_tr.style.display="inline"; 
		   trailer_no.value="";
         }
		 else
		 {
			  trailer_tr.style.display="none";
			  trailer_no.value="";
		 }
	 }
 </script>
<style>
input { 
    width: 100px;
}
input:focus {
    background-color: #F3F781;
}
select:focus {
    background-color: #F3F781;
}
 table {border-collapse: collapse;}
			 .left{
					width:280px;
					float:left;										
					font-size: 10px;
					color:black;
				}
				.right{
					margin-left:300px;
					font-size: 10px;
					color:black;
				}
</style>
<div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
		
          
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div align="center"><?php echo $msg;?></div>
		 
		  <?php 
		  $attributes = array('method' => 'POST','id' => 'myform','name'=>'myChkForm','enctype'=>'multipart/form-data');
		  //,'target'=>'_BLANK'
		  //echo form_open(base_url().'index.php/shedBillController/billGenerationFormToDB',$attributes);
			$Stylepadding = 'style="padding: 12px 20px;"';
				if(!empty($error_message))
				{
					$Stylepadding = 'style="padding:25px 20px;"';
				}	
				if(isset($captcha_image)){
					$Stylepadding = 'style="padding:62px 20px 93px;"';
				}?>
		<div align="center">
		<table>
			<tr align="center">
				<th style="color:black;">CHITTAGONG PORT AUTHORITY</th>
			</tr>
		</table>
		</div>
          <h3 style="color:black;"><span><?php echo $title; ?></span> </h3>
		<div class="img" style="margin-right:20px;">
		 	 <!--<div id="login_container">-->
		<form id="myChkForm" name="myChkForm" action="<?php echo site_url('report/containerPositionToDB');?>" method="post" onsubmit="return validate()">
	<div style="width: 500px">
		<div class="left">
			<fieldset>
				<legend>ENTRY INFO:</legend>
				<table >
					<tr>
						<td> CONTAINER NO</td>
						<td>:</td>
						<td><input type="text" id="cont_no"  name="cont_no" onblur="return getContainerInfo(this.value)"/></td>
					</tr>
					<tr>
						<td> ACTION</td>
						<td>:</td>
						<td>
							 <select name="cont_position" id="cont_position" onchange="showTrailer()">
								<option value="" label="cont_position">--Select--</option>
								<option value="Delivery Stay" label="Delivery Stay" >Delivery Stay</option>
								<option value="Delivery Cancel" label="Delivery Cancel" >Delivery Cancel</option>																							
								<option value="Container Receive" label="Container Receive" >Container Receive</option>																							
								<option value="Empty Container Remove" label="Empty Container Remove" >Empty Container Remove</option>																							
								<option value="On Chasis Delivery" label="On Chasis Delivery" >On Chasis Delivery</option>																							
								<option value="Empty Lying YARD" label="Empty Lying YARD" >Empty Lying(YARD)</option>																															
								<option value="Bidder delivery Auction" label="Bidder delivery Auction" >Bidder delivery / Auction</option>																							
								<option value="Custom Appraise" label="Custom Appraise" >Custom Appraise</option>																							
								<option value="C&F Delivery" label="C&F Delivery" >C&F Delivery</option>	
								<option value="Container inventory" label="Container inventory" >Container inventory</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<table>
								<tr id="trailer_vw" style="display:none;">
									<td> TRAILER NO</td>
									<td>:</td>
									<td><input  type="text" id="trailer_no"  name="trailer_no"  /></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="3" align="right">
							<input tabindex="8" id="save_btn" class="login_button" type="submit" style="width : 100px" value="SAVE"/>
						</td>
					</tr>
				</table>
			</fieldset>
		</div>
			</form>
		<div id="contInfoDiv" class="right" style="display:none;">
			<fieldset>
			<legend>CONTAINER INFO</legend>
				<div>
				<table align="center">
					<tr>
						<td>SIZE</td>
						<td> : </td>
						<td><label id="cont_size"></label></td>					
						<td><input type="hidden" id="cont_size_hd" name="cont_size_hd"/></td>					
					</tr>
					<tr>
						<td>HEIGHT</td>
						<td> : </td>
						<td><label id="cont_height"></label></td>
						<td><input type="hidden" id="cont_height_hd" name="cont_height_hd"/></td>	
					</tr>
					<tr>
						<td>STATUS</td>
						<td> : </td>
						<td><label id="cont_status"></label></td>
						<td><input type="hidden" id="cont_status_hd" name="cont_status_hd"/></td>	
					</tr>
					<tr>
						<td>ROTATION</td>
						<td> : </td>
						<td><label id="cont_rotation"></label></td>
						<td><input type="hidden" id="cont_rotation_hd" name="cont_rotation_hd"/></td>	
					</tr>
					
				</table>
				</div>
			</fieldset>
		
		</div>
		</div>
		</br>
		</br>
		
	<?php
/*****************************************************
Developed BY: Sourav Chakraborty
Software Engineer
DataSoft Systems Bangladesh Ltd
******************************************************/

$_SESSION['Control_Panel']=$this->session->userdata('Control_Panel');

?>
		 </div>
          <div class="clr"></div>
        </div>
       <div style="">
		<table width="80%" border ='1' cellpadding='0' cellspacing='0'>
			<tr  align="center" class="gridDark">
				<th>SL</th>
				<th>CONTAINER</th>
				<th>ACTION</th>
				<th>TRAILER NO</th>
				<th>ROTATION</th>
				<th>SIZE</th>
				<th>HEIGHT</th>
				<th>STATUS</th>
				<th>ACTION</th>
			</tr>
			<?php for($i=0;$i<count($rtnSearchList);$i++) {?>
			<tr  align="center" class="gridLight">
				<td><?php echo $i+1;?></td>
				<td><?php echo $rtnSearchList[$i]['cont_number'] ?></td>
				<td><?php echo $rtnSearchList[$i]['position'] ?></td>
				<td><?php echo $rtnSearchList[$i]['trailer_no'] ?></td>
				<td><?php echo $rtnSearchList[$i]['rotation'] ?></td>
				<td><?php echo $rtnSearchList[$i]['cont_size'] ?></td>
				<td><?php echo $rtnSearchList[$i]['cont_height'] ?></td>
				<td><?php echo $rtnSearchList[$i]['cont_status'] ?></td>
				<td style="padding:5px;">
				<form action="<?php echo site_url('report/containerPositionDelete') ?>" method="post" onsubmit="return confirm('Are you sure you want to delete Container Position?');">
					<input type="hidden" name="cont_move_id" value="<?php echo $rtnSearchList[$i]['id']; ?>">
					<input type="submit" class="login_button" name="submit" value="Delete">
				</form>
				</td>	
			</tr>
			<?php }?>
		</table>
		</div>
       <!-- <p class="pages"><small>Page 1 of 2</small> <span>1</span> <a href="#">2</a> <a href="#">&raquo;</a></p>-->
      </div>
      <div class="sidebar" >
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
  </div>