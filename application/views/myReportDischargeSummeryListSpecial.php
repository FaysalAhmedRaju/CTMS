<HTML>
	<HEAD>
		<!--TITLE>IGM Final Amendment</TITLE-->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <style type="text/css">
<!--
.style1 {font-size: 12px}
-->
        </style>
</HEAD>
<BODY>

	<?php
	
		if($_POST['options']=='xl'){
			header("Content-Type: application/ms-excel;charset=UTF-8");
			header("Content-Disposition: attachment; filename=FEEDER_DISCHARGE_Summary_LIST.xls;");
		}
	
		$rotation=$_POST['ddl_imp_rot_no']; 
		include("dbConection.php");
		$query_n4 = "SELECT  r.name,DATE(vsl_vessel_visit_details.flex_date01) AS arr_dt
		FROM sparcsn4.vsl_vessel_visit_details
		INNER JOIN sparcsn4.ref_bizunit_scoped r  ON  sparcsn4.vsl_vessel_visit_details.bizu_gkey=r.gkey		
		WHERE sparcsn4.vsl_vessel_visit_details.ib_vyg='$rotation' ";
		$result_query_n4=mysql_query($query_n4);
		$row_query_n4=mysql_fetch_object($result_query_n4);	
		mysql_close($con_sparcsn4);
						  //mysql_close($con_cchaportdb);
        $sum=0;
	$grand=0;
//mysql_connect("192.168.1.7", "user-dev", "user7test");
//mysql_select_db("ccha");
        include("mydbPConnection.php");
        
	
	//$rotation=$_REQUEST['ddl_imp_rot_no'];
	$igmdetail=mysql_query("select * from igm_details where Import_Rotation_No='$rotation'");
		$testdetailRes2=mysql_num_rows($igmdetail);
		//echo $testdetailRes2."<hr>";
		if($testdetailRes2<1)
		{
			$igmMaster=mysql_query("select Import_Rotation_No,Vessel_Name,Total_number_of_bols,Total_number_of_packages,Total_number_of_containers,Total_gross_mass,Voy_No from igm_masters where Import_Rotation_No='$rotation'");
			$testRes2=mysql_num_rows($igmMaster);
			$row_igm_master=mysql_fetch_object($igmMaster);		
			if($testRes2>0)
		{
	?>
	<TABLE width="100%">
			<TR><TD width="100%">
				<table class='table-header' border=0 width="100%">
					<tr><td colspan="2" align="center"><h1> GENERAL INFORMATION</h1></td></tr>
					<tr>
						<tr>
						<td align="center">Vessel name:<?php print($row_igm_master->Vessel_Name);?></td>
						<td align="center">Rotation No:&nbsp;&nbsp;<?php print($row_igm_master->Import_Rotation_No);?></td>
						</tr>
					</tr>
						
				</table>
			</TD></TR>
			<TR><TD>
					<table width="100%" border=1  cellspacing="0" cellpadding="0">
						<tr>
							<th align="center"><span class="style1" >Total Number Of BL</span></th>
							<th align="center"><span class="style1" >Total Number Of Packages</span></th>
							<th align="center"><span class="style1" >Total Number Of Containers</span></th>
							<th align="center"><span class="style1" >Total Gross Mass</span></th>
						</tr>
					
				    <tr>
						<td align="right"><?php print($row_igm_master->Total_number_of_bols);?></td>
						<td align="right"><?php print($row_igm_master->Total_number_of_packages);?></td>
						<td align="right"><?php print($row_igm_master->Total_number_of_containers);?></td>
						<td align="right"><?php print($row_igm_master->Total_gross_mass);?></td>
					</tr>
					</table>
						<!--<tr><td colspan="2" align="center"><h3><font color="red"> We found Only General segment from ASYCUDA World but we don't get any BL and Container segment. Please contact with ASYCUDA World Team for resending .</font></h3></td></tr>-->
					
			</TD></TR>
		</TABLE>
	
	
	<?php }
	else{
		?>
		<tr><td colspan="2" align="center"><h3><font color="red">No Record found for your given rotation . Please type correctly and try again.</font></h3></td></tr>
		
		<?php
		}

	} else{ ?>
		<?php
		$result_igm_master1="SELECT
												igm_masters.Import_Rotation_No,
												igm_masters.Vessel_Name,
												Voy_No,
												Net_Tonnage,
												Port_of_Shipment,
												Port_of_Destination,
												Sailed_Year,
												Submitee_Org_Id,
												Name_of_Master,
												Organization_Name,
												is_Foreign,
												Vessel_Type,Actual_Berth,Actual_Berth_time
											FROM
												igm_masters 
												LEFT JOIN organization_profiles ON 
												organization_profiles.id=igm_masters.Submitee_Org_Id
												LEFT JOIN vessels ON vessels.id=igm_masters.Vessel_Id
												left join vessels_berth_detail on vessels_berth_detail.Import_Rotation_No=igm_masters.Import_Rotation_No
											WHERE igm_masters.Import_Rotation_No='$rotation'"
														;
			$result_igm_master=mysql_query($result_igm_master1);
			$row_igm_master=mysql_fetch_object($result_igm_master);	
         // print("Shemul".$row_igm_master->Import_Rotation_No);
	?>
	<div class="pageBreak">
	<table>
		
		<tr><td>TO</td></tr>
		<tr><td>TERMINAL MANAGER</td></tr>
		<tr><td>CHITTAGONG PORT AUTHORITY</td></tr>
		<tr><td>SUB : Permission For Discharging Import Container</td></tr>
		<tr><td><b>From / To Vessel  : <?php echo($row_igm_master->Vessel_Name);?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Voyage No - <?php echo($row_igm_master->Voy_No);?></b> </td></tr>
		<!--tr><td><b>Imp.Rot.No - <?php echo($row_igm_master->Import_Rotation_No);?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Arrival Date :  <?php echo($row_query_n4->arr_dt);?></b></td></tr-->
		<tr><td><b>Imp.Rot.No - <?php echo($row_igm_master->Import_Rotation_No);?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Arrival Date : </b><input type="text" id="inActivities" name="inActivities" style="border:1px solid black" /></td></tr>
		<tr><td>Dear sir</td></tr>
		<tr><td>We would like to inform you that we as operator of the above vessel herewith enclose the list of imp.containers of </td></tr>
		<tr><td>following MLO's </td></tr>
	</table>

	<table align="center" width="100%" border="1" style="border-collapse:collapse">
		<tr>
				
				<!--th align="center"><span class="style1" >Shipping Agent Name</span></th>
				<th align="center"><span class="style1" >Agent Name</span></th-->
				<th align="center"><span class="style1" >Agent CODE</span></th>
				
				<th align="center"><span class="style1" >MLO CODE</span></th>
				<th colspan='2' align="center"><span class="style1" >LADEN</span></th>
				<th colspan='2' align="center"><span class="style1" >EMPTY</span></th>
			
				<th colspan='2' align="center"><span class="style1" >REFFER</span></th>
				
				
				<th colspan='2' align="center"><span class="style1" >IMDG</span></th>
				
				<th colspan='2' align="center"><span class="style1" >TRANS</span></th>
				
				<th colspan='2' align="center"><span class="style1" >PANGAON</span></th>
		
				<th colspan='2' align="center"><span class="style1" >ICD</span></th>
				
				<th colspan='2' align="center"><span class="style1" >45'</span></th>
				
				<th colspan='' align="center"><span class="style1" >TOTAL</span></th>
				
				<?php if($countBillRow>0) { ?>
				<th  align="center"><span class="style1" >VIEW BILL</span></th>
				<th  align="center"><span class="style1" >VIEW DETAIL</span></th>
				<?php } ?>
					
			
				
				
		</tr>
					
		<tr>
		 <tr>
			  
			  <!--td  align="center"><?php  print("&nbsp;");?></td>
			 
			  <td  align="center"><?php print("&nbsp;");?></td-->
			 <td  align="center"><?php print("&nbsp;");?></td>
			 <td  align="center"><?php print("&nbsp;");?></td>
			  <td  align="center"><?php  print("20'");?></td>
			   <td  align="center"><?php print("40'");?></td>
			  <td  align="center"><?php  print("20'");?></td>
			   <td  align="center"><?php print("40'");?></td>
			  <td  align="center"><?php  print("20'");?></td>
			   <td  align="center"><?php print("40'");?></td>
			  <td  align="center"><?php  print("20'");?></td>
			  <td  align="center"><?php print("40'");?></td>
			  <td  align="center"><?php  print("20'");?></td>
			  <td  align="center"><?php print("40'");?></td>
			  <td  align="center"><?php  print("20'");?></td>
			  <td  align="center"><?php print("40'");?></td>
			  <td  align="center"><?php  print("20'");?></td>
			  <td  align="center"><?php  print("40'");?></td>
			  <td  align="center"><?php print("L");?></td>
			  <td  align="center"><?php  print("E");?></td>
			  <td  align="center"><?php print("&nbsp;");?></td>
			
		</tr>
							
			<?php
					$str="select distinct submitee_org_id,organization_profiles.Organization_Name as Organization_Name,organization_profiles.Agent_Code,mlocode as mlocode from igm_details 
					inner join organization_profiles on igm_details.Submitee_Org_Id=organization_profiles.id 
					where Import_Rotation_No='$rotation' order by Organization_Name,mlocode";
					
					$result=mysql_query($str);
					$i=0;
					while ($row=mysql_fetch_object($result))
					{
						//$i++;
										   $sum=$sum+$grand;
			?>
			  <tr>
					
					<!--td  align="center"><?php if($row->Organization_Name) print($row->Organization_Name); else print("&nbsp;");?></td-->
					<?php
					$sql_agent_code=mysql_query("select mlodescription,mlo_agent_code_ctms,agent_from,org_id from mlo_detail where mlocode='$row->mlocode'");
					//print("select mlo_agent_code_ctms from mlo_detail where mlocode='$row->mlocode' and org_id='$row->submitee_org_id'");		
					$row_agent_code=mysql_fetch_object($sql_agent_code);
					
					//$resultcombo1 = mysql_query("select Organization_Name,AIN_No,License_No,Address_1 from organization_profiles where id='$row_agent_code->org_id'");
					//$rowcombo1 = mysql_fetch_object($resultcombo1);
					?>
					
					<!--td  align="center"><?php if($row_agent_code->mlodescription) print($row_agent_code->mlodescription); else print("&nbsp;");?></td-->
					<td  align="center">
					<?php
					
					
					if($row_agent_code->mlo_agent_code_ctms) print($row_agent_code->mlo_agent_code_ctms); else print("&nbsp;");
					?></td>

					  
					  <td  align="center"><?php if($row->mlocode) print($row->mlocode); else print("&nbsp;");?></td>
					<?php
//FCL-20"
					$str1="select count(distinct cont_number) as total from igm_detail_container inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id 
							where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and mlocode='$row->mlocode' and cont_iso_type not in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') and type_of_igm<>'TS' 
						 and off_dock_id <>'2592' and cont_status not in ('EMT','EMPTY','MT','ETY') and cont_size =20 and  igm_details.final_submit=1";	
					//print($str1."<br>");
					$result1=mysql_query($str1);
					$row1=mysql_fetch_object($result1);
	//imdg			
					$str1="select count(distinct cont_number) as total from igm_detail_container inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id 
					where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and mlocode='$row->mlocode' and cont_iso_type not in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') and type_of_igm<>'TS' 
					and off_dock_id<>'2592'  and cont_size =20 and (cont_imo <> '' and cont_un <> '' and igm_details.final_submit=1)";	
					$result1_dmg=mysql_query($str1);
					$row1_dmg=mysql_fetch_object($result1_dmg);

					?>
					 <td  align="center"><?php if($row1->total) print($row1->total-$row1_dmg->total); else print(""); $total1=$row1->total-$row1_dmg->total; $totalg1=$totalg1+$total1;?></td>
					<?php
//FCL-40"
					 $str1="select count(distinct cont_number) as total from igm_detail_container inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id 
						   where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and mlocode='$row->mlocode' and cont_iso_type not in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') and type_of_igm<>'TS' 
						   and off_dock_id<>'2592' and cont_status not in ('EMT','EMPTY','MT','ETY') and cont_size =40 and igm_details.final_submit=1";
//print("<br>".$str1);		
					$result1=mysql_query($str1);
					$row1=mysql_fetch_object($result1);
//imdg							
					$str1="select count(distinct cont_number) as total from igm_detail_container inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id 
					where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and mlocode='$row->mlocode' and type_of_igm<>'TS' and off_dock_id<>'2592' and cont_iso_type not in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3')
					and  cont_size =40 and (cont_imo <> '' or cont_un <> '') and igm_details.final_submit=1";	
					$result1_dmg=mysql_query($str1);
					$row1_dmg=mysql_fetch_object($result1_dmg);
					?>
					 <td  align="center"><?php if($row1->total) print($row1->total-$row1_dmg->total); else print(""); $total2=$row1->total-$row1_dmg->total; $totalg2=$totalg2+$total2;?></td>
					<?php
//Empty-20"
					$str1="select count(distinct cont_number) as total from igm_detail_container inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id 
						   where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and mlocode='$row->mlocode' and cont_iso_type not in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3')and type_of_igm<>'TS' 
						   and off_dock_id<>'2592' and   (cont_status='EMT' or cont_status='Empty' or cont_status='MT' or cont_status='ETY') and cont_size =20 and (cont_imo = '' and cont_un = '' and igm_details.final_submit=1)";	
					$result1=mysql_query($str1);
					$row1=mysql_fetch_object($result1);
					
					?>
					 <td  align="center"><?php if($row1->total) print($row1->total); else print(""); $total3=$row1->total; $totalg3=$totalg3+$total3;?></td>		 
					<?php
//Empty-40"
					$str1="select count(distinct cont_number) as total from igm_detail_container inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id 
						   where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and mlocode='$row->mlocode' and cont_iso_type not in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') and type_of_igm<>'TS' 
						   and off_dock_id<>'2592' and  (cont_status='EMT' or cont_status='Empty' or cont_status='MT' or cont_status='ETY') and cont_size =40 and (cont_imo = '' and cont_un = '' and igm_details.final_submit=1)";	
					$result1=mysql_query($str1);
					$row1=mysql_fetch_object($result1);
					
					?>
					 <td  align="center"><?php if($row1->total) print($row1->total); else print(""); $total4=$row1->total; $totalg4=$totalg4+$total4;?></td>		 
				<?php
//Reefer - 20"
					$str1="select count(distinct cont_number) as total from igm_detail_container inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id 
						   where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and mlocode='$row->mlocode' and cont_iso_type like '%R%' and cont_iso_type not in ('DRY') and type_of_igm<>'TS' 
						   and off_dock_id<>'2592'  and cont_size =20 and igm_details.final_submit=1";	
					$result1=mysql_query($str1);
					$row1=mysql_fetch_object($result1);
					
					?>
					 <td  align="center"><?php if($row1->total) print($row1->total); else print(""); $total5=$row1->total; $totalg5=$totalg5+$total5;?></td>		 
				<?php
//Reefer - 40
					$str1="select count(distinct cont_number) as total from igm_detail_container inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id 
						   where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and mlocode='$row->mlocode' and cont_iso_type like '%R%' and cont_iso_type not in ('DRY') and type_of_igm<>'TS' 
						   and off_dock_id<>'2592'  and cont_size =40 and igm_details.final_submit=1";	
					//print($str1."<br>");
					$result1=mysql_query($str1);
					$row1=mysql_fetch_object($result1);
					
					?>
					 <td  align="center"><?php if($row1->total) print($row1->total); else print(""); $total6=$row1->total; $totalg6=$totalg6+$total6;?></td>		 
				<?php
//IMDG 20"
					$str1="select count(distinct cont_number) as total from igm_detail_container inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id 
						   where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and mlocode='$row->mlocode' and cont_type not in ('REFER','REEFER')and type_of_igm<>'TS' 
						   and off_dock_id<>'2592'  and cont_size =20 and (cont_imo <> '' and cont_un <> '' and igm_details.final_submit=1)";	
					$result1=mysql_query($str1);
					$row1=mysql_fetch_object($result1);
					
					?>
					 <td  align="center"><?php if($row1->total) print($row1->total); else print(""); $total7=$row1->total; $totalg7=$totalg7+$total7;?></td>		 
				<?php

//IMDG 40"

					$str1="select count(distinct cont_number) as total from igm_detail_container inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id 
						   where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and mlocode='$row->mlocode' and type_of_igm<>'TS' and off_dock_id<>'2592' and cont_iso_type not in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3')
						   and  cont_size =40 and (cont_imo <> '' or cont_un <> '') and igm_details.final_submit=1";	
					$result1=mysql_query($str1);
					$row1=mysql_fetch_object($result1);
					
					?>
					 <td  align="center"><?php if($row1->total) print($row1->total); else print(""); $total8=$row1->total; $totalg8=$totalg8+$total8;?></td>		 
				<?php
//TS 20"
					$str1="select count(distinct cont_number) as total from igm_detail_container inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id 
						   where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and mlocode='$row->mlocode' and type_of_igm='TS' and cont_iso_type not in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') 
						   and off_dock_id<>'2592'  and cont_size =20 and igm_details.final_submit=1";	
					$result1=mysql_query($str1);
					$row1=mysql_fetch_object($result1);
					
					?>
					 <td  align="center"><?php if($row1->total) print($row1->total); else print(""); $total9=$row1->total; $totalg9=$totalg9+$total9;?></td>		 
				<?php
//TS 40"
					/*$str1="select count(distinct cont_number) as total from igm_detail_container inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id 
						   where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and mlocode='$row->mlocode' and type_of_igm='TS' and cont_iso_type not in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3')
						   and off_dock_id<>'2592' and  cont_size =40 and igm_details.final_submit=1";*/	
					
					// Edited By Sourav Remove 45R1 from the condition
					$str1="select count(distinct cont_number) as total from igm_detail_container inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id 
						   where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and mlocode='$row->mlocode' and type_of_igm='TS' and cont_iso_type not in('22R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3')
						   and off_dock_id<>'2592' and  cont_size =40 and igm_details.final_submit=1";	
					$result1=mysql_query($str1);
					$row1=mysql_fetch_object($result1);
					
					?>
					 <td  align="center"><?php if($row1->total) print($row1->total); else print(""); $total10=$row1->total; $totalg10=$totalg10+$total10;?></td>		 
					
					<!-- PANGAON -->
					
					<?php
//PANGAON 20"							
					$str1="select count(distinct cont_number) as total from igm_detail_container inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id 
						   where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and mlocode='$row->mlocode' and cont_iso_type not in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') 
						   and off_dock_id='5235'  and cont_size =20 and igm_details.final_submit=1";	
					$result1=mysql_query($str1);
					$row1=mysql_fetch_object($result1);
					
					?>
					 <td  align="center"><?php if($row1->total) print($row1->total); else print(""); $total21=$row1->total; $total21=$total21+$total21;?></td>		 
				<?php
//PANGAON 40"	
					$str1="select count(distinct cont_number) as total from igm_detail_container inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id 
						   where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and mlocode='$row->mlocode' and cont_iso_type not in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3')
						   and off_dock_id='5235' and  cont_size =40 and igm_details.final_submit=1";	
					$result1=mysql_query($str1);
					$row1=mysql_fetch_object($result1);
					
					?>
					 <td  align="center"><?php if($row1->total) print($row1->total); else print(""); $total22=$row1->total; $totalg22=$totalg22+$total22;?></td>	
					<!-- PANGAON -->
					
					
					<?php
//OFFDock 20"							
					$str1="select count(distinct cont_number) as total from igm_detail_container inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id 
						   where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and mlocode='$row->mlocode' and cont_iso_type not in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') 
						   and off_dock_id='2592'  and cont_size =20 and igm_details.final_submit=1";	
					$result1=mysql_query($str1);
					$row1=mysql_fetch_object($result1);
					
					?>
					 <td  align="center"><?php if($row1->total) print($row1->total); else print(""); $total11=$row1->total; $totalg11=$totalg11+$total11;?></td>		 
				<?php
//OFFDock 40"	
					$str1="select count(distinct cont_number) as total from igm_detail_container inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id 
						   where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and mlocode='$row->mlocode' and cont_iso_type not in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3')
						   and off_dock_id='2592' and  cont_size =40 and igm_details.final_submit=1";	
					$result1=mysql_query($str1);
					$row1=mysql_fetch_object($result1);
					
					?>
					 <td  align="center"><?php if($row1->total) print($row1->total); else print(""); $total12=$row1->total; $totalg12=$totalg12+$total12;?></td>		 
					 <?php
//Full  45"
					$str1="select count(distinct cont_number) as total from igm_detail_container inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id 
						   where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and mlocode='$row->mlocode'  and cont_iso_type not in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3')
						   and cont_size >40 and igm_details.final_submit=1 and (cont_status <> 'EMT' and cont_status <> 'Empty' and cont_status <> 'MT' and cont_status <> 'ETY')";	
					

					$result1=mysql_query($str1);  
					$row1=mysql_fetch_object($result1);
					
					?>
					 <td  align="center"><?php if($row1->total) print($row1->total); else print(""); $total13=$row1->total; $totalg13=$totalg13+$total13;?></td>		 
				<?php
//Empty 45"
					 $str1="select count(distinct cont_number) as total from igm_detail_container inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id 
						   where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and mlocode='$row->mlocode' and cont_iso_type not in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3')
						   and cont_size >40 and igm_details.final_submit=1 and   (cont_status='EMT' or cont_status='Empty' or cont_status='MT' or cont_status='ETY') ";	

//print($str1."<br>");							
					$result1=mysql_query($str1);
					$row1=mysql_fetch_object($result1);
					
					?>
					 <td  align="center"><?php if($row1->total) print($row1->total); else print(""); $total14=$row1->total; $totalg14=$totalg14+$total14;?></td>		 
					<?php $grand=$total1+$total2+$total3+$total4+$total5+$total6+$total7+
					$total8+$total9+$total10+$total11+$total12+$total13+$total14+$total21+$total22; ?>
					
					
	
					<td align="center"><?php if($grand) print($grand); else print(" "); ?></td>
					
					</tr>
			 <?php $i++; } ?>
		
		</tr>

		<tr>
			<td align="center"><b>Grand Total</b></td>
			<!--td><?php print("&nbsp;");?></td>
			<td><?php print("&nbsp;");?></td-->
			<td><?php print("&nbsp;");?></td>
			<td align="center"><b><?php if($totalg1 > 0) echo $totalg1; else echo " ";?></b></td>
			<td align="center"><b><?php if($totalg2 > 0) echo $totalg2; else echo " ";?></b></td>
			<td align="center"><b><?php if($totalg3 > 0) echo $totalg3; else echo " ";?></b></td>
			<td align="center"><b><?php if($totalg4 > 0) echo $totalg4; else echo " ";?></b></td>
			<td align="center"><b><?php if($totalg5 > 0) echo $totalg5; else echo " ";?></b></td>
			<td align="center"><b><?php if($totalg6 > 0) echo $totalg6; else echo " ";?></b></td>
			<td align="center"><b><?php if($totalg7 > 0) echo $totalg7; else echo " ";?></b></td>
			<td align="center"><b><?php if($totalg8 > 0) echo $totalg8; else echo " ";?></b></td>
			<td align="center"><b><?php if($totalg9 > 0) echo $totalg9; else echo " ";?></b></td>
			<td align="center"><b><?php if($totalg10 > 0) echo $totalg10; else echo " ";?></b></td>
			<td align="center"><b><?php if($totalg21 > 0) echo $totalg21; else echo " ";?></b></td>
			<td align="center"><b><?php if($totalg22 > 0) echo $totalg22; else echo " ";?></b></td>
			<td align="center"><b><?php if($totalg11 > 0) echo $totalg11; else echo " ";?></b></td>
			<td align="center"><b><?php if($totalg12 > 0) echo $totalg12; else echo " ";?></b></td>
			<td align="center"><b><?php if($totalg13 > 0) echo $totalg13; else echo " ";?></b></td>
			<td align="center"><b><?php if($totalg14 > 0) echo $totalg14; else echo " ";;?></b></td>
			<td align="center"><b><?php print($sum+$grand);?></b></td>
                    
		</tr>
	</table>
	<table>
		<tr><td>Vessels Berth Operator : SAIF POWERTEC LIMITED</td></tr>
	</table>
	<!--table align="right">
		<tr align="right">
			<td>BOXES = </td>
			<td><input type="text" id="inActivities" name="inActivities" style="border:1px solid black" /> </td>
		</tr>
		<tr align="right">
			<td>TEUS = </td>
			<td><input type="text" id="inActivities" name="inActivities" style="border:1px solid black" /> </td>
		</tr>
	</table-->
	<table> 
		<tr>
			<td>
				<table>
					<?php 
						$query_summary="SELECT
						IFNULL(SUM(fcl_20),0) AS fcl_20,
						IFNULL(SUM(fcl_40),0) AS fcl_40,
						IFNULL(SUM(fcl_tues),0) AS fcl_tues,
						IFNULL(SUM(fcl_20),0)+IFNULL(SUM(fcl_40),0) AS fcl_box,

						IFNULL(SUM(lcl_20),0) AS lcl_20,
						IFNULL(SUM(lcl_40),0) AS lcl_40,
						IFNULL(SUM(lcl_tues),0) AS lcl_tues,
						IFNULL(SUM(lcl_20),0)+IFNULL(SUM(lcl_40),0) AS lcl_box,

						IFNULL(SUM(icd_20),0) AS icd_20,
						IFNULL(SUM(icd_40),0) AS icd_40,
						IFNULL(SUM(icd_tues),0) AS icd_tues,
						IFNULL(SUM(icd_20),0)+IFNULL(SUM(icd_40),0) AS icd_box,

						IFNULL(SUM(ref_20),0) AS ref_20,
						IFNULL(SUM(ref_40),0) AS ref_40,
						IFNULL(SUM(ref_tues),0) AS ref_tues,
						IFNULL(SUM(ref_20),0)+IFNULL(SUM(ref_40),0) AS ref_box,

						IFNULL(SUM(png_20),0) AS png_20,
						IFNULL(SUM(png_40),0) AS png_40,
						IFNULL(SUM(png_tues),0) AS png_tues,
						IFNULL(SUM(png_20),0)+IFNULL(SUM(png_40),0) AS png_box,

						IFNULL(SUM(emp_20),0) AS emp_20,
						IFNULL(SUM(emp_40),0) AS emp_40,
						IFNULL(SUM(emp_tues),0) AS emp_tues,
						IFNULL(SUM(emp_20),0)+IFNULL(SUM(emp_40),0) AS emp_box,

						IFNULL(SUM(dep_20),0) AS dep_20,
						IFNULL(SUM(dep_40),0) AS dep_40,
						IFNULL(SUM(dep_tues),0) AS dep_tues,
						IFNULL(SUM(dep_20),0)+IFNULL(SUM(dep_40),0) AS dep_box

						 FROM (
						SELECT 
						(CASE WHEN cont_size =20 and cont_status='FCL' and cont_iso_type not in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') and type_of_igm<>'TS' 
						AND off_dock_id=2591 THEN 1  
						ELSE NULL END) AS fcl_20, 
						(CASE WHEN cont_size > 20 AND cont_status = 'FCL' and cont_iso_type not in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') and type_of_igm<>'TS' 
						AND off_dock_id=2591 THEN 1  
						ELSE NULL END) AS fcl_40,
						(CASE WHEN cont_size=20 AND cont_status = 'FCL' and cont_iso_type not in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') and type_of_igm<>'TS' 
						 AND off_dock_id=2591 THEN 1 
						ELSE (CASE WHEN cont_size>20 AND cont_status = 'FCL' and cont_iso_type not in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') and type_of_igm<>'TS' 
						 AND off_dock_id=2591 THEN 2 ELSE NULL END) END) AS fcl_tues,

						(CASE WHEN cont_size =20 AND cont_status='LCL' THEN 1  
						ELSE NULL END) AS lcl_20, 
						(CASE WHEN cont_size > 20 AND cont_status = 'LCL'  THEN 1  
						ELSE NULL END) AS lcl_40,
						(CASE WHEN cont_size=20 AND cont_status = 'LCL' THEN 1 
						ELSE (CASE WHEN cont_size>20 AND cont_status = 'LCL' THEN 2 ELSE NULL END) END) AS lcl_tues,

						(CASE WHEN cont_iso_type NOT IN('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') AND off_dock_id='2592'  AND cont_size =20 THEN 1  
						ELSE NULL END) AS icd_20, 
						(CASE WHEN cont_iso_type NOT IN('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') AND off_dock_id='2592'  AND cont_size  > 20  THEN 1  
						ELSE NULL END) AS icd_40,
						(CASE WHEN cont_iso_type NOT IN('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') AND off_dock_id='2592'  AND cont_size =20 THEN 1 
						ELSE (CASE WHEN cont_iso_type NOT IN('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') AND off_dock_id='2592'  AND cont_size >20 THEN 2 ELSE NULL END) END) AS icd_tues,

						(CASE WHEN cont_iso_type LIKE '%R%' AND cont_iso_type NOT IN ('DRY') AND type_of_igm<>'TS' 
														   AND off_dock_id<>'2592'  AND cont_size =20 THEN 1  
						ELSE NULL END) AS ref_20, 
						(CASE WHEN cont_iso_type LIKE '%R%' AND cont_iso_type NOT IN ('DRY') AND type_of_igm<>'TS' 
														   AND off_dock_id<>'2592'  AND cont_size  > 20  THEN 1  
						ELSE NULL END) AS ref_40,
						(CASE WHEN cont_iso_type LIKE '%R%' AND cont_iso_type NOT IN ('DRY') AND type_of_igm<>'TS' 
														   AND off_dock_id<>'2592'  AND cont_size =20 THEN 1 
						ELSE (CASE WHEN cont_iso_type LIKE '%R%' AND cont_iso_type NOT IN ('DRY') AND type_of_igm<>'TS' 
														   AND off_dock_id<>'2592'  AND cont_size >20 THEN 2 ELSE NULL END) END) AS ref_tues,
														   
						(CASE WHEN off_dock_id='5235'  AND cont_size =20 THEN 1  
						ELSE NULL END) AS png_20, 
						(CASE WHEN off_dock_id='5235'  AND cont_size  > 20  THEN 1  
						ELSE NULL END) AS png_40,
						(CASE WHEN off_dock_id='5235'  AND cont_size =20 THEN 1 
						ELSE (CASE WHEN off_dock_id='5235'  AND cont_size >20 THEN 2 ELSE NULL END) END) AS png_tues,

						(CASE WHEN cont_size =20 AND (cont_status='EMT' OR cont_status='Empty' OR cont_status='MT' OR cont_status='ETY') THEN 1  
						ELSE NULL END) AS emp_20, 
						(CASE WHEN cont_size  > 20 AND (cont_status='EMT' OR cont_status='Empty' OR cont_status='MT' OR cont_status='ETY') THEN 1  
						ELSE NULL END) AS emp_40,
						(CASE WHEN cont_size =20 AND (cont_status='EMT' OR cont_status='Empty' OR cont_status='MT' OR cont_status='ETY') THEN 1 
						ELSE (CASE WHEN cont_size >20 AND (cont_status='EMT' OR cont_status='Empty' OR cont_status='MT' OR cont_status='ETY') THEN 2 ELSE NULL END) END) AS emp_tues,

						(CASE WHEN cont_size =20 AND off_dock_id NOT IN ('2591','2592','5235') THEN 1  
						ELSE NULL END) AS dep_20, 
						(CASE WHEN cont_size  > 20 AND off_dock_id NOT IN ('2591','2592','5235') THEN 1  
						ELSE NULL END) AS dep_40,
						(CASE WHEN cont_size =20 AND off_dock_id NOT IN ('2591','2592','5235') THEN 1 
						ELSE (CASE WHEN cont_size >20 AND off_dock_id NOT IN ('2591','2592','5235') THEN 2 ELSE NULL END) END) AS dep_tues


						FROM igm_detail_container
						INNER JOIN igm_details ON igm_details.id=igm_detail_container.igm_detail_id 
						WHERE  Import_Rotation_No='$rotation' AND igm_details.final_submit=1
						) AS tmp";
						$result_summary=mysql_query($query_summary);
						$row_summary=mysql_fetch_object($result_summary);	
				
						
					?>
					<tr><td><font size="5">1)Container Control SEC.</font></td></tr>
					<tr><td><font size="5">2)Computer to TI/Cont Billing.</font></td></tr>
					<tr><td><font size="5">3)B.M.S.O.T.R SEC</font></td></tr>
					<tr><td><font size="5">4)Office Supdt Accounts Sec</font></td></tr>
					<tr><td><font size="5">5)Vessels Berth Operator : SAIF POWERTEC LIMITED</font></td></tr>
					<tr><td><font size="5">6)AGENT <?php echo $row_query_n4->name ?></font></td></tr>
					<tr><td style="width:90px"><font size="5">7)Berth/Ship -</font>  <input type="text" id="inActivities" name="inActivities" style="border:1px solid black" /></td></tr>
					<tr><td><font size="5">8)ALL MLO's - <?php echo $i; ?></font> </td></tr>
				</table>
			</td>
			<td>
				<div>
				<table width="300px" style="border-collapse:collapse">
					<tr >
						<td align="right" style="width:210px">BOXES = </td>
						<td style="width:90px"><input type="text" id="inActivities" name="inActivities" style="border:1px solid black" /> </td>
					</tr>
					<tr >
						<td align="right" style="width:210px">TEUS = </td>
						<td><input type="text" id="inActivities" name="inActivities" style="border:1px solid black" /> </td>
					</tr>
				</table>
				</div>
				<div align="center">
				<table align="center" width="300px" border="1" style="border-collapse:collapse;margin-top:0px;">
					<tr>
						<td></td>
						<td align="center">20</td>
						<td align="center">40</td>
						<td align="center">BOX</td>
						<td align="center">TUES</td>
					</tr>
					<tr>
						<td align="center">FCL</td>
						<td align="center"><?php echo $row_summary->fcl_20; ?></td>
						<td align="center"><?php echo $row_summary->fcl_40; ?></td>
						<td align="center"><?php echo $row_summary->fcl_box; ?></td>
						<td align="center"><?php echo $row_summary->fcl_tues; ?></td>
					</tr>
					<tr>
						<td align="center">LCL</td>
						<td align="center"><?php echo $row_summary->lcl_20; ?></td>
						<td align="center"><?php echo $row_summary->lcl_40; ?></td>
						<td align="center"><?php echo $row_summary->lcl_box; ?></td>
						<td align="center"><?php echo $row_summary->lcl_tues; ?></td>
					</tr>
					<tr>
						<td align="center">ICD</td>
						<td align="center"><?php echo $row_summary->icd_20; ?></td>
						<td align="center"><?php echo $row_summary->icd_40; ?></td>
						<td align="center"><?php echo $row_summary->icd_box; ?></td>
						<td align="center"><?php echo $row_summary->icd_tues; ?></td>
					</tr>
					<tr>
						<td align="center">REFFER</td>
						<td align="center"><?php echo $row_summary->ref_20; ?></td>
						<td align="center"><?php echo $row_summary->ref_40; ?></td>
						<td align="center"><?php echo $row_summary->ref_box; ?></td>
						<td align="center"><?php echo $row_summary->ref_tues; ?></td>
					</tr>
					<tr>
						<td align="center">PNG</td>
						<td align="center"><?php echo $row_summary->png_20; ?></td>
						<td align="center"><?php echo $row_summary->png_40; ?></td>
						<td align="center"><?php echo $row_summary->png_box; ?></td>
						<td align="center"><?php echo $row_summary->png_tues; ?></td>
					</tr>
					<tr>
						<td align="center">DEPOT</td>
						<td align="center"><?php echo $row_summary->dep_20; ?></td>
						<td align="center"><?php echo $row_summary->dep_40; ?></td>
						<td align="center"><?php echo $row_summary->dep_box; ?></td>
						<td align="center"><?php echo $row_summary->dep_tues; ?></td>
					</tr>
					<tr>
						<td align="center">EMPTY</td>
						<td align="center"><?php echo $row_summary->emp_20; ?></td>
						<td align="center"><?php echo $row_summary->emp_40; ?></td>
						<td align="center"><?php echo $row_summary->emp_box; ?></td>
						<td align="center"><?php echo $row_summary->emp_tues; ?></td>
					</tr>
					<tr>
						<td align="center">TOTAL</td>
						<td align="center"><?php echo $row_summary->fcl_20 + $row_summary->lcl_20 + $row_summary->icd_20 + $row_summary->ref_20 + $row_summary->png_20 + $row_summary->dep_20 + $row_summary->emp_20; ?></td>
						<td align="center"><?php echo $row_summary->fcl_40 + $row_summary->lcl_40 + $row_summary->icd_40 + $row_summary->ref_40 + $row_summary->png_40 + $row_summary->dep_40 + $row_summary->emp_40; ?></td>
						<td align="center"><?php echo $row_summary->fcl_box + $row_summary->lcl_box + $row_summary->icd_box + $row_summary->ref_box + $row_summary->png_box + $row_summary->dep_box + $row_summary->emp_box; ?></td>
						<td align="center"><?php echo $row_summary->fcl_tues + $row_summary->lcl_tues + $row_summary->icd_tues + $row_summary->ref_tues + $row_summary->png_tues + $row_summary->dep_tues + $row_summary->emp_tues; ?></td>
					</tr>
				</table>
				</div>
			</td>
		</tr>
	</table>
	<?php  }?>
	</div>
	<div >
		<table align="center" width="90%" border="0" style="border-collapse:collapse">
			<tr>
				<td align="right">Vessel</td>
				<td align="center">:</td>
				<td><?php echo $row_igm_master->Vessel_Name; ?></td>
				<td align="right">Voyage No</td>
				<td align="center">:</td>
				<td><?php echo $row_igm_master->Voy_No; ?></td>
				<td align="right">Rot No</td>
				<td align="center">:</td>
				<td><?php echo $row_igm_master->Import_Rotation_No; ?></td>
			</tr>
		</table>
		<br>
		<table align="center" width="90%" border="1" style="border-collapse:collapse">
			<tr>
				<td align="center" rowspan="2"><b>SL No.</b></td>
				<td align="center" rowspan="2"><b>MLO</b></td>
				<td align="center" colspan="2"><b>FCL</b></td>
				<td align="center" colspan="2"><b>LCL</b></td>
				<td align="center" colspan="2"><b>ICD</b></td>
				<td align="center" colspan="2"><b>EMPTY</b></td>
				<td align="center" rowspan="2"><b>BOX</b></td>
				<td align="center" rowspan="2"><b>TEUS</b></td>
			</tr>
			<tr>
				<td align="center"><b>20'</b></td>
				<td align="center"><b>40'</b></td>
				<td align="center"><b>20'</b></td>
				<td align="center"><b>40'</b></td>
				<td align="center"><b>20'</b></td>
				<td align="center"><b>40'</b></td>
				<td align="center"><b>20'</b></td>
				<td align="center"><b>40'</b></td>
			</tr>
			<?php
			include("mydbPConnection.php");
			$sql_mlo_info="SELECT DISTINCT submitee_org_id,organization_profiles.Organization_Name AS Organization_Name,organization_profiles.Agent_Code,mlocode AS mlocode 
			FROM igm_details 
			INNER JOIN organization_profiles ON igm_details.Submitee_Org_Id=organization_profiles.id 
			WHERE Import_Rotation_No='$rotation' 
			ORDER BY Organization_Name,mlocode";
			
			$rslt_mlo_info=mysql_query($sql_mlo_info);
			
			$i=0;
			
			$grand_tot_fcl_20=0;
			$grand_tot_fcl_40=0;
			
			$grand_tot_lcl_20=0;
			$grand_tot_lcl_40=0;
			
			$grand_tot_icd_20=0;
			$grand_tot_icd_40=0;
			
			$grand_tot_mty_20=0;
			$grand_tot_mty_40=0;
			
			$grand_tot_box=0;
			$grand_tot_teus=0;
			
			while($row_mlo_info=mysql_fetch_object($rslt_mlo_info))
			{
				$tot_box=0;
				$tot_teus=0;
			?>
			<tr>
				<td align="center"><?php echo $i+1; ?></td>
				<td align="center"><?php echo $row_mlo_info->mlocode; ?></td>
				<?php
				// $sql_fcl_20="SELECT COUNT(DISTINCT cont_number) AS total 
				// FROM igm_detail_container 
				// INNER JOIN igm_details ON igm_details.id=igm_detail_container.igm_detail_id 
				// WHERE Import_Rotation_No='$rotation' AND Submitee_Org_Id='$row_mlo_info->submitee_org_id' AND mlocode='$row_mlo_info->mlocode' 
				// AND cont_iso_type NOT IN('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') 
				// AND type_of_igm<>'TS' AND off_dock_id <>'2592' AND cont_status NOT IN ('EMT','EMPTY','MT','ETY') AND cont_size =20 AND igm_details.final_submit=1";
				
				$sql_fcl_20="SELECT COUNT(DISTINCT cont_number) AS total 
				FROM igm_detail_container 
				INNER JOIN igm_details ON igm_details.id=igm_detail_container.igm_detail_id 
				WHERE Import_Rotation_No='$rotation' AND Submitee_Org_Id='$row_mlo_info->submitee_org_id' AND mlocode='$row_mlo_info->mlocode' 
				AND cont_iso_type NOT IN('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') 
				AND type_of_igm<>'TS' AND off_dock_id <>'2592' AND cont_status IN ('FCL') AND cont_size =20 AND igm_details.final_submit=1";
				
				$rslt_fcl_20=mysql_query($sql_fcl_20);
				
				$fcl_20=mysql_fetch_object($rslt_fcl_20);
				?>
				<td align="center"><?php echo $fcl_20->total; ?></td>
				<?php
				$sql_fcl_40="SELECT COUNT(DISTINCT cont_number) AS total 
				FROM igm_detail_container 
				INNER JOIN igm_details ON igm_details.id=igm_detail_container.igm_detail_id 
				WHERE Import_Rotation_No='$rotation' AND Submitee_Org_Id='$row_mlo_info->submitee_org_id' AND mlocode='$row_mlo_info->mlocode' 
				AND cont_iso_type NOT IN('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') 
				AND type_of_igm<>'TS' AND off_dock_id<>'2592' AND cont_status IN ('FCL') AND cont_size =40 AND igm_details.final_submit=1";
				
				$rslt_fcl_40=mysql_query($sql_fcl_40);
				
				$fcl_40=mysql_fetch_object($rslt_fcl_40);
				?>
				<td align="center"><?php echo $fcl_40->total; ?></td>
				<?php 
				$sql_lcl_20="SELECT COUNT(DISTINCT cont_number) AS total 
				FROM igm_detail_container 
				INNER JOIN igm_details ON igm_details.id=igm_detail_container.igm_detail_id 
				WHERE Import_Rotation_No='$rotation' AND Submitee_Org_Id='$row_mlo_info->submitee_org_id' AND mlocode='$row_mlo_info->mlocode' 
				AND cont_iso_type NOT IN('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') 
				AND type_of_igm<>'TS' AND off_dock_id<>'2592' AND cont_status IN ('LCL') AND cont_size =20 AND igm_details.final_submit=1";
				
				$rslt_lcl_20=mysql_query($sql_lcl_20);
				
				$lcl_20=mysql_fetch_object($rslt_lcl_20);
				?>
				<td align="center"><?php echo $lcl_20->total; ?></td>
				<?php 
				$sql_lcl_40="SELECT COUNT(DISTINCT cont_number) AS total 
				FROM igm_detail_container 
				INNER JOIN igm_details ON igm_details.id=igm_detail_container.igm_detail_id 
				WHERE Import_Rotation_No='$rotation' AND Submitee_Org_Id='$row_mlo_info->submitee_org_id' AND mlocode='$row_mlo_info->mlocode' 
				AND cont_iso_type NOT IN('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') 
				AND type_of_igm<>'TS' AND off_dock_id<>'2592' AND cont_status IN ('LCL') AND cont_size =40 AND igm_details.final_submit=1";
				
				$rslt_lcl_40=mysql_query($sql_lcl_40);
				
				$lcl_40=mysql_fetch_object($rslt_lcl_40);
				?>
				<td align="center"><?php echo $lcl_40->total; ?></td>
				<?php
				$sql_icd_20="SELECT COUNT(DISTINCT cont_number) AS total 
				FROM igm_detail_container 
				INNER JOIN igm_details ON igm_details.id=igm_detail_container.igm_detail_id 
				WHERE Import_Rotation_No='$rotation' AND Submitee_Org_Id='$row_mlo_info->submitee_org_id' AND mlocode='$row_mlo_info->mlocode' 
				AND cont_iso_type NOT IN('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') 
				AND off_dock_id='2592' AND cont_size =20 AND igm_details.final_submit=1";
				
				$rslt_icd_20=mysql_query($sql_icd_20);
				
				$icd_20=mysql_fetch_object($rslt_icd_20);
				?>
				<td align="center"><?php echo $icd_20->total; ?></td>
				<?php
				$sql_icd_40="SELECT COUNT(DISTINCT cont_number) AS total 
				FROM igm_detail_container INNER JOIN igm_details ON igm_details.id=igm_detail_container.igm_detail_id 
				WHERE Import_Rotation_No='$rotation' AND Submitee_Org_Id='$row_mlo_info->submitee_org_id' AND mlocode='$row_mlo_info->mlocode' 
				AND cont_iso_type NOT IN('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3')
				AND off_dock_id='2592' AND  cont_size =40 AND igm_details.final_submit=1";
				
				$rslt_icd_40=mysql_query($sql_icd_40);
				
				$icd_40=mysql_fetch_object($rslt_icd_40);
				?>
				<td align="center"><?php echo $icd_40->total; ?></td>
				<?php
				$sql_mty_20="SELECT COUNT(DISTINCT cont_number) AS total 
				FROM igm_detail_container 
				INNER JOIN igm_details ON igm_details.id=igm_detail_container.igm_detail_id 
				WHERE Import_Rotation_No='$rotation' AND Submitee_Org_Id='$row_mlo_info->submitee_org_id' AND mlocode='$row_mlo_info->mlocode' 
				AND cont_iso_type NOT IN('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3')
				AND type_of_igm<>'TS' AND off_dock_id<>'2592' AND  (cont_status='EMT' OR cont_status='Empty' OR cont_status='MT' OR cont_status='ETY') 
				AND cont_size =20 AND (cont_imo = '' AND cont_un = '' AND igm_details.final_submit=1)";
				
				$rslt_mty_20=mysql_query($sql_mty_20);
				
				$mty_20=mysql_fetch_object($rslt_mty_20);
				?>
				<td align="center"><?php echo $mty_20->total; ?></td>
				<?php
				$sql_mty_40="SELECT COUNT(DISTINCT cont_number) AS total 
				FROM igm_detail_container 
				INNER JOIN igm_details ON igm_details.id=igm_detail_container.igm_detail_id 
				WHERE Import_Rotation_No='$rotation' AND Submitee_Org_Id='$row_mlo_info->submitee_org_id' AND mlocode='$row_mlo_info->mlocode' 
				AND cont_iso_type NOT IN('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') 
				AND type_of_igm<>'TS' AND off_dock_id<>'2592' AND (cont_status='EMT' OR cont_status='Empty' OR cont_status='MT' OR cont_status='ETY') 
				AND cont_size =40 AND (cont_imo = '' AND cont_un = '' AND igm_details.final_submit=1)";
				
				$rslt_mty_40=mysql_query($sql_mty_40);
				
				$mty_40=mysql_fetch_object($rslt_mty_40);
				?>
				<td align="center"><?php echo $mty_40->total; ?></td>
				<?php
				$tot_box=$fcl_20->total + $fcl_40->total + $lcl_20->total + $lcl_40->total + $icd_20->total + $icd_40->total + $mty_20->total + $mty_40->total;
				$tot_teus=($fcl_20->total + $lcl_20->total + $icd_20->total + $mty_20->total)+(($fcl_40->total + $lcl_40->total + $icd_40->total + $mty_40->total)*2);
				?>
				<td align="center"><?php echo $tot_box; ?></td>
				<td align="center"><?php echo $tot_teus; ?></td>
			</tr>
			<?php
				$i++;
				
				$grand_tot_fcl_20=$grand_tot_fcl_20+$fcl_20->total;
				$grand_tot_fcl_40=$grand_tot_fcl_40+$fcl_40->total;
				
				$grand_tot_lcl_20=$grand_tot_lcl_20+$lcl_20->total;
				$grand_tot_lcl_40=$grand_tot_lcl_40+$lcl_40->total;
				
				$grand_tot_icd_20=$grand_tot_icd_20+$icd_20->total;
				$grand_tot_icd_40=$grand_tot_icd_40+$icd_40->total;
				
				$grand_tot_mty_20=$grand_tot_mty_20+$mty_20->total;
				$grand_tot_mty_40=$grand_tot_mty_40+$mty_40->total;
				
				$grand_tot_box=$grand_tot_box+$tot_box;
				$grand_tot_teus=$grand_tot_teus+$tot_teus;
			}
			?>
			<tr>
				<td align="center" colspan="2"><b>Grand Total</b></td>
				<td align="center"><?php echo $grand_tot_fcl_20; ?></td>
				<td align="center"><?php echo $grand_tot_fcl_40; ?></td>
				<td align="center"><?php echo $grand_tot_lcl_20; ?></td>
				<td align="center"><?php echo $grand_tot_lcl_40; ?></td>
				<td align="center"><?php echo $grand_tot_icd_20; ?></td>
				<td align="center"><?php echo $grand_tot_icd_40; ?></td>
				<td align="center"><?php echo $grand_tot_mty_20; ?></td>
				<td align="center"><?php echo $grand_tot_mty_40; ?></td>
				<td align="center"><?php echo $grand_tot_box; ?></td>
				<td align="center"><?php echo $grand_tot_teus; ?></td>
			</tr>
		</table>
		<br>
		<table align="center" width="90%">
			<tr>
				<td class="defaultFont">
					<font size="6">
					১/ অত্র জাহাজের সকল OPEN TOP, FLAT RACK কন্টেইনার CCT ইয়ার্ডের নির্দিষ্ট স্লটে সংরক্ষণ করে মেমোর মাধ্যমে ASI/SI কে হ্যান্ডওভার করতে হবে। বাকী সকল বুলেটসীলযুক্ত কন্টেইনার সংশ্লিষ্ট ইয়ার্ডে সংরক্ষণ করে R/L এর উপর নিরাপত্তা রক্ষী/কর্মচারীর রিসিভিং স্বাক্ষর নিতে হবে।<br>
					২/ ডিসচার্জিং লিস্টে প্রাইভেট ডিপো নির্দেশিত ৩৭ আইটেম কন্টেইনারগুলি CTMS পদ্ধতি অনুসরণ করে সংশ্লিষ্ট ডিপোতে প্রেরণ করতে হবে।
					<br>
					৩/ Highly Perishable, Onion, Garlic, Ginger & Dates জাতীয় পণ্য DRY কন্টেইনারে পরিবাহিত হলে সেগুলো অবতরণের জন্য অত্র দপ্তর থেকে আলাদাভাবে অনুমতি নিতে হবে।
					<br>
					<b> ৪/ MLO _______________ ICT Pangaon Container NCT ইয়ার্ডে পানগাঁও স্লটে সংরক্ষণ করতে হবে। </b>
					</font>
				</td>
			</tr>
		</table>
	</div>
	
	
<?php 

mysql_close($con_cchaportdb);
if($_POST['options']=='html'){?>		
	</BODY>
</HTML>
<?php }?>

