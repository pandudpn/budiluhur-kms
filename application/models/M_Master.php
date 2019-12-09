<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Master extends CI_Model {

    public function showAllUser($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor,
                id_user,
                nama,
                username,
				b.id_akses,
				nama_akses,
                email,
                foto_user
			FROM 
				users a
			LEFT JOIN
				akses b
			ON
				b.id_akses = a.id_akses, (SELECT @row := 0) r
            WHERE
                id_user != ".$this->session->userdata('id')."
                ";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				`nama` LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR `username` LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR `email` LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR (SELECT CASE tipe_user WHEN 1 THEN 'Administrator' WHEN 2 THEN 'Dosen' ELSE 'Mahasiswa' END) LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor'
		);
		
		$sql .= " ORDER BY id_user DESC";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	public function showAllKategori($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor,
				id_kategori,
				title,
				description
			FROM 
                category, (SELECT @row := 0) r
                ";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " WHERE ( ";    
			$sql .= "
				`title` LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR description LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor'
		);
		
		$sql .= " ORDER BY title ASC";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	public function showAllStaff($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor,
				id_user,
				nama, username, email, password, tipe_user, foto_user
			FROM 
				users, (SELECT @row := 0) r
			WHERE
				tipe_user = 3
                ";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				nama LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR email LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor'
		);
		
		$sql .= " ORDER BY id_user DESC";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	public function showAllAkses($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor,
                id_akses,
                nama_akses,
                hak
			FROM 
                akses, (SELECT @row := 0) r
                ";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				`nama_akses` LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor'
		);
		
		$sql .= " ORDER BY nama_akses ASC";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}
	
	public function insertUser($nama, $username, $password, $akses, $email, $foto){
		$data = array(
			'nama'		=> $nama,
			'username'	=> $username,
			'password'	=> $password,
			'id_akses'	=> $akses,
			'email'		=> $email,
			'foto_user'	=> $foto
		);
		return $this->db->insert('users', $data);
	}

	public function insertAkses($nama, $hak){
		$data = array(
			'nama_akses'	=> $nama,
			'hak'			=> $hak
		);
		return $this->db->insert('akses', $data);
	}

	public function insertKategori($judul, $deskripsi){
		$data = array(
			'title'			=> $judul,
			'description'	=> $deskripsi
		);
		return $this->db->insert('category', $data);
	}

	public function editUser($id){
		return $this->db->get_where('users', ['id_user'	=> $id]);
	}

	public function editAkses($id){
		return $this->db->get_where('akses', ['id_akses' => $id]);
	}

	public function editKategori($id){
		return $this->db->get_where('category', ['id_kategori'	=> $id]);
	}

	public function updateUser($id, $nama, $akses, $email){
		$data = array(
			'nama'		=> $nama,
			'id_akses'	=> $akses,
			'email'		=> $email
		);
		$this->db->where('id_user', $id);
		return $this->db->update('users', $data);
	}

	public function updateAkses($id, $nama, $crud){
		$data = array(
			'nama_akses'	=> $nama,
			'hak'			=> $crud
		);
		$this->db->where('id_akses', $id);
		return $this->db->update('akses', $data);
	}

	public function updateKategori($id, $judul, $deskripsi){
		$data = array(
			'title'			=> $judul,
			'description'	=> $deskripsi
		);
		$this->db->where('id_kategori', $id);
		return $this->db->update('category', $data);
	}

	public function deleteUser($id){
		$this->db->where('id_user', $id);
		return $this->db->delete('users');
	}

	public function deleteKategori($id){
		$this->db->where('id_kategori', $id);
		return $this->db->delete('category');
	}

	public function hapusAkses($id){
		$this->db->where('id_akses', $id);
		return $this->db->delete('akses');
	}

	public function cek_username($username){
		return $this->db->get_where('users', ['username' => $username]);
	}

	public function cek_email($email){
		return $this->db->get_where('users', ['email' => $email]);
	}

	public function getKategori(){
		return $this->db->get('category');
	}

	public function getAkses(){
		return $this->db->get('akses');
	}

	public function cek_nama_akses($nama){
		return $this->db->get_where('akses', ['nama_akses' => $nama]);
	}

}