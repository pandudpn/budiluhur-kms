<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Login extends CI_Model {

    function validasi_login($username, $password)
	{
		return $this->db
			->select('a.*, b.*')
			->join('akses b', 'b.id_akses = a.id_akses', 'left')
			->where('username', $username)
			->where('password', $password)
			->limit(1)
			->get('users a')->row();
	}

	function validasi_login_2($username, $password)
	{
		return $this->db
			->select('a.*, b.*')
			->join('akses b', 'b.id_akses = a.id_akses', 'left')
			->where('username', $username)
			->where('password', $password)
			->limit(1)
			->get('users a')->row_array();
	}
	
	public function updateLogin($id){
		$this->db->where('id_user', $id);
		return $this->db->update('users', ['is_online' => 'online']);
	}

	public function updateLogout($id){
		$this->db->where('id_user', $id);
		return $this->db->update('users', ['is_online' => 'tidak']);
	}
    
    public function getDataLogin(){
        $id = $this->session->userdata('id');

		$this->db->join('akses b', 'b.id_akses = a.id_akses', 'left');
        return $this->db->get_where('users a', array('id_user' => $id))->row();
    }

}