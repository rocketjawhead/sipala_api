<?php if(!defined('BASEPATH')) exit('No direct script allowed');

class M_skp extends CI_Model{

	public function __construct() {
        parent::__construct();
        $this->load->model('M_base','base');
        $this->date_now = date('Y-m-d');
        $this->year_now = date('Y');
    }

	function get_skp($userid,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$get_data = $this->db->query("SELECT 
										sa.id,
										sa.year_now,
										su.title AS skp_unit,
										sp.title AS skp_planning,
										sc.title AS skp_category,
										si.title AS skp_indikator,
										ss.title AS skp_satuan,
										sa.min_target,
										sa.max_target,
										sa.status
										FROM skp_activity sa 
										INNER JOIN skp_unit su ON sa.id_skp_unit = su.id
										INNER JOIN skp_planning sp ON sa.id_skp_planning = sp.id
										INNER JOIN skp_category sc ON sa.id_skp_category = sc.id
										INNER JOIN skp_indikator si ON sa.id_skp_indikator = si.id
										INNER JOIN skp_satuan ss ON sa.id_skp_satuan = ss.id
										WHERE sa.status = 1 
										AND sa.user_id = '$userid'
										GROUP BY sa.year_now")->result();

			if (isset($get_data)) {
				return $this->base->success_data($get_data);
			}else{
				return $this->base->failed();
			}
		}else{
			return $this->base->invalid_key();
		}
	}


	function insert($year_now,$userid,$id_skp_unit,$id_skp_planning,$id_skp_category,$id_skp_indikator,$id_skp_satuan,$min_target,$max_target,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			

			$data_insert = array(
				'user_id' => $userid,
				'year_now' => $year_now, 
				'id_skp_unit' => $id_skp_unit,
				'id_skp_planning' => $id_skp_planning,
				'id_skp_category' => $id_skp_category,
				'id_skp_indikator' => $id_skp_indikator,
				'id_skp_satuan' => $id_skp_satuan,
				'min_target' => $min_target,
				'max_target' => $max_target
			);

			$insert_data = $this->db->insert('skp_activity',$data_insert);

			if ($insert_data == TRUE) {

				return $this->base->success();

			}else{

				return $this->base->failed();

			}
		}else{
			return $this->base->invalid_key();
		}
	}

	function list_detail_skp($year_now,$userid,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {


			if(strlen($year_now) > 0) {
				$sql = "SELECT 
						sa.id,
						sa.year_now,
						su.title AS skp_unit,
						sp.title AS skp_planning,
						sc.title AS skp_category,
						si.title AS skp_indikator,
						ss.title AS skp_satuan,
						sa.min_target,
						sa.max_target
						FROM skp_activity sa 
						INNER JOIN skp_unit su ON sa.id_skp_unit = su.id
						INNER JOIN skp_planning sp ON sa.id_skp_planning = sp.id
						INNER JOIN skp_category sc ON sa.id_skp_category = sc.id
						INNER JOIN skp_indikator si ON sa.id_skp_indikator = si.id
						INNER JOIN skp_satuan ss ON sa.id_skp_satuan = ss.id
						WHERE sa.status = 1 
						AND sa.user_id = '$userid' 
						AND sa.year_now = '$year_now' ";
			}else{
				$sql = "SELECT 
						sa.id,
						sa.year_now,
						su.title AS skp_unit,
						sp.title AS skp_planning,
						sc.title AS skp_category,
						si.title AS skp_indikator,
						ss.title AS skp_satuan,
						sa.min_target,
						sa.max_target
						FROM skp_activity sa 
						INNER JOIN skp_unit su ON sa.id_skp_unit = su.id
						INNER JOIN skp_planning sp ON sa.id_skp_planning = sp.id
						INNER JOIN skp_category sc ON sa.id_skp_category = sc.id
						INNER JOIN skp_indikator si ON sa.id_skp_indikator = si.id
						INNER JOIN skp_satuan ss ON sa.id_skp_satuan = ss.id
						WHERE sa.status = 1 
						AND sa.user_id = '$userid' 
						AND sa.year_now = '$this->year_now'
						";
			}

			
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