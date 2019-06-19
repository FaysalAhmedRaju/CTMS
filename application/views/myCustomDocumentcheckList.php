
	
	
		<?php
		include_once("mydbPConnection.php");
//mysql_close();
//include_once("mydbClientconnect.php");

//include_once("myCustomDocumentcheckHTML.php");
$org_Type_id=$_SESSION['org_Type_id'];
$login_id=$_SESSION['login_id'];

//$txt_imp_rot1=$_REQUEST['$txt_imp_rot1'];
//$txt_imp_rot=$_REQUEST['$txt_imp_rot'];
//$txt_bl=$_REQUEST['$txt_bl'];
//$txt_line=$_REQUEST['$txt_line'];




if ($txt_bl != '' and $txt_imp_rot1!='') 
{
	$sqlMaster=mysql_query("select file_clearence_date from igm_masters where Import_Rotation_No='$txt_imp_rot1'");
	$rowMaster=mysql_fetch_object($sqlMaster);
	//print($rowMaster->file_clearence_date."<hr>");
	/*if(!($_SESSION['Control_Panel']==10 or $_SESSION['Control_Panel']==12 or $_SESSION['Control_Panel']==44)){
	if($rowMaster->file_clearence_date>"2013-09-02")
	{
		print("<font color='red' size='4'>According to customs decision, you can not view any IGM  after final entry completion from 2013-09-02...</font>");
		//include_once("myCustomDocumentcheckHTML.php");
		break;
	}	
}*/	
		
			
			
			$sql="
			select igms.IGM_id as master_id,igms.id as id,igms.Import_Rotation_No as Import_Rotation_No,
					igms.Line_No as Line_No,
					igms.BL_No as BL_No,
					
					igms.office_code,
					igms.Pack_Number as Pack_Number,
					igms.Pack_Description as Pack_Description,
					igms.Pack_Marks_Number as Pack_Marks_Number,
					igms.Description_of_Goods as Description_of_Goods,
					igms.Submission_Date,
					igms.Date_of_Entry_of_Goods as Date_of_Entry_of_Goods,
					igms.weight as weight,
					igms.weight_unit,igms.net_weight,
					igms.net_weight_unit,
					igms.Bill_of_Entry_No as Bill_of_Entry_No,
					igms.Bill_of_Entry_Date as Bill_of_Entry_Date,
					igms.No_of_Pack_Delivered as No_of_Pack_Delivered,igms.AFR,igms.delivery_block_stat,igms.int_block,
							igms.No_of_Pack_Discharged as No_of_Pack_Discharged,igms.Remarks as Remarks,igms.ConsigneeDesc,
							igms.NotifyDesc,igms.Submitee_Org_Id,'D' as igm_type,BE_Status as 
							BE_Status,R_No as R_No,R_Date as R_Date,amendment_appoved,igms.PFstatus from igm_details 
							igms where igms.Import_Rotation_No='$txt_imp_rot1' and 
					replace(replace(igms.BL_No,' ',''),'
','')='$txt_bl' and final_submit='1'
			";
			
		//	print($sql."<hr>");
			$res_cnt=mysql_query($sql);
			$row_cnt=mysql_num_rows($res_cnt);
		//	print($row_cnt);
		  	
			if ($row_cnt>0) {
				$table='igm_details';
				$table_con='igm_detail_container';
				$table_navy='igm_navy_response';
			}
			else {
				
	
		$sql="select igms.igm_master_id as master_id,igms.id as id,igms.Import_Rotation_No as Import_Rotation_No,igms.Line_No as Line_No,
		igms.BL_No as BL_No, igms.office_code,igms.Pack_Number as Pack_Number,
		igms.Pack_Description as Pack_Description,igms.Pack_Marks_Number as Pack_Marks_Number,
		igms.Description_of_Goods as Description_of_Goods,igms.Submission_Date,
		igms.Date_of_Entry_of_Goods as Date_of_Entry_of_Goods,igms.weight as weight,igms.weight_unit,
		igms.net_weight,igms.net_weight_unit,igms.Bill_of_Entry_No as Bill_of_Entry_No,
		igms.Bill_of_Entry_Date as Bill_of_Entry_Date,igms.No_of_Pack_Delivered as No_of_Pack_Delivered,
		igms.AFR,igms.delivery_block_stat,igms.int_block,igms.No_of_Pack_Discharged as No_of_Pack_Discharged,igms.Remarks as Remarks,igms.ConsigneeDesc,
		igms.NotifyDesc,igms.Submitee_Org_Id,'S' as igm_type,BE_Status as BE_Status,
		R_No as R_No,R_Date as R_Date,amendment_appoved,igms.PFstatus  from igm_supplimentary_detail igms 
		where igms.Import_Rotation_No='$txt_imp_rot1' and replace(replace(replace(substring_index(`igms`.`BL_No`,_latin1'*',-(1)),_latin1' ',_latin1''),' ',''),'
','')='$txt_bl' and final_submit='1'";
	
		
//print($sql."<hr>");
		$res_cnt=mysql_query($sql);
		$row_cnt=mysql_num_rows($res_cnt);
		//print($row_cnt);
		if ($row_cnt>0){
			$table='igm_supplimentary_detail';
			$table_con='igm_sup_detail_container';
			$table_navy='igm_navy_response';
				
		}
			
			}	
				
	if($table=='')
	
		{
		
				$sql="
				select igms.IGM_id as master_id,igms.id as id,igms.Import_Rotation_No as Import_Rotation_No,
					igms.Line_No as Line_No,
					igms.BL_No as BL_No,
					
					igms.office_code,
					igms.Pack_Number as Pack_Number,
					igms.Pack_Description as Pack_Description,
					igms.Pack_Marks_Number as Pack_Marks_Number,
					igms.Description_of_Goods as Description_of_Goods,
					igms.Submission_Date,
					igms.Date_of_Entry_of_Goods as Date_of_Entry_of_Goods,
					igms.weight as weight,
					igms.weight_unit,igms.net_weight,
					igms.net_weight_unit,
					igms.Bill_of_Entry_No as Bill_of_Entry_No,
					igms.Bill_of_Entry_Date as Bill_of_Entry_Date,
					igms.No_of_Pack_Delivered as No_of_Pack_Delivered,igms.AFR,igms.delivery_block_stat,igms.int_block,
							igms.No_of_Pack_Discharged as No_of_Pack_Discharged,igms.Remarks as Remarks,igms.ConsigneeDesc,
							igms.NotifyDesc,igms.Submitee_Org_Id,'D' as igm_type,BE_Status as 
							BE_Status,R_No as R_No,R_Date as R_Date,amendment_appoved,igms.PFstatus,'h' as history from igm_details_history 
							igms where igms.Import_Rotation_No='$txt_imp_rot1' and 
					replace(replace(igms.BL_No,' ',''),'
','')='$txt_bl' and final_submit='1'";
			
		//		print($sql."<hr>");
				$res_cnt=mysql_query($sql);
				$row_cnt=mysql_num_rows($res_cnt);
		//	print($row_cnt);
			if ($row_cnt>0){
				$table='igm_details_history';
				$table_con='igm_detail_container_history';
				$table_navy='igm_navy_response_history';
				}
	
		else {
		
		
			$sql="select igms.igm_master_id as master_id,igms.id as id,igms.Import_Rotation_No as Import_Rotation_No,igms.Line_No as Line_No,
			igms.BL_No as BL_No, igms.office_code,igms.Pack_Number as Pack_Number,
			igms.Pack_Description as Pack_Description,igms.Pack_Marks_Number as Pack_Marks_Number,
			igms.Description_of_Goods as Description_of_Goods,igms.Submission_Date,
			igms.Date_of_Entry_of_Goods as Date_of_Entry_of_Goods,igms.weight as weight,igms.weight_unit,
			igms.net_weight,igms.net_weight_unit,igms.Bill_of_Entry_No as Bill_of_Entry_No,
			igms.Bill_of_Entry_Date as Bill_of_Entry_Date,igms.No_of_Pack_Delivered as No_of_Pack_Delivered,
			igms.AFR,igms.delivery_block_stat,igms.int_block,igms.No_of_Pack_Discharged as No_of_Pack_Discharged,igms.Remarks as Remarks,
			igms.ConsigneeDesc,igms.NotifyDesc,igms.Submitee_Org_Id,'S' as igm_type,BE_Status as BE_Status,
			R_No as R_No,R_Date as R_Date,amendment_appoved,igms.PFstatus,'h' as history  from igm_supplimentary_detail_history 
			igms where igms.Import_Rotation_No='$txt_imp_rot1' and replace(replace(replace(substring_index(`igms`.`BL_No`,_latin1'*',-(1)),_latin1' ',_latin1''),' ',''),'
','')='$txt_bl' and final_submit='1'";
			
			
		//	print($sql."<hr>");
			$res_cnt=mysql_query($sql);
			$row_cnt=mysql_num_rows($res_cnt);
		//	print($row_cnt);
			if ($row_cnt>0){
			$table='igm_supplimentary_detail_history';
			$table_con='igm_sup_detail_container_history';
			$table_navy='igm_navy_response_history';
			}
		}

	
		 
			//for igm not found
		
				if($row_cnt<="0")
				print("You have select your full/correct BL No");
				//print("ershad".$table."ershad");
				
	
		}	
	

}

						
							
else if(($txt_line != '' and $txt_imp_rot!=''))
{

$sqlMaster=mysql_query("select file_clearence_date from igm_masters where Import_Rotation_No='$txt_imp_rot'");
	$rowMaster=mysql_fetch_object($sqlMaster);
	//print($rowMaster->file_clearence_date."<hr>");
	/*if(!($_SESSION['Control_Panel']==10 or $_SESSION['Control_Panel']==12 or $_SESSION['Control_Panel']==44)){
	if($rowMaster->file_clearence_date>"2013-09-02")
	{
		print("<font color='red' size='4'>According to customs decision, you can not view any IGM  after final entry completion from 2013-09-02...</font>");
		//include_once("myCustomDocumentcheckHTML.php");
		break;
	}	
}*/	

		
		$no=count(explode("-",$txt_line));
		//print($no."<hr>");
			if($no=='1' or $no=='2')
			{
	
			$sql="
			select igms.IGM_id as master_id,igms.id as id,igms.Import_Rotation_No as Import_Rotation_No,
				igms.Line_No as Line_No,
				igms.BL_No as BL_No,
				
				igms.office_code,
				igms.Pack_Number as Pack_Number,
				igms.Pack_Description as Pack_Description,
				igms.Pack_Marks_Number as Pack_Marks_Number,
				igms.Description_of_Goods as Description_of_Goods,
				igms.Submission_Date,
				igms.Date_of_Entry_of_Goods as Date_of_Entry_of_Goods,
				igms.weight as weight,
				igms.weight_unit,igms.net_weight,
				igms.net_weight_unit,
				igms.Bill_of_Entry_No as Bill_of_Entry_No,
				igms.Bill_of_Entry_Date as Bill_of_Entry_Date,
				igms.No_of_Pack_Delivered as No_of_Pack_Delivered,igms.AFR,igms.delivery_block_stat,igms.int_block,
						igms.No_of_Pack_Discharged as No_of_Pack_Discharged,igms.Remarks as Remarks,igms.ConsigneeDesc,
						igms.NotifyDesc,igms.Submitee_Org_Id,'D' as igm_type,BE_Status as BE_Status,R_No as R_No,
						R_Date as R_Date,amendment_appoved,
						igms.PFstatus  from igm_details igms where 
						igms.Import_Rotation_No='$txt_imp_rot' and replace(replace(igms.Line_No,' ',''),'
','')='$txt_line' and final_submit='1'
			";
			
	//print($sql."<hr>");
	$res_cnt=mysql_query($sql);
	//print($res_cnt."<hr>");
	$row_cnt=mysql_num_rows($res_cnt);
	//print($row_cnt."<hr>");
  	
	if ($row_cnt>0) {
		$table='igm_details';
		$table_con='igm_detail_container';
		$table_navy='igm_navy_response';
		//print($table."<hr>");
		
	}
	else {
	
	
		
			$sql="
			select igms.igm_master_id as master_id,igms.id as id,igms.Import_Rotation_No as Import_Rotation_No,igms.Line_No as Line_No,
			igms.BL_No as BL_No,igms.office_code,igms.Pack_Number as Pack_Number,
			igms.Pack_Description as Pack_Description,igms.Pack_Marks_Number as Pack_Marks_Number,
			igms.Description_of_Goods as Description_of_Goods,igms.Submission_Date,
			igms.Date_of_Entry_of_Goods as Date_of_Entry_of_Goods,
			igms.weight as weight,igms.weight_unit,igms.net_weight,igms.net_weight_unit,igms.Bill_of_Entry_No as
			Bill_of_Entry_No,igms.Bill_of_Entry_Date as Bill_of_Entry_Date,igms.No_of_Pack_Delivered 
			as No_of_Pack_Delivered,igms.AFR,igms.delivery_block_stat,igms.int_block,
			igms.No_of_Pack_Discharged as No_of_Pack_Discharged,igms.Remarks as Remarks,igms.ConsigneeDesc,
			igms.NotifyDesc,igms.Submitee_Org_Id,'S' as igm_type,BE_Status as BE_Status,
			R_No as R_No,R_Date as R_Date,amendment_appoved,
						igms.PFstatus  from igm_supplimentary_detail igms
						where igms.Import_Rotation_No='$txt_imp_rot' and replace(replace(replace(substring_index(`igms`.`Line_No`,_latin1'*',-(1)),_latin1' ',_latin1''),' ',''),'
','')='$txt_line' and final_submit='1'
			";
			
			//print($sql."<hr>");
 			$res_cnt=mysql_query($sql);
			//print($res_cnt);
			$row_cnt=mysql_num_rows($res_cnt);
			if ($row_cnt>0){
				$table='igm_supplimentary_detail';
				$table_con='igm_sup_detail_container';
				$table_navy='igm_navy_response';
				
			}
				
	}	
	
	}
		if($no=='3' or $no=='4' or $no=='5' or $no=='6')
			{
	$sql="
			select igms.igm_master_id as master_id,igms.id as id,igms.Import_Rotation_No as Import_Rotation_No,igms.Line_No as Line_No,
			igms.BL_No as BL_No,igms.office_code,igms.Pack_Number as Pack_Number,
			igms.Pack_Description as Pack_Description,igms.Pack_Marks_Number as Pack_Marks_Number,
			igms.Description_of_Goods as Description_of_Goods,igms.Submission_Date,
			igms.Date_of_Entry_of_Goods as Date_of_Entry_of_Goods,
			igms.weight as weight,igms.weight_unit,igms.net_weight,igms.net_weight_unit,igms.Bill_of_Entry_No as
			Bill_of_Entry_No,igms.Bill_of_Entry_Date as Bill_of_Entry_Date,igms.No_of_Pack_Delivered 
			as No_of_Pack_Delivered,igms.AFR,igms.delivery_block_stat,igms.int_block,
			igms.No_of_Pack_Discharged as No_of_Pack_Discharged,igms.Remarks as Remarks,igms.ConsigneeDesc,
			igms.NotifyDesc,igms.Submitee_Org_Id,'S' as igm_type,BE_Status as BE_Status,
			R_No as R_No,R_Date as R_Date,amendment_appoved,
						igms.PFstatus  from igm_supplimentary_detail igms
						where igms.Import_Rotation_No='$txt_imp_rot' and replace(replace(replace(substring_index(`igms`.`Line_No`,_latin1'*',-(1)),_latin1' ',_latin1''),' ',''),'
','')='$txt_line' and final_submit='1'
			";
			
			//print($sql."<hr>");
 			$res_cnt=mysql_query($sql);
			$row_cnt=mysql_num_rows($res_cnt);
			if ($row_cnt>0){
				$table='igm_supplimentary_detail';
				$table_con='igm_sup_detail_container';
				$table_navy='igm_navy_response';
				
			}
			
	else {
	
	$sql="
			select igms.IGM_id as master_id,igms.id as id,igms.Import_Rotation_No as Import_Rotation_No,
				igms.Line_No as Line_No,
				igms.BL_No as BL_No,
				
				igms.office_code,
				igms.Pack_Number as Pack_Number,
				igms.Pack_Description as Pack_Description,
				igms.Pack_Marks_Number as Pack_Marks_Number,
				igms.Description_of_Goods as Description_of_Goods,
				igms.Submission_Date,
				igms.Date_of_Entry_of_Goods as Date_of_Entry_of_Goods,
				igms.weight as weight,
				igms.weight_unit,igms.net_weight,
				igms.net_weight_unit,
				igms.Bill_of_Entry_No as Bill_of_Entry_No,
				igms.Bill_of_Entry_Date as Bill_of_Entry_Date,
				igms.No_of_Pack_Delivered as No_of_Pack_Delivered,igms.AFR,igms.delivery_block_stat,igms.int_block,
						igms.No_of_Pack_Discharged as No_of_Pack_Discharged,igms.Remarks as Remarks,igms.ConsigneeDesc,
						igms.NotifyDesc,igms.Submitee_Org_Id,'D' as igm_type,BE_Status as BE_Status,R_No as R_No,
						R_Date as R_Date,amendment_appoved,
						igms.PFstatus  from igm_details igms where 
						igms.Import_Rotation_No='$txt_imp_rot' and replace(replace(igms.Line_No,' ',''),'
','')='$txt_line' and final_submit='1'
			";
			
	//print($sql."<hr>");
	$res_cnt=mysql_query($sql);
	$row_cnt=mysql_num_rows($res_cnt);
	
  	
	if ($row_cnt>0) {
		$table='igm_details';
		$table_con='igm_detail_container';
		$table_navy='igm_navy_response';
		
		
	}
		
			
				
	}	
	
	}
		
	if($table=='')
	
		{
		 
			//for igm history
			if($no=='1' or $no=='2')
			{
			
			$sql="
				select igms.IGM_id as master_id,igms.id as id,igms.Import_Rotation_No as Import_Rotation_No,
				igms.Line_No as Line_No,
				igms.BL_No as BL_No,
				
				igms.office_code,
				igms.Pack_Number as Pack_Number,
				igms.Pack_Description as Pack_Description,
				igms.Pack_Marks_Number as Pack_Marks_Number,
				igms.Description_of_Goods as Description_of_Goods,
				igms.Submission_Date,
				igms.Date_of_Entry_of_Goods as Date_of_Entry_of_Goods,
				igms.weight as weight,
				igms.weight_unit,igms.net_weight,
				igms.net_weight_unit,
				igms.Bill_of_Entry_No as Bill_of_Entry_No,
				igms.Bill_of_Entry_Date as Bill_of_Entry_Date,
				igms.No_of_Pack_Delivered as No_of_Pack_Delivered,igms.AFR,igms.delivery_block_stat,igms.int_block,
						igms.No_of_Pack_Discharged as No_of_Pack_Discharged,igms.Remarks as Remarks,igms.ConsigneeDesc,
						igms.NotifyDesc,igms.Submitee_Org_Id,'D' as igm_type,BE_Status as BE_Status,R_No as R_No,
						R_Date as R_Date,amendment_appoved,
						igms.PFstatus,'h' as history  from igm_details_history igms where 
						igms.Import_Rotation_No='$txt_imp_rot' and replace(replace(igms.Line_No,' ',''),'
','')='$txt_line' and final_submit='1'";
		//print($sql."<hr>");		
		$res_cnt=mysql_query($sql);
		$row_cnt=mysql_num_rows($res_cnt);
		if ($row_cnt>0){
		$table='igm_details_history';
		$table_con='igm_detail_container_history';
		$table_navy='igm_navy_response_history';
		}
		
			else {
			
						
				$sql="select igms.igm_master_id as master_id,igms.id as id,igms.Import_Rotation_No as Import_Rotation_No,igms.Line_No as Line_No,
			igms.BL_No as BL_No,igms.office_code,igms.Pack_Number as Pack_Number,
			igms.Pack_Description as Pack_Description,igms.Pack_Marks_Number as Pack_Marks_Number,
			igms.Description_of_Goods as Description_of_Goods,igms.Submission_Date,
			igms.Date_of_Entry_of_Goods as Date_of_Entry_of_Goods,
			igms.weight as weight,igms.weight_unit,igms.net_weight,igms.net_weight_unit,igms.Bill_of_Entry_No as
			Bill_of_Entry_No,igms.Bill_of_Entry_Date as Bill_of_Entry_Date,igms.No_of_Pack_Delivered 
			as No_of_Pack_Delivered,igms.AFR,igms.delivery_block_stat,igms.int_block,
			igms.No_of_Pack_Discharged as No_of_Pack_Discharged,igms.Remarks as Remarks,igms.ConsigneeDesc,
			igms.NotifyDesc,igms.Submitee_Org_Id,'S' as igm_type,BE_Status as BE_Status,
			R_No as R_No,R_Date as R_Date,amendment_appoved,
						igms.PFstatus,'h' as history  from igm_supplimentary_detail_history igms
						where igms.Import_Rotation_No='$txt_imp_rot' and replace(replace(replace(substring_index(`igms`.`Line_No`,_latin1'*',-(1)),_latin1' ',_latin1''),' ',''),'
','')='$txt_line' and final_submit='1'";
						
				//print($sql."<hr>");
				$res_cnt=mysql_query($sql);
				$row_cnt=mysql_num_rows($res_cnt);
				if ($row_cnt>0){
				$table='igm_supplimentary_detail_history';
				$table_con='igm_sup_detail_container_history';
				$table_navy='igm_navy_response_history';
				}
			}

}
	if($no=='3' or $no=='4' or $no=='5' or $no=='6')
			{
			
			
					
				$sql="select igms.igm_master_id as master_id,igms.id as id,igms.Import_Rotation_No as Import_Rotation_No,igms.Line_No as Line_No,
			igms.BL_No as BL_No,igms.office_code,igms.Pack_Number as Pack_Number,
			igms.Pack_Description as Pack_Description,igms.Pack_Marks_Number as Pack_Marks_Number,
			igms.Description_of_Goods as Description_of_Goods,igms.Submission_Date,
			igms.Date_of_Entry_of_Goods as Date_of_Entry_of_Goods,
			igms.weight as weight,igms.weight_unit,igms.net_weight,igms.net_weight_unit,igms.Bill_of_Entry_No as
			Bill_of_Entry_No,igms.Bill_of_Entry_Date as Bill_of_Entry_Date,igms.No_of_Pack_Delivered 
			as No_of_Pack_Delivered,igms.AFR,igms.delivery_block_stat,igms.int_block,
			igms.No_of_Pack_Discharged as No_of_Pack_Discharged,igms.Remarks as Remarks,igms.ConsigneeDesc,
			igms.NotifyDesc,igms.Submitee_Org_Id,'S' as igm_type,BE_Status as BE_Status,
			R_No as R_No,R_Date as R_Date,amendment_appoved,
						igms.PFstatus,'h' as history  from igm_supplimentary_detail_history igms
						where igms.Import_Rotation_No='$txt_imp_rot' and replace(replace(replace(substring_index(`igms`.`Line_No`,_latin1'*',-(1)),_latin1' ',_latin1''),' ',''),'
','')='$txt_line' and final_submit='1'";
						
			//	print($sql."<hr>");
				$res_cnt=mysql_query($sql);
				$row_cnt=mysql_num_rows($res_cnt);
				if ($row_cnt>0){
				$table='igm_supplimentary_detail_history';
				$table_con='igm_sup_detail_container_history';
				$table_navy='igm_navy_response_history';
				}
		
			else {
			
				$sql="
				select igms.IGM_id as master_id,igms.id as id,igms.Import_Rotation_No as Import_Rotation_No,
				igms.Line_No as Line_No,
				igms.BL_No as BL_No,
				
				igms.office_code,
				igms.Pack_Number as Pack_Number,
				igms.Pack_Description as Pack_Description,
				igms.Pack_Marks_Number as Pack_Marks_Number,
				igms.Description_of_Goods as Description_of_Goods,
				igms.Submission_Date,
				igms.Date_of_Entry_of_Goods as Date_of_Entry_of_Goods,
				igms.weight as weight,
				igms.weight_unit,igms.net_weight,
				igms.net_weight_unit,
				igms.Bill_of_Entry_No as Bill_of_Entry_No,
				igms.Bill_of_Entry_Date as Bill_of_Entry_Date,
				igms.No_of_Pack_Delivered as No_of_Pack_Delivered,igms.AFR,igms.delivery_block_stat,igms.int_block,
						igms.No_of_Pack_Discharged as No_of_Pack_Discharged,igms.Remarks as Remarks,igms.ConsigneeDesc,
						igms.NotifyDesc,igms.Submitee_Org_Id,'D' as igm_type,BE_Status as BE_Status,R_No as R_No,
						R_Date as R_Date,amendment_appoved,
						igms.PFstatus,'h' as history  from igm_details_history igms where 
						igms.Import_Rotation_No='$txt_imp_rot' and replace(replace(igms.Line_No,' ',''),'
','')='$txt_line' and final_submit='1'";
		//print($sql."<hr>");		
		$res_cnt=mysql_query($sql);
		$row_cnt=mysql_num_rows($res_cnt);
		if ($row_cnt>0){
		$table='igm_details_history';
		$table_con='igm_detail_container_history';
		$table_navy='igm_navy_response_history';
		}	


			}

}


				if($row_cnt<="0")
				print("<font color=red size=4><strong>You Must select your full/correct Rotation No(0001/10) and Line No</strong></font>");
				//print("ershad".$table."ershad");
				
		}
						
}			
							
else if($txt_imp_rot!='' and $txt_line == '')
{
 print("<b><font color=red>YOU MUST FILL UP LINE NO</font></b>");
}

else if($txt_bl!='' and $txt_imp_rot1 == '')
{
 print("<b><font color=red>YOU MUST FILL UP IMPORT ROTATION NO WITH BL NO</font></b>");
}

else
{
 print("<b>FILL UP [<font color=red>IMPORT ROTATION NO AND LINE NO</font>] OR ONLY [<font color=red>IMPORT ROTATION NO AND BL NO</font>]</b>");
}							
                    
					
				//print $sql;
				   //$result1=mysql_query($str1);
				   
								
					
		?>
<!--<div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo $title; ?></span> </h2>
          <p class="infopost" style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/login/logout"><font color="skyblue" size ="2">Logout</font></a></p>
          <div class="clr"></div>
			<div class="img1">	-->
		<TABLE width="100%">
			<TR><TD width="100%">
				<table class='table-header' border=0 width="100%">
				<!--<tr><td height="5%"  class="onlyTable"><a href='home.php?myflag=<?php print($_SESSION['Control_Panel'])?>' target='upper_top'><img src="img/cchaiconHome.png" border="0" height="20" width="20">Back to Control Panel</a>&nbsp;&nbsp;&nbsp;Logged&nbsp;as&nbsp;Id:<?php print($_SESSION['login_id']); ?>&nbsp;&nbsp;Name:<?php print($_SESSION['User_Name']); ?></td><td colspan=3 class="onlyTable1"><a href='home.php?myflag=9' ><img src="img/cchaiconLogOut.png" border="0" height="20" width="20">Log out</a></td></tr>
			<tr><td height="5%"  class="onlyTable"><a href='home.php?myflag=135&VD=SC' target='upper_top'><img src="img/cchaiconHome.png" border="0" height="20" width="20">Back to Document Check</a></td></tr>		
					<tr class='gridLight'><td colspan="2" align="center"><h1> Check  Document  </h1></td></tr>-->
					<TR align="left"><TD colspan="6" ><a href="<?php echo site_url('igmViewController/myPanelView') ?>"><img src="<?php echo IMG_PATH; ?>back.png" height="40px" width="40px" align="middle" hspace="5"/>Back to Control Panel</a></TD></TR>
					<tr class='gridLight'><td colspan="2" align="left">
					<?php
					if($txt_line !='' and $txt_imp_rot!='')
					{
					
					?>
					<h1 style="text-align: left">Check Document for Rotation: <?php print($txt_imp_rot)?> and Line No: <?php print($txt_line)?> </h1>
					
					<?php
					}
					else
					{
					?>
					<h1 style="text-align: left">Check Document for Rotation: <?php print($txt_imp_rot1)?> and BL no: <?php print($txt_bl)?>  </h1>
					<?php
					}
					?>
					</td></tr>
					
					
					<tr>
						
							
						</td>
						<td align="right"><b></b></td>
						
					</tr>
					<tr>
					<td align="right"><b></b></td>
					</tr>
				</table>
			</TD></TR>
			<TR><TD>
					<table width="100%" border=1  cellspacing="0" cellpadding="0">
						<tr class='gridDark'>
					
							
						
							<th>Import Rotation No</th>
							<th width="20%"><span class="style1">Line No</span></th>
								<th><span class="style1">B/L No</span></th>
<th><span class="style1">Vessel_Name</span></th>
									<th><span class="style1">Pack Number</span></th>
							<th><span class="style1">Pack Description</span></th>
							<th><span class="style1">Pack Marks Number</span></th>
							<th><span class="style1">Description of Goods</span></th>
							<!--<th><span class="style1">Date of Entry</span></th>-->
							<th><span class="style1">Gross Weight</span></th>
							<th><span class="style1">Net Weight</span></th>
							<th><span class="style1">Bill of Entry No</span></th>
							<th><span class="style1">Bill of Entry Date</span></th>
							<th><span class="style1">Status & Time</span></th>
							<th><span class="style1">Release No</span></th>
							<th><span class="style1">Release Date</span></th>
							
							<th><span class="style1">Consignee Description</span></th>
							<th><span class="style1">Notify Description (Importers in IGM) </span></th>
							<th><span class="style1">Importers in B/E </span></th>
                                                        <th><span class="style1">Date of Submission</span></th>
							<th><span class="style1">No of Pack Delivered</span></th>
							<th><span class="style1">No of Pack Discharged</span></th>
							<th><span class="style1">Organization Name</span></th>
							<th><span class="style1">AIR</span></th>
							<th><span class="style1">Delivery Status</span></th>
							<th><span class="style1">Intelligence Block Status</span></th>
							<th><span class="style1">CPA OneStop Status</span></th>
							<th><span class="style1">Remarks</span></th>
							<th><span class="style1">Navy Comments</span></th>
								
							<th><span class="style1">Container Description</span></th>
							<th><span class="style1">FINAL CLERANCE FILES REF NUMBER</span></th>
		 				   	<th><span class="style1">FINAL CLERANCE DATE</span></th>
							<th><span class="style1">ETA DATE</span></th>
							<th><span class="style1">ACTUAL BERTH</span></th>
							
							<?php  //$row1->PFstatus==1 and $row1->file_clearence_date==null
								if(($_SESSION['Control_Panel']==10 or $_SESSION['Control_Panel']==81) and $_SESSION['user_role_id']<>14)
							{
							?>
							<th><span class="style1">Action</span></th>
							<th><span class="style1">Received Document</span></th>
							
							<?php
							}
							?>
							
							
						</tr>
					
						<tr>
							<?php while($row1=mysql_fetch_object($res_cnt)){ 
			if($_SESSION['Control_Panel']==10)
				{
					//print("custom");
					if(($row1->amendment_appoved<>1) and ($row1->PFstatus==1 or $row1->PFstatus==10 or $row1->PFstatus==2)) 
					{
						$con=1;
					}
				}
			else
				{
						//print("other");
					if(($row1->amendment_appoved<>1) and ($row1->PFstatus==1  or $row1->PFstatus==10))
					{
						$con=1;
					}
				
				}
			if($con=="1")
			{
					
					if($_SESSION['Control_Panel']==10)
						{
							//print("Custom");
							if($row1->PFstatus==2)
								{
									print("<font color=red size=4><b>This Igm is still waiting for Custom Approval</b></font>");
								}
						}
					
				

				//**************zico**************
/*if($org_Type_id=='5')

{
   	$today=date("Y-m-d h:i:s");	
		
	$org_id=$_SESSION['org_id'];
	$login_id=$_SESSION['login_id'];
	$link="Check The IGM";
	
	
	$handle111= fopen('/var/www/html/Message/port_log.txt' , 'a') or exit("Unable to open file!");
	
	fwrite(	$handle111,	"\r\n Rottion_no:".$row1->Import_Rotation_No."|"." line_no:".$row1->Line_No."|"." File Clearence date: ".$row1->file_clearence_date."|"." Date: ".$today."|"." Link: ".$link." Login_id: ".$login_id."|". "Org_Type_id:".$org_Type_id);	
	print($handle111);
	fclose($handle111); 
	
}*/	
				//****************end**************






					  
					  
					$str_vessel=mysql_query("select Vessel_Name,file_clearence_logintime,file_clearence_date,final_clerance_files_ref_number from igm_masters where id='$row1->master_id'");
		//	print("select Vessel_Name,file_clearence_date,final_clerance_files_ref_number from igm_masters where id='$row1->master_id'");
			$row_vessel=mysql_fetch_object($str_vessel);  

					



			//**************zico**************

if($org_Type_id=='5')

{
   	$today=date("Y-m-d h:i:s");	
		
	$org_id=$_SESSION['org_id'];
	$login_id=$_SESSION['login_id'];
	$link="Check The IGM";
	
	
	$handle111= fopen('/var/www/html/Message/port_log.txt' , 'a') or exit("Unable to open file!");
	
	fwrite(	$handle111,	"\r\n Rottion_no:".$row1->Import_Rotation_No."|"." line_no:".$row1->Line_No."|"." File Clearence date: ".$row_vessel->file_clearence_date."|"." Date: ".$today."|"." Link: ".$link." Login_id: ".$login_id."|". "Org_Type_id:".$org_Type_id);	
	print($handle111);
	fclose($handle111); 
	
}	
				
//****************end**************
				





					if($_SESSION['org_Type_id']!="18")
					{
						if($row1->AFR=="BLOCKED") {echo "<tr bgcolor='#FDFFB9' >";}
						else if($row1->AFR=="BLOCKED") {echo "<tr bgcolor='#C3FFB9'>";}
						else if($row1->delivery_block_stat=="block") {echo "<tr bgcolor='#FF6633'>";}
						else if($row1->int_block=="block") {echo "<tr bgcolor='#C8D780'>";}
						else if($row_vessel->file_clearence_date=="" and ($_SESSION['Control_Panel']==10 or $_SESSION['Control_Panel']==6 or $_SESSION['Control_Panel']==72)) {echo "<tr bgcolor='hotpink'>";}
						else echo  "<tr class='gridLight'>";
					}
					else echo  "<tr class='gridLight'>";
					
					?>
					 
					 
			<td  align="center"><?php if($row1->Import_Rotation_No)  print($row1->Import_Rotation_No); else print("&nbsp;"); ?></td>
				<?php $strin1=mysql_query("SELECT (SUBSTRING_INDEX('$row1->Line_No', '*', -1)) as Line_No,(SUBSTRING_INDEX('$row1->BL_No', '*', -1)) as BL_No");
			//print("SELECT (SUBSTRING_INDEX('$row1->Line_No', '*', -1)) as Line_No,(SUBSTRING_INDEX('$row1->BL_No', '*', -1)) as BL_No");
			$line_bl=mysql_fetch_object($strin1);?>
				<td  align="center" width="20%"><?php if ($line_bl->Line_No)  print($line_bl->Line_No); else print("&nbsp;"); ?></td>
			<td  align="center"><?php if($line_bl->BL_No)  print($line_bl->BL_No); else print("&nbsp;"); ?></td>
<td  align="center"><?php if($row_vessel->Vessel_Name)  print($row_vessel->Vessel_Name); else print("&nbsp;"); ?></td>
				<td  align="center"><?php if($row1->Pack_Number)  print($row1->Pack_Number); else print("&nbsp;"); ?></td>
				<td  align="center"><?php if($row1->Pack_Description)  print($row1->Pack_Description); else print("&nbsp;"); ?></td>
					<td  align="center"><?php if($row1->Pack_Marks_Number)  print($row1->Pack_Marks_Number); else print("&nbsp;"); ?></td>
				<td  align="center"><?php if($row1->Description_of_Goods)  print($row1->Description_of_Goods); else print("&nbsp;"); ?></td>
						<!--<td  align="center"><?php if($row1->Date_of_Entry_of_Goods)  print($row1->Date_of_Entry_of_Goods); else print("&nbsp;"); ?></td>-->
					  <td  align="center"><?php 
					  if($row1->weight)  
					  {
					  
					  
					  
					  print($row1->weight."<br>".$row1->weight_unit); 
					  
					  $igm_gross_weight=$row1->weight;
					  
					   $weight_unit=strtoupper($row1->weight_unit);
					  $weight_unit= str_replace('.','',$weight_unit);
					   $weight_unit= str_replace(' ','',$weight_unit);
					   
					  if(($weight_unit=="MTON") Or ($weight_unit=="MTONS"))
									{
									$weight1=$igm_gross_weight * 1000;
									$ex_mess="Note  : 1 MTON = 1000 KGs";
									}
									else if( ($weight_unit=="TON") or ($weight_unit=="TONS"))
									{
									$weight1=$igm_gross_weight * 1000;
									$ex_mess="Note : 1 TON = 1000 KGs";
									}									
									else if(($weight_unit=="HTON") or ($weight_unit=="HTONS"))
									{
									$weight1=$igm_gross_weight * 1000 * 1.8;
									$ex_mess="Note : 1 HTON=1800 KGs";
									}
									else if( ($weight_unit=="STON") or ($weight_unit=="STONS" )  )
									{
									$weight1=$igm_gross_weight * 907.185;
									$ex_mess="Note  : 1 STON = 907.185 KGs";
									}									
									else if(($weight_unit=="LTON" ) or ($weight_unit=="LTONS" ) )
									{
									$weight1=$igm_gross_weight * 1016.05 ;
									$ex_mess="Note : 1 LTON = 1016.05 KGs";
									}
									else if($weight_unit=="LBS" )
									{
									$weight1=$igm_gross_weight * 0.453592;
									$ex_mess="Note : 1 LBS = 0.453592 KGs";
									}
									else
									$weight1=$igm_gross_weight;
									
									
									if(!($weight_unit=="KG" or $weight_unit=="KGS"))
									print("<br>&nbsp;&nbsp;&nbsp;<a><font  color='blue'> Equivalent to ".$weight1." KGS </font></a><hr><font  color='red'>".$ex_mess."</font>");
					  }
					  else print("&nbsp;"); ?></td>
						<td  align="center"><?php if($row1->net_weight)  print($row1->net_weight); else print("&nbsp;"); ?></td>
					  
<?php

if ($row1->Bill_of_Entry_No)
{

$bill_no=explode(",",$row1->Bill_of_Entry_No);	
$Sad_reg_no=substr($bill_no[0],1);
//$Sad_reg_no=substr($row1->Bill_of_Entry_No,1);
					  $bin=mysql_query("select  id,SAD_CONSIGNEE,SAD_DECLARANT,org_id from sad_gen_informations where  SAD_REG_NBER='$Sad_reg_no' 
and SAD_REG_DATE='$row1->Bill_of_Entry_Date' and SAD_CUO_COD='$row1->office_code'");
$rowbin=mysql_fetch_object($bin); 
if($rowbin->SAD_DECLARANT<>0)
{
$org_name=mysql_query("select Organization_Name,block_open,block_open_by,block_open_comment,block_date from organization_profiles where id='$rowbin->org_id'");
//print("select Organization_Name,block_open,block_open_by,block_open_comment,block_date from organization_profiles where id='$rowbin->org_id'");
$roworg=mysql_fetch_object($org_name); 
//print($roworg->block_open."==".$roworg->block_open_by);
	if($roworg->block_open=="Block" and $roworg->block_open_by=="JCMushfeq")
		{
			$msg1="This C&F($rowbin->SAD_DECLARANT) License is Blocked by Customs on $roworg->block_date<br>Customs Message: $roworg->block_open_comment";
			//print("<font color=red size=2><b>$msg1</b></font>");					
		}
		
}
}
$sql_organization=mysql_query("select Organization_Name as Organization_Name from organization_profiles orgs where id='$row1->Submitee_Org_Id'");
//print("select Organization_Name as Organization_Name from organization_profiles orgs where id='$row1->Submitee_Org_Id'");
$row_organization=mysql_fetch_object($sql_organization);

$beno=$row1->Bill_of_Entry_No;
$BEdate=$row1->Bill_of_Entry_Date;
$office=$row1->office_code;
$be1=explode(",",$beno);
$be=$be1[0];
?>


						<td  align="center"><?php if($beno)  { ?><a href='Forms/myBillEntryImportReportHTML.php?reg=<?php print($be);?>&date=<?php print($BEdate);?>&code=<?php print($office);?>' target="aboutblank"><?php print($beno); ?></a><!--print($row1->Bill_of_Entry_No);--><?php print("<font color=red size=2><hr>$msg1</font>"); }else print("&nbsp;"); ?></td>
					  <td  align="center"><?php if($BEdate)  print($BEdate); else print("&nbsp;"); ?></td>
  					<td  align="center"><?php if($row1->BE_Status)  print($row1->BE_Status."<br>".$row1->R_Date); else print("&nbsp;"); ?></td>
  					<!--<td  align="center"><?php if($row1->R_No)  print($row1->R_No); else print("&nbsp;"); ?></td>
  					<td  align="center"><?php if($row1->R_No)  print($row1->R_Date); else print("&nbsp;"); ?></td>-->
					
					<td  align="center"><a href="javascript:gsremote2
('Forms/myDeliverydashboardrepot.php?beno=<?php print($row1->Bill_of_Entry_No);?>
&bedate=<?php print($row1->Bill_of_Entry_Date);?>
&officecode=<?php print($row1->office_code);?>
&Import_Rotation_No=<?php print($row1->Import_Rotation_No);?>
&Line_No=<?php print($line_bl->Line_No);?>
&BL_No=<?php print($line_bl->BL_No);?>','abc',400,350,10,10)">
<?php if($row1->R_No)  print($row1->R_No); else print("&nbsp;"); ?></a>
</td><td  align="center"><?php if($row1->R_No)  print($row1->R_Date); 
else print("&nbsp;"); ?></td>
	

					  <td  align="center"><?php if($row1->ConsigneeDesc)  print($row1->ConsigneeDesc); else print("&nbsp;"); ?></td>
					  <td  align="center"><?php if($row1->NotifyDesc)  print($row1->NotifyDesc); else print("&nbsp;"); ?></td>
						<td><?php
						$bill_no=explode(",",$row1->Bill_of_Entry_No);
						$be_no=substr($bill_no[0],1);
						
						$sql_consignee=mysql_query("select SAD_CONSIGNEE,SAD_TYP_DEC 
						from sad_gen_informations where SAD_REG_NBER=$be_no and 
						SAD_REG_DATE='$row1->Bill_of_Entry_Date' and SAD_CUO_COD=$row1->office_code");

						$numrowcon=mysql_num_rows($sql_consignee);
						if($numrowcon==0)
						{
							$sql_consignee=mysql_query("select SAD_CONSIGNEE,SAD_TYP_DEC 
							from sad_gen_informations_history where SAD_REG_NBER=$be_no and 
							SAD_REG_DATE='$row1->Bill_of_Entry_Date' and SAD_CUO_COD=$row1->office_code");

						}
						/*print("select SAD_CONSIGNEE,SAD_TYP_DEC 
						from sad_gen_informations where SAD_REG_NBER=$be_no and 
						SAD_REG_DATE='$row1->Bill_of_Entry_Date' and SAD_CUO_COD=$row1->office_code");
*/
						$row_consignee=mysql_fetch_object($sql_consignee);
						
						if($row_consignee->SAD_CONSIGNEE)
								{
									$sql_consignee=mysql_query("select CMP_NAM,
									concat(CMP_ADR,ifnull(CMP_AD2,' '),ifnull(CMP_AD3,' '),ifnull(CMP_AD4,' ')) as address 
									from uncmptab where CMP_COD='$row_consignee->SAD_CONSIGNEE'");

									/*print("select CMP_NAM,
									concat(CMP_ADR,ifnull(CMP_AD2,' '),ifnull(CMP_AD3,' '),ifnull(CMP_AD4,' ')) as address 
									from uncmptab where CMP_COD='$row_consignee->SAD_CONSIGNEE'");*/


									$row_consignee=mysql_fetch_object($sql_consignee);
									
									$bin_name=$row_consignee->CMP_NAM;
									$bin_add=$row_consignee->address;
								}
								else if($row_consignee->SAD_CONSIGNEE="" and $row_consignee->SAD_TYP_DEC=="IM")
								{
									$sql_consignee=mysql_query("select SAD_CON_NAM as CMP_NAM,concat(SAD_CON_ADD1,SAD_CON_ADD2) as address 
									from sad_occ_cns where SAD_GEN_id=$id");

									/*print("select SAD_CON_NAM as CMP_NAM,concat(SAD_CON_ADD1,SAD_CON_ADD2) as address 
									from sad_occ_cns where SAD_GEN_id=$id");*/

									$row_consignee=mysql_fetch_object($sql_consignee);
									
									$bin_name=$row_consignee->CMP_NAM;
									$bin_add=$row_consignee->address;
								}
					 print($bin_name."<br>".$bin_add);
						?>
						</td>
					  
					  <td  align="center"><?php if($row1->Submission_Date)  print($row1->Submission_Date); else print("&nbsp;"); ?></td>
					 <td  align="center"><?php if($row1->No_of_Pack_Delivered)  print($row1->No_of_Pack_Delivered); else print("&nbsp;"); ?></td>
					  <td  align="center"><?php if($row1->No_of_Pack_Discharged)  print($row1->No_of_Pack_Discharged); else print("&nbsp;"); ?></td>
					  <td  align="center"><?php if($row_organization->Organization_Name) print($row_organization->Organization_Name); else print("&nbsp;");?></td>
					<td  align="center">
			<?php 
			// AIR Block Open Information Details
			if($row1->igm_type=='D') 
			{
				$office_afr= mysql_query("select block_status,office_code,AFR_By,AFR_Date,remarks from igm_detail_afr where igm_detail_id='$row1->id'  
				and AFR_By is not null order by AFR_Date desc limit 2");
			}
			else
			{
				$office_afr= mysql_query("select block_status,office_code,AFR_By,AFR_Date,remarks from igm_detail_afr where igm_sup_detail_id='$row1->id'  
				and AFR_By is not null order by AFR_Date desc limit 2");
				
			}
			$numrowAIR=mysql_num_rows($office_afr);
			
			if($row1->AFR) 
			{
				print(strtoupper($row1->AFR));
				if($numrowAIR>0)
				{
					while($rowOffice_afr=mysql_fetch_object($office_afr))
					{
						$status1=strtoupper($rowOffice_afr->block_status);
						print("<hr><b>$status1 BY: </b><br>$rowOffice_afr->AFR_By<br>$rowOffice_afr->AFR_Date<br><b>$status1 REMARKS: </b> <br>$rowOffice_afr->remarks");
					}
				}
				
			}
			else print("&nbsp;");

			?>
			</td>
			<td  align="center">
			<?php 
			// Delivery Block Open Information Details				 
			if($row1->igm_type=='D') 
			{
				$office= mysql_query("select block_status,office_code,AFR_By,AFR_Date,Deliver_block_by,remarks,Deliver_block_time from igm_detail_afr where igm_detail_id='$row1->id' and  Deliver_block_by is not null 
				order by Deliver_block_time desc limit 2");
			}
			else
			{
				$office= mysql_query("select block_status,office_code,AFR_By,AFR_Date,Deliver_block_by,remarks,Deliver_block_time from igm_detail_afr where 
				igm_sup_detail_id='$row1->id' and  Deliver_block_by is not null order by Deliver_block_time desc limit 2");
			}
			$numrowDIV=mysql_num_rows($office);
			
			if($row1->delivery_block_stat) 
			{
				print(strtoupper($row1->delivery_block_stat));
				if($numrowDIV>0)
				{
					while($rowOffice=mysql_fetch_object($office))
					{
						$status=strtoupper($rowOffice->block_status);
						print("<hr><b>$status BY: </b><br>$rowOffice->Deliver_block_by<br>$rowOffice->Deliver_block_time<br><b>$status REMARKS: </b> <br>$rowOffice->remarks");
					}
				}
				
			}
			else print("&nbsp;");
			
			
			?>
			</td>
			<td  align="center">
					
					<?php 
					// Intelligence Block Open Information Details
					if($row1->igm_type=='D')
					$sql_int_block=mysql_query("select block_status,int_block_status,int_block_datetime,remarks from igm_detail_afr where igm_detail_id=$row1->id and int_block_status is not null order by id desc limit 1");
					else 
					$sql_int_block=mysql_query("select block_status,int_block_status,int_block_datetime,remarks from igm_detail_afr where igm_sup_detail_id=$row1->id and int_block_status is not null order by id desc limit 1");
					
					$int_numrow=mysql_num_rows($sql_int_block);
					
					if($row1->int_block) 
					{
						print(strtoupper($row1->int_block));
						if($int_numrow>0)
						{
							while($row_int_block=mysql_fetch_object($sql_int_block))
							{
								$status2=strtoupper($row_int_block->block_status);
								print("<hr><b>$status2 BY: </b><br>$row_int_block->int_block_status<br>$row_int_block->int_block_datetime<br><b>$status2 REMARKS: </b> <br>$row_int_block->remarks");
							}
						}
				
					}
					else print("&nbsp;");
					?>
				</td>
				<?php 
				$sql_delivery=mysql_query("select Port_Checked,Check_by_port,Check_datetime from delivery_dash_board where sad_gen_id=$rowbin->id");
				$row_delivery=mysql_fetch_object($sql_delivery);
				if($row_delivery->Port_Checked==1)
				{
					$dlvStatus=$row_delivery->Port_Checked;
					$dlvCheckBy=$row_delivery->Check_by_port;
					$dlvCheckTime=$row_delivery->Check_datetime;
				}
				else
				{
					$dlvStatus=null;
					$dlvCheckBy=null;
					$dlvCheckTime=null;
				
				}
				
				?>
					<td  align="center"><?php if($dlvStatus==1) print("<font color='blue'><b>One Stop Clear</b></font><hr>Clear By: ".$dlvCheckBy."<br>".$dlvCheckTime); else print("&nbsp;");?></td>
					<td  align="center"><?php if($row1->Remarks) print($row1->Remarks); else print("&nbsp;");?></td>
					<?php  if 	($row1->igm_type=='D')
						{
						$str="select response_details3,response_details2,response_details1,hold_application,
				rejected_application,auto_no as submitId,final_amendment,appsubmitdate,navy_response_to_port,
				permission_no from $table_navy where igm_details_id='$row1->id'";
			/*$str="select response_details3,response_details2,response_details1,hold_application,
			rejected_application,auto_no as submitId,final_amendment,appsubmitdate,navy_response_to_port,permission_no from igm_navy_response left join $table
			on $table.id=igm_navy_response.igm_details_id where 
			igm_navy_response.igm_details_id=$row1->id";*/
						}
						else if($row1->igm_type=='S')
						{
						$str="select response_details3,response_details2,response_details1,hold_application,
			rejected_application,auto_no as submitId,final_amendment,appsubmitdate,navy_response_to_port,
			permission_no from $table_navy where egm_details_id='$row1->id'";
			//$str="select response_details3,response_details2,response_details1,hold_application,rejected_application,auto_no 			as submitId,final_amendment,appsubmitdate,navy_response_to_port,permission_no from igm_navy_response left join $table on $table.id=igm_navy_response.egm_details_id where igm_navy_response.egm_details_id=$row1->id";
						}
					//print($str);
			$resultnavy = mysql_query($str);	
			$navy=mysql_fetch_object($resultnavy);
			

			?>

		<?php			
			if($navy->final_amendment==2)
			{
				print("<td valign='top'>
							LabComments:$navy->response_details1<br>
							NAIO Comments:$navy->response_details2<br>
							$navy->hold_application</td>");
			}
			else if($navy->final_amendment==3)
			{
				print("<td valign='top'>
							LabComments:$navy->response_details1<br>
							NAIO Comments:$navy->response_details2<br>
							$navy->rejected_application</td>");
			}
			else if($navy->navy_response_to_port != "" and $navy->response_details3 == "")
			{		
				print("<td valign='top'>$navy->navy_response_to_port</td>");
			}
			else if($navy->final_amendment==1)
			{	
				print("<td>LabComments:$navy->response_details1<br>
						   NAIO Comments:$navy->response_details2<br>		
						   Finally:$navy->response_details3</td>");
			}
			else
			{
				print("<td valign='top'></td>");
			}
		?>

					

					<td align="left" valign="top">
					
					<table width="100%">
					<tr border="1">
						<th>Off-dock Name</th>
						<th>Cnt. Number</th>
						<th>Seal Number</th>
						<th>Size</th>
						<th>Type</th>
						<th>Height</th>
						<th>Weight</th>
						<th>Status</th>
						<th>Imco</th>
						<th>Un</th>
						<th>Remarks</th>
						<th>Delivery Status</th>
					</tr>
					<?php 
					//load container detail
						//print("select cnt.id as id,cnt.cont_number as cont_number,cnt.cont_size as cont_size,cnt.cont_weight as cont_weight,cnt.cont_seal_number as cont_seal_number,cnt.cont_description as cont_description from igm_detail_container cnt where cnt.igm_detail_id=$row->id");
						
						
if 	($row1->igm_type=='D')

            {
						$str2="select cnt.id as id, cnt.cont_number as cont_number, cnt.cont_size as cont_size,cnt.cont_type as cont_type,cnt.cont_height as cont_height,cnt.cont_status as cont_status,cnt.cont_weight as cont_weight,cnt.cont_seal_number as cont_seal_number,cnt.cont_description as cont_description,cnt.cont_imo as cont_imo, cnt.cont_un as cont_un,cnt.Delivery_Status as Delivery_Status,off_dock_id,Organization_Name from $table_con cnt 
left join organization_profiles
on 
organization_profiles.id=cnt.off_dock_id
where cnt.igm_detail_id=$row1->id";
						$result2 = mysql_query($str2);						
						
			}			
else
			{		
						$str2="select cnt.id as id, cnt.cont_number as cont_number, cnt.cont_size as cont_size,cnt.cont_type as cont_type,cnt.cont_height as cont_height,cnt.cont_status as cont_status,cnt.cont_weight as cont_weight,cnt.cont_seal_number as cont_seal_number,cnt.cont_description as cont_description,cnt.cont_imo as cont_imo, cnt.cont_un as cont_un,cnt.Delivery_Status as Delivery_Status,off_dock_id,Organization_Name from $table_con cnt 
left join organization_profiles
on 
organization_profiles.id=cnt.off_dock_id
where cnt.igm_sup_detail_id=$row1->id";
						$result2 = mysql_query($str2);													
						
			}			
						//print($str2);
						//print("select cnt.id as id, cnt.cont_number as cont_number, cnt.cont_size as cont_size,cnt.cont_type as cont_type,cnt.cont_height as cont_height,cnt.cont_status as cont_status,cnt.cont_weight as cont_weight,cnt.cont_seal_number as cont_seal_number,cnt.cont_description as cont_description,cnt.cont_imo as cont_imo, cnt.cont_un as cont_un from igm_detail_container cnt where cnt.igm_detail_id=$row1->id");
						while($row2 = mysql_fetch_object($result2)) {
						
						if($row2->Delivery_Status==1) 
						$status="<font color=blue size=2>Already Delivered</font>";
						else
						$status=null;
						print("<tr>
								<td>$row2->Organization_Name</td>
									<td>$row2->cont_number</td>
								<td>$row2->cont_seal_number</td>
								<td>$row2->cont_size</td>
								<td>$row2->cont_type</td>
								<td>$row2->cont_height</td>
								<td>$row2->cont_weight</td>
								<td>$row2->cont_status</td>
								<td>$row2->cont_imo</td>
								<td>$row2->cont_un</td>
								<td>$row2->cont_description</td>
								<td>$status</td>
								</tr>");	
							print("<tr><td colspan='4'><hr noshade></td></tr>");
						}
						mysql_free_result($result2);	
						
					?>					
					</table>

<td  align="center"><?php if($row_vessel->final_clerance_files_ref_number) print($row_vessel->final_clerance_files_ref_number); else print("&nbsp;");?></td>
<td  align="center"><?php //$row1->PFstatus==1 and $row1->file_clearence_date==null
 if($row_vessel->file_clearence_date<>null and $row1->PFstatus==10 )
print($row_vessel->file_clearence_logintime);
else if($row1->PFstatus==1 and $row_vessel->file_clearence_date<>null)
print("<a><font color='red'>IGM Submitted after Final Clearence Date :($row_vessel->file_clearence_logintime)</font></a>"); 
else print("&nbsp;");

$vessel_bearth=mysql_query("select ETA_Date,Actual_Berth from vessels_berth_detail where igm_id='$row1->master_id'");
//print("select ETD_Date,Actual_Berth from vessels_berth_detail where igm_id='$row1->master_id'");
$row_bearth=mysql_fetch_object($vessel_bearth);


?></td>
<td  align="center"><?php if($row_bearth->ETA_Date) print($row_bearth->ETA_Date); else print("&nbsp;");?></td>
<td  align="center"><?php if($row_bearth->Actual_Berth) print($row_bearth->Actual_Berth); else print("&nbsp;");?></td>
					
					<?php

					$bill_no=explode(",",$row1->Bill_of_Entry_No);
					//print($bill_no[0]."shemul");		
					$bill_no_noted=substr($bill_no[0],1);
						
					//$bill_no_noted=substr($row1->Bill_of_Entry_No,1);
					//	
					
					if(($_SESSION['Control_Panel']==10 or $_SESSION['Control_Panel']==81)  and $row1->Bill_of_Entry_No <> null and $_SESSION['user_role_id']<>14)
					{
					//print($_SESSION['Control_Panel']."shemul<hr>".$row1->Bill_of_Entry_No);
					if($row1->history=="h")
					{
						$str_noted="select noted,noted_by,noted_date,entrydate,user_id,forward_to_section from bill_of_entry_doc_detail_history where Bill_of_Entry_No='$bill_no_noted' and 
						year(bill_of_entry_date)=year('$row1->Bill_of_Entry_Date') and office_code='$row1->office_code'
						";
						$result_noted=mysql_query($str_noted);
						$numrow=mysql_num_rows($result_noted);
						if($numrow==0)
						{
							$str_noted="select noted,noted_by,noted_date,entrydate,user_id,forward_to_section from bill_of_entry_doc_detail where Bill_of_Entry_No='$bill_no_noted' and 
							bill_of_entry_date like '%$row1->Bill_of_Entry_Date%' and office_code='$row1->office_code'";
							$result_noted=mysql_query($str_noted);
						}
						
						//print($str_noted."h");
					}
					else
					 {
						//$str_noted="select noted,noted_by,noted_date,entrydate,user_id,forward_to_section from bill_of_entry_doc_detail where Bill_of_Entry_No='$bill_no_noted' and 
						//year(bill_of_entry_date)=year('$row1->Bill_of_Entry_Date') and office_code='$row1->office_code'";
						
						$str_noted="select noted,noted_by,noted_date,entrydate,user_id,forward_to_section from bill_of_entry_doc_detail where Bill_of_Entry_No='$bill_no_noted' and 
						bill_of_entry_date like '%$row1->Bill_of_Entry_Date%' and office_code='$row1->office_code'";
						$result_noted=mysql_query($str_noted);


						//print($str_noted);
					}
					//print($str_noted."<hr>");
					//print($str_noted."abc");
					
					
					$row_noted=mysql_fetch_object($result_noted);
					//and $_SESSION['login_id']!='ds00180'
					
					if($row_noted->noted==0 and $_SESSION['login_id']!='ds00180'  and $_SESSION['login_id']!='ds00180pav')
					
					{
					?>
						<td>
						<a href='home.php?myflag=626&edit=yes&BILL=<?php print($row1->Bill_of_Entry_No);?>&DATE=<?php print($row1->Bill_of_Entry_Date);?>&OFFICE_CODE=<?php print($row1->office_code);?>&imp_rot=<?php print($txt_imp_rot);?>&line=<?php print($txt_line);?>&bl=<?php print($txt_bl);?>&txt_imp_rot1=<?php print($txt_imp_rot1);?>' style="color:blue">Noted</a>
	                    </td>
					<?php
					}
					else
					{ ?>
					<td><font color="blue"><?php if($row_noted->noted==1){ ?><b>Status: Noted</b><br> Noted by: <?php print($row_noted->noted_by."<br>".$row_noted->noted_date); } else { print("&nbsp;");} ?></font></td>
					
					<?php 
					
					}
					if($row_noted->user_id!=""){
					?>
					<td><font color="blue"><b><br> Received by: </b><?php print($row_noted->user_id."<br>".$row_noted->entrydate."<br><b>Section:</b> " .$row_noted->forward_to_section); ?></font></td>
					<?php } else { ?>
					<td>&nbsp;</td>
					<?php } ?>
		
					  </tr>	
					<?php }
					}}?>	
					
					
					</tr>
					
				
					</table>
					
			</TD></TR>
			<?php mysql_close($con_cchaportdb);?>
		</TABLE>
	<!--</div>
	<div class="clr"></div>
        
    </div>
	
	</div>
            
    <div class="sidebar">
	<?php //include_once("mySideBar.php"); ?>
	</div>
    <div class="clr"></div>

	</div>
</div>-->
