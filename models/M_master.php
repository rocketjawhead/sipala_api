<?php if(!defined('BASEPATH')) exit('No direct script allowed');

class M_master extends CI_Model{

	public function __construct() {
        parent::__construct();
        $this->load->model('M_base','base');
    }

	function get_jabatan($ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$get_data = $this->db->query("SELECT id,title,status FROM jabatan ORDER BY id DESC")->result();

			if (isset($get_data)) {
				return $this->base->success_data($get_data);
			}else{
				return $this->base->failed();
			}
		}else{
			return $this->base->invalid_key();
		}
	}


	function add_jabatan($title,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$data_insert = array(
				'title' => $title 
			);

			$insert_data = $this->db->insert('jabatan',$data_insert);

			if ($insert_data == TRUE) {

				return $this->base->success();

			}else{

				return $this->base->failed();

			}
		}else{
			return $this->base->invalid_key();
		}
	}


	function detail_jabatan($id,$ip_host,$secretkey){
    $checking_key = $this->base->validity_key($secretkey);
    if ($checking_key == TRUE) {

      $sql = "SELECT * FROM jabatan WHERE id = '$id' ";

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


	function update_jabatan($id,$title,$status,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$update_data = $this->db->query("UPDATE jabatan SET title = '$title',status = '$status' WHERE id = '$id' ");

			if ($update_data == TRUE) {

				return $this->base->success();

			}else{

				return $this->base->failed();
				
			}
		}else{
			return $this->base->invalid_key();
		}
	}


	function delete_jabatan($id,$title,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$update_data = $this->db->query("UPDATE jabatan SET status = '0' WHERE id = '$id' ");

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

	function get_bagian($ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$get_data = $this->db->query("SELECT id,title,status FROM bagian ORDER BY id DESC")->result();

			if (isset($get_data)) {
				return $this->base->success_data($get_data);
			}else{
				return $this->base->failed();
			}
		}else{
			return $this->base->invalid_key();
		}
	}


	function add_bagian($title,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$data_insert = array(
				'title' => $title 
			);

			$insert_data = $this->db->insert('bagian',$data_insert);

			if ($insert_data == TRUE) {

				return $this->base->success();

			}else{

				return $this->base->failed();

			}
		}else{
			return $this->base->invalid_key();
		}
	}


	function detail_bagian($id,$ip_host,$secretkey){
    $checking_key = $this->base->validity_key($secretkey);
    if ($checking_key == TRUE) {

      $sql = "SELECT * FROM bagian WHERE id = '$id' ";

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


	function update_bagian($id,$title,$status,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$update_data = $this->db->query("UPDATE bagian SET title = '$title',status = '$status' WHERE id = '$id' ");

			if ($update_data == TRUE) {

				return $this->base->success();

			}else{

				return $this->base->failed();
				
			}
		}else{
			return $this->base->invalid_key();
		}
	}


	function delete_bagian($id,$title,$ip_host,$secretkey) {
		$checking_key = $this->base->validity_key($secretkey);
		if ($checking_key == TRUE) {
			
			$update_data = $this->db->query("UPDATE bagian SET status = '0' WHERE id = '$id' ");

			if ($update_data == TRUE) {

				return $this->base->success();

			}else{

				return $this->base->failed();
				
			}
		}else{
			return $this->base->invalid_key();
		}
	}

	//unit
	function get_unit($ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $get_data = $this->db->query("SELECT id,title,status FROM unit ORDER BY id DESC")->result();

            if (isset($get_data)) {
                return $this->base->success_data($get_data);
            }else{
                return $this->base->failed();
            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function add_unit($title,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $data_insert = array(
                'title' => $title 
            );

            $insert_data = $this->db->insert('unit',$data_insert);

            if ($insert_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();

            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function detail_unit($id,$ip_host,$secretkey){
    $checking_key = $this->base->validity_key($secretkey);
    if ($checking_key == TRUE) {

      $sql = "SELECT * FROM unit WHERE id = '$id' ";

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


    function update_unit($id,$title,$status,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $update_data = $this->db->query("UPDATE unit SET title = '$title',status = '$status' WHERE id = '$id' ");

            if ($update_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();
                
            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function delete_unit($id,$title,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $update_data = $this->db->query("UPDATE unit SET status = '0' WHERE id = '$id' ");

            if ($update_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();
                
            }
        }else{
            return $this->base->invalid_key();
        }
    }

    //opd
    function get_opd($ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $get_data = $this->db->query("SELECT id,title,longitude,latitude,location_code,status FROM opd ORDER BY id DESC")->result();

            if (isset($get_data)) {
                return $this->base->success_data($get_data);
            }else{
                return $this->base->failed();
            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function add_opd($title,$longitude,$latitude,$location_code,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $data_insert = array(
                'title' => $title,
                'longitude' => $longitude, 
                'latitude' => $latitude,
                'location_code' => $location_code
            );

            $insert_data = $this->db->insert('opd',$data_insert);

            if ($insert_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();

            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function detail_opd($id,$ip_host,$secretkey){
    $checking_key = $this->base->validity_key($secretkey);
    if ($checking_key == TRUE) {

      $sql = "SELECT * FROM opd WHERE id = '$id' ";

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


    function update_opd($id,$title,$longitude,$latitude,$location_code,$status,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $update_data = $this->db->query("UPDATE opd SET 
                title = '$title',
                longitude = '$longitude',
                latitude = '$latitude',
                location_code = '$location_code',
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


    function delete_opd($id,$title,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $update_data = $this->db->query("UPDATE opd SET status = '0' WHERE id = '$id' ");

            if ($update_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();
                
            }
        }else{
            return $this->base->invalid_key();
        }
    }

    //golongan
    function get_golongan($ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $get_data = $this->db->query("SELECT id,title,status FROM golongan ORDER BY id DESC")->result();

            if (isset($get_data)) {
                return $this->base->success_data($get_data);
            }else{
                return $this->base->failed();
            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function add_golongan($title,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $data_insert = array(
                'title' => $title 
            );

            $insert_data = $this->db->insert('golongan',$data_insert);

            if ($insert_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();

            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function detail_golongan($id,$ip_host,$secretkey){
    $checking_key = $this->base->validity_key($secretkey);
    if ($checking_key == TRUE) {

      $sql = "SELECT * FROM golongan WHERE id = '$id' ";

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


    function update_golongan($id,$title,$status,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $update_data = $this->db->query("UPDATE golongan SET title = '$title',status = '$status' WHERE id = '$id' ");

            if ($update_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();
                
            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function delete_golongan($id,$title,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $update_data = $this->db->query("UPDATE golongan SET status = '0' WHERE id = '$id' ");

            if ($update_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();
                
            }
        }else{
            return $this->base->invalid_key();
        }
    }

    //gelar
    function get_gelar($ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $get_data = $this->db->query("SELECT id,title,status FROM gelar ORDER BY id DESC")->result();

            if (isset($get_data)) {
                return $this->base->success_data($get_data);
            }else{
                return $this->base->failed();
            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function add_gelar($title,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $data_insert = array(
                'title' => $title 
            );

            $insert_data = $this->db->insert('gelar',$data_insert);

            if ($insert_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();

            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function detail_gelar($id,$ip_host,$secretkey){
    $checking_key = $this->base->validity_key($secretkey);
    if ($checking_key == TRUE) {

      $sql = "SELECT * FROM gelar WHERE id = '$id' ";

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


    function update_gelar($id,$title,$status,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $update_data = $this->db->query("UPDATE gelar SET title = '$title',status = '$status' WHERE id = '$id' ");

            if ($update_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();
                
            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function delete_gelar($id,$title,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $update_data = $this->db->query("UPDATE gelar SET status = '0' WHERE id = '$id' ");

            if ($update_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();
                
            }
        }else{
            return $this->base->invalid_key();
        }
    }

    //task
    function get_task($userid,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $get_data = $this->db->query("SELECT id,title,status FROM ref_task WHERE user_id = '$userid' ORDER BY id DESC")->result();

            if (isset($get_data)) {
                return $this->base->success_data($get_data);
            }else{
                return $this->base->failed();
            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function add_task($userid,$title,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $data_insert = array(
                'title' => $title,
                'user_id' => $userid 
            );

            $insert_data = $this->db->insert('ref_task',$data_insert);

            if ($insert_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();

            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function detail_task($userid,$id,$ip_host,$secretkey){
    $checking_key = $this->base->validity_key($secretkey);
    if ($checking_key == TRUE) {

      $sql = "SELECT * FROM ref_task WHERE id = '$id' AND user_id = '$userid' ";

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


    function update_task($userid,$id,$title,$status,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $update_data = $this->db->query("UPDATE ref_task SET title = '$title',status = '$status' WHERE id = '$id' AND user_id = '$userid' ");

            if ($update_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();
                
            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function delete_task($userid,$id,$title,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $update_data = $this->db->query("UPDATE ref_task SET status = '0' WHERE id = '$id' AND user_id = '$userid' ");

            if ($update_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();
                
            }
        }else{
            return $this->base->invalid_key();
        }
    }

    //place
    function get_place($userid,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $get_data = $this->db->query("SELECT id,title,status FROM ref_place WHERE user_id = '$userid' ORDER BY id DESC")->result();

            if (isset($get_data)) {
                return $this->base->success_data($get_data);
            }else{
                return $this->base->failed();
            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function add_place($userid,$title,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $data_insert = array(
                'user_id' => $userid,
                'title' => $title 
            );

            $insert_data = $this->db->insert('ref_place',$data_insert);

            if ($insert_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();

            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function detail_place($id,$ip_host,$secretkey){
    $checking_key = $this->base->validity_key($secretkey);
    if ($checking_key == TRUE) {

      $sql = "SELECT * FROM ref_place WHERE id = '$id' ";

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


    function update_place($id,$title,$status,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $update_data = $this->db->query("UPDATE ref_place SET title = '$title',status = '$status' WHERE id = '$id' ");

            if ($update_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();
                
            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function delete_place($id,$title,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $update_data = $this->db->query("UPDATE ref_place SET status = '0' WHERE id = '$id' ");

            if ($update_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();
                
            }
        }else{
            return $this->base->invalid_key();
        }
    }

    //organizer
    function get_organizer($userid,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $get_data = $this->db->query("SELECT id,title,status FROM ref_organizer WHERE user_id = '$userid' ORDER BY id DESC")->result();

            if (isset($get_data)) {
                return $this->base->success_data($get_data);
            }else{
                return $this->base->failed();
            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function add_organizer($userid,$title,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $data_insert = array(
                'user_id' => $userid,
                'title' => $title 
            );

            $insert_data = $this->db->insert('ref_organizer',$data_insert);

            if ($insert_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();

            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function detail_organizer($id,$ip_host,$secretkey){
    $checking_key = $this->base->validity_key($secretkey);
    if ($checking_key == TRUE) {

      $sql = "SELECT * FROM ref_organizer WHERE id = '$id' ";

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


    function update_organizer($id,$title,$status,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $update_data = $this->db->query("UPDATE ref_organizer SET title = '$title',status = '$status' WHERE id = '$id' ");

            if ($update_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();
                
            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function delete_organizer($id,$title,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $update_data = $this->db->query("UPDATE ref_organizer SET status = '0' WHERE id = '$id' ");

            if ($update_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();
                
            }
        }else{
            return $this->base->invalid_key();
        }
    }

    //task work
    function get_taskwork($ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $get_data = $this->db->query("SELECT id,title,status FROM ref_task_work ORDER BY id DESC")->result();

            if (isset($get_data)) {
                return $this->base->success_data($get_data);
            }else{
                return $this->base->failed();
            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function add_taskwork($title,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $data_insert = array(
                'title' => $title 
            );

            $insert_data = $this->db->insert('ref_task_work',$data_insert);

            if ($insert_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();

            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function detail_taskwork($id,$ip_host,$secretkey){
    $checking_key = $this->base->validity_key($secretkey);
    if ($checking_key == TRUE) {

      $sql = "SELECT * FROM ref_task_work WHERE id = '$id' ";

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


    function update_taskwork($id,$title,$status,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $update_data = $this->db->query("UPDATE ref_task_work SET title = '$title',status = '$status' WHERE id = '$id' ");

            if ($update_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();
                
            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function delete_taskwork($id,$title,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $update_data = $this->db->query("UPDATE ref_task_work SET status = '0' WHERE id = '$id' ");

            if ($update_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();
                
            }
        }else{
            return $this->base->invalid_key();
        }
    }

    
    //holiday
    function get_holiday($ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $get_data = $this->db->query("SELECT id,title_day,status,date_day FROM holiday ORDER BY id DESC")->result();

            if (isset($get_data)) {
                return $this->base->success_data($get_data);
            }else{
                return $this->base->failed();
            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function add_holiday($title,$date,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {


            $check_holiday = $this->db->query("SELECT COUNT(date_day) AS qty FROM holiday WHERE date_day = '$date' AND status = 1 ")->row()->qty;

            if ($check_holiday == 1) {
                return $this->base->failed_duplicate();
            }
            
            $data_insert = array(
                'title_day' => $title,
                'date_day' => $date, 
            );

            $insert_data = $this->db->insert('holiday',$data_insert);

            if ($insert_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();

            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function detail_holiday($id,$ip_host,$secretkey){
    $checking_key = $this->base->validity_key($secretkey);
    if ($checking_key == TRUE) {

      $sql = "SELECT * FROM holiday WHERE id = '$id' ";

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


    function update_holiday($id,$title,$date,$status,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {

            $check_holiday = $this->db->query("SELECT COUNT(date_day) AS qty FROM holiday WHERE date_day = '$date' AND status = 1 ")->row()->qty;

            if ($check_holiday == 1) {
                return $this->base->failed_duplicate();
            }
            
            $update_data = $this->db->query("UPDATE holiday SET title_day = '$title',status = '$status',date_day = '$date' WHERE id = '$id' ");

            if ($update_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();
                
            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function delete_holiday($id,$title,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $update_data = $this->db->query("UPDATE holiday SET status = '0' WHERE id = '$id' ");

            if ($update_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();
                
            }
        }else{
            return $this->base->invalid_key();
        }
    }

    //skpunit
    function get_skpunit($userid,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $get_data = $this->db->query("SELECT id,title,status FROM skp_unit ORDER BY id DESC")->result();

            if (isset($get_data)) {
                return $this->base->success_data($get_data);
            }else{
                return $this->base->failed();
            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function add_skpunit($userid,$title,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $data_insert = array(
                'title' => $title 
            );

            $insert_data = $this->db->insert('skp_unit',$data_insert);

            if ($insert_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();

            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function detail_skpunit($id,$ip_host,$secretkey){
    $checking_key = $this->base->validity_key($secretkey);
    if ($checking_key == TRUE) {

      $sql = "SELECT * FROM skp_unit WHERE id = '$id' ";

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


    function update_skpunit($id,$title,$status,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $update_data = $this->db->query("UPDATE skp_unit SET title = '$title',status = '$status' WHERE id = '$id' ");

            if ($update_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();
                
            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function delete_skpunit($id,$title,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $update_data = $this->db->query("UPDATE skp_unit SET status = '0' WHERE id = '$id' ");

            if ($update_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();
                
            }
        }else{
            return $this->base->invalid_key();
        }
    }

    //skpplanning
    function get_skpplanning($userid,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $get_data = $this->db->query("SELECT 
                sp.id,sp.title,sp.status,su.title AS skp_unit
                FROM skp_planning sp 
                INNER JOIN skp_unit su ON sp.id_skp_unit = su.id
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


    function add_skpplanning($userid,$title,$id_skp_unit,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $data_insert = array(
                'title' => $title,
                'id_skp_unit' => $id_skp_unit 
            );

            $insert_data = $this->db->insert('skp_planning',$data_insert);

            if ($insert_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();

            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function detail_skpplanning($id,$ip_host,$secretkey){
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {

          $sql = "SELECT 
                    sp.id,sp.title,sp.status,su.title AS skp_unit,sp.id_skp_unit
                    FROM skp_planning sp 
                    INNER JOIN skp_unit su ON sp.id_skp_unit = su.id
                    WHERE sp.id = '$id' ";

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


    function update_skpplanning($id,$title,$id_skp_unit,$status,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $update_data = $this->db->query("UPDATE skp_planning SET title = '$title',id_skp_unit = '$id_skp_unit',status = '$status' WHERE id = '$id' ");

            if ($update_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();
                
            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function delete_skpplanning($id,$title,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $update_data = $this->db->query("UPDATE skp_planning SET status = '0' WHERE id = '$id' ");

            if ($update_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();
                
            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function get_detail_skpplanning($id,$ip_host,$secretkey){
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {

          $sql = "SELECT 
                sp.id,sp.title,sp.status,su.title AS skp_unit,sp.id_skp_unit
                FROM skp_planning sp 
                INNER JOIN skp_unit su ON sp.id_skp_unit = su.id
                WHERE sp.id_skp_unit = '$id' ";

          $res_sql = $this->db->query($sql)->result();

          return $this->base->success_data($res_sql);
          
          
        }else{
          return $this->base->invalid_key();
        }
    }

    function get_detail_skpcategory($id,$ip_host,$secretkey){
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {

          $sql = "SELECT * FROM skp_category";

          $res_sql = $this->db->query($sql)->result();

          return $this->base->success_data($res_sql);
          
          
        }else{
          return $this->base->invalid_key();
        }
    }

    function get_detail_skpindikator($id,$ip_host,$secretkey){
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {

          $sql = "SELECT * FROM skp_indikator";

          $res_sql = $this->db->query($sql)->result();

          return $this->base->success_data($res_sql);
          
          
        }else{
          return $this->base->invalid_key();
        }
    }

    function get_detail_skpsatuan($id,$ip_host,$secretkey){
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {

          $sql = "SELECT * FROM skp_satuan";

          $res_sql = $this->db->query($sql)->result();

          return $this->base->success_data($res_sql);
          
          
        }else{
          return $this->base->invalid_key();
        }
    }

    //shift
    function get_shift($ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $get_data = $this->db->query("SELECT id,title_shift,start_shift,end_shift,status FROM ref_shift ORDER BY id DESC")->result();

            if (isset($get_data)) {
                return $this->base->success_data($get_data);
            }else{
                return $this->base->failed();
            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function add_shift($title_shift,$start_shift,$end_shift,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $data_insert = array(
                'title_shift' => $title_shift,
                'start_shift' => $start_shift,
                'end_shift' => $end_shift 
            );

            $insert_data = $this->db->insert('ref_shift',$data_insert);

            if ($insert_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();

            }
        }else{
            return $this->base->invalid_key();
        }
    }


    function detail_shift($id,$ip_host,$secretkey){
    $checking_key = $this->base->validity_key($secretkey);
    if ($checking_key == TRUE) {

      $sql = "SELECT * FROM ref_shift WHERE id = '$id' ";

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


    function update_shift($id,$title_shift,$start_shift,$end_shift,$status,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $update_data = $this->db->query("UPDATE ref_shift SET 
                title_shift = '$title_shift',
                start_shift = '$start_shift',
                end_shift = '$end_shift',
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


    function delete_shift($id,$title,$ip_host,$secretkey) {
        $checking_key = $this->base->validity_key($secretkey);
        if ($checking_key == TRUE) {
            
            $update_data = $this->db->query("UPDATE ref_shift SET status = '0' WHERE id = '$id' ");

            if ($update_data == TRUE) {

                return $this->base->success();

            }else{

                return $this->base->failed();
                
            }
        }else{
            return $this->base->invalid_key();
        }
    }





	
}