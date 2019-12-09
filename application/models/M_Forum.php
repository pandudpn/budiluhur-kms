<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Forum extends CI_Model {

    public function getCategoryGroup($forum){
        $this->db->group_by('jurusan');
        return $this->db->get_where('forum_category', array('akses' => $forum));
    }

    public function getCategory($forum){
        return $this->db->get_where('forum_category', array('akses' => $forum));
    }

    public function CategoryView($forum = FALSE, $slug = FALSE){
        if($slug == FALSE){
            $this->db->join('forum_category a', 'b.id_forkat = a.id_forkat');
            return $this->db->get('forum_subcategory b')->result_array();
        }
        return $this->db->get_where('forum_category', array('akses' => $forum, 'slug_category' => $slug))->row_array();
    }

    public function SubcategoryView($forum = FALSE, $category = FALSE, $subcategory = FALSE){
        $this->db->join('forum_category b', 'a.id_forkat = b.id_forkat', 'left');
        return $this->db->get_where('forum_subcategory a', array('akses' => $forum, 'slug_subcategory' => $subcategory, 'slug_category' => $category))->row_array();
    }

    public function ThreadsView($forum = FALSE, $category = FALSE, $subcategory = FALSE, $threads = FALSE){
        $sql = "SELECT
                a.*, c.*, d.*, e.*, p.*, t1.total
                FROM forum_threads a
                LEFT JOIN forum_subcategory c ON c.id_forsubkat = a.id_forsubkat
                LEFT JOIN forum_category d ON d.id_forkat = c.id_forkat
                LEFT JOIN users e ON a.id_user = e.id_user
                LEFT JOIN akses p ON p.id_akses = e.id_akses
                LEFT JOIN
                (
                    SELECT t.id_user, sum(t.total) total
                    FROM
                    (
                        SELECT a.id_user, count(id_threads) total
                        FROM users a LEFT JOIN forum_threads b ON b.id_user = a.id_user
                        GROUP BY a.id_user
                        UNION ALL
                        SELECT a.id_user, count(id_comments) total
                        FROM users a LEFT JOIN forum_comments c ON c.id_user = a.id_user
                        GROUP BY a.id_user
                    ) t
                    GROUP BY t.id_user
                ) t1
                ON t1.id_user = e.id_user
                WHERE slug_category = '$category' 
                AND slug_subcategory = '$subcategory' 
                AND slug_threads = '$threads'
                AND akses = '$forum'";
        return $this->db->query($sql)->row_array();
    }

    public function getSubKategori($forum, $id){
        $sql = "SELECT
                b.*, c.*, e.*, a.*, d.*, 
                f.total_threads, f.total_post, max(c.ts_threads)
                FROM
                forum_subcategory b 
                LEFT JOIN forum_category a ON b.id_forkat = a.id_forkat
                LEFT JOIN forum_threads c ON b.id_forsubkat = c.id_forsubkat
                LEFT JOIN forum_comments d ON c.id_threads = d.id_threads
                LEFT JOIN users e ON e.id_user = c.id_user
                LEFT JOIN
                (
                    SELECT t.id_forsubkat, sum(t.total_threads) total_threads, sum(t.total_post) total_post
                    FROM
                    (
                        SELECT count(id_threads) total_threads, count(id_threads) total_post, id_forsubkat
                        FROM forum_threads
                        GROUP BY id_forsubkat
                        UNION ALL
                        SELECT NULL total_threads, count(id_comments) total_post, NULL
                        FROM forum_comments
                    ) t
                ) f
                ON f.id_forsubkat = b.id_forsubkat
                LEFT JOIN
                (
                    SELECT max(ts_threads) ts, id_forsubkat FROM forum_threads GROUP BY id_forsubkat
                ) q1
                ON q1.id_forsubkat = b.id_forsubkat AND q1.ts = c.ts_threads
                WHERE b.id_forkat = '$id'
                AND akses = '$forum'
                GROUP BY b.id_forsubkat";
        return $this->db->query($sql);
    }

    public function getThreads($id){
        $sql = "SELECT
                a.*, b.*, c.*, d.*, e.*, p.*, g.username user, count(d.id_comments) as total_comments
                FROM
                forum_subcategory b 
                LEFT JOIN forum_threads c ON b.id_forsubkat = c.id_forsubkat
                LEFT JOIN forum_category a ON b.id_forkat = a.id_forkat
                LEFT JOIN forum_comments d ON c.id_threads = d.id_threads
                LEFT JOIN users e ON e.id_user = c.id_user
                LEFT JOIN akses p ON p.id_akses = e.id_akses
                LEFT JOIN
                (
                    SELECT max(ts_threads) ts, id_forsubkat, id_threads FROM forum_threads GROUP BY id_forsubkat
                ) f
                ON f.id_forsubkat = c.id_forsubkat AND f.ts = c.ts_threads
                LEFT JOIN
                (
                    SELECT max(ts_comments) time_comments, fc.id_user, username, id_comments, id_threads FROM forum_comments fc, users us
                    GROUP BY id_threads
                ) g
                ON g.time_comments = d.ts_comments
                WHERE c.id_forsubkat = '$id'
                GROUP BY c.id_threads";
        return $this->db->query($sql);
    }

    public function getComments($id){
        $sql = "SELECT
                a.*, b.*, c.*, d.*, e.*, p.*, t1.total
                FROM forum_threads a 
                INNER JOIN forum_comments b ON b.id_threads = a.id_threads
                INNER JOIN forum_subcategory c ON c.id_forsubkat = a.id_forsubkat
                INNER JOIN forum_category d ON d.id_forkat = c.id_forkat
                INNER JOIN users e ON b.id_user = e.id_user
                LEFT JOIN akses p ON p.id_akses = e.id_akses
                LEFT JOIN
                (
                    SELECT t.id_user, sum(t.total) total
                    FROM
                    (
                        SELECT a.id_user, count(id_threads) total
                        FROM users a LEFT JOIN forum_threads b ON b.id_user = a.id_user
                        GROUP BY a.id_user
                        UNION ALL
                        SELECT a.id_user, count(id_comments) total
                        FROM users a LEFT JOIN forum_comments c ON c.id_user = a.id_user
                        GROUP BY a.id_user
                    ) t
                    GROUP BY t.id_user
                ) t1
                ON t1.id_user = e.id_user
                WHERE a.id_threads = '$id'
                ORDER BY ts_comments ASC";
        return $this->db->query($sql)->result_array();
    }

    function validasi_login($username, $password)
	{
		return $this->db
			->select('*')
			->where('username', $username)
			->where('password', $password)
			->limit(1)
			->get('users')->row();
    }

    public function AfterLogin(){
        $id = $this->session->userdata('id');
        $sql = "SELECT 
                t.id_user, t.username, t.foto_user, sum(t.total) total, IFNULL(sum(t.likes), 0) likes
                FROM
                (
                SELECT a.id_user, username, foto_user, count(id_threads) total, sum(likes_threads) likes
                FROM users a LEFT JOIN forum_threads b ON b.id_user = a.id_user
                GROUP BY a.id_user
                UNION ALL
                SELECT a.id_user, username, foto_user, count(id_comments) total, sum(likes_comments) likes
                FROM users a LEFT JOIN forum_comments c ON c.id_user = a.id_user
                GROUP BY a.id_user
                ) t
                WHERE t.id_user = '$id'";
        return $this->db->query($sql)->row_array();
    }

    public function insertCategory($nama, $deskripsi, $jurusan, $slug){
        $data = array(
            'nama_category' => $nama,
            'deskripsi'     => $deskripsi,
            'jurusan'       => $jurusan,
            'slug_category' => $slug,
            'akses'         => $this->uri->segment(3)
        );
        return $this->db->insert('forum_category', $data);
    }

    public function insertSubcategory($category, $nama, $deskripsi, $slug){
        $data = array(
            'id_forkat'             => $category,
            'nama_subcategory'      => $nama,
            'deskripsi_subcategory' => $deskripsi,
            'slug_subcategory'      => $slug
        );
        return $this->db->insert('forum_subcategory', $data);
    }

    public function insertThreads($user, $subcategory, $title, $slug, $isi){
        $data = array(
            'id_user'               => $user,
            'id_forsubkat'          => $subcategory,
            'title_threads'         => $title,
            'slug_threads'          => $slug,
            'isi_threads'           => $isi
        );
        return $this->db->insert('forum_threads', $data);
    }

    public function insertComments($user, $threads, $isi){
        $data = array(
            'id_user'       => $user,
            'id_threads'    => $threads,
            'komentar'      => $isi
        );
        return $this->db->insert('forum_comments', $data);
    }

    public function getAllCategory($forum){
        $this->db->order_by('jurusan', 'ASC');
        return $this->db->get_where('forum_category', ['akses' => $forum]);
    }

    public function getAllSubkategori($forum){
        $this->db->join('forum_category a', 'a.id_forkat = b.id_forkat', 'left');
        return $this->db->get_where('forum_subcategory b', ['akses' => $forum]);
    }

}

/* End of file M_Forum.php */
