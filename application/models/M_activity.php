<?php if(!defined('BASEPATH')) exit('No direct script allowed');

class M_activity extends CI_Model{

	public function __construct() {
        parent::__construct();
        $this->load->model('M_base','base');
        $this->date_now = date('Y-m-d');
    }

	function get_activity($user_id,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$get_data = $this->db->query("SELECT 
										act.id,
										act.user_id,
										act.act_date,
										act.start_time,
										act.end_time,
										act.act_detail,
										HOUR(TIMEDIFF(act.end_time, act.start_time)) AS diff_hour,
										MINUTE(TIMEDIFF(act.end_time, act.start_time)) AS diff_minute,
										act.place AS place,
										-- rt.title AS task,
										act.pj AS organizer,
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
										) AS status_badged,
										act.imageurl
										FROM activity act 
										-- INNER JOIN ref_place pl ON act.place = pl.id 
										-- INNER JOIN ref_task rt ON act.task = rt.id 
										-- INNER JOIN ref_organizer og ON act.pj = og.id 
										WHERE act.user_id = '$user_id' 
										AND act.act_id IN (0,1,5)
										ORDER BY id DESC")->result();

			if (isset($get_data)) {
				return $this->base->success_data($get_data);
			}else{
				return $this->base->failed();
			}
		}else{
			return $this->base->invalid_key();
		}
	}


	function add_activity($imageurl,$user_id,$act_date,$start_time,$end_time,$act_detail,$place,$pj,$remark,$latitude,$longitude,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$get_url_pic = $this->base->upload_pic($imageurl);

			if ($get_url_pic == false) {
				$val_imageurl = null;
			}else{
				$val_imageurl = $get_url_pic;
			}
			

			$check_holiday = $this->db->query("SELECT COUNT(date_day) AS qty FROM holiday WHERE date_day = '$act_date' AND status = 1 ")->row()->qty;

			if ($check_holiday == 1) {
				return $this->base->failed_holiday();
			}

			//absent before activity

			$check_absent = $this->db->query("SELECT COUNT(act.id) AS qty 
				FROM activity act 
				WHERE act.user_id = '$user_id' 
				AND act.act_id = '1' 
				AND act.act_date = '$this->date_now' 
				")->row()->qty;


			if ($check_absent == 0) {
				return $this->base->failed_activity();
			}

			//end absent before activity


			$data_insert = array(
				'user_id' => $user_id,
				'act_date' => $act_date, 
				'start_time' => $start_time,
				'end_time' => $end_time,
				'act_detail' => $act_detail,
				'place' => $place,
				'pj' => $pj,
				'task' => $remark,
				'latitude' => $latitude,
				'longitude' => $longitude,
				'imageurl' => $val_imageurl
			);

			$insert_data = $this->db->insert('activity',$data_insert);

			if ($insert_data == TRUE) {

				return $this->base->success();

			}else{

				return $this->base->failed();

			}
		}else{
			return $this->base->invalid_key();
		}
	}


	function detail_activity($id,$ip_host,$secretkey){
    $checking_key = $this->base->validity_key($secretkey);
    if ($checking_key == TRUE) {

      $sql = "SELECT 
			act.id,
			act.act_date,
			act.user_id,
			act.act_date,
			act.start_time,
			act.end_time,
			act.act_detail,
			HOUR(TIMEDIFF(act.end_time, act.start_time)) AS diff_hour,
			MINUTE(TIMEDIFF(act.end_time, act.start_time)) AS diff_minute,
			act.place AS place,
			act.pj AS organizer,
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
			-- INNER JOIN ref_place pl ON act.place = pl.id 
			-- INNER JOIN ref_task rt ON act.task = rt.id 
			-- INNER JOIN ref_organizer og ON act.pj = og.id 
			WHERE act.id = '$id'
			ORDER BY id DESC";

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


	function update_activity($id,$act_date,$start_time,$end_time,$act_detail,$place,$pj,$remark,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {

			$data_insert = array(
				'act_date' => $act_date, 
				'start_time' => $start_time,
				'end_time' => $end_time,
				'act_detail' => $act_detail,
				'place' => $place,
				'pj' => $pj,
				'task' => $remark
			);
			$this->db->where('id',$id);
			$update_data = $this->db->update('activity',$data_insert);

			if ($update_data == TRUE) {

				return $this->base->success();

			}else{

				return $this->base->failed();
				
			}
		}else{
			return $this->base->invalid_key();
		}
	}


	function delete_activity($id,$title,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$update_data = $this->db->query("UPDATE activity SET status = '0' WHERE id = '$id' ");

			if ($update_data == TRUE) {

				return $this->base->success();

			}else{

				return $this->base->failed();
				
			}
		}else{
			return $this->base->invalid_key();
		}
	}



	function top_activity($user_id,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$get_data = $this->db->query("SELECT 
										COUNT(act.user_id) AS qty,
										usr.fullname,
										usr.nip
										FROM activity act 
										INNER JOIN users usr ON act.user_id = usr.unique_id
										WHERE act.start_time < '08:00:00' 
                                        AND act.act_id = 1
										GROUP BY act.user_id
										ORDER BY qty DESC 
										LIMIT 10
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


	function history_activity($user_id,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$get_data = $this->db->query("SELECT 
										act.act_date,
										act.start_time,
										usr.fullname,
										usr.nip,
										rf.title AS status_desc
										FROM activity act 
										LEFT JOIN users usr ON act.user_id = usr.unique_id 
										LEFT JOIN ref_task rf ON act.act_id = rf.id
										ORDER BY act.id DESC 
										LIMIT 50
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


	//
	function do_activity($imageurl,$user_id,$type_act,$start_date,$end_date,$desc_activity,$latitude,$longitude,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$type_desc = $this->db->query("SELECT title FROM ref_task rt WHERE rt.id = '$type_act' ")->row()->title;

			$date_now = date("Y-m-d");
			$time_now = date("H:i:s");
			$unique_numb = rand(10000,99999);

			$get_url_pic = $this->base->upload_pic($imageurl);

			if ($get_url_pic == false) {
				$val_imageurl = null;
			}else{
				$val_imageurl = $get_url_pic;

			}

			
			if ($type_act == '2' || $type_act == '3' || $type_act == '4') {
				
				
				//update leave date
				// echo $val_imageurl;
				// die();
				$update_date = $this->db->query("UPDATE users SET start_leave = '$start_date',end_leave = '$end_date' WHERE unique_id = '$user_id' ");

				//sick leave and dinas
				$start = new DateTime($start_date);
				$end = new DateTime($end_date);
				$oneday = new DateInterval("P1D");

				$days = array();
				
				foreach(new DatePeriod($start, $oneday, $end->add($oneday)) as $day) {
				    $day_num = $day->format("N"); 
				    if($day_num < 6) { 
				        $days[] = $day->format("Y-m-d");
				    } 
				}    
			// 	echo "string";
			// die();
				foreach ($days as $value) {
				  	// echo "$value <br>";
				  	$data_insert = array(
						'user_id' => $user_id,
						'unique_numb' => $unique_numb,
						'act_date' => $value,
						'start_time' => $time_now,
						'end_time' => $time_now,
						'act_id' => $type_act,
						'act_detail' => $desc_activity,
						'place' => 0,
						'pj' => 0, 
						'task' => 0,
						'status' => '1',
						'imageurl' => $val_imageurl,
						'latitude' => $latitude,
						'longitude' => $longitude
					);
					$exec_insert = $this->db->insert('activity',$data_insert);
					
				}

			}else{
				$data_insert = array(
					'user_id' => $user_id,
					'unique_numb' => $unique_numb,
					'act_date' => $date_now,
					'start_time' => $time_now,
					'end_time' => $time_now,
					'act_id' => $type_act,
					'act_detail' => $desc_activity,
					'place' => 0,
					'pj' => 0, 
					'task' => 0,
					'status' => '1',
					'imageurl' => $val_imageurl,
					'latitude' => $latitude,
					'longitude' => $longitude
				);
				$exec_insert = $this->db->insert('activity',$data_insert);

			}

			
			

			$date_now = $this->date_now;

			//absen
			if ($type_act == 1) {
				$update_date = $this->db->query("UPDATE users SET status_act = '$type_act',login_date = '$time_now',logout_date = NULL, status_date = '$date_now' WHERE unique_id = '$user_id' ");
			}elseif ($type_act == 5) {
				$update_date = $this->db->query("UPDATE users SET status_act = '$type_act',logout_date = '$time_now',status_date = '$date_now' WHERE unique_id = '$user_id' ");
			}else{
				$update_date = $this->db->query("UPDATE users SET status_act = '$type_act',logout_date = null,login_date = null,status_date = '$date_now' WHERE unique_id = '$user_id' ");
			}
			

			return $this->base->success();
			
			
		}else{
			return $this->base->invalid_key();
		}
	}


	function list_absent($user_id,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$get_data = $this->db->query("SELECT 
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
					WHERE act.act_date >= '$this->date_now'
					AND act.act_id = 1
					ORDER BY act.id DESC")->result();

			if (isset($get_data)) {
				return $this->base->success_data($get_data);
			}else{
				return $this->base->failed();
			}
		}else{
			return $this->base->invalid_key();
		}
	}


	function get_activity_limit($user_id,$limit,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			

			if ($limit > 0) {
				$get_data = $this->db->query("SELECT 
										act.id,
										act.user_id,
										act.act_date,
										act.start_time,
										act.end_time,
										act.act_detail,
										HOUR(TIMEDIFF(act.end_time, act.start_time)) AS diff_hour,
										MINUTE(TIMEDIFF(act.end_time, act.start_time)) AS diff_minute,
										act.place AS place,
										-- rt.title AS task,
										act.pj AS organizer,
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
										WHERE act.user_id = '$user_id' 
										AND act.act_id IN (0,1,5)
										ORDER BY id DESC
										LIMIT ".$limit)->result();
			}else{
				$get_data = $this->db->query("SELECT 
										act.id,
										act.user_id,
										act.act_date,
										act.start_time,
										act.end_time,
										act.act_detail,
										HOUR(TIMEDIFF(act.end_time, act.start_time)) AS diff_hour,
										MINUTE(TIMEDIFF(act.end_time, act.start_time)) AS diff_minute,
										act.place AS place,
										-- rt.title AS task,
										act.pj AS organizer,
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
										WHERE act.user_id = '$user_id' 
										AND act.act_id IN (0,1,5)
										ORDER BY id DESC")->result();
			}


			

			if (isset($get_data)) {
				return $this->base->success_data($get_data);
			}else{
				return $this->base->failed();
			}
		}else{
			return $this->base->invalid_key();
		}
	}


	function history_activity_absent($user_id,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$get_data = $this->db->query("SELECT 
										usr.unique_id AS userid,
										act.act_date,
										act.start_time,
										usr.fullname,
										usr.nip
										FROM activity act 
										LEFT JOIN users usr ON act.user_id = usr.unique_id 
										LEFT JOIN ref_task rf ON act.act_id = rf.id
										WHERE act.act_id = 1 
										AND act.act_date = '$this->date_now'
										ORDER BY act.id DESC 
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





	
}