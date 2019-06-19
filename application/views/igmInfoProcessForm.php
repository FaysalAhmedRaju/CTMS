<script>
function getIGMDtl()
	{		
	//alert("OK : "+rotation);
	var rotation_no=document.getElementById("rotation_no").value;
	var bl_no=document.getElementById("bl_no").value;
	
	//alert("hgh : "+rotation_no);
	
		if (window.XMLHttpRequest) 
		{

		  xmlhttp=new XMLHttpRequest();
		} 
		else 
		{  
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=stateChangeIgmDtlInfo;
		xmlhttp.open("GET","<?php echo site_url('ajaxController/getIGMDtlInfo')?>?rotation_no="+rotation_no+"&bl_no="+bl_no,false);
					
		xmlhttp.send();
	}
	
	
	function stateChangeIgmDtlInfo()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			
			//var val = xmlhttp.responseText;
			
		    //alert("OK");
			
			//var line_no=document.getElementById("line_no");
			//removeOptions(selectList);
			//alert(xmlhttp.responseText);
			var val = xmlhttp.responseText;
			var jsonData = JSON.parse(val);
			console.log(jsonData);
			//clearForm();
			if(jsonData.status_mst==0)
				{
					alert("Rotation Number Not Valid");
				}
				else if(jsonData.status_dtl==0)
				{
					//alert("BL Number Not Exist");
					for (var i = 0; i < jsonData.rtnIGMMstList.length; i++) 
					{
						document.getElementById('IGM_id').value=jsonData.rtnIGMMstList[i].id;
					}
				}
				else
				{
					//alert("BL Details Already Exist");
					/*for (var i = 0; i < jsonData.rtnIGMDtlList.length; i++) 
					{
						document.getElementById('id').value=jsonData.rtnIGMDtlList[i].id;
						document.getElementById('IGM_id').value=jsonData.rtnIGMDtlList[i].IGM_id;
						document.getElementById('line_no').value=jsonData.rtnIGMDtlList[i].Line_No;

						
						document.getElementById('pck_num').value=jsonData.rtnIGMDtlList[i].Pack_Number;
						document.getElementById('pck_desc').value=jsonData.rtnIGMDtlList[i].Pack_Description;
						document.getElementById('pck_marks_num').value=jsonData.rtnIGMDtlList[i].Pack_Marks_Number;
						document.getElementById('goods_desc').value=jsonData.rtnIGMDtlList[i].Description_of_Goods;
						document.getElementById('weight').value=jsonData.rtnIGMDtlList[i].weight;
						document.getElementById('remarks').value=jsonData.rtnIGMDtlList[i].Remarks;
						document.getElementById('cons_desc').value=jsonData.rtnIGMDtlList[i].ConsigneeDesc;
						document.getElementById('not_desc').value=jsonData.rtnIGMDtlList[i].NotifyDesc;
						document.getElementById('sub_id').value=jsonData.rtnIGMDtlList[i].Submitee_Id;
						document.getElementById('sub_dt').value=jsonData.rtnIGMDtlList[i].Submission_Date;
						document.getElementById('mlo_code').value=jsonData.rtnIGMDtlList[i].mlocode;
						document.getElementById('exp_name').value=jsonData.rtnIGMDtlList[i].Exporter_name;
						document.getElementById('exp_addr').value=jsonData.rtnIGMDtlList[i].Exporter_address;
						document.getElementById('not_code').value=jsonData.rtnIGMDtlList[i].Notify_code;
						document.getElementById('not_name').value=jsonData.rtnIGMDtlList[i].Notify_name;
						document.getElementById('not_addr').value=jsonData.rtnIGMDtlList[i].Notify_address;
						
						document.getElementById('cons_code').value=jsonData.rtnIGMDtlList[i].Consignee_code;
						document.getElementById('cons_name').value=jsonData.rtnIGMDtlList[i].Consignee_name;
						document.getElementById('cons_addr').value=jsonData.rtnIGMDtlList[i].Consignee_address;
						document.getElementById('dg_stat').value=jsonData.rtnIGMDtlList[i].DG_status;
						document.getElementById('unload_code').value=jsonData.rtnIGMDtlList[i].place_of_unloading;
						document.getElementById('origine_code').value=jsonData.rtnIGMDtlList[i].port_of_origin;
					}*/
				}
						
		}
	}
 

 
	function clearForm()
	{
		//document.getElementById('id').value="";
		document.getElementById('IGM_id').value="";
		document.getElementById('line_no').value="";
		//document.getElementById('BL_No').value="";
		document.getElementById('pck_num').value="";
		document.getElementById('pck_desc').value="";
		document.getElementById('pck_marks_num').value="";
		document.getElementById('goods_desc').value="";
		document.getElementById('weight').value="";
		document.getElementById('remarks').value="";
		document.getElementById('cons_desc').value="";
		document.getElementById('not_desc').value="";
		//document.getElementById('sub_id').value="";
		//document.getElementById('sub_dt').value="";
		//document.getElementById('Submitee_Org_Id').value=jsonData.rtnIGMDtlList[i].Submitee_Org_Id;
						
		//document.getElementById('last_update').value=jsonData.rtnIGMDtlList[i].last_update;
		//document.getElementById('type_of_igm').value="";
		//document.getElementById('weight_unit').value="";
		document.getElementById('mlo_code').value="";
		document.getElementById('exp_name').value="";
		document.getElementById('exp_addr').value="";
		document.getElementById('not_code').value="";
		document.getElementById('not_name').value="";
		document.getElementById('not_addr').value="";
					
		document.getElementById('cons_code').value="";
		document.getElementById('cons_name').value="";
		document.getElementById('cons_addr').value="";
		document.getElementById('dg_stat').value="";
		document.getElementById('unload_code').value="";
		document.getElementById('origine_code').value="";
	}
		
function validate()
      {
		  //alert("OK");
		if( document.myform.er_date.value == "" )
         {
            alert( "Please provide Rotation Number!" );
            document.myform.er_date.focus() ;
            return false;
         }
		 else{
			 return( true );
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
		
		  <?php 
		  $attributes = array('id' => 'myform','name' => 'myform','onsubmit'=>'return validate()');
		  
		  echo form_open(base_url().'index.php/igmViewController/igmInfoProcess',$attributes);
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
			 <table style="border:solid 1px #ccc;" width="450px" align="center" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<table border="0" width="650px" align="center">
								<tr>
									<td colspan="2" align="center" ><?php echo $msg; ?></td>
								</tr>
								<tr>
									<td align="right" ><label for="rotation_no">Rotation No :</label></td>
									<td >
										<input type="text" style="width:120px;" id="rotation_no" name="rotation_no"> 
										
									</td>
								</tr>
						</table>
					</td>
				</tr>
			</table>
			</br>
			<table style="border:solid 1px #ccc;" width="550px" align="center">
				<tr>
					<td>
						Line No
					</td>
					<td>
						: 
					</td>
					<td>
						<input type="text" style="width:120px;" id="line_no" name="line_no" >
					</td>
					<td>
						B/L No
					</td>
					<td>
						: 
					</td>
					<td>
						<input type="text" style="width:120px;" id="bl_no" name="bl_no" onblur="getIGMDtl()">
						<input type="hidden" style="width:120px;" id="id" name="id">
						<input type="hidden" style="width:120px;" id="IGM_id" name="IGM_id">
					</td>
				</tr>
				<tr>
					<td>
						Pack Number
					</td>
					<td>
						: 
					</td>
					<td>
						<input type="text" style="width:120px;" id="pck_num" name="pck_num" >
					</td>
					<td>
						Pack Description
					</td>
					<td>
						: 
					</td>
					<td>
						<input type="text" style="width:120px;" id="pck_desc" name="pck_desc" >
					</td>
				</tr>
				<tr>
					<td>
						Pack Marks Number
					</td>
					<td>
						: 
					</td>
					<td>
						<textarea style="width:120px;" id="pck_marks_num" name="pck_marks_num"></textarea>
					</td>
					<td>
						Description of Goods
					</td>
					<td>
						: 
					</td>
					<td>
						<textarea style="width:120px;" id="goods_desc" name="goods_desc"></textarea>
					</td>
				</tr>
				<tr>
					<td>
						Weight
					</td>
					<td>
						: 
					</td>
					<td>
						<input type="text" style="width:120px;" id="weight" name="weight" >
					</td>
					<td>
						Remarks
					</td>
					<td>
						: 
					</td>
					<td>
						<input type="text" style="width:120px;" id="remarks" name="remarks" >
					</td>
				</tr>
				<tr>
					<td>
						Consignee Description
					</td>
					<td>
						: 
					</td>
					<td>
						<textarea style="width:120px;" id="cons_desc" name="cons_desc"></textarea>
					</td>
					<td>
						Notify Description
					</td>
					<td>
						: 
					</td>
					<td>
						<textarea style="width:120px;" id="not_desc" name="not_desc"></textarea>
					</td>
				</tr>
				<!--tr>
					<td>
						Submitee Id
					</td>
					<td>
						: 
					</td>
					<td>
						<input type="text" style="width:120px;" id="sub_id" name="sub_id" >
					</td>
					<td>
						Submission Date
					</td>
					<td>
						: 
					</td>
					<td>
						<input type="text" style="width:120px;" id="sub_dt" name="sub_dt" >
						<script>
							 $(function() {
								$( "#sub_dt" ).datepicker({
										changeMonth: true,
										changeYear: true,
										dateFormat: 'yy-mm-dd', // iso format
									});
							});
						</script>
					</td>
				</tr-->
				<tr>
					<td>
						Exporter Name
					</td>
					<td>
						: 
					</td>
					<td>
						<input type="text" style="width:120px;" id="exp_name" name="exp_name" >
					</td>
					<td>
						Exporter Address
					</td>
					<td>
						: 
					</td>
					<td>
						<textarea style="width:120px;" id="exp_addr" name="exp_addr"></textarea>
					</td>
				</tr>
				<tr>
					<td>
						Notify Name
					</td>
					<td>
						: 
					</td>
					<td>
						<input type="text" style="width:120px;" id="not_name" name="not_name" >
					</td>
					<td>
						Notify Address
					</td>
					<td>
						: 
					</td>
					<td>
						<textarea style="width:120px;" id="not_addr" name="not_addr"></textarea>
					</td>
				</tr>
				<tr>
					<td>
						Notify Code
					</td>
					<td>
						: 
					</td>
					<td>
						<input type="text" style="width:120px;" id="not_code" name="not_code" >
					</td>
					<td>
						Consignee Code
					</td>
					<td>
						: 
					</td>
					<td>
						<input type="text" style="width:120px;" id="cons_code" name="cons_code" >
					</td>
				</tr>
				<tr>
					<td>
						Consignee Name
					</td>
					<td>
						: 
					</td>
					<td>
						<input type="text" style="width:120px;" id="cons_name" name="cons_name" >
					</td>
					<td>
						Consignee Address
					</td>
					<td>
						: 
					</td>
					<td>
						<textarea style="width:120px;" id="cons_addr" name="cons_addr"></textarea>
					</td>
				</tr>
				<tr>
					<td>
						Origin Code
					</td>
					<td>
						: 
					</td>
					<td>
						<input type="text" style="width:120px;" id="origine_code" name="origine_code" >
					</td>
					<td>
						Unloading Code
					</td>
					<td>
						: 
					</td>
					<td>
						<input type="text" style="width:120px;" id="unload_code" name="unload_code" >
					</td>
				</tr>
				<tr>
					<td>
						MLO Code
					</td>
					<td>
						: 
					</td>
					<td>
						<input type="text" style="width:120px;" id="mlo_code" name="mlo_code" >
					</td>
					<td>
						DG Status
					</td>
					<td>
						:
					</td>
					<td>
						<input type="text" style="width:120px;" id="dg_stat" name="dg_stat" >
					</td>
				</tr>
				<tr>
					<td colspan="6" align="center"><?php $arrt = array('name'=>'submit_login','id'=>'submit','value'=>'Save','class'=>'login_button'); echo form_submit($arrt);?></td>									
				</tr>
			</table>
		 </div>
		  <?php echo form_close()?>
          <div class="clr"></div>
        </div>
      </div>
      <div class="sidebar">
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	<?php echo form_close()?>
  </div>