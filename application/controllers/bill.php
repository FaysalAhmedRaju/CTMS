<?php
class bill extends CI_Controller {
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
			$config["base_url"] = site_url("bill/vesselBillList/$segment_three");
			$config["total_rows"] = $this->bm->dataReturn($sql_row_num);
			$config["per_page"] = 20;
			$offset = $this->uri->segment(4, 0);
			$config["uri_segment"] = 4;
			$limit=$config["per_page"];
			
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			$start=$page;
			
			$sql_bill_list="select draftNumber,IFNULL(finalNumber,draftNumber) as finalNumber,rotation,vsl_name,bill_name,ata,atd,berth,agent_code,agent_name,flag,cnt_code,bill_type from
							ctmsmis.mis_vsl_billing_detail where agent_code='$login_id' order by draftNumber DESC limit $start,$limit";
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
			
			$sql_search_bill="select draftNumber,IFNULL(finalNumber,draftNumber) as finalNumber,rotation,vsl_name,bill_name,ata,atd,berth,agent_code,agent_name,flag,cnt_code,bill_type 
			from ctmsmis.mis_vsl_billing_detail where rotation='$rotation' and agent_code='$login_id'";
			
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
					$bill_sql="select bill_name as invoiceDesc,if(cnt_code='BD',concat('JL/',mis_vsl_billing_detail.draftNumber,'-',substring(billing_date,4,1)),
								concat('JF/',mis_vsl_billing_detail.draftNumber,'-',substring(billing_date,4,1))) as draftNumber,
								vsl_name as vesselName,rotation as ibVoyageNbr,master_name as captain,atd as ATD,ata as ATA,agent_name as customerName,
								concat(agent_code,'(',ifnull(agent_alias_id,''),')') as payeecustomerkey,agent_address,grt as grossRevenueTons,
								exchangeRate as exchangeRate,date(billing_date) as created,berth as berth,flag as flagcountry,deck_cargo as cargo,date(oa_date) as ffd,
								description as description,gl_code as glcode,rate as rateBilled,bas as quantityUnit,
								IF(description LIKE 'BERTH_HIRE_1%',mis_vsl_billing_detail.unit,mis_vsl_billing_sub_detail.unit_for_pilot) as quantityBilled,
								if(description LIKE 'BERTH_HIRE_1%',((grt+ifnull(deck_cargo,0))*rate*unit),(rate*mis_vsl_billing_sub_detail.unit_for_pilot)) as totusd,
								creator,if(description LIKE 'BERTH_HIRE_1%',((grt+ifnull(deck_cargo,0))*rate*unit*exchangeRate),
								(rate*mis_vsl_billing_sub_detail.unit_for_pilot*exchangeRate)) as totbsd,  
								'DRAFT' as status from ctmsmis.mis_vsl_billing_detail
								inner join ctmsmis.mis_vsl_billing_sub_detail on ctmsmis.mis_vsl_billing_sub_detail.draftNumber=ctmsmis.mis_vsl_billing_detail.draftNumber 
								where ctmsmis.mis_vsl_billing_detail.draftNumber='$draftNumber' and bill_type=101 order by draftNumber,description";
								
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
					//echo 		$bill_sql;		
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";			
			
				}
				else
				{
					$bill_sql="select invoiceDesc,draftNumber,vesselName,ibVoyageNbr,captain,ATD,ATA,customerName,payeecustomerkey,agent_address,grossRevenueTons,
								exchangeRate,created,flagcountry,cargo,ffd,DATE_FORMAT(onboundpiloton,'%H:%i')as onboundpiloton,DATE_FORMAT(onboundpilotoff,'%H:%i')as  onboundpilotoff,
								DATE_FORMAT(inboundpiloton,'%H:%i') as inboundpiloton,DATE_FORMAT(inboundpilotoff,'%H:%i') as inboundpilotoff,description,glcode,rateBilled,quantityUnit,
								if(description like 'Tug%',sum(quantityBilled),quantityBilled) as quantityBilled,if(description='PILOTAGE FEE',sum(move),move) as move,sum(totusd) as totusd,
								sum(bdChraged) as bdChraged,if((description='BERTHING' or description='SHIFT VESSEL BERTH'),((totusd*15)/100),0) as vatusd, 
								(select vatusd*exchangeRate) as bdVat,status,creator from (
								select bill_name as invoiceDesc,if(cnt_code='BD',concat('PL/',mis_vsl_billing_detail.draftNumber,'-',substring(billing_date,4,1)),
								concat('PF/',mis_vsl_billing_detail.draftNumber,'-',substring(billing_date,4,1))) as draftNumber,vsl_name as vesselName,
								rotation as ibVoyageNbr,master_name as captain,date(atd) as ATD,date(ata) as ATA,agent_name as customerName,
								concat(agent_code,'(',ifnull(agent_alias_id,''),')') as payeecustomerkey,agent_address,grt as grossRevenueTons,exchangeRate as exchangeRate,
								date(billing_date) as created,flag as flagcountry,deck_cargo as cargo,oa_date as ffd,pilot_ob_onboard as onboundpiloton,pilot_ob_offboard as onboundpilotoff,
								pilot_ib_onboard as inboundpiloton,pilot_ib_offboard as inboundpilotoff,description as description,concat(gl_code,'0') as glcode,
								rate as rateBilled,bas as quantityUnit,
								unit_for_pilot as quantityBilled,move,(rate*unit_for_pilot*move) as totusd,
								(rate*unit_for_pilot*move*exchangeRate) as bdChraged,
								'DRAFT' as status,creator
								from ctmsmis.mis_vsl_billing_detail inner join ctmsmis.mis_vsl_billing_sub_detail on ctmsmis.mis_vsl_billing_sub_detail.draftNumber=ctmsmis.mis_vsl_billing_detail.draftNumber 
								where ctmsmis.mis_vsl_billing_detail.draftNumber='$draftNumber'  and bill_type=102) as tbl group by description";
					
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

			//$stylesheet = file_get_contents('resources/styles/test.css'); // external css
			$pdf->useSubstitutions = true; // optional - just as an example
			$pdf->SetWatermarkText('CPA CTMS');		
			$pdf->showWatermarkText = true;
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
			
			$this->updateBillFinalStatus(); // Update Final STATUS , if no of days greater than 7
			
			//return;
			
			$sql_row_num="SELECT count(id) as rtnValue FROM  ctmsmis.mis_billing  INNER JOIN ctmsmis.billingreport
							ON ctmsmis.billingreport.id = ctmsmis.mis_billing.bill_type ";
			$config["total_rows"] = $this->bm->dataReturn($sql_row_num);
			//$r = $this->bm->dataReturn($sql_row_num);
			//echo $r;
			$segment_three = $this->uri->segment(3);
			
			$config = array();
			$config["base_url"] = site_url("bill/containerBillList/$segment_three");
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
			$sql_bill_list="SELECT imp_rot,exp_rot,bill_type,mlo_code,draft_id,IFNULL(created_user,'') AS created_user, draft_final_status,pdf_draft_view_name,pdf_detail_view_name, DATE(billing_date) AS billing_date, billingreport.billtype,
			IFNULL(ctmsmis.billingdisputecont.disputeDetails,'') AS disputeDetails
			FROM ctmsmis.mis_billing 
			INNER JOIN ctmsmis.billingreport ON ctmsmis.billingreport.id = ctmsmis.mis_billing.bill_type
			LEFT JOIN ctmsmis.billingdisputecont ON ctmsmis.mis_billing.draft_id= ctmsmis.billingdisputecont.invoicerefno			
			ORDER BY mis_billing.draft_id DESC limit $start,$limit";
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
			
			$sql_bill_list="SELECT imp_rot,exp_rot,bill_type,mlo_code,draft_id,IFNULL(created_user,'') AS created_user, draft_final_status,pdf_draft_view_name,pdf_detail_view_name,DATE(billing_date) AS billing_date, billingreport.billtype,
			IFNULL(ctmsmis.billingdisputecont.disputeDetails,'') AS disputeDetails
			FROM ctmsmis.mis_billing 
			LEFT JOIN ctmsmis.billingdisputecont ON ctmsmis.mis_billing.draft_id= ctmsmis.billingdisputecont.invoicerefno
			INNER JOIN ctmsmis.billingreport ON ctmsmis.billingreport.id = ctmsmis.mis_billing.bill_type ".$cond." 
				
			ORDER BY mis_billing.draft_id DESC ";
			
			//return ;
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
			
			
			if($draft_view=='pdfPangoanDischargeInvoice')
			{
				$bill_sql="select * from (
						select mlo as payCustomerId,mlo_name as payCustomername,agent_code as customerId,agent as customerName,(SELECT remarks FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS remarks,
						vsl_name as ibCarrierName,rotation as ibVisitId,berth,wpn,IF(UCASE((SELECT remarks FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber'))='RECTIFIED',CONCAT(draftNumber,'/R'),draftNumber) AS draftNumber,
						description as Particulars,size,height,count(description) as qty,sum(amt) as amt,
						IFNULL(sum(vat),0) as vat,(SELECT DATE_FORMAT(billing_date,'%d-%m-%Y')  FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') as billingDate,DATE_FORMAT(argo_visist_dtls_eta,'%d-%m-%Y %h:%i %p') as eta,
						DATE_FORMAT(argo_visist_dtls_etd,'%d-%m-%Y %h:%i %p') as etd,
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
								and size=20
								) as qtytot20,
								(select count(distinct id) from ctmsmis.mis_billing_details dtl
								where draftNumber='$draftNumber'
								and size=40
								) as qtytot40,
								(select count(distinct id) from ctmsmis.mis_billing_details dtl
								where draftNumber='$draftNumber'
								and size=45
								) as qtytot45,
								vatperc,
								(SELECT created_user FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS created_user
								from
								(
								select * from ctmsmis.mis_billing_details 
								where draftNumber='$draftNumber'
								) as tmp
								group by payCustomerId,Particulars,vatperc order by payCustomerId,Particulars asc,WPN desc
								) as tbl";


				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";			
			}
			else if($draft_view=='pdfPangoanLoadingInvoice')
			{
				$bill_sql="select * from (
						select mlo as payCustomerId,mlo_name as payCustomername,agent_code as customerId,agent as customerName,
						vsl_name as ibCarrierName,rotation as ibVisitId,berth,wpn,if(depo_date is null,draftNumber,concat(draftNumber,'R')) as draftNumber,
						if(description like 'Load%',concat(description,' (',wpn,')'),description) as Particulars,size,height,count(description) as qty,sum(amt) as amt,
						if(description like '%1 to 7 days%',if(days>=7,7,days),if(description like '%8 to 20 days%',if(days-7>=13,13,days-7),if(description like 'Storage%',days-20,0))) as days2,
						IFNULL(sum(vat),0) as vat,(select DATE_FORMAT(billing_date,'%d-%m-%Y') from ctmsmis.mis_billing where draft_id='$draftNumber') as billingDate,DATE_FORMAT(billingDate,'%d-%m-%Y %h:%i %p') as eta ,
						DATE_FORMAT(fcy_time_out,'%d-%m-%Y %h:%i %p') as etd,
						if(currency_gkey=2,'$','') as usd,
						'Container Loading Bill (PCT)' as invoiceDesc,
						'DRAFT' as status,
						if(depo_date is null,'','Rectified') as remarks,
						cast((
							CASE
								WHEN
									currency_gkey=2
								THEN
									CAST(Tarif_rate AS DECIMAL(10,4))
								ELSE
									substring(cast(Tarif_rate as DECIMAL(10,4)),1,length(cast(Tarif_rate as DECIMAL(10,4)))-2)
							END)as CHAR) AS rateBilled,
							
							(select exrate 
							from ctmsmis.mis_billing 
							where draft_id='$draftNumber') as exchangeRate,
							
							(select count(distinct id) 
							from ctmsmis.mis_billing_details dtl
							where draftNumber='$draftNumber' and size=20) as qtytot20,
							
							(select count(distinct id) 
							from ctmsmis.mis_billing_details dtl
							where draftNumber='$draftNumber'
							and size=40) as qtytot40,
							
							(select count(distinct id) 
							from ctmsmis.mis_billing_details dtl
							where draftNumber='$draftNumber' and size=45) as qtytot45,vatperc,
							
							(SELECT created_user FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS created_user
							from
							(select *,if(datediff(fcy_time_out,ifnull(depo_date,DATE_ADD(cl_date,INTERVAL 4 DAY)))+1<1,'0',datediff(fcy_time_out,ifnull(depo_date,DATE_ADD(cl_date,INTERVAL 4 DAY)))+1) as days from ctmsmis.mis_billing_details 
							where draftNumber='$draftNumber') as tmp
							group by payCustomerId,Particulars,height,days2,vatperc order by payCustomerId,Particulars asc,WPN desc
						) as tbl";
										
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";			
			}
			else if($draft_view=='pdfReeferInvoice')
			{
				// $bill_sql="select 'Reefer Charges Bill' as invoiceDesc,draftNumber as draftNumber,mlo as payCustomerId,mlo_name as payCustomername,agent_code as customerId,agent as customerName,CAST((select max(exchangeRate) from ctmsmis.mis_billing_details dtl where draftNumber='$draftNumber') AS DECIMAL(10,4)) AS exchangeRate,description as Particulars,height,size,
				// if(currency_gkey=2,'$','') as usd,
				// cast((
				// CASE
					// WHEN
						// currency_gkey=2
					// THEN
						// CAST(Tarif_rate AS DECIMAL(10,4))
					// ELSE
						// substring(cast(Tarif_rate as DECIMAL(10,4)),1,length(cast(Tarif_rate as DECIMAL(10,4)))-2)
					// END
				// )as CHAR) AS rateBilled,count(id) as qtyUnit,sum(storage_days)as qty,sum(amt) as amt,sum(vat) as vat,(sum(amt)+vat) as netTotal,'' as comments,'DRAFT' as status,rfr_disconnect as eventTo,
				// (select count(distinct id) from ctmsmis.mis_billing_details dtl
				// where draftNumber='$draftNumber'
				// and size=20 and dtl.mlo=tbl.mlo
				// and fcy_time_in is not null
				// ) as qtytot20,
				// (select count(distinct id) from ctmsmis. mis_billing_details dtl
				// where draftNumber='$draftNumber'
				// and size=40 and dtl.mlo=tbl.mlo
				// and fcy_time_in is not null
				// ) as qtytot40,
				// (select count(distinct id) from ctmsmis.mis_billing_details dtl
				// where draftNumber='$draftNumber'
				// and size=45 and dtl.mlo=tbl.mlo
				// and fcy_time_in is not null
				// ) as qtytot45
				// from
				// (select * from ctmsmis.mis_billing_details where draftNumber='$draftNumber' order by id) as tbl
				// group by description,size";
				
				$bill_sql="SELECT 'Reefer Charges Bill' AS invoiceDesc,draftNumber AS draftNumber,mlo AS payCustomerId,mlo_name AS payCustomername,agent_code AS customerId,agent AS customerName,CAST((SELECT MAX(exchangeRate) FROM ctmsmis.mis_billing_details dtl WHERE draftNumber='$draftNumber') AS DECIMAL(10,4)) AS exchangeRate,description AS Particulars,height,size,
				IF(currency_gkey=2,'$','') AS usd,
				CAST((
					CASE
						WHEN currency_gkey=2
						THEN CAST(Tarif_rate AS DECIMAL(10,4))
						ELSE SUBSTRING(CAST(Tarif_rate AS DECIMAL(10,4)),1,LENGTH(CAST(Tarif_rate AS DECIMAL(10,4)))-2)
					END)AS CHAR) AS rateBilled,COUNT(id) AS qtyUnit,SUM(storage_days)AS qty,ROUND(SUM(amt),2) AS amt,ROUND(SUM(vat),2) AS vat,(SUM(amt)+vat) AS netTotal,'' AS comments,'DRAFT' AS STATUS,DATE(rfr_disconnect) AS eventTo,
				(SELECT DATE(billing_date) FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS billing_date,
				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=20 AND dtl.mlo=tbl.mlo
				AND fcy_time_in IS NOT NULL
				) AS qtytot20,
				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=40 AND dtl.mlo=tbl.mlo
				AND fcy_time_in IS NOT NULL
				) AS qtytot40,

				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=45 AND dtl.mlo=tbl.mlo
				AND fcy_time_in IS NOT NULL
				) AS qtytot45
				FROM
				(
				SELECT * FROM ctmsmis.mis_billing_details WHERE draftNumber='$draftNumber' ORDER BY id

				)AS tbl GROUP BY description,size";
					
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";						
			}
			else if($draft_view=='pdfLoadingInvoice')
			{	
				$bill_sql="SELECT 'Container Loading Bill' AS invoiceDesc,draftNumber AS draftNumber,mlo AS payCustomerId,mlo_name AS payCustomerName,agent_code AS conCustomerId,agent AS conCustomerName,CAST((SELECT MAX(exchangeRate) FROM ctmsmis.mis_billing_details dtl WHERE draftNumber='$draftNumber') AS DECIMAL(10,4)) AS exchangeRate,(SELECT DATE(billing_date) FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS created,rotation AS vslId,vsl_name AS obCarrierName,ata AS eta, atd AS etd,berth AS berth,CONCAT(description,' (',wpn,')') AS Particulars,height,size,
				IF(currency_gkey=2,'$','') AS usd,
				CAST((
					CASE
						WHEN currency_gkey=2
						THEN CAST(Tarif_rate AS DECIMAL(10,4))
						ELSE SUBSTRING(CAST(Tarif_rate AS DECIMAL(10,4)),1,LENGTH(CAST(Tarif_rate AS DECIMAL(10,4)))-2)
					END
				)AS CHAR) AS rateBilled,COUNT(description) AS quantityBilled,SUM(amt) AS totalCharged,SUM(vat) AS totalvatamount,(SUM(amt)+SUM(vat)) AS netTotal,'' AS comments,'DRAFT' AS STATUS,
				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=20 AND dtl.mlo=tbl.mlo
				AND fcy_time_in IS NOT NULL
				) AS qtytot20,
				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=40 AND dtl.mlo=tbl.mlo
				AND fcy_time_in IS NOT NULL
				) AS qtytot40,

				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=45 AND dtl.mlo=tbl.mlo
				AND fcy_time_in IS NOT NULL
				) AS qtytot45,
				(SELECT created_user FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS created_user,vatperc
				FROM
				(
				SELECT * FROM ctmsmis.mis_billing_details WHERE draftNumber='$draftNumber' ORDER BY id
				)AS tbl GROUP BY Particulars,vatperc

				UNION ALL

				SELECT 'Container Loading Bill' AS invoiceDesc,draftNumber AS draftNumber,mlo AS payCustomerId,mlo_name AS payCustomerName,agent_code AS conCustomerId,agent AS conCustomerName,CAST((SELECT MAX(exchangeRate) FROM ctmsmis.mis_billing_details dtl WHERE draftNumber='$draftNumber') AS DECIMAL(10,4)) AS exchangeRate,(SELECT DATE(billing_date) FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS created,rotation AS vslId,vsl_name AS obCarrierName,ata AS eta, atd AS etd,berth AS berth,'LABOUR FUND' AS Particulars,NULL AS height,NULL AS size,
				'' AS usd,
				4.5 AS rateBilled,CONCAT(SUM(tues),' Teus') AS quantityBilled,SUM(tues)*4.5 AS totalCharged,0 AS totalvatamount,(SELECT SUM(tues)*4.5+0) AS netTotal,'' AS comments,'DRAFT' AS STATUS,
				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=20 AND dtl.mlo=tbl.mlo
				AND fcy_time_in IS NOT NULL
				) AS qtytot20,
				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=40 AND dtl.mlo=tbl.mlo
				AND fcy_time_in IS NOT NULL
				) AS qtytot40,

				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=45 AND dtl.mlo=tbl.mlo
				AND fcy_time_in IS NOT NULL
				) AS qtytot45,
				(SELECT created_user FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS created_user,vatperc
				FROM
				(
				SELECT * FROM ctmsmis.mis_billing_details WHERE draftNumber='$draftNumber' AND description LIKE 'Load%' ORDER BY id
				)AS tbl";
					
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";						
			}
			else if($draft_view=='pdfDischargeInvoice')
			{
				
				$bill_sql="select * from (
				select mlo as payCustomerId,mlo_name as payCustomername,agent_code as customerId,agent as customerName,
				vsl_name as ibCarrierName,rotation as ibVisitId,berth,wpn,draftNumber,
				concat(description,'(',wpn,')') as Particulars,size,height,count(description) as qty,sum(amt) as amt,
				IFNULL(sum(vat),0) as vat,(select billing_date from ctmsmis.mis_billing where draft_id='$draftNumber') as billingDate,argo_visist_dtls_eta as eta ,argo_visist_dtls_etd as etd,
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
				) as qtytot45
				,
				vatperc,
				(SELECT created_user FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS created_user
				from
				(
				select * from ctmsmis.mis_billing_details 
				where draftNumber='$draftNumber'
				) as tmp
				group by payCustomerId,Particulars,vatperc order by payCustomerId,Particulars asc,WPN desc
				) as tbl

				union all

				select mlo as payCustomerId,mlo_name as payCustomername,agent_code as customerId,agent as customerName,
				vsl_name as ibCarrierName,rotation as ibVisitId,berth,wpn,draftNumber,
				'LABOUR FUND' as Particulars,size,height,concat(sum(tues),'(Teus)') as qty,sum(tues)*4.5 as amt,
				0 as vat,(select billing_date from ctmsmis.mis_billing where draft_id='$draftNumber') as billingDate,argo_visist_dtls_eta as eta ,argo_visist_dtls_etd as etd,
				'' as usd,
				'Container Discharging Bill' as invoiceDesc,
				'DRAFT' as status,
				'' as comments,
				4.5 AS rateBilled,
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
				) as qtytot45
				,
				0 AS vatperc,
				(SELECT created_user FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS created_user
				from
				(
				select * from ctmsmis.mis_billing_details 
				where draftNumber='$draftNumber' and description like 'Discharging%'
				) as tmp
				group by payCustomerId,Particulars";
				/*$bill_sql="select * from (
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
				group by payCustomerId,Particulars";*/
					
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";						
			}
			else if($draft_view=='pdfDraftICDInvoice')
			{
				$bill_sql="select qty,amt,vat,status,draftNumber,ibCarrierName,customerId,customerName,
				payCustomerId,payCustomername,Particulars,
				if(exchangeRate=1,ifnull((SELECT rate FROM billing.bil_currency_exchange_rates WHERE DATE(effective_date)=DATE(final.final.currency_date)),(SELECT rate FROM billing.bil_currency_exchange_rates ORDER BY effective_date DESC LIMIT 1)),exchangeRate) as exchangeRate,
				rateBilled,chargeEventTypeId,
				date(billingDate) as billingDate,invoiceDesc,ibVisitId,height,berth,atd,ata,size,qtytot20,qtytot40,qtytot45,
				usd,eventPerformDate,comments,discharge_done,storage_days
				from
				(
				SELECT count(description) AS qty ,sum(amt) AS amt,IFNULL(sum(vat),0) AS vat,
				'DRAFT' as status,draftNumber,vsl_name as ibCarrierName,mlo as customerId,
				mlo_name as customerName,agent_code as payCustomerId,agent as payCustomername,
				description as Particulars,
				CAST((select max(exchangeRate) from ctmsmis.mis_billing_details dtl where draftNumber='$draftNumber') AS DECIMAL(10,4)) AS exchangeRate,

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

				id as chargeEventTypeId,billingDate,'ICD Bill' as invoiceDesc,
				rotation as ibVisitId,height,berth,atd,ata,size,ata as currency_date,


				(select count(distinct id) from ctmsmis.mis_billing_details dtl
				where draftNumber='$draftNumber'
				and size=20 and dtl.mlo=details.mlo
				and fcy_time_in is not null
				) as qtytot20,
				(select count(distinct id) from ctmsmis.mis_billing_details dtl
				where draftNumber='$draftNumber'
				and size=40 and dtl.mlo=details.mlo
				and fcy_time_in is not null
				) as qtytot40,

				(select count(distinct id) from ctmsmis.mis_billing_details dtl
				where draftNumber='$draftNumber'
				and size=45 and dtl.mlo=details.mlo
				and fcy_time_in is not null
				) as qtytot45,


				if(currency_gkey=2,'$','') as usd,
				max(fcy_time_out) AS eventPerformDate,

				'' AS comments,
				cl_date as discharge_done,if(storage_days = 0 ,NULL,storage_days) AS storage_days

				FROM
				(
				select * from ctmsmis.mis_billing_details where draftNumber='$draftNumber'
				)

				AS details group by draftNumber,Particulars,height order by payCustomerId,Particulars,height asc
				)as final";
				
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";
			}
			else if($draft_view=='pdfPangoanStatusChangeInvoice')
			{
				$bill_sql="SELECT * FROM (
				SELECT mlo AS payCustomerId,mlo_name AS payCustomername,agent_code AS customerId,agent AS customerName,
				vsl_name AS ibCarrierName,rotation AS ibVisitId,berth,wpn,IF(UCASE((SELECT remarks FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber'))=UCASE('rectified'),CONCAT(draftNumber,'/R'),draftNumber) AS draftNumber,
				IF(description LIKE 'Load%',CONCAT(description,' (',wpn,')'),description) AS Particulars,size,ROUND(height,1) AS height,COUNT(description) AS qty,ROUND(SUM(amt),2) AS amt,
				IF(depo_date IS NOT NULL,IF(description LIKE 'Storage%',days,0),IF(description LIKE '%1 to 7 days%',IF(days>=7,7,days),IF(description LIKE '%8 to 20 days%',IF(days-7>=13,13,days-7),IF(description LIKE 'Storage%',days-20,0)))) AS days2,
				ROUND(IFNULL(SUM(vat),0),2) AS vat,(SELECT DATE(billing_date) FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS billingDate,billingDate AS eta ,fcy_time_out AS etd,
				IF(currency_gkey=2,'$','') AS usd,
				'Status Change Bill (CPA to PCT)' AS invoiceDesc,
				'DRAFT' AS STATUS,
				(SELECT remarks FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS remarks,
				CAST((
					CASE
						WHEN
							currency_gkey=2
						THEN
							CAST(Tarif_rate AS DECIMAL(10,4))
						ELSE
							SUBSTRING(CAST(Tarif_rate AS DECIMAL(10,4)),1,LENGTH(CAST(Tarif_rate AS DECIMAL(10,4)))-2)
					END)AS CHAR) AS rateBilled,
				(SELECT exrate FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS exchangeRate,
				(SELECT COUNT(DISTINCT id) 
				FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber' AND size=20) AS qtytot20,
				(SELECT COUNT(DISTINCT id) 
				FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber' AND size=40) AS qtytot40,
				(SELECT COUNT(DISTINCT id) 
				FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber' AND size=45) AS qtytot45,
				vatperc,
				(SELECT created_user 
				FROM ctmsmis.mis_billing 
				WHERE draft_id='$draftNumber') AS created_user
				FROM
				(
				SELECT *,IF(DATEDIFF(fcy_time_out,IFNULL(depo_date,DATE_ADD(cl_date,INTERVAL 4 DAY)))+1<1,'0',DATEDIFF(fcy_time_out,IFNULL(depo_date,DATE_ADD(cl_date,INTERVAL 4 DAY)))+1) AS days 
				FROM ctmsmis.mis_billing_details 
				WHERE draftNumber='$draftNumber' AND active=1) AS tmp
				GROUP BY payCustomerId,Particulars,height,days2,vatperc 
				ORDER BY payCustomerId,Particulars ASC,WPN DESC) AS tbl";
				
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";
			}
			else if($draft_view=='pdfStatucChangeCPAToICDInvoice')
			{
				$bill_sql="SELECT 'STATUS CHANGE INVOICE (CPA TO ICD)' AS invoiceDesc,'DRAFT' AS STATUS,draftNumber AS draftNumber,mlo AS payCustomerId,mlo_name AS payCustomername,agent_code AS customerId,agent AS customerName,CAST((SELECT MAX(exchangeRate) FROM ctmsmis.mis_billing_details dtl WHERE draftNumber='$draftNumber') AS DECIMAL(10,4)) AS exchangeRate,DATE(billingDate) AS billingDate,rotation AS ibVisitId,vsl_name AS ibCarrierName,ata AS eta,atd AS etd,berth AS berth,cl_date AS discharge_done,DATE(fcy_time_out) AS icd_yardin_date,description AS Particulars,id AS unitId,size AS size,ROUND(height,1) AS height,COUNT(DISTINCT id) AS qtyUnit,IF(SUM(storage_days)=0,NULL,SUM(storage_days)) AS qty,(SELECT remarks FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS comments,
				IF(currency_gkey=2,'$','') AS usd,
				CAST((
					CASE
						WHEN
							currency_gkey=2
						THEN
							CAST(Tarif_rate AS DECIMAL(10,4))
						ELSE
							SUBSTRING(CAST(Tarif_rate AS DECIMAL(10,4)),1,LENGTH(CAST(Tarif_rate AS DECIMAL(10,4)))-2)
					END
				)AS CHAR) AS rateBilled,
				SUM(amt) AS amt,SUM(vat) AS vat,
				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=20 AND dtl.mlo=tbl.mlo
				AND fcy_time_in IS NOT NULL
				) AS qtytot20,
				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=40 AND dtl.mlo=tbl.mlo
				AND fcy_time_in IS NOT NULL
				) AS qtytot40,

				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=45 AND dtl.mlo=tbl.mlo
				AND fcy_time_in IS NOT NULL
				) AS qtytot45
				FROM(
				SELECT * FROM ctmsmis.mis_billing_details WHERE draftNumber='$draftNumber' 
				) AS tbl GROUP BY Particulars ORDER BY usd DESC,Particulars";
				
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";
			}
			else if($draft_view=='pdfStatucChangeFCLToLCLInvoice')
			{
				$bill_sql="SELECT 'STATUS CHANGE INVOICE (FCL TO LCL)' AS invoiceDesc,'DRAFT' AS STATUS,draftNumber AS draftNumber,mlo AS payCustomerId,mlo_name AS payCustomername,agent_code AS customerId,agent AS customerName,CAST((SELECT MAX(exchangeRate) FROM ctmsmis.mis_billing_details dtl WHERE draftNumber='$draftNumber') AS DECIMAL(10,4)) AS exchangeRate,DATE(billingDate) AS billingDate,rotation AS ibVisitId,vsl_name AS ibCarrierName,ata AS eta,atd AS etd,berth AS berth,cl_date AS discharge_done,DATE(fcy_time_out) AS unstuffing_date,description AS Particulars,id AS unitId,size AS size,ROUND(height,1) AS height,COUNT(DISTINCT id) AS qtyUnit,IF(SUM(storage_days)=0,NULL,SUM(storage_days)) AS qty,(SELECT remarks FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS comments,
				IF(currency_gkey=2,'$','') AS usd,
				CAST((
					CASE
						WHEN
							currency_gkey=2
						THEN
							CAST(Tarif_rate AS DECIMAL(10,4))
						ELSE
							SUBSTRING(CAST(Tarif_rate AS DECIMAL(10,4)),1,LENGTH(CAST(Tarif_rate AS DECIMAL(10,4)))-2)
					END
				) AS CHAR) AS rateBilled,SUM(amt) AS amt,SUM(vat) AS vat,
				(SELECT COUNT(DISTINCT id) 
				FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=20 AND dtl.mlo=tbl.mlo
				AND fcy_time_in IS NOT NULL
				) AS qtytot20,
				(SELECT COUNT(DISTINCT id) 
				FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=40 AND dtl.mlo=tbl.mlo
				AND fcy_time_in IS NOT NULL
				) AS qtytot40,
				(SELECT COUNT(DISTINCT id) 
				FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=45 AND dtl.mlo=tbl.mlo
				AND fcy_time_in IS NOT NULL
				) AS qtytot45
				FROM(
				SELECT * FROM ctmsmis.mis_billing_details WHERE draftNumber='$draftNumber' 
				) AS tbl GROUP BY Particulars";
				
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";
			}
			else if($draft_view=='pdfStatucChangeLCLToFCLInvoice')
			{
				$bill_sql="SELECT 'STATUS CHANGE INVOICE (LCL TO FCL)' AS invoiceDesc,'DRAFT' AS STATUS,draftNumber AS draftNumber,mlo AS payCustomerId,mlo_name AS payCustomername,agent_code AS customerId,agent AS customerName,CAST((SELECT MAX(exchangeRate) FROM ctmsmis.mis_billing_details dtl WHERE draftNumber='$draftNumber') AS DECIMAL(10,4)) AS exchangeRate,DATE(billingDate) AS billingDate,rotation AS ibVisitId,vsl_name AS ibCarrierName,ata AS eta,atd AS etd,berth AS berth,cl_date AS discharge_done,DATE(fcy_time_out) AS fcl_declaration_date,description AS Particulars,id AS unitId,size AS size,height AS height,COUNT(DISTINCT id) AS qtyUnit,IF(SUM(storage_days)=0,NULL,SUM(storage_days)) AS qty,(SELECT remarks FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS comments,
				IF(currency_gkey=2,'$','') AS usd,
				CAST((
					CASE
						WHEN
							currency_gkey=2
						THEN
							CAST(Tarif_rate AS DECIMAL(10,4))
						ELSE
							SUBSTRING(CAST(Tarif_rate AS DECIMAL(10,4)),1,LENGTH(CAST(Tarif_rate AS DECIMAL(10,4)))-2)
					END
				) AS CHAR) AS rateBilled,SUM(amt) AS amt,SUM(vat) AS vat,
				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=20 AND dtl.mlo=tbl.mlo
				AND fcy_time_in IS NOT NULL
				) AS qtytot20,
				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=40 AND dtl.mlo=tbl.mlo
				AND fcy_time_in IS NOT NULL
				) AS qtytot40,
				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=45 AND dtl.mlo=tbl.mlo
				AND fcy_time_in IS NOT NULL
				) AS qtytot45
				FROM(
				SELECT * FROM ctmsmis.mis_billing_details WHERE draftNumber='$draftNumber' 
				) AS tbl GROUP BY Particulars";
				
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";
			}
			else if($draft_view=='pdfPangoanStatusChangePCTToCPAInvoice')
			{
				$bill_sql="SELECT * FROM (
				SELECT mlo AS payCustomerId,mlo_name AS payCustomername,agent_code AS customerId,agent AS customerName,
				vsl_name AS ibCarrierName,rotation AS ibVisitId,berth,wpn,IF(UCASE((SELECT remarks FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber'))=UCASE('rectified'),CONCAT(draftNumber,'/R'),draftNumber) AS draftNumber,
				IF(description LIKE 'Load%',CONCAT(description,' (',wpn,')'),description) AS Particulars,size,ROUND(height,1) AS height,COUNT(description) AS qty,ROUND(SUM(amt),2) AS amt,
				IF(depo_date IS NOT NULL,IF(description LIKE 'Storage%',days,0),IF(description LIKE '%1 to 7 days%',IF(days>=7,7,days),IF(description LIKE '%8 to 20 days%',IF(days-7>=13,13,days-7),IF(description LIKE 'Storage%',days-20,0)))) AS days2,
				ROUND(IFNULL(SUM(vat),0),2) AS vat,(SELECT DATE(billing_date) FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS billingDate,billingDate AS eta ,pre_imp_ata AS etd,
				IF(currency_gkey=2,'$','') AS usd,
				'Status Change Bill (PCT to CPA)' AS invoiceDesc,
				'DRAFT' AS STATUS,
				(SELECT remarks FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS remarks,
				CAST((
					CASE
						WHEN
							currency_gkey=2
						THEN
							CAST(Tarif_rate AS DECIMAL(10,4))
						ELSE
							SUBSTRING(CAST(Tarif_rate AS DECIMAL(10,4)),1,LENGTH(CAST(Tarif_rate AS DECIMAL(10,4)))-2)
					END
				)AS CHAR) AS rateBilled,
				(SELECT exrate FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS exchangeRate,
				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=20
				) AS qtytot20,
				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=40
				) AS qtytot40,

				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=45
				) AS qtytot45
				,
				vatperc,
				(SELECT created_user FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS created_user
				FROM
				(
				SELECT *,IF(DATEDIFF(cl_date,IFNULL(fcy_time_in,DATE_ADD(cl_date,INTERVAL 4 DAY)))+1<1,'0',DATEDIFF(cl_date,IFNULL(fcy_time_in,DATE_ADD(cl_date,INTERVAL 4 DAY)))+1) AS days FROM ctmsmis.mis_billing_details 
				WHERE draftNumber='$draftNumber' AND active=1
				) AS tmp
				GROUP BY payCustomerId,Particulars,height,days2,vatperc ORDER BY payCustomerId,Particulars ASC,WPN DESC
				) AS tbl";
				
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";
			}
			//SOURAV
			else if($draft_view=='pdfOffhireInvoice')
			{
				$bill_sql="select 'OFFHIRE CHARGES ON CONTAINER' as type,if(sum(storage_days)=0,NULL,sum(storage_days)) as qty,sum(amt) AS amt,IFNULL(sum(vat),0) AS vat,
				'DRAFT' as status,draftNumber,vsl_name as ibCarrierName,mlo as customerId,
				mlo_name as customerName,agent_code as payCustomerId,agent as payCustomername,
				description as Particulars,

				/*cast(rateBilled as DECIMAL(10,4)) as rateBilled,*/

				CAST(IFNULL((SELECT rate FROM billing.bil_currency_exchange_rates WHERE DATE(effective_date)=date(min(fcy_time_out))),    
								(SELECT rate FROM billing.bil_currency_exchange_rates ORDER BY effective_date DESC LIMIT 1)) AS DECIMAL(10,4)) AS exchangeRate,

				billingDate,'Offhire Charges Bill' as invoiceDesc,
				height,size,

				count(description) as qtyUnit,

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
				)as CHAR) AS rateBilled,

				date(min(fcy_time_out)) as yardout,
				'' as comments,
				(SELECT created_user FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS created_user
				from 
				(

				select gkey,draftNumber,fcy_time_in,fcy_time_out,mlo,mlo_name,agent_code,agent,
				storage_days,
				invoice_type,vsl_name,rotation,berth,billingDate,id,description,size,height,freight_kind,
				vatperc,Tarif_rate,exchangeRate,currency_gkey,amt,vat
				 from ctmsmis.mis_billing_details where draftNumber='$draftNumber' order by id

				)as tbl group by Particulars";
				
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";
			}
			else if($draft_view=='pdfDraftOffdockToMuktarpurStatusChangeInvoice')
			{
				
				$bill_sql="select 'STATUS CHANGE INVOICE (OFFDOCK TO MUKTARPUR)' as invoiceDesc,'DRAFT' as status,draftNumber as draftNumber,
				mlo as payCustomerId,mlo_name as payCustomername,agent_code as customerId,agent as customerName,
				CAST((select max(exchangeRate) from ctmsmis.mis_billing_details dtl where draftNumber='$draftNumber') AS DECIMAL(10,4)) AS exchangeRate,
				(select billing_Date from ctmsmis.mis_billing where draft_id='$draftNumber') as billingDate,
				rotation as ibVisitId,vsl_name as ibCarrierName,argo_visist_dtls_eta as eta,argo_visist_dtls_etd as etd,
				berth as berth,cl_date as discharge_done,fcy_time_out as icd_yardin_date,description as Particulars,id as unitId,size as size,
				height as height,count(distinct id) as qtyUnit,if(sum(storage_days)=0,null,sum(storage_days)) as qty,
				(select remarks from ctmsmis.mis_billing where draft_id='$draftNumber') as comments,
				(SELECT created_user FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS created_user,
				if(currency_gkey=2,'$','') as usd,billingDate AS ata,pre_imp_ata AS atd,
				cast((
				 CASE
				  WHEN
				   currency_gkey=2
				  THEN
				   CAST(Tarif_rate AS DECIMAL(10,4))
				  ELSE
				   substring(cast(Tarif_rate as DECIMAL(10,4)),1,length(cast(Tarif_rate as DECIMAL(10,4)))-2)

				  END
				)as CHAR) AS rateBilled,sum(amt) as amt,sum(vat) as vat,
				(select count(distinct id) from ctmsmis.mis_billing_details dtl
				where draftNumber=  '$draftNumber'
				and size=20 and dtl.mlo=tbl.mlo
				and fcy_time_in is not null
				) as qtytot20,
				(select count(distinct id) from ctmsmis.mis_billing_details dtl
				where draftNumber=  '$draftNumber'
				and size=40 and dtl.mlo=tbl.mlo
				and fcy_time_in is not null
				) as qtytot40,

				(select count(distinct id) from ctmsmis.mis_billing_details dtl
				where draftNumber=  '$draftNumber'
				and size=45 and dtl.mlo=tbl.mlo
				and fcy_time_in is not null
				) as qtytot45
				from(
				select * from ctmsmis.mis_billing_details where draftNumber= '$draftNumber' 
				) as tbl group by Particulars order by usd desc,Particulars";
				
				//echo $bill_sql;
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";
			}
			//SOURAV
			else if($draft_view=='pdfDraftMukterpulDischargeInvoice')		//MUKTARPUR CONT DISCHARGE - 07-01-2019	//intakhab
			{
				$bill_sql="SELECT * FROM (
				SELECT mlo AS payCustomerId,mlo_name AS payCustomername,agent_code AS customerId,agent AS customerName,
				vsl_name AS ibCarrierName,rotation AS ibVisitId,berth,wpn,IF(UCASE((SELECT remarks FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber'))='RECTIFIED',CONCAT(draftNumber,'/R'),draftNumber) AS draftNumber,
				CONCAT(description,'(',wpn,')') AS Particulars,size,height,COUNT(description) AS qty,ROUND(SUM(amt),2) AS amt,
				IFNULL(ROUND(SUM(vat),2),0) AS vat,(SELECT DATE(billing_date) FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS billingDate,argo_visist_dtls_eta AS eta ,argo_visist_dtls_etd AS etd,
				IF(currency_gkey=2,'$','') AS usd,
				'Container Discharging Bill (Muktarpur)' AS invoiceDesc,
				'DRAFT' AS STATUS,
				(SELECT remarks FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS comments,
				CAST((
					CASE
						WHEN
							currency_gkey=2
						THEN
							CAST(Tarif_rate AS DECIMAL(10,4))
						ELSE
							SUBSTRING(CAST(Tarif_rate AS DECIMAL(10,4)),1,LENGTH(CAST(Tarif_rate AS DECIMAL(10,4)))-2)
					END
				)AS CHAR) AS rateBilled,
				exchangeRate,
				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=20
				) AS qtytot20,
				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=40
				) AS qtytot40,

				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=45
				) AS qtytot45
				,
				vatperc,
				(SELECT created_user FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS created_user
				FROM
				(
				SELECT * FROM ctmsmis.mis_billing_details 
				WHERE draftNumber='$draftNumber'
				) AS tmp
				GROUP BY payCustomerId,Particulars,vatperc,rateBilled ORDER BY payCustomerId,Particulars ASC,WPN DESC
				) AS tbl";
				//return;
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";
			}
			else if($draft_view=='pdfMukhterpoleLoadingInvoice')		//MUKTARPUR CONT LOAD - 07-01-2019	//intakhab
			{
				$bill_sql="SELECT * FROM (
				SELECT mlo AS payCustomerId,mlo_name AS payCustomername,agent_code AS customerId,agent AS customerName,
				vsl_name AS ibCarrierName,rotation AS ibVisitId,berth,wpn,IF(UCASE((SELECT remarks FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber'))=UCASE('rectified'),CONCAT(draftNumber,'/R'),draftNumber) AS draftNumber,
				IF(description LIKE 'Load%',CONCAT(description,' (',wpn,')'),description) AS Particulars,size,height,COUNT(description) AS qty,ROUND(SUM(amt),2) AS amt,
				IF(depo_date IS NOT NULL,IF(description LIKE 'Storage%',days,0),IF(description LIKE '%1 to 7 days%',IF(days>=7,7,days),IF(description LIKE '%8 to 20 days%',IF(days-7>=13,13,days-7),IF(description LIKE 'Storage%',days-20,0)))) AS days2,
				ROUND(IFNULL(SUM(vat),0),2) AS vat,(SELECT DATE(billing_date) FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS billingDate,billingDate AS eta ,fcy_time_out AS etd,
				IF(currency_gkey=2,'$','') AS usd,
				'LOADING BILL (Muktarpur)' AS invoiceDesc,
				'DRAFT' AS STATUS,
				(SELECT remarks FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS remarks,
				CAST((
					CASE
						WHEN currency_gkey=2
						THEN CAST(Tarif_rate AS DECIMAL(10,4))
				        ELSE SUBSTRING(CAST(Tarif_rate AS DECIMAL(10,4)),1,LENGTH(CAST(Tarif_rate AS DECIMAL(10,4)))-2)
					END)AS CHAR) AS rateBilled,
				(SELECT exrate FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS exchangeRate,
				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=20
				) AS qtytot20,
				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=40
				) AS qtytot40,

				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=45
				) AS qtytot45
				,
				vatperc,
				(SELECT created_user FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS created_user
				FROM
				(
				SELECT *,IF(DATEDIFF(fcy_time_out,IFNULL(depo_date,DATE_ADD(cl_date,INTERVAL 4 DAY)))+1<1,'0',DATEDIFF(fcy_time_out,IFNULL(depo_date,DATE_ADD(cl_date,INTERVAL 4 DAY)))+1) AS days FROM ctmsmis.mis_billing_details 
				WHERE draftNumber='$draftNumber' AND active=1
				) AS tmp
				GROUP BY payCustomerId,Particulars,height,days2,vatperc ORDER BY payCustomerId,Particulars ASC,WPN DESC
				) AS tbl";
				
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";
			}
			else if($draft_view=='pdfExportStorageInvoice')
			{
				$bill_sql="SELECT 'EXPORT STORAGE INVOICE' AS TYPE,draftNumber,'DRAFT' AS STATUS,
				'EXPORT STORAGE INVOICE' AS invoiceDesc, DATE_FORMAT(billingDate,'%d-%m-%Y') as billingDate,agent_code AS conCustomerId,
				agent AS conCustomerName,mlo AS payCustomerId,
				mlo_name AS payCustomerName,
				CAST((SELECT MAX(exchangeRate) FROM ctmsmis.mis_billing_details dtl WHERE draftNumber='$draftNumber') AS DECIMAL(10,4)) AS exchangeRate,
				COUNT(id) AS quantityUnit,SUM(amt) AS totalCharged,
				description,

				CAST((
					CASE 
						WHEN 
							currency_gkey=2 
						THEN 
							CAST(Tarif_rate AS DECIMAL(10,4)) 
						ELSE 
							SUBSTRING(CAST(Tarif_rate AS DECIMAL(10,4)),1,LENGTH(CAST(Tarif_rate AS DECIMAL(10,4)))-2)
							
						END 
				)AS CHAR) AS rateBilled,


				SUM(vat) AS totalvatamount,SUM(amt)+SUM(vat) AS netTotal,vsl_name AS obCarrierName,ata AS obCarrierATA,atd AS obCarrierATD,
				height,

				 berth,
				arcar_id AS vslId,size,

				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=20 AND dtl.mlo=tbl.mlo
				AND fcy_time_in IS NOT NULL
				) AS qtytot20,
				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=40 AND dtl.mlo=tbl.mlo
				AND fcy_time_in IS NOT NULL
				) AS qtytot40,

				(SELECT COUNT(DISTINCT id) FROM ctmsmis.mis_billing_details dtl
				WHERE draftNumber='$draftNumber'
				AND size=45 AND dtl.mlo=tbl.mlo
				AND fcy_time_in IS NOT NULL
				) AS qtytot45,


				IF(currency_gkey=2,'$','') AS usd,
				IF(SUM(storage_days)=0,NULL,SUM(storage_days)) AS qty ,
				COUNT(description) AS qtyUnit,'' AS comments

				FROM

				(
					SELECT * FROM ctmsmis.mis_billing_details WHERE ctmsmis.mis_billing_details.draftNumber='$draftNumber'
				)AS tbl GROUP BY description";
								
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";
				//echo $bill_sql;

			}
			//echo $bill_sql;
			//return;
			$bill_rslt=$this->bm->dataSelect($bill_sql);
			//echo $bill_rslt;
			//$summary_bill_detail=$this->bm->dataSelect($summary_bill);	
			//$this->data['summary_bill_detail']=$summary_bill_detail;			

			$print_time=$this->bm->dataSelect($bill_print_time);	
			$this->data['bill_rslt']=$bill_rslt;			
			$this->data['print_time']=$print_time;			
			//$this->load->view('vesselBillPdf',$data);
			if($draft_view=='pdfPangoanDischargeInvoice')
			{
				$html=$this->load->view('container_rptPangoanDischargingDraftInvoice',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
				$pdfFilePath ="containerBill-".time()."-download.pdf";
			}
			else if($draft_view=='pdfPangoanLoadingInvoice')
			{
				$html=$this->load->view('container_rptPangoanLoadingDraftInvoice',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
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
			else if($draft_view=='pdfDraftICDInvoice')
			{
				$html=$this->load->view('icdbill',$this->data, true); 
				$pdfFilePath ="icdbill-".time()."-download.pdf";
			}
			else if($draft_view=='pdfPangoanStatusChangeInvoice')		//CPA to PCT
			{
				$html=$this->load->view('statusChange(CPAtoPCT)',$this->data, true); 
				$pdfFilePath ="statusChange(CPAtoPCT)-".time()."-download.pdf";
			}
			else if($draft_view=='pdfStatucChangeCPAToICDInvoice')
			{
				$html=$this->load->view('statusChange(CPAtoICD)',$this->data, true); 
				$pdfFilePath ="statusChange(CPAtoICD)-".time()."-download.pdf";
			}
			else if($draft_view=='pdfStatucChangeFCLToLCLInvoice')
			{
				$html=$this->load->view('statusChange(FCLtoLCL)',$this->data, true); 
				$pdfFilePath ="statusChange(FCLtoLCL)-".time()."-download.pdf";
			}
			else if($draft_view=='pdfStatucChangeLCLToFCLInvoice')
			{
				$html=$this->load->view('statusChange(LCLtoFCL)',$this->data, true); 
				$pdfFilePath ="statusChange(LCLtoFCL)-".time()."-download.pdf";
			}
			else if($draft_view=='pdfPangoanStatusChangePCTToCPAInvoice')
			{
				$html=$this->load->view('statusChange(PCTtoCPA)',$this->data, true); 
				$pdfFilePath ="statusChange(PCTtoCPA)-".time()."-download.pdf";
			}
			else if($draft_view=='pdfOffhireInvoice')
			{
				$html=$this->load->view('offhireChargesContainerInvoice',$this->data, true); 
				$pdfFilePath ="offhireChargesOnContainer-".time()."-download.pdf";
			}
			else if($draft_view=='pdfDraftOffdockToMuktarpurStatusChangeInvoice')
			{
				$html=$this->load->view('statusChange(OFFDOCK TO MUKTARPUR)Invoice',$this->data, true); 
				$pdfFilePath ="statusChange(OffdockToMuktarpur)-".time()."-download.pdf";
			}
			else if($draft_view=='pdfDraftMukterpulDischargeInvoice')		//MUKTARPUR CONT DISCHARGE - 07-01-2019	//intakhab
			{
				$html=$this->load->view('mukhtarpur_cont_discharge_bill',$this->data, true); 
				$pdfFilePath ="mukhtarpurContDischargeBill-".time()."-download.pdf";
			}
			else if($draft_view=='pdfMukhterpoleLoadingInvoice')		//MUKTARPUR CONT LOAD - 07-01-2019	//intakhab
			{
				$html=$this->load->view('mukhtarpur_cont_load_bill',$this->data, true); 
				$pdfFilePath ="mukhtarpurContLoadingBill-".time()."-download.pdf";
			}
			else if($draft_view=='pdfExportStorageInvoice')
			{
				$html=$this->load->view('rptExportStorageDraftInvoice',$this->data, true); 
				$pdfFilePath ="exportStorage-".time()."-download.pdf";
			}
			//actually, you can pass mPDF parameter on this load() function
			$pdf = $this->m_pdf->load();
			$pdf->SetWatermarkText('CPA CTMS');		
			$pdf->showWatermarkText = true;
			$stylesheet = file_get_contents('resources/styles/test.css');
			
			$pdf->useSubstitutions = true; // optional - just as an example
	
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
	
			if($draft_detail_view=='pdfReeferInvoice')
			{
				$sql_detail="select 'Reefer Charges Bill' as invoiceDesc,draftNumber as draftNumber,DATE(billingDate) as created,mlo as customerId,mlo_name as customerName,agent_code as concustomerid,agent as concustomername,id as unitId,rotation as ibVisitId,vsl_name as ibCarrierName, size as isoLength,height as isoHeight,freight_kind as freightKind,rfr_connect as eventFrom,rfr_disconnect as eventTo,ceil((TIMESTAMPDIFF(SECOND, rfr_connect,rfr_disconnect))/3600) as hours,storage_days as quantity,vatperc as vatperc,'DRAFT' as status,yard
				from ctmsmis.mis_billing_details 
				where draftNumber='$draftNumber' 
				order by draftNumber";
			}
			else if($draft_detail_view=='pdfLoadingInvoice')
			{
				$sql_detail="SELECT draftNumber AS draftNumber,rotation AS obVisitId,(SELECT DATE(billing_date) FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS created,vsl_name AS obCarrierName,mlo AS customerId,mlo_name AS customerName,agent_code AS concustomerid,agent AS concustomername,id AS unitId,size AS isoLength,height AS isoHeight,freight_kind AS freightKind,vatperc AS vatperc, DATE(atd) AS landingDate,description,wpn,IF(wpn='W','PORT','DEPO') AS loc,'DRAFT' AS STATUS
				FROM ctmsmis.mis_billing_details WHERE draftNumber='$draftNumber' AND description LIKE 'Load%' ORDER BY draftNumber";
				
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
				COUNT(w) AS  w,
				COUNT(p) AS  p,
				COUNT(n) AS n,
				COUNT(chargeEntityId) AS tot,
				COUNT(fcl) AS  fcl,
				COUNT(lcl) AS  lcl,
				COUNT(mty) AS  mty,
				COUNT(tot_20_85) AS  tot_20_85,
				COUNT(tot_20_95) AS  tot_20_95,
				COUNT(tot_40_85) AS  tot_40_85,
				COUNT(tot_40_95) AS  tot_40_95,
				COUNT(tot_45_85) AS  tot_45_85,
				COUNT(tot_45_95) AS  tot_45_95
				 FROM
				(SELECT DISTINCT id AS chargeEntityId,

				(CASE WHEN height='8.6' AND size = '20' AND freight_kind = 'FCL' THEN 1
				ELSE NULL END) AS fcl_20_85,

				(CASE WHEN height='9.6' AND size = '20' AND freight_kind = 'FCL' THEN 1
				ELSE NULL END) AS fcl_20_95,

				(CASE WHEN height='8.6' AND size = '40' AND freight_kind = 'FCL' THEN 1
				ELSE NULL END) AS fcl_40_85,

				(CASE WHEN height='9.6' AND size = '40' AND freight_kind = 'FCL' THEN 1
				ELSE NULL END) AS fcl_40_95,

				(CASE WHEN height='8.6' AND size = '45' AND freight_kind = 'FCL' THEN 1
				ELSE NULL END) AS fcl_45_85,

				(CASE WHEN height='9.6' AND size = '45' AND freight_kind = 'FCL' THEN 1
				ELSE NULL END) AS fcl_45_95,

				(CASE WHEN height='8.6' AND size = '20' AND freight_kind = 'LCL' THEN 1
				ELSE NULL END) AS lcl_20_85,

				(CASE WHEN height='9.6' AND size = '20' AND freight_kind = 'LCL' THEN 1
				ELSE NULL END) AS lcl_20_95,

				(CASE WHEN height='8.6' AND size = '40' AND freight_kind = 'LCL' THEN 1
				ELSE NULL END) AS lcl_40_85,

				(CASE WHEN height='9.6' AND size = '40' AND freight_kind = 'LCL' THEN 1
				ELSE NULL END) AS lcl_40_95,

				(CASE WHEN height='8.6' AND size = '45' AND freight_kind = 'LCL' THEN 1
				ELSE NULL END) AS lcl_45_85,

				(CASE WHEN height='9.6' AND size = '45' AND freight_kind = 'LCL' THEN 1
				ELSE NULL END) AS lcl_45_95,

				(CASE WHEN height='8.6' AND size = '20' AND freight_kind = 'MTY' THEN 1
				ELSE NULL END) AS mty_20_85,

				(CASE WHEN height='9.6' AND size = '20' AND freight_kind = 'MTY' THEN 1
				ELSE NULL END) AS mty_20_95,

				(CASE WHEN height='8.6' AND size = '40' AND freight_kind = 'MTY' THEN 1
				ELSE NULL END) AS mty_40_85,

				(CASE WHEN height='9.6' AND size = '40' AND freight_kind = 'MTY' THEN 1
				ELSE NULL END) AS mty_40_95,

				(CASE WHEN height='8.6' AND size = '45' AND freight_kind = 'MTY' THEN 1
				ELSE NULL END) AS mty_45_85,

				(CASE WHEN height='9.6' AND size = '45' AND freight_kind = 'MTY' THEN 1
				ELSE NULL END) AS mty_45_95,

				(CASE WHEN vatperc=0 THEN 1
				ELSE NULL END) AS nonvat,

				(CASE WHEN vatperc!=0 THEN 1
				ELSE NULL END) AS vat,

				(CASE WHEN wpn ='W' THEN 1
				ELSE NULL END) AS w,

				(CASE WHEN wpn ='P' THEN 1
				ELSE NULL END) AS p,

				(CASE WHEN wpn ='N' THEN 1
				ELSE NULL END) AS n,

				(CASE WHEN freight_kind = 'FCL' THEN 1
				ELSE NULL END) AS fcl,

				(CASE WHEN freight_kind = 'LCL' THEN 1
				ELSE NULL END) AS lcl,

				(CASE WHEN freight_kind = 'MTY' THEN 1
				ELSE NULL END) AS mty,


				(CASE WHEN height='8.6' AND size = '20'  THEN 1
				ELSE NULL END) AS tot_20_85,

				(CASE WHEN height='9.6' AND size = '20' THEN 1
				ELSE NULL END) AS tot_20_95,

				(CASE WHEN height='8.6' AND size = '40'  THEN 1
				ELSE NULL END) AS tot_40_85,

				(CASE WHEN height='9.6' AND size = '40'  THEN 1
				ELSE NULL END) AS tot_40_95,

				(CASE WHEN height='8.6' AND size = '45'  THEN 1
				ELSE NULL END) AS tot_45_85,

				(CASE WHEN height='9.6' AND size = '45'  THEN 1
				ELSE NULL END) AS tot_45_95

				FROM ctmsmis.mis_billing_details 
				WHERE draftNumber='$draftNumber' ) AS destais";
				
				$rslt_detail_summary=$this->bm->dataSelect($sql_detail_summary);
				$this->data['rslt_detail_summary']=$rslt_detail_summary;
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
			else if($draft_detail_view=='pdfPangoanDischargeInvoice')
			{
				// $sql_detail="select id as stt,gkey,freight_kind as freightKind,'DRAFT' as status,'Container Discharging Bill (PCT)' as invoiceDesc,draftNumber,vsl_name as ibCarrierName,
				// mlo as customerId,mlo_name as customerName,agent_code as concustomerid,agent as concustomername,
				// rotation as ibVisitId,date(billingDate) as created,size as isoLength,height as isoHeight,
				// wpn as equipment,
				// (select sparcsn4.inv_goods.destination 
				// from sparcsn4.inv_unit 
				// inner join sparcsn4.inv_goods on sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
				// where sparcsn4.inv_unit.gkey=mis_billing_details.gkey) as preloc,
				// vatperc,iso_grp,
				// (CASE
					// WHEN iso_grp = 'UT' THEN 'OPEN TOP'
					// WHEN iso_grp IN ('RE','RT') THEN 'REEFER'
					// WHEN iso_grp IN ('PL','PC','PC') THEN 'F-RACK'
					// WHEN iso_grp IN ('TN','TD','TG') THEN 'TANK'
						// ELSE NULL
					// END) AS cnttype
				// from ctmsmis.mis_billing_details
				// where draftNumber='$draftNumber' order by draftNumber";
				
				$sql_detail="SELECT id AS unitId,gkey,freight_kind AS freightKind,'DRAFT' AS status,'Container Discharging Bill (PCT)' AS invoiceDesc,draftNumber,vsl_name AS ibCarrierName,
				mlo AS customerId,mlo_name AS customerName,agent_code AS concustomerid,agent AS concustomername,
				rotation AS ibVisitId,billingDate AS created,size AS isoLength,height AS isoHeight,
				wpn AS equipment,DATE(fcy_time_in) AS fcy_time_in,
				(SELECT sparcsn4.inv_goods.destination 
				FROM sparcsn4.inv_unit 
				INNER JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
				WHERE sparcsn4.inv_unit.gkey=ctmsmis.mis_billing_details.gkey) AS preloc,
				vatperc,iso_grp,
				(CASE
						WHEN iso_grp = 'UT' THEN 'OPEN TOP'
						WHEN iso_grp IN ('RE','RT') THEN 'REEFER'
					WHEN iso_grp IN ('PL','PC','PC') THEN 'F-RACK'
					WHEN iso_grp IN ('TN','TD','TG') THEN 'TANK'
						ELSE NULL
				END) AS cnttype,
				(SELECT DATE(billing_date) FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS billing_date

				FROM ctmsmis.mis_billing_details
				WHERE draftNumber='$draftNumber' ORDER BY draftNumber";
								
				// $summary_bill="SELECT
								// COUNT(fcl_20_85) AS  fcl_20_85,
								// COUNT(fcl_20_95) AS  fcl_20_95,
								// COUNT(fcl_40_85) AS  fcl_40_85,
								// COUNT(fcl_40_95) AS  fcl_40_95,
								// COUNT(fcl_45_85) AS  fcl_45_85,
								// COUNT(fcl_45_95) AS  fcl_45_95,

								// COUNT(lcl_20_85) AS  lcl_20_85,
								// COUNT(lcl_20_95) AS  lcl_20_95,
								// COUNT(lcl_40_85) AS  lcl_40_85,
								// COUNT(lcl_40_95) AS  lcl_40_95,
								// COUNT(lcl_45_85) AS  lcl_45_85,
								// COUNT(lcl_45_95) AS  lcl_45_95,

								// COUNT(mty_20_85) AS  mty_20_85,
								// COUNT(mty_20_95) AS  mty_20_95,
								// COUNT(mty_40_85) AS  mty_40_85,
								// COUNT(mty_40_95) AS  mty_40_95,
								// COUNT(mty_45_85) AS  mty_45_85,
								// COUNT(mty_45_95) AS  mty_45_95,
								// COUNT(nonvat) AS  nonvat,
								// COUNT(vat) AS  vat,
								// COUNT(chargeEntityId) AS tot,
								// COUNT(fcl) AS  fcl,
								// COUNT(lcl) AS  lcl,
								// COUNT(mty) AS  mty,
								// COUNT(tot_20_85) AS  tot_20_85,
								// COUNT(tot_20_95) AS  tot_20_95,
								// COUNT(tot_40_85) AS  tot_40_85,
								// COUNT(tot_40_95) AS  tot_40_95,
								// COUNT(tot_45_85) AS  tot_45_85,
								// COUNT(tot_45_95) AS  tot_45_95,
								// COUNT(equipmentW) AS equipmentW,
								// COUNT(equipmentP) AS equipmentP,
								// COUNT(equipmentN) AS equipmentN,
								// COUNT(LON) AS LON,
								// (select (COUNT(chargeEntityId)-COUNT(LON))) AS NLON
								// from
								// (
								// SELECT DISTINCT id as chargeEntityId,

								// (CASE WHEN height='8.6' AND size = 20 AND freight_kind = 'FCL' THEN 1
								// ELSE NULL END) AS fcl_20_85,

								// (CASE WHEN height='9.6' AND size = 20 AND freight_kind = 'FCL' THEN 1
								// ELSE NULL END) AS fcl_20_95,

								// (CASE WHEN height='8.6' AND size = 40 AND freight_kind = 'FCL' THEN 1
								// ELSE NULL END) AS fcl_40_85,

								// (CASE WHEN height='9.6' AND size = 40 AND freight_kind = 'FCL' THEN 1
								// ELSE NULL END) AS fcl_40_95,

								// (CASE WHEN height='8.6' AND size = 45 AND freight_kind = 'FCL' THEN 1
								// ELSE NULL END) AS fcl_45_85,

								// (CASE WHEN height='9.6' AND size = 45 AND freight_kind = 'FCL' THEN 1
								// ELSE NULL END) AS fcl_45_95,

								// (CASE WHEN height='8.6' AND size = 20 AND freight_kind = 'LCL' THEN 1
								// ELSE NULL END) AS lcl_20_85,

								// (CASE WHEN height='9.6' AND size = 20 AND freight_kind = 'LCL' THEN 1
								// ELSE NULL END) AS lcl_20_95,

								// (CASE WHEN height='8.6' AND size = 40 AND freight_kind = 'LCL' THEN 1
								// ELSE NULL END) AS lcl_40_85,

								// (CASE WHEN height='9.6' AND size = 40 AND freight_kind = 'LCL' THEN 1
								// ELSE NULL END) AS lcl_40_95,

								// (CASE WHEN height='8.6' AND size = 45 AND freight_kind = 'LCL' THEN 1
								// ELSE NULL END) AS lcl_45_85,

								// (CASE WHEN height='9.6' AND size = 45 AND freight_kind = 'LCL' THEN 1
								// ELSE NULL END) AS lcl_45_95,

								// (CASE WHEN height='8.6' AND size = 20 AND freight_kind = 'EMPTY' THEN 1
								// ELSE NULL END) AS mty_20_85,

								// (CASE WHEN height='9.6' AND size = 20 AND freight_kind = 'EMPTY' THEN 1
								// ELSE NULL END) AS mty_20_95,

								// (CASE WHEN height='8.6' AND size = 40 AND freight_kind = 'EMPTY' THEN 1
								// ELSE NULL END) AS mty_40_85,

								// (CASE WHEN height='9.6' AND size = 40 AND freight_kind = 'EMPTY' THEN 1
								// ELSE NULL END) AS mty_40_95,

								// (CASE WHEN height='8.6' AND size = 45 AND freight_kind = 'EMPTY' THEN 1
								// ELSE NULL END) AS mty_45_85,

								// (CASE WHEN height='9.6' AND size = 45 AND freight_kind = 'EMPTY' THEN 1
								// ELSE NULL END) AS mty_45_95,

								// (CASE WHEN vatperc =0 THEN 1
								// ELSE NULL END) AS nonvat,

								// (CASE WHEN vatperc !=0 THEN 1
								// ELSE NULL END) AS vat,

								// (CASE WHEN freight_kind = 'FCL' THEN 1
								// ELSE NULL END) AS fcl,

								// (CASE WHEN freight_kind = 'LCL' THEN 1
								// ELSE NULL END) AS lcl,

								// (CASE WHEN freight_kind = 'EMPTY' THEN 1
								// ELSE NULL END) AS mty,

								// (CASE WHEN height='8.6' AND size = 20  THEN 1
								// ELSE NULL END) AS tot_20_85,

								// (CASE WHEN height='9.6' AND size = 20 THEN 1
								// ELSE NULL END) AS tot_20_95,

								// (CASE WHEN height='8.6' AND size = 40  THEN 1
								// ELSE NULL END) AS tot_40_85,

								// (CASE WHEN height='9.6' AND size = 40  THEN 1
								// ELSE NULL END) AS tot_40_95,

								// (CASE WHEN height='8.6' AND size = 45  THEN 1
								// ELSE NULL END) AS tot_45_85,

								// (CASE WHEN height='9.6' AND size = 45  THEN 1
								// ELSE NULL END) AS tot_45_95,

								// (CASE WHEN wpn='W'   THEN 1
								// ELSE NULL END) AS equipmentW,

								// (CASE WHEN wpn='P'   THEN 1
								// ELSE NULL END) AS equipmentP,

								// (CASE WHEN wpn='N'   THEN 1
								// ELSE NULL END) AS equipmentN,
								// if(destination not in('2591','2592','5230','5231','5232','5233','5234','5235','5236','5237','5238') and freight_kind !='MTY',1,NULL) as LON
								// from
								// (
								// select * from ctmsmis.mis_billing_details where draftNumber='$draftNumber' and description like 'Load%'
								// ) tbl
								// ) final";	

								$summary_bill="SELECT
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
								(SELECT (COUNT(chargeEntityId)-COUNT(LON))) AS NLON
								FROM
								(
								SELECT DISTINCT id AS chargeEntityId,

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
								IF(destination NOT IN('2591','2592','5230','5231','5232','5233','5234','5235','5236','5237','5238') AND freight_kind !='MTY',1,NULL) AS LON
								FROM
								(
								SELECT * FROM ctmsmis.mis_billing_details WHERE draftNumber='14862' AND description LIKE (CASE WHEN invoice_type=112 THEN 'Load%' WHEN invoice_type=120 THEN 'Load%' WHEN invoice_type=108 THEN 'Discharging%' WHEN invoice_type=128 THEN 'Discharging%' ELSE 'Status%' END )
								) tbl
								) final";								
					
					$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";	
					$print_time=$this->bm->dataSelect($bill_print_time);		
					$this->data['print_time']=$print_time;		
					
					$summary_bill_detail=$this->bm->dataSelect($summary_bill);	
					$this->data['summary_bill_detail']=$summary_bill_detail;			
			}
			else if($draft_detail_view=='pdfPangoanLoadingInvoice')
			{				
				$sql_detail="select distinct id as unitId,gkey,freight_kind as freightKind,'DRAFT' as status,'Container Loading Bill (PCT)' as invoiceDesc,draftNumber,if(depo_date is null,draftNumber,concat(draftNumber,'R')) as billNumber,vsl_name as ibCarrierName, DATE_FORMAT(depo_date,'%d-%m-%Y') as depo_date,
				mlo as customerId,mlo_name as customerName,agent_code as concustomerid,agent as concustomername,
				rotation as ibVisitId,(select DATE_FORMAT(billing_date,'%d-%m-%Y') from ctmsmis.mis_billing where draft_id='$draftNumber') as created,size as isoLength,height as isoHeight, DATE_FORMAT(cl_date,'%d-%m-%Y') AS timeIn, DATE_FORMAT(fcy_time_out,'%d-%m-%Y') as timeOut,
				pre_imp_rot as imp_rot,
				DATE_FORMAT(pre_imp_ata,'%d-%m-%Y') as imp_ata,
				if(datediff(fcy_time_out,ifnull(depo_date,DATE_ADD(cl_date,INTERVAL 4 DAY)))+1<1,'0',datediff(fcy_time_out,ifnull(depo_date,DATE_ADD(cl_date,INTERVAL 4 DAY)))+1) as days,
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
				where draftNumber='$draftNumber' and description like 'Load%' order by draftNumber";
						
				$summary_bill="SELECT
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

								(CASE WHEN height='8.6' AND size = 20 AND freight_kind = 'EMPTY' THEN 1
								ELSE NULL END) AS mty_20_85,

								(CASE WHEN height='9.6' AND size = 20 AND freight_kind = 'EMPTY' THEN 1
								ELSE NULL END) AS mty_20_95,

								(CASE WHEN height='8.6' AND size = 40 AND freight_kind = 'EMPTY' THEN 1
								ELSE NULL END) AS mty_40_85,

								(CASE WHEN height='9.6' AND size = 40 AND freight_kind = 'EMPTY' THEN 1
								ELSE NULL END) AS mty_40_95,

								(CASE WHEN height='8.6' AND size = 45 AND freight_kind = 'EMPTY' THEN 1
								ELSE NULL END) AS mty_45_85,

								(CASE WHEN height='9.6' AND size = 45 AND freight_kind = 'EMPTY' THEN 1
								ELSE NULL END) AS mty_45_95,

								(CASE WHEN vatperc =0 THEN 1
								ELSE NULL END) AS nonvat,

								(CASE WHEN vatperc !=0 THEN 1
								ELSE NULL END) AS vat,

								(CASE WHEN freight_kind = 'FCL' THEN 1
								ELSE NULL END) AS fcl,

								(CASE WHEN freight_kind = 'LCL' THEN 1
								ELSE NULL END) AS lcl,

								(CASE WHEN freight_kind = 'EMPTY' THEN 1
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
								select * from ctmsmis.mis_billing_details where draftNumber='$draftNumber' and description like 'Load%'
								) tbl
								) final";					
					
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";		
				$print_time=$this->bm->dataSelect($bill_print_time);	
				$this->data['print_time']=$print_time;			
				
				$summary_bill_detail=$this->bm->dataSelect($summary_bill);	
				$this->data['summary_bill_detail']=$summary_bill_detail;			
			}	
			
			else if($draft_detail_view=='pdfDraftICDInvoice')
			{
				$sql_detail="select draftNumber,'DRAFT' as status,description as invoiceDesc,id as unitId,freight_kind as freightKind,height as isoHeight,size as isoLength,
							vsl_name as ibCarrierName,rotation as ibVisitId,
							vatperc,date(billingDate) as created,
							agent as concustomername,
							agent_code as concustomerid,
							mlo_name as customerName,mlo as customerId,date(fcy_time_in) as timeIn,date(fcy_time_out) as timeOut,
							(select last_pos_locid from sparcsn4.inv_unit_fcy_visit where unit_gkey=mis_billing_details.gkey) as wagon, seal_nbr1

							from ctmsmis.mis_billing_details
							where draftNumber='$draftNumber' and description like 'LIFT%'";
												
				$summary_bill="select 
							count(fcl_20_85) as  fcl_20_85,
							count(fcl_20_95) as  fcl_20_95,
							count(fcl_40_85) as  fcl_40_85,
							count(fcl_40_95) as  fcl_40_95,
							count(fcl_45_85) as  fcl_45_85,
							count(fcl_45_95) as  fcl_45_95,

							count(lcl_20_85) as  lcl_20_85,
							count(lcl_20_95) as  lcl_20_95,
							count(lcl_40_85) as  lcl_40_85,
							count(lcl_40_95) as  lcl_40_95,
							count(lcl_45_85) as  lcl_45_85,
							count(lcl_45_95) as  lcl_45_95,

							count(mty_20_85) as  mty_20_85,
							count(mty_20_95) as  mty_20_95,
							count(mty_40_85) as  mty_40_85,
							count(mty_40_95) as  mty_40_95,
							count(mty_45_85) as  mty_45_85,
							count(mty_45_95) as  mty_45_95,

							count(chargeEntityId) as tot,
							count(fcl) as  fcl,
							count(lcl) as  lcl,
							count(mty) as  mty,
							count(tot_20_85) as  tot_20_85,
							count(tot_20_95) as  tot_20_95,
							count(tot_40_85) as  tot_40_85,
							count(tot_40_95) as  tot_40_95,
							count(tot_45_85) as  tot_45_85,
							count(tot_45_95) as  tot_45_95
							 from
							(select distinct id as chargeEntityId,

							(CASE WHEN height='8.6' AND size = '20' AND freight_kind = 'FCL' THEN 1
							ELSE NULL END) AS fcl_20_85,

							(CASE WHEN height='9.6' AND size = '20' AND freight_kind = 'FCL' THEN 1
							ELSE NULL END) AS fcl_20_95,

							(CASE WHEN height='8.6' AND size = '40' AND freight_kind = 'FCL' THEN 1
							ELSE NULL END) AS fcl_40_85,

							(CASE WHEN height='9.6' AND size = '40' AND freight_kind = 'FCL' THEN 1
							ELSE NULL END) AS fcl_40_95,

							(CASE WHEN height='8.6' AND size = '45' AND freight_kind = 'FCL' THEN 1
							ELSE NULL END) AS fcl_45_85,

							(CASE WHEN height='9.6' AND size = '45' AND freight_kind = 'FCL' THEN 1
							ELSE NULL END) AS fcl_45_95,

							(CASE WHEN height='8.6' AND size = '20' AND freight_kind = 'LCL' THEN 1
							ELSE NULL END) AS lcl_20_85,

							(CASE WHEN height='9.6' AND size = '20' AND freight_kind = 'LCL' THEN 1
							ELSE NULL END) AS lcl_20_95,

							(CASE WHEN height='8.6' AND size = '40' AND freight_kind = 'LCL' THEN 1
							ELSE NULL END) AS lcl_40_85,

							(CASE WHEN height='9.6' AND size = '40' AND freight_kind = 'LCL' THEN 1
							ELSE NULL END) AS lcl_40_95,

							(CASE WHEN height='8.6' AND size = '45' AND freight_kind = 'LCL' THEN 1
							ELSE NULL END) AS lcl_45_85,

							(CASE WHEN height='9.6' AND size = '45' AND freight_kind = 'LCL' THEN 1
							ELSE NULL END) AS lcl_45_95,

							(CASE WHEN height='8.6' AND size = '20' AND freight_kind = 'MTY' THEN 1
							ELSE NULL END) AS mty_20_85,

							(CASE WHEN height='9.6' AND size = '20' AND freight_kind = 'MTY' THEN 1
							ELSE NULL END) AS mty_20_95,

							(CASE WHEN height='8.6' AND size = '40' AND freight_kind = 'MTY' THEN 1
							ELSE NULL END) AS mty_40_85,

							(CASE WHEN height='9.6' AND size = '40' AND freight_kind = 'MTY' THEN 1
							ELSE NULL END) AS mty_40_95,

							(CASE WHEN height='8.6' AND size = '45' AND freight_kind = 'MTY' THEN 1
							ELSE NULL END) AS mty_45_85,

							(CASE WHEN height='9.6' AND size = '45' AND freight_kind = 'MTY' THEN 1
							ELSE NULL END) AS mty_45_95,

							(CASE WHEN freight_kind = 'FCL' THEN 1
							ELSE NULL END) AS fcl,

							(CASE WHEN freight_kind = 'LCL' THEN 1
							ELSE NULL END) AS lcl,

							(CASE WHEN freight_kind = 'MTY' THEN 1
							ELSE NULL END) AS mty,


							(CASE WHEN height='8.6' AND size = '20'  THEN 1
							ELSE NULL END) AS tot_20_85,

							(CASE WHEN height='9.6' AND size = '20' THEN 1
							ELSE NULL END) AS tot_20_95,

							(CASE WHEN height='8.6' AND size = '40'  THEN 1
							ELSE NULL END) AS tot_40_85,

							(CASE WHEN height='9.6' AND size = '40'  THEN 1
							ELSE NULL END) AS tot_40_95,

							(CASE WHEN height='8.6' AND size = '45'  THEN 1
							ELSE NULL END) AS tot_45_85,

							(CASE WHEN height='9.6' AND size = '45'  THEN 1
							ELSE NULL END) AS tot_45_95

							from ctmsmis.mis_billing_details
							where draftNumber='$draftNumber' and description like 'LIFT%' ) as destais";	
				
				$summary_bill_detail=$this->bm->dataSelect($summary_bill);	
				$this->data['summary_bill_detail']=$summary_bill_detail;				
					
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";		
				$print_time=$this->bm->dataSelect($bill_print_time);	
				$this->data['print_time']=$print_time;				
			}	
			 //new bill detail
            else if($draft_detail_view=='pdfPangoanStatusChangeInvoice')
			{
                           $sql_detail="SELECT DISTINCT id AS unitId,gkey,freight_kind AS freightKind,'DRAFT' AS STATUS,'Status Change Bill (CPA to PCT)' AS invoiceDesc,draftNumber,IF(depo_date IS NULL,draftNumber,CONCAT(draftNumber,'R')) AS billNumber,vsl_name AS ibCarrierName,depo_date,
                            mlo AS customerId,mlo_name AS customerName,agent_code AS concustomerid,agent AS concustomername,
                            rotation AS ibVisitId,(SELECT DATE_FORMAT(billing_date, '%d-%m-%Y') AS billing_date FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS created,size AS isoLength,LEFT(height,3) AS isoHeight,DATE_FORMAT(cl_date, '%d-%m-%Y') AS timeIn,
                            DATE_FORMAT(fcy_time_out, '%d-%m-%Y') AS timeOut, pre_imp_rot AS imp_rot, 
                            DATE_FORMAT(pre_imp_ata, '%d-%m-%Y')  AS imp_ata,
                            IF(DATEDIFF(fcy_time_out,IFNULL(depo_date,DATE_ADD(cl_date,INTERVAL 4 DAY)))+1<1,'0',DATEDIFF(fcy_time_out,IFNULL(depo_date,DATE_ADD(cl_date,INTERVAL 4 DAY)))+1) AS days,
                            wpn AS equipment,
                            (SELECT sparcsn4.inv_goods.destination 
                            FROM sparcsn4.inv_unit 
                            INNER JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
                            WHERE sparcsn4.inv_unit.gkey=ctmsmis.mis_billing_details.gkey) AS preloc,
                            vatperc,iso_grp,
                            (CASE
                                    WHEN iso_grp = 'UT' THEN 'OPEN TOP'
                                    WHEN iso_grp IN ('RE','RT') THEN 'REEFER'
                                    WHEN iso_grp IN ('PL','PC','PC') THEN 'F-RACK'
                                    WHEN iso_grp IN ('TN','TD','TG') THEN 'TANK'
                                    ELSE NULL
                            END) AS cnttype

                            FROM ctmsmis.mis_billing_details
                            WHERE draftNumber='$draftNumber' AND description LIKE 'Status%' ORDER BY draftNumber";
                        
                           $summary_bill="SELECT
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
                                        select * from ctmsmis.mis_billing_details where draftNumber='$draftNumber' and description LIKE (CASE WHEN invoice_type=112 THEN 'Load%' WHEN invoice_type=120 THEN 'Load%' WHEN invoice_type=108 THEN 'Discharging%' ELSE 'Status%' END )
                                        ) tbl
                                        ) final";
                                $summary_bill_detail=$this->bm->dataSelect($summary_bill);	
				$this->data['summary_bill_detail']=$summary_bill_detail;				
					
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";		
				$print_time=$this->bm->dataSelect($bill_print_time);	
				$this->data['print_time']=$print_time;	

                         }
                         
			else if($draft_detail_view=='pdfStatucChangeCPAToICDInvoice')
			{
                           $sql_detail="SELECT DISTINCT id AS unitId,draftNumber AS draftNumber,
                               'STATUS CHANGE INVOICE (CPA TO ICD)' AS invoiceList,vsl_name AS ibCarrierName,
                               rotation AS ibVisitId,mlo AS customerId,mlo_name AS customerName,DATE_FORMAT(billingDate, '%d-%m-%Y') AS created,
                               agent_code AS concustomerid,agent AS concustomername,'DRAFT' AS STATUS,size AS isoLength,
                               LEFT(height,3) AS isoHeight,freight_kind AS freightKind,DATE_FORMAT(fcy_time_in, '%d-%m-%Y') AS timeIn,cl_date AS cl_date,
                               DATE_ADD(cl_date,INTERVAL 4 DAY) AS eventFrom,DATE_FORMAT(fcy_time_out, '%d-%m-%Y') AS eventTo,
                               DATEDIFF(fcy_time_out,DATE_ADD(cl_date,INTERVAL 4 DAY))+1 AS days,vatperc AS vatperc
                               FROM ctmsmis.mis_billing_details WHERE draftNumber=$draftNumber";
                        
                           $summary_bill="SELECT
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
                                COUNT(chargeEntityId) AS  vat,
                                COUNT(chargeEntityId) AS tot,
                                COUNT(fcl) AS  fcl,
                                COUNT(lcl) AS  lcl,
                                COUNT(mty) AS  mty,
                                COUNT(tot_20_85) AS  tot_20_85,
                                COUNT(tot_20_95) AS  tot_20_95,
                                COUNT(tot_40_85) AS  tot_40_85,
                                COUNT(tot_40_95) AS  tot_40_95,
                                COUNT(tot_45_85) AS  tot_45_85,
                                COUNT(tot_45_95) AS  tot_45_95
                                 FROM
                                (SELECT DISTINCT  id AS chargeEntityId,

                                (CASE WHEN  height='8.600' AND  size = '20' AND  freight_kind = 'FCL' THEN 1
                                ELSE NULL END) AS fcl_20_85,

                                (CASE WHEN  height='9.600' AND  size = '20' AND  freight_kind = 'FCL' THEN 1
                                ELSE NULL END) AS fcl_20_95,

                                (CASE WHEN  height='8.600' AND  size = '40' AND  freight_kind = 'FCL' THEN 1
                                ELSE NULL END) AS fcl_40_85,

                                (CASE WHEN  height='9.600' AND  size = '40' AND  freight_kind = 'FCL' THEN 1
                                ELSE NULL END) AS fcl_40_95,

                                (CASE WHEN  height='8.600' AND  size = '45' AND  freight_kind = 'FCL' THEN 1
                                ELSE NULL END) AS fcl_45_85,

                                (CASE WHEN  height='9.600' AND  size = '45' AND  freight_kind = 'FCL' THEN 1
                                ELSE NULL END) AS fcl_45_95,

                                (CASE WHEN  height='8.600' AND  size = '20' AND  freight_kind = 'LCL' THEN 1
                                ELSE NULL END) AS lcl_20_85,

                                (CASE WHEN  height='9.600' AND  size = '20' AND  freight_kind = 'LCL' THEN 1
                                ELSE NULL END) AS lcl_20_95,

                                (CASE WHEN  height='8.600' AND  size = '40' AND  freight_kind = 'LCL' THEN 1
                                ELSE NULL END) AS lcl_40_85,

                                (CASE WHEN  height='9.600' AND  size = '40' AND  freight_kind = 'LCL' THEN 1
                                ELSE NULL END) AS lcl_40_95,

                                (CASE WHEN  height='8.600' AND  size = '45' AND  freight_kind = 'LCL' THEN 1
                                ELSE NULL END) AS lcl_45_85,

                                (CASE WHEN  height='9.600' AND  size = '45' AND  freight_kind = 'LCL' THEN 1
                                ELSE NULL END) AS lcl_45_95,

                                (CASE WHEN  height='8.600' AND  size = '20' AND  freight_kind = 'MTY' THEN 1
                                ELSE NULL END) AS mty_20_85,

                                (CASE WHEN  height='9.600' AND  size = '20' AND  freight_kind = 'MTY' THEN 1
                                ELSE NULL END) AS mty_20_95,

                                (CASE WHEN  height='8.600' AND  size = '40' AND  freight_kind = 'MTY' THEN 1
                                ELSE NULL END) AS mty_40_85,

                                (CASE WHEN  height='9.600' AND  size = '40' AND  freight_kind = 'MTY' THEN 1
                                ELSE NULL END) AS mty_40_95,

                                (CASE WHEN  height='8.600' AND  size = '45' AND  freight_kind = 'MTY' THEN 1
                                ELSE NULL END) AS mty_45_85,

                                (CASE WHEN  height='9.600' AND  size = '45' AND  freight_kind = 'MTY' THEN 1
                                ELSE NULL END) AS mty_45_95,


                                (CASE WHEN  freight_kind = 'FCL' THEN 1
                                ELSE NULL END) AS fcl,

                                (CASE WHEN  freight_kind = 'LCL' THEN 1
                                ELSE NULL END) AS lcl,

                                (CASE WHEN  freight_kind = 'MTY' THEN 1
                                ELSE NULL END) AS mty,


                                (CASE WHEN  height='8.600' AND  size = '20'  THEN 1
                                ELSE NULL END) AS tot_20_85,

                                (CASE WHEN  height='9.600' AND  size = '20' THEN 1
                                ELSE NULL END) AS tot_20_95,

                                (CASE WHEN  height='8.600' AND  size = '40'  THEN 1
                                ELSE NULL END) AS tot_40_85,

                                (CASE WHEN  height='9.600' AND  size = '40'  THEN 1
                                ELSE NULL END) AS tot_40_95,

                                (CASE WHEN  height='8.600' AND  size = '45'  THEN 1
                                ELSE NULL END) AS tot_45_85,

                                (CASE WHEN  height='9.600' AND  size = '45'  THEN 1
                                ELSE NULL END) AS tot_45_95

                                FROM ctmsmis.mis_billing_details
                                WHERE  draftNumber='$draftNumber') AS cancel";
                                $summary_bill_detail=$this->bm->dataSelect($summary_bill);	
				$this->data['summary_bill_detail']=$summary_bill_detail;				
					
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";		
				$print_time=$this->bm->dataSelect($bill_print_time);	
				$this->data['print_time']=$print_time;	

                    }	
                    
                    else if($draft_detail_view=='pdfStatucChangeLCLToFCLInvoice')
			{
                           $sql_detail="SELECT DISTINCT id AS unitId,draftNumber AS draftNumber,'STATUS CHANGE INVOICE (LCL TO FCL)' AS invoiceList,
                               vsl_name AS ibCarrierName,rotation AS ibVisitId,mlo AS customerId,mlo_name AS customerName,
                               DATE_FORMAT(billingDate, '%d-%m-%Y') AS created,agent_code AS concustomerid,agent AS concustomername,'DRAFT' AS STATUS,
                               size AS isoLength,LEFT(height,3) AS isoHeight,freight_kind AS freightKind,DATE_FORMAT(fcy_time_in, '%Y-%m-%d')  AS timeIn,
                               cl_date AS cl_date,DATE_ADD(cl_date,INTERVAL 4 DAY) AS eventFrom,DATE_FORMAT(fcy_time_out, '%Y-%m-%d') AS eventTo,
                               DATEDIFF(fcy_time_out,DATE_ADD(cl_date,INTERVAL 4 DAY))+1 AS days,vatperc AS vatperc
                                FROM ctmsmis.mis_billing_details WHERE draftNumber=$draftNumber";
                        
                           $summary_bill="SELECT
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
                                COUNT(chargeEntityId) AS  vat,
                                COUNT(chargeEntityId) AS tot,
                                COUNT(fcl) AS  fcl,
                                COUNT(lcl) AS  lcl,
                                COUNT(mty) AS  mty,
                                COUNT(tot_20_85) AS  tot_20_85,
                                COUNT(tot_20_95) AS  tot_20_95,
                                COUNT(tot_40_85) AS  tot_40_85,
                                COUNT(tot_40_95) AS  tot_40_95,
                                COUNT(tot_45_85) AS  tot_45_85,
                                COUNT(tot_45_95) AS  tot_45_95
                                 FROM
                                (SELECT DISTINCT  id AS chargeEntityId,

                                (CASE WHEN  height='8.600' AND  size = '20' AND  freight_kind = 'FCL' THEN 1
                                ELSE NULL END) AS fcl_20_85,

                                (CASE WHEN  height='9.600' AND  size = '20' AND  freight_kind = 'FCL' THEN 1
                                ELSE NULL END) AS fcl_20_95,

                                (CASE WHEN  height='8.600' AND  size = '40' AND  freight_kind = 'FCL' THEN 1
                                ELSE NULL END) AS fcl_40_85,

                                (CASE WHEN  height='9.600' AND  size = '40' AND  freight_kind = 'FCL' THEN 1
                                ELSE NULL END) AS fcl_40_95,

                                (CASE WHEN  height='8.600' AND  size = '45' AND  freight_kind = 'FCL' THEN 1
                                ELSE NULL END) AS fcl_45_85,

                                (CASE WHEN  height='9.600' AND  size = '45' AND  freight_kind = 'FCL' THEN 1
                                ELSE NULL END) AS fcl_45_95,

                                (CASE WHEN  height='8.600' AND  size = '20' AND  freight_kind = 'LCL' THEN 1
                                ELSE NULL END) AS lcl_20_85,

                                (CASE WHEN  height='9.600' AND  size = '20' AND  freight_kind = 'LCL' THEN 1
                                ELSE NULL END) AS lcl_20_95,

                                (CASE WHEN  height='8.600' AND  size = '40' AND  freight_kind = 'LCL' THEN 1
                                ELSE NULL END) AS lcl_40_85,

                                (CASE WHEN  height='9.600' AND  size = '40' AND  freight_kind = 'LCL' THEN 1
                                ELSE NULL END) AS lcl_40_95,

                                (CASE WHEN  height='8.600' AND  size = '45' AND  freight_kind = 'LCL' THEN 1
                                ELSE NULL END) AS lcl_45_85,

                                (CASE WHEN  height='9.600' AND  size = '45' AND  freight_kind = 'LCL' THEN 1
                                ELSE NULL END) AS lcl_45_95,

                                (CASE WHEN  height='8.600' AND  size = '20' AND  freight_kind = 'MTY' THEN 1
                                ELSE NULL END) AS mty_20_85,

                                (CASE WHEN  height='9.600' AND  size = '20' AND  freight_kind = 'MTY' THEN 1
                                ELSE NULL END) AS mty_20_95,

                                (CASE WHEN  height='8.600' AND  size = '40' AND  freight_kind = 'MTY' THEN 1
                                ELSE NULL END) AS mty_40_85,

                                (CASE WHEN  height='9.600' AND  size = '40' AND  freight_kind = 'MTY' THEN 1
                                ELSE NULL END) AS mty_40_95,

                                (CASE WHEN  height='8.600' AND  size = '45' AND  freight_kind = 'MTY' THEN 1
                                ELSE NULL END) AS mty_45_85,

                                (CASE WHEN  height='9.600' AND  size = '45' AND  freight_kind = 'MTY' THEN 1
                                ELSE NULL END) AS mty_45_95,


                                (CASE WHEN  freight_kind = 'FCL' THEN 1
                                ELSE NULL END) AS fcl,

                                (CASE WHEN  freight_kind = 'LCL' THEN 1
                                ELSE NULL END) AS lcl,

                                (CASE WHEN  freight_kind = 'MTY' THEN 1
                                ELSE NULL END) AS mty,


                                (CASE WHEN  height='8.600' AND  size = '20'  THEN 1
                                ELSE NULL END) AS tot_20_85,

                                (CASE WHEN  height='9.600' AND  size = '20' THEN 1
                                ELSE NULL END) AS tot_20_95,

                                (CASE WHEN  height='8.600' AND  size = '40'  THEN 1
                                ELSE NULL END) AS tot_40_85,

                                (CASE WHEN  height='9.600' AND  size = '40'  THEN 1
                                ELSE NULL END) AS tot_40_95,

                                (CASE WHEN  height='8.600' AND  size = '45'  THEN 1
                                ELSE NULL END) AS tot_45_85,

                                (CASE WHEN  height='9.600' AND  size = '45'  THEN 1
                                ELSE NULL END) AS tot_45_95

                                FROM ctmsmis.mis_billing_details
                                WHERE  draftNumber='$draftNumber') AS cancel";
                                $summary_bill_detail=$this->bm->dataSelect($summary_bill);	
				$this->data['summary_bill_detail']=$summary_bill_detail;				
					
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";		
				$print_time=$this->bm->dataSelect($bill_print_time);	
				$this->data['print_time']=$print_time;	

                    }
                    
                    else if($draft_detail_view=='pdfStatucChangeFCLToLCLInvoice')
			{
                           $sql_detail="SELECT DISTINCT id AS unitId,draftNumber AS draftNumber,
                               'STATUS CHANGE INVOICE (FCL TO LCL)' AS invoiceList,vsl_name AS ibCarrierName,
                               rotation AS ibVisitId,mlo AS customerId,mlo_name AS customerName,
                               DATE_FORMAT(billingDate, '%Y-%m-%d') AS created,agent_code AS concustomerid,agent AS concustomername,
                               'DRAFT' AS STATUS,size AS isoLength,LEFT(height,3) AS isoHeight,freight_kind AS freightKind,
                               DATE_FORMAT(fcy_time_in, '%Y-%m-%d') AS timeIn,cl_date AS cl_date,
                               DATE_ADD(cl_date,INTERVAL 4 DAY) AS eventFrom,DATE_FORMAT(fcy_time_out, '%Y-%m-%d') AS eventTo,
                               DATEDIFF(fcy_time_out,DATE_ADD(cl_date,INTERVAL 4 DAY))+1 AS days,vatperc AS vatperc
                               FROM ctmsmis.mis_billing_details WHERE draftNumber='$draftNumber'";
                        
                           $summary_bill="SELECT
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
                                COUNT(chargeEntityId) AS  vat,
                                COUNT(chargeEntityId) AS tot,
                                COUNT(fcl) AS  fcl,
                                COUNT(lcl) AS  lcl,
                                COUNT(mty) AS  mty,
                                COUNT(tot_20_85) AS  tot_20_85,
                                COUNT(tot_20_95) AS  tot_20_95,
                                COUNT(tot_40_85) AS  tot_40_85,
                                COUNT(tot_40_95) AS  tot_40_95,
                                COUNT(tot_45_85) AS  tot_45_85,
                                COUNT(tot_45_95) AS  tot_45_95
                                 FROM
                                (SELECT DISTINCT  id AS chargeEntityId,

                                (CASE WHEN  height='8.600' AND  size = '20' AND  freight_kind = 'FCL' THEN 1
                                ELSE NULL END) AS fcl_20_85,

                                (CASE WHEN  height='9.600' AND  size = '20' AND  freight_kind = 'FCL' THEN 1
                                ELSE NULL END) AS fcl_20_95,

                                (CASE WHEN  height='8.600' AND  size = '40' AND  freight_kind = 'FCL' THEN 1
                                ELSE NULL END) AS fcl_40_85,

                                (CASE WHEN  height='9.600' AND  size = '40' AND  freight_kind = 'FCL' THEN 1
                                ELSE NULL END) AS fcl_40_95,

                                (CASE WHEN  height='8.600' AND  size = '45' AND  freight_kind = 'FCL' THEN 1
                                ELSE NULL END) AS fcl_45_85,

                                (CASE WHEN  height='9.600' AND  size = '45' AND  freight_kind = 'FCL' THEN 1
                                ELSE NULL END) AS fcl_45_95,

                                (CASE WHEN  height='8.600' AND  size = '20' AND  freight_kind = 'LCL' THEN 1
                                ELSE NULL END) AS lcl_20_85,

                                (CASE WHEN  height='9.600' AND  size = '20' AND  freight_kind = 'LCL' THEN 1
                                ELSE NULL END) AS lcl_20_95,

                                (CASE WHEN  height='8.600' AND  size = '40' AND  freight_kind = 'LCL' THEN 1
                                ELSE NULL END) AS lcl_40_85,

                                (CASE WHEN  height='9.600' AND  size = '40' AND  freight_kind = 'LCL' THEN 1
                                ELSE NULL END) AS lcl_40_95,

                                (CASE WHEN  height='8.600' AND  size = '45' AND  freight_kind = 'LCL' THEN 1
                                ELSE NULL END) AS lcl_45_85,

                                (CASE WHEN  height='9.600' AND  size = '45' AND  freight_kind = 'LCL' THEN 1
                                ELSE NULL END) AS lcl_45_95,

                                (CASE WHEN  height='8.600' AND  size = '20' AND  freight_kind = 'MTY' THEN 1
                                ELSE NULL END) AS mty_20_85,

                                (CASE WHEN  height='9.600' AND  size = '20' AND  freight_kind = 'MTY' THEN 1
                                ELSE NULL END) AS mty_20_95,

                                (CASE WHEN  height='8.600' AND  size = '40' AND  freight_kind = 'MTY' THEN 1
                                ELSE NULL END) AS mty_40_85,

                                (CASE WHEN  height='9.600' AND  size = '40' AND  freight_kind = 'MTY' THEN 1
                                ELSE NULL END) AS mty_40_95,

                                (CASE WHEN  height='8.600' AND  size = '45' AND  freight_kind = 'MTY' THEN 1
                                ELSE NULL END) AS mty_45_85,

                                (CASE WHEN  height='9.600' AND  size = '45' AND  freight_kind = 'MTY' THEN 1
                                ELSE NULL END) AS mty_45_95,


                                (CASE WHEN  freight_kind = 'FCL' THEN 1
                                ELSE NULL END) AS fcl,

                                (CASE WHEN  freight_kind = 'LCL' THEN 1
                                ELSE NULL END) AS lcl,

                                (CASE WHEN  freight_kind = 'MTY' THEN 1
                                ELSE NULL END) AS mty,


                                (CASE WHEN  height='8.600' AND  size = '20'  THEN 1
                                ELSE NULL END) AS tot_20_85,

                                (CASE WHEN  height='9.600' AND  size = '20' THEN 1
                                ELSE NULL END) AS tot_20_95,

                                (CASE WHEN  height='8.600' AND  size = '40'  THEN 1
                                ELSE NULL END) AS tot_40_85,

                                (CASE WHEN  height='9.600' AND  size = '40'  THEN 1
                                ELSE NULL END) AS tot_40_95,

                                (CASE WHEN  height='8.600' AND  size = '45'  THEN 1
                                ELSE NULL END) AS tot_45_85,

                                (CASE WHEN  height='9.600' AND  size = '45'  THEN 1
                                ELSE NULL END) AS tot_45_95

                                FROM ctmsmis.mis_billing_details
                                WHERE  draftNumber='$draftNumber') AS cancel";
                                $summary_bill_detail=$this->bm->dataSelect($summary_bill);	
				$this->data['summary_bill_detail']=$summary_bill_detail;				
					
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";		
				$print_time=$this->bm->dataSelect($bill_print_time);	
				$this->data['print_time']=$print_time;	
                         }
				else if($draft_detail_view=='pdfPangoanStatusChangePCTToCPAInvoice')
						{
                           $sql_detail="SELECT DISTINCT id AS unitId,gkey,freight_kind AS freightKind,'DRAFT' AS STATUS,'Status Change Bill (PCT to CPA)' AS invoiceDesc,draftNumber,IF(depo_date IS NULL,draftNumber,CONCAT(draftNumber,'R')) AS billNumber,vsl_name AS ibCarrierName,depo_date,
                            mlo AS customerId,mlo_name AS customerName,agent_code AS concustomerid,agent AS concustomername,
                            rotation AS ibVisitId,(SELECT DATE_FORMAT(billing_date, '%d-%m-%Y') AS billing_date FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS created,size AS isoLength,LEFT(height,3) AS isoHeight,DATE_FORMAT(cl_date, '%d-%m-%Y') AS timeIn,fcy_time_out AS timeOut,
                            pre_imp_rot AS imp_rot,
                            DATE_FORMAT(fcy_time_in, '%d-%m-%Y') AS imp_ata,
                            IF(DATEDIFF(cl_date,IFNULL(fcy_time_in,DATE_ADD(cl_date,INTERVAL 4 DAY)))+1<1,'0',DATEDIFF(cl_date,IFNULL(fcy_time_in,DATE_ADD(cl_date,INTERVAL 4 DAY)))+1) AS days,
                            wpn AS equipment,
                            (SELECT sparcsn4.inv_goods.destination 
                            FROM sparcsn4.inv_unit 
                            INNER JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
                            WHERE sparcsn4.inv_unit.gkey=ctmsmis.mis_billing_details.gkey) AS preloc,
                            vatperc,iso_grp,
                            (CASE
                                    WHEN iso_grp = 'UT' THEN 'OPEN TOP'
                                    WHEN iso_grp IN ('RE','RT') THEN 'REEFER'
                                    WHEN iso_grp IN ('PL','PC','PC') THEN 'F-RACK'
                                    WHEN iso_grp IN ('TN','TD','TG') THEN 'TANK'
                                    ELSE NULL
                            END) AS cnttype

                            FROM ctmsmis.mis_billing_details
                            WHERE draftNumber='$draftNumber' AND description LIKE 'Status%' ORDER BY draftNumber";
                        
                           $summary_bill="SELECT
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
                            (SELECT (COUNT(chargeEntityId)-COUNT(LON))) AS NLON
                            FROM
                            (
                            SELECT DISTINCT id AS chargeEntityId,

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
                            IF(destination NOT IN('2591','2592','5230','5231','5232','5233','5234','5235','5236','5237','5238') AND freight_kind !='MTY',1,NULL) AS LON
                            FROM
                            (
                            SELECT * FROM ctmsmis.mis_billing_details WHERE draftNumber='$draftNumber' AND description LIKE (CASE WHEN invoice_type=112 THEN 'Load%' WHEN invoice_type=120 THEN 'Load%' WHEN invoice_type=108 THEN 'Discharging%' ELSE 'Status%' END )
                            ) tbl
                            ) final";
                                $summary_bill_detail=$this->bm->dataSelect($summary_bill);	
				$this->data['summary_bill_detail']=$summary_bill_detail;				
					
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";		
				$print_time=$this->bm->dataSelect($bill_print_time);	
				$this->data['print_time']=$print_time;	

               }

			//SOURAV
			else if($draft_detail_view=='pdfOffhireInvoice')
			{
				
				$sql_detail="SELECT DISTINCT unitId,freightKind,invoiceList,status,draftNumber,ibCarrierName,concustomerid,concustomername,
				customerId,customerName,ibVisitId,isoHeight,berth,isoLength,'OFFHIRE DATA FORMAT FOR PREPARATION OF AGENT BILL DATE WISE' as invoiceDesc,

				(CASE WHEN  (SELECT carrier_mode
							FROM sparcsn4.inv_unit inv
							INNER JOIN sparcsn4.inv_unit_fcy_visit fcy ON fcy.unit_gkey=inv.gkey 
							INNER JOIN sparcsn4.argo_carrier_visit acv ON fcy.actual_ib_cv=acv.gkey
							WHERE inv.id=final.unitId AND inv.gkey=final.unit_gkey AND category='STRGE') IN ('TRAIN','VESSEL')
						THEN ''
					ELSE
						timeIn END) AS timeIn,


				(CASE WHEN  (SELECT carrier_mode
							FROM sparcsn4.inv_unit inv
							INNER JOIN sparcsn4.inv_unit_fcy_visit fcy ON fcy.unit_gkey=inv.gkey 
							INNER JOIN sparcsn4.argo_carrier_visit acv ON fcy.actual_ib_cv=acv.gkey
							WHERE inv.id=final.unitId AND inv.gkey=final.unit_gkey AND category='STRGE') IN ('VESSEL')
						THEN timeIn
					ELSE
						'' END) AS timeIn_pan,
						
				(CASE WHEN  (SELECT carrier_mode
							FROM sparcsn4.inv_unit inv
							INNER JOIN sparcsn4.inv_unit_fcy_visit fcy ON fcy.unit_gkey=inv.gkey 
							INNER JOIN sparcsn4.argo_carrier_visit acv ON fcy.actual_ib_cv=acv.gkey
							WHERE inv.id=final.unitId AND inv.gkey=final.unit_gkey AND category='STRGE') IN ('TRAIN')
						THEN timeIn
					ELSE
						'' END) AS timeIn_icd,

				billingDate,exchangeRate,depoName,
				IF(freightKind='LCL','',eventTo) AS eventTo,
				unstuffingDate,yardOutDate,yardOutDate1,
				(IF(freightKind='FCL',
					(CASE WHEN  (SELECT carrier_mode
							FROM sparcsn4.inv_unit inv
							INNER JOIN sparcsn4.inv_unit_fcy_visit fcy ON fcy.unit_gkey=inv.gkey 
							INNER JOIN sparcsn4.argo_carrier_visit acv ON fcy.actual_ib_cv=acv.gkey
							WHERE inv.id=final.unitId AND inv.gkey=final.unit_gkey AND category='STRGE') IN ('TRAIN','VESSEL')
						THEN DATEDIFF(yardOutDate1,eventTo)+1
					ELSE
						DATEDIFF(yardOutDate1,eventTo) END),
					
					IF(freightKind='LCL',DATEDIFF(yardOutDate1,eventTo)+1,DATEDIFF(yardOutDate1,eventTo)+1))) AS days
				FROM (
				SELECT id AS unitId,details.gkey AS unit_gkey,
				(SELECT sparcsn4.inv_unit.freight_kind FROM sparcsn4.inv_unit
					WHERE id=details.id AND sparcsn4.inv_unit.gkey < details.gkey AND category='IMPRT' 
					ORDER BY sparcsn4.inv_unit.gkey DESC LIMIT 1) AS freightKind,
				'OFFHIRE CHARGES ON CONTAINER' AS invoiceList,'DRAFT' AS STATUS,
				draftNumber,
				vsl_name AS ibCarrierName,
				agent_code AS concustomerid,
				agent AS concustomername,
				mlo AS customerId,mlo_name AS customerName,
				rotation AS ibVisitId,height AS isoHeight,
				berth,
				size AS isoLength,
				(SELECT DATE(fcy.time_in) 
					FROM sparcsn4.inv_unit inv
					INNER JOIN sparcsn4.inv_unit_fcy_visit fcy ON fcy.unit_gkey=inv.gkey 
						WHERE inv.id=details.id AND sparcsn4.inv.gkey < details.gkey  AND category='IMPRT'  ORDER BY sparcsn4.inv.gkey DESC LIMIT 1
				) AS timeIn,
				DATE(billingDate) AS billingDate,

				(SELECT MAX(exchangeRate) FROM ctmsmis.mis_billing_details WHERE draftNumber='$draftNumber') AS exchangeRate,depo_name AS depoName,

				(SELECT DATE(fcy.time_in) 
					FROM sparcsn4.inv_unit inv
					INNER JOIN sparcsn4.inv_unit_fcy_visit fcy ON fcy.unit_gkey=inv.gkey 
						WHERE inv.id=details.id AND sparcsn4.inv.gkey=details.gkey  AND category='STRGE'  ORDER BY sparcsn4.inv.gkey DESC LIMIT 1
				) AS eventTo,

				(select if(mis_inv_unit.freight_kind='LCL',date(mis_inv_unit.stripp_unstuff_dt),'') from ctmsmis.mis_inv_unit  
						where mis_inv_unit.category='IMPRT'  and fcy_transit_state in('S99_RETIRED','S70_DEPARTED')
						and mis_inv_unit.id=details.id order by mis_inv_unit.gkey desc limit 1
				) AS unstuffingDate,

				(SELECT DATE(fcy.time_out) 
					FROM sparcsn4.inv_unit inv
					INNER JOIN sparcsn4.inv_unit_fcy_visit fcy ON fcy.unit_gkey=inv.gkey 
						WHERE inv.id=details.id AND sparcsn4.inv.gkey=details.gkey  AND category='STRGE'  ORDER BY sparcsn4.inv.gkey DESC LIMIT 1
				) AS delv_dt_for_mty,

				DATE(fcy_time_out) AS yardOutDate1,
				  
				(SELECT DATE(MIN(fcy_time_out)) FROM ctmsmis.mis_billing_details WHERE draftNumber='$draftNumber') AS yardOutDate
				FROM
				(
				SELECT * FROM ctmsmis.mis_billing_details WHERE draftNumber='$draftNumber' AND description LIKE 'LIFT%' ORDER BY id
				)

				AS details
				) AS final";
                
				//echo $sql_detail;
				
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";		
				$print_time=$this->bm->dataSelect($bill_print_time);	
				$this->data['print_time']=$print_time;	
			}
			else if($draft_detail_view=='pdfDraftOffdockToMuktarpurStatusChangeInvoice')
			{
				
				//pdfDraftOffdockToMuktarpurStatusChangeInvoice
				//echo 	$draft_detail_view;
				$sql_detail="select distinct id as unitId,draftNumber as draftNumber,'STATUS CHANGE INVOICE (OFFDOCK TO MUKTARPUR)' as invoiceDesc,
				vsl_name as ibCarrierName,rotation as ibVisitId,mlo as customerId,mlo_name as customerName,
				(select billing_Date from ctmsmis.mis_billing where draft_id='$draftNumber') as created,
				agent_code as concustomerid,agent as concustomername,'DRAFT' as status,size as isoLength,height as isoHeight,
				freight_kind as freightKind,date(fcy_time_in) as timeIn,cl_date as cl_date,DATE_ADD(cl_date,INTERVAL 4 DAY) as eventFrom,
				fcy_time_out as eventTo,
				DATEDIFF(cl_date,fcy_time_in)+1 AS days,
				datediff(fcy_time_out,DATE_ADD(cl_date,INTERVAL 4 DAY))+1 as days_old,
				vatperc as vatperc
				from ctmsmis.mis_billing_details where draftNumber='$draftNumber'";
                
			
                $summary_bill="SELECT
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
				select * from ctmsmis.mis_billing_details where draftNumber='$draftNumber' and description LIKE (CASE WHEN invoice_type=112 THEN 'Load%' WHEN invoice_type=120 THEN 'Load%' WHEN invoice_type=108 THEN 'Discharging%' WHEN invoice_type=128 THEN 'Discharging%' ELSE 'Status%' END )
				) tbl
				) final";
                $summary_bill_detail=$this->bm->dataSelect($summary_bill);	
				$this->data['summary_bill_detail']=$summary_bill_detail;				
					
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";		
				$print_time=$this->bm->dataSelect($bill_print_time);	
				$this->data['print_time']=$print_time;	
			}
			//SOURAV
			else if($draft_detail_view=='pdfDraftMukterpulDischargeInvoice')		//MUKTARPUR CONT DISCHARGE - 07-01-2019		//intakhab
			{
				$sql_detail="SELECT id AS unitId,gkey,freight_kind AS freightKind,'DRAFT' AS STATUS,'Container Discharging Bill (Muktarpur)' AS invoiceDesc,draftNumber,vsl_name AS ibCarrierName,
				mlo AS customerId,mlo_name AS customerName,agent_code AS concustomerid,agent AS concustomername,
				rotation AS ibVisitId,billingDate AS created,size AS isoLength,height AS isoHeight,
				wpn AS equipment,DATE(fcy_time_in) AS fcy_time_in,
				(SELECT sparcsn4.inv_goods.destination 
				FROM sparcsn4.inv_unit 
				INNER JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
				WHERE sparcsn4.inv_unit.gkey=mis_billing_details.gkey) AS preloc,
				vatperc,iso_grp,
				(CASE
						WHEN iso_grp = 'UT' THEN 'OPEN TOP'
						WHEN iso_grp IN ('RE','RT') THEN 'REEFER'
					WHEN iso_grp IN ('PL','PC','PC') THEN 'F-RACK'
					WHEN iso_grp IN ('TN','TD','TG') THEN 'TANK'
						ELSE NULL
				END) AS cnttype,
				(SELECT DATE(billing_date) FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS billing_date

				FROM ctmsmis.mis_billing_details
				WHERE draftNumber='$draftNumber' ORDER BY draftNumber";
				
				$summary_bill="SELECT
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
				(SELECT (COUNT(chargeEntityId)-COUNT(LON))) AS NLON
				FROM
				(
				SELECT DISTINCT id AS chargeEntityId,

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
				IF(destination NOT IN('2591','2592','5230','5231','5232','5233','5234','5235','5236','5237','5238') AND freight_kind !='MTY',1,NULL) AS LON
				FROM
				(
				SELECT * FROM ctmsmis.mis_billing_details WHERE draftNumber='$draftNumber' AND description LIKE (CASE WHEN invoice_type=112 THEN 'Load%' WHEN invoice_type=120 THEN 'Load%' WHEN invoice_type=108 THEN 'Discharging%' WHEN invoice_type=128 THEN 'Discharging%' ELSE 'Status%' END )
				) tbl
				) final";
				
				$summary_bill_detail=$this->bm->dataSelect($summary_bill);	
				$this->data['summary_bill_detail']=$summary_bill_detail;				
					
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";		
				$print_time=$this->bm->dataSelect($bill_print_time);	
				$this->data['print_time']=$print_time;
			}
			else if($draft_detail_view=='pdfMukhterpoleLoadingInvoice')		//MUKTARPUR CONT LOAD - 07-01-2019		//intakhab
			{
				$sql_detail="SELECT DISTINCT id AS unitId,gkey,freight_kind AS freightKind,'DRAFT' AS STATUS,'Container Loading Bill (Muktarpur)' AS invoiceDesc,draftNumber,IF(depo_date IS NULL,draftNumber,CONCAT(draftNumber,'R')) AS billNumber,vsl_name AS ibCarrierName,depo_date,
				mlo AS customerId,mlo_name AS customerName,agent_code AS concustomerid,agent AS concustomername,
				rotation AS ibVisitId,(SELECT DATE(billing_date) FROM ctmsmis.mis_billing WHERE draft_id='$draftNumber') AS created,size AS isoLength,height AS isoHeight,cl_date AS timeIn,DATE(fcy_time_out) AS timeOut,
				pre_imp_rot AS imp_rot,
				DATE(pre_imp_ata) AS imp_ata,
				IF(DATEDIFF(fcy_time_out,IFNULL(depo_date,DATE_ADD(cl_date,INTERVAL 4 DAY)))+1<1,'0',DATEDIFF(fcy_time_out,IFNULL(depo_date,DATE_ADD(cl_date,INTERVAL 4 DAY)))+1) AS days,
				wpn AS equipment,
				(SELECT sparcsn4.inv_goods.destination 
				FROM sparcsn4.inv_unit 
				INNER JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
				WHERE sparcsn4.inv_unit.gkey=mis_billing_details.gkey) AS preloc,
				vatperc,iso_grp,
				(CASE
						WHEN iso_grp = 'UT' THEN 'OPEN TOP'
						WHEN iso_grp IN ('RE','RT') THEN 'REEFER'
					WHEN iso_grp IN ('PL','PC','PC') THEN 'F-RACK'
					WHEN iso_grp IN ('TN','TD','TG') THEN 'TANK'
						ELSE NULL
				END) AS cnttype

				FROM ctmsmis.mis_billing_details
				WHERE draftNumber='$draftNumber' AND description LIKE 'Load%' ORDER BY draftNumber";
				
				$summary_bill="SELECT
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
				(SELECT (COUNT(chargeEntityId)-COUNT(LON))) AS NLON
				FROM
				(
				SELECT DISTINCT id AS chargeEntityId,

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
				IF(destination NOT IN('2591','2592','5230','5231','5232','5233','5234','5235','5236','5237','5238') AND freight_kind !='MTY',1,NULL) AS LON
				FROM
				(
				SELECT * FROM ctmsmis.mis_billing_details WHERE draftNumber='$draftNumber' AND description LIKE (CASE WHEN invoice_type=112 THEN 'Load%' WHEN invoice_type=120 THEN 'Load%' WHEN invoice_type=108 THEN 'Discharging%' WHEN invoice_type=128 THEN 'Discharging%' ELSE 'Status%' END )
				) tbl
				) final";
				
				$summary_bill_detail=$this->bm->dataSelect($summary_bill);	
				$this->data['summary_bill_detail']=$summary_bill_detail;				
					
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";		
				$print_time=$this->bm->dataSelect($bill_print_time);	
				$this->data['print_time']=$print_time;
			}
			//echo $sql_detail;
			
			else if($draft_detail_view=='pdfExportStorageInvoice')
			{
				   $sql_detail="SELECT DISTINCT draftNumber,
					'DRAFT' AS STATUS,
					'EXPORT STORAGE INVOICE' AS invoiceDesc,
					id AS unitId, 
					freight_kind AS freightKind,
					height AS isoHeight,
					size AS isoLength,
					vsl_name AS obCarrierName,
					arcar_id AS obVisitId,
					vat AS vatperc,
					DATE(billingDate) AS created,
					DATE(fcy_time_in) AS eventFrom,
					DATE(atd) AS eventTo,
					arcar_id AS vslId,
					agent_code AS concustomername,
					agent AS concustomerid,
					mlo AS customerName,mlo_name AS customerId,
					ABS((DATE(atd) - ( DATE(fcy_time_in) + 1)))  AS days

					FROM 
					(
						SELECT * FROM ctmsmis.mis_billing_details WHERE mis_billing_details.draftNumber='$draftNumber' AND description LIKE 'storage%'
					) AS T";
				
			
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";		
				$print_time=$this->bm->dataSelect($bill_print_time);	
				$this->data['print_time']=$print_time;	
				 }
			$rslt_detail=$this->bm->dataSelect($sql_detail);	
			
			$this->data['rslt_detail']=$rslt_detail;			  
		
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
			else if($draft_detail_view=='pdfPangoanDischargeInvoice')
			{
				$html=$this->load->view('container_rptPangoanDischargingDraftDetailsInvoice',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
				$pdfFilePath ="containerBill-".time()."-download.pdf";
			}
			else if($draft_detail_view=="pdfPangoanLoadingInvoice")
			{
				$html=$this->load->view('container_rptPangoanLoadingDraftDetailsInvoice',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
				$pdfFilePath ="containerBill-".time()."-download.pdf";
			}
			else if($draft_detail_view=="pdfDraftICDInvoice")
			{
				$html=$this->load->view('rptICDDraftDetailsInvoice',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
				$pdfFilePath ="containerBill-".time()."-download.pdf";
			}
			                        // new bill detail-------------
             else if($draft_detail_view=='pdfPangoanStatusChangeInvoice')
               {
                 $html=$this->load->view('container_statusChangeRptPangaonLoadingDraftDetailsInvoice',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
                 $pdfFilePath ="containerBill-".time()."-download.pdf";
                            
               }
            else if($draft_detail_view=='pdfStatucChangeCPAToICDInvoice')
               {
                 $html=$this->load->view('container_rptStatusDraftDetailsInvoiceCPAtoICD',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
                 $pdfFilePath ="containerBill-".time()."-download.pdf";
               } 
            else if($draft_detail_view=='pdfStatucChangeLCLToFCLInvoice')
               {
                  $html=$this->load->view('container_rptStatusDraftDetailsInvoiceLCLtoFCL',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
                 $pdfFilePath ="containerBill-".time()."-download.pdf";
               }
            else if($draft_detail_view=='pdfStatucChangeFCLToLCLInvoice')
               {
				   $html=$this->load->view('container_rptStatusDraftDetailsInvoiceFCLtoLCL',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
				   $pdfFilePath ="containerBill-".time()."-download.pdf";
               }
			else if($draft_detail_view=='pdfPangoanStatusChangePCTToCPAInvoice')
               {
                    $html=$this->load->view('container_rptPangoanStatusChangePCTToCPADraftDetailsInvoice',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
                    $pdfFilePath ="containerBill-".time()."-download.pdf";
               }	   
			//SOURAV
			else if($draft_detail_view=='pdfOffhireInvoice')
			{
				$html=$this->load->view('container_OffhireDraftDetailsInvoice',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
                $pdfFilePath ="offhireBillDetails-".time()."-download.pdf";
			}
			else if($draft_detail_view=='pdfDraftOffdockToMuktarpurStatusChangeInvoice')
			{
				$html=$this->load->view('container_rptStatusChangeOffdockToMuktarpurDraftDetailsInvoice',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
                $pdfFilePath ="OffdockToMuktarpurDetails-".time()."-download.pdf";
			}
			//SOURAV
			else if($draft_detail_view=='pdfDraftMukterpulDischargeInvoice')		//MUKTARPUR CONT DISCHARGE - 07-01-2019		//intakhab
			{
				$html=$this->load->view('mukhtarpur_cont_discharge_detail',$this->data, true); 
				$pdfFilePath ="mukhtarpurContDischargeDetail-".time()."-download.pdf";
			}
			else if($draft_detail_view=='pdfMukhterpoleLoadingInvoice')		//MUKTARPUR CONT LOAD - 07-01-2019		//intakhab
			{
				$html=$this->load->view('mukhtarpur_cont_load_detail',$this->data, true); 
				$pdfFilePath ="mukhtarpurContLoadingDetail-".time()."-download.pdf";
			}
			else if($draft_detail_view=='pdfExportStorageInvoice')
			{

				$html=$this->load->view('rptExportStorageDraftDetailInvoice',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
				$pdfFilePath ="exportStorageDetail-".time()."-download.pdf";
			}
			
			$pdf = $this->m_pdf->load();
			$pdf->SetWatermarkText('CPA CTMS');		
			$pdf->showWatermarkText = true;
			if($draft_detail_view=='pdfOffhireInvoice')
			{
				$pdf->AddPage('L', // L - landscape, P - portrait
					'', '', '', '',
					15, // margin_left
					10, // margin right
					10, // margin top
					10, // margin bottom
					18, // margin header
					12); // margin footer  
			}
			$pdf->useSubstitutions = true; 
			
			$stylesheet = file_get_contents('resources/styles/test.css'); 
			
			$pdf->setFooter('||Page {PAGENO} of {nb}');
			$pdf->WriteHTML($stylesheet,1);
			$pdf->WriteHTML($html,2);
			
			$pdf->Output($pdfFilePath, "I"); // For Show Pdf
		}
	}
	
	// Container Billing List End
	
	//Container Bill List (Version) start
	function containerBillListVersion()
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
			
			$sql_row_num="SELECT count(id) as rtnValue 
			FROM  ctmsmis.backup_mis_billing 
			INNER JOIN ctmsmis.billingreport ON ctmsmis.billingreport.id = ctmsmis.backup_mis_billing.bill_type ";
		//	echo "<br>";
			$config["total_rows"] = $this->bm->dataReturn($sql_row_num);
			//$r = $this->bm->dataReturn($sql_row_num);
			//echo $r;
			$segment_three = $this->uri->segment(3);
			
			$config = array();
			$config["base_url"] = site_url("report/containerBillListVersion/$segment_three");
			$config["total_rows"] = $this->bm->dataReturn($sql_row_num);
			$config["per_page"] = 20;
			$offset = $this->uri->segment(4, 0);
			$config["uri_segment"] = 4;
			$limit=$config["per_page"];
			
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			$start=$page;
			
			$sql_bill_list="SELECT imp_rot,exp_rot,bill_type,mlo_code,draft_id,IFNULL(created_user,'') AS created_user, draft_final_status,pdf_draft_view_name,pdf_detail_view_name, DATE(billing_date) AS billing_date, billingreport.billtype,version,modification_type
			FROM ctmsmis.backup_mis_billing 
			INNER JOIN ctmsmis.billingreport ON ctmsmis.billingreport.id = ctmsmis.backup_mis_billing.bill_type 
			ORDER BY ctmsmis.backup_mis_billing.draft_id DESC limit $start,$limit";

			$rslt_bill_list=$this->bm->dataSelect($sql_bill_list);
			$data['rslt_bill_list']=$rslt_bill_list;
			$data['start']=$start;
			$data["links"] = $this->pagination->create_links();
			
			$this->load->view('header5');
			$this->load->view('containerBillListVersion',$data);
			$this->load->view('footer_1');
		}
	}
	
	function searchBillofContainerVersion()
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
			
			$sql_bill_list="SELECT imp_rot,exp_rot,bill_type,mlo_code,draft_id,IFNULL(created_user,'') AS created_user, draft_final_status,pdf_draft_view_name,pdf_detail_view_name,DATE(billing_date) AS billing_date, billingreport.billtype,version,modification_type
			FROM ctmsmis.backup_mis_billing 
			INNER JOIN ctmsmis.billingreport ON ctmsmis.billingreport.id = ctmsmis.backup_mis_billing.bill_type ".$cond." ORDER BY backup_mis_billing.draft_id DESC ";
	
			$rslt_bill_list=$this->bm->dataSelect($sql_bill_list);
			
			$data['rslt_bill_list']=$rslt_bill_list; 
			$this->load->view('header5');
			$this->load->view('containerBillListVersion',$data);
			$this->load->view('footer_1');
		}
	}
	
	function viewContainerBillVersion()
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
		//echo "<br>";
			$version=$this->input->post('version');
						
			$this->load->library('m_pdf');
			$pdf->use_kwt = true;
			//echo $draftNumber."".$bill_type."".$cnt_code;
			//return;
			if($draft_view=='pdfDraftICDInvoice')
			{
				$bill_sql="select qty,amt,vat,status,draftNumber,ibCarrierName,customerId,customerName,
				payCustomerId,payCustomername,Particulars,
				if(exchangeRate=1,ifnull((SELECT rate FROM billing.bil_currency_exchange_rates WHERE DATE(effective_date)=DATE(final.final.currency_date)),(SELECT rate FROM billing.bil_currency_exchange_rates ORDER BY effective_date DESC LIMIT 1)),exchangeRate) as exchangeRate,
				rateBilled,chargeEventTypeId,
				date(billingDate) as billingDate,invoiceDesc,ibVisitId,height,berth,atd,ata,size,qtytot20,qtytot40,qtytot45,
				usd,eventPerformDate,comments,discharge_done,storage_days
				from
				(
				SELECT count(description) AS qty ,sum(amt) AS amt,IFNULL(sum(vat),0) AS vat,
				'DRAFT' as status,draftNumber,vsl_name as ibCarrierName,mlo as customerId,
				mlo_name as customerName,agent_code as payCustomerId,agent as payCustomername,
				description as Particulars,
				CAST((select max(exchangeRate) from ctmsmis.backup_mis_billing_details dtl where draftNumber='$draftNumber') AS DECIMAL(10,4)) AS exchangeRate,

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

				id as chargeEventTypeId,billingDate,'ICD Bill' as invoiceDesc,
				rotation as ibVisitId,height,berth,atd,ata,size,ata as currency_date,


				(select count(distinct id) from ctmsmis.backup_mis_billing_details dtl
				where draftNumber='$draftNumber'
				and size=20 and dtl.mlo=details.mlo and version='$version'
				and fcy_time_in is not null
				) as qtytot20,
				(select count(distinct id) from ctmsmis.backup_mis_billing_details dtl
				where draftNumber='$draftNumber'
				and size=40 and dtl.mlo=details.mlo and version='$version'
				and fcy_time_in is not null
				) as qtytot40,

				(select count(distinct id) from ctmsmis.backup_mis_billing_details dtl
				where draftNumber='$draftNumber'
				and size=45 and dtl.mlo=details.mlo and version='$version'
				and fcy_time_in is not null
				) as qtytot45,


				if(currency_gkey=2,'$','') as usd,
				max(fcy_time_out) AS eventPerformDate,

				'' AS comments,
				cl_date as discharge_done,if(storage_days = 0 ,NULL,storage_days) AS storage_days

				FROM
				(
				select * from ctmsmis.backup_mis_billing_details where draftNumber='$draftNumber' and version='$version'
				)

				AS details group by draftNumber,Particulars,height order by payCustomerId,Particulars,height asc
				)as final";
			//	return;
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";
			}
			
			$bill_rslt=$this->bm->dataSelect($bill_sql);	
			$print_time=$this->bm->dataSelect($bill_print_time);	
			$this->data['bill_rslt']=$bill_rslt;			
			$this->data['print_time']=$print_time;			
			
			if($draft_view=='pdfDraftICDInvoice')
			{
				$html=$this->load->view('icdbillversion',$this->data, true); 
				$pdfFilePath ="icdbill-".time()."-download.pdf";
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
	
	function viewContainerDetailVersion()
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
			$version=$this->input->post('version');
					
			$this->load->library('m_pdf');
			$pdf->use_kwt = true;
	
			if($draft_detail_view=='pdfDraftICDInvoice')
			{
				$sql_detail="select draftNumber,'DRAFT' as status,description as invoiceDesc,id as unitId,
				freight_kind as freightKind,height as isoHeight,size as isoLength,vsl_name as ibCarrierName,
				rotation as ibVisitId,vatperc,date(billingDate) as created,
				agent as concustomername,agent_code as concustomerid,
				mlo_name as customerName,mlo as customerId,date(fcy_time_in) as timeIn,date(fcy_time_out) as timeOut,
				(select last_pos_locid from sparcsn4.inv_unit_fcy_visit where unit_gkey=backup_mis_billing_details.gkey) as wagon,version
				from ctmsmis.backup_mis_billing_details
				where draftNumber='$draftNumber' and version='$version' and description like 'LIFT%'";
												
				$summary_bill="select 
							count(fcl_20_85) as  fcl_20_85,
							count(fcl_20_95) as  fcl_20_95,
							count(fcl_40_85) as  fcl_40_85,
							count(fcl_40_95) as  fcl_40_95,
							count(fcl_45_85) as  fcl_45_85,
							count(fcl_45_95) as  fcl_45_95,

							count(lcl_20_85) as  lcl_20_85,
							count(lcl_20_95) as  lcl_20_95,
							count(lcl_40_85) as  lcl_40_85,
							count(lcl_40_95) as  lcl_40_95,
							count(lcl_45_85) as  lcl_45_85,
							count(lcl_45_95) as  lcl_45_95,

							count(mty_20_85) as  mty_20_85,
							count(mty_20_95) as  mty_20_95,
							count(mty_40_85) as  mty_40_85,
							count(mty_40_95) as  mty_40_95,
							count(mty_45_85) as  mty_45_85,
							count(mty_45_95) as  mty_45_95,

							count(chargeEntityId) as tot,
							count(fcl) as  fcl,
							count(lcl) as  lcl,
							count(mty) as  mty,
							count(tot_20_85) as  tot_20_85,
							count(tot_20_95) as  tot_20_95,
							count(tot_40_85) as  tot_40_85,
							count(tot_40_95) as  tot_40_95,
							count(tot_45_85) as  tot_45_85,
							count(tot_45_95) as  tot_45_95
							 from
							(select distinct id as chargeEntityId,

							(CASE WHEN height='8.6' AND size = '20' AND freight_kind = 'FCL' THEN 1
							ELSE NULL END) AS fcl_20_85,

							(CASE WHEN height='9.6' AND size = '20' AND freight_kind = 'FCL' THEN 1
							ELSE NULL END) AS fcl_20_95,

							(CASE WHEN height='8.6' AND size = '40' AND freight_kind = 'FCL' THEN 1
							ELSE NULL END) AS fcl_40_85,

							(CASE WHEN height='9.6' AND size = '40' AND freight_kind = 'FCL' THEN 1
							ELSE NULL END) AS fcl_40_95,

							(CASE WHEN height='8.6' AND size = '45' AND freight_kind = 'FCL' THEN 1
							ELSE NULL END) AS fcl_45_85,

							(CASE WHEN height='9.6' AND size = '45' AND freight_kind = 'FCL' THEN 1
							ELSE NULL END) AS fcl_45_95,

							(CASE WHEN height='8.6' AND size = '20' AND freight_kind = 'LCL' THEN 1
							ELSE NULL END) AS lcl_20_85,

							(CASE WHEN height='9.6' AND size = '20' AND freight_kind = 'LCL' THEN 1
							ELSE NULL END) AS lcl_20_95,

							(CASE WHEN height='8.6' AND size = '40' AND freight_kind = 'LCL' THEN 1
							ELSE NULL END) AS lcl_40_85,

							(CASE WHEN height='9.6' AND size = '40' AND freight_kind = 'LCL' THEN 1
							ELSE NULL END) AS lcl_40_95,

							(CASE WHEN height='8.6' AND size = '45' AND freight_kind = 'LCL' THEN 1
							ELSE NULL END) AS lcl_45_85,

							(CASE WHEN height='9.6' AND size = '45' AND freight_kind = 'LCL' THEN 1
							ELSE NULL END) AS lcl_45_95,

							(CASE WHEN height='8.6' AND size = '20' AND freight_kind = 'MTY' THEN 1
							ELSE NULL END) AS mty_20_85,

							(CASE WHEN height='9.6' AND size = '20' AND freight_kind = 'MTY' THEN 1
							ELSE NULL END) AS mty_20_95,

							(CASE WHEN height='8.6' AND size = '40' AND freight_kind = 'MTY' THEN 1
							ELSE NULL END) AS mty_40_85,

							(CASE WHEN height='9.6' AND size = '40' AND freight_kind = 'MTY' THEN 1
							ELSE NULL END) AS mty_40_95,

							(CASE WHEN height='8.6' AND size = '45' AND freight_kind = 'MTY' THEN 1
							ELSE NULL END) AS mty_45_85,

							(CASE WHEN height='9.6' AND size = '45' AND freight_kind = 'MTY' THEN 1
							ELSE NULL END) AS mty_45_95,

							(CASE WHEN freight_kind = 'FCL' THEN 1
							ELSE NULL END) AS fcl,

							(CASE WHEN freight_kind = 'LCL' THEN 1
							ELSE NULL END) AS lcl,

							(CASE WHEN freight_kind = 'MTY' THEN 1
							ELSE NULL END) AS mty,


							(CASE WHEN height='8.6' AND size = '20'  THEN 1
							ELSE NULL END) AS tot_20_85,

							(CASE WHEN height='9.6' AND size = '20' THEN 1
							ELSE NULL END) AS tot_20_95,

							(CASE WHEN height='8.6' AND size = '40'  THEN 1
							ELSE NULL END) AS tot_40_85,

							(CASE WHEN height='9.6' AND size = '40'  THEN 1
							ELSE NULL END) AS tot_40_95,

							(CASE WHEN height='8.6' AND size = '45'  THEN 1
							ELSE NULL END) AS tot_45_85,

							(CASE WHEN height='9.6' AND size = '45'  THEN 1
							ELSE NULL END) AS tot_45_95

							from ctmsmis.backup_mis_billing_details
							where draftNumber='$draftNumber' and version='$version' and description like 'LIFT%' ) as destais";	
				
				$summary_bill_detail=$this->bm->dataSelect($summary_bill);	
				$this->data['summary_bill_detail']=$summary_bill_detail;				
					
				$bill_print_time="SELECT DATE_FORMAT(now(), '%W %M %e %Y %H:%i') as Time";		
				$print_time=$this->bm->dataSelect($bill_print_time);	
				$this->data['print_time']=$print_time;				
			}	
			
			$rslt_detail=$this->bm->dataSelect($sql_detail);	
			
			$this->data['rslt_detail']=$rslt_detail;			  
		
			if($draft_detail_view=="pdfDraftICDInvoice")
			{
				$html=$this->load->view('rptICDDraftDetailsInvoiceVersion',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
				$pdfFilePath ="containerBill-".time()."-download.pdf";
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
	
	
	//Container Bill List (Version) end
	
	// Update Bill Final STATUS
	function updateBillFinalStatus()
	{

		$sql_query="SELECT draft_id,billing_date,NOW() AS curr_date,DATEDIFF(DATE(NOW()), DATE(billing_date))+1 AS no_of_day
		FROM ctmsmis.mis_billing
		WHERE draft_final_status=0
		ORDER BY draft_id DESC";
		$rtnQuery=$this->bm->dataSelect($sql_query);
		for($i=0;$i<count($rtnQuery);$i++)
		{
			if($rtnQuery[$i]['no_of_day']>7)
			{
				//echo $rtnQuery[$i]['draft_id']."\n";
				$sql_update="UPDATE ctmsmis.mis_billing 
				SET draft_final_status=1
				WHERE draft_id=".$rtnQuery[$i]['draft_id'];
				
				//echo $sql_update."\n";
				$this->bm->dataInsert($sql_update);
			}
			else{
				//echo "NOT";
			}
		}
		
	}
	
	
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