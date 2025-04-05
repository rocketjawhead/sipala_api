<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        //validation jwt
        // // $this->auth();
        //end validatoin jwt
        header('Access-Control-Allow-Origin: * ');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        $this->load->model('M_report','rpt');
    }
	


    //activity
    public function taskdaily_post(){
        $user_id = $this->post('user_id');
        $start_date = $this->post('start_date');
        $end_date = $this->post('end_date');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->rpt->task_daily($user_id,$start_date,$end_date,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function taskdailystaff_post(){
        $userid = $this->post('userid');
        $start_date = $this->post('start_date');
        $end_date = $this->post('end_date');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->rpt->task_daily_staff($userid,$start_date,$end_date,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function exectaskdailystaff_post(){
        $id = $this->post('id');
        $userid = $this->post('userid');
        $start_date = $this->post('start_date');
        $end_date = $this->post('end_date');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->rpt->exec_task_daily_staff($id,$userid,$start_date,$end_date,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function summary_post(){
        $userid = $this->post('userid');
        $start_date = $this->post('start_date');
        $end_date = $this->post('end_date');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->rpt->get_summary($userid,$start_date,$end_date,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function printsummary_post(){
        $userid = $this->post('userid');
        $start_date = $this->post('start_date');
        $end_date = $this->post('end_date');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->rpt->print_summary($userid,$start_date,$end_date,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function absent_post(){
        $userid = $this->post('userid');
        $limit = $this->post('limit');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->rpt->absent($userid,$limit,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function absentdate_post(){
        $userid = $this->post('userid');
        $start_date = $this->post('start_date');
        $end_date = $this->post('end_date');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->rpt->absent_date($userid,$start_date,$end_date,$ip_host,$secretkey);
        $this->response($exec);
    }

}
