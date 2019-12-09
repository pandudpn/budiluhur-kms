<?php
$this->load->view('templates/header');
$this->load->view('templates/navbar');
$this->load->view('templates/sidebar');
?>

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Balas Pesan</h4>
            <div class="col-md-6 offset-md-3">
                <div class="form-group row">
                    <label for="nama" class="col-form-label col-md-3">Nama</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" value="<?php echo $pesan->nama; ?>" readonly>
                    </div>
                </div>
                <?php echo form_open_multipart('pesan/balasinbox/'.$id, array('id' => 'formBalasInbox')); ?>
                <div class="form-group row">
                    <label for="subjek" class="col-form-label col-md-3">Subjek</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="subjek" id="subjek" required>
                        <input type="hidden" name="kepada" id="kepada" value="<?php echo $pesan->id_from; ?>">
                        <input type="hidden" class="form-control" id="id_pesan" name="id_pesan">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lampiran" class="col-form-label col-md-3">Lampiran</label>
                    <div class="col-md-9">
                        <input type="file" class="form-control-file" name="lampiran" id="file">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="isi" class="col-form-label col-md-3">Isi</label>
                    <div class="col-md-9">
                        <textarea name="isi" id="isi" cols="5" rows="15" class="form-control"></textarea>
                    </div>
                </div>
                <a href="<?= base_url('pesan/inbox'); ?>" class="btn btn-secondary float-left"><i class="mdi mdi-arrow-left"></i> Back</a>
                <button type="submit" class="btn btn-info float-right" id="SimpanData"><i class="mdi mdi-send"></i> Kirim</button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#formBalasInbox').submit(function(e){
            e.preventDefault();
            var formData = new FormData($(this)[0]);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                contentType: false,
                processData: false,
                data: formData,
                dataType: 'json',
                beforeSend: function(){
                    $('#SimpanData').html('<i class="mdi mdi-loading mdi-spin"> Mengirim Pesan........</i>');
                    $('#SimpanData').addClass('disabled');
                },
                success: function(data){
                    setTimeout(function(){
                        if(data.status == 'success'){
                            $('#SimpanData').html('Simpan Data');
                            $('#SimpanData').removeClass('disabled');
                            $('#ModalHeader').html('Berhasil');
                            $('#ModalContent').html(data.pesan);
                            $('#ModalFooter').html('<a href="<?= base_url(); ?>pesan/inbox" class="btn btn-primary">Ok</a>');
                            $('#ModalGue').modal('show');
                        }else{
                            $('#SimpanData').html('Simpan Data');
                            $('#SimpanData').removeClass('disabled');
                            $('#ModalHeader').html('Error');
                            $('#ModalContent').html(data.pesan);
                            $('#ModalFooter').html('<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>');
                            $('#ModalGue').modal('show');
                        }
                    }, 2000);
                },
                error: function(){
                    setTimeout(function(){
                        $('#SimpanData').html('Simpan Data');
                        $('#SimpanData').removeClass('disabled');
                        $('#ModalHeader').html('Error');
                        $('#ModalContent').html('<font style="color:red;" size="3">Terjadi Kesalahan pada <i>Side-Server</i> atau Data-data yang di kirim. Silahkan Periksa Kembali atau Hubungi <i><b>Developer</b></i>.</font>');
                        $('#ModalFooter').html('<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>');
                        $('#ModalGue').modal('show');
                    }, 2000);
                }
            })
        });
    });

    $(document).ready(function(){
        $.ajax({
            url: "<?= base_url('pesan/countNewPesan'); ?>",
            type: 'POST',
            data: {'id_pesan':'id_pesan'},
            success: function(data){
                $('#id_pesan').val(data);
            }
        })
    })
</script>

<?php
$this->load->view('templates/footer_1');
$this->load->view('templates/footer_2');
?>