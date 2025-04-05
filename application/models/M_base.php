<?php if(!defined('BASEPATH')) exit('No direct script allowed');



class M_base extends CI_Model{



	public function __construct() {

            parent::__construct();

            $this->secretkey_server = $this->config->item('secretkey_server');
            $this->date_now = date('Y-m-d');
	        $this->load->model('M_email','mail');
	        $this->year_now = date('Y');
	        $this->base_url = $this->config->item('base_url');

    }

    function generate_qr($content_qr,$name_qr){
    	  //START GENERATE CODE
	      $this->load->library('ciqrcode'); //pemanggilan library QR CODE
	      $config['cacheable']  = true; //boolean, the default is true
	      $config['cachedir']   = './uploads/'; //string, the default is application/cache/
	      $config['errorlog']   = './uploads/'; //string, the default is application/logs/
	      $config['imagedir']   = './uploads/qrcode/'; //direktori penyimpanan qr code
	      $config['quality']    = true; //boolean, the default is true
	      $config['size']     = '1024'; //interger, the default is 1024
	      $config['black']    = array(224,255,255); // array, default is array(255,255,255)
	      $config['white']    = array(70,130,180); // array, default is array(0,0,0)
	      $this->ciqrcode->initialize($config);

	      $params['data'] = $content_qr; //isi content url
	      $params['level'] = 'H'; //H=High
	      $params['size'] = 10;
	      $params['savename'] = FCPATH.$config['imagedir'].$name_qr; 
	      $this->ciqrcode->generate($params);
    }



	function validity_key($secretkey) {

		if ($secretkey == $this->secretkey_server) {

			return true;

		}else{

			return false;

		}

	}



	function checking_auth_admin($userid,$password){



		$newpassword = sha1($password);

		$auth_user = $this->db->query("SELECT COUNT(id) AS total FROM sysadmin 

			WHERE id = '$userid' AND password = '$newpassword' AND status = 1 ")->row()->total;



		if ($auth_user == 0) {

			return FALSE;

		}else{

			return TRUE;

		}

		

	}



	function checking_otp_paid($userid,$otp,$trx_id){



		$valid_otp = $this->db->query("SELECT COUNT(id) AS total FROM otp_paid 

			WHERE userid = '$userid' 

			AND value_otp = '$otp' 

			AND trx_id = '$trx_id'

			AND status = 0 ")->row()->total;



		if ($valid_otp == 0) {

			return FALSE;

		}else{

			return TRUE;

		}

		

	}





	function list_bank($iphost,$secretkey){

		$check_key = $this->validity_key($secretkey);

		if ($check_key == TRUE) {

			$ref_bank = $this->db->query("SELECT account_name,account_number,name_bank,code_bank FROM ref_banks")->result();

			return $this->success_data($ref_bank);

		}else{

			return $this->failed();

		}

	}



	function total_dashboard($iphost,$secretkey){

		$check_key = $this->validity_key($secretkey);

		if ($check_key == TRUE) {

			$total_user = $this->db->query("SELECT COUNT(id) AS qty FROM users WHERE status = 1 ")->row()->qty;
			$total_absent = $this->db->query("SELECT COUNT(id) AS qty FROM activity WHERE act_id = 1 AND act_date = '$this->date_now' ")->row()->qty;
			$total_leave = $this->db->query("SELECT COUNT(id) AS qty FROM activity WHERE act_id IN (2,3,4) AND act_date = '$this->date_now' ")->row()->qty;

			$data = array(
				'total_user' => $total_user,
				'total_absent' => $total_absent,
				'total_leave' => $total_leave
			);

			return $this->success_data($data);

		}else{

			return $this->failed();

		}

	}


	function value_chart($iphost,$secretkey){

		$check_key = $this->validity_key($secretkey);

		if ($check_key == TRUE) {
			// DATE_FORMAT(act.create_date,'%Y') = '$year_now'
			// DATE_FORMAT(act.create_date,'%m') = '11'
			// $total_absent = $this->db->query("SELECT COUNT(id) AS qty FROM activity WHERE act_id = 1 AND act_date = '$this->date_now' ")->row()->qty;
			$array_absent=array();
			for ($i=1; $i < 13 ; $i++) { 
				$total_absent = $this->db->query("SELECT 
					COUNT(id) AS qty 
					FROM activity 
					WHERE act_id = 1 
					AND DATE_FORMAT(act_date,'%m') = '$i'
					AND DATE_FORMAT(act_date,'%Y') = '$this->year_now' 
					")->row()->qty;

				$array_absent['bulan'.$i] = $total_absent;
			}

			$array_sick=array();
			for ($i=1; $i < 13 ; $i++) { 
				$total_sick = $this->db->query("SELECT 
					COUNT(id) AS qty 
					FROM activity 
					WHERE act_id = 2 
					AND DATE_FORMAT(act_date,'%m') = '$i'
					AND DATE_FORMAT(act_date,'%Y') = '$this->year_now' 
					")->row()->qty;

				$array_sick['bulan'.$i] = $total_sick;
			}

			//cuti
			$array_leave=array();
			for ($i=1; $i < 13 ; $i++) { 
				$total_leave = $this->db->query("SELECT 
					COUNT(id) AS qty 
					FROM activity 
					WHERE act_id IN (3,4) 
					AND DATE_FORMAT(act_date,'%m') = '$i'
					AND DATE_FORMAT(act_date,'%Y') = '$this->year_now' 
					")->row()->qty;

				$array_leave['bulan'.$i] = $total_leave;
			}

			$data_chart = array(
				'data_absent' => $array_absent,
				'data_sick' => $array_sick,
				'data_leave' => $array_leave 
			);

			// echo json_encode($noarray);

			// die();
			return $this->success_data($data_chart);

		}else{

			return $this->failed();

		}

	}










	function validity_login($email) {

		$check_email = $this->validity_email($email);

		if ($check_email == true) {

			return TRUE;

		}else{

			return $this->invalid_email;

		}

	}





	function validity_email($email,$phonenumber) {

		$check_email = $this->db->query("SELECT IFNULL(count(email),0) AS email FROM users WHERE email = '$email' OR phonenumber = '$phonenumber'")->row();

		return $check_email->email;

	}





	function validity_password($email) {

		$check_email = $this->db->query("SELECT email,password FROM users WHERE email = '$email' AND status = 1 ")->row();

		if (isset($check_email)) {

			return true;

		}else{

			return false;

		}

	}





	function validity_referral($referral,$email) {

		$check_referral = $this->db->query("SELECT id,unique_id FROM users WHERE referral_code = '$referral' AND status = 1 ")->row();

		if (isset($check_referral)) {



			$unique_id = $check_referral->unique_id;

			$poin_register = $this->poin_register;

			$update_poin = $this->insert_transaction_poin($poin_register,$unique_id);

			return TRUE;

		}else{

			return FALSE;

		}

	}



	function insert_transaction_poin($poin,$userid){

		$unique_number = date('Ymdhis');

		$data_insert = array(

			'userid' => $userid,

			'unique_number' => $unique_number,

			'type_transaction' => '3',

			'credit' => $poin,

			'debit' => 0 

		);

		$exec_insert = $this->db->insert('transaction',$data_insert);

		if ($exec_insert == TRUE) {

			$sql_poin = "UPDATE account SET poin = poin + '$poin' WHERE userid = '$userid' ";

			$update_poin = $this->db->query($sql_poin);

			return TRUE;

		}else{

			return FALSE;

		}

	}



	function debit_transaction_balance($trx_id,$amount,$userid,$type_transaction,$profit){



		$balance = $this->check_balance($userid);

		$unique_number = date('his').rand(1000,9999);



		if (($balance - $amount) < 0) {

			return $this->invalid_balance();

		}else{

			$data_insert = array(

				'trx_id' => $trx_id,

				'userid' => $userid,

				'unique_number' => $unique_number,

				'type_transaction' => $type_transaction,

				'credit' => 0,

				'debit' => $amount,

				'profit' => $profit

			);

			$exec_insert = $this->db->insert('transaction',$data_insert);

			if ($exec_insert == TRUE) {

				$update_balance = $this->db->query("UPDATE account SET balance = balance - '$amount' WHERE userid = '$userid' ");

				$update_checkout = $this->db->query("UPDATE checkout SET upload_receipt = 1,status_payment = 'paid',profit = '$profit' WHERE trx_id = '$trx_id' ");

				return $this->success();

			}else{



				return $this->failed();

			}

		}





		

	}



	function credit_transaction_balance($trx_id,$unique_number,$balance,$userid,$type_transaction,$trx_fee){

		$unique_number = date('Ymdhis');

		$data_insert = array(
			'userid' => $userid,
			'unique_number' => $unique_number,
			'type_transaction' => $type_transaction,
			'credit' => 0,
			'debit' => $balance
		);
		$exec_insert = $this->db->insert('transaction',$data_insert);
		if ($exec_insert == TRUE) {
			$update_balance = $this->db->query("UPDATE account SET balance = balance + '$balance' WHERE userid = '$userid' ");
			$update_balance = $this->db->query("UPDATE checkout SET status_transaction = 2 WHERE trx_id = '$trx_id' ");
			$insert_transaction_activity = $this->insert_transaction_activity($trx_id,'deposit',json_encode($data_insert),null,$userid);
			$transaction_gl = $this->insert_transaction_gl($trx_id,$trx_fee,0);//for income services
			return $this->success();
		}else{
			return $this->failed();
		}

	}





	function audit_trail($name_log,$data_log,$url,$userid){

		$data_insert = array(

          'name_log' => $name_log,

          'data_log' => json_encode($data_log),

          'url' => $url,

          'userid' => $userid

        );

        $exec_insert = $this->db->insert('audit_trail',$data_insert);

        return $exec_insert;

	}





	function check_balance($userid){

		$get_balance = $this->db->query("SELECT balance FROM account WHERE userid = '$userid' ")->row();

		if (isset($get_balance)) {

			return $get_balance->balance;

		}else{

			return 0;

		}

	}



	//response



	function success(){

		return array(

			'status' => 'Success',

			'responsecode' => '00',

			'message' => 'Success' 

		);

	}



	function failed_activity(){
		return array(
			'status' => 'Failed',
			'responsecode' => '500',
			'message' => 'Mohon untuk absent terlebih dahulu' 
		);
	}





	function failed(){

		return array(

			'status' => 'Failed',

			'responsecode' => '500',

			'message' => 'Failed' 

		);

	}


	function failed_holiday(){

		return array(

			'status' => 'Failed',

			'responsecode' => '500',

			'message' => 'Tanggal Yang dipilih adalah hari libur' 

		);

	}

	function failed_duplicate(){

		return array(

			'status' => 'Failed',

			'responsecode' => '500',

			'message' => 'Data duplikat' 

		);

	}





	function success_data($data){

		return array(

			'status' => 'Success',

			'responsecode' => '00',

			'Data'=>$data,

			'message' => 'Success' 

		);

	}



	function success_login($data){

		return array(

			'status' => 'Success',

			'Data' => $data,

			'responsecode' => '00',

			'message' => 'Success Login' 

		);

	}



	function transaction_pending(){

		return array(

			'status' => 'Success',

			'responsecode' => '03',

			'message' => 'Transaksi sedang diproses' 

		);

	}



	function transaction_failed(){

		return array(

			'status' => 'Failed',

			'responsecode' => '01',

			'message' => 'Transaction Failed or Not Found' 

		);

	}



	function transaction_duplicate(){

		return array(

			'status' => 'Failed',

			'responsecode' => '01',

			'message' => 'Transaction Has Been Record' 

		);

	}



	function invalid_key(){

		return array(

			'status' => 'Failed',

			'responsecode' => '401',

			'message' => 'Authorization Failed' 

		);

	}



	function invalid_execute(){

		return array(

			'status' => 'Failed',

			'responsecode' => '402',

			'message' => 'Execute Failed' 

		);

	}



	function invalid_balance(){

		return array(

			'status' => 'Failed',

			'responsecode' => '13',

			'message' => 'Invalid Balance' 

		);

	}



	function invalid_email(){

		return array(

			'status' => 'Failed',

			'responsecode' => '14',

			'message' => 'Invalid Email' 

		);

	}



	function invalid_referral(){

		return array(

			'status' => 'Failed',

			'responsecode' => '14',

			'message' => 'Invalid Referral Code' 

		);

	}



	function invalid_login(){

		return array(

			'status' => 'Failed',

			'responsecode' => '404',

			'message' => 'Invalid Login, Please check your credential' 

		);

	}





	function invalid_otp(){

		return array(

			'status' => 'Failed',

			'responsecode' => '404',

			'message' => 'Invalid Login, Please check your OTP' 

		);

	}





	function invalid_verify_account(){

		return array(

			'status' => 'Failed',

			'responsecode' => '404',

			'message' => 'Invalid Login, Please check your email and click url verification' 

		);

	}



	function link_expired(){

		return array(

			'status' => 'Failed',

			'responsecode' => '404',

			'message' => 'Invalid URL LINK, Please request again your URL LINK' 

		);

	}





	function inquiry_pulsa($type_inq,$provider){

		  $username   = $this->username_key;

	      $apiKey   = $this->api_key;

	      $signature  = md5($username.$apiKey.'pl');



	      $json = array(

	        'commands' => 'pricelist',

	        'username' => $username,

	        'sign' => $signature 

	      );



	      $url = $this->url_vendor_pulsa.$type_inq.'/'.$provider;

	      $post_curl = $this->post_curl($url,$json);

	      return $post_curl;

	}



	function inquiry_pricelist($type_inq){

		  $username   = $this->username_key;

	      $apiKey   = $this->api_key;

	      $signature  = md5($username.$apiKey.'pl');



	      $json = array(

	        'commands' => 'pricelist',

	        'username' => $username,

	        'sign' => $signature 

	      );



	      $url = $this->url_vendor_pulsa.$type_inq;

	      $post_curl = $this->post_curl($url,$json);

	      return $post_curl;

	}


	function post_curl($url,$data_req){

	      $ch  = curl_init();

	      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

	      curl_setopt($ch, CURLOPT_URL, $url);

	      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data_req));

	      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

	      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	      $data = curl_exec($ch);

	      curl_close($ch);

	      return $data;

	}





	function push_telegram($trx_id,$trx_type){



		$data_insert = array(

			'trx_id' => $trx_id,

			'trx_type' => $trx_type,

			'is_send' => 0

		);

		$exec_insert = $this->db->insert('queue_notif',$data_insert);



	}





	function push_notification($trx_id,$trx_type){



		$data_insert = array(

			'trx_id' => $trx_id,

			'trx_type' => $trx_type,

			'is_send' => 0

		);

		$exec_insert = $this->db->insert('queue_notif',$data_insert);



	}





	function send_push_telegram(){





		$count_notif = $this->db->query("SELECT COUNT(id) AS total FROM queue_notif WHERE is_send = 0 AND status = 1 ")->row()->total;



		if ($count_notif > 0) {

			

			// $count_notif = $count_notif+1;

			for ($i=0; $i < $count_notif; $i++) { 



				$detail_notif = $this->db->query("SELECT id,trx_id,trx_type,is_send,status 

				FROM queue_notif WHERE is_send = 0 AND status = 1 ORDER BY id ASC LIMIT 1

				")->row();

				//push telegram

				$trx_id = $detail_notif->trx_id;

				$curl = curl_init();

				$date_now = date('Y-m-d H:i:s');

				$json = array(

					'trx_id' => $detail_notif->trx_id,

					'trx_type' => $detail_notif->trx_type,

					'trx_date' => $date_now 

				);



				$send_json = json_encode($json);

				$url = "https://api.telegram.org/bot5298359439:AAGIA2-b3bMC2aszq4wOuEsmLdE1W3O6LF4/sendMessage?chat_id=2113714082&text=".$send_json;

				curl_setopt_array($curl, array(

				  CURLOPT_URL => $url,

				  CURLOPT_RETURNTRANSFER => true,

				  CURLOPT_ENCODING => '',

				  CURLOPT_MAXREDIRS => 10,

				  CURLOPT_TIMEOUT => 0,

				  CURLOPT_FOLLOWLOCATION => true,

				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

				  CURLOPT_CUSTOMREQUEST => 'GET',

				));



				$response = curl_exec($curl);



				$update_status_notif = $this->db->query("UPDATE queue_notif SET is_send = 1, send_notif = '$date_now' WHERE trx_id = '$trx_id' ");



				curl_close($curl);

			}

			



			return $this->success();



		}else{

			return $this->failed();

		}



	}





	function send_push_discord(){





		$count_notif = $this->db->query("SELECT COUNT(id) AS total FROM queue_notif WHERE is_send = 0 AND status = 1 ")->row()->total;



		if ($count_notif > 0) {

			

			// $count_notif = $count_notif+1;

			for ($i=0; $i < $count_notif; $i++) { 



				$detail_notif = $this->db->query("SELECT id,trx_id,trx_type,is_send,status 

				FROM queue_notif WHERE is_send = 0 AND status = 1 ORDER BY id ASC LIMIT 1

				")->row();

				//push telegram

				$trx_id = $detail_notif->trx_id;

				$curl = curl_init();

				$date_now = date('Y-m-d H:i:s');

				$json = array(

					'trx_id' => $detail_notif->trx_id,

					'trx_type' => $detail_notif->trx_type,

					'trx_date' => $date_now 

				);



				$send_json = json_encode($json);



				$post_discord = $this->post_discord($send_json);



				if($post_discord == TRUE){

					$update_status_notif = $this->db->query("UPDATE queue_notif SET is_send = 1, send_notif = '$date_now' WHERE trx_id = '$trx_id' ");

				}

			}

			



			return $this->success();



		}else{

			return $this->failed();

		}



	}



	function send_push_visitor(){





		$count_notif = $this->db->query("SELECT COUNT(id) AS total FROM visitor WHERE is_send = 0")->row()->total;



		if ($count_notif > 0) {

			

			// $count_notif = $count_notif+1;

			for ($i=0; $i < $count_notif; $i++) { 



				$detail_notif = $this->db->query("SELECT id,ip_host,url_path,create_date AS visit_date 

				FROM visitor WHERE is_send = 0 ORDER BY id ASC LIMIT 1

				")->row();

				//push telegram



				$curl = curl_init();

				$date_now = date('Y-m-d H:i:s');

				$json = array(

					'ip_host' => $detail_notif->ip_host,

					'url_path' => $detail_notif->url_path,

					'visit_date' => $detail_notif->visit_date,

					'notif_date' => $date_now 

				);



				$id = $detail_notif->id;



				$send_json = json_encode($json);



				$post_discord = $this->post_discord_visitor($send_json);



				if($post_discord == TRUE){

					$update_status_notif = $this->db->query("UPDATE visitor SET is_send = 1 WHERE id = '$id' ");

				}

			}

			



			return $this->success();



		}else{

			return $this->failed();

		}



	}



	function send_push_activity(){





		$count_notif = $this->db->query("SELECT COUNT(id) AS total FROM log_activity WHERE is_send = 0")->row()->total;



		if ($count_notif > 0) {

			

			// $count_notif = $count_notif+1;

			for ($i=0; $i < $count_notif; $i++) { 



				$detail_notif = $this->db->query("SELECT id,ip_host,userid,url_path,create_date 

				FROM log_activity WHERE is_send = 0 ORDER BY id ASC LIMIT 1

				")->row();

				//push telegram



				$curl = curl_init();

				$date_now = date('Y-m-d H:i:s');

				$json = array(

					'ip_host' => $detail_notif->ip_host,

					'userid' => $detail_notif->userid,

					'url_path' => $detail_notif->url_path,

					'trx_date' => $detail_notif->create_date,

					'notif_date' => $date_now 

				);



				$id = $detail_notif->id;



				$send_json = json_encode($json);



				$post_discord = $this->post_discord_activity($send_json);



				if($post_discord == TRUE){

					$update_status_notif = $this->db->query("UPDATE log_activity SET is_send = 1 WHERE id = '$id' ");

				}

			}

			



			return $this->success();



		}else{

			return $this->failed();

		}



	}





	//log activity

	function insert_transaction_activity($trx_id,$log_title,$request,$response,$user_id){
		$data_insert = array(
			'trx_id' => $trx_id,
			'log_title' => $log_title,
			'log_request' => $request, 
			'log_response' => $response,
			'userid' => $user_id
		);
		$exec_data = $this->db->insert('transaction_activity',$data_insert);
		return TRUE;

	}



	function insert_transaction_gl($trx_id,$credit,$debit){

		$data_insert = array(

			'trx_id' => $trx_id,

			'credit' => $credit,

			'debit' => $debit

		);

		$exec_data = $this->db->insert('transaction_gl',$data_insert);

		return TRUE;

	}





	function exec_transaction_balance($trx_id,$credit,$debit){

		$data_insert = array(

			'trx_id' => $trx_id,

			'credit' => $credit,

			'debit' => $debit

		);

		$exec_data = $this->db->insert('transaction_balance',$data_insert);

		return TRUE;

	}







	function send_email($type_activity,$email_to,$code){



		//declare

		if ($type_activity == 1) {

			$subject = 'Kode OTP';

			$html = $this->mail->email_otp($code);

		}elseif ($type_activity == 2) {

			$subject = 'Verifikasi Akun';

			$html = $this->mail->email_verify($code);

		}elseif ($type_activity == 3) {

			$subject = 'Reset Password';

			$html = $this->mail->email_reset_password($code);

		}elseif ($type_activity == 4) {

			$subject = 'Reset PIN';

			$html = $this->mail->email_reset_pin($code);

		}else{

			$subject = '';

		}

		//

		$config = [
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'protocol'  => 'smtp',
            'smtp_host' => $this->smtp_host,
            'smtp_user' => $this->smtp_user,  
            'smtp_pass'   => $this->smtp_pass, 
            'smtp_crypto' => 'ssl',
            'smtp_port'   => 465,
            'crlf'    => "\r\n",
            'newline' => "\r\n"
        ];


        // Load library email dan konfigurasinya
        $this->load->library('email', $config);
        $this->email->from($this->smtp_user);
        $this->email->to($email_to); 
        $this->email->subject($subject);
        $this->email->message($html);
        $this->email->send();
        return TRUE;  

    }





    function transaction_poin($ref_id){

    	$get_info_transaction = $this->db->query("SELECT id,user_id,type_transaction FROM checkout WHERE trx_id = '$ref_id' 

    		")->row();







    	if (isset($get_info_transaction)) {



    		//declare

    		$trx_id = $get_info_transaction->id;

    		$userid = $get_info_transaction->user_id;

    		$type_transaction = $get_info_transaction->type_transaction;

    		

    		//get info user transaction

    		$get_info_user = $this->db->query("SELECT sub_referral_code 

    			FROM users WHERE unique_id  = '$userid' AND status = 1 ")->row();



    		if (isset($get_info_user)) {



    			$sub_referral_code = $get_info_user->sub_referral_code;



    			$cnt_referral = strlen($sub_referral_code);

    			if ($cnt_referral > 1) {

    				//

	    			$sub_referral_code = $get_info_user->sub_referral_code;

	    			$ref_code = $this->db->query("SELECT unique_id FROM users 

	    				WHERE referral_code = '$sub_referral_code' AND status = 1 ")->row();





	    			if(isset($ref_code)){



	    				$credit_poin = 1;	



	    				$userid_owner = $ref_code->unique_id;

	    				$insert_poin = array(

			    			'trx_id' => $trx_id,

			    			'userid' => $userid_owner, 

			    			'debit' => 0,

			    			'credit' => $credit_poin,

			    			'type_transaction' => $type_transaction

			    		);

			    		$this->db->insert('transaction_poin',$insert_poin);



			    		$update_poin = $this->db->query("UPDATE account SET poin = poin + '$credit_poin' WHERE userid = '$userid_owner'  ");

	    			}else{

	    				return FALSE;

	    			}

	    			

    			}else{

    				$credit_poin = 2;

    				

    			}



    			//owner	

	    		$insert_poin = array(

	    			'trx_id' => $trx_id,

	    			'userid' => $userid, 

	    			'debit' => 0,

	    			'credit' => $credit_poin,

	    			'type_transaction' => $type_transaction

	    		);

	    		$this->db->insert('transaction_poin',$insert_poin);

	    		$update_poin = $this->db->query("UPDATE account SET poin = poin + '$credit_poin' WHERE userid = '$userid'  ");

    			

    		}else{



    			return FALSE;

    		}



    		return TRUE;



    	}else{



    		return FALSE;

    	}

    }





    function visitor($ip_host,$url_path,$random_code,$secretkey){

    	$checking_key = $this->validity_key($secretkey);

	    if ($checking_key == TRUE) {



	      $data_insert = array(

	      	'ip_host' => $ip_host,

	      	'url_path' => $url_path, 

	      	'random_code' => $random_code 

	      );



	      $exec_insert = $this->db->insert('visitor',$data_insert);

	      

	      return $this->base->success();

	    }else{

	      return $this->base->invalid_key();

	    }

    }



    function log_activity($ip_host,$json_param,$userid,$url_path,$random_code,$secretkey){

    	$checking_key = $this->validity_key($secretkey);

	    if ($checking_key == TRUE) {





	      $my_var = (array) json_decode($json_param);

	      $sReplaceString = "xxxxxx";

	      if(isset($my_var["secretkey"])){

				($my_var["secretkey"] = $sReplaceString);

		  }



		  $json_param_regex = json_encode($my_var);



	      $data_insert = array(

	      	'json_param' => $json_param_regex,

	      	'ip_host' => $ip_host,

	      	'userid' => $userid,

	      	'random_code' => $random_code,

	      	'url_path' => $url_path

	      );



	      $exec_insert = $this->db->insert('log_activity',$data_insert);

	      

	      return $this->base->success();

	    }else{

	      return $this->base->invalid_key();

	    }

    }




    function last_login($ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$get_data = $this->db->query("SELECT last_login,nip,fullname,email FROM users WHERE DATE_FORMAT(last_login,'%Y-%m-%d') = '$this->date_now' ORDER BY last_login DESC ")->result();

			if (isset($get_data)) {
				return $this->base->success_data($get_data);
			}else{
				return $this->base->failed();
			}
		}else{
			return $this->base->invalid_key();
		}
	}

	function upload_pic($imageurl){


		if (strlen($imageurl) > 0) {
			$imagedata = base64_decode($imageurl);
	        $im = imagecreatefromstring($imagedata);
	        if ($im !== false) {
	            $filename =  "assets/img/profile/".md5(date('ymdhis')).'.png';
	            $filepath = FCPATH.$filename;
	            imagepng($im,$filepath,9);
	            imagedestroy($im);
	            $url_path = $this->base_url.$filename;
	            
	            return $url_path;
	        }
	        else {
	            return false;
	        }
		}else{
			return false;
		}	
	}



	function get_address_geo($latitude,$longitude){


		if (strlen($latitude) > 0) {
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$latitude.','.$longitude.'&key=AIzaSyBtghyckZKis03U5lqxBfgZwIxai3cLyxs',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'GET',
			));

			$response = curl_exec($curl);

			curl_close($curl);
			// echo $response;

			$decode = json_decode($response,true);
			$res_encode = json_encode($decode['results']);
			$queries = json_decode($res_encode);
			$index_value = json_encode($queries[3]);
			// echo $index_value;
			$decode_1 = json_decode($index_value,true);
			$res_encode1 = json_encode($decode_1['formatted_address']);
			return str_replace('"', '', json_encode($queries[3]->formatted_address));
		}else{
			return null;
		}

		

	}







    







	

}