<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My404 extends CI_Controller {

    public function index()
    {
        $this->output->set_status_header('404');
        $this->load->view('error404');
    }

}

/* End of file My404.php */
