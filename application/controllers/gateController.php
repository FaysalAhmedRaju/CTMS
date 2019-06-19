<?php

class gateController extends CI_Controller {
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
        
        function index(){
		 $this->gate();
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
		
		
		function gateOut()
		{
		    $session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['title']="GATE OUT...";
				//echo $data['title'];
				$this->load->view('header5');
				$this->load->view('gateOutView',$data);
				$this->load->view('footer_1');
			}	
		}
		
		
		
		function gateOutView()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
				{
					$this->logout();
				}
			else
				{
				$verifyNo=$this->input->post('verifyNo');
				//echo $rotNo;	
				 $tableFlag=1;
				
				 $strSelect="select import_rotation,cont_number,rcv_pack,flt_pack,shed_loc,if(loc_first=1,'Yes','No') as loc_first,Pack_Number,Pack_Description,weight,Notify_name,
				 Notify_address, Consignee_name from shed_tally_info inner join igm_supplimentary_detail on igm_supplimentary_detail.id=shed_tally_info.igm_sup_detail_id 
				 where verify_number='$verifyNo'";
								
				 $stat = $this->bm->dataSelectDb1($strSelect);
				 
				 if($stat>=1)
				 {
					 $verifyStatusList=$stat;
				 }
				 else
				 {
					$strSelect="select import_rotation,cont_number,rcv_pack,flt_pack,shed_loc,if(loc_first=1,'Yes','No') as loc_first,Pack_Number,Pack_Description,weight,Notify_name,
					Notify_address, Consignee_name from shed_tally_info inner join igm_details on igm_details.id=shed_tally_info.igm_detail_id
					where verify_number='$verifyNo'"; 
					$stat = $this->bm->dataSelectDb1($strSelect);
					$verifyStatusList=$stat;
					
				 }
					 
					 
				 // For chalan view by verify number---------
				 $goodsDesStr="select Description_of_Goods from igm_supplimentary_detail inner join  shed_tally_info 
                               on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id where shed_tally_info.verify_number='$verifyNo'";
			     $result2 = $this->bm->dataSelectDb1($goodsDesStr);
			     $goodsDes= $result2[0]['Description_of_Goods'];
				 $data['goodsDes']=$goodsDes;
				 $DesStr="select truck_id, delv_pack, remarks from do_information where verify_no ='$verifyNo'";
			     $result3 = $this->bm->dataSelectDb1($DesStr);
				  
			     $data['result3']=$result3;
				 $data['tableFlag']=1;
                 // For chalan view by verify number---------END	 
				 
				 $data['verifyStatusList']=$verifyStatusList; 
				 $data['tableFlag']=$tableFlag;
				 $data['title']="GATE OUT...";
			     $data['verifyNo']=	$verifyNo;	
				 $data['tableTitle']="<font color=green>GATE OUT FOR VERIFY NO:</font> <font color=blue size=4><b>".$verifyNo."</b></font>";
				 $this->load->view('header5');
				 $this->load->view('gateOutView',$data);
				 $this->load->view('footer_1');
		 
		       }
		
		}
		
		
		function chalan()
		{
			$this->load->library('m_pdf');
		    $mpdf->use_kwt = true;
			

		    $verifyNo=$this->input->post('verifyNo');
			$notifyName=$this->input->post('notifyName');
			$notifyAddress=$this->input->post('notifyAddress');
			$stat=$this->input->post('stat');
			//echo $rotNo;	
			
				
		    $chalanStr1="SELECT cnf_lic_no FROM verify_other_data INNER JOIN shed_tally_info ON shed_tally_info.id = verify_other_data.shed_tally_id 
                              WHERE shed_tally_info.verify_number='$verifyNo'";
								
			$result1 = $this->bm->dataSelectDb1($chalanStr1);
			$CNFLicenceNo=$result1[0]['cnf_lic_no'];
		    //echo $CNFLicenceNo."</br>";
				 
			$CNFStr1="SELECT distinct(ref_bizunit_scoped.name) as name, address_line1
						 FROM inv_unit 
						 INNER JOIN inv_goods ON inv_goods.gkey=inv_unit.goods
						 LEFT JOIN ref_bizunit_scoped ON ref_bizunit_scoped.gkey=inv_goods.consignee_bzu
						 WHERE ref_bizunit_scoped.id = '$CNFLicenceNo'";
		    $CNFresult = $this->bm->dataSelect($CNFStr1);
			$cnfName=$CNFresult[0]['name'];
			$cnfAddress1=$CNFresult[0]['address_line1'];
				 
			$goodsDesStr="select Description_of_Goods from igm_supplimentary_detail inner join  shed_tally_info 
                               on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id where shed_tally_info.verify_number='$verifyNo'";
			$result2 = $this->bm->dataSelectDb1($goodsDesStr);
			$goodsDes= $result2[0]['Description_of_Goods'];
				 
			//--
			if($stat==1)
			{
				$DesStr="SELECT id,truck_id, delv_pack, remarks FROM do_information 
					WHERE verify_no ='$verifyNo' AND delv_status=1
					ORDER BY id DESC LIMIT 1";
				$count=2;
			}
				
			else
			{
				$DesStr="select truck_id, delv_pack, remarks from do_information where verify_no ='$verifyNo'";
				$count=1;
			}
				 
		    // $DesStr="select truck_id, delv_pack, remarks from do_information where verify_no ='$verifyNo'";
		    /* $DesStr="SELECT id,truck_id, delv_pack, remarks FROM do_information 
					WHERE verify_no ='$verifyNo'
					ORDER BY id DESC LIMIT 1"; */
			$result3 = $this->bm->dataSelectDb1($DesStr);
			
			$login_id = $this->session->userdata('login_id');
				  
			$this->data['result3']=$result3;
				 
			//for($i=0;$i<count($result3);$i++) 
			//{
			  // echo $result3[$i]['truck_id']."</br>";
			  // echo $result3[$i]['delv_pack']."</br>";
			  // echo $result3[$i]['remarks']."</br>";
		   // }
			
			$this->data['verifyNo']=$verifyNo;	 
			$this->data['cnfName']=$cnfName;   // CNF Name
			$this->data['cnfAddress1']=$cnfAddress1;  // CNF Address
			$this->data['notifyName']=$notifyName;
		    $this->data['notifyAddress']=$notifyAddress;
			$this->data['goodsDes']=$goodsDes; // Goods description
			$this->data['count']=$count; 

				 
			//echo $cnfName."</br>";
				 
		    // echo $cnfAddress1."</br>";
			//echo $notifyName."</br>";
		    //echo $notifyAddress."</br>";
			//echo $goodsDes;
			$html=$this->load->view('chalanView',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
		 
		    $pdfFilePath ="mypdfName-".time()."-download.pdf";

		    $pdf = $this->m_pdf->load();
			
			//$stylesheet = file_get_contents(CSS_PATH.'style.css'); // external css
			//$stylesheet = file_get_contents('resources/styles/test.css'); 
			$pdf->useSubstitutions = true; 
				
			$pdf->setFooter('Developed By : '.$login_id.'|Page {PAGENO}|Date {DATE j-m-Y}');
		
			//$pdf->WriteHTML($stylesheet,1);
			$pdf->WriteHTML($html,2);
				
			$pdf->Output($pdfFilePath, "I");	 
					
		}
		
		
		
		
		function containerRegisterInRegister()
		{
			 $session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				
				$query = "SELECT DISTINCT gkey, id FROM sparcsn4.road_gates WHERE life_cycle_state='ACT'";
				$gateList = $this->bm->dataSelect($query);
					
				$data['gateList']=$gateList;
				$data['title']="REGISTER";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('containerRegisterInRegister',$data);
				$this->load->view('footer');
			}	
		}
		
		/*Sumon Roy
		  Software Developer
		  Note: For gathering more data rows have to change parameter simple tables in mpdf.  
		*/
		function containerRegisterInRegisterView()
		{
			$this->load->library('m_pdf');
		    $mpdf->use_kwt = true;
			$mpdf->simpleTables = true;
		    $date=$this->input->post('date');
			$gate=$this->input->post('gate');
			

			
		    $str="SELECT sparcsn4.road_truck_visit_details.truck_license_nbr,sparcsn4.road_truck_transactions.ctr_id,sparcsn4.road_truck_transactions.stage_id,
					sparcsn4.road_truck_transactions.ctr_freight_kind,RIGHT(sparcsn4.road_truck_transactions.eqo_eq_length,2) AS size,sparcsn4.road_truck_transactions.nbr,
					sparcsn4.road_truck_transactions.line_id
					FROM sparcsn4.road_truck_visit_details
					INNER JOIN sparcsn4.road_truck_transactions ON sparcsn4.road_truck_transactions.truck_visit_gkey=sparcsn4.road_truck_visit_details.tvdtls_gkey
					WHERE DATE(sparcsn4.road_truck_visit_details.created)='$date' AND sparcsn4.road_truck_visit_details.gate_gkey=$gate";
			
		
			$result = $this->bm->dataSelect($str);	  

			$gateStr1="SELECT DISTINCT id FROM sparcsn4.road_gates WHERE gkey=$gate";
			$gateResult = $this->bm->dataSelect($gateStr1);
							
			$this->data['result']=$result;
			$this->data['gateResult']=$gateResult;
			$this->data['date']=$date;	 

			//echo $cnfName."</br>";

			$html=$this->load->view('containerRegisterInRegisterView',$this->data, true); 
		    $pdfFilePath ="mypdfName-".time()."-download.pdf";

		    $pdf = $this->m_pdf->load();
			//$stylesheet = file_get_contents(CSS_PATH.'style.css'); // external css
			//$stylesheet = file_get_contents('resources/styles/test.css'); 
			//$pdf->useSubstitutions = true; 				
			$pdf->setFooter('Developed By : DataSoft|Page {PAGENO}|Date {DATE j-m-Y}');
		
			//$pdf->WriteHTML($stylesheet,1);
			$pdf = new mPDF('utf-8', 'A4-L');  //have tried several of the formats
			//$pdf->WriteHTML($content,2);
			$pdf->WriteHTML($html,2);
				
			$pdf->Output($pdfFilePath, "I");	 					
		}
		
		
				
		function gateWiseContainerRegister()
		{
			
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				
				$query = "SELECT DISTINCT gkey, id FROM sparcsn4.road_gates WHERE life_cycle_state='ACT'";
				$gateList = $this->bm->dataSelect($query);
					
				$data['gateList']=$gateList;
				$data['title']="CONTAINER REGISTER REPORT";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('gateWiseContainerRegister',$data);
				$this->load->view('footer');
			}	
			
		}
		
		
		function gateWiseContainerRegisterView()
		{
				$fileType=$this->input->post('fileOptions');
				$registerType=$this->input->post('registerType');
				$date=$this->input->post('date');
				$gate=$this->input->post('gate');
			   //ECHO $fileType;
			   //return;
			   //$data['voysNo']=$getVoyNo;
			   if($registerType=="inward" and $gate=="all")
			   {  
			/* 		$str="SELECT sparcsn4.road_gates.id, sparcsn4.road_truck_visit_details.gate_gkey, sparcsn4.road_truck_visit_details.truck_license_nbr,sparcsn4.inv_unit.category, sparcsn4.road_truck_transactions.ctr_id,sparcsn4.road_truck_transactions.stage_id,
					sparcsn4.road_truck_transactions.ctr_freight_kind,RIGHT(sparcsn4.road_truck_transactions.eqo_eq_length,2) AS size,sparcsn4.road_truck_transactions.nbr
					FROM sparcsn4.road_truck_visit_details
					INNER JOIN sparcsn4.road_truck_transactions ON sparcsn4.road_truck_transactions.truck_visit_gkey=sparcsn4.road_truck_visit_details.tvdtls_gkey
					INNER JOIN sparcsn4.road_gates ON sparcsn4.road_gates.gkey=sparcsn4.road_truck_visit_details.gate_gkey
					INNER JOIN sparcsn4.inv_unit ON sparcsn4.road_truck_transactions.unit_gkey=sparcsn4.inv_unit.gkey
					WHERE DATE(sparcsn4.road_truck_visit_details.created)='$date' AND stage_id='In Gate' AND sparcsn4.inv_unit.category='EXPRT'"; */
					
					$str="SELECT inv_unit.gkey,sparcsn4.road_gates.id, sparcsn4.road_truck_visit_details.gate_gkey, sparcsn4.argo_carrier_visit.id AS truck,
					sparcsn4.road_truck_visit_details.truck_license_nbr,sparcsn4.inv_unit.category, sparcsn4.road_truck_transactions.ctr_id,sparcsn4.road_truck_transactions.stage_id,
					sparcsn4.road_truck_transactions.ctr_freight_kind,RIGHT(sparcsn4.road_truck_transactions.eqo_eq_length,2) AS size,sparcsn4.road_truck_transactions.nbr,
					sparcsn4.road_truck_visit_details.created
					FROM sparcsn4.road_truck_visit_details
					INNER JOIN sparcsn4.road_truck_transactions ON sparcsn4.road_truck_transactions.truck_visit_gkey=sparcsn4.road_truck_visit_details.tvdtls_gkey
					INNER JOIN sparcsn4.road_gates ON sparcsn4.road_gates.gkey=sparcsn4.road_truck_visit_details.gate_gkey
					INNER JOIN sparcsn4.inv_unit ON sparcsn4.road_truck_transactions.unit_gkey=sparcsn4.inv_unit.gkey
					INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
					INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
					WHERE sparcsn4.road_truck_visit_details.created BETWEEN '$date 08:00:00' AND DATE_ADD('$date 07:59:59', INTERVAL 1 DAY) AND stage_id='In Gate' AND sparcsn4.inv_unit.category='EXPRT'";		
					
					$data['title']="INWARD EXPORT  CONTAINER REGISTER";	
					$result = $this->bm->dataSelect($str);
					$data['gate']="ALL";
					$data['gate_type']="inward";
			   }
			    else if($registerType=="inward" and $gate!="all")
			   {  
					$str="SELECT inv_unit.gkey,sparcsn4.road_gates.id, sparcsn4.road_truck_visit_details.gate_gkey, sparcsn4.argo_carrier_visit.id AS truck,
					sparcsn4.road_truck_visit_details.truck_license_nbr,sparcsn4.inv_unit.category, sparcsn4.road_truck_transactions.ctr_id,sparcsn4.road_truck_transactions.stage_id,
					sparcsn4.road_truck_transactions.ctr_freight_kind,RIGHT(sparcsn4.road_truck_transactions.eqo_eq_length,2) AS size,sparcsn4.road_truck_transactions.nbr,
					sparcsn4.road_truck_visit_details.created
					FROM sparcsn4.road_truck_visit_details
					INNER JOIN sparcsn4.road_truck_transactions ON sparcsn4.road_truck_transactions.truck_visit_gkey=sparcsn4.road_truck_visit_details.tvdtls_gkey
					INNER JOIN sparcsn4.road_gates ON sparcsn4.road_gates.gkey=sparcsn4.road_truck_visit_details.gate_gkey
					INNER JOIN sparcsn4.inv_unit ON sparcsn4.road_truck_transactions.unit_gkey=sparcsn4.inv_unit.gkey
					INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
					INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ib_cv
					WHERE sparcsn4.road_truck_visit_details.created BETWEEN '$date 08:00:00' AND DATE_ADD('$date 07:59:59', INTERVAL 1 DAY) AND stage_id='In Gate' AND sparcsn4.inv_unit.category='EXPRT'and sparcsn4.road_truck_visit_details.gate_gkey=$gate";
				   
				   $data['title']="INWARD EXPORT  CONTAINER REGISTER";	
				  
				  $result = $this->bm->dataSelect($str);
				   $data['gate']=$result[0]['id'];
				   $data['gate_type']="inward";
			  }		
			else if($registerType=="outward" and $gate=="all")
			   {  
					/* $str="SELECT inv_unit.gkey,sparcsn4.road_gates.id, sparcsn4.road_truck_visit_details.gate_gkey, sparcsn4.road_truck_visit_details.truck_license_nbr,sparcsn4.inv_unit.category, sparcsn4.road_truck_transactions.ctr_id,sparcsn4.road_truck_transactions.stage_id,
					sparcsn4.road_truck_transactions.ctr_freight_kind,RIGHT(sparcsn4.road_truck_transactions.eqo_eq_length,2) AS size,sparcsn4.road_truck_transactions.nbr
					FROM sparcsn4.road_truck_visit_details
					INNER JOIN sparcsn4.road_truck_transactions ON sparcsn4.road_truck_transactions.truck_visit_gkey=sparcsn4.road_truck_visit_details.tvdtls_gkey
					INNER JOIN sparcsn4.road_gates ON sparcsn4.road_gates.gkey=sparcsn4.road_truck_visit_details.gate_gkey
					INNER JOIN sparcsn4.inv_unit ON sparcsn4.road_truck_transactions.unit_gkey=sparcsn4.inv_unit.gkey
					INNER JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
					WHERE sparcsn4.road_truck_visit_details.created BETWEEN '$date 08:00:00' AND DATE_ADD('$date 07:59:59', INTERVAL 1 DAY)
					AND inv_goods.destination!=2591 AND stage_id='Out Gate' and sparcsn4.inv_unit.category!='EXPRT'"; */
					
					/* $str="SELECT inv_unit.gkey,sparcsn4.road_gates.id, sparcsn4.road_truck_visit_details.gate_gkey, sparcsn4.road_truck_visit_details.truck_license_nbr,sparcsn4.inv_unit.category, sparcsn4.road_truck_transactions.ctr_id,sparcsn4.road_truck_transactions.stage_id,
					sparcsn4.road_truck_transactions.ctr_freight_kind,RIGHT(sparcsn4.road_truck_transactions.eqo_eq_length,2) AS size,sparcsn4.road_truck_transactions.nbr
					FROM sparcsn4.road_truck_visit_details
					INNER JOIN sparcsn4.road_truck_transactions ON sparcsn4.road_truck_transactions.truck_visit_gkey=sparcsn4.road_truck_visit_details.tvdtls_gkey
					INNER JOIN sparcsn4.road_gates ON sparcsn4.road_gates.gkey=sparcsn4.road_truck_visit_details.gate_gkey
					INNER JOIN sparcsn4.inv_unit ON sparcsn4.road_truck_transactions.unit_gkey=sparcsn4.inv_unit.gkey
					INNER JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
					WHERE sparcsn4.road_truck_visit_details.created BETWEEN '$date 08:00:00' AND DATE_ADD('$date 07:59:59', INTERVAL 1 DAY) AND stage_id='Out Gate'
					AND inv_goods.destination!=2591 AND sparcsn4.inv_unit.category ='IMPRT'
					 
					UNION ALL
					
					SELECT inv_unit.gkey,sparcsn4.road_gates.id, sparcsn4.road_truck_visit_details.gate_gkey, sparcsn4.road_truck_visit_details.truck_license_nbr,sparcsn4.inv_unit.category, sparcsn4.road_truck_transactions.ctr_id,sparcsn4.road_truck_transactions.stage_id,
					sparcsn4.road_truck_transactions.ctr_freight_kind,RIGHT(sparcsn4.road_truck_transactions.eqo_eq_length,2) AS size,sparcsn4.road_truck_transactions.nbr
					FROM sparcsn4.road_truck_visit_details
					INNER JOIN sparcsn4.road_truck_transactions ON sparcsn4.road_truck_transactions.truck_visit_gkey=sparcsn4.road_truck_visit_details.tvdtls_gkey
					INNER JOIN sparcsn4.road_gates ON sparcsn4.road_gates.gkey=sparcsn4.road_truck_visit_details.gate_gkey
					INNER JOIN sparcsn4.inv_unit ON sparcsn4.road_truck_transactions.unit_gkey=sparcsn4.inv_unit.gkey
					WHERE sparcsn4.road_truck_visit_details.created BETWEEN '$date 08:00:00' AND DATE_ADD('$date 07:59:59', INTERVAL 1 DAY) AND stage_id='Out Gate'
					AND sparcsn4.inv_unit.category ='STRGE'";	 */	

					$str="SELECT * FROM (
					SELECT inv_unit.gkey,sparcsn4.road_gates.id, sparcsn4.road_truck_visit_details.gate_gkey,sparcsn4.argo_carrier_visit.id AS truck,sparcsn4.inv_unit.category, sparcsn4.road_truck_transactions.ctr_id,sparcsn4.road_truck_transactions.stage_id,
					sparcsn4.road_truck_transactions.ctr_freight_kind,RIGHT(sparcsn4.road_truck_transactions.eqo_eq_length,2) AS size,sparcsn4.road_truck_transactions.nbr,sparcsn4.road_truck_visit_details.created,sparcsn4.road_truck_transactions.handled
					FROM sparcsn4.road_truck_visit_details
					INNER JOIN sparcsn4.road_truck_transactions ON sparcsn4.road_truck_transactions.truck_visit_gkey=sparcsn4.road_truck_visit_details.tvdtls_gkey
					INNER JOIN sparcsn4.road_gates ON sparcsn4.road_gates.gkey=sparcsn4.road_truck_visit_details.gate_gkey
					INNER JOIN sparcsn4.inv_unit ON sparcsn4.road_truck_transactions.unit_gkey=sparcsn4.inv_unit.gkey
					INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
					INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ob_cv
					INNER JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
					WHERE sparcsn4.road_truck_visit_details.created BETWEEN '$date 00:00:00' AND DATE_ADD('$date  00:00:00', INTERVAL 2 DAY) AND stage_id='Out Gate'
					AND inv_goods.destination!=2591 AND sparcsn4.inv_unit.category ='IMPRT'
					 
					UNION ALL

					SELECT inv_unit.gkey,sparcsn4.road_gates.id, sparcsn4.road_truck_visit_details.gate_gkey,sparcsn4.argo_carrier_visit.id AS truck,sparcsn4.inv_unit.category, sparcsn4.road_truck_transactions.ctr_id,sparcsn4.road_truck_transactions.stage_id,
					sparcsn4.road_truck_transactions.ctr_freight_kind,RIGHT(sparcsn4.road_truck_transactions.eqo_eq_length,2) AS size,sparcsn4.road_truck_transactions.nbr,sparcsn4.road_truck_visit_details.created,sparcsn4.road_truck_transactions.handled
					FROM sparcsn4.road_truck_visit_details
					INNER JOIN sparcsn4.road_truck_transactions ON sparcsn4.road_truck_transactions.truck_visit_gkey=sparcsn4.road_truck_visit_details.tvdtls_gkey
					INNER JOIN sparcsn4.road_gates ON sparcsn4.road_gates.gkey=sparcsn4.road_truck_visit_details.gate_gkey
					INNER JOIN sparcsn4.inv_unit ON sparcsn4.road_truck_transactions.unit_gkey=sparcsn4.inv_unit.gkey
					INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
					INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ob_cv
					WHERE sparcsn4.road_truck_visit_details.created BETWEEN '$date 00:00:00' AND DATE_ADD('$date  00:00:00', INTERVAL 2 DAY) AND stage_id='Out Gate'
					AND sparcsn4.inv_unit.category ='STRGE'
					) AS tbl WHERE handled BETWEEN '$date 08:00:00' AND DATE_ADD('$date  07:59:59', INTERVAL 1 DAY) ORDER BY truck,handled";
	
				   $data['title']="OUTWARD CONTAINER REGISTER";	
					$result = $this->bm->dataSelect($str);
				   $data['gate']="ALL";
				   $data['gate_type']="outward";
			  }	
			  else if($registerType=="outward" and $gate!="all")
			   {  
					
				/* 	$str="SELECT inv_unit.gkey,sparcsn4.road_gates.id, sparcsn4.road_truck_visit_details.gate_gkey, sparcsn4.road_truck_visit_details.truck_license_nbr,sparcsn4.inv_unit.category, sparcsn4.road_truck_transactions.ctr_id,sparcsn4.road_truck_transactions.stage_id,
					sparcsn4.road_truck_transactions.ctr_freight_kind,RIGHT(sparcsn4.road_truck_transactions.eqo_eq_length,2) AS size,sparcsn4.road_truck_transactions.nbr
					FROM sparcsn4.road_truck_visit_details
					INNER JOIN sparcsn4.road_truck_transactions ON sparcsn4.road_truck_transactions.truck_visit_gkey=sparcsn4.road_truck_visit_details.tvdtls_gkey
					INNER JOIN sparcsn4.road_gates ON sparcsn4.road_gates.gkey=sparcsn4.road_truck_visit_details.gate_gkey
					INNER JOIN sparcsn4.inv_unit ON sparcsn4.road_truck_transactions.unit_gkey=sparcsn4.inv_unit.gkey
					INNER JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
					WHERE sparcsn4.road_truck_visit_details.created BETWEEN '$date 08:00:00' AND DATE_ADD('$date 07:59:59', INTERVAL 1 DAY) AND stage_id='Out Gate'
					AND inv_goods.destination!=2591 AND sparcsn4.inv_unit.category ='IMPRT' and sparcsn4.road_truck_visit_details.gate_gkey=$gate
					 
					UNION ALL
					
					SELECT inv_unit.gkey,sparcsn4.road_gates.id, sparcsn4.road_truck_visit_details.gate_gkey, sparcsn4.road_truck_visit_details.truck_license_nbr,sparcsn4.inv_unit.category, sparcsn4.road_truck_transactions.ctr_id,sparcsn4.road_truck_transactions.stage_id,
					sparcsn4.road_truck_transactions.ctr_freight_kind,RIGHT(sparcsn4.road_truck_transactions.eqo_eq_length,2) AS size,sparcsn4.road_truck_transactions.nbr
					FROM sparcsn4.road_truck_visit_details
					INNER JOIN sparcsn4.road_truck_transactions ON sparcsn4.road_truck_transactions.truck_visit_gkey=sparcsn4.road_truck_visit_details.tvdtls_gkey
					INNER JOIN sparcsn4.road_gates ON sparcsn4.road_gates.gkey=sparcsn4.road_truck_visit_details.gate_gkey
					INNER JOIN sparcsn4.inv_unit ON sparcsn4.road_truck_transactions.unit_gkey=sparcsn4.inv_unit.gkey
					WHERE sparcsn4.road_truck_visit_details.created BETWEEN '$date 08:00:00' AND DATE_ADD('$date 07:59:59', INTERVAL 1 DAY) AND stage_id='Out Gate'
					AND sparcsn4.inv_unit.category ='STRGE' and sparcsn4.road_truck_visit_details.gate_gkey=$gate";
				*/
					$str="SELECT * FROM (
					SELECT inv_unit.gkey,sparcsn4.road_gates.id, sparcsn4.road_truck_visit_details.gate_gkey,sparcsn4.argo_carrier_visit.id AS truck,sparcsn4.inv_unit.category, sparcsn4.road_truck_transactions.ctr_id,sparcsn4.road_truck_transactions.stage_id,
					sparcsn4.road_truck_transactions.ctr_freight_kind,RIGHT(sparcsn4.road_truck_transactions.eqo_eq_length,2) AS size,sparcsn4.road_truck_transactions.nbr,sparcsn4.road_truck_visit_details.created,sparcsn4.road_truck_transactions.handled
					FROM sparcsn4.road_truck_visit_details
					INNER JOIN sparcsn4.road_truck_transactions ON sparcsn4.road_truck_transactions.truck_visit_gkey=sparcsn4.road_truck_visit_details.tvdtls_gkey
					INNER JOIN sparcsn4.road_gates ON sparcsn4.road_gates.gkey=sparcsn4.road_truck_visit_details.gate_gkey
					INNER JOIN sparcsn4.inv_unit ON sparcsn4.road_truck_transactions.unit_gkey=sparcsn4.inv_unit.gkey
					INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
					INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ob_cv
					INNER JOIN sparcsn4.inv_goods ON sparcsn4.inv_goods.gkey=sparcsn4.inv_unit.goods
					WHERE sparcsn4.road_truck_visit_details.created BETWEEN '$date 00:00:00' AND DATE_ADD('$date  00:00:00', INTERVAL 2 DAY) AND stage_id='Out Gate'
					AND inv_goods.destination!=2591 AND sparcsn4.inv_unit.category ='IMPRT' and sparcsn4.road_truck_visit_details.gate_gkey=$gate
					 
					UNION ALL

					SELECT inv_unit.gkey,sparcsn4.road_gates.id, sparcsn4.road_truck_visit_details.gate_gkey,sparcsn4.argo_carrier_visit.id AS truck,sparcsn4.inv_unit.category, sparcsn4.road_truck_transactions.ctr_id,sparcsn4.road_truck_transactions.stage_id,
					sparcsn4.road_truck_transactions.ctr_freight_kind,RIGHT(sparcsn4.road_truck_transactions.eqo_eq_length,2) AS size,sparcsn4.road_truck_transactions.nbr,sparcsn4.road_truck_visit_details.created,sparcsn4.road_truck_transactions.handled
					FROM sparcsn4.road_truck_visit_details
					INNER JOIN sparcsn4.road_truck_transactions ON sparcsn4.road_truck_transactions.truck_visit_gkey=sparcsn4.road_truck_visit_details.tvdtls_gkey
					INNER JOIN sparcsn4.road_gates ON sparcsn4.road_gates.gkey=sparcsn4.road_truck_visit_details.gate_gkey
					INNER JOIN sparcsn4.inv_unit ON sparcsn4.road_truck_transactions.unit_gkey=sparcsn4.inv_unit.gkey
					INNER JOIN sparcsn4.inv_unit_fcy_visit ON sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
					INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.gkey=sparcsn4.inv_unit_fcy_visit.actual_ob_cv
					WHERE sparcsn4.road_truck_visit_details.created BETWEEN '$date 00:00:00' AND DATE_ADD('$date  00:00:00', INTERVAL 2 DAY) AND stage_id='Out Gate'
					AND sparcsn4.inv_unit.category ='STRGE' and sparcsn4.road_truck_visit_details.gate_gkey=$gate
					) AS tbl WHERE handled BETWEEN '$date 08:00:00' AND DATE_ADD('$date  07:59:59', INTERVAL 1 DAY) ORDER BY truck,handled";

				   $data['title']="OUTWARD CONTAINER REGISTER";	
				   $result = $this->bm->dataSelect($str);
				   $data['gate']=$result[0]['id'];
				   $data['gate_type']="outward";
			  }		
					
		
					$data['result']=$result;			
					$data['date']=$date;	
					$data['fileType']=$fileType;	
					$this->load->view('gateWiseContainerRegisterView',$data);

			   }
			   
	/*SOURAV */
		function containerRegisterInRegister_ocr()
		{
			 $session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				
				$query = "SELECT DISTINCT gkey, id FROM sparcsn4.road_gates WHERE life_cycle_state='ACT'";
				$gateList = $this->bm->dataSelect($query);
				//	print_r($gateList); exit();
				$data['gateList']=$gateList;
				$data['title']="REGISTER";
				//echo $data['title'];
				$this->load->view('header2');
				$this->load->view('containerRegisterInRegister_ocr',$data);
				$this->load->view('footer');
			}	
		}
		

		function containerRegisterInRegisterView_ocr()
		{
			$this->load->library('m_pdf');
		    $mpdf->use_kwt = true;
			$mpdf->simpleTables = true;
		    $date=$this->input->post('date');
			$gate=$this->input->post('gate');
			

			
		    /*$str="SELECT sparcsn4.road_truck_visit_details.truck_license_nbr,sparcsn4.road_truck_transactions.ctr_id,sparcsn4.road_truck_transactions.stage_id,
					sparcsn4.road_truck_transactions.ctr_freight_kind,RIGHT(sparcsn4.road_truck_transactions.eqo_eq_length,2) AS size,sparcsn4.road_truck_transactions.nbr,
					sparcsn4.road_truck_transactions.line_id
					FROM sparcsn4.road_truck_visit_details
					INNER JOIN sparcsn4.road_truck_transactions ON sparcsn4.road_truck_transactions.truck_visit_gkey=sparcsn4.road_truck_visit_details.tvdtls_gkey
					WHERE DATE(sparcsn4.road_truck_visit_details.created)='$date' AND sparcsn4.road_truck_visit_details.gate_gkey=$gate";
			
		
			$result = $this->bm->dataSelect($str);	*/  

			$gateStr1="SELECT DISTINCT id FROM sparcsn4.road_gates WHERE gkey=$gate";
			$gateResult = $this->bm->dataSelect($gateStr1);
            $add_date = date('Y-m-d', strtotime($date. ' + 1 days'));
			//$this->data['result']=$result;
			$this->data['gateResult']=$gateResult;
			$this->data['date']=$date;
            $this->data['add_date']=$add_date;
            $this->data['gate']=$gate;

			//echo $cnfName."</br>";

			$html=$this->load->view('containerRegisterInRegisterView_ocr',$this->data, true); 
		    $pdfFilePath ="mypdfName-".time()."-download.pdf";

		    $pdf = $this->m_pdf->load();
			//$stylesheet = file_get_contents(CSS_PATH.'style.css'); // external css
			//$stylesheet = file_get_contents('resources/styles/test.css'); 
			//$pdf->useSubstitutions = true; 				
			$pdf->setFooter('Developed By : DataSoft|Page {PAGENO}|Date {DATE j-m-Y}');
		
			//$pdf->WriteHTML($stylesheet,1);
			$pdf = new mPDF('utf-8', 'A4-L');  //have tried several of the formats
			//$pdf->WriteHTML($content,2);
			$pdf->WriteHTML($html,2);
				
			$pdf->Output($pdfFilePath, "I");	 					
		}

      
}
?>