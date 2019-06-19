<html>
	<head>
		<title>STUFFING CONTAINER LIST</title>
		<!--style>
			/* th,td
			{
				border:1px solid black;
			} */
		</style-->
		<script>
			function del_entry()
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
			function toggle(ele) {
				//alert("uu");
			 var checkboxes = document.getElementsByTagName('input');
			 if (ele.checked) {
				 for (var i = 0; i < checkboxes.length; i++) {
					 if (checkboxes[i].type == 'checkbox') {
						 checkboxes[i].checked = true;
					 }
				 }
			 } else {
				 for (var i = 0; i < checkboxes.length; i++) {
					 console.log(i)
					 if (checkboxes[i].type == 'checkbox') {
						 checkboxes[i].checked = false;
					 }
				 }
			 }
			}
		</script>
		<style>
			.accept_button {
				background-color: #4CAF50; /* Green */
				border: none;
				color: white;
				padding: 15px 32px;
				text-align: center;
				text-decoration: none;
				display: inline-block;
				font-size: 16px;
				cursor: pointer;
			}
		</style>
	</head>
	<body>
		  
		  <?php 
		  
		  $login_id=$this->session->userdata('login_id');
		  //echo $login_id."rr";
		  if($login_id == 'CPACS1') {
		  $attributes = array('target' => 'msgbar', 'id' => 'myform','name' => 'myform','onsubmit'=>'return validate()');		  
		  echo form_open(base_url().'index.php/report/acceptStuffingList',$attributes);
			$Stylepadding = 'style="padding: 12px 20px;"';
				if(!empty($error_message))
				{
					$Stylepadding = 'style="padding:25px 20px;"';
				}	
				if(isset($captcha_image)){
					$Stylepadding = 'style="padding:62px 20px 93px;"';
		  } } ?>
		<table width="100%" style="border-collapse: collapse;" border="0" align="center">
			<!--tr>
				<td colspan="11" align="center"><img width="200px" height="60px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
			</tr-->
		<?php
		if($stuffing_date!=null)
		{
		?>
			<tr>
				<td colspan="11" align="center"><h2>STUFFING CONTAINER LIST OF <?php echo $stuffing_date; ?></h2></td>
			</tr>
		<?php
		}
		else if($cont_no!=null)
		{
		?>
			<tr>
				<td colspan="11" align="center"><h2>STUFFING CONTAINER LIST OF <?php echo $cont_no; ?></h2></td>
			</tr>
		<?php
		}
		else if($offdock!=null)
		{
		?>
			<tr>
				<td colspan="12" align="center"><h2><?php echo $rslt_stuffing_report[0]['name']; ?></h2></td>
			</tr>
			<tr>
				<td colspan="12" align="center">STUFFING CONTAINER LIST</td>
			</tr>
			<?php
		//	if($ctime<=10 and $ctime>=9)
			if($ctime==$lowerLimit and $isOffdock==1)
			{ 
			?>
			<tr>
				<td colspan="12">
					<div style="font-size:20px;color:red;">
						<marquee hspace="1"><b>Delete facility will be closed after <?php echo $diff; ?> minutes for today.</b></marquee>
					</div>
				</td>
			</tr>	
			<?php
			}
			else if($ctime>=$upperLimit and $isOffdock==1)
			{ 
			?>
			<tr>
				<td colspan="12">
					<div style="font-size:20px;color:red;">
						<marquee hspace="1"><b>Delete facility is closed for today.</b></marquee>
					</div>	
				</td>
			</tr>
			<?php
			}			
		}
		?>
			<?php if( $login_id == 'CPACS1') { ?>
			<tr>
				<td colspan="13" align="right" style="border:1px solid black;"><input type="checkbox" id="selectall" onClick="toggle(this)"/> SELECT ALL</td>
			</tr>
			<?php } ?>
			<tr>
				<th style="border:1px solid black;">Sl</th>
				<th style="border:1px solid black;">Container No</th>
				<th style="border:1px solid black;">Seal No</th>
				<th style="border:1px solid black;">ISO</th>
				<th style="border:1px solid black;">Size</th>
				<th style="border:1px solid black;">Height</th>
				<th style="border:1px solid black;">Type</th>
				<th style="border:1px solid black;">MLO</th>
				<th style="border:1px solid black;">Stuffing Date</th>
				<?php if( $login_id == 'CPACS1' or $login_id=='admin') { ?>
				<th style="border:1px solid black;">Submit date</th>
				<?php } ?>
				<th style="border:1px solid black;">Destination Port</th>
				<th style="border:1px solid black;">Commodity</th>
				<?php if( $login_id == 'CPACS1') { ?>
				<th style="border:1px solid black;">IS ACCEPT</th>
				<?php } ?>
			<?php
			if($offdock==null)
			{
			?>
				<th style="border:1px solid black;">Offdoc</th>
			<?php
			}
			else if($offdock!=null and $isOffdock==1)
			{
			?>
				<th style="border:1px solid black;">Action</th>
			<?php
			}
			?>
			</tr>
			<?php
			for($i=0;$i<count($rslt_stuffing_report);$i++)
			{
			?>
				<tr>
					<td align="center" style="border:1px solid black;"><?php echo $i+1; ?></td>
					<td align="center" style="border:1px solid black;"><?php echo $rslt_stuffing_report[$i]['cont_id']; ?></td>
					<td align="center" style="border:1px solid black;"><?php echo $rslt_stuffing_report[$i]['seal_no']; ?></td>
					<td align="center" style="border:1px solid black;"><?php echo $rslt_stuffing_report[$i]['iso_type']; ?></td>
					<td align="center" style="border:1px solid black;"><?php echo $rslt_stuffing_report[$i]['size']; ?></td>
					<td align="center" style="border:1px solid black;"><?php echo $rslt_stuffing_report[$i]['height']; ?></td>
					<td align="center" style="border:1px solid black;"><?php echo $rslt_stuffing_report[$i]['iso_group']; ?></td>
					<td align="center" style="border:1px solid black;"><?php echo $rslt_stuffing_report[$i]['mlo_code']; ?></td>
					<td align="center" style="border:1px solid black;"><?php echo $rslt_stuffing_report[$i]['stuffing_date']; ?></td>
					<?php if( $login_id == 'CPACS1' or $login_id=='admin') { ?>
					<td align="center" style="border:1px solid black;"><?php echo $rslt_stuffing_report[$i]['submit_date']; ?></td>
					<?php } ?>
					<td align="center" style="border:1px solid black;"><?php echo $rslt_stuffing_report[$i]['dest_port']; ?></td>
					<td align="center" style="border:1px solid black;"><?php echo $rslt_stuffing_report[$i]['comodity_code']; ?></td>
					<?php if( $login_id == 'CPACS1') { ?>
					<td align="center" style="border:1px solid black;"><input type="checkbox" id="acceptChk" name="acceptChk[]" value="<?php echo $rslt_stuffing_report[$i]['akey']; ?>" <?php if($rslt_stuffing_report[$i]['accept_stuffing'] === '1') echo 'checked="checked"';?>/></td>
					<?php } ?>
				<?php
				if($offdock==null)
				{
				?>
					<td align="center" style="border:1px solid black;"><?php echo $rslt_stuffing_report[$i]['name']; ?></td>
				<?php
				}
				else if($offdock!=null and $isOffdock==1)
				{
				?>
					<td align="center" style="border:1px solid black;">
					<?php 
						//	echo $rslt_stuffing_report[$i]['hr'];
					?>	
						<form name="delete_entry" id="delete_entry" onsubmit="return del_entry()" action="<?php echo site_url("report/deleteOffdockEntry")?>" method="post" >
							<input type="hidden" name="delete_cont" id="delete_cont" value="<?php echo $rslt_stuffing_report[$i]['cont_id']; ?>" />
							<input type="hidden" name="delete_stfdate" id="delete_stfdate" value="<?php echo $rslt_stuffing_report[$i]['stuffing_date']; ?>" />
							<!--input type="submit" name="delete_entry" id="delete_entry" value="Delete"  /-->
							
							<input type="submit" name="delete_entry" id="delete_entry" value="Delete" 
							<?php if($rslt_stuffing_report[$i]['hr']>=$upperLimit) { ?> disabled <?php } ?> />
						</form>
					<?php
					//	}
					?>
					</td>
				<?php
				}
				?>
				</tr>
			<?php
			}
			?>
				<!--tr>
					<td style="border:1px solid black;" colspan="12">&nbsp;</td>
				</tr-->
				<tr>
					<td style="border:1px solid black;" colspan="2" align="center"><b>20' => <?php echo $size_20;?></b></td>
					<td style="border:1px solid black;" colspan="2" align="center"><b>40' => <?php echo $size_40;?></b></td>
					<td style="border:1px solid black;" colspan="2" align="center"><b>Box' => <?php echo $size_20+$size_40;?></b></td>
					<td style="border:1px solid black;" colspan="7" align="left"><b>Teus => <?php echo $t20+$t40;?></b></td>
				</tr>
		</table>
		</br>
		<?php if($login_id == 'CPACS1') { ?>
		<div align="center">
		
			<button type="submit" class="accept_button">ACCEPT</button>
			<?php echo form_close()?>
		</div>
		<div align="center">
			<iframe id="msgbar" align="center" style="padding-left:100px" name="msgbar" frameborder="0"></iframe>
		</div>
		 <?php echo form_close()?>
		</br>
		</br>
		<?php } ?>
		<!--table style="border-collapse:collapse" border="1" align="center">
			<tr>
				<th>20'</th>
				<th>40'</th>
				<th>Total Teus</th>
			</tr>
			<tr>
				<td><?php echo $size_20;?></td>
				<td><?php echo $size_40;?></td>
				<td><?php echo $t20+$t40;?></td>
			</tr>
		</table-->
	</body>
</html>