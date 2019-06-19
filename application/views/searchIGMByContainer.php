<script type="text/javascript">
	function validate()
	{
		if( document.myForm.container.value == "" )
		{
			alert( "Please provide Container No!" );
			document.myForm.container.focus() ;
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
					<form name= "myForm" onsubmit="return(validate());" action="<?php echo site_url("report/searchIGMByContainerPerform");?>" method="post">
						<table align="center" style="border:solid 1px #ccc;" width="350px" align="center" cellspacing="0" cellpadding="0">
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="right" ><label><font color='red'><b>*</b></font>Container</label></td>
								<td>:</td>
								<td>
									<input type="text" style="width:130px;" id="container" name="container"/>
								</td>
								<td align="left">
									<input type="submit" value="Search" class="login_button"/>      
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
						</table>
					</form>
					<?php
					if($flag==1)
					{
					?>
						<table width="400px">
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr class="gridDark">
								<th>Sl</th>
								<th>Import Rotation No</th>
								<th>Container No</th>
								<th>Size</th>
								<th>Height</th>
								<th>MLO Code</th>
							</tr>
							<?php
							for($i=0;$i<count($rslt_container_search);$i++)
							{
							?>
							<tr class="gridLight">
								<td align="center"><?php echo $i+1;?></td>
								<td align="center"><?php echo $rslt_container_search[$i]['Import_Rotation_No']?></td>
								<td align="center"><?php echo $rslt_container_search[$i]['cont_number']?></td>
								<td align="center"><?php echo $rslt_container_search[$i]['cont_size']?></td>
								<td align="center"><?php echo $rslt_container_search[$i]['cont_height']?></td>
								<td align="center"><?php echo $rslt_container_search[$i]['mlocode']?></td>
							</tr>
							<?php
							}
							?>
						</table>
					<?php
					}
					?>
				</div>
         
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