<?php if(!defined('BASEPATH')) exit('No direct script allowed');

class M_absent extends CI_Model{

	public function __construct() {
        parent::__construct();
        $this->load->model('M_base','base');
        $this->date_now = date('Y-m-d');
    }



    function list_absent($user_id,$type_absent,$limit,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
				
			$get_info = $this->db->query("SELECT * FROM users WHERE unique_id  = '$user_id' ")->row();

			if (isset($get_info)) {
				$id = $get_info->id;

				

					if ($limit == 0) {
						$sql = "
								SELECT 
								DATE_FORMAT(create_date,'%d %M %Y %H:%i:%s') AS request_date,
								MIN(act_date) AS start_leave,
								MAX(act_date) AS end_leave,
								act_detail,
								status_active,
								(
								CASE
									WHEN is_approved = 0 THEN 'Menunggu'
									ELSE 'Approve' 
								END
								) AS status_approved,
								is_approved,
								imageurl,
								act_id,
								(
								CASE
									WHEN act_id = 1 THEN 'Hadir'
									WHEN act_id = 5 THEN 'Pulang'
									WHEN act_id = 2 THEN 'Sakit'
									WHEN act_id = 3 THEN 'Cuti'
									WHEN act_id = 4 THEN 'Dinas'
								END
								) AS act_desc,
								date_approved,
								(
                                	SELECT COUNT(act1.id) AS QTY FROM activity act1 WHERE act1.unique_numb = unique_numb
                                ) AS total_absent
								FROM activity 
								WHERE user_id = '$user_id'  
								AND act_id IN ($type_absent)
								GROUP BY user_id,unique_numb 
								ORDER BY create_date DESC
								";
					}else{
						$sql = "
								SELECT 
								DATE_FORMAT(create_date,'%d %M %Y %H:%i:%s') AS request_date,
								MIN(act_date) AS start_leave,
								MAX(act_date) AS end_leave,
								act_detail,
								status_active,
								(
								CASE
									WHEN is_approved = 0 THEN 'Menunggu'
									ELSE 'Approve' 
								END
								) AS status_approved,
								is_approved,
								imageurl,
								act_id,
								(
								CASE
									WHEN act_id = 1 THEN 'Hadir'
									WHEN act_id = 5 THEN 'Pulang'
									WHEN act_id = 2 THEN 'Sakit'
									WHEN act_id = 3 THEN 'Cuti'
									WHEN act_id = 4 THEN 'Dinas'
								END
								) AS act_desc,
								date_approved,
								(
                                	SELECT COUNT(act1.id) AS QTY FROM activity act1 WHERE act1.unique_numb = unique_numb
                                ) AS total_absent
								FROM activity 
								WHERE user_id = '$user_id' 
								AND act_id IN ($type_absent)  
								GROUP BY user_id,unique_numb 
								ORDER BY create_date DESC
								LIMIT $limit
								";
					}
					
				
				


				$get_data = $this->db->query($sql)->result();

				if (isset($get_data)) {
					return $this->base->success_data($get_data);
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

	function list_absent_staff($user_id,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
				
			$get_info = $this->db->query("SELECT * FROM users WHERE unique_id  = '$user_id' ")->row();

			if (isset($get_info)) {
				$id = $get_info->id;
				$get_data = $this->db->query("
					SELECT 
						request_date,
						DATE_FORMAT(start_leave,'%d %M %Y') AS start_leave,
						DATE_FORMAT(end_leave,'%d %M %Y') AS end_leave,
						act_detail,
						nip,
						fullname,
						status_active,
						unique_numb,
						imageurl
					FROM(
					SELECT
					DATE_FORMAT(act.create_date,'%d %M %Y %H:%i:%s') AS request_date, 
					MIN(act.act_date) AS start_leave,
					MAX(act.act_date) AS end_leave,
					act.act_detail,
					usr.nip,
					usr.fullname,
					act.status_active,
					act.unique_numb,
					act.imageurl
					FROM activity act 
					INNER JOIN users usr ON usr.unique_id = act.user_id
					WHERE act.act_id = 3 
					AND act.status_active = 0 
					AND usr.id_lead = '$id' 
					OR usr.id_head = '$id' 
					GROUP BY act.user_id,DATE_FORMAT(act.create_date,'%Y-%m-%d')
					) GAB
					")->result();

				if (isset($get_data)) {
					return $this->base->success_data($get_data);
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


	function check_absent($user_id,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			

			$count_activity = $this->db->query("SELECT COUNT(id) AS qty FROM activity WHERE act_date = '$this->date_now' AND act_id IN (1,2,3,4,5) AND user_id = '$user_id' ")->row();


			$get_start_absent = $this->db->query("SELECT start_time,act_detail,latitude,longitude FROM activity WHERE act_date = '$this->date_now' AND act_id = 1 AND user_id = '$user_id' ")->row();

			$get_end_absent = $this->db->query("SELECT start_time,act_detail,latitude,longitude FROM activity WHERE act_date = '$this->date_now' AND act_id = 5 AND user_id = '$user_id' ")->row();

			$sick_absent = $this->db->query("SELECT start_time,act_detail,latitude,longitude FROM activity WHERE act_date = '$this->date_now' AND act_id = 2 AND user_id = '$user_id' ")->row();

			if (isset($get_start_absent)) {
				$start_time_absent = $get_start_absent->start_time;
				$start_desc_absent = $get_start_absent->act_detail;
				$start_latitude_absent = $get_start_absent->latitude;
				$start_longitude_absent = $get_start_absent->longitude;
			}else{
				$start_time_absent = null;
				$start_desc_absent = null;
				$start_latitude_absent = null;
				$start_longitude_absent = null;
			}

			if (isset($get_end_absent)) {
				$end_time_absent = $get_end_absent->start_time;
				$end_desc_absent = $get_end_absent->act_detail;
				$end_latitude_absent = $get_end_absent->latitude;
				$end_longitude_absent = $get_end_absent->longitude;
			}else{
				$end_time_absent = null;
				$end_desc_absent = null;
				$end_latitude_absent = null;
				$end_longitude_absent = null;
			}

			if (isset($sick_absent)) {
				$sick_time_absent = $sick_absent->start_time;
				$sick_desc_absent = $sick_absent->act_detail;
				$sick_latitude_absent = $get_sick_absent->latitude;
				$sick_longitude_absent = $get_sick_absent->longitude;
			}else{
				$sick_time_absent = null;
				$sick_desc_absent = null;
				$sick_latitude_absent = null;
				$sick_longitude_absent = null;
			}

			$data = array(
				'date_absent' => $this->date_now,
				'count_act' => $count_activity->qty,
				'start_time_absent' => $start_time_absent,
				'start_desc_absent' => $start_desc_absent,
				'start_latitude_absent' => $start_latitude_absent,
				'start_longitude_absent' => $start_longitude_absent,
				'end_time_absent' => $end_time_absent,
				'end_desc_absent' => $end_desc_absent,
				'end_latitude_absent' => $end_latitude_absent,
				'end_longitude_absent' => $end_longitude_absent,
				'sick_time_absent' => $sick_time_absent,
				'sick_desc_absent' => $sick_desc_absent,
				'sick_latitude_absent' => $sick_latitude_absent,
				'sick_longitude_absent' => $sick_longitude_absent
			);

			return $this->base->success_data($data);

		}else{
			return $this->base->invalid_key();
		}
	}



	function approve_absent($user_id,$absentid,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
				
				$update = $this->db->query("UPDATE activity SET status_active = 1 WHERE unique_numb = '$absentid' ");

				return $this->base->success();
		}else{
			return $this->base->invalid_key();
		}
	}





	
}