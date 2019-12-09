<?php
$this->load->view('templates/header');
$this->load->view('templates/navbar');
$this->load->view('templates/sidebar');
?>
<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title text-center"><i>Knowledge Management Systems</i></h4>
            <h4 class="card-subtitle text-center">Universitas Budi Luhur</h4>
            <div class="text-center">
                <img src="<?= base_url('assets/images/logo-bl.png'); ?>" alt="Universitas Budi Luhur" width="300" height="300">
            </div>
            <br><br>
            <p class="text-justify">KMS (Knowledge Management System) adalah sistem yang diciptakan untuk memfasilitasi penangkapan, penyimpanan, pencarian, pemindahan dan penggunaan kembali pengetahuan.  Dalam knowledge management system ada dua hal yang diperlukan dalam membangun sistem ini yaitu tacit knowledge dan explisit knowledge, kedua hal tersebut digunakan agar membuat KMS menjadikaya akan pengetahuan dan dapat digunakan oleh lainnya</p><br>
            <div class="text-justify">
                <p>Fitur-fitur yang ada pada Website ini :</p>
                <ul>
                    <li><a href="<?= base_url(); ?>">Home</a></li>
                    <li>
                        Media
                        <ul>
                            <li><a href="<?= base_url('dokumen'); ?>">Dokumen</a></li>
                            <li><a href="<?= base_url('video'); ?>">Video</a></li>
                        </ul>
                    </li>
                    <li><a href="<?= base_url('forum'); ?>">Forum</a></li>
                    <li>
                        Pesan
                        <ul>
                            <li><a href="<?= base_url('pesan/new'); ?>">Tulis Pesan Baru</a></li>
                            <li><a href="<?= base_url('pesan/inbox'); ?>">Pesan Masuk</a></li>
                            <li><a href="<?= base_url('pesan/sent'); ?>">Pesan Keluar</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('templates/footer_1');
$this->load->view('templates/footer_2');
?>