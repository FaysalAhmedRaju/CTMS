<html>
	<head>
		<title>Chittagong Port Authority</title>
		<link rel="shortcut icon" href="<?php echo IMG_PATH; ?>cpa.png" />
	</head>
	<body>

		<table width="72%" align="center" border="0">
			<tr>
				<td height="80px" bgcolor="#F9FAFB" >
					<img src="<?php echo IMG_PATH;?>logo_cpa.gif" />
				</td>
			</tr>
			<tr>
				<td>
					<p style="text-align: justify;">
						<font color='blue' size='4'>										
							<b>Message To:<br/>
							OffDock: Please check Your Pre-advise Declaration before sending Export Containers to Port otherwise GATEIN process will be halted.
							<br/>
							Shipping Agent/MLO: Please declare and check Pre-advise for Export Containers properly otherwise GATEIN Process will be halted.
							<br/>
							For any help please Contact CTMS helpline:01749-923327</b><hr/>
						</font>
					</p>
				</td>
			</tr>
			<tr>
				<td height="50px"  >
				<?php $cont_id=$_POST['containerLocation']; //echo $cont_id; ?>	
					<table WIDTH="95%" align="center">
						<tr>
							<td WIDTH="20%" ALIGN="left">Container No</td>
							<td ALIGN="CENTER">Location Description</td>
						</tr>
			<?php
			include("mydbPConnectionn4.php");
			$strCat = "select category from sparcsn4.inv_unit where id='$cont_id' order by sparcsn4.inv_unit.gkey desc limit 1";
			$resCat = mysql_query($strCat);
			$cat="";		
			while($rowCat = mysql_fetch_object($resCat))
			{
				$cat=$rowCat->category;
			}
		
			if($cat=="IMPRT")
			{
				$sql="SELECT inv.id,
				 
				  (CASE WHEN   
					 fcyVisit.last_pos_loctype ='YARD'   
						THEN   
					 CONCAT('Yard:',IFNULL(ctmsmis.cont_yard(fcyVisit.last_pos_slot),''), 
							  ',Block:',IFNULL(ctmsmis.cont_block(fcyVisit.last_pos_slot,ctmsmis.cont_yard(fcyVisit.last_pos_slot)),''),  
									 ',Pos:',CONVERT(fcyVisit.last_pos_slot USING utf8), 
							  ',Ctgry:',inv.category,',Freight Kind:',inv.freight_kind, 
							  ',Dest:',IFNULL(desti.destination,''), 
							  ',MLO:',g.id,
							  ',ISO:',IFNULL(sparcsn4.ref_equip_type.id,''), 
							  ',AssnType:',IFNULL((SELECT sparcsn4.inv_unit.flex_string01 FROM sparcsn4.inv_unit WHERE sparcsn4.inv_unit.gkey=inv.gkey),''), 
							  ',AssnDate:',IFNULL(fcyVisit.flex_date01,''),  
							  ',DisTime:',ifnull(fcyVisit.time_in,'') 
							  )   
					   WHEN   
						   fcyVisit.last_pos_loctype ='VESSEL'    
					   THEN  
					CONCAT('Position : ',CONVERT(fcyVisit.last_pos_name USING utf8),',Vessel Name : ',sparcsn4.vsl_vessels.name,',Category : ',inv.category)  
					   ELSE 
					IFNULL(CONCAT('Position : ',CONVERT(fcyVisit.last_pos_name USING utf8),',Vessel Name : ',sparcsn4.vsl_vessels.name,',Category : ',inv.category),'NO CONTAINER FOUND')  
				   
					END) 
				
				 
				AS dsc  
				 
				FROM sparcsn4.inv_unit inv  
				inner join sparcsn4.inv_unit_fcy_visit fcyVisit on fcyVisit.unit_gkey=inv.gkey
				INNER JOIN sparcsn4.argo_carrier_visit ON (argo_carrier_visit.gkey=inv.declrd_ib_cv or argo_carrier_visit.gkey=inv.cv_gkey)
				INNER JOIN sparcsn4.argo_visit_details ON sparcsn4.argo_visit_details.gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
				INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_visit_details.gkey
				inner join sparcsn4.vsl_vessels on vsl_vessels.gkey=vsl_vessel_visit_details.vessel_gkey
				inner join sparcsn4.vsl_vessel_classes on vsl_vessel_classes.gkey=vsl_vessels.vesclass_gkey
				INNER JOIN sparcsn4.inv_unit_equip ON inv.gkey=inv_unit_equip.unit_gkey 
				inner join  sparcsn4.ref_bizunit_scoped g ON inv.line_op = g.gkey
				INNER JOIN sparcsn4.ref_equipment ON inv_unit_equip.eq_gkey=ref_equipment.gkey
				INNER JOIN sparcsn4.ref_equip_type ON ref_equipment.eqtyp_gkey=ref_equip_type.gkey 
				inner join sparcsn4.inv_goods desti on desti.gkey=inv.goods
				WHERE inv.id ='$cont_id' ORDER BY inv.gkey DESC LIMIT 1";
			}
			else if($cat=="EXPRT") 
			{
				$sql="
				SELECT inv.id, 
				 
				  (CASE WHEN   
					 fcyVisit.last_pos_loctype ='YARD'   
						THEN   
					 CONCAT('Yard:',IFNULL(ctmsmis.cont_yard(fcyVisit.last_pos_slot),''),  
					 ', Block:',IFNULL(ctmsmis.cont_block(fcyVisit.last_pos_slot,ctmsmis.cont_yard(fcyVisit.last_pos_slot)),''), 
					 ',Position:',IFNULL(CONVERT(fcyVisit.last_pos_slot USING utf8),''),
					 ',MLO:',g.id,
					 ',Category:',inv.category,',Gate In:',ifnull(fcyVisit.time_in,'')) 
					   WHEN   
						   fcyVisit.last_pos_loctype ='VESSEL'    
					   THEN  
					CONCAT('Position : ',IFNULL(CONVERT(fcyVisit.last_pos_name USING utf8),''),',Vessel Name : ',sparcsn4.vsl_vessels.name,',Category : ',inv.category,',Load Time : ',ifnull(fcyVisit.time_out,''))         
					   ELSE 
					CONCAT('PRE ADVISED : ',IFNULL(CONVERT(fcyVisit.last_pos_name USING utf8),''), 
						   ',Category : ',CONCAT (inv.category ,', ', 
							 IFNULL((SELECT CONCAT (CASE WHEN sub_type='DE' THEN 'Dray Off'   
							WHEN sub_type='DI' THEN 'Delivery Import'   
							WHEN sub_type='DM' THEN 'Delivery EMPTY'   
							WHEN sub_type='RE' THEN 'INBOUND'   
					   END  ,' to Offdock :', NAME) AS d FROM sparcsn4.road_truck_transactions   
					   inner JOIN sparcsn4.ref_bizunit_scoped ON road_truck_transactions.trkco_id=ref_bizunit_scoped.id   
					   WHERE unit_gkey=inv.gkey LIMIT 1),'') 
						 )   
						 )   
				   
					END) 
				AS dsc  
				 
				FROM sparcsn4.inv_unit inv  

				inner join sparcsn4.inv_unit_fcy_visit fcyVisit on fcyVisit.unit_gkey=inv.gkey
				INNER JOIN sparcsn4.argo_carrier_visit ON (argo_carrier_visit.gkey=inv.declrd_ib_cv or argo_carrier_visit.gkey=inv.cv_gkey)
				INNER JOIN sparcsn4.argo_visit_details ON sparcsn4.argo_visit_details.gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
				INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_visit_details.gkey
				inner join sparcsn4.vsl_vessels on vsl_vessels.gkey=vsl_vessel_visit_details.vessel_gkey
				inner join  sparcsn4.ref_bizunit_scoped g ON inv.line_op = g.gkey
				WHERE inv.id ='$cont_id' ORDER BY inv.gkey DESC LIMIT 1";
			}
			
			else
			{
				$sql="SELECT inv.id, 
					CONCAT('Position:',fcyVisit.last_pos_name,
				  ',Category:',inv.category,
				  ',Freight Kind:',inv.freight_kind, 
				  ',Time Move:',ifnull(fcyVisit.time_move,''))       
					AS dsc 
					FROM sparcsn4.inv_unit inv  
					inner join sparcsn4.inv_unit_fcy_visit fcyVisit on fcyVisit.unit_gkey=inv.gkey
					WHERE inv.id ='$cont_id' ORDER BY inv.gkey DESC LIMIT 1";
			}		
							
							//echo $sql;
							 $result=mysql_query($sql);
							// echo mysql_num_rows($result);
							 $row=mysql_fetch_object($result);
							// echo $row->id."=".$row->dsc."<hr>";
							
							$ipAddress=$this->ip_address = $_SERVER['REMOTE_ADDR'];
							//date_default_timezone_set("Asia/Dhaka");
							$s2=date("Y-m-d H:i:s");
							$data="$cont_id |$ipAddress |$s2 \n";
							write_file("ContainerSearch.txt", $data, 'a');
							 
						?>
						<tr>
							<td  WIDTH="20%" ALIGN="LEFT"><?php echo strtoupper($cont_id); ?></td>
							<td ALIGN="CENTER"><?php if($row->dsc) echo $row->dsc; else echo "&nbsp";?></td>
						</tr>
						
						<!--tr>
							<td  WIDTH="20%" ALIGN="LEFT"></td>
							<td align="center">
                                <table border="1" cellspacing="0" cellpadding="0" bgcolor="#B5EFF0">
                                    <tr><td align="center" >
                                            <font color="black">&nbsp;You can get Container Location by sending SMS to <b>2777</b><br/>&nbsp;SMS Format: cont < space > Container No<br/>&nbsp;EXAMPLE: cont WHLU2317382<br/>&nbsp; (This is on TEST BASIS)</font>
                                    </td></tr></table>
                            </td>
						</tr-->
						
					</table>
				</td>
			</tr>
			<tr>
				<td height="80px" bgcolor="#F9FAFB" >
					<img src="<?php echo IMG_PATH;?>logoDataSoft.png" align="left" height="30px"/> <img src="<?php echo IMG_PATH;?>stlogo.gif" align="right"/>
				</td>
				
			</tr>
			<tr>
				<td height="10px"  ></td>
				
			</tr>
			<tr>
				<td ><hr/></td>
			</tr>
			<?php
			mysql_close($con);
			include_once("mydbPConnection.php");
			$sql1=mysql_query("SELECT igm_masters.Import_Rotation_No,Vessel_Name,Voy_No,Port_of_Shipment,igm_masters.file_clearence_date,(SELECT CONCAT(IFNULL(Organization_Name,' '),' ',IFNULL(Address_1,' '),' ',IFNULL(Address_2,' ')) FROM organization_profiles WHERE organization_profiles.id=igm_detail_container.off_dock_id) AS offdock FROM igm_detail_container INNER JOIN igm_details ON igm_details.id=igm_detail_container.igm_detail_id INNER JOIN igm_masters ON igm_masters.id=igm_details.IGM_id WHERE cont_number='$cont_id'ORDER BY file_clearence_date DESC LIMIT 1");
			//echo "SELECT igm_masters.Import_Rotation_No,Vessel_Name,Voy_No,Port_of_Shipment,igm_masters.file_clearence_date,(SELECT CONCAT(IFNULL(Organization_Name,' '),' ',IFNULL(Address_1,' '),' ',IFNULL(Address_2,' ')) FROM organization_profiles WHERE organization_profiles.id=igm_detail_container.off_dock_id) AS offdock FROM igm_detail_container INNER JOIN igm_details ON igm_details.id=igm_detail_container.igm_detail_id INNER JOIN igm_masters ON igm_masters.id=igm_details.IGM_id WHERE cont_number='$cont_id'";
			$row2=mysql_fetch_object($sql1);
			//echo mysql_num_rows($sql1);
			
			
			?>
			<tr>
				<td bgcolor="#B5EFF0">
			<table width="100%"  align="center" border="0">
			
					<tr>
						<td ><b>Detail Information</b></td>
					</tr>
					<tr>
						<td width="20%">Container No</td><td>:</td><td ><b><?php echo strtoupper($cont_id); ?></b></td>
					</tr>
					<tr>
						<td width="20%">Last Vessel Name</td><td>:</td><td ><b><?php echo $row2->Vessel_Name; ?></b></td>
					</tr>
					<tr>
						<td width="20%">Import Rotation No</td><td>:</td><td ><b><?php echo $row2->Import_Rotation_No; ?></b></td>
					</tr>
					<tr>
						<td width="20%">Voy No</td><td>:</td><td ><b><?php echo $row2->Voy_No; ?></b></td>
					</tr>
					<tr>
						<td width="20%">Vessel Arrival Date(Estimated)</td><td>:</td><td ><b><?php echo  $row2->file_clearence_date; ?></b></td>
					</tr>
					<tr>
						<td width="20%">Port of Shipment</td><td>:</td><td ><b><?php echo  $row2->Port_of_Shipment; ?></b></td>
					</tr>
					<tr>
						<td width="20%">Port/Offdock</td><td>:</td><td ><b><?php echo  $row2->offdock; ?></b></td>
					</tr>
				</table>
			</td>
			
		</tr>	
			
			<?php mysql_close($con);?>
					
				
			
			<tr>
				<td ><hr/></td>
			</tr>
			
			<tr>
				<td ><img src="<?php echo IMG_PATH; ?>containerloc.png" width="1050" height="500" alt="" /></td>
			</tr>
		</table>
		
	</body>
</html>