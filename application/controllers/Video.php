<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_login', 'login');
        $this->load->model('m_master', 'master');
        $this->load->model('m_media', 'media');
        $this->load->model('m_chat', 'chat');
        if(!$this->session->userdata('login')){
            redirect(base_url());
        }
        if(strtolower($this->session->userdata('akses')) == 'dosen'){
            show_404();
        }
    }
    
    public function index()
    {
        $data['login']      = $this->login->getDataLogin();
        $data['session_data_user'] = $this->chat->getOnlineUsers();
        $data['judul']      = "Kumpulan Video - Universitas Budi Luhur Knowledge Management Systems";
        $data['video']      = $this->media->getVideo();

        $this->load->view('video/index', $data);
    }

    public function tambah(){
        if(substr($this->session->userdata('hak'), 0, 1) == 'c'){
            if($this->input->post()){
                $status                         = '';
                $pesan                          = '';
    
                $config['upload_path']          = './assets/video';
                $config['allowed_types']        = 'mp4|flv|wmv|mp3|png|mkv';
                $config['encrypt_name']         = TRUE;
                $config['overwrite']            = TRUE;
    
                $this->load->library('upload', $config);
    
                if(!$this->upload->do_upload('video')){
                    $status = 'error';
                    $pesan  = '<font style="color:red;" size="3">'.$this->upload->display_errors('', '').'</font>';
                }else{
                    $id_user    = $this->session->userdata('id');
                    $kategori   = $this->input->post('kategori');
                    $description= $this->input->post('deskripsi');
                    $judul      = $this->input->post('judul');
                    $video      = $this->upload->data();
    
                    $f          = "C:/ffmpeg/bin/ffmpeg";
                    $in         = $video['full_path'];
                    $thumbnail  = $video['raw_name'].".jpg";
    
                    $ins        = $this->media->insertVideo($id_user, $kategori, $judul, $video['orig_name'], $video['file_name'], $description, $thumbnail, $video['file_type']);
    
                    if($ins){
                        $status = "success";
                        $pesan  = '<font style="color:green;" size="3"><i class="mdi mdi-check-outline"></i> Video Baru Berhasil Ditambahkan!</font>';
                        exec("$f -i $in -an -ss 5 -s 320x240 D:/Projects/PHP/budiluhur_kms/assets/video/thumbnail/$thumbnail");
                    }else{
                        unlink($video['full_path']);
                        $status = "error";
                        $pesan  = '<font style="color:red;" size="3"><i class="mdi mdi-close-outline"> Terjadi Kesalahan pada Code atau Query Database, Silahkan Periksa Kembali atau Hubungi <b>Developer</b>.</i></font>';
                    }
                }
                echo json_encode(array(
                    'status'    => $status,
                    'pesan'     => $pesan
                ));
            }else{
                $data['kategori']   = $this->master->getKategori();
                $this->load->view('video/tambah', $data);
            }
        }else{
            show_404();
        }
    }

}

/* End of file Video.php */
