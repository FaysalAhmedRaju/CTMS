<HTML>
	<HEAD>
		<TITLE>Summary Of Import Container(MLO,Size,Height) Wise</TITLE>
		
	    <style type="text/css">
<!--
.style1 {font-size: 12px}
-->
        </style>
</HEAD>
<BODY>

	<?php
	
    $sum=0;
	$grand=0;
	
	$sum20=0;
	$sum40=0;
	$sum45=0;
	
    $grand20=0;
	$grand40=0;
	$grand45=0;
	
        include("mydbPConnection.php");
		include("dbConection.php");
		//mysql_connect("192.168.1.1", "user7", "user7test");
		//mysql_select_db("ccha");
		
	$rotation=$_POST['ddl_imp_rot_no']; 
	$result_igm_master=mysql_query("SELECT
												Import_Rotation_No,
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
												Vessel_Type
											FROM
												igm_masters 
												LEFT JOIN organization_profiles ON 
												organization_profiles.id=igm_masters.Submitee_Org_Id
												LEFT JOIN vessels ON vessels.id=igm_masters.Vessel_Id
											WHERE igm_masters.Import_Rotation_No='$rotation'",$con_cchaportdb
														);
			$row_igm_master=mysql_fetch_object($result_igm_master);		
	?>
			
		<TABLE width="100%">
			<TR><TD width="100%">
				<table class='table-header' border=0 width="100%">
					<tr><td colspan="2" align="center"><h1>Summary Of Import Container(MLO,Size,Height) Wise</h1></td></tr>
					<tr>
						
						
						<tr>
					<td align="center">Vessel name:<?php print($row_igm_master->Vessel_Name);?></td>
			
					
					
					
					<td align="center">Rotation No:&nbsp;&nbsp;<?php print($row_igm_master->Import_Rotation_No);?></td>
				
				<?php
				$sql_berth=mysql_query("select * from vessels_berth_detail where 
				Import_Rotation_No='$row_igm_master->Import_Rotation_No'",$con_cchaportdb);
				
				$row_time=mysql_fetch_object($sql_berth);
				
				?>
				
				
					<td align="left">ATA:<?php print($row_time->Actual_Berth);?><td align="left">ATD:<?php print($row_time->Actual_Berth_time);?></td>
					</tr>
					
						
				</table>
			</TD></TR>
			<TR><TD>
					<table width="100%" border=1  cellspacing="0" cellpadding="0">
					<tr>
						<th align="center"><span class="style1" >Shipping Agent</span></th>
						<th align="center"><span class="style1" >Agent CODE</span></th>
						<th align="center"><span class="style1" >MLO CODE</span></th>
							
						
														
						<th colspan='5' align="center"><span class="style1" >FCL</span></th>
						<th colspan='5' align="center"><span class="style1" >LCL</span></th>
							
						<th colspan='5' align="center"><span class="style1" >EMPTY</span></th>
						
							
						<th colspan='5' align="center"><span class="style1" >TRANS(FCL)</span></th>
					    <th colspan='5' align="center"><span class="style1" >TRANS(LCL)</span></th>
					    <th colspan='5' align="center"><span class="style1" >TRANS(EMPTY)</span></th>
					
					    <th colspan='3' align="center"><span class="style1" >TOTAL</span></th>
												
					    <th colspan='2' align="center"><span class="style1" >TOTAL</span></th>
								
																			
					</tr>
					
						<tr>
						 <tr>
							  <td  align="center"><?php  print("&nbsp;");?></td>
							 
							  <td  align="center"><?php print("&nbsp;");?></td>
 							  <td  align="center"><?php print("&nbsp;");?></td>
							 
							  <td colspan='2' align="center"><?php  print("20");?></td>
							  <td colspan='2' align="center"><?php print("40");?></td>
							  <td  align="center"><?php print("45");?></td>
							 
							 
							 
							  <td colspan='2' align="center"><?php  print("20");?></td>
							  <td colspan='2' align="center"><?php print("40");?></td>
							  <td  align="center"><?php print("45");?></td>
								 
							  <td colspan='2' align="center"><?php  print("20");?></td>
							  <td colspan='2' align="center"><?php print("40");?></td>
							  <td  align="center"><?php print("45");?></td>
								
								
							  <td colspan='2' align="center"><?php  print("20");?></td>
							  <td colspan='2' align="center"><?php print("40");?></td>
							  <td  align="center"><?php print("45");?></td>
								
								
							  <td colspan='2' align="center"><?php  print("20");?></td>
							  <td colspan='2' align="center"><?php print("40");?></td>
							  <td  align="center"><?php print("45");?></td>
								
								
							  <td colspan='2' align="center"><?php  print("20");?></td>
							  <td colspan='2' align="center"><?php print("40");?></td>
							  <td  align="center"><?php print("45");?></td>
							
							  <td  align="center"><?php  print("20");?></td>
							  <td  align="center"><?php print("40");?></td>
							  <td  align="center"><?php print("45");?></td>
								
								
				
								
							
					 </tr>
					 
					 
					        <tr>
							  <td  align="center"><?php  print("&nbsp;");?></td>
							 
							  <td  align="center"><?php print("&nbsp;");?></td>
 							  <td  align="center"><?php print("&nbsp;");?></td>
							
							  <td  align="center"><?php  print("8.6");?></td>
							  <td  align="center"><?php print("9.6");?></td>
							  <td  align="center"><?php print("8.6");?></td>
								 
								 
							  <td  align="center"><?php  print("9.6");?></td>
							  <td  align="center"><?php print("9.6");?></td>
							    
							  <td  align="center"><?php print("8.6");?></td>
								 
							  <td  align="center"><?php  print("9.6");?></td>
							  <td  align="center"><?php print("8.6");?></td>
							  <td  align="center"><?php print("9.6");?></td>
								 
								 
								 
							  <td  align="center"><?php  print("9.6");?></td>
							  
							  
							   <td  align="center"><?php print("8.6");?></td>
							     <td  align="center"><?php print("9.6");?></td>
								 
							  <td  align="center"><?php  print("8.6");?></td>
							   <td  align="center"><?php print("9.6");?></td>
							    
								
								
							  <td  align="center"><?php  print("9.6");?></td>
							  
							  
							   <td  align="center"><?php print("8.6");?></td>
							     <td  align="center"><?php print("9.6");?></td>
								 
							  <td  align="center"><?php  print("8.6");?></td>
							   <td  align="center"><?php print("9.6");?></td>
							    
								
								  <td  align="center"><?php  print("9.6");?></td>
							
							  
							   <td  align="center"><?php print("8.6");?></td>
							     <td  align="center"><?php print("9.6");?></td>
								 
							  <td  align="center"><?php  print("8.6");?></td>
							   <td  align="center"><?php print("9.6");?></td>
							    
								
								  <td  align="center"><?php  print("9.6");?></td>
							  
								 
							   <td  align="center"><?php print("8.6");?></td>
							     <td  align="center"><?php print("9.6");?></td>
								 
							  <td  align="center"><?php  print("8.6");?></td>
							   <td  align="center"><?php print("9.6");?></td>
							    
								
								  <td  align="center"><?php  print("9.6");?></td>
							
								 
								 
								  <td  align="center"><?php  print("&nbsp;");?>
							   <td  align="center"><?php print("&nbsp;");?></td>
							    
								
								  <td  align="center"><?php  print("&nbsp;");?></td>
							
							  
							
					 </tr>
							
					<?php
					
					
			$str="select distinct submitee_org_id,organization_profiles.Organization_Name as 
			Organization_Name,organization_profiles.Agent_Code,mlocode as mlocode from igm_details 
			inner join organization_profiles on igm_details.Submitee_Org_Id=organization_profiles.id 
			where Import_Rotation_No='$rotation' order by mlocode,Organization_Name";
							
							$result=mysql_query($str,$con_cchaportdb);
							while ($row=mysql_fetch_object($result))
							{

                                                   $sum=$sum+$grand;
												   $sum20=$sum20+$grand20;
												   $sum40=$sum40+$grand40;
												   $sum45=$sum45+$grand45;
												   
					?>
					  <tr>
<td  align="left"><?php if($row->Organization_Name) print($row->Organization_Name); else print("&nbsp;");?></td>
	<td  align="left">
							<?php
							
							
							//echo"select mlo_agent_code_ctms from mlo_detail where mlocode='$row->mlocode' and org_id='$row->submitee_org_id'";
							$sql_agent_code= mysql_query("select y.id  as mlo_agent_code_ctms from sparcsn4.ref_bizunit_scoped r 
LEFT JOIN sparcsn4.ref_agent_representation x on r.gkey=x.bzu_gkey 
LEFT JOIN sparcsn4.ref_bizunit_scoped y ON x.agent_gkey=y.gkey 
where r.id='$row->mlocode' and y.id is not null",$con_sparcsn4);
							//print("select mlo_agent_code_ctms from mlo_detail where mlocode='$row->mlocode' and org_id='$row->submitee_org_id'");		
							$row_agent_code=mysql_fetch_object($sql_agent_code);
							
							if($row_agent_code->mlo_agent_code_ctms) print($row_agent_code->mlo_agent_code_ctms); else print("&nbsp;");
							?></td>

							  <td  align="left"><?php if($row->mlocode) print($row->mlocode); else print("&nbsp;");?></td>
							
														





<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/


							
//FCL-20"   8.6    
		$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
		igm_details on igm_details.id=igm_detail_container.igm_detail_id 
		where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
		and mlocode='$row->mlocode' and 
		type_of_igm<>'TS' 
         and cont_status in ('FCL','FCL/PART') and 
		cont_size <=20 and (cont_height='8.6' or cont_height='8') and  igm_details.final_submit=1";	
							//print($str1."<br>");
							$result1=mysql_query($str1,$con_cchaportdb);
							$row1=mysql_fetch_object($result1);
			//imdg			
	/*$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
	igm_details on igm_details.id=igm_detail_container.igm_detail_id 
	where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and 
	mlocode='$row->mlocode' and cont_type not in ('REFER','REEFER')and type_of_igm<>'TS' 
	and off_dock_id<>'2592'  and cont_size =20 and (cont_imo <> '' and cont_un <> '' 
	and  cont_height='8.6'and igm_details.final_submit=1)";	
							
	$result1_dmg=mysql_query($str1);
	$row1_dmg=mysql_fetch_object($result1_dmg);*/
// 9.6 laden	
$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
		igm_details on igm_details.id=igm_detail_container.igm_detail_id 
		where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
		and mlocode='$row->mlocode' and 
		type_of_igm<>'TS' 
         and cont_status in ('FCL','FCL/PART') and 
		cont_size <=20 and cont_height='9.6' and  igm_details.final_submit=1";	
							//print($str1."<br>");
		$result1l=mysql_query($str1,$con_cchaportdb);
		$row1l=mysql_fetch_object($result1l);
			//imdg			
	/*$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
	igm_details on igm_details.id=igm_detail_container.igm_detail_id 
	where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and 
	mlocode='$row->mlocode' and cont_type not in ('REFER','REEFER')and type_of_igm<>'TS' 
	and off_dock_id<>'2592'  and cont_size =20 and (cont_imo <> '' and cont_un <> '' 
	 and cont_height='9.6'and igm_details.final_submit=1)";	
							
	$result1_dmgl=mysql_query($str1);
	$row1_dmgl=mysql_fetch_object($result1_dmgl);*/

							?>
<td  align="left"><?php if($row1->total) print($row1->total); 
else print("0"); $total1=$row1->total; $totalg1=$totalg1+$total1; //print($totalg1);?></td>

<td  align="left"><?php if($row1l->total) print($row1l->total); 
else print("0"); $total1l=$row1l->total; $totalg1l=$totalg1l+$total1l; //print($totalg1l);?></td>


							<?php
//FCL-40"
							$str1="select count(distinct cont_number) as total from igm_detail_container inner join igm_details 
							on igm_details.id=igm_detail_container.igm_detail_id 
							       where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
								   and mlocode='$row->mlocode' and type_of_igm<>'TS' 
                                    and 
								   cont_status in ('FCL','FCL/PART') 
		and cont_size =40 and (cont_height='8.6' or cont_height='8') and igm_details.final_submit=1";
//print("<br>".$str1);	
							$result1=mysql_query($str1,$con_cchaportdb);
							$row1=mysql_fetch_object($result1);
		//imdg							
							/*$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
							igm_details on igm_details.id=igm_detail_container.igm_detail_id 
							where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and 
							mlocode='$row->mlocode' and type_of_igm<>'TS' and off_dock_id<>'2592' 
			and  cont_size =40 and cont_height='8.6' and (cont_imo <> '' or cont_un <> '') and igm_details.final_submit=1";	
							$result1_dmg=mysql_query($str1);
							$row1_dmg=mysql_fetch_object($result1_dmg);*/
							
							
////for 9.6//////////////	13aug						
			/*$str1="select count(distinct cont_number) as total from igm_detail_container 
			inner join igm_details 
			on igm_details.id=igm_detail_container.igm_detail_id 
			where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
			and mlocode='$row->mlocode' and 
			type_of_igm<>'TS' 
             and cont_status in ('FCL','FCL/PART')
			and cont_size =40 and cont_height='9.6' and igm_details.final_submit=1";*/
			
			$str1="select sum(sub) as total from (
select count(distinct cont_number) as sub
from igm_detail_container 
inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id 
left join igm_supplimentary_detail on igm_supplimentary_detail.igm_detail_id=igm_details.id
where igm_details.Import_Rotation_No='$rotation' and igm_details.Submitee_Org_Id=$row->submitee_org_id  and mlocode='$row->mlocode' and igm_details.type_of_igm<>'TS' 
and cont_status in ('FCL','FCL/PART')and cont_size =40 and cont_height='9.6' and igm_details.final_submit=1 and igm_supplimentary_detail.id is null
union
select  count(distinct igm_sup_detail_container.cont_number) as sub
from igm_details 
inner join igm_supplimentary_detail on igm_supplimentary_detail.igm_detail_id=igm_details.id
inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
where igm_details.Import_Rotation_No='$rotation' and igm_details.Submitee_Org_Id=$row->submitee_org_id  and mlocode='$row->mlocode' and igm_details.type_of_igm<>'TS'
and igm_sup_detail_container.cont_status in ('FCL','FCL/PART')and igm_sup_detail_container.cont_size =40 and igm_sup_detail_container.cont_height='9.6' and igm_details.final_submit=1 
) as tmp";
//print("<br>".$str1);	
							$result1f=mysql_query($str1,$con_cchaportdb);
							$row1f=mysql_fetch_object($result1f);
		//imdg							
							/*$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
							igm_details on igm_details.id=igm_detail_container.igm_detail_id 
							where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and 
							mlocode='$row->mlocode' and type_of_igm<>'TS' and off_dock_id<>'2592' 
			and  cont_size =40 and cont_height='9.6' and (cont_imo <> '' or cont_un <> '') and igm_details.final_submit=1";	
							$result1_dmgf=mysql_query($str1);
							$row1_dmgf=mysql_fetch_object($result1_dmgf);*/
																					
							?>
<td  align="left"><?php if($row1->total) print($row1->total); 
else print("0"); $total2=$row1->total; $totalg2=$totalg2+$total2;?></td>

<td  align="left"><?php if($row1f->total) print($row1f->total); 
else print("0"); $total2f=$row1f->total; $totalg2f=$totalg2f+$total2f;?></td>
							
							<?php
//FCL-45"   zico         //siz2:45
	$str1="select count(distinct cont_number) as total from igm_detail_container 
	inner join igm_details 
	on igm_details.id=igm_detail_container.igm_detail_id 
    where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
	and mlocode='$row->mlocode' and type_of_igm<>'TS' 
    and cont_status in ('FCL','FCL/PART') 
	and cont_size =45 and igm_details.final_submit=1";
//print("<br>".$str1);	
							//print($str1."<br>");
							$result11=mysql_query($str1,$con_cchaportdb);
							$row11=mysql_fetch_object($result11);
		//imdg							
	/*$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
	igm_details on igm_details.id=igm_detail_container.igm_detail_id 
	where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and 
	mlocode='$row->mlocode' and type_of_igm<>'TS' and off_dock_id<>'2592' 
	and  cont_size =45 and  cont_height='9.6' 
	and (cont_imo <> '' or cont_un <> '') and igm_details.final_submit=1";*/	
							
							//print($str1);
							$result1_dmg11=mysql_query($str1);
							$row1_dmg11=mysql_fetch_object($result1_dmg11);																					
							?>
<td  align="left"><?php if($row11->total) print($row11->total); 
else print("0"); $tota31=$row11->total; $totalg31=$totalg31+$tota31;?></td>

<?php
//LCL-20"   8.6        FCL  LCL  FCL/PART  EMT   EMPTY   MTY  MT

		$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
		igm_details on igm_details.id=igm_detail_container.igm_detail_id 
		where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
		and mlocode='$row->mlocode'  and 
		type_of_igm<>'TS' 
         and 
		cont_status='LCL' and 
		cont_size <=20 and (cont_height='8.6' or cont_height='8') and  igm_details.final_submit=1";	
							//print($str1."<br>");
		$result1f1=mysql_query($str1,$con_cchaportdb);
		$row1f1=mysql_fetch_object($result1f1);
		
			//imdg			
	/*$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
	igm_details on igm_details.id=igm_detail_container.igm_detail_id 
	where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and 
	mlocode='$row->mlocode'  and  type_of_igm<>'TS' 
	and off_dock_id<>'2592'  and cont_size =20 and  
	(cont_height='8.6'and igm_details.final_submit=1)";	
		
     
	$result1_dmgf1=mysql_query($str1);
	$row1_dmgf1=mysql_fetch_object($result1_dmgf1);*/
	
	

// 9.6 laden	
$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
		igm_details on igm_details.id=igm_detail_container.igm_detail_id 
		where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
		and mlocode='$row->mlocode' and 
		type_of_igm<>'TS' 
         and cont_status='LCL' and 
		cont_size <=20 and cont_height='9.6' and  igm_details.final_submit=1";	
							//print($str1."<br>");
							$result1lf1=mysql_query($str1,$con_cchaportdb);
							$row1lf1=mysql_fetch_object($result1lf1);
			//imdg			
	/*$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
	igm_details on igm_details.id=igm_detail_container.igm_detail_id 
	where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and 
	mlocode='$row->mlocode' and type_of_igm<>'TS' 
	and off_dock_id<>'2592'  and cont_size =20 and  
	(cont_height='9.6'and igm_details.final_submit=1)";	
							
	$result1_dmglf1=mysql_query($str1);
	$row1_dmglf1=mysql_fetch_object($result1_dmglf1);*/
//LCL 20//8.6  9.6							?>


<td  align="left"><?php if($row1f1->total) print($row1f1->total); 
else print("0"); $totalf20f=$row1f1->total; 
$totalFCL20A=$totalFCL20A+$totalf20f; //print($totalFCL20A."A");?></td>

<td  align="left"><?php if($row1lf1->total) print($row1lf1->total); 
else print("0"); $totalf20=$row1lf1->total; 
$totalFCL20B=$totalFCL20B+$totalf20;//print($totalFCL20B);?></td>



							<?php
//LCL-40"   // 8.6  9.6
$str1="select count(distinct cont_number) as total from igm_detail_container inner join igm_details 
on igm_details.id=igm_detail_container.igm_detail_id 
where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
and mlocode='$row->mlocode' and type_of_igm<>'TS' 
 and cont_status='LCL' 
and cont_size =40 and (cont_height='8.6' or cont_height='8') and igm_details.final_submit=1";
//print("<br>".$str1);	
							$result1f40=mysql_query($str1,$con_cchaportdb);
							$row1f40=mysql_fetch_object($result1f40);
		//imdg							
/*$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
igm_details on igm_details.id=igm_detail_container.igm_detail_id 
where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and 
mlocode='$row->mlocode' and type_of_igm<>'TS' and off_dock_id<>'2592' 
and  cont_size =40 and cont_height='8.6' and 
(cont_imo <> '' or cont_un <> '') and igm_details.final_submit=1";	

$result1_dmgf40=mysql_query($str1);
$row1_dmgf40=mysql_fetch_object($result1_dmgf40);*/
							
							
////for 9.6//////////////		

/*					
$str1="select count(distinct cont_number) as total from igm_detail_container inner join igm_details 
on igm_details.id=igm_detail_container.igm_detail_id 
where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
and mlocode='$row->mlocode' and type_of_igm<>'TS' 
 and cont_status='LCL' 
and cont_size =40 and cont_height='9.6' and igm_details.final_submit=1";*/
$str1="
select count(distinct cont_number) as total from  igm_details 
inner join igm_supplimentary_detail on igm_supplimentary_detail.igm_detail_id=igm_details.id inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
where igm_details.Import_Rotation_No='$rotation' and igm_details.Submitee_Org_Id=$row->submitee_org_id  and mlocode='$row->mlocode' and igm_details.type_of_igm<>'TS'
and igm_sup_detail_container.cont_status='LCL' and igm_sup_detail_container.cont_size =40 and igm_sup_detail_container.cont_height='9.6' and igm_details.final_submit=1 
";
/*
$str1="select sum(sub) as total from (
select count(distinct cont_number) as sub from igm_detail_container 
inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id 
left join igm_supplimentary_detail on igm_supplimentary_detail.igm_detail_id=igm_details.id
where igm_details.Import_Rotation_No='$rotation' and igm_details.Submitee_Org_Id=$row->submitee_org_id  and mlocode='$row->mlocode' and igm_details.type_of_igm<>'TS'
 and cont_status='LCL' 
and cont_size =40 and cont_height='9.6' and igm_details.final_submit=1 and igm_supplimentary_detail.id is null
union
select count(distinct cont_number) as sub from  igm_details 
inner join igm_supplimentary_detail on igm_supplimentary_detail.igm_detail_id=igm_details.id inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
where igm_details.Import_Rotation_No='$rotation' and igm_details.Submitee_Org_Id=$row->submitee_org_id  and mlocode='$row->mlocode' and igm_details.type_of_igm<>'TS'
and igm_sup_detail_container.cont_status='LCL' and igm_sup_detail_container.cont_size =40 and igm_sup_detail_container.cont_height='9.6' and igm_details.final_submit=1 
) as tmp";*/
//print("<br>".$str1);	
							$result1ff40=mysql_query($str1,$con_cchaportdb);
							$row1ff40=mysql_fetch_object($result1ff40);
		//imdg							
							/*$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
							igm_details on igm_details.id=igm_detail_container.igm_detail_id 
							where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and 
							mlocode='$row->mlocode' and type_of_igm<>'TS' and off_dock_id<>'2592' 
							and  cont_size =40 and cont_height='9.6' and (cont_imo <> '' or cont_un <> '') and igm_details.final_submit=1";	
							$result1_dmgff40=mysql_query($str1);
							$row1_dmgff40=mysql_fetch_object($result1_dmgff40);*/
																					
							?>
<td  align="left"><?php if($row1f40->total) print($row1f40->total); 
else print("0"); $total240=$row1f40->total; 
$totalg40A=$totalg40A+$total240; //print("A");?></td>

<td  align="left"><?php if($row1ff40->total) print($row1ff40->total); 
else print("0"); $total2f40=$row1ff40->total;
 $totalg2f40B=$totalg2f40B+$total2f40; //print("B"); ?></td>
							
							<?php
//LCL-45"   zico         //siz2:45
	$str1="select count(distinct cont_number) as total from igm_detail_container 
	inner join igm_details 
	on igm_details.id=igm_detail_container.igm_detail_id 
    where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
	and mlocode='$row->mlocode' and  type_of_igm<>'TS' 
    and cont_status='LCL'
	and cont_size =45 and igm_details.final_submit=1";
//print("<br>".$str1);	
							//print($str1."<br>");
							$result11f45=mysql_query($str1,$con_cchaportdb);
							$row11f45=mysql_fetch_object($result11f45);
		//imdg							
	/*$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
	igm_details on igm_details.id=igm_detail_container.igm_detail_id 
	where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and 
	mlocode='$row->mlocode' and type_of_igm<>'TS' and off_dock_id<>'2592' 
	and  cont_size =45 and  cont_height='9.6' 
	and (cont_imo <> '' or cont_un <> '') and igm_details.final_submit=1";*/	
							
							//print($str1);
							//$result1_dmg11f45=mysql_query($str1);
							//$row1_dmg11f45=mysql_fetch_object($result1_dmg11f45);																					
							?>

<td  align="left"><?php if($row11f45->total) print($row11f45->total); 
else print("0"); $tota45=$row11f45->total; $totalg45f=$totalg45f+$tota45;?></td>							
							
							<?php
//Empty-20"
$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
igm_details on igm_details.id=igm_detail_container.igm_detail_id 
 where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
and mlocode='$row->mlocode' and type_of_igm<>'TS' 
 and (cont_status='EMT' or cont_status='Empty' 
or cont_status='MT'or cont_status='MTY' or cont_status='ETY') and  cont_height='8.6' 
and cont_size =20 and 
(cont_imo = '' and cont_un = '' and igm_details.final_submit=1)";
							$result1=mysql_query($str1,$con_cchaportdb);
							$row1=mysql_fetch_object($result1);
							
$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
igm_details on igm_details.id=igm_detail_container.igm_detail_id 
							       where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
								   and mlocode='$row->mlocode' and type_of_igm<>'TS' 
                                    and   (cont_status='EMT' or cont_status='Empty' 
								   or cont_status='MT' or cont_status='ETY') and cont_size =20 and cont_height='9.6'
								   and (cont_imo = '' and cont_un = '' 
								   and igm_details.final_submit=1)";	
							$result1e=mysql_query($str1,$con_cchaportdb);
							$row1e=mysql_fetch_object($result1e);						
							
							?>
<td  align="left"><?php if($row1->total) print($row1->total); else print("0"); 
$total3=$row1->total; $totalg3=$totalg3+$total3;?></td>		 
	
<td  align="left"><?php if($row1e->total) print($row1e->total); else print("0"); 
$total3e=$row1e->total; $totalg3e=$totalg3e+$total3e;?></td>		 

	<?php
//Empty-40"
$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
igm_details on igm_details.id=igm_detail_container.igm_detail_id 
where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
and mlocode='$row->mlocode' and type_of_igm<>'TS' 
 and  (cont_status='EMT' or cont_status='Empty' or 
cont_status='MT' or cont_status='MTY' or cont_status='ETY') and cont_size =40 and cont_height='8.6' and (cont_imo = '' and cont_un = '' and 
igm_details.final_submit=1)";	
							$result1=mysql_query($str1,$con_cchaportdb);
							$row1=mysql_fetch_object($result1);
							
//print($str1);
							
$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
igm_details on igm_details.id=igm_detail_container.igm_detail_id 
where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
and mlocode='$row->mlocode' and type_of_igm<>'TS' 
 and  (cont_status='EMT' or cont_status='Empty' or 
cont_status='MT' or cont_status='ETY') and cont_size =40 and cont_height='9.6' and (cont_imo = '' and cont_un = '' and 
igm_details.final_submit=1)";	
							$result1e40=mysql_query($str1,$con_cchaportdb);
							$row1e40=mysql_fetch_object($result1e40);							
							
							?>
<td  align="left"><?php if($row1->total) print($row1->total); else print("0"); 
$total4=$row1->total; $totalg4=$totalg4+$total4;?></td>		 


<td  align="left"><?php if($row1e40->total) print($row1e40->total); else print("0"); 
$total40=$row1e40->total; $total4e40=$total4e40+$total40;?></td>		 
						 
<?php
$str1="select count(distinct cont_number) as total from igm_detail_container 
		inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id 
where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and 
mlocode='$row->mlocode'  
    and cont_size =45 and cont_height='9.6' and igm_details.final_submit=1 and   
	(cont_status='EMT' or cont_status='Empty' or cont_status='MT'
	or cont_status='MTY' or cont_status='ETY')";	

//print($str1."<br>");							
							$result1=mysql_query($str1,$con_cchaportdb);
							$row1e45=mysql_fetch_object($result1);

?>							
<td  align="left"><?php if($row1e45->total) print($row1e45->total); else print("0"); 
$total45=$row1e45->total; $total4e45=$total4e45+$total45;?></td>		 
						
						<?php
//TS 20"


$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
igm_details on igm_details.id=igm_detail_container.igm_detail_id 
where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
and mlocode='$row->mlocode' and type_of_igm='TS' and cont_status='FCL' 
and (cont_height='8.6' or cont_height='8')
and cont_size <=20 and igm_details.final_submit=1";	
$result1=mysql_query($str1,$con_cchaportdb);
$row1t2=mysql_fetch_object($result1);

$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
igm_details on igm_details.id=igm_detail_container.igm_detail_id 
where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
and mlocode='$row->mlocode' and type_of_igm='TS' and cont_status='FCL' 
and cont_height='9.6'
and cont_size <=20 and igm_details.final_submit=1";	
$result1=mysql_query($str1,$con_cchaportdb);
$row1t22=mysql_fetch_object($result1);
							
							?>
<td  align="left"><?php if($row1t2->total) print($row1t2->total); 
else print("0"); $totalT20=$row1t2->total; $totalgT20=$totalgT20+$totalT20;?></td>		 
						
<td  align="left"><?php if($row1t22->total) print($row1t22->total); 
else print("0"); $totalT2B=$row1t22->total; $totalgT20B=$totalgT20B+$totalT2B;?></td>		 
						
						<?php
//TS 40"
$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
igm_details on igm_details.id=igm_detail_container.igm_detail_id 
where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
and mlocode='$row->mlocode' and type_of_igm='TS' and cont_status='FCL' 
and (cont_height='8.6' or cont_height='8')
and  cont_size =40 and 
igm_details.final_submit=1";	

$result1=mysql_query($str1,$con_cchaportdb);
$row1t4=mysql_fetch_object($result1);


$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
igm_details on igm_details.id=igm_detail_container.igm_detail_id 
where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
and mlocode='$row->mlocode' and type_of_igm='TS' and cont_status='FCL' 
and cont_height='9.6' and  cont_size =40 and 
igm_details.final_submit=1";	

$result1=mysql_query($str1,$con_cchaportdb);
$row1t44=mysql_fetch_object($result1);
							
							?>
<td  align="left"><?php if($row1t4->total) print($row1t4->total); 
else print("0"); $totalT40=$row1t4->total; $totalgT40=$totalgT40+$totalT40;?></td>		 


<td  align="left"><?php if($row1t44->total) print($row1t44->total); 
else print("0"); $totalT4B=$row1t44->total; $totalgT40B=$totalgT40B+$totalT4B;?></td>		 
							
							<?php
//TS 45"   zico
$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
igm_details on igm_details.id=igm_detail_container.igm_detail_id 
where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and 
mlocode='$row->mlocode' and type_of_igm='TS' and cont_status='FCL' 
and cont_height='9.6' 
and  cont_size =45 and igm_details.final_submit=1";	

$result1=mysql_query($str1,$con_cchaportdb);
$row1t45=mysql_fetch_object($result1);
							
							?>
<td  align="left"><?php if($row1t45->total) print($row1t45->total); 
else print("0"); $totalT45=$row1t45->total; $totalgT45=$totalgT45+$totalT45;?></td>		 


<?php
//TS  LCL 20"
$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
igm_details on igm_details.id=igm_detail_container.igm_detail_id 
where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
and mlocode='$row->mlocode' and type_of_igm='TS' and cont_status='LCL' 
and (cont_height='8.6' or cont_height='8')
  and cont_size <=20 and igm_details.final_submit=1";	
$result1=mysql_query($str1,$con_cchaportdb);
$row1t2l=mysql_fetch_object($result1);


$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
igm_details on igm_details.id=igm_detail_container.igm_detail_id 
where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
and mlocode='$row->mlocode' and type_of_igm='TS' and cont_status='LCL' 
and cont_height='9.6'
and cont_size <=20 and igm_details.final_submit=1";	
$result1=mysql_query($str1,$con_cchaportdb);
$row1t22l=mysql_fetch_object($result1);
							
							?>
<td  align="left"><?php if($row1t2l->total) print($row1t2l->total); 
else print("0"); $totalT20l=$row1t2l->total; $totalgT20l=$totalgT20l+$totalT20l;?></td>		 
						
<td  align="left"><?php if($row1t22l->total) print($row1t22l->total); 
else print("0"); $totalT2Bl=$row1t22l->total; $totalgT20Bl=$totalgT20Bl+$totalT2Bl;?></td>		 
						
						<?php
//TS 40"
$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
igm_details on igm_details.id=igm_detail_container.igm_detail_id 
where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
and mlocode='$row->mlocode' and type_of_igm='TS' and cont_status='LCL' 
and (cont_height='8.6' or cont_height='8') 
and  cont_size =40 and 
igm_details.final_submit=1";	

$result1=mysql_query($str1,$con_cchaportdb);
$row1t4l=mysql_fetch_object($result1);


$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
igm_details on igm_details.id=igm_detail_container.igm_detail_id 
where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
and mlocode='$row->mlocode' and type_of_igm='TS' and cont_status='LCL' 
and cont_height='9.6' 
and  cont_size =40 and 
igm_details.final_submit=1";	

$result1=mysql_query($str1,$con_cchaportdb);
$row1t44l=mysql_fetch_object($result1);
							
							?>
<td  align="left"><?php if($row1t4l->total) print($row1t4l->total); 
else print("0"); $totalT40l=$row1t4l->total; $totalgT40l=$totalgT40l+$totalT40l;?></td>		 


<td  align="left"><?php if($row1t44l->total) print($row1t44l->total); 
else print("0"); $totalT4Bl=$row1t44l->total; $totalgT40Bl=$totalgT40Bl+$totalT4Bl;?></td>		 
							
							<?php
//TS 45"   zico
$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
igm_details on igm_details.id=igm_detail_container.igm_detail_id 
where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and 
mlocode='$row->mlocode' and type_of_igm='TS' and cont_status='LCL' 
and cont_height='9.6' 
and  cont_size =45 and igm_details.final_submit=1";	

$result1=mysql_query($str1,$con_cchaportdb);
$row1t45l=mysql_fetch_object($result1l);
							
							?>
<td  align="left"><?php if($row1t45l->total) print($row1t45l->total); 
else print("0"); $totalT45l=$row1t45l->total; $totalgT45l=$totalgT45l+$totalT45l;?></td>		 





<?php
//TS  EMPTY 20"
$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
igm_details on igm_details.id=igm_detail_container.igm_detail_id 
where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
and mlocode='$row->mlocode' and type_of_igm='TS' 
and (cont_height='8.6' or cont_height='8')
and (cont_status='EMT' or cont_status='Empty' or cont_status='MT' or cont_status='MTY' or cont_status='ETY') 
 and cont_size <=20 and igm_details.final_submit=1";	
$result1=mysql_query($str1,$con_cchaportdb);
$row1t2e=mysql_fetch_object($result1);


$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
igm_details on igm_details.id=igm_detail_container.igm_detail_id 
where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
and mlocode='$row->mlocode' and type_of_igm='TS'
and (cont_status='EMT' or cont_status='Empty' or cont_status='MT' or cont_status='MTY' or cont_status='ETY')  
and cont_height='9.6'
  and cont_size <=20 and igm_details.final_submit=1";	
$result1=mysql_query($str1,$con_cchaportdb);
$row1t22e=mysql_fetch_object($result1);
							
							?>
<td  align="left"><?php if($row1t2e->total) print($row1t2e->total); 
else print("0"); $totalT20e=$row1t2e->total; $totalgT20e=$totalgT20e+$totalT20e;?></td>		 
						
<td  align="left"><?php if($row1t22e->total) print($row1t22e->total); 
else print("0"); $totalT2Be=$row1t22e->total; $totalgT20Be=$totalgT20Be+$totalT2Be;?></td>		 
						
						<?php
//TS 40" empty
$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
igm_details on igm_details.id=igm_detail_container.igm_detail_id 
where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
and mlocode='$row->mlocode' and type_of_igm='TS' 
and (cont_status='EMT' or cont_status='Empty' or cont_status='MT' or cont_status='MTY' or cont_status='ETY') 
and (cont_height='8.6' or cont_height='8') 
 and  cont_size =40 and 
igm_details.final_submit=1";	

$result1=mysql_query($str1,$con_cchaportdb);
$row1t4e=mysql_fetch_object($result1);


$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
igm_details on igm_details.id=igm_detail_container.igm_detail_id 
where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id 
and mlocode='$row->mlocode' and type_of_igm='TS'
and (cont_status='EMT' or cont_status='Empty' or cont_status='MT' or cont_status='MTY' or cont_status='ETY')  
and cont_height='9.6' 
and  cont_size =40 and 
igm_details.final_submit=1";

$result1=mysql_query($str1,$con_cchaportdb);
$row1t44e=mysql_fetch_object($result1);
							
							?>
<td  align="left"><?php if($row1t4e->total) print($row1t4e->total); 
else print("0"); $totalT40e=$row1t4e->total; $totalgT40e=$totalgT40e+$totalT40e;?></td>		 


<td  align="left"><?php if($row1t44e->total) print($row1t44e->total); 
else print("0"); $totalT4Be=$row1t44e->total; $totalgT40Be=$totalgT40Be+$totalT4Be;?></td>		 
							
							<?php
//TS 45"   zico
$str1="select count(distinct cont_number) as total from igm_detail_container inner join 
igm_details on igm_details.id=igm_detail_container.igm_detail_id 
where Import_Rotation_No='$rotation' and Submitee_Org_Id=$row->submitee_org_id and 
mlocode='$row->mlocode' and type_of_igm='TS' 
and (cont_status='EMT' or cont_status='Empty' or cont_status='MT' or cont_status='MTY' or cont_status='ETY') 
and cont_height='9.6' 
 and  cont_size =45 and igm_details.final_submit=1";	

$result1=mysql_query($str1,$con_cchaportdb);
$row1t45e=mysql_fetch_object($result1l);
							
							?>
<td  align="left"><?php if($row1t45e->total) print($row1t45e->total); 
else print("0"); $totalT45e=$row1t45e->total; $totalgT45e=$totalgT45e+$totalT45e;?></td>		 

<?php $grand=$totalf20f+$totalf20+$total240+$total2f40+$tota45+$total1+$total1l+$total2+
$total2f+$tota31+

$total3+$total3e+
$total4+$total40+$total45+

$totalT20+$totalT2B+$totalT40+$totalT4B+$totalT45

+$totalT20l+$totalT2Bl+$totalT40l+$totalT4Bl+$totalT45l

+$totalT20e+$totalT2Be+$totalT40e+$totalT4Be+$totalT45e
; ?>

<?php 
$grand20=$totalf20f+$totalf20+$total1+$total1l+$total3+$total3e+$totalT20+$totalT2B 
+$totalT20l+$totalT2Bl+$totalT20e+$totalT2Be
; ?>

<?php 
$grand40=$total240+$total2f40+$total2+
$total2f+$total4+$total40+$totalT40+$totalT4B+$totalT40l+$totalT4Bl+$totalT40e+$totalT4Be
; ?>

<?php 
$grand45=$tota45+$tota31+$total45+$totalT45+$totalT45l+$totalT45e
; ?>


							
 		
			<td align="center"><?php if($grand) print($grand20); else print("0"); ?></td>
			<td align="center"><?php if($grand) print($grand40); else print("0"); ?></td>
			<td align="center"><?php if($grand) print($grand45); else print("0"); ?></td>
			
			<td align="center"><?php if($grand) print($grand); else print("0"); ?></td>
							</tr>
					 <?php } ?>
				
					</tr> 

                                         <tr>
					<td align="center"><b>Grand Total</b></td>
					<td><?php print("&nbsp;");?></td>
					<td><?php print("&nbsp;");?></td>
					

					<td><b><?php print($totalg1);?></b></td>
					<td><b><?php print($totalg1l);?></b></td>
					
					
					<td><b><?php print($totalg2);?></b></td>
					
					<td><b><?php print($totalg2f);?></b></td>
					
					<td><b><?php print($totalg31); // lcl end  $totalg31?></b></td>
					

					<td><b><?php print($totalFCL20A);?></b></td>
					<td><b><?php print($totalFCL20B);?></b></td>
					
					<td><b><?php print($totalg40A);?></b></td>
					<td><b><?php print($totalg2f40B);?></b></td>
					
					
					<td><b><?php print($totalg45f);//fcl end?></b></td>
					
					
					
					
					
					
					
					<td><b><?php print($totalg3);?></b></td>
					<td><b><?php print($totalg3e);?></b></td>
					
					<td><b><?php print($totalg4);?></b></td>
					<td><b><?php print($total4e40);?></b></td>
					
					
					<td><b><?php print($total4e45);//end empty?></b></td>
					
					
					
					<td><b><?php print($totalgT20);?></b></td>				
					<td><b><?php print($totalgT20B);?></b></td>
					<td><b><?php print($totalgT40);?></b></td>
					<td><b><?php print($totalgT40B);?></b></td>
					
					<td><b><?php print($totalgT45);//end ts fcl?></b></td>
					
					
					<td><b><?php print($totalgT20l);?></b></td>				
					<td><b><?php print($totalgT20Bl);?></b></td>
					<td><b><?php print($totalgT40l);?></b></td>
					<td><b><?php print($totalgT40Bl);?></b></td>
					
					<td><b><?php print($totalgT45l);//end ts lcl?></b></td>
					
					
					<td><b><?php print($totalgT20e);?></b></td>				
					<td><b><?php print($totalgT20Be);?></b></td>
					<td><b><?php print($totalgT40e);?></b></td>
					<td><b><?php print($totalgT40Be);?></b></td>
					
					<td><b><?php print($totalgT45e);//end ts empty?></b></td>
					
					<td align="center"><b><?php print($sum20+$grand20);?></b></td>
					<td align="center"><b><?php print($sum40+$grand40);?></b></td>
					<td align="center"><b><?php print($sum45+$grand45);?></b></td>
									
					<td align="center"><b><?php print($sum+$grand);?></b></td>
                    
					</tr>

					
				
					</table>
					
			</TD></TR>
		</TABLE>
	
<?php 
mysql_close($con_cchaportdb);
mysql_close($con_sparcsn4);
if($_POST['options']=='html'){?>		
	</BODY>
</HTML>
<?php }?>
