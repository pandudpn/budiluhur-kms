<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesan extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('download');
        $this->load->model('m_login', 'login');
        $this->load->model('m_pesan', 'pesan');
        $this->load->model('m_master', 'master');
        $this->load->model('m_chat', 'chat');
        if(!$this->session->userdata('login')){
            redirect(base_url());
        }
    }

    public function countNewPesan(){
        echo $this->pesan->totalPesan();
    }

    public function new(){
        if($this->input->post()){
            $status                         = '';
            $pesan                          = '';

            $config['upload_path']          = './assets/attachment';
            $config['allowed_types']        = 'pdf|ppt|pptx|doc|docx|xls|xlsx|gif|png|jpg|jpeg';
            $config['encrypt_name']         = TRUE;
            $config['overwrite']            = TRUE;

            $this->load->library('upload', $config);

            if(!$this->upload->do_upload('lampiran')){
                $status = 'error';
                $pesan  = '<font style="color:red;" size="3">'.$this->upload->display_errors('', '').'</font>';
            }

            $to         = $this->input->post('tujuan');

            if($to == $this->session->userdata('id')){
                $status = 'error';
                $pesan  = '<font style="color:red;" size="3">Tidak boleh mengirim pesan ke diri sendiri. Silahkan pilih tujuan email ke orang lain.</font>';
            }else{
                $pesan      = $this->input->post('id_pesan');
                $from       = $this->session->userdata('id');
                $subjek     = $this->input->post('subjek');
                $isi        = $this->input->post('isi');

                $ins        = $this->pesan->kirimPesan($pesan, $from, $to, $subjek, $isi);

                if(!empty($_FILES['lampiran']['name'])){
                    $lampiran   = $this->upload->data();
                    $insert     = $this->pesan->Attachment($pesan, $lampiran['orig_name'], $lampiran['file_name'], $lampiran['raw_name'], $lampiran['file_ext']);
                }else{
                    $lampiran   = '';
                    $insert     = $this->pesan->Attachment($pesan, '', '', '', '');
                }

                if($ins && $insert){
                    $status = "success";
                    $pesan  = '<font style="color:green;" size="3"><i class="mdi mdi-check-outline"></i> Pesan Berhasil di Kirim!</font>';
                }else{
                    $status = "error";
                    $pesan  = '<font style="color:red;" size="3"><i class="mdi mdi-close-outline"> Terjadi Kesalahan pada Code atau Query Database, Silahkan Periksa Kembali atau Hubungi <b>Developer</b>.</i></font>';
                }
            }
            echo json_encode(array(
                'status'    => $status,
                'pesan'     => $pesan
            ));
        }else{
            $data['login']  = $this->login->getDataLogin();
            $data['judul']  = "Tulis Pesan Baru";
            $data['session_data_user'] = $this->chat->getOnlineUsers();
            $this->load->view('pesan/new/index', $data);
        }
    }

    public function autoComplete(){
        $term   = $this->input->get('term');
        if(isset($term)){
            $query  = $this->pesan->cari_nama($term);

            if($query->num_rows() > 0){
                foreach($query->result() AS $row){
                    $data[] = array(
                        'id'    => $row->id_user,
                        'nama'  => $row->nama,
                        'email' => $row->email
                    );
                }
                echo json_encode($data);
            }
        }
    }

    public function inbox(){
        $data['login']  = $this->login->getDataLogin();
        $data['judul']  = "Pesan Masuk - Universitas Budi Luhur Knowledge Management Systems";
        $data['session_data_user'] = $this->chat->getOnlineUsers();
        $this->load->view('pesan/inbox/index', $data);
    }

    public function detailinbox($id){
        $cek_id = $this->pesan->cek_id($id)->row();
        if($cek_id->id_to == $this->session->userdata('id')){
            $data['pesan']  = $this->pesan->getPesanInbox($id)->row();
            $data['p']      = $this->pesan->getPesanInbox($id);
            $this->load->view('pesan/inbox/detail', $data);
        }else{
            show_404();
        }
    }

    public function balasinbox($id){
        $cek_id = $this->pesan->cek_id($id)->row();
        if($cek_id->id_to == $this->session->userdata('id')){
            if($this->input->post()){
                $status                         = '';
            $pesan                          = '';

            $config['upload_path']          = './assets/attachment';
            $config['allowed_types']        = 'pdf|ppt|pptx|doc|docx|xls|xlsx|gif|png|jpg|jpeg';
            $config['encrypt_name']         = TRUE;
            $config['overwrite']            = TRUE;

            $this->load->library('upload', $config);

            if(!$this->upload->do_upload('lampiran')){
                $status = 'error';
                $pesan  = '<font style="color:red;" size="3">'.$this->upload->display_errors('', '').'</font>';
            }
            $pesan      = $this->input->post('id_pesan');
            $from       = $this->session->userdata('id');
            $to         = $this->input->post('kepada');
            $subjek     = $this->input->post('subjek');
            $isi        = $this->input->post('isi');

            $ins        = $this->pesan->kirimPesan($pesan, $from, $to, $subjek, $isi);

            if(!empty($_FILES['lampiran']['name'])){
                $lampiran   = $this->upload->data();
                $insert     = $this->pesan->Attachment($pesan, $lampiran['orig_name'], $lampiran['file_name'], $lampiran['raw_name'], $lampiran['file_ext']);
            }else{
                $lampiran   = '';
                $insert     = $this->pesan->Attachment($pesan, '', '', '', '');
            }

            if($ins && $insert){
                $status = "success";
                $pesan  = '<font style="color:green;" size="3"><i class="mdi mdi-check-outline"></i> Pesan Berhasil di Kirim!</font>';
            }else{
                unlink($lampiran['full_path']);
                $status = "error";
                $pesan  = '<font style="color:red;" size="3"><i class="mdi mdi-close-outline"> Terjadi Kesalahan pada Code atau Query Database, Silahkan Periksa Kembali atau Hubungi <b>Developer</b>.</i></font>';
            }
            echo json_encode(array(
                'status'    => $status,
                'pesan'     => $pesan
            ));
            }else{
                $data['pesan']  = $this->pesan->getPesanInbox($id)->row();
                $data['login']  = $this->login->getDataLogin();
                $data['judul']  = "Reply Message";
                $data['session_data_user'] = $this->chat->getOnlineUsers();
                $data['id']     = $id;
                $this->load->view('pesan/inbox/balas', $data);
            }
        }else{
            show_404();
        }
    }

    public function sent(){
        $data['login']  = $this->login->getDataLogin();
        $data['judul']  = "Pesan Keluar";
        $data['session_data_user'] = $this->chat->getOnlineUsers();
        $this->load->view('pesan/sent/index', $data);
    }

    public function showInbox(){
        $requestData	= $_REQUEST;
		$fetch			= $this->pesan->showAllInbox($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

            $nestedData[]	= "<center>".$row['nama']."</center>";
            if(strlen($row['subject']) > 15){
                $nestedData[]   = "<center><a href='".site_url('pesan/detailinbox/'.$row['id_message'])."' title='".$row['subject']."' class='DetailInbox'>".substr($row['subject'], 0, 15)."</a>";
            }else{
                $nestedData[]   = "<center><a href='".site_url('pesan/detailinbox/'.$row['id_message'])."' class='DetailInbox'>".$row['subject']."</a>";
            }
            if(strlen($row['isi']) > 50){
                $nestedData[]   = "<center><a href='".site_url('pesan/detailinbox/'.$row['id_message'])."' class='DetailInbox' title='".$row['isi']."'>".substr($row['isi'], 0, 50)."</a>";
            }else{
                $nestedData[]   = "<center><a href='".site_url('pesan/detailinbox/'.$row['id_message'])."' class='DetailInbox' title='".$row['isi']."'>".$row['isi']."</a>";
            }
			$nestedData[]	= "<center>".$row['tanggal']."</center>";

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

    public function KotakKeluar(){
        $requestData	= $_REQUEST;
		$fetch			= $this->pesan->showAllOutbox($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
            $nestedData = array();

            $nestedData[]	= "<center>".$row['nama']."</center>";
            if(strlen($row['subject']) > 15){
                $nestedData[]   = "<center><a href='".site_url('pesan/detailoutbox/'.$row['id_message'])."' class='detailOutbox' title='".$row['subject']."'>".substr($row['subject'], 0, 15)."........</a>";
            }else{
                $nestedData[]   = "<center><a href='".site_url('pesan/detailoutbox/'.$row['id_message'])."' class='detailOutbox' title='".$row['subject']."'>".$row['subject']."</a>";
            }
            if(strlen($row['isi']) > 50){
                $nestedData[]   = "<center><a href='".site_url('pesan/detailoutbox/'.$row['id_message'])."' class='detailOutbox' title='".$row['isi']."'>".substr($row['isi'], 0, 50)."........</a>";
            }else{
                $nestedData[]   = "<center><a href='".site_url('pesan/detailoutbox/'.$row['id_message'])."' class='detailOutbox' title='".$row['isi']."'>".$row['isi']."</a>";
            }
			$nestedData[]	= "<center>".$row['tanggal']."</center>";

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

    public function detailoutbox($id){
        $cek_id = $this->pesan->cek_id($id)->row();
        if($cek_id->id_from == $this->session->userdata('id')){
            $data['pesan']  = $this->pesan->getPesanOutbox($id)->row();
            $data['p']      = $this->pesan->getPesanOutbox($id);
            $this->load->view('pesan/sent/detail', $data);
        }else{
            show_404();
        }
    }

    public function attachmentInboxDownload($upload, $pesan, $file){
        $download   = $this->pesan->getAttachmentInbox($upload, $pesan);
        $path       = './assets/attachment/'.$file;
        force_download("$download->file_name", file_get_contents($path),);
    }
    
}

/* End of file Pesan.php */
