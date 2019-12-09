<?php echo form_open_multipart('video/tambah', array('id' => 'formVideo')); ?>
<div class="form-group row">
    <label for="kategori" class="col-form-label col-md-3">Kategori</label>
    <div class="col-md-9">
        <select name="kategori" id="kategori" class="form-control" autofocus>
            <option value="" selected disabled>-</option>
            <?php foreach($kategori->result() AS $da){ ?>
            <option value="<?php echo $da->id_kategori; ?>"><?php echo $da->title; ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="form-group row">
    <label for="judul" class="col-form-label col-md-3">Judul</label>
    <div class="col-md-9">
        <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul Video">
    </div>
</div>
<div class="form-group row">
    <label for="deskripsi" class="col-form-label col-md-3">Deskripsi</label>
    <div class="col-md-9">
        <textarea name="deskripsi" id="deskripsi" cols="5" rows="10" class="form-control"></textarea>
    </div>
</div>
<div class="form-group row">
    <label for="video" class="col-form-label col-md-3">Video</label>
    <div class="col-md-9">
        <input type="file" class="form-control-file" id="video" name="video" placeholder="Pilih Video" required>
    </div>
</div>
<?php echo form_close(); ?>
<div id="respon"></div>
<script>
    $(document).ready(function(){
        var btn = '<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>';
            btn += '<button type="button" class="btn btn-primary" id="SimpanData">Simpan Data</button>';
        
        $('#ModalFooter').html(btn);

        $('#SimpanData').click(function(e){
            e.preventDefault();
            var formData = new FormData($('#formVideo')[0]);

            $.ajax({
                url: $('#formVideo').attr('action'),
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: function(){
                    $('#SimpanData').html('<i class="mdi mdi-loading mdi-spin"> Menunggu respon server.....</i>');
                    $('#SimpanData').addClass('disabled');
                },
                success: function(data){
                    setTimeout(function(){
                        if(data.status == 'success'){
                            $('#Notifikasi').html(data.pesan);
                            $('#Notifikasi').fadeIn('fast').show().delay(4000).fadeOut('slow');
                            $('#SimpanData').html('Simpan Data');
                            $('#SimpanData').removeClass('disabled');
                            $('#ModalGue').modal('hide');
                            
                        }else{
                            $('#respon').html(data.pesan);
                            $('#respon').fadeIn('fast').show().delay(4000).fadeOut('slow');
                            $('#SimpanData').html('Simpan Data');
                            $('#SimpanData').removeClass('disabled');
                        }
                    }, 3000);
                    setTimeout(function(){
                        window.location.href = '<?php echo base_url(); ?>video';
                    }, 4500);
                },
                error: function(){
                    setTimeout(function(){
                        $('#respon').html('<font style="color:red;" size="3"><i class="mdi mdi-close-outline"> Terjadi Kesalahan pada <i>Side-Server</i> atau Data yang di Upload, Silahkan Periksa Kembali!</i></font>');
                        $('#respon').fadeIn('fast').show().delay(4000).fadeOut('slow');
                        $('#SimpanData').html('Simpan Data');
                        $('#SimpanData').removeClass('disabled');
                    }, 3000);
                }
            });
        });
    });
</script>