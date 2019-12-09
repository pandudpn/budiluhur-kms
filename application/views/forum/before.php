<?php $this->load->view('templates/forum/header'); ?>

<!-- forum -->
<div class="container-fluid forum">
    <div class="row">
        <!-- kiri -->
        <div class="col-md-9">
            <div class="box-kiri">
                <div class="group-category">
                    <a href="#" class="fac" id="FTI">Forums</a>
                    <div class="group-subcategory" id="FTI">
                        <div class="row">
                            <?php if($this->session->userdata('akses') == 'Dosen' || $this->session->userdata('akses') == 'Prodi' || $this->session->userdata('akses') == 'Dekan' || $this->session->userdata('akses') == 'Administrator'){ ?>
                            <div class="col-md-4"  style="height: 30px;">
                                <a href="<?= base_url('forums/dosen'); ?>" class="subcategory">Forum Dosen</a>
                            </div>
                            <?php }
                            if($this->session->userdata('akses') == 'Prodi' || $this->session->userdata('akses') == 'Dekan' || $this->session->userdata('akses') == 'Administrator'){ ?>
                            <div class="col-md-4"  style="height: 30px;">
                                <a href="<?= base_url('forums/prodi'); ?>" class="subcategory">Forum Prodi</a>
                            </div>
                            <?php }
                            if($this->session->userdata('akses') == 'Dekan' || $this->session->userdata('akses') == 'Administrator'){ ?>
                            <div class="col-md-4"  style="height: 30px;">
                                <a href="<?= base_url('forums/dekan'); ?>" class="subcategory">Forum Dekan</a>
                            </div>
                            <?php }
                            if($this->session->userdata('akses') == 'Administrator'){ ?>
                            <div class="col-md-4"  style="height: 30px;">
                                <a href="<?= base_url('forums/direktur'); ?>" class="subcategory">Forum Direktur</a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- .// kiri -->
        <?php $this->load->view('templates/forum/sidebar'); ?>
    </div>
</div>
<!-- .//forum -->

<?php $this->load->view('templates/forum/footer'); ?>