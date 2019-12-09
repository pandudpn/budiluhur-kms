<?php
$this->load->view('templates/header');
$this->load->view('templates/navbar');
$this->load->view('templates/sidebar');
?>
<script>
    $(document).ready(function(){
        $('#kepada').autocomplete({
            source: "<?php echo base_url('pesan/autoComplete'); ?>",
            focus: function(event, ui){
                $('#kepada').val(ui.item.nama);
                return false;
            },
            select: function(event, ui){
                $('#kepada').val(ui.item.nama);
                $('#tujuan').val(ui.item.id);
                return false;
            }
        }).autocomplete("instance")._renderItem = function(ul, item){
            return $("<li>")
                    .append("<div>" + item.nama + " - " + item.email + "</div>")
                    .appendTo(ul);
        };
    });
</script>

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Tulis Pesan Baru</h4>
            <hr>
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="form-group row">
                        <label for="kepada" class="col-form-label col-md-3">Kepada</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="kepada" name="kepada" placeholder="Nama atau Email Tujuan Mengirim Pesan">
                            <div id="cek"></div>
                        </div>
                    </div>
                    <?= form_open_multipart('pesan/new', array('id' => 'pesanBaru')); ?>
                    <div class="form-group row">
                        <label for="subjek" class="col-form-label col-md-3">Subjek</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="subjek" name="subjek" placeholder="Subjek Pesan" required>
                            <input type="text" class="form-control" id="tujuan" name="tujuan">
                            <input type="hidden" class="form-control" id="id_pesan" name="id_pesan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lampiran" class="col-form-label col-md-3">Lampiran</label>
                        <div class="col-md-9">
                            <input type="file" class="form-control-file" name="lampiran" id="lampiran">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="isi" class="col-form-label col-md-3">Isi</label>
                        <div class="col-md-9">
                            <textarea name="isi" id="isi" cols="5" rows="10" class="form-control" placeholder="Isi Pesan"></textarea>
                        </div>
                    </div>
                    <button class="btn btn-info float-right" type="submit" id="kirim"><i class="mdi mdi-send"></i> Kirim</button>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#pesanBaru').submit(function(e){
            e.preventDefault();

            var tujuan = $('#kepada').val();
            var to     = $('#tujuan').val();
            if(tujuan == ''){
                $('#cek').html('<font style="color:red;" size="2">* Tidak boleh kosong</font>');
            }else if(to == ''){
                $('#cek').html('<font style="color:red;" size="2">Tujuan Salah!</font>');
            }else{
                $('#cek').html('');
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function(){
                        $('#kirim').html('<i class="mdi mdi-spin mdi-loading"> Menunggu respon server.....</i>');
                        $('#kirim').addClass('disabled');
                    },
                    success: function(data){
                        setTimeout(function(){
                            if(data.status == 'success'){
                                $('#kirim').html('<i class="mdi mdi-send"></i> Kirim');
                                $('#kirim').removeClass('disabled');
                                $('#ModalHeader').html('<div class="col"><div class="text-center"><i class="mdi mdi-check"></i> Berhasil</div></div>');
                                $('#ModalContent').html(data.pesan);
                                $('#ModalFooter').html('<a href="<?= base_url(); ?>pesan/new" class="btn btn-primary">Ok</a>');
                                $('#ModalGue').modal('show');
                            }
                        }, 2000);
                    },
                    error: function(){
                        setTimeout(function(){
                            $('#kirim').html('<i class="mdi mdi-send"></i> Kirim');
                            $('#kirim').removeClass('disabled');
                            $('#ModalHeader').html('<div class="col"><div class="text-center"><i class="mdi mdi-close"></i> Error</div></div>');
                            $('#ModalContent').html('<font style="color:red;" size="3">Terjadi Kesalahan dalam <i>Side-Server</i> atau Data yang di kirim. Silahkan Periksa Kembali atau Hubungi <i><b>Developer</b></i>.</font>');
                            $('#ModalFooter').html('<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>');
                            $('#ModalGue').modal('show');
                        }, 2000);
                    }
                })
            }
        })
    });

    $(document).ready(function(){
        $.ajax({
            url: "<?= base_url(); ?>pesan/countNewPesan",
            type: 'POST',
            data: {'id_pesan':'id_pesan'},
            success: function(data){
                $('#id_pesan').val(data);
            }
        })
    });
</script>

<?php
$this->load->view('templates/footer_1');
$this->load->view('templates/footer_2');
?>