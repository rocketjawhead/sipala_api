<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Base extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        //validation jwt
        // // $this->auth();
        //end validatoin jwt
        header('Allow-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        $this->load->model('M_base','bs');
    }

    public function totaldashboard_post()
    {
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->bs->total_dashboard($ip_host,$secretkey);
        $this->response($exec);
    }


    public function valuechart_post()
    {
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->bs->value_chart($ip_host,$secretkey);
        $this->response($exec);
    }


    public function visitor_post()
    {
        $ip_host = $this->post('ip_host');
        $url_path = $this->post('url_path');
        $random_code = $this->post('random_code');
        $secretkey = $this->post('secretkey');

        $exec = $this->bs->visitor($ip_host,$url_path,$random_code,$secretkey);
        $this->response($exec);
    }

    public function logactivity_post()
    {
        $ip_host = $_SERVER['REMOTE_ADDR'];
        $json_param = $this->post('json_param');
        $userid = $this->post('userid');
        $url_path = $this->post('url_path');
        $random_code = $this->post('random_code');
        $secretkey = $this->post('secretkey');

        $exec = $this->bs->log_activity($ip_host,$json_param,$userid,$url_path,$random_code,$secretkey);
        $this->response($exec);
    }


    public function lastlogin_post()
    {
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->bs->last_login($ip_host,$secretkey);
        $this->response($exec);
    }

}
