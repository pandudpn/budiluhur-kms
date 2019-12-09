<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Pesan extends CI_Model {

    public function showAllInbox($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
                id_message, nama, subject, isi, date_format(ts_message, '%d %M %Y - %H:%i:%s') tanggal
			FROM 
                message a
            INNER JOIN
                users b
            ON
                b.id_user = a.id_from
            WHERE
                id_to = ".$this->session->userdata('id')."
                ";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				`nama` LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR subject LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR isi LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR date_format(ts_message, '%d %M %Y') LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'id_message'
		);
		
		$sql .= " ORDER BY id_message DESC";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
    }

    public function showAllOutbox($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
                id_message, nama, subject, isi, date_format(ts_message, '%d %M %Y - %h:%i:%s') tanggal
			FROM 
                message a
            INNER JOIN
                users b
            ON
                b.id_user = a.id_to
            WHERE
                id_from = ".$this->session->userdata('id')."
                ";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				`nama` LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR subject LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR isi LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR date_format(ts_message, '%d %M %Y') LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'id_message'
		);
		
		$sql .= " ORDER BY id_message DESC";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
    }

    public function totalPesan(){
        $output = '';
        $query  = $this->db->count_all_results('message');
        $sql    = $query + 1;
        $output = ''.$sql;
        return $output;
    }

    public function cari_nama($key){
        $this->db->like('nama', $key);
        $this->db->or_like('email', $key);
        return $this->db->get('users');
    }

    public function kirimPesan($pesan, $from, $to, $subjek, $isi){
        $data = array(
            'id_message'    => $pesan,
            'id_from'       => $from,
            'id_to'         => $to,
            'subject'       => $subjek,
            'isi'           => $isi
        );
        return $this->db->insert('message', $data);
    }

    public function Attachment($pesan, $file_name, $download, $raw, $ext){
        $data = array(
            'id_message'    => $pesan,
            'file_name'     => $file_name,
            'file_download' => $download,
            'raw_name'      => $raw,
            'extension'     => $ext
        );
        return $this->db->insert('attachments', $data);
    }

    public function getPesanInbox($id){
        $sql = "SELECT
                a.*, nama, username, email, c.*
                FROM message a INNER JOIN users b
                ON b.id_user = a.id_from
                INNER JOIN attachments c
                ON c.id_message = a.id_message
                WHERE a.id_message = '$id'";
        return $this->db->query($sql);
    }

    public function getPesanOutbox($id){
        $sql = "SELECT
                a.*, nama, username, email, c.*
                FROM message a INNER JOIN users b
                ON b.id_user = a.id_to
                INNER JOIN attachments c
                ON c.id_message = a.id_message
                WHERE a.id_message = '$id'";
        return $this->db->query($sql);
    }

    public function cek_id($id){
        return $this->db->get_where('message', ['id_message' => $id]);
    }

    public function getAttachmentInbox($upload, $pesan){
        $sql = "SELECT a.*, b.*
                FROM
                message a LEFT JOIN attachments b
                ON b.id_message = a.id_message
                WHERE a.id_message = '$pesan'
                AND b.id_upload = '$upload'";
        return $this->db->query($sql)->row();
    }

}

/* End of file M_Pesan.php */
