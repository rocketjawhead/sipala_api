<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        //header('Access-Control-Allow-Origin : *');
        //header('Access-Control-Allow-Methods : GET, POST, OPTIONS');
        //validation jwt
        // $this->auth();
        //end validatoin jwt
        $this->load->model('M_profile','pro');
    }

    public function userprofile_post()
    {
        
        $userid = $this->post('userid');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->pro->user_profile($userid,$ip_host,$secretkey);
        $this->response($exec);
        
    }
	
	public function checkprofile_post()
	{
        
        $userid = $this->post('userid');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->pro->check_profile($userid,$ip_host,$secretkey);
        $this->response($exec);
        
	}


    public function updateprofile_post()
    {

        $userid = $this->post('userid');
        $fullname = $this->post('fullname');
        $email = $this->post('email');
        $position = $this->post('position');
        $unit = $this->post('unit');
        $unit_2 = $this->post('unit_2');
        $id_lead = $this->post('id_lead');
        $id_head = $this->post('id_head');
        $task_work = $this->post('task_work');
        $opd = $this->post('opd');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->pro->update_profile($userid,$fullname,$email,$position,$unit,$unit_2,$id_lead,$id_head,$task_work,$opd,$ip_host,$secretkey);
        $this->response($exec);
        
    }


    public function updatepassword_post()
    {
        
        $userid = $this->post('userid');
        $password_old = $this->post('password_old');
        $password_new = $this->post('password_new');
        $password_new_conf = $this->post('password_new_conf');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->pro->update_password($userid,$password_old,$password_new,$password_new_conf,$ip_host,$secretkey);
        $this->response($exec);
        
    }

    public function updatepin_post()
    {
        
        $userid = $this->post('userid');
        $pin_old = $this->post('pin_old');
        $pin_new = $this->post('pin_new');
        $pin_new_conf = $this->post('pin_new_conf');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->pro->update_pin($userid,$pin_old,$pin_new,$pin_new_conf,$ip_host,$secretkey);
        $this->response($exec);
        
    }

    function updatepicture_post(){
        
        $imageurl = $this->post('imageurl');
        $userid = $this->post('userid');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->pro->update_picture($imageurl,$userid,$ip_host,$secretkey);
        $this->response($exec);

    }


    public function updateuser_post(){
        
        $userid = $this->post('userid');
        $fullname = $this->post('fullname');
        $id_opd = $this->post('id_opd');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->pro->update_user($userid,$fullname,$id_opd,$ip_host,$secretkey);
        $this->response($exec);
        
    }

    public function changepassword_post()
    {
        $userid = $this->post('userid');
        $password_old = $this->post('password_old');
        $password = $this->post('password_new');
        $password_conf = $this->post('password_new_conf'); 
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->pro->change_password($userid,$password_old,$password,$password_conf,$ip_host,$secretkey);
        $this->response($exec);
    }

}
