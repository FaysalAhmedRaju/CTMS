<script>
	function changeTextBox(val)
	{
		//alert(val);
		var conboDiv = document.getElementById("conboDiv");
		var inputDiv = document.getElementById("inputDiv");
		if(val=="serial" || val=="product" || val=="ip_addr")
		{
			inputDiv.style.display="inline";
			conboDiv.style.display="none";
		}
		else
		{
			inputDiv.style.display="none";
			conboDiv.style.display="inline";
			
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
			var url = "<?php echo site_url('ajaxController/getComboValForNetworkList');?>?colName="+val;
			//alert(url);
			xmlhttp.onreadystatechange=stateChangeSearchComboVal;
			xmlhttp.open("GET",url,false);
			xmlhttp.send();
		}		
	}
		
	function stateChangeSearchComboVal()
	{
		//alert(xmlhttp.responseText);
		if (xmlhttp.readyState==4 && xmlhttp.status==200) 
		{
			var selectList=document.getElementById("searchVal");
			removeOptions(selectList);
			//alert(xmlhttp.responseText);
			var val = xmlhttp.responseText;
			var jsonData = JSON.parse(val);
			//alert(xmlhttp.responseText);
			for (var i = 0; i < jsonData.length; i++) 
			{
				var option = document.createElement('option');
				option.value = jsonData[i].id;
				option.text = jsonData[i].detl;
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

    // function validate()
    // {
        // if (confirm("Are you sure!! Delete this record?") == true) 
		// {
		   // return true ;
		// } 
		// else 
		// {
			// return false;
        // }		 
    // }
      
	// function checked()
	// {
		// if (confirm("Are you sure! you checked this record!!") == true) 
		// {
			// return true ;
		// } 
		// else 
		// {
			// return false;
		// } 
	// }
      
 </script>
<div class="content">
    <div class="content_resize">
		<div class="mainbar">
			<div class="article">
				<h2 align="left"><span><?php echo $title; ?></span> </h2>		  
				<p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
				<div class="clr"></div>	  		 	
				<div class="img">  
					<form action="<?php echo site_url('report/product_report_pdf');?>" method="POST" target="_blank">
						<table border="0" width="300px" align="center">
							<tr>
								<td colspan="5" align="center"><span><font color="green"  size="4" style="font-weight: bold"><nobr><?php echo $tableTitle; ?></nobr></font></span> </td>
							</tr>								 
							<tr>
								<td align="left" >
									<label for=""><nobr><b>Search By :</b></nobr><em>&nbsp;</em></label>
								</td>
								<td>
									<select name="search_by" id="search_by" onchange="changeTextBox(this.value);">
										<option value="serial" label="Serial No" selected style="width:110px;">Serial No</option>
										<option value="category" label="Product Category">Product Category</option>
										<option value="product" label="Product Name">Product Name</option>
										<option value="location" label="Location">Location</option>
										<!--<option value="serial" label="Serial No">Serial No</option>-->
										<option value="user" label="Updated By">Updated By</option>
										<option value="ip_addr" label="IP Address">IP Address</option>
										<option value="monitor" label="All Monitor">All Monitor</option>
									</select>
								</td>
	
								<td><b><nobr>Search Value:</nobr></b></td>
								<td>
									<div id="conboDiv" style="display:none;">
										<select name="searchVal" id="searchVal" style="width:170px">
											<option value="">---select---</option>
										</select>
									</div>
									<div id="inputDiv" style="">
										<input type="text" style="width:170px" id="searchInput" name="searchInput" autofocus />
									</div>
								</td>
							</tr>	
							<tr>
							<td align="right" colspan="2">
								<label for="Excel" style="font-size:11px;width:100%;margin:0;padding:0;text-align:right;width:75%;">Excel</label>
								<?php 	$data = array(
								'name'        => 'fileOptions',
								'id'          => 'fileOptions',
								'value'       => 'xl',
								'checked'     => FALSE,
								'style'       => 'width:2em;border:none;display:block;float:right;margin:0 5px 0 0;padding:0;',
								);
								echo form_radio($data); ?>
							</td>
							 	<!--td align="left">
									<label for="HTML" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">HTML</label>
									<?php 	$data = array(
												'name'        => 'fileOptions',
												'id'          => 'fileOptions',
												'value'       => 'html',
												'checked'     => TRUE,
												'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
												);
									echo form_radio($data); ?>
								</td--> 
								<td align="left" colspan="2">
									<label for="PDF" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">PDF</label>
									<?php 	$data = array(
												'name'        => 'fileOptions',
												'id'          => 'fileOptions',
												'value'       => 'pdf',
												'checked'     => FALSE,
												'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
												);
									echo form_radio($data); ?>
								</td>
							</tr>
							<tr>	
								<td  align="center" width="70px" colspan="4">
									<input type="submit" value="View" name="View" class="login_button">
								</td>
							</tr>
							
						</table>
					</form>	
				</div>			
				<div class="clr"></div>
			</div>
		</div>
		<div class="sidebar" style="width:140px; padding: 0px 0 12px;">
			<?php include_once("mySideBar.php"); ?>
		</div>
		<div class="clr"></div>
    </div>
	<?php echo form_close()?>
</div>