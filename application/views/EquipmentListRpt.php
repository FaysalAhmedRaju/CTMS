 <!-- <link rel="stylesheet" href="<?php echo base_url("resources/styles/bootstrap.min.css");?>"> -->
 <style>
 .table-hover > tbody > tr:hover {
  background-color: #f5f5f5;
}
 </style>
 <script Language="JavaScript">
 function ClickStart(val) 
{
	var strtQuery="";
	//alert(val);
	if (window.XMLHttpRequest) 
	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} 
	else 
	{  
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	if(val="0")
	{
		alert("Start");
		xmlhttp.open("POST","<?php echo site_url('ajaxController/getBlockList')?>?yard="+val+"&jval="+jval,false);
		xmlhttp.send();
	}
	else{
		alert("End");
		xmlhttp.open("POST","<?php echo site_url('ajaxController/getBlockList')?>?yard="+val+"&jval="+jval,false);
	    xmlhttp.send();
	}
	
}
function getShiftName(shift,jval)
{
	//alert("ShiftName : "+shift+jval);
	var sval = "shift"+jval;
	var shiftBox = document.getElementById(sval);
	//alert(shiftBox);
	shiftBox.value = shift;
	
	//alert(shiftBox.value);
}
 </script>
 <?php
	include("dbConection.php");
 ?>
 <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div align="center"><span><?php echo $msg; ?></span></div>
		  <div class="clr"></div>

		<div class="img">
			<table style="width:100%">
				<form action="<?php echo site_url('uploadExcel/blockWiseEquipmentList');?>" method="POST">	
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
							<th>Serial No</th>
							<th>Block</th>						
							<th>Equipment</th>
							<th>Shift</th>
							<th>Action</th>
							<th>Action</th>
						</tr>
						<?php 
						$j=$start;
						for($i=0;$i<count($equipmentList);$i++) { 
						$j++;
						$equip = $equipmentList[$i]['equipement'];
						?>
				<tr class="gridLight">
					<td><?php  echo $j; ?></td>					
					<td><?php if($equipmentList[$i]['Block']) echo $equipmentList[$i]['Block']; else echo "&nsp;"; ?></td>					
					<td><?php if($equipmentList[$i]['equipement']) echo $equipmentList[$i]['equipement']; else echo "&nbsp;"; ?></td>							
					<td>
					<!--select name="shift" id="shift" onchange="getShiftName(this.value,<?php echo $j;?>)"-->
					
					<?php 
							
							$str1 = "select shift from ctmsmis.mis_equip_detail
							inner join ctmsmis.mis_equip_assign_detail on ctmsmis.mis_equip_assign_detail.equip_detail_id=ctmsmis.mis_equip_detail.id
							where equipment='$equip' and start_state=1 and end_state=0 and work_out_state=0 and date(start_work_time)=date(now()) 
							order by ctmsmis.mis_equip_assign_detail.id desc limit 1";
							//echo "Query : ".$str1;
							$res1 = mysql_query($str1);
							$row1 = mysql_fetch_object($res1); 
							$num_rows = mysql_num_rows($res1);	
							$sftVal = $row1->shift;
					?>
					
					<select name="shift" id="shift" onchange="getShiftName(this.value,<?php echo $j;?>)">											
						  <option value="">--Select--</option>
						  <option value="A" <?php if($sftVal=='A'){?> selected <?php } ?> >A</option>
						  <option value="B" <?php if($sftVal=='B'){?> selected <?php } ?> >B</option>
						  <option value="C" <?php if($sftVal=='C'){?> selected <?php } ?> >C</option>					  
					</select> 
					</td>
				
				
					<td>
						<?php
							$str = "select ctmsmis.mis_equip_assign_detail.id,ctmsmis.mis_equip_assign_detail.start_state,ctmsmis.mis_equip_assign_detail.end_state,ctmsmis.mis_equip_assign_detail.work_out_state from ctmsmis.mis_equip_detail
							inner join ctmsmis.mis_equip_assign_detail on ctmsmis.mis_equip_assign_detail.equip_detail_id=ctmsmis.mis_equip_detail.id
							where ctmsmis.mis_equip_detail.equipment='$equip' and date(start_work_time) = date(now()) order by ctmsmis.mis_equip_assign_detail.id desc limit 1";
							$res = mysql_query($str);
							$row = mysql_fetch_object($res);
							
							$start_state = $row->start_state;
							$end_state=$row->end_state;
							$work_out_state=$row->work_out_state;
							$id=$row->id;
							
							if(($start_state==0 and $end_state==0) or ($start_state==1 and $work_out_state==1) or ($start_state==1 and $end_state==1))
							{
						?>
						<form action="<?php echo site_url('uploadExcel/equipmentStartWorkoutPerform');?>" method="POST">
							<input type="hidden" name="block" value="<?php echo $equipmentList[$i]['Block'];?>">
							<input type="hidden" name="equipment" value="<?php echo $equipmentList[$i]['equipement'];?>">
							<input type="hidden" id="shift<?php echo $j;?>" name="shift<?php echo $j;?>" value="">
							<input type="hidden" id="jval" name="jval" value="<?php echo $j;?>">
							<input type="hidden" name="btnState" value="start">
							<input type="submit" value="Start" name="start" class="login_button">							
						</form> 
						<?php
							}
							/*
							else if($start_state==1 && $work_out_state==1)
							{
						?>
						<form action="<?php echo site_url('uploadExcel/equipmentStartWorkoutPerform');?>" method="POST">
							<input type="hidden" name="block" value="<?php echo $equipmentList[$i]['Block'];?>">
							<input type="hidden" name="equipment" value="<?php echo $equipmentList[$i]['equipement'];?>">
							<input type="hidden" id="shift" name="shift">
							<input type="hidden" name="btnState" value="start">
							<input type="submit" value="Start" name="start" class="login_button">							
						</form> 	
						<?php
							}
							else if($start_state==1 && $end_state==1)
							{
						?>
						<form action="<?php echo site_url('uploadExcel/equipmentStartWorkoutPerform');?>" method="POST">
							<input type="hidden" name="block" value="<?php echo $equipmentList[$i]['Block'];?>">
							<input type="hidden" name="equipment" value="<?php echo $equipmentList[$i]['equipement'];?>">
							<input type="hidden" id="shift" name="shift">
							<input type="hidden" name="btnState" value="start">
							<input type="submit" value="Start" name="start" class="login_button">							
						</form> 
						
						<?php
							/*}*/
							else
							{
						?>
						<form action="<?php echo site_url('uploadExcel/equipmentStartWorkoutPerform');?>" method="POST">
							<input type="hidden" name="block" value="<?php echo $equipmentList[$i]['Block'];?>">
							<input type="hidden" name="equipment" value="<?php echo $equipmentList[$i]['equipement'];?>">							
							<input type="hidden" name="btnState" value="end">
							<input type="hidden" name="detailID" value="<?php echo $id;?>">
							<input type="submit" value="End" name="end" class="login_button">							
						</form>
						<?php
							}
						?>
					</td>
					<td>
						<form action="<?php echo site_url('uploadExcel/equipmentStartWorkoutPerform');?>" method="POST">
							<input type="hidden" name="block" value="<?php echo $equipmentList[$i]['Block'];?>">							
							<input type="hidden" name="equipment" value="<?php echo $equipmentList[$i]['equipement'];?>">
							
							<input type="hidden" name="btnState" value="workout">
							<?php
							if($start_state==0)
							{
							?>
							<input type="submit" value="Work Out" name="workout" class="login_button" disabled style="background-color:gray;">	
							<?php
							}
							else if($start_state==1 && $work_out_state==1)
							{
							?>
							<input type="submit" value="Work Out" name="workout" class="login_button" disabled style="background-color:gray;">	
							<?php
							}
							else if($start_state==1 && $end_state==1)
							{
							?>
							<input type="submit" value="Work Out" name="workout" class="login_button" disabled style="background-color:gray;">	
							<?php
							}
							else if($start_state==1 && $end_state==0 && $work_out_state==0)
							{
							?>
								<input type="submit" value="Work Out" name="workout" class="login_button">
								<input type="hidden" name="detailID" value="<?php echo $id;?>">
							<?php
							}
							?>
						</form> 
					</td>
					
				</tr>
				<?php } ?>
						
						
				</table>
			</td>
		</tr>
		<TR><TD align="center"><p><?php echo $links; ?></p></TD></TR>
	</table>

		 <!--</div>-->
		 </div>
         <!-- <div class="post_content">
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. <a href="#">Suspendisse bibendum. Cras id urna.</a> Morbi tincidunt, orci ac convallis aliquam, lectus turpis varius lorem, eu posuere nunc justo tempus leo. Donec mattis, purus nec placerat bibendum, dui pede condimentum odio, ac blandit ante orci ut diam. Cras fringilla magna. Phasellus suscipit, leo a pharetra condimentum, lorem tellus eleifend magna, eget fringilla velit magna id neque. Curabitur vel urna. In tristique orci porttitor ipsum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec libero. Suspendisse bibendum. Cras id urna. Morbi tincidunt, orci ac convallis aliquam, lectus turpis varius lorem, eu posuere nunc justo tempus leo.</p>
            <p><strong>Aenean consequat porttitor adipiscing. Nam pellentesque justo ut tortor congue lobortis. Donec venenatis sagittis fringilla.</strong> Etiam nec libero magna, et dictum velit. Proin mauris mauris, mattis eu elementum eget, commodo in nulla. Mauris posuere venenatis pretium. Maecenas a dui sed lorem aliquam dictum. Nunc urna leo, imperdiet eu bibendum ac, pretium ac massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla facilisi. Quisque condimentum luctus ullamcorper.</p>
            <p class="spec"><a href="#" class="rm">Read more &raquo;</a></p>
			
			
          </div>-->
		  </form>
          <div class="clr"></div>
        </div>
		
		<?php
			if($mystatus==2)
			{
				echo $body;
			}
		?>
		
	
   
   	
		
       
       <!-- <p class="pages"><small>Page 1 of 2</small> <span>1</span> <a href="#">2</a> <a href="#">&raquo;</a></p>-->
      </div>
      <div class="sidebar">
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
	<?php echo form_close()?>
  </div>
  

 