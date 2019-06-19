<?php

class cfsModule extends CI_Controller {
	function __construct()
	{
	    parent::__construct();	
            $this->load->library(array('session', 'form_validation'));
            $this->load->model(array('CI_auth', 'CI_menu'));
            $this->load->helper(array('html','form', 'url'));
			$this->load->driver('cache');
			$this->load->model('ci_auth', 'bm', TRUE);
			$this->load->library("pagination");
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
			
	}
	function index(){
		 $this->lclAssignment();
    }
	
//Sumon Roy--Start
	
	function logout(){ 
		$query="SELECT sparcsn4.vsl_vessel_visit_details.vvd_gkey,sparcsn4.vsl_vessels.name,sparcsn4.vsl_vessel_visit_details.ib_vyg,sparcsn4.vsl_vessel_visit_details.ob_vyg,
			LEFT(sparcsn4.argo_carrier_visit.phase,2) AS phase_num,SUBSTR(sparcsn4.argo_carrier_visit.phase,3) AS phase_str,sparcsn4.argo_visit_details.eta,
			sparcsn4.argo_visit_details.etd,sparcsn4.argo_carrier_visit.ata,
			sparcsn4.argo_carrier_visit.atd,sparcsn4.ref_bizunit_scoped.id AS agent,sparcsn4.argo_quay.id AS berth,
			IFNULL(sparcsn4.vsl_vessel_visit_details.flex_string02,sparcsn4.vsl_vessel_visit_details.flex_string03) AS berthop
			FROM sparcsn4.argo_carrier_visit
			INNER JOIN sparcsn4.argo_visit_details ON sparcsn4.argo_visit_details.gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
			INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_visit_details.gkey
			INNER JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
			INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.vsl_vessel_visit_details.bizu_gkey
			LEFT JOIN sparcsn4.vsl_vessel_berthings ON sparcsn4.vsl_vessel_berthings.vvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
			LEFT JOIN sparcsn4.argo_quay ON sparcsn4.argo_quay.gkey=sparcsn4.vsl_vessel_berthings.quay
			WHERE sparcsn4.argo_carrier_visit.phase IN ('20INBOUND','30ARRIVED','40WORKING','50COMPLETE','60DEPARTED')
			ORDER BY sparcsn4.argo_carrier_visit.phase";
			//echo $data['voysNo'];
			$rtnVesselList = $this->bm->dataSelect($query);
			$data['rtnVesselList']=$rtnVesselList;
			
			$data['body']="<font color='blue' size=2>LogOut Successfully....</font>";

			$this->session->sess_destroy();
			$this->cache->clean();
			//redirect(base_url(),$data);
			$this->load->view('header');
			$this->load->view('welcomeview_1', $data);
			$this->load->view('footer');
			$this->db->cache_delete_all();
        }
		
		
	function lclAssignment()
	{
		//print_r($this->session->all_userdata());
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
		    $strSelect="select lcl_assignment_detail.id,igm_detail_container.cont_number,
			igm_detail_container.cont_size,igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,assignment_date,
			igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,
			lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time from lcl_assignment_detail
			inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id 
			inner join igm_masters on igm_masters.id=igm_details.IGM_id 
			inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id where unstuff_flag=0";
			$lclAssignmentList = $this->bm->dataSelectDb1($strSelect);
			
			$data['lclAssignmentList']=$lclAssignmentList;    
			$editFlag = 0;
			$data['editFlag']=$editFlag;
			$data['title']="LCL ASSIGNMENT ENTRY FORM...";
			$this->load->view('header5');
			$this->load->view('lclAssignmentEntryForm',$data);
			$this->load->view('footer_1');
		}	
    }
	  
	  
	  
	 function lclAssignmentPerform()
	  {	
	    $session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		} 
		else
		{
		$login_id = $this->session->userdata('login_id');	
		//$data['login_id']=$login_id;
		$ipaddr = $_SERVER['REMOTE_ADDR'];
		
		if($this->input->post('sync'))
		{
	       $this->syncLclAssignment();
		}
		else
		{
			// update___________________
				if($this->input->post('update'))
				{
					$lclID=$this->input->post('id');
			
					$expectDate=$this->input->post('expectDate');
					$stv=$this->input->post('stv');
					$contAtShed=$this->input->post('contAtShed');
					$cargoAtShed=$this->input->post('cargoAtShed');
					$decOfCargo=$this->input->post('decOfCargo');
					$remarks=$this->input->post('remarks');
					$igmDetailContId=$this->input->post('igmDetailContId');
					$igmDetailId=$this->input->post('igmDetailId');
					
					
					$strInsertEq = "UPDATE lcl_assignment_detail SET igm_cont_detail_id ='$igmDetailContId',igm_detail_id = '$igmDetailId',
									assignment_date='$expectDate',cont_loc_shed ='$contAtShed',cargo_loc_shed='$cargoAtShed',description_cargo='$decOfCargo',
									remarks='$remarks',last_update=now(),update_by='$login_id',user_ip='$ipaddr',unstuff_flag='0',berthOp='$stv'
									WHERE lcl_assignment_detail.id=$lclID";
										
						
					$stat = $this->bm->dataInsertDB1($strInsertEq);
							
					if($stat==1)
					{
						$data['msg']="LCL Assignment Updated successfully ";
						$dateFlag=1;
						$data['dateFlag']=$dateFlag;
						$exptDate=$this->input->post('expectDate');
						$data['exptDate']=$exptDate;
						

					}
					else
						$data['msg']="Not Updated.";
					
					
					$strSelect="select lcl_assignment_detail.id,igm_detail_container.cont_number,
			igm_detail_container.cont_size,igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,assignment_date,
			igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,
			lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time from lcl_assignment_detail
			inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id 
			inner join igm_masters on igm_masters.id=igm_details.IGM_id 
			inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id where unstuff_flag=0";
					$lclAssignmentList = $this->bm->dataSelectDb1($strSelect);
					
					$data['lclAssignmentList']=$lclAssignmentList;    
				
				$data['title']="LCL ASSIGNMENT ENTRY FORM...";
				$this->load->view('header5');
				$this->load->view('lclAssignmentEntryForm',$data);
				$this->load->view('footer_1');
			}
			
		
			
			else
			{
				$cont=$this->input->post('contNo');
				$expectDate=$this->input->post('expectDate');
				$stv=$this->input->post('stv');
				$contAtShed=$this->input->post('contAtShed');
				$cargoAtShed=$this->input->post('cargoAtShed');
				$decOfCargo=$this->input->post('decOfCargo');
				$remarks=$this->input->post('remarks');
				$igmDetailContId=$this->input->post('igmDetailContId');
				$igmDetailId=$this->input->post('igmDetailId');
                $landingTime=$this->input->post('landingTime');
				
				
				
				$strContSearch="select count(*) as rtnValue from lcl_assignment_detail
			inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id
             where igm_detail_container.cont_number='$cont' and unstuff_flag=0";				
				
			$contSearch= $this->bm->dataReturnDb1($strContSearch);
			
			  if($contSearch!=0)
			  {
				  $data['msg']="Container No: ".$cont." already assigned!";
				  
				    $dateFlag=1;
					$data['dateFlag']=$dateFlag;
					$exptDate=$this->input->post('expectDate');
					$data['exptDate']=$exptDate;
					
					$shedFlag=1;
						
					$contShed=$this->input->post('contAtShed');
					$cargoShed=$this->input->post('cargoAtShed');
						
				    $data['contShed']=$contShed;
					$data['cargoShed']=$cargoShed;
					$data['shedFlag']=$shedFlag;	
					
							
					$strSelect="select lcl_assignment_detail.id,igm_detail_container.cont_number,
					igm_detail_container.cont_size,igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,assignment_date,
					igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,
					lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time,if(assignment_date<=date(now()),1,0) as st
					from lcl_assignment_detail
					inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id 
					inner join igm_masters on igm_masters.id=igm_details.IGM_id 
					inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id where unstuff_flag=0 and cont_loc_shed='$contShed' order by assignment_date";
					$lclAssignmentList = $this->bm->dataSelectDb1($strSelect);
					
					$data['lclAssignmentList']=$lclAssignmentList;
				
					$data['title']="LCL ASSIGNMENT ENTRY FORM...";
					$this->load->view('header5');
					$this->load->view('lclAssignmentEntryForm',$data);
					$this->load->view('footer_1');
			  }

			else
				{
				$strInsertEq = "insert into lcl_assignment_detail(igm_cont_detail_id,igm_detail_id,assignment_date,cont_loc_shed,cargo_loc_shed,description_cargo,remarks,last_update,update_by,user_ip,unstuff_flag,berthOp,landing_time)
									values($igmDetailContId,$igmDetailId, '$expectDate', '$contAtShed', '$cargoAtShed', '$decOfCargo','$remarks', now(), '$login_id','$ipaddr','0','$stv','$landingTime')";
					
				$stat = $this->bm->dataInsertDB1($strInsertEq);
				
				$shedFlag=0;		
				if($stat==1)
				{
					$data['msg']="LCL Assignment Saved successfully  ";
					$dateFlag=1;
					$data['dateFlag']=$dateFlag;
					$exptDate=$this->input->post('expectDate');
					$data['exptDate']=$exptDate;
					
					$shedFlag=1;
						
					$contShed=$this->input->post('contAtShed');
					$cargoShed=$this->input->post('cargoAtShed');
						
				    $data['contShed']=$contShed;
					$data['cargoShed']=$cargoShed;
					$data['shedFlag']=$shedFlag;	
					
				}
				else
					$data['msg']="Not Saved.";
				
				
				$strSelect="select lcl_assignment_detail.id,igm_detail_container.cont_number,
			igm_detail_container.cont_size,igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,assignment_date,
			igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,
			lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time, if(assignment_date<=date(now()),1,0) as st from lcl_assignment_detail
			inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id 
			inner join igm_masters on igm_masters.id=igm_details.IGM_id 
			inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id where unstuff_flag=0 and cont_loc_shed='$contShed' order by assignment_date";
				$lclAssignmentList = $this->bm->dataSelectDb1($strSelect);
				
				$data['lclAssignmentList']=$lclAssignmentList;    
			
				$data['title']="LCL ASSIGNMENT ENTRY FORM...";
				$this->load->view('header5');
				$this->load->view('lclAssignmentEntryForm',$data);
				$this->load->view('footer_1');
			
			}
			}
		}
	  }
	 }
	 
	 
	 //syncLclAssignment________________________________
	 
	 function syncLclAssignment()
	 {
		//echo "sync";
			$strAssignID="select lcl_assignment_detail.igm_cont_detail_id,igm_detail_container.cont_number
			from lcl_assignment_detail
			inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id
			inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id
			where unstuff_flag=0";
			$lclAssignmentIDList = $this->bm->dataSelectDb1($strAssignID);
			for($i=0;$i<count($lclAssignmentIDList);$i++) { 
				$dtlContId=$lclAssignmentIDList[$i]['igm_cont_detail_id'];
				$cont_number=$lclAssignmentIDList[$i]['cont_number'];
				
				/*$strID = "select count(*) as rtnValue from sparcsn4.inv_unit
				inner join sparcsn4.srv_event on sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey
				where id='$cont_number' and  category='IMPRT' and event_type_gkey=30";
				*/
				$strId = "select 
				(select count(*) from sparcsn4.srv_event where sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey and event_type_gkey=30) as rtnValue
				from sparcsn4.inv_unit where id='$cont_number' and  category='IMPRT' order by sparcsn4.inv_unit.gkey desc limit 1";
				$rtnValue = $this->bm->dataReturn($strId);
				if($rtnValue>0)
				{
					$strID = "update lcl_assignment_detail SET unstuff_flag=1 where igm_cont_detail_id=$dtlContId";
					$flagUpdate = $this->bm->dataInsertDB1($strID);					
				}
			}
			$strSelect="select lcl_assignment_detail.id,igm_detail_container.cont_number,
			igm_detail_container.cont_size,igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,assignment_date,
			igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,
			lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time from lcl_assignment_detail
			inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id 
			inner join igm_masters on igm_masters.id=igm_details.IGM_id 
			inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id where unstuff_flag=0";
			$lclAssignmentList = $this->bm->dataSelectDb1($strSelect);
					
			$data['lclAssignmentList']=$lclAssignmentList;
			$data['title']="LCL ASSIGNMENT ENTRY FORM...";
			$this->load->view('header5');
			$this->load->view('lclAssignmentEntryForm',$data);
			$this->load->view('footer_1'); 
			
			
	 }
 
 
 
 
	 function lclAssignmentEdit()
	 {
		$session_id = $this->session->userdata('value');

		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		
		else
		{
			if($this->input->post('lclID'))
				{
					$lclID=$this->input->post('lclID');
				}
			else
				{
					$lclID=$this->uri->segment(3);
				}

			//echo "ID ".$lclID;
			$strSelect="select lcl_assignment_detail.id, igm_detail_container.cont_number,
			igm_detail_container.cont_size,igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,assignment_date,
			igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,
			lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time from lcl_assignment_detail
			inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id 
			inner join igm_masters on igm_masters.id=igm_details.IGM_id 
			inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id where unstuff_flag=0 and lcl_assignment_detail.id=$lclID";
			$lclAssignmentEditList = $this->bm->dataSelectDb1($strSelect);
			
			$data['lclAssignmentEditList']=$lclAssignmentEditList;    
			$editFlag = 1;
			$data['editFlag']=$editFlag;
			
			
			$strSelect="select lcl_assignment_detail.id,igm_detail_container.cont_number,
			igm_detail_container.cont_size,igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,assignment_date,
			igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,
			lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time from lcl_assignment_detail
			inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id 
			inner join igm_masters on igm_masters.id=igm_details.IGM_id 
			inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id where unstuff_flag=0";
			$lclAssignmentList = $this->bm->dataSelectDb1($strSelect);
			$data['lclAssignmentList']=$lclAssignmentList; 
			
			
			$data['title']="LCL ASSIGNMENT ENTRY FORM...";
			$this->load->view('header5');
			$this->load->view('lclAssignmentEntryForm',$data);
			$this->load->view('footer_1');
			
			
		}
	 }
	 
/*
	function lclAssignmentReportView()
	{
		   $login_id = $this->session->userdata('login_id');	
		   $strSelect="select lcl_assignment_detail.id,igm_detail_container.cont_number,igm_detail_container.cont_size,
			igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,
				igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time
				from lcl_assignment_detail
				inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id
				inner join igm_masters on igm_masters.id=igm_details.IGM_id
				inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id
				where unstuff_flag=0 order by cont_loc_shed";
			$lclAssignmentList = $this->bm->dataSelectDb1($strSelect);
			
		   $data['lclAssignmentList']=$lclAssignmentList; 
		   $data['login_id']=$login_id;
		   $data['title']="LCL ASSIGNMENT REPORT";
		   $this->load->view('lclAssignmentReportView',$data);   
	}

	*/
    function lclAssignmentReportView()
		  {  
		    
			$login_id = $this->session->userdata('login_id');	
		  		//load mPDF library
			$this->load->library('m_pdf');
            $data['title']="LCL ASSIGNMENT REPORT";
			/*
            $strSelect="select lcl_assignment_detail.id,igm_detail_container.cont_number,igm_detail_container.cont_size,
			    igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,
				igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time
				from lcl_assignment_detail
				inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id
				inner join igm_masters on igm_masters.id=igm_details.IGM_id
				inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id
				where unstuff_flag=0 order by cont_loc_shed";*/
			$strSelect="select distinct cont_loc_shed from lcl_assignment_detail where unstuff_flag=0 order by cont_loc_shed";
			$lclAssignmentList = $this->bm->dataSelectDb1($strSelect);
			
		    //$data['lclAssignmentList']=$lclAssignmentList; 
		    $data['login_id']=$login_id;
		  
            $this->data['lclAssignmentList']= $lclAssignmentList;
		    $html=$this->load->view('lclAssignmentReportView',$this->data,true);

   
				//this the the PDF filename that user will get to download
			$pdfFilePath ="mypdfName-".time()."-download.pdf";


				//actually, you can pass mPDF parameter on this load() function
			$pdf = $this->m_pdf->load();
			//$pdf->autoPageBreak = true;
				//$pdf->SetHeader('|Date: {DATE j-m-Y}|');

				//$pdf->SetHeader($url . "\n\n" . 'Date {DATE j-m-Y}');
               // $pdf->setFooter('|Page {PAGENO}|');
				//generate the PDF!
				//$stylesheet = file_get_contents('pdf.css'); // external css
				//$pdf->WriteHTML($stylesheet,1);
			$stylesheet = file_get_contents('resources/styles/lcl.css'); 
		    $pdf->useSubstitutions = true; 
			$pdf->WriteHTML($stylesheet,1);	
			$pdf->WriteHTML($html,2);
				//offer it to user via browser download! (The PDF won't be saved on your server HDD)
			$pdf->Output($pdfFilePath, "I");   //--------pdf view show
				//$pdf->Output($pdfFilePath, "D");  //-------pdf download					
		}
			
	

	
	function lclAssignmentCancel()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		
		else
		{
			if($this->input->post('lclID'))
				{
					$lclID=$this->input->post('lclID');
				}
			else
				{
					$lclID=$this->uri->segment(3);
				}
			//echo "ID ".$lclID;
			$strSelect="DELETE FROM lcl_assignment_detail WHERE lcl_assignment_detail.id=$lclID";
			$stat = $this->bm->dataDeleteDB1($strSelect);
			
			if($stat==1)
			{
				$data['msg']="LCL Assignment Deleted";
			}
			else
				$data['msg']="Not delete.";
			
			
			$strSelect="select lcl_assignment_detail.id,igm_detail_container.cont_number,
			igm_detail_container.cont_size,igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,assignment_date,
			igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,
			lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time from lcl_assignment_detail
			inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id 
			inner join igm_masters on igm_masters.id=igm_details.IGM_id 
			inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id where unstuff_flag=0";
			$lclAssignmentList = $this->bm->dataSelectDb1($strSelect);
			$data['lclAssignmentList']=$lclAssignmentList; 
			
			
			$data['title']="LCL ASSIGNMENT ENTRY FORM...";
			$this->load->view('header5');
			$this->load->view('lclAssignmentEntryForm',$data);
			$this->load->view('footer_1');
		}
		
	}
	
	
	
	//LCL Assignment Report Table____________________________________________
	
	function lclAssignmentReportTable()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		
		$login_id = $this->session->userdata('login_id');	
		$data['login_id']=$login_id;
		
		$strSelect="select lcl_assignment_detail.id,igm_detail_container.cont_number,
			igm_detail_container.cont_size,igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,assignment_date,
			igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,
			lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time from lcl_assignment_detail
			inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id 
			inner join igm_masters on igm_masters.id=igm_details.IGM_id 
			inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id where unstuff_flag=0";
			$lclAssignmentList = $this->bm->dataSelectDb1($strSelect);
			$data['lclAssignmentList']=$lclAssignmentList; 
			
			
			$data['title']="LCL ASSIGNMENT REPORT....";
			$this->load->view('header5');
			$this->load->view('lclAssignmentReportTableView',$data);
			$this->load->view('footer_1');
		
	}
	
	/*
	function lclAssignmentReportTablePerform()
	{
	
	  $login_id = $this->session->userdata('login_id');	
	  $data['login_id']=$login_id;
	  $search_by = $this->input->post('search_by');
	  if($search_by=="rotation")
		{
		 $rot=$this->input->post('search_value');
		 $data['title']="LCL ASSIGNMENT REPORT FOR THE ROTATION  ".$rot;
		 $data['rot']=$rot;
		 
			$strSelect="select lcl_assignment_detail.id,igm_detail_container.cont_number,
			igm_detail_container.cont_size,igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,assignment_date,
			igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,
			lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time from lcl_assignment_detail
			inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id 
			inner join igm_masters on igm_masters.id=igm_details.IGM_id 
			inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id where unstuff_flag=0 and igm_details.Import_Rotation_No='$rot' ";
			$lclAssignmentList = $this->bm->dataSelectDb1($strSelect);
			$data['lclAssignmentList']=$lclAssignmentList; 
	
			$this->load->view('header5');
			$this->load->view('lclAssignmentReportTableView',$data);
			$this->load->view('footer_1');
		}
	  else if($search_by=="container")
		{
	     $cont=$this->input->post('search_value');
		 $data['title']="LCL ASSIGNMENT REPORT THE CONTAINER ".$cont;
		 $todate=$this->input->post('todate');
		 
		 $strSelect="select lcl_assignment_detail.id,igm_detail_container.cont_number,
			igm_detail_container.cont_size,igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,assignment_date,
			igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,
			lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time from lcl_assignment_detail
			inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id 
			inner join igm_masters on igm_masters.id=igm_details.IGM_id 
			inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id where unstuff_flag=0 AND cont_number='$cont'";
			$lclAssignmentList = $this->bm->dataSelectDb1($strSelect);
			$data['lclAssignmentList']=$lclAssignmentList; 
			
			$this->load->view('header5');
			$this->load->view('lclAssignmentReportTableView',$data);
			$this->load->view('footer_1');
		}
	 
     else if($search_by=="shedNo")	 
	    {
		 $shedNo=$this->input->post('shedNo');
		 $fromdate=$this->input->post('fromdate');
		 $todate=$this->input->post('todate');
		 $data['fromdate']=$fromdate;
		 $data['todate']=$todate;
		 
		 $data['title']="LCL ASSIGNMENT REPORT FOR THE SHED NO: ".$shedNo." AND DATE BETWEEN ".$fromdate." AND ".$todate;
		 //$todate=$this->input->post('todate');
		 
		 $strSelect="select lcl_assignment_detail.id,igm_detail_container.cont_number,
			igm_detail_container.cont_size,igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,assignment_date,
			igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,
			lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time from lcl_assignment_detail
			inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id 
			inner join igm_masters on igm_masters.id=igm_details.IGM_id 
			inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id where unstuff_flag=0 AND cont_loc_shed='$shedNo' AND assignment_date BETWEEN '$fromdate' AND '$todate'";
			$lclAssignmentList = $this->bm->dataSelectDb1($strSelect);
			$data['lclAssignmentList']=$lclAssignmentList; 
			
			$this->load->view('header5');
			$this->load->view('lclAssignmentReportTableView',$data);
			$this->load->view('footer_1');
		   
	    }
			
	  else if($search_by=="dateRange")
		{
		 $fromdate=$this->input->post('fromdate');
		 $todate=$this->input->post('todate');
		 $data['fromdate']=$fromdate;
		 $data['todate']=$todate;
		 $data['title']="LCL ASSIGNMENT REPORT BETWEEN ".$fromdate." AND ".$todate;	
		 
		 $strSelect="select lcl_assignment_detail.id,igm_detail_container.cont_number,
			igm_detail_container.cont_size,igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,assignment_date,
			igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,
			lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time from lcl_assignment_detail
			inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id 
			inner join igm_masters on igm_masters.id=igm_details.IGM_id 
			inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id where unstuff_flag=0 AND assignment_date BETWEEN '$fromdate' AND '$todate'";
			$lclAssignmentList = $this->bm->dataSelectDb1($strSelect);
			$data['lclAssignmentList']=$lclAssignmentList; 
			
			$this->load->view('header5');
			$this->load->view('lclAssignmentReportTableView',$data);
			$this->load->view('footer_1');
		}
		
	else  
	    {

		 $data['title']=" LCL ASSIGNMENT REPORT ";
		 
		 $strSelect="select lcl_assignment_detail.id,igm_detail_container.cont_number,
			igm_detail_container.cont_size,igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,assignment_date,
			igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,
			lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time from lcl_assignment_detail
			inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id 
			inner join igm_masters on igm_masters.id=igm_details.IGM_id 
			inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id where unstuff_flag=0";
			$lclAssignmentList = $this->bm->dataSelectDb1($strSelect);
			$data['lclAssignmentList']=$lclAssignmentList; 
			
			$this->load->view('header5');
			$this->load->view('lclAssignmentReportTableView',$data);
			$this->load->view('footer_1');
		   
	   }
			     
	}
	
	*/
function lclAssignmentReportTablePerform()
	{
	  $login_id = $this->session->userdata('login_id');	
	  $data['login_id']=$login_id;
	  $search_by = $this->input->post('search_by');
	  
	  if (isset($_POST['View'])) {
		  
		  if($search_by=="rotation")
		{
		 $rot=$this->input->post('search_value');
		 $data['title']="LCL ASSIGNMENT REPORT FOR THE ROTATION  ".$rot;
		 $data['rot']=$rot;
		 
		 $strSelect="select lcl_assignment_detail.id,igm_detail_container.cont_number,
			igm_detail_container.cont_size,igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,assignment_date,
			igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,
			lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time from lcl_assignment_detail
			inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id 
			inner join igm_masters on igm_masters.id=igm_details.IGM_id 
			inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id where unstuff_flag=0 and igm_details.Import_Rotation_No='$rot' ";
			$lclAssignmentList = $this->bm->dataSelectDb1($strSelect);
			$data['lclAssignmentList']=$lclAssignmentList; 
	
			$this->load->view('header5');
			$this->load->view('lclAssignmentReportTableView',$data);
			$this->load->view('footer_1');
		}
	  else if($search_by=="container")
		{
	     $cont=$this->input->post('search_value');
		 $data['title']="LCL ASSIGNMENT REPORT FOR THE CONTAINER ".$cont;
		 $todate=$this->input->post('todate');
		 
		 $strSelect="select lcl_assignment_detail.id,igm_detail_container.cont_number,
			igm_detail_container.cont_size,igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,assignment_date,
			igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,
			lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time from lcl_assignment_detail
			inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id 
			inner join igm_masters on igm_masters.id=igm_details.IGM_id 
			inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id where unstuff_flag=0 AND cont_number='$cont'";
			$lclAssignmentList = $this->bm->dataSelectDb1($strSelect);
			$data['lclAssignmentList']=$lclAssignmentList; 
			
			$this->load->view('header5');
			$this->load->view('lclAssignmentReportTableView',$data);
			$this->load->view('footer_1');
		}
	 
     else if($search_by=="shedNo")	 
	    {
		 $shedNo=$this->input->post('shedNo');
		 $fromdate=$this->input->post('fromdate');
		 $todate=$this->input->post('todate');
		 $data['fromdate']=$fromdate;
		 $data['todate']=$todate;
		 
		 $data['title']="LCL ASSIGNMENT REPORT FOR THE SHED NO: ".$shedNo." AND DATE BETWEEN ".$fromdate." AND ".$todate;
		 //$todate=$this->input->post('todate');
		 
		 $strSelect="select lcl_assignment_detail.id,igm_detail_container.cont_number,
			igm_detail_container.cont_size,igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,assignment_date,
			igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,
			lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time from lcl_assignment_detail
			inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id 
			inner join igm_masters on igm_masters.id=igm_details.IGM_id 
			inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id where unstuff_flag=0 AND cont_loc_shed='$shedNo' AND assignment_date BETWEEN '$fromdate' AND '$todate'";
			$lclAssignmentList = $this->bm->dataSelectDb1($strSelect);
			$data['lclAssignmentList']=$lclAssignmentList; 
			
			$this->load->view('header5');
			$this->load->view('lclAssignmentReportTableView',$data);
			$this->load->view('footer_1');
		   
	    }
			
	  else if($search_by=="dateRange")
		{
		 $fromdate=$this->input->post('fromdate');
		 $todate=$this->input->post('todate');
		 $data['fromdate']=$fromdate;
		 $data['todate']=$todate;
		 $data['title']="LCL ASSIGNMENT REPORT BETWEEN ".$fromdate." AND ".$todate;	
		 
		 $strSelect="select lcl_assignment_detail.id,igm_detail_container.cont_number,
			igm_detail_container.cont_size,igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,assignment_date,
			igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,
			lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time from lcl_assignment_detail
			inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id 
			inner join igm_masters on igm_masters.id=igm_details.IGM_id 
			inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id where unstuff_flag=0 AND assignment_date BETWEEN '$fromdate' AND '$todate'";
			$lclAssignmentList = $this->bm->dataSelectDb1($strSelect);
			$data['lclAssignmentList']=$lclAssignmentList; 
			
			$this->load->view('header5');
			$this->load->view('lclAssignmentReportTableView',$data);
			$this->load->view('footer_1');
		}
		
	else  
	    {

		 $data['title']=" LCL ASSIGNMENT REPORT ";
		 
		 $strSelect="select lcl_assignment_detail.id,igm_detail_container.cont_number,
			igm_detail_container.cont_size,igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,assignment_date,
			igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,
			lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time from lcl_assignment_detail
			inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id 
			inner join igm_masters on igm_masters.id=igm_details.IGM_id 
			inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id where unstuff_flag=0";
			$lclAssignmentList = $this->bm->dataSelectDb1($strSelect);
			$data['lclAssignmentList']=$lclAssignmentList; 
			
			$this->load->view('header5');
			$this->load->view('lclAssignmentReportTableView',$data);
			$this->load->view('footer_1');
		   
			}

		}
		elseif (isset($_POST['Print'])) {
				$this->load->library('m_pdf');
			
				if($search_by=="rotation")
				{
				 $rot=$this->input->post('search_value');
				 $title="LCL ASSIGNMENT REPORT FOR THE ROTATION  ".$rot;
				 $data['rot']=$rot;
				 
				 $strSelect="select lcl_assignment_detail.id,igm_detail_container.cont_number,
					igm_detail_container.cont_size,igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,assignment_date,
					igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,
					lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time, 
					lcl_assignment_detail.last_update AS lst_updt, DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s') as time from lcl_assignment_detail
					inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id 
					inner join igm_masters on igm_masters.id=igm_details.IGM_id 
					inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id where unstuff_flag=0 and igm_details.Import_Rotation_No='$rot' ORDER BY lst_updt ASC ";
					// $lclAssignmentList = $this->bm->dataSelectDb1($strSelect);
					// $data['lclAssignmentList']=$lclAssignmentList; 
			
					// $this->load->view('header5');
					// $this->load->view('lclAssignmentReportTableView',$data);
					// $this->load->view('footer_1');
				}
			  else if($search_by=="container")
				{
				 $cont=$this->input->post('search_value');
				 $title="LCL ASSIGNMENT REPORT FOR THE CONTAINER ".$cont;
				 $todate=$this->input->post('todate');
				 
				 $strSelect="select lcl_assignment_detail.id,igm_detail_container.cont_number,
					igm_detail_container.cont_size,igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,assignment_date,
					igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,
					lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time, DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s') as time from lcl_assignment_detail
					inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id 
					inner join igm_masters on igm_masters.id=igm_details.IGM_id 
					inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id where unstuff_flag=0 AND cont_number='$cont'";
/* 					$lclAssignmentList = $this->bm->dataSelectDb1($strSelect);
					$data['lclAssignmentList']=$lclAssignmentList; 
					
					$this->load->view('header5');
					$this->load->view('lclAssignmentReportTableView',$data);
					$this->load->view('footer_1'); */
				}
			 
			 else if($search_by=="shedNo")	 
				{
				 $shedNo=$this->input->post('shedNo');
				 $fromdate=$this->input->post('fromdate');
				 $todate=$this->input->post('todate');
				 $data['fromdate']=$fromdate;
				 $data['todate']=$todate;
				 
				 $title="LCL ASSIGNMENT REPORT FOR THE SHED NO: ".$shedNo." AND DATE BETWEEN ".$fromdate." AND ".$todate;
				 //$todate=$this->input->post('todate');
				 
				 $strSelect="select lcl_assignment_detail.id,igm_detail_container.cont_number,
					igm_detail_container.cont_size,igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,assignment_date,
					igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,
					lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time,
					lcl_assignment_detail.last_update AS lst_updt, DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s') as time from lcl_assignment_detail
					inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id 
					inner join igm_masters on igm_masters.id=igm_details.IGM_id 
					inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id where unstuff_flag=0 AND cont_loc_shed='$shedNo' AND assignment_date BETWEEN '$fromdate' AND '$todate' ORDER BY lst_updt ASC";


				   
				}
					
			  else if($search_by=="dateRange")
				{
				 $fromdate=$this->input->post('fromdate');
				 $todate=$this->input->post('todate');
				 $data['fromdate']=$fromdate;
				 $data['todate']=$todate;
				 $title="LCL ASSIGNMENT REPORT BETWEEN ".$fromdate." AND ".$todate;	
				 $this->data['title']=$title;
				 
				 $strSelect="select lcl_assignment_detail.id,igm_detail_container.cont_number,
					igm_detail_container.cont_size,igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,assignment_date,
					igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,
					lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time, 
					lcl_assignment_detail.last_update AS lst_updt, DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s') as time from lcl_assignment_detail
					inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id 
					inner join igm_masters on igm_masters.id=igm_details.IGM_id 
					inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id where unstuff_flag=0 AND assignment_date BETWEEN '$fromdate' AND '$todate' ORDER BY lst_updt ASC";

				}
				
			else  
				{

				 $title="LCL ASSIGNMENT REPORT";
				 
				 $strSelect="select lcl_assignment_detail.id,igm_detail_container.cont_number,
					igm_detail_container.cont_size,igm_detail_container.cont_height,igm_details.Import_Rotation_No,Vessel_Name,assignment_date,
					igm_details.mlocode,berthOp as stv,cont_loc_shed,cargo_loc_shed,description_cargo,
					lcl_assignment_detail.remarks,date(lcl_assignment_detail.landing_time)as landing_time, 
					lcl_assignment_detail.last_update AS lst_updt, DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s') as time from lcl_assignment_detail
					inner join igm_details on igm_details.id=lcl_assignment_detail.igm_detail_id 
					inner join igm_masters on igm_masters.id=igm_details.IGM_id 
					inner join igm_detail_container on igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id where unstuff_flag=0 ORDER BY lst_updt ASC";

				   
			   }
					$this->data['title']=$title;
			   		$lclAssignmentList = $this->bm->dataSelectDb1($strSelect);
			

					$data['login_id']=$login_id;
				  
					$this->data['lclAssignmentList']= $lclAssignmentList;
					$html=$this->load->view('lclAssignmentReportViewbySearch',$this->data,true);

					$pdfFilePath ="mypdfName-".time()."-download.pdf";

					$pdf = $this->m_pdf->load();

					$stylesheet = file_get_contents('resources/styles/lcl.css'); 
					$pdf->useSubstitutions = true; 
					$pdf->WriteHTML($stylesheet,1);
					$pdf->WriteHTML($html,2);

					$pdf->Output($pdfFilePath, "I");   //--------pdf view show

		}
	  
			     
	}
	/*
	function lclAssignmentTallyEntry()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
		else
			{
			    $container=$this->uri->segment(3);
				$rot_year=$this->uri->segment(4);
				$rot_no=$this->uri->segment(5);
				$rotation=$rot_year.'/'.$rot_no;
				$data['title']='Tally Entry Form for Rotation: '.$rotation.' and Container: '.$container;
				$data['container']=$container;
				$data['rotation']=$rotation;
				$this->load->view('lclAssignmentReportTallyEntry',$data);
			}	
		
	}
	
	*/
	//Sumon Roy--End-----------------------------------------------
	
	//Sourav Organizational Profile Start 
	function org_creation_form()	
	{		
		$session_id = $this->session->userdata('value');		
		if($session_id!=$this->session->userdata('session_id'))		
		{			
			$this->logout();		
		}		
		else		
		{						
			$sql_org_type="SELECT id,Org_Type FROM tbl_org_types ORDER BY Org_Type ASC";
			$orgList=$this->bm->dataSelectDb1($sql_org_type);
			$data['orgList']=$orgList;
			
			$data['title']="ORGANIZATION PROFILE FORM";			
			$msg="";	
			$data['editFlag']=0;			
			$data['orgDetailList']="";
			$this->load->view('header2');			
			$this->load->view('organization_creation_form',$data);			
			$this->load->view('footer_1');			
		}	
	}
	
	function orgProfileList()
	{
		//print_r($this->session->all_userdata());
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$sql_row_num="select count(*) as rtnValue from organization_profiles";
			
			//echo $sql_row_num;
			$segment_three = $this->uri->segment(3);
			
			$config = array();
			$config["base_url"] = site_url("cfsModule/orgProfileList/$segment_three");
			$config["total_rows"] = $this->bm->dataReturnDb1($sql_row_num);
			$config["per_page"] = 20;
			$offset = $this->uri->segment(4, 0);
			$config["uri_segment"] = 4;
			$limit=$config["per_page"];
			
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			$start=$page;
			
			if($this->input->post('delete'))
			{
				$lclID=$this->input->post('lclID');
				$deleteSql="DELETE FROM organization_profiles WHERE id='$lclID'";
				$deleteStat=$this->bm->dataInsertDB1($deleteSql);
			}
			
		    $strSelect="SELECT organization_profiles.id AS profileId,organization_profiles.Org_Type_id,Org_Type,Organization_Name,AIN_No_New,License_No,Agent_Code
			FROM organization_profiles
			INNER JOIN tbl_org_types ON organization_profiles.Org_Type_id=tbl_org_types.id order by organization_profiles.id desc limit $start,$limit";

			//echo $strSelect;
			//return;
			$profileList = $this->bm->dataSelectDb1($strSelect);
			
			$strOrgType="SELECT * FROM tbl_org_types";

			//echo $strSelect;
			//return;
			$org_type_list = $this->bm->dataSelectDb1($strOrgType);
			
			$strOrgName="SELECT distinct Organization_Name FROM organization_profiles";
			$org_name_list = $this->bm->dataSelectDb1($strOrgName);
			
			$data['profileList']=$profileList;    
			$data['org_type_list']=$org_type_list;    
			$data['org_name_list']=$org_name_list;    
			$data['start']=$start;
			$data['links'] = $this->pagination->create_links();
			
			$data['title']="Organization Profile List...";
			$this->load->view('header5');
			$this->load->view('orgProfileList',$data);
			$this->load->view('footer_1');
		}	
    }
	function searchOrgProfile()
	{
		//print_r($this->session->all_userdata());
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$searchBy=$this->input->post('search_by');
			$cond="";
			if($searchBy=="org_type")
			{
				$orgTypeId=$this->input->post('org_type');
				$cond=" where tbl_org_types.id=".$orgTypeId;
			}
			else if($searchBy=="org_name")
			{
				$orgName=$this->input->post('org_name');
				$cond=" where Organization_Name= '".$orgName."'";
			}
			else if($searchBy=="lic_no")
			{
				$lic=$this->input->post('lic_no');
				$cond=" where License_No='".$lic."'";
			}
			else if($searchBy=="aiin_no")
			{
				$lic=$this->input->post('aiin_no');
				$cond=" where AIN_No_New='".$lic."'";
			}
			else
			{
				$cond="";
			}

			
			$sql_row_num="select count(*) as rtnValue from organization_profiles";
			
			//echo $sql_row_num;
			$segment_three = $this->uri->segment(3);
			
			$config = array();
			$config["base_url"] = site_url("cfsModule/orgProfileList/$segment_three");
			$config["total_rows"] = $this->bm->dataReturnDb1($sql_row_num);
			$config["per_page"] = 20;
			$offset = $this->uri->segment(4, 0);
			$config["uri_segment"] = 4;
			$limit=$config["per_page"];
			
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			$start=$page;
			
		    $strSelect="SELECT organization_profiles.id AS profileId,organization_profiles.Org_Type_id,Org_Type,Organization_Name,AIN_No_New,License_No,Agent_Code 
			FROM organization_profiles
			INNER JOIN tbl_org_types ON organization_profiles.Org_Type_id=tbl_org_types.id".$cond. 
			" limit $start,$limit";

			//echo $strSelect;
			//return;
			$profileList = $this->bm->dataSelectDb1($strSelect);
			
			$strOrgType="SELECT * FROM tbl_org_types";

			//echo $strSelect;
			//return;
			$org_type_list = $this->bm->dataSelectDb1($strOrgType);
			
			$strOrgName="SELECT distinct Organization_Name FROM organization_profiles";
			$org_name_list = $this->bm->dataSelectDb1($strOrgName);
			
			$data['profileList']=$profileList;    
			$data['org_type_list']=$org_type_list;    
			$data['org_name_list']=$org_name_list; 
			$data['start']=$start;
			$data['links'] = $this->pagination->create_links();
			
			$data['title']="Organization Profile List...";
			$this->load->view('header5');
			$this->load->view('orgProfileList',$data);
			$this->load->view('footer_1');
		}	
    }
	function editOrgProfile()
	{
		$login_id = $this->session->userdata('login_id');
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
				$this->logout();
		}
		else
		{
			$lclID=$this->input->post('lclID');
			
			$selectSql="SELECT organization_profiles.id AS profileId,organization_profiles.Org_Type_id,Org_Type,Organization_Name,AIN_No_New,License_No,Agent_Code,
			License_issue_Date,Licence_Validity_Date,Address_1,Address_2,Address_3,Telephone_No_Land,Cell_No_1,Cell_No_2,Fax_No,email,URL
			FROM organization_profiles
			INNER JOIN tbl_org_types ON organization_profiles.Org_Type_id=tbl_org_types.id
			where organization_profiles.id='$lclID'";
            //echo $selectSql;
            //return;
			$orgDetailList=$this->bm->dataSelectDb1($selectSql);
			$data['orgDetailList']=$orgDetailList;
			
			$sql_org_type="SELECT id,Org_Type FROM tbl_org_types ORDER BY Org_Type ASC";
			$orgList=$this->bm->dataSelectDb1($sql_org_type);
			$data['orgList']=$orgList;
			
			$data['editFlag']=1;

			$data['title']="ORGANIZATION PROFILE FORM";	
			$data['msg']="";

			$this->load->view('header2');
			$this->load->view('organization_creation_form',$data);
			$this->load->view('footer');
		}
	}
	function org_creation_action()
	{
		$login_id = $this->session->userdata('login_id');
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
				$this->logout();
		}
		else
		{
			$org_prof_id=$this->input->post('org_prof_id');		//hidden
			
			$orgType=$this->input->post('org_type');
			$sql_org_type_id="SELECT id as rtnValue FROM tbl_org_types WHERE Org_Type='$orgType'";

			$org_Type_id=$this->bm->dataReturnDb1($sql_org_type_id);
			//echo "hh : ".$org_Type_id;
			//return;
			
			$org_name=$this->input->post('org_name');
			$ain_no=$this->input->post('ain_no');
			
			$license_no=$this->input->post('license_no');
			$license_issue_dt=$this->input->post('license_issue_dt');
			$license_validity_dt=$this->input->post('license_validity_dt');
			
			$address_1=$this->input->post('address_1');
			$address_2=$this->input->post('address_2');
			$address_3=$this->input->post('address_3');
			
			$land_phone=$this->input->post('land_phone');
			$cell_phone_1=$this->input->post('cell_phone_1');
			$cell_phone_2=$this->input->post('cell_phone_2');
			
			$fax_no=$this->input->post('fax_no');
			$email=$this->input->post('email');
			$url=$this->input->post('url');
			
			$agent_code=$this->input->post('agent_code');
			
			$login_id = $this->session->userdata('login_id');
			
			if($org_prof_id>0)
			{
				$sql_org_create="UPDATE organization_profiles
				 SET Org_Type_id='$org_Type_id',`Organization_Name`='$org_name',`License_No`='$license_no',
				 AIN_No='$ain_no',AIN_No_New='$ain_no',
				`License_issue_Date`='$license_issue_dt',
				`Licence_Validity_Date`='$license_validity_dt',`Address_1`='$address_1',
				`Address_2`='$address_2',`Address_3`='$address_3',`Telephone_No_Land`='$land_phone',
				`Cell_No_1`='$cell_phone_1',`Cell_No_2`='$cell_phone_2',`Fax_No`='$fax_no',`email`='$email',
				`URL`='$url',`Last_Update_By_id`='$login_id',`last_update`=NOW(),`Agent_Code`='$agent_code'
				 WHERE id=$org_prof_id";
			}
			else
			{				
				$sql_org_create="INSERT INTO organization_profiles(`Org_Type_id`,`Organization_Name`,`AIN_No`,`AIN_No_New`,`License_No`,`License_issue_Date`,`Licence_Validity_Date`,`Address_1`,`Address_2`,`Address_3`,`Telephone_No_Land`,`Cell_No_1`,`Cell_No_2`,`Fax_No`,`email`,`URL`,`Last_Update_By_id`,`last_update`,`Agent_Code`)
				VALUES('$org_Type_id','$org_name','$ain_no','$ain_no','$license_no','$license_issue_dt','$license_validity_dt','$address_1','$address_2','$address_3','$land_phone','$cell_phone_1','$cell_phone_2','$fax_no','$email','$url','$login_id',NOW(),'$agent_code')";
			}
			
			//$rslt_org_create=1;
			$rslt_org_create=$this->bm->dataInsertDB1($sql_org_create);
			
			//echo $sql_org_create;
			//return;
			
			if($rslt_org_create==1)
				$msg="<font color='green'><b>Organization profile created</b></font>";
			else
				$msg="<font color='red'><b>Failed</b></font>";
			
			$sql_org_type="SELECT id,Org_Type FROM tbl_org_types ORDER BY Org_Type ASC";
			$orgList=$this->bm->dataSelectDb1($sql_org_type);
			$data['orgList']=$orgList;
			
			$data['editFlag']=0;

			$data['title']="ORGANIZATION PROFILE FORM";	
			$data['msg']=$msg;
			
			$this->load->view('header2');
			$this->load->view('organization_creation_form',$data);
			$this->load->view('footer_1');	
			
			//echo "HELLO : ".$orgType;
			//return;
		}
	}
	//Sourav Organizational Profile End
	
	
}

?>