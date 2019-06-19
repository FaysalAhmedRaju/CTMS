<meta http-equiv="refresh" content="20" />
<style>
	#overflow
	{
		width: 100%;
		height: 1000px;
		overflow: scroll;
		border: 1px solid #ccc;
	}
</style>
<table width="100%">
	<tr>
		<td align="center"><img src="<?php echo IMG_PATH; ?>cpanew.jpg" height="100px" width="300px"  /></td>
	</tr>
</table>

<div class="content">
	<div class="content_resize_1">
		<div class="mainbar_1">
			<div class="article">
				<h2><span><?php echo $title; ?></span> </h2>
				<!--p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p-->
				
				<div class="clr"></div>
				<div class="img1">
				
			<table cellspacing="1" cellpadding="1" align="center"  id="mytbl" style="overflow-y:scroll" >
				<form action="<?php echo site_url('report/exportContainerLoadingList');?>" method="POST" >
					<tr><td colspan="12" align="center">  <span><font color="green"  size="4" style="font-weight: bold"><nobr><?php print $tableTitle; ?></nobr></font></span></td></tr>
			

									 
					<tr>
						<td align="center" >
					

					<td><b><nobr>Rotation:</nobr></b></td>
					<td>
								<input type="text" style="width:170px" id="rotation" name="rotation" autofocus />
					</td>

					<td  align="center" width="70px">
								<input type="submit" value="Search" name="Search" class="login_button">
					</td>
					</tr>
				</form>
			</table>
				<!--div class="img1" style="overflow:auto"-->
				<!--div id="overflow"-->
					<table>
						<tr>
							<td>
								<table width="100%">
									<!--tr class="gridDark"-->
									<tr bgcolor="#aea4a4">
										<th>Sl</th>
										<th>ID</th>
										<th>Rotation</th>
										<th>Vessel Name</th>
										<th>Freight Kind</th>
										<th>Category</th>
										<th>Size</th>
										<th>Height</th>
										<th>Position</th>
										<th>MLO</th>
										<th>Seal</th>
										<th>Weight</th>
										<th>Trailer No</th>
										<th>Port of Discharge</th>
										<th>Update By</th>
										<th>Update Time</th>
										<th>Remarks</th>
									</tr>
									<?php
									$container="";
									for($i=0;$i<count($rslt_export_container_loading_list);$i++)
									{
									?>
									<!--tr class="gridLight"-->
									<tr <?php if($rslt_export_container_loading_list[$i]['cont_status']!=$rslt_export_container_loading_list[$i]['freight_kind']){ ?> bgcolor="#93E0FE" <?php } else if($rslt_export_container_loading_list[$i]['re_status']=="1"){ ?> bgcolor="pink" <?php } else if($rslt_export_container_loading_list[$i]['re_status']=="2"){ ?> bgcolor="F8FAD7"<?php }else { if($color==0) { ?> bgcolor="#d9e6f0" <?php } else  {?>bgcolor="FFFFFF" <?php }} ?>>
										<td align="center"><?php echo $i+1; ?></td>
										<td align="center"><?php echo $rslt_export_container_loading_list[$i]['id']; ?></td>
										<td align="center"><?php echo $rslt_export_container_loading_list[$i]['vsl_visit_dtls_ib_vyg']; ?></td>
										<td align="center"><?php echo $rslt_export_container_loading_list[$i]['vsl_name']; ?></td>
										<td align="center"><?php echo $rslt_export_container_loading_list[$i]['cont_status']; ?></td>
										<td align="center"><?php echo $rslt_export_container_loading_list[$i]['category']; ?></td>
										<td align="center"><?php echo $rslt_export_container_loading_list[$i]['size']; ?></td>
										<td align="center"><?php echo $rslt_export_container_loading_list[$i]['height']/10; ?></td>
										<td align="center"><?php echo $rslt_export_container_loading_list[$i]['stowage_pos']; ?></td>
										<td align="center"><?php echo $rslt_export_container_loading_list[$i]['mlo']; ?></td>
										<td align="center"><?php echo $rslt_export_container_loading_list[$i]['seal_no']; ?></td>
										<td align="center"><?php echo $rslt_export_container_loading_list[$i]['goods_and_ctr_wt_kg']; ?></td>
										<td align="center"><?php echo $rslt_export_container_loading_list[$i]['truck_no']; ?></td>
										<td align="center"><?php echo $rslt_export_container_loading_list[$i]['pod']; ?></td>
										<td align="center"><?php echo $rslt_export_container_loading_list[$i]['user_id']; ?></td>
										<td align="center"><?php echo $rslt_export_container_loading_list[$i]['last_update']; ?></td>
										<td align="center"><?php if($rslt_export_container_loading_list[$i]['cont_status']!=$rslt_export_container_loading_list[$i]['freight_kind']) echo "Need to load with given Freight Kind"; else if($rslt_export_container_loading_list[$i]['re_status']==0) echo "GENERAL"; else  echo "Need To Pre Advise or Something Others";?></td>
									</tr>
									<?php
										$container=$container.", ".$rslt_export_container_loading_list[$i]['id'];
									}
									?>
								</table>
							</td>
						</tr>
						<!--tr>
							<td><?php echo substr($container,1); ?></td>
						</tr-->
					</table>
				</div>
				<table>
					<tr>
						<td><?php echo substr($container,1); ?></td>
					</tr>
				</table>
				<div class="clr"></div>
			</div>
		</div>
		<!--div class="sidebar">
			<?php //include_once("mySideBar.php"); ?>
		</div-->
		<div class="clr"></div>
	</div>
</div>
	