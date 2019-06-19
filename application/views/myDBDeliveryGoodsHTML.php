<div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
		   <div class="img1">
			
			<form action="home.php?myflag=9082" method="post" name="frm2" onsubmit="return validateForm()">


<table width=79% height="20%" border="0" align="center">

<!--<tr><td height="5%"  class="onlyTable"><a href='home.php?myflag=9084&homemsg=Hello'>Dash Board Delivery List<a/></td></tr>-->
<?php if($_SESSION['Control_Panel']==100 or $_SESSION['Control_Panel']==10){ ?>
<tr><td height="5%"  class="onlyTable"><a href='Forms/myalldashboarddeliveredreport.php?login_id=<?php print($_SESSION['login_id']); ?>' target="_blank"> <img src="<?php echo IMG_PATH; ?>report.jpg" border="0" height="20" width="20"><font color="blue">All Delivery Report for <? print($_SESSION['login_id']); ?></font></a></td></tr>
	<?php } else { ?>
	<tr><td height="5%"  class="onlyTable"><a href='Forms/myallportcheckedreport.php?login_id=<?php print($_SESSION['login_id']); ?>' target="_blank"> <img src="<?php echo IMG_PATH; ?>report.jpg" border="0" height="20" width="20"><font color="blue">All Checked Report for <? print($_SESSION['login_id']); ?></font></a></td></tr>
	<tr><td > <img src="<?php echo IMG_PATH; ?>report.jpg" border="0" height="20" width="20"><font color="blue"><a href="home.php?myflag=9093">Port Checked Report Import</a></font></td></tr>

	<?php } ?>
	<tr>
		<td align="center" class="style1"><div align="center"><font size="5"><b>Dash Board for Delivery of goods, Import</b></font></div></td>
	
	</tr>
	
	<tr><td align="center" class="style1"><div align="center"><font bgcolor="#33CCCC"color="red" size="3"><b><?php echo$msg1;?></b></font></div></td></tr>
	
	<tr><td  align="center" class="style1"><div  align="center"><font  color="#000" size="3"><b><?php echo$msg;?></td></tr>
	<?php if($BENO!="" and $msg1=="" and $msg=="") {
	$msg2="Goods are deliverable..."
	?>
	<tr><td  align="center" class="style1"><div  align="center"><font  color="green" size="3"><b><?php echo$msg2;?></td></tr>
	<?php } ?>
 
 </table>
  
  

  <br >
  <br >
</table>	

  <table width="65%" border="0" cellspacing="0" cellpadding="0" align="center">
   
    <input type="hidden" name="txt_login_id" value="<?php print($_SESSION['login_id']); ?>">
	<input type="hidden" name="txt_id_0" value="<?php if($DID!=""){echo($DID);}else{echo($DEID);}?>">
	
	<input type="hidden" id="txt1" name="txt_AFR"   value="<?php print($AFR);?>"/>
	<input type="hidden" id="txt2" name="txt_delivery_block_stat"   value="<?php print($delivery_block_stat);?>"/>
	<input type="hidden" id="txt3" name="txt_BE_Status"   value="<?php print($BE_Status);?>"/>
	<input type="hidden" id="txt4" name="txt_igm_detail_id"   value="<?php print($igm_detail_id);?>"/>
	<input type="hidden" id="txt5" name="txt_igm_sup_detail_id"   value="<?php print($igm_sup_detail_id);?>"/>
	<input type="hidden" id="txt6" name="txt_permission_no"   value="<?php print($permission_no);?>"/>
	<input type="hidden" id="txt19" name="txt_Rel_order_No"  value="<?php print($release_Order_No);?>"  />
	<input type="hidden" id="txt20" name="txt_Rel_order_Dt"    value="<?php print($status_datetime);?>"  />
	<input type="hidden" id="txt20" name="txt_revenue"    value="<?php print($revenue);?>"  />
 <tr>
  <td width="200" height="40" class="data" id="txt2" ><div align="left"><span class="style2">Office Code </span></div></td>
  <td width="2">&nbsp;:&nbsp;</td>
  <td><label> <input type="text" id="txt2" name="txt_office_code"  tabindex=1 value="<?php if($DID!=""){print($office_1);}else{print($office_code);}?>"/> </label><b style="color:red">*</b><?php if($_SESSION['Control_Panel']==100 or $_SESSION['Control_Panel']==81){ ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rotation No: <input type="text" id="txt2" name="txt_rot_no"  tabindex=4 value="" AUTOCOMPLETE = "off"/><?php } ?></td>	  
 </tr>

	    <tr>
	      <td width="200" height="40" class="data" id="txt1" ><div align="left"><span class="style2">Registration No(B/E No) </span></div></td>
	        <td width="2">&nbsp;:&nbsp;</td>
		  <td>
		  <div id="suggest"><label>
	        <input type="text" name="txt_BE_No" AUTOCOMPLETE = "off" tabindex=2 id="beno" onkeyup="suggest(this.value+'|'+txt_office_code.value);" onblur="fill();" value="<?php if($DID!=""){print($BENO_1);}else{print($BENO);}?>"/>
	      </label><b style="color:red">*</b><?php if($_SESSION['Control_Panel']==100 or $_SESSION['Control_Panel']==81){ ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Line No: <input type="text" id="txt2" name="txt_line_no"  tabindex=5 value="" AUTOCOMPLETE = "off"/><?php } ?>
		  <div class="suggestionsBox" id="suggestions" style="display: none;">
		  <img src="images/arrow11.png" style="position: relative; top: -12px; left: 25px;" alt="upArrow" />
	        <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
	      </div></div></td>
	    </tr>
		
	
    <tr>
      <td width="200" height="40" class="data" id="txt3" ><div align="left"><span class="style2">B/E Date </span></div></td>
        <td width="2">&nbsp;:&nbsp;</td>
	  <td><label> <input type="text" id="txt_bedate" name="txt_BE_DT"  tabindex=3 value="<?php if($DID!=""){print($BEDT_1);}else{print($BEDATE);}?>"/></label><b style="color:red">*</b><?php if($BEDATE) { ?><a href='Forms/myBillEntryImportReportHTML.php?reg=<?php print("C".$BENO);?>&date=<?php print($BEDATE);?>&code=<?php print($office_code);?>' target="aboutblank">&nbsp;&nbsp;<font color="blue">B/E Report</font></a><?php } ?></td>
	</tr>	
   
     <input type="hidden"  id="txt_sadid" name="txt_SAD_ID"  readonly="true"  value="<?php print($row->id);?>"/>
 	<tr>
      <td width="200" height="41" class="data" id="txt14"><div align="left"><span class="style2">BIN No</span></div></td>
        <td width="2">&nbsp;:&nbsp;</td>
	  <td><label>  <b><?php print($BINNO);?> <b> </label></td>
    </tr>
    <tr>
      <td width="200" height="41" class="data" id="txt15"><div align="left"><span class="style2">Importers Name & Addesss </span></div></td>
        <td width="2">&nbsp;:&nbsp;</td>
	  <td><label> <b> <?php print($imp_name."<br>".$imp_address);?> <b></label></td>
    </tr>
	
	  <tr>
      <td width="200" height="41" class="data" id="txt16"><div align="left"><span class="style2"> AIN No </span></div></td>
        <td width="2">&nbsp;:&nbsp;</td>
	  <td><label>  <b><?php print($AINNO);?> <b> </label></td>
    </tr>
	  <tr>
      <td width="200" height="41" class="data" id="txt17"><div align="left"><span class="style2">C & F Name & Addesss </span></div></td>
        <td width="2">&nbsp;:&nbsp;</td>
	  <td><label> <b><?php print($cnf_name."<br>".$cnf_address);?> <b></label></td>
    </tr>
	<?php if($_SESSION['Control_Panel']==100) { ?>
	  <tr>
      <td width="200" height="41" class="data" id="txt18"><div align="left"><span class="style2">Bank treasury </span></div></td>
        <td width="2">&nbsp;:&nbsp;</td>
	  <td ><label>  <b><?php print($Amount);?> <b> </label></td>
    </tr>
	<?php } if($office_code==303){ ?>
	<tr>
      <td width="200" width="200" height="41" class="data" id="txt19"><div align="left"><span class="style2">UP/UD No </span></div></td>
        <td width="2">&nbsp;:&nbsp;</td>
	  <td><label>   <b><?php print($SADITM_RESERVED);?>  <b></label></td>
    </tr>
	<?php } ?>	  <tr>
      <td width="200" width="200" height="41" class="data" id="txt19"><div align="left"><span class="style2">Release Order No </span></div></td>
        <td width="2">&nbsp;:&nbsp;</td>
	  <td><label>   <b><?php print($release_Order_No);?>  <b></label></td>
    </tr>
	  <tr>
      <td width="200" height="41" class="data" id="txt20"><div align="left"><span class="style2">Release order Date & Time </span></div></td>
        <td width="2">&nbsp;:&nbsp;</td>
	  <td><label> <b> <?php if($release_Order_No) print($status_datetime);?>  <b></label></td>
    </tr>
	<?php /* if(!($select_code==0 or $select_code=="" or $office_code=="303")) {  ?>
	<tr>
      <td width="200" width="200" height="41" class="data" id="txt19"><div align="left"><span class="style2">Selectivity Status </span></div></td>
        <td width="2">&nbsp;:&nbsp;</td>
	  <td <?php if($select_code==2 ){ ?> bgcolor="yellow" <?php } else if($select_code==3) {  ?> bgcolor="red" <?php } elseif($select_code==1) {?> bgcolor="blue"  <?php }  ?>><label>   <b><?php print($selectivity);?>  <b></label></td>
    </tr>
	<?php } */?>
	 <tr>
	 <td width="200" height="41" class="data" id="txt21"><div align="left"><span class="style2">Duty-Tax Amount </span></div></td>
       <td width="2">&nbsp;:&nbsp;</td>
	 <td><label>  <b><?php if($revenue) print($revenue." BDT");?> <b> </label><?php if($revenue) { ?><a href="#" onclick="open_win(<?php print($id) ?>,<?php print($BENO); ?>,'<?php print($BEDATE) ?>',<?php print($office_code); ?>,'<?php print($sad_type); ?>')"> <font color="blue">Total Tax</font></a><?php } ?></td>
    </tr>
     <tr>
	 <td width="200" height="41" class="data" id="txt22"><div align="left"><span class="style2">Vessel Name </span></div></td>
	  <td width="2">&nbsp;:&nbsp;</td>
	 <td><label>  <b><?php print($VESSELN );?> <b> </label></td>
    </tr>
     <tr>
	 <td width="200" height="41" class="data" id="txt23"><div align="left"><span class="style2">Import Rotation No </span></div></td>
       <td width="2">&nbsp;:&nbsp;</td>
	 <td><label>  <b><?php print($Import_Rotation_No);?>  <b></label></td>
    </tr>
	 <tr>
    <td width="200" height="41" class="data" id="txt24"><div align="left"><span class="style2">Line No </span></div></td>
       <td width="2">&nbsp;:&nbsp;</td>
	 <td><label> <b> <?php if($multi_row>0) print($line); else print($Line_No);?>   <b> </label></td>
    </tr>
	 <tr>
	 <td width="200" height="41" class="data" id="txt25"><div align="left"><span class="style2">BL No </span></div></td>
        <td width="2">&nbsp;:&nbsp;</td>
	  <td><label>   <b><?php if($multi_row>0) print($BL); else print($BL_No);?> <b> </label></td>
    </tr>
	 <tr>
	 <td width="200" height="41" class="data" id="txt25"><div align="left"><span class="style2">Total Pack in IGM </span></div></td>
        <td width="2">&nbsp;:&nbsp;</td>
	  <td><label>   <b><?php if($multi_row>0) print($TotalP); else print($Pack_Number);?> <b> </label></td>
    </tr>
	 <tr>
	 <td width="200" height="41" class="data" id="txt26"><div align="left"><span class="style2">Description of Goods  </span></div></td>
       <td width="2">&nbsp;:&nbsp;</td>
	 <td><label>  <b><?php print($Description_of_Goods);?> <b> </label></td>
    </tr>
    <tr>
	 <td width="200" height="41" class="data" id="txt26"><div align="left"><span class="style2">Notify Party (Importers)  </span></div></td>
       <td width="2">&nbsp;:&nbsp;</td>
	 <td><label>  <b><?php print($NotifyDesc);?> <b> </label></td>
    </tr>
	<!-- <tr>
	
	 <td height="41" class="data" id="txt27"><div align="left"><span class="style2">Total Pack  :</span></div></td>
      <td><label>
 <b>
<?php print($TOTALPACK);?>
 <b></label></td>
    </tr>-->
	<?php// print($TOTALPACK); ?>
	<tr>
	<input type="hidden" name="tot_pack" id="tot_pack" value="<?php print($TOTALPACK); ?>">
	 <td width="200" height="41" class="data" id="txt27"><div align="left"><span class="style2">Total Pack</span></div></td>
        <td width="2">&nbsp;:&nbsp;</td>
	  <td><label>
	<b>
	<?php if($_SESSION['Control_Panel']!=100 && $_SESSION['Control_Panel']!=81) { ?>
	<input type="text" id="port_tot_pack" name="total_pack_by_port" value="<?php if($Total_pack_by_port) print($Total_pack_by_port); else print($total_pack_by_port);?>">
	<?php } else { if ($Total_pack_by_port) print($Total_pack_by_port." <font color=blue> [Actual Total Pack :". $TOTALPACK."]</font>"); else print("Entries yet to given by Port. <font color=blue> [Actual Total Pack :". $TOTALPACK."]</font> "); } ?>
	
	<b></label></td>
    </tr>
	
	 <tr>
	 <td width="200" height="41" class="data" id="txt28"><div align="left"><span class="style2"> Gross Weight </span></div></td>
       <td width="2">&nbsp;:&nbsp;</td> 
	  <td><label>  <b><?php if($multi_row>0) print($TotalG); else print($weight."".$weight_unit);?>  <b>  </label></td>
    </tr>
<!--<tr>
	 <td height="41" class="data" id="txt28"><div align="left"><span class="style2"> Net Weight : </span></div></td>
      <td><label>  <b><?php print($net_weight."".$net_weight_unit);?>  <b>  </label></td>
    </tr>-->

 <tr>
	 <td width="200" height="41" class="data" id="txt26"><div align="left"><span class="style2">Agent Name  </span></div></td>
       <td width="2">&nbsp;:&nbsp;</td>
	 <td><label>  <b>
	 <?php 
	 $sql_org=mysql_query("select Organization_Name from organization_profiles where id=$Submitee_Org_Id");
	 $row_org=mysql_fetch_object($sql_org);
	 print($row_org->Organization_Name);
	 
	 ?>
	 
	 
	<b> </label></td>
    </tr>
	 <?php 
	 //print($AFR);
	 if($igm_detail_id>0)
	 {
		if($AFR=="BLOCKED")
		$sql_afr=mysql_query("select remarks,AFR_By as Deliver_block_by,AFR_Date as Deliver_block_time from igm_detail_afr where igm_detail_id='$igm_detail_id' and AFR_By is not null order by id desc");
		else if($delivery_block_stat=='block')
		$sql_afr=mysql_query("select remarks,Deliver_block_by,Deliver_block_time from igm_detail_afr where igm_detail_id='$igm_detail_id' and Deliver_block_by is not null order by id desc");
	 }
	else if($igm_sup_detail_id>0)
	{
		if($AFR=="BLOCKED")
		$sql_afr=mysql_query("select remarks,AFR_By as Deliver_block_by,AFR_Date as Deliver_block_time from igm_detail_afr where igm_sup_detail_id='$igm_sup_detail_id'  and AFR_By is not null order by id desc");
		else if($delivery_block_stat=='block')
		$sql_afr=mysql_query("select remarks,Deliver_block_by,Deliver_block_time from igm_detail_afr where igm_sup_detail_id='$igm_sup_detail_id' and Deliver_block_by is not null  order by id desc");
	}
	if($row_afr=mysql_fetch_object($sql_afr))
	{
	?>
	<tr>
	 <td width="200" height="41" class="data" id="txt26"><div align="left"><span class="style2"> AIR/Customs Comment </span></div></td>
       <td width="2">&nbsp;:&nbsp;</td>
	 <td><label>  <b>
	<?php
	if($AFR=="BLOCKED")
	print("<font color=red>".$row_afr->remarks." BY:".$row_afr->Deliver_block_by." Time: ".$row_afr->Deliver_block_time."</font>");
	else
	print($row_afr->remarks." BY:".$row_afr->Deliver_block_by." Time: ".$row_afr->Deliver_block_time);
		
	 ?>
	 
	 
	<b> </label></td>
    </tr>
	<?php
	}
	//print($igm_detail_id.'--'.$igm_sup_detail_id.'--shemul');
	if($igm_detail_id>0)
	{
		$sql_navy=mysql_query("select final_amendment,response_details3,hold_application,
		rejected_application,response_details2,response_details1 from igm_navy_response 
		where igm_details_id=$igm_detail_id");
	}
	else if($igm_sup_detail_id>0)
	{
		$sql_navy=mysql_query("select final_amendment,response_details3,hold_application,
		rejected_application,response_details2,response_details1 from igm_navy_response 
		where egm_details_id=$igm_sup_detail_id");
	}
	$row_count=mysql_num_rows($sql_navy);
	if($row_count>0)
	{
	?>
	<tr>
	 <td width="200" height="41" class="data" id="txt26"><div align="left"><span class="style2">Navy Comments  </span></div></td>
       <td width="2">&nbsp;:&nbsp;</td>
	 <td><label>  <b>
	 <?php 
		$row_navy=mysql_fetch_object($sql_navy);
		if($row_navy->final_amendment=="1")
		print($row_navy->response_details3);
		elseif($row_navy->final_amendment=="2")
		print("<font color=red>".$row_navy->hold_application."</font>");
		elseif($row_navy->final_amendment=="3")
		print("<font color=red>".$row_navy->rejected_application."</font>");
		else
		print("<font color=red>".$row_navy->response_details1."<br>".$row_navy->response_details2."</font>");
	?>
	</b> </label></td>
    </tr>
	<?php } ?>

     <tr>
	 <td width="200" height="41" class="data" id="txt29"><div align="left"><span class="style2"> Containers</span></div></td>
       <td width="2">&nbsp;:&nbsp;</td>
	 <td><label>
			 <table >
				<tr class='gridDark'><td>Cont Number</td><TD> Size</TD><td> Seal Number</td><td> Status </td><td> height</td><td> Gross Weight </td><td>Container Location</td></tr>
			<?php
					IF($igm_detail_id>0)
					{ 
						$abc="";
						$status="";
						$sql6=mysql_query("select igm_detail_id,cont_number,cont_size,cont_seal_number,cont_status,cont_height,cont_gross_weight,cont_weight from igm_detail_container where igm_detail_id='$igm_detail_id'");						
							$row_nums=mysql_num_rows($sql6);
							if($row_nums)
							{
							
						//	print($row_nums);
							while($rows5=mysql_fetch_object($sql6))
							{									
			?>
								<tr class='gridLight'>
								<td><?php print($rows5->cont_number); ?></td>
								<td><?php print($rows5->cont_size); ?></td>				
								<td><?php print($rows5->cont_seal_number); ?></td>				
								<td><?php print($rows5->cont_status); ?></td>
								<td><?php print($rows5->cont_height); ?></td>
								
								<td><?php print($rows5->cont_gross_weight); ?></td>
								
								<td ><a href="../searchcontainerlocation.php?cont=<?php print($rows5->cont_number); ?>" target="_blank"><color="blue">Location</font></a></td>
								</tr>											
			<?php			
			
			
						/*	 $handle = fopen("http://202.51.178.147:8080/CPA/containersearch.htm?contno=$rows5->cont_number", "r");
							$contents = fread($handle,2600);
							$contents1=explode('Dray Status',$contents);
							$contents2=explode('<td align="center">',$contents1[1]);
							//print($contents1[1]);
							
							//print($contents2[0]."<hr>");
								
							$cont_pos1=$contents2[1];
							$cont_pos2=$contents2[2];
						//	print($cont_pos1."-".$cont_pos2."<hr>");
							$status=$rows5->cont_number."/".$cont_pos1."/".$cont_pos2;
						//print($status);
							$abc=$abc."|".$status;*/
						}
						}
						else
						{
						
								$sql6=mysql_query("select igm_detail_id,cont_number,cont_size,cont_seal_number,cont_status,cont_height,cont_gross_weight,cont_weight from igm_detail_container_history where igm_detail_id='$igm_detail_id'");						
							$row_nums=mysql_num_rows($sql6);
							
							
						//	print($row_nums);
							while($rows5=mysql_fetch_object($sql6))
							{									
			?>
								<tr class='gridLight'>
								<td><?php print($rows5->cont_number); ?></td>
								<td><?php print($rows5->cont_size); ?></td>				
								<td><?php print($rows5->cont_seal_number); ?></td>				
								<td><?php print($rows5->cont_status); ?></td>
								<td><?php print($rows5->cont_height); ?></td>
								
								<td><?php print($rows5->cont_gross_weight); ?></td>
								
								<td ><a href="../searchcontainerlocation.php?cont=<?php print($rows5->cont_number); ?>" target="_blank"><color="blue">Location</font></a></td>
								</tr>											
			<?php			
			
			
						
						}
						
						//print($abc);
					}
				}					
					ELSE if($igm_sup_detail_id>0)
							{
								$sql8=mysql_query("select cont_number,cont_size,cont_seal_number,cont_status,cont_height,cont_weight,Cont_gross_weight from igm_sup_detail_container where igm_sup_detail_id='$igm_sup_detail_id' ");						
								//print("select cont_number,cont_size,cont_seal_number,cont_status,cont_height,cont_weight,Cont_gross_weight from igm_sup_detail_container where igm_sup_detail_id='$igm_sup_detail_id' ");	
									$row_nums=mysql_num_rows($sql8);
									if($row_nums==0)
									{
									$sql8=mysql_query("select cont_number,cont_size,cont_seal_number,cont_status,cont_height,cont_weight,Cont_gross_weight from igm_sup_detail_container_history where igm_sup_detail_id='$igm_sup_detail_id' ");						
									}
									while($rows7=mysql_fetch_object($sql8))							
									{									
			?>		
										<tr class='gridLight'>
										<td><?php print($rows7->cont_number); ?></td>
										<td><?php print($rows7->cont_size); ?></td>				
										<td><?php print($rows7->cont_seal_number); ?></td>				
										<td><?php print($rows7->cont_status); ?></td>
										<td><?php print($rows7->cont_height); ?></td>
										
										<td><?php print($rows7->Cont_gross_weight); ?></td>
										
										<td ><a href="../searchcontainerlocation.php?cont=<?php print($rows7->cont_number); ?>" target="_blank"><color="blue">Location</font></a></td>
										</tr>														
											
			<?php						}
							}	  
			?> 	   
				</table>
	  
      </label></td>
    </tr>
	<?php  if($row_nums>0) { ?>
	<tr>
	 <td width="200" height="41" class="data" id="txt31"<div align="left"><span class="style2"> Total Container</span></div></td>
       <td width="2">&nbsp;:&nbsp;</td>
	 <td><label>  <b><?php if($row_nums>0) print($row_nums);?> <b> </label>
       
     </td>
    </tr>
	<?php } ?>
<?php //if($_SESSION['Control_Panel']==100) { ?>	

	<tr>
	 <td width="200" height="41" class="data" id="txt31"<div align="left"><span class="style2"> Port/Offdock Checked By <br>& Date</span></div></td>
       <td width="2">&nbsp;:&nbsp;</td>
	 <td><label>  <b><?php if($Check_by_port) print($Check_by_port."<br>DT: ".$Check_datetime);?> <b> </label>
       <!-- <input type="text" id="txt31" name="txt_JT_Sarker" value="<?php if($Check_by_port) print($Check_by_port."<br> DT: ".$Check_datetime);?>"    />-->
     </td>
    </tr>
	<?php //} ?>
	<?php
	
	?>
	<tr>
	 <td width="200" height="41" class="data" id="txt30"><div align="left"><span class="style2">On Chassis Delivery Issue No</span></div></td>
        <td width="2">&nbsp;:&nbsp;</td>
	  <td><label>
	  <?php if($_SESSION['Control_Panel']==10 or $_SESSION['Control_Panel']==74) { ?>
        <input type="text" id="txt30" name="Issue_no" value="<?php if($Issue_no) print($Issue_no);?>" />
      <b style="color:red">*</b>
	  <?php } else { ?>
	  <b><?php if($Issue_no) print($Issue_no); ?> </b>
	  <?php } ?>
	  </label></td>
    </tr>
<?php// print($gate_no."shemul<hr/>") ?>
		<tr>
	 <td width="200" height="41" class="data" id="txt30"><div align="left"><span class="style2">On Chassis Gate No</span></div></td>
        <td width="2">&nbsp;:&nbsp;</td>
	  <td><label>
	  <?php if($_SESSION['Control_Panel']==10 or $_SESSION['Control_Panel']==74) { ?>
        <input type="text" id="txt30" name="gate_no" value="<?php if($gate_no) print($gate_no);?>" />
      <b style="color:red">*</b>
	  <?php } else { ?>
	  <b><?php if($gate_no) print($gate_no); ?> </b>
	  <?php } ?>
	  </label></td>
    </tr>
	
	<tr>
	 <td width="200" height="41" class="data" id="txt30"><div align="left"><span class="style2">Risk Bond</span></div></td>
        <td width="2">&nbsp;:&nbsp;</td>
	  <td><label>
	  <?php if($_SESSION['Control_Panel']==10 or $_SESSION['Control_Panel']==74) { ?>
        <input type="text" id="txt30" name="risk_bond" value="<?php if($risk_bond) print($risk_bond);?>" />
      
	  <?php } else { ?>
	  <b><?php if($risk_bond) print($risk_bond); ?> </b>
	  <?php } ?>
	  </label></td>
    </tr>
	<?php
	if($IP_address)
	{
	?>
	<tr>
	 <td width="200" height="41" class="data" id="txt30"><div align="left"><span class="style2">Document Verifying Gate</span></div></td>
        <td width="2">&nbsp;:&nbsp;</td>
	  <td><label>
       <b><?php

	$sql_gate=mysql_query("select gate_name from delivery_gate_name where gate_ip='$IP_address'");
	//print("select gate_name from delivery_gate_name where gate_ip='$IP_address'");
	$row_gate=mysql_fetch_object($sql_gate);	

	 if($IP_address) print($row_gate->gate_name);?></b>
      </label></td>
    </tr>
	
	<?php  } ?>
	<?php
	if($Issue_no)
	{
	?>
	<tr>
	 <td width="200" height="41" class="data" id="txt30"><div align="left"><span class="style2">Issued By & Time</span></div></td>
        <td width="2">&nbsp;:&nbsp;</td>
	  <td><label>
       <b><?php

	$sql_user=mysql_query("select u_name from users where login_id='$Issue_by'");
	$row_user=mysql_fetch_object($sql_user);	

	 if($Issue_by) print($Issue_by." (".$row_user->u_name." )<br>".$Issue_Time);?></b>
      </label></td>
    </tr>
	
	<?php  } ?>
	 <tr>
	 <td width="200" height="41" class="data" id="txt31"<div align="left"><span class="style2">Discrepancy report (if any)</span></div></td>
      <td width="2">&nbsp;:&nbsp;</td> 
	 <td><label>
       	<?php if($_SESSION['Control_Panel']!=100 && $_SESSION['Control_Panel']!=81) {?>
		<!--<textarea rows="5" cols="50" name="port_comment"><?php print($Port_comment); ?></textarea>-->
		<select id="comment" name="port_comment" onchange="checksubmit(this.value)">
		<option value="">.............Select...........</option>
		<option value="Quantity Mismatch" <?php if($Port_comment=="Quantity Mismatch") print('selected'); ?>>Quantity Mismatch</option>
		<option value="Container No Mismatch" <?php if($Port_comment=="Container No Mismatch") print('selected'); ?>>Container No Mismatch</option>
		<option value="Other" <?php if($Port_comment=="Other") print('selected'); ?>>Other</option>
		<option value="No Discrepancy" <?php if($Port_comment=="No Discrepancy") print('selected'); ?>>No Discrepancy</option>
		</select>
		<?php } else { ?>
			<!--<textarea rows="5" cols="50" name="port_comment" style="visibility:hidden;"><?php print($Port_comment); ?></textarea>-->
			<label><b><?php if($Port_comment=="No Decrepancy"){print("No Discrepancy");} else { print($Port_comment); }?></b></label>
		<?php } ?>
	  </td>
    </tr>
	<?php if($_SESSION['Control_Panel']!=12) {
	if($decrepency_remarks) {
	?>
	 <tr>
	 <td width="200" height="41" class="data" id="txt31"<div align="left"><span class="style2">Port Comments</span></div></td>
      <td width="2">&nbsp;:&nbsp;</td> 
	 <td>    	
	<label><b><?php print($decrepency_remarks); ?></b></label>
	 </td>
    </tr>
		<?php }} ?>
		<?php if($Deliver_status==1)  {?>	
	<tr>
	 <td width="200" height="41" class="data" id="txt26"><div align="left"><span class="style2">Delivered By  </span></div></td>
       <td width="2">&nbsp;:&nbsp;</td>
	 <td><label>  <b><?php print($Dlogin_id."<br>".$Deliver_dttime);?> <b> </label></td>
    </tr>
	<tr>
	<?php } ?>
	<?php if($Cepz_Notify_Delv==1)  {?>	
	<tr>
	 <td width="200" height="41" class="data" id="txt26"><div align="left"><span class="style2">Transffered By  </span></div></td>
       <td width="2">&nbsp;:&nbsp;</td>
	 <td><label>  <b><?php print($Dlogin_id."<br>".$Deliver_dttime);?> <b> </label></td>
    </tr>
	<tr>
	<?php } ?>
	<?php if($EPZ_Received_status==1)  {?>	
	<tr>
	 <td width="200" height="41" class="data" id="txt26"><div align="left"><span class="style2">EPZ Received By  </span></div></td>
       <td width="2">&nbsp;:&nbsp;</td>
	 <td><label>  <b><?php print($EPZ_Received_by."<br>".$EPZ_Received_Date);?> <b> </label></td>
    </tr>
	<tr>
	<?php } ?>
	<?php if($EPZ_Delivery_status==1)  {?>	
	<tr>
	 <td width="200" height="41" class="data" id="txt26"><div align="left"><span class="style2">EPZ Delivered By  </span></div></td>
       <td width="2">&nbsp;:&nbsp;</td>
	 <td><label>  <b><?php print($EPZ_Delivery_by."<br>".$EPZ_Delivery_Date);?> <b> </label></td>
    </tr>
	<tr>
	<?php } ?>
     <tr>
	 <td width="200" height="41" class="data" id="txt30"><div align="left"><span class="style2">Location of Goods</span></div></td>
        <td width="2">&nbsp;:&nbsp;</td>
	  <td><label>
        <input type="text" id="txt30" name="txt_Location_og_goods" value="<?php if($Location_og_goods) print($Location_og_goods); else print($LOCATION_OF_GOODS);?>" />
      </label><b style="color:red">*</b></td>
    </tr>
	 <tr>
	 <td width="200" height="41" class="data" id="txt31"<div align="left"><span class="style2"> Jetty Sarker's License No</span></div></td>
       <td width="2">&nbsp;:&nbsp;</td>
	 <td><label>
        <input type="text" id="txt31" name="txt_JT_Sarker" value="<?php if($JT_Sarkar_nm) print($JT_Sarkar_nm); else print($JT_SARKER);?>"    />
      </label><b style="color:red">*</b></td>
    </tr>
	<?php if($_SESSION['Control_Panel']==100) { ?>
	 <tr>
	 <td width="200" height="41" class="data" id="txt31"<div align="left"><span class="style2"> Mode  of Transport </span></div></td>
        <td width="2">&nbsp;:&nbsp;</td>
	  <td><label>
        <!--<input type="text" id="txt31" name="mode_of_transport" value="<?php print($mode_of_transport);?>"    />-->
		<select name="mode_of_transport">
		<option value="Prime Mover" <?php if($mode_of_transport=="Prime Mover") print('selected'); ?>>Prime Mover</option>
		<option value="Truck" <?php if($mode_of_transport=="Truck") print('selected'); ?>>Truck</option>
		<option value="Covered Van" <?php if($mode_of_transport=="Covered Van") print('selected'); ?>>Covered Van</option>
		<option value="Other" <?php if($mode_of_transport=="Other") print('selected'); ?>>Other</option>
		</select>
      </label></td>
    </tr>
	<tr>
	 <td width="200" height="41" class="data" id="txt31"<div align="left"><span class="style2"> Transport Identification No </span></div></td>
        <td width="2">&nbsp;:&nbsp;</td>
	  <td><label>
        <input type="text" id="txt31" name="Identification_no" value="<?php print($Identification_no);?>"    />
		
      </label></td>
    </tr>
	<?php } ?>
	<script language = "Javascript" type="text/javascript">
	function check(remarks)
	{
	var cepz=document.getElementById("CEPZ").value;
	//alert(remarks);
	//alert(document.getElementById('1').checked);
	if(document.getElementById('1').checked)
	{
	//alert();
		document.getElementById('options').style.backgroundColor="pink";
		document.getElementById("remarks").style.visibility = 'visible';
		if(cepz!="")
		document.getElementById("uppercase").value ="This Consginment has been delivered/Shiptes/Tranfer to CEPZ or KEPZ.";
		else
		document.getElementById("uppercase").value ="All document checked found correct and permitted for delivery.";
		document.getElementById("Add").style.visibility = 'visible';
		document.getElementById("Add").value = 'Deliver';
	}
	else
	{
		document.getElementById('options').style.backgroundColor="white";
	}
	if(document.getElementById('2').checked)
	{
		document.getElementById('options2').style.backgroundColor="pink";
		document.getElementById("remarks").style.visibility = 'visible';
		document.getElementById("uppercase").value = remarks;
		document.getElementById("Add").style.visibility = 'visible';
		document.getElementById("Add").value = 'Not Delivered';
	}
	else
	{
		document.getElementById('options2').style.backgroundColor="white";
	}
	}
	</script>
	
	<?php if($msg1==""){ 
		if($_SESSION['Control_Panel']==100){
	?>
	
	
	<!--<tr>
		<td width="200" height="41" class="data" id="upper32"><div align="left"><span class="style2"> Checked</span></div></td>
		  <td width="2">&nbsp;:&nbsp;</td>
		<td>
			<input type="checkbox" name="checkbox" id="checkbox" onclick="ischecked()">
		</td>
	</tr>-->
	<?php } } ?>
	<?php if($_SESSION['Control_Panel']==100){ 
	//if($Status=="")
	//{
	?>
	
	<!--<tr id="status" style="visibility:display;">-->
	<?php //} else { ?>
	<tr id="status" style="visibility:display;">
	<?php //} ?>
		<td width="200" height="41" class="data" id="upper32"><div align="left"><span class="style2"> Status</span></div></td>
		  <td width="2">&nbsp;:&nbsp;</td>
		<td id="options" <?php if ($Status=="Found Ok"){?> style="background-color: pink;" <?php } else {?> style="background-color: white;" <?php } ?>  >
			<input type="radio" name="options" id="1" value="ok" onclick="check('<?php print($Delivered_remarks); ?>')" <?php if($Status=="Found Ok") print("checked"); ?>> Found Ok<br>
		</td>
			</tr>
			<?php 
			//if($Status=="")
			//{
			?>
			<!--<tr id="status2" style="visibility:display;">-->
			<?php// } else { ?>
			<tr id="status2" style="visibility:display;">
			<?php //} ?>
			<td>&nbsp;</td>
			  <td>&nbsp;</td>
		<td id="options2" <?php if ($Status=="Not Found Ok"){?> style="background-color: pink;" <?php } else {?> style="background-color: white;" <?php } ?> >
			<input type="radio" name="options" id="2" value="not" onclick="check('<?php print($Delivered_remarks); ?>')" <?php if($Status=="Not Found Ok") print("checked"); ?>>Not Found Ok
			
		</td>
		
		
	</tr>
	<?php } 
	if($_SESSION['Control_Panel']==12){
	if($decrepency_remarks) {
	?>
	<tr id="remarks" style="visibility:display;">
	<?php } else { ?>
	<tr id="remarks" style="visibility:hidden;">
	<?php } ?>
		<td width="200" height="41" class="data" id="upper32"><div align="left"><span class="style2"> <?php if($_SESSION['Control_Panel']==12){ ?>Port Comments<?php }else { ?>Delivery Remarks <?php } ?></span></div></td>
	    <td width="2">&nbsp;:&nbsp;</td>
		<td><label>
		<textarea type="text" id="uppercase" name="txt_Delivery_remarks"   onkeyup="upperCase(this.id)" style="width:260px;height:80px"><?php if($decrepency_remarks) print($decrepency_remarks); ?></textarea>
		</label></td>
    </tr>
	<?php
		}
	else {
	if($Status=="") { 
	?>
	 <tr id="remarks" style="visibility:hidden;">
	 <?php } else { ?>
	  <tr id="remarks" style="visibility:display;">
	  <?php } ?>
		 <td width="200" height="41" class="data" id="upper32"><div align="left"><span class="style2"> Delivery Remarks </span></div></td>
	        <td width="2">&nbsp;:&nbsp;</td>
		  <td><label>
		  <textarea type="text" id="uppercase" name="txt_Delivery_remarks"   onkeyup="upperCase(this.id)" style="width:260px;height:80px">
<?php 


if($EPZ_Received_status==1){ print("All document checked found correct and permitted for delivery."); } 
else if($EPZ_Received_status==0 and $Cepz_Notify_Delv==1){ print("RECEIVED ON GATE OF EPZ"); } 
elseif ($Delivery_remarks){print($Delivery_remarks);}
else print("All document checked found correct and permitted for delivery.");?></textarea>
		  
		</label></td>
    </tr>
	<?php } ?>
	
    <tr>
      <td height="44" class="data"><span class="style2">
        <label>
        <div align="center" class="style2"></div>
        <span class="style2">
        </label>
        <label></label>
      </span></td>
      <td colspan="2"><label>
        <label></label>
        <div align="justify">
<span class="style2">
	
			
          <input style="visibility:hidden;"  type="submit" id="theSearchButton" name="search" value="SEARCH" />
          </span>
	<?php  
	
			if($_SESSION['Control_Panel']==10 or $_SESSION['Control_Panel']==74)
			{
				if($Issue_no){ ?>
		
			<input type="submit" name="Issue" id="Issue" style="visibility:display;" value="Issue Update" onClick="return mychecked();"/>
			<?php } else { ?>
			
			<input type="submit" name="Issue" id="Issue" style="visibility:display;" value="Issue" onClick="return mychecked();"/>
          </span>
			<?php 
			} 
			}	
			//print($_SESSION['Control_Panel']."<hr>");
			if(!($_SESSION['Control_Panel']==100 or $_SESSION['Control_Panel']==10 or $_SESSION['Control_Panel']==74 or $_SESSION['Control_Panel']==1010)){
			
			?>
			 <input id="mySubmit" style="visibility:hidden;" type="submit" onclick="return mychecked()" name="Checked" value="Submit" />
          <?php
			
			if($Deliver_status==0 && $Check_by_port!="") { ?>
			<input id="mySubmit" style="visibility:display;" type="submit" onclick="return mychecked()" name="CheckedUpdate" value="Update" />
			<?php  } ?>
		  </span>
		    <?php  } ?>
		  <?php if($Deliver_status==0) {
			
			if($select_code=="0" or $select_code=="" or $select_code=="2")
			{
				if($_SESSION['login_id']!="ds00100")
				{
				if($Cepz_Notify_Delv==1 and $EPZ_Received_status==0){
				?>
				
				<input type="submit" name="Received" id="Received" style="visibility:visible;" value="Received" onClick="return myDeliveryconfirm();"/>
				<?php
				}
				elseif ($EPZ_Received_status==1 and $EPZ_Delivery_status==0) {
					?>
					<input type="submit" name="EPZDeliver" id="EPZDeliver" style="visibility:visible;" value="EPZDeliver" onClick="return myDeliveryconfirm();"/>
					<?php
					} else {

		  ?>
           <input type="submit" name="Add" id="Add" style="visibility:hidden;" value="Deliver" onClick="return myDeliveryconfirm();"/>
          </span>
		<?php }} } } ?>
		   <input style="visibility:hidden;"  type="reset" name="reset" value="Reset" onclick="reset();">
          </span>
		<?php 
			if($_SESSION['Control_Panel']==100){
			if($msg1!="" or $msg!=""){
			//print($id."shemul");
			
			?>
			 <input onclick="printer_win(<?php print($id) ?>,<?php print($BENO); ?>,'<?php print($BEDATE) ?>',<?php print($office_code); ?>)" type="submit" name="print" value="PRINT" />
			<?php } } ?>
		 <!--<input type="submit" name="edit" value="Update">-->
		 <input type="hidden" id="CEPZ" value="<?php print($NotifyDesc_cepz_check); ?>">
          </span>
			
		</div>
      </label></td>
    </tr>
  </table>
  <script>
 
  </script>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
			
		   </div>
		  <div class="clr"></div>
        
       </div>
	
      </div>
       <!-- <p class="pages"><small>Page 1 of 2</small> <span>1</span> <a href="#">2</a> <a href="#">&raquo;</a></p>-->
      
     <div class="sidebar">
	   <?php include_once("mySideBar.php"); ?>
	 </div>
      <div class="clr"></div>

	</div>
</div>