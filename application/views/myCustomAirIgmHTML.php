<?php







$this->msg=$homemsg;
	  $this->impno=$impno;
	  $this->igm=$igm;
	 $this->lineno=$lineno;
	 $this->impno1=$impno1;
	 $this->blno=$blno;
	// $_SESSION["rot"]=$this->impno;
//$_SESSION["igm"]=$this->igm;
//$rot=$_SESSION["rot"];
//$igm=$_SESSION["igm"];
	 // echo "<br>".$impno."=rot=".$lineno."=Line=".$igm."=igm=".$impno1."=rot2=".$blno."=bol=";
	  if(strlen($this->impno)<=6)
	  {
	  print("<font color=blue size=3><b>please give your rotaion as xxxx/xx<br></b></font>");
	  }
	 // print($_SESSION["rot"]);
	//  print($this->impno);
	   
	if($impno=="")
	//$impno="99999999";
$lineno=trim($lineno);
$start=$_SESSION['start'];
	$mylimit=$_SESSION['mylimit'];

	if($start=="")
	{
	$start=0;	
	}
//$igm=$_POST['igm'];
//print($impno);
//print($igm);

//if($lineno=="")
//$lineno="shahzahan";

//$lineno=str_replace(' ','',$lineno);

//if(($impno!="" and $lineno=="") or ($impno!="" and $lineno!="") )
	if($impno!="" and $lineno!="")
		{
		$sql="select count(*) as cnt from igm_supplimentary_detail where Import_Rotation_No='$impno' and replace(replace(replace(substring_index(`igm_supplimentary_detail`.`Line_No`,_latin1'*',-(1)),_latin1' ',_latin1''),' ',''),'
','')='$lineno'";
		//print($sql."<br>");
		$res_cnt=mysql_query($sql);
		$row_cnt=mysql_fetch_object($res_cnt);
		if ($row_cnt->cnt>0){
			$table='igm_supplimentary_detail';
			$table_con='igm_sup_detail_container';
				
		}
		else {
			$sql="select count(*) as cnt from igm_supplimentary_detail_history where Import_Rotation_No='$impno' and replace(replace(replace(substring_index(`igm_supplimentary_detail_history`.`Line_No`,_latin1'*',-(1)),_latin1' ',_latin1''),' ',''),'
','')='$lineno'";
			$res_cnt=mysql_query($sql);
			$row_cnt=mysql_fetch_object($res_cnt);
			if ($row_cnt->cnt>0){
			$table='igm_supplimentary_detail_history';
			$table_con='igm_sup_detail_container_history';
			}
		}

	 
	 if($table!='')
	
		{
		$str="select igms.igm_detail_id,igms.id as id,igm_master_id as IGM_id,igms.Import_Rotation_No as 
Import_Rotation_No,igms.Line_No as Line_No, igms.BL_No as BL_No,igms.Pack_Number 
as Pack_Number,igms.Pack_Description as Pack_Description,igms.Pack_Marks_Number as 
Pack_Marks_Number, igms.Description_of_Goods as Description_of_Goods,igms.Date_of_Entry_of_Goods 
as Date_of_Entry_of_Goods,igms.weight as weight,igms.weight_unit,igms.net_weight,
igms.net_weight_unit, igms.Bill_of_Entry_No as Bill_of_Entry_No,igms.Bill_of_Entry_Date 
as Bill_of_Entry_Date,igms.office_code,igms.No_of_Pack_Delivered as No_of_Pack_Delivered, igms.No_of_Pack_Discharged 
as No_of_Pack_Discharged,igms.Remarks as Remarks,igms.AFR as AFR,igms.delivery_block_stat as 
deliverbstat,igms.ConsigneeDesc,int_block as int_block,
igms.NotifyDesc,igms.Submitee_Org_Id,null as mlocode,igms.type_of_igm as type_of_igm,
(select Organization_Name from organization_profiles orgs where orgs.id=igms.Submitee_Org_Id) 
as Organization_Name,null as imco,null asun,
igms.Submission_Date as SubmitDate ,'S' as igmtyp from $table igms 
where igms.Import_Rotation_No='$impno' and igms.final_submit=1 and (igms.PFstatus=1 or igms.PFstatus=10) and igms.amendment_appoved<>1  and replace(replace(replace(substring_index(`igms`.`Line_No`,_latin1'*',-(1)),_latin1' ',_latin1''),' ',''),'
','')='$lineno' 
";
		}
	 
	 if($table=='')
	
		{
		 
			//for igm Supplimentary
			$sql="select count(*) as cnt from igm_details where Import_Rotation_No='$impno' and replace(replace(replace(substring_index(`igm_details`.`Line_No`,_latin1'*',-(1)),_latin1' ',_latin1''),' ',''),'
','')='$lineno'";
			//print($sql."<br>");
			$res_cnt=mysql_query($sql);
			$row_cnt=mysql_fetch_object($res_cnt);
			
		  	
			if ($row_cnt->cnt>0) {
				$table='igm_details';
				$table_con='igm_detail_container';
			}
			else{
				$sql="select count(*) as cnt from igm_details_history where Import_Rotation_No='$impno' and replace(replace(replace(substring_index(`igm_details_history`.`Line_No`,_latin1'*',-(1)),_latin1' ',_latin1''),' ',''),'
','')='$lineno'";
				$res_cnt=mysql_query($sql);
				$row_cnt=mysql_fetch_object($res_cnt);
				if ($row_cnt->cnt>0){
				$table='igm_details_history';
				$table_con='igm_detail_container_history';
				}
				else
				{
				print("<font color=red size=3><b>please give your full/correct Line No<br></b></font>");
				
				}
			}
			
			if($table!='')	
			{
			$str="select null as igm_detail_id,igms.id as id,igms.IGM_id as IGM_id,igms.Import_Rotation_No as 
Import_Rotation_No,igms.Line_No as Line_No, igms.BL_No as BL_No,igms.Pack_Number 
as Pack_Number,igms.Pack_Description as Pack_Description,igms.Pack_Marks_Number as 
Pack_Marks_Number, igms.Description_of_Goods as Description_of_Goods,igms.Date_of_Entry_of_Goods 
as Date_of_Entry_of_Goods,igms.weight as weight,igms.weight_unit,igms.net_weight,
igms.net_weight_unit, igms.Bill_of_Entry_No as Bill_of_Entry_No,igms.Bill_of_Entry_Date 
as Bill_of_Entry_Date,igms.office_code,igms.No_of_Pack_Delivered as No_of_Pack_Delivered, igms.No_of_Pack_Discharged 
as No_of_Pack_Discharged,igms.Remarks as Remarks,igms.AFR as AFR,igms.delivery_block_stat as 
deliverbstat,igms.ConsigneeDesc,int_block as int_block,
igms.NotifyDesc,igms.Submitee_Org_Id,igms.mlocode,igms.type_of_igm as type_of_igm,
(select Organization_Name from organization_profiles orgs where orgs.id=igms.Submitee_Org_Id) 
as Organization_Name,imco,un,
igms.Submission_Date as SubmitDate,'I' as igmtyp from $table igms 
where igms.Import_Rotation_No='$impno' and igms.final_submit=1 and (igms.PFstatus=1 or igms.PFstatus=10) and igms.amendment_appoved<>1 and replace(replace(replace(substring_index(`igms`.`Line_No`,_latin1'*',-(1)),_latin1' ',_latin1''),' ',''),'
','')='$lineno'";
			
			}
			
			}
	 
	 }
	 //if($impno!="" and $lineno=="")

      //if(($impno!="" and $lineno=="") or ($impno!="" and $lineno!="") )
	  
	 if($impno1!="" and $blno!="")
		{
		print("With Bl Search");
		$sql="select count(*) as cnt from igm_supplimentary_detail where Import_Rotation_No='$impno1' and replace(replace(replace(substring_index(`igm_supplimentary_detail`.`BL_No`,_latin1'*',-(1)),_latin1' ',_latin1''),' ',''),'
','')='$blno'";
		//print($sql."<br>");
		$res_cnt=mysql_query($sql);
		$row_cnt=mysql_fetch_object($res_cnt);
		if ($row_cnt->cnt>0)
		{
			$table='igm_supplimentary_detail';
			$table_con='igm_sup_detail_container';
		}
		else 
		{
			$sql="select count(*) as cnt from igm_supplimentary_detail_history where Import_Rotation_No='$impno1' and replace(replace(replace(substring_index(`igm_supplimentary_detail_history`.`BL_No`,_latin1'*',-(1)),_latin1' ',_latin1''),' ',''),'
','')='$blno'";
			$res_cnt=mysql_query($sql);
			$row_cnt=mysql_fetch_object($res_cnt);
			if ($row_cnt->cnt>0)
			{
				$table='igm_supplimentary_detail_history';
				$table_con='igm_sup_detail_container_history';
			}
		}

	 
	 if($table!='')
	
		{
		$str="select igms.igm_detail_id,igms.id as id,igm_master_id as IGM_id,igms.Import_Rotation_No as 
Import_Rotation_No,igms.Line_No as Line_No, igms.BL_No as BL_No,igms.Pack_Number 
as Pack_Number,igms.Pack_Description as Pack_Description,igms.Pack_Marks_Number as 
Pack_Marks_Number, igms.Description_of_Goods as Description_of_Goods,igms.Date_of_Entry_of_Goods 
as Date_of_Entry_of_Goods,igms.weight as weight,igms.weight_unit,igms.net_weight,
igms.net_weight_unit, igms.Bill_of_Entry_No as Bill_of_Entry_No,igms.Bill_of_Entry_Date 
as Bill_of_Entry_Date,igms.office_code,igms.No_of_Pack_Delivered as No_of_Pack_Delivered, igms.No_of_Pack_Discharged 
as No_of_Pack_Discharged,igms.Remarks as Remarks,igms.AFR as AFR,igms.delivery_block_stat as 
deliverbstat,igms.ConsigneeDesc,
igms.NotifyDesc,igms.Submitee_Org_Id,null as mlocode,igms.type_of_igm as type_of_igm,
(select Organization_Name from organization_profiles orgs where orgs.id=igms.Submitee_Org_Id) 
as Organization_Name,null as imco,null asun,
igms.Submission_Date as SubmitDate ,'S' as igmtyp from $table igms 
where igms.Import_Rotation_No='$impno1' and igms.final_submit=1 and (igms.PFstatus=1 or igms.PFstatus=10) and igms.amendment_appoved<>1  and replace(replace(replace(substring_index(`igms`.`BL_No`,_latin1'*',-(1)),_latin1' ',_latin1''),' ',''),'
','')='$blno' 
";
		}
	 
	 if($table=='')
	
		{
		 
			//for igm Supplimentary
			$sql="select count(*) as cnt from igm_details where Import_Rotation_No='$impno1' and replace(replace(replace(substring_index(`igm_details`.`BL_No`,_latin1'*',-(1)),_latin1' ',_latin1''),' ',''),'
','')='$blno'";
			//print($sql."<br>");
			$res_cnt=mysql_query($sql);
			$row_cnt=mysql_fetch_object($res_cnt);
			
		  	
			if ($row_cnt->cnt>0) 
			{
				$table='igm_details';
				$table_con='igm_detail_container';
			}
			else
			{
				$sql="select count(*) as cnt from igm_details_history where Import_Rotation_No='$impno1' and replace(replace(replace(substring_index(`igm_details_history`.`BL_No`,_latin1'*',-(1)),_latin1' ',_latin1''),' ',''),'
','')='$blno'";
				$res_cnt=mysql_query($sql);
				$row_cnt=mysql_fetch_object($res_cnt);
				if ($row_cnt->cnt>0){
				$table='igm_details_history';
				$table_con='igm_detail_container_history';
				}
				else
				{
				//print("<font color=red size=3><b>please give your full/correct BL No<br></b></font>");
				
				}
			}
			
			if($table!='')	
			{
			$str="select null as igm_detail_id,igms.id as id,igms.IGM_id as IGM_id,igms.Import_Rotation_No as 
Import_Rotation_No,igms.Line_No as Line_No, igms.BL_No as BL_No,igms.Pack_Number 
as Pack_Number,igms.Pack_Description as Pack_Description,igms.Pack_Marks_Number as 
Pack_Marks_Number, igms.Description_of_Goods as Description_of_Goods,igms.Date_of_Entry_of_Goods 
as Date_of_Entry_of_Goods,igms.weight as weight,igms.weight_unit,igms.net_weight,
igms.net_weight_unit, igms.Bill_of_Entry_No as Bill_of_Entry_No,igms.Bill_of_Entry_Date 
as Bill_of_Entry_Date,igms.office_code,igms.No_of_Pack_Delivered as No_of_Pack_Delivered, igms.No_of_Pack_Discharged 
as No_of_Pack_Discharged,igms.Remarks as Remarks,igms.AFR as AFR,igms.delivery_block_stat as 
deliverbstat,igms.ConsigneeDesc,
igms.NotifyDesc,igms.Submitee_Org_Id,igms.mlocode,igms.type_of_igm as type_of_igm,
(select Organization_Name from organization_profiles orgs where orgs.id=igms.Submitee_Org_Id) 
as Organization_Name,imco,un,
igms.Submission_Date as SubmitDate,'I' as igmtyp from $table igms 
where igms.Import_Rotation_No='$impno1' and igms.final_submit=1 and (igms.PFstatus=1 or igms.PFstatus=10) and igms.amendment_appoved<>1 and replace(replace(replace(substring_index(`igms`.`BL_No`,_latin1'*',-(1)),_latin1' ',_latin1''),' ',''),'
','')='$blno'";
			
			}
			}
	 }
	 
	 
 
       if($impno!="" and $lineno=="")

	 {
	 if($igm=="igm")
	 {
       // print($igm."aaa");
	/*$mySQL="select null as igm_detail_id,igms.id as id,igms.IGM_id as IGM_id,igms.Import_Rotation_No as 
Import_Rotation_No,igms.Line_No as Line_No, igms.BL_No as BL_No,igms.Pack_Number 
as Pack_Number,igms.Pack_Description as Pack_Description,igms.Pack_Marks_Number as 
Pack_Marks_Number, igms.Description_of_Goods as Description_of_Goods,igms.Date_of_Entry_of_Goods 
as Date_of_Entry_of_Goods,igms.weight as weight,igms.weight_unit,igms.net_weight,
igms.net_weight_unit, igms.Bill_of_Entry_No as Bill_of_Entry_No,igms.Bill_of_Entry_Date 
as Bill_of_Entry_Date,igms.office_code,igms.No_of_Pack_Delivered as No_of_Pack_Delivered, igms.No_of_Pack_Discharged 
as No_of_Pack_Discharged,igms.Remarks as Remarks,igms.AFR as AFR,igms.ConsigneeDesc,
igms.NotifyDesc,igms.Submitee_Org_Id,igms.mlocode,igms.type_of_igm as type_of_igm,
(select Organization_Name from organization_profiles orgs where orgs.id=igms.Submitee_Org_Id) 
as Organization_Name,imco,un,
igms.Submission_Date as SubmitDate,'I' as igmtyp from igm_details igms 
where igms.Import_Rotation_No like '$impno%' and igms.final_submit=1 and (igms.PFstatus=1 or igms.PFstatus=10) and igms.amendment_appoved<>1 and igms.Line_No like '%$lineno%'
union
select null as igm_detail_id,igms.id as id,igms.IGM_id as IGM_id,igms.Import_Rotation_No as 
Import_Rotation_No,igms.Line_No as Line_No, igms.BL_No as BL_No,igms.Pack_Number 
as Pack_Number,igms.Pack_Description as Pack_Description,igms.Pack_Marks_Number as 
Pack_Marks_Number, igms.Description_of_Goods as Description_of_Goods,igms.Date_of_Entry_of_Goods 
as Date_of_Entry_of_Goods,igms.weight as weight,igms.weight_unit,igms.net_weight,
igms.net_weight_unit, igms.Bill_of_Entry_No as Bill_of_Entry_No,igms.Bill_of_Entry_Date 
as Bill_of_Entry_Date,igms.office_code,igms.No_of_Pack_Delivered as No_of_Pack_Delivered, igms.No_of_Pack_Discharged 
as No_of_Pack_Discharged,igms.Remarks as Remarks,igms.AFR as AFR,igms.ConsigneeDesc,
igms.NotifyDesc,igms.Submitee_Org_Id,igms.mlocode,igms.type_of_igm as type_of_igm,
(select Organization_Name from organization_profiles orgs where orgs.id=igms.Submitee_Org_Id) 
as Organization_Name,imco,un,
igms.Submission_Date as SubmitDate,'I' as igmtyp from igm_details_history igms 
where igms.Import_Rotation_No='$impno' and igms.final_submit=1 and (igms.PFstatus=1 or igms.PFstatus=10) and igms.amendment_appoved<>1 and igms.Line_No like '%$lineno%'";
	;
	 */
	 $str="select null as igm_detail_id,igms.id as id,igms.IGM_id as IGM_id,igms.Import_Rotation_No as 
Import_Rotation_No,igms.Line_No as Line_No, igms.BL_No as BL_No,igms.Pack_Number 
as Pack_Number,igms.Pack_Description as Pack_Description,igms.Pack_Marks_Number as 
Pack_Marks_Number, igms.Description_of_Goods as Description_of_Goods,igms.Date_of_Entry_of_Goods 
as Date_of_Entry_of_Goods,igms.weight as weight,igms.weight_unit,igms.net_weight,
igms.net_weight_unit, igms.Bill_of_Entry_No as Bill_of_Entry_No,igms.Bill_of_Entry_Date 
as Bill_of_Entry_Date,igms.office_code,igms.No_of_Pack_Delivered as No_of_Pack_Delivered, igms.No_of_Pack_Discharged 
as No_of_Pack_Discharged,igms.Remarks as Remarks,igms.int_block as int_block,igms.AFR as AFR,igms.delivery_block_stat as deliverbstat,igms.ConsigneeDesc,
igms.NotifyDesc,igms.Submitee_Org_Id,igms.mlocode,igms.type_of_igm as type_of_igm,
(select Organization_Name from organization_profiles orgs where orgs.id=igms.Submitee_Org_Id) 
as Organization_Name,imco,un,
igms.Submission_Date as SubmitDate,'I' as igmtyp from igm_details igms left join igm_supplimentary_detail on igm_supplimentary_detail.igm_detail_id=igms.id
where igms.Import_Rotation_No='$impno' and igms.final_submit=1 and (igms.PFstatus=1 or igms.PFstatus=10) and igms.amendment_appoved<>1  and igm_supplimentary_detail.igm_detail_id is null
 ";
	 }
	 else if($igm=="suppl")
	 {
	//print($igm."bbb");

	/* $mySQL="
select igms.igm_detail_id,igms.id as id,null as IGM_id,igms.Import_Rotation_No as 
Import_Rotation_No,igms.Line_No as Line_No, igms.BL_No as BL_No,igms.Pack_Number 
as Pack_Number,igms.Pack_Description as Pack_Description,igms.Pack_Marks_Number as 
Pack_Marks_Number, igms.Description_of_Goods as Description_of_Goods,igms.Date_of_Entry_of_Goods 
as Date_of_Entry_of_Goods,igms.weight as weight,igms.weight_unit,igms.net_weight,
igms.net_weight_unit, igms.Bill_of_Entry_No as Bill_of_Entry_No,igms.Bill_of_Entry_Date 
as Bill_of_Entry_Date,igms.office_code,igms.No_of_Pack_Delivered as No_of_Pack_Delivered, igms.No_of_Pack_Discharged 
as No_of_Pack_Discharged,igms.Remarks as Remarks,igms.AFR as AFR,igms.ConsigneeDesc,
igms.NotifyDesc,igms.Submitee_Org_Id,null as mlocode,igms.type_of_igm as type_of_igm,
(select Organization_Name from organization_profiles orgs where orgs.id=igms.Submitee_Org_Id) 
as Organization_Name,null as imco,null asun,
igms.Submission_Date as SubmitDate ,'S' as igmtyp from igm_supplimentary_detail igms 
where igms.Import_Rotation_No like '$impno%' and igms.final_submit=1 and (igms.PFstatus=1 or igms.PFstatus=10) and igms.amendment_appoved<>1  and igms.Line_No like '%$lineno%' 
union
select igms.igm_detail_id,igms.id as id,null as IGM_id,igms.Import_Rotation_No as 
Import_Rotation_No,igms.Line_No as Line_No, igms.BL_No as BL_No,igms.Pack_Number 
as Pack_Number,igms.Pack_Description as Pack_Description,igms.Pack_Marks_Number as 
Pack_Marks_Number, igms.Description_of_Goods as Description_of_Goods,igms.Date_of_Entry_of_Goods 
as Date_of_Entry_of_Goods,igms.weight as weight,igms.weight_unit,igms.net_weight,
igms.net_weight_unit, igms.Bill_of_Entry_No as Bill_of_Entry_No,igms.Bill_of_Entry_Date 
as Bill_of_Entry_Date,igms.office_code,igms.No_of_Pack_Delivered as No_of_Pack_Delivered, igms.No_of_Pack_Discharged 
as No_of_Pack_Discharged,igms.Remarks as Remarks,igms.AFR as AFR,igms.ConsigneeDesc,
igms.NotifyDesc,igms.Submitee_Org_Id,null as mlocode,igms.type_of_igm as type_of_igm,
(select Organization_Name from organization_profiles orgs where orgs.id=igms.Submitee_Org_Id) 
as Organization_Name,null as imco,null asun,
igms.Submission_Date as SubmitDate ,'S' as igmtyp from igm_supplimentary_detail_history igms 
where igms.Import_Rotation_No='$impno' and igms.final_submit=1 and (igms.PFstatus=1 or igms.PFstatus=10) and igms.amendment_appoved<>1  and igms.Line_No like '%$lineno%' 
";*/
	// print($mySQL);
	 $str="
select igms.igm_detail_id,igms.id as id,igm_master_id as IGM_id,igms.Import_Rotation_No as 
Import_Rotation_No,igms.Line_No as Line_No, igms.BL_No as BL_No,igms.Pack_Number 
as Pack_Number,igms.Pack_Description as Pack_Description,igms.Pack_Marks_Number as 
Pack_Marks_Number, igms.Description_of_Goods as Description_of_Goods,igms.Date_of_Entry_of_Goods 
as Date_of_Entry_of_Goods,igms.weight as weight,igms.weight_unit,igms.net_weight,
igms.net_weight_unit, igms.Bill_of_Entry_No as Bill_of_Entry_No,igms.Bill_of_Entry_Date 
as Bill_of_Entry_Date,igms.office_code,igms.No_of_Pack_Delivered as No_of_Pack_Delivered, igms.No_of_Pack_Discharged 
as No_of_Pack_Discharged,igms.Remarks as Remarks,igms.int_block as int_block,igms.AFR as AFR,igms.delivery_block_stat as deliverbstat,igms.ConsigneeDesc,
igms.NotifyDesc,igms.Submitee_Org_Id,null as mlocode,igms.type_of_igm as type_of_igm,
(select Organization_Name from organization_profiles orgs where orgs.id=igms.Submitee_Org_Id) 
as Organization_Name,null as imco,null asun,
igms.Submission_Date as SubmitDate ,'S' as igmtyp from igm_supplimentary_detail igms 
where igms.Import_Rotation_No='$impno' and igms.final_submit=1 and (igms.PFstatus=1 or igms.PFstatus=10) and igms.amendment_appoved<>1   
     
";
	 }
	
	 else{
	 print("<font color=red size=3><strong>Select the IGM Type</strong></font>");
	 }
	 }
		//print ($str);
	 $result=mysql_query("$str");
	 include("myCustomAirIgmCheckHTML.php");
	 ?>