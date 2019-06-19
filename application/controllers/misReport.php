<?php
class misReport extends CI_Controller {
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
	
	function A23_1Form()
	{
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$data['title']="REPORT FORM...";
			$this->load->view('header2');
			$this->load->view('misA23_1HTML',$data);
			$this->load->view('footer');
		}
	}
	
	function A23_1Report()
	{  
		$fromdate=$this->input->post('fromdate');
		$data['fromdate']=$fromdate;
		$this->load->view('misA23_1Report',$data);
		$this->load->view('myclosebar');	  
	}
	// Equipment Indent
	function mis_equipment_indent()
	{
		//print_r($this->session->all_userdata());
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$query = "select id,yard_name from ctmsmis.mis_equip_indent where type='YARD' ORDER BY yard_name ASC";
			$rtnBlockList = $this->bm->dataSelect($query);
			
			$queryShed = "select id,yard_name from ctmsmis.mis_equip_indent where type='SHED' ORDER BY yard_name ASC";
			$rtnShedList = $this->bm->dataSelect($queryShed);
			$data['rtnShedList']=$rtnShedList;
			
			$data['title']="EQUIPMENT INDENT...";
			$data['msg']="";
			$data['editFlag']=0;
			
			$data['rtnBlockList']=$rtnBlockList;
			$data['indent_details']="";
			$this->load->view('header2');
			$this->load->view('mis_equipment_indent_form',$data);
			$this->load->view('footer');
		}	
    }
	function mis_equipment_indent_entry()
	{
		//print_r($this->session->all_userdata());
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$msg="";
			$cnf_code=$this->input->post('cnf_lic_no');
			$indent_dt=$this->input->post('indent_dt');
			$cnf_name=$this->input->post('cnf_name');
			$no_of_cont=$this->input->post('no_of_cont');
			$description=$this->input->post('description');
			$tot_weight=$this->input->post('tot_weight');
			$max_weight_pkg=$this->input->post('max_weight');
			$equip_rrc=$this->input->post('equip_rrc');
			
			$equip_flt=$this->input->post('equip_flt');
			$equip_mc=$this->input->post('equip_mc');
			
			$no_of_rrc=$this->input->post('no_of_rrc');
			$no_of_flt=$this->input->post('no_of_flt');
			$no_of_mc=$this->input->post('no_of_mc');
			
			$equip_flt_3t="";
			$equip_flt_5t="";
			$equip_flt_10t="";
			$equip_flt_20t="";
			
			$equip_mc_10t="";
			$equip_mc_20t="";
			$equip_mc_30t="";
			$equip_mc_50t="";
			
			$equip_rrc_1t="";
			
			if($equip_rrc=="RRC")
			{
				$equip_rrc_1t="1";
			}
			
			if($equip_flt=="3T")
			{
				$equip_flt_3t="1";
			}
			else if($equip_flt=="5T")
			{
				$equip_flt_5t="1";
			}
			else if($equip_flt=="10T")
			{
				$equip_flt_10t="1";
			}
			else if($equip_flt=="20T")
			{
				$equip_flt_20t="1";
			}
			
			if($equip_mc=="10T")
			{
				$equip_mc_10t="1";
			}
			else if($equip_mc=="20T")
			{
				$equip_mc_20t="1";
			}
			else if($equip_mc=="30T")
			{
				$equip_mc_30t="1";
			}
			else if($equip_mc=="50T")
			{
				$equip_mc_50t="1";
			}
			
			$yard=$this->input->post('yard');
			if($yard=="")
			{
				$yard=$this->input->post('shed');
			}
			
			$ipaddr = $_SERVER['REMOTE_ADDR'];
			$enter_by=$this->session->userdata('login_id');
			
			
			if($this->input->post('update'))
			{ 
				$indentid=$this->input->post('indentid'); 
				//echo $rId;

				$updateSql="UPDATE ctmsmis.mis_equip_indent_entry set 
				cnf_code='$cnf_code',cnf_name='$cnf_name',no_of_container='$no_of_cont',goods_description='$description',total_weight='$tot_weight',
				max_weight_pkg='$max_weight_pkg',equip_rrc='$equip_rrc_1t',equip_flt_3t='$equip_flt_3t',equip_flt_5t='$equip_flt_5t',
				equip_flt_10t='$equip_flt_10t',equip_flt_20t='$equip_flt_20t',equip_mc_10t='$equip_mc_10t',equip_mc_20t='$equip_mc_20t',
				equip_mc_30t='$equip_mc_30t',equip_mc_50t='$equip_mc_50t',indent_yard_id=$yard,no_of_rrc='$no_of_rrc',no_of_flt='$no_of_flt',no_of_mc='$no_of_mc',
				entry_dt='$indent_dt'
				where id='$indentid'";   
	
				$updateStat=$this->bm->dataUpdate($updateSql);  

				   if($updateStat==1)
				   {
					   $msg="<font size=3 color=green>Data updated successfully.</font>";
				   }
				   else {
					   $msg="<font size=3 color=red>Data not updated.</font>";
				   }
			}
			
			else
			{
				$sqlQuery="INSERT INTO ctmsmis.mis_equip_indent_entry (cnf_code,cnf_name,no_of_container,goods_description,total_weight,
				max_weight_pkg,equip_rrc,equip_flt_3t,equip_flt_5t,equip_flt_10t,equip_flt_20t,equip_mc_10t,equip_mc_20t,
				equip_mc_30t,equip_mc_50t,indent_yard_id,ip_addr,entry_dt,enter_by,no_of_rrc,no_of_flt,no_of_mc,indent_entry_dt) 
				VALUES ('$cnf_code','$cnf_name','$no_of_cont','$description','$tot_weight','$max_weight_pkg','$equip_rrc_1t','$equip_flt_3t','$equip_flt_5t',
				'$equip_flt_10t','$equip_flt_20t','$equip_mc_10t','$equip_mc_20t','$equip_mc_30t','$equip_mc_50t',$yard,'$ipaddr','$indent_dt','$enter_by',
				'$no_of_rrc','$no_of_flt','$no_of_mc',now())";
				//echo $sqlQuery;
				//return ;
				
				$rslt_query=$this->bm->dataInsert($sqlQuery);
				
				if($rslt_query>0)
				{
					$msg="<font color='green'><b>Data Successfully Inserted.</font>";
				}
				else
				{
					$msg="<font color='red'><b>Data Not Inserted.</font>";
				}
			}
			
			$queryShed = "select id,yard_name from ctmsmis.mis_equip_indent where type='SHED' ORDER BY yard_name ASC";
			$rtnShedList = $this->bm->dataSelect($queryShed);
			$data['rtnShedList']=$rtnShedList;
			
			$query = "select id,yard_name from ctmsmis.mis_equip_indent where type='YARD' ORDER BY yard_name ASC";
			$rtnBlockList = $this->bm->dataSelect($query);
			
			$data['rtnBlockList']=$rtnBlockList;
			$data['title']="EQUIPMENT INDENT...";
			$data['msg']=$msg;
			$this->load->view('header2');
			$this->load->view('mis_equipment_indent_form',$data);
			$this->load->view('footer');
		}	
    }
	function mis_equipment_indent_list()
	{
		//print_r($this->session->all_userdata());
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$sql_user_num="select count(*) as rtnValue from ctmsmis.mis_equip_indent_entry";			
			$segment_three = $this->uri->segment(3);				
			$config = array();
			$config["base_url"] = site_url("report/mis_equipment_indent_list/$segment_three");
			
			$config["total_rows"] = $this->bm->dataReturn($sql_user_num);
			
			//echo "hh : ".$config["total_rows"];
			$config["per_page"] = 30;
			$offset = $this->uri->segment(4, 0);
			$config["uri_segment"] = 4;
			$limit=$config["per_page"];
			
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;				
			$start=$page;

			if($this->input->post('delete'))
			{
				$indentId=$this->input->post('indentid');
				$deleteSql="DELETE FROM ctmsmis.mis_equip_indent_entry WHERE id='$indentId'";
				$deleteStat=$this->bm->dataInsert($deleteSql);
			}
			
			$listSql="SELECT mis_equip_indent_entry.id,yard_name,cnf_code,cnf_name,no_of_container,goods_description,total_weight,
			max_weight_pkg,equip_rrc,equip_flt_3t,equip_flt_5t,equip_flt_10t,equip_flt_20t,equip_mc_10t,equip_mc_20t,
			equip_mc_30t,equip_mc_50t,indent_yard_id,ip_addr,entry_dt,enter_by,no_of_rrc,no_of_flt,no_of_mc,DATE(entry_dt) as indent_date 
			FROM ctmsmis.mis_equip_indent_entry
			INNER JOIN ctmsmis.mis_equip_indent ON mis_equip_indent_entry.indent_yard_id=mis_equip_indent.id
			ORDER BY mis_equip_indent_entry.id DESC limit $start,$limit";
		   //echo $listSql;
			$list=$this->bm->dataSelect($listSql);
			
			$data['list']=$list;
			$data['start']=$start;
			$data["links"] = $this->pagination->create_links();
			
			$data['tableTitle']="INDENT LIST";
			$this->load->view('header5');
			$this->load->view('mis_equipment_indent_list',$data);
			$this->load->view('footer_1');
		}	
    }
	function mis_equipment_indent_list_Search()
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
  
		 if($search_by=="entry_date")
		{
			$searchDt=trim($this->input->post('searchDt'));
			
			$data['tableTitle']="Search Date:  ".$searchDt;			
			
			$listSql="SELECT mis_equip_indent_entry.id,yard_name,cnf_code,cnf_name,no_of_container,goods_description,total_weight,
			max_weight_pkg,equip_rrc,equip_flt_3t,equip_flt_5t,equip_flt_10t,equip_flt_20t,equip_mc_10t,equip_mc_20t,
			equip_mc_30t,equip_mc_50t,indent_yard_id,ip_addr,entry_dt,enter_by,no_of_rrc,no_of_flt,no_of_mc,DATE(entry_dt) as indent_date 
			FROM ctmsmis.mis_equip_indent_entry
			INNER JOIN ctmsmis.mis_equip_indent ON mis_equip_indent_entry.indent_yard_id=mis_equip_indent.id
			WHERE DATE(entry_dt)='$searchDt'
			ORDER BY mis_equip_indent_entry.id DESC";            
		}

		else if($search_by=="yard")
		{
			$yard=trim($this->input->post('searchVal'));
			
			
			$listSql="SELECT mis_equip_indent_entry.id,yard_name,cnf_code,cnf_name,no_of_container,goods_description,total_weight,
			max_weight_pkg,equip_rrc,equip_flt_3t,equip_flt_5t,equip_flt_10t,equip_flt_20t,equip_mc_10t,equip_mc_20t,
			equip_mc_30t,equip_mc_50t,indent_yard_id,ip_addr,entry_dt,enter_by,no_of_rrc,no_of_flt,no_of_mc,DATE(entry_dt) as indent_date 
			FROM ctmsmis.mis_equip_indent_entry
			INNER JOIN ctmsmis.mis_equip_indent ON mis_equip_indent_entry.indent_yard_id=mis_equip_indent.id
			WHERE indent_yard_id='$yard'
			ORDER BY mis_equip_indent_entry.id DESC";   
			
			$listYard=$this->bm->dataSelect($listSql);
			
			$data['tableTitle']="Search Yard:  ".$listYard[0]['yard_name'];		
				   
		}
		 else if($search_by=="cnf_license")
		{
			$cnf_license=trim($this->input->post('searchInput'));
			$data['tableTitle']="Cnf License:  ".$cnf_license;	
			
			$listSql="SELECT mis_equip_indent_entry.id,yard_name,cnf_code,cnf_name,no_of_container,goods_description,total_weight,
			max_weight_pkg,equip_rrc,equip_flt_3t,equip_flt_5t,equip_flt_10t,equip_flt_20t,equip_mc_10t,equip_mc_20t,
			equip_mc_30t,equip_mc_50t,indent_yard_id,ip_addr,entry_dt,enter_by,no_of_rrc,no_of_flt,no_of_mc,DATE(entry_dt) as indent_date 
			FROM ctmsmis.mis_equip_indent_entry
			INNER JOIN ctmsmis.mis_equip_indent ON mis_equip_indent_entry.indent_yard_id=mis_equip_indent.id
			WHERE cnf_code='$cnf_license'
			ORDER BY mis_equip_indent_entry.id DESC";   
		   
		}
		
		$list=$this->bm->dataSelect($listSql);
		$data['list']=$list;

		$this->load->view('header5');
		$this->load->view('mis_equipment_indent_list',$data);
		$this->load->view('footer_1');
		   
		}
		
	}
	function mis_equipment_indent_list_Edit()
	{
		$login_id = $this->session->userdata('login_id');
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
				$this->logout();
		}
		else
		{
			$indentid=$this->input->post('indentid');
			
			$selectSql="SELECT mis_equip_indent_entry.id,yard_name,cnf_code,cnf_name,no_of_container,goods_description,total_weight,
			max_weight_pkg,equip_rrc,equip_flt_3t,equip_flt_5t,equip_flt_10t,equip_flt_20t,equip_mc_10t,equip_mc_20t,
			equip_mc_30t,equip_mc_50t,indent_yard_id,ip_addr,entry_dt,enter_by,no_of_rrc,no_of_flt,no_of_mc ,DATE(entry_dt) as indent_date 
			FROM ctmsmis.mis_equip_indent_entry
			INNER JOIN ctmsmis.mis_equip_indent ON mis_equip_indent_entry.indent_yard_id=mis_equip_indent.id
			WHERE mis_equip_indent_entry.id='$indentid'";
			//echo $selectSql;
            //return;
			$indent_details=$this->bm->dataSelect($selectSql);
			$data['indent_details']=$indent_details;
			
			$queryShed = "select id,yard_name from ctmsmis.mis_equip_indent where type='SHED' ORDER BY yard_name ASC";
			$rtnShedList = $this->bm->dataSelect($queryShed);
			$data['rtnShedList']=$rtnShedList;
			
			$query = "select id,yard_name from ctmsmis.mis_equip_indent where type='YARD' ORDER BY yard_name ASC";
			$rtnBlockList = $this->bm->dataSelect($query);
			$data['rtnBlockList']=$rtnBlockList;
			
			$data['editFlag']=1;

			$data['title']="EQUIPMENT INDENT ...";
			$data['msg']="";

			$this->load->view('header2');
			$this->load->view('mis_equipment_indent_form',$data);
			$this->load->view('footer');
		}
	}
	function mis_equipment_indent_report()
	{
		$session_id = $this->session->userdata('value');			
		if($session_id!=$this->session->userdata('session_id'))			
		{				
			$this->logout();			
		}			
		else			
		{				
			$data['title']="EQUIPMENT INDENT REPORT";				
			//echo $data['title'];				
			$this->load->view('header2');				
			$this->load->view('equipmentIndentReportForm',$data);				
			$this->load->view('footer');			
		}	
	}
	
	function mis_equipment_indent_report_view()
	{
		$indent_date=$this->input->post('indent_date');
	//	return;
		$this->load->library('m_pdf');
		$pdf->use_kwt = true;
		$this->data['title']="EQUIPMENT INDENT REPORT";
		$this->data['indent_date']=$indent_date;
		
		
		$pdfFilePath ="EQUIPMENT INDENT REPORT-".time()."-download.pdf";
		$pdf = $this->m_pdf->load();
		$pdf->useAdobeCJK = true;
		$pdf->SetAutoFont(AUTOFONT_ALL);
		//$pdf->SetFont('bangla_solaiman');
		$html=$this->load->view('mis_equipment_indent_rpt_view',$this->data, true);
		$stylesheet = file_get_contents('resources/styles/test.css'); // external css
		$pdf->useSubstitutions = true; // optional - just as an example
		
		$pdf->setFooter('Developed By : DataSoft|Page {PAGENO} of {nb}|Date {DATE j-m-Y}');
		
		$pdf->WriteHTML($stylesheet,1);
		$pdf->WriteHTML($html,2);
		$pdf->Output($pdfFilePath, "I"); // For Show Pdf
	}
	
	
		
	function equipmentUnstuffing()
	{
		//print_r($this->session->all_userdata());
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			$str1 = "SELECT DISTINCT(sparcsn4.vsl_vessel_visit_details.flex_string03) AS berthop 
					FROM sparcsn4.vsl_vessel_visit_details WHERE sparcsn4.vsl_vessel_visit_details.flex_string03 IS NOT NULL limit 8";
			$bertg_opList = $this->bm->dataSelect($str1);
			$data['bertg_opList']=$bertg_opList;
		/* 	$query = "select id,yard_name from ctmsmis.mis_equip_indent ORDER BY yard_name ASC";
			$rtnBlockList = $this->bm->dataSelect($query); */
			
			$data['title']="EQUIPMENT UNSTUFFING FORM...";
			$data['msg']="";
			$data['editFlag']=0;
			$data['indent_details']="";
			$this->load->view('header2');
			$this->load->view('equipmentUnstuffing_form',$data);
			$this->load->view('footer');
		}	
    }
	
	function equipmentUnstuffing_entry()
	{
		//print_r($this->session->all_userdata());
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{ 
			$msg="";
			$berth_op=$this->input->post('berth_op');
			$un_dt=$this->input->post('un_dt');
			$rot_no=$this->input->post('rot_no');
			$vsl_name=$this->input->post('vsl_name');
			$upr_no=$this->input->post('upr_no');
			$shed_no=$this->input->post('shed_no');
			$buskar=$this->input->post('buskar');
			$long_trolly=$this->input->post('long_trolly');
			
			$equip_flt=$this->input->post('equip_flt');
			$equip_mc=$this->input->post('equip_mc');
			
			$no_of_flt=$this->input->post('no_of_flt');
			$no_of_mc=$this->input->post('no_of_mc');
			
			$equip_flt_3t="";
			$equip_flt_5t="";
			$equip_flt_10t="";
			$equip_flt_20t="";
			
			$equip_mc_10t="";
			$equip_mc_20t="";
			$equip_mc_30t="";
			$equip_mc_50t="";
			
			
			if($equip_flt=="3T")
			{
				$equip_flt_3t="1";
			}
			else if($equip_flt=="5T")
			{
				$equip_flt_5t="1";
			}
			else if($equip_flt=="10T")
			{
				$equip_flt_10t="1";
			}
			else if($equip_flt=="20T")
			{
				$equip_flt_20t="1";
			}
			
			if($equip_mc=="10T")
			{
				$equip_mc_10t="1";
			}
			else if($equip_mc=="20T")
			{
				$equip_mc_20t="1";
			}
			else if($equip_mc=="30T")
			{
				$equip_mc_30t="1";
			}
			else if($equip_mc=="50T")
			{
				$equip_mc_50t="1";
			}
			
			
			$ipaddr = $_SERVER['REMOTE_ADDR'];
			$enter_by=$this->session->userdata('login_id');
			
			 if($this->input->post('update'))
			   { 
					$unstuffid=$this->input->post('unstuffid'); 
                    //echo $rId;

                    $updateSql="UPDATE ctmsmis.mis_equip_unstuffing set rotation ='$rot_no', vsl_name='$vsl_name', berth_op='$berth_op',
                            up_no='$upr_no', shed_no='$shed_no', buskar='$buskar', long_trolly='$long_trolly',flt_3t='$equip_flt_3t',flt_5t='$equip_flt_5t',
							flt_10t='$equip_flt_10t',flt_20t='$equip_flt_20t',mc_10t='$equip_mc_10t',mc_20t='$equip_mc_20t',
							mc_30t='$equip_mc_30t',mc_50t='$equip_mc_50t', no_of_flt='$no_of_flt', no_of_mc='$no_of_mc',
							entry_by='$enter_by', entry_date='$un_dt', ipAddr='$ipaddr',unstuffing_entry_dt=now()
                            where mis_equip_unstuffing.id='$unstuffid'";   
		//echo $updateSql;
                     $updateStat=$this->bm->dataUpdate($updateSql);  

                       if($updateStat==1)
                       {
                           $msg="<font size=3 color=green>Data updated successfully.</font>";
                       }
                       else {
                           $msg="<font size=3 color=red>Data not updated.</font>";
                       }
				}
			  else{
					$sqlQuery="INSERT INTO ctmsmis.mis_equip_unstuffing (rotation, vsl_name, berth_op, up_no, shed_no, buskar, long_trolly, flt_3t, flt_5t, flt_10t, flt_20t, mc_10t, mc_20t, mc_30t, mc_50t,
					no_of_flt, no_of_mc, entry_date,entry_by, ipAddr,unstuffing_entry_dt) VALUES ('$rot_no','$vsl_name','$berth_op','$upr_no','$shed_no','$buskar','$long_trolly','$equip_flt_3t','$equip_flt_5t',
					'$equip_flt_10t','$equip_flt_20t','$equip_mc_10t', '$equip_mc_20t', '$equip_mc_30t', '$equip_mc_50t', '$no_of_flt', '$no_of_mc',
					'$un_dt','$enter_by','$ipaddr',now())";
				//	echo $sqlQuery;
				//	return ;
					
					$rslt_query=$this->bm->dataInsert($sqlQuery);
					
					if($rslt_query>0)
					{
						$msg="<font color='green'><b>Data Successfully Inserted.</font>";
					}
					else
					{
						$msg="<font color='red'><b>Data Not Inserted.</font>";
					}
				  }
			$str1 = "SELECT DISTINCT(sparcsn4.vsl_vessel_visit_details.flex_string03) AS berthop 
					FROM sparcsn4.vsl_vessel_visit_details WHERE sparcsn4.vsl_vessel_visit_details.flex_string03 IS NOT NULL limit 8";
			$bertg_opList = $this->bm->dataSelect($str1);
			$data['editFlag']=0;
			$data['bertg_opList']=$bertg_opList;
			
			$data['title']="EQUIPMENT UNSTUFFING FORM...";
			$data['msg']=$msg;
			$this->load->view('header2');
			$this->load->view('equipmentUnstuffing_form',$data);
			$this->load->view('footer');
		}	
    }
  
  
  function equipmentUnstuffingList()
  {
	  		//print_r($this->session->all_userdata());
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{
			if($this->input->post('delete'))
			{
				$unstuffid=$this->input->post('unstuffid');
				$deleteSql="DELETE FROM ctmsmis.mis_equip_unstuffing WHERE id='$unstuffid'";
				$deleteStat=$this->bm->dataDelete($deleteSql);
			}
			
			$sql_user_num="select count(*) as rtnValue from ctmsmis.mis_equip_unstuffing";			
			$segment_three = $this->uri->segment(3);				
			$config = array();
			$config["base_url"] = site_url("report/equipmentUnstuffingList/$segment_three");
			
			$config["total_rows"] = $this->bm->dataReturn($sql_user_num);
			
			//echo "hh : ".$config["total_rows"];
			$config["per_page"] = 30;
			$offset = $this->uri->segment(4, 0);
			$config["uri_segment"] = 4;
			$limit=$config["per_page"];
			
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;				
			$start=$page;		
			
			$listSql="SELECT ctmsmis.mis_equip_unstuffing.id,ctmsmis.mis_equip_unstuffing.rotation, ctmsmis.mis_equip_unstuffing.vsl_name, ctmsmis.mis_equip_unstuffing.berth_op, 
					ctmsmis.mis_equip_unstuffing.up_no, ctmsmis.mis_equip_unstuffing.shed_no, ctmsmis.mis_equip_unstuffing.buskar, 
					ctmsmis.mis_equip_unstuffing.long_trolly, 
					IF(flt_3t>0,no_of_flt,0) AS flt_3t,
					IF(flt_5t>0,no_of_flt,0) AS flt_5t,
					IF(flt_10t>0,no_of_flt,0) AS flt_10t,
					IF(flt_20t>0,no_of_flt,0) AS flt_20t,

					IF(mc_10t>0,no_of_mc,0) AS mc_10t,
					IF(mc_20t>0,no_of_mc,0) AS mc_20t,
					IF(mc_30t>0,no_of_mc,0) AS mc_30t,
					IF(mc_50t>0,no_of_mc,0) AS mc_50t,
					
					no_of_flt, no_of_mc, ctmsmis.mis_equip_unstuffing.entry_date, entry_by, ipAddr,date(ctmsmis.mis_equip_unstuffing.entry_date) as un_dt FROM ctmsmis.mis_equip_unstuffing ORDER BY entry_date DESC
					 limit $start,$limit";
		   //echo $listSql;
			$list=$this->bm->dataSelect($listSql);
			
			$data['list']=$list;
			$data['start']=$start;
			$data["links"] = $this->pagination->create_links();
			
			$data['tableTitle']="UNSTUFFING LIST";
			$this->load->view('header5');
			$this->load->view('equipmentUnstuffingList',$data);
			$this->load->view('footer_1');
		}
	}

	function equipmentUnstuffingList_Search()
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
			//echo $search_by;
			//return;		
  
		 if($search_by=="entry_date")
		{
			$searchDt=trim($this->input->post('searchDt'));
			
			$data['tableTitle']="Search Date:  ".$searchDt;			
			
			$listSql="SELECT ctmsmis.mis_equip_unstuffing.id,ctmsmis.mis_equip_unstuffing.rotation, ctmsmis.mis_equip_unstuffing.vsl_name, ctmsmis.mis_equip_unstuffing.berth_op, 
					ctmsmis.mis_equip_unstuffing.up_no, ctmsmis.mis_equip_unstuffing.shed_no, ctmsmis.mis_equip_unstuffing.buskar, 
					ctmsmis.mis_equip_unstuffing.long_trolly, 
					IF(flt_3t>0,no_of_flt,0) AS flt_3t,
					IF(flt_5t>0,no_of_flt,0) AS flt_5t,
					IF(flt_10t>0,no_of_flt,0) AS flt_10t,
					IF(flt_20t>0,no_of_flt,0) AS flt_20t,

					IF(mc_10t>0,no_of_mc,0) AS mc_10t,
					IF(mc_20t>0,no_of_mc,0) AS mc_20t,
					IF(mc_30t>0,no_of_mc,0) AS mc_30t,
					IF(mc_50t>0,no_of_mc,0) AS mc_50t,
					no_of_flt, no_of_mc, ctmsmis.mis_equip_unstuffing.entry_date, entry_by, ipAddr,date(ctmsmis.mis_equip_unstuffing.entry_date) as un_dt FROM ctmsmis.mis_equip_unstuffing 
					where date(ctmsmis.mis_equip_unstuffing.entry_date)='$searchDt'
					ORDER BY mis_equip_unstuffing.id DESC";      
			//echo $listSql;
			//return;					
		}

		 else if($search_by=="berth_op")
		{
			$berthOp=trim($this->input->post('searchVal'));
		
			$listSql="SELECT ctmsmis.mis_equip_unstuffing.id,ctmsmis.mis_equip_unstuffing.rotation, ctmsmis.mis_equip_unstuffing.vsl_name, ctmsmis.mis_equip_unstuffing.berth_op, 
					ctmsmis.mis_equip_unstuffing.up_no, ctmsmis.mis_equip_unstuffing.shed_no, ctmsmis.mis_equip_unstuffing.buskar, 
					ctmsmis.mis_equip_unstuffing.long_trolly, 
					IF(flt_3t>0,no_of_flt,0) AS flt_3t,
					IF(flt_5t>0,no_of_flt,0) AS flt_5t,
					IF(flt_10t>0,no_of_flt,0) AS flt_10t,
					IF(flt_20t>0,no_of_flt,0) AS flt_20t,

					IF(mc_10t>0,no_of_mc,0) AS mc_10t,
					IF(mc_20t>0,no_of_mc,0) AS mc_20t,
					IF(mc_30t>0,no_of_mc,0) AS mc_30t,
					IF(mc_50t>0,no_of_mc,0) AS mc_50t,
					no_of_flt, no_of_mc, ctmsmis.mis_equip_unstuffing.entry_date, entry_by, ipAddr,date(ctmsmis.mis_equip_unstuffing.entry_date) as un_dt FROM ctmsmis.mis_equip_unstuffing 
					WHERE  ctmsmis.mis_equip_unstuffing.berth_op='$berthOp' ORDER BY mis_equip_unstuffing.id DESC";   
			
			//echo $listSql;
			//return;
			$listBerth=$this->bm->dataSelect($listSql);
			
			$data['tableTitle']="Search Berth Operator:  ".$listBerth[0]['berth_op'];		
				   
		}
		
		$list=$this->bm->dataSelect($listSql);
		$data['list']=$list;

		$this->load->view('header5');
		$this->load->view('equipmentUnstuffingList',$data);
		$this->load->view('footer_1');
		   
		}
		
	}
	function equipmentUnstuffingList_edit()
	{
		$login_id = $this->session->userdata('login_id');
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
				$this->logout();
		}
		else
		{
			$unstuffid=$this->input->post('unstuffid');
			
			$selectSql="SELECT ctmsmis.mis_equip_unstuffing.id, ctmsmis.mis_equip_unstuffing.rotation, ctmsmis.mis_equip_unstuffing.vsl_name, ctmsmis.mis_equip_unstuffing.berth_op, 
					ctmsmis.mis_equip_unstuffing.up_no, ctmsmis.mis_equip_unstuffing.shed_no, ctmsmis.mis_equip_unstuffing.buskar, 
					ctmsmis.mis_equip_unstuffing.long_trolly, 
					IF(flt_3t>0,no_of_flt,0) AS flt_3t,
					IF(flt_5t>0,no_of_flt,0) AS flt_5t,
					IF(flt_10t>0,no_of_flt,0) AS flt_10t,
					IF(flt_20t>0,no_of_flt,0) AS flt_20t,

					IF(mc_10t>0,no_of_mc,0) AS mc_10t,
					IF(mc_20t>0,no_of_mc,0) AS mc_20t,
					IF(mc_30t>0,no_of_mc,0) AS mc_30t,
					IF(mc_50t>0,no_of_mc,0) AS mc_50t,
					no_of_flt, no_of_mc, ctmsmis.mis_equip_unstuffing.entry_date, entry_by, ipAddr,date(ctmsmis.mis_equip_unstuffing.entry_date) as un_dt FROM ctmsmis.mis_equip_unstuffing 
					WHERE mis_equip_unstuffing.id='$unstuffid'";
          // echo $selectSql;
          //     return;
			$indent_details=$this->bm->dataSelect($selectSql);
			$data['indent_details']=$indent_details;
			
			$str1 = "SELECT DISTINCT(sparcsn4.vsl_vessel_visit_details.flex_string03) AS berthop 
			FROM sparcsn4.vsl_vessel_visit_details WHERE sparcsn4.vsl_vessel_visit_details.flex_string03 IS NOT NULL limit 8";
			$bertg_opList = $this->bm->dataSelect($str1);
			$data['bertg_opList']=$bertg_opList;
			
			$data['editFlag']=1;
			$data['title']="EQUIPMENT UNSTUFFING FORM...";
			$data['msg']=$msg;
			$this->load->view('header2');
			$this->load->view('equipmentUnstuffing_form',$data);
			$this->load->view('footer');
		}
	}
  
}
?>