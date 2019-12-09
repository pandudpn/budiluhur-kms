<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_login', 'login');
        $this->load->model('m_master', 'master');
        $this->load->model('m_chat', 'chat');
        if(!$this->session->userdata('login')){
            redirect(base_url());
        }
        if($this->session->userdata('akses') != "Administrator"){
            show_404();
        }
    }
    
    public function index()
    {
        $data['login']  = $this->login->getDataLogin();
        $data['session_data_user'] = $this->chat->getOnlineUsers();
        $data['judul']  = "Data User - Universitas Budi Luhur Knowledge Management Systems";
        $this->load->view('user/index', $data);
    }

    public function showAllData(){
        $requestData	= $_REQUEST;
		$fetch			= $this->master->showAllUser($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

            $nestedData[]	= "<center>".$row['nomor']."</center>";
			$nestedData[]	= "<center>".$row['nama']."</center>";
            $nestedData[]	= "<center>".$row['username']."</center>";
            $nestedData[]	= "<center>".$row['nama_akses']."</center>";
            $nestedData[]   = "<center><a href='".site_url('user/edit/'.$row['id_user'])."' id='EditUser'><i class='mdi mdi-pencil-outline'></i> Edit</a> | <a href='".site_url('user/hapus/'.$row['id_user'])."' id='HapusUser'><i class='mdi mdi-trash-can-outline'></i> Hapus</a></center>";

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
            $status                         = '';
            $pesan                          = '';

            $config['upload_path']          = './assets/images/faces';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 1024 * 8;
            $config['encrypt_name']         = TRUE;
            $config['overwrite']            = TRUE;

            $this->load->library('upload', $config);

            if(!$this->upload->do_upload('foto')){
                $status = 'error';
                $pesan  = '<font style="color:red;" size="3">'.$this->upload->display_errors('', '').'</font>';
            }else{
                $nama       = $this->input->post('nama');
                $username   = $this->input->post('username');
                $password   = sha1(sha1($this->input->post('password')));
                $akses      = $this->input->post('akses');
                $email      = $this->input->post('email');
                $foto       = $this->upload->data();

                $ins        = $this->master->insertUser($nama, $username, $password, $akses, $email, $foto['file_name']);
                if($ins){
                    $status = 'success';
                    $pesan  = '<font style="color:green;" size="2"><b><i class="mdi mdi-check-outline"></i> Berhasil</b></font>';
                }else{
                    unlink($foto['full_path']);
                    $status = 'error';
                    $pesan  = '<font style="color:red;" size="3"><i>Terjadi Kesalahan pada Query Database. Silahkan Periksa Kembali atau Hubungi <b>Developer</b>.</i></font>';
                }
                @unlink($_FILES['foto']);
                echo json_encode(array(
                    'status'    => $status,
                    'pesan'     => $pesan
                ));
            }
        }else{
            $data['akses']  = $this->master->getAkses()->result();
            $this->load->view('user/tambah', $data);
        }
    }

    public function edit($id){
        if(!empty($id)){
            if($this->input->post()){
                $nama   = $this->input->post('nama');
                $email  = $this->input->post('email');
                $akses  = $this->input->post('akses');

                $update = $this->master->updateUser($id, $nama, $akses, $email);
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
                $data['user']   = $this->master->editUser($id)->row();
                $data['akses']  = $this->master->getAkses()->result();
                $data['id']     = $id;
                $this->load->view('user/edit', $data);
            }
        }
    }

    public function hapus($id){
        if($this->input->is_ajax_request()){
            $hapus  = $this->master->deleteUser($id);

            if($hapus){
                $status = "success";
                $pesan  = '<font style="color:green;" size="2"><i class="mdi mdi-check-outline"></i> Berhasil dihapus</font>';
            }else{
                $status = "error";
                $pesan  = '<font style="color:red;" size="3"><i class="mdi mdi-close-outline"></i> Query ada yang salah, Silahkan hubungi <i><b>Developer</b></i>.</font>';
            }
            echo json_encode(array(
                'status'    => $status,
                'pesan'     => $pesan
            ));
        }
    }

    public function ajax_cek_username(){
        if($this->input->is_ajax_request()){
            $username   = $this->input->post('username');
            $cek    = $this->master->cek_username($username);

            if($cek->num_rows() > 0){
                $status = 0;
                $pesan  = '<font style="color:red" size="2">* Username sudah digunakan, Silahkan gunakan Username yang lain</font>';
            }else{
                $status = 1;
                $pesan  = '';
            }
            echo json_encode(array(
                'status'    => $status,
                'pesan'     => $pesan
            ));
        }
    }

    public function ajax_cek_email(){
        if($this->input->is_ajax_request()){
            $email   = $this->input->post('email');
            $cek    = $this->master->cek_email($email);

            if($cek->num_rows() > 0){
                $status = 0;
                $pesan  = '<font style="color:red" size="2">* Email sudah digunakan, Silahkan gunakan Email yang lain</font>';
            }else{
                $status = 1;
                $pesan  = '';
            }
            echo json_encode(array(
                'status'    => $status,
                'pesan'     => $pesan
            ));
        }
    }

}