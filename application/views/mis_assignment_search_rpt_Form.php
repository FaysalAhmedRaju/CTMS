<script type="text/javascript">

function changeTextBox(v)
{
	    var search_value = document.getElementById("search_value");
		var fromdate = document.getElementById("fromdate");
		if(v=="date")
		{
			search_value.value=null;
			search_value.disabled=true;
			fromdate.disabled=false;		
		}
		else if(v=="bl_no")
		{
			fromdate.value=null;
			search_value.disabled=false;
			fromdate.disabled=true;	
		}
		else if(v=="user")
		{
			fromdate.value=null;
			search_value.value=null;
			search_value.disabled=false;
			fromdate.disabled=false;	
		}	
		else if(v=="all")
		{
			fromdate.value=null;
			search_value.value=null;
			search_value.disabled=true;
			fromdate.disabled=true;	
		}			
		else if(v=="")
		{
			search_value.value=null;
			fromdate.value=null;
			search_value.disabled=true;
			fromdate.disabled=true;
		}
		else 
		{
			fromdate.value=null;
			search_value.disabled=false;
			fromdate.disabled=true;			
		}	
}
</script>
<style>
     #table-scroll {
	  height:500px;
	  width: 1000px;
	  overflow:auto;  
	  margin-top:0px;
      }
</style>
 <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
		  
		  <?php 
		  $attributes = array('target' => '_blank', 'id' => 'myform');
		  
		  echo form_open(base_url().'index.php/report/mis_assignment_entry_rpt',$attributes);
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
			<table border="0" width="300px" align="center">
								<tr>
									<td align="right" colspan="2"></td>
								</tr>
								 
                                <tr>
									<td align="left" >
									<label for=""><font color='red'></font>Search By :<em>&nbsp;</em></label></td>
									<td>
									        <select name="search_by" id="search_by" class="" onchange="changeTextBox(this.value);">
												<option value="" label="search_by" selected style="width:110px;">---Select-------</option>
												<option value="all" label="All" >All</option>
												<option value="date" label="date" >Date</option>
												<option value="bl_no" label="bl_no" >Bl No</option>
												<option value="user" label="user" >User</option>														
											</select>

									</td>
								</tr>	
								
								
								 <tr>
									<td align="left" ><label for=""><font color='red'></font><nobr>Search value :<nobr><em>&nbsp;</em></label></td>
									<td>
									<input type="text" style="width:150px;" id="search_value" name="search_value" disabled> 
									</td>
								</tr>	


                                <tr colspan="4">
									   <td align="left" ><label><font color='red'></font>Search Date:</label></td>
										<td>
										 <input type="text" style="width:130px;" id="fromdate" name="fromdate" value="<?php date("Y-m-d"); ?>" disabled />
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
								</tr>
								<tr>
									
									<td align="left">
									
										
										</td>
										<td>
										<table><tr>
									<td align="left">
										<label for="HTML" style="font-size:11px;width:100%;margin:0;padding:0;text-align:left;width:75%;">HTML</label>
										<?php 	$data = array(
													'name'        => 'options',
													'id'          => 'options',
													'value'       => 'html',
													'checked'     => TRUE,
													'style'       => 'width:2em;border:none;display:block;float:left;margin:0 5px 0 0;padding:0;',
													);
										echo form_radio($data); ?>
										
									</td>
									</tr></table></td>
								</tr>
								<tr>
									<td colspan="2" align="center" width="70px">
									<input type="submit" value="View" name="View" class="login_button">
									</td>
								</form>	
								</tr>

							</table>
						</td>
					</tr>
				</table>
		</form>
   
		 
		 <!--</div>-->
		 </div>
         <!-- <div class="post_content">
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. <a href="#">Suspendisse bibendum. Cras id urna.</a> Morbi tincidunt, orci ac convallis aliquam, lectus turpis varius lorem, eu posuere nunc justo tempus leo. Donec mattis, purus nec placerat bibendum, dui pede condimentum odio, ac blandit ante orci ut diam. Cras fringilla magna. Phasellus suscipit, leo a pharetra condimentum, lorem tellus eleifend magna, eget fringilla velit magna id neque. Curabitur vel urna. In tristique orci porttitor ipsum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. Suspendisse bibendum. Cras id urna. Morbi tincidunt, orci ac convallis aliquam, lectus turpis varius lorem, eu posuere nunc justo tempus leo.</p>
            <p><strong>Aenean consequat porttitor adipiscing. Nam pellentesque justo ut tortor congue lobortis. Donec venenatis sagittis fringilla.</strong> Etiam nec libero magna, et dictum velit. Proin mauris mauris, mattis eu elementum eget, commodo in nulla. Mauris posuere venenatis pretium. Maecenas a dui sed lorem aliquam dictum. Nunc urna leo, imperdiet eu bibendum ac, pretium ac massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla facilisi. Quisque condimentum luctus ullamcorper.</p>
            <p class="spec"><a href="#" class="rm">Read more &raquo;</a></p>
			
			
          </div>-->
		  <?php echo form_close()?>
          <div class="clr"></div>
        </div>
       
       <!-- <p class="pages"><small>Page 1 of 2</small> <span>1</span> <a href="#">2</a> <a href="#">&raquo;</a></p>-->
      </div>
      <div class="sidebar">
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	<?php echo form_close()?>
  </div>
  