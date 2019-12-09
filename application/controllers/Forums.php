<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forums extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_login', 'login');
        $this->load->model('m_master', 'master');
        $this->load->model('m_forum', 'forum');
        $this->load->model('m_chat', 'chat');
        if(!$this->session->userdata('login')){
            redirect(base_url());
        }
    }
    
    public function index()
    {
        $data['login']      = $this->forum->AfterLogin();
        $data['session_data_user'] = $this->chat->getOnlineUsers();
        $data['judul']      = "Forums - Knowledge Management Systemns";
        $this->load->view('forum/before', $data);
    }

    public function view($forum){
        if($forum == 'dosen'){
            if($this->session->userdata('akses') == 'Administrator' || $this->session->userdata('akses') == 'Dosen' || $this->session->userdata('akses') == 'Dekan' || $this->session->userdata('akses') == 'Prodi' || $this->session->userdata('akses') == 'Direktur'){
                $data['login']      = $this->forum->AfterLogin();
                $data['kategori']   = $this->forum->getCategory($forum)->result();
                $data['k']          = $this->forum->getCategoryGroup($forum)->result();
                $data['judul']      = "Forums ".ucfirst($forum)." - Knowledge Management Systemns";
                $data['f']          = $forum;
                $this->load->view('forum/index', $data);
            }else{
                show_404();
            }
        }elseif($forum == 'dekan'){
            if($this->session->userdata('akses') == 'Administrator' || $this->session->userdata('akses') == 'Dekan' || $this->session->userdata('akses') == 'Direktur'){
                $data['login']      = $this->forum->AfterLogin();
                $data['kategori']   = $this->forum->getCategory($forum)->result();
                $data['k']          = $this->forum->getCategoryGroup($forum)->result();
                $data['judul']      = "Forums ".ucfirst($forum)." - Knowledge Management Systemns";
                $data['f']          = $forum;
                $this->load->view('forum/index', $data);
            }else{
                show_404();
            }
        }elseif($forum == 'prodi'){
            if($this->session->userdata('akses') == 'Administrator' || $this->session->userdata('akses') == 'Prodi' || $this->session->userdata('akses') == 'Dekan' || $this->session->userdata('akses') == 'Direktur'){
                $data['login']      = $this->forum->AfterLogin();
                $data['kategori']   = $this->forum->getCategory($forum)->result();
                $data['k']          = $this->forum->getCategoryGroup($forum)->result();
                $data['judul']      = "Forums ".ucfirst($forum)." - Knowledge Management Systemns";
                $data['f']          = $forum;
                $this->load->view('forum/index', $data);
            }else{
                show_404();
            }
        }elseif($forum == 'direktur'){
            if($this->session->userdata('akses') == 'Administrator' || $this->session->userdata('akses') == 'Direktur'){
                $data['login']      = $this->forum->AfterLogin();
                $data['kategori']   = $this->forum->getCategory($forum)->result();
                $data['k']          = $this->forum->getCategoryGroup($forum)->result();
                $data['judul']      = "Forums ".ucfirst($forum)." - Knowledge Management Systemns";
                $data['f']          = $forum;
                $this->load->view('forum/index', $data);
            }else{
                show_404();
            }
        }
    }

    public function category($forum, $slug){
        if(!empty($slug)){
            $data['login']      = $this->forum->AfterLogin();
            $data['kategori']   = $this->forum->CategoryView($forum, $slug);
            $data['judul']      = $data['kategori']['nama_category']." - Forums";
            $data['subkategori']= $this->forum->getSubkategori($forum, $data['kategori']['id_forkat'])->result_array();
            $data['f']          = $forum;
            $this->load->view('forum/kategori', $data);
        }else{
            show_404();
        }
    }

    public function subcategory($forum, $category, $subcategory){
        if(!empty($category) && !empty($subcategory)){
            $data['login']      = $this->forum->AfterLogin();
            $data['subkategori']    = $this->forum->SubcategoryView($forum, $category, $subcategory);
            $data['judul']          = $data['subkategori']['nama_subcategory']." - Forums";
            $data['threads']        = $this->forum->getThreads($data['subkategori']['id_forsubkat'])->result_array();
            $data['f']          = $forum;
            $this->load->view('forum/subkategori', $data);
        }else{
            show_404();
        }
    }

    public function threads($forum, $category, $subcategory, $threads){
        if(!empty($category) && !empty($subcategory) && !empty($threads)){
            $data['login']      = $this->forum->AfterLogin();
            $data['threads']    = $this->forum->ThreadsView($forum, $category, $subcategory, $threads);
            $data['judul']      = $data['threads']['title_threads']." - Forums";
            $data['comments']   = $this->forum->getComments($data['threads']['id_threads']);
            $data['f']          = $forum;
            $this->load->view('forum/post', $data);
        }else{
            show_404();
        }
    }

    public function tambah_category($forum){
        if($this->input->post()){
            $nama       = $this->input->post('nama');
            $deskripsi  = $this->input->post('deskripsi');
            $jurusan    = $this->input->post('jurusan');
            $slug       = url_title(strtolower($nama));

            $ins        = $this->forum->insertCategory($nama, $deskripsi, $jurusan, $slug);

            if($ins){
                $json['status'] = "success";
                $json['pesan']  = "<font style='color:green;' size='3'><i class='mdi mdi-check-outline'></i> Berhasil</font>";
            }else{
                $json['status'] = "error";
                $json['pesan']  = "<font style='color:red;' size='3'><i class='mdi mdi-close-outline'></i> Terjadi kesalahan dalam <i><b>Code</b></i> atau <i><b>Query</b></i>. Silahkan periksa kembali atau Hubungi <i><b>Developer</b></i>.</font>";
            }
            echo json_encode($json);
        }else{
            $data['f']  = $forum;
            $this->load->view('forum/tambah_category', $data);
        }
    }

    public function tambah_subcategory($forum){
        if($this->input->post()){
            $category   = $this->input->post('kategori');
            $nama       = $this->input->post('nama');
            $deskripsi  = $this->input->post('deskripsi');
            $slug       = url_title(strtolower($nama));

            $ins        = $this->forum->insertSubcategory($category, $nama, $deskripsi, $slug);

            if($ins){
                $json['status'] = "success";
                $json['pesan']  = "<font style='color:green;' size='3'><i class='mdi mdi-check-outline'></i> Berhasil</font>";
            }else{
                $json['status'] = "error";
                $json['pesan']  = "<font style='color:red;' size='3'><i class='mdi mdi-close-outline'></i> Terjadi kesalahan dalam <i><b>Code</b></i> atau <i><b>Query</b></i>. Silahkan periksa kembali atau Hubungi <i><b>Developer</b></i>.</font>";
            }
            echo json_encode($json);
        }else{
            $data['kategori']   = $this->forum->getAllCategory($forum)->result();
            $data['f']          = $forum;
            $this->load->view('forum/tambah_subcategory', $data);
        }
    }

    public function tambah_threads($forum){
        if($this->input->post()){
            $user       = $this->session->userdata('id');
            $subcategory = $this->input->post('subcategory');
            $title       = $this->input->post('title');
            $slug       = url_title(strtolower($title));
            $isi  = $this->input->post('isi');

            $ins        = $this->forum->insertThreads($user, $subcategory, $title, $slug, $isi);

            if($ins){
                redirect('forums');
            }else{
                redirect('forums');
            }
        }else{
            $data['subkategori']    = $this->forum->getAllSubkategori($forum)->result();
            $data['judul']          = "Topik Baru - Forums";
            $data['login']          = $this->forum->AfterLogin();
            $data['f']              = $forum;
            $this->load->view('forum/tambah_threads', $data);
        }
    }

    public function tambah_comments(){
        if($this->input->post()){
            $user       = $this->session->userdata('id');
            $threads    = $this->input->post('id_threads');
            $isi        = $this->input->post('isi');

            $ins        = $this->forum->insertComments($user, $threads, $isi);

            if($ins){
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

}