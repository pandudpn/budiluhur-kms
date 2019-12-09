<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('download');
        $this->load->model('m_login', 'login');
        $this->load->model('m_media', 'media');
        $this->load->model('m_chat', 'chat');
        $this->load->model('m_master', 'master');
        if(!$this->session->userdata('login')){
            redirect(base_url());
        }
        if(strpos($this->session->userdata('hak'), 'r') == false){
            if(substr($this->session->userdata('hak'), 0, 1) != 'r'){
                show_404();
            }
        }
        if(strtolower($this->session->userdata('akses')) == 'dosen'){
            show_404();
        }
    }
    
    public function index()
    {
        $data['login']  = $this->login->getDataLogin();
        $data['session_data_user'] = $this->chat->getOnlineUsers();
        $data['judul']  = "Dokumen - dokumen Universitas Budi Luhur Knowledge Management Systems";
        $this->load->view('dokumen/index', $data);
    }

    public function showAllData(){
        $requestData	= $_REQUEST;
		$fetch			= $this->media->showAllDocument($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

            $nestedData[]	= "<center>".$row['nomor']."</center>";
            if(strlen($row['file_nama']) > 20){
                $nestedData[]   = "<center title='".$row['file_nama']."'><a href='".site_url('document/download/'.$row['id_file'].'/'.$row['file_download'])."' id='fileDownload'> ".substr($row['file_nama'], 0, 20)."...</a></center>";
            }else{
                $nestedData[]   = "<center><a href='".site_url('document/download/'.$row['id_file'].'/'.$row['file_download'])."' id='fileDownload'> ".$row['file_nama']."</a></center>";
            }
            if(strlen($row['description']) > 40){
                $nestedData[]	= "<center title='".$row['description']."'>".substr($row['description'], 0, 40)."...</center>";
            }else{
                $nestedData[]	= "<center>".$row['description']."</center>";
            }
            $nestedData[]	= "<center>".$row['size']." KB</center>";

			$data[] = $nestedData;
		}

		$json_data = array(
			"draw"            => intval( $requestData['draw'] ),  
			"recordsTotal"    => intval( $totalData ),  
			"recordsFiltered" => intval( $totalFiltered ), 
			"data"            => $data
			);

		echo json_encode($json_data);
    }

    public function tambah(){
        if(substr($this->session->userdata('hak'), 0, 1) == 'c'){
            if($this->input->post()){
                $status                         = '';
                $pesan                          = '';
    
                $config['upload_path']          = './assets/documents';
                $config['allowed_types']        = 'rar|zip|pdf|doc|docx|ppt|pptx|xls|xlsx|txt';
                $config['max_size']             = 1024 * 30;
                $config['encrypt_name']         = TRUE;
                $config['overwrite']            = TRUE;
    
                $this->load->library('upload', $config);
    
                if(!$this->upload->do_upload('files')){
                    $status = 'error';
                    $pesan  = '<font style="color:red;" size="3">'.$this->upload->display_errors('', '').'</font>';
                }else{
                    $kategori   = $this->input->post('kategori');
                    $deskripsi  = $this->input->post('deskripsi');
                    $id_user    = $this->session->userdata('id');
                    $file       = $this->upload->data();
    
                    $ins        = $this->media->insertDocument($id_user, $kategori, $file['orig_name'], $file['file_name'], $deskripsi, $file['file_size']);
                    if($ins){
                        $status = 'success';
                        $pesan  = '<font style="color:green;" size="2"><b><i class="mdi mdi-check-outline"></i> Berhasil</b></font>';
                    }else{
                        unlink($file['full_path']);
                        $status = 'error';
                        $pesan  = '<font style="color:red;" size="3"><i>Terjadi Kesalahan pada Code atau Query Database. Silahkan Periksa Kembali atau Hubungi <b>Developer</b>.</i></font>';
                    }
                    @unlink($_FILES['files']);
                    echo json_encode(array(
                        'status'    => $status,
                        'pesan'     => $pesan
                    ));
                }
            }else{
                $data['kategori']   = $this->master->getKategori()->result();
                $this->load->view('dokumen/tambah', $data);
            }
        }else{
            show_404();
        }
    }

    public function download($id, $download){
        $file   = $this->media->getFile($id)->row();
        $path   = './assets/documents/'.$download;
        force_download("$file->file_nama", file_get_contents($path),);
    }

}