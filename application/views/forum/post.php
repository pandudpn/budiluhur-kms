<?php $this->load->view('templates/forum/header'); ?>
<!-- forum -->
<div class="container-fluid forum">
    <div class="row">
        <!-- kiri -->
        <div class="col-md-9">
            <p class="title-category"><?= $threads['title_threads']; ?></p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('forums'); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('forums/'.$f); ?>">Forums <?= ucfirst($f); ?></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('forums/'.$f.'/'.$threads['slug_category']); ?>"><?= $threads['nama_category']; ?></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('forums/'.$f.'/'.$threads['slug_category'].'/'.$threads['slug_subcategory']); ?>"><?= $threads['nama_subcategory']; ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $threads['title_threads']; ?></li>
                </ol>
            </nav>
            <!-- box thread -->
            <div class="box-thread-start">
                <div class="row">
                    <!-- user profile -->
                    <div class="col-md-2 post-kiri">
                        <p class="post-username text-center"><?= $threads['username']; ?></p>
                        <div class="text-center">
                            <img src="<?= base_url('assets/images/faces/'.$threads['foto_user']); ?>" alt="Profile Foto">
                        </div>
                        <p class="user-jabatan<?php if($threads['nama_akses'] == 'Administrator'){echo '-1';}elseif($threads['nama_akses'] == 'Dekan' || $threads['nama_akses'] == 'Prodi'){echo '-2';}else{echo '';} ?>">
                            <?php echo $threads['nama_akses'] ?>
                        </p>
                        <p class="user-joined">
                            <?= date('d F Y', strtotime($threads['ts_user'])); ?>
                        </p>
                        <p class="user-post-total"><?= number_format($threads['total'], 0, '.',','); ?></p>
                    </div>
                    <!-- .//user profile -->

                    <!-- postingan -->
                    <div class="col-md-10 post-kanan">
                        <p class="judul-postingan"><?= $threads['title_threads']; ?></p>
                        <hr>
                        <div class="isi-postingan mb-3">
                            <?= $threads['isi_threads']; ?>
                        </div>
                        <div class="like-postingan">
                            <div class="text-right">
                                <a href="#" class="thumbs-up"><i class="mdi mdi-thumb-up-outline"></i> <?= $threads['likes_threads']; ?></a>
                                <a href="#" class="thumbs-up"><i class="mdi mdi-thumb-down-outline"></i> <?= $threads['dislikes_threads']; ?></a>
                            </div>
                        </div>
                    </div>
                    <!-- .//postingan -->
                </div>
            </div>
            <!-- .//box-thread -->
            <br><br>
            <!-- box-comments -->
            <div class="box-thread-start">
                <?php if($comments){
                    foreach($comments AS $row){ ?>
                    <div class="row">
                        <!-- user profile -->
                        <div class="col-md-2 post-kiri">
                            <p class="post-username text-center"><?= $row['username']; ?></p>
                            <div class="text-center">
                                <img src="<?= base_url('assets/images/faces/'.$row['foto_user']); ?>" alt="Profile Foto">
                            </div>
                            <p class="user-jabatan<?php if($row['nama_akses'] == 'Administrator'){echo '-1';}elseif($row['nama_akses'] == 'Dekan' || $row['nama_akses'] == 'Prodi'){echo '-2';}else{echo '';} ?>">
                                <?= $row['nama_akses']; ?>
                            </p>
                            <p class="user-joined"><?= date('d F Y', strtotime($row['ts_user'])); ?></p>
                            <p class="user-post-total"><?= number_format($row['total'],0, '.',','); ?></p>
                        </div>
                        <!-- .//user profile -->

                        <!-- postingan -->
                        <div class="col-md-10 post-kanan">
                            <br>
                            <div class="isi-postingan mb-3">
                                <?= $row['komentar']; ?>
                            </div>
                            <div class="like-postingan">
                                <div class="text-right">
                                    <a href="#" class="thumbs-up"><i class="mdi mdi-thumb-up-outline"></i> <?= $row['likes_comments']; ?></a>
                                    <a href="#" class="thumbs-up"><i class="mdi mdi-thumb-down-outline"></i> <?= $row['dislikes_comments']; ?></a>
                                </div>
                            </div>
                        </div>
                        <!-- .//postingan -->
                    </div>
                    <hr>
                    <?php }
                }else{
                    echo "<h5 class='text-center'>Tidak ada komentar.</h5>";
                } ?>
            </div><br>
            <!-- .// box-comments -->

            <!-- tulis comments -->
            <?php if($this->session->userdata('login')){ ?>
            <div class="box-thread-start pt-4">
                <div class="row">
                    <div class="col-md-10 offset-md-2 kolom-comment">
                        <?php echo form_open('forums/tambah_comments', array('id' => 'formTambah'));?>
                        <input type="hidden" class="form-control" name="id_threads" value="<?= $threads['id_threads']; ?>">
                        <textarea name="isi" id="isi" cols="10" rows="5" class="form-control" required></textarea>
                        <button class="btn btn-primary float-right" type="submit">Submit Comment</button>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            <?php } ?>
            <!-- .// tulis comments -->
        </div>
        <!-- .// kiri -->
        <?php $this->load->view('templates/forum/sidebar'); ?>
    </div>
</div>
<!-- .//forum -->

<script>
    CKEDITOR.replace('isi');
</script>

<?php $this->load->view('templates/forum/footer'); ?>