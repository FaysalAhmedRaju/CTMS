 
 <script type="text/javascript">
  $(function() {
    $("#equipment").change(function() {
        if ($(this).val() == "All") {
			//console.log(false);
            $("#srcVal").attr("disabled", "disabled");
			$("#srcVal").val("");
        }
        else {
            //console.log(true);
            $("#srcVal").removeAttr("disabled");
        }
    });
});

  function getBlock(yard)
	{		
	
		if (window.XMLHttpRequest) 
		{

		  xmlhttp=new XMLHttpRequest();
		} 
		else 
		{  
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=stateChangeYardInfo;
		xmlhttp.open("GET","<?php echo site_url('ajaxController/getBlockCpa')?>?yard="+yard,false);
					
		xmlhttp.send();
	}
	
	
	function stateChangeYardInfo()
	{			
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			
			var val = xmlhttp.responseText;
			
		    //alert(val);
			
			var selectList=document.getElementById("block");
			removeOptions(selectList);
			//alert(xmlhttp.responseText);
			var val = xmlhttp.responseText;
			var jsonData = JSON.parse(val);
			//alert(xmlhttp.responseText);
			for (var i = 0; i < jsonData.length; i++) 
			{
				var option = document.createElement('option');
				option.value = jsonData[i].block;  //value of option in backend
				option.text = jsonData[i].block;	  //text of option in frontend
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
		function validate()
      {
		  //alert("test"+document.myform.fromdate.value);
		 if( document.myform.rotNum.value == "" )
         {
            alert( "Please provide Rotation No!" );
            document.myform.rotNum.focus() ;
            return false;
         }
		   if( document.myform.fromdate.value == "" )
         {
            alert( "Please provide From Date!" );
            document.myform.fromdate.focus() ;
            return false;
         }
		  if( document.myform.fromTime.value == "" )
         {
            alert( "Please provide From Time!" );
            document.myform.fromTime.focus() ;
            return false;
         }
		  if( document.myform.todate.value == "" )
         {
            alert( "Please provide To Date!" );
            document.myform.todate.focus() ;
            return false;
         }
		  if( document.myform.toTime.value == "" )
         {
            alert( "Please provide To Time!" );
            document.myform.toTime.focus() ;
            return false;
         }
		 return( true );
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
		  $attributes = array('target' => '_blank', 'id' => 'myform','name' => 'myform','onsubmit'=>'return validate()');
		  
		  echo form_open(base_url().'index.php/report/yardWiseContainerHandlingView',$attributes);
			$Stylepadding = 'style="padding: 12px 20px;"';
				if(!empty($error_message))
				{
					$Stylepadding = 'style="padding:25px 20px;"';
				}	
				if(isset($captcha_image)){
					$Stylepadding = 'style="padding:62px 20px 93px;"';
				}?>
	
		<div class="img">
		 <table style="border:solid 1px #ccc;" width="700px" align="center" cellspacing="0" cellpadding="0">
				<tr><td>	 
		 <table align="center" border ="0">
						<tr>				
							<td align="right" ><label for="block">Rotation Number:<em>&nbsp;</em></label></td>
							<td align="left" >
								<input type="text" id="rotNum" class="login_input_text" name="rotNum" >
							</td>
						</tr>
						<tr>
										<td>
										<label for="field3"><font color='red'><b>*</b></font>TERMINAL:</label></td>
										<td>
											<select name="yard_no" id="yard_no" class="" onchange="getBlock(this.value)";>
											<option value="" label="yard_no" selected style="width:130px;">Select</option>
												<option value="CCT" label="CCT" >CCT</option>
												<option value="NCT" label="NCT" >NCT</option>
												<option value="GCB" label="GCB">GCB</option>
										</select>
										</td>
									</tr>
									<tr>
										<td>
										<label for="field4"><font color='red'><b>*</b></font>BLOCK :</label></td>
										<td>
											<select name="block" id="block">
											<option value="ALL">---Select---</option>																						
										</select>
										</td>
									</tr>
									<tr>
									
									<td align="left" ><label><font color='red'><b>*</b></font>From Date:</label>
											<td> 
											<input type="text" style="width:120px;" id="fromdate" name="fromdate" value="<?php date("Y-m-d"); ?>"/>
											</td>
								
											<script>
											  $(function() {
												$( "#fromdate" ).datepicker({
													changeMonth: true,
													changeYear: true,
													dateFormat: 'yy-mm-dd', // iso format
												});
											});
									</script>
									</td>
									
									<td align="left"><label><font color='red'><b>*</b></font>From Time:</label>
									<input type="text" style="width:120px;" id="fromTime" name="fromTime"> (HH:MM)(24 hrs)
									</td>
								</tr>
									<tr>
									<td align="left" ><label><font color='red'><b>*</b></font>To Date:
									<td ><input type="text" style="width:120px;" id="todate" name="todate" value="<?php date("Y-m-d"); ?>"/></td>
									</label> 
									<script>
											  $(function() {
												$( "#todate" ).datepicker({
													changeMonth: true,
													changeYear: true,
													dateFormat: 'yy-mm-dd', // iso format
												});
											});
									</script>
									</td>
									<td align="left"><label><font color='red'><b>&nbsp;&nbsp;  *</b></font>  To Time        :</label>
									<input type="text" style="width:120px;" id="toTime" name="toTime"> (HH:MM)(24 hrs)
									</td>
									</tr>
						<tr align="center">
							
							<td colspan="2" align="center" width="70px"><br><?php $arrt = array('name'=>'report','id'=>'submit','value'=>'Show','class'=>'login_button'); echo form_submit($arrt);?>	
							
							</td>
							
						</tr>
						<tr><td colspan="2">&nbsp;</td></tr>
				</table>
			</td>
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