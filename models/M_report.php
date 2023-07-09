<?php if(!defined('BASEPATH')) exit('No direct script allowed');

class M_report extends CI_Model{

	public function __construct() {
        parent::__construct();
        $this->load->model('M_base','base');
    }

	function task_daily($user_id,$start_date,$end_date,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			

			$sql = "SELECT 
					act.id,
					act.user_id,
					act.act_date,
					act.start_time,
					act.end_time,
					IFNULL(act.act_detail,'') AS act_detail,
					HOUR(TIMEDIFF(act.end_time, act.start_time)) AS diff_hour,
					MINUTE(TIMEDIFF(act.end_time, act.start_time)) AS diff_minute,
					IFNULL(pl.title,'') AS place,
					IFNULL(og.title,'') AS organizer,
					rf.title AS status_desc
					FROM activity act 
					LEFT JOIN ref_place pl ON act.place = pl.id  
					LEFT JOIN ref_organizer og ON act.pj = og.id 
					LEFT JOIN ref_task rf ON act.act_id = rf.id
					WHERE act.user_id = '$user_id' 
					AND act.act_date >= '$start_date' 
					AND act.act_date <= '$end_date'
					AND act.act_id IN (0,1,5)
					ORDER BY act.id DESC";

			// echo $sql;

			$get_data = $this->db->query($sql)->result();

			if (isset($get_data)) {
				return $this->base->success_data($get_data);
			}else{
				return $this->base->failed();
			}
		}else{
			return $this->base->invalid_key();
		}
	}

	//
	function task_daily_staff($user_id,$start_date,$end_date,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			

			$sql = "SELECT 
					act.id,
					act.user_id,
					act.act_date,
					act.start_time,
					act.end_time,
					-- IFNULL(act.act_detail,'') AS act_detail,
					(
					CASE
						WHEN act.act_id = 1 THEN 'Masuk'
						WHEN act.act_id = 5 THEN 'Pulang'
						WHEN act.act_id > 0 THEN 'act.act_detail'
						ELSE act.act_detail
					END
					) AS act_detail,
					HOUR(TIMEDIFF(act.end_time, act.start_time)) AS diff_hour,
					MINUTE(TIMEDIFF(act.end_time, act.start_time)) AS diff_minute,
					act.place AS place,
					act.pj AS organizer,
					act.is_approved,
					(
					CASE
						WHEN act.is_approved = 0 THEN 'Menunggu'
						ELSE 'Approve' 
					END
					) AS status_approved,
					(
					CASE
						WHEN act.is_approved = 0 THEN 'bg-warning'
						ELSE 'bg-success' 
					END
					) AS status_badged
					FROM activity act 
					INNER JOIN users usr ON act.user_id = usr.unique_id
					-- LEFT JOIN ref_place pl ON act.place = pl.id  
					-- LEFT JOIN ref_organizer og ON act.pj = og.id 
					-- LEFT JOIN ref_task rf ON act.act_id = rf.id
					WHERE usr.nip =  '$user_id' 
					AND act.act_date >= '$start_date' 
					AND act.act_date <= '$end_date'
					ORDER BY act.id DESC";

			// echo $sql;

			$get_data = $this->db->query($sql)->result();

			if (isset($get_data)) {
				return $this->base->success_data($get_data);
			}else{
				return $this->base->failed();
			}
		}else{
			return $this->base->invalid_key();
		}
	}

	function exec_task_daily_staff($id,$user_id,$start_date,$end_date,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {

			

			// $update = $this->db->query("UPDATE activity act SET act.is_approved = 1 
			// 		WHERE act.user_id = '$user_id' 
			// 		AND act.act_date >= '$start_date' 
			// 		AND act.act_date <= '$end_date' ");

			$data = array(
				'is_approved' => 1,
				'date_approved' => date('Y-m-d H:i:s')
			);
	        $this->db->where_in('id', $id);
			$data = $this->db->update('activity', $data);
			

			if (isset($data)) {
				return $this->base->success();
			}else{
				return $this->base->failed();
			}
		}else{
			return $this->base->invalid_key();
		}
	}


	function get_summary($user_id,$start_date,$end_date,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			

			$sql = "SELECT 
					activity_date,
				    total_hour,
				    total_minute,
				    today_act,
				    (
				    CASE
				    WHEN today_act = 1 THEN 'HADIR'
				    WHEN today_act = 2 THEN 'SAKIT'
				    WHEN today_act = 3 THEN 'CUTI'
				    WHEN today_act = 4 THEN 'DINAS'
				    END
				    ) AS today_act_desc
				FROM(
				SELECT 
				CONCAT(DAYNAME(act.act_date),', ',DATE_FORMAT(act.act_date,'%a %d %M %Y')) AS  activity_date,
				SUM(HOUR(TIMEDIFF(act.end_time, act.start_time))) AS total_hour,
				SUM(MINUTE(TIMEDIFF(act.end_time, act.start_time))) AS total_minute,
				(
					SELECT act1.act_id FROM activity act1 WHERE act1.user_id = act.user_id 
				    ORDER BY act1.create_date ASC 
				    LIMIT 1
				) AS today_act
				FROM activity act 
				WHERE act.user_id = '$user_id' 
				AND act.act_date >= '$start_date' 
				AND act.act_date <= '$end_date'
				GROUP BY act.act_date
				) GAB;";

			// echo $sql;
			// die();

			$get_data = $this->db->query($sql)->result();

			if (isset($get_data)) {
				return $this->base->success_data($get_data);
			}else{
				return $this->base->failed();
			}
		}else{
			return $this->base->invalid_key();
		}
	}


	function print_summary($user_id,$start_date,$end_date,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {


			$get_profil = $this->db->query("
				SELECT 
				usr.nip,
				usr.fullname,
				usr.email,
				gol.title AS golongan 
				FROM users usr
				INNER JOIN golongan gol ON gol.id = usr.level
				WHERE usr.unique_id = '$user_id' 
				")->row();



			$get_total_act = $this->db->query("
				SELECT COUNT(*) AS qty FROM( SELECT act.act_date FROM activity act 
				WHERE act.user_id = '$user_id' 
				AND act.act_date >= '$start_date' 
				AND act.act_date <= '$end_date' 
				GROUP BY act.act_date ) GAB; 
				")->row()->qty;
			

			$sql = "SELECT 
					activity_date,
				    total_hour,
				    total_minute,
				    today_act,
				    (
				    CASE
				    WHEN today_act = 1 THEN 'HADIR'
				    WHEN today_act = 2 THEN 'SAKIT'
				    WHEN today_act = 3 THEN 'CUTI'
				    WHEN today_act = 4 THEN 'DINAS'
				    END
				    ) AS today_act_desc
				FROM(
				SELECT 
				CONCAT(DAYNAME(act.act_date),', ',DATE_FORMAT(act.act_date,'%a %d %M %Y')) AS  activity_date,
				SUM(HOUR(TIMEDIFF(act.end_time, act.start_time))) AS total_hour,
				SUM(MINUTE(TIMEDIFF(act.end_time, act.start_time))) AS total_minute,
				(
					SELECT act1.act_id FROM activity act1 WHERE act1.user_id = act.user_id 
				    ORDER BY act1.create_date ASC 
				    LIMIT 1
				) AS today_act
				FROM activity act 
				WHERE act.user_id = '$user_id' 
				AND act.act_date >= '$start_date' 
				AND act.act_date <= '$end_date'
				GROUP BY act.act_date
				) GAB;";

			$get_data = $this->db->query($sql)->result();


			$data_summary = array(
				'nip' => $get_profil->nip,
				'email' => $get_profil->email, 
				'fullname' => $get_profil->fullname,
				'golongan' => $get_profil->golongan,
				'total_day' => $get_total_act,
				'data' => $get_data
			);

			if (isset($get_data)) {
				return $this->base->success_data($data_summary);
			}else{
				return $this->base->failed();
			}
		}else{
			return $this->base->invalid_key();
		}
	}


	function absent($userid,$limit,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {


			if ($limit > 0) {
				$sql = "SELECT 
						act.id,
						act.user_id,
						DATE_FORMAT(act.act_date,'%d %M %Y') AS date_absent,
						act.start_time AS start_absent,
						(
							SELECT IFNULL(act1.start_time,'') FROM activity act1 
							WHERE act1.user_id = '$userid' 
							AND act1.act_id = 5 
							AND act1.act_date = act.act_date
 						) AS end_absent,
 						'' AS address
						FROM activity act 
						WHERE act.user_id = '$userid' 
						AND act.act_id = 1
						ORDER BY act.id DESC
						LIMIT $limit
						";
			}else{
				$sql = "SELECT 
						act.id,
						act.user_id,
						DATE_FORMAT(act.act_date,'%d %M %Y') AS date_absent,
						act.start_time AS start_absent,
						(
							SELECT IFNULL(act1.start_time,'') FROM activity act1 
							WHERE act1.user_id = '$userid' 
							AND act1.act_id = 5 
							AND act1.act_date = act.act_date
 						) AS end_absent,
 						'' AS address
						FROM activity act 
						WHERE act.user_id = '$userid' 
						AND act.act_id = 1
						ORDER BY act.id DESC
						";
			}
			

			

			// echo $sql;

			$get_data = $this->db->query($sql)->result();

			if (isset($get_data)) {
				return $this->base->success_data($get_data);
			}else{
				return $this->base->failed();
			}
		}else{
			return $this->base->invalid_key();
		}
	}

	function absent_date($userid,$start_date,$end_date,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {


			if (strlen($start_date) == 0) {
				$sql = "SELECT 
						act.id,
						act.user_id,
						DATE_FORMAT(act.act_date,'%d %M %Y') AS date_absent,
						act.start_time AS start_absent,
						(
							SELECT IFNULL(act1.start_time,'') FROM activity act1 
							WHERE act1.user_id = '$userid' 
							AND act1.act_id = 5 
							AND act1.act_date = act.act_date
 						) AS end_absent,
 						'' AS address
						FROM activity act 
						WHERE act.user_id = '$userid' 
						AND act.act_id = 1
						AND act.act_date <= '$end_date'
						ORDER BY act.id DESC
						";
			}else{
				$sql = "SELECT 
						act.id,
						act.user_id,
						DATE_FORMAT(act.act_date,'%d %M %Y') AS date_absent,
						act.start_time AS start_absent,
						(
							SELECT IFNULL(act1.start_time,'') FROM activity act1 
							WHERE act1.user_id = '$userid' 
							AND act1.act_id = 5 
							AND act1.act_date = act.act_date
 						) AS end_absent,
 						'' AS address
						FROM activity act 
						WHERE act.user_id = '$userid' 
						AND act.act_id = 1 
						AND act.act_date >= '$start_date'
						AND act.act_date <= '$end_date'
						ORDER BY act.id DESC
						";
			}
			

			

			// echo $sql;

			$get_data = $this->db->query($sql)->result();

			if (isset($get_data)) {
				return $this->base->success_data($get_data);
			}else{
				return $this->base->failed();
			}
		}else{
			return $this->base->invalid_key();
		}
	}





	
}