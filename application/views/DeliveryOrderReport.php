

<HTML>
	<HEAD>
		<TITLE>Delivery Order Report</TITLE>
		<LINK href="../css/report.css" type=text/css rel=stylesheet>
		<link rel="shortcut icon" href="<?php echo IMG_PATH; ?>cpa.png" />
		<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH; ?>login_style.css" />
	</HEAD>
	<BODY bgcolor="#A9CEFD">
	<?php
	include("mydbPConnection.php");
	
	$rotation=str_replace("_","/",$rotation);
	//$bl=$bl;
	
	//echo $rotation.$bl;

	$str=mysql_query("select igm_detail_id,rotation,Line_No,BL_No,bill_of_entry_no,bill_of_entry_date,gp_no,gp_date,paid_date,voy_no,vessel_name,date,bill_no,arrived_from,pack_marks_number  as pack_marks_number,description  as description,port_comment,comment_by,comment_time,released,released_by,released_time,if(consignee_id>0,consignee_name,(select Organization_Name from organization_profiles where organization_profiles.id=igm_delivery_order.cnf_id)) as cnf_ff,agent from igm_delivery_order where rotation='$rotation' and BL_No='$bl'");
	$row=mysql_fetch_object($str);
	 ?>
	 <table width="1000px" bgcolor="#FEFDE7" align="center"><tr><td><br/><br/><br/><br/>
		<table width="900px" border="0" align="center" >
			<tr>
				<td width="300px">
					NO. <?php echo $row->bill_no; ?>
				</td>
				<td width="300px" align="center">
					<font size="5"><b>ORIGINAL</b></font>
				</td>
				<td width="300px" align="right">
					CHITTAGONG
				</td>
			</tr>
			<tr>
				<td width="300px" colspan="2">
					THE DEPUTY TRAFFIC MANAGER<br>CHITTAGONG PORT AUTHORITY<br>CHITTAGONG
				</td>
				<td width="300px" align="right">
					Date: <?php echo $row->date; ?>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td width="895px" colspan="3">
					Sir,<br>
					Please Deliver to M/S____________________________________<u><?php echo $row->cnf_ff; ?></u>___________________________________<br>
					or order the undermentioned Cargo Ex. M.V.________________________<u><?php echo $row->vessel_name; ?></u>___________________________<br>
					Voy__________<u><?php echo $row->voy_no; ?></u>__________ arrived from________<u><?php echo $row->arrived_from; ?></u>_________ Imp. Rot No____________<u><?php echo $row->rotation; ?></u>__________<br>
					and take proper receipt.
				</td>
			</tr>
			<tr>
				<td colspan="3">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<table border="1" width="895px" cellspacing="0" cellpadding="0">
						<tr align="center" bgcolor="#CACCCC">
							<td width="45%">
								Marks & Numbers
							</td>
							<td width="55%" bgcolor="#CACCCC">
								No. of Packages & Description
							</td>
						</tr>
						<tr>
							<td width="45%">
								<?php echo $row->pack_marks_number; ?>
							</td>
							<td width="55%">
								<?php echo $row->description; 
								
								$str2=mysql_query("select cont_number,cont_size,cont_iso_type,cont_status from igm_detail_container where igm_detail_id='$row->igm_detail_id'");
								while ($row2=mysql_fetch_object($str2)){
									echo "<br/><br/>".$row2->cont_number."/".$row2->size." ".$row2->cont_iso_type." ".$row2->cont_status."<br/>";
								}
								
								?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan="3">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="45%">
								L/No. <?php echo $row->Line_No; ?>
							</td>							
						</tr>
						<tr>
							<td width="55%">
								B/L No. <?php echo $row->BL_No; ?>
							</td>
						</tr>
						<tr>
							<td width="45%">
								B/E No. ____<u><?php echo $row->bill_of_entry_no; ?></u>____ Dt. __<u><?php echo $row->bill_of_entry_date; ?></u>____
							</td>	
						</tr>
						<tr>
							<td width="55%">
								G.P No. ____<u><?php echo $row->gp_no; ?></u>_____ Dt. ___<u><?php echo $row->gp_date; ?></u>___
							</td>
						</tr>
						<tr>
							<td width="55%">
								<b>PAID UPTO: <?php echo $row->paid_date; ?></b>
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td>
								<?php  echo $row->agent; ?>
							</td>
						</tr>
						<tr>							
							<td>
								&nbsp;
							</td>
						</tr>
						<tr align="right">
							<td>
								As Agents
							</td>
						</tr>
					</table>
					
				</td>
				
			</tr>
			<tr><td colspan="3"><br/><br/><br/></td></tr>
			<tr>
				<td align="center" colspan="2">
					<fieldset>
					<legend>Port Comment</legend>
						<table >
						<?php
							$attributes = array('name' => 'frm2');
							echo form_open(base_url().'index.php/report/DeliveryOrderPortComment',array('name' =>'frm2','onsubmit' => 'isvalidLogin()'));
							//echo $row->rotation;
						?>
							<tr>
								<td colspan="2">
								<br/>
									
									<input type="hidden" name="rotation" value="<?php echo $row->rotation; ?>">
									<input type="hidden" name="bl" value="<?php echo $row->BL_No; ?>">
									<input type="hidden" name="igm_detail_id" value="<?php echo $row->igm_detail_id; ?>">
									<textarea style="width:400px;height:200px;font-size: 12px;background:#ffffff;" name="port_comment"><?php echo $row->port_comment; ?></textarea>
									
									
								</td>
							</tr>
							<?php if($row->released==0){ ?>
							<tr>
								<td align="right">
									<input class="login_button" type="submit" name="comment" value="Comment">
								</td>
								</form>
								<?php
								
									$attributes = array('name' => 'frm2');
									echo form_open(base_url().'index.php/report/releaseDeliveryOrder',array('name' =>'frm2','onsubmit' => 'isvalidLogin()'));
									//echo $row->rotation;
									?>
									
								<td align="left" >
									
									<input type="hidden" name="rotation" value="<?php echo $row->rotation; ?>">
									<input type="hidden" name="bl" value="<?php echo $row->BL_No; ?>">
									<input type="hidden" name="igm_detail_id" value="<?php echo $row->igm_detail_id; ?>">
									<input class="login_button" type="submit" name="release" value="Released">
									</form>
								</td>
							</tr>
								<?php }else { ?>
							<tr>
								<td><font color="blue" size="3"><b>Already Released by <?php echo $row->released_by; ?> on <?php echo $row->released_time; ?></b></font>
								</td>
							</tr>	
							<?php } ?>	
							
							
								
							
						</table>
					</fieldset>
				</td>
			</tr>
			
		</table>
		</td></tr></table>
<?php mysql_close($con_cchaportdb);?>
<?php if($_POST['options']=='html'){?>		
	</BODY>
</HTML>
<?php }?>