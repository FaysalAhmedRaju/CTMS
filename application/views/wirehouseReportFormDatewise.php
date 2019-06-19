 <script type="text/javascript">
   
			function validate()
			{
				if( document.myForm.fromdate.value == "" )
				{
					alert( "Please provide fromdate!" );
					document.myForm.fromdate.focus() ;
					return false;
				}
				
				if( document.myForm.todate.value == "" )
				{
					alert( "Please provide todate!" );
					document.myForm.todate.focus() ;
					return false;
				}
				return true ;
			}
</script> 
 
 <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
			<h2><span><?php echo $title; ?></span> </h2>
			<p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
			
			<div class="clr"></div>
			<div class="img">
		 	 <!--<div id="login_container">-->
				<form name= "myForm" onsubmit="return(validate());" action="<?php echo site_url("report/wireHouseReportDatewise");?>" target="_blank" method="post">
					<table align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td align="left" ><label><font color='red'><b>*</b></font>From:</label></td>
								<td>
									<input type="text" style="width:130px;" id="fromdate" name="fromdate" value="<?php date("Y-m-d"); ?>"/>
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
						 <td>&nbsp;</td>
						</tr>
						<tr>
							<td align="left" ><label><font color='red'><b>*</b></font>To:</label></td>
							<td> 
								<input type="text" style="width:130px;" id="todate" name="todate" value="<?php date("Y-m-d"); ?>"/>
							</td>
							<script>
								$(function() {
								$( "#todate" ).datepicker({
									changeMonth: true,
									changeYear: true,
									dateFormat: 'yy-mm-dd', // iso format
								});
								});
							</script>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<input type="submit" value="View" class="login_button"/>      
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
					</table>
				</form>
							
						</td>
					</tr>
				</table>
			
		 
		 <!--</div>-->
		 </div>
         <!-- <div class="post_content">
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. <a href="#">Suspendisse bibendum. Cras id urna.</a> Morbi tincidunt, orci ac convallis aliquam, lectus turpis varius lorem, eu posuere nunc justo tempus leo. Donec mattis, purus nec placerat bibendum, dui pede condimentum odio, ac blandit ante orci ut diam. Cras fringilla magna. Phasellus suscipit, leo a pharetra condimentum, lorem tellus eleifend magna, eget fringilla velit magna id neque. Curabitur vel urna. In tristique orci porttitor ipsum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. Suspendisse bibendum. Cras id urna. Morbi tincidunt, orci ac convallis aliquam, lectus turpis varius lorem, eu posuere nunc justo tempus leo.</p>
            <p><strong>Aenean consequat porttitor adipiscing. Nam pellentesque justo ut tortor congue lobortis. Donec venenatis sagittis fringilla.</strong> Etiam nec libero magna, et dictum velit. Proin mauris mauris, mattis eu elementum eget, commodo in nulla. Mauris posuere venenatis pretium. Maecenas a dui sed lorem aliquam dictum. Nunc urna leo, imperdiet eu bibendum ac, pretium ac massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla facilisi. Quisque condimentum luctus ullamcorper.</p>
            <p class="spec"><a href="#" class="rm">Read more &raquo;</a></p>
			
			
          </div>-->
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