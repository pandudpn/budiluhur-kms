<?php $this->load->view('templates/forum/header'); ?>
<!-- forum -->
<div class="container-fluid forum">
    <div class="row">
        <!-- kiri -->
        <div class="col-md-9">
            <p class="title-category"><?php echo $subkategori['nama_subcategory']; ?></p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('forums'); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('forums/'.$f); ?>">Forums <?= ucfirst($f); ?></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('forums/'.$f.'/'.$subkategori['slug_category']); ?>"><?= $subkategori['nama_category']; ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $subkategori['nama_subcategory']; ?></li>
                </ol>
            </nav>
            <?php if($threads){ ?>
            <div class="box-kiri">
                <div class="row and">
                    <div class="col-md-6 text-center">
                        <span>Threads</span>
                    </div>
                    <div class="col-md-2 text-center">
                        <span>Comments</span>
                    </div>
                    <div class="col-md-4 text-center">
                        <span>Last Post</span>
                    </div>
                </div>

                <!-- looping threads  -->
                <?php foreach($threads AS $row){ ?>
                <div class="row subkat">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="<?= base_url('forums/'.$f.'/'.$row['slug_category'].'/'.$row['slug_subcategory'].'/'.$row['slug_threads']); ?>" class="post-link">
                                    <?php if(strlen($row['title_threads']) > 35){
                                        echo substr($row['title_threads'], 0, 35).".....";
                                    }else{
                                        echo $row['title_threads'];
                                    } ?>
                                </a>
                            </div>
                            <div class="col-md-12">
                                <p class="deskripsi-post">
                                    <?= $row['username']." - "; ?>
                                    <span class="tgl-post">
                                        <?php if(date('d F Y', strtotime($row['ts_threads'])) == date('d F Y')){
                                            echo "Hari Ini, ".date('H:i', strtotime($row['ts_threads']));
                                        }else{
                                            echo date('d F Y', strtotime($row['ts_threads']));
                                        } ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 text-center">
                        <p class="total-comments"><?= number_format($row['total_comments'], 0, '.',','); ?></p>
                    </div>
                    <div class="col-md-4">
                        <?php if($row['ts_comments'] != NULL){ ?>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="<?= base_url('forums/'.$f.'/'.$row['slug_category'].'/'.$row['slug_subcategory'].'/'.$row['slug_threads']); ?>" class="last-post-link">
                                    <?php if(strlen($row['komentar']) > 35){
                                        echo substr($row['komentar'], 0, 35).".....";
                                    }else{
                                        echo $row['komentar'];
                                    } ?>
                                </a>
                            </div>
                            <div class="col-md-12">
                                <p class="post-by tidak-kosong">
                                    <?= $row['user']; ?>
                                </p>
                            </div>
                            <div class="col-md-12">
                                <p class="tanggal-last-post">
                                <?php if(date('d F Y', strtotime($row['ts_comments'])) == date('d F Y')){
                                        echo "Hari Ini, ".date('H:i', strtotime($row['ts_comments']));
                                    }else{
                                        echo date('d F Y', strtotime($row['ts_comments']));
                                    } ?>
                                </p>
                            </div>
                        </div>
                        <?php }else{ ?>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="<?= base_url('forums/'.$f.'/'.$row['slug_category'].'/'.$row['slug_subcategory'].'/'.$row['slug_threads']); ?>" class="last-post-link">
                                    <?php if(strlen($row['title_threads']) > 35){
                                        echo substr($row['title_threads'], 0, 35).".....";
                                    }else{
                                        echo $row['title_threads'];
                                    } ?>
                                </a>
                            </div>
                            <div class="col-md-12">
                                <p class="post-by">
                                    <?= $row['username']; ?>
                                </p>
                            </div>
                            <div class="col-md-12">
                                <p class="tanggal-last-post">
                                    <?php if(date('d F Y', strtotime($row['ts_threads'])) == date('d F Y')){
                                        echo "Hari Ini, ".date('H:i', strtotime($row['ts_threads']));
                                    }else{
                                        echo date('d F Y', strtotime($row['ts_threads']));
                                    } ?>
                                </p>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <hr>
                <?php } ?>
                <!-- .// end looping threads -->

            </div>
            <?php }else{ ?>
            <div class="box-kiri">
                <h1 class="text-center text-danger"><i>Tidak Ada Topik.</i></h1>
            </div>
            <?php } ?>
        </div>
        <!-- .// kiri -->

        <?php $this->load->view('templates/forum/sidebar'); ?>
    </div>
</div>
<!-- .//forum -->
<?php $this->load->view('templates/forum/footer'); ?>