<?php $this->load->view('templates/forum/header'); ?>

<!-- forum -->
<div class="container-fluid forum">
    <div class="row">
        <!-- kiri -->
        <div class="col-md-9">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('forums'); ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo "Forums ".ucfirst($f); ?></li>
                </ol>
            </nav>
            <div class="box-kiri">
                <?php foreach($k AS $row){ ?>
                <div class="group-category">
                    <a href="#" class="fac" id="<?php if($row->jurusan == 'FTI'){echo 'FTI';}elseif($row->jurusan == 'FT'){echo 'FT';}elseif($row->jurusan == 'FIKOM'){echo 'FIKOM';}elseif($row->jurusan == 'FEB'){echo 'FEB';}else{echo 'FISIP';}; ?>">
                        <?php
                        if($row->jurusan == 'FTI'){
                            echo 'Fakultas Teknologi Informasi';
                        }elseif($row->jurusan == 'FEB'){
                            echo 'Fakultas Ekonomi Dan Bisnis';
                        }elseif($row->jurusan == 'FIKOM'){
                            echo 'Fakultas Ilmu Komunikasi';
                        }elseif($row->jurusan == 'FT'){
                            echo 'Fakultas Teknik';
                        }else{
                            echo 'Fakultas Ilmu Sosial Politik';
                        }
                        ?>
                    </a>
                    <div class="group-subcategory" id="<?php if($row->jurusan == 'FTI'){echo 'FTI';}elseif($row->jurusan == 'FT'){echo 'FT';}elseif($row->jurusan == 'FIKOM'){echo 'FIKOM';}elseif($row->jurusan == 'FEB'){echo 'FEB';}else{echo 'FISIP';}; ?>">
                        <div class="row">
                            <?php foreach($kategori AS $data){
                                if($data->jurusan == $row->jurusan){ ?>
                                <div class="col-md-4">
                                    <a href="<?php echo base_url('forums/'.$f.'/'.$data->slug_category); ?>" class="subcategory">
                                        <?= $data->nama_category; ?>
                                    </a>
                                    <p class="description-category">
                                        <?= substr($data->deskripsi, 0, 130)."....."; ?>
                                    </p>
                                </div>
                                <?php }
                             } ?>
                        </div>
                    </div>
                </div>
                <hr>
                <?php } ?>
            </div>
        </div>
        <!-- .// kiri -->
        <?php $this->load->view('templates/forum/sidebar'); ?>
    </div>
</div>
<!-- .//forum -->

<?php $this->load->view('templates/forum/footer'); ?>