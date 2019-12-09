<!-- sidebar -->
<div class="col-md-3">
    <!-- box login -->
    <div class="box-kanan">
        <!-- login -->
        <?php if(!$this->session->userdata('login')){ ?>
        <div class="box-login">
            <h5 class="text-center">Login</h5>
            <?php if($this->session->flashdata('salah')){ ?>
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert" style="font-size:13px;">
                <?= $this->session->flashdata('salah'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-top:-5px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php } ?>
            <div class="login">
                <?= form_open('login'); ?>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                    <input type="password" class="form-control" id="password" name="password" placeholder="********">
                    <button class="btn btn-primary" type="submit">Login</button>
                <?= form_close(); ?>
            </div>
            <hr>
        </div>
        <!-- .//login -->
        <?php }else{ ?>
        <!-- after login -->
        <div class="box-user">
            <h6 class="username text-center">Hi, <b><?= $login['username']; ?></b></h6>
            <div class="text-center">
                <img src="<?= base_url('assets/images/faces/'.$login['foto_user']); ?>" alt="Foto Profile">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <p class="total-post text-center">Total Posting : <?= $login['total']; ?> Post</p>
                </div>
                <div class="col-md-6">
                    <p class="total-likes text-center">Total Likes : <?= $login['likes']; ?> Likes</p>
                </div>
                <div class="col-md-4">
                    <a href="#" class="edit-profile"><i class="mdi mdi-account-circle-outline"></i>
                        Profile</a>
                </div>
                <div class="col-md-4">
                    <a href="#" class="pesan-profile"><i class="mdi mdi-message-text-outline"></i> Pesan</a>
                </div>
                <div class="col-md-4">
                    <a href="<?= base_url('login/logout'); ?>" class="profile-logout"><i class="mdi mdi-logout"></i> Logout</a>
                </div>
            </div>
        </div>
        <!-- .// afterlogin -->
        <?php } ?>
    </div><br>
    <!-- .//box login -->
    
    <!-- tambah -->
    <?php if($this->session->userdata('login') && $this->uri->segment(2) != ''){ ?>
    <div class="box-kanan" id="tambah-kategori">
        <?php if($this->session->userdata('akses') == 'Administrator'){ ?>
            <a href="<?php echo base_url('forums/tambah_category/'.$f); ?>" class="btn btn-info" id="tambahKategori"><i class="mdi mdi-plus"></i> Tambah Kategori</a>
        <?php } 
        if($this->session->userdata('akses') == 'Dekan' || $this->session->userdata('akses') == 'Administrator' || $this->session->userdata('akses') == 'Prodi'){ ?>
            <a href="<?php echo base_url('forums/tambah_subcategory/'.$f); ?>" class="btn btn-primary" id="tambahSubkategori"><i class="mdi mdi-plus"></i> Tambah Subkategori</a>
        <?php } ?>
        <a href="<?php echo base_url('forums/tambah_threads/'.$f); ?>" class="btn btn-success" id="tambahThreads"><i class="mdi mdi-plus"></i> Tulis Topik Baru</a>
    </div>
    <?php } ?>
    <!-- .//tambah -->
</div>
<!-- .// sidebar -->

<script>
    $(document).on('click', '#tambahKategori, #tambahSubkategori', function(e){
        e.preventDefault();

        $('#ModalContent').load($(this).attr('href'));
        $('#ModalGue').modal('show');
    })
</script>