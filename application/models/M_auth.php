<?php if(!defined('BASEPATH')) exit('No direct script allowed');

use \Firebase\JWT\JWT;

class M_auth extends CI_Model{



	public function __construct() {

        parent::__construct();

        $this->load->model('M_base','base');

        $this->load->model('M_main','main');

        $this->poin_register = $this->config->item('poin_register');

        $this->value_otp = $this->config->item('value_otp');

        $this->uniqueid_code = $this->config->item('uniqueid_code');

        $this->date_now = date('Y-m-d');

        $this->datetime_now = date('Y-m-d H:i:s');

        $this->base_url = $this->config->item('base_url');

    }


	

	function login($username,$password,$ip_host,$secretkey){


		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			$u = $username; 
	        $p = sha1($password); 
	        $q = array('username' => $u); 

	        $val = $this->main->get_user($u)->row(); 
	        if($this->main->get_user($u)->num_rows() == 0){
	        	return $this->base->invalid_login();
	        }

			// echo json_encode($val);
			// die();

			$match = $val->password;   
	        if($p == $match){  
	        	$email = $val->nip;
	        	$check_status = $this->db->query("SELECT IFNULL(status,0) AS status FROM users WHERE nip = '$email' ")->row()->status;
	        	if ($check_status == 0) {
	        		return $this->base->invalid_verify_account();
	        	}else{
	        		$update_unique = $this->db->query("UPDATE users SET last_login = '$this->datetime_now' WHERE email = '$email' ");
	        		// $update_unique = $this->db->query("UPDATE login_log SET status = '1' WHERE email = '$email' ");
		        	$uniqueid = $this->uniqueid_code;
		        	$data_unique = array(
		        		'uniqueid' => $uniqueid,
		        		'email' => $email
		        	);
		        	$exec_unique = $this->db->insert('login_log',$data_unique);
		        	$data = array(
		        		'uniqueid' => $uniqueid,
		        		'email' => $email 
		        	);


		        	if ($val->qr_url == null) {
		        		//generate qr
			        	$qrcode_string=$val->nip.'.png';
						$this->base->generate_qr($val->unique_id,$qrcode_string);
						$qrcode_url = $this->base_url.'uploads/qrcode/'.$qrcode_string;
			        	//end generate qr

			        	$update_qr = $this->db->query("UPDATE users SET qr_url = '$qrcode_url' WHERE unique_id = '$val->unique_id'  ");
		        	}else{
		        		// echo "string";
		        		$qrcode = false;
		        	}
		        	

		        	//
		        	$check_email = $this->db->query("SELECT id FROM users WHERE nip = '$email' AND status = 1 ")->row();
					$userid = $check_email->id;
		        	$get_jwt = $this->get_jwt($userid,$email);
					return $this->base->success_data($get_jwt);
		        	//
		            // return $this->base->success_login($data);
	        	}
	        }
	        else {
	        	return $this->base->invalid_login();
	        }
		}else{
			return $this->base->invalid_key();
		}

	}



	function register($fullname,$phonenumber,$email,$password,$referral,$pin,$ip_host,$secretkey){

		$checking_key = $this->base->validity_key($secretkey);

		if ($checking_key == TRUE) {

			

			//checking exist email

			// $check_email = $this->db->query("SELECT COUNT(id) AS total FROM users WHERE email = '$email' ")->row()->total;

			// if ($check_email > 1) {

			// 	# code...

			// }

			$check_email = $this->base->validity_email($email,$phonenumber);

			if ($check_email == 0) {

				//



				$unique_id = rand(10,99).date("YmdHis");

				$data_user = array(

					'unique_id ' => $unique_id,
					'email ' => $email, 
					'phonenumber ' => $phonenumber,
					'username ' => $fullname,
					'password ' => sha1($password),
					'pin ' => sha1($pin),
					'level ' => 1,
					'status ' => 0,
					'referral_code ' => SUBSTR(md5(uniqid(rand(), true)),0,6),
					'sub_referral_code' => $referral
				);

				$insert_user = $this->db->insert('users',$data_user);



				if ($insert_user == TRUE) {

					$data_account = array(

						'userid ' => $unique_id,

						'balance ' => 0, 

						'poin ' => 0,

						'status ' => 1

					);

					$insert_account = $this->db->insert('account',$data_account);





					//generate uniqueid activity

					$uniqueid_activity = rand(100000,999999);

					$type_activity = 2;//verify

					$activity = array(

						'email' => $email,

						'uniqueid_activity' => $uniqueid_activity,

						'type_activity' => $type_activity,

						'create_date' => date("Y-m-d H:i:s") 

					);

					$exec = $this->db->insert('auth_activity',$activity);

					//sendemai

					$this->base->send_email($type_activity,$email,$uniqueid_activity);

					



					return $this->base->success();

				}else{

					return $this->base->failed();

				}





			}else{

				return $this->base->invalid_email();

			}





		}else{

			return $this->base->invalid_key();

		}

	}









	function get_jwt($userid,$email){





		$get_userid = $this->db->query("SELECT unique_id,nip,fullname,email,type_account,imageprofil,is_admin 
		FROM users WHERE nip = '$email' AND status = 1 ")->row();



		$key = $this->config->item('thekey');

		$token['id'] = $userid;  

	    $token['email'] = $get_userid->email;

	    $date = new DateTime();

	    $token['iat'] = $date->getTimestamp();

	    $token['exp'] = $date->getTimestamp() + 60*1000; //60 second * 1, setup 15 minutes

	    $output['token'] = JWT::encode($token,$key); 

	    $output['email'] = $email;

	    $output['userid'] = $get_userid->unique_id ; 
	    $output['nip'] = $get_userid->nip;
	    $output['fullname'] = $get_userid->fullname; 
	    $output['email'] = $get_userid->email;
	    $output['type_account'] = $get_userid->type_account;
	    $output['imageprofil'] = $get_userid->imageprofil;
	    $output['is_admin'] = $get_userid->is_admin;
	    


	    return $output;

	}





	function request_otp($id,$email,$ip_host,$secretkey){



		$checking_key = $this->base->validity_key($secretkey);

		if ($checking_key == TRUE) {

			$check_email = $this->db->query("SELECT id FROM login_log WHERE email = '$email' AND uniqueid = '$id' AND status = 0 ")->row();

			if (isset($check_email)) {

				

				//update otp

				$this->db->query("UPDATE otp SET status = 1 WHERE email = '$email' ");

				//



				$type_activity = 1;

				$value_otp = $this->value_otp;

				$valid_date = date('Y-m-d H:i:s', strtotime('15 minute'));

				$data_otp = array(

					'uniqueid' => $this->uniqueid_code,

					'value_otp' => $value_otp,

					'email' => $email,

					'valid_date' => $valid_date

				);



				$exec_otp = $this->db->insert('otp',$data_otp);

				if ($exec_otp == TRUE) {

					//send otp to email

					//sendemai

					$this->base->send_email($type_activity,$email,$value_otp);

					return $this->base->success();

				}else{

					return $this->base->failed();

				}

			}else{

				return $this->base->failed();

			}

		}else{

			return $this->base->invalid_key();

		}



	}


	function validation_otp($otp,$email,$ip_host,$secretkey){


		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			$check_email = $this->db->query("SELECT id FROM users WHERE email = '$email' AND status = 1 ")->row();
			if (isset($check_email)) {
				$check_otp = $this->db->query("SELECT id,valid_date FROM otp WHERE email = '$email' AND value_otp = '$otp' AND status = 0 ")->row();
				if (isset($check_otp)) {
					$valid_date = $check_otp->valid_date;
					$date_now = date("Y-m-d H:i:s");
					if ($valid_date > $date_now) {
						$update_otp = $this->db->query("UPDATE otp SET status = 1 WHERE value_otp = '$otp' AND email = '$email' ");
						$userid = $check_email->id;
						$get_jwt = $this->get_jwt($userid,$email);
						return $this->base->success_data($get_jwt);
					}else{
						return $this->base->failed();
					}
				}else{
					return $this->base->invalid_otp();
				}
			}else{
				return $this->base->invalid_verify_account();
			}
		}else{
			return $this->base->invalid_key();
		}
	}



	function forget_password($email,$ip_host,$secretkey){



		$checking_key = $this->base->validity_key($secretkey);

		if ($checking_key == TRUE) {

			$check_email = $this->db->query("SELECT id FROM users WHERE email = '$email' AND status = 1 ")->row();

			

			if (isset($check_email)) {



				$update_data = $this->db->query("UPDATE auth_activity SET status = 1 WHERE email = '$email' ");



				//generate uniqueid activity

				$uniqueid_activity = rand(100000,999999);

				$type_activity = 3;//forget password

				$activity = array(

					'email' => $email,

					'uniqueid_activity' => $uniqueid_activity,

					'type_activity' => $type_activity,

					'create_date' => date("Y-m-d H:i:s") 

				);

				$exec = $this->db->insert('auth_activity',$activity);

				if ($exec == TRUE) {

					

					//send email forget password

					$this->base->send_email($type_activity,$email,$uniqueid_activity);

					return $this->base->success();

				}else{

					return $this->base->failed();

				}



			}else{

				return $this->base->invalid_verify_account();

			}

		}else{

			return $this->base->invalid_key();

		}



	}









	function check_link_password($uniqueid_activity,$type_activity,$ip_host,$secretkey){



		$checking_key = $this->base->validity_key($secretkey);

		if ($checking_key == TRUE) {

			$check_data = $this->db->query("SELECT COUNT(id) AS total FROM auth_activity 

				WHERE md5(uniqueid_activity) = '$uniqueid_activity' AND type_activity = 3 AND status = 0 ")->row()->total;

			if ($check_data > 0) {



				return $this->base->success();



			}else{

				return $this->base->link_expired();

			}

		}else{

			return $this->base->invalid_key();

		}



	}













	function reset_password($id,$password,$password_conf,$ip_host,$secretkey){



		$checking_key = $this->base->validity_key($secretkey);

		if ($checking_key == TRUE) {

			$check_data = $this->db->query("SELECT id,uniqueid_activity,email FROM auth_activity 

				WHERE md5(uniqueid_activity) = '$id' AND type_activity = 3 AND status = 0 ")->row();

			if (isset($check_data)) {



				if ($password != $password_conf) {

					return $this->base->failed();

				}



				$update_url = $this->db->query("UPDATE auth_activity SET status = 1 WHERE md5(uniqueid_activity) = '$id' ");

				$new_password = sha1($password);

				$email = $check_data->email;

				$update_password = $this->db->query("UPDATE users SET password = '$new_password' WHERE email = '$email' ");

				return $this->base->success();



			}else{

				return $this->base->link_expired();

			}

		}else{

			return $this->base->invalid_key();

		}



	}



	





	function check_link_verifyuser($uniqueid_activity,$type_activity,$ip_host,$secretkey){



		$checking_key = $this->base->validity_key($secretkey);

		if ($checking_key == TRUE) {

			$check_data = $this->db->query("SELECT COUNT(id) AS total FROM auth_activity 

				WHERE md5(uniqueid_activity) = '$uniqueid_activity' AND type_activity = 2 AND status = 0 ")->row()->total;

			if ($check_data > 0) {



				$get_email = $this->db->query("SELECT email FROM auth_activity WHERE md5(uniqueid_activity) = '$uniqueid_activity' AND type_activity = 2 AND status = 0")->row()->email;



				$update_status = $this->db->query("UPDATE users SET status = 1 WHERE email = '$get_email' ");

				$update_link = $this->db->query("UPDATE auth_activity SET status = 1 WHERE email = '$get_email' ");



				return $this->base->success();



			}else{

				return $this->base->link_expired();

			}

		}else{

			return $this->base->invalid_key();

		}



	}











	

}