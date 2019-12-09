<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('m_login', 'login');
    }

    public function index()
    {
        if($this->session->userdata('login')){
			redirect(base_url());
		}else{
			$this->form_validation->set_rules('username', 'Username', 'required|trim');
			$this->form_validation->set_rules('password', 'Password', 'required|trim');
			if($this->form_validation->run() == FALSE){
				$data['judul']	= "Login - Universitas Budi Luhur Knowledge Management Systems";
				$this->load->view('login', $data);
			}else{
				$username = $this->input->post('username');
				$password = sha1(sha1($this->input->post('password')));

				$user = $this->login->validasi_login($username, $password);
				$userrr = $this->login->validasi_login_2($username, $password);
				if($user){
					$this->login->updateLogin($user->id_user);
					$user_data = array(
						'id'		=> $user->id_user,
						'username'	=> $this->input->post('username'),
						'akses'		=> $user->nama_akses,
						'hak'		=> $user->hak,
						'nama'		=> $user->nama,
						'email'		=> $user->email,
						'session_data_user' => $userrr,
						'login'		=> true
					);
					$this->session->set_userdata($user_data);
					if(strtolower($user->nama_akses) == 'dosen'){
						redirect('forums');
					}else{
						redirect(base_url());
					}
				}else{
					$this->session->set_flashdata('salah', 'Username atau Password anda Salah!');
					redirect('login');
				}
			}
		}
    }

    public function logout(){
		$this->login->updateLogout($this->session->userdata('id'));
		$data = array('id','username','login','akses','hak', 'nama', 'email', 'session_data_user');
		$this->session->unset_userdata($data);
		redirect(base_url());
		exit(0);
    }

}