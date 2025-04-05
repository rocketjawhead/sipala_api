<?php if(!defined('BASEPATH')) exit('No direct script allowed');

class M_apperance extends CI_Model{

	public function __construct() {
        parent::__construct();
        $this->load->model('M_base','base');
        $this->date_now = date('Y-m-d');

        $this->base_url = $this->config->item('base_url');
    }

    function list_data($ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$data_apperance = $this->db->query("SELECT * FROM appearance")->result();

			return $this->base->success_data($data_apperance);
			

		}else{
			return $this->base->invalid_key();
		}
	}

	function detail($type_code,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$data_apperance = $this->db->query("SELECT * FROM appearance WHERE type_code = '$type_code' ")->row();

			return $this->base->success_data($data_apperance);
			

		}else{
			return $this->base->invalid_key();
		}
	}

	//change picture
	function update($id,$type_code,$type_name,$height,$width,$imageurl,$userid,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			if (strlen($imageurl) > 0) {
				//data
		        $imagedata = base64_decode($imageurl);
		        $im = imagecreatefromstring($imagedata);
		        if ($im !== false) {
		            $filename =  "assets/img/profile/".md5(date('ymdhis')).'.png';
		            $filepath = FCPATH.$filename;
		            imagepng($im,$filepath,9);
		            imagedestroy($im);
		            $url_path = $this->base_url.$filename;

		            $update_picture = $this->db->query("UPDATE appearance SET 
		            	type_code = '$type_code',
		            	type_name = '$type_name',
		            	height = '$height',
		            	width = '$width',
		            	imageurl = '$url_path' 
		            	WHERE id = '$id' ");

		            if ($update_picture == TRUE) {
		            	return $this->base->success();
		            }else{
		            	return $this->base->failed();
		            }

		            
		        }
		        else {
		            return $this->base->failed();
		        }
			}else{
				$update_picture = $this->db->query("UPDATE appearance SET 
	            	type_code = '$type_code',
	            	type_name = '$type_name',
	            	height = '$height',
	            	width = '$width' 
	            	WHERE id = '$id' ");

	            if ($update_picture == TRUE) {
	            	return $this->base->success();
	            }else{
	            	return $this->base->failed();
	            }
			}
			
			

		}else{
			return $this->base->invalid_key();
		}
	}

	
}