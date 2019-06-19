<div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
			<div class="img">
			<table style="border:solid 1px #ccc;" width="500px" align="center" cellspacing="0" cellpadding="0" >
				<tr><td>	
			<TABLE width="100%" border="0" align="center">
			 <?php 
			$attributes=array('target' =>'_blank');
			echo form_open(base_url().'index.php/igmViewController/viewIGMList',$attributes);
			$Stylepadding = 'style="padding: 12px 20px;"';
				if(!empty($error_message))
				{
					$Stylepadding = 'style="padding:25px 20px;"';
				}	
				if(isset($captcha_image)){
					$Stylepadding = 'style="padding:62px 20px 93px;"';
				}?>
			<!--<form name="frm2" action="home.php?myflag=136" method="post"  >-->
		
			<table width="100%" border="0">
<tr><td width="40%"><font color="#608EC6" size="4">Import Rotation No</font> </td><td> <input type="text" name="impno" onkeyup="valid(this.value)" value="<?php print($this->impno); ?>"></td></tr>
<tr><td><font color="#608EC6" size="4">Line  No</font>  </td><td><input type="text" name="lineno" value="<?php print($this->lineno); ?>"></td></tr>
<tr>
	<td><font color="#608EC6" size="4">IGM Type</font> </td>				
	<td>Main Line<input type="radio" name="options" value="igm">&nbsp;Supplementary<input type="radio" name="options" value="suppl"></td>
</tr>
<tr align="center"><td colspan="2" ><font color="#608AAA" size="6" align="center">OR</font> </td></tr>
<tr><td><font color="#608EC6" size="4">Import Rotation No</font> </td><td> <input type="text" name="impno1" onkeyup="valid(this.value)" value="<?php if($this->impno1) print($this->impno1); ?>"></td></tr>
<tr><td><font color="#608EC6" size="4">BL No</font>  </td><td><input type="text" name="blno" value="<?php if($this->blno) print($this->blno); ?>"></td></tr>
<tr ><td></td><td colspan="2">&nbsp;</td></tr>
<tr ><td></td><td colspan="2"><input type="Submit" name="Add" value="view" ></td></tr>
</table>
							
		<?php echo form_close()?>
		</TABLE>
			</td></tr></table>
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