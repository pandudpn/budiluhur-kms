<?php $this->load->view('templates/forum/header'); ?>
<!-- forum -->
<div class="container-fluid forum">
    <div class="row">
        <!-- kiri -->
        <div class="col-md-9">
            <p class="title-category">Topik Baru</p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('forums'); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('forums/'.$f); ?>">Forums <?= ucfirst($f); ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Topik Baru</li>
                </ol>
            </nav>

            <!-- tulis comments -->
            <div class="box-thread-start">
                <?php echo form_open('forums/tambah_threads/'.$f, array('id' => 'formTambah')); ?>
                <div class="form-group row pt-5">
                    <label for="subcategory" class="col-form-label col-md-3 pl-5">Sub Kategori</label>
                    <div class="col-md-9 pr-5">
                        <select name="subcategory" id="subcategory" class="form-control" required>
                            <option value="" selected disabled>--- PILIH SUB KATEGORI ---</option>
                            <?php foreach($subkategori AS $row){ ?>
                            <option value="<?= $row->id_forsubkat; ?>"><?= $row->jurusan." - ".$row->nama_subcategory; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="title" class="col-form-label col-md-3 pl-5">Judul</label>
                    <div class="col-md-9 pr-5">
                        <input type="text" class="form-control" id="title" name="title" placeholder="Judul Baru" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="isi" class="col-form-label col-md-3 pl-5">Isi Topik</label>
                    <div class="col-md-9 pr-5">
                        <textarea name="isi" id="isi" cols="5" rows="10" placeholder="Isi Pembahasan" required></textarea>
                    </div>
                </div>
                <div class="text-right">
                    <button class="btn btn-primary mb-3 mr-5" style="width: 100px" id="Yes" type="submit">Submit</button>
                </div>
                <?php echo form_close(); ?>
            </div>
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