<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends BD_Controller {
    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        //validation jwt
        // // $this->auth();
        //end validatoin jwt
        //header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        $this->load->model('M_master','mt');
    }
	


    //jabatan
    public function listjabatan_post(){
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->get_jabatan($ip_host,$secretkey);
        $this->response($exec);
    }

    public function addjabatan_post(){
        $title = $this->post('title');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->add_jabatan($title,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function detailjabatan_post(){
        $id = $this->post('id');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->detail_jabatan($id,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function updatejabatan_post(){
        $id = $this->post('id');
        $title = $this->post('title');
        $status = $this->post('status');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->update_jabatan($id,$title,$status,$ip_host,$secretkey);
        $this->response($exec);
    }

    //
    public function listunit_post(){
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->get_unit($ip_host,$secretkey);
        $this->response($exec);
    }

    public function addunit_post(){
        $title = $this->post('title');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->add_unit($title,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function detailunit_post(){
        $id = $this->post('id');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->detail_unit($id,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function updateunit_post(){
        $id = $this->post('id');
        $title = $this->post('title');
        $status = $this->post('status');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->update_unit($id,$title,$status,$ip_host,$secretkey);
        $this->response($exec);
    }

    //
    public function listopd_post(){
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->get_opd($ip_host,$secretkey);
        $this->response($exec);
    }

    public function addopd_post(){
        $title = $this->post('title');
        $longitude = $this->post('longitude');
        $latitude = $this->post('latitude');
        $location_code = $this->post('location_code');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->add_opd($title,$longitude,$latitude,$location_code,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function detailopd_post(){
        $id = $this->post('id');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->detail_opd($id,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function updateopd_post(){
        $id = $this->post('id');
        $title = $this->post('title');
        $longitude = $this->post('longitude');
        $latitude = $this->post('latitude');
        $location_code = $this->post('location_code');
        $status = $this->post('status');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->update_opd($id,$title,$longitude,$latitude,$location_code,$status,$ip_host,$secretkey);
        $this->response($exec);
    }
    //
    public function listgolongan_post(){
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->get_golongan($ip_host,$secretkey);
        $this->response($exec);
    }

    public function addgolongan_post(){
        $title = $this->post('title');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->add_golongan($title,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function detailgolongan_post(){
        $id = $this->post('id');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->detail_golongan($id,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function updategolongan_post(){
        $id = $this->post('id');
        $title = $this->post('title');
        $status = $this->post('status');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->update_golongan($id,$title,$status,$ip_host,$secretkey);
        $this->response($exec);
    }
    //
    public function listgelar_post(){
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->get_gelar($ip_host,$secretkey);
        $this->response($exec);
    }

    public function addgelar_post(){
        $title = $this->post('title');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->add_gelar($title,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function detailgelar_post(){
        $id = $this->post('id');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->detail_gelar($id,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function updategelar_post(){
        $id = $this->post('id');
        $title = $this->post('title');
        $status = $this->post('status');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->update_gelar($id,$title,$status,$ip_host,$secretkey);
        $this->response($exec);
    }

    //bagian
    public function listbagian_post(){
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->get_bagian($ip_host,$secretkey);
        $this->response($exec);
    }

    public function addbagian_post(){
        $title = $this->post('title');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->add_bagian($title,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function detailbagian_post(){
        $id = $this->post('id');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->detail_bagian($id,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function updatebagian_post(){
        $id = $this->post('id');
        $title = $this->post('title');
        $status = $this->post('status');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->update_bagian($id,$title,$status,$ip_host,$secretkey);
        $this->response($exec);
    }

    //task
    public function listtask_post(){
        $userid = $this->post('userid');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->get_task($userid,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function addtask_post(){
        $userid = $this->post('userid');
        $title = $this->post('title');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->add_task($userid,$title,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function detailtask_post(){
        $userid = $this->post('userid');
        $id = $this->post('id');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->detail_task($userid,$id,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function updatetask_post(){
        $userid = $this->post('userid');
        $id = $this->post('id');
        $title = $this->post('title');
        $status = $this->post('status');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->update_task($id,$userid,$title,$status,$ip_host,$secretkey);
        $this->response($exec);
    }

    //place
    public function listplace_post(){
        $userid = $this->post('userid');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->get_place($userid,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function addplace_post(){
        $userid = $this->post('userid');
        $title = $this->post('title');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->add_place($userid,$title,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function detailplace_post(){
        $id = $this->post('id');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->detail_place($id,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function updateplace_post(){
        $id = $this->post('id');
        $title = $this->post('title');
        $status = $this->post('status');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->update_place($id,$title,$status,$ip_host,$secretkey);
        $this->response($exec);
    }
    //organizer
    public function listorganizer_post(){
        $userid = $this->post('userid');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->get_organizer($userid,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function addorganizer_post(){
        $userid = $this->post('userid');
        $title = $this->post('title');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->add_organizer($userid,$title,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function detailorganizer_post(){
        $id = $this->post('id');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->detail_organizer($id,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function updateorganizer_post(){
        $id = $this->post('id');
        $title = $this->post('title');
        $status = $this->post('status');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->update_organizer($id,$title,$status,$ip_host,$secretkey);
        $this->response($exec);
    }

    //task work
    public function listtaskwork_post(){
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->get_taskwork($ip_host,$secretkey);
        $this->response($exec);
    }

    public function addtaskwork_post(){
        $title = $this->post('title');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->add_taskwork($title,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function detailtaskwork_post(){
        $id = $this->post('id');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->detail_taskwork($id,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function updatetaskwork_post(){
        $id = $this->post('id');
        $title = $this->post('title');
        $status = $this->post('status');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->update_taskwork($id,$title,$status,$ip_host,$secretkey);
        $this->response($exec);
    }

    //holiday
    public function listholiday_post(){
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->get_holiday($ip_host,$secretkey);
        $this->response($exec);
    }

    public function addholiday_post(){
        $title_day = $this->post('title_day');
        $date_day = $this->post('date_day');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->add_holiday($title_day,$date_day,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function detailholiday_post(){
        $id = $this->post('id');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->detail_holiday($id,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function updateholiday_post(){
        $id = $this->post('id');
        $title_day = $this->post('title_day');
        $date_day = $this->post('date_day');
        $status = $this->post('status');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->update_holiday($id,$title_day,$date_day,$status,$ip_host,$secretkey);
        $this->response($exec);
    }

    //skpunit
    public function listskpunit_post(){
        $userid = $this->post('userid');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->get_skpunit($userid,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function addskpunit_post(){
        $userid = $this->post('userid');
        $title = $this->post('title');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->add_skpunit($userid,$title,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function detailskpunit_post(){
        $id = $this->post('id');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->detail_skpunit($id,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function updateskpunit_post(){
        $id = $this->post('id');
        $title = $this->post('title');
        $status = $this->post('status');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->update_skpunit($id,$title,$status,$ip_host,$secretkey);
        $this->response($exec);
    }

    //skpplanning
    public function listskpplanning_post(){
        $userid = $this->post('userid');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->get_skpplanning($userid,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function addskpplanning_post(){
        $userid = $this->post('userid');
        $title = $this->post('title');
        $id_skp_unit = $this->post('id_skp_unit');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->add_skpplanning($userid,$title,$id_skp_unit,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function detailskpplanning_post(){
        $id = $this->post('id');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->detail_skpplanning($id,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function updateskpplanning_post(){
        $id = $this->post('id');
        $title = $this->post('title');
        $id_skp_unit = $this->post('id_skp_unit');
        $status = $this->post('status');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->update_skpplanning($id,$title,$id_skp_unit,$status,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function getskpplanning_post(){
        $id = $this->post('id');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->get_detail_skpplanning($id,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function getskpcategory_post(){
        $id = $this->post('id');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->get_detail_skpcategory($id,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function getskpindikator_post(){
        $id = $this->post('id');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->get_detail_skpindikator($id,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function getskpsatuan_post(){
        $id = $this->post('id');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->get_detail_skpsatuan($id,$ip_host,$secretkey);
        $this->response($exec);
    }

    //shift
    public function listshift_post(){
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->get_shift($ip_host,$secretkey);
        $this->response($exec);
    }

    public function addshift_post(){
        $title_shift = $this->post('title_shift');
        $start_shift = $this->post('start_shift');
        $end_shift = $this->post('end_shift');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->add_shift($title_shift,$start_shift,$end_shift,$ip_host,$secretkey);
        $this->response($exec);
    }


    public function detailshift_post(){
        $id = $this->post('id');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->detail_shift($id,$ip_host,$secretkey);
        $this->response($exec);
    }

    public function updateshift_post(){
        $id = $this->post('id');
        $title_shift = $this->post('title_shift');
        $start_shift = $this->post('start_shift');
        $end_shift = $this->post('end_shift');
        $status = $this->post('status');
        $ip_host = $this->post('ip_host');
        $secretkey = $this->post('secretkey');

        $exec = $this->mt->update_shift($id,$title_shift,$start_shift,$end_shift,$status,$ip_host,$secretkey);
        $this->response($exec);
    }

}
