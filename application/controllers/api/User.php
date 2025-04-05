<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        //validation jwt
        // // $this->auth();
        //end validatoin jwt

        $this->load->model('M_user','usr');
    }
	


    //user
    public function listuser_post(){
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->usr->get_user($ip_host,$secretkey);
        $this->response($exec);
    }

    public function adduser_post(){

        $nip = $this->post('nip');
        $fullname = $this->post('fullname');
        $email = $this->post('email');
        $password = $this->post('password');
        $type_account = $this->post('type_account');
        $golongan = $this->post('golongan');
        $unit = $this->post('unit');
        $position = $this->post('position');
        $id_lead = $this->post('id_lead');
        $id_head = $this->post('id_head');
        $task_work = $this->post('task_work');
        $opd = $this->post('opd');
        $user_id = $this->post('userid');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->usr->add_user($nip,$fullname,$email,$password,$type_account,$golongan,$unit,$position,$id_lead,$id_head,$task_work,$opd,$user_id,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function detailuser_post(){
        $id = $this->post('id');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->usr->detail_user($id,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function updateuser_post(){
        $id = $this->post('id');
        $nip = $this->post('nip');
        $fullname = $this->post('fullname');
        $email = $this->post('email');
        $type_account = $this->post('type_account');
        $golongan = $this->post('golongan');
        $unit = $this->post('unit');
        $position = $this->post('position');
        $id_lead = $this->post('id_lead');
        $id_head = $this->post('id_head');
        $task_work = $this->post('task_work');
        $opd = $this->post('opd');
        $status = $this->post('status');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->usr->update_user($id,$nip,$fullname,$email,$type_account,$golongan,$unit,$position,$id_lead,$id_head,$task_work,$opd,$status,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function liststaff_post(){
        
        $userid = $this->post('userid');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->usr->get_staff($userid,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function inquirystaff_post(){
        
        $userid = $this->post('userid');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->usr->inquiry_staff($userid,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function bulkqr_post(){
        
        $secretkey = $this->post('secretkey');

        $exec = $this->usr->bulk_qr($secretkey);
        $this->response($exec);
    }

    public function changeadmin_post(){

        $userid = $this->post('userid');
        $is_admin = $this->post('is_admin');
        $secretkey = $this->post('secretkey');

        $exec = $this->usr->change_admin($userid,$is_admin,$secretkey);
        $this->response($exec);
    }

    public function finduser_post(){

        $uniqueid = $this->post('uniqueid');
        $secretkey = $this->post('secretkey');

        $exec = $this->usr->find_user($uniqueid,$secretkey);
        $this->response($exec);
    }

}
