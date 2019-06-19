<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Ronnie - 8 Jul 2011
 */

class Welcome extends CI_Controller {
		function __construct()
	{
		parent::__construct();
		$this->load->library(array('session'));
            $this->load->model(array('CI_auth', 'CI_menu'));
            $this->load->helper(array('html','form', 'url'));
			$this->load->model('ci_auth', 'bm', TRUE);
			$this->load->driver('cache');
			$this->load->helper('date');
		
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
	}
	

    function index() {
        $this->viewpage();
    }

    function viewpage($isOk = 1) {
       // $abc['user_id']=$this->session->userdata('login_index_id');
		//print_r($this->session->all_userdata());
		if($this->session->userdata('login_id'))
		{$this->load->view('header2');
		$this->load->view('panelView');
		$this->load->view('footer');}
		else{
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
			$this->load->view('header');
			$this->load->view('welcomeview_1',$data);
			$this->load->view('footer');
		}
    }

	 function copanioManual($isOk = 1) {
       // $abc['user_id']=$this->session->userdata('login_index_id');
		//print_r($this->session->all_userdata());
		if($this->session->userdata('login_id'))
		{$this->load->view('header2');
		$this->load->view('panelView');
		$this->load->view('footer');}
		else{
        $this->load->view('header');
        $this->load->view('welcomeview_1',$data);
        $this->load->view('footer');}
    }
	
   

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */