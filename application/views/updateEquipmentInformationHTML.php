 <?php
	include("dbConection.php");
 ?>
 <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <span><?php echo $msg; ?></span>
		  <div class="clr"></div>
		  		 
		<div class="img">
			<table width="100%">
				<form action="<?php echo site_url('uploadExcel/updateEquipmentList');?>" method="POST">	
				<tr>
					<td>
						Equipment
					</td>
					<td>
						<input type="text" name="search">
					</td>
					<td>
						<?php $arrt = array('name'=>'Equipment','id'=>'submit','value'=>'Search','class'=>'login_button'); echo form_submit($arrt);?>
					</td>
					
				</tr>
				</form>
				</table><br/>
		 	 <!--<div id="login_container">-->
		 <table style="border:solid 1px #ccc;" width="550px" align="center" cellspacing="0" cellpadding="0">
				<tr><td>	 
		 <table align="center" border="0">		
						
						<tr bgcolor="#85DDEA">
							<th>SL.</th>
							<th>Equipment</th>
							<th>Description</th>
							<th>Capacity</th>
							<th>Action</th>
						</tr>
						<?php 
						$j=$start;
						for($i=0;$i<count($equipmentList);$i++) { 
						$j++;
						$equip=$equipmentList[$i]['equipement'];
						$strequip = "select distinct description,capacity from ctmsmis.mis_equip_detail where equipment='$equip'";
						$resequip=mysql_query($strequip,$con_sparcsn4);
						$des = "";
						$cap = "";
						while($rowequip=mysql_fetch_object($resequip))
						{
							$des = $rowequip->description;
							$cap = $rowequip->capacity;
						}
						?>
				<form action="<?php echo site_url('uploadExcel/updateEquipmentPerform');?>" method="POST">
				<input type="hidden" value="<?php echo $equipmentList[$i]['equipement'];?>"  name="myval" style="width:80px">
				<tr class="gridLight">
					<td><?php  echo $j; ?></td>
					<td><?php if($equipmentList[$i]['equipement']) echo $equipmentList[$i]['equipement']; else echo "&nbsp;"; ?></td>
					<td><input type="text" name="descValue" value="<?php echo $des;?>" style="width:200px"></td>
					<td><input type="text" name="capacity" value="<?php echo $cap;?>" style="width:80px"></td>
					<td><input type="submit" name="submit" value="Update" class="login_button"></td>				
				</tr>
				</form>
				<?php } ?>						
						
				</table>
			</td>
		</tr>
	</table>
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
 