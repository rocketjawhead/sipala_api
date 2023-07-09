<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;

class Auth extends BD_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('M_main');
        //header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        $this->load->model('M_auth');
    }

    

    public function login_post()
    {
        $username = $this->post('username'); //Username Posted
        $password = $this->post('password'); //Pasword Posted
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->M_auth->login($username,$password,$ip_host,$secretkey);
        $this->response($exec);
    }





    public function register_post(){

        $fullname = $this->post('fullname');
        $phonenumber = $this->post('phonenumber');
        $email = $this->post('email');
        $password = $this->post('password');
        $referral = $this->post('referral');
        $pin = $this->post('pin');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');
        $exec = $this->M_auth->register($fullname,$phonenumber,$email,$password,$referral,$pin,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function requestotp_post()
    {
        $id = $this->post('id'); 
        $email = $this->post('email');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->M_auth->request_otp($id,$email,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function validationotp_post()
    {
        $otp = $this->post('otp'); 
        $email = $this->post('email');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->M_auth->validation_otp($otp,$email,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function forgetpassword_post()
    {
        $email = $this->post('email'); 
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->M_auth->forget_password($email,$ip_host,$secretkey);
        $this->response($exec);
    }




    public function checklinkpassword_post()
    {
        $uniqueid_activity = $this->post('uniqueid_activity');
        $type_activity = $this->post('type_activity'); 
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->M_auth->check_link_password($uniqueid_activity,$type_activity,$ip_host,$secretkey);
        $this->response($exec);
    }




    public function resetpassword_post()
    {
        $id = $this->post('id');
        $password = $this->post('password');
        $password_conf = $this->post('password_conf'); 
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->M_auth->reset_password($id,$password,$password_conf,$ip_host,$secretkey);
        $this->response($exec);
    }



    public function checklinkverifyuser_post()
    {
        $uniqueid_activity = $this->post('uniqueid_activity');
        $type_activity = $this->post('type_activity'); 
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->M_auth->check_link_verifyuser($uniqueid_activity,$type_activity,$ip_host,$secretkey);
        $this->response($exec);
    }

    





    

}
