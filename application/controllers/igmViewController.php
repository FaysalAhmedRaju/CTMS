<?php

class igmViewController extends CI_Controller {
	function __construct()
	{
	    parent::__construct();	
            $this->load->library(array('session', 'form_validation'));
            $this->load->model(array('CI_auth', 'CI_menu'));
            $this->load->helper(array('html','form', 'url'));
			$this->load->driver('cache');
			$this->load->library("pagination");
			
			
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
			
	}
        
        function index(){
		 $this->viewIgmGeneral();
        }
		function myPanelView(){
			if($this->session->userdata('login_id'))
			{
				$this->load->view('header2');
				$this->load->view('panelView');
				$this->load->view('footer');
			}
			else
			{
			
				$this->load->view('header');
				$this->load->view('welcomeview_1',$data);
				$this->load->view('footer');
			}
			
		}
		
		//view Vessel GM
		function viewIgmGeneral(){
			//print_r($this->session->all_userdata());
			
			$user = $this->session->userdata('login_id');
			$user=str_replace(" ","",$user);
			$session_id = $this->session->userdata('value');
			//print($session_id."<hr>");
			
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
			
				$type_of_Igm = $this->uri->segment(3);
				$this->load->model('ci_auth', 'bm', TRUE);
			
				/*********** Pagination**************/
				
				$config = array();
				$config["base_url"] = site_url("igmViewController/viewIgmGeneral/$type_of_Igm");
				$config["total_rows"] = $this->bm->record_count();
				$config["per_page"] = 5;
				$config["uri_segment"] = 4;
			
				$this->pagination->initialize($config);
				$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			
				/***********Pagination***************/
					
				$igmMasterList = $this->bm->myListForm($type_of_Igm,$config["per_page"], $page); ///ai khane error khachche
				$datahome['igmMasterList']=$igmMasterList;
               
				$data['title']="View Vessel Declaration Detail($type_of_Igm)...";
				$data['type']=$type_of_Igm;
				$data["links"] = $this->pagination->create_links();
				$this->load->view('header1',$datahome);
				$this->load->view('myCNFViewIGmListHTML',$data);
				//$this->load->view('myCNFViewIGmListHTML', array_merge($data, $datahome));
				$this->load->view('footer2');
				
			}
		}
		
		//Search Vessel
		function myListSearch(){
			//print_r($this->session->all_userdata());
			
			$user = $this->session->userdata('login_id');
			$user=str_replace(" ","",$user);
			$session_id = $this->session->userdata('value');
			//print($session_id."<hr>");
			
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$SearchCriteria=$this->input->post('SearchCriteria');
				$Searchdata=$this->input->post('Searchdata');
				$type=$this->input->post('type');
				//echo $type."<hr>";
				
				$this->load->model('ci_auth', 'bm', TRUE);
				
				$igmMasterList = $this->bm->myListSearch($type,$SearchCriteria, $Searchdata); ///ai khane error khachche
				$datahome['igmMasterList']=$igmMasterList;
               
				$data['title']="View Vessel Declaration Detail($type)...";
				$data['type']=$type;
				
				$this->load->view('header1',$datahome);
				$this->load->view('myCNFViewIGmListHTML',$data);
				//$this->load->view('myCNFViewIGmListHTML', array_merge($data, $datahome));
				$this->load->view('footer2');
				
			}
		}
		
		//view Igm GM
		function myListForm(){
			//print_r($this->session->all_userdata());
			
			$user = $this->session->userdata('login_id');
			$user=str_replace(" ","",$user);
			$session_id = $this->session->userdata('value');
			//print($session_id."<hr>");
			
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
			
				$CODE = $this->uri->segment(3);
				$type_of_Igm = $this->uri->segment(4);
				$this->load->model('ci_auth', 'bm', TRUE);
			
				/*********** Pagination**************/
				
				$config = array();
				$config["base_url"] = site_url("igmViewController/myListForm/$CODE/$type_of_Igm");
				$config["total_rows"] = $this->bm->record_count();
				$config["per_page"] = 5;
				$config["uri_segment"] = 5;
			
				$this->pagination->initialize($config);
				$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
			
				/***********Pagination***************/
					
				$igmMasterList = $this->bm->myListFormIGM($CODE,$type_of_Igm,$config["per_page"], $page); ///ai khane error khachche
				$datahome['igmMasterList']=$igmMasterList;
               
				$data['title']="LIST OF IGM SUB DETAILS ($type_of_Igm)...";
				$data['type']=$type_of_Igm;
				$data['CODE']=$CODE;
				$data['user']=$user;
				$data["links"] = $this->pagination->create_links();
				$this->load->view('header3',$datahome);
				$this->load->view('myCNFIGMSubListHTML',$data);
				//$this->load->view('myCNFViewIGmListHTML', array_merge($data, $datahome));
				$this->load->view('footer2');
				
			}
		}
		//Search by Port................
		function myListSearchforPort(){
			//print_r($this->session->all_userdata());
			
			$user = $this->session->userdata('login_id');
			$user=str_replace(" ","",$user);
			$session_id = $this->session->userdata('value');
			//print($session_id."<hr>");
			
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$CODE=$this->input->post('txt_CODE2');
				$TM=$this->input->post('txt_TM2');
				$txt_ROTATION=$this->input->post('txt_ROTATION');
				$org_type_id=$this->input->post('txt_Org_Id_for_search2');
			
				
				$this->load->model('ci_auth', 'bm', TRUE);
				
				$igmMasterList = $this->bm->myListSearchforPort($CODE,$TM, $txt_ROTATION,$org_type_id); ///ai khane error khachche
				$datahome['igmMasterList']=$igmMasterList;
               
				$data['title']="LIST OF IGM SUB DETAILS ($TM)...";
				$data['type']=$TM;
				$data['CODE']=$CODE;
				
				$this->load->view('header3',$datahome);
				$this->load->view('myCNFIGMSubListHTML',$data);
				//$this->load->view('myCNFViewIGmListHTML', array_merge($data, $datahome));
				$this->load->view('footer2');
				
			}
		}
		
		//Search by Line/BL...............
		function myListSearchLineBL(){
			//print_r($this->session->all_userdata());
			
			$user = $this->session->userdata('login_id');
			$user=str_replace(" ","",$user);
			$session_id = $this->session->userdata('value');
			//print($session_id."<hr>");
			
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$CODE=$this->input->post('MCODE');
				$TM=$this->input->post('TM');
				$txt_ROTATION=$this->input->post('txt_ROTATION');
				$SearchId=$this->input->post('lbl_search');
				$SearchData=$this->input->post('txt_serch');
			
				//echo $SearchId."<hr>";
				$this->load->model('ci_auth', 'bm', TRUE);
				
				$igmMasterList = $this->bm->myListSearchLineBL($CODE,$TM, $txt_ROTATION,$SearchId,$SearchData); ///ai khane error khachche
				$datahome['igmMasterList']=$igmMasterList;
               
				$data['title']="LIST OF IGM SUB DETAILS ($TM)...";
				$data['type']=$TM;
				$data['CODE']=$CODE;
				
				$this->load->view('header3',$datahome);
				$this->load->view('myCNFIGMSubListHTML',$data);
				//$this->load->view('myCNFViewIGmListHTML', array_merge($data, $datahome));
				$this->load->view('footer2');
				
			}
		}
		
		//Search by Importer..............
		function myListSearchImporter(){
			//print_r($this->session->all_userdata());
			
			$user = $this->session->userdata('login_id');
			$user=str_replace(" ","",$user);
			$session_id = $this->session->userdata('value');
			//print($session_id."<hr>");
			
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$CODE=$this->input->post('MCODE');
				$TM=$this->input->post('TM');
				$txt_ROTATION=$this->input->post('txt_ROTATION');
				$SearchId=$this->input->post('lbl_search');
				$SearchData=$this->input->post('txt_serch');
			
				//echo $SearchId."<hr>";
				$this->load->model('ci_auth', 'bm', TRUE);
				
				$igmMasterList = $this->bm->myListSearchImporter($CODE,$TM, $txt_ROTATION,$SearchId,$SearchData); ///ai khane error khachche
				$datahome['igmMasterList']=$igmMasterList;
               
				$data['title']="LIST OF IGM SUB DETAILS ($TM)...";
				$data['type']=$TM;
				$data['CODE']=$CODE;
				$data['user']=$user;
				
				$this->load->view('header3',$datahome);
				$this->load->view('myCNFIGMSubListHTML',$data);
				//$this->load->view('myCNFViewIGmListHTML', array_merge($data, $datahome));
				$this->load->view('footer2');
				
			}
		}
		
		//Search by MLO Code...............
		function myListSearchMLO(){
			//print_r($this->session->all_userdata());
			
			$user = $this->session->userdata('login_id');
			$user=str_replace(" ","",$user);
			$session_id = $this->session->userdata('value');
			//print($session_id."<hr>");
			
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$CODE=$this->input->post('txt_CODE');
				$TM=$this->input->post('txt_TM');
				$txt_ROTATION=$this->input->post('txt_ROTATION');
				$org_type_id=$this->input->post('txt_Org_Id_for_search123');
				//$SearchData=$this->input->post('txt_serch');
			
				//echo $SearchId."<hr>";
				$this->load->model('ci_auth', 'bm', TRUE);
				
				$igmMasterList = $this->bm->myListSearchMLO($CODE,$TM, $txt_ROTATION,$org_type_id); ///ai khane error khachche
				$datahome['igmMasterList']=$igmMasterList;
               
				$data['title']="LIST OF IGM SUB DETAILS ($TM)...";
				$data['type']=$TM;
				$data['CODE']=$CODE;
				
				$this->load->view('header3',$datahome);
				$this->load->view('myCNFIGMSubListHTML',$data);
				//$this->load->view('myCNFViewIGmListHTML', array_merge($data, $datahome));
				$this->load->view('footer2');
				
			}
		}
		//Search by MLO Name...............
		function myListSearchByMLO(){
			//print_r($this->session->all_userdata());
			
			$user = $this->session->userdata('login_id');
			$user=str_replace(" ","",$user);
			$session_id = $this->session->userdata('value');
			//print($session_id."<hr>");
			
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$CODE=$this->input->post('txt_CODE');
				$TM=$this->input->post('txt_TM');
				$txt_ROTATION=$this->input->post('txt_ROTATION');
				$org_type_id=$this->input->post('txt_Org_Id_for_search123');
				//$SearchData=$this->input->post('txt_serch');
			
				//echo $SearchId."<hr>";
				$this->load->model('ci_auth', 'bm', TRUE);
				
				$igmMasterList = $this->bm->myListSearchByMLO($CODE,$TM, $txt_ROTATION,$org_type_id); ///ai khane error khachche
				$datahome['igmMasterList']=$igmMasterList;
               
				$data['title']="LIST OF IGM SUB DETAILS ($TM)...";
				$data['type']=$TM;
				$data['CODE']=$CODE;
				
				$this->load->view('header3',$datahome);
				$this->load->view('myCNFIGMSubListHTML',$data);
				//$this->load->view('myCNFViewIGmListHTML', array_merge($data, $datahome));
				$this->load->view('footer2');
				
			}
		}
		
		//Search by SAF Name...............
		function myListSearchBySAF(){
			//print_r($this->session->all_userdata());
			
			$user = $this->session->userdata('login_id');
			$user=str_replace(" ","",$user);
			$session_id = $this->session->userdata('value');
			//print($session_id."<hr>");
			
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$CODE=$this->input->post('txt_CODE');
				$TM=$this->input->post('txt_TM');
				$txt_ROTATION=$this->input->post('txt_ROTATION');
				$org_type_id=$this->input->post('txt_Org_Id_for_search122');
				//$SearchData=$this->input->post('txt_serch');
			
				//echo $SearchId."<hr>";
				$this->load->model('ci_auth', 'bm', TRUE);
				
				$igmMasterList = $this->bm->myListSearchBySAF($CODE,$TM, $txt_ROTATION,$org_type_id); ///ai khane error khachche
				$datahome['igmMasterList']=$igmMasterList;
               
				$data['title']="LIST OF IGM SUB DETAILS ($TM)...";
				$data['type']=$TM;
				$data['CODE']=$CODE;
				
				$this->load->view('header3',$datahome);
				$this->load->view('myCNFIGMSubListHTML',$data);
				//$this->load->view('myCNFViewIGmListHTML', array_merge($data, $datahome));
				$this->load->view('footer2');
				
			}
		}
		/************************************************* View Img Search End *********************************************/
		/*************************************************Start Supplementary**********************************************/
		
		//view Igm GM
		function myListFormSEasy(){
			//print_r($this->session->all_userdata());
			
			$user = $this->session->userdata('login_id');
			$user=str_replace(" ","",$user);
			$session_id = $this->session->userdata('value');
			//print($session_id."<hr>");
			
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
			
				
				$MCODE = $this->uri->segment(3);
				$TM = $this->uri->segment(4);
				$CType = $this->uri->segment(5);
				//echo $MCODE."=".$TM."=".$CType;
				
				$this->load->model('ci_auth', 'bm', TRUE);
			
				/*********** Pagination**************/
				
				$config = array();
				$config["base_url"] = site_url("igmViewController/myListForm/$CODE/$type_of_Igm");
				$config["total_rows"] = $this->bm->record_count();
				$config["per_page"] = 5;
				$config["uri_segment"] = 6;
			
				$this->pagination->initialize($config);
				$page = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
			
				/***********Pagination***************/
					
				$igmMasterList = $this->bm->myListFormSEasy($MCODE,$TM,$CType,$config["per_page"], $page); ///ai khane error khachche
				$datahome['igmMasterList']=$igmMasterList;
               
				$data['title']="VIEW IGM SUPPLEMENTARY DETAIL...";
				$data['type']=$TM;
				$data['MCODE']=$MCODE;
				$data['CType']=$CType;
				$data["links"] = $this->pagination->create_links();
				$this->load->view('header3',$datahome);
				$this->load->view('myIGMFFSupplListHTMLEasy',$data);
				//$this->load->view('myCNFViewIGmListHTML', array_merge($data, $datahome));
				$this->load->view('footer2');
				
			}
		}
		
		//view Supp Igm GM Search By Line/BL
		function myListSearchFFByLineBL(){
			//print_r($this->session->all_userdata());
			
			$user = $this->session->userdata('login_id');
			$user=str_replace(" ","",$user);
			$session_id = $this->session->userdata('value');
			//print($session_id."<hr>");
			
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
			
				
				$CType=$this->input->post('CType');
				$MCODE=$this->input->post('MCODE');
				$master_id=$this->input->post('rot_search');
				$TM=$this->input->post('TM');
				$SFlag=$this->input->post('txt_SFlag');
				$txt_ROTATION=$this->input->post('txt_ROTATION');
				$SearchId=$this->input->post('lbl_search');
				$SearchData=$this->input->post('txt_serch');
				$this->load->model('ci_auth', 'bm', TRUE);
					
				$igmMasterList = $this->bm->myListSearchFFByLineBL($CType,$MCODE,$master_id,$TM,$SearchId,$SearchData,$SFlag,$txt_ROTATION); ///ai khane error khachche
				$datahome['igmMasterList']=$igmMasterList;
               
				$data['title']="VIEW IGM SUPPLEMENTARY DETAIL...";
				$data['type']=$TM;
				$data['MCODE']=$MCODE;
				$data['CType']=$CType;
				
				$this->load->view('header3',$datahome);
				$this->load->view('myIGMFFSupplListHTMLEasy',$data);
				//$this->load->view('myCNFViewIGmListHTML', array_merge($data, $datahome));
				$this->load->view('footer2');
				
			}
		}
		
		//view Supp Igm GM Search By FF Agent
		function myListSearchFFByFF(){
			//print_r($this->session->all_userdata());
			
			$user = $this->session->userdata('login_id');
			$user=str_replace(" ","",$user);
			$session_id = $this->session->userdata('value');
			//print($session_id."<hr>");
			
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
			
				
				$CType=$this->input->post('CType');
				$MCODE=$this->input->post('txt_ccc');
				$master_id=$this->input->post('rot_search');
				$TM=$this->input->post('txt_TMccc2');
				$SFlag=$this->input->post('txt_SFlag');
				$txt_ROTATION=$this->input->post('txt_ROTATION');
				$SearchId=$this->input->post('txt_Org_Id_for_submittedFF');
				//$SearchData=$this->input->post('txt_serch');
				$this->load->model('ci_auth', 'bm', TRUE);
					
				$igmMasterList = $this->bm->myListSearchFFByFF($MCODE,$TM,$SearchId,$txt_ROTATION); ///ai khane error khachche
				$datahome['igmMasterList']=$igmMasterList;
               
				$data['title']="VIEW IGM SUPPLEMENTARY DETAIL...";
				$data['type']=$TM;
				$data['MCODE']=$MCODE;
				$data['CType']=$CType;
				
				$this->load->view('header3',$datahome);
				$this->load->view('myIGMFFSupplListHTMLEasy',$data);
				//$this->load->view('myCNFViewIGmListHTML', array_merge($data, $datahome));
				$this->load->view('footer2');
				
			}
		}
		
		//view Supp Igm GM ...................
		function myListFormS(){
			//print_r($this->session->all_userdata());
			
			$user = $this->session->userdata('login_id');
			$user=str_replace(" ","",$user);
			$session_id = $this->session->userdata('value');
			//print($session_id."<hr>");
			
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
			
				$CODE = $this->uri->segment(3);
				$SubCODE = $this->uri->segment(4);
				$TM = $this->uri->segment(5);
				//$SearchData=$this->input->post('txt_serch');
				$this->load->model('ci_auth', 'bm', TRUE);
					
				$igmMasterList = $this->bm->myListFormS($CODE,$SubCODE,$TM); ///ai khane error khachche
				$datahome['igmMasterList']=$igmMasterList;
               
				$data['title']="VIEW IGM SUPPLEMENTARY DETAIL...";
				$data['type']=$TM;
				$data['CODE']=$CODE;
				$data['SubCODE']=$SubCODE;
				
				$this->load->view('header3',$datahome);
				$this->load->view('myIGMSupplListHTML',$data);
				//$this->load->view('myCNFViewIGmListHTML', array_merge($data, $datahome));
				$this->load->view('footer2');
				
			}
		}
		//view Supp Igm GM Search By Port
		function myListSearchFFByPort(){
			//print_r($this->session->all_userdata());
			
			$user = $this->session->userdata('login_id');
			$user=str_replace(" ","",$user);
			$session_id = $this->session->userdata('value');
			//print($session_id."<hr>");
			
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
			
				
				$CODE=$this->input->post('txt_CODE');
				$SubCode=$this->input->post('txt_SubCode');
				$TM=$this->input->post('txt_TM');
				$org_type_id=$this->input->post('txt_Org_Id_for_search2');
				
				$this->load->model('ci_auth', 'bm', TRUE);
					
				$igmMasterList = $this->bm->myListSearchFFByPort($CODE,$SubCode,$TM,$org_type_id); ///ai khane error khachche
				$datahome['igmMasterList']=$igmMasterList;
               
				$data['title']="VIEW IGM SUPPLEMENTARY DETAIL...";
				$data['type']=$TM;
				$data['CODE']=$CODE;
				$data['SubCode']=$SubCode;
				
				$this->load->view('header3',$datahome);
				$this->load->view('myIGMSupplListHTML',$data);
				//$this->load->view('myCNFViewIGmListHTML', array_merge($data, $datahome));
				$this->load->view('footer2');
				
			}
		}
		/*********************************************End IGM Supplementary ********************************************************/
		//view Igm Container HTML..........................................
		function myIGMContainer(){
			//print_r($this->session->all_userdata());
			
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
			
				$data['title']="IGM Container List...";
				$this->load->view('header4');
				$this->load->view('myIGMDetailsContainerListHTML',$data);
				//$this->load->view('footer');
			}
		}
		
		//view Igm Container List...............................................
		function myIGMContainerList(){
		
			//$type_of_Igm = $this->uri->segment(3);
			$Searchdata=$this->input->post('Searchdata');
			$SearchCriteria2=$this->input->post('SearchCriteria2');
			//echo $SearchCriteria2;
			$this->load->model('ci_auth', 'bm', TRUE);
			$igmContainerList = $this->bm->myIgmContainerListSearch($Searchdata);
        
			$datahome['igmContainerList']=$igmContainerList;
			//$data['igmContainerList']=$igmContainerList;
        
			$data['title']="IGM Container List...";
			$data['rotation']=$Searchdata;
			$data['SearchCriteria2']=$SearchCriteria2;
			$this->load->view('header4',$datahome);
			$this->load->view('myIGMDetailsContainerListHTML',$data);
			$this->load->view('footer2');
		
		
		
		}
		
		//view Check the IGM HTML..........................................
		function checkTheIGM(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
			
				$data['title']="Check The Document...";
				$this->load->view('header2');
				$this->load->view('myCustomDocumentcheckHTML',$data);
				$this->load->view('footer');
			}
		}
		
		//view Check the IGM HTML..........................................
		function viewIGM(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
			
				$data['title']="Check The Document...";
				$this->load->view('header');
				$this->load->view('myViewIgmCheckList',$data);
				$this->load->view('footer');
			}
		}
		
		//view Check the IGM HTML..........................................
		function viewIGMList(){
			//print_r($this->session->all_userdata());
			$session_id = $this->session->userdata('value');
			$impno=$this->input->post('impno');
			$lineno=$this->input->post('lineno');
			$igm=$this->input->post('options');
			$impno1=$this->input->post('impno1');
			$blno=$this->input->post('blno');
			$data['impno']=$impno;
			$data['lineno']=$lineno;
			$data['igm']=$igm;
			$data['impno1']=$impno1;
			$data['blno']=$blno;
			
			//echo $impno."=rot=".$lineno."=Line=".$igm."=igm=".$impno1."=rot2=".$blno."=bol=";
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
			
				$data['title']="Check The Document...";
				$this->load->view('header1');
				$this->load->view('myCustomAirIgmHTML',$data);
				$this->load->view('footer');
			}
		}
		
		
		//view Check the IGM List...............................................
		function checkTheIGMList(){
		
			//$type_of_Igm = $this->uri->segment(3);
			$txt_imp_rot=$this->input->post('txt_imp_rot');
			$txt_line=$this->input->post('txt_line');
			$txt_imp_rot1=$this->input->post('txt_imp_rot1');
			$txt_bl=$this->input->post('txt_bl');
						       
			$data['title']="Check The Document...";
			$data['txt_imp_rot']=$txt_imp_rot;
			$data['txt_line']=$txt_line;
			$data['txt_imp_rot1']=$txt_imp_rot1;
			$data['txt_bl']=$txt_bl;
			
			$this->load->view('header3');
			$this->load->view('myCustomDocumentcheckList',$data);
			//$this->load->view('footer');
		
				
		}
		
		//UpDate Manifest....
		function updateManifest(){
			//print_r($this->session->all_userdata());
			
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
				
			}
			else
			{
				$data['title']="CONVERT IGM...";
				$this->load->view('header2');
				$this->load->view('myUpdateManifest',$data);
				$this->load->view('footer');
			}	
        }
		//UpDate Manifest....
		function updateManifestList(){
			//print_r($this->session->all_userdata());
			
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();				
			}
			else
			{
				$ddl_imp_rot_no=$this->input->post('ddl_imp_rot_no');
				$data['title']="UPDATE MANIFEST...";
				//$this->load->view('header2');
				$this->load->model('ci_auth', 'bm', TRUE);
				$igmContainerList = $this->bm->updateManifestList($ddl_imp_rot_no);
				//echo 
				$strChkEdi = "select count(*) as rtnValue from edi_stow_info where ucase(file_name_edi)=ucase(concat(replace('$ddl_imp_rot_no','/','_'),'.edi'))";
				$ediSt = $this->bm->dataReturnDb1($strChkEdi);
				
				$strCntryCode = "select sparcsn4.vsl_vessels.country_code as rtnValue
				from sparcsn4.vsl_vessel_visit_details
				inner join sparcsn4.vsl_vessels on sparcsn4.vsl_vessels.gkey=sparcsn4.vsl_vessel_visit_details.vessel_gkey
				where ib_vyg='$ddl_imp_rot_no'";
				$CntryCode = $this->bm->dataReturn($strCntryCode);
				
				if(count($igmContainerList)==0)
				{
					$data['title']="CONVERT IGM...";
					$data['msg']="<font color='red' size='2'><b>You can not convert IGM before getting IGM from Customs ASYCODA WORLD...</b></font>";
					$this->load->view('header2',$igmContainerList);
					$this->load->view('myUpdateManifest',$data);
					$this->load->view('footer');
				}
				else if($ediSt==0 and $CntryCode!="BD")
				{
					$data['title']="CONVERT IGM...";
					$data['msg']="<font color='red' size='2'><b>EDI for Rotation <strong>$ddl_imp_rot_no</strong> not uploaded through <strong>myportpanel</strong>...</b></font>";
					$this->load->view('header2',$igmContainerList);
					$this->load->view('myUpdateManifest',$data);
					$this->load->view('footer');
				}
				else
				{
					// for checking export loading complete start awal
					$strChkBO = "SELECT IFNULL(IFNULL(flex_string03,flex_string02),'NB') AS rtnValue
					FROM sparcsn4.vsl_vessel_visit_details WHERE ib_vyg='$ddl_imp_rot_no'";
					//$bo = $this->bm->dataReturn($strChkBO);
					$bo = "";
					if($bo=="NB")
					{
						$data['title']="CONVERT IGM...";
						$data['msg']="<font color='red' size='2'><b>Please assign berth operator name for rotaiton ".$ddl_imp_rot_no."...</b></font>";
						$this->load->view('header2',$igmContainerList);
						$this->load->view('myUpdateManifest',$data);
						$this->load->view('footer');
					}
					else
					{
						$strBOpOrg = "select id as rtnValue from organization_profiles where Organization_Name='$bo'";
						$BOpOrg = $this->bm->dataReturnDb1($strBOpOrg);
						
						$strBlockRotCount = "select count(*) as rtnValue from ctmsmis.mis_exp_vvd
						where brth_org_id='$BOpOrg' and ucase(comments) !='OK'";
						//$cnt = $this->bm->dataReturn($strBlockRotCount);
						$cnt = 0;
						
						if($cnt>0)
						{
							$strBlockRotList = "select ib_vyg as rtnValue from ctmsmis.mis_exp_vvd
							inner join sparcsn4.vsl_vessel_visit_details on sparcsn4.vsl_vessel_visit_details.vvd_gkey=ctmsmis.mis_exp_vvd.vvd_gkey
							where brth_org_id='$org_id' and ucase(comments) !='OK'";
							$BlockRotList = $this->bm->dataSelect($strBlockRotList);
							$strBRot = "";
							for($brl=0;$brl<count($strBlockRotList);$brl++)
							{
								$strBRot .= $strBlockRotList[$brl]['rtnValue'].", ";
							}
							$data['title']="CONVERT IGM...";
							$data['msg']="<font color='red' size='2'><b>IGM ".$ddl_imp_rot_no." is not convertable because berth operator of this IGM is ".$bo." and his previous export rotation ".$strBRot." is not complete...</b></font>";
							$this->load->view('header2',$igmContainerList);
							$this->load->view('myUpdateManifest',$data);
							$this->load->view('footer');
						}
						else
						{
							for($i=0;$i<count($igmContainerList);$i++)
							{
								//echo "shemul3";
								$imp=$igmContainerList[$i]['Import_Rotation_No'];
								$Total_number_of_containers=$igmContainerList[$i]['Total_number_of_containers'];
								$Total_number_of_bols=$igmContainerList[$i]['Total_number_of_bols'];
								$Total_number_of_containers=str_replace(" ","",$Total_number_of_containers);
								if($Total_number_of_containers==0)
								{
									$data['title']="CONVERT IGM...";
									$data['msg']="<font color='red' size='2'><b>This is Break Bulk(BB) IGM. You can not convert this IGM</b></font>";
									$this->load->view('header2',$igmContainerList);
									$this->load->view('myUpdateManifest',$data);
									$this->load->view('footer');
								}
								if($Total_number_of_bols>0)
								{
									//echo "shemul2";
									$igmList = $this->bm->updateManifestList1($ddl_imp_rot_no);
									//echo count($igmList);
									if(count($igmList)==0)
									{
										//echo "shemul4";
										$data['title']="CONVERT IGM...";
										$data['msg']="<font color='red' size='2'><b>Only General segment is available from ASYCODA WORLD.<br> You can not convert this IGM before getting BL Segment..</b></font>";
										$this->load->view('header2',$igmContainerList);
										$this->load->view('myUpdateManifest',$data);
										$this->load->view('footer');
									}
									else
									{
										$this->load->view('myUpdateManifestList',$data);
									}
								}						
							}
						}
					}
				}
				
				
				
				
				//$this->load->view('myUpdateManifestList',$data);
				
				///$data['a']=$a;
				//$this->load->view('myUpdateManifest',$data);
				
				//$data['myUpdateManifestList'] = $this->load->view('myUpdateManifestList', $ddl_imp_rot_no, TRUE);
				//$this->load->view ('myUpdateManifest', $data);
				//$this->load->view('footer');
			}	
        }
		
		//view Delivery Dash Board HTML..........................................
		function myDBDelivery(){
			//print_r($this->session->all_userdata());
			
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
			
				$data['title']="Delivery Dash Board Import...";
				$this->load->view('header2');
				$this->load->view('myDBDeliveryGoodsHTML',$data);
				$this->load->view('footer');
			}
		}
		
		//view Delivery Dash Board List...............................................
		function myDBDeliveryList(){
		
			//$type_of_Igm = $this->uri->segment(3);
			$txt_imp_rot=$this->input->post('txt_imp_rot');
			$txt_line=$this->input->post('txt_line');
			$txt_imp_rot1=$this->input->post('txt_imp_rot1');
			$txt_bl=$this->input->post('txt_bl');			        
			$data['title']="Delivery Dash Board Import...";
			$data['txt_imp_rot']=$txt_imp_rot;
			$data['txt_line']=$txt_line;
			$data['txt_imp_rot1']=$txt_imp_rot1;
			$data['txt_bl']=$txt_bl;
			
			$this->load->view('header2');
			$this->load->view('myCustomDocumentcheckList',$data);
			$this->load->view('footer');
		
		
		
		}
		function viewImporterList(){
			$this->load->model('ci_auth', 'bm', TRUE);
			$session_id = $this->session->userdata('value');
			$type = $this->uri->segment(3);
			$search=$this->input->post('search');
			
			/*********** Pagination**************/
				
				$config = array();
				$config["base_url"] = site_url("igmViewController/viewImporterList/$type");
				$config["total_rows"] = $this->bm->record_count_igm();
				$config["per_page"] = 20;
				$config["uri_segment"] = 4;
			
				$this->pagination->initialize($config);
				$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
				
				$limit=$config["per_page"];
				$start=$page;
			
				/***********Pagination***************/
			
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				
				if($type=="search"){
					$sql="select distinct Notify_code,ifnull(Notify_name,NotifyDesc) as notify_name,Notify_address from igm_details where upper(ifnull(notify_name,NotifyDesc)) like upper('%$search%')order by id desc limit $start,$limit";
				}
				else
					$sql="select distinct Notify_code,ifnull(Notify_name,NotifyDesc) as notify_name,Notify_address from igm_details order by id desc limit $start,$limit";
				//echo $sql;
				
				$igmImporterList = $this->bm->dataSelectDb1($sql);
				$data['igmImporterList']=$igmImporterList;
				
				$data["links"] = $this->pagination->create_links();
				$data['title']="Importer List...";
				$this->load->view('header2');
				$this->load->view('myViewImporterList',$data);
				$this->load->view('footer');
			}
		}
		
		function viewExporterList(){
			$this->load->model('ci_auth', 'bm', TRUE);
			$session_id = $this->session->userdata('value');
			$type = $this->uri->segment(3);
			$search=$this->input->post('search');
			
			/*********** Pagination**************/
				
				$config = array();
				$config["base_url"] = site_url("igmViewController/viewExporterList/$type");
				$config["total_rows"] = $this->bm->record_count_igm();
				$config["per_page"] = 20;
				$config["uri_segment"] = 4;
			
				$this->pagination->initialize($config);
				$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
				
				$limit=$config["per_page"];
				$start=$page;
			
				/***********Pagination***************/
			
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				
				if($type=="search"){
					$sql="select distinct Exporter_name,Exporter_address from igm_details  where Exporter_name like '%$search%' order by id desc limit $start,$limit";
				}
				else
					$sql="select distinct Exporter_name,Exporter_address from igm_details order by id desc limit $start,$limit";
				//echo $sql;
				
				$igmImporterList = $this->bm->dataSelectDb1($sql);
				$data['igmImporterList']=$igmImporterList;
				
				$data["links"] = $this->pagination->create_links();
				$data['title']="Exporter List...";
				$this->load->view('header2');
				$this->load->view('myViewExporterList',$data);
				$this->load->view('footer');
			}
		}
		
		
		function logout(){
		
          
			$data['body']="<font color='blue' size=2>LogOut Successfully....</font>";

			$this->session->sess_destroy();
			$this->cache->clean();
			//redirect(base_url(),$data);
			$this->load->view('header');
			$this->load->view('welcomeview_1', $data);
			$this->load->view('footer');
			$this->db->cache_delete_all();
        }
	// IGM INFORMATION ENTRY START	
	function igmInfoProcessForm()
	{
		$session_id = $this->session->userdata('value');			
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$login_id = $this->session->userdata('login_id');
			$data['title']="IGM INFORMATION PROCESS FORM...";
			$data['msg']="";

			$this->load->view('header2');
			$this->load->view('igmInfoProcessForm',$data);
			$this->load->view('footer');
			
		}
	}	
	function igmInfoProcess()
	{
		$session_id = $this->session->userdata('value');			
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$IGM_id=$this->input->post('IGM_id');
			$rotation_no=$this->input->post('rotation_no');
			$line_no=$this->input->post('line_no');			
			$bl_no=$this->input->post('bl_no');			
			$pck_num=$this->input->post('pck_num');
			$pck_desc=$this->input->post('pck_desc');
			$pck_marks_num=$this->input->post('pck_marks_num');
			$goods_desc=$this->input->post('goods_desc');
			$weight=$this->input->post('weight');
			$remarks=$this->input->post('remarks');
			$cons_desc=$this->input->post('cons_desc');
			$not_desc=$this->input->post('not_desc');
			//$sub_id=$this->input->post('sub_id');
			//$sub_dt=$this->input->post('sub_dt');
			$mlo_code=$this->input->post('mlo_code');
			$exp_name=$this->input->post('exp_name');
			$exp_addr=$this->input->post('exp_addr');
			$not_code=$this->input->post('not_code');
			$not_name=$this->input->post('not_name');
			$not_addr=$this->input->post('not_addr');
			$cons_code=$this->input->post('cons_code');
			$cons_name=$this->input->post('cons_name');
			$cons_addr=$this->input->post('cons_addr');
			$dg_stat=$this->input->post('dg_stat');
			$unload_code=$this->input->post('unload_code');
			$origine_code=$this->input->post('origine_code');
			
			//$login_id = $this->session->userdata('login_id');
			
			$insertIgmDtlQry="insert into igm_details (IGM_id,Import_Rotation_No,Line_No,BL_No,Pack_Number,Pack_Description,Pack_Marks_Number,Description_of_Goods,
							weight,Remarks,ConsigneeDesc,NotifyDesc,mlocode,
							Exporter_name,Exporter_address,Notify_code,Notify_name,Notify_address,Consignee_code,Consignee_name,Consignee_address,DG_status,
							place_of_unloading,port_of_origin) values ($IGM_id,'$rotation_no','$line_no','bl_no','$pck_num','$pck_desc','$pck_marks_num','$goods_desc','$weight',
							'$remarks','$cons_desc','$not_desc','$mlo_code','$exp_name','$exp_addr','$not_code','$not_name','$not_addr','$cons_code','$cons_name','$cons_addr',
							'$dg_stat','$unload_code','$origine_code')";
			//echo $insertIgmDtlQry;
			//return;
			//$statIgmDtl = $this->bm->dataInsertDB1($insertIgmDtlQry);  
			$statIgmDtl = 1;  
			if($statIgmDtl==1)
			{
				$data['msg']="IGM INFORMATION INSERTED SUCCESSFULLY FOR THE ROTATION NUMBER -> <b>".$rotation_no."</b>";
			}
			else
			{
				$data['msg']="IGM INFORMATION NOT INSERTED -> <b>".$rotation_no."</b>";
			}
			
			$data['title']="IGM INFORMATION PROCESS FORM...";		
			$this->load->view('header2');
			$this->load->view('igmInfoProcessForm',$data);
			$this->load->view('footer');
			
		}
	}
		// IGM INFORMATION ENTRY END
		
		
		
		
        
}
?>