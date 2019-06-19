<?php
class signUpProcess extends CI_Model {

   public function __construct()
    {
        parent::__construct();
            $this->load->library('session'); 
            $this->load->database();
            $this->load->helper('url');
	    	$this->load->helper('file');
			
			
			
	}
	
	public function record_count() {
        return $this->db->count_all("igm_masters");
    }
	
	
	public function dataSelect($str) {
	
		$query=$this->db->query($str);
		$data=$query->result_array();
			
		return $data;
    }
	
	public function dataInsert($str) {
	
		$query=$this->db->query($str);
		
		return $query;
		//$tableName="image";
		//$this->db->insert($tableName, $data); 
    }
	
	public function dataUpdate($str) {
	
		$query=$this->db->query($str);
		return $query;
		 
    }
	public function dataDelete($str) {
	
		$query=$this->db->query($str);
		return $query;
		 
    }
	
	public function dataCount($str) {
	
		$query=$this->db->query($str);
		$row = $query->row();
		$cnt=$row->cnt;
		
		return $cnt;
    }
	
	public function dataReturn($str) {
	
		$query=$this->db->query($str);
		$row = $query->row();
		$rtnValue=$row->rtnValue;
		
		return $rtnValue;
    }
	
	
	public function dataTransaction($str,$str1) {
	
		$this->db->trans_begin();

		$this->db->query($str);
		$this->db->query($str1);
		//$this->db->query('AND YET ANOTHER QUERY...');

		if ($this->db->trans_status() === FALSE)
		{
				$this->db->trans_rollback();
				$rtnValue=0;
		}
		else
		{
				$this->db->trans_commit();
				$rtnValue=1;
		}
		
		return $rtnValue;
    }
	public function dataTransaction3($str,$str1,$str2) {
	
		$this->db->trans_begin();

		$this->db->query($str);
		$this->db->query($str1);
		$this->db->query($str2);
		//$this->db->query('AND YET ANOTHER QUERY...');

		if ($this->db->trans_status() === FALSE)
		{
				$this->db->trans_rollback();
				$rtnValue=0;
		}
		else
		{
				$this->db->trans_commit();
				$rtnValue=1;
		}
		
		return $rtnValue;
    }
	
	public function dataTransactionMulti($str,$str1,$str2,$str3) {
	
		$this->db->trans_begin();
		//$this->db->trans_start();
		$this->db->query($str);
		$this->db->query($str1);
		$this->db->query($str2);
		$this->db->query($str3);
		//$this->db->query('AND YET ANOTHER QUERY...');
		
		if ($this->db->trans_status() === FALSE)
		{
				//echo "rollback";
				$this->db->trans_rollback();
				$rtnValue=0;
		}
		else
		{
				//echo "commit";
				$this->db->trans_commit();
				//$this->db->trans_complete();
				$rtnValue=1;
		}
		
		return $rtnValue;
    }

}
