
<?php
class myCreateTable	{
	
	function myCreateTable(){
		include_once("mydbPConnection.php");
		//$this->DatasoftUtility("ccha","localhost","root","");
	}

	//Find out the current Date
	function CURR_DATE(){
		$result_now=mysql_query("SELECT NOW() as datetime");
		$row_now=mysql_fetch_object($result_now);
		return $row_now->datetime;
	}

	//Find out the current year
	function CURR_YEAR(){
		$curr_date=$this->CURR_DATE();
		$time=substr($curr_date,10);
		$day=substr($curr_date,0,10);
		$piece=explode("-",$day);
		$year=substr($piece[0],2);
		return $year;
	}
	
	//Find out the current month
	function CURR_MONTH(){
		$curr_date=$this->CURR_DATE();
		$day=substr($curr_date,0,10);
		$piece=explode("-",$day);
		$month=$piece[1];
		return $month;
	}
	
	//find out the Rotation Year
	function ROTATION_YEAR($rotation_no){
		$curr_year=$this->CURR_YEAR();
		$ROT_YEAR=explode("/",$rotation_no);
		if (($ROT_YEAR[1]!= $curr_year) and $this->CURR_MONTH()< 4)
			return $ROT_YEAR[1]+1;
		else
			return $ROT_YEAR[1];
	}
	
	function TABLE_NAME($rotation_no){
		//$curr_year=$this->CURR_YEAR();
		//$rotation_year=$this->ROTATION_YEAR($rotation_no);
		//print("<br>CURR : ".$curr_year." ROT :".$rotation_year);
		//if ($curr_year==$rotation_year) 
		$result_now=mysql_query("SELECT count(Import_Rotation_No) as cnt from  igm_details where Import_Rotation_No='$rotation_no'");
		$row_now=mysql_fetch_object($result_now);
		$cnt=$row_now->cnt;
		if ($cnt>0) 
		return "igm_details,igm_detail_container,igm_supplimentary_detail,igm_sup_detail_container";
		else 
		return "igm_details_history,igm_detail_container_history,igm_supplimentary_detail_history,igm_sup_detail_container_history";
//return "igm_details,igm_detail_container,igm_supplimentary_detail,igm_sup_detail_container";
	}

	function BE_RELATED_TABLE($sad_id){
		$str="select count(id) as cnt from sad_gen_informations where id=$sad_id";
		//print($str);
		$result=mysql_query($str);
		$row_cnt=mysql_fetch_object($result);
		//print("count :".$row_cnt->cnt);
		if ($row_cnt->cnt >0)
		return $this->HistoryCheck(1);
		else 
		return $this->HistoryCheck(2);
	}  
	
	function HistoryCheck($check_id){
		if ($check_id == 1 or $check_id == "")
		return "sad_gen_informations,sad_itms,edi_assessment_a,edi_global_texes,edi_global_texes_a,edi_item_tax,edi_item_tax_a,sad_valu_ims,sad_valu_exs,sad_occ_exps,sad_occ_cns,sad_itm_valu_vims,sad_itm_valu_exs";
		else 
		return "sad_gen_informations_history,sad_itms_history,edi_assessment_a_history,edi_global_texes_history,edi_global_texes_a_history,edi_item_tax_history,edi_item_tax_a_history,sad_valu_ims_history,sad_valu_exs_history,sad_occ_exps_history,sad_occ_cns_history,sad_itm_valu_vims_history,sad_itm_valu_exs_history";
	}
mysql_close($con_sparcsn4);
}
