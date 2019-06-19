<script type="text/javascript">

	function getList()
		{
			if (window.XMLHttpRequest) 
			{
			 xmlhttp=new XMLHttpRequest();
			} 
			else 
			{  
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}

				var search_by = document.myForm.search_by.value;
				//alert(search_by);
				
				var url = "<?php echo site_url('ajaxController/getOrgResult')?>?search_by="+search_by;
				//xmlhttp.open("GET","<?php echo site_url('ajaxController/getLCLContInfo')?>?cont="+cont,false);
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
			var selectList=document.getElementById("list");
			removeOptions(selectList);
			//alert(xmlhttp.responseText);
			var val = xmlhttp.responseText;
			//alert(val);
			var jsonData = JSON.parse(val);
			//alert(xmlhttp.responseText);
			for (var i = 0; i < jsonData.length; i++) 
			{
				var option = document.createElement('option');
				option.value = jsonData[i].type;  //value of option in backend
				option.text = jsonData[i].type;	  //text of option in frontend
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
        if (confirm("Are you sure!! Delete this record?") == true) {
		   return true ;
	} else {
		 return false;
            }		 
      }

</script>
<style>
     #table-scroll {
	  height:500px;
	  width: 600px;
	  overflow:auto;  
	  margin-top:0px;
      }
</style>

<div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
		   <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>

   <h2><span><?php echo $title; ?></span> </h2>
   
   <div class="clr"></div>
   <div class="img">
       <form name= "myForm"  action="<?php echo site_url("report/organizationTypeListSearch");?>" method="post">
   
  			<table cellspacing="1" cellpadding="1" align="center">
				<tr>
					<td align="right" colspan="2"></td>
				</tr>
				<td colspan="2" align="left" style="padding-left:15px;">
					<a href="<?php echo site_url('report/organizationTypeEntryForm') ?>"  class="login_button" name="print" style="padding:4px;" target="_self"><font size="2" color="#424242">ADD NEW ORG.TYPE</font></a>
				</td>
				<tr>
					<td align="right" colspan="2"></td>
				</tr>
				 
				<tr>
					<td align="left" >
					<label for=""><nobr>Search By :<em>&nbsp;</em></nobr></label></td>
					<td>
							<select name="search_by" id="search_by" name="search_by" class="" onchange="getList(this.value);">
								<option value="" selected style="width:110px;">---Select-------</option>
								<option value="org">Organization</option>														
							</select>

					</td>

				<!--th align="center"><label><nobr><font color='red'></font>Search Value:</nobr></label></th-->
				<td>
					<select id="list" name="list" style="width:150px;">
						<option value="">--Select--</option>
					</select>
				</td>
				
				<td colspan="2" align="center" width="70px">
					<input type="submit" value="View" name="save" class="login_button">
				</td>
			</tr>
		</table>

		</form>
   
	<br/>
	<div id="table-scroll" >
	<table cellspacing="1" cellpadding="1" align="center">
		<tr class="gridDark" style="height:45px; bgcolor:#BDBDBD" >
			<th>SL</th>
			<th>ORG. TYPE</th>
			<th>DESCRIPTION</th>		
			<th>EDIT</th>		
			<th>DELETE</th>		
			
		</tr>
		
	  <?php
       
        for($i=0;$i<count($formList);$i++) { 
         ?>
         <tr class="gridLight">
          <td>
           <?php echo $i+1;?>
          </td>
         <!-- <td align="center" >
           <?php echo $formList[$i]['id']?>
          </td> Org_Type, users_section_detail.short_name, url_details.url_title, login_id 
		  -->
          <td align="center">
           <?php echo $formList[$i]['Org_Type']?>
          </td>
          <td align="center">
           <?php echo $formList[$i]['Type_description']?>
          </td>

		  <td align="center">
			<form action="<?php echo site_url('report/organizationTypeEdit');?>" method="POST">
				<input type="hidden" name="listId" value="<?php echo $formList[$i]['id'];?>">							
				<input type="submit" value="Edit" name="Edit" class="login_button" >							
			</form> 
        </td> 
		<td align="center">
			<form action="<?php echo site_url('report/organizationTypeList');?>" method="POST" onsubmit="return validate();">
				<input type="hidden" name="listId" value="<?php echo $formList[$i]['id'];?>">							
				<input type="submit" value="Delete" name="delete" class="login_button" >							
			</form> 
        </td> 
		
		  
         </tr>
         <?php
        }
       ?>
	</table>
  </div>
   </div>

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
  