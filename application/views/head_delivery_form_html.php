<script>
    // if ( window.history.replaceState ) {
        // window.history.replaceState( null, null, window.location.href );
    // }
</script>
<script>
	function chk_weight()
	{
		//set value
		// var be_no_tmp=document.getElementById("be_no_tmp").value;
		// document.getElementById("be_no").value=be_no_tmp;
		
		// var be_date_tmp=document.getElementById("be_date_tmp").value;
		// document.getElementById("be_date").value=be_date_tmp;
		
		var cp_no_tmp=document.getElementById("cp_no_tmp").value;
		document.getElementById("cp_no").value=cp_no_tmp;
		
		var cp_date_tmp=document.getElementById("cp_date_tmp").value;
		document.getElementById("cp_date").value=cp_date_tmp;
		
		//----
		var current_weight=parseInt(document.getElementById("quantity").value);
		var stc=document.getElementById("stc").value;
		var tot_dlv_qty=parseInt(document.getElementById("tot_dlv_qty").value);
		
		stc=stc.substr(0,stc.indexOf(' '));
		
		var gross_weight=tot_dlv_qty+current_weight;
		
		if(gross_weight > stc)
		{
			if (confirm("Total quantity is more then assignment. Continue?") == true) 
			{
				return true ;
			} 
			else 
			{
				return false;
			}
		}
	}
	
	function confirm_delete()
	{
		if (confirm("Delete this entry ?") == true) 
		{
			return true ;
		} 
		else 
		{
			return false;
		}
	}
	
	// function chk_submit()
	// {
		// var dlv_val=document.getElementById("dlv_val").value;
		// alert(dlv_val);
		// if(dlv_val==1)
			// var alert_msg="Perform strip operation?";
		// else if(dlv_val==2)
			// var alert_msg="Perform cancel operation?";
		// else if(dlv_val==3)
			// var alert_msg="Perform stay operation?";

		// if (confirm(alert_msg) == true) 
		// {
			// return true ;
		// } 
		// else 
		// {
			// return false;
		// }
	// }
	
	function chk_submit()
	{
		if (confirm("Continue ?") == true) 
		{
			return true ;
		} 
		else 
		{
			return false;
		}
	}
</script>
<?php include('dbConection.php'); ?>
<table align="center" width="850px">
	<tr>
		<td align="center"><img align="middle" width="235px" height="75px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
	</tr>
	<tr>
		<td align="center"><b>OFFICE OF THE TERMINAL MANAGER<br>HEAD DELIVERY REGISTER REPORT</b></td>
	</tr>
	<tr>
		<td align="center"><b>Date : <?php echo date("Y-m-d"); ?></b></td>
	</tr>
	<tr>
		<td align="left"><b>Assignment (Delivery) : <?php echo $rslt_info_panel[0]['mfdch_desc']?></b></td>
	</tr>
</table>
<br>
<table width="850px" align="center" border="2" style="border-collapse:collapse;">
	<tr>
		<!--td colspan="6">C&F : <?php echo $rslt_info_panel[0]['cf']; ?>, Vessel : <?php echo $rslt_info_panel[0]['v_name']; ?>, Rotation : <?php echo $rslt_info_panel[0]['rot_no']; ?>, BL No. : <?php echo $rslt_info_panel[0]['bl_no']; ?></td-->
		<td colspan="6">C&F : <?php echo $rslt_info_panel[0]['cf']; ?>, Vessel : <?php echo $rslt_info_panel[0]['v_name']; ?>, Rotation : <?php echo $rslt_info_panel[0]['rot_no']; ?>, BL No. : <?php echo $rslt_info_panel[0]['bl_no']; ?></td>
	</tr>
	<tr>
		<td><b>B/E No</b> :</td>
		<!--td><input style="width:150px" name="be_no_tmp" id="be_no_tmp" value="<?php echo $rslt_entry_dlv_dtl[0]['be_no']; ?>" <?php if($is_entry_data==1){?> readonly <?php } ?> /></td-->
		<td><a href="<?php echo site_url("report/xml_conversion_action/1/$office_code/$be_no/$be_dt")?>" target="_blank" title="View BE"><?php echo $be_no; ?></a></td>
		<td><b>B/E Date</b> :</td>
		<!--td><input style="width:150px" type="date" name="be_date_tmp" id="be_date_tmp" value="<?php echo $be_dt; ?>" <?php if($is_entry_data==1){?> readonly <?php } ?> /></td-->
		<td><?php echo $be_dt; ?></td>
				<!--script>
					$(function() {
						$( "#be_date" ).datepicker({
							changeMonth: true,
							changeYear: true,
							dateFormat: 'yy-mm-dd', // iso format
						});
					});	
				</script-->
		<td><b>STC</b> :</td>
		<td><?php echo $rslt_stc_weight[0]['stc']; ?></td>
	</tr>
	<tr>
		<td><b>CP No</b> :</td>
		<td><input style="width:150px" name="cp_no_tmp" id="cp_no_tmp" value="<?php echo $rslt_entry_dlv_dtl[0]['cp_no']; ?>" <?php if($is_entry_data==1){?> readonly <?php } ?> /></td>
		<td><b>CP Date</b> :</td>
		<td><input style="width:150px" type="date" name="cp_date_tmp" id="cp_date_tmp" value="<?php echo $rslt_entry_dlv_dtl[0]['cp_dt']; ?>" <?php if($is_entry_data==1){?> readonly <?php } ?> /></td>
				<!--script>
					$(function() {
						$( "#cp_dt" ).datepicker({
							changeMonth: true,
							changeYear: true,
							dateFormat: 'yy-mm-dd', // iso format
						});
					});	
				</script-->
		<td><b>Weight</b> :</td>
		<td><?php echo $rslt_stc_weight[0]['weight']; ?></td>
	</tr>
<!--/table>
<br>
<table width="800px" align="center" border="2" style="border-collapse:collapse;"-->
	<tr>
		<th align="center">Cont. No.</th>
		<th align="center">Good's Description</th>
		<th colspan="2" align="center">Cart Details</th>
		<th align="center">Delivery</th>
		<th align="center">Signature & Mobile</th>
	</tr>
	<?php
	for($i=0;$i<count($rslt_cont_no);$i++)
	{		
		$cont=$rslt_cont_no[$i]['cont_number'];
		$sql_unit_gkey="SELECT a.gkey		
		FROM sparcsn4.inv_unit a
		INNER JOIN sparcsn4.inv_unit_fcy_visit b ON b.unit_gkey=a.gkey
		INNER JOIN sparcsn4.config_metafield_lov ON a.flex_string01=config_metafield_lov.mfdch_value
		WHERE a.id='$cont' AND config_metafield_lov.mfdch_value NOT IN ('CANCEL') AND a.freight_kind='FCL'";
		
		$rslt_unit_gkey=mysql_query($sql_unit_gkey);
		
		while($row_unit_gkey=mysql_fetch_object($rslt_unit_gkey))
		{
			$sql_chk_status="SELECT dlv_status,status_dt
			FROM ctmsmis.mis_head_delivery_detail
			WHERE unit_gkey='$row_unit_gkey->gkey'";
				
			$rslt_chk_status=mysql_query($sql_chk_status);
				
			$row_chk_status=mysql_fetch_object($rslt_chk_status);
			
			$chk_status=$row_chk_status->dlv_status;
			$chk_date=$row_chk_status->status_dt;
	?>
	<tr>
		<td align="center"><?php echo $rslt_cont_no[$i]['cont_number']; ?></td>
		<td align="center"><?php echo $rslt_cont_no[$i]['Description_of_Goods']; ?></td>
		<td colspan="2" align="center">
			Weight : <?php echo $rslt_cont_no[$i]['weight']; ?> KG
			<br>
			<br>
			<br>
			<form name="truck_entry_form" id="truck_entry_form" method="post" action="<?php echo site_url("report/head_delivery_entry");?>">
				<input type="hidden" name="unit_gkey" id="unit_gkey" value="<?php echo $row_unit_gkey->gkey; ?>" />
				<input type="hidden" name="bl_no" id="bl_no" value="<?php echo $rslt_info_panel[0]['bl_no']; ?>" />
				<input type="hidden" name="tot_dlv_qty" id="tot_dlv_qty" value="<?php echo $tot_dlv_qty; ?>" />
				<input type="hidden" name="stc" id="stc" value="<?php echo $rslt_stc_weight[0]['stc']; ?>" />
				
				<input type="hidden" name="container" id="container" value="<?php echo $rslt_cont_no[$i]['cont_number']; ?>" />
				<input type="hidden" name="rotation" id="rotation" value="<?php echo $rslt_info_panel[0]['rot_no']; ?>" />
				
				<!--input type="hidden" name="be_no" id="be_no" value="<?php echo $rslt_entry_dlv_dtl[0]['be_no']; ?>" /-->
				<!--input type="hidden" name="be_no" id="be_no" />
				<input type="hidden" name="be_date" id="be_date" /-->
				<input type="hidden" name="cp_no" id="cp_no" />
				<input type="hidden" name="cp_date" id="cp_date" />
				
				<table border="1" style="border-collapse:collapse;margin:0 0 0 0;width:300px;" >
					<tr>
						<th>Truck</th>
						<th>Quantity</th>
						<th>Action</th>
					</tr>
					<?php
					include('mydbPConnectionn4.php');
					
					$cont_id=$rslt_cont_no[$i]['cont_number'];
					
					$sql_truck_qty="SELECT ctmsmis.mis_head_delivery_sub_detail.id AS id,ctmsmis.mis_head_delivery_sub_detail.truck_no,ctmsmis.mis_head_delivery_sub_detail.qty
					FROM ctmsmis.mis_head_delivery_detail
					INNER JOIN ctmsmis.mis_head_delivery_sub_detail ON ctmsmis.mis_head_delivery_sub_detail.head_dlv_dtl_id=ctmsmis.mis_head_delivery_detail.id
					WHERE ctmsmis.mis_head_delivery_detail.cont_id='$cont_id'";
					
					$rslt_truck_qty=mysql_query($sql_truck_qty);
					
					while($row_truck_qty=mysql_fetch_object($rslt_truck_qty))
					{
					?>
					<tr>
						<td><?php echo $row_truck_qty->truck_no; ?></td>
						<td><?php echo $row_truck_qty->qty; ?></td>
						<td align="center">
							<form action="<?php echo site_url("report/head_dlv_delete")?>" method="post">
								<input type="hidden" name="sub_dtl_id" id="sub_dtl_id" value="<?php echo $row_truck_qty->id; ?>" />
								<input type="hidden" name="cont_for_sub_dtl" id="cont_for_sub_dtl" value="<?php echo $rslt_cont_no[$i]['cont_number']; ?>" />
								<input name="delete" id="delete" type="submit" value="Delete" 
								<?php if($chk_status==1) { ?> disabled <?php } else if($chk_status==2) { ?> disabled <?php } ?> onclick="return confirm_delete();" />
							</form>
						</td>
					</tr>
					<?php
					}
					?>
					<tr>	
						<td>
							<input name="truck_no" id="truck_no" type="text" style="width:100px" />
						</td>
						<td><input name="quantity" id="quantity" type="text" style="width:100px" /></td>
						<td align="center"><input name="save" id="save" type="submit" value="Add"
						<?php if($chk_status==1) { ?> disabled <?php } else if($chk_status==2){?> disabled <?php } else if($chk_status==3){?> disabled <?php } ?> onclick="return chk_weight();" /></td>
					</tr>
				</table>
			</form>
		</td>
		<td align="center">
			<table>
				<?php
				// $sql_chk_status="SELECT dlv_status,status_dt
				// FROM ctmsmis.mis_head_delivery_detail
				// WHERE unit_gkey='$row_unit_gkey->gkey'";
				
				// $rslt_chk_status=mysql_query($sql_chk_status);
				
				// $row_chk_status=mysql_fetch_object($rslt_chk_status);
				
				// $chk_status=$row_chk_status->dlv_status;
				// $chk_date=$row_chk_status->status_dt;
				
				$today_date=date("Y-m-d");
				?>
				<tr>
					<td align="center">
						<form name="dlv_strip_form" id="dlv_strip_form" action="<?php echo site_url("report/head_dlv_status_action")?>" method="post" >
							<input type="hidden" name="dlv_val" id="dlv_val" value=1 />
							<input type="hidden" name="container_dlv" id="container_dlv" value="<?php echo $rslt_cont_no[$i]['cont_number']; ?>" />
							<input type="hidden" name="unit_gkey_dlv" id="unit_gkey_dlv" value="<?php echo $row_unit_gkey->gkey; ?>" />
							<input type="submit" name="strip" id="strip" value="Strip" 
							<?php if($chk_status==1) { ?> disabled <?php } else if($chk_status==2 and $today_date==$chk_date) { ?> disabled <?php } else if($chk_status==3 and $today_date==$chk_date) { ?> disabled <?php } ?>
							onclick="return chk_submit()" />
						</form>
					</td>
				</tr>
				<tr>
					<td align="center">
						<form name="dlv_cancel_form" id="dlv_cancel_form" action="<?php echo site_url("report/head_dlv_status_action")?>" method="post" >
							<input type="hidden" name="dlv_val" id="dlv_val" value=2 />
							<input type="hidden" name="container_dlv" id="container_dlv" value="<?php echo $rslt_cont_no[$i]['cont_number']; ?>" />
							<input type="hidden" name="unit_gkey_dlv" id="unit_gkey_dlv" value="<?php echo $row_unit_gkey->gkey; ?>" />
							<input type="submit" name="cancel" id="cancel" value="Cancel" 
							<?php if($chk_status==1) { ?> disabled  <?php } else if($chk_status==2 and $today_date==$chk_date) { ?> disabled <?php } else if($chk_status==2 and $today_date!=$chk_date) { ?> disabled <?php } else if($chk_status==3 and $today_date==$chk_date) { ?> disabled <?php } ?>
							onclick="return chk_submit()" />
						</form>
					</td>
				</tr>
				<tr>
					<td align="center">
						<form name="dlv_stay_form" id="dlv_stay_form" action="<?php echo site_url("report/head_dlv_status_action")?>" method="post" >
							<input type="hidden" name="dlv_val" id="dlv_val" value=3 />
							<input type="hidden" name="container_dlv" id="container_dlv" value="<?php echo $rslt_cont_no[$i]['cont_number']; ?>" />
							<input type="hidden" name="unit_gkey_dlv" id="unit_gkey_dlv" value="<?php echo $row_unit_gkey->gkey; ?>" />
							<input type="submit" name="stay" id="stay" value="Stay" 
							<?php if($chk_status==1) { ?> disabled <?php } else if($chk_status==2 and $today_date==$chk_date) { ?> disabled <?php } else if($chk_status==3 and $today_date==$chk_date) { ?>  disabled <?php } else if($chk_status==3 and $today_date!=$chk_date) { ?> disabled <?php } ?>
							onclick="return chk_submit()" />
						</form>
					</td>
				</tr>
			</table>
		</td>
		<td align="center">
			<?php
			$sql_cf_sign="SELECT ctmsmis.mis_jetty_sirkar.signature_path
			FROM ctmsmis.mis_jetty_sirkar
			INNER JOIN ctmsmis.mis_cf_assign_truck ON ctmsmis.mis_cf_assign_truck.jetty_sirkar_id=ctmsmis.mis_jetty_sirkar.id
			WHERE cont_id='$cont'
			ORDER BY ctmsmis.mis_jetty_sirkar.id DESC LIMIT 1";
			
			$rslt_cf_sign=mysql_query($sql_cf_sign);
			
			$row_cf_sign=mysql_fetch_object($rslt_cf_sign);
			
			$cf_sign=$row_cf_sign->signature_path;
			
			//$path=$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/images/jetty_sarkar_signature_files/".$cf_sign;
			//$path=$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/images/";
			//echo IMG;
			?>
			<!--img align="middle" width="200px" height="70px" src="<?php echo IMG_PATH?><?php echo $cf_sign; ?>" -->
			<img align="middle" width="200px" height="70px" 
			src="<?php echo IMG_PATH; ?><?php echo "jetty_sarkar_signature_files/".$cf_sign; ?>" />
		</td>
	</tr>
	<?php
		}
	}
	?>
</table>