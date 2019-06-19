
<div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2 align="left"><span><?php echo $title; ?></span> </h2>
		  

          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>	  
		 
	
    <div class="img">
         <form name= "myForm" action="<?php echo site_url("uploadExcel/last24hrPerformancePdfUpload");?>" method="post" enctype="multipart/form-data">

            <fieldset>
                <table>
                    <tr><td colspan="3" align="center"><?php echo $msg; ?></td></tr>
					<tr>
                                <td style="width:250px;">
                               <label><nobr>PERFORMANCE DATE :</nobr><em>&nbsp;</em></label>
                               </td>
                               <td>
                                  <input type="date" style="width:160px;" id="perform_date" name="perform_date" value=""/>
                               </td>
                      </tr>
					  
                      <tr>
                               <td style="width:250px;">
                               <label><nobr>MANUAL REPORT UPLOAD  :</nobr><em>&nbsp;</em></label>
                               </td>
								<td> 
								<input type="file" style="width:200px;" id="manual_file" name="manual_file" value=""/>
								</td>
								
                        </tr>
						<tr>
                               <td>
                               <label><nobr>CTMS REPORT UPLOAD  :</nobr><em>&nbsp;</em></label>
                               </td>

                                <td>
                                  <input type="file" style="width:200px;" name="ctms_file" id="ctms_file" value=""/>
                               </td>
                        </tr>
						<tr>	
                               <td align="left" colspan='2' ><?php $arrt = array('name'=>'submit_login','id'=>'submit','value'=>'Upload','class'=>'login_button'); echo form_submit($arrt);?> </td>
                       </tr>
					   </form>
                       <!--tr><td colspan='2'><?php echo $msg; ?></td></tr-->
                      
                 </table>
                             
            </fieldset>      
                           
                          
				
                   
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