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
				<td height="50px"  >
				<?php $cont_id=$_POST['containerLocation']; //echo $cont_id; ?>	
					<table WIDTH="95%" align="center">
						<tr>
							<td WIDTH="20%" ALIGN="left">Container No</td>
							<td ALIGN="CENTER">Location Description</td>
						</tr>
						<?php
						
							include("mydbPConnectionctms.php");
							$sql2=mysql_query("select gkey,fcy_time_out from mis_inv_unit where id='$cont_id'");
							while($row2=mysql_fetch_object($sql2)){
							if($row2->fcy_time_out==""){
								$sql3=mysql_query("call update_containers_by_gkey($row2->gkey)");
							}
							
							}
							
							
							
							$sql="
SELECT ms.id, 
 
CASE  
 WHEN 
  ms.category = 'IMPRT' 
 THEN 
  (CASE WHEN   
     ms.fcy_last_pos_loctype ='YARD'   
        THEN   
     CONCAT('Yard:',IFNULL(ctmsmis.cont_yard(ms.fcy_last_pos_slot),''), 
              ',Block:',IFNULL(ctmsmis.cont_block(ms.fcy_last_pos_slot,ctmsmis.cont_yard(ms.fcy_last_pos_slot)),''),  
                     ',Pos:',CONVERT(ms.fcy_last_pos_slot USING utf8), 
              ',Ctgry:',ms.category,',Freight Kind:',ms.freight_kind, 
              ',Dest:',IFNULL(ms.destination,''), 
              ',ISO:',IFNULL(ms.iso_code,''), 
              ',AssnType:',IFNULL((SELECT sparcsn4.inv_unit.flex_string01 FROM sparcsn4.inv_unit WHERE sparcsn4.inv_unit.gkey=ms.gkey),''), 
              ',AssnDate:',IFNULL(ms.fcy_flx_date01,''),  
              ',DisTime:',ifnull(ms.fcy_time_in,'') 
              )   
       WHEN   
           ms.fcy_last_pos_loctype ='VESSEL'    
       THEN  
    CONCAT('Position : ',CONVERT(ms.fcy_position_name USING utf8),',Vessel Name : ',ms.vsl_name,',Category : ',ms.category)  
       ELSE 
    IFNULL(CONCAT('Position : ',CONVERT(ms.fcy_position_name USING utf8),',Vessel Name : ',ms.vsl_name,',Category : ',ms.category),'NO CONTAINER FOUND')  
   
    END) 
 WHEN  
  ms.category = 'EXPRT'   
 THEN  
  (CASE WHEN   
     ms.fcy_last_pos_loctype ='YARD'   
        THEN   
     CONCAT('Yard:',IFNULL(ctmsmis.cont_yard(ms.fcy_last_pos_slot),''),  
     ', Block:',IFNULL(ctmsmis.cont_block(ms.fcy_last_pos_slot,ctmsmis.cont_yard(ms.fcy_last_pos_slot)),''), 
     ',Position:',IFNULL(CONVERT(ms.fcy_last_pos_slot USING utf8),''), 
     ',Category:',ms.category,',Gate In:',ifnull(ms.fcy_time_in,'')) 
       WHEN   
           ms.fcy_last_pos_loctype ='VESSEL'    
       THEN  
    CONCAT('Position : ',IFNULL(CONVERT(ms.fcy_position_name USING utf8),''),',Vessel Name : ',ms.vsl_name,',Category : ',ms.category,',Load Time : ',ifnull(ms.fcy_time_out,''))         
       ELSE 
    CONCAT('NOT IN YARD,GATE OUT : ', 
         ifnull(ms.fcy_time_out,''), 
           ',Category : ',  
           CONCAT (ms.category ,', ', 
             IFNULL((SELECT CONCAT (CASE WHEN sub_type='DE' THEN 'Dray Off'   
            WHEN sub_type='DI' THEN 'Delivery Import'   
            WHEN sub_type='DM' THEN 'Delivery EMPTY'   
            WHEN sub_type='RE' THEN 'INBOUND'   
       END  ,' to Offdock :', NAME) AS d FROM sparcsn4.road_truck_transactions   
       inner JOIN sparcsn4.ref_bizunit_scoped ON road_truck_transactions.trkco_id=ref_bizunit_scoped.id   
       WHERE unit_gkey=ms.gkey LIMIT 1),'') 
         )   
         )   
   
    END) 
 WHEN  
  ms.category = 'STRGE' 
 THEN 
  (CASE WHEN   
     ms.fcy_last_pos_loctype ='YARD'   
        THEN   
     CONCAT('Yard:',ctmsmis.cont_yard(ms.fcy_last_pos_slot), 
          ',Block:',ctmsmis.cont_block(ms.fcy_last_pos_slot,ctmsmis.cont_yard(ms.fcy_last_pos_slot)), 
          ',Position:',CONVERT(ms.fcy_last_pos_slot USING utf8), 
          ',Category:',ms.category,',Gate Out:',ifnull(ms.fcy_time_in,''))      
       ELSE 
    CONCAT('NOT IN YARD,GATE OUT : ', 
         ifnull(ms.fcy_time_out,''), 
           ',Category : ',  
           CONCAT (ms.category ,', ', 
             IFNULL((SELECT CONCAT (CASE WHEN sub_type='DE' THEN 'Dray Off'   
            WHEN sub_type='DI' THEN 'Delivery Import'   
            WHEN sub_type='DM' THEN 'Delivery EMPTY'   
            WHEN sub_type='RE' THEN 'Receive Export'   
       END  ,' to Offdock :', NAME) AS d FROM sparcsn4.road_truck_transactions   
       inner JOIN sparcsn4.ref_bizunit_scoped ON road_truck_transactions.trkco_id=ref_bizunit_scoped.id   
       WHERE unit_gkey=ms.gkey LIMIT 1),'') 
         )   
         )   
   
    END) 
 ELSE 
  'NO CONTAINER FOUND' 
END 
 
AS dsc  
 
FROM ctmsmis.mis_inv_unit ms  WHERE ms.id ='$cont_id' ORDER BY ms.gkey DESC LIMIT 1";
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
						
						<tr>
							<td  WIDTH="20%" ALIGN="LEFT"></td>
							<td align="center">
                                <table border="1" cellspacing="0" cellpadding="0" bgcolor="#B5EFF0">
                                    <tr><td align="center" >
                                            <font color="black">&nbsp;You can get Container Location by sending SMS to <b>2777</b><br/>&nbsp;SMS Format: cont < space > Container No<br/>&nbsp;EXAMPLE: cont WHLU2317382<br/>&nbsp; (This is on TEST BASIS)</font>
                                    </td></tr></table>
                            </td>
						</tr>
						
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
			$sql1=mysql_query("SELECT igm_masters.Import_Rotation_No,Vessel_Name,Voy_No,Port_of_Shipment,igm_masters.file_clearence_date,(SELECT CONCAT(IFNULL(Organization_Name,' '),' ',IFNULL(Address_1,' '),' ',IFNULL(Address_2,' ')) FROM organization_profiles WHERE organization_profiles.id=igm_detail_container.off_dock_id) AS offdock FROM igm_detail_container INNER JOIN igm_details ON igm_details.id=igm_detail_container.igm_detail_id INNER JOIN igm_masters ON igm_masters.id=igm_details.IGM_id WHERE cont_number='$cont_id'");
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
			
			
					
				
			
			<tr>
				<td ><hr/></td>
			</tr>
			
			<tr>
				<td ><img src="<?php echo IMG_PATH; ?>containerloc.png" width="1050" height="500" alt="" /></td>
			</tr>
		</table>
		
	</body>
</html>