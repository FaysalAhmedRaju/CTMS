<?php

class report extends CI_Controller {
	function __construct()
	{
	    parent::__construct();	
            $this->load->library(array('session', 'form_validation'));
            $this->load->model(array('CI_auth', 'CI_menu'));
            $this->load->helper(array('html','form', 'url'));
			$this->load->driver('cache');
			$this->load->helper('file');
			$this->load->model('ci_auth', 'bm', TRUE);
			$this->load->library("pagination");
			
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
			
	}
        
        function index(){
		 $this->report();
        }
		
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
		
		function report(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="FEEDER DISCHARGE SUMMARY LIST...";
				$this->load->view('header2');
				$this->load->view('myFeederDischargeHTML',$data);
				$this->load->view('footer');
			}	
        }
		
		
		
		function reportView(){
		$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		$billQuery="select mlo_code,draft_id,pdf_draft_view_name,pdf_detail_view_name 
					from ctmsmis.mis_billing 
					where imp_rot='$ddl_imp_rot_no'";
		$rtnBillData=$this->bm->dataSelect($billQuery);
		$countBillRow=count($rtnBillData);
		$data['countBillRow']=$countBillRow;
		$data['rtnBillData']=$rtnBillData;
		$this->load->view('myReportDischargeSummeryList',$data);
		$this->load->view('myclosebar');
		
		}
		function offdocdepotLadenContForm()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
				$data['title']="DEPOT LADEN CONTAINER AT CHITTAGONG PORT";
				$this->load->view('header2');
				$this->load->view('offdocdepotLadenContForm',$data);
				$this->load->view('footer');
			}
		}
		
		function offdocdepotLadenCont()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$sValue=$this->input->post('sValue');
				$data['sValue']=$sValue;
				$login_id = $this->session->userdata('login_id');	
				$data['login_id']=$login_id;
				$data['title']="DEPOT LADEN CONTAINER AT CHITTAGONG PORT UP TO";
				//$this->load->view('header2');
				$this->load->view('offdocdepotLadenContHTML',$data);
				//$this->load->view('footer');
			}
		}
		function myViewBreakBulkList(){
		
		$this->load->view('myViewBreakBulkListView',$data);
		$this->load->view('myclosebar');
		}
		//BILL SUMMARY START
		function myRountingPointCodeList(){
		
		$this->load->view('myRountingPointCodeListView',$data);
		$this->load->view('myclosebar');
		}
		function myBillSummaryForm(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="Bill Summary Form";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('myBillSummaryFormView',$data);
				$this->load->view('footer');
			}	
        }
		function myBillSummaryviews(){
		$fromdate=$this->input->post('fromdate');
		$todate=$this->input->post('todate');
		$data['fromdate']=$fromdate;
		$data['todate']=$todate;
		$this->load->view('myVesselBillSummaryviews',$data);
		$this->load->view('myclosebar');
		}
		function dateWiseEqipAssignForm(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="DATE WISE EQUIPMENT ASSINGMENT LIST...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('dateWiseEqipAssignFormView',$data);
				$this->load->view('footer');
			}	
        }
		
		function dateWiseEqipAssignReport()
		{
		//echo date('Y-m-d');
		if($this->input->post())
		{
			$fromdate=$this->input->post('fromdate');
		}
		else
		{
			$fromdate = date('Y-m-d');
		}
		$type=$this->input->post('options1');
		$login_id = $this->session->userdata('login_id');	
		$data['login_id']=$login_id;	
		$data['fromdate']=$fromdate;
		$data['todate']=$todate;
		$data['type']=$type;
		//echo $data['voysNo'];
		$this->load->view('dateWiseEqipAssignReportReport',$data);
		$this->load->view('myclosebar');
		}
		//SC SELECT
		function myEquipmentLoginLogout(){
			
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="EQUIPMENT HANDLING PERFORMANCE LOGIN";
				$this->load->view('header2');
				$this->load->view('myEquipmentLoginLogoutForm',$data);
				$this->load->view('footer');
			}	
        }
		function myEquipmentLoginLogoutView(){
			
				$fromdate=$this->input->post('fromdate');
				$equip=$this->input->post('equip');
				$shift=$this->input->post('shift');
				$euser=$this->input->post('euser');
				$serch_by=$this->input->post('serch_by');
				$data['serch_by']=$serch_by;
				$serch_value=$this->input->post('serch_value');
				$data['serch_value']=$serch_value;
				$serch_combo=$this->input->post('serch_combo');
				$data['serch_combo']=$serch_combo;
				$data['fromdate']=$fromdate;
				$data['equip']=$equip;
				$data['shift']=$shift;
				$data['euser']=$euser;
				$this->load->view('myEquipmentLoginLogoutViewList',$data);
				$this->load->view('myclosebar');
			
		}
		//SC END
		//SaifPowerTech start
	function myEquipmentHandlingHistory()
	{
		//print_r($this->session->all_userdata());
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$data['title']="EQUIPMENT HANDLING PERFORMANCE HISTORY...";
			//echo $data['title'];
			$this->load->view('header2');
			$this->load->view('myEquipmentHandlingHistoryForm',$data);
			$this->load->view('footer');
		}	
    }
		
	function myEquipmentHandlingHistoryView()
	{
		$type=$this->input->post('options');
				
		$data['type']=$type;
		$fromdate=$this->input->post('fromdate');
		$shift=$this->input->post('shift');
		$todate=$this->input->post('todate');
		$data['fromdate']=$fromdate;
		$data['shift']=$shift;
		$data['todate']=$todate;
		
		if($shift=="timewise")
		{
			$fromtime=$this->input->post('fromtime');
			$data['fromtime']=$fromtime.":00";
			$totime=$this->input->post('totime');
			$data['totime']=$totime.":00";
		}
		
		$this->load->view('myEquipmentHandlingHistoryViewList',$data);
		$this->load->view('myclosebar');
	}
		//Bill Summery END
		
		function dateWiseoffDockContListForm(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="DATE WISE PRE ADVICE CONTAINER LIST...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('dateWiseoffDockContListFormView',$data);
				$this->load->view('footer');
			}	
        }
		function dateAndRoationWisePreAdviseCont(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="LOADED CONTAINER SUMMARY LIST...";
				$this->load->view('header2');
				$this->load->view('dateWisePreAdviseContForm',$data);
				$this->load->view('footer');
			}	
        }
		function dateAndRoatinWisePreAdviseContView(){		
		$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		$fromdate=$this->input->post('fromdate');
		//$todate=$this->input->post('todate');
		$data['fromdate']=$fromdate;
		//$data['todate']=$todate;
		$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
		$this->load->view('dateWisePreAdviseContViewList',$data);
		$this->load->view('myclosebar');
		
		}
		function dateWiseoffDockContListReport(){
		$fromdate=$this->input->post('fromdate');
		$todate=$this->input->post('todate');
		$type=$this->input->post('options1');
		$login_id = $this->session->userdata('login_id');	
		$data['login_id']=$login_id;	
		$data['fromdate']=$fromdate;
		$data['todate']=$todate;
		$data['type']=$type;
		//echo $data['voysNo'];
		$this->load->view('dateWiseoffDockContListReport',$data);
		$this->load->view('myclosebar');
		}
		//
		function offDockContListForm()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$data['title']="POSITION WISE OFFDOCK CONTAINER";
				$this->load->view('header2');
				$this->load->view('offDockContListForm',$data);
				$this->load->view('footer');
			}
		}
		
		function offDockContListViews()
		{
			
				$login_id = $this->session->userdata('login_id');	
				$data['login_id']=$login_id;
				$positon=$this->input->post('positon');
				$data['positon']=$positon;
				$data['title']="OFFDOCK CONTAINER AT CHITTAGONG PORT";
				$this->load->view('offDockContListViews',$data);
			
		}
		//containe Search
		function offDockContSearchForm()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$data['title']="POSITION WISE OFFDOCK CONTAINER";
				$this->load->view('header2');
				$this->load->view('offDockContSearchFormHTML',$data);
				$this->load->view('footer');
			}
		}
		
		function offDockContSearchViews()
		{
			
				$login_id = $this->session->userdata('login_id');	
				$data['login_id']=$login_id;
				$container_no=$this->input->post('container_no');
				$data['container_no']=$container_no;
				$data['title']="OFFDOCK CONTAINER AT CHITTAGONG PORT";
				$this->load->view('offDockContSearchViews',$data);
			
		}
		//Container Searcch
		//PreAdvice Panel
		
		function myoffDocWiseContStatus(){
		$login_id = $this->session->userdata('login_id');	
		$data['login_id']=$login_id;	
		$UserName = $this->session->userdata('User_Name');
		$data['UserName']=$UserName;
		$this->load->view('myoffDocWiseContStatusView',$data);
		$this->load->view('myclosebar');
		}
					function myAgentWiseVesselInfo(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="AGENT WISE PREADVICE CONTAINER REPORT...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('myAgentWiseVesselInfoForm',$data);
				$this->load->view('footer');
			}	
        }
		function myReportHHTReCord(){
				$this->load->library('m_pdf');
				$pdf->use_kwt = true;
				$this->data['title']="Assigned Equipment Report";
				$pdfFilePath ="AssignedEquipmentList-".time()."-download.pdf";
				$pdf = $this->m_pdf->load();
				$pdf->SetWatermarkText('CPA CTMS');
				$pdf->showWatermarkText = true;	
				//$this->data['fromdate']=$fromdate;
				$html=$this->load->view('myReportHHTReCordView',$this->data, true);
				$stylesheet = file_get_contents('resources/styles/test.css'); // external css
				//$scriptSheet = file_get_contents('resources/scripts/JsBarcode.all.min.js'); // external css
				$pdf->useSubstitutions = true; // optional - just as an example
				//$pdf->SetHeader($url . "\n\n" . 'Date {DATE j-m-Y}');  // optional - just as an example
				//echo "SheetAdd : ".$stylesheet;
				$pdf->setFooter('Developed By : DataSoft|Page {PAGENO} of {nb}|Date {DATE j-m-Y}');
				
				$pdf->WriteHTML($stylesheet,1);
				$pdf->WriteHTML($html,2);
				//$pdf->WriteHTML($scriptSheet,3);
				$pdf->Output($pdfFilePath, "I"); // For Show Pdf
				
				//$this->load->view('myReportHHTReCordView',$data);
				//$this->load->view('myclosebar');
		}
		function myAgentWiseVesselInfoReport()
		{
			
			$rot=$this->input->post('ddl_imp_rot_no');
			$data['rot']=$rot;
			$this->load->view('mymyAgentWiseVesselInfoView',$data);
			$this->load->view('myclosebar');
			
		}
		function myoffDociew(){
			
		$UserName = $this->session->userdata('User_Name');
		$data['UserName']=$UserName;
		$this->load->view('myoffDociew',$data);
		$this->load->view('myclosebar');
		}
		
		function commodityInfoView(){
			
		$UserName = $this->session->userdata('User_Name');
		$data['UserName']=$UserName;
		$this->load->view('commodityInfoView',$data);
		$this->load->view('myclosebar');
		}
		
		function myPortCodeList(){
			
		$UserName = $this->session->userdata('User_Name');
		$data['UserName']=$UserName;
		$this->load->view('myPortCodeListView',$data);
		$this->load->view('myclosebar');
		}
		function myAgentWiseVessel(){
		$login_id = $this->session->userdata('login_id');	
		$UserName = $this->session->userdata('User_Name');
		$data['login_id']=$login_id;
		$data['UserName']=$UserName;
		$this->load->view('myAgentWiseVesselView',$data);
		$this->load->view('myclosebar');
		}
		
		function myPreAdviceContainerDetail($year,$serial)
		{
			$login_id = $this->session->userdata('login_id');	
			$data['login_id']=$login_id;
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
			$rot=$year."/".$serial;
			$data['rot']=$rot;
			
			$vvdGkey=$this->input->post('vvdGkey');
			$data['vvdGkey']=$vvdGkey;
			
			$this->load->view('myPreAdviceContainerDetailView',$data);
			$this->load->view('myclosebar');
			
			
			
		}
		
		function myAgentWiseContainerStatus(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="AGENT WISE PREADVICE CONTAINER REPORT...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('myAgentWiseContainerStatusForm',$data);
				$this->load->view('footer');
			}	
        }
		
		function myAgentWiseContainerStatusReport(){
		$login_id = $this->session->userdata('login_id');	
		$data['login_id']=$login_id;
		$login_id = $this->session->userdata('login_id');	
		$data['login_id']=$login_id;
		$serch_by=$this->input->post('serch_by');
		$data['serch_by']=$serch_by;
		$serch_value=$this->input->post('serch_value');
		$data['serch_value']=$serch_value;
		$serch_combo=$this->input->post('serch_combo');
		$data['serch_combo']=$serch_combo;
		$this->load->view('myAgentWiseContainerStatusReportView',$data);
		$this->load->view('myclosebar');
			
  }
  function myOffdocWiseContainerStatus(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="AGENT WISE PREADVICE CONTAINER REPORT...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('myOffdocWiseContainerStatusForm',$data);
				$this->load->view('footer');
			}	
        }
		
		function myOffdocWiseContainerStatusReport(){
		$login_id = $this->session->userdata('login_id');	
		$data['login_id']=$login_id;
		$rot=$this->input->post('ddl_imp_rot_no');
		$data['rot']=$rot;
		echo $data['cont'];
		$this->load->view('myOffdocWiseContainerStatusReportView',$data);
		$this->load->view('myclosebar');
			
  }
		function loadedContainerList(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="LOADED CONTAINER SUMMARY LIST...";
				$this->load->view('header2');
				$this->load->view('myloadedContainerListHTML',$data);
				$this->load->view('footer');
			}	
        }
		
		function loadedContainerListView($rot){
		if($this->input->post())
		{
		$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		}
		else
		{
			$ddl_imp_rot_no=$rot;
		}
		//$this->load->model('ci_auth', 'bm', TRUE);
		//$getVvdGkey = $this->bm->loadedContainerListView($ddl_imp_rot_no);
		//$data['vvdGkey']=$getVvdGkey;
		$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
		$this->load->view('myReportLoadedContainerList',$data);
		$this->load->view('myclosebar');
		
		}
		//ROTATIN WISE CONTAINER INFORMATION START
		
		function myRotationWiseContInfoForm(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="ROTATIN WISE CONTAINER INFORMATION...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('myRotationWiseContInfoFormView',$data);
				$this->load->view('footer');
			}	
        }
		function myRotationWiseContInfo(){
		$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
		$this->load->view('myRotationWiseContInfoView',$data);
		$this->load->view('myclosebar');
		}
		
		
		//ROTATIN WISE CONTAINER INFORMATION END
		//VESSEL WISE REFFER CONTAINER START
		function vesslWiseRefeerContainerList(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="LOADED CONTAINER SUMMARY LIST...";
				$this->load->view('header2');
				$this->load->view('vesslWiseRefeerContainerForm',$data);
				$this->load->view('footer');
			}	
        }
		function vesslWiseRefeerContainerListView(){		
		$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		$fromdate=$this->input->post('fromdate');
		$todate=$this->input->post('todate');
		$data['fromdate']=$fromdate;
		$data['todate']=$todate;
		$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
		$this->load->view('vesslWiseRefeerContainerViewList',$data);
		$this->load->view('myclosebar');
		
		}
		
		function vesslWiseRefeerContainer($year,$serial)
		{
			
			$rot=$year."/".$serial;
			$data['rot']=$rot;
			$this->load->view('vesslWiseRefeerContainerListDetails',$data);
		}
		//VESSEL WISE REFFER CONTAINER END
		
		//DESTI START
		function destinationloadedContainerList(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="LOADED CONTAINER SUMMARY LIST...";
				$this->load->view('header2');
				$this->load->view('mydestinationloadedContainerListHTML',$data);
				$this->load->view('footer');
			}	
        }
		function destinationloadedContainerListView($rot){
		if($this->input->post())
		{
		$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		}
		else
		{
			$ddl_imp_rot_no=$rot;
		}
		//$this->load->model('ci_auth', 'bm', TRUE);
		//$getVvdGkey = $this->bm->loadedContainerListView($ddl_imp_rot_no);
		//$data['vvdGkey']=$getVvdGkey;
		$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
		$this->load->view('myReportDestinationWiseLoadedContainerList',$data);
		$this->load->view('myclosebar');
		
		}
		//DESTI END
		//mlo wise preadvice start
		function mloWisePreadviceloadedContainerList(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="LOADED CONTAINER SUMMARY LIST...";
				$this->load->view('header2');
				$this->load->view('mloWisePreadviceForm',$data);
				$this->load->view('footer');
			}	
        }
		
		function mloWisePreadviceListView(){		
		$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		
		$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
		$this->load->view('mloWisePreadviceViewList',$data);
		$this->load->view('myclosebar');
		
		}
		//new............
		
		function mloWisePreadviceDetailsListView(){
		
		$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		
		
		
		$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
		$this->load->view('mloWisePreadviceViewListDetails',$data);
		$this->load->view('myclosebar');
		
		}
		//........
		function myPreAdviceAllView($year,$serial,$mlo)
		{
			
			$rot=$year."/".$serial;
			$data['rot']=$rot;
			$data['mlo']=$mlo;
			$this->load->view('mloWisePreadviceViewListDetails',$data);
		}
		function mlowiseviewsummary($year,$serial,$mlo)
		{
			
			$rot=$year."/".$serial;
			$data['rot']=$rot;
			$data['mlo']=$mlo;
			$this->load->view('mloWiseSummeryList',$data);
		}
		
		
		//mlo wise preadvice end
		//Mlo wise import export summery for Export loading apps
		function myExportImExSummery(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="LOADED CONTAINER SUMMARY LIST...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('myReportImExSummeryExportLoading',$data);
				$this->load->view('footer');
			}	
        }
		//ss
		
		function loadedFreightKindContainerList(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="LOADED CONTAINER FREIGHT KIND SUMMARY LIST...";
				$this->load->view('header2');
				$this->load->view('myloadedContainerFreightKindListHTML',$data);
				$this->load->view('footer');
			}	
        }
		function loadedContainerFreightKindListView(){
		$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		//$this->load->model('ci_auth', 'bm', TRUE);
		//$getVvdGkey = $this->bm->loadedContainerListView($ddl_imp_rot_no);
		//$data['vvdGkey']=$getVvdGkey;
		//echo $data['vvdGkey'];
		$this->load->view('myReportLoadedContainerFreightKindList',$data);
		$this->load->view('myclosebar');
		
		}
		//ss
		function myExportImExSummeryView($rot){
		if($this->input->post())
		{
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		}
		else if($this->uri->segment(3))
		{
			$ddl_imp_rot_no=str_replace("_","/",$this->uri->segment(3));
		}
		else
		{
			$ddl_imp_rot_no=$rot;
		}
		//echo "==".$ddl_imp_rot_no;
		$this->load->model('ci_auth', 'bm', TRUE);
		$getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
		$data['voysNo']=$getVoyNo;		
		$data['ddl_imp_rot_no']=$ddl_imp_rot_no;		
		//echo $data['voysNo'];
		$this->load->view('myReportImExSummeryExportLoadingList',$data);
		$this->load->view('myclosebar');
		
		}
		//End Mlo wise import export summery for Export loading apps
		
		
		// export container Loading Report for Export loading apps
		function myExportContainerLoadingReport(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="EXPORT CONTAINER LOADING REPORT...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('myReportExportContainerLoading',$data);
				$this->load->view('footer');
			}	
        }
		function myExportContainerLoadingReportView(){
		$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		$this->load->model('ci_auth', 'bm', TRUE);
		$getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
		$data['voysNo']=$getVoyNo;
		$fromdate=$this->input->post('fromdate');
		$fromTime=$this->input->post('fromTime');
		$todate=$this->input->post('todate');
		$toTime=$this->input->post('toTime');
		$button_show=0;
		if($_POST['options']=='html')
			$button_show=1;
		$data['fromdate']=$fromdate;
		$data['fromTime']=$fromTime;
		$data['todate']=$todate;
		$data['toTime']=$toTime;
		$data['button_show']=$button_show;
		
		//echo $data['toTime'];
		//return;
		$this->load->view('myReportExportContainerLoadingList',$data);
		$this->load->view('myclosebar');
		
		}
		//Export container ToBe Loading start
		function ExportContainerTobeLoadingReport(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="EXPORT CONTAINER TO BE LOADED...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('ReportExportContainerTobeLoaded',$data);
				$this->load->view('footer');
			}	
        }
		function ExportContainerToBeLodedView(){
		$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		$this->load->model('ci_auth', 'bm', TRUE);
		$getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
		$data['voysNo']=$getVoyNo;
		//echo $data['voysNo'];
		$this->load->view('ExportContainerToBeLodedList',$data);
		$this->load->view('myclosebar');
		
		}
		//Export container ToBe Loading end
		//PRE ADVICE START
		function RequestForPreAdviceReport(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="REQUEST FOR PREADVICE CONTAINER LIST...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('ReportForPreAdviceContaineList',$data);
				$this->load->view('footer');
			}	
        }
		
	function garmentsContInfoForm()
	{
		//print_r($this->session->all_userdata());
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$data['title']="Container Information (Garments Item) Form...";
			$this->load->view('header2');
			$this->load->view('garmentsContInfo',$data);
			$this->load->view('footer');
		}	
    }
	
	function garmentContInfoList($rot)
	{
		$fileType=$this->input->post('fileOptions');
		if($this->input->post())
		{
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		}
		else
		{
			$ddl_imp_rot_no=$rot;
		}
		
		if($fileType!="pdf" )
		{  
			$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
			$this->load->view('garmentContInfoList',$data);
			$this->load->view('myclosebar');
		} 
				   
		else if($fileType=="pdf")
		{  
				   
			$this->load->library('m_pdf');
			$mpdf->use_kwt = true;
			$this->data['ddl_imp_rot_no']=$ddl_imp_rot_no;
			//$this->data['title']="Country Wise Import Report";

			$html=$this->load->view('garmentContInfoList',$this->data, true); 
			$pdfFilePath ="garmentContInfoList".time().".pdf";

			//actually, you can pass mPDF parameter on this load() function
			$pdf = $this->m_pdf->load();
			$pdf->SetWatermarkText('CPA CTMS');
			$pdf->showWatermarkText = true;					
			//$stylesheet = file_get_contents('resources/styles/test.css'); // external css
			$pdf->setFooter('Developed By : DataSoft|Page {PAGENO}|Date {DATE j-m-Y}');
			$pdf->WriteHTML($html,2);
			$pdf->Output($pdfFilePath, "I"); // For Show Pdf					
		 }
		//$this->load->model('ci_auth', 'bm', TRUE);
		//$getVvdGkey = $this->bm->loadedContainerListView($ddl_imp_rot_no);
		//$data['vvdGkey']=$getVvdGkey;
/* 		$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
		$this->load->view('garmentContInfoList',$data); */

		
	}
	
	/// SOURAV SEARCH ITEM BY ROTATION START 
	function searchGarmentsItemByRotationForm()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$data['title']="Container Information Form...";
			$this->load->view('header2');
			$this->load->view('searchGarmentsItemByRotationForm',$data);
			$this->load->view('footer');
		}	
	}
	function searchGarmentsItemByRotationList()
	{
		$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		$ddl_imp_item=$this->input->post('ddl_imp_item');
		/*if($this->input->post())
		{
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		}
		else
		{
			$ddl_imp_rot_no=$rot;
		}*/
		//$this->load->model('ci_auth', 'bm', TRUE);
		//$getVvdGkey = $this->bm->loadedContainerListView($ddl_imp_rot_no);
		//$data['vvdGkey']=$getVvdGkey;
		$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
		$data['ddl_imp_item']=$ddl_imp_item;
		$this->load->view('searchGarmentsItemByRotationList',$data);
		$this->load->view('myclosebar');
		
	}
	/// SOURAV SEARCH ITEM BY ROTATION END
		
		function RequestForPreAdviceReportView(){
		$this->load->model('ci_auth', 'bm', TRUE);
		$fromdate=$this->input->post('fromdate');
		$todate=$this->input->post('todate');
		$data['fromdate']=$fromdate;
		$data['todate']=$todate;
		$this->load->view('RequestForPreAdviceReportList',$data);
		$this->load->view('myclosebar');
		
		}
		//PRE ADVICE CONTAINER LIST END
		function myContainerDelete(){
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
			$gkey=$this->input->post('gkey');
			//$this->load->model('ci_auth', 'bm', TRUE);
			$strTrans = "select sparcsn4.inv_unit_fcy_visit.transit_state as rtnValue 
			from sparcsn4.inv_unit_fcy_visit where sparcsn4.inv_unit_fcy_visit.unit_gkey='$gkey'";
			$transStat = $this->bm->dataReturn($strTrans);
			if($strTrans=='S60_LOADED' or $strTrans=='S70_DEPARTED')
			{
				$strUpdateDelFlg = "UPDATE ctmsmis.mis_exp_unit SET delete_flag='1' where gkey='$gkey'";
				$this->bm->dataUpdate($strUpdateDelFlg);
			}
			else{
				$strDel = "DELETE FROM ctmsmis.mis_exp_unit WHERE gkey='$gkey'";
				$this->bm->dataDelete($strDel);
			}
			$button_show=1;
			$data['button_show']=$button_show;
			//$getVoyNo = $this->bm->myContDelete($gkey);
			//$data['voysNo']=$this->input->post('voysNumber');
			$this->load->view('myReportExportContainerLoadingList',$data);
			$this->load->view('myclosebar');
			
		}
		
		
		function myExportContainerNotFoundReport(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="EXPORT CONTAINER NOT FOUND REPORT...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('myNotFounContForm',$data);
				$this->load->view('footer');
			}	
        }
		
		function myExportContainerNotFoundReportView(){
		$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		$this->load->model('ci_auth', 'bm', TRUE);
		$getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
		$data['voysNo']=$getVoyNo;
		$fromdate=$this->input->post('fromdate');
		$todate=$this->input->post('todate');
		$data['fromdate']=$fromdate;
		$data['todate']=$todate;
	
		//echo $data['voysNo'];
		$this->load->view('myReportExportContainerNotFoundList',$data);
		$this->load->view('myclosebar');
		}
		//Blocked start
		function myBlockedContainerView(){
			
		$UserName = $this->session->userdata('User_Name');
		$data['UserName']=$UserName;
		$this->load->view('myBlockedContainerList',$data);
		$this->load->view('myclosebar');
		}
		function myBlockedContainerAllView(){
			
		$UserName = $this->session->userdata('User_Name');
		$data['UserName']=$UserName;
		$this->load->view('myBlockedContainerAllList',$data);
		$this->load->view('myclosebar');
		}
		//BLOCKE END
		//Export container list start
		function myExportContainerLoadingReportForm(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="EXPORT CONTAINER LOADING REPORT...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('myReportExportContainerLoadedForm',$data);
				$this->load->view('footer');
			}	
        }
		function myExportContainerLoadedReportView(){
		$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		
		$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
		
		
		$fromdate=$this->input->post('fromdate');
		$fromTime=$this->input->post('fromTime');
		$todate=$this->input->post('todate');
		$toTime=$this->input->post('toTime');
		$data['fromdate']=$fromdate;
		$data['fromTime']=$fromTime;
		$data['todate']=$todate;
		$data['toTime']=$toTime;
		
		
		$this->load->view('myReportExportContainerLoadingListView',$data);
		$this->load->view('myclosebar');
		
		}
		//Export container list end
		//IMport container list start
		function myImportContainerLoadingReportForm(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="IMPORT CONTAINER DISCHARGE LIST REPORT...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('myReportImportContainerLoadedForm',$data);
				$this->load->view('footer');
			}	
        }
		function myImportContainerLoadedReportView(){
		$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		$this->load->model('ci_auth', 'bm', TRUE);
		
		$fromdate=$this->input->post('fromdate');
		$fromTime=$this->input->post('fromTime');
		$todate=$this->input->post('todate');
		$toTime=$this->input->post('toTime');
		$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
		$data['fromdate']=$fromdate;
		$data['fromTime']=$fromTime;
		$data['todate']=$todate;
		$data['toTime']=$toTime;
		
		
		//echo $data['toTime'];
		//return;
		$this->load->view('myReportImportContainerLoadingListView',$data);
		$this->load->view('myclosebar');
		
		}
		//IMport container list end
		//shahadat
		function myImportContainerDischargeReport(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="IMPORT CONTAINER DISCHARGE REPORT...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('myReportImportContainerDischarging',$data);
				$this->load->view('footer');
			}	
        }
		function myImportContainerDischargeReportView($rot){
		if($this->input->post())
		{
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		}
		else
		{
			$ddl_imp_rot_no=$rot;
		}
		$this->load->model('ci_auth', 'bm', TRUE);
		$getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
		$data['voysNo']=$getVoyNo;
		$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
		//echo $data['voysNo'];
		$this->load->view('myReportImportContainerDischargeList',$data);
		$this->load->view('myclosebar');
		
		}
		//REFFER CONTAINER
		function myRefferImportContainerDischargeReport(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="YARD WISE REFFER IMPORT CONTAINER...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('berthOperatorImportContainerDischarging',$data);
				$this->load->view('footer');
			}	
        }
		function myRefferImportContainerDischargeReportView(){
			$rptType=$this->input->post('options');
			$type=$this->input->post('options1');
		if (isset($_POST['submit_login'])) {
			if($rptType=="pdf")
			{
				$this->load->library('m_pdf');
				$pdf->use_kwt = true;
				$this->data['title']="Reffer Delivery Report";

				if($type=="deli")
				{
					$fromdate=$this->input->post('fromdate');
					$todate=$this->input->post('todate');
					$yard_no=$this->input->post('yard_no'); 
					$rfrConStat=$this->input->post('optionsC');
					
					$this->data['fromdate']=$fromdate;
					$this->data['todate']=$todate;
					$this->data['yard_no']=$yard_no;
					$this->data['rfrConStat']=$rfrConStat;
					
					$html=$this->load->view('myRefferImportDeliveryReportList',$this->data, true);
				}
				else
				{
					$fromdate=$this->input->post('fromdate');
					$todate=$this->input->post('todate');
					$type=$this->input->post('options1');
					$yard_no=$this->input->post('yard_no'); 
					
					$this->data['fromdate']=$fromdate;
					$this->data['todate']=$todate;
					$this->data['yard_no']=$yard_no;
					$this->data['type']=$type;
					
					$html=$this->load->view('myRefferImportContainerDischargeReportList',$this->data, true);
				}
				
				
				//this the the PDF filename that user will get to download
				$pdfFilePath ="Reefer_Container_List-".time()."-download.pdf";
				$pdf = $this->m_pdf->load();
				$pdf->SetWatermarkText('CPA CTMS');
				$pdf->showWatermarkText = true;	
				$stylesheet = file_get_contents('resources/styles/test.css'); // external css
				//$scriptSheet = file_get_contents('resources/scripts/JsBarcode.all.min.js'); // external css
				$pdf->useSubstitutions = true; // optional - just as an example
				//$pdf->SetHeader($url . "\n\n" . 'Date {DATE j-m-Y}');  // optional - just as an example
				//echo "SheetAdd : ".$stylesheet;
				$pdf->setFooter('Developed By : DataSoft|Page {PAGENO} of {nb}|Date {DATE j-m-Y}');
				
				$pdf->WriteHTML($stylesheet,1);
				$pdf->WriteHTML($html,2);
				//$pdf->WriteHTML($scriptSheet,3);
				$pdf->Output($pdfFilePath, "I"); // For Show Pdf
			}
			else{
				if($type=="deli")
				{
						$fromdate=$this->input->post('fromdate');
						$todate=$this->input->post('todate');
						$rfrConStat=$this->input->post('optionsC');
						$yard_no=$this->input->post('yard_no'); 
						$data['yard_no']=$yard_no;
						//return;
						$data['fromdate']=$fromdate;
						$data['todate']=$todate;
						$data['type']=$type;
						$data['rfrConStat']=$rfrConStat;
						//echo $data['voysNo'];
						$this->load->view('myRefferImportDeliveryReportList',$data);
				}
				else{
						$fromdate=$this->input->post('fromdate');
						$todate=$this->input->post('todate');
						$type=$this->input->post('options1');
						$yard_no=$this->input->post('yard_no'); 
						$data['yard_no']=$yard_no;
						//return;
						$data['fromdate']=$fromdate;
						$data['todate']=$todate;
						$data['type']=$type;
						//echo $data['voysNo'];
						$this->load->view('myRefferImportContainerDischargeReportList',$data);
				}
				$this->load->view('myclosebar');
			}
		}
		else if(isset($_POST['submit_forwarding']))
		{
			$rptType=$this->input->post('options');
			$type=$this->input->post('options1');
			
				if($type=="deli")
					{
						$fromdate=$this->input->post('fromdate');
						$todate=$this->input->post('todate');
						
						$yard_no=$this->input->post('yard_no'); 
						$data['yard_no']=$yard_no;
							//return;
						$data['fromdate']=$fromdate;
						$data['todate']=$todate;
						$data['type']=$type;
							//echo $data['voysNo'];
						$this->load->view('myRefferImportDeliveryReportForwading',$data);
					}
		}
	}
		//EXPORT COMMODITY IN VESSES START
		
		function myExportCommodityForm(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="Export Commodity...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('myExportCommodityFormView',$data);
				$this->load->view('footer');
			}	
        }
		function myExportCommodityConversion(){
		$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
		$this->load->view('myExportCommodityConvers',$data);
		$this->load->view('myclosebar');
		}
		
		
		//EXPORT COMMODITY IN VESSES END
		//WATER SUPPLY IN VESSES START
		//REFFER CONTAINER
		function myWaterSupplyInVesselsReportForm(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="WATER SUPPLY IN VESSES...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('myWaterSupplyInVesselsReportView',$data);
				$this->load->view('footer');
			}	
        }
		function myWaterSupplyInVesselsReport(){
		$fromdate=$this->input->post('fromdate');
		$todate=$this->input->post('todate');
		$type=$this->input->post('options1');
		//return;
		$data['fromdate']=$fromdate;
		$data['todate']=$todate;
		$data['type']=$type;
		//echo $data['voysNo'];
		$this->load->view('myWaterSupplyInVesselsReportList',$data);
		$this->load->view('myclosebar');
		}
		
		//WATER SUPPLY IN VESSES END
		function berthOperatorExportContainerHandlingReport(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="BERTH OPERATOR WISE EXPORT CONTAINER...";
				$this->load->view('header2');
				$this->load->view('berthOperatorWiseExportContainer',$data);
				$this->load->view('footer');
			}	
        }
		function berthOperatorWiseExportContainerListView(){
		$fromdate=$this->input->post('fromdate');
		$todate=$this->input->post('todate');
		$data['fromdate']=$fromdate;
		$data['todate']=$todate;
		//echo $data['voysNo'];
		$this->load->view('berthOperatorWiseExportContainerReportList',$data);
		$this->load->view('myclosebar');
		
		}
		
		function myAllReportView($year,$serial,$reportNo,$type)
		{
			//echo $year."/".$serial."-".$reportCat."-".$reportNo;
			$rot=$year."/".$serial;
			if($reportNo==1)
			{
				if($type=="detail")
					$this->loadedContainerListView($rot);
				else
					$this->myExportImExSummeryView($rot);
			}
			
			if($reportNo==2)
			{
				if($type=="detail")
					$this->myImportContainerDischargeReportView($rot);
				else
					$this->myImportSummeryView($rot);
			}
		}
		
				
		function dischargeListForMLO()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="Date Wise Discharge List For MLO..";
				$this->load->view('header2');
				$this->load->view('dischargeListForMLOForm',$data);
				$this->load->view('footer');
			}
		}
		
		function dischargeListForMLOreport()
		{
			$session_id = $this->session->userdata('value');
			$login_id = $this->session->userdata('login_id');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				if($this->input->post('options')!='pdf')
				{
				$type=$this->input->post('options');
				$fromDate=$this->input->post('fromDate');
				$toDate=$this->input->post('toDate');

				$str= "select sparcsn4.inv_unit.id,
				(select right(sparcsn4.ref_equip_type.nominal_length,2) from ref_equip_type 
				INNER JOIN sparcsn4.ref_equipment ON ref_equipment.eqtyp_gkey=ref_equip_type.gkey
				INNER JOIN sparcsn4.inv_unit_equip ON inv_unit_equip.eq_gkey=ref_equipment.gkey
				where sparcsn4.inv_unit_equip.unit_gkey=inv_unit.gkey
				) as size,
				(select right(sparcsn4.ref_equip_type.nominal_height,2)/10 from ref_equip_type 
				INNER JOIN sparcsn4.ref_equipment ON ref_equipment.eqtyp_gkey=ref_equip_type.gkey
				INNER JOIN sparcsn4.inv_unit_equip ON inv_unit_equip.eq_gkey=ref_equipment.gkey
				where sparcsn4.inv_unit_equip.unit_gkey=inv_unit.gkey
				) as height ,
				sparcsn4.inv_unit.freight_kind,sparcsn4.inv_unit_fcy_visit.time_in,sparcsn4.inv_unit_fcy_visit.time_out
				from sparcsn4.inv_unit
				inner join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
				inner join sparcsn4.ref_bizunit_scoped on sparcsn4.ref_bizunit_scoped.gkey= sparcsn4.inv_unit.line_op
				where DATE(time_out) BETWEEN '$fromDate' and '$toDate' and sparcsn4.ref_bizunit_scoped.id='$login_id'";
				
				$getDischargeList = $this->bm->dataSelect($str);
				//echo $getDischargeList;
				$data['type']=$type;
				$data['fromDate']=$fromDate;
				$data['toDate']=$toDate;
				$data['getList']=$getDischargeList;
				$this->load->view('dischargeListForMLOFormView',$data);
			}
			else
			{
				
				$this->load->library('m_pdf');
				$mpdf->use_kwt = true;
				$fromDate=$this->input->post('fromDate');
				$toDate=$this->input->post('toDate');

				$this->data['fromDate']=$fromDate;
				$this->data['toDate']=$toDate; 
				$str = "select sparcsn4.inv_unit.id,
				(select right(sparcsn4.ref_equip_type.nominal_length,2) from ref_equip_type 
				INNER JOIN sparcsn4.ref_equipment ON ref_equipment.eqtyp_gkey=ref_equip_type.gkey
				INNER JOIN sparcsn4.inv_unit_equip ON inv_unit_equip.eq_gkey=ref_equipment.gkey
				where sparcsn4.inv_unit_equip.unit_gkey=inv_unit.gkey
				) as size,
				(select right(sparcsn4.ref_equip_type.nominal_height,2)/10 from ref_equip_type 
				INNER JOIN sparcsn4.ref_equipment ON ref_equipment.eqtyp_gkey=ref_equip_type.gkey
				INNER JOIN sparcsn4.inv_unit_equip ON inv_unit_equip.eq_gkey=ref_equipment.gkey
				where sparcsn4.inv_unit_equip.unit_gkey=inv_unit.gkey
				) as height ,
				sparcsn4.inv_unit.freight_kind,sparcsn4.inv_unit_fcy_visit.time_in,sparcsn4.inv_unit_fcy_visit.time_out
				from sparcsn4.inv_unit
				inner join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
				inner join sparcsn4.ref_bizunit_scoped on sparcsn4.ref_bizunit_scoped.gkey= sparcsn4.inv_unit.line_op
				where DATE(time_out) BETWEEN '$fromDate' and '$toDate' and sparcsn4.ref_bizunit_scoped.id='$login_id'";
				
				//echo $str;
				//return;
				$getDischargeList = $this->bm->dataSelect($str);
				$this->data['getList']=$getDischargeList;
				$html=$this->load->view('dischargeListForMLOFormViewPDF',$this->data, true); 
				$pdfFilePath ="EmtyContainerFoundListPDF-".time()."-download.pdf";

				   //actually, you can pass mPDF parameter on this load() function
				$pdf = $this->m_pdf->load();
				$pdf->SetWatermarkText('CPA CTMS');
				$pdf->showWatermarkText = true;	
				//$stylesheet = file_get_contents('resources/styles/test.css'); // external css
				$pdf->setFooter('Developed By : DataSoft|Page {PAGENO}|Date {DATE j-m-Y}');
			//	$pdf->WriteHTML($stylesheet,1);
				$pdf->WriteHTML($html,2);
				$pdf->Output($pdfFilePath, "I"); // For Show Pdf	
			    }
		    }
		
		}
	//Three form start	
			
	function assignmentAllReportForm()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$data['title']="YARD WISE PROPOSED EMPTY AND EMPTY CONTAINER REPORT...";
			//echo $data['title'];
			$this->load->view('header5');
			$this->load->view('assignmentAllReportForm',$data);
			$this->load->view('footer_1');
		}
	}
		
		
	function assignmentAllReportFormView()
	{
		if($this->input->post('submit')=="2")
		{
			$type=$this->input->post('options1');
			$fileType=$this->input->post('fileOptions');
			   
			if($type=="assign1" && $fileType!="pdf" )
			{  
				$fromdate=$this->input->post('fromdate1');
				$yard_no=$this->input->post('yard_no1'); 
				$data['fromdate']=$fromdate;
				$data['yard_no']=$yard_no;
				$data['type']=$type;
				$this->load->view('myReportEmtyContainerFoundListAssignment',$data);
			} 
			   
			else if($type=="assign1" && $fileType=="pdf")
			{  
				$this->load->library('m_pdf');
				$mpdf->use_kwt = true;
					
				$this->data['fromdate']=$this->input->post('fromdate1');
				$this->data['yard_no']=$this->input->post('yard_no1');

				$html=$this->load->view('myReportEmtyContainerFoundListPDF',$this->data, true); 
				$pdfFilePath ="EmtyContainerFoundListPDF-".time()."-download.pdf";

				//actually, you can pass mPDF parameter on this load() function
				$pdf = $this->m_pdf->load();
				$pdf->SetWatermarkText('CPA CTMS');
				$pdf->showWatermarkText = true;		
				//$stylesheet = file_get_contents('resources/styles/test.css'); // external css
				$pdf->setFooter('Developed By : DataSoft|Page {PAGENO}|Date {DATE j-m-Y}');
				$pdf->WriteHTML($html,2);
				$pdf->Output($pdfFilePath, "I"); // For Show Pdf					
			}
			   
			else if($type=="cont1")
			{
				$container=$this->input->post('container1');
				$data['container']=$container;
				$data['type']=$type;
				$this->load->view('myReportEmtyOneContainerFound',$data);
			}
			else if($type=="deli1" && $fileType=="pdf" )
			{
				$this->load->library('m_pdf');
				$mpdf->use_kwt = true;
				
				$this->data['fromdate']=$this->input->post('fromdate1');
				$this->data['todate']=$this->input->post('todate1');
				$this->data['yard_no']=$this->input->post('yard_no1'); 
				
				$html=$this->load->view('myReportDeliverContainerFoundListPDF',$this->data, true); 
				$pdfFilePath ="EmtyContainerFoundListPDF-".time()."-download.pdf";

				//actually, you can pass mPDF parameter on this load() function
				$pdf = $this->m_pdf->load();
				$pdf->SetWatermarkText('CPA CTMS');
				$pdf->showWatermarkText = true;		
				//$stylesheet = file_get_contents('resources/styles/test.css'); // external css
				$pdf->setFooter('Developed By : DataSoft|Page {PAGENO}|Date {DATE j-m-Y}');
				$pdf->WriteHTML($html,2);
				$pdf->Output($pdfFilePath, "I"); // For Show Pdf	
			}
			else
			{
				$fromdate=$this->input->post('fromdate1');
				$todate=$this->input->post('todate1');
				$yard_no=$this->input->post('yard_no1'); 
				
				$data['yard_no']=$yard_no;
				$data['fromdate']=$fromdate;
				$data['todate']=$todate;
				$data['type']=$type;
				$this->load->view('myReportEmtyContainerFoundList',$data);
			}
		}
		else if($this->input->post('submit')=="1")
		{
			$type=$this->input->post('options1');
			//return;
			//$data['voysNo']=$getVoyNo;
			if($type=="assign")
			{  
				$fromdate=$this->input->post('fromdate');
				$yard_no=$this->input->post('yard_no'); 
				$block=$this->input->post('block'); 
				
				$data['fromdate']=$fromdate;
				$data['yard_no']=$yard_no;
				$data['block']=$block;
				
				$data['type']=$type;
				$this->load->view('yardWiseEmtyContainerReportView',$data);
			}
			elseif($type=="cont")
			{
				$container=$this->input->post('container');
				$data['container']=$container;
				$data['type']=$type;
				$this->load->view('myReportEmtyOneContainerFound',$data);
			}
			else
			{
				$fromdate=$this->input->post('fromdate');
				$todate=$this->input->post('todate');
				$yard_no=$this->input->post('yard_no'); 
				$block=$this->input->post('block'); 
				
				$data['yard_no']=$yard_no;
				$data['block']=$block;			
				$data['fromdate']=$fromdate;
				$data['todate']=$todate;
				$data['type']=$type;

				$this->load->view('yardWiseEmtyContainerFoundListView',$data);
			}
		}
		else
		{
			$type=$this->input->post('options3');
			//echo $type;
			$fromdate=$this->input->post('fromdate3');
			$yard=$this->input->post('yard3'); 
			$data['fromdate']=$fromdate;
			$data['yard_no']=$yard;
			$data['type']=$type;
			$this->load->view('myReportAssingmentAndEmtyContainerReport',$data);
			$this->load->view('myclosebar');
		} 
	}
	
		 public function appraiseReSlotLocList()
		{
			//$ddl_imp_rot_no=$this->input->post('fromdate');
			//$this->load->model('ci_auth', 'bm', TRUE);
			//$getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
			//$data['voysNo']=$getVoyNo;
			
			$fromDt = $this->input->post('fromdate');
			//$toDt = $this->input->post('todate');
			$fromTime = $this->input->post('fromTime');
			$toTime = $this->input->post('toTime');
			$contList = $this->input->post('contList');
			
			$search_format = $this->input->post('options');
					
			if($search_format=="xl" or $search_format=="html")
			{
				$search_value=$this->input->post('search_by');
				//$data['title']="DISCHARGE CONTAINER FOR THE YARD ".$search_value;
				//$data['yard']=$search_value;
				$data['fromDt']=$fromDt;
				//$data['toDt']=$toDt;
				$data['fromTime']=$fromTime;
				$data['toTime']=$toTime;
				$data['contList']=$contList;
				//$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
				$this->load->view('appraiseReSlotLocList',$data);
				$this->load->view('myclosebar');
			}
			else{
				//load mPDF library
				$this->load->library('m_pdf');
				$pdf->use_kwt = true;
				//$this->data['search_by']=$search_by;
				$this->data['fromDt']=$fromDt;
				//$this->data['toDt']=$toDt;
				$this->data['fromTime']=$fromTime;
				$this->data['toTime']=$toTime;
				$this->data['contList']=$contList;
				$html=$this->load->view('appraiseReSlotLocList',$this->data, true);
				//this the the PDF filename that user will get to download
				$pdfFilePath ="appraiseReSlotLocList-".time()."-download.pdf";
				$pdf = $this->m_pdf->load();
				$pdf->SetWatermarkText('CPA CTMS');
				$pdf->showWatermarkText = true;	
				$stylesheet = file_get_contents('resources/styles/test.css'); // external css
				$pdf->useSubstitutions = true; // optional - just as an example
				//$pdf->SetHeader($url . "\n\n" . 'Date {DATE j-m-Y}');  // optional - just as an example
				//echo "SheetAdd : ".$stylesheet;
				$pdf->setFooter('Developed By : DataSoft|Page {PAGENO} of {nb}|Date {DATE j-m-Y}');
				//$footerHtml='<pagefooter name="MyFooter1" content-left="{DATE j-m-Y}" content-center="{PAGENO}/{nbpg}" content-right="My document" footer-style="font-family: serif; font-size: 8pt; font-weight: bold; font-style: italic; color: #000000;" />';
				$pdf->WriteHTML($stylesheet,1);
				$pdf->WriteHTML($html,2);
				$pdf->Output($pdfFilePath, "I"); // For Show Pdf
					//load mPDF library
				
				}
			
		}

		 
		//three form end
		//Shift wise container report
  
    function shiftWiseContainerReport()
	{
		if($this->uri->segment(3)=="A")
			{

				$yard_no=$this->uri->segment(4);
				$fromdate=$this->uri->segment(5);
				
				$data['fromdate']=$fromdate;
				$data['yard_no']=$yard_no;
				$data['shift']="Shift A";
				//$data['type']=$type;
				$this->load->view('shiftWiseContainerReportView',$data);					
			}
		else if($this->uri->segment(3)=="B")
			{
				$yard_no=$this->uri->segment(4);
				$fromdate=$this->uri->segment(5);
				
				$data['fromdate']=$fromdate;
				$data['yard_no']=$yard_no;
				$data['shift']="Shift B";
				//$data['type']=$type;
				$this->load->view('shiftWiseContainerReportView',$data);					
			}
		else if($this->uri->segment(3)=="C")
			{
				$yard_no=$this->uri->segment(4);
				$fromdate=$this->uri->segment(5);
				
				$data['fromdate']=$fromdate;
				$data['yard_no']=$yard_no;
				$data['shift']="Shift C";
				//$data['type']=$type;
				$this->load->view('shiftWiseContainerReportView',$data);					
			}
		else if($this->uri->segment(3)=="Stay")
			{
				$yard_no=$this->uri->segment(4);
				$fromdate=$this->uri->segment(5);
				
				$data['fromdate']=$fromdate;
				$data['yard_no']=$yard_no;
				//$data['shift']="Shift C";
				//$data['type']=$type;
				$this->load->view('stayContainerReportView',$data);					
			}	
		else 
			{
				$yard_no=$this->uri->segment(4);
				$fromdate=$this->uri->segment(5);
				
				$data['fromdate']=$fromdate;
				$data['yard_no']=$yard_no;
				$data['shift']="N";
				//$data['type']=$type;
				$this->load->view('shiftWiseContainerReportView',$data);					
			}
				
	}
	
    function shiftYardAndBlockWiseContainerReport()
	 {
		if($this->uri->segment(3)=="A")
			{
				$yard_no=$this->uri->segment(4);
				$fromdate=$this->uri->segment(5);
				$block=$this->uri->segment(6);
				
				$data['fromdate']=$fromdate;
				$data['yard_no']=$yard_no;
				$data['block']=$block;
				$data['shift']="Shift A";
				//$data['type']=$type;
				$this->load->view('shiftYardAndBlockWiseContainerReport',$data);					
			}
		else if($this->uri->segment(3)=="B")
			{
				$yard_no=$this->uri->segment(4);
				$fromdate=$this->uri->segment(5);
				$block=$this->uri->segment(6);
				$data['fromdate']=$fromdate;
				$data['yard_no']=$yard_no;
				$data['block']=$block;
				$data['shift']="Shift B";
				//$data['type']=$type;
				$this->load->view('shiftYardAndBlockWiseContainerReport',$data);					
			}
		else if($this->uri->segment(3)=="C")
			{
				$yard_no=$this->uri->segment(4);
				$fromdate=$this->uri->segment(5);
				$block=$this->uri->segment(6);
				
				$data['fromdate']=$fromdate;
				$data['yard_no']=$yard_no;
				$data['block']=$block;
				$data['shift']="Shift C";
				//$data['type']=$type;
				$this->load->view('shiftYardAndBlockWiseContainerReport',$data);					
			}
		else if($this->uri->segment(3)=="Stay")
			{
				$yard_no=$this->uri->segment(4);
				$fromdate=$this->uri->segment(5);
				$block=$this->uri->segment(6);
				
				$data['fromdate']=$fromdate;
				$data['yard_no']=$yard_no;
				$data['block']=$block;
				//$data['shift']="Shift C";
				//$data['type']=$type;
				$this->load->view('stayYardWiseContainerReportView',$data);					
			}
		else 
			{
				$yard_no=$this->uri->segment(4);
				$fromdate=$this->uri->segment(5);
				$block=$this->uri->segment(6);
				
				$data['fromdate']=$fromdate;
				$data['yard_no']=$yard_no;
				$data['block']=$block;
				$data['shift']="N";
				//$data['type']=$type;
				$this->load->view('shiftYardAndBlockWiseContainerReport',$data);					
			}
	}
	
	
		/* Commented by Sumon
		function myRequstEmtyContainerReport(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="PROPOSED EMPTY AND EMPTY  CONTAINER REPORT...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('myRequestNotEmtyContForm',$data);
				$this->load->view('footer');
			}	
        }
		
		function myRequstforEmtyContainerReportView(){
		    //$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		   //$this->load->model('ci_auth', 'bm', TRUE);
		   //$getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
		   $type=$this->input->post('options1');
		   $fileType=$this->input->post('options');
		   //return;
		   //$data['voysNo']=$getVoyNo;
    	   if($type=="assign" && $fileType!="pdf" )
		   {  
				$fromdate=$this->input->post('fromdate');
				$yard_no=$this->input->post('yard_no'); 
				$data['fromdate']=$fromdate;
				$data['yard_no']=$yard_no;
				$data['type']=$type;
				$this->load->view('myReportEmtyContainerFoundListAssignment',$data);
		   } 
		   
		   else if($type=="assign" && $fileType=="pdf")
		   {  
	       
				$this->load->library('m_pdf');
				$mpdf->use_kwt = true;
				
				$mpdf->cacheTables = true;
				$mpdf->simpleTables=true;
				$mpdf->packTableData=true;
				$this->data['fromdate']=$this->input->post('fromdate');
				$this->data['yard_no']=$this->input->post('yard_no'); 

				$html=$this->load->view('myReportEmtyContainerFoundListPDF',$this->data, true); 
				$pdfFilePath ="EmtyContainerFoundListPDF-".time()."-download.pdf";

				   //actually, you can pass mPDF parameter on this load() function
				$pdf = $this->m_pdf->load();
					
				//$stylesheet = file_get_contents('resources/styles/test.css'); // external css
				$pdf->setFooter('Developed By : DataSoft|Page {PAGENO}|Date {DATE j-m-Y}');
				$pdf->WriteHTML($html,2);
				$pdf->Output($pdfFilePath, "I"); // For Show Pdf					
		   }
		   
		   elseif($type=="cont")
		   {
				$container=$this->input->post('container');
				$data['container']=$container;
				$data['type']=$type;
				$this->load->view('myReportEmtyOneContainerFound',$data);
		   }
		   elseif($type=="deli" && $fileType=="pdf" )
		   {
			   	$this->data['fromdate']=$this->input->post('fromdate');
				$this->data['todate']=$this->input->post('todate');
				$this->data['yard_no']=$this->input->post('yard_no'); 
				$this->data['type']=$type;
				
				$this->load->library('m_pdf');
				$mpdf->use_kwt = true;

				$mpdf->cacheTables = true;
				$mpdf->simpleTables=true;
				$mpdf->packTableData=true;
				$html=$this->load->view('myReportDeliverContainerFoundListPDF',$this->data, true); 
				$pdfFilePath ="EmtyContainerFoundListPDF-".time()."-download.pdf";

				   //actually, you can pass mPDF parameter on this load() function
				$pdf = $this->m_pdf->load();
					
				//$stylesheet = file_get_contents('resources/styles/test.css'); // external css
				$pdf->setFooter('Developed By : DataSoft|Page {PAGENO}|Date {DATE j-m-Y}');
				$pdf->WriteHTML($html,2);
				$pdf->Output($pdfFilePath, "I"); // For Show Pdf	
		   }
		   else
		   {
			
				$fromdate=$this->input->post('fromdate');
				$todate=$this->input->post('todate');
				$yard_no=$this->input->post('yard_no'); 
				$data['yard_no']=$yard_no;
				$data['fromdate']=$fromdate;
				$data['todate']=$todate;
				$data['type']=$type;
				$this->load->view('myReportEmtyContainerFoundList',$data);
		   }
		   
				$this->load->view('myclosebar');
        }
  
  */
      function blockWiseRotation()
		{
			$session_id = $this->session->userdata('value');
				if($session_id!=$this->session->userdata('session_id'))
				{
					$this->logout();
				}
				else
				{
					$data['title']="IMPORT DISCHARGE REPORT";
					$this->load->view('header2');
					$this->load->view('blockWiseRotation',$data);
					$this->load->view('footer');
				}
		}

		
       function blockWiseRotationView()
		{
			$session_id = $this->session->userdata('value');
			$login_id = $this->session->userdata('login_id');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$rotNo=$this->input->post('rotNo');
				$block=$this->input->post('block');
				$search_format = $this->input->post('options');
				// N4 Total Container By Rotation..
				$strN4="SELECT count(inv_unit.id) as rtnValue  
						FROM sparcsn4.inv_unit INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
						INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
						INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
						WHERE sparcsn4.vsl_vessel_visit_details.ib_vyg='$rotNo'";
				$getTotal = $this->bm->dataReturn($strN4);		
				
				
				//ctmsmis discharge total...
				
				//$str1="select count(cont_id) as rtnValue from ctmsmis.mis_exp_unit where rotation='$rotNo' and snx_type='2' order by last_update asc";
				$getVvdQry="select vvd_gkey as rtnValue from sparcsn4.vsl_vessel_visit_details where ib_vyg='$rotNo'";
				$vvdGkey = $this->bm->dataReturn($getVvdQry);	
				//$vvdGkey=$row->vvd_gkey;
				
				$str1="SELECT count(ctmsmis.mis_inv_unit.id) as rtnValue					
					FROM  ctmsmis.mis_inv_unit 
					WHERE mis_inv_unit.vvd_gkey='$vvdGkey' AND category='IMPRT' AND fcy_time_in IS NOT NULL
					order by id asc";
				$dischargeTotal = $this->bm->dataReturn($str1);
				
                if($block=="" or $block==null)
				{
				    $str= "select cont_id, cont_status, cont_size, cont_height, last_update, current_position, user_id
                          from ctmsmis.mis_exp_unit where rotation='$rotNo' and snx_type='2' order by current_position,last_update asc";
				    $data['flag']=0;  
				    $this->data['flag']=0;  
				}
				
				else
				{
					$str= "select id,size,height,freight_kind,mlo,mlo_name,current_position,pod,seal_no,mis_exp_unit.goods_and_ctr_wt_kg as goods_and_ctr_wt_kg,
							truck_no,craine_id,ctmsmis.mis_exp_unit.user_id,mis_exp_unit.last_update 
							from ctmsmis.mis_exp_unit 
							inner join ctmsmis.mis_inv_unit on mis_inv_unit.gkey=mis_exp_unit.gkey 
							where ctmsmis.mis_exp_unit.rotation='$rotNo' and ctmsmis.mis_exp_unit.snx_type='2' and ctmsmis.mis_exp_unit.current_position='$block' 
							order by mlo,ctmsmis.mis_exp_unit.last_update asc";
					//echo $str;
					$data['flag']=1;	 					
					$this->data['flag']=1;	 					
				}
				
				$getList = $this->bm->dataSelect($str);
				
				if($search_format=="xl" or $search_format=="html")
				{
					$data['dischargeTotal']=$dischargeTotal;
					$data['getTotal']=$getTotal;
					$data['rotNo']=$rotNo;
					$data['block']=$block;				
					$data['getList']=$getList;
					$data['rotation']=$rotNo;
					$this->load->view('blockWiseRotationView',$data);
				}
				else
				{
						//load mPDF library
					$this->load->library('m_pdf');
					$pdf->use_kwt = true;
					$this->data['dischargeTotal']=$dischargeTotal;
					$this->data['getTotal']=$getTotal;
					$this->data['rotNo']=$rotNo;
					$this->data['block']=$block;				
					$this->data['getList']=$getList;
					$this->data['rotation']=$rotNo;
					//$this->data['title']="Container Operation Report";
					$html=$this->load->view('blockWiseRotationView',$this->data, true);
					//this the the PDF filename that user will get to download
					$pdfFilePath ="ImportDischargeReport-".time()."-download.pdf";
					$pdf = $this->m_pdf->load();
					$pdf->SetWatermarkText('CPA CTMS');
					$pdf->showWatermarkText = true;	
					$stylesheet = file_get_contents('resources/styles/test.css'); // external css
					$pdf->useSubstitutions = true; // optional - just as an example
					//$pdf->SetHeader($url . "\n\n" . 'Date {DATE j-m-Y}');  // optional - just as an example
					//echo "SheetAdd : ".$stylesheet;
					$pdf->setFooter('Developed By : DataSoft|Page {PAGENO} of {nb}|Date {DATE j-m-Y}');
					//$footerHtml='<pagefooter name="MyFooter1" content-left="{DATE j-m-Y}" content-center="{PAGENO}/{nbpg}" content-right="My document" footer-style="font-family: serif; font-size: 8pt; font-weight: bold; font-style: italic; color: #000000;" />';
					$pdf->WriteHTML($stylesheet,1);
					$pdf->WriteHTML($html,2);
					$pdf->Output($pdfFilePath, "I"); // For Show Pdf
				}
			}
			/*$session_id = $this->session->userdata('value');
			$login_id = $this->session->userdata('login_id');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$rotNo=$this->input->post('rotNo');
				$block=$this->input->post('block');
				
				// N4 Total Container By Rotation..
				$strN4="SELECT count(inv_unit.id) as rtnValue  
						FROM sparcsn4.inv_unit INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
						INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
						INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
						WHERE sparcsn4.vsl_vessel_visit_details.ib_vyg='$rotNo'";
				$getTotal = $this->bm->dataReturn($strN4);		
				
				
				//ctmsmis discharge total...
				
				$str1="select count(cont_id) as rtnValue from ctmsmis.mis_exp_unit where rotation='$rotNo' and snx_type='2' order by last_update asc";
				$dischargeTotal = $this->bm->dataReturn($str1);
				
                if($block=="" or $block==null)
				{
				    $str= "select cont_id, cont_status, cont_size, cont_height, last_update, current_position, user_id
                          from ctmsmis.mis_exp_unit where rotation='$rotNo' and snx_type='2' order by current_position,last_update asc";
				    $data['flag']=0;  
				}
				
				else
				{
					$str= "select cont_id, cont_status, cont_size, cont_height, last_update, current_position, user_id,mlo,mlo_name
                           from ctmsmis.mis_exp_unit where rotation='$rotNo' and snx_type='2' and current_position='$block' order by last_update asc";
					$data['flag']=1;	 					
				}
				
				$getList = $this->bm->dataSelect($str);
				
				$data['dischargeTotal']=$dischargeTotal;
				$data['getTotal']=$getTotal;
				$data['rotNo']=$rotNo;
				$data['block']=$block;				
				$data['getList']=$getList;
				$data['rotation']=$rotNo;
				$this->load->view('blockWiseRotationView',$data);
			}
		*/
		}	
	
			
    	function pendingEmptyContinerReport()
		{
			$fromdate=$this->input->post('fromdate');
			$yard_no=$this->input->post('yard_no'); 
			$data['fromdate']=$fromdate;
			$data['yard_no']="ALL";
			//$data['type']=$type;
			$this->load->view('pendingEmptyContinerReportView',$data);
			
		}
		
		
		function monthlyYardWiseContainerHandling()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="Yard Wise Total Container Handling..";
				$this->load->view('header2');
				$this->load->view('monthlyYardWiseContainerHandling',$data);
				$this->load->view('footer');
			}
		}
		
		
		
	function monthlyYardWiseContainerHandlingView()
		{
			$session_id = $this->session->userdata('value');
			$login_id = $this->session->userdata('login_id');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$fromDate=$this->input->post('fromDate');
				$toDate=$this->input->post('toDate');

				$str= "SELECT berth,SUM(imp20) AS imp20,SUM(imp40) AS imp40,(SUM(imp20)+SUM(imp40)*2) AS impteus,SUM(exp20) AS exp20,SUM(exp40) AS exp40,(SUM(exp20)+SUM(exp40)*2) AS expteus
						FROM (
						SELECT sparcsn4.inv_unit.id,sparcsn4.vsl_vessel_visit_details.ib_vyg,LEFT(sparcsn4.argo_quay.id,3) AS berth,
						(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2)=20 THEN 1 ELSE 0 END)  AS imp20,
						(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2)!=20 THEN 1 ELSE 0 END)  AS imp40,
						0 AS exp20,0 AS exp40
						FROM sparcsn4.inv_unit
						INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
						INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
						INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
						INNER JOIN sparcsn4.vsl_vessel_berthings ON sparcsn4.vsl_vessel_berthings.vvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
						INNER JOIN sparcsn4.argo_quay ON sparcsn4.argo_quay.gkey=sparcsn4.vsl_vessel_berthings.quay
						INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
						INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
						INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
						WHERE DATE(sparcsn4.argo_carrier_visit.ata) BETWEEN '$fromDate' AND '$toDate'

						UNION ALL

						SELECT sparcsn4.inv_unit.id,sparcsn4.vsl_vessel_visit_details.ib_vyg,LEFT(sparcsn4.argo_quay.id,3) AS berth,
						0 AS imp20, 0 AS imp40,
						(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2)=20 THEN 1 ELSE 0 END)  AS exp20,
						(CASE WHEN RIGHT(sparcsn4.ref_equip_type.nominal_length,2)!=20 THEN 1 ELSE 0 END)  AS exp40
						FROM sparcsn4.inv_unit
						INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
						INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ob_cv
						INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
						INNER JOIN sparcsn4.vsl_vessel_berthings ON sparcsn4.vsl_vessel_berthings.vvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
						INNER JOIN sparcsn4.argo_quay ON sparcsn4.argo_quay.gkey=sparcsn4.vsl_vessel_berthings.quay
						INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey
						INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
						INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
						WHERE DATE(sparcsn4.argo_carrier_visit.ata) BETWEEN '$fromDate' AND '$toDate' AND sparcsn4.inv_unit_fcy_visit.transit_state !='S20_INBOUND'
						) AS imptbl GROUP BY berth";
						//echo $fromDate."".$toDate."".$str;
				//return;
				$getDetails = $this->bm->dataSelect($str);
				$data['fromDate']=$fromDate;
				$data['toDate']=$toDate;
				$data['login']=$login_id;				
				$data['getDetails']=$getDetails;
				$this->load->view('monthlyYardWiseContainerHandlingView',$data);
			}

		}
	
  
	/*Commented by Sumon Roy	//Yard wise assignment / delivery empty details 
		 function yardWiseEmtyContainerReport()
		{
		    $session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="YARD WISE PROPOSED EMPTY AND EMPTY  CONTAINER REPORT...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('yardWiseEmtyContainerReportForm',$data);
				$this->load->view('footer');
			}	
        }
		
			
		
	 function yardWiseEmtyContainerReportView()
		{
		   //$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		   //$this->load->model('ci_auth', 'bm', TRUE);
		   //$getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
		   $type=$this->input->post('options1');
		   //return;
		   //$data['voysNo']=$getVoyNo;
		   if($type=="assign")
		   {  
			$fromdate=$this->input->post('fromdate');
			$yard_no=$this->input->post('yard_no'); 
			$block=$this->input->post('block'); 
			
			$data['fromdate']=$fromdate;
			$data['yard_no']=$yard_no;
			$data['block']=$block;
			
			$data['type']=$type;
			$this->load->view('yardWiseEmtyContainerReportView',$data);
		   }
		   elseif($type=="cont")
		   {
			$container=$this->input->post('container');
			$data['container']=$container;
			$data['type']=$type;
			$this->load->view('myReportEmtyOneContainerFound',$data);
		   }
		   else
		   {
			$fromdate=$this->input->post('fromdate');
			$todate=$this->input->post('todate');
			$yard_no=$this->input->post('yard_no'); 
			$block=$this->input->post('block'); 
			
			$data['yard_no']=$yard_no;
			$data['block']=$block;			
			$data['fromdate']=$fromdate;
			$data['todate']=$todate;
			$data['type']=$type;
			$this->load->view('yardWiseEmtyContainerFoundListView',$data);
		   }
		   
		   $this->load->view('myclosebar');
  
		}
		
  */
  
    function stripping()
		{
			$fromdate=$this->input->post('fromdate');
			$data['fromdate']=$fromdate;
			$this->load->view('myStripped',$data);
			
		}
	function strippingPreparation()
		{
			$fromdate=$this->input->post('fromdate');
			//echo $fromdate;
			//return;
			$data['fromdate']=$fromdate;
			
			$this->load->view('myStrippedPreparation',$data);
		}
		
  //start
  /* Commented by Sumon Roy
  function myRequstAssignmentEmtyContainerReport(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="ASSAIGNMENT/DELIVERY EMPTY SUMMARY REPORT...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('myAssignmentAndNotEmtyContForm',$data);
				$this->load->view('footer');
			}	
        }
		
		function myReportAssignmentAndEmtyContainerReportView(){
		   $type=$this->input->post('options1');
			$fromdate=$this->input->post('fromdate');
			$yard=$this->input->post('yard'); 
			$data['fromdate']=$fromdate;
			$data['yard']=$yard;
			$data['type']=$type;
			$this->load->view('myReportAssingmentAndEmtyContainerReport',$data);
		   $this->load->view('myclosebar');
  
        }
  */

		//end
		//End Export Container Loading report for Export loading apps
		//cont history
		function myContainerHistoryReportForm(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="CONTAINER HISTORY REPORT...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('myContainerHistoryReportViewForm',$data);
				$this->load->view('footer');
			}	
        }
		function myContainerHistoryReport(){
		$container_no=$this->input->post('container_no');
		$data['container_no']=$container_no;
		$this->load->view('myContainerHistoryReportList',$data);
		$this->load->view('myclosebar');
		}
		//cont history
		
		
		//Igm Report GM HTML
		function myIGMReport(){
			//print_r($this->session->all_userdata());
			
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$data['title']="IGM REPORTS...";
				$this->load->view('header2');
				$this->load->view('myReportIGMHTML',$data);
				$this->load->view('footer');
			}	
        }
		
		//Igm Report GM HTML
		function excelFormatForEdiConverter(){
			//print_r($this->session->all_userdata());
			
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				//$data['title']="IGM REPORTS...";
				//$this->load->view('header2');
				$this->load->view('excelFormatForEdiConverter',$data);
				//$this->load->view('myviewEDIDetailsList2',$data);
				//$this->load->view('footer');
			}	
        }
		
		
		
		//Igm Report GM view
		function myIGMReportView(){
		$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
				$this->load->view('myReportIGMtList');
				$this->load->view('myclosebar');
			}
		}
		
		//Igm Report BB HTML
		function myIGMBBReport(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();

			}
			else
			{
				$data['title']="IGM BREAK BULKS REPORTS...";
				$this->load->view('header2');
				$this->load->view('myReportIGMBBHTML',$data);
				$this->load->view('footer');
			}
				
        }
		//Igm Report BB view
		function myIGMBBReportView(){
		
		$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
				$this->load->view('myReportIGMtList');
				$this->load->view('myclosebar');
			}
		}
		
		//Supplementary Igm Report  HTML
		function myIGMFFReport(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				//$this->load->view('header');
				//$this->load->view('welcomeview_1', $data);
				//$this->load->view('footer');
			}
			else
			{
				$data['title']="IGM SUPLEMENTARY REPORTS...";
				$this->load->view('header2');
				$this->load->view('myReportIgmSupplementaryHTML',$data);
				$this->load->view('footer');
			}	
        }
		//Supplementary Igm Report  view
		function myIGMFFReportView(){
		$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
				$this->load->view('myReportIGMSuplementarytList');
				$this->load->view('myclosebar');
			}
		}
		
		
		//COntainer Summery View HTML
		function ImportContainerSummery(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				//$this->load->view('header');
				//$this->load->view('welcomeview_1', $data);
				//$this->load->view('footer');
			}
			else
			{
				$data['title']="SUMMARY OF IMPORT CONTAINER...";
				$this->load->view('header2');
				$this->load->view('myReportFeederDischargeHTML22',$data);
				$this->load->view('footer');
			}
        }	
		//Container Summery Report
		function ImportContainerSummeryView(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				if($this->input->post())
					{
						$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
					}
					else if($this->uri->segment(3))
					{
						$ddl_imp_rot_no=str_replace("_","/",$this->uri->segment(3));
					}
					$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
				//$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
				$this->load->view('myReportDischargeSummeryList22',$data);
				$this->load->view('myclosebar');
			}
        }
		// Mlo Discharge Summery List HMLT
		function mloDischargeSummery(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				//$this->load->view('header');
				//$this->load->view('welcomeview_1', $data);
				//$this->load->view('footer');
			}
			else
			{
				$data['title']="MLO DISCHARGE SUMMARY LIST...";
				$this->load->view('header2');
				$this->load->view('myReportMloDischargeHTML',$data);
				$this->load->view('footer');
			}
		}
		// Mlo Discharge Summery List report
		function mloDischargeSummeryView(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
				$this->load->view('myReportMloDischargeList');
				$this->load->view('myclosebar');
			}
        }	
		//Discharge Summery List HMLT
		function myDischargeList(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				//$this->load->view('header');
				//$this->load->view('welcomeview_1', $data);
				//$this->load->view('footer');
			}
			else
			{
				$data['title']="DISCHARGE LIST...";
				$this->load->view('header2');
				$this->load->view('myReportDischargeHTML',$data);
				$this->load->view('footer');
			}
		}
		// Mlo Discharge Summery List report
		function myDischargeListView(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
				$this->load->view('myReportDischargeList');
				$this->load->view('myclosebar');
			}
        }	
		
		// FCL Manifest HMLT
		function myFCLManifest(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				//$this->load->view('header');
				//$this->load->view('welcomeview_1', $data);
				//$this->load->view('footer');
			}
			else
			{
				$data['title']="FCL MANIFEST...";
				$this->load->view('header2');
				$this->load->view('myReportFCLMenifestHTML',$data);
				$this->load->view('footer');
			}
		}
		// FCL Manifet report
		function myFCLManifestView(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
				$this->load->view('myReportFCLMenifestList');
				$this->load->view('myclosebar');
			}
        }	
		
		// LCL Manifest HMLT
		function myLCLManifest(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				//$this->load->view('header');
				//$this->load->view('welcomeview_1', $data);
				//$this->load->view('footer');
			}
			else
			{
				$data['title']="LCL MANIFEST...";
				$this->load->view('header2');
				$this->load->view('myReportLCLMenifestHTML',$data);
				$this->load->view('footer');
			}
		}
		// LCL Manifet report
		function myLCLManifestView(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
				$this->load->view('myReportLCLMenifestList');
				$this->load->view('myclosebar');
			}
        }	
		
		// DG Manifest HTML
		function myDGManifest(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				//$this->load->view('header');
				//$this->load->view('welcomeview_1', $data);
				//$this->load->view('footer');
			}
			else
			{
				$data['title']="DG MANIFEST...";
				$this->load->view('header2');
				$this->load->view('myReportDGMenifestHTML',$data);
				$this->load->view('footer');
			}
		}
		// DG Manifet report
		function myDGManifestView(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
				$this->load->view('myReportDGMenifestList');
				$this->load->view('myclosebar');
			}
        }	
		
		// ICD Manifest HTML
		function myICDManifest(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				//$this->load->view('header');
				//$this->load->view('welcomeview_1', $data);
				//$this->load->view('footer');
			}
			else
			{
				$data['title']="ICD MANIFEST...";
				$this->load->view('header2');
				$this->load->view('myReportICDMenifestHTML',$data);
				$this->load->view('footer');
			}
		}
		// ICD Manifet report
		function myICDManifestView(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
				$this->load->view('myReportICDMenifestList');
				$this->load->view('myclosebar');
			}
        }	
		
		// Bearth Operator report HMLT
		function myBirthIGMList(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				//$this->load->view('header');
				//$this->load->view('welcomeview_1', $data);
				//$this->load->view('footer');
			}
			else
			{
				$data['title']="BERTH OPERATOR REPORT...";
				$this->load->view('header2');
				$this->load->view('myBirthIGMListHTML',$data);
				$this->load->view('footer');
			}
		}
		// Bearth Operator Report List 
		function myBirthIGMListView(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
				$this->load->view('myReportBerthOperator');
				$this->load->view('myclosebar');
			}
        }
		
		// Bearth Operator Report List 
		function mySearchContainerLocation(){
			//print_r($this->session->all_userdata());
				
				$cont_id=$this->input->post('containerLocation');
				//echo $cont_id;
				$this->load->view('mySearchContainerLocationHTMl');
				//$this->load->view('myclosebar');
			
        }	
		
		//Delivery Order Report
		function viewDeliveryOrder($bl,$rot){
		$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				if($rot==""){
					$bl = $this->uri->segment(3);
					$rot = $this->uri->segment(4);
				}
				
				//echo $rot."=".$bl;
				$data['rotation']=str_replace("_","/",$rot);
				$data['bl']=$bl;
				$this->load->model('ci_auth', 'bm', TRUE);
				$DeliveryList = $this->bm->viewDeliveryOrder($rot,$bl);
				$data['DeliveryList']=$DeliveryList;
				$this->load->view('DeliveryOrderReport',$data);
			}
		}
		//Delivery Order Report
		function releaseDeliveryOrder(){
		$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$rot=$this->input->post('rotation');
				$bl=$this->input->post('bl');
				$igm_detail_id=$this->input->post('igm_detail_id');
				
				
				$this->load->model('ci_auth', 'bm', TRUE);
				$DeliveryList = $this->bm->releaseDeliveryOrder($rot,$bl,$igm_detail_id);
				$data['DeliveryList']=$DeliveryList;
				
				
				$this->viewDeliveryOrder($bl,$rot);
			}
		}
		//Delivery Order Report
		function DeliveryOrderPortComment(){
		$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$rot=$this->input->post('rotation');
				$bl=$this->input->post('bl');
				$igm_detail_id=$this->input->post('igm_detail_id');
				$port_comment=$this->input->post('port_comment');
				$port_comment=str_replace("'","",$port_comment);
				$port_comment=str_replace('"','',$port_comment);
				
				
				$this->load->model('ci_auth', 'bm', TRUE);
				$DeliveryList = $this->bm->DeliveryOrderPortComment($rot,$bl,$igm_detail_id,$port_comment);
				$data['DeliveryList']=$DeliveryList;
				
				
				$this->viewDeliveryOrder($bl,$rot);
			}
		}
		//last 24 hours
		function myImportContainerDischargeReportlast24hours(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="IMPORT CONTAINER DISCHARGE REPORT...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('myReportImportContainerDischargingLast24Hours',$data);
				$this->load->view('footer');
			}	
        }
		function myImportContainerDischargeReportViewLast24Hours(){
		$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		$fromdate=$this->input->post('fromdate');
		$this->load->model('ci_auth', 'bm', TRUE);
		$getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
		$data['voysNo']=$getVoyNo;
		$data['fromdate']=$fromdate;
		//echo $data['voysNo'];
		$this->load->view('myReportImportContainerDischargeListLast24hours',$data);
		$this->load->view('myclosebar');
		
		}
		//last 24 hours
		//MLO WISE IMPORT SUMMARY
		
		function myImportSummery(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="IMPORT LOADED CONTAINER SUMMARY LIST...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('myReportImExSummeryImportLoading',$data);
				$this->load->view('footer');
			}	
        }
		function myImportSummeryView($rot){
		if($this->input->post())
		{
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		}
		else
		{
			$ddl_imp_rot_no=$rot;
		}
		$this->load->model('ci_auth', 'bm', TRUE);
		$getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
		$data['voysNo']=$getVoyNo;
		$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
		//echo $data['voysNo'];
		$this->load->view('myReportImportSummerytLoadingList',$data);
		$this->load->view('myclosebar');
		
		}
		//MLO WISE IMPORT SUMMARY END
		//COntainer Summery View HTML
		function IgmReportbyDescription(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				//$this->load->view('header');
				//$this->load->view('welcomeview_1', $data);
				//$this->load->view('footer');
			}
			else
			{
				$data['title']="SUMMARY OF IMPORT CONTAINER...";
				$this->load->view('header2');
				$this->load->view('myReportbyDescriptionHTML.php',$data);
				$this->load->view('footer');
			}
        }	
		//Container Summery Report
		function IgmReportbyDescriptionView(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$description=$this->input->post('description');
				$from=$this->input->post('from');
				$to=$this->input->post('to');
				$this->load->view('myReportbyDescriptionHTMLlist');
				$this->load->view('myclosebar');
			}
        }
		
		function IgmReportbyImporter(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				//$this->load->view('header');
				//$this->load->view('welcomeview_1', $data);
				//$this->load->view('footer');
			}
			else
			{
				$data['title']="SUMMARY OF IMPORT CONTAINER...";
				$this->load->view('header2');
				$this->load->view('myReportbyImporterHTML',$data);
				$this->load->view('footer');
			}
        }	
		
		
		//Container Summery Report
		function IgmReportbyImporterView(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$description=$this->input->post('description');
				$from=$this->input->post('from');
				$to=$this->input->post('to');
				$this->load->view('myReportbyImporterHTMLlist');
				$this->load->view('myclosebar');
			}
        }
		
		function IgmReportbyContainer(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				//$this->load->view('header');
				//$this->load->view('welcomeview_1', $data);
				//$this->load->view('footer');
			}
			else
			{
				$data['title']="SUMMARY OF IMPORT CONTAINER...";
				$this->load->view('header2');
				$this->load->view('myReportbyContainerHTML',$data);
				$this->load->view('footer');
			}
        }	
		
		function IgmReportbyContainerView(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$description=$this->input->post('description');
				$from=$this->input->post('from');
				$to=$this->input->post('to');
				$this->load->view('myReportbyContainerHTMLlist');
				$this->load->view('myclosebar');
			}
        }
		
		//Igm search by BL start
		
		function IgmReportbyBL(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				//$this->load->view('header');
				//$this->load->view('welcomeview_1', $data);
				//$this->load->view('footer');
			}
			else
			{
				$data['title']="SUMMARY OF IMPORT CONTAINER...";
				$this->load->view('header2');
				$this->load->view('myReportbyBLHTML',$data);
				$this->load->view('footer');
			}
        }	
		
		
		//Container Summery Report
		function IgmReportbyBLView(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$description=$this->input->post('description');
				$from=$this->input->post('from');
				$to=$this->input->post('to');
				$this->load->view('myReportbyBLHTMLlist');
				$this->load->view('myclosebar');
			}
        }
		
		// igm search by L end
		
		
		
				//shahadat
		function OffDockContainerList(){
		   //print_r($this->session->all_userdata());
		   $session_id = $this->session->userdata('value');
		   if($session_id!=$this->session->userdata('session_id'))
		   {
			$this->logout();
		   }
		   else
		   {
			$data['title']="OFFDOCK DESTINATION WISE CONTAINER LIST...";
			$this->load->view('header2');
			$this->load->view('myOffDockContainerListHTML',$data);
			$this->load->view('footer');
		   } 
		}
		  function OffDockContainerListView(){
		  $ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		  $this->load->view('myReportOffDockContainerList',$data);
		  $this->load->view('myclosebar');
		  
		  }
		  //shahadat									
		
		function depotLadenContListView()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				
				$depo = $this->uri->segment(3);
				$size = $this->uri->segment(4);
				$data['depo']=$depo;
				$data['size']=$size;
				//$this->load->view('header2');
				$this->load->view('depotLadenContListHTML',$data);
				//$this->load->view('footer');
			}
		}
		
		function depotLadenContForm()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
				$data['title']="DEPOT LADEN CONTAINER AT CHITTAGONG PORT";
				$this->load->view('header2');
				$this->load->view('depotLadenContForm',$data);
				$this->load->view('footer');
			}
		}
		
		function depotLadenCont()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$sValue=$this->input->post('sValue');
				$data['sValue']=$sValue;
				$data['title']="DEPOT LADEN CONTAINER AT CHITTAGONG PORT UP TO";
				//$this->load->view('header2');
				$this->load->view('depotLadenContHTML',$data);
				//$this->load->view('footer');
			}
		}
		
		
		function vesselEventHistory()
		{
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$data['title']="VESSEL EVENTS HISTORY...";
				$this->load->view('header2');
				$this->load->view('eventHistoryForm',$data);
				$this->load->view('footer');
			}
		}
		
		function eventHistoryReport()
		{
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
				$data['title']="VESSEL EVENTS HISTORY";
				$data['rotation']=$ddl_imp_rot_no;
				//$this->load->view('header2');
				$this->load->view('eventHistoryHTML',$data);
				//$this->load->view('footer');
			}
		}
		
		
	function containerEventHistory()
		{
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');			
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();				
			}
			else
			{							
				$data['tableFlag']=0;
				$data['title']="CONTAINER EVENTS HISTORY...";
				$data['expST']=$expST;
				$this->load->view('header5');
				$this->load->view('containerEventHistoryForm',$data);
				$this->load->view('footer_1');
			}
		}
		
	function containerEventHistoryReport()
		{
		    $session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$contNo=$this->input->post('contNo');
				$data['title']="CONTAINER EVENTS HISTORY";
				$data['tableFlag']=1;
				$data['tableTitle']="Event History of Container No: ".$contNo;
				
				$contHistorySql="SELECT sparcsn4.inv_unit.gkey,sparcsn4.inv_unit_fcy_visit.time_move,
				sparcsn4.inv_unit_fcy_visit.time_in,sparcsn4.inv_unit_fcy_visit.time_out,
				sparcsn4.inv_unit.category,sparcsn4.inv_unit.freight_kind,sparcsn4.inv_unit_fcy_visit.transit_state,
				sparcsn4.inv_unit_fcy_visit.last_pos_name,sparcsn4.ref_bizunit_scoped.id AS mlo
				FROM sparcsn4.inv_unit
				INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
				INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.inv_unit.line_op
				WHERE sparcsn4.inv_unit.id='$contNo' ORDER BY 2 DESC";
				
				$contHistory = $this->bm->dataSelect($contHistorySql);
				$data['contHistory']=$contHistory;
				$data['contNo']=$contNo;
				$this->load->view('header5');
				$this->load->view('containerEventHistoryForm',$data);
				$this->load->view('footer_1');
			}
		}
		
		
		
		
		
		function usrCreationForm()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$this->load->model('CI_auth', 'bm', TRUE);
				$sql = "select id,Org_Type from tbl_org_types where id in(1,2,5,6,30,57,59,4,64,66,67)";
				$orgList = $this->bm->dataSelectDb1($sql);
				$data['orgList']=$orgList;
				$msg = "";
				$data['msg']=$msg;
				$data['creation']=1;
				$data['title']="User Creation Form...";
				$this->load->view('header2');
				$this->load->view('userCreationForm',$data);
				$this->load->view('footer');
			}
		}
		
		function userCreation()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();				
			}
			else
			{
				$this->load->model('CI_auth', 'bm', TRUE);
				$orgType=$this->input->post('orgType');
				$license_no=$this->input->post('license_no');
				$orgName=$this->input->post('orgName');
				
				$sql_org_id="SELECT id as rtnValue 
				FROM organization_profiles 
				WHERE Organization_Name='$orgName' AND Org_Type_id='$orgType'";
				
				$org_id=$this->bm->dataReturnDb1($sql_org_id);
				
				$uId=trim($this->input->post('uId'));
				$uPass=$this->input->post('uPass');
				$cPass=$this->input->post('cPass');
				$pass = sha1($cPass);
				$address1=$this->input->post('address1');
				$address2=$this->input->post('address2');
				$lPhone=$this->input->post('lPhone');
				$cPhone=$this->input->post('cPhone');
				$email=$this->input->post('email');
				$userType=$this->input->post('userType');
				$section=$this->input->post('section');
				$create=$this->input->post('create');
				$imageName=$_FILES["image"]["name"];
				
				$msg = "";

				move_uploaded_file($_FILES["image"]["tmp_name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/images/".$_FILES["image"]["name"]);			
				rename($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/images/".$_FILES["image"]["name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/images/".$imageName);
				
				$sql_chk_license="SELECT COUNT(gkey) AS rtnValue FROM sparcsn4.ref_bizunit_scoped WHERE id='$license_no'";
	
				$chk_license=$this->bm->dataReturn($sql_chk_license);
			
				if($orgType=="" or $orgType==" ")
				{
					$msg = "<font color='red'><b>You should select Organization type.</b></font>";
				}
				else if($chk_license==0 and $orgType==2 and $uId!='devcf')
				{
					$msg = "<font color='red'><b>License No. is not valid</b></font>";
				}
				else if($orgName=="" or $orgName==" ")
				{
					$msg = "<font color='red'><b>Organization name should not be blank.</b></font>";
				}
				else if($uId=="" or $uId==" ")
				{
					$msg = "<font color='red'><b>User Id should not be blank.</b></font>";
				}
				else if($create!=null and $uPass==null)
				{
					$msg = "<font color='red'><b>Password should not be blank.</b></font>";
				}
				else if($create!=null and $cPass==null)
				{
					$msg = "<font color='red'><b>Confirm Password should not be blank.</b></font>";
				}
				else if($cPhone=="" or $cPhone==" ")
				{
					$msg = "<font color='red'><b>Cell Phone should not be blank.</b></font>";
				}
				else if($email=="" or $email==" ")
				{
					$msg = "<font color='red'><b>Email should not be blank.</b></font>";
				}
				else if($orgType=="5" and $section==null)
				{
					$msg = "<font color='red'><b>Section should not be blank for Port.</b></font>";
				}
				else if($userType=="organization" and $userType=="cnf" and $imageName==null)		
				{
					$msg = "<font color='red'><b>Provide a image</b></font>";
				}
				else
				{
					$sqlUser = "select count(id) as rtnValue from users where login_id='$uId'";
					$rtnValue = $this->bm->dataReturnDb1($sqlUser);
					
					if($rtnValue>0)					
					{
						if($create!=null)
						{
							$msg = "<font color='red'><b>User id $uId already exist. Try with another..</b></font>";
						}
						else
						{
							$sqlUpdate="update users set u_name='$orgName',login_id='$uId',is_admin_user=1,org_Type_id='$orgType',Address_1='$address1',Address_2='$address2',Telephone_No_Land='$lPhone',Cell_No_1='$cPhone',email='$email',image_path='$imageName',org_id='$org_id',section='$section',account_update_date=now() where login_id='$uId'";
					
							$update = $this->bm->dataUpdateDB1($sqlUpdate);
						
							if($update==1)
							{	
								$msg = "<font color='blue'><b>Successfully updated for login ID ".$uId."</b></font>";
							}
							else
							{
								$msg = "<font color='red'><b>Update failed</b></font>";
							}
						}
						
						/** uncomment the update portion in case of error in user info update **/
						//$msg = "<font color='red'><b>User id $uId already exist. Try with another..</b></font>";
						// $sqlUpdate="update users set u_name='$orgName',login_id='$uId',is_admin_user=1,org_Type_id='$orgType',Address_1='$address1',Address_2='$address2',Telephone_No_Land='$lPhone',Cell_No_1='$cPhone',email='$email',image_path='$imageName',section='$section',account_update_date=now() where login_id='$uId'";
					
						// $update = $this->bm->dataUpdateDB1($sqlUpdate);
					
						// if($update==1)
						// {	
							// $msg = "<font color='blue'><b>Successfully updated for login ID ".$uId."</b></font>";
						// }
						// else
						// {
							// $msg = "<font color='red'><b>Update failed</b></font>";
						// }
					}
					else
					{	
						if($orgType==2)
						{
							$sql_license_gkey="SELECT gkey AS rtnValue FROM sparcsn4.ref_bizunit_scoped WHERE id='$license_no'";
							
							$license_gkey=$this->bm->dataReturn($sql_license_gkey);
							
							$sqlInsert = "insert into users(u_name,login_id,login_password,is_admin_user,org_Type_id,Address_1,Address_2,Telephone_No_Land,Cell_No_1,email,image_path,org_id,entrydate,section,account_update_date,new_pass,n4_bizu_gkey) 
							values('$orgName','$uId','$pass',1,'$orgType','$address1','$address2','$lPhone','$cPhone','$email','$imageName','$org_id',now(),'$section',now(),'$pass','$license_gkey')";
						}
						else
						{
							$sqlInsert = "insert into users(u_name,login_id,login_password,is_admin_user,org_Type_id,Address_1,Address_2,Telephone_No_Land,Cell_No_1,email,image_path,org_id,entrydate,section,account_update_date,new_pass) 
							values('$orgName','$uId','$pass',1,'$orgType','$address1','$address2','$lPhone','$cPhone','$email','$imageName','$org_id',now(),'$section',now(),'$pass')";
						}	
						
						$insertStat = $this->bm->dataInsertDB1($sqlInsert);
					
						if($insertStat)
						{	
							$msg = "<font color='blue'><b>User created successfully</b></font>";
						}
						else
						{
							$msg = "<font color='red'><b>User not created</b></font>";
						}
						
					}
				}
				
				$sql = "select id,Org_Type from tbl_org_types where id in(1,5,6,30,57,64,66,67)";
				$orgList = $this->bm->dataSelectDb1($sql);
				$data['orgList']=$orgList;
				$data['msg']=$msg;
				$data['creation']=1;
				$data['title']="User Creation Form...";
				$this->load->view('header2');
				$this->load->view('userCreationForm',$data);
				$this->load->view('footer');
			}
		}
		
		//vessel layout
		function vslLayout(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$data['title']="New Vessel Layout...";
				$this->load->view('header2');
				$this->load->view('bayViewForm',$data);
				$this->load->view('footer');
			}
        }
		
		function blankBayView(){
			$this->load->view('blankBayView');
		 }
		
		
		function getVslLayout(){
			$this->load->view('getVslInfo');
       }
	   
	   function blankBayForm(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$data['title']="Blank Vessel Layout...";
				$this->load->view('header2');
				$this->load->view('blankBayForm',$data);
				$this->load->view('footer');
			}
        }
		
		function deleteWrongBay(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$data['title']="DELETE WRONG BAY...";
				$data['msg']="";
				$this->load->view('header2');
				$this->load->view('deleteBayForm',$data);
				$this->load->view('footer');
			}
        }
		
		function deleteBayPerformed()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$login_id = $this->session->userdata('login_id');
				$this->load->model('ci_auth', 'bm', TRUE);
				$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
				$sValue=$this->input->post('sValue');
				$sqlrot="select sparcsn4.vsl_vessels.id as rtnValue from sparcsn4.vsl_vessel_visit_details
				inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
				where sparcsn4.vsl_vessel_visit_details.ib_vyg='$ddl_imp_rot_no'";
				//echo $sqlrot."<hr>";
				$vslId=$this->bm->dataReturn($sqlrot);
				$rtn1 = $this->bm->dataDelete("delete from ctmsmis.misBayView where vslId='$vslId' and bay='$sValue'");
				$rtn2 = $this->bm->dataDelete("delete from ctmsmis.misBayViewBelow where vslId='$vslId' and bay='$sValue'");
				$rtn3 = $this->bm->dataDelete("delete from ctmsmis.misBayDetail where vslId='$vslId' and bay='$sValue'");
				if($rtn1==1 and $rtn2==1 and $rtn3==1)
				{
					$data['msg']="<font color='blue'>Rotation ".$ddl_imp_rot_no." Bay ".$sValue." deleted successfully.</font>";
					$this->bm->dataInsert("insert into ctmsmis.misBayDelLog(rotation,bay,delete_by,delete_time) values ('$ddl_imp_rot_no','$sValue','$login_id',now())");
				}
				else
				{
					$data['msg']="<font color='blue'>Rotation ".$ddl_imp_rot_no." Bay ".$sValue." not deleted.</font>";
					$this->bm->dataInsert("insert into ctmsmis.misBayDelLog(rotation,bay,delete_by,delete_time) values ('$ddl_imp_rot_no','$sValue','$login_id',now())");
				}
				//$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
				//$data['sValue']=$sValue;
				$data['title']="DELETE WRONG BAY...";				
				$this->load->view('header2');
				$this->load->view('deleteBayForm',$data);
				$this->load->view('footer');
			}
		}
		
		function deleteIGMInfo(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$data['title']="DELETE IGM INFORMATION FORM...";
				$data['msg']="";
				$this->load->view('header2');
				$this->load->view('deleteIGMInfoForm',$data);
				$this->load->view('footer');
			}
        }
		
		function deleteIGMInfoPerform()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();				
			}
			else
			{
				$login_id = $this->session->userdata('login_id');
				$this->load->model('ci_auth', 'bm', TRUE);
				$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
				
				$strDelCont="DELETE FROM igm_detail_container where igm_detail_id in (select id from igm_details where Import_Rotation_No='$ddl_imp_rot_no')";
				$strDelDtl="DELETE FROM igm_details where Import_Rotation_No='$ddl_imp_rot_no'";
				
				//$str1 = "DELETE igm_details.*,igm_detail_container.* FROM igm_details 
				//INNER JOIN igm_detail_container ON igm_detail_container.igm_detail_id=igm_details.id
				//WHERE Import_Rotation_No='$ddl_imp_rot_no'";
				
				$strSupDelCont="DELETE FROM igm_sup_detail_container where igm_sup_detail_id in (select id from igm_supplimentary_detail where Import_Rotation_No='$ddl_imp_rot_no')";
				$strSupDelDtl="DELETE FROM igm_supplimentary_detail where Import_Rotation_No='$ddl_imp_rot_no'";
				
				//$str2 = "DELETE igm_supplimentary_detail.*,igm_sup_detail_container.* FROM igm_supplimentary_detail 
				//INNER JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
				//WHERE Import_Rotation_No='$ddl_imp_rot_no'";
				
				$str3 = "DELETE FROM igm_for_ctms WHERE Rotation_no='$ddl_imp_rot_no'";
				
				$str4 = "DELETE FROM igm_masters WHERE Import_Rotation_No='$ddl_imp_rot_no'";
				//$rtn1==1; $rtn2==1; $rtn3==1; $rtn4==1;
				
				//$rtn1 = $this->bm->dataDeleteDB1($str1);
				//$rtn2 = $this->bm->dataDeleteDB1($str2);
				
				$rtn1 = $this->bm->dataDeleteDB1($strDelCont);
				$rtn2 = $this->bm->dataDeleteDB1($strDelDtl);
				$rtn3 = $this->bm->dataDeleteDB1($strSupDelCont);
				$rtn4 = $this->bm->dataDeleteDB1($strSupDelDtl);
				$rtn5 = $this->bm->dataDeleteDB1($str3);
				$rtn6 = $this->bm->dataDeleteDB1($str4);
				
				if($rtn1==1 and $rtn2==1 and $rtn3==1 and $rtn4==1 and $rtn5==1 and $rtn6==1)
				{
					$data['msg']="<font color='blue'>Rotation ".$ddl_imp_rot_no." deleted successfully.</font>";
					$this->bm->dataInsertDB1("insert into cchaportdb.igm_delete_info(rotation,delete_by,delete_time) values ('$ddl_imp_rot_no','$login_id',now())");
				}
				else
				{
					$data['msg']="<font color='blue'>Rotation ".$ddl_imp_rot_no." not deleted.</font>";
					$this->bm->dataInsertDB1("insert into cchaportdb.igm_delete_info(rotation,delete_by,delete_time) values ('$ddl_imp_rot_no','$login_id',now())");
				}
				//$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
				//$data['sValue']=$sValue;
				$data['title']="DELETE IGM INFORMATION FORM...";				
				$this->load->view('header2');
				$this->load->view('deleteIGMInfoForm',$data);
				$this->load->view('footer');
			}
		}
		
		function updateVslForExpCont()
		{
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$data['title']="UPDATE VESSEL FOR EXPORT CONTAINERS...";
				$data['msg']="";
				$this->load->view('header2');
				$this->load->view('changeVesselForm',$data);
				$this->load->view('footer');
			}
        }
		
		function updateVslForExContPerformed()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$this->load->model('ci_auth', 'bm', TRUE);
				$pre_rot=trim($this->input->post('pre_rot'));
				$new_rot=trim($this->input->post('new_rot'));
				$contsstr=trim($this->input->post('conts'));
				//echo $pre_rot." ".$new_rot." ".$contsstr;
				$contPart = explode(",",$contsstr);
				//echo $contsstr."<br>";
				$conts = "";
				for($i=0;$i<count($contPart);$i++)
				{
					//echo $i.",";
					$container = trim($contPart[$i]);
					if($i==count($contPart)-1)
						$conts .= "'".$container."'";
					else
						$conts .= "'".$container."',";
				}
				//echo $conts."<br>";
				$sqlprerot="select vvd_gkey as rtnValue from sparcsn4.vsl_vessel_visit_details where ib_vyg='$pre_rot'";
				$sqlnewrot="select vvd_gkey as rtnValue from sparcsn4.vsl_vessel_visit_details where ib_vyg='$new_rot'";
				$preVvdGky=$this->bm->dataReturn($sqlprerot);
				$newVvdGky=$this->bm->dataReturn($sqlnewrot);
				//echo $preVvdGky."-".$newVvdGky;
				$strUpdate = "update ctmsmis.mis_exp_unit set vvd_gkey=$newVvdGky,snx_type=1,last_update=NOW() where vvd_gkey=$preVvdGky and cont_id in($conts)";
				//return;
				$stat = $this->bm->dataUpdate($strUpdate);
				if($stat==1)
					$data['msg']="Container(s) ".$contsstr." Successfully transfered from ".$pre_rot." to ".$new_rot.".";
				else
					$data['msg']="Container(s) ".$contsstr." not transfered from ".$pre_rot." to ".$new_rot.".";
				$data['title']="UPDATE VESSEL FOR EXPORT CONTAINERS...";
				$this->load->view('header2');
				$this->load->view('changeVesselForm',$data);
				$this->load->view('footer');
			}
		}
		
		function updateVisitForPctCont()
		{
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$data['title']="UPDATE VISIT FOR PANGOAN CONTAINERS...";
				$data['msg']="";
				$this->load->view('header2');
				$this->load->view('updateVisitForPctContForm',$data);
				$this->load->view('footer');
			}
        }
		
		function updateVisitForPctContPerformed()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				//$this->load->model('ci_auth', 'bm', TRUE);
				$rot=trim($this->input->post('rot'));
				$cont=trim($this->input->post('cont'));
				$cate=trim($this->input->post('cate'));
				
				$sqlarcargkey="SELECT sparcsn4.argo_carrier_visit.gkey  AS rtnValue FROM sparcsn4.argo_carrier_visit
				INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
				WHERE ib_vyg='$rot'";				
				$sqlunitgkey="SELECT gkey  AS rtnValue FROM sparcsn4.inv_unit WHERE id='$cont' AND category='$cate' ORDER BY gkey DESC LIMIT 1";
				$arcargkey=$this->bm->dataReturn($sqlarcargkey);
				$unitgkey=$this->bm->dataReturn($sqlunitgkey);
				//echo $preVvdGky."-".$newVvdGky;
				$strUpdate = "UPDATE sparcsn4.inv_unit_fcy_visit SET actual_ib_cv='$arcargkey' WHERE unit_gkey='$unitgkey'";
				//return;
				$stat = $this->bm->dataUpdate($strUpdate);
				if($stat==1)
					$data['msg']="Successfully updated";
				else
					$data['msg']="Not updated";
				$data['title']="UPDATE VISIT FOR PANGOAN CONTAINERS...";
				$this->load->view('header2');
				$this->load->view('updateVisitForPctContForm',$data);
				$this->load->view('footer');
			}
		}
		
		function myExportContainerBlockReport(){
		   //print_r($this->session->all_userdata());
		   $session_id = $this->session->userdata('value');
		   if($session_id!=$this->session->userdata('session_id'))
		   {
			$this->logout();
		   }
		   else
		   {
			$data['title']="EXPORT CONTAINER BLOCK REPORT...";
			//echo $data['title'];
			$this->load->view('header2');
			$this->load->view('myBlockContForm',$data);
			$this->load->view('footer');
		   } 
		}

		function myExportContainerBlockReportView(){
			  $ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
			  $this->load->model('ci_auth', 'bm', TRUE);
			  $getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
			  $data['voysNo']=$getVoyNo;
			  //echo $data['voysNo'];
			  $this->load->view('myReportExportContainerBlockList',$data);
			  $this->load->view('myclosebar');
		  
		  }
		
		// vessel layout end
		
		// Vessel List for Canada
		
		function myVesselList(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="VESSEL LIST...";
				$fromdate=$this->input->post('fromdate');
				$todate=$this->input->post('todate');
				if($fromdate!=""){
					$date="file_clearence_date between '$fromdate' and '$todate 23:59:59' ";
				}else{
					$date="year(file_clearence_date)= year(now()) ";
				}
				if($fromdate!=""){
				$str="select Import_Rotation_No,Vessel_Name,file_clearence_date as Submission_Date from igm_masters where vsl_dec_type='GM' and $date order by id desc";
				//echo $str;
				$rtnVesselList = $this->bm->dataSelectDb1($str);
				$data['rtnVesselList']=$rtnVesselList;
				}
				else
				$data['rtnVesselList']="";
				$this->load->view('header2');
				$this->load->view('myVesselList',$data);
				$this->load->view('footer');
			}	
        }
		
		function myIGMDownload(){
			$rot=$this->uri->segment(3);
			$year=$this->uri->segment(4);
			
			$data['rot']=$rot."/".$year;
			$this->load->view('myIGMDownloadTxt',$data);
		}
		
		
		// convert igm to certify section
		function convertIgmCertifySection(){
		
		$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$data['msg']="";
				$data['title']="CONVERT IGM...";
				$this->load->view('header2');
				$this->load->view('myConvertIgmCertifySection',$data);
				$this->load->view('footer');
			}	
		
		}
		
		function convertIgmCertify(){
		
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
			
			$str="SELECT  sparcsn4.inv_unit.gkey AS unit_gkey,sparcsn4.inv_unit.id AS containerId,argo_carrier_visit.id AS vesslID,r.id AS mlo 
                            FROM sparcsn4.inv_unit  
                            INNER JOIN sparcsn4.argo_carrier_visit ON (sparcsn4.argo_carrier_visit.gkey=inv_unit.cv_gkey OR sparcsn4.argo_carrier_visit.gkey=inv_unit.declrd_ib_cv)  
                            INNER JOIN sparcsn4.ref_bizunit_scoped r ON r.gkey=inv_unit.line_op 
                            LEFT JOIN sparcsn4.ref_agent_representation x on r.gkey=x.bzu_gkey 
                            LEFT JOIN sparcsn4.ref_bizunit_scoped y ON x.agent_gkey=y.gkey 
                            INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey  
                            WHERE sparcsn4.vsl_vessel_visit_details.ib_vyg='$ddl_imp_rot_no' AND sparcsn4.inv_unit.category='IMPRT'";
			
				$rtnContainerList = $this->bm->dataSelect($str);
				$i=0;
				foreach($rtnContainerList as $n4ContainerList){
				 $unit_gkey=$n4ContainerList['unit_gkey'];
				 $container_id=$n4ContainerList['containerId'];
				 $vesslID=$n4ContainerList['vesslID'];
				 $mlo_code=$n4ContainerList['mlo'];
				 
				 //$strUpdate="REPLACE INTO continfo_pervessel (unit_gkey,rotation,container_id,vessel_id,mlo) values('$unit_gkey','$ddl_imp_rot_no','$container_id','$vesslID','$mlo_code')";
				 //$rtnContainerPreVessel = $this->bm->dataUpdate($strUpdate);
				
				$igmContainer="select distinct igm_detail_container.off_dock_id as desti_code,igm_detail_container.cont_vat as vat_novat,igm_details.BL_No as mbl,ifnull(igm_supplimentary_detail.BL_No,'') as sbl from igm_detail_container 
								inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id left join igm_supplimentary_detail on igm_supplimentary_detail.igm_detail_id=igm_details.id  
								where igm_details.Import_Rotation_No='$ddl_imp_rot_no' and igm_detail_container.cont_number='$container_id' limit 1";
			
				$rtnContainerList = $this->bm->dataSelectDb1($igmContainer);
				
				$desti_code=$rtnContainerList[0]['desti_code'];
                $vat_novat=$rtnContainerList[0]['vat_novat'];
                $masterBL=$rtnContainerList[0]['mbl'];
                $subBL=$rtnContainerList[0]['sbl'];
                $vatperc = 0;
				
				$vat="";
                if($vat_novat=="VAT")
                {
                    $vatperc = 15;
                    $vat="VAT";
                }
                else
                {
                   $vat="NON VAT"; 
                   $vatperc = 0;
                }
				$billed = 0;
				if($subBL==""){
					$strBillingNew="REPLACE INTO ctmsmis.billingvatinfo_new(unit_gkey,equipmentid,last_update,vatperc,billed,master_BL_No,sub_BL_No) VALUES('$unit_gkey','$container_id',NOW(),'$vatperc','$billed','$masterBL',null)";
				}else{
					$strBillingNew="REPLACE INTO ctmsmis.billingvatinfo_new(unit_gkey,equipmentid,last_update,vatperc,billed,master_BL_No,sub_BL_No) VALUES('$unit_gkey','$container_id',NOW(),'$vatperc','$billed','$masterBL','$subBL')";
				}
				
				$rtnBillingInfo = $this->bm->dataUpdatedb2($strBillingNew);
				if($rtnBillingInfo>0)
					$i++;
			
			}
			if($i>0)
				$msg="Successfully Inserted";
			else
				$msg="Not Inserted. Please Try Again...";
			//REPLACE INTO continfo_pervessel (unit_gkey,rotation,container_id,vessel_id,mlo) values('$unit_gkey','$ddl_imp_rot_no','$container_id','$vesslID','$mlo_code')
			$data['title']="CONVERT IGM...";
			$data['msg']=$msg;
			$this->load->view('header2');
			$this->load->view('myConvertIgmCertifySection',$data);
			$this->load->view('footer');
		
		}
		
		// convert igm to certify section
		
		// One Stop Certify Section000
		function onestopCertifySection(){
		
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$data['msg']="";
				$data['title']="CONVERT IGM...";
				$this->load->view('header2');
				$this->load->view('myOneStopCertifySection',$data);
				$this->load->view('footer');
			}	
		
		}
		
		Function oneStopIgmCertifyList(){
			
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
		
			$ddl_imp_cont_no=$this->input->post('ddl_imp_cont_no');
			$ddl_imp_bl_no=$this->input->post('ddl_imp_bl_no');
			
			if($ddl_imp_cont_no!=""){
				$sqlBl="select BL_No,igm_details.Import_Rotation_No from igm_details inner join igm_detail_container on igm_detail_container.igm_detail_id=igm_details.id where cont_number='$ddl_imp_cont_no' order by igm_detail_container.id desc limit 1";
				$rtnBlList = $this->bm->dataSelectDb1($sqlBl);
				$rtnBlNo= $rtnBlList[0]['BL_No'];
				$rtnRotation= $rtnBlList[0]['Import_Rotation_No'];
			} else {
				$sqlBl="select BL_No,igm_details.Import_Rotation_No from igm_details inner join igm_detail_container on igm_detail_container.igm_detail_id=igm_details.id where BL_No='$ddl_imp_bl_no' order by igm_detail_container.id desc limit 1";
				$rtnBlList = $this->bm->dataSelectDb1($sqlBl);
				$rtnBlNo= $rtnBlList[0]['BL_No'];
				$rtnRotation= $rtnBlList[0]['Import_Rotation_No'];
				//$rtnBlNo=$ddl_imp_bl_no;
			}
						
			$sqlContainer="select igm_details.id,cont_number,igm_details.Import_Rotation_No,(select Vessel_Name from igm_masters 
			where igm_masters.id=igm_details.IGM_id) as vsl_name,igm_details.BL_No,
			cont_size,cont_height,off_dock_id,
			(select Organization_Name from organization_profiles where organization_profiles.id=igm_detail_container.off_dock_id) as offdock_name,
			cont_status,cont_seal_number,cont_iso_type from igm_detail_container 
			inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id 
			where igm_details.BL_No='$rtnBlNo' and igm_details.Import_Rotation_No='$rtnRotation'
			union
			select igm_details.id,cont_number,igm_details.Import_Rotation_No,(select Vessel_Name from igm_masters 
			where igm_masters.id=igm_supplimentary_detail.igm_master_id) as vsl_name,igm_details.BL_No,
			cont_size,cont_height,off_dock_id,
			(select Organization_Name from organization_profiles where organization_profiles.id=igm_sup_detail_container.off_dock_id) as offdock_name,
			cont_status,cont_seal_number,cont_iso_type from igm_sup_detail_container 
			inner join igm_supplimentary_detail on igm_supplimentary_detail.id=igm_sup_detail_container.igm_sup_detail_id 
			inner join igm_details on igm_details.id=igm_supplimentary_detail.igm_detail_id
			where igm_supplimentary_detail.BL_No='$rtnBlNo' and igm_details.Import_Rotation_No='$rtnRotation'
			";
			
			//echo $sqlContainer;
			$rtnContainerList = $this->bm->dataSelectDb1($sqlContainer);
			$data['rtnContainerList']=$rtnContainerList;
		
			$data['containerNo']=$ddl_imp_cont_no;
			$data['blNo']=$ddl_imp_bl_no;
			$data['title']="Container List";
			$this->load->view('header5');
			$this->load->view('myoneStopIgmCertifyListHtml1',$data);
			$this->load->view('footer_1');
		}
	}
		// One Stop Certify Section
		
		
		// End vessel List for canada
		//Get Shipping Agent From AJAX
		function getAgent(){
			//print_r($this->session->all_userdata());
			//$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
			//print_r("shemul test report");
			$this->load->view('getAgent');

        }	
		//Get MLO CODE From AJAX
		function getmlocode(){
			//print_r($this->session->all_userdata());
			//$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
			//print_r("shemul test report");
			$this->load->view('getmlocode');

        }	
		//Get Mlo code for LCL Manifest from Ajax
		function getmlocodeigm(){
			
			$this->load->view('getmlocodeigm');

        }	
			
		//Get Shiiping agent for IGM Report from Ajax
		function getShippingAgents(){
			
			$this->load->view('getShippingAgents');

        }	
		function getmlo(){
			
			$this->load->view('getmlo');
        }	
		
		function getSupShippingAgents(){
			
			$this->load->view('getSupShippingAgents');
        }	
		
		function preAdvisedOffDockContByRotForm()
		{
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="ROTATION WISE PREADVICE CONTAINER REPORT...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('preAdvisedOffDockContByRotForm',$data);
				$this->load->view('footer');
			}	
        }	
		
		function preAdvisedOffDockContByRotReport()
		{	
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$login_id = $this->session->userdata('login_id');	
				$data['login_id']=$login_id;
				$ofdock = $this->Offdock($login_id);
				$rotation=$this->input->post('rotation');
				$data['rotation']=$rotation;
				$serch_by=$this->input->post('serch_by');
				$data['serch_by']=$serch_by;
				$data['ofdock']=$ofdock;
				$this->load->view('preAdvisedOffDockContByRotReport',$data);
				$this->load->view('myclosebar');
			}
		}
		/*function dateWiseEqipAssignForm(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="DATE WISE EQUIPMENT ASSINGMENT LIST...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('dateWiseEqipAssignFormView',$data);
				$this->load->view('footer');
			}	
        }*/
		// Sourav Attached .............. 
		function containerHandlingRptForm(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{  
				$data['title']="CONTAINER HANDLING REPORT...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('myReportContainerHandling',$data);
				$this->load->view('footer');
			}	
        }
		//container Handling Report
		function containerHandlingView(){
							//echo "Hello";
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			$this->load->library('m_pdf');
			$pdf->use_kwt = true;
			$this->data['title']="CONTAINER HANDLING REPORT";
			/*if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{*/
				 if($this->input->post())
				{
					$equipment=$this->input->post('equipment');
					$shift=$this->input->post('shift');
					$sVal=$this->input->post('sVal');
					$sDate=$this->input->post('sDate');
				}
				else
				{
					$equipment="All";
					$shift="All";
					$sDate = date('Y-m-d');
				}
				//$equipment=$this->input->post('equipment');
				//$sVal=$this->input->post('sVal');
				//$sDate=$this->input->post('sDate');
				
				$this->data['equipment']=$equipment;
				$this->data['sVal']=$sVal;
				$this->data['sDate']=$sDate;
				$this->data['shift']=$shift;
				
				//$this->data['rslt_stuffing_report']=$rslt_stuffing_report;
					//$this->data['offdock']=$login_id_offdock;
					
					//$this->data['t20']=$t20;
					//$this->data['t40']=$t40;
					//$this->data['size_20']=$size_20;
					//$this->data['size_40']=$size_40;

					$html=$this->load->view('myReportContainerHandlingList',$this->data, true); 
						 
					$pdfFilePath ="myReportContainerHandlingList_rpt-".time()."-download.pdf";

					$pdf = $this->m_pdf->load();
					$pdf->SetWatermarkText('CPA CTMS');
					$pdf->showWatermarkText = true;	
				//	$stylesheet = file_get_contents('resources/styles/cctnct.css'); 
						
					/* $pdf->AddPage('P', // L - landscape, P - portrait
							'', '', '', '',
							10, // margin_left
							10, // margin right
							10, // margin top
							10, // margin bottom
							10, // margin header
							10); // margin footer */
							
				//	$pdf->WriteHTML($stylesheet,1);
					$pdf->setFooter('Developed By : DataSoft|Page {PAGENO} of {nb}|Date {DATE j-m-Y}');
					$pdf->WriteHTML($html,2);
							 
					$pdf->Output($pdfFilePath, "I"); // For Show Pdf
				
				//$this->load->view('myReportContainerHandlingList',$data);
				//$this->load->view('myclosebar');
			//}
        }
		
		
		function showProcessList()
		{
			$session_id = $this->session->userdata('value');
			$login_id = $this->session->userdata('login_id');
			
			$this->load->model('ci_auth', 'bm', TRUE);
			
				
				$sql_data="SELECT * FROM information_schema.processlist where User ='sparcsn4' and DB is not null order by Time asc;";
			
				$processList = $this->bm->dataSelectDb2($sql_data);
				
				$data['processList']=$processList;    
				$data['title']="Running Process List...";
				
				$data['login_id']=$login_id;
				$this->load->view('header2');
				$this->load->view('showProcessForm',$data);
				$this->load->view('footer');
			//}
		}
		
		function slaveProcess()
		{
			$session_id = $this->session->userdata('value');
			$login_id = $this->session->userdata('login_id');			
			$this->load->model('ci_auth', 'bm', TRUE);
			
				$sql_data="show slave STATUS";
			
				$processList = $this->bm->dataSelect($sql_data);
				
				$data['processList']=$processList; 

				$sql_data22="show slave STATUS";
			
				$processList22 = $this->bm->dataSelectDb2($sql_data22);
				
				$data['processList22']=$processList22;    
				
				$data['title']="Slave Process";

				$data['login_id']=$login_id;
				$this->load->view('header5');
				$this->load->view('slaveProcess',$data);
				$this->load->view('footer_1');
		}	
		
		
		
		
		function plannedRptForm(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{  
				$data['title']="Container Job Done Report Vesselwise...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('myPlannedRptFrm',$data);
				$this->load->view('footer');
			}	
        }
		function plannedRptFormView(){
					
					$srcFor=$this->input->post('srcFor');
					$srcRot=$this->input->post('srcRot');
					$fromdate=$this->input->post('fromdate');
					$todate=$this->input->post('todate');
					
					
					//return;
					$data['fromdate']=$fromdate;
					$data['todate']=$todate;
					$data['srcFor']=$srcFor;
					$data['srcRot']=$srcRot;
					
					//echo $data['voysNo'];
					$this->load->view('plannedRptFormViewList',$data);
		}
		function officeCodeUpdaterForm()
		{
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{  
				$data['title']="Update Form....";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('updateShedFrm',$data);
				$this->load->view('footer');
			}	
		}
		function shedUpdateFormView(){
		
				$rotation=$this->input->post('rotation');
				$container=$this->input->post('container');
				$tblName="";
				$chkSupTbl="select COUNT(igm_supplimentary_detail.id) 
							from igm_supplimentary_detail 
							inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
							where Import_Rotation_No='$rotation' and cont_number='$container'";
				$chkSupTbl = $this->bm->dataSelectDb1($chkSupTbl);
				if($chkSupTbl==0)
				{
					$sqlUpdateShed="
									select igm_details.id,igm_details.Line_No,Import_Rotation_No,BL_No,cont_number,Pack_Number 
									from igm_details 
									inner join igm_detail_container on igm_detail_container.igm_detail_id=igm_details.id
									where Import_Rotation_No='$rotation' and cont_number='$container'
									order by 2";
					$tblName="Detail";
				}
				else{
					$sqlUpdateShed="select igm_supplimentary_detail.id,igm_supplimentary_detail.Line_No,Import_Rotation_No,BL_No,cont_number,Pack_Number 
								from igm_supplimentary_detail 
								inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
								where Import_Rotation_No='$rotation' and cont_number='$container'
								order by 2";
					$tblName="SupDetail";
				}
				
				
			
			//echo $sqlContainer;
				$rtnSqlUpdateShedList = $this->bm->dataSelectDb1($sqlUpdateShed);
				$data['rtnSqlUpdateShedList']=$rtnSqlUpdateShedList;
				$data['container']=$container;
				$data['rotation']=$rotation;
				$data['tblName']=$tblName;
				//echo $data['voysNo'];
				$this->load->view('shedUpdateFormView',$data);
		}
				function updateActionPerform(){
					
				$rotation=$this->input->post('rotation');
				$container=$this->input->post('container');
				$tblName=$this->input->post('tblName');
				
				$dtlID=$this->input->post('dtlID');
				$lineNo=$this->input->post('lineNo');
				$packNo=$this->input->post('packNo');
				$blNo=$this->input->post('blNo');
				$beNo=$this->input->post('beNo');
				$beDate=$this->input->post('beDate');
				$offCode=$this->input->post('offCode');
				
				//echo "Detail ID : ".$dtlID." Line : ".$lineNo." BE No : ".$beNo." Table Name : ".$tblName;
				
				if($tblName=="Detail")
				{
					$strupdate = "update igm_details 
									set Bill_of_Entry_No='$beNo', Bill_of_Entry_Date='$beDate', office_code='$offCode'
									where id=$dtlID";
									echo "Detail";
				}
				else{
					$strupdate = "update igm_supplimentary_detail 
								  set Bill_of_Entry_No='$beNo', Bill_of_Entry_Date='$beDate', office_code='$offCode'
								  where id=$dtlID";
								  echo $strupdate;
				}
			
			$stat = $this->bm->dataInsertDB1($strupdate);
			//$stat=1;
			//echo "Stat : ".$stat;
			
			$data['msg']="";
			if($stat==1)
				$data['msg']="Data successfully updated ";
			else
				$data['msg']="Data not updated";
			
				$tblName="";
				
				$chkSupTbl="select COUNT(igm_supplimentary_detail.id) 
							from igm_supplimentary_detail 
							inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
							where Import_Rotation_No='$rotation' and cont_number='$container'";
				$chkSupTbl = $this->bm->dataSelectDb1($chkSupTbl);
				if($chkSupTbl==0)
				{
					$sqlUpdateShed="
									select igm_details.id,igm_details.Line_No,Import_Rotation_No,BL_No,cont_number,Pack_Number 
									from igm_details 
									inner join igm_detail_container on igm_detail_container.igm_detail_id=igm_details.id
									where Import_Rotation_No='$rotation' and cont_number='$container'
									order by 2";
					$tblName="Detail";
				}
				else{
					$sqlUpdateShed="select igm_supplimentary_detail.id,igm_supplimentary_detail.Line_No,Import_Rotation_No,BL_No,cont_number,Pack_Number 
								from igm_supplimentary_detail 
								inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
								where Import_Rotation_No='$rotation' and cont_number='$container'
								order by 2";
					$tblName="SupDetail";
				}
			
			//echo $sqlContainer;
				$rtnSqlUpdateShedList = $this->bm->dataSelectDb1($sqlUpdateShed);
				$data['rtnSqlUpdateShedList']=$rtnSqlUpdateShedList;
				$data['container']=$container;
				$data['rotation']=$rotation;
				$data['tblName']=$tblName;
				//$data['container']=$container;
				//$data['rotation']=$rotation;
				//echo $data['voysNo'];
				//$this->load->view('shedUpdateFormView',$data);
			$this->load->view('shedUpdateFormView',$data);
		}
			function doReportForm()
		{
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{  
				$data['title']="Delivery Order Report...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('doRptFrm',$data);
				$this->load->view('footer');
			}	
		}
		function doReportView(){

				$container=$this->input->post('container');
				
				$data['container']=$container;				
				//echo $data['voysNo'];
				$this->load->view('doRptFormViewList',$data);
		}
		
		function tallyEntryWithIgmInfoForm()
		{	
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="TALLY ENTRY FORM WITH IGM INFORMATION...";
				$this->load->view('header2');
				$this->load->view('tallyEntryForm',$data);
				$this->load->view('footer');
			}
		}
		function tallyEntryFormWithIgmContInfo()
		{	
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				if($this->input->post('rotation') && $this->input->post('cont'))
				{
					$rotation=trim($this->input->post('rotation'));
					$cont=trim($this->input->post('cont'));
					
					$cntquery="SELECT COUNT(lcl_assignment_detail.igm_detail_id) AS rtnValue
					FROM lcl_assignment_detail
					INNER JOIN igm_details ON igm_details.id=lcl_assignment_detail.igm_detail_id
					INNER JOIN igm_detail_container ON igm_detail_container.igm_detail_id=igm_details.id
					WHERE Import_Rotation_No='$rotation' AND cont_number='$cont'";
					
					$cntrslt=$this->bm->dataReturnDb1($cntquery);
					
					
					if($cntrslt==0)
					{
						$data['title']="TALLY ENTRY FORM WITH IGM INFORMATION...";
						$data['msg']="Please provide assignment for the container";
						$data['assigned']=0;
						$this->load->view('tallyEntryFormView',$data);
						
						//return;
					} 
				}
				else
				{
					$cont=$this->uri->segment(3);
					$rot_year=$this->uri->segment(4);
					$rot_no=$this->uri->segment(5);
					$rotation=$rot_year.'/'.$rot_no;
					
					$cntquery="SELECT COUNT(lcl_assignment_detail.igm_detail_id) AS rtnValue
					FROM lcl_assignment_detail
					INNER JOIN igm_details ON igm_details.id=lcl_assignment_detail.igm_detail_id
					INNER JOIN igm_detail_container ON igm_detail_container.igm_detail_id=igm_details.id
					WHERE Import_Rotation_No='$rotation' AND cont_number='$cont'";
					
					$cntrslt=$this->bm->dataReturnDb1($cntquery);
					
					if($cntrslt==0)
					{
						$data['title']="TALLY ENTRY FORM WITH IGM INFORMATION...";
						$data['msg']="Please provide assignment for the container";
						$data['assigned']=0;
						$this->load->view('tallyEntryFormView',$data);
						
						//return;
					}
				}
				
				$chkExistShedTallyQry="select count(id) as id from shed_tally_info WHERE  import_rotation='$rotation' and cont_number='$cont'";
				$rtnExistShedTally = $this->bm->dataSelectDb1($chkExistShedTallyQry);
				$cntExist = $rtnExistShedTally[0]['id'];
				
				//echo $cntExist;
				//echo $chkExistShedTallyQry;
				
				$tbl = "sup_detail";
			
				//Cont_gross_weight and cont_seal_number added
				if($cntExist<1)
				{
					$sqlContainer="SELECT igm_supplimentary_detail.id,master_BL_No,Description_of_Goods,Import_Rotation_No,BL_No,cont_number,cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
					FROM igm_supplimentary_detail 
					LEFT JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id					
					WHERE Import_Rotation_No='$rotation' AND cont_number='$cont'
					ORDER BY 2";
					
					$sql_vesselname_seal="SELECT Vessel_Name,cont_seal_number,cont_size 
					FROM igm_supplimentary_detail 
					LEFT JOIN igm_details ON igm_details.id=igm_supplimentary_detail.igm_detail_id
					LEFT JOIN igm_masters ON igm_masters.id=igm_supplimentary_detail.igm_master_id
					LEFT JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id	
					WHERE igm_masters.Import_Rotation_No= '$rotation' AND igm_sup_detail_container.cont_number='$cont'";
				}
				else
				{
					$sqlContainerCheck="SELECT igm_supplimentary_detail.id,master_BL_No,Description_of_Goods,Import_Rotation_No,BL_No,cont_number,cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
					FROM igm_supplimentary_detail 
					INNER JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
					WHERE Import_Rotation_No='$rotation' AND cont_number='$cont'
					ORDER BY 2";				

					$rtnContainerListCheck = $this->bm->dataSelectDb1($sqlContainerCheck);
					$cntCheck = count($rtnContainerListCheck);
					
					if($cntCheck==0)
					{
						$sqlContainer = "select * from (select igm_details.id,Import_Rotation_No,BL_No,cont_number,cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
						from igm_details 
						inner join igm_detail_container on igm_detail_container.igm_detail_id=igm_details.id
						where Import_Rotation_No='$rotation' and cont_number='$cont'					
						) tbl1
						union
						select * from (SELECT shed_tally_info.igm_detail_id AS id,
						import_rotation AS Import_Rotation_No,
						BL_No,
						shed_tally_info.cont_number,
						cont_size,
						Cont_gross_weight,
						cont_seal_number,
						Pack_Description,
						Pack_Marks_Number,
						Pack_Number,
						ConsigneeDesc,
						NotifyDesc FROM shed_tally_info LEFT JOIN igm_details ON shed_tally_info.igm_detail_id=igm_details.id LEFT JOIN igm_detail_container ON igm_detail_container.igm_detail_id=igm_details.id WHERE shed_tally_info.import_rotation='2018/1975' AND shed_tally_info.cont_number='MRKU3362706' AND BL_NO IS NOT NULL 
						) tbl2";		

						$sql_vesselname_seal="SELECT Vessel_Name,cont_seal_number,cont_size 
						FROM igm_details 
						LEFT JOIN igm_masters ON igm_masters.id=igm_details.IGM_id
						LEFT JOIN igm_detail_container ON igm_detail_container.igm_detail_id=igm_details.id	
						WHERE igm_masters.Import_Rotation_No= '$rotation' AND igm_detail_container.cont_number='$cont'";
					}
					else
					{
						$sqlContainer="select * from (SELECT igm_supplimentary_detail.id,master_BL_No,Description_of_Goods,Import_Rotation_No,BL_No,cont_number,
						cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
						FROM igm_supplimentary_detail 
						LEFT JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id					
						WHERE Import_Rotation_No='$rotation' AND cont_number='$cont'
						) tbl1
						union
						select * from (SELECT shed_tally_info.igm_sup_detail_id as id,master_BL_No,Description_of_Goods,import_rotation as Import_Rotation_No,BL_No,
						shed_tally_info.cont_number, cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,
						NotifyDesc FROM shed_tally_info 
						LEFT JOIN igm_supplimentary_detail ON shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id 
						LEFT JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id 
						WHERE shed_tally_info.import_rotation='$rotation' and shed_tally_info.cont_number='$cont' and BL_NO is null
						)tbl2";
						
						$sql_vesselname_seal="SELECT Vessel_Name,cont_seal_number,cont_size 
						FROM igm_supplimentary_detail 
						LEFT JOIN igm_details ON igm_details.id=igm_supplimentary_detail.igm_detail_id
						LEFT JOIN igm_masters ON igm_masters.id=igm_supplimentary_detail.igm_master_id
						LEFT JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id	
						WHERE igm_masters.Import_Rotation_No= '$rotation' AND igm_sup_detail_container.cont_number='$cont'";
					}
					
					/*$sqlContainer="SELECT shed_tally_info.igm_sup_detail_id as id,master_BL_No,Description_of_Goods,import_rotation as Import_Rotation_No,BL_No,shed_tally_info.cont_number,
								cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
								FROM shed_tally_info 
								LEFT JOIN igm_supplimentary_detail  ON shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
								LEFT JOIN  igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
								WHERE  shed_tally_info.import_rotation='$rotation' and shed_tally_info.cont_number='$cont'
								ORDER BY 2";*/
				}
				//echo $sqlContainer;
				
				$rtnContainerList = $this->bm->dataSelectDb1($sqlContainer);
				$cnt = count($rtnContainerList);
				//echo "ee : ".$cnt."--".$sqlContainer;
				
			//	echo "count_number " . $cnt;  //finds working query
				
				//Cont_gross_weight and cont_seal_number added
				if($cnt==0)
				{
					$tbl = "detail";
					if($cntExist<1)
					{
						$sqlContainer = "select igm_details.id,Import_Rotation_No,BL_No,cont_number,cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
						from igm_details 
						LEFT join igm_detail_container on igm_detail_container.igm_detail_id=igm_details.id
						where Import_Rotation_No='$rotation' and cont_number='$cont'
						order by 2";
					}
					else {
						$sqlContainer = "select * from (select igm_details.id,Import_Rotation_No,BL_No,cont_number,cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
						from igm_details 
						inner join igm_detail_container on igm_detail_container.igm_detail_id=igm_details.id
						where Import_Rotation_No='$rotation' and cont_number='$cont'					
						) tbl1
						union
						select * from (SELECT shed_tally_info.igm_detail_id AS id,
						import_rotation AS Import_Rotation_No,
						BL_No,
						shed_tally_info.cont_number,
						cont_size,
						Cont_gross_weight,
						cont_seal_number,
						Pack_Description,
						Pack_Marks_Number,
						Pack_Number,
						ConsigneeDesc,
						NotifyDesc FROM shed_tally_info LEFT JOIN igm_details ON shed_tally_info.igm_detail_id=igm_details.id LEFT JOIN igm_detail_container ON igm_detail_container.igm_detail_id=igm_details.id WHERE shed_tally_info.import_rotation='2018/1975' AND shed_tally_info.cont_number='MRKU3362706' AND BL_NO IS NOT NULL 
						)tbl2";
					}
					$rtnContainerList = $this->bm->dataSelectDb1($sqlContainer);
					
					$sql_vesselname_seal="SELECT Vessel_Name,cont_seal_number,cont_size 
						FROM igm_details 
						LEFT JOIN igm_masters ON igm_masters.id=igm_details.IGM_id
						LEFT JOIN igm_detail_container ON igm_detail_container.igm_detail_id=igm_details.id	
						WHERE igm_masters.Import_Rotation_No= '$rotation' AND igm_detail_container.cont_number='$cont'";
				}
				$chkExchangeDoneQuery="select count(id) as chkVal from shed_tally_info where import_rotation='$rotation' and cont_number='$cont' and exchange_done_status=1";
					//echo $chkExchangeDoneQuery;
					$chkList = $this->bm->dataSelectDb1($chkExchangeDoneQuery);
					$chkVal= $chkList[0]['chkVal'];
					if($chkVal>0)
					{
						//$data['update_btn_status']=0;
						$data['view_btn_status']=1;  //previously 0; 1 for exchange done; alter if necessary
						$data['save_btn_status']=0;
						$data['exchange_btn_status']=0;
						$data['msgExchange']="Exchange Done";
					}
					else{
						$chkExchangeDoneQuery="select count(id) as chkVal from shed_tally_info where import_rotation='$rotation' and cont_number='$cont' and exchange_done_status=0";
						//echo $chkQuery;
						$chkList = $this->bm->dataSelectDb1($chkExchangeDoneQuery);
						$chkVal= $chkList[0]['chkVal'];
						if($chkVal>0)
						{
							//$data['update_btn_status']=1;
							$data['view_btn_status']=1;
							$data['exchange_btn_status']=1;
							$data['save_btn_status']=1;
						}
						else{
							//$data['update_btn_status']=0;
							$data['view_btn_status']=0;
							$data['exchange_btn_status']=0;
							$data['save_btn_status']=1;
						}
					}
				$login_id = $this->session->userdata('login_id');
				
				// $sql_vesselname_seal="SELECT Vessel_Name,cont_seal_number
				// FROM  shed_tally_info
				// LEFT JOIN igm_supplimentary_detail ON shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
				// LEFT JOIN igm_details ON igm_details.id=igm_supplimentary_detail.igm_detail_id
				// LEFT JOIN igm_masters ON igm_masters.id=igm_supplimentary_detail.igm_master_id
				// LEFT JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id		
				// WHERE shed_tally_info.import_rotation='$rotation' AND shed_tally_info.cont_number='$cont'";
				
				// $sql_vesselname_seal="SELECT Vessel_Name,cont_seal_number 
				// FROM igm_supplimentary_detail 
				// LEFT JOIN igm_details ON igm_details.id=igm_supplimentary_detail.igm_detail_id
				// LEFT JOIN igm_masters ON igm_masters.id=igm_supplimentary_detail.igm_master_id
				// LEFT JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id	
				// WHERE igm_masters.Import_Rotation_No= '$rotation' AND igm_sup_detail_container.cont_number='$cont'";
				
				
				
				$rslt_vesselname_seal=$this->bm->dataSelectDb1($sql_vesselname_seal);
				
				$data['rslt_vesselname_seal']=$rslt_vesselname_seal;
				
				$data['assigned']=1;		
				$data['rotation']=$rotation;
				$data['tbl']=$tbl;
				$data['cont']=$cont;
				$data['stat']="";
				$data['login_id']=$login_id;
				
				
				$data['rtnContainerList']=$rtnContainerList; //"$rtnContainerList" returns selected data for table
				$this->load->view('tallyEntryFormView',$data);
			}
		}
		//////////// SOURAV TALLY ENTRY NEW FORMAT START ////////////////////////
		function saveTallyRcv()
		{	
			$rcv=$this->input->post('rcv');
			$conLocFast=$this->input->post('conLocFast');
			$flt=$this->input->post('flt');
			$flt_pack_loc=$this->input->post('flt_pack_loc');
			$totalPck=$this->input->post('totalPck');
			$rcv_unit=$this->input->post('rcv_unit');
			$loc=$this->input->post('contAtShed');
			$shiftname=$this->input->post('shiftname');
			$actualmarks=$this->input->post('actualmarks');
			$remark=$this->input->post('remark');			
			$dtlId=$this->input->post('dtlId');
			//$wrDate=$this->input->post('wrDate');
			
			$rot=$this->input->post('rot');
			$cont=$this->input->post('cont');
			
			$tbl=$this->input->post('tbl');
			
			$ipaddr = $_SERVER['REMOTE_ADDR'];
			$login_id = $this->session->userdata('login_id');
			$section = $this->session->userdata('section');
			
			$date = date('dmy');
			$dtlDate = date('my');
			
			$igmDetailQuery="select MAX(id) as rtnValue from shed_tally_info";				
			$igmDetailId = $this->bm->dataReturnDb1($igmDetailQuery);
			$igmDetailId_no = $igmDetailId+1;
			$igmDetailNumber=$dtlDate."00".$igmDetailId_no;
			 
			$strChkTallySheetEntry="select count(id) as id from shed_tally_info WHERE  import_rotation='$rot' and cont_number='$cont'";
			//echo $strChkTallySheetEntry;
			$rtnExistTallySheet = $this->bm->dataSelectDb1($strChkTallySheetEntry);
			$tallyExist = $rtnExistTallySheet[0]['id'];
			//echo "Exist : ".$tallyExist;
			if($tallyExist>0)
			{
				if($tbl=="sup_detail")
				{
					$strGetTallyInformation= "select distinct tally_sheet_no,wr_date,tally_sheet_number from shed_tally_info WHERE  import_rotation='$rot' and cont_number='$cont'";
					$rtnGetTallyInformation = $this->bm->dataSelectDb1($strGetTallyInformation);
					
					$tallySheetNo=$rtnGetTallyInformation[0]['tally_sheet_no'];
					$wrDate=$rtnGetTallyInformation[0]['wr_date'];
					$tallySheetNumber=$rtnGetTallyInformation[0]['tally_sheet_number'];
					
					if($dtlId=="" || $dtlId==0)
							{
								$str = "insert into shed_tally_info(igm_sup_detail_id,import_rotation,cont_number,rcv_pack,flt_pack,flt_pack_loc,shed_loc,update_by,ip_addr,remarks,last_update,tally_sheet_no,shift_name,actual_marks,loc_first,total_pack,wr_date,shed_yard,rcv_unit,tally_sheet_number)
								values('$igmDetailNumber','$rot','$cont','$rcv','$flt','$flt_pack_loc','$loc','$login_id','$ipaddr','$remark',now(),
								'$tallySheetNo','$shiftname','$actualmarks',$conLocFast,$totalPck,date(now()),'$section','$rcv_unit','$tallySheetNumber')";
							}
					else
					{
					
						$str = "insert into shed_tally_info(igm_sup_detail_id,import_rotation,cont_number,rcv_pack,flt_pack,flt_pack_loc,shed_loc,update_by,ip_addr,
							remarks,last_update,tally_sheet_no,shift_name,actual_marks,loc_first,total_pack,wr_date,shed_yard,rcv_unit,tally_sheet_number)
							values('$dtlId','$rot','$cont','$rcv','$flt','$flt_pack_loc','$loc','$login_id','$ipaddr','$remark',now(),
							'$tallySheetNo','$shiftname','$actualmarks',$conLocFast,$totalPck,'$wrDate','$section','$rcv_unit','$tallySheetNumber')";
					}
				}
				else
				{
					if($dtlId=="" || $dtlId==0)
							{
								$str = "insert into shed_tally_info(igm_sup_detail_id,import_rotation,cont_number,rcv_pack,flt_pack,flt_pack_loc,shed_loc,update_by,ip_addr,remarks,last_update,tally_sheet_no,shift_name,actual_marks,loc_first,total_pack,wr_date,shed_yard,rcv_unit,tally_sheet_number)
								values('$igmDetailNumber','$rot','$cont','$rcv','$flt','$flt_pack_loc','$loc','$login_id','$ipaddr','$remark',now(),
								'$maxtally_sheet_no','$shiftname','$actualmarks',$conLocFast,$totalPck,date(now()),'$section','$rcv_unit','$tallySheetNumber')";
							}
					else
					{
						$str = "insert into shed_tally_info(igm_detail_id,import_rotation,cont_number,rcv_pack,flt_pack,flt_pack_loc,shed_loc,update_by,ip_addr,
							remarks,last_update,tally_sheet_no,shift_name,actual_marks,loc_first,total_pack,wr_date,shed_yard,rcv_unit,tally_sheet_number)
							values('$dtlId','$rot','$cont','$rcv','$flt','$flt_pack_loc','$loc','$login_id','$ipaddr','$remark',now(),
							'$tallySheetNo','$shiftname','$actualmarks',$conLocFast,$totalPck,'$wrDate','$section','$rcv_unit','$tallySheetNumber')";
					}
				}
				//echo $str;
				$stat = $this->bm->dataInsertDB1($str);
				if($stat==1)
				{					
					$data['stat']="<font color='red'><b>Sucessfully inserted</b></font>";
					$data['view_btn_status']=1;
					$data['exchange_btn_status']=1;
					$data['save_btn_status']=1;
				}
			}
			else
			{
				//echo "NEW DATA";
				
				$tally_sheet_noQuery="select MAX(tally_sheet_no) as rtnValue from shed_tally_info";
				$tally_sheet_no = $this->bm->dataReturnDb1($tally_sheet_noQuery);
				
				
				
				$maxtally_sheet_no = $tally_sheet_no+1;
				//$igmDetailId_no = $igmDetailId+1;
				
				$size=strlen($maxtally_sheet_no);
				
				if($size==1)
				{
				//	 $tallySheetNumber="TSN"."-".$date."000".$maxtally_sheet_no;
					 $tallySheetNumber=$section."-".$date."000".$maxtally_sheet_no;
					 //$igmDetailNumber=$dtlDate.$maxtally_sheet_no.$igmDetailId_no;
				}
				else if($size==2)
				{
				//	 $tallySheetNumber="TSN"."-".$date."00".$maxtally_sheet_no;
					$tallySheetNumber=$section."-".$date."00".$maxtally_sheet_no;
					//$igmDetailNumber=$dtlDate.$maxtally_sheet_no.$igmDetailId_no;
				}
				else if($size==3)
				{
				//	 $tallySheetNumber="TSN"."-".$date."0".$maxtally_sheet_no;
					 $tallySheetNumber=$section."-".$date."0".$maxtally_sheet_no;
					 //$igmDetailNumber=$dtlDate.$maxtally_sheet_no.$igmDetailId_no;
				}
				else 
				{
				//	 $tallySheetNumber="TSN"."-".$date."".$maxtally_sheet_no;
					$tallySheetNumber=$section."-".$date."".$maxtally_sheet_no;
					//$igmDetailNumber=$dtlDate.$maxtally_sheet_no.$igmDetailId_no;
				}
				if($tbl=="sup_detail")
						{
							if($dtlId=="" || $dtlId==0)
							{
									$str = "insert into shed_tally_info(igm_sup_detail_id,import_rotation,cont_number,rcv_pack,flt_pack,flt_pack_loc,shed_loc,update_by,ip_addr,remarks,last_update,tally_sheet_no,shift_name,actual_marks,loc_first,total_pack,wr_date,shed_yard,rcv_unit,tally_sheet_number)
									values('$igmDetailNumber','$rot','$cont','$rcv','$flt','$flt_pack_loc','$loc','$login_id','$ipaddr','$remark',now(),
									'$maxtally_sheet_no','$shiftname','$actualmarks',$conLocFast,$totalPck,date(now()),'$section','$rcv_unit','$tallySheetNumber')";
							}
							else
							{
									$str = "insert into shed_tally_info(igm_sup_detail_id,import_rotation,cont_number,rcv_pack,flt_pack,flt_pack_loc,shed_loc,update_by,ip_addr,remarks,last_update,tally_sheet_no,shift_name,actual_marks,loc_first,total_pack,wr_date,shed_yard,rcv_unit,tally_sheet_number)
									values('$dtlId','$rot','$cont','$rcv','$flt','$flt_pack_loc','$loc','$login_id','$ipaddr','$remark',now(),
									'$maxtally_sheet_no','$shiftname','$actualmarks',$conLocFast,$totalPck,date(now()),'$section','$rcv_unit','$tallySheetNumber')";
							}
						}
						else
						{
							if($dtlId=="" || $dtlId==0)
							{
								$str = "insert into shed_tally_info(igm_sup_detail_id,import_rotation,cont_number,rcv_pack,flt_pack,flt_pack_loc,shed_loc,update_by,ip_addr,remarks,last_update,tally_sheet_no,shift_name,actual_marks,loc_first,total_pack,wr_date,shed_yard,rcv_unit,tally_sheet_number)
									values('$igmDetailNumber','$rot','$cont','$rcv','$flt','$flt_pack_loc','$loc','$login_id','$ipaddr','$remark',now(),
									'$maxtally_sheet_no','$shiftname','$actualmarks',$conLocFast,$totalPck,date(now()),'$section','$rcv_unit','$tallySheetNumber')";
							}
							else
							{
								$str = "insert into shed_tally_info(igm_detail_id,import_rotation,cont_number,rcv_pack,flt_pack,flt_pack_loc,shed_loc,update_by,ip_addr,remarks,last_update,tally_sheet_no,shift_name,actual_marks,loc_first,total_pack,wr_date,shed_yard,rcv_unit,tally_sheet_number)
									values('$dtlId','$rot','$cont','$rcv','$flt','$flt_pack_loc','$loc','$login_id','$ipaddr','$remark',now(),
									'$maxtally_sheet_no','$shiftname','$actualmarks',$conLocFast,$totalPck,date(now()),'$section','$rcv_unit','$tallySheetNumber')";
							}
						}
					//echo $str;
						$stat = $this->bm->dataInsertDB1($str);  //comment out to stop insertion
						if($stat==1)
						{
							$data['stat']="<font color='red'><b>Sucessfully inserted</b></font>";
							$data['view_btn_status']=1;
							$data['exchange_btn_status']=1;
							$data['save_btn_status']=1;
						}
			}
			$chkExistShedTallyQry="select count(id) as id from shed_tally_info WHERE  import_rotation='$rot' and cont_number='$cont'";
			$rtnExistShedTally = $this->bm->dataSelectDb1($chkExistShedTallyQry);
			$cntExist = $rtnExistShedTally[0]['id'];
					
			if($tbl=="sup_detail")
			{
				$tbl=="sup_detail";
				if($cntExist<1)
				{
					$sqlContainer = "select igm_supplimentary_detail.id,master_BL_No,Description_of_Goods,Import_Rotation_No,BL_No,cont_number,cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
					from igm_supplimentary_detail 
					inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
					where Import_Rotation_No='$rot' and cont_number='$cont'
					order by 2";
				}
				else
				{
					$sqlContainer = "select * from (SELECT igm_supplimentary_detail.id,master_BL_No,Description_of_Goods,Import_Rotation_No,BL_No,cont_number,
									cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
									FROM igm_supplimentary_detail 
									LEFT JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id					
									WHERE Import_Rotation_No='$rot' AND cont_number='$cont'
									) tbl1
									union
									select * from (SELECT shed_tally_info.igm_sup_detail_id as id,master_BL_No,Description_of_Goods,import_rotation as Import_Rotation_No,BL_No,
									shed_tally_info.cont_number, cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,
									NotifyDesc FROM shed_tally_info 
									LEFT JOIN igm_supplimentary_detail ON shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id 
									LEFT JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id 
									WHERE shed_tally_info.import_rotation='$rot' and shed_tally_info.cont_number='$cont' and BL_NO is null
									)tbl2";
					/*$sqlContainer="SELECT shed_tally_info.igm_sup_detail_id as id,master_BL_No,Description_of_Goods,import_rotation as Import_Rotation_No,BL_No,shed_tally_info.cont_number,
					cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
					FROM shed_tally_info 
					LEFT JOIN igm_supplimentary_detail  ON shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
					LEFT JOIN  igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
					WHERE  shed_tally_info.import_rotation='$rot' and shed_tally_info.cont_number='$cont'
					ORDER BY 2";*/
				}
			}						
			else
			{
				$tbl=="detail";
				if($cntExist<1)
				{
					$sqlContainer = "select igm_details.id,Import_Rotation_No,BL_No,cont_number,cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
					from igm_details 
					inner join igm_detail_container on igm_detail_container.igm_detail_id=igm_details.id
					where Import_Rotation_No='$rot' and cont_number='$cont'
					order by 2
					";
				}
				else
				{
					$sqlContainer = "select * from (select igm_details.id,Import_Rotation_No,BL_No,cont_number,cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
									from igm_details 
									inner join igm_detail_container on igm_detail_container.igm_detail_id=igm_details.id
									where Import_Rotation_No='$rot' and cont_number='$cont'					
									) tbl1
									union
									select * from (SELECT shed_tally_info.igm_detail_id as id,master_BL_No,Description_of_Goods,import_rotation as Import_Rotation_No,BL_No,
									shed_tally_info.cont_number, cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,
									NotifyDesc FROM shed_tally_info 
									LEFT JOIN igm_details ON shed_tally_info.igm_detail_id=igm_details.id 
									LEFT JOIN igm_detail_container ON igm_detail_container.igm_detail_id=igm_details.id 
									WHERE shed_tally_info.import_rotation='$rot' and shed_tally_info.cont_number='$cont' and BL_NO is null
									)tbl2";
				}
			}
			//echo $sqlContainer;
			$rtnContainerList = $this->bm->dataSelectDb1($sqlContainer);			
			$data['assigned']=1;
			$data['rotation']=$rot;
			$data['cont']=$cont;
			$data['tbl']=$tbl;
				
			$data['rtnContainerList']=$rtnContainerList;
			$this->load->view('tallyEntryFormView',$data);
			
			
			//echo "RCV : ".$rcv." DtlID : ".$dtlId." Rotation : ".$rotation;
		}
		function deleteTallyRcv()
		{	
			$tallyID=$this->uri->segment(3);
			$cont=$this->uri->segment(4);			
			$rot=str_replace("_","/",$this->uri->segment(5));
			$tbl=$this->uri->segment(6);
			
			$strDelQuery = "delete from shed_tally_info where id=$tallyID";
			$statDel = $this->bm->dataInsertDB1($strDelQuery);
			if($statDel==1)
			{
				$data['stat']="<font color='red'><b>Sucessfully Deleted.</b></font>";
				$data['view_btn_status']=1;
				$data['save_btn_status']=1;
				$data['exchange_btn_status']=1;
			}
			$chkExistShedTallyQry="select count(id) as id from shed_tally_info WHERE  import_rotation='$rot' and cont_number='$cont'";
			//echo $chkExistShedTallyQry;
			//echo $tbl."-- Table ";
			$rtnExistShedTally = $this->bm->dataSelectDb1($chkExistShedTallyQry);
			$cntExist = $rtnExistShedTally[0]['id'];
					
			if($tbl=="sup_detail")
			{
				$tbl="sup_detail";
				if($cntExist<1)
				{
					$sqlContainer = "select igm_supplimentary_detail.id,master_BL_No,Description_of_Goods,Import_Rotation_No,BL_No,cont_number,cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
					from igm_supplimentary_detail 
					inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
					where Import_Rotation_No='$rot' and cont_number='$cont'
					order by 2";
				}
				else
				{
					$sqlContainer="select * from (SELECT igm_supplimentary_detail.id,master_BL_No,Description_of_Goods,Import_Rotation_No,BL_No,cont_number,
									cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
									FROM igm_supplimentary_detail 
									LEFT JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id					
									WHERE Import_Rotation_No='$rot' AND cont_number='$cont'
									) tbl1
									union
									select * from (SELECT shed_tally_info.igm_sup_detail_id as id,master_BL_No,Description_of_Goods,import_rotation as Import_Rotation_No,BL_No,
									shed_tally_info.cont_number, cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,
									NotifyDesc FROM shed_tally_info 
									LEFT JOIN igm_supplimentary_detail ON shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id 
									LEFT JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id 
									WHERE shed_tally_info.import_rotation='$rot' and shed_tally_info.cont_number='$cont' and BL_NO is null
									)tbl2";
				}
			}						
			else
			{
				$tbl="detail";
				if($cntExist<1)
				{
					$sqlContainer = "select igm_details.id,Import_Rotation_No,BL_No,cont_number,cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
					from igm_details 
					inner join igm_detail_container on igm_detail_container.igm_detail_id=igm_details.id
					where Import_Rotation_No='$rot' and cont_number='$cont'
					order by 2
					";
				}
				else
				{
					$sqlContainer="select * from (select igm_details.id,Import_Rotation_No,BL_No,cont_number,cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
									from igm_details 
									inner join igm_detail_container on igm_detail_container.igm_detail_id=igm_details.id
									where Import_Rotation_No='$rot' and cont_number='$cont'					
									) tbl1
									union
									select * from (SELECT shed_tally_info.igm_detail_id as id,master_BL_No,Description_of_Goods,import_rotation as Import_Rotation_No,BL_No,
									shed_tally_info.cont_number, cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,
									NotifyDesc FROM shed_tally_info 
									LEFT JOIN igm_details ON shed_tally_info.igm_detail_id=igm_details.id 
									LEFT JOIN igm_detail_container ON igm_detail_container.igm_detail_id=igm_details.id 
									WHERE shed_tally_info.import_rotation='$rot' and shed_tally_info.cont_number='$cont' and BL_NO is null
									)tbl2";
					/*$sqlContainer = "SELECT shed_tally_info.igm_detail_id as id,master_BL_No,Description_of_Goods,import_rotation as Import_Rotation_No,BL_No,shed_tally_info.cont_number,
					cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
					FROM shed_tally_info 
					LEFT JOIN igm_details  ON shed_tally_info.igm_detail_id=igm_details.id
					LEFT JOIN  igm_detail_container ON igm_detail_container.igm_detail_id=igm_details.id
					WHERE  shed_tally_info.import_rotation='$rot' and shed_tally_info.cont_number='$cont'
					ORDER BY 2";*/
				}
			}
			
			$rtnContainerList = $this->bm->dataSelectDb1($sqlContainer);			
			$data['assigned']=1;
			$data['rotation']=$rot;
			$data['cont']=$cont;
			$data['tbl']=$tbl;
				
			$data['rtnContainerList']=$rtnContainerList;
			$this->load->view('tallyEntryFormView',$data);
			//echo " TallyID : ".$tallyID;
		}
		//////////// SOURAV TALLY ENTRY NEW FORMAT END ////////////////////////
		/*
		function tallyEntryFormWithIgmContInfo()
		{	
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				if($this->input->post('rotation') && $this->input->post('cont'))
				{
					$rotation=trim($this->input->post('rotation'));
					$cont=trim($this->input->post('cont'));
					
					$cntquery="SELECT COUNT(lcl_assignment_detail.igm_detail_id) AS rtnValue
					FROM lcl_assignment_detail
					INNER JOIN igm_details ON igm_details.id=lcl_assignment_detail.igm_detail_id
					INNER JOIN igm_detail_container ON igm_detail_container.igm_detail_id=igm_details.id
					WHERE Import_Rotation_No='$rotation' AND cont_number='$cont'";
					
					$cntrslt=$this->bm->dataReturnDb1($cntquery);
					
					if($cntrslt==0)
					{
						$data['title']="TALLY ENTRY FORM WITH IGM INFORMATION...";
						$data['msg']="Please provide assignment for the container";
						$data['assigned']=0;
						$this->load->view('tallyEntryFormView',$data);
						
						return;
					} 
				}
				else
				{
					$cont=$this->uri->segment(3);
					$rot_year=$this->uri->segment(4);
					$rot_no=$this->uri->segment(5);
					$rotation=$rot_year.'/'.$rot_no;
					
					$cntquery="SELECT COUNT(lcl_assignment_detail.igm_detail_id) AS rtnValue
					FROM lcl_assignment_detail
					INNER JOIN igm_details ON igm_details.id=lcl_assignment_detail.igm_detail_id
					INNER JOIN igm_detail_container ON igm_detail_container.igm_detail_id=igm_details.id
					WHERE Import_Rotation_No='$rotation' AND cont_number='$cont'";
					
					$cntrslt=$this->bm->dataReturnDb1($cntquery);
					
					if($cntrslt==0)
					{
						$data['title']="TALLY ENTRY FORM WITH IGM INFORMATION...";
						$data['msg']="Please provide assignment for the container";
						$data['assigned']=0;
						$this->load->view('tallyEntryFormView',$data);
						
						return;
					}
				}
				
				$tbl = "sup_detail";
			
				//Cont_gross_weight and cont_seal_number added
				$sqlContainer="SELECT igm_supplimentary_detail.id,master_BL_No,Description_of_Goods,Import_Rotation_No,BL_No,cont_number,cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
				FROM igm_supplimentary_detail 
				INNER JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
				WHERE Import_Rotation_No='$rotation' AND cont_number='$cont'
				ORDER BY 2";				
				
				$rtnContainerList = $this->bm->dataSelectDb1($sqlContainer);
				$cnt = count($rtnContainerList);
				
			//	echo "count_number " . $cnt;  //finds working query
				
				//Cont_gross_weight and cont_seal_number added
				if($cnt==0)
				{
					$tbl = "detail";
					$sqlContainer = "select igm_details.id,Import_Rotation_No,BL_No,cont_number,cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
					from igm_details 
					inner join igm_detail_container on igm_detail_container.igm_detail_id=igm_details.id
					where Import_Rotation_No='$rotation' and cont_number='$cont'
					order by 2";					
					$rtnContainerList = $this->bm->dataSelectDb1($sqlContainer);
				}
				$chkExchangeDoneQuery="select count(id) as chkVal from shed_tally_info where import_rotation='$rotation' and cont_number='$cont' and exchange_done_status=1";
					//echo $chkExchangeDoneQuery;
					$chkList = $this->bm->dataSelectDb1($chkExchangeDoneQuery);
					$chkVal= $chkList[0]['chkVal'];
					if($chkVal>0)
					{
						$data['update_btn_status']=0;
						$data['view_btn_status']=1;  //previously 0; 1 for exchange done; alter if necessary
						$data['save_btn_status']=0;
						$data['exchange_btn_status']=0;
						$data['msgExchange']="Exchange Done";
					}
					else{
						$chkExchangeDoneQuery="select count(id) as chkVal from shed_tally_info where import_rotation='$rotation' and cont_number='$cont' and exchange_done_status=0";
						//echo $chkQuery;
						$chkList = $this->bm->dataSelectDb1($chkExchangeDoneQuery);
						$chkVal= $chkList[0]['chkVal'];
						if($chkVal>0)
						{
							$data['update_btn_status']=1;
							$data['view_btn_status']=1;
							$data['exchange_btn_status']=1;
							$data['save_btn_status']=0;
						}
						else{
							$data['update_btn_status']=0;
							$data['view_btn_status']=0;
							$data['exchange_btn_status']=0;
							$data['save_btn_status']=1;
						}
					}
				$login_id = $this->session->userdata('login_id');
				$data['assigned']=1;		
				$data['rotation']=$rotation;
				$data['tbl']=$tbl;
				$data['cont']=$cont;
				$data['stat']="";
				$data['login_id']=$login_id;
				$data['rtnContainerList']=$rtnContainerList; //"$rtnContainerList" returns selected data for table
				$this->load->view('tallyEntryFormView',$data);
			}
		}
		
		function updateTallyInfo()
		{
			$rot=$this->input->post('rot');
				$cont=$this->input->post('cont');
				
				$tally_sheet_noQuery="select MAX(tally_sheet_no) as rtnValue from shed_tally_info";
				$tally_sheet_no = $this->bm->dataReturnDb1($tally_sheet_noQuery);
				$maxtally_sheet_no = $tally_sheet_no+1;
				
				for($i=0;$i<$this->input->post('tblRow');$i++)
				{
					$rcv=$this->input->post('rcv'.$i);
					$flt=$this->input->post('flt'.$i);
					$conLocFast=$this->input->post('conLocFast'.$i);
					$totalPck=$this->input->post('totalPck'.$i);
					$loc=$this->input->post('contAtShed'.$i);
					$wrDate=$this->input->post('wrDate');
					$remark=$this->input->post('remark'.$i); //remarks added
					
					$shiftname=$this->input->post('shiftname'.$i);  //combo box shift name
					$actualmarks=$this->input->post('actualmarks'.$i);  //textarea actual marks	
					$tbl=$this->input->post('tbl'.$i);
					$ipaddr = $_SERVER['REMOTE_ADDR'];
					$login_id = $this->session->userdata('login_id');
					$section = $this->session->userdata('section');
					$supId=$this->input->post('dtlId'.$i);
					$rcv_unit=$this->input->post('rcv_unit'.$i);
					//$chkQuery="select count(id) as chkVal from shed_tally_info where import_rotation='$rot' and cont_number='$cont' ";
					//echo $chkQuery;
					//$chkList = $this->bm->dataSelectDb1($chkQuery);
					//$chkVal= $chkList[0]['chkVal'];
					$tallysheet=$this->input->post('tallySheetNumber');
					$str = "";
					if($tallysheet!="")
					{
						//$tallysheet=$this->input->post('tallysheet'.$i);
						if($tbl=="sup_detail")
						{
							$str = "update shed_tally_info set rcv_pack='$rcv'
									,flt_pack='$flt',shed_loc='$loc',update_by='$login_id',ip_addr='$ipaddr',remarks='$remark',last_update=now(),
									shift_name='$shiftname',actual_marks='$actualmarks',loc_first=$conLocFast,total_pack=$totalPck,
									wr_date='$wrDate',shed_yard='$section',rcv_unit='$rcv_unit'
									where igm_sup_detail_id='$supId' and import_rotation='$rot' and cont_number='$cont'";
							//echo $str;
						}
						else
						{
							$str = "update shed_tally_info set rcv_pack='$rcv'
									,flt_pack='$flt',shed_loc='$loc',update_by='$login_id',ip_addr='$ipaddr',remarks='$remark',last_update=now(),
									shift_name='$shiftname',actual_marks='$actualmarks',loc_first=$conLocFast,
									total_pack=$totalPck,wr_date='$wrDate',shed_yard='$section',rcv_unit='$rcv_unit' 
									where igm_detail_id='$supId' and import_rotation='$rot' and cont_number='$cont'";
							//echo $str;
						}
					
						$stat = $this->bm->dataInsertDB1($str);  //comment out to stop insertion
						if($stat==1)
						{
							$data['stat']="<font color='red'><b>Sucessfully Updated</b></font>";
							$data['update_btn_status']=1;
							$data['view_btn_status']=1;
							$data['exchange_btn_status']=1;
						}
						else
						{
							$data['stat']="<font color='red'><b>Not Updated</b></font>";
						}
					}
					else{
						
						
						
						$date = date('dmy');
        
						$size=strlen($maxtally_sheet_no);
						$tallySheetNumber = "";
						if($size==1)
						{
					//	 $tallySheetNumber="TSN"."-".$date."000".$maxtally_sheet_no;
						 $tallySheetNumber=$section."-".$date."000".$maxtally_sheet_no;
						}
						else if($size==2)
						{
					//	 $tallySheetNumber="TSN"."-".$date."00".$maxtally_sheet_no;
						 $tallySheetNumber=$section."-".$date."00".$maxtally_sheet_no;
						}
						else if($size==3)
						{
					//	 $tallySheetNumber="TSN"."-".$date."0".$maxtally_sheet_no;
						 $tallySheetNumber=$section."-".$date."0".$maxtally_sheet_no;
						}
						else 
						{
					//	 $tallySheetNumber="TSN"."-".$date."".$maxtally_sheet_no;
						 $tallySheetNumber=$section."-".$date."".$maxtally_sheet_no;
						}
						
						
						if($tbl=="sup_detail")
						{
							$str = "insert into shed_tally_info(igm_sup_detail_id,import_rotation,cont_number,rcv_pack,flt_pack,shed_loc,update_by,ip_addr,remarks,last_update,tally_sheet_no,shift_name,actual_marks,loc_first,total_pack,wr_date,shed_yard,rcv_unit,tally_sheet_number)
							values('$supId','$rot','$cont','$rcv','$flt','$loc','$login_id','$ipaddr','$remark',now(),
							'$maxtally_sheet_no','$shiftname','$actualmarks',$conLocFast,$totalPck,'$wrDate','$section','$rcv_unit','$tallySheetNumber')";
						}
						else
						{
							$str = "insert into shed_tally_info(igm_detail_id,import_rotation,cont_number,rcv_pack,flt_pack,shed_loc,update_by,ip_addr,remarks,last_update,tally_sheet_no,shift_name,actual_marks,loc_first,total_pack,wr_date,shed_yard,rcv_unit,tally_sheet_number)
							values('$supId','$rot','$cont','$rcv','$flt','$loc','$login_id','$ipaddr','$remark',now(),
							'$maxtally_sheet_no','$shiftname','$actualmarks',$conLocFast,$totalPck,'$wrDate','$section','$rcv_unit','$tallySheetNumber')";
						}
					
						$stat = $this->bm->dataInsertDB1($str);  //comment out to stop insertion
						if($stat==1)
						{
							$data['stat']="<font color='red'><b>Sucessfully inserted</b></font>";
							//$data['update_btn_status']=1;
							$data['update_btn_status']=1;
							$data['view_btn_status']=1;
							$data['exchange_btn_status']=1;
							$data['save_btn_status']=0;
						}
						else
						{
							$data['stat']="<font color='red'><b>Not inserted</b></font>";
						}
					}
						if($tbl=="sup_detail")
						{
							$sqlContainer = "select igm_supplimentary_detail.id,master_BL_No,Description_of_Goods,Import_Rotation_No,BL_No,cont_number,cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
							from igm_supplimentary_detail 
							inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
							where Import_Rotation_No='$rot' and cont_number='$cont'
							order by 2";
						}
						
						else
						{
							$sqlContainer = "select igm_details.id,Import_Rotation_No,BL_No,cont_number,cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
								from igm_details 
								inner join igm_detail_container on igm_detail_container.igm_detail_id=igm_details.id
								where Import_Rotation_No='$rotation' and cont_number='$cont'
								order by 2
								";	
						}
					//echo "Rcv".$rcv."Flt".$flt."Loc".$conLocFast."Tot".$totalPck."\n";
				}
				
				$rtnContainerList = $this->bm->dataSelectDb1($sqlContainer);			
				$data['assigned']=1;
				$data['rotation']=$rot;
				$data['cont']=$cont;
				$data['tbl']=$tbl;
				
				$data['rtnContainerList']=$rtnContainerList;
				$this->load->view('tallyEntryFormView',$data);
		}*/
		/*function tallyEntryFormWithIgmContInfo()
		{	
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				if($this->input->post('rotation') && $this->input->post('cont'))
				{
					$rotation=trim($this->input->post('rotation'));
					$cont=trim($this->input->post('cont'));
					
					$cntquery="SELECT COUNT(lcl_assignment_detail.igm_detail_id) AS rtnValue
					FROM lcl_assignment_detail
					INNER JOIN igm_details ON igm_details.id=lcl_assignment_detail.igm_detail_id
					INNER JOIN igm_detail_container ON igm_detail_container.igm_detail_id=igm_details.id
					WHERE Import_Rotation_No='$rotation' AND cont_number='$cont'";
					
					$cntrslt=$this->bm->dataReturnDb1($cntquery);
					
					
					if($cntrslt==0)
					{
						$data['title']="TALLY ENTRY FORM WITH IGM INFORMATION...";
						$data['msg']="Please provide assignment for the container";
						$data['assigned']=0;
						$this->load->view('tallyEntryFormView',$data);
						
						return;
					} 
				}
				else
				{
					$cont=$this->uri->segment(3);
					$rot_year=$this->uri->segment(4);
					$rot_no=$this->uri->segment(5);
					$rotation=$rot_year.'/'.$rot_no;
					
					$cntquery="SELECT COUNT(lcl_assignment_detail.igm_detail_id) AS rtnValue
					FROM lcl_assignment_detail
					INNER JOIN igm_details ON igm_details.id=lcl_assignment_detail.igm_detail_id
					INNER JOIN igm_detail_container ON igm_detail_container.igm_detail_id=igm_details.id
					WHERE Import_Rotation_No='$rotation' AND cont_number='$cont'";
					
					$cntrslt=$this->bm->dataReturnDb1($cntquery);
					
					if($cntrslt==0)
					{
						$data['title']="TALLY ENTRY FORM WITH IGM INFORMATION...";
						$data['msg']="Please provide assignment for the container";
						$data['assigned']=0;
						$this->load->view('tallyEntryFormView',$data);
						
						return;
					}
				}
				
				$chkExistShedTallyQry="select count(id) as id from shed_tally_info WHERE  import_rotation='$rotation' and cont_number='$cont'";
				$rtnExistShedTally = $this->bm->dataSelectDb1($chkExistShedTallyQry);
				$cntExist = $rtnExistShedTally[0]['id'];
				
				//echo $cntExist;
				//echo $chkExistShedTallyQry;
				
				$tbl = "sup_detail";
			
				//Cont_gross_weight and cont_seal_number added
				if($cntExist<1)
				{
					$sqlContainer="SELECT igm_supplimentary_detail.id,master_BL_No,Description_of_Goods,Import_Rotation_No,BL_No,cont_number,cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
					FROM igm_supplimentary_detail 
					LEFT JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id					
					WHERE Import_Rotation_No='$rotation' AND cont_number='$cont'
					ORDER BY 2";
				}
				else
				{
					$sqlContainer="SELECT shed_tally_info.igm_sup_detail_id as id,master_BL_No,Description_of_Goods,import_rotation as Import_Rotation_No,BL_No,shed_tally_info.cont_number,
								cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
								FROM shed_tally_info 
								LEFT JOIN igm_supplimentary_detail  ON shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
								LEFT JOIN  igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
								WHERE  shed_tally_info.import_rotation='$rotation' and shed_tally_info.cont_number='$cont'
								ORDER BY 2";
				}
				//echo $sqlContainer;
				
				$rtnContainerList = $this->bm->dataSelectDb1($sqlContainer);
				$cnt = count($rtnContainerList);
				//echo "ee : ".$cnt."--".$sqlContainer;
				
			//	echo "count_number " . $cnt;  //finds working query
				
				//Cont_gross_weight and cont_seal_number added
				if($cnt==0)
				{
					$tbl = "detail";
					if($cntExist<1)
					{
						$sqlContainer = "select igm_details.id,Import_Rotation_No,BL_No,cont_number,cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
						from igm_details 
						LEFT join igm_detail_container on igm_detail_container.igm_detail_id=igm_details.id
						where Import_Rotation_No='$rotation' and cont_number='$cont'
						order by 2";
					}
					else {
						$sqlContainer = "SELECT shed_tally_info.igm_detail_id as id,master_BL_No,Description_of_Goods,import_rotation as Import_Rotation_No,BL_No,shed_tally_info.cont_number,
									cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
									FROM shed_tally_info 
									LEFT JOIN igm_details  ON shed_tally_info.igm_detail_id=igm_details.id
									LEFT JOIN  igm_detail_container ON igm_detail_container.igm_detail_id=igm_details.id
									WHERE  shed_tally_info.import_rotation='$rotation' and shed_tally_info.cont_number='$cont'
									ORDER BY 2";
					}
					$rtnContainerList = $this->bm->dataSelectDb1($sqlContainer);
				}
				$chkExchangeDoneQuery="select count(id) as chkVal from shed_tally_info where import_rotation='$rotation' and cont_number='$cont' and exchange_done_status=1";
					//echo $chkExchangeDoneQuery;
					$chkList = $this->bm->dataSelectDb1($chkExchangeDoneQuery);
					$chkVal= $chkList[0]['chkVal'];
					if($chkVal>0)
					{
						$data['update_btn_status']=0;
						$data['view_btn_status']=1;  //previously 0; 1 for exchange done; alter if necessary
						$data['save_btn_status']=0;
						$data['exchange_btn_status']=0;
						$data['msgExchange']="Exchange Done";
					}
					else{
						$chkExchangeDoneQuery="select count(id) as chkVal from shed_tally_info where import_rotation='$rotation' and cont_number='$cont' and exchange_done_status=0";
						//echo $chkQuery;
						$chkList = $this->bm->dataSelectDb1($chkExchangeDoneQuery);
						$chkVal= $chkList[0]['chkVal'];
						if($chkVal>0)
						{
							$data['update_btn_status']=1;
							$data['view_btn_status']=1;
							$data['exchange_btn_status']=1;
							$data['save_btn_status']=0;
						}
						else{
							$data['update_btn_status']=0;
							$data['view_btn_status']=0;
							$data['exchange_btn_status']=0;
							$data['save_btn_status']=1;
						}
					}
				$login_id = $this->session->userdata('login_id');
				
				
				
				
				
				$data['assigned']=1;		
				$data['rotation']=$rotation;
				$data['tbl']=$tbl;
				$data['cont']=$cont;
				$data['stat']="";
				$data['login_id']=$login_id;
				
				
				$data['rtnContainerList']=$rtnContainerList; //"$rtnContainerList" returns selected data for table
				$this->load->view('tallyEntryFormView',$data);
			}
		}*/
		function updateTallyInfo()
		{
				$rot=$this->input->post('rot');
				$cont=$this->input->post('cont');
				
				$tally_sheet_noQuery="select MAX(tally_sheet_no) as rtnValue from shed_tally_info";
				$tally_sheet_no = $this->bm->dataReturnDb1($tally_sheet_noQuery);
				
				$igmDetailQuery="select MAX(id) as rtnValue from shed_tally_info";				
				$igmDetailId = $this->bm->dataReturnDb1($igmDetailQuery);
				
				$maxtally_sheet_no = $tally_sheet_no+1;
				$igmDetailId_no = $igmDetailId+1;
				
				$date = date('dmy');
				$dtlDate = date('my');
        
				$size=strlen($maxtally_sheet_no);
				$tallySheetNumber = "";
				$igmDetailNumber = "";
				
				
				
				
				for($i=0;$i<$this->input->post('tblRow');$i++)
				{
					$rcv=$this->input->post('rcv'.$i);
					$flt=$this->input->post('flt'.$i);
					$conLocFast=$this->input->post('conLocFast'.$i);
					$totalPck=$this->input->post('totalPck'.$i);
					$loc=$this->input->post('contAtShed'.$i);
					$wrDate=$this->input->post('wrDate');
					$remark=$this->input->post('remark'.$i); //remarks added
					
					$shiftname=$this->input->post('shiftname'.$i);  //combo box shift name
					$actualmarks=$this->input->post('actualmarks'.$i);  //textarea actual marks	
					$tbl=$this->input->post('tbl'.$i);
					$ipaddr = $_SERVER['REMOTE_ADDR'];
					$login_id = $this->session->userdata('login_id');
					$section = $this->session->userdata('section');
					$supId=$this->input->post('dtlId'.$i);
					$rcv_unit=$this->input->post('rcv_unit'.$i);
					//$chkQuery="select count(id) as chkVal from shed_tally_info where import_rotation='$rot' and cont_number='$cont' ";
					//echo $chkQuery;
					//$chkList = $this->bm->dataSelectDb1($chkQuery);
					//$chkVal= $chkList[0]['chkVal'];
					$tallysheet=$this->input->post('tallySheetNumber');
					$tallysheetNo=$this->input->post('maxTallyNo');
					
				if($size==1)
				{
				//	 $tallySheetNumber="TSN"."-".$date."000".$maxtally_sheet_no;
					 $tallySheetNumber=$section."-".$date."000".$maxtally_sheet_no;
					 $igmDetailNumber=$dtlDate.$maxtally_sheet_no.$igmDetailId_no;
				}
				else if($size==2)
				{
				//	 $tallySheetNumber="TSN"."-".$date."00".$maxtally_sheet_no;
					$tallySheetNumber=$section."-".$date."00".$maxtally_sheet_no;
					$igmDetailNumber=$dtlDate.$maxtally_sheet_no.$igmDetailId_no;
				}
				else if($size==3)
				{
				//	 $tallySheetNumber="TSN"."-".$date."0".$maxtally_sheet_no;
					 $tallySheetNumber=$section."-".$date."0".$maxtally_sheet_no;
					 $igmDetailNumber=$dtlDate.$maxtally_sheet_no.$igmDetailId_no;
				}
				else 
				{
				//	 $tallySheetNumber="TSN"."-".$date."".$maxtally_sheet_no;
					$tallySheetNumber=$section."-".$date."".$maxtally_sheet_no;
					$igmDetailNumber=$dtlDate.$maxtally_sheet_no.$igmDetailId_no;
				}
					$str = "";
					if($tallysheet!="")
					{
						//$tallysheet=$this->input->post('tallysheet'.$i);
						if($tbl=="sup_detail")
						{
							if($supId=="" || $supId==0)
							{
								if($rcv!=0 || $flt!=0 || $conLocFast!=0 || $totalPck!=0)
								{
									$str = "insert into shed_tally_info(igm_sup_detail_id,import_rotation,cont_number,rcv_pack,flt_pack,shed_loc,update_by,ip_addr,remarks,last_update,tally_sheet_no,shift_name,actual_marks,loc_first,total_pack,wr_date,shed_yard,rcv_unit,tally_sheet_number)
										values('$igmDetailNumber','$rot','$cont','$rcv','$flt','$loc','$login_id','$ipaddr','$remark',now(),
										'$tallysheetNo','$shiftname','$actualmarks',$conLocFast,$totalPck,'$wrDate','$section','$rcv_unit','$tallysheet')";
								}
								else{
									
									$getPreviousQtyDtl="select rcv_pack,flt_pack,loc_first,total_pack from shed_tally_info where igm_sup_detail_id='$supId' and import_rotation='$rot' and cont_number='$cont'";
									$rtnPreviousQtyList = $this->bm->dataSelectDb1($getPreviousQtyDtl);
									
									$chngRcvPack=$rtnPreviousQtyList[0]['rcv_pack'] + $rcv;
									$chngFltPack=$rtnPreviousQtyList[0]['flt_pack'] + $flt;
									$chngLocFastPack=$rtnPreviousQtyList[0]['loc_first'] + $conLocFast;
									$chngTotalPack=$rtnPreviousQtyList[0]['total_pack'] + $totalPck;
									
									//echo "Total : ".$previousRcvPack;
									
									$str = "update shed_tally_info set rcv_pack='$chngRcvPack'
									,flt_pack='$chngFltPack',shed_loc='$loc',update_by='$login_id',ip_addr='$ipaddr',remarks='$remark',last_update=now(),
									shift_name='$shiftname',actual_marks='$actualmarks',loc_first=$chngLocFastPack,total_pack=$chngTotalPack,
									wr_date='$wrDate',shed_yard='$section',rcv_unit='$rcv_unit'
									where igm_sup_detail_id='$supId' and import_rotation='$rot' and cont_number='$cont'";
								}
							}
							else
							{
									$getPreviousQtyDtl="select rcv_pack,flt_pack,loc_first,total_pack from shed_tally_info where igm_sup_detail_id='$supId' and import_rotation='$rot' and cont_number='$cont'";
									$rtnPreviousQtyList = $this->bm->dataSelectDb1($getPreviousQtyDtl);
									$chngRcvPack=$rtnPreviousQtyList[0]['rcv_pack'] + $rcv;
									$chngFltPack=$rtnPreviousQtyList[0]['flt_pack'] + $flt;
									$chngLocFastPack=$rtnPreviousQtyList[0]['loc_first'] + $conLocFast;
									$chngTotalPack=$rtnPreviousQtyList[0]['total_pack'] + $totalPck;
									
									//echo "Total : ".$previousRcvPack1;
									
								$str = "update shed_tally_info set rcv_pack='$chngRcvPack'
									,flt_pack='$chngFltPack',shed_loc='$loc',update_by='$login_id',ip_addr='$ipaddr',remarks='$remark',last_update=now(),
									shift_name='$shiftname',actual_marks='$actualmarks',loc_first=$chngLocFastPack,total_pack=$chngTotalPack,
									wr_date='$wrDate',shed_yard='$section',rcv_unit='$rcv_unit'
									where igm_sup_detail_id='$supId' and import_rotation='$rot' and cont_number='$cont'";
							}
							//echo $str;
						}
						else
						{
							if($supId=="" || $supId==0)
							{
								$str = "insert into shed_tally_info(igm_detail_id,import_rotation,cont_number,rcv_pack,flt_pack,shed_loc,update_by,ip_addr,remarks,last_update,tally_sheet_no,shift_name,actual_marks,loc_first,total_pack,wr_date,shed_yard,rcv_unit,tally_sheet_number)
										values('$igmDetailNumber','$rot','$cont','$rcv','$flt','$loc','$login_id','$ipaddr','$remark',now(),
										'$tallysheetNo','$shiftname','$actualmarks',$conLocFast,$totalPck,'$wrDate','$section','$rcv_unit','$tallysheet')";
							}
							else
							{
								$str = "update shed_tally_info set rcv_pack='$rcv'
									,flt_pack='$flt',shed_loc='$loc',update_by='$login_id',ip_addr='$ipaddr',remarks='$remark',last_update=now(),
									shift_name='$shiftname',actual_marks='$actualmarks',loc_first=$conLocFast,
									total_pack=$totalPck,wr_date='$wrDate',shed_yard='$section',rcv_unit='$rcv_unit' 
									where igm_detail_id='$supId' and import_rotation='$rot' and cont_number='$cont'";
							}
							//echo $str;
						}
						//echo $str;
						$stat = $this->bm->dataInsertDB1($str);  //comment out to stop insertion
						if($stat==1)
						{
							$data['stat']="<font color='red'><b>Sucessfully Updated</b></font>";
							$data['update_btn_status']=1;
							$data['view_btn_status']=1;
							$data['exchange_btn_status']=1;
							$data['save_btn_status']=0;

						}
						else
						{
							$data['stat']="<font color='red'><b>Not Updated</b></font>";
						}
					}
					else{
						if($tbl=="sup_detail")
						{
								if($supId=="" || $supId==0)
								{
									$str = "insert into shed_tally_info(igm_sup_detail_id,import_rotation,cont_number,rcv_pack,flt_pack,shed_loc,update_by,ip_addr,remarks,last_update,tally_sheet_no,shift_name,actual_marks,loc_first,total_pack,wr_date,shed_yard,rcv_unit,tally_sheet_number)
									values('$igmDetailNumber','$rot','$cont','$rcv','$flt','$loc','$login_id','$ipaddr','$remark',now(),
									'$maxtally_sheet_no','$shiftname','$actualmarks',$conLocFast,$totalPck,'$wrDate','$section','$rcv_unit','$tallySheetNumber')";
								}
								else
								{
									$str = "insert into shed_tally_info(igm_sup_detail_id,import_rotation,cont_number,rcv_pack,flt_pack,shed_loc,update_by,ip_addr,remarks,last_update,tally_sheet_no,shift_name,actual_marks,loc_first,total_pack,wr_date,shed_yard,rcv_unit,tally_sheet_number)
									values('$supId','$rot','$cont','$rcv','$flt','$loc','$login_id','$ipaddr','$remark',now(),
									'$maxtally_sheet_no','$shiftname','$actualmarks',$conLocFast,$totalPck,'$wrDate','$section','$rcv_unit','$tallySheetNumber')";
								}
						}
						else
						{
							$str = "insert into shed_tally_info(igm_detail_id,import_rotation,cont_number,rcv_pack,flt_pack,shed_loc,update_by,ip_addr,remarks,last_update,tally_sheet_no,shift_name,actual_marks,loc_first,total_pack,wr_date,shed_yard,rcv_unit,tally_sheet_number)
							values('$supId','$rot','$cont','$rcv','$flt','$loc','$login_id','$ipaddr','$remark',now(),
							'$maxtally_sheet_no','$shiftname','$actualmarks',$conLocFast,$totalPck,'$wrDate','$section','$rcv_unit','$tallySheetNumber')";
						}
					
						$stat = $this->bm->dataInsertDB1($str);  //comment out to stop insertion
						if($stat==1)
						{
							$data['stat']="<font color='red'><b>Sucessfully inserted</b></font>";
							//$data['update_btn_status']=1;
							$data['update_btn_status']=1;
							$data['view_btn_status']=1;
							$data['exchange_btn_status']=1;
							$data['save_btn_status']=0;
						}
						else
						{
							$data['stat']="<font color='red'><b>Not inserted</b></font>";
						}
					}
					$chkExistShedTallyQry="select count(id) from shed_tally_info WHERE  import_rotation='$rot' and cont_number='$cont'";
					$rtnExistShedTally = $this->bm->dataSelectDb1($chkExistShedTallyQry);
					$cntExist = count($rtnExistShedTally);
					
						if($tbl=="sup_detail")
						{
							if($cntExist<1)
							{
								$sqlContainer = "select igm_supplimentary_detail.id,master_BL_No,Description_of_Goods,Import_Rotation_No,BL_No,cont_number,cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
								from igm_supplimentary_detail 
								inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
								where Import_Rotation_No='$rot' and cont_number='$cont'
								order by 2";
							}
							else{
								$sqlContainer="SELECT shed_tally_info.igm_sup_detail_id as id,master_BL_No,Description_of_Goods,import_rotation as Import_Rotation_No,BL_No,shed_tally_info.cont_number,
								cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
								FROM shed_tally_info 
								LEFT JOIN igm_supplimentary_detail  ON shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
								LEFT JOIN  igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
								WHERE  shed_tally_info.import_rotation='$rot' and shed_tally_info.cont_number='$cont'
								ORDER BY 2";
							}
						}
						
						else
						{
							if($cntExist<1)
							{
								$sqlContainer = "select igm_details.id,Import_Rotation_No,BL_No,cont_number,cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
								from igm_details 
								inner join igm_detail_container on igm_detail_container.igm_detail_id=igm_details.id
								where Import_Rotation_No='$rot' and cont_number='$cont'
								order by 2
								";
							}
							else
							{
								$sqlContainer = "SELECT shed_tally_info.igm_detail_id as id,master_BL_No,Description_of_Goods,import_rotation as Import_Rotation_No,BL_No,shed_tally_info.cont_number,
									cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
									FROM shed_tally_info 
									LEFT JOIN igm_details  ON shed_tally_info.igm_detail_id=igm_details.id
									LEFT JOIN  igm_detail_container ON igm_detail_container.igm_detail_id=igm_details.id
									WHERE  shed_tally_info.import_rotation='$rot' and shed_tally_info.cont_number='$cont'
									ORDER BY 2";
							}
						}
					//echo "Rcv".$rcv."Flt".$flt."Loc".$conLocFast."Tot".$totalPck."\n";
				}
				
				$rtnContainerList = $this->bm->dataSelectDb1($sqlContainer);			
				$data['assigned']=1;
				$data['rotation']=$rot;
				$data['cont']=$cont;
				$data['tbl']=$tbl;
				
				$data['rtnContainerList']=$rtnContainerList;
				$this->load->view('tallyEntryFormView',$data);
		}
			// LCL Certify Section000
		function lclAssignmentCertifySection(){
		
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$data['msg']="";
				$data['unstuff_flag']="";
				$data['verify_number']="-1";
				$data['title']="LCL ASSINGMENT CERTIFY SECTION...";
				$this->load->view('header5');
				$this->load->view('lclAssignmentCertifySectionHTML',$data);
				$this->load->view('footer_1');
			}	
		
		}
		
		Function lclAssignmentCertifyList(){
			
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
		
			 $ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
			 $ddl_bl_no=$this->input->post('ddl_bl_no');
			
			
			/*$sqlContainer="select * from (select distinct lcl_assignment_detail.id,lcl_assignment_detail.verify_number,igm_details.BL_No,igm_detail_container.igm_detail_id,igm_detail_container.cont_number,igm_details.Import_Rotation_No,lcl_assignment_detail.cont_loc_shed,
							(select Vessel_Name from igm_masters where igm_masters.id=igm_details.IGM_id) as vsl_name
								from igm_detail_container
								INNER JOIN lcl_assignment_detail ON igm_detail_container.id=lcl_assignment_detail.igm_cont_detail_id
								INNER JOIN igm_details ON igm_detail_container.igm_detail_id=igm_details.id
								WHERE igm_detail_container.cont_number='$ddl_imp_cont_no' and lcl_assignment_detail.unstuff_flag=1) tbl1
								inner join
								(
								select * from 
								(select igm_supplimentary_detail.id as igm_sup_dtl_id,cont_number,cont_size,cont_seal_number,cont_status,cont_height,cont_iso_type,off_dock_id,cont_location_code,
								igm_supplimentary_detail.Pack_Marks_Number,igm_supplimentary_detail.NotifyDesc,igm_supplimentary_detail.ConsigneeDesc,
								(select Organization_Name from organization_profiles where organization_profiles.id=igm_sup_detail_container.off_dock_id) as offdock_name
								from igm_sup_detail_container 
								inner join igm_supplimentary_detail on
								igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
								where cont_number='$ddl_imp_cont_no')as tbl) as tbl2
								on 
								tbl1.cont_number=tbl2.cont_number";*/
								/*$sqlContainer="select igm_supplimentary_detail.id,IFNULL(sum(rcv_pack),0) as rcv_pack,igm_sup_detail_container.cont_number,igm_supplimentary_detail.Import_Rotation_No,Pack_Marks_Number,shed_loc,
												Description_of_Goods,ConsigneeDesc,NotifyDesc,cont_size,cont_weight,cont_seal_number,cont_status,cont_height,cont_iso_type,shed_tally_info.verify_number,
												shed_tally_info.wr_upto_date,shed_tally_info.verify_by,shed_tally_info.verify_time,
												(select Organization_Name from organization_profiles where organization_profiles.id=igm_sup_detail_container.off_dock_id) as offdock_name 
												from  igm_supplimentary_detail
												inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
												left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
												where igm_sup_detail_container.cont_number='$ddl_imp_cont_no' 
												group by igm_sup_detail_container.id";*/
								$sqlContainer="select igm_supplimentary_detail.id,IFNULL(sum(rcv_pack)+sum(loc_first),0) as rcv_pack,igm_sup_detail_container.cont_number,igm_supplimentary_detail.Import_Rotation_No,Pack_Marks_Number,shed_loc,shed_yard,
												Description_of_Goods,ConsigneeDesc,NotifyDesc,cont_size,cont_weight,cont_seal_number,cont_status,cont_height,cont_iso_type,IFNULL(shed_tally_info.verify_number,0) as verify_number,
												shed_tally_info.wr_upto_date,shed_tally_info.verify_by,shed_tally_info.verify_time,shed_tally_info.wr_upto_date,IFNULL(shed_tally_info.id,0) as verify_id,
												(select Organization_Name from organization_profiles where organization_profiles.id=igm_sup_detail_container.off_dock_id) as offdock_name,
													agent_do,do_date,be_no,be_date,cnf_lic_no,update_ton,cnf_name
													from  igm_supplimentary_detail
													inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
													left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
													left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
													where igm_supplimentary_detail.Import_Rotation_No='$ddl_imp_rot_no' and igm_supplimentary_detail.BL_No='$ddl_bl_no'
													group by igm_sup_detail_container.id";
			
			//echo $sqlContainer;
			$rtnContainerList = $this->bm->dataSelectDb1($sqlContainer);
			$data['rtnContainerList']=$rtnContainerList;
			
			$containerNo=$rtnContainerList[0]['cont_number'];
			$verify_id=$rtnContainerList[0]['verify_id'];
			$verify_num=$rtnContainerList[0]['verify_number'];
			$cnf_lic_no=$rtnContainerList[0]['cnf_lic_no'];
			
			$cnf_licQuery="SELECT name from ref_bizunit_scoped where id='$cnf_lic_no'";
			$rtnCnfName = $this->bm->dataSelect($cnf_licQuery);
			$cnf_name=$rtnCnfName[0]['name'];
			
			
			$strID = "select count(*) as rtnValue from sparcsn4.inv_unit
				inner join sparcsn4.srv_event on sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey
				where id='$containerNo' and  category='IMPRT' and event_type_gkey=30";
			$rtnValue = $this->bm->dataReturn($strID);
			
			if($rtnValue<1)
			{
				$msg="<font color='red'><b>CARGO IS NOT UNSTUFFED.</b></font>";
			}
			else
			{
				if($verify_id==0)
				{
					$msg="<font color='red'><b>NOT VERIFIED YET</b></font>";
				}
			}
			
			$data['unstuff_flag']=$rtnValue;
			$data['verify_id']=$verify_id;
			$data['verify_num']=$verify_num;
			$data['cnf_name']=$cnf_name;
			$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
			$data['ddl_bl_no']=$ddl_bl_no;
			$data['msg']=$msg;
			$data['title']="LCL ASSINGMENT CERTIFY SECTION...";
			$this->load->view('header5');
			$this->load->view('lclAssignmentCertifySectionHTML',$data);
			$this->load->view('footer_1');
		}
	}
	 function lclAssignmentVerify()
	{
		$session_id = $this->session->userdata('value');
		//$lclID=$this->input->post('lclID');
		//$igm_sup_detail_id=$this->uri->segment(3);
		//$cont=$this->uri->segment(4);
		$igm_sup_detail_id=$this->input->post('id');
		//$cont=$this->input->post('cont_number');
		//$wr_out_date=$this->uri->segment(5);
		//$wr_out_date=$this->input->post('wrDate');
		$cnfLicense=$this->input->post('strCnfLicense');
		$strCnfCode=$this->input->post('strCnfCode');
		$agent_do=$this->input->post('strAgentDo');
		$do_date=$this->input->post('strDoDate');
		$be_no=$this->input->post('strBEno');
		$be_date=$this->input->post('strBEdate');
		$wr_out_date=$this->input->post('strWRdate');
		
		$verify_rot=$this->input->post('verify_rot');
		$verify_bl=$this->input->post('verify_bl');
		
		$verify_num=$this->input->post('verify_num');		
		$verify_id=$this->input->post('verify_id');
		
		$strTonUpdt=$this->input->post('strTonUpdt');
		
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$login_id = $this->session->userdata('login_id');
				$ipaddr = $_SERVER['REMOTE_ADDR'];
				
				if($verify_num=="" or $verify_num==0)
				{
					$VerifyNoQuery="select MAX(verify_number) as rtnValue from shed_tally_info";
					$VerifyNo = $this->bm->dataReturnDb1($VerifyNoQuery);
					$maxVerifyNo = $VerifyNo+1;
								
					//echo "Date : ".$wr_out_date;
					//echo "VerifyNo : ".$cont;

					$strUpdateEq = "update shed_tally_info set wr_upto_date='$wr_out_date',verify_number=$maxVerifyNo,verify_by='$login_id',verify_time=NOW() 
									where id='$verify_id'";
				
					$statUp = $this->bm->dataInsertDB1($strUpdateEq);
					
					$AfterUpdateShedIdQuery="select id as rtnValue from shed_tally_info where verify_number='$maxVerifyNo'";
					$AfterUpdateShedId = $this->bm->dataReturnDb1($AfterUpdateShedIdQuery);
					$AfterUpdateMaxShedId = $AfterUpdateShedId;
					
					$strInsertVerifyOther = "insert into verify_other_data (shed_tally_id,agent_do,do_date,be_no,be_date,cnf_lic_no,update_ton,last_update,update_by,user_ip,cnf_name) 
									values ('$AfterUpdateMaxShedId','$agent_do','$do_date','$be_no','$be_date','$cnfLicense','$strTonUpdt',NOW(),'$login_id','$ipaddr','$strCnfCode')";
				
					$stat = $this->bm->dataInsertDB1($strInsertVerifyOther);
					
					$data['msg']="";
					if($stat==1)
						$msg="<font color='green'><b>LCL ASSIGNMENT VERIFIED SUCCESSFULLY FOR : </font>".$maxVerifyNo;
					else
						$msg="<font color='red'><b>NOT INSERTED.<font color='red'><b>";
				}
				else
				{
					
					
					$strInsertTally= "UPDATE  shed_tally_info 
											set wr_upto_date='$wr_out_date'
											WHERE id='$verify_id'";
				
					$stat = $this->bm->dataInsertDB1($strInsertTally);
					
					$strInsertVerifyOther = "UPDATE  verify_other_data 
											set agent_do='$agent_do',cnf_name='$strCnfCode',do_date='$do_date',be_no='$be_no',be_date='$be_date',cnf_lic_no='$cnfLicense',update_ton='$strTonUpdt'
											WHERE shed_tally_id='$verify_id'";
				
					$stat1 = $this->bm->dataInsertDB1($strInsertVerifyOther);
					
					$data['msg']="";
					if($stat1==1)
						$msg="<font color='green'><b>LCL ASSIGNMENT UPDATED SUCCESSFULLY.</font>";
					else
						$msg="<font color='red'><b>NOT UPDATED.</font>";
				}
				
				$sqlContainer="select igm_supplimentary_detail.id,IFNULL(sum(rcv_pack)+sum(loc_first),0) as rcv_pack,igm_sup_detail_container.cont_number,igm_supplimentary_detail.Import_Rotation_No,Pack_Marks_Number,shed_loc,
												Description_of_Goods,ConsigneeDesc,NotifyDesc,cont_size,cont_weight,cont_seal_number,cont_status,cont_height,cont_iso_type,IFNULL(shed_tally_info.verify_number,0) as verify_number,
												shed_tally_info.wr_upto_date,shed_tally_info.verify_by,shed_tally_info.verify_time,shed_tally_info.wr_upto_date,IFNULL(shed_tally_info.id,0) as verify_id,
												(select Organization_Name from organization_profiles where organization_profiles.id=igm_sup_detail_container.off_dock_id) as offdock_name,
													agent_do,do_date,be_no,be_date,cnf_lic_no,update_ton,cnf_name
													from  igm_supplimentary_detail
													inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
													left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
													left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
													where igm_supplimentary_detail.Import_Rotation_No='$verify_rot' and igm_supplimentary_detail.BL_No='$verify_bl'
													group by igm_sup_detail_container.id";
			
				//echo $sqlContainer;
				$rtnContainerList = $this->bm->dataSelectDb1($sqlContainer);
				$data['rtnContainerList']=$rtnContainerList;
			
				$containerNo=$rtnContainerList[0]['cont_number'];
				$verify_id=$rtnContainerList[0]['verify_id'];
				
				$cnf_lic_no=$rtnContainerList[0]['cnf_lic_no'];
				$cnf_licQuery="SELECT name from ref_bizunit_scoped where id='$cnf_lic_no'";
				$rtnCnfName = $this->bm->dataSelect($cnf_licQuery);
				$cnf_name=$rtnCnfName[0]['name'];
				
				
				$strID = "select count(*) as rtnValue from sparcsn4.inv_unit
					inner join sparcsn4.srv_event on sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey
					where id='$containerNo' and  category='IMPRT' and event_type_gkey=30";
				$rtnValue = $this->bm->dataReturn($strID);
				/*
				if($rtnValue<1)
				{
					$msg="<font color='red'><b>CARGO IS NOT UNSTUFFED.</b></font>";
				}
				else
				{
					if($verify_id==0)
					{
						$msg="<font color='red'><b>NOT VERIFIED YET</b></font>";
					}
				}
				*/
					$data['unstuff_flag']=$rtnValue;
					$data['verify_id']=$verify_id;
					$data['verify_num']=$verify_num;
					$data['cnf_name']=$cnf_name;
					$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
					$data['ddl_bl_no']=$ddl_bl_no;
					$data['msg']=$msg;
					$data['title']="LCL ASSINGMENT CERTIFY SECTION...";
					$this->load->view('header5');
					$this->load->view('lclAssignmentCertifySectionHTML',$data);
					$this->load->view('footer_1');
				
			}
		
	}
	
	  function deliveryEntryFormByWHClerk()
		{	
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
			
				if($this->uri->segment(6)=="doForm")
	
				{
					$blNo=str_replace("_","/",$this->uri->segment(3));
					$rotyear=$this->uri->segment(4);
					$rot=$this->uri->segment(5);
					$data['doFormFlag']=1;
					$data['blNo']=$blNo;
					$data['rotNo']=$rotyear.'/'.$rot;
					
				}
				else{
					$data['doFormFlag']=0;
				}

				$data['title']="ONE STOP SERVICE CENTER";
				$this->load->view('header5');
				$this->load->view('deliveryEntryFormByWHClerkHTML',$data);
				$this->load->view('footer_1');
			}
		}
		
		
    function deliveryEntryForm()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else 
			{	
		    $oneStop=$this->input->post('oneStopPoint');
			$shedTallyInfoID=$this->input->post('shedTallyInfoID');
			$cnf_lic=$this->input->post('cnf_lic');
			$cnfName=$this->input->post('cnfName');
			$paperFileDate=$this->input->post('paperFileDate');
			$exitNoteNum=strtoupper($this->input->post('exitNoteNum'));
			$date=$this->input->post('date');
			$truckNum=$this->input->post('truckNum');
			$billNo=$this->input->post('billNo');
			$billOfEntryDate=$this->input->post('billOfEntryDate'); 
			$invoiceAmount=$this->input->post('invoiceAmount'); 
			$blNo=$this->input->post('blNo');
			$rotNo=$this->input->post('rotNo');
			$doNo=$this->input->post('doNo');
			$doDate=$this->input->post('doDate');
			$validUpToDate=$this->input->post('validUpToDate');
			$commLandDate=$this->input->post('commLandDate');
			$cusOrderNo=strtoupper($this->input->post('cusOrderNo'));
			$cusOrderDate=$this->input->post('cusOrderDate');
			
		    $login_id = $this->session->userdata('login_id');
	
			$verifyNo=$this->input->post('verifyNo');
			$verifyStatus=0;
			
			if($this->input->post('save'))  
		      {
				  $checkQuery="select verify_number from shed_tally_info where id='$shedTallyInfoID'";				  
				  $selectStat = $this->bm->dataSelectDb1($checkQuery);
				  $chkVal=$selectStat[0]['verify_number'];
			     if($chkVal=="" || $chkVal=="NULL" )
				  {
				  if($verifyNo=="")
				  {
					  $maxVerifysql="SELECT IFNULL(MAX(verify_serial),0)+1 AS rtnValue FROM shed_tally_info WHERE DATE(verify_time)=DATE(NOW()) AND verify_unit='$oneStop'";
					 // $maxVerifysql="select max(verify_number)+1 as rtnValue from shed_tally_info";
					  $newVerifySerial = $this->bm->dataReturnDb1($maxVerifysql);
					  
					 //$sd = date(dmy);	
					  
					   //$dateQuery="select DATE_FORMAT(date(now()),'%d%m%y') as rtnValue";
					   $date = date('dmy');
					   
                       $size=strlen($newVerifySerial);
					   $newVerifyNo = "";
					   if($size==1)
					   {
						   $newVerifyNo=$oneStop."".$date."000".$newVerifySerial;
					   }
					   else if($size==2)
					   {
						   $newVerifyNo=$oneStop."".$date."00".$newVerifySerial;
					   }
					   else if($size==3)
					   {
						   $newVerifyNo=$oneStop."".$date."0".$newVerifySerial;
					   }
					   else 
					   {
						   $newVerifyNo=$oneStop."".$date."".$newVerifySerial;
					   }
					   
					  $searchQuery="select count(shed_tally_id)as rtnValue from verify_other_data where shed_tally_id='$shedTallyInfoID'";
					  $selectStat = $this->bm->dataReturnDb1($searchQuery);
					 // echo  $selectStat;
					  if( $selectStat==0)
					  {
						  
					   $updateShedQuery="UPDATE shed_tally_info SET verify_serial='$newVerifySerial', verify_number='$newVerifyNo',verify_time=now(),verify_by='$login_id',verify_unit='$oneStop' WHERE shed_tally_info.id=$shedTallyInfoID";		
					   $updateStat = $this->bm->dataUpdateDB1($updateShedQuery);
					   
                       $selectQuery="insert into verify_other_data (shed_tally_id, cnf_lic_no, cnf_name, date, no_of_truck, paper_file_date,
					   exit_note_number, be_no, be_date, do_no, do_date, valid_up_to_date, cus_rel_odr_no, cus_rel_odr_date, comm_landing_date)
					   values('$shedTallyInfoID','$cnf_lic','$cnfName', '$date','$truckNum', '$paperFileDate', '$exitNoteNum','$billNo', '$billOfEntryDate',
					   '$doNo', '$doDate', '$validUpToDate','$cusOrderNo', '$cusOrderDate', '$commLandDate')" ;	
                        
						
					   $Stat = $this->bm->dataInsertDB1($selectQuery);
                      					   
						 //echo $selectQuery;
					  }
					  else
					  {	  
					  // echo $newVerifyNo;
					  $updateShedQuery="UPDATE shed_tally_info SET verify_serial='$newVerifySerial', verify_number='$newVerifyNo',verify_time=now(),verify_by='$login_id',verify_unit='$oneStop' WHERE shed_tally_info.id=$shedTallyInfoID";		
					  $updateStat = $this->bm->dataUpdateDB1($updateShedQuery);	

                      $updateVerifyQuery="UPDATE verify_other_data SET cnf_lic_no='$cnf_lic', cnf_name='$cnfName',date ='$date',
					                no_of_truck='$truckNum',paper_file_date='$paperFileDate', exit_note_number='$exitNoteNum', be_no='$billNo',be_date='$billOfEntryDate',
									do_no='$doNo', do_date='$doDate', valid_up_to_date='$validUpToDate', cus_rel_odr_no='$cusOrderNo',cus_rel_odr_date='$cusOrderDate',
									comm_landing_date='$commLandDate' WHERE shed_tally_id=$shedTallyInfoID";

					   $Stat = $this->bm->dataUpdateDB1($updateVerifyQuery);

					  }
					   //echo  $updateVerifyQuery;
                       if($updateStat==1 and $Stat==1 )	 
					   {
						  //$data['msg']="Saved Sucessfully.";
						 echo "<font color=green>Saved Sucessfully.</font></br>";
						 					  
					     echo "<font color=green size=4>New Verification No : ".$newVerifyNo."</font>"; 
					   }		
                        else	
							echo "<font color=red>Not Saved.</font>";
						
                         // $data['msg']="Not Saved.";							
					  
					     //$verifyStatus=1;
				         //$data['verifyStatus']=$verifyStatus;
					     //$data['newVerifyNo'] = $newVerifyNo;
                         //$data['blNo']=$blNo;				  
					     //$data['rotNo']=$rotNo;
					  

				  }
				  
				  else
				  {					  
                      $updateVerifyQuery="UPDATE verify_other_data SET cnf_lic_no='$cnf_lic', cnf_name='$cnfName',date ='$date',
					                no_of_truck='$truckNum',paper_file_date='$paperFileDate', exit_note_number='$exitNoteNum', be_no='$billNo',be_date='$billOfEntryDate',
									do_no='$doNo', do_date='$doDate', valid_up_to_date='$validUpToDate', cus_rel_odr_no='$cusOrderNo',cus_rel_odr_date='$cusOrderDate',
									comm_landing_date='$commLandDate' WHERE shed_tally_id=$shedTallyInfoID";
						//echo 	$updateVerifyQuery;		

					   $Stat = $this->bm->dataUpdateDB1($updateVerifyQuery);	
                       if($Stat==1 )	
					   {
				          echo "<font color=green>Sucessfully updated</font>";

						  //$data['msg']="Sucessfully updated";
					   }		
                        else		
							echo "<font color=red>Not Updated.</font>";		
                         // $data['msg']="Not Updated.";		

					     // echo $updateVerifyQuery;
                         //$verifyStatus=2;
					     //$data['verifyStatus']=$verifyStatus;
                         //$data['blNo']=$blNo;				  
					     //$data['rotNo']=$rotNo;				       
					     // $data['verifyNo']=$verifyNo;
				  }
				   
			  }

            else{
				echo "<font>This  is already verified and verify number: ".$chkVal."</font>";
			}
			   //$data['title']="ONE STOP SERVICE CENTER";
						//$this->load->view('header5');
						//$this->load->view('deliveryEntryFormByWHClerkHTML',$data);
						//$this->load->view('footer_1');
		      }
		   }
		}
		
		function deliverySearchByVerifyNo()
		{	
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="ONE STOP SERVICE CENTER";
				$this->load->view('header5');
				$this->load->view('deliverySearchByVerifyNoForm',$data);
				$this->load->view('footer_1');
			}
		}
		
				

		function deliverySearchByVerify()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				
			    $assignClerk=$this->input->post('assignClerk');
	            $shedTallyId=$this->input->post('shedTallyId');
				$verifyNo1=$this->input->post('verifyNo1');
				$bankCPdate=$this->input->post('bankCPdate');
			    $bankCPno=$this->input->post('bankCPno');

				
				 if($this->input->post('save'))
				  {
					  if($bankCPdate!="" and $bankCPno!="")
					  {

				 
						  $Query="UPDATE verify_other_data SET clerk_assign ='$assignClerk' WHERE shed_tally_id='$shedTallyId'";
						 //echo $Query;

						   $Stat = $this->bm->dataUpdateDB1($Query);	
						   if($Stat==1 )	
						   {
							  $data['msg']="<font color=green>Sucessfully Assigned.</font>";
						   }		
							else		
							  $data['msg']= "<font color=red>Not Updated.</font>";
				       }
					  else 
                            $data['msg']= "<font color=red>Require Bank CP no and CP Date in Gate information Form!</font>";					  

				  }
				 $data['title']="ONE STOP SERVICE CENTER";
				//$data['trFlag']=1;
				$this->load->view('header5');
				$this->load->view('deliverySearchByVerifyNoForm',$data);
				$this->load->view('footer_1');
					
	           	
			}
		}
	//Shed delivery order
		
	function shedDeliveryOrder()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="SHED DELIVERY ORDER";
				$this->load->view('header2');
				$this->load->view('shedDeliveryOrder',$data);
				$this->load->view('footer');
			}
			
		}
		
		function shedDeliveryOrderForm()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$login_id = $this->session->userdata('login_id');
			    $this->load->library('m_pdf');
		        $mpdf->use_kwt = true;

				$verifyNo=$this->input->post('verifyNo');
				
				$sqlOrder = "select igm_supplimentary_detail.id,IFNULL(sum(rcv_pack+loc_first),0) as rcv_pack,igm_masters.Vessel_Name,igm_supplimentary_detail.Import_Rotation_No,
				  igm_sup_detail_container.cont_number,Pack_Marks_Number,shed_loc,shed_yard,Description_of_Goods,Notify_name,IFNULL(shed_tally_info.verify_number,0) as verify_number,
				  IFNULL(shed_tally_info.id,0) as verify_id,igm_supplimentary_detail.Pack_Number,igm_supplimentary_detail.Pack_Description,
				  igm_supplimentary_detail.BL_No,igm_sup_detail_container.cont_size,igm_sup_detail_container.cont_status,igm_sup_detail_container.cont_weight,
				  verify_other_data.cnf_name,verify_other_data.be_no,verify_other_data.be_date,igm_sup_detail_container.cont_height
				  from  igm_supplimentary_detail
				  inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
				  inner join igm_masters on igm_supplimentary_detail.igm_master_id=igm_masters.id
				  left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
				  left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
				  where shed_tally_info.verify_number='$verifyNo'";	
								
				$orderList = $this->bm->dataSelectDb1($sqlOrder);	
				$this->data['verifyNo']=$verifyNo;
				$this->data['orderList']=$orderList;
				
				
				$sqlTruckCount="select count(truck_id) as rtnValue from do_information where verify_no='$verifyNo'";
				$truckCount = $this->bm->dataReturnDb1($sqlTruckCount);	
				$this->data['truckCount']=$truckCount;
				
				$sqlTruckDetails="select truck_id, delv_pack from do_information where verify_no='$verifyNo'";
				$truckDetails = $this->bm->dataSelectDb1($sqlTruckDetails);	
				$this->data['truckDetails']=$truckDetails;
				//echo $orderList;
				//$this->load->view('header5');
				$this->load->view('shedDeliveryOrderForm',$data);
				$html=$this->load->view('shedDeliveryOrderForm',$this->data, true); 
				
				$pdfFilePath ="mypdfName-".time()."-download.pdf";

				$pdf = $this->m_pdf->load();
				$pdf->SetWatermarkText('CPA CTMS');
				$pdf->showWatermarkText = true;	
				//$stylesheet = file_get_contents(CSS_PATH.'style.css'); // external css
				//$stylesheet = file_get_contents('resources/styles/test.css'); 
				$pdf->useSubstitutions = true; 
					
				$pdf->setFooter('Prepared By : '.$login_id.'|Page {PAGENO}|Date {DATE j-m-Y}');
			
				//$pdf->WriteHTML($stylesheet,1);
				$pdf->WriteHTML($html,2);
					
				$pdf->Output($pdfFilePath, "I");	 		
		
			}	
		}
		
	
	
	
		// LCL Certify Section	
		function doEntrySearchForm()
		{	
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="DELIVERY ENTRY FORM...";
				$this->load->view('header2');
				$this->load->view('doEntryFormHTML',$data);
				$this->load->view('footer');
			}
		}
		
		function doEntryForm()
		{
			$rotation=$this->input->post('rotation');
			$cont=$this->input->post('cont');
			$sqlContainer = "select igm_supplimentary_detail.id,import_rotation,cont_number,BL_No,Pack_Marks_Number,Pack_Description,Pack_Number,sum(rcv_pack) as rcv_pack,
			sum(flt_pack) as flt_pack
			from shed_tally_info 
			inner join igm_supplimentary_detail on igm_supplimentary_detail.id=shed_tally_info.igm_sup_detail_id
			where import_rotation='$rotation' and cont_number='$cont' group by shed_tally_info.igm_sup_detail_id";				
			$rtnContainerList = $this->bm->dataSelectDb1($sqlContainer);
			
			$data['rotation']=$rotation;
			$data['cont']=$cont;
			$data['tbl']="sup_detail";
				
			$data['rtnContainerList']=$rtnContainerList;
			$this->load->view('doEntryFormView',$data);
		}
		
		
		function updateDOInfo()
		{
			$dlv=$this->input->post('dlv');
			$loc=$this->input->post('loc');
			$supId=$this->input->post('dtlId');
			$rot=$this->input->post('rot');
			$cont=$this->input->post('cont');
			$remark=$this->input->post('remark');
			$tbl=$this->input->post('tbl');
			$ipaddr = $_SERVER['REMOTE_ADDR'];
			$login_id = $this->session->userdata('login_id');
			
			$str = "";
			if($tbl=="sup_detail")
			{
				$str = "insert into do_information(igm_sup_detail_id,import_rotation,cont_number,delv_pack,shed_loc,update_by,ip_addr,remarks,last_update)
				values('$supId','$rot','$cont','$dlv','$loc','$login_id','$ipaddr','$remark',now())";
			}
			else
			{
				$str = "insert into do_information(igm_detail_id,import_rotation,cont_number,delv_pack,shed_loc,update_by,ip_addr,remarks,last_update)
				values('$supId','$rot','$cont','$dlv','$loc','$login_id','$ipaddr','$remark',now())";
			}
				
			//}
			$stat = $this->bm->dataInsertDB1($str);
			//echo "<br>".$str;
			if($stat==1)
			{
				$data['stat']="<font color='red'><b>Sucessfully inserted</b></font>";
			}
			else
			{
				$data['stat']="<font color='red'><b>Not inserted</b></font>";
			}
			
			if($tbl=="sup_detail")
			{
				$sqlContainer = "select igm_supplimentary_detail.id,import_rotation,cont_number,BL_No,Pack_Marks_Number,Pack_Description,Pack_Number,sum(rcv_pack) as rcv_pack,
				sum(flt_pack) as flt_pack
				from shed_tally_info 
				inner join igm_supplimentary_detail on igm_supplimentary_detail.id=shed_tally_info.igm_sup_detail_id
				where import_rotation='$rot' and cont_number='$cont' group by shed_tally_info.igm_sup_detail_id";
			}
			else
			{
				$sqlContainer = "select igm_details.id,Import_Rotation_No,BL_No,cont_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
					from igm_details 
					inner join igm_detail_container on igm_detail_container.igm_detail_id=igm_details.id
					where Import_Rotation_No='$rot' and cont_number='$cont'
					order by 2
					";	
			}
				
				//echo "<br>".$sqlContainer;
				$rtnContainerList = $this->bm->dataSelectDb1($sqlContainer);				
				$data['rotation']=$rot;
				$data['cont']=$cont;
				$data['tbl']=$tbl;
				
				$data['rtnContainerList']=$rtnContainerList;
				$this->load->view('doEntryFormView',$data);
		}
		
		function wirehouseReportForm()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="WAREHOUSE REPORT FORM...";
				$this->load->view('header2');
				$this->load->view('wirehouseReportForm',$data);
				$this->load->view('footer');
			}
		}
		
		function wireHouseReport()
		{
			$rotation=$this->input->post('rotation');
			$cont=$this->input->post('cont');
			
			$sqlContainer = "select igm_supplimentary_detail.id,igm_supplimentary_detail.Line_No,Pack_Marks_Number,igm_supplimentary_detail.Description_of_Goods,Pack_Number,
			(select sum(rcv_pack) from shed_tally_info where igm_sup_detail_id=igm_supplimentary_detail.id) as rcv_pack,
			(select sum(delv_pack) from do_information where igm_sup_detail_id=igm_supplimentary_detail.id) as delv_pack,
			(select rcv_pack-delv_pack) as rest_pack,
			(select shed_loc from shed_tally_info where igm_sup_detail_id=igm_supplimentary_detail.id limit 1) as shed_loc
			from igm_supplimentary_detail 
			inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
			where Import_Rotation_No='$rotation' and cont_number='$cont'";				
			$rtnContainerList = $this->bm->dataSelectDb1($sqlContainer);
			
			$data['rotation']=$rotation;
			$data['cont']=$cont;
			$data['rtnContainerList']=$rtnContainerList;
			$this->load->view('wirehouseReportView',$data);
		}
		
		//datewise report view form
		function wirehouseReportFormDatewise()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="DATEWISE WIREHOUSE REPORT FORM...";
				$this->load->view('header2');
				$this->load->view('wirehouseReportFormDatewise',$data);  
				//"testvalidation" "wirehouseReportFormDatewise" previous
				$this->load->view('footer');
			}
		}
		
		//sends result for wirehouseReportFormDatawise
		function wireHouseReportDatewise()
		{
			$fromdate=$this->input->post('fromdate');	//fromdate
			$todate=$this->input->post('todate');       //todate    
			
			//validation test begins
		//	$this->form_validation->set_rules('fromddate', 'From', 'required');
		//	$this->form_validation->set_rules('todate', 'To', 'required');
			
			//validation test ends
			
			//with rotation, container
			$sqlContainer = "SELECT id,Import_Rotation_No,cont_number,Line_No,Pack_Marks_Number,Description_of_Goods,Pack_Number,
			SUM(rcv_pack) AS rcv_pack,actual_marks,marks_state,
			(SELECT SUM(delv_pack) FROM do_information WHERE igm_sup_detail_id=tmp.id) AS delv_pack
			FROM
			(SELECT igm_supplimentary_detail.id,igm_supplimentary_detail.Line_No,Import_Rotation_No,igm_sup_detail_container.cont_number,Pack_Marks_Number,igm_supplimentary_detail.Description_of_Goods,Pack_Number,rcv_pack,actual_marks,marks_state
			FROM igm_supplimentary_detail 
			INNER JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
			LEFT JOIN shed_tally_info ON shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
			WHERE DATE(shed_tally_info.last_update) BETWEEN '$fromdate' AND '$todate') AS tmp GROUP BY id"; 
			
			$rtnContainerList = $this->bm->dataSelectDb1($sqlContainer);
			
			$data['rtnContainerList']=$rtnContainerList;
			$data['from']=$fromdate;
			$data['to']=$todate;
			
			$this->load->view('wirehouseReportViewDatewise',$data);
		}
		
		
		function exportCopinoView()
		{
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{  
				$data['title']="Export Copino...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('exportCopinoView',$data);
				$this->load->view('footer');
			}	
		}
		function exportCopinoDownloadView()
				{
					$login_id = $this->session->userdata('login_id');	
					$data['login_id']=$login_id;
					
					$search_value=$this->input->post('search_value');
					$data['title']="EXPORT COPINO ROTATION ".$search_value;					
					$data['rot']=$search_value;
											 
					$this->load->view('exportCopinoDownloadView',$data);   
				}
		// MH Chowdhury report start
		function contDetailInfoByRotWithXlsDownloadForm()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$data['title']="CONTAINER DETAILS BY ROTATION";
				$this->load->view('header2');
				$this->load->view('contDetailByRotationFormExcelAndHtml',$data);   
				$this->load->view('footer');
			}
		}	

		function contDetailInfoByRotWithXlsDownloadPerform()
		{
				$login_id = $this->session->userdata('login_id');	
				$data['login_id']=$login_id;
				$search_by = $this->input->post('search_by');
				if($search_by=="rotation")
				{
					$search_value=$this->input->post('search_value');
					$data['title']="CONTAINERS DETAIL FOR THE ROTATION ".$search_value;
				    $data['rot']=$search_value;
				}
				else if($search_by=="container")
				{
					$search_value=$this->input->post('search_value');
					$data['title']="CONTAINERS DETAIL FOR THE CONTAINER ".$search_value;
					$data['con']=$search_value;
				}
				else
				{
					$fromdate=$this->input->post('fromdate');
					$todate=$this->input->post('todate');
				    $data['fromdate']=$fromdate;
				    $data['todate']=$todate;
					$data['title']="VESSEL PERFORMANCE DATE BETWEEN ".$fromdate." AND ".$todate;	
				}
			     
				$this->load->view('contDetailByRotationExcelAndHtmlView',$data);   
		}
		function contListAllByRotationForm()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$data['title']="CONTAINER LIST (ALL)";
				$this->load->view('header2');
				$this->load->view('ContListAllByRotationView',$data);   
				$this->load->view('footer');
			}
		}
		function contListAllByRotationDownloadView()
				{
					$login_id = $this->session->userdata('login_id');	
					$data['login_id']=$login_id;
					$search_by = $this->input->post('search_by');
					
					$search_value=$this->input->post('search_value');
					$data['title']="CONTAINERS LIST FOR THE ROTATION ".$search_value;
					$data['containerStatus']="IGM Containers";
					$data['rot']=$search_value;
					
						 
					$this->load->view('ContListAllByRotationExcelHTMLDownloadView',$data);   
				}
		function contListDischargeByRotationForm()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$data['title']="CONTAINER LIST (DISCHARGE)";
				$this->load->view('header2');
				$this->load->view('ContListDischargeByRotationView',$data);   
				$this->load->view('footer');
			}
		}
		
					function contListDischargeByRotationDownloadView()
				{
					$login_id = $this->session->userdata('login_id');	
					$data['login_id']=$login_id;
					//$search_by = $this->input->post('search_by');
					
					//$search_value=$this->input->post('search_value');
					
					$dis_date_from=$this->input->post('dis_date_from');
					$dis_date_to=$this->input->post('dis_date_to');
					
					$data['title']="CONTAINERS LIST FROM ".$dis_date_from." TO ".$dis_date_to;
					$data['containerStatus']="DISCHARGE Containers";
					
					$data['dis_date_from']=$dis_date_from;
					$data['dis_date_to']=$dis_date_to;
					
						 
					$this->load->view('ContListDischargeByRotationExcelHTMLDownloadView',$data);   
				} 
				
		function contListAssignmentByRotationForm()
				{
					$session_id = $this->session->userdata('value');
					if($session_id!=$this->session->userdata('session_id'))
					{
						$this->logout();
						
					}
					else
					{
						$data['title']="CONTAINER LIST (ASSIGNMENT)";
						$this->load->view('header2');
						$this->load->view('ContListAssignmentByRotationView',$data);   
						$this->load->view('footer');
					}
				}
		function contListAssignmentByRotationDownloadView()
				{
					$login_id = $this->session->userdata('login_id');	
					$data['login_id']=$login_id;
					//$search_by = $this->input->post('search_by');
					
					$assign_date_from=$this->input->post('assign_date_from');
					$assign_date_to=$this->input->post('assign_date_to');
					
					$data['title']="CONTAINERS LIST FORM  ".$assign_date_from." TO ".$assign_date_to;
					$data['containerStatus']="Assignment Containers";
					$data['assign_date_from']=$assign_date_from;
					$data['assign_date_to']=$assign_date_to;
					
						 
					$this->load->view('ContListAssignmentByRotationExcelHTMLDownloadView',$data);   
				}		
		function contListOffDockByRotationForm()
				{
					$session_id = $this->session->userdata('value');
					if($session_id!=$this->session->userdata('session_id'))
					{
						$this->logout();
						
					}
					else
					{
						$data['title']="CONTAINER LIST (OFFDOCK DELIVERY)";
						$this->load->view('header2');
						$this->load->view('ContListOffDockByRotationView',$data);   
						$this->load->view('footer');
					}
				}
		function contListOffDockByRotationDownloadView()
				{
					$login_id = $this->session->userdata('login_id');	
					$data['login_id']=$login_id;
					//$search_by = $this->input->post('search_by');
					
					//$search_value=$this->input->post('search_value');
					$off_date_from=$this->input->post('off_date_from');
					$off_date_to=$this->input->post('off_date_to');
					
					
					$data['containerStatus']="DISCHARGE Containers";
					
					$data['off_date_from']=$off_date_from;
					$data['off_date_to']=$off_date_to;
					$data['title']="CONTAINERS LIST FROM ".$off_date_from." TO ".$off_date_to;
					$data['containerStatus']="OffDock Containers";
					//$data['rot']=$search_value;
					
						 
					$this->load->view('ContListOffDockByRotationExcelHTMLDownloadView',$data);  
				}				
		function contListReferByRotationForm()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$data['title']="CONTAINER LIST (REFFER)";
				$this->load->view('header2');
				$this->load->view('ContListReferByRotationView',$data);   
				$this->load->view('footer');
			}
		}
		function contListReferByRotationDownloadView()
				{
					$login_id = $this->session->userdata('login_id');	
					$data['login_id']=$login_id;
					$ref_date_from=$this->input->post('ref_date_from');
					$ref_date_to=$this->input->post('ref_date_to');
					
					//$search_value=$this->input->post('search_value');
					$data['title']="CONTAINERS LIST From ".$ref_date_from." To ".$ref_date_to;
					$data['containerStatus']="Reefer Containers";
					//$data['rot']=$search_value;
					$data['ref_date_from']=$ref_date_from;
					$data['ref_date_to']=$ref_date_to;
					
						 
					$this->load->view('ContListReferByRotationExcelHTMLDownloadView',$data);   
				}	
		function contListEmptyGateOutByRotationForm()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$data['title']="CONTAINER LIST (Empty GATE OUT) ";
				$this->load->view('header2');
				$this->load->view('ContListEmptyGateOutByRotationView',$data);   
				$this->load->view('footer');
			}
		}
		function contListEmptyGateOutByRotationDownloadView()
				{
					$login_id = $this->session->userdata('login_id');	
					$data['login_id']=$login_id;
					//$search_by = $this->input->post('search_by');
					$fromDt=$this->input->post('fromDt');
					$toDt=$this->input->post('toDt');
					
					//$search_value=$this->input->post('search_value');
					$data['title']="CONTAINERS LIST From ".$fromDt." To ".$toDt;
					$data['containerStatus']="EmptyGateOut Containers";
					//$data['rot']=$search_value;
					$data['fromDt']=$fromDt;
					$data['toDt']=$toDt;
					
						 
					$this->load->view('ContListEmptyGateOutByRotationExcelHTMLDownloadView',$data);   
				}	
		function contListStripingByRotationForm()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$data['title']="CONTAINER LIST (STRIPPING)";
				$this->load->view('header2');
				$this->load->view('ContListStripingByRotationView',$data);   
				$this->load->view('footer');
			}
		}
				 
		function contListStripingByRotationDownloadView()
				{
					$login_id = $this->session->userdata('login_id');	
					$data['login_id']=$login_id;
					
					$search_by = $this->input->post('search_by');
					
					if($search_by=="rotation")
					{
						$search_value=$this->input->post('search_value');
						$data['title']="CONTAINERS DETAIL FOR THE ROTATION ".$search_value;
						$data['rot']=$search_value;
						$data['search_by']=$search_by;
					}
					else{
						$stripping_date_from=$this->input->post('stripping_date_from');
						$stripping_date_to=$this->input->post('stripping_date_to');
					
						//$search_value=$this->input->post('search_value');
						$data['search_by']=$search_by;
						$data['title']="CONTAINERS LIST From ".$stripping_date_from." To ".$stripping_date_to;
						$data['stripping_date_from']=$stripping_date_from;
						$data['stripping_date_to']=$stripping_date_to;
					}
					
					$data['containerStatus']="Stripping Containers";
					//$data['rot']=$search_value;
					$this->load->view('ContListStripingByRotationExcelHTMLDownloadView',$data);  
				}	
		// MH Chowdhury report end
		function shedStockBalanceForm()
		{	
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$str="select verify_number,import_rotation,shed_tally_info.cont_number,master_BL_No,BL_No,cont_weight,cont_size,cont_height,cont_status,cont_type,
				Pack_Number,Pack_Description,Notify_name from shed_tally_info 
				inner join igm_supplimentary_detail on shed_tally_info.igm_sup_detail_id = igm_supplimentary_detail.id
				inner join igm_sup_detail_container on shed_tally_info.igm_sup_detail_id=igm_sup_detail_container.igm_sup_detail_id
				where verify_number !='' and shed_tally_info.delivery_status !=1";
				$rtnContainerList = $this->bm->dataSelectDb1($str);
				$data['rtnContainerList']=$rtnContainerList;
				$data['title']="STOCK BALANCE REPORT...";
				$this->load->view('header2');
				$this->load->view('shedStockBalanceForm',$data);
				$this->load->view('footer');
			}
		}
		function shedStockBalanceFormView()
				{
					$strVerifyNum=$this->input->post('strVerifyNum');
					
					$str="select verify_number,import_rotation,shed_tally_info.cont_number,master_BL_No,BL_No,cont_weight,cont_size,cont_height,cont_status,cont_type,
					Pack_Number,Pack_Description,Notify_name from shed_tally_info 
					inner join igm_supplimentary_detail on shed_tally_info.igm_sup_detail_id = igm_supplimentary_detail.id
					inner join igm_sup_detail_container on shed_tally_info.igm_sup_detail_id=igm_sup_detail_container.igm_sup_detail_id
					where verify_number='$strVerifyNum' and shed_tally_info.delivery_status !=1";
					
					$rtnContainerList = $this->bm->dataSelectDb1($str);
					//echo $rtnContainerList[0]['verify_number']."  fdfdfd";
					$data['rtnContainerList']=$rtnContainerList;
					$data['vNum']=$rtnContainerList[0]['verify_number'];
					$data['title']="STOCK BALANCE REPORT...";
					$this->load->view('header2');
					$this->load->view('shedStockBalanceForm',$data);
					$this->load->view('footer');
					/*
					$login_id = $this->session->userdata('login_id');	
					$data['login_id']=$login_id;
								
					$strVerifyNum=$this->input->post('strVerifyNum');
					
					
					$data['containerStatus']="STOCK BALANCE REPORT";
					$data['strVerifyNum']=$strVerifyNum;
					//echo "yy : ".$strVerifyNum;
					$this->load->view('shedStockBalanceFormView',$data);   
					*/
				}	
				/****************Verification List ***************/
				
				
		function verificationListForm()
		  {	
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$login_id = $this->session->userdata('login_id');	

				$str="select verify_number,import_rotation,shed_tally_info.cont_number,master_BL_No,BL_No,cont_weight,cont_size,cont_height,cont_status,cont_type,
				Pack_Number,Pack_Description,Notify_name from shed_tally_info 
				inner join igm_supplimentary_detail on shed_tally_info.igm_sup_detail_id = igm_supplimentary_detail.id
				inner join igm_sup_detail_container on shed_tally_info.igm_sup_detail_id=igm_sup_detail_container.igm_sup_detail_id
				where verify_number!='' order by shed_tally_info.id desc";
				$rtnContainerList = $this->bm->dataSelectDb1($str);
				$data['rtnContainerList']=$rtnContainerList;
				$data['title']="VERIFICATION LIST REPORT...";
				$data['login_id']=$login_id;
				$this->load->view('header2');
				$this->load->view('verificationListForm',$data);
				$this->load->view('footer');
			}
		}
		
		function verificationListFormView()
				{
					$login_id = $this->session->userdata('login_id');	
					
					$strVerifyNum=$this->input->post('strVerifyNum');
					
					$str="select verify_number,import_rotation,shed_tally_info.cont_number,master_BL_No,BL_No,cont_weight,cont_size,cont_height,cont_status,cont_type,
					Pack_Number,Pack_Description,Notify_name from shed_tally_info 
					inner join igm_supplimentary_detail on shed_tally_info.igm_sup_detail_id = igm_supplimentary_detail.id
					inner join igm_sup_detail_container on shed_tally_info.igm_sup_detail_id=igm_sup_detail_container.igm_sup_detail_id
					where verify_number='$strVerifyNum'";
					
					$rtnContainerList = $this->bm->dataSelectDb1($str);
					//echo $rtnContainerList[0]['verify_number']."  fdfdfd";
					$data['rtnContainerList']=$rtnContainerList;
					$data['login_id']=$login_id;
					$data['title']="VERIFICATION LIST REPORT...";
					$data['vNum']=$rtnContainerList[0]['verify_number'];
					$this->load->view('header2');
					$this->load->view('verificationListForm',$data);
					$this->load->view('footer');
				
				}
				/*******************************/
					/**********************Certification List ******************************/
				
		function certificationFormHtml(){
		
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$data['msg']="";
				$data['unstuff_flag']="";
				$data['verify_number']="-1";
				$data['title']="CERTIFICATION SECTION...";
				$this->load->view('header5');
				$this->load->view('certificationFormHtml',$data);
				$this->load->view('footer_1');
			}	
		
		}
				
		Function certificationFormViewList()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
		
			 //$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
			 //$ddl_bl_no=$this->input->post('ddl_bl_no');
			
				if($this->input->post('ddl_imp_rot_no') && $this->input->post('ddl_bl_no'))
				{
					$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
					$ddl_bl_no=$this->input->post('ddl_bl_no');

				}
				else{
					$ddl_bl_no=str_replace("_","/",$this->uri->segment(3));
					$ddl_imp_rot_no=str_replace("_","/",$this->uri->segment(4));
					//$ddl_imp_rot_no=$this->uri->segment(4);
					//$rot_year=$this->uri->segment(4);
					//$rot_no=$this->uri->segment(5);
					//$ddl_imp_rot_no=$rot_year.'/'.$rot_no;
				}
			
				$sqlContainer="select igm_supplimentary_detail.id,IFNULL(sum(rcv_pack)+sum(loc_first),0) as rcv_pack,rcv_unit,igm_masters.Vessel_Name,igm_sup_detail_container.cont_number,igm_supplimentary_detail.Import_Rotation_No,Pack_Marks_Number,shed_loc,shed_yard,Description_of_Goods,ConsigneeDesc,Notify_name,cont_size,cont_weight,cont_seal_number,cont_status,cont_height,cont_iso_type,IFNULL(shed_tally_info.verify_number,0) as verify_number,shed_tally_info.wr_upto_date,shed_tally_info.verify_by,shed_tally_info.verify_time,shed_tally_info.wr_date,IFNULL(shed_tally_info.id,0) as verify_id,
				(select Organization_Name from organization_profiles where organization_profiles.id=igm_sup_detail_container.off_dock_id) as offdock_name,
				agent_do,do_date,be_no,be_date,cnf_lic_no,update_ton,igm_supplimentary_detail.BL_No
				from  igm_supplimentary_detail
				inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
				inner join igm_masters on igm_supplimentary_detail.igm_master_id=igm_masters.id
				left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
				left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
				where igm_supplimentary_detail.Import_Rotation_No='$ddl_imp_rot_no' and igm_supplimentary_detail.BL_No='$ddl_bl_no'
				group by igm_sup_detail_container.id";
			
			//echo $sqlContainer;
			$rtnContainerList = $this->bm->dataSelectDb1($sqlContainer);
			$data['rtnContainerList']=$rtnContainerList;
			
			$containerNo=$rtnContainerList[0]['cont_number'];
			$verify_id=$rtnContainerList[0]['verify_id'];
			$verify_num=$rtnContainerList[0]['verify_number'];
			$cnf_lic_no=$rtnContainerList[0]['cnf_lic_no'];
			
			$cnf_licQuery="SELECT name from ref_bizunit_scoped where id='$cnf_lic_no'";
			$rtnCnfName = $this->bm->dataSelect($cnf_licQuery);
			$cnf_name=$rtnCnfName[0]['name'];
			
			
			$strID = "select count(*) as rtnValue from sparcsn4.inv_unit
				inner join sparcsn4.srv_event on sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey
				where id='$containerNo' and  category='IMPRT' and event_type_gkey=30";
			$rtnValue = $this->bm->dataReturn($strID);
			
			if($rtnValue<1)
			{
				$msg="<font color='red'><b>CARGO IS NOT UNSTUFFED.</b></font>";
			}
			else
			{
				if($verify_id==0)
				{
					$msg="<font color='red'><b>NOT VERIFIED YET</b></font>";
				}
			}
			
			$data['unstuff_flag']=$rtnValue;
			$data['verify_id']=$verify_id;
			$data['verify_num']=$verify_num;
			$data['cnf_name']=$cnf_name;
			$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
			$data['ddl_bl_no']=$ddl_bl_no;
			$data['msg']=$msg;
			$data['title']="CERTIFICATION SECTION...";
			$this->load->view('header5');
			$this->load->view('certificationFormHtml',$data);
			$this->load->view('footer_1');
		}
	}
	function certificationListPdf()
	{
		//load mPDF library
		$this->load->library('m_pdf');
		$mpdf->use_kwt = true;
		//load mPDF library
		
		
		$ddl_bl_no=str_replace("_","/",$this->uri->segment(3));
		$ddl_imp_rot_no=str_replace("_","/",$this->uri->segment(4));
		
		//echo "BL : ".$ddl_bl_no."Rt : ".$ddl_imp_rot_no;
			$str="select igm_supplimentary_detail.id,IFNULL(sum(rcv_pack)+sum(loc_first),0) as rcv_pack,rcv_unit,igm_masters.Vessel_Name,igm_sup_detail_container.cont_number,igm_supplimentary_detail.Import_Rotation_No,Pack_Marks_Number,shed_loc,shed_yard,Description_of_Goods,ConsigneeDesc,Notify_name,cont_size,cont_weight,cont_seal_number,cont_status,cont_height,cont_iso_type,IFNULL(shed_tally_info.verify_number,0) as verify_number,shed_tally_info.wr_upto_date,shed_tally_info.verify_by,shed_tally_info.verify_time,shed_tally_info.wr_date,IFNULL(shed_tally_info.id,0) as verify_id,
			(select Organization_Name from organization_profiles where organization_profiles.id=igm_sup_detail_container.off_dock_id) as offdock_name,
			agent_do,do_date,be_no,be_date,cnf_lic_no,update_ton,igm_supplimentary_detail.BL_No
			from  igm_supplimentary_detail
			inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
			inner join igm_masters on igm_supplimentary_detail.igm_master_id=igm_masters.id
			left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
			left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
			where igm_supplimentary_detail.Import_Rotation_No='$ddl_imp_rot_no' and igm_supplimentary_detail.BL_No='$ddl_bl_no' group by igm_sup_detail_container.id";
				//echo $str;
				//echo $str;
				$rtnContainerList = $this->bm->dataSelectDb1($str);
				$container=$rtnContainerList[0]['cont_number'];
				
			$str_fcyVisit="select fcy_time_in,fcy_last_pos_slot,fcy_position_name,yard,fcy_time_out,(select ctmsmis.cont_block(fcy_last_pos_slot,yard)) as block from (
													select time_in as fcy_time_in,last_pos_slot as fcy_last_pos_slot,last_pos_name as fcy_position_name,ctmsmis.cont_yard(last_pos_slot) as yard,time_out as fcy_time_out from inv_unit a
														inner join 
													inv_unit_fcy_visit on inv_unit_fcy_visit.unit_gkey=a.gkey
															inner join
													 argo_carrier_visit h ON (h.gkey = a.declrd_ib_cv or h.gkey = a.cv_gkey)
															inner join
														argo_visit_details i ON h.cvcvd_gkey = i.gkey
															inner join
														vsl_vessel_visit_details ww ON ww.vvd_gkey = i.gkey where ib_vyg='$ddl_imp_rot_no' and a.id='$container'
													) as  tmp";
				$rtnfcyVisit = $this->bm->dataSelect($str_fcyVisit);
				$fcy_time_out=$rtnfcyVisit[0]['fcy_time_out'];
		//now pass the data//
		 $this->data['title']="Shed Bill";
		 $this->data['rtnContainerList']=$rtnContainerList;
		 $this->data['fcy_time_out']=$fcy_time_out;
		
		$html=$this->load->view('certificationListPdfOutput',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
 	 
		//this the the PDF filename that user will get to download
		$pdfFilePath ="certificationPdfOutput-".time()."-download.pdf";

		
		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
		$pdf->SetWatermarkText('CPA CTMS');
		$pdf->showWatermarkText = true;	
		//$pdf->mirrorMargins = 1;
		//generate the PDF!
		//$stylesheet = file_get_contents('assets/css/main.css');
        //$mpdf->WriteHTML($stylesheet,1);
		//$stylesheet = file_get_contents('resources/styles/test.css'); // external css
		$pdf->useSubstitutions = true; // optional - just as an example
		//$pdf->SetHeader($url . "\n\n" . 'Date {DATE j-m-Y}');  // optional - just as an example
		//echo "SheetAdd : ".$stylesheet;
		$pdf->setFooter('Developed By : DataSoft|Page {PAGENO}|Date {DATE j-m-Y}');
		//$footerHtml='<pagefooter name="MyFooter1" content-left="{DATE j-m-Y}" content-center="{PAGENO}/{nbpg}" content-right="My document" footer-style="font-family: serif; font-size: 8pt; font-weight: bold; font-style: italic; color: #000000;" />';
		//$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		//$pdf->WriteHTML('<pagebreak resetpagenum="1" pagenumstyle="1" suppress="off" />');
		//offer it to user via browser download! (The PDF won't be saved on your server HDD)
		//$pdf->Output($pdfFilePath, "D"); /// For Direct Download 
		$pdf->Output($pdfFilePath, "I"); // For Show Pdf
	}
	
	
		/****Verification Number Delete********/
	
	function deleteVerificationNumber()
	{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$verifyNo=str_replace("_","/",$this->uri->segment(3));
				 //echo $verifyNo;				 
				$selectQuery="select id as rtnValue from shed_tally_info where verify_number='$verifyNo'";
                $shedTallyId = $this->bm->dataReturnDb1($selectQuery);
				
			    $updateShedQuery="UPDATE shed_tally_info SET verify_serial=0, verify_number=NULL, verify_time=NULL,verify_by=NULL,verify_unit=NULL WHERE shed_tally_info.id=$shedTallyId";		
			    $updateStat = $this->bm->dataUpdateDB1($updateShedQuery);
				$delQuery = "DELETE  from verify_other_data WHERE shed_tally_id='$shedTallyId'";
				$deleteStat = $this->bm->dataDeleteDB1($delQuery);
				
                $delQueryFromShedBillMaster = "DELETE from shed_bill_master WHERE verify_no='$verifyNo'";
				$delStat = $this->bm->dataDeleteDB1($delQueryFromShedBillMaster);	
				
                $delQueryFromShedBillDetails = "DELETE from shed_bill_details WHERE verify_no='$verifyNo'";
				$delStatDetails = $this->bm->dataDeleteDB1($delQueryFromShedBillDetails); 
				
				$delQueryFromShedBillTariff = "DELETE from shed_bill_tarrif WHERE verify_no='$verifyNo'";
				$delStatTariff = $this->bm->dataDeleteDB1($delQueryFromShedBillTariff);
				
				$delQueryFromDOinfo = "DELETE from do_information WHERE verify_no='$verifyNo'";
				$delStatDoInfo = $this->bm->dataDeleteDB1($delQueryFromDOinfo);		   
			
				$str="select verify_number,import_rotation,shed_tally_info.cont_number,master_BL_No,BL_No,cont_weight,cont_size,cont_height,cont_status,cont_type,
				Pack_Number,Pack_Description,Notify_name from shed_tally_info 
				inner join igm_supplimentary_detail on shed_tally_info.igm_sup_detail_id = igm_supplimentary_detail.id
				inner join igm_sup_detail_container on shed_tally_info.igm_sup_detail_id=igm_sup_detail_container.igm_sup_detail_id
				where verify_number!='' order by verify_number desc";
				$rtnContainerList = $this->bm->dataSelectDb1($str);
				
				$data['rtnContainerList']=$rtnContainerList;
				$data['title']="VERIFICATION LIST REPORT...";
				$this->load->view('header2');
				$this->load->view('verificationListForm',$data);
				$this->load->view('footer');
			}	
	}
	
	
	/*
	//Appraisement section start
		  function appraisementCertifySection()
		  {
		   $session_id = $this->session->userdata('value');
		   if($session_id!=$this->session->userdata('session_id'))
		   {
			$this->logout();
			
		   }
		   else
		   {
			$data['msg']="";
			$data['unstuff_flag']="";
			$data['verify_number']="-1";
			$data['title']="APPRAISEMENT SECTION...";
			$data['userip']=$_SERVER['REMOTE_ADDR'];
			$this->load->view('header5');
			$this->load->view('appraisementSectionHTML',$data);
			$this->load->view('footer_1');
		   } 
		  
		  }
		  
		  function appraisementCertifyList()
		  { 
		   $session_id = $this->session->userdata('value');
		   if($session_id!=$this->session->userdata('session_id'))
		   {
			$this->logout();
			
		   }
		   else
		   {

		   if($this->input->post('ddl_imp_rot_no') && $this->input->post('ddl_bl_no'))
				{
					$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
					$ddl_bl_no=$this->input->post('ddl_bl_no');

				}
				else{
					$ddl_bl_no=str_replace("_","/",$this->uri->segment(3));
					$ddl_imp_rot_no=str_replace("_","/",$this->uri->segment(4));
					//$ddl_imp_rot_no=$this->uri->segment(4);
					//$rot_year=$this->uri->segment(4);
					//$rot_no=$this->uri->segment(5);
					//$ddl_imp_rot_no=$rot_year.'/'.$rot_no;
				}
		   /*$sqlContainer="select igm_supplimentary_detail.id,IFNULL(sum(rcv_pack),0) as rcv_pack,igm_masters.Vessel_Name,igm_supplimentary_detail.Import_Rotation_No,
						  igm_sup_detail_container.cont_number,Pack_Marks_Number,shed_loc,shed_yard,Description_of_Goods,ConsigneeDesc,NotifyDesc,Notify_name,cont_size,
						  cont_weight,cont_seal_number,cont_status,cont_height,cont_iso_type,IFNULL(shed_tally_info.verify_number,0) as verify_number,
						  shed_tally_info.wr_upto_date,shed_tally_info.verify_by,shed_tally_info.verify_time,shed_tally_info.wr_upto_date,IFNULL(shed_tally_info.id,0) as verify_id,
		   (select Organization_Name from organization_profiles where organization_profiles.id=igm_sup_detail_container.off_dock_id) as offdock_name,agent_do,do_date,be_no,be_date,cnf_lic_no,update_ton
		   from  igm_supplimentary_detail
		   inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
		   inner join igm_masters on igm_supplimentary_detail.igm_master_id=igm_masters.id
		   left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
		   left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
		   where igm_supplimentary_detail.Import_Rotation_No='$ddl_imp_rot_no' and igm_supplimentary_detail.BL_No='$ddl_bl_no' 
		   group by igm_sup_detail_container.id";*/
		   
		  /* $sqlContainer="select igm_supplimentary_detail.id,IFNULL(sum(rcv_pack+loc_first),0) as rcv_pack,igm_masters.Vessel_Name,igm_supplimentary_detail.Import_Rotation_No,
							igm_sup_detail_container.cont_number,Pack_Marks_Number,shed_loc,shed_yard,Description_of_Goods,Notify_name,IFNULL(shed_tally_info.verify_number,0) as verify_number,
							IFNULL(shed_tally_info.id,0) as verify_id,igm_supplimentary_detail.Pack_Number,igm_supplimentary_detail.Pack_Description,
							igm_supplimentary_detail.BL_No,igm_sup_detail_container.cont_size,igm_sup_detail_container.cont_status,
							verify_other_data.cnf_name,verify_other_data.be_no,verify_other_data.be_date
							 from  igm_supplimentary_detail
							 inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
							 inner join igm_masters on igm_supplimentary_detail.igm_master_id=igm_masters.id
							 left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
							 left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
						   where igm_supplimentary_detail.Import_Rotation_No='$ddl_imp_rot_no' and igm_supplimentary_detail.BL_No='$ddl_bl_no' 
						   ";
		   //echo $sqlContainer;
		   $rtnContainerList = $this->bm->dataSelectDb1($sqlContainer);
		   $data['rtnContainerList']=$rtnContainerList;
		   
		    $sqlAppraisementQuery="select equipment,appraise_date,carpainter_use,hosting_charge,extra_movement,scale_for from appraisement_info 
									where rotation='$ddl_imp_rot_no' and BL_NO='$ddl_bl_no'";
		    $rtnAppraisementList = $this->bm->dataSelectDb1($sqlAppraisementQuery);
			
			if(count($rtnAppraisementList)>0)
			{
				$appraiseFlag=1;
			}
			else{
				$appraiseFlag=0;
			}
		   //$data['rtnAppraisementList']=$rtnAppraisementList;
		   
		   $used_equipment=$rtnAppraisementList[0]['equipment'];
		   $appraise_date=$rtnAppraisementList[0]['appraise_date'];		   
		   $carpainter_use=$rtnAppraisementList[0]['carpainter_use'];
		   $hosting_charge=$rtnAppraisementList[0]['hosting_charge'];
		   $extra_movement=$rtnAppraisementList[0]['extra_movement'];
		   $scale_for=$rtnAppraisementList[0]['scale_for'];
		   
		   $containerNo=$rtnContainerList[0]['cont_number'];
		   $verify_id=$rtnContainerList[0]['verify_id'];
		   $verify_num=$rtnContainerList[0]['verify_number'];
		   //$cnf_lic_no=$rtnContainerList[0]['cnf_lic_no'];
		   
		   //$cnf_licQuery="SELECT name from ref_bizunit_scoped where id='$cnf_lic_no'";
		   //$rtnCnfName = $this->bm->dataSelect($cnf_licQuery);
		   //$cnf_name=$rtnCnfName[0]['name'];
		   
		   
		   $strID = "select count(*) as rtnValue from sparcsn4.inv_unit
			 inner join sparcsn4.srv_event on sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey
			 where id='$containerNo' and  category='IMPRT' and event_type_gkey=30";
		   $rtnValue = $this->bm->dataReturn($strID);
		   
		   if($rtnValue<1)
		   {
			$msg="<font color='red'><b>CARGO IS NOT UNSTUFFED.</b></font>";
		   }
		   else
		   {
			if($verify_id==0)
			{
			 $msg="<font color='red'><b>NOT VERIFIED YET</b></font>";
			}
		   }
		   $data['used_equipment']=$used_equipment;
		   $data['appraise_date']=$appraise_date;
		   $data['carpainter_use']=$carpainter_use;
		   $data['hosting_charge']=$hosting_charge;
		   $data['extra_movement']=$extra_movement;
		   $data['scale_for']=$scale_for;
		   
		   $data['unstuff_flag']=$rtnValue;
		   $data['appraiseFlag']=$appraiseFlag;
		   $data['verify_id']=$verify_id;
		   $data['verify_num']=$verify_num;
		   $data['cnf_name']=$cnf_name;
		   $data['ddl_imp_rot_no']=$ddl_imp_rot_no;
		   $data['ddl_bl_no']=$ddl_bl_no;
		  // $data['userip']=$userip;  //user ip
		  // $data['login_id']=$login_id;  //user id
		   $data['msg']=$msg;
		   $data['title']="APPRAISEMENT SECTION...";
		   $this->load->view('header5');
		   $this->load->view('appraisementSectionHTML',$data);
		   $this->load->view('footer_1');
		  }
		 }*/
		 
		/* function appraisementVerify()
		 {
		  $session_id = $this->session->userdata('value');
		  
		  $igm_sup_detail_id=$this->input->post('id');
		  
		  if($session_id!=$this->session->userdata('session_id'))
		  {
		   $this->logout();
		  }
		   
		  else
		  {
		   $login_id = $this->session->userdata('login_id');
		  // $ipaddr = $_SERVER['REMOTE_ADDR'];
		   
		   $ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		   $ddl_bl_no=$this->input->post('ddl_bl_no');
		  // $login_id=$this->input->post('login_id');
		   $userip=$_SERVER['REMOTE_ADDR'];
		   $used_equipment=$this->input->post('used_equipment');
		   $appraise_date=$this->input->post('appraise_date');
		   
		   $carpainter_use=$this->input->post('carpainter_use');
		   $hosting_charge=$this->input->post('hosting_charge');
		   $extra_movement=$this->input->post('extra_movement');
		   $scale_for=$this->input->post('scale_for');
		   
		   $chkAppraisement="select 1 as rtnVal from appraisement_info where rotation='$ddl_imp_rot_no' and BL_NO='$ddl_bl_no'";
		   $rtnAppraisement = $this->bm->dataSelectDb1($chkAppraisement);
		   if($rtnAppraisement[0]['rtnVal']== 1)
		   {
			   $strInsertVerifyOther = "update appraisement_info set equipment='$used_equipment',appraise_date='$appraise_date',
										carpainter_use='$carpainter_use',hosting_charge='$hosting_charge'
										,extra_movement='$extra_movement',scale_for='$scale_for',
										user_id='$login_id',user_ip='$userip',last_update=now()
										where rotation='$ddl_imp_rot_no' and BL_NO='$ddl_bl_no'";
										$sucMsg = "APPRAISEMENT UPDATED SUCCESSFULLY";
										$unSucMsg = "APPRAISEMENT NOT UPDATED";
		   }
		   else
		   {
				$strInsertVerifyOther = "insert into appraisement_info (rotation,BL_NO,equipment,appraise_date,carpainter_use,hosting_charge
									,extra_movement,scale_for,user_id,user_ip,last_update) 
									values ('$ddl_imp_rot_no','$ddl_bl_no','$used_equipment','$appraise_date','$carpainter_use','$hosting_charge',
									'$extra_movement','$scale_for','$login_id','$userip',now())";									
									$sucMsg = "APPRAISEMENT SAVE SUCCESSFULLY";
									$unSucMsg = "APPRAISEMENT NOT SAVE";
		   }
		   
		   $stat = $this->bm->dataInsertDB1($strInsertVerifyOther);
		   
		   $data['msg']="";
		   if($stat==1)
			$msgPO="<font color='green'><b>".$sucMsg."</font>";
		   else
			$msgPO="<font color='red'><b>".$unSucMsg."<font color='red'><b>";
		  
		  $sqlContainer="select igm_supplimentary_detail.id,IFNULL(sum(rcv_pack+loc_first),0) as rcv_pack,igm_masters.Vessel_Name,igm_supplimentary_detail.Import_Rotation_No,
							igm_sup_detail_container.cont_number,Pack_Marks_Number,shed_loc,shed_yard,Description_of_Goods,Notify_name,IFNULL(shed_tally_info.verify_number,0) as verify_number,
							IFNULL(shed_tally_info.id,0) as verify_id,igm_supplimentary_detail.Pack_Number,igm_supplimentary_detail.Pack_Description,
							igm_supplimentary_detail.BL_No,igm_sup_detail_container.cont_size,igm_sup_detail_container.cont_status,
							verify_other_data.cnf_name,verify_other_data.be_no,verify_other_data.be_date
							 from  igm_supplimentary_detail
							 inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
							 inner join igm_masters on igm_supplimentary_detail.igm_master_id=igm_masters.id
							 left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
							 left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
						   where igm_supplimentary_detail.Import_Rotation_No='$ddl_imp_rot_no' and igm_supplimentary_detail.BL_No='$ddl_bl_no' 
						   ";
		   //echo $sqlContainer;
		   $rtnContainerList = $this->bm->dataSelectDb1($sqlContainer);
		   $data['rtnContainerList']=$rtnContainerList;
		   
		    $sqlAppraisementQuery="select equipment,appraise_date,carpainter_use,hosting_charge,extra_movement,scale_for from appraisement_info 
									where rotation='$ddl_imp_rot_no' and BL_NO='$ddl_bl_no'";
		    $rtnAppraisementList = $this->bm->dataSelectDb1($sqlAppraisementQuery);
			if(count($rtnAppraisementList)>0)
			{
				$appraiseFlag=1;
			}
			else{
				$appraiseFlag=0;
			}
		   //$data['rtnAppraisementList']=$rtnAppraisementList;
		   
		   $used_equipment=$rtnAppraisementList[0]['equipment'];
		   $appraise_date=$rtnAppraisementList[0]['appraise_date'];		   
		   $carpainter_use=$rtnAppraisementList[0]['carpainter_use'];
		   $hosting_charge=$rtnAppraisementList[0]['hosting_charge'];
		   $extra_movement=$rtnAppraisementList[0]['extra_movement'];
		   $scale_for=$rtnAppraisementList[0]['scale_for'];
		   
		   $containerNo=$rtnContainerList[0]['cont_number'];
		   $verify_id=$rtnContainerList[0]['verify_id'];
		   $verify_num=$rtnContainerList[0]['verify_number'];
		  
		   $data['used_equipment']=$used_equipment;
		   $data['appraise_date']=$appraise_date;
		   $data['carpainter_use']=$carpainter_use;
		   $data['hosting_charge']=$hosting_charge;
		   $data['extra_movement']=$extra_movement;
		   $data['scale_for']=$scale_for;
		   
		   $data['unstuff_flag']=1;
		   $data['appraiseFlag']=$appraiseFlag;
		   $data['verify_id']=$verify_id;
		   $data['verify_num']=$verify_num;
		   $data['cnf_name']=$cnf_name;
		   $data['ddl_imp_rot_no']=$ddl_imp_rot_no;
		   $data['ddl_bl_no']=$ddl_bl_no;
		   $data['msg']=$msg;
		   $data['msgPO']=$msgPO;
		   $data['title']="APPRAISEMENT SECTION...";
		   $this->load->view('header5');
		   $this->load->view('appraisementSectionHTML',$data);
		   $this->load->view('footer_1'); 
		  }
		 }
		  
		 //Appraisement section end
		 */
		 //Appraisement section start
		//Appraisement section start
		  function appraisementCertifySection()
		  {
		   $session_id = $this->session->userdata('value');
		   if($session_id!=$this->session->userdata('session_id'))
		   {
			$this->logout();
			
		   }
		   else
		   {
			$data['msg']="";
			$data['unstuff_flag']="";
			$data['verify_number']="-1";
			$data['title']="APPRAISEMENT SECTION...";
			$data['userip']=$_SERVER['REMOTE_ADDR'];
			$this->load->view('header5');
			$this->load->view('appraisementSectionHTML',$data);
			$this->load->view('footer_1');
		   } 
		  
		  }
		  
		  function appraisementCertifyList()
		  { 
		   $session_id = $this->session->userdata('value');
		   if($session_id!=$this->session->userdata('session_id'))
		   {
			$this->logout();
			
		   }
		   else
		   {

		   if($this->input->post('ddl_imp_rot_no') && $this->input->post('ddl_bl_no'))
				{
					$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
					$ddl_bl_no=$this->input->post('ddl_bl_no');

				}
				else{
					$ddl_bl_no=str_replace("_","/",$this->uri->segment(3));
					$ddl_imp_rot_no=str_replace("_","/",$this->uri->segment(4));
					//$ddl_imp_rot_no=$this->uri->segment(4);
					//$rot_year=$this->uri->segment(4);
					//$rot_no=$this->uri->segment(5);
					//$ddl_imp_rot_no=$rot_year.'/'.$rot_no;
				}
		   /*$sqlContainer="select igm_supplimentary_detail.id,IFNULL(sum(rcv_pack),0) as rcv_pack,igm_masters.Vessel_Name,igm_supplimentary_detail.Import_Rotation_No,
						  igm_sup_detail_container.cont_number,Pack_Marks_Number,shed_loc,shed_yard,Description_of_Goods,ConsigneeDesc,NotifyDesc,Notify_name,cont_size,
						  cont_weight,cont_seal_number,cont_status,cont_height,cont_iso_type,IFNULL(shed_tally_info.verify_number,0) as verify_number,
						  shed_tally_info.wr_upto_date,shed_tally_info.verify_by,shed_tally_info.verify_time,shed_tally_info.wr_upto_date,IFNULL(shed_tally_info.id,0) as verify_id,
		   (select Organization_Name from organization_profiles where organization_profiles.id=igm_sup_detail_container.off_dock_id) as offdock_name,agent_do,do_date,be_no,be_date,cnf_lic_no,update_ton
		   from  igm_supplimentary_detail
		   inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
		   inner join igm_masters on igm_supplimentary_detail.igm_master_id=igm_masters.id
		   left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
		   left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
		   where igm_supplimentary_detail.Import_Rotation_No='$ddl_imp_rot_no' and igm_supplimentary_detail.BL_No='$ddl_bl_no' 
		   group by igm_sup_detail_container.id";*/
		   
			$chkExchangeDoneQry="select count(shed_tally_info.id) as exchangeCount from shed_tally_info 
								inner join igm_supplimentary_detail on
								shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
								where shed_tally_info.exchange_done_status=1 and shed_tally_info.import_rotation='$ddl_imp_rot_no' and 
								igm_supplimentary_detail.BL_No='$ddl_bl_no'";
		    $rtnchkExchangeDoneList = $this->bm->dataSelectDb1($chkExchangeDoneQry);
			$excngeDoneStat=$rtnchkExchangeDoneList[0]['exchangeCount'];
			
			if($excngeDoneStat<1)
			{
				$data['excngeDoneStat']=$excngeDoneStat;
				$msg="<font color='red'><b>THIS CONTAINER IS NOT YET UNSTUFFED.</b></font>";
			}			
		   else
		   {		   
		   $sqlContainer="select igm_supplimentary_detail.id,IFNULL(total_pack,0) as rcv_pack,igm_masters.Vessel_Name,igm_supplimentary_detail.Import_Rotation_No,
							igm_sup_detail_container.cont_number,Pack_Marks_Number,shed_loc,shed_yard,Description_of_Goods,Notify_name,IFNULL(shed_tally_info.verify_number,0) as verify_number,
							IFNULL(shed_tally_info.id,0) as verify_id,igm_supplimentary_detail.Pack_Number,igm_supplimentary_detail.Pack_Description,
							igm_supplimentary_detail.BL_No,igm_sup_detail_container.cont_size,igm_sup_detail_container.cont_status,verify_other_data.cnf_lic_no,
							verify_other_data.cnf_name,verify_other_data.be_no,verify_other_data.be_date,shed_tally_info.total_pack as rcvTally,shed_tally_info.rcv_unit,
							igm_sup_detail_container.Cont_gross_weight as Cont_gross_weight
							 from  igm_supplimentary_detail
							 inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
							 inner join igm_masters on igm_supplimentary_detail.igm_master_id=igm_masters.id
							 left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
							 left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
						   where igm_supplimentary_detail.Import_Rotation_No='$ddl_imp_rot_no' and igm_supplimentary_detail.BL_No='$ddl_bl_no' 
						   limit 1";
		   //echo $sqlContainer;
		   $rtnContainerList = $this->bm->dataSelectDb1($sqlContainer);
		   $data['rtnContainerList']=$rtnContainerList;
		   
		   $getId=$rtnContainerList[0]['id'];
		   
		   $queryGetUnit="select SUM(IFNULL(shed_tally_info.total_pack,0)) as rcvTally,shed_tally_info.rcv_unit,shed_tally_info.shed_loc
							 from  igm_supplimentary_detail
							 inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
							 inner join igm_masters on igm_supplimentary_detail.igm_master_id=igm_masters.id
							 left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
							 left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
						     where igm_supplimentary_detail.id='$getId'
							 group by shed_tally_info.shed_loc,shed_tally_info.rcv_unit";
		   $rtnUnitList = $this->bm->dataSelectDb1($queryGetUnit);
		   $data['rtnUnitList']=$rtnUnitList;
		    $sqlAppraisementQuery="select equipment,appraise_date,carpainter_use,hosting_charge,extra_movement,scale_for,equipment_id from appraisement_info 
									where rotation='$ddl_imp_rot_no' and BL_NO='$ddl_bl_no'";
		    $rtnAppraisementList = $this->bm->dataSelectDb1($sqlAppraisementQuery);
			
			if(count($rtnAppraisementList)>0)
			{
				$appraiseFlag=1;
			}
			else{
				$appraiseFlag=0;
			}
		   //$data['rtnAppraisementList']=$rtnAppraisementList;
		   
		   $used_equipment=$rtnAppraisementList[0]['equipment'];
		   $equip_id=$rtnAppraisementList[0]['equipment_id'];
		   $appraise_date=$rtnAppraisementList[0]['appraise_date'];		   
		   $carpainter_use=$rtnAppraisementList[0]['carpainter_use'];
		   $hosting_charge=$rtnAppraisementList[0]['hosting_charge'];
		   $extra_movement=$rtnAppraisementList[0]['extra_movement'];
		   $scale_for=$rtnAppraisementList[0]['scale_for'];
		   
		   $containerNo=$rtnContainerList[0]['cont_number'];
		   $verify_id=$rtnContainerList[0]['verify_id'];
		   $verify_num=$rtnContainerList[0]['verify_number'];
		   //$cnf_lic_no=$rtnContainerList[0]['cnf_lic_no'];
		   
		   //$cnf_licQuery="SELECT name from ref_bizunit_scoped where id='$cnf_lic_no'";
		   //$rtnCnfName = $this->bm->dataSelect($cnf_licQuery);
		   //$cnf_name=$rtnCnfName[0]['name'];
		   
		   
		   /*$strID = "select count(*) as rtnValue from sparcsn4.inv_unit
			 inner join sparcsn4.srv_event on sparcsn4.srv_event.applied_to_gkey=sparcsn4.inv_unit.gkey
			 where id='$containerNo' and  category='IMPRT' and event_type_gkey=30";
		   $rtnValue = $this->bm->dataReturn($strID);*/ //need not check to N4 according to zakir vai,2017/09/06//
		   $rtnValue=1;
		   if($rtnValue<1)
		   {
			$msg="<font color='red'><b>CARGO IS NOT UNSTUFFED.</b></font>";
		   }
		   else
		   {
			if($verify_id==0)
			{
			 $msg="<font color='red'><b>NOT VERIFIED YET</b></font>";
			}
		   }
		   $getUsedEquipmentQuery= "select equipment_id,equipment_name,equipment_charge,remarks from used_equipment order by equipment_id asc";
		   $getUsedEquipment = $this->bm->dataSelectDb1($getUsedEquipmentQuery);
			
		   $data['getUsedEquipment']=$getUsedEquipment;
		   
		   $data['used_equipment']=$used_equipment;
		   $data['equip_charge']=$equip_charge;
		   $data['appraise_date']=$appraise_date;
		   $data['carpainter_use']=$carpainter_use;
		   $data['hosting_charge']=$hosting_charge;
		   $data['extra_movement']=$extra_movement;
		   $data['scale_for']=$scale_for;
		   
		   $data['unstuff_flag']=$rtnValue;
		   $data['appraiseFlag']=$appraiseFlag;
		   $data['verify_id']=$verify_id;
		   $data['verify_num']=$verify_num;
		   $data['cnf_name']=$cnf_name;
		   $data['ddl_imp_rot_no']=$ddl_imp_rot_no;
		   $data['ddl_bl_no']=$ddl_bl_no;
		   }
		  // $data['userip']=$userip;  //user ip
		  // $data['login_id']=$login_id;  //user id
		   $data['msg']=$msg;
		   $data['title']="APPRAISEMENT SECTION...";
		   $this->load->view('header5');
		   $this->load->view('appraisementSectionHTML',$data);
		   $this->load->view('footer_1');
		  }
		 }
		 
		 function appraisementVerify()
		 {
		  $session_id = $this->session->userdata('value');
		  
		  $igm_sup_detail_id=$this->input->post('id');
		  
		  if($session_id!=$this->session->userdata('session_id'))
		  {
		   $this->logout();
		  }
		   
		  else
		  {
		   $login_id = $this->session->userdata('login_id');
		   //$ipaddr = $_SERVER['REMOTE_ADDR'];
		   
		   $ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		   $ddl_bl_no=$this->input->post('ddl_bl_no');
		  // $login_id=$this->input->post('login_id');
		   $userip=$_SERVER['REMOTE_ADDR'];
		   $used_equipment=$this->input->post('used_equipment');
		   $equip_charge=$this->input->post('equip_charge');		   
		   $appraise_date=$this->input->post('appraise_date');
		   
		   $carpainter_use=$this->input->post('carpainter_use');
		   $hosting_charge=$this->input->post('hosting_charge');
		   $extra_movement=$this->input->post('extra_movement');
		   $scale_for=$this->input->post('scale_for');
		   
		   $chkAppraisement="select 1 as rtnVal from appraisement_info where rotation='$ddl_imp_rot_no' and BL_NO='$ddl_bl_no'";
		   $rtnAppraisement = $this->bm->dataSelectDb1($chkAppraisement);
		   if($rtnAppraisement[0]['rtnVal']== 1)
		   {
			   $strInsertVerifyOther = "update appraisement_info set equipment='$equip_charge',appraise_date='$appraise_date',
										carpainter_use='$carpainter_use',hosting_charge='$hosting_charge'
										,extra_movement='$extra_movement',scale_for='$scale_for',
										user_id='$login_id',user_ip='$userip',last_update=now(),equipment_id='$used_equipment'
										where rotation='$ddl_imp_rot_no' and BL_NO='$ddl_bl_no'";
										$sucMsg = "APPRAISEMENT UPDATED SUCCESSFULLY";
										$unSucMsg = "APPRAISEMENT NOT UPDATED";
		   }
		   else
		   {
				$strInsertVerifyOther = "insert into appraisement_info (rotation,BL_NO,equipment,appraise_date,carpainter_use,hosting_charge
									,extra_movement,scale_for,user_id,user_ip,last_update,equipment_id) 
									values ('$ddl_imp_rot_no','$ddl_bl_no','$equip_charge','$appraise_date','$carpainter_use','$hosting_charge',
									'$extra_movement','$scale_for','$login_id','$userip',now(),'$used_equipment')";									
									$sucMsg = "APPRAISEMENT SAVE SUCCESSFULLY";
									$unSucMsg = "APPRAISEMENT NOT SAVE";
		   }
		   
		   $stat = $this->bm->dataInsertDB1($strInsertVerifyOther);
		   
		   $chkVerifyOtherData="select shed_tally_info.id
							 from  igm_supplimentary_detail
							 inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
							 inner join igm_masters on igm_supplimentary_detail.igm_master_id=igm_masters.id
							 left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
							 left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
								where igm_supplimentary_detail.Import_Rotation_No='$ddl_imp_rot_no' and igm_supplimentary_detail.BL_No='$ddl_bl_no'";
		   $chkVerifyOther = $this->bm->dataSelectDb1($chkVerifyOtherData);
		   $shedTallyID=$chkVerifyOther[0]['id'];
		   
		   $cnfLicense=$this->input->post('cnfLicense');
		   $cnfName=$this->input->post('cnfName');
		   $beNo=$this->input->post('beNo');
		   $beDate=$this->input->post('beDate');
		   
		   $chkOtherQuery="select 1 as rtnVal from verify_other_data where shed_tally_id='$shedTallyID'";
		   $rtnChkOther = $this->bm->dataSelectDb1($chkOtherQuery);
		   $shedRtnValue=$rtnChkOther[0]['rtnVal'];
		   
		   if($shedRtnValue == 1)
		   {
			     $strInsertVerifyOtherData = "update verify_other_data set cnf_lic_no='$cnfLicense',cnf_name='$cnfName',
										be_no='$beNo',be_date='$beDate'
										where shed_tally_id='$shedTallyID'";
										//$sucMsg = "APPRAISEMENT UPDATED SUCCESSFULLY";
										//$unSucMsg = "APPRAISEMENT NOT UPDATED";
		   }
		   else{
			   	$strInsertVerifyOtherData = "insert into verify_other_data ( shed_tally_id,cnf_lic_no,cnf_name,be_no,be_date,last_update,update_by,user_ip) 
									values ('$shedTallyID','$cnfLicense','$cnfName','$beNo','$beDate',now(),'$login_id','$userip')";									
									//$sucMsg = "APPRAISEMENT SAVE SUCCESSFULLY";
									//$unSucMsg = "APPRAISEMENT NOT SAVE";
		   }
		    //echo $strInsertVerifyOtherData;
		    $statOther = $this->bm->dataInsertDB1($strInsertVerifyOtherData);
		   
		   $data['msg']="";
		   if($stat==1)
			$msgPO="<font color='green'><b>".$sucMsg."</font>";
		   else
			$msgPO="<font color='red'><b>".$unSucMsg."<font color='red'><b>";
		  
		  $sqlContainer="select igm_supplimentary_detail.id,IFNULL(sum(rcv_pack+loc_first),0) as rcv_pack,igm_masters.Vessel_Name,igm_supplimentary_detail.Import_Rotation_No,
							igm_sup_detail_container.cont_number,Pack_Marks_Number,shed_loc,shed_yard,Description_of_Goods,Notify_name,IFNULL(shed_tally_info.verify_number,0) as verify_number,
							IFNULL(shed_tally_info.id,0) as verify_id,igm_supplimentary_detail.Pack_Number,igm_supplimentary_detail.Pack_Description,
							igm_supplimentary_detail.BL_No,igm_sup_detail_container.cont_size,igm_sup_detail_container.cont_status,verify_other_data.cnf_lic_no,
							verify_other_data.cnf_name,verify_other_data.be_no,verify_other_data.be_date,shed_tally_info.total_pack as rcvTally,shed_tally_info.rcv_unit,
							igm_sup_detail_container.Cont_gross_weight as Cont_gross_weight
							 from  igm_supplimentary_detail
							 inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
							 inner join igm_masters on igm_supplimentary_detail.igm_master_id=igm_masters.id
							 left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
							 left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
						   where igm_supplimentary_detail.Import_Rotation_No='$ddl_imp_rot_no' and igm_supplimentary_detail.BL_No='$ddl_bl_no' 
						   ";
		   //echo $sqlContainer;
		   $rtnContainerList = $this->bm->dataSelectDb1($sqlContainer);
		   $data['rtnContainerList']=$rtnContainerList;
		   
		    $sqlAppraisementQuery="select equipment,appraise_date,carpainter_use,hosting_charge,extra_movement,scale_for,equipment_id from appraisement_info 
									where rotation='$ddl_imp_rot_no' and BL_NO='$ddl_bl_no'";
		    $rtnAppraisementList = $this->bm->dataSelectDb1($sqlAppraisementQuery);
			if(count($rtnAppraisementList)>0)
			{
				$appraiseFlag=1;
			}
			else{
				$appraiseFlag=0;
			}
		   //$data['rtnAppraisementList']=$rtnAppraisementList;
		   
		   $used_equipment=$rtnAppraisementList[0]['equipment_id'];
		   $equip_charge=$rtnAppraisementList[0]['equipment'];
		   $appraise_date=$rtnAppraisementList[0]['appraise_date'];		   
		   $carpainter_use=$rtnAppraisementList[0]['carpainter_use'];
		   $hosting_charge=$rtnAppraisementList[0]['hosting_charge'];
		   $extra_movement=$rtnAppraisementList[0]['extra_movement'];
		   $scale_for=$rtnAppraisementList[0]['scale_for'];
		   
		   $containerNo=$rtnContainerList[0]['cont_number'];
		   $verify_id=$rtnContainerList[0]['verify_id'];
		   $verify_num=$rtnContainerList[0]['verify_number'];
		  
		   $data['used_equipment']=$used_equipment;
		   $data['appraise_date']=$appraise_date;
		   $data['carpainter_use']=$carpainter_use;
		   $data['hosting_charge']=$hosting_charge;
		   $data['extra_movement']=$extra_movement;
		   $data['scale_for']=$scale_for;
		   
		   $data['unstuff_flag']=1;
		   $data['appraiseFlag']=$appraiseFlag;
		   $data['verify_id']=$verify_id;
		   $data['verify_num']=$verify_num;
		   $data['cnf_name']=$cnf_name;
		   $data['ddl_imp_rot_no']=$ddl_imp_rot_no;
		   $data['ddl_bl_no']=$ddl_bl_no;
		   $data['msg']=$msg;
		   $data['msgPO']=$msgPO;
		   $data['title']="APPRAISEMENT SECTION...";
		   $this->load->view('header5');
		   $this->load->view('appraisementSectionHTML',$data);
		   $this->load->view('footer_1'); 
		  }
		 }
		  function appraisementCertifySectionEdit()
		  {
		   $session_id = $this->session->userdata('value');
		   if($session_id!=$this->session->userdata('session_id'))
		   {
			$this->logout();
			
		   }
		   else
		   {
			$data['msg']="";
			$data['unstuff_flag']="";
			$data['verify_number']="-1";
			$data['title']="APPRAISEMENT EDIT SECTION...";
			$data['userip']=$_SERVER['REMOTE_ADDR'];
			$this->load->view('header5');
			$this->load->view('appraisementEditSectionHTML',$data);
			$this->load->view('footer_1');
		   } 
		  
		  }
		  function appraisementCertifyListEdit()
		  { 
		   $session_id = $this->session->userdata('value');
		   if($session_id!=$this->session->userdata('session_id'))
		   {
			$this->logout();
			
		   }
		   else
		   {

		   if($this->input->post('ddl_imp_rot_no') && $this->input->post('ddl_bl_no'))
				{
					$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
					$ddl_bl_no=$this->input->post('ddl_bl_no');

				}
				else{
					$ddl_bl_no=str_replace("_","/",$this->uri->segment(3));
					$ddl_imp_rot_no=str_replace("_","/",$this->uri->segment(4));
					
				}
			$chkExchangeDoneQry="select count(shed_tally_info.id) as exchangeCount from shed_tally_info 
								inner join igm_supplimentary_detail on
								shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
								where shed_tally_info.exchange_done_status=1 and shed_tally_info.import_rotation='$ddl_imp_rot_no' and 
								igm_supplimentary_detail.BL_No='$ddl_bl_no'";
		    $rtnchkExchangeDoneList = $this->bm->dataSelectDb1($chkExchangeDoneQry);
			$excngeDoneStat=$rtnchkExchangeDoneList[0]['exchangeCount'];
			
			if($excngeDoneStat<1)
			{
				$data['excngeDoneStat']=$excngeDoneStat;
				$msg="<font color='red'><b>THIS CONTAINER IS NOT YET UNSTUFFED.</b></font>";
			}			
		   else
		   {		   
		   $sqlContainer="select igm_supplimentary_detail.id,IFNULL(total_pack,0) as rcv_pack,igm_masters.Vessel_Name,igm_supplimentary_detail.Import_Rotation_No,
							igm_sup_detail_container.cont_number,Pack_Marks_Number,shed_loc,shed_yard,Description_of_Goods,Notify_name,IFNULL(shed_tally_info.verify_number,0) as verify_number,
							IFNULL(shed_tally_info.id,0) as verify_id,igm_supplimentary_detail.Pack_Number,igm_supplimentary_detail.Pack_Description,
							igm_supplimentary_detail.BL_No,igm_sup_detail_container.cont_size,igm_sup_detail_container.cont_status,verify_other_data.cnf_lic_no,
							verify_other_data.cnf_name,verify_other_data.be_no,verify_other_data.be_date,shed_tally_info.total_pack as rcvTally,shed_tally_info.rcv_unit,
							igm_sup_detail_container.Cont_gross_weight as Cont_gross_weight
							 from  igm_supplimentary_detail
							 inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
							 inner join igm_masters on igm_supplimentary_detail.igm_master_id=igm_masters.id
							 left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
							 left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
						   where igm_supplimentary_detail.Import_Rotation_No='$ddl_imp_rot_no' and igm_supplimentary_detail.BL_No='$ddl_bl_no' 
						   limit 1
						   ";
		   //echo $sqlContainer;
		   $rtnContainerList = $this->bm->dataSelectDb1($sqlContainer);
		   $data['rtnContainerList']=$rtnContainerList;
		   
		   $getId=$rtnContainerList[0]['id'];
		   $queryGetUnit="select SUM(IFNULL(shed_tally_info.total_pack,0)) as rcvTally,shed_tally_info.rcv_unit,shed_tally_info.shed_loc
							 from  igm_supplimentary_detail
							 inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
							 inner join igm_masters on igm_supplimentary_detail.igm_master_id=igm_masters.id
							 left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
							 left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
						     where igm_supplimentary_detail.id='$getId'
							 group by shed_tally_info.shed_loc,shed_tally_info.rcv_unit";
		   $rtnUnitList = $this->bm->dataSelectDb1($queryGetUnit);
		   $data['rtnUnitList']=$rtnUnitList;
		   
		    $sqlAppraisementQuery="select equipment,appraise_date,carpainter_use,hosting_charge,extra_movement,scale_for,equipment_id from appraisement_info 
									where rotation='$ddl_imp_rot_no' and BL_NO='$ddl_bl_no'";
		    $rtnAppraisementList = $this->bm->dataSelectDb1($sqlAppraisementQuery);
			
			if(count($rtnAppraisementList)>0)
			{
				$appraiseFlag=1;
			}
			else{
				$appraiseFlag=0;
			}
		   //$data['rtnAppraisementList']=$rtnAppraisementList;
		   
		   $used_equipment=$rtnAppraisementList[0]['equipment_id'];
		   $equip_charge=$rtnAppraisementList[0]['equipment'];
		   $appraise_date=$rtnAppraisementList[0]['appraise_date'];		   
		   $carpainter_use=$rtnAppraisementList[0]['carpainter_use'];
		   $hosting_charge=$rtnAppraisementList[0]['hosting_charge'];
		   $extra_movement=$rtnAppraisementList[0]['extra_movement'];
		   $scale_for=$rtnAppraisementList[0]['scale_for'];
		   
		   $containerNo=$rtnContainerList[0]['cont_number'];
		   $verify_id=$rtnContainerList[0]['verify_id'];
		   $verify_num=$rtnContainerList[0]['verify_number'];
		   $rtnValue=1;
		   if($rtnValue<1)
		   {
			$msg="<font color='red'><b>CARGO IS NOT UNSTUFFED.</b></font>";
		   }
		   else
		   {
			if($verify_id==0)
			{
			 $msg="<font color='red'><b>NOT VERIFIED YET</b></font>";
			}
		   }
		   $getUsedEquipmentQuery= "select equipment_id,equipment_name,equipment_charge,remarks from used_equipment order by equipment_id asc";
		   $getUsedEquipment = $this->bm->dataSelectDb1($getUsedEquipmentQuery);
			
		   $data['getUsedEquipment']=$getUsedEquipment;
		   $data['used_equipment']=$used_equipment;
		   $data['equip_charge']=$equip_charge;
		   $data['appraise_date']=$appraise_date;
		   $data['carpainter_use']=$carpainter_use;
		   $data['hosting_charge']=$hosting_charge;
		   $data['extra_movement']=$extra_movement;
		   $data['scale_for']=$scale_for;
		   
		   $data['unstuff_flag']=$rtnValue;
		   $data['appraiseFlag']=$appraiseFlag;
		   $data['verify_id']=$verify_id;
		   $data['verify_num']=$verify_num;
		   $data['cnf_name']=$cnf_name;
		   $data['ddl_imp_rot_no']=$ddl_imp_rot_no;
		   $data['ddl_bl_no']=$ddl_bl_no;
		   }
		   $data['msg']=$msg;
		   $data['title']="APPRAISEMENT EDIT SECTION...";
		   $this->load->view('header5');
		   $this->load->view('appraisementEditSectionHTML',$data);
		   $this->load->view('footer_1');
		  }
		 }
		  function appraisementVerifyEdit()
		 {
		  $session_id = $this->session->userdata('value');
		  
		  $igm_sup_detail_id=$this->input->post('id');
		  
		  if($session_id!=$this->session->userdata('session_id'))
		  {
		   $this->logout();
		  }
		   
		  else
		  {
		   $login_id = $this->session->userdata('login_id');
		   //$ipaddr = $_SERVER['REMOTE_ADDR'];
		   
		   $ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		   $ddl_bl_no=$this->input->post('ddl_bl_no');
		  // $login_id=$this->input->post('login_id');
		   $userip=$_SERVER['REMOTE_ADDR'];
		   $used_equipment=$this->input->post('used_equipment');
		   $equip_charge=$this->input->post('equip_charge');
		   $appraise_date=$this->input->post('appraise_date');
		   
		   $carpainter_use=$this->input->post('carpainter_use');
		   $hosting_charge=$this->input->post('hosting_charge');
		   $extra_movement=$this->input->post('extra_movement');
		   $scale_for=$this->input->post('scale_for');
		   
		   $chkAppraisement="select 1 as rtnVal from appraisement_info where rotation='$ddl_imp_rot_no' and BL_NO='$ddl_bl_no'";
		   $rtnAppraisement = $this->bm->dataSelectDb1($chkAppraisement);
		   if($rtnAppraisement[0]['rtnVal']== 1)
		   {
			   $strInsertVerifyOther = "update appraisement_info set equipment='$equip_charge',appraise_date='$appraise_date',
										carpainter_use='$carpainter_use',hosting_charge='$hosting_charge'
										,extra_movement='$extra_movement',scale_for='$scale_for',
										user_id='$login_id',user_ip='$userip',last_update=now(),equipment_id='$used_equipment'
										where rotation='$ddl_imp_rot_no' and BL_NO='$ddl_bl_no'";
										$sucMsg = "APPRAISEMENT UPDATED SUCCESSFULLY";
										$unSucMsg = "APPRAISEMENT NOT UPDATED";
		   }
		   else
		   {
				$strInsertVerifyOther = "insert into appraisement_info (rotation,BL_NO,equipment,appraise_date,carpainter_use,hosting_charge
									,extra_movement,scale_for,user_id,user_ip,last_update,equipment_id) 
									values ('$ddl_imp_rot_no','$ddl_bl_no','$equip_charge','$appraise_date','$carpainter_use','$hosting_charge',
									'$extra_movement','$scale_for','$login_id','$userip',now(),'$used_equipment')";									
									$sucMsg = "APPRAISEMENT SAVE SUCCESSFULLY";
									$unSucMsg = "APPRAISEMENT NOT SAVE";
		   }
		   
		   $stat = $this->bm->dataInsertDB1($strInsertVerifyOther);
		   
		   $chkVerifyOtherData="select shed_tally_info.id
							 from  igm_supplimentary_detail
							 inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
							 inner join igm_masters on igm_supplimentary_detail.igm_master_id=igm_masters.id
							 left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
							 left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
								where igm_supplimentary_detail.Import_Rotation_No='$ddl_imp_rot_no' and igm_supplimentary_detail.BL_No='$ddl_bl_no'";
		   $chkVerifyOther = $this->bm->dataSelectDb1($chkVerifyOtherData);
		   $shedTallyID=$chkVerifyOther[0]['id'];
		   
		   $cnfLicense=$this->input->post('cnfLicense');
		   $cnfName=$this->input->post('cnfName');
		   $beNo=$this->input->post('beNo');
		   $beDate=$this->input->post('beDate');
		   
		   $chkOtherQuery="select 1 as rtnVal from verify_other_data where shed_tally_id='$shedTallyID'";
		   $rtnChkOther = $this->bm->dataSelectDb1($chkOtherQuery);
		   $shedRtnValue=$rtnChkOther[0]['rtnVal'];
		   
		   if($shedRtnValue == 1)
		   {
			     $strInsertVerifyOtherData = "update verify_other_data set cnf_lic_no='$cnfLicense',cnf_name='$cnfName',
										be_no='$beNo',be_date='$beDate'
										where shed_tally_id='$shedTallyID'";
										//$sucMsg = "APPRAISEMENT UPDATED SUCCESSFULLY";
										//$unSucMsg = "APPRAISEMENT NOT UPDATED";
		   }
		   else{
			   	$strInsertVerifyOtherData = "insert into verify_other_data ( shed_tally_id,cnf_lic_no,cnf_name,be_no,be_date,last_update,update_by,user_ip) 
									values ('$shedTallyID','$cnfLicense','$cnfName','$beNo','$beDate',now(),'$login_id','$userip')";									
									//$sucMsg = "APPRAISEMENT SAVE SUCCESSFULLY";
									//$unSucMsg = "APPRAISEMENT NOT SAVE";
		   }
		    //echo $strInsertVerifyOtherData;
		    $statOther = $this->bm->dataInsertDB1($strInsertVerifyOtherData);
		   
		   $data['msg']="";
		   if($stat==1)
			$msgPO="<font color='green'><b>".$sucMsg."</font>";
		   else
			$msgPO="<font color='red'><b>".$unSucMsg."<font color='red'><b>";
		  
		  $sqlContainer="select igm_supplimentary_detail.id,IFNULL(sum(rcv_pack+loc_first),0) as rcv_pack,igm_masters.Vessel_Name,igm_supplimentary_detail.Import_Rotation_No,
							igm_sup_detail_container.cont_number,Pack_Marks_Number,shed_loc,shed_yard,Description_of_Goods,Notify_name,IFNULL(shed_tally_info.verify_number,0) as verify_number,
							IFNULL(shed_tally_info.id,0) as verify_id,igm_supplimentary_detail.Pack_Number,igm_supplimentary_detail.Pack_Description,
							igm_supplimentary_detail.BL_No,igm_sup_detail_container.cont_size,igm_sup_detail_container.cont_status,verify_other_data.cnf_lic_no,
							verify_other_data.cnf_name,verify_other_data.be_no,verify_other_data.be_date,shed_tally_info.total_pack as rcvTally,shed_tally_info.rcv_unit,
							igm_sup_detail_container.Cont_gross_weight as Cont_gross_weight
							 from  igm_supplimentary_detail
							 inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
							 inner join igm_masters on igm_supplimentary_detail.igm_master_id=igm_masters.id
							 left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
							 left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
						   where igm_supplimentary_detail.Import_Rotation_No='$ddl_imp_rot_no' and igm_supplimentary_detail.BL_No='$ddl_bl_no'
							limit 1
						   ";
		   //echo $sqlContainer;
		   $rtnContainerList = $this->bm->dataSelectDb1($sqlContainer);
		   $data['rtnContainerList']=$rtnContainerList;
		   
		   $getId=$rtnContainerList[0]['id'];
		   $queryGetUnit="select SUM(IFNULL(shed_tally_info.total_pack,0)) as rcvTally,shed_tally_info.rcv_unit,shed_tally_info.shed_loc
							 from  igm_supplimentary_detail
							 inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
							 inner join igm_masters on igm_supplimentary_detail.igm_master_id=igm_masters.id
							 left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
							 left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
						     where igm_supplimentary_detail.id='$getId'
							 group by shed_tally_info.shed_loc,shed_tally_info.rcv_unit";
		   $rtnUnitList = $this->bm->dataSelectDb1($queryGetUnit);
		   $data['rtnUnitList']=$rtnUnitList;
		   
		    $sqlAppraisementQuery="select equipment,appraise_date,carpainter_use,hosting_charge,extra_movement,scale_for,equipment_id from appraisement_info 
									where rotation='$ddl_imp_rot_no' and BL_NO='$ddl_bl_no'";
		    $rtnAppraisementList = $this->bm->dataSelectDb1($sqlAppraisementQuery);
			if(count($rtnAppraisementList)>0)
			{
				$appraiseFlag=1;
			}
			else{
				$appraiseFlag=0;
			}
		   //$data['rtnAppraisementList']=$rtnAppraisementList;
		   
		   $used_equipment=$rtnAppraisementList[0]['equipment_id'];
		   $equip_charge=$rtnAppraisementList[0]['equipment'];
		   $appraise_date=$rtnAppraisementList[0]['appraise_date'];		   
		   $carpainter_use=$rtnAppraisementList[0]['carpainter_use'];
		   $hosting_charge=$rtnAppraisementList[0]['hosting_charge'];
		   $extra_movement=$rtnAppraisementList[0]['extra_movement'];
		   $scale_for=$rtnAppraisementList[0]['scale_for'];
		   
		   $containerNo=$rtnContainerList[0]['cont_number'];
		   $verify_id=$rtnContainerList[0]['verify_id'];
		   $verify_num=$rtnContainerList[0]['verify_number'];
			
		   $getUsedEquipmentQuery= "select equipment_id,equipment_name,equipment_charge,remarks from used_equipment order by equipment_id asc";
		   $getUsedEquipment = $this->bm->dataSelectDb1($getUsedEquipmentQuery);
			
		   $data['getUsedEquipment']=$getUsedEquipment;
		  
		  
		   $data['used_equipment']=$used_equipment;
		   $data['equip_charge']=$equip_charge;
		   $data['appraise_date']=$appraise_date;
		   $data['carpainter_use']=$carpainter_use;
		   $data['hosting_charge']=$hosting_charge;
		   $data['extra_movement']=$extra_movement;
		   $data['scale_for']=$scale_for;
		   
		   $data['unstuff_flag']=1;
		   $data['appraiseFlag']=$appraiseFlag;
		   $data['verify_id']=$verify_id;
		   $data['verify_num']=$verify_num;
		   $data['cnf_name']=$cnf_name;
		   $data['ddl_imp_rot_no']=$ddl_imp_rot_no;
		   $data['ddl_bl_no']=$ddl_bl_no;
		   $data['msg']=$msg;
		   $data['msgPO']=$msgPO;
		   $data['title']="APPRAISEMENT EDIT SECTION...";
		   $this->load->view('header5');
		   $this->load->view('appraisementEditSectionHTML',$data);
		   $this->load->view('footer_1'); 
		  }
		 }
		 //Appraisement section end
		 //Appraisement section end
		 // APPRAISEMENT List Section Start
		function appraisementListForm()
		{	
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$str="select rotation,BL_NO,equipment,appraise_date,carpainter_use,hosting_charge,extra_movement,scale_for 
						from appraisement_info
						order by gkey desc";
				$rtnContainerList = $this->bm->dataSelectDb1($str);
				$data['rtnContainerList']=$rtnContainerList;
				$data['title']="APPRAISEMENT LIST REPORT...";
				$this->load->view('header2');
				$this->load->view('appraisementListHTML',$data);
				$this->load->view('footer');
			}
		}
		function appraisementListFormList()
				{
					$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
					$ddl_bl_no=$this->input->post('ddl_bl_no');
					
					$str="select rotation,BL_NO,equipment,appraise_date,carpainter_use,hosting_charge,extra_movement,scale_for 
							from appraisement_info where rotation='$ddl_imp_rot_no' and BL_NO='$ddl_bl_no'";
					
					$rtnContainerList = $this->bm->dataSelectDb1($str);
					//echo $rtnContainerList[0]['verify_number']."  fdfdfd";
					$data['rtnContainerList']=$rtnContainerList;
					$data['title']="APPRAISEMENT LIST REPORT...";
					$data['vNum']=$rtnContainerList[0]['BL_NO'];
					$this->load->view('header2');
					$this->load->view('appraisementListHTML',$data);
					$this->load->view('footer');
				
				}	
		// APPRAISEMENT List Section End
		
		// TALLY LIST Start
		function tallyListForm()
		{	
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$str="SELECT tally_sheet_number,import_rotation,cont_number,SUM(rcv_pack) AS rcv_pack,SUM(flt_pack) AS flt_pack,SUM(shed_loc) AS shed_loc,loc_first,wr_date,shed_yard 
				FROM shed_tally_info
				INNER JOIN igm_supplimentary_detail ON shed_tally_info.igm_sup_detail_id = igm_supplimentary_detail.id
				GROUP BY tally_sheet_number
				ORDER BY shed_tally_info.id DESC";
				
				$rtnContainerList = $this->bm->dataSelectDb1($str);
				$data['rtnContainerList']=$rtnContainerList;
				$data['title']="TALLY LIST REPORT...";
				$this->load->view('header2');
				$this->load->view('tallyListForm',$data);
				$this->load->view('footer');
			}
		}
		
		function tallyFormList()
		{
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
			$ddl_cont_no=$this->input->post('ddl_cont_no');
					
			/* $str="SELECT tally_sheet_number,import_rotation,cont_number,igm_supplimentary_detail.BL_NO,rcv_pack,flt_pack,
				shed_loc,loc_first,wr_date,shed_yard FROM shed_tally_info
				INNER JOIN igm_supplimentary_detail ON shed_tally_info.igm_sup_detail_id = igm_supplimentary_detail.id
				where import_rotation='$ddl_imp_rot_no' and cont_number='$ddl_cont_no'"; */
				
			$str="SELECT tally_sheet_number,import_rotation,cont_number,SUM(rcv_pack) AS rcv_pack,SUM(flt_pack) AS flt_pack,SUM(shed_loc) AS shed_loc,loc_first,wr_date,shed_yard 
			FROM shed_tally_info
			INNER JOIN igm_supplimentary_detail ON shed_tally_info.igm_sup_detail_id = igm_supplimentary_detail.id
			WHERE import_rotation='$ddl_imp_rot_no' AND cont_number='$ddl_cont_no'";	
					
			$rtnContainerList = $this->bm->dataSelectDb1($str);
			//echo $rtnContainerList[0]['verify_number']."  fdfdfd";
			$data['rtnContainerList']=$rtnContainerList;
			$data['title']="TALLY LIST REPORT...";
			$data['vNum']=$rtnContainerList[0]['BL_NO'];
			$this->load->view('header2');
			$this->load->view('tallyListForm',$data);
			$this->load->view('footer');
		}	
		// TALLY LIST End
		
			//Release Order Start
		function releaseOrderForm(){
		
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$data['msg']="";
				$data['unstuff_flag']="";
				$data['verify_number']="-1";
				$data['title']="RELEASE ORDER SECTION...";
				$this->load->view('header5');
				$this->load->view('releaseOrderForm',$data);
				$this->load->view('footer_1');
			}	
		
		}
		
		function releaseOrderFormView()
		{
			$verify_number=$this->input->post('verify_number');
			if($_POST['options']=='Bill')
			{
				$this->getShedBillPdf($verify_number);
			}
			else
			{
			$login_id = $this->session->userdata('login_id');
					
			$strBill="select igm_supplimentary_detail.id,IFNULL(sum(rcv_pack+loc_first),0) as rcv_pack,igm_masters.Vessel_Name,igm_supplimentary_detail.Import_Rotation_No,igm_sup_detail_container.cont_number,Pack_Marks_Number,shed_loc,shed_yard,Description_of_Goods,Notify_name,IFNULL(shed_tally_info.verify_number,0) as verify_number,IFNULL(shed_tally_info.id,0) as verify_id,igm_supplimentary_detail.Pack_Number,igm_supplimentary_detail.Pack_Description,igm_supplimentary_detail.BL_No,igm_sup_detail_container.cont_size,igm_sup_detail_container.cont_status,igm_sup_detail_container.cont_weight,verify_other_data.cnf_name,verify_other_data.be_no,verify_other_data.be_date,igm_sup_detail_container.cont_height,bank_bill_recv.bill_no,bank_bill_recv.cp_no,RIGHT(bank_bill_recv.cp_year,2) AS cp_year,bank_bill_recv.cp_bank_code,bank_bill_recv.cp_unit,date(bank_bill_recv.recv_time) as cp_date,igm_supplimentary_detail.Notify_address,igm_supplimentary_detail.Line_No,total_port,concat(right(YEAR(bill_date),2),'/',concat(if(length(bill_generation_no)=1,'00000',if(length(bill_generation_no)=2,'0000',if(length(bill_generation_no)=3,'000',if(length(bill_generation_no)=4,'00',if(length(bill_generation_no)=5,'0',''))))),bill_generation_no)) as master_bill_no,shed_bill_master.bill_date,VoyNo,verify_other_data.exit_note_number
			from  igm_supplimentary_detail
			inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
			inner join igm_masters on igm_supplimentary_detail.igm_master_id=igm_masters.id
			left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
			left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
			left join shed_bill_master on shed_bill_master.verify_no=shed_tally_info.verify_number
			left join bank_bill_recv on bank_bill_recv.bill_no=shed_bill_master.bill_no
			left join vessels_berth_detail on shed_bill_master.import_rotation=vessels_berth_detail.Import_Rotation_No
			where shed_tally_info.verify_number='$verify_number' limit 1";
					
			$rtnContainerList = $this->bm->dataSelectDb1($strBill);
			$data['rtnContainerList']=$rtnContainerList;
					
			$strBillRcvInfo="select description,gl_code from shed_bill_details 
							inner join shed_bill_master on shed_bill_master.bill_no=shed_bill_details.bill_no
							where shed_bill_master.verify_no='$verify_number'";
			$rtnBillRcvInfo = $this->bm->dataSelectDb1($strBillRcvInfo);
			$data['rtnBillRcvInfo']=$rtnBillRcvInfo;
					
			$sqlTruckNumber="select no_of_truck from verify_other_data
							inner join shed_tally_info on shed_tally_info.id=verify_other_data.shed_tally_id
							where shed_tally_info.verify_number='$verify_number'";
					//echo "TestData : ".$sqlTruckNumber;
			$rtnTruckNumber = $this->bm->dataSelectDb1($sqlTruckNumber);
					
			$data['rtnTruckNumber']=$rtnTruckNumber;
					
			$str="select concat(right(YEAR(bill_date),2),'/',concat(if(length(bill_generation_no)=1,'00000',if(length(bill_generation_no)=2,'0000',if(length(bill_generation_no)=3,'000',if(length(bill_generation_no)=4,'00',if(length(bill_generation_no)=5,'0',''))))),bill_generation_no)) as bill_no,verify_no,unit_no,cpa_vat_reg_no,ex_rate,bill_date,arraival_date,import_rotation,vessel_name,cl_date,bl_no,wr_date,wr_upto_date,importer_vat_reg_no,importer_name,cnf_lic_no,cnf_agent,be_no,be_date,ado_no,ado_date,ado_valid_upto,manifest_qty,cont_size,cont_height,bill_rcv_stat, if(bill_rcv_stat=1,'Paid','Not Paid') as paid_status from shed_bill_master where verify_no='$verify_number'"; 
			//and bill_no in (select max(bill_no) from shed_bill_master where verify_no='$verify_number')";
			//echo $str;
			//echo $str;
			$rtnBillList = $this->bm->dataSelectDb1($str);
			$unit_no=$rtnBillList[0]['unit_no'];
			$cpa_vat_reg_no=$rtnBillList[0]['cpa_vat_reg_no'];
			$ex_rate=$rtnBillList[0]['ex_rate'];
			$bill_rcv_stat=$rtnBillList[0]['bill_rcv_stat'];
				
			$strBankPaymentInfo = "select shed_bill_master.bill_no,bill_rcv_stat,cp_bank_code,user,concat(cp_bank_code,cp_unit,'/',right(cp_year,2),'-',concat(if(length(cp_no)=1,'000',if(length(cp_no)=2,'00',if(length(cp_no)=3,'0',''))),cp_no)) as cp_no
			from shed_bill_master 
			inner join bank_bill_recv on bank_bill_recv.bill_no=shed_bill_master.bill_no
			where verify_no='$verify_number'";
			$rtnBankPaymentInfo = $this->bm->dataSelectDb1($strBankPaymentInfo);
			$rcvstat=$rtnBankPaymentInfo[0]['bill_rcv_stat'];
			$cpnoview=$rtnBankPaymentInfo[0]['cp_no'];
			$cpbankcode=$rtnBankPaymentInfo[0]['cp_bank_code'];
			$shedbill=$rtnBankPaymentInfo[0]['bill_no'];
			$billPrepareBy=$rtnBankPaymentInfo[0]['user'];
				
			if($cpbankcode=="OB")
				$cpbankname="ONE BANK LIMITED";
				
			$sqlrcvdate="SELECT recv_by,DATE(recv_time) AS recv_time FROM bank_bill_recv WHERE bill_no='$shedbill'";
			$rtnrcvdate = $this->bm->dataSelectDb1($sqlrcvdate);
				
			$recv_by=$rtnrcvdate[0]['recv_by'];
			$recv_time=$rtnrcvdate[0]['recv_time'];
				
			$qry="select verify_no,bill_no,gl_code,description,tarrif_rate,Qty,qday,amt,vatTK,mlwfTK from shed_bill_details
			where verify_no='$verify_number' and bill_no in (select max(bill_no) from shed_bill_master where verify_no='$verify_number')";
			//echo $qry;
			$chargeList = $this->bm->dataSelectDb1($qry); 
					
			$qry_sum="select SUM(amt) as amt from shed_bill_details
					where verify_no='$verify_number' and bill_no in (select max(bill_no) from shed_bill_master where verify_no='$verify_number')";
			//echo $qry;
			$sumAll = $this->bm->dataSelectDb1($qry_sum);
			$tot_sum=$sumAll[0]['amt'];
					
			$qry_qday="select IFNULL(SUM(qday),0) as qday from shed_bill_details
					where verify_no='$verify_number' and bill_no in (select max(bill_no) from shed_bill_master where verify_no='$verify_number') AND gl_code not in('501005','502000N','503000N')";
			//echo $qry;
			$qdayAll = $this->bm->dataSelectDb1($qry_qday);
			$tot_qday=$qdayAll[0]['qday'];
				
			$data['rtnBillList']=$rtnBillList;
			$data['chargeList']=$chargeList;

			//now pass the data//
			$data['title']="Shed Bill";
			$data['verify_number']=$verify_number;
			$data['tot_sum']=$tot_sum;
			$data['tot_qday']=$tot_qday;
			//$this->data['amountInwords']=convert_number_to_words(5000);
				 
			$data['unit_no']=$unit_no;
			$data['cpa_vat_reg_no']=$cpa_vat_reg_no;
			$data['ex_rate']=$ex_rate;
			$data['bill_rcv_stat']=$bill_rcv_stat;
			$data['cpnoview']=$cpnoview;
			$data['cpbankname']=$cpbankname;
			$data['recv_time']=$recv_time;
			$data['recv_by']=$recv_by;
			$data['billPrepareBy']=$billPrepareBy;
			$data['bill_print_times']=4;
			$data['login_id']=$login_id;
					
			//echo $rtnContainerList[0]['verify_number']."  fdfdfd";
					
			$data['verifyNo']=$verify_number;
			//$data['title']="TALLY LIST REPORT...";
			//$data['vNum']=$rtnContainerList[0]['BL_NO'];
			//$this->load->view('header2');
			$this->load->view('releaseOrderFormView',$data);
			//$this->load->view('footer');
		}
	}

	function releaseorderpdf()
	{
		$verify_number=$this->input->post('verify_number');
		if($_POST['options']=='Bill')
		{
			$bill=1; // From Release Order Form
			$this->getShedBillPdf($verify_number,$bill);
		}
		else
		{
			$this->load->library('m_pdf');
			$mpdf->use_kwt = true;
			//$bill=0; // Not From Release Order Form
			$verify_num=$this->input->post('verify_number');
			
			$strBill="select igm_supplimentary_detail.id,IFNULL(sum(rcv_pack+loc_first),0) as rcv_pack,igm_masters.Vessel_Name,igm_supplimentary_detail.Import_Rotation_No,igm_sup_detail_container.cont_number,Pack_Marks_Number,shed_loc,shed_yard,Description_of_Goods,Notify_name,IFNULL(shed_tally_info.verify_number,0) as verify_number,IFNULL(shed_tally_info.id,0) as verify_id,igm_supplimentary_detail.Pack_Number,igm_supplimentary_detail.Pack_Description,igm_supplimentary_detail.BL_No,igm_sup_detail_container.cont_size,igm_sup_detail_container.cont_status,igm_sup_detail_container.cont_weight,verify_other_data.cnf_name,verify_other_data.be_no,verify_other_data.be_date,igm_sup_detail_container.cont_height,bank_bill_recv.bill_no,bank_bill_recv.cp_no,RIGHT(bank_bill_recv.cp_year,2) AS cp_year,bank_bill_recv.cp_bank_code,bank_bill_recv.cp_unit,date(bank_bill_recv.recv_time) as cp_date,igm_supplimentary_detail.Notify_address,igm_supplimentary_detail.Line_No,total_port,concat(right(YEAR(bill_date),2),'/',concat(if(length(bill_generation_no)=1,'00000',if(length(bill_generation_no)=2,'0000',if(length(bill_generation_no)=3,'000',if(length(bill_generation_no)=4,'00',if(length(bill_generation_no)=5,'0',''))))),bill_generation_no)) as master_bill_no,shed_bill_master.bill_date,VoyNo,verify_other_data.exit_note_number
			from  igm_supplimentary_detail
			inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
			inner join igm_masters on igm_supplimentary_detail.igm_master_id=igm_masters.id
			left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
			left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
			left join shed_bill_master on shed_bill_master.verify_no=shed_tally_info.verify_number
			left join bank_bill_recv on bank_bill_recv.bill_no=shed_bill_master.bill_no
			left join vessels_berth_detail on shed_bill_master.import_rotation=vessels_berth_detail.Import_Rotation_No
			where shed_tally_info.verify_number='$verify_num' limit 1";
						
			$rtnContainerList = $this->bm->dataSelectDb1($strBill);
				
			$this->data['rtnContainerList']=$rtnContainerList;
				
			$strBillRcvInfo="select description,gl_code 
							from shed_bill_details 
							inner join shed_bill_master on shed_bill_master.bill_no=shed_bill_details.bill_no
							where shed_bill_master.verify_no='$verify_num'";
											
			$rtnBillRcvInfo = $this->bm->dataSelectDb1($strBillRcvInfo);
			$this->data['rtnBillRcvInfo']=$rtnBillRcvInfo;
						
			$str="select concat(right(YEAR(bill_date),2),'/',concat(if(length(bill_generation_no)=1,'00000',if(length(bill_generation_no)=2,'0000',if(length(bill_generation_no)=3,'000',if(length(bill_generation_no)=4,'00',if(length(bill_generation_no)=5,'0',''))))),bill_generation_no)) as bill_no,verify_no,unit_no,cpa_vat_reg_no,ex_rate,bill_date,arraival_date,import_rotation,vessel_name,cl_date,bl_no,wr_date,wr_upto_date,importer_vat_reg_no,importer_name,cnf_lic_no,cnf_agent,be_no,be_date,ado_no,ado_date,ado_valid_upto,manifest_qty,cont_size,cont_height,bill_rcv_stat,if(bill_rcv_stat=1,'Paid','Not Paid') as paid_status 
			from shed_bill_master where verify_no='$verify_num'"; 
				
			$rtnBillList = $this->bm->dataSelectDb1($str);
				
			$unit_no=$rtnBillList[0]['unit_no'];
			$cpa_vat_reg_no=$rtnBillList[0]['cpa_vat_reg_no'];
			$ex_rate=$rtnBillList[0]['ex_rate'];
			$bill_rcv_stat=$rtnBillList[0]['bill_rcv_stat'];
					
			$this->data['rtnBillList']=$rtnBillList;
			
			$this->data['title']="Shed Bill";
			$this->data['verify_number']=$verify_num;
			$this->data['tot_sum']=$tot_sum;
			$this->data['unit_no']=$unit_no;
			$this->data['cpa_vat_reg_no']=$cpa_vat_reg_no;
			$this->data['ex_rate']=$ex_rate;
			$this->data['bill_rcv_stat']=$bill_rcv_stat;
			$this->data['cpnoview']=$cpnoview;
					
			$this->data['recv_time']=$recv_time;
			$this->data['recv_by']=$recv_by;
			$this->data['billPrepareBy']=$billPrepareBy;
			$this->data['bill_print_times']=4;
			$login_id = $this->session->userdata('login_id');
			$this->data['login_id']=$login_id;
									
			$this->data['verifyNo']=$verify_num;		
			
			$html=$this->load->view('releaseOrderFormViewPDF',$this->data, true); 
				 
			$pdfFilePath=$verify_num."_releaseorder.pdf";

			$pdf = $this->m_pdf->load();
			$pdf->SetWatermarkText('CPA CTMS');
			$pdf->showWatermarkText = true;				
			$stylesheet = file_get_contents('resources/styles/releaseorder.css'); // external css
			
			  $pdf->AddPage('L', // L - landscape, P - portrait
					'', '', '', '',
					15, // margin_left
					10, // margin right
					10, // margin top
					10, // margin bottom
					18, // margin header
					12); // margin footer  
			
		//	$pdf->AddPage('L'); 
			
			$pdf->setFooter('Prepared By : '.$login_id.'|Page {PAGENO} of {nb}|Date {DATE j-m-Y}');
								
			$pdf->WriteHTML($stylesheet,1);
			$pdf->WriteHTML($html,2);
								 
			$pdf->Output($pdfFilePath, "I"); // For Show Pdf
		}
	}				
				
	public function getShedBillPdf($verify_number,$bill)
	{ 
		//load mPDF library
		$login_id = $this->session->userdata('login_id');
		$this->load->library('m_pdf');
		$mpdf->use_kwt = true;
		$billVerify = $verify_number;
		/*if($this->input->post('sendVerifyNo'))
		{
			$billVerify=$this->input->post('sendVerifyNo');
		}
		else if($this->input->post('verify_num'))
		{
			$billVerify=$this->input->post('verify_num');
		}
		else
		{
			$billVerify=str_replace("_","/",$this->uri->segment(3));
		}*/
		$strBankPaymentInfo = "select shed_bill_master.bill_no,bill_rcv_stat,cp_bank_code,user,concat(cp_bank_code,cp_unit,'/',right(cp_year,2),'-',concat(if(length(cp_no)=1,'000',if(length(cp_no)=2,'00',if(length(cp_no)=3,'0',''))),cp_no)) as cp_no
		from shed_bill_master 
		inner join bank_bill_recv on bank_bill_recv.bill_no=shed_bill_master.bill_no
		where verify_no='$billVerify'";
		$rtnBankPaymentInfo = $this->bm->dataSelectDb1($strBankPaymentInfo);
		$rcvstat=$rtnBankPaymentInfo[0]['bill_rcv_stat'];
		$cpnoview=$rtnBankPaymentInfo[0]['cp_no'];
		$cpbankcode=$rtnBankPaymentInfo[0]['cp_bank_code'];
		$shedbill=$rtnBankPaymentInfo[0]['bill_no'];
		$bill_clerk=$rtnBankPaymentInfo[0]['user'];
		if($cpbankcode=="OB")
			$cpbankname="ONE BANK LIMITED";
		//load mPDF library
	   /*if($this->input->post('sendVerifyNo'))
		{
		  $billVerify=$this->input->post('sendVerifyNo');
		}
		else
		{
		$billVerify=$this->uri->segment(3);
		}*/
		
		$str="select concat(right(YEAR(bill_date),2),'/',concat(if(length(bill_generation_no)=1,'00000',if(length(bill_generation_no)=2,'0000',if(length(bill_generation_no)=3,'000',if(length(bill_generation_no)=4,'00',if(length(bill_generation_no)=5,'0',''))))),bill_generation_no)) as bill_no,verify_no,unit_no,cpa_vat_reg_no,ex_rate,bill_date,arraival_date,import_rotation,vessel_name,
		cl_date,bl_no,wr_date,wr_upto_date,importer_vat_reg_no,importer_name,cnf_lic_no,cnf_agent,be_no,
		be_date,ado_no,ado_date,ado_valid_upto,manifest_qty,cont_size,cont_height from shed_bill_master 
		where verify_no='$billVerify'";
		//echo $str;
		//echo $str;
		$rtnContainerList = $this->bm->dataSelectDb1($str);
		$unit_no=$rtnContainerList[0]['unit_no'];
		$cpa_vat_reg_no=$rtnContainerList[0]['cpa_vat_reg_no'];
		$ex_rate=$rtnContainerList[0]['ex_rate'];
		
		$qry="select verify_no,bill_no,gl_code,description,tarrif_rate,Qty,qday,amt,vatTK,mlwfTK from shed_bill_details
		where verify_no='$billVerify'";
		//echo $qry;
		$chargeList = $this->bm->dataSelectDb1($qry); 
			
		$qry_sum="select SUM(amt) as amt from shed_bill_details
					where verify_no='$billVerify'";
				//echo $qry;
		$sumAll = $this->bm->dataSelectDb1($qry_sum);
		$tot_sum=$sumAll[0]['amt'];
			
		$qry_qday="select IFNULL(SUM(qday),0) as qday from shed_bill_details
					where verify_no='$billVerify' AND gl_code not in('501005','502000N','503000N')";
				//echo $qry;
		$qdayAll = $this->bm->dataSelectDb1($qry_qday);
		$tot_qday=$qdayAll[0]['qday'];
			
		$sqlrcvdate="SELECT recv_by,DATE(recv_time) AS recv_time FROM bank_bill_recv WHERE bill_no='$shedbill'";
		$rtnrcvdate = $this->bm->dataSelectDb1($sqlrcvdate);
		
		$recv_by=$rtnrcvdate[0]['recv_by'];
		$recv_time=$rtnrcvdate[0]['recv_time'];
		
		$this->data['rtnContainerList']=$rtnContainerList;
		$this->data['chargeList']=$chargeList;

		//now pass the data//
		$this->data['title']="Shed Bill";
		$this->data['verify_number']=$billVerify;
		$this->data['rcvstat']=$rcvstat;
		$this->data['cpnoview']=$cpnoview;
		$this->data['cpbankname']=$cpbankname;
		$this->data['recv_time']=$recv_time;
		$this->data['recv_by']=$recv_by;
		$this->data['tot_sum']=$tot_sum;
		$this->data['tot_qday']=$tot_qday;
		$this->data['bill_clerk']=$bill_clerk;
		$this->data['bill_print_times']=3;
		//$this->data['amountInwords']=convert_number_to_words(5000);
		 
		$this->data['unit_no']=$unit_no;
		$this->data['cpa_vat_reg_no']=$cpa_vat_reg_no;
		$this->data['ex_rate']=$ex_rate;
		$this->data['billFrmRls']=$bill;
		 
		//attached Shed delivery order
			 
		$verifyNo=$verify_number;
				
		$sqlOrder = "select igm_supplimentary_detail.id,IFNULL(sum(rcv_pack+loc_first),0) as rcv_pack,igm_masters.Vessel_Name,igm_supplimentary_detail.Import_Rotation_No,igm_sup_detail_container.cont_number,Pack_Marks_Number,shed_loc,shed_yard,Description_of_Goods,Notify_name,IFNULL(shed_tally_info.verify_number,0) as verify_number,IFNULL(shed_tally_info.id,0) as verify_id,igm_supplimentary_detail.Pack_Number,igm_supplimentary_detail.Pack_Description,igm_supplimentary_detail.BL_No,igm_sup_detail_container.cont_size,igm_sup_detail_container.cont_status,igm_sup_detail_container.cont_weight,verify_other_data.cnf_name,verify_other_data.be_no,verify_other_data.be_date,igm_sup_detail_container.cont_height
		from  igm_supplimentary_detail
		inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
		inner join igm_masters on igm_supplimentary_detail.igm_master_id=igm_masters.id
		left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
		left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
		where shed_tally_info.verify_number='$verifyNo'";	
								
		$orderList = $this->bm->dataSelectDb1($sqlOrder);	
		$this->data['verifyNo']=$verifyNo;
		$this->data['orderList']=$orderList;
				
		$sqlTruckCount="select count(truck_id) as rtnValue from do_information where verify_no='$verifyNo'";
		$truckCount = $this->bm->dataReturnDb1($sqlTruckCount);	
		$this->data['truckCount']=$truckCount;
				
		$sqlTruckDetails="select truck_id, delv_pack from do_information where verify_no='$verifyNo'";
		$truckDetails = $this->bm->dataSelectDb1($sqlTruckDetails);	
		$this->data['truckDetails']=$truckDetails;
		//echo $orderList;
		//$this->load->view('header5');
		//end shed delivery

		$html=$this->load->view('shedBillPdfOutput',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
 	 
		//this the the PDF filename that user will get to download
		$pdfFilePath ="shedBill-".time()."-download.pdf";

		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
		$pdf->SetWatermarkText('CPA CTMS');
		$pdf->showWatermarkText = true;	
		//$pdf->mirrorMargins = 1;
		//generate the PDF!
		//$stylesheet = file_get_contents('assets/css/main.css');
        //$mpdf->WriteHTML($stylesheet,1);
		$stylesheet = file_get_contents('resources/styles/shedBill.css'); // external css
		$pdf->useSubstitutions = true; // optional - just as an example
		//$pdf->SetHeader($url . "\n\n" . 'Date {DATE j-m-Y}');  // optional - just as an example
		//echo "SheetAdd : ".$stylesheet;
		$pdf->setFooter('Prepared By :'.$bill_clerk.'|Page {PAGENO} of {nb}|Date {DATE j-m-Y}');
		//$footerHtml='<pagefooter name="MyFooter1" content-left="{DATE j-m-Y}" content-center="{PAGENO}/{nbpg}" content-right="My document" footer-style="font-family: serif; font-size: 8pt; font-weight: bold; font-style: italic; color: #000000;" />';
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		//$pdf->WriteHTML('<pagebreak resetpagenum="1" pagenumstyle="1" suppress="off" />');
		//offer it to user via browser download! (The PDF won't be saved on your server HDD)
		//$pdf->Output($pdfFilePath, "D"); /// For Direct Download 
		$pdf->Output($pdfFilePath, "I"); // For Show Pdf
	}
		//Release Order End
		
		//Cart Ticket start
		function cartTicketForm(){
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
			 	$data['msg']="";
			/* 	$data['unstuff_flag']="";
				$data['verify_number']="-1"; */
				$data['title']="CART TICKET SECTION..."; 
				$this->load->view('header5');
				$this->load->view('cartTicketForm',$data);
				$this->load->view('footer_1');
			}	
		
		}
		
		function cartTicketView(){
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$sqlTruckNumber = "";
				if($this->input->post('btnCartView'))
				{
					$verifyNo=$this->input->post('verify_number');
					$truckno=$this->input->post('troCart');
				//	$sqlTruckNumber="SELECT verify_no,truck_id,delv_pack FROM do_information WHERE verify_no='$verifyNo' AND truck_id='$truckno'";
					$sqlTruckNumber="SELECT verify_no,truck_id, gate_no, delv_pack FROM do_information WHERE verify_no='$verifyNo'";
				}
				else{
					$verifyNo=$this->input->post('verify_number');
					$sqlTruckNumber="select verify_no,truck_id, gate_no,delv_pack from do_information where verify_no='$verifyNo'";
				}
				//echo $sqlTruckNumber;			
				
				$rtnTruckNumber = $this->bm->dataSelectDb1($sqlTruckNumber);
				
				$data['rtnTruckNumber']=$rtnTruckNumber;
				$data['verifyNo']=$verifyNo;
				$this->load->view('cartTicketHTML',$data);
			}	
		}
		
		function cartTicketPdf()
		{ 
			//load mPDF library
			$this->load->library('m_pdf');
			$mpdf->use_kwt = true;
			
			$sqlTruckNumber = "";
			if($this->input->post('btnCartView'))
			{
				$verifyNo=$this->input->post('verify_number');
				$truckno=$this->input->post('troCart');
				
				$sqlTruckNumber_2="SELECT verify_no,truck_id,gate_no,delv_pack FROM do_information WHERE verify_no='$verifyNo'";

				$sqlTruckNumber="select no_of_truck from verify_other_data 
				inner join shed_tally_info on shed_tally_info.id=verify_other_data.shed_tally_id
				where verify_number='$verifyNo'";
			}
			else{
				$verifyNo=$this->input->post('verify_number');
			
				$sqlTruckNumber_2="select verify_no,truck_id,gate_no,delv_pack from do_information where verify_no='$verifyNo'";
				
				$sqlTruckNumber="select no_of_truck from verify_other_data 
				inner join shed_tally_info on shed_tally_info.id=verify_other_data.shed_tally_id
				where verify_number='$verifyNo'";
			}
				//echo $sqlTruckNumber;			
				
			$rtnTruckNumber_2 = $this->bm->dataSelectDb1($sqlTruckNumber_2);
			
			$rtnTruckNumber = $this->bm->dataSelectDb1($sqlTruckNumber);
			
			$login_id = $this->session->userdata('login_id');
				
			$this->data['rtnTruckNumber']=$rtnTruckNumber;
			$this->data['rtnTruckNumber_2']=$rtnTruckNumber_2;
			$this->data['verifyNo']=$verifyNo;

			$html=$this->load->view('cartTicketPdfOutput',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
			 
			$pdfFilePath ="cartTicket-".time()."-download.pdf";

			$pdf = $this->m_pdf->load();
			$pdf->SetWatermarkText('CPA CTMS');
			$pdf->showWatermarkText = true;		
		//	$stylesheet = file_get_contents('resources/styles/test.css'); // external css
			$stylesheet = file_get_contents('resources/styles/cartticket.css'); // external css
		//	$pdf->useSubstitutions = true; // optional - just as an example
				
			//$pdf->setFooter('Developed By : '.$login_id.'|Page {PAGENO}|Date {DATE j-m-Y}');
				
			$pdf->WriteHTML($stylesheet,1);
			$pdf->WriteHTML($html,2);
				 
			$pdf->Output($pdfFilePath, "I"); // For Show Pdf
		}
		//Cart Ticket end
		
		//Gate Confirmation start
		function gateConfirmation(){
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['msg']="";
				$this->load->view('header5');
				$this->load->view('gateConfirmation',$data);
				$this->load->view('footer_1');
			}	
		}
		
		function gateConfirmationPerform()
		{	
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$verify_num=$this->input->post('verify_num');
				$tro=$this->input->post('tro');
				
				$truckupdate="UPDATE do_information SET delv_status='1' WHERE truck_id='$tro' AND verify_no='$verify_num'";
				
				$statechange = $this->bm->dataInsertDB1($truckupdate);
				if($statechange==1)
				{
					$data['msg'] ="<font color=green><b>Successfully Inserted.</b></font>";
					$data['verify_num'] =$verify_num;
				}
				
				//no empty truck start
			//	$query = "SELECT truck_id FROM do_information WHERE verify_no='$verify_num' AND delv_status='0'";
				$query = "SELECT COUNT(truck_id) AS rtnValue FROM do_information WHERE verify_no='$verify_num' AND delv_status='0'";
           
				$rtntrkno = $this->bm->dataReturnDb1($query);
				
				if($rtntrkno==0)
				{
					//write pdf start
					$this->load->library('m_pdf');
					$mpdf->use_kwt = true;
					
						//--------cartticket start
					$login_id = $this->session->userdata('login_id');
					
					$sqlTruckNumber="select verify_no,truck_id,gate_no,delv_pack from do_information where verify_no='$verify_num'";
					
					$rtnTruckNumber = $this->bm->dataSelectDb1($sqlTruckNumber);
				
					$this->data['rtnTruckNumber']=$rtnTruckNumber;		
					$this->data['verifyNo']=$verify_num;
					
					$html=$this->load->view('pdfWriteTest',$this->data, true); 
					
					$pdfFilePath_cartTicket =$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/pdfsend/".$verify_num."_cartTicket.pdf";

					$pdf = $this->m_pdf->load();
					$pdf->SetWatermarkText('CPA CTMS');
					$pdf->showWatermarkText = true;	
					$stylesheet = file_get_contents('resources/styles/cartticket.css');
					
					$pdf->setFooter('Developed By : '.$login_id.'|Page {PAGENO}|Date {DATE j-m-Y}');
						
					$pdf->WriteHTML($stylesheet,1);
					$pdf->WriteHTML($html,2);
						 
					$pdf->Output($pdfFilePath_cartTicket, "F"); // To save Pdf; to show and download use "I" and "D" respectively
						//--------cartticket end
						
						//--------bill start
					$strBankPaymentInfo = "select shed_bill_master.bill_no,bill_rcv_stat,cp_bank_code,concat(cp_bank_code,cp_unit,'/',right(cp_year,2),'-',concat(if(length(cp_no)=1,'000',if(length(cp_no)=2,'00',if(length(cp_no)=3,'0',''))),cp_no)) as cp_no
					from shed_bill_master 
					inner join bank_bill_recv on bank_bill_recv.bill_no=shed_bill_master.bill_no
					where verify_no='$verify_num'";
			
					$rtnBankPaymentInfo = $this->bm->dataSelectDb1($strBankPaymentInfo);
					$rcvstat=$rtnBankPaymentInfo[0]['bill_rcv_stat'];
					$cpnoview=$rtnBankPaymentInfo[0]['cp_no'];
					$cpbankcode=$rtnBankPaymentInfo[0]['cp_bank_code'];
					$shedbill=$rtnBankPaymentInfo[0]['bill_no'];
			
					if($cpbankcode=="OB")
						$cpbankname="ONE BANK LIMITED";
			
					$str="select bill_no,verify_no,unit_no,cpa_vat_reg_no,ex_rate,bill_date,arraival_date,import_rotation,vessel_name,
					cl_date,bl_no,wr_date,wr_upto_date,importer_vat_reg_no,importer_name,cnf_lic_no,cnf_agent,be_no,
					be_date,ado_no,ado_date,ado_valid_upto,manifest_qty,cont_size,cont_height from shed_bill_master 
					where verify_no='$verify_num'";
					
					$rtnContainerList = $this->bm->dataSelectDb1($str);
					$unit_no=$rtnContainerList[0]['unit_no'];
					$cpa_vat_reg_no=$rtnContainerList[0]['cpa_vat_reg_no'];
					$ex_rate=$rtnContainerList[0]['ex_rate'];
			
					$qry="select verify_no,bill_no,gl_code,description,tarrif_rate,Qty,qday,amt,vatTK,mlwfTK from shed_bill_details where verify_no='$verify_num'";
					
					$chargeList = $this->bm->dataSelectDb1($qry); 
				
					$qry_sum="select SUM(amt) as amt from shed_bill_details where verify_no='$verify_num'";
					
					$sumAll = $this->bm->dataSelectDb1($qry_sum);
					$tot_sum=$sumAll[0]['amt'];
				
					$qry_qday="select IFNULL(SUM(qday),0) as qday from shed_bill_details where verify_no='$verify_num' AND gl_code not in('501005','502000N','503000N')";
					
					$qdayAll = $this->bm->dataSelectDb1($qry_qday);
					$tot_qday=$qdayAll[0]['qday'];
				
					$sqlrcvdate="SELECT recv_by,DATE(recv_time) AS recv_time FROM bank_bill_recv WHERE bill_no='$shedbill'";
					$rtnrcvdate = $this->bm->dataSelectDb1($sqlrcvdate);
			
					$recv_by=$rtnrcvdate[0]['recv_by'];
					$recv_time=$rtnrcvdate[0]['recv_time'];
			
					$this->data['rtnContainerList']=$rtnContainerList;
					$this->data['chargeList']=$chargeList;

					$this->data['title']="Shed Bill";
					$this->data['verify_number']=$verify_num;
					$this->data['rcvstat']=$rcvstat;
					$this->data['cpnoview']=$cpnoview;
					$this->data['cpbankname']=$cpbankname;
					$this->data['recv_time']=$recv_time;
					$this->data['recv_by']=$recv_by;
					$this->data['tot_sum']=$tot_sum;
					$this->data['tot_qday']=$tot_qday;
					$this->data['bill_print_times']=1;  //for email
			 
					$this->data['unit_no']=$unit_no;
					$this->data['cpa_vat_reg_no']=$cpa_vat_reg_no;
					$this->data['ex_rate']=$ex_rate;

					$html=$this->load->view('shedBillPdfOutput',$this->data, true); 
			 
					$pdfFilePath_Bill =$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/pdfsend/".$verify_num."_bill.pdf";

					$pdf = $this->m_pdf->load();
					$pdf->SetWatermarkText('CPA CTMS');
					$pdf->showWatermarkText = true;	
				//	$stylesheet = file_get_contents('resources/styles/test.css'); // external css
					$stylesheet = file_get_contents('resources/styles/shedBill.css'); // external css
					$pdf->useSubstitutions = true; // optional - just as an example
					
					$pdf->setFooter('Developed By : DataSoft|Page {PAGENO}|Date {DATE j-m-Y}');
					
					$pdf->WriteHTML($stylesheet,1);
					$pdf->WriteHTML($html,2);
					 
					$pdf->Output($pdfFilePath_Bill, "F"); // For Show Pdf
						//--------bill end
						
						//--------release order start
					$strBill="select igm_supplimentary_detail.id,IFNULL(sum(rcv_pack+loc_first),0) as rcv_pack,igm_masters.Vessel_Name,igm_supplimentary_detail.Import_Rotation_No,igm_sup_detail_container.cont_number,Pack_Marks_Number,shed_loc,shed_yard,Description_of_Goods,Notify_name,IFNULL(shed_tally_info.verify_number,0) as verify_number,IFNULL(shed_tally_info.id,0) as verify_id,igm_supplimentary_detail.Pack_Number,igm_supplimentary_detail.Pack_Description,igm_supplimentary_detail.BL_No,igm_sup_detail_container.cont_size,igm_sup_detail_container.cont_status,igm_sup_detail_container.cont_weight,verify_other_data.cnf_name,verify_other_data.be_no,verify_other_data.be_date,igm_sup_detail_container.cont_height,bank_bill_recv.bill_no,bank_bill_recv.cp_no,RIGHT(bank_bill_recv.cp_year,2) AS cp_year,bank_bill_recv.cp_bank_code,bank_bill_recv.cp_unit,date(bank_bill_recv.recv_time) as cp_date,igm_supplimentary_detail.Notify_address,igm_supplimentary_detail.Line_No,total_port,concat(right(YEAR(bill_date),2),'/',concat(if(length(bill_generation_no)=1,'00000',if(length(bill_generation_no)=2,'0000',if(length(bill_generation_no)=3,'000',if(length(bill_generation_no)=4,'00',if(length(bill_generation_no)=5,'0',''))))),bill_generation_no)) as master_bill_no,shed_bill_master.bill_date,VoyNo,verify_other_data.exit_note_number
					from  igm_supplimentary_detail
					inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
					inner join igm_masters on igm_supplimentary_detail.igm_master_id=igm_masters.id
					left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
					left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
					left join shed_bill_master on shed_bill_master.verify_no=shed_tally_info.verify_number
					left join bank_bill_recv on bank_bill_recv.bill_no=shed_bill_master.bill_no
					left join vessels_berth_detail on shed_bill_master.import_rotation=vessels_berth_detail.Import_Rotation_No
					where shed_tally_info.verify_number='$verify_num' limit 1";
					
					$rtnContainerList = $this->bm->dataSelectDb1($strBill);
			
					$this->data['rtnContainerList']=$rtnContainerList;
			
					$strBillRcvInfo="select description,gl_code 
						from shed_bill_details 
						inner join shed_bill_master on shed_bill_master.bill_no=shed_bill_details.bill_no
						where shed_bill_master.verify_no='$verify_num'";
										
					$rtnBillRcvInfo = $this->bm->dataSelectDb1($strBillRcvInfo);
					$this->data['rtnBillRcvInfo']=$rtnBillRcvInfo;
					
					$str="select concat(right(YEAR(bill_date),2),'/',concat(if(length(bill_generation_no)=1,'00000',if(length(bill_generation_no)=2,'0000',if(length(bill_generation_no)=3,'000',if(length(bill_generation_no)=4,'00',if(length(bill_generation_no)=5,'0',''))))),bill_generation_no)) as bill_no,verify_no,unit_no,cpa_vat_reg_no,ex_rate,bill_date,arraival_date,import_rotation,vessel_name,
					cl_date,bl_no,wr_date,wr_upto_date,importer_vat_reg_no,importer_name,cnf_lic_no,cnf_agent,be_no,
					be_date,ado_no,ado_date,ado_valid_upto,manifest_qty,cont_size,cont_height,bill_rcv_stat, 
					if(bill_rcv_stat=1,'Paid','Not Paid') as paid_status 
					from shed_bill_master where verify_no='$verify_num'"; 
			
					$rtnBillList = $this->bm->dataSelectDb1($str);
			
					$unit_no=$rtnBillList[0]['unit_no'];
					$cpa_vat_reg_no=$rtnBillList[0]['cpa_vat_reg_no'];
					$ex_rate=$rtnBillList[0]['ex_rate'];
					$bill_rcv_stat=$rtnBillList[0]['bill_rcv_stat'];
				
					$this->data['rtnBillList']=$rtnBillList;
		
					$this->data['title']="Shed Bill";
					$this->data['verify_number']=$verify_num;
					$this->data['tot_sum']=$tot_sum;
				
							 
					$this->data['unit_no']=$unit_no;
					$this->data['cpa_vat_reg_no']=$cpa_vat_reg_no;
					$this->data['ex_rate']=$ex_rate;
					$this->data['bill_rcv_stat']=$bill_rcv_stat;
					$this->data['cpnoview']=$cpnoview;
				
					$this->data['recv_time']=$recv_time;
					$this->data['recv_by']=$recv_by;
					$this->data['billPrepareBy']=$billPrepareBy;
					$this->data['bill_print_times']=4;
					$this->data['login_id']=$login_id;
								
					$this->data['verifyNo']=$verify_num;		
		
					$html=$this->load->view('releaseOrderFormViewPDF',$this->data, true); 
			 
					$pdfFilePath_releaseorder =$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/pdfsend/".$verify_num."_releaseorder.pdf";

					$pdf = $this->m_pdf->load();
					$pdf->SetWatermarkText('CPA CTMS');
					$pdf->showWatermarkText = true;	
					$stylesheet = file_get_contents('resources/styles/releaseorder.css'); // external css
							
					$pdf->setFooter('Prepared By : '.$login_id.'|Page {PAGENO}|Date {DATE j-m-Y}');
							
					$pdf->WriteHTML($stylesheet,1);
					$pdf->WriteHTML($html,2);
							 
					$pdf->Output($pdfFilePath_releaseorder, "F"); // For Show Pdf
						//--------release order end
						
					//write pdf end
					//sending mail start
					include_once("sendEmailController.php");
					require_once('mailer/class.smtp.php');
					
					$subject="Shedbill";
					$body="Please check the attached files.";
				//	$emailClient="intakhab.alam@datasoft-bd.com";
				//	$emailClient="intakhab.chy@gmail.com";
				//	$emailClient="shahjahan@datasoft-bd.com";
				//	$emailClient="shahscjp@gmail.com";
					$emailClient="intakhab.chy@gmail.com";

					$sendEmailController =new sendEmailController();
					
					$sendEmail=$sendEmailController->sendEmail($subject,$body,$emailClient,$pdfFilePath_cartTicket,$pdfFilePath_Bill,$pdfFilePath_releaseorder);

					//sending mail end
					
					$this->load->view('header5');
					$this->load->view('gateConfirmation',$data);
					$this->load->view('footer_1');
					return;
				}
				//no empty truck end
				
				//query from ajax
				$str_reload="SELECT * FROM (SELECT igm_supplimentary_detail.id,igm_masters.Vessel_Name,igm_supplimentary_detail.Import_Rotation_No,igm_supplimentary_detail.Pack_Marks_Number,igm_supplimentary_detail.Description_of_Goods,IFNULL(shed_tally_info.verify_number,0) AS verify_number,verify_other_data.cnf_name,verify_other_data.be_no,verify_other_data.be_date,igm_details.Consignee_name,igm_supplimentary_detail.Pack_Description,igm_details.BL_No AS mloline,igm_supplimentary_detail.BL_No AS ffwline,(SELECT mlocode FROM igm_details 
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
				
				$rslt_reload = $this->bm->dataSelectDb1($str_reload);
				
				$reg_no=$rslt_reload[0]['Import_Rotation_No'];
				$vessel_name=$rslt_reload[0]['Vessel_Name'];
				$marks=$rslt_reload[0]['Pack_Marks_Number'];
				$des_goods=$rslt_reload[0]['Description_of_Goods'];
				$quantity=$rslt_reload[0]['Pack_Number'];
				$mlo_line=$rslt_reload[0]['mloline'];
				$mlo_code=$rslt_reload[0]['mlocode'];
				$ffw_line=$rslt_reload[0]['ffwline'];
				$unit=$rslt_reload[0]['Pack_Description'];
				$cnf=$rslt_reload[0]['cnf_name'];
				$importer_name=$rslt_reload[0]['Consignee_name'];
				$be_no=$rslt_reload[0]['be_no'];
				$be_date=$rslt_reload[0]['be_date'];
				$dlv_qty=$rslt_reload[0]['bal_pack'];		//if $dlv_qty==0 then send mail  
				$notifyName=$rslt_reload[0]['Notify_name'];
				$notifyAddress=$rslt_reload[0]['Notify_address'];
				
				$data['vessel_name'] =$vessel_name;
				$data['reg_no'] =$reg_no;
				$data['marks'] =$marks;
				$data['des_goods'] =$des_goods;
				$data['quantity'] =$quantity;
				$data['mlo_line'] =$mlo_line;
				$data['mlo_code'] =$mlo_code;
				$data['ffw_line'] =$ffw_line;
				$data['unit'] =$unit;
				$data['cnf'] =$cnf;
				$data['importer_name'] =$importer_name;
				$data['be_no'] =$be_no;
				$data['be_date'] =$be_date;
				$data['dlv_qty'] =$dlv_qty;  
				$data['notifyName'] =$notifyName;
				$data['notifyAddress'] =$notifyAddress;
				
				$this->load->view('header5');
				$this->load->view('gateConfirmation',$data);
				$this->load->view('footer_1');
			}
		}
		//Gate Confirmation end
		//Gate Report Start
	
	function gateReportForm()
	{
		$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$data['msg']="";
				$data['title']="GATE REPORT SECTION...";
				$this->load->view('header5');
				$this->load->view('gateReportForm',$data);
				$this->load->view('footer_1');
			}	
	}
function gateReportViewPdf()
	 {
		$login_id = $this->session->userdata('login_id');	
		$data['login_id']=$login_id;
		$search_by = $this->input->post('search_by');
		echo "TEST ".$search_by;
		
		//load mPDF library
		$this->load->library('m_pdf');
		$pdf->use_kwt = true;
		//load mPDF library
		if($search_by=="vNum")
			{
				$vNum=$this->input->post('search_value');
				$strSelect="select do_information.verify_no,truck_id,delv_pack,manifest_qty,vessel_name,shed_loc,cnf_agent,
							shed_bill_master.be_no,do_information.import_rotation,date(do_information.last_update)as dt,exit_note_number, Pack_Marks_Number,
							(IFNULL(manifest_qty,0)-IFNULL(delv_pack,0)) as balance,do_information.remarks,verify_other_data.date,signature_path
							from do_information
							left join shed_bill_master on do_information.verify_no=shed_bill_master.verify_no
							left join shed_tally_info on do_information.verify_no=shed_tally_info.verify_number
							left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
							left join igm_supplimentary_detail on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
							left join cnf_signature_data on verify_other_data.cnf_lic_no=cnf_signature_data.cnf_license_no
							where do_information.verify_no='$vNum' and do_information.delv_status=1";
				
			}
			else if ($search_by=="dateRange")
			{
				 $fromdate=$this->input->post('fromdate');
				 $todate=$this->input->post('todate');
				 $strSelect="select do_information.verify_no,truck_id,delv_pack,manifest_qty,vessel_name,shed_loc,cnf_agent,
							shed_bill_master.be_no,do_information.import_rotation,date(do_information.last_update)as dt,exit_note_number, Pack_Marks_Number,
							(IFNULL(manifest_qty,0)-IFNULL(delv_pack,0)) as balance,do_information.remarks,verify_other_data.date,signature_path
							from do_information
							left join shed_bill_master on do_information.verify_no=shed_bill_master.verify_no
							left join shed_tally_info on do_information.verify_no=shed_tally_info.verify_number
							left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
							left join igm_supplimentary_detail on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
							left join cnf_signature_data on verify_other_data.cnf_lic_no=cnf_signature_data.cnf_license_no
							where date(do_information.last_update) between '$fromdate' and '$todate' and do_information.delv_status=1";
			}
			$rtnGateReportList = $this->bm->dataSelectDb1($strSelect);
			$this->data['rtnGateReportList']=$rtnGateReportList;
			 
			 $strSignatureQuery="select image_path from users where login_id='$login_id'";
			 $strSignature = $this->bm->dataSelectDb1($strSignatureQuery);
			 $signaturePath=$strSignature[0]['image_path'];
			 
			$this->data['verify_number']=$vNum;
			$this->data['fromdate']=$fromdate;
			$this->data['todate']=$todate;
			$this->data['signaturePath']=$signaturePath;
			
			$html=$this->load->view('GateReportPdfOutput',$this->data, true);
			//this the the PDF filename that user will get to download
			$pdfFilePath ="gateReport-".time()."-download.pdf";

			
			//actually, you can pass mPDF parameter on this load() function
			$pdf = $this->m_pdf->load();
			$pdf->SetWatermarkText('CPA CTMS');
			$pdf->showWatermarkText = true;	
			//$pdf->mirrorMargins = 1;
			//generate the PDF!
			//$stylesheet = file_get_contents('assets/css/main.css');
			//$mpdf->WriteHTML($stylesheet,1);
			//$stylesheet = file_get_contents('resources/styles/test.css'); // external css
			$pdf->AddPage('L', // L - landscape, P - portrait
				'', '', '', '',
				30, // margin_left
				30, // margin right
				30, // margin top
				30, // margin bottom
				18, // margin header
				12); // margin footer
			$pdf->useSubstitutions = true; // optional - just as an example
			//$pdf->SetHeader($url . "\n\n" . 'Date {DATE j-m-Y}');  // optional - just as an example
			//echo "SheetAdd : ".$stylesheet;
			$pdf->setFooter('Developed By : DataSoft|Page {PAGENO}|Date {DATE j-m-Y}');
			//$footerHtml='<pagefooter name="MyFooter1" content-left="{DATE j-m-Y}" content-center="{PAGENO}/{nbpg}" content-right="My document" footer-style="font-family: serif; font-size: 8pt; font-weight: bold; font-style: italic; color: #000000;" />';
			//$pdf->WriteHTML($stylesheet,1);
			$pdf->WriteHTML($html,2);
			//$pdf->WriteHTML('<pagebreak resetpagenum="1" pagenumstyle="1" suppress="off" />');
			//offer it to user via browser download! (The PDF won't be saved on your server HDD)
			//$pdf->Output($pdfFilePath, "D"); /// For Direct Download 
			$pdf->Output($pdfFilePath, "I"); // For Show Pdf
		
	 }

     //Gate Report End


    //IMPORT CARGO RECEIVING & DELIVERY REPORT START---------------------FAYSAL
    function importCargoReportForm()
    {
        $session_id = $this->session->userdata('value');
        if($session_id!=$this->session->userdata('session_id'))
        {
            $this->logout();

        }
        else
        {
            $query = "SELECT DISTINCT `shed_yard` FROM cchaportdb.shed_tally_info WHERE shed_yard !=' ' AND  shed_yard != 'null'";
            $shed_yard = $this->bm->dataSelectDb1($query);
            // print_r($shed_yard); exit();
            $data['shed_yard']=$shed_yard;
            $data['msg']="";
            $data['title']="IMPORT CARGO RECEIVING & DELIVERY REPORT SECTION...";
            $this->load->view('header5');
            $this->load->view('importCargoReceivingAndDeliveryForm',$data);
            $this->load->view('footer_1');
        }
    }

    function importCargoReport()
    {

        $importCargodate = $this->input->post('importCargodate');
        $shed_no = $this->input->post('shed_no');


        $search_format = $this->input->post('options');
//        print_r($search_format); exit();
        if($search_format=="xl" or $search_format=="html")
        {

            $data['importCargodate']=$importCargodate;
            $data['shed_no']=$shed_no;
            $this->load->view('importCargoReceivingAndDeliveryView',$data);

        }
        else{
            //load mPDF library
            $this->load->library('m_pdf');
            $pdf->use_kwt = true;
            $this->data['importCargodate']=$importCargodate;
            $this->data['shed_no']=$shed_no;
            $html=$this->load->view('importCargoReceivingAndDeliveryView',$this->data, true);
            //this the the PDF filename that user will get to download
            $pdfFilePath ="importCargoReceivingAndDeliveryView-".time()."-download.pdf";
            $pdf = $this->m_pdf->load();
            $pdf->SetWatermarkText('CPA CTMS');
            $pdf->showWatermarkText = true;
            $stylesheet = file_get_contents('resources/styles/test.css'); // external css
            $pdf->useSubstitutions = true; // optional - just as an example
            //$pdf->SetHeader($url . "\n\n" . 'Date {DATE j-m-Y}');  // optional - just as an example
            //echo "SheetAdd : ".$stylesheet;
            $pdf->setFooter('Developed By : DataSoft|Page {PAGENO} of {nb}|Date {DATE j-m-Y}');
            //$footerHtml='<pagefooter name="MyFooter1" content-left="{DATE j-m-Y}" content-center="{PAGENO}/{nbpg}" content-right="My document" footer-style="font-family: serif; font-size: 8pt; font-weight: bold; font-style: italic; color: #000000;" />';
            $pdf->WriteHTML($stylesheet,1);
            $pdf->WriteHTML($html,2);
            $pdf->Output($pdfFilePath, "I"); // For Show Pdf
            //load mPDF library

        }



    }




    //IMPORT CARGO RECEIVING & DELIVERY REPORT END
	 
	// MH Chowdhury report EXPORT start
	function exportContListAllByRotationForm()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$data['title']="CONTAINER LIST (ALL)";
			$this->load->view('header2');
			$this->load->view('exportContListAllByRotationView',$data);   
			$this->load->view('footer');
		}
	}
	
	function exportContListAllByRotationDownloadView()
	{
		$login_id = $this->session->userdata('login_id');	
		$data['login_id']=$login_id;
		$search_by = $this->input->post('search_by');
		if($search_by=="rotation")
		{
			$rotation=$this->input->post('search_value');
			$cond = " WHERE sparcsn4.vsl_vessel_visit_details.ib_vyg='$rotation'";
			$data['title']="CONTAINERS LIST FOR THE ROTATION ".$rotation;
			$data['cond']=$cond;
			$data['containerStatus']="Export Containers";
		}
		else if($search_by=="dateRange")
		{
			$fromdate=$this->input->post('fromdate');
			$todate=$this->input->post('todate');
			$cond = " WHERE DATE(sparcsn4.inv_unit_fcy_visit.time_out) BETWEEN '$fromdate' AND '$todate'";
			$data['title']="CONTAINERS LIST FROM ".$fromdate." TO ".$todate;
			$data['cond']=$cond;
			$data['containerStatus']="Export Containers";
		}
					
		$this->load->view('exportContListAllByRotationExcelHTMLDownloadView',$data);   
	}
	// MH Chowdhury report EXPORT end
	
	//Sourav
	//////////// VESSEL LIST WITH STATUS START//////////////////
	function viewVesselListStatus()
	{
		//echo "rr";
		$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				//echo $login_id;
				$login_id = $this->session->userdata('login_id');
				$org_Type_id = $this->session->userdata('org_Type_id');
				//echo $login_id;
				if($org_Type_id==1)
					{
						$query="SELECT sparcsn4.vsl_vessel_visit_details.vvd_gkey,sparcsn4.vsl_vessels.name,sparcsn4.vsl_vessel_visit_details.ib_vyg,sparcsn4.vsl_vessel_visit_details.ob_vyg,
						LEFT(sparcsn4.argo_carrier_visit.phase,2) AS phase_num,SUBSTR(sparcsn4.argo_carrier_visit.phase,3) AS phase_str,sparcsn4.argo_visit_details.eta,
						sparcsn4.argo_visit_details.etd,sparcsn4.argo_carrier_visit.ata,
						sparcsn4.argo_carrier_visit.atd,sparcsn4.ref_bizunit_scoped.id AS agent,
						IFNULL(sparcsn4.vsl_vessel_visit_details.flex_string02,sparcsn4.vsl_vessel_visit_details.flex_string03) AS berthop
						FROM sparcsn4.argo_carrier_visit
						INNER JOIN sparcsn4.argo_visit_details ON sparcsn4.argo_visit_details.gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
						INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_visit_details.gkey
						INNER JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
						INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.vsl_vessel_visit_details.bizu_gkey
						WHERE sparcsn4.argo_carrier_visit.phase IN ('20INBOUND','30ARRIVED','40WORKING','50COMPLETE','60DEPARTED') and sparcsn4.ref_bizunit_scoped.id='$login_id'
						ORDER BY sparcsn4.argo_carrier_visit.phase";
					}
					else if($org_Type_id==57)
					{
						$query="SELECT sparcsn4.vsl_vessel_visit_details.vvd_gkey,sparcsn4.vsl_vessels.name,sparcsn4.vsl_vessel_visit_details.ib_vyg,sparcsn4.vsl_vessel_visit_details.ob_vyg,
						LEFT(sparcsn4.argo_carrier_visit.phase,2) AS phase_num,SUBSTR(sparcsn4.argo_carrier_visit.phase,3) AS phase_str,sparcsn4.argo_visit_details.eta,
						sparcsn4.argo_visit_details.etd,sparcsn4.argo_carrier_visit.ata,
						sparcsn4.argo_carrier_visit.atd,sparcsn4.ref_bizunit_scoped.id AS agent,
						IFNULL(sparcsn4.vsl_vessel_visit_details.flex_string02,sparcsn4.vsl_vessel_visit_details.flex_string03) AS berthop
						FROM sparcsn4.argo_carrier_visit
						INNER JOIN sparcsn4.argo_visit_details ON sparcsn4.argo_visit_details.gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
						INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_visit_details.gkey
						INNER JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
						INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.vsl_vessel_visit_details.bizu_gkey
						WHERE sparcsn4.argo_carrier_visit.phase IN ('20INBOUND','30ARRIVED','40WORKING','50COMPLETE','60DEPARTED') and sparcsn4.ref_bizunit_scoped.id in 
						(SELECT r.id FROM sparcsn4.ref_bizunit_scoped r       
							LEFT JOIN ( sparcsn4.ref_agent_representation X       
							LEFT JOIN sparcsn4.ref_bizunit_scoped Y ON X.agent_gkey=Y.gkey )  ON r.gkey=X.bzu_gkey 
							WHERE Y.id = '$login_id'))
						ORDER BY sparcsn4.argo_carrier_visit.phase";
					}
					else
					{
						$query="SELECT sparcsn4.vsl_vessel_visit_details.vvd_gkey,sparcsn4.vsl_vessels.name,sparcsn4.vsl_vessel_visit_details.ib_vyg,sparcsn4.vsl_vessel_visit_details.ob_vyg,
						LEFT(sparcsn4.argo_carrier_visit.phase,2) AS phase_num,SUBSTR(sparcsn4.argo_carrier_visit.phase,3) AS phase_str,sparcsn4.argo_visit_details.eta,
						sparcsn4.argo_visit_details.etd,sparcsn4.argo_carrier_visit.ata,
						sparcsn4.argo_carrier_visit.atd,sparcsn4.ref_bizunit_scoped.id AS agent,
						IFNULL(sparcsn4.vsl_vessel_visit_details.flex_string02,sparcsn4.vsl_vessel_visit_details.flex_string03) AS berthop
						FROM sparcsn4.argo_carrier_visit
						INNER JOIN sparcsn4.argo_visit_details ON sparcsn4.argo_visit_details.gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
						INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_visit_details.gkey
						INNER JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
						INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.vsl_vessel_visit_details.bizu_gkey
						WHERE sparcsn4.argo_carrier_visit.phase IN ('20INBOUND','30ARRIVED','40WORKING','50COMPLETE','60DEPARTED')
						ORDER BY sparcsn4.argo_carrier_visit.phase";
					}
					//echo $query;
				//echo $data['voysNo'];
				$rtnVesselList = $this->bm->dataSelect($query);
				$data['rtnVesselList']=$rtnVesselList;
				$data['login_id']=$login_id;
					
				$data['title']="VESSEL LIST WITH STATUS...";
				$this->load->view('header5');
				$this->load->view('viewVesselListWithStatus',$data);
				$this->load->view('footer_1');
			}
	}
	function viewVesselListSearchList()
	{
		$rot_num=trim($this->input->post('rot_num'));
		$login_id = $this->session->userdata('login_id');
		$org_Type_id = $this->session->userdata('org_Type_id');
			if($org_Type_id==1)
						{
						$query="SELECT sparcsn4.vsl_vessel_visit_details.vvd_gkey,sparcsn4.vsl_vessels.name,sparcsn4.vsl_vessel_visit_details.ib_vyg,sparcsn4.vsl_vessel_visit_details.ob_vyg,
						LEFT(sparcsn4.argo_carrier_visit.phase,2) AS phase_num,SUBSTR(sparcsn4.argo_carrier_visit.phase,3) AS phase_str,sparcsn4.argo_visit_details.eta,
						sparcsn4.argo_visit_details.etd,sparcsn4.argo_carrier_visit.ata,
						sparcsn4.argo_carrier_visit.atd,sparcsn4.ref_bizunit_scoped.id AS agent,
						IFNULL(sparcsn4.vsl_vessel_visit_details.flex_string02,sparcsn4.vsl_vessel_visit_details.flex_string03) AS berthop
						FROM sparcsn4.argo_carrier_visit
						INNER JOIN sparcsn4.argo_visit_details ON sparcsn4.argo_visit_details.gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
						INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_visit_details.gkey
						INNER JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
						INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.vsl_vessel_visit_details.bizu_gkey
						WHERE sparcsn4.vsl_vessel_visit_details.ib_vyg='$rot_num' and sparcsn4.ref_bizunit_scoped.id='$login_id'
						ORDER BY sparcsn4.argo_carrier_visit.phase";
						}
						else if($org_Type_id==57)
						{
							$query="SELECT sparcsn4.vsl_vessel_visit_details.vvd_gkey,sparcsn4.vsl_vessels.name,sparcsn4.vsl_vessel_visit_details.ib_vyg,sparcsn4.vsl_vessel_visit_details.ob_vyg,
							LEFT(sparcsn4.argo_carrier_visit.phase,2) AS phase_num,SUBSTR(sparcsn4.argo_carrier_visit.phase,3) AS phase_str,sparcsn4.argo_visit_details.eta,
							sparcsn4.argo_visit_details.etd,sparcsn4.argo_carrier_visit.ata,
							sparcsn4.argo_carrier_visit.atd,sparcsn4.ref_bizunit_scoped.id AS agent,
							IFNULL(sparcsn4.vsl_vessel_visit_details.flex_string02,sparcsn4.vsl_vessel_visit_details.flex_string03) AS berthop
							FROM sparcsn4.argo_carrier_visit
							INNER JOIN sparcsn4.argo_visit_details ON sparcsn4.argo_visit_details.gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
							INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_visit_details.gkey
							INNER JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
							INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.vsl_vessel_visit_details.bizu_gkey
							WHERE sparcsn4.vsl_vessel_visit_details.ib_vyg='$rot_num' and sparcsn4.ref_bizunit_scoped.id in (SELECT r.id FROM sparcsn4.ref_bizunit_scoped r       
							LEFT JOIN ( sparcsn4.ref_agent_representation X       
							LEFT JOIN sparcsn4.ref_bizunit_scoped Y ON X.agent_gkey=Y.gkey )  ON r.gkey=X.bzu_gkey 
							WHERE Y.id = '$login_id')
							ORDER BY sparcsn4.argo_carrier_visit.phase";
						}
						else
						{
							$query="SELECT sparcsn4.vsl_vessel_visit_details.vvd_gkey,sparcsn4.vsl_vessels.name,sparcsn4.vsl_vessel_visit_details.ib_vyg,sparcsn4.vsl_vessel_visit_details.ob_vyg,
							LEFT(sparcsn4.argo_carrier_visit.phase,2) AS phase_num,SUBSTR(sparcsn4.argo_carrier_visit.phase,3) AS phase_str,sparcsn4.argo_visit_details.eta,
							sparcsn4.argo_visit_details.etd,sparcsn4.argo_carrier_visit.ata,
							sparcsn4.argo_carrier_visit.atd,sparcsn4.ref_bizunit_scoped.id AS agent,
							IFNULL(sparcsn4.vsl_vessel_visit_details.flex_string02,sparcsn4.vsl_vessel_visit_details.flex_string03) AS berthop
							FROM sparcsn4.argo_carrier_visit
							INNER JOIN sparcsn4.argo_visit_details ON sparcsn4.argo_visit_details.gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
							INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_visit_details.gkey
							INNER JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
							INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.vsl_vessel_visit_details.bizu_gkey
							WHERE sparcsn4.vsl_vessel_visit_details.ib_vyg='$rot_num'
							ORDER BY sparcsn4.argo_carrier_visit.phase";
						}
		//echo $data['voysNo'];
		$rtnVesselList = $this->bm->dataSelect($query);
		$data['rtnVesselList']=$rtnVesselList;
		$data['login_id']=$login_id;
		$data['title']="VESSEL LIST WITH STATUS...";
		$this->load->view('header5');
		$this->load->view('viewVesselListWithStatus',$data);
		$this->load->view('footer_1');
			
	}
	//SOURAV
	// FOR IMPORT APPS LIST START
	function viewVesselListImportStatus()
	{
		$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$login_id = $this->session->userdata('login_id');
				$org_Type_id = $this->session->userdata('org_Type_id');
				if($org_Type_id==1)
					{
						$query="select * from ( SELECT ctmsmis.mis_inv_unit.vvd_gkey,ctmsmis.mis_inv_unit.vsl_visit_dtls_ib_vyg,ctmsmis.mis_inv_unit.vsl_name,
								(SELECT SUBSTR(sparcsn4.argo_carrier_visit.phase,3) FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS phase, 
								(SELECT LEFT(sparcsn4.argo_carrier_visit.phase,2) FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS phase_num,
								(SELECT sparcsn4.argo_carrier_visit.ata FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS ata,
								(SELECT sparcsn4.argo_carrier_visit.atd FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS atd,
								(SELECT sparcsn4.vsl_vessel_visit_details.flex_string02 FROM sparcsn4.vsl_vessel_visit_details WHERE sparcsn4.vsl_vessel_visit_details.vvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS bop,
								(SELECT sparcsn4.ref_bizunit_scoped.id FROM sparcsn4.vsl_vessel_visit_details
								INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.vsl_vessel_visit_details.bizu_gkey 
								WHERE sparcsn4.vsl_vessel_visit_details.vvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS mlo,
								COUNT(ctmsmis.mis_exp_unit.gkey) AS exp_cont
								FROM ctmsmis.mis_exp_unit 
								INNER JOIN ctmsmis.mis_inv_unit ON ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey
								WHERE ctmsmis.mis_inv_unit.vsl_visit_dtls_ib_vyg is not null and snx=0 
								GROUP BY 1) as tmp where PHASE not in ('CANCELED','CLOSED') and mlo='$login_id' order by phase_num";
					}
					else if($org_Type_id==57)
					{
						$query="select * from ( SELECT ctmsmis.mis_inv_unit.vvd_gkey,ctmsmis.mis_inv_unit.vsl_visit_dtls_ib_vyg,ctmsmis.mis_inv_unit.vsl_name,
								(SELECT SUBSTR(sparcsn4.argo_carrier_visit.phase,3) FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS phase, 
								(SELECT LEFT(sparcsn4.argo_carrier_visit.phase,2) FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS phase_num,
								(SELECT sparcsn4.argo_carrier_visit.ata FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS ata,
								(SELECT sparcsn4.argo_carrier_visit.atd FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS atd,
								(SELECT sparcsn4.vsl_vessel_visit_details.flex_string02 FROM sparcsn4.vsl_vessel_visit_details WHERE sparcsn4.vsl_vessel_visit_details.vvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS bop,
								(SELECT sparcsn4.ref_bizunit_scoped.id FROM sparcsn4.vsl_vessel_visit_details
								INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.vsl_vessel_visit_details.bizu_gkey 
								WHERE sparcsn4.vsl_vessel_visit_details.vvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS mlo,
								COUNT(ctmsmis.mis_exp_unit.gkey) AS exp_cont
								FROM ctmsmis.mis_exp_unit 
								INNER JOIN ctmsmis.mis_inv_unit ON ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey
								WHERE ctmsmis.mis_inv_unit.vsl_visit_dtls_ib_vyg is not null and snx=0 
								GROUP BY 1) as tmp where PHASE not in ('CANCELED','CLOSED') and mlo in (SELECT r.id FROM sparcsn4.ref_bizunit_scoped r       
							LEFT JOIN ( sparcsn4.ref_agent_representation X       
							LEFT JOIN sparcsn4.ref_bizunit_scoped Y ON X.agent_gkey=Y.gkey )  ON r.gkey=X.bzu_gkey 
							WHERE Y.id = '$login_id') order by phase_num";
					}
					else
					{
						$query="select * from ( SELECT ctmsmis.mis_inv_unit.vvd_gkey,ctmsmis.mis_inv_unit.vsl_visit_dtls_ib_vyg,ctmsmis.mis_inv_unit.vsl_name,
								(SELECT SUBSTR(sparcsn4.argo_carrier_visit.phase,3) FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS phase, 
								(SELECT LEFT(sparcsn4.argo_carrier_visit.phase,2) FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS phase_num,
								(SELECT sparcsn4.argo_carrier_visit.ata FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS ata,
								(SELECT sparcsn4.argo_carrier_visit.atd FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS atd,
								(SELECT sparcsn4.vsl_vessel_visit_details.flex_string02 FROM sparcsn4.vsl_vessel_visit_details WHERE sparcsn4.vsl_vessel_visit_details.vvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS bop,
								(SELECT sparcsn4.ref_bizunit_scoped.id FROM sparcsn4.vsl_vessel_visit_details
								INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.vsl_vessel_visit_details.bizu_gkey 
								WHERE sparcsn4.vsl_vessel_visit_details.vvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS mlo,
								COUNT(ctmsmis.mis_exp_unit.gkey) AS exp_cont
								FROM ctmsmis.mis_exp_unit 
								INNER JOIN ctmsmis.mis_inv_unit ON ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey
								WHERE ctmsmis.mis_inv_unit.vsl_visit_dtls_ib_vyg is not null and snx=0 
								GROUP BY 1) as tmp where PHASE not in ('CANCELED','CLOSED') order by phase_num";
					}
					//echo $query;
				//echo $data['voysNo'];
				$rtnVesselList = $this->bm->dataSelect($query);
				$data['rtnVesselList']=$rtnVesselList;
				$data['login_id']=$login_id;
					
				$data['title']="VESSEL LIST WITH STATUS...";
				$this->load->view('header5');
				$this->load->view('viewVesselListImportStatus',$data);
				$this->load->view('footer_1');
			}
	}
	function viewVesselListImportSearchList()
	{
		$rot_num=trim($this->input->post('rot_num'));
		$login_id = $this->session->userdata('login_id');
		$org_Type_id = $this->session->userdata('org_Type_id');
			if($org_Type_id==1)
						{
						$query="select * from ( SELECT ctmsmis.mis_inv_unit.vvd_gkey,ctmsmis.mis_inv_unit.vsl_visit_dtls_ib_vyg,ctmsmis.mis_inv_unit.vsl_name,
								(SELECT SUBSTR(sparcsn4.argo_carrier_visit.phase,3) FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS phase, 
								(SELECT LEFT(sparcsn4.argo_carrier_visit.phase,2) FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS phase_num,
								(SELECT sparcsn4.argo_carrier_visit.ata FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS ata,
								(SELECT sparcsn4.argo_carrier_visit.atd FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS atd,
								(SELECT sparcsn4.vsl_vessel_visit_details.flex_string02 FROM sparcsn4.vsl_vessel_visit_details WHERE sparcsn4.vsl_vessel_visit_details.vvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS bop,
								(SELECT sparcsn4.ref_bizunit_scoped.id FROM sparcsn4.vsl_vessel_visit_details
								INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.vsl_vessel_visit_details.bizu_gkey 
								WHERE sparcsn4.vsl_vessel_visit_details.vvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS mlo,
								COUNT(ctmsmis.mis_exp_unit.gkey) AS exp_cont
								FROM ctmsmis.mis_exp_unit 
								INNER JOIN ctmsmis.mis_inv_unit ON ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey
								WHERE ctmsmis.mis_inv_unit.vsl_visit_dtls_ib_vyg='$rot_num' and snx=0 
								GROUP BY 1) as tmp where PHASE not in ('CANCELED','CLOSED') and mlo='$login_id' order by phase_num";
						}
						else if($org_Type_id==57)
						{
						$query="select * from ( SELECT ctmsmis.mis_inv_unit.vvd_gkey,ctmsmis.mis_inv_unit.vsl_visit_dtls_ib_vyg,ctmsmis.mis_inv_unit.vsl_name,
								(SELECT SUBSTR(sparcsn4.argo_carrier_visit.phase,3) FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS phase, 
								(SELECT LEFT(sparcsn4.argo_carrier_visit.phase,2) FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS phase_num,
								(SELECT sparcsn4.argo_carrier_visit.ata FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS ata,
								(SELECT sparcsn4.argo_carrier_visit.atd FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS atd,
								(SELECT sparcsn4.vsl_vessel_visit_details.flex_string02 FROM sparcsn4.vsl_vessel_visit_details WHERE sparcsn4.vsl_vessel_visit_details.vvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS bop,
								(SELECT sparcsn4.ref_bizunit_scoped.id FROM sparcsn4.vsl_vessel_visit_details
								INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.vsl_vessel_visit_details.bizu_gkey 
								WHERE sparcsn4.vsl_vessel_visit_details.vvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS mlo,
								COUNT(ctmsmis.mis_exp_unit.gkey) AS exp_cont
								FROM ctmsmis.mis_exp_unit 
								INNER JOIN ctmsmis.mis_inv_unit ON ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey
								WHERE ctmsmis.mis_inv_unit.vsl_visit_dtls_ib_vyg='$rot_num' and snx=0 
								GROUP BY 1) as tmp where PHASE not in ('CANCELED','CLOSED') and mlo in (SELECT r.id FROM sparcsn4.ref_bizunit_scoped r       
							LEFT JOIN ( sparcsn4.ref_agent_representation X       
							LEFT JOIN sparcsn4.ref_bizunit_scoped Y ON X.agent_gkey=Y.gkey )  ON r.gkey=X.bzu_gkey 
							WHERE Y.id = '$login_id') order by phase_num";
						}
						else
						{
							$query="select * from ( SELECT ctmsmis.mis_inv_unit.vvd_gkey,ctmsmis.mis_inv_unit.vsl_visit_dtls_ib_vyg,ctmsmis.mis_inv_unit.vsl_name,
								(SELECT SUBSTR(sparcsn4.argo_carrier_visit.phase,3) FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS phase, 
								(SELECT LEFT(sparcsn4.argo_carrier_visit.phase,2) FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS phase_num,
								(SELECT sparcsn4.argo_carrier_visit.ata FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS ata,
								(SELECT sparcsn4.argo_carrier_visit.atd FROM sparcsn4.argo_carrier_visit WHERE sparcsn4.argo_carrier_visit.cvcvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS atd,
								(SELECT sparcsn4.vsl_vessel_visit_details.flex_string02 FROM sparcsn4.vsl_vessel_visit_details WHERE sparcsn4.vsl_vessel_visit_details.vvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS bop,
								(SELECT sparcsn4.ref_bizunit_scoped.id FROM sparcsn4.vsl_vessel_visit_details
								INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.vsl_vessel_visit_details.bizu_gkey 
								WHERE sparcsn4.vsl_vessel_visit_details.vvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey) AS mlo,
								COUNT(ctmsmis.mis_exp_unit.gkey) AS exp_cont
								FROM ctmsmis.mis_exp_unit 
								INNER JOIN ctmsmis.mis_inv_unit ON ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey
								WHERE ctmsmis.mis_inv_unit.vsl_visit_dtls_ib_vyg='$rot_num' and snx=0 
								GROUP BY 1) as tmp where PHASE not in ('CANCELED','CLOSED') order by phase_num";
						}
						
		//echo $data['voysNo'];
		$rtnVesselList = $this->bm->dataSelect($query);
		$data['rtnVesselList']=$rtnVesselList;
		$data['login_id']=$login_id;
		$data['title']="VESSEL LIST WITH STATUS IMPORT...";
		$this->load->view('header5');
		$this->load->view('viewVesselListImportStatus',$data);
		$this->load->view('footer_1');
			
	}
	// FOR IMPORT APPS LIST END
	
	function vesselListWithStatusEntry()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$remarks=trim($this->input->post('remarks'));
			$vvd_gkey=trim($this->input->post('vvd_gkey'));
			$ipaddr = $_SERVER['REMOTE_ADDR'];
			$login_id = $this->session->userdata('login_id');
				
			if($remarks=="")
			{
				$data['msg']="<font color='red'><b>Blank Comment Can not be Saved.</b></font>";
			}
			else
			{
				$getBerthOpQry="SELECT 
									IFNULL(flex_string03,flex_string02) AS berthop
									FROM sparcsn4.vsl_vessel_visit_details WHERE vvd_gkey=$vvd_gkey";
				$rtnBerthOp = $this->bm->dataSelect($getBerthOpQry);
				$rslt_berthop=$rtnBerthOp[0]['berthop'];
				
				$getOrgId="SELECT DISTINCT org_id FROM cchaportdb.users WHERE u_name LIKE '%$rslt_berthop%' AND org_Type_id=30";
				$rtnOrgId = $this->bm->dataSelectDb1($getOrgId);
				$rslt_OrgId=$rtnOrgId[0]['org_id'];
				
				$existChkQry="select count(vvd_gkey) as vvd_gkey from ctmsmis.mis_exp_vvd where vvd_gkey=$vvd_gkey";
					
				$rtnExistQry = $this->bm->dataSelect($existChkQry);
			//	echo "yt : ".$rtnExistQry;
				$rslt_vvd_gkey=$rtnExistQry[0]['vvd_gkey'];
					
				if($rslt_vvd_gkey<1) // insert Data
				{
					
					
					$insertQuery="insert into ctmsmis.mis_exp_vvd (vvd_gkey,comments,comments_by,comments_time,user_ip,brth_org_id,pre_comments,pre_comments_time) values('$vvd_gkey','$remarks','$login_id',now(),'$ipaddr','$rslt_OrgId','$remarks',now())";
					$vesselStatusEntryStat=$this->bm->dataInsert($insertQuery);
					if($vesselStatusEntryStat==1)
					{
						$data['msg']="<font color='green'><b>Data Successfully Inserted.</b></font>";
					}
					else
					{
						$data['msg']="<font color='red'><b>Data Not Inserted.</b></font>";
					}
				}
				else // update Data
					{
						$updateQuery="update ctmsmis.mis_exp_vvd  set comments='$remarks',comments_by='$login_id',comments_time=now(),user_ip='$ipaddr',brth_org_id='$rslt_OrgId' where vvd_gkey='$vvd_gkey'";
						$vesselStatusUpdtStat=$this->bm->dataInsert($updateQuery);
						if($vesselStatusUpdtStat==1)
						{
							$data['msg']="<font color='green'><b>Data Successfully Updated.</b></font>";
						}
						else
						{
							$data['msg']="<font color='red'><b>Data Not Updated.</b></font>";
						}
					}
			}
			$query="SELECT sparcsn4.vsl_vessel_visit_details.vvd_gkey,sparcsn4.vsl_vessels.name,sparcsn4.vsl_vessel_visit_details.ib_vyg,sparcsn4.vsl_vessel_visit_details.ob_vyg,
						LEFT(sparcsn4.argo_carrier_visit.phase,2) AS phase_num,SUBSTR(sparcsn4.argo_carrier_visit.phase,3) AS phase_str,sparcsn4.argo_visit_details.eta,
						sparcsn4.argo_visit_details.etd,sparcsn4.argo_carrier_visit.ata,
						sparcsn4.argo_carrier_visit.atd
						FROM sparcsn4.argo_carrier_visit
						INNER JOIN sparcsn4.argo_visit_details ON sparcsn4.argo_visit_details.gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
						INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_visit_details.gkey
						INNER JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
						WHERE sparcsn4.argo_carrier_visit.phase IN ('20INBOUND','30ARRIVED','40WORKING','50COMPLETE','60DEPARTED')
						ORDER BY sparcsn4.argo_carrier_visit.phase";
						//echo $data['voysNo'];
			$rtnVesselList = $this->bm->dataSelect($query);
			$data['rtnVesselList']=$rtnVesselList;			
			$data['title']="VESSEL LIST WITH STATUS...";
			$this->load->view('header5');
			$this->load->view('viewVesselListWithStatus',$data);
			$this->load->view('footer_1');
		}
	}
	//////////// VESSEL LIST WITH STATUS END//////////////////
	
	
		//EXPORT EXCEL UPLOAD SAMPLE FORM (WITH LOADED DATA) start
		function myExportExcelUploadSampleForm(){
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="EXPORT EXCEL UPLOAD SAMPLE FORM...";
				$this->load->view('header2');
				$this->load->view('myExportExcelUploadSampleForm',$data);
				$this->load->view('footer');
			}	
        }
		
		function myExportExcelUploadSampleReportViewPerform()
		{
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
			$this->load->model('ci_auth', 'bm', TRUE);
			$getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
			$data['voysNo']=$getVoyNo;

			$this->load->view('myExportExcelUploadSampleReportViewPerform',$data);
			$this->load->view('myclosebar');
		}
		/*function myExportExcelUploadSampleForm(){
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="EXPORT EXCEL UPLOAD SAMPLE FORM...";
				$this->load->view('header2');
				$this->load->view('myExportExcelUploadSampleForm',$data);
				$this->load->view('footer');
			}	
        }
		
		function myExportExcelUploadSampleReportViewPerform()
		{
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
			$this->load->model('ci_auth', 'bm', TRUE);
			$getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
			$data['voysNo']=$getVoyNo;

			$this->load->view('myExportExcelUploadSampleReportViewPerform',$data);
			$this->load->view('myclosebar');
		}*/
		
		//EXPORT EXCEL UPLOAD SAMPLE FORM (WITH LOADED DATA) end
		
		//EXPORT EXCEL UPLOAD SAMPLE (WITH LOADED DATA) start
		
		function myExportExcelUploadSample(){
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="EXPORT EXCEL UPLOAD SAMPLE...";
				$this->load->view('header2');
				$this->load->view('myExportExcelUploadSample',$data);
				$this->load->view('footer');
			}	
        }
				
		function myExportExcelUploadSampleReportView()
		{
		if($this->uri->segment(3))
		{
			$ddl_imp_rot_no=str_replace("_","/",$this->uri->segment(3));
		}
		else
		{
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
		}
						
			$this->load->model('ci_auth', 'bm', TRUE);
			$getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
			$data['voysNo']=$getVoyNo;
			$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
			/* $fromdate=$this->input->post('fromdate');
			$fromTime=$this->input->post('fromTime');
			$todate=$this->input->post('todate');
			$toTime=$this->input->post('toTime');
			$data['fromdate']=$fromdate;
			$data['fromTime']=$fromTime;
			$data['todate']=$todate;
			$data['toTime']=$toTime; */
			
			//echo $data['toTime'];
			//return;
			$this->load->view('myExportExcelUploadSampleReportView',$data);
			$this->load->view('myclosebar');
		}
		
		//EXPORT EXCEL UPLOAD SAMPLE (WITH LOADED DATA) end
		///////////// POD,ISO CODE,YARD LIST START ///////////////
	function podListView()
	{
		$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$query="SELECT DISTINCT ref_unloc_code.id,ref_unloc_code.place_code,ref_unloc_code.place_name
						FROM ref_routing_point
						INNER JOIN ref_unloc_code ON ref_unloc_code.gkey=ref_routing_point.unloc_gkey
						ORDER BY ref_unloc_code.id";
				//echo $data['voysNo'];
				$rtnVesselList = $this->bm->dataSelect($query);
				$data['rtnVesselList']=$rtnVesselList;
					
				$data['title']="POD LIST ...";
				$this->load->view('header2');
				$this->load->view('podListView',$data);
				$this->load->view('footer');
			}
	}
	function podListViewSearchList()
	{
		$rot_num=trim($this->input->post('rot_num'));
				
		$query="SELECT DISTINCT ref_unloc_code.id,ref_unloc_code.place_code,ref_unloc_code.place_name
				FROM ref_routing_point
				INNER JOIN ref_unloc_code ON ref_unloc_code.gkey=ref_routing_point.unloc_gkey
				where place_code='$rot_num'
				ORDER BY ref_unloc_code.id";
		//echo $data['voysNo'];
		$rtnVesselList = $this->bm->dataSelect($query);
		$data['rtnVesselList']=$rtnVesselList;
				
		$data['title']="POD LIST ...";
		$this->load->view('header2');
		$this->load->view('podListView',$data);
		$this->load->view('footer');
			
	}
	function yardListView()
	{
		$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$query="select terminal,block,block_cpa from ctmsmis.yard_block order by terminal asc";
				//echo $data['voysNo'];
				$rtnVesselList = $this->bm->dataSelect($query);
				$data['rtnVesselList']=$rtnVesselList;
					
				$data['title']="YARD LIST ...";
				$this->load->view('header2');
				$this->load->view('yardListView',$data);
				$this->load->view('footer');
			}
	}
	function yardListViewSearchList()
	{
		$terminal=trim($this->input->post('rot_num'));
				
		$query="select terminal,block,block_cpa from ctmsmis.yard_block where terminal='$terminal' order by terminal asc";
		//echo $data['voysNo'];
		$rtnVesselList = $this->bm->dataSelect($query);
		$data['rtnVesselList']=$rtnVesselList;
				
		$data['title']="YARD LIST ...";
		$this->load->view('header2');
		$this->load->view('yardListView',$data);
		$this->load->view('footer');
			
	}
	function isoCodeListView()
	{
		$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$query="SELECT DISTINCT cont_iso_type,cont_size,cont_height,cont_type FROM igm_detail_container";
				//echo $data['voysNo'];
				$rtnVesselList = $this->bm->dataSelectDb1($query);
				$data['rtnVesselList']=$rtnVesselList;
					
				$data['title']="ISO CODE LIST ...";
				$this->load->view('header2');
				$this->load->view('isoCodeListView',$data);
				$this->load->view('footer');
			}
	}
	function isoCodeListViewSearchList()
	{
		$iso_type=trim($this->input->post('rot_num'));
				
		$query="SELECT DISTINCT cont_iso_type,cont_size,cont_height,cont_type FROM igm_detail_container where cont_iso_type='$iso_type'";
		//echo $data['voysNo'];
		$rtnVesselList = $this->bm->dataSelectDb1($query);
		$data['rtnVesselList']=$rtnVesselList;
				
		$data['title']="ISO CODE LIST ...";
		$this->load->view('header2');
		$this->load->view('isoCodeListView',$data);
		$this->load->view('footer');
			
	}
	///////////// POD,ISO CODE,YARD LIST END ///////////////
	//Search Vessel List start
		function commentsSearchForVessel(){
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="SEARCH COMMENTS...";
				$this->load->view('header2');
				$this->load->view('commentsSearchForVessel',$data);
				$this->load->view('footer');
			}	
        }
		function commentsSearchForVesselDownloadView(){
				$login_id = $this->session->userdata('login_id');	
				$data['login_id']=$login_id;
					//$search_by = $this->input->post('search_by');
				$fromDt=$this->input->post('from_dt');
				$toDt=$this->input->post('to_dt');
				
				//$search_value=$this->input->post('search_value');
				$data['title']="Vessel List With Comments by Shipping Section </br> From ".$fromDt." To ".$toDt;
				//$data['rot']=$search_value;
				$data['fromDt']=$fromDt;
				$data['toDt']=$toDt;
					
						 
				$this->load->view('commentsSearchForVesselDownloadView',$data);   
				}
		//Search Vessel List end
		//YARD WISE CONTAINER HANDLING REPORT START ////
		function yardWiseContainerHandlingRptForm(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{  
				$data['title']="YARD WISE CONTAINER RECEIVE REPORT...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('yardWiseContainerHandlingFrm',$data);
				$this->load->view('footer');
			}	
        }
			//container Handling Report
		function yardWiseContainerHandlingView(){

			$session_id = $this->session->userdata('value');

				 if($this->input->post())
				{
					$rotNum=$this->input->post('rotNum');
					$yard_no=$this->input->post('yard_no');
					$block=$this->input->post('block');
					$fromdate=$this->input->post('fromdate');
					$fromTime=$this->input->post('fromTime');
					$todate=$this->input->post('todate');
					$toTime=$this->input->post('toTime');
				}
				
				$data['rotNum']=$rotNum;
				$data['yard_no']=$yard_no;
				$data['block']=$block;
				$data['fromdate']=$fromdate;
				$data['fromTime']=$fromTime;
				$data['todate']=$todate;
				$data['toTime']=$toTime;
				
				
				$this->load->view('yardWiseContainerHandlingList',$data);
				$this->load->view('myclosebar');
        }
		//YARD WISE CONTAINER HANDLING REPORT END ////
			//YARD WISE CONTAINER HANDLING REPORT START ////
		function yardWiseContainerHandlingDetailsRptForm(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{  
				$data['title']="CURRENT YARD LYING CONTAINER REPORT...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('yardWiseContainerHandlingDetailsFrm',$data);
				$this->load->view('footer');
			}	
        }
			//container Handling Report
		function yardWiseContainerHandlingDetailsView(){

			$session_id = $this->session->userdata('value');

				 if($this->input->post())
				{
					$yard_no=$this->input->post('yard_no');
					$block=$this->input->post('block');							
				}
				
				$data['yard_no']=$yard_no;
				$data['block']=$block;

				$this->load->view('yardWiseContainerHandlingDetailsList',$data);
				$this->load->view('myclosebar');
        }
		function yardWiseContainerDeliveryRptForm(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{  
				$data['title']="YARD WISE CONTAINER DELIVERY REPORT...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('yardWiseContainerDeliveryFrm',$data);
				$this->load->view('footer');
			}	
        }
			//container Handling Report
		function yardWiseContainerDeliveryView(){

				$session_id = $this->session->userdata('value');

				 if($this->input->post())
				{
					$assDt=$this->input->post('assDt');
					$yard_no=$this->input->post('yard_no');
					$block=$this->input->post('block');
					$fromdate=$this->input->post('fromdate');
					$fromTime=$this->input->post('fromTime');
					$todate=$this->input->post('todate');
					$toTime=$this->input->post('toTime');
				}
				
				$data['assDt']=$assDt;
				$data['yard_no']=$yard_no;
				$data['block']=$block;
				$data['fromdate']=$fromdate;
				$data['fromTime']=$fromTime;
				$data['todate']=$todate;
				$data['toTime']=$toTime;

				$this->load->view('yardWiseContainerDeliveryList',$data);
				$this->load->view('myclosebar');
        }
		//YARD WISE CONTAINER HANDLING REPORT END ////
				/*************************************************/
				
		//Search IGM Container start

		function searchIGMByContainer()
		{
			$flag=0;
			
			$data['title']="Search IGM Container...";
			$data['flag']=$flag;
			$this->load->view('header2');
			$this->load->view('searchIGMByContainer',$data);
			$this->load->view('footer');
		}
		
		function searchIGMByContainerPerform()
		{
			$container=$this->input->post('container');
			$flag=1;
			
			$sql_container_search="SELECT DISTINCT cont_number,Import_Rotation_No,mlocode,cont_size,cont_height 
			FROM igm_detail_container
			INNER JOIN igm_details ON igm_details.id=igm_detail_container.igm_detail_id
			WHERE cont_number LIKE '$container%'";
			
			$rslt_container_search = $this->bm->dataSelectDb1($sql_container_search);
			
			$data['flag']=$flag;
			$data['title']="Search IGM Container...";
			$data['rslt_container_search']=$rslt_container_search;
			$this->load->view('header2');
			$this->load->view('searchIGMByContainer',$data);
			$this->load->view('footer');
		}
	function uploadSignature()
		{
			$preRot=$this->input->post('rotNumber');
			$rot=str_replace('/','_',$preRot);
			$cont=$this->input->post('contNumber');
			//$user=$this->input->post('user');
			
			$upload_dir = FCPATH . 'resources/images/Signature/';  //implement this function yourself
			
			$img = $this->input->post('my_hidden');
			$img_ff = $this->input->post('my_hidden_ff');
			$img_cpa = $this->input->post('my_hidden_cpa');
			
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
			$sign_name="sign_".$rot."_".$cont."_bo.png";
			$file = $upload_dir.$sign_name;
			
			$sign_name_ff="sign_".$rot."_".$cont."_ff.png";
			$file_ff = $upload_dir.$sign_name_ff;
			
			$sign_name_cpa="sign_".$rot."_".$cont."_cpa.png";
			$file_cpa = $upload_dir.$sign_name_cpa;
					
			$str = "update shed_tally_info set signature_path_berth='$sign_name',signature_path_freight='$sign_name_ff',signature_path_cpa='$sign_name_cpa' where import_rotation='$preRot' and cont_number='$cont'";				
			//$data['str']=$str;
			$stat = $this->bm->dataInsertDB1($str);  //comment out to stop insertion
			if($stat==1)
			{
				//$data['stat']="1";
				$data['stat']="Image Successfully Uploaded";
				$success = file_put_contents($file, $dataImg);
				$success_ff = file_put_contents($file_ff, $dataImg_ff);
				$success_cpa = file_put_contents($file_cpa, $dataImg_cpa);
				
				require('ShedBillController.php');
				$test = new ShedBillController();
				$test->tallyReportPdf($preRot,$cont);
				
			}
			else
			{
				//$data['stat']="0";	
				$data['stat']="Image Successfully Not Uploaded";	
			}
			echo json_encode($data);
		}
		//Search IGM Container end
		
		//Container Search start
	function containerSearchForm()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$flag=0;
			$data['msg']="";
			$data['flag']=$flag;
			$data['title']="CONTAINER SEARCH...";
			$this->load->view('header5');
			$this->load->view('containerSearchForm',$data);
			$this->load->view('footer_1');
		}	
	}
		
	function containerSearchResult()
	{	
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$ddl_imp_cont_no=$this->input->post('ddl_imp_cont_no');
			$assignment=$this->input->post('assignment');
			$flag=1;
		
			$sqlBl="select BL_No from igm_details inner join igm_detail_container on igm_detail_container.igm_detail_id=igm_details.id where cont_number='$ddl_imp_cont_no' order by igm_detail_container.id desc";
			$rtnBlList = $this->bm->dataSelectDb1($sqlBl);
			$rtnBlNo= $rtnBlList[0]['BL_No'];
						
			$sqlContainer="select igm_details.id,igm_detail_container.cont_gross_weight,igm_details.mlocode,left(igm_details.Description_of_Goods,20) AS Description_of_Goods,cont_number,igm_details.Import_Rotation_No,igm_details.BL_No,
			(select Vessel_Name from igm_masters 
			where igm_masters.id=igm_details.IGM_id) as vsl_name,
			igm_details.BL_No,
			cont_size,cont_height,off_dock_id,
			(select Organization_Name from organization_profiles where organization_profiles.id=igm_detail_container.off_dock_id) as offdock_name,
			cont_status,cont_seal_number,cont_iso_type 
			from igm_detail_container 
			inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id 
			where igm_details.BL_No='$rtnBlNo'
			union
			select igm_details.id,igm_detail_container.cont_gross_weight,igm_details.mlocode,left(igm_details.Description_of_Goods,20) AS Description_of_Goods,igm_sup_detail_container.cont_number,igm_details.Import_Rotation_No,igm_details.BL_No,
			(select Vessel_Name from igm_masters 
			where igm_masters.id=igm_supplimentary_detail.igm_master_id) as vsl_name,igm_details.BL_No,igm_sup_detail_container.cont_size,igm_sup_detail_container.cont_height,igm_sup_detail_container.off_dock_id,
			(select Organization_Name 
			from organization_profiles where organization_profiles.id=igm_sup_detail_container.off_dock_id) as offdock_name,igm_sup_detail_container.cont_status,igm_sup_detail_container.cont_seal_number,igm_sup_detail_container.cont_iso_type 
			from igm_sup_detail_container 
			inner join igm_supplimentary_detail on igm_supplimentary_detail.id=igm_sup_detail_container.igm_sup_detail_id 
			inner join igm_details on igm_details.id=igm_supplimentary_detail.igm_detail_id
			inner join igm_detail_container on igm_detail_container.igm_detail_id=igm_details.id
			where igm_supplimentary_detail.BL_No='$rtnBlNo'";
			
			$rtnContainerList = $this->bm->dataSelectDb1($sqlContainer);
			$data['rtnContainerList']=$rtnContainerList;
			
			$data['assignment']=$assignment;
			$data['containerNo']=$ddl_imp_cont_no;
			$data['blNo']=$ddl_imp_bl_no;
			$data['flag']=$flag;
		//	$data['title']="Container List";
		//	$this->load->view('header5');
			$this->load->view('containerSearchResult',$data);
		//	$this->load->view('footer_1');
		}
	}
	//Container Search end
		/// Container Discharge By Apps Start ///////
		public function containerDischargeAppsForm()
		{
			/*$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{*/
				$strAllList = "SELECT ctmsmis.mis_exp_unit.gkey,mis_exp_unit.cont_id AS id,mis_exp_unit.rotation,mis_exp_unit.isoType AS iso,
				(CASE 
				WHEN mis_exp_unit.cont_size= '20' AND mis_exp_unit.cont_height = '86' AND mis_exp_unit.isoGroup NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC') THEN '2D'
				WHEN mis_exp_unit.cont_size = '40' AND mis_exp_unit.cont_height='86' AND mis_exp_unit.isoGroup NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC') THEN '4D'
				WHEN mis_exp_unit.cont_size = '40' AND mis_exp_unit.cont_height='96' AND mis_exp_unit.isoGroup NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC') THEN '4H'
				WHEN mis_exp_unit.cont_size = '45' AND mis_exp_unit.cont_height='96' AND mis_exp_unit.isoGroup NOT IN ('RS','RT','RE','UT','TN','TD','TG','PF','PC') THEN '45H'
				WHEN mis_exp_unit.cont_size = '20' AND mis_exp_unit.cont_height='86' AND mis_exp_unit.isoGroup IN ('RS','RT','RE') THEN '2RF'
				WHEN mis_exp_unit.cont_size = '40' AND mis_exp_unit.isoGroup IN ('RS','RT','RE') THEN '4RH'
				WHEN mis_exp_unit.cont_size = '20' AND mis_exp_unit.cont_height='86' AND mis_exp_unit.isoGroup IN ('UT') THEN '2OT'
				WHEN mis_exp_unit.cont_size = '40' AND mis_exp_unit.isoGroup IN ('UT') THEN '4OT'
				WHEN mis_exp_unit.cont_size = '20' AND mis_exp_unit.cont_height='86' AND mis_exp_unit.isoGroup IN ('PF','PC') THEN '2FR'
				WHEN mis_exp_unit.cont_size = '40' AND mis_exp_unit.isoGroup IN ('PF','PC') THEN '4FR'
				WHEN mis_exp_unit.cont_size = '20' AND mis_exp_unit.cont_height='86' AND mis_exp_unit.isoGroup IN ('TN','TD','TG') THEN '2TK'
				ELSE ''
				END
				) AS TYPE,
				mis_exp_unit.cont_mlo AS mlo,ctmsmis.mis_exp_unit.current_position,
				cont_status AS freight_kind,ctmsmis.mis_exp_unit.goods_and_ctr_wt_kg AS weight,ctmsmis.mis_exp_unit.coming_from AS coming_from,
				ctmsmis.mis_exp_unit.pod,ctmsmis.mis_exp_unit.stowage_pos,ctmsmis.mis_exp_unit.last_update,
				ref_commodity.short_name,ctmsmis.mis_exp_unit.user_id,sparcsn4.inv_goods.destination
				FROM ctmsmis.mis_exp_unit 
				INNER JOIN sparcsn4.inv_unit ON sparcsn4.inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
				INNER join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
				INNER JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
				INNER JOIN sparcsn4.ref_commodity ON sparcsn4.ref_commodity.gkey=sparcsn4.inv_goods.commodity_gkey
				where  mis_exp_unit.snx_type=2 and sparcsn4.inv_unit_fcy_visit.transit_state='S20_INBOUND' order by last_update desc";
				
				$rtnAllList = $this->bm->dataSelect($strAllList);
				$data['rtnAllList']=$rtnAllList;
				$data['title']="CONTAINER DISCHARGE LIST APPS...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('containerDischargeAppsForm',$data);
				$this->load->view('footer');
			//}	
		}
		public function containerDischargeAppsList()
		{
			
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
			$this->load->model('ci_auth', 'bm', TRUE);
			$getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
			$data['voysNo']=$getVoyNo;
			
			$search_by = $this->input->post('search_by');
					
					
			if($search_by=="yard" and $ddl_imp_rot_no=="")
			{
				$search_value=$this->input->post('search_value');
				$fromdate=$this->input->post('fromdate');
				$todate=$this->input->post('todate');
				$data['title']="DISCHARGE CONTAINER FOR THE YARD ".$search_value;
				$data['yard']=$search_value;
				$data['search_by']=$search_by;
				//$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
				$data['fromdate']=$fromdate;
				$data['todate']=$todate;
			}
			if($search_by=="yard" and $ddl_imp_rot_no!="")
			{
				$search_value=$this->input->post('search_value');
				$fromdate=$this->input->post('fromdate');
				$todate=$this->input->post('todate');
				$data['title']="DISCHARGE CONTAINER FOR THE YARD ".$search_value;
				$data['yard']=$search_value;
				$data['search_by']=$search_by;
				$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
				$data['fromdate']=$fromdate;
				$data['todate']=$todate;
			}
			if($search_by=="all" and $ddl_imp_rot_no!="")
			{
				//$search_value=$this->input->post('search_value');
				$data['title']="DISCHARGE CONTAINER FOR THE ROTATION".$ddl_imp_rot_no;
				//$data['yard']=$search_value;
				$data['search_by']="all";
				$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
			}
			else if($search_by=="dateRange")
			{
				$fromdate=$this->input->post('fromdate');
				$todate=$this->input->post('todate');
				
				$data['title']="DISCHARGE CONTAINER FROM ".$fromdate." TO ".$todate;
				$data['fromdate']=$fromdate;
				$data['todate']=$todate;
				$data['search_by']=$search_by;
				$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
			}
			else if($search_by=="dateTime")
			{
				$fromdate=$this->input->post('fromdate');
				$todate=$this->input->post('todate');
				$fromTime=$this->input->post('fromTime');
				$toTime=$this->input->post('toTime');
				
				$data['title']="DISCHARGE CONTAINER FROM ".$fromdate." ".$fromTime." TO ".$todate." ".$toTime;
				$data['fromdate']=$fromdate;
				$data['todate']=$todate;
				$data['fromTime']=$fromTime;
				$data['toTime']=$toTime;
				$data['search_by']=$search_by;
				$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
			}
			else{
				//$stripping_date_from=$this->input->post('stripping_date_from');
				//$stripping_date_to=$this->input->post('stripping_date_to');
					
				//$search_value=$this->input->post('search_value');
				//$data['search_by']=$search_by;
				//$data['title']="CONTAINERS LIST From ".$stripping_date_from." To ".$stripping_date_to;
				//$data['stripping_date_from']=$stripping_date_from;
				//$data['stripping_date_to']=$stripping_date_to;
					}
			$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
			$this->load->view('containerDischargeAppsList',$data);
			$this->load->view('myclosebar');
		}
		/// Container Discharge By Apps End ///////
		// Container Search By ROTATION APPS START/////
		public function containerSearchByRotationAppsForm()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="CONTAINER SEARCH BY ROTATION APPS..";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('containerSearchByRotationAppsForm',$data);
				$this->load->view('footer');
			}
		}
		public function containerSearchByRotationAppsList()
		{
			$rotation = $this->input->post('rotation');
			$search_format = $this->input->post('options');
			if($search_format=="xl" or $search_format=="html")
			{
				$data['rotation']=$rotation;
				$data['title']="CONTAINER SEARCH BY APPS";
				$this->load->view('containerSearchByRotationAppsList',$data);
				$this->load->view('myclosebar');
			}
			else{
				//load mPDF library
				$this->load->library('m_pdf');
				$pdf->use_kwt = true;
				//$this->data['search_by']=$search_by;
				$this->data['rotation']=$rotation;
				$this->data['title']="CONTAINER SEARCH BY APPS";
				//$this->data['toDt']=$toDt;
				$html=$this->load->view('containerSearchByRotationAppsList',$this->data, true);
				//this the the PDF filename that user will get to download
				$pdfFilePath ="containerSearchByRotationAppsList-".time()."-download.pdf";
				$pdf = $this->m_pdf->load();
				$pdf->SetWatermarkText('CPA CTMS');
				$pdf->showWatermarkText = true;	
				$stylesheet = file_get_contents('resources/styles/test.css'); // external css
				$pdf->useSubstitutions = true; // optional - just as an example
				//$pdf->SetHeader($url . "\n\n" . 'Date {DATE j-m-Y}');  // optional - just as an example
				//echo "SheetAdd : ".$stylesheet;
				$pdf->setFooter('Developed By : DataSoft|Page {PAGENO} of {nb}|Date {DATE j-m-Y}');
				//$footerHtml='<pagefooter name="MyFooter1" content-left="{DATE j-m-Y}" content-center="{PAGENO}/{nbpg}" content-right="My document" footer-style="font-family: serif; font-size: 8pt; font-weight: bold; font-style: italic; color: #000000;" />';
				$pdf->WriteHTML($stylesheet,1);
				$pdf->WriteHTML($html,2);
				$pdf->Output($pdfFilePath, "I"); // For Show Pdf
					//load mPDF library
				
				}
			
		}
		// Container Search By ROTATION APPS END/////
		//MIS Assignment start
	function misAssignmentForm()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();	
		}
		else
		{
			$title="MIS Assignment";
				
			$data['title']=$title;
			$this->load->view('header2');
			$this->load->view('misAssignmentForm',$data);
			$this->load->view('footer');
		}
	}
	
	function misAssignmentPerform()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();	
		}
		else
		{
			$date=$this->input->post('date');
			$terminal=$this->input->post('terminal');		//CCT, NCT, GCB
			$yard=$this->input->post('yard');
			$assigntype=$this->input->post('assigntype');
			$filetype=$this->input->post('option');
			
			//pdf start
			if($filetype=="pdf")
			{
				$this->load->library('m_pdf');
				$mpdf->use_kwt = true;
				
				if($terminal=="CCT" or $terminal=="NCT")
				{
					$sqlNCTCCT="SELECT DISTINCT mfdch_value,mfdch_desc 
					FROM ctmsmis.tmp_assignment_type_new
					WHERE date(flex_date01)='$date' and 
					(CASE
						WHEN
							'$assigntype' !='ALLASSIGN'
						THEN
							Yard_No='$terminal' AND mfdch_value='$assigntype'
						ELSE
							Yard_No='$terminal'
					END)
					ORDER BY Yard_No,mfdch_value,flex_date01,line_no";
					
					/*
					if('$assigntype' !='ALLASSIGN')
						SELECT DISTINCT mfdch_value,mfdch_desc 
						FROM ctmsmis.tmp_assignment_type_new
						WHERE date(flex_date01)='$date' and Yard_No='$terminal' AND mfdch_value='$assigntype';
					else 
						SELECT DISTINCT mfdch_value,mfdch_desc 
						FROM ctmsmis.tmp_assignment_type_new
						WHERE date(flex_date01)='$date' and Yard_No='$terminal';
					*/
					
					$rsltNCTCCT=$this->bm->dataSelect($sqlNCTCCT);
				
					$this->data['date']=$date;
					$this->data['terminal']=$terminal;
					$this->data['rsltNCTCCT']=$rsltNCTCCT;

					$html=$this->load->view('cctnctReport',$this->data, true); 
					 
					$pdfFilePath ="cctnctReport-".time()."-download.pdf";

					$pdf = $this->m_pdf->load();
					$pdf->SetWatermarkText('CPA CTMS');
					$pdf->showWatermarkText = true;	
					$stylesheet = file_get_contents('resources/styles/cctnct.css'); 
					
					$pdf->AddPage('P', // L - landscape, P - portrait
						'', '', '', '',
						10, // margin_left
						10, // margin right
						10, // margin top
						10, // margin bottom
						5, // margin header
						10); // margin footer
						
					$pdf->WriteHTML($stylesheet,1);
					$pdf->WriteHTML($html,2);
						 
					$pdf->Output($pdfFilePath, "I"); // For Show Pdf
				}
			
				else if($terminal=="GCB")
				{
					$sqlGCB="SELECT DISTINCT Block_No FROM ctmsmis.tmp_assignment_type_new
					WHERE 
						(CASE
							WHEN
								'$yard' !='ALLBLOCK'
							THEN
								(CASE
									WHEN
										'$assigntype' !='ALLASSIGN'
									THEN
										Yard_No='$terminal' AND Block_No='$yard' AND mfdch_value='$assigntype'
									ELSE
										Yard_No='$terminal' AND Block_No='$yard'
								END)
							ELSE
								(CASE
									WHEN
										'$assigntype' !='ALLASSIGN'
									THEN
										Yard_No='$terminal' AND mfdch_value='$assigntype'
									ELSE
										Yard_No='$terminal'
								END)
						END)
							ORDER BY Yard_No,Block_No,mfdch_value,flex_date01,line_no";
					//return;
					$rsltGCB=$this->bm->dataSelect($sqlGCB);
				
					$this->data['date']=$date;
					$this->data['yard']=$yard;
					$this->data['assigntype']=$assigntype;
					$this->data['terminal']=$terminal;
					$this->data['rsltGCB']=$rsltGCB;
					
					$html=$this->load->view('gcbReport',$this->data, true);	//change view
					 
					$pdfFilePath ="gcbReport-".time()."-download.pdf";

					$pdf = $this->m_pdf->load();
					$pdf->SetWatermarkText('CPA CTMS');
					$pdf->showWatermarkText = true;	
					$stylesheet = file_get_contents('resources/styles/cctnct.css'); 
					
					$pdf->AddPage('P', // L - landscape, P - portrait
						'', '', '', '',
						10, // margin_left
						10, // margin right
						10, // margin top
						10, // margin bottom
						5, // margin header
						10); // margin footer
						
					$pdf->WriteHTML($stylesheet,1);
					$pdf->WriteHTML($html,2);
						 
					$pdf->Output($pdfFilePath, "I"); // For Show Pdf
				}
			}
			//pdf end
			
			//excel start
			else
			{
				if($terminal=="CCT" or $terminal=="NCT")
				{
					$sqlNCTCCT="SELECT DISTINCT mfdch_value,mfdch_desc 
					FROM ctmsmis.tmp_assignment_type_new
					WHERE date(flex_date01)='$date' and 
					(CASE
						WHEN
							'$assigntype' !='ALLASSIGN'
						THEN
							Yard_No='$terminal' AND mfdch_value='$assigntype'
						ELSE
							Yard_No='$terminal'
					END)
					ORDER BY Yard_No,mfdch_value,flex_date01,line_no";
					
					$rsltNCTCCT=$this->bm->dataSelect($sqlNCTCCT);
				
					$data['date']=$date;
					$data['terminal']=$terminal;
					$data['rsltNCTCCT']=$rsltNCTCCT;

					$this->load->view('cctnctExcel',$data);  
				}
				
				else if($terminal=="GCB")
				{
					$sqlGCB="SELECT DISTINCT Block_No FROM ctmsmis.tmp_assignment_type_new
					WHERE 
						(CASE
							WHEN
								'$yard' !='ALLBLOCK'
							THEN
								(CASE
									WHEN
										'$assigntype' !='ALLASSIGN'
									THEN
										Yard_No='$terminal' AND Block_No='$yard' AND mfdch_value='$assigntype'
									ELSE
										Yard_No='$terminal' AND Block_No='$yard'
								END)
							ELSE
								(CASE
									WHEN
										'$assigntype' !='ALLASSIGN'
									THEN
										Yard_No='$terminal' AND mfdch_value='$assigntype'
									ELSE
										Yard_No='$terminal'
								END)
						END)
							ORDER BY Yard_No,Block_No,mfdch_value,flex_date01,line_no";
					//return;
					$rsltGCB=$this->bm->dataSelect($sqlGCB);
				
					$data['date']=$date;
					$data['yard']=$yard;
					$data['assigntype']=$assigntype;
					$data['terminal']=$terminal;
					$data['rsltGCB']=$rsltGCB;
					
					$this->load->view('gcbExcel',$data);  
				}
			}
			//excel end
		}
	}
	//MIS Assignment end
	/// Last 24 Hour ER Position Start ///////
		public function last24HoursERForm()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="LAST 24 HOURS 20' AND 40' EIR POSITION";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('last24HoursERForm',$data);
				$this->load->view('footer');
			}	
		}
		public function last24HoursERList()
		{
			$search_by = $this->input->post('er_date');
			$search_yard = $this->input->post('search_yard');
			$search_shift = $this->input->post('search_shift');
			if($search_shift=="all")
			{
				$data['fromTime']="08:30:00";
				$data['toTime']="08:30:00";
			}
			else if($search_shift=="A")
			{
				$data['fromTime']="08:30:01";
				$data['toTime']="16:30:00";
			}
			else if($search_shift=="B")
			{
				$data['fromTime']="16:30:01";
				$data['toTime']="00:30:00";
			}
			else if($search_shift=="C")
			{
				$data['fromTime']="00:30:01";
				$data['toTime']="08:30:00";
			}
			$data['title']="LAST 24 HOURS 20' AND 40' EIR POSITION";
			
			$data['search_by']=$search_by;
			$data['search_yard']=$search_yard;
			$data['search_shift']=$search_shift;
			$this->load->view('last24HoursERList',$data);
			$this->load->view('myclosebar');
		}
	/// Last 24 Hour ER Position End ///////
	/// OffDock Removal Position Start ///////
		public function offDockRemovalPositionForm()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="OFFDOCK REMOVAL POSITION FROM YARD TO DEPOT";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('offDockRemovalPositionForm',$data);
				$this->load->view('footer');
			}	
		}
		public function offDockRemovalPositionList()
		{
			$search_by = $this->input->post('er_date');
			$search_shift = $this->input->post('search_shift');
			$terminal = $this->input->post('terminal');
			$search_yard = $this->input->post('search_yard');
			if($search_shift=="all")
			{
				$data['fromTime']="00:00:00";
				$data['toTime']="23:59:59";
			}
			else if($search_shift=="A")
			{
				$data['fromTime']="08:00:01";
				$data['toTime']="16:00:00";
			}
			else if($search_shift=="B")
			{
				$data['fromTime']="16:00:01";
				$data['toTime']="23:59:59";
			}
			else if($search_shift=="C")
			{
				$data['fromTime']="00:00:00";
				$data['toTime']="08:00:00";
			}
			
			$data['title']="OFFDOCK REMOVAL POSITION FROM ".$search_yard." YARD TO DEPOT";
			
			$data['search_by']=$search_by;
			$data['terminal']=$terminal;
			$data['search_yard']=$search_yard;
			$data['search_shift']=$search_shift;
			$this->load->view('offDockRemovalPositionList',$data);
			$this->load->view('myclosebar');
		}
	/// Last 24 Hour ER Position End ///////
		
	public function appraiseReSlotLocForm()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="APPRAISE RE-SLOT LOCATION...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('appraiseReSlotLocForm',$data);
				$this->load->view('footer');
			}	
		}
		
		//appraisementRegister
 function appraisementRegisterPerform()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();	
		}
		else
		{
			$this->load->library('m_pdf');
			$mpdf->use_kwt = true;
			
		/* 	$date=$this->input->post('date');
			$terminal=$this->input->post('terminal');
			$block=$this->input->post('block');
			$assigntype=$this->input->post('assigntype'); */
			
			$date=$this->input->post('regdate');
			$terminal=$this->input->post('regterminal');		//CCT, NCT, GCB
			$yard=$this->input->post('regblock');
			$assigntype=$this->input->post('regassigntype');
		//	$filetype=$this->input->post('option');
			
			
			$this->load->library('m_pdf');
			$mpdf->use_kwt = true;
				
			if($terminal=="CCT" or $terminal=="NCT")
			{
			//	echo "ok";
				$sqlNCTCCT="SELECT DISTINCT mfdch_value,mfdch_desc 
				FROM ctmsmis.tmp_assignment_type_new
				WHERE date(flex_date01)='$date' and 
				(CASE
					WHEN
						'$assigntype' !='ALLASSIGN'
					THEN
						Yard_No='$terminal' AND mfdch_value='$assigntype'
					ELSE
						Yard_No='$terminal'
				END)
				ORDER BY Yard_No,mfdch_value,flex_date01,line_no";
					
				$rsltNCTCCT=$this->bm->dataSelect($sqlNCTCCT);
				
				$this->data['date']=$date;
				$this->data['terminal']=$terminal;
				$this->data['rsltNCTCCT']=$rsltNCTCCT;

				$html=$this->load->view('cctnctReportAppraise',$this->data, true); 
					 
				$pdfFilePath ="cctnctReportAppraise.pdf";

				$pdf = $this->m_pdf->load();
				$pdf->SetWatermarkText('CPA CTMS');
				$pdf->showWatermarkText = true;	
				$pdf->setFooter('Developed By : DataSoft|Page {PAGENO} of {nb}|Date {DATE j-m-Y}');
				$stylesheet = file_get_contents('resources/styles/cctnct.css'); 
					
				$pdf->AddPage('P', // L - landscape, P - portrait
						'', '', '', '',
						10, // margin_left
						10, // margin right
						10, // margin top
						10, // margin bottom
						5, // margin header
						10); // margin footer
						
				$pdf->WriteHTML($stylesheet,1);
				$pdf->WriteHTML($html,2);
						 
				$pdf->Output($pdfFilePath, "I"); // For Show Pdf
			}
			
			else if($terminal=="GCB")
			{
				$this->load->library('m_pdf');
				$mpdf->use_kwt = true;
				
				$cond="";
				$date=$this->input->post('regdate');
				$block=$this->input->post('regblock');
				$assigntype=$this->input->post('regassigntype');
				
				if($assigntype!="ALLASSIGN")
				{
					$sql_assignment="SELECT DISTINCT mfdch_value,mfdch_desc 
								FROM ctmsmis.tmp_assignment_type_new 
								WHERE date(flex_date01)='$date' and Block_No='$block' AND mfdch_value='$assigntype'";
				}
				else
				{
					$sql_assignment="SELECT DISTINCT mfdch_value,mfdch_desc 
							FROM ctmsmis.tmp_assignment_type_new
							WHERE date(flex_date01)='$date' and Block_No='$block'";
				}
							
				$rslt_assignment=$this->bm->dataSelect($sql_assignment);
				
				$this->data['date']=$date;
				$this->data['block']=$block;
				$this->data['terminal']=$terminal;
			//	$this->data['assigntype']=$assigntype;
				
			//	$this->data['rslt_appraisement_register']=$rslt_appraisement_register;
				$this->data['rslt_assignment']=$rslt_assignment;

				$html=$this->load->view('gcbReportAppraise',$this->data, true); 
					 
				$pdfFilePath ="gcbReportAppraise.pdf";

				$pdf = $this->m_pdf->load();
				$pdf->SetWatermarkText('CPA CTMS');
				$pdf->showWatermarkText = true;	
				$pdf->setFooter('Developed By : DataSoft|Page {PAGENO} of {nb}|Date {DATE j-m-Y}');
				$stylesheet = file_get_contents('resources/styles/cctnct.css'); 
					
				$pdf->AddPage('P', // L - landscape, P - portrait
						'', '', '', '',
						10, // margin_left
						10, // margin right
						10, // margin top
						10, // margin bottom
						5, // margin header
						10); // margin footer
						
				$pdf->WriteHTML($stylesheet,1);
				$pdf->WriteHTML($html,2);
						 
				$pdf->Output($pdfFilePath, "I"); // For Show Pdf
			}
		}
	}
		//
//CONTAINER POSITION ENTRY START ////
	public function containerPositionEntryForm()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="CONTAINER POSITION ENTRY...";
				$data['msg']="";
				//echo $data['title'];
				$searchQry="select id,cont_number,rotation,cont_size,cont_height,cont_status,position,trailer_no from ctmsmis.container_move_position where solve_stat=0 order by id desc";
				$rtnSearchList = $this->bm->dataSelect($searchQry);
				$data['rtnSearchList']=$rtnSearchList;
				$this->load->view('header2');
				$this->load->view('containerPositionEntryForm',$data);
				$this->load->view('footer');
			}	
		}
		
	public function containerPositionToDB()
	{
		$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$ipaddr = $_SERVER['REMOTE_ADDR'];
				$login_id = $this->session->userdata('login_id');
				
				$cont_no = $this->input->post('cont_no');
				$cont_position = $this->input->post('cont_position');
				$cont_size_hd = $this->input->post('cont_size_hd');
				$cont_height_hd = $this->input->post('cont_height_hd');
				$cont_status_hd = $this->input->post('cont_status_hd');
				$cont_rotation_hd = $this->input->post('cont_rotation_hd');
				$trailer_no = $this->input->post('trailer_no');
				
				$insertQuery="insert into ctmsmis.container_move_position (cont_number,rotation,cont_size,cont_height,cont_status,
							position,entry_date,user,ip_address,trailer_no) 
							values ('$cont_no','$cont_rotation_hd','$cont_size_hd','$cont_height_hd','$cont_status_hd','$cont_position',now(),'$login_id','$ipaddr','$trailer_no')
							";
				$vesselStatusEntryStat=$this->bm->dataInsert($insertQuery);
				if($vesselStatusEntryStat==1)
				{
					$data['msg']="<font color='green'><b>Data Successfully Inserted.</b></font>";
					
					
				}
				else
				{
					$data['msg']="<font color='red'><b>Data Not Inserted.</b></font>";
				}
				$searchQry="select id,cont_number,rotation,cont_size,cont_height,cont_status,position,trailer_no from ctmsmis.container_move_position where solve_stat=0 order by id desc";
				$rtnSearchList = $this->bm->dataSelect($searchQry);
				$data['rtnSearchList']=$rtnSearchList;
				$data['title']="CONTAINER POSITION ENTRY...";
				$this->load->view('header2');
				$this->load->view('containerPositionEntryForm',$data);
				$this->load->view('footer');
			}
	}
	public function containerPositionDelete()
	{
		$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$ipaddr = $_SERVER['REMOTE_ADDR'];
				$login_id = $this->session->userdata('login_id');
				$cont_move_id = $this->input->post('cont_move_id');
				//echo "ID : ".$cont_move_id;
				$deleteQuery="delete from ctmsmis.container_move_position where id= $cont_move_id";
				$containerPositionDelStat=$this->bm->dataInsert($deleteQuery);
				if($containerPositionDelStat==1)
				{
					$data['msg']="<font color='green'><b>Position Successfully Deleted.</b></font>";
				}
				else
				{
					$data['msg']="<font color='red'><b>Position Not Deleted.</b></font>";
				}
				$searchQry="select id,cont_number,rotation,cont_size,cont_height,cont_status,position,trailer_no from ctmsmis.container_move_position where solve_stat=0 order by id desc";
				$rtnSearchList = $this->bm->dataSelect($searchQry);
				$data['rtnSearchList']=$rtnSearchList;
				$data['title']="CONTAINER POSITION ENTRY...";
				$this->load->view('header2');
				$this->load->view('containerPositionEntryForm',$data);
				$this->load->view('footer');
			}
		
	}
	//CONTAINER POSITION ENTRY END ////
	
	
	function rotationWiseContainerPosition()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
		else
			{
				$data['title']="Rotation Wise Container Position..";
				$data['msg']="";
				//echo $data['title'];
				$searchQry="select id,cont_number,rotation,cont_size,cont_height,cont_status,position,trailer_no from ctmsmis.container_move_position where solve_stat=0 order by id desc";
				$rtnSearchList = $this->bm->dataSelect($searchQry);
				$data['rtnSearchList']=$rtnSearchList;
				$this->load->view('header2');
				$this->load->view('rotationWiseContainerPosition',$data);
				$this->load->view('footer');
			}	
	}
	
	
	
	function rotationWiseContainerPositionView()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
		else
			{
				$rotNo=$this->input->post('rotNo');
				
				$data['title']="Rotation: $rotNo Container Position..";
				$data['msg']="";
				$searchQry="select id,cont_number,rotation,cont_size,cont_height,cont_status,position,trailer_no from ctmsmis.container_move_position where rotation='$rotNo' and solve_stat=0 order by id desc";
				$rtnSearchList = $this->bm->dataSelect($searchQry);
				$data['rtnSearchList']=$rtnSearchList;
				$this->load->view('header2');
				$this->load->view('rotationWiseContainerPosition',$data);
				$this->load->view('footer');
			}	
	}
	public function containerPositionSolveUpdate()
	{
		$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$ipaddr = $_SERVER['REMOTE_ADDR'];
				$login_id = $this->session->userdata('login_id');
				$cont_move_id = $this->input->post('cont_move_id');
				//echo "ID : ".$cont_move_id;
				$updateQuery="update ctmsmis.container_move_position set solve_stat=1 where id= $cont_move_id";
				$containerPositionUpdtStat=$this->bm->dataInsert($updateQuery);
				if($containerPositionUpdtStat==1)
				{
					$data['msg']="<font color='green'><b>Container Position Successfully Solved.</b></font>";
				}
				else
				{
					$data['msg']="<font color='red'><b>Container Position Not Solved.</b></font>";
				}
				$searchQry="select id,cont_number,rotation,cont_size,cont_height,cont_status,position,trailer_no from ctmsmis.container_move_position where solve_stat=0 order by id desc";
				$rtnSearchList = $this->bm->dataSelect($searchQry);
				$data['rtnSearchList']=$rtnSearchList;
				$data['title']="Rotation Wise Container Position..";
				$this->load->view('header2');
				$this->load->view('rotationWiseContainerPosition',$data);
				$this->load->view('footer');
			}
		
	}
	// Container Operation Report Start //
	public function containerOperationReportForm()
	{
		$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="CONTAINER OPERATION REPORT";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('containerOperationReportForm',$data);
				$this->load->view('footer');
			}	
	}
	public function containerOperationReportList()
	{
			$searchDt = $this->input->post('searchDt');
			$cont_position = $this->input->post('cont_position');
			$search_format = $this->input->post('options');
					
			if($search_format=="xl" or $search_format=="html")
			{				
				$data['searchDt']=$searchDt;
				$data['cont_position']=$cont_position;
				$data['title']="Container Operation Report";
				$this->load->view('containerOperationReportList',$data);
				$this->load->view('myclosebar');
			}
			else{
				//load mPDF library
				$this->load->library('m_pdf');
				$pdf->use_kwt = true;
				$this->data['searchDt']=$searchDt;
				$this->data['cont_position']=$cont_position;
				$this->data['title']="Container Operation Report";
				$html=$this->load->view('containerOperationReportList',$this->data, true);
				//this the the PDF filename that user will get to download
				$pdfFilePath ="containerOperationReportList-".time()."-download.pdf";
				$pdf = $this->m_pdf->load();
				$pdf->SetWatermarkText('CPA CTMS');
				$pdf->showWatermarkText = true;	
				$stylesheet = file_get_contents('resources/styles/test.css'); // external css
				$pdf->useSubstitutions = true; // optional - just as an example
				//$pdf->SetHeader($url . "\n\n" . 'Date {DATE j-m-Y}');  // optional - just as an example
				//echo "SheetAdd : ".$stylesheet;
				$pdf->setFooter('Developed By : DataSoft|Page {PAGENO} of {nb}|Date {DATE j-m-Y}');
				//$footerHtml='<pagefooter name="MyFooter1" content-left="{DATE j-m-Y}" content-center="{PAGENO}/{nbpg}" content-right="My document" footer-style="font-family: serif; font-size: 8pt; font-weight: bold; font-style: italic; color: #000000;" />';
				$pdf->WriteHTML($stylesheet,1);
				$pdf->WriteHTML($html,2);
				$pdf->Output($pdfFilePath, "I"); // For Show Pdf
					//load mPDF library
				
				}
	}
	// Container Operation Report End //
	// Container Operation YardLying START //	
		function containerOperationYardLyingList(){

			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{

				$this->load->view('containerOperationYardLyingList',$data);
				$this->load->view('myclosebar');
			}
        }
	// Container Operation YardLying END //
	
	//User edit or delete start
	function userList()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();	
		}
		else
		{
			
			$sql_user_num="select count(*) as rtnValue from users";
			
			$segment_three = $this->uri->segment(3);
			
			$config = array();
			$config["base_url"] = site_url("report/userList/$segment_three");
			
			$config["total_rows"] = $this->bm->dataReturnDb1($sql_user_num);
			$config["per_page"] = 20;
			$offset = $this->uri->segment(4, 0);
			$config["uri_segment"] = 4;
			$limit=$config["per_page"];
			
			$this->pagination->initialize($config);
			/* echo "ok";
			return; */
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			
			$start=$page;
			
			$sql_user_list="select *
			from users
			left join organization_profiles on organization_profiles.id=users.org_id limit $start,$limit";
			$rslt_user_list=$this->bm->dataSelectDb1($sql_user_list);
			$data['rslt_user_list']=$rslt_user_list;
			$data['start']=$start;
			$data["links"] = $this->pagination->create_links();
			
			$this->load->view('header2');
			$this->load->view('userList',$data);
			$this->load->view('footer');
		}
	}
	
	function searchUser()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();	
		}
		else
		{
			$search_by=$this->input->post('search_by');
		
			$login_id=$this->input->post('login_id_search');
			$org_type_id=$this->input->post('org_type_id');
			
			if($search_by=="login_id")
			{
				$sql_search="select *
				from users
				left join organization_profiles on organization_profiles.id=users.org_id 
				where login_id='$login_id'";
			}
			else if($search_by=="org_Type")
			{
				$sql_search="SELECT *
				FROM users
				WHERE Org_Type_id='$org_type_id'";
			}
			
			$rslt_user_list=$this->bm->dataSelectDb1($sql_search);
			$data['rslt_user_list']=$rslt_user_list;
			
			$this->load->view('header2');
			$this->load->view('userList',$data);
			$this->load->view('footer');
		}
	}
	
	function editUser()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();	
		}
		else
		{
			$login_id=$this->input->post('login_id_edit');
			
			$sql_user_data="select * from users where login_id='$login_id'";
			
			$rslt_user_data=$this->bm->dataSelectDb1($sql_user_data);
			
			$sql = "select id,Org_Type from tbl_org_types where id in(1,2,5,6,30,57)";
			$orgList = $this->bm->dataSelectDb1($sql);
			$data['orgList']=$orgList;
			$data['rslt_user_data']=$rslt_user_data;
			$data['creation']=0;
			$data['title']="User Modification Form...";
			$this->load->view('header2');
			$this->load->view('userCreationForm',$data);
			$this->load->view('footer');
		}
	}
	
	function deleteUser()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();	
		}
		else
		{
			$login_id=$this->input->post('login_id_delete');
			
			$sql_delete="DELETE FROM users WHERE login_id='$login_id'";
			
			$rslt_delete=$this->bm->dataDeleteDB1($sql_delete);
			
	//after deleting an entry load the page with pagination
			
			$sql_user_num="select count(*) as rtnValue from users";
			
			$segment_three = $this->uri->segment(3);
			
			$config = array();
			$config["base_url"] = site_url("report/userList/$segment_three");
			$config["total_rows"] = $this->bm->dataReturnDb1($sql_user_num);
			$config["per_page"] = 20;
			$offset = $this->uri->segment(4, 0);
			$config["uri_segment"] = 4;
			$limit=$config["per_page"];
			
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			$start=$page;
			
			$sql_user_list="select *
			from users
			left join organization_profiles on organization_profiles.id=users.org_id limit $start,$limit";
			
			$rslt_user_list=$this->bm->dataSelectDb1($sql_user_list);
			
			$data['rslt_user_list']=$rslt_user_list;
			$data['start']=$start;
			$data["links"] = $this->pagination->create_links();
			
			$msg="<font color='blue'><b>Successfully deleted login ID ".$login_id."</b></font>";
			$data['msg']=$msg;
			
			$this->load->view('header2');
			$this->load->view('userList',$data);
			$this->load->view('footer');
		}
	}
	//User edit or delete end
	
	// WORK DONE REPORT 24 HRS START
	
	function workDone24hrsForm()
		{
			$session_id = $this->session->userdata('value');
				if($session_id!=$this->session->userdata('session_id'))
				{
					$this->logout();
				}
				else
				{
					$data['title']="24 HRS. CONTAINER HANDLING FORM ...";
					$this->load->view('header2');
					$this->load->view('workDone24hrsForm',$data);
					$this->load->view('footer');
				}
		}
	function workDone24hrsList()
		{
			$session_id = $this->session->userdata('value');
				if($session_id!=$this->session->userdata('session_id'))
				{
					$this->logout();
				}
				else
				{
					$work_date=$this->input->post('work_date');
					$rotation_no=$this->input->post('rotation_no');
					$search_format = $this->input->post('options');
					
					if($search_format=="xl" or $search_format=="html")
					{
						$data['title']="24 HRS. CONTAINER HANDLING REPORT OF ".$work_date;
						$data['work_date']=$work_date;
						$data['rotation_no']=$rotation_no;
						
						$this->load->view('workDone24hrsList',$data);
					}
					else
					{
						//load mPDF library
						$this->load->library('m_pdf');
						$pdf->use_kwt = true;
						$this->data['title']="24 HRS. CONTAINER HANDLING REPORT OF ".$work_date;
						$this->data['work_date']=$work_date;
						$this->data['rotation_no']=$rotation_no;

						//$this->data['title']="Container Operation Report";
						$html=$this->load->view('workDone24hrsList',$this->data, true);
						//this the the PDF filename that user will get to download
						$pdfFilePath ="24_HRS_CONTAINER_HANDLING_RPT".time()."-download.pdf";
						$pdf = $this->m_pdf->load();
						$pdf->SetWatermarkText('CPA CTMS');
						$pdf->showWatermarkText = true;	
						$stylesheet = file_get_contents('resources/styles/test.css'); // external css
						$pdf->useSubstitutions = true; // optional - just as an example
						//$pdf->SetHeader($url . "\n\n" . 'Date {DATE j-m-Y}');  // optional - just as an example
						//echo "SheetAdd : ".$stylesheet;
						$pdf->setFooter('Developed By : DataSoft|Page {PAGENO} of {nb}|Date {DATE j-m-Y}');
						$pdf->AddPage('P', // L - landscape, P - portrait
						'', '', '', '',
						5, // margin_left
						5, // margin right
						5, // margin top
						5, // margin bottom
						5, // margin header
						5); // margin footer
						//$footerHtml='<pagefooter name="MyFooter1" content-left="{DATE j-m-Y}" content-center="{PAGENO}/{nbpg}" content-right="My document" footer-style="font-family: serif; font-size: 8pt; font-weight: bold; font-style: italic; color: #000000;" />';
						$pdf->WriteHTML($stylesheet,1);
						$pdf->WriteHTML($html,2);
						$pdf->Output($pdfFilePath, "I"); // For Show Pdf
					}
					
				}
		}
	// WORK DONE REPORT 24 HRS END
	
	//LAST 24 HOURS STUFFING CONTAINER LIST start
	function stuffingContainerListForm()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();	
		}
		else
		{
			$org_Type_id = $this->session->userdata('org_Type_id');
			
			if($org_Type_id==6 )		//for Offdock
			{
				$login_id = $this->session->userdata('login_id');
				
			//	$sql_time="SELECT HOUR(NOW()) AS ctime,TIMEDIFF(CONCAT(DATE(NOW()),' 10:00:00'),NOW()) AS diff";
				$sql_time="SELECT HOUR(NOW()) AS ctime,TIMEDIFF(CONCAT(DATE(NOW()),' 08:00:00'),NOW()) AS diff";
			
				$rslt_time=$this->bm->dataSelectDb1($sql_time);
					
				$data['ctime']=$rslt_time[0]['ctime'];
				$data['diff']=$rslt_time[0]['diff'];
				
				/* $lowerLimit=9;
				$upperLimit=10; */
				
				$lowerLimit=7;
				$upperLimit=8;
				
				$data['lowerLimit']=$lowerLimit;
				$data['upperLimit']=$upperLimit;
				
				$login_id = $this->session->userdata('login_id');

				$data['title']="STUFFING CONTAINER LIST...";
				$data['login_id']=$login_id;

				$this->load->view('header2');
				$this->load->view('stuffingContainerListOffdockWiseForm',$data);
				$this->load->view('footer');

				return;
			}
			else if($org_Type_id==1 or $org_Type_id==57)	//for MLO & Shipping Agent
			{
				$login_id = $this->session->userdata('login_id');
			
				$data['title']="STUFFING CONTAINER LIST...";
				$data['login_id']=$login_id;
				
				$this->load->view('header2');
				$this->load->view('stuffingContainerListMloWiseForm',$data);
				$this->load->view('footer');

				return;
			}
			else					//for CPA and Admin
			{
				$data['title']="STUFFING CONTAINER LIST...";
				$this->load->view('header2');
				$this->load->view('stuffingContainerListForm',$data);
				$this->load->view('footer');
			}
		}
	}
	
	function stuffingContainerListPerform()
	{
		
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();	
		}
		else
		{
			$org_Type_id = $this->session->userdata('org_Type_id');
			$this->load->library('m_pdf');
			$mpdf->use_kwt = true;
					
			$type=$this->input->post('option');
			$stuffing_date=$this->input->post('stuffing_date');
			$cont_no=$this->input->post('cont_no');
			$offdock=$this->input->post('offdock');
			$login_id_offdock=$this->input->post('login_id_offdock');
			$login_id_mlo=$this->input->post('login_id_mlo');
			
			if($stuffing_date!=null and $cont_no!=null)				//Date and container wise search from cpa and admin panel
			{
				$sql_stuffing_report="select *,last_update as submit_date 
				from ctmsmis.exp_stuffing_unit 
				inner join ctmsmis.offdoc on ctmsmis.offdoc.id=ctmsmis.exp_stuffing_unit.depo_code
				where stuffing_date='$stuffing_date' and cont_id='$cont_no'";
				
				$rslt_stuffing_report=$this->bm->dataSelect($sql_stuffing_report);
				
				//teus calculation start
				$row=count($rslt_stuffing_report);
				
				$t20=1;
				$t40=1;
				$size_20=0;
				$size_40=0;
				
				for($j=0;$j<$row;$j++)
				{
					if($rslt_stuffing_report[$j]['size']==20)
					{
						$size_20=$size_20+1;
					}
					else if($rslt_stuffing_report[$j]['size']==40)
					{
						$size_40=$size_40+1;
					}
				}
				
				$t20=$size_20*1;
				$t40=$size_40*2;
				//teus calculation end
				
				if($type=="html")
				{
					$data['rslt_stuffing_report']=$rslt_stuffing_report;
					$data['stuffing_date']=$stuffing_date;
					
					$data['t20']=$t20;
					$data['t40']=$t40;
					$data['size_20']=$size_20;
					$data['size_40']=$size_40;
				
					$this->load->view('stuffingContainerList',$data);
				}
				else if($type=="pdf")
				{	
					$this->data['rslt_stuffing_report']=$rslt_stuffing_report;
					$this->data['stuffing_date']=$stuffing_date;
					
					$this->data['t20']=$t20;
					$this->data['t40']=$t40;
					$this->data['size_20']=$size_20;
					$this->data['size_40']=$size_40;

					$html=$this->load->view('stuffingContainerListPDF',$this->data, true); 
						 
					$pdfFilePath ="stuffingContainerListPDF_date-".time()."-download.pdf";

					$pdf = $this->m_pdf->load();
					$pdf->SetWatermarkText('CPA CTMS');
					$pdf->showWatermarkText = true;	
				//	$stylesheet = file_get_contents('resources/styles/cctnct.css'); 
						
					$pdf->AddPage('P', // L - landscape, P - portrait
							'', '', '', '',
							10, // margin_left
							10, // margin right
							10, // margin top
							10, // margin bottom
							10, // margin header
							10); // margin footer
							
				//	$pdf->WriteHTML($stylesheet,1);
				$pdf->setFooter('Developed By : DataSoft|Page {PAGENO} of {nb}|Date {DATE j-m-Y}');
					$pdf->WriteHTML($html,2);
							 
					$pdf->Output($pdfFilePath, "I"); // For Show Pdf
				}
			}
			
			else if($stuffing_date!=null and $offdock!=null)			//Date and offdock wise search from cpa and admin panel
			{
				$sql_stuffing_report="select *,last_update as submit_date 
				from ctmsmis.exp_stuffing_unit 
				inner join ctmsmis.offdoc on ctmsmis.offdoc.id=ctmsmis.exp_stuffing_unit.depo_code
				where code='$offdock' and stuffing_date='$stuffing_date'";
				
				$rslt_stuffing_report=$this->bm->dataSelect($sql_stuffing_report);
				
				//teus calculation start
				$row=count($rslt_stuffing_report);
				
				$t20=1;
				$t40=1;
				$size_20=0;
				$size_40=0;
				
				for($j=0;$j<$row;$j++)
				{
					if($rslt_stuffing_report[$j]['size']==20)
					{
						$size_20=$size_20+1;
					}
					else if($rslt_stuffing_report[$j]['size']==40)
					{
						$size_40=$size_40+1;
					}
				}
				
				$t20=$size_20*1;
				$t40=$size_40*2;
				
				//teus calculation end
				
				if($type=="html")
				{
					$data['rslt_stuffing_report']=$rslt_stuffing_report;
					$data['offdock']=$offdock;
					
					$data['t20']=$t20;
					$data['t40']=$t40;
					$data['size_20']=$size_20;
					$data['size_40']=$size_40;
					
					$this->load->view('stuffingContainerList',$data);
				}
				else if($type=="pdf")
				{
					$this->data['rslt_stuffing_report']=$rslt_stuffing_report;
					$this->data['offdock']=$offdock;
					
					$this->data['t20']=$t20;
					$this->data['t40']=$t40;
					$this->data['size_20']=$size_20;
					$this->data['size_40']=$size_40;

					$html=$this->load->view('stuffingContainerListPDF',$this->data, true); 
						 
					$pdfFilePath ="stuffingContainerListPDF_offdock-".time()."-download.pdf";

					$pdf = $this->m_pdf->load();
					$pdf->SetWatermarkText('CPA CTMS');
					$pdf->showWatermarkText = true;	
				//	$stylesheet = file_get_contents('resources/styles/cctnct.css'); 
						
					$pdf->AddPage('P', // L - landscape, P - portrait
							'', '', '', '',
							10, // margin_left
							10, // margin right
							10, // margin top
							10, // margin bottom
							10, // margin header
							10); // margin footer
							
				//	$pdf->WriteHTML($stylesheet,1);
				$pdf->setFooter('Developed By : DataSoft|Page {PAGENO} of {nb}|Date {DATE j-m-Y}');
					$pdf->WriteHTML($html,2);
							 
					$pdf->Output($pdfFilePath, "I"); // For Show Pdf
				}
			} 
			
			else if($login_id_offdock!=null)			//Date wise search from offdock panel
			{
				$stuffing_date_offdock=$this->input->post('stuffing_date_offdock');
				$isOffdock=1;
				
				$depo_code=$this->Offdock($login_id_offdock);
				
				/* 
				//previous query with uploaded_by, modified to get result in case of data was uploaded by admin
				
				$sql_stuffing_report="select *,hour(now()) as hr 
				from ctmsmis.exp_stuffing_unit 
				inner join ctmsmis.offdoc on ctmsmis.offdoc.id=ctmsmis.exp_stuffing_unit.depo_code
				where uploaded_by='$login_id_offdock' and stuffing_date='$stuffing_date_offdock'"; */
				
				$sql_stuffing_report="select *,hour(now()) as hr 
				from ctmsmis.exp_stuffing_unit 
				inner join ctmsmis.offdoc on ctmsmis.offdoc.id=ctmsmis.exp_stuffing_unit.depo_code
				where depo_code='$depo_code' and stuffing_date='$stuffing_date_offdock'";
			
				$rslt_stuffing_report=$this->bm->dataSelect($sql_stuffing_report);
				
				//teus calculation start
				$row=count($rslt_stuffing_report);
				
				$t20=1;
				$t40=1;
				$size_20=0;
				$size_40=0;
				
				for($j=0;$j<$row;$j++)
				{
					if($rslt_stuffing_report[$j]['size']==20)
					{
						$size_20=$size_20+1;
					}
					else if($rslt_stuffing_report[$j]['size']==40)
					{
						$size_40=$size_40+1;
					}
				}
				
				$t20=$size_20*1;
				$t40=$size_40*2;
				
				//teus calculation end
					
				if($type=="html")
				{
				//	$sql_time="SELECT HOUR(NOW()) AS ctime,TIMEDIFF(CONCAT(DATE(NOW()),' 10:00:00'),NOW()) AS diff";
					$sql_time="SELECT HOUR(NOW()) AS ctime,TIMEDIFF(CONCAT(DATE(NOW()),' 08:00:00'),NOW()) AS diff";
			
					$rslt_time=$this->bm->dataSelectDb1($sql_time);
					
					$data['ctime']=$rslt_time[0]['ctime'];
					$data['diff']=$rslt_time[0]['diff'];
					
					/* $lowerLimit=9;
					$upperLimit=10; */
					
					$lowerLimit=7;
					$upperLimit=8;
					
					$data['lowerLimit']=$lowerLimit;
					$data['upperLimit']=$upperLimit;
					
					$data['rslt_stuffing_report']=$rslt_stuffing_report;
					$data['offdock']=$login_id_offdock;
					$data['isOffdock']=$isOffdock;
					
					$data['t20']=$t20;
					$data['t40']=$t40;
					$data['size_20']=$size_20;
					$data['size_40']=$size_40;
					
					$this->load->view('stuffingContainerList',$data);
				}
				else if($type=="pdf")
				{
					$this->data['rslt_stuffing_report']=$rslt_stuffing_report;
					$this->data['offdock']=$login_id_offdock;
					
					$this->data['t20']=$t20;
					$this->data['t40']=$t40;
					$this->data['size_20']=$size_20;
					$this->data['size_40']=$size_40;

					$html=$this->load->view('stuffingContainerListPDF',$this->data, true); 
						 
					$pdfFilePath ="stuffingContainerListPDF_offdock-".time()."-download.pdf";

					$pdf = $this->m_pdf->load();
					$pdf->SetWatermarkText('CPA CTMS');
					$pdf->showWatermarkText = true;	
				//	$stylesheet = file_get_contents('resources/styles/cctnct.css'); 
						
					/* $pdf->AddPage('P', // L - landscape, P - portrait
							'', '', '', '',
							10, // margin_left
							10, // margin right
							10, // margin top
							10, // margin bottom
							10, // margin header
							10); // margin footer */
							
				//	$pdf->WriteHTML($stylesheet,1);
				$pdf->setFooter('Developed By : DataSoft|Page {PAGENO} of {nb}|Date {DATE j-m-Y}');
					$pdf->WriteHTML($html,2);
							 
					$pdf->Output($pdfFilePath, "I"); // For Show Pdf
				}
			}
			
			else if($login_id_mlo!=null)					//MLO wise search from MLO panel
			{
				$stuffing_date_mlo=$this->input->post('stuffing_date_mlo');
				$search_by=$this->input->post('search_by');
				if($org_Type_id==57) // If Shipping Agent 
				{
					$ship_mlo=$this->input->post('ship_mlo');
					
					if($ship_mlo=="ALL")
					{
						$cond = "mlo_code in (SELECT r.id FROM sparcsn4.ref_bizunit_scoped r       
														LEFT JOIN ( sparcsn4.ref_agent_representation X       
														LEFT JOIN sparcsn4.ref_bizunit_scoped Y ON X.agent_gkey=Y.gkey )  ON r.gkey=X.bzu_gkey 
														WHERE Y.id = '$login_id_mlo')";
					}
					else
					{
						$cond = "mlo_code='$ship_mlo'";
					}
				}
				else // If MLO
				{
					$cond = "mlo_code='$login_id_mlo'";
				}
				
				if($offdock=="ALL")
				{
					$offDock_cond = "";
				}
				else{
					$offDock_cond = "and code='$offdock'";
				}
					
					if($search_by=="offdock")
					{
						$sql_stuffing_report="select * 
												from ctmsmis.exp_stuffing_unit 
												inner join ctmsmis.offdoc on ctmsmis.offdoc.id=ctmsmis.exp_stuffing_unit.depo_code
												where ".$cond." ".$offDock_cond." and stuffing_date='$stuffing_date_mlo'";
					}
					else if($search_by=="cont_no")
					{
						$sql_stuffing_report="select * 
												from ctmsmis.exp_stuffing_unit 
												inner join ctmsmis.offdoc on ctmsmis.offdoc.id=ctmsmis.exp_stuffing_unit.depo_code
												where ".$cond." and cont_id='$cont_no' and stuffing_date='$stuffing_date_mlo'";
					}
				
				//echo $cond;
				//echo "\br";
				//echo $sql_stuffing_report;
			
				$rslt_stuffing_report=$this->bm->dataSelect($sql_stuffing_report);
				
				//teus calculation start
				$row=count($rslt_stuffing_report);
				
				$t20=1;
				$t40=1;
				$size_20=0;
				$size_40=0;
				
				for($j=0;$j<$row;$j++)
				{
					if($rslt_stuffing_report[$j]['size']==20)
					{
						$size_20=$size_20+1;
					}
					else if($rslt_stuffing_report[$j]['size']==40)
					{
						$size_40=$size_40+1;
					}
				}
			
				$t20=$size_20*1;
				$t40=$size_40*2;
				
				//teus calculation end
				
				if($type=="html")
				{
					$data['rslt_stuffing_report']=$rslt_stuffing_report;
					$data['offdock']=$login_id_mlo;
					
					$data['t20']=$t20;
					$data['t40']=$t40;
					$data['size_20']=$size_20;
					$data['size_40']=$size_40;
					
					$this->load->view('stuffingContainerListMloWise',$data);
				}
				else if($type=="pdf")
				{
					$this->data['rslt_stuffing_report']=$rslt_stuffing_report;
					$this->data['offdock']=$login_id_mlo;
					
					$this->data['t20']=$t20;
					$this->data['t40']=$t40;
					$this->data['size_20']=$size_20;
					$this->data['size_40']=$size_40;

					$html=$this->load->view('stuffingContainerListMloWisePDF',$this->data, true); 
						 
					$pdfFilePath ="stuffingContainerListPDF_offdock-".time()."-download.pdf";

					$pdf = $this->m_pdf->load();
					$pdf->SetWatermarkText('CPA CTMS');
					$pdf->showWatermarkText = true;	
				//	$stylesheet = file_get_contents('resources/styles/cctnct.css'); 
						
					$pdf->AddPage('P', // L - landscape, P - portrait
							'', '', '', '',
							10, // margin_left
							10, // margin right
							10, // margin top
							10, // margin bottom
							10, // margin header
							10); // margin footer
							
				//	$pdf->WriteHTML($stylesheet,1);
				$pdf->setFooter('Developed By : DataSoft|Page {PAGENO} of {nb}|Date {DATE j-m-Y}');
					$pdf->WriteHTML($html,2);
							 
					$pdf->Output($pdfFilePath, "I"); // For Show Pdf
				}
			}
		}
	}
	
	function deleteOffdockEntry()				//only for html view, delete is not applicable in pdf
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();	
		}
		else
		{
			$login_id_offdock=$this->session->userdata('login_id');
			$isOffdock=1;
			$delete_cont=$this->input->post('delete_cont');
			$delete_stfdate=$this->input->post('delete_stfdate');
			
			$sql_delete_offdock="DELETE FROM ctmsmis.exp_stuffing_unit WHERE cont_id='$delete_cont' and stuffing_date='$delete_stfdate'";
			
			$rslt_delete_offdock=$this->bm->dataDelete($sql_delete_offdock);
			
			//after deleting an entry reload the full page with previous query
			
			$stuffing_date_offdock=$delete_stfdate;
			
			$depo_code=$this->Offdock($login_id_offdock);
				
			/* 
			//previous query with uploaded_by, modified to get result in case of data was uploaded by admin
			
			$sql_stuffing_report="select *,time(now()) as time 
			from ctmsmis.exp_stuffing_unit 
			inner join ctmsmis.offdoc on ctmsmis.offdoc.id=ctmsmis.exp_stuffing_unit.depo_code
			where uploaded_by='$login_id_offdock' and stuffing_date='$stuffing_date_offdock'"; */
			
			$sql_stuffing_report="select *,time(now()) as time 
			from ctmsmis.exp_stuffing_unit 
			inner join ctmsmis.offdoc on ctmsmis.offdoc.id=ctmsmis.exp_stuffing_unit.depo_code
			where depo_code='$depo_code' and stuffing_date='$stuffing_date_offdock'";
			
			$rslt_stuffing_report=$this->bm->dataSelect($sql_stuffing_report);
			
			//teus calculation start
			$row=count($rslt_stuffing_report);
				
			$t20=1;
			$t40=1;
			$size_20=0;
			$size_40=0;
				
			for($j=0;$j<$row;$j++)
			{
				if($rslt_stuffing_report[$j]['size']==20)
				{
					$size_20=$size_20+1;
				}
				else if($rslt_stuffing_report[$j]['size']==40)
				{
					$size_40=$size_40+1;
				}
			}
				
			$t20=$size_20*1;
			$t40=$size_40*2;
				
			//teus calculation end
			
		//	$sql_time="SELECT HOUR(NOW()) AS ctime,TIMEDIFF(CONCAT(DATE(NOW()),' 10:00:00'),NOW()) AS diff";
			$sql_time="SELECT HOUR(NOW()) AS ctime,TIMEDIFF(CONCAT(DATE(NOW()),' 08:00:00'),NOW()) AS diff";
			
			$rslt_time=$this->bm->dataSelectDb1($sql_time);
					
			$data['ctime']=$rslt_time[0]['ctime'];
			$data['diff']=$rslt_time[0]['diff'];
				
			/* $lowerLimit=9;
			$upperLimit=10; */
			
			$lowerLimit=7;
			$upperLimit=8;
				
			$data['lowerLimit']=$lowerLimit;
			$data['upperLimit']=$upperLimit;
			
			$data['rslt_stuffing_report']=$rslt_stuffing_report;
			$data['offdock']=$login_id_offdock;
			$data['isOffdock']=$isOffdock;
					
			$data['t20']=$t20;
			$data['t40']=$t40;
			$data['size_20']=$size_20;
			$data['size_40']=$size_40;
					
			$this->load->view('stuffingContainerList',$data);
		}
	}
	//LAST 24 HOURS STUFFING CONTAINER LIST end
	
	//LAST 24 HOURS STUFFING CONTAINER LIST for admin start
	
	function last24hrsOffDockStatementoforAdminForm()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['flag']=0;
				$data['title']="Last 24 hrs Offdock statement";
				$this->load->view('header2');
				$this->load->view('last24hrsOffDockStatementoforAdminForm',$data);
				$this->load->view('footer');
			}
		}
		
		
		function last24hrsOffDockStatementList()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$offdock_login_id=$this->input->post('offdock');
				$stuffing_date=$this->input->post('stuffing_date');
				
				$query="SELECT *  FROM ctmsmis.offdoc_statement WHERE date(last_update)='$stuffing_date' and update_by='$offdock_login_id'";
				//echo $query;
				//return;
				$offDock = $this->bm->dataSelect($query);
				$data['title']="Last 24 hrs Offdock statement";
				$data['offDock']=$offDock;
				$data['flag']=1;
				$this->load->view('header2');
				$this->load->view('last24hrsOffDockStatementoforAdminForm',$data);
				$this->load->view('footer');
			}
		}
		
			//LAST 24 HOURS STUFFING CONTAINER LIST for admin end
	
	//offDock Stuffing or statement permission form start
	function stuffingPermissionForm()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$timeQuery="Select date(now()) as rtnValue";
			$data["toDate"] = $this->bm->dataReturnDb1($timeQuery);
			$data['title']="Stuffing\Statement Permission Form";
			$this->load->view('header2');
			$this->load->view('stuffingPermissionFormHTML',$data);
			$this->load->view('footer');
		}
	}
		
	function stuffingPermissionPerform()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{  
			$ipaddr = $_SERVER['REMOTE_ADDR'];
			$offdock=$this->input->post('offdock');
			$stuffing_date=$this->input->post('stuffing_date');
			$time=$this->input->post('time');
			$login_id = $this->session->userdata('login_id');	
			$data['login_id']=$login_id;
			
			if($offdock=="all")
			{
				$sql_offdock_id="select id,name from ctmsmis.offdoc";
				
				$rslt_offdock_id=$this->bm->dataSelect($sql_offdock_id);
				
				for($i=0;$i<count($rslt_offdock_id);$i++)
				{
					$offdock=$rslt_offdock_id[$i]['id'];
					
					$find_query="SELECT offdock_code as rtnValue from ctmsmis.offdock_upload_permission WHERE offdock_code='$offdock' and date(last_update)=date(now())";
					$find_offdock=$this->bm->dataReturn($find_query);
						
					if($find_offdock=="")
					{
						$insertQuery="insert into ctmsmis.offdock_upload_permission(offdock_code,permit_date,permit_time,permit_by,last_update, ip_address) 
						values('$offdock','$stuffing_date','$time','$login_id',now(),'$ipaddr')";
					}
					else
					{
						$insertQuery="Update ctmsmis.offdock_upload_permission 
						set offdock_code='$offdock',permit_date='$stuffing_date',permit_time='$time',permit_by='$login_id',last_update=now(),ip_address='$ipaddr' 
						where offdock_code='$offdock' and date(last_update)=date(now())";
					}
					$stat=$this->bm->dataInsert($insertQuery);
				}
			}
			else
			{
				$find_query="SELECT offdock_code as rtnValue from ctmsmis.offdock_upload_permission WHERE offdock_code='$offdock' and date(last_update)=date(now())";
				$find_offdock=$this->bm->dataReturn($find_query);
					
				if($find_offdock=="")
				{
					$insertQuery="insert into ctmsmis.offdock_upload_permission(offdock_code,permit_date,permit_time,permit_by,last_update, ip_address) 
					values('$offdock','$stuffing_date','$time','$login_id',now(),'$ipaddr')";
				}
				else
				{
					$insertQuery="Update ctmsmis.offdock_upload_permission 
					set offdock_code='$offdock',permit_date='$stuffing_date',permit_time='$time',permit_by='$login_id',last_update=now(),ip_address='$ipaddr' 
					where offdock_code='$offdock' and date(last_update)=date(now())";
				}
				$stat=$this->bm->dataInsert($insertQuery);
			}
			
			if($stat==1)
			{
				$data['msg']="Permission is granted.";
			}
			else
			{	
				$data['msg']="Permission failed.";
			}
			
			$timeQuery="Select date(now()) as rtnValue";
			$data["toDate"] = $this->bm->dataReturnDb1($timeQuery);	
			
			$data['title']="Stuffing\Statement Permission Form";
			
			$this->load->view('header2');
			$this->load->view('stuffingPermissionFormHTML',$data);
			$this->load->view('footer');
		}
	}
	
		//Old function without facility to select all offdock from combo box. Remove comment if necessary or any error occurs in present function with same name.
		/* function stuffingPermissionPerform()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{  
				$ipaddr = $_SERVER['REMOTE_ADDR'];
				$offdock=$this->input->post('offdock');
				$stuffing_date=$this->input->post('stuffing_date');
				$time=$this->input->post('time');
				$login_id = $this->session->userdata('login_id');	
				$data['login_id']=$login_id;
				
				$find_query="SELECT offdock_code as rtnValue from ctmsmis.offdock_upload_permission WHERE offdock_code='$offdock' and date(last_update)=date(now())";
				$find_offdock=$this->bm->dataReturn($find_query);
				
				if($find_offdock=="")
				{
					$insertQuery="insert into ctmsmis.offdock_upload_permission(offdock_code, permit_date, permit_time, permit_by, last_update, ip_address ) 
					values ('$offdock', '$stuffing_date','$time', '$login_id', now(), '$ipaddr')";
					
				//echo $insertQuery;
				//return;	
				}
				else
				{
					$insertQuery="Update ctmsmis.offdock_upload_permission set offdock_code='$offdock', permit_date='$stuffing_date', permit_time='$time',
								permit_by='$login_id', last_update=now(), ip_address='$ipaddr' where offdock_code='$offdock' and date(last_update)=date(now())";
								
				}
				$stat=$this->bm->dataInsert($insertQuery);
				if($stat==1)
				{
					$data['msg']="Permission is granted.";
				}
				else
				{	
					$data['msg']="Permission failed.";
				}
				$timeQuery="Select date(now()) as rtnValue";
				$data["toDate"] = $this->bm->dataReturnDb1($timeQuery);				
				$data['title']="Stuffing\Statement Permission Form";
				$this->load->view('header2');
				$this->load->view('stuffingPermissionFormHTML',$data);
				$this->load->view('footer');
			}
		} */
		
	//offDock Stuffing or statement permission form end

	//Barcode TEST Start
	function barcodeTestForm()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$data['title']="Barcode Generation FORM";
			$this->load->view('header2');
			$this->load->view('barcodeTestForm',$data);
			$this->load->view('footer');
		}
	}
	
	function generateBarcodePage()
	{
		$container_no=$this->input->post('container_no');
		$container_no2=$this->input->post('container_no2');
		$truck_no=$this->input->post('truck_no');		
		$contCat=$this->input->post('contCat');
		$printType=$this->input->post('printType');
		
		$search_format = "html";
		
		// Log Write START
		$ipaddr = $_SERVER['REMOTE_ADDR'];
		$login_id = $this->session->userdata('login_id');		
		$printDate=date("Y-m-d H:i:s");
		$writeDocs="\r\n$container_no |$container_no2 |$truck_no |$printDate |$ipaddr |$login_id ";		
		$myFile = "barcodePrintLog.txt";
		write_file($myFile, $writeDocs, 'a');
		// Log Write END
		
		if($search_format=="xl" or $search_format=="html")
		{
			$data['title']=" ";
			$data['container_no']=$container_no;
			$data['truck_no']=$truck_no;
			$data['search_format']=$search_format;
			
			$data['container_no2']=$container_no2;
			$data['contCat']=$contCat;
			$data['printType']=$printType;
						
			$this->load->view('generateBarcodePage',$data);
		}
		else
		{
			//load mPDF library
			$this->load->library('m_pdf');
			$pdf->use_kwt = true;
			$this->data['title']="Barcode Test ";
			$this->data['container_no']=$container_no;
			$this->data['truck_no']=$truck_no;
			$this->data['search_format']=$search_format;
			$this->data['container_no2']=$container_no2;
			$this->data['contCat']=$contCat;
			$this->data['printType']=$printType;
			//$this->data['title']="Container Operation Report";
			$html=$this->load->view('generateBarcodePage',$this->data, true);
			//this the the PDF filename that user will get to download
			$pdfFilePath ="generateBarcodePage-".time()."-download.pdf";
			$pdf = $this->m_pdf->load();
			$pdf->SetWatermarkText('CPA CTMS');
			$pdf->showWatermarkText = true;	
			$stylesheet = file_get_contents('resources/styles/test.css'); // external css
			$scriptSheet = file_get_contents('resources/scripts/JsBarcode.all.min.js'); // external css
			$pdf->useSubstitutions = true; // optional - just as an example
			//$pdf->SetHeader($url . "\n\n" . 'Date {DATE j-m-Y}');  // optional - just as an example
			//echo "SheetAdd : ".$stylesheet;
			$pdf->setFooter('Developed By : DataSoft|Page {PAGENO} of {nb}|Date {DATE j-m-Y}');
			$pdf->AddPage('P', // L - landscape, P - portrait
			'', '', '', '',
			5, // margin_left
			5, // margin right
			5, // margin top
			5, // margin bottom
			5, // margin header
			5); // margin footer
			//$footerHtml='<pagefooter name="MyFooter1" content-left="{DATE j-m-Y}" content-center="{PAGENO}/{nbpg}" content-right="My document" footer-style="font-family: serif; font-size: 8pt; font-weight: bold; font-style: italic; color: #000000;" />';
			$pdf->WriteHTML($stylesheet,1);
			
			$pdf->WriteHTML($html,2);
			$pdf->WriteHTML($scriptSheet,3);
			$pdf->Output($pdfFilePath, "I"); // For Show Pdf	
		}

	}
	//Barcode TEST End
	// Export CONTAINER GATE IN  START
	
	function exportContainerGateInForm()
		{
			$session_id = $this->session->userdata('value');
				if($session_id!=$this->session->userdata('session_id'))
				{
					$this->logout();
				}
				else
				{
					$data['title']="EXPORT CONTAINER GATE IN FORM";
					$this->load->view('header2');
					$this->load->view('exportContainerGateInForm',$data);
					$this->load->view('footer');
				}
		}
	function exportContainerGateInList()
		{
			$session_id = $this->session->userdata('value');
				if($session_id!=$this->session->userdata('session_id'))
				{
					$this->logout();
				}
				else
				{
					$login_id_ship=$this->session->userdata('login_id');
					$rotation_no=$this->input->post('rotation_no');
					$search_format = $this->input->post('options');
					
					if($search_format=="xl" or $search_format=="html")
					{
						$data['title']="EXPORT CONTAINER GATE IN LIST FOR THE ROTATION ".$rotation_no;
						$data['rotation_no']=$rotation_no;
						$data['login_id_ship']=$login_id_ship;
						
						$this->load->view('exportContainerGateInList',$data);
					}
					else
					{
						//load mPDF library
						$this->load->library('m_pdf');
						$pdf->use_kwt = true;
						$this->data['title']="EXPORT CONTAINER GATE IN LIST FOR THE ROTATION ".$rotation_no;
						$this->data['rotation_no']=$rotation_no;
						$this->data['login_id_ship']=$login_id_ship;

						//$this->data['title']="Container Operation Report";
						$html=$this->load->view('exportContainerGateInList',$this->data, true);
						//this the the PDF filename that user will get to download
						$pdfFilePath ="workDone24hrsListRpt-".time()."-download.pdf";
						$pdf = $this->m_pdf->load();
						$pdf->SetWatermarkText('CPA CTMS');
						$pdf->showWatermarkText = true;	
						$stylesheet = file_get_contents('resources/styles/test.css'); // external css
						$pdf->useSubstitutions = true; // optional - just as an example
						//$pdf->SetHeader($url . "\n\n" . 'Date {DATE j-m-Y}');  // optional - just as an example
						//echo "SheetAdd : ".$stylesheet;
						$pdf->setFooter('Developed By : DataSoft|Page {PAGENO} of {nb}|Date {DATE j-m-Y}');
						$pdf->AddPage('P', // L - landscape, P - portrait
						'', '', '', '',
						5, // margin_left
						5, // margin right
						5, // margin top
						5, // margin bottom
						5, // margin header
						5); // margin footer
						//$footerHtml='<pagefooter name="MyFooter1" content-left="{DATE j-m-Y}" content-center="{PAGENO}/{nbpg}" content-right="My document" footer-style="font-family: serif; font-size: 8pt; font-weight: bold; font-style: italic; color: #000000;" />';
						$pdf->WriteHTML($stylesheet,1);
						$pdf->WriteHTML($html,2);
						$pdf->Output($pdfFilePath, "I"); // For Show Pdf
					}
					
				}
		}
	// Export CONTAINER GATE IN END
	function acceptStuffingList()
	{
		//$acceptChkVal=
		
		$countSelectedRow = count($this->input->post('acceptChk'));   // get selected value
		//echo $countSelectedRow."-- ".$this->input->post('acceptChk');
		$countTotalTblRow = count($this->input->post('stuffingKey')); // get all table row
		
		//echo $countSelectedRow."gg\n";
		$setval="";
		$data['msg']="";
		
		for($i=0;$i<$countTotalTblRow;$i++) {
			
			$strAcceptStuffingKeyQry="update ctmsmis.exp_stuffing_unit set accept_stuffing=0 where akey=".$this->input->post('stuffingKey')[$i];
			$acceptStuffingKeyStat=$this->bm->dataInsert($strAcceptStuffingKeyQry);
			$data['msg']="<font color='green'><b>Stuffing Data Accepted.</b></font>";
		}
		
		if( $this->input->post('acceptChk') != "") // IF Stuffing Container not Checked.
		{
			for($j=0;$j<$countSelectedRow;$j++) {			
				$strAcceptStuffingQry="update ctmsmis.exp_stuffing_unit set accept_stuffing=1 where akey=".$this->input->post('acceptChk')[$j];
				$acceptStuffingStat=$this->bm->dataInsert($strAcceptStuffingQry);
				if($acceptStuffingStat==1)
					{
						$data['msg']="<font color='green'><b>Stuffing Data Accepted.</b></font>";
					}
					else
					{
						$data['msg']="<font color='red'><b>Stuffing Data Not Accepted.</b></font>";
					}
				
			}
		}
		echo $data['msg'];
	}
	
	//edi convert start
	
	//View Converted Edi List
	function ConvertedEDISearch()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
			//$this->load->view('header');
			//$this->load->view('welcomeview_1', $data);
			//$this->load->view('footer');
		}
		else
		{
			$this->load->model('ci_auth', 'bm', TRUE);
				
			/*********** Pagination**************/
				
			$config = array();
			$config["base_url"] = site_url("report/viewEDIDetails/$exp_no");
			$config["total_rows"] = $this->bm->record_count_row('edi_master');
			$config["per_page"] = 5;
			$config["uri_segment"] = 3;
			
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			//echo $config["total_rows"] ;
			/***********Pagination***************/
				
			$ediDetails = $this->bm->myEdiDetail($config["per_page"], $page);
			$data["links"] = $this->pagination->create_links();	
			$data['ediDetails']=$ediDetails;
			$data['title']="CONVERTED EDI LIST...";
			$this->load->view('header2');
			$this->load->view('myEDIList',$data);
			$this->load->view('footer');
		}
	}
	
	//view EDI details................
	function viewEDIDetails()
	{
		//print_r($this->session->all_userdata());
		$session_id = $this->session->userdata('value');			
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$exp_no=$this->uri->segment(3);
			//echo $exp_no;
			$this->load->model('ci_auth', 'bm', TRUE);
			/*********** Pagination**************/
				
			$config = array();
			$config["base_url"] = site_url("report/viewEDIDetails/$exp_no");
			$config["total_rows"] = $this->bm->record_count_edi('edi_detail',$exp_no);
			$config["per_page"] = 5;
			$config["uri_segment"] = 4;
			
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			//echo $config["total_rows"] ;
			/***********Pagination***************/
				
			$ediDetails = $this->bm->viewEDIDetails($exp_no,$config["per_page"], $page); ///ai khane error khachche
			$data['ediDetails']=$ediDetails;
               
			$data['title']="EDI CONTAINER DETAILS...";
			$data["links"] = $this->pagination->create_links();
			$this->load->view('header2');
			$this->load->view('myviewEDIDetailsList',$data);
			$this->load->view('footer');
		}
	}
	
	//Search Edi List........................
	function myEDIListSearch()
	{
		//print_r($this->session->all_userdata());
		$session_id = $this->session->userdata('value');			
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$SearchCriteria=$this->input->post('SearchCriteria');
			$Searchdata=$this->input->post('Searchdata');
							
			$this->load->model('ci_auth', 'bm', TRUE);
			$ediDetails = $this->bm->myEDIListSearch($SearchCriteria, $Searchdata); ///ai khane error khachche
			$data['ediDetails']=$ediDetails;
               
			$data['title']="CONVERTED EDI LIST...";
			$data['type']=$type;
				
			$this->load->view('header2');
			$this->load->view('myEDIList',$data);
			$this->load->view('footer');
		}
	}
		
	//view berth details................
	function viewBerthDetails()
	{
		//print_r($this->session->all_userdata());
		$session_id = $this->session->userdata('value');			
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$exp_no=$this->uri->segment(3);
			//echo $exp_no;
			$this->load->model('ci_auth', 'bm', TRUE);
			$ediDetails = $this->bm->viewBerthDetails($exp_no); ///ai khane error khachche
			$data['ediDetails']=$ediDetails;
               
			$data['title']="VESSEL BERTH DETAILS...";
			$data['type']=$type;
				
			$this->load->view('header2');
			$this->load->view('myBerthDetailList',$data);
			$this->load->view('footer');
		}
	}
	
	//Awal EDI Mdule start	
	
		//Edi Search
		function EDISearch($msg){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				//$this->load->view('header');
				//$this->load->view('welcomeview_1', $data);
				//$this->load->view('footer');
			}
			else
			{
				$data['msg']=$msg;
				$data['title']="SEARCH BY EXPORT ROTATION...";
				$this->load->view('header2');
				$this->load->view('myEdiSearchHTML',$data);
				$this->load->view('footer');
			}
        }
		
		//Edi converter
		function EDIConverter($msg){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				//$this->load->view('header');
				//$this->load->view('welcomeview_1', $data);
				//$this->load->view('footer');
			}
			else
			{
			
				$exp_no1=$this->input->post('exp_no');
				$exp_no=str_replace("/","",$exp_no1);
				$this->load->model('ci_auth', 'bm', TRUE);
				list($berth,$vsl) = $this->bm->myEdiVslSearch($exp_no1); 
				$data['berth']=$berth;
				$data['vsl']=$vsl;
				
				$data['exp_no']=$exp_no;
				$data['exp_no1']=$exp_no1;
				$data['msg']=$msg;
				$data['title']="EDI CONVERT FROM EXCEL...";
				$this->load->view('header2');
				$this->load->view('myEdiConverterHTML',$data);
				$this->load->view('footer');
			}
        }
		
		//Edi Converter
		function EDIFileConverter(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			$login_id = $this->session->userdata('login_id');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				//$this->load->view('header');
				//$this->load->view('welcomeview_1', $data);
				//$this->load->view('footer');
			}
			else
			{
				$data['title']="EDI CONVERT FROM EXCEL...";
				
				$exp_no=$this->input->post('exp_no');
				
				error_reporting(E_ALL ^ E_NOTICE);			
				$exp_no1=str_replace("/","_",$exp_no);
				$filenm=$login_id."_".$exp_no1.".xls";
				$filetype=$_POST["filetype"];
				if ($_FILES["file"]["error"] > 0)
				{
				echo "Error: " . $_FILES["file"]["error"] . "<br />";
				return;
				}
				else
				move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/uploadfile/edi/".$_FILES["fileToUpload"]["name"]);
				
				rename($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/uploadfile/edi/".$_FILES["fileToUpload"]["name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/uploadfile/edi/".$filenm);
				
				require_once('excel_reader2.php');
				$data = new Spreadsheet_Excel_Reader($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/uploadfile/edi/".$filenm);
				$rtn=$this->Checkxcel($data,$login_id,$exp_no);
				
				if($rtn==2){
					$rtn=$this->excelWritetoEDI($data,$login_id,$exp_no);					
				}
				else
				{
					
					$this->load->view('header2');
					$this->load->view('myEdiConverterHTML',$data);
					$this->load->view('footer');
				}
			}
        }
		// Read excel file to check error
		function Checkxcel($mydata,$login_id,$exp_no){
			$agent=$mydata->value(3,2);
			$voy=$mydata->value(4,2);
			$callSign=$mydata->value(5,2);
			$vsl_name=$mydata->value(6,2);
			$date=$mydata->value(7,2);
			$LOP=$mydata->value(8,2);
			$nextPort=$mydata->value(9,2);
			
			if($agent==""){
				$data['msg']="Agent Can not be blank on cell B3...";
				$this->EDIConverter($data['msg']);
				return ;
			}else if($voy==""){
				$data['msg']="Voys Can not be blank on cell B4...";
				$this->EDIConverter($data['msg']);
				return ;
			}else if($callSign==""){
				$data['msg']="Call Sign can not be blank on cell B5...";
				$this->EDIConverter($data['msg']);
				return ;
			}else if($vsl_name==""){
				$data['msg']="Vessel Name can not be blank on cell B6...";
				$this->EDIConverter($data['msg']);
				return ;
			}else if($date==""){
				$data['msg']="Date can not be blank on cell B7...";
				$this->EDIConverter($data['msg']);
				return ;
			}else if($LOP==""){
				$data['msg']="Load Port can not be blank on cell B8...";
				$this->EDIConverter($data['msg']);
				return ;
			}else if($nextPort==""){
				$data['msg']="Next Port can not be blank on cell B9...";
				$this->EDIConverter($data['msg']);
				return ;
			}else{
			return 2;
			}
			
		}
		function excelWritetoEDI($mydata,$login_id,$exp_no){
			$agent=$mydata->value(3,2);
			$voy=$mydata->value(4,2);
			$callSign=$mydata->value(5,2);
			$vsl_name=$mydata->value(6,2);
			$date=$mydata->value(7,2);
			$date2=substr($date,2);
			$LOP=$mydata->value(8,2);
			$nextPort=$mydata->value(9,2);
			$presentTime=date("is");
			$j=0;
			//$todate=date("YmdHis");
			//$vsl=str_replace(" ","_",$vsl_name);
			$exp_no1=str_replace("/","",$exp_no);
			$rot=str_replace("/","",$exp_no);
			$file=$login_id."_".$exp_no1;
			$myFile=$file.'.edi';
			if(file_exists($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/uploadfile/xml/".$myFile)){
				unlink($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/uploadfile/xml/".$myFile);
			}
		  
			$fh= fopen($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/uploadfile/xml/".$myFile , 'a');
			$stringData ="UNB+UNOA:2+".$agent."+".$agent."+".$date2.":".$presentTime."+0+++++".$agent."'\n";
			fwrite($fh, $stringData);
			$j++;
            $stringData ="UNH+1+BAPLIE:D:95B:UN:SMDG20'\n";
			fwrite($fh, $stringData);
			$j++;
            $stringData ="BGM++0+9'\n";
			fwrite($fh, $stringData);
			$j++;
			$stringData ="DTM+137:" .$date.$presentTime.":201'\n";
			fwrite($fh, $stringData);
			$j++;
            $stringData ="TDT+20+".$voy. "+++".$agent.":172:20+++".$callSign.":103:ZZZ:".$vsl_name. "'\n";
			fwrite($fh, $stringData);
			$j++;
            $stringData ="LOC+5+" .$LOP. ":139:6'\n";
			fwrite($fh, $stringData);
			$j++;
            $stringData ="LOC+61+" .$nextPort. ":139:6'\n";
			fwrite($fh, $stringData);
			$j++;
			$stringData ="DTM+178:" .$date.$presentTime.":201'\n";
			fwrite($fh, $stringData);
			$j++;
			//insert into edi_master table in model
			$this->load->model('ci_auth', 'bm', TRUE);
			$ediMasterinsert = $this->bm->myEdiMasterInsert($agent,$voy, $callSign,$vsl_name,$date,$LOP,$nextPort,$login_id,$rot); 
			
			$totalrow=0;
			$excelrow=$mydata->rowcount(0);
			$i=12;

		   while($i<=$excelrow)
		   {
				if( $mydata->value($i,1)!="" )
				$totalrow=$totalrow+1;
			    $i=$i+1;
		   }
		   
		   $row=12;
		   
			while($row<($totalrow+12))
			{
				
				$container_no=$mydata->value($row,1);
				$iso=$mydata->value($row,2);
				$liner=$mydata->value($row,3);
				$status=$mydata->value($row,4);
				$weight=$mydata->value($row,5);
				$booking=$mydata->value($row,6);
				$seal=$mydata->value($row,7);
				$imdg=$mydata->value($row,8);
				$unno=$mydata->value($row,9);
				$temp=$mydata->value($row,10);
				$loadport=$mydata->value($row,11);
				$dischargeport=$mydata->value($row,12);
				$st=$mydata->value($row,13);
				
				$container_no=trim($container_no);
				$iso=trim($iso);
				$liner=trim($liner);
				$status=trim($status);
				$weight=trim($weight);
				$booking=trim($booking);
				$seal=trim($seal);
				$imdg=trim($imdg);
				$unno=trim($unno);
				$temp=trim($temp);
				$loadport=trim($loadport);
				$dischargeport=trim($dischargeport);
				$st=trim($st);
				
							
				
				
				$convertWeight=$weight*1000;
				/*$num_length = strlen((string)$convertWeight);
				if($num_length>7){
					$convertWeight=sprintf('%.2E',$convertWeight);
					$convertWeight=str_replace('+','',$convertWeight);
					
				}*/
				
				
				if(substr($status,0,1)=="F"){
					$cnt_status="5";
				}else{
					$cnt_status="4";
				}
				
				$stringData="LOC+147+" .$st. "::5'\n"; 
				fwrite($fh, $stringData);
				$j++;
                $stringData="MEA+WT++KGM:".$convertWeight. "'\n";
				fwrite($fh, $stringData);
				$j++;
				if($temp!=""){
					$stringData="TMP+2+".$temp.":CEL'\n";
					fwrite($fh, $stringData);
					$j++;					
				}
                $stringData="LOC+9+".$loadport. "'\n";
				fwrite($fh, $stringData);
				$j++;
				$stringData="LOC+11+" .$dischargeport. "'\n";
				fwrite($fh, $stringData);
				$j++;
				$stringData="LOC+83+".$dischargeport. "'\n";
				fwrite($fh, $stringData);
				$j++;
				$stringData="RFF+BM:1'\n"; 
				fwrite($fh, $stringData);
				$j++;
                $stringData="EQD+CN+".$container_no. "+".$iso. "+++".$cnt_status. "'\n";
				fwrite($fh, $stringData);
				$j++;				
				$stringData="NAD+CA+" .$liner. ":172:ZZZ'\n";
				fwrite($fh, $stringData);
				$j++;
				if(!($imdg=="" and $unno=="")){
                $stringData="DGS+IMD+".$imdg. "+".$unno. "+2'\n";
				fwrite($fh, $stringData);
				$j++;
				
				//echo $container_no;
				//$this->load->model('ci_auth', 'bm2', TRUE);
				//$ediMasterinsert = $this->bm->myEdiDetailInsert($container_no,$iso, $liner,$status,$weight,$booking,$seal,$imdg,$unno,$temp,$loadport,$dischargeport,$st,$login_id,$vsl_name,$rot); 
				
			
				}	
				$ediMasterinsert = $this->bm->myEdiDetailInsert($container_no,$iso, $liner,$status,$weight,$booking,$seal,$imdg,$unno,$temp,$loadport,$dischargeport,$st,$login_id,$vsl_name,$rot); 
				$row=$row+1;
			}
			$stringData="UNT+".$j."+1'\n";
			fwrite($fh, $stringData);
            $stringData="UNZ+1+0'";
			fwrite($fh, $stringData);
			fclose($fh);
			
			//$myFile="abcd.pdf";
			$ip = $this->input->ip_address();
			//echo $ip;
			//$converted_EDI="http://192.168.16.42/myportpaneltest/resources/edi/".$myFile;
			$converted_EDI='http://'.$_SERVER['SERVER_ADDR']."/myportpanel/resources/uploadfile/xml/".$myFile;
			$data['msg']="<a href=".$converted_EDI." target='_blank' download>Download EDI File for Vessel $vsl_name and Rotation $exp_no</a>";
			$data['exp_no']=$exp_no;
			//$this->EDIConverter($data['msg']);
			$this->EDISearch($data['msg']);
			//$this->load->view('header2');
			//$this->load->view('myEdiConverterHTML',$data);
			//$this->load->view('footer');
			//echo "<br>".$j;
		}
		
		//Awal EDI Mdule end
		
	//Search Edi Detail List........................
	function myEDIDetailSearch()
	{
		//print_r($this->session->all_userdata());
		$session_id = $this->session->userdata('value');			
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$SearchCriteria=$this->input->post('SearchCriteria');
			$Searchdata=$this->input->post('Searchdata');
							
			$this->load->model('ci_auth', 'bm', TRUE);
			$ediDetails = $this->bm->myEDIDetailSearch($SearchCriteria, $Searchdata); ///ai khane error khachche
			$data['ediDetails']=$ediDetails;
               
			$data['title']="CONVERTED EDI LIST...";
			$data['type']=$type;
				
			$this->load->view('header2');
			$this->load->view('myviewEDIDetailsList',$data);
			$this->load->view('footer');
		}
	}
		
	//edi convert end
	
		
	//Vessel Bill List start
	
	function vesselBillList()
	{
		$session_id = $this->session->userdata('value');			
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{	
			$login_id = $this->session->userdata('login_id');
			$data['title']="VESSEL BILL LIST...";
			
			$sql_row_num="select count(*) as rtnValue from ctmsmis.mis_vsl_billing_detail where agent_code='$login_id'";
			
			//echo $sql_row_num;
			$segment_three = $this->uri->segment(3);
			
			$config = array();
			$config["base_url"] = site_url("report/vesselBillList/$segment_three");
			$config["total_rows"] = $this->bm->dataReturn($sql_row_num);
			$config["per_page"] = 20;
			$offset = $this->uri->segment(4, 0);
			$config["uri_segment"] = 4;
			$limit=$config["per_page"];
			
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			$start=$page;
			$sql_bill_list = "";
			if($login_id=="devsh")
			{
				$sql_bill_list="select draftNumber,IFNULL(finalNumber,draftNumber) as finalNumber,rotation,vsl_name,bill_name,ata,atd,berth,agent_code,agent_name,flag,cnt_code,bill_type from
				ctmsmis.mis_vsl_billing_detail order by draftNumber DESC limit $start,$limit";
			}
			else{
				$sql_bill_list="select draftNumber,IFNULL(finalNumber,draftNumber) as finalNumber,rotation,vsl_name,bill_name,ata,atd,berth,agent_code,agent_name,flag,cnt_code,bill_type from
				ctmsmis.mis_vsl_billing_detail where agent_code='$login_id' order by draftNumber DESC limit $start,$limit";
			}
			$rslt_bill_list=$this->bm->dataSelect($sql_bill_list);
			
			$data['rslt_bill_list']=$rslt_bill_list;
			$data['start']=$start;
			$data["links"] = $this->pagination->create_links();
			
			$this->load->view('header5');
			$this->load->view('vesselBillList',$data);
			$this->load->view('footer_1');
			}
		}
	
	function searchBill()
	{
		$session_id = $this->session->userdata('value');			
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$login_id = $this->session->userdata('login_id');
			$data['title']="VESSEL BILL LIST...";
			
			$rotation=trim($this->input->post('rotation'));
			$sql_search_bill="";
			if($login_id=="devsh")
			{
				$sql_search_bill="select draftNumber,IFNULL(finalNumber,draftNumber) as finalNumber,rotation,vsl_name,bill_name,ata,atd,berth,agent_code,agent_name,flag,cnt_code,bill_type 
				from ctmsmis.mis_vsl_billing_detail where rotation='$rotation'";
			}
			else{
				$sql_search_bill="select draftNumber,IFNULL(finalNumber,draftNumber) as finalNumber,rotation,vsl_name,bill_name,ata,atd,berth,agent_code,agent_name,flag,cnt_code,bill_type 
				from ctmsmis.mis_vsl_billing_detail where rotation='$rotation' and agent_code='$login_id'";
			}
			
			$rslt_bill_list=$this->bm->dataSelect($sql_search_bill);
			
			$data['rslt_bill_list']=$rslt_bill_list; 
			$this->load->view('header5');
			$this->load->view('vesselBillList',$data);
			$this->load->view('footer_1');
			
		}
	}
	
	function viewBill()
	{
		$session_id = $this->session->userdata('value');			
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$draftNumber=$this->uri->segment(3);	
			$cnt_code=$this->uri->segment(4);	
			$bill_type=$this->uri->segment(5);				
			$this->load->library('m_pdf');
			$pdf->use_kwt = true;
			//echo $draftNumber."".$bill_type."".$cnt_code;
			//return;
			if($bill_type==101)
			{
				if($cnt_code=='PBD')
				{
					$bill_sql="select invoiceDesc,draftNumber,vesselName,ibVoyageNbr,captain,date(ATD) as ATD,date(ATA) as ATA,customerName,payeecustomerkey,agent_address,grossRevenueTons,
								exchangeRate,date(created) as created,berth,flagcountry,cargo,ffd,description,glcode,rateBilled,quantityUnit,sum(quantityBilled) as quantityBilled,
								creator,sum(totbsd) as totbsd,status
								from(
								select bill_name as invoiceDesc,ifnull(finalNumber,if(cnt_code='BD' or cnt_code='PBD',
								concat('JL/',mis_vsl_billing_detail.draftNumber,'-',substr(billing_date,4,1)),
								concat('JF/',mis_vsl_billing_detail.draftNumber,'-',substr(billing_date,4,1)))) as draftNumber,
								vsl_name as vesselName,rotation as ibVoyageNbr,master_name as captain,atd as ATD,ata as ATA,agent_name as customerName,
								concat(agent_code,'(',ifnull(agent_alias_id,''),')') as payeecustomerkey,agent_address,grt as grossRevenueTons,exchangeRate as exchangeRate,
								date(billing_date) as created,berth as berth,flag as flagcountry,deck_cargo as cargo,date(oa_date) as ffd,
								description as description,if(description like 'PCT HARBOUR CRANE%','5000',concat(gl_code,'0')) as glcode,rate as rateBilled,bas as quantityUnit,
								IF(description LIKE 'BERTH_HIRE_1%',mis_vsl_billing_detail.unit,mis_vsl_billing_sub_detail.unit_for_pilot) as quantityBilled,
								if(finalNumber is null,creator,drft_update_by) as creator,
								if(description LIKE 'BERTH_HIRE_1%',(rate*unit),(rate*mis_vsl_billing_sub_detail.unit_for_pilot*exchangeRate)) as totbsd, 'DRAFT' as status
								from ctmsmis.mis_vsl_billing_detail
								inner join ctmsmis.mis_vsl_billing_sub_detail on mis_vsl_billing_sub_detail.draftNumber=mis_vsl_billing_detail.draftNumber 
								where mis_vsl_billing_detail.draftNumber='$draftNumber' and bill_type=101 order by draftNumber,description) as tbl group by description";
								
					$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";			
				}
				else
				{
					// $bill_sql="select bill_name as invoiceDesc,if(cnt_code='BD',concat('JL/',mis_vsl_billing_detail.draftNumber,'-',substring(billing_date,4,1)),
								// concat('JF/',mis_vsl_billing_detail.draftNumber,'-',substring(billing_date,4,1))) as draftNumber,
								// vsl_name as vesselName,rotation as ibVoyageNbr,master_name as captain,atd as ATD,ata as ATA,agent_name as customerName,
								// concat(agent_code,'(',ifnull(agent_alias_id,''),')') as payeecustomerkey,agent_address,grt as grossRevenueTons,
								// exchangeRate as exchangeRate,date(billing_date) as created,berth as berth,flag as flagcountry,deck_cargo as cargo,date(oa_date) as ffd,
								// description as description,gl_code as glcode,rate as rateBilled,bas as quantityUnit,
								// IF(description LIKE 'BERTH_HIRE_1%',mis_vsl_billing_detail.unit,mis_vsl_billing_sub_detail.unit_for_pilot) as quantityBilled,
								// if(description LIKE 'BERTH_HIRE_1%',((grt+ifnull(deck_cargo,0))*rate*unit),(rate*mis_vsl_billing_sub_detail.unit_for_pilot)) as totusd,
								// creator,if(description LIKE 'BERTH_HIRE_1%',((grt+ifnull(deck_cargo,0))*rate*unit*exchangeRate),
								// (rate*mis_vsl_billing_sub_detail.unit_for_pilot*exchangeRate)) as totbsd,  
								// 'DRAFT' as status from ctmsmis.mis_vsl_billing_detail
								// inner join ctmsmis.mis_vsl_billing_sub_detail on ctmsmis.mis_vsl_billing_sub_detail.draftNumber=ctmsmis.mis_vsl_billing_detail.draftNumber 
								// where ctmsmis.mis_vsl_billing_detail.draftNumber='$draftNumber' and bill_type=101 order by draftNumber,description";
								
					$bill_sql="select invoiceDesc,draftNumber,vesselName,ibVoyageNbr,captain,ATD,ATA,customerName,payeecustomerkey,agent_address,grossRevenueTons,
								exchangeRate,created,berth,flagcountry,cargo,ffd,description,glcode,rateBilled,quantityUnit,sum(quantityBilled) as quantityBilled,
								creator,round(sum(totusd),4) as totusd,round(sum(totbsd),2) as totbsd,round(sum(vatbd),2) as vatbd,status
								from(
								select bill_name as invoiceDesc,if(cnt_code='BD',concat('JL/',mis_vsl_billing_detail.draftNumber,'-',substring(billing_date,4,1)),concat('JF/',mis_vsl_billing_detail.draftNumber,'-',substring(billing_date,4,1))) as draftNumber,vsl_name as vesselName,rotation as ibVoyageNbr,master_name as captain,atd as ATD,ata as ATA,agent_name as customerName,concat(agent_code,'(',ifnull(agent_alias_id,''),')') as payeecustomerkey,agent_address,grt as grossRevenueTons,exchangeRate as exchangeRate,billing_date as created,berth as berth,flag as flagcountry,deck_cargo as cargo,oa_date as ffd,description as description,gl_code as glcode,rate as rateBilled,bas as quantityUnit,
								IF(description LIKE 'BERTH_HIRE_1%',mis_vsl_billing_detail.unit,mis_vsl_billing_sub_detail.unit_for_pilot) as quantityBilled,if(description LIKE 'BERTH_HIRE_1%',((grt+ifnull(deck_cargo,0))*rate*unit),(rate*mis_vsl_billing_sub_detail.unit_for_pilot)) as totusd,creator,
								if(description LIKE 'BERTH_HIRE_1%',((grt+ifnull(deck_cargo,0))*rate*unit*exchangeRate),(rate*mis_vsl_billing_sub_detail.unit_for_pilot*exchangeRate)) as totbsd,(select if(date(ata)>='2017-12-27',(totbsd*15)/100,'0')) as vatbd,'DRAFT' as status from ctmsmis.mis_vsl_billing_detail
								inner join ctmsmis.mis_vsl_billing_sub_detail on ctmsmis.mis_vsl_billing_sub_detail.draftNumber=ctmsmis.mis_vsl_billing_detail.draftNumber where ctmsmis.mis_vsl_billing_detail.draftNumber='$draftNumber' and bill_type=101 order by draftNumber,description) as tbl group by description";
								
					$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";			

				}
			}
			else if($bill_type==102)
			{
				if($cnt_code=='PBD')
				{
					$bill_sql="select invoiceDesc,draftNumber,vesselName,ibVoyageNbr,captain,ATD,ATA,customerName,payeecustomerkey,agent_address,
					grossRevenueTons,exchangeRate,created,flagcountry,cargo,ffd,onboundpiloton,onboundpilotoff,inboundpiloton,inboundpilotoff,description,
					glcode,rateBilled,quantityUnit,quantityBilled,sum(move) as move,sum(bdChraged) as bdChraged,
					if((description='BERTHING' or description='SHIFT VESSEL BERTH'),((bdChraged*15)/100),0) as bdVat,status,
					creator from 
					(
					select bill_name as invoiceDesc,ifnull(finalNumber,if(cnt_code='BD' or cnt_code='PBD',
					concat('PL/',mis_vsl_billing_detail.draftNumber,'-',substr(billing_date,4,1)),concat('PF/',mis_vsl_billing_detail.draftNumber,'-',substr(billing_date,4,1)))) as draftNumber,
					vsl_name as vesselName,rotation as ibVoyageNbr,master_name as captain,date(atd) as ATD,date(ata) as ATA,agent_name as customerName,concat(agent_code,'(',ifnull(agent_alias_id,''),')') as payeecustomerkey,
					agent_address,grt as grossRevenueTons,exchangeRate as exchangeRate,billing_date as created,flag as flagcountry,deck_cargo as cargo,date(oa_date) as ffd, DATE_FORMAT(pilot_ob_onboard,'%H:%i') as onboundpiloton,
					DATE_FORMAT(pilot_ob_offboard,'%H:%i') as onboundpilotoff,
					DATE_FORMAT(pilot_ib_onboard,'%H:%i') as inboundpiloton, DATE_FORMAT(pilot_ib_offboard,'%H:%i')  as inboundpilotoff,if(description='Port Dues for Sea-going Vessel',
					substr(description,1,9),description) as description,concat(gl_code,'0') as glcode,rate as rateBilled,bas as quantityUnit,unit_for_pilot as quantityBilled,move,(rate*unit_for_pilot*move*exchangeRate) as bdChraged,
					'DRAFT' as status,if(finalNumber is null,creator,drft_update_by) as creator
					from ctmsmis.mis_vsl_billing_detail inner join ctmsmis.mis_vsl_billing_sub_detail on ctmsmis.mis_vsl_billing_sub_detail.draftNumber=ctmsmis.mis_vsl_billing_detail.draftNumber 
					where mis_vsl_billing_detail.draftNumber='$draftNumber' 
					and bill_type=102 and description not like '%BIWTA%') as tbl group by description";
					$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";			
			
				}
				else
				{
					// $bill_sql="select invoiceDesc,draftNumber,vesselName,ibVoyageNbr,captain,ATD,ATA,customerName,payeecustomerkey,agent_address,grossRevenueTons,
								// exchangeRate,created,flagcountry,cargo,ffd,DATE_FORMAT(onboundpiloton,'%H:%i')as onboundpiloton,DATE_FORMAT(onboundpilotoff,'%H:%i')as  onboundpilotoff,
								// DATE_FORMAT(inboundpiloton,'%H:%i') as inboundpiloton,DATE_FORMAT(inboundpilotoff,'%H:%i') as inboundpilotoff,description,glcode,rateBilled,quantityUnit,
								// if(description like 'Tug%',sum(quantityBilled),quantityBilled) as quantityBilled,if(description='PILOTAGE FEE',sum(move),move) as move,sum(totusd) as totusd,
								// sum(bdChraged) as bdChraged,if((description='BERTHING' or description='SHIFT VESSEL BERTH'),((totusd*15)/100),0) as vatusd, 
								// (select vatusd*exchangeRate) as bdVat,status,creator from (
								// select bill_name as invoiceDesc,if(cnt_code='BD',concat('PL/',mis_vsl_billing_detail.draftNumber,'-',substring(billing_date,4,1)),
								// concat('PF/',mis_vsl_billing_detail.draftNumber,'-',substring(billing_date,4,1))) as draftNumber,vsl_name as vesselName,
								// rotation as ibVoyageNbr,master_name as captain,date(atd) as ATD,date(ata) as ATA,agent_name as customerName,
								// concat(agent_code,'(',ifnull(agent_alias_id,''),')') as payeecustomerkey,agent_address,grt as grossRevenueTons,exchangeRate as exchangeRate,
								// date(billing_date) as created,flag as flagcountry,deck_cargo as cargo,oa_date as ffd,pilot_ob_onboard as onboundpiloton,pilot_ob_offboard as onboundpilotoff,
								// pilot_ib_onboard as inboundpiloton,pilot_ib_offboard as inboundpilotoff,description as description,concat(gl_code,'0') as glcode,
								// rate as rateBilled,bas as quantityUnit,
								// unit_for_pilot as quantityBilled,move,(rate*unit_for_pilot*move) as totusd,
								// (rate*unit_for_pilot*move*exchangeRate) as bdChraged,
								// 'DRAFT' as status,creator
								// from ctmsmis.mis_vsl_billing_detail inner join ctmsmis.mis_vsl_billing_sub_detail on ctmsmis.mis_vsl_billing_sub_detail.draftNumber=ctmsmis.mis_vsl_billing_detail.draftNumber 
								// where ctmsmis.mis_vsl_billing_detail.draftNumber='$draftNumber'  and bill_type=102) as tbl group by description";
								
					$bill_sql="select invoiceDesc,draftNumber,vesselName,ibVoyageNbr,captain,ATD,ATA,customerName,payeecustomerkey,agent_address,grossRevenueTons,exchangeRate,created,flagcountry,cargo,ffd,onboundpiloton,onboundpilotoff,inboundpiloton,inboundpilotoff,description,glcode,rateBilled,quantityUnit,if(description like 'Tug%' or description='Additional Tug Charge for Unberthing',sum(quantityBilled),quantityBilled) as quantityBilled,if(description ='PILOTAGE FEE' or description ='Night Navigation Fee' or description like 'SHIFT%',sum(move),move) as move,round(sum(totusd),4) as totusd,round(sum(bdChraged),2) as bdChraged,
					round(sum(vatusd),4) as vatusd,
					round((sum(bdChraged)*15/100),2) as bdVat,status,creator 
					from (
					select bill_name as invoiceDesc,if(cnt_code='BD',concat('PL/',mis_vsl_billing_detail.draftNumber,'-',substring(billing_date,4,1)),concat('PF/',mis_vsl_billing_detail.draftNumber,'-',substring(billing_date,4,1))) as draftNumber,vsl_name as vesselName,rotation as ibVoyageNbr,master_name as captain,atd as ATD,ata as ATA,agent_name as customerName,concat(agent_code,'(',ifnull(agent_alias_id,''),')') as payeecustomerkey,agent_address,grt as grossRevenueTons,exchangeRate as exchangeRate,billing_date as created,flag as flagcountry,deck_cargo as cargo,oa_date as ffd,pilot_ob_onboard as onboundpiloton,pilot_ob_offboard as onboundpilotoff,
					pilot_ib_onboard as inboundpiloton,pilot_ib_offboard as inboundpilotoff,description as description,concat(gl_code,'0') as glcode,rate as rateBilled,bas as quantityUnit,
					unit_for_pilot as quantityBilled,move,(rate*unit_for_pilot*move) as totusd,
					(rate*unit_for_pilot*move*exchangeRate) as bdChraged,
					'DRAFT' as status,creator,if(date(ata)>='2017-12-27',1,0) as vtdt,
					(select if(vtdt=1,((totusd*15)/100),if((description='BERTHING' or description='SHIFT VESSEL BERTH'),((totusd*15)/100),0)))  as vatusd
					from ctmsmis.mis_vsl_billing_detail inner join ctmsmis.mis_vsl_billing_sub_detail on ctmsmis.mis_vsl_billing_sub_detail.draftNumber=ctmsmis.mis_vsl_billing_detail.draftNumber where ctmsmis.mis_vsl_billing_detail.draftNumber='$draftNumber'  and bill_type=102) as tbl group by description";
					
					$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";			

					//echo $bill_sql;
					//return;
				}
			}
			else if($bill_type==103)
			{
				//rptJettyChargeDraftInvoice
				
				$bill_sql="select 'DRAFT' as status,bill_name as invoiceDesc,if(cnt_code='BD',concat('JL/',mis_vsl_billing_detail.draftNumber,'-5'),
					concat('JF/',mis_vsl_billing_detail.draftNumber,'-5')) as draftNumber,vsl_name as ibCarrierName,rotation as ibVisitId,
					master_name as captain,DATE_FORMAT(atd,'%Y-%m-%d %H:%i')as ibCarrierATD,DATE_FORMAT(ata,'%Y-%m-%d %H:%i') as ibCarrierATA,agent_name as customerName,
					concat(agent_code,'(',ifnull(agent_alias_id,''),')') as payeecustomerkey, agent_address, grt as grt,exchangeRate as exchangeRate,
					date(billing_date) as created,berth as berth,flag as flagcountry,ifnull(deck_cargo,0) as cargo,date(oa_date) as ffd,description as description,
					gl_code as glcode,rate as rateBilled,bas as bas,unit_for_pilot as quantityBilled,(rate*unit_for_pilot)as totusd,
					(rate*unit_for_pilot*exchangeRate)as totbsd,creator, now() as printTime from
					ctmsmis.mis_vsl_billing_detail inner join ctmsmis.mis_vsl_billing_sub_detail on
					ctmsmis.mis_vsl_billing_sub_detail.draftNumber=ctmsmis.mis_vsl_billing_detail.draftNumber 
					where ctmsmis.mis_vsl_billing_detail.draftNumber='$draftNumber' and bill_type=103 and unit_for_pilot>0 
					order by substring(description,9,3) desc,substring(description,13,2) asc";
					
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";			
	
			}
			else if($bill_type==104)
			{
				//rptJettyMiscChargeDraftInvoice
				$bill_sql="select 'DRAFT' as status,bill_name as invoiceDesc,if(cnt_code='BD',concat('JL/',mis_vsl_billing_detail.draftNumber,'-5'),
					concat('JF/',mis_vsl_billing_detail.draftNumber,'-5')) as draftNumber,vsl_name as ibCarrierName,rotation as ibVisitId,master_name as captain,
					DATE_FORMAT(atd,'%Y-%m-%d %H:%i') as ibCarrierATD,DATE_FORMAT(ata,'%Y-%m-%d %H:%i') as ibCarrierATA,agent_name as customerName,agent_code as payeecustomerkey,grt as grt,exchangeRate as exchangeRate,
					date(billing_date) as created,berth as berth,flag as flagcountry,ifnull(deck_cargo,0) as cargo,oa_date as ffd,description as description,gl_code as glcode,
					rate as rateBilled,bas as bas,unit_for_pilot as quantityBilled,(rate*unit_for_pilot)as totusd,(rate*unit_for_pilot*exchangeRate)as totbsd,creator from
                    ctmsmis.mis_vsl_billing_detail inner join ctmsmis.mis_vsl_billing_sub_detail on ctmsmis.mis_vsl_billing_sub_detail.draftNumber=ctmsmis.mis_vsl_billing_detail.draftNumber 
					where ctmsmis.mis_vsl_billing_detail.draftNumber='$draftNumber' and bill_type=104";
					
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";			
	
			}
			
		
	
			
			//echo $bill_sql;
			//return;
			$bill_rslt=$this->bm->dataSelect($bill_sql);	
			$print_time=$this->bm->dataSelect($bill_print_time);	
			$this->data['bill_rslt']=$bill_rslt;			
			$this->data['print_time']=$print_time;			
			//$this->load->view('vesselBillPdf',$data);
			if($bill_type==101)
			{
				if($cnt_code=='PBD')
				{
					$html=$this->load->view('rptJettyOccupancyDraftInvoicePan_vslBill.php',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
					$pdfFilePath ="VesselBill-".time()."-download.pdf";
					//echo $bill_rslt[0]['printTime'];
					//return;
					
				}
				else
				{
					$html=$this->load->view('rptJettyOccupancyDraftInvoice',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
					$pdfFilePath ="VesselBill-".time()."-download.pdf";
				}
			}
			else if($bill_type==102)
			{
				if($cnt_code=='PBD')
				{
					$html=$this->load->view('rptNonJettyDraftInvoicePan',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
					$pdfFilePath ="VesselBill-".time()."-download.pdf";
				}
				else
				{
					$html=$this->load->view('rptNonJettyDraftInvoice',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
					$pdfFilePath ="VesselBill-".time()."-download.pdf";
				}
			}
			else if($bill_type==103)
			{
				$html=$this->load->view('rptJettyChargeDraftInvoice.php',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
				$pdfFilePath ="VesselBill-".time()."-download.pdf";
			}
			else if($bill_type==104)
			{	
				$html=$this->load->view('rptJettyMiscChargeDraftInvoice.php',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
				$pdfFilePath ="VesselBill-".time()."-download.pdf";	
			}
			//actually, you can pass mPDF parameter on this load() function
			$pdf = $this->m_pdf->load();
			$pdf->SetWatermarkText('CPA CTMS');
			$pdf->showWatermarkText = true;	
			//$stylesheet = file_get_contents('resources/styles/test.css'); // external css
			$pdf->useSubstitutions = true; // optional - just as an example

			$pdf->setFooter('||Page {PAGENO} of {nb}');
			$pdf->WriteHTML($stylesheet,1);
			$pdf->WriteHTML($html,2);

			$pdf->Output($pdfFilePath, "I"); // For Show Pdf
		}
	}
	
	//Vessel Bill List end
	
	// Container Billing List Start
	function containerBillList()
	{
		$session_id = $this->session->userdata('value');			
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{	
			$login_id = $this->session->userdata('login_id');
			$data['title']="CONTAINER BILL LIST...";
			
			$sql_row_num="SELECT count(id) as rtnValue FROM  ctmsmis.mis_billing  INNER JOIN ctmsmis.billingreport
							ON ctmsmis.billingreport.id = ctmsmis.mis_billing.bill_type ";
			$config["total_rows"] = $this->bm->dataReturn($sql_row_num);
			//$r = $this->bm->dataReturn($sql_row_num);
			//echo $r;
			$segment_three = $this->uri->segment(3);
			
			$config = array();
			$config["base_url"] = site_url("report/containerBillList/$segment_three");
			$config["total_rows"] = $this->bm->dataReturn($sql_row_num);
			$config["per_page"] = 20;
			$offset = $this->uri->segment(4, 0);
			$config["uri_segment"] = 4;
			$limit=$config["per_page"];
			
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			$start=$page;
			//echo "t";
			//return;
			$sql_bill_list="SELECT imp_rot,exp_rot,bill_type,mlo_code,draft_id,IFNULL(created_user,'') AS created_user, draft_final_status,pdf_draft_view_name,pdf_detail_view_name, DATE(billing_date) AS billing_date, billingreport.billtype
							FROM ctmsmis.mis_billing INNER JOIN ctmsmis.billingreport ON ctmsmis.billingreport.id = ctmsmis.mis_billing.bill_type ORDER BY mis_billing.draft_id DESC limit $start,$limit";
			//echo $sql_bill_list;
			//return;

			$rslt_bill_list=$this->bm->dataSelect($sql_bill_list);
			$data['rslt_bill_list']=$rslt_bill_list;
			$data['start']=$start;
			$data["links"] = $this->pagination->create_links();
			
			$this->load->view('header5');
			$this->load->view('containerBillList',$data);
			$this->load->view('footer_1');
		}
	}
	
	function searchBillofContainer()
	{
		$session_id = $this->session->userdata('value');			
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$login_id = $this->session->userdata('login_id');
			$data['title']="CONTAINER BILL LIST...";
			
			$search_by=$this->input->post('search_by');
			
			if($search_by=="bill_type")
			{
				$bill_type=$this->input->post('bill_type');
				$cond="WHERE billtype='$bill_type'";
			}
			else if($search_by=="draft_no")
			{
				$draft_no=$this->input->post('draft_no');
				$cond="WHERE draft_id='$draft_no'";
			}
			else if($search_by=="imp_rotation_no")
			{
				$rotation_no=$this->input->post('rotation_no');
				$cond="WHERE imp_rot='$rotation_no'";
			}
			else if($search_by=="exp_rotation_no")
			{
				$rotation_no=$this->input->post('rotation_no');
				$cond="WHERE exp_rot='$rotation_no'";
			}
			
			$sql_bill_list="SELECT imp_rot,exp_rot,bill_type,mlo_code,draft_id,IFNULL(created_user,'') AS created_user, draft_final_status,pdf_draft_view_name,pdf_detail_view_name,DATE(billing_date) AS billing_date, billingreport.billtype
			FROM ctmsmis.mis_billing 
			INNER JOIN ctmsmis.billingreport ON ctmsmis.billingreport.id = ctmsmis.mis_billing.bill_type ".$cond." ORDER BY mis_billing.draft_id DESC ";
	
			$rslt_bill_list=$this->bm->dataSelect($sql_bill_list);
			
			$data['rslt_bill_list']=$rslt_bill_list; 
			$this->load->view('header5');
			$this->load->view('containerBillList',$data);
			$this->load->view('footer_1');
			
		}
	}
	
	function viewContainerBill()
	{
		$session_id = $this->session->userdata('value');			
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$draftNumber=$this->input->post('draftNumber');
			$draft_view=$this->input->post('draft_view');
						
			$this->load->library('m_pdf');
			$pdf->use_kwt = true;
			//echo $draftNumber."".$bill_type."".$cnt_code;
			//return;
			if($draft_view=='pdfPangoanDischargeInvoice')
			{
				$bill_sql="select * from (
						select mlo as payCustomerId,mlo_name as payCustomername,agent_code as customerId,agent as customerName,
						vsl_name as ibCarrierName,rotation as ibVisitId,berth,wpn,draftNumber,
						description as Particulars,size,height,count(description) as qty,sum(amt) as amt,
						IFNULL(sum(vat),0) as vat,(SELECT billing_date FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') as billingDate,argo_visist_dtls_eta as eta ,argo_visist_dtls_etd as etd,
						if(currency_gkey=2,'$','') as usd,
						'Container Discharging Bill (PCT)' as invoiceDesc,
						'DRAFT' as status,
						'' as comments,
						cast((
							CASE
								WHEN
									currency_gkey=2
								THEN
									CAST(Tarif_rate AS DECIMAL(10,4))
								ELSE
									substring(cast(Tarif_rate as DECIMAL(10,4)),1,length(cast(Tarif_rate as DECIMAL(10,4)))-2)
							END)as CHAR) AS rateBilled,
						exchangeRate,
						(select count(distinct id) from ctmsmis.mis_billing_details dtl
						where draftNumber='$draftNumber'
						and size=20) as qtytot20,
						(select count(distinct id) from ctmsmis.mis_billing_details dtl
						where draftNumber='$draftNumber' and size=40) as qtytot40,
						(select count(distinct id) from ctmsmis.mis_billing_details dtl
						where draftNumber='$draftNumber' and size=45) as qtytot45,
						vatperc,
						(SELECT created_user FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS created_user
						from
						(select * from ctmsmis.mis_billing_details 
						where draftNumber='$draftNumber') as tmp
						group by payCustomerId,Particulars,vatperc order by payCustomerId,Particulars asc,WPN desc) as tbl";

					$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";			
			}
			else if($draft_view=='pdfReeferInvoice')
			{
				$bill_sql="select 'Reefer Charges Bill' as invoiceDesc,draftNumber as draftNumber,mlo as payCustomerId,mlo_name as payCustomername,agent_code as customerId,agent as customerName,CAST((select max(exchangeRate) from ctmsmis.mis_billing_details dtl where draftNumber='$draftNumber') AS DECIMAL(10,4)) AS exchangeRate,description as Particulars,height,size,
				if(currency_gkey=2,'$','') as usd,
				cast((
				CASE
					WHEN
					currency_gkey=2
					THEN
					CAST(Tarif_rate AS DECIMAL(10,4))
					ELSE
					substring(cast(Tarif_rate as DECIMAL(10,4)),1,length(cast(Tarif_rate as DECIMAL(10,4)))-2)
					END
				)as CHAR) AS rateBilled,count(id) as qtyUnit,sum(storage_days)as qty,sum(amt) as amt,sum(vat) as vat,(sum(amt)+vat) as netTotal,'' as comments,'DRAFT' as status,rfr_disconnect as eventTo,
				(select count(distinct id) from ctmsmis.mis_billing_details dtl
				where draftNumber='$draftNumber'
				and size=20 and dtl.mlo=tbl.mlo
				and fcy_time_in is not null
				) as qtytot20,
				(select count(distinct id) from ctmsmis. mis_billing_details dtl
				where draftNumber='$draftNumber'
				and size=40 and dtl.mlo=tbl.mlo
				and fcy_time_in is not null
				) as qtytot40,
				(select count(distinct id) from ctmsmis.mis_billing_details dtl
				where draftNumber='$draftNumber'
				and size=45 and dtl.mlo=tbl.mlo
				and fcy_time_in is not null
				) as qtytot45
				from
				(select * from ctmsmis.mis_billing_details where draftNumber='$draftNumber' order by id) as tbl
				group by description,size";
					
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";						
			}
			else if($draft_view=='pdfLoadingInvoice')
			{
				$bill_sql="select 'Container Loading Bill' as invoiceDesc,draftNumber as draftNumber,mlo as payCustomerId,mlo_name as payCustomerName,agent_code as conCustomerId,agent as conCustomerName,CAST((select max(exchangeRate) from ctmsmis.mis_billing_details dtl where draftNumber='$draftNumber') AS DECIMAL(10,4)) AS exchangeRate,date(billingDate) as created,rotation as vslId,vsl_name as obCarrierName,ata as eta, atd as etd,berth as berth,description as description,height,size,
				if(currency_gkey=2,'$','') as usd,
				cast((
				CASE
				  WHEN
				   currency_gkey=2
				  THEN
				   CAST(Tarif_rate AS DECIMAL(10,4))
				  ELSE
				   substring(cast(Tarif_rate as DECIMAL(10,4)),1,length(cast(Tarif_rate as DECIMAL(10,4)))-2)

				  END
				)as CHAR) AS rateBilled,count(description) as quantityBilled,sum(amt) as totalCharged,SUM(vat) as totalvatamount,(sum(amt)+SUM(vat)) as netTotal,'' as comments,'DRAFT' as status,
				(select count(distinct id) from ctmsmis.mis_billing_details dtl
				where draftNumber='$draftNumber'
				and size=20 and dtl.mlo=tbl.mlo
				and fcy_time_in is not null
				) as qtytot20,
				(select count(distinct id) from ctmsmis.mis_billing_details dtl
				where draftNumber='$draftNumber'
				and size=40 and dtl.mlo=tbl.mlo
				and fcy_time_in is not null
				) as qtytot40,
				(select count(distinct id) from ctmsmis.mis_billing_details dtl
				where draftNumber='$draftNumber'
				and size=45 and dtl.mlo=tbl.mlo
				and fcy_time_in is not null
				) as qtytot45,
				(SELECT created_user FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS created_user
				from
				(select * from ctmsmis.mis_billing_details where draftNumber='$draftNumber' order by id) as tbl group by description";
					
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";						
			}
			else if($draft_view=='pdfDischargeInvoice')
			{
				$bill_sql="select * from (
				select mlo as payCustomerId,mlo_name as payCustomername,agent_code as customerId,agent as customerName,
				vsl_name as ibCarrierName,rotation as ibVisitId,berth,wpn,draftNumber,
				concat(description,'(',wpn,')') as Particulars,size,height,count(description) as qty,sum(amt) as amt,
				IFNULL(sum(vat),0) as vat,date(billingDate) as billingDate,argo_visist_dtls_eta as eta ,argo_visist_dtls_etd as etd,
				if(currency_gkey=2,'$','') as usd,
				'Container Discharging Bill' as invoiceDesc,
				'DRAFT' as status,
				'' as comments,
				cast((
					CASE
						WHEN
							currency_gkey=2
						THEN
							CAST(Tarif_rate AS DECIMAL(10,4))
						ELSE
							substring(cast(Tarif_rate as DECIMAL(10,4)),1,length(cast(Tarif_rate as DECIMAL(10,4)))-2)
					END
				)as CHAR) AS rateBilled,
				exchangeRate,
				(select count(distinct id) from ctmsmis.mis_billing_details dtl
				where draftNumber='$draftNumber'
				and size=20
				and fcy_time_in is not null
				) as qtytot20,
				(select count(distinct id) from ctmsmis.mis_billing_details dtl
				where draftNumber='$draftNumber'
				and size=40
				and fcy_time_in is not null
				) as qtytot40,
				(select count(distinct id) from ctmsmis.mis_billing_details dtl
				where draftNumber='$draftNumber'
				and size=45
				and fcy_time_in is not null
				) as qtytot45,
				vatperc,
				(SELECT created_user FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS created_user
				from
				(select * from ctmsmis.mis_billing_details 
				where draftNumber='$draftNumber') as tmp group by payCustomerId,Particulars,vatperc order by payCustomerId,Particulars asc,WPN desc
				) as tbl
				union all
				select mlo as payCustomerId,mlo_name as payCustomername,agent_code as customerId,agent as customerName,
				vsl_name as ibCarrierName,rotation as ibVisitId,berth,wpn,draftNumber,
				'LABOUR FUND' as Particulars,size,height,concat(sum(tues),'(Tues)') as qty,sum(tues)*4.5 as amt,
				0 as vat,date(billingDate) as billingDate,argo_visist_dtls_eta as eta ,argo_visist_dtls_etd as etd,
				'' as usd,
				'Container Discharging Bill' as invoiceDesc,'DRAFT' as status,'' as comments,
				4.5 AS rateBilled,exchangeRate,
				(select count(distinct id) from ctmsmis.mis_billing_details dtl
				where draftNumber='$draftNumber'
				and size=20
				and fcy_time_in is not null
				) as qtytot20,
				(select count(distinct id) from ctmsmis.mis_billing_details dtl
				where draftNumber='$draftNumber'
				and size=40
				and fcy_time_in is not null
				) as qtytot40,
				(select count(distinct id) from ctmsmis.mis_billing_details dtl
				where draftNumber='$draftNumber'
				and size=45
				and fcy_time_in is not null
				) as qtytot45,
				0 AS vatperc,
				(SELECT created_user FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS created_user
				from
				(
				select * from ctmsmis.mis_billing_details 
				where draftNumber='$draftNumber'
				) as tmp
				group by payCustomerId,Particulars";
					
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";						
			}
			
			$bill_rslt=$this->bm->dataSelect($bill_sql);	
			$print_time=$this->bm->dataSelect($bill_print_time);	
			$this->data['bill_rslt']=$bill_rslt;			
			$this->data['print_time']=$print_time;			
			
			if($draft_view=='pdfPangoanDischargeInvoice')
			{
				$html=$this->load->view('container_rptPangoanDischargingDraftInvoice.php',$this->data, true); 
				$pdfFilePath ="containerBill-".time()."-download.pdf";
			}
			else if($draft_view=='pdfReeferInvoice')
			{
				$html=$this->load->view('reeferbill',$this->data, true); 
				$pdfFilePath ="reeferbill-".time()."-download.pdf";
			}
			else if($draft_view=='pdfLoadingInvoice')
			{
				$html=$this->load->view('loadingbill',$this->data, true); 
				$pdfFilePath ="loadingbill-".time()."-download.pdf";
			}
			else if($draft_view=='pdfDischargeInvoice')
			{
				$html=$this->load->view('dischargebill',$this->data, true); 
				$pdfFilePath ="dischargebill-".time()."-download.pdf";
			}
				
			$pdf = $this->m_pdf->load();
			$pdf->SetWatermarkText('CPA CTMS');
			$pdf->showWatermarkText = true;	
			$pdf->useSubstitutions = true; 
			
			$stylesheet = file_get_contents('resources/styles/test.css');

			$pdf->setFooter('||Page {PAGENO} of {nb}');
			$pdf->WriteHTML($stylesheet,1);
			$pdf->WriteHTML($html,2);

			$pdf->Output($pdfFilePath, "I"); // For Show Pdf
		}
	}
	
	function viewContainerDetail()
	{
		$session_id = $this->session->userdata('value');			
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$draftNumber=$this->input->post('draftNumberDetail');
			$draft_detail_view=$this->input->post('draft_detail_view');
						
			$this->load->library('m_pdf');
			$pdf->use_kwt = true;
		//	echo $draft_detail_view;
		
		//	if($draft_detail_view=='pdfReeferDraftDetailsInvoice')
			if($draft_detail_view=='pdfReeferInvoice')
			{
				$sql_detail="select 'Reefer Charges Bill' as invoiceDesc,draftNumber as draftNumber,billingDate as created,mlo as customerId,mlo_name as customerName,agent_code as concustomerid,agent as concustomername,id as unitId,rotation as ibVisitId,vsl_name as ibCarrierName, size as isoLength,height as isoHeight,freight_kind as freightKind,rfr_connect as eventFrom,rfr_disconnect as eventTo,ceil((TIMESTAMPDIFF(SECOND, rfr_connect,rfr_disconnect))/3600) as hours,storage_days as quantity,vatperc as vatperc,'DRAFT' as status,yard
				from ctmsmis.mis_billing_details 
				where draftNumber='$draftNumber' 
				order by draftNumber";
			}
			
			else if($draft_detail_view=='pdfLoadingInvoice')
			{
				$sql_detail="select draftNumber as draftNumber,rotation as obVisitId,billingDate as created,vsl_name as obCarrierName,mlo as customerId,mlo_name as customerName,agent_code as concustomerid,agent as concustomername,id as unitId,size as isoLength,height as isoHeight,freight_kind as freightKind,vatperc as vatperc, atd as landingDate,description,'DRAFT' as status
				from ctmsmis.mis_billing_details 
				where draftNumber='$draftNumber' and description like 'Load%' 
				order by draftNumber";
			}
			else if($draft_detail_view=='pdfDischargeInvoice')
			{
				$sql_detail="select id as unitId,gkey,freight_kind as freightKind,'DRAFT' as status,'Container Discharging Bill' as invoiceDesc,draftNumber,vsl_name as ibCarrierName,
				mlo as customerId,mlo_name as customerName,agent_code as concustomerid,agent as concustomername,
				rotation as ibVisitId,date(billingDate) as created,size as isoLength,height as isoHeight,fcy_time_in as timeIn,
				wpn as equipment,
				(select sparcsn4.inv_goods.destination 
				from sparcsn4.inv_unit 
				inner join sparcsn4.inv_goods on sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
				where sparcsn4.inv_unit.gkey=ctmsmis.mis_billing_details.gkey) as preloc,
				vatperc,iso_grp,
				(CASE
						WHEN iso_grp = 'UT' THEN 'OPEN TOP'
						WHEN iso_grp IN ('RE','RT') THEN 'REEFER'
						WHEN iso_grp IN ('PL','PC','PC') THEN 'F-RACK'
						WHEN iso_grp IN ('TN','TD','TG') THEN 'TANK'
						ELSE NULL
				END) AS cnttype
				from ctmsmis.mis_billing_details
				where draftNumber='$draftNumber' and description like'DISCH%'
				order by draftNumber";
				
				$sql_detail_summary="SELECT
				COUNT(fcl_20_85) AS  fcl_20_85,
				COUNT(fcl_20_95) AS  fcl_20_95,
				COUNT(fcl_40_85) AS  fcl_40_85,
				COUNT(fcl_40_95) AS  fcl_40_95,
				COUNT(fcl_45_85) AS  fcl_45_85,
				COUNT(fcl_45_95) AS  fcl_45_95,

				COUNT(lcl_20_85) AS  lcl_20_85,
				COUNT(lcl_20_95) AS  lcl_20_95,
				COUNT(lcl_40_85) AS  lcl_40_85,
				COUNT(lcl_40_95) AS  lcl_40_95,
				COUNT(lcl_45_85) AS  lcl_45_85,
				COUNT(lcl_45_95) AS  lcl_45_95,

				COUNT(mty_20_85) AS  mty_20_85,
				COUNT(mty_20_95) AS  mty_20_95,
				COUNT(mty_40_85) AS  mty_40_85,
				COUNT(mty_40_95) AS  mty_40_95,
				COUNT(mty_45_85) AS  mty_45_85,
				COUNT(mty_45_95) AS  mty_45_95,
				COUNT(nonvat) AS  nonvat,
				COUNT(vat) AS  vat,
				COUNT(chargeEntityId) AS tot,
				COUNT(fcl) AS  fcl,
				COUNT(lcl) AS  lcl,
				COUNT(mty) AS  mty,
				COUNT(tot_20_85) AS  tot_20_85,
				COUNT(tot_20_95) AS  tot_20_95,
				COUNT(tot_40_85) AS  tot_40_85,
				COUNT(tot_40_95) AS  tot_40_95,
				COUNT(tot_45_85) AS  tot_45_85,
				COUNT(tot_45_95) AS  tot_45_95,
				COUNT(equipmentW) AS equipmentW,
				COUNT(equipmentP) AS equipmentP,
				COUNT(equipmentN) AS equipmentN,
				COUNT(LON) AS LON,
				(select (COUNT(chargeEntityId)-COUNT(LON))) AS NLON
				from
				(
				SELECT DISTINCT id as chargeEntityId,

				(CASE WHEN height='8.6' AND size = 20 AND freight_kind = 'FCL' THEN 1
				ELSE NULL END) AS fcl_20_85,

				(CASE WHEN height='9.6' AND size = 20 AND freight_kind = 'FCL' THEN 1
				ELSE NULL END) AS fcl_20_95,

				(CASE WHEN height='8.6' AND size = 40 AND freight_kind = 'FCL' THEN 1
				ELSE NULL END) AS fcl_40_85,

				(CASE WHEN height='9.6' AND size = 40 AND freight_kind = 'FCL' THEN 1
				ELSE NULL END) AS fcl_40_95,

				(CASE WHEN height='8.6' AND size = 45 AND freight_kind = 'FCL' THEN 1
				ELSE NULL END) AS fcl_45_85,

				(CASE WHEN height='9.6' AND size = 45 AND freight_kind = 'FCL' THEN 1
				ELSE NULL END) AS fcl_45_95,

				(CASE WHEN height='8.6' AND size = 20 AND freight_kind = 'LCL' THEN 1
				ELSE NULL END) AS lcl_20_85,

				(CASE WHEN height='9.6' AND size = 20 AND freight_kind = 'LCL' THEN 1
				ELSE NULL END) AS lcl_20_95,

				(CASE WHEN height='8.6' AND size = 40 AND freight_kind = 'LCL' THEN 1
				ELSE NULL END) AS lcl_40_85,

				(CASE WHEN height='9.6' AND size = 40 AND freight_kind = 'LCL' THEN 1
				ELSE NULL END) AS lcl_40_95,

				(CASE WHEN height='8.6' AND size = 45 AND freight_kind = 'LCL' THEN 1
				ELSE NULL END) AS lcl_45_85,

				(CASE WHEN height='9.6' AND size = 45 AND freight_kind = 'LCL' THEN 1
				ELSE NULL END) AS lcl_45_95,

				(CASE WHEN height='8.6' AND size = 20 AND freight_kind = 'MTY' THEN 1
				ELSE NULL END) AS mty_20_85,

				(CASE WHEN height='9.6' AND size = 20 AND freight_kind = 'MTY' THEN 1
				ELSE NULL END) AS mty_20_95,

				(CASE WHEN height='8.6' AND size = 40 AND freight_kind = 'MTY' THEN 1
				ELSE NULL END) AS mty_40_85,

				(CASE WHEN height='9.6' AND size = 40 AND freight_kind = 'MTY' THEN 1
				ELSE NULL END) AS mty_40_95,

				(CASE WHEN height='8.6' AND size = 45 AND freight_kind = 'MTY' THEN 1
				ELSE NULL END) AS mty_45_85,

				(CASE WHEN height='9.6' AND size = 45 AND freight_kind = 'MTY' THEN 1
				ELSE NULL END) AS mty_45_95,

				(CASE WHEN vatperc =0 THEN 1
				ELSE NULL END) AS nonvat,

				(CASE WHEN vatperc !=0 THEN 1
				ELSE NULL END) AS vat,

				(CASE WHEN freight_kind = 'FCL' THEN 1
				ELSE NULL END) AS fcl,

				(CASE WHEN freight_kind = 'LCL' THEN 1
				ELSE NULL END) AS lcl,

				(CASE WHEN freight_kind = 'MTY' THEN 1
				ELSE NULL END) AS mty,

				(CASE WHEN height='8.6' AND size = 20  THEN 1
				ELSE NULL END) AS tot_20_85,

				(CASE WHEN height='9.6' AND size = 20 THEN 1
				ELSE NULL END) AS tot_20_95,

				(CASE WHEN height='8.6' AND size = 40  THEN 1
				ELSE NULL END) AS tot_40_85,

				(CASE WHEN height='9.6' AND size = 40  THEN 1
				ELSE NULL END) AS tot_40_95,

				(CASE WHEN height='8.6' AND size = 45  THEN 1
				ELSE NULL END) AS tot_45_85,

				(CASE WHEN height='9.6' AND size = 45  THEN 1
				ELSE NULL END) AS tot_45_95,

				(CASE WHEN wpn='W'   THEN 1
				ELSE NULL END) AS equipmentW,

				(CASE WHEN wpn='P'   THEN 1
				ELSE NULL END) AS equipmentP,

				(CASE WHEN wpn='N'   THEN 1
				ELSE NULL END) AS equipmentN,
				if(destination not in('2591','2592','5230','5231','5232','5233','5234','5235','5236','5237','5238') and freight_kind !='MTY',1,NULL) as LON
				from
				(
				select * from ctmsmis.mis_billing_details where draftNumber='$draftNumber' and description like'DISCH%'
				) tbl
				) final";
				
				$rslt_detail_summary=$this->bm->dataSelect($sql_detail_summary);
				$this->data['rslt_detail_summary']=$rslt_detail_summary;
			}
			
			$rslt_detail=$this->bm->dataSelect($sql_detail);	
			
		//	$rslt_detail_summary=$this->bm->dataSelect($sql_detail_summary);	
		//	$print_time=$this->bm->dataSelect($bill_print_time);	
			$this->data['rslt_detail']=$rslt_detail;			  
		//	$this->data['rslt_detail_summary']=$rslt_detail_summary;					
			
		//	if($draft_detail_view=='pdfReeferDraftDetailsInvoice')
			if($draft_detail_view=='pdfReeferInvoice')
			{
				$html=$this->load->view('reeferdetail',$this->data, true); 
				$pdfFilePath ="reeferdetail-".time()."-download.pdf";
			}
			else if($draft_detail_view=='pdfLoadingInvoice')
			{
				$html=$this->load->view('loadingdetail',$this->data, true); 
				$pdfFilePath ="loadingdetail-".time()."-download.pdf";
			}
			else if($draft_detail_view=='pdfDischargeInvoice')
			{
				$html=$this->load->view('dischargedetail',$this->data, true); 
				$pdfFilePath ="dischargedetail-".time()."-download.pdf";
			}
				
			$pdf = $this->m_pdf->load();
			$pdf->SetWatermarkText('CPA CTMS');
			$pdf->showWatermarkText = true;	
			$pdf->useSubstitutions = true; 
			
			$stylesheet = file_get_contents('resources/styles/test.css'); 
			
			$pdf->setFooter('||Page {PAGENO} of {nb}');
			$pdf->WriteHTML($stylesheet,1);
			$pdf->WriteHTML($html,2);

			$pdf->Output($pdfFilePath, "I"); // For Show Pdf
		}
	}
	// Container Billing List End
	
	// Vat Status Start
	function checkVatStatusForm()
	{
		$session_id = $this->session->userdata('value');			
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$login_id = $this->session->userdata('login_id');
			$data['title']="Vat Status Check...";


			$this->load->view('header2');
			$this->load->view('checkVatStatusForm',$data);
			$this->load->view('footer');
			
		}
	}
	
	function vatStatusList()
	{
		$rotation_no=$this->input->post('rotation_no');
		$mloName=$this->input->post('mloName');
		$countVat=0;
		$countNonVat=0;
		
		if($mloName=="")
		{
			$countVatQry="select count(igm_detail_container.cont_number) as rtnValue
								from igm_detail_container 
								inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id  
								where igm_details.Import_Rotation_No='$rotation_no' and cont_vat='VAT'";
								
			$countNonVatQry="select count(igm_detail_container.cont_number) as rtnValue
								from igm_detail_container 
								inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id  
								where igm_details.Import_Rotation_No='$rotation_no' and cont_vat!='VAT'";
								
			$sql_search_vat_stat="select igm_detail_container.cont_number,igm_detail_container.cont_size,igm_detail_container.cont_height,cont_status,igm_detail_container.cont_vat as vat_novat,igm_details.mlocode
								from igm_detail_container 
								inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id  
								where igm_details.Import_Rotation_No='$rotation_no' 
								order by igm_detail_container.cont_vat desc ";
			
		}
		else
		{
			$countVatQry="select count(igm_detail_container.cont_number) as rtnValue
								from igm_detail_container 
								inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id  
								where igm_details.Import_Rotation_No='$rotation_no' and cont_vat='VAT' and igm_details.mlocode='$mloName'";
								
			$countNonVatQry="select count(igm_detail_container.cont_number) as rtnValue
								from igm_detail_container 
								inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id  
								where igm_details.Import_Rotation_No='$rotation_no' and cont_vat!='VAT' and igm_details.mlocode='$mloName'";
								
			$sql_search_vat_stat="select igm_detail_container.cont_number,igm_detail_container.cont_size,igm_detail_container.cont_height,cont_status,igm_detail_container.cont_vat as vat_novat,igm_details.mlocode
								from igm_detail_container 
								inner join igm_details on igm_details.id=igm_detail_container.igm_detail_id  
								where igm_details.Import_Rotation_No='$rotation_no' and igm_details.mlocode='$mloName'
								order by igm_detail_container.cont_vat desc ";
		}
		
		
		$countVat=$this->bm->dataReturnDb1($countVatQry);

		$countNonVat=$this->bm->dataReturnDb1($countNonVatQry);

		$rslt_vat_stat_list=$this->bm->dataSelectDb1($sql_search_vat_stat);
			
		$data['rslt_vat_stat_list']=$rslt_vat_stat_list; 
		$data['rotation_no']=$rotation_no; 
		$data['countVat']=$countVat; 
		$data['countNonVat']=$countNonVat; 
		$data['mloName']=$mloName; 
		
		$this->load->view('vatStatusList',$data);
	}
	// Vat Status End
	
	
		
	
	function countryWiseImportReport()
	{

		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$data['title']="Country Wise Import Report";
			$this->load->view('header2');
			$this->load->view('countryWiseImportReport',$data);
			$this->load->view('footer');
		}
	}

		
    function countryWiseImportReportView()
		{
			$session_id = $this->session->userdata('value');
			$login_id = $this->session->userdata('login_id');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$countryName=$this->input->post('countryName');
				$fromdate=$this->input->post('fromdate');
				$todate=$this->input->post('todate');
				
				$sqlQuery="select cnty,yr,sum(box) as box,sum(teus) as teus,(sum(cont_gross_weight)/1000) as tonnage
						from (
						select year(file_clearence_date) as yr,'$countryName' as cnty,1 as box,if(cont_size=20,1,2) as teus,cont_gross_weight 
						from igm_details
						inner join igm_detail_container on igm_detail_container.igm_detail_id=igm_details.id
						where date(file_clearence_date) between '$fromdate' and '$todate' and Exporter_address like '%$countryName%'
						) as tbl group by cnty,yr";
						
				$reslt = $this->bm->dataSelectDb1($sqlQuery);		
				//echo $sqlQuery;
				//return;
			$data['reslt']=$reslt;
			$data['countryName']=$countryName;
			$data['fromdate']=$fromdate;
			$data['todate']=$todate;
			$data['title']="Country Wise Import Report";
			//$this->load->view('header2');
			$this->load->view('countryWiseImportReportView',$data);
			//$this->load->view('footer');
			}
		}
	


//Year Wise Import Report

   	  function yearWiseImportReport()
	{

		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$data['title']="Year Wise Import Report";
			$this->load->view('header2');
			$this->load->view('yearWiseImportReport',$data);
			$this->load->view('footer');
		}
	}
		
		
		 function yearWiseImportReportView()
		{
			$session_id = $this->session->userdata('value');
			$login_id = $this->session->userdata('login_id');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$type=$this->input->post('options1');
				$fileType=$this->input->post('fileOptions');
								
				$fromdate=$this->input->post('fromdate');
				$todate=$this->input->post('todate');
				$sqlQuery="SELECT 
							sum(tot) as tot,
							sum(fcl_cont) as fcl_cont,
							sum(lcl_cont) as lcl_cont,
							sum(mty_cont) as mty_cont,
							sum(cont_20) as cont_20,
							sum(cont_40) as cont_40,
							sum(cont_45) as cont_45
							from(
							select
							1 as tot,
							(case when freight_kind='FCL' then 1 else 0 end) as fcl_cont,
							(case when freight_kind='LCL' then 1 else 0 end) as lcl_cont,
							(case when freight_kind='MTY' then 1 else 0 end) as mty_cont,
							(case when size=20 then 1 else 0 end) as cont_20,
							(case when size=40 then 1 else 0 end) as cont_40,
							(case when size=45 then 1 else 0 end) as cont_45
							from (
							SELECT inv_unit.freight_kind,
							(select right(nominal_length,2) from sparcsn4.inv_unit_equip
							inner join sparcsn4.ref_equipment on sparcsn4.inv_unit_equip.eq_gkey=sparcsn4.ref_equipment.gkey
							inner join sparcsn4.ref_equip_type on sparcsn4.ref_equipment.eqtyp_gkey=sparcsn4.ref_equip_type.gkey
							where sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey limit 1) as size 
							from sparcsn4.inv_unit  
							inner join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey 
							WHERE DATE(inv_unit_fcy_visit.time_in) BETWEEN '$fromdate' AND '$todate' AND  inv_unit.category='IMPRT'
							) as tbl) as final";
					
				$reslt = $this->bm->dataSelect($sqlQuery);		
				//echo $sqlQuery;
				//return;
				
				//$this->load->view('footer');
					
				 if($fileType!="pdf" )
				   {  
					$data['reslt']=$reslt;
					$data['fromdate']=$fromdate;
					$data['todate']=$todate;
					//$data['title']="Country Wise Import Report";
					//$this->load->view('header2');
					$this->load->view('yearWiseImportReportView',$data);
			   
						/* $fromdate=$this->input->post('fromdate1');
						$yard_no=$this->input->post('yard_no1'); 
						$data['fromdate']=$fromdate;
						$data['yard_no']=$yard_no;
						$data['type']=$type;
						$this->load->view('myReportEmtyContainerFoundListAssignment',$data); */
				   } 
				   
				   else if($fileType=="pdf")
				   {  
				   
						$this->load->library('m_pdf');
						$mpdf->use_kwt = true;
						$this->data['reslt']=$reslt;	
						$this->data['fromdate']=$fromdate;
						$this->data['todate']=$todate; 
						//$this->data['title']="Country Wise Import Report";

						$html=$this->load->view('yearWiseImportReportView',$this->data, true); 
						$pdfFilePath ="yearWiseImportReportViewPdf_".time().".pdf";

						   //actually, you can pass mPDF parameter on this load() function
						$pdf = $this->m_pdf->load();
						$pdf->SetWatermarkText('CPA CTMS');
						$pdf->showWatermarkText = true;		
						//$stylesheet = file_get_contents('resources/styles/test.css'); // external css
						$pdf->setFooter('Developed By : DataSoft|Page {PAGENO}|Date {DATE j-m-Y}');
						$pdf->WriteHTML($html,2);
						$pdf->Output($pdfFilePath, "I"); // For Show Pdf					
				   }

			}
		}
		
	function exportContainerLoadingList()
	{
		$session_id = $this->session->userdata('value');		
		if($this->input->post('Search'))
		{
			$rotation = trim($this->input->post('rotation'));		
			$sql_export_container_loading_list="select inv_unit.id,ib_vyg as vsl_visit_dtls_ib_vyg,name as vsl_name,freight_kind,category,
			(select size from ctmsmis.mis_inv_unit where ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey) as size,ctmsmis.mis_exp_unit.cont_status,
			(select height from ctmsmis.mis_inv_unit where ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey) as height,
			(select mlo from ctmsmis.mis_inv_unit where ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey) as mlo,
			(select mlo_name from ctmsmis.mis_inv_unit where ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey) as mlo_name,
			stowage_pos,seal_no,mis_exp_unit.last_update,user_id,mis_exp_unit.goods_and_ctr_wt_kg,pod,truck_no,re_status 
			from ctmsmis.mis_exp_unit 
			inner join sparcsn4.inv_unit on sparcsn4.inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
			inner join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
			inner join sparcsn4.vsl_vessel_visit_details on sparcsn4.vsl_vessel_visit_details.vvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey
			inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey 
			where ib_vyg='$rotation' and sparcsn4.inv_unit_fcy_visit.transit_state not in('S60_LOADED','S70_DEPARTED','S99_RETIRED') and preAddStat=0 and snx_type!=2 and hour(TIMEDIFF(now(),last_update))<75 
			order by ctmsmis.mis_exp_unit.last_update desc,ctmsmis.mis_exp_unit.vvd_gkey";

			
		}
	  
		else{ 
			$sql_export_container_loading_list="select inv_unit.id,ib_vyg as vsl_visit_dtls_ib_vyg,name as vsl_name,freight_kind,category,
			(select size from ctmsmis.mis_inv_unit where ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey) as size,ctmsmis.mis_exp_unit.cont_status,
			(select height from ctmsmis.mis_inv_unit where ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey) as height,
			(select mlo from ctmsmis.mis_inv_unit where ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey) as mlo,
			(select mlo_name from ctmsmis.mis_inv_unit where ctmsmis.mis_inv_unit.gkey=ctmsmis.mis_exp_unit.gkey) as mlo_name,
			stowage_pos,seal_no,mis_exp_unit.last_update,user_id,mis_exp_unit.goods_and_ctr_wt_kg,pod,truck_no,re_status 
			from ctmsmis.mis_exp_unit 
			inner join sparcsn4.inv_unit on sparcsn4.inv_unit.gkey=ctmsmis.mis_exp_unit.gkey 
			inner join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
			inner join sparcsn4.vsl_vessel_visit_details on sparcsn4.vsl_vessel_visit_details.vvd_gkey=ctmsmis.mis_exp_unit.vvd_gkey
			inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey 
			where sparcsn4.inv_unit_fcy_visit.transit_state not in('S60_LOADED','S70_DEPARTED','S99_RETIRED') and preAddStat=0 and snx_type!=2 and hour(TIMEDIFF(now(),last_update))<75 
			order by ctmsmis.mis_exp_unit.last_update desc,ctmsmis.mis_exp_unit.vvd_gkey";
		  }		
		$rslt_export_container_loading_list=$this->bm->dataSelect($sql_export_container_loading_list);
			
		$data['rslt_export_container_loading_list']=$rslt_export_container_loading_list;
		
	//	$this->load->view('header5');
		$this->load->view('exportContainerLoadingList',$data);
	//	$this->load->view('footer_1');
	}
	
	//24 Hours Discharge Container List Start
function getLast24HourDischargeImportContainerList()
	{
		$cont_size = $this->uri->segment(3);
		$fromdate = $this->uri->segment(4);
		$vvdGkey = $this->uri->segment(5);
		$impContType = $this->uri->segment(6);
		$qryCond="";
		$qryCondExtra="";
		$qryCondFcyTime="";
		$qryCondFcyTimeOnBoard="";
		
		// Discharge 
		if($impContType=='discharge_done_LD_20')
		{
			$qryCond="SELECT 
						(CASE WHEN size = $cont_size
						AND fcy_time_in >CONCAT(DATE_ADD('$fromdate', INTERVAL -1 DAY),' 08:00:00')
						AND fcy_time_in <CONCAT('$fromdate',' 08:00:01') 
						AND freight_kind IN ('FCL','LCL')  THEN id 
						ELSE '' END) AS discharge_container,size,height,freight_kind,fcy_time_in
						FROM";
			$qryCondFcyTime=" WHERE fcy_time_in IS NOT NULL";
		}
		else if($impContType=='discharge_done_LD_40')
		{
			$qryCond="SELECT 
						(CASE WHEN size !=$cont_size
						AND fcy_time_in >CONCAT(DATE_ADD('$fromdate', INTERVAL -1 DAY),' 08:00:00')
						AND fcy_time_in <CONCAT('$fromdate',' 08:00:01') 
						AND freight_kind IN ('FCL','LCL')  THEN id   
						ELSE '' END) AS discharge_container,size,height,freight_kind,fcy_time_in
						FROM";
			$qryCondFcyTime=" WHERE fcy_time_in IS NOT NULL";
		}
		else if($impContType=='discharge_done_MT_20')
		{
			$qryCond="SELECT 
						(CASE WHEN size = $cont_size
							AND fcy_time_in >CONCAT(DATE_ADD('$fromdate', INTERVAL -1 DAY),' 08:00:00')
							AND fcy_time_in <CONCAT('$fromdate',' 08:00:01') 
							AND freight_kind ='MTY'  THEN id  
							ELSE '' END) AS discharge_container,size,height,freight_kind,fcy_time_in
						FROM";
			$qryCondFcyTime=" WHERE fcy_time_in IS NOT NULL";
		}
		else if($impContType=='discharge_done_MT_40')
		{
			$qryCond="SELECT 
						(CASE WHEN size !=$cont_size
							AND fcy_time_in >CONCAT(DATE_ADD('$fromdate', INTERVAL -1 DAY),' 08:00:00')
							AND fcy_time_in <CONCAT('$fromdate',' 08:00:01') 
							AND freight_kind ='MTY'  THEN id  
							ELSE '' END) AS discharge_container,size,height,freight_kind,fcy_time_in
						FROM";
			$qryCondFcyTime=" WHERE fcy_time_in IS NOT NULL";
		}
		
		// Discharge Total
		else if($impContType=='balance_LD_20')
		{
			$qryCond="SELECT 
						(CASE WHEN size = $cont_size AND freight_kind IN ('FCL','LCL')  THEN id  
						ELSE '' END) AS discharge_container,size,height,freight_kind,fcy_time_in
						FROM";
			$qryCondExtra=" AND fcy_transit_state NOT IN ('S20_INBOUND')";
		}
		else if($impContType=='balance_LD_40')
		{
			$qryCond="SELECT 
						(CASE WHEN size > $cont_size AND freight_kind IN ('FCL','LCL')  THEN id  
						ELSE '' END) AS discharge_container,size,height,freight_kind,fcy_time_in
						FROM";
			$qryCondExtra=" AND fcy_transit_state NOT IN ('S20_INBOUND')";
		}
		else if($impContType=='balance_MT_20')
		{
			$qryCond="SELECT 
						(CASE WHEN size = $cont_size AND freight_kind ='MTY'  THEN id  
						ELSE '' END) AS discharge_container,size,height,freight_kind,fcy_time_in
						FROM";
			$qryCondExtra=" AND fcy_transit_state NOT IN ('S20_INBOUND')";
		}
		else if($impContType=='balance_MT_40')
		{
			$qryCond="SELECT 
						(CASE WHEN size > $cont_size AND freight_kind ='MTY'  THEN id  
						ELSE '' END) AS discharge_container,size,height,freight_kind,fcy_time_in
						FROM";
			$qryCondExtra=" AND fcy_transit_state NOT IN ('S20_INBOUND')";
		}
		
		// Discharge Balance
		
		else if($impContType=='onboard_LD_20')
		{
			$qryCond="SELECT 
						(CASE WHEN size = $cont_size AND freight_kind IN ('FCL','LCL')  THEN id  
							ELSE '' END) AS discharge_container,size,height,freight_kind,fcy_time_in
						FROM";
			$qryCondExtra=" AND fcy_transit_state='S20_INBOUND'";
			$qryCondFcyTimeOnBoard=" WHERE  fcy_time_in IS NULL";
		}
		else if($impContType=='onboard_LD_40')
		{
			$qryCond="SELECT 
						(CASE WHEN size > $cont_size AND freight_kind IN ('FCL','LCL')  THEN id  
						ELSE '' END) AS discharge_container,size,height,freight_kind,fcy_time_in
						FROM";
			$qryCondExtra=" AND fcy_transit_state='S20_INBOUND'";
			$qryCondFcyTimeOnBoard=" WHERE  fcy_time_in IS NULL";
		}
		else if($impContType=='onboard_MT_20')
		{
			$qryCond="SELECT 
						(CASE WHEN size = $cont_size AND freight_kind ='MTY'  THEN id  
						ELSE '' END) AS discharge_container,size,height,freight_kind,fcy_time_in
						FROM";
			$qryCondExtra=" AND fcy_transit_state='S20_INBOUND'";
			$qryCondFcyTimeOnBoard=" WHERE  fcy_time_in IS NULL";
		}
		else if($impContType=='onboard_MT_40')
		{
			$qryCond="SELECT 
						(CASE WHEN size > $cont_size AND freight_kind ='MTY'  THEN id  
						ELSE '' END) AS discharge_container,size,height,freight_kind,fcy_time_in
						FROM";
			$qryCondExtra=" AND fcy_transit_state='S20_INBOUND'";
			$qryCondFcyTimeOnBoard=" WHERE  fcy_time_in IS NULL";
		}
		
		$query="SELECT
				*
				FROM 
				(
				".
				$qryCond.				
				"
				(
				SELECT id, size,height,IFNULL((SELECT disch_dt FROM ctmsmis.mis_disch_cont WHERE ctmsmis.mis_disch_cont.gkey=ctmsmis.mis_inv_unit.gkey),fcy_time_in) AS fcy_time_in,freight_kind
				FROM ctmsmis.mis_inv_unit 
				WHERE  mis_inv_unit.vvd_gkey=$vvdGkey AND category='IMPRT'".$qryCondExtra."
				) AS tmp ".$qryCondFcyTime.$qryCondFcyTimeOnBoard."
				) AS final WHERE discharge_container!=''";
		//echo $query;
		
		$getVesselInfoQry="select vsl_vessels.name as vsl_name,ifnull(sparcsn4.vsl_vessel_visit_details.flex_string02,
							ifnull(sparcsn4.vsl_vessel_visit_details.flex_string03,'')) as berth_op,ifnull(sparcsn4.argo_quay.id,'') as berth,
							sparcsn4.argo_carrier_visit.ata,sparcsn4.argo_carrier_visit.atd,sparcsn4.vsl_vessel_visit_details.ib_vyg 
							from vsl_vessel_visit_details
							inner join sparcsn4.argo_carrier_visit on sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
							inner join sparcsn4.vsl_vessel_berthings on sparcsn4.vsl_vessel_berthings.vvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
							inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
							inner join sparcsn4.argo_quay on sparcsn4.argo_quay.gkey=sparcsn4.vsl_vessel_berthings.quay
							where vsl_vessel_visit_details.vvd_gkey=$vvdGkey";
		
		$disChargeListContainer=$this->bm->dataSelect($query);
		$getVesselInfo=$this->bm->dataSelect($getVesselInfoQry);
		
		$data['disChargeListContainer']=$disChargeListContainer; 
		$data['getVesselInfo']=$getVesselInfo; 
		$this->load->view('getLast24HourDischargeContainerList',$data);
	}
	
	// Discharge Export  
	function getLast24HourDischargeExportContainerList()
	{
		$cont_size = $this->uri->segment(3);
		$fromdate = $this->uri->segment(4);
		$vvdGkey = $this->uri->segment(5);
		$impContType = $this->uri->segment(6);
		$qryCond="";
		$qryCondExtra="";
		$qryCondFcyTime="";
		
		// Discharge 
		if($impContType=='discharge_done_LD_20')
		{
			$qryCond="SELECT 
						(CASE WHEN size = $cont_size
						AND fcy_time_in >CONCAT(DATE_ADD('$fromdate', INTERVAL -1 DAY),' 08:00:00')
						AND fcy_time_in <CONCAT('$fromdate',' 08:00:01') 
						AND freight_kind IN ('FCL','LCL')  THEN id 
						ELSE '' END) AS discharge_container,size,height,freight_kind,fcy_time_in
						FROM";
			$qryCondFcyTime=" WHERE fcy_time_in IS NOT NULL";
		}
		else if($impContType=='discharge_done_LD_40')
		{
			$qryCond="SELECT 
						(CASE WHEN size !=$cont_size
						AND fcy_time_in >CONCAT(DATE_ADD('$fromdate', INTERVAL -1 DAY),' 08:00:00')
						AND fcy_time_in <CONCAT('$fromdate',' 08:00:01') 
						AND freight_kind IN ('FCL','LCL')  THEN id   
						ELSE '' END) AS discharge_container,size,height,freight_kind,fcy_time_in
						FROM";
			$qryCondFcyTime=" WHERE fcy_time_in IS NOT NULL";
		}
		else if($impContType=='discharge_done_MT_20')
		{
			$qryCond="SELECT 
						(CASE WHEN size = $cont_size
							AND fcy_time_in >CONCAT(DATE_ADD('$fromdate', INTERVAL -1 DAY),' 08:00:00')
							AND fcy_time_in <CONCAT('$fromdate',' 08:00:01') 
							AND freight_kind ='MTY'  THEN id  
							ELSE '' END) AS discharge_container,size,height,freight_kind,fcy_time_in
						FROM";
			$qryCondFcyTime=" WHERE fcy_time_in IS NOT NULL";
		}
		else if($impContType=='discharge_done_MT_40')
		{
			$qryCond="SELECT 
						(CASE WHEN size !=$cont_size
							AND fcy_time_in >CONCAT(DATE_ADD('$fromdate', INTERVAL -1 DAY),' 08:00:00')
							AND fcy_time_in <CONCAT('$fromdate',' 08:00:01') 
							AND freight_kind ='MTY'  THEN id  
							ELSE '' END) AS discharge_container,size,height,freight_kind,fcy_time_in
						FROM";
			$qryCondFcyTime=" WHERE fcy_time_in IS NOT NULL";
		}
		
		// Discharge Total
		else if($impContType=='balance_LD_20')
		{
			$qryCond="SELECT 
						(CASE WHEN size = $cont_size AND freight_kind IN ('FCL','LCL')  THEN id  
						ELSE '' END) AS discharge_container,size,height,freight_kind,fcy_time_in
						FROM";
			$qryCondExtra=" AND fcy_transit_state NOT IN ('S20_INBOUND')";
		}
		else if($impContType=='balance_LD_40')
		{
			$qryCond="SELECT 
						(CASE WHEN size > $cont_size AND freight_kind IN ('FCL','LCL')  THEN id  
						ELSE '' END) AS discharge_container,size,height,freight_kind,fcy_time_in
						FROM";
			$qryCondExtra=" AND fcy_transit_state NOT IN ('S20_INBOUND')";
		}
		else if($impContType=='balance_MT_20')
		{
			$qryCond="SELECT 
						(CASE WHEN size = $cont_size AND freight_kind ='MTY'  THEN id  
						ELSE '' END) AS discharge_container,size,height,freight_kind,fcy_time_in
						FROM";
			$qryCondExtra=" AND fcy_transit_state NOT IN ('S20_INBOUND')";
		}
		else if($impContType=='balance_MT_40')
		{
			$qryCond="SELECT 
						(CASE WHEN size > $cont_size AND freight_kind ='MTY'  THEN id  
						ELSE '' END) AS discharge_container,size,height,freight_kind,fcy_time_in
						FROM";
			$qryCondExtra=" AND fcy_transit_state NOT IN ('S20_INBOUND')";
		}
		
		// Discharge Balance
		
		else if($impContType=='onboard_LD_20')
		{
			$qryCond="SELECT 
						(CASE WHEN size = $cont_size AND freight_kind IN ('FCL','LCL')  THEN id  
							ELSE '' END) AS discharge_container,size,height,freight_kind,fcy_time_in
						FROM";
			$qryCondExtra=" AND fcy_transit_state='S20_INBOUND'";
		}
		else if($impContType=='onboard_LD_40')
		{
			$qryCond="SELECT 
						(CASE WHEN size > $cont_size AND freight_kind IN ('FCL','LCL')  THEN id  
						ELSE '' END) AS discharge_container,size,height,freight_kind,fcy_time_in
						FROM";
			$qryCondExtra=" AND fcy_transit_state='S20_INBOUND'";
		}
		else if($impContType=='onboard_MT_20')
		{
			$qryCond="SELECT 
						(CASE WHEN size = $cont_size AND freight_kind ='MTY'  THEN id  
						ELSE '' END) AS discharge_container,size,height,freight_kind,fcy_time_in
						FROM";
			$qryCondExtra=" AND fcy_transit_state='S20_INBOUND'";
		}
		else if($impContType=='onboard_MT_40')
		{
			$qryCond="SELECT 
						(CASE WHEN size > $cont_size AND freight_kind ='MTY'  THEN id  
						ELSE '' END) AS discharge_container,size,height,freight_kind,fcy_time_in
						FROM";
			$qryCondExtra=" AND fcy_transit_state='S20_INBOUND'";
		}
		
		$query="SELECT
				*
				FROM 
				(
				".
				$qryCond.				
				"
				(
				SELECT id, size,height,IFNULL((SELECT disch_dt FROM ctmsmis.mis_disch_cont WHERE ctmsmis.mis_disch_cont.gkey=ctmsmis.mis_inv_unit.gkey),fcy_time_in) AS fcy_time_in,freight_kind
				FROM ctmsmis.mis_inv_unit 
				WHERE  mis_inv_unit.vvd_gkey=$vvdGkey AND category='EXPRT'".$qryCondExtra."
				) AS tmp ".$qryCondFcyTime."
				) AS final WHERE discharge_container!=''";
		//echo $query;
		
		$getVesselInfoQry="select vsl_vessels.name as vsl_name,ifnull(sparcsn4.vsl_vessel_visit_details.flex_string02,
							ifnull(sparcsn4.vsl_vessel_visit_details.flex_string03,'')) as berth_op,ifnull(sparcsn4.argo_quay.id,'') as berth,
							sparcsn4.argo_carrier_visit.ata,sparcsn4.argo_carrier_visit.atd,sparcsn4.vsl_vessel_visit_details.ib_vyg 
							from vsl_vessel_visit_details
							inner join sparcsn4.argo_carrier_visit on sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
							inner join sparcsn4.vsl_vessel_berthings on sparcsn4.vsl_vessel_berthings.vvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
							inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
							inner join sparcsn4.argo_quay on sparcsn4.argo_quay.gkey=sparcsn4.vsl_vessel_berthings.quay
							where vsl_vessel_visit_details.vvd_gkey=$vvdGkey";
		
		$disChargeListContainer=$this->bm->dataSelect($query);
		$getVesselInfo=$this->bm->dataSelect($getVesselInfoQry);
		
		$data['disChargeListContainer']=$disChargeListContainer; 
		$data['getVesselInfo']=$getVesselInfo; 
		$this->load->view('getLast24HourDischargeContainerList',$data);
	}
	//24 Hours Discharge Container List End
	
	//Sumon attached--berth report view
			function berthReportView()
		{
				$this->load->library('m_pdf');
		        $mpdf->use_kwt = true;

				$data['fromdate']=$fromdate=$this->input->post('fromdate');
				$data['todate']=$todate=$this->input->post('todate');
/* 				print($fromdate);
				print($todate);
				return; */
				
				$sql = "SELECT vsl_vessels.id AS VesselID,vsl_vessels.name AS
				VesselName,(vsl_vessel_classes.loa_cm)/10 AS LENGTH,vsl_vessel_classes.beam_cm AS Draft,argo_quay.id AS JettyNo,
				(SELECT ref_routing_point.id FROM sparcsn4.argo_visit_details INNER JOIN sparcsn4.ref_point_calls ON argo_visit_details.itinereray=ref_point_calls.itin_gkey INNER JOIN sparcsn4.ref_routing_point ON ref_point_calls.point_gkey=ref_routing_point.gkey WHERE argo_visit_details.gkey=vsl_vessel_visit_details.vvd_gkey AND ref_point_calls.calling_order=0) AS LoadPortCall,r.id AS LineOperator,r.name AS LocalAgent,vsl_vessels.country_code AS Flag,IFNULL(vsl_vessel_berthings.eta,(SELECT eta FROM sparcsn4.argo_visit_details WHERE sparcsn4.argo_visit_details.gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey)) AS estBerthDate,vsl_vessel_berthings.ata AS BerthDate
				FROM sparcsn4.vsl_vessel_visit_details
				INNER JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
				INNER JOIN sparcsn4.vsl_vessel_classes ON sparcsn4.vsl_vessel_classes.gkey=sparcsn4.vsl_vessels.vesclass_gkey
				INNER JOIN sparcsn4.vsl_vessel_berthings ON sparcsn4.vsl_vessel_berthings.vvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
				INNER JOIN sparcsn4.argo_quay ON sparcsn4.argo_quay.gkey=sparcsn4.vsl_vessel_berthings.quay
				INNER JOIN  ( sparcsn4.ref_bizunit_scoped r 
				LEFT JOIN ( sparcsn4.ref_agent_representation X  
				LEFT JOIN sparcsn4.ref_bizunit_scoped Y ON X.agent_gkey=Y.gkey )              
				ON r.gkey=X.bzu_gkey)  ON r.gkey = vsl_vessel_visit_details.bizu_gkey
				WHERE DATE(vsl_vessel_berthings.ata) BETWEEN '$fromdate' AND '$todate'";	
								
				$resultList = $this->bm->dataSelect($sql);	
				$this->data['resultList']=$resultList;

				$this->load->view('berthReportViewForm',$data);
				$html=$this->load->view('berthReportViewForm',$this->data, true); 
				
				$pdfFilePath ="berthReport- ".time()."-download.pdf";

				$pdf = $this->m_pdf->load();
				$pdf->SetWatermarkText('CPA CTMS');
				$pdf->showWatermarkText = true;	
				$pdf->useSubstitutions = true; 
					
				$pdf->setFooter('Developed By : DataSoft|Page {PAGENO}|Date {DATE j-m-Y}');
			
				//$pdf->WriteHTML($stylesheet,1);
				$pdf->WriteHTML($html,2);
					
				$pdf->Output($pdfFilePath, "I");	 
		}
	//Sourav
	
	function mloWiseFinalDischargingExportFormForCPA(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="MLO WISE FINAL LOADING EXPORT REPORT APPS...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('myReportExportContainerLoadedFormForCPA',$data);
				$this->load->view('footer');
			}	
        }
	public function chkMloWiseFinalDischargingExport()
	{
		if (isset($_POST['detail'])) {
        # detail-button was clicked
			//$this->myExportContainerLoadedReportView();
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');		
			$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
			$fromdate=$this->input->post('fromdate');
			$fromTime=$this->input->post('fromTime');
			$todate=$this->input->post('todate');
			$toTime=$this->input->post('toTime');
			$getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
			$data['voysNo']=$getVoyNo;
			$data['fromdate']=$fromdate;
			$data['fromTime']=$fromTime;
			$data['todate']=$todate;
			$data['toTime']=$toTime;
			
			$this->load->view('myReportExportContainerLoadingListViewForCPA',$data);
		}
		elseif (isset($_POST['summary'])) {
			# summary-button was clicked
			//$this->myExportImExSummeryView();
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
			$fromdate=$this->input->post('fromdate');
			$fromTime=$this->input->post('fromTime');
			$todate=$this->input->post('todate');
			$toTime=$this->input->post('toTime');
			$this->load->model('ci_auth', 'bm', TRUE);
			$getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
			$data['voysNo']=$getVoyNo;		
			$data['ddl_imp_rot_no']=$ddl_imp_rot_no;		
			$data['fromdate']=$fromdate;
			$data['fromTime']=$fromTime;
			$data['todate']=$todate;
			$data['toTime']=$toTime;
			//echo $data['voysNo'];
			$this->load->view('myReportExportSummaryMloWise',$data);
			$this->load->view('myclosebar');

		}
	}
	
	function mloWiseFinalDischargingExportFormForCPAN4(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="MLO WISE FINAL LOADING EXPORT REPORT...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('myReportExportContainerLoadedFormForCPAN4',$data);
				$this->load->view('footer');
			}	
        }
	public function chkMloWiseFinalDischargingExportN4()
	{
		if (isset($_POST['detail'])) {
        # detail-button was clicked
			//$this->myExportContainerLoadedReportView();
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');		
			$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
			//$fromdate=$this->input->post('fromdate');
			//$fromTime=$this->input->post('fromTime');
			//$todate=$this->input->post('todate');
			//$toTime=$this->input->post('toTime');
			$getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
			$data['voysNo']=$getVoyNo;
			//$data['fromdate']=$fromdate;
			//$data['fromTime']=$fromTime;
			//$data['todate']=$todate;
			//$data['toTime']=$toTime;
			
			$this->load->view('myReportExportContainerLoadingListViewForCPAN4',$data);
		}
		elseif (isset($_POST['summary'])) {
			# summary-button was clicked
			//$this->myExportImExSummeryView();
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
			//$fromdate=$this->input->post('fromdate');
			//$fromTime=$this->input->post('fromTime');
			//$todate=$this->input->post('todate');
			//$toTime=$this->input->post('toTime');
			$this->load->model('ci_auth', 'bm', TRUE);
			$getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
			$data['voysNo']=$getVoyNo;		
			$data['ddl_imp_rot_no']=$ddl_imp_rot_no;		
			//$data['fromdate']=$fromdate;
			//$data['fromTime']=$fromTime;
			//$data['todate']=$todate;
			//$data['toTime']=$toTime;
			//echo $data['voysNo'];
			$this->load->view('myReportExportSummaryMloWiseN4',$data);
			$this->load->view('myclosebar');

		}
	}
	function mloWiseFinalDischargingImportFormForCPA(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="MLO WISE FINAL DISCHARGING IMPORT REPORT...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('myReportImportContainerLoadedFormForCPA',$data);
				$this->load->view('footer');
			}	
       }
	public function chkMloWiseFinalDischargingImport()
	{
		if (isset($_POST['detail'])) {
        # detail-button was clicked
			//$this->myExportContainerLoadedReportView();
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');		
			$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
			$fromdate=$this->input->post('fromdate');
			$fromTime=$this->input->post('fromTime');
			$todate=$this->input->post('todate');
			$toTime=$this->input->post('toTime');
			$getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
			$data['voysNo']=$getVoyNo;
			$data['fromdate']=$fromdate;
			$data['fromTime']=$fromTime;
			$data['todate']=$todate;
			$data['toTime']=$toTime;
			
			$this->load->view('myReportImportContainerLoadingListViewForCPA',$data);
		}
		elseif (isset($_POST['summary'])) {
			# summary-button was clicked
			//$this->myExportImExSummeryView();
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
			$fromdate=$this->input->post('fromdate');
			$fromTime=$this->input->post('fromTime');
			$todate=$this->input->post('todate');
			$toTime=$this->input->post('toTime');
			$this->load->model('ci_auth', 'bm', TRUE);
			$getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
			$data['voysNo']=$getVoyNo;		
			$data['ddl_imp_rot_no']=$ddl_imp_rot_no;		
			$data['fromdate']=$fromdate;
			$data['fromTime']=$fromTime;
			$data['todate']=$todate;
			$data['toTime']=$toTime;
			//echo $data['voysNo'];
			$this->load->view('mloWiseLoadingSummaryList',$data);
			$this->load->view('myclosebar');

		}
	}
	public function chkImportLoadedContainerMloWise()
	{
		if (isset($_POST['detail'])) {
        # detail-button was clicked
			//$this->myImportContainerLoadedReportView();
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
			$this->load->model('ci_auth', 'bm', TRUE);
			
			$fromdate=$this->input->post('fromdate');
			$fromTime=$this->input->post('fromTime');
			$todate=$this->input->post('todate');
			$toTime=$this->input->post('toTime');
			$getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
			$data['voysNo']=$getVoyNo;
			$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
			$data['fromdate']=$fromdate;
			$data['fromTime']=$fromTime;
			$data['todate']=$todate;
			$data['toTime']=$toTime;
			
			
			//echo $data['toTime'];
			//return;
			$this->load->view('myReportImportContainerLoadingListViewForCPA',$data);
		}
		elseif (isset($_POST['summary'])) {
			# summary-button was clicked
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');		
			$fromdate=$this->input->post('fromdate');
			$fromTime=$this->input->post('fromTime');
			$todate=$this->input->post('todate');
			$toTime=$this->input->post('toTime');
			$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
			$data['fromdate']=$fromdate;
			$data['fromTime']=$fromTime;
			$data['todate']=$todate;
			$data['toTime']=$toTime;
			
			$getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
			$data['voysNo']=$getVoyNo;
			$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
						
			$this->load->view('mloWiseLoadingSummaryList',$data);

		}
	}
	public function chkExportLoadedContainerMloWise()
	{
		if (isset($_POST['detail'])) {
        # detail-button was clicked
			$this->myExportContainerLoadedReportView();
		}
		elseif (isset($_POST['summary'])) {
			# summary-button was clicked
			//$this->myExportImExSummeryView();
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
			$fromdate=$this->input->post('fromdate');
			$fromTime=$this->input->post('fromTime');
			$todate=$this->input->post('todate');
			$toTime=$this->input->post('toTime');
			$this->load->model('ci_auth', 'bm', TRUE);
			$getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
			$data['voysNo']=$getVoyNo;		
			$data['ddl_imp_rot_no']=$ddl_imp_rot_no;		
			$data['fromdate']=$fromdate;
			$data['fromTime']=$fromTime;
			$data['todate']=$todate;
			$data['toTime']=$toTime;
			//echo $data['voysNo'];
			$this->load->view('myReportExportSummaryMloWise',$data);
			$this->load->view('myclosebar');

		}
	}
	
	// Pangoan Discahrge Report----Sumon Roy-------
	
	 function pangoanDischargeForm()
        {
            //print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="PANGAON DISCHARGING  REPORT...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('pangoanDischargeFormView',$data);
				$this->load->view('footer');
			}	
            
        }
        
        function pangoanDischargeReportPerform()
        {
            if (isset($_POST['detail'])) {
        # detail-button was clicked
			//$this->myExportContainerLoadedReportView();
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');		
			$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
			$fromdate=$this->input->post('fromdate');
			$fromTime=$this->input->post('fromTime');
			$todate=$this->input->post('todate');
			$toTime=$this->input->post('toTime');
			$getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
                        //return $getVoyNo;
			$data['voysNo']=$getVoyNo;
			$data['fromdate']=$fromdate;
			$data['fromTime']=$fromTime;
			$data['todate']=$todate;
			$data['toTime']=$toTime;
			
			$this->load->view('pangoanDischargeReportPerformDetailView',$data);
		}
		elseif (isset($_POST['summary'])) {
			# summary-button was clicked
			//$this->myExportImExSummeryView();
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
			$fromdate=$this->input->post('fromdate');
			$fromTime=$this->input->post('fromTime');
			$todate=$this->input->post('todate');
			$toTime=$this->input->post('toTime');
			$this->load->model('ci_auth', 'bm', TRUE);
			$getVoyNo = $this->bm->myExportImExSummeryView($ddl_imp_rot_no);
			$data['voysNo']=$getVoyNo;		
			$data['ddl_imp_rot_no']=$ddl_imp_rot_no;		
			$data['fromdate']=$fromdate;
			$data['fromTime']=$fromTime;
			$data['todate']=$todate;
			$data['toTime']=$toTime;
			//echo $data['voysNo'];
			$this->load->view('pangoanDischargeReportPerformSummaryView',$data);
			$this->load->view('myclosebar');
		} 
        }
		
	//Pangoan Loading start
	function pangoanLoadingExportForm()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$data['title']="PANGOAN LOADING EXPORT FORM";
			//echo $data['title'];
			$this->load->view('header2');
			$this->load->view('pangoanLoadingExportForm',$data);
			$this->load->view('footer');
		}	
	}
	
	public function pangoanLoadingExportSummaryDetails()
	{
		if(isset($_POST['detail'])) 
		{
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');		
			$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
			$fromdate=$this->input->post('fromdate');
			$fromTime=$this->input->post('fromTime');
			$todate=$this->input->post('todate');
			$toTime=$this->input->post('toTime');
			
			$sql_voyNo="SELECT sparcsn4.argo_carrier_visit.id AS rtnValue 
			FROM sparcsn4.vsl_vessel_visit_details   
			INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
			WHERE ib_vyg='$ddl_imp_rot_no'";
			
			$getVoyNo = $this->bm->dataReturn($sql_voyNo);
			
			$data['voysNo']=$getVoyNo;
			$data['fromdate']=$fromdate;
			$data['fromTime']=$fromTime;
			$data['todate']=$todate;
			$data['toTime']=$toTime;
			
			$this->load->view('pangoanLoadingExportDetailsView',$data);
		}
		elseif (isset($_POST['summary'])) 
		{
			$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
			$fromdate=$this->input->post('fromdate');
			$fromTime=$this->input->post('fromTime');
			$todate=$this->input->post('todate');
			$toTime=$this->input->post('toTime');
			$this->load->model('ci_auth', 'bm', TRUE);
			
			$sql_voyNo="SELECT sparcsn4.argo_carrier_visit.id AS rtnValue 
			FROM sparcsn4.vsl_vessel_visit_details   
			INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
			WHERE ib_vyg='$ddl_imp_rot_no'";
			
			$getVoyNo = $this->bm->dataReturn($sql_voyNo);
			
			$data['voysNo']=$getVoyNo;		
			$data['ddl_imp_rot_no']=$ddl_imp_rot_no;		
			$data['fromdate']=$fromdate;
			$data['fromTime']=$fromTime;
			$data['todate']=$todate;
			$data['toTime']=$toTime;
		
			$this->load->view('pangoanLoadingExportSummaryView',$data);
			$this->load->view('myclosebar');
		}
	}
	//Pangoan Loading end
	
	//Offhire Summary and Details start
	
	function offhireSummaryAndDetails()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$data['title']="OFFHIRE SUMMARY AND DETAILS";
			
			$this->load->view('header2');
			$this->load->view('offhireSummaryAndDetailsForm',$data);
			$this->load->view('footer');
		}
	}
	
	function offhireSummaryAndDetailsView()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$offhire_date=$this->input->post('offhire_date');
		
			$type=$this->input->post('submit');
			$options=$this->input->post('options');

			if($type=="Summary")
			{
				$sql_offhire_summary="SELECT mlo,NAME,
				COUNT(mty_20_85) AS mty_20_85, 
				COUNT(mty_20_95) AS mty_20_95, 
				COUNT(mty_40_85) AS mty_40_85,
				COUNT(mty_40_95) AS mty_40_95,
				COUNT(mty_45_85) AS mty_45_85,
				COUNT(mty_45_95) AS mty_45_95 
				FROM 
				(SELECT sparcsn4.inv_unit.gkey,r.id AS mlo,Y.name AS NAME, 
				(CASE 
					WHEN 
						((SELECT RIGHT(sparcsn4.ref_equip_type.nominal_height,2) FROM sparcsn4.ref_equip_type
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.eqtyp_gkey=sparcsn4.ref_equip_type.gkey
				INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.eq_gkey=sparcsn4.ref_equipment.gkey
				WHERE sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey)) IN (86,80,40) AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.ref_equip_type
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.eqtyp_gkey=sparcsn4.ref_equip_type.gkey
				INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.eq_gkey=sparcsn4.ref_equipment.gkey
				WHERE sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey) = 20 AND sparcsn4.road_truck_transactions.ctr_freight_kind = 'MTY' 
					THEN 1 
					ELSE NULL 
				END) AS mty_20_85, 
				(CASE 
					WHEN 
						((SELECT RIGHT(sparcsn4.ref_equip_type.nominal_height,2) FROM sparcsn4.ref_equip_type
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.eqtyp_gkey=sparcsn4.ref_equip_type.gkey
				INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.eq_gkey=sparcsn4.ref_equipment.gkey
				WHERE sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey)) IN (96,90) AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.ref_equip_type
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.eqtyp_gkey=sparcsn4.ref_equip_type.gkey
				INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.eq_gkey=sparcsn4.ref_equipment.gkey
				WHERE sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey) = 20 AND sparcsn4.road_truck_transactions.ctr_freight_kind = 'MTY' 
					THEN 1 
					ELSE NULL 
				END) AS mty_20_95, 
				(CASE 
					WHEN ((SELECT RIGHT(sparcsn4.ref_equip_type.nominal_height,2) FROM sparcsn4.ref_equip_type
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.eqtyp_gkey=sparcsn4.ref_equip_type.gkey
				INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.eq_gkey=sparcsn4.ref_equipment.gkey
				WHERE sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey)) IN (86, 80,40) AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.ref_equip_type
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.eqtyp_gkey=sparcsn4.ref_equip_type.gkey
				INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.eq_gkey=sparcsn4.ref_equipment.gkey
				WHERE sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey) = 40 AND sparcsn4.road_truck_transactions.ctr_freight_kind = 'MTY' 
					THEN 1 
					ELSE NULL 
				END) AS mty_40_85, 
				(CASE 
					WHEN ((SELECT RIGHT(sparcsn4.ref_equip_type.nominal_height,2) FROM sparcsn4.ref_equip_type
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.eqtyp_gkey=sparcsn4.ref_equip_type.gkey
				INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.eq_gkey=sparcsn4.ref_equipment.gkey
				WHERE sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey)) IN (96,90) AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.ref_equip_type
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.eqtyp_gkey=sparcsn4.ref_equip_type.gkey
				INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.eq_gkey=sparcsn4.ref_equipment.gkey
				WHERE sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey) = 40 AND sparcsn4.road_truck_transactions.ctr_freight_kind = 'MTY' 
					THEN 1 
					ELSE NULL 
				END) AS mty_40_95, 
				(CASE 
					WHEN ((SELECT RIGHT(sparcsn4.ref_equip_type.nominal_height,2) FROM sparcsn4.ref_equip_type
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.eqtyp_gkey=sparcsn4.ref_equip_type.gkey
				INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.eq_gkey=sparcsn4.ref_equipment.gkey
				WHERE sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey)) IN (86, 80,40) AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.ref_equip_type
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.eqtyp_gkey=sparcsn4.ref_equip_type.gkey
				INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.eq_gkey=sparcsn4.ref_equipment.gkey
				WHERE sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey)>40 AND sparcsn4.road_truck_transactions.ctr_freight_kind = 'MTY' 
					THEN 1 
					ELSE NULL 
				END) AS mty_45_85, 
				(CASE 
					WHEN ((SELECT RIGHT(sparcsn4.ref_equip_type.nominal_height,2) FROM sparcsn4.ref_equip_type
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.eqtyp_gkey=sparcsn4.ref_equip_type.gkey
				INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.eq_gkey=sparcsn4.ref_equipment.gkey
				WHERE sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey)) IN (96,90) AND (SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) FROM sparcsn4.ref_equip_type
				INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.eqtyp_gkey=sparcsn4.ref_equip_type.gkey
				INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.eq_gkey=sparcsn4.ref_equipment.gkey
				WHERE sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey)>40 AND sparcsn4.road_truck_transactions.ctr_freight_kind = 'MTY' 
					THEN 1 
					ELSE NULL 
				END) AS mty_45_95 
				FROM sparcsn4.inv_unit 
				INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey 
				INNER JOIN sparcsn4.road_truck_transactions ON sparcsn4.road_truck_transactions.unit_gkey=sparcsn4.inv_unit.gkey 
				INNER JOIN sparcsn4.road_truck_visit_details ON sparcsn4.road_truck_transactions.truck_visit_gkey=sparcsn4.road_truck_visit_details.tvdtls_gkey 
				INNER JOIN ( sparcsn4.ref_bizunit_scoped r LEFT JOIN ( sparcsn4.ref_agent_representation X 
				LEFT JOIN sparcsn4.ref_bizunit_scoped Y ON X.agent_gkey=Y.gkey ) ON r.gkey=X.bzu_gkey) ON r.gkey = sparcsn4.inv_unit.line_op 
				WHERE sparcsn4.road_truck_visit_details.created >= CONCAT('$offhire_date',' 08:00:00') AND sparcsn4.road_truck_visit_details.created <= CONCAT(ADDDATE('$offhire_date',INTERVAL 1 DAY),' 08:00:00') AND sparcsn4.road_truck_transactions.stage_id='Out Gate' AND road_truck_transactions.status !='CANCEL' AND sparcsn4.road_truck_transactions.ctr_freight_kind='MTY' 
				ORDER BY line_id) AS detail 
				GROUP BY mlo";
				
				if($options=="pdf")
				{
					$this->load->library('m_pdf');
					$pdf->use_kwt = true;

					$pdf = $this->m_pdf->load();
					$pdf->SetWatermarkText('CPA CTMS');
					$pdf->showWatermarkText = true;	
					$rslt_offhire_summary=$this->bm->dataSelect($sql_offhire_summary);

					$this->data['rslt_offhire_summary']=$rslt_offhire_summary;
					
				//	$stylesheet = file_get_contents('resources/styles/truckReport.css'); // external css
					$html=$this->load->view('offhireSummaryPDF',$this->data, true); 

					$pdf->AddPage('P', // L - landscape, P - portrait
								'', '', '', '',
								5, // margin_left
								5, // margin right
								5, // margin top
								5, // margin bottom
								5, // margin header
								5); // margin footer

					$pdf->setFooter('|Page {PAGENO} of {nb}|');   

					$pdf->WriteHTML($stylesheet,1);
					$pdf->WriteHTML($html,2);

					$pdf->Output($pdfFilePath, "I");
				}
				else if($options=="html" or $options=="xl")
				{
					$rslt_offhire_summary=$this->bm->dataSelect($sql_offhire_summary);
				
					$data['rslt_offhire_summary']=$rslt_offhire_summary;
					$data['offhire_date']=$offhire_date;
				
					$this->load->view('offhireSummaryView',$data);
				}
			}
			else if($type=="Details")
			{
				$sql_get_mlo="SELECT DISTINCT r.id AS mlo,Y.name AS concustomername
				FROM sparcsn4.inv_unit
				INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
				INNER JOIN sparcsn4.road_truck_transactions ON sparcsn4.road_truck_transactions.unit_gkey=sparcsn4.inv_unit.gkey
				INNER JOIN sparcsn4.road_truck_visit_details ON sparcsn4.road_truck_transactions.truck_visit_gkey=sparcsn4.road_truck_visit_details.tvdtls_gkey
				INNER JOIN  ( sparcsn4.ref_bizunit_scoped r   
				LEFT JOIN ( sparcsn4.ref_agent_representation X   
				LEFT JOIN sparcsn4.ref_bizunit_scoped Y ON X.agent_gkey=Y.gkey )                
				ON r.gkey=X.bzu_gkey)  ON r.gkey = sparcsn4.inv_unit.line_op
				WHERE sparcsn4.road_truck_visit_details.created >= CONCAT('$offhire_date',' 08:00:00')
				AND sparcsn4.road_truck_visit_details.created <= CONCAT(ADDDATE('$offhire_date',INTERVAL 1 DAY),' 08:00:00')
				AND sparcsn4.road_truck_transactions.stage_id='Out Gate' AND road_truck_transactions.status !='CANCEL'
				AND sparcsn4.road_truck_transactions.ctr_freight_kind='MTY'
				ORDER BY r.id";
				
				if($options=="pdf")
				{
					$this->load->library('m_pdf');
					$pdf->use_kwt = true;

					$pdf = $this->m_pdf->load();
					$pdf->SetWatermarkText('CPA CTMS');
					$pdf->showWatermarkText = true;	
					$rslt_get_mlo=$this->bm->dataSelect($sql_get_mlo);

					$this->data['rslt_get_mlo']=$rslt_get_mlo;
					$this->data['offhire_date']=$offhire_date;
					
				//	$stylesheet = file_get_contents('resources/styles/truckReport.css'); // external css
					$html=$this->load->view('offhireDetailsPDF',$this->data, true); 

					$pdf->AddPage('P', // L - landscape, P - portrait
								'', '', '', '',
								5, // margin_left
								5, // margin right
								5, // margin top
								5, // margin bottom
								5, // margin header
								5); // margin footer

					$pdf->setFooter('|Page {PAGENO} of {nb}|');   

					$pdf->WriteHTML($stylesheet,1);
					$pdf->WriteHTML($html,2);

					$pdf->Output($pdfFilePath, "I");
				}
				else if($options=="html" or $options=="xl")
				{
					$rslt_get_mlo=$this->bm->dataSelect($sql_get_mlo);
				
					$data['rslt_get_mlo']=$rslt_get_mlo;
				
					$data['offhire_date']=$offhire_date;
				
					$this->load->view('offhireDetailsView',$data);
				}	
			}	
		}
	}
	
	//Offhire Summary and Details end
	
	
	//Offdoc information entry form start
	 function myoffDocEntryForm()
         {
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
				{
					$this->logout();
				}
		else
		{
                    //$UserName = $this->session->userdata('User_Name');
                    $data['UserName']=$UserName;
                    $data['msg']="";
                    $data['title']="OFFDOC INFORMATION ENTRY FORM";
                    $this->load->view('header2');
                    $this->load->view('myoffDocEntryFormView',$data);
                    $this->load->view('footer');
				}
                
       }   
           function myoffDocEntryFormPerform()
              {
				$session_id = $this->session->userdata('value');
				if($session_id!=$this->session->userdata('session_id'))
				{
					$this->logout();
				}
				else
				{
                    $offdoc_id=$this->input->post('offdoc_id');
                    $offdoc_code=$this->input->post('offdoc_code');
                    $offdoc_name=$this->input->post('offdoc_name');
                    
                    
                    $insertQuery="insert into ctmsmis.offdoc(id, code, code_ctms, name)values('$offdoc_id','$offdoc_code','$offdoc_code','$offdoc_name')";
                  // ECHO $insertQuery;
                   //return;
                    $offdocInsertStat=$this->bm->dataInsert($insertQuery);
                    if($offdocInsertStat==1)
						{
                        $data['msg']="<font color=green size='2'><nobr>OffDoc Information Inserted Successfully</nobr></font>";
                        }
                    else
                        $data['msg']="<font color=red size='2'><nobr>OffDoc Information Insert Failed</nobr></font>";
                    
                    $UserName = $this->session->userdata('User_Name');
                    $data['title']="OFFDOC INFORMATION ENTRY FORM";
                    $this->load->view('header2');
                    $this->load->view('myoffDocEntryFormView',$data);
                    $this->load->view('footer');
				}
                
      } 
        
	function sh_agent_assignment_Form()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="ALL ASSIGNMENT DETAILS FORM...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('sh_agent_assignment_Form',$data);
				$this->load->view('footer');
			}	
		}
	function sh_agent_assignment_ReportView()
		{
		  
			$fromdate=$this->input->post('fromdate');
			$login_id = $this->session->userdata('login_id');
			//$yard_no=$this->input->post('yard_no'); 
			//$block=$this->input->post('block'); 
			
			$data['fromdate']=$fromdate;
			$data['login_id']=$login_id;
			//$data['yard_no']=$yard_no;
			//$data['block']=$block;
			
			//$data['type']=$type;
			$this->load->view('sh_agent_assignment_ReportView',$data);
			//$this->load->view('yardWiseEmtyContainerReportView',$data);
		   
		  
		   
		   $this->load->view('myclosebar');
  
		}
	
	/*PILOTAGE CERTIFICATE START*/
	function vesselListForPilotage()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$query="SELECT sparcsn4.vsl_vessel_visit_details.vvd_gkey,sparcsn4.vsl_vessels.name,sparcsn4.vsl_vessel_visit_details.ib_vyg,sparcsn4.vsl_vessel_visit_details.ob_vyg,
					LEFT(sparcsn4.argo_carrier_visit.phase,2) AS phase_num,SUBSTR(sparcsn4.argo_carrier_visit.phase,3) AS phase_str,
					sparcsn4.ref_bizunit_scoped.id AS agent
					FROM sparcsn4.argo_carrier_visit
					INNER JOIN sparcsn4.argo_visit_details ON sparcsn4.argo_visit_details.gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
					INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_visit_details.gkey
					INNER JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
					INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.vsl_vessel_visit_details.bizu_gkey
					WHERE sparcsn4.argo_carrier_visit.phase IN ('20INBOUND','30ARRIVED','40WORKING')
					ORDER BY sparcsn4.argo_carrier_visit.phase";
					
				$rtnVesselList = $this->bm->dataSelect($query);
				$data['rtnVesselList']=$rtnVesselList;
					
				$data['title']="VESSEL LIST WITH STATUS...";
				$this->load->view('header5');
				$this->load->view('viewVesselStatusForPilotage',$data);
				$this->load->view('footer_1');
			}
		}
		function viewVesselStatusSearchList()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$rot_num=trim($this->input->post('rot_num'));
				$query="SELECT sparcsn4.vsl_vessel_visit_details.vvd_gkey,sparcsn4.vsl_vessels.name,sparcsn4.vsl_vessel_visit_details.ib_vyg,sparcsn4.vsl_vessel_visit_details.ob_vyg,
					LEFT(sparcsn4.argo_carrier_visit.phase,2) AS phase_num,SUBSTR(sparcsn4.argo_carrier_visit.phase,3) AS phase_str,
					sparcsn4.ref_bizunit_scoped.id AS agent
					FROM sparcsn4.argo_carrier_visit
					INNER JOIN sparcsn4.argo_visit_details ON sparcsn4.argo_visit_details.gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
					INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_visit_details.gkey
					INNER JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
					INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.vsl_vessel_visit_details.bizu_gkey
					WHERE 
					sparcsn4.vsl_vessel_visit_details.ib_vyg='$rot_num'
					ORDER BY sparcsn4.argo_carrier_visit.phase";
					
				$rtnVesselList = $this->bm->dataSelect($query);
				$data['rtnVesselList']=$rtnVesselList;
					
				$data['title']="VESSEL LIST WITH STATUS...";
				$this->load->view('header5');
				$this->load->view('viewVesselStatusForPilotage',$data);
				$this->load->view('footer_1');
			}
		}
		function departureReportOfVessel()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$from_stat=$this->uri->segment(3);
				$data['chk_igm_id']="";
				$ddl_imp_rot_no=str_replace("_","/",$this->uri->segment(4));
				$query_igm="SELECT id as igm_mst_id,Vessel_Name,Name_of_Master,Deck_cargo,Port_of_Destination,flag FROM igm_masters 
						WHERE Import_Rotation_No='$ddl_imp_rot_no'";
				$rtnVesselDetails_igm = $this->bm->dataSelectDb1($query_igm);
				$data['rtnVesselDetails_igm']=$rtnVesselDetails_igm;
				
				$query_n4="SELECT vsl_vessel_visit_details.vvd_gkey,vsl_vessels.radio_call_sign,vsl_vessel_classes.loa_cm,vsl_vessel_classes.gross_registered_ton,
							vsl_vessel_classes.net_registered_ton,ref_bizunit_scoped.name AS localagent,ref_country.cntry_name as flag,
							vsl_vessel_classes.beam_cm
							FROM sparcsn4.vsl_vessels
							INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
							INNER JOIN vsl_vessel_classes ON vsl_vessel_classes.gkey=vsl_vessels.vesclass_gkey
							INNER JOIN ref_bizunit_scoped  ON ref_bizunit_scoped.gkey=vsl_vessels.owner_gkey
							INNER JOIN ref_country ON ref_country.cntry_code=vsl_vessels.country_code
							WHERE  vsl_vessel_visit_details.ib_vyg='$ddl_imp_rot_no'";
							
				$rtnVesselDetails_n4 = $this->bm->dataSelect($query_n4);
				$data['rtnVesselDetails_n4']=$rtnVesselDetails_n4;
				
				$this->load->view('header5');
				if($from_stat=="A")
				{
					$this->load->view('arrivalReportVesselandPilotageCertificateView',$data);
				}
				else if($from_stat=="S")
				{
					
					$this->load->view('shiftingForm',$data);
				}
				else if($from_stat=="D")
				{
					$chk_depart_query = "SELECT igm_id AS igm_id  FROM igm_masters
										INNER JOIN doc_vsl_depart ON  igm_masters.id=doc_vsl_depart.igm_id
										WHERE Import_Rotation_No = '$ddl_imp_rot_no'";
					//echo $chk_depart_query;
					$chkDepart = $this->bm->dataSelectDb1($chk_depart_query);
					$igm_id=$chkDepart[0]['igm_id'];
					if($igm_id>0)
					{						
						$query_depart="SELECT igm_id,vvd_gkey,pilot_name,pilot_on_board,pilot_off_board,pilot_frm,pilot_to,mooring_frm_time,
										mooring_to_time,tug_name,assit_frm,assit_to,atd 
										FROM doc_vsl_depart
										WHERE igm_id=$igm_id";
						
						$rtnVesselDetails_depart = $this->bm->dataSelectDb1($query_depart);
						$getArraivalDt="select IFNULL(ata,'00:00:00') as ata from doc_vsl_arrival where igm_id=$igm_id";
						//echo $getArraivalDt;
						$rtnArrivalDt = $this->bm->dataSelectDb1($getArraivalDt);
						
						$data['rtnVesselDetails_depart']=$rtnVesselDetails_depart;
						$data['chk_igm_id']=$igm_id;
						$data['ata']=$rtnArrivalDt[0]['ata'];
					}
						$this->load->view('viewPilotageCertificateDeparture',$data);
				}
				else if($from_stat=="R")
				{
					
					$igm_id_arraival=0;
					$igm_id_depart=0;
					$igm_id_shift=0;
					
					//$ddl_imp_rot_no=str_replace("_","/",$this->uri->segment(4));;
					$this->load->library('m_pdf');
					$pdf->use_kwt = true;
					$this->data['title']="Pilotage Certificate";
					$this->data['ddl_imp_rot_no']=$ddl_imp_rot_no;
					$pdfFilePath ="PilotageCertificate-".time()."-download.pdf";
					$pdf = $this->m_pdf->load();
					$pdf->SetWatermarkText('CPA CTMS');
					$pdf->showWatermarkText = true;	
					$chk_depart_query = "SELECT igm_id AS igm_id  FROM igm_masters
										INNER JOIN doc_vsl_depart ON  igm_masters.id=doc_vsl_depart.igm_id
										WHERE Import_Rotation_No = '$ddl_imp_rot_no'";
					//echo $chk_depart_query;
					$chkDepart = $this->bm->dataSelectDb1($chk_depart_query);
					$igm_id_depart=$chkDepart[0]['igm_id'];
					
					$chk_arrival_query = "SELECT igm_id AS igm_id  FROM igm_masters
										INNER JOIN doc_vsl_arrival ON  igm_masters.id=doc_vsl_arrival.igm_id
										WHERE Import_Rotation_No = '$ddl_imp_rot_no'";
					//echo $chk_depart_query;
					$chkArrival = $this->bm->dataSelectDb1($chk_arrival_query);
					
					$igm_id_arraival=$chkArrival[0]['igm_id'];
					
					$chk_shift_query = "SELECT igm_id AS igm_id  FROM igm_masters
										INNER JOIN doc_vsl_shift ON  igm_masters.id=doc_vsl_shift.igm_id
										WHERE Import_Rotation_No = '$ddl_imp_rot_no'";
					//echo $chk_depart_query;
					$chkShift = $this->bm->dataSelectDb1($chk_shift_query);
					
					$igm_id_shift=$chkShift[0]['igm_id'];
					
					if($igm_id_depart>0)
					{
						$query_igm="SELECT id as igm_mst_id,Vessel_Name,Name_of_Master,Deck_cargo,Port_of_Destination,flag FROM igm_masters 
						WHERE Import_Rotation_No='$ddl_imp_rot_no'";
						//echo $query_igm;
						$rtnVesselDetails_igm = $this->bm->dataSelectDb1($query_igm);
						$this->data['rtnVesselDetails_igm']=$rtnVesselDetails_igm;
						
						$query_n4="SELECT vsl_vessel_visit_details.vvd_gkey,vsl_vessels.radio_call_sign,vsl_vessel_classes.loa_cm,vsl_vessel_classes.gross_registered_ton,
									vsl_vessel_classes.net_registered_ton,ref_bizunit_scoped.name AS localagent,ref_country.cntry_name as flag,
									vsl_vessel_classes.beam_cm
									FROM sparcsn4.vsl_vessels
									INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
									INNER JOIN vsl_vessel_classes ON vsl_vessel_classes.gkey=vsl_vessels.vesclass_gkey
									INNER JOIN ref_bizunit_scoped  ON ref_bizunit_scoped.gkey=vsl_vessels.owner_gkey
									INNER JOIN ref_country ON ref_country.cntry_code=vsl_vessels.country_code
									WHERE  vsl_vessel_visit_details.ib_vyg='$ddl_imp_rot_no'";
									
						$rtnVesselDetails_n4 = $this->bm->dataSelect($query_n4);
						$this->data['rtnVesselDetails_n4']=$rtnVesselDetails_n4;
						
						$query_depart="SELECT igm_id,vvd_gkey,pilot_name,pilot_on_board,pilot_off_board,pilot_frm,pilot_to,mooring_frm_time,
										mooring_to_time,tug_name,assit_frm,assit_to,atd,DATE(pilot_on_board) as sign_depart,aditional_tug+1 as aditional_tug 
										FROM doc_vsl_depart
										WHERE igm_id=$igm_id_depart";
						
						$rtnVesselDetails_depart = $this->bm->dataSelectDb1($query_depart);
						$getArraivalDt="select IFNULL(ata,'00:00:00') as ata from doc_vsl_arrival where igm_id=$igm_id_depart";
						//echo $getArraivalDt;
						$rtnArrivalDt = $this->bm->dataSelectDb1($getArraivalDt);						
						$this->data['rtnVesselDetails_depart']=$rtnVesselDetails_depart;						
						$this->data['ata']=$rtnArrivalDt[0]['ata'];
						$this->data['chk_igm_id']=$igm_id_depart;
					}
					if($igm_id_arraival>0)
					{
						$query42="SELECT id,Vessel_Name,Name_of_Master,grt,nrt,Deck_cargo,loa_cm,Port_of_Destination,radio_call_sign,flag FROM igm_masters 
							WHERE Import_Rotation_No='$ddl_imp_rot_no'";
						 
						$rtnVesselDetails_igm = $this->bm->dataSelectDb1($query42);
						$this->data['rtnVesselDetails_igm']=$rtnVesselDetails_igm ;
				//        echo $rtnVesselDetails_igm[0]['Vessel_Name'];
				//        echo $query42;
				//        return;
						$query21="SELECT vsl_vessel_visit_details.vvd_gkey,vsl_vessels.name,vsl_vessels.radio_call_sign,vsl_vessel_classes.loa_cm,vsl_vessel_classes.gross_registered_ton,vsl_vessel_classes.net_registered_ton,ref_bizunit_scoped.name AS localagent,ref_country.cntry_name
						FROM sparcsn4.vsl_vessels
						INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
						INNER JOIN vsl_vessel_classes ON vsl_vessel_classes.gkey=vsl_vessels.vesclass_gkey
						INNER JOIN ref_bizunit_scoped  ON ref_bizunit_scoped.gkey=vsl_vessels.owner_gkey
						INNER JOIN ref_country ON ref_country.cntry_code=vsl_vessels.country_code
						WHERE  vsl_vessel_visit_details.ib_vyg='$ddl_imp_rot_no'";
						 
						$rtnVesselDetails_n4 = $this->bm->dataSelect($query21);       
						$this->data['rtnVesselDetails_n4']=$rtnVesselDetails_n4;
						
						
						$vvdGkey=$rtnVesselDetails_n4[0]['vvd_gkey'];
						$vsl_arrival_str="select igm_id, vvd_gkey, pilot_name, pilot_on_board, pilot_off_board, pilot_frm, pilot_to, 
								 mooring_frm_time, mooring_to_time, tug_name, assit_frm, assit_to, oa_dt, oa_dt, ata,
								 DATE(pilot_on_board) as sign_arraival,aditional_tug+1 as aditional_tug from 
								 cchaportdb.doc_vsl_arrival where vvd_gkey='$vvdGkey'";
						$rtn_vsl_arrival_info = $this->bm->dataSelectDb1($vsl_arrival_str);
						$this->data['rtn_vsl_arrival_info']=$rtn_vsl_arrival_info ;
					}
					if($igm_id_shift>0)
					{
						//igm start
						$sql_shifting_one="SELECT id,Vessel_Name,Name_of_Master,grt,nrt,Deck_cargo,loa_cm,Port_of_Destination,radio_call_sign,flag 
						FROM igm_masters 
						WHERE Import_Rotation_No='$ddl_imp_rot_no'";
						
						$rtnVesselDetails_igm=$this->bm->dataSelectDb1($sql_shifting_one);
						//igm end
						
						//inserted data start
						$shift_igm_id=$rtnVesselDetails_igm[0]['id'];
						
						$sql_show_current_data="SELECT pilot_name,pilot_on_board,pilot_off_board,shift_frm,shift_to,mooring_frm_time,
						mooring_to_time,tug_name,assit_frm,assit_to,shift_dt,DATE(pilot_on_board) as sign_shift,aditional_tug+1 as aditional_tug 
						FROM doc_vsl_shift 
						WHERE igm_id='$shift_igm_id'";
						
						$rslt_show_current_data=$this->bm->dataSelectDb1($sql_show_current_data);
					
						//inserted data end
						
						//get n4 data - start
						$sql_shifting_two="SELECT sparcsn4.vsl_vessel_visit_details.vvd_gkey,sparcsn4.vsl_vessels.radio_call_sign,vsl_vessel_classes.loa_cm,vsl_vessel_classes.gross_registered_ton,
						vsl_vessel_classes.net_registered_ton,ref_bizunit_scoped.name AS localagent
						FROM sparcsn4.vsl_vessels
						INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
						INNER JOIN sparcsn4.vsl_vessel_classes ON sparcsn4.vsl_vessel_classes.gkey=sparcsn4.vsl_vessels.vesclass_gkey
						INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.vsl_vessels.owner_gkey
						WHERE sparcsn4.vsl_vessel_visit_details.ib_vyg='$ddl_imp_rot_no'";
						
						$rtnVesselDetails_n4=$this->bm->dataSelect($sql_shifting_two);

						//get n4 data - end
						
						$this->data['rtnVesselDetails_igm']=$rtnVesselDetails_igm;
						$this->data['rslt_show_current_data']=$rslt_show_current_data;
						$this->data['rtnVesselDetails_n4']=$rtnVesselDetails_n4;
					}
					
					$this->data['igm_id_arraival']=$igm_id_arraival;
					$this->data['igm_id_shift']=$igm_id_shift;					
					$this->data['igm_id_depart']=$igm_id_depart;
					
					$html=$this->load->view('pilotageCertificateReport',$this->data, true);
					$stylesheet = file_get_contents('resources/styles/test.css'); // external css
					$pdf->useSubstitutions = true; // optional - just as an example
							
					$pdf->AddPage('P', // L - landscape, P - portrait
										'', '', '', '',
										5, // margin_left
										5, // margin right
										5, // margin top
										5, // margin bottom
										5, // margin header
										5); // margin footer
					$pdf->setFooter('Developed By : DataSoft|Page {PAGENO} of {nb}|Date {DATE j-m-Y}');
							
					$pdf->WriteHTML($stylesheet,1);
					$pdf->WriteHTML($html,2);
							//$pdf->WriteHTML($scriptSheet,3);
					$pdf->Output($pdfFilePath, "I"); // For Show Pdf
				}
				$this->load->view('footer_1');
				
				//echo $ddl_imp_rot_no;
			}
		}
		function shifting_insert()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$shift_rotation=$this->input->post('shift_rotation');
				
				$shift_igm_id=$this->input->post('shift_igm_id');
				$shift_vvd_gkey=$this->input->post('shift_vvd_gkey');
				
				$shift_name_of_pilot=$this->input->post('shift_name_of_pilot');
				$shift_boarded_at=$this->input->post('shift_boarded_at');
				$shift_left_at=$this->input->post('shift_left_at');
				
				$shift_shifted_from=$this->input->post('shift_shifted_from');		
				$shift_shifted_to=$this->input->post('shift_shifted_to');
				
				$shift_mooring_unmooring_from=$this->input->post('shift_mooring_unmooring_from');
				$shift_mooring_unmooring_to=$this->input->post('shift_mooring_unmooring_to');		
				$shift_mooring_unmooring_date=$this->input->post('shift_mooring_unmooring_date');
				
				$shift_cpa_tug=$this->input->post('shift_cpa_tug');
				$shift_assistance_from=$this->input->post('shift_assistance_from');		
				$shift_assistance_to=$this->input->post('shift_assistance_to');
				$shift_assistance_date=$this->input->post('shift_assistance_date');
				
				//update - start
				$insert_update_msg="";
				
				$sql_cnt_show_current_data="SELECT COUNT(*) AS rtnValue FROM doc_vsl_shift WHERE igm_id='$shift_igm_id'";
				
				$cnt_show_current_data=$this->bm->dataReturnDb1($sql_cnt_show_current_data);
				
				if($cnt_show_current_data==1)
				{
					$sql_shifting_update="UPDATE doc_vsl_shift
					SET vvd_gkey='$shift_vvd_gkey',pilot_name='$shift_name_of_pilot',pilot_on_board='$shift_boarded_at',pilot_off_board='$shift_left_at',shift_frm='$shift_shifted_from',shift_to='$shift_shifted_to',mooring_frm_time='$shift_mooring_unmooring_from',mooring_to_time='$shift_mooring_unmooring_to',tug_name='$shift_cpa_tug',assit_frm='$shift_assistance_from',assit_to='$shift_assistance_to',shift_dt='$shift_mooring_unmooring_date'
					WHERE igm_id='$shift_igm_id'";
					
					$rslt_shifting_update=$this->bm->dataUpdateDB1($sql_shifting_update);
					
					if($rslt_shifting_update==1)
						$insert_update_msg="Data successfully updated";
				}
				//update - end
				//insert - start
				else
				{
					$sql_shifting_insert="INSERT INTO doc_vsl_shift(igm_id,vvd_gkey,pilot_name,pilot_on_board,pilot_off_board,shift_frm,shift_to,mooring_frm_time,mooring_to_time,tug_name,assit_frm,assit_to,shift_dt)
					VALUES('$shift_igm_id','$shift_vvd_gkey','$shift_name_of_pilot','$shift_boarded_at','$shift_left_at','$shift_shifted_from','$shift_shifted_to','$shift_mooring_unmooring_from','$shift_mooring_unmooring_to','$shift_cpa_tug','$shift_assistance_from','$shift_assistance_to','$shift_mooring_unmooring_date'))";
					
					$rslt_shifting_insert=$this->bm->dataInsertDB1($sql_shifting_insert);
					
					if($rslt_shifting_insert==1)
						$insert_update_msg="Data successfully inserted";
				}
				//insert - end
				
			//load previous data - start
				//get igm data - start
				$sql_shifting_one="SELECT id,Vessel_Name,Name_of_Master,grt,nrt,Deck_cargo,loa_cm,Port_of_Destination,radio_call_sign,flag 
				FROM igm_masters 
				WHERE Import_Rotation_No='$shift_rotation'";
				
				$rtnVesselDetails_igm=$this->bm->dataSelectDb1($sql_shifting_one);
				
				$data['rtnVesselDetails_igm']=$rtnVesselDetails_igm;
				//get igm data - end
				
				//check if previous data is available - start
			//	$igm_id=$rtnVesselDetails_igm[0]['id'];
				
				$sql_cnt_show_current_data="SELECT COUNT(*) AS rtnValue FROM doc_vsl_shift WHERE igm_id='$shift_igm_id'";
				
				$cnt_show_current_data=$this->bm->dataReturnDb1($sql_cnt_show_current_data);
				
				if($cnt_show_current_data==1)
				{
					$sql_show_current_data="SELECT pilot_name,pilot_on_board,pilot_off_board,shift_frm,shift_to,mooring_frm_time,mooring_to_time,tug_name,assit_frm,assit_to,shift_dt FROM doc_vsl_shift WHERE igm_id='$shift_igm_id'";
					
					$rslt_show_current_data=$this->bm->dataSelectDb1($sql_show_current_data);
					
					$data['rslt_show_current_data']=$rslt_show_current_data;
				}
				//check if previous data is available - end
				
				//get n4 data - start
				$sql_shifting_two="SELECT sparcsn4.vsl_vessel_visit_details.vvd_gkey,sparcsn4.vsl_vessels.radio_call_sign,vsl_vessel_classes.loa_cm,vsl_vessel_classes.gross_registered_ton,
				vsl_vessel_classes.net_registered_ton,ref_bizunit_scoped.name AS localagent
				FROM sparcsn4.vsl_vessels
				INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
				INNER JOIN sparcsn4.vsl_vessel_classes ON sparcsn4.vsl_vessel_classes.gkey=sparcsn4.vsl_vessels.vesclass_gkey
				INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.vsl_vessels.owner_gkey
				WHERE sparcsn4.vsl_vessel_visit_details.ib_vyg='$shift_rotation'";
				
				$rtnVesselDetails_n4=$this->bm->dataSelect($sql_shifting_two);

				$data['rtnVesselDetails_n4']=$rtnVesselDetails_n4;
				//get n4 data - end
			//load previous data - end
				
				$data['insert_update_msg']=$insert_update_msg;
				$data['shift_rotation']=$shift_rotation;
							
				$this->load->view('header5');
				$this->load->view('shiftingForm',$data);
				$this->load->view('footer_1');
			}
		}
		function departureOfVesselEntry()
		{
			$d_igm_mst_id=trim($this->input->post('d_igm_mst_id'));
			$d_vvd_gkey=trim($this->input->post('d_vvd_gkey'));
			$d_name_pilot=trim($this->input->post('d_name_pilot'));
			$d_board_at=trim($this->input->post('d_board_at'));
			$d_left_at=trim($this->input->post('d_left_at'));
			$d_pilotage_from=trim($this->input->post('d_pilotage_from'));
			$d_pilotage_to=trim($this->input->post('d_pilotage_to'));
			$d_time_unmoor_from=trim($this->input->post('d_time_unmoor_from'));
			$d_time_unmoor_to=trim($this->input->post('d_time_unmoor_to'));
			$d_cpa_tug=trim($this->input->post('d_cpa_tug'));
			$d_assist_from=trim($this->input->post('d_assist_from'));
			$d_assist_to=trim($this->input->post('d_assist_to'));
			$d_dt_of_depart=trim($this->input->post('d_dt_of_depart'));
			
			if($d_igm_mst_id!="")
			{
				if($d_name_pilot!="")
				{
					$chk_depart_query = "select 1 as stat from doc_vsl_depart where igm_id=$d_igm_mst_id";
					$chkDepart = $this->bm->dataSelectDb1($chk_depart_query);
					
					if($chkDepart[0]['stat']==1)
					{
						$depart_query="UPDATE doc_vsl_depart
										SET pilot_name='$d_name_pilot',pilot_on_board='$d_board_at',
										pilot_off_board='$d_left_at',pilot_frm='$d_pilotage_from',pilot_to='$d_pilotage_to',
										mooring_frm_time='$d_time_unmoor_from',
										mooring_to_time='$d_time_unmoor_to',tug_name='$d_cpa_tug',assit_frm='$d_assist_from',assit_to='$d_assist_to',atd='$d_dt_of_depart'
										WHERE igm_id=$d_igm_mst_id
									";
						$data['msg']="<b><font color='green'>Successfully Updated.</font></b>";
					}
					else
					{
						$depart_query="INSERT INTO doc_vsl_depart(igm_id,vvd_gkey,pilot_name,pilot_on_board,
									pilot_off_board,pilot_frm,pilot_to,mooring_frm_time,
									mooring_to_time,tug_name,assit_frm,assit_to,atd) 
									VALUES ($d_igm_mst_id,$d_vvd_gkey,'$d_name_pilot','$d_board_at','$d_left_at','$d_pilotage_from','$d_pilotage_to',
									'$d_time_unmoor_from','$d_time_unmoor_to','$d_cpa_tug','$d_assist_from','$d_assist_to','$d_dt_of_depart')";
						
						$data['msg']="<b><font color='green'>Successfully Inserted.</font></b>";
					}
					$rslt_shifting_insert=$this->bm->dataInsertDB1($depart_query);
					
					if($rslt_shifting_insert <=0)
					{
						//$data['msg']="Successfully Not Inserted.";
						$data['msg']="<b><font color='red'>Data Not Inserted.</font></b>";
					}
				}
				else
				{
					$data['msg']="<b><font color='red'>Pilot Name Required.</font></b>";
				}
			}
			else{
				$data['msg']="<b><font color='red'>IGM Information Problem.</font></b>";
			}
			/* Get Data When From Reload*/
			$get_rotation_query = "SELECT Import_Rotation_No AS Import_Rotation_No  FROM igm_masters
									WHERE id = $d_igm_mst_id";
			//echo $chk_depart_query;
			$rtnRotation = $this->bm->dataSelectDb1($get_rotation_query);
			$ddl_imp_rot_no=$rtnRotation[0]['Import_Rotation_No'];
			$data['chk_igm_id']="";
			//$ddl_imp_rot_no=str_replace("_","/",$this->uri->segment(4));
			$query_igm="SELECT id as igm_mst_id,Vessel_Name,Name_of_Master,Deck_cargo,Port_of_Destination,flag FROM igm_masters 
						WHERE Import_Rotation_No='$ddl_imp_rot_no'";
			$rtnVesselDetails_igm = $this->bm->dataSelectDb1($query_igm);
			$data['rtnVesselDetails_igm']=$rtnVesselDetails_igm;
				
			$query_n4="SELECT vsl_vessel_visit_details.vvd_gkey,vsl_vessels.radio_call_sign,vsl_vessel_classes.loa_cm,vsl_vessel_classes.gross_registered_ton,
						vsl_vessel_classes.net_registered_ton,ref_bizunit_scoped.name AS localagent,ref_country.cntry_name as flag
						FROM sparcsn4.vsl_vessels
						INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
						INNER JOIN vsl_vessel_classes ON vsl_vessel_classes.gkey=vsl_vessels.vesclass_gkey
						INNER JOIN ref_bizunit_scoped  ON ref_bizunit_scoped.gkey=vsl_vessels.owner_gkey
						INNER JOIN ref_country ON ref_country.cntry_code=vsl_vessels.country_code
						WHERE  vsl_vessel_visit_details.ib_vyg='$ddl_imp_rot_no'";
							
			$rtnVesselDetails_n4 = $this->bm->dataSelect($query_n4);
			$data['rtnVesselDetails_n4']=$rtnVesselDetails_n4;
			
			$chk_depart_query = "SELECT igm_id AS igm_id  FROM igm_masters
										INNER JOIN doc_vsl_depart ON  igm_masters.id=doc_vsl_depart.igm_id
										WHERE Import_Rotation_No = '$ddl_imp_rot_no'";
			//echo $chk_depart_query;
			$chkDepart = $this->bm->dataSelectDb1($chk_depart_query);
			$igm_id=$chkDepart[0]['igm_id'];
			if($igm_id>0)
			{						
				$query_depart="SELECT igm_id,vvd_gkey,pilot_name,pilot_on_board,pilot_off_board,pilot_frm,pilot_to,mooring_frm_time,
								mooring_to_time,tug_name,assit_frm,assit_to,atd 
								FROM doc_vsl_depart
								WHERE igm_id=$igm_id";
						
				$rtnVesselDetails_depart = $this->bm->dataSelectDb1($query_depart);
				$getArraivalDt="select IFNULL(ata,'00:00:00') as ata from doc_vsl_arrival where igm_id=$igm_id";
						//echo $getArraivalDt;
				$rtnArrivalDt = $this->bm->dataSelectDb1($getArraivalDt);
					
				$data['rtnVesselDetails_depart']=$rtnVesselDetails_depart;
				$data['chk_igm_id']=$igm_id;
				$data['ata']=$rtnArrivalDt[0]['ata'];
			}
			/* Get Data When From Reload*/
			$this->load->view('header5');
			$this->load->view('viewPilotageCertificateDeparture',$data);
			$this->load->view('footer_1');

		}
		function saveArrivalReportVesselandPilotageCertificateInfo()
		  {
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
			 $this->logout();
			}
			else
			{
		//     boardedTime leftTime  pilotageFrom pilotageTo mooringTimeFrm mooringTimeTo
		//                                cpaTugName cpaTugAssisFrm cpaTugAssisTo arrivalOuterAnchorageDate
		//        fwDraftMax motherVesselName anchoaragePortLimit dangerCargo
			   // $tbl=$this->input->post('tbl');
			//$ipaddr = $_SERVER['REMOTE_ADDR'];
			//$login_id = $this->session->userdata('login_id'); igmId vvdGkey
				$igmId=$this->input->post('igmId');
				$vvdGkey=$this->input->post('vvdGkey');
			$pilotName=$this->input->post('pilotName');
				$boardedTime=$this->input->post('boardedTime');	
				$leftTime=$this->input->post('leftTime');	
				$pilotageFrom=$this->input->post('pilotageFrom');	
				$pilotageTo=$this->input->post('pilotageTo');	
				$mooringTimeFrm=$this->input->post('mooringTimeFrm');	
				$mooringTimeTo=$this->input->post('mooringTimeTo');	
				$cpaTugName=$this->input->post('cpaTugName');	
				$cpaTugAssisFrm=$this->input->post('cpaTugAssisFrm');	
				$cpaTugAssisTo=$this->input->post('cpaTugAssisTo');	
				$arrivalOuterAnchorageDate=$this->input->post('arrivalOuterAnchorageDate');
				$arrivalDate=$this->input->post('arrivalDate');
				$fwDraftMax=$this->input->post('fwDraftMax');	
				$motherVesselName=$this->input->post('motherVesselName');	
				$anchoaragePortLimit=$this->input->post('anchoaragePortLimit');	
				$dangerCargo=$this->input->post('dangerCargo');	
				
				$ddl_imp_rot_no=$this->input->post('rotation');	
				$data['rotation']=$ddl_imp_rot_no;
				
				$findQuery="Select igm_id as rtnValue from doc_vsl_arrival where igm_id=$igmId";
				$find_IGM=$this->bm->dataReturnDb1($findQuery);
			if($find_IGM!="")
				{
					 $strUpdate="UPDATE doc_vsl_arrival SET pilot_name='$pilotName', pilot_on_board='$boardedTime',pilot_off_board='$leftTime',
							pilot_frm='$pilotageFrom', pilot_to='$pilotageTo', mooring_frm_time='$mooringTimeFrm', mooring_to_time='$mooringTimeTo',
							tug_name='$cpaTugName', assit_frm='$cpaTugAssisFrm', assit_to='$cpaTugAssisTo', oa_dt='$arrivalOuterAnchorageDate',
							ata='$arrivalDate' WHERE igm_id='$igmId'";
					$updateStat = $this->bm->dataUpdateDB1($strUpdate);
					
				   // echo $strUpdate;
				   // return;
					if($updateStat==1)
					{
						$data['msg']="<font color=green>Information Updated Successfully</font>";
					}
					else
					   $data['msg']="<font color=red>Information not Updated.</font>";       
					
				}
				else
				{
					$str = "insert into doc_vsl_arrival(igm_id, vvd_gkey, pilot_name, pilot_on_board, pilot_off_board, pilot_frm,
						pilot_to, mooring_frm_time, mooring_to_time, tug_name, assit_frm, assit_to, oa_dt, ata)
						values('$igmId','$vvdGkey','$pilotName','$boardedTime','$leftTime','$pilotageFrom','$pilotageTo','$mooringTimeFrm',
							'$mooringTimeTo','$cpaTugName','$cpaTugAssisFrm','$cpaTugAssisTo','$arrivalOuterAnchorageDate','$arrivalDate')";

					$stat = $this->bm->dataInsertDB1($str);
					if($stat==1)
					{
						$data['msg']="<font color=green>Information Saved Successfully</font>";
					}
					else
					   $data['msg']="<font color=red>Information not Saved.</font>";
				   
				}
				
				//Information show start
				 $query42="SELECT id,Vessel_Name,Name_of_Master,grt,nrt,Deck_cargo,loa_cm,Port_of_Destination,radio_call_sign,flag FROM igm_masters 
					WHERE Import_Rotation_No='$ddl_imp_rot_no'";
				 
				$rtnVesselDetails_igm = $this->bm->dataSelectDb1($query42);
				$data['rtnVesselDetails_igm']=$rtnVesselDetails_igm ;
		//        echo $rtnVesselDetails_igm[0]['Vessel_Name'];
		//        echo $query42;
		//        return;
				$query21="SELECT vsl_vessel_visit_details.vvd_gkey,vsl_vessels.name,vsl_vessels.radio_call_sign,vsl_vessel_classes.loa_cm,vsl_vessel_classes.gross_registered_ton,vsl_vessel_classes.net_registered_ton,ref_bizunit_scoped.name AS localagent,ref_country.cntry_name
				FROM sparcsn4.vsl_vessels
				INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
				INNER JOIN vsl_vessel_classes ON vsl_vessel_classes.gkey=vsl_vessels.vesclass_gkey
				INNER JOIN ref_bizunit_scoped  ON ref_bizunit_scoped.gkey=vsl_vessels.owner_gkey
				INNER JOIN ref_country ON ref_country.cntry_code=vsl_vessels.country_code
				WHERE  vsl_vessel_visit_details.ib_vyg='$ddl_imp_rot_no'";
				 
				$rtnVesselDetails_n4 = $this->bm->dataSelect($query21);       
				$data['rtnVesselDetails_n4']=$rtnVesselDetails_n4;
				
				
				$vvdGkey=$rtnVesselDetails_n4[0]['vvd_gkey'];
				$vsl_arrival_str="select igm_id, vvd_gkey, pilot_name, pilot_on_board, pilot_off_board, pilot_frm, pilot_to,
						 mooring_frm_time, mooring_to_time, tug_name, assit_frm, assit_to, oa_dt, oa_dt, ata from 
						 cchaportdb.doc_vsl_arrival where vvd_gkey='$vvdGkey'";
				$rtn_vsl_arrival_info = $this->bm->dataSelectDb1($vsl_arrival_str);
				$data['rtn_vsl_arrival_info']=$rtn_vsl_arrival_info ;
				
				   //Information show end
				
		//        $data['rtnVesselDetails_n4']="";
		//        $data['rtnVesselDetails_igm']="";
				$data['title']="VESSEL LIST WITH STATUS...";
				$this->load->view('header5');
				$this->load->view('arrivalReportVesselandPilotageCertificateView',$data);
				$this->load->view('footer_1');
			}
  }
	/*PILOTAGE CERTIFICATE END*/
	
	/*C & F PANEL ALL ASSIGNMENT  */
	function cf_agent_assignment_Form()
  {
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="ALL ASSIGNMENT DETAILS FORM...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('cf_agent_assignment_Form',$data);
				$this->load->view('footer');
			}	
  }
  
  	function cf_agent_assignment_ReportView()
	{
	  
		$fromdate=$this->input->post('fromdate');
		$login_id = $this->session->userdata('login_id');
		$n4_bizu_gkey = $this->session->userdata('n4_bizu_gkey');
		//$yard_no=$this->input->post('yard_no'); 
		//$block=$this->input->post('block'); 
		
		$data['fromdate']=$fromdate;
		$data['login_id']=$login_id;
		$data['n4_bizu_gkey']=$n4_bizu_gkey;
		//$data['yard_no']=$yard_no;
		//$data['block']=$block;
		
		//$data['type']=$type;
	   $cnfsql="SELECT u_name AS rtnValue FROM users WHERE login_id='$login_id'";
		$cnfName= $this->bm->dataReturnDb1($cnfsql);
		$data['cnfName']=$cnfName;
		$this->load->view('cf_agent_assignment_ReportView',$data);
		//$this->load->view('yardWiseEmtyContainerReportView',$data);
	   
	  
	   
	   $this->load->view('myclosebar');

	}
  
	//container handling report monthly - start
	function containerHandlingRptMonthlyForm()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{  
			$data['title']="MONTHLY CONTAINER HANDLING REPORT...";

			$this->load->view('header2');
			$this->load->view('myReportContainerHandlingMonthly',$data);
			$this->load->view('footer');
		}	
	}
	
	function containerHandlingMonthlyView()
	{
		$session_id = $this->session->userdata('value');
		$this->load->library('m_pdf');
		$pdf->use_kwt = true;
		$this->data['title']="CONTAINER HANDLING REPORT";
		
		$search_value=$this->input->post('search_value');
		$from_date=$this->input->post('from_date');
		$to_date=$this->input->post('to_date');
			
		$this->data['search_value']=$search_value;
		$this->data['from_date']=$from_date;
		$this->data['to_date']=$to_date;
			
		$html=$this->load->view('myReportContainerHandlingMonthlyList',$this->data, true); 
					 
		$pdfFilePath ="myReportContainerHandlingMonthlyList_rpt-".time()."-download.pdf";

		$pdf = $this->m_pdf->load();
		$pdf->SetWatermarkText('CPA CTMS');
		$pdf->showWatermarkText = true;	
			
		$pdf->setFooter('Developed By : DataSoft|Page {PAGENO} of {nb}|Date {DATE j-m-Y}');
		$pdf->WriteHTML($html,2);
						 
		$pdf->Output($pdfFilePath, "I"); // For Show Pdf	
	}
	//container handling report monthly - end
	// Chairman Panel
	function vslDtlForChairmanView()
	{
		
		//$UserName = $this->session->userdata('User_Name');
		//$data['UserName']=$UserName;
		$this->load->view('vslDtlForChairman');
		$this->load->view('myclosebar');
	}
	function gateDtlForChairmanView()
	{
			
		//$UserName = $this->session->userdata('User_Name');
		//$data['UserName']=$UserName;
		$this->load->view('gateDtlForChairmanView');
		$this->load->view('myclosebar');
	}
	
		function jettySarkarEntryForm()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="JETTY SARKAR ENTRY FORM...";
				$data['msg']="";
				
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('jettySarkarEntryFormView',$data);
				$this->load->view('footer');
			}	
			
		}
		
	// function jettySarkarEntryFormPerform()
		// {
			// $login_id = $this->session->userdata('login_id');
			// $n4_bizu_gkey = $this->session->userdata('n4_bizu_gkey');
			// $ipaddr = $_SERVER['REMOTE_ADDR'];
				// //jsName  jsLicenseNo jsContact jsAddress
			// $jsName=$this->input->post('jsName');
			// $jsLicenseNo=$this->input->post('jsLicenseNo');
			// $jsContact=$this->input->post('jsContact');
			// $jsAddress=$this->input->post('jsAddress');

			// $jsAddress=$this->input->post('jsAddress');
			// $upStr=$this->input->post('updateFlag');
			// if($upStr=="update")
			// {
				// $jettyId=$this->input->post('jettyId');
				// $updateQuery="update ctmsmis.mis_jetty_sirkar set js_name='$jsName', js_lic_no='$jsLicenseNo', cell_no='$jsContact',
								// adress='$jsAddress', last_update= now(), update_by='$login_id', user_ip='$ipaddr' where id='$jettyId'";
				// //echo $updateQuery;
				// //return;
				// $updateStat=$this->bm->dataUpdate($updateQuery);		
				// if($updateStat==1)
				// {
                // $data['msg']="<font color=green size='3'><nobr> Information Updated Successfully</nobr></font>";
                // }
				// else
					// $data['msg']="<font color=red size='3'><nobr> Information Update Failed</nobr></font>";
			// }	
				
			// else
			// {
				// $jsSql="select count(*) as rtnValue from ctmsmis.mis_jetty_sirkar where  n4_bizu_gkey='$n4_bizu_gkey' and js_lic_no='$jsLicenseNo'";	
				// $stat=$this->bm->dataReturn($jsSql);
				// if($stat==1)
				// {
					 // $data['msg']="<font color=red size='3'><nobr> This Jetty Sarkar Information already entered.</nobr></font>";
				// }
				// else
				// {				
				// error_reporting(E_ALL ^ E_NOTICE);   
    
                // $fileName=str_replace('-','',$jsLicenseNo);
				// $fi=$fileName.".jpg";
				
				// $sign=$_POST["sign"];
				
					
				// if ($_FILES["sign"]["error"] > 0 )
				// {
						// $data['msg']="<font color='red' size=4>Here is Problem!! To upload this file. Please! Check Again, That file is not Corrupted and ensure correct format</font>";
				// }
				// else
				// {
					// move_uploaded_file($_FILES["sign"]["tmp_name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/images/jetty_sarkar_signature_files/".$_FILES["sign"]["name"]);			
					// rename($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/images/jetty_sarkar_signature_files/".$_FILES["sign"]["name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/images/jetty_sarkar_signature_files/".$fi);
					 
					
					// $insertQuery="insert into ctmsmis.mis_jetty_sirkar(n4_bizu_gkey, js_name, signature_path, js_lic_no, cell_no, adress, last_update, update_by,
									// user_ip)values('$n4_bizu_gkey','$jsName', '$fi', '$jsLicenseNo','$jsContact','$jsAddress', now(),'$login_id', '$ipaddr')";
					// //   ECHO $insertQuery;
					   // //return;
					// $infoInsertStat=$this->bm->dataInsert($insertQuery);
					// if($infoInsertStat==1)
						// {
						// $data['msg']="<font color=green size='3'><nobr> Information Inserted Successfully</nobr></font>";
						// }
					// else
						// $data['msg']="<font color=red size='3'><nobr> Information Insert Failed</nobr></font>";
					// }
				// }
			// }
			// $data['title']="JETTY SARKAR ENTRY FORM...";
			// $this->load->view('header2');
			// $this->load->view('jettySarkarEntryFormView',$data);
			// $this->load->view('footer');
		// }
		
	function jettySarkarEntryFormPerform()
	{
		$login_id = $this->session->userdata('login_id');
		$n4_bizu_gkey = $this->session->userdata('n4_bizu_gkey');
		$ipaddr = $_SERVER['REMOTE_ADDR'];
			
		$jsName=$this->input->post('jsName');
		$jsLicenseNo=$this->input->post('jsLicenseNo');
		$jsContact=$this->input->post('jsContact');
		$jsAddress=$this->input->post('jsAddress');
		
		$license_val_dt=$this->input->post('license_val_dt');
	
		$gate_pass_val_dt=$this->input->post('gate_pass_val_dt');
		
		$upStr=$this->input->post('updateFlag');
		
		if($upStr=="update")
		{
			$jettyId=$this->input->post('jettyId');
			$updateQuery="update ctmsmis.mis_jetty_sirkar set js_name='$jsName', js_lic_no='$jsLicenseNo', cell_no='$jsContact',
							adress='$jsAddress',lic_val_dt='$license_val_dt',gate_pass_val_dt='$gate_pass_val_dt', last_update= now(), update_by='$login_id', user_ip='$ipaddr' where id='$jettyId'";
			
			$updateStat=$this->bm->dataUpdate($updateQuery);		
			if($updateStat==1)
			{
				$data['msg']="<font color=green size='3'><nobr> Information Updated Successfully</nobr></font>";
			}
			else
				$data['msg']="<font color=red size='3'><nobr> Information Update Failed</nobr></font>";
		}		
		else
		{
			$jsSql="select count(*) as rtnValue from ctmsmis.mis_jetty_sirkar where  n4_bizu_gkey='$n4_bizu_gkey' and js_lic_no='$jsLicenseNo'";	
			
			$stat=$this->bm->dataReturn($jsSql);
			
			if($stat==1)
			{
				$data['msg']="<font color=red size='3'><nobr> This Jetty Sarkar Information already entered.</nobr></font>";
			}
			else
			{				
				error_reporting(E_ALL ^ E_NOTICE);   

				$fileName=str_replace('-','',$jsLicenseNo);
				$sign_img=$fileName."_sign.jpg";
				
				$lic_img=$fileName."_lic.jpg";
				$js_img=$fileName."_js.jpg";
				$pass_img=$fileName."_pass.jpg";
				
				$sign=$_POST["sign"];
			
				if($_FILES["sign"]["error"] > 0 or $_FILES["photo_img"]["error"] > 0 or $_FILES["gate_pass_img"]["error"] > 0)
				{
					$data['msg']="<font color='red' size=4>Here is Problem!! To upload this file. Please! Check Again, That file is not Corrupted and ensure correct format</font>";
				}
				else
				{
					move_uploaded_file($_FILES["sign"]["tmp_name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/images/jetty_sarkar_signature_files/".$_FILES["sign"]["name"]);			
					rename($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/images/jetty_sarkar_signature_files/".$_FILES["sign"]["name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/images/jetty_sarkar_signature_files/".$sign_img);
					
					//--
					move_uploaded_file($_FILES["license_img"]["tmp_name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/images/jetty_sarkar_signature_files/".$_FILES["license_img"]["name"]);			
					rename($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/images/jetty_sarkar_signature_files/".$_FILES["license_img"]["name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/images/jetty_sarkar_signature_files/".$lic_img);
					
					move_uploaded_file($_FILES["photo_img"]["tmp_name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/images/jetty_sarkar_signature_files/".$_FILES["photo_img"]["name"]);			
					rename($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/images/jetty_sarkar_signature_files/".$_FILES["photo_img"]["name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/images/jetty_sarkar_signature_files/".$js_img);
					
					move_uploaded_file($_FILES["gate_pass_img"]["tmp_name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/images/jetty_sarkar_signature_files/".$_FILES["gate_pass_img"]["name"]);			
					rename($_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/images/jetty_sarkar_signature_files/".$_FILES["gate_pass_img"]["name"],$_SERVER['DOCUMENT_ROOT']."/myportpanel/resources/images/jetty_sarkar_signature_files/".$pass_img);
					//--
					 
					$insertQuery="insert into ctmsmis.mis_jetty_sirkar(n4_bizu_gkey, js_name, signature_path, js_lic_no, cell_no, adress,lic_copy_path,gate_pass_path,js_img_path,lic_val_dt,gate_pass_val_dt, last_update, update_by,user_ip)
					values('$n4_bizu_gkey','$jsName', '$sign_img', '$jsLicenseNo','$jsContact','$jsAddress','$lic_img','$pass_img','$js_img','$license_val_dt','$gate_pass_val_dt',now(),'$login_id', '$ipaddr')";
					
					$infoInsertStat=$this->bm->dataInsert($insertQuery);
					
					if($infoInsertStat==1)
					{
						$data['msg']="<font color=green size='3'><nobr> Information Inserted Successfully</nobr></font>";
					}
					else
						$data['msg']="<font color=red size='3'><nobr> Information Insert Failed</nobr></font>";
				}
			}
		}
		
		$data['title']="JETTY SARKAR ENTRY FORM...";
		$this->load->view('header2');
		$this->load->view('jettySarkarEntryFormView',$data);
		$this->load->view('footer');
	}
		
		
	function jettySarkarListForm()
	{
		$login_id = $this->session->userdata('login_id');
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$selectSQL="select id, n4_bizu_gkey, js_name, js_lic_no, cell_no, adress, last_update, update_by,
						user_ip,lic_copy_path,gate_pass_path,js_img_path,signature_path from ctmsmis.mis_jetty_sirkar  where update_by='$login_id' order by id desc";
			 
		$js=$this->bm->dataSelect($selectSQL);
		$data['js']=$js;
   
		$data['title']="JETTY SARKAR LIST";
				
		$this->load->view('header2');
		$this->load->view('jettySarkarList',$data);
		$this->load->view('footer');	
		}
		
	}
		
				
	function jettySarkarEntryFormEdit()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			
			$editFlag=$this->input->post('editFlag');
			$jsId=$this->input->post('jsId');
			$selectSQL="select id, n4_bizu_gkey, js_name, js_lic_no, cell_no, adress,lic_val_dt,gate_pass_val_dt, last_update, update_by,user_ip,lic_copy_path,gate_pass_path,js_img_path,signature_path from ctmsmis.mis_jetty_sirkar  where id='$jsId'";
			 
			$jttySr=$this->bm->dataSelect($selectSQL);
			$data['jttySr']=$jttySr;
			$data['editFlag']=$editFlag;
			$data['jettyId']=$jsId;
			
			$data['updateFlag']="update";
			
			
			$data['title']="JETTY SARKAR ENTRY FORM...";
			$data['msg']="";
			
			//echo $data['title'];
			$this->load->view('header2');
			$this->load->view('jettySarkarEntryFormView',$data);
			$this->load->view('footer');
		}	
		
	}
		
		function jettySarkarEntryDelete()
		{
			$login_id = $this->session->userdata('login_id');
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$jsId=$this->input->post('jsId');
				$deleteSQL="Delete from ctmsmis.mis_jetty_sirkar  where id='$jsId'";
				$delStat=$this->bm->dataDelete($deleteSQL);
 
				$selectSQL="select id, n4_bizu_gkey, js_name, js_lic_no, cell_no, adress, last_update, update_by,
							user_ip,lic_copy_path,gate_pass_path,js_img_path,signature_path from ctmsmis.mis_jetty_sirkar where update_by='$login_id' order by id desc";
                 //ECHO $selectSQL;
                 //return;
            $js=$this->bm->dataSelect($selectSQL);
			$data['js']=$js;
       
			$data['title']="JETTY SARKAR LIST";
				
			$this->load->view('header2');
			$this->load->view('jettySarkarList',$data);
			$this->load->view('footer');	
			}
			
		}
		
		
	//truck entry form - start
	function truck_entry_form()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$login_id = $this->session->userdata('login_id');
			$n4_bizu_gkey = $this->session->userdata('n4_bizu_gkey');
			$msg="";
			
			$sql_cnf_info="SELECT u_name,login_id,n4_bizu_gkey 
							FROM users 
							WHERE login_id='$login_id'";
							
			$rslt_cnf_info=$this->bm->dataSelectDb1($sql_cnf_info);
			
			$data['rslt_cnf_info']=$rslt_cnf_info;
			$data['n4_bizu_gkey']=$n4_bizu_gkey;
			$data['msg']=$msg;
			
			$data['title']="CONTAINER ASSIGN FOR DELIVERY";
			$this->load->view('header2');
			$this->load->view('truck_entry_form',$data);
			$this->load->view('footer');
		}
	}
	
	function truck_entry_data()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$login_id = $this->session->userdata('login_id');
			$n4_bizu_gkey = $this->session->userdata('n4_bizu_gkey');
			$msg="";
			$total_truck=0;
			$truck_no="";
			
			$table_id=$this->input->post('table_id');
			$cnf_name=$this->input->post('cnf_name');
			$container_no=trim($this->input->post('container_no'));
			$unit_gkey=$this->input->post('unit_gkey');
			$assignment_type=trim($this->input->post('assignment_type'));
			//$delivery_time_slot=trim($this->input->post('delivery_time_slot'));
			$jetty_sarkar=$this->input->post('jetty_sarkar');
			//$total_truck=trim($this->input->post('total_truck'));
		//	$truck_no=$this->input->post('truck_no');
			//$all_truck=trim($this->input->post('all_truck'));
			//$be_no=trim($this->input->post('be_no'));
			$truck_assign_by=$this->session->userdata('login_id');
			$user_ip=$_SERVER['REMOTE_ADDR'];
			
			$sql_chk_truck="SELECT COUNT(*) AS rtnValue FROM ctmsmis.mis_cf_assign_truck WHERE id='$table_id'";
			
			$rslt_chk_truck=$this->bm->dataReturn($sql_chk_truck);
			
			if($rslt_chk_truck==1)
			{
				/*$sql_update_truck_data="UPDATE ctmsmis.mis_cf_assign_truck
				SET jetty_sirkar_id='$jetty_sarkar',unit_gkey='$unit_gkey',cont_id='$container_no',assign_type='$assignment_type',dlv_time_slot='$delivery_time_slot',truck_id='$all_truck',BE_No='$be_no',truck_assign_time=NOW(),truck_assign_by='$truck_assign_by',user_ip='$user_ip'
				WHERE id='$table_id'";*/
				
				$sql_update_truck_data="UPDATE ctmsmis.mis_cf_assign_truck
				SET jetty_sirkar_id='$jetty_sarkar',unit_gkey='$unit_gkey',cont_id='$container_no',assign_type='$assignment_type',truck_assign_time=NOW(),truck_assign_by='$truck_assign_by',user_ip='$user_ip'
				WHERE id='$table_id'";
				
				$rslt_update_truck_data=$this->bm->dataUpdate($sql_update_truck_data);
				
				if($rslt_update_truck_data)
					$msg="<font color='blue'>Truck data successfully updated</font>";
				else
					$msg="<font color='red'>Entry failed. Try again.</font>";
			}
			else
			{
				/*$sql_insert_truck_data="INSERT INTO 	ctmsmis.mis_cf_assign_truck(jetty_sirkar_id,unit_gkey,cont_id,assign_type,dlv_time_slot,truck_id,BE_No,truck_assign_time,truck_assign_by,user_ip)
				VALUES('$jetty_sarkar','$unit_gkey','$container_no','$assignment_type','$delivery_time_slot','$all_truck','$be_no',NOW(),'$truck_assign_by','$user_ip')";
				*/
				$sql_insert_truck_data="INSERT INTO ctmsmis.mis_cf_assign_truck(jetty_sirkar_id,unit_gkey,cont_id,assign_type,dlv_time_slot,BE_No,truck_assign_time,truck_assign_by,user_ip)
				VALUES('$jetty_sarkar','$unit_gkey','$container_no','$assignment_type','','',NOW(),'$truck_assign_by','$user_ip')";
				
				//echo $sql_insert_truck_data;
				//return;
				$rslt_insert_truck_data=$this->bm->dataInsert($sql_insert_truck_data);
				
				if($rslt_insert_truck_data)
					$msg="<font color='blue'>Truck data successfully inserted</font>";
				else
					$msg="<font color='red'>Entry failed. Try again.</font>";
			}
			
			$sql_cnf_info="SELECT u_name,login_id,n4_bizu_gkey 
							FROM users 
							WHERE login_id='$login_id'";
							
			$rslt_cnf_info=$this->bm->dataSelectDb1($sql_cnf_info);
			
			$data['title']="CONTAINER ASSIGN FOR DELIVERY";
			$data['msg']=$msg;
			$data['login_id']=$login_id;
			$data['n4_bizu_gkey']=$n4_bizu_gkey;
			$data['rslt_cnf_info']=$rslt_cnf_info;
			
			$this->load->view('header2');
			$this->load->view('truck_entry_form',$data);
			$this->load->view('footer');
		}
	}
	//truck entry form - end
	
	//truck entry list - start
	function truck_entry_list()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();	
		}
		else
		{	
			$sql_truck_list="SELECT * FROM ctmsmis.mis_cf_assign_truck";
			
			$rslt_truck_list=$this->bm->dataSelect($sql_truck_list);
			
			$data['title']="Truck List...";
			$data['rslt_truck_list']=$rslt_truck_list;
			$this->load->view('header2');
			$this->load->view('truck_entry_list',$data);
			$this->load->view('footer');
		}
	}
	
	function edit_truck()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();	
		}
		else
		{
			//initial data - start
			$login_id = $this->session->userdata('login_id');
			$n4_bizu_gkey = $this->session->userdata('n4_bizu_gkey');
			$msg="";
			
			$sql_cnf_info="SELECT u_name,login_id,n4_bizu_gkey 
							FROM users 
							WHERE login_id='$login_id'";
							
			$rslt_cnf_info=$this->bm->dataSelectDb1($sql_cnf_info);
			
			$data['rslt_cnf_info']=$rslt_cnf_info;
			$data['n4_bizu_gkey']=$n4_bizu_gkey;
			$data['msg']=$msg;
			//initial data - end
			
			//previously inserted data - start
			$id_edit=$this->input->post('id_edit');
			
			$sql_edit_truck="SELECT * FROM ctmsmis.mis_cf_assign_truck WHERE id='$id_edit'";
			
			$rslt_edit_truck=$this->bm->dataSelect($sql_edit_truck);
			
			$data['rslt_edit_truck']=$rslt_edit_truck;
			//previously inserted data - end
			
			$data['title']="Truck Entry Form...";
			$data['is_edit']=1;
			
			$this->load->view('header2');
			$this->load->view('truck_entry_form',$data);
			$this->load->view('footer');
		}
	}
	//truck entry list - end
	
	//truck report - start
	function truck_report()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();	
		}
		else
		{
			$this->load->library('m_pdf');
			$pdf->use_kwt = true;
				
			$pdf = $this->m_pdf->load();
			$pdf->SetWatermarkText('CPA CTMS');
			$pdf->showWatermarkText = true;	

			$login_id=$this->session->userdata('login_id');
			$sql_cnf_info="SELECT u_name,login_id,n4_bizu_gkey 
							FROM users 
							WHERE login_id='$login_id'";
							
			$rslt_cnf_info=$this->bm->dataSelectDb1($sql_cnf_info);
		
			$this->data['rslt_cnf_info']=$rslt_cnf_info;
			
			$id_report=$this->input->post('id_report');
	
			$sql_truck_report="SELECT * FROM ctmsmis.mis_cf_assign_truck WHERE id='$id_report'";
			
			$rslt_truck_report=$this->bm->dataSelect($sql_truck_report);
			
			$this->data['rslt_truck_report']=$rslt_truck_report;
			
			$stylesheet = file_get_contents('resources/styles/truckReport.css'); // external css
			$html=$this->load->view('truck_report',$this->data, true); 
			
			$pdf->AddPage('P', // L - landscape, P - portrait
										'', '', '', '',
										5, // margin_left
										5, // margin right
										5, // margin top
										5, // margin bottom
										5, // margin header
										5); // margin footer
										
			$pdf->setFooter('|Page {PAGENO} of {nb}|');   
				
			$pdf->WriteHTML($stylesheet,1);
			$pdf->WriteHTML($html,2);
					
			$pdf->Output($pdfFilePath, "I");
		}
	}
	//truck report - end
	
	//Removal List of Overflow Yard - start
	
	function removal_list_form()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$modify=$this->uri->segment(3);
			
			if($modify=="overflow")
				$data['title']="REMOVAL LIST OF OVERFLOW YARD...";
			else if($modify=="all")
				$data['title']="LIST OF CTMS ASSIGNMENT...";
			$data['modify']=$modify;
			
			$this->load->view('header2');
			$this->load->view('removal_list_form',$data);
			$this->load->view('footer');
		}	
	}
	
	// function removal_list_report()
	// {
		// $session_id = $this->session->userdata('value');
		// if($session_id!=$this->session->userdata('session_id'))
		// {
			// $this->logout();
		// }
		// else
		// {
			// $assignment_date=$this->input->post('assignment_date');
			// $modify=$this->input->post('modify');
			
			// $sql_removal_list="SELECT * FROM (SELECT a.id AS cont_no,k.name AS cf,k.sms_number,
			// a.freight_kind AS cont_status,
			// IFNULL((SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
			// FROM sparcsn4.srv_event
			// INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
			// WHERE sparcsn4.srv_event.applied_to_gkey=a.gkey  AND sparcsn4.srv_event.event_type_gkey IN(18,13,16) AND sparcsn4.srv_event_field_changes.new_value IS NOT NULL AND sparcsn4.srv_event_field_changes.new_value !='' AND sparcsn4.srv_event_field_changes.new_value !='Y-CGP-.' AND sparcsn4.srv_event.gkey<(SELECT sparcsn4.srv_event.gkey FROM sparcsn4.srv_event
			// INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
			// WHERE sparcsn4.srv_event.event_type_gkey=4 AND sparcsn4.srv_event.applied_to_gkey=a.gkey AND metafield_id='unitFlexString01' AND new_value IS NOT NULL ORDER BY sparcsn4.srv_event_field_changes.gkey DESC LIMIT 1) ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1),(SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
			// FROM sparcsn4.srv_event
			// INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
			// WHERE sparcsn4.srv_event.applied_to_gkey=a.gkey  AND sparcsn4.srv_event.event_type_gkey IN(18,13,16) ORDER BY sparcsn4.srv_event_field_changes.gkey DESC LIMIT 1)) AS slot,
			// (SELECT size FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey) AS size,
			// CAST(((SELECT height FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey)/10) AS DECIMAL(10,1)) AS height,
			// (SELECT IF(SUBSTR(REPLACE(UPPER(LTRIM(vsl_name)),'.',''),1,2)='MV',SUBSTR(REPLACE(LTRIM(vsl_name),'.',''),3),REPLACE(LTRIM(vsl_name),'.','')) FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey) AS v_name,
			// (SELECT ctmsmis.mis_inv_unit.vsl_visit_dtls_ib_vyg FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey) AS rot_no,
			// g.id AS mlo,
			// config_metafield_lov.mfdch_value AS mfdch_value,
					// config_metafield_lov.mfdch_desc AS mfdch_desc,a.seal_nbr1
			// FROM sparcsn4.inv_unit a
			// INNER JOIN sparcsn4.inv_unit_fcy_visit b ON b.unit_gkey=a.gkey
			// INNER JOIN sparcsn4.ref_bizunit_scoped g ON a.line_op = g.gkey
			// INNER JOIN sparcsn4.config_metafield_lov ON a.flex_string01=config_metafield_lov.mfdch_value
			// INNER JOIN
					// sparcsn4.inv_goods j ON j.gkey = a.goods
			// LEFT JOIN
					// sparcsn4.ref_bizunit_scoped k ON k.gkey = j.consignee_bzu
			// WHERE DATE(flex_date01)='$assignment_date' AND config_metafield_lov.mfdch_value NOT IN ('CANCEL')) AS tbl WHERE sms_number IS NULL";
			
			// $rslt_removal_list=$this->bm->dataSelect($sql_removal_list);
			
			// $data['rslt_removal_list']=$rslt_removal_list;
			
			// $this->load->view('removal_list_report_view',$data);
		// }
	// }
	
	function removal_list_report()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$login_id = $this->session->userdata('login_id');
			
		    //$mpdf->use_kwt = true;
				
			$assignment_date=$this->input->post('assignment_date');
			$modify=$this->input->post('modify');
			$options=$this->input->post('options');
			$sql_removal_list = "";
			
			if($modify=="overflow")
			{
				$sql_removal_list="SELECT a.id AS cont_no,k.name AS cf,IFNULL(k.sms_number,ctmsmis.mis_assignment_entry.phone_number) AS sms_number,
				a.freight_kind AS cont_status,
				IFNULL((SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
				FROM sparcsn4.srv_event
				INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
				WHERE sparcsn4.srv_event.applied_to_gkey=a.gkey  AND sparcsn4.srv_event.event_type_gkey IN(18,13,16) AND sparcsn4.srv_event_field_changes.new_value IS NOT NULL AND sparcsn4.srv_event_field_changes.new_value !='' AND sparcsn4.srv_event_field_changes.new_value !='Y-CGP-.' AND sparcsn4.srv_event.gkey<(SELECT sparcsn4.srv_event.gkey FROM sparcsn4.srv_event
				INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
				WHERE sparcsn4.srv_event.event_type_gkey=4 AND sparcsn4.srv_event.applied_to_gkey=a.gkey AND metafield_id='unitFlexString01' AND new_value IS NOT NULL ORDER BY sparcsn4.srv_event_field_changes.gkey DESC LIMIT 1) ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1),(SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
				FROM sparcsn4.srv_event
				INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
				WHERE sparcsn4.srv_event.applied_to_gkey=a.gkey  AND sparcsn4.srv_event.event_type_gkey IN(18,13,16) ORDER BY sparcsn4.srv_event_field_changes.gkey DESC LIMIT 1)) AS slot,
				(SELECT ctmsmis.cont_yard(slot)) AS Yard_No,
				(SELECT size FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey) AS size,
				CAST(((SELECT height FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey)/10) AS DECIMAL(10,1)) AS height,
				(SELECT IF(SUBSTR(REPLACE(UPPER(LTRIM(vsl_name)),'.',''),1,2)='MV',SUBSTR(REPLACE(LTRIM(vsl_name),'.',''),3),REPLACE(LTRIM(vsl_name),'.','')) FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey) AS v_name,
				(SELECT ctmsmis.mis_inv_unit.vsl_visit_dtls_ib_vyg FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey) AS rot_no,
				g.id AS mlo,
				config_metafield_lov.mfdch_value AS mfdch_value,
						config_metafield_lov.mfdch_desc AS mfdch_desc,a.seal_nbr1
				FROM sparcsn4.inv_unit a
				INNER JOIN sparcsn4.inv_unit_fcy_visit b ON b.unit_gkey=a.gkey
				INNER JOIN sparcsn4.ref_bizunit_scoped g ON a.line_op = g.gkey
				LEFT JOIN ctmsmis.mis_assignment_entry ON ctmsmis.mis_assignment_entry.unit_gkey=a.gkey
				INNER JOIN sparcsn4.config_metafield_lov ON a.flex_string01=config_metafield_lov.mfdch_value
				INNER JOIN
						sparcsn4.inv_goods j ON j.gkey = a.goods
				LEFT JOIN
						sparcsn4.ref_bizunit_scoped k ON k.gkey = j.consignee_bzu
				WHERE DATE(flex_date01)='$assignment_date' AND config_metafield_lov.mfdch_value NOT IN ('CANCEL') AND a.remark LIKE 'overflow%'";
			}
			else{
				$sql_removal_list="SELECT a.id AS cont_no,k.name AS cf,IFNULL(k.sms_number,ctmsmis.mis_assignment_entry.phone_number) AS sms_number,
				a.freight_kind AS cont_status,
				IFNULL((SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
				FROM sparcsn4.srv_event
				INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
				WHERE sparcsn4.srv_event.applied_to_gkey=a.gkey  AND sparcsn4.srv_event.event_type_gkey IN(18,13,16) AND sparcsn4.srv_event_field_changes.new_value IS NOT NULL AND sparcsn4.srv_event_field_changes.new_value !='' AND sparcsn4.srv_event_field_changes.new_value !='Y-CGP-.' AND sparcsn4.srv_event.gkey<(SELECT sparcsn4.srv_event.gkey FROM sparcsn4.srv_event
				INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
				WHERE sparcsn4.srv_event.event_type_gkey=4 AND sparcsn4.srv_event.applied_to_gkey=a.gkey AND metafield_id='unitFlexString01' AND new_value IS NOT NULL ORDER BY sparcsn4.srv_event_field_changes.gkey DESC LIMIT 1) ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1),(SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
				FROM sparcsn4.srv_event
				INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
				WHERE sparcsn4.srv_event.applied_to_gkey=a.gkey  AND sparcsn4.srv_event.event_type_gkey IN(18,13,16) ORDER BY sparcsn4.srv_event_field_changes.gkey DESC LIMIT 1)) AS slot,
				(SELECT ctmsmis.cont_yard(slot)) AS Yard_No,
				(SELECT size FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey) AS size,
				CAST(((SELECT height FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey)/10) AS DECIMAL(10,1)) AS height,
				(SELECT IF(SUBSTR(REPLACE(UPPER(LTRIM(vsl_name)),'.',''),1,2)='MV',SUBSTR(REPLACE(LTRIM(vsl_name),'.',''),3),REPLACE(LTRIM(vsl_name),'.','')) FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey) AS v_name,
				(SELECT ctmsmis.mis_inv_unit.vsl_visit_dtls_ib_vyg FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey) AS rot_no,
				g.id AS mlo,
				config_metafield_lov.mfdch_value AS mfdch_value,
						config_metafield_lov.mfdch_desc AS mfdch_desc,a.seal_nbr1
				FROM sparcsn4.inv_unit a
				INNER JOIN sparcsn4.inv_unit_fcy_visit b ON b.unit_gkey=a.gkey
				INNER JOIN sparcsn4.ref_bizunit_scoped g ON a.line_op = g.gkey
				LEFT JOIN ctmsmis.mis_assignment_entry ON ctmsmis.mis_assignment_entry.unit_gkey=a.gkey
				INNER JOIN sparcsn4.config_metafield_lov ON a.flex_string01=config_metafield_lov.mfdch_value
				INNER JOIN
						sparcsn4.inv_goods j ON j.gkey = a.goods
				LEFT JOIN
						sparcsn4.ref_bizunit_scoped k ON k.gkey = j.consignee_bzu
				WHERE DATE(flex_date01)='$assignment_date' AND config_metafield_lov.mfdch_value NOT IN ('CANCEL')";
			}
			$rslt_removal_list=$this->bm->dataSelect($sql_removal_list);
			
			if($options=="pdf")
			{
				$this->data['rslt_removal_list']=$rslt_removal_list;
				$this->data['modify']=$modify;
				
				if($modify=="overflow")
				{
					$this->data['heading']="Removal Tally of Overflow Yard";
				}
				else
				{
					$this->data['heading']="List of CTMS Assignment";
				}
				$this->load->library('m_pdf');
				$pdf->use_kwt = true;
				$pdf->cacheTables = true;
				$pdf->simpleTables=true;
				$pdf->packTableData=true;
				$pdf = $this->m_pdf->load();				
				$pdf->useSubstitutions = true; 
				
				$stylesheet = file_get_contents('resources/styles/truckReport.css'); // external css
				$html=$this->load->view('removal_list_report_view_pdf',$this->data, true);
											
				$pdfFilePath ="removal_list_report-".time()."-download.pdf";
				
				
						
				$pdf->setFooter('Prepared By : '.$login_id.'|Page {PAGENO}|Date {DATE j-m-Y}');
				
				$pdf->WriteHTML($stylesheet,1);
				$pdf->WriteHTML($html,2);
						
				$pdf->Output($pdfFilePath, "I");
			}
			else if($options=="excel")
			{
				$data['rslt_removal_list']=$rslt_removal_list;
				$data['modify']=$modify;
				
				if($modify=="overflow")
				{
					$data['heading']="Removal Tally of Overflow Yard";
				}
				else
				{
					$data['heading']="List of CTMS Assignment";
				}
				$this->load->view('removal_list_report_view_excel',$data); 
			}
			else if($options=="html")
			{
				$data['rslt_removal_list']=$rslt_removal_list;
				$data['modify']=$modify;
				
				if($modify=="overflow")
				{
					$data['heading']="Removal Tally of Overflow Yard";
				}
				else
				{
					$data['heading']="List of CTMS Assignment";
				}
				$this->load->view('removal_list_report_view',$data);
			}
		}
	}
	
	//Removal List of Overflow Yard - end
	
	// Bill OF ENTRY Information-- Start
	
		function billOfEntryInfoForm()
		{
			$login_id = $this->session->userdata('login_id');
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="BILL OF INFORMATION ENTRY FORM...";
				$data['msg']="";
				$data['login_id']=$login_id;
				$jetty_list_query="SELECT js_name, js_lic_no FROM ctmsmis.mis_jetty_sirkar WHERE update_by='$login_id'";
			 // echo $jetty_list_query;
				$jttySr_list=$this->bm->dataSelect($jetty_list_query);
				$data['jttySr_list']=$jttySr_list;
				$this->load->view('header2');
				$this->load->view('billOfEntryInfoFormView',$data);
				$this->load->view('footer');
				
			}
		}
		
		function billOfEntryPerform()
		{  
            $login_id = $this->session->userdata('login_id');
            $session_id = $this->session->userdata('value');
            if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
            else
			{

			$bl_no=$this->input->post('bl_no');
            $be_no=$this->input->post('be_no');
			$be_date=$this->input->post('be_date');
			$office_code=$this->input->post('office_code');
			$jetty_sarkar_lic_no=$this->input->post('jetty_sarkar');
			$numOfRow=$this->input->post('numOfRow');
            $igmDetailsId=$this->input->post('igmDetailsId');
                        
                        
                      //  echo $bl_no.'-'.$be_no.'-'.$be_date.'-'.$office_code.'-'.$jetty_sarkar_lic_no;
                        
            $sqlUpdate="UPDATE cchaportdb.igm_details set Bill_of_Entry_No='$be_no', Bill_of_Entry_Date='$be_date',
                         office_code='$office_code', jetty_sirkar_lic='$jetty_sarkar_lic_no' where BL_No='$bl_no'";
			$updateStat = $this->bm->dataUpdateDB1($sqlUpdate);
                      //  if($updateStat==1)
            $updateStat==1;
                      //  echo $numOfRow;
                      //  echo '\r\n';
                        
            for($i=0; $i<$numOfRow; $i++)
                {
                    $contNo=$this->input->post('container'.$i);
                    $igmContId=$this->input->post('contId'.$i);
                    $truckNo=$this->input->post('truckNo'.$i); 
                    $findSql="SELECT COUNT(igm_detail_cont_id) AS rtnValue FROM igm_truck_detail WHERE igm_detail_cont_id='$igmContId'";
					$findStat=$this->bm->dataReturnDb1($findSql);
                    if($findStat==1)
                        {
                          $updateSql="UPDATE igm_truck_detail SET igm_detail_id= '$igmDetailsId', truck_no='$truckNo' WHERE igm_detail_cont_id='$igmContId'";
                          $updateStat = $this->bm->dataUpdateDB1($updateSql);
                        }
                    else
                        {
                         $insertSql="INSERT INTO cchaportdb.igm_truck_detail(igm_detail_id, igm_detail_cont_id, truck_no) VALUES($igmDetailsId, $igmContId,'$truckNo')";
                         $insertStat=$this->bm->dataInsertDB1($insertSql);  
                        }
                        //    echo $insertSql;
                         //  echo $contNo.'=='.$truckNo;
                 }
                      //  return;
                    if(($insertStat==1 && $updateStat==1)|| $updateStat==1 )
                            {
                              $data['msg']=  "<font color=green>Data successfully updated and inserted.</font>";
                            }
                    else
                            {
                              $data['msg']=  "<font color=red>Not Updated/Inserted</font>";
                            }
				$data['login_id']=$login_id;
				$data['title']="BILL OF INFORMATION ENTRY FORM...";
                $jetty_list_query="SELECT js_name, js_lic_no FROM ctmsmis.mis_jetty_sirkar WHERE update_by='$login_id'";
				$jttySr_list=$this->bm->dataSelect($jetty_list_query);
				$data['jttySr_list']=$jttySr_list;
                $this->load->view('header2');
                $this->load->view('billOfEntryInfoFormView',$data);
                $this->load->view('footer');
			
		}
    }
		
	
	// Bill OF ENTRY Information-- End
	
	// SMS REPORT Sourav
	function smsRptForm()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="SMS REPORT FORM...";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('smsRptForm',$data);
				$this->load->view('footer');
			}	
		}
		function smsRptView()
		{
		  
			$fromdate=$this->input->post('fromdate');
			
			$query="SELECT  ref.name,cell_no,sms_sending_time,max_time_limit,
					(CASE
					   WHEN sms_status='0' THEN 'NOT SEND'
					   ELSE 'SEND' END) AS sms_status,
					(CASE
					   WHEN sms_type='overflow' THEN SUBSTRING(sms,12,11)
					   WHEN sms_type='keepdown' THEN SUBSTRING(sms,12,11)
					   ELSE SUBSTRING(sms,33,11) END) AS id,
					(CASE
					   WHEN sms_type='overflow' THEN 'OVERFLOW'
					   WHEN sms_type='keepdown' THEN 'KEEPDOWN'
					   ELSE 'ASSIGNMENT' END) AS sms_type 					   
					FROM ctmsmis.sms_transaction st
					LEFT JOIN sparcsn4.inv_unit inv ON st.unit_gkey=inv.gkey
					LEFT JOIN sparcsn4.ref_bizunit_scoped ref ON st.bizu_gkey=ref.gkey
					WHERE DATE(st.max_time_limit)='$fromdate'
					ORDER BY sms_type desc";
							
			$rtnSmsDetails = $this->bm->dataSelect($query);
			
			$query_tot="SELECT 
						COUNT(id) AS tot,
						SUM(tot_overflow) AS count_tot_overflow,
						SUM(tot_keepdown) AS count_tot_keepdown,
						SUM(tot_assign) AS count_tot_assignment,
						SUM(tot_overflow_send_sms) AS count_tot_overflow_send_sms,
						SUM(tot_keepdown_send_sms) AS count_tot_keepdown_send_sms,
						SUM(tot_assignment_send_sms) AS count_tot_assignment_send_sms,
						(SUM(tot_overflow)-SUM(tot_overflow_send_sms)) AS count_tot_overflow_sms_not_send,
						(SUM(tot_keepdown)-SUM(tot_keepdown_send_sms)) AS count_tot_keepdown_sms_not_send,
						(SUM(tot_assign)-SUM(tot_assignment_send_sms)) AS count_tot_assignment_sms_not_send
						FROM (
						SELECT id,
						(CASE
						   WHEN sms_type='overflow' THEN 1
						   ELSE 0 END) AS tot_overflow,
						(CASE
						   WHEN sms_type='keepdown' THEN 1
						   ELSE 0 END) AS tot_keepdown,
						(CASE
						   WHEN sms_type='overflow' AND sms_status=1 THEN 1
						   ELSE 0 END) AS tot_overflow_send_sms,
						(CASE
						   WHEN sms_type='keepdown' AND sms_status=1 THEN 1
						   ELSE 0 END) AS tot_keepdown_send_sms,
						(CASE
						   WHEN sms_type='notoverflow' OR sms_type IS NULL THEN 1
						   ELSE 0 END) AS tot_assign,
						(CASE
						   WHEN (sms_type='notoverflow' OR sms_type IS NULL) AND sms_status=1 THEN 1
						   ELSE 0 END) AS tot_assignment_send_sms
						FROM ctmsmis.sms_transaction 
						WHERE DATE(max_time_limit)='$fromdate') AS tbl";
			
			$rtnSmsTotInfo = $this->bm->dataSelect($query_tot);
			
			$data['rtnSmsDetails']=$rtnSmsDetails;
			$data['fromdate']=$fromdate;
			$data['rtnSmsTotInfo']=$rtnSmsTotInfo;
			
			//$data['type']=$type;
			$this->load->view('smsRptView',$data);
			//$this->load->view('yardWiseEmtyContainerReportView',$data);
		   
		  
		   
		   $this->load->view('myclosebar');
  
		}
	/*function mis_assignment_entry_rpt()
	{
		//$data['type']=$type;
		$login_id = $this->session->userdata('login_id');
		$data['login_id']=$login_id;
		$this->load->view('mis_assignment_entry_rpt_view',$data);
		//$this->load->view('yardWiseEmtyContainerReportView',$data);
	   $this->load->view('myclosebar');
  
	}*/
	
	function mis_assignment_report_search()		
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			$data['title']="MIS ASSIGNMENT REPORT....";
			$this->load->view('header2');
			$this->load->view('mis_assignment_search_rpt_Form',$data);
			$this->load->view('footer');
		}
		
		function mis_assignment_entry_rpt()
		{
			$search_by = $this->input->post('search_by');
			$login_id = $this->session->userdata('login_id');
			if($search_by=="all")
			{
				
				$data['login_id']=$login_id;
				$this->load->view('mis_assignment_entry_rpt_view',$data);
				//$this->load->view('yardWiseEmtyContainerReportView',$data);
	
				//$this->load->view('mis_assignment_entry_rpt_view');
				$this->load->view('myclosebar');
			}
			else if($search_by=="date")
			{
				$data['login_id']=$login_id;
				$search_val = $this->input->post('fromdate');
				$data['search_by']=$search_by;
				$data['search_val']=$search_val;
				$this->load->view('mis_assignment_search_rpt_view',$data);
			}
			else
			{
				$data['login_id']=$login_id;
				$search_val_dt = $this->input->post('fromdate');
				$search_val = $this->input->post('search_value');
				$data['search_by']=$search_by;
				$data['search_val']=$search_val;
				$data['search_val_dt']=$search_val_dt;
				$this->load->view('mis_assignment_search_rpt_view',$data);
			}
		   
		   $this->load->view('myclosebar');
  
		}
	
	
	
	function downloadAssignmentSnx()
	{			
		$this->load->view('downloadAssignmentSnx');
	}
	
	//Product type - start
	function product_type_form()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$msg="";
			$data['title']="PRODUCT TYPE FORM...";
			$data['msg']=$msg;
			
			$this->load->view('header2');
			$this->load->view('product_type_form',$data);
			$this->load->view('footer');
		}
	}
	
	function product_type_save()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$login_id = $this->session->userdata('login_id');
			$user_ip=$_SERVER['REMOTE_ADDR'];
			$msg="";
			
			$product_id=$this->input->post('product_id');
			$short_name=$this->input->post('short_name');
			$description=$this->input->post('description');
			
			$sql_chk_duplicate="SELECT COUNT(*) AS rtnValue FROM inventory_product_type WHERE id='$product_id'";
			
			$cnt=$this->bm->dataReturnDb1($sql_chk_duplicate);
			
			if($cnt>0)
			{
				$sql_update_product="UPDATE inventory_product_type
				SET short_name='$short_name',product_desc='$description',created_by='$login_id',created_time=NOW(),user_ip='$user_ip'
				WHERE id='$product_id'";
				
				$rslt_update_product=$this->bm->dataUpdateDB1($sql_update_product);
				
				if($rslt_update_product==1)
					$msg="<font color='green'><b>Succesfully updated</b></font>";
				else
					$msg="<font color='red'><b>Update failed</b></font>";
			}
			else
			{
				$sql_insert_product="INSERT INTO inventory_product_type(short_name,product_desc,created_by,created_time,user_ip) 
				VALUES('$short_name','$description','$login_id',NOW(),'$user_ip')";
				
				$rslt_insert_product=$this->bm->dataInsertDB1($sql_insert_product);
				
				if($rslt_insert_product==1)
					$msg="<font color='green'><b>Succesfully inserted</b></font>";
				else
					$msg="<font color='red'><b>Insertion failed</b></font>";
			}
			
			$data['title']="PRODUCT TYPE FORM...";
			$data['msg']=$msg;
			
			$this->load->view('header2');
			$this->load->view('product_type_form',$data);
			$this->load->view('footer');
		}
	}
	//Product type - end
	
	//Location - start
	function location_form()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$msg="";
			$data['title']="LOCATION FORM...";
			$data['msg']=$msg;
			
			$this->load->view('header2');
			$this->load->view('location_form',$data);
			$this->load->view('footer');
		}
	}
	
	function location_save()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$login_id = $this->session->userdata('login_id');
			$user_ip=$_SERVER['REMOTE_ADDR'];
			$msg="";
			
			$location_id=$this->input->post('location_id');
			$location_name=$this->input->post('location_name');
			
			$sql_chk_duplicate="SELECT COUNT(*) AS rtnValue FROM inventory_product_location WHERE id='$location_id'";
			
			$cnt=$this->bm->dataReturnDb1($sql_chk_duplicate);
			
			if($cnt>0)
			{
				$sql_update_location="UPDATE inventory_product_location
				SET location_name='$location_name',created_by='$login_id',created_time=NOW(),user_ip='$user_ip'
				WHERE id='$location_id'";
				
				$rslt_update_location=$this->bm->dataUpdateDB1($sql_update_location);
				
				if($rslt_update_location==1)
					$msg="<font color='green'><b>Succesfully updated</b></font>";
				else
					$msg="<font color='red'><b>Update failed</b></font>";
			}
			else
			{
				$sql_insert_location_name="INSERT INTO inventory_product_location(location_name,created_by,created_time,user_ip)
				VALUES('$location_name','$login_id',NOW(),'$user_ip')";
			
				$rslt_insert_location_name=$this->bm->dataInsertDB1($sql_insert_location_name);
			
				if($rslt_insert_location_name==1)
					$msg="<font color='green'><b>Succesfully inserted</b></font>";
				else
					$msg="<font color='red'><b>Insertion failed</b></font>";
			}
			
			$data['title']="LOCATION FORM...";
			$data['msg']=$msg;
			
			$this->load->view('header2');
			$this->load->view('location_form',$data);
			$this->load->view('footer');
			
		}
	}
	//Location - end
	
	//Product user - start
	function product_user_form()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$msg="";
			$data['title']="PRODUCT USER FORM...";
			$data['msg']=$msg;
			
			$this->load->view('header2');
			$this->load->view('product_user_form',$data);
			$this->load->view('footer');
		}
	}
	
	function product_user_save()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$login_id = $this->session->userdata('login_id');
			$user_ip=$_SERVER['REMOTE_ADDR'];
			$msg="";
			
			$user_id=$this->input->post('user_id');
			$company_name=$this->input->post('company_name');
			
			$sql_chk_duplicate="SELECT COUNT(*) AS rtnValue FROM inventory_product_user WHERE id='$user_id'";
			
			$cnt=$this->bm->dataReturnDb1($sql_chk_duplicate);
			
			if($cnt>0)
			{
				$sql_update_user="UPDATE inventory_product_user
				SET company_name='$company_name',created_by='$login_id',created_time=NOW(),user_ip='$user_ip'
				WHERE id='$user_id'";
				
				$rslt_update_user=$this->bm->dataUpdateDB1($sql_update_user);
				
				if($rslt_update_user==1)
					$msg="<font color='green'><b>Succesfully updated</b></font>";
				else
					$msg="<font color='red'><b>Update failed</b></font>";
			}
			else
			{
				$sql_insert_company_name="INSERT INTO inventory_product_user(company_name,created_by,created_time,user_ip)
				VALUES('$company_name','$login_id',NOW(),'$user_ip')";
			
				$rslt_insert_company_name=$this->bm->dataInsertDB1($sql_insert_company_name);
			
				if($rslt_insert_company_name==1)
					$msg="<font color='green'><b>Succesfully inserted</b></font>";
				else
					$msg="<font color='red'><b>Insertion failed</b></font>";
			}
			
			$data['title']="PRODUCT USER FORM...";
			$data['msg']=$msg;
			
			$this->load->view('header2');
			$this->load->view('product_user_form',$data);
			$this->load->view('footer');
		}
	}
	//Product user - end
	
	//Product list - start
	function product_list()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
                    
		   if($this->input->post('search'))
			{
				$pro_type=$this->input->post('product_type');
				$sql_product_list="SELECT * FROM inventory_product_type where short_name='$pro_type'";
			}
			else
			{
			$sql_product_list="SELECT * FROM inventory_product_type";
            }
		$rslt_product_list=$this->bm->dataSelectDb1($sql_product_list);
		$data['rslt_product_list']=$rslt_product_list;
		
		$data['title']="PRODUCT TYPE LIST...";
					
		$product_type_Sql="SELECT DISTINCT(short_name) AS short_name FROM inventory_product_type";
		$rslt_product_type_list=$this->bm->dataSelectDb1($product_type_Sql);			
		$data['product_type_list']=$rslt_product_type_list;
					
		$this->load->view('header2');
		$this->load->view('product_list',$data);
		$this->load->view('footer');
		}
	}
	//Product list - end
	
	//Product edit - start
	function product_edit_form()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$product_id=$this->input->post('product_id');
			
			$sql_product_info="SELECT id,short_name,product_desc
			FROM inventory_product_type
			WHERE id='$product_id'";
			
			$rslt_product_info=$this->bm->dataSelectDb1($sql_product_info);
			
			$data['rslt_product_info']=$rslt_product_info;
			
			$data['title']="PRODUCT TYPE FORM...";
			$data['msg']=$msg;
			
			$this->load->view('header2');
			$this->load->view('product_type_form',$data);
			$this->load->view('footer');
		}
	}
	//Product edit - end
	
	//Product delete - start
	function product_delete_form()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$product_id=$this->input->post('product_id');
			
			//-delete start
			$sql_delete_product="DELETE FROM inventory_product_type WHERE id='$product_id'";
			
			$rslt_delete_product=$this->bm->dataDeleteDB1($sql_delete_product);
			//-delete end
			
			//-reload list - start
			$sql_product_list="SELECT * FROM inventory_product_type";
			
			$rslt_product_list=$this->bm->dataSelectDb1($sql_product_list);
			//-reload list - end
			
			$data['title']="PRODUCT TYPE LIST...";
			$data['rslt_product_list']=$rslt_product_list;
			
			$this->load->view('header2');
			$this->load->view('product_list',$data);
			$this->load->view('footer');
		}
	}
	//Product delete - end
	
	//Location List - start
	function location_list()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$sql_location_list="SELECT * FROM inventory_product_location";
			
			$rslt_location_list=$this->bm->dataSelectDb1($sql_location_list);
			
			$data['rslt_location_list']=$rslt_location_list;
			
			$data['title']="LOCATION LIST...";
			
			$this->load->view('header2');
			$this->load->view('location_list',$data);
			$this->load->view('footer');
		}
	}
	//Location List - end
	
	//Location edit - start
	function location_edit_form()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$location_id=$this->input->post('location_id');
			
			$sql_location_info="SELECT id,location_name
			FROM inventory_product_location
			WHERE id='$location_id'";
			
			$rslt_location_info=$this->bm->dataSelectDb1($sql_location_info);
			
			$data['rslt_location_info']=$rslt_location_info;
			
			$data['title']="LOCATION FORM...";
			$data['msg']=$msg;
			
			$this->load->view('header2');
			$this->load->view('location_form',$data);
			$this->load->view('footer');
		}
	}
	//Location edit - end
	
	//Location delete - start
	function location_delete_form()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$location_id=$this->input->post('location_id');
			
			//-delete start
			$sql_delete_location="DELETE FROM inventory_product_location WHERE id='$location_id'";
			
			$delstat=$this->bm->dataDeleteDB1($sql_delete_location);
			if($delstat==1)
			{
               $data['msg']="<font size=3 color=green>Data Deleted.</font>";
            }
            else {
               $data['msg']="<font size=3 color=red>Data not deleted. Please! Make sure it is deleted from others entry.</font>";
            }
			//-delete end
			
			//-reload list - start
			$sql_location_list="SELECT * FROM inventory_product_location";
			
			$rslt_location_list=$this->bm->dataSelectDb1($sql_location_list);
			//-reload list - end
			
			$data['rslt_location_list']=$rslt_location_list;
			
			$this->load->view('header2');
			$this->load->view('location_list',$data);
			$this->load->view('footer');
		}
	}
	//Location delete - end
	
	//User List - start
	function product_user_list()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$sql_product_user_list="SELECT * FROM inventory_product_user";
			
			$rslt_product_user_list=$this->bm->dataSelectDb1($sql_product_user_list);
			
			$data['rslt_product_user_list']=$rslt_product_user_list;
			
			$data['title']="USER LIST...";
			
			$this->load->view('header2');
			$this->load->view('product_user_list',$data);
			$this->load->view('footer');
		}
	}
	//User List - end
	
	//User edit - start
	function user_edit_form()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$user_id=$this->input->post('user_id');
			
			$sql_user_info="SELECT id,company_name
			FROM inventory_product_user
			WHERE id='$user_id'";
			
			$rslt_user_info=$this->bm->dataSelectDb1($sql_user_info);
			
			$data['rslt_user_info']=$rslt_user_info;
			
			$data['title']="USER FORM...";
			$data['msg']=$msg;
			
			$this->load->view('header2');
			$this->load->view('product_user_form',$data);
			$this->load->view('footer');
		}
	}
	//User edit - end
	
	//User delete - start
	// function user_delete_form()
	// {
		// $session_id = $this->session->userdata('value');
		// if($session_id!=$this->session->userdata('session_id'))
		// {
			// $this->logout();
		// }
		// else
		// {
			// $user_id=$this->input->post('user_id');
			
			// //-delete start
		// echo	$sql_delete_user="DELETE FROM inventory_product_user WHERE id='$user_id'";
			
			// $rslt_delete_user=$this->bm->dataDeleteDB1($sql_delete_user);
			// //-delete end
			
			// //-reload list - start
	// echo		$sql_user_list="SELECT * FROM inventory_product_user";
			
			// $rslt_user_list=$this->bm->dataSelectDb1($sql_user_list);
			// //-reload list - end
			
			// $data['rslt_user_list']=$rslt_user_list;
			
			// $this->load->view('header2');
			// $this->load->view('product_user_list',$data);
			// $this->load->view('footer');
		// }
	// }
	//user delete - end
	
	function product_dlv_form()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
                                
                        $owner_sql="SELECT id, full_name FROM inventory_product_owner";
                        // echo $jetty_list_query;
                        $owner_list=$this->bm->dataSelectDb1($owner_sql);
                        $data['owner_list']=$owner_list;

                         $usr_sql="SELECT id,company_name FROM inventory_product_user";
                        // echo $jetty_list_query;
                        $usr_list=$this->bm->dataSelectDb1($usr_sql);
                        $data['usr_list']=$usr_list;

			$login_id = $this->session->userdata('login_id');
			$data['title']="PRODUCT DELIVERY FORM...";
			$data['login_id']=$login_id;
			
			$this->load->view('header2');
			$this->load->view('product_dlv_form',$data);
			$this->load->view('footer');
		}
	}
	
	
        
        
		function product_dlv_entry()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$login_id = $this->session->userdata('login_id');
			$product_type=$this->input->post('product_type');
			$product_name=$this->input->post('product_name');
			$handover_category=$this->input->post('handover_category');
			$handover_to=$this->input->post('handover_to');
                        $ownar_id=$this->input->post('ownar_id');
			$usr_id=$this->input->post('usr_id');
			$handover_date=$this->input->post('handover_date');
			$comments=$this->input->post('comments');
			$handover_by=$this->input->post('handover_by');
                        $ipaddr = $_SERVER['REMOTE_ADDR'];
                        
                                                        
                if($this->input->post('update'))
                   { 
                    $delid=$this->input->post('delid'); 
                    //echo $rId;
                     if($handover_to=="owner")
                     {
                    $updateSql="UPDATE cchaportdb.inventory_product_delivery set product_id ='$product_name', handover_category='$handover_category', handover_to='$handover_to',
                            handover_owner_user_id='$ownar_id', handover_date='$handover_date', comments='$comments', handover_by='$handover_by',  last_update=now(), user_ip='$ipaddr'
                             where inventory_product_delivery.id='$delid'"; 
                     }
                     else{
                         $updateSql="UPDATE cchaportdb.inventory_product_delivery set product_id ='$product_name', handover_category='$handover_category', handover_to='$handover_to',
                             handover_owner_user_id='$usr_id',handover_date='$handover_date', comments='$comments', handover_by='$handover_by',  last_update=now(), user_ip='$ipaddr'
                             where inventory_product_delivery.id='$delid'"; 
                     }
                   
                     $updateStat=$this->bm->dataUpdateDB1($updateSql);  
                       if($updateStat==1)
                           $data['msg']="<font size=3 color=green>Data updated successfully.</font>";
                       else 
                           $data['msg']="<font size=3 color=red>Data not updated.</font>";			
                   }
                  //add insert query here
                else{
                    if($handover_to=="owner")
                    {
                    $handOverSql="INSERT INTO cchaportdb.inventory_product_delivery(`product_id`,`handover_category`, `handover_to`, handover_owner_user_id,
                               `handover_date`, `comments`,`handover_by`, `last_update`, `user_ip`)
                                VALUES('$product_name', '$handover_category', '$handover_to', '$ownar_id', '$handover_date',
                                '$comments','$handover_by', now(), '$ipaddr' )";
                    }
                    else
                    {
                        $handOverSql="INSERT INTO cchaportdb.inventory_product_delivery(`product_id`,`handover_category`, `handover_to`, handover_owner_user_id,
                               `handover_date`, `comments`,`handover_by`, `last_update`, `user_ip`)
                                VALUES('$product_name', '$handover_category', '$handover_to','$usr_id', '$handover_date',
                                '$comments','$handover_by', now(), '$ipaddr' )"; 
                    }
                    //echo $handOverSql;
                    $insertStat=$this->bm->dataInsertDB1($handOverSql);  
                
                    if($insertStat==1)
                          $data['msg']="<font size=4 color=green>Data inserted successfully.</font>";

                    else
                          $data['msg']="<font size=3 color=red>Data not inserted.</font>";
                }    

                $data['title']="PRODUCT DELIVERY FORM...";
				$data['login_id']=$login_id;
		            
                $owner_sql="SELECT id, full_name FROM inventory_product_owner";
                // echo $jetty_list_query;
                $owner_list=$this->bm->dataSelectDb1($owner_sql);
                $data['owner_list']=$owner_list;

                 $usr_sql="SELECT id,company_name FROM inventory_product_user";
                // echo $jetty_list_query;
                $usr_list=$this->bm->dataSelectDb1($usr_sql);
                $data['usr_list']=$usr_list;

		$this->load->view('header2');
		$this->load->view('product_dlv_form',$data);
		$this->load->view('footer');
		}
	}
	
	
	 function networkProductDeliveryList()
        {
            
            $login_id = $this->session->userdata('login_id');
            $session_id = $this->session->userdata('value');
            if($session_id!=$this->session->userdata('session_id'))
            {
                    $this->logout();
            }
            else
            {

                if($this->input->post('delete'))
                {
                    $deliId=$this->input->post('dID');
                    $deleteSql="DELETE FROM inventory_product_delivery WHERE inventory_product_delivery.id='$deliId'";
                    $deleteStat=$this->bm->dataDeleteDB1($deleteSql);
                }
                $listSql="SELECT inventory_product_delivery.`id`,`product_id`, `inventory_product_type`.id AS typeid, `short_name`,`prod_name`, 
                    `handover_category`,`handover_to`,handover_owner_user_id,
                        CASE 
                                WHEN handover_to ='owner' THEN  full_name
                                WHEN handover_to <> 'owner' THEN company_name
                                END
                                AS owner_user,
                                `handover_date`,`comments`,`handover_by`  
                        FROM `inventory_product_delivery` 
                        INNER JOIN `inventory_product_info` ON `inventory_product_delivery`.`product_id`=inventory_product_info.`id`
                        INNER JOIN `inventory_product_type` ON `inventory_product_type`.`id`=inventory_product_info.type_id
                        LEFT JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_delivery.handover_owner_user_id
                        AND handover_to ='owner'
                        LEFT JOIN `inventory_product_user` ON `inventory_product_user`.id=inventory_product_delivery.handover_owner_user_id
                        AND handover_to <> 'owner' order by inventory_product_delivery.`id` desc";

                $list=$this->bm->dataSelectDb1($listSql);
                $data['list']=$list;

                $data['tableTitle']="PRODUCT DELEDERY LIST";
                $this->load->view('header2');
                $this->load->view('networkProductDeliveryList',$data);
                $this->load->view('footer');
               
            }
            
        }
        
        
        function networkProductDeliveryListEdit()
        {
             $login_id = $this->session->userdata('login_id');
            $session_id = $this->session->userdata('value');
            if($session_id!=$this->session->userdata('session_id'))
            {
                    $this->logout();
            }
            else
            {
                $deliId=$this->input->post('deliveryID');
                
                $selectSql="SELECT inventory_product_delivery.`id`,`product_id`, `inventory_product_type`.id AS typeid, `short_name`,`prod_name`, 
                `handover_category`,`handover_to`,handover_owner_user_id,
                    CASE 
                            WHEN handover_to ='owner' THEN  full_name
                            WHEN handover_to <> 'owner' THEN company_name
                            END
                            AS owner_user,
                            `handover_date`,`comments`,`handover_by`  
                    FROM `inventory_product_delivery` 
                    INNER JOIN `inventory_product_info` ON `inventory_product_delivery`.`product_id`=inventory_product_info.`id`
                    INNER JOIN `inventory_product_type` ON `inventory_product_type`.`id`=inventory_product_info.type_id
                    LEFT JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_delivery.handover_owner_user_id
                    AND handover_to ='owner'
                    LEFT JOIN `inventory_product_user` ON `inventory_product_user`.id=inventory_product_delivery.handover_owner_user_id
                    AND handover_to <> 'owner' WHERE inventory_product_delivery.id='$deliId'";
                         // echo $selectSql;
                $delv_details=$this->bm->dataSelectDb1($selectSql);
                $data['delv_details']=$delv_details;                
                $data['editflag']=1;
                
                 $owner_sql="SELECT id, full_name FROM inventory_product_owner";
                // echo $jetty_list_query;
                $owner_list=$this->bm->dataSelectDb1($owner_sql);
                $data['owner_list']=$owner_list;

                 $usr_sql="SELECT id,company_name FROM inventory_product_user";
                // echo $jetty_list_query;
                $usr_list=$this->bm->dataSelectDb1($usr_sql);
                $data['usr_list']=$usr_list;

                $data['title']="PRODUCT RECEIVED FORM.";
               // $data['msg']="";
                $data['login_id']=$login_id;

                $this->load->view('header2');
                $this->load->view('product_dlv_form',$data);
				$this->load->view('footer');
            }            
        } 
	//product delivery form - end
	 
	
	// SOURAV Pliot Entry
	function pilot_vsl_entry_rpt()
	{
			$data['msg']="";
			$this->load->view('pilot_vsl_entry_rpt_view',$data);
			//$this->load->view('yardWiseEmtyContainerReportView',$data);
		   
		  
		   
		   $this->load->view('myclosebar');
  
	}
	function update_pilot_vsl_status()
	{
			$vslEntryId=$this->input->post('vslEntryId');
			
			//echo $vslEntryId;
			$data['msg']="";
			
			$strUpdate="update doc_vsl_info set status=1 where id=$vslEntryId";
						
			$stat = $this->bm->dataInsertDB1($strUpdate);
						
			if($stat==1)
				$data['msg']="<font color='green' size=2>Data Successfully Updated</font>";
			else
				$data['msg']="<font color='red' size=2>Data Not Updated</font>";

			$this->load->view('pilot_vsl_entry_rpt_view',$data);

		   $this->load->view('myclosebar');
  
	}
	// SOURAV
	//---------Sumon--------------Network Product Entry-----------------------------------------------------
		function networkProductEntryForm()
		{
            $login_id = $this->session->userdata('login_id');
            $session_id = $this->session->userdata('value');
            if($session_id!=$this->session->userdata('session_id'))
            {
                    $this->logout();
            }
            else
            {
            $data['title']="PRODUCT ENTRY FORM.";
            $data['msg']="";
            $data['login_id']=$login_id;
            $data['editFlag']=0;
            $product_sql="SELECT id,IF(short_name='Monitor',CONCAT(short_name,'-',product_desc),short_name) AS short_name FROM cchaportdb.inventory_product_type ORDER BY short_name ASC";
            // echo $jetty_list_query;
            $product_list=$this->bm->dataSelectDb1($product_sql);
            $data['product_list']=$product_list;
           
            $location_sql="SELECT id, location_name FROM inventory_product_location";
            // echo $jetty_list_query;
            $location_list=$this->bm->dataSelectDb1($location_sql);
            $data['location_list']=$location_list;
            
            $owner_sql="SELECT id, full_name FROM inventory_product_owner";
            // echo $jetty_list_query;
            $owner_list=$this->bm->dataSelectDb1($owner_sql);
            $data['owner_list']=$owner_list;
            
             $usr_sql="SELECT id,company_name FROM inventory_product_user";
            // echo $jetty_list_query;
            $usr_list=$this->bm->dataSelectDb1($usr_sql);
            $data['usr_list']=$usr_list;
                 
            $this->load->view('header2');
            $this->load->view('networkProductEntryForm',$data);
            $this->load->view('footer');

            }
        }
        
       function networkProductEntryPerform()
        {
            $login_id = $this->session->userdata('login_id');
			$ipaddr = $_SERVER['REMOTE_ADDR'];
            $session_id = $this->session->userdata('value');
            if($session_id!=$this->session->userdata('session_id'))
            {
                    $this->logout();
            }
            else
            {
                //product_type serial_no rcv_date ip_addr dec_id location product_user ownar_name rcv_by
                $product_type=$this->input->post('product_type');
                $serial_no=$this->input->post('serial_no');
				$imei_number=$this->input->post('imei_number');
                $prod_name=$this->input->post('prod_name');
                $rcv_date=$this->input->post('rcv_date'); 
                $ip_addr=$this->input->post('ip_addr'); 
                $dec_id=$this->input->post('dec_id'); 
                $location=$this->input->post('location'); 
                $loc_dtl=trim($this->input->post('loc_dtl')); 
                $product_user=$this->input->post('product_user'); 
                $ownar_id=$this->input->post('ownar_id'); 
                $rcv_by=$this->input->post('rcv_by'); 

                
				$strPordDtl = "select count(*) as rtnValue from inventory_product_location_details where location_details = '$loc_dtl'";
				$ack = $this->bm->dataReturnDb1($strPordDtl);
				$prodLocDtlId = 0;
				if($ack==0)
				{
					$strIn = "INSERT INTO inventory_product_location_details(location_id,location_details,updated_by,updated_time,ip_addr) 
					VALUES ('$location','$loc_dtl','$login_id',now(),'$ipaddr')";
					$inSt=$this->bm->dataInsertDB1($strIn);
					if($inSt)
					{
						$strDtlId = "select id as rtnValue from inventory_product_location_details where location_details = '$loc_dtl'";
						$prodLocDtlId = $this->bm->dataReturnDb1($strDtlId);
					}
				}
				else
				{
					$strDtlId = "select id as rtnValue from inventory_product_location_details where location_details = '$loc_dtl'";
					$prodLocDtlId = $this->bm->dataReturnDb1($strDtlId);
				}
				//echo $prodLocDtlId;
                if($this->input->post('update'))
                {
					$productId=$this->input->post('pid');  
					$serial_chk_sql="SELECT  COUNT(*) AS rtnValue FROM inventory_product_info WHERE prod_serial!= 'missing' AND prod_serial='$serial_no'
									AND inventory_product_info.id!='$productId'";
					$serialStat=$this->bm->dataReturnDb1($serial_chk_sql);
					if($serialStat==0)
					{
					 $updateSql="UPDATE cchaportdb.inventory_product_info set loc_detail_id ='$prodLocDtlId', owner_id='$ownar_id', type_id='$product_type',
							  prod_name='$prod_name', prod_serial='$serial_no',imei_number='$imei_number', prod_ip='$ip_addr', prod_deck_id='$dec_id',  prod_rcv_date='$rcv_date', prod_rcv_by='$rcv_by', 
							   last_update=now() where inventory_product_info.id='$productId'";   
					 
					  $updateStat=$this->bm->dataUpdateDB1($updateSql);  
						//               echo $updateSql;
					   //return;
						if($updateStat==1)
						{
							$data['msg']="<font size=3 color=green>Data updated successfully.</font>";
						}
						else {
							$data['msg']="<font size=3 color=red>Data not updated.</font>";
						}
					}
					else
					{
						$data['msg']="<font size=3 color=red>Duplicate Serial number is found!!</font>";
					}
                    
                }
                else
                {
					$serial_chk_sql="SELECT  COUNT(*) AS rtnValue FROM inventory_product_info WHERE prod_serial!= 'missing' AND prod_serial='$serial_no'";
					$serialStat=$this->bm->dataReturnDb1($serial_chk_sql);
					if($serialStat==0)
					{
						$insertSql="INSERT INTO cchaportdb.inventory_product_info(loc_detail_id, owner_id, type_id, prod_name, prod_serial, imei_number, prod_ip, 
								prod_deck_id, prod_rcv_date, prod_rcv_by, last_update) VALUES('$prodLocDtlId', '$ownar_id', '$product_type',
								'$prod_name','$serial_no', '$imei_number', '$ip_addr', '$dec_id', '$rcv_date', '$rcv_by', now())";

				   // echo $insertSql;
				   //    return;
						$insertStat=$this->bm->dataInsertDB1($insertSql);  
						if($insertStat==1)
						{
							$data['msg']="<font size=3 color=green>Data inserted successfully.</font>";
						}
						else {
							$data['msg']="<font size=3 color=red>Data not inserted.</font>";
						}
					}
					else
					{
						 $data['msg']="<font size=3 color=red>Duplicate Serial number is found!!</font>";
					}
                }
				

                $data['title']="PRODUCT ENTRY FORM.";
               // $data['msg']="";
                $data['login_id']=$login_id;
                $data['editFlag']=0;
                $product_sql="SELECT id,IF(short_name='Monitor',CONCAT(short_name,'-',product_desc),short_name) AS short_name FROM cchaportdb.inventory_product_type ORDER BY short_name ASC";
                // echo $jetty_list_query;
                $product_list=$this->bm->dataSelectDb1($product_sql);
                $data['product_list']=$product_list;

                $location_sql="SELECT id, location_name FROM inventory_product_location";
                // echo $jetty_list_query;
                $location_list=$this->bm->dataSelectDb1($location_sql);
                $data['location_list']=$location_list;

                $owner_sql="SELECT id, full_name FROM inventory_product_owner";
                // echo $jetty_list_query;
                $owner_list=$this->bm->dataSelectDb1($owner_sql);
                $data['owner_list']=$owner_list;
                
                $usr_sql="SELECT id,company_name FROM inventory_product_user";
                // echo $jetty_list_query;
                $usr_list=$this->bm->dataSelectDb1($usr_sql);
                $data['usr_list']=$usr_list;

                $this->load->view('header2');
                $this->load->view('networkProductEntryForm',$data);
                $this->load->view('footer');
            }
        }
         
                
        function networkProductEntryList()
        {
            $login_id = $this->session->userdata('login_id');
            $session_id = $this->session->userdata('value');
            if($session_id!=$this->session->userdata('session_id'))
            {
                    $this->logout();
            }
            else
            {
				
				$sql_user_num="select count(*) as rtnValue from inventory_product_info";			
				$segment_three = $this->uri->segment(3);				
				$config = array();
				$config["base_url"] = site_url("report/networkProductEntryList/$segment_three");
				
				$config["total_rows"] = $this->bm->dataReturnDb1($sql_user_num);
				$config["per_page"] = 30;
				$offset = $this->uri->segment(4, 0);
				$config["uri_segment"] = 4;
				$limit=$config["per_page"];
				
				$this->pagination->initialize($config);
				$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;				
				$start=$page;

                if($this->input->post('delete'))
                {
                    $productId=$this->input->post('pid');
                    $deleteSql="DELETE FROM inventory_product_info WHERE inventory_product_info.id='$productId'";
                    $deleteStat=$this->bm->dataDeleteDB1($deleteSql);
                }
				
                $listSql="SELECT inventory_product_info.id, loc_detail_id,location_details, owner_id, full_name, type_id, short_name,prod_name,
                     prod_serial,imei_number, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by, checkStatus, checked_by FROM inventory_product_info 
                     LEFT JOIN `inventory_product_location_details` ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
                     INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
                     INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
					 order by inventory_product_info.id limit $start,$limit";
               
                $list=$this->bm->dataSelectDb1($listSql);
                $data['list']=$list;
				$data['start']=$start;
				$data["links"] = $this->pagination->create_links();

                $data['tableTitle']="PRODUCT LIST";
                $this->load->view('header5');
                $this->load->view('networkProductList',$data);
                $this->load->view('footer_1');
               
            }
        }
		
		
	    function networkProductEntryListBySearch()
        {
            $login_id = $this->session->userdata('login_id');
            $session_id = $this->session->userdata('value');
            if($session_id!=$this->session->userdata('session_id'))
            {
                    $this->logout();
            }
            else
            {
              $search_by = $this->input->post('search_by');
	  
             if($search_by=="serial")
				{
				$serial=trim($this->input->post('searchInput'));
				$data['tableTitle']="Product Serial No:  ".$serial;			 
                    $listSql="SELECT inventory_product_info.id, loc_detail_id,location_details, owner_id, full_name, type_id, short_name,prod_name,
                     prod_serial, imei_number, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by, checkStatus, checked_by FROM inventory_product_info 
                     LEFT JOIN `inventory_product_location_details` ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
                     INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
                     INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
                     WHERE prod_serial='$serial'";            
				}

             else if($search_by=="category")
				{
					$category=trim($this->input->post('searchVal'));
					 
					 $listSql="SELECT inventory_product_info.id, loc_detail_id,location_details, owner_id, full_name, type_id, short_name,prod_name,
						 prod_serial, imei_number, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by, checkStatus, checked_by FROM inventory_product_info 
						 LEFT JOIN `inventory_product_location_details` ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
						 INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
						 INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
						 WHERE type_id='$category'";
						$category_name_sql="SELECT inventory_product_type.id ,IF(short_name='Monitor',CONCAT(short_name,'-',product_desc),short_name) AS detl 
								FROM inventory_product_type WHERE cchaportdb.inventory_product_type.id='$category'";
						$cat_name=$this->bm->dataSelectDb1($category_name_sql);
						$data['tableTitle']="Product category: ".$cat_name[0]['detl'];
					   
					}
             else if($search_by=="product")
			{
			 $product_name=trim($this->input->post('searchInput'));
			 $data['tableTitle']="Product Name:  ".$product_name;		 
             $listSql="SELECT inventory_product_info.id, loc_detail_id,location_details, owner_id, full_name, type_id, short_name,prod_name,
                     prod_serial, imei_number, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by, checkStatus, checked_by FROM inventory_product_info 
                     LEFT JOIN `inventory_product_location_details` ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
                     INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
                     INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
                     WHERE prod_name='$product_name'";
               
			}
            else if($search_by=="location")
			{
			 $location=trim($this->input->post('searchVal'));
			 $data['tableTitle']="Location:  ".$location;
		 
                    $listSql="SELECT inventory_product_info.id, loc_detail_id,location_details, owner_id, full_name, type_id, short_name,prod_name,
                     prod_serial, imei_number, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by, checkStatus, checked_by FROM inventory_product_info 
                     LEFT JOIN inventory_product_location_details ON  inventory_product_location_details.id=inventory_product_info.loc_detail_id
                     INNER JOIN inventory_product_location ON inventory_product_location_details.location_id=inventory_product_location.id
                     INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
                     INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
                     WHERE location_name='$location'";
               
			}
             else if($search_by=="user")
			{
			 $updated_by=trim($this->input->post('searchVal'));
			 $data['tableTitle']="Records updated by:  ".$updated_by;
		 
                    $listSql="SELECT inventory_product_info.id, loc_detail_id,location_details, owner_id, full_name, type_id, short_name,prod_name,
                     prod_serial, imei_number, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by, checkStatus, checked_by FROM inventory_product_info 
                     LEFT JOIN `inventory_product_location_details` ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
                     INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
                     INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
                     WHERE prod_rcv_by ='$updated_by'";
               
			}
			else if($search_by=="ip_addr")
				{
				 $ip_addr=trim($this->input->post('searchInput'));
				 $data['tableTitle']="IP Address:  ".$ip_addr;

				 
							$listSql="SELECT inventory_product_info.id, loc_detail_id,location_details, owner_id, full_name, type_id, short_name,prod_name,
							 prod_serial, imei_number, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by, checkStatus, checked_by FROM inventory_product_info 
							 LEFT JOIN `inventory_product_location_details` ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
							 INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
							 INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
							 WHERE prod_ip='$ip_addr'";  
				}
                $list=$this->bm->dataSelectDb1($listSql);
                $data['list']=$list;

                //$data['tableTitle']="PRODUCT LIST";
                $this->load->view('header5');
                $this->load->view('networkProductList',$data);
                $this->load->view('footer_1');
               
            }
            
        }
		
		 function networkProductCkecked()
        {
            $login_id = $this->session->userdata('login_id');
            $ipaddr = $_SERVER['REMOTE_ADDR'];
            $session_id = $this->session->userdata('value');
            if($session_id!=$this->session->userdata('session_id'))
            {
                $this->logout();
            }
            else
            {
            $chkId=$this->input->post('chkId');    
            $updateSql="UPDATE cchaportdb.inventory_product_info set checkStatus=1, checked_by='$login_id'
                      where inventory_product_info.id='$chkId' and checkStatus=0";   
					 
            $updateStat=$this->bm->dataUpdateDB1($updateSql); 
            
            		
			$sql_user_num="select count(*) as rtnValue from inventory_product_info";			
			$segment_three = $this->uri->segment(3);				
			$config = array();
			$config["base_url"] = site_url("report/networkProductEntryList/$segment_three");
					
			$config["total_rows"] = $this->bm->dataReturnDb1($sql_user_num);
			$config["per_page"] = 30;
			$offset = $this->uri->segment(4, 0);
			$config["uri_segment"] = 4;
			$limit=$config["per_page"];
					
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;				
			$start=$page;

				
                $listSql="SELECT inventory_product_info.id, loc_detail_id,location_details, owner_id, full_name, type_id, short_name,prod_name,
                     prod_serial,imei_number, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by, checkStatus, checked_by FROM inventory_product_info 
                     LEFT JOIN `inventory_product_location_details` ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
                     INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
                     INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
                     order by inventory_product_info.id limit $start,$limit";
               
                $list=$this->bm->dataSelectDb1($listSql);
                $data['list']=$list;
				$data['start']=$start;
				$data["links"] = $this->pagination->create_links();

                $data['tableTitle']="PRODUCT LIST";
                $this->load->view('header5');
                $this->load->view('networkProductList',$data);
                $this->load->view('footer_1');
            }
        }
  
		
		
               
        function workstationList()
        {
            $login_id = $this->session->userdata('login_id');
            $session_id = $this->session->userdata('value');
            if($session_id!=$this->session->userdata('session_id'))
            {
                    $this->logout();
            }
            else
            {

                if($this->input->post('delete'))
                {
                    $productId=$this->input->post('pid');
                    $deleteSql="DELETE FROM inventory_product_info WHERE inventory_product_info.id='$productId'";
                    $deleteStat=$this->bm->dataDeleteDB1($deleteSql);
                }
                $search_by = $this->input->post('search_by');
	  
                if($search_by=="serial")
                  {
                    $serial=trim($this->input->post('searchInput'));
                    $data['tableTitle']="Product Serial No:  ".$serial;
                    $listSql="SELECT inventory_product_info.id, inventory_product_info.loc_detail_id,location_details, inventory_product_info.owner_id,
                        full_name, inventory_product_info.type_id, short_name,inventory_product_info.prod_name,
                        inventory_product_info.prod_serial,inventory_product_info.prod_ip, inventory_product_info.prod_deck_id,
                        inventory_product_info.prod_rcv_date, inventory_product_info.prod_rcv_by,
                        info.prod_name AS mName,info.prod_serial mSerial    
                        FROM inventory_product_info 
                        LEFT JOIN `inventory_product_location_details` ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
                        INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
                        INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
                        LEFT JOIN inventory_workstation_monitor ON inventory_product_info.id=inventory_workstation_monitor.workstation_id
                        LEFT JOIN inventory_product_info info ON info.id=inventory_workstation_monitor.monitor_id
                        WHERE inventory_product_type.id='6' and inventory_product_info.prod_serial='$serial'";            
		}

                 else if($search_by=="ip_addr")
		{
		 $ip_addr=trim($this->input->post('searchInput'));
		 $data['tableTitle']="IP Address:  ".$ip_addr;
		// $data['rot']=$serial;
		 
                      $listSql="SELECT inventory_product_info.id, inventory_product_info.loc_detail_id,location_details, inventory_product_info.owner_id,
                        full_name, inventory_product_info.type_id, short_name,inventory_product_info.prod_name,
                        inventory_product_info.prod_serial,inventory_product_info.prod_ip, inventory_product_info.prod_deck_id,
                        inventory_product_info.prod_rcv_date, inventory_product_info.prod_rcv_by,
                        info.prod_name AS mName,info.prod_serial mSerial    
                        FROM inventory_product_info 
                        LEFT JOIN `inventory_product_location_details` ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
                        INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
                        INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
                        LEFT JOIN inventory_workstation_monitor ON inventory_product_info.id=inventory_workstation_monitor.workstation_id
                        LEFT JOIN inventory_product_info info ON info.id=inventory_workstation_monitor.monitor_id
                        WHERE inventory_product_type.id='6' and inventory_product_info.prod_ip='$ip_addr'";
//                    echo $listSql;
//                    return;
               
		}
               else
               {
                $data['tableTitle']="WORKSTATION LIST";
                $listSql="SELECT inventory_product_info.id, inventory_product_info.loc_detail_id,location_details, inventory_product_info.owner_id,
                        full_name, inventory_product_info.type_id, short_name,inventory_product_info.prod_name,
                        inventory_product_info.prod_serial,inventory_product_info.prod_ip, inventory_product_info.prod_deck_id,
                        inventory_product_info.prod_rcv_date, inventory_product_info.prod_rcv_by,
                        info.prod_name AS mName,info.prod_serial mSerial    
                        FROM inventory_product_info 
                        LEFT JOIN `inventory_product_location_details` ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
                        INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
                        INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
                        LEFT JOIN inventory_workstation_monitor ON inventory_product_info.id=inventory_workstation_monitor.workstation_id
                        LEFT JOIN inventory_product_info info ON info.id=inventory_workstation_monitor.monitor_id
                        WHERE inventory_product_type.id='6'";
               }
                $list=$this->bm->dataSelectDb1($listSql);
                $data['list']=$list;

                
                $this->load->view('header5');
                $this->load->view('workstationProductList',$data);
                $this->load->view('footer_1');
               
            }
            
        }
		
	  function addWorkStationItem()
        {
            $login_id = $this->session->userdata('login_id');
            $session_id = $this->session->userdata('value');
            if($session_id!=$this->session->userdata('session_id'))
            {
                    $this->logout();
            }
            else
            {
                $data['product_info_id'] = $this->input->post('product_info_id');
                $data['product_name'] = $this->input->post('product_name');
                $data['product_serial'] = $this->input->post('product_serial');
                $data['product_model'] = $this->input->post('product_model');

                $monitor_sql="SELECT id,CONCAT(TRIM(prod_name),'-',TRIM(prod_serial)) AS short_name FROM inventory_product_info WHERE type_id IN(13,14,15,16,18,19) ORDER BY 
                            short_name ASC";

                $monitor_list=$this->bm->dataSelectDb1($monitor_sql);
                $data['monitor_list']=$monitor_list;
                
                $data['title']="ADD WORKSTATION ITEM";
                $this->load->view('header2');
                $this->load->view('workStationItemForm',$data);
                $this->load->view('footer');

            }
        }
        
        function addWorkStationItemPerform()
        {
            $login_id = $this->session->userdata('login_id');
            $session_id = $this->session->userdata('value');
            if($session_id!=$this->session->userdata('session_id'))
            {
                    $this->logout();
            }
            else
            {
                $product_info_id = $this->input->post('product_info_id');
                $monitor = $this->input->post('monitor');

                $sql_insert="REPLACE INTO inventory_workstation_monitor(workstation_id, monitor_id) VALUES('$product_info_id','$monitor')";
                $stat=$this->bm->dataInsertDB1($sql_insert);
               // echo $sql_insert;
                //return;
                if($stat==1)
                    $msg="<font color='green'><b>Succesfully inserted</b></font>";
                else
                    $msg="<font color='red'><b>Insertion failed</b></font>";

                $monitor_sql="SELECT id,CONCAT(TRIM(prod_name),'-',TRIM(prod_serial)) AS short_name FROM inventory_product_info WHERE type_id IN(13,14,15,16,18,19) ORDER BY 
                            short_name ASC";    
                $monitor_list=$this->bm->dataSelectDb1($monitor_sql);
                $data['monitor_list']=$monitor_list;
                $data['msg']=$msg;
                $data['title']="ADD WORKSTATION ITEM";
                $this->load->view('header2');
                $this->load->view('workStationItemForm',$data);
                $this->load->view('footer');
                
            }
            
        }
        	   
        
       function networkProductListEdit()
        {
            $login_id = $this->session->userdata('login_id');
            $session_id = $this->session->userdata('value');
            if($session_id!=$this->session->userdata('session_id'))
            {
                    $this->logout();
            }
            else
            {
                $productId=$this->input->post('prodructID');
                
                $selectSql="SELECT inventory_product_info.id, loc_detail_id,location_details, owner_id, full_name, type_id, short_name,prod_name, 
                    `inventory_product_location`.id as loc_id,`location_name`, 
                     prod_serial, imei_number, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by FROM inventory_product_info 
                     LEFT JOIN `inventory_product_location_details` ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
                     INNER JOIN `inventory_product_location` ON `inventory_product_location`.`id`=inventory_product_location_details.`location_id`
                     INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
                     INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
                     WHERE inventory_product_info.id='$productId'";
//                echo $selectSql;
//                return;
                $product_details=$this->bm->dataSelectDb1($selectSql);
                $data['product_details']=$product_details;
                
                $data['editFlag']=1;

                $data['title']="PRODUCT ENTRY FORM.";
                $data['msg']="";
                $data['login_id']=$login_id;

                $product_sql="SELECT id,short_name FROM cchaportdb.inventory_product_type order by short_name asc";
                // echo $jetty_list_query;
                $product_list=$this->bm->dataSelectDb1($product_sql);
                $data['product_list']=$product_list;

                $location_sql="SELECT id, location_name FROM inventory_product_location";
                // echo $jetty_list_query;
                $location_list=$this->bm->dataSelectDb1($location_sql);
                $data['location_list']=$location_list;

                $owner_sql="SELECT id, full_name FROM inventory_product_owner";
                // echo $jetty_list_query;
                $owner_list=$this->bm->dataSelectDb1($owner_sql);
                $data['owner_list']=$owner_list;
                
                $usr_sql="SELECT id,company_name FROM inventory_product_user";
                // echo $jetty_list_query;
                $usr_list=$this->bm->dataSelectDb1($usr_sql);
                $data['usr_list']=$usr_list;

                $this->load->view('header2');
                $this->load->view('networkProductEntryForm',$data);
                $this->load->view('footer');
            }
        }
		
	function networkProductReceive()
        {
           $login_id = $this->session->userdata('login_id');
            $session_id = $this->session->userdata('value');
            if($session_id!=$this->session->userdata('session_id'))
            {
                $this->logout();
            }
            else
            {
            $data['title']="PRODUCT RECEIVED FORM.";
            $data['msg']="";
            $data['login_id']=$login_id;
            $data['editFlag']=0;
            $product_sql="SELECT id,IF(short_name='Monitor',CONCAT(short_name,'-',product_desc),short_name) AS short_name FROM cchaportdb.inventory_product_type ORDER BY short_name ASC";
            // echo $jetty_list_query;
            $product_list=$this->bm->dataSelectDb1($product_sql);
            $data['product_list']=$product_list;
           
            $location_sql="SELECT id, location_name FROM inventory_product_location";
            // echo $jetty_list_query;
            $location_list=$this->bm->dataSelectDb1($location_sql);
            $data['location_list']=$location_list;
            
            $owner_sql="SELECT id, full_name FROM inventory_product_owner";
            // echo $jetty_list_query;
            $owner_list=$this->bm->dataSelectDb1($owner_sql);
            $data['owner_list']=$owner_list;
            
             $usr_sql="SELECT id,company_name FROM inventory_product_user";
            // echo $jetty_list_query;
            $usr_list=$this->bm->dataSelectDb1($usr_sql);
            $data['usr_list']=$usr_list;
                 
            $this->load->view('header2');
            $this->load->view('networkProductReceiveForm',$data);
            $this->load->view('footer');

            }
        }   
        
       function networkProductReceivePerform()
       {
           
            $login_id = $this->session->userdata('login_id');
            $session_id = $this->session->userdata('value');
            if($session_id!=$this->session->userdata('session_id'))
            {
                    $this->logout();
            }
            else
            {
//product_type prod_name product_type rcv_from ownar_id usr_id rcv_date rcv_by
                $product_type=$this->input->post('product_type');
                $prod_name=$this->input->post('prod_name');
                $recv_category=$this->input->post('recv_category');
                $rcv_from=$this->input->post('rcv_from');
                $rcv_date=$this->input->post('rcv_date'); 
              //  $ip_addr=$this->input->post('ip_addr'); 
                $rcv_comment=$this->input->post('rcv_comment'); 
               // $location=$this->input->post('location'); 
                $usr_id=$this->input->post('usr_id'); 
                $ownar_id=$this->input->post('ownar_id'); 
                $rcv_by=$this->input->post('rcv_by'); 
                $ipaddr = $_SERVER['REMOTE_ADDR'];
                
                                
                if($this->input->post('update'))
                   { 
                    $rId=$this->input->post('rcvid'); 
                    //echo $rId;
                    if($rcv_from=='owner'){
                    $updateSql="UPDATE cchaportdb.inventory_product_receive set product_id ='$prod_name', rcv_category='$recv_category', rcv_from='$rcv_from',
                             rcv_frm_owner_user='$ownar_id', rcv_date='$rcv_date', comments='$rcv_comment', rcv_by='$rcv_by', last_update=now(), user_ip='$ipaddr'
                             where inventory_product_receive.id='$rId'";   
                    }
                    else{
                        $updateSql="UPDATE cchaportdb.inventory_product_receive set product_id ='$prod_name', rcv_category='$recv_category', rcv_from='$rcv_from',
                             rcv_frm_owner_user='$usr_id', rcv_date='$rcv_date', comments='$rcv_comment', rcv_by='$rcv_by', last_update=now(), user_ip='$ipaddr' 
                             where inventory_product_receive.id='$rId'";  

                    }
                     $updateStat=$this->bm->dataUpdateDB1($updateSql);  
                                 // echo $tag."=".$updateSql;
                      //return;
                       if($updateStat==1)
                       {
                           $data['msg']="<font size=3 color=green>Data updated successfully.</font>";
                       }
                       else {
                           $data['msg']="<font size=3 color=red>Data not updated.</font>";
                       }
                  }
             else {
                
                if($rcv_from=="owner")
                {
                    $ownerSql="INSERT INTO cchaportdb.inventory_product_receive(`product_id`,  `rcv_category`, `rcv_from`, 
                           `rcv_frm_owner_user`, `rcv_date`, `comments`, `rcv_by`, `last_update`, `user_ip`) 
                            VALUES('$prod_name', '$recv_category', '$rcv_from',
                            '$ownar_id','$rcv_date', '$rcv_comment', '$rcv_by', now(), '$ipaddr' )";

                  //  echo $ownerSql;
                    $insertStat=$this->bm->dataInsertDB1($ownerSql);  
                }
                else
                {
                 $userSql="INSERT INTO cchaportdb.inventory_product_receive(`product_id`,  `rcv_category`, `rcv_from`, 
                   `rcv_frm_owner_user`, `rcv_date`, `comments`, `rcv_by`, `last_update`, `user_ip`) 
                    VALUES('$prod_name', '$recv_category', '$rcv_from',
                   '$usr_id','$rcv_date',  '$rcv_comment', '$rcv_by', now(), '$ipaddr' )";
                // echo $userSql;
                 $insertStat=$this->bm->dataInsertDB1($userSql);  
                   
                }
              if($insertStat==1)
                {
                    $data['msg']="<font size=3 color=green>Data inserted successfully.</font>";
                }
              else
                {
                    $data['msg']="<font size=3 color=red>Data not inserted.</font>";
                }
            }       
            $data['title']="PRODUCT RECEIVED FORM.";
           // $data['msg']="";
            $data['login_id']=$login_id;
            $data['editFlag']=0;
            $product_sql="SELECT id,IF(short_name='Monitor',CONCAT(short_name,'-',product_desc),short_name) AS short_name FROM cchaportdb.inventory_product_type ORDER BY short_name ASC";
            // echo $jetty_list_query;
            $product_list=$this->bm->dataSelectDb1($product_sql);
            $data['product_list']=$product_list;
           
            $location_sql="SELECT id, location_name FROM inventory_product_location";
            // echo $jetty_list_query;
            $location_list=$this->bm->dataSelectDb1($location_sql);
            $data['location_list']=$location_list;
            
            $owner_sql="SELECT id, full_name FROM inventory_product_owner";
            // echo $jetty_list_query;
            $owner_list=$this->bm->dataSelectDb1($owner_sql);
            $data['owner_list']=$owner_list;
            
             $usr_sql="SELECT id,company_name FROM inventory_product_user";
            // echo $jetty_list_query;
            $usr_list=$this->bm->dataSelectDb1($usr_sql);
            $data['usr_list']=$usr_list;
                 
            $this->load->view('header2');
            $this->load->view('networkProductReceiveForm',$data);
            $this->load->view('footer');

            }
           
       }
        
       
     
        
        function networkProductReceiveList()
        {
            $login_id = $this->session->userdata('login_id');
            $session_id = $this->session->userdata('value');
            if($session_id!=$this->session->userdata('session_id'))
            {
                    $this->logout();
            }
            else
            {

                if($this->input->post('delete'))
                {
                    $rcvId=$this->input->post('pid');
                    $deleteSql="DELETE FROM inventory_product_receive WHERE inventory_product_receive.id='$rcvId'";
                    $deleteStat=$this->bm->dataDeleteDB1($deleteSql);
                }
                $listSql="SELECT *
                     FROM ((SELECT inventory_product_receive.id, `product_id`, `prod_name`, `rcv_category`, `rcv_from`,`rcv_frm_owner_user`, full_name AS owner_user,`rcv_date`,`comments`,`rcv_by`
                    FROM `inventory_product_receive` 
                    INNER JOIN `inventory_product_info` ON `inventory_product_receive`.`product_id`=inventory_product_info.`id`
                    INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_receive.rcv_frm_owner_user 
                     WHERE rcv_from='owner')
                    UNION ALL
                    (SELECT `inventory_product_receive`.`id`, `product_id`, `prod_name`, `rcv_category`, `rcv_from`,`rcv_frm_owner_user`, company_name AS owner_user,`rcv_date`,`comments`,`rcv_by`
                    FROM `inventory_product_receive` 
                    INNER JOIN `inventory_product_info` ON `inventory_product_receive`.`product_id`=inventory_product_info.`id`
                    INNER JOIN `inventory_product_user` ON `inventory_product_user`.id=inventory_product_receive.rcv_frm_owner_user 
                    WHERE rcv_from='user' ))a ORDER BY id DESC";
               
                $list=$this->bm->dataSelectDb1($listSql);
                $data['list']=$list;

                $data['tableTitle']="PRODUCT RECEIVED LIST";
                $this->load->view('header2');
                $this->load->view('networkProductReceivedList',$data);
                $this->load->view('footer');              
            }  
        }
        
        function networkProductReceivedEdit()
        {
            $login_id = $this->session->userdata('login_id');
            $session_id = $this->session->userdata('value');
            if($session_id!=$this->session->userdata('session_id'))
            {
                    $this->logout();
            }
            else
            {
                $recvId=$this->input->post('recvID');
                
                $selectSql="SELECT inventory_product_receive.id AS rcv_id, inventory_product_type.id, short_name,`product_id`, `prod_name`, `rcv_category`, `rcv_from`,`rcv_frm_owner_user`, 
                            CASE 
                            WHEN rcv_from='owner' THEN  full_name
                            WHEN rcv_from='user' THEN company_name
                            END
                            AS owner_user,
                    `rcv_date`,`comments`,`rcv_by`
                    FROM `inventory_product_receive` 
                    INNER JOIN `inventory_product_info` ON `inventory_product_receive`.`product_id`=inventory_product_info.`id`
                    INNER JOIN `inventory_product_type` ON `inventory_product_type`.`id`=inventory_product_info.`type_id`
                    LEFT JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_receive.rcv_frm_owner_user
                    AND rcv_from='owner'
                    LEFT JOIN `inventory_product_user` ON `inventory_product_user`.id=inventory_product_receive.rcv_frm_owner_user 
                    AND rcv_from='user'
                    WHERE inventory_product_receive.id='$recvId'";
             //  echo $selectSql;
//                return;
                $product_details=$this->bm->dataSelectDb1($selectSql);
                $data['product_details']=$product_details;                
                $data['editFlag']=1;

                $data['title']="PRODUCT RECEIVED FORM.";
               // $data['msg']="";
                $data['login_id']=$login_id;

				$product_sql="SELECT id,IF(short_name='Monitor',CONCAT(short_name,'-',product_desc),short_name) AS short_name FROM cchaportdb.inventory_product_type ORDER BY short_name ASC";
                // echo $jetty_list_query;
                $product_list=$this->bm->dataSelectDb1($product_sql);
                $data['product_list']=$product_list;

                $location_sql="SELECT id, location_name FROM inventory_product_location";
                // echo $jetty_list_query;
                $location_list=$this->bm->dataSelectDb1($location_sql);
                $data['location_list']=$location_list;

                $owner_sql="SELECT id, full_name FROM inventory_product_owner";
                // echo $jetty_list_query;
                $owner_list=$this->bm->dataSelectDb1($owner_sql);
                $data['owner_list']=$owner_list;

                 $usr_sql="SELECT id,company_name FROM inventory_product_user";
                // echo $jetty_list_query;
                $usr_list=$this->bm->dataSelectDb1($usr_sql);
                $data['usr_list']=$usr_list;

                $this->load->view('header2');
                $this->load->view('networkProductReceiveForm',$data);
                $this->load->view('footer');
            }
                
        }
  
		//Network Product Entry----------------------------------------------------------
		//location details___________________________
		function location_detail_form()
        {
            $session_id = $this->session->userdata('value');
            if($session_id!=$this->session->userdata('session_id'))
		{
		$this->logout();
		}
            else
		{
                $login_id = $this->session->userdata('login_id');
		$data['title']="LOCATION DETAIL FORM...";
		$data['msg']="";
           		
		$location_sql="SELECT id, location_name FROM inventory_product_location";
		$location_list=$this->bm->dataSelectDb1($location_sql);
		$data['location_list']=$location_list;
				
		$this->load->view('header2');
		$this->load->view('location_details_form',$data);
		$this->load->view('footer');
            }
            
        }
		
		
        function location_details_save()
		{
			$session_id = $this->session->userdata('value');
		    if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
                $loc_id=$this->input->post('location');
                $loc_details=$this->input->post('location_detail');
                $login_id = $this->session->userdata('login_id');
                $user_ip=$_SERVER['REMOTE_ADDR'];
                if($this->input->post('update'))
                { 
                    $loc_dt_id=$this->input->post('loc_dt_id');
                    $sql_location_detail_update="UPDATE cchaportdb.inventory_product_location_details set location_id ='$loc_id', location_details='$loc_details', 
                                                            updated_by='$login_id',  updated_time=now(), ip_addr='$user_ip'
                                                            where inventory_product_location_details.id='$loc_dt_id'";
//			
//                                echo $sql_location_detail_update;
//                                return;
//                                
                    $updateStat=$this->bm->dataUpdateDB1($sql_location_detail_update);  
                    if($updateStat==1)
                        $msg="<font size=3 color=green>Data updated successfully.</font>";
                    else 
                         $msg="<font size=3 color=red>Data not updated.</font>";	

                    }
                else{                       
                    $sql_location_detail="INSERT INTO inventory_product_location_details(`location_id`, `location_details`, `updated_by`, `updated_time`, `ip_addr`)
											VALUES('$loc_id','$loc_details','$login_id',NOW(),'$user_ip')";
			
//                               echo $sql_location_detail;
//                                return;
                    $insertStat=$this->bm->dataInsertDB1($sql_location_detail);
                                              //  $rslt_insert_location_name=0;
                    if($insertStat==1)
                           $msg="<font color='green'><b>Succesfully inserted</b></font>";
                     else
                           $msg="<font color='red'><b>Insertion failed</b></font>";
                    }

				$data['title']="LOCATION DETAIL FORM...";
				$data['msg']=$msg;
							
				$location_sql="SELECT id, location_name FROM inventory_product_location";
							// echo $jetty_list_query;
				$location_list=$this->bm->dataSelectDb1($location_sql);
				$data['location_list']=$location_list;
				
				$this->load->view('header2');
				$this->load->view('location_details_form',$data);
				$this->load->view('footer');
			}
			
		}
                
         function location_details_list()
         {
            $session_id = $this->session->userdata('value');
            if($session_id!=$this->session->userdata('session_id'))
				{
				$this->logout();
				}
            else
				{
                if($this->input->post('delete'))
                {
                    $loc_dtl_id=$this->input->post('lid');
                    $deleteSql="DELETE FROM inventory_product_location_details WHERE inventory_product_location_details.id='$loc_dtl_id'";
                    $deleteStat=$this->bm->dataDeleteDB1($deleteSql);
                }
                if($this->input->post('search'))
                {
                    $loc_id=$this->input->post('location');
                    $location_list_Sql="SELECT `inventory_product_location_details`.id as loc_dtl_id, `inventory_product_location_details`.`location_id`,
                   `location_details`, `inventory_product_location`.`location_name` FROM `inventory_product_location_details`
                    INNER JOIN `inventory_product_location` ON `inventory_product_location`.`id`=`inventory_product_location_details`.`location_id`
                    where inventory_product_location.id='$loc_id'";
                }
                else
                {
                 $location_list_Sql="SELECT `inventory_product_location_details`.id as loc_dtl_id, `inventory_product_location_details`.`location_id`,
                   `location_details`, `inventory_product_location`.`location_name` FROM `inventory_product_location_details`
                    INNER JOIN `inventory_product_location` ON `inventory_product_location`.`id`=`inventory_product_location_details`.`location_id`";
                }

                $data['editFlag']=1; 
                $loc_list=$this->bm->dataSelectDb1($location_list_Sql);
                $data['loc_list']=$loc_list;    
				$location_sql="SELECT id, location_name FROM inventory_product_location";
                // echo $jetty_list_query;
                $location_list=$this->bm->dataSelectDb1($location_sql);
                $data['location_list']=$location_list;
				
                $data['title']="LOCATION DETAIL LIST.";
				$this->load->view('header2');
				$this->load->view('location_details_list',$data);
				$this->load->view('footer');          
            }
             
         }
         
         
    function location_details_list_edit()
         {
            $session_id = $this->session->userdata('value');
        if($session_id!=$this->session->userdata('session_id'))
		{
				$this->logout();
		}
        else
		{
                $location_dtl_id=$this->input->post('location_dtl_id');
                 $location_list_Sql="SELECT `inventory_product_location_details`.id as loc_dtl_id, `inventory_product_location_details`.`location_id`,
                   `location_details`, `inventory_product_location`.`location_name`, inventory_product_location.id as locId FROM `inventory_product_location_details`
                    INNER JOIN `inventory_product_location` ON `inventory_product_location`.`id`=`inventory_product_location_details`.`location_id`
                    where`inventory_product_location_details`.id='$location_dtl_id'";
                 
//                 echo $location_list_Sql;
//                 return;

                $loc_list=$this->bm->dataSelectDb1($location_list_Sql);
                $data['loc_list']=$loc_list; 
                $data['editFlag']=1;
                $login_id = $this->session->userdata('login_id');
				$data['title']="LOCATION DETAIL FORM...";
				$data['msg']="";
           		
				$location_sql="SELECT id, location_name FROM inventory_product_location";
				$location_list=$this->bm->dataSelectDb1($location_sql);
				$data['location_list']=$location_list;
						
				$this->load->view('header2');
				$this->load->view('location_details_form',$data);
				$this->load->view('footer');
        }
             
      }
	  
	  //Workstation Report
	  
	  
		function workstationReport()
        {
            $login_id = $this->session->userdata('login_id');
            $session_id = $this->session->userdata('value');
            if($session_id!=$this->session->userdata('session_id'))
            {
                    $this->logout();
            }
            else
            {
				$data['tableTitle']="WORKSTATION REPORT";
				$this->load->view('header2');
                $this->load->view('workstationProductReport',$data);
                $this->load->view('footer');
               
            }
            
        }
		
		 function workstationReportPerform()
        {
            $login_id = $this->session->userdata('login_id');
            $session_id = $this->session->userdata('value');
            if($session_id!=$this->session->userdata('session_id'))
            {
                    $this->logout();
            }
            else
            {

               
                $search_by = $this->input->post('search_by');
	  
                if($search_by=="serial")
                  {
                    $serial=trim($this->input->post('searchInput'));
                    $this->data['tableTitle']="Product Serial No:  ".$serial;
                    $listSql="SELECT inventory_product_info.id, inventory_product_info.loc_detail_id,location_details, inventory_product_info.owner_id,
                        full_name, inventory_product_info.type_id, short_name,inventory_product_info.prod_name,
                        inventory_product_info.prod_serial,inventory_product_info.prod_ip, inventory_product_info.prod_deck_id,
                        inventory_product_info.prod_rcv_date, inventory_product_info.prod_rcv_by,
                        info.prod_name AS mName,info.prod_serial mSerial    
                        FROM inventory_product_info 
                        LEFT JOIN `inventory_product_location_details` ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
                        INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
                        INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
                        LEFT JOIN inventory_workstation_monitor ON inventory_product_info.id=inventory_workstation_monitor.workstation_id
                        LEFT JOIN inventory_product_info info ON info.id=inventory_workstation_monitor.monitor_id
                        WHERE inventory_product_type.id='6' and inventory_product_info.prod_serial='$serial'";            
				}

				 else if($search_by=="ip_addr")
				{
				 $ip_addr=trim($this->input->post('searchInput'));
				 $this->data['tableTitle']="IP Address:  ".$ip_addr;
				// $data['rot']=$serial;
				 
					  $listSql="SELECT inventory_product_info.id, inventory_product_info.loc_detail_id,location_details, inventory_product_info.owner_id,
						full_name, inventory_product_info.type_id, short_name,inventory_product_info.prod_name,
						inventory_product_info.prod_serial,inventory_product_info.prod_ip, inventory_product_info.prod_deck_id,
						inventory_product_info.prod_rcv_date, inventory_product_info.prod_rcv_by,
						info.prod_name AS mName,info.prod_serial mSerial    
						FROM inventory_product_info 
						LEFT JOIN `inventory_product_location_details` ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
						INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
						INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
						LEFT JOIN inventory_workstation_monitor ON inventory_product_info.id=inventory_workstation_monitor.workstation_id
						LEFT JOIN inventory_product_info info ON info.id=inventory_workstation_monitor.monitor_id
						WHERE inventory_product_type.id='6' and inventory_product_info.prod_ip='$ip_addr'";
		//                    echo $listSql;
		//                    return;
					   
				}
		   else
		   {
                $this->data['tableTitle']="WORKSTATION LIST";
                $listSql="SELECT inventory_product_info.id, inventory_product_info.loc_detail_id,location_details, inventory_product_info.owner_id,
                        full_name, inventory_product_info.type_id, short_name,inventory_product_info.prod_name,
                        inventory_product_info.prod_serial,inventory_product_info.prod_ip, inventory_product_info.prod_deck_id,
                        inventory_product_info.prod_rcv_date, inventory_product_info.prod_rcv_by,
                        info.prod_name AS mName,info.prod_serial mSerial    
                        FROM inventory_product_info 
                        LEFT JOIN `inventory_product_location_details` ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
                        INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
                        INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
                        LEFT JOIN inventory_workstation_monitor ON inventory_product_info.id=inventory_workstation_monitor.workstation_id
                        LEFT JOIN inventory_product_info info ON info.id=inventory_workstation_monitor.monitor_id
                        WHERE inventory_product_type.id='6'";
               }
                $list=$this->bm->dataSelectDb1($listSql);
                $this->data['list']=$list;

                $this->load->library('m_pdf');
				$mpdf->use_kwt = true;
				//$this->data['ddl_imp_rot_no']=$ddl_imp_rot_no;
				//$this->data['title']="Country Wise Import Report";

				$html=$this->load->view('workstationReportView',$this->data, true); 
				$pdfFilePath ="garmentContInfoList".time().".pdf";

				//actually, you can pass mPDF parameter on this load() function
				$pdf = $this->m_pdf->load();
				$pdf->SetWatermarkText('CPA CTMS');
				$pdf->showWatermarkText = true;	
								
				//$stylesheet = file_get_contents('resources/styles/test.css'); // external css
				$pdf->setFooter('Developed By : DataSoft|Page {PAGENO}|Date {DATE j-m-Y}');
				$pdf->WriteHTML($html,2);
				$pdf->Output($pdfFilePath, "I"); // For Show Pdf	

			
					//$this->load->view('header5');
                $this->load->view('workstationReportView',$data);
               // $this->load->view('footer_1');
               
            }
            
        }
	  	
	// Equipment Entry Form 
	function equipmentEntryForm()
	{
            $session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
                if($this->input->post('delete'))
                {
                    $eid=$this->input->post('eid');
                    $deleteSql="DELETE FROM ctmsmis.equip_assign_detail WHERE ctmsmis.equip_assign_detail.id='$eid'";
                    $deleteStat=$this->bm->dataDelete($deleteSql);
                }
                $rslt_sql="SELECT id, `workshop_zone`, `equipment`, `equip_num`,non_operational,equip_supply, `updated_by`, `update_time` FROM ctmsmis.equip_assign_detail";
                $result=$this->bm->dataSelect($rslt_sql);			
                $data['result']=$result;
                $data['editFlag']=0;
                $msg="";
                $data['title']="Equipment Assign Entry Form";
                $data['msg']=$msg;
                $this->load->view('header2');
                $this->load->view('equipmentEntryForm',$data);
                $this->load->view('footer');
            }
	}
        
    function equipmentEntryFormPerform()
	{ 
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
			{
			$login_id = $this->session->userdata('login_id');
			$zone=$this->input->post('zone');
			$equipment=$this->input->post('equipment');
			$total_equip=$this->input->post('total_equip');
			$total_supply=$this->input->post('total_supply');
			$nonOperational=$this->input->post('nonOperational');
		
			
			if($this->input->post('go_to_dashboard'))
			{
				//echo "go_to_dashboard";
				$sql_equip_demand="SELECT equipment,tot_equip,tot_out_of_order,tot_supply,IFNULL(tot_demand,0) AS  tot_demand,
				(tot_equip-tot_out_of_order-tot_supply) AS tot_stand_by,DATE(NOW()) AS cur_dt
				FROM (
				SELECT * FROM (SELECT 
				IF(equipment='RST Loaded 45 Ton','RST 45 Ton(L)',equipment) AS equipment,
				SUM(equip_num) AS tot_equip,SUM(non_operational) AS tot_out_of_order,SUM(equip_supply) AS tot_supply 
				FROM ctmsmis.equip_assign_detail
				GROUP BY equipment) tbl
				LEFT JOIN 
				(
				SELECT equip_type,SUM(equip_demand) AS tot_demand 
				FROM ctmsmis.mis_equip_demand 
				WHERE equip_type IS NOT NULL AND equip_type!=''
				GROUP BY equip_type ) tbl2 ON  tbl.equipment=tbl2.equip_type
				) AS final_tbl";
				
				$rslt_equip_demand=$this->bm->dataSelect($sql_equip_demand);
				
				for($i=0;$i<count($rslt_equip_demand);$i++)
				{
					$equipment=$rslt_equip_demand[$i]['equipment'];
					$tot_out_of_order=$rslt_equip_demand[$i]['tot_out_of_order'];
					$cur_dt=$rslt_equip_demand[$i]['cur_dt'];
					$tot_demand=$rslt_equip_demand[$i]['tot_demand'];
					$tot_supply=$rslt_equip_demand[$i]['tot_supply'];
					$tot_stand_by=$rslt_equip_demand[$i]['tot_stand_by'];
										
					$sql_replace_demand_supply="REPLACE INTO ctmsmis.mis_equip_demand_suply(equipment_type,demand_suply_date,demand,suply,stand_by,out_of_order)
					VALUES('$equipment','$cur_dt','$tot_demand','$tot_supply','$tot_stand_by','$tot_out_of_order')";
					
					$rslt_replace_demand_supply=$this->bm->dataInsert($sql_replace_demand_supply);
				}									
				
				if($rslt_replace_demand_supply)								
					$msg="<font color='green'>Dashboard data updated</font>";
				else
					$msg="<font color='red'>Dashboard data not updated</font>";
			}
			else 
			{
				if($zone=="")
				{
					$msg="<font color='red'><b>Please Select Zone.</b></font>";
				}
				else if($equipment=="")
				{
					$msg="<font color='red'><b>Please Select Equipment.</b></font>";
				}
				else
				{
					if($this->input->post('update'))
					{
						$equipID=$this->input->post('equipID');
						$updateSql="UPDATE ctmsmis.equip_assign_detail set workshop_zone ='$zone', equipment='$equipment', equip_num='$total_equip',non_operational='$nonOperational',equip_supply='$total_supply',
									updated_by='$login_id',  update_time=now() where ctmsmis.equip_assign_detail.id='$equipID'";
						$updateStat=$this->bm->dataUpdate($updateSql);
						
						if($updateStat==1)
							$msg="<font color='green'><b>Succesfully Updated</b></font>";
						else
							$msg="<font color='red'><b>Updation failed</b></font>";				
					}
					// goto dashboard - start
					//else 
					// goto dashboard - end
					else
					{				
						$strChk = "select count(id) as rtnValue 
						from ctmsmis.equip_assign_detail where workshop_zone ='$zone' and equipment='$equipment'";
						$rtnVal = $this->bm->dataReturn($strChk);
						
						if($rtnVal>0)
						{
							$msg="<font color='red'><b>Data Already Exist.</b></font>";
						}
						else
						{
							$insert_sql="INSERT INTO ctmsmis.equip_assign_detail(`workshop_zone`, `equipment`, `equip_num`, non_operational,equip_supply,`updated_by`, `update_time`)
							VALUES('$zone','$equipment','$total_equip', '$nonOperational','$total_supply','$login_id', NOW())";							
							$insert_stat=$this->bm->dataInsert($insert_sql);

							if($insert_stat==1)
								$msg="<font color='green'><b>Succesfully inserted</b></font>";
							else
								$msg="<font color='red'><b>Insertion failed</b></font>";
						}
					}				
				}
			}	
			   
		
			$rslt_sql="SELECT id, `workshop_zone`, `equipment`, `equip_num`, `updated_by`,non_operational,equip_supply, `update_time` FROM ctmsmis.equip_assign_detail";
			$result=$this->bm->dataSelect($rslt_sql);			
			$data['result']=$result;

			$data['title']="Equipment Assign Entry Form";
			$data['msg']=$msg;
			$data['editFlag']=0;
			$this->load->view('header2');
			$this->load->view('equipmentEntryForm',$data);
			$this->load->view('footer');
		} 
	}
        
    function equipmentEntryFormEdit()
	{
        $session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{           
            $eqiID= $this->input->post('eqiID');
                
			$select_sql="SELECT id,`workshop_zone`, `equipment`, `equip_num`,non_operational,equip_supply, `updated_by`, `update_time` 
					FROM ctmsmis.equip_assign_detail where equip_assign_detail.id='$eqiID'";
			
			$select_result=$this->bm->dataSelect($select_sql);			
			$data['select_result']=$select_result;
			
			$rslt_sql="SELECT id, `workshop_zone`, `equipment`, `equip_num`,non_operational,equip_supply, `updated_by`, `update_time` FROM ctmsmis.equip_assign_detail";
			$result=$this->bm->dataSelect($rslt_sql);			
			$data['result']=$result;

			$data['editFlag']=1;
			$msg="";
			$data['title']="Equipment Assign Entry Form";
			$data['msg']=$msg;
			$this->load->view('header2');
			$this->load->view('equipmentEntryForm',$data);
			$this->load->view('footer');
        }
	}
	
        
	// SOURAV Equipment Status
	function mis_equipment_cur_stat_rpt()
	{
	   $this->load->view('mis_equipment_current_status');
	   $this->load->view('myclosebar');
  
	}
    // SMS BALANCE ENTRY
	function smsBalanceEntryForm()
	{
        $session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{  
			$rslt_sql="SELECT  id,buy_sms,send_sms,date_sms FROM ctmsmis.sms_transaction_balance WHERE sms_status=0 order by id desc limit 1";
			$result=$this->bm->dataSelect($rslt_sql);			
			$data['result']=$result;
			$msg="";
			$data['title']="Sms Balance Entry Form";
			$data['msg']=$msg;
			$this->load->view('header2');
			$this->load->view('mis_sms_balance_entry',$data);
			$this->load->view('footer');
		}
            
	}
        
    function smsBalanceEntryFormPerform()
    { 
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{			
			$login_id = $this->session->userdata('login_id');
			$buy_sms=trim($this->input->post('buy_sms'))+48;
			$ipaddr = $_SERVER['REMOTE_ADDR'];
			
			$insert_sql="INSERT INTO ctmsmis.sms_transaction_balance (buy_sms,date_sms,updated_by,ip_addr) 
							VALUES ('$buy_sms',now(),'$login_id','$ipaddr')";
					
			$insert_stat=$this->bm->dataInsert($insert_sql);

			if($insert_stat==1)
				$msg="<font color='green'><b>Succesfully inserted</b></font>";
			else
				$msg="<font color='red'><b>Insertion failed</b></font>";   
				//$msg="";
				
			$rslt_sql="SELECT  id,buy_sms,send_sms,date_sms FROM ctmsmis.sms_transaction_balance WHERE sms_status=0 order by id desc limit 1";
			$result=$this->bm->dataSelect($rslt_sql);			
			$data['result']=$result;
	
			$data['title']="Sms Balance Entry Form";
			$data['msg']=$msg;
			$this->load->view('header2');
			$this->load->view('mis_sms_balance_entry',$data);
			$this->load->view('footer');
		} 
    }        	
	
	//assignment_sheet_for_pangaon - start
	function assignment_sheet_for_pangaon()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$msg="";
			$data['title']="ASSIGNMENT SHEET FOR OUTWARD PANGAON";
			$data['msg']=$msg;
			
			$this->load->view('header2');
			$this->load->view('assignment_sheet_for_pangaon_form',$data);
			$this->load->view('footer');
		}
	}
	
	function assignment_sheet_for_pangaon_action()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$pangaon_rot=$this->input->post('pangaon_rot');
			
			$sql_assignment_sheet="SELECT sparcsn4.inv_unit.id AS cont_id,
			(SELECT RIGHT(sparcsn4.ref_equip_type.nominal_length,2) 
			FROM sparcsn4.inv_unit_equip 
			INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey 
			INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey 
			WHERE sparcsn4.inv_unit_equip.unit_gkey=sparcsn4.inv_unit.gkey) AS size,
			sparcsn4.inv_unit.seal_nbr1 AS seal_no,sparcsn4.inv_unit.goods_and_ctr_wt_kg,
			(SELECT NAME FROM sparcsn4.vsl_vessels
			INNER JOIN sparcsn4.vsl_vessel_visit_details vsldtl ON vsldtl.vessel_gkey=sparcsn4.vsl_vessels.gkey
			WHERE  vsldtl.ib_vyg=sparcsn4.inv_unit_fcy_visit.flex_string10) AS vsl_name,
			sparcsn4.inv_unit_fcy_visit.flex_string10 AS rot_no,sparcsn4.ref_bizunit_scoped.id AS mlo,
			(SELECT DATE(ata) FROM sparcsn4.vsl_vessel_berthings
			INNER JOIN sparcsn4.vsl_vessel_visit_details vsldtl ON vsldtl.vvd_gkey=sparcsn4.vsl_vessel_berthings.vvd_gkey
			WHERE  vsldtl.ib_vyg=sparcsn4.inv_unit_fcy_visit.flex_string10 LIMIT 1) AS berthDT
			FROM sparcsn4.vsl_vessel_visit_details
			INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
			INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.actual_ob_cv = sparcsn4.argo_carrier_visit.gkey
			INNER JOIN sparcsn4.inv_unit ON sparcsn4.inv_unit.gkey = sparcsn4.inv_unit_fcy_visit.unit_gkey
			INNER JOIN sparcsn4.ref_bizunit_scoped ON sparcsn4.ref_bizunit_scoped.gkey=sparcsn4.inv_unit.line_op
			WHERE sparcsn4.vsl_vessel_visit_details.ib_vyg='$pangaon_rot'";
			
			$rslt_assignment_sheet=$this->bm->dataSelect($sql_assignment_sheet);
			
			$data['pangaon_rot']=$pangaon_rot;
			$data['rslt_assignment_sheet']=$rslt_assignment_sheet;
			
			$this->load->view('assignment_sheet_for_pangaon_view',$data);
		}
	}
	//assignment_sheet_for_pangaon - end
	
	//head delivery - start
	function head_delivery()
	{
		$is_data=0;
		$is_entry_data=0;
		$data['container']="";
		
		$data['is_data']=$is_data;
		$data['title']="HEAD DELIVERY";
		
		$this->load->view('header2');
		$this->load->view('head_delivery_form',$data);
		$this->load->view('footer');	
	}
	
	function head_delivery_search($container)
	{			
		$is_data=0;
		$is_entry_data=0;
		$msg_insert="";
		$msg="";
		
		if($container!="")
			$cont_no=$container;
		else
			$cont_no=$this->input->post('cont_no');
		
		$data['container']=$cont_no;
		
		//select container data - start
		$sql_info_panel="SELECT a.gkey,IF(LENGTH(a.id)=11,CONCAT(SUBSTR(a.id ,1,4),'-',SUBSTR(a.id ,5,6),'-',SUBSTR(a.id ,11)),a.id ) AS cont_no,k.name AS cf,CONVERT(SUBSTRING(k.name, 1), UNSIGNED INTEGER) AS sl,a.freight_kind AS cont_status,
		IFNULL((SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
		FROM sparcsn4.srv_event
		INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
		WHERE sparcsn4.srv_event.applied_to_gkey=a.gkey AND sparcsn4.srv_event.event_type_gkey IN(18,13,16) AND sparcsn4.srv_event_field_changes.new_value IS NOT NULL AND sparcsn4.srv_event_field_changes.new_value !='' AND sparcsn4.srv_event_field_changes.new_value !='Y-CGP-.' AND sparcsn4.srv_event.gkey<(SELECT sparcsn4.srv_event.gkey FROM sparcsn4.srv_event
		INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
		WHERE sparcsn4.srv_event.event_type_gkey=4 AND sparcsn4.srv_event.applied_to_gkey=a.gkey AND metafield_id='unitFlexString01' AND new_value IS NOT NULL ORDER BY sparcsn4.srv_event_field_changes.gkey DESC LIMIT 1) ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1),(SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
		FROM sparcsn4.srv_event
		INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
		WHERE sparcsn4.srv_event.applied_to_gkey=a.gkey  AND sparcsn4.srv_event.event_type_gkey IN(18,13,16) ORDER BY sparcsn4.srv_event_field_changes.gkey DESC LIMIT 1)) AS slot,
		(SELECT size FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey) AS size,
		((SELECT height FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey)/10) AS height,
		(SELECT IF(SUBSTR(REPLACE(UPPER(LTRIM(vsl_name)),'.',''),1,2)='MV',SUBSTR(REPLACE(LTRIM(vsl_name),'.',''),3),REPLACE(LTRIM(vsl_name),'.','')) FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey) AS v_name,
		(SELECT ctmsmis.mis_inv_unit.vsl_visit_dtls_ib_vyg FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey) AS rot_no,
		g.id AS mlo,j.bl_nbr AS bl_no,
		DATE(b.flex_date01) AS stDate,
		b.flex_date01,
		(SELECT ctmsmis.cont_yard(slot)) AS Yard_No,
		(SELECT ctmsmis.cont_block(slot,Yard_No)) AS Block_No,mfdch_value, mfdch_desc,
				(CASE
				WHEN
					config_metafield_lov.mfdch_value='APPREF'
				THEN
					'REF'
				WHEN
					config_metafield_lov.mfdch_value='DLV2H'
				THEN
					'2H'
				WHEN
					config_metafield_lov.mfdch_value='DLVGRD'
				THEN
					'G'
				WHEN
					config_metafield_lov.mfdch_value='DLVOTH'
				THEN
					'OTH'
				WHEN
					config_metafield_lov.mfdch_value='DLVHYS'
				THEN
					'HC'
				WHEN
					config_metafield_lov.mfdch_value='APPDLV2H'
				THEN
					'2H'
				WHEN
					config_metafield_lov.mfdch_value='APPDLVGRD'
				THEN
					'G'
				WHEN
					config_metafield_lov.mfdch_value='DLVREF2H'
				THEN
					'2H'
				WHEN
					config_metafield_lov.mfdch_value='DLVREFGRD'
				THEN
					'G'
				ELSE
					a.flex_string15
				END
				) AS remarks,b.time_out,a.seal_nbr1
		FROM sparcsn4.inv_unit a
		INNER JOIN sparcsn4.inv_unit_fcy_visit b ON b.unit_gkey=a.gkey
		INNER JOIN sparcsn4.ref_bizunit_scoped g ON a.line_op = g.gkey
		INNER JOIN sparcsn4.config_metafield_lov ON a.flex_string01=config_metafield_lov.mfdch_value
		INNER JOIN
				sparcsn4.inv_goods j ON j.gkey = a.goods
		LEFT JOIN
				sparcsn4.ref_bizunit_scoped k ON k.gkey = j.consignee_bzu
		WHERE a.id='$cont_no' AND config_metafield_lov.mfdch_value NOT IN ('CANCEL') AND a.freight_kind='FCL'
		ORDER BY a.gkey DESC LIMIT 1";
		
		$rslt_info_panel=$this->bm->dataSelect($sql_info_panel);
		
		if(count($rslt_info_panel)>0)
		{
			$is_data=1;
		}
		else
		{
			$msg="Assignment not given for container ".$cont_no;
			
			$data['msg']=$msg;
			$data['title']="HEAD DELIVERY";
		
			$this->load->view('header2');
			$this->load->view('head_delivery_form',$data);
			$this->load->view('footer');
			
			return;
		}
		
		$data['is_data']=$is_data;
		$data['msg']=$msg;
		$data['msg_insert']=$msg_insert;
		
		$data['rslt_info_panel']=$rslt_info_panel;
		
		$rot_no=$rslt_info_panel[0]['rot_no'];
		
		//get bl no of igm - start
		$sql_bl_no="SELECT BL_No AS rtnValue
		FROM igm_details
		INNER JOIN igm_detail_container ON igm_detail_container.igm_detail_id=igm_details.id
		WHERE Import_Rotation_No='$rot_no' AND cont_number='$cont_no'";
		
		$bl_no=$this->bm->dataReturnDb1($sql_bl_no);
		
	//	$bl_no=$rslt_info_panel[0]['bl_no'];		// take with rotation and cont_no in a separate query from igm; not from n4 query stated above.
		//get bl no of igm - end

		$sql_stc_weight="SELECT CONCAT(Pack_Number,' ',Pack_Description) AS stc,CONCAT(weight,' KG') AS weight 
		FROM igm_details 
		WHERE Import_Rotation_No='$rot_no' AND REPLACE(BL_No,'/','')='$bl_no'";
		
		$rslt_stc_weight=$this->bm->dataSelectDb1($sql_stc_weight);
		
		$data['rslt_stc_weight']=$rslt_stc_weight;
		
		//select container data - end
		
		//select container no - start
		
		$sql_cont_no="SELECT DISTINCT cont_number,Description_of_Goods,igm_details.weight 
		FROM igm_details
		INNER JOIN igm_detail_container ON igm_detail_container.igm_detail_id=igm_details.id 
		WHERE BL_No='$bl_no'";
		
		$rslt_cont_no=$this->bm->dataSelectDb1($sql_cont_no);
		
		$data['rslt_cont_no']=$rslt_cont_no;
		
		//select container no - end
		
		//select entry data - start
		$bl_nbr_n4=$rslt_info_panel[0]['bl_no'];
		
		$unit_gkey=$rslt_info_panel[0]['gkey'];
		
		$sql_entry_dlv_dtl="SELECT id,be_no,be_dt,cp_no,cp_dt FROM ctmsmis.mis_head_delivery_detail WHERE bl_nbr='$bl_nbr_n4'";
		
		$rslt_entry_dlv_dtl=$this->bm->dataSelect($sql_entry_dlv_dtl);
		
	//	$data['tot_dlv_qty']=0;
		
		if(count($rslt_entry_dlv_dtl)!=0)
		{
			$dlv_dtl_id=$rslt_entry_dlv_dtl[0]['id'];
			// $data['be_no']=$rslt_entry_dlv_dtl[0]['be_no'];
			// $data['be_dt']=$rslt_entry_dlv_dtl[0]['be_dt'];
			// $data['cp_no']=$rslt_entry_dlv_dtl[0]['cp_no'];
			// $data['cp_dt']=$rslt_entry_dlv_dtl[0]['cp_dt'];
			$data['is_entry_data']=1;
			
			$data['rslt_entry_dlv_dtl']=$rslt_entry_dlv_dtl;
			
			$sql_entry_sub_dtl="SELECT COUNT(*) AS no_of_truck,SUM(qty) AS tot_dlv_qty
			FROM ctmsmis.mis_head_delivery_sub_detail
			WHERE head_dlv_dtl_id='$dlv_dtl_id'";
			
			$rslt_entry_sub_dtl=$this->bm->dataSelect($sql_entry_sub_dtl);
			
			$data['no_of_truck']=$rslt_entry_sub_dtl[0]['no_of_truck'];
			$data['tot_dlv_qty']=$rslt_entry_sub_dtl[0]['tot_dlv_qty'];
		}
		
		//select entry data - end
		
		//be no, date from xml
		$sql_be_no_dt="SELECT office_code,reg_no AS be_no,reg_date AS be_dt
		FROM sad_info
		INNER JOIN sad_container ON sad_container.sad_id=sad_info.id
		WHERE cont_number='$cont_no'";
		
		$rslt_be_no_dt=$this->bm->dataSelectDb1($sql_be_no_dt);
		
		$data['office_code']=$rslt_be_no_dt[0]['office_code'];
		$data['be_no']=$rslt_be_no_dt[0]['be_no'];
		$data['be_dt']=$rslt_be_no_dt[0]['be_dt'];
		
		//----
		
		$data['title']="HEAD DELIVERY";
		
		$this->load->view('head_delivery_form_html',$data);
	
	}
	
	function head_delivery_entry()
	{
		$container=$this->input->post('container');
		$rotation=$this->input->post('rotation');
		
		$unit_gkey=$this->input->post('unit_gkey');
		$bl_no=$this->input->post('bl_no');
		
		$be_no=$this->input->post('be_no');
		$be_date=$this->input->post('be_date');
		$cp_no=$this->input->post('cp_no');
		$cp_date=$this->input->post('cp_date');
		
		$total_dlv_truck=$this->input->post('total_dlv_truck');
		$total_dlv_quantity=$this->input->post('total_dlv_quantity');
		
		$truck_no=$this->input->post('truck_no');
		$quantity=$this->input->post('quantity');
		
		$dlv_by=$this->session->userdata('login_id');
		$ipaddr = $_SERVER['REMOTE_ADDR'];
		
		//insert head_dlv_dtl - start
		$rtn_unit_gkey=0;
		
		$sql_unit_gkey="SELECT COUNT(*) AS rtnValue FROM ctmsmis.mis_head_delivery_detail WHERE unit_gkey='$unit_gkey'";
		
		$rtn_unit_gkey=$this->bm->dataReturn($sql_unit_gkey);
		
		if($rtn_unit_gkey==0)
		{
			$sql_insert_dlv_dtl="INSERT INTO ctmsmis.mis_head_delivery_detail(unit_gkey,bl_nbr,cont_id,rotation,be_no,be_dt,cp_no,cp_dt,dlv_dt,dlv_by,ip_addr)
			VALUES('$unit_gkey','$bl_no','$container','$rotation','$be_no','$be_date','$cp_no','$cp_date',NOW(),'$dlv_by','$ipaddr')";
		
			$rslt_insert_dlv_dtl=$this->bm->dataInsert($sql_insert_dlv_dtl);
		}				
		
		//insert head_dlv_dtl - end
		
		//insert head_dlv_sub_dtl - start
		$sql_dlv_dtl_id="SELECT id AS rtnValue FROM ctmsmis.mis_head_delivery_detail WHERE unit_gkey='$unit_gkey'";
		
		$head_dlv_id=$this->bm->dataReturn($sql_dlv_dtl_id);
	
		$sql_insert_dlv_sub_dtl="INSERT INTO ctmsmis.mis_head_delivery_sub_detail(head_dlv_dtl_id,truck_no,qty,entry_dt,entry_by)
		VALUES('$head_dlv_id','$truck_no','$quantity',NOW(),'$dlv_by')";
		
		$rslt_insert_dlv_sub_dtl=$this->bm->dataInsert($sql_insert_dlv_sub_dtl);
		
		//if($rslt_insert_dlv_dtl==1 and $rslt_insert_dlv_sub_dtl==1)
		if($rslt_insert_dlv_sub_dtl==1)
			$data['msg_insert']="Successfully inserted";
		//insert head_dlv_sub_dtl - end
	
		$this->head_delivery_search($container);
	}
	
	function head_dlv_delete()
	{
		$sub_dtl_id=$this->input->post('sub_dtl_id');
		$cont_for_sub_dtl=$this->input->post('cont_for_sub_dtl');
		
		$sql_head_dlv_delete="DELETE FROM ctmsmis.mis_head_delivery_sub_detail
							WHERE id='$sub_dtl_id'";
							
		$rslt_head_dlv_delete=$this->bm->dataDelete($sql_head_dlv_delete);
		
		$this->head_delivery_search($cont_for_sub_dtl);
	}
	
	function head_dlv_status_action()
	{
		$dlv_val=$this->input->post('dlv_val');
		$container_dlv=$this->input->post('container_dlv');
	
		$unit_gkey_dlv=$this->input->post('unit_gkey_dlv');
	
		$sql_status_update="UPDATE ctmsmis.mis_head_delivery_detail 
							SET dlv_status='$dlv_val',status_dt=NOW()
							WHERE unit_gkey='$unit_gkey_dlv'";
	
		$rslt_status_update=$this->bm->dataUpdate($sql_status_update);
		
		$this->head_delivery_search($container_dlv);
	}
	
	// OLD - uncomment following section (till head delivery - eend) if necessary
	
	  // function headDeliveryForm()
        // {
            // $login_id = $this->session->userdata('login_id');
           // // $ipaddr = $_SERVER['REMOTE_ADDR'];
            // $session_id = $this->session->userdata('value');
            // if($session_id!=$this->session->userdata('session_id'))
            // {
                // $this->logout();
            // }
            // else
            // {       
                // $data['title']="Head Delivery Search";
                // $this->load->view('header2');
                // $this->load->view('headDeliveryInfoForm',$data);
                // $this->load->view('footer');
            // }
            
        // }
        
        // function headDeliveryPerformPDF()
        // {
            // $login_id = $this->session->userdata('login_id');
            // $session_id = $this->session->userdata('value');
            // if($session_id!=$this->session->userdata('session_id'))
            // {
                // $this->logout();
            // }
            
            // else {
                // $this->load->library('m_pdf');
                // $cont=$this->input->post('cont');
                // //echo $rot;
                // $this->data['title']="HEAD DELIVERY REGISTER REPORT OF CCT ".$cont;

                // $str = "SELECT a.gkey,IF(LENGTH(a.id)=11,CONCAT(SUBSTR(a.id ,1,4),'-',SUBSTR(a.id ,5,6),'-',SUBSTR(a.id ,11)),a.id ) AS cont_no,a.id AS contid,k.name AS cf,CONVERT(SUBSTRING(k.name, 1), UNSIGNED INTEGER) AS sl,
		// a.freight_kind AS cont_status,
		// IFNULL((SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
		// FROM sparcsn4.srv_event
		// INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
		// WHERE sparcsn4.srv_event.applied_to_gkey=a.gkey  AND sparcsn4.srv_event.event_type_gkey IN(18,13,16) AND sparcsn4.srv_event_field_changes.new_value IS NOT NULL AND sparcsn4.srv_event_field_changes.new_value !='' AND sparcsn4.srv_event_field_changes.new_value !='Y-CGP-.' AND sparcsn4.srv_event.gkey<(SELECT sparcsn4.srv_event.gkey FROM sparcsn4.srv_event
		// INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
		// WHERE sparcsn4.srv_event.event_type_gkey=4 AND sparcsn4.srv_event.applied_to_gkey=a.gkey AND metafield_id='unitFlexString01' AND new_value IS NOT NULL ORDER BY sparcsn4.srv_event_field_changes.gkey DESC LIMIT 1) ORDER BY sparcsn4.srv_event.gkey DESC LIMIT 1),(SELECT SUBSTRING(sparcsn4.srv_event_field_changes.new_value,7)
		// FROM sparcsn4.srv_event
		// INNER JOIN sparcsn4.srv_event_field_changes ON sparcsn4.srv_event_field_changes.event_gkey=sparcsn4.srv_event.gkey
		// WHERE sparcsn4.srv_event.applied_to_gkey=a.gkey  AND sparcsn4.srv_event.event_type_gkey IN(18,13,16) ORDER BY sparcsn4.srv_event_field_changes.gkey DESC LIMIT 1)) AS slot,
		// (SELECT size FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey) AS size,
		// ((SELECT height FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey)/10) AS height,
		// (SELECT IF(SUBSTR(REPLACE(UPPER(LTRIM(vsl_name)),'.',''),1,2)='MV',SUBSTR(REPLACE(LTRIM(vsl_name),'.',''),3),REPLACE(LTRIM(vsl_name),'.','')) FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey) AS v_name,
		// (SELECT ctmsmis.mis_inv_unit.vsl_visit_dtls_ib_vyg FROM ctmsmis.mis_inv_unit WHERE gkey=a.gkey) AS rot_no,
		// g.id AS mlo,j.bl_nbr AS bl_no,
			    // DATE(b.flex_date01) AS stDate,
			    // b.flex_date01,
		// (SELECT ctmsmis.cont_yard(slot)) AS Yard_No,
			    // (SELECT ctmsmis.cont_block(slot,Yard_No)) AS Block_No,mfdch_value, mfdch_desc,
			   // b.time_out,a.seal_nbr1
		// FROM sparcsn4.inv_unit a
		// INNER JOIN sparcsn4.inv_unit_fcy_visit b ON b.unit_gkey=a.gkey
		// INNER JOIN sparcsn4.ref_bizunit_scoped g ON a.line_op = g.gkey
		// INNER JOIN sparcsn4.config_metafield_lov ON a.flex_string01=config_metafield_lov.mfdch_value
		// INNER JOIN
			    // sparcsn4.inv_goods j ON j.gkey = a.goods
		// LEFT JOIN
			    // sparcsn4.ref_bizunit_scoped k ON k.gkey = j.consignee_bzu
		// WHERE a.id='$cont' AND config_metafield_lov.mfdch_value NOT IN ('CANCEL') AND a.freight_kind='FCL'";
		
                // $head_result = $this->bm->dataSelect($str);  	
                // $this->data['head_result']=$head_result;                             
                // /*$bl_no=$head_result[0]['bl_no'];
                // $unit_gkey=$head_result[0]['gkey'];
                
// //                echo $unit_gkey;
// //                return;
                
                // $str1="SELECT  igm_details.id,cont_number,igm_details.Import_Rotation_No,(SELECT Vessel_Name FROM igm_masters 
                    // WHERE igm_masters.id=igm_details.IGM_id) AS vsl_name,igm_details.BL_No, cont_size,cont_height,off_dock_id, 
                    // (SELECT Organization_Name FROM organization_profiles 
                    // WHERE organization_profiles.id=igm_detail_container.off_dock_id) AS offdock_name, cont_status,cont_seal_number,
                    // cont_iso_type, igm_details.Pack_Number, igm_details.Pack_Description, igm_detail_container.cont_gross_weight  AS cont_weight 
                    // FROM igm_detail_container  
                    // INNER JOIN igm_details ON igm_details.id=igm_detail_container.igm_detail_id  
                    // WHERE igm_details.BL_No='$bl_no' 
                    // UNION 
                    // SELECT igm_details.id,cont_number,igm_details.Import_Rotation_No,(SELECT Vessel_Name FROM igm_masters  
                    // WHERE igm_masters.id=igm_supplimentary_detail.igm_master_id) AS vsl_name,igm_details.BL_No, cont_size,cont_height,off_dock_id, 
                    // (SELECT Organization_Name FROM organization_profiles 
                    // WHERE organization_profiles.id=igm_sup_detail_container.off_dock_id) AS offdock_name,
                    // cont_status,cont_seal_number,cont_iso_type, igm_details.Pack_Number, igm_details.Pack_Description, igm_sup_detail_container.Cont_gross_weight AS cont_weight
                    // FROM igm_sup_detail_container 
                    // INNER JOIN igm_supplimentary_detail ON igm_supplimentary_detail.id=igm_sup_detail_container.igm_sup_detail_id 
                    // INNER JOIN igm_details ON igm_details.id=igm_supplimentary_detail.igm_detail_id 
                    // WHERE igm_supplimentary_detail.BL_No='$bl_no'";
                // $sqlresult = $this->bm->dataSelectDb1($str1);                
                // $this->data['sqlresult']=$sqlresult;
               // // $this->data['title']="";
                
                // $str3="SELECT be_no, be_dt, cp_no, cp_dt FROM ctmsmis.mis_head_delivery_detail 
                        // WHERE mis_head_delivery_detail.unit_gkey='$unit_gkey'";
                 // $dlv_result = $this->bm->dataSelect($str3);  	
                // $this->data['dlv_result']=$dlv_result;*/     
                // $html=$this->load->view('headDeliveryViewPdf', $this->data,true);
                // //$html=$this->load->view('pdf_output', $data); //pdf_output for rotation

                // //this the the PDF filename that user will get to download
                // $pdfFilePath ="mypdfName-".time()."-download.pdf";

                // //actually, you can pass mPDF parameter on this load() function
                // $pdf = $this->m_pdf->load();

// //                $pdf->SetHeader('|Date: {DATE j-m-Y}|');

                // //$pdf->SetHeader($url . "\n\n" . 'Date {DATE j-m-Y}');
                // $pdf->setFooter('|Page {PAGENO}|');
                // //generate the PDF!
                // $pdf->WriteHTML($html,2);
                // //offer it to user via browser download! (The PDF won't be saved on your server HDD)
                // $pdf->Output($pdfFilePath, "I");   //--------pdf view show
                // //$pdf->Output($pdfFilePath, "D");  //-------pdf download					
                // }
            
            
        // }
  
	//head delivery - end
	
	// Special Feeder Discharge Summary Sourav
	function reportSpecial()
	{
		//print_r($this->session->all_userdata());
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$data['title']="FEEDER DISCHARGE SUMMARY LIST SPECIAL...";
			$this->load->view('header2');
			$this->load->view('myFeederDischargeSpecialHTML',$data);
			$this->load->view('footer');
		}	
       }
	function specialReportView()
	{
		$rptType=$this->input->post('options');
		if($rptType=='pdf')
		{
			//$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
			$this->load->library('m_pdf');
			$pdf->use_kwt = true;
			$this->data['title']="FEEDER DISCHARGE Summary LIST";
			$pdfFilePath ="FEEDER DISCHARGE Summary LIST-".time()."-download.pdf";
			$pdf = $this->m_pdf->load();
			$pdf->SetWatermarkText('CPA CTMS');
			$pdf->showWatermarkText = true;	
			$pdf->useAdobeCJK = true;
			$pdf->SetAutoFont(AUTOFONT_ALL);
			
			$html=$this->load->view('myReportDischargeSummeryListSpecial',$this->data, true);
			$stylesheet = file_get_contents('resources/styles/test.css'); // external css
			$pdf->useSubstitutions = true; // optional - just as an example
			
			$pdf->setFooter('Developed By : DataSoft|Page {PAGENO} of {nb}|Date {DATE j-m-Y}');
			
			$pdf->WriteHTML($stylesheet,1);
			$pdf->WriteHTML($html,2);
			$pdf->Output($pdfFilePath, "I"); // For Show Pdf
		}
		else{
			$this->load->view('myReportDischargeSummeryListSpecial');
			//$this->load->view('footer');
		}
	}
	
	
	function icdInboundOutboundContainerReport()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			// $query = "SELECT DISTINCT gkey, id FROM sparcsn4.road_gates WHERE life_cycle_state='ACT'";
			// $gateList = $this->bm->dataSelect($query);
				
			// $data['gateList']=$gateList;
			$data['title']="ICD INBOUND OUTBOUND REPORT";
			//echo $data['title'];
			$this->load->view('header2');
			$this->load->view('icdInboundOutboundContainerForm',$data);
			$this->load->view('footer');
		}	
		
	}	
		
		
	function icdInboundOutboundContainerReportView()
		{
			//	$fileType=$this->input->post('fileOptions');
			//	$registerType=$this->input->post('registerType');
				$visitType=$this->input->post('visitType');
				$vist_id=$this->input->post('vist_id');
			   if($visitType=="inbound")
			   {  
					$str="SELECT sparcsn4.vsl_vessels.name,inv_unit.id AS cont,  inv_unit_fcy_visit.time_in,
					 inv_unit_fcy_visit.time_out, inv_unit_fcy_visit.flex_string10 AS rot_no,
					RIGHT(sparcsn4.ref_equip_type.nominal_length,2) AS size,
					RIGHT(sparcsn4.ref_equip_type.nominal_height,2) AS height
					FROM sparcsn4.inv_unit
					INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
					INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv

					INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.unit_gkey=inv_unit.gkey
					INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
					INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
					LEFT JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.ib_vyg=sparcsn4.inv_unit_fcy_visit.flex_string10
					LEFT JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
					WHERE sparcsn4.argo_carrier_visit.id='$vist_id'";		
				//	$data['title']="ICD INBOUND CONTAINER LIST";
			   }
			    else if($visitType=="outbound")
			   {  
					$str="SELECT sparcsn4.vsl_vessels.name,inv_unit.id AS cont,  inv_unit_fcy_visit.time_in,
					 inv_unit_fcy_visit.time_out, inv_unit_fcy_visit.flex_string10 AS rot_no,
					RIGHT(sparcsn4.ref_equip_type.nominal_length,2) AS size,
					RIGHT(sparcsn4.ref_equip_type.nominal_height,2) AS height
					FROM sparcsn4.inv_unit
					INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
					INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ob_cv

					INNER JOIN sparcsn4.inv_unit_equip ON sparcsn4.inv_unit_equip.unit_gkey=inv_unit.gkey
					INNER JOIN sparcsn4.ref_equipment ON sparcsn4.ref_equipment.gkey=sparcsn4.inv_unit_equip.eq_gkey
					INNER JOIN sparcsn4.ref_equip_type ON sparcsn4.ref_equip_type.gkey=sparcsn4.ref_equipment.eqtyp_gkey
					LEFT JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.ib_vyg=sparcsn4.inv_unit_fcy_visit.flex_string10
					LEFT JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
					WHERE sparcsn4.argo_carrier_visit.id='$vist_id'";
				   
				//   $data['title']="ICD OUTBOUND CONTAINER LIST";	
				}	
			
			
			$result = $this->bm->dataSelect($str);
			$data['result']=$result;			
			$data['vist_id']=$vist_id;	
			$this->load->view('icdInboundOutboundContainerView',$data);

	   }  
	
	//xml conversion - start
	function xml_conversion()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$msg="";
			
			$sql_be_num="SELECT COUNT(*) AS rtnValue FROM sad_info";
			
			if(($this->uri->segment(4))=="")
				$segment_three=0;
			else
				$segment_three = $this->uri->segment(3);
			
			$config = array();
			$config["base_url"] = site_url("report/xml_conversion/$segment_three");
			$config["total_rows"] = $this->bm->dataReturnDb1($sql_be_num);
			
			$config["per_page"] = 20;
			$offset = $this->uri->segment(4, 0);
			$config["uri_segment"] = 4;
			$limit=$config["per_page"];
			
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			$start=$page;
			
			$sql_list_of_be="SELECT office_code,reg_no,reg_date FROM sad_info ORDER BY id DESC LIMIT $start,$limit";
			
			$rslt_list_of_be=$this->bm->dataSelectDb1($sql_list_of_be);
			
			if(count($rslt_list_of_be)==0)
				$msg="No result found";
			
			$data['title']="BE ENTRY...";
			$data['msg']=$msg;
			$data['rslt_list_of_be']=$rslt_list_of_be;
			$data['start']=$start;
			$data["links"] = $this->pagination->create_links();
			
			$this->load->view('header2');
			$this->load->view('xml_conversion_form',$data);
			$this->load->view('footer');
		}
	}
	
	function search_be_list()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$cond="";
			$msg="";
			
			if($this->input->post('search_office_code'))
			{
				$search_office_code=$this->input->post('search_office_code');
				$cond=" WHERE office_code='$search_office_code'";
			}
			else if($this->input->post('search_c_number'))
			{
				$search_c_number=$this->input->post('search_c_number');
				$cond=" WHERE reg_no='$search_c_number'";
			}
			else if($this->input->post('search_c_date'))
			{
				$search_c_date=$this->input->post('search_c_date');
				$cond=" WHERE reg_date='$search_c_date'";
			}
			else if($this->input->post('search_entry_date'))
			{
				$search_entry_date=$this->input->post('search_entry_date');
				$cond=" WHERE DATE(entry_dt)='$search_entry_date'";
			}
			else if($this->input->post('search_cont_no'))
			{
				$search_cont_no=$this->input->post('search_cont_no');
				$cond=" INNER JOIN sad_container ON sad_container.`sad_id`=sad_info.`id`
						WHERE sad_container.`cont_number`='$search_cont_no'";
			}				
			
			$sql_search_be_list="SELECT office_code,reg_no,reg_date FROM sad_info".$cond;
			
			$rslt_list_of_be=$this->bm->dataSelectDb1($sql_search_be_list);
			
			if(count($rslt_list_of_be)==0)
				$msg="No result found";
			
			$data['title']="BE ENTRY...";
			$data['msg']=$msg;
			$data['rslt_list_of_be']=$rslt_list_of_be;
			
			$this->load->view('header2');
			$this->load->view('xml_conversion_form',$data);
			$this->load->view('footer');					
		}
	}
	
	// function xml_conversion_action()
	// {
		// $session_id = $this->session->userdata('value');
		// if($session_id!=$this->session->userdata('session_id'))
		// {
			// $this->logout();
		// }
		// else
		// {
			// $login_id = $this->session->userdata('login_id');
			// $this->load->library('m_pdf');
		    // $mpdf->use_kwt = true;
			
			// $flag=$this->uri->segment(3);
			
			// if($flag==1)
			// {
				// $office_code=$this->uri->segment(4);
			 	// $c_nubmber=$this->uri->segment(5);
				// $xml_date=$this->uri->segment(6);
			// }
			// else
			// {
				// $office_code=$this->input->post('office_code');
				// $c_nubmber=$this->input->post('c_nubmber');
				// $xml_date=$this->input->post('xml_date');
			// }
							
			// // $sql_show_report="SELECT * 
			// // FROM sad_info
			// // INNER JOIN sad_container ON sad_container.sad_id=sad_info.id
			// // INNER JOIN sad_item ON sad_item.sad_id=sad_info.id
			// // WHERE sad_info.office_code='$office_code' AND reg_no='$c_nubmber' AND reg_date='$xml_date'";
			
			// $sql_show_report="SELECT * 
			// FROM sad_info
			// INNER JOIN sad_item ON sad_item.sad_id=sad_info.id
			// WHERE sad_info.office_code='$office_code' AND reg_no='$c_nubmber' AND reg_date='$xml_date'";
							
			// $rslt_show_report=$this->bm->dataSelectDb1($sql_show_report);
			// // $data['rslt_show_report']=$rslt_show_report;
			// // $this->load->view('xml_conversion_pdf',$data);
			// $this->data['rslt_show_report']=$rslt_show_report;
						
			// $dec_ref_no=$rslt_show_report[0]['dec_ref_no'];
			// $dec_ref_no=substr($dec_ref_no,1);
			// $dec_ref_no="/C".$dec_ref_no;
			
			// $this->data['dec_ref_no']=$dec_ref_no;
			
			// $vsl_rot=$rslt_show_report[0]['manif_num'];
			// $vsl_rot=str_replace(" ","/",$vsl_rot);
			
			// $sql_vsl_name="SELECT Vessel_Name AS rtnValue FROM igm_masters WHERE Import_Rotation_No='$vsl_rot'";
			
			// $vsl_name=$this->bm->dataReturnDb1($sql_vsl_name);
			// $this->data['vsl_name']=$vsl_name;
			
			// $pdf = $this->m_pdf->load();
			// $stylesheet = file_get_contents('resources/styles/xml_conversion.css'); // external css
			
			// $pdf->AddPage('P', // L - landscape, P - portrait
						// '', '', '', '',
						// 5, // margin_left
						// 5, // margin right
						// 10, // margin top
						// 10, // margin bottom
						// 10, // margin header
						// 10); // margin footer
					
			// $html=$this->load->view('xml_conversion_pdf',$this->data, true);
										
			// $pdfFilePath ="xml_conversion_pdf-".time()."-download.pdf";

		// //	$pdf = $this->m_pdf->load();
			
			// $pdf->useSubstitutions = true; 
					
		// //	$pdf->setFooter('Prepared By : '.$login_id.'|Page {PAGENO}|Date {DATE j-m-Y}');
			
			// $pdf->WriteHTML($stylesheet,1);
			// $pdf->WriteHTML($html,2);
					
			// $pdf->Output($pdfFilePath, "I");
			// // $data['rslt_show_report']=$rslt_show_report;
			
			// // $this->load->view('xml_conversion_html',$data);
		// }
	// }
	
	function xml_conversion_action()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			// if($this->input->post('view')=="View")
			// {
				$login_id = $this->session->userdata('login_id');
				$this->load->library('m_pdf');
				$mpdf->use_kwt = true;
				
				$flag=$this->uri->segment(3);
				
				if($flag==1)
				{
					$office_code=$this->uri->segment(4);
					$c_nubmber=$this->uri->segment(5);
					$xml_date=$this->uri->segment(6);
				}
				else
				{
					$office_code=$this->input->post('office_code');
					$c_nubmber=$this->input->post('c_nubmber');
					$xml_date=$this->input->post('xml_date');
				}							
				
				$sql_show_report="SELECT * 
				FROM sad_info
				INNER JOIN sad_item ON sad_item.sad_id=sad_info.id
				WHERE sad_info.office_code='$office_code' AND reg_no='$c_nubmber' AND reg_date='$xml_date'";
							
				$rslt_show_report=$this->bm->dataSelectDb1($sql_show_report);
				
				$this->data['rslt_show_report']=$rslt_show_report;
							
				$dec_ref_no=$rslt_show_report[0]['dec_ref_no'];
				$dec_ref_no=substr($dec_ref_no,1);
				$dec_ref_no="/C".$dec_ref_no;
				
				$this->data['dec_ref_no']=$dec_ref_no;				
				
				//--						
				$vsl_rot=$rslt_show_report[0]['manif_num'];	
				//$vsl_rot=str_replace(" ","/",$vsl_rot);				
				$cnt=substr_count($vsl_rot," ");
		
				if($cnt==1)
				{
					$index=strpos($vsl_rot," ");				
					$first_str=substr($vsl_rot,0,$index);			
					$last_str=substr($vsl_rot,$index);
					$last_str=(int)$last_str;			
					$vsl_rot=$first_str."/".$last_str;	
				}
				else if($cnt==2)
				{
					$index=strpos($vsl_rot," ");
					$vsl_rot=trim(substr($vsl_rot,$index));
					$index=strpos($vsl_rot," ");
					$first_str=substr($vsl_rot,0,$index);			
					$last_str=substr($vsl_rot,$index);
					$last_str=(int)$last_str;					
					$vsl_rot=$first_str."/".$last_str;	
				}
				//--							
				
				$sql_vsl_name="SELECT Vessel_Name AS rtnValue FROM igm_masters WHERE Import_Rotation_No='$vsl_rot'";
			//	return;
				$vsl_name=$this->bm->dataReturnDb1($sql_vsl_name);
				$this->data['vsl_name']=$vsl_name;
				
				//cont list - start
				$sql_cont_info="SELECT * FROM sad_container
				INNER JOIN sad_info ON sad_info.id=sad_container.sad_id 
				WHERE office_code='$office_code' AND reg_no='$c_nubmber' AND reg_date='$xml_date'";
				
				$rslt_cont_info=$this->bm->dataSelectDb1($sql_cont_info);
				
				//--
				$this->data['rslt_cont_info']=$rslt_cont_info;			
				//cont list - end
				
				$pdf = $this->m_pdf->load();
				
				//$pdf->SetWatermarkText('CPA CTMS');
				//$pdf->showWatermarkText = true;
				
				$stylesheet = file_get_contents('resources/styles/xml_conversion.css'); // external css							
				
				$pdf->AddPage('P', // L - landscape, P - portrait
							'', '', '', '',
							5, // margin_left
							5, // margin right
							10, // margin top
							10, // margin bottom
							10, // margin header
							10); // margin footer
						
				$html=$this->load->view('xml_conversion_pdf',$this->data, true);
									
				$pdfFilePath ="xml_conversion_pdf-".time()."-download.pdf";
				
				$pdf->useSubstitutions = true; 					
				
				$pdf->WriteHTML($stylesheet,1);
				$pdf->WriteHTML($html,2);
						
				$pdf->Output($pdfFilePath, "I");				
			// }
			// else if($this->input->post('view')=="View Container")
			// {
				// $login_id = $this->session->userdata('login_id');
				// $this->load->library('m_pdf');
				// $mpdf->use_kwt = true;
				
				// $office_code=$this->input->post('office_code');
				// $c_nubmber=$this->input->post('c_nubmber');
				// $xml_date=$this->input->post('xml_date');
				
				// $sql_cont_info="SELECT * FROM sad_container
				// INNER JOIN sad_info ON sad_info.id=sad_container.sad_id 
				// WHERE office_code='$office_code' AND reg_no='$c_nubmber' AND reg_date='$xml_date'";
				
				// $rslt_cont_info=$this->bm->dataSelectDb1($sql_cont_info);
				
				// //--
				// $this->data['rslt_cont_info']=$rslt_cont_info;								
				
				// $pdf = $this->m_pdf->load();
				
				// $pdf->SetWatermarkText('CPA CTMS');
				// $pdf->showWatermarkText = true;
				
				// $stylesheet = file_get_contents('resources/styles/xml_conversion.css'); // external css
				
				// $pdf->AddPage('P', // L - landscape, P - portrait
							// '', '', '', '',
							// 5, // margin_left
							// 5, // margin right
							// 10, // margin top
							// 10, // margin bottom
							// 10, // margin header
							// 10); // margin footer
						
				// $html=$this->load->view('xml_conversion_cont_info',$this->data, true);
											
				// $pdfFilePath ="xml_conversion_cont_info-".time()."-download.pdf";
				
				// $pdf->useSubstitutions = true; 					
				
				// $pdf->WriteHTML($stylesheet,1);
				// $pdf->WriteHTML($html,2);
						
				// $pdf->Output($pdfFilePath, "I");	
				// //--				
			// }
		}
	}
	
	//date wise be report - start
	function date_wise_be_report()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$data['title']="DATE WISE Bill of Entry REPORT...";
			
			$this->load->view('header2');
			$this->load->view('date_wise_be_report_form',$data);
			$this->load->view('footer');
		}
	}
	
	function date_wise_be_report_action()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$be_entry_date=$this->input->post('be_entry_date');
			
			$sql_be_report_datewise="SELECT COUNT(*) AS tot_entry,ip_address,entry_dt
			FROM sad_info
			WHERE DATE(entry_dt)='$be_entry_date'
			GROUP BY ip_address";
			
			$rslt_be_report_datewise=$this->bm->dataSelectDb1($sql_be_report_datewise);
			
			$this->load->library('m_pdf');
			$mpdf->use_kwt = true;
			
			//--
			$this->data['rslt_be_report_datewise']=$rslt_be_report_datewise;								
			$this->data['be_entry_date']=$be_entry_date;								
				
			$pdf = $this->m_pdf->load();
			
			$pdf->SetWatermarkText('CPA CTMS');
			$pdf->showWatermarkText = true;
			
		//	$stylesheet = file_get_contents('resources/styles/xml_conversion.css'); // external css
			
			$pdf->AddPage('P', // L - landscape, P - portrait
						'', '', '', '',
						5, // margin_left
						5, // margin right
						10, // margin top
						10, // margin bottom
						10, // margin header
						10); // margin footer
					
			$html=$this->load->view('date_wise_be_report_pdf',$this->data, true);
										
			$pdfFilePath ="date_wise_be_report-".time()."-download.pdf";
			
			$pdf->useSubstitutions = true; 					
			$pdf->setFooter('|Page {PAGENO} of {nb}|');   
		//	$pdf->WriteHTML($stylesheet,1);
			$pdf->WriteHTML($html,2);
					
			$pdf->Output($pdfFilePath, "I");
			//--
		}
	}
		//date wise be report - end
	//xml conversion - end
	
	//handling performance compare - start
	function handling_performance_compare()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$data['title']="Handling Performance Compare";
			
			$this->load->view('header2');
			$this->load->view('handling_performance_compare',$data);
			$this->load->view('footer');
		}
	}
	
	function handling_performance_compare_search($perform_search_date_entry)
	{
		if($perform_search_date_entry!="")
			$perform_search_date=$perform_search_date_entry;
		else
			$perform_search_date=$this->input->post('perform_search_date');
		
		$sql_performance_search="SELECT 
		IF(SUBSTR(sparcsn4.argo_quay.id,1,1)='G',1,IF(SUBSTR(sparcsn4.argo_quay.id,1,1)='C',2,3)) AS berth_sl,
		sparcsn4.argo_quay.id AS berth,Y.id AS agent,
		sparcsn4.argo_carrier_visit.id,
		sparcsn4.vsl_vessel_visit_details.flex_date07 AS ffd,
		sparcsn4.vsl_vessels.name,
		IFNULL(sparcsn4.vsl_vessel_visit_details.flex_string03,sparcsn4.vsl_vessel_visit_details.flex_string02) AS berthop,
		sparcsn4.vsl_vessel_berthings.ata ata,
		sparcsn4.argo_carrier_visit.atd atd,
		'' AS pr_imp,
		'' AS pr_exp,
		(IFNULL(sparcsn4.argo_carrier_visit.atd,(SELECT sparcsn4.argo_visit_details.etd FROM sparcsn4.argo_visit_details WHERE sparcsn4.argo_visit_details.gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey LIMIT 1))) AS etd,
		sparcsn4.argo_carrier_visit.gkey,
		sparcsn4.argo_carrier_visit.cvcvd_gkey,
		sparcsn4.vsl_vessel_visit_details.ib_vyg,
		DATE(sparcsn4.vsl_vessel_berthings.ata) AS ata_dt

		FROM sparcsn4.argo_carrier_visit
		INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
		INNER JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
		INNER JOIN sparcsn4.vsl_vessel_berthings ON sparcsn4.vsl_vessel_berthings.vvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
		INNER JOIN sparcsn4.argo_quay ON sparcsn4.argo_quay.gkey=sparcsn4.vsl_vessel_berthings.quay
		INNER JOIN
		( sparcsn4.ref_bizunit_scoped r
		LEFT JOIN ( sparcsn4.ref_agent_representation X
		LEFT JOIN sparcsn4.ref_bizunit_scoped Y ON X.agent_gkey=Y.gkey )
		ON r.gkey=X.bzu_gkey
		)  ON r.gkey = sparcsn4.argo_carrier_visit.operator_gkey

		WHERE (
		(sparcsn4.argo_carrier_visit.ata BETWEEN CONCAT(DATE_ADD('$perform_search_date', INTERVAL -1 DAY),' 08:00:00') AND CONCAT('$perform_search_date',' 08:00:01'))
		OR(sparcsn4.argo_carrier_visit.ata < CONCAT('$perform_search_date',' 08:00:01') AND sparcsn4.argo_carrier_visit.atd IS NULL)
		OR (sparcsn4.argo_carrier_visit.atd BETWEEN CONCAT(DATE_ADD('$perform_search_date', INTERVAL -1 DAY),' 08:00:00') AND CONCAT('$perform_search_date',' 08:00:01')) 
		) 
		AND sparcsn4.argo_carrier_visit.carrier_mode='VESSEL' AND  sparcsn4.argo_carrier_visit.phase!='80CANCELED'
		ORDER BY 1,2";
		
		$rslt_performance_search=$this->bm->dataSelect($sql_performance_search);
		
		$data['rslt_performance_search']=$rslt_performance_search;
		$data['perform_search_date']=$perform_search_date;
		$data['flag']=1;
		$data['title']="Handling Performance Compare";
		
		$this->load->view('header2');
		$this->load->view('handling_performance_compare',$data);
		$this->load->view('footer');
	}
	
	function actual_ctms_entry_action()
	{
		$tbl_id=$this->input->post('tbl_id');
		$vvd_gkey_entry=$this->input->post('vvd_gkey_entry');
		$rot_entry=$this->input->post('rot_entry');
		$vsl_name_entry=$this->input->post('vsl_name_entry');
		$berth_entry=$this->input->post('berth_entry');
		$agent_entry=$this->input->post('agent_entry');
		$discharge_actual_entry=$this->input->post('discharge_actual_entry');
		$discharge_ctms_entry=$this->input->post('discharge_ctms_entry');
		$loading_actual_entry=$this->input->post('loading_actual_entry');
		$loading_ctms_entry=$this->input->post('loading_ctms_entry');
		$perform_search_date_entry=$this->input->post('perform_search_date_entry');
		$login_id = $this->session->userdata('login_id');
		$ip_address = $_SERVER['REMOTE_ADDR'];
		//$ata_dt_entry=$this->input->post('ata_dt_entry');
		
		//echo "<br>";	
		
		//--17-01-19
		$cnt=0;
		
		$sql_chk_duplicate="SELECT COUNT(*) AS rtnValue FROM ctmsmis.handlingperformancecompare WHERE id='$tbl_id'";
		
		$cnt=$this->bm->dataReturn($sql_chk_duplicate);
		
		if($cnt>0)
		{
			$sql_insert_perform="UPDATE ctmsmis.handlingperformancecompare
			SET discharge_actual='$discharge_actual_entry',discharge_ctms='$discharge_ctms_entry',loading_actual='$loading_actual_entry',loading_ctms='$loading_ctms_entry',ip_address='$ip_address'
			WHERE id='$tbl_id'";
		}
		else
		{
			$sql_insert_perform="INSERT INTO ctmsmis.handlingperformancecompare(vvd_gkey,rotation,vessel_name,berth,agent,discharge_actual,discharge_ctms,loading_actual,loading_ctms,ata_dt,entry_dt,entry_by,ip_address)
			VALUES('$vvd_gkey_entry','$rot_entry','$vsl_name_entry','$berth_entry','$agent_entry','$discharge_actual_entry','$discharge_ctms_entry','$loading_actual_entry','$loading_ctms_entry','$perform_search_date_entry',NOW(),'$login_id','$ip_address')";
		}
		
		//--17-01-19
		
		// $sql_insert_perform="INSERT INTO ctmsmis.handlingperformancecompare(vvd_gkey,rotation,vessel_name,berth,agent,discharge_actual,discharge_ctms,loading_actual,loading_ctms,ata_dt,entry_dt,entry_by)
		// VALUES('$vvd_gkey_entry','$rot_entry','$vsl_name_entry','$berth_entry','$agent_entry','$discharge_actual_entry','$discharge_ctms_entry','$loading_actual_entry','$loading_ctms_entry','$perform_search_date_entry',NOW(),'$login_id')";
	
		$rslt_insert_perform=$this->bm->dataInsert($sql_insert_perform);
		
		$this->handling_performance_compare_search($perform_search_date_entry);
	
		// $data['flag']=1;
		// $data['title']="Handling Performance Compare";
		
		// $this->load->view('header2');
		// $this->load->view('handling_performance_compare',$data);
		// $this->load->view('footer');
	}
	
	function add_new_form_action()
	{
		$vsl_name_new=$this->input->post('vsl_name_new');
		$rot_new=$this->input->post('rot_new');
		$berth_new=$this->input->post('berth_new');
		$agent_new=$this->input->post('agent_new');
		$dis_act_new=$this->input->post('dis_act_new');
		$dis_ctms_new=$this->input->post('dis_ctms_new');
		$load_act_new=$this->input->post('load_act_new');
		$load_ctms_new=$this->input->post('load_ctms_new');
		$perform_search_date_entry_new=$this->input->post('perform_search_date_entry_new');
		$login_id = $this->session->userdata('login_id');
		
		$sql_vvd_gkey="SELECT vvd_gkey AS rtnValue FROM vsl_vessel_visit_details WHERE ib_vyg='$rot_new'";
		
		$vvd_gkey_new=$this->bm->dataReturn($sql_vvd_gkey);
		
		$sql_insert_new_entry="INSERT INTO ctmsmis.handlingperformancecompare(vvd_gkey,rotation,vessel_name,berth,agent,discharge_actual,discharge_ctms,loading_actual,loading_ctms,ata_dt,entry_dt,entry_by)
		VALUES('$vvd_gkey_new','$rot_new','$vsl_name_new','$berth_new','$agent_new','$dis_act_new','$dis_ctms_new','$load_act_new','$load_ctms_new','$perform_search_date_entry_new',NOW(),'$login_id')";
		
		$rslt_insert_new_entry=$this->bm->dataInsert($sql_insert_new_entry);
		
		$this->handling_performance_compare_search($perform_search_date_entry_new);
	}
	
	//handling performance compare - end
	//ICD Container Report start
			function icdContainerReportByRotation()
		{
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="ROTATION WISE ICD CONTAINER";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('icdContainerReportByRotation',$data);
				$this->load->view('footer');
			}	
        }
		function icdContainerReportByRotationView()
		{
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="ROTATION WISE ICD CONTAINER";
				$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
				$query = "SELECT sparcsn4.vsl_vessels.name AS vsl_name
					FROM sparcsn4.vsl_vessels
					INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
					WHERE sparcsn4.vsl_vessel_visit_details.ib_vyg='$ddl_imp_rot_no'";
				$vsselName = $this->bm->dataSelect($query);
				$data['vsselName']=$vsselName;
				$data['ddl_imp_rot_no']=$ddl_imp_rot_no;
				//echo $data['title'];
				$this->load->view('icdContainerReportByRotationView',$data);

			}	
        }
  
	//ICD Container Report End
	function containerBarcodeSearch()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$msg="";
			$data['title']="BARCODE GENERATOR...";
			$data['msg']=$msg;
			
			$this->load->view('header2');
			$this->load->view('containerBarcodeSearch',$data);
			$this->load->view('footer');
		}
	}
	function continerBarcodeGeneratePerform()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$cont_no = "";
			if($this->input->post('cont_no'))
				$cont_no=$this->input->post('cont_no');
			else
				$cont_no=$this->uri->segment(3);
			
			$data['cont_no']=$cont_no;
			$data['title']="BARCODE";
			$data['msg']=$msg;
			

			$this->load->view('containerBarcodeGenerator',$data);
		}
	}
	
	//Container Wise Truck - start
	function cont_wise_truck()
	{
		$data['title']="CONTAINER WISE TRUCK";
		$data['msg']=$msg;
		
		$this->load->view('header2');
		$this->load->view('cont_wise_truck',$data);
		$this->load->view('footer');
	}
	
	function cont_wise_truck_search()
	{
		$data['title']="CONTAINER WISE TRUCK";
		$data['msg']=$msg;
		
		//--- 
		
		$query = "SELECT DISTINCT gkey, id FROM sparcsn4.road_gates WHERE life_cycle_state='ACT'";
		$gateList = $this->bm->dataSelect($query);
					
		$data['gateList']=$gateList;
				
		$container_no=$this->input->post('cont_no');
		$data['container_no']=$container_no;
		
		$sql_cont_truck_n4="SELECT sparcsn4.inv_unit.id AS cont_no,sparcsn4.inv_unit.gkey AS unit_gkey,sparcsn4.config_metafield_lov.mfdch_desc AS assign_type,DATE(sparcsn4.inv_unit_fcy_visit.flex_date01) AS assign_date,sparcsn4.vsl_vessel_visit_details.ib_vyg AS rotation,sparcsn4.vsl_vessels.name AS vessel_name,k.name AS cnf,k.gkey AS bizu_gkey
		FROM sparcsn4.inv_unit  
		INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
		INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
		INNER JOIN sparcsn4.vsl_vessel_visit_details ON sparcsn4.vsl_vessel_visit_details.vvd_gkey=sparcsn4.argo_carrier_visit.cvcvd_gkey
		INNER JOIN sparcsn4.vsl_vessels ON sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
		INNER JOIN sparcsn4.config_metafield_lov ON sparcsn4.inv_unit.flex_string01=config_metafield_lov.mfdch_value 
		INNER JOIN
		sparcsn4.inv_goods j ON j.gkey = sparcsn4.inv_unit.goods
		LEFT JOIN
		sparcsn4.ref_bizunit_scoped k ON k.gkey = j.consignee_bzu
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
		
		$cf_assign_truck_id=$rslt_chk_entered_truck[0]['id'];
		
		$sql_truck_number_list="SELECT truck_number,entrance_date,entrance_gate,entrance_serial FROM ctmsmis.cont_wise_truck_dtl WHERE cf_assign_truck_id='$cf_assign_truck_id'";
		
		$rslt_truck_number_list=$this->bm->dataSelect($sql_truck_number_list);
		//---
		
		$data['flag']=0;
		
		if(count($rslt_cont_truck_n4)>0 and count($rslt_cont_truck_igm)>0)
		{
			$data['flag']=1;
		}
		
		$data['rslt_cont_truck_n4']=$rslt_cont_truck_n4;
		$data['rslt_cont_truck_igm']=$rslt_cont_truck_igm;
		$data['rslt_chk_entered_truck']=$rslt_chk_entered_truck;
		$data['rslt_truck_number_list']=$rslt_truck_number_list;
		//--- 
		
		$this->load->view('header2');
		$this->load->view('cont_wise_truck',$data);
		$this->load->view('footer');
	}
	
	function truck_wise_entry_action()
	{
		$login_id = $this->session->userdata('login_id');
		$ipaddr = $_SERVER['REMOTE_ADDR'];
		
		$cont_no=$this->input->post('container_no');
		$unit_gkey=$this->input->post('unit_gkey');		
		$total_truck=$this->input->post('total_truck');			
		$all_truck=$this->input->post('all_truck');		
		$bizu_gkey=$this->input->post('bizu_gkey');		
		$assign_type=$this->input->post('assign_type');		
		$gate=$this->input->post('gate');		
		
		$sql_chk_duplicate="SELECT COUNT(*) AS rtnValue FROM ctmsmis.mis_cf_assign_truck WHERE unit_gkey='$unit_gkey'";
		
		$rslt_chk_duplicate=$this->bm->dataReturn($sql_chk_duplicate);
		
		if($rslt_chk_duplicate>0)
		{
			$sql_cf_assign_truck_update="UPDATE ctmsmis.mis_cf_assign_truck 
								SET number_of_truck='$total_truck',truck_assign_time=NOW(),truck_assign_by='$login_id',user_ip='$ipaddr' 
								WHERE unit_gkey='$unit_gkey'";
								
			$rslt_cf_assign_truck_update=$this->bm->dataUpdate($sql_cf_assign_truck_update);
		}
		else
		{
			$sql_cf_assign_truck="INSERT INTO ctmsmis.mis_cf_assign_truck(unit_gkey,cont_id,assign_type,number_of_truck,truck_assign_time,truck_assign_by,user_ip)
							VALUES('$unit_gkey','$cont_no','$assign_type','$total_truck',NOW(),'$login_id','$ipaddr')";
							
			$rslt_cf_assign_truck=$this->bm->dataInsert($sql_cf_assign_truck);
		}
		
		if($rslt_cf_assign_truck or $rslt_cf_assign_truck_update)
		{
			$sql_cf_assign_truck_id="SELECT ctmsmis.mis_cf_assign_truck.id AS rtnValue 
								FROM ctmsmis.mis_cf_assign_truck
								WHERE unit_gkey='$unit_gkey'";
						
			$cf_assign_truck_id=$this->bm->dataReturn($sql_cf_assign_truck_id);
			
			for($i=1;$i <= $total_truck;$i++)
			{
				$strSeral = "SELECT IFNULL(MAX(entrance_serial),0)+1 AS rtnValue FROM ctmsmis.cont_wise_truck_dtl WHERE entrance_date=DATE(NOW()) AND entrance_gate='$gate'";
				$trkSerial=$this->bm->dataReturn($strSeral);
				
				
				$truck_number = $this->input->post('truck_no_'.$i);				
				if($truck_number!="")
				{
					$sql_chk_dup_truck="SELECT COUNT(truck_number) as rtnValue FROM ctmsmis.cont_wise_truck_dtl WHERE truck_number='$truck_number' AND cf_assign_truck_id='$cf_assign_truck_id'";
				
					$rslt_chk_duplicate=$this->bm->dataReturn($sql_chk_dup_truck);
					
					if($rslt_chk_duplicate>0)
					{
						$sql_update_cont_wise_dtl="UPDATE ctmsmis.cont_wise_truck_dtl SET cf_assign_truck_id='$cf_assign_truck_id',bizu_gkey='$bizu_gkey',encrypted_data=sha1('".$cont_no.$bizu_gkey.$truck_number."') WHERE truck_number='$truck_number' AND cf_assign_truck_id='$cf_assign_truck_id'";
						
						$rslt_conf_wise_dtl_update=$this->bm->dataUpdate($sql_update_cont_wise_dtl);
					}
					else
					{
						$sql_conf_wise_dtl="INSERT INTO ctmsmis.cont_wise_truck_dtl(cf_assign_truck_id,truck_number,bizu_gkey,encrypted_data,entrance_date,entrance_gate,entrance_serial)
							VALUES('$cf_assign_truck_id','$truck_number','$bizu_gkey',sha1('".$cont_no.$bizu_gkey.$truck_number."'),DATE(NOW()),'$gate','$trkSerial')";
							
						$rslt_conf_wise_dtl=$this->bm->dataInsert($sql_conf_wise_dtl);
					}					
				}
			}
			
			if($rslt_conf_wise_dtl)
				$data['msg']="<font color='green' size='5'>Successfully inserted for ".$cont_no."<b><br/><br/><a href='".site_url('report/continerBarcodeGeneratePerform/'.$cont_no)."' target='_blank'>Print Ticket</a></b></font>";
			else if($rslt_conf_wise_dtl_update)
				$data['msg']="<font color='green' size='5'>Successfully updated for ".$cont_no."<b><br/><br/><a href='".site_url('report/continerBarcodeGeneratePerform/'.$cont_no)."' target='_blank'>Print Ticket</a></b></font>";
			else
				$data['msg']="<font color='red' size='5'>Entry failed for ".$cont_no."</font>";
		}
		
		$data['title']="CONTAINER WISE TRUCK";
		
		$this->load->view('header2');
		$this->load->view('cont_wise_truck',$data);
		$this->load->view('footer');
	}
	
	//Container Wise Truck - end
	function containerListForSecurity()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$data['tableTitle']="Container List Search";
			$this->load->view('header2');
			$this->load->view('containerListForSecurity',$data);
			$this->load->view('footer');
		}
	}
	
	function containerListForSecurityBySearch()
	{
		$login_id = $this->session->userdata('login_id');
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
				$this->logout();
		}
		else
		{
		  $search_by = $this->input->post('search_by');
		  
		  if($search_by=="Date")
			{
			$date=trim($this->input->post('searchInput'));
			$data['tableTitle']="Container List for the Date: ".$date;
			$listSql="SELECT ctmsmis.mis_cf_assign_truck.cont_id, ctmsmis.mis_cf_assign_truck.number_of_truck, ctmsmis.cont_wise_truck_dtl.bizu_gkey,cont_id, 
				ctmsmis.cont_wise_truck_dtl.encrypted_data, ctmsmis.cont_wise_truck_dtl.truck_number, 
				cont_wise_truck_dtl.entrance_gate,mis_cf_assign_truck.assign_type, cont_wise_truck_dtl.entrance_date, cont_wise_truck_dtl.cont_verification_status FROM ctmsmis.mis_cf_assign_truck 
				INNER JOIN ctmsmis.cont_wise_truck_dtl ON ctmsmis.cont_wise_truck_dtl.cf_assign_truck_id=ctmsmis.mis_cf_assign_truck.id 
				WHERE cont_wise_truck_dtl.entrance_date='$date'";    
			}

			else if($search_by=="Gate")
			{
			 $gate=trim($this->input->post('searchVal'));
				$data['tableTitle']="Container List for the Gate: ".$gate; 
			   $listSql="SELECT ctmsmis.mis_cf_assign_truck.cont_id, ctmsmis.mis_cf_assign_truck.number_of_truck, ctmsmis.cont_wise_truck_dtl.bizu_gkey,cont_id, 
				ctmsmis.cont_wise_truck_dtl.encrypted_data, ctmsmis.cont_wise_truck_dtl.truck_number, 
				cont_wise_truck_dtl.entrance_gate,mis_cf_assign_truck.assign_type, cont_wise_truck_dtl.entrance_date, cont_wise_truck_dtl.cont_verification_status FROM ctmsmis.mis_cf_assign_truck 
				INNER JOIN ctmsmis.cont_wise_truck_dtl ON ctmsmis.cont_wise_truck_dtl.cf_assign_truck_id=ctmsmis.mis_cf_assign_truck.id 
				where cont_wise_truck_dtl.entrance_gate='$gate'";
				   
			}
			$list=$this->bm->dataSelect($listSql);
			$data['list']=$list;

			$this->load->view('containerListForSecurityBySearch',$data);               
            }	
	}
	
	//Cargo Handling Equipment Position Entry
	function cargoHandlingEquipmentPositionEntry()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			if($this->input->post('delete'))
			{
				$eid=$this->input->post('eid');
				$deleteSql="DELETE FROM ctmsmis.equip_for_cargo_handling WHERE ctmsmis.equip_for_cargo_handling.id='$eid'";
				$deleteStat=$this->bm->dataDelete($deleteSql);
			}
			$rslt_sql="SELECT id, equip_type, office,  demand, supply, stand_by, out_of_order, updated_by, date(update_time) as update_time FROM ctmsmis.equip_for_cargo_handling where update_time=date(now())";
			$result=$this->bm->dataSelect($rslt_sql);			
			$data['result']=$result;
			$data['editFlag']=0;
			$msg="";
			$data['title']="Equipment Assign For Cargo Handling";
			$data['msg']=$msg;
			$this->load->view('header2');
			$this->load->view('cargoHandlingEquipmentPositionEntry',$data);
			$this->load->view('footer');
		}
	}
        
        function cargoHandlingEquipmentPositionPerform()
        { 
            $session_id = $this->session->userdata('value');
            if($session_id!=$this->session->userdata('session_id'))
            {
                       $this->logout();
            }
            else
            {
                    
            $login_id = $this->session->userdata('login_id');
            $equip_type=$this->input->post('equip_type');
            $office=$this->input->post('office');
           // $total_equip=$this->input->post('total_equip');
            $demand=$this->input->post('demand');
            $supply=$this->input->post('supply');
            $stand_by=$this->input->post('stand_by');
            $out_of_order=$this->input->post('out_of_order');
            
			/* if($this->input->post('update'))
			{
				$equipID=$this->input->post('equipID');
				$updateSql="UPDATE ctmsmis.equip_for_cargo_handling set equip_type ='$equip_type', office='$office', 
							demand='$demand', supply='$supply', stand_by='$stand_by', out_of_order='$out_of_order',
							updated_by='$login_id',  update_time=now() where ctmsmis.equip_for_cargo_handling.id='$equipID'";
//                    echo $updateSql;
//                    return;
				$updateStat=$this->bm->dataUpdate($updateSql);
			   if($updateStat==1)
				$msg="<font color='green'><b>Succesfully Updated</b></font>";
			   else
				$msg="<font color='red'><b>Updation failed</b></font>";
                    
			} */
           // else{
            
                $insert_sql="REPLACE INTO ctmsmis.equip_for_cargo_handling(equip_type, office, demand, supply, stand_by, out_of_order, updated_by, update_time)
                    VALUES('$equip_type', '$office', '$demand', '$supply','$stand_by','$out_of_order', '$login_id', NOW())";
                    
//                    echo $insert_sql;
//                    return;
                $insert_stat=$this->bm->dataInsert($insert_sql);

                if($insert_stat==1)
                    $msg="<font color='green'><b>Succesfully inserted</b></font>";
                else
                    $msg="<font color='red'><b>Insertion failed</b></font>";
         //    }   
                    //$msg="";
                    
                    $rslt_sql="SELECT id, equip_type, office,  demand, supply, stand_by, out_of_order, updated_by, date(update_time) as update_time FROM ctmsmis.equip_for_cargo_handling where update_time=date(now())";
                    $result=$this->bm->dataSelect($rslt_sql);			
                    $data['result']=$result;
			
                    $data['title']="Equipment Assign For Cargo Handling";
                    $data['msg']=$msg;
                    $data['editFlag']=0;
                    $this->load->view('header2');
                    $this->load->view('cargoHandlingEquipmentPositionEntry',$data);
                    $this->load->view('footer');
			} 
        }
     
 
	function cargoHandlingEquipmentPositionEdit()
	{
            $session_id = $this->session->userdata('value');
            if($session_id!=$this->session->userdata('session_id'))
            {
                    $this->logout();
            }
            else
            {
               $eqiID= $this->input->post('eqiID');               
                $select_sql="SELECT id, equip_type, office, demand, supply, stand_by, out_of_order, updated_by, update_time
                        FROM ctmsmis.equip_for_cargo_handling where equip_for_cargo_handling.id='$eqiID'";
                
//                echo $select_sql;
//                return;
                $select_result=$this->bm->dataSelect($select_sql);			
                $data['select_result']=$select_result;
                
				$rslt_sql="SELECT id, equip_type, office, demand, supply, stand_by, out_of_order, updated_by, date(update_time) as update_time FROM ctmsmis.equip_for_cargo_handling where update_time=date(now())";
                $result=$this->bm->dataSelect($rslt_sql);			
                $data['result']=$result;

                $data['editFlag']=1;
                $msg="";
				$data['title']="Equipment Assign For Cargo Handling";
                $data['msg']=$msg;
                $this->load->view('header2');
                $this->load->view('cargoHandlingEquipmentPositionEntry',$data);
                $this->load->view('footer');
            }
	}
	
	
	function cargoHandlingEquipmentPositionView()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
		   $this->logout();
		}
		else
		{
			$this->load->view('cargoHandlingEquipmentPositionView',$data);
		} 
		
	}
	
		//Cargo Handling Equipment Position Entry---- End
		
	function product_report_search()		//intakhab
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$data['tableTitle']="PRODUCT LIST";
			
			$this->load->view('header2');
			$this->load->view('networkProductReportForm',$data);
			$this->load->view('footer');			
		}
	}
	
	function product_report_pdf()	 //Sumon	//intakhab
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$fileType=$this->input->post('fileOptions');
			//echo CI_VERSION;
			//return;
		if($fileType=="pdf" )
			{ 
			$this->load->library('m_pdf');
			$pdf->use_kwt = true;
			
			$pdf = $this->m_pdf->load();
			$pdf->SetWatermarkText('CPA CTMS');
			$pdf->showWatermarkText = true;	
			$search_by = $this->input->post('search_by');
			
			if($search_by=="serial")
			{
				$serial=trim($this->input->post('searchInput'));
				$this->data['tableTitle']="Product Serial No:  ".$serial;			 
				
				$sql_product_list="SELECT inventory_product_info.id, loc_detail_id,location_details, owner_id, full_name, type_id, short_name,prod_name,
				prod_serial, imei_number, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by, checkStatus, checked_by FROM inventory_product_info 
				LEFT JOIN `inventory_product_location_details` ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
				INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
				INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
				WHERE prod_serial='$serial'";            
			}
			else if($search_by=="category")
			{
				$category=trim($this->input->post('searchVal'));
				// $this->data['tableTitle']="Product Category:  ".$category;
				$sql_product_list="SELECT inventory_product_info.id, loc_detail_id,location_details, owner_id, full_name, type_id, short_name,prod_name,
				prod_serial, imei_number, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by, checkStatus, checked_by FROM inventory_product_info 
				LEFT JOIN `inventory_product_location_details` ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
				INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
				INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
				WHERE type_id='$category'";
				$category_name_sql="SELECT inventory_product_type.id ,IF(short_name='Monitor',CONCAT(short_name,'-',product_desc),short_name) AS detl 
				FROM inventory_product_type WHERE cchaportdb.inventory_product_type.id='$category'";
				$cat_name=$this->bm->dataSelectDb1($category_name_sql);
				$this->data['tableTitle']="Product category: ".$cat_name[0]['detl'];   
			}
			else if($search_by=="product")
			{
				$product_name=trim($this->input->post('searchInput'));
				$this->data['tableTitle']="Product Name:  ".$product_name;		 
				$sql_product_list="SELECT inventory_product_info.id, loc_detail_id,location_details, owner_id, full_name, type_id, short_name,prod_name,
				prod_serial, imei_number, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by, checkStatus, checked_by FROM inventory_product_info 
				LEFT JOIN `inventory_product_location_details` ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
				INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
				INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
				WHERE prod_name='$product_name'";		   
			}
			else if($search_by=="location")
			{
				$location=trim($this->input->post('searchVal'));
				$this->data['tableTitle']="Location:  ".$location;
	 
				$sql_product_list="SELECT inventory_product_info.id, loc_detail_id,location_details, owner_id, full_name, type_id, short_name,prod_name,
				prod_serial, imei_number, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by, checkStatus, checked_by FROM inventory_product_info 
				LEFT JOIN inventory_product_location_details ON  inventory_product_location_details.id=inventory_product_info.loc_detail_id
				INNER JOIN inventory_product_location ON inventory_product_location_details.location_id=inventory_product_location.id
				INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
				INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
				WHERE location_name='$location'";
			}
			else if($search_by=="user")
			{
				$updated_by=trim($this->input->post('searchVal'));
				$this->data['tableTitle']="Records updated by:  ".$updated_by;
	 
				$sql_product_list="SELECT inventory_product_info.id, loc_detail_id,location_details, owner_id, full_name, type_id, short_name,prod_name,
				prod_serial, imei_number, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by, checkStatus, checked_by FROM inventory_product_info 
				LEFT JOIN `inventory_product_location_details` ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
				INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
				INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
				WHERE prod_rcv_by ='$updated_by'";
			}
			else if($search_by=="ip_addr")
			{
				$ip_addr=trim($this->input->post('searchInput'));
				$this->data['tableTitle']="IP Address:  ".$ip_addr;

				$sql_product_list="SELECT inventory_product_info.id, loc_detail_id,location_details, owner_id, full_name, type_id, short_name,prod_name,
				prod_serial, imei_number, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by, checkStatus, checked_by FROM inventory_product_info 
				LEFT JOIN `inventory_product_location_details` ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
				INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
				INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
				WHERE prod_ip='$ip_addr'";  
			}
			else if($search_by=="monitor")
			{
				//$ip_addr=trim($this->input->post('searchInput'));
				$this->data['tableTitle']="All Monitor";

				$sql_product_list="SELECT inventory_product_info.id, loc_detail_id,location_details, owner_id, full_name, type_id, 
				 short_name,prod_name, prod_serial, imei_number, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by, 
				 checkStatus, checked_by FROM inventory_product_info
				  LEFT JOIN `inventory_product_location_details` 
				  ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
				  INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
				  INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id WHERE short_name='Monitor'";  
			}

			$rslt_product_list=$this->bm->dataSelectDb1($sql_product_list);
			
			$this->data['rslt_product_list']=$rslt_product_list;
			
			$html=$this->load->view('network_product_list_report',$this->data, true); 

			$pdf->AddPage('P', // L - landscape, P - portrait
								'', '', '', '',
								5, // margin_left
								5, // margin right
								5, // margin top
								5, // margin bottom
								5, // margin header
								5); // margin footer

			$pdf->setFooter('|Page {PAGENO} of {nb}|');   

			$pdf->WriteHTML($stylesheet,1);
			$pdf->WriteHTML($html,2);

			$pdf->Output($pdfFilePath, "I");
		}
		else
		{
			$search_by = $this->input->post('search_by');
			
			if($search_by=="serial")
			{
				$serial=trim($this->input->post('searchInput'));
				$data['tableTitle']="Product Serial No:  ".$serial;			 
				
				$sql_product_list="SELECT inventory_product_info.id, loc_detail_id,location_details, owner_id, full_name, type_id, short_name,prod_name,
				prod_serial, imei_number, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by, checkStatus, checked_by FROM inventory_product_info 
				LEFT JOIN `inventory_product_location_details` ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
				INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
				INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
				WHERE prod_serial='$serial'";            
			}
			else if($search_by=="category")
			{
				$category=trim($this->input->post('searchVal'));
				// $this->data['tableTitle']="Product Category:  ".$category;
				$sql_product_list="SELECT inventory_product_info.id, loc_detail_id,location_details, owner_id, full_name, type_id, short_name,prod_name,
				prod_serial, imei_number, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by, checkStatus, checked_by FROM inventory_product_info 
				LEFT JOIN `inventory_product_location_details` ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
				INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
				INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
				WHERE type_id='$category'";
				$category_name_sql="SELECT inventory_product_type.id ,IF(short_name='Monitor',CONCAT(short_name,'-',product_desc),short_name) AS detl 
				FROM inventory_product_type WHERE cchaportdb.inventory_product_type.id='$category'";
				$cat_name=$this->bm->dataSelectDb1($category_name_sql);
				$data['tableTitle']="Product category: ".$cat_name[0]['detl'];   
			}
			else if($search_by=="product")
			{
				$product_name=trim($this->input->post('searchInput'));
				$data['tableTitle']="Product Name:  ".$product_name;		 
				$sql_product_list="SELECT inventory_product_info.id, loc_detail_id,location_details, owner_id, full_name, type_id, short_name,prod_name,
				prod_serial, imei_number, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by, checkStatus, checked_by FROM inventory_product_info 
				LEFT JOIN `inventory_product_location_details` ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
				INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
				INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
				WHERE prod_name='$product_name'";		   
			}
			else if($search_by=="location")
			{
				$location=trim($this->input->post('searchVal'));
				$data['tableTitle']="Location:  ".$location;
	 
				$sql_product_list="SELECT inventory_product_info.id, loc_detail_id,location_details, owner_id, full_name, type_id, short_name,prod_name,
				prod_serial, imei_number, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by, checkStatus, checked_by FROM inventory_product_info 
				LEFT JOIN inventory_product_location_details ON  inventory_product_location_details.id=inventory_product_info.loc_detail_id
				INNER JOIN inventory_product_location ON inventory_product_location_details.location_id=inventory_product_location.id
				INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
				INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
				WHERE location_name='$location'";
			}
			else if($search_by=="user")
			{
				$updated_by=trim($this->input->post('searchVal'));
				$data['tableTitle']="Records updated by:  ".$updated_by;
	 
				$sql_product_list="SELECT inventory_product_info.id, loc_detail_id,location_details, owner_id, full_name, type_id, short_name,prod_name,
				prod_serial, imei_number, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by, checkStatus, checked_by FROM inventory_product_info 
				LEFT JOIN `inventory_product_location_details` ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
				INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
				INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
				WHERE prod_rcv_by ='$updated_by'";
			}
			else if($search_by=="ip_addr")
			{
				$ip_addr=trim($this->input->post('searchInput'));
				$data['tableTitle']="IP Address:  ".$ip_addr;

				$sql_product_list="SELECT inventory_product_info.id, loc_detail_id,location_details, owner_id, full_name, type_id, short_name,prod_name,
				prod_serial, imei_number, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by, checkStatus, checked_by FROM inventory_product_info 
				LEFT JOIN `inventory_product_location_details` ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
				INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
				INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id
				WHERE prod_ip='$ip_addr'";  
			}
			else if($search_by=="monitor")
			{
				//$ip_addr=trim($this->input->post('searchInput'));
				$data['tableTitle']="All Monitor";

				$sql_product_list="SELECT inventory_product_info.id, loc_detail_id,location_details, owner_id, full_name, type_id, 
				 short_name,prod_name, prod_serial, imei_number, prod_ip, prod_deck_id, prod_rcv_date, prod_rcv_by, 
				 checkStatus, checked_by FROM inventory_product_info
				  LEFT JOIN `inventory_product_location_details` 
				  ON `inventory_product_location_details`.id=inventory_product_info.`loc_detail_id` 
				  INNER JOIN inventory_product_owner ON inventory_product_owner.id=inventory_product_info.owner_id
				  INNER JOIN inventory_product_type ON inventory_product_type.id=inventory_product_info.type_id WHERE short_name='Monitor'";  
			}

			$rslt_product_list=$this->bm->dataSelectDb1($sql_product_list);
			
			$data['rslt_product_list']=$rslt_product_list;
			
			$this->load->view('network_product_list_report_excel',$data); 
			
			}
		}
	}
	
	//Organization Type entry and list
	
	function organizationTypeList()
	{
		$session_id = $this->session->userdata('value');			
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{   
			if($this->input->post('delete'))
			{
				$listId=$this->input->post('listId');
				$deleteSQL="Delete from  cchaportdb.tbl_org_types  where id='$listId'";
				$updateStat=$this->bm->dataDeleteDB1($deleteSQL);			
			}
			
			$formListQuery="SELECT id, Org_Type, Type_description FROM cchaportdb.tbl_org_types";						
			$formList=$this->bm->dataSelectDb1($formListQuery);
			$data['title']="ORGANIZATION TYPE LIST";
			$data['msg']=$msg;
			$data['formList']=$formList;
			$data['editFlag']=0;	
			$this->load->view('header2');
			$this->load->view('organizationTypeList',$data);
			$this->load->view('footer');
		}
	}



	function organizationTypeListSearch()
	{
		$session_id = $this->session->userdata('value');			
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{   
			$seach_by=$this->input->post('search_by');
			$list=$this->input->post('list');						
			if ($seach_by=="org")
			{	       
				$formListQuery="SELECT id, Org_Type, Type_description FROM cchaportdb.tbl_org_types where Org_Type='$list'";
				//echo $formListQuery;
			//return;	
			}
			else if($searchkey=="sec")
			{
					
			}
			$formList=$this->bm->dataSelectDb1($formListQuery);
			
			$data['title']="ORGANIZATION TYPE LIST";
			$data['msg']=$msg;
			$data['formList']=$formList;
			$data['editFlag']=0;	
			$this->load->view('header2');
			$this->load->view('organizationTypeList',$data);
			$this->load->view('footer');
		}
	}

	function organizationTypeEdit()
	{
		$session_id = $this->session->userdata('value');			
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{   
			$seach_by=$this->input->post('search_by');
			$list=$this->input->post('listId');						
     
				$formListQuery="SELECT id, Org_Type, Type_description FROM cchaportdb.tbl_org_types where id='$list'";
			//	echo $formListQuery;
			//return;	
			
			$formList=$this->bm->dataSelectDb1($formListQuery);
			
			$data['title']="ORGANIZATION TYPE LIST";
			$data['msg']=$msg;
			$data['formList']=$formList;
			$data['editFlag']=1;
				
			$this->load->view('header2');
			$this->load->view('organizationTypeForm',$data);
			$this->load->view('footer');
		}
	}
	
	function organizationTypeEntryForm()
	{
		$session_id = $this->session->userdata('value');			
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{   
			$seach_by=$this->input->post('search_by');
			$list=$this->input->post('listId');						
     
			$formListQuery="SELECT id, Org_Type, Type_description FROM cchaportdb.tbl_org_types where id='$list'";
			$formList=$this->bm->dataSelectDb1($formListQuery);
			
			$org_type = $this->input->post('org_type');
            $type_description=$this->input->post('type_description');
           

 		if($this->input->post('update'))
			{
			$org_id=$this->input->post('org_id');
			$updateSql="UPDATE cchaportdb.tbl_org_types set Org_Type ='$org_type', Type_description='$type_description' 
						where cchaportdb.tbl_org_types.id='$org_id'";
               //   echo $updateSql;
            //      return;
				$updateStat=$this->bm->dataUpdateDB1($updateSql);
			   if($updateStat==1)
				$msg="<font color='green'><b>Succesfully Updated</b></font>";
			   else
				$msg="<font color='red'><b>Updation failed</b></font>";
                    
			} 
            if($this->input->post('save')){
            
                $insert_sql="INSERT INTO cchaportdb.tbl_org_types(Org_Type, Type_description) VALUES('$org_type', '$type_description')";
                    
               //    echo $insert_sql;
			   //      return;
                $insert_stat=$this->bm->dataInsertDB1($insert_sql);

                if($insert_stat==1)
                    $msg="<font color='green'><b>Succesfully inserted</b></font>";
                else
                    $msg="<font color='red'><b>Insertion failed</b></font>";
            }   
                    //$msg="";
			
			$data['title']="ORGANIZATION TYPE FORM";
			$data['msg']=$msg;
			$data['formList']=$formList;
			$data['editFlag']=0;
				
			$this->load->view('header2');
			$this->load->view('organizationTypeForm',$data);
			$this->load->view('footer');
		}
	}
	function listOfNotStrippedContainerView()
	{
		$fromdate=$this->input->post('strDt');
		$yard_no=$this->input->post('yard_no1'); 
		$data['fromdate']=$fromdate;
		$data['yard_no']=$yard_no;
		$this->load->view('listOfNotStrippedContainerView',$data);
    }
	
	function ocr_container_info()
	{

			
			//$this->load->view('header2');
			$this->load->view('ocr_container_form',$data);
			//$this->load->view('footer');

	}
	function ocr_container_list()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$cond="";
			$msg="";
			
			if($this->input->post('search_office_code'))
			{
				$search_office_code=$this->input->post('search_office_code');
				$cond=" WHERE office_code='$search_office_code'";
			}
			else if($this->input->post('search_c_number'))
			{
				$search_c_number=$this->input->post('search_c_number');
				$cond=" WHERE reg_no='$search_c_number'";
			}
			else if($this->input->post('search_c_date'))
			{
				$search_c_date=$this->input->post('search_c_date');
				$cond=" WHERE reg_date='$search_c_date'";
			}
			else if($this->input->post('search_entry_date'))
			{
				$search_entry_date=$this->input->post('search_entry_date');
				$cond=" WHERE DATE(entry_dt)='$search_entry_date'";
			}
			else if($this->input->post('search_cont_no'))
			{
				$search_cont_no=$this->input->post('search_cont_no');
				$cond=" INNER JOIN sad_container ON sad_container.`sad_id`=sad_info.`id`
						WHERE sad_container.`cont_number`='$search_cont_no'";
			}				
			
			$sql_search_be_list="SELECT office_code,reg_no,reg_date FROM sad_info".$cond;
			
			$rslt_list_of_be=$this->bm->dataSelectDb1($sql_search_be_list);
			
			if(count($rslt_list_of_be)==0)
				$msg="No result found";
			
			$data['title']="BE ENTRY...";
			$data['msg']=$msg;
			$data['rslt_list_of_be']=$rslt_list_of_be;
			
			$this->load->view('header2');
			$this->load->view('xml_conversion_form',$data);
			$this->load->view('footer');					
		}
	}
	// CIR
	function cirForm()
	{
		//print_r($this->session->all_userdata());
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$data['title']="CIR";
			$this->load->view('header2');
			$this->load->view('cirForm',$data);
			$this->load->view('footer');
		}	
    }
	function cirReportView()
	{
		$fromdate=$this->input->post('fromdate1');
		$cat=$this->input->post('yard_no1'); 
		
		$this->data['fromdate']=$fromdate;
		$this->data['cat']=$cat;
		
		$this->load->library('m_pdf');
		$pdf->use_kwt = true;
		$this->data['title']="CIR Report";
		$pdfFilePath ="CIR Report-".time()."-download.pdf";
		$pdf = $this->m_pdf->load();
		$pdf->useAdobeCJK = true;
		$pdf->SetAutoFont(AUTOFONT_ALL);
		
		$html=$this->load->view('cirReportView',$this->data, true);
		$stylesheet = file_get_contents('resources/styles/test.css'); // external css
		$pdf->useSubstitutions = true; // optional - just as an example
		
		$pdf->setFooter('Developed By : DataSoft|Page {PAGENO} of {nb}|Date {DATE j-m-Y}');
		
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		$pdf->Output($pdfFilePath, "I"); // For Show Pdf
		
		//$this->load->view('cirReportView',$data);
    }
	
	// Raju
	 //date wise be icd report - start
    function date_wise_icd_report()
    {
        $session_id = $this->session->userdata('value');

        if($session_id!=$this->session->userdata('session_id'))
        {
            $this->logout();
        }
        else
        {
            $data['title']="DATE WISE ICD Report...";

            $this->load->view('header2');
            $this->load->view('date_wise_icd_report_form',$data);
            $this->load->view('footer');
        }
    }

    function date_wise_icd_report_action()
    {
        $session_id = $this->session->userdata('value');
        if($session_id!=$this->session->userdata('session_id'))
        {
            $this->logout();
        }
        else
        {
            $icd_entry_date = $this->input->post('icd_entry_date');

            $sql_icd_report_datewise="SELECT i.cir_dt,i.cir_no,i.time,i.pt, i.shift,i.category,i.entry_dt FROM icd_app_mst AS i 
            WHERE DATE(i.cir_dt) = '$icd_entry_date'";

            $rslt_icd_report_datewise = $this->bm->dataSelectDb1($sql_icd_report_datewise);

          //  $this->load->library('m_pdf');
          //  $mpdf->use_kwt = true;
            $this->data['rslt_icd_report_datewise']=$rslt_icd_report_datewise;
            $this->data['icd_entry_date']=$icd_entry_date;
           // $pdf = $this->m_pdf->load();
          //  $pdf->SetWatermarkText('CPA CTMS');
          //  $pdf->showWatermarkText = true;

//            $pdf->AddPage('P', // L - landscape, P - portrait
//                '', '', '', '',
//                5, // margin_left
//                5, // margin right
//                10, // margin top
//                10, // margin bottom
//                10, // margin header
//                10); // margin footer
            $this->load->view('date_wise_icd_report_pdf',$this->data);
          //  $html=$this->load->view('date_wise_icd_report_pdf',$this->data, true);
          //  $pdfFilePath ="date_wise_icd_report-".time()."-download.pdf";
          //  $pdf->useSubstitutions = true;
          //  $pdf->setFooter('|Page {PAGENO} of {nb}|');
          //  $pdf->WriteHTML($html,2);
          //  $pdf->Output($pdfFilePath, "I");
        }
    }



    function icd_icr_wise_report()
    {
        $session_id = $this->session->userdata('value');
       // print_r($session_id);
        if($session_id!=$this->session->userdata('session_id'))
        {
            $this->logout();
        }
        else
        {
            $cir_no = $this->input->post('cir_no');
            $cir_dt = $this->input->post('cir_dt');


            $sql_data="SELECT cont_no, rotation, wagon_no FROM icd_app_mst
JOIN icd_app_dtl ON icd_app_dtl.mst_id = icd_app_mst.id WHERE icd_app_mst.cir_no = '$cir_no'
AND DATE(icd_app_mst.cir_dt) = '$cir_dt'";

            $rslt_data = $this->bm->dataSelectDb1($sql_data);

              $this->load->library('m_pdf');
              $mpdf->use_kwt = true;
            $this->data['rslt_data']=$rslt_data;
            $this->data['cir_dt']=$cir_dt;
             $pdf = $this->m_pdf->load();
              $pdf->SetWatermarkText('CPA CTMS');
              $pdf->showWatermarkText = true;

            $pdf->AddPage('P', // L - landscape, P - portrait
                '', '', '', '',
                5, // margin_left
                5, // margin right
                10, // margin top
                10, // margin bottom
                10, // margin header
                10); // margin footer
            $this->load->view('date_and_cir_wise_report',$this->data);
              $html=$this->load->view('date_and_cir_wise_report',$this->data, true);
              $pdfFilePath ="date_and_cir_wise_report-".time()."-download.pdf";
              $pdf->useSubstitutions = true;
              $pdf->setFooter('|Page {PAGENO} of {nb}|');
              $pdf->WriteHTML($html,2);
              $pdf->Output($pdfFilePath, "I");

        }
    }

    // //date wise be icd report - End
	//Unit wise last24HrsPosition  start--Sumon
		function last24HrPositionForm()
    {
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$data['title']="LAST 24 HOURS POSITION..";
			$this->load->view('header2');
			$this->load->view('last24HrPositionForm',$data);
			$this->load->view('footer');
		}
	}
	
	function last24HrPositionFormPerform()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$data['date']=$this->input->post('date');
			$data['unit']=$this->input->post('unit');
			//echo $yards;
			$data['title']="LAST 24 HOURS POSITION..";
			//$this->load->view('header2');
			$this->load->view('last24HrPositionPerform',$data);
			//$this->load->view('footer');
		}
	}
	
	//Unit wise last24HrsPosition  end
	
	//ocr report - start
	function ocr_report_form()
	{
		$login_id = $this->session->userdata('login_id');
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$data['title']="OCR REPORT FORM";
			$data['msg']="";
				
			$this->load->view('header2');
			$this->load->view('ocr_report_form',$data);
			$this->load->view('footer');	
		}
	}
	
	function ocr_report_action()
	{
		$login_id = $this->session->userdata('login_id');
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$this->load->library('m_pdf');
			$mpdf->use_kwt = true;

			$search_by=$this->input->post('search_by');
			$from_dt=$this->input->post('from_dt');
			$to_dt=$this->input->post('to_dt');
			
			if($search_by=="ocd")
			{
				$sql_ocr_report="SELECT unit_gkey,cont_number,freight_kind,
				(SELECT rd.created
				FROM sparcsn4.road_truck_transactions
				INNER JOIN sparcsn4.road_documents rd ON rd.tran_gkey=sparcsn4.road_truck_transactions.gkey
				WHERE sparcsn4.road_truck_transactions.unit_gkey=mis_ocr_info.unit_gkey AND rd.doctype_gkey='7'
				ORDER BY sparcsn4.road_truck_transactions.gkey DESC LIMIT 1) AS eir_taken,
				entry_dt_time AS out_time,assign_dt,cf_name,
				(SELECT sparcsn4.road_truck_visit_details.bat_nbr
				FROM sparcsn4.road_truck_transactions
				INNER JOIN sparcsn4.road_truck_visit_details ON sparcsn4.road_truck_visit_details.tvdtls_gkey=sparcsn4.road_truck_transactions.truck_visit_gkey
				WHERE sparcsn4.road_truck_transactions.unit_gkey=mis_ocr_info.unit_gkey ORDER BY sparcsn4.road_truck_transactions.gkey LIMIT 1) AS trailer_no,
				(SELECT sparcsn4.road_truck_visit_details.truck_license_nbr
				FROM sparcsn4.road_truck_transactions
				INNER JOIN sparcsn4.road_truck_visit_details ON sparcsn4.road_truck_visit_details.tvdtls_gkey=sparcsn4.road_truck_transactions.truck_visit_gkey
				WHERE sparcsn4.road_truck_transactions.unit_gkey=mis_ocr_info.unit_gkey ORDER BY sparcsn4.road_truck_transactions.gkey LIMIT 1) AS truck_license_nbr,
				TIMEDIFF(entry_dt_time,(SELECT rd.created
				FROM sparcsn4.road_truck_transactions
				INNER JOIN sparcsn4.road_documents rd ON rd.tran_gkey=sparcsn4.road_truck_transactions.gkey
				WHERE sparcsn4.road_truck_transactions.unit_gkey=mis_ocr_info.unit_gkey AND rd.doctype_gkey='7'
				ORDER BY rd.gkey DESC LIMIT 1)) AS time_diff
				FROM ctmsmis.mis_ocr_info
				WHERE off_dock_code='2591' AND entry_dt BETWEEN '$from_dt' AND '$to_dt'";
			}
			else if($search_by=="depo")
			{
				$sql_ocr_report="SELECT DISTINCT off_dock_code,
				(SELECT offdoc.code FROM ctmsmis.offdoc WHERE id=mis_ocr_info.off_dock_code) AS depo_code,
				(SELECT offdoc.name FROM ctmsmis.offdoc WHERE id=mis_ocr_info.off_dock_code) AS depo_name
				FROM ctmsmis.mis_ocr_info
				WHERE off_dock_code!='2591' AND entry_dt BETWEEN '$from_dt' AND '$to_dt'
				ORDER BY depo_code";
			}
			
			$rslt_ocr_report=$this->bm->dataSelect($sql_ocr_report);
				
			$this->data['rslt_ocr_report']=$rslt_ocr_report;
			
			$dest="";
			if($search_by=="ocd")
				$dest="On Chasis Delivery";
			else if($search_by=="depo")
				$dest="Depo";
			
			$this->data['search_by']=$search_by;
			$this->data['dest']=$dest;
			$this->data['from_dt']=$from_dt;
			$this->data['to_dt']=$to_dt;
			
		//	$this->load->view('ocr_report_view',$data);
			
			$html=$this->load->view('ocr_report_view',$this->data, true); 

			$pdfFilePath ="ocr_report_view-".time()."-download.pdf";

			$pdf = $this->m_pdf->load();

			$pdf->SetWatermarkText('CPA CTMS');
			$pdf->showWatermarkText = true;

			//$stylesheet = file_get_contents(CSS_PATH.'style.css'); // external css
			//$stylesheet = file_get_contents('resources/styles/test.css'); 
			$pdf->useSubstitutions = true; 
				
			$pdf->setFooter('Prepared By : '.$login_id.'|Page {PAGENO}|Date {DATE j-m-Y}');

			//$pdf->WriteHTML($stylesheet,1);
			$pdf->WriteHTML($html,2);
				
			$pdf->Output($pdfFilePath, "I");
		}
	}
	//ocr report - end
	
	
	function Offdock($login_id)
	{
		$offdoc ="";
		if($login_id=='gclt')
		{
			$offdoc = "3328";
		}
		elseif($login_id=='saple')
		{
			$offdoc = "3450";
		}
		elseif($login_id=='saplw')
		{
			$offdoc = "2603";
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
		elseif($login_id=='kdsl')
		{
			$offdoc = "2624";
		}		
		else
		{
		 $offdoc = "";
		}
		return $offdoc;
	}
		
        
}
?>