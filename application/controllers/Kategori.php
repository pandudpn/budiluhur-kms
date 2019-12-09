<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {
    
    public $hak;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_login', 'login');
        $this->load->model('m_master', 'master');
        $this->load->model('m_chat', 'chat');
        $this->hak  = $this->login->getDataLogin();
        if(!$this->session->userdata('login')){
            redirect(base_url());
        }
        if(strpos($this->hak->hak, 'r') == false){
            if(substr($this->hak->hak, 0, 1) != 'r'){
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
        $data['judul']  = "Data Kategori - Universitas Budi Luhur Knowledge Management Systems";
        $this->load->view('kategori/index', $data);
    }

    public function showAllData(){
        $requestData	= $_REQUEST;
		$fetch			= $this->master->showAllKategori($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

            $nestedData[]	= "<center>".$row['nomor']."</center>";
			$nestedData[]	= "<center>".$row['title']."</center>";
            if(strlen($row['description']) > 40){
                $nestedData[]	= "<center title='".$row['description']."'>".substr($row['description'], 0, 40)." ...</center>";
            }else{
                $nestedData[]	= "<center>".$row['description']."</center>";
            }
            if(substr($this->hak->hak, 0, 1) == 'u' || strpos($this->hak->hak, 'u')){
                $nestedData[]   = "<center><a href='".site_url('kategori/edit/'.$row['id_kategori'])."' id='EditKategori'><i class='mdi mdi-pencil-outline'></i> Edit</a></center>";
            }
            if(substr($this->hak->hak, 0, 1) == 'd' || strpos($this->hak->hak, 'd')){
                $nestedData[]   = "<center><a href='".site_url('kategori/hapus/'.$row['id_kategori'])."' id='HapusKategori'><i class='mdi mdi-trash-can-outline'></i> Hapus</a></center>";
            }

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
        if(substr($this->hak->hak, 0, 1) == 'c'){
            if($this->input->post()){
                $judul      = $this->input->post('judul');
                $deskripsi  = $this->input->post('deskripsi');

                $ins        = $this->master->insertKategori($judul, $deskripsi);
                if($ins){
                    $status = 'success';
                    $pesan  = '<font style="color:green;" size="2"><b><i class="mdi mdi-check-outline"></i> Berhasil</b></font>';
                }else{
                    $status = 'error';
                    $pesan  = '<font style="color:red;" size="3"><i>Terjadi Kesalahan pada Query Database. Silahkan Periksa Kembali atau Hubungi <b>Developer</b>.</i></font>';
                }
                echo json_encode(array(
                    'status'    => $status,
                    'pesan'     => $pesan
                ));
            }else{
                $this->load->view('kategori/tambah');
            }
        }else{
            show_404();
        }
    }

    public function edit($id){
        if(substr($this->hak->hak, 0, 1) == 'u' || strpos($this->hak->hak, 'u')){
            if(!empty($id)){
                if($this->input->post()){
                    $judul      = $this->input->post('judul');
                    $deskripsi  = $this->input->post('deskripsi');
    
                    $update = $this->master->updateKategori($id, $judul, $deskripsi);
                    if($update){
                        $status = 'success';
                        $pesan  = '<font style="color:green;" size="2"><b><i class="mdi mdi-check-outline"></i> Berhasil Merubah Data</b></font>';
                    }else{
                        $status = 'error';
                        $pesan  = '<font style="color:red;" size="3"><i>Terjadi Kesalahan pada Query Database. Silahkan Periksa Kembali atau Hubungi <b>Developer</b>.</i></font>';
                    }
                    echo json_encode(array(
                        'status'    => $status,
                        'pesan'     => $pesan
                    ));
                }else{
                    $data['kategori']   = $this->master->editKategori($id)->row();
                    $data['id']         = $id;
                    $this->load->view('kategori/edit', $data);
                }
            }
        }else{
            show_404();
        }
    }

    public function hapus($id){
        if($this->session->userdata('akses') == 1){
            if($this->input->is_ajax_request()){
                $hapus  = $this->master->deleteKategori($id);
    
                if($hapus){
                    $status = "success";
                    $pesan  = '<font style="color:green;" size="2"><b><i class="mdi mdi-check-outline"></i> Berhasil dihapus</b></font>';
                }else{
                    $status = "error";
                    $pesan  = '<font style="color:red;" size="3"><i class="mdi mdi-close-outline"></i> Query ada yang salah, Silahkan hubungi <i><b>Developer</b></i>.</font>';
                }
                echo json_encode(array(
                    'status'    => $status,
                    'pesan'     => $pesan
                ));
            }
        }else{
            show_404();
        }
    }

}