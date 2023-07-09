<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Activity extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        //header('Access-Control-Allow-Origin: *');
        //header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        //validation jwt
        // // $this->auth();
        //end validatoin jwt

        $this->load->model('M_activity','act');
    }
	


    //activity
    public function listactivity_post(){
        $user_id = $this->post('user_id');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->act->get_activity($user_id,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function addactivity_post(){
        $imageurl = $this->post('imageurl');
        $user_id = $this->post('user_id');
        $act_date = $this->post('act_date');
        $start_time = $this->post('start_time');
        $end_time = $this->post('end_time');
        $act_detail = $this->post('act_detail');
        $place = $this->post('place');
        $pj = $this->post('pj');
        $remark = $this->post('remark');
        $latitude = $this->post('latitude');
        $longitude = $this->post('longitude');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->act->add_activity($imageurl,$user_id,$act_date,$start_time,$end_time,$act_detail,$place,$pj,$remark,$latitude,$longitude,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function detailactivity_post(){
        $id = $this->post('id');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->act->detail_activity($id,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function updateactivity_post(){
        $id = $this->post('id');
        $act_date = $this->post('act_date');
        $start_time = $this->post('start_time');
        $end_time = $this->post('end_time');
        $act_detail = $this->post('act_detail');
        $place = $this->post('place');
        $pj = $this->post('pj');
        $remark = $this->post('remark');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->act->update_activity($id,$act_date,$start_time,$end_time,$act_detail,$place,$pj,$remark,$ip_host,$secretkey);
        $this->response($exec);
    }

    //home
    public function topactivity_post(){
        $user_id = $this->post('userid');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->act->top_activity($user_id,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function historyactivity_post(){
        $user_id = $this->post('userid');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->act->history_activity($user_id,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function doactivity_post(){

        $imageurl = $this->post('imageurl');
        $user_id = $this->post('userid');
        $type_act = $this->post('type_act');
        $start_date = $this->post('start_date');
        $end_date = $this->post('end_date');
        $desc_activity = $this->post('desc_activity');
        $latitude = $this->post('latitude');
        $longitude = $this->post('longitude');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->act->do_activity($imageurl,$user_id,$type_act,$start_date,$end_date,$desc_activity,$latitude,$longitude,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function listabsent_post(){
        $user_id = $this->post('user_id');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->act->list_absent($user_id,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function listactivityapp_post(){
        $user_id = $this->post('userid');
        $limit = $this->post('limit');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->act->get_activity_limit($user_id,$limit,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function historyabsent_post(){
        $user_id = $this->post('userid');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->act->history_activity_absent($user_id,$ip_host,$secretkey);
        $this->response($exec);
    }


}
