<?php if(!defined('BASEPATH')) exit('No direct script allowed');

class M_user extends CI_Model{

	public function __construct() {
        parent::__construct();
        $this->load->model('M_base','base');
        $this->base_url = $this->config->item('base_url');
    }

	function get_user($ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$get_data = $this->db->query("SELECT 
										usr.id,
										usr.nip,
										usr.unique_id,
										usr.fullname,
										usr.email,
										rf.title AS type_account,
										gl.title AS level,
										un.title AS unit,
										bg.title AS position,
										(
											SELECT usr1.fullname FROM users usr1 WHERE usr1.id = usr.id_lead 
										) AS direct_lead,
										(
											SELECT usr1.fullname FROM users usr1 WHERE usr1.id = usr.id_head
										) AS direct_head,
										rtw.title AS task_work,
										usr.is_admin
										FROM users usr
										LEFT JOIN ref_user rf ON usr.type_account = rf.id 
										LEFT JOIN golongan gl ON usr.level = gl.id 
										LEFT JOIN unit un ON usr.work_unit = un.id 
										LEFT JOIN bagian bg ON usr.position = bg.id 
										LEFT JOIN ref_task_work rtw ON usr.task_priority = rtw.id;")->result();

			if (isset($get_data)) {
				return $this->base->success_data($get_data);
			}else{
				return $this->base->failed();
			}
		}else{
			return $this->base->invalid_key();
		}
	}


	function add_user($nip,$fullname,$email,$password,$type_account,$golongan,$unit,$position,$id_lead,$id_head,$task_work,$opd,$user_id,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {


			$unique_id = rand(10,99).date("YmdHis");

			$validation_nip = $this->db->query("SELECT COUNT(id) AS qty FROM users WHERE nip = '$nip' ")->row()->qty;
			$validation_email = $this->db->query("SELECT COUNT(id) AS qty FROM users WHERE email = '$email' ")->row()->qty;

			if ($validation_email > 0 || $validation_nip > 0) {
				return $this->base->failed();
			}

			$qrcode_string=$nip.'.png';
			$this->base->generate_qr($unique_id,$qrcode_string);
			
			$data_insert = array(
				'unique_id' => $unique_id,
				'nip' => $nip,
				'fullname' => $fullname, 
				'email' => $email,
				'password' => sha1($password),
				'type_account' => $type_account,
				'level' => $golongan,
				'work_unit' => $unit,
				'position' => $position,
				'id_lead' => $id_lead,
				'id_head' => $id_head,
				'task_priority' => $task_work,
				'id_opd' => $opd,
				'qr_url' => $this->base_url.'uploads/qrcode/'.$qrcode_string,
				'create_by' => $user_id
			);

			$insert_data = $this->db->insert('users',$data_insert);

			if ($insert_data == TRUE) {

				return $this->base->success();

			}else{

				return $this->base->failed();

			}
		}else{
			return $this->base->invalid_key();
		}
	}


	function detail_user($id,$ip_host,$secretkey){
    $checking_key = $this->base->validity_key($secretkey);
    if ($checking_key == TRUE) {

      $sql = "SELECT 
			usr.id,
			usr.nip,
			usr.unique_id,
			usr.fullname,
			usr.email,
			rf.id AS id_type_account,
			rf.title AS type_account,
			gl.id AS id_level,
			gl.title AS level,
			un.id AS id_unit,
			un.title AS unit,
			bg.id AS id_position,
			bg.title AS position,
			usr.id_lead,
			usr.id_head,
			(
				SELECT usr1.fullname FROM users usr1 WHERE usr1.id = usr.id_lead 
			) AS direct_lead,
			(
				SELECT usr1.fullname FROM users usr1 WHERE usr1.id = usr.id_head
			) AS direct_head,
			rtw.id AS id_task_work,
			rtw.title AS task_work,
			usr.id_opd,
			od.title AS opd,
			usr.status
			FROM users usr
			LEFT JOIN ref_user rf ON usr.type_account = rf.id 
			LEFT JOIN golongan gl ON usr.level = gl.id 
			LEFT JOIN unit un ON usr.work_unit = un.id 
			LEFT JOIN bagian bg ON usr.position = bg.id 
			LEFT JOIN ref_task_work rtw ON usr.task_priority = rtw.id
			LEFT JOIN opd od ON od.id = usr.id_opd 
			WHERE usr.id = '$id'
			";

      $res_sql = $this->db->query($sql)->row();

      if (isset($res_sql)) {
        return $this->base->success_data($res_sql);
      }else{
        return $this->base->invalid_execute();
      }
      
    }else{
      return $this->base->invalid_key();
    }
  }


	function update_user($id,$nip,$fullname,$email,$type_account,$golongan,$unit,$position,$id_lead,$id_head,$task_work,$opd,$status,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {


			$validation_nip = $this->db->query("SELECT COUNT(id) AS qty FROM users WHERE nip = '$nip' AND id != '$id' ")->row()->qty;
			$validation_email = $this->db->query("SELECT COUNT(id) AS qty FROM users WHERE email = '$email' AND id != '$id' ")->row()->qty;

			if ($validation_email > 0 || $validation_nip > 0) {
				return $this->base->failed();
			}
			
			$update_data = $this->db->query("
				UPDATE users SET 
				nip = '$nip',
				fullname = '$fullname', 
				email = '$email',
				type_account = '$type_account',
				level = '$golongan',
				work_unit = '$unit',
				position = '$position',
				id_lead = '$id_lead',
				id_head = '$id_head',
				task_priority = '$task_work',
				id_opd = '$opd',
				status = '$status'
				WHERE id = '$id' ");

			if ($update_data == TRUE) {

				return $this->base->success();

			}else{

				return $this->base->failed();
				
			}
		}else{
			return $this->base->invalid_key();
		}
	}


	function delete_user($id,$title,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$update_data = $this->db->query("UPDATE user SET status = '0' WHERE id = '$id' ");

			if ($update_data == TRUE) {

				return $this->base->success();

			}else{

				return $this->base->failed();
				
			}
		}else{
			return $this->base->invalid_key();
		}
	}

	//

	function get_staff($userid,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			

			$get_head_id = $this->db->query("SELECT id FROM users WHERE unique_id = '$userid' ")->row()->id;

			$get_data = $this->db->query("SELECT 
										usr.id,
										usr.nip,
										usr.unique_id,
										usr.fullname,
										usr.email
										FROM users usr
										WHERE usr.id_lead = '$get_head_id' 
										OR usr.id_head = '$get_head_id'
										")->result();

			if (isset($get_data)) {
				return $this->base->success_data($get_data);
			}else{
				return $this->base->failed();
			}
		}else{
			return $this->base->invalid_key();
		}
	}


	function bulk_qr($secretkey){


		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {

		$data_user = $this->db->query("SELECT * FROM users")->result();

		foreach ($data_user as $val) {
			  	// echo $value->unique_id."<br/>";

			  	//generate qr
		    	$qrcode_string=$val->nip.'.png';
				$this->base->generate_qr($val->unique_id,$qrcode_string);
				$qrcode_url = $this->base_url.'uploads/qrcode/'.$qrcode_string;
		    	//end generate qr
		    	$update_qr = $this->db->query("UPDATE users SET qr_url = '$qrcode_url' WHERE unique_id = '$val->unique_id'  ");

		}

		return $this->base->success();

		}else{
			return $this->base->invalid_key();
		}


	}


	function change_admin($userid,$is_admin,$secretkey){


		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {

		$update = $this->db->query("UPDATE users SET is_admin = '$is_admin' WHERE unique_id = '$userid' ");

		return $this->base->success();

		}else{
			return $this->base->invalid_key();
		}


	}


	function find_user($uniqueid,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$sql = "SELECT 
					usr.id,
					usr.nip,
					usr.unique_id,
					usr.fullname,
					usr.email,
					rf.title AS type_account,
					gl.title AS level,
					un.title AS unit,
					bg.title AS position,
					(
						SELECT usr1.fullname FROM users usr1 WHERE usr1.id = usr.id_lead 
					) AS direct_lead,
					(
						SELECT usr1.fullname FROM users usr1 WHERE usr1.id = usr.id_head
					) AS direct_head,
					rtw.title AS task_work,
					usr.is_admin
					FROM users usr
					LEFT JOIN ref_user rf ON usr.type_account = rf.id 
					LEFT JOIN golongan gl ON usr.level = gl.id 
					LEFT JOIN unit un ON usr.work_unit = un.id 
					LEFT JOIN bagian bg ON usr.position = bg.id 
					LEFT JOIN ref_task_work rtw ON usr.task_priority = rtw.id
					WHERE usr.unique_id = '$uniqueid'
					";

	      $res_sql = $this->db->query($sql)->row();

	      if (isset($res_sql)) {
	        return $this->base->success_data($res_sql);
	      }else{
	        return $this->base->invalid_execute();
	      }

		}
	}






	
}