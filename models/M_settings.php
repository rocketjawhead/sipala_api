<?php if(!defined('BASEPATH')) exit('No direct script allowed');

class M_settings extends CI_Model{

	public function __construct() {
        parent::__construct();
        $this->load->model('M_base','base');
    }

	function main_menu($ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$get_main_menu = $this->db->query("SELECT title_menu,url_menu,fa_icon,header_menu,sub_menu FROM main_menu WHERE status = 1 ORDER BY order_numb ASC")->result();

			if (isset($get_main_menu)) {
				return $this->base->success_data($get_main_menu);
			}else{
				return $this->base->failed();
			}
			


		}else{
			return $this->base->invalid_key();
		}


	}


	function reset($ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$get_main_menu = $this->db->query("DELETE FROM activity")->result();

			if (isset($get_main_menu)) {
				return $this->base->success();
			}else{
				return $this->base->failed();
			}
			


		}else{
			return $this->base->invalid_key();
		}


	}

	
}