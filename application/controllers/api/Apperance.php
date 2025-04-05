<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Apperance extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        //header('Access-Control-Allow-Origin: *');
        //header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        //validation jwt
        // $this->auth();
        //end validatoin jwt
        $this->load->model('M_apperance','app');
    }

    public function list_post(){
        
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->app->list_data($ip_host,$secretkey);
        $this->response($exec);
        
    }


    public function detail_post(){
        
        $type_code = $this->post('type_code');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->app->detail($type_code,$ip_host,$secretkey);
        $this->response($exec);
        
    }

    function update_post(){
        $id = $this->post('id');
        $type_code = $this->post('type_code');
        $type_name = $this->post('type_name');
        $height = $this->post('height');
        $width = $this->post('width');
        $imageurl = $this->post('imageurl');
        $userid = $this->post('userid');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->app->update($id,$type_code,$type_name,$height,$width,$imageurl,$userid,$ip_host,$secretkey);
        $this->response($exec);

    }

}
