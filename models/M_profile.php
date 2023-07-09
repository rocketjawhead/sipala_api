<?php if(!defined('BASEPATH')) exit('No direct script allowed');

class M_profile extends CI_Model{

	public function __construct() {
        parent::__construct();
        $this->load->model('M_base','base');
        $this->date_now = date('Y-m-d');

        $this->base_url = $this->config->item('base_url');
    }

    function user_profile($userid,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$data_profile = $this->db->query("
				SELECT 
				usr.id,
				usr.nip,
				usr.unique_id,
				usr.fullname,
				usr.email,
				rf.id AS id_type_account,
				rf.title AS type_account,
				gl.id AS id_level,
				gl.title AS level,
				usr.unit_1 AS unit,
				usr.unit_2 AS unit_2,
				usr.jabatan AS position,
				usr.id_lead, 
				(
					SELECT usr1.fullname FROM users usr1 WHERE usr1.id = usr.id_lead 
				) AS direct_lead,
				usr.id_head,
				(
					SELECT usr1.fullname FROM users usr1 WHERE usr1.id = usr.id_head
				) AS direct_head,
				rtw.id AS id_task_work,
				rtw.title AS task_work,
				usr.id_opd,
				od.title AS opd,
				usr.imageprofil,
				(
                	SELECT COUNT(usr1.id) AS qty FROM users usr1 WHERE usr1.id_head = usr.id OR usr1.id_lead = usr.id 
                    LIMIT 1
                ) AS id_position,
                usr.qr_url
				FROM users usr
				LEFT JOIN ref_user rf ON usr.type_account = rf.id 
				LEFT JOIN golongan gl ON usr.level = gl.id 
				LEFT JOIN ref_task_work rtw ON usr.task_priority = rtw.id
				LEFT JOIN opd od ON usr.id_opd = od.id 
				WHERE usr.unique_id = '$userid' 
				")->row();

			return $this->base->success_data($data_profile);
			

		}else{
			return $this->base->invalid_key();
		}
	}

	function check_profile($userid,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {

			$get_profile = $this->db->query("
				SELECT 
					fullname,
					nip,
					userid,
					email,
					login_date,
					latitude,
					longitude,
					address_office,
					start_absent_latitude,
					start_absent_longitude,
					today_act,
					(
					CASE
					WHEN today_act = 1 THEN 'Hadir'
					WHEN today_act = 2 THEN 'Sakit'
					WHEN today_act = 3 THEN 'Cuti'
					WHEN today_act = 4 THEN 'Dinas'
					END
					) AS today_act_desc, 
					start_absent,
					end_absent,
					start_absent_timestamp,
					end_absent_timestamp,
					total_attendance,
					total_sick,
					total_leave,
					total_dinas
				FROM (
				SELECT 
				usr.unique_id AS userid,
				usr.fullname,
				usr.nip,
				usr.email,
				usr.login_date,
				od.latitude,
				od.longitude,
				od.title AS address_office,
				(
					SELECT act.act_id FROM activity act WHERE act.user_id = usr.unique_id 
					AND act.act_id IN (1,2,3,4) AND act.act_date = '$this->date_now' 
					ORDER BY act.create_date ASC
					LIMIT 1 
				) AS today_act,
				(
					SELECT act.start_time FROM activity act WHERE act.user_id = usr.unique_id 
					AND act.act_id = 1 AND act.act_date = '$this->date_now' 
					ORDER BY act.create_date ASC
					LIMIT 1 
				) AS start_absent,
				(
					SELECT act.create_date FROM activity act WHERE act.user_id = usr.unique_id 
					AND act.act_id = 1 AND act.act_date = '$this->date_now' 
					ORDER BY act.create_date ASC
					LIMIT 1 
				) AS start_absent_timestamp,
				(
					SELECT act.latitude FROM activity act WHERE act.user_id = usr.unique_id 
					AND act.act_id = 1 AND act.act_date = '$this->date_now' 
					ORDER BY act.create_date ASC
					LIMIT 1 
				) AS start_absent_latitude,
				(
					SELECT act.longitude FROM activity act WHERE act.user_id = usr.unique_id 
					AND act.act_id = 1 AND act.act_date = '$this->date_now' 
					ORDER BY act.create_date ASC
					LIMIT 1 
				) AS start_absent_longitude,
				(
					SELECT act.start_time FROM activity act WHERE act.user_id = usr.unique_id 
					AND act.act_id = 5 AND act.act_date = '$this->date_now' 
					ORDER BY act.create_date ASC
					LIMIT 1 
				) AS end_absent,
				(
					SELECT act.create_date FROM activity act WHERE act.user_id = usr.unique_id 
					AND act.act_id = 5 AND act.act_date = '$this->date_now' 
					ORDER BY act.create_date ASC
					LIMIT 1 
				) AS end_absent_timestamp,
				(
					SELECT COUNT(id) AS QTY 
					FROM activity act 
					WHERE act.act_id = '1' 
					AND act.user_id = usr.unique_id 
				)  AS total_attendance,
				(
					SELECT COUNT(id) AS QTY 
					FROM activity act 
					WHERE act.act_id = '2' 
					AND act.user_id = usr.unique_id 
				)  AS total_sick,
				(
					SELECT COUNT(id) AS QTY 
					FROM activity act 
					WHERE act.act_id = '3' 
					AND act.user_id = usr.unique_id 
				)  AS total_leave,
				(
					SELECT COUNT(id) AS QTY 
					FROM activity act 
					WHERE act.act_id = '4' 
					AND act.user_id = usr.unique_id 
				)  AS total_dinas
				FROM users usr 
				LEFT JOIN opd od ON usr.id_opd = od.id
				WHERE usr.status = 1 AND usr.unique_id = '$userid' 
				) GAB 
				")->row();


			$day_now = date('D');
			if ($day_now == 'Mon') {
				$is_apel = 0;

				//checking existing absent
				$check_apel_now = $this->db->query("
					SELECT COUNT(id) AS qty FROM activity act 
					WHERE act.user_id = '$userid' 
					AND act.act_id = '6' 
					AND act.act_date = '$this->date_now'
					")->row()->qty;

				if ($check_apel_now > 0) {
					$is_apel = 1;
				}else{

					//check jam
					$current_date = date('H:i:s');
					$expired_apel = '10:00:00';
					$time = date('H:i:s', strtotime($expired_apel));

					if ($current_date > $time ) {
						$is_apel = 1;
					}else{
						$is_apel = 0;
					}
				}

			}else{
				$is_apel = 1;
			}


			if ($is_apel == 0) {
				$radius_absent = 0;
			}else{
				$radius_absent = 800;	
			}
			

			if (isset($get_profile)) {
				$data_res = array(
					'fullname' => $get_profile->fullname,
					'userid' => $get_profile->userid,
					'nip' => $get_profile->nip,
					'email' => $get_profile->email,
					'login_date' => $get_profile->login_date, 
					'latitude' => doubleval($get_profile->latitude),
					'longitude' => doubleval($get_profile->longitude),
					'address_office' => $get_profile->address_office,
					'start_absent_latitude' => doubleval($get_profile->start_absent_latitude),
					'start_absent_longitude' => doubleval($get_profile->start_absent_longitude),
					'start_absent_address' => $this->base->get_address_geo($get_profile->start_absent_latitude,$get_profile->start_absent_longitude),
					// 'start_absent_address' => $this->base->get_address_geo($latitude,$longitude),
					'today_act' => $get_profile->today_act,
					'today_act_desc' => $get_profile->today_act_desc,
					'start_absent' => $get_profile->start_absent,
					'end_absent' => $get_profile->end_absent,
					'start_absent_timestamp' => $get_profile->start_absent_timestamp,
					'end_absent_timestamp' => $get_profile->end_absent_timestamp,
					'total_attendance' => $get_profile->total_attendance,
					'total_sick' => $get_profile->total_sick,
					'total_leave' => $get_profile->total_leave,
					'total_dinas' => $get_profile->total_dinas,
					'radius_absent' => $radius_absent,
					'is_apel' => $is_apel
				);
				return $this->base->success_data($data_res);
			}else{
				return $this->base->failed();
			}

		}else{
			return $this->base->invalid_key();
		}
	}

	function check_profile_old($userid,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			

			$get_last_login = $this->db->query("SELECT status_date,start_leave,end_leave FROM users WHERE unique_id = '$userid' ")->row();

			if ($get_last_login->end_leave == NULL) {
				if ($get_last_login->status_date == NULL || $get_last_login->status_date == $this->date_now) {
					// $status = false;
				}else{
					$update_status_absent = $this->db->query("UPDATE users SET status_act = '0' WHERE unique_id = '$userid'  ");
				}
			}else{
				if ($this->date_now > $get_last_login->end_leave) {
					$update_status_absent = $this->db->query("UPDATE users SET status_act = '0',start_leave = NULL, end_leave = NULL WHERE unique_id = '$userid'  ");
				}
			}


			$get_balance = $this->db->query("SELECT 
				usr.email,usr.status_act,usr.login_date,usr.logout_date,rt.title AS status_desc 
				FROM users usr 
				LEFT JOIN ref_task rt ON usr.status_act = rt.id
				WHERE usr.status = 1 AND usr.unique_id = '$userid' ")->row();

			if (isset($get_balance)) {
				return $this->base->success_data($get_balance);
			}else{
				return $this->base->failed();
			}

		}else{
			return $this->base->invalid_key();
		}
	}


	function update_password($userid,$password_old,$password_new,$password_new_conf,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			if ($password_new != $password_new_conf) {
				return $this->base->failed();
			}

			$new_password_old = sha1($password_old);
			$check_profile = $this->db->query("SELECT COUNT(id) AS total 
				FROM users WHERE unique_id = '$userid' AND password = '$new_password_old' AND status = 1 ")->row()->total;

			if ($check_profile > 0) {

				$gen_password_new = sha1($password_new);
				$update_password = $this->db->query("UPDATE users SET password = '$gen_password_new' 
					WHERE unique_id = '$userid' ");

				return $this->base->success();
			}else{
				return $this->base->failed();
			}

		}else{
			return $this->base->invalid_key();
		}
	}


	function update_pin($userid,$pin_old,$pin_new,$pin_new_conf,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			if ($pin_new != $pin_new_conf) {
				return $this->base->failed();
			}

			$new_pin_old = sha1($pin_old);
			$check_profile = $this->db->query("SELECT COUNT(id) AS total 
				FROM users WHERE unique_id = '$userid' AND pin = '$new_pin_old' AND status = 1 ")->row()->total;

			if ($check_profile > 0) {

				$gen_pin_new = sha1($pin_new);
				$update_pin = $this->db->query("UPDATE users SET pin = '$gen_pin_new' 
					WHERE unique_id = '$userid' ");

				return $this->base->success();
			}else{
				return $this->base->failed();
			}

		}else{
			return $this->base->invalid_key();
		}
	}

	function update_profile($userid,$fullname,$email,$position,$unit,$unit_2,$id_lead,$id_head,$task_work,$opd,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			

			$check_profile = $this->db->query("SELECT COUNT(id) AS total 
				FROM users WHERE unique_id = '$userid' AND status = 1 ")->row()->total;

			if ($check_profile > 0) {

				$update_profile = $this->db->query("UPDATE users 
					SET fullname = '$fullname',
					email = '$email',
					jabatan = '$position',
					unit_1 = '$unit',
					unit_2 = '$unit_2',
					id_lead = '$id_lead',
					id_head = '$id_head',
					task_priority = '$task_work',
					id_opd = '$opd' 
					WHERE unique_id = '$userid' ");

				return $this->base->success();
			}else{
				return $this->base->failed();
			}

		}else{
			return $this->base->invalid_key();
		}
	}

	//change picture
	function update_picture($imageurl,$userid,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$check_profile = $this->db->query("SELECT COUNT(id) AS total 
				FROM users WHERE unique_id = '$userid' AND status = 1 ")->row()->total;

			if ($check_profile > 0) {
				//data
		        $imagedata = base64_decode($imageurl);
		        $im = imagecreatefromstring($imagedata);
		        if ($im !== false) {
		            $filename =  "assets/img/profile/".md5(date('ymdhis')).'.png';
		            $filepath = FCPATH.$filename;
		            imagepng($im,$filepath,9);
		            imagedestroy($im);
		            $url_path = $this->base_url.$filename;
		            $update_picture = $this->db->query("UPDATE users SET imageprofil = '$url_path' WHERE unique_id = '$userid' ");

		            $data_res = array(
		            	'imageprofil' => $url_path 
		            );

		            return $this->base->success_data($data_res);
		        }
		        else {
		            return $this->base->failed();
		        }
		        //end
			}else{
				return $this->base->failed();
			}

		}else{
			return $this->base->invalid_key();
		}
	}


	function update_user($userid,$fullname,$id_opd,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			

			$check_profile = $this->db->query("SELECT COUNT(id) AS total 
				FROM users WHERE unique_id = '$userid' AND status = 1 ")->row()->total;

			if ($check_profile > 0) {

				$update_profile = $this->db->query("UPDATE users 
					SET fullname = '$fullname',
					id_opd = '$id_opd' 
					WHERE unique_id = '$userid' ");

				return $this->base->success();
			}else{
				return $this->base->failed();
			}

		}else{
			return $this->base->invalid_key();
		}
	}

	function change_password($userid,$password_old,$password,$password_conf,$ip_host,$secretkey){


		$checking_key = $this->base->validity_key($secretkey);

		if ($checking_key == TRUE) {


			$enc_password_old = sha1($password_old);

			$sql = "SELECT usr.id FROM users usr 
				WHERE usr.password = '$enc_password_old' 
				AND usr.unique_id = '$userid'
				";

			// echo $password_conf;

			$check_data = $this->db->query($sql)->row();

			if (isset($check_data)) {

				if ($password != $password_conf) {
					return $this->base->failed();
				}
				
				$new_password = sha1($password);
				$update_password = $this->db->query("UPDATE users SET password = '$new_password' WHERE unique_id = '$userid' ");
				return $this->base->success();

			}else{
				return $this->base->failed();
			}
		}else{
			return $this->base->invalid_key();
		}



	}

	
}