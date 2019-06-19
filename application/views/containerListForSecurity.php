<script>
	function changeTextBox(val)
		{
			//alert(val);
			var conboDiv = document.getElementById("conboDiv");
			var inputDiv = document.getElementById("inputDiv");
			if(val=="Date")
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
				var url = "<?php echo site_url('ajaxController/getGateList');?>?colName="+val;
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
				option.text = jsonData[i].id;
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

      
 </script>
 <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2 align="left"><span><?php echo $title; ?></span> </h2>
		  

          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>	  
		 
	
	<div class="img">  
            <form action="<?php echo site_url('report/containerListForSecurityBySearch');?>" method="POST" target="_blank" >
            <table border="0" width="300px" align="center">
		<tr><td colspan="4" align="center"><h2><span><font color="green"  size="4" style="font-weight: bold"><nobr><?php echo $tableTitle; ?></nobr></font></span> </h2></td></tr>


		<tr>		
		<td align="left" >
		<label for=""><nobr><b>Search By :</b></nobr><em>&nbsp;</em></label></td>

                <td>
                    <select style="width:170px" name="search_by" id="search_by" onchange="changeTextBox(this.value);">
                        <option value="" >Select</option>
                        <option value="Gate" label="Gate">Gate</option>
                        <option value="Date" label="Date">Date</option>
                     </select>
				</td>
				</tr>
				<tr>

		<td><b><nobr>Search Value:</nobr></b></td>
		<td>
			<div id="conboDiv" style="display:none;">
				<select name="searchVal" id="searchVal" style="width:170px">
				<option value="">---select---</option>
				</select>
			</div>
			<div id="inputDiv" style="">
				<input type="text" style="width:170px" id="searchInput" name="searchInput"  />
				 <script>
								$( function() {
								$( "#searchInput" ).datepicker({
								changeMonth: true,
								changeYear: true,
								dateFormat: 'yy-mm-dd', // iso format
								});
								} );
						</script>
			</div>
		</td>
		</tr>
		<tr>
		<td  colspan="2" align="center" width="70px">
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
  </div>
  

  