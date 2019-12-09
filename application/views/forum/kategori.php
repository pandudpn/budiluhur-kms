<?php $this->load->view('templates/forum/header'); ?>
<!-- forum -->
<div class="container-fluid forum">
    <div class="row">
        <!-- kiri -->
        <div class="col-md-9">
            <p class="title-category"><?php echo $kategori['nama_category']; ?></p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('forums'); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('forums/'.$f); ?>">Forums <?php echo ucfirst($f); ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $kategori['nama_category']; ?></li>
                </ol>
            </nav>
            <?php if($subkategori){ ?>
            <div class="box-kiri">
                <div class="row and">
                    <div class="col-md-7 text-center">
                        <span>Forums</span>
                    </div>
                    <div class="col-md-1 text-center">
                        <span>Thread</span>
                    </div>
                    <div class="col-md-1 text-center">
                        <span>Post</span>
                    </div>
                    <div class="col-md-3 text-center">
                        <span>Last Post</span>
                    </div>
                </div>
                <?php foreach($subkategori AS $row){ ?>
                <div class="row kat">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="<?= base_url('forums/'.$f.'/'.$row['slug_category'].'/'.$row['slug_subcategory']); ?>" class="category-link">
                                    <?php if(strlen($row['nama_subcategory']) > 35){
                                        echo substr($row['nama_subcategory'], 0, 35).".....";
                                    }else{
                                        echo $row['nama_subcategory'];
                                    } ?>
                                </a>
                            </div>
                            <div class="col-md-12">
                                <p class="deskripsi-category">
                                    <?php
                                    if(strlen($row['deskripsi_subcategory']) > 60){
                                        echo substr($row['deskripsi_subcategory'], 0, 60).".....";
                                    }else{
                                        echo $row['deskripsi_subcategory'];
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1 text-center">
                        <p class="total-thread"><?= number_format($row['total_threads'], 0, '.', ','); ?></p>
                    </div>
                    <div class="col-md-1 text-center">
                        <p class="jumlah-post"><?= number_format($row['total_post'], 0, '.', ','); ?></p>
                    </div>
                    <div class="col-md-3">
                        <?php 
                        if($row['ts_threads'] != NULL){ ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="<?= base_url('forums/'.$f.'/'.$row['slug_category'].'/'.$row['slug_subcategory'].'/'.$row['slug_threads']); ?>" class="last-post-link">
                                        <?php if(strlen($row['title_threads']) > 23){
                                            echo substr($row['title_threads'], 0, 23).".....";
                                        }else{
                                            echo $row['title_threads'];
                                        } ?>
                                    </a>
                                </div>
                                <div class="col-md-12">
                                    <p class="thread-by"><b><?= $row['username']; ?></b></p>
                                </div>
                                <div class="col-md-12">
                                    <p class="tanggal-last-post"><?= date('d F Y', strtotime($row['ts_threads'])); ?></p>
                                </div>
                            </div>
                        <?php }else{
                            echo '<h5 style="margin-top: 9%; text-align: center;">Tidak ada topik.</h5>';
                        } ?>
                    </div>
                </div>
                <hr>
                <?php } ?>
            </div>
            <?php }else{ ?>
            <div class="box-kiri">
                <h1 class="text-center text-danger"><i>Tidak ada subkategori pembahasan.</i></h1>
            </div>
            <?php } ?>
        </div>
        <!-- .// kiri -->
        <?php $this->load->view('templates/forum/sidebar'); ?>
    </div>
</div>
<!-- .//forum -->
<?php $this->load->view('templates/forum/footer'); ?>