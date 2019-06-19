<?php if($_POST['options']=='html'){?>
<HTML>
	<HEAD>
		<TITLE>IGM Import Manifest</TITLE>
		<LINK href="../css/report.css" type=text/css rel=stylesheet>
	</HEAD>
	<BODY>
	<?php } else if($_POST['options']=='xl'){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=IGM.xls;");
		header("Content-Type: application/ms-excel");
		header("Pragma: no-cache");
		header("Expires: 0");

	}
	include("mydbPConnection.php");
	
	$igm_id=$_GET['igm_no'];
	//$rotation=mysql_query("select id,Import_Rotation_No from igm_details where IGM_id='$igm_id'");
	//$rowinp=mysql_fetch_object($rotation);
	$from=$rowinp->Import_Rotation_No;
	$txt_org=$_POST['txt_org'];
	$org_id=$_GET['org_id'];
	//echo $org_id;
	$import=$_POST[ddl_imp_rot_no];
	//echo $from;
	$txt_org=$_POST[txt_line];
	$mlo=$_POST['ddl_Org_id'];
	
//echo $import;
//echo ($org_id."aaaa");
//echo $txt_org;
//echo $mlo;

	//include("mydbPConnection.php");
	//For FCL Container Count - 20"
			

	if($_POST['txt_line']=="all")
{

	$str1="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and 
	(cont_status='FCL' or cont_status='FCL/PART' or cont_status='PRT')  
	and type_of_igm<>'TS' 
    and off_dock_id<>'2592' 
    and (cont_size='20' or cont_size='10') and
    igm_details.Import_Rotation_No='$import' and igm_details.final_submit=1";

}
else
{

	$str1="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	 and 
	(cont_status='FCL' or cont_status='FCL/PART' or cont_status='PRT') 
	and type_of_igm<>'TS' 
    and off_dock_id<>'2592' 
    and (cont_size='20' or cont_size='10') and
    igm_details.Import_Rotation_No='$import' and igm_details.Submitee_Org_Id=$txt_org	and mlocode='$mlo' and igm_details.final_submit=1";


}						
	                 
	//For LCL Container Count-20"
 	if($_POST['txt_line']=="all")
{  
 $str3="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and 
	cont_status='LCL' 
	and type_of_igm<>'TS' 
    and off_dock_id<>'2592' 
    and (cont_size='20' or cont_size='10') and
igm_details.Import_Rotation_No='$import' and igm_details.final_submit=1 ";

}

else

{
$str3="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and
	cont_status='LCL' 
	and type_of_igm<>'TS' 
    and off_dock_id<>'2592' 
    and (cont_size='20' or cont_size='10') and
igm_details.Import_Rotation_No='$import' and igm_details.Submitee_Org_Id=$txt_org and igm_details.final_submit=1	and mlocode='$mlo'";
}	
	//For Empty Container Count - Emp-20"


	if($_POST['txt_line']=="all")
{  
	$str5="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	      FROM igm_details,igm_detail_container WHERE 
	      igm_details.id=igm_detail_container.igm_detail_id 
          and
	      type_of_igm<>'TS' and cont_iso_type  not in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') and cont_iso_type not in ('DRY')
	      and
	      (cont_status='EMT' or cont_status='Empty'or cont_status='MT' or cont_status='MTY' or cont_status='ETY')
		  and off_dock_id<>'2592' 
          and (cont_size='20' or cont_size='10') and
igm_details.Import_Rotation_No='$import' and igm_details.final_submit=1";
}
else
{
$str5="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	      FROM igm_details,igm_detail_container WHERE 
	      igm_details.id=igm_detail_container.igm_detail_id 
          and
	      type_of_igm<>'TS' and cont_iso_type  not in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') and cont_iso_type not in ('DRY')
	      and
	        (cont_status='EMT' or cont_status='Empty' or cont_status='MT' or cont_status='MTY' or cont_status='ETY')
		  and off_dock_id<>'2592' 
          and (cont_size='20' or cont_size='10') and
igm_details.Import_Rotation_No='$import' and igm_details.Submitee_Org_Id=$txt_org and igm_details.final_submit=1	and mlocode='$mlo'";

}

	//ICD - 20"
	if($_POST['txt_line']=="all")
{  							
						
	$str7="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and off_dock_id='2592' 
    and (cont_size='20' or cont_size='10') and
igm_details.Import_Rotation_No='$import' and igm_details.final_submit=1";
	
}

else
{
	$str7="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and off_dock_id='2592' 
    and (cont_size='20' or cont_size='10') and
igm_details.Import_Rotation_No='$import' and igm_details.Submitee_Org_Id=$txt_org and igm_details.final_submit=1	and mlocode='$mlo'";
	
}

							
	//TS	- 20"

if($_POST['txt_line']=="all")
{  							
							
	$str9="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and type_of_igm='TS' 
	and (cont_size='20' or cont_size='10') and
igm_details.Import_Rotation_No='$import' and igm_details.final_submit=1 ";

//    group by Submitee_Org_Id";

}

else

{
	$str9="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and type_of_igm='TS' 
	and (cont_size='20' or cont_size='10') and
igm_details.Import_Rotation_No='$import' and igm_details.Submitee_Org_Id=$txt_org and igm_details.final_submit=1	and mlocode='$mlo'";

//    group by Submitee_Org_Id";

}

								
	// Reefer	 - 20"			
if($_POST['txt_line']=="all")
{
	$str11="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and cont_iso_type in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') and cont_iso_type not in ('DRY')  and (cont_status='EMT' or cont_status='Empty' or cont_status='MT' or cont_status='ETY' )
	and (cont_size='20' or cont_size='10')
	and igm_details.Import_Rotation_No='$import' and igm_details.final_submit=1 ";


}

else

{
	$str11="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and cont_iso_type in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') and cont_iso_type not in ('DRY')  and (cont_status='EMT' or cont_status='Empty' or cont_status='MT' or cont_status='ETY')
	and (cont_size='20' or cont_size='10')
	and igm_details.Import_Rotation_No='$import' and igm_details.Submitee_Org_Id=$txt_org	and mlocode='$mlo' and igm_details.final_submit=1";


}
	

if($_POST['txt_line']=="all")
{
	$str110="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and cont_iso_type in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') and cont_iso_type not in ('DRY') and (!(cont_status='EMT' or cont_status='Empty' or cont_status='MT' or cont_status='ETY'))
	and (cont_size='20' or cont_size='10')
	and igm_details.Import_Rotation_No='$import' and igm_details.final_submit=1 ";


}

else

{
	$str110="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and cont_iso_type in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') and cont_iso_type not in ('DRY') and (!(cont_status='EMT' or cont_status='Empty' or cont_status='MT' or cont_status='ETY'))
	and (cont_size='20' or cont_size='10')
	and igm_details.Import_Rotation_No='$import' and igm_details.Submitee_Org_Id=$txt_org	and mlocode='$mlo' and igm_details.final_submit=1";


}
	
	//IMCO UN - 20"
if($_POST['txt_line']=="all")
{

	$str13="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id  and (cont_un   <> '' or cont_imo <> '')
	and (cont_size='20' or cont_size='10') and igm_details.Import_Rotation_No='$import' and igm_details.final_submit=1";
}

else

{
	$str13="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id  and (cont_un   <> '' or cont_imo <> '')
	and (cont_size='20' or cont_size='10') and igm_details.Import_Rotation_No='$import' and igm_details.Submitee_Org_Id=$txt_org	and mlocode='$mlo' and igm_details.final_submit=1";
}

							
							
													
													
	$result1=mysql_query($str1); //For FCL - 20"
	$row=mysql_fetch_object($result1); 
				   
	$result3=mysql_query($str3);//for LCL - 20"
	$row3=mysql_fetch_object($result3);
				   
	$result5=mysql_query($str5);//For Empty - 20"
	$row5=mysql_fetch_object($result5);
				    
	$result7=mysql_query($str7); // For TS 20"
    $row7=mysql_fetch_object($result7);
				   
	$result9=mysql_query($str9); // For ICD 20"
	$row9=mysql_fetch_object($result9);
				   
	$result11=mysql_query($str11); //For Refer 20"
				   $row11=mysql_fetch_object($result11);

$result110=mysql_query($str110); //For Refer 20"
    $row110=mysql_fetch_object($result110);
				   
	$result13=mysql_query($str13); // For IMCO/UN 20"
	$row13=mysql_fetch_object($result13);
				    
				   
	//For FCL Container Count - 40"
			


if($_POST['txt_line']=="all")
{

	$str2="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and 
	(cont_status='FCL' or cont_status='FCL/PART' or cont_status='PRT') 
	and type_of_igm<>'TS' 
    and off_dock_id<>'2592' 
    and cont_size='40'
    and igm_details.Import_Rotation_No='$import' and igm_details.final_submit=1";
}
else
{
	$str2="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and 
	(cont_status='FCL' or cont_status='FCL/PART' or cont_status='PRT') 
	and type_of_igm<>'TS' 
    and off_dock_id<>'2592' 
    and cont_size='40'
    and igm_details.Import_Rotation_No='$import' and igm_details.Submitee_Org_Id=$txt_org and igm_details.final_submit=1	and mlocode='$mlo'";
}
	//print($str2);					
	                 
	//For LCL Container Count+40"
  

if($_POST['txt_line']=="all")
{
  $str4="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and
	cont_status='LCL' 
	and type_of_igm<>'TS' 
    and off_dock_id<>'2592' 
    and cont_size='40'
    and igm_details.Import_Rotation_No='$import' and igm_details.final_submit=1";

}

else
{
 $str4="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and
	cont_status='LCL' 
	and type_of_igm<>'TS' 
    and off_dock_id<>'2592' 
    and cont_size='40'
    and igm_details.Import_Rotation_No='$import' and igm_details.Submitee_Org_Id=$txt_org and igm_details.final_submit=1	and mlocode='$mlo'";

}

//print($str4);	

	
	//For Empty Container Count + Emp+40"
if($_POST['txt_line']=="all")
{
	$str6="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	      FROM igm_details,igm_detail_container WHERE 
	      igm_details.id=igm_detail_container.igm_detail_id 
          and
	      type_of_igm<>'TS' 
	      and
	        (cont_status='EMT' or cont_status='Empty' or cont_status='MT' or cont_status='MTY' or cont_status='ETY') and (!(cont_type='REEFER' or cont_type='REFER'))
		  and off_dock_id<>'2592' 
          and cont_size='40'
          and igm_details.Import_Rotation_No='$import' and igm_details.final_submit=1";
}

else
{

	$str6="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	      FROM igm_details,igm_detail_container WHERE 
	      igm_details.id=igm_detail_container.igm_detail_id 
          and
	      type_of_igm<>'TS' 
	      and
	       (cont_status='EMT' or cont_status='Empty' or cont_status='MT' or cont_status='MTY' or cont_status='ETY') and (!(cont_type='REEFER' or cont_type='REFER'))
		  and off_dock_id<>'2592' 
          and cont_size='40'
          and igm_details.Import_Rotation_No='$import' and igm_details.Submitee_Org_Id=$txt_org	and mlocode='$mlo' and igm_details.final_submit=1";

}

	//ICD + 40"							
						
if($_POST['txt_line']=="all")
{
	$str8="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and off_dock_id='2592' 
    and cont_size='40'
    and igm_details.Import_Rotation_No='$import' and igm_details.final_submit=1";
}

else

{
	$str8="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and off_dock_id='2592' 
    and cont_size='40'
    and igm_details.Import_Rotation_No='$import' and igm_details.Submitee_Org_Id=$txt_org and igm_details.final_submit=1	and mlocode='$mlo'";
}

								
	//TS	+ 40"						


if($_POST['txt_line']=="all")
{
	$str10="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and type_of_igm='TS' 
	and cont_size='40'
    and igm_details.Import_Rotation_No='$import' and igm_details.final_submit=1
";
}
else

{
	$str10="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and type_of_igm='TS' 
	and cont_size='40'
    and igm_details.Import_Rotation_No='$import' and igm_details.Submitee_Org_Id=$txt_org	and mlocode='$mlo'

    group by Submitee_Org_Id and igm_details.final_submit=1";
}

								
	// Reefer	 + 40"			


if($_POST['txt_line']=="all")
{
	$str12="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and cont_iso_type in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') and cont_iso_type not in ('DRY') and (cont_status='EMT' or cont_status='Empty' or cont_status='MT' or cont_status='ETY')
	and cont_size='40'
	and igm_details.Import_Rotation_No='$import' and igm_details.final_submit=1";

}

else
{

	$str12="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and cont_iso_type in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') and cont_iso_type not in ('DRY') and (cont_status='EMT' or cont_status='Empty' or cont_status='MT' or cont_status='ETY')
	and cont_size='40'
	and igm_details.Import_Rotation_No='$import' and igm_details.Submitee_Org_Id=$txt_org	and mlocode='$mlo' and igm_details.final_submit=1";
}

if($_POST['txt_line']=="all")
{
	$str120="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and cont_iso_type in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') and cont_iso_type not in ('DRY') and (!(cont_status='EMT' or cont_status='Empty' or cont_status='MT' or cont_status='ETY'))
	and cont_size='40'
	and igm_details.Import_Rotation_No='$import' and igm_details.final_submit=1";

}

else
{

	$str120="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and cont_iso_type in('22R1','45R1','45R0','25R1','45R3','22R0','42R1','45R8','20R1','22R9','42R0','22R2','20R0','45R4','22R7','42R3') and cont_iso_type not in ('DRY') and (!(cont_status='EMT' or cont_status='Empty' or cont_status='MT' or cont_status='ETY'))
	and cont_size='40'
	and igm_details.Import_Rotation_No='$import' and igm_details.Submitee_Org_Id=$txt_org	and mlocode='$mlo' and igm_details.final_submit=1";
}

	//IMCO UN + 40"
if($_POST['txt_line']=="all")
{
	$str14="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id  and (cont_un   <> '' or cont_imo <> '')
	and cont_size='40' and igm_details.Import_Rotation_No='$import' and igm_details.final_submit=1 ";


}

else

{
	$str14="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id  and (cont_un   <> '' or cont_imo <> '')
	and cont_size='40' and igm_details.Import_Rotation_No='$import' and igm_details.Submitee_Org_Id=$txt_org	and mlocode='$mlo' and igm_details.final_submit=1";


}
	//40"
				   $result2=mysql_query($str2);//FCL
				   $row2=mysql_fetch_object($result2);
				   
				    $result4=mysql_query($str4);//LCL
				   $row4=mysql_fetch_object($result4);
				   
				    $result6=mysql_query($str6);//EMPTY
				   $row6=mysql_fetch_object($result6);
				    
				   $result8=mysql_query($str8);//ICD
				   $row8=mysql_fetch_object($result8);
				   
				    $result10=mysql_query($str10);//TS
				   $row10=mysql_fetch_object($result10);
				   
				    $result12=mysql_query($str12);//Refer
				   $row12=mysql_fetch_object($result12);

					$result120=mysql_query($str120);//Refer full
				   $row120=mysql_fetch_object($result120);
				   
				    $result14=mysql_query($str14);//IMCO
				   $row14=mysql_fetch_object($result14);
				    
//For FCL Container Count + 45"
			

if($_POST['txt_line']=="all")
{
	$str21="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and
	(cont_status='FCL' or cont_status='FCL/PART' or cont_status='PRT') 
	and type_of_igm<>'TS' 
    and off_dock_id<>'2592' 
    and cont_size>'40'
    and igm_details.Import_Rotation_No='$import' and igm_details.final_submit=1 ";
}
else
{
	$str21="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and
	(cont_status='FCL' or cont_status='FCL/PART' or cont_status='PRT') 
	and type_of_igm<>'TS' 
    and off_dock_id<>'2592' 
    and cont_size>'40'
    and igm_details.Import_Rotation_No='$import' and igm_details.Submitee_Org_Id=$txt_org	and mlocode='$mlo' and igm_details.final_submit=1";
}
						
	                 
	//For LCL Container Count+45"
if($_POST['txt_line']=="all")
{

    $str22="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and
	cont_status='LCL' 
	and type_of_igm<>'TS' 
    and off_dock_id<>'2592' 
    and cont_size>'40'
    and igm_details.Import_Rotation_No='$import' and igm_details.final_submit=1";

}

else

{
 $str22="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and
	cont_status='LCL' 
	and type_of_igm<>'TS' 
    and off_dock_id<>'2592' 
    and cont_size>'40'
    and igm_details.Import_Rotation_No='$import' and igm_details.Submitee_Org_Id=$txt_org	and mlocode='$mlo' and igm_details.final_submit=1";
//print($str22);

}

	//For Empty Container Count + Emp+45"
if($_POST['txt_line']=="all")
{
	$str23="SELECT  count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	      FROM igm_details,igm_detail_container WHERE 
	      igm_details.id=igm_detail_container.igm_detail_id 
          and
	      type_of_igm<>'TS'  and (!(cont_type='REEFER' or cont_type='REFER'))
	      and
	       (cont_status='EMT' or cont_status='Empty' or cont_status='MT' or cont_status='MTY' or cont_status='ETY')
		  and off_dock_id<>'2592' 
          and cont_size>'40'
          and igm_details.Import_Rotation_No='$import' and igm_details.final_submit=1";

}
else
{

	$str23="SELECT  count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	      FROM igm_details,igm_detail_container WHERE 
	      igm_details.id=igm_detail_container.igm_detail_id 
          and
	      type_of_igm<>'TS' and (!(cont_type='REEFER' or cont_type='REFER'))
	      and
	        (cont_status='EMT' or cont_status='Empty' or cont_status='MT' or cont_status='MTY' or cont_status='ETY') 
		  and off_dock_id<>'2592' 
          and cont_size>'40'
          and igm_details.Import_Rotation_No='$import' and igm_details.Submitee_Org_Id=$txt_org	and mlocode='$mlo' and igm_details.final_submit=1";

		//print($str23);


}
	//ICD + 45"							
						

if($_POST['txt_line']=="all")
{
	$str24="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and off_dock_id='2592' 
    and cont_size>'40'
    and igm_details.Import_Rotation_No='$import' and igm_details.final_submit=1";

}
else
{
	$str24="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and off_dock_id='2592' 
    and cont_size>'40'
    and igm_details.Import_Rotation_No='$import' and igm_details.Submitee_Org_Id=$txt_org	and mlocode='$mlo' and igm_details.final_submit=1";

}

								
	//TS	+ 45"
						
if($_POST['txt_line']=="all")
{
	$str25="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and type_of_igm='TS' 
	and cont_size>'40'
    and igm_details.Import_Rotation_No='$import' '
and igm_details.final_submit=1";
}

else
{
	$str25="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and type_of_igm='TS' 
	and cont_size>'40'
    and igm_details.Import_Rotation_No='$import' and igm_details.Submitee_Org_Id=$txt_org	and mlocode='$mlo'
and igm_details.final_submit=1";
}

								
	// Reefer	 + 45"

if($_POST['txt_line']=="all")
{			
	$str26="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and (cont_type='REEFER' OR  cont_type='REFER') and (!(cont_status='EMT' or cont_status='Empty' or cont_status='MT' or cont_status='ETY'))
	and cont_size>'40'
	and igm_details.Import_Rotation_No='$import' and igm_details.final_submit=1 ";

}
else
{
$str26="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and (cont_type='REEFER' OR  cont_type='REFER') and (!(cont_status='EMT' or cont_status='Empty' or cont_status='MT' or cont_status='ETY'))
	and cont_size>'40'
	and igm_details.Import_Rotation_No='$import' and igm_details.Submitee_Org_Id=$txt_org	and mlocode='$mlo' and igm_details.final_submit=1";

}


if($_POST['txt_line']=="all")
{			
	$str260="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and (cont_type='REEFER' OR  cont_type='REFER') and (cont_status='EMT' or cont_status='Empty' or cont_status='MT' or cont_status='ETY')
	and cont_size>'40'
	and igm_details.Import_Rotation_No='$import' and igm_details.final_submit=1 ";

}
else
{
$str260="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id 
	and (cont_type='REEFER' OR  cont_type='REFER') and (cont_status='EMT' or cont_status='Empty' or cont_status='MT' or cont_status='ETY')
	and cont_size>'40'
	and igm_details.Import_Rotation_No='$import' and igm_details.Submitee_Org_Id=$txt_org	and mlocode='$mlo' and igm_details.final_submit=1";

}
	//IMCO UN + 45"
if($_POST['txt_line']=="all")
{

	$str27="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id  and (cont_un   <> '' or cont_imo <> '')
	and cont_size>'40' and igm_details.Import_Rotation_No='$import' and igm_details.final_submit=1";
}
else
{
$str27="SELECT count(distinct cont_number) as number,sum(cont_gross_weight) as gross_weight,sum(cont_gross_weight+cont_weight) as net_weight,sum(cont_weight) as tare_weight
	FROM igm_details,igm_detail_container WHERE 
	igm_details.id=igm_detail_container.igm_detail_id  and (cont_un   <> '' or cont_imo <> '')
	and cont_size>'40' and igm_details.Import_Rotation_No='$import' and igm_details.Submitee_Org_Id=$txt_org	and mlocode='$mlo' and igm_details.final_submit=1";
}
													
				//	print $str22;
					//print $str2;
				   $result21=mysql_query($str21);
				   $row21=mysql_fetch_object($result21);
				   
				    $result22=mysql_query($str22);
				   $row22=mysql_fetch_object($result22);
				   
				    $result23=mysql_query($str23);
				   $row23=mysql_fetch_object($result23);
				    
				   $result24=mysql_query($str24);
				   $row24=mysql_fetch_object($result24);
				   
				    $result25=mysql_query($str25);
				   $row25=mysql_fetch_object($result25);
				   
				    $result26=mysql_query($str26);
				   $row26=mysql_fetch_object($result26);
				   
				    $result27=mysql_query($str27);
				   $row27=mysql_fetch_object($result27);
				    
				   
								
					
		$result_igm_master=mysql_query("SELECT
												Import_Rotation_No,
												vessels.Vessel_Name,
												Voy_No,
												Net_Tonnage,
												Port_of_Shipment,
												Port_of_Destination,
												Sailed_Year,
												Submitee_Org_Id,
												Name_of_Master,
												Organization_Name,
												Submitee_Org_Type,
												is_Foreign,
												Vessel_Type,
												Name_of_Master,
												Port_of_Registry
											FROM
												igm_masters 
												LEFT JOIN organization_profiles ON 
												organization_profiles.id=igm_masters.Submitee_Org_Id
												LEFT JOIN vessels ON vessels.id=igm_masters.Vessel_Id
											WHERE 
												igm_masters.Import_Rotation_No='$import'
												
											");
		
			if($result_igm_master)
			$row_igm_master=mysql_fetch_object($result_igm_master);	
			$str="SELECT Organization_Name from organization_profiles where id='$_POST[txt_line]'";
			//print $str;
			$result_org_name=mysql_query($str);
			$row_org_name=mysql_fetch_object($result_org_name);
			$str1=mysql_query("select ETA_Date,ETD_Date,Actual_Berth,Actual_Berth_time from vessels_berth_detail
									where Import_Rotation_No='$import'");
$row_time=mysql_fetch_object($str1);
		
		
		?>
		
	    <p>
	      <?php //if($_POST['options']=='html'){?>		
</p>

		<table align="center">
			<tr align="center">
				<!--td style="font-size:22px;" ><b><font size="4"><b>CHITTAGONG PORT AUTHORITY, CHITTAGONG</b></td-->
				<td align="center"><img width="280px" height="90px" src="<?php echo IMG_PATH?>cpanew.jpg"></td>
			</tr>
			<tr><td style="font-size:22px;" ><b>MLO DISCHARGE SUMMARY</b></td></tr>
			 <tr>
            <tr><td height="37"><p class="style1">AGENT:<?php print($row_igm_master->Organization_Name);?></p>
  <p class="style1">ORGANIZATION NAME: <?php print($row_org_name->Organization_Name);?></p>              
<p class="style1">MLO: <?php print($mlo);?></p></td>
          </tr>
	 <tr>
                  <td height="22" colspan="0">Vessel:<?php print($row_igm_master->Vessel_Name);?></td>
                  <td>&nbsp;</td>
                </tr>
				 <tr>
            <td>
                <tr>
                  <td>Voyage No:<?php print($row_igm_master->Voy_No);?> </td>
                  <td>Cust Rot No:<?php print($row_igm_master->Import_Rotation_No);?> </td>
				  </tr>
				  <tr>
                  <td>ETA:<?php print($row_time->ETA_Date);?></td>
                  <td>ETD:<?php print($row_time->ETD_Date);?></td>
                </tr>
		</table>  
 <table  width="100%" border="1">          
              <tr>
                <td colspan="2" width="20%"><strong>Container</strong></td>
                <td  colspan="1" width="20%"><strong>CL</strong></td>
                <td colspan="3" width="30%"><div align="center"><strong colspan="4">NOS. of cont.</strong></div></td>
                <td colspan="4" width="30%"><div align="center"><strong>Gross weight </strong></div></td>
              </tr>
              <tr>
                <td height="22">Size</td>
                <td  colspan="1">Type</td>
              <td  colspan="1" ><strong>CL</strong></td>
                <td >Full</td>
                <td >MT</td>
                <td >Total</td>
                <td >Full</td>
                <td >NET</td>
                <td >MT</td>
                <td >Total</td>
              </tr>
              
                
                    <tr>
                      <td width="7%" height="100" rowspan="8">20</td>
                      <td width="11%" height="100" rowspan="5">Normal</td>
                      <td width="14%" height="19">FCL</td>
					  <td width="14%" height="19"><?php if($row->number) print($row->number); else print("&nbsp;");?></td>
                          <td width="14%" height="19"><?php print("&nbsp;");?></td>
                          <td width="18%" height="19"><?php if($row->number) print($row->number); else print("&nbsp;");?></td>
                          <td width="13%" height="19"><?php if($row->net_weight) print($row->net_weight); else print("&nbsp;");?></td>
                          <td width="15%" height="19"><?php if($row->gross_weight)  print($row->gross_weight); else print("&nbsp;");?></td>
                         <td width="14%" height="19"><?php print("&nbsp;&nbsp;");?></td>
                           <td width="15%" height="19"><?php if($row->gross_weight) print($row->gross_weight); else print("&nbsp;");?></td>
					</tr>
					<tr>
					 <td width="14%" height="19">LCL</td>
					  <td width="14%" height="19"><?php if($row3->number) print($row3->number); else print("&nbsp;");?></td>
                          <td width="14%" height="19"><?php  print("&nbsp;");?></td>
                          <td width="18%" height="19"><?php if($row3->number) print($row3->number); else print("&nbsp;");?></td>
                          <td width="13%" height="19"><?php if($row3->net_weight) print($row3->net_weight); else print("&nbsp;");?></td>
                          <td width="15%" height="19"><?php if($row3->gross_weight) print($row3->gross_weight); else print("&nbsp;");?></td>
                         <td width="14%" height="19"><?php print("&nbsp;");?></td>
                           <td width="15%" height="19"><?php if($row3->gross_weight) print($row3->gross_weight); else print("&nbsp;");?></td>
					</tr>
					<tr>
					<td width="14%" height="19">EMPTY</td>
					
					
						  <td width="14%" height="19"><?php print("&nbsp;");?></td>
				     	   <td width="14%" height="19"><?php if($row5->number) print($row5->number); else print("&nbsp;");?></td>
                          <td width="18%" height="19"><?php if($row5->number) print($row5->number); else print("&nbsp;");?></td>
                         <td width="14%" height="19"><?php print("&nbsp;");?></td>
					     <td width="14%" height="19"><?php print("&nbsp;");?></td>
                          <td width="15%" height="19"><?php if($row5->net_weight) print($row5->net_weight); else print("&nbsp;");?></td>
                         <td width="15%" height="19"><?php if($row5->net_weight) print($row5->net_weight); else print("&nbsp;");?></td>
                          
                        </tr>
					<tr>
					<td width="14%" height="19">ICD</td>
					      <td width="14%" height="19"><?php if($row7->number) print($row7->number); else print("&nbsp;");?></td>
                          <td width="14%" height="19"><?php  print("&nbsp;");?></td>
                          <td width="18%" height="19"><?php if($row7->number) print($row7->number); else print("&nbsp;");?></td>
                          <td width="13%" height="19"><?php if($row7->net_weight) print($row7->net_weight); else print("&nbsp;");?></td>
                          <td width="15%" height="19"><?php if($row7->gross_weight) print($row7->gross_weight); else print("&nbsp;");?></td>
                          <td width="14%" height="19"><?php print("&nbsp;");?></td>
                           <td width="15%" height="19"><?php if($row7->gross_weight) print($row7->gross_weight); else print("&nbsp;");?></td>
					</tr>
					<tr>
					<td width="14%" height="19">TRANS</td>
					  <td width="14%" height="19"><?php if($row9->number) print($row9->number); else print("&nbsp;");?></td>
                          <td width="14%" height="19"><?php  print("&nbsp;");?></td>
                          <td width="18%" height="19"><?php if($row9->number) print($row9->number); else print("&nbsp;");?></td>
                          <td width="13%" height="19"><?php if($row9->net_weight) print($row9->net_weight); else print("&nbsp;");?></td>
                          <td width="15%" height="19"><?php if($row9->gross_weight) print($row9->gross_weight); else print("&nbsp;");?></td>
                         <td width="14%" height="19"><?php print("&nbsp;");?></td>
                           <td width="15%" height="19"><?php if($row9->gross_weight) print($row9->gross_weight); else print("&nbsp;");?></td>
					</tr>
					<tr>
					<td width="14%" height="19">REFFER</td>
					<td width="14%" height="19">REFR</td>
					<td width="14%" height="19"><?php if($row110->number) print($row110->number); else print("&nbsp;");?></td>
                          <td width="14%" height="19"><?php if($row11->number) print("&nbsp;");?></td>
                          <td width="18%" height="19"><?php  print($row11->number+$row110->number); ?></td>
                          <td width="13%" height="19"><?php  print($row11->net_weight+$row110->net_weight); ?></td>
                          <td width="15%" height="19"><?php  print($row11->gross_weight+$row110->gross_weight);?></td>
                         <td width="14%" height="19"><?php print("&nbsp;");?></td>
                           <td width="15%" height="19"><?php  print($row11->gross_weight+$row110->gross_weight);?></td>
					</tr>
					<tr>
						<td width="14%" height="19">IMDG</td>
					<td width="14%" height="19">IMDG</td>
					<td width="14%" height="19"><?php if($row13->number) print($row13->number); else print("&nbsp;");?></td>
                          <td width="14%" height="19"><?php print("&nbsp;");?></td>
                          <td width="18%" height="19"><?php if($row13->number) print($row13->number); else print("&nbsp;");?></td>
                          <td width="13%" height="19"><?php  print($row13->net_weight);?></td>
                          <td width="15%" height="19"><?php if($row13->gross_weight) print($row13->gross_weight); else print("&nbsp;");?></td>
                         <td width="14%" height="19"><?php print("&nbsp;");?></td>
                           <td width="15%" height="19"><?php if($row13->gross_weight)  print($row13->gross_weight); else print("&nbsp;");?></td>
					</tr>
					<tr>
						<td width="14%" height="19">Subtotal</td>
					<td width="14%" height="19">&nbsp;</td>
					 <td width="14%" height="19"><?php $total1=$row->number+$row3->number+$row5->number+$row7->number+$row9->number+$row11->number; print($total1); ?></td>
                          <td width="14%" height="19"><?php print("&nbsp;");?></td>
                          <td width="14%" height="19"><?php $total4=$row->number+$row3->number+$row5->number+$row7->number+$row9->number+$row11->number; print($total4); ?></td>
                          <td width="14%" height="19"><?php $total7=$row->net_weight+$row3->net_weight+$row5->net_weight+$row7->net_weight+$row9->net_weight; print($total7); ?></td>
                          <td width="14%" height="19"><?php $total10=$row->gross_weight+$row3->gross_weight+$row5->gross_weight+$row7->gross_weight+$row9->gross_weight; print($total10); ?></td>
                          <td width="14%" height="19"><?php print("&nbsp;");?></td>
                        <td width="14%" height="19"><?php $total13=$row->gross_weight+$row3->gross_weight+$row5->gross_weight+$row7->gross_weight+$row9->gross_weight; print($total13); ?></td>
					</tr>
					 <tr>
                      <td width="7%" height="100" rowspan="8">40</td>
                      <td width="11%" height="100" rowspan="5">Normal</td>
                      <td width="14%" height="19">FCL</td>
					  <td width="14%" height="19"><?php if($row2->number) print($row2->number); else print("&nbsp;");?></td>
                          <td width="14%" height="19"><?php print("&nbsp;");?></td>
                          <td width="18%" height="19"><?php if($row2->number) print($row2->number); else print("&nbsp;");?></td>
                          <td width="13%" height="19"><?php if($row2->net_weight) print($row2->net_weight); else print("&nbsp;");?></td>
                          <td width="15%" height="19"><?php if($row2->gross_weight) print($row2->gross_weight); else print("&nbsp;");?></td>
                         <td width="14%" height="19"><?php print("&nbsp;");?></td>
                           <td width="15%" height="19"><?php if($row2->gross_weight) print($row2->gross_weight); else print("&nbsp;");?></td>
					</tr>
					<tr>
					 <td width="14%" height="19">LCL</td>
					  <td width="14%" height="19"><?php if($row4->number) print($row4->number); else print("&nbsp;");?></td>
                          <td width="14%" height="19"><?php print("&nbsp;");?></td>
                          <td width="18%" height="19"><?php if($row4->number) print($row4->number); else print("&nbsp;");?></td>
                          <td width="13%" height="19"><?php if($row4->net_weight) print($row4->net_weight); else print("&nbsp;");?></td>
                          <td width="15%" height="19"><?php if($row4->gross_weight) print($row4->gross_weight); else print("&nbsp;");?></td>
                         <td width="14%" height="19"><?php print("&nbsp;");?></td>
                           <td width="15%" height="19"><?php if($row4->gross_weight) print($row4->gross_weight); else print("&nbsp;");?></td>
					</tr>
					<tr>
					<td width="14%" height="19">EMPTY</td>
					
					
						   <td width="14%" height="19"><?php print("&nbsp;");?></td>
                          <td width="14%" height="19"><?php if($row6->number) print($row6->number); else print("&nbsp;");?></td>
                         
                          <td width="18%" height="19"><?php if($row6->number) print($row6->number); else print("&nbsp;");?></td>
                          <td width="14%" height="19"><?php print("&nbsp;");?></td>
						    <td width="14%" height="19"><?php print("&nbsp;");?></td>
                          <td width="15%" height="19"><?php if($row6->net_weight) print($row6->net_weight); else print("&nbsp;");?></td>
                       
                           <td width="15%" height="19"><?php if($row6->net_weight) print($row6->net_weight); else print("&nbsp;");?></td>
                          
                        </tr>
					<tr>
					<td width="14%" height="19">ICD</td>
					       <td width="14%" height="19"><?php if($row8->number) print($row8->number); else print("&nbsp;");?></td>
                          <td width="14%" height="19"><?php print("&nbsp;");?></td>
                          <td width="18%" height="19"><?php if($row8->number) print($row8->number); else print("&nbsp;");?></td>
                          <td width="13%" height="19"><?php if($row8->net_weight) print($row8->net_weight); else print("&nbsp;");?></td>
                          <td width="15%" height="19"><?php if($row8->gross_weight) print($row8->gross_weight); else print("&nbsp;");?></td>
                         <td width="14%" height="19"><?php print("&nbsp;");?></td>
                           <td width="15%" height="19"><?php if($row8->gross_weight) print($row8->gross_weight); else print("&nbsp;");?></td>
					</tr>
					<tr>
					<td width="14%" height="19">TRANS</td>
					   <td width="14%" height="19"><?php if($row10->number) print($row10->number); else print("&nbsp;");?></td>
                          <td width="14%" height="19"><?php print("&nbsp;");?></td>
                          <td width="18%" height="19"><?php if($row10->number) print($row10->number); else print("&nbsp;");?></td>
                          <td width="13%" height="19"><?php if($row10->net_weight) print($row10->net_weight); else print("&nbsp;");?></td>
                          <td width="15%" height="19"><?php if($row10->gross_weight) print($row10->gross_weight); else print("&nbsp;");?></td>
                         <td width="14%" height="19"><?php print("&nbsp;");?></td>
                           <td width="15%" height="19"><?php if($row10->gross_weight) print($row10->gross_weight); else print("&nbsp;");?></td>
					</tr>
					<tr>
					<td width="14%" height="19">REFFER</td>
					<td width="14%" height="19">REFR</td>
					<td width="14%" height="19"><?php if($row120->number) print($row120->number); else print("&nbsp;");?></td>
                          <td width="14%" height="19"><?php if($row12->number) print($row12->number); else print("&nbsp;");?></td>
                          <td width="18%" height="19"><?php   print($row12->number+$row120->number); ?></td>
                          <td width="13%" height="19"><?php   print($row12->net_weight+$row120->net_weight); ?></td>
                          <td width="15%" height="19"><?php   print($row12->gross_weight+$row120->gross_weight); ?></td>
                         <td width="14%" height="19"><?php print("&nbsp;");?></td>
                           <td width="15%" height="19"><?php   print($row12->gross_weight+$row120->gross_weight);?></td>
					</tr>
					<tr>
						<td width="14%" height="19">IMDG</td>
					<td width="14%" height="19">IMDG</td>
					 <td width="14%" height="19"><?php  if($row14->number) print($row14->number); else print("&nbsp;");?></td>
                          <td width="14%" height="19"><?php if($row14->number) print("&nbsp;");?></td>
                          <td width="18%" height="19"><?php if($row14->number) print($row14->number); else print("&nbsp;");?></td>
                          <td width="13%" height="19"><?php if($row14->net_weight) print($row14->net_weight); else print("&nbsp;");?></td>
                          <td width="15%" height="19"><?php if($row14->gross_weight) print($row14->gross_weight); else print("&nbsp;");?></td>
                         <td width="14%" height="19"><?php print("&nbsp;");?></td>
                           <td width="15%" height="19"><?php if($row14->gross_weight) print($row14->gross_weight); else print("&nbsp;");?></td>
					</tr>
					<tr>
						<td width="14%" height="19">Subtotal</td>
					<td width="14%" height="19">&nbsp;</td>
					 <td width="14%" height="19"><?php $total2=$row2->number+$row4->number+$row6->number+$row8->number+$row10->number+$row12->number; print($total2); ?></td>
                         <td width="14%"><?php print("&nbsp;");?></td>
                           <td width="14%"><?php $total5=$row2->number+$row4->number+$row6->number+$row8->number+$row10->number+$row12->number; print($total5); ?></td>
                          <td width="14%"><?php $total8=$row2->net_weight+$row4->net_weight+$row6->net_weight+$row8->net_weight+$row10->net_weight; print($total8); ?></td>
							<td width="14%"><?php $total11=$row2->gross_weight+$row4->gross_weight+$row6->gross_weight+$row8->gross_weight+$row10->gross_weight; print($total11); ?></td>
                       <td width="14%"><?php print("&nbsp;");?></td>
                        <td width="14%"><?php $total14=$row2->gross_weight+$row4->gross_weight+$row6->gross_weight+$row8->gross_weight+$row10->gross_weight; print($total14); ?></td>
					</tr>
					 <tr>
                      <td width="7%" height="100" rowspan="8">45</td>
                      <td width="11%" height="100" rowspan="5">Normal</td>
                      <td width="14%" height="19">FCL</td>
					 <td width="14%" height="19"><?php if($row21->number) print($row21->number); else print("&nbsp;");?></td>
                          <td width="14%"><?php print("&nbsp;");?></td>
                          <td width="18%"><?php  if($row21->number) print($row21->number); else print("&nbsp;");?></td>
                          <td width="13%"><?php  if($row21->net_weight)  print($row21->net_weight); else print("&nbsp;");?></td>
                          <td width="15%"><?php  if($row21->gross_weight) print($row21->gross_weight); else print("&nbsp;");?></td>
                         <td width="14%"><?php print("&nbsp;");?></td>
                           <td width="15%"><?php  if($row21->gross_weight) print($row21->gross_weight); else print("&nbsp;");?></td>
					</tr>
					<tr>
					 <td width="14%" height="19">LCL</td>
					   <td width="14%" height="19"><?php  if($row22->number) print($row22->number); else print("&nbsp;");?></td>
                          <td width="14%"><?php print("&nbsp;");?></td>
                          <td width="18%"><?php if($row22->number) print($row22->number); else print("&nbsp;");?></td>
                          <td width="13%"><?php  if($row22->net_weight) print($row22->net_weight); else print("&nbsp;");?></td>
                          <td width="15%"><?php  if($row22->gross_weight) print($row22->gross_weight); else print("&nbsp;");?></td>
                         <td width="14%"><?php print("&nbsp;");?></td>
                           <td width="15%"><?php  if($row22->gross_weight) print($row22->gross_weight); else print("&nbsp;");?></td>
					</tr>
					<tr>
					<td width="14%" height="19">EMPTY</td>
					
					
						   <td width="14%" height="19"><?php print("&nbsp;");?></td>
                          <td width="14%"><?php  if($row23->number) print($row23->number); else print("&nbsp;");?></td>
                 
                          <td width="18%"><?php if($row23->number) print($row23->number); else print("&nbsp;");?></td>
                          <td width="14%"><?php print("&nbsp;");?></td>
						  <td width="14%"><?php print("&nbsp;");?></td>
                          <td width="15%"><?php if($row23->net_weight) print($row23->net_weight); else print("&nbsp;");?></td>
                    
                           <td width="15%"><?php if($row23->net_weight) print($row23->net_weight); else print("&nbsp;");?></td>
                          
                        </tr>
					<tr>
					<td width="14%" height="19">ICD</td>
					        <td width="14%" height="19"><?php if($row24->number) print($row24->number); else print("&nbsp;");?></td>
                          <td width="14%"><?php print("&nbsp;");?></td>
                          <td width="18%"><?php if($row24->number) print($row24->number); else print("&nbsp;");?></td>
                          <td width="13%"><?php if($row24->net_weight) print($row24->net_weight); else print("&nbsp;");?></td>
                          <td width="15%"><?php if($row24->gross_weight) print($row24->gross_weight); else print("&nbsp;");?></td>
                         <td width="14%"><?php print("&nbsp;");?></td>
                           <td width="15%"><?php if($row24->gross_weight) print($row24->gross_weight); else print("&nbsp;");?></td>
					</tr>
					<tr>
					<td width="14%" height="19">TRANS</td>
					    <td width="14%" height="19"><?php if($row25->number) print($row25->number); else print("&nbsp;");?></td>
                          <td width="14%"><?php print("&nbsp;");?></td>
                          <td width="18%"><?php if($row25->number) print($row25->number); else print("&nbsp;");?></td>
                          <td width="13%"><?php if($row25->net_weight)  print($row25->net_weight); else print("&nbsp;");?></td>
                          <td width="15%"><?php if($row25->gross_weight) print($row25->gross_weight); else print("&nbsp;");?></td>
                         <td width="14%"><?php print("&nbsp;");?></td>
                           <td width="15%"><?php if($row25->gross_weight) print($row25->gross_weight); else print("&nbsp;");?></td>
					</tr>
					<tr>
					<td width="14%" height="19">REFFER</td>
					<td width="14%" height="19">REFR</td>
					<td width="14%"height="19" ><?php if($row26->number) print($row26->number); else print("&nbsp;");?></td>
                          <td width="14%"><?php if($row260->number) print($row260->number); else print("&nbsp;");?></td>
                          <td width="18%"><?php  print($row26->number+$row260->number); ?></td>
                          <td width="13%"><?php  print($row26->net_weight+$row260->net_weight); ?></td>
                          <td width="15%"><?php  print($row26->gross_weight+$row260->gross_weight); ?></td>
                         <td width="14%"><?php print("&nbsp;");?></td>
                           <td width="15%"><?php  print($row26->gross_weight+$row260->gross_weight); ?></td>
					</tr>
					<tr>
						<td width="14%" height="19">IMDG</td>
					<td width="14%" height="19">IMDG</td>
					 <td width="14%" height="19"><?php if($row27->number) print($row27->number); else print("&nbsp;");?></td>
                          <td width="14%"><?php print("&nbsp;");?></td>
                          <td width="18%"><?php if($row27->number) print($row27->number); else print("&nbsp;");?></td>
                          <td width="13%"><?php if($row27->net_weight) print($row27->net_weight); else print("&nbsp;");?></td>
                          <td width="15%"><?php if($row27->gross_weight) print($row27->gross_weight); else print("&nbsp;");?></td>
                         <td width="14%"><?php print("&nbsp;");?></td>
                           <td width="15%"><?php if($row27->gross_weight) print($row27->gross_weight); else print("&nbsp;");?></td>
					</tr>
					<tr>
						<td width="14%" height="19">Subtotal</td>
					   <td width="14%"><?php print("&nbsp;");?></td>
                     
                            <td width="14%" height="19"><?php $total3=$row21->number+$row22->number+$row23->number+$row24->number+$row25->number+$row260->number; print($total3); ?></td>
                         <td width="14%"><?php print("&nbsp;");?></td>
                           <td width="14%"><?php $total6=$row21->number+$row22->number+$row23->number+$row24->number+$row25->number+$row260->number; print($total6); ?></td>
                          <td width="14%"><?php $total9=$row21->net_weight+$row22->net_weight+$row23->net_weight+$row24->net_weight+$row25->net_weight; print($total9); ?></td>
                  <td width="14%"><?php $total12=$row21->gross_weight+$row22->gross_weight+$row23->gross_weight+$row24->gross_weight+$row25->gross_weight; print($total12); ?></td>
                       <td width="14%"><?php print("&nbsp;");?></td>
                       <td width="14%"><?php $total15=$row21->gross_weight+$row22->gross_weight+$row23->gross_weight+$row24->gross_weight+$row25->gross_weight; print($total15); ?></td>
					</tr>
					<tr>
					<td>Total</td><td>&nbsp;</td><td>&nbsp;</td>
                         <td width="10%"><?php $total=$total1+$total2+$total3; print($total);?></td>
                <td>&nbsp;</td>
                  <td width="9%"><?php $total=$total2+$total4+$total6; print($total);?></td>
                  <td width="9%"><?php $total=$total7+$total8+$total9;print($total);?></td>
                  <td width="9%"><?php $total=$total10+$total11+$total12;print($total);?></td>
                  <td width="7%">&nbsp;</td>
				  <td width="9%"><?php $total=$total13+$total14+$total15;print($total);?></td>
                  
                       
					</tr>
					<tr>
					<td>Others Cargo</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
					</tr>
					
                    </table>
					

</TD></TR>
	</TABLE>
<?php
mysql_close($con_cchaportdb);
 if($_POST['options']=='html'){?>		
	</BODY>
</HTML>
<?php }?>



