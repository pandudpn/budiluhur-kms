<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('m_login', 'login');
        $this->load->model('m_chat', 'chat');
    }

    public function index()
    {
        $data['login']  = $this->login->getDataLogin();
        $data['judul']  = "Universitas Budi Luhur Knowledge Management Systems";
        $data['session_data_user'] = $this->chat->getOnlineUsers();
        $this->load->view('home', $data);
    }

}