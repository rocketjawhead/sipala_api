<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('M_settings','st');
        //header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    }
	
	public function mainmenu_post()
	{
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->st->main_menu($ip_host,$secretkey);
        $this->response($exec);
        
	}


    public function reset_post()
    {
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->st->reset($ip_host,$secretkey);
        $this->response($exec);
        
    }

}
