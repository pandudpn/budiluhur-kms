<?php
$this->load->view('templates/header');
$this->load->view('templates/navbar');
$this->load->view('templates/sidebar');
?>

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Video</h4>
            <div class="row">
                <div class="col-md-3">
                    <?php if(substr($this->session->userdata('hak'), 0, 1) == 'c'){ ?>
                        <a href="<?php echo base_url('video/tambah'); ?>" class="btn btn-info" id="TambahVideo"><i class="mdi mdi-plus"></i> Tambah Video</a>
                    <?php } ?>
                </div>
                <div class="col-md-4">
                    <div id="Notifikasi" style="display:none;"></div>
                </div>
                <div class="col-md-5">
                    <div class="form-group row">
                        <label for="search" class="col-form-label col-md-4"><i class="mdi mdi-file-search-outline"></i> Pencarian</label>
                        <div class="col-md-8">
                            <input type="text" onkeyup="myFunction()" class="form-control" id="search" name="search" placeholder="Pencarian Video">
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="row" id="hasilVideo">
                        <?php foreach($video->result() AS $data){ ?>
                        <div class="col-md-4 text-center li">
                            <a href="<?php echo base_url('assets/video/'.$data->file_download); ?>" data-toggle="lightbox" data-gallery="video" data-width="700" data-height="380" data-footer="<?php echo $data->description; ?>" title="<?php echo $data->description; ?>" data-title="<?= $data->judul; ?>" class="col-sm-4">
                                <img src="<?php echo base_url('assets/video/thumbnail/'.$data->thumbnail); ?>" alt="<?php echo $data->judul; ?>" class="img-fluid">
                            </a>
                            <p style="margin-top:10px;"><?php echo $data->judul; ?></p>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '#TambahVideo', function(e){
        e.preventDefault();

        $('#ModalHeader').html('Tambah Video');
        $('#ModalContent').load($(this).attr('href'));
        $('#ModalGue').modal('show');
    })
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });

    function myFunction() {
        // Declare variables
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById('search');
        filter = input.value.toUpperCase();
        ul = document.getElementById("hasilVideo");
        li = ul.getElementsByTagName('div');

        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("p")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
            } else {
            li[i].style.display = "none";
            }
        }
    }
</script>

<?php
$this->load->view('templates/footer_1');
$this->load->view('templates/footer_2');
?>