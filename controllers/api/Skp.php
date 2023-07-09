<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Skp extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        //validation jwt
        // // $this->auth();
        //end validatoin jwt
        //header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        $this->load->model('M_skp','sk');
    }
	


    //activity
    public function list_post(){
        $user_id = $this->post('userid');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->sk->get_skp($user_id,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function add_post(){

        $year_now = $this->post('year_now');
        $userid = $this->post('userid');
        $id_skp_unit = $this->post('id_skp_unit');
        $id_skp_planning = $this->post('id_skp_planning');
        $id_skp_category = $this->post('id_skp_category');
        $id_skp_indikator = $this->post('id_skp_indikator');
        $id_skp_satuan = $this->post('id_skp_satuan');
        $min_target = $this->post('min_target');
        $max_target = $this->post('max_target');
        $secretkey = $this->post('secretkey');

        $exec = $this->sk->insert($year_now,$userid,$id_skp_unit,$id_skp_planning,$id_skp_category,$id_skp_indikator,$id_skp_satuan,$min_target,$max_target,$secretkey);
        $this->response($exec);
    }

    public function listdetail_post(){
        $year_now = $this->post('year_now');
        $user_id = $this->post('userid');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->sk->list_detail_skp($year_now,$user_id,$ip_host,$secretkey);
        $this->response($exec);
    }

}
