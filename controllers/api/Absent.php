<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Absent extends BD_Controller {
    function __construct()
    {
        // Construct the parent classasoy
        parent::__construct();
        //header('Access-Control-Allow-Origin: *');
        //header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        //validation jwt
        // // $this->auth();
        //end validatoin jwt

        $this->load->model('M_absent','bs');
    }
	


    //activity
    public function listabsent_post(){
        $user_id = $this->post('userid');
        $type_absent = $this->post('type_absent');
        $limit = $this->post('limit');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->bs->list_absent($user_id,$type_absent,$limit,$ip_host,$secretkey);
        $this->response($exec);
    }    

    public function listabsentstaff_post(){
        $user_id = $this->post('userid');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->bs->list_absent_staff($user_id,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function checkabsent_post(){
        $user_id = $this->post('userid');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->bs->check_absent($user_id,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function approve_post(){
        $user_id = $this->post('userid');
        $absentid = $this->post('absentid');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->bs->approve_absent($user_id,$absentid,$ip_host,$secretkey);
        $this->response($exec);
    }


}
