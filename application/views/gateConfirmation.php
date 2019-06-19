
<script language="JavaScript">
	function validate()
	{
		if( document.myform.dlv_date.value == "" )
		{
			alert( "Please provide date!" );
			document.myform.dlv_date.focus() ;
			return false;
		}
		
		if( document.myform.gate_no.value == "" )
		{
			alert( "Please select truck no!" );
			document.myform.tro.focus() ;
			return false;
		}
		
		return true ;
		
	}
	
	function getvrfyno(verify_num)
	{
		document.getElementById("gate_pass_no").value="";
		document.getElementById("reg_no").value="";
		document.getElementById("marks").value="";
		document.getElementById("vessel_name").value="";
		document.getElementById("des_goods").value="";
		document.getElementById("mlo_line").value="";
		document.getElementById("quantity").value="";
		document.getElementById("mlo_code").value="";
		document.getElementById("unit").value="";
		document.getElementById("ffw_line").value="";
		document.getElementById("cnf").value="";
		document.getElementById("ffw_code").value="";
		document.getElementById("be_no").value="";
		document.getElementById("importer_name").value="";
		document.getElementById("be_date").value="";
		document.getElementById("gate_no").value="";
		document.getElementById("dlv_date").value="";
		document.getElementById("tro").value="";
		document.getElementById("dlv_qty").value="";
		document.getElementById("notifyName").value="";
		document.getElementById("notifyAddress").value="";
		var r = document.getElementById("verify_num").value;
	
		document.getElementById("verify_number").value=r;
		document.getElementById("verifyNo").value=r;
		
		if(document.getElementById("verify_num").value=="")
		{
			alert("Please! Enter Verify No.");
			document.getElementById("verify_num").focus();
		}
		else
		{
			var verify_num=document.getElementById("verify_num").value;
			
			getTruck(verify_num);	//call for truck no

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
			var url = "<?php echo site_url('ajaxController/getDeliveryByVerifyInfo')?>?verify_num="+verify_num;
		//	alert(url);
			xmlhttp.onreadystatechange=stateChangegetBLInfo;
			xmlhttp.open("GET",url,false);	
			
			xmlhttp.send();
		}
	}

	function stateChangegetBLInfo()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) //???
		{			
			var val = xmlhttp.responseText;
			
			var jsonData = JSON.parse(val);
			for (var i = 0; i < jsonData.length; i++) 
		    {
				/* document.getElementById("gate_pass_no").value="";*/
				document.getElementById("reg_no").value=jsonData[i].Import_Rotation_No;
				document.getElementById("marks").value=jsonData[i].Pack_Marks_Number; 
				document.getElementById("vessel_name").value=jsonData[i].Vessel_Name;
				document.getElementById("des_goods").value=jsonData[i].Description_of_Goods;
			/*	document.getElementById("mlo_line").value="";	*/
				document.getElementById("quantity").value=jsonData[i].Pack_Number;
				document.getElementById("mlo_line").value=jsonData[i].mloline;
				document.getElementById("mlo_code").value=jsonData[i].mlocode;
				document.getElementById("unit").value=jsonData[i].Pack_Description;
				document.getElementById("ffw_line").value=jsonData[i].ffwline;
				document.getElementById("cnf").value=jsonData[i].cnf_name;
				/*document.getElementById("ffw_code").value="";*/
				document.getElementById("importer_name").value=jsonData[i].Consignee_name;
				document.getElementById("be_no").value=jsonData[i].be_no; 
				document.getElementById("be_date").value=jsonData[i].be_date; 
	/*			document.getElementById("gate_no").value="";
				document.getElementById("dlv_date").value="";
				document.getElementById("tro").value="";*/
				document.getElementById("dlv_qty").value=jsonData[i].bal_pack; 
				document.getElementById("notifyName").value=jsonData[i].Notify_name; 
				document.getElementById("notifyAddress").value=jsonData[i].Notify_address; 
			}			
		}
	}
	
	function getTruck(val){
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
		var url = "<?php echo site_url('ajaxController/getTruck')?>?verify_num="+val;
		//alert(url);
		xmlhttp.onreadystatechange=stateChangeSection;
		xmlhttp.open("GET",url,false);
		xmlhttp.send();
	}
	
	function stateChangeSection()
	{
		//alert(xmlhttp.responseText);
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			var selectList=document.getElementById("tro");
			removeOptions(selectList);
			//alert(xmlhttp.responseText);
			var val = xmlhttp.responseText;
			var jsonData = JSON.parse(val);
			//alert(xmlhttp.responseText);
			for (var i = 0; i < jsonData.length; i++) 
			{
				var option = document.createElement('option');
				option.value = jsonData[i].truck_id;  //value of option in backend
				option.text = jsonData[i].truck_id;	  //text of option in frontend
				selectList.appendChild(option);
			}
		}
	}
	
	function removeOptions(selectbox)
	{
		var i;
		for(i=selectbox.options.length-1;i>=1;i--)
		{
			selectbox.remove(i);
		}
	}
	
	function getbalance(tro)
	{
		var verify_num=document.getElementById("verify_num").value;
	
		if (window.XMLHttpRequest) 
		{
		//	alert("ok");
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} 
		else 
		{  
			// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	//	var url = "<?php echo site_url('ajaxController/getbalance')?>?truck_id="+tro+"&verify_num="+verify_num;
		var url = "<?php echo site_url('ajaxController/getbalance')?>?truck_id="+tro;
		//alert(url);
		xmlhttp.onreadystatechange=stateChangeBalance;
		xmlhttp.open("GET",url,false);
		xmlhttp.send();
	}
	
	function stateChangeBalance()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) //???
		{			
			var val = xmlhttp.responseText;
			
			
			var jsonData = JSON.parse(val);
		//	alert(jsonData);
		//	console.log(jsonData);
			//alert(jsonData[0].rtndelvPack);
			//alert("alert");
			var rcv=document.getElementById("quantity").value;
		//	document.getElementById("dlv_qty").value=parseFloat(rcv)-parseFloat(jsonData[0].rtndelvPack.delv_pack);
		//	document.getElementById("gate_no").value=jsonData[0].rtndelv.gate_no;
			document.getElementById("gate_no").value=jsonData[0].gate_no;
		//	alert("alert");
			document.getElementById("troCart").value=jsonData[0].truck_id;
			//alert("after select "+document.getElementById("tro").value);
		}
	}

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
</script>
<style>
input {   
    width: 200px;
}

input:focus {
    background-color: #F3F781;
}

select:focus {
    background-color: #F3F781;
}

 table {border-collapse: collapse;}
			 .left{
					width:800px;
					float:left;										
					font-size: 10px;
					color:black;
				}
				.middle{
					margin-left:0px;
					width:230px;
					float:left;
					height:100%;
					font-size: 10px;
					color:black;
				}
				.right{
					margin-left:20px;
					font-size: 10px;
					color:black;
				}
				.left_container_fieldSet{
					
					float:left;
					height:100%;
					font-size: 10px;
					color:black;
				}
				.right_container_fieldSet{
					margin-left:10px;
					font-size: 10px;
					color:black;
				}
				.left_tbl_div{
					float:left;
					height:100%;
					font-size: 10px;
					color:black;
				}
				.right_tbl_div{
					float:right;
					font-size: 10px;
					color:black;
				}
	.ui-datepicker {
				   background: #DF7A3C;
				   border: 1px solid #555;
				   color: black;
				 }
				
				.input_field
				{
					width:200px;
					background-color : #F7EEC0;
				}
</style>

<div class="content">
    <div class="content_resize_1">
      <div class="mainbar_1">
        <div class="article">
		
          
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          
		 
		  <?php 
		  $attributes = array('method' => 'POST','id' => 'myform','name'=>'myform','onsubmit'=>'return validate()','enctype'=>'multipart/form-data');
		  
		  echo form_open(base_url().'index.php/report/gateConfirmationPerform',$attributes);
			$Stylepadding = 'style="padding: 12px 20px;"';
				if(!empty($error_message))
				{
					$Stylepadding = 'style="padding:25px 20px;"';
				}	
				?>
		<div align="center">
		<table>
			
			<tr align="center">
				<th style="color:black;">CHITTAGONG PORT AUTHORITY</th>
			</tr>
			<!--tr align="center">
				<iframe align="center" name="msgbar" id="msgbar" height="30" frameborder="1"></iframe>
			</tr-->
			<tr align="center">
				<th style="color:black;">GATE CONFIRMATION</th>
			
			</tr>
		</table>
		</div>
          <h3 style="color:black;"><span><?php echo $title; ?></span> </h3>
		<div class="img" style="margin-right:20px; background-color:#C1E0FF;">
		 	 
		 <table style="border:solid 1px #ccc;" width="800px" align="center" cellspacing="0" cellpadding="0">
			<tr>
			 <td>	 
				<table align="center">	
					<tr >
						<td style="color:black;">VERIFY NO :<em>&nbsp;</em></td>
						<td >
							<input type="text" id="verify_num" name="verify_num" autofocus value="<?php echo $verify_num;?>" onblur="return getvrfyno(this.value)" tabindex="1"/>
						</td>
						<td style="color:black;">GATE PASS NO:<em>&nbsp;</em></td>
						<td align="right">
							<input type="text" id="gate_pass_no" name="gate_pass_no">
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<?php// for($i=0;i<count($rslt_reload);$i++) { ?>
	<div>
		<div class="left">
			<fieldset>
				<legend>INFORMATION</legend>
				<table height="217px">
					<tr>
						<td align="right"> REGISTRATION NO</td>
						<td>:</td>
						<td><input class="input_field" type="text" id="reg_no" name="reg_no" value="<?php echo $reg_no;?>" readonly></td>
						<td align="right"> MARKS</td>
						<td>:</td>
						<td><input class="input_field" type="text" id="marks" name="marks" readonly></td>
					</tr>
					<tr>
						<td align="right"> VESSEL NAME</td>
						<td>:</td>
						<td><input class="input_field" type="text" id="vessel_name" name="vessel_name" value="<?php echo $vessel_name;?>" readonly /></td>
						<td align="right"> DESCRIPTION OF GOODS</td>
						<td>:</td>
						<td><input class="input_field" type="text" id="des_goods" name="des_goods" value="<?php echo $des_goods;?>" readonly></td>
					</tr>
					<tr>
						<td align="right"> MLO LINE</td>
						<td>:</td>
						<td><input class="input_field" type="text" id="mlo_line" name="mlo_line" value="<?php echo $mlo_line;?>" readonly></td>
						<td align="right"> QUANTITY</td>
						<td>:</td>
						<td><input class="input_field" type="text" id="quantity" name="quantity" value="<?php echo $quantity;?>" readonly></td>
					</tr>
					<tr>
						<td align="right"> MLO CODE</td>
						<td>:</td>
						<td><input class="input_field" type="text" id="mlo_code" name="mlo_code" value="<?php echo $mlo_code;?>" readonly></td>
						<td align="right"> UNIT</td>
						<td>:</td>
						<td><input class="input_field" type="text" id="unit" name="unit" value="<?php echo $unit;?>" readonly></td>
					</tr>
					<tr>
						<td align="right"> FFW LINE</td>
						<td>:</td>
						<td><input class="input_field" type="text" id="ffw_line"  name="ffw_line" value="<?php echo $ffw_code;?>" readonly></td>
						<td align="right"> C&F AGENT</td>
						<td>:</td>
						<td align="right"><input class="input_field" type="text" id="cnf"  name="cnf" value="<?php echo $cnf;?>" readonly></td>
					</tr>
					<tr>
						<td align="right"> FFW CODE</td>
						<td>:</td>
						<td><input class="input_field" type="text" id="ffw_code"  name="ffw_code" readonly></td>
						<td align="right"> BE NO</td>
						<td>:</td>
						<td><input class="input_field" type="text" id="be_no"  name="be_no" value="<?php echo $be_no;?>" readonly></td>
					</tr>
					<tr>
						<td align="right"> IMPORTER NAME</td>
						<td>:</td>
						<td><input class="input_field" type="text" id="importer_name"  name="importer_name" value="<?php echo $importer_name;?>" readonly></td>
						<td align="right"> BE DATE</td>
						<td>:</td>
						<td><input class="input_field" type="text" id="be_date"  name="be_date" value="<?php echo $be_date;?>" readonly></td>
					</tr>
				</table>
			</fieldset>
			<fieldset>
				<legend>Entry Part</legend>
				<table>
					<tr>
						<td width="95px" align="right"> GATE NO</td>
						<td>:</td>
						<td><input class="input" type="text" id="gate_no" name="gate_no"></td>
						<td width="130px" align="right"> DLV DT</td>
						<td>:</td>
						<td><input class="input" type="text" id="dlv_date" name="dlv_date" tabindex="3" >
						<script>
							$(function() {
								$( "#dlv_date" ).datepicker({
								changeMonth: true,
								changeYear: true,
								dateFormat: 'yy-mm-dd', // iso format
							 });
							 });
						</script></td>
					</tr>
					<tr>
						<td width="95px" align="right"> TRO/TRU#</td>
						<td>:</td>
						<td> <select id="tro" name="tro" onchange="getbalance(this.value)" tabindex="2" >
								<option value="">--Select--</option>
							</select> </td>
						<td width="130px" align="right"> DLV BALANCE QTY</td>
						<td>:</td>
						<td><input type="text" id="dlv_qty" name="dlv_qty" readonly></td>
					</tr>
				</table>
			</fieldset>	
		</div>
	</div>
	 
	<div> 
		<div align="center">
			<table>
				<tr>
					<td><input class="login_button" type="submit" style="width : 100px" value="Save"/>
					<?php echo form_close()?></td>
					<td>
						<form action="<?php echo site_url('report/cartTicketPdf');?>" method="POST" target="_blank">
							<input type="hidden" name="verify_number" id="verify_number" >
							<!--input type="hidden" name="troCart" id="troCart" value=""-->
							<input class="login_button" type="submit" style="width : 100px" value="View" name="btnCartView"/>
						</form>
					</td>
					<td>
						<form action="<?php echo site_url('gateController/chalan');?>" method="POST" target="_blank">
							<input type="hidden" name="stat" id="stat" value=1>
							<input type="hidden" name="verifyNo" id="verifyNo" >
							<input type="hidden" name="troCart" id="troCart" value="">
							<input type="hidden" name="notifyName" id="notifyName" value="">
							<input type="hidden" name="notifyAddress" id="notifyAddress" value="">
							<input class="login_button" type="submit" style="width : 100px" value="Invoice" name="btnCartView"/>
						</form>
					</td>
				</tr>
				<tr >  <td align="center" colspan="3"> <?php echo $msg?></td>
				</tr>
			</table>
		</div>
	</div>
	<?php //} //for loop end ?> 
	<?php
/*****************************************************
Developed BY: Sourav Chakraborty
Software Developer
DataSoft Systems Bangladesh Ltd
******************************************************/

$_SESSION['Control_Panel']=$this->session->userdata('Control_Panel');

?>

<!--div style="width:100%; height:500px; overflow-y:auto;">
</div-->


		 <!--</div>-->
		 </div>
         
		  
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