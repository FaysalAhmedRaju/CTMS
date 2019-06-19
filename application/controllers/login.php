<?php

class Login extends CI_Controller {
	function __construct()
	{
	    parent::__construct();	
            $this->load->library(array('session', 'form_validation'));
            $this->load->model(array('CI_auth', 'CI_menu'));
            $this->load->helper(array('html','form', 'url'));
			$this->load->model('ci_auth', 'bm', TRUE);
			$this->load->driver('cache');
			//$my_session_id = $_GET['session_id']; //gets the session ID successfully
			//$this->session->userdata('session_id', $my_session_id); //it won't set the session with my id.
			//print_r($this->session->userdata);
			
			
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
			
	}
        
        function index(){
		$abc['user_id']=$this->session->userdata('login_index_id');
		//print_r($this->session->all_userdata());
		/*if($this->CI_auth->check_logged() == true)
		{$this->load->view('header2');
		$this->load->view('panelView');
		$this->load->view('footer');}*/
		
		//redirect(base_url().'index.php/member_area/');
			
		$sub_data['login_failed'] ='';
		$data['title'] = 'Login';
		//$data['body'] = 'shemul bhowmick';
		//$data['menu_top'] = $this->CI_menu->menu_top();
		//$data['body'] = $this->load->view('_login_form',$sub_data, true);
		
		if($this->input->post('submit_login')) {
			
			
			
			$this->form_validation->set_rules('username', 'username', 'trim|required|min_length[2]|max_length[20]|xss_clean');
			$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[5]|max_length[35]|xss_clean');
			$this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');
			//print("shemul bhowmick");
			if ($this->form_validation->run() == FALSE){
				//print("awal");
				$data['body'] = $sub_data;
				$this->load->view('header');
				$this->load->view('welcomeview_1', $data);
				$this->load->view('footer');
			}
			else{
			
				$userId=$this->input->post(trim(str_replace(' ','','username')));
				//echo $userId;
				
				if($userId=="cpaops"){
					$rtn =$this->CI_auth->check_ip();
					/*$ipAddress=$this->ip_address = $_SERVER['REMOTE_ADDR'];
					$s2=date("Y-m-d H:i:s");
					$data="\r\n$userId |$s2 |$ipAddress ";
					write_file("serverlogincpaops.txt", $data, 'a');*/
					//echo $rtn."shemul";
					if($rtn>0){
					
						$login_array = array($this->input->post(trim(str_replace(' ','','username'))), $this->input->post(trim(str_replace(' ','','password'))));
						if($this->CI_auth->process_login($login_array))
						{
						
							$session_id = $this->session->userdata('value');
							if($session_id!=$this->session->userdata('session_id'))
							{
								$this->logout();
							}
							else
							{	
							
								$this->load->view('header2');
								$this->load->view('panelView');
								$this->load->view('footer');												
								
							}
							
							
							
						}else{
						
						
							$sub_data['login_failed'] = "<font color='red' size=2>Invalid username or password</font>";
							$data['body'] =$sub_data['login_failed'];
							
							$this->load->view('header');
							$this->load->view('welcomeview_1', $data);
							$this->load->view('footer');
						}
					
					}else{
						$sub_data['login_failed'] = "<font color='red' size=2>Unauthorize Access</font>";
						$data['body'] =$sub_data['login_failed'];
						
						$this->load->view('header');
						$this->load->view('welcomeview_1', $data);
						$this->load->view('footer');
					}
				
				}
				else
				{
				//	echo $pass=$this->input->post('password');
					$login_array = array($this->input->post(trim(str_replace(' ','','username'))), $this->input->post(trim(str_replace(' ','','password'))));
					//echo "shemul";
					//print_r($login_array);
					//echo $this->CI_auth->process_login($login_array);
					if($this->CI_auth->process_login($login_array))
					{
						
						$session_id = $this->session->userdata('value');
						if($session_id!=$this->session->userdata('session_id'))
						{
							$this->logout();
						}
						else
						{	
						
							$this->load->view('header2');
							$this->load->view('panelView');
							$this->load->view('footer');
												
							
						}				
						
					}else{
					
					
						$sub_data['login_failed'] = "<font color='red' size=2>Invalid username or password</font>";
						$data['body'] =$sub_data['login_failed'];
						
						$this->load->view('header');
						$this->load->view('welcomeview_1', $data);
						$this->load->view('footer');
					}
				}
			}
		}
		else{
			$this->load->view('_output_html', $data);
		}
        }
		//shaha
		 function myPasswordChange(){
		
           //$login_id = $this->session->userdata('login_id');
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{ 
				$login_id = $this->session->userdata('login_id');
				$data['login_id']=$login_id;
				$this->load->view('header2');
				$this->load->view('myChangePasswordForm',$data);
				$this->load->view('footer');
			}
        }
		function myPasswordChangeUpdateForm(){
			
		//$data['title']="PassWord Update Successfully";
		$login_id = $this->session->userdata('login_id');
		$current = sha1($_POST['old_password']);
		$new_password = sha1($_POST['new_password']);
		$confirm_password = sha1($_POST['confirm_password']);
		$checkoldpass = mysql_query("SELECT new_pass FROM users WHERE login_id='$login_id'");
        $result = mysql_fetch_object($checkoldpass);
		$newpss=$result->new_pass;
		$ipaddr = $_SERVER['REMOTE_ADDR'];
		
		if($current!=$newpss)
		{
			$data['ptitle']='Current password is not Match. Press back to try again.';
			$this->load->view('header2');
			$this->load->view('myChangePasswordForm',$data);
			$this->load->view('footer');
            return false;
		}
   
		else if ($new_password == $confirm_password) {
			$name = $this->session->userdata('User_Name');
			$login_id = $this->session->userdata('login_id');
        
           $sql = "UPDATE users SET new_pass ='$new_password',last_date=NOW(),update_by='$update_by',user_ip='$ipaddr' WHERE login_id='$login_id'";
			mysql_query($sql);
			$data['title']="Password Update Successfully";
			$this->load->view('header2');
			$this->load->view('panelView',$data);
			$this->load->view('footer');
            return false;
        }
    
		else
		{
			$data['ptitle']='New Password did not match. Press back to try again';
			$this->load->view('header2');
			$this->load->view('myChangePasswordForm',$data);
			$this->load->view('footer');
			return false;
		}
			
}
		//shaha
		
		function changePassForClient(){
		
           //$login_id = $this->session->userdata('login_id');
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$data['ptitle']="";
				$this->load->view('header2');
				$this->load->view('clientPassChangeForm',$data);
				$this->load->view('footer');
			}
        }
		
		function changePassForClientPerform(){
		
           //$login_id = $this->session->userdata('login_id');
			$session_id = $this->session->userdata('value');
			if($session_id!=$this->session->userdata('session_id'))
			{
				$this->logout();
			}
			else
			{
				$loging_id = trim($this->input->post('loging_id'));
				$new_password = trim($this->input->post('new_password'));
				$confirm_password = trim($this->input->post('confirm_password'));
				$ipaddr = $_SERVER['REMOTE_ADDR'];
				$msg = "";
				if($new_password==$confirm_password){
					$this->load->model('ci_auth', 'bm', TRUE);
					$pass = sha1($new_password);
					$cpass = sha1($confirm_password);	
					
					$sqlUser = "select count(id) as rtnValue from users where login_id='$loging_id'";
					$rtnValue = $this->bm->dataReturnDb1($sqlUser);
					$update_by = $this->session->userdata('login_id');
					if($rtnValue>0){
						$str = "UPDATE users SET new_pass='$cpass',last_date=NOW(),update_by='$update_by' WHERE login_id='$loging_id'";
						$res = $this->bm->dataUpdateDB1($str);
						if($res)
							$msg = "<font color='green'>Password updated</font>";
						else
							$msg = "<font color='red'>Password not updated</font>";
					}else{
						$msg = "<font color='red'>There is no users for login id <strong>".$loging_id."</strong></font>";
					}
				}else{
					$msg = "<font color='red'>New password and confirm password is not matched to each others.</font>";
				}
				$data['ptitle']=$msg;
				$this->load->view('header2');
				$this->load->view('clientPassChangeForm',$data);
				$this->load->view('footer');
			}
        }
		
        function logout(){
		
            /*$this->session->sess_destroy();
			
			$this->cache->clean();
			set_header("cache-Control: no-store, no-cache, must-revalidate");
			set_header("cache-Control: post-check=0, pre-check=0", false);
			set_header("Pragma: no-cache");
			set_header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
	    
			
			$this->load->view('header');
			$this->load->view('welcomeview_1', $data);
			$this->load->view('footer');*/
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
}
?>