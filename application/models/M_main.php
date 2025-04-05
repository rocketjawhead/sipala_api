<?php if(!defined('BASEPATH')) exit('No direct script allowed');

class M_main extends CI_Model{

	function get_user($email) {
		// return $this->db->get_where('users',$q);
		// return $this->db->query("SELECT id,email,status,pin,password FROM users WHERE nip = '$email' ")->row();
			$this->db->select("id,email,nip,status,pin,password,unique_id,qr_url");
		  	$this->db->from("users");
	  		$this->db->where('nip', $email);
	  		return $query = $this->db->get();
	}



	function get_user_admin($email) {
		// return $this->db->get_where('users',$q);
		// return $this->db->query("SELECT id,email,status,pin,password FROM users WHERE nip = '$email' ")->row();
			$this->db->select("id,email,nip,status,pin,password");
		  	$this->db->from("sysadmin");
	  		$this->db->where('nip', $email);
	  		return $query = $this->db->get();
	}

	
}