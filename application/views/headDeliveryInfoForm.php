
<div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2 align="left"><span><?php echo $title; ?></span> </h2>
		  

          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>	  
		 
	
    <div class="img">
        <form name= "myForm" onsubmit="return validate();" action="<?php echo site_url("report/headDeliveryPerformPDF");?>" method="post" target="_blank">
            <fieldset>
                <table>
                    <!--<tr><td colspan="3" align="center"><h2><span>Container Search </h2></td></tr>-->
                   <tr>
                           <td>
                               <label><nobr>Container :</nobr><em>&nbsp;</em></label>
                               </td>
                               <td>
                                  <input type="text" style="width:160px;" id="cont" name="cont" value=""/>
                               </td>
                               <td align="left"><?php $arrt = array('name'=>'submit_login','id'=>'submit','value'=>'Search','class'=>'login_button'); echo form_submit($arrt);?> </td>
                       </tr>
<!--                       <tr>
                            <td align="right" colspan="2">
                                <?php if($editFlag==1){?>
                                <input class="login_button"  name="update" type="submit"  value="UPDATE" > 
                                <?php } else{?>
                                 <input class="login_button"  name="save" type="submit"  value="SAVE" > 
                                <?php } ?> 
                            </td>

                        </tr>-->
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