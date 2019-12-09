<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akses extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_login', 'login');
        $this->load->model('m_master', 'master');
        $this->load->model('m_chat', 'chat');
        if(!$this->session->userdata('login')){
            redirect(base_url());
        }
        if(!$this->session->userdata('akses') == 'Administrator'){
            show_404();
        }
    }
    
    public function index()
    {
        $data['login']  = $this->login->getDataLogin();
        $data['judul']  = "Hak Akses";
        $data['session_data_user'] = $this->chat->getOnlineUsers();
        $this->load->view('akses/index', $data);
    }

    public function showAllData(){
        $requestData	= $_REQUEST;
		$fetch			= $this->master->showAllAkses($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

            $nestedData[]	= "<center>".$row['nomor']."</center>";
			$nestedData[]	= "<center><a href='".site_url('akses/edit/'.$row['id_akses'])."' id='EditAkses'>".$row['nama_akses']."</a></center>";
            if(substr($row['hak'], 0, 1) == 'c'){
                $nestedData[]   = "<center style='color:green;'><b>Punya</b></center>";
            }else{
                $nestedData[]   = "<center style='color:red;'><b>Tidak Punya</b></center>";
            }
            if(substr($row['hak'], 0, 1) == 'r' || strpos($row['hak'], 'r')){
                $nestedData[]   = "<center style='color:green;'><b>Punya</b></center>";
            }else{
                $nestedData[]   = "<center style='color:red;'><b>Tidak Punya</b></center>";
            }
            if(substr($row['hak'], 0, 1) == 'u' || strpos($row['hak'], 'u')){
                $nestedData[]   = "<center style='color:green;'><b>Punya</b></center>";
            }else{
                $nestedData[]   = "<center style='color:red;'><b>Tidak Punya</b></center>";
            }
            if(substr($row['hak'], 0, 1) == 'd' || strpos($row['hak'], 'd')){
                $nestedData[]   = "<center style='color:green;'><b>Punya</b></center>";
            }else{
                $nestedData[]   = "<center style='color:red;'><b>Tidak Punya</b></center>";
            }
            $nestedData[]	= "<center><a href='".site_url('akses/hapus/'.$row['id_akses'])."' id='HapusAkses'><i class='mdi mdi-trash-can-outline'></i> Hapus</a></center>";

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
        if($this->input->post()){
            $buat   = $this->input->post('buat');
            $baca   = $this->input->post('baca');
            $ubah   = $this->input->post('ubah');
            $hapus  = $this->input->post('hapus');

            $nama   = $this->input->post('nama');
            $crud   = $buat.$baca.$ubah.$hapus;

            $ins    = $this->master->insertAkses($nama, $crud);
            if($ins){
                $json['status'] = "success";
                $json['pesan']  = "<font style='color:gree;' size='2'><i class='mdi mdi-check-outline'></i> Berhasil</font>";
            }else{
                $json['status'] = "error";
                $json['pesan']  = "<font style='color:red;' size='3'>Terjadi Kesalahan pada <b>Code</b> atau <b>Query</b>. Silahkan Hubungi <i><b>Developer</b></i>.</font>";
            }
            echo json_encode($json);
        }else{
            $this->load->view('akses/tambah');
        }
    }

    public function edit($id){
        if(!empty($id)){
            if($this->input->post()){
                $buat   = $this->input->post('buat');
                $baca   = $this->input->post('baca');
                $ubah   = $this->input->post('ubah');
                $hapus  = $this->input->post('hapus');

                $nama   = $this->input->post('nama');
                $crud   = $buat.$baca.$ubah.$hapus;

                $ins    = $this->master->updateAkses($id, $nama, $crud);
                if($ins){
                    $json['status'] = "success";
                    $json['pesan']  = "<font style='color:gree;' size='2'><i class='mdi mdi-check-outline'></i> Berhasil</font>";
                }else{
                    $json['status'] = "error";
                    $json['pesan']  = "<font style='color:red;' size='3'>Terjadi Kesalahan pada <b>Code</b> atau <b>Query</b>. Silahkan Hubungi <i><b>Developer</b></i>.</font>";
                }
                echo json_encode($json);
            }else{
                $data['id']     = $id;
                $data['akses']  = $this->master->editAkses($id)->row();
                $this->load->view('akses/edit', $data);
            }
        }else{
            redirect(base_url());
        }
    }

    public function hapus($id){
        if($this->input->is_ajax_request()){
            $hapus  = $this->master->hapusAkses($id);

            if($hapus){
                $json['status'] = "success";
                $json['pesan']  = "<font style='color:green;' size='2'><i clas='mdi mdi-check-outline'></i> Berhasil</font>";
            }else{
                $json['status'] = "error";
                $json['pesan']  = "<font style='color:red;' size='2'><i class='mdi mdi-close-outline'></i> Error! Terjadi kesalahan!</font>";
            }
            echo json_encode($json);
        }
    }

    public function cek_nama_akses(){
        $nama   = $this->input->post('nama');

        $cek_nama = $this->master->cek_nama_akses($nama);
        if($cek_nama->num_rows() > 0){
            $status['status']   = 0;
            $status['pesan']    = "<font style='color:red;' size='2'>Nama Akses Sudah tersedia, Gunakan yang lain</font>";
        }else{
            $status['status']   = 1;
            $status['pesan']    = '';
        }
        echo json_encode($status);
    }

}

/* End of file Akses.php */
