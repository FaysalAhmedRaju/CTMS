<?php

class menuDesignController extends CI_Controller {
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
	
	function sectionDetailsForm()
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
			$data['title']="Org Section Detail Form...";
			$this->load->view('header2');
			$this->load->view('sectionDetailForm',$data);
			$this->load->view('footer');
		}
	}
	
	
	function sectionDetailsFormPerform()
	{
		
		$session_id = $this->session->userdata('value');
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{	$data['tblFlag']=0;
			
			$orgTypeId=$this->input->post('orgType');
			$shortName=$this->input->post('shortName');
			$fullName=$this->input->post('fullName');
			
			
			$insertQuery="insert into cchaportdb.users_section_detail(short_name, full_name, org_type_id) 
							values ('$shortName','$fullName','$orgTypeId')";
							

			//echo $insertQuery;
			//return;
				$stat=$this->bm->dataInsertDB1($insertQuery);
				if($stat==1)
				{
					$data['msg']="<font color='green'><b>Data Successfully Inserted.</b></font>";
				}
				else
				{
					$data['msg']="<font color='red'><b>Data Not Inserted.</b></font>";
				}

			$data['title']="Org Section Detail Form...";
			$this->load->view('header2');
			$this->load->view('sectionDetailForm',$data);
			$this->load->view('footer');
		}
	}
	

	
	
	//sidebar start
	function sidebarForm()
	{
		$session_id = $this->session->userdata('value');			
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{   
			$msg="";
			$data['title']="SIDEBAR FORM...";
			$data['msg']=$msg;
				
			$this->load->view('header2');
			$this->load->view('sidebarForm',$data);
			$this->load->view('footer');
		}
	}
	
	function sidebarDataInsert()
	{
		$session_id = $this->session->userdata('value');			
		if($session_id!=$this->session->userdata('session_id'))
		{
			$this->logout();
		}
		else
		{   
			//	$orgTypeID=$this->input->post('orgType');
			//	$section_id=$this->input->post('section');
			//	$menuType=$this->input->post('menuType');
			
			$login_id = $this->session->userdata('login_id');
			$ipaddr = $_SERVER['REMOTE_ADDR'];
			
			$loginID=$this->input->post('loginID');  //
			$tbl_org_types_id=$this->input->post('tbl_org_types_id');
			$users_section_detail_id=$this->input->post('users_section_detail_id');
			$url_id=$this->input->post('urlName');
			
			$sql_check="SELECT count(*) as rtnValue 
			FROM user_prev 
			WHERE url_id='$url_id'";
						
			$count=$this->bm->dataReturnDb1($sql_check);
			
			if($count==1)
			{
				$sql_update="UPDATE user_prev
				SET login_id='$loginID',tbl_org_type_id='$tbl_org_types_id',section_id='$users_section_detail_id',url_id='$url_id',last_update=now(),update_by='$login_id',ip_address='$ipaddr'
				WHERE url_id='$url_id'";
				
				$stat = $this->bm->dataUpdateDB1($sql_update);
				
				$msg="<font color='blue'><b>Successfully updated.</b></font>";
			}
			else
			{
				$sql_insert="INSERT INTO user_prev(login_id,tbl_org_type_id,section_id,url_id,last_update,update_by,ip_address)
				VALUES('$loginID','$tbl_org_types_id','$users_section_detail_id','$url_id',now(),'$login_id','$ipaddr')";
				
				$stat = $this->bm->dataInsertDB1($sql_insert);
				
				$msg="<font color='blue'><b>Successfully inserted.</b></font>";
			}
			
			
			if($stat==1)
				$msg=$msg;
			else
				$msg="<font color='red'><b>Failed, Try Again.</b></font>";
			
			$data['title']="SIDEBAR FORM...";
			$data['msg']=$msg;
				
			$this->load->view('header2');
			$this->load->view('sidebarForm',$data);
			$this->load->view('footer');
		}
	}
	//sidebar end
}
?>