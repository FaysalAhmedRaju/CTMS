 <script type="text/javascript">	
function cngCurrency(value)
{
	//alert(value);
	var value1="";
	if(value==1)
	{
		value1=2;
	}
	else
	{
		value1=1;
	}
		var mealsByCategory = {
			1: ["BDT"],
			2: ["USD"]			
		}
		//alert(xmlhttp.responseText);
		var catOptions = "";
            for (categoryId in mealsByCategory[value1]) {
                catOptions += "<option value="+value1+">" + mealsByCategory[value1][categoryId] + "</option>";
            }
			//alert(mealsByCategory[value1]);
            document.getElementById("toCurrency").innerHTML = catOptions;
}
</script> 
<style>
	input:focus
	{
		background-color:#A9E2F3;
	}

	select:focus
	{
		background-color:#A9E2F3;
	}

</style>
 <div class="content">
    <div class="content_resize_1">
      <div class="mainbar_1">
        <div class="article">
   <h2><span><?php echo $title; ?></span> </h2>
   <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
   <div align="center"><?php echo $stat; ?></div>
   <div class="img" align="center">

    <!--form name= "myForm" onsubmit="return(validate());" action="<?php echo site_url("ShedBillController/pdf_download");?>" method="post" target="_blank"-->	
    <form name= "myForm" onsubmit="" action="<?php echo site_url("ShedBillController/addExchangeRate");?>" method="post">	
	<div align="center" style="border:1px solid grey; width:50%;">	 
						
		<table>
			<tr>
				<td>
					From Currency
				</td>
				<td>
					<select name="frmCurrency" id="frmCurrency" tabindex="2" onChange="cngCurrency(this.value)" style="width:90%;">  
						<option value="">----Select-------------</option>
						<?php 
						 for($i=0;$i<count($gkeyList);$i++) { 						
						  echo '<option value="'.$gkeyList[$i]['gkey'].'">'.$gkeyList[$i]['id'].'</option>';
						 }
						?>
				   </select>
				</td>
			</tr>
			<tr>
				<td>
					To Currency
				</td>
				<td>
					<select name="toCurrency" id="toCurrency" tabindex="2" style="width:90%;">  
						<option value="">----Select-------------</option>
						<?php 
						 for($i=0;$i<count($gkeyList);$i++) { 						
						  echo '<option value="'.$gkeyList[$i]['gkey'].'">'.$gkeyList[$i]['id'].'</option>';
						 }
						?>
				   </select>
				</td>
			</tr>
			<tr>
				<td>
					Date
				</td>
				<td>
					<input type="text" name="excngDt" id="excngDt" value="<?php echo date("Y-m-d") ?>" style="width:90%;"/>
				</td>
				<script>
					 $(function() {
					 $( "#excngDt" ).datepicker({
					  changeMonth: true,
					  changeYear: true,
					  dateFormat: 'yy-mm-dd', // iso format
					 });
					 });
				</script>
			</tr>
			<tr>
				<td>
					Rate
				</td>
				<td>
					<input type="text" name="excngRate" style="width:90%;"/>
				</td>
			</tr>
			<tr>
				<td>
					Notes
				</td>
				<td>
					<textarea name="notes"></textarea>
					
				</td>
			</tr>
			<tr>
				<td colspan=2>
					<input type="submit" class="login_button" style="width:100%;" value="SAVE"/>
				</td>
				
			</tr>
		</table>
	</div>
    </form>
	
   </div>
          <div class="clr"></div>
        </div>
       
   
      </div>
      <div class="sidebar">
    <?php include_once("mySideBar.php"); ?>
   </div>
      <div class="clr"></div>
    </div>
  </div>