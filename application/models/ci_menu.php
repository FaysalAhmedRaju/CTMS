<?php
class CI_menu extends CI_Model {
    function __construct()
    {
        parent::__construct();
            $this->load->library('session'); 
            $this->load->database();
            $this->load->helper('url');
            $this->load->model(array('CI_auth'));
    }
    
    function create_menu($array_menu, $separator ='|'){
        $data = array(
            'menu' => $array_menu,
            'separator' => $separator
        );
        return $this->load->view('_links',$data, true);
    }
    
    function menu_top(){
        $menu_common = array(
            'Home' => base_url(),
            'People' => '#',
            'News' => '#'
        );
        
        $menu_unlogged = array(
            'Register' => base_url().'index.php/register/',
            'Login' => base_url().'index.php/login/'
        );
        
        $menu_logged = array(
            'My Account' => base_url().'index.php/member_area/',
            'Logout' => base_url().'index.php/login/logout/'
        );
        
        $menu = array_merge($menu_common,($this->CI_auth->check_logged() == true)?$menu_logged:$menu_unlogged);
        return $this->create_menu($menu);
    }
    
}