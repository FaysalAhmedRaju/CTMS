<?php
//awal
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Ronnie - 8 Jul 2011
 */

class ajaxController extends CI_Controller {
	function __construct()
	{
	    parent::__construct();	
            $this->load->library(array('session', 'form_validation'));
            $this->load->model(array('CI_auth', 'CI_menu'));
            $this->load->helper(array('html','form', 'url'));
			$this->load->driver('cache');
			$this->load->model('ci_auth', 'bm', TRUE);
			
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
			
	}	

	function ajaxValue()
	{
		$serch_by = $_GET["serch_by"];
		$query = "";
		if($serch_by=="offdoc")
		{
			$query = "select distinct code_ctms as id,name from ctmsmis.offdoc";
		}
		
		if($serch_by=="pod")
		{
			$query = "select * from
			(
			select
			(select id from sparcsn4.ref_unloc_code where gkey=tbl.unloc_gkey) as id,
			(select place_name from sparcsn4.ref_unloc_code where gkey=tbl.unloc_gkey) as name
			from 
			(
			select distinct unloc_gkey from sparcsn4.ref_routing_point
			) as tbl 
			) as final WHERE id REGEXP '[a-z]+' order by id";
		}
		
		$rtnVehicleList=$this->bm->dataSelect($query);
		echo json_encode($rtnVehicleList);
	}
	function logEquipName()
	{
		$serch_by = $_GET["serch_by"];
		$query = "";
		if($serch_by=="equip")
		{
			$query = "select distinct logEquip as id from ctmsmis.mis_equip_log_in_out_info where logEquip like'RTG%'";
		}
		
		if($serch_by=="euser")
		{
			$query = "select distinct logBy as id from ctmsmis.mis_equip_log_in_out_info where logEquip like'RTG%'";
		}
		
		$rtnVehicleList=$this->bm->dataSelect($query);
		echo json_encode($rtnVehicleList);
	}
	
	function getMlo()
	{
		$rotation = $_GET["rot"];
		$rot = str_replace("_","/",$rotation);
		$login_id = $this->session->userdata('login_id');
		$ofdock = $this->Offdock($login_id);
		$query = "select distinct cont_mlo from ctmsmis.mis_exp_unit_preadv_req where rotation='$rot' and transOp=$ofdock";	
		
		$rtnVehicleList=$this->bm->dataSelect($query);
		echo json_encode($rtnVehicleList);
	}
	
	function getOrgSection()
	{
		$org_id = $_GET["orgId"];
		$query = "SELECT section_value,section_lebel FROM tbl_org_section WHERE org_type_id=$org_id";	
		
		$rtnSectionList=$this->bm->dataSelectDb1($query);
		echo json_encode($rtnSectionList);
	}
	
	function getLCLContInfo()
	{
		$cont = $_GET['cont'];
		
		$strDtlCont = "SELECT COUNT(*) as rtnValue FROM igm_detail_container WHERE cont_number='$cont' AND cont_status='LCL'";
		$rtnValDtlCont = $this->bm->dataReturnDb1($strDtlCont);
		
		$strSupDtlCont = "SELECT COUNT(*) as rtnValue FROM igm_sup_detail_container WHERE cont_number='$cont' AND cont_status='LCL'";
		$rtnValSupDtl = $this->bm->dataReturnDb1($strSupDtlCont);
		
		if($rtnValDtlCont==0 and $rtnValSupDtl==0)
		{
			$strN4check="select count(*) as rtnValue from inv_unit where freight_kind='LCL' AND id='$cont'";
			$contN4check = $this->bm->dataReturn($strN4check); 
			
			if($contN4check>0)
				{
					$strUpdateDetail="update igm_detail_container set cont_status='LCL' where cont_number='$cont' and cont_status='FCL'";
					$strUpdateStat1 = $this->bm->dataUpdateDB1($strUpdateDetail);
					
					$strUpdateSupDetail="update igm_sup_detail_container set cont_status='LCL' where cont_number='$cont' and cont_status='FCL'";
					$strUpdateStat2 = $this->bm->dataUpdateDB1($strUpdateSupDetail);
					
					
					 $strDtlCont = "SELECT COUNT(*) as rtnValue FROM igm_detail_container WHERE cont_number='$cont' AND cont_status='LCL'";
					 $rtnValDtlCont = $this->bm->dataReturnDb1($strDtlCont);
				
					 $strSupDtlCont = "SELECT COUNT(*) as rtnValue FROM igm_sup_detail_container WHERE cont_number='$cont' AND cont_status='LCL'";
					 $rtnValSupDtl = $this->bm->dataReturnDb1($strSupDtlCont);
				}
  
             else
			 {
			    echo "Container not found.";
			 }
			
		}
						
		if($rtnValDtlCont>0 or $rtnValSupDtl>0)
		{
			$strContDetail = "select cont_size,cont_height,Vessel_Name,igm_details.Import_Rotation_No,mlocode,igm_detail_container.id,igm_detail_id
                              from igm_detail_container 
						      inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id
							  inner join igm_masters on igm_masters.id=igm_details.IGM_id
							  where cont_number='$cont' order by igm_detail_container.id desc limit 1";
			//echo $strContDetail;
			$contInfo = $this->bm->dataSelectDb1($strContDetail);
			 
		    //json_encode($contInfo);
			$cont_size="";
			$cont_height="";
			$Vessel_Name="";
			$Import_Rotation_No="";
			$mlocode="";
			$igmDetailContId="";
			$igmDetailId="";
			for($i=0;$i<count($contInfo);$i++) {
				$cont_size=$contInfo[$i]['cont_size'];
				$cont_height=$contInfo[$i]['cont_height'];
				$Vessel_Name=$contInfo[$i]['Vessel_Name'];
				$Import_Rotation_No=$contInfo[$i]['Import_Rotation_No'];
				$mlocode=$contInfo[$i]['mlocode'];
				$igmDetailContId=$contInfo[$i]['id'];
				$igmDetailId=$contInfo[$i]['igm_detail_id'];
			}
			
			$strBerth = "select flex_string02 as rtnValue from sparcsn4.vsl_vessel_visit_details where ib_vyg='$Import_Rotation_No'";
			$berthOp = $this->bm->dataReturn($strBerth);
			
			$strTimeIn="select inv_unit_fcy_visit.time_in as rtnValue from inv_unit_fcy_visit
						inner join inv_unit on 
						inv_unit_fcy_visit.gkey=inv_unit.gkey
						where inv_unit.category='IMPRT' 
						and id='$cont'";
						
			$timeInfo = $this->bm->dataReturn($strTimeIn);			
			
			echo "|".$cont_size."|".$cont_height."|".$Vessel_Name."|".$Import_Rotation_No."|".$mlocode."|".$igmDetailContId."|".$igmDetailId."|".$berthOp."|".$timeInfo;
		}
		else
		{
			echo "Container not found";
		}
	}
	
	
  function getShedDtlInfo()
	{
		    $shed = $_GET["shed"];
			$query = "select lcl_assignment_detail.id,igm_detail_container.cont_number,
			igm_detail_container.cont_size,igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,assignment_date,
			igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,
			lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time,if(assignment_date<=date(now()),1,0) as st 
			from lcl_assignment_detail
			inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id 
			inner join igm_masters on igm_masters.id=igm_details.IGM_id 
			inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id where unstuff_flag=0 and cont_loc_shed='$shed' order by assignment_date";	
            $rtnShedList = $this->bm->dataSelectDb1($query);
            echo json_encode($rtnShedList);	   
	}
	
	
	function getDeliveryInfo()
	{
		$verifyNo = $_GET['verifyNo'];
		$query = "select shed_tally_info.import_rotation, igm_supplimentary_detail.BL_No,master_Line_No,igm_supplimentary_detail.Pack_Marks_Number, mlocode,
				igm_supplimentary_detail.Description_of_Goods,igm_supplimentary_detail.Consignee_name, Cont_gross_weight,
				ABS(Cont_gross_weight-cont_weight) as Net_weight, shed_tally_info.cont_number,
				igm_sup_detail_container.cont_height,igm_sup_detail_container.cont_size, igm_sup_detail_container.cont_type, verify_other_data.be_no,
				verify_other_data.be_date,do_date,wr_upto_date,cnf_lic_no, cnf_name,cont_number_packaages,rcv_pack
				from shed_tally_info 
				inner join igm_supplimentary_detail on igm_supplimentary_detail.id=shed_tally_info.igm_sup_detail_id
				inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
				left join igm_details on igm_details.id=igm_supplimentary_detail.igm_detail_id
				left join verify_other_data on verify_other_data.shed_tally_id=shed_tally_info.id
				where verify_number=$verifyNo";
           $deliveryList = $this->bm->dataSelectDb1($query);   
           echo json_encode($deliveryList);	 
	}
	
	
 function getDeliveryByBLInfo()
	{
		$blNo = $_GET['blNo'];
		$rotNo = $_GET['rotNo'];
		$login_id = $this->session->userdata('login_id');
		
		$exchageStatusQuery="select exchange_done_status AS rtnValue from shed_tally_info 
							inner join igm_supplimentary_detail on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
							where shed_tally_info.import_rotation='$rotNo' and igm_supplimentary_detail.BL_No='$blNo'";
							
		$exchnStatus = $this->bm->dataReturnDb1($exchageStatusQuery);
		
		$cont_igm="SELECT  cont_number,cont_size,cont_weight,cont_height,cont_status 
		FROM igm_detail_container
		INNER JOIN igm_details ON igm_detail_container.igm_detail_id=igm_details.id
		WHERE igm_details.Import_Rotation_No='$rotNo' AND igm_details.BL_No='$blNo'
		UNION
		SELECT  cont_number,cont_size,cont_weight,cont_height,cont_status 
		FROM igm_sup_detail_container
		INNER JOIN igm_supplimentary_detail ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
		WHERE igm_supplimentary_detail.Import_Rotation_No='$rotNo' AND igm_supplimentary_detail.BL_No='$blNo'";
		$igmContList = $this->bm->dataSelectDb1($cont_igm);
		
		$cont_be="SELECT cont_number,freight_kind FROM sad_info
		INNER JOIN sad_container ON sad_info.id=sad_container.sad_id
		WHERE reg_no=1833904";
		$beContList = $this->bm->dataSelectDb1($cont_be);
		
		$data['igmContList']=$igmContList;		
		$data['beContList']=$beContList;
		
		
		if($exchnStatus==0)
		{
			$data['exchnStatus']='no';
			
		}
		else
		{

		$query = "select assigned_unit.unit_no as one_stop_point, verify_unit,DATE_FORMAT(date(verify_time),'%d%m%y')as verify_time,				
				verify_number, do_no,  do_date, valid_up_to_date, cus_rel_odr_no, cus_rel_odr_date, paper_file_date,exit_note_number, date, no_of_truck,   shed_tally_info.id, 
				shed_tally_info.import_rotation, igm_supplimentary_detail.BL_No, verify_number, master_Line_No,igm_supplimentary_detail.Pack_Marks_Number, 
				mlocode, igm_supplimentary_detail.master_BL_No,igm_supplimentary_detail.BL_No,
				igm_supplimentary_detail.Description_of_Goods,igm_supplimentary_detail.Notify_name,organization_profiles.Organization_Name, igm_sup_detail_container.Cont_gross_weight,
				igm_sup_detail_container.cont_weight, shed_tally_info.actual_marks, shed_tally_info.cont_number,
				igm_sup_detail_container.cont_height,igm_sup_detail_container.cont_size, igm_sup_detail_container.cont_type,
				igm_supplimentary_detail.Pack_Description,igm_supplimentary_detail.Pack_Number, shed_tally_info.rcv_unit, verify_other_data.be_no,
				verify_other_data.be_date,verify_other_data.cnf_lic_no, cnf_name, shed_bill_master.grand_total,
				rcv_pack,igm_detail_container.cont_status as mloStatus, igm_sup_detail_container.cont_status as ffwStatus, shed_loc, date(now()) as date
				from shed_tally_info  
				inner join igm_supplimentary_detail on igm_supplimentary_detail.id=shed_tally_info.igm_sup_detail_id
				inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
                                left join shed_bill_master on shed_bill_master.verify_no=shed_tally_info.verify_number
				left join igm_details on igm_details.id=igm_supplimentary_detail.igm_detail_id
                                inner join igm_detail_container on igm_details.id=igm_detail_container.igm_detail_id
				left join verify_other_data on verify_other_data.shed_tally_id=shed_tally_info.id 
				left join organization_profiles on igm_supplimentary_detail.Submitee_Org_Id=organization_profiles.id
                left join assigned_unit on assigned_unit.rotation=shed_tally_info.import_rotation
                where igm_supplimentary_detail.BL_No='$blNo' and igm_supplimentary_detail.Import_Rotation_No='$rotNo'";
           $deliveryList = $this->bm->dataSelectDb1($query);   
		   
		   $subQuery="select date(sparcsn4.vsl_vessel_visit_details.flex_date08) as rtnValue from sparcsn4.vsl_vessel_visit_details where ib_vyg='$rotNo'";
		   $commLandDate = $this->bm->dataSelect($subQuery);
		   //$commLandDate=2;

		   $data['deliveryList']=$deliveryList;
		   $data['commLandDate']=$commLandDate;		
		}		   
		  // echo $commLandDate;
           echo json_encode($data);	    
		   
	}
	
	function getDeliveryBySeaInfo()
	{
		$seaNo = $_GET['seaNo'];
		
		$querySea="SELECT DISTINCT sum_declare AS blNo,RIGHT(REPLACE(manif_num,' ','/'),9) AS rotNo FROM sad_info
		INNER JOIN sad_item ON  sad_info.id=sad_item.sad_id
		WHERE reg_no=$seaNo";
		$seaInfo = $this->bm->dataSelectDb1($querySea);
		
		
		$blNo = $seaInfo[0]['blNo'];
		$rotNo = $seaInfo[0]['rotNo'];
		
		$login_id = $this->session->userdata('login_id');
		
		$exchageStatusQuery="select exchange_done_status AS rtnValue from shed_tally_info 
							inner join igm_supplimentary_detail on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
							where shed_tally_info.import_rotation='$rotNo' and igm_supplimentary_detail.BL_No='$blNo'";
							
		$exchnStatus = $this->bm->dataReturnDb1($exchageStatusQuery);
		
		$cont_igm="SELECT  cont_number,cont_size,cont_weight,cont_height,cont_status 
		FROM igm_detail_container
		INNER JOIN igm_details ON igm_detail_container.igm_detail_id=igm_details.id
		WHERE igm_details.Import_Rotation_No='2019/557' AND igm_details.BL_No='OOLU2616413350'
		UNION
		SELECT  cont_number,cont_size,cont_weight,cont_height,cont_status 
		FROM igm_sup_detail_container
		INNER JOIN igm_supplimentary_detail ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
		WHERE igm_supplimentary_detail.Import_Rotation_No='2019/557' AND igm_supplimentary_detail.BL_No='OOLU2616413350'";
		$igmContList = $this->bm->dataSelectDb1($cont_igm);
		
		$cont_be="SELECT cont_number,freight_kind FROM sad_info
		INNER JOIN sad_container ON sad_info.id=sad_container.sad_id
		WHERE reg_no=1833904";
		$beContList = $this->bm->dataSelectDb1($cont_be);
		
		$data['igmContList']=$igmContList;		
		$data['beContList']=$beContList;		
		
		if($exchnStatus==0)
		{
			$data['exchnStatus']='no';
			
		}
		else
		{
		
			/*$cont_igm="SELECT  cont_number,cont_size,cont_weight,cont_height,cont_status 
			FROM igm_detail_container
			INNER JOIN igm_details ON igm_detail_container.igm_detail_id=igm_details.id
			WHERE igm_details.Import_Rotation_No='$rotNo' AND igm_details.BL_No='$blNo'
			UNION
			SELECT  cont_number,cont_size,cont_weight,cont_height,cont_status 
			FROM igm_sup_detail_container
			INNER JOIN igm_supplimentary_detail ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
			WHERE igm_supplimentary_detail.Import_Rotation_No='$rotNo' AND igm_supplimentary_detail.BL_No='$blNo'";
			$igmContList = $this->bm->dataSelectDb1($cont_igm);
			
			$cont_be="SELECT cont_number,freight_kind FROM sad_info
			INNER JOIN sad_container ON sad_info.id=sad_container.sad_id
			WHERE reg_no=$seaNo";
			$beContList = $this->bm->dataSelectDb1($cont_be);*/
			
			$query = "select assigned_unit.unit_no as one_stop_point, verify_unit,DATE_FORMAT(date(verify_time),'%d%m%y')as verify_time,				
			verify_number, do_no,  do_date, valid_up_to_date, cus_rel_odr_no, cus_rel_odr_date, paper_file_date,exit_note_number, date, no_of_truck,   shed_tally_info.id, 
			shed_tally_info.import_rotation, igm_supplimentary_detail.BL_No, verify_number, master_Line_No,igm_supplimentary_detail.Pack_Marks_Number, 
			mlocode, igm_supplimentary_detail.master_BL_No,igm_supplimentary_detail.BL_No,
			igm_supplimentary_detail.Description_of_Goods,igm_supplimentary_detail.Notify_name,organization_profiles.Organization_Name, igm_sup_detail_container.Cont_gross_weight,
			igm_sup_detail_container.cont_weight, shed_tally_info.actual_marks, shed_tally_info.cont_number,
			igm_sup_detail_container.cont_height,igm_sup_detail_container.cont_size, igm_sup_detail_container.cont_type,
			igm_supplimentary_detail.Pack_Description,igm_supplimentary_detail.Pack_Number, shed_tally_info.rcv_unit, verify_other_data.be_no,
			verify_other_data.be_date,verify_other_data.cnf_lic_no, cnf_name, shed_bill_master.grand_total,
			rcv_pack,igm_detail_container.cont_status as mloStatus, igm_sup_detail_container.cont_status as ffwStatus, shed_loc, date(now()) as date
			from shed_tally_info  
			inner join igm_supplimentary_detail on igm_supplimentary_detail.id=shed_tally_info.igm_sup_detail_id
			inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
							left join shed_bill_master on shed_bill_master.verify_no=shed_tally_info.verify_number
			left join igm_details on igm_details.id=igm_supplimentary_detail.igm_detail_id
							inner join igm_detail_container on igm_details.id=igm_detail_container.igm_detail_id
			left join verify_other_data on verify_other_data.shed_tally_id=shed_tally_info.id 
			left join organization_profiles on igm_supplimentary_detail.Submitee_Org_Id=organization_profiles.id
			left join assigned_unit on assigned_unit.rotation=shed_tally_info.import_rotation
			where igm_supplimentary_detail.BL_No='$blNo' and igm_supplimentary_detail.Import_Rotation_No='$rotNo'";
           $deliveryList = $this->bm->dataSelectDb1($query);   
		   
		   $subQuery="select date(sparcsn4.vsl_vessel_visit_details.flex_date08) as rtnValue from sparcsn4.vsl_vessel_visit_details where ib_vyg='$rotNo'";
		   $commLandDate = $this->bm->dataSelect($subQuery);
		   //$commLandDate=2;

		   $data['deliveryList']=$deliveryList;
		   $data['commLandDate']=$commLandDate;		
		   //$data['igmContList']=$igmContList;		
		   //$data['beContList']=$beContList;		
		}		   
		  // echo $commLandDate;
           echo json_encode($data);	    
		   
	}
	
	
	
	
	function getVerifyInfo()
	{
		$verifyNo = $_GET['verifyNo'];
		//$verify = substr($verifyNo, -4);
		$query ="SELECT verify_number,verify_unit,DATE_FORMAT(date(verify_time),'%d%m%y')as verify_time, shed_tally_info.import_rotation,
		shed_bill_master.bill_no, shed_bill_master.bill_date,cp_no,RIGHT(cp_year,2) AS cp_year,cp_bank_code,cp_unit, date(recv_time) as bank_cp_date, 
		date(verify_time)as verifyDate,shed_tally_info.tally_sheet_number,
		        shed_tally_info.wr_date,rcv_pack,shed_loc, igm_sup_detail_container.cont_number, appraise_date,
		        igm_sup_detail_container.cont_height, igm_sup_detail_container.cont_type,appraise_date,
				igm_supplimentary_detail.BL_No, igm_supplimentary_detail.master_BL_No,
				igm_sup_detail_container.cont_status, igm_sup_detail_container.cont_size, shed_tally_info.shed_yard, shed_tally_info.actual_marks, 
				igm_masters.Vessel_Name, Registration_number_of_transport_code, igm_supplimentary_detail.Pack_Marks_Number, igm_supplimentary_detail.Description_of_Goods, 
				igm_sup_detail_container.Cont_gross_weight,igm_sup_detail_container.cont_weight,
                (shed_tally_info.rcv_pack+shed_tally_info.loc_first) as un_rcv_qty, igm_details.Pack_Description,
				igm_supplimentary_detail.Pack_Number, verify_other_data.be_no, verify_other_data.be_date,
                shed_bill_master.grand_total,shed_loc, if(shed_bill_master.bill_rcv_stat=1,'Paid','Not Paid')as bill_rcv_stat, 
				igm_supplimentary_detail.weight, igm_supplimentary_detail.net_weight_unit,igm_supplimentary_detail.Notify_name, 
				igm_supplimentary_detail.Notify_address, shed_tally_id,
				no_of_truck, verify_other_data.cnf_lic_no, verify_other_data.cnf_name,cus_rel_odr_no,cus_rel_odr_date, paper_file_date,exit_note_number,date, 
				verify_other_data.clerk_assign
				from shed_tally_info 
				inner join igm_supplimentary_detail on igm_supplimentary_detail.id=shed_tally_info.igm_sup_detail_id
				left join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
				inner join igm_masters on igm_supplimentary_detail.igm_master_id=igm_masters.id
				left join igm_details on igm_details.id=igm_supplimentary_detail.igm_detail_id
		 		left join verify_other_data on verify_other_data.shed_tally_id=shed_tally_info.id 
                                left join appraisement_info on igm_supplimentary_detail.BL_No=appraisement_info.BL_NO
                                left join shed_bill_master on shed_bill_master.verify_no=shed_tally_info.verify_number
                                left join bank_bill_recv on shed_bill_master.bill_no=bank_bill_recv.bill_no
				WHERE shed_tally_info.verify_number='$verifyNo'";

      	
        $deliveryList = $this->bm->dataSelectDb1($query);   
        echo json_encode($deliveryList);	 	 
	
	
	}
	
	
	
	//get clerk
	
	function getClerk()
	{
	    $clerkQuery = "SELECT u_name FROM users WHERE org_Type_id=63";						
		$clerkList = $this->bm->dataSelectDb1($clerkQuery);
		echo json_encode($clerkList);
		
	}
	

	
	function Offdock($login_id)
	{
		$offdoc ="";
		if($login_id=='gclt')
		{
		 $offdoc = "3328";
		}
		elseif($login_id=='saplw')
		{
		 $offdoc = "3450";
		}
		elseif($login_id=='ebil')
		{
		 $offdoc = "2594";
		}
		elseif($login_id=='cctcl')
		{
		 $offdoc = "2595";
		}
		elseif($login_id=='ktlt')
		{
		 $offdoc = "2596";
		}
		elseif($login_id=='qnsc')
		{
		 $offdoc = "2597";
		}
		elseif($login_id=='ocl')
		{
		 $offdoc = "2598";
		}
		elseif($login_id=='vlsl')
		{
		 $offdoc = "2599";
		}
		elseif($login_id=='shml')
		{
		 $offdoc = "2600";
		}
		elseif($login_id=='iqen')
		{
		 $offdoc = "2601";
		}
		elseif($login_id=='iltd')
		{
		 $offdoc = "2620";
		}
		
		elseif($login_id=='plcl')
		{
		 $offdoc = "2643";
		}
		elseif($login_id=='shpm')
		{
		 $offdoc = "2646";
		}
		elseif($login_id=='hsat')
		{
		 $offdoc = "3697";
		}
		elseif($login_id=='ellt')
		{
		 $offdoc = "3709";
		}
		elseif($login_id=='bmcd')
		{
		 $offdoc = "3725";
		}
		elseif($login_id=='nclt')
		{
		 $offdoc = "4013";
		}		
		else
		{
		 $offdoc = "";
		}
		return $offdoc;
	}
	// Sourav ....................
	function getBlockList()
	{
		    $yard = $_GET["yard"];
		    $jval = $_GET["jval"];
			$query = "select  $jval as myval,block
						from(
								select block from ctmsmis.yard_block where terminal='$yard'
							) as tt";	
            $rtnBlockList = $this->bm->dataSelect($query);
            echo json_encode($rtnBlockList);
		//$terminal = $_POST["terminalName"];	   
	}
	
	
	function getBlock()
	{
		 $yard = $_GET["yard"];
		 $query = "select distinct block_cpa as block from ctmsmis.yard_block where terminal='$yard' and  block_cpa!='NULL' ORDER BY block ASC";
         $rtnBlockList = $this->bm->dataSelect($query);
         echo json_encode($rtnBlockList);		 
	}
	function getBlockCpa()
	{
		 $yard = $_GET["yard"];
		 $query = "select distinct block_cpa as block from ctmsmis.yard_block where terminal='$yard' and  block_cpa!='NULL' ORDER BY block ASC";
         $rtnBlockList = $this->bm->dataSelect($query);
         echo json_encode($rtnBlockList);		 
	}
	
	/*function getAllYard()
	{
		 //$yard = $_GET["yard"];
		 $query = "select distinct current_position from ctmsmis.mis_exp_unit
					where  mis_exp_unit.delete_flag='0' and mis_exp_unit.snx_type=2 and current_position!=''";
         $rtnYardList = $this->bm->dataSelect($query);
         echo json_encode($rtnYardList);		 
	}*/
	function getAllBlockYard()
	{
		 //$yard = $_GET["yard"];
		 $query = "select distinct block from ctmsmis.yard_block where block is not null ORDER BY block ASC";
         $rtnBlockList = $this->bm->dataSelect($query);
         echo json_encode($rtnBlockList);		 
	}
	function getAllBlock()
	{
		 //$yard = $_GET["yard"];
		 $query = "select distinct block_cpa as block from ctmsmis.yard_block where block_cpa is not null ORDER BY block_cpa";
         $rtnBlockList = $this->bm->dataSelect($query);
         echo json_encode($rtnBlockList);		 
	}
	
	function getCnfCode()
	{
		    $cnf_lic_no= $_GET["cnf_lic_no"];
		    //$jval = $_GET["jval"];
			$getCnfNameQuery= "SELECT distinct(ref_bizunit_scoped.name) as name
									FROM inv_unit 
									INNER JOIN inv_goods ON inv_goods.gkey=inv_unit.goods
									LEFT JOIN ref_bizunit_scoped ON ref_bizunit_scoped.gkey=inv_goods.consignee_bzu
									WHERE ref_bizunit_scoped.id LIKE '$cnf_lic_no'";
				$getCnfName = $this->bm->dataSelect($getCnfNameQuery);
				//$getCnfNameValue=$getCnfName[0]['name'];
			
			
			//$query = "select  $jval as myval,block
						//from(
							//	select block from ctmsmis.yard_block where terminal='$yard'
							//) as tt";	
            //$rtnBlockList = $this->bm->dataSelect($query);
            echo json_encode($getCnfName);
		//$terminal = $_POST["terminalName"];	   
	}
	
	
	
	function contEventDetails()
	{
		$gkey= $_GET["gkey"];	
		$contHistorySql="SELECT sparcsn4.srv_event_types.id,sparcsn4.srv_event_types.description,sparcsn4.srv_event.placed_by,sparcsn4.srv_event.placed_time,sparcsn4.srv_event.creator,sparcsn4.srv_event.created
				FROM sparcsn4.srv_event
				INNER JOIN sparcsn4.srv_event_types ON sparcsn4.srv_event_types.gkey=sparcsn4.srv_event.event_type_gkey
				WHERE sparcsn4.srv_event.applied_to_gkey=$gkey";
	    $contHistory = $this->bm->dataSelect($contHistorySql);
        echo json_encode($contHistory);

	}	
	
	

	// Sourav ......Bill Data Start..............
	function getBillInfo()
	{
		    $tarrif_id= $_GET["tarrif_id"];
			$getBillInfoQuery= "select id as tarrif_id,bil_tariffs.description,long_description,bil_tariffs.gl_code,rate_type,amount as tarrif_rate from bil_tariffs
								inner join bil_tariff_rates on
								bil_tariffs.gkey=bil_tariff_rates.tariff_gkey
								where id='$tarrif_id'";
			$getBillInfo = $this->bm->dataSelectDb1($getBillInfoQuery);
			$data['getBillInfo']=$getBillInfo;
	
            echo json_encode($data);		
	}
	
	function checkVerifyNumberExist()
	{
		$strVerifyNum= $_GET["verify_num"];
		 $strChkQry="select Count(verify_no) as chkNum from shed_bill_master where verify_no='$strVerifyNum'";
		 $rtnChkList = $this->bm->dataSelectDb1($strChkQry);
		 if($rtnChkList[0]['chkNum']<1)
		 {
			 $strChkShedTallyQry="select Count(verify_number) as chkNum from shed_tally_info where verify_number='$strVerifyNum'";
			 $rtnChkShedTallyList = $this->bm->dataSelectDb1($strChkShedTallyQry);
			 if($rtnChkShedTallyList[0]['chkNum']<1)
			 {
				 $data['rtnChkList']=0;  // Not Found
			 }
			 else{
				 $data['rtnChkList']=1; // Exist in Shed Tally Info
			 }
		 }
		 else{
			  $data['rtnChkList']=2; // Exist in Shed Bill Master
		 }
		
		 echo json_encode($data);
	}
	function getBillDetails()
	{
			$strVerifyNum= $_GET["verify_num"];
			$unstfDt= $_GET["unstfDt"];
			
			$uptoDt= $_GET["uptoDt"];
			$rpc= $_GET["rpc"];
			$hcCharge= $_GET["hcCharge"];
			$scCharge= $_GET["scCharge"];
			$vatInfo= $_GET["vatInfo"];
			$mlwf= $_GET["mlwf"];
			
			$section = $this->session->userdata('section');
			
			/*$strChkQry="select 1 as chkNum from shed_bill_master where verify_no='$strVerifyNum'";
			$rtnChkList = $this->bm->dataSelectDb1($strChkQry);
			$chkNum = $rtnChkList[0]['chkNum'];
			echo "Check Number : ".$chkNum;
			if($chkNum=='1')
			{
				$strChargeList="select gl_code,description,tarrif_rate,Qty,qday,amt,vatTK,mlwfTK from shed_bill_details where verify_no='$strVerifyNum'";
				$chargeList = $this->bm->dataSelectDb1($strChargeList);
			}
			else
			{*/
			$this->tariffGenerate($strVerifyNum,$unstfDt,$uptoDt,$rpc,$hcCharge,$scCharge);
		    //$jval = $_GET["jval"];
			$str="select  import_rotation,shed_tally_info.cont_number,verify_number,Vessel_Name,Line_No,igm_supplimentary_detail.BL_No,igm_sup_detail_container.Cont_gross_weight as cont_weight,igm_sup_detail_container.cont_size,cont_height,
						  igm_sup_detail_container.cont_status,igm_sup_detail_container.cont_type,wr_date,wr_upto_date,cnf_lic_no,be_no,be_date,notify_name,cnf_name,rcv_pack,loc_first,total_pack,
						  igm_supplimentary_detail.Pack_Number,igm_supplimentary_detail.Consignee_code,igm_supplimentary_detail.Consignee_name,
						  verify_other_data.valid_up_to_date,verify_other_data.do_no,verify_other_data.do_date,verify_other_data.comm_landing_date,rcv_unit,equipment
					from shed_tally_info
					inner join igm_supplimentary_detail on igm_supplimentary_detail.id = shed_tally_info.igm_sup_detail_id
					inner join igm_sup_detail_container on shed_tally_info.igm_sup_detail_id=igm_sup_detail_container.igm_sup_detail_id
					inner join igm_masters on igm_supplimentary_detail.igm_master_id=igm_masters.id
					left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
					left join appraisement_info on appraisement_info.rotation=igm_supplimentary_detail.Import_Rotation_No and appraisement_info.BL_NO=igm_supplimentary_detail.BL_No
					where verify_number='$strVerifyNum'";					
					$rtnBillList = $this->bm->dataSelectDb1($str);
			
			$import_rotation = $rtnBillList[0]['import_rotation'];
			$container = $rtnBillList[0]['cont_number'];
			$blNo= $rtnBillList[0]['BL_No'];
					
			$arraivalDateQry="select date(sparcsn4.argo_carrier_visit.ata) as ata from sparcsn4.vsl_vessel_visit_details
									inner join sparcsn4.argo_carrier_visit 
									on sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
									where sparcsn4.vsl_vessel_visit_details.ib_vyg='$import_rotation'";
			$arraivalDate = $this->bm->dataSelect($arraivalDateQry);
			$arraivalDateValue=$arraivalDate[0]['ata'];
			
			$getDataAppraisalQry="select equipment,appraise_date,carpainter_use,hosting_charge,extra_movement,scale_for from 
									appraisement_info where rotation='$import_rotation' and BL_NO='$blNo'";
			$appraisalData = $this->bm->dataSelectDb1($getDataAppraisalQry);

			$getExRateQuery= "select rate from bil_currency_exchange_rates where DATE(effective_date)= '$arraivalDateValue'";
			$getExRate = $this->bm->dataSelectDb1($getExRateQuery);
			$getExRateValue=$getExRate[0]['rate'];
			
			/**********************Auto Bill Start*******************************/
			//if($unstfDt=="")
				/*{
					$getDateDiffQuery= "SELECT IFNULL(DATEDIFF(verify_other_data.valid_up_to_date,DATE_ADD(wr_date,INTERVAL 4 day)),0) as dif from shed_tally_info
										left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
										where shed_tally_info.verify_number='$strVerifyNum'";
				}
				else
				{*/
					$getDateDiffQuery= "SELECT IFNULL(DATEDIFF('$uptoDt',DATE_ADD('$unstfDt',INTERVAL 4 day)),0) as dif from shed_tally_info
										left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
										where shed_tally_info.verify_number='$strVerifyNum'";
				/*}*/
			/*$getDateDiffQuery= "select IFNULL(DATEDIFF(sparcsn4.inv_unit_fcy_visit.time_out,DATE_ADD(sparcsn4.inv_unit_fcy_visit.time_in,INTERVAL 4 day)),0) as dif
												from sparcsn4.inv_unit
												inner join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
												where sparcsn4.inv_unit.id='$container' and sparcsn4.inv_unit.category='STRGE'";*/
						$getDateDiff = $this->bm->dataSelectDb1($getDateDiffQuery);
						$dateDiffValue=$getDateDiff[0]['dif'];
						//$dateDiffValue=15;
						
						
						$qry= "select verify_no,tarrif_id,bil_tariffs.description,bil_tariffs.gl_code,IFNULL(bil_tariff_rates.amount,0) as tarrif_rate,
							ifnull(verify_other_data.update_ton,CEIL(igm_sup_detail_container.Cont_gross_weight /1000)) as Qty,
							igm_sup_detail_container.Cont_gross_weight as cont_weight,
					(case 
						when 
							tarrif_id like '%1ST%'
						then 
							 if($dateDiffValue<7,$dateDiffValue,7)
						else 
							case 
								when 
									tarrif_id like '%2ND%'
								then 
									if($dateDiffValue<14,$dateDiffValue-7,7)
								else  
									if(tarrif_id like '%3RD%',$dateDiffValue-14,1)
							end
					end) as qday,
										(select tarrif_rate*Qty*qday) as amt,
										(select if($vatInfo='0',0,(select amt*15/100))) as vatTK
										from shed_bill_tarrif
										inner join bil_tariffs on 
										shed_bill_tarrif.tarrif_id= bil_tariffs.id
										inner join bil_tariff_rates on
										bil_tariffs.gkey=bil_tariff_rates.tariff_gkey
										inner join shed_tally_info on
										shed_tally_info.verify_number=shed_bill_tarrif.verify_no
										inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id = shed_tally_info.igm_sup_detail_id
										inner join verify_other_data on verify_other_data.shed_tally_id=shed_tally_info.id
										where verify_no='$strVerifyNum'";
							//echo $qry;
						$chargeList = $this->bm->dataSelectDb1($qry);
			
			
			
			/**********************Auto Bill End*******************************/
			
			$qryTotalBill= "select SUM(amt) as totAmount,sum(vatTK) as totVat ,'0.0' as totMlwf from (select verify_no,tarrif_id,bil_tariffs.description,bil_tariffs.gl_code,IFNULL(bil_tariff_rates.amount,0) as tarrif_rate,
							ifnull(verify_other_data.update_ton,CEIL(igm_sup_detail_container.Cont_gross_weight/1000)) as Qty,
							igm_sup_detail_container.Cont_gross_weight,
					(case 
						when 
							tarrif_id like '%1ST%'
						then 
							 if($dateDiffValue<7,$dateDiffValue,7)
						else 
							case 
								when 
									tarrif_id like '%2ND%'
								then 
									if($dateDiffValue<14,$dateDiffValue-7,7)
								else  
									if(tarrif_id like '%3RD%',$dateDiffValue-14,1)
							end
					end) as qday,
										(select tarrif_rate*Qty*qday) as amt,
										(select if($vatInfo='0',0,(select amt*15/100))) as vatTK
										from shed_bill_tarrif
										inner join bil_tariffs on 
										shed_bill_tarrif.tarrif_id= bil_tariffs.id
										inner join bil_tariff_rates on
										bil_tariffs.gkey=bil_tariff_rates.tariff_gkey
										inner join shed_tally_info on
										shed_tally_info.verify_number=shed_bill_tarrif.verify_no
										inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id = shed_tally_info.igm_sup_detail_id
										inner join verify_other_data on verify_other_data.shed_tally_id=shed_tally_info.id
										where verify_no='$strVerifyNum') tbl";
							//echo $qry;
						$totalBillList = $this->bm->dataSelectDb1($qryTotalBill);
	//}
			$oneStopPoint="select distinct unit_no from assigned_unit where rotation='$import_rotation'";
			$oneStopList = $this->bm->dataSelectDb1($oneStopPoint);
			$oneStop=$oneStopList[0]['unit_no'];
			
			
			$data['totalBillList']=$totalBillList;
			$data['appraisalData']=$appraisalData;
			$data['rtnBillList']=$rtnBillList;
			$data['chargeList']=$chargeList;
			$data['arraivalDateValue']=$arraivalDateValue;
			$data['getExRateValue']=$getExRateValue;
			//$data['sectionValue']=$this->session->userdata('section');
			$data['sectionValue']=$oneStop;
			$data['unstfDt']=$unstfDt;
			
			$data['uptoDt']=$uptoDt;
			$data['rpc']=$rpc;
			$data['hcCharge']=$hcCharge;
			$data['scCharge']=$scCharge;
			
			$data['dateDiffValue']=$dateDiffValue;
            echo json_encode($data);
		//$terminal = $_POST["terminalName"];	   
	}
	function tariffGenerate($billVerify,$unstfDt,$uptoDt,$rpc,$hcCharge,$scCharge)
	{
		/*$qry="select igm_sup_detail_container.cont_status,loc_first,shed_tally_info.cont_number	 
				from  igm_supplimentary_detail
				inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
				left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
				where shed_tally_info.verify_number='$billVerify'
				group by igm_sup_detail_container.id";*/
		$qry="select igm_sup_detail_container.cont_status,rcv_pack,loc_first,shed_tally_info.cont_number,equipment,appraisement_info.equipment_id,used_equipment.equipment_name	 
				from  igm_supplimentary_detail
				inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
				left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id 
				left join appraisement_info on igm_supplimentary_detail.Import_Rotation_No=appraisement_info.rotation and igm_supplimentary_detail.BL_No=appraisement_info.BL_NO
				left join used_equipment on used_equipment.equipment_id=appraisement_info.equipment_id
				where shed_tally_info.verify_number='$billVerify'
				group by igm_sup_detail_container.id";
				
		$conStatus = $this->bm->dataSelectDb1($qry); 
		$cont_status = $conStatus[0]['cont_status'];
		$loc_first = $conStatus[0]['loc_first'];
		$rcv_pack = $conStatus[0]['rcv_pack'];
		$cont_number = $conStatus[0]['cont_number'];
		//echo "Starus==".$loc_first;
		$equip_charge = $conStatus[0]['equipment'];
		$equip_id = $conStatus[0]['equipment_id'];
		$equip_name = $conStatus[0]['equipment_name'];
		if($cont_status='LCL')
		{
			$strRiverDues="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
				values('$billVerify',(select get_shed_bill_tarrif('$billVerify',1)),1,1)";
			$statRiverDues=$this->bm->dataInsertDB1($strRiverDues);
				
			$strStuffUnStuff="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
				values('$billVerify',(select get_shed_bill_tarrif('$billVerify',2)),1,2)";
			$statStuffUnStuff=$this->bm->dataInsertDB1($strStuffUnStuff);
			
			if($hcCharge!=0)
			{
				$strHostingCharge="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
				values('$billVerify',(select get_shed_bill_tarrif('$billVerify',3)),1,3)";
				$statHostingCharge=$this->bm->dataInsertDB1($strHostingCharge);
			}
			else
			{
				$strDelHostingCharge="delete from shed_bill_tarrif where verify_no='$billVerify' and event_type=3";
				$statDelHostingCharge=$this->bm->dataInsertDB1($strDelHostingCharge);
			}
			
			if($rpc!=0)
			{
				$strScaleCharge="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
					values('$billVerify',(select get_shed_bill_tarrif('$billVerify',12)),1,12)";
				$statScaleCharge=$this->bm->dataInsertDB1($strScaleCharge);
			}
				else
			{
				$strDelScaleCharge="delete from shed_bill_tarrif where verify_no='$billVerify' and event_type=12";
				$statDelScaleCharge=$this->bm->dataInsertDB1($strDelScaleCharge);
			}
			
			if($scCharge!=0)
			{
				
				$strWeightmentCharge="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
					values('$billVerify',(select get_shed_bill_tarrif('$billVerify',10)),1,10)";
				$statWeightmentCharge=$this->bm->dataInsertDB1($strWeightmentCharge);
			}
				else
			{				
				$strDelWeightmentCharge="delete from shed_bill_tarrif where verify_no='$billVerify' and event_type=10";
				$statDelWeightmentCharge=$this->bm->dataInsertDB1($strDelWeightmentCharge);
			}
			if($loc_first>0)
			{
				/********************Add 4 Days*************************/
				/*if($unstfDt=="")
				{
					$getDateDiffQuery= "SELECT IFNULL(DATEDIFF(valid_up_to_date,DATE_ADD(wr_date,INTERVAL 4 day)),0) as dif from shed_tally_info
										left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
										where shed_tally_info.verify_number='$billVerify'";
				}
				else
				{*/
					$getDateDiffQuery= "SELECT IFNULL(DATEDIFF('$uptoDt',DATE_ADD('$unstfDt',INTERVAL 4 day)),0) as dif from shed_tally_info
										left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
										where shed_tally_info.verify_number='$billVerify'";
				/*}*/
				
				$getDateDiff = $this->bm->dataSelectDb1($getDateDiffQuery);
				
				$dateDiffValue=$getDateDiff[0]['dif'];
				if($dateDiffValue>14)
				{
					//9
					$strStuffUnStuff="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
						values('$billVerify',(select get_shed_bill_tarrif('$billVerify',9)),1,9)";
					$statStuffUnStuff=$this->bm->dataInsertDB1($strStuffUnStuff);
					//8
					$strStuffUnStuff1="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
						values('$billVerify',(select get_shed_bill_tarrif('$billVerify',8)),1,8)";
					$statStuffUnStuff1=$this->bm->dataInsertDB1($strStuffUnStuff1);
					//7
					$strStuffUnStuff2="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
						values('$billVerify',(select get_shed_bill_tarrif('$billVerify',7)),1,7)";
					$statStuffUnStuff2=$this->bm->dataInsertDB1($strStuffUnStuff2);
				}
				else if($dateDiffValue>7 and $dateDiffValue<=14)
				{
					//7
					$strStuffUnStuff="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
						values('$billVerify',(select get_shed_bill_tarrif('$billVerify',7)),1,7)";
					$statStuffUnStuff=$this->bm->dataInsertDB1($strStuffUnStuff);
					//8
					$strStuffUnStuff1="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
						values('$billVerify',(select get_shed_bill_tarrif('$billVerify',8)),1,8)";
					$statStuffUnStuff1=$this->bm->dataInsertDB1($strStuffUnStuff1);
				}
				else if($dateDiffValue>0 and $dateDiffValue<=7)
				{
					//7
					$strStuffUnStuff="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
						values('$billVerify',(select get_shed_bill_tarrif('$billVerify',7)),1,7)";
					$statStuffUnStuff=$this->bm->dataInsertDB1($strStuffUnStuff);
				}
			}
			//else if($loc_first<=0)
			//{
				/********************Add 4 Days*************************/
			if($rcv_pack>0)
			{
				if($unstfDt=="")
				{
					$getDateDiffQuery= "SELECT IFNULL(DATEDIFF('$uptoDt',DATE_ADD('$unstfDt',INTERVAL 4 day)),0) as dif from shed_tally_info
										left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
										where shed_tally_info.verify_number='$billVerify'";
				}
				else
				{
					$getDateDiffQuery= "SELECT IFNULL(DATEDIFF('$uptoDt',DATE_ADD('$unstfDt',INTERVAL 4 day)),0) as dif from shed_tally_info
										left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
										where shed_tally_info.verify_number='$billVerify'";
				}
				$getDateDiff = $this->bm->dataSelectDb1($getDateDiffQuery);
				$dateDiffValue=$getDateDiff[0]['dif'];
				//$dateDiffValue = 18;
				if($dateDiffValue>14)
				{
					//4
					$strStuffUnStuff="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
						values('$billVerify',(select get_shed_bill_tarrif('$billVerify',4)),1,4)";
					$statStuffUnStuff=$this->bm->dataInsertDB1($strStuffUnStuff);
					//5
					$strStuffUnStuff="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
						values('$billVerify',(select get_shed_bill_tarrif('$billVerify',5)),1,5)";
					$statStuffUnStuff=$this->bm->dataInsertDB1($strStuffUnStuff);
					//6
					$strStuffUnStuff="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
						values('$billVerify',(select get_shed_bill_tarrif('$billVerify',6)),1,6)";
					$statStuffUnStuff=$this->bm->dataInsertDB1($strStuffUnStuff);
				}
				else if($dateDiffValue>7 and $dateDiffValue<=14)
				{
					//4
					$strStuffUnStuff="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
						values('$billVerify',(select get_shed_bill_tarrif('$billVerify',4)),1,4)";
					$statStuffUnStuff=$this->bm->dataInsertDB1($strStuffUnStuff);
					//5
					$strStuffUnStuff="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
						values('$billVerify',(select get_shed_bill_tarrif('$billVerify',5)),1,5)";
					$statStuffUnStuff=$this->bm->dataInsertDB1($strStuffUnStuff);
				}
				else if($dateDiffValue>0 and $dateDiffValue<=7)
				{
					//4
					$strStuffUnStuff="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
						values('$billVerify',(select get_shed_bill_tarrif('$billVerify',4)),1,4)";
					$statStuffUnStuff=$this->bm->dataInsertDB1($strStuffUnStuff);
				}
			}
				//echo "Diff :  ".$getDateDiff[0]['dif'];
			//}
			/*if($equip_id==1)  //USED EQUIPMENT
			{
				$strUsedEquipmentCharge="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
				values('$billVerify',(select get_shed_bill_tarrif('$billVerify',13)),1,13)";
				$statUsedEquipmentCharge=$this->bm->dataInsertDB1($strUsedEquipmentCharge);
			}
			else if($equip_id==2)  //USED EQUIPMENT
			{
				$strUsedEquipmentCharge="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
				values('$billVerify',(select get_shed_bill_tarrif('$billVerify',14)),1,14)";
				$statUsedEquipmentCharge=$this->bm->dataInsertDB1($strUsedEquipmentCharge);
			}
			else if($equip_id==3)  //USED EQUIPMENT
			{
				$strUsedEquipmentCharge="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
				values('$billVerify',(select get_shed_bill_tarrif('$billVerify',15)),1,15)";
				$statUsedEquipmentCharge=$this->bm->dataInsertDB1($strUsedEquipmentCharge);
			}
			else if($equip_id==4)  //USED EQUIPMENT
			{
				$strUsedEquipmentCharge="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
				values('$billVerify',(select get_shed_bill_tarrif('$billVerify',16)),1,16)";
				$statUsedEquipmentCharge=$this->bm->dataInsertDB1($strUsedEquipmentCharge);
			}
			else if($equip_id==5)  //USED EQUIPMENT
			{
				$strUsedEquipmentCharge="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
				values('$billVerify',(select get_shed_bill_tarrif('$billVerify',17)),1,17)";
				$statUsedEquipmentCharge=$this->bm->dataInsertDB1($strUsedEquipmentCharge);
			}
			else
			{
				$strDelUsedEquipmentCharge="delete from shed_bill_tarrif where verify_no='$billVerify' and event_type in (13,14,15,16,17)";
				$statDelUsedEquipmentCharge=$this->bm->dataInsertDB1($strDelUsedEquipmentCharge);
			}*/
		}
		else
		{
			echo 'FCL';
		}
	}
	function getDataFromShedBill()
	{
			$strVerifyNum= $_GET["verify_num"];
			
			$chkDataExist="select count(bill_no) as countBill from shed_bill_master where verify_no='$strVerifyNum'";
			$rtnExistData = $this->bm->dataSelectDb1($chkDataExist);
			$dataStat=$rtnExistData[0]['countBill'];
			if($dataStat>0)
			{
					$shedBillMasterQry="select concat(right(YEAR(bill_date),2),'/',
								concat(if(length(bill_generation_no)=1,'00000',if(length(bill_generation_no)=2,'0000',if(length(bill_generation_no)=3,'000',
								if(length(bill_generation_no)=4,'00',if(length(bill_generation_no)=5,'0',''))))),bill_generation_no)) as bill_no,
								verify_no,unit_no,cpa_vat_reg_no,ex_rate,bill_date,arraival_date,shed_bill_master.import_rotation,vessel_name,cl_date,bl_no,shed_bill_master.wr_date,
								shed_bill_master.wr_upto_date as valid_up_to_date,importer_vat_reg_no,importer_name,cnf_lic_no,cnf_agent,be_no,be_date,ado_no,ado_date,ado_valid_upto,manifest_qty,
								shed_bill_master.cont_size,shed_bill_master.cont_height,bill_rcv_stat,shed_bill_master.cont_weight,da_bill_no,bill_for,less,part_bl,shed_bill_master.remarks,total_port,total_vat,total_mlwf,less_amt_port,
								less_amt_vat,grand_total,cont_type,rcv_pack,loc_first,extra_movement from shed_bill_master 
								left join shed_tally_info on verify_number=shed_bill_master.verify_no
								inner join igm_sup_detail_container on shed_tally_info.igm_sup_detail_id=igm_sup_detail_container.igm_sup_detail_id
								where verify_no='$strVerifyNum'";
					$shedBillMasterList = $this->bm->dataSelectDb1($shedBillMasterQry);
					
					
					$shedBillDetailQry="select shed_bill_details.id,bil_tariffs.id as tarrif_id,verify_no,bill_no,shed_bill_details.gl_code,shed_bill_details.description,tarrif_rate,Qty,qday,amt,vatTK,mlwfTK 
										from shed_bill_details 
										left join bil_tariffs on bil_tariffs.gl_code=shed_bill_details.gl_code
										where verify_no='$strVerifyNum' and bill_no in (select MAX(bill_no) from shed_bill_details where verify_no='$strVerifyNum')";
										
					$shedBillDetailList = $this->bm->dataSelectDb1($shedBillDetailQry);
					
					$data['shedBillDetailList']=$shedBillDetailList;
					$data['shedBillMasterList']=$shedBillMasterList;
					$data['dataExist']=1;
			}
			else
			{
				$data['dataExist']=0;
				$data['shedBillDetailList']="";
				$data['shedBillMasterList']="";
			}
			
			
            echo json_encode($data);
	}
	// Sourav ......Bill Data End..............
			 
	function getDeliveryByVerifyInfo()
	{
		$verify_num = $_GET['verify_num'];
		
		$query = "SELECT * FROM (SELECT igm_supplimentary_detail.id,igm_masters.Vessel_Name,igm_supplimentary_detail.Import_Rotation_No,igm_supplimentary_detail.Pack_Marks_Number,igm_supplimentary_detail.Description_of_Goods,IFNULL(shed_tally_info.verify_number,0) AS verify_number,verify_other_data.cnf_name,verify_other_data.be_no,verify_other_data.be_date,igm_details.Consignee_name,igm_supplimentary_detail.Pack_Description,igm_details.BL_No AS mloline,igm_supplimentary_detail.BL_No AS ffwline,(SELECT mlocode FROM igm_details 
		INNER JOIN igm_supplimentary_detail sdtl ON sdtl.igm_detail_id=igm_details.id
		WHERE sdtl.id=igm_supplimentary_detail.id) AS mlocode,igm_supplimentary_detail.Pack_Number,(SELECT igm_supplimentary_detail.Pack_Number-IFNULL((SELECT SUM(delv_pack) AS delv_pack FROM do_information WHERE verify_no='$verify_num' AND delv_status=1),0)) AS bal_pack,igm_supplimentary_detail.Notify_name,igm_supplimentary_detail.Notify_address
		FROM  igm_supplimentary_detail
		INNER JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
		INNER JOIN igm_masters ON igm_supplimentary_detail.igm_master_id=igm_masters.id
		LEFT JOIN  shed_tally_info ON shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
		LEFT JOIN verify_other_data ON shed_tally_info.id=verify_other_data.shed_tally_id
		LEFT JOIN igm_details ON igm_details.id=igm_supplimentary_detail.igm_detail_id 
		LEFT JOIN do_information ON do_information.verify_no=shed_tally_info.verify_number
		WHERE shed_tally_info.verify_number='$verify_num') AS tbl ORDER BY id ASC LIMIT 1";
           
		$deliveryList = $this->bm->dataSelectDb1($query);   
        echo json_encode($deliveryList);	 
	}
	
	function getTruck()
	{
		$verify_num = $_GET['verify_num'];
		
		$query = "SELECT truck_id FROM do_information WHERE verify_no='$verify_num' AND delv_status='0'";
           
		$rtntrkno = $this->bm->dataSelectDb1($query);  
        echo json_encode($rtntrkno);	 
	}
	
	/* function getbalance()
	{
		$truck_id=$_GET['truck_id'];
		$verify_num=$_GET['verify_num'];
		
	//	$query = "SELECT delv_pack,truck_id,gate_no FROM do_information WHERE truck_id='$truck_id'";
		$packQuery = "SELECT IFNULL(SUM(delv_pack),0) AS delv_pack FROM do_information WHERE delv_status=1 AND verify_no='$verify_num'";		
		$rtndelvPack = $this->bm->dataSelectDb1($packQuery); 
        $data['rtndelvPack']=$rtndelvPack;	
		
		$query = "SELECT gate_no,truck_id FROM do_information WHERE delv_status=0 AND verify_no='$verify_num' and truck_id='$truck_id'";		
		$rtndelv = $this->bm->dataSelectDb1($query);  
		$data['rtndelv']=$rtndelv;	
		
        echo json_encode($data);
	} */
	
	function getbalance()
	{
		$truck_id=$_GET['truck_id'];
	//	$verify_num=$_GET['verify_num'];
		
	//	$query = "SELECT delv_pack,truck_id,gate_no FROM do_information WHERE truck_id='$truck_id'";
		/* $packQuery = "SELECT IFNULL(SUM(delv_pack),0) AS delv_pack FROM do_information WHERE delv_status=1 AND verify_no='$verify_num'";		
		$rtndelvPack = $this->bm->dataSelectDb1($packQuery); 
        $data['rtndelvPack']=$rtndelvPack;	 */
		
		$query = "SELECT gate_no,truck_id FROM do_information WHERE delv_status=0 AND truck_id='$truck_id'";		
		$rtndelv = $this->bm->dataSelectDb1($query);  
	//	$data['rtndelv']=$rtndelv;	
		
        echo json_encode($rtndelv);
	}
	
	function ExchangeDoneStatusChange()
	{
		//$rotation=str_replace("_","/",$this->uri->segment(3));
		//$container=str_replace("_","/",$this->uri->segment(4));
		$rotation= $_GET["rotation"];
		$container= $_GET["container"];
		
		$str = "update shed_tally_info set exchange_done_status=1
									where import_rotation='$rotation' and cont_number='$container' ";
		$stat = $this->bm->dataInsertDB1($str);
		
		if($stat==1)
			{
				$data['stat']="1";
				//$data['save_btn_status']=0;
				//$data['update_btn_status']=0;
				//$data['view_btn_status']=0;
			}
			else
			{
				$data['stat']="0";
				//$data['update_btn_status']=0;
				//$data['view_btn_status']=0;
			}
			//$data['shedBillDetailList']=$shedBillDetailList;
			//$data['shedBillMasterList']=$shedBillMasterList;
			
            echo json_encode($data);
	}
	function getEquipmentCharge()
	{
		$equipID= $_GET["equipID"];
		$getEquipChargeQuery= "select equipment_charge from used_equipment where equipment_id='$equipID'";
		$getEquipCharge = $this->bm->dataSelectDb1($getEquipChargeQuery);
        echo json_encode($getEquipCharge);   
	}
	// UPLOAD SIGNATURE START//
		function uploadSignatureSrOfficer()
		{
			$preRot=$_GET["rotation"];
			$rot=str_replace('/','_',$preRot);
			$cont=$_GET["container"];
			$user=$_GET["user"];
			
			$upload_dir = FCPATH . 'resources/images/Signature/';  //implement this function yourself
			
			$img = $_GET['hiddenPath'];
			$img_ff = $_GET['hiddenPath_ff'];
			$img_cpa = $_GET['hiddenPath_cpa'];
			
							//echo "Image : ".$img;
							//echo "Rot : ".$rot;
							
			$imgBs = str_replace('data:image/png;base64,', '', $img);
			$imgRep = str_replace(' ', '+', $imgBs);
			$dataImg = base64_decode($imgRep);
			
			$imgBs_ff = str_replace('data:image/png;base64,', '', $img_ff);
			$imgRep_ff = str_replace(' ', '+', $imgBs_ff);
			$dataImg_ff = base64_decode($imgRep_ff);
			
			$imgBs_cpa = str_replace('data:image/png;base64,', '', $img_cpa);
			$imgRep_cpa = str_replace(' ', '+', $imgBs_cpa);
			$dataImg_cpa= base64_decode($imgRep_cpa);
			
			//echo "Data : ".$data;
			$sign_name="sign_".$rot."_".$cont."_"."bo"."_".$user.".png";
			$file = $upload_dir.$sign_name;
			
			$sign_name_ff="sign_".$rot."_".$cont."_"."ff"."_".$user.".png";
			$file_ff = $upload_dir.$sign_name_ff;
			
			$sign_name_cpa="sign_".$rot."_".$cont."_"."cpa"."_".$user.".png";
			$file_cpa = $upload_dir.$sign_name_cpa;
					
			$str = "update shed_tally_info set signature_path_berth='$sign_name',signature_path_freight='$sign_name_ff',signature_path_cpa='$sign_name_cpa' where import_rotation='$preRot' and cont_number='$cont'";				
							//echo $str;
			$stat = $this->bm->dataInsertDB1($str);  //comment out to stop insertion
			if($stat==1)
			{
				$data['stat']="1";
				$success = file_put_contents($file, $dataImg);
				$success_ff = file_put_contents($file_ff, $dataImg_ff);
				$success_cpa = file_put_contents($file_cpa, $dataImg_cpa);
			}
			else
			{
				$data['stat']="0";	
			}
			echo json_encode($data);
		}
		// UPLOAD SIGNATURE END//
	function getAllYard()
	{
		 //$yard = $_GET["yard"];
		 $query = "select distinct current_position from ctmsmis.mis_exp_unit
					where  mis_exp_unit.delete_flag='0' and mis_exp_unit.snx_type=2 and current_position!=''";
         $rtnYardList = $this->bm->dataSelect($query);
         echo json_encode($rtnYardList);		 
	}
	
	//yard start
	function loadBlock()
	{
		$terminal = $_GET["terminal"];
		$query = "select distinct Block_No from ctmsmis.tmp_assignment_type_new where Yard_No='$terminal' order by Block_No";
        
		$rtnBlockList = $this->bm->dataSelect($query);        
		echo json_encode($rtnBlockList);		 
	}
	
	function getAssignmentType()
	{
		$terminal = $_GET["terminal"];
		$assignDt = $_GET["assignDt"];
		$strCheck = "select count(*) as rtnValue from ctmsmis.tmp_assignment_type_new where date(flex_date01)='$assignDt'";
		$rtnValue = $this->bm->dataReturn($strCheck);
		//if($rtnValue<1500)
		//{
			$strCallProc = "CALL ctmsmis.update_assignment_type_new('$assignDt')";
			$this->bm->dataUpdate($strCallProc);
		//}
		$query = "select distinct mfdch_value,mfdch_desc from ctmsmis.tmp_assignment_type_new where Yard_No='$terminal'";
        
		$rtnAssignmentList = $this->bm->dataSelect($query);        
		echo json_encode($rtnAssignmentList);		 
	}
	
	function onblockchange()
	{
		$terminal = $_GET["terminal"];
		$assignDt = $_GET["assignDt"];
		$yard = $_GET["yard"];
		
		if($yard=='ALLBLOCK')
			$query = "select distinct mfdch_value,mfdch_desc from ctmsmis.tmp_assignment_type_new where Yard_No='$terminal'";
		else
			$query = "select distinct mfdch_value,mfdch_desc from ctmsmis.tmp_assignment_type_new where Yard_No='$terminal' and Block_No='$yard'";
        
		$rtnBlock = $this->bm->dataSelect($query);        
		echo json_encode($rtnBlock);		 
	}
	//yard end
	
	function updatetable()
	{
		$date = $_GET["date"];
		$block = $_GET["regblock"];
		$strCheck = "select count(*) as rtnValue from ctmsmis.tmp_assignment_type_new where date(flex_date01)='$date'";
		$rtnValue = $this->bm->dataReturn($strCheck);
		if($rtnValue<1000)
		{
			$strCallProc = "CALL ctmsmis.update_assignment_type_new('$date')";
			$this->bm->dataUpdate($strCallProc);
		}		
		
		$query = "select distinct mfdch_value,mfdch_desc from ctmsmis.tmp_assignment_type_new where Block_No='$block'";
        
		$rtnAssignmentList = $this->bm->dataSelect($query);        
		echo json_encode($rtnAssignmentList);		
	}
	function getContainerInfo()
	{
		    $cont_number= $_GET["cont_number"];

			$getContainerInfoQuery= "select (select right(sparcsn4.ref_equip_type.nominal_length,2) from ref_equip_type 
									INNER JOIN sparcsn4.ref_equipment ON ref_equipment.eqtyp_gkey=ref_equip_type.gkey
									INNER JOIN sparcsn4.inv_unit_equip ON inv_unit_equip.eq_gkey=ref_equipment.gkey
									where sparcsn4.inv_unit_equip.unit_gkey=inv_unit.gkey
									) as cont_size,
									(select right(sparcsn4.ref_equip_type.nominal_height,2)/10 from ref_equip_type 
									INNER JOIN sparcsn4.ref_equipment ON ref_equipment.eqtyp_gkey=ref_equip_type.gkey
									INNER JOIN sparcsn4.inv_unit_equip ON inv_unit_equip.eq_gkey=ref_equipment.gkey
									where sparcsn4.inv_unit_equip.unit_gkey=inv_unit.gkey
									) as cont_height,
									freight_kind as cont_status,
									inv_unit_fcy_visit.flex_string10 ib_vyg
									FROM sparcsn4.inv_unit
									INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
									INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ob_cv
									
									where inv_unit.id='$cont_number'";
			$getContainerInfoRslt = $this->bm->dataSelect($getContainerInfoQuery);
            echo json_encode($getContainerInfoRslt);
	   
	}
	
	// Get MLO using Rotation Start
		function getMloByRotation()
		{
			$rotation = $_GET["rotation"];
			$query = "select distinct igm_details.mlocode
								from igm_detail_container 
								inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id  
								where igm_details.Import_Rotation_No='$rotation'";
			$rtnMloList = $this->bm->dataSelectDb1($query);
			
			//$data['rtnMloList']=$rtnMloList; 
			echo json_encode($rtnMloList);		 
		}
		// Get MLO using Rotation End
	
	//sidebar start
	function getOrgTypeSection()
	{
		$login_id=$_GET['login_id'];
		
		$sql_OrgTypeSection="select users.login_id,tbl_org_types.id as tbl_org_types_id,Org_Type,users_section_detail.id as users_section_detail_id,full_name
		from users 
		inner join tbl_org_types on tbl_org_types.id=users.org_Type_id
		inner join users_section_detail on users_section_detail.id=users.section
		where login_id='$login_id'";
		
		$rslt_OrgTypeSection = $this->bm->dataSelectDb1($sql_OrgTypeSection);
		
		echo json_encode($rslt_OrgTypeSection);	
	}
	
	function getURL()
	{
		$menu_id=$_GET['menu_id'];
	
		$sql_URL="select distinct url_id,panel_menu_id,url_title 
		from url_details
		where panel_menu_id='$menu_id'";
		
		$rslt_URL = $this->bm->dataSelectDb1($sql_URL);
		
		echo json_encode($rslt_URL);
	}
	//sidebar end
	// Get IGM Detail Information
	function getIGMDtlInfo()
		{
			$rotation_no = $_GET["rotation_no"];
			$bl_no = $_GET["bl_no"];
			$rtnIGMDtlList="";
			
			$queryChkExist="select count(id) as cntData from igm_masters where Import_Rotation_No='$rotation_no'";
			$rtnChkList = $this->bm->dataSelectDb1($queryChkExist);
			$rowChk=$rtnChkList[0]['cntData'];
			
			if($rowChk==0)
			{
				$status_mst=0;
				$status_dtl=0;
			}
			else
			{
				$status_mst=1;
				$queryIgmDtl = "select id,IGM_id,Import_Rotation_No,Line_No,BL_No,Pack_Number,Pack_Description,Pack_Marks_Number,
								Description_of_Goods,weight,Remarks,ConsigneeDesc,NotifyDesc,Submitee_Id,Submission_Date,Submitee_Org_Id,
								last_update,type_of_igm,weight_unit,mlocode,Exporter_name,Exporter_address,Notify_code,Notify_name,Notify_address,
								Consignee_code,Consignee_name,Consignee_address,DG_status,place_of_unloading,port_of_origin from igm_details 
								where Import_Rotation_No='$rotation_no' and BL_No='$bl_no'";
				$rtnIGMDtlList = $this->bm->dataSelectDb1($queryIgmDtl);
				
				$queryIgmMst = "select id,Submitee_Id,Submission_Date,Port_of_Destination,Submitee_Org_Id from igm_masters where Import_Rotation_No='$rotation_no'";
				$rtnIGMMstList = $this->bm->dataSelectDb1($queryIgmMst);
				
				if(count($rtnIGMDtlList)>0)
				{
					$status_dtl=1;
					$data['rtnIGMDtlList']=$rtnIGMDtlList;
				}
				else
				{
					$status_dtl=0;
					$data['rtnIGMMstList']=$rtnIGMMstList;
				}
				
			}
			
			
			$data['status_mst']=$status_mst; 
			$data['status_dtl']=$status_dtl; 
			 
			echo json_encode($data);	
		}
	
	//cnf info start
	function get_cnf_info()
	{
		$license_no=$_GET['license_no'];
		
		$sql_cnf_info="SELECT gkey,id,NAME AS u_name,ct_name,address_line1 AS Address_1,address_line2 AS Address_2,city,telephone AS Telephone_No_Land,sms_number AS Cell_No_1,email_address AS email
		FROM sparcsn4.ref_bizunit_scoped 
		WHERE id='$license_no'";
		
		$rslt_user_data=$this->bm->dataSelect($sql_cnf_info);
		
		echo json_encode($rslt_user_data);
	}
	//cnf info end
	
	//assignment type and delivery time - start
	function get_assignment_dlvtime()
	{
		$container_no=$_GET['container_no'];
		
		$sql_assignment_dlvtime="SELECT id,gkey,mfdch_desc AS assign_type,CONCAT(delDT,' ',delTime) AS dlv_time_slot
								FROM (
								SELECT a.id,a.gkey,config_metafield_lov.mfdch_value,mfdch_desc,b.flex_date01,
								CAST(DATE(flex_date01) AS CHAR) AS delDT,
								(CASE 
									WHEN UCASE(mfdch_desc) LIKE 'APPRAISE CUM DEL%' THEN '2PM-5PM'
									WHEN UCASE(mfdch_desc) LIKE '%REEFER%' THEN '4PM-7PM'
									ELSE '10AM-1PM' END) AS delTime
								FROM sparcsn4.inv_unit a 
								INNER JOIN sparcsn4.inv_unit_fcy_visit b ON b.unit_gkey=a.gkey
								INNER JOIN sparcsn4.config_metafield_lov ON a.flex_string01=config_metafield_lov.mfdch_value 
								INNER JOIN sparcsn4.inv_goods j ON j.gkey = a.goods 
								WHERE a.id='$container_no' AND config_metafield_lov.mfdch_value NOT IN ('CANCEL','OCD','APPCUS','APPOTH','APPREF')
								) AS tbl";
		
		$rslt_assignment_dlvtime=$this->bm->dataSelect($sql_assignment_dlvtime);
	//	$rslt_assignment_dlvtime=$this->bm->dataSelectDb2($sql_assignment_dlvtime);
		
		echo json_encode($rslt_assignment_dlvtime);
	}
	//assignment type and delivery time - end
	
	
	function getBLInfoForCnF()
	  {
		$blNo = $_GET['blNo'];
		//$rotNo = $_GET['rotNo'];
		$login_id = $this->session->userdata('login_id');
		
		$query1="SELECT Import_Rotation_No,BL_No, Bill_of_Entry_No, Bill_of_Entry_Date, Pack_Number, office_code, jetty_sirkar_lic, Pack_Description,Pack_Marks_Number
					FROM cchaportdb.igm_details WHERE BL_No='$blNo'";
							
		$blInfo1 = $this->bm->dataSelectDb1($query1);
		
		$query2="SELECT igm_detail_container.id, igm_detail_container.igm_detail_id,cont_number,cont_size,cont_gross_weight,cont_height,truck_no
				FROM igm_details 
				INNER JOIN igm_detail_container ON igm_details.id=igm_detail_container.igm_detail_id 
				LEFT JOIN igm_truck_detail ON igm_detail_container.id=igm_truck_detail.igm_detail_cont_id
				WHERE igm_details.BL_No='$blNo'";
							
		$blInfo2 = $this->bm->dataSelectDb1($query2);
		
		$data['blInfo1']=$blInfo1;	
		$data['blInfo2']=$blInfo2;	
	
        echo json_encode($data);	    
		   
	 }
	 
	 //product name - start
	function get_product_name()
	{
		$product_type_id=$_GET['product_type_id'];
		
		$sql_product_name="SELECT id, CONCAT(prod_name,'---',prod_serial) AS prod_name FROM inventory_product_info WHERE type_id='$product_type_id' ORDER BY prod_name ASC";
		
		$rslt_product_name=$this->bm->dataSelectDb1($sql_product_name);
		
		echo json_encode($rslt_product_name);
	}
	//product name - end
	
	//handover to - start
	function get_handover_to()
	{
		$handover_cat=$_GET['handover_cat'];
		
		if($handover_cat=="new")
		{
			$sql_handover_to="SELECT id,full_name FROM inventory_product_owner ORDER BY full_name ASC";
		}
		else if($handover_cat=="damaged" or $handover_cat=="repaired")
		{
			$sql_handover_to="SELECT id,company_name FROM inventory_product_user";	
		}
		
		$rslt_handover_to=$this->bm->dataSelectDb1($sql_handover_to);
		
		echo json_encode($rslt_handover_to);
	}
	//handover to - end
	
	
	function getNetworkProduct()
        {
            $typeId=$_GET['typeid'];
		$query="SELECT id, CONCAT(prod_name,'---',prod_serial) AS prod_name FROM inventory_product_info WHERE type_id='$typeId' ORDER BY prod_name ASC";
							
            $productName = $this->bm->dataSelectDb1($query);		
         //   $data['productName']=$productName;	
           echo json_encode($productName);	    
        }
		
		
	function getLocationInfo()
        {
            	$location_id=$_GET['locid'];
		$sql_location="SELECT inventory_product_location_details.id, location_details FROM inventory_product_location_details
                             WHERE `inventory_product_location_details`.`location_id`='$location_id'";
		
		$loc_dtl=$this->bm->dataSelectDb1($sql_location);
		
		echo json_encode($loc_dtl);
        }
		
			
	function getComboValForNetworkList()
	{
		$colName = $_GET["colName"];
		$query = "";
		if($colName=="category")
			$query = "SELECT id ,IF(short_name='Monitor',CONCAT(short_name,'-',product_desc),short_name) as detl FROM cchaportdb.inventory_product_type ORDER BY short_name ASC";		
		else if($colName=="location")
			$query = "SELECT location_name as id, location_name as detl FROM inventory_product_location";
		else if($colName=="user")
			$query = "SELECT login_id as id, login_id as detl FROM `users` WHERE `org_Type_id`='66'";
		
		$rtnComboValList=$this->bm->dataSelectDb1($query);
		echo json_encode($rtnComboValList);
	}	
	function getIndentYard()
	{
		 $query = "select id,yard_name from ctmsmis.mis_equip_indent ORDER BY yard_name ASC";
         $rtnBlockList = $this->bm->dataSelect($query);
         echo json_encode($rtnBlockList);		 
	}
	
	function getVslName()
	{
		 $rot_no = $_GET["rot_no"];
		 $query = "SELECT sparcsn4.vsl_vessels.name AS vsl_name
					FROM sparcsn4.vsl_vessels
					INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
					WHERE sparcsn4.vsl_vessel_visit_details.ib_vyg='$rot_no'";
         $vsselName = $this->bm->dataSelect($query);
         echo json_encode($vsselName);		 
	}
	
	function getberthOp()
	{
		 $query = "SELECT DISTINCT(sparcsn4.vsl_vessel_visit_details.flex_string03) AS berthop 
					FROM sparcsn4.vsl_vessel_visit_details WHERE sparcsn4.vsl_vessel_visit_details.flex_string03 IS NOT NULL limit 8";
         $berthOpList = $this->bm->dataSelect($query);
         echo json_encode($berthOpList);		 
	}
	
	//container wise truck - start
	function get_cont_truck_info()
	{
		$container_no = $_GET["container_no"];
		
		$sql_cont_truck_n4="SELECT sparcsn4.inv_unit.id AS cont_no,sparcsn4.inv_unit.gkey AS unit_gkey,sparcsn4.config_metafield_lov.mfdch_desc AS assign_type,DATE(sparcsn4.inv_unit_fcy_visit.flex_date01) AS assign_date,sparcsn4.vsl_vessel_visit_details.ib_vyg AS rotation,sparcsn4.vsl_vessels.name AS vessel_name,sparcsn4.ref_bizunit_scoped.name AS cnf,sparcsn4.ref_bizunit_scoped.gkey AS bizu_gkey
		FROM sparcsn4.inv_unit  
		INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
		INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
		INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
		INNER JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
		INNER JOIN sparcsn4.config_metafield_lov ON sparcsn4.inv_unit.flex_string01=config_metafield_lov.mfdch_value 
		INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.inv_unit.line_op 
		WHERE sparcsn4.inv_unit.id='$container_no'";
		
		$rslt_cont_truck_n4=$this->bm->dataSelect($sql_cont_truck_n4);
		
		$sql_cont_truck_igm="SELECT cont_size,cont_height,Pack_Description,Pack_Number
		FROM igm_details
		INNER JOIN igm_detail_container ON igm_detail_container.igm_detail_id=igm_details.id
		WHERE cont_number='$container_no'";
		
		$rslt_cont_truck_igm=$this->bm->dataSelectDb1($sql_cont_truck_igm);
		
		//---
		$sql_chk_entered_truck="SELECT id,number_of_truck 
		FROM ctmsmis.mis_cf_assign_truck 
		WHERE cont_id='$container_no'";
		
		$rslt_chk_entered_truck=$this->bm->dataSelect($sql_chk_entered_truck);
		
		$cf_assign_truck_id=$rslt_chk_entered_truck[0]['number_of_truck'];
		
		$sql_truck_number_list="SELECT truck_number AS rtnValue FROM ctmsmis.cont_wise_truck_dtl WHERE cf_assign_truck_id='$cf_assign_truck_id'";
		
		$rslt_truck_number_list=$this->bm->dataReturn($sql_truck_number_list);
		//---
		
		$data['rslt_cont_truck_n4']=$rslt_cont_truck_n4;
		$data['rslt_cont_truck_igm']=$rslt_cont_truck_igm;
		$data['rslt_chk_entered_truck']=$rslt_chk_entered_truck;
		$data['rslt_truck_number_list']=$rslt_truck_number_list;
		
		echo json_encode($data);	
	}
	//container wise truck - end
	
	
	function getGateList()
	{
		 $query = "SELECT DISTINCT gkey, id FROM sparcsn4.road_gates WHERE life_cycle_state='ACT'";
         $gateList = $this->bm->dataSelect($query);
         echo json_encode($gateList);		 
	}
	// Sourav Dispute Comments Entry
	function saveDisputeComments()
	{
		//$rotation=str_replace("_","/",$this->uri->segment(3));
		//$container=str_replace("_","/",$this->uri->segment(4));
		$bill_no= $_GET["bill_no"];
		$comment= $_GET["comment"];
		$ipaddr = $_SERVER['REMOTE_ADDR'];
		$login_id = $this->session->userdata('login_id');
		
		$str = "INSERT INTO ctmsmis.billingdisputecont(invoicerefno,disputeDetails,disputeDate,ipaddress,createdby,createdtime) 
		VALUES ('$bill_no','$comment',now(),'$ipaddr','$login_id',now())";
		$stat = $this->bm->dataInsert($str);
		
		if($stat==1)
		{
			$data['stat']="1";
			
		}
		else
		{
			$data['stat']="0";
			
		}
		
		echo json_encode($data);
	}
	
	function getOrgResult()
	{
		//$searchkey=$_GET["search_by"];	

		$sqlQuery="SELECT id, Org_Type as type from tbl_org_types";
		
		$list = $this->bm->dataSelectDb1($sqlQuery);
		echo json_encode($list);
	}	
	//cnf info start
	function get_org_info()
	{
		$org_type=$_GET['org_type'];
		$org_name=$_GET['org_name'];
		
		$sql_org_info="SELECT Address_1,Address_2,Cell_No_1,Cell_No_2,email FROM organization_profiles WHERE Organization_Name='$org_name' AND Org_Type_id='$org_type'";
		
		$rslt_user_data=$this->bm->dataSelectDb1($sql_org_info);
		
		echo json_encode($rslt_user_data);
	}
	
	
}
