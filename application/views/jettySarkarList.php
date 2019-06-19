<script type="text/javascript">
	function delete_jty_sarkar()
	{
		if (confirm("Do you want to detete this entry?") == true)
		{
			return true ;
		}
		else
		{
			return false;
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
<html>
<div class="content">
    <div class="content_resize">
		<div class="mainbar_1">
			<div class="article">
				<h2 align="center"><span><?php echo $title; ?></span> </h2>
				<p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
   
				<div class="clr"></div>
					<div class="img">
						<div id="table-scroll">
	<table cellspacing="1" cellpadding="1" align="center" id="mytbl" style="width:600px; padding-left: 60px;" >
		<tr class="gridDark" style="height:35px;">
			<th>SL</th>
			<th>JS NAME</th>
			<th>LICENSE NO</th>
			<!--th>CONTACT NO</th>
			<th>ADRRESS</th-->
			<th>PICTURE</th>
			<th>SIGNATURE</th>
			<th>LICENSE</th>
			<th>GATE PASS</th>
			<th>ACTION</th>
			<th>ACTION</th>
		</tr>
		
	  <?php
       
        for($i=0;$i<count($js);$i++) { 
		
			
		?>
	<!-- n4_bizu_gkey, js_name, js_lic_no, cell_no, adress, last_update, update_by,user_ip -->
							
	      
		  <td align="center" >
           <?php echo $i+1;?>
          </td>
 
          <td align="center">
           <?php echo $js[$i]['js_name']?>
          </td>
          <td align="center">
           <?php echo $js[$i]['js_lic_no']?>
          </td>
          <!--td align="center">
           <?php echo $js[$i]['cell_no']?>
          </td>
          <td align="center">
           <?php echo $js[$i]['adress']?>
		</td-->	
		<td align="center">
			<?php   
			$picture=str_replace('-','',$js[$i]['js_img_path']);
			$signature=str_replace('-','',$js[$i]['signature_path']);
			$license_copy=str_replace('-','',$js[$i]['lic_copy_path']);
			$gate_pass=str_replace('-','',$js[$i]['gate_pass_path']);
			
			?>
		   <img align="middle"  width="100px" height="40px" src="<?php echo JTY_SIG_PATH.''.$picture; ?>">
		</td>	
		<td align="center">
           <img align="middle"  width="100px" height="40px" src="<?php echo JTY_SIG_PATH.''.$signature; ?>">
		</td>	
		<td align="center">
          <img align="middle"  width="100px" height="40px" src="<?php echo JTY_SIG_PATH.''.$license_copy; ?>">
		</td>	
		<td align="center">
           <img align="middle"  width="100px" height="40px" src="<?php echo JTY_SIG_PATH.''.$gate_pass; ?>">
		</td>	
		  <td align="center">
           <form action="<?php echo site_url('report/jettySarkarEntryFormEdit');?>" method="POST">
				<input type="hidden" name="jsId" value="<?php echo $js[$i]['id'];?>">		
				<input type="hidden" name="editFlag" value="1">		
				<input type="hidden" name="updateFlag" value="<?php echo $updateFlag;?>">		
					
				<input type="submit" value="Edit" name="start" class="login_button" style="width:100%;">							
			</form>
          </td> 
		   <td align="center">
           <form action="<?php echo site_url('report/jettySarkarEntryDelete');?>" method="POST" onsubmit="return(delete_jty_sarkar());">
				<input type="hidden" name="jsId" value="<?php echo $js[$i]['id'];?>">		
				<input type="submit" value="Delete" name="Delete" class="login_button" style="width:100%;">							
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
      <div class="sidebar" style="width:10px">
    <?php include_once("mySideBar.php"); ?>
   </div>
      <div class="clr"></div>
    </div>
 <?php echo form_close()?>
  </div>
  <!--/body-->
  </html>