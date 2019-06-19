<div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
		  <h2 style="color:black;" ><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
		  <div align="center"><?php echo $msg;?></div>
    <div class="img" style="margin-right:20px;">
	<div align="center">
		<form align="center" name= "myForm" action="<?php echo site_url("report/rotationWiseContainerPositionView");?>" method="post">
			<table align="center" style="border:solid 1px #ccc;" width="350px" cellspacing="0" cellpadding="0">
				<tr>
					<td>&nbsp;</td>
						</tr>
							<tr>
							  <th align="left" ><label><font color='red'></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rotation No:</label></th>
							  <td>
								<input type="text" style="width:130px;" id="rotNo" name="rotNo" value=""/>
									&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="submit" value="Search" class="login_button"/> 
							  </td>
							</tr>
						<tr>
							<td>&nbsp;</td>
				</tr>
			</table>
		</form>
		
		</div>
		
	
		 </div>
          <div class="clr"></div>
        </div>

		<table width="90%" border ='1' cellpadding='0' cellspacing='0'>
			<tr  align="center" class="gridDark">
				<th>SL</th>
				<th>CONTAINER</th>
				<th>ACTION</th>
				<th>ROTATION</th>
				<th>SIZE</th>
				<th>HEIGHT</th>
				<th>STATUS</th>
				<th>TRAILER NO</th>
				<th>ACTION</th>
			</tr>
			<?php for($i=0;$i<count($rtnSearchList);$i++) {?>
			<tr  align="center">
				<td><?php echo $i+1;?></td>
				<td><?php echo $rtnSearchList[$i]['cont_number'] ?></td>
				<td><?php echo $rtnSearchList[$i]['position'] ?></td>
				<td><?php echo $rtnSearchList[$i]['rotation'] ?></td>
				<td><?php echo $rtnSearchList[$i]['cont_size'] ?></td>
				<td><?php echo $rtnSearchList[$i]['cont_height'] ?></td>
				<td><?php echo $rtnSearchList[$i]['cont_status'] ?></td>
				<td><?php echo $rtnSearchList[$i]['trailer_no'] ?></td>
				<td style="padding:5px;">
				<form action="<?php echo site_url('report/containerPositionSolveUpdate') ?>" method="post" onsubmit="return confirm('Are you sure ?');">
					<input type="hidden" name="cont_move_id" value="<?php echo $rtnSearchList[$i]['id']; ?>">
					<input type="submit" class="login_button" name="submit" value="Solve">
				</form>
				</td>	
			</tr>
			<?php }?>
		</table>
		<table align="center" width="85%" cellpadding='0' cellspacing='0'>
		   <tr align ="left"><th><b><u>Container No:</u></b></th></tr>
			<tr>
			    <td><b><?php for($i=0;$i<count($rtnSearchList);$i++) { echo $rtnSearchList[$i]['cont_number'].", ";} ?></b></td>
			</tr>
		</table>
      </div>
      <div class="sidebar" >
	   <?php include_once("mySideBar.php"); ?>
	  </div>
      <div class="clr"></div>
    </div>
  </div>