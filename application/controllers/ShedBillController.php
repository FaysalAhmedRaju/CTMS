<?php

class ShedBillController extends CI_Controller {
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
		 $this->shedBillView();
    }
	function shedBillView()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$data['title']="Shed Bill FORM...";
			$this->load->view('header5');
			$this->load->view('shedBillForm',$data);
			$this->load->view('footer_1');
		}	
    }
	
	function shedBillGenerate()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			if($this->input->post('verifyNo')=="")
			{
				if($this->uri->segment(3)=="")
				{
					$data['msg']="<font color='red'><b>Please input verify No.</b></font>";
				}
				else{
					$billVerify=$this->uri->segment(3);
					$data['msg']="Generate Bill For The Verification Number ".$billVerify;
				}
				
			}
			else
			{
				$billVerify=$this->input->post('verifyNo');
				$data['msg']="Generate Bill For The Verification Number ".$billVerify;
			}
			//$billVerify=$this->input->post('verifyNo');
			
			$data['title']="Shed Bill FORM...";
			
			
			//$tariffData=$this->tariffGenerate($billVerify);
			$this->tariffGenerate($billVerify);
			
			$contQuery="select cont_number from shed_tally_info where verify_number='$billVerify'";
			$contNum = $this->bm->dataSelectDb1($contQuery);
			$container = $contNum[0]['cont_number'];	
			
			$getDateDiffQuery= "select IFNULL(DATEDIFF(sparcsn4.inv_unit_fcy_visit.time_out,DATE_ADD(sparcsn4.inv_unit_fcy_visit.time_in,INTERVAL 4 day)),0) as dif
									from sparcsn4.inv_unit
									inner join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
									where sparcsn4.inv_unit.id='$container' and sparcsn4.inv_unit.category='STRGE'";
			$getDateDiff = $this->bm->dataSelect($getDateDiffQuery);
			$dateDiffValue=$getDateDiff[0]['dif'];
			//$dateDiffValue=15;
			
						$qry= "select verify_no,tarrif_id,bil_tariffs.description,bil_tariffs.gl_code,IFNULL(bil_tariff_rates.amount,0) as tarrif_rate,
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
										(select amt*15/100) as vatTK
										from shed_bill_tarrif
										inner join bil_tariffs on 
										shed_bill_tarrif.tarrif_id= bil_tariffs.id
										inner join bil_tariff_rates on
										bil_tariffs.gkey=bil_tariff_rates.tariff_gkey
										inner join shed_tally_info on
										shed_tally_info.verify_number=shed_bill_tarrif.verify_no
										inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id = shed_tally_info.igm_sup_detail_id
										inner join verify_other_data on verify_other_data.shed_tally_id=shed_tally_info.id
										where verify_no='$billVerify'";
				
			$chargeList = $this->bm->dataSelectDb1($qry); 
			//$data['tariffData']=$tariffData;
			$data['chargeList']= $chargeList;
			
			$contQuery="select COUNT(verify_no) as verify_no from shed_bill_master where verify_no='$billVerify'";
			$contNum = $this->bm->dataSelectDb1($contQuery);
			$verify_no = $contNum[0]['verify_no'];
			if($verify_no>0)
			{
				$data['stat']="<font color='red'><b>Bill Already Generated.</b></font>";
				$data['chkGenerate']=1;
			}
			//"Status : ".$tariffData[1]['contStat'];

			$this->load->view('header5');
			$this->load->view('shedBillForm',$data);
			$this->load->view('footer_1');
		}	
    }
	function tariffGenerate($billVerify)
	{
		
		$qry="select igm_sup_detail_container.cont_status,loc_first,shed_tally_info.cont_number	 
				from  igm_supplimentary_detail
				inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
				left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
				where shed_tally_info.verify_number='$billVerify'
				group by igm_sup_detail_container.id";
				
		$conStatus = $this->bm->dataSelectDb1($qry); 
		$cont_status = $conStatus[0]['cont_status'];
		$loc_first = $conStatus[0]['loc_first'];
		$cont_number = $conStatus[0]['cont_number'];
		//echo "Starus==".$loc_first;
		if($cont_status='LCL')
		{
			$strRiverDues="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
				values('$billVerify',(select get_shed_bill_tarrif('$billVerify',1)),1,1)";
			$statRiverDues=$this->bm->dataInsertDB1($strRiverDues);
				
			$strStuffUnStuff="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
				values('$billVerify',(select get_shed_bill_tarrif('$billVerify',2)),1,2)";
			$statStuffUnStuff=$this->bm->dataInsertDB1($strStuffUnStuff);
			
			$strHostingCharge="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
				values('$billVerify',(select get_shed_bill_tarrif('$billVerify',3)),1,3)";
			$statHostingCharge=$this->bm->dataInsertDB1($strHostingCharge);
				
			if($loc_first==1)
			{
				/********************Add 4 Days*************************/
				$getDateDiffQuery= "select IFNULL(DATEDIFF(sparcsn4.inv_unit_fcy_visit.time_out,DATE_ADD(sparcsn4.inv_unit_fcy_visit.time_in,INTERVAL 4 day)),0) as dif
									from sparcsn4.inv_unit
									inner join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
									where sparcsn4.inv_unit.id='$cont_number' and sparcsn4.inv_unit.category='STRGE'";
				$getDateDiff = $this->bm->dataSelect($getDateDiffQuery);
				$dateDiffValue=$getDateDiff[0]['dif'];
				if($dateDiffValue>14)
				{
					//9
					$strStuffUnStuff="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
						values('$billVerify',(select get_shed_bill_tarrif('$billVerify',9)),1,9)";
					$statStuffUnStuff=$this->bm->dataInsertDB1($strStuffUnStuff);
				}
				else if($dateDiffValue>7 and $dateDiffValue<=14)
				{
					//8
					$strStuffUnStuff="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
						values('$billVerify',(select get_shed_bill_tarrif('$billVerify',8)),1,8)";
					$statStuffUnStuff=$this->bm->dataInsertDB1($strStuffUnStuff);
				}
				else if($dateDiffValue>0 and $dateDiffValue<=7)
				{
					//7
					$strStuffUnStuff="replace into shed_bill_tarrif(verify_no,tarrif_id,billType,event_type) 
						values('$billVerify',(select get_shed_bill_tarrif('$billVerify',7)),1,7)";
					$statStuffUnStuff=$this->bm->dataInsertDB1($strStuffUnStuff);
				}
			}
			else if($loc_first==0)
			{
				/********************Add 4 Days*************************/
				$getDateDiffQuery= "select IFNULL(DATEDIFF(sparcsn4.inv_unit_fcy_visit.time_out,DATE_ADD(sparcsn4.inv_unit_fcy_visit.time_in,INTERVAL 4 day)),0) as dif
									from sparcsn4.inv_unit
									inner join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
									where sparcsn4.inv_unit.id='$cont_number' and sparcsn4.inv_unit.category='STRGE'";
				$getDateDiff = $this->bm->dataSelect($getDateDiffQuery);
				//$dateDiffValue=$getDateDiff[0]['dif'];
				$dateDiffValue = 18;
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
				//echo "Diff :  ".$getDateDiff[0]['dif'];
			}
		}
		else
		{
			echo 'FCL';
		}
		
		//$callFunctionQry="select get_shed_bill_tarrif($billVerify,1) as tarrifHead";
		//$getTarrif = $this->bm->dataSelectDb1($callFunctionQry);
		//$data['contStat']=$callFunction ;
		//$data['amount']=$amount;
		//$data['qty']=$qty;
		//$data['rcv']=$rcv;
		//$cars = array("$amount", "$qty", "$rcv");
		//return $getTarrif;
	}
	function saveGeneratedBilltoDb()
	{
		//echo "Tot ".$this->input->post('verifyNo');
			
			/*if($this->input->post('verifyNo')=="")
			{
				$data['msg']="<font color='red'><b>Please Generate Bill First.</b></font>";
			}
			else{*/

			$billVerify=$this->input->post('verifyNo');
			
			$contQuery="select COUNT(verify_no) as verify_no from shed_bill_master where verify_no='$billVerify'";
			$contNum = $this->bm->dataSelectDb1($contQuery);
			$verify_no = $contNum[0]['verify_no'];
			if($verify_no>0)
			{
				$data['stat']="<font color='red'><b>Bill Already Generated.</b></font>";
				$data['chkGenerate']=1;
			}
			else{
			
			/****************** Save Data For Shed Bill Master START ***************************************/
			$str="select  import_rotation,cont_number,verify_number,Vessel_Name,Line_No,BL_No,wr_date,wr_upto_date,cnf_lic_no,be_no,be_date,notify_name 
					from shed_tally_info
					inner join igm_supplimentary_detail on igm_supplimentary_detail.id = shed_tally_info.igm_sup_detail_id
					inner join igm_masters on igm_supplimentary_detail.igm_master_id=igm_masters.id
					left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
					where verify_number=$billVerify";
					//echo $str;
			$rtnContainerList = $this->bm->dataSelectDb1($str);
			$cnf_lic_no = $rtnContainerList[0]['cnf_lic_no'];
			$container = $rtnContainerList[0]['cont_number'];
			$import_rotation = $rtnContainerList[0]['import_rotation'];
			$verify_number = $rtnContainerList[0]['verify_number'];
			$Vessel_Name = $rtnContainerList[0]['Vessel_Name'];
			$Line_No = $rtnContainerList[0]['Line_No'];
			$BL_No = $rtnContainerList[0]['BL_No'];
			$wr_date = $rtnContainerList[0]['wr_date'];
			$wr_upto_date = $rtnContainerList[0]['wr_upto_date'];
			$be_no = $rtnContainerList[0]['be_no'];
			$be_date = $rtnContainerList[0]['be_date'];
			$notify_name = $rtnContainerList[0]['notify_name'];
			
			
				$getCnfNameQuery= "SELECT ref_bizunit_scoped.name
									FROM inv_unit 
									INNER JOIN inv_goods ON inv_goods.gkey=inv_unit.goods
									LEFT JOIN ref_bizunit_scoped ON ref_bizunit_scoped.gkey=inv_goods.consignee_bzu
									WHERE inv_unit.id='$container' AND ref_bizunit_scoped.id LIKE '$cnf_lic_no'";
				$getCnfName = $this->bm->dataSelect($getCnfNameQuery);
				$getCnfNameValue=$getCnfName[0]['name'];
				
				$arraivalDateQry="select date(sparcsn4.argo_carrier_visit.ata) as ata from sparcsn4.vsl_vessel_visit_details
									inner join sparcsn4.argo_carrier_visit 
									on sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
									where sparcsn4.vsl_vessel_visit_details.ib_vyg='$import_rotation'";
				$arraivalDate = $this->bm->dataSelect($arraivalDateQry);
				$arraivalDateValue=$arraivalDate[0]['ata'];
				
				$getExRateQuery= "select rate from bil_currency_exchange_rates where DATE(effective_date)= '$arraivalDateValue'";
				$getExRate = $this->bm->dataSelectDb1($getExRateQuery);
				$getExRateValue=$getExRate[0]['rate'];
				
				$getManifestQtyQuery="select cont_size,cont_height,IFNULL(CEIL(igm_sup_detail_container.Cont_gross_weight/1000),0) as Qty from igm_sup_detail_container
										inner join shed_tally_info on
										shed_tally_info.igm_sup_detail_id = igm_sup_detail_container.id 
										where verify_number=$billVerify";
				$getManifest = $this->bm->dataSelectDb1($getManifestQtyQuery);
				$cont_size=$getManifest[0]['cont_size'];
				$cont_height=$getManifest[0]['cont_height'];
				$manifest_qty=$getManifest[0]['Qty'];
				
				//echo "eytr".$getExRateQuery;
				//for($i=0;$i<count($rtnContainerList);$i++) 
				//{
					/*
						echo "Rotation : ".$rtnContainerList[$i]['import_rotation']."Cont : ".$rtnContainerList[$i]['cont_number']."BL : ".$rtnContainerList[$i]['BL_No']
						."verifyNo : ".$rtnContainerList[$i]['verify_number']."Vessel : ".$rtnContainerList[$i]['Vessel_Name']."LINE : ".$rtnContainerList[$i]['Line_No']
						."WR DATE : ".$rtnContainerList[$i]['wr_date']."WR upto : ".$rtnContainerList[$i]['wr_upto_date']
						."CNF LIC No : ".$rtnContainerList[$i]['cnf_lic_no']."BE No : ".$rtnContainerList[$i]['be_no']
						."BE DT : ".$rtnContainerList[$i]['be_date']."Cnf Name : ".$getCnfNameValue					
						;
					*/
					$shedMasterInsertQry="insert into shed_bill_master (verify_no,unit_no,cpa_vat_reg_no,ex_rate,bill_date,
										arraival_date,import_rotation,vessel_name,
										cl_date,bl_no,wr_date,wr_upto_date,importer_vat_reg_no,importer_name,cnf_lic_no,cnf_agent,
										be_no,be_date,ado_no,ado_date,ado_valid_upto,
										manifest_qty,cont_size,cont_height) 
										values 
										('$verify_number','1','2041001546','$getExRateValue',now(),'$arraivalDateValue','$import_rotation',
										 '$Vessel_Name','','$BL_No','$wr_date',
										 '$wr_upto_date','','$notify_name','$cnf_lic_no','$getCnfNameValue',
										 '$be_no','$be_date','','','','$manifest_qty','$cont_size','$cont_height'
										)";
					//echo $shedMasterInsertQry;
					$shedMasterInsert=$this->bm->dataInsertDB1($shedMasterInsertQry);
					
					if($shedMasterInsert==1)
					{
						/****************** Save Data For Shed Bill Details START ***************************************/
						$getShedMasterIDQuery= "select bill_no from shed_bill_master where verify_no=$billVerify";
						$getShedMasterID = $this->bm->dataSelectDb1($getShedMasterIDQuery);
						$getShedMasterIDValue=$getShedMasterID[0]['bill_no'];
						
						if($wr_date=="")
							{
								$getDateDiffQuery= "SELECT IFNULL(DATEDIFF(valid_up_to_date,DATE_ADD(wr_date,INTERVAL 4 day)),0) as dif from shed_tally_info
													left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
													where shed_tally_info.verify_number='$billVerify'";
							}
							else
							{
								$getDateDiffQuery= "SELECT IFNULL(DATEDIFF(valid_up_to_date,DATE_ADD('$wr_date',INTERVAL 4 day)),0) as dif from shed_tally_info
													left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
													where shed_tally_info.verify_number='$billVerify'";
							}
						
						/*$getDateDiffQuery= "select IFNULL(DATEDIFF(sparcsn4.inv_unit_fcy_visit.time_out,DATE_ADD(sparcsn4.inv_unit_fcy_visit.time_in,INTERVAL 4 day)),0) as dif
												from sparcsn4.inv_unit
												inner join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
												where sparcsn4.inv_unit.id='$container' and sparcsn4.inv_unit.category='STRGE'";*/
						$getDateDiff = $this->bm->dataSelectDb1($getDateDiffQuery);
						$dateDiffValue=$getDateDiff[0]['dif'];
						//$dateDiffValue=15;
						
						
						$qry= "select verify_no,tarrif_id,bil_tariffs.description,bil_tariffs.gl_code,IFNULL(bil_tariff_rates.amount,0) as tarrif_rate,
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
										(select amt*15/100) as vatTK
										from shed_bill_tarrif
										inner join bil_tariffs on 
										shed_bill_tarrif.tarrif_id= bil_tariffs.id
										inner join bil_tariff_rates on
										bil_tariffs.gkey=bil_tariff_rates.tariff_gkey
										inner join shed_tally_info on
										shed_tally_info.verify_number=shed_bill_tarrif.verify_no
										inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id = shed_tally_info.igm_sup_detail_id
										inner join verify_other_data on verify_other_data.shed_tally_id=shed_tally_info.id
										where verify_no='$billVerify'";
							//echo $qry;
						$chargeList = $this->bm->dataSelectDb1($qry);
						
						for($i=0;$i<count($chargeList);$i++) 
						{
							if($chargeList[$i]['qday']>0)
							{
							$gl_code=$chargeList[$i]['gl_code'];
							$description=$chargeList[$i]['description'];
							$tarrif_rate=$chargeList[$i]['tarrif_rate'];
							$Qty=$chargeList[$i]['Qty'];
							$qday=$chargeList[$i]['qday'];
							$amt=$chargeList[$i]['amt'];
							$vatTK=$chargeList[$i]['vatTK'];
							
							
							$shedDetailInsertQry="insert into shed_bill_details (verify_no,bill_no,gl_code,description,tarrif_rate,Qty,qday,amt,vatTK,mlwfTK) 
													values 
													('$billVerify','$getShedMasterIDValue','$gl_code','$description','$tarrif_rate',
														'$Qty','$qday','$amt','$vatTK','')";
							//echo $shedDetailInsertQry;
							
							$shedDetailInsert=$this->bm->dataInsertDB1($shedDetailInsertQry);
							
							if($shedDetailInsert==1)
							{
								$data['stat']="<font color='green'><b>Bill Successfully Saved.</b></font>";
							}
							/*echo "GL : ".$chargeList[$i]['gl_code']."Description : ".$chargeList[$i]['description']."Rate : ".$chargeList[$i]['tarrif_rate']
								."Qty : ".$chargeList[$i]['Qty']."Days : ".$chargeList[$i]['qday']."Port(tk) : ".$chargeList[$i]['amt']
								."Vat(tk) : ".$chargeList[$i]['vatTK']."MLWF(tk) : ".$chargeList[$i]['gl_code']
								."Verify No : ".$chargeList[$i]['verify_no']
								;*/
							}
						}
						
						/****************** Save Data For Shed Bill Details END***************************************/
					}
					else
					{
						$data['stat']="<font color='red'><b>Not inserted</b></font>";
					}
				}	
			
			
			
			
			
			/****************** Save Data For Shed Bill Master END ***************************************/
			
				if($this->input->post('verifyNo')=="")
				{
					$billVerify=$this->uri->segment(3);
					$data['msg']="Generate Bill For The Verification Number ".$billVerify;
				}
				else
				{
					$billVerify=$this->input->post('verifyNo');
					$data['msg']="Generate Bill For The Verification Number ".$billVerify;
				}
			//$billVerify=$this->input->post('verifyNo');
			//}
			$data['title']="Shed Bill FORM...";
			
			
			//$tariffData=$this->tariffGenerate($billVerify);
			//$this->tariffGenerate($billVerify);
			
			$contQuery="select cont_number from shed_tally_info where verify_number='$billVerify'";
			//echo "Query : ".$contQuery;
			$contNum = $this->bm->dataSelectDb1($contQuery);
			$container = $contNum[0]['cont_number'];	
			
			/*$getDateDiffQuery= "select IFNULL(DATEDIFF(sparcsn4.inv_unit_fcy_visit.time_out,DATE_ADD(sparcsn4.inv_unit_fcy_visit.time_in,INTERVAL 4 day)),0) as dif
									from sparcsn4.inv_unit
									inner join sparcsn4.inv_unit_fcy_visit on sparcsn4.inv_unit_fcy_visit.unit_gkey=sparcsn4.inv_unit.gkey
									where sparcsn4.inv_unit.id='$container' and sparcsn4.inv_unit.category='STRGE'";*/
			if($wr_date=="")
			{
				$getDateDiffQuery= "SELECT IFNULL(DATEDIFF(valid_up_to_date,DATE_ADD(wr_date,INTERVAL 4 day)),0) as dif from shed_tally_info
									left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
									where shed_tally_info.verify_number='$billVerify'";
			}
			else
			{
				$getDateDiffQuery= "SELECT IFNULL(DATEDIFF(valid_up_to_date,DATE_ADD('$wr_date',INTERVAL 4 day)),0) as dif from shed_tally_info
									left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
									where shed_tally_info.verify_number='$billVerify'";
			}						
			$getDateDiff = $this->bm->dataSelectDb1($getDateDiffQuery);
			$dateDiffValue=$getDateDiff[0]['dif'];
			//$dateDiffValue=15;
			
			
			$qry= "select verify_no,tarrif_id,bil_tariffs.description,bil_tariffs.gl_code,IFNULL(bil_tariff_rates.amount,0) as tarrif_rate,
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
										(select amt*15/100) as vatTK
										from shed_bill_tarrif
										inner join bil_tariffs on 
										shed_bill_tarrif.tarrif_id= bil_tariffs.id
										inner join bil_tariff_rates on
										bil_tariffs.gkey=bil_tariff_rates.tariff_gkey
										inner join shed_tally_info on
										shed_tally_info.verify_number=shed_bill_tarrif.verify_no
										inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id = shed_tally_info.igm_sup_detail_id
										inner join verify_other_data on verify_other_data.shed_tally_id=shed_tally_info.id
										where verify_no='$billVerify'";
				
			$chargeList = $this->bm->dataSelectDb1($qry); 
			
			$contQuery="select COUNT(verify_no) as verify_no from shed_bill_master where verify_no='$billVerify'";
			$contNum = $this->bm->dataSelectDb1($contQuery);
			$verify_no = $contNum[0]['verify_no'];
			if($verify_no>0)
			{
				//$data['stat']="<font color='red'><b>Bill Already Generated.</b></font>";
				$data['chkGenerate']=1;
			}
			
			
			$data['title']="Shed Bill FORM...";
			$data['chargeList']= $chargeList;
			$this->load->view('header5');
			$this->load->view('shedBillForm',$data);
			$this->load->view('footer_1');
			
			
			
			
			//$data['tariffData']=$tariffData;
			//$data['chargeList']= $chargeList;
		
	}
	function exchangeRateForm()
		{
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$excngQry="select gkey,id from bil_currencies order by gkey";
				$gkeyList = $this->bm->dataSelectDb1($excngQry); 			
				$data['gkeyList']= $gkeyList;
			
				$data['title']="Add Exchange Rate...";
				$this->load->view('header5');
				$this->load->view('addExchangeRateForm',$data);
				$this->load->view('footer_1');
			}	
		}
	function addExchangeRate()
	{
		$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$frmCurrID= $this->input->post('frmCurrency');
				$toCurrID= $this->input->post('toCurrency');
				$excngDt= $this->input->post('excngDt');
				$excngRate= $this->input->post('excngRate');
				$notes= $this->input->post('notes');
				$login_id = $this->session->userdata('login_id');
				
				$excngInsertQry="replace into bil_currency_exchange_rates (rate,notes,effective_date,from_currency_gkey,to_currency_gkey,created,creator)
									values ($excngRate,'$notes','$excngDt',$frmCurrID,$toCurrID,NOW(),'$login_id') ";
				//echo $excngInsertQry;
				$stat=$this->bm->dataInsertDB1($excngInsertQry);
				if($stat==1)
				{
					$data['stat']="<font color='green'><b>Sucessfully inserted</b></font>";
				}else{
					$data['stat']="<font color='red'><b>Not inserted</b></font>";
				}
							
				$excngQry="select gkey,id from bil_currencies order by gkey";
				$gkeyList = $this->bm->dataSelectDb1($excngQry); 			
				$data['gkeyList']= $gkeyList;
				
				$data['title']="Add Exchange Rate...";
				$this->load->view('header5');
				$this->load->view('addExchangeRateForm',$data);
				$this->load->view('footer_1');
			}	
	}
	
	function logout()
	{ 
		$data['body']="<font color='blue' size=2>LogOut Successfully....</font>";
		$this->session->sess_destroy();
		$this->cache->clean();
		//redirect(base_url(),$data);
		$this->load->view('header');
		$this->load->view('welcomeview_1', $data);
		$this->load->view('footer');
		$this->db->cache_delete_all();
	}
	
	 public function getShedBillPdf()
	{ 
		//load mPDF library
		$login_id = $this->session->userdata('login_id');
		$this->load->library('m_pdf');
		$mpdf->use_kwt = true;
				$billVerify = "";
				if($this->input->post('sendVerifyNo'))
				{
					$billVerify=$this->input->post('sendVerifyNo');
					/*$shedbill=$this->input->post('shedbill');  //bill no
					$rcvstat=$this->input->post('rcvstat');
					$cpnoview=$this->input->post('cpnoview');
					$cpbankcode=$this->input->post('cpbankcode');
					if($cpbankcode=="OB")
						$cpbankname="ONE BANK LIMITED";*/
					
				}
				else if($this->input->post('verify_num'))
				{
					$billVerify=$this->input->post('verify_num');
					
				}
				else{
					$billVerify=str_replace("_","/",$this->uri->segment(3));
					//$ddl_imp_rot_no=str_replace("_","/",$this->uri->segment(4));
					//$ddl_imp_rot_no=$this->uri->segment(4);
					//$rot_year=$this->uri->segment(4);
					//$rot_no=$this->uri->segment(5);
					//$ddl_imp_rot_no=$rot_year.'/'.$rot_no;
					
					//ECHO $billVerify;
				}
		$strBankPaymentInfo = "select shed_bill_master.bill_no,bill_rcv_stat,cp_bank_code,user,
		concat(cp_bank_code,cp_unit,'/',right(cp_year,2),'-',concat(if(length(cp_no)=1,'000',if(length(cp_no)=2,'00',if(length(cp_no)=3,'0',''))),cp_no)) as cp_no
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
		
			$str="select concat(right(YEAR(bill_date),2),'/',
								concat(if(length(bill_generation_no)=1,'00000',if(length(bill_generation_no)=2,'0000',if(length(bill_generation_no)=3,'000',
								if(length(bill_generation_no)=4,'00',if(length(bill_generation_no)=5,'0',''))))),bill_generation_no)) as bill_no,verify_no,unit_no,cpa_vat_reg_no,ex_rate,bill_date,arraival_date,import_rotation,vessel_name,
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
		 $this->data['bill_print_times']=1;
		 //$this->data['amountInwords']=convert_number_to_words(5000);
		 
		 $this->data['unit_no']=$unit_no;
		 $this->data['cpa_vat_reg_no']=$cpa_vat_reg_no;
		 $this->data['ex_rate']=$ex_rate;

		$html=$this->load->view('shedBillPdfOutput',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
 	 
		//this the the PDF filename that user will get to download
		$pdfFilePath ="shedBill-".time()."-download.pdf";

		
		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
		//$pdf->mirrorMargins = 1;
		//generate the PDF!
		//$stylesheet = file_get_contents('assets/css/main.css');
        //$mpdf->WriteHTML($stylesheet,1);
		$stylesheet = file_get_contents('resources/styles/shedBill.css'); // external css
		$pdf->useSubstitutions = true; // optional - just as an example
		//$pdf->SetHeader($url . "\n\n" . 'Date {DATE j-m-Y}');  // optional - just as an example
		//echo "SheetAdd : ".$stylesheet;
		//$pdf->setFooter('Prepared By :'.$bill_clerk.'|Page {PAGENO}|Date {DATE j-m-Y}');
		//$footerHtml='<pagefooter name="MyFooter1" content-left="{DATE j-m-Y}" content-center="{PAGENO}/{nbpg}" content-right="My document" footer-style="font-family: serif; font-size: 8pt; font-weight: bold; font-style: italic; color: #000000;" />';
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		//$pdf->WriteHTML('<pagebreak resetpagenum="1" pagenumstyle="1" suppress="off" />');
		//offer it to user via browser download! (The PDF won't be saved on your server HDD)
		//$pdf->Output($pdfFilePath, "D"); /// For Direct Download 
		$pdf->Output($pdfFilePath, "I"); // For Show Pdf
	}
	
	//-----SHED BILL LIST start
	function shedBillListForm()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			//initial data start
			/* $sqlbillno = "SELECT shed_bill_master.bill_no,shed_bill_master.verify_no,unit_no,import_rotation,cnf_agent,SUM(amt) AS total_amt,SUM(vatTk) AS total_vat,total_port,total_mlwf 
			FROM shed_bill_details INNER JOIN shed_bill_master 
			ON shed_bill_master.bill_no=shed_bill_details.bill_no 
			GROUP BY bill_no"; */
			
			/* $sqlbillno = "SELECT shed_bill_master.bill_no AS bn,CONCAT(RIGHT(YEAR(bill_date),2),'/',CONCAT(IF(LENGTH(bill_generation_no)=1,'00000',IF(LENGTH(bill_generation_no)=2,'0000',IF(LENGTH(bill_generation_no)=3,'000',
			IF(LENGTH(bill_generation_no)=4,'00',IF(LENGTH(bill_generation_no)=5,'0',''))))),bill_generation_no)) AS bill_no,shed_bill_master.verify_no,unit_no,import_rotation,cnf_agent,SUM(amt) AS total_amt,SUM(vatTk) AS total_vat,total_port,total_mlwf 
			FROM shed_bill_details INNER JOIN shed_bill_master 
			ON shed_bill_master.bill_no=shed_bill_details.bill_no 
			GROUP BY shed_bill_master.bill_no"; */
			
			$sqlbillno="SELECT shed_bill_master.bill_no AS bn,CONCAT(RIGHT(YEAR(bill_date),2),'/',CONCAT(IF(LENGTH(bill_generation_no)=1,'00000',IF(LENGTH(bill_generation_no)=2,'0000',IF(LENGTH(bill_generation_no)=3,'000',IF(LENGTH(bill_generation_no)=4,'00',IF(LENGTH(bill_generation_no)=5,'0',''))))),bill_generation_no)) AS bill_no,shed_bill_master.verify_no,unit_no,import_rotation,cnf_agent,SUM(amt) AS total_amt,SUM(vatTk) AS total_vat,total_port,total_mlwf 
			FROM shed_bill_details 
			INNER JOIN shed_bill_master ON shed_bill_master.bill_no=shed_bill_details.bill_no 
			GROUP BY shed_bill_master.bill_no ORDER BY bill_no DESC"; 
				
			$rtnbillno = $this->bm->dataSelectDb1($sqlbillno);
			$data['rtnbillno']=$rtnbillno;
				
			//initial data end
				
			$data['title']="SHED BILL LIST FORM...";
		//	$this->load->view('header2');
			$this->load->view('header5');
			$this->load->view('shedBillListForm',$data);
		//	$this->load->view('footer');
			$this->load->view('footer_1');
		}
	}
	
	function shedBillList()
	{
		$search_by=$this->input->post('search_by');
		
		if($search_by=="billNo")
		{
			$billNo=$this->input->post('search_value');
			$cond = " WHERE shed_bill_master.bill_generation_no=RIGHT('$billNo',6) GROUP BY shed_bill_master.bill_no";				
		}
		
		else if($search_by=="verifyNo")
		{
			$verifyNo=$this->input->post('search_value');
			$cond = " WHERE shed_bill_master.verify_no='$verifyNo' GROUP BY shed_bill_master.bill_no";				
		}
		
		else if($search_by=="Unit")
		{
			$Unit=$this->input->post('search_value');
			$cond = " WHERE shed_bill_master.unit_no='$Unit' GROUP BY shed_bill_master.bill_no";				
		}
		
		
		
		$sqlbillno = "SELECT shed_bill_master.bill_no AS bn,CONCAT(RIGHT(YEAR(bill_date),2),'/',CONCAT(IF(LENGTH(bill_generation_no)=1,'00000',IF(LENGTH(bill_generation_no)=2,'0000',IF(LENGTH(bill_generation_no)=3,'000',
		IF(LENGTH(bill_generation_no)=4,'00',IF(LENGTH(bill_generation_no)=5,'0',''))))),bill_generation_no)) AS bill_no,shed_bill_master.verify_no,unit_no,import_rotation,cnf_agent,SUM(amt) AS total_amt,SUM(vatTk) AS total_vat,total_port,total_mlwf 
		FROM shed_bill_details INNER JOIN shed_bill_master 
		ON shed_bill_master.bill_no=shed_bill_details.bill_no".$cond;
		
		$rtnbillno = $this->bm->dataSelectDb1($sqlbillno);
			
		$data['rtnbillno']=$rtnbillno;
		$this->load->view('header2');
		$this->load->view('shedBillListForm',$data);
		$this->load->view('footer');
	}
	
	
	function shedreceive()
	{
		$verifyno=$this->input->post('verifyno');  
		$shedbill=$this->input->post('shedbill');
			
		$sql="UPDATE shed_bill_master
		SET bill_rcv_stat = '1'
		WHERE verify_no='$verifyno'"; 
				  
		$update = $this->bm->dataInsertDB1($sql);   //reopen
		
		//cpno start
		
		$sqlcpnoyear="SELECT IFNULL(MAX(cp_no),0) AS cp_no,YEAR(NOW()) AS year FROM bank_bill_recv WHERE cp_year=YEAR(NOW())";
		$rtncpnoyear = $this->bm->dataSelectDb1($sqlcpnoyear);
		$rtncpno=$rtncpnoyear[0]['cp_no'];
		$cpno=$rtncpno+1;
		$cpyear=$rtncpnoyear[0]['year'];
		$login_id = $this->session->userdata('login_id');
		
		$cpbankcode=$this->session->userdata('section'); //from session
		 
		$sqlunit="SELECT section AS rtnValue FROM users INNER JOIN shed_bill_master ON shed_bill_master.user=users.login_id WHERE shed_bill_master.verify_no='$verifyno'";
		$rtnunit = $this->bm->dataReturnDb1($sqlunit);
		
		$cpunit=$rtnunit;
	
		$sqlbankinsert="INSERT INTO bank_bill_recv(bill_no,cp_no,cp_year,cp_bank_code,cp_unit,recv_by,recv_time) VALUES('$shedbill','$cpno','$cpyear','$cpbankcode','$cpunit','$login_id',now())"; //reopen
		
	 	$rsltbankinsert = $this->bm->dataInsertDB1($sqlbankinsert);  //reopen 

		$sqlbillno = "SELECT shed_bill_master.bill_no AS bn,CONCAT(RIGHT(YEAR(bill_date),2),'/',CONCAT(IF(LENGTH(bill_generation_no)=1,'00000',IF(LENGTH(bill_generation_no)=2,'0000',IF(LENGTH(bill_generation_no)=3,'000',
		IF(LENGTH(bill_generation_no)=4,'00',IF(LENGTH(bill_generation_no)=5,'0',''))))),bill_generation_no)) AS bill_no,shed_bill_master.verify_no,unit_no,import_rotation,cnf_agent,SUM(amt) AS total_amt,SUM(vatTk) AS total_vat,total_port,total_mlwf 
		FROM shed_bill_details INNER JOIN shed_bill_master 
		ON shed_bill_master.bill_no=shed_bill_details.bill_no 
		GROUP BY shed_bill_master.bill_no ORDER BY bill_no DESC";
				
		$rtnbillno = $this->bm->dataSelectDb1($sqlbillno);
		$data['rtnbillno']=$rtnbillno;
	//	$data['cpnoview']=$cpnoview;
		$data['shedbill']=$shedbill;
			
		$this->load->view('header2');
		$this->load->view('shedBillListForm',$data);
		$this->load->view('footer');
	}
	//-----SHED BILL LIST end
	
	function getIgmDetailsByVerifyNumber()
	{
		
		//$verifyNo=$this->input->post('sendVerifyNo');
		
		if($this->input->post('sendVerifyNo'))
		{
		  $verifyNo=$this->input->post('sendVerifyNo');
		}
		else
		{			
	      $verifyNo=$this->uri->segment(3);
		}
			
		$data['title']="IGM DETAILS FOR THE VERIFY NO: ".$verifyNo;
		
		$verifyReport = "select igm_supplimentary_detail.id,IFNULL(SUM(shed_tally_info.rcv_pack)+SUM(shed_tally_info.loc_first),0) as rcv_pack,shed_tally_info.cont_number,shed_tally_info.import_rotation,Pack_Marks_Number,shed_loc,shed_yard,
            Description_of_Goods,ConsigneeDesc,NotifyDesc,cont_size,cont_weight,cont_seal_number,cont_status,cont_height,cont_iso_type,IFNULL(shed_tally_info.verify_number,0) as verify_number,
            shed_tally_info.wr_upto_date,shed_tally_info.verify_by,shed_tally_info.verify_time,shed_tally_info.wr_upto_date,IFNULL(shed_tally_info.id,0) as verify_id,
            (select Organization_Name from organization_profiles where organization_profiles.id=igm_sup_detail_container.off_dock_id) as offdock_name,
             agent_do,do_date,be_no,be_date,cnf_lic_no,update_ton
             from  igm_supplimentary_detail
             inner join igm_sup_detail_container on igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
             left join  shed_tally_info on shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
             left join verify_other_data on shed_tally_info.id=verify_other_data.shed_tally_id
             where shed_tally_info.verify_number='$verifyNo'";
		
		$rtnVerifyReport = $this->bm->dataSelectDb1($verifyReport);
			
		$data['rtnVerifyReport']=$rtnVerifyReport;
	
		$this->load->view('getIgmDetailsByVerifyForm',$data);

		
	}
	
	   //-----BILL SEARCH BY VERIFY NUMBER start
	function billSearchByVerifyForm()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{	$data['tblFlag']=0;
			$search = 0;
			$data['search']=$search;
			$data['title']="BILL SEARCH BY VERIFY NUMBER...";
			$this->load->view('header2');
			$this->load->view('billSearchByVerifyForm',$data);
			$this->load->view('footer');
		}
	}
	
	
	
	
	
	function bilSearchByVerifyNumber()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{	
			$search = 1;
			$data['search']=$search;
			$data['title']="BILL SEARCH BY VERIFY NUMBER...";
			$verifyNo="";
		if($this->uri->segment(3) != null )
		{
			$verifyNo=$this->uri->segment(3);
		}
		else
		{
			$verifyNo=$this->input->post('verifyNo');
		}
		
		
		//$verify = substr($verifyNo, -4);
		
		$doReportQuery="SELECT count(verify_no) as total, sum(delv_pack) as total_do_pack, count(truck_id) as total_truck_assign 
		                from do_information where verify_no='$verifyNo'";
		$checkDo = $this->bm->dataSelectDb1($doReportQuery);
		
		$deliverd_truck = $checkDo[0]['total_truck_assign'];
		//$total_pack_in_DO= $checkDo[0]['total_do_pack'];
		//$total_truck_assign_in_DO = $checkDo[0]['total_truck_assign'];
		
		
		//$rem_truck=$truckNum-$deliverd_truck;
		
			$verifyReport = "SELECT shed_bill_master.bill_no, shed_tally_info.verify_number, unit_no,shed_tally_info.import_rotation,
		vessel_name,shed_bill_master.bl_no,igm_supplimentary_detail.Description_of_Goods,Qty, shed_loc, shed_yard,
		if(bill_rcv_stat=1,'Paid','Not Paid') as paid_status, cont_number,
                igm_supplimentary_detail.Pack_Number, igm_supplimentary_detail.Pack_Description,
                (shed_tally_info.rcv_pack+ ifnull(shed_tally_info.loc_first,0)) as rcv_pack,shed_tally_info.rcv_unit, no_of_truck
		FROM shed_tally_info 
		left JOIN shed_bill_master ON shed_tally_info.verify_number=shed_bill_master.verify_no
		left JOIN shed_bill_details ON shed_bill_master.bill_no =shed_bill_details.bill_no
		left JOIN verify_other_data ON shed_tally_info.id=verify_other_data.shed_tally_id
                inner join igm_supplimentary_detail on igm_supplimentary_detail.id=shed_tally_info.igm_sup_detail_id
	        left join igm_details on igm_details.id=igm_supplimentary_detail.igm_detail_id
		WHERE shed_tally_info.verify_number='$verifyNo'
		GROUP BY bill_no";
		
		$rtnVerifyReport = $this->bm->dataSelectDb1($verifyReport);			
		$truck_num=$rtnVerifyReport[0]['no_of_truck'];
	    $data['rtnVerifyReport']=$rtnVerifyReport;
		
		
		
		$rem_truck=$truck_num-$deliverd_truck;
		$data['deliverd_truck']=$deliverd_truck;
		$data['rem_truck']=$rem_truck;
		

		if($deliverd_truck>=0)
		{
			$doQuery="SELECT verify_no, delv_pack, truck_id, gate_no from do_information where verify_no='$verifyNo' order by id";
			$doInfo = $this->bm->dataSelectDb1($doQuery);
			$data['doInfo']=$doInfo;
			$doShowFlag=1;
			$data['doShowFlag']=$doShowFlag;
				if($truck_num>$deliverd_truck)
					{
					   $data['dlv_btn_status']=1;
					}
				else
					{
						//$dlv_btn_status=1;
						$data['dlv_btn_status']=0;
					}
			$data['tblFlag']=1;
		}
		
		else
		{
		    $data['dlv_btn_status']=1;
			$data['doShowFlag']=0;
			$data['tblFlag']=1;
		}
		


		//echo $deliverd_truck;
		//$rcv_pack=$rtnVerifyReport[0]['rcv_pack'];
		//$no_of_truck=$rtnVerifyReport[0]['no_of_truck'];
      /*
	  if($total_truck_assign_in_DO >=$no_of_truck)
		{
			$data['rtnVerifyReport']=$rtnVerifyReport;
			$data['msg']="Already Delivered or Truck already assiged.";
			$data['verifyNo']=$verifyNo;
			$data['tblFlag']=0;
			$data['dlv_btn_status']=0;
		}
		else if($total_pack_in_DO>=$rcv_pack)
		{
			$data['rtnVerifyReport']=$rtnVerifyReport;
			//$data['msg']="No any pack remain of the verify: ".$verifyNo;
			echo "No any pack remain of the verify no: ".$verifyNo;
			$data['verifyNo']=$verifyNo;
			$data['tblFlag']=0;
			$data['dlv_btn_status']=0;
		}
		else{
		
			$data['verifyNo']=$verifyNo;				
			$data['rtnVerifyReport']=$rtnVerifyReport;
			$data['truckNum']=2;
			$data['tblFlag']=1;
			$data['dlv_btn_status']=1;
		}	
		*/

		    $data['verifyNo']=$verifyNo;
		    
			$this->load->view('header2');
			$this->load->view('billSearchByVerifyForm',$data);
			$this->load->view('footer');
		}
	}
	
	
	
	function deliver()
	{
	  $session_id = $this->session->userdata('value');
	  if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
		$search = 1;
		$data['search']=$search;
		$data['title']="BILL SEARCH BY VERIFY NUMBER...";
		$truckNum=$this->input->post('numTruc');
		$contNo=$this->input->post('contNo');
		$rotNo=$this->input->post('rotNo');
		//$deliverd_truck=$this->input->post('deliverd_truck');
		//$gateNo=$this->input->post('gateNo');
		$verifyNo=$this->input->post('verifyNo');
		//$realPackSum=$this->input->post('packSum');
		//echo $realPackSum;
		
		$ipaddr = $_SERVER['REMOTE_ADDR'];
		$login_id = $this->session->userdata('login_id');
		
		//$verify = substr($verifyNo, -4);
		
		$doReportQuery="SELECT count(verify_no) as total, sum(delv_pack) as total_do_pack, count(truck_id) as total_truck_assign 
		                from do_information where verify_no='$verifyNo'";
		$checkDo = $this->bm->dataSelectDb1($doReportQuery);
		$delivered_pack=$checkDo[0]['total_do_pack'];
		$deliverd_truck = $checkDo[0]['total_truck_assign'];
		$delivered_total_truck = $checkDo[0]['total'];
		//$total_pack_in_DO= $checkDo[0]['total_do_pack'];
		//$total_truck_assign_in_DO = $checkDo[0]['total_truck_assign'];
		
		//echo $delivered_total_truck;
		
		
	    $verifyReport = "SELECT shed_bill_master.bill_no, shed_tally_info.verify_number, unit_no,shed_tally_info.import_rotation,
		vessel_name,shed_bill_master.bl_no,igm_supplimentary_detail.Description_of_Goods,Qty, shed_loc, shed_yard,
		if(bill_rcv_stat=1,'Paid','Not Paid') as paid_status, cont_number,
                igm_supplimentary_detail.Pack_Number, igm_supplimentary_detail.Pack_Description,
                (shed_tally_info.rcv_pack+ ifnull(shed_tally_info.loc_first,0)) as rcv_pack,shed_tally_info.rcv_unit, no_of_truck
		FROM shed_tally_info 
		left JOIN shed_bill_master ON shed_tally_info.verify_number=shed_bill_master.verify_no
		left JOIN shed_bill_details ON shed_bill_master.bill_no =shed_bill_details.bill_no
		left JOIN verify_other_data ON shed_tally_info.id=verify_other_data.shed_tally_id
                inner join igm_supplimentary_detail on igm_supplimentary_detail.id=shed_tally_info.igm_sup_detail_id
	        left join igm_details on igm_details.id=igm_supplimentary_detail.igm_detail_id
		WHERE shed_tally_info.verify_number='$verifyNo' GROUP BY bill_no";
		
		$rtnVerifyReport = $this->bm->dataSelectDb1($verifyReport);			
		$truck_num=$rtnVerifyReport[0]['no_of_truck'];
	    $data['rtnVerifyReport']=$rtnVerifyReport;
		
		
		
		//$rem_truck=$truck_num-$deliverd_truck;
		//$data['deliverd_truck']=$deliverd_truck;
		//$data['rem_truck']=$rem_truck;
		

		if($delivered_total_truck>=0 and $delivered_total_truck<$truck_num)
		{		
			$verifyReport = "SELECT distinct(rcv_pack +ifnull(shed_tally_info.loc_first,0)) as rcv_pack, shed_tally_info.rcv_unit,
			igm_supplimentary_detail.Pack_Number, igm_supplimentary_detail.Pack_Description
			FROM shed_bill_details INNER JOIN shed_bill_master 
			ON shed_bill_master.bill_no=shed_bill_details.bill_no
			INNER JOIN shed_tally_info ON shed_bill_details.verify_no=shed_tally_info.verify_number
			inner join igm_supplimentary_detail on igm_supplimentary_detail.id=shed_tally_info.igm_sup_detail_id
			left join igm_details on igm_details.id=igm_supplimentary_detail.igm_detail_id
			WHERE shed_bill_master.verify_no='$verifyNo'";
			
			$rtnVerifyReport = $this->bm->dataSelectDb1($verifyReport);
			
			$realRecivedPackNumber=$rtnVerifyReport[0]['rcv_pack'];
			$realRecivedPackUnit=$rtnVerifyReport[0]['rcv_unit'];
			$igmPackNumber=$rtnVerifyReport[0]['Pack_Number'];
			$igmPackUnit=$rtnVerifyReport[0]['Pack_Description'];		
		
			//echo "dsd".$truckNum."tt";			
			$pack=0;
			for($i=$deliverd_truck+1; $i<$deliverd_truck+2;$i++)
			{
				//echo $i;
				$trucId=$this->input->post('truck'.$i);
				$packQty= $this->input->post('pkQty'.$i);
				$gateNo= $this->input->post('gateNo'.$i);
				//echo $packQty."ok";
				//$trucId= $_POST['truck'.$i];
				//$packQty= $_POST['packQty'.$i];
				$pack=$delivered_pack+$packQty;
				//echo $trucId."<br>";
				//echo $packQty."<br>";				
			}
		   //echo $deliverd_truck."ee".$pack;
			if($realRecivedPackUnit==$igmPackUnit)
			{
				if($realRecivedPackNumber>=$pack)
				{   
					$insert_OK=1; 
					$data['msgFlag']=0;			
				}

				if($realRecivedPackNumber<$pack)
				{
					$data['msgFlag']=2;
					//$data['msg']="Assigning Package more than Real Package!!";
					$data['msg']= "<font color=red>Sorry! You are delivering more packages than received packages.</br> Please correct package quantity and Try again!!.</font>";
				}		
				
				if($insert_OK==1)
				{
					// $trucId=$this->input->post('truck'.$i);				
					for($i=($deliverd_truck+1); $i<($deliverd_truck+2);$i++)
					{
						//echo $truckNumber[$i];
						
						$trucId=$this->input->post('truck'.$i);
						$packQty= $this->input->post('pkQty'.$i);
						$gateNo= $this->input->post('gateNo'.$i);
						if($trucId=="")
						{
							$trucId=0;
							$packQty=0;
						}
						else
						{
							$strInsertEq = "insert into do_information(verify_no, import_rotation, cont_number, truck_id, delv_pack, update_by, ip_addr, last_update, gate_no)
							values('$verifyNo','$rotNo', '$contNo', '$trucId', $packQty, '$login_id', '$ipaddr',  now(), '$gateNo')";  	  
							$stat = $this->bm->dataInsertDB1($strInsertEq);
							//echo $strInsertEq;
							// echo "stat: ".$stat." tr: ".$trucId;
						}			  
					}
					
					if($stat==1)
					{
					  $sql="UPDATE shed_tally_info SET delivery_status = '1' WHERE verify_number = '$verifyNo'";
					  $update = $this->bm->dataInsertDB1($sql);
					  $data['msgFlag']=1;
					  //$data['msg']="Successfully Delivered";
					  $data['msg']=  "<font color=green>Successfully Delivered</font>";
					}
				}
				
			}		
			else
			 {
				if($igmPackNumber>=$pack)
				{   
					$insert_OK=1; 
					$data['msgFlag']=0;
					if($insert_OK==1)
					{
						// $trucId=$this->input->post('truck'.$i);				
						for($i=($deliverd_truck+1); $i<=($deliverd_truck+2);$i++)
						{
							//echo $truckNumber[$i];				
							$trucId=$this->input->post('truck'.$i);
							$packQty= $this->input->post('pkQty'.$i);
							$gateNo= $this->input->post('gateNo'.$i);
							if($trucId=="")
							{					
								$trucId=0;
								$packQty=0;
							}
							else
							{
								$strInsertEq = "insert into do_information(verify_no, import_rotation, cont_number, truck_id, delv_pack, update_by, ip_addr, last_update, gate_no)
								values('$verifyNo','$rotNo', '$contNo', '$trucId', $packQty, '$login_id', '$ipaddr',  now(), '$gateNo')";  	  
								$stat = $this->bm->dataInsertDB1($strInsertEq);
								//echo $strInsertEq;
								// echo "stat: ".$stat." tr: ".$trucId;
							}			  
						}
						if($stat==1)
						{
							$sql="UPDATE shed_tally_info SET delivery_status = '1' WHERE verify_number = '$verifyNo'";
							$update = $this->bm->dataInsertDB1($sql);
							$data['msgFlag']=1;
							//$data['msg']="Successfully Delivered";
							$data['msg']=  "<font color=green>Successfully Delivered</font>";
						}
					}
				}
				else{
					$data['msgFlag']=2;
					$data['msg']= "<font color=red>Sorry! You are delivering more packages than IGM packages.</br> Please correct package quantity and try again!!.</font>";
			        }
			}
		
			if($deliverd_truck>=0)
				{
					$doQuery="SELECT verify_no, delv_pack, truck_id, gate_no from do_information where verify_no='$verifyNo' order by id";
					$doInfo = $this->bm->dataSelectDb1($doQuery);
					$data['doInfo']=$doInfo;
					$doShowFlag=1;
					$data['doShowFlag']=$doShowFlag;
						if($truck_num>$deliverd_truck)
							{
							   $data['dlv_btn_status']=1;
							}
						else
							{
								//$dlv_btn_status=1;
								$data['dlv_btn_status']=0;
							}
					$data['tblFlag']=1;					

					$doReportQuery="SELECT count(verify_no) as total, sum(delv_pack) as total_do_pack, count(truck_id) as total_truck_assign 
		                from do_information where verify_no='$verifyNo'";
					$checkDo = $this->bm->dataSelectDb1($doReportQuery);
					$delivered_pack=$checkDo[0]['total_do_pack'];
					$deliverd_truck = $checkDo[0]['total_truck_assign'];
					
					
					$rem_truck=$truck_num-$deliverd_truck;
					$data['deliverd_truck']=$deliverd_truck;
					$data['rem_truck']=$rem_truck;

				}
				
			else
				{
					$doQuery="SELECT verify_no, delv_pack, truck_id, gate_no from do_information where verify_no='$verifyNo' order by id";
					$doInfo = $this->bm->dataSelectDb1($doQuery);
					$data['doInfo']=$doInfo;
					$data['dlv_btn_status']=1;
					$data['doShowFlag']=1;
					$data['tblFlag']=1;
				}
		}
		
		else{
			$doQuery="SELECT verify_no, delv_pack, truck_id, gate_no from do_information where verify_no='$verifyNo' order by id";
			 $doInfo = $this->bm->dataSelectDb1($doQuery);
			 $data['doInfo']=$doInfo;
			 $data['dlv_btn_status']=0;
			 $data['doShowFlag']=1;
			 $data['tblFlag']=1;	
			
			
			$data['msgFlag']=2;
			$data['msg']= "<font color=red>Sorry! Already delivered all assign trucks.</font>";  
		   }
		
		    $this->load->view('header2');
			$this->load->view('billSearchByVerifyForm',$data);
			$this->load->view('footer');
		}

	}
	
	

	
	//-----TALLY REPORT start
	function tallyReportForm()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{	
			$data['title']="TALLY REPORT FORM...";
			$this->load->view('header2');
			$this->load->view('tallyReportForm',$data);
			$this->load->view('footer');
		}
	}
	
	function tallyReport()
	{
		if($this->input->post('rotation') && $this->input->post('container'))
				{
					$rotation=$this->input->post('rotation');
					$container=$this->input->post('container');

				}
				else{
					$rotation=str_replace("_","/",$this->uri->segment(3));
					$container=str_replace("_","/",$this->uri->segment(4));
					//$ddl_imp_rot_no=$this->uri->segment(4);
					//$rot_year=$this->uri->segment(4);
					//$rot_no=$this->uri->segment(5);
					//$ddl_imp_rot_no=$rot_year.'/'.$rot_no;
				}
		
		/*$sqltallyreport = "SELECT id,Import_Rotation_No,cont_number,Line_No,Pack_Marks_Number,Description_of_Goods,Pack_Number,loc_first,
  SUM(rcv_pack) AS rcv_pack,actual_marks,marks_state,
  (SELECT SUM(delv_pack) FROM do_information WHERE verify_no=tmp.verify_number) AS delv_pack
  FROM(SELECT igm_supplimentary_detail.id,igm_supplimentary_detail.Line_No,Import_Rotation_No,igm_sup_detail_container.cont_number,Pack_Marks_Number,igm_supplimentary_detail.Description_of_Goods,Pack_Number,rcv_pack,loc_first,actual_marks,marks_state,shed_tally_info.verify_number
  FROM igm_supplimentary_detail 
  INNER JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
  LEFT JOIN shed_tally_info ON shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
  WHERE Import_Rotation_No='$rotation' AND igm_sup_detail_container.cont_number='$container' and rcv_pack>0) AS tmp GROUP BY id";*/
  
  //commented on 26/08/2017
  /* $sqltallyreport = "SELECT id,Import_Rotation_No,cont_number,Line_No,Pack_Marks_Number,Description_of_Goods,Pack_Number,
  (SUM(rcv_pack)+IFNULL(loc_first,0)) as totPkg,actual_marks,marks_state,
  (SELECT SUM(delv_pack) FROM do_information WHERE verify_no=tmp.verify_number) AS delv_pack
  FROM(SELECT igm_supplimentary_detail.id,igm_supplimentary_detail.Line_No,Import_Rotation_No,igm_sup_detail_container.cont_number,Pack_Marks_Number,igm_supplimentary_detail.Description_of_Goods,Pack_Number,rcv_pack,loc_first,actual_marks,marks_state,shed_tally_info.verify_number
  FROM igm_supplimentary_detail 
  INNER JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
  LEFT JOIN shed_tally_info ON shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
  WHERE Import_Rotation_No='$rotation' AND igm_sup_detail_container.cont_number='$container') AS tmp GROUP BY id"; */
		
		$section = $this->session->userdata('section');
		/* $sqltallyreport = "SELECT id,Vessel_Name,Import_Rotation_No,cont_number,cont_size,tally_sheet_number,rcv_pack,loc_first,flt_pack,shed_loc,Line_No,Pack_Marks_Number,Description_of_Goods,Pack_Number,
		(SUM(rcv_pack)+IFNULL(loc_first,0)) AS totPkg,actual_marks,marks_state,
		(SELECT SUM(delv_pack) FROM do_information WHERE verify_no=tmp.verify_number) AS delv_pack,shift_name,Notify_name
		FROM(SELECT igm_supplimentary_detail.id,igm_supplimentary_detail.Line_No,igm_supplimentary_detail.Import_Rotation_No,igm_sup_detail_container.cont_number,Vessel_Name,cont_size,Pack_Marks_Number,igm_supplimentary_detail.Description_of_Goods,Pack_Number,rcv_pack,loc_first,actual_marks,marks_state,shed_tally_info.verify_number,shed_tally_info.flt_pack,shed_loc,tally_sheet_number,shift_name,Notify_name
		FROM igm_supplimentary_detail 
		INNER JOIN igm_masters ON igm_masters.id=igm_supplimentary_detail.igm_master_id
		INNER JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
		LEFT JOIN shed_tally_info ON shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
		WHERE igm_supplimentary_detail.Import_Rotation_No='$rotation' AND igm_sup_detail_container.cont_number='$container') AS tmp GROUP BY id"; */
		
		
	/* 	$rtntallyreport = $this->bm->dataSelectDb1($sqltallyreport);
		
		$sqlBerth="SELECT IFNULL(flex_string02,flex_string03) AS rtnValue FROM sparcsn4.vsl_vessel_visit_details WHERE ib_vyg='$rotation'";
		
		$rsltBerth=$this->bm->dataReturn($sqlBerth); */
		
		$sqlinfo = "SELECT id,Vessel_Name,Import_Rotation_No,cont_number,cont_seal_number,cont_size,tally_sheet_number,rcv_pack,loc_first,flt_pack,shed_loc,Line_No,Pack_Marks_Number,Description_of_Goods,Pack_Number,
		(SUM(rcv_pack)+IFNULL(loc_first,0)) AS totPkg,actual_marks,marks_state,
		(SELECT SUM(delv_pack) FROM do_information WHERE verify_no=tmp.verify_number) AS delv_pack,shift_name,Notify_name,mlocode
		FROM(SELECT igm_supplimentary_detail.id,igm_supplimentary_detail.Line_No,igm_supplimentary_detail.Import_Rotation_No,igm_sup_detail_container.cont_number,cont_seal_number,Vessel_Name,cont_size,igm_supplimentary_detail.Pack_Marks_Number,igm_supplimentary_detail.Description_of_Goods,igm_supplimentary_detail.Pack_Number,rcv_pack,loc_first,actual_marks,marks_state,shed_tally_info.verify_number,shed_tally_info.flt_pack,shed_loc,tally_sheet_number,shift_name,igm_supplimentary_detail.Notify_name,igm_details.mlocode
		FROM igm_supplimentary_detail 
		INNER JOIN igm_details ON igm_details.id=igm_supplimentary_detail.igm_detail_id
		INNER JOIN igm_masters ON igm_masters.id=igm_supplimentary_detail.igm_master_id
		INNER JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id
		LEFT JOIN shed_tally_info ON shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
		WHERE igm_supplimentary_detail.Import_Rotation_No='$rotation' AND igm_sup_detail_container.cont_number='$container') AS tmp GROUP BY id";
		
		$rtninfo = $this->bm->dataSelectDb1($sqlinfo);
		
		$sqlBerth="SELECT IFNULL(flex_string02,flex_string03) AS berthOp,DATE(sparcsn4.argo_carrier_visit.ata) AS ata
		FROM sparcsn4.vsl_vessel_visit_details 
		INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
		WHERE ib_vyg='$rotation'";
		
		$rsltBerth=$this->bm->dataSelect($sqlBerth);
			
		$data['rotation']=$rotation;
		$data['container']=$container;
		$data['section']=$section;
		$data['rtninfo']=$rtninfo;
		$data['rsltBerth']=$rsltBerth;
		$data['counter']=$counter;
		$this->load->view('tallyReport',$data);
	}
	
	function tallyReportPdf($rot,$cont)
	{ 
			//load mPDF library
		$this->load->library('m_pdf');
		$mpdf->use_kwt = true;
		
		if($this->input->post('rotation') && $this->input->post('container'))
		{
			$rotation=$this->input->post('rotation');
			$container=$this->input->post('container');
		}
		/*else if($_GET["rotation"] && $_GET["cont"])
		{
			$rotation=$_GET["rotation"];
			$container=$_GET["cont"];
		}*/
		else if($this->uri->segment(3) != null && $this->uri->segment(4) != null)
		{
			$rotation=str_replace("_","/",$this->uri->segment(3));
			$container=str_replace("_","/",$this->uri->segment(4));
		}
		else{
			$rotation=$rot;
			$container=$cont;
		}

		$section = $this->session->userdata('section');
		$login_id = $this->session->userdata('login_id');
			
		$sqlinfo = "SELECT  id,(SELECT Vessel_Name FROM igm_masters WHERE Import_Rotation_No= tmp.import_rotation) AS Vessel_Name,import_rotation as Import_Rotation_No,cont_number,cont_seal_number,cont_size,tally_sheet_number,rcv_pack,rcv_unit,loc_first,flt_pack,shed_loc,Line_No,Pack_Marks_Number,Description_of_Goods,Pack_Number,
		(SUM(rcv_pack)+IFNULL(loc_first,0)) AS totPkg,actual_marks,marks_state,
		(SELECT SUM(delv_pack) FROM do_information WHERE verify_no=tmp.verify_number) AS delv_pack,shift_name,Notify_name,mlocode
		FROM(SELECT shed_tally_info.igm_sup_detail_id as id,rcv_unit,igm_supplimentary_detail.Line_No,shed_tally_info.import_rotation,igm_sup_detail_container.cont_number,cont_seal_number,Vessel_Name,cont_size,igm_supplimentary_detail.Pack_Marks_Number,igm_supplimentary_detail.Description_of_Goods,igm_supplimentary_detail.Pack_Number,rcv_pack,loc_first,actual_marks,marks_state,shed_tally_info.verify_number,shed_tally_info.flt_pack,shed_loc,tally_sheet_number,shift_name,
		(select Organization_Name from organization_profiles where id=igm_supplimentary_detail.Submitee_Org_Id) as Notify_name,igm_details.mlocode
		FROM  shed_tally_info
		LEFT JOIN igm_supplimentary_detail ON shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id
		LEFT JOIN igm_details ON igm_details.id=igm_supplimentary_detail.igm_detail_id
		LEFT JOIN igm_masters ON igm_masters.id=igm_supplimentary_detail.igm_master_id
		LEFT JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id		
		WHERE shed_tally_info.import_rotation='$rotation' AND shed_tally_info.cont_number='$container') AS tmp GROUP BY id";
			
		$rtninfo = $this->bm->dataSelectDb1($sqlinfo);
		
		$loopCounter="select * from (SELECT igm_supplimentary_detail.id,master_BL_No,Description_of_Goods,Import_Rotation_No,BL_No,cont_number,
												cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,Pack_Marks_Number,Pack_Number,ConsigneeDesc,NotifyDesc 
												FROM igm_supplimentary_detail 
												LEFT JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id					
												WHERE Import_Rotation_No='$rotation' AND cont_number='$container'
												) tbl1
												union
												select * from (SELECT shed_tally_info.igm_sup_detail_id as id,master_BL_No,Description_of_Goods,import_rotation as Import_Rotation_No,BL_No,
												shed_tally_info.cont_number, cont_size,Cont_gross_weight,cont_seal_number,Pack_Description,actual_marks,Pack_Number,ConsigneeDesc,
												NotifyDesc FROM shed_tally_info 
												LEFT JOIN igm_supplimentary_detail ON shed_tally_info.igm_sup_detail_id=igm_supplimentary_detail.id 
												LEFT JOIN igm_sup_detail_container ON igm_sup_detail_container.igm_sup_detail_id=igm_supplimentary_detail.id 
												WHERE shed_tally_info.import_rotation='$rotation' and shed_tally_info.cont_number='$container' and BL_NO is null
												)tbl2";
		$rtnCounter = $this->bm->dataSelectDb1($loopCounter);
		
		$sqlBerth="SELECT IFNULL(flex_string03,flex_string02) AS berthOp,DATE(sparcsn4.argo_carrier_visit.ata) AS ata
		FROM sparcsn4.vsl_vessel_visit_details 
		INNER JOIN sparcsn4.argo_carrier_visit ON sparcsn4.argo_carrier_visit.cvcvd_gkey=sparcsn4.vsl_vessel_visit_details.vvd_gkey
		WHERE ib_vyg='$rotation'";
		//echo $sqlBerth;
		$rsltBerth=$this->bm->dataSelect($sqlBerth);
		
		$sqlSigQuery="select distinct signature_path_berth,signature_path_freight,signature_path_cpa from shed_tally_info 
		where import_rotation='$rotation' and cont_number='$container'";
			
		$rsltSig=$this->bm->dataSelectDb1($sqlSigQuery);
		$signature_path_berth=$rsltSig[0]['signature_path_berth'];
		$signature_path_freight=$rsltSig[0]['signature_path_freight'];
		$signature_path_cpa=$rsltSig[0]['signature_path_cpa'];
		
		$this->data['rotation']=$rotation;
		$this->data['container']=$container;
		$this->data['section']=$section;
		$this->data['rtninfo']=$rtninfo;
		$this->data['rtnCounter']=$rtnCounter;
		$this->data['rsltBerth']=$rsltBerth;
		$this->data['counter']=$counter;
		$this->data['signature_path_berth']=$signature_path_berth;
		$this->data['signature_path_freight']=$signature_path_freight;
		$this->data['signature_path_cpa']=$signature_path_cpa;

		$html=$this->load->view('tallyReportPdfOutput',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
		 
		$pdfFilePath ="tallyReport-".time()."-download.pdf";

		$pdf = $this->m_pdf->load();
		$pdf->allow_charset_conversion = true;
		$pdf->charset_in = 'iso-8859-4';
		$stylesheet = file_get_contents('resources/styles/test.css'); // external css
	//	$pdf->useSubstitutions = true; // optional - just as an example
			
		$pdf->setFooter('Prepared By : '.$login_id.'|Page {PAGENO} of {nb}|Date {DATE j-m-Y}');
			
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
			 
		$pdf->Output($pdfFilePath, "I"); // For Show Pdf
	}
	//-----TALLY REPORT end
		function shedBillHeadWiseSummaryRptForm()
				{
					$session_id = $this->session->userdata('value');
					if($session_id!=$this->session->userdata('session_id'))
					{
						$this->logout();
						
					}
					else
					{
						$data['title']="HEAD WISE SUMMARY FOR SHED BILL";
						$this->load->view('header2');
						$this->load->view('shedBillHeadWiseSummaryRptForm',$data);   
						$this->load->view('footer');
					}
				}
	function shedBillHeadWiseSummaryRptView()
				{
					$login_id = $this->session->userdata('login_id');	
					$data['login_id']=$login_id;
					
					$from_dt=$this->input->post('from_dt');
					$to_dt=$this->input->post('to_dt');
					$unitNo=$this->input->post('unitNo');
					
					
					$data['from_dt']=$from_dt;
					$data['to_dt']=$to_dt;
					$data['unitNo']=$unitNo;
					$data['title']="UNIT NO ".$unitNo." FROM : ".$from_dt." TO : ".$to_dt;
					
					$this->load->view('shedBillHeadWiseSummaryRptView',$data);   
				}
function shedBillSummaryRptForm()
				{
					$session_id = $this->session->userdata('value');
					if($session_id!=$this->session->userdata('session_id'))
					{
						$this->logout();
						
					}
					else
					{
						$data['title']="SUMMARY FOR SHED BILL";
						$this->load->view('header2');
						$this->load->view('shedBillSummaryRptForm',$data);   
						$this->load->view('footer');
					}
				}
	function shedBillSummaryRptView()
				{
					$login_id = $this->session->userdata('login_id');	
					$data['login_id']=$login_id;
					
					$from_dt=$this->input->post('from_dt');
					$to_dt=$this->input->post('to_dt');

					$data['from_dt']=$from_dt;
					$data['to_dt']=$to_dt;
					
					$data['title']="FROM : ".$from_dt." TO : ".$to_dt;
					
					$this->load->view('shedBillSummaryRptView',$data);   
				}	
				
	public function getShedStockBalancePdf()
	{ 
		//load mPDF library
		$this->load->library('m_pdf');
		$mpdf->use_kwt = true;
		$login_id = $this->session->userdata('login_id');
		//load mPDF library
	   
		  $strVerifyNum=$this->input->post('vNum');
		
		if($billVerify=="")
		{
			$str="select verify_number,import_rotation,shed_tally_info.cont_number,master_BL_No,BL_No,cont_weight,cont_size,cont_height,cont_status,cont_type,
				Pack_Number,Pack_Description,Notify_name from shed_tally_info 
				inner join igm_supplimentary_detail on shed_tally_info.igm_sup_detail_id = igm_supplimentary_detail.id
				inner join igm_sup_detail_container on shed_tally_info.igm_sup_detail_id=igm_sup_detail_container.igm_sup_detail_id
				where verify_number>0 and shed_tally_info.delivery_status not in (1)";
		}
			else{
				$str="select verify_number,import_rotation,shed_tally_info.cont_number,master_BL_No,BL_No,cont_weight,cont_size,cont_height,cont_status,cont_type,
					Pack_Number,Pack_Description,Notify_name from shed_tally_info 
					inner join igm_supplimentary_detail on shed_tally_info.igm_sup_detail_id = igm_supplimentary_detail.id
					inner join igm_sup_detail_container on shed_tally_info.igm_sup_detail_id=igm_sup_detail_container.igm_sup_detail_id
					where verify_number='$strVerifyNum' and shed_tally_info.delivery_status not in (1)";
			}
				//echo $str;
				//echo $str;
		$rtnContainerList = $this->bm->dataSelectDb1($str);
		
		 $this->data['rtnContainerList']=$rtnContainerList;
		
		 $this->data['title']="Verify List";
		

		$html=$this->load->view('shedBillStockBalancePdfOutput',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
 	 
		//this the the PDF filename that user will get to download
		$pdfFilePath ="shedBill-".time()."-download.pdf";

		
		//actually, you can pass mPDF parameter on this load() function
		$pdf = $this->m_pdf->load();
		//$pdf->mirrorMargins = 1;
		//generate the PDF!
		//$stylesheet = file_get_contents('assets/css/main.css');
        //$mpdf->WriteHTML($stylesheet,1);
		//$stylesheet = file_get_contents('resources/styles/test.css'); // external css
		$pdf->useSubstitutions = true; // optional - just as an example
		//$pdf->SetHeader($url . "\n\n" . 'Date {DATE j-m-Y}');  // optional - just as an example
		//echo "SheetAdd : ".$stylesheet;
		$pdf->setFooter('Prepared By :'.$login_id.' |Page {PAGENO}|Date {DATE j-m-Y}');
		//$footerHtml='<pagefooter name="MyFooter1" content-left="{DATE j-m-Y}" content-center="{PAGENO}/{nbpg}" content-right="My document" footer-style="font-family: serif; font-size: 8pt; font-weight: bold; font-style: italic; color: #000000;" />';
		//$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		//$pdf->WriteHTML('<pagebreak resetpagenum="1" pagenumstyle="1" suppress="off" />');
		//offer it to user via browser download! (The PDF won't be saved on your server HDD)
		//$pdf->Output($pdfFilePath, "D"); /// For Direct Download 
		$pdf->Output($pdfFilePath, "I"); // For Show Pdf
	}	
	
	
	function billGenerationForm()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
				
		}
		else
		{
			$getBillTarrifQuery= "select id,bil_tariffs.description,long_description,bil_tariffs.gl_code,effective_date,rate_type,amount from bil_tariffs inner join bil_tariff_rates on 
								bil_tariffs.gkey=bil_tariff_rates.tariff_gkey ORDER BY ID ASC ";
			$getBillTarrif = $this->bm->dataSelectDb1($getBillTarrifQuery);
			
			$data['getBillTarrif']=$getBillTarrif;			
			$data['title']="BILL GENERATION";
			$this->load->view('header5');
			$this->load->view('billGenerationForm',$data);   
			$this->load->view('footer_1');
		}
	}
	
	function billGenerationFormToDB()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
				
		}
		else
		{
			//bl,vessel,cont_size,cont_height
			
			
			//return;
			$ipaddr = $_SERVER['REMOTE_ADDR'];
			$login_id = $this->session->userdata('login_id');
			
			$verify_number = $this->input->post('verify_num');
			$bill_no = $this->input->post('bill_no');
			$da_bill_no = $this->input->post('da_bill_no');
			$bill_date = $this->input->post('bill_date');
			$rotation_no = $this->input->post('rotation_no');
			$arr_dt = $this->input->post('arr_dt');
			$comm_dt = $this->input->post('comm_dt');
			$wr_dt = $this->input->post('wr_dt');
			$ado_no = $this->input->post('ado_no');
			$ado_dt = $this->input->post('ado_dt');
			$ado_upto = $this->input->post('ado_upto');
			$one_stop_point = $this->input->post('one_stop_point');
			$ex_rate = $this->input->post('ex_rate');
			$bill_for = $this->input->post('bill_for');
			$unstfDt = $this->input->post('unstfDt');
			$wr_upto_dt = $this->input->post('wr_upto_dt');
			$be_no = $this->input->post('be_no');
			$be_dt = $this->input->post('be_dt');
			$less = $this->input->post('less');
			$part_bl = $this->input->post('part_bl');
			
			$cont_qty = $this->input->post('cont_qty');
			$cont_wht = $this->input->post('cont_wht');
			$cnfCode = $this->input->post('cnfCode');
			$cnfName = $this->input->post('cnfName');
			$impo_reg_no = $this->input->post('impo_reg_no');
			$impo_reg_name = $this->input->post('impo_reg_name');
			
			$total_port = $this->input->post('total_port');
			$total_vat = $this->input->post('total_vat');
			$total_mlwf = $this->input->post('total_mlwf');
			$less_amt_port = $this->input->post('less_amt_port');
			$less_amt_vat = $this->input->post('less_amt_vat');
			$grand_total = $this->input->post('grand_total');
						
			$remarks = $this->input->post('remarks');
			$extra_movement=$this->input->post('ext_mov_twnty');
			if($extra_movement=="")
			{
				$extra_movement=$this->input->post('ext_mov_forty');
			}
			$vessel_name = $this->input->post('vessel_name');
			$bl_no = $this->input->post('bl_no');
			$container_size = $this->input->post('container_size');
			$container_height = $this->input->post('container_height');
			
			$chkBillExistQuery="select count(bill_no) as chkRslt from shed_bill_master where verify_no='$verify_number'";
			$getBillRslt = $this->bm->dataSelectDb1($chkBillExistQuery);
			$billExist=$getBillRslt[0]['chkRslt'];
			//echo "Query : ".$billExist;
			if($billExist > 0)
			{
				echo "<font color='red'><b>Bill Already Generated.</b></font>";
					/*$shedMasterUpdateQry="update shed_bill_master 
											set wr_upto_date='$wr_upto_dt',
											total_port='$total_port',total_vat='$total_vat',total_mlwf='$total_mlwf',
											less_amt_port='$less_amt_port',less_amt_vat='$less_amt_vat',grand_total='$grand_total'
											where verify_no='$verify_number'
										";
					
					$shedMasterUpdate=$this->bm->dataInsertDB1($shedMasterUpdateQry);
					
					if($shedMasterUpdate==1)
					{
						$strDeleteQry="delete from shed_bill_details where verify_no='$verify_number'";
						$statDel = $this->bm->dataInsertDB1($strDeleteQry);
						
						for($i=0; $i<=$this->input->post('tbl_total_row');$i++)
					   {
						
						if($this->input->post('tarrif_id'.$i)!="")
						{
							$tarrif_id= $this->input->post('tarrif_id'.$i);
							$billHead= $this->input->post('billHead'.$i);
							$gl_code= $this->input->post('option'.$i);
							$rate= $this->input->post('rate'.$i);
							$qty= $this->input->post('qty'.$i);
							$qday= $this->input->post('qday'.$i);
							$weight= $this->input->post('weight'.$i);
							$mlwf= $this->input->post('mlwf'.$i);
							$vatTK= $this->input->post('vatTK'.$i);
							$amt= $this->input->post('amt'.$i);
							
						
							
							
							$strUpdateEq="insert into shed_bill_details(verify_no,bill_no,gl_code,description,tarrif_rate,Qty,qday,amt,vatTK,mlwfTK) 
											values('$verify_number','$bill_no','$gl_code','$billHead','$rate','$qty','$qday','$amt','$vatTK','$mlwf')";											
							$stat = $this->bm->dataInsertDB1($strUpdateEq);
						}
					   }
					
					   echo "<font color='green'><b>Bill Updated. Bill No: ".$bill_no."</b></font> <a href='".site_url('ShedBillController/getShedBillPdf/'.$verify_number)."' target='_blank'>View Bill</a>";
					}
					else{
						
						echo "<font color='red'><b>Bill Not Updated</b></font>";
					}
					
				*/
			}
			else
			{
					$billGenNoQuery="select IFNULL(MAX(bill_generation_no),0)+1 as bill_generation_no from shed_bill_master where right(YEAR(now()),2)=".date('y');
					$billGenNo = $this->bm->dataSelectDb1($billGenNoQuery);
					$getBillGenNo = $billGenNo[0]['bill_generation_no'];
					//echo $getBillGenNo;
				$shedMasterInsertQry="insert into shed_bill_master (verify_no,unit_no,cpa_vat_reg_no,ex_rate,bill_date,
										arraival_date,import_rotation,vessel_name,
										cl_date,bl_no,wr_date,wr_upto_date,importer_vat_reg_no,importer_name,cnf_lic_no,cnf_agent,
										be_no,be_date,ado_no,ado_date,ado_valid_upto,
										manifest_qty,cont_size,cont_height,cont_weight,da_bill_no,bill_for,less,part_bl,remarks,extra_movement,total_port,
										total_vat,total_mlwf,less_amt_port,less_amt_vat,grand_total,user,ip_address,entry_dt,bill_generation_no) 
										values 
										('$verify_number','$one_stop_point','2041001546','$ex_rate','$bill_date','$arr_dt','$rotation_no',
										 '$vessel_name','$comm_dt','$bl_no','$wr_dt',
										 '$wr_upto_dt','$impo_reg_no','$impo_reg_name','$cnfCode','$cnfName',
										 '$be_no','$be_dt','$ado_no','$ado_dt','$ado_upto','$cont_qty','$container_size','$container_height','$cont_wht','$da_bill_no',
										 '$bill_for','$less','$part_bl','$remarks','$extra_movement','$total_port','$total_vat','$total_mlwf','$less_amt_port','$less_amt_vat',
										 '$grand_total','$login_id','$ipaddr',now(),$getBillGenNo)";								 
										
					//echo $shedMasterInsertQry;
					$shedMasterInsert=$this->bm->dataInsertDB1($shedMasterInsertQry);
					$chkBillNoQuery="select bill_no from shed_bill_master where verify_no='$verify_number' order by bill_no desc limit 1";
					$getBillNo = $this->bm->dataSelectDb1($chkBillNoQuery);
					$bill=$getBillNo[0]['bill_no'];
					
					if($shedMasterInsert==1)
					{
						for($i=0; $i<=$this->input->post('tbl_total_row');$i++)
					   {
						//echo $truckNumber[$i];
						if($this->input->post('tarrif_id'.$i)!="")
						{
							$tarrif_id= $this->input->post('tarrif_id'.$i);
							$billHead= $this->input->post('billHead'.$i);
							$gl_code= $this->input->post('option'.$i);
							$rate= $this->input->post('rate'.$i);
							$qty= $this->input->post('qty'.$i);
							$qday= $this->input->post('qday'.$i);
							$weight= $this->input->post('weight'.$i);
							$mlwf= $this->input->post('mlwf'.$i);
							$vatTK= $this->input->post('vatTK'.$i);
							$amt= $this->input->post('amt'.$i);
							
							$strInsertEq = "insert into shed_bill_details (verify_no,bill_no,gl_code,description,tarrif_rate,Qty,qday,amt,vatTK,mlwfTK) 
																values 
																('$verify_number','$bill','$gl_code','$billHead','$rate',
																	'$qty','$qday','$amt','$vatTK','$mlwf')";  	  
							$stat = $this->bm->dataInsertDB1($strInsertEq);
						}
					   }
					   //echo "<a href='/ShedBillController/getShedBillPdf/'".$verify_number."><font color='green'><b>Bill Successfully Created For The Verification No: ".$verify_number."</b></font></a>";
					   //$data['msg']="<font color='green'><b>Bill Successfully Created</b></font>";
					   //echo site_url('ShedBillController/getShedBillPdf/'.$verify_number)
					   //echo "";
					   //$site_url='ShedBillController/getShedBillPdf/';
					   //echo "<font color='green'><b>Bill Generated. Bill No: ".$bill."</b></font></br>";
					   //echo "<a target='_blank' href='site_url('ShedBillController/getShedBillPdf/'".$verify_number."')><font color='green'><b>View Bill</b></font></a>'";
					
					$rtnBillQuery="select concat(right(YEAR(bill_date),2),'/',
								concat(if(length(bill_generation_no)=1,'00000',if(length(bill_generation_no)=2,'0000',if(length(bill_generation_no)=3,'000',
								if(length(bill_generation_no)=4,'00',if(length(bill_generation_no)=5,'0',''))))),bill_generation_no)) as bill_no from shed_bill_master where verify_no='$verify_number'";
					$rtnBillNo = $this->bm->dataSelectDb1($rtnBillQuery);
					$billNo=$rtnBillNo[0]['bill_no'];
					
					echo "<font color='green'><b>Bill Generated. Bill No: ".$billNo."</b></font> <a href='".site_url('ShedBillController/getShedBillPdf/'.$verify_number)."' target='_blank'>View Bill</a>";
					 
					 
					 // echo "<a target='_blank' href='/ShedBillController/getShedBillPdf/".$verify_number'"><font color='green'><b>View Bill</b></font></a>";
					}
					else{
						//$data['msg']="<font color='red'><b>Bill Not Created</b></font>";
						echo "<font color='red'><b>Bill Not Created</b></font>";
					}
				
				
			}
			/*$getBillTarrifQuery= "select id,bil_tariffs.description,long_description,bil_tariffs.gl_code,effective_date,rate_type,amount from bil_tariffs inner join bil_tariff_rates on 
								  bil_tariffs.gkey=bil_tariff_rates.tariff_gkey ORDER BY ID ASC ";
			$getBillTarrif = $this->bm->dataSelectDb1($getBillTarrifQuery);
			$data['verify_num']=$verify_number;
			$data['billVerify']=$verify_number;
			$data['getBillTarrif']=$getBillTarrif;			
			$data['title']="BILL GENERATION";
			$this->load->view('header5');
			$this->load->view('billGenerationForm',$data);   
			$this->load->view('footer_1');*/
		}
	}
	
	//-----Bill Delete start
	function billDeletePerform()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
				
		}
		else
		{
			$verify_no=$this->input->post('vrfno');
			$bill_no=$this->input->post('sdbillno');
			
			$sql_delete_master="DELETE FROM shed_bill_master
						WHERE bill_no='$bill_no' AND verify_no='$verify_no'";
						
			$rslt_delete_master = $this->bm->dataDeleteDB1($sql_delete_master);
			
			$sql_delete_details="DELETE FROM shed_bill_details
						WHERE bill_no='$bill_no' AND verify_no='$verify_no'";
						
			$rslt_delete_details = $this->bm->dataDeleteDB1($sql_delete_details);
			
			$sqlbillno = "SELECT shed_bill_master.bill_no AS bn,CONCAT(RIGHT(YEAR(bill_date),2),'/',CONCAT(IF(LENGTH(bill_generation_no)=1,'00000',IF(LENGTH(bill_generation_no)=2,'0000',IF(LENGTH(bill_generation_no)=3,'000',IF(LENGTH(bill_generation_no)=4,'00',IF(LENGTH(bill_generation_no)=5,'0',''))))),bill_generation_no)) AS bill_no,shed_bill_master.verify_no,unit_no,import_rotation,cnf_agent,SUM(amt) AS total_amt,SUM(vatTk) AS total_vat,total_port,total_mlwf 
			FROM shed_bill_details 
			INNER JOIN shed_bill_master ON shed_bill_master.bill_no=shed_bill_details.bill_no 
			GROUP BY shed_bill_master.bill_no ORDER BY bill_no DESC";
		
			$rtnbillno = $this->bm->dataSelectDb1($sqlbillno);
			
			$data['rtnbillno']=$rtnbillno;
			$data['title']="SHED BILL LIST FORM...";
			$this->load->view('header2');
			$this->load->view('shedBillListForm',$data);
			$this->load->view('footer');
		}
	}
	//-----Bill Delete end
	
	//unit set or update start
	function unitSetUpdate()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$msg="";
			$value=0;
			
			$data['title']="UNIT UPDATE...";
			$data['msg']=$msg;
			$data['value']=$value;
			$this->load->view('header2');
			$this->load->view('unitSetUpdate',$data);
			$this->load->view('footer');
		}
	}
	
	function unitSetUpdatePerform()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$rotation=$this->input->post('rotation');
			$unit=$this->input->post('unit');
			
			$sql_check="select count(*) as rtnValue from assigned_unit where rotation='$rotation'";
			$rtn_check=$this->bm->dataReturnDB1($sql_check);
			
			$value=0;
			
			if($rtn_check==0)
			{
				$sql_insert="insert into assigned_unit(rotation,unit_no) values('$rotation','$unit')";
				$rslt_insert=$this->bm->dataInsertDB1($sql_insert);
				$msg="<font color='green'><b>Successfully inserted</b></font>";
			}
			else
			{
				$sql_update="update assigned_unit set unit_no='$unit' where rotation='$rotation'";
				$rslt_update=$this->bm->dataUpdateDB1($sql_update);
				$msg="<font color='green'><b>Successfully updated</b></font>";
			}
			
			$data['title']="UNIT UPDATE...";
			$data['msg']=$msg;
			$data['value']=$value;
			$this->load->view('header2');
			$this->load->view('unitSetUpdate',$data);
			$this->load->view('footer');
		}
	}
	//unit set or update end
	
	//unit list start
	function unitList()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$sql_list="select * from assigned_unit";
			$rslt_list=$this->bm->dataSelectDB1($sql_list);
			$msg="";
			
			$data['title']="UNIT LIST...";
			$data['rslt_list']=$rslt_list;
			$data['msg']=$msg;
			$this->load->view('header2');
			$this->load->view('unitList',$data);
			$this->load->view('footer');
		}
	}
	
	function unitListSearch()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$rotation=$this->input->post('rotation');
			$msg="";
			
			$sql_list="select * from assigned_unit where rotation='$rotation'";
			$rslt_list=$this->bm->dataSelectDB1($sql_list);
			
			$data['title']="UNIT LIST...";
			$data['rslt_list']=$rslt_list;
			$data['msg']=$msg;
			$this->load->view('header2');
			$this->load->view('unitList',$data);
			$this->load->view('footer');
		}
	}
	//unit list end
	
	//unit list delete start
	function unitListDelete()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$rotation=$this->input->post('rot');
			$unit=$this->input->post('unit');
			$msg="<font color='green'><b>Successfully Deleted</b></font>";
			
			$sql_delete="DELETE FROM assigned_unit WHERE rotation='$rotation' AND unit_no='$unit'";
			
			$rslt_delete = $this->bm->dataDeleteDB1($sql_delete);
			
			$sql_list="select * from assigned_unit";
			$rslt_list=$this->bm->dataSelectDB1($sql_list);
			
			$data['title']="UNIT LIST...";
			$data['rslt_list']=$rslt_list;
			$data['msg']=$msg;
			$this->load->view('header2');
			$this->load->view('unitList',$data);
			$this->load->view('footer');
		}
	}
	//unit list delete end
	
	//unit list edit start
	function unitListEdit()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$rotation=$this->input->post('rt_no');
			$msg="";
			$value=1;
			
			$data['title']="UNIT UPDATE...";
			$data['msg']=$msg;
			$data['value']=$value;
			$data['rotation']=$rotation;
			$this->load->view('header2');
			$this->load->view('unitSetUpdate',$data);
			$this->load->view('footer');
		}
	}
	//unit list edit end
}
?>