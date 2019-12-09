<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Media extends CI_Model {

    public function showAllDocument($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor,
                b.id_user,
                b.nama,
                b.username,
                a.id_file, file_nama, file_download,
                description, size
			FROM 
                files a 
            INNER JOIN
                users b ON b.id_user = a.id_user, (SELECT @row := 0) r
                ";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " WHERE ( ";    
			$sql .= "
				`file_nama` LIKE '%".$this->db->escape_like_str($like_value)."%'
                OR `description` LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor'
		);
		
		$sql .= " ORDER BY id_file DESC";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
    }
    
    public function insertDocument($id_user, $category, $file_nama, $file_download, $deskripsi, $size){
        $data = array(
            'id_user'       => $id_user,
            'id_kategori'   => $category,
            'file_nama'     => $file_nama,
            'file_download' => $file_download,
            'description'   => $deskripsi,
            'size'          => $size
        );
        return $this->db->insert('files', $data);
    }

    public function insertVideo($id_user, $kategori, $title, $file, $file_download, $description, $thumbnail, $tipe_file){
        $data = array(
            'id_user'           => $id_user,
            'id_kategori'       => $kategori,
            'title'             => $title,
            'file_name'         => $file,
            'file_download'     => $file_download,
            'description'       => $description,
            'thumbnail'         => $thumbnail,
            'tipe_file'         => $tipe_file
        );
        return $this->db->insert('video', $data);
    }

    public function getFile($id){
        return $this->db->get_where('files', ['id_file' => $id]);
    }

    public function getVideo(){
        $sql = "SELECT
                nama, c.title AS nama_kategori, a.title AS judul,
                file_name, file_download, a.description, tipe_file, thumbnail
                FROM video a INNER JOIN users b
                ON b.id_user = a.id_user
                INNER JOIN category c
                ON c.id_kategori = a.id_kategori
                ORDER BY ts_video DESC";
        return $this->db->query($sql);
    }

}

/* End of file M_Media.php */
